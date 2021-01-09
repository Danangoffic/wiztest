<?php

namespace App\Models;

use CodeIgniter\Model;

class UserDetailModel extends Model
{
    protected $table      = 'user_detail';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_user',
        'nama',
        'alamat',
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
