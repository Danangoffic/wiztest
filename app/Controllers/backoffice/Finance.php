<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\InstansiModel;
use App\Models\MarketingModel;
use App\Models\PembayaranModel;
use App\Controllers\BaseController;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\TestModel;
use Dompdf\Dompdf;
use TCPDF;

// use App\Controllers;
// use CodeIgniter\Controller;

class Finance extends BaseController
{
    protected $session;
    protected $CustomerModel;
    protected $instansi_model;
    protected $marketing_model;
    protected $pembayaran_model;
    protected $C_Layanan;
    protected $date1;
    protected $date2;
    protected $marketing;
    protected $instansi;
    public function __construct()
    {
        $this->CustomerModel = new CustomerModel();
        $this->instansi_model = new InstansiModel();
        $this->marketing_model = new MarketingModel();
        $this->pembayaran_model = new PembayaranModel();
        $this->C_Layanan = new Layanan;
        $this->session = \Config\Services::session();
    }

    public function invoice()
    {
        if (!$this->session->get('logged_in') || !$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
        $filter_submit = ($this->request->getPost('filter_submit')) ? $this->request->getPost('filter_submit') : '';

        if ($filter_submit !== '') {
            $filtering = ($this->request->getPost('filtering')) ? $this->request->getPost('filtering') : '';
            if ($filtering == "on") {
                $data_customer = $this->invoice_filter();
            }
        } else {
            $data_customer = $this->CustomerModel->orderBy('tgl_kunjungan', 'DESC')->get()->getResultArray();
        }

        // dd(db_connect()->showLastQuery());

        $data = array(
            'data_customer' => $data_customer,
            'instansi_model' => $this->instansi_model,
            'marketing_model' => $this->marketing_model,
            'pembayaran_model' => $this->pembayaran_model,
            'c_layanan' => $this->C_Layanan,
            'session' => $this->session,
            'page' => 'invoice',
            'title' => "Laporan Data Invoice",
            'date1' => ($this->date1 == '') ? '' : $this->date1,
            'date2' => ($this->date2 == '') ? '' : $this->date2,
        );
        // dd($data);
        return $this->returning_invoice($filter_submit, $data);
    }

    public function invoice_aps()
    {
        if (!$this->session->get('logged_in') || !$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
        $filter_submit = ($this->request->getPost('filter_submit')) ? $this->request->getPost('filter_submit') : '';
        if ($filter_submit !== '') {
            $filtering = ($this->request->getPost('filtering')) ? $this->request->getPost('filtering') : '';
            if ($filtering == "on") {
                $data_customer = $this->invoice_filter();
            }
        } else {
            $data_customer = $this->CustomerModel->where(['instansi' => '1'])->orderBy('tgl_kunjungan', 'DESC')->get()->getResultArray();
        }

        $data = array(
            'data_customer' => $data_customer,
            'instansi_model' => $this->instansi_model,
            'marketing_model' => $this->marketing_model,
            'pembayaran_model' => $this->pembayaran_model,
            'c_layanan' => $this->C_Layanan,
            'session' => $this->session,
            'page' => 'invoice_aps',
            'title' => "Laporan Data Invoice APS",
            'date1' => ($this->date1 == '') ? '' : $this->date1,
            'date2' => ($this->date2 == '') ? '' : $this->date2,
            // 'marketing' => $this->marketing,
            // 'instansi' => $this->instansi
        );

        return $this->returning_invoice($filter_submit, $data);
    }

    public function instansi()
    {
        $DataInstansi = $this->instansi_model->findAll();
        $data = array(
            'title' => "Data Instansi",
            'page' => "finance_instansi",
            'session' => $this->session,
            'data' => $DataInstansi
        );
        return view("backoffice/finance/instansi", $data);
    }

    public function detail_finance_instansi(int $id_instansi = null)
    {
        if ($id_instansi == null) {
            $this->session->setFlashdata('error', 'Instansi tidak ditemukan');
            return redirect()->to("/backoffice/finance/instansi");
        }
        $detail_instansi = $this->instansi_model->detail_instansi($id_instansi);
        if ($detail_instansi == null) {
            $this->session->setFlashdata('error', 'Instansi tidak ditemukan');
            return redirect()->to("/backoffice/finance/instansi");
        }
        helper('form');
        $customerModel = new CustomerModel();
        $layanan_test_model = new LayananTestModel();
        $layanan_model = new LayananModel();
        $test_model = new TestModel();
        $filtering = ($this->request->getPost('filtering')) ? $this->request->getPost('filtering') : "";
        $filter_instansi = [
            'instansi' => $id_instansi,
            // 'tgl_kunjungan' => date("Y-m-d")
        ];
        if ($filtering == "on") {
            $date1 = ($this->request->getPost("date1")) ? $this->request->getPost("date1") : "";
            $date2 = ($this->request->getPost("date2")) ? $this->request->getPost("date2") : "";
            $jenis_test  = ($this->request->getPost("jenis_test")) ? $this->request->getPost("jenis_test") : "";

            if ($jenis_test != "") {
                $filter_instansi['jenis_test'] = $jenis_test;
            }
            if ($date1 != "" && $date2 != "") {
                $filter_instansi['tgl_kunjungan'] = "a.tgl_kunjungan between {$date1} AND {$date2}";
            } elseif ($date1 == "" && $date2 != "") {
                $filter_instansi['tgl_kunjungan'] = $date2;
            } elseif ($date1 != "" && $date2 != "") {
                $date_now = date("Y-m-d");
                $filter_instansi['tgl_kunjungan'] = "a.tgl_kunjungan between {$date1} AND {$date_now}";
            }
        }
        $customers = $customerModel->deep_detail_by_id(null, $filter_instansi)->getResultArray();
        $filter_instansi['kehadiran'] = 23;
        $kehadiran_customers = $customerModel->deep_detail_by_id(null, $filter_instansi)->getResultArray();
        $filter_instansi['kehadiran'] = 22;
        $ketidak_hadiran_customers = $customerModel->deep_detail_by_id(null, $filter_instansi)->getResultArray();

        $total_kehadiran = count($kehadiran_customers);
        $total_customer = count($customers);
        $total_tidak_hadir = count($ketidak_hadiran_customers);
        $nama_instansi = $detail_instansi['nama'];
        $alamat = $detail_instansi['alamat'];
        $id_marketing = $detail_instansi['pic_marketing'];
        if ($id_marketing != null) {
            $detail_marketing = $this->marketing_model->find($id_marketing);
            $pic_marketing = $detail_marketing['nama_marketing'];
        } else {
            $pic_marketing = "";
        }
        $filter_test_instansi = ['id_pemeriksaan' => 1];
        if ($id_instansi == 1) {
            $filter_test_instansi['id_segmen'] = 1;
        } else {
            $filter_test_instansi['id_segmen'] = 2;
        }

        $layanan_test = $layanan_test_model->by_keys($filter_test_instansi)->get()->getResultArray();
        $pemeriksaan = array();
        foreach ($layanan_test as $key => $LT) {
            $detail_layanan = $layanan_model->find($LT['id_layanan']);
            $detail_test = $test_model->find($LT['id_test']);

            $nama_layanan = $detail_layanan['nama_layanan'];
            $nama_test = $detail_test['nama_test'];

            $pemeriksaan[] = array(
                'id' => $LT['id'],
                'text' => $nama_test . " " . $nama_layanan
            );
        }
        $data = array(
            'title' => "Data Detail Instansi",
            'page' => "finance_instansi",
            'session' => session(),
            'customers_instansi' => $customers,
            'jumlah_customer' => $total_customer,
            'total_kehadiran' => $total_kehadiran,
            'total_invoice_terbit' => null,
            'PIC' => $pic_marketing,
            'pemeriksaan' => $pemeriksaan,
            'nama_instansi' => $nama_instansi,
            'total_tidak_hadir' => $total_tidak_hadir,
            'alamat' => $alamat,
            'id_instansi' => $id_instansi

        );
        return view("backoffice/finance/detail_instansi", $data);
    }

    public function print_instansi_invoice()
    {
        $id_instansi = $this->request->getPost("id_instansi");
        if ($id_instansi == null) {
            $this->session->setFlashdata('error', 'Instansi tidak ditemukan');
            return redirect()->to("/backoffice/finance/instansi");
        }
        $detail_instansi = $this->instansi_model->detail_instansi($id_instansi);
        if ($detail_instansi == null) {
            $this->session->setFlashdata('error', 'Instansi tidak ditemukan');
            return redirect()->to("/backoffice/finance/instansi");
        }

        $id_peserta_to_print = $this->request->getPost("print_invoice");
        // dd($id_peserta_to_print);
        if ($id_peserta_to_print == null) {
            return $this->print_all_invoice_instansi($id_instansi);
        } else {
            return $this->print_invoice_peserta_instansi($detail_instansi, $id_peserta_to_print);
        }
    }

    protected function print_all_invoice_instansi($id_instansi = null)
    {
        # code...
    }

    protected function print_invoice_peserta_instansi($detail_instansi = null, $id_peserta_to_print = null)
    {
        // $total_id = count($id_peserta_to_print);
        $test_customers = $this->CustomerModel->select('customers.jenis_test, count(customers.jenis_test) as total_jenis, c.nama_test, d.nama_layanan, b.biaya')
            ->join("data_layanan_test b", 'b.id = customers.jenis_test')
            ->join("jenis_test c", "c.id = b.id_test")
            ->join("jenis_layanan d", "d.id = b.id_layanan")
            ->whereIn('customers.id', $id_peserta_to_print)->orderBy('jenis_test', 'ASC')->groupBy('jenis_test')->get()->getResultArray();
        // dd(db_connect()->showLastQuery());
        $detail_customers = $this->CustomerModel->whereIn('id', $id_peserta_to_print)->orderBy("id", "DESC")->get();
        $first_customers = $detail_customers->getRowArray();
        $inv_first_cust = $first_customers['invoice_number'];
        $random = date("is");
        $title = "Invoice_{$inv_first_cust}_{$random}";
        $data = [
            'title' => $title,
            'page' => "finance",
            'total_peserta' => $test_customers,
            'detail_peserta' => $detail_customers->getResultArray(),
            'detail_instansi' => $detail_instansi
        ];
        $PDF = new Dompdf();
        $PDF->loadHtml(view('backoffice/finance/print_invoice_customer', $data));
        // $PDF->paperOrientation = 'landscape';
        $this->response->setContentType('application/pdf');
        $PDF->render();
        $PDF->stream("{$title}.pdf", ['attachment' => 1]);
        //Close and output PDF document
        $PDF->Output($title . '.pdf', 'I');
    }

    protected function invoice_filter()
    {
        $this->date1 = ($this->request->getPost('date1')) ? $this->request->getPost('date1') : '';
        $this->date2 = ($this->request->getPost('date2')) ? $this->request->getPost('date2') : '';
        $this->instansi = ($this->request->getPost('instansi')) ? $this->request->getPost('instansi') : '';
        $this->marketing = ($this->request->getPost('marketing')) ? $this->request->getPost('marketing') : '';
        $query = "SELECT * FROM customers WHERE 1=1 ";
        if ($this->date1 !== '' && $this->date2 !== '') {
            $query .= " AND (created_at BETWEEN '{$this->date1}' AND '{$this->date2}') ";
        } else if ($this->date1 !== '' && $this->date2 == '') {
            $query .= " AND created_at  = '{$this->date1}' ";
        } else if ($this->date1 == '' && $this->date2 !== '') {
            $query .= " AND created_at = '{$this->date2}' ";
        }
        if ($this->instansi !== '') {
            $query .= " AND instansi = '{$this->instansi}' ";
        }
        if ($this->marketing !== '') {
            $query .= " AND id_marketing = '{$this->marketing}' ";
        }
        if ($this->date1 == '' && $this->date2 == '' && $this->marketing == '' && $this->instansi == '') {
            return $this->CustomerModel->orderBy('tgl_kunjungan', 'DESC')->get()->getResultArray();
        } else {
            return db_connect()->query($query . " ORDER BY id DESC")->getResultArray();
        }
    }

    public function print_invoice(string $type_invoice = "ttd", string $invoice_number)
    {
        // if (!$this->session->get('logged_in') || !$this->session->get('id_user')) {
        //     return redirect()->to('/backoffice/login');
        // }
        $attachment = ($this->request->getGet("attachment")) ? $this->request->getGet("attachment") : 1;
        switch ($type_invoice) {
            case 'ttd':
                return $this->pdf_customer_ttd($invoice_number, $attachment);
                break;
            case 'no-ttd':
                return $this->pdf_customer($invoice_number, $attachment);
                break;
            default:
                # code...
                break;
        }
    }

    // public function FunctionName(Type $var = null)
    // {
    //     # code...
    // }

    protected function print_pdf($data)
    {
        // $dompdf = new \Dompdf\Dompdf();
        // $dompdf->loadHtml(view('backoffice/finance/invoice_print_pdf', $data));
        // $dompdf->setPaper('A4', 'landscape');
        // $dompdf->render();
        // // $dompdf->set
        // // $dompdf->
        // $dompdf->stream($data['title'] . ".pdf", ['Attachment' => 0]);

        $PDF = new Dompdf();
        // $PDF->paperOrientation = 'landscape';
        $PDF->loadHtml(view('backoffice/finance/invoice_print_pdf', $data));

        $this->response->setContentType('application/pdf');
        $PDF->render();
        $PDF->stream($data['title'] . ".pdf", ['attachment' => 0]);
        //Close and output PDF document
        // $PDF->Output('Invoicement.pdf', 'I');
    }

    public function pdf_customer($invoice_number = null, $attachment = 1)
    {
        if ($invoice_number == null) {
            echo "Invoice number kosong";
            return false;
        }
        $customer = $this->CustomerModel->get_customer_by_invoice($invoice_number);
        if ($customer == null) {
            echo "Customer tidak ditemukan";
            return false;
        }
        $id_customer = $customer['id'];
        $data_pembayaran = $this->pembayaran_model->where(['id_customer' => $id_customer])->get()->getRowArray();
        $data_layanan_test = db_connect()->table('data_layanan_test')->where('id', $customer['jenis_test'])->limit(1)->get()->getRowArray();
        $data_layanan = db_connect()->table('jenis_layanan')->where('id', $data_layanan_test['id_layanan'])->get()->getRowArray();
        $data_test = db_connect()->table('jenis_test')->where('id', $data_layanan_test['id_test'])->get()->getRowArray();
        $nama_test = $data_test['nama_test'];
        $nama_layanan = $data_layanan['nama_layanan'];

        $nama_paket = $nama_test . " ({$nama_layanan})";
        $nama = $customer['nama'];
        $title = "Invoice {$nama} - {$invoice_number}";
        $data = [
            'title' => $title,
            'page' => "invoice_customer",
            'customer' => $customer,
            'data_pembayaran' => $data_pembayaran,
            'nama_paket' => $nama_paket
        ];

        $PDF = new Dompdf();
        $PDF->loadHtml(view('backoffice/finance/print_invoice_customer', $data));
        // $PDF->paperOrientation = 'landscape';
        $this->response->setContentType('application/pdf');
        $PDF->render();
        $PDF->stream("{$title}.pdf", ['attachment' => 1]);
        //Close and output PDF document
        $PDF->Output($title . '.pdf', 'I');
    }

    public function pdf_customer_ttd($invoice_number = null, $attachment = 1)
    {
        if ($invoice_number == null) {
            return null;
        }
        $customer = $this->CustomerModel->get_customer_by_invoice($invoice_number);
        if ($customer == null) {
            echo "Customer tidak ditemukan";
        }
        $id_customer = $customer['id'];
        $data_pembayaran = $this->pembayaran_model->where(['id_customer' => $id_customer])->get()->getRowArray();
        $data_layanan_test = db_connect()->table('data_layanan_test')->where('id', $customer['jenis_test'])->limit(1)->get()->getRowArray();
        $data_layanan = db_connect()->table('jenis_layanan')->where('id', $data_layanan_test['id_layanan'])->get()->getRowArray();
        $data_test = db_connect()->table('jenis_test')->where('id', $data_layanan_test['id_test'])->get()->getRowArray();
        $nama_test = $data_test['nama_test'];
        $nama_layanan = $data_layanan['nama_layanan'];

        $nama_paket = $nama_test . " ({$nama_layanan})";
        $title = "Invoice " . $customer['nama'] . " - " . $invoice_number;
        $data = [
            'title' => $title,
            'page' => "invoice_customer",
            'customer' => $customer,
            'data_pembayaran' => $data_pembayaran,
            'nama_paket' => $nama_paket
        ];
        // $dompdf = new \Dompdf\Dompdf();
        // $dompdf->loadHtml(view('backoffice/finance/print_invoice_customer_ttd', $data));
        // $dompdf->setPaper('A4', 'landscape');
        // $dompdf->render();
        // // $dompdf->set
        // // $dompdf->
        // $dompdf->stream($data['title'] . ".pdf", ['Attachment' => $attachment]);

        $PDF = new Dompdf();
        // $PDF->paperOrientation = 'landscape';

        $PDF->loadHtml(view('backoffice/finance/print_invoice_customer_ttd', $data));
        $PDF->paperOrientation = 'landscape';
        $this->response->setContentType('application/pdf');
        $PDF->render();
        $PDF->stream($title . ".pdf", ['attachment' => 0]);
        //Close and output PDF document
        // $PDF->Output($title . '.pdf', 'I');
    }

    /**
     * @todo return the view into printing pdf, excel or data view
     * @author Danang Arif R
     * @copyright 2021
     */

    protected function returning_invoice(string $to_switch, array $data)
    {
        if (count($data['data_customer']) == 0) {
            $this->session->setFlashdata('error', 'Data Customer tidak ada pada filter tersebut');
            return redirect()->back();
        }
        switch ($to_switch) {
            case 'Filter':
                # code...
                return view("backoffice/finance/invoice_aps", $data);
                break;
            case 'Print PDF':
                return $this->print_pdf($data);
                break;
            case 'Print Excel':
                break;
            case '':
                return view("backoffice/finance/invoice_aps", $data);
                break;
            default:
                # code...
                return view("backoffice/finance/invoice_aps", $data);
                break;
        }
    }

    public function print_excel()
    {
        # code...
    }

    public function delete($id_customer)
    {
        if (!$this->session->get('logged_in') || !$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
    }

    public function edit($id_customer)
    {
        if (!$this->session->get('logged_in') || !$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
    }
}
