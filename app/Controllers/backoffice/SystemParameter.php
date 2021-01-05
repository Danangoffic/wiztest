<?php

namespace App\Controllers\backoffice;

use App\Models\SystemParameterModel;
use CodeIgniter\Controller;
// use App\Controllers;
// use CodeIgniter\Controller;

class SystemParameter extends Controller
{


    public function index()
    {
        $SERVER_KEY = "SB-Mid-server-njmm7T2YGKMdzauzJRLre29W";
        $CLIENT_KEY = "SB-Mid-client-FNK0ZdKVig8hiqwE";

        $encrypted_serverkey = base64_encode($SERVER_KEY);
        $encrypted_clientkey = base64_encode($CLIENT_KEY);

        $decrypted_serverkey = base64_decode($encrypted_serverkey);
        $decrypted_clientkey = base64_decode($encrypted_clientkey);

        echo "Server Key : " . $encrypted_serverkey . "<br>";
        echo "CLient Key : " . $encrypted_clientkey . "<br>";
        echo "decrypted server : " . $decrypted_serverkey . "<br>";
        echo "decrypted client : " . $decrypted_clientkey . "<br>";

        $url_get_token = 'https://app.sandbox.midtrans.com/snap/v1/transactions';
        // $url_
    }

    public function getApplicationConstant(string $VGROUP, string $PARAMTER)
    {
        $systemParam = new SystemParameterModel();
        $getData = $systemParam->getByVgroupAndParamter($VGROUP, $PARAMTER);
        if ($getData) {
            $encValue = $getData['value'];
            $decValue = base64_decode($encValue);
            return $decValue;
        } else {
            return NULL;
        }
    }

    public function getApplicationConstant2(string $VGROUP, string $PARAMTER)
    {
        $systemParam = new SystemParameterModel();
        $getData = $systemParam->getByVgroupAndParamter($VGROUP, $PARAMTER);
        if ($getData) {
            return $getData['value'];
        } else {
            return NULL;
        }
    }

    //--------------------------------------------------------------------

}
