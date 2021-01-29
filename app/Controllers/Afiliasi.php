<?php

namespace App\Controllers;

use App\Controllers\backoffice\Layanan;
use App\Controllers\backoffice\SystemParameter;
use App\Models\AfiliasiModel;
use App\Models\AlatModel;
use App\Models\CustomerModel;
use App\Models\DokterModel;
use App\Models\HasilLaboratoriumModel;
use App\Models\InstansiModel;
use App\Models\KuotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PembayaranModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\SampleModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\RESTful\ResourceController;

class Afiliasi extends ResourceController
{
    protected $systemparam;
    protected $layananModel;
    protected $pemeriksaanModel;
    protected $testModel;
    protected $layananTestModel;
    protected $customerModel;
    protected $kuotaModel;
    protected $PembayaranModel;
    protected $status_model;
    protected $marketing_model;
    protected $hasil_test;
    protected $dokter_model;
    protected $alat_model;
    protected $sample_model;
    protected $petugas_model;
    protected $layanan_controller;
    protected $afiliasi_model;
    protected $page;
    protected $instansi_model;
    protected $session;

    public function __construct()
    {
        $this->systemparam = new SystemParameter;
        $this->layananModel = new LayananModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->customerModel = new CustomerModel();
        $this->kuotaModel = new KuotaModel();
        $this->PembayaranModel = new PembayaranModel();
        $this->status_model = new StatusHasilModel();
        $this->marketing_model = new MarketingModel();
        $this->hasil_test = new HasilLaboratoriumModel();
        $this->dokter_model = new DokterModel();
        $this->alat_model = new AlatModel();
        $this->sample_model = new SampleModel();
        $this->petugas_model = new PemeriksaModel();
        $this->layanan_controller = new Layanan;
        $this->afiliasi_model = new AfiliasiModel();
        $this->instansi_model = new InstansiModel();
        $this->page = "afiliasi";
        $this->session = \Config\Services::session();
    }


    public function corporate($id_instansi = null)
    {
        if ($id_instansi == null) {
            return redirect()->to("/");
        }
        $data_instansi = $this->instansi_model->find($id_instansi);
        if ($data_instansi == null) {
            $this->session->setFlashdata('error', "Corporate tidak ditemukan");
            return redirect()->to("/");
        }
        $is_afiliated = $data_instansi['afiliated'];
        if ($is_afiliated == "no") {
            $this->session->setFlashdata('error', "Corporate tidak ditemukan dalam afiliasi, untuk dapatkan afiliasi, anda bisa kontak pada marketing kami");
            return redirect()->to("/");
        }
        $id_marketing = $data_instansi['pic_marketing'];
        $data_marketing = $data_marketing = $this->marketing_model->find($id_marketing);

        $layanan_test_data = $this->layananTestModel
            ->where(['id_pemeriksaan' => '1', 'id_segmen' => '2'])->groupBy('id_test')->get()->getResultArray();
        // $getData = $this->sysParamModel->getByVgroupAndParamter('MIDTRANS_KEY', 'CLIENT_KEY');
        $data = [
            'title' => "Quicktest.id || Pendaftaran Test Afiliasi Corporate " . $data_instansi['nama'],
            'subtitle1' => ucwords("form pendaftaran test"),
            'marketings' => $data_marketing,
            'jenis_test' => $this->testModel,
            'layanan_test_data' => $layanan_test_data
        ];
        return view('customer/corporate', $data);
    }

    public function home_service($id_marketing = null)
    {
        if ($id_marketing == null) {
            return redirect()->to("/");
        }

        $validasi_marketing = $this->marketing_model->find($id_marketing);
        if ($validasi_marketing !== null) {
            $is_afiliated = $validasi_marketing['is_afiliated_hs'];
            if ($is_afiliated == "no") {
                $this->session->setFlashdata('error', 'Link afiliasi yang anda gunakan belum tersedia');
                return redirect()->to("/");
            }
            $data_marketing = $data_marketing = $this->marketing_model->find($id_marketing);

            $layanan_test_data = $this->layananTestModel
                ->where(['id_pemeriksaan' => '1', 'id_segmen' => '2'])->groupBy('id_test')->get()->getResultArray();
            // $getData = $this->sysParamModel->getByVgroupAndParamter('MIDTRANS_KEY', 'CLIENT_KEY');
            $data = [
                'title' => "Quicktest.id || Pendaftaran Afiliasi Home Service Melalui " . $data_marketing['nama'],
                'subtitle1' => ucwords("form pendaftaran test"),
                'marketings' => $data_marketing,
                'jenis_test' => $this->testModel,
                'layanan_test_data' => $layanan_test_data
            ];
            return view('customer/home_service', $data);
        }
    }
}
