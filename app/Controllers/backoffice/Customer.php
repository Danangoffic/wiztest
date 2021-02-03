<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\FaskesModel;
use App\Models\KotaModel;
use App\Models\KuotaModel;
use App\Models\PemeriksaanModel;
use App\Controllers\BaseController;
// use App\Controllers;
// use CodeIgniter\Controller;

class Customer extends BaseController
{
    public $session;
    protected $faskesModel;
    protected $kotaModel;
    protected $userC;
    protected $customer_model;
    public function __construct()
    {
        $this->faskesModel = new FaskesModel();
        $this->kotaModel = new KotaModel();
        $this->userC = new User;
        $this->session = \Config\Services::session();
        $this->customer_model = new CustomerModel();
    }
    public function index()
    {
    }

    public function kehadiran()
    {
        # code...
    }
}
