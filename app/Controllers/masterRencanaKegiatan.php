<?php

namespace App\Controllers;

class masterRencanaKegiatan extends BaseController
{

    public function __construct()
    {
    }
    public function rencanaKegiatan()
    {

        $data = [
            'title' => 'Rincian Kegiatan',
            'menu' => 'Dashboard',
            'subMenu' => '',
        ];
        return view('Dashboard/rencanaKegiatan', $data);
    }
}
