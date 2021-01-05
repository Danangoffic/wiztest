<?php

namespace App\Controllers\backoffice;

use App\Models\KehadiranModel;
use App\Models\LayananModel;
use App\Models\PemeriksaanModel;
use CodeIgniter\Controller;
// use App\Controllers;
// use CodeIgniter\Controller;

class Home extends Controller
{
    protected $session;
    protected $kehadiranModel;
    protected $layananModel;
    protected $pemeriksaanModel;
    public function __construct()
    {
        $this->session = session();
        $this->kehadiranModel = new KehadiranModel();
        $this->layananModel = new LayananModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $date_now = date('Y-m-d');
        $date1 = $this->request->getPost('date1') ? $this->request->getPost('date1') : $date_now;
        $date2 = $this->request->getPost('date2') ? $this->request->getPost('date2') : $date_now;
        $JenisLayanan = $this->layananModel->findAll();
        $JenisPemeriksaan = $this->pemeriksaanModel->findAll();

        // dd($this->session->get('nama'));
        $data = [
            'date1' => $date1,
            'date2' => $date2,
            'session' => $this->session, 'title' => 'Dashboard',
            'page' => 'dashboard', 'date_now' => $date_now,
            'jenis_layanan' => $JenisLayanan, 'jenis_pemeriksaan' => $JenisPemeriksaan, 'kehadiran_model' => $this->kehadiranModel
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
