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
                                                    <th>No.</th>
                                                    <th>Kegiatan</th>
                                                    <th>Status</th>
                                                    <th>Verifikasi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1.</td>
                                                    <td>Mencangkul Tanaman</td>
                                                    <td>Proses</td>
                                                    <td>
                                                        <span class="badge badge-success">Sudah diverifikasi</span>
                                                    </td>
                                                </tr>
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
                                                    <th>Uraian</th>
                                                    <th>Jumlah</th>
                                                    <th>Satuan</th>
                                                    <th>Waktu</th>
                                                    <th>Hasil</th>
                                                    <th>Bukti Dukung</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Lorem, ipsum dolor.</td>
                                                    <td>1</td>
                                                    <td>Jam</td>
                                                    <td>12 Jam 15 Menit</td>
                                                    <td>Suram</td>
                                                    <td>Bukti Dukung</td>
                                                </tr>
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
<?= $this->endSection(); ?>