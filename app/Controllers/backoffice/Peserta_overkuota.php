<?php

namespace App\Controllers\backoffice;

use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\TestModel;
use App\Controllers\BaseController;
use Dompdf\Cpdf;
use App\Controllers\backoffice\Peserta;
use App\Controllers\Customer;
use App\Models\CustomerHomeServiceModel;
use App\Models\CustomerModel;
use App\Models\CustomerOverloadModel;
use App\Models\FaskesModel;
use App\Models\HasilLaboratoriumModel;
use App\Models\InstansiModel;
use App\Models\MarketingModel;
use App\Models\PembayaranModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\StatusHasilModel;
use App\Models\UserDetailModel;
use App\Models\UserModel;

// use App\Controllers;
// use CodeIgniter\Controller;

class Peserta_overkuota extends BaseController
{
    public $session;
    public $customerModel;
    public $dokterModel;
    public $jenisPemeriksaanModel;
    public $faskesModel;
    public $instansiModel;
    public $marketingModel;
    public $layananTestModel;
    public $testModel;
    public $layananModel;
    public $pemeriksaModel;
    public $customerPublic;
    public $statusHadir;
    protected $pembayaran_model;
    protected $hasil_lab;
    protected $customer_overload;
    protected $home_service_model;
    protected $user_model;
    protected $detail_user_model;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->customerModel = new CustomerModel();
        $this->pemeriksaModel = new PemeriksaModel();
        $this->jenisPemeriksaanModel = new PemeriksaanModel();
        $this->faskesModel = new FaskesModel();
        $this->instansiModel = new InstansiModel();
        $this->marketingModel = new MarketingModel();
        $this->layananTestModel = new LayananTestModel();
        $this->testModel = new TestModel();
        $this->layananModel = new LayananModel();
        $this->customerPublic = new Customer;
        $this->statusHadir = new StatusHasilModel();
        $this->pembayaran_model = new PembayaranModel();
        $this->hasil_lab = new HasilLaboratoriumModel();
        $this->customer_overload = new CustomerOverloadModel();
        $this->home_service_model = new CustomerHomeServiceModel();
        $this->user_model = new UserModel();
        $this->detail_user_model = new UserDetailModel();
        $layanan = new Layanan;
    }
    public function index()
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if ($user_level == 1 || $user_level == 100) {
        } else {
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        }
        $dataPemeriksa = $this->pemeriksaModel->findAll();
        // dd($dataPemeriksa);
        $dataJenisPemeriksaan = $this->jenisPemeriksaanModel->findAll();
        $dataFaskes = $this->faskesModel->findAll();
        $dataInstanasi = $this->instansiModel->findAll();
        $dataMarketing = $this->marketingModel->findAll();

        $kondisi_layanan_test = ['id_segmen' => "1", 'id_pemeriksaan' => "1"];
        $dataLayananTest = $this->layananTestModel->where($kondisi_layanan_test)->get()->getResultArray();
        $data = array(
            'title' => "Form Registrasi Peserta Overload",
            'page' => "registrasi_overload",
            'session' => session(),
            'pemeriksa' => $dataPemeriksa,
            'jenis_pemeriksaan' => $dataJenisPemeriksaan,
            'faskes' => $dataFaskes,
            'instansi' => $dataInstanasi,
            'marketing' => $dataMarketing,
            'data_layanan_test' => $dataLayananTest,
            'testModel' => $this->testModel,
            'layananModel' => $this->layananModel,
            'status_peserta' => 21,
            'validation' => \Config\Services::validation()
        );
        return view('backoffice/peserta/create_peserta', $data);
    }

    public function save()
    {
        if (!$this->session->has("logged_in")) {
            $this->session->setFlashData("error", "Anda harus login");
            return redirect()->to("/backoffice/login");
        }
        $user_level = intval($this->session->get("user_level"));
        if ($user_level == 1 || $user_level == 100) {
        } else {
            $this->session->setFlashData("error", "Anda tidak memiliki akses");
            return redirect()->to("/backoffice/login");
        }
        // $validation =  \Config\Services::validation();


        $nama = $this->request->getPost('nama');
        $nik = $this->request->getPost('nik');
        $phone = $this->request->getPost('phone');
        $phone = str_replace(' ', '', $phone);
        $phone = str_replace('+62', '0', $phone);
        $email = $this->request->getPost('email');
        $jenis_kelamin = $this->request->getPost('jenis_kelamin');
        $tempat_lahir = $this->request->getPost('tempat_lahir');
        $tgl_lahir = $this->request->getPost('tgl_lahir');
        $alamat = $this->request->getPost('alamat');
        $id_marketing = $this->request->getPost('id_marketing');
        $layanan_test = $this->request->getPost('layanan_test');

        $detail_layanan_test = $this->layananTestModel->find($layanan_test);
        $id_test = $detail_layanan_test['id_test'];
        $id_layanan = $detail_layanan_test['id_layanan'];
        $id_pemeriksaan = $detail_layanan_test['id_pemeriksaan'];
        $jenis_pemeriksaan = $this->request->getPost('jenis_pemeriksaan');

        $jenis_layanan = $this->request->getPost('jenis_layanan');
        $faskes_asal = $this->request->getPost('faskes_asal');
        $instansi = $this->request->getPost('instansi');
        $kehadiran = 22;
        $tgl_kunjungan = $this->request->getPost('tgl_kunjungan');
        $id_jam_kunjungan = $this->request->getPost('jam_kunjungan');
        $dataJamKunjungan = $this->customerPublic->kuotaModel->find($id_jam_kunjungan);
        $jam_kunjungan = $dataJamKunjungan['jam'];
        $status_pembayaran = $this->request->getPost('status_pembayaran');
        $pemeriksa = $this->request->getPost('nama_pemeriksa');
        // var_dump($this->request->getPost());
        // exit();
        $customer_UNIQUE = $this->customerPublic->getOrderId($layanan_test, $id_pemeriksaan, $tgl_kunjungan, $id_layanan, $jam_kunjungan);
        // echo db_connect()->showLastQuery();
        // exit();
        // dd($customer_UNIQUE);
        try {
            $Layanan = new Layanan();
            $dataLayanan = $this->layananModel->find($jenis_layanan);
            $dataTest = $this->testModel->find($layanan_test);
            $amount_test = intval($dataTest['biaya']);
            $no_urutan = $this->customerPublic->getUrutan($layanan_test, $tgl_kunjungan, $id_pemeriksaan, $id_layanan);
            // echo "Urutan : " . $no_urutan;
            $status_peserta = $this->request->getPost('status_peserta');
            // var_dump($data);
            $DataInsertCustomer = [
                'nama' => $nama,
                'email' => $email,
                'nik' => $nik,
                'phone' => $phone,
                'pemeriksa' => $pemeriksa,
                'jenis_test' => $layanan_test,
                'jenis_pemeriksaan' => $id_pemeriksaan,
                'jenis_layanan' => $id_layanan,
                'faskes_asal' => $faskes_asal,
                'customer_unique' => $customer_UNIQUE,
                'jenis_kelamin' => $jenis_kelamin,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tgl_lahir,
                'alamat' => $alamat,
                'id_marketing' => $id_marketing,
                'instansi' => $instansi,
                'status_test' => '',
                'tahap' => 1,
                'kehadiran' => $kehadiran,
                'no_antrian' => $no_urutan,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => $status_pembayaran,
                'status_peserta' => $status_peserta,
            ];
            $insert = $this->customerModel->insert($DataInsertCustomer);
            $insert_id = null;
            if ($insert) {
                $insert_id = $this->customerModel->getInsertID();
                $InvoiceCustomer = $this->customerPublic->getInvoiceNumber($insert_id);

                $this->customerModel->update($insert_id, ['invoice_number' => $InvoiceCustomer]);


                /**
                 * jika status peserta adalah overload, insert data ke customer overload juga
                 */
                if ($status_peserta == 21) {

                    $DataInsertCustomer['id_customer'] = $insert_id;
                    $DataInsertCustomer['invoice_number'] = $InvoiceCustomer;
                    $this->customer_overload->insert($DataInsertCustomer);
                    $insert_overload_id = $this->customer_overload->getInsertID();
                }
            } else {
                $this->session->setFlashdata("error", "Gagal menyimpan");
                return redirect()->to("/backoffice/peserta/create");
            }


            $detail_test = $this->testModel->find($id_test);
            if ($status_pembayaran == "Invoice" || $status_pembayaran == "Belum Lunas" || $status_pembayaran == "Lunas") {
                $tipe_pembayaran = "langsung";
            } else {
                $tipe_pembayaran = "midtrans";
            }
            $dataInsertPembayaran = [
                'id_customer' => $insert_id,
                'tipe_pembayaran' => $tipe_pembayaran,
                'nama' => $nama,
                'amount' => $amount_test,
                'nama_test' => $detail_test['nama_test'],
                'status_pembayaran' => $status_pembayaran,
                'jenis_pembayaran' => $status_pembayaran
            ];
            $insertPembayaran = $this->customerPublic->PembayaranModel->insert($dataInsertPembayaran);
            $id_pembayaran = $this->customerPublic->PembayaranModel->getInsertID();
            if ($id_pembayaran && $insertPembayaran) {
                $this->session->setFlashdata('success', 'Berhasil tambahkan data peserta tes');
                return redirect()->to('/backoffice/peserta');
            } else {
                $this->session->setFlashdata('error', 'Gagal tambahkan data peserta tes');
                return redirect()->to('/backoffice/peserta/create')->withInput();
            }
        } catch (\Throwable $th) {
            //throw $th;
            $this->session->setFlashdata('error', 'Gagal tambahkan data peserta tes karena ' . $th->getMessage() . ' line : ' . $th->getLine() . ' file : ' . $th->getFile());
            return redirect()->to('/backoffice/peserta/create')->withInput();
        }
    }

    public function detail_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Detail Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/peserta_overkuota/detail_customer_overkuota', $data);
    }

    public function edit_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Ubah Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/peserta_overkuota/edit_customer_overkuota', $data);
    }

    public function update_customer_overkuota($id_customer_overkuota)
    {
        # code...
    }

    public function delete_customer_overkuota($id_customer_overkuota)
    {
        $data = array(
            'title' => "Hapus Data Customer Overkuota",
            'page' => "registrasi_overkuota",
            'session' => session(),
        );
        return view('backoffice/peserta_overkuota/delete_customer_overkuota', $data);
    }

    public function doDelete_custoemr_overkuota()
    {
        # code...
    }

    public function check_peserta_overload()
    {
        $validation = $this->validate([
            'tgl_kunjungan' => [
                'rules' => 'required',
                'erros' => [
                    'required' => 'Tanggal kunjungan harus dipilih'
                ]
            ],
            'jam_kunjungan' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Jam kunjungan harus dipilih'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' =>
                [
                    'required' => '{field} lengkap harus diisi',
                ]
            ],
            'nik' => [
                'rules' => 'required|min_length[nik,16]|max_length[nik,16]',
                'errors' =>
                [
                    'required' => '{field} harus diisi',
                    'min_length' => 'Panjang karakter {nik} minimal 16 karakter',
                    'max_length' => 'Panjang karakter {nik} maksimal 16 karakter'
                ]
            ],
            'phone' => [
                'rules' => 'required|min_length[phone, 8]|max_length[phone,14]',
                'erros' =>
                [
                    'required' => 'No HP harus diisi',
                    'min_length' => 'Panjang nomor HP minimal 8 karakter',
                    'max_length' => 'Karakter nomor HP terlalu panjang'
                ]
            ],
            'email' =>  [
                'rules' => 'required',
                'errors' =>
                [
                    'required' => '{field} harus diisi'
                ]
            ],
            'tgl_lahir' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} harus diisi'
                ]
            ]
        ]);
        if (!$validation) {
            return redirect()->back()->withInput();
        } else {
            return true;
        }
    }
}
