<?php

namespace App\Controllers\backoffice;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\HasilLaboratoriumModel;
use App\Models\InstansiModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PemeriksaModel;
use App\Models\SampleModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\Validation\Validation;

// use App\Controllers;
// use CodeIgniter\Controller;

class Reporting extends BaseController
{
    protected $hasil_lab_model;
    protected $customer_model;
    protected $status_model;
    protected $layanan_test_model;
    protected $layanan_model;
    protected $test_model;
    protected $sample_model;
    protected $petugas_model;
    protected $instansi_model;
    protected $marketing_model;
    protected $session;
    public function __construct()
    {
        $this->hasil_lab_model = new HasilLaboratoriumModel();
        $this->customer_model = new CustomerModel();
        $this->status_model = new StatusHasilModel();
        $this->layanan_test_model = new LayananTestModel();
        $this->layanan_model = new LayananModel();
        $this->test_model = new TestModel();
        $this->sample_model = new SampleModel();
        $this->petugas_model = new PemeriksaModel();
        $this->instansi_model = new InstansiModel();
        $this->marketing_model = new MarketingModel();
        $this->session = \Config\Services::session();
    }

    public function hasil()
    {
        $is_filter_on = ($this->request->getPost("filtering")) ? $this->request->getPost("filtering") : "";
        if ($is_filter_on == "on") {
            $tipe_filter = $this->request->getPost("tipe_filter");
            switch ($tipe_filter) {
                case 'Filter':
                    $tgl_registrasi1 = ($this->request->getPost("date1")) ? $this->request->getPost("date1") : "";
                    $tgl_registrasi2 = ($this->request->getPost("date2")) ? $this->request->getPost("date2") : "";

                    $instansi = ($this->request->getPost("instansi")) ? $this->request->getPost("instansi") : "";
                    $marketing = ($this->request->getPost("marketing")) ? $this->request->getPost("marketing") : "";
                    $res_db = db_connect()->table('hasil_laboratorium a')->select("a.*")->where("a.valid", "yes");
                    $res_db->join('customers b', 'b.id = a.id_customer');
                    if ($tgl_registrasi1 != "" && $tgl_registrasi2 != "") {
                        $res_db->where("b.created_at BETWEEN {$tgl_registrasi1} AND {$tgl_registrasi2}");
                    } elseif ($tgl_registrasi1 != "" && $tgl_registrasi2 == "") {
                        $res_db->where("b.created_at", $tgl_registrasi1);
                    } elseif ($tgl_registrasi1 == "" && $tgl_registrasi2 != "") {
                        $res_db->where("b.created_at", $tgl_registrasi2);
                    }
                    if ($instansi != "") {
                        $res_db->where("b.instansi", $instansi);
                    }
                    if ($marketing != "") {
                        $res_db->where("b.id_marketing", $marketing);
                    }
                    $data_hasil = $res_db->get()->getResultArray();
                    break;
                case 'Cetak PDF':

                    break;
                case 'Cetak Excel':

                    break;
                default:
                    # code...
                    break;
            }
        } else {
            $data_hasil = $this->hasil_lab_model->where(['valid' => "yes"])->get()->getResultArray();
        }

        $data = [
            'title' => "Laporan Hasil Pemeriksaan",
            'page' => "reporting_hasil",
            'data_hasil' => $data_hasil,
            'customer_model' => $this->customer_model,
            'status_model' => $this->status_model,
            'layanan_test_model' => $this->layanan_test_model,
            'layanan_model' => $this->layanan_model,
            'test_model' => $this->test_model,
            'sample_model' => $this->sample_model,
            'petugas_model' => $this->petugas_model,
            'instansi_model' => $this->instansi_model,
            'marketing_model' => $this->marketing_model,
            'session' => $this->session
        ];
        return view("backoffice/reporting/hasil", $data);
    }

    public function marketing()
    {
        $data_customer = db_connect()->table('customers')->orderBy('id', 'DESC')->get()->getResultArray();
        $data = [
            'title' => "Laporan Data Marketing",
            'page' => "reporting_marketing",
            'data_customer' => $data_customer,
            'layanan_test_model' => $this->layanan_test_model,
            'layanan_model' => $this->layanan_model,
            'test_model' => $this->test_model,
            'instansi_model' => $this->instansi_model,
            'marketing_model' => $this->marketing_model,
            'session' => $this->session
        ];
        return view("backoffice/reporting/marketing", $data);
    }
}
