<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\KuotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PemeriksaanModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\Controller;
// use App\Controllers;
// use CodeIgniter\Controller;

class Frontoffice extends Controller
{
    public $session;
    protected $customerModel;
    protected $pemeriksaanModel;
    protected $kuotaModal;
    protected $instansi;
    protected $marketing;
    protected $layananTestModel;
    protected $layananModel;
    protected $testModel;
    protected $statusModel;
    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->kuotaModal = new KuotaModel();
        $this->session = session();
        $this->instansi = new Instansi;
        $this->marketing = new MarketingModel();
        $this->layananTestModel = new LayananTestModel();
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->statusModel = new StatusHasilModel();
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }

        // dd($this->session->get('nama'));
        return view('backoffice/dashboard/index');
    }

    public function walk_in()
    {
        $filter = ($this->request->getVar('filtering')) ? $this->request->getVar('filtering') : '';
        $Customer = array();
        if ($filter == "on") {
            $date1 = ($this->request->getVar('date1')) ? $this->request->getVar('date1') : '';
            $date2 = ($this->request->getVar('date2')) ? $this->request->getVar('date2') : '';
            $instansi = ($this->request->getVar('instansi')) ? $this->request->getVar('instansi') : '';
            $marketing = ($this->request->getVar('marketing')) ? $this->request->getVar('marketing') : '';
            $layanan_test = ($this->request->getVar('layanan_test')) ? $this->request->getVar('layanan_test') : '';
            $queryFilter = 'SELECT * FROM customers';
            $queryFilter .= " WHERE jenis_layanan = '1'";

            if ($date1 !== '' && $date2 !== '') {
                $queryFilter .= " AND tgl_kunjungan BETWEEN '" . $date1 . "' AND '" . $date2 . "'";
            } elseif ($date1 !== '') {
                $queryFilter .= " AND tgl_kunjungan = '" . $date1 . "'";
            } elseif ($date2 !== '') {
                $queryFilter .= " AND tgl_kunjungan BETWEEN '" . date('Y-m-d') . "' AND '" . $date2 . "'";
            }
            if ($instansi !== '') {
                $queryFilter .= " AND instansi = '$instansi'";
            }
            if ($marketing !== '') {
                $queryFilter .= " AND id_marketing = '$marketing'";
            }
            if ($layanan_test !== '') {
                $queryFilter .= " AND jenis_test = '$layanan_test'";
            }
            $queryFilter .= " ORDER BY id DESC";
            $Customer = db_connect()->query($queryFilter)->getResultArray();
        } else {
            $Customer = db_connect()->table('customers')->select()->orderBy('id', 'DESC')->get()->getResultArray();
        }
        // $Customer = $this->customerModel->detailRegistrasi(false, $id_jenis_pemeriksaan)->getResultArray();
        $data = array(
            'title' => "Walk-In",
            'page' => "walk_in",
            'data_customer' => $Customer,
            'instansi' => $this->instansi->instansiModel->findAll(),
            'instansiModel' => $this->instansi->instansiModel,
            'marketing' => $this->marketing->findAll(),
            'marketingModel' => $this->marketing,
            'layananTest' => $this->layananTestModel->findAll(),
            'layananModel' => $this->layananModel,
            'instansiModel' => $this->instansi->instansiModel,
            'testModel' => $this->testModel,
            'layananTestModel' => $this->layananTestModel,
            'session' => session(),
            'status_model' => $this->statusModel
        );
        return view('backoffice/frontoffice/walk_in', $data);
    }

    public function antrian_swab_walk_in()
    {
        $filterDate = ($this->request->getVar('filterDate')) ? $this->request->getPost('filterDate') : date('Y-m-d');
        $kuotaSwabSameDay = $this->customerModel->findCustomerCounter('1', $filterDate)->getFirstRow();
        $kuotaSwabBasic =  $this->customerModel->findCustomerCounter('2', $filterDate)->getFirstRow();
        $data = array(
            'title' => "Antrian Swab Walk-In",
            'page' => "antrian_swab_walk_in",
            'kuotaSwabSameDay' => $kuotaSwabSameDay,
            'kuotaSwabBasic' => $kuotaSwabBasic,
            'session' => session(),
            'filterDate' => $filterDate
        );
        return view('backoffice/frontoffice/antrian', $data);
    }

    public function antrian_rapid_antigen()
    {
        $filterDate = ($this->request->getVar('filterDate')) ? $this->request->getPost('filterDate') : date('Y-m-d');
        $kuotaSwabSameDay = $this->kuotaModal->findV2('3')->getResultArray();
        $kuotaSwabBasic = $this->kuotaModal->findV2('4')->getResultArray();
        $data = array(
            'title' => "Antrian Rapid Walk-In",
            'page' => "antrian_rapid_antigen",
            'kuotaSwabSameDay' => $kuotaSwabSameDay,
            'kuotaSwabBasic' => $kuotaSwabBasic,
            'session' => session(),
            'filterDate' => $filterDate
        );
        return view('backoffice/frontoffice/antrian_rapid_antigen', $data);
    }

    public function detail_antrian($segment, $tanggal, $jam, $id_jenis_test)
    {
        switch ($segment) {
            case 'antrian':
                # code...
                $id_jenis_test = 1;
                break;
            case 'antrianbasic':
                $id_jenis_test = 2;
                break;
            case 'antrianrapid':
                $id_jenis_test = 3;
                break;
            case 'antrianantigen':
                $id_jenis_test = 4;
                break;
            default:
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman yang anda cari, tidak tersedia');
                break;
        }
        $kuotaSwabSameDay = $this->kuotaModal->findV2('3')->getResultArray();
        $kuotaSwabBasic = $this->kuotaModal->findV2('4')->getResultArray();
        $data = array(
            'title' => "Antrian Rapid Walk-In",
            'page' => "antrian_rapid_antigen",
            'kuotaSwabSameDay' => $kuotaSwabSameDay,
            'kuotaSwabBasic' => $kuotaSwabBasic,
            'session' => session()
        );
        return view('backoffice/frontoffice/antrian_rapid_antigen', $data);
    }

    //--------------------------------------------------------------------

}
