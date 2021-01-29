<?php

namespace App\Models;

use CodeIgniter\Model;

class AfiliasiModel extends Model
{
    protected $table      = 'afiliasi';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_marketing',
        'value',
        'is_disount',
        'discount',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
