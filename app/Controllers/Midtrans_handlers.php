<?php

namespace App\Controllers;
// use App\Controllers\BaseController;

use App\Controllers\backoffice\Layanan;
use App\Controllers\backoffice\Midtrans;
use App\Controllers\backoffice\Whatsapp_service;
use App\Models\CustomerModel;
use App\Models\PemanggilanModel;
use App\Models\PembayaranModel;
use CodeIgniter\Controller;
use CodeIgniter\Email\Email;
// use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;


class Midtrans_handlers extends ResourceController
{
    protected $veritrans;
    protected $midtrans;
    protected $CustomerModel;
    protected $PembayaranModel;
    protected $notif;
    protected $production_mode;
    public function __construct()
    {
        // parent::__construct();
        // $params = array('server_key' => 'your_server_key', 'production' => false);
        // $this->load->library('veritrans');
        // $this->veritrans = new \Veritrans;
        $this->midtrans = new \Midtrans;
        $this->CustomerModel = new CustomerModel();
        $this->PembayaranModel = new PembayaranModel();
        $Midtrans_bo = new Midtrans;
        $this->production_mode = $Midtrans_bo->production_mode;
        // $this->veritrans->config($params);
        // $this->load->helper('url');
    }

    public function index()
    {
        $PemanggilanModel = new PemanggilanModel();
        // $this->veritrans->config($params);
        // echo 'test notification handler';
        try {
            $json_result = file_get_contents('php://input');
            $result = json_decode($json_result);

            if ($result !== null) {
                $data_key = db_connect()->table('system_parameter')->where(['vgroup' => 'MIDTRANS_KEY', 'parameter' => 'SERVER_KEY'])->get()->getFirstRow();

                /**
                 * @param string $serverKey is encoded, plase decode with base64_decode to store into midtrans server key configuration
                 */
                $serverKey = $data_key->value;
                $params = array(
                    'server_key' => base64_decode($serverKey),
                    'production' => $this->production_mode
                );
                $this->midtrans->config($params);
                $NotifMidtrans = $this->midtrans->status($result->order_id);
                // $NotifMidtrans->getResponse();
                $transaction = $NotifMidtrans->transaction_status;
                $type = $NotifMidtrans->payment_type;
                $order_id = $NotifMidtrans->order_id;
                $fraud = $NotifMidtrans->fraud_status;
                $gross_amount = $NotifMidtrans->gross_amount;
                // $status_code = $NotifMidtrans->status_code;
                // $this->midtrans->config($params);
                // $notif = $this->midtrans->status($result->order_id);
                // $this->notif = $notif;
                // $notif = $this->notif;
                // return $this->respond($notif);
                // exit();
                // $transaction = $notif['transaction_status'];
                // $type = $notif['payment_type'];
                // $order_id = $notif['order_id'];
                // $fraud = $notif['fraud_status'];

                $responseMessage = "";
                $responseStatus = "success";
                $customer_check = $this->CustomerModel->where(['customer_unique' => $order_id])->first();
                // return $customer_check;
                if ($customer_check) {
                    $id_customer = $customer_check['id'];
                    $id_layanan_test = $customer_check['jenis_test'];
                    $tgl_kunjungan = $customer_check['tgl_kunjungan'];
                    $jam_kunjungan = $customer_check['jam_kunjungan'];
                    $payemnt_check = $this->PembayaranModel->where(['id_customer' => $id_customer])->first();
                    // print_r($payemnt_check);
                    if ($payemnt_check) {
                        $id_pembayaran = $payemnt_check['id'];
                        $arrayCustomerUpdate = array(
                            'status_pembayaran' => $transaction
                        );
                        $arrayPembayaranUpdate = array(
                            'amount' => $gross_amount,
                            'jenis_pembayaran' => $type,
                            'status_pembayaran' => $transaction
                        );
                        $arrayInsertPemanggilan = array(
                            'id_customer' => $id_customer,
                            'id_layanan_test' => $id_layanan_test,
                            'stataus_pemanggilan' => '11',
                            'tgl_kunjungan' => $tgl_kunjungan,
                            'jam_kunjungan' => $jam_kunjungan
                        );

                        $updateCustomer = $this->CustomerModel->update($id_customer, $arrayCustomerUpdate);
                        $updatePayment = $this->PembayaranModel->update($id_pembayaran, $arrayPembayaranUpdate);
                        $createPemanggilanCustomer = $PemanggilanModel->insert($arrayInsertPemanggilan);

                        if ($updateCustomer && $updatePayment && $createPemanggilanCustomer) {


                            $responseStatus = $NotifMidtrans->status_message;
                            $responseMessage = $NotifMidtrans->status_message;
                            $arrayReturn = array(
                                'statusMessage' => $responseStatus,
                                'responseMessage' => $responseMessage,
                                'paymentType' => $type,
                                'orderId' => $order_id,
                                'transactionStatus' => $transaction,
                                'detailCustomer' => $customer_check,
                                'detailPaymentCustomer' => $payemnt_check,
                                'statusCode' => 200,
                                'fraud' => $fraud,
                                'midtrans_response' => $NotifMidtrans
                            );
                            if ($transaction == "settlement" || $transaction == "capture") {
                                $this->sendEmailCustomer($order_id, $NotifMidtrans);
                                $this->send_whatsapp($id_customer);
                            }
                        } else {
                            $responseStatus = $NotifMidtrans->status_message;
                            $responseMessage = "Failed update customer";
                            $arrayReturn = array(
                                'statusMessage' => $responseStatus,
                                'responseMessage' => $responseMessage,
                                'paymentType' => $type,
                                'orderId' => $order_id,
                                'transactionStatus' => $transaction,
                                'detailCustomer' => $customer_check,
                                'detailPaymentCustomer' => $payemnt_check,
                                'statusCode' => 200,
                                'fraud' => $fraud,
                                'midtrans_response' => $NotifMidtrans
                            );
                        }
                    } else {

                        $responseStatus = "failed";
                        $responseMessage = "Payment check is failed";
                        $arrayReturn = array(
                            'statusMessage' => $responseStatus,
                            'responseMessage' => $responseMessage,
                            'paymentType' => $type,
                            'orderId' => $order_id,
                            'transactionStatus' => $transaction,
                            'detailCustomer' => $customer_check,
                            'detailPaymentCustomer' => $payemnt_check,
                            'statusCode' => 200,
                            'fraud' => $fraud,
                            'midtrans_response' => $NotifMidtrans
                        );
                    }
                } else {
                    $responseStatus = "failed";
                    $responseMessage = "Customer check is failed";
                    $arrayReturn = array(
                        'statusMessage' => $responseStatus,
                        'responseMessage' => $responseMessage,
                        'paymentType' => $type,
                        'orderId' => $order_id,
                        'transactionStatus' => $transaction,
                        'detailCustomer' => $customer_check,
                        'statusCode' => 200,
                        'fraud' => $fraud,
                        'midtrans_response' => $NotifMidtrans
                    );
                }



                // $responseNotif = $this->proses_notif($notif);
                return $this->respond($arrayReturn, 200, 'success');
                // $notif = $this->veritrans->status($result->order_id);
            }
            // echo "result is null";
            return $this->respond(array('statusMessage' => 'failed'), 400, 'failed');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->respond(array(
                'line' => $th->getLine(),
                'code' => $th->getCode(),
                'message' => $th->getMessage(),
                'file' => $th->getFile(),
                'previous' => $th->getPrevious(),
                'statusCode' => 500
                // 'trace' => $th->getTrace()
            ), 500, 'server error');
        }
    }

    /**
     * PROSES NOTIFIKASI mengambil dari objek $notif 
     * yang sudah diambil melalui status midtrans
     * 
     * 
     * @return $arrayReturn
     */
    protected function proses_notif($notif)
    {
        // $notif = $this->notif;
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $responseMessage = "";
        $responseStatus = "success";
        $customer_check = $this->CustomerModel->where(['customer_unique' => $order_id])->first();
        // return $customer_check;
        if ($customer_check) {
            $payemnt_check = $this->PembayaranModel->where(['id_customer' => $customer_check['id']]);
            if ($payemnt_check) {
                $arrayCustomerUpdate = array(
                    'status_pembayaran' => $transaction
                );
                $arrayPembayaranUpdate = array(
                    'amount' => $notif->gross_amount,
                    'jenis_pembayaran' => $type,
                    'status_pembayaran' => $transaction
                );
                $updateCustomer = $this->CustomerModel->update($customer_check['id'], $arrayCustomerUpdate);
                $updatePayment = $this->PembayaranModel->update($payemnt_check['id'], $arrayPembayaranUpdate);
                if ($updateCustomer && $updatePayment) {
                    $responseStatus = "success";
                    $responseMessage = $this->midtrans_report();
                }
            } else {
                $responseStatus = "failed";
            }
        } else {
            $responseStatus = "failed";
        }


        $arrayReturn = array(
            'statusMessage' => $responseStatus,
            'responseMessage' => $responseMessage,
            'paymentType' => $type,
            'orderId' => $order_id,
            'transactionStatus' => $transaction,
            'detailCustomer' => $customer_check,
            'detailPaymentCustomer' => $payemnt_check,
            'statusCode' => $notif->status_code
        );
        return $arrayReturn;
    }

    /**
     * store response message from midtrans report
     * @return string responseMessage from midtrans status
     */
    public function midtrans_report(): string
    {
        $responseMessage = "";
        $notif = $this->notif;
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;
        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    // echo "Transaction order_id: " . $order_id . " is challenged by FDS";
                    $responseMessage = "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                    $responseMessage = "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            // echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
            $responseMessage = "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            // echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
            $responseMessage = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
            $responseMessage = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }
        return $responseMessage;
    }

    /**
     * Send email to customer user 
     * 
     */
    protected function sendEmailCustomer(string $order_id, $notif_modtrans)
    {
        # code...

        $Layanan = new Layanan;

        $Email = \Config\Services::email();

        // $Email->initialize($config);

        $CustomerDetail = $this->CustomerModel->where(['customer_unique' => $order_id])->first();
        $emailCustomer = $CustomerDetail['email'];
        $id_customer = $CustomerDetail['id'];
        $nama_customer = $CustomerDetail['nama'];

        $PaymentDetail = $this->PembayaranModel->where(['id_customer' => $id_customer])->first();
        $data_email = array(
            'detail_pembayaran' => $PaymentDetail,
            'detail_customer' => $CustomerDetail,
            'notif' => $notif_modtrans,
            'title' => 'Informasi Pembayaran'
        );
        $attachment = $Layanan->getImageQRCode(base_url('api/hadir/' . $id_customer), $nama_customer);
        $attachment_name = $nama_customer . ".pdf";
        $emailMessage = view('send_email', $data_email);

        $Email->setTo($emailCustomer);
        $Email->setFrom('info@quicktest.id', 'QuickTest.id INFO');
        $Email->setSubject("Informasi Pendaftaran Quictest.id");
        $Email->setMessage($emailMessage);
        $Email->attach($attachment, 'attachment', $attachment_name, "application/pdf");
        if ($Email->send()) {
            return true;
        } else {
            $data = $Email->printDebugger(['headers']);
            print_r($data);
        }
    }

    protected function send_whatsapp($id_customer = null)
    {
        if ($id_customer != null) {
            $whatsapp_service = new Whatsapp_service;
            $whatsapp_service->send_whatsapp_QR($id_customer);
            $whatsapp_service->send_whatsapp_invoice($id_customer);
        }
    }

    public function load_email(string $order_id)
    {
        $data_key = db_connect()->table('system_parameter')->where(['vgroup' => 'MIDTRANS_KEY', 'parameter' => 'SERVER_KEY'])->get()->getFirstRow();

        /**
         * @param string $serverKey is encoded, plase decode with base64_decode to store into midtrans server key configuration
         */
        $serverKey = $data_key->value;
        $params = array(
            'server_key' => base64_decode($serverKey),
            'production' => false
        );
        $this->midtrans->config($params);
        $notif = $this->midtrans->status($order_id);
        $CustomerDetail = $this->CustomerModel->where(['customer_unique' => $order_id])->first();
        // $emailCustomer = $CustomerDetail['email'];
        // echo db_connect()->showLastQuery();
        $PaymentDetail = $this->PembayaranModel->where(['id_customer' => $CustomerDetail['id']])->first();
        // dd($CustomerDetail);
        return view('send_email', array('title' => 'Email', 'detail_pembayaran' => $PaymentDetail, 'detail_customer' => $CustomerDetail, 'notif' => $notif));
    }


    public function redirection_handler()
    {
        // $name = $this->request->getGet('')
    }


    public function CobaSendEmail(string $customer_unique)
    {
        # code...
        $get_customer = $this->CustomerModel->where(['customer_unique' => $customer_unique])->get()->getRowArray();
        $email = $get_customer['email'];
        $alias = $get_customer['nama'];
        $subject = "Konfirmasi Pembayaran";
        $Layanan = new Layanan;

        $Email = \Config\Services::email();

        // $Email->initialize($config);
        $Email->setFrom('pendaftaran@quicktest.id', 'QuickTest.id INFO Pendaftaran');

        $Email->setTo($email);
        $Email->setSubject($subject);
        $data_konten = array('title' => 'Informasi Pendaftaran dan Pembayaran', 'nama' => $alias, 'layanan' => $Layanan, 'detail_customer' => $get_customer);
        $emailMessage = view('send_email', $data_konten);
        $Email->setMessage($emailMessage);
        $Email->attach($Layanan->getImageQRCode(base_url('api/hadir/danang-arif-rahmanda'), "danang_arif_rahmanda.png"));
        if ($Email->send()) {
            echo "Email successfully sent to " . $email;
            return $emailMessage;
        } else {
            $data = $Email->printDebugger(['headers']);
            print_r($data);
        }
    }
}
