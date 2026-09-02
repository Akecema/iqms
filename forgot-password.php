<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    
    <!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="pages/icon/favicon.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>i-QIMS | Forgot Password</title>
    
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
                <h2>Forgot Password</h2>
                <!-- <p class="subtitle"></p> -->

                <form method="POST" action="forgot-password-process.php">
                    <div class="form-group">
                        <label for="username">Staff ID / Username</label>
                        <input type="text" name="username" placeholder="e.g. IAT0001" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Registered Email</label>
                        <input type="email" name="email" required>
                    </div>

                    <button type="submit" class="login-btn">Reset Password</button>

                    <div style="text-align: right; margin-top: 12px;">
                        <a href="index.php" style="font-size: 13px; color: #085209; text-decoration: none; font-weight: 500;">
                            Back to Login
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

    <!-- SweetAlert Library -->
    <script src="pages/vendor/sweetalert2/sweetalert2.min.js"></script>
    <link href="pages/vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert Logic -->
    <?php if (!empty($_SESSION['fp_message'])): ?>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        Swal.fire({
            icon: <?= json_encode($_SESSION['fp_status']) ?>,
            title: <?= json_encode($_SESSION['fp_title']) ?>,
            text: <?= json_encode($_SESSION['fp_message']) ?>,
            confirmButtonColor: '#198754'
        });
    });
    </script>
    <?php
    unset($_SESSION['fp_message'], $_SESSION['fp_status'], $_SESSION['fp_title']);
    endif;
    ?>
</body>
</html>

