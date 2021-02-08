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
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\SampleModel;
use App\Models\StatusHasilModel;
use App\Models\TestModel;
use CodeIgniter\RESTful\ResourceController;
// use Dompdf\Cpdf;
use Dompdf\Dompdf;
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
    protected $pemeriksaanModel;
    protected $composer;
    protected $fileLabModel;
    protected $lokasi_input;
    protected $instansi;
    protected $faskes_asal;
    public function __construct()
    {
        $this->codeBarCode = "code128";;
        $this->session = \Config\Services::session();
        $this->dompdf = new Dompdf();
        $this->customer = new CustomerModel();
        $this->laboratoriumModel = new HasilLaboratoriumModel();
        $this->customerC = new Customer;
        $this->sampleModel = new SampleModel();
        $this->dokterModel = new DokterModel();
        $this->petugasModel = new PemeriksaModel();
        $this->statusHasilModel = new StatusHasilModel();
        $this->alatModel = new AlatModel();
        $this->layananTestModel = new LayananTestModel();
        $this->testModel = new TestModel();
        $this->layananModel = new LayananModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->fileLabModel = new FileLabModel();
        $this->lokasi_input = new KotaModel();
        $this->instansi = new InstansiModel();
        $this->faskes_asal = new FaskesModel();
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
        $data = [
            'page' => 'laboratorium',
            'title' => 'Validasi Laboratorium',
            'session' => $this->session,
            'data' => $this->laboratoriumModel->findAll(),
            'status' => $this->statusHasilModel,
            'customer' => $this->customer
            // 'data' => $this->get_data_laboratorium()
        ];
        // dd($this->session->get('nama'));
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

    public function insert_antigen()
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
        $list_status_cov = $this->statusHasilModel->by_jenis_status('status_cov')->get()->getResultArray();
        $list_status_gene = $this->statusHasilModel->by_jenis_status('status_gene')->get()->getResultArray();
        $list_status_orf = $this->statusHasilModel->by_jenis_status('status_orf')->get()->getResultArray();
        $data = array(
            'title' => "Import data",
            'page' => "lab",
            'session' => $this->session
        );
        return view("backoffice/laboratorium/import_excel", $data);
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
        $type = $this->request->getPost("type");
        try {
            if ($type == "import_excel") {
                $fileexcel = $this->request->getFile("excel");
                if ($fileexcel) {
                    $origin_file_name = $fileexcel->getName();
                    // $file = $fileexcel->getExtension;
                    $insert_file = array('file' => $origin_file_name);
                    $insert = $this->fileLabModel->insert($insert_file);
                    $id_file = $this->fileLabModel->getInsertID();
                    // $origin_mime_type = $fileexcel->getExtension;
                    // $date_now = date("dmYHis");
                    // $name = ($this->request->getPost("file_name") == null || $this->request->getPost("file_name") == "") ? $origin_file_name . "-" . $date_now . "." . $origin_mime_type : $this->request->getPost("file_name");
                    // $new_name = $fileexcel->getRandomName();
                    // if ($fileexcel->isValid() && !$fileexcel->hasMoved()) {
                    //     $path = WRITEPATH . "/excels";
                    //     if (!$fileexcel->move($path, $new_name)) {
                    //         $this->session->setFlashdata("error", "Gagal import excel, silahkan import ulang");
                    //         return redirect()->to("/backoffice/laboratorium/import_data");
                    //     }
                    // }
                    $excelReader  = new PHPExcel();
                    //mengambil lokasi temp file
                    $fileLocation = $fileexcel->getTempName();
                    //baca file
                    $objPHPExcel = PHPExcel_IOFactory::load($fileLocation);
                    //ambil sheet active
                    $sheet    = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
                    //looping untuk mengambil data
                    $table = "<table width='100%' border='1'>";
                    $table .= "<thead><tr>";
                    $table .= "<td>Well</td>";
                    $table .= "<td>SampleID</td>";
                    $table .= "<td>Sample</td>";
                    $table .= "<td>SampleType</td>";
                    $table .= "<td>gene</td>";
                    $table .= "<td>Dye</td>";
                    $table .= "<td>ct</td>";
                    $table .= "<td>concentration</td>";
                    $table .= "<td>c_unit</td>";
                    $table .= "<td>standard_c</td>";
                    $table .= "<td>ref_dye</td>";
                    $table .= "<td>unique_ID</td>";
                    $table .= "<td>replicate</td>";
                    $table .= "<td>QC</td>";
                    $table .= "</tr></thead>";
                    $reader_index = 1;
                    $indx = 0;
                    try {
                        // dd($sheet);
                        foreach ($sheet as $idx => $data) {
                            //skip index 1 karena title excel
                            if ($idx == 1) {
                                continue;
                            }
                            // dd($data);
                            $array_insert[$indx] = array();
                            $Well = $data['A'];
                            $SampleID = $data['B'];
                            $Sample = $data['C'];
                            $SampleType = $data['D'];
                            $Dye = $data['E'];
                            $gene = $data['F'];
                            $ct = $data['G'];
                            $concentration = $data['H'];
                            $c_unit = $data['I'];
                            $standard_c = $data['J'];
                            $ref_dye = $data['K'];
                            $unique_ID = $data['L'];
                            $replicate = $data['M'];
                            $QC = $data['N'];
                            $customer = $this->customer->where(['customer_unique' => $SampleID])->get()->getRowArray();
                            // dd($customer);
                            if ($customer != null) {
                                $id_customer = $customer['id'];
                                // echo $reader_index;
                                if ($reader_index == 1) {
                                    // $array_insert[$indx]['id_customer'] 
                                    $this->id_customer = $id_customer;
                                    // $array_insert[$indx]['value_orf'] = 
                                    $this->value_orf = $ct;
                                    // $array_insert[$indx]['status_orf'] 
                                    $this->status_orf = ($ct != "--" || $ct != "") ? 6 : 5;
                                    // print_r($array_insert);
                                } elseif ($reader_index == 2) {
                                    // $array_insert[$indx]['value_n_gene'] 
                                    $this->value_n_gene = $ct;
                                    // $array_insert[$indx]['status_gene'] 
                                    $this->status_gene = ($ct != "--" || $ct != "") ? 4 : 3;
                                    // print_r($array_insert);
                                    // dd($data);
                                } elseif ($reader_index == 3) {
                                    // $array_insert[$indx]['value_ic'] 
                                    $this->value_ic = $ct;
                                    // $array_insert[$indx]['status_pemeriksaan'] 
                                    $this->status_pemeriksaan = "7";
                                    // $array_insert[$indx]['status_kirim'] 
                                    $this->status_kirim = "9";
                                    // $array_insert[$indx]['created_by'] 
                                    $this->created_by = $this->session->get("id_user");
                                    // $array_insert[$indx]['updated_by'] 
                                    $this->updated_by = $this->session->get("id_user");
                                    // $array_insert[$indx]['waktu_ambil_sampling'] 
                                    $this->waktu_ambil_sampling = date("Y-m-d H:i:s");
                                    // $array_insert[$indx]['catatan'] 
                                    $this->catatan = $QC;
                                    // $array_insert[$indx]['has_file'] 
                                    $this->has_file = "yes";
                                    // $array_insert[$indx]['id_file'] 
                                    $this->id_file = $id_file;
                                    // print_r($array_insert);
                                }
                                // dd($array_insert);
                                if ($reader_index == 3) {
                                    $array_insert = array(
                                        'id_customer' => $this->id_customer,
                                        'value_orf' => $this->value_orf,
                                        'status_orf' => $this->status_orf,
                                        'value_n_gene' => $this->value_n_gene,
                                        'status_gene' => $this->status_gene,
                                        'value_ic' => $this->value_ic,
                                        'status_pemeriksaan' => $this->status_pemeriksaan,
                                        'status_kirim' => $this->status_kirim,
                                        'created_by' => $this->created_by,
                                        'updated_by' => $this->updated_by,
                                        'waktu_ambil_sampling' => $this->waktu_ambil_sampling,
                                        'catatan' => $this->catatan,
                                        'has_file' => $this->has_file,
                                        'id_file' => $this->id_file,
                                    );
                                    // print_r($array_insert);
                                    // dd($array_insert);
                                    $this->laboratoriumModel->insert($array_insert);
                                    $indx++;
                                }
                                $reader_index++;
                                if ($reader_index == 4) {
                                    $reader_index = 1;
                                };
                            }


                            $table .= "<tr>";
                            $table .= "<td>" . $Well . "</td>";
                            $table .= "<td>" . $SampleID . "</td>";
                            $table .= "<td>" . $Sample . "</td>";
                            $table .= "<td>" . $SampleType . "</td>";
                            $table .= "<td>" . $gene . "</td>";
                            $table .= "<td>" . $Dye . "</td>";
                            $table .= "<td>" . $ct . "</td>";
                            $table .= "<td>" . $concentration . "</td>";
                            $table .= "<td>" . $c_unit . "</td>";
                            $table .= "<td>" . $standard_c . "</td>";
                            $table .= "<td>" . $ref_dye . "</td>";
                            $table .= "<td>" . $unique_ID . "</td>";
                            $table .= "<td>" . $replicate . "</td>";
                            $table .= "<td>" . $QC . "</td>";
                            $table .= "</tr>";
                        }
                        // exit();
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
            $data_laboratorium = $this->laboratoriumModel->findAll();
            if ($data_laboratorium == null) {
                return $this->failNotFound('Not found');
            }
            $result = array();
            foreach ($data_laboratorium as $key => $value) {
                $detailCustomer = $this->customer->find($value['id_customer']);
                $detailLayananTest = $this->layananTestModel->find($detailCustomer['jenis_test']);
                $detailTest = $this->testModel->find($detailLayananTest['id_test']);
                $detailLayanan = $this->layananModel->find($detailLayananTest['id_layanan']);
                $detailSample = $this->sampleModel->find($value['id_sample']);
                $statusCov = '';
                $statusGene = '';
                $statusOrf = '';
                $statusIgg = '';
                $statusIgm = '';
                $statusKirim = '';
                if ($value['status_cov'] !== null) {
                    $detailHasilCov = $this->statusHasilModel->find($value['status_cov']);
                    $statusCov = ($detailHasilCov['nama_status']) ? $detailHasilCov['nama_status'] : '';
                }
                if ($value['status_gene'] !== null) {
                    $detailHasilGene = $this->statusHasilModel->find($value['status_gene']);
                    $statusGene = ($detailHasilGene['nama_status']) ? $detailHasilGene['nama_status'] : '';
                }
                if ($value['status_orf'] !== null) {
                    $detailHasilOrf = $this->statusHasilModel->find($value['status_orf']);
                    $statusOrf = ($detailHasilOrf['nama_status']) ? $detailHasilOrf['nama_status'] : '';
                }
                if ($value['status_igg'] !== null) {
                    $detailHasilIgg = $this->statusHasilModel->find($value['status_igg']);
                    $statusIgg = ($detailHasilIgg['nama_status']) ? $detailHasilIgg['nama_status'] : '';
                }
                if ($value['status_igm'] !== null) {
                    $detailHasilIgm = $this->statusHasilModel->find($value['status_igm']);
                    $statusIgm = ($detailHasilIgm['nama_status']) ? $detailHasilIgm['nama_status'] : '';
                }
                if ($value['status_kirim'] !== null) {
                    $detailHasilKirim = $this->statusHasilModel->find($value['status_kirim']);
                    $statusKirim = ($detailHasilKirim['nama_status']) ? $detailHasilKirim['nama_status'] : '';
                }
                $ic = $value['detail_ic'];
                $catatan = $value['catatan'];
                $paket_pemeriksaan = $detailTest['nama_test'] . "(" . $detailLayanan['nama_layanan'] . ")";
                $nama_sample = ($value['id_sample'] != null) ? $detailSample['nama_sample'] : '';
                $result[] = array(
                    'id_customer' => $value['id_customer'],
                    'id_hasil' => $value['id'],
                    'tgl_kunjungan' => $detailCustomer['tgl_kunjungan'],
                    'registrasi' => $detailCustomer['customer_unique'] . ' - ' . substr($detailCustomer['created_at'], 0, 10),
                    'paket_pemeriksaan' => $paket_pemeriksaan,
                    'nama_customer' => $detailCustomer['nama'],
                    'nik' => $detailCustomer['nik'],
                    'waktu_sampling' => substr($value['waktu_ambil_sampling'], 0, 10),
                    'waktu_periksa' => substr($value['waktu_periksa_sampling'], 0, 10),
                    'waktu_selesa_periksa' => substr($value['waktu_selesai_periksa'], 0, 10),
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
        $detail_customer = $this->customer->find($id_customer);
        if ($detail_customer == null) {
            $this->session->setFlashdata("error", "customer not found");
        }
        $hasil_lab = $this->laboratoriumModel->where(['id_customer' => $id_customer])->first();
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

    public function print_hasil($id_customer = null, $attachment = 1)
    {
        $customer = $this->customer->detail_customer($id_customer);
        if ($customer == null) {
            echo "peserta tidak ditemukan";
        }
        $invoice_number = $customer['invoice_number'];
        if ($invoice_number == null) {
            echo "Invoice number kosong";
            return false;
        }
        $customer = $this->CustomerModel->get_customer_by_invoice($invoice_number);
        if ($customer == null) {
            echo "Customer tidak ditemukan";
            return false;
        }
        $id_customer = $customer['id'];
        $data_pembayaran = $this->pembayaran_model->where(['id_customer' => $id_customer])->get()->getRowArray();
        $data_layanan_test = db_connect()->table('data_layanan_test')->where('id', $customer['jenis_test'])->limit(1)->get()->getRowArray();
        $data_layanan = db_connect()->table('jenis_layanan')->where('id', $data_layanan_test['id_layanan'])->get()->getRowArray();
        $data_test = db_connect()->table('jenis_test')->where('id', $data_layanan_test['id_test'])->get()->getRowArray();
        $nama_test = $data_test['nama_test'];
        $nama_layanan = $data_layanan['nama_layanan'];

        $nama_paket = $nama_test . " ({$nama_layanan})";
        $nama = $customer['nama'];
        $title = "Invoice {$nama} - {$invoice_number}";
        $data = [
            'title' => $title,
            'page' => "invoice_customer",
            'customer' => $customer,
            'data_pembayaran' => $data_pembayaran,
            'nama_paket' => $nama_paket
        ];
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml(view('backoffice/laboratorium/print_hasil_peserta', $data));
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        // $dompdf->set
        // $dompdf->
        $dompdf->stream($title . ".pdf", ['Attachment' => $attachment]);
    }
}
