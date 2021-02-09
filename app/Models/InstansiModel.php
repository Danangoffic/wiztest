<?php

namespace App\Models;

use CodeIgniter\Model;

class InstansiModel extends Model
{
    protected $table      = 'instansi';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nama',
        'alamat',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function detail_instansi($id_instansi = null)
    {
        if ($id_instansi == null) {
            return null;
        }
        return db_connect()->table($this->table)->select()->where('id', $id_instansi)->limit(1)->get()->getRowArray();
    }
}
