<?php

namespace App\Controllers;
// use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\PembayaranModel;
use CodeIgniter\Controller;
// use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;

// if (!defined('BASEPATH')) exit('No direct script access allowed');

class Handler extends ResourceController
{

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -  
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    protected $veritrans;
    protected $midtrans;
    protected $CustomerModel;
    protected $PembayaranModel;
    function __construct()
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
        $data_key = db_connect()->table('system_parameter')->where(['vgroup' => 'MIDTRANS_KEY', 'parameter' => 'SERVER_KEY'])->get()->getFirstRow();
        $serverKey = $data_key->value;
        $usernameServerKey = base64_decode($serverKey);
        $fullServerKey = $usernameServerKey . ":";
        $encodeFull = base64_encode($fullServerKey);
        // echo $serverKey;
        // echo base64_decode($serverKey);
        $params = array(
            'server_key' => $fullServerKey,
            'production' => false
        );
        $this->midtrans->config($params);
        // $this->veritrans->config($params);
        echo 'test notification handler';
        $json_result = file_get_contents('php://input');
        $result = json_decode($json_result);

        if ($result) {
            $notif = $this->midtrans->status($result->order_id);
            return $this->proses_notif($notif);
            // $notif = $this->veritrans->status($result->order_id);
        }

        error_log(print_r($result, TRUE));
    }

    protected function proses_notif($notif)
    {
        $transaction = $notif->transaction_status;
        $type = $notif->payment_type;
        $order_id = $notif->order_id;
        $fraud = $notif->fraud_status;

        $customer_check = $this->CustomerModel->where(['customer_unique' => $order_id])->first();
        if ($customer_check) {
            $payemnt_check = $this->PembayaranModel->find($customer_check['id']);
            if ($payemnt_check) {
            }
        }

        if ($transaction == 'capture') {
            // For credit card transaction, we need to check whether transaction is challenge by FDS or not
            if ($type == 'credit_card') {
                if ($fraud == 'challenge') {
                    // TODO set payment status in merchant's database to 'Challenge by FDS'
                    // TODO merchant should decide whether this transaction is authorized or not in MAP
                    echo "Transaction order_id: " . $order_id . " is challenged by FDS";
                } else {
                    // TODO set payment status in merchant's database to 'Success'
                    echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
                }
            }
        } else if ($transaction == 'settlement') {
            // TODO set payment status in merchant's database to 'Settlement'
            echo "Transaction order_id: " . $order_id . " successfully transfered using " . $type;
        } else if ($transaction == 'pending') {
            // TODO set payment status in merchant's database to 'Pending'
            echo "Waiting customer to finish transaction order_id: " . $order_id . " using " . $type;
        } else if ($transaction == 'deny') {
            // TODO set payment status in merchant's database to 'Denied'
            echo "Payment using " . $type . " for transaction order_id: " . $order_id . " is denied.";
        }
    }
}
