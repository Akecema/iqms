<?php
session_start();

// Debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$debugFile = 'debug_fp.txt';
file_put_contents($debugFile, date('Y-m-d H:i:s') . " - Process Started\n", FILE_APPEND);

require './db/db_connect.php';
include 'web-mail/email-settings.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$username = trim($_POST['username'] ?? '');
$email    = trim($_POST['email'] ?? '');

file_put_contents($debugFile, "User: $username, Email: $email\n", FILE_APPEND);

if ($username === '' || $email === '') {
    $_SESSION['fp_status'] = 'error';
    $_SESSION['fp_title']  = 'Error';
    $_SESSION['fp_message'] = 'All fields are required.';
    header("Location: forgot-password.php");
    exit;
}

// ------------------------------------------------
// 1. VALIDATE USER + EMAIL MATCH
// ------------------------------------------------
$stmt = $db_con->prepare("
    SELECT L.staff_id, L.username, E.staff_email, E.staff_name
    FROM user_login L
    INNER JOIN employee_details E ON L.staff_id = E.staff_id
    WHERE L.username = ?
      AND E.staff_email = ?
      AND L.account_locked = 'N'
    LIMIT 1
");
$stmt->bind_param("ss", $username, $email);
$stmt->execute();
$result = $stmt->get_result();

file_put_contents($debugFile, "Query Rows: " . $result->num_rows . "\n", FILE_APPEND);

$user = $result->fetch_assoc();

if (!$user) {
    file_put_contents($debugFile, "User not found or email mismatch.\n", FILE_APPEND);
    $_SESSION['fp_status'] = 'error';
    $_SESSION['fp_title']  = 'Invalid Details';
    $_SESSION['fp_message'] = 'Username and email do not match our records.';
    header("Location: forgot-password.php");
    exit;
}

// ------------------------------------------------
// 2. GENERATE TEMP PASSWORD
// ------------------------------------------------
$tempPassword = substr(str_shuffle('ABCDEFGHJKLMNPQRSTUVWXYZ23456789'), 0, 8);
$hashed = password_hash($tempPassword, PASSWORD_DEFAULT);

// ------------------------------------------------
// 3. UPDATE PASSWORD
// ------------------------------------------------
$stmtUpd = $db_con->prepare("
    UPDATE user_login
    SET password = ?,
        force_change_password = 1,
        change_password = 'Y',
        change_password_date = NOW()
    WHERE username = ?
");
$stmtUpd->bind_param("ss", $hashed, $username);
if($stmtUpd->execute()){
    file_put_contents($debugFile, "Password updated in DB.\n", FILE_APPEND);
} else {
    file_put_contents($debugFile, "DB Update Failed: " . $stmtUpd->error . "\n", FILE_APPEND);
}

// ------------------------------------------------
// 4. SEND EMAIL
// ------------------------------------------------
try {

    $mail = new PHPMailer(); 

    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = $host; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = $email_username; // Your Mailtrap username
    $mail->Password = $email_password; // Your Mailtrap password
    $mail->Port = $port;

    $mail->setFrom($email_username, $system_name);
    $mail->addAddress($user['staff_email'], $user['staff_name']);

    $mail->isHTML(true);
    $mail->Subject = 'Password Reset Notification';

    $mail->Body = "
        <p>Dear {$user['staff_name']},</p>

        <p>Your password has been reset.</p>

        <p><strong>Username:</strong> {$username}</p>
        <p><strong>Temporary Password:</strong> {$tempPassword}</p>

        <p>Please log in and change your password immediately.</p>

        <p style='font-size:12px;color:#888'>
            This is a system-generated email. Do not reply.
        </p>
    ";

    $mail->send();
    file_put_contents($debugFile, "Email sent successfully.\n", FILE_APPEND);

    $_SESSION['fp_status'] = 'success';
    $_SESSION['fp_title']  = 'Password Reset';
    $_SESSION['fp_message'] = 'A temporary password has been sent to your email (' . $user['staff_email'] . ').';

} catch (Exception $e) {

    file_put_contents($debugFile, "Email Error: " . $mail->ErrorInfo . "\n", FILE_APPEND);

    $_SESSION['fp_status'] = 'warning';
    $_SESSION['fp_title']  = 'Password Reset (Email Failed)';
    $_SESSION['fp_message'] = 'Password changed, but email failed: ' . $mail->ErrorInfo;
}

header("Location: forgot-password.php");
exit;
