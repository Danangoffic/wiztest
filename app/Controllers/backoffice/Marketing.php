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
        // print_r($this->session->get());

        // var_dump($this->session->get("user_level"));
        // exit();
        $this->is_user();

        $page = 'marketing';
        $data = array(
            'title' => "Data Marketing",
            'page' => $page,
            'data_marketing' => $this->marketing_model->findAll(),
            'kota_model' => $this->kota_model,
            'lokasi_input_model' => $this->lokasi_input_model,
            'customer_model' => $this->customers_model,
            'session' => $this->session
        );
        return view('backoffice/marketing/index_' . $page, $data);
    }

    public function detail(int $id_marketing)
    {
        $this->is_user();

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
        # code...
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
        # code...
    }

    public function delete(int $id_marketing)
    {
        # code...
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
    }

    /**
     * Check is user true or not
     *
     * @return RedirectResponse|bool
     **/
    protected function is_user()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to(base_url());
        }
        if ($this->session->get("user_level") == "1" || $this->session->get('user_level') == "2") {
            return true;
        } else {
            return redirect()->to(base_url());
        }
    }

    public function afiliasi()
    {
        # code...
    }
}
