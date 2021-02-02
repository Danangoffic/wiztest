<?php

namespace App\Controllers\backoffice;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KuotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\PemeriksaanModel;
use App\Models\TestModel;
use App\Models\UserModel;

// use CodeIgniter\Controller;

class Settings extends ResourceController
{
    protected $session;
    protected $data_layanan_test_model;
    protected $kuota_model;
    protected $layanan_model;
    protected $test_model;
    protected $pemeriksaan_model;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->data_layanan_test_model = new LayananTestModel();
        $this->kuota_model = new KuotaModel();
        $this->layanan_model = new LayananModel();
        $this->test_model = new TestModel();
        $this->pemeriksaan_model = new PemeriksaanModel();
        // if()
    }
    public function index()
    {
        $JenisLayananTest = $this->data_layanan_test_model->where(['id_segmen' => '1', 'id_pemeriksaan' => '1'])->get()->getResultArray();
        $data = [
            'title' => 'Pengaturan',
            'page' => 'Pengaturan',
            'jenis_layanan_test' => $JenisLayananTest,
            'kuota_model' => $this->kuota_model,
            'layanan_model' => $this->layanan_model,
            'test_model' => $this->test_model,
            'pemeriksaan_model' => $this->pemeriksaan_model,
            'session' => $this->session
        ];
        return view('backoffice/settings/index_settings', $data);
    }

    public function update_biaya()
    {

        $ids = $this->request->getPost('id');
        // $array_batch = array();
        $status_update = false;
        try {
            foreach ($ids as $key => $id_biaya) {
                $biaya = $this->request->getPost('biaya' . $id_biaya);
                $array_update = array('biaya' => $biaya);
                if ($this->data_layanan_test_model->update($id_biaya, $array_update)) {
                    $status_update = true;
                }
            }
            if ($status_update) {
                $this->session->setFlashdata('success', "Berhasil update biaya test");
                return redirect()->to('/backoffice/settings');
            } else {
                $this->session->setFlashdata('error', "Gagal update biaya test");
                return redirect()->to('/backoffice/settings');
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', "Gagal update biaya test");
            return redirect()->to('/backoffice/settings');
        }
    }

    public function update_kuota($id_test)
    {
        $ids = $this->request->getPost('id');
        // $array_batch = array();
        $status_update = false;
        try {
            $data_test = $this->data_layanan_test_model->find($id_test);
            if (count($data_test) == 0) {
                $this->session->setFlashdata('error', "Gagal update kuota test");
                return redirect()->to('/backoffice/settings');
            }
            foreach ($ids as $key => $id_kuota) {
                // echo $id_kuota;
                $kuota = $this->request->getPost("kuota");
                $array_update = array('kuota' => $kuota[$id_kuota]);
                $this->kuota_model->update($id_kuota, $array_update);
                // echo db_connect()->showLastQuery() . "<br>";
                // if ($this->kuota_model->update($id_kuota, $array_update)) {
                //     $status_update = true;
                // } else {
                //     $status_update = false;
                // }
            }
            $this->session->setFlashdata('success', "Berhasil update kuota test");
            return redirect()->to('/backoffice/settings');
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', "Gagal update kuota test");
            return redirect()->to('/backoffice/settings');
        }
    }

    public function detail_kuota_by_id()
    {
        $userModel = new UserModel();
        $jadwalLayanan = new KuotaModel();
        $id = $this->request->getVar('id');
        $getBy = $this->session->get('id_user');
        $cekUser = $userModel->find($getBy);
        if ($cekUser['user_level'] != '1') {
            return $this->fail('Failed');
        }
        try {
            //code...
            $dataKuota = $jadwalLayanan->find($id);
            if (count($dataKuota) > 0) {
                return $this->respond($dataKuota, 200, 'success');
            } else {
                return $this->failNotFound();
            }
        } catch (\Throwable $th) {
            return $this->failServerError('Failed ' . $th->getMessage());
        }
    }

    public function detail_paket_pemeriksaan()
    {
        $id_paket_pemeriksaan = $this->request->getVar("id_paket_pemeriksaan");

        try {
            $check = $this->data_layanan_test_model->find($id_paket_pemeriksaan);
            if ($check && $check != null) {
                return $this->respond($check, 200, 'success');
            } else {
                return $this->failNotFound('failed');
            }
        } catch (\Throwable $th) {
            return $this->failServerError("failed");
        }
    }

    // public function update_kuota($id)
    // {
    //     # code...
    //     $jadwalLayanan = new KuotaModel();
    //     $jam = $this->request->getVar('jam');
    //     $updated_by = $this->session->get('id_user');
    //     $kuota = $this->request->getVar('kuota');
    //     $setData = ['jam' => $jam, 'kuota' => $kuota, 'updated_by' => $updated_by];
    //     $return = array();
    //     try {
    //         $update = $jadwalLayanan->update($id, $setData);
    //         if ($update) {
    //             return $this->respondUpdated($jadwalLayanan->find($id), 'success');
    //         } else {
    //             return $this->fail('failed');
    //         }
    //     } catch (\Throwable $th) {
    //         return $this->failServerError('Internal Server Error', 500, 'Failed ' . $th->getMessage());
    //     }
    // }

    // public function auto_create()
    // {
    //     $JenisLayananTest = new LayananTestModel();
    //     $jadwalLayanan = new KuotaModel();
    //     $dataLayananTest = $JenisLayananTest->findAll();
    //     $created_by = 1;
    //     $updated_by = 1;
    //     $data = array();
    //     foreach ($dataLayananTest as $key => $value) {
    //         for ($i = 1; $i < 25; $i++) {
    //             $data = [
    //                 'jenis_test_layanan' => $value['id'],
    //                 'jam' => "0$i:00",
    //                 'kuota' => 0,
    //                 'status' => 1,
    //                 'created_by' => $created_by,
    //                 'updated_by' => $updated_by
    //             ];
    //             $jadwalLayanan->insert($data);
    //         }
    //     }
    //     $dataJadwal = $jadwalLayanan->findAll();
    //     $data = ['data' => $dataJadwal, ' statusMessage' => 'success'];
    //     dd($data);
    // }

    //--------------------------------------------------------------------

}
