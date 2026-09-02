<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../web-mail/email-settings.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$pst_datenow = date('Y-m-d H:i:s');	

if ($_POST['action'] === 'change_password') {

    $user_id = $session_id; // or staff_id

    $current_password = $_POST['current_password'] ?? '';
    $new_password     = $_POST['new_password'] ?? '';

    if (empty($current_password) || empty($new_password)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Get current password hash
    $stmt = $db_con->prepare("
        SELECT password 
        FROM user_login 
        WHERE username = ?
    ");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found.'
        ]);
        exit;
    }

    $row = $result->fetch_assoc();

    // Verify old password
    if (!password_verify($current_password, $row['password'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Current password is incorrect.'
        ]);
        exit;
    }

    // Hash new password
    $hashed = password_hash($new_password, PASSWORD_DEFAULT);
    $changePswd = 'Y';
    $forcePswd = 0;

    // Update password
    $stmt = $db_con->prepare("
        UPDATE user_login
        SET password = ?, force_change_password = ? ,change_password = ?, change_password_date = NOW(), updated_date = NOW()
        WHERE username = ?
    ");
    $stmt->bind_param("siss", $hashed, $forcePswd, $changePswd, $user_id);

    if ($stmt->execute()) {

        //Send Email
        $recipients = [];

        //3. Select users with a specific role
        $sql = "SELECT E.staff_email, E.staff_name
                    FROM employee_details  E 
                        LEFT JOIN user_login L ON E.staff_id = L.staff_id
                            WHERE L.username = '$user_id' ";
        $result = $db_con->query($sql);
        while ($row = $result->fetch_assoc()) {
            $recipients[] = $row;
        }

        $mail = new PHPMailer(); 

        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = $host; // Your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = $email_username; // Your Mailtrap username
        $mail->Password = $email_password; // Your Mailtrap password
        //$mail->SMTPSecure = 'tls';
        $mail->Port = $port;

        // Sender and recipient settings
        $mail->setFrom($email_username, $system_name);

        $success_count = 0;
        $fail_count = 0;
        $fail_emails = [];

        // All authorize users for review inspection record
        foreach ($recipients as $authouser) {

            // Clear all recipients and attachments for each loop
            $mail->clearAddresses();
            $mail->clearAttachments();

            $mail->addAddress($authouser['staff_email'], $authouser['staff_name']);        
            $mail->isHTML(true);
            $mail->Subject =  $esubject_2;

            $mail->Body = "
                <p>Dear {$authouser['staff_name']},</p>

                <p>This is to inform you that your account password was successfully changed.</p>

                <p><strong>Date & Time:</strong> " . date('d M Y, h:i A') . "</p>

                <p>If you did not perform this action, please contact the system administrator immediately.</p>

                <p style='color:#888;font-size:12px'>
                    ** This is a system generated email. Please DO NOT REPLY. **
                </p>
            ";

            $mail->send();

        }

        unset($_SESSION['force_password_change']);
        
        // Destroy session for security
        session_unset();
        session_destroy();

        echo json_encode([
            'status' => 'success',
            'logout' => true,
            'message' => 'Password changed successfully. Please log in again.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update password.'
        ]);
    }

    exit;
}
