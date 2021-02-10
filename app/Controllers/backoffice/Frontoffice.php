<?php

namespace App\Controllers\backoffice;

use App\Models\BilikSwabberModel;
use App\Models\CustomerModel;
use App\Models\KuotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PemanggilanModel;
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
    protected $pemanggilan_model;
    protected $bilik_swabber_model;
    protected $layanan_test_model;
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
        $this->pemanggilan_model = new PemanggilanModel();
        $this->bilik_swabber_model = new BilikSwabberModel();
        $this->layanan_test_model = new LayananTestModel();
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
        $data_layanan_test = $this->layananTestModel->get_by_key('id_pemeriksaan', "1")->getResultArray();
        $ids_test = array();
        foreach ($data_layanan_test as $key => $lt) {
            $ids_test[] = $lt['id'];
        }
        $Customer = array();
        if ($filter == "on") {
            $date1 = ($this->request->getVar('date1')) ? $this->request->getVar('date1') : '';
            $date2 = ($this->request->getVar('date2')) ? $this->request->getVar('date2') : '';
            $instansi = ($this->request->getVar('instansi')) ? $this->request->getVar('instansi') : '';
            $marketing = ($this->request->getVar('marketing')) ? $this->request->getVar('marketing') : '';
            $layanan_test = ($this->request->getVar('layanan_test')) ? $this->request->getVar('layanan_test') : '';
            $Customer = $this->customerModel->filter_walkin($ids_test, $date1, $date2, $instansi, $marketing, $layanan_test)->getResultArray();
        } else {
            // $data_layanan_test = $this->layananTestModel->select("id")->where(['id_layanan' => "1"])->get()->getResultArray();
            // $ids_test = array();
            // foreach ($data_layanan_test as $key => $lt) {
            //     $ids_test[] = $lt['id'];
            // }
            $extra = [
                'jenis_test' => $ids_test
            ];
            $Customer = $this->customerModel->deep_detail_by_id(null, $extra)->getResultArray();
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
        $filter = ['id_segmen' => '1', 'id_test' => '1', 'id_pemeriksaan' => '1'];
        $data_layanan_test_show = $this->layananTestModel->where($filter)->get()->getResultArray();
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
        $filter_antrian = ['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'jenis_test' => $id_test, 'kehadiran' => '23'];
        $antrian_swabber = $this->customerModel->where($filter_antrian)->orderBy('no_antrian', 'ASC')->get()->getResultArray();
        // echo db_connect()->showLastQuery() . "<br>";
        $filter_booking = ['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'jenis_test' => $id_test];
        $booking_antrian = $this->customerModel->where($filter_booking)->orderBy('no_antrian', 'ASC')->get()->getResultArray();
        // echo db_connect()->showLastQuery() . "<br>";
        $data = array('antrian_swabber' => $antrian_swabber, 'booking_antrian' => $booking_antrian);
        return $this->respond($data, 200, 'success');
    }

    public function cek_bilik_antrian()
    {
        helper('form');
        $bilikModel = new BilikSwabberModel();
        $data_bilik = $bilikModel->orderBy("nomor_bilik", "asc")->get()->getResultArray();
        $data = [
            'data_bilik' => $data_bilik,
            'title' => 'Data Bilik Antrian',
            'page' => 'fontoffice',
            'session' => $this->session
        ];
        return view("backoffice/frontoffice/cek_bilik_antrian", $data);
    }

    public function manajemen_antrian($nomor_bilik = 1)
    {
        $date_now = date('Y-m-d');
        $jam_now = date("H") . ":00:00";
        // $jenis_test = $this->layanan_test_model->get_by_key(['id_segmen' => "1", "id_pemeriksaan" => "1"])->getResultArray();
        $data_customer = $this->customerModel->by_nomor_bilik($nomor_bilik)->getResultArray();

        $db_bilik = $this->bilik_swabber_model->by_nomor_bilik($nomor_bilik)->getRowArray();
        // $user_swabber = $this->user_model;
        // dd($this->session->get('user_level'));
        // $data_bilik = $db_bilik->where('nomor_bilik', $nomor_bilik)->get()->getRowArray();

        $data = array(
            'title' => "Antrian Bilik " . $nomor_bilik,
            'page' => "frontoffice",
            'data_customer' => $data_customer,
            'session' => $this->session,
            'data_bilik' => $db_bilik,
            'nomor_bilik' => $nomor_bilik,
        );
        return view("backoffice/frontoffice/manajemen_antrian", $data);
    }

    public function antrian_panggilan()
    {
        $bilik = $this->request->getVar('nomor_bilik');
        $data_panggilan = $this->dalam_panggilan($bilik);
        $data_antrian = $this->antrian_menunggu($bilik);

        if ($data_panggilan != null) {
            $id_customer = $data_panggilan['id_customer'];
            $id_customer_antrian = $data_antrian['id_customer'];
            $customer_panggilan = $this->customerModel->detail_customer($id_customer);
            $customer_antrian = $this->customerModel->detail_customer($id_customer_antrian);
            $return_array = array(
                'panggilan' => $customer_panggilan,
                'antrian' => $customer_antrian
            );
            return $this->respond($return_array, 200, "success");
        } else {
            $return_array = array(
                'antrian' => []
            );
            return $this->respond($return_array, 404, "not found");
        }
    }

    protected function dalam_panggilan($bilik)
    {
        return $this->pemanggilan_model->by_jenis_antrian('12', $bilik)->get(1)->getRowArray();
    }

    protected function antrian_menunggu($bilik)
    {
        return $this->pemanggilan_model->by_jenis_antrian('11', $bilik)->get(1)->getRowArray();
    }

    public function next_antrian()
    {
        $id_customer =  $this->request->getVar('id_customer');
        try {
            $cek = $this->customerModel->detail_customer($id_customer);
            $response_failed = ['status' => "failed", 'message' => "peserta tidak ditemukan"];
            if ($cek == null) return $this->respond($response_failed, 400, "failed");

            $data_pemanggilan = array('status_pemanggilan' => "12");
            $get_pemanggilan = $this->pemanggilan_model->get_by_customer($id_customer);
            $detail_pemanggilan = $get_pemanggilan->getRowArray();
            $id_pemanggilan = $detail_pemanggilan['id'];
            $update_pemanggilan1 = $this->pemanggilan_model->update($id_pemanggilan, $data_pemanggilan);
            $get = $this->pemanggilan_model->belum_dipanggil()->getRowArray();
            $id_get = $get['id'];
            $customer_id_get = $get['id_customer'];

            $array_update2 = array('status_pemanggilan' => "12");
            $update_pemanggilan2 = $this->pemanggilan_model->update($id_get, $array_update2);

            $customer_data_next = $this->customerModel->detail_customer($customer_id_get);
            $tgl_kunjungan = $customer_data_next['tgl_kunjungan'];
            $jam_kunjungan = $customer_data_next['jam_kunjungan'];
            $date_now = date("Y-m-d");
            $jam = date("H") . ":00:00";
            if ($date_now == $tgl_kunjungan && $jam_kunjungan == $jam) {
                return $this->respond($customer_data_next, 200, "success");
            }
        } catch (\Throwable $th) {
        }
    }

    //--------------------------------------------------------------------

}
