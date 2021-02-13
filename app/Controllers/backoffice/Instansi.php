<?php

namespace App\Controllers\backoffice;

use App\Models\InstansiModel;
use App\Models\KotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\TestModel;
use App\Controllers\BaseController;
use App\Models\CustomerCorporateModel;
use App\Models\CustomerModel;
use Dompdf\Cpdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Instansi extends BaseController
{
    public $session;
    protected $kotaModel;
    protected $marketingModel;
    public $instansiModel;
    public $customers_corporate_model;
    public function __construct()
    {
        $this->session = \config\Services::session();
        $this->kotaModel = new KotaModel();
        $this->marketingModel = new MarketingModel();
        $this->instansiModel = new InstansiModel();
        $this->customers_corporate_model = new CustomerCorporateModel();
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
            'afiliated' => "yes",
            'pic_marketing' => $pic_marketing,
            'created_by' => $this->session->get('id_user'),
            'updated_by' => $this->session->get('id_user')
        );
        try {
            $save = $this->instansiModel->insert($data_insert);
            if ($save) {
                $this->session->setFlashdata('success', 'Berhasil tambahkan instansi');
                return redirect()->to("/backoffice/registrasi/instansi");
            } else {
                $this->session->setFlashdata('error', 'Gagal tambahkan instansi');
                return redirect()->to("/backoffice/instansi/create");
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', 'Server error untuk tambahkan instansi');
            return redirect()->to('/backoffice/instansi/create');
        }
    }

    public function detail_instansi($id_instansi)
    {
        helper('form');
        $customerModel = new CustomerModel();
        $layanan_test_model = new LayananTestModel();
        $layanan_model = new LayananModel();
        $test_model = new TestModel();
        $filtering = ($this->request->getPost('filtering')) ? $this->request->getPost('filtering') : "";
        $filter_instansi = [
            'instansi' => $id_instansi,
        ];
        if ($filtering == "on") {
            $date1 = ($this->request->getPost("date1")) ? $this->request->getPost("date1") : "";
            $date2 = ($this->request->getPost("date2")) ? $this->request->getPost("date2") : "";
            $jenis_test  = ($this->request->getPost("jenis_test")) ? $this->request->getPost("jenis_test") : "";

            if ($jenis_test != "") {
                $filter_instansi['jenis_test'] = $jenis_test;
            }
            if ($date1 != "" && $date2 != "") {
                $filter_instansi['tgl_kunjungan'] = "a.tgl_kunjungan between {$date1} AND {$date2}";
            } elseif ($date1 == "" && $date2 != "") {
                $filter_instansi['tgl_kunjungan'] = $date2;
            } elseif ($date1 != "" && $date2 != "") {
                $date_now = date("Y-m-d");
                $filter_instansi['tgl_kunjungan'] = "a.tgl_kunjungan between {$date1} AND {$date_now}";
            }
        }
        $customers = $customerModel->deep_detail_by_id(null, $filter_instansi)->getResultArray();
        $filter_instansi['kehadiran'] = 23;
        $kehadiran_customers = $customerModel->deep_detail_by_id(null, $filter_instansi)->getResultArray();
        $filter_instansi['kehadiran'] = 22;
        $ketidak_hadiran_customers = $customerModel->deep_detail_by_id(null, $filter_instansi)->getResultArray();

        $total_kehadiran = count($kehadiran_customers);
        $total_customer = count($customers);
        $total_tidak_hadir = count($ketidak_hadiran_customers);
        $detail_instansi = $this->instansiModel->find($id_instansi);
        $nama_instansi = $detail_instansi['nama'];
        $alamat = $detail_instansi['alamat'];
        $id_marketing = $detail_instansi['pic_marketing'];
        if ($id_marketing != null) {
            $detail_marketing = $this->marketingModel->find($id_marketing);
            $pic_marketing = $detail_marketing['nama_marketing'];
        } else {
            $pic_marketing = "";
        }
        $filter_test_instansi = ['id_pemeriksaan' => 1];
        if ($id_instansi == 1) {
            $filter_test_instansi['id_segmen'] = 1;
        } else {
            $filter_test_instansi['id_segmen'] = 2;
        }

        $layanan_test = $layanan_test_model->by_keys($filter_test_instansi)->get()->getResultArray();
        $pemeriksaan = array();
        foreach ($layanan_test as $key => $LT) {
            $detail_layanan = $layanan_model->find($LT['id_layanan']);
            $detail_test = $test_model->find($LT['id_test']);

            $nama_layanan = $detail_layanan['nama_layanan'];
            $nama_test = $detail_test['nama_test'];

            $pemeriksaan[] = array(
                'id' => $LT['id'],
                'text' => $nama_test . " " . $nama_layanan
            );
        }
        $data = array(
            'title' => "Data Detail Instansi",
            'page' => "instansi",
            'session' => session(),
            'customers_instansi' => $customers,
            'jumlah_customer' => $total_customer,
            'total_kehadiran' => $total_kehadiran,
            'total_invoice_terbit' => null,
            'PIC' => $pic_marketing,
            'pemeriksaan' => $pemeriksaan,
            'nama_instansi' => $nama_instansi,
            'total_tidak_hadir' => $total_tidak_hadir,
            'alamat' => $alamat

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
        $nama = $this->request->getPost('nama');
        $alamat = $this->request->getPost('alamat');
        $kota = $this->request->getPost('kota');
        $nama_user = $this->request->getPost('nama_user');
        $tempat_lahir = $this->request->getPost('tempat_lahir');
        $tgl_lahir = $this->request->getPost('tgl_lahir');
        $phone = $this->request->getPost('phone');
        $email = $this->request->getPost('email');
        $pic_marketing = (int) $this->request->getPost('pic_marketing');
        // dd($this->request->getPost());
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
            'created_by' => $this->session->get('id_user'),
            'updated_by' => $this->session->get('id_user')
        );
        try {
            $save = $this->instansiModel->update($id_instansi, $data_insert);
            // dd(db_connect()->showLastQuery());
            if ($save) {
                $this->session->setFlashdata('success', 'Berhasil ubah instansi');
            } else {
                $this->session->setFlashdata('error', 'Gagal Ubah instansi');
            }
            return redirect()->to('/backoffice/instansi/edit/' . $id_instansi);
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', 'Server error untuk ubah instansi');
            return redirect()->to('/backoffice/instansi/edit/' . $id_instansi);
        }
    }

    public function delete_instansi($id_instansi)
    {
        $data = array(
            'data_instansi' => $this->instansiModel->find($id_instansi),
            'title' => "Hapus Instansi",
            'page' => "instansi",
            'session' => session(),
            'id' => $id_instansi
        );
        return view('backoffice/instansi/delete_instansi', $data);
    }

    public function doDelete_instansi()
    {
        $id_instansi = $this->request->getPost("id_instansi");
        $cek_instansi = $this->instansiModel->find($id_instansi);
        if ($cek_instansi != null || count($cek_instansi) == 1) {
            if ($this->instansiModel->delete($id_instansi)) {
                $this->session->setFlashdata('success', 'Berhasil hapus instansi');
                return redirect()->to("/backoffice/registrasi/instansi");
            } else {
                $this->session->setFlashdata('error', 'Gagal hapus instansi');
                return redirect()->to('/backoffice/instansi/delete_instansi/' . $id_instansi);
            }
        } else {
            $this->session->setFlashdata('error', 'Gagal hapus instansi');
            return redirect()->to('/backoffice/instansi/delete_instansi/' . $id_instansi);
        }
    }
}
