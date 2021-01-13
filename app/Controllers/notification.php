<?php

namespace App\Controllers;
// use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\PembayaranModel;
use CodeIgniter\Controller;
use CodeIgniter\Email\Email;
// use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;


class Notification extends ResourceController
{
	protected $veritrans;
	protected $midtrans;
	protected $CustomerModel;
	protected $PembayaranModel;
	protected $notif;
	public function __construct()
	{
		// parent::__construct();
		// $params = array('server_key' => 'your_server_key', 'production' => false);
		// $this->load->library('veritrans');
		// $this->veritrans = new \Veritrans;
		$this->midtrans = new \Midtrans;
		$this->CustomerModel = new CustomerModel();
		$this->PembayaranModel = new PembayaranModel();
		// $this->veritrans->config($params);
		// $this->load->helper('url');
	}

	public function index()
	{

		// $this->veritrans->config($params);
		// echo 'test notification handler';
		$json_result = file_get_contents('php://input');
		$result = json_decode($json_result);

		if ($result !== null) {
			$data_key = db_connect()->table('system_parameter')->where(['vgroup' => 'MIDTRANS_KEY', 'parameter' => 'SERVER_KEY'])->get()->getFirstRow();
			$serverKey = $data_key->value;
			$params = array(
				'server_key' => $serverKey,
				'production' => false
			);
			$this->midtrans->config($params);
			$notif = $this->midtrans->status($result->order_id);
			$this->notif = $notif;
			return $this->respond($this->proses_notif(), 200, 'success');
			// $notif = $this->veritrans->status($result->order_id);
		}
		// echo "result is null";
		return $this->fail(array('responseMessage' => 'result is null', 'statusMessage' => 'failed'), 400, 'failed');
	}

	/**
	 * PROSES NOTIFIKASI mengambil dari objek $notif 
	 * yang sudah diambil melalui status midtrans
	 * 
	 * 
	 * @return $arrayReturn
	 */
	protected function proses_notif()
	{
		$notif = $this->notif;
		$transaction = $notif->transaction_status;
		$type = $notif->payment_type;
		$order_id = $notif->order_id;
		$fraud = $notif->fraud_status;

		$responseMessage = "";
		$responseStatus = "success";
		$customer_check = $this->CustomerModel->where(['customer_unique' => $order_id])->first();
		if ($customer_check) {
			$payemnt_check = $this->PembayaranModel->find($customer_check['id']);
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
	protected function midtrans_report(): string
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
	protected function sendEmailCustomer(string $order_id)
	{
		# code...
		$Email = \Config\Services::email();
		$config["protocol"] = "smtp";

		//isi sesuai nama domain/mail server
		$config["SMTPHost"]  = "danangoffic.xyz";

		//alamat email SMTP
		$config["SMTPUser"]  = "info@danangoffic.xyz";

		//password email SMTP
		$config["SMTPPass"]  = "info123";

		$config["SMTPPort"]  = 465;
		$config["SMTPCrypto"] = "ssl";
		$Email->initialize($config);

		$CustomerDetail = $this->CustomerModel->where(['customer_unique' => $order_id])->first();
		$emailCustomer = $CustomerDetail['email'];

		$Email->setFrom('info@quicktest.id', 'QuickTest.id INFO');
		$Email->setTo($emailCustomer);
		$Email->setSubject("Payment Info Dari Pendaftaran Melalui Quictest.id");
		$PaymentDetail = $this->PembayaranModel->where(['id_customer' => $CustomerDetail['id']])->first();

		$emailMessage = view('send_email', array('detail_pembayaran' => $PaymentDetail, 'detail_customer' => $CustomerDetail, 'notif' => $this->notif));
		$Email->sendMessage($emailMessage);
		$Email->send();
	}


	public function redirection_handler()
	{
	}
}
