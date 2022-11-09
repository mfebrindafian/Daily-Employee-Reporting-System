<?php

namespace App\Models;

use CodeIgniter\Model;

class masterKegiatanModel extends Model
{
    protected $table = 'mst_kegiatan';
    protected $allowedFields = ['user_id', 'rincian_kegiatan', 'tipe_kegiatan', 'status_rincian', 'tgl_input', 'tgl_update'];

    public function getAllByUserId($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->get()
            ->getResultArray();
    }

    public function getAllByUserIdOrderYear($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->orderBy('tgl_input', 'ASC')
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
