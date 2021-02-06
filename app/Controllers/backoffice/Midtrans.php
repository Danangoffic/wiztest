<?php

namespace App\Controllers\backoffice;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\CURLRequest;
use CodeIgniter\RESTful\ResourceController;
use Midtrans as GlobalMidtrans;

// use 
// use App\Controllers;
// use CodeIgniter\Controller;

class Midtrans extends ResourceController
{
    protected $sysParam;
    public $SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.midtrans.com/snap/v1';
    public $SNAP_PRODUCTION_BASE_URL = 'https://app.midtrans.com/snap/v1';

    protected $snap_url_prod = "https://app.midtrans.com/snap/snap.js";
    protected $snap_url_dev = "https://app.sandbox.midtrans.com/snap/snap.js";

    protected $server_key_prod = "Mid-server-ziBWgMIMvdY6Xd7PsTgBdnEz";
    protected $client_key_prod = "Mid-client-coq-IuJTF1nZLqTE";

    protected $server_key_dev = "SB-Mid-server-QkrkR-LkKVtR3SeHfFH5roM4";
    protected $client_key_dev = "SB-Mid-client-mp4wARPRYp1RjrBO";

    protected $midtrans_config;
    protected $midtrans_snap;
    protected $midtrans;
    public $production_mode;
    public $server_key;
    public $client_key;
    public $snap_url_js;
    public function __construct()
    {
        //set production mode (true to production mode, false to development mode)
        $this->production_mode = true;

        //set serverkey, clientkey, snapurljs on customers payment where production mode is set
        $this->server_key = ($this->production_mode) ? $this->server_key_prod : $this->server_key_dev;
        $this->client_key = ($this->production_mode) ? $this->client_key_prod : $this->client_key_dev;
        $this->snap_url_js = ($this->production_mode) ? $this->snap_url_prod : $this->snap_url_dev;
    }

    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        // dd($this->session->get('nama'));
        return view('backoffice/layanan/index');
    }

    public function services()
    {
    }

    public function getToken($params)
    {

        try {

            \Midtrans\Config::$serverKey = $this->server_key;
            \Midtrans\Config::$isProduction = $this->production_mode;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $CreateTrans = \Midtrans\Snap::createTransaction($params);

            if ($snapToken) {
                return ['data' => $CreateTrans, 'statusMessage' => 'success'];
            } else {
                return ['statusMessage' => 'Failed'];
            }
        } catch (\Throwable $th) {
            //throw $th;
            return ['statusMessage' => 'Error. ' . $th->getMessage()];
        }
    }

    public function get_status_midtrans($order_id = null)
    {
        $returnArray = array();
        try {
            $configMidtrans = array(
                'server_key' => $this->server_key,
                'production' => $this->production_mode
            );
            // echo "Selesai";
            $this->midtrans->config($configMidtrans);
            $returnArray = $this->midtrans->status($order_id);

            // return $StatusMidtrans;
        } catch (\Throwable $th) {
            $returnArray = ['status_message' => 'failed. ' . $th->getMessage()];
        }
        return $returnArray;
    }

    public function getStatusByOrderId(string $OrderId)
    {
        $returnArray = array();
        try {

            $configMidtrans = array(
                'server_key' => $this->server_key,
                'production' => $this->production_mode
            );
            // echo "Selesai";
            $this->midtrans->config($configMidtrans);
            $returnArray = $this->midtrans->status($OrderId);

            // return $StatusMidtrans;
        } catch (\Throwable $th) {
            $returnArray = array('statusMessage' => 'failed. ' . $th->getMessage());
        }
        return $returnArray;
    }

    public function handle_notification($order_id = null)
    {
        return $this->get_status_midtrans($order_id);
    }

    // const SANDBOX_BASE_URL = 'https://api.sandbox.veritrans.co.id/v2';
    // const PRODUCTION_BASE_URL = 'https://api.veritrans.co.id/v2';

    //--------------------------------------------------------------------

}
