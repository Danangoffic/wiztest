<?php

namespace App\Controllers\backoffice;

use App\Controllers\Customer;
use App\Models\CustomerModel;
use App\Models\DokterModel;
use App\Models\FaskesModel;
use App\Models\InstansiModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\PemeriksaanModel;
use App\Models\PemeriksaModel;
use App\Models\TestModel;
use CodeIgniter\Controller;
use CodeIgniter\Validation\Validation;
use Dompdf\Cpdf;
// use App\Controllers;
// use CodeIgniter\Controller;

class Peserta extends Controller
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

    public function __construct()
    {
        $this->session = session();
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
    }
    public function index()
    {
        $Customer = $this->customerModel->detailRegistrasi()->getResultArray();
        $data = array(
            'title' => "Registrasi",
            'page' => "registrasi",
            'data_customer' => $Customer,
            'session' => session()
        );
        return view('backoffice/registrasi/index', $data);
    }

    public function create_peserta()
    {
        $dataPemeriksa = $this->pemeriksaModel->findAll();
        // dd($dataPemeriksa);
        $dataJenisPemeriksaan = $this->jenisPemeriksaanModel->findAll();
        $dataFaskes = $this->faskesModel->findAll();
        $dataInstanasi = $this->instansiModel->findAll();
        $dataMarketing = $this->marketingModel->findAll();
        $dataLayananTest = $this->layananTestModel->findAll();
        $data = array(
            'title' => "Registrasi Peserta Baru",
            'page' => "registrasi",
            'session' => session(),
            'pemeriksa' => $dataPemeriksa,
            'jenis_pemeriksaan' => $dataJenisPemeriksaan,
            'faskes' => $dataFaskes,
            'instansi' => $dataInstanasi,
            'marketing' => $dataMarketing,
            'data_layanan_test' => $dataLayananTest,
            'testModel' => $this->testModel,
            'layananModel' => $this->layananModel,
            'validation' => \Config\Services::validation()
        );
        return view('backoffice/peserta/create_peserta', $data);
    }

    public function save()
    {
        $marketingModel = new MarketingModel();
        // $validation =  \Config\Services::validation();
        $this->validasi_peserta();

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
        $kehadiran = 0;
        $tgl_kunjungan = $this->request->getPost('tgl_kunjungan');
        $id_jam_kunjungan = $this->request->getPost('jam_kunjungan');
        $dataJamKunjungan = $this->customerPublic->kuotaModel->find($id_jam_kunjungan);
        $jam_kunjungan = $dataJamKunjungan['jam'];
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

            $no_urutan = $this->customerPublic->getUrutan($layanan_test, $tgl_kunjungan, $id_pemeriksaan, $id_layanan);
            // echo "Urutan : " . $no_urutan;

            // var_dump($data);
            $DataInsertCustomer = [
                'nama' => $nama,
                'email' => $email,
                'nik' => $nik,
                'phone' => $phone,
                'pemeriksa' => $this->request->getPost('nama_pemeriksa'),
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
                'status_test' => 'menunggu',
                'tahap' => 1,
                'kehadiran' => $kehadiran,
                'no_antrian' => $no_urutan,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => $this->request->getPost('status_pembayaran')
            ];
            $insert = $this->customerModel->insert($DataInsertCustomer);
            $insert_id = null;
            if ($insert) {
                $insert_id = $this->customerModel->getInsertID();
            } else {
                // return $this->failValidationError();
            }
            $InvoiceCustomer = $this->customerPublic->getInvoiceNumber($insert_id);
            $this->customerModel->update($insert_id, ['invoice_number' => $InvoiceCustomer]);
            $detail_test = $this->testModel->find($id_test);
            $dataInsertPembayaran = [
                'id_customer' => $insert_id,
                'nama' => $nama,
                'jenis_test' => $layanan_test,
                'nama_test' => $detail_test['nama_test'],
                'status_pembayaran' => 'unpaid'
            ];
            $insertPembayaran = $this->customerPublic->PembayaranModel->insert($dataInsertPembayaran);
            $id_pembayaran = $this->customerPublic->PembayaranModel->getInsertID();
            if ($id_pembayaran) {
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

    public function detail_peserta($id)
    {
        $Midtrans = new Midtrans();
        $Customer = $this->customerModel->detailRegistrasi($id)->getFirstRow();
        $orderId = $Customer->customer_unique;
        // dd($Customer);
        // echo $orderId;
        // exit();
        $DetailPayment = $Midtrans->getStatusByOrderId($orderId);
        // dd($DetailPayment);

        $data = array(
            'title' => "Registrasi",
            'page' => "registrasi",
            'data_customer' => $Customer,
            'session' => session(),
            'id' => $id,
            'detail_payment' => $DetailPayment
        );
        return view('backoffice/peserta/detail_peserta', $data);
    }

    public function edit($id_customer)
    {
        $dataPemeriksa = $this->pemeriksaModel->findAll();
        // dd($dataPemeriksa);
        $dataJenisPemeriksaan = $this->jenisPemeriksaanModel->findAll();
        $dataFaskes = $this->faskesModel->findAll();
        $dataInstanasi = $this->instansiModel->findAll();
        $dataMarketing = $this->marketingModel->findAll();
        $dataLayananTest = $this->layananTestModel->findAll();
        $data = array(
            'title' => "Ubah Customer",
            'page' => "registrasi",
            'session' => session(),
            'data' => $this->customerModel->find($id_customer),
            'id' => $id_customer,
            'pemeriksa' => $dataPemeriksa,
            'jenis_pemeriksaan' => $dataJenisPemeriksaan,
            'faskes' => $dataFaskes,
            'instansi' => $dataInstanasi,
            'marketing' => $dataMarketing,
            'data_layanan_test' => $dataLayananTest,
            'testModel' => $this->testModel,
            'layananModel' => $this->layananModel,
            'validation' => \Config\Services::validation()
        );
        return view('backoffice/peserta/edit_peserta', $data);
    }

    public function update($id_customer)
    {
        $this->validasi_peserta();

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
        $kehadiran = 0;
        $tgl_kunjungan = $this->request->getPost('tgl_kunjungan');
        $id_jam_kunjungan = $this->request->getPost('jam_kunjungan');
        $dataJamKunjungan = $this->customerPublic->kuotaModel->find($id_jam_kunjungan);
        $jam_kunjungan = $dataJamKunjungan['jam'];
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

            $no_urutan = $this->customerPublic->getUrutan($layanan_test, $tgl_kunjungan, $id_pemeriksaan, $id_layanan);
            // echo "Urutan : " . $no_urutan;

            // var_dump($data);
            $DataInsertCustomer = [
                'nama' => $nama,
                'email' => $email,
                'nik' => $nik,
                'phone' => $phone,
                'pemeriksa' => $this->request->getPost('nama_pemeriksa'),
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
                'status_test' => 'menunggu',
                'tahap' => 1,
                'kehadiran' => $kehadiran,
                'no_antrian' => $no_urutan,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => $this->request->getPost('status_pembayaran')
            ];
            $insert = $this->customerModel->insert($DataInsertCustomer);
            $insert_id = null;
            if ($insert) {
                $insert_id = $this->customerModel->getInsertID();
            } else {
                // return $this->failValidationError();
            }
            $InvoiceCustomer = $this->customerPublic->getInvoiceNumber($insert_id);
            $this->customerModel->update($insert_id, ['invoice_number' => $InvoiceCustomer]);
            $detail_test = $this->testModel->find($id_test);
            $dataInsertPembayaran = [
                'id_customer' => $insert_id,
                'nama' => $nama,
                'jenis_test' => $layanan_test,
                'nama_test' => $detail_test['nama_test'],
                'status_pembayaran' => 'unpaid'
            ];
            $insertPembayaran = $this->customerPublic->PembayaranModel->insert($dataInsertPembayaran);
            $id_pembayaran = $this->customerPublic->PembayaranModel->getInsertID();
            if ($id_pembayaran) {
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

    public function delete($id_customer)
    {
        $data = array(
            'title' => "Tambah Customer",
            'page' => "registrasi",
            'session' => session(),
        );
        return view('backoffice/peserta/delete_peserta', $data);
    }

    public function doDelete()
    {
        # code...
    }

    public function peserta_hadir(int $id_peserta)
    {
        # code...
    }

    public function validasi_peserta()
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
            return redirect()->to('/backoffice/peserta/create')->withInput();
        } else {
            return true;
        }
    }
}
