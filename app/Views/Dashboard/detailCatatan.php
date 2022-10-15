<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Detail Catatan</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Detail Catatan</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6 d-flex align-items-center">
                                    <h5><strong>Catatan Diterima</strong></h5>
                                </div>
                                <div class="col-md-6 py-1">
                                    <div>
                                        <div id="tabelData_filter" class="input-group input-group-md float-right" style="width: 250px">
                                            <input type="search" id="pencarian1" class="form-control float-right auto_search" placeholder="Search ..." />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-hover " id="tabelData1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Pengirim</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($list_catatan != NULL) : ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($list_catatan as $catatan) : ?>
                                            <?php if ($catatan['tipe_catatan'] == '2' && $catatan['id_penerima'] == session(('user_id'))) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <?php $tgl1 = $catatan['tgl'];
                                                    $tgl2 = explode('-', $tgl1);
                                                    $tgl3 = $tgl2[2] . '-' . $tgl2[1] . '-' . $tgl2[0] ?>
                                                    <td><?= $tgl3; ?></td>
                                                    <td><?= $catatan['pengirim']; ?> </td>
                                                    <td><?= $catatan['catatan'] ?></td>
                                                </tr>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6 d-flex align-items-center">
                                    <h5><strong>Catatan Dikirim</strong></h5>
                                </div>
                                <div class="col-md-6 py-1">
                                    <div>
                                        <div id="tabelData_filter" class="input-group input-group-md float-right" style="width: 250px">
                                            <input type="search" id="pencarian2" class="form-control float-right auto_search" placeholder="Search ..." />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-hover " id="tabelData2">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Penerima</th>
                                        <th>Catatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($list_catatan != NULL) : ?>
                                        <?php $no = 1; ?>
                                        <?php foreach ($list_catatan as $catatan) : ?>
                                            <?php if ($catatan['tipe_catatan'] == '2' && $catatan['id_penerima'] != session(('user_id'))) : ?>
                                                <tr>
                                                    <td><?= $no++ ?></td>
                                                    <?php $tgl1 = $catatan['tgl'];
                                                    $tgl2 = explode('-', $tgl1);
                                                    $tgl3 = $tgl2[2] . '-' . $tgl2[1] . '-' . $tgl2[0] ?>
                                                    <td><?= $tgl3; ?></td>
                                                    <td><?= $catatan['penerima']; ?>
                                                    </td>
                                                    <td><?= $catatan['catatan'] ?></td>
                                                </tr>
                                            <?php endif; ?>
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


<script>
    $('#tabelData1').DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        responsive: true,
        ordering: true,
        info: true,
        autoWidth: false,
        pageLength: 15,
    });

    $(document).ready(function() {
        $('#tabelData1').DataTable().search($('#pencarian1').val()).draw();
    });

    $('#tabelData1_wrapper').children().first().addClass('d-none');
    $('.dataTables_paginate').addClass('Pager2').addClass('float-right');
    $('.dataTables_info').addClass('text-sm text-gray py-2');
    $('.dataTables_paginate').parent().parent().addClass('card-footer clearfix');

    $(document).on('keyup', '#pencarian1', function() {
        $('#tabelData1').DataTable().search($('#pencarian1').val()).draw();
    });


    $('#tabelData2').DataTable({
        paging: true,
        lengthChange: false,
        searching: true,
        responsive: true,
        ordering: true,
        info: true,
        autoWidth: false,
        pageLength: 15,
    });

    $(document).ready(function() {
        $('#tabelData2').DataTable().search($('#pencarian2').val()).draw();
    });

    $('#tabelData2_wrapper').children().first().addClass('d-none');
    $('.dataTables_paginate').addClass('Pager2').addClass('float-right');
    $('.dataTables_info').addClass('text-sm text-gray py-2');
    $('.dataTables_paginate').parent().parent().addClass('card-footer clearfix');

    $(document).on('keyup', '#pencarian2', function() {
        $('#tabelData2').DataTable().search($('#pencarian2').val()).draw();
    });
</script>
<?= $this->endSection(); ?>