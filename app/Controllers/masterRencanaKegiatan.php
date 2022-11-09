<?php

namespace App\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterLaporanHarianModel;

class masterRencanaKegiatan extends BaseController
{
    protected $masterKegiatanModel;
    protected $masterLaporanHarianModel;
    public function __construct()
    {
        $this->masterKegiatanModel = new masterKegiatanModel();
        $this->masterLaporanHarianModel = new masterLaporanHarianModel();
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

    public function detailRencanaKegiatan($id_kegiatan)
    {
        $data_kegiatan = $this->masterKegiatanModel->getDataById($id_kegiatan);

        $list_laporan = $this->masterLaporanHarianModel->getAllLaporanByUserId(session('user_id'));

        foreach ($list_laporan as $list) {
            $laporan = $list['uraian_kegiatan'];
            $data = json_decode($laporan);
            $list_tipe = $data->kode_tipe;
            $list_rencana = $data->kd_rencana;
            $list_uraian = $data->uraian;
            $list_jumlah = $data->jumlah;
            $list_satuan = $data->satuan;
            $list_hasil = $data->hasil;
            $list_durasi_jam = $data->durasi_jam;
            $list_durasi_menit = $data->durasi_menit;
            $list_bukti_dukung = $data->bukti_dukung;
            $ke = 0;
            foreach ($list_rencana as $rencana) {
                $cek[] = $rencana;
                if ($rencana == $id_kegiatan) {
                    $list_kegiatan[] = [
                        'tgl_kegiatan' => $list['tgl_kegiatan'],
                        'kode_tipe' =>   $list_tipe[$ke],
                        'kd_rencana' => $list_rencana[$ke],
                        'uraian' => $list_uraian[$ke],
                        'jumlah' => $list_jumlah[$ke],
                        'satuan' => $list_satuan[$ke],
                        'hasil' => $list_hasil[$ke],
                        'durasi_jam' => $list_durasi_jam[$ke],
                        'durasi_menit' => $list_durasi_menit[$ke],
                        'bukti_dukung' => $list_bukti_dukung[$ke],
                    ];
                }
                $ke++;
            }
        }

        if (in_array($id_kegiatan, $cek) == false) {
            $list_kegiatan = null;
        }

        $data = [
            'title' => 'Rincian Kegiatan',
            'menu' => 'Dashboard',
            'subMenu' => '',
            'data_kegiatan' => $data_kegiatan,
            'list_kegiatan' => $list_kegiatan
        ];
        // dd($data);

        return view('Dashboard/detailKegiatan', $data);
    }
}
