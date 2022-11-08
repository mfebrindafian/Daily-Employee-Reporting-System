<?php

namespace App\Controllers;

use App\Models\MasterKegiatanModel;

class masterRencanaKegiatan extends BaseController
{
    protected $masterKegiatanModel;
    public function __construct()
    {

        $this->masterKegiatanModel = new masterKegiatanModel();
    }
    public function rencanaKegiatan()
    {
        $list_kegiatan = $this->masterKegiatanModel->getAllByUserId(session('user_id'));

        if ($list_kegiatan != null) {
            foreach ($list_kegiatan as $list) {
                $kegiatan = explode('-', $list['tgl_input']);
                if ($kegiatan[0] == date('Y')) {
                    $daftar_kegiatan[] = $list;
                } else {
                    $daftar_kegiatan = null;
                }
            }
        } else {
            $daftar_kegiatan = null;
        }

        $data = [
            'title' => 'Rincian Kegiatan',
            'menu' => 'Dashboard',
            'subMenu' => '',
            'list_kegiatan' => $daftar_kegiatan
        ];
        return view('Dashboard/rencanaKegiatan', $data);
    }

    public function tambahRencanaKegiatan()
    {
        $field_uraian = $this->request->getVar('field_uraian');
        $field_tipe = $this->request->getVar('field_tipe');

        $jumlah = count($field_uraian);

        if ($jumlah != null) {
            for ($i = 0; $i < $jumlah; $i++) {
                $this->masterKegiatanModel->save([
                    'user_id' => session('user_id'),
                    'rincian_kegiatan' => $field_uraian[$i],
                    'tipe_kegiatan' => $field_tipe[$i],
                    'status_rincian' => 'B',
                    'tgl_input' => date('Y-m-d'),
                    'tgl_update' => null
                ]);
            }
        }

        return redirect()->to('/rincianKegiatanPegawai');
    }

    public function updateStatusRincian($id_kegiatan)
    {
        $this->masterKegiatanModel->save([
            'id' => $id_kegiatan,
            'status_rincian' => 'S',
        ]);

        return redirect()->to('/rincianKegiatanPegawai');
    }

    public function hapusStatusRincian($id_kegiatan)
    {
        $this->masterKegiatanModel->delete($id_kegiatan);
        return redirect()->to('/rincianKegiatanPegawai');
    }

    public function riwayatRencanaKegiatan()
    {
        $user_id = session('user_id');
        $list_rencana = $this->masterKegiatanModel->getAllByUserIdOrderYear($user_id);

        $data = [
            'title' => 'Rincian Kegiatan',
            'menu' => 'Dashboard',
            'subMenu' => '',
            'list_kegiatan' => $list_rencana
        ];

        return view('Dashboard/riwayatKegiatan', $data);
    }

    public function detailtRencanaKegiatan()
    {
        $data = [];

        return view('Dashboard/detailKegiatan', $data);
    }
}
