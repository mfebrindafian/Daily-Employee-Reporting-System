<?php

namespace App\Controllers;

use App\Models\MasterPegawaiModel;
use App\Models\MasterUserModel;
use App\Models\MasterUserLevelModel;
use App\Models\MasterAksesUserLevelModel;
use App\Models\MasterEs3Model;
use App\Models\MasterGolonganModel;
use App\Models\MasterJabatanModel;
use App\Models\MasterPendidikanModel;
use App\Models\MasterSatkerModel;
use App\Models\MasterEs4Model;
use App\Models\MasterFungsionalModel;


class masterKelolaMaster extends BaseController
{
    protected $masterKelolaMasterModel;
    protected $masterPegawaiModel;
    protected $masterUserModel;
    protected $masterUserLevelModel;
    protected $masterAksesUserLevelModel;
    protected $masterEs3Model;
    protected $masterGolonganModel;
    protected $masterJabatanModel;
    protected $masterPendidikanModel;
    protected $masterSatkerModel;
    protected $masterEs4Model;
    protected $masterFungsionalModel;

    public function __construct()
    {
        $this->masterUserModel = new masterUserModel();
        $this->masterUserLevelModel = new masterUserLevelModel();
        $this->masterAksesUserLevelModel = new masterAksesUserLevelModel();
        $this->masterPegawaiModel = new MasterPegawaiModel();
        $this->masterEs3Model = new MasterEs3Model();
        $this->masterGolonganModel = new MasterGolonganModel();
        $this->masterJabatanModel = new MasterJabatanModel();
        $this->masterPendidikanModel = new MasterPendidikanModel();
        $this->masterSatkerModel = new MasterSatkerModel();
        $this->masterEs4Model = new MasterEs4Model();
        $this->masterFungsionalModel = new MasterFungsionalModel();
    }

    public function masterUser()
    {
        $list_user = $this->masterUserModel->getAllUser();
        $list_pegawai = $this->masterPegawaiModel->getAllPegawai();
        $level_tersedia = $this->masterUserLevelModel->getAlllevel();



        $data = [
            'title' => 'Master User',
            'menu' => 'Kelola Master',
            'subMenu' => 'Master User',
            'list_user' => $list_user,
            'list_pegawai' => $list_pegawai,
            'level_tersedia' => $level_tersedia,
            'show_data_user' => NULL,
            'show_list_level' => NULL,
            'class_modal_default' => 'col-md-6',
            'class_modal_setup' => 'col-md-6 d-none'
        ];

        return view('kelolaMaster/masterUser', $data);
    }

    public function showDataUSer($user_id)
    {
        $list_user = $this->masterUserModel->getAllUser();
        $data_user = $this->masterUserModel->getProfilUser($user_id);
        $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($user_id);
        $level_tersedia = $this->masterUserLevelModel->getAlllevel();
        $list_pegawai = $this->masterPegawaiModel->getAllPegawai();

        $data = [
            'title' => 'Master User',
            'menu' => 'Kelola Master',
            'subMenu' => 'Master User',
            'list_user' => $list_user,
            'list_pegawai' => $list_pegawai,
            'show_data_user' => $data_user,
            'show_list_level' => $list_user_level,
            'level_tersedia' => $level_tersedia,
            'class_modal_default' => 'col-md-6 d-none',
            'class_modal_setup' => 'col-md-6'
        ];
        //dd($data);
        return view('kelolaMaster/masterUser', $data);
    }

    public function updateRoleAktivasi()
    {
        $id_user = $this->request->getVar('id_user_show');
        $username = $this->request->getVar('username_show');
        $fullname = $this->request->getVar('fullname_show');
        $email = $this->request->getVar('email_show');
        $password = $this->request->getVar('password_show');
        $token = $this->request->getVar('token_show');
        $image_user = $this->request->getVar('image_user_show');
        $nip_lama_user = $this->request->getVar('nip_lama_user_show');
        $is_active = $this->request->getVar('is_active');
        $level_user = $this->request->getVar('level_show');
        $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($id_user);


        for ($i = 0; $i < count($list_user_level); $i++) {
            $this->masterAksesUserLevelModel->save([
                'id' => $list_user_level[$i]['id'],
                'user_id' => $id_user,
                'level_id' => $level_user[$i]
            ]);
        }


        $this->masterUserModel->save([
            'id' => $id_user,
            'username' => $username,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $password,
            'token' => $token,
            'image' => $image_user,
            'nip_lama_user' => $nip_lama_user,
            'is_active' => $is_active,
        ]);

        if (session('user_id') == $id_user) {

            $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($id_user);

            $data1 = [
                'log' => TRUE,
                'user_id' => session('user_id'),
                'level_id' => session('level_id'),
                'list_user_level' => $list_user_level,
                'list_menu'  => session('list_menu'),
                'list_submenu' => session('list_submenu'),
                'fullname' => session('fullname'),
                'data_user' => session('data_user')
            ];
            session()->set($data1);
        }


        return redirect()->to('/showDataUser/' . $id_user);
    }

    public function tambahLevelUser()
    {
        $id_user = $this->request->getVar('id_user_role');
        $level_id = $this->request->getVar('role');

        $this->masterAksesUserLevelModel->save([
            'user_id' => $id_user,
            'level_id' => $level_id
        ]);


        if (session('user_id') == $id_user) {

            $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($id_user);

            $data1 = [
                'log' => TRUE,
                'user_id' => session('user_id'),
                'level_id' => session('level_id'),
                'list_user_level' => $list_user_level,
                'list_menu'  => session('list_menu'),
                'list_submenu' => session('list_submenu'),
                'fullname' => session('fullname'),
                'data_user' => session('data_user')
            ];
            session()->set($data1);
        }
        session()->setFlashdata('pesan', 'Tambah Level berhasil');
        session()->setFlashdata('icon', 'success');

        return redirect()->to('/showDataUser/' . $id_user);
    }

    public function resetPasswordUser()
    {
        $id_user = $this->request->getVar('id_user_reset');
        $username = $this->request->getVar('username_reset');
        $fullname = $this->request->getVar('fullname_reset');
        $email = $this->request->getVar('email_reset');
        $token = $this->request->getVar('token_reset');
        $image_user = $this->request->getVar('image_user_reset');
        $nip_lama_user = $this->request->getVar('nip_lama_user_reset');
        $is_active = $this->request->getVar('is_active_reset');

        $pass_default =  password_hash('123456', PASSWORD_DEFAULT);

        $this->masterUserModel->save([
            'id' => $id_user,
            'username' => $username,
            'fullname' => $fullname,
            'email' => $email,
            'password' => $pass_default,
            'token' => $token,
            'image' => $image_user,
            'nip_lama_user' => $nip_lama_user,
            'is_active' => $is_active,
        ]);
        session()->setFlashdata('pesan', 'Reset password ' . $username . ' berhasil');
        session()->setFlashdata('icon', 'success');

        return redirect()->to('/showDataUser/' . $id_user);
    }

    public function hapusLevelUser()
    {
        $id_akses_user_level = $this->request->getVar('id_level_hapus');
        $id_user = $this->request->getVar('id_user_hapus');


        $this->masterAksesUserLevelModel->delete($id_akses_user_level);

        if (session('user_id') == $id_user) {

            $list_user_level = $this->masterAksesUserLevelModel->getUserLevel($id_user);

            $data1 = [
                'log' => TRUE,
                'user_id' => session('user_id'),
                'level_id' => session('level_id'),
                'list_user_level' => $list_user_level,
                'list_menu'  => session('list_menu'),
                'list_submenu' => session('list_submenu'),
                'fullname' => session('fullname'),
                'data_user' => session('data_user')
            ];
            session()->set($data1);
        }

        session()->setFlashdata('pesan', 'Hapus Level berhasil');
        session()->setFlashdata('icon', 'success');

        return redirect()->to('/showDataUser/' . $id_user);
    }



    public function tambahUser()
    {
        $id_pegawai = $this->request->getVar('id_pegawai');
        $nip_lama_tambah = $this->masterPegawaiModel->getNipLama($id_pegawai);
        $username_tambah = $this->request->getVar('username_tambah');
        $fullname_tambah = $this->request->getVar('fullname_tambah');
        $email_tambah = $this->request->getVar('email_tambah');
        $is_active_tambah = $this->request->getVar('is_active_tambah');
        $pass_default_tambah =  password_hash('123456', PASSWORD_DEFAULT);

        $image_user = ($nip_lama_tambah['nip_lama'] . '.jpg');

        $this->masterUserModel->save([
            'username' => $username_tambah,
            'fullname' => $fullname_tambah,
            'email' => $email_tambah,
            'password' => $pass_default_tambah,
            'token' => null,
            'image' => $image_user,
            'nip_lama_user' => $nip_lama_tambah['nip_lama'],
            'is_active' => $is_active_tambah,
        ]);

        $last_input_user_id = $this->masterUserModel->getLastId();


        $all_level = $this->masterUserLevelModel->getAlllevel();
        for ($al = 0; $al <= count($all_level); $al++) {
            if ($this->request->getVar('level_pick' . $al) != null) {
                $Level_choose[] = ($al + 1);
            }
        }

        for ($lev = 0; $lev < count($Level_choose); $lev++) {
            $this->masterAksesUserLevelModel->save([
                'user_id' => $last_input_user_id,
                'level_id' => $Level_choose[$lev]
            ]);
        }

        session()->setFlashdata('pesan', 'tambah user ' . $username_tambah . ' berhasil');
        session()->setFlashdata('icon', 'success');

        return redirect()->to('/masterUser');
    }


    public function masterPegawai()
    {
        $keyword = $this->request->getVar('keyword');

        if ($keyword) {
            $list_pegawai = $this->masterPegawaiModel->search($keyword);
        } else {
            $list_pegawai = $this->masterPegawaiModel->getAllPegawai();
        }


        $list_bidang = $this->masterEs3Model->getAllBidang();
        $list_golongan = $this->masterGolonganModel->getAllGolongan();
        $list_jabatan = $this->masterJabatanModel->getAllJabatan();
        $list_pendidikan = $this->masterPendidikanModel->getAllPendidikan();
        $list_satker = $this->masterSatkerModel->getAllSatker();
        $list_seksi = $this->masterEs4Model->getAllSeksi();
        $list_fungsional = $this->masterFungsionalModel->getAllFungsional();

        $data_user = $this->masterUserModel->getAllUser();


        $data = [
            'title' => 'Master Pegawai',
            'menu' => 'Kelola Master',
            'subMenu' => 'Master Pegawai',
            'list_user' => $data_user,
            'list_pegawai' => $list_pegawai,
            'list_bidang' => $list_bidang,
            'list_golongan' => $list_golongan,
            'list_jabatan' => $list_jabatan,
            'list_pendidikan' => $list_pendidikan,
            'list_satker' => $list_satker,
            'list_seksi' => $list_seksi,
            'list_fungsional' => $list_fungsional,
            'pegawai_tertentu' => null,
            'modal_edit' => '',
            'modal_detail' => '',
            'detail_pegawai' => null,
            'image_pegawai' => null,
            'keyword' => $keyword


        ];
        // dd($data);
        return view('kelolaMaster/masterPegawai', $data);
    }

    public function savePegawai()
    {
        $this->masterPegawaiModel->save([
            'nip_lama' => $this->request->getVar('nip_lama'),
            'nip_baru' => $this->request->getVar('nip_baru'),
            'nama_pegawai' => $this->request->getVar('nama_pegawai'),
            'gol_kd' => $this->request->getVar('gol_kd'),
            'tmt' => $this->request->getVar('tmt'),
            'jabatan_kd' => $this->request->getVar('jabatan_kd'),
            'ket_jabatan' => $this->request->getVar('ket_jabatan'),
            'pendidikan_kd' => $this->request->getVar('pendidikan_kd'),
            'tahun_pdd' => $this->request->getVar('tahun_pdd'),
            'jk' => $this->request->getVar('jk'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'satker_kd' => $this->request->getVar('satker_kd'),
            'es3_kd' => $this->request->getVar('es3_kd'),
            'es4_kd' => $this->request->getVar('es4_kd'),
            'fungsional_kd' => $this->request->getVar('fungsional_kd'),

        ]);

        return redirect()->to('/masterPegawai');
    }


    public function showEditPegawai($id_pegawai)
    {

        $list_pegawai = $this->masterPegawaiModel->getAllPegawai();
        $list_bidang = $this->masterEs3Model->getAllBidang();
        $list_golongan = $this->masterGolonganModel->getAllGolongan();
        $list_jabatan = $this->masterJabatanModel->getAllJabatan();
        $list_pendidikan = $this->masterPendidikanModel->getAllPendidikan();
        $list_satker = $this->masterSatkerModel->getAllSatker();
        $list_seksi = $this->masterEs4Model->getAllSeksi();
        $list_fungsional = $this->masterFungsionalModel->getAllFungsional();

        $data_user = $this->masterUserModel->getAllUser();

        $data = [
            'title' => 'Master Pegawai',
            'menu' => 'Kelola Master',
            'subMenu' => 'Master Pegawai',
            'list_user' => $data_user,
            'list_pegawai' => $list_pegawai,
            'list_bidang' => $list_bidang,
            'list_golongan' => $list_golongan,
            'list_jabatan' => $list_jabatan,
            'list_pendidikan' => $list_pendidikan,
            'list_satker' => $list_satker,
            'list_seksi' => $list_seksi,
            'list_fungsional' => $list_fungsional,
            'pegawai_tertentu' => $this->masterPegawaiModel->getPegawaiById($id_pegawai),
            'modal_edit' => 'modal-edit',
            'modal_detail' => '',
            'detail_pegawai' => null,
            'image_pegawai' => null,
            'keyword' => ''


        ];
        //dd($data);
        return view('kelolaMaster/masterPegawai', $data);
    }

    public function updatePegawai()
    {
        $id = $this->request->getVar('id_pegawai_tertentu');


        $this->masterPegawaiModel->save([
            'id' => intval($id),
            'nip_lama' => $this->request->getVar('nip_lama'),
            'nip_baru' => $this->request->getVar('nip_baru'),
            'nama_pegawai' => $this->request->getVar('nama_pegawai'),
            'gol_kd' => $this->request->getVar('gol_kd'),
            'tmt' => $this->request->getVar('tmt'),
            'jabatan_kd' => $this->request->getVar('jabatan_kd'),
            'ket_jabatan' => $this->request->getVar('ket_jabatan'),
            'pendidikan_kd' => $this->request->getVar('pendidikan_kd'),
            'tahun_pdd' => $this->request->getVar('tahun_pdd'),
            'jk' => $this->request->getVar('jk'),
            'tgl_lahir' => $this->request->getVar('tgl_lahir'),
            'satker_kd' => $this->request->getVar('satker_kd'),
            'es3_kd' => $this->request->getVar('es3_kd'),
            'es4_kd' => $this->request->getVar('es4_kd'),
            'fungsional_kd' => $this->request->getVar('fungsional_kd'),

        ]);

        return redirect()->to('/masterPegawai');
    }


    public function showDetailPegawai($id_pegawai)
    {

        $detail_pegawai = $this->masterPegawaiModel->getDetailPegawaiById($id_pegawai);
        $image_pegawai = $this->masterUserModel->getImage($detail_pegawai['nip_lama']);
        if ($image_pegawai == null) {
            $image_pegawai = [
                'image' => 'default.png',
                'username' => ''
            ];
        } else {
            $image_pegawai = $image_pegawai;
        }
        $list_pegawai = $this->masterPegawaiModel->getAllPegawai();
        $list_bidang = $this->masterEs3Model->getAllBidang();
        $list_golongan = $this->masterGolonganModel->getAllGolongan();
        $list_jabatan = $this->masterJabatanModel->getAllJabatan();
        $list_pendidikan = $this->masterPendidikanModel->getAllPendidikan();
        $list_satker = $this->masterSatkerModel->getAllSatker();
        $list_seksi = $this->masterEs4Model->getAllSeksi();
        $list_fungsional = $this->masterFungsionalModel->getAllFungsional();
        $data_user = $this->masterUserModel->getAllUser();

        $data = [
            'title' => 'Master Pegawai',
            'menu' => 'Kelola Master',
            'subMenu' => 'Master Pegawai',
            'list_user' => $data_user,
            'list_pegawai' => $list_pegawai,
            'list_bidang' => $list_bidang,
            'list_golongan' => $list_golongan,
            'list_jabatan' => $list_jabatan,
            'list_pendidikan' => $list_pendidikan,
            'list_satker' => $list_satker,
            'list_seksi' => $list_seksi,
            'list_fungsional' => $list_fungsional,
            'pegawai_tertentu' => null,
            'detail_pegawai' => $detail_pegawai,
            'image_pegawai' => $image_pegawai,
            'modal_edit' => '',
            'modal_detail' => 'modal-detail',
            'keyword' => ''


        ];
        //dd($data);
        return view('kelolaMaster/masterPegawai', $data);
    }





    public function masterKegiatan()
    {
        $data = [
            'title' => 'Master Kegiatan',
            'menu' => 'Kelola Master',
            'subMenu' => 'Master Kegiatan'
        ];
        return view('kelolaMaster/masterKegiatan', $data);
    }



    public function get_autofillPegawai()
    {
        $model = new MasterPegawaiModel();

        $request = \Config\Services::request();
        $kode = $request->getPostGet('term');
        $pegawai = $model
            ->like('nama_pegawai', $kode)
            ->orderBy('nama_pegawai', 'ASC')
            ->findAll();
        $hasil = array();
        foreach ($pegawai as $rt) :
            $hasil[] = [
                "label" => $rt['nama_pegawai']
            ];
        endforeach;
        echo json_encode($hasil);
    }
}
