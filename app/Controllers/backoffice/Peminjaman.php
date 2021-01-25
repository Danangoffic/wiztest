<?php

namespace App\Controllers\backoffice;

use App\Models\GudangModel;
use App\Models\KategoriBarangModel;
use App\Models\PeminjamanModel;
use App\Models\TrafikDataGudangModel;
use App\Controllers\BaseController;

class Peminjaman extends BaseController
{
    protected $session;
    public $peminjamanModel;
    protected $trafikGudangModel;
    protected $barangGudangModel;
    protected $kategoriBarangModel;
    protected $page;
    function __construct()
    {
        $this->session = session();
        $this->peminjamanModel = new PeminjamanModel();
        $this->trafikGudangModel = new TrafikDataGudangModel();
        $this->barangGudangModel = new GudangModel();
        $this->kategoriBarangModel = new KategoriBarangModel();
        $this->page = "peminjaman";
    }

    public function index()
    {
        if (!$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
        $data = [
            'data_peminjaman' => $this->peminjamanModel->findAll(),
            'trafik_data' => $this->trafikGudangModel,
            'title' => "Data Peminjaman Gudang",
            'page' => "peminjaman"
        ];
        return view('backoffice/' . $this->page . '/index_' . $this->page, $data);
    }

    public function create_keluar_barang()
    {
        if (!$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
        $db_status_keluar = db_connect()->table('status_hasil')->select()->where('jenis_status', 'status_peminjaman')->where('nama_status', 'keluar')->limit(1)->get()->getFirstRow();
        $id_status = base64_encode($db_status_keluar->id);
        $data = [
            'old_barang' => old('id_barang'),
            'barang_gudang' => $this->barangGudangModel,
            'kategori_gudang' => $this->kategoriBarangModel,
            'title' => "Data Masuk Peminjaman Gudang",
            'page' => "peminjaman",
            'id_status' => $id_status
        ];
        return view('backoffice/' . $this->page . '/index_' . $this->page, $data);
    }

    public function save_keluar_barang()
    {
        if (!$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
        $id_status = base64_decode($this->request->getPost('id_status'));
        $db_check_status = db_connect()->table('status_hasil')->select()->where(['jenis_status' => 'status_peminjaman', 'nama_status' => 'keluar'])->limit(1)->get()->getFirstRow();
        $check_id = $db_check_status->id;
        if ($id_status != $check_id) {
            $this->session->setFlashdata('error', 'Maaf tidak bisa melakukan penyimpanan');
            return redirect()->to('/backoffice/peminjaman/create_keluar_barang');
        }
        $ids_barang = $this->request->getPost('id_barang');
    }

    public function create_masuk_barang()
    {
        if (!$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
        $data = [
            'barang_gudang' => $this->barangGudangModel,
            'kategori_gudang' => $this->kategoriBarangModel,
            'title' => "Data Keluar Peminjaman Gudang",
            'page' => "peminjaman"
        ];
        return view('backoffice/' . $this->page . '/index_' . $this->page, $data);
    }
}
