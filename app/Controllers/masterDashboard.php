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
use App\Models\MasterEs3Model;
use App\Models\MasterKegiatanModel;
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
    protected $masterEs3Model;
    protected $masterKegiatanModel;
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
        $this->masterEs3Model = new MasterEs3Model();
        $this->masterKegiatanModel = new masterKegiatanModel();
    }

    public function index()
    {
        $event_data = $this->masterLaporanHarianModel->getAll(session('user_id'));
        if (session('level_id') == "2") {
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
        $total_laporan = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));
        $catatan_data = $this->masterCatatanModel->getAll(session('user_id'));
        if (session('level_id') == "2") {
            if ($catatan_data != NULL) {
                foreach ($catatan_data as $catatan) {
                    //perbaikan fungsi join
                    $nip_lama_pengirim = $this->masterUserModel->getNipLamaByUserId($catatan['user_id']);
                    $pengirim = $this->masterPegawaiModel->getProfilPegawai($nip_lama_pengirim['nip_lama_user']);
                    $nip_lama_penerima = $this->masterUserModel->getNipLamaByUserId($catatan['user_id_penerima']);
                    $penerima = $this->masterPegawaiModel->getProfilPegawai($nip_lama_penerima['nip_lama_user']);

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
        } else {
            $kegiatan_bulan_ini = 0;
        }

        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiOnDashboard();
        $ke = 0;
        foreach ($list_pegawai as $pegawai) {
            $nip_lama_pegawai = $this->masterPegawaiModel->getNipLama($pegawai['id']);
            $user_id_pegawai_laporan = $this->masterUserModel->getUserId($nip_lama_pegawai['nip_lama']);
            if ($user_id_pegawai_laporan != null) {
                $total_laporan_masing[$ke] = $this->masterLaporanHarianModel->getAllLaporanByUserId($user_id_pegawai_laporan['id']);
            } else {
                $total_laporan_masing[$ke] = [];
            }
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
            $nip_lama_pegawai = $this->masterPegawaiModel->getNipLama($pegawai['id']);
            $user_id_pegawai_laporan = $this->masterUserModel->getUserId($nip_lama_pegawai['nip_lama']);
            if ($user_id_pegawai_laporan != null) {
                $total_laporan_mingguan_masing[$ke_minggu] = $this->masterLaporanHarianModel->getAllLaporanByUserId2($user_id_pegawai_laporan['id']);
            } else {
                $total_laporan_mingguan_masing[$ke_minggu] = [];
            }
            $ke_minggu++;
        }
        for ($t = 0; $t < count($total_laporan_mingguan_masing); $t++) {
            $jml_minggu_pegawai[] = count($total_laporan_mingguan_masing[$t]);
        }

        $today = Time::today('Asia/Jakarta');
        $today->toLocalizedString('yyyy-MM-dd');
        $list_rencana = $this->masterKegiatanModel->getAllByUserId(session('user_id'));
        $data = [
            'title' => 'Dashboard',
            'menu' => 'Dashboard',
            'subMenu' => 'Kegiatan Harian Pegawai',
            'events' => $events_json,
            'catatan' => $catatan_json,
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'total_laporan' => count($total_laporan),
            'total_kegiatan_bulan_ini' => $kegiatan_bulan_ini,
            'modal_detail' => '',
            'laporan_harian_tertentu' => NULL,
            'laporan_bulan_ini' => $laporan_bulan_ini,
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
            'nip_lama_pegawai_terpilih' => null,
            'today' => $today,
            'akses_tambah' => 'active',
            'list_satker' => $this->masterSatkerModel->getAllSatker(),
            'list_bidang' => $this->masterEs3Model->getAllBidang(),
            'pop_up' => 'off',
            'list_rencana' => $list_rencana

        ];
        // dd($data);
        return view('Dashboard/index', $data);
    }





    public function showDetailLaporanHarianOnDashboard($laporan_id)
    {
        $user_id_detail = $this->masterLaporanHarianModel->getUserIdbyLaporanId($laporan_id);

        if ($user_id_detail != null) {
            $data_user = $this->masterUserModel->getProfilUser($user_id_detail['user_id']);
            $data_pegawai_user = $this->masterPegawaiModel->getProfilPegawai($data_user['nip_lama_user']);
            $data_user_pilih = array_merge($data_user, $data_pegawai_user);
        } else {
            $data_user_pilih = null;
        }


        if ($user_id_detail['user_id'] == session('user_id')) {
            $event_data = $this->masterLaporanHarianModel->getAll(session('user_id'));
            $total_laporan = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));
            $total = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));
            $itemsCount = 10;
            $list_laporan_harian_detail = $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->paginate($itemsCount, 'list_laporan_harian');
            $pager_detail = $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->pager;
            $laporan_harian_tertentu_detail = $this->masterLaporanHarianModel->getLaporan(session('user_id'), $laporan_id);
            $list_full_laporan_harian_detail = $this->masterLaporanHarianModel->getTotalByUser(session('user_id'));
        } else {
            $event_data = $this->masterLaporanHarianModel->getAll($user_id_detail['user_id']);
            $total_laporan = $this->masterLaporanHarianModel->getTotalByUser($user_id_detail['user_id']);
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
        if (session('level_id') == "2") {
            if ($catatan_data != NULL) {
                foreach ($catatan_data as $catatan) {
                    //perbaikan fungsi join
                    $nip_lama_pengirim = $this->masterUserModel->getNipLamaByUserId($catatan['user_id']);
                    $pengirim = $this->masterPegawaiModel->getProfilPegawai($nip_lama_pengirim['nip_lama_user']);
                    $nip_lama_penerima = $this->masterUserModel->getNipLamaByUserId($catatan['user_id_penerima']);
                    $penerima = $this->masterPegawaiModel->getProfilPegawai($nip_lama_penerima['nip_lama_user']);

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


        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiOnDashboard();
        $ke = 0;
        foreach ($list_pegawai as $pegawai) {
            $nip_lama_pegawai = $this->masterPegawaiModel->getNipLama($pegawai['id']);
            $user_id_pegawai_laporan = $this->masterUserModel->getUserId($nip_lama_pegawai['nip_lama']);
            if ($user_id_pegawai_laporan != null) {
                $total_laporan_masing[$ke] = $this->masterLaporanHarianModel->getAllLaporanByUserId($user_id_pegawai_laporan['id']);
            } else {
                $total_laporan_masing[$ke] = [];
            }
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
            $nip_lama_pegawai = $this->masterPegawaiModel->getNipLama($pegawai['id']);
            $user_id_pegawai_laporan = $this->masterUserModel->getUserId($nip_lama_pegawai['nip_lama']);
            if ($user_id_pegawai_laporan != null) {
                $total_laporan_mingguan_masing[$ke_minggu] = $this->masterLaporanHarianModel->getAllLaporanByUserId2($user_id_pegawai_laporan['id']);
            } else {
                $total_laporan_mingguan_masing[$ke_minggu] = [];
            }
            $ke_minggu++;
        }
        for ($t = 0; $t < count($total_laporan_mingguan_masing); $t++) {
            $jml_minggu_pegawai[] = count($total_laporan_mingguan_masing[$t]);
        }

        $nip_lama = $this->masterUserModel->getProfilUser($user_id_detail);
        $list_rencana = $this->masterKegiatanModel->getAllByUserId(session('user_id'));

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
            'events' => $events_json,
            'catatan' => $catatan_json,
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'total_laporan' => count($total_laporan),
            'list_full_laporan_harian' =>  $list_full_laporan_harian_detail,
            'tanggal_mulai' => '2022-07-01',
            'pegawai_json' => $pegawai_json,
            'user_dipilih' => $data_user_pilih,
            'div_card' => 'd-none',
            'nip_lama_pegawai_terpilih' => $nip_lama['nip_lama_user'],
            'akses_tambah' => 'non-active',
            'list_pegawai' => $list_pegawai,
            'pegawai_json' => $pegawai_json,
            'jml_perbulan_pegawai' => $jml_bulan_pegawai,
            'jml_perminggu_pegawai' => $jml_minggu_pegawai,
            'pop_up' => 'on',
            'list_rencana' => $list_rencana
        ];
        dd($data);
        return view('Dashboard/index', $data);
    }


    public function showKegiatanPegawai($nip_lama)
    {
        $user_id_pegawai = $this->masterUserModel->getUserId($nip_lama);

        if ($user_id_pegawai != null) {
            $data_user = $this->masterUserModel->getProfilUser($user_id_pegawai['id']);
            $data_pegawai_user = $this->masterPegawaiModel->getProfilPegawai($data_user['nip_lama_user']);
            $data_user_pilih = array_merge($data_user, $data_pegawai_user);
        } else {
            $data_user_pilih = null;
        }


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
        if (session('level_id') == "2") {
            if ($catatan_data != NULL) {
                foreach ($catatan_data as $catatan) {
                    //perbaikan fungsi join
                    $nip_lama_pengirim = $this->masterUserModel->getNipLamaByUserId($catatan['user_id']);
                    $pengirim = $this->masterPegawaiModel->getProfilPegawai($nip_lama_pengirim['nip_lama_user']);
                    $nip_lama_penerima = $this->masterUserModel->getNipLamaByUserId($catatan['user_id_penerima']);
                    $penerima = $this->masterPegawaiModel->getProfilPegawai($nip_lama_penerima['nip_lama_user']);

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

        $laporan_bulan_ini = [];
        $jml_bulan_pegawai = [];
        $jml_bulan_pegawai = [];
        $laporan_bulan_pegawai = [];
        $list_pegawai = $this->masterPegawaiModel->getAllPegawaiOnDashboard();
        $ke = 0;
        foreach ($list_pegawai as $pegawai) {
            $nip_lama_pegawai = $this->masterPegawaiModel->getNipLama($pegawai['id']);
            $user_id_pegawai_laporan = $this->masterUserModel->getUserId($nip_lama_pegawai['nip_lama']);
            if ($user_id_pegawai_laporan != null) {
                $total_laporan_masing[$ke] = $this->masterLaporanHarianModel->getAllLaporanByUserId($user_id_pegawai_laporan['id']);
            } else {
                $total_laporan_masing[$ke] = [];
            }
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
            $nip_lama_pegawai = $this->masterPegawaiModel->getNipLama($pegawai['id']);
            $user_id_pegawai_laporan = $this->masterUserModel->getUserId($nip_lama_pegawai['nip_lama']);
            if ($user_id_pegawai_laporan != null) {
                $total_laporan_mingguan_masing[$ke_minggu] = $this->masterLaporanHarianModel->getAllLaporanByUserId2($user_id_pegawai_laporan['id']);
            } else {
                $total_laporan_mingguan_masing[$ke_minggu] = [];
            }
            $ke_minggu++;
        }

        for ($t = 0; $t < count($total_laporan_mingguan_masing); $t++) {
            $jml_minggu_pegawai[] = count($total_laporan_mingguan_masing[$t]);
        }
        $list_rencana = $this->masterKegiatanModel->getAllByUserId(session('user_id'));

        $data = [
            'title' => 'Dashboard',
            'menu' => 'Dashboard',
            'subMenu' => 'Kegiatan Harian Pegawai',
            'events' => $events_json,
            'catatan' => $catatan_json,
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'modal_detail' => '',
            'laporan_harian_tertentu' => NULL,
            'laporan_bulan_ini' => $laporan_bulan_ini,
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
            'nip_lama_pegawai_terpilih' => $nip_lama,
            'akses_tambah' => 'non-active',
            'list_satker' => $this->masterSatkerModel->getAllSatker(),
            'list_bidang' => $this->masterEs3Model->getAllBidang(),
            'pop_up' => 'on-2',
            'list_rencana' => $list_rencana

        ];
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
            //perbaikan fungsi join
            $nip_lama_pengirim = $this->masterUserModel->getNipLamaByUserId($catatan['user_id']);
            $pengirim = $this->masterPegawaiModel->getProfilPegawai($nip_lama_pengirim['nip_lama_user']);
            $nip_lama_penerima = $this->masterUserModel->getNipLamaByUserId($catatan['user_id_penerima']);
            $penerima = $this->masterPegawaiModel->getProfilPegawai($nip_lama_penerima['nip_lama_user']);

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
        return view('Dashboard/detailCatatan', $data);
    }
}
