<?php

namespace App\Models;

use CodeIgniter\I18n\Time;
use CodeIgniter\Model;

class MasterUserModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'tbl_user';
    protected $allowedFields = ['username', 'fullname', 'email', 'password', 'token', 'image', 'nip_lama_user',  'is_active'];

    public function get_data_login($username, $tbl)
    {
        $builder = $this->db->table($tbl);
        $builder->where('username', $username);
        $log = $builder->get()->getRow();
        return $log;
    }

    public function getUser($username)
    {
        return $this
            ->table('tbl_user')
            ->where('username', $username)
            ->get()
            ->getRowArray();
    }

    public function getAllUserAktif()
    {
        return $this
            ->table('tbl_user.*,mst_pegawai.*')
            ->where('mst_pegawai.satker_kd', 1500)
            ->where('tbl_user.is_active', 'Y')
            ->join('mst_pegawai', 'mst_pegawai.nip_lama = tbl_user.nip_lama_user')
            ->get()
            ->getResultArray();
    }

    public function getAllUserTidakAktif()
    {
        return $this
            ->table('tbl_user.*,mst_pegawai.*')
            ->where('mst_pegawai.satker_kd', 1500)
            ->where('tbl_user.is_active', 'N')
            ->join('mst_pegawai', 'mst_pegawai.nip_lama = tbl_user.nip_lama_user')
            ->get()
            ->getResultArray();
    }

    public function getProfilUser($user_id)
    {
        return $this
            ->table('tbl_user')
            ->where('id', $user_id)
            ->get()
            ->getRowArray();
    }

    public function getAllUser()
    {
        return $this
            ->table('tbl_user')
            ->get()
            ->getResultArray();
    }

    public function getAllUserOnDashboard()
    {
        return $this
            ->table('tbl_user.*,mst_pegawai.*')
            ->where('mst_pegawai.satker_kd', 1500)
            ->join('mst_pegawai', 'mst_pegawai.nip_lama = tbl_user.nip_lama_user')
            ->get()
            ->getResultArray();
    }


    public function getImage($nip_lama)
    {
        return $this
            ->table('tbl_user')
            ->select('image')
            ->select('username')
            ->where('nip_lama_user', $nip_lama)
            ->get()
            ->getRowArray();
    }

    public function getLastId()
    {
        return $this
            ->table('tbl_user')
            ->select('id')
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();
    }


    public function getAllUserBySatker($kd_satker)
    {
        return $this
            ->table($this->table)
            ->select('tbl_user.*', 'mst_pegawai.*')
            ->where('mst_pegawai.satker_kd', $kd_satker)
            ->join('mst_pegawai', 'mst_pegawai.nip_lama= tbl_user.nip_lama_user')
            ->get()
            ->getResultArray();
    }

    public function getUserId($nip_lama)
    {
        return $this
            ->table('tbl_user')
            ->select('id')
            ->where('nip_lama_user', $nip_lama)
            ->get()
            ->getRowArray();
    }

    public function getTotalByUserJoinPegawai($pegawai_id)
    {
        return $this
            ->table($this->table)
            ->select('mst_laporanharian.*,tbl_user.*,mst_pegawai.*')
            ->where('mst_pegawai.id', $pegawai_id)
            ->join('mst_pegawai', 'tbl_user.nip_lama_user = mst_pegawai.nip_lama')
            ->join('mst_laporanharian', 'tbl_user.id = mst_laporanharian.user_id')
            ->orderBy('mst_pegawai.id', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getTotalByUserJoinPegawai2($pegawai_id)
    {
        return $this
            ->table($this->table)
            ->select('mst_laporanharian.*,tbl_user.*,mst_pegawai.*')
            ->where('mst_pegawai.id', $pegawai_id)
            ->where('mst_laporanharian.tgl_kegiatan >=', date("Y-m-d", strtotime("last monday")))
            ->where('mst_laporanharian.tgl_kegiatan <=', date("Y-m-d", strtotime("next sunday")))
            ->join('mst_pegawai', 'tbl_user.nip_lama_user = mst_pegawai.nip_lama')
            ->join('mst_laporanharian', 'tbl_user.id = mst_laporanharian.user_id')
            ->orderBy('mst_pegawai.id', 'ASC')
            ->get()
            ->getResultArray();
    }


    public function getDataPegawaiByUserId($user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_user.*,mst_pegawai.*')
            ->where('tbl_user.id', $user_id)
            ->join('mst_pegawai', 'tbl_user.nip_lama_user = mst_pegawai.nip_lama')
            ->get()
            ->getRowArray();
    }
}
