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

// Finished Goods  Part
if($_POST['action'] == 'add_finishgoods_part')
{
    if (isset($_POST['ir_id'], $_POST['related_cust'], $_POST['qty_ok'], $_POST['qty_ng'])) 
    {
        $ir_id       = intval($_POST['ir_id']);
        $sr_id       = intval($_POST['sr_id']);
        $related_cust= intval($_POST['related_cust']);
        $qty_ok      = intval($_POST['qty_ok']);
        $qty_ng      = intval($_POST['qty_ng']);

        // get material hdr
        $stmt = $db_con->prepare("
                    SELECT i.ir_material
                    FROM inspection_records i 
                    WHERE i.ir_id = ?
                ");
        $stmt->bind_param("i", $ir_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        $part_no = $row['ir_material'];
        
        //Update sorting status in inspection table
        $update = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? 
                                        WHERE ir_id = ?");
        $update->bind_param("ii", $s_draft_id, $ir_id);
        $update->execute();

        // Insert new record
        $insert = $db_con->prepare("INSERT INTO inspection_sorting_related_part_cust 
                                    (srp_ir_id_cust, srp_ir_id_sorting, srp_related_cust, srp_mathdr_id_cust, srp_qty_ok_cust, srp_qty_ng_cust,  created_by, created_date) 
                                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->bind_param("iiiiiiss", $ir_id, $sr_id, $related_cust, $part_no, $qty_ok, $qty_ng,  $session_id, $pst_datenow);

        if ($insert->execute()) {
            echo json_encode(["status" => "success", "message" => "Finished Goods part saved successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Insert failed: " . $insert->error]);
        }        

    } else {
        echo json_encode(["status" => "error", "message" => "Invalid parameters."]);
    }
}

// List all relted part
if ($_POST['action'] === 'get_finishgoods_part') {
    
    $ir_id = intval($_POST['ir_id'] ?? 0);
    $sr_id = intval($_POST['sr_id'] ?? 0);

    $status = 0;
    if ($sr_id > 0) {
        $q = $db_con->prepare("SELECT sr_status FROM inspection_sorting WHERE sr_id = ?");
        $q->bind_param("i", $sr_id);
        $q->execute();
        $q->bind_result($status);
        $q->fetch();
        $q->close();
    }

    $stmt = $db_con->prepare("
        SELECT p.srp_id_cust, p.srp_related_cust,
               p.srp_qty_ok_cust, p.srp_qty_ng_cust,
               c.rc_cust_name, c.rc_cust_id
        FROM inspection_sorting_related_part_cust p
        LEFT JOIN related_customers c ON p.srp_related_cust = c.rc_cust_id
        WHERE p.srp_ir_id_cust = ? and p.srp_ir_id_sorting = ?
    ");
    $stmt->bind_param("ii", $ir_id, $sr_id);
    $stmt->execute();
    $res = $stmt->get_result();

    ob_start();

    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
    ?>
    <tr data-srp_id="<?= $row['srp_id_cust'] ?>">
        <td>
            <input type="text" class="form-control" value="<?= htmlspecialchars($row['rc_cust_name']) ?>" readonly>
            <input type="hidden" class="form-control related_cust" value="<?= htmlspecialchars($row['rc_cust_id']) ?>">
        </td>
        <td><input type="number" class="form-control qty_ok" min="0" value="<?= $row['srp_qty_ok_cust'] ?>"></td>
        <td><input type="number" class="form-control qty_ng" min="0" value="<?= $row['srp_qty_ng_cust'] ?>"></td>
        <td>
            <button class="btn btn-black btn-sm btnUpdateRowCust" data-bs-toggle="tooltip" title="Save changes"><i class="fa fa-save"></i></button>
            <button class="btn btn-red btn-sm btnDeleteRowCust" data-bs-toggle="tooltip" title="Delete record"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    <?php
            }
        } else {
            if (in_array($status, [4, 8, 10])) {
                echo "<tr><td colspan='4' class='text-center text-danger'>No record</td></tr>";
            } else {
                // Get default customer info from material_header
                $stmt = $db_con->prepare("
                    SELECT c.rc_cust_id, c.rc_cust_name
                    FROM material_header h
                    INNER JOIN inspection_records i ON h.matid = i.ir_material
                    LEFT JOIN related_customers c ON h.matcustomer = c.rc_cust_id
                    WHERE i.ir_id = ?
                    LIMIT 1
                ");
                $stmt->bind_param("i", $ir_id);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
    ?>
    <tr>
        <td>
            <input type="text" class="form-control" value="<?= htmlspecialchars($row['rc_cust_name']) ?>" readonly>
            <input type="hidden" class="form-control related_cust" value="<?= htmlspecialchars($row['rc_cust_id']) ?>">
        </td>
        <td><input type="number" class="form-control qty_ok" min="0" value=""></td>
        <td><input type="number" class="form-control qty_ng" min="0" value=""></td>
        <td>
            <button class="btn btn-black btn-sm btnSaveRowCust" data-bs-toggle="tooltip" title="Save record"><i class="fa fa-plus"></i></button>
        </td>
    </tr>
    <?php
        }
    }

    $html = ob_get_clean();
    echo json_encode([
        'html' => $html,
        'sorting_status' => $status
    ]);
    exit;
}

//Update Finished Goods  part
if($_POST['action'] == 'update_finishgoods_part')
{
    if (isset($_POST['ir_id'], $_POST['qty_ok'], $_POST['qty_ng'])) 
    {
        $srp_id_cust = intval($_POST['row_id']);
        $ir_id       = intval($_POST['ir_id']);
        $qty_ok      = intval($_POST['qty_ok']);
        $qty_ng      = intval($_POST['qty_ng']);

        // Update existing record
        $update = $db_con->prepare("UPDATE inspection_sorting_related_part_cust 
                                    SET srp_qty_ok_cust = ?, srp_qty_ng_cust = ?, updated_by = ?, updated_date = ? 
                                    WHERE srp_id_cust = ?");
        $update->bind_param("iissi", $qty_ok, $qty_ng, $session_id, $pst_datenow, $srp_id_cust);

        if ($update->execute()) {
            echo json_encode(["status" => "success", "message" => "Finished Goods part updated successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed: " . $update->error]);
        }
        
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid parameters."]);
    }
}

// Delete row
if ($_POST['action'] == 'delete_related_part') {

    if (!empty($_POST['row_id'])) {

        $srp_id_cust = intval($_POST['row_id']);

        $stmt = $db_con->prepare("DELETE FROM inspection_sorting_related_part_cust WHERE srp_id_cust = ?");
        $stmt->bind_param("i", $srp_id_cust);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Finished Goods part deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed: " . $stmt->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid row_id"]);
    }
}

//load after delete
if ($_POST['action'] == 'get_finishgoods_part_aftr_delete') {
       
    $ir_id = intval($_POST['ir_id']);
    
    $stmt = $db_con->prepare("
                SELECT p.matno, p.matdesc, c.rc_cust_id, c.rc_cust_name
                FROM material_header p
                LEFT JOIN inspection_records i ON p.matid = i.ir_material
                LEFT JOIN material_details m ON m.mathdr = p.matid
                LEFT JOIN related_customers c ON p.matcustomer = c.rc_cust_id
                WHERE i.ir_id = ?
            ");
    $stmt->bind_param("i", $ir_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    ?>
    <tr>
        <td>
            <input type="text" class="form-control" value="<?= htmlspecialchars($row['rc_cust_name']) ?>" readonly>
            <input type="hidden" class="form-control related_cust" value="<?= htmlspecialchars($row['rc_cust_id']) ?>">
        </td>
        <td><input type="number" class="form-control qty_ok" min="0" value="" style="width:70px;"></td>
        <td><input type="number" class="form-control qty_ng" min="0" value="" style="width:70px;"></td>
        <td><button type="button" class="btn btn-secondary btn-sm btnSaveRowCust" data-bs-toggle="tooltip" title="Save record"><i class="fa fa-plus" aria-hidden="true"></i></button></td>
        </tr>
    
    <?php
        
    $html = ob_get_clean();
    echo $html; // sreturn plain HTML

}

// ---------------- Edit -------------
// List all relted part
if ($_POST['action'] === 'get_finishgoods_part_edit') {
    
    $ir_id = intval($_POST['ir_id'] ?? 0);
    $sr_id = intval($_POST['sr_id'] ?? 0);

    $status = 0;
    if ($sr_id > 0) {
        $q = $db_con->prepare("SELECT sr_status FROM inspection_sorting WHERE sr_id = ?");
        $q->bind_param("i", $sr_id);
        $q->execute();
        $q->bind_result($status);
        $q->fetch();
        $q->close();
    }

    $stmt = $db_con->prepare("
        SELECT p.srp_id_cust, p.srp_related_cust,
               p.srp_qty_ok_cust, p.srp_qty_ng_cust,
               c.rc_cust_name, c.rc_cust_id
        FROM inspection_sorting_related_part_cust p
        LEFT JOIN related_customers c ON p.srp_related_cust = c.rc_cust_id
        WHERE p.srp_ir_id_cust = ? and p.srp_ir_id_sorting = ?
    ");
    $stmt->bind_param("ii", $ir_id, $sr_id);
    $stmt->execute();
    $res = $stmt->get_result();

    ob_start();

    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
    ?>
    <tr data-srp_id="<?= $row['srp_id_cust'] ?>">
        <td>
            <input type="text" class="form-control" value="<?= htmlspecialchars($row['rc_cust_name']) ?>" readonly>
            <input type="hidden" class="form-control related_cust" value="<?= htmlspecialchars($row['rc_cust_id']) ?>">
        </td>
        <td><input type="number" class="form-control qty_ok" min="0" value="<?= $row['srp_qty_ok_cust'] ?>"></td>
        <td><input type="number" class="form-control qty_ng" min="0" value="<?= $row['srp_qty_ng_cust'] ?>"></td>
        <td>
            <button class="btn btn-black btn-sm btnUpdateRowCust" data-bs-toggle="tooltip" title="Save changes"><i class="fa fa-save"></i></button>
            <button class="btn btn-red btn-sm btnDeleteRowCust" data-bs-toggle="tooltip" title="Delete record"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    <?php
            }
        } else {
            if (in_array($status, [4, 8, 10])) {
                echo "<tr><td colspan='4' class='text-center text-danger'>No record</td></tr>";
            } else {
                // Get default customer info from material_header
                $stmt = $db_con->prepare("
                    SELECT c.rc_cust_id, c.rc_cust_name
                    FROM material_header h
                    INNER JOIN inspection_records i ON h.matid = i.ir_material
                    LEFT JOIN related_customers c ON h.matcustomer = c.rc_cust_id
                    WHERE i.ir_id = ?
                    LIMIT 1
                ");
                $stmt->bind_param("i", $ir_id);
                $stmt->execute();
                $res = $stmt->get_result();
                $row = $res->fetch_assoc();
    ?>
    <tr>
        <td>
            <input type="text" class="form-control" value="<?= htmlspecialchars($row['rc_cust_name']) ?>" readonly>
            <input type="hidden" class="form-control related_cust" value="<?= htmlspecialchars($row['rc_cust_id']) ?>">
        </td>
        <td><input type="number" class="form-control qty_ok" min="0" value=""></td>
        <td><input type="number" class="form-control qty_ng" min="0" value=""></td>
        <td>
            <button class="btn btn-black btn-sm btnSaveRowCust" data-bs-toggle="tooltip" title="Save record"><i class="fa fa-plus"></i></button>
        </td>
    </tr>
    <?php
        }
    }

    $html = ob_get_clean();
    echo json_encode([
        'status' => 'success',
        'data' => [
            'html' => $html,
            'sorting_status' => (int)$status,
            'sr_id' => $sr_id,
            'ir_id' => $ir_id
        ]
    ]);
    // echo json_encode([
    //     'html' => $html,
    //     'sorting_status' => $status
    // ]);
    exit;
}

?>