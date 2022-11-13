<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<link rel="stylesheet" href="<?= base_url('/css/aos.css') ?>">
<link rel="stylesheet" href="<?= base_url('/css/progresscircle.css') ?>">
<div class="loader-api">
    <div class="container chase"></div>
</div>
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
                <div class="col-12">
                    <div class="small-box rincian-1 p-4 " data-aos-once="true" data-aos="fade-down" data-aos-duration="500">
                        <div class="row">
                            <div class="col-6 p-0 d-flex flex-column">
                                <h5>Menampilkan Rincian Kegiatan <strong class="nama-pegawai"></strong></h5>
                            </div>
                            <div class="col-2 p-0"></div>
                            <div class="col-4 p-0 text-right">
                                <div>
                                    <span>Periode</span>
                                    <strong class="ml-2 periode" id="tgl-kegiatan-tabel">
                                    </strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-5 ">
                    <div class="small-box bg-white" data-aos-once="true" data-aos="fade-right" data-aos-delay="100" data-aos-duration="500">
                        <div class="row px-1">
                            <div class="col-12 py-1 text-center text-truncate ">
                                <span class="text-bold">
                                    Data sasaran kegiatan
                                </span>
                            </div>
                        </div>

                        <hr class="m-0">
                        <div class="row ">
                            <div class="col-6 text-center py-2">
                                <span class="fa-5x text-bold counter text-red belum-tindak"></span>
                                <p class="text-sm text-gray">Belum ditindaklanjuti</p>
                            </div>
                            <div class="col-6 text-center py-2">
                                <span class="fa-5x text-bold counter text-warning sedang-tindak"></span>
                                <p class="text-sm text-gray">Sedang ditindaklanjuti</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 text-center py-2">
                                <span class="fa-5x text-bold counter text-primary selesai-tindak"></span>
                                <p class="text-sm text-gray">Selesai ditindaklanjuti</p>
                            </div>
                            <div class="col-6 text-center py-2">
                                <span class="fa-5x text-bold counter text-success telah-verif"></span>
                                <p class="text-sm text-gray">Telah diverifikasi koordinator</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="small-box bg-white p-4" data-aos-once="true" data-aos="fade-left" data-aos-delay="200" data-aos-duration="500">
                                <div class="row">
                                    <div class="col-6 d-flex justify-content-center align-items-center">
                                        <span class="dicon hijau fa-2x rounded">
                                            <i class="far fa-clock"></i>
                                        </span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-bold fa-4x counter rata-jam"></span>jam
                                        <span class="text-bold fa-4x counter ml-3 rata-menit"></span>menit
                                        <p class="text-gray">Rata-rata jam kerja harian</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-md-6">
                            <div class="small-box bg-white p-4" data-aos-once="true" data-aos="fade-left" data-aos-delay="200" data-aos-duration="500">
                                <div class="row">
                                    <div class="col-7 text-center">
                                        <div class="circles">
                                            <div class="second circle"><strong style=" width: 120px;"></strong></div>
                                        </div>
                                    </div>
                                    <div class="col-5 d-flex align-items-center">
                                        <p class="text-gray">Jam kerja terbuang</p>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="small-box bg-white p-2" data-aos-once="true" data-aos="fade-left" data-aos-delay="300" data-aos-duration="500">
                                <span class="text-sm ml-2 text-gray"><strong>Laporan kegiatan</strong></span>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-bold fa-4x counter hari-kerja-input"></span>
                                        <p class="text-gray">Jumlah laporan diinputkan</p>
                                    </div>
                                    <div class="col-6 text-center">
                                        <span class="text-bold fa-4x counter hari-harus-input"></span>
                                        <p class="text-gray">Jumlah laporan seharusnya</p>
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
                        <div class="row px-1 mb-1">
                            <div class="col-12 py-2 text-center text-truncate">
                                <span class="text-sm text-white">
                                    <strong>Kegiatan</strong>
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-1">
                            <div class="col-12 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Rata-rata kegiatan pribadi perhari
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-3">
                            <div class="col-12 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 text-white counter kegiatan-pribadi"></h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6 rounded-lg" style="cursor: pointer;">
                    <div class="small-box bg-white rincian-2" data-aos-once="true" data-aos="fade-down" data-aos-delay="100" data-aos-duration="500">
                        <div class="row px-1 mb-1">
                            <div class="col-12 py-2 text-center text-truncate">
                                <span class="text-sm text-white">
                                    <strong>Lembur</strong>
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
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
                                <h3 class="my-2 counter text-white kegiatan-lembur"></h3>
                            </div>
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <div class="d-flex align-items-center">
                                    <h3 class="my-2 counter text-white jam-lembur"></h3> <span class="ml-1 text-white">Jam</span>
                                    <h3 class="my-2 counter text-white menit-lembur ml-2"></h3> <span class="ml-1 text-white">Menit</span>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-6 rounded-lg" style="cursor: pointer;">
                    <div class="small-box bg-white rincian-2" data-aos-once="true" data-aos="fade-down" data-aos-delay="200" data-aos-duration="500">
                        <div class="row px-1 mb-1">
                            <div class="col-12 py-2 text-center text-truncate">
                                <span class="text-sm text-white">
                                    <strong>Cuti</strong>
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
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
                                <h3 class="my-2 counter text-white jumlah-cuti"></h3>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-6 rounded-lg" style="cursor: pointer;">
                    <div class="small-box bg-white rincian-2" data-aos-once="true" data-aos="fade-down" data-aos-delay="300" data-aos-duration="500">
                        <div class="row px-1 mb-1">
                            <div class="col-12 py-2 text-center text-truncate">
                                <span class="text-sm text-white">
                                    <strong class="nama-bidang"></strong>
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-1">
                            <div class="col-6 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Rata-rata jam kerja bidang
                                </span>
                            </div>
                            <div class="col-6 py-2 text-center text-truncate ">
                                <span class="text-sm text-white">
                                    Rata-rata kegiatan bidang perhari
                                </span>
                            </div>
                        </div>
                        <hr class="m-0">
                        <div class="row px-3">
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 counter text-white rata-jam-bidang"></h3> <span class="ml-1 text-white">Jam</span>
                                <h3 class="my-2 counter text-white rata-menit-bidang ml-2"></h3> <span class="ml-1 text-white">Menit</span>
                            </div>
                            <div class="col-6 d-flex justify-content-center align-items-center">
                                <h3 class="my-2 counter text-white kegiatan-bidang"></h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-7">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Sasaran Kegiatan Tahunan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-success tombol mr-2 tombol-rencana" style="background-color: #3c4b64; border: none;">Tambah</button>
                                    <a class="btn btn-outline-secondary tombol-riwayat">Riwayat</a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <h5>
                                        tahun: <strong><?= date('Y') ?></strong>
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
                                        <tbody id="u">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
                                        <tbody id="t">

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 d-flex align-items-center">
                                    <h5><strong>Daftar Pegawai</strong></h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group input-group-md">
                                        <input type="search" id="pencarian4" name="table_search" class="form-control float-right" placeholder="Search ..." />
                                    </div>
                                </div>
                            </div>

                            <table class="table table-hover mt-2" id="tabelData4">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($list_pegawai != null) : ?>
                                        <?php $no_peg = 1; ?>
                                        <?php foreach ($list_pegawai as $list_peg) : ?>
                                            <tr>
                                                <td><?= $no_peg++; ?></td>
                                                <td><?= $list_peg['nama_pegawai']; ?></td>
                                                <td>
                                                    <button class="btn btn-sm btn-primary lihat" style="background-color: #2D95C9;" data-nip="<?= $list_peg['nip_lama']; ?>"><span>Detail</span></i></button>
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
                            <h3 class=" mb-3 text-center">Yakin Hapus Rencana Kegiatan ini?</h3>
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
<script src="<?= base_url('/js/tanggal.js') ?>"></script>
<script src="<?= base_url('/js/laporan.js') ?>"></script>
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

    function counter() {
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
    }
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
<script>
    $(document).on('click', '#open-modal-hapus', function() {
        $('.hapus-kegiatan').attr('href', $(this).data('link'))
    })
</script>


<script src="<?= base_url('/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script src="<?= base_url('/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
<script src="<?= base_url('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
<script src="<?= base_url('/js/tanggal.js') ?>"></script>
<!-- API -->
<script>
    $('#tabelData4').DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        responsive: true,
        ordering: false,
        info: true,
        autoWidth: false,
        pageLength: 10,
    });

    $(document).ready(function() {
        $('#tabelData4').DataTable().search($('#pencarian4').val()).draw();
    });

    $('#tabelData4_wrapper').children().first().addClass('d-none');
    $('.dataTables_paginate').addClass('Pager2').addClass('float-right');
    $('.dataTables_info').addClass('text-sm text-gray py-2');
    $('.dataTables_paginate').parent().parent().addClass('card-footer clearfix');

    $(document).on('keyup', '#pencarian4', function() {
        $('#tabelData4').DataTable().search($('#pencarian4').val()).draw();
    });
    // -----
    const baseUrl = '<?= base_url() ?>';
    const sessionNip = '<?= session('nip_lama') ?>';
    const es3kd = '<?= session('es3_kd') ?>'
    const jabatan = '<?= session('jabatan') ?>'
    $(document).on('click', '.lihat', function() {
        runApi($(this).data('nip'))
    })
    runApi('<?= session('nip_lama') ?>')

    function runApi(nip) {
        $.ajax({
            dataType: "json",
            url: baseUrl + '/APIRencanaKegiatan/' + nip,
            success: function(data) {
                // perintilan
                $('.nama-pegawai').html(data['nama_pegawai'])
                $('.nama-bidang').html(data['nama_bidang'])
                $('.periode').html(ubahFormatTanggal2(data['periode_awal']) + ` - ` + ubahFormatTanggal2(data['periode_akhir']))
                $('.rata-jam').html(data['rata_rata_jam'])
                $('.rata-menit').html(data['rata_rata_menit'])
                $('.kegiatan-pribadi').html(data['rata_rata_kegiatan_pribadi'])
                $('.kegiatan-lembur').html(data['jumlah_kegiatan_cuti'])
                $('.jam-lembur').html(data['jumlah_jam_lembur'])
                $('.menit-lembur').html(data['jumlah_menit_lembur'])
                $('.jumlah-cuti').html(data['jumlah_cuti'])
                $('.rata-jam-bidang').html(data['rata_rata_jam_bidang'])
                $('.rata-menit-bidang').html(data['rata_rata_menit_bidang'])
                $('.kegiatan-bidang').html(data['jumlah_kegiatan_bidang'])
                $('.hari-harus-input').html(data['total_hari_harus_input'])
                $('.hari-kerja-input').html(data['total_hari_kerja_telah_input'])

                $('.belum-tindak').html(data['rincian']['B'])
                $('.sedang-tindak').html(data['rincian']['T'])
                $('.selesai-tindak').html(data['rincian']['S'])
                $('.telah-verif').html(data['verif']['S'])

                $('.tombol-riwayat').attr('href', baseUrl + '/riwayatRencanaKegiatan/' + nip)

                // table
                $('#u,#t').empty()
                let tombol = '';
                let no = {
                    't': 1,
                    'u': 1
                };
                if (nip == sessionNip) {
                    $('.tombol-rencana').removeClass('d-none')

                } else if (nip != sessionNip) {
                    $('.tombol-rencana').addClass('d-none')
                }
                if (data['daftar_kegiatan'] != null) {
                    $.each(data['daftar_kegiatan'], function(i) {
                        if (nip == sessionNip && data['daftar_kegiatan'][i]['status_rincian'] == 'Belum ditindaklanjuti') {
                            tombol = `
                                    <button class="btn btn-sm btn-danger" id="open-modal-hapus" data-toggle="modal" data-target="#modal-hapus" data-link="` + baseUrl + `/hapusStatusRincian/` + data['daftar_kegiatan'][i]['id'] + `">Hapus</button>
                                    <a href="` + baseUrl + `/updateStatusRincian/` + data['daftar_kegiatan'][i]['id'] + `" class="btn btn-sm btn-success">Selesai</a>
                            `
                        } else if (nip == sessionNip && data['daftar_kegiatan'][i]['status_rincian'] == 'Selesai ditindaklanjuti') {
                            tombol = `
                                    <button class="btn btn-sm btn-danger" id="open-modal-hapus" data-toggle="modal" data-target="#modal-hapus" data-link="` + baseUrl + `/hapusStatusRincian/` + data['daftar_kegiatan'][i]['id'] + `">Hapus</button>
                            `
                        }

                        if (es3kd == data['es3_kd'] && jabatan == 'koordinator' && data['daftar_kegiatan'][i]['status_rincian'] == 'Selesai ditindaklanjuti' && data['daftar_kegiatan'][i]['status_verifikasi'] == 'Belum diverifikasi') {
                            tombol += `
                            <a href="` + baseUrl + `/verifikasiKegiatan/` + data['daftar_kegiatan'][i]['id'] + `" class="btn btn-sm btn-info">Verifikasi</a>
                            `
                        }

                        console.log(es3kd)
                        console.log(data['es3_kd'])
                        console.log(jabatan)
                        console.log(data['daftar_kegiatan'][i]['status_rincian'])
                        console.log(data['daftar_kegiatan'][i]['status_verifikasi'])

                        $('#' + data['daftar_kegiatan'][i]['tipe_kegiatan'].toLowerCase()).append(
                            `
                            <tr>
                                <td>` + no[data['daftar_kegiatan'][i]['tipe_kegiatan'].toLowerCase()]++ +
                            `</td>
                                <td>` + data['daftar_kegiatan'][i]['rincian_kegiatan'] + `</td>
                                <td>` + data['daftar_kegiatan'][i]['status_rincian'] + `</td>
                                <td>` + data['daftar_kegiatan'][i]['status_verifikasi'] + `</td>
                                <td>
                                    <a href="` + baseUrl + `/detailRencanaKegiatan/` + data['daftar_kegiatan'][i]['id'] + `/` + nip + `" class="btn btn-sm btn-primary">Detail</a>
                                    ` + tombol + `
                                </td>
                            </tr>
                            `
                        )
                    })
                }
                counter();
            },
            statusCode: {
                500: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal! Periksa kembali koneksi Anda!',
                        showConfirmButton: false,
                        timer: 3000
                    })
                }
            },
        });
    }


    $(document).ajaxStart(function() {
        $('.loader-api').removeClass('d-none');

    }).ajaxStop(function() {
        $('.loader-api').addClass('d-none')
    });
</script>



<?= $this->endSection(); ?>