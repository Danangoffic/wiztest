<?php

namespace App\Controllers\backoffice;

use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\TestModel;
use CodeIgniter\Controller;
use Dompdf\Cpdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Layanan extends Controller
{
    public $session;
    public function __construct()
    {
        $this->session = session();
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        // dd($this->session->get('nama'));
        return view('backoffice/layanan/index');
    }

    public function detail_layanan($id_layanan)
    {
        $modelLayananTest = new LayananTestModel();
        $modelLayanan = new LayananModel();
        $modelTest = new TestModel();
        $result_model = $modelLayananTest->find($id_layanan);
        $id_pemeriksaan = $result_model['id_test'];
        $id_layanan = $result_model['id_layanan'];
        $DataPemeriksaan = $modelTest->find($id_pemeriksaan);
        $DataLayanan = $modelLayanan->find($id_layanan);
        $resultData = [
            'id' => $id_layanan,
            'nama_test' => $DataPemeriksaan['nama_test'],
            'nama_layanan' => $DataLayanan['nama_layanan'],
            'biaya' => $result_model['biaya'],
        ];
        return $resultData;
    }

    public function pdf($id_customer)
    {
        
    }

    //--------------------------------------------------------------------

}
