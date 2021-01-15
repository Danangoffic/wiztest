<?php

namespace App\Controllers\backoffice;

use App\Models\GudangModel;
use App\Models\KategoriBarangModel;
use App\Models\StatusHasilModel;
use CodeIgniter\Controller;
use CodeIgniter\Validation\Validation;

// use App\Controllers;
// use CodeIgniter\Controller;

class Gudang extends Controller
{
    public $session;
    protected $gudangModel;
    protected $statusModel;
    protected $kategoriBarangModel;

    public function __construct()
    {
        $this->gudangModel = new GudangModel();
        $this->statusModel = new StatusHasilModel();
        $this->kategoriBarangModel = new KategoriBarangModel();
        // $this->gudangModel = new gudangModel();
        $this->session = session();
    }

    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Data Barang Gudang',
            'page' => 'gudang',
            'data' => $this->gudangModel->findAll(),
            'statusModel' => $this->statusModel,
            'kategori' => $this->kategoriBarangModel,
            // 'gudang' => $this->gudangModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/gudang/index_gudang', $data);
    }

    public function create()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Tambah Data Gudang',
            'page' => 'gudang',
            'statusModel' => $this->statusModel,
            'kategori' => $this->kategoriBarangModel,
            // 'gudang' => $this->gudangModel,
            'validation' => \Config\Services::validation(),
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/gudang/create_gudang', $data);
    }

    public function detail(int $id_gudang)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'gudang',
            'page' => 'gudang',
            'data' => $this->gudangModel->find($id_gudang),
            'statusModel' => $this->statusModel,
            // 'gudang' => $this->gudangModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'id' => $id_gudang
        );
        // dd($this->session->get('nama'));
        return view('backoffice/gudang/detail_gudang', $data);
    }

    public function save()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $fileBarang = $this->request->getFile('gambar_barang');
        if ($fileBarang->getError() == 4) {
            $namaFileBarang = "";
        } else {
            //generate name with random name
            $namaFileBarang = $fileBarang->getRandomName();
            //move file ke folder img with new name
            $fileBarang->move('assets/gudang', $namaFileBarang);
        }

        $nama_barang = $this->request->getPost('nama_barang');
        $kode_barang = uniqid("QT-", false);
        $stock = $this->request->getPost('stock');
        $id_status = $this->request->getPost('status');
        $kategori_gudang = $this->request->getPost('kategori_gudang');

        $array_data = array(
            'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'image_barang' => $namaFileBarang,
            'stock' => $stock,
            'status_barang' => $id_status,
            'kategori_gudang' => $kategori_gudang,
            'created_by' => session()->get('id_user'),
            'updated_by' => session()->get('id_user')
        );
        $inserting = $this->gudangModel->insert($array_data);
        if ($inserting) {
            $this->session->setFlashdata('success', 'Berhasil tambahkan data gudang');
            return redirect()->to('/backoffice/gudang');
        } else {
            $this->session->setFlashdata('error', 'Gagal tambahkan data gudang');
            return redirect()->to('/backoffice/gudang/create')->withInput();
        }
    }

    public function edit(int $id_gudang)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Ubah Data Barang Gudang',
            'page' => 'gudang',
            'data' => $this->gudangModel->find($id_gudang),
            'kategori' => $this->kategoriBarangModel,
            // 'gudang' => $this->gudangModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'id' => $id_gudang
        );
        // dd($this->session->get('nama'));
        return view('backoffice/gudang/edit_gudang', $data);
    }

    public function update(int $id_row)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $fileBarang = $this->request->getFile('gambar_barang');
        $old_image_barang = $this->request->getPost('old_image_barang');
        if ($fileBarang->getError() == 4) {
            $namaFileBarang = $old_image_barang;
        } else {
            //generate name with random name
            $namaFileBarang = $fileBarang->getRandomName();
            //move file ke folder img with new name
            $fileBarang->move('img', $namaFileBarang);
            if ($old_image_barang !== "") {
                unlink($old_image_barang, 'assets/gudang/');
            }
        }

        $nama_barang = $this->request->getPost('nama_barang');
        $kategori_gudang = $this->request->getPost('kategori_gudang');
        // dd($this->request->getPost());
        // $kode_barang = uniqid("QT-", false);
        $stock = $this->request->getPost('stock');
        $id_status = ($stock > 0) ? 15 : 14;

        $array_data = array(
            // 'kode_barang' => $kode_barang,
            'nama_barang' => $nama_barang,
            'image_barang' => $namaFileBarang,
            'stock' => $stock,
            'status_barang' => $id_status,
            'kategori_gudang' => $kategori_gudang,
            'created_by' => session()->get('id_user'),
            'updated_by' => session()->get('id_user')
        );
        $inserting = $this->gudangModel->update($id_row, $array_data);
        if ($inserting) {
            $this->session->setFlashdata('success', 'Berhasil ubah data gudang');
            return redirect()->to('/backoffice/gudang/edit/' . $id_row);
        } else {
            $this->session->setFlashdata('error', 'Gagal ubah data gudang');
            return redirect()->to('/backoffice/gudang/edit/' . $id_row)->withInput();
        }
    }

    public function delete(int $id_gudang)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Hapus Barang Gudang',
            'page' => 'gudang',
            'data' => $this->gudangModel->find($id_gudang),
            // 'gudang' => $this->gudangModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'id' => $id_gudang
        );
        // dd($this->session->get('nama'));
        return view('backoffice/gudang/delete_gudang', $data);
    }

    public function generate_barcode_barang(int $id_gudang)
    {
        $Layanan = new Layanan;
        $src_image_barcode = $Layanan->generate_image_barcode_string("gudang." . $id_gudang);
    }

    public function scan_by_barcode(string $value = "")
    {
        if ($value !== "") {
            $newValue = explode(".", $value);
            $id_gudang = $newValue[1];
            $detail_barang = $this->gudangModel->find($id_gudang);
            if (count($detail_barang) > 0) {
            }
        } else {
            echo "barang tidak ditemukan";
        }
    }

    public function do_delete(int $id_faskes)
    {
        # code...
    }
}
