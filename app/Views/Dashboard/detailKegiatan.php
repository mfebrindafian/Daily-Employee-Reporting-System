<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Kegiatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/rincianKegiatanPegawai') ?>">Rincian Kegiatan</a></li>
                        <li class="breadcrumb-item active">Detail Kegiatan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="rencana">
                                <div class="row">
                                    <div class="col-4">
                                        <h5>Rencana Kegiatan</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">

                                        <table class="table table-hover mt-2">
                                            <thead>
                                                <tr>
                                                    <th>Kegiatan</th>
                                                    <th>Status</th>
                                                    <th>Verifikasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if ($data_kegiatan != null) : ?>
                                                    <tr>
                                                        <td><?= $data_kegiatan['rincian_kegiatan']; ?></td>
                                                        <td><?php if ($data_kegiatan['status_rincian'] == 'B') {
                                                                echo 'Belum ditindaklanjuti';
                                                            } elseif ($data_kegiatan['status_rincian'] == 'T') {
                                                                echo 'Sedang ditindaklanjuti';
                                                            } else {
                                                                echo 'Selesai ditindaklanjuti';
                                                            } ?></td>
                                                        <td><?php if ($data_kegiatan['status_verifikasi'] == 'B') {
                                                                echo 'Belum diverifikasi';
                                                            } else {
                                                                echo 'sudah diverifikasi';
                                                            } ?></td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="rangkaian">
                                <div class="row">
                                    <div class="col-4">
                                        <h5>Rangkaian Pelaksanaan Kegiatan</h4>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">

                                        <table class="table table-hover mt-2">
                                            <thead>
                                                <tr>
                                                    <th>No.</th>
                                                    <th>Tanggal Kegiatan</th>
                                                    <th>Uraian</th>
                                                    <th>Jumlah</th>
                                                    <th>Satuan</th>
                                                    <th>Waktu Kegiatan</th>
                                                    <th>Hasil</th>
                                                    <th>Bukti Dukung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $ke = 1; ?>
                                                <?php if ($list_kegiatan != null) : ?>
                                                    <?php foreach ($list_kegiatan as $list) : ?>
                                                        <tr>
                                                            <td><?= $ke++; ?></td>
                                                            <td id="tgl-kegiatan-tabel">
                                                                <?= $list['tgl_kegiatan']; ?>
                                                            </td>
                                                            <td><?= $list['uraian']; ?></td>
                                                            <td><?= $list['jumlah']; ?></td>
                                                            <td><?= $list['satuan']; ?></td>
                                                            <td><?= $list['jam_mulai']; ?> - <?= $list['jam_selesai']; ?></td>
                                                            <td><?= $list['hasil']; ?></td>

                                                            <td>
                                                                <?php $data_user = session('data_user'); ?>
                                                                <?php $folderNIP = $data_user['nip_lama_user'];  ?>
                                                                <?php foreach ($list['bukti_dukung'] as $b) : ?>
                                                                    <div class="p-2 mb-1 rounded-sm card-bukti-laporan">
                                                                        <a title="<?= $b; ?>" target="_blank" href="<?= base_url('berkas/' . $folderNIP . '/' . $list['tgl_kegiatan'] . '/' . $b) ?>"> <?= $b; ?></a>
                                                                    </div>
                                                                <?php endforeach; ?>
                                                            </td>

                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="<?= base_url('/js/tanggal.js') ?>"></script>
<script src="<?= base_url('/js/laporan.js') ?>"></script>
<?= $this->endSection(); ?>