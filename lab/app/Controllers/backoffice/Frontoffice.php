<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\KuotaModel;
use App\Models\PemeriksaanModel;
use CodeIgniter\Controller;
// use App\Controllers;
// use CodeIgniter\Controller;

class Frontoffice extends Controller
{
    public $session;
    protected $customerModel;
    protected $pemeriksaanModel;
    protected $kuotaModal;
    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->kuotaModal = new KuotaModel();
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

    public function walk_in()
    {

        $data_pemeriksaan = $this->pemeriksaanModel->where(['nama_pemeriksaan' => 'WALK IN'])->first();
        $id_jenis_pemeriksaan = $data_pemeriksaan['id'];
        $Customer = $this->customerModel->detailRegistrasi(false, $id_jenis_pemeriksaan)->getResultArray();
        $data = array(
            'title' => "Walk-In",
            'page' => "walk_in",
            'data_customer' => $Customer,
            'session' => session()
        );
        return view('backoffice/frontoffice/walk_in', $data);
    }

    public function antrian_swab_walk_in()
    {
        $filterDate = ($this->request->getVar('filterDate')) ? $this->request->getPost('filterDate') : date('Y-m-d');
        $kuotaSwabSameDay = $this->kuotaModal->findV2('1')->getResultArray();
        $kuotaSwabBasic = $this->kuotaModal->findV2('2')->getResultArray();
        $data = array(
            'title' => "Antrian Swab Walk-In",
            'page' => "antrian_swab_walk_in",
            'kuotaSwabSameDay' => $kuotaSwabSameDay,
            'kuotaSwabBasic' => $kuotaSwabBasic,
            'session' => session(),
            'filterDate' => $filterDate
        );
        return view('backoffice/frontoffice/antrian', $data);
    }

    public function antrian_rapid_antigen()
    {
        $filterDate = ($this->request->getVar('filterDate')) ? $this->request->getPost('filterDate') : date('Y-m-d');
        $kuotaSwabSameDay = $this->kuotaModal->findV2('3')->getResultArray();
        $kuotaSwabBasic = $this->kuotaModal->findV2('4')->getResultArray();
        $data = array(
            'title' => "Antrian Rapid Walk-In",
            'page' => "antrian_rapid_antigen",
            'kuotaSwabSameDay' => $kuotaSwabSameDay,
            'kuotaSwabBasic' => $kuotaSwabBasic,
            'session' => session(),
            'filterDate' => $filterDate
        );
        return view('backoffice/frontoffice/antrian_rapid_antigen', $data);
    }

    public function detail_antrian($segment, $tanggal, $jam, $id_jenis_test)
    {
        switch ($segment) {
            case 'antrian':
                # code...
                $id_jenis_test = 1;
                break;
            case 'antrianbasic':
                $id_jenis_test = 2;
                break;
            case 'antrianrapid':
                $id_jenis_test = 3;
                break;
            case 'antrianantigen':
                $id_jenis_test = 4;
                break;
            default:
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Halaman yang anda cari, tidak tersedia');
                break;
        }
        $kuotaSwabSameDay = $this->kuotaModal->findV2('3')->getResultArray();
        $kuotaSwabBasic = $this->kuotaModal->findV2('4')->getResultArray();
        $data = array(
            'title' => "Antrian Rapid Walk-In",
            'page' => "antrian_rapid_antigen",
            'kuotaSwabSameDay' => $kuotaSwabSameDay,
            'kuotaSwabBasic' => $kuotaSwabBasic,
            'session' => session()
        );
        return view('backoffice/frontoffice/antrian_rapid_antigen', $data);
    }

    //--------------------------------------------------------------------

}
