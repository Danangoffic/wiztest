<?php

namespace App\Controllers\backoffice;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CURLRequest;
use Midtrans as GlobalMidtrans;

// use 
// use App\Controllers;
// use CodeIgniter\Controller;

class Midtrans extends Controller
{
    protected $sysParam;
    public $SNAP_SANDBOX_BASE_URL = 'https://app.sandbox.midtrans.com/snap/v1';
    public $SNAP_PRODUCTION_BASE_URL = 'https://app.midtrans.com/snap/v1';
    protected $ServerKeySandbox = "SB-Mid-server-njmm7T2YGKMdzauzJRLre29W";
    protected $ClientKeySandBox = "SB-Mid-client-FNK0ZdKVig8hiqwE";
    public function __construct()
    {
        $this->sysParam = new SystemParameter();
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
            $encrypted_server = $DB->value;
            $ServerKey = base64_decode($encrypted_server);
            \Midtrans\Config::$serverKey = "SB-Mid-server-njmm7T2YGKMdzauzJRLre29W";
            \Midtrans\Config::$isProduction = false;
            // Set sanitization on (default)
            \Midtrans\Config::$isSanitized = true;
            // Set 3DS transaction for credit card to true
            \Midtrans\Config::$is3ds = true;

            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $CreateTrans = \Midtrans\Snap::createTransaction($params);



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
            $MidtransService = new \Midtrans;
            $configMidtrans = array(
                'server_key' => $decodedUsernameKey,
                'production' => false
            );
            // echo "Selesai";
            $MidtransService->config($configMidtrans);
            $returnArray = $MidtransService->status($OrderId);

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
