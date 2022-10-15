<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Kelola Level</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Kelola Level</li>
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
                                        <th>LEVEL/ROLE</th>
                                        <th>HAK AKSES</th>
                                        <th>AKSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($list_level as $level) : ?>
                                        <tr>
                                            <td><?= $level['nama_level']; ?>
                                            <td><a href="<?= base_url('/editKelolaLevel/' . $level['id']) ?>" type="button" class="btn btn-info btn-xs tombol" style="background-color: #3c4b64; border:none;">Edit Hak Akses</a></td>
                                            <td>
                                                <button id="btn-edit" type="button" class="btn btn-info btn-xs tombol" style="background-color: #2D95C9; border:none;" data-toggle="modal" data-id="<?= $level["id"] ?>" data-nama_level="<?= $level["nama_level"] ?>" data-target="#modal-edit"><i class="fas fa-pen"></i></button>
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
    <!-- MODAL HAK AKSES -->
    <div class="modal fade" id="<?= $id_modal; ?>" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-scrollable modal-xl">
            <form action="<?= base_url('/updateKelolaLevel/' . $level_id) ?>" method="POST" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Hak Akses Menu</h4>
                    <a href="<?= base_url('/kelolaLevel') ?>" type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="card-body table-responsive p-0">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                    <tr class="kepala-tabel">
                                        <th style="width: 10px">NO.</th>
                                        <th>MENU</th>
                                        <th style="width: 60px">VIEW</th>
                                        <th style="width: 60px">ADD</th>
                                        <th style="width: 60px">EDIT</th>
                                        <th style="width: 60px">DELETE</th>
                                        <th style="width: 60px">PRINT</th>
                                        <th style="width: 60px">UPLOAD</th>
                                    </tr>
                                </thead>
                                <tbody>



                                    <?php for ($i = 0; $i < count($list_menu); $i++) : ?>
                                        <?php $hiddenMenu = '' ?>

                                        <?php if ($list_menu[$i]['is_active'] == 'N') {
                                            $hiddenMenu = 'sembunyi';
                                        } ?>

                                        <tr class="<?= $hiddenMenu; ?>">
                                            <td class="sel-menu"><strong><?= $list_menu[$i]['id']; ?></strong></td>
                                            <td class="sel-menu"><strong><?= $list_menu[$i]['nama_menu']; ?></strong></td>
                                            <td class="sel">
                                                <label for="view<?= $i; ?>" class="ikon-sel">
                                                    <input class="d-none" type="checkbox" name="view<?= $i; ?>" id="view<?= $i; ?>" <?= $list_menu[$i]['view_level'] == 'Y' ? 'checked' : ''; ?> />
                                                    <i class="far <?= $list_menu[$i]['view_level'] == 'Y' ? 'fa-check-circle text-green' : 'fa-times-circle text-red'; ?>"></i>
                                                </label>
                                            </td>
                                            <td class="sel sel-disabled">

                                            </td>
                                            <td class="sel sel-disabled">

                                            </td>
                                            <td class="sel sel-disabled">

                                            </td>
                                            <td class="sel sel-disabled">

                                            </td>
                                            <td class="sel sel-disabled">

                                            </td>
                                        </tr>

                                        <?php for ($j = 0; $j < count($list_submenu); $j++) : ?>
                                            <?php $hiddenSubmenu = '' ?>
                                            <?php if ($list_submenu[$j]['menu_id'] == $list_menu[$i]['id']) : ?>
                                                <?php if ($list_submenu[$j]['is_active'] == 'N') {
                                                    $hiddenSubmenu = 'sembunyi';
                                                } ?>

                                                <tr class="<?= $hiddenSubmenu; ?>">
                                                    <td></td>
                                                    <td><?= $list_submenu[$j]['nama_submenu']; ?></td>
                                                    <td class="sel">
                                                        <label for="view_submenu<?= $j; ?>" class="ikon-sel">
                                                            <input class="d-none" type="checkbox" name="view_submenu<?= $j; ?>" id="view_submenu<?= $j; ?>" <?= $list_submenu[$j]['view_level'] == 'Y' ? 'checked' : ''; ?> />
                                                            <i class="far <?= $list_submenu[$j]['view_level'] == 'Y' ? 'fa-check-circle text-green' : 'fa-times-circle text-red'; ?>"></i>
                                                        </label>
                                                    </td>
                                                    <td class="sel">
                                                        <label for="add_submenu<?= $j; ?>" class="ikon-sel">
                                                            <input class="d-none" type="checkbox" name="add_submenu<?= $j; ?>" id="add_submenu<?= $j; ?>" <?= $list_submenu[$j]['add_level'] == 'Y' ? 'checked' : ''; ?> />
                                                            <i class="far <?= $list_submenu[$j]['add_level'] == 'Y' ? 'fa-check-circle text-green' : 'fa-times-circle text-red'; ?>"></i>
                                                        </label>
                                                    </td>
                                                    <td class="sel">
                                                        <label for="edit_submenu<?= $j; ?>" class="ikon-sel">
                                                            <input class="d-none" type="checkbox" name="edit_submenu<?= $j; ?>" id="edit_submenu<?= $j; ?>" <?= $list_submenu[$j]['edit_level'] == 'Y' ? 'checked' : ''; ?> />
                                                            <i class="far <?= $list_submenu[$j]['edit_level'] == 'Y' ? 'fa-check-circle text-green' : 'fa-times-circle text-red'; ?>"></i>
                                                        </label>
                                                    </td>
                                                    <td class="sel">
                                                        <label for="delete_submenu<?= $j; ?>" class="ikon-sel">
                                                            <input class="d-none" type="checkbox" name="delete_submenu<?= $j; ?>" id="delete_submenu<?= $j; ?>" <?= $list_submenu[$j]['delete_level'] == 'Y' ? 'checked' : ''; ?> />
                                                            <i class="far <?= $list_submenu[$j]['delete_level'] == 'Y' ? 'fa-check-circle text-green' : 'fa-times-circle text-red'; ?>"></i>
                                                        </label>
                                                    </td>
                                                    <td class="sel">
                                                        <label for="print_submenu<?= $j; ?>" class="ikon-sel">
                                                            <input class="d-none" type="checkbox" name="print_submenu<?= $j; ?>" id="print_submenu<?= $j; ?>" <?= $list_submenu[$j]['print_level'] == 'Y' ? 'checked' : ''; ?> />
                                                            <i class="far <?= $list_submenu[$j]['print_level'] == 'Y' ? 'fa-check-circle text-green' : 'fa-times-circle text-red'; ?>"></i>
                                                        </label>
                                                    </td>
                                                    <td class="sel">
                                                        <label for="upload_submenu<?= $j; ?>" class="ikon-sel">
                                                            <input class="d-none" type="checkbox" name="upload_submenu<?= $j; ?>" id="upload_submenu<?= $j; ?>" <?= $list_submenu[$j]['upload_level'] == 'Y' ? 'checked' : ''; ?> />
                                                            <i class="far <?= $list_submenu[$j]['upload_level'] == 'Y' ? 'fa-check-circle text-green' : 'fa-times-circle text-red'; ?>"></i>
                                                        </label>
                                                    </td>
                                                </tr>
                                            <?php endif; ?>

                                        <?php endfor; ?>


                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>

                    </div>
                    <!-- /.card-body -->
                </div>
                <div class="modal-footer justify-content-between">

                    <a href="<?= base_url('/kelolaLevel') ?>" type="button" class="btn btn-default"> Tutup</a>

                    <button type="submit" class="btn btn-info tombol" style="background-color: #3c4b64; border:none;">Simpan</button>
                </div>
            </form>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


    <!-- MODAL TAMBAH LEVEL -->
    <div class="modal fade" style="padding-top: 13%;" id="modal-tambah">
        <div class="modal-dialog">
            <form action="<?= base_url('/saveLevel') ?>" method="POST" class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Level</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Level</label>
                        <input type="nama_level" name="nama_level" class="form-control" placeholder="Nama Level ...">
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

    <!-- MODAL EDIT LEVEL -->
    <div class="modal fade" style="padding-top: 13%;" id="modal-edit">
        <div class="modal-dialog">
            <form action="<?= base_url("/updateNamaLevel") ?>" method="POST" class="modal-content">
                <input type="text" name="id_level" id="id_level" class="d-none">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Level</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Level</label>
                        <input type="nama_level" name="nama_level" id="nama_level" class="form-control">
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
<script>
    $(document).ready(function() {
        $('input[type="checkbox"]').change(function() {
            if ($(this).prop('checked') == true) {
                $(this).siblings().addClass('fa-check-circle text-green').removeClass('fa-times-circle text-red')
            } else if ($(this).prop('checked') == false) {
                $(this).siblings().removeClass('fa-check-circle text-green').addClass('fa-times-circle text-red')
            }
        })
    })
</script>

<script>
    //Mengambil Data edit dengan menggunakan Jquery
    $(document).on('click', '#btn-edit', function() {
        $('#id_level').val($(this).data('id'));
        $('#nama_level').val($(this).data('nama_level'));
    })
</script>

<script>
    $(document).ready(function() {
        $('#modal-hakAkses').modal('show');
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