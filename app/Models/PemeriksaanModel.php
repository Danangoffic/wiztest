<?php

namespace App\Models;

use CodeIgniter\Model;

class PemeriksaanModel extends Model
{
    protected $table      = 'jenis_pemeriksaan';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'nama_pemeriksaan',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function whereInSelection($col, $val)
    {
        return $this->this_db_table()->whereIn($col, $val)->orderBy('id', 'ASC')->get();
    }

    public function this_db_table($select = false)
    {
        $db_this = db_connect()->table($this->table);
        if ($select) $db_this->select($select);
        return $db_this;
    }
}
