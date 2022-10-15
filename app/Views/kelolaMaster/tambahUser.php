<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Buat Akun User</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item"><a href="<?= base_url('/masterUser') ?>">Master User</a></li>
                        <li class="breadcrumb-item active">Tambah User</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- FORM -->
            <form action="" method="POST" class="row">
                <div id="kiri" class="col-md-12">
                    <div class="card">
                        <div class="card-header" style="background-color: #3c4b64; color: white;">
                            <h3 class="card-title">Akun</h3>
                        </div>
                        <div class="card-body">
                            <!-- INPUT -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select name="role" id="selectRole" class="form-control mr-2" style="border-radius: 5px;">
                                        <option selected disabled>- Pilih Role -</option>
                                        <option value="1">Pegawai</option>
                                        <option>Bidang Kepegawaian</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Username</label>
                                    <input type="text" name="nip" class="form-control" placeholder="Username ...">
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="text" name="nip" class="form-control" placeholder="Password ..." value="XyuUo29ja8" disabled>
                                </div>
                                <div class="float-right">
                                    <button type="button" class="btn btn-success swalDefaultSuccess">Buat</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="kanan" class="d-none col-md-6">

                </div>
            </form>
        </div>
    </section>
</div>
<!-- SweetAlert2 -->
<script src="<?= base_url('/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<!-- Select2 -->
<script src="<?= base_url('/plugins/select2/js/select2.full.min.js') ?>"></script>

<script>
    $(function() {
        var Toast = Swal.mixin({
            toast: true,
            position: 'top',
            showConfirmButton: false,
            timer: 3000
        });
        $('.swalDefaultSuccess').click(function() {
            Toast.fire({
                icon: 'warning',
                title: 'Sebelum membuat akun, silahkan pilih pegawai terlebih dahulu!'
            })
        });
    })
</script>

<script>
    $("#selectRole").change(function() {
        if ($("#selectRole").val() == 1) {
            $("#kiri").removeClass("col-md-12").addClass("col-md-6");
            $("#kanan").removeClass("d-none");
            $("#kanan").append(
                `
                <div class="card">
                        <div class="card-header" style="background-color: #3c4b64; color: white;">
                            <h3 class="card-title">Pilih Data Pegawai</h3>
                        </div>
                        <div class="card-body">
                            <!-- INPUT -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>NIP <span class="" style="color: red;">*</span></label>
                                    <input type="text" name="nip" class="form-control" placeholder="NIP ...">
                                </div>
                                <hr>
                                <img class="img-fluid mb-4" src="<?= base_url('/images/default.jpg') ?>" style="width: 150px;" alt="">
                                <!-- KETERANGAN -->

                                <div class="form-group">
                                    <label>Nama Pegawai</label>
                                    <input type="text" name="nama_pegawai" class="form-control" style="background-color: white;" placeholder="-" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Bidang</label>
                                    <input type="text" name="bidang" class="form-control" style="background-color: white;" placeholder="-" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Jenis Kelamin</label>
                                    <input type="text" name="bidang" class="form-control" style="background-color: white;" placeholder="-" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            )
        } else {
            $("#kiri").addClass("col-md-12").removeClass("col-md-6");
            $("#kanan").addClass("d-none");
            $("#kanan").empty();
        }
    });
</script>

<?= $this->endSection(); ?>