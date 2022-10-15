<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Andika:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="<?= base_url('/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') ?>">
    <!-- Toastr -->
    <link rel="stylesheet" href="<?= base_url('/plugins/toastr/toastr.min.css') ?>" />
    <link rel="stylesheet" href="<?= base_url('/plugins/fontawesome-free/css/all.min.css') ?>" />
    <link rel="icon" type="image/x-icon" href="<?= base_url('/images/bps.png') ?>">
    <title>Login</title>

    <style>
        body {
            font-family: 'Andika', sans-serif;
        }



        html,
        body {
            height: 100%;
            width: 100%;
            background-color: #e3ecfa;
        }

        .login {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            justify-items: center;
        }

        .button {
            background-color: #3C4B64;
            padding: 10px;
            border: none;
            color: white;
        }

        .button:hover {
            background-color: #1A2B48;
            color: white;
        }

        .button:focus {
            background-color: #3C4B64;
            color: white;
        }

        .title {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        .test {
            max-width: 1000px;
            overflow: hidden;
        }

        .test2 {
            background-color: #3C4B64;
            padding: 0;
        }

        .test2 img {
            opacity: 80%;
            border-radius: 0;
        }

        .test2 img:hover {
            opacity: 100%;
            transition: 0.5s;
        }

        .logo {
            position: absolute;
            width: 100px;
            top: 50%;
            right: 50%;
        }

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

        textarea:focus,
        input[type="text"]:focus,
        input[type="password"]:focus,
        .uneditable-input:focus {
            border-color: #3C4B64;
            box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset, 0 0 8px #3C4B64;
            outline: 0 none;
        }

        @media only screen and (max-width: 576px) {
            .test2 {
                display: none;
            }
        }


        .row {
            max-width: 1000px;
        }

        form {
            width: 90%;
        }

        /**
  * Arc
  *
  * @author jh3y - jheytompkins.com
*/
        .arc:before {
            -webkit-animation: spin 0.5s infinite linear;
            animation: spin 0.5s infinite linear;
            border-radius: 100%;
            border-top: 6px solid var(--primary, #fff);
            content: '';
            display: block;
            height: 20px;
            width: 20px;
        }

        @-webkit-keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spin {
            to {
                -webkit-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body class="">
    <div class="min-vh-100 min-vw-100 d-flex justify-content-center align-items-center">

        <div class="row bg-white rounded overflow-hidden shadow-lg">
            <div class="col-sm-6 d-flex justify-content-center align-items-center flex-column py-5 px-5">
                <div class="title mb-4">
                    <h4 class="mb-4 fw-bold fs-2">Login SiPHP</h4>
                </div>
                <form class="mb-4" action="<?= base_url('/login') ?>" method="post">
                    <div class="form-group">
                        <label for="login" class="fw-semibold mb-2">Username</label>
                        <input type="text" class="form-control shadow-none" name="username" placeholder="Username">
                    </div>


                    <div class="form-group mb-4">
                        <label for="password" class="fw-semibold mt-3 mb-2">Password</label>
                        <div class="password">
                            <input type="password" name="password" id="password" class="form-control shadow-none" placeholder="Password">
                            <i name="eye" class="fas fa-eye pw-eye" id="togglePassword"></i>
                        </div>
                    </div>

                    <button type="submit" id="liveAlertBtn" class="w-100 btn button mt-3 fw-semibold d-flex justify-content-center"><span>Login</span><span class="arc d-none"></span></button>
                </form>
            </div>
            <div class="col-sm-6 test2">
                <img src="<?= base_url('/images/1.png') ?>" class="card-img" style="object-fit: cover;" height="100%">
            </div>
        </div>
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
            <?php if (session()->getFlashdata('pesan')) { ?>
                Swal.fire({
                    title: "<?= session()->getFlashdata('pesan') ?>",
                    text: "<?= session()->getFlashdata('pesan_text') ?>",
                    icon: "<?= session()->getFlashdata('icon') ?>",
                    showConfirmButton: true,
                });
            <?php } ?>
            $('.button').click(function() {
                $(this).children().first().addClass('d-none')
                $('.arc').removeClass('d-none')
            })
        });
    </script>
</body>


</html>