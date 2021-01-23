<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\DokterModel;
use App\Models\FaskesModel;
use App\Models\KotaModel;
use App\Models\KuotaModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use CodeIgniter\Controller;
// use App\Controllers;
// use CodeIgniter\Controller;

class Petugas extends Controller
{
    public $session;
    protected $pemeriksaModel;
    protected $kotaModel;
    public function __construct()
    {
        $this->pemeriksaModel = new PemeriksaModel();
        // $this->kotaModel = new KotaModel();
        $this->session = session();
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Petugas Pemeriksa',
            'page' => 'petugas',
            'data' => $this->pemeriksaModel->findAll(),
            // 'kota' => $this->kotaModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/pemeriksa/index_pemeriksa', $data);
    }

    public function create()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Tambah Data Petugas Pemeriksa',
            'page' => 'petugas',
            'validation' => \Config\Services::validation(),
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/pemeriksa/create_pemeriksa', $data);
    }

    public function save()
    {
        $nama = $this->request->getPost('nama');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        $arrayInsert = array(
            'nama' => $nama,
            'phone' => $phone,
            'email' => $email,
            'created_by' => $this->session->get('id_user'),
            'updated_by' => $this->session->get('id_user')
        );
        $inserting = $this->pemeriksaModel->insert($arrayInsert);
        if ($inserting) {
            $this->session->setFlashdata('success', 'Berhasil tambahkan data petugas');
            return redirect()->to('/backoffice/petugas');
        } else {
            $this->session->setFlashdata('error', 'Gagal tambahkan data petugas');
            return redirect()->to('/backoffice/petugas')->withInput();
        }
    }

    public function edit(int $id_pemeriksa)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Petugas Pemeriksa',
            'page' => 'petugas',
            'data' => $this->pemeriksaModel->find($id_pemeriksa),
            'id' => $id_pemeriksa,
            'validation' => \Config\Services::validation(),
            // 'kota' => $this->kotaModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/pemeriksa/edit_pemeriksa', $data);
    }

    public function update(int $id_row)
    {
        $nama = $this->request->getPost('nama');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        $id_petugas = $this->request->getPost('id_petugas');
        if ($id_row != $id_petugas) {
            $this->session->setFlashdata('error', 'Gagal ubah data petugas karena url tidak sesuai');
            return redirect()->to('/backoffice/petugas/edit/' . $id_petugas)->withInput();
        }
        $arrayInsert = array(
            'nama' => $nama,
            'phone' => $phone,
            'email' => $email,
            'created_by' => $this->session->get('id_user'),
            'updated_by' => $this->session->get('id_user')
        );
        $inserting = $this->pemeriksaModel->update($id_petugas, $arrayInsert);
        if ($inserting) {
            $this->session->setFlashdata('success', 'Berhasil ubah data petugas');
            return redirect()->to('/backoffice/petugas');
        } else {
            $this->session->setFlashdata('error', 'Gagal ubah data petugas');
            return redirect()->to('/backoffice/petugas/edit/' . $id_petugas)->withInput();
        }
    }

    public function delete(int $id_pemeriksa)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Hapus Petugas Pemeriksa',
            'page' => 'petugas',
            'data' => $this->pemeriksaModel->find($id_pemeriksa),
            'id' => $id_pemeriksa,
            // 'kota' => $this->kotaModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/pemeriksa/delete_pemeriksa', $data);
    }

    public function do_delete(int $id_row)
    {
        $id_pemeriksa = $this->request->getPost('id_pemeriksa');
        if ($id_row != $id_pemeriksa) {
            $this->session->setFlashdata('error', 'Gagal hapus data petugas karena url tidak sesuai');
            return redirect()->to('/backoffice/petugas/delete/' . $id_pemeriksa)->withInput();
        }
        $data_petugas = $this->pemeriksaModel->find($id_pemeriksa);
        if ($data_petugas) {
            $this->pemeriksaModel->delete($id_pemeriksa);
            $this->session->setFlashdata('success', 'Berhasil hapus data petugas');
            return redirect()->to('/backoffice/petugas');
        } else {
            $this->session->setFlashdata('error', 'Gagal hapus data petugas');
            return redirect()->to('/backoffice/petugas/')->withInput();
        }
    }
}
