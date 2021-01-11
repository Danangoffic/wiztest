<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\PemeriksaanModel;
use App\Models\TestModel;
use CodeIgniter\Controller;
use CodeIgniter\RESTful\ResourceController;
// use Dompdf\Cpdf;
use Dompdf\Dompdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Layanan extends ResourceController
{
    public $session;
    public $codeBarCode;
    public $dompdf;
    public $pdf;
    protected $customer;
    public function __construct()
    {
        $this->codeBarCode = "code128";;
        $this->session = session();
        $this->dompdf = new Dompdf();
        $this->customer = new CustomerModel();
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
        $data = array(
            'session' => session(),
            'page' => 'invoice',
            'title' => 'Invoice'
        );
        // $pdf = new PdfExtender;
        $html = view('backoffice/layanan/invoice_pdf_print', $data);
        $this->dompdf->loadHtml($html);
        // Render the PDF
        $this->dompdf->render();
        // Output the generated PDF to Browser
        $this->dompdf->stream($this->filename, array("Attachment" => false));
        // $pdf->setPaper('A4');
        // $pdf->setFilename('Invoice.pdf');
        // $pdf->load_view('backoffice/layanan/invoice_pdf_print', $data);
        // $output = $this->dompdf->output();
        // file_put_contents()
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

    public function hadir_by_qr_code(string $customer)
    {
        $JENIS_TEST_MODEL = new LayananTestModel();
        $PEMERIKSAAN_MODEL = new PemeriksaanModel();
        $TEST_MODEL = new TestModel();
        $id_customer = base64_decode($customer);
        $customerData = $this->customer->find($id_customer);
        if ($customerData) {
            $kehadiran = $customerData['kehadiran'];
            if ($kehadiran == 0 || $kehadiran == '0') {
                $updateKehadiran = array('kehadiran' => '1');
                $this->customer->update($id_customer, $updateKehadiran);
                $newCustomerData = $this->customer->find($id_customer);
                // $jenisTestData = $this->
            }
        }
    }

    public function printbarcode(string $encoded_id_customer)
    {
        $decoded = base64_decode($encoded_id_customer);
        $CustomerModel = new CustomerModel();
        $detailCustomer = $CustomerModel->find(base64_decode($encoded_id_customer));
        $url = base_url('api/peserta/' . $encoded_id_customer);
        $img_url = $this->get_bar_code($url);
        $type = pathinfo($img_url, PATHINFO_EXTENSION);
        $data = file_get_contents($img_url);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // It will be called downloaded.pdf
        $html = '<center><img importance="" width=\'200\' height=\'100\' src="' . $base64 . '" id=""></center>';
        $fileHTMLVIEW = view('backoffice/layanan/print_barcode', ['base64' => $base64, 'url' => $url, 'detailCustomer' => $detailCustomer, 'original_img' => $img_url, 'html_img' => $html]);
        return $fileHTMLVIEW;
        exit();
        // $htmlFile = base_url('backoffice/layanan/render_barcode/' . $encoded_id_customer, true);
        $this->dompdf->loadHtml($fileHTMLVIEW);
        $arraySize = array(0, 0, 250, 150);
        $this->dompdf->setPaper($arraySize);
        $this->dompdf->render();
        $this->dompdf->stream('barcode.pdf', ['Attachment' => false]);
        // readfile("fileinit.pdf");

        // return view('backoffice/Layanan/print_barcode', ['img_url' => $img_url]);
    }

    public function coba_barcode($id_customer)
    {
        $CustomerModel = new CustomerModel();
        $detailCustomer = $CustomerModel->find($id_customer);
        $url = $detailCustomer['customer_unique'];
        $this->codeBarCode = "code128";
        $img_url = $this->get_bar_code(urlencode($url));
        $type = pathinfo($img_url, PATHINFO_EXTENSION);
        $data = file_get_contents($img_url);
        $base64 = 'data:image/png' . ';base64,' . base64_encode($data);
        // It will be called downloaded.pdf
        $html = '<center><img importance="" width=\'200\' height=\'100\' src="' . $img_url . '" id=""></center>';
        // $fileHTMLVIEW = view('backoffice/layanan/print_barcode', ['base64' => $base64, 'url' => $url, 'detailCustomer' => $detailCustomer, 'original_img' => $img_url, 'html_img' => $html]);
        // return $fileHTMLVIEW;
        // exit();
        // $htmlFile = base_url('backoffice/layanan/render_barcode/' . $encoded_id_customer, true);
        $this->dompdf->loadHtml($html);
        $arraySize = array(0, 0, 250, 150);
        $this->dompdf->setPaper($arraySize);
        $this->dompdf->render();
        $this->dompdf->stream('barcode.pdf', ['Attachment' => false]);
    }

    //--------------------------------------------------------------------

}
