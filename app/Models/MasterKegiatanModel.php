<?php

namespace App\Models;

use CodeIgniter\Model;

class masterKegiatanModel extends Model
{
    protected $table = 'mst_kegiatan';
    protected $allowedFields = ['user_id', 'rincian_kegiatan', 'tipe_kegiatan', 'status_rincian', 'status_verifikasi', 'tgl_input', 'tgl_update'];

    public function getAllByUserId($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
    }

    public function getAllByUserIdDate($user_id, $start_date, $end_date)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->where('user_id', $user_id)
            ->where('tgl_input >=', $start_date)
            ->where('tgl_input <=', $end_date)
            ->get()
            ->getResultArray();
    }

    public function getAllByUserIdOrderYear($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->orderBy('tgl_input', 'DESC')
            ->get()
            ->getResultArray();
    }

    public function getDataById($id)
    {
        return $this
            ->table($this->table)
            ->where('id', $id)
            ->get()
            ->getRowArray();
    }
}
