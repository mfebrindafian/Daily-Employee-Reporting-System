<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
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
                <div id="kiri" class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Rencana Kegiatan</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <button data-toggle="modal" data-target="#modal-tambah" class="btn btn-success tombol mr-2" style="background-color: #3c4b64; border: none;">Tambah</button>
                                    <a href="#" class="btn btn-outline-secondary">Riwayat</a>
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
                                            <tr>
                                                <td>1</td>
                                                <td>Menggali Lubang</td>
                                                <td>Terkubur</td>
                                                <td>Sukses</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-warning">Detail</a>
                                                    <a href="#" class="btn btn-sm btn-success">Selesai</a>
                                                </td>
                                            </tr>
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
                                            <tr>
                                                <td>1</td>
                                                <td>Menggali Lubang</td>
                                                <td>Terkubur</td>
                                                <td>Sukses</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-warning">Detail</a>
                                                    <a href="#" class="btn btn-sm btn-success">Selesai</a>
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




<!-- MODAL TAMBAH KEGIATAN -->
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog  modal-xl ">
        <form id="form-tambah" action="" method="post" class="modal-content form-tambah" enctype="multipart/form-data">
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
                            <p>tanggal Kegiatan
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
                                        <option value="utama">Utama</option>
                                        <option value="tambahan">Tambahan</option>
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
                                        <option value="utama">Utama</option>
                                        <option value="tambahan">Tambahan</option>
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
</script>

<?= $this->endSection(); ?>