<?php

namespace App\Controllers;

use App\Models\MasterUserModel;
use App\Models\MasterPegawaiModel;
use App\Models\MasterEs3Model;
use App\Models\MasterEs4Model;

class masterUser extends BaseController
{
    protected $masterUserModel;
    protected $masterPegawaiModel;
    protected $masterEs3Model;
    protected $masterEs4Model;


    public function __construct()
    {
        $this->masterUserModel = new masterUserModel();
        $this->masterPegawaiModel = new masterPegawaiModel();
        $this->masterEs3Model = new MasterEs3Model();
        $this->masterEs4Model = new MasterEs4Model();
    }

    public function profile()
    {
        $data_profil_user = $this->masterUserModel->getProfilUser(session('user_id'));
        $data_pegawai_user = $this->masterPegawaiModel->getProfilPegawai($data_profil_user['nip_lama_user']);

        $data = [
            'title' => 'Profile User',
            'menu' => '',
            'subMenu' => '',
            'list_level' => session('list_user_level'),
            'data_profil_user' => $data_profil_user,
            'data_pegawai_user' => $data_pegawai_user,
            'list_bidang' => $this->masterEs3Model->getAllBidang(),
            'list_seksi' => $this->masterEs4Model->getAllSeksi()
        ];
        // dd($data);

        return view('Profile/index', $data);
    }

    public function gantiPasswordByUser()
    {
        $user = $this->masterUserModel->getProfilUser(session('user_id'));


        $password_lama = $this->request->getVar('password_lama');
        $password_baru = $this->request->getVar('password_baru');


        if (password_verify($password_lama, $user['password'])) {

            $lower_pass = strtolower($password_baru);
            $pass_baru = password_hash($lower_pass, PASSWORD_DEFAULT);


            $this->masterUserModel->save([
                'id' => intval(session('user_id')),
                'username' => $user['username'],
                'fullname' => $user['fullname'],
                'email' => $user['email'],
                'password' => $pass_baru,
                'token' => '',
                'image' => $user['image'],
                'nip_lama_user' => $user['nip_lama_user'],
                'is_active' => $user['is_active'],
            ]);
            session()->setFlashdata('pesan', 'Ganti Password Berhasil');
            session()->setFlashdata('icon', 'success');
        } else {
            return redirect()->to('/dashboard');
        }


        return redirect()->to('/profile');
    }
    public function updateProfileByUser()
    {
        $id_user = $this->request->getVar('id_profile_user');
        $password = $this->request->getVar('password_user');
        $token = $this->request->getVar('token');
        $nip_lama_user = $this->request->getVar('nip_lama_user');
        $is_active = $this->request->getVar('is_active');
        $username = $this->request->getVar('username');
        $nama_lengkap = $this->request->getVar('nama');
        $email = $this->request->getVar('email');
        $image_user_baru = $this->request->getFile('image_user_baru');
        $image_user_lama = $this->request->getVar('image_user_lama');


        $data_user = session('data_user');
        $nip_lama = $data_user['nip_lama_user'];
        $dirname = 'images/profil/' . $nip_lama;

        if (!file_exists($dirname)) {

            if ($image_user_baru->getError() == 4) {
                $nama_image = $image_user_lama;
            } else {
                if ($image_user_lama != 'default.png' && $image_user_lama != 'default.jpg') {
                    unlink('images/profil/' . $image_user_lama);
                }
                $ekstensi = $image_user_baru->getExtension();
                $nama_image = ($nip_lama . '.' . $ekstensi);
                $image_user_baru->move('images/profil/', $nama_image);
            }
        }
        $this->masterUserModel->save([
            'id' => $id_user,
            'username' => $username,
            'fullname' => $nama_lengkap,
            'email' => $email,
            'password' => $password,
            'token' => $token,
            'image' => $nama_image,
            'nip_lama_user' => $nip_lama_user,
            'is_active' => $is_active,
        ]);

        if (session('user_id') == $id_user) {

            $user = $this->masterUserModel->getUser($username);

            $data1 = [
                'log' => TRUE,
                'user_id' => session('user_id'),
                'level_id' => session('level_id'),
                'list_user_level' => session('list_user_level'),
                'list_menu'  => session('list_menu'),
                'list_submenu' => session('list_submenu'),
                'fullname' => $user['fullname'],
                'data_user' => $user
            ];
            session()->set($data1);
        }

        session()->setFlashdata('pesan', 'Update Profile Berhasil');
        session()->setFlashdata('icon', 'success');
        return redirect()->to('/profile');
    }
}
