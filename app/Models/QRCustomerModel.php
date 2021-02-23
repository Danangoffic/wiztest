<?php

namespace App\Models;

use CodeIgniter\Model;

class QRCustomerModel extends Model
{
    protected $table      = 'qr_customer';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'id_customer',
        'qr_code',
        'status'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function by_order_id($customer_unqiue = false)
    {
        if ($customer_unqiue) {
            $builder = db_connect()->table('customers a')->select("b.*")
                ->join('qr_customer b', 'b.id_customer = a.id')
                ->where('b.customer_unique', $customer_unqiue)->limit(1);
            return $builder->get()->getRowArray();
        } else {
            return null;
        }
    }

    public function by_id_customer($id_customer = false)
    {
        if ($id_customer) {
            $builder = $this->where('id_customer', $id_customer)->limit(1);
            return $builder->get()->getRowArray();
        } else {
            return null;
        }
    }

    public function check_data(array $keys_val = null)
    {
        if ($keys_val != null) {
            $builder = db_connect()->table($this->table)->where($keys_val);
            return $builder->get();
        } else {
            return null;
        }
    }
}
