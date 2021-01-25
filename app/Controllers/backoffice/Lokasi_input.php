<?php

namespace App\Controllers\backoffice;

use App\Models\KotaModel;
use App\Controllers\BaseController;
use App\Models\LokasiPenginputanModel;

// use App\Controllers;
// use CodeIgniter\Controller;

class Lokasi_input extends BaseController
{
    public $session;
    public $lokasiInputModel;
    protected $kotaModel;
    public function __construct()
    {
        // $this->kotaModel = new KotaModel();
        $this->session = session();
        $this->lokasiInputModel = new LokasiPenginputanModel();
        $this->kotaModel = new KotaModel();
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Data Lokasi Input',
            'page' => 'lokasi_input',
            'data' => $this->lokasiInputModel->findAll(),
            'kota' => $this->kotaModel,
            'session' => session(),
        );
        // dd($this->session->get('nama'));
        return view('backoffice/lokasi_input/index_lokasi', $data);
    }

    public function create()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Tambah Data Lokasi Penginputan',
            'page' => 'lokasi_input',
            // 'kota' => $this->kotaModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'kota' => $this->kotaModel->findAll()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/lokasi_input/create_lokasi', $data);
    }

    public function save()
    {
        // dd($this->request->getPost());
        $id_kota = $this->request->getPost('id_kota');
        $url_kop = $this->request->getPost('url_kop');
        $data_kota = $this->kotaModel->find($id_kota);
        if ($data_kota) {
            $arrayInsert = array(
                'id_kota' => $id_kota,
                'url_kop' => $url_kop,
                'created_by' => $this->session->get('id_user'),
                'updated_by' => $this->session->get('id_user')
            );
            $inserting = $this->lokasiInputModel->insert($arrayInsert);
            if ($inserting) {
                $this->session->setFlashdata('success', 'Berhasil tambahkan data');
                return redirect()->to('/backoffice/lokasi_input');
            } else {
                $this->session->setFlashdata('error', 'Gagal tambahkan data');
                return redirect()->to('/backoffice/lokasi_input/create')->withInput();
            }
        } else {
            $this->session->setFlashdata('error', 'Gagal tambahkan data');
            return redirect()->to('/backoffice/lokasi_input/create')->withInput();
        }
    }

    public function detail($id_dokter)
    {
        # code...
    }

    public function edit(int $id_lokasi)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Ubah Data Lokasi Penginputan',
            'page' => 'lokasi_input',
            // 'kota' => $this->kotaModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'kota' => $this->kotaModel->findAll(),
            'id' => $id_lokasi,
            'data' => $this->lokasiInputModel->find($id_lokasi)
        );
        // dd($this->session->get('nama'));
        return view('backoffice/lokasi_input/edit_lokasi', $data);
    }

    public function update(int $id_row)
    {
        // dd($this->request->getPost());
        $id_kota = $this->request->getPost('id_kota');
        $url_kop = $this->request->getPost('url_kop');
        $id_lokasi = $this->request->getPost('id_lokasi');
        $data_kota = $this->kotaModel->find($id_kota);
        if ($id_row != $id_lokasi) {
            $this->session->setFlashdata('error', 'Gagal ubah data karena url dengan lokasi tidak sesuai');
            return redirect()->to('/backoffice/lokasi_input/edit' . $id_lokasi)->withInput();
        }
        if ($data_kota) {
            $arrayInsert = array(
                'id_kota' => $id_kota,
                'url_kop' => $url_kop,
                'created_by' => $this->session->get('id_user'),
                'updated_by' => $this->session->get('id_user')
            );
            $updating = $this->lokasiInputModel->update($id_lokasi, $arrayInsert);
            if ($updating) {
                $this->session->setFlashdata('success', 'Berhasil ubah data');
                return redirect()->to('/backoffice/lokasi_input');
            } else {
                $this->session->setFlashdata('error', 'Gagal ubah data');
                return redirect()->to('/backoffice/lokasi_input/edit' . $id_lokasi)->withInput();
            }
        } else {
            $this->session->setFlashdata('error', 'Gagal ubah data');
            return redirect()->to('/backoffice/lokasi_input/edit' . $id_lokasi)->withInput();
        }
    }

    public function delete(int $id_lokasi)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $dataLokasi = $this->lokasiInputModel->find($id_lokasi);
        $dataKota = $this->kotaModel->find($dataLokasi['id_kota']);
        $data = array(
            'title' => 'Hapus Data Lokasi Penginputan',
            'page' => 'lokasi_input',
            // 'kota' => $this->kotaModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'id' => $id_lokasi,
            'nama_kota' => $dataKota['nama_kota']
        );
        // dd($this->session->get('nama'));
        return view('backoffice/lokasi_input/delete_lokasi', $data);
    }

    public function do_delete()
    {
        $id_lokasi = $this->request->getPost('id_lokasi');
        $findDataLokasi = $this->lokasiInputModel->find($id_lokasi);
        if ($findDataLokasi) {
            $this->lokasiInputModel->delete($id_lokasi);
            $this->session->setFlashdata('success', 'Berhasil menghapus data lokasi penginputan');
            return redirect()->to('/backoffice/lokasi_input');
        } else {
            $this->session->setFlashdata('error', 'Gagal menghapus data lokasi penginputan');
            return redirect()->to('/backoffice/lokasi_input');
        }
    }
}
