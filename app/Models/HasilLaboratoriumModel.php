<?php

namespace App\Models;

use CodeIgniter\Model;

class HasilLaboratoriumModel extends Model
{
    protected $table      = 'hasil_laboratorium';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'valid',
        'well',
        'id_customer',
        'id_alat',
        'id_sample',
        'id_dokter',
        'id_petugas',
        'status_cov',
        'value_n_gene',
        'value_orf',
        'value_ic',
        'status_gene',
        'status_orf',
        'value_igg',
        'value_igm',
        'status_igg',
        'status_igm',
        'status_antigen',
        'status_molecular',
        'detail_ic',
        'status_pemeriksaan',
        'status_kirim',
        'txt_status_swab',
        'txt_status_antigen',
        'txt_status_rapid',
        'waktu_ambil_sampling',
        'waktu_periksa_sampling',
        'waktu_selesai_periksa',
        'created_by',
        'updated_by',
        'catatan',
        'has_file',
        'id_file',
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function by_file_id($id_file = null)
    {
        if ($id_file == null) {
            return $id_file;
        }
        $builder = db_connect()->table($this->table)->where('id_file', $id_file)->orderBy('id', 'ASC');
        return $builder->get()->getResultArray();
    }

    public function by_id_customer($id_customer = null)
    {
        if ($id_customer == null) return $id_customer;
        $builder = db_connect()->table($this->table)->where('id_customer', $id_customer)->limit(1);
        return $builder->get()->getRowArray();
    }

    public function by_valid($valid = null)
    {
        $builder = db_connect()
            ->table($this->table)->select()
            ->where('valid', $valid)
            ->orderBy('id', 'desc');
        return $builder->get()->getResultArray();
    }

    public function customers_by_test($id_test = false, $valid = "no", $date1 = false, $date2 = false)
    {
        $builder = db_connect()
            ->table('customers a')
            ->select("b.*, d.nama_test, e.nama_layanan, a.created_at as tgl_registrasi, a.nama, a.nik, a.customer_unique, a.jenis_kelamin, a.alamat, a.tgl_kunjungan, a.jam_kunjungan")
            ->join('hasil_laboratorium b', 'a.id = b.id_customer')
            ->join('data_layanan_test c', 'a.jenis_test = c.id')
            ->join('jenis_test d', 'c.id_test = d.id')
            ->join('jenis_layanan e', 'c.id_layanan = e.id');
        if ($id_test) {
            $builder->where('c.id_test', $id_test);
        }
        if ($date1 && $date2) {
            $builder->where("a.tgl_kunjungan between '{$date1}' and '{$date2}' ");
        } else {
            if ($date1) {
                $builder->where('a.tgl_kunjungan', $date1);
            } elseif ($date2) {
                $builder->where('a.tgl_kunjungan', $date2);
            }
        }
        $builder->where('b.valid', $valid)->orderBy('b.id', 'DESC');
        return $builder->get()->getResultArray();
    }
}
