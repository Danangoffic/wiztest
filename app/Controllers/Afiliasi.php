<?php

namespace App\Controllers;

use App\Controllers\backoffice\Layanan;
use App\Controllers\backoffice\Midtrans;
use App\Controllers\backoffice\SystemParameter;
use App\Controllers\backoffice\Whatsapp_service;
use App\Models\AfiliasiModel;
use App\Models\AlatModel;
use App\Models\CustomerCorporateModel;
use App\Models\CustomerHomeServiceModel;
use App\Models\CustomerModel;
use App\Models\DataFileCorporateModel;
use App\Models\DokterModel;
use App\Models\HasilLaboratoriumModel;
use App\Models\InstansiModel;
use App\Models\KuotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PembayaranModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\SampleModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\RESTful\ResourceController;
use PHPExcel;
use PHPExcel_IOFactory;

class Afiliasi extends ResourceController
{
    protected $systemparam;
    protected $layananModel;
    protected $pemeriksaanModel;
    protected $testModel;
    protected $layananTestModel;
    protected $customerModel;
    protected $kuotaModel;
    protected $PembayaranModel;
    protected $status_model;
    protected $marketing_model;
    protected $hasil_test;
    protected $dokter_model;
    protected $alat_model;
    protected $sample_model;
    protected $petugas_model;
    protected $layanan_controller;
    protected $afiliasi_model;
    protected $page;
    protected $instansi_model;
    protected $session;
    protected $midtrans_bo;
    protected $customers_controller;
    protected $customer_corporate;
    protected $customer_home_service;

    public function __construct()
    {
        $this->systemparam = new SystemParameter;
        $this->layananModel = new LayananModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->customerModel = new CustomerModel();
        $this->kuotaModel = new KuotaModel();
        $this->PembayaranModel = new PembayaranModel();
        $this->status_model = new StatusHasilModel();
        $this->marketing_model = new MarketingModel();
        $this->hasil_test = new HasilLaboratoriumModel();
        $this->dokter_model = new DokterModel();
        $this->alat_model = new AlatModel();
        $this->sample_model = new SampleModel();
        $this->petugas_model = new PemeriksaModel();
        $this->layanan_controller = new Layanan;
        $this->afiliasi_model = new AfiliasiModel();
        $this->instansi_model = new InstansiModel();
        $this->page = "afiliasi";
        $this->session = \Config\Services::session();
        $this->midtrans_bo = new Midtrans;
        $this->customers_controller = new Customer;
        $this->customer_corporate = new CustomerCorporateModel();
        $this->customer_home_service = new CustomerHomeServiceModel();
        helper('form');
    }


    public function corporate($id_instansi = null)
    {
        if ($id_instansi == null) {
            return redirect()->to("/");
        }
        $data_instansi = $this->instansi_model->detail_instansi($id_instansi);
        if ($data_instansi == null) {
            $this->session->setFlashdata('error', "Corporate tidak ditemukan");
            return redirect()->to("/");
        }
        $is_afiliated = $data_instansi['afiliated'];
        if ($is_afiliated == "no") {
            $this->session->setFlashdata('error', "Corporate tidak ditemukan dalam afiliasi, untuk dapatkan afiliasi, anda bisa kontak pada marketing kami");
            return redirect()->to("/");
        }
        $id_marketing = $data_instansi['pic_marketing'];
        $data_marketing = $data_marketing = $this->marketing_model->find($id_marketing);

        $layanan_test_data = $this->layananTestModel
            ->by_keys(['id_pemeriksaan' => '1', 'id_segmen' => '2'])
            ->groupBy('id_test')
            ->get()
            ->getResultArray();
        // dd(db_connect()->showLastQuery());
        // $getData = $this->sysParamModel->getByVgroupAndParamter('MIDTRANS_KEY', 'CLIENT_KEY');
        $data = [
            'title' => "Quicktest.id || Pendaftaran Test Afiliasi Corporate " . $data_instansi['nama'],
            'subtitle1' => ucwords("form pendaftaran test"),
            'marketings' => $data_marketing,
            'jenis_test' => $this->testModel,
            'layanan_test_data' => $layanan_test_data,
            'data_instansi' => $data_instansi,
            'data_marketing' => $data_marketing,
            'id_instansi' => $id_instansi,
            'id_marketing' => $data_marketing['id'],
            'session' => $this->session
        ];
        return view('customer/corporate', $data);
    }

    public function home_service($id_marketing = null)
    {
        if ($id_marketing == null) {
            return redirect()->to("/");
        }

        $validasi_marketing = $this->marketing_model->find($id_marketing);
        if ($validasi_marketing !== null) {
            $is_afiliated = $validasi_marketing['is_afiliated_hs'];
            if ($is_afiliated == "no") {
                $this->session->setFlashdata('error', 'Link afiliasi yang anda gunakan belum tersedia');
                return redirect()->to("/");
            }
            $data_marketing = $data_marketing = $this->marketing_model->find($id_marketing);

            $layanan_test_data = $this->layananTestModel
                ->where(['id_pemeriksaan' => '1', 'id_segmen' => '2'])->groupBy('id_test')->get()->getResultArray();
            // $getData = $this->sysParamModel->getByVgroupAndParamter('MIDTRANS_KEY', 'CLIENT_KEY');
            $data = [
                'title' => "Quicktest.id || Pendaftaran Afiliasi Home Service Melalui " . $data_marketing['nama_marketing'],
                'subtitle1' => ucwords("form pendaftaran test"),
                'marketings' => $data_marketing,
                'jenis_test' => $this->testModel,
                'layanan_test_data' => $layanan_test_data,
                'marketing' => $id_marketing
            ];
            return view('customer/home_service', $data);
        }
    }

    public function save_corporate()
    {
        $fileexcel = $this->request->getFile("excel");
        if ($fileexcel) {
            $id_instansi = $this->request->getPost('id_instansi');
            $id_marketing = $this->request->getPost("id_marketing");
            $tgl_kunjungan = $this->request->getPost("tgl_kunjungan");
            $jam_kunjungan = $this->request->getPost("jam_kunjungan");
            $id_layanan_test = $this->request->getPost("id_layanan");
            $faskes_asal = 3;

            $detail_layanan_test = $this->layananTestModel->find($id_layanan_test);

            $jenis_test = $detail_layanan_test['id'];
            $id_test = $detail_layanan_test['id_test'];
            $jenis_layanan = $detail_layanan_test['id_layanan'];
            $jenis_pemeriksaan = $detail_layanan_test['id_pemeriksaan'];
            $biaya_test = $detail_layanan_test['biaya'];

            $detail_instansi = $this->instansi_model->detail_instansi($id_instansi);

            $nama_instansi = $detail_instansi['nama'];

            $Layanan = new Layanan();

            $new_name_file = $nama_instansi . "-" . date('dmYHis') . "{$id_instansi}-" . $fileexcel->getRandomName();
            $excelReader  = new PHPExcel();
            //mengambil lokasi temp file
            $fileLocation = $fileexcel->getTempName();
            //baca file
            $objPHPExcel = PHPExcel_IOFactory::load($fileLocation);
            //ambil sheet active
            $sheet    = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            foreach ($sheet as $idx => $data) {
                if ($idx == 1) {
                    continue;
                }
                $nama = $data['A'];
                $nik = $data['B'];
                $email = $data['C'];
                $jenis_kelamin = $data['D'];
                $phone = $data['E'];
                $tempat_lahir = $data['F'];
                $tgl_lahir = $data['G'];
                $alamat = $data['H'];
                if ($nama == "" || $nama == null) {
                    break;
                }
                $customer_UNIQUE = $this->customers_controller->getOrderId($id_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan);
                $no_urutan = $this->customers_controller->getUrutan($id_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan, $jam_kunjungan);

                $dataMarketing = $this->marketing_model->find($id_marketing);
                $dataLayanan = $this->layananModel->find($jenis_layanan);

                if ($id_test == 2 || $id_test == "2" || $id_test == 3 || $id_test == "3") {
                    $nomor_bilik = 3;
                } else {
                    $hitung_bilik = $no_urutan % 7;
                    if ($hitung_bilik == 0 || $hitung_bilik == 3) {
                        $hitung_bilik++;
                    }
                    $nomor_bilik = $hitung_bilik;
                }

                if ($idx == 2) {
                    $data_insert_corporate = [
                        'nama' => $nama,
                        'email' => $email,
                        'nik' => $nik,
                        'phone' => $phone,
                        'jenis_test' => $jenis_test,
                        'jenis_pemeriksaan' => $jenis_pemeriksaan,
                        'jenis_layanan' => $jenis_layanan,
                        'faskes_asal' => $faskes_asal,
                        'customer_unique' => $customer_UNIQUE,
                        'jenis_kelamin' => $jenis_kelamin,
                        'tempat_lahir' => $tempat_lahir,
                        'tanggal_lahir' => $tgl_lahir,
                        'alamat' => $alamat,
                        'id_marketing' => $id_marketing,
                        'instansi' => $id_instansi,
                        'status_test' => 'menunggu',
                        'tahap' => 1,
                        'kehadiran' => '22',
                        'no_antrian' => $no_urutan,
                        'nomor_bilik' => $nomor_bilik,
                        'jam_kunjungan' => $jam_kunjungan,
                        'tgl_kunjungan' => $tgl_kunjungan,
                        'status_pembayaran' => 'invoice',
                        'status_peserta' => "20",
                    ];
                    $insert_corporate = $this->customer_corporate->insert($data_insert_corporate);
                    if (!$insert_corporate) {
                        $this->session->setFlashdata('error', "Gagal tambahkan data peserta corporate tahap 1");
                        return redirect()->back();
                        // return $this->failValidationError();
                    }
                    $id_inserted = $this->customer_corporate->getInsertID();

                    $invoice_corporate = $this->afiliasi_invoice($id_inserted, "corporate");
                    $arr_invoice_corporate = ['invoice_number' => $invoice_corporate];
                    $this->customer_corporate->update($id_inserted, $arr_invoice_corporate);
                }

                $DataInsertCustomer = [
                    'nama' => $nama,
                    'email' => $email,
                    'nik' => $nik,
                    'phone' => $phone,
                    'jenis_test' => $jenis_test,
                    'jenis_pemeriksaan' => $jenis_pemeriksaan,
                    'jenis_layanan' => $jenis_layanan,
                    'faskes_asal' => $faskes_asal,
                    'customer_unique' => $customer_UNIQUE,
                    'jenis_kelamin' => $jenis_kelamin,
                    'tempat_lahir' => $tempat_lahir,
                    'tanggal_lahir' => $tgl_lahir,
                    'alamat' => $alamat,
                    'id_marketing' => $id_marketing,
                    'instansi' => $id_instansi,
                    'status_test' => 'menunggu',
                    'tahap' => 1,
                    'kehadiran' => '22',
                    'no_antrian' => $no_urutan,
                    'nomor_bilik' => $nomor_bilik,
                    'jam_kunjungan' => $jam_kunjungan,
                    'tgl_kunjungan' => $tgl_kunjungan,
                    'status_pembayaran' => 'Invoice',
                    'status_peserta' => "20",
                    'is_corporate' => "yes",
                    'id_corporate' => $id_inserted
                ];
                $insert_customer = $this->customerModel->insert($DataInsertCustomer);

                if ($insert_customer) {
                    $insert_id = $this->customerModel->getInsertID();
                } else {
                    $this->session->setFlashdata('error', "Gagal tambahkan data peserta corporate tahap 2");
                    return redirect()->back();
                }
                $InvoiceCustomer = $this->customers_controller->getInvoiceNumber($insert_id);
                $arr_invoice = ['invoice_number' => $InvoiceCustomer];
                $this->customerModel->update($insert_id, $arr_invoice);

                $data_pembayaran = [
                    'id_customer' => $insert_id,
                    'tipe_pembayaran' => "langsung",
                    'amount' => $biaya_test,
                    'jenis_pembayaran' => "Invoice",
                    'status_pembayaran' => "Invoice"
                ];
                $insert_pembayaran = $this->PembayaranModel->insert($data_pembayaran);
                if (!$insert_pembayaran) {
                    $this->session->setFlashdata('error', "Gagal tambahkan data peserta corporate tahap 2");
                    return redirect()->back();
                }
                $this->send_email_customer_afiliasi($insert_id);
                $this->send_whatsapp_customer_afiliasi($insert_id);
            }
            $fileexcel->move("/assets/corporate/", $new_name_file);
            $data_file_corporate_model = new DataFileCorporateModel();
            $array_insert = [
                'nama_file' => $new_name_file,
                'id_instansi' => $id_instansi,
                'id_cust_corporate' => $id_inserted,
                'created_by' => '999',
                'updated_by' => '999'
            ];
            $data_file_corporate_model->insert($array_insert);
            // $data_file_corporate_model->getInsertID()
            $this->session->setFlashdata('succcess', "Berhasil Submit Data Peserta Pada Kami");
            return redirect()->to('/afiliasi/corporate/' . $id_instansi);
        } else {
            $this->session->setFlashdata('error', "Gagal Submit Data Peserta Pada Kami");
            return redirect()->back();
        }
    }

    public function afiliasi_invoice($id, $tipe)
    {
        switch ($tipe) {
            case 'corporate':
                $word1 = "COR{$id}-";
                $random = rand(1000, 9999);
                $generateUrutan = str_pad($id, 4, '0', STR_PAD_LEFT);
                $invoice = $word1 . date("ymd") . $random . $generateUrutan;
                return $invoice;
                break;
            case 'home service':
                $word1 = "HS{$id}-";
                $random = rand(1000, 9999);
                $generateUrutan = str_pad($id, 4, '0', STR_PAD_LEFT);
                $invoice = $word1 . date("ymd") . $random . $generateUrutan;
                return $invoice;
                break;
            case 'rujukan':
                $word1 = "RJ{$id}-";
                $random = rand(1000, 9999);
                $generateUrutan = str_pad($id, 4, '0', STR_PAD_LEFT);
                $invoice = $word1 . date("ymd") . $random . $generateUrutan;
                return $invoice;
                break;
            default:
                # code...
                break;
        }
    }

    public function send_email_customer_afiliasi($id_customer = null)
    {
        $Layanan = new Layanan;

        $Email = \Config\Services::email();

        // $Email->initialize($config);

        // $id_cust = $data_customer['id'];
        $CustomerDetail = $this->customerModel->detail_customer($id_customer);
        $emailCustomer = $CustomerDetail['email'];
        $id_customer = $CustomerDetail['id'];
        // $nama_customer = $CustomerDetail['nama'];
        $invoice_number = $CustomerDetail['invoice_number'];

        // $PaymentDetail = $this->PembayaranModel->pembayaran_by_customer($id_customer);
        $qr_image = $Layanan->getUrlQRCode(base_url('api/hadir/' . $id_customer));

        $tgl_kunjungan = $CustomerDetail['tgl_kunjungan'];
        $jam_kunjungan = $CustomerDetail['jam_kunjungan'];
        $nama = $CustomerDetail['nama'];
        $no_reg = $CustomerDetail['customer_unique'];
        $title = "Informasi Pembayaran dan Pendaftaran Pada Quictest.id";
        $pdf_file = base_url('api/print_invoice/no-ttd/' . $invoice_number . "?attachment=1");

        $data_email = array(
            'no_reg' => $no_reg,
            'nama' => $nama,
            'title' => $title,
            'qr_image' => $qr_image,
            'pdf_file' => $pdf_file,
            'informasi' => "Terima kasih telah melakukan pembayaran pada kami, berikut kami berikan gambar QR Code untuk anda 
                                    hadir pada tempat kami saat melakukan konfirmasi kedatangan 
                                    pada tanggal {$tgl_kunjungan} 
                                    pukul {$jam_kunjungan}."
        );

        $emailMessage = view('send_email_afiliasi', $data_email);

        $Email->setTo($emailCustomer);
        $Email->setFrom('pendaftaran@quicktest.id', 'Pendaftaran QuickTest.id');
        $Email->setSubject($title);
        $Email->setMessage($emailMessage);
        $Email->attach($qr_image, 'inline', "qr_code_quictest.png", "image/png");
        $Email->attach(
            $pdf_file,
            'inline',
            "Invoice " . $CustomerDetail['nama'] . " - {$invoice_number}.pdf",
            "application/pdf"
        );
        if ($Email->send()) {
            return true;
        } else {
            $data = $Email->printDebugger(['headers']);
            print_r($data);
        }
    }

    public function send_whatsapp_customer_afiliasi($id_customer = null)
    {
        if ($id_customer != null) {
            $whatsapp_service = new Whatsapp_service;
            $whatsapp_service->send_whatsapp_QR($id_customer);
            $whatsapp_service->send_whatsapp_invoice($id_customer);
        } else {
            return false;
        }
    }
}
