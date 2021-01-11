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
        'id_customer',
        'id_alat',
        'id_sample',
        'id_dokter',
        'id_petugas',
        'status_cov',
        'status_gene',
        'status_orf',
        'status_igg',
        'status_igm',
        'status_antigen',
        'status_molecular',
        'detail_ic',
        'status_pemeriksaan',
        'status_kirim',
        'waktu_ambil_sampling',
        'waktu_periksa_sampling',
        'waktu_selesai_periksa',
        'created_by',
        'updated_by',
        'catatan'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
