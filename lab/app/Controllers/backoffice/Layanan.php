<?php

namespace App\Controllers\backoffice;

use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\TestModel;
use CodeIgniter\Controller;
// use Dompdf\Cpdf;
use Dompdf\Dompdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Layanan extends Controller
{
    public $session;
    public $codeBarCode;
    public $dompdf;
    public function __construct()
    {
        $this->codeBarCode = "code128";;
        $this->session = session();
        $this->dompdf = new Dompdf();
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

    public function detail_layanan($id_layanan)
    {
        $modelLayananTest = new LayananTestModel();
        $modelLayanan = new LayananModel();
        $modelTest = new TestModel();
        $result_model = $modelLayananTest->find($id_layanan);
        $id_pemeriksaan = $result_model['id_test'];
        $id_layanan = $result_model['id_layanan'];
        $DataPemeriksaan = $modelTest->find($id_pemeriksaan);
        $DataLayanan = $modelLayanan->find($id_layanan);
        $resultData = [
            'id' => $id_layanan,
            'nama_test' => $DataPemeriksaan['nama_test'],
            'nama_layanan' => $DataLayanan['nama_layanan'],
            'biaya' => $result_model['biaya'],
        ];
        return $resultData;
    }

    public function printPDFCustomer($id)
    {
        view('backoffice/layanan/invoice_pdf');
    }

    protected function file_get_contents_curl($url)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);

        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    protected function get_qr_code(string $value = "")
    {
        $url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . $value . "&choe=UTF-8";
        return $url;
    }

    public function setCodeBarCode($code = "code128")
    {
        $this->codeBarCode = $code;
    }

    public function get_bar_code(string $value = "")
    {
        $url = "https://bwipjs-api.metafloor.com/?bcid=" . $this->codeBarCode . "&text=" . $value;
        return $url;
    }

    /*
    *$value = value of channel to use like url or name
    *$renamingFile = rename file like channel name, url name
    */
    public function getImageQRCode(string $value = "", $renamingFile)
    {
        $data = $this->file_get_contents_curl($this->getUrlQRCode($value));
        $fqr = $renamingFile . '.png';
        return file_put_contents($fqr, $data);
    }

    public function getUrlQRCode(string $value = "")
    {
        return $this->get_qr_code($value);
    }

    public function getUrlBarCode(string $value = "")
    {
        return $this->get_bar_code($value);
    }

    //--------------------------------------------------------------------

}
