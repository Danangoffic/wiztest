<?php

namespace App\Controllers\backoffice;

use App\Models\CustomerModel;
use App\Models\DokterModel;
use App\Models\FaskesModel;
use App\Models\KotaModel;
use App\Models\KuotaModel;
use App\Models\PemeriksaanModel;
use CodeIgniter\Controller;
use App\Controllers\backoffice\User;
use App\Controllers\backoffice\Layanan;
use App\Models\UserDetailModel;

// use App\Controllers;
// use CodeIgniter\Controller;

class Dokter extends Controller
{
    public $session;
    protected $dokterModel;
    protected $kotaModel;
    protected $userC;
    protected $layananC;
    protected $detailUserModel;
    public function __construct()
    {
        $this->dokterModel = new DokterModel();
        $this->userC = new User;
        $this->layananC = new Layanan;
        $this->detailUserModel = new UserDetailModel();
        // $this->kotaModel = new KotaModel();
        $this->session = \Config\Services::session();
    }
    public function index()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Dokter',
            'page' => 'dokter',
            'data' => $this->dokterModel->findAll(),
            // 'kota' => $this->kotaModel,
            'session' => $this->session,
            'user' => $this->userC->userModel
        );
        // dd($this->session->get('nama'));
        return view('backoffice/dokter/index_dokter', $data);
    }

    public function create()
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data = array(
            'title' => 'Tambah Data Dokter',
            'page' => 'dokter',
            // 'kota' => $this->kotaModel,
            'validation' => \Config\Services::validation(),
            'session' => session(),
            'user' => $this->userC->userModel
        );
        // dd($this->session->get('nama'));
        return view('backoffice/dokter/create_dokter', $data);
    }

    public function save()
    {
        // dd($this->request->getPost());
        $validation_input = $this->validate([
            'nama' => [
                'rules' => 'required',
                'errors' => '{field} lengkap dokter harus diisi'
            ],
            'email' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi'
                ]
            ]
        ]);
        // dd($this->validator);
        if (!$validation_input) {
            return redirect()->to('/backoffice/dokter/create')->withInput();
        }
        $namattd = "";
        if ($this->request->getFile('img_ttd')) :
            $img_ttd = $this->request->getFile('img_ttd');

            if ($img_ttd->getError() == 4) {
                $namattd = "";
            } else {
                //generate name with random name
                $namattd = $img_ttd->getRandomName();
                //move file ke folder img with new name
                $img_ttd->move('assets/dokter', $namattd);
            }
        endif;
        // dd($this->session->get('id_user'));
        $email = $this->request->getpost('email');
        $password = $this->request->getpost('password');
        $nama = $this->request->getpost('nama');
        $phone = $this->request->getpost('phone');
        $level_user = $this->request->getPost('level_user');
        $user_id = null;
        if ($email != '' && $password != '') {
            $insert_user = array(
                'email' => $email,
                'password' => md5($password),
                'user_level' => $level_user,
                'created_by' => $this->session->get('id_user'),
                'updated_by' => $this->session->get('id_user')
            );
            $inserting_user = $this->userC->userModel->insert($insert_user);
            if ($inserting_user) {
                $user_id = $this->userC->userModel->getInsertID();
                $detail_array = array(
                    'nama' => $nama,
                    'phone' => $phone,
                    'id_lokasi' => '1',
                    'id_user' => $user_id
                );
                $insert_detail = $this->detailUserModel->insert($detail_array);
                if (!$insert_detail) {
                    $this->userC->userModel->delete($user_id);
                    $this->session->setFlashdata('error', 'Gagal Tambahkan data dokter');
                    return redirect()->to('/backoffice/dokter/create')->withInput();
                }
            }
        }
        // $url_qrcode = $this->layananC->getUrlQRCode(base_url('backoffice/dokter/'))
        $insert_dokter = array(
            'nama'  => $nama,
            'phone' => $phone,
            'id_user' => $user_id,
            'img_ttd' => $namattd
        );
        $insert_dokter = $this->dokterModel->insert($insert_dokter);
        $id_dokter = $this->dokterModel->getInsertID();
        $url_qrcode = $this->layananC->getUrlQRCode(base_url('assets/dokter/' . $namattd));
        $array_update = array('qrcode_ttd' => $url_qrcode);
        $update = $this->dokterModel->update($id_dokter, $array_update);
        if ($update) {
            session()->setFlashdata('success', 'Berhasil tambah data dokter');
            return redirect()->to('/backoffice/dokter');
        } else {
            session()->setFlashdata('error', 'Gagal tambah data dokter');
            return redirect()->to('/backoffice/dokter')->withInput();
        }
    }

    public function detail($id_dokter)
    {
        # code...
    }

    public function edit(int $id_dokter)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data_dokter = $this->dokterModel->find($id_dokter);
        $data = array(
            'title' => 'ubah Data Dokter',
            'page' => 'dokter',
            'data_dokter' => $data_dokter,
            'data_user' => $this->userC->userModel->find($data_dokter['id_user']),
            'id' => $id_dokter,
            'validation' => \Config\Services::validation(),
            // 'kota' => $this->kotaModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/dokter/edit_dokter', $data);
    }

    public function update(int $id_dokter)
    {

        $data_dokter = $this->dokterModel->find($id_dokter);
        $id_user_dokter = $data_dokter['id_user'];
        if ($id_user_dokter == '' || $id_user_dokter == null) {
            $this->session->setFlashdata('error', 'Gagal mengubah data');
            return redirect()->to('/backoffice/dokter/edit/' . $id_dokter)->withInput();
        }

        $validation_input = $this->validate([
            'email_dokter' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '{field} wajib diisi'
                ]
            ],
            'nama' => [
                'rules' => 'required',
                'errors' => '{field} lengkap dokter harus diisi'
            ],
            'img_ttd' => [
                'rules' => 'max_size[img_ttd,1024]|is_image[img_ttd]|mime_in[img_ttd,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran gambar terlalu besar',
                    'is_image' => 'Yang anda pilih bukan gambar',
                    'mime_in' => 'Yang anda pilih bukan gambar',
                ]
            ]
        ]);
        if (!$validation_input) {
            $this->session->setFlashdata('error', "Gagal mengubah data dokter");
            return redirect()->to('/backoffice/dokter/edit/' . $id_dokter)->withInput();
        }
        $email = $this->request->getPost('email_dokter');
        $password = ($this->request->getPost('password_dokter')) ? $this->request->getPost('password_dokter') : '';
        $nama = $this->request->getPost('nama');
        $phone = $this->request->getPost('phone');
        $user_id = null;
        $img_ttd = $this->request->getFile('img_ttd');
        $old_img_ttd = $this->request->getPost('old_img_ttd');
        if ($img_ttd->getError() == 4) {
            $namattd = $old_img_ttd;
        } else {
            //generate name with random name
            $namattd = str_replace('.', '', str_replace(',', '', str_replace(' ', '_', $nama))) . $img_ttd->getRandomName();
            //move file ke folder img with new name
            $img_ttd->move('assets/dokter', $namattd);
            if ($old_img_ttd || $old_img_ttd !== "" || $old_img_ttd !== null) {
                unlink('assets/dokter/' . $this->request->getPost('old_img_ttd'));
            }
        }
        $url_qrcode = $this->layananC->getUrlQRCode(base_url('assets/dokter/' . $namattd));
        $update_user = array();
        if ($email != '' && $password != '') {
            $update_user = array(
                'email' => $email,
                'password' => md5($password),
                'created_by' => session('id'),
                'updated_by' => session('id')
            );
        } else if ($email !== "" && $password == '') {
            $update_user = array(
                'email' => $email,
                'created_by' => session('id'),
                'updated_by' => session('id')
            );
        }
        $this->userC->userModel->update($id_user_dokter, $update_user);

        // $url_qrcode = $this->layananC->getUrlQRCode(base_url('backoffice/dokter/'))
        $data_dokter = array(
            'nama'  => $nama,
            'phone' => $phone,
            'user_id' => $user_id,
            'img_ttd' => $namattd,
            'qrcode_ttd' => $url_qrcode
        );
        $update_dokter = $this->dokterModel->update($id_dokter, $data_dokter);

        if ($update_dokter) {
            $this->session->setFlashdata('success', 'Berhasil ubah data dokter');
            return redirect()->to('/backoffice/dokter');
        } else {
            $this->session->setFlashdata('error', 'Gagal ubah data dokter');
            return redirect()->to('/backoffice/dokter')->withInput();
        }
    }

    public function delete(int $id_dokter)
    {
        // session_destroy();
        if (!$this->session->has('logged_in')) {
            return redirect()->to('/backoffice/login');
        }
        $data_dokter = $this->dokterModel->find($id_dokter);
        $data = array(
            'title' => 'ubah Data Dokter',
            'page' => 'dokter',
            'data_dokter' => $data_dokter,
            'data_user' => $this->userC->userModel->find($data_dokter['id_user']),
            'id' => $id_dokter,
            // 'kota' => $this->kotaModel,
            'session' => session()
        );
        // dd($this->session->get('nama'));
        return view('backoffice/dokter/delete_dokter', $data);
    }

    public function do_delete()
    {
        $id_dokter = $this->request->getPost('id_dokter');
        $findDataDokter = $this->dokterModel->find($id_dokter);
        if ($findDataDokter) {
            $user_dokter = $this->userC->userModel->find($findDataDokter['id_user']);
            if ($user_dokter) {
                $this->dokterModel->delete($id_dokter);
            }
            $source = 'assets/dokter/';
            if ($findDataDokter['img_ttd'] !== "")
                unlink($findDataDokter['img_ttd'], $source);
            $id_user_dokter = $user_dokter['id'];
            $this->userC->userModel->delete($id_user_dokter);
            $this->session->setFlashdata('success', 'Berhasil menghapus data dokter');
            return redirect()->to('/backoffice/dokter');
        } else {
            $this->session->setFlashdata('error', 'Gagal menghapus data dokter');
            return redirect()->to('/backoffice/dokter');
        }
    }
}
