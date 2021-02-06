<?php

namespace App\Controllers\backoffice;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\PemanggilanModel;
use CodeIgniter\RESTful\ResourceController;

class Antrian extends ResourceController
{
    protected $pemanggilan_model;
    protected $customer_model;
    protected $session;
    public function __construct()
    {
        $this->pemanggilan_model = new PemanggilanModel();
        $this->customer_model = new CustomerModel();
        $this->session = \Config\Services::session();
    }

    public function bilik($nomor_bilik = 1)
    {
        $data = [
            'title' => "Bilik Antrian " . $nomor_bilik,
            'page' => "bilik",
            'session' => $this->session,
            'nomor_bilik' => $nomor_bilik
        ];
        return view("backoffice/antrian/bilik", $data);
    }

    public function get_data_antrian()
    {
        $nomor_bilik = $this->request->getVar("nomor_bilik");
        $data_antrian_bilik = $this->pemanggilan_model->get_nomor_antrian_bilik($nomor_bilik)->getResultArray();
        return $this->respond($data_antrian_bilik, 200, 'success');
    }

    public function get_data_on_call()
    {
        $nomor_bilik = $this->request->getVar("nomor_bilik");
        $data_pemanggilan_bilik = $this->pemanggilan_model->get_nomor_panggilan_bilik($nomor_bilik)->getResultArray();
        return $this->respond($data_pemanggilan_bilik, 200, 'success');
    }
}
