<?php

use PHPMailer\PHPMailer\PHPMailer;

$mail = new PHPMailer(true);

$mail->isSMTP();
$mail->Host = $host;
$mail->SMTPAuth = true;
$mail->Username = $email_username;
$mail->Password = $email_password;
$mail->Port = $port;

$mail->setFrom($email_username, $system_name);
$mail->addAddress($user['staff_email'], $user['staff_name']);

$mail->isHTML(true);
$mail->Subject = 'Account Locked Notification';

$mail->Body = "
    <p>Dear {$user['staff_name']},</p>
    <p>Your account has been <strong>locked</strong> due to multiple failed login attempts.</p>
    <p><strong>Date & Time:</strong> ".date('d M Y, h:i A')."</p>
    <p>Please contact the system administrator.</p>
    <p style='font-size:12px;color:#888'>System generated email. Do not reply.</p>
";

$mail->send();
