<?php

namespace App\Controllers;

use App\Models\MasterUserModel;
use App\Models\MasterAksesUserLevelModel;


class masterAkses extends BaseController
{
    protected $masterUserModel;
    protected $masterAksesUserLevelModel;

    public function __construct()
    {
        $this->masterUserModel = new masterUserModel();
        $this->masterAksesUserLevelModel = new masterAksesUserLevelModel();
    }

    public function index()
    {
        $alert = false;
        $data = [
            'alert' => $alert,
        ];
        return view('siphp/login', $data);
    }

    public function open()
    {
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $this->masterUserModel->getUser($username);


        $pass_default =  password_hash('123456', PASSWORD_DEFAULT);



        if ($user == NULL) {
            session()->setFlashdata('pesan', 'Username Anda Salah');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/');
        }


        $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($user['id']);
        $level_id = $list_user_level[count($list_user_level) - 1]['level_id'];
        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu($level_id, $user['id']);
        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu($level_id, $user['id']);
        if (password_verify($password, $user['password'])) {

            if (password_verify($password, $pass_default)) {
                $alert = false;
                $data = [
                    'alert' => $alert,
                    'data_user' => $user
                ];
                return view('siphp/gantiPassword', $data);
            }


            if ($user['is_active'] == 'Y') {
                $data = [
                    'log' => TRUE,
                    'user_id' => $user['id'],
                    'level_id' => $level_id,
                    'list_user_level' => $list_user_level,
                    'list_menu'  => $list_menu,
                    'list_submenu' => $list_submenu,
                    'fullname' => $user['fullname'],
                    'data_user' => $user
                ];
            } else {
                session()->setFlashdata('pesan', 'Akun Tidak Aktif');
                session()->setFlashdata('icon', 'error');
                return redirect()->to('/');
            }




            session()->set($data);
            session()->setFlashdata('pesan', 'berhasil login');
            return redirect()->to('/dashboard');
        }
        session()->setFlashdata('pesan', 'Password salah');
        session()->setFlashdata('icon', 'error');
        return redirect()->to('/');
    }

    public function switchLevel()
    {
        $id = $this->request->getVar('id');

        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu($id, session('user_id'));
        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu($id, session('user_id'));

        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => $id,
            'list_user_level' => session('list_user_level'),
            'list_menu'  => $list_menu,
            'list_submenu' => $list_submenu,
            'fullname' => session('fullname'),
            'data_user' => session('data_user')

        ];

        session()->set($data1);


        return redirect()->to('/dashboard');
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        session()->setFlashdata('pesan', 'Berhasil Logout');
        session()->setFlashdata('icon', 'success');
        return redirect()->to('/');
    }


    public function gantiPasswordDefault()
    {
        $user_id = $this->request->getVar('user_id');
        $pass_baru = $this->request->getVar('password_baru');
        $confirm_pass = $this->request->getVar('confirm_password');
        $user = $this->masterUserModel->getProfilUser($user_id);

        if ($pass_baru == $confirm_pass && $pass_baru == '123456') {
            //alert gagal ubah password 
            $alert = true;
            $data = [
                'alert' => $alert,
                'data_user' => $user
            ];

            return view('siphp/gantiPassword', $data);
        }

        if ($pass_baru == $confirm_pass) {
            $pass_baru_hash = password_hash($pass_baru, PASSWORD_DEFAULT);

            $this->masterUserModel->save([
                'id' => $user['id'],
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'email' => $user['email'],
                'password' => $pass_baru_hash,
                'token' => '',
                'image' => $user['image'],
                'nip_lama_user' => $user['nip_lama_user'],
                'is_active' => $user['is_active'],
            ]);

            $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($user['id']);
            $level_id = $list_user_level[count($list_user_level) - 1]['level_id'];
            $list_menu = $this->masterAksesUserLevelModel->getAksesMenu($level_id, $user['id']);
            $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu($level_id, $user['id']);

            if ($user['is_active'] == 'Y') {
                $data = [
                    'log' => TRUE,
                    'user_id' => $user['id'],
                    'level_id' => $level_id,
                    'list_user_level' => $list_user_level,
                    'list_menu'  => $list_menu,
                    'list_submenu' => $list_submenu,
                    'fullname' => $user['fullname'],
                    'data_user' => $user
                ];
            } else {
                session()->setFlashdata('pesan', 'Akun Tidak Aktif');
                session()->setFlashdata('icon', 'error');
                return redirect()->to('/');
            }

            session()->set($data);
            session()->setFlashdata('pesan', 'berhasil login');
            return redirect()->to('/dashboard');
            // ///alert berhasil ubah password
            // session()->setFlashdata('pesan', 'Password berhasil diubah!');
            // session()->setFlashdata('pesan_text', 'Silahkan login kembali');
            // session()->setFlashdata('icon', 'success');
            // return redirect()->to('/');
        } else {
            //alert gagal ubah password 
            $alert = true;
            $data = [
                'alert' => $alert,
                'data_user' => $user
            ];

            return view('siphp/gantiPassword', $data);
        }
    }
}
