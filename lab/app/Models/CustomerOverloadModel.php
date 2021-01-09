<?php

namespace App\Models;

use CodeIgniter\Model;

class CustomerOverloadModel extends Model
{
    protected $table      = 'customers_overload';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'jenis_test',
        'jenis_pemeriksaan',
        'jenis_layanan',
        'faskes_asal',
        'customer_unique',
        'email',
        'nama',
        'nik',
        'phone',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'id_marketing',
        'instansi',
        'id_pembayaran',
        'status_pembayaran',
        'status_test',
        'tahap',
        'kehadiran',
        'no_antrian',
        'jam_kunjungan',
        'tgl_kunjungan'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
