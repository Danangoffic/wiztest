<?php

namespace App\Models;

use CodeIgniter\Model;

class RujukanModel extends Model
{
    protected $table      = 'rujukan';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'kota',
        'nama',
        'alamat',
        'phone',
        'email',
        'pic_marketing',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
