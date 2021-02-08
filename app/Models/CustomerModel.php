<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerModel extends Model
{
    protected $table      = 'customers';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'jenis_test',
        'jenis_pemeriksaan',
        'jenis_layanan',
        'faskes_asal',
        'customer_unique',
        'invoice_number',
        'status_peserta',
        'email',
        'nama',
        'nik',
        'phone',
        'pemeriksa',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'id_marketing',
        'instansi',
        'status_test',
        'tahap',
        'kehadiran',
        'no_antrian',
        'nomor_bilik',
        'jam_kunjungan',
        'tgl_kunjungan',
        'status_pembayaran',
        'token',
        'catatan',
        'url_pdf',
        'is_hs',
        'id_hs',
        'is_corporate',
        'id_cust_corporate'
    ];

    public function customer()
    {
        return db_connect()->table($this->table);
    }

    // public function db_table()
    // {
    //     return $this->db_this->table($this->table);
    // }

    protected $useTimestamps = true;

    public function customer_jenis_test_filtering_date_between($select = "*", $id_jenis_test, $id_jenis_layanan, $date1, $date2)
    {
        $builder = $this->customer()->select($select)
            ->where('jenis_test', $id_jenis_test)
            ->where('jenis_layanan', $id_jenis_layanan)
            ->where("tgl_kunjungan BETWEEN '{$date1}' AND '{$date2}'");
        return $builder->get()->getFirstRow();
        // $query = $this->db_this()->query("select {$select} from {$this->table} where jenis_test = '{$id_jenis_test}' AND jenis_layanan = '{$id_jenis_layanan}' AND tgl_kunjungan BETWEEN '{$date1}' AND '{$date2}'");
        // return $query->getFirstRow();
    }

    public function findCustomerCounter($jenis_layanan = '1', $tgl_kunjungan)
    {
        return db_connect()->table('customers')
            ->select('count(*) as counter')
            ->where('jenis_layanan', $jenis_layanan)
            ->where('tgl_kunjungan', $tgl_kunjungan)->get();
    }

    public function getCustomerAvailableByDate($jenis_test, $jenis_pemeriksaan, $jenis_layanan, $faskes_asal = '1', $tgl_kunjungan, $jam_kunjungan = null)
    {
        $query = db_connect()
            ->table('customers')
            ->where([
                'jenis_test' => $jenis_test,
                'jenis_pemeriksaan' => $jenis_pemeriksaan,
                'jenis_layanan' => $jenis_layanan,
                'faskes_asal' => $faskes_asal,
                'tgl_kunjungan' => $tgl_kunjungan,
                'jam_kunjungan' => $jam_kunjungan,
                'kehadiran' => '22'
            ])->orderBy('id', 'DESC')->limit(1);
        return $query->get();
    }

    public function getByInvoiceNumber($invoiceNumber)
    {
        $db = db_connect();
        $builder = $db->table('customers a')->select('a.*, b.nama as nama_instansi, c.nama_marketing')
            ->join('instansi b', 'b.id = a.instansi')
            ->join('marketing c', 'c.id = a.id_marketing');
        $builder->where('a.inoice_number', $invoiceNumber);
        return $builder->get();
    }

    public function detailRegistrasi($id = false, $jenis_pemeriksaan = false)
    {
        $db = db_connect();
        $builder = $db->table('customers a')->select('a.*, b.nama as nama_instansi, c.nama_marketing, d.biaya, e.nama_layanan, f.nama_test, g.nama_pemeriksaan')
            ->join('instansi b', 'b.id = a.instansi')
            ->join('marketing c', 'c.id = a.id_marketing')
            ->join('data_layanan_test d', 'd.id = a.jenis_test')
            ->join('jenis_layanan e', 'e.id = d.id_layanan')
            ->join('jenis_test f', 'f.id = d.id_test')
            ->join('jenis_pemeriksaan g', 'g.id = d.id_pemeriksaan')
            ->orderBy('id', 'DESC');
        if ($id) {
            $builder->where('a.id', $id);
        }
        if ($jenis_pemeriksaan) {
            $builder->where('d.id_pemeriksaan', $jenis_pemeriksaan);
        }
        return $builder->get();
    }

    public function customerPayment($paymentStatus = "pending", $id_data_jenis_test, $tgl_kunjungan = '')
    {
        # code...
        $builder = db_connect()->table('customers a')
            ->select('a.*, b.nama_pemeriksaan, c.jam, hour(c.jam) as jam_, c.kuota')
            ->join('jenis_pemeriksaan b', 'a.jenis_pemeriksaan = b.id')
            ->join('kuota_customer c', 'a.jenis_test = c.jenis_test_layanan')
            ->where('a.status_pembayaran', $paymentStatus)
            ->where('a.jenis_test', $id_data_jenis_test)
            ->where('a.tgl_kunjungan', $tgl_kunjungan);
        return $builder->get();
    }

    /**
     * this function is to get total customer in same test for home service
     * @param int|string $jenis_test
     */
    public function total_customer_same_test_hs($id_hs, $jenis_test): int
    {
        return $this->customer()->where(['id_hs' => $id_hs, 'jenis_test' => $jenis_test])->countAllResults();
    }

    public function customersBooking($id_data_jenis_test, $tgl_kunjungan = false, $jam_kunjungan = false, $paymentStatus = 'settlement', $kehadiran = '22')
    {
        $builder = db_connect()->table('customers a')
            ->select('a.*, b.nama_pemeriksaan, c.jam, hour(c.jam) as jam_, c.kuota')
            ->join('jenis_pemeriksaan b', 'a.jenis_pemeriksaan = b.id')
            ->join('kuota_customer c', 'a.jenis_test = c.jenis_test_layanan')
            ->where('a.jenis_test', $id_data_jenis_test);
        if ($tgl_kunjungan) {
            $builder->where('a.tgl_kunjungan', $tgl_kunjungan);
        }
        if ($paymentStatus) {
            $builder->where('a.status_pembayaran', $paymentStatus);
        }
        if ($jam_kunjungan) {
            $builder->where('a.jam_kunjungan', $jam_kunjungan)
                ->where('c.jam', $jam_kunjungan);
        }
        if ($kehadiran) {
            $builder->where('a.kehadiran', $kehadiran);;
        }
        $builder->orderBy('a.id', 'DESC');
        return $builder;
    }

    public function get_customer_by_invoice($invoice_number = null)
    {
        return $this->customer()->where('invoice_number', $invoice_number)->get(1)->getRowArray();
    }

    public function get_by_customer_unique($customer_unique = null)
    {
        if ($customer_unique == null) {
            return null;
        }
        $builder = $this->customer()->where('customer_unique', $customer_unique)->get(1);
        return $builder->getRowArray();
    }

    public function detail_customer($id_customer = null)
    {
        if ($id_customer == null) {
            return null;
        }
        $builder = $this->customer()->where('id', $id_customer)->limit(1);
        return $builder->get()->getRowArray();
    }

    public function customers_corporate($id_instansi = null)
    {
        if ($id_instansi == null) {
            return null;
        }

        $builder = $this->customer()->where('instansi', $id_instansi)->orderBy('nama', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function customers_hs($id_hs = null)
    {
        if ($id_hs = null) {
            return null;
        }
        $is_hs = "yes";
        $builder = $this->customer()->where('is_hs', $is_hs)->where('id_hs', $id_hs)->orderBy('nama', ' ASC')->get();
        return $builder->getResultArray();
    }

    public function antrian_swabber($tanggal = null, $jam = null, $nomor_bilik = null, $tipe = "booking")
    {
        $builder = $this->customer();
        $builder->where(['tgl_kunjungan' => $tanggal, 'jam_kunjungan' => $jam, 'nomor_bilik' => $nomor_bilik]);
        if ($tipe == "antrian") {
            $builder->where('kehadiran', '23');
        }
        $builder->where('is_printed', "0");
        $builder->orderBy('no_antrian', 'ASC');
        return $builder->get();
    }

    public function by_nomor_bilik($nomor_bilik = 1)
    {
        $builder = db_connect()->table($this->table)->where('nomor_bilik', $nomor_bilik)
            ->where(['kehadiran' => "23", "tgl_kunjungan" => date('Y-m-d'), 'jam_kunjungan' => date("H") . ":00:00"])
            ->orderBy('no_antrian', 'ASC')->get();
        return $builder;
    }
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
