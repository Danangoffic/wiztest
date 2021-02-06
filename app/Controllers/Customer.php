<?php

namespace App\Controllers;

use App\Controllers\backoffice\Home_service;
use App\Controllers\backoffice\Layanan;
use App\Controllers\backoffice\Midtrans as BackofficeMidtrans;
use App\Controllers\backoffice\SystemParameter;
use App\Models\AlatModel;
use App\Models\CustomerHomeServiceModel;
use App\Models\CustomerModel;
use App\Models\DokterModel;
use App\Models\HasilLaboratoriumModel;
use App\Models\KehadiranModel;
use App\Models\KuotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\MenuModel;
use App\Models\PemanggilanModel;
use App\Models\PembayaranModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\SampleModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SystemParameterModel;
use App\Controllers\Midtrans;

class Customer extends ResourceController
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
    protected $layanan_test_model;
    protected $midtrans_bo;

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
        $this->CustomerHomeServiceModel = new CustomerHomeServiceModel();
        $this->layanan_test_model = new LayananTestModel();
        $this->midtrans_bo = new BackofficeMidtrans;
    }

    public function index()
    {

        $data_marketing = $this->marketing_model->findAll();

        $data = [
            'title' => "Home",
            'marketings' => $data_marketing,
            'midtrans_client_key' => $this->midtrans_bo->client_key,
            'snap_url_js' => $this->midtrans_bo->snap_url_js
        ];
        return view('customer/index', $data);
    }

    public function getMenu()
    {
        $menumodel = new MenuModel();
        try {
            $dataMenu = $menumodel->findAll();
            if (count($dataMenu) > 0) {
                return $this->respond($dataMenu, 200, 'success');
            } else {
                return $this->respond(null, 404, 'not found');
            }
        } catch (\Throwable $th) {
            return $this->failServerError();
        }
    }

    public function registrasi()
    {

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
        $marketing = $this->request->getPost('marketing');
        $jenis_test = $this->request->getPost('jenis_test');
        $detail_layanan_test = $this->layanan_test_model->find($jenis_test);
        $jenis_pemeriksaan = $detail_layanan_test['id_pemeriksaan'];
        $jenis_layanan = $detail_layanan_test['id_layanan'];
        $faskes_asal = $this->request->getPost('faskes_asal');
        $instansi = $this->request->getPost('instansi');
        $kehadiran = 0;
        $tgl_kunjungan = $this->request->getPost('tgl_kunjungan');
        $id_jam_kunjungan = $this->request->getPost('jam_kunjungan');
        $dataJamKunjungan = $this->kuotaModel->find($id_jam_kunjungan);
        $jam_kunjungan = $dataJamKunjungan['jam'];
        // var_dump($this->request->getPost());
        // exit();
        $customer_UNIQUE = $this->getOrderId($jenis_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan);
        // echo db_connect()->showLastQuery();
        // exit();
        // dd($customer_UNIQUE);
        try {
            $Layanan = new Layanan();
            $dataMarketing = $this->marketing_model->find($marketing);
            $dataLayanan = $this->layananModel->find($jenis_layanan);


            $no_urutan = $this->getUrutan($jenis_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);
            if ($jenis_test == 2 || $jenis_test == "2") {
                $nomor_bilik = 1;
            } else if ($jenis_test == 3 || $jenis_test == "3") {
                $nomor_bilik = 2;
            } else {
                $hitung_bilik = 6 % $no_urutan;
                $nomor_bilik = $hitung_bilik + 2;
            }

            // echo "Urutan : " . $no_urutan;

            // var_dump($data);
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
                'id_marketing' => $marketing,
                'instansi' => $instansi,
                'status_test' => 'menunggu',
                'tahap' => 1,
                'kehadiran' => '22',
                'no_antrian' => $no_urutan,
                'nomor_bilik' => $nomor_bilik,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => 'pending',
                'status_peserta' => "20"
            ];
            $insert = $this->customerModel->insert($DataInsertCustomer);
            $insert_id = null;
            if ($insert) {
                $insert_id = $this->customerModel->getInsertID();
            } else {
                return $this->failValidationError();
            }
            $InvoiceCustomer = $this->getInvoiceNumber($insert_id);
            $this->customerModel->update($insert_id, ['invoice_number' => $InvoiceCustomer]);
            $DetailLayananTest = $Layanan->detail_layanan($jenis_pemeriksaan);
            $productName = $DetailLayananTest['nama_test'] . ' ' . $DetailLayananTest['nama_layanan'];
            $params = array(
                'transaction_details' => array(
                    'order_id' => $DataInsertCustomer['customer_unique'],
                    'gross_amount' => $detail_layanan_test['biaya'],
                    'product_name' => $productName,
                    'quantity' => 1
                ),
                'customer_details' => array(
                    'first_name' => explode(' ', $nama)[0],
                    'last_name' => str_replace(explode(' ', $nama)[0], '', $nama),
                    'email' => $email,
                    'phone' => $phone,
                    'Address' => $alamat
                ),
            );


            // MIDTRANS TRANSACTION GET TOKEN
            $Midtrans = new BackofficeMidtrans();
            $MidtransToken = $Midtrans->getToken($params);
            $vars = array(
                'marketing' => array(
                    'id' => $marketing,
                    'nama' => $dataMarketing['nama_marketing']
                ),
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'jenis_test' => $jenis_test,
                'jenis_pemeriksaan' => $jenis_pemeriksaan,
                'jenis_layanan' => $dataLayanan['nama_layanan'],
                'no_antrian' => $DataInsertCustomer['no_antrian']
            );
            array_push($params, $vars);

            $dataInsertPembayaran = [
                'id_customer' => $insert_id,
                'status_pembayaran' => 'unpaid'
            ];
            $insertPembayaran = $this->PembayaranModel->insert($dataInsertPembayaran);
            $id_pembayaran = $this->PembayaranModel->getInsertID();
            if ($MidtransToken) {
                $data = ['midtrans' => $MidtransToken, 'invoice_number' => $InvoiceCustomer, 'transaction' => $params, 'detail_payment' => $this->PembayaranModel->find($id_pembayaran)];
                return $this->respond($data, 200, 'success');
            } else {
                $data = ['data' => '', 'invoice_number' => null];
                return $this->respond($data, 400, 'Failed');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError($th->getMessage() . ' line: ' . $th->getLine() . ' Code: ' . $th->getCode() . ' file: ' . $th->getFile());
        }
    }

    public function getOrderId($type_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan)
    {
        $awal = '';
        switch ($type_test) {
            case '1':
                $awal = 'SPS';
                break;
            case '2':
                $awal = 'SPB';
                break;
            case '3':
                $awal = 'RTB';
                break;
            case '4':
                $awal = 'SAB';
                break;

            default:
                # code...
                break;
        }
        $awal = $awal . date('ymd') . substr($jam_kunjungan, 0, 2);
        $urutan = $this->getUrutan($type_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);

        $ID = str_pad($urutan, 3, '0', STR_PAD_LEFT);
        $NEWID = $awal . $ID;
        return $NEWID;
    }

    public function getUrutan($type_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan)
    {

        $data = $this->customerModel->getCustomerAvailableByDate($type_test, $jenis_pemeriksaan, $jenis_layanan, '1', $tgl_kunjungan)->getRowArray();
        // db_connect()->table()->select()->get()->getRowArray()
        // echo db_connect()->showLastQuery();
        // var_dump($data);
        if ($data) {
            $totalData = (intval($data['id'])) ? intval($data['id']) : 0;
        } else {
            $totalData = 0;
        }
        return $totalData + 1;
    }

    public function getInvoiceNumber($id_customer): string
    {
        $data = $this->customerModel->find($id_customer);
        // echo $data['no_antrian'];
        // exit();
        $word1 = 'INV-';
        $date = date('ymd');
        if (!is_array($id_customer)) {
            $urutan = $data['no_antrian'];
        } else {
            $urutan =  1;
        }

        $generateUrutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);
        // echo $date;
        // exit();
        $invoice = $word1 . $date . $generateUrutan;
        // echo $invoice;
        // exit();
        return $invoice;
    }

    public function detail_form2()
    {

        $id_jenis_test = $this->request->getVar('id_jenis_test');
        $id_pemeriksaan = $this->request->getVar('id_pemeriksaan');
        $segmen = $this->request->getVar('segmen');
        try {

            $dataLayanan = $this->layananTestModel->getDetailLayananTestByIdJenisTest($id_jenis_test, $id_pemeriksaan, $segmen)->getResultArray();
            $result = ['data_layanan' => $dataLayanan];
            if ($dataLayanan) {
                return $this->respond($result, 200, 'success');
            } else {
                return $this->respond($result, 404, 'Not found');
            }
        } catch (\Throwable $th) {
            return $this->failServerError('Failed ' . $th->getMessage());
        }
    }

    public function jadwal_available()
    {

        $id_jenis_test = $this->request->getVar('jenis_test');
        $tgl_kunjungan = $this->request->getVar('tgl_kunjungan');
        // $jenis_pemeriksaan = $this->request->getPost('jenis_pemeriksaan');
        $cek_db_kuota = $this->layananTestModel->getKuotaJenisTest($id_jenis_test);
        // echo db_connect()->getLastQuery();
        $result_data = array();
        // dd($cek_db_kuota->getResultArray());
        foreach ($cek_db_kuota->getResultArray() as $key => $value) {
            $KuotaDB = $this->layananTestModel->getAvailableKuota($id_jenis_test, $value['jam'], $tgl_kunjungan);
            $availKuota = intval($value['kuota']) - $KuotaDB;
            $status = ($availKuota == 0) ? 'full' : 'available';
            $disabled = ($availKuota == 0) ? 'disabled' : '';
            $btn_class = ($availKuota == 0) ? 'btn btn-danger disabled' : 'btn btn-outline-primary';
            $result_data[] = [
                'value' => $value['val'],
                'label' => substr($value['jam'], 0, 5),
                'kuota' => $availKuota,
                'status' => $status,
                'disabled' => $disabled,
                'btn_class' => $btn_class
            ];
        }
        return $this->respond($result_data, 200, 'success');
    }

    public function update_data_customer_registration()
    {
        $payment_type = $this->request->getPost('payment_type');
        $order_id = $this->request->getPost('order_id');
        $pdf_url = $this->request->getPost('pdf_url');
        $gross_amount = $this->request->getPost('gross_amount');
        $transaction_status = $this->request->getPost('transaction_status');
        $finish_url = $this->request->getPost('finish_url');
        $transaction_id = $this->request->getPost('transaction_id');
        $MidtransHandler = new backoffice\Midtrans;
        $returnArray = array();
        try {
            $customerDetail = $this->customerModel->where(['customer_unique' => $order_id])->first();
            // print_r($customerDetail);
            // exit();
            if ($customerDetail) {
                $id_customer = $customerDetail['id'];
                $payment_check  = $this->PembayaranModel->where(['id_customer' => $id_customer])->first();
                if ($payment_check) {
                    $id_payment = $payment_check['id'];
                    $arrayCustomerUpdate = array(
                        'status_pembayaran' => $transaction_status,
                        'url_pdf' => $pdf_url
                    );
                    $arrayPembayaranUpdate = array(
                        'tipe_pembayaran' => "midtrans",
                        'amount' => $gross_amount,
                        'jenis_pembayaran' => $payment_type,
                        'status_pembayaran' => $transaction_status
                    );
                    $updateCustomer = $this->customerModel->update($id_customer, $arrayCustomerUpdate);
                    $updatePayment = $this->PembayaranModel->update($id_payment, $arrayPembayaranUpdate);

                    if ($updateCustomer && $updatePayment) {
                        $get_qr = array();
                        if ($transaction_status == "settlement" || $transaction_status == "capture") {
                            $get_qr = $this->get_qr_by_order_id($order_id);
                        }
                        $responseStatus = "success";
                        $midtransStatus = $MidtransHandler->getStatusByOrderId($order_id);
                        $statusCode = 200;
                        $newCustomerDetail = $this->customerModel->where(['customer_unique' => $order_id])->first();
                        $newPaymentDetail = $this->PembayaranModel->update($payment_check['id'], $arrayPembayaranUpdate);
                        $returnArray = array(
                            'responseStatus' => $responseStatus,
                            'responseMessage' => 'success',
                            'statusMidtrans' => $midtransStatus,
                            'statusCode' => $statusCode,
                            'customer_detail' => $newCustomerDetail,
                            'payment_detail' => $newPaymentDetail,
                            'qr_detail' => $get_qr,
                            'finish_url' => $finish_url
                        );
                        return $this->respondUpdated($returnArray, 'success');
                    } else {
                        $responseStatus = "failed";
                        $responseMessage = "failed update customer";
                        $statusCode = 400;
                        $returnArray = array(
                            'responseStatus' => $responseStatus,
                            'responseMessage' => $responseMessage,
                            'statusCode' => $statusCode,
                            'finish_url' => $finish_url
                        );
                    }
                } else {
                    $responseStatus = "failed";
                    $responseMessage = "failed update customer";
                    $statusCode = 400;
                    $returnArray = array(
                        'responseStatus' => $responseStatus,
                        'responseMessage' => $responseMessage,
                        'statusCode' => $statusCode,
                        'finish_url' => $finish_url
                    );
                }
            } else {
                $responseStatus = "failed";
                $responseMessage = "failed update customer";
                $statusCode = 400;
                $returnArray = array(
                    'responseStatus' => $responseStatus,
                    'responseMessage' => $responseMessage,
                    'statusCode' => $statusCode,
                    'finish_url' => $finish_url
                );
            }
        } catch (\Throwable $th) {
            //throw $th;
            $responseStatus = "failed";
            $responseMessage = "failed update cause " . $th->getMessage() . ' code : ' . $th->getCode() . ' line : ' . $th->getLine();
            $statusCode = 500;
            $returnArray = array(
                'responseStatus' => $responseStatus,
                'responseMessage' => $responseMessage,
                'statusCode' => $statusCode,
                'finish_url' => $finish_url
            );
        }
        return $this->respond($returnArray, $returnArray['statusCode'], $returnArray['responseMessage']);
    }

    public function get_server_key()
    {
        $order_id = $this->request->getVar('order_id');
        try {
            $db_init = db_connect()->table('customers')->select()->where('customer_unique', $order_id)->get();
            $data_customer = $db_init->getResultArray();
            $total_data = count($data_customer);
            if ($total_data > 0) {
                $db_server_key = db_connect()->table('system_parameter')->select()->where('vgroup', 'MIDTRANS_KEY')->where('parameter', 'SERVER_KEY')->get();
                $result_server_key = $db_server_key->getRowArray();
                $server_key = $result_server_key['value'];
                $respondData = array(
                    'statusMessage' => 'success',
                    'server_key' => $server_key
                );
                return $this->respond($respondData, 200, 'success');
            } else {
                $respondData = array(
                    'statusMessage' => 'order id tidak ditemukan'
                );
                return $this->respond($respondData, 401, 'failed');
            }
        } catch (\Throwable $th) {
            $respondData = array(
                'statusMessage' => 'Gagal karena' . $th->getMessage()
            );
            return $this->respond($respondData, 500, 'failed');
        }
    }

    public function get_qr_by_order_id($order_id)
    {
        // $order_id = $this->request->getVar('order_id');
        try {
            $db_init = db_connect()->table('customers')->select()->where('customer_unique', $order_id)->get();
            $data_customer = $db_init->getResultArray();
            $total_data = count($data_customer);
            if ($total_data > 0) {
                $id_customer = $data_customer['id'];
                $url = base_url('api/hadir/' . base64_encode($id_customer));
                $qr_url = $this->layanan_controller->getUrlQRCode($url);
                $respondData = array(
                    'responseMessage' => 'success',
                    'url_img' => $qr_url
                );
                return $this->respond($respondData, 200, 'success');
            } else {
                $respondData = array(
                    'responseMessage' => 'not found',
                    'url_img' => null
                );
                return $this->respond($respondData, 404, 'failed');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function findOrderId()
    {
        $order_id = $this->request->getVar('order_id');
        try {
            $db_init = db_connect()->table('customers')->select()->where('customer_unique', $order_id)->get();
            $data_customer = $db_init->getResultArray();
            $total_data = count($data_customer);
            if ($total_data > 0) {
                $id_customer = $data_customer['id'];
                $url = base_url('api/hadir/' . base64_encode($id_customer));
                $qr_url = $this->layanan_controller->getUrlQRCode($url);
                $respondData = array(
                    'statusMessage' => 'success',
                    'url_img' => $qr_url
                );
                return $this->respond($respondData, 200, 'success');
            } else {
                $respondData = array(
                    'statusMessage' => 'order id tidak ditemukan'
                );
                return $this->respond($respondData, 401, 'failed');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function encode_key()
    {
        $key = $this->request->getVar('key');
        $result_encoded = base64_encode($key . ':');
        echo $result_encoded;
    }

    public function check_order_id()
    {
        // $NotifController = new Notification;
        // return $NotifController->index();
        $order_id = $this->request->getVar('order_id');
        $typeSearch = $this->request->getVar('tos');
        switch ($typeSearch) {
            case 'hasil':
                return $this->cari_hasil($order_id);
                break;
            case 'registrasi_detail':
                return $this->cari_registrasi_detail($order_id);
                break;
            case 'reschedule':
                return $this->cari_reshcedule($order_id);
                break;
            default:
                # code...
                break;
        }
    }

    public function cari_hasil($order_id)
    {

        try {
            $detailCustomer = $this->customerModel->where(['customer_unique' => $order_id])->first();
            if (count($detailCustomer) == 0) {
                return $this->fail('order id tidak ditemukan', 404, 'not found');
            } else {
                $id_customer = $detailCustomer['id'];
                $value = $this->hasil_test->where(['id_customer' => $id_customer])->first();
                if (count($value) == 0) {
                    return $this->failNotFound('Not found');
                }
                $result = array();
                // foreach ($data_laboratorium as $key => $value) {
                $id_jenis_layanan_test = $detailCustomer['jenis_test'];
                $detailLayananTest = $this->layananTestModel->find($id_jenis_layanan_test);
                $detailTest = $this->testModel->find($detailLayananTest['id_test']);
                $detailLayanan = $this->layananModel->find($detailLayananTest['id_layanan']);
                $detailSample = $this->sample_model->find($value['id_sample']);
                $statusCov = '';
                $statusGene = '';
                $statusOrf = '';
                $statusIgg = '';
                $statusIgm = '';
                $statusKirim = '';
                if ($value['status_cov'] !== "") {
                    $detailHasilCov = $this->status_model->find($value['status_cov']);
                    $statusCov = $detailHasilCov['nama_status'];
                }
                if ($value['status_gene'] !== "") {
                    $detailHasilGene = $this->status_model->find($value['status_gene']);
                    $statusGene = $detailHasilGene['nama_status'];
                }
                if ($value['status_orf'] !== "") {
                    $detailHasilOrf = $this->status_model->find($value['status_orf']);
                    $statusOrf = $detailHasilOrf['nama_status'];
                }
                if ($value['status_igg'] !== "") {
                    $detailHasilIgg = $this->status_model->find($value['status_igg']);
                    $statusIgg = $detailHasilIgg['nama_status'];
                }
                if ($value['status_igm'] !== "") {
                    $detailHasilIgm = $this->status_model->find($value['status_igm']);
                    $statusIgm = $detailHasilIgm['nama_status'];
                }
                if ($value['status_kirim'] !== "") {
                    $detailHasilKirim = $this->status_model->find($value['status_kirim']);
                    $statusKirim = $detailHasilKirim['nama_status'];
                }
                $ic = $value['detail_ic'];
                $catatan = $value['catatan'];
                $paket_pemeriksaan = $detailTest['nama_test'] . "(" . $detailLayanan['nama_layanan'] . ")";
                $nama_sample = $detailSample['nama_sample'];
                $result = array(
                    'id_customer' => $value['id_customer'],
                    'id_hasil' => $value['id'],
                    'tgl_kunjungan' => $detailCustomer['tgl_kunjungan'],
                    'registrasi' => $detailCustomer['customer_unique'] . ' - ' . substr($detailCustomer['created_at'], 0, 10),
                    'paket_pemeriksaan' => $paket_pemeriksaan,
                    'nama_customer' => $detailCustomer['nama'],
                    'nik' => $detailCustomer['nik'],
                    'waktu_sampling' => substr($value['waktu_ambil_sampling'], 0, 10),
                    'waktu_periksa' => substr($value['waktu_periksa_sampling'], 0, 10),
                    'waktu_selesa_periksa' => substr($value['waktu_selesai_periksa'], 0, 10),
                    'status_cov' => $statusCov,
                    'status_gene' => $statusGene,
                    'status_orf' => $statusOrf,
                    'status_igg' => $statusIgg,
                    'status_igm' => $statusIgm,
                    'ic' => $ic,
                    'nama_sample' => $nama_sample,
                    'catatan' => $catatan,
                    'status_kirim' => $statusKirim,
                    'id_jenis_layanan_test' => $id_jenis_layanan_test
                );
                return $this->respond($result, 200, 'success');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }

        // }
    }

    public function cari_registrasi_detail($order_id)
    {
        $PemanggilanModel = new PemanggilanModel();
        try {
            $detailCustomer = $this->customerModel->where(['customer_unique' => $order_id])->first();

            if (count($detailCustomer) == 0) {

                return $this->respond('nomor registrasi tidak ditemukan', 404, 'failed');
            } else {
                $id_customer = $detailCustomer['id'];
                $pembayaran = $this->PembayaranModel->where(['id_customer' => $id_customer])->first();
                $arrayResult = array(
                    'detail_customer' => $detailCustomer,
                    'detail_pembayaran' => $pembayaran,
                    // 'detail_antrian' =>
                );
                return $this->respond($arrayResult, 200, 'success');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError();
        }
    }

    public function home_service()
    {
        $data_marketing = $this->marketing_model->findAll();
        $vgroup = 'MIDTRANS_KEY';
        $paramter = 'CLIENT_KEY';
        $DB = db_connect()->table('system_parameter')->select('*')->where('vgroup', $vgroup)->where('parameter', $paramter)->get()->getFirstRow();
        $layanan_test_data = $this->layananTestModel
            ->where(['id_pemeriksaan' => '2', 'id_segmen' => '1'])->groupBy('id_test')->get()->getResultArray();
        $jenis_test = $this->testModel;
        // $getData = $this->sysParamModel->getByVgroupAndParamter('MIDTRANS_KEY', 'CLIENT_KEY');
        $encrypted_client = $DB->value;
        $ClientKey = base64_decode($encrypted_client);
        $data = [
            'title' => "Home",
            'marketings' => $data_marketing,
            'midtrans_client_key' => $ClientKey,
            'jenis_test' => $jenis_test,
            'layanan_test_data' => $layanan_test_data
        ];
        return view('customer/home_service', $data);
    }

    public function getSelectedTest()
    {
        $id_jenis_test = $this->request->getVar('id_test');
        $id_jenis_pemeriksaan = $this->request->getVar('type');
        $id_segmen = $this->request->getVar('segmen');
        // dd($this->request->getVar());
        try {
            $check_jenis_test = $this->testModel->find($id_jenis_test);
            // echo "Hasil id : {$check_jenis_test['id']}";
            if ($check_jenis_test['id']) {
                $check_data_layanan_test = $this->layananTestModel
                    ->where(['id_test' => $id_jenis_test, 'id_pemeriksaan' => $id_jenis_pemeriksaan, 'id_segmen' => $id_segmen])->get()->getResultArray();
                if ($check_data_layanan_test) {
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
            } else {
                return $this->failForbidden();
            }
        } catch (\Throwable $th) {
            return $this->respond(array('message' => $th->getMessage()), 500, 'error');
        }
    }

    public function home_service_registration()
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
            $p = $peserta[0];
            $detail_jenis_test = $this->layananTestModel->find($p['jenis_test']);
            $detail_layanan = $this->layananModel->find($detail_jenis_test['id_layanan']);
            $detail_test = $this->testModel->find($detail_jenis_test['id_test']);
            $jenis_pemeriksaan = $detail_jenis_test['id_pemeriksaan'];
            $jenis_layanan = $detail_jenis_test['id_layanan'];
            $jenis_test = $p['jenis_test'];
            $tgl_kunjungan = $p['tgl_kunjungan'];
            $jam_kunjungan = $p['jam_kunjungan'];
            $jenis_kelamin = $p['jenis_kelamin'];
            $tempat_lahir = $p['tempat_lahir'];
            $tgl_lahir = $p['tgl_lahir'];
            $alamat = $p['alamat'];
            $instansi = $p['instansi'];
            $marketing = $p['marketing'];

            $customer_UNIQUE = $this->getOrderId($jenis_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan);
            $no_urutan = $this->getUrutan($jenis_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);

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
                'status_peserta' => "20",
            );
            $this->CustomerHomeServiceModel->insert($array_insert);
            $id_hs = $this->CustomerHomeServiceModel->getInsertID();

            $InvoiceCustomer = $this->generate_invoice_hs($id_hs);
            $this->CustomerHomeServiceModel->update($id_hs, ['invoice_number' => $InvoiceCustomer]);

            $array_insert = array();
            $ids = array();
            $harga_test = 0;
            $product_name = array();
            foreach ($peserta as $key => $p) {
                $detail_jenis_test = $this->layananTestModel->find($p['jenis_test']);
                $detail_layanan = $this->layananModel->find($p['id_layanan']);
                $detail_test = $this->testModel->find($p['id_test']);
                $jenis_pemeriksaan = $detail_jenis_test['id_pemeriksaan'];
                $jenis_layanan = $detail_jenis_test['id_layanan'];
                $jenis_test = $p['jenis_test'];
                $tgl_kunjungan = $p['tgl_kunjungan'];
                $jam_kunjungan = $p['jam_kunjungan'];
                $jenis_kelamin = $p['jenis_kelamin'];
                $tempat_lahir = $p['tempat_lahir'];
                $tgl_lahir = $p['tgl_lahir'];
                $alamat = $p['alamat'];
                $instansi = $p['instansi'];
                $marketing = $p['marketing'];

                $customer_UNIQUE = $this->getOrderId($jenis_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan);
                $no_urutan = $this->getUrutan($jenis_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);

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
                    'status_peserta' => "20",
                    'is_hs' => "yes",
                    'id_hs' => $id_hs
                );
                $this->customerModel->insert($array_insert);
                $ids = $this->customerModel->getInsertID();

                $InvoiceCustomer = $this->getInvoiceNumber($ids);
                $this->customerModel->update($ids, ['invoice_number' => $InvoiceCustomer]);

                $harga_test += $detail_jenis_test['biaya'];
                $product_name[] = $detail_test['nama_test'] . " " . $detail_layanan['nama_layanan'];
            }
            // $this->customerModel->insertBatch($array_insert);
            // $last_inserted = $this->customerModel->getInsertID();



            $array_result = array('statusMessage' => 'success', 'id_hs' => $id_hs, 'total_customers' => count($peserta));
            return $this->respond($array_result, 200, 'success');
            // return $this->midtrans_transaction_get_token("2", )
        } catch (\Throwable $th) {
            return $this->failServerError('failed', 500, 'failed');
        }
    }

    protected function generate_invoice_hs($id_customer)
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


    protected function midtrans_transaction_get_token($customer_type = "1", $detail_transaction)
    {
        $params = array(
            'transaction_details' => array(
                'order_id' => $detail_transaction['order_id'],
                'gross_amount' => $detail_transaction['biaya'],
                'product_name' => $detail_transaction['productName'],
                'quantity' => 1
            ),
            'customer_details' => array(
                'first_name' => explode(' ', $detail_transaction['nama'])[0],
                'last_name' => str_replace(explode(' ', $detail_transaction['nama'])[0], '', $detail_transaction['nama']),
                'email' => $detail_transaction['email'],
                'phone' => $detail_transaction['phone'],
                'Address' => $detail_transaction['alamat']
            ),
        );


        // MIDTRANS TRANSACTION GET TOKEN
        $Midtrans = new BackofficeMidtrans();
        $MidtransToken = $Midtrans->getToken($params);
        $vars = array(
            'marketing' => array(
                'id' => $detail_transaction['marketing'],
                'nama' => $detail_transaction['dataMarketing']['nama_marketing']
            ),
            'jam_kunjungan' => $detail_transaction['jam_kunjungan'],
            'tgl_kunjungan' => $detail_transaction['tgl_kunjungan'],
            'jenis_test' => $detail_transaction['jenis_test'],
            'jenis_pemeriksaan' => $detail_transaction['jenis_pemeriksaan'],
            'jenis_layanan' => $detail_transaction['dataLayanan']['nama_layanan'],
            'antrain' => $detail_transaction['no_antrian']
        );
        array_push($params, $vars);
        $PembayaranModel = new PembayaranModel();
        $dataInsertPembayaran = [
            'id_customer' => $detail_transaction['insert_id'],
            'status_pembayaran' => 'pending'
        ];
        $insertPembayaran = $PembayaranModel->insert($dataInsertPembayaran);
        $id_pembayaran = $PembayaranModel->getInsertID();
        if ($MidtransToken) {
            $data = ['data' => $MidtransToken, 'invoice_number' => $detail_transaction['InvoiceCustomer'], 'transaction' => $params, 'detail_payment' => $PembayaranModel->find($detail_transaction['id_pembayaran'])];
            return $this->respond($data, 200, 'success');
        } else {
            $data = ['data' => '', 'invoice_number' => null];
            return $this->respond($data, 400, 'Failed');
        }
    }

    public function validasi_no_registrasi()
    {
        $customer_unique = $this->request->getVar('no_registrasi');
        try {
            $finding = $this->customerModel->where(['customer_unique' => $customer_unique])->first();
            if ($finding) {
                $detail_layanan_test = $this->layananTestModel->find($finding['jenis_test']);
                $detail_layanan = $this->layananModel->find($detail_layanan_test['id_layanan']);
                $detail_pemeriksaan = $this->pemeriksaanModel->find($detail_layanan_test['id_pemeriksaan']);
                $detail_test = $this->testModel->find($detail_layanan_test['id_test']);
                $detail_pembayaran = $this->PembayaranModel->where(['id_customer' => $finding['id']])->get()->getRowArray();
                $detail_kehadiran = $this->status_model->find($finding['kehadiran']);
                $detail_marketing = $this->marketing_model->find($finding['id_marketing']);
                $result_data = array(
                    'no_registrasi' => $customer_unique,
                    'nama' => $finding['nama'],
                    'kehadiran' => $detail_kehadiran['nama_status'],
                    'jenis_test' => $detail_test['nama_test'],
                    'jenis_layanan' => $detail_layanan['nama_layanan'],
                    'tgl_kunjungan' => $finding['tgl_kunjungan'],
                    'jam_kunjungan' => $finding['jam_kunjungan'],
                    'marketing' => $detail_marketing['nama_marketing'],
                    'cara_pemeriksaan' => $detail_pemeriksaan['nama_pemeriksaan'],
                    'detail_pembayaran' => array(
                        'gross_amount' => $detail_pembayaran['amount'],
                        'jenis_pembayaran' => $detail_pembayaran['jenis_pembayaran'],
                        'status_pembayaran' => $detail_pembayaran['status_pembayaran']
                    ),

                );
                return $this->respond($result_data, 200, 'success');
            } else {
                return $this->respond(array('message' => 'Nomor registrasi tidak ditemukan'), 400, 'failed');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->respond(array('message' => 'Nomor registrasi tidak ditemukan, error karena ' . $th->getMessage()), 500, 'error');
        }
    }

    public function check_hasil()
    {
        $customer_unique = $this->request->getVar('no_registrasi');
        try {
            $finding = $this->customerModel->where(['customer_unique' => $customer_unique])->first();
            if ($finding) {

                $detail_hasil = $this->hasil_test->where(['id_customer' => $finding['id']])->get()->getRowArray();
                $id_dokter = $detail_hasil['id_dokter'];
                $id_petugas = $detail_hasil['id_petugas'];
                $id_alat = $detail_hasil['id_alat'];
                if ($id_dokter !== "" && $id_petugas !== "" && $id_alat !== "") {
                    $detail_dokter = $this->dokter_model->find($id_dokter);
                    $detail_petugas = $this->petugas_model->find($id_petugas);
                    $detail_alat = $this->alat_model->find($id_alat);

                    $detail_layanan_test = $this->layananTestModel->find($finding['jenis_test']);
                    $detail_layanan = $this->layananModel->find($detail_layanan_test['id_layanan']);
                    $detail_pemeriksaan = $this->pemeriksaanModel->find($detail_layanan_test['id_pemeriksaan']);
                    $detail_test = $this->testModel->find($detail_layanan_test['id_test']);
                    $detail_pembayaran = $this->PembayaranModel->where(['id_customer' => $finding['id']])->get()->getRowArray();
                    $detail_kehadiran = $this->status_model->find($finding['kehadiran']);
                    $detail_marketing = $this->marketing_model->find($finding['id_marketing']);

                    $status_cov = $this->status_model->find($detail_hasil['status_cov']);
                } else {
                    return $this->respond(array('message' => "Hasil dari laboratorium belum keluar"), 200, 'success');
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    // public function (Type $var = null)
    // {
    //     # code...
    // }

    public function cari_reshcedule($order_id)
    {
        # code...
    }

    //--------------------------------------------------------------------

}
