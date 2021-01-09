<?php

namespace App\Controllers\backoffice;

use App\Models\InstansiModel;
use App\Models\KotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\TestModel;
use CodeIgniter\Controller;
use Dompdf\Cpdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Home_service extends Controller
{
    public $session;
    protected $kotaModel;
    protected $marketingModel;
    public function __construct()
    {
        $this->session = session();
        $this->kotaModel = new KotaModel();
        $this->marketingModel = new MarketingModel();
    }
    public function index()
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
}
