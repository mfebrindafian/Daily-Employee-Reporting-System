<?php

use App\Models\MasterUserModel;
use App\Models\MasterAksesUserLevelModel;
use App\Models\MasterAksesMenuModel;
use App\Models\MasterKegiatanModel;
use App\Models\MasterPegawaiModel;



// function allowHalaman($level_id, $id_menu)
// {
//     $masterAksesUserLevelModel = new masterAksesUserLevelModel();
//     $listHalaman = $masterAksesUserLevelModel->getAksesMenu($level_id, session('user_id'));
//     foreach ($listHalaman as $list) {
//         if ($list['id'] == $id_menu && $list['view_level'] == 'Y' && $list['is_active'] == 'Y') {
//             return true;
//         } else {
//             return false;
//         }
//     }
// }



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


function allowHalaman($level_id, $nama_menu, $nama_submenu)
{
    $masterAksesUserLevelModel = new masterAksesUserLevelModel();
    $listSubmenu = $masterAksesUserLevelModel->getAksesSubmenu($level_id, session('user_id'));
    $listHalaman = $masterAksesUserLevelModel->getAksesMenu($level_id, session('user_id'));


    $cekNamaMenu = [];
    foreach ($listHalaman as $list) {
        $cekNamaMenu[] = $list['nama_menu'];
        if ($list['nama_menu'] == $nama_menu && $list['view_level'] == 'Y' && $list['is_active'] == 'Y') {
            return true;
        }
    }
    if (in_array($nama_menu, $cekNamaMenu) == false) {
        return false;
    }
    $cekNamaSubMenu = [];
    foreach ($listSubmenu as $list2) {
        $cekNamaSubMenu[] = $list2['nama_submenu'];
        if ($list2['nama_submenu'] == $nama_submenu && $list2['view_level'] == 'Y' && $list2['is_active'] == 'Y') {
            return true;
        }
    }
    if (in_array($nama_submenu, $cekNamaSubMenu) == false) {
        return false;
    }
}
