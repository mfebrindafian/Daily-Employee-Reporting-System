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
use PHPUnit\Framework\Test;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


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
            'list_rencana' => $this->masterKegiatanModel->getAllByUserId(session('user_id'))
        ];
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
        $field_jam = $this->request->getVar('field_jam');
        $field_menit = $this->request->getVar('field_menit');

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

        $uraian_laporan = array('kode_tipe' => $field_tipe, 'kd_rencana' => $field_rencana, 'uraian' => $field_uraian, 'jumlah' => $field_jumlah, 'satuan' => $field_satuan, 'hasil' => $field_hasil, 'durasi_jam' => $field_jam, 'durasi_menit' => $field_menit, 'bukti_dukung' => $namaFile);

        $json_laporan = json_encode($uraian_laporan);

        $this->masterLaporanHarianModel->save([
            'user_id' => session('user_id'),
            'tgl_kegiatan' => $tanggal,
            'uraian_kegiatan' => $json_laporan,
        ]);
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
            'list_rencana' => $this->masterKegiatanModel->getAllByUserId(session('user_id'))
        ];
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


        $uraian_laporan = array('uraian' => $uraian, 'jumlah' => $jumlah, 'satuan' => $satuan, 'hasil' => $hasil, 'bukti_dukung' => $namaFile);
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
        $field_jam = $this->request->getVar('field_jam');
        $field_menit = $this->request->getVar('field_menit');

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



        $uraian_laporan = array('kode_tipe' => $field_tipe, 'kd_rencana' => $field_rencana, 'uraian' => $field_uraian, 'jumlah' => $field_jumlah, 'satuan' => $field_satuan, 'hasil' => $field_hasil, 'durasi_jam' => $field_jam, 'durasi_menit' => $field_menit, 'bukti_dukung' => $namaFile);

        $encode_laporan = json_encode($uraian_laporan);


        $this->masterLaporanHarianModel->save([
            'id' => $laporan_id,
            'user_id' => session('user_id'),
            'tgl_kegiatan' => $tanggal,
            'uraian_kegiatan' => $encode_laporan,
        ]);
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
            'list_rencana' => $this->masterKegiatanModel->getAllByUserId(session('user_id'))
        ];
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
                    $list_jam = $data->durasi_jam;
                    $list_menit = $data->durasi_menit;
                    $sheet->setCellValue(('G' . $column), $list_jam[$i] . ' Jam ' . $list_menit[$i] . ' Menit');



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
                    $list_jam = $data->durasi_jam;
                    $list_menit = $data->durasi_menit;
                    $sheet->setCellValue(('G' . $column), $list_jam[$i] . ' Jam ' . $list_menit[$i] . ' Menit');


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
                            $list_jam = $data->durasi_jam;
                            $list_menit = $data->durasi_menit;
                            $sheet->setCellValue(('G' . $column), $list_jam[$i] . ' Jam ' . $list_menit[$i] . ' Menit');



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
}
