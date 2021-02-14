<?php

namespace App\Models;

use CodeIgniter\Model;

class DataFileCorporateModel extends Model
{
    protected $table      = 'data_file_corporate';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nama_file',
        'id_instansi',
        'id_cust_corporate',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
