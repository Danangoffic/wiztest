<?php

namespace App\Controllers\backoffice;

use App\Controllers\Customer;
use App\Models\CustomerModel;
use App\Models\FaskesModel;
use App\Models\InstansiModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use App\Controllers\BaseController;
use App\Controllers\Midtrans_handlers;
use App\Models\CustomerHomeServiceModel;
use App\Models\CustomerOverloadModel;
use App\Models\HasilLaboratoriumModel;
use App\Models\KehadiranModel;
use App\Models\KuotaModel;
use App\Models\PemanggilanModel;
use App\Models\PembayaranModel;
use App\Models\UserDetailModel;
use App\Models\UserModel;
use Dompdf\Dompdf;
use TCPDF;

// use CodeIgniter\Validation\Validation;
// use Dompdf\Cpdf;
// use Dompdf\Css\Stylesheet;
// use Dompdf\Options;
// use TCPDF;

// use App\Controllers;
// use CodeIgniter\Controller;

class Peserta extends BaseController
{
    public $session;
    public $customerModel;
    public $dokterModel;
    public $jenisPemeriksaanModel;
    public $faskesModel;
    public $instansiModel;
    public $marketingModel;
    public $layananTestModel;
    public $testModel;
    public $layananModel;
    public $pemeriksaModel;
    public $customerPublic;
    public $statusHadir;
    protected $pembayaran_model;
    protected $hasil_lab;
    protected $customer_overload;
    protected $home_service_model;
    protected $user_model;
    protected $detail_user_model;
    public $dompdf;
    protected $kehadiran_model;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->customerModel = new CustomerModel();
        $this->faskesModel = new FaskesModel();
    }

    protected function check_user_level()
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if ($user_level == 1 || $user_level == 100) {
            return true;
        } else {
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        }
    }
    public function index()
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if (!in_array($user_level, array(1, 2, 4, 99, 103))) :
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        endif;

        $this->layananTestModel = new LayananTestModel();
        $this->instansiModel = new InstansiModel();
        $this->marketingModel = new MarketingModel();
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $data_walkin = $this->layananTestModel->get_by_key('id_pemeriksaan', "1")->getResultArray();

        $ids_test = array();
        foreach ($data_walkin as $key => $lt) {
            $ids_test[] = $lt['id'];
        }
        $filter = ($this->request->getVar('filtering')) ? $this->request->getVar('filtering') : '';
        $Customer = array();
        if ($filter == "on") {
            $date1 = ($this->request->getVar('date1')) ? $this->request->getVar('date1') : '';
            $date2 = ($this->request->getVar('date2')) ? $this->request->getVar('date2') : '';
            $queryFilter = 'SELECT * FROM customers';
            $queryFilter .= " WHERE is_hs = 'no'";

            if ($date1 !== '' && $date2 !== '') {
                $queryFilter .= " AND (tgl_kunjungan BETWEEN '" . $date1 . "' AND '" . $date2 . "')";
            } elseif ($date1 !== '') {
                $queryFilter .= " AND tgl_kunjungan = '" . $date1 . "'";
            } elseif ($date2 !== '') {
                $now_date = date("Y-m-d");
                $queryFilter .= " AND tgl_kunjungan BETWEEN '{$now_date}' AND '{$date2}'";
            }
            $queryFilter .= " AND jenis_test IN (SELECT id FROM data_layanan_test WHERE id_segmen = '1' AND id_pemeriksaan = '1')";
            $queryFilter .= " ORDER BY id DESC";
            $Customer = db_connect()->query($queryFilter)->getResultArray();
        } else {
            $extra = [
                'jenis_test' => $ids_test
            ];
            $Customer = $this->customerModel->deep_detail_by_id(null, $extra)->getResultArray();
            // $Customer = db_connect()->table('customers')->whereIn('jenis_test', $ids_test)->select()->orderBy('id', 'DESC')->get()->getResultArray();
        }

        $data = array(
            'title' => "Data Registrasi Peserta",
            'page' => "registrasi",
            'data_customer' => $Customer,
            'instansiModel' => $this->instansiModel,
            'marketingModel' => $this->marketingModel,
            'layananModel' => $this->layananModel,
            'testModel' => $this->testModel,
            'layananTestModel' => $this->layananTestModel,
            'session' => \Config\Services::session()
        );
        return view('backoffice/registrasi/index', $data);
    }

    public function create_peserta()
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if (!in_array($user_level, array(1, 2, 4, 99, 103))) :
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        endif;

        $this->instansiModel = new InstansiModel();
        $this->marketingModel = new MarketingModel();
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->pemeriksaModel = new PemeriksaModel();
        $this->jenisPemeriksaanModel = new PemeriksaanModel();


        $dataPemeriksa = $this->pemeriksaModel->findAll();
        // dd($dataPemeriksa);
        $dataJenisPemeriksaan = $this->jenisPemeriksaanModel->findAll();
        $dataFaskes = $this->faskesModel->findAll();
        $dataInstanasi = $this->instansiModel->findAll();
        $dataMarketing = $this->marketingModel->findAll();

        $kondisi_layanan_test = ['id_segmen' => "1", 'id_pemeriksaan' => "1"];
        $dataLayananTest = $this->layananTestModel->get_by_key($kondisi_layanan_test)->getResultArray();
        $data = array(
            'title' => "Form Registrasi Peserta Baru",
            'page' => "registrasi",
            'session' => session(),
            'pemeriksa' => $dataPemeriksa,
            'jenis_pemeriksaan' => $dataJenisPemeriksaan,
            'faskes' => $dataFaskes,
            'instansi' => $dataInstanasi,
            'marketing' => $dataMarketing,
            'data_layanan_test' => $dataLayananTest,
            'testModel' => $this->testModel,
            'layananModel' => $this->layananModel,
            'status_peserta' => 20,
            'validation' => \Config\Services::validation()
        );
        return view('backoffice/peserta/create_peserta', $data);
    }

    public function save()
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if (!in_array($user_level, array(1, 2, 4, 99, 103))) :
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        endif;
        // $validation =  \Config\Services::validation();
        $this->validasi_peserta();

        $this->instansiModel = new InstansiModel();
        $this->marketingModel = new MarketingModel();
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->pemeriksaModel = new PemeriksaModel();
        $this->jenisPemeriksaanModel = new PemeriksaanModel();
        $this->customerPublic = new Customer;
        $this->customer_overload = new CustomerOverloadModel();
        $this->pembayaran_model = new PembayaranModel();
        $kuotaModel = new KuotaModel();

        $nama = $this->request->getPost('nama');
        $nik = $this->request->getPost('nik');
        $phone = $this->request->getPost('phone');
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('+62', '0', $phone);
        $email = $this->request->getPost('email');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $tempat_lahir = $this->request->getPost('tempat_lahir');
        $tgl_lahir = $this->request->getPost('tgl_lahir');
        $alamat = $this->request->getPost('alamat');
        $id_marketing = $this->request->getPost('id_marketing');
        $jenis_layanan = $this->request->getPost('jenis_layanan');


        $id_pemeriksaan = $this->request->getPost('id_pemeriksaan');
        // jenis_layanan
        $layanan_test = $this->request->getPost('test_layanan');
        $explode_layanan = explode(" ", $layanan_test);
        $id_test = intval($explode_layanan[0]);
        $id_layanan = $explode_layanan[1];
        $faskes_asal = $this->request->getPost('faskes_asal');
        $instansi = $this->request->getPost('instansi');

        $kehadiran = 23;
        $tgl_kunjungan = $this->request->getPost('tgl_kunjungan');
        $id_jam_kunjungan = $this->request->getPost('jam_kunjungan');
        $dataJamKunjungan = $kuotaModel->find($id_jam_kunjungan);
        $jam_kunjungan = $dataJamKunjungan['jam'];
        $status_pembayaran = $this->request->getPost('status_pembayaran');
        $pemeriksa =  $this->request->getPost('nama_pemeriksa');
        $detail_layanan_test = $this->layananTestModel->where(['id_test' => $id_test, 'id_layanan' => $id_layanan, 'id_pemeriksaan' => $id_pemeriksaan])->get()->getRowArray();
        $id_layanan_test = $detail_layanan_test['id'];

        try {
            $customer_UNIQUE = $this->customerPublic->getOrderId($id_layanan_test, $id_pemeriksaan, $tgl_kunjungan, $id_layanan, $jam_kunjungan);

            $no_urutan = $this->customerPublic->getUrutan($id_layanan_test, $tgl_kunjungan, $id_pemeriksaan, $jenis_layanan, $jam_kunjungan);
            // dd(db_connect()->showLastQuery());

            if ($id_test == 2 || $id_test == 3) {
                $nomor_bilik = 3;
            } else {
                $hitung_bilik = ($no_urutan % 7);
                if ($hitung_bilik == 0 || $hitung_bilik >= 3) {
                    $hitung_bilik += 1;
                }
                $nomor_bilik = $hitung_bilik;
            }

            $data_layanan_test = $this->layananTestModel->get_by_key(['id_layanan' => $id_layanan, 'id_test' => $id_test, 'id_pemeriksaan' => $id_pemeriksaan])->getRowArray();
            $id_jenis_test_customer = $data_layanan_test['id'];
            $amount_test = intval($data_layanan_test['biaya']);

            /**
             * VALIDASI STATUS PESERTA, JIKA NO URUT > MAX KUOTA, OTOMATIS MENJADI PESERTA OVERKUOTA
             */
            $status_peserta = ($no_urutan <= 51) ? (int) $this->request->getPost('status_peserta') : 21;


            // var_dump($data);
            $DataInsertCustomer = [
                'nama' => $nama,
                'email' => $email,
                'nik' => $nik,
                'phone' => $phone,
                'pemeriksa' => $pemeriksa,
                'jenis_test' => $id_jenis_test_customer,
                'jenis_pemeriksaan' => $id_pemeriksaan,
                'jenis_layanan' => $id_layanan,
                'faskes_asal' => $faskes_asal,
                'customer_unique' => $customer_UNIQUE,
                'jenis_kelamin' => $jenis_kelamin,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tgl_lahir,
                'alamat' => $alamat,
                'id_marketing' => $id_marketing,
                'instansi' => $instansi,
                'status_test' => 'menunggu',
                'tahap' => 1,
                'kehadiran' => $kehadiran,
                'no_antrian' => $no_urutan,
                'nomor_bilik' => $nomor_bilik,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => $status_pembayaran,
                'status_peserta' => $status_peserta,
            ];
            $insert = $this->customerModel->insert($DataInsertCustomer);
            // $insert_id = null;
            if ($insert) {
                $insert_id = $this->customerModel->getInsertID();
                $InvoiceCustomer = $this->customerPublic->getInvoiceNumber($insert_id);

                $this->customerModel->update($insert_id, ['invoice_number' => $InvoiceCustomer]);

                /**
                 * jika status peserta adalah overload, insert data ke customer overload juga
                 */
                if ($status_peserta == 21) {

                    $DataInsertCustomer['id_customer'] = $insert_id;
                    $DataInsertCustomer['invoice_number'] = $InvoiceCustomer;
                    $this->customer_overload->insert($DataInsertCustomer);
                    $insert_overload_id = $this->customer_overload->getInsertID();
                }
            } else {
                $this->session->setFlashdata("error", "Gagal menyimpan");
                return redirect()->to("/backoffice/peserta/create");
            }


            $detail_test = $this->testModel->find($id_test);
            if ($status_pembayaran == "Invoice" || $status_pembayaran == "Belum Lunas" || $status_pembayaran == "Lunas" || $status_pembayaran == "") {
                $tipe_pembayaran = "langsung";
            } else {
                $tipe_pembayaran = "midtrans";
            }
            $dataInsertPembayaran = [
                'id_customer' => $insert_id,
                'tipe_pembayaran' => $tipe_pembayaran,
                'nama' => $nama,
                'amount' => $amount_test,
                'nama_test' => $detail_test['nama_test'],
                'status_pembayaran' => $status_pembayaran,
                'jenis_pembayaran' => $status_pembayaran
            ];

            $this->hasil_lab = new HasilLaboratoriumModel();
            $insertPembayaran = $this->pembayaran_model->insert($dataInsertPembayaran);

            if ($id_jenis_test_customer == 2 || $id_jenis_test_customer == 3) {
                $dataInsertHasilAwal = [
                    'valid' => "no",
                    'id_customer' => $insert_id
                ];
                $insertHasil = $this->hasil_lab->insert($dataInsertHasilAwal);
            }
            $id_pembayaran = $this->pembayaran_model->getInsertID();
            if ($id_pembayaran && $insertPembayaran) {
                if ($status_pembayaran == "Lunas" || $status_pembayaran == "Invoice") {
                    $arrayInsertPemanggilan = array(
                        'id_customer' => $insert_id,
                        'id_layanan_test' => $id_jenis_test_customer,
                        'status_pemanggilan' => '11',
                        'tgl_kunjungan' => $tgl_kunjungan,
                        'jam_kunjungan' => $jam_kunjungan,
                        'bilik' => $nomor_bilik,
                        'antrian' => $no_urutan
                    );
                    $PemanggilanModel = new PemanggilanModel();
                    $PemanggilanModel->insert($arrayInsertPemanggilan);
                    $MH = new Midtrans_handlers;
                    $MH->send_whatsapp($insert_id);
                }
                $message_extra = "Silahkan antri pada bilik " . $nomor_bilik . " dengan nomor antrian " . $no_urutan;
                $this->session->setFlashdata('success', 'Berhasil tambahkan data peserta tes. ' . $message_extra);
                return redirect()->to('/backoffice/peserta');
            } else {
                $this->session->setFlashdata('error', 'Gagal tambahkan data peserta tes');
                return redirect()->to('/backoffice/peserta/create')->withInput();
            }
        } catch (\Throwable $th) {
            //throw $th;
            $this->session->setFlashdata('error', 'Gagal tambahkan data peserta tes karena ' . $th->getMessage() . ' line : ' . $th->getLine() . ' file : ' . $th->getFile());
            return redirect()->to('/backoffice/peserta/create')->withInput();
        }
    }

    public function detail_peserta($id)
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if (!in_array($user_level, array(1, 2, 4, 99, 103))) :
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        endif;

        $this->statusHadir = new StatusHasilModel();
        $this->customer_overload = new CustomerOverloadModel();

        // $Midtrans = new Midtrans();
        $Customer = $this->customerModel->detailRegistrasi($id)->getFirstRow();
        $nama = $Customer->nama;
        $order_id = $Customer->customer_unique;

        $tipe_pembayaran = $Customer->tipe_pembayaran;
        // dd($order_id);
        if ($tipe_pembayaran == "midtrans") {
            /**
             * GET STATUS PEMBAYARAN MELALUI MIDTRANS
             */
            $midtrans_bo = new Midtrans;
            \Midtrans::$isProduction = $midtrans_bo->production_mode;
            \Midtrans::$serverKey = $midtrans_bo->server_key;
            // dd(\Midtrans::$isProduction);

            $midtrans_status = (object) \Midtrans::status($order_id);
            // dd($midtrans_status);
            $jenis_pembayaran = ucwords(str_replace("_", " ", $midtrans_status->payment_type));
            $status_pembayaran = $midtrans_status->transaction_status;
            $midtrans_gross_amount = (int) $midtrans_status->gross_amount;
            $has_va = ($midtrans_status->va_numbers) ? $midtrans_status->va_numbers : null;

            $va = ($has_va != null) ? $has_va[0]->va_number : null;
            $bank = ($has_va != null) ? $has_va[0]->bank : null;
            $amt = 'Rp ' . number_format($midtrans_gross_amount, 0, ",", ".");
        } elseif ($tipe_pembayaran == "langsung") {
            $amount = $Customer->amount;
            $jenis_pembayaran = $Customer->jenis_pembayaran;
            $status_pembayaran = $Customer->status_pembayaran;
            $va = null;
            $amt = 'Rp ' . number_format($amount, 0, ",", ".");
            $bank = null;
        }

        $data = array(
            'title' => "Detail Peserta {$nama} - {$order_id}",
            'page' => "registrasi",
            'data_customer' => $Customer,
            'session' => $this->session,
            'id' => $id,
            'amt' => $amt,
            'va' => $va,
            'paymentType' => $jenis_pembayaran,
            'bank' => $bank,
            'transactionStatus' => $status_pembayaran,
            'status_hadir' => $this->statusHadir
        );
        return view('backoffice/peserta/detail_peserta', $data);
    }

    public function print_pdf($id_customer)
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }



        $this->instansiModel = new InstansiModel();
        $this->marketingModel = new MarketingModel();
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();

        $this->customer_overload = new CustomerOverloadModel();
        $this->home_service_model = new CustomerHomeServiceModel();
        $this->user_model = new UserModel();
        $this->detail_user_model = new UserDetailModel();
        $this->pembayaran_model = new PembayaranModel();

        $data_customer = $this->customerModel->find($id_customer);
        if ($data_customer == null) {
            $this->session->setFlashdata('error', "peserta tidak ditemukan");
            return redirect()->to("/backoffice/registrasi");
        }
        $nama_customer = $data_customer['nama'];
        $jenis_kelamin = $data_customer['jenis_kelamin'];

        if ($jenis_kelamin == "pria") {
            $prefix_name = "Bapak";
        } else {
            $prefix_name = "Ibu";
        }

        $name_attn = $prefix_name . " " . $nama_customer;
        $data = array(
            'session' => $this->session,
            'page' => 'registrasi',
            'title' => 'Invoice - ' . $name_attn,
            'data_customer' => $data_customer,
            'customer_model' => $this->customerModel,
            'home_service' => $this->home_service_model,
            'layanan_test_model' => $this->layananTestModel,
            'layanan_model' => $this->layananModel,
            'test_model' => $this->testModel,
            'pembayaran_model' => $this->pembayaran_model,
            'user' => $this->user_model,
            'detail_user' => $this->detail_user_model
        );
        // $pdf = new PdfExtender;
        $html = view('backoffice/peserta/print_pdf', $data);
        $html .= '<link rel="stylesheet" href="/assets/dist/css/adminlte.min.css">';
        // $html .= '';
        // $this->dompdf->setIsHtml5ParserEnabled(true);
        // require_once('tcpdf_include.php');
        $PDF = new Dompdf();



        //PDFutput the HTML content
        $PDF->loadHtml($html);
        //line ini penting
        $this->response->setContentType('application/pdf');
        $PDF->render();
        $PDF->stream("Invoice-{$nama_customer}.pdf", ['attachment' => 0]);
        //Close and output PDF document
        // $PDF->Output('Invoice-' . $name_attn . '.pdf', 'I');
    }

    public function print_pdf_peserta($id_customer)
    {
        # code...
    }

    public function edit($id_customer)
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if (!in_array($user_level, array(1, 2, 4, 99, 103))) :
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        endif;


        $this->instansiModel = new InstansiModel();
        $this->marketingModel = new MarketingModel();
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->pemeriksaModel = new PemeriksaModel();
        $this->faskesModel = new FaskesModel();
        $this->jenisPemeriksaanModel = new PemeriksaanModel();
        // $this->customerPublic = new Customer;
        $this->customer_overload = new CustomerOverloadModel();
        $this->home_service_model = new CustomerHomeServiceModel();
        $this->user_model = new UserModel();
        $this->detail_user_model = new UserDetailModel();
        $this->pembayaran_model = new PembayaranModel();


        $dataPemeriksa = $this->pemeriksaModel->findAll();
        // dd($dataPemeriksa);
        $dataJenisPemeriksaan = $this->jenisPemeriksaanModel->findAll();
        $dataFaskes = $this->faskesModel->findAll();
        $dataInstanasi = $this->instansiModel->findAll();
        $dataMarketing = $this->marketingModel->findAll();
        $dataLayananTest = $this->layananTestModel->get_by_key(['id_pemeriksaan' => "1", 'id_segmen' => "1"])->getResultArray();
        $data = array(
            'title' => "Ubah Customer",
            'page' => "registrasi",
            'session' => session(),
            'data' => $this->customerModel->find($id_customer),
            'id' => $id_customer,
            'pemeriksa' => $dataPemeriksa,
            'jenis_pemeriksaan' => $dataJenisPemeriksaan,
            'faskes' => $dataFaskes,
            'instansi' => $dataInstanasi,
            'marketing' => $dataMarketing,
            'data_layanan_test' => $dataLayananTest,
            'testModel' => $this->testModel,
            'layananModel' => $this->layananModel,
            'validation' => \Config\Services::validation()
        );
        return view('backoffice/peserta/edit_peserta', $data);
    }

    public function update($id_customer)
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if (!in_array($user_level, array(1, 2, 4, 99, 103))) :
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        endif;

        $this->validasi_peserta();

        $this->instansiModel = new InstansiModel();
        $this->marketingModel = new MarketingModel();
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->pemeriksaModel = new PemeriksaModel();
        $this->faskesModel = new FaskesModel();
        $this->jenisPemeriksaanModel = new PemeriksaanModel();
        $this->customerPublic = new Customer;
        $this->customer_overload = new CustomerOverloadModel();
        $this->home_service_model = new CustomerHomeServiceModel();
        $this->user_model = new UserModel();
        $this->detail_user_model = new UserDetailModel();
        $this->pembayaran_model = new PembayaranModel();

        $nama = $this->request->getPost('nama');
        $nik = $this->request->getPost('nik');
        $phone = $this->request->getPost('phone');
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('+62', '0', $phone);
        $email = $this->request->getPost('email');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $tempat_lahir = $this->request->getPost('tempat_lahir');
        $tgl_lahir = $this->request->getPost('tgl_lahir');
        $alamat = $this->request->getPost('alamat');
        $id_marketing = $this->request->getPost('id_marketing');
        $layanan_test = $this->request->getPost('layanan_test');

        $detail_layanan_test = $this->layananTestModel->find($layanan_test);
        $id_test = $detail_layanan_test['id_test'];
        $id_layanan = $detail_layanan_test['id_layanan'];
        $id_pemeriksaan = $detail_layanan_test['id_pemeriksaan'];
        $jenis_pemeriksaan = $this->request->getPost('jenis_pemeriksaan');

        $jenis_layanan = $this->request->getPost('jenis_layanan');
        $faskes_asal = $this->request->getPost('faskes_asal');
        $instansi = $this->request->getPost('instansi');
        // $kehadiran = 0;
        $tgl_kunjungan = $this->request->getPost('tgl_kunjungan');
        $id_jam_kunjungan = $this->request->getPost('jam_kunjungan');
        $dataJamKunjungan = $this->customerPublic->kuotaModel->find($id_jam_kunjungan);
        $jam_kunjungan = $dataJamKunjungan['jam'];
        $status_pembayaran  = $this->request->getPost('status_pembayaran');
        $pemeriksa = $this->request->getPost('nama_pemeriksa');
        // var_dump($this->request->getPost());
        // exit();
        // $customer_UNIQUE = $this->customerPublic->getOrderId($layanan_test, $id_pemeriksaan, $tgl_kunjungan, $id_layanan, $jam_kunjungan);
        // echo db_connect()->showLastQuery();
        // exit();
        // dd($customer_UNIQUE);
        try {
            $Layanan = new Layanan();
            $dataLayanan = $this->layananModel->find($jenis_layanan);
            $dataTest = $this->testModel->find($layanan_test);

            $no_urutan = $this->customerPublic->getUrutan($layanan_test, $tgl_kunjungan, $id_pemeriksaan, $id_layanan, $jam_kunjungan);
            // echo "Urutan : " . $no_urutan;

            // var_dump($data);
            $DataInsertCustomer = array(
                'nama' => $nama,
                'email' => $email,
                'nik' => $nik,
                'phone' => $phone,
                'pemeriksa' => $pemeriksa,
                'jenis_test' => $layanan_test,
                'jenis_pemeriksaan' => $id_pemeriksaan,
                'jenis_layanan' => $id_layanan,
                'faskes_asal' => $faskes_asal,
                // 'customer_unique' => $customer_UNIQUE,
                'jenis_kelamin' => $jenis_kelamin,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tgl_lahir,
                'alamat' => $alamat,
                'id_marketing' => $id_marketing,
                'instansi' => $instansi,
                'status_test' => '-',
                'tahap' => 1,
                'no_antrian' => $no_urutan,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => $status_pembayaran
            );
            $update = $this->customerModel->update($id_customer, $DataInsertCustomer);
            // $insert_id = null;
            if ($update) {
                $detail_test = $this->testModel->find($id_test);
                $dataInsertPembayaran = [
                    'status_pembayaran' => $status_pembayaran
                ];
                $data_pembayaran = $this->pembayaran_model->find(['id_customer' => $id_customer]);
                $id_pembayaran = $data_pembayaran['id'];
                $update_payment = $this->pembayaran_model->update($id_pembayaran, $dataInsertPembayaran);
                // $update_payment = db_connect()->table('data_pembayaran')->update($dataInsertPembayaran, ['id_customer' => $id_customer]);
                if ($update_payment) {
                    $this->session->setFlashdata('success', 'Berhasil ubah data peserta tes');
                    return redirect()->to('/backoffice/peserta');
                } else {
                    $this->session->setFlashdata('error', 'Gagal ubah data peserta tes');
                    return redirect()->to('/backoffice/peserta/edit/' . $id_customer)->withInput();
                }
            } else {
                $this->session->setFlashdata('error', 'Gagal ubah data peserta tes');
                return redirect()->to('/backoffice/peserta/edit/' . $id_customer)->withInput();
            }
        } catch (\Throwable $th) {
            //throw $th;
            $this->session->setFlashdata('error', 'Gagal ubah data peserta tes karena ' . $th->getMessage() . ' line : ' . $th->getLine() . ' file : ' . $th->getFile());
            dd($th);
            return redirect()->to('/backoffice/peserta/edit/' . $id_customer)->withInput();
        }
    }

    public function delete($id_customer)
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if (!in_array($user_level, array(1, 2, 99, 103))) :
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        endif;
        // var_dump($user_level);
        // exit();

        $data_customer = $this->customerModel->detail_customer($id_customer);
        if ($data_customer == null) {
            $this->session->setFlashdata("error", "Data customer tidak ditemukan");
            return redirect()->to("/backoffice/registrasi");
        }

        $data = array(
            'title' => "Hapus Customer",
            'page' => "registrasi",
            'session' => $this->session,
            'id' => $id_customer,
            'data_customer' => $data_customer
        );
        return view('backoffice/peserta/delete_peserta', $data);
    }

    public function doDelete()
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if (!in_array($user_level, array(1, 2, 99, 103))) :
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        endif;

        $id_customer = base64_decode($this->request->getPost("id_customer"));


        $this->pembayaran_model = new PembayaranModel();
        $this->hasil_lab = new HasilLaboratoriumModel();

        $this->user_model = new UserModel();
        $this->detail_user_model = new UserDetailModel();
        // $this->hasil_lab = new Lab

        $data_customer = $this->customerModel->detail_customer($id_customer);
        $data_pembayaran = $this->pembayaran_model->where(['id_customer' => $id_customer])->first();
        $data_lab = $this->hasil_lab->where(['id_customer' => $id_customer])->get()->getRowArray();
        $csrf = $this->request->getPost("csrf_test_name");
        // dd($data_pembayaran);
        if (!$csrf) {
            $this->session->setFlashdata("error", "Maaf token penghapusan tidak ditemukan");
            return redirect()->to("/backoffice/registrasi");
        }
        if ($data_customer == null) {
            $this->session->setFlashdata("error", "Data customer tidak ditemukan");
            return redirect()->to("/backoffice/registrasi");
        }
        $order_id = $data_customer['customer_unique'];
        // $midtrans_bo = new Midtrans;
        // \Midtrans::$isProduction = $midtrans_bo->production_mode;
        // \Midtrans::$serverKey = $midtrans_bo->server_key;
        // $cancel_payment = \Midtrans::cancel($order_id);
        $status_peserta = $data_customer['status_peserta'];
        if ($status_peserta == 21) {
            $customer_overload = $this->customer_overload->where(['id_customer' => $id_customer])->get()->getRowArray();
            if ($customer_overload === null) {
                $this->session->setFlashdata("error", "Data customer tidak ditemukan");
                return redirect()->to("/backoffice/registrasi");
            }
            $this->customer_overload->delete($customer_overload['id']);
        }


        if ($data_lab !== null) $this->hasil_lab->delete($data_lab['id']);

        if ($data_pembayaran !== null) $this->pembayaran_model->delete($data_pembayaran['id']);

        $this->customerModel->delete($id_customer);

        $this->session->setFlashdata("success", "Berhasil hapus data customer");
        return redirect()->to("/backoffice/registrasi");
    }

    // public function peserta_hadir(int $id_peserta)
    // {
    //     if (!$this->session->has('logged_in')) {
    //         $this->session->setFlashdata("error", "Anda perlu login terlebih dahulu");
    //         $this->session->set("redirecting", "/");
    //     }
    // }

    public function hadirkan_peserta(int $id_peserta)
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if ($user_level == 1 || $user_level == 100) {
        } else {
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        }


        $data_customer = $this->customerModel->find($id_peserta);
        if ($data_customer !== null) :
            $status_kehadiran = intval($data_customer['kehadiran']);
            if ($status_kehadiran == 20) {
                if ($this->updateHadirkanPeserta($id_peserta)) {
                    $this->session->setFlashdata('success', 'Berhasil update data peserta untuk hadir');
                    return redirect()->to('/backoffice/peserta/' . $id_peserta);
                } else {
                    // $this->session->setFlashdata('error', 'Gagal update data peserta untuk hadir');
                    return redirect()->to('/backoffice/peserta/' . $id_peserta);
                }
            } elseif ($status_kehadiran == 21) {
                $this->session->setFlashdata("success", "Peserta sudah hadir");
                return redirect()->to("/backoffice/peserta/" . $id_peserta);
            } else {
                $this->session->setFlashdata("error", "Fraud peserta");
                return redirect()->to("/backoffice/registrasi");
            }
        else :
            $this->session->setFlashdata("error", "Peserta tidak ditemukan");
            return redirect()->to("/backoffice/registrasi");
        endif;
    }

    public function kehadiran_by_scanning_qr($id_peserta)
    {
        $update_peserta_by_qr = $this->updated_by_qr($id_peserta);
        $responseCode = $update_peserta_by_qr['responseCode'];
        $responseMessage = $update_peserta_by_qr['message'];
        $statusMessage = $update_peserta_by_qr['statusMessage'];
        switch ($responseCode) {
            case '00':
                $this->session->setFlashdata("success", $responseMessage);
                break;
            case '10':
                $this->session->setFlashdata("success", $responseMessage);
                break;
            default:
                $this->session->setFlashdata("error", $responseMessage);
                break;
        }
        $customerDetail = $this->customerModel->detail_customer($id_peserta);
        $nama_customer = $customerDetail['nama'];
        $order_id = $customerDetail['customer_unique'];
        $invoice_number = $customerDetail['invoice_number'];
        $bilik = $customerDetail['nomor_bilik'];
        $no_antrian = $customerDetail['no_antrian'];
        // $message = $responseMessage;

        $data = [
            'title' => "Kehadiran Peserta",
            'response' => $update_peserta_by_qr,
            'page' => "peserta",
            'nama' => $nama_customer,
            'order_id' => $order_id,
            'message' => $responseMessage,
            'invoice_number' => $invoice_number,
            'bilik' => $bilik,
            'no_antrian' => $no_antrian,
            'status' => $statusMessage
        ];
        return view("customer/kehadiran", $data);
    }

    protected function updated_by_qr($id_peserta): array
    {

        $this->pembayaran_model = new PembayaranModel();
        $this->kehadiran_model = new KehadiranModel();

        $today = date("Y-m-d");
        $customerDetail = $this->customerModel->detail_customer($id_peserta);
        $pembayaran_detail = $this->pembayaran_model->pembayaran_by_customer($id_peserta);

        if ($customerDetail != null && $pembayaran_detail != null) {
            /**
             * cek pembayaran di midtrans juga untuk menghindari data yg tidak benar
             */
            $order_id = $customerDetail['customer_unique'];
            $status_pembayaran = $pembayaran_detail['status_pembayaran'];
            if ($status_pembayaran == "Belum Lunas" || $status_pembayaran == "belum lunas") {
                $array_return = array(
                    'statusMessage' => "failed",
                    'message' => "<h4 class='badge badge-danger'>Gagal absen untuk hadir karena belum melakukan pembayaran</h4>",
                    'responseCode' => "01"
                );
                return $array_return;
            }

            $tgl_kunjungan = $customerDetail['tgl_kunjungan'];

            if ($today != $tgl_kunjungan) {
                $array_return = array(
                    'statusMessage' => "failed",
                    'message' => "<h4 class='badge badge-danger'>Gagal absen untuk hadir karena tidak sesuai tanggal kunjungan. 
                    Silahkan melakukan validasi absensi kehadiran pada klinik pada tanggal: {$tgl_kunjungan}</h4>",
                    'responseCode' => "01"
                );
                return $array_return;
            }
            $statusKehadiran = intval($customerDetail['kehadiran']);
            $statusPembayaran = lcfirst($pembayaran_detail['status_pembayaran']);
            if ($statusKehadiran == 22 && ($statusPembayaran == 'settlement' || $statusPembayaran == 'Invoice' || $statusPembayaran == "lunas")) {
                $created_by = ($this->session->has('id_user')) ? $this->session->get('id_user') : '0';
                $dataCustomer = array(
                    'kehadiran' => 23
                );
                $updateCustomer = $this->customerModel->update($id_peserta, $dataCustomer);
                $insertDataHadir = array('id_customer' => $id_peserta, 'created_by' => $created_by);
                $insertKehadiran = $this->kehadiran_model->insert($insertDataHadir);
                if ($updateCustomer && $insertKehadiran) {
                    $array_return = array(
                        'statusMessage' => "success",
                        'message' => "<span class='badge badge-success'>Berhasil absen untuk hadir</span>",
                        'responseCode' => "00"
                    );
                    return $array_return;
                } else {
                    $this->session->setFlashdata('error', 'Gagal update data peserta');
                    $array_return = array(
                        'statusMessage' => "failed",
                        'message' => "<span class='badge badge-danger'>Peserta Tidak Ditemukan</span>",
                        'responseCode' => "01"
                    );
                    return $array_return;
                }
            } else if ($statusKehadiran == 23) {
                $array_return = array(
                    'statusMessage' => "success",
                    'message' => "<span class='badge badge-success'>Peserta sudah hadir</span>",
                    'responseCode' => "10"
                );
                return $array_return;

                // return false;
            } elseif ($statusPembayaran == "pending" || $statusPembayaran == "belum lunas") {
                $this->session->setFlashdata('error', 'Peserta belum melakukan pelunasan');
                $array_return = array(
                    'statusMessage' => "failed",
                    'message' => "<span class='badge badge-warning'>Peserta belum melakukan pelunasan</span>",
                    'responseCode' => "02"
                );
                return $array_return;
            }
        } else {
            $this->session->setFlashdata('error', 'Peserta tidak ditemukan');
            $array_return = array(
                'statusMessage' => "failed",
                'message' => "<span class='badge badge-danger'>Peserta tidak ditemukan</span>",
                'responseCode' => "03"
            );
            return $array_return;
        }
    }

    protected function updateHadirkanPeserta($id_peserta)
    {

        $customerDetail = $this->customerModel->find($id_peserta);
        if ($customerDetail) {
            $statusKehadiran = intval($customerDetail['kehadiran']);
            $statusPembayaran = $customerDetail['status_pembayaran'];
            if ($statusKehadiran == 20 && ($statusPembayaran == 'paid' || $statusPembayaran == 'invoice')) {
                $dataCustomer = array(
                    'kehadiran' => 21
                );
                $updateCustomer = $this->customerModel->update($id_peserta, $dataCustomer);
                $insertDataHadir = array('id_customer' => $id_peserta);
                $insertKehadiran = db_connect()->table('kehadiran')->insert($insertDataHadir);
                if ($updateCustomer && $insertKehadiran) {
                    return true;
                } else {
                    $this->session->setFlashdata('error', 'Gagal update data peserta');
                    return false;
                }
            } else {
                $this->session->setFlashdata('error', 'Peserta belum melakukan pelunasan');
                return false;
            }
        }
    }

    protected function validasi_peserta()
    {
        $validation = $this->validate([
            'tgl_kunjungan' => [
                'rules' => 'required',
                'erros' => [
                    'required' => 'Tanggal kunjungan harus dipilih'
                ]
            ],
            'jam_kunjungan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam kunjungan harus dipilih'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' =>
                [
                    'required' => '{field} lengkap harus diisi',
                ]
            ],
            'nik' => [
                'rules' => 'required|min_length[nik,16]|max_length[nik,16]',
                'errors' =>
                [
                    'required' => '{field} harus diisi',
                    'min_length' => 'Panjang karakter {nik} minimal 16 karakter',
                    'max_length' => 'Panjang karakter {nik} maksimal 16 karakter'
                ]
            ],
            'phone' => [
                'rules' => 'required|min_length[phone, 8]|max_length[phone,14]',
                'erros' =>
                [
                    'required' => 'No HP harus diisi',
                    'min_length' => 'Panjang nomor HP minimal 8 karakter',
                    'max_length' => 'Karakter nomor HP terlalu panjang'
                ]
            ],
            'email' =>  [
                'rules' => 'required',
                'errors' =>
                [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ]
        ]);
        if (!$validation) {
            return redirect()->back()->withInput();
        } else {
            return true;
        }
    }
}
