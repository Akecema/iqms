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
        
        //Update sorting status in inspection table
        $update = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? 
                                        WHERE ir_id = ?");
        $update->bind_param("ii", $s_draft_id, $ir_id);
        $update->execute();

        $stmtInsert = $db_con->prepare("INSERT INTO sorting_qty (sr_ir_id, sr_qty_ok, sr_qty_ng, sr_status, created_by, created_date) 
                                            VALUES (?, ?, ?, ?, ?, ?)");
        $stmtInsert->bind_param("iiiiss", $ir_id, $qty_ok, $qty_ng, $s_new_id, $session_id, $pst_datenow);

        if ($stmtInsert->execute()) {
            echo json_encode(["status" => "success", "message" => "Sorting quantity saved successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Insert failed: ".$stmtInsert->error]);
        }
       

    } else {
       echo json_encode(["status" => "error", "message" => "Error to save record"]);
    }

}

// List sorting qty
if ($_POST['action'] == 'get_sorting_qty') {

    if (!empty($_POST['ir_id'])) {

        $ir_id = intval($_POST['ir_id']);

        $stmt = $db_con->prepare("SELECT sr_id, sr_qty_ok, sr_qty_ng 
                                  FROM sorting_qty 
                                  WHERE sr_ir_id = ?");
        $stmt->bind_param("i", $ir_id);
        $stmt->execute();
        $res = $stmt->get_result();

        ob_start();

        if ($res->num_rows > 0) {
            while ($row = $res->fetch_assoc()) {
                ?>
                <tr data-sr_id="<?= $row['sr_id'] ?>">   
                    <td><input type="number" class="form-control sr_qty_ok" value="<?= $row['sr_qty_ok'] ?>" style="width:70px;"></td>
                    <td><input type="number" class="form-control sr_qty_ng" value="<?= $row['sr_qty_ng'] ?>" style="width:70px;"></td>
                    <td>
                        <button type="button" class="btn btn-black btn-sm btnUpdateRowSr" data-bs-toggle="tooltip" title="Update and save record"><i class="fa fa-save"></i></button>
                        <!-- <button type="button" class="btn btn-red btn-sm btnDeleteRowSr" data-bs-toggle="tooltip" title="Delete record"><i class="fa fa-trash"></i></button> -->
                    </td>
                </tr>

            <?php
                }
            } else {
                // return an empty row for "new insert"
            ?>
            <tr>
                <td><input type="number" class="form-control sr_qty_ok" value="" style="width:70px;"></td>
                <td><input type="number" class="form-control sr_qty_ng" value="" style="width:70px;"></td>
                <td><button type="button" class="btn btn-black btn-sm btnSaveRowSr" data-bs-toggle="tooltip" title="Add record"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
            </tr>
            <?php
        }

        $html = ob_get_clean();
        echo $html; // sreturn plain HTML
    } else {
        echo "<tr><td colspan='7'>Invalid ir_id</td></tr>";
    }
}

//Update sorting qty
if($_POST['action'] == 'update_sorting_qty')
{
    if (isset($_POST['ir_id'], $_POST['qty_ok'], $_POST['qty_ng'])) 
    {
        $sr_id  = intval($_POST['row_id']);
        $ir_id  = intval($_POST['ir_id']);
        $qty_ok = intval($_POST['qty_ok']);
        $qty_ng = intval($_POST['qty_ng']);

        $update = $db_con->prepare("UPDATE sorting_qty SET sr_qty_ok = ?, sr_qty_ng = ?, updated_by = ?, updated_date = ? 
                                        WHERE sr_id = ?");
        $update->bind_param("iiisi", $qty_ok, $qty_ng, $session_id, $pst_datenow, $sr_id);

        if ($update->execute()) {
            echo json_encode(["status" => "success", "message" => "Sorting quantity updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed: " . $update->error]);
        }    
        
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid parameters."]);
    }
}

?>