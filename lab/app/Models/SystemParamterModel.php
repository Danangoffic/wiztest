<?php

namespace App\Models;

use CodeIgniter\Model;

class SystemParameterModel extends Model
{
    protected $table      = 'system_parameter';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = [
        'vgroup',
        'parameter',
        'value',
        'status',
        'created_by',
        'updated_by'
    ];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function getByVgroupAndParamter($vgroup = false, $parameter = false)
    {
        if ($vgroup && $parameter) {
            return $this->where(['vgroup' => $vgroup, 'paramter' => $parameter])->first();
        } else {
            return FALSE;
        }
    }
}
