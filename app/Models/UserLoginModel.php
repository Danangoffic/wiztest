<?php

namespace App\Models;

use CodeIgniter\Model;

class UserLoginModel extends Model
{
    protected $table      = 'user_login';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_user',
        'nama',
        'email',
        'page'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
