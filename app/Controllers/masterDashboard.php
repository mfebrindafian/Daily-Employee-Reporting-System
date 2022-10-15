<?php

namespace App\Controllers;




use App\Models\MasterLaporanHarianModel;
use App\Models\MasterUserModel;
use App\Models\MasterSatuanModel;
use App\Models\MasterPegawaiModel;
use App\Models\MasterGolonganModel;
use App\Models\MasterPendidikanModel;
use App\Models\MasterSatkerModel;
use App\Models\MasterFungsionalModel;
use App\Models\MasterCatatanModel;
use CodeIgniter\I18n\Time;


class masterDashboard extends BaseController
{
    protected $masterLaporanHarianModel;
    protected $masterDashboardModel;
    protected $masterUserModel;
    protected $masterPegawaiModel;
    protected $masterGolonganModel;
    protected $masterPendidikanModel;
    protected $masterSatkerModel;
    protected $masterFungsionalModel;
    protected $masterCatatanModel;

    public function __construct()
    {

        $this->masterUserModel = new masterUserModel();
        $this->masterLaporanHarianModel = new masterLaporanHarianModel();
        $this->masterSatuanModel = new masterSatuanModel();
        $this->masterPegawaiModel = new MasterPegawaiModel();
        $this->masterGolonganModel = new MasterGolonganModel();
        $this->masterPendidikanModel = new MasterPendidikanModel();
        $this->masterSatkerModel = new MasterSatkerModel();
        $this->masterFungsionalModel = new MasterFungsionalModel();
        $this->masterCatatanModel = new MasterCatatanModel();
    }

    public function index()
    {
        $event_data = $this->masterLaporanHarianModel->getAll(session('user_id'));

        $list_user = $this->masterUserModel->getAllUserOnDashboard();
        if (session('level_id') == "7") {
            if ($event_data != NULL) {
                foreach ($event_data as $row) {

                    $events[] = array(
                        'link' => base_url('/showDetailLaporanHarianOnDashboard/' . $row['id']),
                        'tgl' => $row['tgl_kegiatan']
                    );
                }
                $events_json = json_encode($events);
                $tanggal_mulai = "2022-07-01";
            } else {
                $events[] = array('');
                $events_json = json_encode($events);
                $tanggal_mulai = "";
            }
        } else {
            $events[] = array('');
            $events_json = json_encode($events);
            $tanggal_mulai = "";
        }

        $catatan_data = $this->masterCatatanModel->getAll(session('user_id'));
        if (session('level_id') == "7") {
            if ($catatan_data != NULL) {
                foreach ($catatan_data as $catatan) {
                    $pengirim = $this->masterUserModel->getDataPegawaiByUserId($catatan['user_id']);
                    $penerima = $this->masterUserModel->getDataPegawaiByUserId($catatan['user_id_penerima']);

                    $catatan_all[] = array(
                        'id' => $catatan['id'],
                        'id_pengirim' => $catatan['user_id'],
                        'pengirim' => $pengirim['nama_pegawai'],
                        'id_penerima' => $catatan['user_id_penerima'],
                        'penerima' => $penerima['nama_pegawai'],
                        'catatan' => $catatan['catatan'],
                        'tgl' => $catatan['tgl_catatan']
                    );
                }
                $catatan_json = json_encode($catatan_all);
            } else {
                $catatan_all[] = array('');
                $catatan_json = json_encode($catatan_all);
            }
        } else {
            $catatan_all[] = array('');
            $catatan_json = json_encode($catatan_all);
        }





        $total_laporan = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));


        $januari = [];
        $februari = [];
        $maret = [];
        $april = [];
        $april = [];
        $mei = [];
        $juni = [];
        $juli = [];
        $agustus = [];
        $september = [];
        $oktober = [];
        $november = [];
        $desember = [];
        $laporan_bulan_ini = [];
        $list_uraian = [];
        $jml_bulan_pegawai = [];
        $jml_bulan_pegawai = [];
        $laporan_bulan_pegawai = [];
        if ($total_laporan != NULL) {
            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $bulan[] = $data[1];
                if ($bulan[$i] == date('m')) {
                    $laporan_bulan_ini[] = $total_laporan[$i];
                }
            }


            foreach ($laporan_bulan_ini as $bulan) {
                $laporan = $bulan['uraian_kegiatan'];
                $data = json_decode($laporan);
                $list_uraian[] = $data->uraian;
            }

            $kegiatan_bulan_ini = 0;

            for ($i = 0; $i < count($list_uraian); $i++) {
                $kegiatan_bulan_ini = $kegiatan_bulan_ini + count($list_uraian[$i]);
            }

            //untuk kebutuhan chart
            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $tahun[] = $data[0];
                if ($tahun[$i] == date('Y')) {
                    $laporan_tahun_ini[] = $total_laporan[$i];
                }
            }

            foreach ($laporan_tahun_ini as $tahun) {
                $laporan_tahun = $tahun['uraian_kegiatan'];
                $data_tahun = json_decode($laporan_tahun);
                $list_uraian_tahun[] = $data_tahun->uraian;
            }
            $kegiatan_tahun_ini = 0;

            for ($i = 0; $i < count($list_uraian_tahun); $i++) {
                $kegiatan_tahun_ini = $kegiatan_tahun_ini + count($list_uraian_tahun[$i]);
            }



            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $bulan[] = $data[1];
                $tahun[] = $data[0];
                if ($bulan[$i] == '01' && $tahun[$i] == date('Y')) {
                    $januari[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '02' && $tahun[$i] == date('Y')) {
                    $februari[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '03' && $tahun[$i] == date('Y')) {
                    $maret[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '04' && $tahun[$i] == date('Y')) {
                    $april[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '05' && $tahun[$i] == date('Y')) {
                    $mei[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '06' && $tahun[$i] == date('Y')) {
                    $juni[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '07' && $tahun[$i] == date('Y')) {
                    $juli[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '08' && $tahun[$i] == date('Y')) {
                    $agustus[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '09' && $tahun[$i] == date('Y')) {
                    $september[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '10' && $tahun[$i] == date('Y')) {
                    $oktober[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '11' && $tahun[$i] == date('Y')) {
                    $november[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '12' && $tahun[$i] == date('Y')) {
                    $desember[] = $total_laporan[$i];
                }
            }
        } else {
            $laporan_bulan_ini = null;
            $kegiatan_bulan_ini = 0;
            $kegiatan_tahun_ini = 0;
            $kegiatan_januari_ini = 0;
            $kegiatan_februari_ini = 0;
            $kegiatan_maret_ini = 0;
            $kegiatan_april_ini = 0;
            $kegiatan_mei_ini = 0;
            $kegiatan_juni_ini = 0;
            $kegiatan_juli_ini = 0;
            $kegiatan_agustus_ini = 0;
            $kegiatan_september_ini = 0;
            $kegiatan_oktober_ini = 0;
            $kegiatan_november_ini = 0;
            $kegiatan_desember_ini = 0;
        }


        if ($januari != null) {
            foreach ($januari as $hitung_kegiatan) {
                $kegiatan_januari = $hitung_kegiatan['uraian_kegiatan'];
                $data_januari = json_decode($kegiatan_januari);
                $list_uraian_januari[] = $data_januari->uraian;
            }
            $kegiatan_januari_ini = 0;
            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_januari); $hitung_kegiatan++) {
                $kegiatan_januari_ini = $kegiatan_januari_ini + count($list_uraian_januari[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_januari_ini = 0;
        }
        if ($februari != null) {
            foreach ($februari as $hitung_kegiatan) {
                $kegiatan_februari = $hitung_kegiatan['uraian_kegiatan'];
                $data_februari = json_decode($kegiatan_februari);
                $list_uraian_februari[] = $data_februari->uraian;
            }
            $kegiatan_februari_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_februari); $hitung_kegiatan++) {
                $kegiatan_februari_ini = $kegiatan_februari_ini + count($list_uraian_februari[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_februari_ini = 0;
        }
        if ($maret != null) {
            foreach ($maret as $hitung_kegiatan) {
                $kegiatan_maret = $hitung_kegiatan['uraian_kegiatan'];
                $data_maret = json_decode($kegiatan_maret);
                $list_uraian_maret[] = $data_maret->uraian;
            }
            $kegiatan_maret_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_maret); $hitung_kegiatan++) {
                $kegiatan_maret_ini = $kegiatan_maret_ini + count($list_uraian_maret[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_maret_ini = 0;
        }
        if ($april != null) {
            foreach ($april as $hitung_kegiatan) {
                $kegiatan_april = $hitung_kegiatan['uraian_kegiatan'];
                $data_april = json_decode($kegiatan_april);
                $list_uraian_april[] = $data_april->uraian;
            }
            $kegiatan_april_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_april); $hitung_kegiatan++) {
                $kegiatan_april_ini = $kegiatan_april_ini + count($list_uraian_april[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_april_ini = 0;
        }
        if ($mei != null) {
            foreach ($mei as $hitung_kegiatan) {
                $kegiatan_mei = $hitung_kegiatan['uraian_kegiatan'];
                $data_mei = json_decode($kegiatan_mei);
                $list_uraian_mei[] = $data_mei->uraian;
            }
            $kegiatan_mei_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_mei); $hitung_kegiatan++) {
                $kegiatan_mei_ini = $kegiatan_mei_ini + count($list_uraian_mei[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_mei_ini = 0;
        }
        if ($juni != null) {
            foreach ($juni as $hitung_kegiatan) {
                $kegiatan_juni = $hitung_kegiatan['uraian_kegiatan'];
                $data_juni = json_decode($kegiatan_juni);
                $list_uraian_juni[] = $data_juni->uraian;
            }
            $kegiatan_juni_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_juni); $hitung_kegiatan++) {
                $kegiatan_juni_ini = $kegiatan_juni_ini + count($list_uraian_juni[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_juni_ini = 0;
        }
        if ($juli != null) {
            foreach ($juli as $hitung_kegiatan) {
                $kegiatan_juli = $hitung_kegiatan['uraian_kegiatan'];
                $data_juli = json_decode($kegiatan_juli);
                $list_uraian_juli[] = $data_juli->uraian;
            }
            $kegiatan_juli_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_juli); $hitung_kegiatan++) {
                $kegiatan_juli_ini = $kegiatan_juli_ini + count($list_uraian_juli[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_juli_ini = 0;
        }
        if ($agustus != null) {
            foreach ($agustus as $hitung_kegiatan) {
                $kegiatan_agustus = $hitung_kegiatan['uraian_kegiatan'];
                $data_agustus = json_decode($kegiatan_agustus);
                $list_uraian_agustus[] = $data_agustus->uraian;
            }
            $kegiatan_agustus_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_agustus); $hitung_kegiatan++) {
                $kegiatan_agustus_ini = $kegiatan_agustus_ini + count($list_uraian_agustus[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_agustus_ini = 0;
        }
        if ($september != null) {
            foreach ($september as $hitung_kegiatan) {
                $kegiatan_september = $hitung_kegiatan['uraian_kegiatan'];
                $data_september = json_decode($kegiatan_september);
                $list_uraian_september[] = $data_september->uraian;
            }
            $kegiatan_september_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_september); $hitung_kegiatan++) {
                $kegiatan_september_ini = $kegiatan_september_ini + count($list_uraian_september[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_september_ini = 0;
        }
        if ($oktober != null) {
            foreach ($oktober as $hitung_kegiatan) {
                $kegiatan_oktober = $hitung_kegiatan['uraian_kegiatan'];
                $data_oktober = json_decode($kegiatan_oktober);
                $list_uraian_oktober[] = $data_oktober->uraian;
            }
            $kegiatan_oktober_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_oktober); $hitung_kegiatan++) {
                $kegiatan_oktober_ini = $kegiatan_oktober_ini + count($list_uraian_oktober[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_oktober_ini = 0;
        }
        if ($november != null) {
            foreach ($november as $hitung_kegiatan) {
                $kegiatan_november = $hitung_kegiatan['uraian_kegiatan'];
                $data_november = json_decode($kegiatan_november);
                $list_uraian_november[] = $data_november->uraian;
            }
            $kegiatan_november_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_november); $hitung_kegiatan++) {
                $kegiatan_november_ini = $kegiatan_november_ini + count($list_uraian_november[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_november_ini = 0;
        }
        if ($desember != null) {
            foreach ($desember as $hitung_kegiatan) {
                $kegiatan_desember = $hitung_kegiatan['uraian_kegiatan'];
                $data_desember = json_decode($kegiatan_desember);
                $list_uraian_desember[] = $data_desember->uraian;
            }
            $kegiatan_desember_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_desember); $hitung_kegiatan++) {
                $kegiatan_desember_ini = $kegiatan_desember_ini + count($list_uraian_desember[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_desember_ini = 0;
        }


        if (date('m') == "01") {
            $namaBulan = 'Januari';
        } elseif (date('m') == "02") {
            $namaBulan = 'Maret';
        } elseif (date('m') == "03") {
            $namaBulan = 'Maret';
        } elseif (date('m') == "04") {
            $namaBulan = 'April';
        } elseif (date('m') == "05") {
            $namaBulan = 'Mei';
        } elseif (date('m') == "06") {
            $namaBulan = 'Juni';
        } elseif (date('m') == "07") {
            $namaBulan = 'Juli';
        } elseif (date('m') == "08") {
            $namaBulan = 'Agustus';
        } elseif (date('m') == "09") {
            $namaBulan = 'September';
        } elseif (date('m') == "10") {
            $namaBulan = 'Oktober';
        } elseif (date('m') == "11") {
            $namaBulan = 'November';
        } else {
            $namaBulan = 'Desember';
        }


        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiOnDashboard();
        $ke = 0;
        foreach ($list_pegawai as $pegawai) {
            $total_laporan_masing[$ke] = $this->masterUserModel->getTotalByUserJoinPegawai($pegawai['id']);
            $ke++;
        }

        if ($list_pegawai != NULL) {
            foreach ($list_pegawai as $pegawai) {

                $pegawai_all[] = array(
                    'nip_lama' => $pegawai['nip_lama'],
                    'label' => $pegawai['nama_pegawai'],
                );
            }
            $pegawai_json = json_encode($pegawai_all);
        } else {
            $pegawai_all[] = array('');
            $pegawai_json = json_encode($pegawai_all);
        }

        for ($i = 0; $i < count($total_laporan_masing); $i++) {
            if (count($total_laporan_masing[$i]) != 0) {
                for ($a = 0; $a < count($total_laporan_masing[$i]); $a++) {
                    $data = explode('-', $total_laporan_masing[$i][$a]['tgl_kegiatan']);
                    $bulan = $data[1];
                    if ($bulan == date('m')) {
                        $laporan_bulan_pegawai[$i][] = $total_laporan_masing[$i][$a];
                        $jml_bulan_pegawai[$i] = count($laporan_bulan_pegawai[$i]);
                    } else {
                        $jml_bulan_pegawai[$i] = 0;
                    }
                }
            } else {
                $jml_bulan_pegawai[$i] = 0;
            }
        }
        $ke_minggu = 0;
        foreach ($list_pegawai as $pegawai) {
            $total_laporan_mingguan_masing[$ke_minggu] = $this->masterUserModel->getTotalByUserJoinPegawai2($pegawai['id']);

            $ke_minggu++;
        }

        for ($t = 0; $t < count($total_laporan_mingguan_masing); $t++) {
            $jml_minggu_pegawai[] = count($total_laporan_mingguan_masing[$t]);
        }
        $today = Time::today('Asia/Jakarta');
        $today->toLocalizedString('yyyy-MM-dd');

        $data = [
            'title' => 'Dashboard',
            'menu' => 'Dashboard',
            'subMenu' => 'Kegiatan Harian Pegawai',
            'events' => $events_json,
            'catatan' => $catatan_json,
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'total_laporan' => count($total_laporan),
            'total_kegiatan_bulan_ini' => $kegiatan_bulan_ini,
            'jumlah_user' => count($list_user),
            'modal_detail' => '',
            'laporan_harian_tertentu' => NULL,
            'laporan_bulan_ini' => $laporan_bulan_ini,
            'nama_bulan' => $namaBulan,
            'jumlah_kegiatan_tahun_ini' => $kegiatan_tahun_ini,
            'total_januari' => $kegiatan_januari_ini,
            'total_februari' => $kegiatan_februari_ini,
            'total_maret' => $kegiatan_maret_ini,
            'total_april' => $kegiatan_april_ini,
            'total_mei' => $kegiatan_mei_ini,
            'total_juni' => $kegiatan_juni_ini,
            'total_juli' => $kegiatan_juli_ini,
            'total_agustus' => $kegiatan_agustus_ini,
            'total_september' => $kegiatan_september_ini,
            'total_oktober' => $kegiatan_oktober_ini,
            'total_november' => $kegiatan_november_ini,
            'total_desember' => $kegiatan_desember_ini,
            'list_full_laporan_harian' =>  $this->masterLaporanHarianModel->getTotalByUser(session('user_id')),
            'list_pegawai' => $list_pegawai,
            'pegawai_json' => $pegawai_json,
            'jml_perbulan_pegawai' => $jml_bulan_pegawai,
            'jml_perminggu_pegawai' => $jml_minggu_pegawai,
            'tanggal_mulai' => $tanggal_mulai,
            'user_dipilih' => null,
            'div_card' => 'd-none',
            'list_golongan' => $this->masterGolonganModel->getAllGolongan(),
            'list_fungsional' => $this->masterFungsionalModel->getAllFungsional(),
            'jumlah_pegawai' => count($this->masterPegawaiModel->getAllPegawaiOnDashboard()),
            'jumlah_laporan' => count($this->masterLaporanHarianModel->getAllLaporan()),
            'jumlah_user_aktif' => count($this->masterUserModel->getAllUserAktif()),
            'jumlah_user_tidak_aktif' => count($this->masterUserModel->getAllUserTidakAktif()),
            'nip_lama_pegawai_terpilih' => null,
            'today' => $today

        ];
        // dd($data);
        return view('Dashboard/index', $data);
    }

    public function showDetailLaporanHarianOnDashboard($laporan_id)
    {
        $list_user = $this->masterUserModel->getAllUserOnDashboard();
        $user_id_detail = $this->masterLaporanHarianModel->getUserIdbyLaporanId($laporan_id);


        if ($user_id_detail != null) {
            $data_user_pilih = $this->masterUserModel->getDataPegawaiByUserId($user_id_detail);
        } else {
            $data_user_pilih = null;
        }


        if ($user_id_detail['user_id'] == session('user_id')) {
            $event_data = $this->masterLaporanHarianModel->getAll(session('user_id'));
            $total_laporan = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));
            $all_year = $this->masterLaporanHarianModel->getAllYear(session('user_id'));
            $total = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));
            $itemsCount = 10;
            $list_laporan_harian_detail = $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->paginate($itemsCount, 'list_laporan_harian');
            $pager_detail = $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->pager;
            $laporan_harian_tertentu_detail = $this->masterLaporanHarianModel->getLaporan(session('user_id'), $laporan_id);
            $list_full_laporan_harian_detail = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));
        } else {
            $event_data = $this->masterLaporanHarianModel->getAll($user_id_detail['user_id']);
            $total_laporan = $this->masterLaporanHarianModel->getTotalByUser($user_id_detail['user_id']);
            $all_year = $this->masterLaporanHarianModel->getAllYear($user_id_detail['user_id']);
            $total = $this->masterLaporanHarianModel->getTotalByUser($user_id_detail['user_id']);
            $itemsCount = 10;
            $list_laporan_harian_detail = $this->masterLaporanHarianModel->getAllByUser($user_id_detail['user_id'])->paginate($itemsCount, 'list_laporan_harian');
            $pager_detail = $this->masterLaporanHarianModel->getAllByUser($user_id_detail['user_id'])->pager;
            $laporan_harian_tertentu_detail = $this->masterLaporanHarianModel->getLaporan($user_id_detail['user_id'], $laporan_id);
            $list_full_laporan_harian_detail = $this->masterLaporanHarianModel->getTotalByUser($user_id_detail['user_id']);
        }




        if ($event_data != NULL) {
            foreach ($event_data as $row) {
                $events[] = array(
                    'link' => base_url('/showDetailLaporanHarianOnDashboard/' . $row['id']),
                    'tgl' => $row['tgl_kegiatan']
                );
            }
            $events_json = json_encode($events);
        } else {
            $events[] = array('');
            $events_json = json_encode($events);
        }



        $catatan_data = $this->masterCatatanModel->getAll(session('user_id'));
        if (session('level_id') == "7") {
            if ($catatan_data != NULL) {
                foreach ($catatan_data as $catatan) {
                    $pengirim = $this->masterUserModel->getDataPegawaiByUserId($catatan['user_id']);
                    $penerima = $this->masterUserModel->getDataPegawaiByUserId($catatan['user_id_penerima']);

                    $catatan_all[] = array(
                        'id' => $catatan['id'],
                        'id_pengirim' => $catatan['user_id'],
                        'pengirim' => $pengirim['nama_pegawai'],
                        'id_penerima' => $catatan['user_id_penerima'],
                        'penerima' => $penerima['nama_pegawai'],
                        'catatan' => $catatan['catatan'],
                        'tgl' => $catatan['tgl_catatan']
                    );
                }
                $catatan_json = json_encode($catatan_all);
            } else {
                $catatan_all[] = array('');
                $catatan_json = json_encode($catatan_all);
            }
        } else {
            $catatan_all[] = array('');
            $catatan_json = json_encode($catatan_all);
        }


        $januari = [];
        $februari = [];
        $maret = [];
        $april = [];
        $april = [];
        $mei = [];
        $juni = [];
        $juli = [];
        $agustus = [];
        $september = [];
        $oktober = [];
        $november = [];
        $desember = [];
        $laporan_bulan_ini = [];
        $list_uraian = [];
        $jml_bulan_pegawai = [];
        $jml_bulan_pegawai = [];
        $laporan_bulan_pegawai = [];

        if ($total_laporan != NULL) {
            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $bulan[] = $data[1];
                if ($bulan[$i] == date('m')) {
                    $laporan_bulan_ini[] = $total_laporan[$i];
                }
            }


            foreach ($laporan_bulan_ini as $bulan) {
                $laporan = $bulan['uraian_kegiatan'];
                $data = json_decode($laporan);
                $list_uraian[] = $data->uraian;
            }

            $kegiatan_bulan_ini = 0;

            for ($i = 0; $i < count($list_uraian); $i++) {
                $kegiatan_bulan_ini = $kegiatan_bulan_ini + count($list_uraian[$i]);
            }
            //untuk kebutuhan chart
            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $tahun[] = $data[0];
                if ($tahun[$i] == date('Y')) {
                    $laporan_tahun_ini[] = $total_laporan[$i];
                }
            }
            $kegiatan_tahun_ini = 0;

            for ($i = 0; $i < count($list_uraian); $i++) {
                $kegiatan_tahun_ini = $kegiatan_tahun_ini + count($list_uraian[$i]);
            }




            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $bulan[] = $data[1];
                $tahun[] = $data[0];

                if ($bulan[$i] == '01' && $tahun[$i] == date('Y')) {
                    $januari[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '02' && $tahun[$i] == date('Y')) {
                    $februari[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '03' && $tahun[$i] == date('Y')) {
                    $maret[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '04' && $tahun[$i] == date('Y')) {
                    $april[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '05' && $tahun[$i] == date('Y')) {
                    $mei[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '06' && $tahun[$i] == date('Y')) {
                    $juni[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '07' && $tahun[$i] == date('Y')) {
                    $juli[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '08' && $tahun[$i] == date('Y')) {
                    $agustus[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '09' && $tahun[$i] == date('Y')) {
                    $september[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '10' && $tahun[$i] == date('Y')) {
                    $oktober[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '11' && $tahun[$i] == date('Y')) {
                    $november[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '12' && $tahun[$i] == date('Y')) {
                    $desember[] = $total_laporan[$i];
                }
            }
        } else {
            $laporan_bulan_ini = null;
            $kegiatan_bulan_ini = 0;
            $kegiatan_tahun_ini = 0;
            $kegiatan_januari_ini = 0;
            $kegiatan_februari_ini = 0;
            $kegiatan_maret_ini = 0;
            $kegiatan_april_ini = 0;
            $kegiatan_mei_ini = 0;
            $kegiatan_juni_ini = 0;
            $kegiatan_juli_ini = 0;
            $kegiatan_agustus_ini = 0;
            $kegiatan_september_ini = 0;
            $kegiatan_oktober_ini = 0;
            $kegiatan_november_ini = 0;
            $kegiatan_desember_ini = 0;
        }


        if ($januari != null) {
            foreach ($januari as $hitung_kegiatan) {
                $kegiatan_januari = $hitung_kegiatan['uraian_kegiatan'];
                $data_januari = json_decode($kegiatan_januari);
                $list_uraian_januari[] = $data_januari->uraian;
            }
            $kegiatan_januari_ini = 0;
            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_januari); $hitung_kegiatan++) {
                $kegiatan_januari_ini = $kegiatan_januari_ini + count($list_uraian_januari[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_januari_ini = 0;
        }
        if ($februari != null) {
            foreach ($februari as $hitung_kegiatan) {
                $kegiatan_februari = $hitung_kegiatan['uraian_kegiatan'];
                $data_februari = json_decode($kegiatan_februari);
                $list_uraian_februari[] = $data_februari->uraian;
            }
            $kegiatan_februari_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_februari); $hitung_kegiatan++) {
                $kegiatan_februari_ini = $kegiatan_februari_ini + count($list_uraian_februari[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_februari_ini = 0;
        }
        if ($maret != null) {
            foreach ($maret as $hitung_kegiatan) {
                $kegiatan_maret = $hitung_kegiatan['uraian_kegiatan'];
                $data_maret = json_decode($kegiatan_maret);
                $list_uraian_maret[] = $data_maret->uraian;
            }
            $kegiatan_maret_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_maret); $hitung_kegiatan++) {
                $kegiatan_maret_ini = $kegiatan_maret_ini + count($list_uraian_maret[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_maret_ini = 0;
        }
        if ($april != null) {
            foreach ($april as $hitung_kegiatan) {
                $kegiatan_april = $hitung_kegiatan['uraian_kegiatan'];
                $data_april = json_decode($kegiatan_april);
                $list_uraian_april[] = $data_april->uraian;
            }
            $kegiatan_april_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_april); $hitung_kegiatan++) {
                $kegiatan_april_ini = $kegiatan_april_ini + count($list_uraian_april[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_april_ini = 0;
        }
        if ($mei != null) {
            foreach ($mei as $hitung_kegiatan) {
                $kegiatan_mei = $hitung_kegiatan['uraian_kegiatan'];
                $data_mei = json_decode($kegiatan_mei);
                $list_uraian_mei[] = $data_mei->uraian;
            }
            $kegiatan_mei_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_mei); $hitung_kegiatan++) {
                $kegiatan_mei_ini = $kegiatan_mei_ini + count($list_uraian_mei[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_mei_ini = 0;
        }
        if ($juni != null) {
            foreach ($juni as $hitung_kegiatan) {
                $kegiatan_juni = $hitung_kegiatan['uraian_kegiatan'];
                $data_juni = json_decode($kegiatan_juni);
                $list_uraian_juni[] = $data_juni->uraian;
            }
            $kegiatan_juni_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_juni); $hitung_kegiatan++) {
                $kegiatan_juni_ini = $kegiatan_juni_ini + count($list_uraian_juni[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_juni_ini = 0;
        }
        if ($juli != null) {
            foreach ($juli as $hitung_kegiatan) {
                $kegiatan_juli = $hitung_kegiatan['uraian_kegiatan'];
                $data_juli = json_decode($kegiatan_juli);
                $list_uraian_juli[] = $data_juli->uraian;
            }
            $kegiatan_juli_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_juli); $hitung_kegiatan++) {
                $kegiatan_juli_ini = $kegiatan_juli_ini + count($list_uraian_juli[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_juli_ini = 0;
        }
        if ($agustus != null) {
            foreach ($agustus as $hitung_kegiatan) {
                $kegiatan_agustus = $hitung_kegiatan['uraian_kegiatan'];
                $data_agustus = json_decode($kegiatan_agustus);
                $list_uraian_agustus[] = $data_agustus->uraian;
            }
            $kegiatan_agustus_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_agustus); $hitung_kegiatan++) {
                $kegiatan_agustus_ini = $kegiatan_agustus_ini + count($list_uraian_agustus[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_agustus_ini = 0;
        }
        if ($september != null) {
            foreach ($september as $hitung_kegiatan) {
                $kegiatan_september = $hitung_kegiatan['uraian_kegiatan'];
                $data_september = json_decode($kegiatan_september);
                $list_uraian_september[] = $data_september->uraian;
            }
            $kegiatan_september_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_september); $hitung_kegiatan++) {
                $kegiatan_september_ini = $kegiatan_september_ini + count($list_uraian_september[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_september_ini = 0;
        }
        if ($oktober != null) {
            foreach ($oktober as $hitung_kegiatan) {
                $kegiatan_oktober = $hitung_kegiatan['uraian_kegiatan'];
                $data_oktober = json_decode($kegiatan_oktober);
                $list_uraian_oktober[] = $data_oktober->uraian;
            }
            $kegiatan_oktober_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_oktober); $hitung_kegiatan++) {
                $kegiatan_oktober_ini = $kegiatan_oktober_ini + count($list_uraian_oktober[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_oktober_ini = 0;
        }
        if ($november != null) {
            foreach ($november as $hitung_kegiatan) {
                $kegiatan_november = $hitung_kegiatan['uraian_kegiatan'];
                $data_november = json_decode($kegiatan_november);
                $list_uraian_november[] = $data_november->uraian;
            }
            $kegiatan_november_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_november); $hitung_kegiatan++) {
                $kegiatan_november_ini = $kegiatan_november_ini + count($list_uraian_november[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_november_ini = 0;
        }
        if ($desember != null) {
            foreach ($desember as $hitung_kegiatan) {
                $kegiatan_desember = $hitung_kegiatan['uraian_kegiatan'];
                $data_desember = json_decode($kegiatan_desember);
                $list_uraian_desember[] = $data_desember->uraian;
            }
            $kegiatan_desember_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_desember); $hitung_kegiatan++) {
                $kegiatan_desember_ini = $kegiatan_desember_ini + count($list_uraian_desember[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_desember_ini = 0;
        }


        if (date('m') == "01") {
            $namaBulan = 'Januari';
        } elseif (date('m') == "02") {
            $namaBulan = 'Maret';
        } elseif (date('m') == "03") {
            $namaBulan = 'Maret';
        } elseif (date('m') == "04") {
            $namaBulan = 'April';
        } elseif (date('m') == "05") {
            $namaBulan = 'Mei';
        } elseif (date('m') == "06") {
            $namaBulan = 'Juni';
        } elseif (date('m') == "07") {
            $namaBulan = 'Juli';
        } elseif (date('m') == "08") {
            $namaBulan = 'Agustus';
        } elseif (date('m') == "09") {
            $namaBulan = 'September';
        } elseif (date('m') == "10") {
            $namaBulan = 'Oktober';
        } elseif (date('m') == "11") {
            $namaBulan = 'November';
        } else {
            $namaBulan = 'Desember';
        }







        if ($all_year != NULL) {
            for ($i = 0; $i < count($all_year); $i++) {
                $data = explode('-', $all_year[$i]['tgl_kegiatan']);
                $tahun[] = $data[0];
            }
        } else {
            $tahun = NULL;
        }
        if ($tahun != NULL) {
            $tahun_tersedia[] = $tahun[0];
            for ($i = 1; $i < count($tahun); $i++) {
                if ($tahun[$i - 1] != $tahun[$i]) {
                    $tahun_tersedia[] = $tahun[$i];
                };
            }
        } else {
            $tahun_tersedia = NULL;
        }




        $tanggal_input_terakhir = $total[count($total) - 1]['tgl_kegiatan'];


        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiOnDashboard();
        $ke = 0;
        foreach ($list_pegawai as $pegawai) {
            $total_laporan_masing[$ke] = $this->masterUserModel->getTotalByUserJoinPegawai($pegawai['id']);
            $ke++;
        }

        if ($list_pegawai != NULL) {
            foreach ($list_pegawai as $pegawai) {

                $pegawai_all[] = array(
                    'nip_lama' => $pegawai['nip_lama'],
                    'label' => $pegawai['nama_pegawai'],
                );
            }
            $pegawai_json = json_encode($pegawai_all);
        } else {
            $pegawai_all[] = array('');
            $pegawai_json = json_encode($pegawai_all);
        }

        for ($i = 0; $i < count($total_laporan_masing); $i++) {
            if (count($total_laporan_masing[$i]) != 0) {
                for ($a = 0; $a < count($total_laporan_masing[$i]); $a++) {
                    $data = explode('-', $total_laporan_masing[$i][$a]['tgl_kegiatan']);
                    $bulan = $data[1];
                    if ($bulan == date('m')) {
                        $laporan_bulan_pegawai[$i][] = $total_laporan_masing[$i][$a];
                        $jml_bulan_pegawai[$i] = count($laporan_bulan_pegawai[$i]);
                    } else {
                        $jml_bulan_pegawai[$i] = 0;
                    }
                }
            } else {
                $jml_bulan_pegawai[$i] = 0;
            }
        }
        $ke_minggu = 0;
        foreach ($list_pegawai as $pegawai) {
            $total_laporan_mingguan_masing[$ke_minggu] = $this->masterUserModel->getTotalByUserJoinPegawai2($pegawai['id']);

            $ke_minggu++;
        }

        for ($t = 0; $t < count($total_laporan_mingguan_masing); $t++) {
            $jml_minggu_pegawai[] = count($total_laporan_mingguan_masing[$t]);
        }

        $nip_lama = $this->masterUserModel->getProfilUser($user_id_detail);


        $data = [
            'title' => 'Dashboard',
            'menu' => 'Dashboard',
            'subMenu' => 'Kegiatan Harian Pegawai',
            'total' => count($total),
            'list_laporan_harian' => $list_laporan_harian_detail,
            'pager' => $pager_detail,
            'itemsCount' => $itemsCount,
            'laporan_harian_tertentu' => $laporan_harian_tertentu_detail,
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'modal_edit' => '',
            'modal_detail' => 'modal-detail',
            'tanggal_input_terakhir' => $tanggal_input_terakhir,
            'events' => $events_json,
            'catatan' => $catatan_json,
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'total_laporan' => count($total_laporan),
            'total_kegiatan_bulan_ini' => $kegiatan_bulan_ini,
            'jumlah_user' => count($list_user),
            'tahun_tersedia' => $tahun_tersedia,
            'laporan_bulan_ini' => $laporan_bulan_ini,
            'nama_bulan' => $namaBulan,
            'jumlah_kegiatan_tahun_ini' => $kegiatan_tahun_ini,
            'total_januari' => $kegiatan_januari_ini,
            'total_februari' => $kegiatan_februari_ini,
            'total_maret' => $kegiatan_maret_ini,
            'total_april' => $kegiatan_april_ini,
            'total_mei' => $kegiatan_mei_ini,
            'total_juni' => $kegiatan_juni_ini,
            'total_juli' => $kegiatan_juli_ini,
            'total_agustus' => $kegiatan_agustus_ini,
            'total_september' => $kegiatan_september_ini,
            'total_oktober' => $kegiatan_oktober_ini,
            'total_november' => $kegiatan_november_ini,
            'total_desember' => $kegiatan_desember_ini,
            'list_full_laporan_harian' =>  $list_full_laporan_harian_detail,
            'tanggal_mulai' => '2022-07-01',
            'jml_perbulan_pegawai' => $jml_bulan_pegawai,
            'jml_perminggu_pegawai' => $jml_minggu_pegawai,
            'list_pegawai' => $list_pegawai,
            'pegawai_json' => $pegawai_json,
            'user_dipilih' => $data_user_pilih,
            'div_card' => 'd-none',
            'list_golongan' => $this->masterGolonganModel->getAllGolongan(),
            'list_fungsional' => $this->masterFungsionalModel->getAllFungsional(),
            'jumlah_pegawai' => count($this->masterPegawaiModel->getAllPegawaiOnDashboard()),
            'jumlah_laporan' => count($this->masterLaporanHarianModel->getAllLaporan()),
            'jumlah_user_aktif' => count($this->masterUserModel->getAllUserAktif()),
            'jumlah_user_tidak_aktif' => count($this->masterUserModel->getAllUserTidakAktif()),
            'nip_lama_pegawai_terpilih' => $nip_lama['nip_lama_user']

        ];

        return view('Dashboard/index', $data);
    }

    public function dataPegawai()
    {

        $list_pendidikan = $this->masterPendidikanModel->getAllPendidikan();
        $list_golongan = $this->masterGolonganModel->getAllGolongan();
        $list_fungsional = $this->masterFungsionalModel->getAllFungsional();
        $list_satker = $this->masterSatkerModel->getAllSatker();

        $satker_choose = $this->request->getVar('satker_choose');
        if ($satker_choose) {
            $data_pegawai = $this->masterPegawaiModel->getAllPegawaiBySatker($satker_choose);
            $list_user = $this->masterUserModel->getAllUserBySatker($satker_choose);
        } else {
            $data_pegawai = $this->masterPegawaiModel->getAllPegawai();
            $list_user = $this->masterUserModel->getAllUser();
        }



        $jk = [];
        $laki_laki = [];
        $perempuan = [];
        $Ia = [];
        $Ib = [];
        $Ic = [];
        $Id = [];
        $IIa = [];
        $IIb = [];
        $IIc = [];
        $IId = [];
        $IIIa = [];
        $IIIb = [];
        $IIIc = [];
        $IIId = [];
        $IVa = [];
        $IVb = [];
        $IVc = [];
        $IVd = [];
        $IVe = [];
        $gol = [];
        $bpf = [];
        $spp = [];
        $st = [];
        $sm = [];
        $spen = [];
        $sap = [];
        $sam = [];
        $samad = [];
        $sau = [];
        $pkpp = [];
        $pkt = [];
        $pkm = [];
        $pkpen = [];
        $pkap = [];
        $pkam = [];
        $pkamad = [];
        $pkau = [];
        $aaam = [];
        $pel = [];
        $asaam = [];
        $asap = [];
        $php = [];
        $apkaam = [];
        $pkamah = [];
        $aamud = [];
        $arsimud = [];
        $ppbj = [];
        $tb = [];
        $pkat = [];
        $ksk = [];
        $fungsional = [];
        $tk_sd = [];
        $tk_smp = [];
        $tk_sma = [];
        $tk_d1 = [];
        $tk_d2 = [];
        $tk_d3 = [];
        $tk_d4 = [];
        $tk_s1 = [];
        $tk_s2 = [];
        $tk_sk3 = [];
        $pdd = [];


        if ($data_pegawai != null) {
            foreach ($data_pegawai as $pegawai) {
                if ($pegawai['jk'] == '1') {
                    $laki_laki[] = $pegawai;
                } else {
                    $perempuan[] = $pegawai;
                }
            }
            $jk[0] = count($laki_laki);
            $jk[1] = count($perempuan);

            foreach ($data_pegawai as $pegawai) {
                if ($pegawai['gol_kd'] == '1') {
                    $Ia[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '2') {
                    $Ib[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '3') {
                    $Ic[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '4') {
                    $Id[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '5') {
                    $IIa[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '6') {
                    $IIb[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '7') {
                    $IIc[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '8') {
                    $IId[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '9') {
                    $IIIa[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '10') {
                    $IIIb[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '11') {
                    $IIIc[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '12') {
                    $IIId[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '13') {
                    $IVa[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '14') {
                    $IVb[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '15') {
                    $IVc[] = $pegawai;
                } elseif ($pegawai['gol_kd'] == '16') {
                    $IVd[] = $pegawai;
                } else {
                    $IVe[] = $pegawai;
                }
            }

            $gol[0] = count($Ia);
            $gol[1] = count($Ib);
            $gol[2] = count($Ic);
            $gol[3] = count($Id);
            $gol[4] = count($IIa);
            $gol[5] = count($IIb);
            $gol[6] = count($IIc);
            $gol[7] = count($IId);
            $gol[8] = count($IIIa);
            $gol[9] = count($IIIb);
            $gol[10] = count($IIIc);
            $gol[11] = count($IIId);
            $gol[12] = count($IVa);
            $gol[13] = count($IVb);
            $gol[14] = count($IVc);
            $gol[15] = count($IVd);
            $gol[16] = count($IVe);

            foreach ($data_pegawai as $pegawai) {
                if ($pegawai['fungsional_kd'] == '1') {
                    $bpf[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '2') {
                    $spp[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '3') {
                    $st[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '4') {
                    $sm[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '5') {
                    $spen[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '6') {
                    $sap[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '7') {
                    $sam[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '8') {
                    $samad[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '9') {
                    $sau[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '10') {
                    $pkpp[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '11') {
                    $pkt[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '12') {
                    $pkm[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '13') {
                    $pkpen[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '14') {
                    $pkap[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '15') {
                    $pkam[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '16') {
                    $pkamad[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '17') {
                    $pkau[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '18') {
                    $aaam[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '19') {
                    $pel[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '20') {
                    $asaam[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '21') {
                    $asap[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '22') {
                    $php[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '23') {
                    $apkaam[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '24') {
                    $pkamah[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '25') {
                    $aamud[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '26') {
                    $arsimud[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '27') {
                    $ppbj[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '28') {
                    $tb[] = $pegawai;
                } elseif ($pegawai['fungsional_kd'] == '29') {
                    $pkat[] = $pegawai;
                } else {
                    $ksk[] = $pegawai;
                }
            }
            $fungsional[0] = count($bpf);
            $fungsional[1] = count($spp);
            $fungsional[2] = count($st);
            $fungsional[3] = count($sm);
            $fungsional[4] = count($spen);
            $fungsional[5] = count($sap);
            $fungsional[6] = count($sam);
            $fungsional[7] = count($samad);
            $fungsional[8] = count($sau);
            $fungsional[9] = count($pkpp);
            $fungsional[10] = count($pkt);
            $fungsional[11] = count($pkm);
            $fungsional[12] = count($pkpen);
            $fungsional[13] = count($pkap);
            $fungsional[14] = count($pkam);
            $fungsional[15] = count($pkamad);
            $fungsional[16] = count($pkau);
            $fungsional[17] = count($aaam);
            $fungsional[18] = count($pel);
            $fungsional[19] = count($asaam);
            $fungsional[20] = count($asap);
            $fungsional[21] = count($php);
            $fungsional[22] = count($apkaam);
            $fungsional[23] = count($pkamah);
            $fungsional[24] = count($aamud);
            $fungsional[25] = count($arsimud);
            $fungsional[26] = count($ppbj);
            $fungsional[27] = count($tb);
            $fungsional[28] = count($pkat);
            $fungsional[29] = count($ksk);


            foreach ($data_pegawai as $pegawai) {
                if ($pegawai['pendidikan_kd'] == 1) {
                    $tk_sd[] = $pegawai;
                } elseif ($pegawai['pendidikan_kd'] == 2) {
                    $tk_smp[] = $pegawai;
                } elseif ($pegawai['pendidikan_kd'] == 3) {
                    $tk_sma[] = $pegawai;
                } elseif ($pegawai['pendidikan_kd'] == 4) {
                    $tk_d1[] = $pegawai;
                } elseif ($pegawai['pendidikan_kd'] == 5) {
                    $tk_d2[] = $pegawai;
                } elseif ($pegawai['pendidikan_kd'] == 6) {
                    $tk_d3[] = $pegawai;
                } elseif ($pegawai['pendidikan_kd'] == 7) {
                    $tk_d4[] = $pegawai;
                } elseif ($pegawai['pendidikan_kd'] == 8) {
                    $tk_s1[] = $pegawai;
                } elseif ($pegawai['pendidikan_kd'] == 9) {
                    $tk_s2[] = $pegawai;
                } else {
                    $tk_sk3[] = $pegawai;
                }
            }
            $pdd[0] = count($tk_sd);
            $pdd[1] = count($tk_smp);
            $pdd[2] = count($tk_sma);
            $pdd[3] = count($tk_d1);
            $pdd[4] = count($tk_d2);
            $pdd[5] = count($tk_d3);
            $pdd[6] = count($tk_d4);
            $pdd[7] = count($tk_s1);
            $pdd[8] = count($tk_s2);
            $pdd[9] = count($tk_sk3);
        }



        $data = [
            'subMenu' => 'Data Pegawai',
            'menu' => 'Dashboard',
            'title' => 'Data Pegawai',
            'list_pendidikan' => $list_pendidikan,
            'list_golongan' => $list_golongan,
            'list_fungsional' => $list_fungsional,
            'list_satker' => $list_satker,
            'jk' => $jk,
            'gol' => $gol,
            'pdd' => $pdd,
            'total_fungsional' => $fungsional,
            'total_pegawai' => count($data_pegawai),
            'total_tb' =>  count($tb),
            'total_pegawai_aktif' => (count($data_pegawai) - count($tb)),
            'jumlah_user' => count($list_user)

        ];
        return view('Dashboard/dataPegawai', $data);
    }

    public function showKegiatanPegawai($nip_lama)
    {
        $user_id_pegawai = $this->masterUserModel->getUserId($nip_lama);
        if ($user_id_pegawai != null) {
            $data_user_pilih = $this->masterUserModel->getDataPegawaiByUserId($user_id_pegawai['id']);
        } else {
            $data_user_pilih = null;
        }


        $list_user = $this->masterUserModel->getAllUserOnDashboard();


        if ($user_id_pegawai != null) {
            $event_data = $this->masterLaporanHarianModel->getAll($user_id_pegawai['id']);


            if ($event_data != NULL) {
                foreach ($event_data as $row) {
                    $events[] = array(
                        'link' => base_url('/showDetailLaporanHarianOnDashboard/' . $row['id']),
                        'tgl' => $row['tgl_kegiatan']
                    );
                }
                $events_json = json_encode($events);
                $tanggal_mulai = "2022-07-01";
            } else {
                $events[] = array('');
                $events_json = json_encode($events);
                $tanggal_mulai = "2022-07-01";
            }
        } else {
            $events[] = array('');
            $events_json = json_encode($events);
            $tanggal_mulai = "";
        }


        $catatan_data = $this->masterCatatanModel->getAll(session('user_id'));
        if (session('level_id') == "7") {
            if ($catatan_data != NULL) {
                foreach ($catatan_data as $catatan) {
                    $pengirim = $this->masterUserModel->getDataPegawaiByUserId($catatan['user_id']);
                    $penerima = $this->masterUserModel->getDataPegawaiByUserId($catatan['user_id_penerima']);

                    $catatan_all[] = array(
                        'id' => $catatan['id'],
                        'id_pengirim' => $catatan['user_id'],
                        'pengirim' => $pengirim['nama_pegawai'],
                        'id_penerima' => $catatan['user_id_penerima'],
                        'penerima' => $penerima['nama_pegawai'],
                        'catatan' => $catatan['catatan'],
                        'tgl' => $catatan['tgl_catatan']
                    );
                }
                $catatan_json = json_encode($catatan_all);
            } else {
                $catatan_all[] = array('');
                $catatan_json = json_encode($catatan_all);
            }
        } else {
            $catatan_all[] = array('');
            $catatan_json = json_encode($catatan_all);
        }


        $total_laporan = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));


        $januari = [];
        $februari = [];
        $maret = [];
        $april = [];
        $april = [];
        $mei = [];
        $juni = [];
        $juli = [];
        $agustus = [];
        $september = [];
        $oktober = [];
        $november = [];
        $desember = [];
        $laporan_bulan_ini = [];
        $list_uraian = [];
        $jml_bulan_pegawai = [];
        $jml_bulan_pegawai = [];
        $laporan_bulan_pegawai = [];
        if ($total_laporan != NULL) {
            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $bulan[] = $data[1];
                if ($bulan[$i] == date('m')) {
                    $laporan_bulan_ini[] = $total_laporan[$i];
                }
            }


            foreach ($laporan_bulan_ini as $bulan) {
                $laporan = $bulan['uraian_kegiatan'];
                $data = json_decode($laporan);
                $list_uraian[] = $data->uraian;
            }

            $kegiatan_bulan_ini = 0;

            for ($i = 0; $i < count($list_uraian); $i++) {
                $kegiatan_bulan_ini = $kegiatan_bulan_ini + count($list_uraian[$i]);
            }

            //untuk kebutuhan chart
            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $tahun[] = $data[0];
                if ($tahun[$i] == date('Y')) {
                    $laporan_tahun_ini[] = $total_laporan[$i];
                }
            }

            foreach ($laporan_tahun_ini as $tahun) {
                $laporan_tahun = $tahun['uraian_kegiatan'];
                $data_tahun = json_decode($laporan_tahun);
                $list_uraian_tahun[] = $data_tahun->uraian;
            }
            $kegiatan_tahun_ini = 0;

            for ($i = 0; $i < count($list_uraian_tahun); $i++) {
                $kegiatan_tahun_ini = $kegiatan_tahun_ini + count($list_uraian_tahun[$i]);
            }



            for ($i = 0; $i < count($total_laporan); $i++) {
                $data = explode('-', $total_laporan[$i]['tgl_kegiatan']);
                $bulan[] = $data[1];
                $tahun[] = $data[0];
                if ($bulan[$i] == '01' && $tahun[$i] == date('Y')) {
                    $januari[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '02' && $tahun[$i] == date('Y')) {
                    $februari[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '03' && $tahun[$i] == date('Y')) {
                    $maret[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '04' && $tahun[$i] == date('Y')) {
                    $april[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '05' && $tahun[$i] == date('Y')) {
                    $mei[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '06' && $tahun[$i] == date('Y')) {
                    $juni[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '07' && $tahun[$i] == date('Y')) {
                    $juli[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '08' && $tahun[$i] == date('Y')) {
                    $agustus[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '09' && $tahun[$i] == date('Y')) {
                    $september[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '10' && $tahun[$i] == date('Y')) {
                    $oktober[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '11' && $tahun[$i] == date('Y')) {
                    $november[] = $total_laporan[$i];
                } elseif ($bulan[$i] == '12' && $tahun[$i] == date('Y')) {
                    $desember[] = $total_laporan[$i];
                }
            }
        } else {
            $laporan_bulan_ini = null;
            $kegiatan_bulan_ini = 0;
            $kegiatan_tahun_ini = 0;
            $kegiatan_januari_ini = 0;
            $kegiatan_februari_ini = 0;
            $kegiatan_maret_ini = 0;
            $kegiatan_april_ini = 0;
            $kegiatan_mei_ini = 0;
            $kegiatan_juni_ini = 0;
            $kegiatan_juli_ini = 0;
            $kegiatan_agustus_ini = 0;
            $kegiatan_september_ini = 0;
            $kegiatan_oktober_ini = 0;
            $kegiatan_november_ini = 0;
            $kegiatan_desember_ini = 0;
        }


        if ($januari != null) {
            foreach ($januari as $hitung_kegiatan) {
                $kegiatan_januari = $hitung_kegiatan['uraian_kegiatan'];
                $data_januari = json_decode($kegiatan_januari);
                $list_uraian_januari[] = $data_januari->uraian;
            }
            $kegiatan_januari_ini = 0;
            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_januari); $hitung_kegiatan++) {
                $kegiatan_januari_ini = $kegiatan_januari_ini + count($list_uraian_januari[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_januari_ini = 0;
        }
        if ($februari != null) {
            foreach ($februari as $hitung_kegiatan) {
                $kegiatan_februari = $hitung_kegiatan['uraian_kegiatan'];
                $data_februari = json_decode($kegiatan_februari);
                $list_uraian_februari[] = $data_februari->uraian;
            }
            $kegiatan_februari_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_februari); $hitung_kegiatan++) {
                $kegiatan_februari_ini = $kegiatan_februari_ini + count($list_uraian_februari[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_februari_ini = 0;
        }
        if ($maret != null) {
            foreach ($maret as $hitung_kegiatan) {
                $kegiatan_maret = $hitung_kegiatan['uraian_kegiatan'];
                $data_maret = json_decode($kegiatan_maret);
                $list_uraian_maret[] = $data_maret->uraian;
            }
            $kegiatan_maret_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_maret); $hitung_kegiatan++) {
                $kegiatan_maret_ini = $kegiatan_maret_ini + count($list_uraian_maret[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_maret_ini = 0;
        }
        if ($april != null) {
            foreach ($april as $hitung_kegiatan) {
                $kegiatan_april = $hitung_kegiatan['uraian_kegiatan'];
                $data_april = json_decode($kegiatan_april);
                $list_uraian_april[] = $data_april->uraian;
            }
            $kegiatan_april_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_april); $hitung_kegiatan++) {
                $kegiatan_april_ini = $kegiatan_april_ini + count($list_uraian_april[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_april_ini = 0;
        }
        if ($mei != null) {
            foreach ($mei as $hitung_kegiatan) {
                $kegiatan_mei = $hitung_kegiatan['uraian_kegiatan'];
                $data_mei = json_decode($kegiatan_mei);
                $list_uraian_mei[] = $data_mei->uraian;
            }
            $kegiatan_mei_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_mei); $hitung_kegiatan++) {
                $kegiatan_mei_ini = $kegiatan_mei_ini + count($list_uraian_mei[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_mei_ini = 0;
        }
        if ($juni != null) {
            foreach ($juni as $hitung_kegiatan) {
                $kegiatan_juni = $hitung_kegiatan['uraian_kegiatan'];
                $data_juni = json_decode($kegiatan_juni);
                $list_uraian_juni[] = $data_juni->uraian;
            }
            $kegiatan_juni_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_juni); $hitung_kegiatan++) {
                $kegiatan_juni_ini = $kegiatan_juni_ini + count($list_uraian_juni[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_juni_ini = 0;
        }
        if ($juli != null) {
            foreach ($juli as $hitung_kegiatan) {
                $kegiatan_juli = $hitung_kegiatan['uraian_kegiatan'];
                $data_juli = json_decode($kegiatan_juli);
                $list_uraian_juli[] = $data_juli->uraian;
            }
            $kegiatan_juli_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_juli); $hitung_kegiatan++) {
                $kegiatan_juli_ini = $kegiatan_juli_ini + count($list_uraian_juli[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_juli_ini = 0;
        }
        if ($agustus != null) {
            foreach ($agustus as $hitung_kegiatan) {
                $kegiatan_agustus = $hitung_kegiatan['uraian_kegiatan'];
                $data_agustus = json_decode($kegiatan_agustus);
                $list_uraian_agustus[] = $data_agustus->uraian;
            }
            $kegiatan_agustus_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_agustus); $hitung_kegiatan++) {
                $kegiatan_agustus_ini = $kegiatan_agustus_ini + count($list_uraian_agustus[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_agustus_ini = 0;
        }
        if ($september != null) {
            foreach ($september as $hitung_kegiatan) {
                $kegiatan_september = $hitung_kegiatan['uraian_kegiatan'];
                $data_september = json_decode($kegiatan_september);
                $list_uraian_september[] = $data_september->uraian;
            }
            $kegiatan_september_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_september); $hitung_kegiatan++) {
                $kegiatan_september_ini = $kegiatan_september_ini + count($list_uraian_september[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_september_ini = 0;
        }
        if ($oktober != null) {
            foreach ($oktober as $hitung_kegiatan) {
                $kegiatan_oktober = $hitung_kegiatan['uraian_kegiatan'];
                $data_oktober = json_decode($kegiatan_oktober);
                $list_uraian_oktober[] = $data_oktober->uraian;
            }
            $kegiatan_oktober_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_oktober); $hitung_kegiatan++) {
                $kegiatan_oktober_ini = $kegiatan_oktober_ini + count($list_uraian_oktober[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_oktober_ini = 0;
        }
        if ($november != null) {
            foreach ($november as $hitung_kegiatan) {
                $kegiatan_november = $hitung_kegiatan['uraian_kegiatan'];
                $data_november = json_decode($kegiatan_november);
                $list_uraian_november[] = $data_november->uraian;
            }
            $kegiatan_november_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_november); $hitung_kegiatan++) {
                $kegiatan_november_ini = $kegiatan_november_ini + count($list_uraian_november[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_november_ini = 0;
        }
        if ($desember != null) {
            foreach ($desember as $hitung_kegiatan) {
                $kegiatan_desember = $hitung_kegiatan['uraian_kegiatan'];
                $data_desember = json_decode($kegiatan_desember);
                $list_uraian_desember[] = $data_desember->uraian;
            }
            $kegiatan_desember_ini = 0;

            for ($hitung_kegiatan = 0; $hitung_kegiatan < count($list_uraian_desember); $hitung_kegiatan++) {
                $kegiatan_desember_ini = $kegiatan_desember_ini + count($list_uraian_desember[$hitung_kegiatan]);
            }
        } else {
            $kegiatan_desember_ini = 0;
        }


        if (date('m') == "01") {
            $namaBulan = 'Januari';
        } elseif (date('m') == "02") {
            $namaBulan = 'Maret';
        } elseif (date('m') == "03") {
            $namaBulan = 'Maret';
        } elseif (date('m') == "04") {
            $namaBulan = 'April';
        } elseif (date('m') == "05") {
            $namaBulan = 'Mei';
        } elseif (date('m') == "06") {
            $namaBulan = 'Juni';
        } elseif (date('m') == "07") {
            $namaBulan = 'Juli';
        } elseif (date('m') == "08") {
            $namaBulan = 'Agustus';
        } elseif (date('m') == "09") {
            $namaBulan = 'September';
        } elseif (date('m') == "10") {
            $namaBulan = 'Oktober';
        } elseif (date('m') == "11") {
            $namaBulan = 'November';
        } else {
            $namaBulan = 'Desember';
        }


        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiOnDashboard();
        $ke = 0;
        foreach ($list_pegawai as $pegawai) {
            $total_laporan_masing[$ke] = $this->masterUserModel->getTotalByUserJoinPegawai($pegawai['id']);
            $ke++;
        }

        if ($list_pegawai != NULL) {
            foreach ($list_pegawai as $pegawai) {

                $pegawai_all[] = array(
                    'nip_lama' => $pegawai['nip_lama'],
                    'label' => $pegawai['nama_pegawai'],
                );
            }
            $pegawai_json = json_encode($pegawai_all);
        } else {
            $pegawai_all[] = array('');
            $pegawai_json = json_encode($pegawai_all);
        }

        for ($i = 0; $i < count($total_laporan_masing); $i++) {
            if (count($total_laporan_masing[$i]) != 0) {
                for ($a = 0; $a < count($total_laporan_masing[$i]); $a++) {
                    $data = explode('-', $total_laporan_masing[$i][$a]['tgl_kegiatan']);
                    $bulan = $data[1];
                    if ($bulan == date('m')) {
                        $laporan_bulan_pegawai[$i][] = $total_laporan_masing[$i][$a];
                        $jml_bulan_pegawai[$i] = count($laporan_bulan_pegawai[$i]);
                    } else {
                        $jml_bulan_pegawai[$i] = 0;
                    }
                }
            } else {
                $jml_bulan_pegawai[$i] = 0;
            }
        }

        $ke_minggu = 0;
        foreach ($list_pegawai as $pegawai) {
            $total_laporan_mingguan_masing[$ke_minggu] = $this->masterUserModel->getTotalByUserJoinPegawai2($pegawai['id']);

            $ke_minggu++;
        }

        for ($t = 0; $t < count($total_laporan_mingguan_masing); $t++) {
            $jml_minggu_pegawai[] = count($total_laporan_mingguan_masing[$t]);
        }

        $data = [
            'title' => 'Dashboard',
            'menu' => 'Dashboard',
            'subMenu' => 'Kegiatan Harian Pegawai',
            'events' => $events_json,
            'catatan' => $catatan_json,
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'total_laporan' => count($total_laporan),
            'total_kegiatan_bulan_ini' => $kegiatan_bulan_ini,
            'jumlah_user' => count($list_user),
            'modal_detail' => '',
            'laporan_harian_tertentu' => NULL,
            'laporan_bulan_ini' => $laporan_bulan_ini,
            'nama_bulan' => $namaBulan,
            'jumlah_kegiatan_tahun_ini' => $kegiatan_tahun_ini,
            'total_januari' => $kegiatan_januari_ini,
            'total_februari' => $kegiatan_februari_ini,
            'total_maret' => $kegiatan_maret_ini,
            'total_april' => $kegiatan_april_ini,
            'total_mei' => $kegiatan_mei_ini,
            'total_juni' => $kegiatan_juni_ini,
            'total_juli' => $kegiatan_juli_ini,
            'total_agustus' => $kegiatan_agustus_ini,
            'total_september' => $kegiatan_september_ini,
            'total_oktober' => $kegiatan_oktober_ini,
            'total_november' => $kegiatan_november_ini,
            'total_desember' => $kegiatan_desember_ini,
            'list_full_laporan_harian' =>  $this->masterLaporanHarianModel->getTotalByUser(session('user_id')),
            'list_pegawai' => $list_pegawai,
            'pegawai_json' => $pegawai_json,
            'jml_perbulan_pegawai' => $jml_bulan_pegawai,
            'tanggal_mulai' => $tanggal_mulai,
            'jml_perbulan_pegawai' => $jml_bulan_pegawai,
            'jml_perminggu_pegawai' => $jml_minggu_pegawai,
            'user_dipilih' => $data_user_pilih,
            'div_card' => '',
            'list_golongan' => $this->masterGolonganModel->getAllGolongan(),
            'list_fungsional' => $this->masterFungsionalModel->getAllFungsional(),
            'jumlah_pegawai' => count($this->masterPegawaiModel->getAllPegawaiOnDashboard()),
            'jumlah_laporan' => count($this->masterLaporanHarianModel->getAllLaporan()),
            'jumlah_user_aktif' => count($this->masterUserModel->getAllUserAktif()),
            'jumlah_user_tidak_aktif' => count($this->masterUserModel->getAllUserTidakAktif()),
            'nip_lama_pegawai_terpilih' => $nip_lama

        ];

        // dd($data);
        return view('Dashboard/index', $data);
    }


    public function tambahCatatan()
    {
        $user_id = session('user_id');
        $nip_lama = $this->request->getVar('nip_lama');

        $id_penerima = $this->masterUserModel->getUserId($nip_lama);


        if ($nip_lama == null) {
            $tipe_catatan = 1;
            $catatan = $this->request->getVar('catatan');
            $user_id_penerima = $user_id;
        } else {
            $tipe_catatan = 2;
            $catatan = $this->request->getVar('catatan_dikirim');
            $user_id_penerima = $id_penerima;
        }


        $tgl_catatan = $this->request->getVar('tgl');

        $this->masterCatatanModel->save([
            'user_id' => $user_id,
            'user_id_penerima' => $user_id_penerima,
            'tgl_catatan' => $tgl_catatan,
            'tipe_catatan' => $tipe_catatan,
            'catatan' => $catatan
        ]);

        return redirect()->to('/dashboard');
    }

    public function updateCatatan()
    {
        $id_catatan = $this->request->getVar('id');
        $catatan_lama = $this->masterCatatanModel->getCatatanById($id_catatan);
        $catatan = $this->request->getVar('catatan');


        $this->masterCatatanModel->save([
            'id' => $id_catatan,
            'user_id' => $catatan_lama['user_id'],
            'user_id_penerima' => $catatan_lama['user_id_penerima'],
            'tgl_catatan' => $catatan_lama['tgl_catatan'],
            'tipe_catatan' => $catatan_lama['tipe_catatan'],
            'catatan' => $catatan
        ]);

        return redirect()->to('/dashboard');
    }

    public function hapusCatatan($id_catatan)
    {
        $catatan = $this->masterCatatanModel->getCatatanById($id_catatan);
        if ($catatan['user_id'] == session('user_id')) {
            $this->masterCatatanModel->delete($id_catatan);
        }
        return redirect()->to('/dashboard');
    }
    public function detailCatatan()
    {
        $list_catatan = $this->masterCatatanModel->getAll(session('user_id'));


        foreach ($list_catatan as $catatan) {
            $pengirim = $this->masterUserModel->getDataPegawaiByUserId($catatan['user_id']);
            $penerima = $this->masterUserModel->getDataPegawaiByUserId($catatan['user_id_penerima']);

            $catatan_all[] = array(
                'id' => $catatan['id'],
                'id_pengirim' => $catatan['user_id'],
                'tipe_catatan' => $catatan['tipe_catatan'],
                'pengirim' => $pengirim['nama_pegawai'],
                'id_penerima' => $catatan['user_id_penerima'],
                'penerima' => $penerima['nama_pegawai'],
                'catatan' => $catatan['catatan'],
                'tgl' => $catatan['tgl_catatan']
            );
        }




        $data = [
            'title' => 'Detail Catatan',
            'menu' => 'Dashboard',
            'subMenu' => 'Kegiatan Harian Pegawai',
            'list_catatan' => $catatan_all,

        ];
        //  dd($data);
        return view('Dashboard/detailCatatan', $data);
    }
}
