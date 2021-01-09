<?php

namespace App\Controllers\backoffice;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\KuotaModel;
use App\Models\LayananTestModel;
use App\Models\UserModel;

// use CodeIgniter\Controller;

class Settings extends ResourceController
{
    protected $session;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        if (!$this->session->has('username')) {
            redirect(base_url('backoffice/user/login'));
        }
        // if()
    }
    public function index()
    {
        $JenisLayananTest = new LayananTestModel();
        $jadwalLayanan = new KuotaModel();
        $dataLayananTest = $JenisLayananTest->findAll();
        $data = [
            'title' => 'Pengaturan',
            'page' => 'Pengaturan',
            'jadwalModel' => $jadwalLayanan,
            'layananTest' => $dataLayananTest
        ];
        return view('backoffice/pengaturan/index', $data);
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

    public function update_kuota($id)
    {
        # code...
        $jadwalLayanan = new KuotaModel();
        $jam = $this->request->getVar('jam');
        $updated_by = $this->session->get('id_user');
        $kuota = $this->request->getVar('kuota');
        $setData = ['jam' => $jam, 'kuota' => $kuota, 'updated_by' => $updated_by];
        $return = array();
        try {
            $update = $jadwalLayanan->update($id, $setData);
            if ($update) {
                return $this->respondUpdated($jadwalLayanan->find($id), 'success');
            } else {
                return $this->fail('failed');
            }
        } catch (\Throwable $th) {
            return $this->failServerError('Internal Server Error', 500, 'Failed ' . $th->getMessage());
        }
    }

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
