<?php if ($data_user != null) : ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= base_url('/plugins/fontawesome-free/css/all.min.css') ?>" />
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= base_url('/dist/css/adminlte.min.css') ?>" />
        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="<?= base_url('/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
        <!-- Toastr -->
        <link rel="stylesheet" href="<?= base_url('/plugins/toastr/toastr.min.css') ?>" />

        <link rel="icon" type="image/x-icon" href="<?= base_url('/images/bps.png') ?>">
        <style>
            .password {
                position: relative;
            }

            .pw-eye {
                position: absolute;
                top: 30%;
                right: 10px;
                cursor: pointer;
            }

            .pw-eye:hover {
                color: gray;
            }

            i {
                font-size: 14px;
            }
        </style>
        <title>Ganti Password</title>
    </head>

    <body style="background-color: #e3ecfa" class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="row">
            <form action="<?= base_url('gantiPasswordDefault'); ?>" method="post" class="col-md-12 bg-white shadow-lg rounded py-4 px-4" style="width: 400px;">
                <input type="hidden" name="user_id" id="user_id" value="<?= $data_user['id'] ?>">
                <h4><strong>Ganti Password</strong></h4>
                <p class="mb-4"><i class="text-gray">Password masih default. Silahkan Ganti Password!</i></p>
                <div class="form-group">
                    <label>Password Baru</label>
                    <div class="password">
                        <input type="password" id="password_baru" name="password_baru" class="form-control" placeholder="Password baru ..." required>
                        <i name="eye" class="fas fa-eye pw-eye" id="togglePassword"></i>
                    </div>
                    <span id='message_baru'></span>
                </div>
                <div class="form-group">
                    <label>Konfirmasi Password Baru</label>
                    <div class="password">
                        <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Konfirmasi password ..." required>
                        <i name="eye" class="fas fa-eye pw-eye" id="togglePassword"></i>
                    </div>
                    <span id='message'></span>
                </div>
                <button type="submit" id="liveAlertBtn" class="btn btn-primary button fw-semibold float-right">Ganti</button>
            </form>
        </div>



        <!-- Bootstrap 4 -->
        <script src="<?= base_url('/plugins/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
        <!-- jQuery -->
        <script src="<?= base_url('/plugins/jquery/jquery.min.js') ?>"></script>
        <script src="<?= base_url('/plugins/sweetalert2/sweetalert2.min.js') ?>"></script>
        <!-- Toastr -->
        <script src="<?= base_url('/plugins/toastr/toastr.min.js') ?>"></script>
        <script>
            $(document).on('click', "#togglePassword", function() {
                $(this).toggleClass("fa-eye fa-eye-slash");
                input = $(this).parent().find("input");
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            $(document).ready(function() {
                <?php if ($alert == true) { ?>
                    Swal.fire({

                        title: "Password Tidak Cocok!",
                        icon: "warning",
                        showConfirmButton: true
                    });
                <?php } ?>
            });
        </script>

        <script>
            $('#password_baru, #confirm_password').on('keyup', function() {

                if ($('#password_baru').val() == $('#confirm_password').val()) {
                    $('#message').html('Password baru cocok').css('color', 'green');
                } else
                    $('#message').html('Password baru belum cocok').css('color', 'red');
            });
        </script>
    </body>

    </html>
<?php endif; ?>