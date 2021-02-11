<?php

namespace App\Controllers\backoffice;

use App\Models\KotaModel;
use App\Models\LokasiPenginputanModel;
use App\Models\UserDetailModel;
use App\Models\UserLevelModel;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel;

class User extends ResourceController
{
    public $session;
    public $userModel;
    protected $userDetailModel;
    protected $userLevelModel;
    protected $lokasiModel;
    protected $kotaModel;
    public function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = new UserModel();
        $this->userDetailModel = new UserDetailModel();
        $this->userLevelModel = new UserLevelModel();
        $this->lokasiModel = new LokasiPenginputanModel();
        $this->kotaModel = new KotaModel();
        // if()
    }
    public function index()
    {
        if (!$this->session->get('id_user')) {
            return redirect()->to('/backoffice/login');
        }
        $data = [
            'users' => $this->userModel->findAll(),
            'user_detail' => $this->userDetailModel,
            'user_level' => $this->userLevelModel,
            'lokasi_input' => $this->lokasiModel,
            'kota_user' => $this->kotaModel,
            'title' => "Data User",
            'page' => 'user',
            'session' => $this->session
        ];
        return view('backoffice/user/index_user', $data);
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
        if ($this->session->has('logged_in')) {
            echo $this->session->get('id_user');
        }
        $data = [
            'session' => $this->session,
            'validation' => \config\Services::validation()
        ];
        return view('backoffice/user/login', $data);
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
            $this->session->setFlashdata('error', 'Login gagal');
            // return $this->respond($result, 400, 'Bad Request');
            return redirect()->to('/backoffice/login')->withInput();
        }

        try {
            // echo "setelah  try";
            // exit();
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            // dd($password);
            $getUser = $this->userModel->loginUser1($email, $password);
            // dd(db_connect()->showLastQuery());

            $db_email = $getUser['email'];
            $db_password = $getUser['password'];
            if ($db_email != $email || $db_password != md5($password)) {
                $this->session->setFlashdata('error', 'Gagal login, username dan password tidak sesuai');
                return redirect()->to('/backoffice/login')->withInput();
            }
            // dd($getUser);
            if ($getUser) {
                // $session = session();
                $id = $getUser['id'];
                $detail_user = $this->userModel->detailById($id)->getFirstRow();
                if (!$detail_user) {
                    $this->session->setFlashdata('error', 'Gagal login');
                    return redirect()->to('/backoffice/login')->withInput();
                }

                $user_level = intval($getUser['user_level']);
                $newdata = array(
                    'email'     => $email,
                    'id_user' => $id,
                    'time' => date('YmdHis' . rand(100, 200)),
                    'nama' => $detail_user->nama,
                    'logged_in' => TRUE,
                    'user_level' => $user_level
                );
                $this->session->set($newdata);
                $this->session->setFlashdata('success', 'Sukses login');

                if ($user_level == null) {
                    $this->session->setFlashdata("error", "Gagal login");
                    return redirect()->to("/backoffice/login");
                }
                /**
                 * 
                 * user level access here
                 */
                echo 'cek user level ' . $user_level;
                if ($user_level == 1 || $user_level == 99 || $user_level == 103 || $user_level == 104) {
                    return redirect()->to('/backoffice');
                } else if ($user_level == 100) {
                    return redirect()->to('/swabber');
                } else if ($user_level == 101) {
                    return redirect()->to('/backoffice/finance/instansi');
                } else if ($user_level == 102 || $user_level == 8) {
                    return redirect()->to('/backoffice/laboratorium/validasi');
                } else if ($user_level == 2) {
                    return redirect()->to('/backoffice/frontoffice/walkin');
                } else if ($user_level == 4 || $user_level == 6) {
                    return redirect()->to('/backoffice/reception');
                } else if ($user_level == 7) {
                    return redirect()->to('/backoffice/dokter');
                }
            } else {
                $this->session->setFlashdata('error', 'Gagal login');
                return redirect()->to('/backoffice')->withInput();
            }
        } catch (\Throwable $th) {
            //throw $th;
            $this->session->setFlashdata('error', 'Gagal login karena ' . $th->getMessage() . " file " . $th->getFile() . " code " . $th->getCode());
            return redirect()->to('/backoffice/login')->withInput();
        }
    }



    public function logout()
    {
        $this->session->destroy();
        $this->session->start();
        $this->session->setFlashdata('success', 'Berhasil keluar');
        return redirect()->to('/backoffice/login');
    }

    public function create_user()
    {
        # code...
        // $validation =  \Config\Services::validation();
        $data = [
            'kota' => $this->kotaModel->findAll(),
            'level_user' => $this->userLevelModel->findAll(),
            'title' => "Tambah Data User",
            'page' => "user",
            'session' => $this->session,
            'validation' => \Config\Services::validation()
        ];
        return view('backoffice/user/create_user', $data);
    }

    // proses tambah user
    public function save()
    {
        # code...
        // $inputValidation = ;
        // $input = $validate->setRules();
        if (!$this->validate([
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email wajib diisi',
                    'valid_email' => '{field} wajib diisi dengan format email menggunakan tanda \'@\'',
                    'is_unique' => '{field} sudah ada',
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
                'errors' => [
                    'required' => '{field} wajib diisi',
                    'min_length' => '{field} wajib diisi setidaknya 6 karakter'
                ]
            ],
            'level' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} user wajib dipilih'
                ]
            ],
            'nama' => [
                'rules' => 'required|min_length[5]',
                'errors' => [
                    'required' => '{field} wajib diisi',
                    'min_length' => '{field} wajib diisi setidaknya 5 karakter'
                ]
            ],
        ])) {
            // $result = [
            //     'responseMessage' => 'failed',
            //     'errors' => $this->validator->getErrors()
            // ];
            $this->session->setFlashdata('error', 'Gagal tambah data user');
            return redirect()->to('/backoffice/user/create_user')->withInput();
            // return redirect()->to('/backoffice/registration')->withInput();
        }
        try {
            $nama = $this->request->getPost('nama');
            $email = $this->request->getPost('email');
            $password = md5($this->request->getPost('password'));
            $user_level = $this->request->getPost('level');
            $phone = $this->request->getPost('phone');
            $lokasi = $this->request->getPost('lokasi');
            $created_by = $this->session->get('id_user');

            $saving_user = $this->userModel->save([
                'email' => $email,
                'password' => $password,
                'user_level' => $user_level,
                'created_by' => $created_by,
                'updated_by' => $created_by
            ]);
            $id_user = $this->userModel->getInsertID();

            $user_detail = $this->userDetailModel->save([
                'id_user' => $id_user,
                'nama' => $nama,
                'id_lokasi' => $lokasi,
                'phone' => $phone,
                // 'created_by' => $created_by,
                // 'updated_by' => $created_by
            ]);

            if ($saving_user && $user_detail) {
                $this->session->setFlashdata('success', 'Berhasil tambah data user');
                return redirect()->to('/backoffice/user');
            } else {
                $this->session->setFlashdata('error', 'Gagal tambah data user ' . db_connect()->error());
                return redirect()->to('/backoffice/user/create_user')->withInput();
            }
        } catch (\Throwable $th) {
            //throw $th;
            $result = [
                'responseMessage' => 'error ' . $th->getMessage(),
                'data' => null
            ];
            $this->session->setFlashdata('error', 'Gagal tambah data user ' . $th->getMessage());
            return redirect()->to('/backoffice/user/create_user')->withInput();
            // return $this->respond($result, 500);
        }
    }

    public function edit_user($id)
    {
        $data = [
            'kota' => $this->kotaModel->findAll(),
            'level_user' => $this->userLevelModel->findAll(),
            'title' => "Tambah Data User",
            'page' => "user",
            'session' => $this->session,
            'user' => $this->userModel->find($id),
            'user_detail' => $this->userDetailModel->where(['id_user' => $id])->first(),
            'validation' => \Config\Services::validation()
        ];
        return view('backoffice/user/edit_user', $data);
    }

    public function update_user()
    {
        $id_user = $this->request->getPost('id_user');
        $id_detail_user = $this->request->getPost('id_detail_user');
        $session_user = $this->session->get('id_user');
        if (!$session_user) {
            $this->session->setFlashdata('error', 'Gagal ubah data user, anda belum login');
            return redirect()->to('/backoffice/user')->withInput();
        }
        try {
            $user = $this->userModel->find($id_user);
            $detail_user = $this->userDetailModel->find($id_detail_user);
            if (is_array($user) && is_array($detail_user)) {
                $password = $this->request->getPost('password');
                $old_password = $this->request->getPost('old_password');
                $nama = $this->request->getPost('nama');
                $id_lokasi = $this->request->getPost('lokasi');
                $level = $this->request->getPost('level');
                $email = $this->request->getPost('email');
                $phone = $this->request->getPost('phone');
                $user_array = [
                    'email' => $email,
                    'user_level' => $level,
                    'updated_by' => $session_user
                ];
                if (!$password || $password == "" || $password == null) {
                    $user_array['password'] = $old_password;
                } else {
                    $user_array['password'] = md5($password);
                }
                $detail_user_array = array(
                    'nama' => $nama,
                    'phone' => $phone,
                    'id_lokasi' => $id_lokasi
                );
                $update1 = $this->userModel->update($id_user, $user_array);
                $update2 = $this->userDetailModel->update($id_detail_user, $detail_user_array);
                if ($update1 && $update2) {
                    $this->session->setFlashdata('success', 'Berhasil ubah data user');
                    return redirect()->to('/backoffice/user');
                } else {
                    $this->session->setFlashdata('error', 'Gagal ubah data user');
                    return redirect()->to('/backoffice/user/edit_user/' . $id_user)->withInput();
                }
            } else {
                $this->session->setFlashdata('error', 'Gagal ubah data user karena user tidak ditemukan');
                return redirect()->to('/backoffice/user/edit_user/' . $id_user)->withInput();
            }
        } catch (\Throwable $th) {
            $this->session->setFlashdata('error', 'Gagal tambah data user ' . $th->getMessage());
            return redirect()->to('/backoffice/user/edit_user/' . $id_user)->withInput();
        }
    }

    public function delete_user($id)
    {
        # code...
    }

    public function doDelete()
    {
        # code...
    }

    //--------------------------------------------------------------------

}
