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
        'id_customer',
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
        'jam_kunjungan',
        'tgl_kunjungan',
        'status_pembayaran',
        'token',
        'catatan',
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
