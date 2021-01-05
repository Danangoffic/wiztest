<?php

namespace App\Models;

use CodeIgniter\Model;

class KuotaModel extends Model
{
    protected $table      = 'kuota_customer';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'jenis_test_layanan',
        'jam',
        'kuota',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function findV2($jenis_test_layanan = false)
    {
        $builder = db_connect()->table($this->table)
            ->select('jam, hour(jam) as jam_int, kuota, jenis_test_layanan')
            ->where('kuota !=', '0');
        if ($jenis_test_layanan) {
            $builder->where('jenis_test_layanan', $jenis_test_layanan);
        }
        $builder->orderBy('jam', 'ASC');
        return $builder->get();
    }

    public function findV3($jenis_test_layanan = false, $tgl_kunjungan, $jam_kunjungan)
    {
        $builder = db_connect()->table($this->table)
            ->select('jam, hour(jam) as jam_int, kuota, jenis_test_layanan')
            ->where('kuota !=', '0');
        if ($jenis_test_layanan) {
            $builder->where('jenis_test_layanan', $jenis_test_layanan);
        }
        $builder->where('jam', $jam_kunjungan);
        $builder->orderBy('jam', 'ASC');
        return $builder->get();
    }
}
