<?php

namespace App\Controllers\backoffice;

use App\Controllers\Customer;
use App\Models\AlatModel;
use App\Models\CustomerModel;
use App\Models\DokterModel;
use App\Models\FaskesModel;
use App\Models\FileLabModel;
use App\Models\HasilLaboratoriumModel;
use App\Models\InstansiModel;
use App\Models\KotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
// use App\Models\PembayaranModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\SampleModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use App\Controllers\backoffice\Layanan;
use CodeIgniter\RESTful\ResourceController;
// use Dompdf\Cpdf;
use Dompdf\Dompdf;
use Dompdf\Options;
use PHPExcel;
use PHPExcel_IOFactory;

// use App\Controllers;
// use CodeIgniter\Controller;

class Laboratorium extends ResourceController
{
    /**
     * Excel parameter
     */
    protected $id_customer;
    protected $value_orf;
    protected $status_orf;
    protected $value_n_gene;
    protected $status_gene;
    protected $value_ic;
    protected $status_pemeriksaan;
    protected $status_kirim;
    protected $created_by;
    protected $updated_by;
    protected $waktu_ambil_sampling;
    protected $catatan;
    protected $has_file;
    protected $id_file;

    public $session;
    public $codeBarCode;
    public $dompdf;
    public $pdf;
    public $laboratoriumModel;
    protected $customer;
    protected $customerC;
    protected $sampleModel;
    protected $dokterModel;
    protected $petugasModel;
    protected $statusHasilModel;
    protected $alatModel;
    protected $layananTestModel;
    protected $testModel;
    protected $layananModel;
    protected $composer;
    protected $fileLabModel;
    protected $lokasi_input;
    protected $instansi;
    protected $faskes_asal;
    public function __construct()
    {
        $this->codeBarCode = "code128";;
        $this->session = \Config\Services::session();

        $this->customer = new CustomerModel();
        $this->laboratoriumModel = new HasilLaboratoriumModel();
        $this->customerC = new Customer;
        $this->sampleModel = new SampleModel();
        $this->dokterModel = new DokterModel();
        $this->petugasModel = new PemeriksaModel();
        $this->statusHasilModel = new StatusHasilModel();
        $this->alatModel = new AlatModel();

        helper('form');
        // $this->sampleModel;
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        // dd($this->session->get('nama'));
        return view('backoffice/layanan/index');
    }

    public function validasi()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $db_file_lab = db_connect()->table('data_file_lab');
        $filtering = ($this->request->getPost('filtering')) ? $this->request->getPost('filtering') : "";
        if ($filtering == "on") {
            $id_file = $this->request->getPost('id_file');
            $data_customer_lab = $this->laboratoriumModel->by_file_id($id_file);
        } else {
            $data_customer_lab = null;
        }
        $data_file_lab = $db_file_lab->orderBy('id', 'DESC')->get()->getResultArray();
        // dd($data_customer_lab);
        $data = [
            'page' => 'laboratorium',
            'title' => 'Validasi Laboratorium',
            'session' => $this->session,
            'status' => $this->statusHasilModel,
            'data_import' => $data_file_lab,
            'customer_model' => $this->customer,
            'data_customer_lab' => $data_customer_lab
        ];
        return view('backoffice/laboratorium/validasi', $data);
    }

    public function hasil()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = [
            'page' => 'laboratorium',
            'title' => 'Hasil Laboratorium',
            'session' => $this->session,
            // 'data' => $this->get_data_laboratorium()
        ];
        // dd($this->session->get('nama'));
        return view('backoffice/laboratorium/index_laboratorium', $data);
    }

    public function import_data()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $user_level = $this->session->get("user_level");
        $level = array(1, 6, 7, 8, 99);
        // in_array($level);
        if (!in_array($user_level, $level)) {
            $this->session->setFlashdata("error", "Anda tidak mempunyai akses");;
            return redirect()->to("/backoffice/login");
        }
        $data = array(
            'title' => "Import data",
            'page' => "lab",
            'session' => $this->session
        );
        return view("backoffice/laboratorium/import_excel", $data);
    }

    public function data_peserta_antigen()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $filtering = ($this->request->getPost("filtering")) ? $this->request->getPost("filtering") : "";
        if ($filtering == "on") {
            $date1 = ($this->request->getPost("date1")) ? $this->request->getPost("date1") : false;
            $date2 = ($this->request->getPost("date2")) ? $this->request->getPost("date2") : false;
        } else {
            $date1 = date("Y-m-d");
            $date2 = false;
        }
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $data_layanan = $this->layananTestModel->where(['id_test' => 3])->get()->getResultArray();
        $ids_jenis_test = array();
        foreach ($data_layanan as $dataL => $val) {
            $ids_jenis_test[] = $val['id'];
        }
        $peserta = array();
        $filter_tgl = ($date2) ? "and customers.tgl_kunjungan between '{$date1}' and '{$date2}'" : "and customers.tgl_kunjungan = '{$date1}'";
        $data_list_peserta_antigen = db_connect()->query("SELECT customers.* FROM `hasil_laboratorium` 
        join customers on customers.id = hasil_laboratorium.id_customer 
        where hasil_laboratorium.valid = 'no' 
        and customers.jenis_test IN (SELECT id from data_layanan_test where id_test = 3) {$filter_tgl}")->getResultArray();
        // echo db_connect()->showLastQuery();

        // dd(db_connect()->showLastQuery());
        $data = array(
            'title' => "Peserta Antigen",
            'page' => "lab",
            'session' => $this->session,
            'data_peserta_antigen' => $data_list_peserta_antigen,
            'layanan_test_model' => $this->layananTestModel,
            'layanan_model' => $this->layananModel,
            'test_model' => $this->testModel,
        );
        return view("backoffice/laboratorium/peserta_antigen", $data);
    }

    public function data_peserta_rapid()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $filtering = ($this->request->getPost("filtering")) ? $this->request->getPost("filtering") : "";
        if ($filtering == "on") {
            $date1 = ($this->request->getPost("date1")) ? $this->request->getPost("date1") : false;
            $date2 = ($this->request->getPost("date2")) ? $this->request->getPost("date2") : false;
        } else {
            $date1 = date("Y-m-d");
            $date2 = false;
        }

        $data_layanan = $this->layananTestModel->where(['id_test' => 2])->get()->getResultArray();
        $ids_jenis_test = array();
        foreach ($data_layanan as $dataL => $val) {
            $ids_jenis_test[] = $val['id'];
        }
        $peserta = array();
        $filter_tgl = ($date2) ? "a.tgl_kunjungan between {$date1} and {$date2}" : $date1;
        $data_list_peserta_antigen = $this->customer->deep_detail_by_id(null, ['jenis_test' => $ids_jenis_test, 'tgl_kunjungan' => $filter_tgl])->getResultArray();
        // dd(db_connect()->showLastQuery());
        foreach ($data_list_peserta_antigen as $key => $v) {
            $data_lab = $this->laboratoriumModel->where(['id_customer' => $v['id'], 'valid' => "no"])->get()->getRowArray();
            if ($data_lab != null) {
                $peserta[] = array(
                    'id' => $v['id'],
                    'tgl_kunjungan' => $v['tgl_kunjungan'],
                    'customer_unique' => $v['customer_unique'],
                    'nik' => $v['nik'],
                    'nama' => $v['nama'],
                    'created_at' => $v['created_at']
                );
            }
        }


        $data = array(
            'title' => "Peserta Rapid Test",
            'page' => "lab",
            'session' => $this->session,
            'data_peserta_antigen' => $peserta,
            'layanan_test_model' => $this->layananTestModel,
            'layanan_model' => $this->layananModel,
            'test_model' => $this->testModel,
        );
        return view("backoffice/laboratorium/peserta_rapid", $data);
    }

    protected function filtering_rapid_antigen()
    {
    }

    public function verifikasi_peserta($id_customer = null)
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $detail_hasil_lab = $this->laboratoriumModel->by_id_customer($id_customer);
        dd(db_connect()->showLastQuery());
        if ($detail_hasil_lab == null) {
            $detail_customer = $this->customer->detail_customer($id_customer);
            if ($detail_customer) {
                $insert_hasil_kosongan = [
                    'valid' => "no",
                    'id_customer' => $id_customer,
                    'created_by' => $this->session->get('id_user'),
                    'updated_by' => $this->session->get('id_user')
                ];
                $this->laboratoriumModel->insert($insert_hasil_kosongan);
                $id = $this->laboratoriumModel->getInsertID();
                $detail_hasil_lab = $this->laboratoriumModel->by_id_customer($id_customer);
            }
        }
        $detail_customer = $this->customer->detail_customer($id_customer);
        $id_layanan_test = $detail_customer['jenis_test'];
        $detail_layanan_test = $this->layananTestModel->find($id_layanan_test);
        $id_test = $detail_layanan_test['id_test'];
        $nama = $detail_customer['nama'];
        $data = array(
            'title' => "Validasi Peserta Antigen - " . $nama,
            'page' => "lab",
            'session' => $this->session,
            'detail_customer' => $detail_customer,
            'layanan_test_model' => $this->layananTestModel,
            'layanan_model' => $this->layananModel,
            'test_model' => $this->testModel,
            'id_test' => $id_test,
            'detail_hasil_lab' => $detail_hasil_lab,
            'status_hasil' => ['val' => 'Negative', 'val' => 'Positive'],
            'status_ngene' => ['val' => 'Negative', 'val' => 'Positive'],
            'status_orf' => ['val' => 'Negative', 'val' => 'Positive'],
            'status_gene_n' => ['val' => 'Negative', 'val' => 'Positive'],
        );
        return view("backoffice/laboratorium/verifikasi_peserta", $data);
    }

    public function save_verifikasi()
    {
        $status_result = $this->request->getPost("result");
        $status_n_gene = $this->request->getPost("status_gene");
        $status_orf = $this->request->getPost("status_orf");
        $nilai_ic = $this->request->getPost("nilai_ic");

        $gene_orf = $this->request->getPost("gene_orf");
        $nilai_ct_orf = $this->request->getPost("nilai_ct_orf");

        $gene_hex_n = $this->request->getPost("gene_hex_n");
        $nilai_ct_hex_n = $this->request->getPost("nilai_ct_hex_n");

        $nilai_ic = $this->request->getPost("nilai_ic");
        $id = $this->request->getPost("id");
        $id_dokter = $this->session->get('id_user');
        $update_data_verifikasi = [
            'status_cov' => $status_result,
            'status_gene' => $status_n_gene,
            'value_ic' => $nilai_ic,
            'value_orf' => $nilai_ct_orf,
            'value_n_gene' => $nilai_ct_hex_n,
            'status_orf' => $status_orf,
            'valid' => "yes",
            'updated_by' => $this->session->get('id_user')
        ];
        $update = $this->laboratoriumModel->update($id, $update_data_verifikasi);
        if ($update) {
            $this->session->setFlashdata("success", "Berhasil validasi peserta");
            return redirect()->to("/backoffice/laboratorium/validasi");
        } else {
            $this->session->setFlashdata("error", "Gagal validasi peserta");
            return redirect()->back();
        }
    }


    public function save()
    {
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $user_level = $this->session->get("user_level");
        $level = array(1, 6, 7, 8, 99);
        // in_array($level);
        if (!in_array($user_level, $level)) {
            $this->session->setFlashdata("error", "Anda tidak mempunyai akses");;
            return redirect()->to("/backoffice/login");
        }
        $this->fileLabModel = new FileLabModel();
        $type = $this->request->getPost("type");
        try {
            if ($type == "import_excel") {
                $fileexcel = $this->request->getFile("excel");
                if ($fileexcel) {
                    $origin_file_name = $fileexcel->getName();
                    $fileLocation = $fileexcel->getTempName();
                    // $file = $fileexcel->getExtension;
                    $insert_file = array('file' => $origin_file_name);
                    $insert = $this->fileLabModel->insert($insert_file);
                    $id_file = $this->fileLabModel->getInsertID();

                    $excelReader  = new PHPExcel();

                    $objPHPExcel = PHPExcel_IOFactory::load($fileLocation);
                    //ambil sheet active
                    $sheet    = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

                    $reader_index = 1;
                    $indx = 0;
                    try {
                        // dd($sheet);
                        foreach ($sheet as $idx => $data) {
                            $status_ins = false;
                            //skip index 1 karena title excel
                            if ($idx < 9) {
                                continue;
                            }
                            // dd($data);
                            $array_insert[$indx] = array();
                            $Well = $data['A'];
                            $SampleID = $data['D'];
                            $Sample = $data['C'];
                            $SampleType = $data['E'];
                            $SamplingDate = $data['G'];
                            $SubmittingDate = $data['H'];
                            $ReportingDate = $data['I'];
                            $FamCt = $data['J'];
                            $StatusORF = $data['K'];
                            $HexCt = $data['L'];
                            $status_gene = $data['M'];
                            $Cy5Ct = $data['N']; // IC
                            $StatusIc = $data['O'];
                            $statusCov = $data['P'];
                            $flag = $data['Q'];

                            $customer = $this->customer->get_by_customer_unique($SampleID);
                            if ($customer == null) {
                                $this->session->setFlashdata('error', 'peserta tidak ditemukan pada sample id ' . $SampleID);
                            } else {
                                $status_ins = true;
                            }
                            if ($status_ins) {
                                $created_by = $this->session->get('id_user');
                                $updated_by = $this->session->get("id_user");
                                $id_customer = $customer['id'];
                                $array_insert = array(
                                    'well' => $Well,
                                    'id_customer' => $id_customer,
                                    'status_cov' => $statusCov,
                                    'value_orf' => $FamCt,
                                    'status_orf' => $StatusORF,
                                    'value_n_gene' => $HexCt,
                                    'status_gene' => $status_gene,
                                    'value_ic' => $Cy5Ct,
                                    'status_ic' => $StatusIc,
                                    'status_pemeriksaan' => 7,
                                    'status_kirim' => 9,
                                    'created_by' => $created_by,
                                    'updated_by' => $updated_by,
                                    'waktu_ambil_sampling' => $this->waktu_ambil_sampling,
                                    'catatan' => $flag,
                                    'has_file' => "yes",
                                    'id_file' => $id_file,
                                    'waktu_ambil_sampling' => $SamplingDate,
                                    'waktu_periksa_sampling' => $SubmittingDate,
                                    'waktu_selesai_periksa' => $ReportingDate,
                                );
                                // print_r($array_insert);
                                // dd($array_insert);
                                $this->laboratoriumModel->insert($array_insert);
                            }
                        }
                        // exit();
                        $fileexcel->move(ROOTPATH . 'public/assets/excels_lab/', $origin_file_name);
                        $this->session->setFlashdata("success", "Berhasil Upload excel");
                        return redirect()->to("/backoffice/laboratorium/hasil");
                    } catch (\Throwable $th) {
                        $this->session->setFlashdata("error", "Gagal Upload excel {$th->getMessage()} {$th->getFile()} {$th->getCode()} {$th->getLine()} ");
                        return redirect()->to("/backoffice/laboratorium/import_data");
                    }
                    // echo $table;

                }
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata("error", "Gagal Upload excel {$th->getMessage()} {$th->getFile()} {$th->getCode()} {$th->getLine()} ");
            return redirect()->to("/backoffice/laboratorium/import_data");
        }
    }

    public function get_data_laboratorium()
    {
        try {
            $data_laboratorium = $this->laboratoriumModel->by_valid("yes");
            // return db_connect()->showLastQuery();
            if ($data_laboratorium == null) {
                return $this->failNotFound('Not found');
            }
            $this->layananModel = new LayananModel();
            $this->testModel = new TestModel();
            $this->layananTestModel = new LayananTestModel();
            $result = array();
            foreach ($data_laboratorium as $key => $value) {
                $detailCustomer = $this->customer->deep_detail_by_id($value['id_customer'])->getRowArray();
                $detailLayananTest = $this->layananTestModel->find($detailCustomer['jenis_test']);
                $detailTest = $this->testModel->find($detailLayananTest['id_test']);
                $detailLayanan = $this->layananModel->find($detailLayananTest['id_layanan']);
                $detailSample = $this->sampleModel->find($value['id_sample']);
                $statusCov = ($value['status_cov'] != null) ? $value['status_cov'] : "";
                $statusGene = ($value['status_gene'] != null) ? $value['status_gene'] : "";
                $statusOrf = ($value['status_orf'] != null) ? $value['status_orf'] : "";
                $statusIgg = ($value['status_igg'] != null) ? $value['status_igg'] : "";
                $statusIgm = ($value['status_igm'] != null) ? $value['status_igm'] : "";
                $statusKirim = '';


                if ($value['status_kirim'] !== null) {
                    $detailHasilKirim = $this->statusHasilModel->find($value['status_kirim']);
                    $statusKirim = ($detailHasilKirim['nama_status']) ? $detailHasilKirim['nama_status'] : '';
                }
                $ic = ($value['value_ic'] != null) ? $value['value_ic'] : "";
                $catatan = ($value['catatan'] != null) ? $value['catatan'] : "";
                $paket_pemeriksaan = $detailTest['nama_test'] . "(" . $detailLayanan['nama_layanan'] . ")";
                $nama_sample = ($value['id_sample'] != null) ? $detailSample['nama_sample'] : '';
                $new_date_created = date("d F, Y", strtotime(substr($detailCustomer['created_at'], 0, 10)));
                $tgl_kunjungan = date("d F Y", strtotime($detailCustomer['tgl_kunjungan']));
                $result[] = array(
                    'id_customer' => $value['id_customer'],
                    'id_hasil' => $value['id'],
                    'tgl_kunjungan' => $tgl_kunjungan,
                    'registrasi' => $detailCustomer['customer_unique'] . '  -<br>' . $new_date_created,
                    'paket_pemeriksaan' => $paket_pemeriksaan,
                    'nama_customer' => $detailCustomer['nama'],
                    'nik' => $detailCustomer['nik'],
                    'waktu_sampling' => $value['waktu_ambil_sampling'],
                    'waktu_periksa' => $value['waktu_periksa_sampling'],
                    'waktu_selesa_periksa' => $value['waktu_selesai_periksa'],
                    'status_cov' => $statusCov,
                    'status_gene' => $statusGene,
                    'status_orf' => $statusOrf,
                    'status_igg' => $statusIgg,
                    'status_igm' => $statusIgm,
                    'ic' => $ic,
                    'nama_sample' => $nama_sample,
                    'catatan' => $catatan,
                    'status_kirim' => $statusKirim
                );
            }
            return $this->respond(array('data' => $result), 200, 'success');
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError($th->getMessage() . ' ' . $th->getCode() . ' ' . $th->getLine());
        }
    }


    public function input($id_customer)
    {
        $detail_customer = $this->customer->deep_detail_by_id($id_customer)->getRowArray();
        if ($detail_customer == null) {
            $this->session->setFlashdata("error", "customer not found");
        }
        $this->layananModel = new LayananModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->lokasi_input = new KotaModel();
        $this->instansi = new InstansiModel();
        $this->faskes_asal = new FaskesModel();
        $hasil_lab = $this->laboratoriumModel->by_id_customer($id_customer);
        // dd($hasil_lab);
        $layanan_test = $this->layananTestModel->find($detail_customer['jenis_test']);
        $new_reg = date_create($detail_customer['created_at']);
        $tgl_registrasi = date_format($new_reg, "Y-m-d");
        $data = array(
            'customer' => $detail_customer,
            'title' => "Input customer",
            'page' => "laboratorium",
            'detail_hasil' => $hasil_lab,
            'layanan_test' => $layanan_test,
            'jenis_pemeriksaan' => $this->layananModel->findAll(),
            'test' => $this->testModel->findAll(),
            'jenis_sample' => $this->sampleModel->findAll(),
            'status' => $this->statusHasilModel,
            'dokter' => $this->dokterModel->findAll(),
            'petugas' => $this->petugasModel->findAll(),
            'lokasi' => $this->lokasi_input->findAll(),
            'instansi' => $this->instansi->findAll(),
            'faskes' => $this->faskes_asal->findAll(),
            'alat' => $this->alatModel->findAll(),
            'id' => $hasil_lab['id'],
            'session' => $this->session,
            'tgl_registrasi' => $tgl_registrasi
        );
        return view("backoffice/laboratorium/input_data", $data);
    }

    public function print_hasil($id_customer = null)
    {
        $kota_model = new KotaModel();
        $hasil_lab_model = new HasilLaboratoriumModel();
        $this->faskes_asal = new FaskesModel();
        $this->dompdf = new Dompdf();
        $customer = $this->customer->deep_detail_by_id($id_customer)->getRowArray();
        // dd(db_connect()->showLastQuery());
        if ($customer == null) {
            echo "peserta tidak ditemukan";
        }
        $invoice_number = $customer['invoice_number'];
        if ($invoice_number == null) {
            echo "Invoice number kosong";
            return false;
        }
        $id_faskes = $customer['faskes_asal'];
        $order_id = $customer['customer_unique'];
        $faskes = $this->faskes_asal->find($id_faskes);
        // dd(db_connect()->showLastQuery());
        if ($faskes == null) {
            echo "Faskes peserta tidak terdaftar";
            return false;
        }
        $nama_faskes = $faskes['nama_faskes'];

        $id_kota = $faskes['kota'];
        $kota = $kota_model->find($id_kota);
        $nama_kota = $kota['nama_kota'];
        $city = $kota['city'];
        $province = $kota['province'];


        $detail_hasil = $hasil_lab_model->by_id_customer($id_customer);
        // dd(db_connect()->showLastQuery());
        $id_customer = $customer['id'];
        $id_test = $customer['id_test'];
        $nama_test = $customer['nama_test'];
        $nama_layanan = $customer['nama_layanan'];

        $nama_paket = $nama_test . " ({$nama_layanan})";
        $nama = $customer['nama'];
        $title = "Hasil_Test_{$nama_test}_{$nama}_{$order_id}";
        $layanan = new Layanan;
        // $get_qr = $layanan->getUrlQRCode(base_url('api/get_hasil_lab/'. $id_customer));
        $size = "100x100";
        $layanan->put_content_qr_code(base_url('api/get_hasil_lab/' . $id_customer), $title, $size);

        $url_qr_code = base_url("assets/qr/{$title}{$size}.png");
        // $type = pathinfo($url_qr_code, PATHINFO_EXTENSION);
        // $file_qr = file_get_contents($url_qr_code);
        // $qr_file_hasil = "data:image/{$type};base64," .  base64_encode($file_qr);

        $waktu_selesai_periksa = $detail_hasil['waktu_selesai_periksa'];
        $str_waktu_selesai = strtotime($waktu_selesai_periksa);
        $sign_waktu = date("d F, Y", $str_waktu_selesai);
        $id_dokter =  $detail_hasil['id_dokter'];
        $dokter = $this->dokterModel->find($id_dokter);
        $doctor_name =  $dokter['nama'];
        $new_ambil = date("d F, Y", strtotime($detail_hasil['waktu_ambil_sampling']));
        $new_periksa = date("d F, Y", strtotime($detail_hasil['waktu_periksa_sampling']));
        $new_selesai = date("d F, Y", strtotime($detail_hasil['waktu_selesai_periksa']));
        $data = [
            'title' => $title,
            'page' => "laboratorium",
            'customer' => $customer,
            'nama_paket' => $nama_paket,
            'detail_hasil' => $detail_hasil,
            'city' => $city,
            'province' => $province,
            'nama_faskes' => $nama_faskes,
            'image_qr_result' => $url_qr_code,
            'sign_waktu' => $sign_waktu,
            'doctor_name' => $doctor_name,
            'new_date_ambil' => $new_ambil,
            'new_date_periksa' => $new_periksa,
            'new_date_selesai' => $new_selesai
        ];
        /**
         * Set DOMPDF Options
         */
        $Option = new Options();
        $Option->setIsRemoteEnabled(true);
        // $Option->setIsHtml5ParserEnabled(true);
        // $Option->setDebugCss(true);
        // $Option->setIsJavascriptEnabled(true);
        // $Option->setIsPhpEnabled(true);

        $dompdf = new Dompdf($Option);
        $contxt = stream_context_create([
            'ssl' => [
                'verify_peer' => FALSE,
                'verify_peer_name' => FALSE,
                'allow_self_signed' => TRUE
            ]
        ]);
        $dompdf->setHttpContext($contxt);
        if ($id_test == 1) {
            // return view('backoffice/laboratorium/print_hasil_peserta', $data);
            $dompdf->loadHtml(view('backoffice/laboratorium/print_hasil_peserta', $data));
        } else {
            // return view('backoffice/laboratorium/print_hasil_pesertav2', $data);
            $dompdf->loadHtml(view('backoffice/laboratorium/print_hasil_pesertav2', $data));
        }

        $dompdf->setPaper('A4', 'portrait');
        // $dompdf->output();
        $dompdf->render();
        $this->response->setHeader('Content-type', "application/pdf");
        $dompdf->stream($title . ".pdf", ['Attachment' => 0]);
    }

    public function send_hasil_peserta($id_customer = null)
    {
        try {
            $customer = $this->customer->deep_detail_by_id($id_customer)->getRowArray();
            if ($customer == null || $id_customer == null) {
                $this->session->setFlashdata("error", "Peserta Tidak Ditemukan");
                return redirect()->to("/backoffice/laboratorium/hasil");
                // echo "Peserta Tidak Ditemukan";
                // return false;
            }
            $send_email = $this->sendEmailCustomer($customer);
            $send_whatsapp = $this->send_whatsapp($customer);
            if ($send_email && $send_whatsapp) {
                $hasil = new HasilLaboratoriumModel();
                $detail_hasil = $hasil->by_id_customer($customer['id']);
                $id_hasil = $detail_hasil['id'];
                $updated_by = $this->session->get('id_user');
                $array_update = [
                    'status_kirim' => 10,
                    'updated_by' => $updated_by
                ];
                $update = $hasil->update($id_hasil, $array_update);
                if ($update) {
                    $this->session->setFlashdata('success', 'Berhasil Kirim hasil test kepada peserta ' . $customer['nama']);
                } else {
                    $this->session->setFlashdata('error', "Gagal Update hasil test");
                }
            } else {
                $this->session->setFlashdata('error', "Gagal Kirim hasil test");
            }
            return redirect()->to('/backoffice/laboratorium/input/' . $id_customer);
        } catch (\Throwable $th) {
            //throw $th;
            $this->session->setFlashdata('error', "Gagal Kirim hasil test karena " . $th->getMessage());
            return redirect()->to('/backoffice/laboratorium/input/' . $id_customer);
        }
    }

    /**
     * Send email to customer user 
     * 
     */
    protected function sendEmailCustomer($customer)
    {
        # code...

        $Layanan = new Layanan;
        $this->faskes_asal = new FaskesModel();
        $Email = \Config\Services::email();

        // $Email->initialize($config);

        $emailCustomer = $customer['email'];
        $id_customer = $customer['id'];
        $nama_customer = $customer['nama'];
        $invoice_number = $customer['invoice_number'];
        $order_id = $customer['customer_unique'];

        $id_customer = $customer['id'];
        $invoice_number = $customer['invoice_number'];
        if ($invoice_number == null) {
            echo "Invoice number kosong";
            return false;
        }
        $id_faskes = $customer['faskes_asal'];
        $faskes = $this->faskes_asal->find($id_faskes);
        // dd(db_connect()->showLastQuery());
        if ($faskes == null) {
            echo "Faskes peserta tidak terdaftar";
            return false;
        }
        $nama_faskes = $faskes['nama_faskes'];
        $kota_model = new KotaModel();
        $id_kota = $faskes['kota'];
        $kota = $kota_model->find($id_kota);
        $nama_kota = $kota['nama_kota'];
        $city = $kota['city'];
        $province = $kota['province'];
        $hasil_lab_model = new HasilLaboratoriumModel();
        $detail_hasil = $hasil_lab_model->by_id_customer($id_customer);
        // dd(db_connect()->showLastQuery());
        $id_customer = $customer['id'];
        $id_test = $customer['id_test'];
        $nama_test = $customer['nama_test'];
        $nama_layanan = $customer['nama_layanan'];

        $nama_paket = $nama_test . " ({$nama_layanan})";
        $nama = $customer['nama'];
        $title = "Hasil_Test_{$nama_test}_{$nama}";
        $data = [
            'title' => $title,
            'page' => "invoice_customer",
            'customer' => $customer,
            'nama_paket' => $nama_paket,
            'detail_hasil' => $detail_hasil,
            'city' => $city,
            'province' => $province,
            'nama_faskes' => $nama_faskes
        ];

        $Layanan = new Layanan;
        $url_pdf = base_url("api/get_hasil/lab" . $id_customer);
        $name_pdf = "Hasil_Test_{$nama_test}_{$nama}_{$order_id}";
        $Layanan->put_content_pdf($url_pdf, $name_pdf);
        $file_pdf = base_url("assets/pdf/{$name_pdf}.pdf");

        // file_get
        if ($id_test == 1) {
            $emailMessage = view('backoffice/laboratorium/email_hasil', $data);
        } else {
            $emailMessage = view('backoffice/laboratorium/email_hasilv2', $data);
        }


        $Email->setTo($emailCustomer);
        $Email->setFrom('pendaftaran@quicktest.id', 'Pendaftaran QuickTest.id');
        $Email->setSubject($title);
        $Email->setMessage($emailMessage);
        $Email->attach(
            $file_pdf,
            'inline',
            $name_pdf . ".pdf",
            "application/pdf"
        );
        if ($Email->send()) {
            return true;
        } else {
            $data = $Email->printDebugger(['headers']);
            print_r($data);
        }
    }

    protected function send_whatsapp($customer)
    {
        $whatsapp_service = new Whatsapp_service;
        $whatsapp_service->send_hasil_test($customer);
    }
}
