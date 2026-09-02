<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';
include 'system-transaction-code.php';
include 'get-running-no.php';
include '../web-mail/email-settings.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$pst_datenow = date('Y-m-d H:i:s');	

if($_POST['action'] == 'add_sorting_qty')
{
    if(isset($_POST['ir_id'], $_POST['qty_ok'], $_POST['qty_ng'])) {

        $ir_id   = intval($_POST['ir_id']);
        $qty_ok  = intval($_POST['qty_ok']);
        $qty_ng  = intval($_POST['qty_ng']);

        if($qty_ok === '' || $qty_ng === '') {
            echo "QTY OK and QTY NG are required.";
            exit;
        }

        // Check if record already exists
        $check = $db_con->prepare("SELECT sr_id FROM sorting_report WHERE sr_ir_id = ?");
        $check->bind_param("i", $ir_id);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {

            // Update existing record
            $row = $res->fetch_assoc();
            $sr_id = $row['sr_id'];

            $update = $db_con->prepare("UPDATE sorting_report SET sr_qty_ok = ?, sr_qty_ng = ? WHERE sr_id = ?");
            $update->bind_param("iii", $qty_ok, $qty_ng, $sr_id);

            if ($update->execute()) {
                echo json_encode(["status" => "success", "message" => "Sorting report updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Update failed: ".$update->error]);
            }

        } else {

            $stmtInsert = $db_con->prepare("INSERT INTO sorting_report (sr_ir_id, sr_qty_ok, sr_qty_ng, sr_status, created_by, created_date) 
                                                VALUES (?, ?, ?, ?, ?, ?)");
            $stmtInsert->bind_param("iiiiss", $ir_id, $qty_ok, $qty_ng, $s_new_id, $session_id, $pst_datenow);

            if ($stmtInsert->execute()) {
                echo json_encode(["status" => "success", "message" => "Sorting report saved successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Insert failed: ".$stmtInsert->error]);
            }
        }

    } else {
       echo json_encode(["status" => "error", "message" => "Error to save record"]);
    }

}

if ($_POST['action'] == 'get_sorting_qty') {

    if (!empty($_POST['ir_id'])) {
        $ir_id = intval($_POST['ir_id']);

        $stmt = $db_con->prepare("SELECT sr_qty_ok, sr_qty_ng 
                                  FROM sorting_report 
                                  WHERE sr_ir_id = ? LIMIT 1");
        $stmt->bind_param("i", $ir_id);
        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            echo json_encode([
                "status" => "success",
                "qty_ok" => $row['sr_qty_ok'],
                "qty_ng" => $row['sr_qty_ng']
            ]);
        } else {
            echo json_encode([
                "status" => "empty",
                "qty_ok" => "",
                "qty_ng" => ""
            ]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "empty"]);
    }
}

?>