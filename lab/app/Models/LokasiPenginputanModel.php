<?php

namespace App\Models;

use CodeIgniter\Model;

class LokasiPenginputanModel extends Model
{
    protected $table      = 'lokasi_input';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_kota',
        'url_kop',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
}
