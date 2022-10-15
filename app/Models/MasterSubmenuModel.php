<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterSubmenuModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'tbl_submenu';
    protected $allowedFields = ['nama_submenu', 'menu_id', 'link', 'is_active'];

    public function getLastId()
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();
    }

    public function getListSubmenu()
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->get()
            ->getResultArray();
    }
}
