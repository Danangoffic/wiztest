<?php

namespace App\Models;

use CodeIgniter\Model;

class QRHasilModel extends Model
{
    protected $table      = 'qr_hasil';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_hasil',
        'qr_code',
        'status'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';
    public function by_id_customer($id_customer = false)
    {
        if ($id_customer) {
            $builder = db_connect()->table('hasil_laboratorium a')->select('b.*')
                ->join('qr_hasil b', 'b.id_hasil = a.id')
                ->where('a.id_customer', $id_customer);
            return $builder->get()->getRowArray();
        } else {
            return null;
        }
    }
}
