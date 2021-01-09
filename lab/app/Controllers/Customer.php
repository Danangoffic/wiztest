<?php

namespace App\Controllers;

use App\Controllers\backoffice\Layanan;
use App\Controllers\backoffice\Midtrans as BackofficeMidtrans;
use App\Controllers\backoffice\SystemParameter;
use App\Models\CustomerModel;
use App\Models\KehadiranModel;
use App\Models\KuotaModel;
use App\Models\LayananModel;
use App\Models\LayananTestModel;
use App\Models\MarketingModel;
use App\Models\MenuModel;
use App\Models\PembayaranModel;
use App\Models\PemeriksaanModel;
use App\Models\TestModel;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\SystemParameterModel;
use Midtrans;

class Customer extends ResourceController
{
    protected $systemparam;
    protected $layananModel;
    protected $pemeriksaanModel;
    protected $testModel;
    protected $layananTestModel;
    protected $customerModel;
    public $kuotaModel;
    public $PembayaranModel;
    function __construct()
    {
        $this->systemparam = new SystemParameter;
        $this->layananModel = new LayananModel();
        $this->pemeriksaanModel = new PemeriksaanModel();
        $this->testModel = new TestModel();
        $this->layananTestModel = new LayananTestModel();
        $this->customerModel = new CustomerModel();
        $this->kuotaModel = new KuotaModel();
        $this->PembayaranModel = new PembayaranModel();
    }
    public function index()
    {
        $marketingModel = new MarketingModel();
        $data_marketing = $marketingModel->findAll();
        $vgroup = 'MIDTRANS_KEY';
        $paramter = 'CLIENT_KEY';
        $DB = db_connect()->table('system_parameter')->select('*')->where('vgroup', $vgroup)->where('parameter', $paramter)->get()->getFirstRow();
        // $getData = $this->sysParamModel->getByVgroupAndParamter('MIDTRANS_KEY', 'CLIENT_KEY');
        $encrypted_client = $DB->value;
        $ClientKey = base64_decode($encrypted_client);
        $data = [
            'title' => "Home",
            'marketings' => $data_marketing,
            'midtrans_client_key' => $ClientKey
        ];
        return view('customer/index', $data);
    }

    public function getMenu()
    {
        $menumodel = new MenuModel();
        try {
            $dataMenu = $menumodel->findAll();
            if (count($dataMenu) > 0) {
                return $this->respond($dataMenu, 200, 'success');
            } else {
                return $this->respond(null, 404, 'not found');
            }
        } catch (\Throwable $th) {
            return $this->failServerError();
        }
    }

    public function registrasi()
    {
        $marketingModel = new MarketingModel();
        $validation =  \Config\Services::validation();
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
        $marketing = $this->request->getPost('marketing');
        $jenis_test = $this->request->getPost('jenis_test');
        $jenis_pemeriksaan = $this->request->getPost('jenis_pemeriksaan');
        $jenis_layanan = $this->request->getPost('jenis_layanan');
        $faskes_asal = $this->request->getPost('faskes_asal');
        $instansi = $this->request->getPost('instansi');
        $kehadiran = 0;
        $tgl_kunjungan = $this->request->getPost('tgl_kunjungan');
        $id_jam_kunjungan = $this->request->getPost('jam_kunjungan');
        $dataJamKunjungan = $this->kuotaModel->find($id_jam_kunjungan);
        $jam_kunjungan = $dataJamKunjungan['jam'];
        // var_dump($this->request->getPost());
        // exit();
        $customer_UNIQUE = $this->getOrderId($jenis_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan);
        // echo db_connect()->showLastQuery();
        // exit();
        // dd($customer_UNIQUE);
        try {
            $Layanan = new Layanan();
            $dataMarketing = $marketingModel->find($marketing);
            $dataLayanan = $this->layananModel->find($jenis_layanan);
            $dataTest = $this->testModel->find($jenis_test);

            $no_urutan = $this->getUrutan($jenis_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);
            // echo "Urutan : " . $no_urutan;

            // var_dump($data);
            $DataInsertCustomer = [
                'nama' => $nama,
                'email' => $email,
                'nik' => $nik,
                'phone' => $phone,
                'jenis_test' => $jenis_test,
                'jenis_pemeriksaan' => $jenis_pemeriksaan,
                'jenis_layanan' => $jenis_layanan,
                'faskes_asal' => $faskes_asal,
                'customer_unique' => $customer_UNIQUE,
                'jenis_kelamin' => $jenis_kelamin,
                'tempat_lahir' => $tempat_lahir,
                'tanggal_lahir' => $tgl_lahir,
                'alamat' => $alamat,
                'id_marketing' => $marketing,
                'instansi' => $instansi,
                'status_test' => 'menunggu',
                'tahap' => 1,
                'kehadiran' => '0',
                'no_antrian' => $no_urutan,
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'status_pembayaran' => 'unpaid'
            ];
            $insert = $this->customerModel->insert($DataInsertCustomer);
            $insert_id = null;
            if ($insert) {
                $insert_id = $this->customerModel->getInsertID();
            } else {
                return $this->failValidationError();
            }
            $InvoiceCustomer = $this->getInvoiceNumber($insert_id);
            $this->customerModel->update($insert_id, ['invoice_number' => $InvoiceCustomer]);
            $DetailLayananTest = $Layanan->detail_layanan($jenis_pemeriksaan);
            $productName = $DetailLayananTest['nama_test'] . ' ' . $DetailLayananTest['nama_layanan'];
            $params = array(
                'transaction_details' => array(
                    'order_id' => $DataInsertCustomer['customer_unique'],
                    'gross_amount' => $DetailLayananTest['biaya'],
                    'product_name' => $productName,
                    'quantity' => 1
                ),
                'customer_details' => array(
                    'first_name' => explode(' ', $nama)[0],
                    'last_name' => str_replace(explode(' ', $nama)[0], '', $nama),
                    'email' => $email,
                    'phone' => $phone,
                    'Address' => $alamat
                ),
                'callbacks' => array(
                    'finis' => base_url()
                )
            );


            // MIDTRANS TRANSACTION GET TOKEN
            $Midtrans = new BackofficeMidtrans();
            $MidtransToken = $Midtrans->getToken($params);
            $vars = array(
                'marketing' => array(
                    'id' => $marketing,
                    'nama' => $dataMarketing['nama_marketing']
                ),
                'jam_kunjungan' => $jam_kunjungan,
                'tgl_kunjungan' => $tgl_kunjungan,
                'jenis_test' => $jenis_test,
                'jenis_pemeriksaan' => $jenis_pemeriksaan,
                'jenis_layanan' => $dataLayanan['nama_layanan'],
                'antrain' => $DataInsertCustomer['no_antrian']
            );
            array_push($params, $vars);
            $PembayaranModel = new PembayaranModel();
            $dataInsertPembayaran = [
                'id_customer' => $insert_id,
                'nama' => $nama,
                'jenis_test' => $jenis_test,
                'nama_test' => $DetailLayananTest['nama_test'],
                'status_pembayaran' => 'unpaid'
            ];
            $insertPembayaran = $PembayaranModel->insert($dataInsertPembayaran);
            $id_pembayaran = $PembayaranModel->getInsertID();
            if ($MidtransToken) {
                $data = ['data' => $MidtransToken, 'invoice_number' => $InvoiceCustomer, 'transaction' => $params, 'detail_payment' => $PembayaranModel->find($id_pembayaran)];
                return $this->respond($data, 200, 'success');
            } else {
                $data = ['data' => '', 'invoice_number' => null];
                return $this->respond($data, 400, 'Failed');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return $this->failServerError($th->getMessage() . ' line: ' . $th->getLine() . ' Code: ' . $th->getCode() . ' file: ' . $th->getFile());
        }
    }

    public function getOrderId($type_test, $jenis_pemeriksaan, $tgl_kunjungan, $jenis_layanan, $jam_kunjungan)
    {
        $awal = '';
        switch ($type_test) {
            case '1':
                $awal = 'SPS';
                break;
            case '2':
                $awal = 'SPB';
                break;
            case '3':
                $awal = 'RTB';
                break;
            case '4':
                $awal = 'SAB';
                break;

            default:
                # code...
                break;
        }
        $awal = $awal . date('ymd') . substr($jam_kunjungan, 0, 2);
        $urutan = $this->getUrutan($type_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan);

        $ID = str_pad($urutan, 3, '0', STR_PAD_LEFT);
        $NEWID = $awal . $ID;
        return $NEWID;
    }

    public function getUrutan($type_test, $tgl_kunjungan, $jenis_pemeriksaan, $jenis_layanan)
    {
        $CustomerModel = new CustomerModel();
        $data = $CustomerModel->getCustomerAvailableByDate($type_test, $jenis_pemeriksaan, $jenis_layanan, '1', $tgl_kunjungan)->getRowArray();
        // db_connect()->table()->select()->get()->getRowArray()
        // echo db_connect()->showLastQuery();
        // var_dump($data);
        if ($data) {
            $totalData = (intval($data['id'])) ? intval($data['id']) : 0;
        } else {
            $totalData = 0;
        }
        return $totalData + 1;
    }

    public function getInvoiceNumber($id_customer): string
    {
        $data = $this->customerModel->find($id_customer);
        // echo $data['no_antrian'];
        // exit();
        $word1 = 'INV-';
        $date = date('ymd');
        $urutan = $data['no_antrian'];
        $generateUrutan = str_pad($urutan, 3, '0', STR_PAD_LEFT);
        // echo $date;
        // exit();
        $invoice = $word1 . $date . $generateUrutan;
        // echo $invoice;
        // exit();
        return $invoice;
    }

    public function detail_form2()
    {

        $id_jenis_test = $this->request->getVar('id_jenis_test');
        try {
            $LayananModel = new LayananTestModel();
            $dataLayanan = $LayananModel->getDetailLayananTestByIdJenisTest($id_jenis_test)->getResultArray();
            $result = ['data_layanan' => $dataLayanan];
            if ($dataLayanan) {
                return $this->respond($result, 200, 'success');
            } else {
                return $this->respond($result, 404, 'Not found');
            }
        } catch (\Throwable $th) {
            return $this->failServerError('Failed ' . $th->getMessage());
        }
    }

    public function jadwal_available()
    {
        $Layanan = new LayananTestModel();
        $id_jenis_test = $this->request->getVar('jenis_test');
        $tgl_kunjungan = $this->request->getVar('tgl_kunjungan');
        // $jenis_pemeriksaan = $this->request->getPost('jenis_pemeriksaan');
        $cek_db_kuota = $Layanan->getKuotaJenisTest($id_jenis_test);
        // echo db_connect()->getLastQuery();
        $result_data = array();
        // dd($cek_db_kuota->getResultArray());
        foreach ($cek_db_kuota->getResultArray() as $key => $value) {
            $KuotaDB = $Layanan->getAvailableKuota($id_jenis_test, $value['jam'], $tgl_kunjungan);
            $availKuota = intval($value['kuota']) - $KuotaDB;
            $status = ($availKuota == 0) ? 'full' : 'available';
            $disabled = ($availKuota == 0) ? 'disabled' : '';
            $btn_class = ($availKuota == 0) ? 'btn-danger' : 'btn-outline-success';
            $result_data[] = [
                'value' => $value['val'],
                'label' => substr($value['jam'], 0, 5),
                'kuota' => $availKuota,
                'status' => $status,
                'disabled' => $disabled,
                'btn_class' => $btn_class
            ];
        }
        return $this->respond($result_data, 200, 'success');
    }



    //--------------------------------------------------------------------

}