<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Master Kegiatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Master Kegiatan</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main Content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 text-center">
                                    <img class="img-fluid" style="width: 100%;" src="<?= base_url('/images/default.jpg') ?>" alt="">
                                </div>
                                <div class="col-md-6 p-2">
                                    <h2 class="font-weight-bold">John Doe</h2>
                                    <p class="text-gray">Administrator</p>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <!-- DAFTAR KEGIATAN -->
                                <div class="col-md-12 px-2">
                                    <div class="card">
                                        <!-- FILTER -->
                                        <div class="row px-4">
                                            <!-- SEARCH -->
                                            <form action="" method="POST" class="col-md-5 mt-3 input-group input-group-md">
                                                <input type="search" name="table_search" class="form-control float-right" placeholder="Search" />
                                                <div class=" input-group-append">
                                                    <button type="submit" class="btn btn-default">
                                                        <i class="fas fa-search"></i>
                                                    </button>
                                                </div>
                                            </form>
                                            <div class="col-md-2"></div>
                                            <!-- TANGGAL DAN STATUS -->
                                            <form action="" method="POST" class="mt-3 col-md-5">
                                                <div class="input-group">
                                                    <select class="form-control" style="border-radius: 5px;">
                                                        <option selected disabled>- Status -</option>
                                                        <option>belum</option>
                                                        <option>proses</option>
                                                        <option>selesai</option>
                                                    </select>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- /.card-header -->
                                        <div class="card-body table-responsive px-4">
                                            <table class="table table-hover text-nowrap">
                                                <thead>
                                                    <tr>
                                                        <th>NO.</th>
                                                        <th>TANGGAL</th>
                                                        <th>URAIAN KEGIATAN</th>
                                                        <th>STATUS</th>
                                                        <th>AKSI</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1.</td>
                                                        <td>16-02-2020</td>
                                                        <td>
                                                            Lorem ipsum dolor sit amet.
                                                        </td>
                                                        <td>
                                                            <span class="badge bg-success">selesai</span>
                                                        </td>
                                                        <td>
                                                            <a href="#" type="button" class="btn btn-info btn-xs tombol pb-0" style="background-color: #E18939; border:none;"><i class="fas fa-eye"></i></a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- /.card-body -->
                                        <div class="card-footer clearfix">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <p>Menampilkan 6 data dari 33</p>
                                                </div>
                                                <div class="col-md-6">
                                                    <ul class="pagination pagination-sm m-0 float-right">
                                                        <li class="page-item">
                                                            <a class="page-link" href="#">&laquo;</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#">1</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#">2</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#">3</a>
                                                        </li>
                                                        <li class="page-item">
                                                            <a class="page-link" href="#">&raquo;</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h4>Daftar Pegawai</h4>
                        </div>
                        <div class="col-md-2"></div>
                        <form class="col-md-4">
                            <div class="input-group">
                                <select class="form-control mr-2" style="border-radius: 5px;">
                                    <option selected disabled>- Pilih Bidang -</option>
                                    <option>Admin</option>
                                    <option>User</option>
                                    <option>Super Admin</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <form class="input-group input-group-md pt-3 px-4" style="width: 250px">
                                    <input type="search" name="table_search" class="form-control float-right" placeholder="Search" />
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>

                                <!-- /.card-header -->
                                <div class="card-body table-responsive px-4">
                                    <table class="table table-hover text-nowrap">
                                        <thead>
                                            <tr>
                                                <th>NO.</th>
                                                <th>USERNAME</th>
                                                <th>ROLE</th>
                                                <th>AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.</td>
                                                <td>John Doe</td>
                                                <td>
                                                    Administrasi
                                                </td>
                                                <td>
                                                    <a href="#" type="button" class="btn btn-info btn-xs tombol pb-0" style="background-color: #E18939; border:none;"><i class="fas fa-plus"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2.</td>
                                                <td>David M. Adams</td>
                                                <td>
                                                    Regular User
                                                </td>
                                                <td>
                                                    <a href="#" type="button" class="btn btn-info btn-xs tombol pb-0" style="background-color: #E18939; border:none;"><i class="fas fa-plus"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer clearfix">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p>Menampilkan 6 data dari 33</p>
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="pagination pagination-sm m-0 float-right">
                                                <li class="page-item">
                                                    <a class="page-link" href="#">&laquo;</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">1</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">2</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">3</a>
                                                </li>
                                                <li class="page-item">
                                                    <a class="page-link" href="#">&raquo;</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<?= $this->endSection(); ?>