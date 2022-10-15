<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterAksesMenuModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'tbl_akses_menu';
    protected $allowedFields = ['level_id', 'menu_id', 'view_level'];



    public function getMenuByLevel($level_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_menu.id')
            ->where('tbl_akses_menu.level_id', $level_id)
            ->get()
            ->getResultArray();
    }
}
