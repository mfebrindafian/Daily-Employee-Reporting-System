<?= $this->extend('layout/template'); ?>

<?php if (allowHalaman(session('level_id'), 1)) : ?>

  <?= $this->section('content'); ?>

  <?php if (date('m') == "01") {
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
  ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 fw-bold">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <?php if ($pop_up == 'off') : ?>
      <?php if (session('level_id') == 2) : ?>
        <section class="content">
          <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
              <div class="col-lg-6 col-6 widget" style="cursor: pointer;">
                <!-- small box -->
                <div class="small-box  bg-white" style="border: 1px solid gray; padding: 0;">
                  <div class="inner" style="color: #55415C; padding-left: 15px;">
                    <h3 style="font-size: 70px;"><?= $total_laporan; ?></h3>
                    <?php if (session('level_id') == 2) : ?>
                      <p style="font-weight: bold;">Jumlah Seluruh Laporan</p>
                    <?php endif; ?>

                  </div>
                  <?php if (session('level_id') == 2) : ?>
                    <a href="<?= base_url('/listLaporan'); ?>" class="selanjutnya">
                      <p style="margin:0;">More info</p> <i class="fas fa-arrow-circle-down"></i>
                    </a>
                  <?php else : ?>
                    <a href="" class="selanjutnya">
                      <p style="margin:0;">&nbsp;</p>
                    </a>
                  <?php endif; ?>
                </div>
              </div>
              <!-- ./col -->
              <div class="col-lg-6 col-6 widget" style="cursor: pointer;">
                <!-- small box -->
                <div class="small-box bg-white" style="border: 1px solid gray; padding: 0;">
                  <div class="inner" style="color: #55415C; padding-left: 15px;">

                    <h3 style="font-size: 70px;">
                      <?= $total_kegiatan_bulan_ini; ?>
                    </h3>
                    <p style="font-weight: bold;">Jumlah Kegiatan Bulan <?= $namaBulan; ?></p>
                  </div>
                  <?php if ($pop_up == 'off') : ?>
                    <?php if ($total_kegiatan_bulan_ini != null && session('level_id') == 2) {
                      echo '<a href="#" data-toggle="modal" data-target="#modal-list-laporan" class="selanjutnya">
                <p style="margin:0;">More info</p> <i class="fas fa-arrow-circle-down"></i>
              </a>';
                    } else {
                      echo
                      '<a href="#" class="selanjutnya">
                <p style="margin:0;">&nbsp;</p>
              </a>';
                    } ?>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <!-- /.row -->
          </div>
        </section>
      <?php endif; ?>
    <?php endif; ?>


    <!-- CALENDAR -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-7">
            <div class="row <?= $div_card; ?>">
              <div class="col-md-12">
                <div class="card p-3">
                  <div class="row">
                    <div class="col-12">
                      <small>Menampilkan Kegiatan Milik</small>
                    </div>
                  </div>
                  <div class="row">
                    <?php if ($user_dipilih != null) : ?>
                      <div class="col-2 text-center">
                        <img style="width: 100%; max-width: 100px;" class="mr-3" src="<?= base_url('/images/profil/' . $user_dipilih['image']) ?>" alt="">
                      </div>
                      <div class="col-6 d-flex flex-column">
                        <strong class=" mt-2"><?= $user_dipilih['nama_pegawai']; ?></strong>
                        <small><?= $user_dipilih['nip_baru'] ?></small>
                        <small><?= $user_dipilih['email'] ?></small>
                        <div class="d-flex">
                          <?php if ($pop_up == 'off') : ?>
                            <?php if ($list_golongan != null) : ?>
                              <?php foreach ($list_golongan as $golongan) : ?>
                                <?php if ($golongan['id'] == $user_dipilih['gol_kd']) : ?>
                                  <span class="badge badge-secondary py-1"><?= $golongan['golongan'] ?></span>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            <?php endif; ?>
                            <?php if ($list_fungsional != null) : ?>
                              <?php foreach ($list_fungsional as $fungsional) : ?>
                                <?php if ($fungsional['id'] == $user_dipilih['fungsional_kd']) : ?>
                                  <span class="ml-2 badge badge-secondary py-1"><?= $fungsional['jabatan_fungsional'] ?></span>
                                <?php endif; ?>
                              <?php endforeach; ?>
                            <?php endif; ?>
                          <?php endif; ?>
                        </div>
                      </div>

                      <div class="col-4 d-flex justify-content-end align-items-end">
                        <a href="#" class="btn btn-sm btn-outline-primary">Rincian Kegiatan</a>
                      </div>
                    <?php endif; ?>
                  </div>
                  <?php if ($user_dipilih == null) : ?>
                    <strong>Pegawai Belum Memiliki Akun</strong>
                  <?php endif; ?>
                </div>
              </div>
            </div>
            <?php if ($user_dipilih == null && session('level_id') != 1) : ?>
              <div class="row">
                <div class="col-12 ">
                  <div class="alert alert-success alert-dismissible fade show" role="alert" style="background-color: #eaffe0; color: #0e4d2d;">
                    <i style="color: #0e4d2d;" class="fas fa-check-circle mr-3"></i> Menampilkan data kegiatan pribadi pada kalender
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <?php if ($user_dipilih != null) : ?>
              <div class="row mb-3">
                <div class="col-12 ">
                  <button class="btn btn-primary" data-toggle="modal" data-target="#modal-cetak">Download Rekap <?= $user_dipilih['nama_pegawai']; ?></button>
                </div>
              </div>
            <?php endif; ?>
            <div class="row">
              <div class="col-md-12 position-relative">
                <div class="card">
                  <div class="notesa d-none">
                    <div class="drop d-none">
                    </div>
                  </div>
                  <!-- THE CALENDAR -->
                  <div id="calendar"></div>
                </div>
              </div>
            </div>
          </div>
          <!-- DIUBAH MENGGUNAKAN HELPERRRRRR -->
          <?php  ?>
          <div class="col-md-5">
            <div class="row mb-3">
              <!-- GANTIII JADII SATU -->
              <?php if (allowChart(session('level_id'), 1)) : ?>
                <div class="col-12 ">
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <h5 class="mb-3"><strong>Catatan Saya</strong></h5>
                          <button class="btn btn-sm btn-primary shadow hari-ini">Hari ini</button>
                          <button class="btn btn-sm ml-3 akan-datang">Akan Datang</button>
                          <button class="btn btn-sm ml-3 sebelumnya">Sebelumnya</button>
                          <div class="mt-3 w-100 catatan-container-hari-ini px-1 d-flex flex-column align-items-center">
                          </div>
                          <div class="mt-3 w-100 catatan-container-akan-datang  px-1 d-none flex-column align-items-center ">
                          </div>
                          <div class="mt-3 w-100 catatan-container-sebelumnya d-none px-1 flex-column align-items-center">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body">
                          <div class="row">
                            <div class="col-8">
                              <h5 class="mb-3"><strong>Catatan diterima dan terkirim</strong></h5>
                            </div>
                            <div class="col-4">
                              <a class="float-right" href="<?= base_url('detailCatatan') ?>">Detail</a>
                            </div>
                          </div>
                          <button class="position-relative btn btn-sm btn-primary diterima shadow">
                            Diterima
                            <span class="pulse"></span>
                          </button>
                          <button class="btn btn-sm terkirim ml-3">Terkirim</button>
                          <div class="mt-3 w-100 catatan-container-diterima px-1 d-flex flex-column align-items-center">
                          </div>
                          <div class="mt-3 w-100 catatan-container-terkirim  px-1 d-none flex-column align-items-center ">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              <?php endif; ?>
            </div>
            <?php if ($user_dipilih == null && session('level_id') != 1) : ?>
              <div class="row">
                <div class="col-12 ">
                  <div class="alert alert-warning alert-dismissible fade show" role="alert" style="background-color: #ffe8a8; color: #664b00;">
                    <i style="color: #8f6c0d;" class="fas fa-info-circle mr-3"></i> Silahkan pilih untuk menampilkan kegiatan pegawai lain pada kalender
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                </div>
              </div>
            <?php endif; ?>
            <?php if (session('level_id') != 1) : ?>
              <div class="card">
                <div class="row">
                  <div class="col-8 pt-3 pl-4">
                    <h5 class="mb-3"><strong>Daftar Pegawai</strong></h5>
                  </div>
                  <div class="col-6">
                    <div class="input-group input-group-md pt-3 px-4" style="width: 250px">
                      <input type="search" id="pencarian4" name="table_search" class="form-control float-right" placeholder="Search ..." />
                    </div>
                  </div>
                  <div class="col-6">
                    <button class="btn btn-primary float-right mt-3 mx-4" data-toggle="modal" data-target="#modal-cetak-bidang">Download Rekap</button>
                  </div>
                </div>
                <!-- /.card-header -->
                <form action="<?= base_url('/showDataUser') ?>" method="POST" class="card-body table-responsive pb-0 px-0">
                  <table class="table table-hover text-nowrap" id="tabelData4">
                    <thead>
                      <tr>
                        <th class="text-center">NO.</th>
                        <th>NAMA</th>
                        <th>BULAN INI</th>
                        <th>MINGGU INI</th>
                        <th>AKSI</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no_ke = 1; ?>
                      <?php if ($pop_up == 'off' || $pop_up == 'on-2') : ?>
                        <?php if ($list_pegawai != null) : ?>
                          <?php foreach ($list_pegawai as $pegawai) : ?>
                            <tr>
                              <td class="text-center"><?= $no_ke; ?></td>
                              <td><?= $pegawai['nama_pegawai']; ?></td>
                              <td class="text-center">
                                <?= $jml_perbulan_pegawai[($no_ke - 1)]; ?>
                              </td>

                              <td class="text-center"> <?= $jml_perminggu_pegawai[($no_ke - 1)]; ?></td>
                              <?php $no_ke++ ?>
                              <td>

                                <a href="<?= base_url('/showKegiatanPegawai/' . $pegawai['nip_lama']); ?>" class="btn btn-info btn-xs tombol" style="background-color: #2D95C9; border:none;"><i class="fas fa-search-plus"></i></a>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </form>
              </div>
          </div>
        </div>
        <?php  ?>
        <!-- CHART -->
      </div>
    <?php endif; ?>

    <!-- MODAL CETAK -->
    <div class="modal fade" id="modal-cetak" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="<?= base_url('/cetakLaporanByPimpinan'); ?>" method="POST" class="modal-content">
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
            <?php if ($user_dipilih != null) : ?>
              <input type="hidden" name="nip_lama_dipilih" value="<?= $user_dipilih['nip_lama']; ?>">
            <?php endif; ?>
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


    <!-- MODAL CETAK BIDANG-->
    <div class="modal fade" id="modal-cetak-bidang" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <form action="<?= base_url('/cetakLaporanByBidang'); ?>" method="POST" class="modal-content">
          <div class="modal-header border-0">
            <h5 class="modal-title" id="exampleModalLabel">Cetak Kegiatan Bidang atau Satker</h5>
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
            <div class="row mb-3">
              <div class="col-12">
                <div class="input-group satkers w-100">
                  <label for="">Satker</label>
                  <select class=" form-control  w-100 mb-3" name="satker">
                    <option value="all">- Semua -</option>
                    <?php if ($pop_up == 'off') : ?>
                      <?php if ($list_satker != NULL) : ?>
                        <?php foreach ($list_satker as $satker) : ?>
                          <option value="<?= $satker['kd_satker']; ?>"><?= $satker['satker']; ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    <?php endif; ?>
                  </select>
                </div>
                <div class="input-group bidangs w-100">
                  <label for="">Bidang</label>
                  <select class=" form-control  w-100" name="bidang">
                    <option value="all">- Semua -</option>
                    <?php if ($pop_up == 'off') : ?>
                      <?php if ($list_bidang != NULL) : ?>
                        <?php foreach ($list_bidang as $bidang) : ?>
                          <option value="<?= $bidang['kd_es3']; ?>"><?= $bidang['deskripsi']; ?></option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    <?php endif; ?>
                  </select>
                </div>
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


    <!-- MODAL KEGIATAN -->
    <?php if (session('level_id') == 2) : ?>
      <div class="modal fade" id="modal-list-laporan">
        <div class="modal-dialog modal-dialog-scrollable modal-xl ">
          <div class="modal-content" enctype="multipart/form-data">
            <input type="text" id="id_kegiatan" name="id_kegiatan" class="d-none">
            <div class="modal-header">
              <h4 class="modal-title">Kegiatan Bulan <?php if ($namaBulan != null) {
                                                        echo $namaBulan;
                                                      } else {
                                                        echo '';
                                                      }; ?></h4>
              <button id="btn-close-modal-tambah" type="button" class="close" aria-label="Close" data-dismiss="modal">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="get">
              <div class="input-group input-group-md float-right mr-5 mt-3" style="width: 450px">
                <input type="text" name="keyword" class="form-control float-right auto_search" placeholder="Search" onkeypress="return event.keyCode != 13" />
                <div class="input-group-append">
                  <button type="button" class="btn btn-default " id="btn-search">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </div>
            </form>
            <div class="modal-body px-5 py-3">
              <div class="row">
                <div class="col-md-12">
                  <table class="table table-hover" id="tabelData">
                    <thead>
                      <tr>
                        <th>NO.</th>
                        <th>TANGGAL</th>
                        <th>URAIAN</th>
                        <th>JUMLAH</th>
                        <th>SATUAN</th>
                        <th>BUKTI DUKUNG</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $no = 1; ?>
                      <?php if ($pop_up == 'off') : ?>
                        <?php if ($laporan_bulan_ini != null) : ?>
                          <?php foreach ($laporan_bulan_ini as $list) : ?>
                            <tr>
                              <td><?= $no++; ?></td>
                              <td id="tgl-kegiatan-tabel"><?= $list['tgl_kegiatan']; ?></td>
                              <?php $laporan = $list['uraian_kegiatan']; ?>
                              <?php $data = json_decode($laporan); ?>
                              <?php $list_uraian = $data->uraian; ?>
                              <td>
                                <?php foreach ($list_uraian as $uraian) : ?>
                                  <div class="p-2 mb-1 rounded-sm card-laporan">
                                    <?= $uraian; ?>
                                  </div>
                                <?php endforeach; ?>
                              </td>
                              <?php $list_jumlah = $data->jumlah; ?>
                              <td>
                                <?php foreach ($list_jumlah as $jumlah) : ?>
                                  <div class="p-2 mb-1 text-center rounded-sm card-laporan">
                                    <?= $jumlah; ?>
                                  </div>
                                <?php endforeach; ?>
                              </td>
                              <?php $list_satuan2 = $data->satuan; ?>
                              <td>
                                <?php foreach ($list_satuan2 as $satuan) : ?>
                                  <div class="p-2 mb-1 text-center rounded-sm card-laporan">
                                    <?= $satuan; ?>
                                  </div>
                                <?php endforeach; ?>
                              </td>
                              <?php $list_bukti_dukung = $data->bukti_dukung; ?>
                              <td>
                                <?php $data_user = session('data_user'); ?>
                                <?php $folderNIP = $data_user['nip_lama_user'];  ?>
                                <?php foreach ($list_bukti_dukung as $bukti_dukung) : ?>
                                  <div class="p-2 mb-1 rounded-sm card-bukti-laporan">
                                    <?php foreach ($bukti_dukung as $b) : ?>
                                      <a title="<?= $b; ?>" target="_blank" href="<?= base_url('berkas/' . $folderNIP . '/' . $list['tgl_kegiatan'] . '/' . $b) ?>"> <?= $b; ?></a>
                                    <?php endforeach; ?>
                                  </div>
                                <?php endforeach; ?>
                              </td>
                            </tr>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
    <?php endif; ?>

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
    <?php if (session('level_id') == 2  && $akses_tambah == 'active') : ?>
      <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog modal-xl ">
          <form action="<?= base_url('/saveLaporanHarian'); ?>" method="post" class="modal-content form-tambah" enctype="multipart/form-data">
            <input type="text" id="id_kegiatan" name="id_kegiatan" class="d-none">
            <div class="modal-header">
              <h4 class="modal-title">Tambah Laporan Kegiatan</h4>
              <button id="btn-close-modal-tambah" type="button" class="close" data-dismiss="modal" aria-label="Close">
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
                              <option value="1">Berdasarkan Rencana</option>
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
                              <option value="0">- Pilih Kegiatan -</option>

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
                        <div class="row"><strong>Waktu</strong></div>
                        <div class="input-group">
                          <input class="form-control satuan-waktu" required type="number" name="field_jam[]" value="0">
                          <span class="px-2"> : </span>
                          <input class="form-control satuan-waktu" required type="number" name="field_menit[]" value="0">
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
            <div class="modal-footer justify-content-between">
              <button data-dismiss="modal" type="button" class="btn btn-default">Tutup</button>
              <button id="tombol-simpan" type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    <?php endif; ?>

    <!-- MODAL DETAIL -->
    <div class="modal fade" id="<?= $modal_detail; ?>" data-keyboard="false" data-backdrop="static">
      <div class="modal-dialog modal-dialog-scrollable modal-xl">
        <div class="modal-content">
          <div class="modal-header pt-3" style="border: none;">
            <?php if ($laporan_harian_tertentu != NULL) : ?>
              <?php if ($laporan_harian_tertentu['user_id'] == session('user_id')) : ?>
                <a href="<?= base_url('/dashboard'); ?>" type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </a>
              <?php endif; ?>
            <?php endif; ?>

            <?php if ($laporan_harian_tertentu != NULL) : ?>
              <?php if ($laporan_harian_tertentu['user_id'] != session('user_id')) : ?>
                <a href="<?= base_url('/showKegiatanPegawai/' . $nip_lama_pegawai_terpilih); ?>" type="button" class="close" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <div class="modal-body px-5 py-3">
            <div class="row mb-2">
              <div class="col-md-12 p-0">
                <p>Tanggal Kegiatan
                </p>
                <?php if ($laporan_harian_tertentu != NULL) : ?>
                  <h1 id="tanggal-detail"></h1>
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
                      <th>URAIAN</th>
                      <th>JUMLAH</th>
                      <th>SATUAN</th>
                      <th>HASIL KEGIATAN</th>
                      <?php if ($laporan_harian_tertentu != NULL) : ?>
                        <?php if ($laporan_harian_tertentu['user_id'] == session('user_id') || session('jabatan') == 'koordinator' && session('es3_kd') == 0 || session('jabatan') == 'koordinator' && $user_dipilih['es3_kd'] == session('es3_kd')) : ?>
                          <th>BUKTI DUKUNG</th>
                        <?php endif; ?>
                      <?php endif; ?>

                    </tr>
                  </thead>
                  <tbody>
                    <?php if ($laporan_harian_tertentu != NULL) : ?>
                      <input type="hidden" name="id_laporan_harian_tertentu" value="<?= $laporan_harian_tertentu['id']; ?>">
                      <?php $laporan = $laporan_harian_tertentu['uraian_kegiatan']; ?>
                      <?php $data = json_decode($laporan); ?>
                      <?php for ($i = 0; $i < count($list_uraian = $data->uraian); $i++) : ?>
                        <tr>
                          <td>
                            <?= $i + 1; ?>
                          </td>
                          <td>
                            <?= $list_uraian[$i]; ?>
                          </td>
                          <td class="text-center">
                            <?php $list_jumlah = $data->jumlah; ?>
                            <?= $list_jumlah[$i]; ?>
                          </td>
                          <?php $list_satuan2 = $data->satuan; ?>
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
                          <td>
                            <?php $list_hasil = $data->hasil; ?>
                            <?= $list_hasil[$i]; ?>
                          </td>
                          <?php $data_user = session('data_user'); ?>
                          <?php $folderNIP = $data_user['nip_lama_user'];  ?>
                          <?php if ($laporan_harian_tertentu != NULL) : ?>
                            <?php if ($laporan_harian_tertentu['user_id'] == session('user_id') || session('jabatan') == 'koordinator' && session('es3_kd') == 0  || session('jabatan') == 'koordinator' && $user_dipilih['es3_kd'] == session('es3_kd')) : ?>
                              <td>
                                <?php $list_bukti_dukung = $data->bukti_dukung; ?>
                                <?php for ($a = 0; $a < count($list_bukti_dukung[$i]); $a++) : ?>
                                  <div title="<?= $list_bukti_dukung[$i][$a]; ?>" class="file-list">
                                    <a target="_blank" title="<?= $list_bukti_dukung[$i][$a]; ?>" href="<?= base_url('berkas/' . $user_dipilih['nip_lama'] . '/' . $laporan_harian_tertentu['tgl_kegiatan'] . '/' . $list_bukti_dukung[$i][$a]) ?>"> <?= $list_bukti_dukung[$i][$a]; ?></a>
                                  </div>
                                <?php endfor; ?>

                              </td>
                            <?php endif; ?>
                          <?php endif; ?>

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



    <script src="<?= base_url('/plugins/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/fullcalendar/main.js') ?>"></script>
    <script src="<?= base_url('/dist/js/pages/dashboard3.js') ?>"></script>
    <script src="<?= base_url('/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/toastr/toastr.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/summernote/summernote-bs4.min.js') ?>"></script>
    <script src="<?= base_url('/js/tanggal.js') ?>"></script>
    <script src="<?= base_url('/js/jquery-ui.min.js') ?>"></script>
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
      var myId = '<?= session('user_id') ?>';
      var check = <?= $events; ?>


      var pegawai = <?= $pegawai_json ?>;
      let noted = <?= $catatan; ?>;
      const start = new Date("<?= $tanggal_mulai; ?>");

      <?php if ($list_full_laporan_harian != null) : ?>
        const uraian = [
          <?php foreach (array_unique($list_uraian_unik) as $uraian) : ?> `<?php
                                                                            $uraian = preg_replace("/\r|\n/", " ", $uraian);
                                                                            echo $newUraian = str_replace('"', '', $uraian); ?>`,
          <?php endforeach; ?>
        ]
      <?php endif; ?>
      <?php if ($list_satuan != NULL) : ?>
        const satuan = [
          <?php foreach ($list_satuan as $satuan) : ?> "<?= $satuan['nama_satuan']; ?>",
          <?php endforeach; ?>
        ]
      <?php endif; ?>
      <?php if ($list_rencana != NULL) : ?>
        const rencana = [
          <?php foreach ($list_rencana as $rencana) : ?> "<?= $rencana['rincian_kegiatan']; ?>",
          <?php endforeach; ?>
        ]
      <?php endif; ?>
      const base_url = '<?= base_url() ?>'
    </script>
    <script src="<?= base_url('/js/index.js') ?>"></script>
    <script src="<?= base_url('/js/append.js') ?>"></script>

    <script>
      $(function() {
        bsCustomFileInput.init();
      });
    </script>

    <?php if (session('level_id') == 2) : ?>
      <script type="text/javascript">
        $('#tabelData').DataTable({
          "paging": false,
          "lengthChange": false,
          "searching": true,
          "responsive": true,
          'ordering': false,
          "info": false,
          "autoWidth": false,
        })

        function filterData() {
          $('#tabelData').DataTable().search(
            $('.auto_search').val()
          ).draw();
        }
        $('.auto_search').on('keyup', function() {
          filterData();
        });

        $(document).ready(function() {

          $('#tabelData_wrapper').children().first().addClass('d-none')
        })
      </script>
    <?php endif; ?>

    <script>
      $(document).ready(function() {
        appendIconKalender();
        appendIconKalenderUncheck();
        <?php if (session('level_id') == 2  && $akses_tambah == 'active') : ?>
          catatan();
          tips();
        <?php endif; ?>
        hariLibur(new Date().getFullYear());
        //
        $('.fc-prev-button').click(function() {
          let tgl = $('.fc-toolbar-title').text().split(' ')
          hapusAppend();
          appendIconKalender();
          appendIconKalenderUncheck();
          <?php if (session('level_id') == 2  && $akses_tambah == 'active') : ?>
            catatan();
          <?php endif; ?>
          hariLibur(tgl[1]);
        });
        $('.fc-next-button').click(function() {
          let tgl = $('.fc-toolbar-title').text().split(' ')
          hapusAppend();
          appendIconKalender();
          appendIconKalenderUncheck();
          <?php if (session('level_id') == 2  && $akses_tambah == 'active') : ?>
            catatan();
          <?php endif; ?>
          hariLibur(tgl[1]);
        });
        $('.fc-today-button').click(function() {
          let tgl = $('.fc-toolbar-title').text().split(' ')
          hapusAppend();
          appendIconKalender();
          appendIconKalenderUncheck();
          <?php if (session('level_id') == 2  && $akses_tambah == 'active') : ?>
            catatan();
          <?php endif; ?>
          hariLibur(tgl[1]);
        });
      });
    </script>

    <script>
      $(document).ready(function() {
        var pilih = document.getElementsByClassName("pilih-kegiatan");
        var pilihRencana = document.getElementsByClassName("pilih-rencana");
        $(document).on('change', '.tipe-kegiatan', function() {
          if ($(this).val() == '1') {
            pilih[$('.tipe-kegiatan').index(this)].classList.remove('d-none')
            $(this).parent().parent().parent().removeClass('col-xl-11').addClass('col-xl-5')
          } else {
            pilihRencana[$('.tipe-kegiatan').index(this)].value = '0'
            pilih[$('.tipe-kegiatan').index(this)].classList.add('d-none')
            $(this).parent().parent().parent().addClass('col-xl-11').removeClass('col-xl-5')
          }
        })
      })
    </script>
    <?= $this->endSection(); ?>
  <?php endif; ?>