<?php

namespace App\Controllers\backoffice;

use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel;
use CodeIgniter\Controller;
use PDO;

class User extends ResourceController
{
    public $session;
    public $userModel;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = new UserModel();
        // if()
    }
    public function index()
    {
        return view('welcome_message');
    }

    public function detailById()
    {

        $id_user = $this->request->getGet('id_user');
        try {
            //code...
            $result = $this->userModel->detailById($id_user);
            // echo "Masuk";
            if ($result || count($result) > 0) {
                $result = ['data' => $this->userModel->detailById($id_user), 'responseMessage' => 'success'];
                return $this->respond($result, 200);
                // echo json_encode($result);
            } else {
                $result = ['responseMessage' => 'Not found'];
                return $this->respond($result, 404);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $result = ['responseMessage' => 'error ' . $th->getMessage()];
            return $this->respond($result, 500);
        }
    }

    public function login()
    {
        # code...
        return view('backoffice/user/login');
    }

    // proses login
    public function doLogin()
    {
        $input = $this->validate([
            'email' => 'required|valid_email',
            'password' => 'required'
        ]);
        if (!$input) {
            $result = [
                'responseMessage' => 'failed',
                'errors' => $this->validator->getErrors()
            ];
            return $this->respond($result, 400, 'Bad Request');
            // return redirect()->to('/backoffice/registration')->withInput();
        }
        try {
            //code...
            $email = $this->request->getVar('email');
            $password = md5($this->request->getVar('password'));
            $getUser = $this->userModel->loginUser1($email, $password);
            if ($getUser) {
                $session = session();
                $id = $getUser['id'];
                $detail_user = $this->userModel->detailById($id)->getFirstRow();
                // $dbCon = db_connect();
                // echo $dbCon->showLastQuery();
                // dd($detail_user);
                $newdata = [
                    'email'     => $email,
                    'id_user' => $id,
                    'time' => date('YmdHis' . rand(100, 200)),
                    'nama' => $detail_user->nama,
                    'logged_in' => TRUE
                ];
                $session->set($newdata);
                return redirect()->to('/backoffice');
            }
        } catch (\Throwable $th) {
            //throw $th;
            session()->setFlashdata('error', 'Gagal login');
            echo "error " . $th->getMessage();
            return redirect()->to('backoffice')->withInput();
        }
    }

    public function logout()
    {
        session_destroy();
        return redirect()->to('backoffice');
    }

    public function create()
    {
        # code...
        // $validation =  \Config\Services::validation();

    }

    // proses tambah user
    public function doCreate()
    {
        # code...
        $input = $this->validate([
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'user_level' => 'required',
            'created_by' => 'required',
            'nama' => 'required|min_length[5]',
        ]);
        // $input = $validate->setRules();
        if (!$input) {
            $result = [
                'responseMessage' => 'failed',
                'errors' => $this->validator->getErrors()
            ];
            return $this->respond($result, 400, 'Bad Request');
            // return redirect()->to('/backoffice/registration')->withInput();
        }
        try {

            $saving_user = $this->userModel->save([
                'email' => $this->request->getVar('email'),
                'password' => md5($this->request->getVar('password')),
                'user_level' => $this->request->getVar('user_level'),
                'created_by' => $this->request->getVar('created_by')
            ]);

            $id_created = $this->userModel->getInsertID();
            $detailUser = ['id_user' => $id_created, 'nama' => $this->request->getVar('nama'), 'alamat' => $this->request->getVar('alamat'), 'created_at' => date('Y-m-d H:i:s')];
            $saving_detail = $this->userModel->crud_users_detail('create', $id_created, $detailUser);
            // dd($saving_detail);
            $detail_user = $this->userModel->detailById($id_created);
            if ($saving_user && $saving_detail && $detail_user) {
                $result = [
                    'responseMessage' => 'success',
                    'data' => $detail_user
                ];
                return $this->respondCreated($result, 'success');
            } else {
                $result = [
                    'responseMessage' => 'failed ',
                    'data' => null
                ];
                return $this->respond($result, 400);
            }
        } catch (\Throwable $th) {
            //throw $th;
            $result = [
                'responseMessage' => 'error ' . $th->getMessage(),
                'data' => null
            ];
            return $this->respond($result, 500);
        }
    }

    public function updateUser()
    {
        # code...
    }

    // proses update
    public function doUpdate()
    {
        # code...
    }

    public function doDelete()
    {
        # code...
    }

    //--------------------------------------------------------------------

}
