<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\PemeriksaanModel;
use App\Models\TestModel;
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

    public function print_pdf(int $id_customer = 0)
    {
        if ($id_customer == 0) {
            return redirect()->back();
        }
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
        $url = $detailCustomer['customer_unique'];
        $img_url = $this->get_bar_code($url);
        $type = pathinfo($img_url, PATHINFO_EXTENSION);
        $data = file_get_contents($img_url);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        // It will be called downloaded.pdf
        $html = '<center>' . $detailCustomer['nama'] . '<br><img importance="" width=\'150\' height=\'75\' src="' . $base64 . '" id=""></center>';
        $fileHTMLVIEW = view('backoffice/layanan/print_barcode', ['base64' => $base64, 'url' => $url, 'detailCustomer' => $detailCustomer, 'original_img' => $img_url, 'html_img' => $html]);
        // return $fileHTMLVIEW;
        // exit();
        // $htmlFile = base_url('backoffice/layanan/render_barcode/' . $encoded_id_customer, true);
        $this->dompdf->loadHtml($fileHTMLVIEW);
        $arraySize = array(0, 0, 170, 190);
        $this->dompdf->setPaper($arraySize, 'landscape');
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

    public function get_encoded_peserta(int $id_customer)
    {
        $encoded_peserta = base64_encode($id_customer);
        print_r($encoded_peserta);
    }

    public function image_barcode_direct()
    {
        $src_image = "http://localhost:8080/backoffice/layanan/genereate_barcode_direct?text=SPB21011413022&codetype=code128&orientation=horizontal&size=30&print=false";
        $data = [
            'src_image' => $src_image,
            'title' => "Cetak Barcode"
        ];
        return view('backoffice/layanan/print_barcode', $data);
    }

    public function generate_image_barcode_string($value = ""): string
    {
        $src_image = "http://localhost:8080/backoffice/layanan/genereate_barcode_direct?text=" . $value . "&codetype=code128&orientation=horizontal&size=30&print=false";
        return $src_image;
    }

    public function genereate_barcode_direct()
    {
        $filepath = (isset($_GET["filepath"]) ? $_GET["filepath"] : "");
        $text = (isset($_GET["text"]) ? $_GET["text"] : "0");
        $size = (isset($_GET["size"]) ? $_GET["size"] : "20");
        $orientation = (isset($_GET["orientation"]) ? $_GET["orientation"] : "horizontal");
        $code_type = (isset($_GET["codetype"]) ? $_GET["codetype"] : "code128");
        $print = (isset($_GET["print"]) && $_GET["print"] == 'true' ? true : false);
        $sizefactor = (isset($_GET["sizefactor"]) ? $_GET["sizefactor"] : "1");

        // This function call can be copied into your project and can be made from anywhere in your code
        $image = $this->barcode($filepath, $text, $size, $orientation, $code_type, $print, $sizefactor);
    }

    function barcode($filepath = "", $text = "0", $size = "20", $orientation = "horizontal", $code_type = "code128", $print = false, $SizeFactor = 1)
    {
        $code_string = "";
        // Translate the $text into barcode the correct $code_type
        if (in_array(strtolower($code_type), array("code128", "code128b"))) {
            $chksum = 104;
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "\`" => "111422", "a" => "121124", "b" => "121421", "c" => "141122", "d" => "141221", "e" => "112214", "f" => "112412", "g" => "122114", "h" => "122411", "i" => "142112", "j" => "142211", "k" => "241211", "l" => "221114", "m" => "413111", "n" => "241112", "o" => "134111", "p" => "111242", "q" => "121142", "r" => "121241", "s" => "114212", "t" => "124112", "u" => "124211", "v" => "411212", "w" => "421112", "x" => "421211", "y" => "212141", "z" => "214121", "{" => "412121", "|" => "111143", "}" => "111341", "~" => "131141", "DEL" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "FNC 4" => "114131", "CODE A" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211214" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code128a") {
            $chksum = 103;
            $text = strtoupper($text); // Code 128A doesn't support lower case
            // Must not change order of array elements as the checksum depends on the array's key to validate final code
            $code_array = array(" " => "212222", "!" => "222122", "\"" => "222221", "#" => "121223", "$" => "121322", "%" => "131222", "&" => "122213", "'" => "122312", "(" => "132212", ")" => "221213", "*" => "221312", "+" => "231212", "," => "112232", "-" => "122132", "." => "122231", "/" => "113222", "0" => "123122", "1" => "123221", "2" => "223211", "3" => "221132", "4" => "221231", "5" => "213212", "6" => "223112", "7" => "312131", "8" => "311222", "9" => "321122", ":" => "321221", ";" => "312212", "<" => "322112", "=" => "322211", ">" => "212123", "?" => "212321", "@" => "232121", "A" => "111323", "B" => "131123", "C" => "131321", "D" => "112313", "E" => "132113", "F" => "132311", "G" => "211313", "H" => "231113", "I" => "231311", "J" => "112133", "K" => "112331", "L" => "132131", "M" => "113123", "N" => "113321", "O" => "133121", "P" => "313121", "Q" => "211331", "R" => "231131", "S" => "213113", "T" => "213311", "U" => "213131", "V" => "311123", "W" => "311321", "X" => "331121", "Y" => "312113", "Z" => "312311", "[" => "332111", "\\" => "314111", "]" => "221411", "^" => "431111", "_" => "111224", "NUL" => "111422", "SOH" => "121124", "STX" => "121421", "ETX" => "141122", "EOT" => "141221", "ENQ" => "112214", "ACK" => "112412", "BEL" => "122114", "BS" => "122411", "HT" => "142112", "LF" => "142211", "VT" => "241211", "FF" => "221114", "CR" => "413111", "SO" => "241112", "SI" => "134111", "DLE" => "111242", "DC1" => "121142", "DC2" => "121241", "DC3" => "114212", "DC4" => "124112", "NAK" => "124211", "SYN" => "411212", "ETB" => "421112", "CAN" => "421211", "EM" => "212141", "SUB" => "214121", "ESC" => "412121", "FS" => "111143", "GS" => "111341", "RS" => "131141", "US" => "114113", "FNC 3" => "114311", "FNC 2" => "411113", "SHIFT" => "411311", "CODE C" => "113141", "CODE B" => "114131", "FNC 4" => "311141", "FNC 1" => "411131", "Start A" => "211412", "Start B" => "211214", "Start C" => "211232", "Stop" => "2331112");
            $code_keys = array_keys($code_array);
            $code_values = array_flip($code_keys);
            for ($X = 1; $X <= strlen($text); $X++) {
                $activeKey = substr($text, ($X - 1), 1);
                $code_string .= $code_array[$activeKey];
                $chksum = ($chksum + ($code_values[$activeKey] * $X));
            }
            $code_string .= $code_array[$code_keys[($chksum - (intval($chksum / 103) * 103))]];

            $code_string = "211412" . $code_string . "2331112";
        } elseif (strtolower($code_type) == "code39") {
            $code_array = array("0" => "111221211", "1" => "211211112", "2" => "112211112", "3" => "212211111", "4" => "111221112", "5" => "211221111", "6" => "112221111", "7" => "111211212", "8" => "211211211", "9" => "112211211", "A" => "211112112", "B" => "112112112", "C" => "212112111", "D" => "111122112", "E" => "211122111", "F" => "112122111", "G" => "111112212", "H" => "211112211", "I" => "112112211", "J" => "111122211", "K" => "211111122", "L" => "112111122", "M" => "212111121", "N" => "111121122", "O" => "211121121", "P" => "112121121", "Q" => "111111222", "R" => "211111221", "S" => "112111221", "T" => "111121221", "U" => "221111112", "V" => "122111112", "W" => "222111111", "X" => "121121112", "Y" => "221121111", "Z" => "122121111", "-" => "121111212", "." => "221111211", " " => "122111211", "$" => "121212111", "/" => "121211121", "+" => "121112121", "%" => "111212121", "*" => "121121211");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                $code_string .= $code_array[substr($upper_text, ($X - 1), 1)] . "1";
            }

            $code_string = "1211212111" . $code_string . "121121211";
        } elseif (strtolower($code_type) == "code25") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
            $code_array2 = array("3-1-1-1-3", "1-3-1-1-3", "3-3-1-1-1", "1-1-3-1-3", "3-1-3-1-1", "1-3-3-1-1", "1-1-1-3-3", "3-1-1-3-1", "1-3-1-3-1", "1-1-3-3-1");

            for ($X = 1; $X <= strlen($text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($text, ($X - 1), 1) == $code_array1[$Y])
                        $temp[$X] = $code_array2[$Y];
                }
            }

            for ($X = 1; $X <= strlen($text); $X += 2) {
                if (isset($temp[$X]) && isset($temp[($X + 1)])) {
                    $temp1 = explode("-", $temp[$X]);
                    $temp2 = explode("-", $temp[($X + 1)]);
                    for ($Y = 0; $Y < count($temp1); $Y++)
                        $code_string .= $temp1[$Y] . $temp2[$Y];
                }
            }

            $code_string = "1111" . $code_string . "311";
        } elseif (strtolower($code_type) == "codabar") {
            $code_array1 = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "0", "-", "$", ":", "/", ".", "+", "A", "B", "C", "D");
            $code_array2 = array("1111221", "1112112", "2211111", "1121121", "2111121", "1211112", "1211211", "1221111", "2112111", "1111122", "1112211", "1122111", "2111212", "2121112", "2121211", "1121212", "1122121", "1212112", "1112122", "1112221");

            // Convert to uppercase
            $upper_text = strtoupper($text);

            for ($X = 1; $X <= strlen($upper_text); $X++) {
                for ($Y = 0; $Y < count($code_array1); $Y++) {
                    if (substr($upper_text, ($X - 1), 1) == $code_array1[$Y])
                        $code_string .= $code_array2[$Y] . "1";
                }
            }
            $code_string = "11221211" . $code_string . "1122121";
        }

        // Pad the edges of the barcode
        $code_length = 20;
        if ($print) {
            $text_height = 30;
        } else {
            $text_height = 0;
        }

        for ($i = 1; $i <= strlen($code_string); $i++) {
            $code_length = $code_length + (int)(substr($code_string, ($i - 1), 1));
        }

        if (strtolower($orientation) == "horizontal") {
            $img_width = $code_length * $SizeFactor;
            $img_height = $size;
        } else {
            $img_width = $size;
            $img_height = $code_length * $SizeFactor;
        }

        $image = imagecreate($img_width, $img_height + $text_height);
        $black = imagecolorallocate($image, 0, 0, 0);
        $white = imagecolorallocate($image, 255, 255, 255);

        imagefill($image, 0, 0, $white);
        if ($print) {
            imagestring($image, 5, 31, $img_height, $text, $black);
        }

        $location = 10;
        for ($position = 1; $position <= strlen($code_string); $position++) {
            $cur_size = $location + (substr($code_string, ($position - 1), 1));
            if (strtolower($orientation) == "horizontal")
                imagefilledrectangle($image, $location * $SizeFactor, 0, $cur_size * $SizeFactor, $img_height, ($position % 2 == 0 ? $white : $black));
            else
                imagefilledrectangle($image, 0, $location * $SizeFactor, $img_width, $cur_size * $SizeFactor, ($position % 2 == 0 ? $white : $black));
            $location = $cur_size;
        }

        // Draw barcode to the screen or save in a file
        if ($filepath == "") {
            header('Content-type: image/png');
            imagepng($image);
            imagedestroy($image);
        } else {
            imagepng($image, $filepath);
            imagedestroy($image);
        }
    }

    public function generate_referal_code($length_string = 6): string
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890abcdefghijklmnopqrstuvwxyz';
        return substr(str_shuffle($str_result), 0, $length_string);
    }

    //--------------------------------------------------------------------

}
