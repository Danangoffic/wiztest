<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\InstansiModel;
use App\Models\MarketingModel;
use App\Models\PembayaranModel;
use App\Controllers\BaseController;
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
            'session' => session(),
            'data' => $DataInstansi
        );
        return view("backoffice/finance/instansi", $data);
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
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('backoffice/finance/invoice_print_pdf', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        // $dompdf->set
        // $dompdf->
        $dompdf->stream($data['title'] . ".pdf", ['Attachment' => 0]);
    }

    public function pdf_customer($invoice_number, $attachment = 1)
    {
        $customer = $this->CustomerModel->where(['invoice_number' => $invoice_number])->get()->getRowArray();
        $id_customer = $customer['id'];
        $data_pembayaran = $this->pembayaran_model->where(['id_customer' => $id_customer])->get()->getRowArray();
        $data_layanan_test = db_connect()->table('data_layanan_test')->where('id', $customer['jenis_test'])->limit(1)->get()->getRowArray();
        $data_layanan = db_connect()->table('jenis_layanan')->where('id', $data_layanan_test['id_layanan'])->get()->getRowArray();
        $data_test = db_connect()->table('jenis_test')->where('id', $data_layanan_test['id_test'])->get()->getRowArray();
        $nama_test = $data_test['nama_test'];
        $nama_layanan = $data_layanan['nama_layanan'];

        $nama_paket = $nama_test . " ({$nama_layanan})";
        $data = [
            'title' => "Invoice " . $customer['nama'] . " - " . $invoice_number,
            'page' => "invoice_customer",
            'customer' => $customer,
            'data_pembayaran' => $data_pembayaran,
            'nama_paket' => $nama_paket
        ];
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('backoffice/finance/print_invoice_customer', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        // $dompdf->set
        // $dompdf->
        $dompdf->stream($data['title'] . ".pdf", ['Attachment' => $attachment]);
    }

    public function pdf_customer_ttd($invoice_number = null, $attachment = 1)
    {
        if ($invoice_number == null) {
            return null;
        }
        $customer = $this->CustomerModel->where(['invoice_number' => $invoice_number])->get()->getRowArray();
        if ($customer == null) {
            return null;
        }
        $id_customer = $customer['id'];
        $data_pembayaran = $this->pembayaran_model->where(['id_customer' => $id_customer])->get()->getRowArray();
        $data_layanan_test = db_connect()->table('data_layanan_test')->where('id', $customer['jenis_test'])->limit(1)->get()->getRowArray();
        $data_layanan = db_connect()->table('jenis_layanan')->where('id', $data_layanan_test['id_layanan'])->get()->getRowArray();
        $data_test = db_connect()->table('jenis_test')->where('id', $data_layanan_test['id_test'])->get()->getRowArray();
        $nama_test = $data_test['nama_test'];
        $nama_layanan = $data_layanan['nama_layanan'];

        $nama_paket = $nama_test . " ({$nama_layanan})";
        $data = [
            'title' => "Invoice " . $customer['nama'] . " - " . $invoice_number,
            'page' => "invoice_customer",
            'customer' => $customer,
            'data_pembayaran' => $data_pembayaran,
            'nama_paket' => $nama_paket
        ];
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('backoffice/finance/print_invoice_customer_ttd', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        // $dompdf->set
        // $dompdf->
        $dompdf->stream($data['title'] . ".pdf", ['Attachment' => $attachment]);
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
