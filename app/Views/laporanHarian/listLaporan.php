<?= $this->extend('layout/template'); ?>
<?php if (allowHalaman(session('level_id'), $menu, $subMenu)) : ?>


    <?= $this->section('content'); ?>



    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Daftar Laporan</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active">Daftar Laporan Harian</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <span style="font-size:30px;"><span class="tgl-hari-ini"></span></span>
                            </div>
                            <div class="col-6 justify-content-end d-flex align-items-center">
                                <span class="text-right">
                                    Total Jam Kerja Hari Ini <span class="text-bold p-2 bg-info rounded ml-2 mr-1"><?= $jam; ?> Jam <?= $menit; ?> Menit</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary card-outline" style="border: #3c4b64;">
                    <div class="card-body box-profile">
                        <div class="row">
                            <div class="col-md-6 py-1">
                                <div class="input-group">
                                    <?php if ($tanggal_input_terakhir != null) {
                                        echo '<button type="button" id="btn-modal-tambah" class="btn btn-info tombol mr-2" style="background-color: #3c4b64; border:none;"><i class="fas fa-plus mr-2"></i>Tambah Laporan</button>';
                                    } ?>
                                    <?php if ($list_full_laporan_harian == NULL) {
                                        echo '<button type="button" id="btn-modal-tambah" class="btn btn-info tombol mr-2" style="background-color: #3c4b64; border:none;"><i class="fas fa-plus mr-2"></i>Tambah Laporan</button>';
                                    } ?>

                                    <button type="button" id="btn-cetak" data-toggle="modal" data-target="#modal-cetak" class="btn btn-info tombol mr-2" style="background-color: #3c4b64; border:none;"><i class="fas fa-print mr-2"></i>Cetak</button>
                                    <button type="button" data-toggle="modal" data-target="#modal-cuti" class="btn btn-outline-success tombol mr-2"><i class="fas fa-plus mr-2"></i>Tambah Cuti</button>
                                    <select name="tahun" class="form-control tahun" style="border-radius: 5px;">
                                        <option value="">--PILIH TAHUN--</option>
                                        <?php if ($tahun_tersedia != null) : ?>
                                            <?php foreach ($tahun_tersedia as $tahun) : ?>
                                                <option value="<?= $tahun; ?>"><?= $tahun; ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <select name="bulan" class="form-control ml-2 bulan opacity-0" style="border-radius: 5px;">
                                        <option value="">--PILIH BULAN--</option>
                                        <option value="01">Januari</option>
                                        <option value="02">Februari</option>
                                        <option value="03">Maret</option>
                                        <option value="04">April</option>
                                        <option value="05">Mei</option>
                                        <option value="06">Juni</option>
                                        <option value="07">Juli</option>
                                        <option value="08">Agustus</option>
                                        <option value="09">September</option>
                                        <option value="10">Oktober</option>
                                        <option value="12">November</option>
                                        <option value="12">Desember</option>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-6 py-1">
                                <div>
                                    <div id="tabelData_filter" class="input-group input-group-md float-right" style="width: 250px">
                                        <input type="search" id="pencarian" name="keyword" class="form-control float-right auto_search" placeholder="Search ..." />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-body table-responsive p-0 overflow-hidden">

                                <table class="table table-hover " id="tabelData">
                                    <thead>
                                        <tr>
                                            <th>NO.</th>
                                            <th>TANGGAL</th>
                                            <th>TIPE KEGIATAN</th>
                                            <th>URAIAN KEGIATAN</th>
                                            <th>JUMLAH</th>
                                            <th>SATUAN</th>
                                            <th>WAKTU KEGIATAN</th>
                                            <th>BUKTI DUKUNG</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php
                                        $start = 0;
                                        $no = 1;
                                        if ($list_full_laporan_harian != NULL) : ?>
                                            <?php

                                            foreach ($list_full_laporan_harian as $list) : ?>
                                                <tr>
                                                    <td><?= $no++; ?></td>
                                                    <td id="tgl-kegiatan-tabel"><?= $list['tgl_kegiatan']; ?></td>
                                                    <?php $laporan = $list['uraian_kegiatan']; ?>
                                                    <?php $data = json_decode($laporan); ?>
                                                    <?php $list_tipe = $data->kode_tipe ?>
                                                    <td> <?php foreach ($list_tipe as $tipe) : ?>
                                                            <div class="p-2 mb-1 rounded-sm card-laporan">
                                                                <?php if ($tipe == '1') {
                                                                    echo 'Berdasarkan sasaran kegiatan';
                                                                } elseif ($tipe == '2') {
                                                                    echo 'Umum';
                                                                } elseif ($tipe == '3') {
                                                                    echo 'Lembur';
                                                                } elseif ($tipe == '4') {
                                                                    echo 'Cuti';
                                                                } ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <?php $list_uraian = $data->uraian; ?>
                                                    <td>
                                                        <?php foreach ($list_uraian as $uraian) : ?>
                                                            <div class="p-2 mb-1 rounded-sm card-laporan">
                                                                <?= $uraian; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <?php $list_jumlah = $data->jumlah; ?>
                                                    <td><?php foreach ($list_jumlah as $jumlah) : ?>
                                                            <div class="p-2 mb-1 text-center rounded-sm card-laporan">
                                                                <?= $jumlah; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <?php $list_satuan2 = $data->satuan; ?>
                                                    <td><?php foreach ($list_satuan2 as $satuan) : ?>
                                                            <div class="p-2 mb-1 text-center rounded-sm card-laporan">
                                                                <?= $satuan; ?>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    </td>
                                                    <?php $jam_mulai = $data->jam_mulai; ?>
                                                    <?php $jam_selesai = $data->jam_selesai ?>
                                                    <?php $jamMul = 0; ?>
                                                    <td><?php foreach ($jam_mulai as $jam) : ?>
                                                            <div class="p-2 mb-1 text-center rounded-sm card-laporan">
                                                                <?= $jam_mulai[$jamMul]; ?> - <?= $jam_selesai[$jamMul]; ?>
                                                            </div>
                                                            <?php $jamMul++ ?>
                                                        <?php endforeach; ?>
                                                    </td>


                                                    <?php $list_bukti_dukung = $data->bukti_dukung; ?>
                                                    <?php $list_tipe = $data->kode_tipe; ?>

                                                    <td>
                                                        <?php $data_user = session('data_user'); ?>
                                                        <?php $folderNIP = $data_user['nip_lama_user'];  ?>
                                                        <?php foreach ($list_bukti_dukung as $bukti_dukung) : ?>
                                                            <div class="p-2 mb-1 rounded-sm card-bukti-laporan">
                                                                <?php foreach ($bukti_dukung as $b) : ?>
                                                                    <?php foreach ($list_tipe as $tipe) : ?>
                                                                        <?php if ($tipe != 4) : ?>
                                                                            <a title="<?= $b; ?>" target="_blank" href="<?= base_url('berkas/' . $folderNIP . '/' . $list['tgl_kegiatan'] . '/' . $b) ?>"> <?= $b; ?></a>
                                                                            <?php break; ?>
                                                                        <?php endif; ?>
                                                                        <?php if ($tipe == 4) : ?>
                                                                            <?php $fullbukti = explode('_', $b) ?>
                                                                            <a title="<?= $b; ?>" target="_blank" href="<?= base_url('berkas/' . $folderNIP . '/' . $fullbukti[0] . '/' . $b) ?>"> <?= $b; ?></a>
                                                                            <?php break; ?>
                                                                        <?php endif ?>

                                                                    <?php endforeach; ?>

                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endforeach; ?>

                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('/showDetailLaporanHarian/' . $list['id']) ?>" type="button" id="btn-detail" class="btn btn-sm btn-primary">
                                                            <span>Detail</span>
                                                        </a>
                                                        <?php foreach ($list_tipe as $tipe) : ?>
                                                            <?php if ($tipe != 4) : ?>
                                                                <a href=" <?= base_url('/showEditLaporanHarian/' . $list['id']) ?>" type="button" id="btn-edit" class="btn btn-sm btn-warning">
                                                                    <span>Edit</span>
                                                                </a>
                                                                <?php break; ?>
                                                            <?php endif ?>
                                                        <?php endforeach; ?>
                                                        <button class="btn btn-sm btn-danger" id="open-modal-hapus" data-toggle="modal" data-target="#modal-hapus" data-link="<?= base_url('/deleteLaporanKegiatan/' . $list['id']); ?>"> <span>Hapus</span></button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- MODAL HAPUS KEGIATAN -->
    <div class="modal fade" id="modal-hapus" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" style="top: 18%;">
            <form action="<?= base_url('/hapusBuktiDukung') ?>" method="POST">
                <div class="modal-content">
                    <div class="modal-header pt-3" style="border: none;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-5 py-3 ">
                        <div class="row mb-2">
                            <div class="col-md-12 p-0 d-flex flex-column justify-content-center align-content-center">
                                <h3 class=" mb-3 text-center">Yakin Hapus Laporan ini?</h3>
                                <i id="nama_bukti_dukung" class="text-center"></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a class="btn btn-danger hapus-kegiatan">Hapus</a>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <?php if ($list_full_laporan_harian != null) : ?>
        <?php foreach ($list_full_laporan_harian as $list) : ?>
            <?php $laporan = $list['uraian_kegiatan']; ?>
            <?php $data = json_decode($laporan); ?>
            <?php $list_uraian = $data->uraian; ?>
            <?php foreach ($list_uraian as $uraian) : ?>
                <?php $list_uraian_unik[] = $uraian; ?>
            <?php endforeach; ?>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- MODAL TAMBAH KEGIATAN -->
    <?php if ($modal_edit != 'modal-edit') : ?>
        <div class="modal fade" id="modal-tambah">
            <div class="modal-dialog  modal-xl ">
                <form id="form-tambah" action="<?= base_url('/saveLaporanHarian'); ?>" method="post" class="modal-content form-tambah" enctype="multipart/form-data">
                    <input type="text" id="id_kegiatan" name="id_kegiatan" class="d-none">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Laporan Kegiatan</h4>
                        <button id="btn-close-modal-tambah" type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-5 py-3">
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="form-group">
                                    <p>tanggal Kegiatan
                                    </p>
                                    <h2 class="mb-3" id="tanggal-tambah"></h2>
                                    <input type="date" class="form-control d-none" name="tanggal" id="hari-ini" class="form-control">
                                </div>
                            </div>
                        </div>

                        <!-- lama -->
                        <div id="lama">
                            <div class="row rounded position-relative py-2 kegiatan-baru ">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-xl-1 baris-kegiatan">
                                            <div class="row"><strong>NO</strong></div>
                                            <div class="row">1</div>
                                        </div>
                                        <div class="col-xl-11 baris-kegiatan">
                                            <div class="row"><strong>Tipe Kegiatan</strong></div>
                                            <div class="row w-100">
                                                <div class="input-group w-100">
                                                    <select class="form-control w-100 tipe-kegiatan" name="field_tipe[]" required>
                                                        <option value=""> - Pilih Tipe -</option>
                                                        <option value="1">Berdasarkan sasaran kegiatan</option>
                                                        <option value="2">Umum</option>
                                                        <option value="3">Lembur</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 baris-kegiatan pilih-kegiatan d-none">
                                            <div class="row"><strong>Pilih Kegiatan</strong></div>
                                            <div class="row w-100">
                                                <div class="input-group w-100">
                                                    <select class="form-control w-100 pilih-rencana" name="field_rencana[]" required>
                                                        <option class="nilai-nol" value="0">- Pilih Kegiatan -</option>

                                                        <?php if ($list_rencana != null) : ?>
                                                            <?php foreach ($list_rencana as $rencana) : ?>
                                                                <option value="<?= $rencana['id']; ?>"><?= $rencana['rincian_kegiatan']; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3 ">
                                        <div class="col-xl-1 baris-kegiatan">
                                        </div>
                                        <div class="col-xl-4 baris-kegiatan">
                                            <div class="row"><strong>Uraian Kegiatan</strong></div>
                                            <div class="row px-1  w-100">

                                                <div class="form-group w-100 position-relative">
                                                    <textarea id="kegiatan-input" class="form-control  w-100" name="field_uraian[]" rows="3" placeholder="Masukkan Uraian Kegiatan ..." required></textarea>
                                                    <div class="option-kegiatan-wrapper w-100 mt-2 bg-white py-2 rounded shadow-lg position-absolute d-none">
                                                        <?php if ($list_full_laporan_harian != null) : ?>
                                                            <?php foreach (array_unique($list_uraian_unik) as $uraian) : ?>
                                                                <option class="option-kegiatan border-bottom d-none"><?= $uraian; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-1 baris-kegiatan">
                                            <div class="row"><strong>Jumlah</strong></div>
                                            <div class="row px-1  w-100">
                                                <div class="form-group  w-100">
                                                    <input type="number" class="form-control  w-100" name="field_jumlah[]" min="1" value="1" required>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 baris-kegiatan">
                                            <div class="row"><strong>Satuan</strong></div>
                                            <div class="row px-1  w-100">
                                                <div class="input-group  w-100">
                                                    <select class=" form-control  w-100" name="field_satuan[]" required>
                                                        <?php if ($list_satuan != NULL) : ?>
                                                            <?php foreach ($list_satuan as $satuan) : ?>
                                                                <option value="<?= $satuan['nama_satuan']; ?>"><?= $satuan['nama_satuan']; ?></option>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 baris-kegiatan">
                                            <div class="row"><strong>Hasil Kegiatan</strong></div>

                                            <div class="row px-1  w-100">
                                                <div class="form-group  w-100 position-relative">
                                                    <textarea class="form-control  w-100" name="field_hasil[]" rows="3" placeholder="Masukkan Hasil Kegiatan ..." required></textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 baris-kegiatan">
                                            <div class="row"><strong>Waktu Kegiatan</strong></div>
                                            <div class="input-group">
                                                <input class="form-control" disabled required type="time" max="07:30" value="07:30">
                                                <input class="form-control jam_mulai" required type="hidden" name="field_jam_mulai[]" max="07:30" value="07:30">
                                            </div>
                                            <div class="input-group">
                                                <input class="form-control jam_akhir jam_akhir_pertama" required type="time" name="field_jam_selesai[]" value="16:00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row my-3">
                                        <div class="col-1"></div>
                                        <div class="col-xl-11 baris-kegiatan mb-2">
                                            <div class="row"><strong>Bukti Dukung</strong></div>
                                            <div class="row w-100">
                                                <div class="input-group w-100">
                                                    <div class="custom-file w-100 position-relative">
                                                        <input type="file" class="custom-file-input w-100" name="field_bukti1[]" id="formFileMultiple" accept=".png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip, .csv" required multiple />
                                                        <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                        <p class="file-tip d-none">
                                                            <strong class="mt-2 d-flex align-items-center">
                                                                <i class="fas fa-exclamation-circle fa-2x text-yellow mr-2"></i>
                                                                Jenis file :
                                                            </strong> <br>
                                                            .png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip <br><br>
                                                            <strong>
                                                                Ukuran File Maks : 200kb
                                                            </strong>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                        <!-- baru -->
                        <div id="baru">
                        </div>
                        <!-- tombol -->
                        <div class="row ">
                            <div class="col-12 py-3 px-0">
                                <button id="tambah-baris" type="button" class="btn btn-default w-100 font-weight-bold">
                                    <i class="fas fa-plus mr-2"></i>Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between position-relative">
                        <button id="btn-close-modal-tambah2" type="button" class="btn btn-default">Tutup</button>
                        <button id="tombol-simpan" type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <?php endif; ?>


    <?php if ($modal_edit == 'modal-edit') : ?>
        <!-- MODAL EDIT KEGIATAN -->
        <div class="modal fade" id="<?= $modal_edit; ?>" data-keyboard="false" data-backdrop="static">
            <div class=" modal-dialog modal-dialog-scrollable modal-xl">
                <form action="<?= base_url('/updateLaporanHarian'); ?>" method="post" class="modal-content form-edit" enctype="multipart/form-data">
                    <input type="text" id="id_kegiatan" name="id_kegiatan" class="d-none">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit Laporan Kegiatan</h4>
                        <a href="<?= base_url('/listLaporan'); ?>" type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </a>
                    </div>
                    <div class="modal-body px-5 py-3">
                        <div class="row">
                            <div class="col-12 p-0">
                                <div class="form-group">
                                    <p>Tanggal Kegiatan
                                    </p>
                                    <h2 class="mb-3" id="tanggal-edit"></h2>
                                    <?php if ($laporan_harian_tertentu != NULL) : ?>
                                        <input type="hidden" name="laporan_id_edit" value="<?= $laporan_harian_tertentu['id']; ?>">
                                        <input type="date" class="d-none" id="tanggal-kegiatan" name="tanggal" value="<?= $laporan_harian_tertentu['tgl_kegiatan']; ?>" class="form-control">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if ($laporan_harian_tertentu != NULL) : ?>
                            <input type="hidden" name="id_laporan_harian_tertentu" value="<?= $laporan_harian_tertentu['id']; ?>">
                        <?php endif; ?>

                        <div id="lama2">
                            <?php if ($laporan_harian_tertentu != NULL) : ?>
                                <?php $no_edit = 1; ?>
                                <?php $laporan = $laporan_harian_tertentu['uraian_kegiatan']; ?>
                                <?php $data = json_decode($laporan); ?>
                                <?php for ($i = 0; $i < count($list_uraian = $data->uraian); $i++) : ?>
                                    <div class="row mt-4 rounded position-relative pt-2 kegiatan">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-xl-1 baris-kegiatan">
                                                    <div class="row"><strong>NO</strong></div>
                                                    <div class="row"><?= $no_edit++; ?></div>
                                                </div>
                                                <?php $list_tipe = $data->kode_tipe; ?>

                                                <div class="<?= ($list_tipe[$i] != 1) ? 'col-xl-11' : 'col-xl-5' ?>  baris-kegiatan">
                                                    <div class="row"><strong>Tipe Kegiatan</strong></div>
                                                    <div class="row w-100">
                                                        <div class="input-group w-100">
                                                            <select class="form-control w-100 tipe-kegiatan" name="field_tipe[]" required>

                                                                <?php if ($list_tipe[$i] == '1') {
                                                                    echo '<option value="1">Berdasarkan sasaran kegiatan</option>';
                                                                } elseif ($list_tipe[$i] == '2') {
                                                                    echo '<option value="2">Umum</option>';
                                                                } elseif ($list_tipe[$i] == '3') {
                                                                    echo '<option value="3">Lembur</option>';
                                                                } ?>
                                                                <?php if ($list_tipe[$i] == '1') {
                                                                    echo '<option value="2">Umum</option><option value="3">Lembur</option>';
                                                                } elseif ($list_tipe[$i] == '2') {
                                                                    echo '<option value="1">Berdasarkan sasaran kegiatan</option><option value="3">Lembur</option>';
                                                                } elseif ($list_tipe[$i] == '3') {
                                                                    echo '<option value="1">Berdasarkan sasaran kegiatan</option><option value="2">Umum</option>';
                                                                } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $list_rencana2 = $data->kd_rencana; ?>
                                                <div class="col-xl-6 baris-kegiatan pilih-kegiatan <?php if ($list_tipe[$i] != 1) {
                                                                                                        echo 'd-none';
                                                                                                    }  ?>">
                                                    <div class="row"><strong>Pilih Kegiatan</strong></div>
                                                    <div class="row w-100">
                                                        <div class="input-group w-100">
                                                            <select class="form-control w-100 pilih-rencana" name="field_rencana[]" required>
                                                                <option class="nilai-nol" value="0">- Pilih Kegiatan -</option>
                                                                <option value="<?= $list_rencana2[$i]; ?>" <?php if ($list_rencana != null) {
                                                                                                                foreach ($list_rencana as $rencana) {
                                                                                                                    if ($rencana['id'] == $list_rencana2[$i]) {
                                                                                                                        echo 'selected';
                                                                                                                    }
                                                                                                                }
                                                                                                            } ?>><?php if ($list_rencana != null) {
                                                                                                                        foreach ($list_rencana as $rencana) {
                                                                                                                            if ($rencana['id'] == $list_rencana2[$i]) {
                                                                                                                                echo $rencana['rincian_kegiatan'];
                                                                                                                            }
                                                                                                                        }
                                                                                                                    } ?></option>
                                                                <?php if ($list_rencana != null) : ?>
                                                                    <?php foreach ($list_rencana as $rencana) : ?>
                                                                        <?php if ($list_rencana2[$i] != $rencana['id']) : ?>
                                                                            <option value="<?= $rencana['id']; ?>"><?= $rencana['rincian_kegiatan']; ?></option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row my-3 ">
                                                <div class="col-xl-1 baris-kegiatan">
                                                </div>
                                                <div class="col-xl-4 baris-kegiatan">
                                                    <div class="row"><strong>Uraian Kegiatan</strong></div>
                                                    <div class="row px-1 w-100">
                                                        <div class="form-group w-100 position-relative">
                                                            <textarea id="kegiatan-input" class="form-control  w-100" name="field_uraian[]" rows="3" placeholder="Masukkan Uraian Kegiatan ..." required><?= $list_uraian[$i]; ?></textarea>
                                                            <div class="option-kegiatan-wrapper w-100 mt-2 bg-white py-2 rounded shadow-lg position-absolute d-none">
                                                                <?php if ($list_full_laporan_harian != null) : ?>
                                                                    <?php foreach (array_unique($list_uraian_unik) as $uraian) : ?>
                                                                        <option class="option-kegiatan border-bottom d-none"><?= $uraian; ?></option>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-1 baris-kegiatan">
                                                    <?php $list_jumlah = $data->jumlah; ?>
                                                    <div class="row"><strong>Jumlah</strong></div>
                                                    <div class="row px-1 w-100">
                                                        <div class="form-group w-100">
                                                            <input type="number" min="1" class="form-control w-100" name="field_jumlah[]" value="<?= $list_jumlah[$i]; ?>" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 baris-kegiatan">
                                                    <?php $list_satuan2 = $data->satuan; ?>

                                                    <div class="row"><strong>Satuan</strong></div>
                                                    <div class="row px-1 w-100">
                                                        <div class="input-group w-100">
                                                            <select class=" form-control w-100" name="field_satuan[]" required>
                                                                <option value="<?= $list_satuan2[$i] ?>"><?= $list_satuan2[$i] ?></option>
                                                                <?php if ($list_satuan != NULL) : ?>
                                                                    <?php foreach ($list_satuan as $satuan) : ?>
                                                                        <?php if ($satuan['nama_satuan'] != $list_satuan2[$i]) : ?>
                                                                            <option value="<?= $satuan['nama_satuan']; ?>"><?= $satuan['nama_satuan']; ?></option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 baris-kegiatan">
                                                    <?php $list_hasil = $data->hasil; ?>
                                                    <div class="row"><strong>Hasil Kegiatan</strong></div>
                                                    <div class="row px-1 w-100">
                                                        <div class="form-group  w-100 position-relative">
                                                            <textarea class="form-control  w-100" name="field_hasil[]" rows="3" placeholder="Masukkan Hasil Kegiatan ..." required><?= $list_hasil[$i]; ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 baris-kegiatan">
                                                    <?php $jam_mulai = $data->jam_mulai; ?>
                                                    <?php $jam_selesai = $data->jam_selesai ?>
                                                    <div class="row"><strong>Waktu Kegiatan</strong></div>

                                                    <div class="input-group">
                                                        <?php if ($i == 0) : ?>
                                                            <input class="form-control" disabled required type="time" max="07:30" value="<?= $jam_mulai[$i] ?>">
                                                        <?php endif; ?>
                                                        <input class="form-control jam_mulai" required type="<?= ($i == 0) ? 'hidden' : 'time' ?>" name="field_jam_mulai[]" value="<?= $jam_mulai[$i] ?>">
                                                    </div>
                                                    <div class="input-group">
                                                        <input class="form-control jam_akhir" required type="time" name="field_jam_selesai[]" value="<?= $jam_selesai[$i] ?>">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class=" row my-3">
                                                <div class="col-1"></div>
                                                <div class="col-xl-11 baris-kegiatan mb-2">
                                                    <div class="row"><strong>Bukti Dukung</strong></div>
                                                    <?php $list_bukti_dukung = $data->bukti_dukung; ?>
                                                    <div class="row w-100">
                                                        <?php for ($a = 0; $a < count($list_bukti_dukung[$i]); $a++) : ?>
                                                            <div title="<?= $list_bukti_dukung[$i][$a]; ?>" class="file-list w-100">
                                                                <input type="hidden" name="field_bukti_lama<?= $i + 1; ?>[]" value="<?= $list_bukti_dukung[$i][$a]; ?>">
                                                                <span class="w-100 text-truncate p-0"><?= $list_bukti_dukung[$i][$a]; ?></span>
                                                                <?php if (count($list_bukti_dukung[$i]) != 1) : ?>
                                                                    <button class="btn-silang" type="button" id="btn-edit-hapus" data-toggle="modal" data-target="#modal-edit-hapus" data-id_laporan_tertentu="<?= $laporan_harian_tertentu['id']; ?>" data-posisi_array="<?= $i; ?>" data-posisi_dalam_array="<?= $a; ?>" data-nama_bukti_dukung="<?= $list_bukti_dukung[$i][$a]; ?>" data-tanggal_hapus="<?= $laporan_harian_tertentu['tgl_kegiatan']; ?>"><i class="fas fa-times" style="color: #80772d;"></i></button>
                                                                <?php endif; ?>
                                                            </div>
                                                            <?php if (count($list_bukti_dukung[$i]) == 1) : ?>
                                                                <p class="file-tip2 d-none">
                                                                    Untuk Menghapus
                                                                    <br> <br>
                                                                    <strong> <?= $list_bukti_dukung[$i][$a]; ?> </strong>
                                                                    <br> <br>
                                                                    Silahkan Tambah bukti dukung baru
                                                                </p>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                        <div class="input-group w-100">
                                                            <div class="custom-file w-100">
                                                                <div id="resp<?= $i + 1; ?>"></div>
                                                                <input type="file" name="field_bukti<?= $i + 1; ?>[]" class="custom-file-input w-100" id="formFileMultiple" accept=".png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip" multiple />
                                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                                <p class="file-tip d-none">
                                                                    <strong class="mt-2 d-flex align-items-center">
                                                                        <i class="fas fa-exclamation-circle fa-2x text-yellow mr-2"></i>
                                                                        Jenis file :
                                                                    </strong> <br>
                                                                    .png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip, .csv <br><br>
                                                                    <strong>
                                                                        Ukuran File Maks : 200kb
                                                                    </strong>
                                                                </p>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                        </div>

                        <div id="baru2">

                        </div>
                        <!-- tombol -->
                        <div class="row ">
                            <div class="col-12 py-3 px-0">
                                <button id="tambah-baris2" type="button" class="btn btn-default w-100 font-weight-bold">
                                    <i class="fas fa-plus mr-2"></i>Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a href="<?= base_url('/listLaporan'); ?>" type="button" class="btn btn-default">Tutup</a>
                        <button id="tombol-edit" type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Update</button>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <?php endif; ?>



    <!-- MODAL DETAIL -->
    <div class="modal fade" id="<?= $modal_detail; ?>" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <div class="modal-content">
                <div class="modal-header pt-3" style="border: none;">
                    <a href="<?= base_url('/listLaporan'); ?>" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body px-5 py-3">
                    <div class="row mb-2">
                        <div class="col-md-12 p-0">
                            <p>Tanggal Kegiatan
                            </p>
                            <?php if ($laporan_harian_tertentu != NULL) : ?>
                                <h2 class="mb-1" id="tanggal-detail"></h2>
                                <input type="date" id="tanggal-kegiatan-detail" class="d-none" value="<?= $laporan_harian_tertentu['tgl_kegiatan']; ?>">
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NO.</th>
                                        <th>TIPE KEGIATAN</th>
                                        <th>URAIAN</th>
                                        <th>JUMLAH</th>
                                        <th>SATUAN</th>
                                        <th>WAKTU KEGIATAN</th>
                                        <th>HASIL KEGIATAN</th>
                                        <th>BUKTI DUKUNG</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($laporan_harian_tertentu != NULL) : ?>
                                        <input type="hidden" name="id_laporan_harian_tertentu" value="<?= $laporan_harian_tertentu['id']; ?>">
                                        <?php $laporan2 = $laporan_harian_tertentu['uraian_kegiatan']; ?>
                                        <?php $data2 = json_decode($laporan2); ?>

                                        <?php for ($i = 0; $i < count($list_uraian = $data2->uraian); $i++) : ?>
                                            <tr>
                                                <td>
                                                    <?= $i + 1; ?>
                                                </td>
                                                <?php $list_tipe2 = $data2->kode_tipe ?>
                                                <td>
                                                    <div class="p-2 mb-1 rounded-sm card-laporan">
                                                        <?php if ($list_tipe2[$i] == '1') {
                                                            echo 'Berdasarkan sasaran kegiatan';
                                                        } else if ($list_tipe2[$i] == '2') {
                                                            echo 'Umum';
                                                        } else if ($list_tipe2[$i] == '3') {
                                                            echo 'Lembur';
                                                        } elseif ($list_tipe2[$i] == '4') {
                                                            echo 'Cuti';
                                                        }  ?>
                                                    </div>

                                                </td>

                                                <td>
                                                    <?= $list_uraian[$i]; ?>
                                                </td>
                                                <td class="text-center">
                                                    <?php $list_jumlah = $data2->jumlah; ?>
                                                    <?= $list_jumlah[$i]; ?>
                                                </td>
                                                <?php $list_satuan2 = $data2->satuan; ?>
                                                <td> <?php if ($list_satuan != NULL) : ?>
                                                        <?php foreach ($list_satuan as $satuan) : ?>
                                                            <?php if ($satuan['nama_satuan'] == $list_satuan2[$i]) : ?>
                                                                <div class="p-2 mb-1 text-center rounded-sm card-laporan">
                                                                    <?= $satuan['nama_satuan']; ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                </td>
                                                <?php $jam_mulai = $data->jam_mulai; ?>
                                                <?php $jam_selesai = $data->jam_selesai ?>
                                                <td>
                                                    <div class="p-2 mb-1 text-center rounded-sm card-laporan">
                                                        <?= $jam_mulai[$i]; ?> - <?= $jam_selesai[$i]; ?>
                                                    </div>


                                                </td>
                                                <td>
                                                    <?php $list_hasil = $data2->hasil; ?>
                                                    <?= $list_hasil[$i]; ?>
                                                </td>
                                                <td>
                                                    <?php $list_bukti_dukung = $data2->bukti_dukung; ?>
                                                    <?php for ($a = 0; $a < count($list_bukti_dukung[$i]); $a++) : ?>
                                                        <?php if ($list_tipe2[$i] != 4) : ?>
                                                            <div title="<?= $list_bukti_dukung[$i][$a]; ?>" class="file-list">
                                                                <a title="<?= $list_bukti_dukung[$i][$a]; ?>" href="<?= base_url('berkas/' . $folderNIP . '/' . $laporan_harian_tertentu['tgl_kegiatan'] . '/' . $list_bukti_dukung[$i][$a]) ?>"> <?= $list_bukti_dukung[$i][$a]; ?></a>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($list_tipe2[$i] == 4) : ?>
                                                            <?php $fullbukti = explode('_', $list_bukti_dukung[$i][$a]) ?>
                                                            <div title="<?= $list_bukti_dukung[$i][$a]; ?>" class="file-list">
                                                                <a title="<?= $list_bukti_dukung[$i][$a]; ?>" href="<?= base_url('berkas/' . $folderNIP . '/' . $fullbukti[0] . '/' . $list_bukti_dukung[$i][$a]) ?>"> <?= $list_bukti_dukung[$i][$a]; ?></a>
                                                            </div>
                                                            <?php break; ?>
                                                        <?php endif ?>

                                                    <?php endfor; ?>

                                                </td>
                                            </tr>
                                        <?php endfor; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL HAPUS BUKTI DUKUNG -->
    <div class="modal fade" id="modal-edit-hapus" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-md" style="top: 18%;">
            <form action="<?= base_url('/hapusBuktiDukung') ?>" method="POST">
                <div class="modal-content">
                    <div class="modal-header pt-3" style="border: none;">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body px-5 py-3 ">
                        <div class="row mb-2">
                            <div class="col-md-12 p-0 d-flex flex-column justify-content-center align-content-center">
                                <span class="w-100 d-flex justify-content-center align-items-center mb-4">
                                    <i class="fas fa-exclamation-circle fa-7x text-red"></i>
                                </span>
                                <input type="hidden" id="id_laporan_tertentu" name="id_laporan_tertentu">
                                <input type="hidden" name="posisi_array" id="posisi_array">
                                <input type="hidden" name="tanggal_hapus" id="tanggal_hapus">
                                <input type="hidden" name="posisi_dalam_array" id="posisi_dalam_array">
                                <h3 class=" mb-3 text-center" id="">Yakin Hapus Bukti Dukung?</h3>
                                <i id="nama_bukti_dukung" class="text-center"></i>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-center border-0">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CETAK -->
    <div class="modal fade" id="modal-cetak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="<?= base_url('/cetakLaporan'); ?>" method="POST" class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="exampleModalLabel">Cetak Kegiatan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-12 text-center">
                            <h5><strong>Tentukan batas mencetak</strong></h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group text-center col-6">
                            <label>Awal</label>
                            <div class="password">
                                <input type="date" id='tgl_cetak_awal' name="tgl_awal" class="form-control" required>
                            </div>

                        </div>

                        <div class="form-group text-center col-6">
                            <label>Akhir</label>
                            <div class="password">
                                <input type="date" id='tgl_cetak_akhir' name="tgl_akhir" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-secondary" style="border:none;" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary tombol" style="background-color: #3c4b64; border:none;"><i class="fas fa-print mr-2"></i>Cetak</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL CUTI -->
    <div class="modal fade" id="modal-cuti" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <form action="<?= base_url('/inputCuti'); ?>" method="POST" class="modal-content" enctype="multipart/form-data">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="exampleModalLabel">Form Cuti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body px-5 py-3">
                    <div class="row rounded position-relative py-2 kegiatan-baru ">
                        <div class="col-12">
                            <div class="row my-3 ">
                                <div class="col-xl-3 baris-kegiatan">
                                    <div class="row"><strong>Mulai Cuti</strong></div>
                                    <div class="row px-1  w-100">
                                        <div class="form-group w-100 position-relative">
                                            <input type="date" name="tanggal_mulai" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 baris-kegiatan">
                                    <div class="row"><strong>Akhir Cuti</strong></div>
                                    <div class="row px-1  w-100">
                                        <div class="input-group  w-100">
                                            <input type="date" name="tanggal_selesai" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 baris-kegiatan">
                                    <div class="row"><strong>Keterangan Cuti</strong></div>

                                    <div class="row px-1  w-100">
                                        <div class="form-group  w-100 position-relative">
                                            <textarea class="form-control  w-100" name="keterangan" rows="1" placeholder="Masukkan Keterangan Cuti..." required></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row my-3">
                                <div class="col-xl-12 baris-kegiatan mb-2">
                                    <div class="row"><strong>Bukti Dukung Cuti</strong></div>
                                    <div class="row w-100">
                                        <div class="input-group w-100">
                                            <div class="custom-file w-100 position-relative">
                                                <input type="file" class="custom-file-input w-100" name="file_bukti" id="formFileMultiple" accept=".png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip, .csv" required />
                                                <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                <p class="file-tip d-none">
                                                    <strong class="mt-2 d-flex align-items-center">
                                                        <i class="fas fa-exclamation-circle fa-2x text-yellow mr-2"></i>
                                                        Jenis file :
                                                    </strong> <br>
                                                    .png, .jpg, .jpeg, .pdf, .xlsx, .docx, .ppt, .txt, .rar, .zip <br><br>
                                                    <strong>
                                                        Ukuran File Maks : 200kb
                                                    </strong>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4">
                    <button type="button" class="btn btn-secondary" style="border:none;" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
                </div>
            </form>
        </div>
    </div>
<?php endif; ?>


<script src="<?= base_url('/plugins/dropzone/min/dropzone.min.js') ?>"></script>
<script src="<?= base_url('/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<script src="<?= base_url('/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('/plugins/jquery-validation/additional-methods.min.js') ?>"></script>
<script src="<?= base_url('/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('/plugins/toastr/toastr.min.js') ?>"></script>
<script>
    <?php if (session()->getFlashdata('pesan')) { ?>
        Swal.fire({
            title: "<?= session()->getFlashdata('pesan') ?>",
            icon: "<?= session()->getFlashdata('icon') ?>",
            showConfirmButton: true,
        });
    <?php } ?>
</script>
<script>
    <?php if ($list_full_laporan_harian != null) : ?>
        const uraian = [
            <?php foreach (array_unique($list_uraian_unik) as $uraian) : ?> `<?php
                                                                                $uraian = preg_replace("/\r|\n/", " ", $uraian);
                                                                                echo $newUraian = str_replace('"', '', $uraian); ?>`,
            <?php endforeach; ?>
        ]
    <?php else : ?>
        const uraian = '';
    <?php endif; ?>
    <?php if ($list_satuan != NULL) : ?>
        const satuan = [
            <?php foreach ($list_satuan as $satuan) : ?> "<?= $satuan['nama_satuan']; ?>",
            <?php endforeach; ?>
        ]
    <?php else : ?>
        const satuan = '';
    <?php endif; ?>
    <?php if ($list_rencana != NULL) : ?>
        const rencana = [
            <?php foreach ($list_rencana as $rencana) : ?> {
                    "id": "<?= $rencana['id']; ?>",
                    "rincian": "<?= $rencana['rincian_kegiatan']; ?>"
                },
            <?php endforeach; ?>
        ]
    <?php else : ?>
        const rencana = '';
    <?php endif; ?>
    var currentDate = '<?php

                        use CodeIgniter\I18n\Time;

                        $myTime = Time::today('Asia/Jakarta');
                        echo $myTime->toLocalizedString('yyyy-MM-dd');
                        ?>';
</script>
<script src="<?= base_url('/js/append.js') ?>"></script>
<script src="<?= base_url('/js/tanggal.js') ?>"></script>
<script src="<?= base_url('/js/laporan.js') ?>"></script>

<script>
    $(document).ready(function() {
        var pilih = document.getElementsByClassName("pilih-kegiatan");
        var pilihRencana = document.getElementsByClassName("pilih-rencana");
        var nilaiNol = document.getElementsByClassName("nilai-nol");
        $(document).on('change', '.tipe-kegiatan', function() {
            if ($(this).val() == '1' && pilihRencana[$('.tipe-kegiatan').index(this)].childElementCount > 1) {
                nilaiNol[$('.tipe-kegiatan').index(this)].removeAttribute('value')
                pilih[$('.tipe-kegiatan').index(this)].classList.remove('d-none')
                pilihRencana[$('.tipe-kegiatan').index(this)].required = true;
                $(this).parent().parent().parent().removeClass('col-xl-11').addClass('col-xl-5')
            } else if ($(this).val() == '1' && pilihRencana[$('.tipe-kegiatan').index(this)].childElementCount <= 1) {
                Toast.fire({
                    icon: 'warning',
                    title: 'Anda Belum Menginputkan Rencana Kegiatan!',
                });
                $(this).prop('selectedIndex', 0)
            } else {
                pilihRencana[$('.tipe-kegiatan').index(this)].setAttribute('value', '0')
                pilihRencana[$('.tipe-kegiatan').index(this)].value = '0'
                pilih[$('.tipe-kegiatan').index(this)].classList.add('d-none')
                pilihRencana[$('.tipe-kegiatan').index(this)].required = false;
                $(this).parent().parent().parent().addClass('col-xl-11').removeClass('col-xl-5')
            }
        })
    })
</script>

<script>
    $(document).on('click', '#open-modal-hapus', function() {
        $('.hapus-kegiatan').attr('href', $(this).data('link'))
    })

    $(document).ready(function() {
        $('.tgl-hari-ini').html(ubahFormatTanggal(new Date()))
    })

    const d = new Date();
    let day = d.getDay();
    if (day == 5) {
        $('.jam_akhir_pertama').val('16:30');
    } else {
        $('.jam_akhir_pertama').val('16:00');
    }
</script>

<script>
    // Mengambil Data edit dengan menggunakan Jquery
    $(document).on('click', '#btn-edit-hapus', function() {
        $('#id_laporan_tertentu').val($(this).data('id_laporan_tertentu'));
        $('#posisi_array').val($(this).data('posisi_array'));
        $('#posisi_dalam_array').val($(this).data('posisi_dalam_array'));
        $('#tanggal_hapus').val($(this).data('tanggal_hapus'));
        $('#nama_bukti_dukung').text($(this).data('nama_bukti_dukung'));

    })
</script>


<?= $this->endSection(); ?>