<?php

namespace App\Controllers;
// use App\Controllers\BaseController;

use App\Controllers\backoffice\Layanan;
use App\Controllers\backoffice\Midtrans as MidtransBO;
use App\Controllers\backoffice\Whatsapp_service;
use App\Models\CustomerModel;
use App\Models\PemanggilanModel;
use App\Models\PembayaranModel;
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
    protected $Midtrans_bo;
    protected $pdf_file;
    protected $qr_code;
    public function __construct()
    {

        $this->midtrans = new \Midtrans;
        $this->CustomerModel = new CustomerModel();
        $this->PembayaranModel = new PembayaranModel();
        $this->Midtrans_bo = new MidtransBO;
        // $this->production_mode = $this->Midtrans_bo->production_mode;
    }

    public function index()
    {

        \Midtrans\Config::$isProduction = $this->Midtrans_bo->production_mode;
        \Midtrans\Config::$serverKey = $this->Midtrans_bo->server_key;
        $notification_receiver = new \Midtrans\Notification();
        try {

            $order_id = $notification_receiver->order_id;
            $status_code = $notification_receiver->status_code;

            $customer_check = $this->CustomerModel->get_by_customer_unique($order_id);

            $arrayReturn = $this->return_handler_midtrans($customer_check, $notification_receiver);

            return $this->respond($arrayReturn, $status_code, $arrayReturn['statusMessage']);
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

    protected function return_handler_midtrans(array $customer_check, $notification_receiver)
    {
        $transaction = $notification_receiver->transaction_status;
        $type = $notification_receiver->payment_type;
        $order_id = $notification_receiver->order_id;
        $fraud = $notification_receiver->fraud_status;
        $gross_amount = $notification_receiver->gross_amount;
        $status_code = $notification_receiver->status_code;
        $PemanggilanModel = new PemanggilanModel();

        $arrayReturn = array();
        if ($customer_check != null) {
            $id_customer = $customer_check['id'];
            $bilik = $customer_check['nomor_bilik'];
            $antrian = $customer_check['no_antrian'];
            // send email and whatsapp first then update //


            $id_layanan_test = $customer_check['jenis_test'];
            $payemnt_check = $this->PembayaranModel->pembayaran_by_customer($id_customer);

            $tgl_kunjungan = $customer_check['tgl_kunjungan'];
            $jam_kunjungan = $customer_check['jam_kunjungan'];
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
                    'status_pemanggilan' => '11',
                    'tgl_kunjungan' => $tgl_kunjungan,
                    'jam_kunjungan' => $jam_kunjungan,
                    'bilik' => $bilik,
                    'antrian' => $antrian
                );

                /**
                 * UPDATE CUSTOMER UNTUK STATUS PEMBAYARAN
                 * UPDATE PEMBAYARAN
                 * INSERT PADA DATA PEMANGGILAN SESUAI TGL KUNJUNGAN DAN JAM KUNJUNGAN
                 */
                $updateCustomer = $this->CustomerModel->update($id_customer, $arrayCustomerUpdate);
                $updatePayment = $this->PembayaranModel->update($id_pembayaran, $arrayPembayaranUpdate);
                $createPemanggilanCustomer = $PemanggilanModel->insert($arrayInsertPemanggilan);

                if ($updateCustomer && $updatePayment && $createPemanggilanCustomer) {

                    $responseStatus = $notification_receiver->status_message;
                    $responseMessage = $notification_receiver->status_message;
                    $arrayReturn = array(
                        'statusMessage' => $responseStatus,
                        'responseMessage' => $responseMessage,
                        'paymentType' => $type,
                        'orderId' => $order_id,
                        'transactionStatus' => $transaction,
                        'detailCustomer' => $customer_check,
                        'detailPaymentCustomer' => $payemnt_check,
                        'statusCode' => $status_code,
                        'fraud' => $fraud,
                        'midtrans_response' => (array) $notification_receiver
                    );

                    /**
                     * SEND EMAIL AND WHATSAPP TO CUSTOMER
                     */
                    if ($transaction == "settlement" || $transaction == "capture") {
                        if ($this->sendEmailCustomer($order_id, $notification_receiver)) {
                            $this->send_whatsapp($id_customer);
                        }
                    }
                } else {
                    $responseStatus = $notification_receiver->status_message;
                    $responseMessage = "Failed update customer";
                    $arrayReturn = array(
                        'statusMessage' => $responseStatus,
                        'responseMessage' => $responseMessage,
                        'paymentType' => $type,
                        'orderId' => $order_id,
                        'transactionStatus' => $transaction,
                        'detailCustomer' => $customer_check,
                        'detailPaymentCustomer' => $payemnt_check,
                        'statusCode' => $status_code,
                        'fraud' => $fraud,
                        'midtrans_response' => $notification_receiver
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
                    'statusCode' => $status_code,
                    'fraud' => $fraud,
                    'midtrans_response' => $notification_receiver
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
                'statusCode' => $status_code,
                'fraud' => $fraud,
                'midtrans_response' => $notification_receiver
            );
        }
        return $arrayReturn;
    }



    /**
     * Send email to customer user 
     * 
     */
    public function sendEmailCustomer(string $order_id, $notif_modtrans)
    {
        # code...

        $Layanan = new Layanan;

        $Email = \Config\Services::email();

        // $Email->initialize($config);

        $CustomerDetail = $this->CustomerModel->get_by_customer_unique($order_id);
        $emailCustomer = $CustomerDetail['email'];
        $id_customer = $CustomerDetail['id'];
        $nama_customer = $CustomerDetail['nama'];
        $invoice_number = $CustomerDetail['invoice_number'];

        $PaymentDetail = $this->PembayaranModel->pembayaran_by_customer($id_customer);


        // $img = file_get_contents($attachment);
        // $file_img = basename($img);
        // write_file("assets/qr_code/" . $file_img, $img);
        // $img_QR_att =
        // $attachment_name = $file_img;
        $pdf_url = base_url('api/print_invoice/no-ttd/' . $invoice_number . "?attachment=1");
        $layanan = new Layanan;
        $pdf_name = "Invoice-" . $CustomerDetail['nama'] . "-{$invoice_number}";
        $qr_name = "qr_code_" . $CustomerDetail['nama'] . "_" . $CustomerDetail['id'];
        $encode_id = base64_encode($CustomerDetail['id']);
        $put_pdf = $layanan->put_content_pdf($pdf_url, $pdf_name);
        $put_qr = $layanan->put_content_qr_code($encode_id, $qr_name);
        $pdf_file = base_url('assets/pdf/' . $pdf_name . ".pdf");
        $qr_image = base_url('assets/qr/' . $qr_name . ".png");
        $data_email = array(
            'detail_pembayaran' => $PaymentDetail,
            'detail_customer' => $CustomerDetail,
            'notif' => $notif_modtrans,
            'title' => 'Informasi Pembayaran dan Pendaftaran',
            'qr_image' => $qr_name,
            'pdf_file' => $pdf_file
        );

        // file_get

        $emailMessage = view('send_email', $data_email);

        $Email->setTo($emailCustomer);
        $Email->setFrom('pendaftaran@quicktest.id', 'Pendaftaran QuickTest.id');
        $Email->setSubject("Informasi Pembayaran dan Pendaftaran Quictest.id");
        $Email->setMessage($emailMessage);
        $Email->attach($qr_image, 'inline', "{$qr_name}.png", "image/png");
        $Email->attach(
            $pdf_file,
            'inline',
            "{$pdf_name}.pdf",
            "application/pdf"
        );
        if ($Email->send()) {
            return true;
        } else {
            $data = $Email->printDebugger(['headers']);
            print_r($data);
        }
    }

    public function send_whatsapp($id_customer = null): bool
    {
        if ($id_customer != null) {
            $whatsapp_service = new Whatsapp_service;
            if ($whatsapp_service->send_whatsapp_QR($id_customer)) {
                return $whatsapp_service->send_whatsapp_invoice($id_customer);
            }
        } else {
            return false;
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


    // public function CobaSendEmail(string $customer_unique)
    // {
    //     # code...
    //     $get_customer = $this->CustomerModel->where(['customer_unique' => $customer_unique])->get()->getRowArray();
    //     $email = $get_customer['email'];
    //     $alias = $get_customer['nama'];
    //     $subject = "Konfirmasi Pembayaran";
    //     $Layanan = new Layanan;

    //     $Email = \Config\Services::email();

    //     // $Email->initialize($config);
    //     $Email->setFrom('pendaftaran@quicktest.id', 'QuickTest.id INFO Pendaftaran');

    //     $Email->setTo($email);
    //     $Email->setSubject($subject);
    //     $data_konten = array('title' => 'Informasi Pendaftaran dan Pembayaran', 'nama' => $alias, 'layanan' => $Layanan, 'detail_customer' => $get_customer);
    //     $emailMessage = view('send_email', $data_konten);
    //     $Email->setMessage($emailMessage);
    //     $Email->attach($Layanan->getImageQRCode(base_url('api/hadir/danang-arif-rahmanda'), "danang_arif_rahmanda.png"));
    //     if ($Email->send()) {
    //         echo "Email successfully sent to " . $email;
    //         return $emailMessage;
    //     } else {
    //         $data = $Email->printDebugger(['headers']);
    //         print_r($data);
    //     }
    // }

    /**
     * store response message from midtrans report
     * @return string responseMessage from midtrans status
     */
    // public function midtrans_report(): string
    // {
    //     $responseMessage = "";
    //     $notif = $this->notif;
    //     $transaction = $notif->transaction_status;
    //     $type = $notif->payment_type;
    //     $order_id = $notif->order_id;
    //     $fraud = $notif->fraud_status;
    //     if ($transaction == 'capture') {
    //         // For credit card transaction, we need to check whether transaction is challenge by FDS or not
    //         if ($type == 'credit_card') {
    //             if ($fraud == 'challenge') {
    //                 // TODO set payment status in merchant's database to 'Challenge by FDS'
    //                 // TODO merchant should decide whether this transaction is authorized or not in MAP
    //                 // echo "Transaction order_id: " . $order_id . " is challenged by FDS";
    //                 $responseMessage = "Transaction order_id: " . $order_id . " is challenged by FDS";
    //             } else {
    //                 // TODO set payment status in merchant's database to 'Success'
    //                 echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
    //                 $responseMessage = "Transaction order_id: " . $order_id . " successfully captured using " . $type;
    //             }
    //         }
    //     } else if ($transaction == 'settlement') {
    //         // TODO set payment status in merchant's database to 'Settlement'
    //         // echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
    //         $responseMessage = "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
    //     } else if ($transaction == 'pending') {
    //         // TODO set payment status in merchant's database to 'Pending'
    //         // echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
    //         $responseMessage = "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
    //     } else if ($transaction == 'deny') {
    //         // TODO set payment status in merchant's database to 'Denied'
    //         // echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
    //         $responseMessage = "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
    //     }
    //     return $responseMessage;
    // }

    /**
     * PROSES NOTIFIKASI mengambil dari objek $notif 
     * yang sudah diambil melalui status midtrans
     * 
     * 
     * @return $arrayReturn
     */
    // protected function proses_notif($notif)
    // {
    //     // $notif = $this->notif;
    //     $transaction = $notif->transaction_status;
    //     $type = $notif->payment_type;
    //     $order_id = $notif->order_id;
    //     $fraud = $notif->fraud_status;

    //     $responseMessage = "";
    //     $responseStatus = "success";
    //     $customer_check = $this->CustomerModel->get_by_customer_unique($order_id);
    //     // return $customer_check;
    //     if ($customer_check) {
    //         $id_customer = $customer_check['id'];
    //         $payemnt_check = $this->PembayaranModel->pembayaran_by_customer($id_customer);
    //         if ($payemnt_check) {
    //             $arrayCustomerUpdate = array(
    //                 'status_pembayaran' => $transaction
    //             );
    //             $arrayPembayaranUpdate = array(
    //                 'amount' => $notif->gross_amount,
    //                 'jenis_pembayaran' => $type,
    //                 'status_pembayaran' => $transaction
    //             );
    //             $updateCustomer = $this->CustomerModel->update($customer_check['id'], $arrayCustomerUpdate);
    //             $updatePayment = $this->PembayaranModel->update($payemnt_check['id'], $arrayPembayaranUpdate);
    //             if ($updateCustomer && $updatePayment) {
    //                 $responseStatus = "success";
    //                 $responseMessage = $this->midtrans_report();
    //             }
    //         } else {
    //             $responseStatus = "failed";
    //         }
    //     } else {
    //         $responseStatus = "failed";
    //     }


    //     $arrayReturn = array(
    //         'statusMessage' => $responseStatus,
    //         'responseMessage' => $responseMessage,
    //         'paymentType' => $type,
    //         'orderId' => $order_id,
    //         'transactionStatus' => $transaction,
    //         'detailCustomer' => $customer_check,
    //         'detailPaymentCustomer' => $payemnt_check,
    //         'statusCode' => $notif->status_code
    //     );
    //     return $arrayReturn;
    // }
}
