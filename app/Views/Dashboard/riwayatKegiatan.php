<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Riwayat Kegiatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/rincianKegiatanPegawai') ?>">Rincian Kegiatan</a></li>
                        <li class="breadcrumb-item active">Riwayat Kegiatan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div id="kiri" class="col-md-12">

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group ">
                                        <select class="form-control" name="" id="">
                                            <option value="">- Pilih Tahun -</option>
                                            <option value="2022">2022</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">

                                    <table class="table table-hover mt-2">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kegiatan</th>
                                                <th>Tipe</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>Mencangkul Tanaman</td>
                                                <td>Petani</td>
                                                <td>Proses</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-danger">Aksi 1</a>
                                                    <a href="#" class="btn btn-sm btn-success">Aksi 2</a>
                                                </td>
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
    </section>
</div>




<?= $this->endSection(); ?>