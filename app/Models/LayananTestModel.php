<?php

namespace App\Models;

use CodeIgniter\Model;

class LayananTestModel extends Model
{
    protected $table      = 'data_layanan_test';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_layanan',
        'id_test',
        'biaya',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
    public function getDetailLayananTestByIdJenisTest($id_jenis_test, $pemeriksaan, $segmen)
    {
        $builderDB = db_connect();
        $query = $builderDB->table('data_layanan_test a')->select('a.id, a.biaya, a.time_start, a.time_end, b.nama_layanan, c.nama_test')
            ->join('jenis_layanan b', 'b.id = a.id_layanan')
            ->join('jenis_test c', 'c.id = a.id_test')
            ->where('a.id_test', $id_jenis_test)
            ->where('a.id_pemeriksaan', $pemeriksaan)
            ->where("a.id_segmen", $segmen);
        return $query->get();
    }

    public function getKuotaJenisTest($id_jenis_test)
    {
        $builderDB = db_connect();
        $query2 = $builderDB->query("SELECT a.jam, hour(a.jam) as val, a.kuota FROM kuota_customer a 
                    JOIN data_layanan_test b ON b.id = a.jenis_test_layanan 
                    JOIN jenis_test c ON c.id = b.id_test
                    WHERE  a.jenis_test_layanan = '$id_jenis_test' AND (hour(a.jam) >= hour(b.time_start) AND hour(a.jam) <= hour(b.time_end))");
        return $query2;
    }

    public function getAvailableKuota($id_jenis_test, $jam_kunjungan, $tgl_kunjungan)
    {
        $builderDB = db_connect();
        $query = $builderDB->table('customers')->select("*")
            ->where('jenis_test', $id_jenis_test)
            ->where('jam_kunjungan', $jam_kunjungan)
            ->where('tgl_kunjungan', $tgl_kunjungan)
            ->countAll();
        return $query;
    }

    public function get_by_key($key = null, $value = null)
    {
        if ($key == null) {
            return null;
        }
        $builder = db_connect()->table('data_layanan_test');
        if (is_array($key)) {
            $builder->where($key);
        } else {
            if ($value == null) {
                return null;
            }
            $builder->where($key, $value);
        }
        return $builder->get();
    }

    public function by_keys(array $keys = null, $value = null)
    {
        if ($keys == null) {
            return null;
        }
        $builder = db_connect()->table('data_layanan_test');
        if (is_array($keys)) {
            $builder->where($keys);
        } else {
            if ($value == null) {
                return null;
            }
            $builder->where($keys, $value);
        }
        return $builder;
    }

    public function get_by_id_layanan($id_layanan = null)
    {
        if ($id_layanan == null) {
            return null;
        }

        $builder = db_connect()->table('data_layanan_test')->where('id_layanan', $id_layanan)->get();
        return $builder->getResultArray();
    }
}
