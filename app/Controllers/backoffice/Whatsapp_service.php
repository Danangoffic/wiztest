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
    protected $url_send_txt;
    protected $url_send_txt_img;
    protected $curl;
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
        $this->url_send_txt = 'http://gowagateway-silly-platypus.mybluemix.net/sendtxtmsg';
        $this->url_send_txt_img = 'http://gowagateway-silly-platypus.mybluemix.net/sendimagemsg';
    }

    public function send_whatsapp_QR($id_customer)
    {
        // header('Content-Type: application/json; charset=utf-8');

        $cek_customer = $this->customer_model->find($id_customer);
        if ($cek_customer == null) {
            return $this->failForbidden();
        }
        $phone = $cek_customer['phone'];
        if ($phone == "" || $phone == null) {
            return $this->fail("mobile phone is not recognised", 400, 'Failed');
        }
        $new_phone = $this->new_phone_number($phone);
        // $get_0 = substr($phone, 0, 1);
        // if ($get_0 == "0" || $get_0 == 0) {
        //     $new_0_to_region = str_replace("0", "62", $get_0);
        //     $new_phone = (int)$phone;
        //     $new_phone = $new_0_to_region . $new_phone;
        // } else {
        //     $new_phone = $phone;
        // }
        $jenis_test = $cek_customer['jenis_test'];
        $layanan_test = $this->layanan_test_model->find($jenis_test);
        $id_layanan = $layanan_test['id_layanan'];
        $id_test = $layanan_test['id_test'];
        $layanan = $this->layanan_model->find($id_layanan);
        $test = $this->test_model->find($id_test);
        $tgl_kunjungan = $cek_customer['tgl_kunjungan'];
        $nama_layanan = $layanan['nama_layanan'];
        $nama_test = $test['nama_test'];

        // MAKE SURE PHONE NUMBER USING REGION CODE
        // $APIkey = $api_key_wasap;
        // $phone = $new_phone;
        $message = 'Terima kasih kepada Bpk/Ibu ' . $cek_customer['nama'] .
            " yang telah melakukan pembayaran pada kami untuk mengikuti test *{$jenis_test}* pada tanggal *{$tgl_kunjungan}*. \n
            Berikut kami lampirkan QR Code yang diperlukan saat anda hadir pada klinik kami.";
        $str = base_url("/api/hadir/" . $id_customer);
        $url_img = $this->layanan_bo->getUrlQRCode($str);
        // $image = "<img download src=data:image/png;base64," . base64_encode($url_img) . ">";
        $url = $this->url_send_txt_img;
        $data = array(
            'APIKey'     => $this->api_key,
            'phoneNumber'  => $new_phone,
            'message' => $message,
            'urlDownloadImage' => $url_img,
        );

        $result = $this->send_curl($url, $data);
        if (!$result) {
            // return $this->fail('failed', 400, 'failed');
            return false;
            // die("Connection Failure");
        }
        curl_close($this->curl);
        return true;
        // return $this->respond($result, 200, 'success');
    }

    protected function send_curl($url, $data)
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_URL, $url);
        curl_setopt($this->curl, CURLOPT_HEADER, 0);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($this->curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->curl, CURLOPT_TIMEOUT, 600);
        curl_setopt($this->curl, CURLOPT_POST, 1);
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $data);

        // EXECUTE:
        return curl_exec($this->curl);
    }

    public function send_whatsapp_invoice($id_customer = null)
    {
        if ($id_customer == null) {
            return $this->failForbidden();
        }
        $cek_customer = $this->customer_model->find($id_customer);
        if ($cek_customer == null) {
            return $this->failNotFound();
        }
        $no_invoice = $cek_customer['invoice_number'];
        $phone = $cek_customer['phone'];
        if ($phone == "" || $phone == null) {
            return $this->fail("mobile phone is not recognised", 400, 'Failed');
        }
        $new_phone = $this->new_phone_number($phone);
        // $get_0 = substr($phone, 0, 1);
        // if ($get_0 == "0") {
        //     $new_0_to_region = str_replace("0", "+62", $get_0);
        //     $new_phone = (int)$phone;
        //     $new_phone = $new_0_to_region . $new_phone;
        // } else {
        //     $new_phone = $phone;
        // }
        $jenis_test = $cek_customer['jenis_test'];
        $layanan_test = $this->layanan_test_model->find($jenis_test);
        $id_layanan = $layanan_test['id_layanan'];
        $id_test = $layanan_test['id_test'];
        $layanan = $this->layanan_model->find($id_layanan);
        $test = $this->test_model->find($id_test);
        $tgl_kunjungan = $cek_customer['tgl_kunjungan'];
        $nama = $cek_customer['nama'];
        $nama_layanan = $layanan['nama_layanan'];
        $nama_test = $test['nama_test'];

        // MAKE SURE PHONE NUMBER USING REGION CODE
        // $APIkey = $api_key_wasap;
        // $phone = $new_phone;
        $message = "Terima kasih kepada Bpk/Ibu {$nama} " .
            " yang telah melakukan pembayaran pada kami untuk mengikuti test *{$jenis_test}* pada tanggal *{$tgl_kunjungan}*. \n
            Berikut kami lampirkan Invoice. " . base_url('/api/print_invoice/no-ttd/' . $no_invoice);

        $url = $this->url_send_txt;
        $data = array(
            'APIKey'     => $this->api_key,
            'phoneNumber'  => $new_phone,
            'message' => $message
        );

        $result = $this->send_curl($url, $data);
        if (!$result) {
            // return $this->fail('failed', 400, 'failed');
            return false;
            // die("Connection Failure");
        }
        curl_close($this->curl);
        // return $this->respond($result, 200, 'success');
        return true;
    }

    protected function new_phone_number($nohp = ""): string
    {
        // penulisan no hp 0811 239 345
        $nohp = str_replace(" ", "", $nohp);
        // penulisan no hp (0274) 778787
        $nohp = str_replace("(", "", $nohp);
        // penulisan no hp (0274) 778787
        $nohp = str_replace(")", "", $nohp);
        // penulisan no hp 0811.239.345
        $nohp = str_replace(".", "", $nohp);

        // cek apakah no hp mengandung karakter + dan 0-9
        if (!preg_match('/[^+0-9]/', trim($nohp))) {
            // cek apakah no hp karakter 1-3 adalah +62
            if (substr(trim($nohp), 0, 2) == '62') {
                $hp = trim($nohp);
            }
            // cek apakah no hp karakter 1 adalah 0
            elseif (substr(trim($nohp), 0, 1) == '0') {
                $hp = '62' . substr(trim($nohp), 1);
            } elseif (substr(trim($nohp), 0, 1) == '8') {
                $hp = '62' . $nohp;
            }
        }
        return $hp;
    }

    public function coba_wa()
    {
        $api_key_wasap = "a8d3096e3e52bc1cb7bdf376fe6a8eb3";

        // MAKE SURE PHONE NUMBER USING REGION CODE
        $APIkey = $api_key_wasap;
        $phone = $this->new_phone_number("081230759128");
        $message = "Hallo Danang";
        // $url_img = $this->layanan_bo->getUrlBarCode("https://reg.quicktest.id/api/hadir/" . $id_customer);

        $url = $this->url_send_txt;
        $data = array(
            'APIKey'     => $this->api_key,
            'phoneNumber'  => $phone,
            'message' => $message,
        );

        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_HEADER, 0);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
        // curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        // curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        // curl_setopt($curl, CURLOPT_POST, 1);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        $result = $this->send_curl($url, $data);

        // EXECUTE:
        // $result = curl_exec($this->curl);
        if (!$result) {
            return $this->fail('failed', 400, 'failed');
            // die("Connection Failure");
        }
        curl_close($this->curl);
        return $this->respond($result, 200, 'success');
    }
}
