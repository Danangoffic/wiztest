<?php

namespace App\Models;

use CodeIgniter\Model;

class PemeriksaModel extends Model
{
    protected $table      = 'pemeriksa';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nama',
        'phone',
        'alamat',
        'email',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
