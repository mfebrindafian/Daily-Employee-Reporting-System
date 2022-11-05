<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterMenuModel extends Model
{
    protected $table = 'tbl_menu';
    protected $allowedFields = ['nama_menu', 'link', 'icon', 'urutan', 'is_active'];

    public function getLastId()
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();
    }

    public function getListMenu()
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->select('nama_menu')
            ->get()
            ->getResultArray();
    }
}
