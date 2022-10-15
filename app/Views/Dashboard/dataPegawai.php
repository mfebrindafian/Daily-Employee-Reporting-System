<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 fw-bold">Dashboard Kepegawaian</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/dashboard') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6 widget" style="cursor: pointer;">
                    <!-- small box -->
                    <div class="small-box  bg-white" style="border: 1px solid gray; padding: 0;">
                        <div class="inner" style="color: #55415C; padding-left: 15px;">
                            <h3 style="font-size: 70px;"><?= $total_pegawai; ?></h3>
                            <p style="font-weight: bold;">Total Pegawai</p>
                        </div>
                        <!-- <a href="" class="selanjutnya">
                            <p style="margin:0;">More info</p> <i class="fas fa-arrow-circle-down"></i>
                        </a> -->
                        <span href="#" class="selanjutnya">
                            <p style="margin:0;">&nbsp;</p>
                        </span>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6 widget" style="cursor: pointer;">
                    <!-- small box -->
                    <div class="small-box bg-white" style="border: 1px solid gray; padding: 0;">
                        <div class="inner" style="color: #55415C; padding-left: 15px;">

                            <h3 style="font-size: 70px;"><?= $total_tb; ?></h3>

                            <p style="font-weight: bold;">Pegawai Tugas Belajar</p>
                        </div>
                        <!-- <a href="#" data-toggle="modal" data-target="#modal-list-laporan" class="selanjutnya">
                            <p style="margin:0;">More info</p> <i class="fas fa-arrow-circle-down"></i>
                        </a> -->
                        <span href="#" class="selanjutnya">
                            <p style="margin:0;">&nbsp;</p>
                        </span>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6 widget" style="cursor: pointer;">
                    <!-- small box -->
                    <div class="small-box bg-white" style="border: 1px solid gray; padding: 0;">
                        <div class="inner" style="color: #55415C; padding-left: 15px;">
                            <h3 style="font-size: 70px;"><?= $total_pegawai_aktif; ?></h3>

                            <p style="font-weight: bold;">Jumlah Pegawai Aktif</p>
                        </div>
                        <span href="#" class="selanjutnya">
                            <p style="margin:0;">&nbsp;</p>
                        </span>

                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6 widget" style="cursor: pointer;">
                    <!-- small box -->
                    <div class="small-box bg-white" style="border: 1px solid gray; padding: 0;">
                        <div class="inner" style="color: #55415C; padding-left: 15px;">
                            <h3 style="font-size: 70px;"><?= $jumlah_user; ?></h3>

                            <p style="font-weight: bold;">Jumlah User</p>
                        </div>
                        <span href="#" class="selanjutnya">
                            <p style="margin:0;">&nbsp;</p>
                        </span>
                    </div>
                </div>

                <!-- ./col -->
            </div>
            <hr>
            <!-- /.row -->
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row mb-3">
                <div class="col-3">
                    <div class="input-group">
                        <form action="" method="GET">
                            <select class="form-control filter mr-2" name="satker_choose" id="satker_choose" style="border-radius: 5px;">
                                <option selected value="">- Satuan Kerja -</option>
                                <?php if ($list_satker != null) : ?>
                                    <?php foreach ($list_satker as $satker) : ?>
                                        <option value="<?= $satker['kd_satker']; ?>">[<?= $satker['kd_satker'];  ?>] <?= $satker['satker']; ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <button id="btn-submit" class="d-none" type="submit">test</button>
                        </form>
                    </div>
                </div>
                <div class="col-2 d-flex align-items-center">
                    <a href="<?= base_url('/dataPegawai') ?>" class="py-1 rounded reset-satker d-none" style=" color: #db9a9a; border: 2px solid #db9a9a; background-color: #ffdbdb; padding: 12px;"><i class="fas fa-times"></i></a>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h6 class="text-center"><strong>Pegawai Berdasarkan Pendidikan</strong></h6>
                        </div>
                        <div class="card-body">
                            <canvas id="barChartPendidikan" style="min-height: 250px;  height: 250px;  max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 d-flex justify-content-center align-items-center">
                                    <img class="img-fluid rounded" style="width: 100%;" src="<?= base_url('/images/bps.png') ?>">
                                </div>
                                <div class="col-md-4"></div>
                                <div class="col-md-4 d-flex justify-content-center align-items-center flex-column" style="min-height: 313px;  height: 313px;  max-height: 313px;">
                                    <h6>DATABASE PEGAWAI</h6>
                                    <h2 class="fa-3x"><strong id="jam"></strong></h2>
                                    <h6 id="hari-ini"></h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h6 class="text-center"><strong>Pegawai Berdasarkan Jenis kelamin</strong></h6>
                        </div>
                        <div class="card-body">
                            <canvas id="donutChart" style="min-height: 250px;  height: 250px;  max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h6 class="text-center"><strong>Pegawai Berdasarkan Golongan</strong></h6>
                        </div>
                        <div class="card-body">
                            <canvas id="barChartGolongan" style="min-height: 250px;  height: 250px;  max-height: 250px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header border-0 pt-4">
                            <h6 class="text-center"><strong>Pegawai Berdasarkan Jabatan Fungsional</strong></h6>
                        </div>
                        <div class="card-body">
                            <canvas id="barChartFungsional" style="min-height: 250px;  height:800px;  max-height: 1000px; max-width: 100%;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- /.content -->
</div>
<!-- ChartJS -->
<script src="<?= base_url('/plugins/chart.js/Chart.min.js') ?>"></script>
<script src="<?= base_url('/js/tanggal.js') ?>"></script>
<!-- BARCHART -->
<script>
    var areaChartData = {
        labels: [
            <?php if ($list_pendidikan != null) : ?>
                <?php foreach ($list_pendidikan as $pendidikan) : ?> "<?= $pendidikan['tk_pendidikan']; ?>",
                <?php endforeach; ?>
            <?php endif; ?>
        ],
        datasets: [{
            backgroundColor: "#3c4b64",
            data: [
                <?php if ($pdd != null) : ?>
                    <?php for ($pd = 0; $pd < count($pdd); $pd++) : ?>
                        <?= $pdd[$pd]; ?>,
                    <?php endfor ?>
                <?php endif; ?>

                , 0
            ],
        }],
    };

    var golonganChartData = {
        labels: [
            <?php if ($list_golongan != null) : ?>
                <?php foreach ($list_golongan as $golongan) : ?> "<?= $golongan['golongan']; ?>",
                <?php endforeach; ?>
            <?php endif; ?>
        ],
        datasets: [{
            backgroundColor: "#3c4b64",
            data: [<?php if ($gol != null) : ?>
                    <?php for ($g = 0; $g < count($gol); $g++) : ?>
                        <?= $gol[$g]; ?>,
                    <?php endfor ?>
                <?php endif; ?>
            ],
        }],
    };

    var fungsionalChartData = {
        labels: [
            <?php if ($list_fungsional != null) : ?>
                <?php foreach ($list_fungsional as $fungsional) : ?> "<?= $fungsional['jabatan_fungsional']; ?>",


                <?php endforeach; ?>
            <?php endif; ?>
        ],
        datasets: [{

            backgroundColor: "#3c4b64",
            data: [<?php if ($total_fungsional != null) : ?>
                    <?php for ($f = 0; $f < count($total_fungsional); $f++) : ?>
                        <?= $total_fungsional[$f]; ?>,
                    <?php endfor ?>
                <?php endif; ?>
            ],
        }],
    };

    var barChartPendidikanCanvas = $("#barChartPendidikan").get(0).getContext("2d");
    var barChartGolonganCanvas = $("#barChartGolongan").get(0).getContext("2d");
    var barChartFungsionalCanvas = $("#barChartFungsional").get(0).getContext("2d");

    var barChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        datasetFill: false,
        legend: false,
        scales: {
            xAxes: [{
                display: true,
                gridLines: {
                    display: false,
                },
            }, ],
            yAxes: [{
                display: true,
                gridLines: {
                    display: true,
                }
            }, ],
        },
    };

    new Chart(barChartPendidikanCanvas, {
        type: "bar",
        data: areaChartData,
        options: barChartOptions,
    });
    new Chart(barChartGolonganCanvas, {
        type: "bar",
        data: golonganChartData,
        options: barChartOptions,
    });
    new Chart(barChartFungsionalCanvas, {
        type: "horizontalBar",
        data: fungsionalChartData,
        options: barChartOptions,
    });
</script>

<!-- DONUT -->
<script>
    var donutChartCanvas = $("#donutChart").get(0).getContext("2d");
    var donutData = {
        labels: ["Laki-laki", "Perempuan"],
        datasets: [{
            data: [<?php if ($jk != null) : ?>

                    <?= $jk[0]; ?>, <?= $jk[1]; ?>
                <?php endif; ?>
            ],
            backgroundColor: [
                "#3c4b64",
                "#e3bfe0",
            ],
        }, ],
    };
    var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
        legend: {
            position: 'bottom'
        }
    };
    new Chart(donutChartCanvas, {
        type: "doughnut",
        data: donutData,
        options: donutOptions,
    });


    let searchParams = new URLSearchParams(window.location.search)
    searchParams.has('satker_choose') // true

    if (searchParams.has('satker_choose')) {
        $('.reset-satker').removeClass('d-none')
    }
    let param = searchParams.get('satker_choose')
    $('#satker_choose').val(param)
    $(document).on('change', '#satker_choose', function() {
        $('#btn-submit').click()

        $(this).val()
    })


    var date = new Date();

    var currentDate = '<?php

                        use CodeIgniter\I18n\Time;

                        $myTime = Time::today('Asia/Jakarta');
                        echo $myTime->toLocalizedString('yyyy-MM-dd');
                        ?>';
    document.getElementById('hari-ini').value = currentDate;

    $('#hari-ini').html(ubahFormatTanggal(currentDate))

    setInterval(customClock, 500);

    function customClock() {
        var time = new Date();
        var hrs = (time.getHours() < 10 ? '0' : '') + time.getHours();
        var min = (time.getMinutes() < 10 ? '0' : '') + time.getMinutes();
        var sec = time.getSeconds();

        document.getElementById('jam').innerHTML = hrs + ":" + min + " WIB";
    }
</script>


<?= $this->endSection(); ?>