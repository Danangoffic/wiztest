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
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

// use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

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
        // $email = $this->session->get('email');
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
        // dd($this->session->get('user_level'));
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
            'detail_user' => $this->detail_user,
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
        // if (!in_array($user_level, $array_user_bilik)) {
        //     return null;
        // }
        $antrian_swabber = $this->customer_model->antrian_swabber($tanggal, $jam, $nomor_bilik, "antrian")->getResultArray();


        // echo db_connect()->showLastQuery() . "<br>";
        $booking_antrian = $this->customer_model->antrian_swabber($tanggal, $jam, $nomor_bilik)->getResultArray();
        // echo db_connect()->showLastQuery() . "<br>";
        $data = array('antrian_swabber' => $antrian_swabber, 'booking_antrian' => $booking_antrian);
        return $this->respond($data, 200, 'success');
    }

    public function print_barcode()
    {
        $id_customer = $this->request->getPost("id_customer");
        $customer = $this->customer_model->detail_customer($id_customer);
        if ($customer == null) return false;
        $customer_unique = $customer['customer_unique'];
        $nama = $customer['nama'];
        $connector = "USB0001";
        // $connector = new FilePrintConnector("php://stdout");
        $connector = new WindowsPrintConnector($connector);
        $printer = new Printer($connector);

        $printer->setBarcodeTextPosition(Printer::BARCODE_TEXT_BELOW);

        $printer->selectPrintMode(Printer::MODE_DOUBLE_HEIGHT | Printer::MODE_DOUBLE_WIDTH);

        for ($i = 0; $i < 3; $i++) {
            $printer->setBarcodeHeight(40);
            $printer->setEmphasis(true);
            $printer->text($nama . "\n");
            $printer->setEmphasis(true);
            $printer->barcode($customer_unique);
            $printer->feed();
            $printer->cut();
        }
        $printer->close();
        $this->do_update_customer_been_printed($id_customer);
        // $printer->text("Height and bar width\n");
        // $printer->selectPrintMode();
        // $heights = array(1, 2, 4, 8, 16, 32);
        // $widths = array(1, 2, 3, 4, 5, 6, 7, 8);
        // $printer->text("Default look\n");

        // $printer->feed();
        // // Set to something sensible for the rest of the examples
        // $printer->setBarcodeHeight(40);
        // $printer->setBarcodeWidth(2);
        // Printer::BARCODE_CODE128 = array(
        //     "title" => "Code128",
        //     "caption" => "Variable length- any ASCII is available",
        //     "example" => array(
        //         array(
        //             "caption" => "Code set A uppercase & symbols",
        //             "content" => "{A" . "012ABCD"
        //         ),
        //         array(
        //             "caption" => "Code set B general text",
        //             "content" => "{B" . "012ABCDabcd"
        //         ),
        //         array(
        //             "caption" => "Code set C compact numbers\n Sending chr(21) chr(32) chr(43)",
        //             "content" => "{C" . chr(21) . chr(32) . chr(43)
        //         )
        //     )
        // );
        // Printer::BARCODE_TEXT_BELOW = "Below";

        // $printbarcoder = ;
        // $printbarcoder = 
    }

    protected function do_update_customer_been_printed($id_customer = null)
    {
        $is_printed = "3";
        $arr_update = ['is_printed' => $is_printed];
        $this->customer_model->update($id_customer, $arr_update);
    }

    // public function print_it()
    // {
    //     $id_customer = $this->request->getPost("id_customer");
    //     $data_customer = $this->customer_model->find($id_customer);

    //     $order_id = $data_customer['customer_unique'];

    //     // $jamkunjungan = $this->input->post('nmjamkunjungan');
    //     $nama =  $data_customer['nama'];
    //     $jeniskelamin = $data_customer['jenis_kelamin'];
    //     $tanggallahir = $data_customer['tanggal_lahir'];

    //     $antrian_ke = $data_customer['no_antrian'];
    //     // $idjenis = $this->input->post('nmidjenis');
    //     // if ($idjenis == "3") {
    //     //     $jenis = "SS";
    //     // }
    //     // if ($idjenis == "4") {
    //     //     $jenis = "SB";
    //     // }
    //     $printer = printer_open("BARCODE");
    //     printer_start_doc($printer, "Doc");
    //     printer_start_page($printer);

    //     /* font management */
    //     $barcode = printer_create_font("Free 3 of 9 Extended", 125, 23, PRINTER_FW_NORMAL, false, false, false, 0);
    //     $arial = printer_create_font("Arial", 30, 10, 50, false, false, false, 0);

    //     /* write the text to the print job */

    //     printer_select_font($printer, $arial);
    //     printer_draw_text($printer, $nama, 25, 10);
    //     printer_draw_text($printer, $jeniskelamin . "/" . $tanggallahir, 25, 50);
    //     // printer_draw_text($printer, "UMUM", 25, 90);
    //     /*printer_draw_text($printer, $jenis."-".str_pad($jamkunjungan, 2, "0", STR_PAD_LEFT)."-".str_pad($antrian_ke, 3, "0", STR_PAD_LEFT), 25, 130);*/
    //     printer_select_font($printer, $barcode, 20);
    //     printer_draw_text($printer, '*' . $order_id . ';' . substr($nama, 0, 9) . '*', 25, 160);
    //     /*printer_select_font($printer, $arial);
    // 		printer_draw_text($printer, $idreg.';'.substr($nama,0,9), 100,270);*/

    //     /* font management */
    //     printer_delete_font($barcode);
    //     printer_delete_font($arial);

    //     /* close the connection */
    //     printer_end_page($printer);
    //     printer_end_doc($printer);
    //     printer_close($printer);
    // }

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
        $user_swabber = $this->user_model->get_by_user_level(100);
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
        $data_user_swabber = $this->user_model->get_by_user_level(100)->get()->getResultArray();
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
