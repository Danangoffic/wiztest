<?php

namespace App\Controllers;

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

        if ($nomor_bilik == 1) {
            $jenis_test = "Rapid Test";
        } else if ($nomor_bilik == 2) {
            $jenis_test = "Swab Antigen";
        } else {
            $jenis_test = "Swab PCR";
        }
        $data = [
            'title' => "Bilik Antrian " . $nomor_bilik,
            'page' => "bilik",
            'session' => $this->session,
            'nomor_bilik' => $nomor_bilik,
            'url_antrian' => base_url('api/antrian'),
            'url_on_call' => base_url('api/on_call'),
            'jenis_test' => $jenis_test
        ];
        return view("antrian/antrian_bilik", $data);
    }

    public function get_data_antrian()
    {
        $nomor_bilik = $this->request->getVar("nomor_bilik");
        $data_antrian_bilik = $this->pemanggilan_model->get_nomor_antrian_bilik($nomor_bilik)->getResultArray();
        $respond_data = array('data' => $data_antrian_bilik);
        return $this->respond($respond_data, 200, 'success');
    }

    public function get_data_on_call()
    {
        $nomor_bilik = $this->request->getVar("nomor_bilik");
        $data_pemanggilan_bilik = $this->pemanggilan_model->get_nomor_panggilan_bilik($nomor_bilik)->getResultArray();
        $respond_data = array('data' => $data_pemanggilan_bilik);
        return $this->respond($respond_data, 200, 'success');
    }
}
