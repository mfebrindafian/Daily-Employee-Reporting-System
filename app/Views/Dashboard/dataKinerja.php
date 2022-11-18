<?= $this->extend('layout/template'); ?>


<?= $this->section('content'); ?>



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
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <span style="font-size:30px;"><span class="tgl-hari-ini"></span></span>
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

                                <tbody>
                                    <tr>


                                    </tr>
                                </tbody>
                            </table>
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
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>


                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>





<script src="<?= base_url('/plugins/dropzone/min/dropzone.min.js') ?>"></script>
<script src="<?= base_url('/plugins/bs-custom-file-input/bs-custom-file-input.min.js') ?>"></script>
<script src="<?= base_url('/plugins/jquery-validation/jquery.validate.min.js') ?>"></script>
<script src="<?= base_url('/plugins/jquery-validation/additional-methods.min.js') ?>"></script>
<script src="<?= base_url('/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('/plugins/toastr/toastr.min.js') ?>"></script>

<?= $this->endSection(); ?>