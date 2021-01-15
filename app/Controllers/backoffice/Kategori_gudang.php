<?php

namespace App\Controllers\backoffice;

use App\Models\KategoriBarangModel;
use CodeIgniter\Controller;
// use App\Controllers;
// use CodeIgniter\Controller;

class Kategori_gudang extends Controller
{
    protected $session;
    protected $kategoriBarangModel;
    public function __construct()
    {
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
            'title' => 'Data Kategori Gudang',
            'page' => 'kategori_gudang',
            'data' => $this->kategoriBarangModel->findAll(),
            // 'gudang' => $this->gudangModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/kategori_gudang/index_kategori', $data);
    }

    public function create()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Tambah Kategori',
            'page' => 'kategori_gudang',
            // 'gudang' => $this->gudangModel,
            'validation' => \Config\Services::validation(),
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/kategori_gudang/create_kategori', $data);
    }

    public function detail(int $id_gudang)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'gudang',
            'page' => 'kategori_gudang',
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
        $page = "kategori_gudang";
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $nama_kategori = $this->request->getPost('nama_kategori');

        $array_data = array(
            'nama_kategori' => $nama_kategori,
            'status_kategori_gudang' => '16',
            'created_by' => session()->get('id_user'),
            'updated_by' => session()->get('id_user')
        );
        $inserting = $this->kategoriBarangModel->insert($array_data);
        if ($inserting) {
            $this->session->setFlashdata('success', 'Berhasil tambahkan data kategori');
            return redirect()->to('/backoffice/' . $page);
        } else {
            $this->session->setFlashdata('error', 'Gagal tambahkan data kategori');
            return redirect()->to('/backoffice/' . $page . '/create')->withInput();
        }
    }

    public function edit(int $id_gudang)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Ubah Data Kategori',
            'page' => 'kategori_gudang',
            'data' => $this->kategoriBarangModel->find($id_gudang),
            // 'gudang' => $this->gudangModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'id' => $id_gudang
        );
        // dd($this->session->get('nama'));
        return view('backoffice/kategori_gudang/edit_kategori', $data);
    }

    public function update(int $id_row)
    {
        $page = "kategori_gudang";
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $nama_kategori = $this->request->getPost('nama_kategori');
        $id_kategori = $this->request->getPost('id_kategori');
        $array_data = array(
            'nama_kategori' => $nama_kategori,
            'status_kategori_gudang' => '16',
            'created_by' => session()->get('id_user'),
            'updated_by' => session()->get('id_user')
        );
        $inserting = $this->kategoriBarangModel->update($id_kategori, $array_data);
        if ($inserting) {
            $this->session->setFlashdata('success', 'Berhasil ubah data kategori');
            return redirect()->to('/backoffice/' . $page);
        } else {
            $this->session->setFlashdata('error', 'Gagal ubah data kategori');
            return redirect()->to('/backoffice/' . $page . '/edit/' . $id_row)->withInput();
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
