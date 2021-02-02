<?php

namespace App\Controllers\backoffice;

use App\Models\InstansiModel;
use App\Models\KotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\TestModel;
use App\Controllers\BaseController;
use App\Controllers\Customer;
use App\Models\CustomerHomeServiceModel;
use App\Models\CustomerModel;
use App\Models\FaskesModel;
use App\Models\PembayaranModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use CodeIgniter\RESTful\ResourceController;
use Dompdf\Cpdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Home_service extends ResourceController
{
    public $session;
    protected $kotaModel;
    protected $marketingModel;
    protected $customer_model;
    protected $jenis_layanan_test_model;
    protected $layanan_model;
    protected $test_model;
    protected $pembayaran_model;
    protected $instansiModel;
    public $customer_home_service_model;
    protected $pemeriksaModel;
    protected $jenisPemeriksaanModel;
    protected $faskesModel;
    protected $layananTestModel;
    protected $testModel;
    protected $layananModel;
    protected $CustomerPublic;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->kotaModel = new KotaModel();
        $this->marketingModel = new MarketingModel();
        $this->instansiModel = new InstansiModel();
        $this->customer_model = new CustomerModel();
        $this->jenis_layanan_test_model = new LayananTestModel();
        $this->layanan_model = new LayananModel();
        $this->test_model = new TestModel();
        $this->pembayaran_model = new PembayaranModel();
        $this->customer_home_service_model = new CustomerHomeServiceModel();
        $this->pemeriksaModel = new PemeriksaModel();
        $this->jenisPemeriksaanModel = new PemeriksaanModel();
        $this->faskesModel = new FaskesModel();
        $this->layananTestModel = new LayananTestModel();
        $this->testModel = new TestModel();
        $this->layananModel = new LayananModel();
        $this->CustomerPublic = new Customer;
    }
    public function index()
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/backoffice');


        $page = "home_service";
        $customers_home_service = $this->customer_home_service_model->findAll();
        $data = array(
            'title' => "Data Home Service",
            'page' => $page,
            'session' => session(),
            'customers_home_service' => $customers_home_service,
            'customer_model' => $this->customer_model,
            'marketingModel' => $this->marketingModel,
            'instansiModel' => $this->instansiModel
        );
        return view('backoffice/' . $page . '/index_' . $page, $data);
    }

    public function detail(int $id_customer_hs)
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/backoffice');
        $page = "home_service";
        $customers_home_service = $this->customer_home_service_model->find($id_customer_hs);
        $data = array(
            'title' => "Detail Data Home Service",
            'page' => $page,
            'session' => session(),
            'customers_home_service' => $customers_home_service,
            'customer_model' => $this->customer_model->where(['id_hs' => $id_customer_hs])->get()->getResultArray(),
            'marketingModel' => $this->marketingModel,
            'instansiModel' => $this->instansiModel,
            'pembayaran_model' => $this->pembayaran_model
        );
        return view('backoffice/' . $page . '/detail_' . $page, $data);
    }

    public function create()
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

        $dataPemeriksa = $this->pemeriksaModel->findAll();
        // dd($dataPemeriksa);
        $dataJenisPemeriksaan = $this->jenisPemeriksaanModel->findAll();
        $dataFaskes = $this->faskesModel->findAll();
        $dataInstanasi = $this->instansiModel->findAll();
        $dataMarketing = $this->marketingModel->findAll();

        $kondisi_layanan_test = ['id_segmen' => "1", 'id_pemeriksaan' => "2"];
        $dataLayananTest = $this->layananTestModel->where($kondisi_layanan_test)->get()->getResultArray();
        $data = array(
            'title' => "Form Registrasi Home Service",
            'page' => "home_service",
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
        return view('backoffice/home_service/create_peserta', $data);
    }

    public function save()
    {
        try {
            $token = $this->request->getVar('token');
            if (!$token) {
                return $this->failUnauthorized();
            }
            $peserta = $this->request->getVar('peserta');
            $list_peserta = count($peserta);
            if ($list_peserta < 5) {
                $this->session->setFlashdata('error', "Daftar peserta yang di daftarkan minimal adalah 5 orang");
                return redirect()->to("/home-service");
            }
            $array_insert = array();
            $ids = array();
            $harga_test = 0;
            $product_name = array();
            $is_hs = $this->request->getVar("is_hs");

            if ($is_hs) {
                $p = $peserta[0];
                $detail_jenis_test = $this->layananTestModel->find($p['jenis_test']);
                $detail_layanan = $this->layananModel->find($detail_jenis_test['id_layanan']);
                $detail_test = $this->testModel->find($detail_jenis_test['id_test']);
                $jenis_pemeriksaan = $detail_jenis_test['id_pemeriksaan'];
                $jenis_layanan = $detail_jenis_test['id_layanan'];
                $jenis_test = $p['paket_pemeriksaan'];
                $tgl_kunjungan = $p['tgl_kunjungan'];
                $jam_kunjungan = $p['jam_kunjungan'];
                $jenis_kelamin = $p['jenis_kelamin'];
                $tempat_lahir = $p['tempat_lahir'];
                $tgl_lahir = $p['tgl_lahir'];
                $alamat = $p['alamat'];
                $instansi = $p['instansi'];
                $marketing = $p['id_marketing'];

                $customer_UNIQUE = $this->CustomerPublic->getOrderId($jenis_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan);
                $no_urutan = $this->CustomerPublic->getUrutan($jenis_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);

                $array_insert = array(
                    'jenis_test' => $p['jenis_test'],
                    'jenis_pemeriksaan' => $jenis_pemeriksaan,
                    'jenis_layanan' => $jenis_layanan,
                    'faskes_asal' => $p['faskes_asal'],
                    'customer_unique' => $customer_UNIQUE,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tgl_lahir,
                    'alamat' => $alamat,
                    'no_urutan' => $no_urutan,
                    'id_marketing' => $marketing,
                    'instansi' => $instansi,
                    'status_test' => 'menunggu',
                    'tahap' => 1,
                    'kehadiran' => '22',
                    'no_antrian' => '0',
                    'jam_kunjungan' => $jam_kunjungan,
                    'tgl_kunjungan' => $tgl_kunjungan,
                    'status_pembayaran' => 'invoice',
                    'status_peserta' => "20"
                );
                $this->customer_home_service_model->insert($array_insert);
                $id_hs = $this->customerModel->getInsertID();

                $InvoiceCustomerHs = $this->generate_invoice($id_hs);
                $this->customer_home_service_model->update($id_hs, ['invoice_number' => $InvoiceCustomerHs]);

                foreach ($peserta as $key => $p) {
                    $detail_jenis_test = $this->layananTestModel->find($p['jenis_test']);
                    $detail_layanan = $this->layananModel->find($detail_jenis_test['id_layanan']);
                    $detail_test = $this->testModel->find($detail_jenis_test['id_test']);
                    $jenis_pemeriksaan = $detail_jenis_test['id_pemeriksaan'];
                    $jenis_layanan = $detail_jenis_test['id_layanan'];
                    $jenis_test = $p['paket_pemeriksaan'];
                    $tgl_kunjungan = $p['tgl_kunjungan'];
                    $jam_kunjungan = $p['jam_kunjungan'];
                    $jenis_kelamin = $p['jenis_kelamin'];
                    $tempat_lahir = $p['tempat_lahir'];
                    $tgl_lahir = $p['tgl_lahir'];
                    $alamat = $p['alamat'];
                    $instansi = $p['instansi'];
                    $marketing = $p['id_marketing'];

                    $customer_UNIQUE = $this->CustomerPublic->getOrderId($jenis_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan);
                    $no_urutan = $this->CustomerPublic->getUrutan($jenis_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);

                    $array_insert = array(
                        'jenis_test' => $p['jenis_test'],
                        'jenis_pemeriksaan' => $jenis_pemeriksaan,
                        'jenis_layanan' => $jenis_layanan,
                        'faskes_asal' => $p['faskes_asal'],
                        'customer_unique' => $customer_UNIQUE,
                        'jenis_kelamin' => $jenis_kelamin,
                        'tempat_lahir' => $tempat_lahir,
                        'tanggal_lahir' => $tgl_lahir,
                        'alamat' => $alamat,
                        'no_urutan' => $no_urutan,
                        'id_marketing' => $marketing,
                        'instansi' => $instansi,
                        'status_test' => 'menunggu',
                        'tahap' => 1,
                        'kehadiran' => '22',
                        'status_peserta' => "20",
                        'no_antrian' => '0',
                        'jam_kunjungan' => $jam_kunjungan,
                        'tgl_kunjungan' => $tgl_kunjungan,
                        'status_pembayaran' => 'Invoice',
                        'is_hs' => "yes",
                        'id_hs' => $id_hs
                    );
                    $this->customerModel->insert($array_insert);
                    $id_customer = $this->customerModel->getInsertID();

                    $InvoiceCustomer = $this->CustomerPublic->getInvoiceNumber($id_customer);
                    $this->customerModel->update($id_customer, ['invoice_number' => $InvoiceCustomer]);
                    $DetailLayananTest = $this->layananModel->find($jenis_pemeriksaan);
                    $productName = $DetailLayananTest['nama_test'] . ' ' . $DetailLayananTest['nama_layanan'];
                    $detail_transaction = array(
                        'customer_unique' => $InvoiceCustomer,
                        'biaya' => $harga_test,
                        'product_name' => $product_name,

                    );

                    $array_insert_pembayaran = array(
                        'id_customer' => $id_customer,
                        'tipe_pembayaran' => "langsung",
                        'amount' => $detail_jenis_test['biaya'],
                        'jenis_pembayaran' => "Invoice",
                        'status_pembayaran' => "Invoice"
                    );
                    $this->pembayaran_model->insert($array_insert_pembayaran);
                    // $harga_test += $detail_jenis_test['biaya'];
                    // $product_name[] = $detail_test['nama_test'] . " " . $detail_layanan['nama_layanan'];
                }
            }
            $array_result = array('statusMessage' => 'success', 'id_hs' => $id_hs, 'total_customers' => count($peserta));
            return $this->respond($array_result, 200, 'success');
            // $this->customerModel->insertBatch($array_insert);
            // $last_inserted = $this->customerModel->getInsertID();


            // return $this->midtrans_transaction_get_token("2", )
        } catch (\Throwable $th) {
            return $this->failServerError('failed', 500, 'failed');
        }
    }

    public function generate_invoice($id_customer)
    {
        $data = $this->customer_home_service_model->find($id_customer);

        $word1 = 'INV-';
        $date = date('ymd');
        if (!is_array($id_customer)) {
            $urutan = $data['no_antrian'];
        } else {
            $urutan =  1;
        }

        $generateUrutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);

        $invoice = $word1 . $date . $generateUrutan;
        return $invoice;
    }

    public function delete_peserta(int $id_customer_hs)
    {
        if (!$this->session->has('logged_in')) return redirect()->to('/backoffice');

        $check_hs = $this->customer_home_service_model->find($id_customer_hs);
        if ($check_hs) {
        }
    }
}
