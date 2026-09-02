<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="pages/icon/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
   
    <link class="main-css" href="pages/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="login/fonts/icomoon/style.css">
    <link rel="stylesheet" href="login/css/owl.carousel.min.css">
    <link rel="stylesheet" href="login/css/bootstrap.min.css">
    <link rel="stylesheet" href="login/css/style.css">

    <link href="pages/vendor/nestable2/css/jquery.nestable.min.css" rel="stylesheet">
    <link href="pages/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">

</head>
<body class="bg-light">

<?php

include 'db/db_connect.php';
include 'web-mail/email-settings.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card shadow">
                <div class="card-header text-center">
                    <strong>System Login</strong>
                </div>

                <div class="card-body">
                    <form method="POST" action="login-process.php">

                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" required autofocus>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="d-flex mb-5 align-items-center">
                            <span class="ml-auto"><a href="forgot-password.php" class="forgot-pass">Forgot Password</a></span> 
                        </div>

                        <!-- CAPTCHA (only after 3 failures) -->
                        <?php if (!empty($_SESSION['show_captcha'])): ?>
                        <div class="mb-3">
                            <label class="form-label">Security Check</label>
                            <div class="d-flex align-items-center gap-2">
                                <img src="captcha.php?<?= time() ?>" alt="captcha">
                                <input type="text" name="captcha" class="form-control" placeholder="Enter code" required>
                            </div>
                        </div>
                        <?php endif; ?>

                        <button type="submit" name="btnlogin" class="btn btn-primary w-100">
                            Login
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Required vendors -->
<script src="login/js/jquery-3.3.1.min.js"></script>
<script src="login/js/popper.min.js"></script>
<script src="login/js/bootstrap.min.js"></script>
<script src="login/js/main.js"></script>

<script src="pages/js/plugins-init/sweetalert.init.js"></script>

<!-- SweetAlert Message -->
<script src="pages/vendor/sweetalert2/sweetalert2.min.js"></script>

<?php if (!empty($_SESSION['login_error'])): ?>
<script>
document.addEventListener("DOMContentLoaded", function () {
    Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: <?= json_encode($_SESSION['login_error']) ?>,
        confirmButtonColor: '#dc3545'
    });
});
</script>
<?php unset($_SESSION['login_error']); endif; ?>


</body>
</html>
