<?php

namespace App\Models;

use CodeIgniter\Model;

class BilikSwabberModel extends Model
{
    protected $table      = 'bilik_swabber';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'assigned_to',
        'nomor_bilik',
        'jenis_test'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function by_nomor_bilik($nomor_bilik = 1)
    {
        $builder = db_connect()
            ->table($this->table)
            ->select()
            ->where('nomor_bilik', $nomor_bilik)->get();
        return $builder;
    }
}
