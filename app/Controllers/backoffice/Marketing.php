<?php

namespace App\Controllers\backoffice;

use App\Controllers\BaseController;
use App\Models\CustomerModel;
use App\Models\KotaModel;
use App\Models\LokasiPenginputanModel;
use App\Models\MarketingModel;

class Marketing extends BaseController
{
    public $marketing_model;
    protected $kota_model;
    protected $lokasi_input_model;
    public $session;
    protected $customers_model;
    public function __construct()
    {
        $this->marketing_model = new MarketingModel();
        $this->session = \Config\Services::session();
        $this->kota_model = new KotaModel();
        $this->lokasi_input_model = new LokasiPenginputanModel();
        $this->customers_model = new CustomerModel();
    }

    public function index()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        // if ($this->session->get("user_level") == 1 || $this->session->get('user_level') == 2) {
        //     // return true;
        // } else {
        //     return redirect()->to(base_url());
        // }

        $db_url_app_reg = db_connect()->table('system_parameter')->where(['vgroup' => 'URL', 'parameter' => "APP_REGISTRATION"])->get()->getFirstRow();
        $decode_url = base64_decode($db_url_app_reg->value);

        $page = 'marketing';
        $data = array(
            'title' => "Data Marketing",
            'page' => $page,
            'data_marketing' => $this->marketing_model->findAll(),
            'kota_model' => $this->kota_model,
            'lokasi_input_model' => $this->lokasi_input_model,
            'customer_model' => $this->customers_model,
            'session' => $this->session,
            'url_reg' => $decode_url
        );
        return view('backoffice/marketing/index_' . $page, $data);
    }

    public function detail(int $id_marketing)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        if ($this->session->get("user_level") == 1 || $this->session->get('user_level') == 2) {
            // return true;
        } else {
            return redirect()->to(base_url());
        }

        $check_marketing = $this->marketing_model->find($id_marketing);
        if (!$check_marketing) return redirect()->to(base_url());
        $page = 'marketing';
        $data = array(
            'title' => "Detail Marketing",
            'page' => $page,
            'data_marketing' => $check_marketing,
            'kota_model' => $this->kota_model,
            'lokasi_input_model' => $this->lokasi_input_model,
            'customer_model' => $this->customers_model,
            'session' => $this->session
        );
        return view('backoffice/marketing/detail_' . $page, $data);
    }

    public function edit(int $id_marketing)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        if ($this->session->get("user_level") == 1 || $this->session->get('user_level') == 2) {
            // return true;
        } else {
            return redirect()->to(base_url());
        }

        $detail_marketing = $this->marketing_model->find($id_marketing);
        if ($detail_marketing == null) {
            $this->session->setFlashdata('error', 'Data marketing tidak ditemukan');
            return redirect()->to("/marketing");
        }
        $data = [
            'data_marketing' => $detail_marketing,
            'kota' => $this->kota_model,
            'title' => "Ubah data marketing",
            'page' => "marketing",
            'id' => $id_marketing,
            'session' => $this->session
        ];
        return view("backoffice/marketing/edit_marketing", $data);
    }

    public function create()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        if ($this->session->get("user_level") == 1 || $this->session->get('user_level') == 2) {
            // return true;
        } else {
            return redirect()->to(base_url());
        }
        $data = [
            'title' => "Form tambah marketing",
            'page' => "marketing",
            'kota' => $this->kota_model,
            'session' => $this->session
        ];
        return view("backoffice/marketing/create_marketing", $data);
    }

    public function save()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        $user_level = $this->session->get('user_level');

        if ($user_level == 1 || $user_level == 2) {
            // return true;
        } else {
            return redirect()->to(base_url());
        }
        // dd($this->request->getPost());
        $id_kota = $this->request->getPost('kota');
        $nama_marketing = $this->request->getPost('nama_marketing');
        $id_user = $this->session->get("id_user");
        $afiliasi_hs = ($this->request->getPost("afiliasi_hs") == null) ? "no" : "yes";
        $afiliasi_rujukan = ($this->request->getPost("afiliasi_rujukan") == null) ? "no" : "yes";

        $data_insert = array(
            'id_kota' => intval($id_kota),
            'nama_marketing' => $nama_marketing,
            'created_by' => $id_user,
            'updated_by' => $id_user,
            'is_afiliated_hs' => $afiliasi_hs,
            'is_afiliated_rujukan' => $afiliasi_rujukan
        );
        if ($this->marketing_model->insert($data_insert)) {
            $this->session->setFlashdata('success', "Berhasil tambahkan data marketing");
            return redirect()->to("/marketing");
        } else {
            $this->session->setFlashdata('error', "Gagal tambahkan data marketing");
            return redirect()->to("/marketing/create");
        }
    }


    /**
     * UPDATE MARKETING DATA
     *
     * @param request $this->request->post()
     * @return RedirectResponse
     * @method POST
     **/
    public function update()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        if ($this->session->get("user_level") == 1 || $this->session->get('user_level') == 2) {
            // return true;
        } else {
            return redirect()->to(base_url());
        }

        // dd($this->request->getPost());
        $id_marketing = $this->request->getPost("id_marketing");
        $validasi_marketing = $this->marketing_model->find($id_marketing);
        if ($validasi_marketing == null) {
            $this->session->setFlashdata('error', "Data marketing tidak terdaftar");
            return redirect()->to("/marketing");
        }
        $id_kota = $this->request->getPost('kota');
        $nama_marketing = $this->request->getPost('nama_marketing');
        $id_user = $this->session->get("id_user");
        $afiliasi_hs = ($this->request->getPost("afiliasi_hs") == null) ? "no" : "yes";
        $afiliasi_rujukan = ($this->request->getPost("afiliasi_rujukan") == null) ? "no" : "yes";

        $data_insert = array(
            'id_kota' => $id_kota,
            'nama_marketing' => $nama_marketing,
            'created_by' => $id_user,
            'updated_by' => $id_user,
            'is_afiliated_hs' => $afiliasi_hs,
            'is_afiliated_rujukan' => $afiliasi_rujukan
        );
        if ($this->marketing_model->update($id_marketing, $data_insert)) {
            $this->session->setFlashdata('success', "Berhasil ubah data marketing");
            return redirect()->to("/marketing");
        } else {
            $this->session->setFlashdata('error', "Gagal ubah data marketing");
            return redirect()->to("/marketing/edit/" . $id_marketing);
        }
    }

    public function delete(int $id_marketing)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        $user_level = $this->session->get("user_level");
        if ($user_level == 1 || $user_level == 2) {
            // return true;
        } else {
            $this->session->setFlashdata('error', "Anda tidak memiliki akses");
            return redirect()->to("/");
        }

        // $id_marketing = $this->request->getPost("id_marketing");
        $validasi_marketing = $this->marketing_model->find($id_marketing);
        // dd($validasi_marketing);
        if ($validasi_marketing == null) {
            $this->session->setFlashdata('error', "Data marketing tidak terdaftar");
            return redirect()->to("/marketing");
        }
        $data = array(
            'data_marketing' => $validasi_marketing,
            'title' => "Hapus data marketing",
            'page' => 'marketing',
            'session' => $this->session,
            'id' => $id_marketing
        );
        return view("backoffice/marketing/delete_marketing", $data);
    }

    /**
     * Do Delete Marketing Data
     *
     * @param request $this->request->post()
     * @return RedirectResponse
     * @method POST
     **/
    public function do_delete()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        if ($this->session->get("user_level") == 1 || $this->session->get('user_level') == 2) {
            // return true;
        } else {
            return redirect()->to(base_url());
        }
        $id_marketing = $this->request->getPost("id_marketing");
        try {
            $validasi_marketing = $this->marketing_model->find($id_marketing);
            if ($validasi_marketing == null) {
                $this->session->setFlashdata('error', "Data marketing tidak terdaftar");
                return redirect()->to("/marketing");
            }
            if ($this->marketing_model->delete($id_marketing)) {
                $this->session->setFlashdata('success', "Berhasil hapus marketing");
                return redirect()->to("/marketing");
            } else {
                $this->session->setFlashdata("error", "Gagal hapus data marketing");
                return redirect()->to("/marketing/delete/" . $id_marketing);
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata("error", "Gagal hapus data marketing");
            return redirect()->to("/marketing/delete/" . $id_marketing);
        }
    }


    public function afiliasi()
    {
        # code...
    }
}
