<?php

namespace App\Models;

use CodeIgniter\Model;

class PemanggilanModel extends Model
{
    protected $table      = 'pemanggilan';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_customer',
        'id_layanan_test',
        'status_pemanggilan',
        'tgl_kunjungan',
        'jam_kunjungan'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function get_nomor_antrian_bilik($nomor_bilik = 1)
    {
        $date = date("Y-m-d");
        $jam = date("H");
        $db_builder = db_connect()->table('customers a')->select('a.no_antrian, a.nama, a.nomor_bilik');
        $db_builder->join('pemanggilan b', 'b.id_customer = a.id')->join('status_hasil c', 'c.id = b.status_pemanggilan')
            ->where('a.nomor_bilik', $nomor_bilik)
            ->where('b.status_pemanggilan', "11")
            ->where('a.tgl_kunjungan', $date)
            ->like('a.jam_kunjungan', $jam, 'right')
            ->orderBy('a.no_antrian')
            ->limit(5);
        return $db_builder->get();
    }

    public function get_nomor_panggilan_bilik($nomor_bilik = 1)
    {
        $date = date("Y-m-d");
        $jam = date("H");
        $db_builder = db_connect()->table('customers a')->select('a.no_antrian, a.nama, a.nomor_bilik');
        $db_builder->join('pemanggilan b', 'b.id_customer = a.id')->join('status_hasil c', 'c.id = b.status_pemanggilan')
            ->where('a.nomor_bilik', $nomor_bilik)
            ->where('b.status_pemanggilan', "12")
            ->where('a.tgl_kunjungan', $date)
            ->like('a.jam_kunjungan', $jam, 'right')
            ->orderBy('a.no_antrian')
            ->limit(1);
        return $db_builder->get();
    }
}
