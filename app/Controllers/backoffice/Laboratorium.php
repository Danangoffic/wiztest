<?php

namespace App\Controllers\backoffice;

use App\Controllers\Customer;
use App\Models\AlatModel;
use App\Models\CustomerModel;
use App\Models\DokterModel;
use App\Models\HasilLaboratoriumModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\SampleModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\RESTful\ResourceController;
// use Dompdf\Cpdf;
use Dompdf\Dompdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Laboratorium extends ResourceController
{
    public $session;
    public $codeBarCode;
    public $dompdf;
    public $pdf;
    protected $customer;
    public $laboratoriumModel;
    protected $customerC;
    protected $sampleModel;
    protected $dokterModel;
    protected $petugasModel;
    protected $statusHasilModel;
    protected $alatModel;
    protected $layananTestModel;
    protected $testModel;
    protected $layananModel;
    protected $pemeriksaanModel;

    public function __construct()
    {
        $this->codeBarCode = "code128";;
        $this->session = session();
        $this->dompdf = new Dompdf();
        $this->customer = new CustomerModel();
        $this->laboratoriumModel = new HasilLaboratoriumModel();
        $this->customerC = new Customer;
        $this->sampleModel = new SampleModel();
        $this->dokterModel = new DokterModel();
        $this->petugasModel = new PemeriksaModel();
        $this->statusHasilModel = new StatusHasilModel();
        $this->alatModel = new AlatModel();
        $this->layananTestModel = new LayananTestModel();
        $this->testModel = new TestModel();
        $this->layananModel = new LayananModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        // $this->sampleModel;
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        // dd($this->session->get('nama'));
        return view('backoffice/layanan/index');
    }

    public function hasil()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = [
            'page' => 'laboratorium',
            'title' => 'Hasil Laboratorium',
            'session' => session()
            // 'data' => $this->get_data_laboratorium()
        ];
        // dd($this->session->get('nama'));
        return view('backoffice/laboratorium/index_laboratorium', $data);
    }

    public function get_data_laboratorium()
    {
        try {
            $data_laboratorium = $this->laboratoriumModel->findAll();
            if (count($data_laboratorium) == 0) {
                return $this->failNotFound('Not found');
            }
            $result = array();
            foreach ($data_laboratorium as $key => $value) {
                $detailCustomer = $this->customer->find($value['id_customer']);
                $detailLayananTest = $this->layananTestModel->find($detailCustomer['jenis_test']);
                $detailTest = $this->testModel->find($detailLayananTest['id_test']);
                $detailLayanan = $this->layananModel->find($detailLayananTest['id_layanan']);
                $detailSample = $this->sampleModel->find($value['id_sample']);
                $statusCov = '';
                $statusGene = '';
                $statusOrf = '';
                $statusIgg = '';
                $statusIgm = '';
                $statusKirim = '';
                if ($value['status_cov'] !== "") {
                    $detailHasilCov = $this->statusHasilModel->find($value['status_cov']);
                    $statusCov = $detailHasilCov['nama_status'];
                }
                if ($value['status_gene'] !== "") {
                    $detailHasilGene = $this->statusHasilModel->find($value['status_gene']);
                    $statusGene = $detailHasilGene['nama_status'];
                }
                if ($value['status_orf'] !== "") {
                    $detailHasilOrf = $this->statusHasilModel->find($value['status_orf']);
                    $statusOrf = $detailHasilOrf['nama_status'];
                }
                if ($value['status_igg'] !== "") {
                    $detailHasilIgg = $this->statusHasilModel->find($value['status_igg']);
                    $statusIgg = $detailHasilIgg['nama_status'];
                }
                if ($value['status_igm'] !== "") {
                    $detailHasilIgm = $this->statusHasilModel->find($value['status_igm']);
                    $statusIgm = $detailHasilIgm['nama_status'];
                }
                if ($value['status_kirim'] !== "") {
                    $detailHasilKirim = $this->statusHasilModel->find($value['status_kirim']);
                    $statusKirim = $detailHasilKirim['nama_status'];
                }
                $ic = $value['detail_ic'];
                $catatan = $value['catatan'];
                $paket_pemeriksaan = $detailTest['nama_test'] . "(" . $detailLayanan['nama_layanan'] . ")";
                $nama_sample = $detailSample['nama_sample'];
                $result[] = array(
                    'id_customer' => $value['id_customer'],
                    'id_hasil' => $value['id'],
                    'tgl_kunjungan' => $detailCustomer['tgl_kunjungan'],
                    'registrasi' => $detailCustomer['customer_unique'] . ' - ' . substr($detailCustomer['created_at'], 0, 10),
                    'paket_pemeriksaan' => $paket_pemeriksaan,
                    'nama_customer' => $detailCustomer['nama'],
                    'nik' => $detailCustomer['nik'],
                    'waktu_sampling' => substr($value['waktu_ambil_sampling'], 0, 10),
                    'waktu_periksa' => substr($value['waktu_periksa_sampling'], 0, 10),
                    'waktu_selesa_periksa' => substr($value['waktu_selesai_periksa'], 0, 10),
                    'status_cov' => $statusCov,
                    'status_gene' => $statusGene,
                    'status_orf' => $statusOrf,
                    'status_igg' => $statusIgg,
                    'status_igm' => $statusIgm,
                    'ic' => $ic,
                    'nama_sample' => $nama_sample,
                    'catatan' => $catatan,
                    'status_kirim' => $statusKirim
                );
            }
            return $this->respond(array('data' => $result), 200, 'success');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }
}
