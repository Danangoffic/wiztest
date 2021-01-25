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
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
