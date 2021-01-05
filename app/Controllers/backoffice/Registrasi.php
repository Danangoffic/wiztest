<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use CodeIgniter\Controller;
use App\Controllers\backofficeMidtrans;

// use App\Controllers;
// use CodeIgniter\Controller;

class Registrasi extends Controller
{
    public $session;
    protected $customerModel;
    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->session = session();
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

    public function registrasi()
    {
        $Customer = $this->customerModel->detailRegistrasi()->getResultArray();
        $data = array(
            'title' => "Registrasi",
            'page' => "registrasi",
            'data_customer' => $Customer,
            'session' => session()
        );
        return view('backoffice/registrasi/index', $data);
    }

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
        return view('backoffice/registrasi/detail_peserta', $data);
    }

    public function create()
    {
        $data = array(
            'title' => "Tambah Customer",
            'page' => "registrasi",
            'session' => session(),
        );
        return view('backoffice/registrasi/create', $data);
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
        return view('backoffice/registrasi/edit', $data);
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
        return view('backoffice/registrasi/delete', $data);
    }

    public function doDelete()
    {
        # code...
    }

    public function instansi()
    {
        $data = array(
            'title' => "Data Instansi",
            'page' => "instansi",
            'session' => session(),
        );
        return view('backoffice/registrasi/index_instansi', $data);
    }

    public function create_instansi()
    {
        $data = array(
            'title' => "Tambah Instansi",
            'page' => "instansi",
            'session' => session(),
        );
        return view('backoffice/registrasi/create_instansi', $data);
    }

    public function edit_instansi($id_instansi)
    {
        $data = array(
            'title' => "Ubah Instansi",
            'page' => "instansi",
            'session' => session(),
        );
        return view('backoffice/registrasi/edit_instansi', $data);
    }

    public function update_instansi($id_instansi)
    {
        # code...
    }

    public function delete_instansi($id_instansi)
    {
        $data = array(
            'title' => "Hapus Instansi",
            'page' => "instansi",
            'session' => session(),
        );
        return view('backoffice/registrasi/delete_instansi', $data);
    }

    public function doDelete_instansi()
    {
        # code...
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

    public function detail_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Detail Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/registrasi/detail_customer_overkuota', $data);
    }

    public function edit_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Ubah Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/registrasi/edit_customer_overkuota', $data);
    }

    public function update_customer_overkuota($id_customer_overkuota)
    {
        # code...
    }

    public function delete_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Hapus Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/registrasi/delete_customer_overkuota', $data);
    }

    public function doDelete_custoemr_overkuota()
    {
        # code...
    }

    //--------------------------------------------------------------------

}
