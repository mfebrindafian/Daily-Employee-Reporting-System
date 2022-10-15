<?php

namespace App\Controllers;

use App\Models\MasterUserLevelModel;
use App\Models\MasterMenuModel;
use App\Models\MasterAksesMenuModel;
use App\Models\MasterSubmenuModel;
use App\Models\MasterAksesSubmenuModel;
use App\Models\MasterAksesUserLevelModel;


class masterSistem extends BaseController
{
    protected $masterUserLevelModel;
    protected $masterMenuModel;
    protected $masterAksesMenuModel;
    protected $masterSubmenuModel;
    protected $masterAksesSubmenuModel;
    protected $masterAksesUserLevelModel;

    public function __construct()
    {
        $this->masterUserLevelModel = new masterUserLevelModel();
        $this->masterMenuModel = new masterMenuModel();
        $this->masterAksesMenuModel = new masterAksesMenuModel();
        $this->masterSubmenuModel = new masterSubmenuModel();
        $this->masterAksesSubmenuModel = new masterAksesSubmenuModel();
        $this->masterAksesUserLevelModel = new masterAksesUserLevelModel();
    }



    // KELOLA LEVEL
    public function kelolaLevel()
    {
        $data = [
            'title' => 'Kelola Level',
            'menu' => 'Sistem',
            'subMenu' => 'Kelola Level',
            'id_modal' => '',
            'level_id' => '',
            'list_level' => $this->masterUserLevelModel->getAlllevel(),
            'list_menu' => session('list_menu'),
            'list_submenu' => session('list_submenu'),
        ];
        //dd($data);
        return view('sistem/kelolaLevel', $data);
    }

    public function editKelolaLevel($level_id)
    {
        $list_menu = $this->masterUserLevelModel->getAksesMenuLevel($level_id);


        $list_submenu = $this->masterUserLevelModel->getAksesSubmenuLevel($level_id);


        $data = [
            'title' => 'Kelola Level',
            'menu' => 'Sistem',
            'subMenu' => 'Kelola Level',
            'id_modal' => 'modal-hakAkses',
            'list_level' => $this->masterUserLevelModel->getAlllevel(),
            'level_id' => $level_id,
            'list_menu' => $list_menu,
            'list_submenu' => $list_submenu
        ];
        // dd($data);
        return view('sistem/kelolaLevel', $data);
    }

    public function updateKelolaLevel($level_id)
    {
        $list_menu = $this->masterUserLevelModel->getAksesMenu($level_id);

        $list_level_menu = $this->masterAksesMenuModel->getMenuByLevel($level_id);

        for ($i = 0; $i < count($list_menu); $i++) {

            $view = $this->request->getVar('view' . $i);
            if ($view == 'on') {
                $view_level = 'Y';
            } else {
                $view_level = 'N';
            }

            $this->masterAksesMenuModel->save([
                'id' => $list_level_menu[$i]['id'],
                'level_id' => $level_id,
                'menu_id' => $list_menu[$i]['menu_id'],
                'view_level' => $view_level,
            ]);
        }


        $list_submenu = $this->masterUserLevelModel->getAksesSubmenu($level_id);
        $list_level_submenu = $this->masterAksesSubmenuModel->getSubmenuByLevel($level_id);

        for ($i = 0; $i < count($list_submenu); $i++) {

            $view_submenu = $this->request->getVar('view_submenu' . $i);
            if ($view_submenu == 'on') {
                $view_submenu_level = 'Y';
            } else {
                $view_submenu_level = 'N';
            }
            $add_submenu = $this->request->getVar('add_submenu' . $i);
            if ($add_submenu == 'on') {
                $add_submenu_level = 'Y';
            } else {
                $add_submenu_level = 'N';
            }
            $edit_submenu = $this->request->getVar('edit_submenu' . $i);
            if ($edit_submenu == 'on') {
                $edit_submenu_level = 'Y';
            } else {
                $edit_submenu_level = 'N';
            }
            $delete_submenu = $this->request->getVar('delete_submenu' . $i);
            if ($delete_submenu == 'on') {
                $delete_submenu_level = 'Y';
            } else {
                $delete_submenu_level = 'N';
            }
            $print_submenu = $this->request->getVar('print_submenu' . $i);
            if ($print_submenu == 'on') {
                $print_submenu_level = 'Y';
            } else {
                $print_submenu_level = 'N';
            }
            $upload_submenu = $this->request->getVar('upload_submenu' . $i);
            if ($upload_submenu == 'on') {
                $upload_submenu_level = 'Y';
            } else {
                $upload_submenu_level = 'N';
            }

            $this->masterAksesSubmenuModel->save([
                'id' => $list_level_submenu[$i]['id'],
                'level_id' => $level_id,
                'submenu_id' =>  $list_submenu[$i]['submenu_id'],
                'view_level' =>  $view_submenu_level,
                'add_level' => $add_submenu_level,
                'delete_level' => $delete_submenu_level,
                'edit_level' => $edit_submenu_level,
                'print_level' => $print_submenu_level,
                'upload_level' => $upload_submenu_level
            ]);
        }


        $list_menu_baru = $this->masterAksesUserLevelModel->getAksesMenu(session('level_id'), session('user_id'));
        $list_submenu_baru = $this->masterAksesUserLevelModel->getAksesSubmenu(session('level_id'), session('user_id'));


        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => session('level_id'),
            'list_user_level' => session('list_user_level'),
            'list_menu'  => $list_menu_baru,
            'list_submenu' => $list_submenu_baru,
            'fullname' => session('fullname'),
            'data_user' => session('data_user')
        ];
        session()->set($data1);

        return redirect()->to('/kelolaLevel');
    }
    public function saveLevel()
    {
        $this->masterUserLevelModel->save([
            'nama_level' => $this->request->getVar('nama_level'),
        ]);

        $last_user_level_id = $this->masterUserLevelModel->getLastId();
        $list_menu_id = $this->masterMenuModel->getListMenu();
        $list_submenu_id = $this->masterSubmenuModel->getListSubmenu();

        for ($i = 0; $i < count($list_menu_id); $i++) {
            $this->masterAksesMenuModel->save([
                'level_id' => intval($last_user_level_id['id']),
                'menu_id' => intval($list_menu_id[$i]['id']),
                'view_level' => 'N'
            ]);
        }
        for ($i = 0; $i < count($list_submenu_id); $i++) {
            $this->masterAksesSubmenuModel->save([
                'level_id' => intval($last_user_level_id['id']),
                'submenu_id' => intval($list_submenu_id[$i]['id']),
                'view_level' => 'N',
                'add_level' => 'N',
                'delete_level' => 'N',
                'edit_level' => 'N',
                'print_level' => 'N',
                'upload_level' => 'N'
            ]);
        }

        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu(session('level_id'), session('user_id'));
        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu(session('level_id'), session('user_id'));


        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => session('level_id'),
            'list_user_level' => session('list_user_level'),
            'list_menu'  => $list_menu,
            'list_submenu' => $list_submenu,
            'fullname' => session('fullname'),
            'data_user' => session('data_user')
        ];
        session()->set($data1);

        return redirect()->to('/kelolaLevel');
    }

    public function updateNamaLevel()
    {
        $id = $this->request->getVar('id_level');
        $nama_level = $this->request->getVar('nama_level');

        $this->masterUserLevelModel->save([
            'id' => intval($id),
            'nama_level' => $nama_level
        ]);

        $list_user_level = $this->masterAksesUserLevelModel->getUserLevel(session('user_id'));

        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => session('level_id'),
            'list_user_level' => $list_user_level,
            'list_menu'  => session('list_menu'),
            'list_submenu' => session('list_submenu'),
            'fullname' => session('fullname'),
            'data_user' => session('data_user')
        ];
        session()->set($data1);

        return redirect()->to('/kelolaLevel');
    }



    // KELOLA MENU
    public function kelolaMenu()
    {
        $data = [
            'title' => 'Kelola Menu',
            'menu' => 'Sistem',
            'subMenu' => 'Kelola Menu',
            'list_menu' => session('list_menu'),
        ];

        return view('sistem/kelolaMenu', $data);
    }

    public function updateMenu()
    {
        $menu_id = $this->request->getVar('id');
        $this->masterMenuModel->save([
            'id' => $menu_id,
            'nama_menu' => $this->request->getVar('nama_menu'),
            'link' => $this->request->getVar('link'),
            'icon' => $this->request->getVar('icon'),
            'urutan' => $this->request->getVar('urutan'),
            'is_active' => $this->request->getVar('is_active'),
        ]);


        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu(session('level_id'), session('user_id'));

        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => session('level_id'),
            'list_user_level' => session('list_user_level'),
            'list_menu'  => $list_menu,
            'list_submenu' => session('list_submenu'),
            'fullname' => session('fullname'),
            'data_user' => session('data_user')
        ];
        session()->set($data1);

        session()->setFlashdata('pesan', 'Menu Berhasil Diubah');
        session()->setFlashdata('pesan_icon', 'success');

        return redirect()->to('/kelolaMenu');
    }

    public function saveMenu()
    {

        $this->masterMenuModel->save([
            'nama_menu' => $this->request->getVar('nama_menu'),
            'link' => $this->request->getVar('link'),
            'icon' => $this->request->getVar('icon'),
            'urutan' => $this->request->getVar('urutan'),
            'is_active' => $this->request->getVar('is_active'),
        ]);

        $list_level_id = $this->masterUserLevelModel->getAllId();
        $last_menu_id = $this->masterMenuModel->getLastId();
        $menu_id = intval($last_menu_id['id']);

        for ($i = 0; $i < count($list_level_id); $i++) {
            $this->masterAksesMenuModel->save([
                'level_id' => intval($list_level_id[$i]['id']),
                'menu_id' => $menu_id,
                'view_level' => 'N',
            ]);
        }


        $list_menu = $this->masterAksesUserLevelModel->getAksesMenu(session('level_id'), session('user_id'));

        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => session('level_id'),
            'list_user_level' => session('list_user_level'),
            'list_menu'  => $list_menu,
            'list_submenu' => session('list_submenu'),
            'fullname' => session('fullname'),
            'data_user' => session('data_user')
        ];
        session()->set($data1);

        session()->setFlashdata('pesan', $this->request->getVar('nama_menu') . ' Berhasil Ditambahkan');
        session()->setFlashdata('pesan_icon', 'success');

        return redirect()->to('/kelolaMenu');
    }



    // KELOLA SUB MENU
    public function kelolaSubMenu()
    {
        $dataSubmenu = $this->masterSubmenuModel;
        $totalSubmenu = $this->masterSubmenuModel->getListSubmenu();
        $itemsCount = 20;

        $data = [
            'title' => 'Kelola Sub Menu',
            'menu' => 'Sistem',
            'total' => count($totalSubmenu),
            'dataSubmenu' =>  $this->masterSubmenuModel->paginate($itemsCount, 'dataSubmenu'),
            'itemsCount' => $itemsCount,
            'pager' => $dataSubmenu->pager,
            'subMenu' => 'Kelola Submenu',
            'list_submenu' => session('list_submenu'),
            'list_menu' => $this->masterMenuModel->getListMenu()
        ];

        return view('sistem/kelolaSubMenu', $data);
    }

    public function updateSubmenu()
    {
        $submenu_id = $this->request->getVar('submenu_id');
        $this->masterSubmenuModel->save([
            'id' => $submenu_id,
            'nama_submenu' => $this->request->getVar('nama_submenu'),
            'menu_id' => $this->request->getVar('menu_id'),
            'link' => $this->request->getVar('link'),
            'is_active' => $this->request->getVar('is_active'),
        ]);


        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu(session('level_id'), session('user_id'));

        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => session('level_id'),
            'list_user_level' => session('list_user_level'),
            'list_menu'  => session('list_menu'),
            'list_submenu' => $list_submenu,
            'fullname' => session('fullname'),
            'data_user' => session('data_user')
        ];
        session()->set($data1);

        session()->setFlashdata('pesan', 'Sub Menu Berhasil Diubah');
        session()->setFlashdata('pesan_icon', 'success');

        return redirect()->to('/kelolaSubMenu');
    }
    public function saveSubmenu()
    {
        $this->masterSubmenuModel->save([
            'nama_submenu' => $this->request->getVar('nama_submenu'),
            'menu_id' => $this->request->getVar('menu_id'),
            'link' => $this->request->getVar('link'),
            'is_active' => $this->request->getVar('is_active'),
        ]);
        $list_level_id = $this->masterUserLevelModel->getAllId();
        $last_submenu_id = $this->masterSubmenuModel->getLastId();
        $submenu_id = intval($last_submenu_id['id']);


        for ($i = 0; $i < count($list_level_id); $i++) {
            $this->masterAksesSubmenuModel->save([
                'level_id' => intval($list_level_id[$i]['id']),
                'submenu_id' => $submenu_id,
                'view_level' => 'N',
                'add_level' => 'N',
                'delete_level' => 'N',
                'edit_level' => 'N',
                'print_level' => 'N',
                'upload_level' => 'N'
            ]);
        }

        $list_submenu = $this->masterAksesUserLevelModel->getAksesSubmenu(session('level_id'), session('user_id'));

        $data1 = [
            'log' => TRUE,
            'user_id' => session('user_id'),
            'level_id' => session('level_id'),
            'list_user_level' => session('list_user_level'),
            'list_menu'  => session('list_menu'),
            'list_submenu' => $list_submenu,
            'fullname' => session('fullname'),
            'data_user' => session('data_user')
        ];
        session()->set($data1);

        session()->setFlashdata('pesan', $this->request->getVar('nama_submenu') . ' Berhasil Ditambahkan');
        session()->setFlashdata('pesan_icon', 'success');

        return redirect()->to('/kelolaSubMenu');
    }
}
