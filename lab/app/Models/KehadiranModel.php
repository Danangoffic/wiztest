<?php

namespace App\Models;

use CodeIgniter\Model;

class KehadiranModel extends Model
{
    protected $table      = 'kehadiran';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'jenis_test',
        'id_customer',
        'id_petugas',
        'biaya'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
    public function getFilterByDateLayanan($from, $to, $type_layanan = false, $type_pemeriksaan = false, $marketing = 0)
    {
        if ($type_layanan && $type_pemeriksaan) {
            $db = db_connect();
            $FILTERING = "SELECT * FROM kehadiran 
            JOIN jenis_test jt 
            ON jt.id = kehadiran.jenis_test 
            JOIN customers 
            ON customers.id = kehadiran.id_customer 
            JOIN jenis_layanan layanan 
            ON layanan.id = customers.jenis_layanan ";
            if ($marketing == 0) {
                $builderQuery = $db->query($FILTERING . "
                                        WHERE customers.status_pembayaran = 'paid' AND customers.jenis_layanan = '$type_layanan' AND customers.jenis_pemeriksaan = '$type_pemeriksaan'
                                        AND (customers.tgl_kunjungan BETWEEN '$from' AND '$to' )");
            } elseif ($marketing == 1) {
                # code...
                $builderQuery = $db->query($FILTERING . "
                                        WHERE customers.status_pembayaran = 'paid' AND customers.jenis_layanan = '$type_layanan' AND customers.jenis_pemeriksaan = '$type_pemeriksaan'
                                        AND (customers.tgl_kunjungan BETWEEN '$from' AND '$to' ) AND customers.id_marketing = '$marketing'");
            } else {
                $builderQuery = $db->query($FILTERING . "
                                        WHERE customers.status_pembayaran = 'paid' AND customers.jenis_layanan = '$type_layanan' AND customers.jenis_pemeriksaan = '$type_pemeriksaan'
                                        AND (customers.tgl_kunjungan BETWEEN '$from' AND '$to' ) AND customers.id_marketing <> 1");
            }
            return $builderQuery;
        } else {
            return FALSE;
        }
    }

    public function getByTglAndTestType($typeTest, $tglKehadiran, $jenis_pemeriksaan = 'WALK IN', $jenis_layanan)
    {
        $db = db_connect();
        $FILTERING = "SELECT * FROM kehadiran 
            JOIN jenis_test jt 
            ON jt.id = kehadiran.jenis_test 
            JOIN customers 
            ON customers.id = kehadiran.id_customer 
            JOIN jenis_layanan layanan 
            ON layanan.id = customers.jenis_layanan ";
        $builderQuery = $db->query($FILTERING . "
            WHERE customers.status_pembayaran = 'paid' AND customers.jenis_pemeriksaan = '$typeTest' 
            AND customers.jenis_layanan = '$jenis_layanan' 
            AND customers.tgl_kunjungan = '$tglKehadiran'");
        return $builderQuery;
    }
}
