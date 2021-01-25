<?php

namespace App\Models;

use CodeIgniter\Model;

class TrafikDataGudangModel extends Model
{
    protected $table      = 'data_trafik_gudang';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_barang_gudang',
        'id_peminjaman',
        'qty',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
