<?php

namespace App\Controllers;

use App\Models\MasterKegiatanModel;
use App\Models\MasterLaporanHarianModel;
use App\Models\MasterPegawaiModel;
use App\Models\MasterUserModel;
use App\Models\MasterEs3Model;
use DateTime;

class masterRencanaKegiatan extends BaseController
{
    protected $masterKegiatanModel;
    protected $masterLaporanHarianModel;
    protected $masterPegawaiModel;
    protected $masterUserModel;
    protected $masterEs3Model;
    public function __construct()
    {
        $this->masterKegiatanModel = new masterKegiatanModel();
        $this->masterLaporanHarianModel = new masterLaporanHarianModel();
        $this->masterPegawaiModel = new masterPegawaiModel();
        $this->masterUserModel = new masterUserModel();
        $this->masterEs3Model = new masterEs3Model();
    }
    public function rencanaKegiatan()
    {
        $list_kegiatan = $this->masterKegiatanModel->getAllByUserId(session('user_id'));

        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiOnDashboard();

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
            'title' => 'Data Kegiatan',
            'menu' => 'Dashboard',
            'subMenu' => 'Data Kegiatan',
            'list_kegiatan' => $daftar_kegiatan,
            'list_pegawai' => $list_pegawai,
            'dari_verif' => 'off'
        ];
        return view('Dashboard/rencanaKegiatan', $data);
    }


    public function APIRencanaKegiatan($nip_lama, $date_range)
    {

        $user_id = $this->masterUserModel->getUserId($nip_lama);

        $data_user = $this->masterUserModel->getNipLamaByUserId($user_id['id']);

        $list_kegiatan = $this->masterKegiatanModel->getAllByUserId($user_id['id']);

        /////////////////////UBAHHH START DATE KE 1 JANUARI
        $exp_date = explode('-', $date_range);

        if ($date_range == 'all') {
            $start_date = (date('Y') . '-01-01');
            $end_date = date('Y-m-d');
        } else {
            $start_date = $exp_date[2] . '-' . $exp_date[1] . '-' . $exp_date[0];
            $end_date = $exp_date[5] . '-' . $exp_date[4] . '-' . $exp_date[3];
        }

        d($start_date);
        dd($end_date);

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

        $curl_handle = curl_init();
        curl_setopt($curl_handle, CURLOPT_URL, 'https://api-harilibur.vercel.app/api');
        curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_handle, CURLOPT_USERAGENT, 'siphp-skripsi');
        $query = curl_exec($curl_handle);
        curl_close($curl_handle);
        // dd($query);
        // $url = ("https://api-harilibur.vercel.app/api");
        // $get_url = file_get_contents($url, false, stream_context_create($arrContextOptions));
        // $libur_nasional = json_decode($get_url);
        $libur_nasional = json_decode($query);

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
        $list_laporan = $this->masterLaporanHarianModel->getTotalByUserDate($start_date, $end_date, $user_id['id']);
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
                $jam_mulai = $data->jam_mulai;
                $jam_selesai = $data->jam_selesai;
                $tanggal = explode('-', $list3['tgl_kegiatan']);
                if ($tanggal[0] == date('Y')) {
                    foreach ($list_tipe as $tipe) {
                        $cek_tipe[] = $tipe;
                        if ($tipe == '3') {
                            $time1 = new DateTime($jam_mulai[$ke_lembur]);
                            $time2 = new DateTime($jam_selesai[$ke_lembur]);
                            $timediff = $time1->diff($time2);
                            $jml_kegiatan[] = $jam_mulai[$ke_lembur];
                            $all_jam[] = $timediff->format('%h');
                            $all_menit[] = $timediff->format('%i');
                            $jumlah_menit = array_sum($all_menit);

                            while ($jumlah_menit >= 60) {
                                $jumlah_menit = $jumlah_menit - 60;
                                $all_jam[] = 1;
                            }
                            $jumlah_jam = array_sum($all_jam);
                            $jml_lembur++;
                        }
                        $ke_lembur++;
                    }
                }
            }
            if (in_array('3', $cek_tipe) == true) {
                $jumlah['jumlah_kegiatan_lembur'] = count($jml_kegiatan);
                $jumlah['jumlah_jam_lembur'] = $jumlah_jam;
                $jumlah['jumlah_menit_lembur'] = $jumlah_menit;
            } else {
                $jumlah['jumlah_kegiatan_lembur'] = 0;
                $jumlah['jumlah_jam_lembur'] = 0;
                $jumlah['jumlah_menit_lembur'] = 0;
            }
        } else {
            $jumlah['jumlah_kegiatan_lembur'] = 0;
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
                $tgl_kegiatan_harian = $list4['tgl_kegiatan'];
                $laporan = $list4['uraian_kegiatan'];
                $data = json_decode($laporan);
                $list_tipe = $data->kode_tipe;
                $list_uraian = $data->uraian;
                $list_jam_mulai = $data->jam_mulai;
                $list_jam_selesai = $data->jam_selesai;
                foreach ($list_tipe as $tipe3) {
                    if ($tipe3 != '4' && $tipe3 != '3') {
                        $list_laporan4[] = [
                            'tgl_kegiatan' => $tgl_kegiatan_harian,
                            'uraian' => $list_uraian[$ke_harian],
                            'jam_mulai' => $list_jam_mulai[$ke_harian],
                            'jam_selesai' => $list_jam_selesai[$ke_harian]
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
                $time1 = new DateTime($list5['jam_mulai']);
                $time2 = new DateTime($list5['jam_selesai']);
                $timediff = $time1->diff($time2);
                $jam_harian[] = $timediff->format('%h');
                $menit_harian[] = $timediff->format('%i');
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

        //MENGHITUNG JUMLAH JAM KERJA TIDAK TERLAKSANA
        $all_kurang = [];
        if ($list_laporan4 != null) {
            foreach ($list_laporan4 as $list5) {
                $time1 = new DateTime($list5['jam_mulai']);
                $time2 = new DateTime($list5['jam_selesai']);
                $timediff = $time1->diff($time2);
                $jam_tak = $timediff->format('%h');
                $menit_tak = $timediff->format('%i');

                $total_detik_tak = (($jam_tak * 3600) + ($menit_tak * 60));

                if ($total_detik_tak < 27000) {
                    $kurang = 27000 - $total_detik_tak;
                    $all_kurang[] = $kurang;
                } else {
                    $all_kurang[] = 0;
                }

                $detik_kurang = array_sum($all_kurang);
                $jam_kurang = [];
                while ($detik_kurang >= 3600) {
                    $jam_kurang[] = 1;
                    $detik_kurang = $detik_kurang - 3600;
                }
                $menit_kurang = [];
                while ($detik_kurang >= 60) {
                    $menit_kurang[] = 1;
                    $detik_kurang = $detik_kurang - 60;
                }
                $jumlah['jumlah_jam_kerja_terbuang'] = array_sum($jam_kurang);
                $jumlah['jumlah_menit_kerja_terbuang'] = array_sum($menit_kurang);
            }
        } else {
            $jumlah['jumlah_jam_kerja_terbuang'] = 0;
            $jumlah['jumlah_menit_kerja_terbuang'] = 0;
        }

        //BATAS MENGHITUNG JUMLAH JAM KERJA TIDAK TERLAKSANA


        //MENGHITUNG RATA-RATA KEGIATAN PERHARI PRIBADI
        if ($list_laporan4 != null) {
            $rata_rata_kegiatan = (count($list_laporan4) / $jumlah['total_hari_harus_input']);

            $jumlah['rata_rata_kegiatan_pribadi'] = round($rata_rata_kegiatan);
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
                $list_jam_mulai = $data->jam_mulai;
                $list_jam_selesai = $data->jam_selesai;
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

        $list_pegawai_bidang = $this->masterPegawaiModel->getAllPegawaiBidang($kd['satker_kd'], $kd['es3_kd']);
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

            $cek_lapmas = 0;
            foreach ($total_laporan_masing as $lap_mas) {
                if (count($lap_mas) != 0) {
                    foreach ($lap_mas as $lap) {
                        $ke_bid = 0;
                        $laporan_mas = $lap['uraian_kegiatan'];
                        $data_mas = json_decode($laporan_mas);
                        $list_tipe = $data_mas->kode_tipe;
                        $list_uraian = $data_mas->uraian;
                        $list_jam_mulai = $data_mas->jam_mulai;
                        $list_jam_selesai = $data_mas->jam_selesai;
                        foreach ($list_tipe as $tipe4) {
                            $cek_tipe2[] = $tipe4;
                            if ($tipe4 != '4' && $tipe4 != '3') {
                                $cek_lapmas++;
                                $list_laporan6[] = [
                                    'uraian' => $list_uraian[$ke_bid],
                                    'jam_mulai' => $list_jam_mulai[$ke_bid],
                                    'jam_selesai' => $list_jam_selesai[$ke_bid]
                                ];
                            }
                            $ke_bid++;
                        }
                    }
                }
            }
            if ($cek_lapmas == 0) {
                $list_laporan6 = null;
            }


            if ($list_laporan6 != null) {
                foreach ($list_laporan6 as $list7) {
                    $time1 = new DateTime($list5['jam_mulai']);
                    $time2 = new DateTime($list5['jam_selesai']);
                    $timediff = $time1->diff($time2);
                    $jam_bid[] = $timediff->format('%h');
                    $menit_bid[] = $timediff->format('%i');
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
                $jumlah['jumlah_kegiatan_bidang'] = round(count($list_laporan6) / $jumlah['total_hari_harus_input'] / count($list_pegawai_bidang));
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
                    $allkegiatan[] = $list;
                } else {
                    $allkegiatan = null;
                }
            }
        } else {
            $allkegiatan = null;
        }

        $status_rincian = null;
        $status_verifikasi = null;
        if ($allkegiatan != null) {
            foreach ($allkegiatan as $all) {
                if ($all['status_rincian'] == 'B') {
                    $status_rincian =  'Belum ditindaklanjuti';
                } elseif ($all['status_rincian'] == 'T') {
                    $status_rincian =  'Sedang ditindaklanjuti';
                } else {
                    $status_rincian =  'Selesai ditindaklanjuti';
                }

                if ($all['status_verifikasi'] == 'B') {
                    $status_verifikasi =  'Belum diverifikasi';
                } else {
                    $status_verifikasi =  'sudah diverifikasi';
                }
                $jumlah['daftar_kegiatan'][] = [
                    'id' => $all['id'],
                    'user_id' => $all['user_id'],
                    'rincian_kegiatan' => $all['rincian_kegiatan'],
                    'tipe_kegiatan' => $all['tipe_kegiatan'],
                    'status_rincian' => $status_rincian,
                    'status_verifikasi' => $status_verifikasi,
                    'tgl_input' => $all['tgl_input'],
                    'tgl_update' => $all['tgl_update']
                ];
            }
        } else {
            $jumlah['daftar_kegiatan'] = null;
        }

        //BATAS UNTUK DAFTAR LIST KEGIATAN

        $nama_pegawai = $this->masterPegawaiModel->getProfilCetak($data_user['nip_lama_user']);
        $nama_bidang = $this->masterEs3Model->getBidangById($nama_pegawai['es3_kd']);

        $jumlah['nama_pegawai'] = $nama_pegawai['nama_pegawai'];
        $jumlah['nama_bidang'] = $nama_bidang['deskripsi'];
        $jumlah['es3_kd'] = $nama_pegawai['es3_kd'];
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

    public function batalStatusRincian($id_kegiatan)
    {
        $this->masterKegiatanModel->save([
            'id' => $id_kegiatan,
            'status_rincian' => 'T',
        ]);

        return redirect()->to('/rincianKegiatanPegawai');
    }

    public function hapusStatusRincian($id_kegiatan)
    {
        $this->masterKegiatanModel->delete($id_kegiatan);
        return redirect()->to('/rincianKegiatanPegawai');
    }

    public function riwayatRencanaKegiatan($nip_lama)
    {
        $user_id = $this->masterUserModel->getUserId($nip_lama);
        $list_kegiatan = $this->masterKegiatanModel->getAllByUserIdOrderYear($user_id['id']);

        $data = [
            'title' => 'Data Kegiatan',
            'menu' => 'Dashboard',
            'subMenu' => '',
            'list_kegiatan' => $list_kegiatan,
            'nip_lama' => $nip_lama
        ];

        return view('Dashboard/riwayatKegiatan', $data);
    }

    public function detailRencanaKegiatan($id_kegiatan, $nip_lama)
    {

        $user_id = $this->masterUserModel->getUserId($nip_lama);
        $data_kegiatan = $this->masterKegiatanModel->getDataById($id_kegiatan);

        $list_laporan = $this->masterLaporanHarianModel->getAllLaporanByUserId($user_id['id']);
        $cek = [];
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
            'title' => 'Data Kegiatan',
            'menu' => 'Dashboard',
            'subMenu' => '',
            'data_kegiatan' => $data_kegiatan,
            'list_kegiatan' => $list_kegiatan
        ];
        // dd($data);

        return view('Dashboard/detailKegiatan', $data);
    }

    public function verifikasiKegiatan($id_kegiatan)
    {
        $this->masterKegiatanModel->save([
            'id' => $id_kegiatan,
            'status_verifikasi' => 'S',
        ]);

        $user_id = $this->masterKegiatanModel->getDataById($id_kegiatan);
        $data_user = $this->masterUserModel->getProfilUser($user_id['user_id']);


        $list_kegiatan = $this->masterKegiatanModel->getAllByUserId($user_id['user_id']);

        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiOnDashboard();


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
            'title' => 'Data Kegiatan',
            'menu' => 'Dashboard',
            'subMenu' => 'Kegiatan Pegawai',
            'list_kegiatan' => $daftar_kegiatan,
            'list_pegawai' => $list_pegawai,
            'dari_verif' => 'on',
            'nip_lama_terpilih' => $data_user['nip_lama_user']
        ];
        return view('Dashboard/rencanaKegiatan', $data);
    }
}
