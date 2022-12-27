<?= $this->extend('layout/template'); ?>
<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Rincian Sasaran Kegiatan Pegawai</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Rincian Kegiatan</li>
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
                            <span style="font-size:30px;">Daftar Sasaran Kegiatan Tahunan</span>
                        </div>
                        <div class="col-6 justify-content-end d-flex align-items-center">
                            <span class="text-right">
                                Periode : <span class="text-bold p-2 bg-info rounded ml-2 mr-1"><?= date('Y'); ?></span>
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
                                        <th>KEGIATAN</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php if ($list_kegiatan != null) : ?>
                                        <?php foreach ($list_kegiatan as $list) : ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $list['rincian_kegiatan']; ?></td>
                                                <td>
                                                    <a href="<?= base_url('/detailRencanaKegiatan/' . $list['id'] . '/' . $nip_lama) ?>" type="button" id="btn-detail" class="btn btn-sm btn-primary">
                                                        <span>Detail</span>
                                                    </a>
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
    </section>
</div>

<?= $this->endSection(); ?>