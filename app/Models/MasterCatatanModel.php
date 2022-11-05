<?php

namespace App\Models;
use CodeIgniter\Model;
class MasterCatatanModel extends Model
{

    protected $table = 'mst_catatan';
    protected $allowedFields = ['user_id', 'user_id_penerima', 'tgl_catatan', 'tipe_catatan', 'catatan'];

    public function getAll($user_id)
    {
        return $this
            ->table($this->table)
            ->where('user_id', $user_id)
            ->orWhere('user_id_penerima', $user_id)
            ->orderBy('tgl_catatan', 'ASC')
            ->get()
            ->getResultArray();
    }
    public function getCatatanById($id_catatan)
    {
        return $this
            ->table($this->table)
            ->where('id', $id_catatan)
            ->get()
            ->getRowArray();
    }
}
