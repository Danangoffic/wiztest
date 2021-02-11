<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table      = 'users';
    // protected $primaryKey = 'id';

    // protected $returnType     = 'array';
    // protected $useSoftDeletes = true;

    protected $allowedFields = ['email', 'password', 'user_level', 'created_by', 'updated_by'];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    public function findByUsername($email = false)
    {
        if ($email) {
            return $this->where(['email' => $email])->first();
        } else {
            return $this->findAll();
        }
    }

    public function loginUser1($email, $password)
    {
        if ($email && $password) {
            $builder = db_connect()->table($this->table)->where('email', $email)->where('password', md5($password))->limit(1);
            return $builder->get()->getFirstRow('array');
        } else {
            return false;
        }
    }

    public function detailById($idUser = false)
    {
        if (!$idUser) {
            return false;
        } else {
            $db = db_connect();
            $builder = $db->table('users');
            return $builder->select("*")->join('users_detail', 'users_detail.id_user = users.id')->where(['users.id' => $idUser])->get();
            // return $query->get();
        }
    }

    public function detailByUsername($userName = false)
    {
        if (!$userName) {
            return false;
        } else {
            $db = \Config\Database::connect();
            $builder = $db->table('users');
            return $builder->select("*")->join('users_detail detail', 'detail.id_user = users.id')->where(['users.username' => $userName])->get();
        }
    }

    public function crud_users_detail(string $type = "read", $idUser = null, $data = null)
    {
        # code...
        $db = db_connect();
        if ($type == "read" && $idUser) {
            $builder = $db->table('users');
            return $builder->select("*")->join('users_detail detail', 'detail.id_user = users.id')->where('users.id', $idUser, true)->get();
        } elseif ($type == "create" && $data) {
            # code...
            return $db->table('users_detail')->insert($data);
        } elseif ($type == "update" && $data && $idUser) {
            return $db->table('users_detail')->where('id_user', $idUser, true)->update($data);
        } elseif ($type == "delete" && $idUser) {
            # code...
            return $db->table('users_detail')->delete('id_user', $idUser);
        } else {
            return false;
        }
    }

    public function update_detail($idUser = null, $data = null)
    {
        if ($idUser == null && $data == null) {
            return false;
        } else {
            return $this->db->table('users_detail')->update($data, ['id_user' => $idUser]);
        }
    }

    public function get_by_user_level($user_level = null)
    {
        if ($user_level == null) {
            return null;
        }
        $builder = db_connect()->table($this->table)->where('user_level', $user_level);
        return $builder;
    }
}
