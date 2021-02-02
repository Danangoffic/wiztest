<?php

namespace App\Controllers\backoffice;

// use App\Controllers\BaseController;
use App\Models\BilikSwabberModel;
use App\Models\CustomerModel;
use App\Models\KehadiranModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use App\Models\UserDetailModel;
use App\Models\UserModel;
use Mike42\Escpos\Printer;
// use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

// use Respon
// use 

class Swabber extends ResourceController
{
    public $session;
    protected $user_model;
    protected $customer_model;
    protected $kehadiran_model;
    protected $status;
    protected $layanan_test_model;
    protected $test_model;
    protected $layanan_model;
    protected $bilik_model;
    protected $layanan_controller;
    protected $escpos;
    protected $detail_user;
    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->user_model = new UserModel();
        $this->customer_model = new CustomerModel();
        $this->kehadiran_model = new KehadiranModel();
        $this->status = new StatusHasilModel();
        $this->layanan_test_model = new LayananTestModel();
        $this->bilik_model = new BilikSwabberModel();
        $this->layanan_controller = new Layanan;
        $this->detail_user = new UserDetailModel();
        $this->layanan_model = new LayananModel();
        $this->test_model = new TestModel();
        // $connector = new FilePrintConnector("php://stdout");
        // $printer = new Printer($connector);
    }

    public function index()
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/');

        if ($this->session->get('user_level') == 100 || $this->session->get("user_level") == 1 || $this->session->get("user_level") == 99) {
            return $this->data_swabber();
        } else {
            return redirect()->to('/');
        }
    }

    protected function data_swabber()
    {
        $email = $this->session->get('email');
        // $user_level = $this->session->get("user_level");
        // if ($user_level !== 100) return redirect()->to("/");

        $date_now = date('Y-m-d');
        $jenis_test = $this->layanan_test_model->where(['id_segmen' => "1", "id_pemeriksaan" => "1"])->get()->getResultArray();
        $antrian_swab_pcr = array();
        $antrian_antigen = array();
        $antrian_rapid = array();
        foreach ($jenis_test as $key => $jt) {
            $id_jenis_test = $jt['id'];
            $id_test = $jt['id_test'];
            $get_customer = $this->customer_model->where(['kehadiran' => "23", "tgl_kunjungan" => $date_now])->where("jenis_test", $id_jenis_test)->orderBy("updated_at", "ASC")->get()->getResultArray();
            foreach ($get_customer as $key => $customers) {
                if ($id_test == "1") {
                    $antrian_swab_pcr[] = $customers;
                } elseif ($id_test == "2") {
                    $antrian_rapid[] = $customers;
                } elseif ($id_test == "3") {
                    $antrian_antigen[] = $customers;
                }
            }
        }
        $db_bilik = db_connect()->table('bilik_swabber')->select();
        $user_swabber = $this->user_model;
        if ($this->session->get("user_level") == 100) {
            $data_bilik = $db_bilik->where('assigned_to', $this->session->get('id_user'))->get()->getResultArray();
            $data_swabber = $user_swabber->where(['id' => $this->session->get("id_user"), 'user_level' => 100])->get()->getResultArray();
        } else {
            $data_bilik = $db_bilik->groupBy("nomor_bilik")->orderBy("nomor_bilik", "ASC")->get()->getResultArray();
            $data_swabber = $user_swabber->where(['user_level' => 100])->get()->getResultArray();
        }

        $data = array(
            'title' => "Antrian Swabber",
            'page' => "swabber",
            'data_swab_pcr' => $antrian_swab_pcr,
            'data_rapid' => $antrian_rapid,
            'data_antigen' => $antrian_antigen,
            'session' => $this->session,
            'data_bilik' => $data_bilik,
            'data_swabber' => $data_swabber,
            'detail_swabber' => $this->detail_user,
            'bilik' => $db_bilik
        );
        return view("backoffice/swabber/index_swabber", $data);
    }

    public function get_antrian_swabber()
    {
        $nomor_bilik = $this->request->getVar('nomor_bilik');
        $tanggal = date("Y-m-d");
        $requested_by = $this->request->getVar('requested_by');
        if (!$requested_by || $requested_by == "" || $requested_by == null) {
            return $this->failUnauthorized();
        }
        $jam = date("H") . ':00:00';
        // $detail_layanan_test = $this->layananTestModel->where(['id_layanan' => $id_layanan])->first();

        // $id_jenis_test = $detail_layanan_test['id'];


        $validasi_swabber = $this->user_model->find($requested_by);
        $user_level = intval($validasi_swabber['user_level']);
        $array_user_bilik = array(1, 99, 100);
        if (!in_array($user_level, $array_user_bilik)) {
        }
        $antrian_swabber = $this->customer_model->where(['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'nomor_bilik' => $nomor_bilik, 'kehadiran' => '23'])->orderBy('no_antrian', 'ASC')->get()->getResultArray();


        // echo db_connect()->showLastQuery() . "<br>";
        $booking_antrian = $this->customer_model->where(['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'nomor_bilik' => $nomor_bilik])->orderBy('no_antrian', 'ASC')->get()->getResultArray();
        // echo db_connect()->showLastQuery() . "<br>";
        $data = array('antrian_swabber' => $antrian_swabber, 'booking_antrian' => $booking_antrian);
        return $this->respond($data, 200, 'success');
    }

    public function print_it(int $id_customer)
    {
        // $Connector = new FilePrintConnector("php://stdout");
        // $data_L = $this->layanan_controller->printbarcode();
    }

    public function kelola()
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/');

        if ($this->session->get('user_level') != 100 || $this->session->get("user_level") != 1) return redirect()->to("/");
        $data_bilik = $this->bilik_model->findAll();
        $data = array(
            'title' => "Data Bilik Swabber",
            'page' => "bilik_swabber",
            'data_bilik' => $data_bilik
        );
        return view("backoffice/swabber/kelola_bilik", $data);
    }

    public function create_bilik()
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/');

        // if ($this->session->get('user_level') != 100 || $this->session->get("user_level") != 1) return redirect()->to("/");
        $data_bilik = $this->bilik_model->findAll();
        $ids_user_bilik = null;
        $user_swabber = $this->user_model->where(['user_level' => 100]);
        if ($data_bilik != null)
            foreach ($data_bilik as $key => $bilik) $ids_user_bilik['id'] = $bilik['assigned_to'];
        if ($ids_user_bilik != null)
            $user_swabber = $user_swabber->whereNotIn("id", $ids_user_bilik);

        $data_user_swabber = $user_swabber->get()->getResultArray();

        $data = array(
            'title' => "Form Tambah Bilik Swabber",
            'page' => "bilik_swabber",
            'data_user_swabber' => $data_user_swabber,
            'data_test' => $this->test_model->findAll(),
            'session' => $this->session
        );
        return view("backoffice/swabber/tambah_bilik", $data);
    }

    public function save_bilik()
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/');

        // if ($this->session->get('user_level') != 100 || $this->session->get("user_level") != 1) return redirect()->to("/");

        $assigned_to = $this->request->getPost('swabber');
        $jenis_test = $this->request->getPost('jenis_test');
        $check_user = $this->user_model->find($assigned_to);
        if ($check_user) {
            $nomor_bilik = $this->request->getPost("nomor_bilik");
            $array_insert = array(
                'assigned_to' => $assigned_to,
                'jenis_test' => $jenis_test,
                'nomor_bilik' => $nomor_bilik
            );
            if ($this->bilik_model->insert($array_insert)) {
                $this->session->setFlashdata("success", "Berhasil Tambahkan Bilik dengan nomor bilik " . $nomor_bilik);
                return redirect()->to("/backoffice/swabber");
            } else {
                $this->session->setFlashdata("error", "Gagal Tambahkan Bilik");
                return redirect()->to("/backoffice/swabber/create_bilik");
            }
        } else {
            $this->session->setFlashdata("error", "Gagal Tambahkan Bilik karena user bukan swabber");
            return redirect()->to("/backoffice/swabber/create_bilik");
        }
    }

    public function edit_bilik(int $id_bilik)
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/');

        if ($this->session->get('user_level') != 100 || $this->session->get("user_level") != 1) return redirect()->to("/");

        $data_bilik = $this->bilik_model->find($id_bilik);
        $data_user_swabber = $this->customer_model->where(['user_level' => 100])->get()->getResultArray();
        $data = array(
            'title' => "Tambah Bilik Swabber",
            'page' => "bilik_swabber",
            'data_user_swabber' => $data_user_swabber,
            'data_bilik' => $data_bilik
        );
        return view("backoffice/swabber/edit_bilik", $data);
    }

    public function update_bilik(int $id_bilik = 0)
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/');

        if ($this->session->get('user_level') != 100 || $this->session->get("user_level") != 1) return redirect()->to("/");

        $id_bilik_form = $this->request->getPost("id_bilik");
        $assigned_to = $this->request->getPost('user');
        $jenis_test = $this->request->getPost('jenis_test');
        $check_user = $this->user_model->find($assigned_to);
        if ($check_user) {
            $get_all_bilik = $this->bilik_model->findAll();
            $total_bilik = count($get_all_bilik);
            $nomor_bilik = $total_bilik + 1;
            $array_insert = array(
                'assigned_to' => $assigned_to,
                'jenis_test' => $jenis_test,
                'nomor_bilik' => $nomor_bilik
            );
            if ($this->bilik_model->update($id_bilik_form, $array_insert)) {
                $this->session->setFlashdata("success", "Berhasil Ubah Bilik");
                return redirect()->to("/backffice/swabber/kelola");
            } else {
                $this->session->setFlashdata("error", "Gagal Ubah Bilik");
                return redirect()->to("/backffice/swabber/edit_bilik/" . $id_bilik_form);
            }
        } else {
            $this->session->setFlashdata("error", "Gagal Ubah Bilik karena user bukan swabber");
            return redirect()->to("/backffice/swabber/edit_bilik/" . $id_bilik_form);
        }
    }
}
