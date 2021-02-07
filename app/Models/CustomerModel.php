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

    public function db_this()
    {
        return db_connect();
    }

    public function db_table()
    {
        return $this->db_this->table($this->table);
    }

    public function customer_jenis_test_filtering_date_between($select = "*", $id_jenis_test, $id_jenis_layanan, $date1, $date2)
    {
        $query = $this->db_this()->query("select {$select} from {$this->table} where jenis_test = '{$id_jenis_test}' AND jenis_layanan = '{$id_jenis_layanan}' AND tgl_kunjungan BETWEEN '{$date1}' AND '{$date2}'");
        return $query->getFirstRow();
    }



    protected $useTimestamps = true;

    public function findCustomerCounter($jenis_layanan = '1', $tgl_kunjungan)
    {
        return db_connect()->table('customers')
            ->select('count(*) as counter')
            ->where('jenis_layanan', $jenis_layanan)
            ->where('tgl_kunjungan', $tgl_kunjungan)->get();
    }

    public function getCustomerAvailableByDate($jenis_test, $jenis_pemeriksaan, $jenis_layanan, $faskes_asal = '1', $tgl_kunjungan)
    {
        $query = db_connect()
            ->table('customers')
            ->where([
                'jenis_test' => $jenis_test,
                'jenis_pemeriksaan' => $jenis_pemeriksaan,
                'jenis_layanan' => $jenis_layanan,
                'faskes_asal' => $faskes_asal,
                'tgl_kunjungan' => $tgl_kunjungan,
                'kehadiran' => '0'
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

    public function customerPayment($paymentStatus = "unpaid", $id_data_jenis_test, $tgl_kunjungan = '')
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
        return db_connect()->table($this->table)->where(['id_hs' => $id_hs, 'jenis_test' => $jenis_test])->countAllResults();
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
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
