<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="pages/icon/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>i-QIMS | Finished Goods Inspection</title>
    <link href="login.css" rel="stylesheet">
</head>
<body>

<?php

include 'db/db_connect.php';
include 'web-mail/email-settings.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

?>

<style>

    #username::placeholder {
        color: #000;
        opacity: 0.20;
    }

    #password::placeholder {
        color: #000;
        opacity: 0.20;
    }

</style>

    <div class="container">
        <div class="login-section">
            <div class="login-box">
                <div class="brand-logo"></div>
                <h2>Login</h2>
                <!-- <p class="subtitle">Enter credentials for Finished Goods Inspection</p> -->

                <form method="POST" action="login-process.php">
                    <div class="form-group">
                        <label for="username">Staff ID / Username</label>
                        <input type="text" id="username" name="username" placeholder="e.g. IAT0001" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>


                    <button type="submit" name="btnlogin" class="login-btn">Log In</button>
                    
                    <div style="text-align: right; margin-top: 12px;">
                        <a href="forgot-password.php" style="font-size: 13px; color: #085209; text-decoration: none; font-weight: 500;">
                            Forgot Password?
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="image-section">
            <div class="image-overlay-text">
                <h2 style="margin: 0 0 10px 0;">Quality Commitment</h2>
                <p style="margin: 0; opacity: 0.9;">Ensuring every finished product meets our rigorous standards of excellence and safety.</p>
            </div>
        </div>
    </div>

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

