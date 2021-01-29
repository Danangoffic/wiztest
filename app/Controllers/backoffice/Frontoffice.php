<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\KuotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PemeriksaanModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\RESTful\ResourceController;

// use App\Controllers;
// use CodeIgniter\Controller;

class Frontoffice extends ResourceController
{
    public $session;
    protected $customerModel;
    protected $pemeriksaanModel;
    protected $kuotaModal;
    protected $instansi;
    protected $marketing;
    protected $layananTestModel;
    protected $layananModel;
    protected $testModel;
    protected $statusModel;
    public function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->kuotaModal = new KuotaModel();
        $this->session = \Config\Services::session();
        $this->instansi = new Instansi;
        $this->marketing = new MarketingModel();
        $this->layananTestModel = new LayananTestModel();
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->statusModel = new StatusHasilModel();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
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
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $filter = ($this->request->getVar('filtering')) ? $this->request->getVar('filtering') : '';
        $Customer = array();
        if ($filter == "on") {
            $date1 = ($this->request->getVar('date1')) ? $this->request->getVar('date1') : '';
            $date2 = ($this->request->getVar('date2')) ? $this->request->getVar('date2') : '';
            $instansi = ($this->request->getVar('instansi')) ? $this->request->getVar('instansi') : '';
            $marketing = ($this->request->getVar('marketing')) ? $this->request->getVar('marketing') : '';
            $layanan_test = ($this->request->getVar('layanan_test')) ? $this->request->getVar('layanan_test') : '';
            $queryFilter = 'SELECT * FROM customers';
            $queryFilter .= " WHERE jenis_test IN (SELECT id FROM data_layanan WHERE id_segmen = '1' AND id_layanan = '1')";

            if ($date1 !== '' && $date2 !== '') {
                $queryFilter .= " AND tgl_kunjungan BETWEEN '" . $date1 . "' AND '" . $date2 . "'";
            } elseif ($date1 !== '') {
                $queryFilter .= " AND tgl_kunjungan = '" . $date1 . "'";
            } elseif ($date2 !== '') {
                $queryFilter .= " AND tgl_kunjungan BETWEEN '" . date('Y-m-d') . "' AND '" . $date2 . "'";
            }
            if ($instansi !== '') {
                $queryFilter .= " AND instansi = '$instansi'";
            }
            if ($marketing !== '') {
                $queryFilter .= " AND id_marketing = '$marketing'";
            }
            if ($layanan_test !== '') {
                $queryFilter .= " AND jenis_test = '$layanan_test'";
            }
            $queryFilter .= " ORDER BY id DESC";
            $Customer = db_connect()->query($queryFilter)->getResultArray();
        } else {
            $data_layanan_test = $this->layananTestModel->select("id")->where(['id_segmen' => "1", 'id_layanan' => 1])->get()->getResultArray();
            $ids_test = array();
            foreach ($data_layanan_test as $key => $lt) {
                $ids_test[] = $lt['id'];
            }
            $Customer = db_connect()->table('customers')->select()->whereIn('jenis_test', $ids_test)->orderBy('id', 'DESC')->get()->getResultArray();
        }
        // $Customer = $this->customerModel->detailRegistrasi(false, $id_jenis_pemeriksaan)->getResultArray();
        $data = array(
            'title' => "Walk-In",
            'page' => "walk_in",
            'data_customer' => $Customer,
            'instansi' => $this->instansi->instansiModel->findAll(),
            'instansiModel' => $this->instansi->instansiModel,
            'marketing' => $this->marketing->findAll(),
            'marketingModel' => $this->marketing,
            'layananTest' => $this->layananTestModel->findAll(),
            'layananModel' => $this->layananModel,
            'instansiModel' => $this->instansi->instansiModel,
            'testModel' => $this->testModel,
            'layananTestModel' => $this->layananTestModel,
            'session' => session(),
            'status_model' => $this->statusModel
        );
        return view('backoffice/frontoffice/walk_in', $data);
    }

    public function antrian_swab_walk_in()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $filtering = ($this->request->getPost('filtering')) ? $this->request->getPost('filtering') : "";
        if ($filtering == "on") {
            $filterDate = $this->request->getPost('date1');
        } else {
            $filterDate = date('Y-m-d');
        }
        // $filterDate = ($this->request->getVar('filterDate')) ? $this->request->getPost('filterDate') : date('Y-m-d');
        $data_layanan_test_show = $this->layananTestModel->where(['id_segmen' => '1', 'id_test' => '1', 'id_pemeriksaan' => '1'])->get()->getResultArray();
        $data = array(
            'title' => "Antrian Swab Walk-In",
            'page' => "antrian_swab_walk_in",
            'session' => session(),
            'filterDate' => $filterDate,
            'customer_model' => $this->customerModel,
            'data_layanan_test' => $data_layanan_test_show,
            'layanan_model' => $this->layananModel,
            'test_model' => $this->testModel,
            'kuota_model' => $this->kuotaModal
        );
        return view('backoffice/frontoffice/antrian', $data);
    }

    public function antrian_rapid_antigen()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $filtering = ($this->request->getPost('filtering')) ? $this->request->getPost('filtering') : "";
        if ($filtering == "on") {
            $filterDate = $this->request->getPost('date1');
        } else {
            $filterDate = date('Y-m-d');
        }
        $kuotaSwabSameDay = $this->kuotaModal->findV2('3')->getResultArray();
        $kuotaSwabBasic = $this->kuotaModal->findV2('4')->getResultArray();
        $data_layanan_test_show = $this->layananTestModel
            ->where(['id_segmen' => '1', 'id_pemeriksaan' => '1'])
            ->whereIn('id_test', ['2', '3'])->get()->getResultArray();

        $data = array(
            'title' => "Antrian Rapid Walk-In",
            'page' => "antrian_rapid_antigen",
            'kuotaSwabSameDay' => $kuotaSwabSameDay,
            'kuotaSwabBasic' => $kuotaSwabBasic,
            'session' => session(),
            'filterDate' => $filterDate,
            'customer_model' => $this->customerModel,
            'data_layanan_test' => $data_layanan_test_show,
            'layanan_model' => $this->layananModel,
            'test_model' => $this->testModel,
            'kuota_model' => $this->kuotaModal
        );
        return view('backoffice/frontoffice/antrian_rapid_antigen', $data);
    }

    public function detail_antrian($id_test, $tanggal, $jam)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data_layanan = $this->layananTestModel->where(['id_test' => $id_test])->first();
        $id_jenis_test = $data_layanan['id'];
        // $id_test = $data_layanan['id_test'];
        // echo db_connect()->showLastQuery();
        // exit();
        $detail_test = $this->testModel->find($id_test);
        $nama_test = $detail_test['nama_test'];
        if ($id_test == "1") {
            $subcontent_url = base_url('backoffice/frontoffice/antrian_swab_walk_in');
        } else {
            $subcontent_url = base_url('backoffice/frontoffice/antrian_rapid_antigen');
        }
        // $antrian_swabber = $this->customerModel->where(['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'jenis_test' => $id_jenis_test, 'kehadiran' => '23'])->orderBy('no_antrian', 'ASC')->get()->getResultArray();
        // $booking_antrian = $this->customerModel->where(['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'jenis_test' => $id_jenis_test])->orderBy('no_antrian', 'ASC')->get()->getResultArray();
        $data = array(
            'title' => "Detail Antrian",
            'page' => "antrian",
            'id_jenis_test' => $id_jenis_test,
            'tanggal' => $tanggal,
            'jam' => $jam,
            'subcontent' => $nama_test,
            'subcontent_url' => $subcontent_url,
            // 'antrian_swabber' => $antrian_swabber,
            // 'booking_antrian' => $booking_antrian,
            'session' => $this->session
        );
        return view('backoffice/frontoffice/detail_antrian', $data);
    }

    public function load_detail_antrian()
    {
        $id_test = $this->request->getVar('id_jenis_test');
        $tanggal = $this->request->getVar('tanggal');
        $jam = $this->request->getVar('jam');
        $requested_by = $this->request->getVar('requested_by');
        if (!$requested_by || $requested_by == "" || $requested_by == null) {
            return $this->failUnauthorized();
        }
        $jam = $jam . ':00:00';
        // $detail_layanan_test = $this->layananTestModel->where(['id_layanan' => $id_layanan])->first();

        // $id_jenis_test = $detail_layanan_test['id'];
        $antrian_swabber = $this->customerModel->where(['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'jenis_test' => $id_test, 'kehadiran' => '23'])->orderBy('no_antrian', 'ASC')->get()->getResultArray();
        // echo db_connect()->showLastQuery() . "<br>";
        $booking_antrian = $this->customerModel->where(['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'jenis_test' => $id_test])->orderBy('no_antrian', 'ASC')->get()->getResultArray();
        // echo db_connect()->showLastQuery() . "<br>";
        $data = array('antrian_swabber' => $antrian_swabber, 'booking_antrian' => $booking_antrian);
        return $this->respond($data, 200, 'success');
    }

    //--------------------------------------------------------------------

}
