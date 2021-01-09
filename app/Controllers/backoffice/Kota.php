<?php

namespace App\Controllers\backoffice;

use App\Models\KotaModel;
use CodeIgniter\Controller;
use CodeIgniter\Validation\Validation;

// use App\Controllers;
// use CodeIgniter\Controller;

class Kota extends Controller
{
    public $session;
    protected $kotaModel;
    public function __construct()
    {
        $this->kotaModel = new KotaModel();
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
            'title' => 'Kota',
            'page' => 'kota',
            'data' => $this->kotaModel->findAll(),
            // 'kota' => $this->kotaModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/kota/index_kota', $data);
    }

    public function create()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Kota',
            'page' => 'kota',
            // 'kota' => $this->kotaModel,
            'validation' => \Config\Services::validation(),
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/kota/create_kota', $data);
    }

    public function save()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $nama_kota = $this->request->getPost('nama_kota');
        $city = $this->request->getPost('city');
        $province = $this->request->getPost('province');
        $array_data = array(
            'nama_kota' => $nama_kota,
            'city' => $city,
            'province' => $province,
            'created_by' => $this->session->get('id_user'),
            'updated_by' => $this->session->get('id_user')
        );
        $inserting = $this->kotaModel->insert($array_data);
        if ($inserting) {
            $this->session->setFlashdata('success', 'Berhasil tambahkan data kota');
            return redirect()->to('/backoffice/kota');
        } else {
            $this->session->setFlashdata('error', 'Gagal tambahkan data kota');
            return redirect()->to('/backoffice/kota')->withInput();
        }
    }

    public function edit(int $id_kota)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Kota',
            'page' => 'kota',
            'data' => $this->kotaModel->find($id_kota),
            // 'kota' => $this->kotaModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'id' => $id_kota
        );
        // dd($this->session->get('nama'));
        return view('backoffice/kota/edit_kota', $data);
    }

    public function update(int $id_row)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $nama_kota = $this->request->getPost('nama_kota');
        $city = $this->request->getPost('city');
        $province = $this->request->getPost('province');
        $id_kota = $this->request->getPost('id_kota');
        if ($id_row != $id_kota) {
            $this->session->setFlashdata('error', 'Gagal update data kota');
            return redirect()->to('/backoffice/kota')->withInput();
        }
        $array_data = array(
            'nama_kota' => $nama_kota,
            'city' => $city,
            'province' => $province,
            'created_by' => $this->session->get('id_user'),
            'updated_by' => $this->session->get('id_user')
        );
        $updating = $this->kotaModel->update($id_kota, $array_data);
        if ($updating) {
            $this->session->setFlashdata('success', 'Berhasil tambahkan data kota');
            return redirect()->to('/backoffice/kota');
        } else {
            $this->session->setFlashdata('error', 'Gagal tambahkan data kota');
            return redirect()->to('/backoffice/kota')->withInput();
        }
    }

    public function delete(int $id_kota)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Kota',
            'page' => 'kota',
            'data' => $this->kotaModel->find($id_kota),
            // 'kota' => $this->kotaModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'id' => $id_kota
        );
        // dd($this->session->get('nama'));
        return view('backoffice/kota/delete_kota', $data);
    }

    public function do_delete(int $id_faskes)
    {
        # code...
    }
}
