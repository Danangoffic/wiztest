<?php

namespace App\Controllers\backoffice;

use App\Models\InstansiModel;
use App\Models\KotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\TestModel;
use App\Controllers\BaseController;
use App\Models\CustomerHomeServiceModel;
use App\Models\CustomerModel;
use App\Models\PembayaranModel;
use Dompdf\Cpdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Home_service extends BaseController
{
    public $session;
    protected $kotaModel;
    protected $marketingModel;
    protected $customer_model;
    protected $jenis_layanan_test_model;
    protected $layanan_model;
    protected $test_model;
    protected $pembayaran_model;
    protected $instansiModel;
    protected $customer_home_service_model;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->kotaModel = new KotaModel();
        $this->marketingModel = new MarketingModel();
        $this->instansiModel = new InstansiModel();
        $this->customer_model = new CustomerModel();
        $this->jenis_layanan_test_model = new LayananTestModel();
        $this->layanan_model = new LayananModel();
        $this->test_model = new TestModel();
        $this->pembayaran_model = new PembayaranModel();
        $this->customer_home_service_model = new CustomerHomeServiceModel();
    }
    public function index()
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/backoffice');


        $page = "home_service";
        $customers_home_service = $this->customer_home_service_model->findAll();
        $data = array(
            'title' => "Data Home Service",
            'page' => $page,
            'session' => session(),
            'customers_home_service' => $customers_home_service,
            'customer_model' => $this->customer_model,
            'marketingModel' => $this->marketingModel,
            'instansiModel' => $this->instansiModel
        );
        return view('backoffice/' . $page . '/index_' . $page, $data);
    }

    public function detail(int $id_customer_hs)
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/backoffice');
        $page = "home_service";
        $customers_home_service = $this->customer_home_service_model->find($id_customer_hs);
        $data = array(
            'title' => "Detail Data Home Service",
            'page' => $page,
            'session' => session(),
            'customers_home_service' => $customers_home_service,
            'customer_model' => $this->customer_model->where(['id_hs' => $id_customer_hs])->get()->getResultArray(),
            'marketingModel' => $this->marketingModel,
            'instansiModel' => $this->instansiModel,
            'pembayaran_model' => $this->pembayaran_model
        );
        return view('backoffice/' . $page . '/detail_' . $page, $data);
    }

    public function delete(int $id_customer_hs)
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/backoffice');

        $check_hs = $this->customer_home_service_model->find($id_customer_hs);
        if ($check_hs) {
        }
    }
}
