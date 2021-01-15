<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriBarangModel extends Model
{
    protected $table      = 'kategori_gudang';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nama_kategori',
        'status_kategori_gudang',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
