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

// Related loose Part
if($_POST['action'] == 'add_related_part')
{
    if (isset($_POST['ir_id'], $_POST['related_dept'], $_POST['type_part'],$_POST['part_no'], $_POST['part_name'], $_POST['qty_ok'], $_POST['qty_ng'])) 
    {
        $ir_id       = intval($_POST['ir_id']);
        $sr_id       = intval($_POST['sr_id']);
        $related_dept= intval($_POST['related_dept']);
        $type_part   = intval($_POST['type_part']);
        $part_no     = intval($_POST['part_no']);
        $part_name   = intval($_POST['part_name']); // assuming FK from material_details
        $qty_ok      = intval($_POST['qty_ok']);
        $qty_ng      = intval($_POST['qty_ng']);

        // First check if the record exists based on ir_id + related_dept + type_part + part_no
        $check = $db_con->prepare("SELECT srp_id_dept 
                            FROM inspection_sorting_related_part_dept 
                            WHERE srp_ir_id_dept = ? 
                            AND srp_related_dept = ? 
                            AND srp_type_part_dept = ? 
                            AND srp_mathdr_id_dept = ? 
                            LIMIT 1");
        $check->bind_param("iiii", $ir_id, $related_dept, $type_part, $part_no);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {

            echo json_encode([
                "status" => "duplicate",
                "message" => "This related loose part already exists."
            ]);

        } else {
            
            // Update sorting status in inspection table
            $update = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? 
                                            WHERE ir_id = ?");
            $update->bind_param("ii", $s_draft_id, $ir_id);
            $update->execute();

            // Insert new record
            $insert = $db_con->prepare("INSERT INTO inspection_sorting_related_part_dept 
                                        (srp_ir_id_dept, srp_ir_id_sorting, srp_related_dept, srp_type_part_dept, srp_mathdr_id_dept, srp_qty_ok_dept, srp_qty_ng_dept, created_by, created_date) 
                                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $insert->bind_param("iiiiiiiss", $ir_id, $sr_id, $related_dept, $type_part, $part_no, $qty_ok, $qty_ng, $session_id, $pst_datenow);

            if ($insert->execute()) {
                echo json_encode(["status" => "success", "message" => "Related loose part saved successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Insert failed: " . $insert->error]);
            }
        }

    } else {
        echo json_encode(["status" => "error", "message" => "Invalid parameters."]);
    }
}

// List all relted part
if ($_POST['action'] === 'get_related_part') {

    $ir_id = intval($_POST['ir_id'] ?? 0);
    $sr_id = intval($_POST['sr_id'] ?? 0);

    // Get sr_status
    $status = 0;
    if ($sr_id > 0) {
        $q = $db_con->prepare("SELECT sr_status FROM inspection_sorting WHERE sr_id = ? and sr_status != ? ");
        $q->bind_param("ii", $sr_id, $s_cancelled_id);
        $q->execute();
        $q->bind_result($status);
        $q->fetch();
        $q->close();
    }

    // Get existing related part rows
    $stmt = $db_con->prepare("
        SELECT p.srp_id_dept, p.srp_related_dept, p.srp_type_part_dept,
               p.srp_mathdr_id_dept, p.srp_qty_ok_dept, p.srp_qty_ng_dept,
               m.bom, m.bomdesc
        FROM inspection_sorting_related_part_dept p
        LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
        WHERE p.srp_ir_id_dept = ? and p.srp_ir_id_sorting = ?
    ");
    $stmt->bind_param("ii", $ir_id, $sr_id);
    $stmt->execute();
    $res = $stmt->get_result();

    ob_start();

    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
    ?>
    <tr data-srp_id="<?= $row['srp_id_dept'] ?>">
        <td>
            <select class="form-control related_dept select2 dept-select">
                <option value="">Select Dept</option>
                <?php
                $q = $db_con->query("SELECT rd_dept_id, rd_dept_name FROM related_departments WHERE rd_dept_status = 'AC'");
                while ($r = $q->fetch_assoc()) {
                    $sel = ($r['rd_dept_id'] == $row['srp_related_dept']) ? "selected" : "";
                    echo "<option value='{$r['rd_dept_id']}' $sel>{$r['rd_dept_name']}</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control type_part select2 part-select">
                <option value="">Select Type</option>
                <?php
                $q = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status='AC'");
                while ($r = $q->fetch_assoc()) {
                    $sel = ($r['tp_partid'] == $row['srp_type_part_dept']) ? "selected" : "";
                    echo "<option value='{$r['tp_partid']}' $sel>{$r['tp_partname']}</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control part_no select2 partno-select">
                <option value="">Part No</option>
                <?php
                $q = $db_con->query("SELECT m.matdet_id, m.bom 
                                        FROM material_details m 
                                        INNER JOIN inspection_records i ON m.mathdr = i.ir_material
                                        JOIN material_department md ON md.matdet_id = m.matdet_id
                                        LEFT JOIN inspection_sorting_related_part_dept s ON md.rd_dept_id = s.srp_related_dept
                                        WHERE i.ir_id = '$ir_id' 
                                        AND s.srp_ir_id_sorting = '$sr_id' 
                                        AND s.srp_related_dept = '$row[srp_related_dept]' 
                                        GROUP BY m.matdet_id");
                while ($r = $q->fetch_assoc()) {
                    $sel = ($r['matdet_id'] == $row['srp_mathdr_id_dept']) ? "selected" : "";
                    echo "<option value='{$r['matdet_id']}' $sel>{$r['bom']}</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="text" class="form-control part_name" value="<?= htmlspecialchars($row['bomdesc']) ?>" readonly data-bs-toggle="tooltip" title="<?= htmlspecialchars($row['bomdesc']) ?>"></td>
        <td><input type="number" class="form-control qty_ok" min="0" value="<?= $row['srp_qty_ok_dept'] ?>"></td>
        <td><input type="number" class="form-control qty_ng" min="0" value="<?= $row['srp_qty_ng_dept'] ?>"></td>
        <td>
            <button class="btn btn-black btn-sm btnUpdateRowDept" data-bs-toggle="tooltip" title="Save changes"><i class="fa fa-save"></i></button>
            <button class="btn btn-red btn-sm btnDeleteRowDept" data-bs-toggle="tooltip" title="Delete record"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    <?php
            }
        } else {
            // If no records and locked (status=9), show warning message
            if (in_array($status, [8, 9, 11])) {
            echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
        } else {
        // Show 1 empty row for user input
    ?>
    <tr>
        <td>
            <select class="form-control related_dept select2 dept-select">
                <option value="">Select Dept</option>
                <?php
                $q = $db_con->query("SELECT rd_dept_id, rd_dept_name FROM related_departments WHERE rd_dept_status = 'AC'");
                while ($r = $q->fetch_assoc()) {
                    echo "<option value='{$r['rd_dept_id']}'>{$r['rd_dept_name']}</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control type_part select2 part-select">
                <option value="">Select Type</option>
                <?php
                $q = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status='AC'");
                while ($r = $q->fetch_assoc()) {
                    echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control part_no select2 partno-select">
                <option value="">Part No</option>
                <?php
                $q = $db_con->query("SELECT m.matdet_id, m.bom 
                                        FROM material_details m 
                                        INNER JOIN inspection_records i ON m.mathdr = i.ir_material
                                        JOIN material_department md ON md.matdet_id = m.matdet_id
                                        LEFT JOIN inspection_sorting_related_part_dept s ON md.rd_dept_id = s.srp_related_dept
                                        WHERE i.ir_id = '$ir_id' 
                                        AND s.srp_ir_id_sorting = '$sr_id' 
                                        AND s.srp_related_dept = '$row[srp_related_dept]'
                                        GROUP BY m.matdet_id ");
                while ($r = $q->fetch_assoc()) {
                    echo "<option value='{$r['matdet_id']}'>{$r['bom']}</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="text" class="form-control part_name" value="" data-bs-toggle="tooltip" title=""></td>
        <td><input type="number" class="form-control qty_ok" min="0" value=""></td>
        <td><input type="number" class="form-control qty_ng" min="0" value=""></td>
        <td>
            <button class="btn btn-black btn-sm btnSaveRowDept" data-bs-toggle="tooltip" title="Add record"><i class="fa fa-plus"></i></button>
        </td>
    </tr>
    <?php
        }
    }

    $html = ob_get_clean();
    echo json_encode([
        'html' => $html,
        'sorting_status' => (int)$status
    ]);
    exit;
}

//Update related loose part
if($_POST['action'] == 'update_related_part')
{
    if (isset($_POST['ir_id'], $_POST['related_dept'], $_POST['type_part'],$_POST['part_no'], $_POST['part_name'], $_POST['qty_ok'], $_POST['qty_ng'])) 
    {
        $srp_id_dept = intval($_POST['row_id']);
        $ir_id       = intval($_POST['ir_id']);
        $related_dept= intval($_POST['related_dept']);
        $type_part   = intval($_POST['type_part']);
        $part_no     = intval($_POST['part_no']);
        $part_name   = intval($_POST['part_name']); // assuming FK from material_details
        $qty_ok      = intval($_POST['qty_ok']);
        $qty_ng      = intval($_POST['qty_ng']);

        // First check if the record exists based on ir_id + related_dept + type_part + part_no
        $check = $db_con->prepare("SELECT srp_id_dept 
                            FROM inspection_sorting_related_part_dept 
                            WHERE srp_ir_id_dept = ? 
                            AND srp_related_dept = ? 
                            AND srp_type_part_dept = ? 
                            AND srp_mathdr_id_dept = ? AND srp_id_dept != ?
                            LIMIT 1");
        $check->bind_param("iiiii", $ir_id, $related_dept, $type_part, $part_no, $srp_id_dept);
        $check->execute();
        $res = $check->get_result();

        if ($res->num_rows > 0) {

          echo json_encode([
                "status" => "duplicate",
                "message" => "This related loose part already exists."
            ]);

        } else {

            // Update existing record
            $row = $res->fetch_assoc();

            $update = $db_con->prepare("UPDATE inspection_sorting_related_part_dept 
                                        SET srp_related_dept = ?, srp_type_part_dept = ?, srp_mathdr_id_dept = ?, srp_qty_ok_dept = ?, srp_qty_ng_dept = ?, updated_by = ?, updated_date = ? 
                                        WHERE srp_id_dept = ?");
            $update->bind_param("iiiiissi", $related_dept, $type_part, $part_no, $qty_ok, $qty_ng, $session_id, $pst_datenow, $srp_id_dept);

            if ($update->execute()) {
                echo json_encode(["status" => "success", "message" => "Related loose part updated successfully."]);
            } else {
                echo json_encode(["status" => "error", "message" => "Update failed: " . $update->error]);
            }
        }
        
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid parameters."]);
    }
}

// Delete row
if ($_POST['action'] == 'delete_related_part') {
    if (!empty($_POST['row_id'])) {
        $srp_id_dept = intval($_POST['row_id']);

        $stmt = $db_con->prepare("DELETE FROM inspection_sorting_related_part_dept WHERE srp_id_dept = ?");
        $stmt->bind_param("i", $srp_id_dept);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Related loose part deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed: " . $stmt->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid row_id"]);
    }
}

//------------- for edit-----------------

// List all relted part
if ($_POST['action'] === 'get_related_part_edit') {

    $ir_id = intval($_POST['ir_id'] ?? 0);
    $sr_id = intval($_POST['sr_id'] ?? 0);

    // Get sr_status
    $status = 0;
    if ($sr_id > 0) {
        $q = $db_con->prepare("SELECT sr_status FROM inspection_sorting WHERE sr_id = ? ");
        $q->bind_param("i", $sr_id);
        $q->execute();
        $q->bind_result($status);
        $q->fetch();
        $q->close();
    }

    // Get existing related part rows
    $stmt = $db_con->prepare("
        SELECT p.srp_id_dept, p.srp_related_dept, p.srp_type_part_dept,
               p.srp_mathdr_id_dept, p.srp_qty_ok_dept, p.srp_qty_ng_dept,
               m.bom, m.bomdesc
        FROM inspection_sorting_related_part_dept p
        LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
        WHERE p.srp_ir_id_dept = ? and p.srp_ir_id_sorting = ?
    ");
    $stmt->bind_param("ii", $ir_id, $sr_id);
    $stmt->execute();
    $res = $stmt->get_result();

    ob_start();

    if ($res->num_rows > 0) {
        while ($row = $res->fetch_assoc()) {
    ?>
    <tr data-srp_id="<?= $row['srp_id_dept'] ?>">
        <td>
            <select class="form-control related_dept select2 dept-select">
                <option value="">Select Dept</option>
                <?php
                $q = $db_con->query("SELECT rd_dept_id, rd_dept_name FROM related_departments WHERE rd_dept_status = 'AC'");
                while ($r = $q->fetch_assoc()) {
                    $sel = ($r['rd_dept_id'] == $row['srp_related_dept']) ? "selected" : "";
                    echo "<option value='{$r['rd_dept_id']}' $sel>{$r['rd_dept_name']}</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control type_part select2 part-select">
                <option value="">Select Type</option>
                <?php
                $q = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status='AC'");
                while ($r = $q->fetch_assoc()) {
                    $sel = ($r['tp_partid'] == $row['srp_type_part_dept']) ? "selected" : "";
                    echo "<option value='{$r['tp_partid']}' $sel>{$r['tp_partname']}</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control part_no select2 partno-select">
                <option value="">Part No</option>
                <?php
                $q = $db_con->query("SELECT m.matdet_id, m.bom 
                                       FROM material_details m 
                                        INNER JOIN inspection_records i ON m.mathdr = i.ir_material
                                        JOIN material_department md ON md.matdet_id = m.matdet_id
                                        LEFT JOIN inspection_sorting_related_part_dept s ON md.rd_dept_id = s.srp_related_dept
                                        WHERE i.ir_id = '$ir_id' 
                                        AND s.srp_ir_id_sorting = '$sr_id' 
                                        AND s.srp_related_dept = '$row[srp_related_dept]' 
                                        GROUP BY m.matdet_id");
                while ($r = $q->fetch_assoc()) {
                    $sel = ($r['matdet_id'] == $row['srp_mathdr_id_dept']) ? "selected" : "";
                    echo "<option value='{$r['matdet_id']}' $sel>{$r['bom']}</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="text" class="form-control part_name" value="<?= htmlspecialchars($row['bomdesc']) ?>" readonly data-bs-toggle="tooltip" title="<?= htmlspecialchars($row['bomdesc']) ?>"></td>
        <td><input type="number" class="form-control qty_ok" min="0" value="<?= $row['srp_qty_ok_dept'] ?>"></td>
        <td><input type="number" class="form-control qty_ng" min="0" value="<?= $row['srp_qty_ng_dept'] ?>"></td>
        <td>
            <button class="btn btn-black btn-sm btnUpdateRowDept" data-bs-toggle="tooltip" title="Save changes"><i class="fa fa-save"></i></button>
            <button class="btn btn-red btn-sm btnDeleteRowDept" data-bs-toggle="tooltip" title="Delete record"><i class="fa fa-trash"></i></button>
        </td>
    </tr>
    <?php
            }
        } else {
            // If no records and locked (status=9), show warning message
            if (in_array($status, [8, 9, 11])) {
                echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
            } else {
                // Show 1 empty row for user input
    ?>
    <tr>
        <td>
            <select class="form-control related_dept select2 dept-select">
                <option value="">Select Dept</option>
                <?php
                $q = $db_con->query("SELECT rd_dept_id, rd_dept_name FROM related_departments WHERE rd_dept_status = 'AC'");
                while ($r = $q->fetch_assoc()) {
                    echo "<option value='{$r['rd_dept_id']}'>{$r['rd_dept_name']}</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control type_part select2 part-select">
                <option value="">Select Type</option>
                <?php
                $q = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status='AC'");
                while ($r = $q->fetch_assoc()) {
                    echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                }
                ?>
            </select>
        </td>
        <td>
            <select class="form-control part_no select2 partno-select">
                <option value="">Part No</option>
                <?php
                $q = $db_con->query("SELECT m.matdet_id, m.bom 
                                        FROM material_details m 
                                        INNER JOIN inspection_records i ON m.mathdr = i.ir_material 
                                        LEFT JOIN inspection_sorting_related_part_dept s ON m.bomdept = s.srp_related_dept
                                        WHERE i.ir_id = '$ir_id' AND s.srp_id_dept = '$sr_id' ");
                while ($r = $q->fetch_assoc()) {
                    echo "<option value='{$r['matdet_id']}'>{$r['bom']}</option>";
                }
                ?>
            </select>
        </td>
        <td><input type="text" class="form-control part_name" value="" data-bs-toggle="tooltip" title=""></td>
        <td><input type="number" class="form-control qty_ok" min="0" value=""></td>
        <td><input type="number" class="form-control qty_ng" min="0" value=""></td>
        <td>
            <button class="btn btn-black btn-sm btnSaveRowDept" data-bs-toggle="tooltip" title="Add record"><i class="fa fa-plus"></i></button>
        </td>
    </tr>
    <?php
        }
    }

    $html = ob_get_clean();
    echo json_encode([
        'status' => 'success',   // <--- required so JS can check res.status
        'data' => [
            'html' => $html,
            'sorting_status' => (int)$status,
            'sr_id' => $sr_id,
            'ir_id' => $ir_id
        ]
    ]);
    // echo json_encode([
    //     'html' => $html,
    //     'sorting_status' => (int)$status
    // ]);
    exit;
}

?>

