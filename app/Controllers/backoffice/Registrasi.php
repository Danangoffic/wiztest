<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Controllers\backofficeMidtrans;
use App\Controllers\BaseController;
use App\Models\InstansiModel;
use App\Models\KotaModel;
use App\Models\MarketingModel;

// use App\Controllers;
// use CodeIgniter\Controller;

class Registrasi extends BaseController
{
    public $session;
    protected $customerModel;
    protected $instansiModel;
    protected $marketingModel;
    protected $kotaModel;
    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->instansiModel = new InstansiModel();
        $this->marketingModel = new MarketingModel();
        $this->kotaModel = new KotaModel();
        $this->session = \Config\Services::session();
    }
    // public function index()
    // {
    //     // session_destroy();
    //     if (!$this->session->has('logged_in')) {
    //         return redirect()->to('/backoffice/login');
    //     }

    //     // dd($this->session->get('nama'));
    //     return view('backoffice/dashboard/index');
    // }

    // public function registrasi()
    // {
    //     $Customer = $this->customerModel->detailRegistrasi()->getResultArray();
    //     $data = array(
    //         'title' => "Registrasi",
    //         'page' => "registrasi",
    //         'data_customer' => $Customer,
    //         'session' => session()
    //     );
    //     return view('backoffice/registrasi/index', $data);
    // }

    public function detail_peserta($id)
    {
        $Midtrans = new Midtrans();
        $Customer = $this->customerModel->detailRegistrasi($id)->getFirstRow();
        $orderId = $Customer->customer_unique;
        // dd($Customer);
        // echo $orderId;
        // exit();
        $DetailPayment = $Midtrans->getStatusByOrderId($orderId);
        // dd($DetailPayment);

        $data = array(
            'title' => "Registrasi",
            'page' => "registrasi",
            'data_customer' => $Customer,
            'session' => session(),
            'id' => $id,
            'detail_payment' => $DetailPayment
        );
        return view('backoffice/peserta/detail_peserta', $data);
    }

    public function create()
    {
        $data = array(
            'title' => "Tambah Customer",
            'page' => "registrasi",
            'session' => session(),
        );
        return view('backoffice/peserta/create_peserta', $data);
    }

    public function save()
    {
        # code...
    }

    public function edit($id_customer)
    {
        $data = array(
            'title' => "Tambah Customer",
            'page' => "registrasi",
            'session' => session(),
        );
        return view('backoffice/peserta/edit_peserta', $data);
    }

    public function update()
    {
        # code...
    }

    public function delete($id_customer)
    {
        $data = array(
            'title' => "Tambah Customer",
            'page' => "registrasi",
            'session' => session(),
        );
        return view('backoffice/peserta/delete_peserta', $data);
    }

    public function doDelete()
    {
        # code...
    }

    public function instansi()
    {
        $InstansiModel = new InstansiModel();
        $DataInstansi = $InstansiModel->findAll();
        $data = array(
            'title' => "Data Instansi",
            'page' => "instansi",
            'session' => session(),
            'data' => $DataInstansi
        );
        return view('backoffice/instansi/index_instansi', $data);
    }



    public function registrasi_overkuota()
    {
        $data = array(
            'title' => "Tambah Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/registrasi/create_customer_overkuota', $data);
    }

    public function save_customer_overkuota()
    {
        # code...
    }



    //--------------------------------------------------------------------

}
