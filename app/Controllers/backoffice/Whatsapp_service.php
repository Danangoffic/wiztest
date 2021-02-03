<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerCorporateModel;
use App\Models\CustomerHomeServiceModel;
use App\Models\CustomerModel;
use App\Models\KotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\LokasiPenginputanModel;
use App\Models\TestModel;
use App\Models\UserDetailModel;
use App\Models\UserLevelModel;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel;

class Whatsapp_service extends ResourceController
{
    protected $customer_model;
    protected $customer_home_service_model;
    protected $customers_corporate_model;
    protected $layanan_test_model;
    protected $layanan_model;
    protected $test_model;
    protected $layanan_bo;
    protected $api_key;
    public function __construct()
    {
        $this->customer_model = new CustomerModel();
        $this->customer_home_service_model = new CustomerHomeServiceModel();
        $this->customers_corporate_model = new CustomerCorporateModel();
        $this->layanan_test_model = new LayananTestModel();
        $this->test_model = new TestModel();
        $this->layanan_model = new LayananModel();
        $this->layanan_bo = new Layanan;
        $this->api_key = "a8d3096e3e52bc1cb7bdf376fe6a8eb3";
    }

    public function send_whatsapp_img_invoice($id_customer)
    {
        // header('Content-Type: application/json; charset=utf-8');

        $cek_customer = $this->customer_model->find($id_customer);
        if ($cek_customer && $cek_customer != null && count($cek_customer) == 1) {
            $phone = $cek_customer['phone'];
            if ($phone == "" || $phone == null) {
                return $this->fail("mobile phone is not recognised", 400, 'Failed');
            }
            $jenis_test = $cek_customer['jenis_test'];
            $layanan_test = $this->layanan_test_model->find($jenis_test);
            $id_layanan = $layanan_test['id_layanan'];
            $id_test = $layanan_test['id_test'];
            $layanan = $this->layanan_model->find($id_layanan);
            $test = $this->test_model->find($id_test);
            $tgl_kunjungan = $cek_customer['tgl_kunjungan'];
            $nama_layanan = $layanan['nama_layanan'];
            $nama_test = $test['nama_test'];
        } else {
            return $this->failForbidden();
        }
        $api_key_wasap = "a8d3096e3e52bc1cb7bdf376fe6a8eb3";

        // MAKE SURE PHONE NUMBER USING REGION CODE
        // $APIkey = $api_key_wasap;
        $phone = $phone;
        $message = 'Terima kasih kepada Bpk/Ibu ' . $cek_customer['nama'] .
            " yang telah melakukan pembayaran untuk mengikuti test *{$jenis_test}* pada tanggal *{$tgl_kunjungan}*. \n
            Berikut kami lampirkan Invoice beserta QR Code yang diperlukan saat anda hadir pada klinik kami.";
        $str = "https://reg.quicktest.id/api/hadir/" . $id_customer;
        $url_img = $this->layanan_bo->getUrlQRCode($str);

        $url = 'http://gowagateway-silly-platypus.mybluemix.net/sendimagemsg';
        $data = array(
            'APIKey'     => $this->api_key,
            'phoneNumber'  => $phone,
            'message' => $message,
            'urlDownloadImage' => $url_img,
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            return $this->fail('failed', 400, 'failed');
            // die("Connection Failure");
        }
        curl_close($curl);
        return $this->respond($result, 200, 'success');
    }

    public function coba_wa()
    {
        $api_key_wasap = "a8d3096e3e52bc1cb7bdf376fe6a8eb3";

        // MAKE SURE PHONE NUMBER USING REGION CODE
        $APIkey = $api_key_wasap;
        $phone = "081230759128";
        $message = "Hallo";
        // $url_img = $this->layanan_bo->getUrlBarCode("https://reg.quicktest.id/api/hadir/" . $id_customer);

        $url = 'http://gowagateway-silly-platypus.mybluemix.net/sendtxtmsg';
        $data = array(
            'APIKey'     => $this->api_key,
            'phoneNumber'  => $phone,
            'message' => $message,
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, 0);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

        // EXECUTE:
        $result = curl_exec($curl);
        if (!$result) {
            return $this->fail('failed', 400, 'failed');
            // die("Connection Failure");
        }
        curl_close($curl);
        return $this->respond($result, 200, 'success');
    }
}
