<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\CustomerModel;
use App\Models\TestModel;
use App\Models\LayananTestModel;
use App\Models\LayananModel;
use App\Models\MarketingModel;
use App\Models\CustomerRujukanModel;
use App\Models\RujukanModel;
use App\Models\PembayaranModel;


class Rujukan extends ResourceController
{
    protected $systemparam;
    protected $layananModel;
    protected $pemeriksaanModel;
    protected $testModel;
    protected $layananTestModel;
    protected $customerModel;
    public $kuotaModel;
    public $PembayaranModel;
    protected $status_model;
    protected $marketing_model;
    protected $hasil_test;
    protected $dokter_model;
    protected $alat_model;
    protected $sample_model;
    protected $petugas_model;
    protected $layanan_controller;
    protected $CustomerHomeServiceModel;
    // protected $layanan_test_model;
    protected $midtrans_bo;
    protected $afiliasi;
    protected $customer_rujukan_model;
    protected $rujukan_model;
    protected $customers_controller;

    function __construct()
    {
        $this->customerModel = new CustomerModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->layananModel = new LayananModel();
        $this->customer_rujukan_model = new CustomerRujukanModel();
        $this->rujukan_model = new RujukanModel();
        $this->customers_controller = new Customer;
        $this->PembayaranModel = new PembayaranModel();
    }

    public function indexv2($id_rujukan = null)
    {
        $this->marketing_model = new MarketingModel();

        $layanan_test_data = $this->layananTestModel->by_keys(['id_pemeriksaan' => '1', 'id_segmen' => '2'])
            ->groupBy('id_test')
            ->get()
            ->getResultArray();
        $data_rujukan = $this->rujukan_model->find($id_rujukan);
        $pic_marketing = $data_rujukan['pic_marketing'];
        $data_marketing = $this->marketing_model->find($pic_marketing);
        $data = [
            'title' => "Home",
            'marketings' => $data_marketing,
            'jenis_test' => $this->testModel,
            'layanan_test_data' => $layanan_test_data,
            'layanan_model' => $this->layananModel,
            'data_rujukan' => $data_rujukan,
            'marketing' => $pic_marketing,
            'id_rujukan' => $id_rujukan
        ];
        return view('customer/rujukan', $data);
    }

    public function select_test()
    {
        $this->testModel = new TestModel();
        $this->layananModel = new LayananModel();
        $this->layananTestModel = new LayananTestModel();

        $id_test = $this->request->getVar('id_test');
        $id_jenis_pemeriksaan = $this->request->getVar('type');
        $id_segmen = $this->request->getVar('segmen');
        // $data_test = $this->layananTestModel->where(['id_test' => $id_test, 'id_pemeriksaan' => $id_jenis_pemeriksaan, 'id_segmen' => $id_segmen])->get()->getResultArra();
        // dd($this->request->getVar());
        try {
            $check_data_layanan_test = $this->layananTestModel->where(['id_test' => $id_test, 'id_pemeriksaan' => $id_jenis_pemeriksaan, 'id_segmen' => $id_segmen])->get()->getResultArray();

            if ($check_data_layanan_test != null) {
                $data = array();
                foreach ($check_data_layanan_test as $key => $dlt) {
                    $detail_layanan = $this->layananModel->find($dlt['id_layanan']);
                    $detail_test = $this->testModel->find($dlt['id_test']);
                    $data[] = array(
                        'id' => $dlt['id'],
                        'biaya' => $dlt['biaya'],
                        'nama_layanan' => $detail_layanan['nama_layanan'],
                        'nama_test' => $detail_test['nama_test']
                    );
                }
                if (count($data) > 0) {
                    return $this->respond(array('data' => $data), 200, 'success');
                } else {
                    return $this->failNotFound('not found');
                }
            } else {
                return $this->failNotFound('not found');
            }
            // } else {
            //     return $this->failForbidden();
            // }
        } catch (\Throwable $th) {
            return $this->respond(array('message' => $th->getMessage()), 500, 'error');
        }
    }

    public function save_rujukan()
    {

        $this->marketing_model = new MarketingModel();
        $id_instansi    =   1;
        $id_marketing   =   $this->request->getPost("id_marketing");
        $tgl_kunjungan  =   $this->request->getPost("tgl_kunjungan");
        $jam_kunjungan  =   $this->request->getPost("jam_kunjungan");
        $faskes_asal    =   3;
        $nama           =   $this->request->getPost('nama');
        $email          =   $this->request->getPost('email');
        $phone          =   $this->request->getPost('phone');
        $nik            =   $this->request->getPost('nik');
        $jenis_kelamin  =   $this->request->getPost('jenis_kelamin');
        $tempat_lahir   =   $this->request->getPost('tempat_lahir');
        $tgl_lahir      =   $this->request->getPost('tanggal_lahir');
        $alamat         =   $this->request->getPost('alamat');
        $id_rujukan     =   intval($this->request->getPost('id_rujukan'));
        $id_layanan_test =  $this->request->getPost("jenis_test");

        $detail_layanan_test = $this->layananTestModel->find($id_layanan_test);

        $jenis_test = $detail_layanan_test['id'];
        $id_test = $detail_layanan_test['id_test'];
        $jenis_layanan = $detail_layanan_test['id_layanan'];
        $jenis_pemeriksaan = $detail_layanan_test['id_pemeriksaan'];
        $biaya_test = $detail_layanan_test['biaya'];

        try {
            $customer_UNIQUE = $this->customers_controller->getOrderId($id_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan);
            $no_urutan = $this->customers_controller->getUrutan($id_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan, $jam_kunjungan);

            $dataMarketing = $this->marketing_model->find($id_marketing);
            $dataLayanan = $this->layananModel->find($jenis_layanan);

            if ($jenis_test == 2 || $jenis_test == "2") {
                $nomor_bilik = 1;
            } else if ($jenis_test == 3 || $jenis_test == "3") {
                $nomor_bilik = 2;
            } else {
                $hitung_bilik = 6 % $no_urutan;
                $nomor_bilik = $hitung_bilik + 2;
            }

            $DataInsertCustomerRujukan = array(
                'id_rujukan' => $id_rujukan,
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
                'kehadiran' => '23',
                'no_antrian' => $no_urutan,
                'nomor_bilik' => $nomor_bilik,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => 'invoice',
                'status_peserta' => "20"
            );

            $this->customer_rujukan_model->insert($DataInsertCustomerRujukan);
            $id_cust_rujukan = $this->customer_rujukan_model->getInsertID();

            $afiliasiController = new Afiliasi;
            $invoice_rujukan = $afiliasiController->afiliasi_invoice($id_cust_rujukan, "rujukan");
            $arr_invoice_rujukan = array('invoice_number' => $invoice_rujukan);
            $update_customer_rujukan = $this->customer_rujukan_model->update($id_cust_rujukan, $arr_invoice_rujukan);
            // return $this->respond(['status_message' => db_connect()->showLastQuery()], 500, 'fail');
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
                'status_pembayaran' => 'invoice',
                'status_peserta' => "20",
                'is_rujukan' => "yes",
                'id_cust_rujukan' => $id_cust_rujukan
            ];
            $insert_customer = $this->customerModel->insert($DataInsertCustomer);

            if ($insert_customer) {
                $insert_id = $this->customerModel->getInsertID();
            } else {
                $this->session->setFlashdata('error', "Gagal tambahkan data rujukan service tahap 2");
                return $this->respond(['status_message' => "Gagal tambahkan data rujukan service tahap 2"], 400, 'failed');
            }
            $InvoiceCustomer = $afiliasiController->afiliasi_invoice($insert_id, "rujukan");
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
                $this->session->setFlashdata('error', "Gagal tambahkan data rujukan service tahap 2");
                return $this->respond(['status_message' => "failed"], 400, 'failed');
            }
            $id_pembayaran = $this->PembayaranModel->getInsertID();

            $afiliasiController->send_email_customer_afiliasi($insert_id);
            $afiliasiController->send_whatsapp_customer_afiliasi($insert_id);

            $arrayRespond = array(
                'id_rujukan' => $id_rujukan,
                'id_cust_rujukan' => $id_cust_rujukan,
                'id_customer' => $insert_id,
                'id_marketing' => $id_marketing,
                'id_pembayaran' => $id_pembayaran,
                'status_message' => "success"
            );

            return $this->respond($arrayRespond, 200, 'success');
        } catch (\Throwable $th) {
            return $this->failServerError($th->getMessage());
        }
    }
}
