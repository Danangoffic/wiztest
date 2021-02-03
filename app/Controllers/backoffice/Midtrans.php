<?php

namespace App\Controllers\backoffice;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\CURLRequest;
use Midtrans as GlobalMidtrans;

// use 
// use App\Controllers;
// use CodeIgniter\Controller;

class Midtrans extends BaseController
{
    protected $sysParam;
    public $SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.midtrans.com/snap/v1';
    public $SNAP_PRODUCTION_BASE_URL = 'https://app.midtrans.com/snap/v1';
    protected $ServerKeySandbox = "SB-Mid-server-njmm7T2YGKMdzauzJRLre29W";
    protected $ClientKeySandBox = "SB-Mid-client-FNK0ZdKVig8hiqwE";

    protected $midtrans_config;
    protected $midtrans_snap;
    protected $midtrans;
    public $production_mode;
    public function __construct()
    {
        $this->sysParam = new SystemParameter();
        $this->midtrans_config =  new \Midtrans\Config;
        $this->midtrans_snap = new \Midtrans\Snap;
        $this->midtrans = new \Midtrans;
        $this->production_mode = true;
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
        // echo "Masuk Midtrans controller";
        $Midtrans = new GlobalMidtrans();


        try {
            $vgroup = 'MIDTRANS_KEY';
            $paramter = 'SERVER_KEY';
            $DB = db_connect()->table('system_parameter')->select('*')->where('vgroup', $vgroup)->where('parameter', $paramter)->get()->getFirstRow();
            if ($DB == null) {
                return false;
            }
            $ServerKey = base64_decode($DB->value);
            $this->midtrans_config::$serverKey = $ServerKey;
            $this->midtrans_config::$isProduction = $this->production_mode;
            $this->midtrans_config::$isSanitized = true;
            $this->midtrans_config::$is3ds = true;
            // \Midtrans\Config::$serverKey = $ServerKey;
            // \Midtrans\Config::$isProduction = false;
            // // Set sanitization on (default)
            // \Midtrans\Config::$isSanitized = true;
            // // Set 3DS transaction for credit card to true
            // \Midtrans\Config::$is3ds = true;

            $snapToken = $this->midtrans_snap->getSnapToken($params);
            $CreateTrans = $this->midtrans_snap->createTransaction($params);

            if ($snapToken) {
                return ['data' => $CreateTrans, 'statusMessage' => 'success'];
            } else {
                return ['statusMessage' => 'Failed'];
            }
            // $Snap = $Midtrans->getSnapToken($params);

        } catch (\Throwable $th) {
            //throw $th;
            return ['statusMessage' => 'Error. ' . $th->getMessage()];
        }
    }

    public function getStatusByOrderId(string $OrderId)
    {
        $returnArray = array();
        try {
            $db_param = db_connect()->table('system_parameter')->where(['vgroup' => 'MIDTRANS_KEY', 'parameter' => 'SERVER_KEY'])->get()->getFirstRow();
            $EncodeduserNameKey = $db_param->value;
            $decodedUsernameKey = base64_decode($EncodeduserNameKey);

            $configMidtrans = array(
                'server_key' => $decodedUsernameKey,
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

    // const SANDBOX_BASE_URL = 'https://api.sandbox.veritrans.co.id/v2';
    // const PRODUCTION_BASE_URL = 'https://api.veritrans.co.id/v2';

    //--------------------------------------------------------------------

}
