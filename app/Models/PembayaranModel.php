<?php

namespace App\Models;

use CodeIgniter\Model;

class PembayaranModel extends Model
{
    protected $table      = 'data_pembayaran';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_customer',
        'tipe_pembayaran',
        'va_number',
        'amount',
        'jenis_pembayaran',
        'status_pembayaran',
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function pembayaran_by_customer($id_customer = null)
    {
        if ($id_customer == null) {
            return null;
        }
        $builder = db_connect()->table('data_pembayaran')->where('id_customer', $id_customer)->get(1);
        return $builder->getRowArray();
    }
}
