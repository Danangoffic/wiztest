<?php

namespace App\Controllers\backoffice;

use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\TestModel;
use App\Controllers\BaseController;
use Dompdf\Cpdf;
use App\Controllers\backoffice\Peserta;
// use App\Controllers;
// use CodeIgniter\Controller;

class Peserta_overkuota extends BaseController
{
    public $session;
    protected $pesertaC;
    public function __construct()
    {
        $this->session = session();
        $this->pesertaC = new Peserta;
    }
    public function index()
    {
        $dataPemeriksa = $this->pesertaC->pemeriksaModel->findAll();
        $dataJenisPemeriksaan = $this->pesertaC->jenisPemeriksaanModel->findAll();
        $dataFaskes = $this->pesertaC->faskesModel->findAll();
        $dataInstanasi = $this->pesertaC->instansiModel->findAll();
        $dataMarketing = $this->pesertaC->marketingModel->findAll();
        $dataLayananTest = $this->pesertaC->layananTestModel->findAll();
        $data = array(
            'title' => "Tambah Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
            'pemeriksa' => $dataPemeriksa,
            'jenis_pemeriksaan' => $dataJenisPemeriksaan,
            'faskes' => $dataFaskes,
            'instansi' => $dataInstanasi,
            'marketing' => $dataMarketing,
            'data_layanan_test' => $dataLayananTest,
            'testModel' => $this->pesertaC->testModel,
            'layananModel' => $this->pesertaC->layananModel

        );
        return view('backoffice/peserta_overkuota/create_customer_overkuota', $data);
    }

    public function save_customer_overkuota()
    {
        # code...
    }

    public function detail_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Detail Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/peserta_overkuota/detail_customer_overkuota', $data);
    }

    public function edit_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Ubah Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/peserta_overkuota/edit_customer_overkuota', $data);
    }

    public function update_customer_overkuota($id_customer_overkuota)
    {
        # code...
    }

    public function delete_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Hapus Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/peserta_overkuota/delete_customer_overkuota', $data);
    }

    public function doDelete_custoemr_overkuota()
    {
        # code...
    }
}
