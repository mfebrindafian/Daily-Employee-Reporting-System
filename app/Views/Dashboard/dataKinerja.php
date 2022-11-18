<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url('/plugins/daterangepicker/daterangepicker.css') ?>">
<link rel="stylesheet" href="<?= base_url('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') ?>">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Data Kinerja</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Daftar Data Kinerja</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-9"></div>
                <div class="col-3">
                    <div class="form-group">

                        <form action="" method="GET" class="input-group rounded">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control rounded-right" id="rentang" name="date_range" />
                            <a href="<?= base_url('/kinerjaPegawai') ?>" class="bek"><i class="fas fa-times"></i></a>
                            <button type="submit" class="btn btn-danger d-none sumbrit">X</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <h4>Daftar Data Kinerja Pegawai</h4>
                        </div>
                        <div class="col-6 justify-content-end d-flex align-items-center">
                            <span class="text-right">
                                Periode : <span class="text-bold p-2 bg-info rounded ml-2 mr-1"><?= $data['periode_awal']; ?> - <?= $data['periode_akhir']; ?></span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-6 rounded-lg" style="cursor: pointer;">
                    <div class="small-box bg-white rincian-2">
                        <div class="row px-1 mb-1">
                            <div class="col-12 py-2 text-center text-truncate">
                                <span class="text-white">
                                    <strong class="nama-bidang">Bagian Umum</strong>
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-1">
                            <div class="col-6 py-2 text-center text-truncate ">
                                <span class="text-white">
                                    Rata-rata jam kerja bidang
                                </span>
                            </div>
                            <div class="col-6 py-2 text-center text-truncate ">
                                <span class="text-white">
                                    Rata-rata kegiatan bidang perhari
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-3">
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 counter text-white rata-jam-bidang"><?= $data['rata_rata_jam_bidang']; ?></h3> <span class="ml-1 text-white">Jam</span>
                                <h3 class="my-2 counter text-white rata-menit-bidang ml-2"><?= $data['rata_rata_menit_bidang']; ?></h3> <span class="ml-1 text-white">Menit</span>
                            </div>
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 counter text-white kegiatan-bidang"><?= $data['jumlah_kegiatan_bidang']; ?></h3>
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
                                        <th>NAMA PEGAWAI</th>
                                        <th>SASARAN BELUM DITINDAKLANJUTI</th>
                                        <th>SASARAN SEDANG DITINDAKLANJUTI</th>
                                        <th>SASARAN SELESAI DITINDAKLANJUTI</th>
                                        <th>RATA-RATA JAM KERJA HARIAN</th>
                                        <th>JUMLAH JAM TIDAK TERLAKSANA</th>
                                        <th>LAPORAN DIINPUT</th>
                                        <th>RATA-RATA KEGIATAN PERHARI</th>
                                        <th>JUMLAH LEMBUR</th>
                                        <th>TOTAL DURASI LEMBUR</th>
                                        <th>JUMLAH CUTI</th>
                                        <th>AKSI</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php if ($list_pegawai != null) : ?>
                                        <?php $ke = 0; ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($list_pegawai as $list) : ?>
                                            <tr>
                                                <td><?= $no++; ?> </td>
                                                <td><?= $list['nama_pegawai']; ?></td>
                                                <td><?= $data[$ke]['rincian']['B']; ?></td>
                                                <td><?= $data[$ke]['rincian']['T']; ?></td>
                                                <td><?= $data[$ke]['rincian']['S']; ?></td>
                                                <td><?= $data[$ke]['rata_rata_jam']; ?> Jam <?= $data[$ke]['rata_rata_menit']; ?> Menit</td>
                                                <td><?= $data[$ke]['jumlah_jam_kerja_terbuang']; ?> Jam <?= $data[$ke]['jumlah_menit_kerja_terbuang']; ?> Menit</td>
                                                <td><?= $data[$ke]['total_hari_kerja_telah_input']; ?></td>
                                                <td><?= $data[$ke]['rata_rata_kegiatan_pribadi']; ?></td>
                                                <td><?= $data[$ke]['jumlah_kegiatan_lembur']; ?></td>
                                                <td><?= $data[$ke]['jumlah_jam_lembur']; ?> Jam <?= $data[$ke]['jumlah_menit_lembur']; ?> Menit</td>
                                                <td><?= $data[$ke]['jumlah_cuti']; ?></td>
                                                <td>

                                                    <button class="btn btn-sm btn-primary" data-link="<?= base_url('#'); ?>"> <span>Detail</span></button>
                                                </td>
                                            </tr>

                                            <?php $ke++ ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>

                                    <?php if ($list_pegawai2 != null) : ?>
                                        <?php foreach ($list_pegawai2 as $list2) : ?>
                                            <td><?= $no++; ?></td>
                                            <td><?= $list2['nama_pegawai']; ?></td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td>-</td>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <hr>

            <?php if (session('es_kd') != '0' && $data_kegiatan != null) :  ?>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <h4>Daftar Sasaran perlu diverifikasi</h4>
                            </div>
                            <div class="col-6 justify-content-end d-flex align-items-center">
                                <span class="text-right">
                                    Periode : <span class="text-bold p-2 bg-info rounded ml-2 mr-1"><?= $data['periode_awal']; ?> - <?= $data['periode_akhir']; ?></span>
                                </span>
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
                                            <th>NAMA PEGAWAI</th>
                                            <th>SASARAN KEGIATAN</th>
                                            <th>AKSI</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no_keg = 1 ?>
                                        <?php $no2 = 0 ?>
                                        <?php foreach ($data_kegiatan as $keg) : ?>
                                            <tr>
                                                <td><?= $no_keg++; ?></td>
                                                <td><?= $keg[$no2]['nama_pegawai']; ?></td>
                                                <td><?= $keg[$no2]['rincian_kegiatan']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('/detailRencanaKegiatan/' . $keg[$no2]['id'] . '/' . $keg[$no2]['nip_lama']) ?>" type="button" id="btn-detail" class="btn btn-sm btn-primary">
                                                        <span>Detail</span>
                                                    </a>
                                                    <a href="<?= base_url('/verifikasiKegiatan/' . $keg[$no2]['id']) ?>" type="button" id="btn-detail" class="btn btn-sm btn-info">
                                                        <span>verif</span>
                                                    </a>
                                                </td>

                                            </tr>
                                            <?php $no2++ ?>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
</div>





<script src="<?= base_url('/plugins/moment/moment.min.js') ?>"></script>
<script src="<?= base_url('/plugins/daterangepicker/daterangepicker.js') ?>"></script>
<script src="<?= base_url('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') ?>"></script>

<script>
    $("#rentang").daterangepicker({
        startDate: moment().startOf('year'),
        endDate: moment(),
    });

    $('#rentang').on('change', function() {
        $('.sumbrit').click()
    })
</script>
<?= $this->endSection(); ?>