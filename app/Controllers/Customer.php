<?php

namespace App\Controllers;

use App\Controllers\backoffice\Layanan;
use App\Controllers\backoffice\Midtrans as BackofficeMidtrans;
use App\Controllers\backoffice\SystemParameter;
use App\Models\CustomerModel;
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
use App\Models\SampleModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SystemParameterModel;
use Midtrans;

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
    function __construct()
    {
        $this->systemparam = new SystemParameter;
        $this->layananModel = new LayananModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->customerModel = new CustomerModel();
        $this->kuotaModel = new KuotaModel();
        $this->PembayaranModel = new PembayaranModel();
    }
    public function index()
    {
        $marketingModel = new MarketingModel();
        $data_marketing = $marketingModel->findAll();
        $vgroup = 'MIDTRANS_KEY';
        $paramter = 'CLIENT_KEY';
        $DB = db_connect()->table('system_parameter')->select('*')->where('vgroup', $vgroup)->where('parameter', $paramter)->get()->getFirstRow();
        // $getData = $this->sysParamModel->getByVgroupAndParamter('MIDTRANS_KEY', 'CLIENT_KEY');
        $encrypted_client = $DB->value;
        $ClientKey = base64_decode($encrypted_client);
        $data = [
            'title' => "Home",
            'marketings' => $data_marketing,
            'midtrans_client_key' => $ClientKey
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
        $marketingModel = new MarketingModel();
        $validation =  \Config\Services::validation();
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
        $jenis_pemeriksaan = $this->request->getPost('jenis_pemeriksaan');
        $jenis_layanan = $this->request->getPost('jenis_layanan');
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
            $dataMarketing = $marketingModel->find($marketing);
            $dataLayanan = $this->layananModel->find($jenis_layanan);
            $dataTest = $this->testModel->find($jenis_test);

            $no_urutan = $this->getUrutan($jenis_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);
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
                'kehadiran' => '0',
                'no_antrian' => $no_urutan,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => 'unpaid'
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
                    'gross_amount' => $DetailLayananTest['biaya'],
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
                'antrain' => $DataInsertCustomer['no_antrian']
            );
            array_push($params, $vars);
            $PembayaranModel = new PembayaranModel();
            $dataInsertPembayaran = [
                'id_customer' => $insert_id,
                'status_pembayaran' => 'unpaid'
            ];
            $insertPembayaran = $PembayaranModel->insert($dataInsertPembayaran);
            $id_pembayaran = $PembayaranModel->getInsertID();
            if ($MidtransToken) {
                $data = ['data' => $MidtransToken, 'invoice_number' => $InvoiceCustomer, 'transaction' => $params, 'detail_payment' => $PembayaranModel->find($id_pembayaran)];
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
        $CustomerModel = new CustomerModel();
        $data = $CustomerModel->getCustomerAvailableByDate($type_test, $jenis_pemeriksaan, $jenis_layanan, '1', $tgl_kunjungan)->getRowArray();
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
        $urutan = $data['no_antrian'];
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
        try {
            $LayananModel = new LayananTestModel();
            $dataLayanan = $LayananModel->getDetailLayananTestByIdJenisTest($id_jenis_test)->getResultArray();
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
        $Layanan = new LayananTestModel();
        $id_jenis_test = $this->request->getVar('jenis_test');
        $tgl_kunjungan = $this->request->getVar('tgl_kunjungan');
        // $jenis_pemeriksaan = $this->request->getPost('jenis_pemeriksaan');
        $cek_db_kuota = $Layanan->getKuotaJenisTest($id_jenis_test);
        // echo db_connect()->getLastQuery();
        $result_data = array();
        // dd($cek_db_kuota->getResultArray());
        foreach ($cek_db_kuota->getResultArray() as $key => $value) {
            $KuotaDB = $Layanan->getAvailableKuota($id_jenis_test, $value['jam'], $tgl_kunjungan);
            $availKuota = intval($value['kuota']) - $KuotaDB;
            $status = ($availKuota == 0) ? 'full' : 'available';
            $disabled = ($availKuota == 0) ? 'disabled' : '';
            $btn_class = ($availKuota == 0) ? 'btn-danger' : 'btn-outline-success';
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
        $layananC = new Layanan;
        // $order_id = $this->request->getVar('order_id');
        try {
            $db_init = db_connect()->table('customers')->select()->where('customer_unique', $order_id)->get();
            $data_customer = $db_init->getResultArray();
            $total_data = count($data_customer);
            if ($total_data > 0) {
                $id_customer = $data_customer['id'];
                $url = base_url('api/hadir/' . base64_encode($id_customer));
                $qr_url = $layananC->getUrlQRCode($url);
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
        $layananC = new Layanan;
        $order_id = $this->request->getVar('order_id');
        try {
            $db_init = db_connect()->table('customers')->select()->where('customer_unique', $order_id)->get();
            $data_customer = $db_init->getResultArray();
            $total_data = count($data_customer);
            if ($total_data > 0) {
                $id_customer = $data_customer['id'];
                $url = base_url('api/hadir/' . base64_encode($id_customer));
                $qr_url = $layananC->getUrlQRCode($url);
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
        $laboratoriumModel = new HasilLaboratoriumModel();
        $layananTestModel = new LayananTestModel();
        $testModel = new TestModel();
        $layananModel = new LayananModel();
        $sampleModel = new SampleModel();
        $statusHasilModel = new StatusHasilModel();
        $customer = new CustomerModel();

        try {
            $detailCustomer = $customer->where(['customer_unique' => $order_id])->first();
            if (count($detailCustomer) == 0) {
                return $this->fail('order id tidak ditemukan', 404, 'not found');
            } else {
                $id_customer = $detailCustomer['id'];
                $value = $laboratoriumModel->where(['id_customer' => $id_customer])->first();
                if (count($value) == 0) {
                    return $this->failNotFound('Not found');
                }
                $result = array();
                // foreach ($data_laboratorium as $key => $value) {
                $id_jenis_layanan_test = $detailCustomer['jenis_test'];
                $detailLayananTest = $layananTestModel->find($id_jenis_layanan_test);
                $detailTest = $testModel->find($detailLayananTest['id_test']);
                $detailLayanan = $layananModel->find($detailLayananTest['id_layanan']);
                $detailSample = $sampleModel->find($value['id_sample']);
                $statusCov = '';
                $statusGene = '';
                $statusOrf = '';
                $statusIgg = '';
                $statusIgm = '';
                $statusKirim = '';
                if ($value['status_cov'] !== "") {
                    $detailHasilCov = $statusHasilModel->find($value['status_cov']);
                    $statusCov = $detailHasilCov['nama_status'];
                }
                if ($value['status_gene'] !== "") {
                    $detailHasilGene = $statusHasilModel->find($value['status_gene']);
                    $statusGene = $detailHasilGene['nama_status'];
                }
                if ($value['status_orf'] !== "") {
                    $detailHasilOrf = $statusHasilModel->find($value['status_orf']);
                    $statusOrf = $detailHasilOrf['nama_status'];
                }
                if ($value['status_igg'] !== "") {
                    $detailHasilIgg = $statusHasilModel->find($value['status_igg']);
                    $statusIgg = $detailHasilIgg['nama_status'];
                }
                if ($value['status_igm'] !== "") {
                    $detailHasilIgm = $statusHasilModel->find($value['status_igm']);
                    $statusIgm = $detailHasilIgm['nama_status'];
                }
                if ($value['status_kirim'] !== "") {
                    $detailHasilKirim = $statusHasilModel->find($value['status_kirim']);
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

    public function cari_reshcedule($order_id)
    {
        # code...
    }

    //--------------------------------------------------------------------

}
