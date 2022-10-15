<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <link rel="stylesheet" href="<?= base_url('/plugins/fontawesome-free/css/all.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/dist/css/adminlte.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('/plugins/daterangepicker/daterangepicker.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('/plugins/fullcalendar/main.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/plugins/toastr/toastr.min.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>">
  <link rel="stylesheet" href="<?= base_url('/plugins/summernote/summernote-bs4.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('/css/jquery-ui.min.css') ?>">

  <link rel=" stylesheet" href="<?= base_url('/css/custom.css') ?>" />
  <link rel="stylesheet" href="<?= base_url('/css/trix.css') ?>" />
  <script src="<?= base_url('/js/trix.js') ?>"></script>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="icon" type="image/x-icon" href="<?= base_url('/images/bps.png') ?>">
  <title><?= $title; ?></title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

    <nav class="main-header navbar navbar-expand navbar-white navbar-light">

      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
      </ul>


      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>
        <li class="nav-item dropdown">
          <a href="#" class="nav-link" data-toggle="dropdown"><?= session('fullname'); ?><i class="right fas fa-angle-down" style="margin-left: 10px"></i> </a>
          <div class="dropdown-menu dropdown-menu-md">
            <a href="<?= base_url('/profile') ?>" class="dropdown-item">
              <i class="fas fa-user mr-2"></i> Profile
            </a>
            <div class="dropdown-divider"></div>
            <?php $list_level = session('list_user_level') ?>
            <?php foreach ($list_level as $list) : ?>
              <form action="<?= base_url('/switchLevel') ?>" method="POST">
                <input type="text" name="id" id="id" value="<?= $list['level_id']; ?>" class="d-none">
                <button type="submit" class="dropdown-item roles <?= ($list['level_id'] == session('level_id')) ? 'aktif' : '' ?>"><?= $list['nama_level']; ?></button>
              </form>
            <?php endforeach; ?>
            <div class="dropdown-divider"></div>
            <a href="<?= base_url('/logout') ?>" class="dropdown-item">
              <i class="fas fa-sign-out-alt mr-2"></i> Logout
            </a>
          </div>
        </li>
      </ul>
    </nav>

    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background-color: #3c4b64;">
      <a href=" <?= base_url('/dashboard') ?>" class="brand-link w-100 d-flex justify-content-center align-content-center" style="border: none">
        <span class="brand-text font-weight-light"><img src="<?= base_url('images/BPS.png') ?>" class="mt-3" alt="Logo BPS" style="width: 100px;" /></span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 d-flex"></div>
        <div class="form-inline mt-3">
          <div class="input-group" data-widget="sidebar-search">
            <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search" style="background-color: #4D5F7C; border: none;" />
            <div class="input-group-append">
              <button class="btn btn-sidebar" style="background-color: #3A4B68;">
                <i class="fas fa-search fa-fw"></i>
              </button>
            </div>
          </div>
        </div>


        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <?php $list_menu = session('list_menu') ?>
            <?php $angle = '#' ?>
            <?php $list_submenu = session('list_submenu') ?>
            <?php foreach ($list_menu as $list) : ?>
              <?php if ($list['is_active'] == 'Y' && $list['view_level'] == 'Y') : ?>
                <li class="nav-item <?= ($menu == $list['nama_menu']) ? 'menu-open' : '' ?>">
                  <a href="<?= base_url($list['link']); ?>" class="nav-link <?= ($menu == $list['nama_menu']) ? 'active' : '' ?>">
                    <i class="nav-icon <?= $list['icon']; ?>"></i>
                    <p><?= $list['nama_menu']; ?>
                      <?php foreach ($list_submenu as $sub) {
                        if ($sub['menu_id'] == $list['id'])
                          $angle = 'right fas fa-angle-left';
                      }  ?>
                      <i class="<?= $angle; ?>"></i>
                    </p>
                  </a>
                  <?php if ($angle != '#') : ?>
                    <ul class="nav nav-treeview">
                      <?php foreach ($list_submenu as $sub) : ?>
                        <?php if (($sub['menu_id'] == $list['id']) && $sub['is_active'] == 'Y' && $sub['view_level'] == 'Y') :  ?>
                          <li class="nav-item">
                            <a href="<?= base_url($sub['link']); ?>" class="nav-link <?= ($subMenu == $sub['nama_submenu']) ? 'active' : '' ?>">
                              <i class="far fa-circle nav-icon"></i>
                              <p><?= $sub['nama_submenu']; ?></p>
                            </a>
                          </li>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </ul>
                  <?php endif; ?>
                </li>
              <?php endif; ?>
            <?php endforeach; ?>
        </nav>
      </div>
    </aside>


    <script src="<?= base_url('/plugins/jquery/jquery.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/datatables-responsive/js/dataTables.responsive.min.js') ?>"></script>
    <div>
      <?= $this->renderSection('content'); ?>
    </div>

    <footer class="main-footer">
      <strong>Copyright &copy; Magang 2022. </strong>
      All rights reserved.
      <div class="float-right d-none d-sm-inline-block">
        <b>Powered by</b> <a target="_blank" href="https://adminlte.io">AdminLTE.io</a>
      </div>
    </footer>
    <script src="<?= base_url('/plugins/jquery-ui/jquery-ui.min.js') ?>"></script>
    <script>
      $.widget.bridge('uibutton', $.ui.button);
    </script>
    <script src="<?= base_url('/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/chart.js/Chart.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/moment/moment.min.js') ?>"></script>
    <script src="<?= base_url('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') ?>"></script>
    <script src="<?= base_url('/dist/js/adminlte.js') ?>"></script>
    <script src="<?= base_url('/dist/js/demo.js') ?>"></script>
</body>

</html>