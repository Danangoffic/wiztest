<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\FaskesModel;
use App\Models\KotaModel;
use App\Models\KuotaModel;
use App\Models\PemeriksaanModel;
use App\Controllers\BaseController;
// use App\Controllers;
// use CodeIgniter\Controller;

class Faskes extends BaseController
{
    public $session;
    protected $faskesModel;
    protected $kotaModel;
    protected $userC;
    public function __construct()
    {
        $this->faskesModel = new FaskesModel();
        $this->kotaModel = new KotaModel();
        $this->userC = new User;
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Faskes',
            'page' => 'faskes',
            'data' => $this->faskesModel->findAll(),
            'kota' => $this->kotaModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/faskes/index_faskes', $data);
    }

    public function create()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Tambah Data Faskes',
            'page' => 'faskes',
            'kota' => $this->kotaModel->findAll(),
            'session' => $this->session
        );
        // dd($this->session->get('nama'));
        return view('backoffice/faskes/create_faskes', $data);
    }

    public function save()
    {
        try {
            $nama_faskes = $this->request->getPost('nama_faskes');
            $health_facility = $this->request->getPost('health_facility');
            $phone = $this->request->getPost('phone');
            $email = $this->request->getPost('email');
            $alamat = $this->request->getPost('alamat');
            $kota = $this->request->getPost('kota');
            $created_by = $this->session->get("id_user");
            $updated_by = $this->session->get("id_user");
            $data_insert = array(
                'nama_faskes' => $nama_faskes,
                'health_facility' => $health_facility,
                'phone' => $phone,
                'email' => $email,
                'alamat' => $alamat,
                'kota' => $kota,
                'created_by' => $created_by,
                'updated_by' => $updated_by
            );
            $inserting = $this->faskesModel->insert($data_insert);
            if ($inserting) {
                $this->session->setFlashdata('success', 'Berhasil tambahkan data faskes');
                return redirect()->to('/backoffice/faskes');
            } else {
                $this->session->setFlashdata('error', 'Gagal tambahkan data faskes');
                return redirect()->to('/backoffice/faskes/create');
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', 'Gagal tambahkan data faskes');
            return redirect()->to('/backoffice/faskes/create');
        }
    }

    public function edit(int $id_faskes)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Ubah Data Faskes',
            'page' => 'faskes',
            'kota' => $this->kotaModel->findAll(),
            'session' => $this->session,
            'data' => $this->faskesModel->find($id_faskes),
            'id' => $id_faskes
        );
        // dd($this->session->get('nama'));
        return view('backoffice/faskes/edit_faskes', $data);
    }

    public function update(int $id_row)
    {
        try {
            $nama_faskes = $this->request->getPost('nama_faskes');
            $health_facility = $this->request->getPost('health_facility');
            $phone = $this->request->getPost('phone');
            $email = $this->request->getPost('email');
            $alamat = $this->request->getPost('alamat');
            $kota = $this->request->getPost('kota');
            $created_by = $this->session->get("id_user");
            $updated_by = $this->session->get("id_user");
            $id_faskes = $this->request->getPost('id_faskes');
            $data_insert = array(
                'nama_faskes' => $nama_faskes,
                'health_facility' => $health_facility,
                'phone' => $phone,
                'email' => $email,
                'alamat' => $alamat,
                'kota' => $kota,
                'created_by' => $created_by,
                'updated_by' => $updated_by
            );
            $inserting = $this->faskesModel->update($id_faskes, $data_insert);
            if ($inserting) {
                $this->session->setFlashdata('success', 'Berhasil ubah data faskes');
                return redirect()->to('/backoffice/faskes');
            } else {
                $this->session->setFlashdata('error', 'Gagal ubah data faskes');
                return redirect()->to('/backoffice/faskes/create');
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', 'Gagal ubah data faskes');
            return redirect()->to('/backoffice/faskes/create');
        }
    }

    public function delete(int $id_faskes)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Hapus Data Faskes',
            'page' => 'faskes',
            'session' => session(),
            'data' => $this->faskesModel->find($id_faskes),
            'id' => $id_faskes
        );
        // dd($this->session->get('nama'));
        return view('backoffice/faskes/delete_faskes', $data);
    }

    public function do_delete(int $id_faskes)
    {
        $user = $this->session->get("id_user");
        $dataUser = $this->userC->userModel->find($user);
        $user_level = $dataUser['user_level'];
        if ($user_level !== '1') {
            $this->session->setFlashdata('error', 'Maaf anda tidak memiliki akses untuk menghapus data');
            return redirect()->to('/backoffice/faskes');
        } else if ($user_level == '1') {
            $this->faskesModel->delete($id_faskes);
            $this->session->setFlashdata('success', 'Berhasil menghapus data faskes');
            return redirect()->to('/backoffice/faskes');
        }
    }
}
