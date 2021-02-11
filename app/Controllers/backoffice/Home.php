<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\InstansiModel;
use App\Models\KehadiranModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PemeriksaanModel;
use App\Models\SegmenModel;
use App\Models\TestModel;
use App\Controllers\BaseController;
// use App\Controllers;
// use CodeIgniter\Controller;

class Home extends BaseController
{
    protected $session;
    protected $kehadiranModel;
    protected $layananModel;
    protected $pemeriksaanModel;
    protected $customersModel;
    protected $LayananTestModel;
    protected $segmenModel;
    protected $marketingModel;
    protected $instansiModel;
    protected $jenisTestModel;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->kehadiranModel = new KehadiranModel();
        $this->layananModel = new LayananModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->customersModel = new CustomerModel();
        $this->LayananTestModel = new LayananTestModel();
        $this->segmenModel = new SegmenModel();
        $this->marketingModel = new MarketingModel();
        $this->instansiModel = new InstansiModel();
        $this->jenisTestModel = new TestModel();
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $date_now = date('Y-m-d');
        $date1 = ($this->request->getPost('date1')) ? $this->request->getPost('date1') : $date_now;
        $date2 = ($this->request->getPost('date2')) ? $this->request->getPost('date2') : $date_now;
        $JenisLayanan = $this->layananModel->findAll();
        $JenisPemeriksaan = $this->pemeriksaanModel->whereInSelection('nama_pemeriksaan', ['WALK IN', 'HOME SERVICE'])->getResultArray();
        // echo db_connect()->showLastQuery();
        // exit();
        // $data_customers_walkin_sameday_with_filtering = $this->customersModel->customer_jenis_test_filtering_date_between("count(*) as total_walkin_sameday_swab", '1', $date1, $date2);
        // $data_customers_walkin_basic_with_filtering = $this->customersModel->customer_jenis_test_filtering_date_between("count(*) as total_walkin_basic_swab", '2', $date1, $date2);
        // $data_customers_homeservice_basic_with_filtering = $this->customersModel->customer_jenis_test_filtering_date_between("count(*) as total_walkin_basic_swab", '2', $date1, $date2);
        // $data_aps_

        // dd($this->session->get('nama'));
        $data = [
            'date1' => $date1,
            'date2' => $date2,
            'session' => $this->session,
            'title' => 'Dashboard',
            'page' => 'dashboard', 'date_now' => $date_now,
            'jenis_layanan' => $JenisLayanan,
            'jenis_pemeriksaan' => $JenisPemeriksaan,
            'kehadiran_model' => $this->kehadiranModel,
            'customers_model' => $this->customersModel,
            'LayananTestModel' => $this->LayananTestModel,
            'segmen_model' => $this->segmenModel,
            'marketing_model' => $this->marketingModel->orderBy('nama_marketing', 'ASC')->get()->getResultArray(),
            'instansi_model' => $this->instansiModel->findAll(),
            'jenis_test_model' => $this->jenisTestModel->findAll()
        ];
        return view('backoffice/dashboard/index', $data);
    }


    public function filtering()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $date1 = $this->request->getPost('date1');
        $date2 = $this->request->getPost('date2');

        // dd($this->session->get('nama'));
        return view('backoffice/dashboard/index', ['session' => $this->session, 'title' => 'Dashboard']);
    }
    //--------------------------------------------------------------------

}
