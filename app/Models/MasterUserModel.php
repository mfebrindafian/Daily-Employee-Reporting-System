<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterUserModel extends Model
{
    protected $table = 'tbl_user';
    protected $allowedFields = ['username', 'fullname', 'email', 'password', 'token', 'image', 'nip_lama_user',  'is_active'];

    public function getUser($username)
    {
        return $this
            ->table('tbl_user')
            ->where('username', $username)
            ->get()
            ->getRowArray();
    }

    // public function getAllUserAktif()
    // {
    //     $query = ('SELECT * FROM dbsiphp.tbl_user tn join dbsiphp2.mst_pegawai tn1 where tn.nip_lama_user = tn1.nip_lama AND tn1.satker_kd = 1500 AND tn.is_active = "Y"');
    //     return $this->db->query($query)->getResultArray();
    // }

    // public function getAllUserTidakAktif()
    // {
    //     $query = ('SELECT * FROM dbsiphp.tbl_user tn join dbsiphp2.mst_pegawai tn1 where tn.nip_lama_user = tn1.nip_lama AND tn1.satker_kd = 1500 AND tn.is_active = "N"');
    //     return $this->db->query($query)->getResultArray();
    // }

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


    public function getUserId($nip_lama)
    {
        return $this
            ->table('tbl_user')
            ->select('id')
            ->where('nip_lama_user', $nip_lama)
            ->get()
            ->getRowArray();
    }


    public function getNipLamaByUserId($user_id)
    {
        return $this
            ->table('tbl_user')
            ->select('nip_lama_user')
            ->where('id', $user_id)
            ->get()
            ->getRowArray();
    }

    // public function getAllUserOnDashboard()
    // {
    //     $query = ('SELECT * FROM dbsiphp.tbl_user tn join dbsiphp2.mst_pegawai tn1 where tn.nip_lama_user = tn1.nip_lama');
    //     return $this->db->query($query)->getResultArray();
    // }

    // public function getAllUserBySatker($kd_satker)
    // {
    //     $query = ('SELECT * FROM dbsiphp.tbl_user tn join dbsiphp2.mst_pegawai tn1 where tn.nip_lama_user = tn1.nip_lama AND tn1.satker_kd = ' . $kd_satker . '');
    //     return $this->db->query($query)->getResultArray();
    // }

    // public function getTotalByUserJoinPegawai($pegawai_id)
    // {

    //     $query = ('SELECT * FROM dbsiphp.tbl_user tn join dbsiphp2.mst_pegawai tn1 join dbsiphp.mst_laporanharian tn2 where tn1.id = ' . $pegawai_id . ' AND tn.nip_lama_user = tn1.nip_lama AND tn.id = tn2.user_id ORDER BY tn1.id ASC');
    //     return $this->db->query($query)->getResultArray();
    // }

    // public function getTotalByUserJoinPegawai2($pegawai_id)
    // {
    //     $monday = (`"` . date("Y-m-d", strtotime("last monday")) . `"`);
    //     $sunday = date("Y-m-d", strtotime("next sunday"));
    //     $query = ('SELECT * FROM dbsiphp.tbl_user user join dbsiphp2.mst_pegawai pegawai join dbsiphp.mst_laporanharian laporan where pegawai.id = ' .  $pegawai_id  . ' AND laporan.tgl_kegiatan >=' . " '" .  $monday . "' "  . ' AND laporan.tgl_kegiatan <=' . " '" .  $sunday . "' "  . ' AND user.nip_lama_user = pegawai.nip_lama AND user.id = laporan.user_id ORDER BY pegawai.id ASC');
    //     return $this->db->query($query)->getResultArray();
    // }


    public function getDataPegawaiByUserId($user_id)
    {
        $query = ('SELECT * FROM dbsiphp.tbl_user tn join dbsiphp2.mst_pegawai tn1 where tn.nip_lama_user = tn1.nip_lama AND tn.id = ' . $user_id);
        return $this->db->query($query)->getRowArray();
    }
}
