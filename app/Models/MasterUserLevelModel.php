<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterUserLevelModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'user_level';
    protected $allowedFields = ['nama_level'];

    public function getAllId()
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->get()
            ->getResultArray();
    }

    public function getAlllevel()
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->select('nama_level')
            ->get()
            ->getResultArray();
    }
    public function getLastId()
    {
        return $this
            ->table($this->table)
            ->select('id')
            ->orderBy('id', 'DESC')
            ->get()
            ->getRowArray();
    }

    public function getAksesMenu($level_id)
    {
        return $this
            ->table($this->table)
            ->select('user_level.*,tbl_akses_menu.*,tbl_menu.*')
            ->where('user_level.id', $level_id)
            ->join('tbl_akses_menu', 'tbl_akses_menu.level_id = user_level.id')
            ->join('tbl_menu', 'tbl_akses_menu.menu_id = tbl_menu.id')
            ->orderBy('tbl_menu.urutan', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getAksesMenuLevel($level_id)
    {
        return $this
            ->table($this->table)
            ->select('user_level.*,tbl_akses_menu.*,tbl_menu.*')
            ->where('user_level.id', $level_id)
            ->join('tbl_akses_menu', 'tbl_akses_menu.level_id = user_level.id')
            ->join('tbl_menu', 'tbl_akses_menu.menu_id = tbl_menu.id')
            ->orderBy('tbl_menu.urutan', 'ASC')
            ->get()
            ->getResultArray();
    }


    public function getAksesSubmenu($level_id)
    {
        return $this
            ->table($this->table)
            ->select('user_level.*,tbl_akses_submenu.*,tbl_submenu.*')
            ->where('user_level.id', $level_id)
            ->join('tbl_akses_submenu', 'tbl_akses_submenu.level_id = user_level.id')
            ->join('tbl_submenu', 'tbl_akses_submenu.submenu_id = tbl_submenu.id')
            ->get()
            ->getResultArray();
    }

    public function getAksesSubmenuLevel($level_id)
    {
        return $this
            ->table($this->table)
            ->select('user_level.*,tbl_akses_submenu.*,tbl_submenu.*')
            ->where('user_level.id', $level_id)
            ->join('tbl_akses_submenu', 'tbl_akses_submenu.level_id = user_level.id')
            ->join('tbl_submenu', 'tbl_akses_submenu.submenu_id = tbl_submenu.id')
            ->get()
            ->getResultArray();
    }
}
