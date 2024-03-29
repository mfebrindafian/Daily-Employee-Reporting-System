<?php

namespace App\Controllers;


use App\Models\MasterLaporanHarianModel;
use App\Models\MasterSatuanModel;
use App\Models\MasterUserModel;
use App\Models\MasterPegawaiModel;
use App\Models\MasterEs3Model;
use App\Models\MasterSatkerModel;
use App\Models\MasterKegiatanModel;
use CodeIgniter\Session\Session;
use DateTime;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PHPUnit\Framework\Test;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;


class masterLaporanHarian extends BaseController
{
    protected $masterSatuanModel;
    protected $masterUserModel;
    protected $masterPegawaiModel;
    protected $masterEs3Model;
    protected $masterSatkerModel;
    protected $masterLaporanHarianModel;
    protected $masterKegiatanModel;
    public function __construct()
    {
        $this->masterSatuanModel = new masterSatuanModel();
        $this->masterUserModel = new masterUserModel();
        $this->masterPegawaiModel = new masterPegawaiModel();
        $this->masterEs3Model = new masterEs3Model();
        $this->masterSatkerModel = new masterSatkerModel();
        $this->masterLaporanHarianModel = new masterLaporanHarianModel();
        $this->masterKegiatanModel = new masterKegiatanModel();
    }
    public function listLaporan()
    {

        $cek_kegiatan = $this->masterKegiatanModel->getAllByUserId(session('user_id'));
        if (session('level_id') == 2) {
            if (count($cek_kegiatan) == 0) {
                session()->setFlashdata('pesan', 'Tambahkan sasaran Kegiatan Tahunan Terlebih Dahulu!');
                session()->setFlashdata('icon', 'error');
                return redirect()->to('/rincianKegiatanPegawai');
            }
        }

        $all_year = $this->masterLaporanHarianModel->getAllYear(session('user_id'));
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
        $keyword = $this->request->getVar('keyword');
        $itemsCount = 10;


        $tanggal_input_terakhir = $this->masterLaporanHarianModel->getMaxDate(session('user_id'));

        $input_hari_ini = $this->masterLaporanHarianModel->getDateToday(date('Y-m-d'), session('user_id'));

        if ($input_hari_ini) {
            $tanggal_input_terakhir = null;
        }

        $laporan_today = $this->masterLaporanHarianModel->getTotalByUserToday(session('user_id'), date('Y-m-d'));
        // dd($laporan_today);
        $jumlah_jam = [];
        $jumlah_menit = [];
        if ($laporan_today != null) {
            $laporan = $laporan_today['uraian_kegiatan'];
            $data = json_decode($laporan);
            $uraian = $data->uraian;
            $jam_mulai = $data->jam_mulai;
            $jam_selesai = $data->jam_selesai;

            $ke = 0;
            foreach ($uraian as $u) {
                $time1 = new DateTime($jam_mulai[$ke]);
                $time2 = new DateTime($jam_selesai[$ke]);
                $timediff = $time1->diff($time2);
                $all_jam[] = $timediff->format('%h');
                $all_menit[] = $timediff->format('%i');
                $jumlah_menit = array_sum($all_menit);

                while ($jumlah_menit >= 60) {
                    $jumlah_menit = $jumlah_menit - 60;
                    $all_jam[] = 1;
                }
                $jumlah_jam = array_sum($all_jam);
                $ke++;
            }
        } else {
            $jumlah_jam = 0;
            $jumlah_menit = 0;
        }

        $data = [
            'title' => 'List Laporan',
            'menu' => 'Laporan Harian',
            'subMenu' => 'Daftar Laporan',
            'total' => count($this->masterLaporanHarianModel->getTotalByUser(session('user_id'))),
            'list_full_laporan_harian' =>  $this->masterLaporanHarianModel->getTotalByUser(session('user_id')),
            'pager' => $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->pager,
            'itemsCount' => $itemsCount,
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'modal_edit' => '',
            'modal_detail' => '',
            'laporan_harian_tertentu' => NULL,
            'tanggal_input_terakhir' => $tanggal_input_terakhir,
            'tahun_tersedia' => $tahun_tersedia,
            'keyword' => $keyword,
            'list_rencana' => $this->masterKegiatanModel->getAllByUserId(session('user_id')),
            'jam' => $jumlah_jam,
            'menit' => $jumlah_menit
        ];
        // dd($data);
        return view('laporanHarian/listLaporan', $data);
    }

    public function saveLaporanHarian()
    {
        $tanggal = $this->request->getVar('tanggal');
        $field_uraian = $this->request->getVar('field_uraian');
        $field_jumlah = $this->request->getVar('field_jumlah');
        $field_satuan = $this->request->getVar('field_satuan');
        $field_hasil = $this->request->getVar('field_hasil');
        $field_tipe = $this->request->getVar('field_tipe');
        $field_rencana = $this->request->getVar('field_rencana');


        $field_jam_mulai = $this->request->getVar('field_jam_mulai');
        $field_jam_selesai = $this->request->getVar('field_jam_selesai');


        for ($i = 1; $i <= count($field_uraian); $i++) {
            $field_bukti[] = $this->request->getFileMultiple('field_bukti' . $i);
        }

        $data_user = session('data_user');
        $folderNIP = $data_user['nip_lama_user'];
        $dirname = 'berkas/' . $folderNIP . '/' . $tanggal;

        if (!file_exists($dirname)) {
            mkdir('berkas/' . $folderNIP . '/' . $tanggal, 0777, true);
        }
        for ($h = 0; $h < count($field_bukti); $h++) {
            for ($i = 0; $i < count($field_bukti[$h]); $i++) {
                for ($j = 0; $j < count($field_bukti[$h]); $j++) {
                    $ekstensi[$i][$j] = $field_bukti[$h][$i]->getExtension();
                    $namaFile[$h][$i] = $tanggal;
                    $namaFile[$h][$i] .= '_kegiatan_ke-';
                    $namaFile[$h][$i] .= $h + 1;
                    $namaFile[$h][$i] .= '_bukti_dukung_ke-';
                    $namaFile[$h][$i] .= $i + 1;
                    $namaFile[$h][$i] .= '.';
                    $namaFile[$h][$i] .= $ekstensi[$i][$j];
                }
                $field_bukti[$h][$i]->move(
                    $dirname,
                    $namaFile[$h][$i]
                );
            }
        }

        $uraian_laporan = array('kode_tipe' => $field_tipe, 'kd_rencana' => $field_rencana, 'uraian' => $field_uraian, 'jumlah' => $field_jumlah, 'satuan' => $field_satuan, 'hasil' => $field_hasil, 'jam_mulai' => $field_jam_mulai, 'jam_selesai' => $field_jam_selesai, 'bukti_dukung' => $namaFile);

        $json_laporan = json_encode($uraian_laporan);

        $this->masterLaporanHarianModel->save([
            'user_id' => session('user_id'),
            'tgl_kegiatan' => $tanggal,
            'uraian_kegiatan' => $json_laporan,
        ]);


        foreach ($field_rencana as $rencana) {
            if ($rencana != 0) {
                $this->masterKegiatanModel->save([
                    'id' => $rencana,
                    'status_rincian' => 'T',
                    'tgl_update' => $tanggal
                ]);
            }
        }
        session()->setFlashdata('pesan', 'Kegiatan Berhasil Ditambahkan');
        session()->setFlashdata('icon', 'success');
        return redirect()->to('/listLaporan');
    }

    public function detailKegiatan()
    {
        $data = [
            'title' => 'Detail Kegiatan',
            'menu' => 'Laporan Harian',
            'subMenu' => 'Daftar Laporan'
        ];
        return view('laporanHarian/detailKegiatan', $data);
    }


    public function showEditLaporanHarian($laporan_id)
    {
        $keyword = $this->request->getVar('keyword');
        $all_year = $this->masterLaporanHarianModel->getAllYear(session('user_id'));
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
        $itemsCount = 10;
        $tanggal_input_terakhir = $this->masterLaporanHarianModel->getMaxDate(session('user_id'));
        $data = [
            'title' => 'List Laporan',
            'menu' => 'Laporan Harian',
            'subMenu' => 'Daftar Laporan',
            'total' => count($this->masterLaporanHarianModel->getTotalByUser(session('user_id'))),
            'list_laporan_harian' => $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->paginate($itemsCount, 'list_laporan_harian'),
            'pager' => $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->pager,
            'itemsCount' => $itemsCount,
            'laporan_harian_tertentu' => $this->masterLaporanHarianModel->getLaporan(session('user_id'), $laporan_id),
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'modal_edit' => 'modal-edit',
            'modal_detail' => '',
            'tanggal_input_terakhir' => $tanggal_input_terakhir,
            'tahun_tersedia' => $tahun_tersedia,
            'keyword' => $keyword,
            'list_full_laporan_harian' =>  $this->masterLaporanHarianModel->getTotalByUser(session('user_id')),
            'list_rencana' => $this->masterKegiatanModel->getAllByUserId(session('user_id')),
            'jam' => 0,
            'menit' => 0
        ];
        // dd($data);
        return view('laporanHarian/listLaporan', $data);
    }

    public function hapusBuktiDukung()
    {
        $tanggal = $this->request->getVar('tanggal_hapus');
        $laporan_id = $this->request->getVar('id_laporan_tertentu');
        $posisi_array = $this->request->getVar('posisi_array');
        $posisi_dalam_array = $this->request->getVar('posisi_dalam_array');

        $data_user = session('data_user');
        $folderNIP = $data_user['nip_lama_user'];


        $laporan_harian_tertentu = $this->masterLaporanHarianModel->getLaporan(session('user_id'), $laporan_id);
        $laporan = $laporan_harian_tertentu['uraian_kegiatan'];
        $decode_laporan = json_decode($laporan);

        $bukti_dukung = $decode_laporan->bukti_dukung;
        $hasil = $decode_laporan->hasil;
        $jumlah = $decode_laporan->jumlah;
        $satuan = $decode_laporan->satuan;
        $uraian = $decode_laporan->uraian;
        $field_tipe = $decode_laporan->kode_tipe;
        $field_rencana = $decode_laporan->kd_rencana;
        $field_jam_mulai = $decode_laporan->jam_mulai;
        $field_jam_selesai = $decode_laporan->jam_selesai;


        $nama_file_hapus = $bukti_dukung[$posisi_array][$posisi_dalam_array];

        unlink('berkas/' . $folderNIP . '/' . $tanggal . '/' . $nama_file_hapus);


        for ($i = 0; $i < count($bukti_dukung); $i++) {
            $k = 0;
            for ($j = 0; $j < count($bukti_dukung[$i]); $j++) {
                if ($bukti_dukung[$i][$j] != $nama_file_hapus) {
                    $namaFile[$i][$k] = $bukti_dukung[$i][$j];
                    $k++;
                }
            }
        }


        $uraian_laporan = array('kode_tipe' => $field_tipe, 'kd_rencana' => $field_rencana, 'uraian' => $uraian, 'jumlah' => $jumlah, 'satuan' => $satuan, 'hasil' => $hasil, 'jam_mulai' => $field_jam_mulai, 'jam_selesai' => $field_jam_selesai, 'bukti_dukung' => $namaFile);
        $encode_laporan = json_encode($uraian_laporan);

        $this->masterLaporanHarianModel->save([
            'id' => $laporan_id,
            'user_id' => session('user_id'),
            'tgl_kegiatan' => $tanggal,
            'uraian_kegiatan' => $encode_laporan,
        ]);

        return redirect()->to('/showEditLaporanHarian/' . $laporan_id);
    }



    public function updateLaporanHarian()
    {
        $laporan_id = $this->request->getVar('laporan_id_edit');
        $laporan_id = $this->request->getVar('id_laporan_harian_tertentu');
        $tanggal = $this->request->getVar('tanggal');
        $field_uraian = $this->request->getVar('field_uraian');
        $field_jumlah = $this->request->getVar('field_jumlah');
        $field_satuan = $this->request->getVar('field_satuan');
        $field_hasil = $this->request->getVar('field_hasil');
        $field_tipe = $this->request->getVar('field_tipe');
        $field_rencana = $this->request->getVar('field_rencana');
        $field_jam_mulai = $this->request->getVar('field_jam_mulai');
        $field_jam_selesai = $this->request->getVar('field_jam_selesai');
        // dd($field_rencana);

        $data_user = session('data_user');
        $folderNIP = $data_user['nip_lama_user'];
        $dirname = 'berkas/' . $folderNIP . '/' . $tanggal;

        for ($i = 1; $i <= count($field_uraian); $i++) {
            $field_bukti[] = $this->request->getFileMultiple('field_bukti' . $i);
        }
        // dd($field_bukti);

        for ($i = 0; $i < count($field_bukti); $i++) {
            for ($j = 0; $j < count($field_bukti[$i]); $j++) {
                if ($this->request->getVar('field_bukti_lama' . ($i + 1)) != null) {
                    $field_bukti_baru[$i] = $this->request->getVar('field_bukti_lama' . ($i + 1));
                } else {
                    $field_bukti_baru[$i] = [];
                }
            }
        }



        for ($i = 0; $i < count($field_bukti_baru); $i++) {
            $a[] = count($field_bukti_baru[$i]);
        }

        for ($h = 0; $h < count($field_bukti); $h++) {
            for ($i = 0; $i < count($field_bukti[$h]); $i++) {
                for ($j = 0; $j < count($field_bukti[$h]); $j++) {
                    if ($field_bukti[$h][$i]->getError() != 4) {
                        $ekstensi[$i][$j] = $field_bukti[$h][$i]->getExtension();
                        $namaFile[$h][$i] = $tanggal;
                        $namaFile[$h][$i] .= '_kegiatan_ke-';
                        $namaFile[$h][$i] .= $h + 1;
                        $namaFile[$h][$i] .= '_bukti_dukung_ke-';
                        $namaFile[$h][$i] .= $a[$h] + $i + 1;
                        $namaFile[$h][$i] .= '.';
                        $namaFile[$h][$i] .= $ekstensi[$i][$j];
                    }
                }
                if ($field_bukti[$h][$i]->getError() != 4) {
                    $field_bukti[$h][$i]->move(
                        $dirname,
                        $namaFile[$h][$i]
                    );
                }
            }
        }




        for ($i = 0; $i < count($field_bukti); $i++) {
            for ($j = 0; $j < count($field_bukti[$i]); $j++) {
                if ($field_bukti[$i][$j]->getError() != 4) {
                    $field_bukti_baru[$i][$a[$i] + $j] = $namaFile[$i][$j];
                }
            }
        }




        $uraian_laporan = array('kode_tipe' => $field_tipe, 'kd_rencana' => $field_rencana, 'uraian' => $field_uraian, 'jumlah' => $field_jumlah, 'satuan' => $field_satuan, 'hasil' => $field_hasil, 'jam_mulai' => $field_jam_mulai, 'jam_selesai' => $field_jam_selesai, 'bukti_dukung' => $field_bukti_baru);

        $encode_laporan = json_encode($uraian_laporan);


        $this->masterLaporanHarianModel->save([
            'id' => $laporan_id,
            'user_id' => session('user_id'),
            'tgl_kegiatan' => $tanggal,
            'uraian_kegiatan' => $encode_laporan,
        ]);

        foreach ($field_rencana as $rencana) {
            if ($rencana != 0) {
                $this->masterKegiatanModel->save([
                    'id' => $rencana,
                    'status_rincian' => 'T',
                    'tgl_update' => $tanggal
                ]);
            }
        }
        session()->setFlashdata('pesan', 'Kegiatan Berhasil Diupdate');
        session()->setFlashdata('icon', 'success');
        return redirect()->to('/listLaporan');
    }

    public function showDetailLaporanHarian($laporan_id)
    {
        $keyword = $this->request->getVar('keyword');
        $all_year = $this->masterLaporanHarianModel->getAllYear(session('user_id'));
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
        $itemsCount = 10;
        $tanggal_input_terakhir = $this->masterLaporanHarianModel->getMaxDate(session('user_id'));
        $data = [
            'title' => 'List Laporan',
            'menu' => 'Laporan Harian',
            'subMenu' => 'Daftar Laporan',
            'total' => count($this->masterLaporanHarianModel->getTotalByUser(session('user_id'))),
            'list_laporan_harian' => $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->paginate($itemsCount, 'list_laporan_harian'),
            'pager' => $this->masterLaporanHarianModel->getAllByUser(session('user_id'))->pager,
            'itemsCount' => $itemsCount,
            'laporan_harian_tertentu' => $this->masterLaporanHarianModel->getLaporan(session('user_id'), $laporan_id),
            'list_satuan' => $this->masterSatuanModel->getAll(),
            'modal_edit' => '',
            'modal_detail' => 'modal-detail',
            'tanggal_input_terakhir' => $tanggal_input_terakhir,
            'tahun_tersedia' => $tahun_tersedia,
            'keyword' => $keyword,
            'list_full_laporan_harian' =>  $this->masterLaporanHarianModel->getTotalByUser(session('user_id')),
            'list_rencana' => $this->masterKegiatanModel->getAllByUserId(session('user_id')),
            'jam' => 0,
            'menit' => 0
        ];
        // dd($data);
        return view('laporanHarian/listLaporan', $data);
    }

    public function cetakLaporan()
    {
        $bulan = array(
            1 =>       'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $tgl_awl = $this->request->getVar('tgl_awal');
        // dd($tgl_awl);
        $var1 = explode('-', $tgl_awl);
        $tgl_awal = $var1[2] . ' ' . $bulan[(int)$var1[1]] . ' ' . $var1[0];
        $tgl_akhr = $this->request->getVar('tgl_akhir');

        if ($tgl_akhr == "") {
            $tgl_akhr = date('Y-m-d');
            $var2 = explode('-', $tgl_akhr);
            $tgl_akhir = $var2[2] . ' ' . $bulan[(int)$var2[1]] . ' ' . $var2[0];
        } else {
            $var2 = explode('-', $tgl_akhr);
            $tgl_akhir = $var2[2] . ' ' . $bulan[(int)$var2[1]] . ' ' . $var2[0];
        }

        $list_laporan = $this->masterLaporanHarianModel->getTotalByUserDate($tgl_awl, $tgl_akhr, session('user_id'));

        $data_profil_user = $this->masterUserModel->getProfilUser(session('user_id'));
        $data_pegawai_user = $this->masterPegawaiModel->getProfilCetak($data_profil_user['nip_lama_user']);


        if ($list_laporan != null) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Satuan Organisasi');
            $sheet->setCellValue('A2', 'Nama');
            $sheet->setCellValue('A3', 'Jabatan');
            $sheet->setCellValue('A4', 'Periode');

            $sheet->setCellValue('C1', $data_pegawai_user['satker']);
            $sheet->setCellValue('C2', $data_pegawai_user['nama_pegawai']);
            $sheet->setCellValue('C3', $data_pegawai_user['jabatan_fungsional']);
            $sheet->setCellValue('C4', ($tgl_awal . ' - ' . $tgl_akhir));

            $sheet->setCellValue('A6', 'No.');
            $sheet->setCellValue('B6', 'Tanggal Kegiatan');
            $sheet->setCellValue('C6', 'Uraian Kegiatan');
            $sheet->setCellValue('D6', 'Satuan');
            $sheet->setCellValue('E6', 'Jumlah');
            $sheet->setCellValue('F6', 'Hasil Kegiatan');
            $sheet->setCellValue('G6', 'Durasi Kerja');
            $sheet->setCellValue('H6', 'Bukti Dukung');

            $column = 7; //Kolom start


            for ($a = 0; $a < count($list_laporan); $a++) {
                $laporan = $list_laporan[$a]['uraian_kegiatan'];
                $data = json_decode($laporan);
                for ($i = 0; $i < count($list_uraian = $data->uraian); $i++) {
                    $sheet->setCellValue(('A' . $column), ($column - 6));
                    $tgl_kegiatan =  $list_laporan[$a]['tgl_kegiatan'];
                    $var3 = explode('-', $tgl_kegiatan);
                    $tgl_kegiatan_pegawai = $var3[2] . ' ' . $bulan[(int)$var3[1]] . ' ' . $var3[0];
                    $sheet->setCellValue(('B' . $column), $tgl_kegiatan_pegawai);
                    $list_uraian = $data->uraian;
                    $sheet->setCellValue(('C' . $column), $list_uraian[$i]);
                    $list_satuan2 = $data->satuan;
                    $sheet->setCellValue(('D' . $column), $list_satuan2[$i]);
                    $list_jumlah = $data->jumlah;
                    $sheet->setCellValue(('E' . $column), $list_jumlah[$i]);
                    $list_hasil = $data->hasil;
                    $sheet->setCellValue(('F' . $column), $list_hasil[$i]);
                    $jam_mulai = $data->jam_mulai;
                    $jam_selesai = $data->jam_selesai;
                    $sheet->setCellValue(('G' . $column), $jam_mulai[$i] . ' - ' . $jam_selesai[$i]);



                    $list_bukti_dukung = $data->bukti_dukung;
                    $bukti_cell = '';
                    $data_user = session('data_user');
                    $folderNIP = $data_user['nip_lama_user'];
                    for ($j = 0; $j < count($list_bukti_dukung[$i]); $j++) {
                        if ($bukti_cell != '') {
                            $bukti_cell .= ', ' . (base_url('/berkas/' . $folderNIP . '/' . $list_laporan[$a]['tgl_kegiatan'] . '/' . $list_bukti_dukung[$i][$j]));
                        } else {
                            $bukti_cell = (base_url('/berkas/' . $folderNIP . '/' . $list_laporan[$a]['tgl_kegiatan'] . '/' . $list_bukti_dukung[$i][$j]));
                        }
                    }
                    $sheet->setCellValue(('H' . $column), $bukti_cell);
                    $column++;
                }
            }
            $sheet->getStyle('A6:H6')->getFont()->setBold(true);
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],

            ];
            $sheet->getStyle('A6:H' . ($column - 1))->applyFromArray($styleArray);

            $styleArray2 = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle('A6:G6')->applyFromArray($styleArray2);
            $sheet->getStyle('A7:A' . ($column - 1))->applyFromArray($styleArray2);
            $sheet->getStyle('D7:D' . ($column - 1))->applyFromArray($styleArray2);
            $sheet->getStyle('E7:E' . ($column - 1))->applyFromArray($styleArray2);



            $sheet->getDefaultRowDimension()->setRowHeight(-1);
            $sheet->getColumnDimension('A')->setWidth(5);;
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);

            // Set judul file excel nya
            $sheet->setTitle("Laporan Pegawai");
            $nama_file = 'Laporan_' . $data_user['fullname'] . '_tanggal_' . $tgl_awal . ' hingga ' . $tgl_akhir;
            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            ob_end_clean();
            $writer->save('php://output');
            exit();
        } else {
            session()->setFlashdata('pesan', 'Laporan pada tanggal yang ditentukan tidak tersedia!');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/listLaporan');
        }
    }

    public function cetakLaporanByPimpinan()
    {
        $bulan = array(
            1 =>       'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        $tgl_awl = $this->request->getVar('tgl_awal');
        $var1 = explode('-', $tgl_awl);
        $tgl_awal = $var1[2] . ' ' . $bulan[(int)$var1[1]] . ' ' . $var1[0];
        $tgl_akhr = $this->request->getVar('tgl_akhir');

        if ($tgl_akhr == "") {
            $tgl_akhr = date('Y-m-d');
            $var2 = explode('-', $tgl_akhr);
            $tgl_akhir = $var2[2] . ' ' . $bulan[(int)$var2[1]] . ' ' . $var2[0];
        } else {
            $var2 = explode('-', $tgl_akhr);
            $tgl_akhir = $var2[2] . ' ' . $bulan[(int)$var2[1]] . ' ' . $var2[0];
        }

        $nip_lama_pegawai_dipilih = $this->request->getVar('nip_lama_dipilih');
        // $user_id = $this->request->getVar('user_id_cetak_dipilih');
        $user_id = $this->masterUserModel->getUserId($this->request->getVar('nip_lama_dipilih'));

        $list_laporan = $this->masterLaporanHarianModel->getTotalByUserDate($tgl_awl, $tgl_akhr, $user_id);
        $data_profil_user = $this->masterUserModel->getProfilUser($user_id);

        $data_pegawai_user = $this->masterPegawaiModel->getProfilCetak($data_profil_user['nip_lama_user']);
        // dd($data_pegawai_user);

        if ($list_laporan != null) {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'Satuan Organisasi');
            $sheet->setCellValue('A2', 'Nama');
            $sheet->setCellValue('A3', 'Jabatan');
            $sheet->setCellValue('A4', 'Periode');

            $sheet->setCellValue('C1', $data_pegawai_user['satker']);
            $sheet->setCellValue('C2', $data_pegawai_user['nama_pegawai']);
            $sheet->setCellValue('C3', $data_pegawai_user['jabatan_fungsional']);
            $sheet->setCellValue('C4', ($tgl_awal . ' - ' . $tgl_akhir));

            $sheet->setCellValue('A6', 'No.');
            $sheet->setCellValue('B6', 'Tanggal Kegiatan');
            $sheet->setCellValue('C6', 'Uraian Kegiatan');
            $sheet->setCellValue('D6', 'Satuan');
            $sheet->setCellValue('E6', 'Jumlah');
            $sheet->setCellValue('F6', 'Hasil Kegiatan');
            $sheet->setCellValue('G6', 'Durasi Kerja');
            if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd') || session('jabatan') == 'koordinator' && session('es3_kd') == 0) {
                $sheet->setCellValue('H6', 'Bukti Dukung');
            }


            $column = 7; //Kolom start


            for ($a = 0; $a < count($list_laporan); $a++) {
                $laporan = $list_laporan[$a]['uraian_kegiatan'];
                $data = json_decode($laporan);
                for ($i = 0; $i < count($list_uraian = $data->uraian); $i++) {
                    $sheet->setCellValue(('A' . $column), ($column - 6));
                    $tgl_kegiatan =  $list_laporan[$a]['tgl_kegiatan'];
                    $var3 = explode('-', $tgl_kegiatan);
                    $tgl_kegiatan_pegawai = $var3[2] . ' ' . $bulan[(int)$var3[1]] . ' ' . $var3[0];
                    $sheet->setCellValue(('B' . $column), $tgl_kegiatan_pegawai);
                    $list_uraian = $data->uraian;
                    $sheet->setCellValue(('C' . $column), $list_uraian[$i]);
                    $list_satuan2 = $data->satuan;
                    $sheet->setCellValue(('D' . $column), $list_satuan2[$i]);
                    $list_jumlah = $data->jumlah;
                    $sheet->setCellValue(('E' . $column), $list_jumlah[$i]);
                    $list_hasil = $data->hasil;
                    $sheet->setCellValue(('F' . $column), $list_hasil[$i]);
                    $jam_mulai = $data->jam_mulai;
                    $jam_selesai = $data->jam_selesai;
                    $sheet->setCellValue(('G' . $column), $jam_mulai[$i] . ' - ' . $jam_selesai[$i]);


                    if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd') || session('jabatan') == 'koordinator' && session('es3_kd') == 0) {
                        $list_bukti_dukung = $data->bukti_dukung;
                        $bukti_cell = '';
                        // $data_user = session('data_user');
                        // $folderNIP = $data_user['nip_lama_user'];
                        for ($j = 0; $j < count($list_bukti_dukung[$i]); $j++) {
                            if ($bukti_cell != '') {
                                $bukti_cell .= ', ' . (base_url('/berkas/' . $data_pegawai_user['nip_lama'] . '/' . $list_laporan[$a]['tgl_kegiatan'] . '/' . $list_bukti_dukung[$i][$j]));
                            } else {
                                $bukti_cell = (base_url('/berkas/' . $data_pegawai_user['nip_lama'] . '/' . $list_laporan[$a]['tgl_kegiatan'] . '/' . $list_bukti_dukung[$i][$j]));
                            }
                        }
                        $sheet->setCellValue(('H' . $column), $bukti_cell);
                    }
                    $column++;
                }
            }
            if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd')) {
                $sheet->getStyle('A6:H6')->getFont()->setBold(true);
            } else {
                $sheet->getStyle('A6:G6')->getFont()->setBold(true);
            }
            $styleArray = [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],

            ];
            if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd') || session('jabatan') == 'koordinator' && session('es3_kd') == 0) {
                $sheet->getStyle('A6:G' . ($column - 1))->applyFromArray($styleArray);
            } else {
                $sheet->getStyle('A6:G' . ($column - 1))->applyFromArray($styleArray);
            }

            $styleArray2 = [
                'alignment' => [
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ];

            $sheet->getStyle('A6:G6')->applyFromArray($styleArray2);
            $sheet->getStyle('A7:A' . ($column - 1))->applyFromArray($styleArray2);
            $sheet->getStyle('D7:D' . ($column - 1))->applyFromArray($styleArray2);
            $sheet->getStyle('E7:E' . ($column - 1))->applyFromArray($styleArray2);



            $sheet->getDefaultRowDimension()->setRowHeight(-1);
            $sheet->getColumnDimension('A')->setWidth(5);;
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setAutoSize(true);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setAutoSize(true);
            $sheet->getColumnDimension('G')->setAutoSize(true);

            // Set judul file excel nya
            $sheet->setTitle("Laporan Pegawai");
            $nama_file = 'Laporan_' . $data_pegawai_user['nama_pegawai'] . '_tanggal_' . $tgl_awal . ' hingga ' . $tgl_akhir;
            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            ob_end_clean();
            $writer->save('php://output');
            exit();
        } else {
            session()->setFlashdata('pesan', 'Laporan pada tanggal yang ditentukan tidak tersedia!');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/showKegiatanPegawai/' . $nip_lama_pegawai_dipilih);
        }
    }


    public function cetakLaporanByBidang()
    {
        $bulan = array(
            1 =>       'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $tgl_awl = $this->request->getVar('tgl_awal');

        $var1 = explode('-', $tgl_awl);
        $tgl_awal = $var1[2] . ' ' . $bulan[(int)$var1[1]] . ' ' . $var1[0];
        $tgl_akhr = $this->request->getVar('tgl_akhir');

        if ($tgl_akhr == "") {
            $tgl_akhr = date('Y-m-d');
            $var2 = explode('-', $tgl_akhr);
            $tgl_akhir = $var2[2] . ' ' . $bulan[(int)$var2[1]] . ' ' . $var2[0];
        } else {
            $var2 = explode('-', $tgl_akhr);
            $tgl_akhir = $var2[2] . ' ' . $bulan[(int)$var2[1]] . ' ' . $var2[0];
        }

        $satker = $this->request->getVar('satker');
        $bidang = $this->request->getVar('bidang');
        $daftar_pegawai = $this->masterPegawaiModel->getAllPegawaiOnBidang($satker, $bidang);
        if ($daftar_pegawai == null) {
            session()->setFlashdata('pesan', 'Data pegawai tidak tersedia');
            session()->setFlashdata('icon', 'error');
            return redirect()->to('/dashboard');
        }


        if ($satker != 'all') {
            $satker_pilihan = $this->masterSatkerModel->getSatkerById($satker);
        } else {
            $satker_pilihan['satker'] = 'Seluruh Satker';
        }
        if ($bidang != 'all') {
            $bidang_pilihan = $this->masterEs3Model->getBidangById($bidang);
        } else {
            $bidang_pilihan['deskripsi'] = 'Seluruh Bidang';
        }


        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Satuan Organisasi');
        $sheet->setCellValue('C1', $satker_pilihan['satker']);
        $sheet->setCellValue('A2', 'Satuan Organisasi');
        $sheet->setCellValue('C2', $bidang_pilihan['deskripsi']);
        $sheet->setCellValue('A3', 'Periode');
        $sheet->setCellValue('C3', ($tgl_awal . ' - ' . $tgl_akhir));

        $column_nama = 5;
        $column_jabatan = 6;
        $column_head = 8;
        $column = 9; //Kolom start isi



        if ($daftar_pegawai != null) {
            foreach ($daftar_pegawai as $pegawai) {
                $data_pegawai_user = $this->masterPegawaiModel->getProfilCetak($pegawai['nip_lama']);
                $sheet->setCellValue(('A' . $column_nama), 'Nama');
                $sheet->setCellValue(('A' . $column_jabatan), 'Jabatan');

                $sheet->setCellValue(('C' . $column_nama), $data_pegawai_user['nama_pegawai']);
                $sheet->setCellValue(('C' . $column_jabatan), $data_pegawai_user['jabatan_fungsional']);


                $sheet->setCellValue(('A' . $column_head), 'No.');
                $sheet->setCellValue(('B' . $column_head), 'Tanggal Kegiatan');
                $sheet->setCellValue(('C' . $column_head), 'Uraian Kegiatan');
                $sheet->setCellValue(('D' . $column_head), 'Satuan');
                $sheet->setCellValue(('E' . $column_head), 'Jumlah');
                $sheet->setCellValue(('F' . $column_head), 'Hasil Kegiatan');
                $sheet->setCellValue(('G' . $column_head), 'Durasi Kerja');
                if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd') || session('jabatan') == 'koordinator' && session('es3_kd') == 0) {
                    $sheet->setCellValue(('H' . $column_head), 'Bukti Dukung');
                }



                $user_id = $this->masterUserModel->getUserId($data_pegawai_user['nip_lama']);
                $list_laporan = $this->masterLaporanHarianModel->getTotalByUserDate($tgl_awl, $tgl_akhr, $user_id);


                if ($list_laporan != null) {
                    $no_baris = 1;
                    for ($a = 0; $a < count($list_laporan); $a++) {
                        $laporan = $list_laporan[$a]['uraian_kegiatan'];
                        $data = json_decode($laporan);
                        for ($i = 0; $i < count($list_uraian = $data->uraian); $i++) {
                            $sheet->setCellValue(('A' . $column), $no_baris);
                            $tgl_kegiatan =  $list_laporan[$a]['tgl_kegiatan'];
                            $var3 = explode('-', $tgl_kegiatan);
                            $tgl_kegiatan_pegawai = $var3[2] . ' ' . $bulan[(int)$var3[1]] . ' ' . $var3[0];
                            $sheet->setCellValue(('B' . $column), $tgl_kegiatan_pegawai);
                            $list_uraian = $data->uraian;
                            $sheet->setCellValue(('C' . $column), $list_uraian[$i]);
                            $list_satuan2 = $data->satuan;
                            $sheet->setCellValue(('D' . $column), $list_satuan2[$i]);
                            $list_jumlah = $data->jumlah;
                            $sheet->setCellValue(('E' . $column), $list_jumlah[$i]);
                            $list_hasil = $data->hasil;
                            $sheet->setCellValue(('F' . $column), $list_hasil[$i]);
                            $jam_mulai = $data->jam_mulai;
                            $jam_selesai = $data->jam_selesai;
                            $sheet->setCellValue(('G' . $column), $jam_mulai[$i] . ' - ' . $jam_selesai[$i]);



                            if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd') || session('jabatan') == 'koordinator' && session('es3_kd') == 0) {
                                $list_bukti_dukung = $data->bukti_dukung;
                                $bukti_cell = '';
                                for ($j = 0; $j < count($list_bukti_dukung[$i]); $j++) {
                                    if ($bukti_cell != '') {
                                        $bukti_cell .= ', ' . (base_url('/berkas/' . $data_pegawai_user['nip_lama'] . '/' . $list_laporan[$a]['tgl_kegiatan'] . '/' . $list_bukti_dukung[$i][$j]));
                                    } else {
                                        $bukti_cell = (base_url('/berkas/' . $data_pegawai_user['nip_lama'] . '/' . $list_laporan[$a]['tgl_kegiatan'] . '/' . $list_bukti_dukung[$i][$j]));
                                    }
                                }
                                $sheet->setCellValue(('H' . $column), $bukti_cell);
                            }

                            $column++;
                            $no_baris++;
                        }
                    }
                }
                if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd') || session('jabatan') == 'koordinator' && session('es3_kd') == 0) {
                    $sheet->getStyle('A' . $column_head . ':G' . $column_head)->getFont()->setBold(true);
                } else {
                    $sheet->getStyle('A' . $column_head . ':F' . $column_head)->getFont()->setBold(true);
                }
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => 'FF000000'],
                        ],
                    ],

                ];
                if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd') || session('jabatan') == 'koordinator' && session('es3_kd') == 0) {
                    $sheet->getStyle('A' . $column_head . ':G' . ($column - 1))->applyFromArray($styleArray);
                } else {
                    $sheet->getStyle('A' . $column_head . ':F' . ($column - 1))->applyFromArray($styleArray);
                }
                $styleArray2 = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];



                $sheet->getStyle('A' . $column_head . ':F' . $column_head)->applyFromArray($styleArray2);
                $sheet->getStyle('A' . ($column_head + 1) . ':A' . ($column - 1))->applyFromArray($styleArray2);
                $sheet->getStyle('D' . ($column_head + 1) . ':D' . ($column - 1))->applyFromArray($styleArray2);
                $sheet->getStyle('E' . ($column_head + 1) . ':E' . ($column - 1))->applyFromArray($styleArray2);

                $styleArray3 = [
                    'alignment' => [
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        // 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                ];
                if (session('jabatan') == 'koordinator' && $data_pegawai_user['es3_kd'] == session('es3_kd') || session('jabatan') == 'koordinator' && session('es3_kd') == 0) {
                    $sheet->getStyle('G' . ($column_head + 1) . ':G' . ($column - 1))->applyFromArray($styleArray3);
                }
                $sheet->getStyle('F' . ($column_head + 1) . ':F' . ($column - 1))->applyFromArray($styleArray3);
                $sheet->getStyle('B' . ($column_head + 1) . ':B' . ($column - 1))->applyFromArray($styleArray3);
                $sheet->getStyle('C' . ($column_head + 1) . ':C' . ($column - 1))->applyFromArray($styleArray3);

                $no_baris = 1;
                $column_nama = ($column + 2);
                $column_jabatan = ($column + 3);
                $column_head = ($column + 5);
                $column = ($column + 6); //Kolom start isi
            }


            $sheet->getDefaultRowDimension()->setRowHeight(-1);
            $sheet->getColumnDimension('A')->setWidth(5);
            $sheet->getColumnDimension('B')->setAutoSize(true);
            $sheet->getColumnDimension('C')->setWidth(100);
            $sheet->getColumnDimension('D')->setAutoSize(true);
            $sheet->getColumnDimension('E')->setAutoSize(true);
            $sheet->getColumnDimension('F')->setWidth(50);
            $sheet->getStyle('C')->getAlignment()->setWrapText(true);
            $sheet->getStyle('F')->getAlignment()->setWrapText(true);

            // Set judul file excel nya
            $sheet->setTitle("Laporan Pegawai");


            $nama_file = 'Laporan_' . $satker_pilihan['satker'] . '_' . $bidang_pilihan['deskripsi'] . '_tanggal_' . $tgl_awal . ' hingga ' . $tgl_akhir;


            // Proses file excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . $nama_file . '.xlsx"'); // Set nama file excel nya
            header('Cache-Control: max-age=0');
            $writer = new Xlsx($spreadsheet);
            ob_end_clean();
            $writer->save('php://output');
            exit();
        }
    }

    public function inputCuti()
    {
        $tanggal_mulai = $this->request->getVar('tanggal_mulai');
        $tanggal_selesai = $this->request->getVar('tanggal_selesai');
        $keterangan = $this->request->getVar('keterangan');
        $file_bukti = $this->request->getFile('file_bukti');


        $data_user = session('data_user');
        $folderNIP = $data_user['nip_lama_user'];
        $dirname = 'berkas/' . $folderNIP . '/' . $tanggal_mulai;

        if (!file_exists($dirname)) {
            mkdir('berkas/' . $folderNIP . '/' . $tanggal_mulai, 0777, true);
        }
        $ekstensi = $file_bukti->getExtension();
        $namaFile = $tanggal_mulai;
        $namaFile .= '_bukti_cuti';
        $namaFile .= '.';
        $namaFile .= $ekstensi;
        $posisi_file = 'berkas/' . $folderNIP . '/' . $tanggal_mulai . '/' . $namaFile;

        if (!file_exists($posisi_file)) {
            $file_bukti->move($dirname, $namaFile);
        }


        $rangArray = [];
        $startDate = strtotime($tanggal_mulai);
        $endDate = strtotime($tanggal_selesai);
        for (
            $currentDate = $startDate;
            $currentDate <= $endDate;
            $currentDate += (86400)
        ) {
            $date = date('Y-m-d', $currentDate);
            $rangArray[] = $date;
        }

        foreach ($rangArray as $rang) {
            if (date('N', strtotime($rang)) < 6) {
                $rangArray2[] = $rang;
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
                $rangArray3[] = $rang2;
            }
        }

        $list_tanggal_terinput = $this->masterLaporanHarianModel->getAllYear(session('user_id'));

        foreach ($list_tanggal_terinput as $tanggal_input) {
            $tanggal_terinput[] = $tanggal_input['tgl_kegiatan'];
        }


        foreach ($rangArray3 as $rang3) {
            if (in_array($rang3, $tanggal_terinput) == false) {
                $rangArray4[] = $rang3;
            }
        }



        $field_tipe[] = '4';
        $field_rencana[] = '0';
        $field_uraian[] = $keterangan;
        $field_jumlah[] = '1';
        $field_satuan[] = 'Dokumen';
        $field_hasil[] = $keterangan;
        $field_jam_mulai[] = '07:30';
        $field_jam_selesai[] = '16:00';
        $field_jam_selesai2[] = '16:30';
        $namaFileSimpan[][] = $namaFile;


        $uraian_laporan1 = array('kode_tipe' => $field_tipe, 'kd_rencana' => $field_rencana, 'uraian' => $field_uraian, 'jumlah' => $field_jumlah, 'satuan' => $field_satuan, 'hasil' => $field_hasil, 'jam_mulai' => $field_jam_mulai, 'jam_selesai' => $field_jam_selesai, 'bukti_dukung' => $namaFileSimpan);
        $uraian_laporan2 = array('kode_tipe' => $field_tipe, 'kd_rencana' => $field_rencana, 'uraian' => $field_uraian, 'jumlah' => $field_jumlah, 'satuan' => $field_satuan, 'hasil' => $field_hasil, 'jam_mulai' => $field_jam_mulai, 'jam_selesai' => $field_jam_selesai2, 'bukti_dukung' => $namaFileSimpan);


        $json_laporan1 = json_encode($uraian_laporan1);
        $json_laporan2 = json_encode($uraian_laporan2);


        foreach ($rangArray4 as $rang4) {

            if (date('N', strtotime($rang4)) == '5') {
                $this->masterLaporanHarianModel->save([
                    'user_id' => session('user_id'),
                    'tgl_kegiatan' => $rang4,
                    'uraian_kegiatan' => $json_laporan2,
                ]);
            } else {
                $this->masterLaporanHarianModel->save([
                    'user_id' => session('user_id'),
                    'tgl_kegiatan' => $rang4,
                    'uraian_kegiatan' => $json_laporan1,
                ]);
            }
        }
        session()->setFlashdata('pesan', 'Kegiatan Cuti Berhasil Ditambahkan');
        session()->setFlashdata('icon', 'success');
        return redirect()->to('/listLaporan');
    }

    public function deleteLaporanKegiatan($laporan_id)
    {
        $data_laporan = $this->masterLaporanHarianModel->getLaporan(session('user_id'), $laporan_id);
        $laporan = $data_laporan['uraian_kegiatan'];
        $data = json_decode($laporan);
        $list_bukti_dukung = $data->bukti_dukung;
        $data_user = session('data_user');
        $folderNIP = $data_user['nip_lama_user'];

        $list_tipe = $data->kode_tipe;
        if ($list_tipe[0] != '4') {
            foreach ($list_bukti_dukung as $list_bukti) {
                foreach ($list_bukti as $list) {
                    unlink('berkas/' . $folderNIP . '/' . $data_laporan['tgl_kegiatan'] . '/' . $list);
                }
            }
            $this->masterLaporanHarianModel->delete($data_laporan['id']);
        } else {

            $abs_namafile = $list_bukti_dukung[0][0];
            $list_laporan = $this->masterLaporanHarianModel->getAll(session('user_id'));
            foreach ($list_laporan as $list) {
                $laporan2 = $list['uraian_kegiatan'];
                $data2 = json_decode($laporan2);
                $list_bukti_dukung2 = $data2->bukti_dukung;
                if ($list_bukti_dukung2[0][0] == $abs_namafile) {
                    $can_delete[] = $list;
                }
            }
            if (count($can_delete) == 1) {
                $tgl_hapus = explode('_', $abs_namafile);
                unlink('berkas/' . $folderNIP . '/' . $tgl_hapus[0] . '/' . $abs_namafile);
            }
            $this->masterLaporanHarianModel->delete($data_laporan['id']);
        }

        session()->setFlashdata('pesan', 'Kegiatan Berhasil Dihapus');
        session()->setFlashdata('icon', 'success');
        return redirect()->to('/listLaporan');
    }
}
