<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterLaporanHarianModel extends Model
{
    protected $table = 'mst_laporanharian';
    protected $allowedFields = ['user_id', 'tgl_kegiatan', 'uraian_kegiatan',];
    public function getAllYear($user_id)
    {
        return $this
            ->table($this->table)
            ->select('tgl_kegiatan')
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
    }
    public function getMaxDate($user_id)
    {
        return $this
            ->table($this->table)
            ->select('tgl_kegiatan')
            ->orderBy('tgl_kegiatan', 'DESC')
            ->where('user_id', $user_id)
            ->get()
            ->getRowArray();
    }

    public function getDateToday($tgl_kegiatan, $user_id)
    {
        return $this
            ->table($this->table)
            ->where('tgl_kegiatan', $tgl_kegiatan)
            ->where('user_id', $user_id)
            ->get()
            ->getRowArray();
    }


    public function getTotalByUser($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->orderBy('tgl_kegiatan', 'DESC')
            ->get()
            ->getResultArray();
    }


    public function getTotalByUserToday($user_id, $tgl_kegiatan)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->where('tgl_kegiatan', $tgl_kegiatan)
            ->get()
            ->getRowArray();
    }

    public function getAllByUser($user_id)
    {

        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->orderBy('tgl_kegiatan', 'DESC');
    }
    public function getAllLaporanByUserId($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
    }

    public function getAllLaporanByUserId2($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->where('tgl_kegiatan >=', date("Y-m-d", strtotime("last monday")))
            ->where('tgl_kegiatan <=', date("Y-m-d", strtotime("next sunday")))
            ->get()
            ->getResultArray();
    }


    public function getAll($user_id)
    {
        return $this
            ->table($this->table)
            ->select('*')
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
    }
    public function getAllLaporan()
    {
        return $this
            ->table($this->table)
            ->select('*')
            ->get()
            ->getResultArray();
    }
    public function getTotalByUserDate($tgl_awal, $tgl_akhir, $user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->where('tgl_kegiatan >=', $tgl_awal)
            ->where('tgl_kegiatan <=', $tgl_akhir)
            ->orderBy('tgl_kegiatan', 'ASC')
            ->get()
            ->getResultArray();
    }
    public function getLaporan($user_id, $laporan_id)
    {
        return $this
            ->table($this->table)
            ->select('*')
            ->where('user_id', $user_id)
            ->where('id', $laporan_id)
            ->get()
            ->getRowArray();
    }
    public function search($user_id, $keyword)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->where('tgl_kegiatan', $keyword);
    }
    public function getUserIdbyLaporanId($laporan_id)
    {
        return $this
            ->table($this->table)
            ->select('user_id')
            ->where('id', $laporan_id)
            ->get()
            ->getRowArray();
    }

    
}
