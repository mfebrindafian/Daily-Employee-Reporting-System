<?php

use App\Models\MasterUserModel;
use App\Models\MasterAksesUserLevelModel;
use App\Models\MasterAksesMenuModel;
use App\Models\MasterKegiatanModel;
use App\Models\MasterPegawaiModel;



function allowHalaman($level_id, $id_menu)
{
    $masterAksesUserLevelModel = new masterAksesUserLevelModel();
    $listHalaman = $masterAksesUserLevelModel->getAksesMenu($level_id, session('user_id'));
    foreach ($listHalaman as $list) {
        if ($list['id'] == $id_menu && $list['view_level'] == 'Y' && $list['is_active'] == 'Y') {
            return true;
        } else {
            return false;
        }
    }
}



function allowChart($level_id, $id_chart)
{
    if ($id_chart == 1) { //untuk chart kegiatan tahunan
        if ($level_id == 2) {
            return true;
        } else {
            return false;
        }
    }
}


function allowSubMenu($level_id, $id_parent, $id_submenu)
{
    $masterAksesUserLevelModel = new masterAksesUserLevelModel();
    $listSubmenu = $masterAksesUserLevelModel->getAksesSubmenu($level_id, session('user_id'));
    $listHalaman = $masterAksesUserLevelModel->getAksesMenu($level_id, session('user_id'));
    foreach ($listHalaman as $list) {
        if ($list['id'] == $id_parent && $list['view_level'] == 'Y' && $list['is_active'] == 'Y') {
            return true;
        } else {
            return false;
        }
    }
    foreach ($listSubmenu as $list) {
        if ($list['nama_menu'] == $id_submenu && $list['view_level'] == 'Y' && $list['is_active'] == 'Y') {
            return true;
        } else {
            return false;
        }
    }
}
