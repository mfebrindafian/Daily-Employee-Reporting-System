<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Menu</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Menu</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- TABLE HEADER-->
            <div class="card card-primary card-outline" style="border: #3c4b64;">
                <div class="card-body box-profile">
                    <div class="row">
                        <form method="" action="" class="col-md-5 py-1">
                            <div class="float-left">
                                <div class="input-group">
                                    <button type="button" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;" data-toggle="modal" data-target="#modal-tambah"><i class="fas fa-plus mr-2"></i> Tambah</button>

                                </div>
                            </div>
                        </form>
                        <div class="col-md-1">
                        </div>
                        <div class="col-md-6 py-1">
                            <div class="input-group input-group-md float-right" style="width: 250px">
                                <input type="text" id="pencarian" name="table_search" class="form-control float-left" placeholder="Search ..." />
                            </div>
                        </div>


                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0 overflow-hidden">
                            <table class="table table-hover text-nowrap" id="tabelData">
                                <thead>
                                    <tr>
                                        <th>NAMA MENU</th>
                                        <th>LINK</th>
                                        <th>ICON</th>
                                        <th>URUTAN</th>
                                        <th>IS ACTIVE</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <?php foreach ($list_menu as $list) :  ?>
                                        <tr>
                                            <td><?= $list['nama_menu']; ?></td>
                                            <td><?= $list['link']; ?></td>
                                            <td>
                                                <?= $list['icon']; ?>
                                            </td>
                                            <td><?= $list['urutan']; ?></td>
                                            <td>
                                                <?php if ($list['is_active'] == 'Y') {

                                                    echo '<span class="badge bg-success">active</span>';
                                                } else {
                                                    echo '<span class="badge bg-danger">non-active</span>';
                                                } ?>
                                            </td>
                                            <td>
                                                <button id="btn-edit" type="button" class="btn btn-info btn-xs tombol" style="background-color: #2D95C9; border:none;" data-toggle="modal" data-target="#modal-edit" data-id="<?= $list['id'] ?>" data-nama_menu="<?= $list['nama_menu'] ?>" data-link="<?= $list['link'] ?>" data-icon="<?= $list['icon'] ?>" data-urutan="<?= $list['urutan'] ?>" data-is_active="<?= $list['is_active'] ?>"><i class="fas fa-pen"></i></button>

                                            </td>
                                        </tr>
                                    <?php endforeach; ?>


                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
        </div>
    </section>




    <!-- MODAL TAMBAH MENU -->
    <div class="modal fade" id="modal-tambah">
        <div class="modal-dialog">
            <form action="<?= base_url('/saveMenu') ?>" method="POST" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Menu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="nama_menu" name="nama_menu" class="form-control" placeholder="Nama Menu ...">
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" name="link" class="form-control" placeholder="Link ...">
                    </div>
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="text" name="icon" class="form-control" placeholder="Nama Icon ...">
                    </div>
                    <div class="form-group">
                        <label>Urutan</label>
                        <input type="number" name="urutan" class="form-control" placeholder="Urutan ...">
                    </div>
                    <div class="form-group">
                        <label>Is Active</label>
                        <select name="is_active" class="form-control mr-2" style="border-radius: 5px;">
                            <option selected disabled>- Is Active -</option>
                            <option value="Y">Active</option>
                            <option value="N">Non-active</option>
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




    <!-- MODAL EDIT MENU -->

    <div class="modal fade" id="modal-edit">
        <div class="modal-dialog">
            <form action="<?= base_url('/updateMenu') ?>" method="POST" class="modal-content">
                <input type="text" name="id" id="id_menu" class="d-none form-control">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Menu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div id="modal" class="modal-body">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="nama_menu" id="nama_menu" name="nama_menu" class="form-control" placeholder="Nama Menu ...">
                    </div>
                    <div class="form-group">
                        <label>Link</label>
                        <input type="text" id="link" name="link" class="form-control" placeholder="Link ...">
                    </div>
                    <div class="form-group">
                        <label>Icon</label>
                        <input type="text" id="icon" name="icon" class="form-control" placeholder="Icon ...">
                    </div>
                    <div class="form-group">
                        <label>Urutan</label>
                        <input type="number" id="urutan" name="urutan" class="form-control" placeholder="Urutan ...">
                    </div>
                    <div class="form-group">
                        <label>Is Active</label>
                        <select id="is_active" name="is_active" class="form-control mr-2" style="border-radius: 5px;">
                            <option value="Y">Active</option>
                            <option value="N">Non-active</option>
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
</div>
<!-- SweetAlert2 -->
<script src="<?= base_url('/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
<script>
    // Mengambil Data edit dengan menggunakan Jquery
    $(document).on('click', '#btn-edit', function() {
        $('#id_menu').val($(this).data('id'));
        $('#nama_menu').val($(this).data('nama_menu'));
        $('#urutan').val($(this).data('urutan'));
        $('#icon').val($(this).data('icon'));
        $('#link').val($(this).data('link'));
        $('#menu_id').val($(this).data('menu_id'));
        $('#is_active').val($(this).data('is_active'));
    })
    // $(document).on('click', '#btn-edit', function() {
    //     console.log($(this).data('id'));
    // })
</script>

<!-- ALERT BERHASIL -->
<script>
    $(document).ready(function() {
        <?php if (session()->getFlashdata('pesan')) { ?>
            Swal.fire({
                position: 'top-end',
                title: "<?= session()->getFlashdata('pesan') ?>",
                icon: "<?= session()->getFlashdata('pesan_icon') ?>",
                showConfirmButton: false,
                timer: 1500,
            });
        <?php } ?>
    });
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
<?= $this->endSection(); ?>