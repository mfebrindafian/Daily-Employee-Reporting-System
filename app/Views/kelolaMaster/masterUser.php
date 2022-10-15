<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Master User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Master User</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="<?= $class_modal_default; ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <img class="img-fluid" style="width: 100%;" src="<?= base_url('/images/default.jpg') ?>" alt="">
                                </div>
                                <div class="col-md-6 p-2">
                                    <h2 class="font-weight-bold">Username</h2>
                                    <p id="oldRole" class="text-gray">Level User</p>
                                    <!-- FORM -->
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 px-5">
                                    <!-- KETERANGAN -->
                                    <div class="col-md-12">
                                        <strong>Nama Lengkap</strong>
                                        <p class="text-muted">
                                            -
                                        </p>

                                        <strong>NIP Lama</strong>
                                        <p class="text-muted">
                                            -
                                        </p>

                                        <strong>Email</strong>
                                        <p class="text-muted">-</p>

                                        <strong>Status Akun</strong>
                                        <div>
                                            <span class="badge badge px-2">
                                                -
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="<?= $class_modal_setup; ?>">
                    <div class="card position-relative">
                        <a href="<?= base_url('/masterUser') ?>" class="delete-kegiatan"><i class="fas fa-times"></i></a>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <?php if ($show_data_user != NULL) : ?>
                                        <?php if ($show_data_user['image'] === 'default.png') {
                                            $image_user = '/images/profil/default.jpg';
                                        } else {
                                            $image_user = '/images/profil/' . $show_data_user['image'];
                                        } ?>
                                        <img class="img-fluid" style="width: 100%;" src="<?= base_url($image_user) ?>" alt="">
                                        <input type="hidden" name='image' value="<?= $show_data_user['image']; ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6 p-2">
                                    <h2 class="font-weight-bold"><?php if ($show_data_user != NULL) {
                                                                        echo $show_data_user['username'];
                                                                    }  ?></h2>
                                    <div class="row">
                                        <?php if ($show_list_level != NULL) : ?>
                                            <?php foreach ($show_list_level as $level) : ?>
                                                <p>&nbsp;&nbsp;</p>
                                                <p id="oldRole" class="text-gray"><?= $level['nama_level']; ?></p>
                                                <p>&nbsp;&nbsp;|</p>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                    <!-- FORM -->
                                    <form action="<?= base_url('/updateRoleAktivasi') ?>" method="POST" enctype="multipart/form-data" id="roleForm" class="row d-none">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>Role/level</label>
                                                <div id="roles">

                                                    <?php if ($show_list_level != NULL) : ?>
                                                        <?php for ($i = 0; $i < count($show_list_level); $i++) : ?>
                                                            <div class="row">
                                                                <div class="col-11">
                                                                    <select name="level_show[]" class="form-control form-control-sm mr-2 mb-2" style="border-radius: 5px;">
                                                                        <option value="<?= $show_list_level[$i]['level_id']; ?>"><?= $show_list_level[$i]['nama_level']; ?></option>
                                                                        <?php if ($level_tersedia != NULL) : ?>
                                                                            <?php foreach ($level_tersedia as $tersedia) : ?>
                                                                                <option value="<?= $tersedia['id']; ?>"><?= $tersedia['nama_level']; ?></option>
                                                                            <?php endforeach; ?>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-1">
                                                                    <button type="button" data-toggle="modal" data-target="#modal-hapus-level" data-nama_level="<?= $show_list_level[$i]['nama_level']; ?>" data-id_level="<?= $show_list_level[$i]['id']; ?>" id="btnHapusLevel" class="btn btn-sm text-white" style="background-color: #E18939; border:none;"><i class="fas fa-times"></i></button>
                                                                </div>
                                                            </div>

                                                        <?php endfor; ?>
                                                    <?php endif; ?>

                                                    <div class="row">
                                                        <div class="col-12 ">
                                                            <div class="float-right">
                                                                <button type="button" data-toggle="modal" data-target="#modal-tambah-role" class="btn btn-success btn-sm tombol" data-id style="background-color: #3c4b64; border: none;">Tambah Role</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="form-group">
                                                <?php if ($show_data_user != NULL) : ?>
                                                    <input type="hidden" name="id_user_show" value="<?= $show_data_user['id']; ?>">
                                                    <input type="hidden" name="username_show" value="<?= $show_data_user['username']; ?>">
                                                    <input type="hidden" name="fullname_show" value="<?= $show_data_user['fullname']; ?>">
                                                    <input type="hidden" name="email_show" value="<?= $show_data_user['email']; ?>">
                                                    <input type="hidden" name="password_show" value="<?= $show_data_user['password']; ?>">
                                                    <input type="hidden" name="token_show" value="<?= $show_data_user['token']; ?>">
                                                    <input type="hidden" name="image_user_show" value="<?= $show_data_user['image']; ?>">
                                                    <input type="hidden" name="nip_lama_user_show" value="<?= $show_data_user['nip_lama_user']; ?>">


                                                    <label for="role">Status</label>
                                                    <select name="is_active" class="form-control form-control-sm mr-2" style="border-radius: 5px;">
                                                        <option value="<?php if ($show_data_user['is_active'] == 'Y') {
                                                                            echo 'Y';
                                                                        } else {
                                                                            echo 'N';
                                                                        } ?>"><?php if ($show_data_user['is_active'] == 'Y') {
                                                                                    echo 'Active';
                                                                                } else {
                                                                                    echo 'Non-active';
                                                                                } ?></option>
                                                        <option value="<?php if ($show_data_user['is_active'] != 'Y') {
                                                                            echo 'Y';
                                                                        } else {
                                                                            echo 'N';
                                                                        } ?>"><?php if ($show_data_user['is_active'] != 'Y') {
                                                                                    echo 'Active';
                                                                                } else {
                                                                                    echo 'Non-active';
                                                                                } ?></option>
                                                    </select>
                                                <?php endif; ?>
                                            </div>

                                            <div>
                                                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-save mr-1"></i> Simpan</button>
                                                <button type="button" id="cancel" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                                            </div>
                                        </div>

                                    </form>
                                    <button id="openRole" class="btn btn-info btn-sm tombol" style="background-color: #2D95C9; border:none;"><i class="fas fa-pen mr-1"></i> Ubah Data</button>
                                    <button id="btnReset" type="button" data-toggle="modal" data-target="#modal-reset-password" class="btn btn-success btn-sm tombol" data-id style="background-color: #3c4b64; border: none;">Reset Password</button>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-12 px-5">
                                    <!-- KETERANGAN -->

                                    <?php if ($show_data_user != NULL) : ?>

                                        <div class="col-md-12">
                                            <strong>Nama Lengkap</strong>
                                            <input type="hidden" name='fullname' value="<?= $show_data_user['fullname']; ?>">
                                            <p class="text-muted">
                                                <?= $show_data_user['fullname']; ?>
                                            </p>

                                            <strong>NIP Lama</strong>
                                            <input type="hidden" name='nip_lama_user' value="<?= $show_data_user['nip_lama_user']; ?>">
                                            <p class="text-muted">
                                                <?= $show_data_user['nip_lama_user']; ?>
                                            </p>

                                            <strong>Email</strong>
                                            <input type="hidden" name='email' value="<?= $show_data_user['email']; ?>">
                                            <p class="text-muted"><?= $show_data_user['email']; ?></p>

                                            <strong>Status Akun</strong>
                                            <input type="hidden" name='is_active' value="<?= $show_data_user['is_active']; ?>">
                                            <div>
                                                <?php if ($show_data_user['is_active'] == 'Y') : ?>
                                                    <span class="badge badge-success px-2">active</span>
                                                <?php else : ?>
                                                    <span class="badge badge-danger px-2">non-active</span>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h4>Daftar User</h4>
                        </div>
                        <form class="col-md-6">
                            <div class="input-group">
                                <select class="form-control filter mr-2" style="border-radius: 5px;">
                                    <option selected value="">- Status Akun -</option>
                                    <option value="active">Active</option>
                                    <option value="non-active">Non-active</option>
                                </select>
                                <button type="button" data-toggle="modal" data-target="#modal-tambah-user" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;"><i class="fas fa-plus mr-2"></i> Tambah</button>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="input-group input-group-md pt-3 px-4" style="width: 250px">
                                    <input type="search" id="pencarian" name="table_search" class="form-control float-right" placeholder="Search ..." />
                                </div>

                                <form action="<?= base_url('/showDataUser'); ?>" method="POST">
                                    <!-- /.card-header -->
                                    <div class="card-body table-responsive px-0 overflow-hidden">
                                        <table class="table table-hover text-nowrap" id="tabelData">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">NO.</th>
                                                    <th>USERNAME</th>
                                                    <th>STATUS AKUN</th>
                                                    <th>AKSI</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $no = 1; ?>
                                                <?php foreach ($list_user as $list) : ?>

                                                    <tr>
                                                        <td class="text-center"><?= $no++ ?></td>
                                                        <td><?= $list['username']; ?></td>
                                                        <td>
                                                            <?php if ($list['is_active'] == 'Y') {

                                                                echo '<span class="badge bg-success">active</span>';
                                                            } else {
                                                                echo '<span class="badge bg-danger">non-active</span>';
                                                            } ?>
                                                        </td>
                                                        <td>
                                                            <a href="<?= base_url('/showDataUser/' . $list['id']); ?>" type="submit" class="btn btn-info btn-xs tombol" style="background-color: #2D95C9; border:none;"><i class="fas fa-pen"></i></a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </form>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- MODAL TAMBAH USER -->
<div class="modal fade" id="modal-tambah-user">
    <div class="modal-dialog modal-xl">
        <form action="<?= base_url('/tambahUser') ?>" method="POST" class="modal-content">
            <input type="text" class="d-none" name="id_pegawai" id="id_pegawai">
            <div class="modal-header border-0">
                <h4 class="modal-title">Tambah User</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 px-4"><label>Pilih Level</label>
                        <div class="d-flex flex-wrap">
                            <div class="pilih-level">
                                <label for="level6" class="checkbox-level">
                                    <i class="far fa-check-square"></i>
                                    Staf/ Pegawai
                                </label>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-4">
                                <hr>
                            </div>
                            <div class="col-4 text-center text-gray opsional">
                                <small>
                                    <em>Level Tambahan</em>
                                </small>
                            </div>
                            <div class="col-4">
                                <hr>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap">
                            <?php $no = 0; ?>
                            <?php if ($level_tersedia != NULL) : ?>
                                <?php foreach ($level_tersedia as $tersedia) : ?>

                                    <div class="pilih-level <?php if ($tersedia['nama_level'] == 'Staf/ Pegawai') : ?>d-none<?php endif; ?>">
                                        <label for="level<?= $no ?>" class="checkbox-level active">
                                            <input class="d-none" type="checkbox" name="level_pick<?= $no ?>" id="level<?= $no ?>" <?php if ($tersedia['nama_level'] == 'Staf/ Pegawai') : ?>checked<?php endif; ?>>
                                            <i class="far fa-square"></i>
                                            <?= $tersedia['nama_level']; ?>
                                        </label>
                                    </div>

                                    <?php $no++ ?>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                        <div class="form-group mt-3">
                            <label>Username</label>
                            <input type="text" name="username_tambah" class="form-control" placeholder="Username ...">
                        </div>
                        <div class="form-group mt-3">
                            <label>Fullname</label>
                            <input type="text" name="fullname_tambah" class="form-control" placeholder="Fullname ...">
                        </div>
                        <div class="form-group mt-3">
                            <label>Email</label>
                            <input type="text" name="email_tambah" class="form-control" placeholder="Email ...">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password_tambah" class="form-control" placeholder="123456" disabled>
                        </div>
                        <div class="form-group">
                            <label>Is Active</label>
                            <select id="is_active" name="is_active_tambah" class="form-control mr-2" style="border-radius: 5px;">
                                <option value="Y">Active</option>
                                <option value="N">Non-active</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 px-4 border-left">

                        <div class="form-group position-relative">
                            <label>Cari Pegawai</label>
                            <input type="text" id="cari_pegawai" class="form-control" placeholder="Search ...">
                            <div class="option-kegiatan-wrapper w-100 mt-2 bg-white py-2 rounded shadow-lg position-absolute d-none">
                                <?php if ($list_pegawai != NULL) : ?>
                                    <?php foreach ($list_pegawai as $pegawai) : ?>
                                        <option data-id="<?= $pegawai['id'] ?>" data-nip_lama="<?= $pegawai['nip_lama'] ?>" data-nama_pegawai="<?= $pegawai['nama_pegawai'] ?>" class="option-kegiatan border-bottom d-none"><?= $pegawai['nama_pegawai'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="row px-2">
                            <!-- KETERANGAN -->
                            <div class="col-md-12 py-2 border rounded">
                                <div class="row">

                                    <div class="col-sm-8">
                                        <strong>Nama Lengkap</strong>
                                        <p id="nama_pegawai_tambah" class="text-muted">
                                            -
                                        </p>

                                        <strong>NIP Lama</strong>
                                        <p id="nip_lama_tambah" class="text-muted">
                                            -
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between border-0">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- MODAL TAMBAH ROLE -->
<div class="modal fade" style="padding-top: 13%;" id="modal-tambah-role">
    <div class="modal-dialog">
        <form action="<?= base_url('/tambahLevelUser') ?>" method="POST" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Level</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?php if ($show_data_user != NULL) : ?>
                        <input type="hidden" name="id_user_role" value="<?= $show_data_user['id']; ?>">
                    <?php endif; ?>
                    <label>Nama Level</label>
                    <select name="role" class="form-control" style="border-radius: 5px;">
                        <?php if ($level_tersedia != NULL) : ?>
                            <?php foreach ($level_tersedia as $tersedia) : ?>
                                <option value="<?= $tersedia['id']; ?>"><?= $tersedia['nama_level']; ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- MODAL RESET PASSWORD -->
<div class="modal fade" style="padding-top: 10%;" id="modal-reset-password">
    <div class="modal-dialog">
        <form action="<?= base_url('/resetPasswordUser') ?>" method="POST" class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center flex-column">
                <div class="form-group">
                    <?php if ($show_data_user != NULL) : ?>
                        <span class="w-100 d-flex justify-content-center align-items-center mb-4">
                            <i class="fas fa-exclamation-circle fa-7x text-red"></i>
                        </span>
                        <input type="hidden" name="id_user_reset" value="<?= $show_data_user['id']; ?>">
                        <input type="hidden" name="username_reset" value="<?= $show_data_user['username']; ?>">
                        <input type="hidden" name="fullname_reset" value="<?= $show_data_user['fullname']; ?>">
                        <input type="hidden" name="email_reset" value="<?= $show_data_user['email']; ?>">
                        <input type="hidden" name="token_reset" value="<?= $show_data_user['token']; ?>">
                        <input type="hidden" name="image_user_reset" value="<?= $show_data_user['image']; ?>">
                        <input type="hidden" name="nip_lama_user_reset" value="<?= $show_data_user['nip_lama_user']; ?>">
                        <input type="hidden" name="is_active_reset" value="<?= $show_data_user['is_active']; ?>">

                        <h3 class="justify-content-center align-items-center mb-4 text-center">Reset Password</h3>
                        <p class="justify-content-center align-items-center text-center">Yakin ingin mereset password <strong><?= $show_data_user['username']; ?>?</strong></p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger tombol">Reset</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<!-- MODAL HAPUS LEVEL -->
<div class="modal fade" style="padding-top: 9%;" id="modal-hapus-level">
    <div class="modal-dialog">
        <form action="<?= base_url('/hapusLevelUser') ?>" method="POST" class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body d-flex justify-content-center align-items-center flex-column">
                <div class="form-group">
                    <?php if ($show_data_user != NULL) : ?>
                        <span class="w-100 d-flex justify-content-center align-items-center mb-4">
                            <i class="fas fa-exclamation-circle fa-7x text-red"></i>
                        </span>
                        <input type="hidden" id="id_level_hapus" name="id_level_hapus">
                        <input type="hidden" name="id_user_hapus" value="<?= $show_data_user['id']; ?>">
                        <h3 class="justify-content-center align-items-center mb-4 text-center">Hapus Level</h3>
                        <span class="text-center">Yakin ingin menghapus level <strong id="nama_level_hapus"></strong> milik <strong><?= $show_data_user['username']; ?>?</strong></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="modal-footer justify-content-center border-0">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-danger tombol">Hapus</button>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<script src="<?= base_url('/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<!-- Toastr -->
<script src="<?= base_url('/plugins/toastr/toastr.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        <?php if (session()->getFlashdata('pesan')) { ?>
            Swal.fire({
                title: "<?= session()->getFlashdata('pesan') ?>",
                icon: "<?= session()->getFlashdata('icon') ?>",
                showConfirmButton: true,
            });
        <?php } ?>
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('keyup', '#cari_pegawai', function() {
            $(this).next().removeClass('d-none')
            for (i = 0; i <= $(this).next().children().length; i++) {
                if ($(this).next().children().eq(i).text().toLowerCase().match($(this).val().toLowerCase()) !== null) {
                    $(this).next().children().eq(i).removeClass('d-none')
                } else {
                    $(this).next().children().eq(i).addClass('d-none')
                }
            }
        })

        $(document).on('blur', '#cari_pegawai', function() {
            let textarea = $(this)
            setTimeout(function() {
                textarea.next().addClass('d-none')
            }, 400)
        })

        $(document).on('click', '.option-kegiatan', function() {
            $('#id_pegawai').val($(this).data('id'));
            $('#nama_pegawai_tambah').text($(this).data('nama_pegawai'));
            $('#nip_lama_tambah').text($(this).data('nip_lama'));
            $(this).parent().prev().val($(this).text())
            $(this).parent().addClass('d-none')
        })
    })
</script>




<script>
    $(document).ready(function() {
        $("#cari_pegawai").autocomplete({
            minLength: 2,
            source: '<?php echo site_url('masterUser/get_autofillPegawai/?') ?>',
            focus: function(event, ui) {
                $("#cari_pegawai").val(ui.item.label);
                return false;
            },
            select: function(event, ui) {
                $("#cari_pegawai").val(ui.item.label);
                return false;
            }
        })
    });
</script>
<script>
    const btnReset = document.querySelector('#btnReset');
    const openRole = document.querySelector('#openRole');
    const cancel = document.querySelector('#cancel');
    const roleForm = document.querySelector('#roleForm');
    const oldRole = document.querySelector('#oldRole');

    openRole.addEventListener('click', function() {
        roleForm.classList.toggle('d-none');
        openRole.classList.toggle('d-none');
        btnReset.classList.toggle('d-none');
        oldRole.classList.toggle('d-none');
    })
    cancel.addEventListener('click', function() {
        roleForm.classList.toggle('d-none');
        openRole.classList.toggle('d-none');
        oldRole.classList.toggle('d-none');
        btnReset.classList.toggle('d-none');
    })
</script>


<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            if ($(this).prop('checked') == true) {
                $(this).parent().toggleClass('active')
                $(this).siblings().removeClass().addClass('far fa-check-square')
            } else if ($(this).prop('checked') == false) {
                $(this).parent().toggleClass('active')
                $(this).siblings().removeClass().addClass('far fa-square')
            }
        })
    })
</script>

<script type="text/javascript">
    $('#tabelData').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        'ordering': false,
        "info": true,
        "autoWidth": false,
        "responsive": true,
        "pageLength": 10

    });

    $('.filter').on('change', function() {
        $('#tabelData').DataTable().search(
            $(this).val()
        ).draw();
    });

    $('#tabelData_wrapper').children().first().addClass('d-none')
    $('.dataTables_paginate').addClass('Pager2').addClass('float-right')
    $('.dataTables_info').addClass('text-sm text-gray py-2')
    $('.dataTables_paginate').parent().parent().addClass('card-footer clearfix')

    $(document).on('keyup', '#pencarian', function() {
        $('#tabelData').DataTable().search(
            $(this).val()
        ).draw();
    })
</script>

<script>
    // Mengambil Data edit dengan menggunakan Jquery
    $(document).on('click', '#btnHapusLevel', function() {
        $('#id_level_hapus').val($(this).data('id_level'));
        $('#nama_level_hapus').text($(this).data('nama_level'));
    })
</script>


<?= $this->endSection(); ?>