<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url('/css/aos.css') ?>">
<link rel="stylesheet" href="<?= base_url('/css/progresscircle.css') ?>">
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Rincian Kegiatan Pegawai</h1>
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
            <div class="row">
                <div class="col-md-5 ">
                    <div class="small-box bg-white" data-aos-once="true" data-aos="fade-right" data-aos-delay="100" data-aos-duration="500">
                        <div class="row px-1">
                            <div class="col-12 py-1 text-center text-truncate ">
                                <span class="text-bold">
                                    Pekerjaan
                                </span>
                            </div>
                        </div>

                        <hr class="m-0">
                        <div class="row ">
                            <div class="col-6 text-center py-2">
                                <span class="fa-5x text-bold counter text-red">64</span>
                                <p class="text-sm text-gray">Belum ditindaklanjuti</p>
                            </div>
                            <div class="col-6 text-center py-2">
                                <span class="fa-5x text-bold counter text-warning">124</span>
                                <p class="text-sm text-gray">Sedang ditindak</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-center py-2">
                                <span class="fa-5x text-bold counter text-primary">12</span>
                                <p class="text-sm text-gray">Selesai Ditindak</p>
                            </div>
                            <div class="col-6 text-center py-2">
                                <span class="fa-5x text-bold counter text-success">45</span>
                                <p class="text-sm text-gray">Telah diverifikasi</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="small-box bg-white p-4" data-aos-once="true" data-aos="fade-left" data-aos-delay="200" data-aos-duration="500">
                                <div class="row">
                                    <div class="col-3 d-flex justify-content-center align-items-center">
                                        <span class="dicon hijau fa-2x rounded">
                                            <i class="far fa-clock"></i>
                                        </span>
                                    </div>
                                    <div class="col-9">
                                        <span class="text-bold fa-4x counter">7</span>jam

                                        <span class="text-bold fa-4x counter ml-3">12</span>menit
                                        <p class="text-gray">Rata-rata jam kerja</p>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="small-box bg-white p-4" data-aos-once="true" data-aos="fade-left" data-aos-delay="200" data-aos-duration="500">
                                <div class="row">
                                    <div class="col-7 text-center">
                                        <div class="circles">
                                            <div class="second circle"><strong style=" width: 120px;"></strong></div>
                                        </div>
                                    </div>
                                    <div class="col-5 d-flex align-items-center">
                                        <p class="text-gray">Jam kerja tebuang</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="small-box bg-white p-2" data-aos-once="true" data-aos="fade-left" data-aos-delay="300" data-aos-duration="500">
                                <span class="text-sm ml-2 text-gray"><strong>Periode 1 Januari - Februari 2022</strong></span>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-bold fa-4x counter">25</span>
                                        <p class="text-gray">Jumlah laporan diinputkan</p>
                                    </div>
                                    <div class="col-6 text-center">
                                        <span class="text-bold fa-4x counter">77</span>
                                        <p class="text-gray">Jumlah laporan Seharusnya</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 col-6 rounded-lg " style="cursor: pointer;">
                    <div class="small-box bg-white rincian-2 " data-aos-once="true" data-aos="fade-down" data-aos-duration="500">
                        <div class="row px-1">
                            <div class="col-12 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Rata-rata kegiatan perhari
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-3">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 text-white counter">97</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6 rounded-lg" style="cursor: pointer;">
                    <div class="small-box bg-white rincian-2" data-aos-once="true" data-aos="fade-down" data-aos-delay="100" data-aos-duration="500">
                        <div class="row px-1">
                            <div class="col-6 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Jumlah Kegiatan Lembur
                                </span>
                            </div>
                            <div class="col-6 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Durasi Lembur
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-3">
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 counter text-white">12</h3>
                            </div>
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <div class="d-flex align-items-center">
                                    <h3 class="my-2 counter text-white">30 </h3> <span class="ml-1 text-white">Jam</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 rounded-lg" style="cursor: pointer;">
                    <div class="small-box bg-white rincian-2" data-aos-once="true" data-aos="fade-down" data-aos-delay="200" data-aos-duration="500">
                        <div class="row px-1">
                            <div class="col-12 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Jumlah Cuti
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-3">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 counter text-white">7</h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-6 rounded-lg" style="cursor: pointer;">
                    <div class="small-box bg-white rincian-2" data-aos-once="true" data-aos="fade-down" data-aos-delay="300" data-aos-duration="500">
                        <div class="row px-1">
                            <div class="col-6 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Rata-rata jam kerja bidang
                                </span>
                            </div>
                            <div class="col-6 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Jumlah Laporan Bidang
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-3">
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 counter text-white">12</h3>
                            </div>
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 counter text-white">30 </h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Rencana Kegiatan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-success tombol mr-2" style="background-color: #3c4b64; border: none;">Tambah</button>
                                    <a href="<?= base_url('/riwayatRencanaKegiatan'); ?>" class="btn btn-outline-secondary">Riwayat</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h5>
                                        tahun: <strong>2022</strong>
                                    </h5>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <i>Utama</i>
                                    <table class="table table-hover mt-2">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kegiatan</th>
                                                <th>Status</th>
                                                <th>Verifikasi</th>
                                                <th>Aksi</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php if ($list_kegiatan != null) : ?>
                                                <?php $ke = 1; ?>
                                                <?php foreach ($list_kegiatan as $list) : ?>
                                                    <?php $tahun = explode('-', $list['tgl_input']) ?>
                                                    <?php if ($list['tipe_kegiatan'] == 'U' && $tahun[0] == date('Y')) : ?>
                                                        <tr>
                                                            <td><?= $ke++; ?></td>
                                                            <td><?= $list['rincian_kegiatan']; ?></td>
                                                            <td><?php if ($list['status_rincian'] == 'B') {
                                                                    echo 'Belum ditindaklanjuti';
                                                                } elseif ($list['status_rincian'] == 'T') {
                                                                    echo 'Sedang ditindaklanjuti';
                                                                } else {
                                                                    echo 'Selesai ditindaklanjuti';
                                                                } ?></td>
                                                            <td><?php if ($list['status_verifikasi'] == 'B') {
                                                                    echo 'Belum diverifikasi';
                                                                } else {
                                                                    echo 'sudah diverifikasi';
                                                                } ?></td>

                                                            <td>
                                                                <a href="<?= base_url('/detailRencanaKegiatan/' . $list['id']) ?>" class="btn btn-sm btn-warning">Detail</a>
                                                                <a href="<?= base_url('/hapusStatusRincian/' . $list['id']); ?>" class="btn btn-sm btn-danger">Hapus</a>
                                                                <a href="<?= base_url('/updateStatusRincian/' . $list['id']); ?>" class="btn btn-sm btn-success">Selesai</a>
                                                            </td>
                                                        </tr>
                                                    <?php endif ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <i>Tambahan</i>
                                    <table class="table table-hover mt-2">
                                        <thead>
                                            <tr>
                                                <th>No.</th>
                                                <th>Kegiatan</th>
                                                <th>Status</th>
                                                <th>Verifikasi</th>
                                                <th>Aksi</th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <?php if ($list_kegiatan != null) : ?>
                                                <?php $ke = 1; ?>
                                                <?php foreach ($list_kegiatan as $list) : ?>
                                                    <?php $tahun = explode('-', $list['tgl_input']) ?>

                                                    <?php if ($list['tipe_kegiatan'] == 'T' && $tahun[0] == date('Y')) : ?>
                                                        <tr>
                                                            <td><?= $ke++; ?></td>
                                                            <td><?= $list['rincian_kegiatan']; ?></td>
                                                            <td><?php if ($list['status_rincian'] == 'B') {
                                                                    echo 'Belum ditindaklanjuti';
                                                                } elseif ($list['status_rincian'] == 'T') {
                                                                    echo 'Sedang ditindaklanjuti';
                                                                } else {
                                                                    echo 'Selesai ditindaklanjuti';
                                                                } ?></td>
                                                            <td><?php if ($list['status_verifikasi'] == 'B') {
                                                                    echo 'Belum diverifikasi';
                                                                } else {
                                                                    echo 'sudah diverifikasi';
                                                                } ?></td>
                                                            <td>
                                                                <a href="<?= base_url('/detailRencanaKegiatan/' . $list['id']) ?>" class="btn btn-sm btn-warning">Detail</a>
                                                                <a href="<?= base_url('/hapusStatusRincian/' . $list['id']); ?>" class="btn btn-sm btn-danger">Hapus</a>
                                                                <a href="<?= base_url('/updateStatusRincian/' . $list['id']); ?>" class="btn btn-sm btn-success">Selesai</a>
                                                            </td>
                                                        </tr>
                                                    <?php endif ?>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>




<!-- MODAL TAMBAH KEGIATAN -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog  modal-xl ">
        <form id="form-tambah" action="<?= base_url('/tambahRencanaKegiatan'); ?>" method="post" class="modal-content form-tambah" enctype="multipart/form-data">
            <input type="text" id="id_kegiatan" name="id_kegiatan" class="d-none">
            <div class="modal-header">
                <h4 class="modal-title">Rencana Kegiatan Tahun</h4>
                <button id="btn-close-modal-tambah" type="button" class="close" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body px-5 py-3">
                <div class="row">
                    <div class="col-12 p-0">
                        <div class="form-group">
                            <p>Tanggal Kegiatan
                            </p>
                            <h2 class="mb-3" id="tanggal-tambah"></h2>
                            <input type="date" class="form-control d-none" name="tanggal" id="hari-ini" class="form-control">
                        </div>
                    </div>
                </div>

                <!-- lama -->
                <div id="lama">
                    <div class="row rounded position-relative pt-2 kegiatan-baru ">
                        <div class="col-xl-1 baris-kegiatan">
                            <div class="row"><strong>NO</strong></div>
                            <div class="row">1</div>
                        </div>
                        <div class="col-xl-3 baris-kegiatan">
                            <div class="row"><strong>Tipe Kegiatan</strong></div>
                            <div class="row px-1  w-100">
                                <div class="input-group  w-100">
                                    <select class=" form-control  w-100" name="field_tipe[]" required>
                                        <option value="U">Utama</option>
                                        <option value="T">Tambahan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 baris-kegiatan">
                            <div class="row"><strong>Uraian Kegiatan</strong></div>
                            <div class="row px-1  w-100">
                                <div class="form-group w-100 position-relative">
                                    <textarea id="kegiatan-input" class="form-control  w-100" name="field_uraian[]" rows="1" placeholder="Masukkan Uraian Kegiatan ..." required></textarea>
                                    <div class="option-kegiatan-wrapper w-100 mt-2 bg-white py-2 rounded shadow-lg position-absolute d-none">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- baru -->
                <div id="baru">
                </div>
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
    </div>
</div>

<script src="<?= base_url('/js/aos.js') ?>"></script>
<script src="<?= base_url('/js/progresscircle.js') ?>"></script>
<script>
    AOS.init();
</script>
<script>
    function appendBaris(modal, noBaris) {
        $(modal).append(
            `
            <div class="row rounded mt-4 position-relative pt-2 kegiatan-baru ">
            <span id="hapus-baris" type="button" class="delete-kegiatan"><i class="fas fa-times"></i></span>
                        <div class="col-xl-1 baris-kegiatan">
                            <div class="row"><strong>NO</strong></div>
                            <div class="row">` +
            noBaris +
            `</div>
                        </div>
                        <div class="col-xl-3 baris-kegiatan">
                            <div class="row"><strong>Tipe Kegiatan</strong></div>
                            <div class="row px-1  w-100">
                                <div class="input-group  w-100">
                                    <select class=" form-control  w-100" name="field_tipe[]" required>
                                        <option value="U">Utama</option>
                                        <option value="T">Tambahan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-8 baris-kegiatan">
                            <div class="row"><strong>Uraian Kegiatan</strong></div>
                            <div class="row px-1  w-100">

                                <div class="form-group w-100 position-relative">
                                    <textarea id="kegiatan-input" class="form-control  w-100" name="field_uraian[]" rows="1" placeholder="Masukkan Uraian Kegiatan ..." required></textarea>
                                    <div class="option-kegiatan-wrapper w-100 mt-2 bg-white py-2 rounded shadow-lg position-absolute d-none">

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
    
    `
        );
    }

    $('[id^="tambah-baris"]').click(function() {
        let noBaris = $('#lama').children().length + $('#baru').children().length + 1;
        appendBaris('#baru', noBaris);
        $('#baru').children().find('#hapus-baris').addClass('d-none');
        $('#baru').children().last().find('#hapus-baris').removeClass('d-none');
    });

    $(document).on('click', '#hapus-baris', function() {
        if ($(this).parent().parent().attr('id') == 'baru') {
            $(this).parent().remove();
            $('#baru').children().find('#hapus-baris').addClass('d-none');
            $('#baru').children().last().find('#hapus-baris').removeClass('d-none');
        }
        if ($(this).parent().parent().attr('id') == 'baru2') {
            $(this).parent().remove();
            $('#baru2').children().find('#hapus-baris').addClass('d-none');
            $('#baru2').children().last().find('#hapus-baris').removeClass('d-none');
        }
    });

    $('.counter').each(function() {
        $(this).prop('Counter', 0).animate({
            Counter: $(this).text()
        }, {
            duration: 1000,
            easing: 'swing',
            step: function(now) {
                $(this).text(Math.ceil(now));
            }
        });
    });
</script>

<script src="<?= base_url('/js/circle-progress.js') ?>"></script>
<script>
    var isi = Math.random();

    function perc2color(perc) {
        var r, g, b = 0;
        if (perc * 100 < 50) {
            g = 255;
            r = Math.round(5.1 * perc * 100);
        } else {
            r = 255;
            g = Math.round(510 - 5.10 * perc * 100);
        }
        var h = r * 0x10000 + g * 0x100 + b * 0x1;
        return '#' + ('000000' + h.toString(16)).slice(-6);
    }
    $('.second.circle')
        .circleProgress({
            value: isi,
            thickness: 10,
            size: 120,
            fill: {
                gradient: [perc2color(isi)],
            },
        })
        .on('circle-animation-progress', function(event, progress) {
            $(this)
                .find('strong')
                .html(Math.round(isi * 100 * progress) + '<span class="text-xs">Jam</span>');
        });
</script>



<?= $this->endSection(); ?>