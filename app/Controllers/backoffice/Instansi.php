<?php

namespace App\Controllers\backoffice;

use App\Models\InstansiModel;
use App\Models\KotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\TestModel;
use CodeIgniter\Controller;
use Dompdf\Cpdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Instansi extends Controller
{
    public $session;
    protected $kotaModel;
    protected $marketingModel;
    public $instansiModel;
    public function __construct()
    {
        $this->session = session();
        $this->kotaModel = new KotaModel();
        $this->marketingModel = new MarketingModel();
        $this->instansiModel = new InstansiModel();
    }
    public function index()
    {
        $DataInstansi = $this->instansiModel->findAll();
        $data = array(
            'title' => "Data Instansi",
            'page' => "instansi",
            'session' => session(),
            'data' => $DataInstansi
        );
        return view('backoffice/instansi/index_instansi', $data);
    }
    public function create_instansi()
    {
        $dataKota = $this->kotaModel->findAll();
        $dataMarketing = $this->marketingModel->findAll();
        $data = array(
            'title' => "Tambah Instansi",
            'page' => "instansi",
            'session' => session(),
            'data_kota' => $dataKota,
            'data_marketing' => $dataMarketing
        );
        return view('backoffice/instansi/create_instansi', $data);
    }

    public function save_instansi()
    {
        $nama = $this->request->getVar('nama');
        $alamat = $this->request->getVar('alamat');
        $kota = $this->request->getVar('kota');
        $nama_user = $this->request->getVar('nama_user');
        $tempat_lahir = $this->request->getVar('tempat_lahir');
        $tgl_lahir = $this->request->getVar('tgl_lahir');
        $phone = $this->request->getVar('phone');
        $email = $this->request->getVar('email');
        $pic_marketing = $this->request->getVar('pic_marketing');
        $data_insert = array(
            'nama' => $nama,
            'alamat' => $alamat,
            'kota' => $kota,
            'nama_user' => $nama_user,
            'tampat_lahir' => $tempat_lahir,
            'tgl_lahir' => $tgl_lahir,
            'phone' => $phone,
            'email' => $email,
            'pic_marketing' => $pic_marketing,
            'created_by' => session('id_user'),
            'updated_by' => session('id_user')
        );
        try {
            $save = $this->instansiModel->insert($data_insert);
            if ($save) {
                $this->session->setFlashdata('success', 'Berhasil tambahkan instansi');
                return redirect(base_url('backoffice/registrasi/instansi'));
            } else {
                $this->session->setFlashdata('error', 'Gagal tambahkan instansi');
                return redirect(base_url('backoffice/instansi/create'));
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', 'Server error untuk tambahkan instansi');
            return redirect(base_url('backoffice/instansi/create'));
        }
    }

    public function detail_instansi($id_instansi)
    {
        $data = array(
            'title' => "Detail Instansi",
            'page' => "instansi",
            'session' => session(),
        );
        return view('backoffice/instansi/detail_instansi', $data);
    }

    public function edit_instansi($id_instansi)
    {
        $data_instansi = $this->instansiModel->find($id_instansi);
        $data_marketing = $this->marketingModel->findAll();
        $data_kota = $this->kotaModel->findAll();
        $data = array(
            'title' => "Ubah Instansi",
            'page' => "instansi",
            'session' => session(),
            'id' => $id_instansi,
            'data_instansi' => $data_instansi,
            'data_marketing' => $data_marketing,
            'data_kota' => $data_kota
        );
        return view('backoffice/instansi/edit_instansi', $data);
    }

    public function update_instansi($id_instansi)
    {
        $nama = $this->request->getVar('nama');
        $alamat = $this->request->getVar('alamat');
        $kota = $this->request->getVar('kota');
        $nama_user = $this->request->getVar('nama_user');
        $tempat_lahir = $this->request->getVar('tempat_lahir');
        $tgl_lahir = $this->request->getVar('tgl_lahir');
        $phone = $this->request->getVar('phone');
        $email = $this->request->getVar('email');
        $pic_marketing = $this->request->getVar('pic_marketing');
        $data_insert = array(
            'nama' => $nama,
            'alamat' => $alamat,
            'kota' => $kota,
            'nama_user' => $nama_user,
            'tampat_lahir' => $tempat_lahir,
            'tgl_lahir' => $tgl_lahir,
            'phone' => $phone,
            'email' => $email,
            'pic_marketing' => $pic_marketing,
            'created_by' => session('id_user'),
            'updated_by' => session('id_user')
        );
        try {
            $save = $this->instansiModel->update($id_instansi, $data_insert);
            if ($save) {
                $this->session->setFlashdata('success', 'Berhasil ubah instansi');
                return redirect(base_url('backoffice/registrasi/instansi'));
            } else {
                $this->session->setFlashdata('error', 'Gagal tambahkan instansi');
                return redirect(base_url('backoffice/instansi/edit_instansi/' . $id_instansi));
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', 'Server error untuk tambahkan instansi');
            return redirect(base_url('backoffice/instansi/edit_instansi/' . $id_instansi));
        }
    }

    public function delete_instansi($id_instansi)
    {
        $data = array(
            'title' => "Hapus Instansi",
            'page' => "instansi",
            'session' => session(),
        );
        return view('backoffice/instansi/delete_instansi', $data);
    }

    public function doDelete_instansi()
    {
        # code...
    }
}
