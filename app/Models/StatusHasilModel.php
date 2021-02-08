<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusHasilModel extends Model
{
    protected $table      = 'status_hasil';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'jenis_status',
        'nama_status',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function by_jenis_status($jenis_status = null)
    {
        if ($jenis_status) return null;

        $builder = db_connect()->table($this->table)->where('jenis_status', $jenis_status);
        return $builder;
    }
}
