<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterAksesUserLevelModel extends Model
{
    protected $useTimestamps = true;
    protected $useSoftDeletes = true;
    protected $table = 'tbl_akses_user_level';
    protected $allowedFields = ['user_id', 'level_id'];


    public function getUserLevel($user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.nama_level')
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->where(['tbl_akses_user_level.deleted_at' => null])
            ->join('user_level', 'tbl_akses_user_level.level_id = user_level.id')
            ->get()
            ->getResultArray();
    }

    public function getAksesMenu($level_id, $user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.*,tbl_akses_menu.*,tbl_menu.*')
            ->where('tbl_akses_user_level.level_id', $level_id)
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->where(['tbl_akses_user_level.deleted_at' => null])
            ->join('user_level', 'user_level.id = tbl_akses_user_level.level_id')
            ->join('tbl_akses_menu', 'tbl_akses_menu.level_id = user_level.id')
            ->join('tbl_menu', 'tbl_akses_menu.menu_id = tbl_menu.id')
            ->orderBy('tbl_menu.urutan', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getAksesMenuLevel($level_id, $user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.*,tbl_akses_menu.*,tbl_menu.*')
            ->where('tbl_akses_user_level.level_id', $level_id)
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->where(['tbl_akses_user_level.deleted_at' => null])
            ->join('user_level', 'user_level.id = tbl_akses_user_level.level_id')
            ->join('tbl_akses_menu', 'tbl_akses_menu.level_id = user_level.id')
            ->join('tbl_menu', 'tbl_akses_menu.menu_id = tbl_menu.id')
            ->orderBy('tbl_menu.urutan', 'ASC')
            ->get()
            ->getResultArray();
    }


    public function getAksesSubmenu($level_id, $user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.*,tbl_akses_submenu.*,tbl_submenu.*')
            ->where('tbl_akses_user_level.level_id', $level_id)
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->where(['tbl_akses_user_level.deleted_at' => null])
            ->join('user_level', 'user_level.id = tbl_akses_user_level.level_id')
            ->join('tbl_akses_submenu', 'tbl_akses_submenu.level_id = user_level.id')
            ->join('tbl_submenu', 'tbl_akses_submenu.submenu_id = tbl_submenu.id')
            ->get()
            ->getResultArray();
    }

    public function getAksesSubmenuLevel($level_id, $user_id)
    {
        return $this
            ->table($this->table)
            ->select('tbl_akses_user_level.*,user_level.*,tbl_akses_submenu.*,tbl_submenu.*')
            ->where('tbl_akses_user_level.level_id', $level_id)
            ->where('tbl_akses_user_level.user_id', $user_id)
            ->where(['tbl_akses_user_level.deleted_at' => null])
            ->join('user_level', 'user_level.id = tbl_akses_user_level.level_id')
            ->join('tbl_akses_submenu', 'tbl_akses_submenu.level_id = user_level.id')
            ->join('tbl_submenu', 'tbl_akses_submenu.submenu_id = tbl_submenu.id')
            ->get()
            ->getResultArray();
    }
}
