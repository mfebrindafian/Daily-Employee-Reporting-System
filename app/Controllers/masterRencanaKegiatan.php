<?php

namespace App\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterLaporanHarianModel;
use App\Models\MasterPegawaiModel;
use App\Models\MasterUserModel;
use DateTime;

class masterRencanaKegiatan extends BaseController
{
    protected $masterKegiatanModel;
    protected $masterLaporanHarianModel;
    protected $masterPegawaiModel;
    protected $masterUserModel;
    public function __construct()
    {
        $this->masterKegiatanModel = new masterKegiatanModel();
        $this->masterLaporanHarianModel = new masterLaporanHarianModel();
        $this->masterPegawaiModel = new masterPegawaiModel();
        $this->masterUserModel = new masterUserModel();
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
            'list_kegiatan' => $daftar_kegiatan,
        ];
        return view('Dashboard/rencanaKegiatan', $data);
    }


    public function APIRencanaKegiatan($user_id)
    {

        $data_user = $this->masterUserModel->getNipLamaByUserId($user_id);

        $list_kegiatan = $this->masterKegiatanModel->getAllByUserId($user_id);

        /////////////////////UBAHHH START DATE KE 1 JANUARI
        $start_date = (date('Y') . '-11-01');
        $end_date = date('Y-m-d');
        //MENGHITUNG HARI-HARI DIMULAI 1 JANUARI SAMPAI HARI INI DENGAN IRISAN KONDISI
        $rangArray = [];
        $startDate = strtotime($start_date);
        $endDate = strtotime($end_date);
        for (
            $currentDate = $startDate;
            $currentDate <= $endDate;
            $currentDate += (86400)
        ) {
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date; //SELURUH HARI MULAI 1 JANUARI SAMPAI HARI INI
        }

        foreach ($rangArray as $rang) {
            if (date('N', strtotime($rang)) < 6) {
                $rangArray2[] = $rang; //SELURUH HARI MULAI 1 JANUARI SAMPAI HARI INI TANPA SABTU DAN MINGGU
            }
        }
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $url = ("https://api-harilibur.vercel.app/api");
        $get_url = file_get_contents($url, false, stream_context_create($arrContextOptions));
        $libur_nasional = json_decode($get_url);
        foreach ($libur_nasional as $libur) {
            if ($libur->is_national_holiday == 'true') {
                $tanggal = new DateTime($libur->holiday_date);
                $libur_nasional2[] = $tanggal->format('Y-m-d');
            }
        }
        foreach ($rangArray2 as $rang2) {
            if (in_array($rang2, $libur_nasional2) == false) {
                $rangArray3[] = $rang2;  //SELURUH HARI MULAI 1 JANUARI SAMPAI HARI INI TANPA SABTU DAN MINGGU DAN LIBUR NASIONAL
            }
        }

        //BATAS MENGHITUNG HARI-HARI DIMULAI 1 JANUARI SAMPAI HARI INI DENGAN IRISAN KONDISI

        $jumlah['total_hari_harus_input'] = count($rangArray3); //TOTAL HARI HARUS INPUT LAPORAN TAHUN INI


        //MENGHITUNG SELURUH LAPORAN HARI KERJA YANG TELAH DIINPUTKAN DENGAN BATASAN IRISAN (SELURUH HARI MULAI 1 JANUARI SAMPAI HARI INI TANPA SABTU DAN MINGGU DAN LIBUR NASIONAL)
        $list_laporan = $this->masterLaporanHarianModel->getTotalByUserDate($start_date, $end_date, $user_id);
        if ($list_laporan != null) {
            foreach ($list_laporan as $listlap) {
                if (in_array($listlap['tgl_kegiatan'], $rangArray3) == true) {
                    $list_laporan2[] = $listlap;
                }
            }
        } else {
            $list_laporan2 = null;
        }

        if ($list_laporan2 != null) {
            $jumlah['total_hari_kerja_telah_input'] = count($list_laporan2);
        } else {
            $jumlah['total_hari_kerja_telah_input'] = 0;
        }
        //BATAS MENGHITUNG SELURUH LAPORAN HARI KERJA YANG TELAH DIINPUTKAN DENGAN BATASAN IRISAN (SELURUH HARI MULAI 1 JANUARI SAMPAI HARI INI TANPA SABTU DAN MINGGU DAN LIBUR NASIONAL)

        //MENGHITUNG JUMLAH KEGIATAN LEMBUR
        foreach ($rangArray as $rang4) {
            if (in_array($rang4, $libur_nasional2) == false) {
                $rangArray4[] = $rang4;  //SELURUH HARI MULAI 1 JANUARI SAMPAI HARI INI TANPA LIBUR NASIONAL
            }
        }
        if ($list_laporan != null) {
            foreach ($list_laporan as $listlap) {
                if (in_array($listlap['tgl_kegiatan'], $rangArray4) == true) {
                    $list_laporan3[] = $listlap;
                }
            }
        } else {
            $list_laporan3 = null;
        }

        $jml_lembur = 0;
        if ($list_laporan3 != null) {
            foreach ($list_laporan3 as $list3) {
                $ke_lembur = 0;
                $laporan = $list3['uraian_kegiatan'];
                $data = json_decode($laporan);
                $list_tipe = $data->kode_tipe;
                $list_durasi_jam = $data->durasi_jam;
                $list_durasi_menit = $data->durasi_menit;
                $tanggal = explode('-', $list3['tgl_kegiatan']);
                if ($tanggal[0] == date('Y')) {
                    foreach ($list_tipe as $tipe) {
                        $cek_tipe[] = $tipe;
                        if ($tipe == '3') {
                            $jam[] = intval($list_durasi_jam[$ke_lembur]);
                            $menit[] = intval($list_durasi_menit[$ke_lembur]);
                            $jml_lembur++;
                        }
                        $ke_lembur++;
                    }
                }
            }
            if (in_array('3', $cek_tipe) == true) {
                $jumlah_menit = array_sum($menit);
                while ($jumlah_menit >= 60) {
                    $jumlah_menit = $jumlah_menit - 60;
                    $jam[] = 1;
                }

                $jumlah_jam = array_sum($jam);
                $jumlah['jumlah_jam_lembur'] = $jumlah_jam;
                $jumlah['jumlah_menit_lembur'] = $jumlah_menit;
            }
        } else {
            $jumlah['jumlah_jam_lembur'] = 0;
            $jumlah['jumlah_menit_lembur'] = 0;
        };

        //BATAS MENGHITUNG JUMLAH KEGIATAN LEMBUR


        //UNTUK MENGHITUNG JUMLAH STATUS RINCIAN BELUM, SEDANG DAN SELESAI DITINDAKLANJUTI

        if ($list_kegiatan != null) {
            foreach ($list_kegiatan as $list) {
                $cek_status_rincian[] = $list['status_rincian'];
                $tipe_status = ['B', 'T', 'S'];
                foreach ($tipe_status as $tipe) {
                    if ($list['status_rincian'] == $tipe) {
                        $array1[$tipe][] = $list;
                        $jumlah['rincian'][$tipe] = count($array1[$tipe]);
                    }
                }

                foreach ($tipe_status as $tipe) {
                    if (in_array($tipe, $cek_status_rincian) == false) {
                        $jumlah['rincian'][$tipe] = 0;
                    }
                }
                //BATAS UNTUK MENGHITUNG JUMLAH STATUS RINCIAN BELUM, SEDANG DAN SELESAI DITINDAKLANJUTI

                //UNTUK MENGHITUNG JUMLAH STATUS RINCIAN BELUM DAN SELESAI DIVERIFIKASI KOORDINATOR
                $tipe_status2 = ['B', 'S'];
                $cek_status_verifikasi[] = $list['status_verifikasi'];
                foreach ($tipe_status2 as $tipe2) {
                    if ($list['status_verifikasi'] == $tipe2) {
                        $array2[$tipe2][] = $list;
                        $jumlah['verif'][$tipe2] = count($array2[$tipe2]);
                    }
                }
                foreach ($tipe_status2 as $tipe2) {
                    if (in_array($tipe2, $cek_status_verifikasi) == false) {
                        $jumlah['verif'][$tipe2] = 0;
                    }
                }
                // BATAS UNTUK MENGHITUNG JUMLAH STATUS RINCIAN BELUM DAN SELESAI DIVERIFIKASI KOORDINATOR

            }
        } else {
            $tipe_status = ['B', 'T', 'S'];
            foreach ($tipe_status as $tipe) {
                $jumlah['rincian'][$tipe] = 0;
            }
            $tipe_status2 = ['B', 'S'];
            foreach ($tipe_status2 as $tipe2) {
                $jumlah['verif'][$tipe2] = 0;
            }
        }



        //UNTUK MENGHITUNG RATA-RATA JAM KERJA HARIAN PRIBADI
        if ($list_laporan2 != null) {
            foreach ($list_laporan2 as $list4) {
                $ke_harian = 0;
                $laporan = $list4['uraian_kegiatan'];
                $data = json_decode($laporan);
                $list_tipe = $data->kode_tipe;
                $list_uraian = $data->uraian;
                $list_durasi_jam = $data->durasi_jam;
                $list_durasi_menit = $data->durasi_menit;
                foreach ($list_tipe as $tipe3) {
                    if ($tipe3 != '4' && $tipe3 != '3') {
                        $list_laporan4[] = [
                            'uraian' => $list_uraian[$ke_harian],
                            'durasi_jam' => $list_durasi_jam[$ke_harian],
                            'durasi_menit' => $list_durasi_menit[$ke_harian]
                        ]; //LIST LAPORAN TANPA CUTI dan TANPA LEMBUR

                    }
                    $ke_harian++;
                }
            }
        } else {
            $list_laporan4 = null;
        }

        if ($list_laporan4 != null) {
            foreach ($list_laporan4 as $list5) {
                $jam_harian[] = intval($list5['durasi_jam']);
                $menit_harian[] = intval($list5['durasi_menit']);
            }
            $jumlah_jam_harian = array_sum($jam_harian);
            $jumlah_menit_harian = array_sum($menit_harian);
            $total_detik = (($jumlah_jam_harian * 3600) + ($jumlah_menit_harian * 60));
            $bagi_detik = ($total_detik /  $jumlah['total_hari_harus_input']);

            $jml_jam_harian = 0;
            while ($bagi_detik >= 3600) {
                $bagi_detik = $bagi_detik - 3600;
                $jml_jam_harian++;
            }
            $jml_menit_harian = 0;
            while ($bagi_detik >= 60) {
                $bagi_detik = $bagi_detik - 60;
                $jml_menit_harian++;
            }
            $jumlah['rata_rata_jam'] = $jml_jam_harian;
            $jumlah['rata_rata_menit'] = $jml_menit_harian;
        } else {
            $jumlah['rata_rata_jam'] = 0;
            $jumlah['rata_rata_menit'] = 0;
        }
        //BATAS MENGHITUNG RATA-RATA JAM KERJA HARIAN PRIBADI


        //MENGHITUNG RATA-RATA KEGIATAN PERHARI PRIBADI
        if ($list_laporan4 != null) {
            $rata_rata_kegiatan = (count($list_laporan4) / $jumlah['total_hari_harus_input']);
            $jumlah['rata_rata_kegiatan_pribadi'] = floor($rata_rata_kegiatan);
        } else {
            $jumlah['rata_rata_kegiatan_pribadi'] = 0;
        }
        //BATAS MENGHITUNG RATA-RATA KEGIATAN PERHARI PRIBADI

        //MENGHITUNG JUMLAH CUTI
        if ($list_laporan2 != null) {
            foreach ($list_laporan2 as $list4) {
                $ke_harian = 0;
                $laporan = $list4['uraian_kegiatan'];
                $data = json_decode($laporan);
                $list_tipe = $data->kode_tipe;
                $list_uraian = $data->uraian;
                $list_durasi_jam = $data->durasi_jam;
                $list_durasi_menit = $data->durasi_menit;
                foreach ($list_tipe as $tipe4) {
                    $cek_tipe2[] = $tipe4;
                    if ($tipe4 == '4') {
                        $list_laporan5[] = [
                            'uraian' => $list_uraian[$ke_harian],

                        ]; //LIST LAPORAN TANPA CUTI dan TANPA LEMBUR

                    }
                    $ke_harian++;
                }
            }
            if (in_array('4', $cek_tipe2) == false) {
                $list_laporan5 = null;
            }
        } else {
            $list_laporan5 = null;
        }


        if ($list_laporan5 != null) {
            $jumlah['jumlah_cuti'] = count($list_laporan5);
        } else {
            $jumlah['jumlah_cuti'] = 0;
        }
        //BATAS MENGHITUNG JUMLAH CUTI

        //MENGHITUNG RATA-RATA JAM KERJA HARIAN PEGAWAI DI BIDANG YANG SAMA
        $kd = $this->masterPegawaiModel->getProfilCetak($data_user['nip_lama_user']);

        $list_pegawai_bidang = $this->masterPegawaiModel->getAllPegawaiOnBidang($kd['satker_kd'], $kd['es3_kd']);
        $ke = 0;
        if ($list_pegawai_bidang != null) {
            foreach ($list_pegawai_bidang as $pegawai) {
                $nip_lama_pegawai = $this->masterPegawaiModel->getNipLama($pegawai['id']);
                $user_id_pegawai_laporan = $this->masterUserModel->getUserId($nip_lama_pegawai['nip_lama']);
                if ($user_id_pegawai_laporan != null) {
                    $total_laporan_masing[$ke] = $this->masterLaporanHarianModel->getAllLaporanByUserId($user_id_pegawai_laporan['id']);
                } else {
                    $total_laporan_masing[$ke] = [];
                }
                $ke++;
            }

            foreach ($total_laporan_masing as $lap_mas) {
                if (count($lap_mas) != 0) {
                    foreach ($lap_mas as $lap) {
                        $ke_bid = 0;
                        $laporan = $lap['uraian_kegiatan'];
                        $data = json_decode($laporan);
                        $list_tipe = $data->kode_tipe;
                        $list_uraian = $data->uraian;
                        $list_durasi_jam = $data->durasi_jam;
                        $list_durasi_menit = $data->durasi_menit;
                        foreach ($list_tipe as $tipe4) {
                            $cek_tipe2[] = $tipe4;
                            if ($tipe4 != '4' && $tipe3 != '3') {
                                $list_laporan6[] = [
                                    'uraian' => $list_uraian[$ke_bid],
                                    'durasi_jam' => $list_durasi_jam[$ke_bid],
                                    'durasi_menit' => $list_durasi_menit[$ke_bid]
                                ];
                            }
                            $ke_bid++;
                        }
                    }
                } else {
                    $list_laporan6 = null;
                }
            }

            if ($list_laporan6 != null) {
                foreach ($list_laporan6 as $list7) {
                    $jam_bid[] = intval($list7['durasi_jam']);
                    $menit_bid[] = intval($list7['durasi_menit']);
                }

                $jumlah_jam_bid = array_sum($jam_bid);
                $jumlah_menit_bid = array_sum($menit_bid);
                $total_detik_bid = (($jumlah_jam_bid * 3600) + ($jumlah_menit_bid * 60));
                $bagi_detik_bid = ($total_detik_bid /  $jumlah['total_hari_harus_input'] / count($list_pegawai_bidang));
                $jml_jam_bid = 0;
                while ($bagi_detik_bid >= 3600) {
                    $bagi_detik_bid = $bagi_detik_bid - 3600;
                    $jml_jam_bid++;
                }
                $jml_menit_bid = 0;
                while ($bagi_detik_bid >= 60) {
                    $bagi_detik_bid = $bagi_detik_bid - 60;
                    $jml_menit_bid++;
                }
                $jumlah['rata_rata_jam_bidang'] = $jml_jam_bid;
                $jumlah['rata_rata_menit_bidang'] = $jml_menit_bid;
            } else {
                $jumlah['rata_rata_jam_bidang'] = 0;
                $jumlah['rata_rata_menit_bidang'] = 0;
            }
        } else {
            $jumlah['rata_rata_jam_bidang'] = 0;
            $jumlah['rata_rata_menit_bidang'] = 0;
        }
        //BATAS MENGHITUNG RATA JAM KERJA HARIA PEGAWAI DI BIDANG YANG SAMA 

        //MENGHITUNG JUMLAH KEGIATAN YANG DIKERJAKAN BIDANG YANG SAMA
        if ($list_pegawai_bidang != null) {
            if ($list_laporan6 != null) {
                $jumlah['jumlah_kegiatan_bidang'] = count($list_laporan6);
            } else {
                $jumlah['jumlah_kegiatan_bidang'] = 0;
            }
        } else {
            $jumlah['jumlah_kegiatan_bidang'] = 0;
        }
        //BATAS MENGHITUNG JUMLAH KEGIATAN YANG DIKERJAKAN BIDANG YANG SAMA

        // UNTUK DAFTAR LIST KEGIATAN
        if ($list_kegiatan != null) {
            foreach ($list_kegiatan as $list) {
                $kegiatan = explode('-', $list['tgl_input']);
                if ($kegiatan[0] == date('Y')) {
                    $jumlah['daftar_kegiatan'][] = $list;
                } else {
                    $jumlah['daftar_kegiatan'] = null;
                }
            }
        } else {
            $jumlah['daftar_kegiatan'] = null;
        }
        //BATAS UNTUK DAFTAR LIST KEGIATAN

        $jumlah['periode_awal'] = $start_date;
        $jumlah['periode_akhir'] = $end_date;

        echo (json_encode($jumlah));
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
