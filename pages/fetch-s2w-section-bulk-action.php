<?php

ob_clean();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';
include 'system-transaction-code.php';
include 'get-running-no.php';
include 'get-user-authorization.php';
include '../web-mail/email-settings.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;   

$today = date('Y-m-d');
$pst_datenow = date('Y-m-d H:i:s');	

//Submit
if ($_POST['action'] == 'bulk_submit') {

    $ids = $_POST['ids'] ?? [];

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode([
            "status" => "error",
            "message" => "No record selected."
        ]);
        exit;
    }

    // make sure all ids are integer
    $ids = array_map('intval', $ids);

    $success = 0;
    $failed  = 0;
    $fail_list = [];

    foreach ($ids as $s2w_id) {

        // -----------------------------------------
        // 1) Get report row based on s2w_id
        // -----------------------------------------
        $stmt = $db_con->prepare("
            SELECT rp_id, rp_s2w_ir_id, rp_s2w_sr_id, rp_s2w_id, rp_s2w_docno, rp_s2w_status
            FROM inspection_s2w_report
            WHERE rp_s2w_id = ? and rp_s2w_status != 8
            LIMIT 1
        ");
        $stmt->bind_param("i", $s2w_id);
        $stmt->execute();
        $rp = $stmt->get_result()->fetch_assoc();

        if (!$rp) {
            $failed++;
            $fail_list[] = "S2W ID $s2w_id (Report not found)";
            continue;
        }

        $rp_id     = (int)$rp['rp_id'];
        $ir_id     = (int)$rp['rp_s2w_ir_id'];
        $sr_id     = (int)$rp['rp_s2w_sr_id'];
        $rp_status = (int)$rp['rp_s2w_status'];

        // only allow submit if status = Draft OR Returned (example)
        if (!in_array($rp_status, [$s_draft_id, $s_return_id])) {
            $failed++;
            $fail_list[] = "RP ID $rp_id (Not allowed status)";
            continue;
        }

        // -----------------------------------------
        // 2) Get appraisor for this user
        // -----------------------------------------
        $stmtA = $db_con->prepare("
            SELECT P.appraisor
            FROM employee_approval P
            WHERE P.staff_id = ?
            LIMIT 1
        ");
        $stmtA->bind_param("s", $session_id);
        $stmtA->execute();
        $app = $stmtA->get_result()->fetch_assoc();

        $appraisor_id = $app['appraisor'] ?? null;

        // -----------------------------------------
        // 3) If draft → must have docno
        // -----------------------------------------
        $new_docno = $rp['rp_s2w_docno'];

        if ($rp_status == $s_draft_id) {

            // if your docno is already created earlier, keep it
            // but if empty → generate new docno
            if (empty($new_docno)) {
                // generate doc no here (your existing logic)
                // example only:
                // $running_no = getNextTransactionNo(...);
                // $new_docno = $session_comp . $s2w_rp_code . $doc_date . $running_no;

                $new_docno = $session_comp . $s2w_rp_code . date("ymd") . rand(1000, 9999);
            }

            $stmtU = $db_con->prepare("
                UPDATE inspection_s2w_report
                SET 
                    rp_s2w_docno   = ?,
                    rp_s2w_status  = ?,
                    rp_approver    = ?,
                    submitted_by   = ?,
                    submitted_date = NOW()
                WHERE rp_id = ?
            ");
            $stmtU->bind_param("sissi", $new_docno, $s_pendApproval_id, $appraisor_id, $session_id, $rp_id);
            $ok = $stmtU->execute();

        } else {

            // returned → resubmit (no new docno)
            $stmtU = $db_con->prepare("
                UPDATE inspection_s2w_report
                SET 
                    rp_s2w_status  = ?,
                    submitted_by   = ?,
                    submitted_date = NOW()
                WHERE rp_id = ?
            ");
            $stmtU->bind_param("isi", $s_pendApproval_id, $session_id, $rp_id);
            $ok = $stmtU->execute();
        }

        if (!$ok) {
            $failed++;
            $fail_list[] = "RP ID $rp_id (Update failed)";
            continue;
        }

        // -----------------------------------------
        // 4) Update parent statuses
        // -----------------------------------------
        $db_con->query("UPDATE inspection_records SET ir_s2w_rp_status = $s_pendApproval_id WHERE ir_id = $ir_id");
        $db_con->query("UPDATE inspection_sorting SET sr_s2w_rp_status = $s_pendApproval_id WHERE sr_id = $sr_id");
        $db_con->query("UPDATE inspection_s2w SET s2w_rp_status = $s_pendApproval_id WHERE s2w_id = $s2w_id");

        // -----------------------------------------
        // 5) Activity comment
        // -----------------------------------------
        $stmtD = $db_con->prepare("
            SELECT S.rp_s2w_docno, R.inspect_date, R.ir_shift
            FROM inspection_s2w_report S
            LEFT JOIN inspection_records R ON R.ir_id = S.rp_s2w_ir_id
            WHERE S.rp_id = ?
        ");
        $stmtD->bind_param("i", $rp_id);
        $stmtD->execute();
        $inspectiondet = $stmtD->get_result()->fetch_assoc();

        $docno = $inspectiondet['rp_s2w_docno'] ?? $new_docno;

        $appsection = 'PDI';
        $apptask = 'S2W_report';
        $comment_status = "submit the Something When Wrong (S2W) Report";

        $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? AND section = ? AND task = ?";
        $stmtr_quamax = $db_con->prepare($query_quamax);
        $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
        $stmtr_quamax->execute();
        $rst_quamax = $stmtr_quamax->get_result()->fetch_array();
        $next_priority = ($rst_quamax[0] + 1);

        $rinsert5 = $db_con->prepare("
            INSERT INTO activity_comment
            (section, task, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $rinsert5->bind_param(
            "sssssssssss",
            $appsection,
            $apptask,
            $s_pendReview_id,
            $docno,
            $inspectiondet['ir_shift'],
            $inspectiondet['inspect_date'],
            $comment_status,
            $next_priority,
            $session_id,
            $session_id,
            $pst_datenow
        );
        $rinsert5->execute();

        // -----------------------------------------
        // 6) (Optional) Send email (same like your loop)
        // -----------------------------------------
        // You can keep your email logic here
        // but for bulk, better send 1 email per rp_id OR group by approver

        $success++;
    }

    echo json_encode([
        "status" => ($failed == 0 ? "success" : "partial"),
        "message" => "Bulk submit completed. Success: $success, Failed: $failed",
        "success_count" => $success,
        "failed_count" => $failed,
        "failed_list" => $fail_list
    ]);
    exit;
}

//Cancel
if ($_POST['action'] == 'bulk_cancel') {

    $ids    = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode([
            "status" => "error",
            "message" => "No record selected."
        ]);
        exit;
    }

    if ($remark == '') {
        echo json_encode([
            "status" => "error",
            "message" => "Remark is required."
        ]);
        exit;
    }

    $ids = array_map('intval', $ids);

    $success = 0;
    $failed  = 0;
    $fail_list = [];

    foreach ($ids as $s2w_id) {

        // -----------------------------------------
        // 1) Find rp_id + ir_id + sr_id from s2w_id
        // -----------------------------------------
        $stmt = $db_con->prepare("
            SELECT rp_id, rp_s2w_ir_id, rp_s2w_sr_id, rp_s2w_id, rp_s2w_status
            FROM inspection_s2w_report 
            WHERE rp_s2w_id = ? and rp_s2w_status != 8
            LIMIT 1
        ");
        $stmt->bind_param("i", $s2w_id);
        $stmt->execute();
        $rp = $stmt->get_result()->fetch_assoc();

        if (!$rp) {
            $failed++;
            $fail_list[] = "S2W ID $s2w_id (Report not found)";
            continue;
        }

        $rp_id     = (int)$rp['rp_id'];
        $ir_id     = (int)$rp['rp_s2w_ir_id'];
        $sr_id     = (int)$rp['rp_s2w_sr_id'];
        $rp_status = (int)$rp['rp_s2w_status'];

        $docno_new = "";

        // OPTIONAL: Only allow cancel if report already submitted / pending approval
        // if (!in_array($rp_status, [$s_pendApproval_id, $s_pendReview_id])) {
        //     $failed++;
        //     $fail_list[] = "RP ID $rp_id (Not allowed status)";
        //     continue;
        // }

        // -----------------------------------------
        // 2) Generate cancel docno (unique)
        // -----------------------------------------
        $docno_cancel = $session_comp . $s2w_rp_cancelcode . $doc_date . str_pad($s2w_rp_cancelcode_max + $success, 4, "0", STR_PAD_LEFT);

        // -----------------------------------------
        // 3) Update report to Cancelled
        // -----------------------------------------
        $stmtU = $db_con->prepare("
            UPDATE inspection_s2w_report
            SET 
                rp_s2w_docno = ?,
                rp_s2w_docnocancel = ?,
                rp_s2w_status      = ?,
                cancel_remark      = ?,
                cancelled_by       = ?,
                cancelled_date     = NOW()
            WHERE rp_id = ?
        ");
        $stmtU->bind_param("ssissi", $docno_new, $docno_cancel, $s_cancelled_id, $remark, $session_id, $rp_id);

        if (!$stmtU->execute()) {
            $failed++;
            $fail_list[] = "RP ID $rp_id (Cancel update failed)";
            continue;
        }

        // -----------------------------------------
        // 4) Reset parent statuses back to New
        // -----------------------------------------
        $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_rp_status = ? WHERE sr_id = ?");
        $stmt2->bind_param("ii", $s_new_id, $sr_id);
        $stmt2->execute();

        $stmt2_1 = $db_con->prepare("UPDATE inspection_records SET ir_s2w_rp_status = ? WHERE ir_id = ?");
        $stmt2_1->bind_param("ii", $s_new_id, $ir_id);
        $stmt2_1->execute();

        $stmt2_2 = $db_con->prepare("UPDATE inspection_s2w SET s2w_rp_status = ? WHERE s2w_id = ?");
        $stmt2_2->bind_param("ii", $s_new_id, $s2w_id);
        $stmt2_2->execute();

        // -----------------------------------------
        // 5) Fetch details for activity comment
        // -----------------------------------------
        $stmt4 = $db_con->prepare("
                    SELECT S.rp_id, S.rp_s2w_docno, R.inspect_date, R.ir_shift
                    FROM inspection_s2w_report S
                    LEFT JOIN inspection_records R ON R.ir_id = S.rp_s2w_ir_id
                    WHERE S.rp_id = ?
                ");
        $stmt4->bind_param("i", $rp_id);
        $stmt4->execute();
        $inspectiondet = $stmt4->get_result()->fetch_assoc();

        // -----------------------------------------
        // 6) Insert activity comment
        // -----------------------------------------
        $appsection = 'PDI';
        $apptask = 'S2W_report';
        $comment_status = "cancel Something When Wrong (S2W) report submission";

        $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? AND section = ? AND task = ?";
        $stmtr_quamax = $db_con->prepare($query_quamax);
        $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
        $stmtr_quamax->execute();
        $row_quamax = $stmtr_quamax->get_result()->fetch_array();

        $next_priority = ($row_quamax[0] + 1);

        $rinsert5 = $db_con->prepare("
            INSERT INTO activity_comment
            (section, task, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        $rinsert5->bind_param(
            "sssssssssss",
            $appsection,
            $apptask,
            $s_cancelled_id,
            $docno_cancel,
            $inspectiondet['ir_shift'],
            $inspectiondet['inspect_date'],
            $comment_status,
            $next_priority,
            $session_id,
            $session_id,
            $pst_datenow
        );
        $rinsert5->execute();

        $success++;
    }

    echo json_encode([
        "status" => ($failed == 0 ? "success" : "partial"),
        "message" => "Bulk cancel completed. Success: $success, Failed: $failed",
        "success_count" => $success,
        "failed_count" => $failed,
        "failed_list" => $fail_list
    ]);
    exit;
}

//Approve
if ($_POST['action'] == 'bulk_approve') {

    $ids = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No record selected.'
        ]);
        exit;
    }

    // statuses
    $approved_remark = $remark;
    $approved_by = $session_id;
    $approved_date = $pst_datenow;

    $s2w_status = $s_pendAck_id; // approved -> pending acknowledge

    mysqli_begin_transaction($db_con);

    try {

        // Prepare statements once (faster)
        $stmt_get = $db_con->prepare("
            SELECT rp_id, rp_s2w_ir_id, rp_s2w_sr_id, rp_s2w_id
            FROM inspection_s2w_report
            WHERE rp_id = ?
        ");

        $stmt_ir = $db_con->prepare("
            UPDATE inspection_records 
            SET ir_s2w_rp_status = ?, ir_s2w_ack_status = ?
            WHERE ir_id = ?
        ");

        $stmt_sr = $db_con->prepare("
            UPDATE inspection_sorting 
            SET sr_s2w_rp_status = ?, sr_s2w_ack_status = ?
            WHERE sr_id = ?
        ");

        $stmt_s2w = $db_con->prepare("
            UPDATE inspection_s2w 
            SET s2w_rp_status = ?, s2w_ack_status = ?
            WHERE s2w_id = ?
        ");

        $stmt_rp = $db_con->prepare("
            UPDATE inspection_s2w_report 
            SET rp_s2w_status = ?, 
                rp_s2w_ack_status = ?, 
                approved_remark = ?, 
                approved_by = ?, 
                approved_date = ?
            WHERE rp_id = ?
        ");

        $stmt_det = $db_con->prepare("
            SELECT s.rp_s2w_docno, r.ir_shift, r.shift_date
            FROM inspection_s2w_report s
            LEFT JOIN inspection_records r ON s.rp_s2w_ir_id = r.ir_id
            WHERE s.rp_id = ?
        ");

        $approvedCount = 0;
        $docnos = []; // Collect all document numbers
        $sr_current_shift = $current_shift;
        $sr_production_date = $shift_date;

        foreach ($ids as $rp_id) {

            $rp_id = intval($rp_id);
            if ($rp_id <= 0) continue;

            // 1) get rp details (ir_id, sr_id, s2w_id)
            $stmt_get->bind_param("i", $rp_id);
            $stmt_get->execute();
            $rpRow = $stmt_get->get_result()->fetch_assoc();

            if (!$rpRow) continue;

            $ir_id  = intval($rpRow['rp_s2w_ir_id']);
            $sr_id  = intval($rpRow['rp_s2w_sr_id']);
            $s2w_id = intval($rpRow['rp_s2w_id']);

            // 2) update inspection_records
            $stmt_ir->bind_param("iii", $s2w_status, $s_new_id, $ir_id);
            $stmt_ir->execute();

            // 3) update inspection_sorting
            $stmt_sr->bind_param("iii", $s2w_status, $s_new_id, $sr_id);
            $stmt_sr->execute();

            // 4) update inspection_s2w
            $stmt_s2w->bind_param("iii", $s2w_status, $s_new_id, $s2w_id);
            $stmt_s2w->execute();

            // 5) update inspection_s2w_report
            $stmt_rp->bind_param("iisssi", $s2w_status, $s_new_id, $approved_remark, $approved_by, $approved_date, $rp_id);
            $stmt_rp->execute();

            // 6) Collect document number and shift/date from first record
            $stmt_det->bind_param("i", $rp_id);
            $stmt_det->execute();
            $inspectiondet = $stmt_det->get_result()->fetch_assoc();

            if ($inspectiondet) {
                $s2w_docno = $inspectiondet['rp_s2w_docno'];
                
                // Collect document number
                if (!empty($s2w_docno)) {
                    $docnos[] = $s2w_docno;
                }

                // Get shift + date from first successful record
                if ($approvedCount == 0) {
                    $sr_current_shift = $inspectiondet['ir_shift'];
                    $sr_production_date = $inspectiondet['shift_date'];
                }
            }

            $approvedCount++;
        }

        // ===============================
        // Insert SINGLE activity comment with ALL document numbers
        // ===============================
        if ($approvedCount > 0 && count($docnos) > 0) {
            
            $combined_docnos = implode(', ', $docnos);
            
            $appsection = 'PDI';
            $apptask = 'S2W REPORT';
            $comment_status = "approved the Something When Wrong (S2W) Report";

            $stmt_max = $db_con->prepare("
                SELECT MAX(comment_priority) AS max_priority
                FROM activity_comment
                WHERE staff_id = ? AND section = ? AND task = ?
            ");
            $stmt_max->bind_param("sss", $session_id, $appsection, $apptask);
            $stmt_max->execute();
            $row_quamax = $stmt_max->get_result()->fetch_assoc();

            $next_priority = (int)($row_quamax['max_priority'] ?? 0) + 1;

            $stmt_insert_comment = $db_con->prepare("
                INSERT INTO activity_comment
                    (section, task, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date)
                VALUES
                    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt_insert_comment->bind_param(
                "sssssssssss",
                $appsection,
                $apptask,
                $s2w_status,
                $combined_docnos,  // Multiple document numbers separated by commas
                $sr_current_shift,
                $sr_production_date,
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $stmt_insert_comment->execute();
        }

        mysqli_commit($db_con);

        echo json_encode([
            'status' => 'success',
            'message' => "Approved successfully ($approvedCount record(s))."
        ]);
        exit;

    } catch (Exception $e) {

        mysqli_rollback($db_con);

        echo json_encode([
            'status' => 'error',
            'message' => 'Bulk approve failed: ' . $e->getMessage()
        ]);
        exit;
    }
}

//Return
if ($_POST['action'] == 'bulk_return') {

    $ids    = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No records selected']);
        exit;
    }

    if ($remark == '') {
        echo json_encode(['status' => 'error', 'message' => 'Remark is required']);
        exit;
    }

    $returned_remark = $remark;
    $returned_by     = $session_id;
    $returned_date   = $pst_datenow;

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount    = 0;
        $failedList   = [];
        $docnos = []; // Collect all document numbers
        $sr_current_shift = $current_shift;
        $sr_production_date = $shift_date;

        foreach ($ids as $id) {

            $s2w_id = intval($id);
            if ($s2w_id <= 0) {
                $failCount++;
                $failedList[] = "Invalid S2W ID ($id)";
                continue;
            }

            // 1) Find S2W record
            $stmtFind = $db_con->prepare("
                SELECT s2w_id, s2w_ir_id, s2w_sr_id, s2w_docno, s2w_status
                FROM inspection_s2w
                WHERE s2w_id = ?
                LIMIT 1
            ");
            $stmtFind->bind_param("i", $s2w_id);
            $stmtFind->execute();
            $s2w = $stmtFind->get_result()->fetch_assoc();

            if (!$s2w) {
                $failCount++;
                $failedList[] = "S2W:$s2w_id not found";
                continue;
            }

            $ir_id     = intval($s2w['s2w_ir_id']);
            $sr_id     = intval($s2w['s2w_sr_id']);
            $s2w_docno = $s2w['s2w_docno'];
            $curStatus = intval($s2w['s2w_status']);

            // Only allow return if status is 9 or 10
            if (!in_array($curStatus, [9, 10])) {
                $failCount++;
                $failedList[] = "S2W:$s2w_id invalid status ($curStatus)";
                continue;
            }

            $newStatus = $s_return_id;

            // 2) Update inspection_records
            $stmt1 = $db_con->prepare("
                UPDATE inspection_records
                SET ir_s2w_status = ?
                WHERE ir_id = ?
            ");
            $stmt1->bind_param("ii", $newStatus, $ir_id);
            $stmt1->execute();

            // 3) Update inspection_sorting
            $stmt2 = $db_con->prepare("
                UPDATE inspection_sorting
                SET sr_s2w_status = ?
                WHERE sr_id = ?
            ");
            $stmt2->bind_param("ii", $newStatus, $sr_id);
            $stmt2->execute();

            // 4) Update inspection_s2w based on current status
            if ($curStatus == 9) {

                $stmt3 = $db_con->prepare("
                    UPDATE inspection_s2w
                    SET s2w_status = ?,
                        rvw_returned_remark = ?,
                        rvw_returned_by = ?,
                        rvw_returned_date = ?
                    WHERE s2w_id = ?
                ");
                $stmt3->bind_param("isssi", $newStatus, $returned_remark, $returned_by, $returned_date, $s2w_id);
                $stmt3->execute();

            } else if ($curStatus == 10) {

                $stmt3 = $db_con->prepare("
                    UPDATE inspection_s2w
                    SET s2w_status = ?,
                        app_returned_remark = ?,
                        app_returned_by = ?,
                        app_returned_date = ?
                    WHERE s2w_id = ?
                ");
                $stmt3->bind_param("isssi", $newStatus, $returned_remark, $returned_by, $returned_date, $s2w_id);
                $stmt3->execute();
            }

            // Collect document number
            if (!empty($s2w_docno)) {
                $docnos[] = $s2w_docno;
            }

            // Get shift + date from first successful record
            if ($successCount == 0) {
                $stmtShift = $db_con->prepare("
                    SELECT ir_shift, shift_date
                    FROM inspection_records
                    WHERE ir_id = ?
                    LIMIT 1
                ");
                $stmtShift->bind_param("i", $ir_id);
                $stmtShift->execute();
                $inspectiondet = $stmtShift->get_result()->fetch_assoc();

                $sr_current_shift   = $inspectiondet['ir_shift'] ?? $current_shift;
                $sr_production_date = $inspectiondet['shift_date'] ?? $shift_date;
            }

            $successCount++;
        }

        // ===============================
        // Insert SINGLE activity comment with ALL document numbers
        // ===============================
        if ($successCount > 0 && count($docnos) > 0) {
            
            $combined_docnos = implode(', ', $docnos);
            
            $appsection = 'PDI';
            $apptask    = 'S2W';
            $comment_status = "returned the Something When Wrong (S2W)";

            $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? AND section = ? AND task = ?";
            $stmtr_quamax = $db_con->prepare($query_quamax);
            $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
            $stmtr_quamax->execute();
            $rst_quamax = $stmtr_quamax->get_result();
            $row_quamax = $rst_quamax->fetch_array();
            $next_priority = ($row_quamax[0] + 1);

            $stmtAct = $db_con->prepare("
                INSERT INTO activity_comment
                    (section, task, form_status, docno, prod_shift, shift_date, status_comment,
                     comment_priority, staff_id, commentator, comment_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmtAct->bind_param(
                "sssssssssss",
                $appsection,
                $apptask,
                $newStatus,
                $combined_docnos,  // Multiple document numbers separated by commas
                $sr_current_shift,
                $sr_production_date,
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $stmtAct->execute();
        }

        $db_con->commit();

        echo json_encode([
            'status' => 'success',
            'message' => "Bulk return completed. Success: $successCount, Failed: $failCount",
            'failed_list' => $failedList
        ]);
        exit;

    } catch (Exception $e) {

        $db_con->rollback();

        echo json_encode([
            'status' => 'error',
            'message' => 'Bulk return failed: ' . $e->getMessage()
        ]);
        exit;
    }
}

//Acknowledge
if ($_POST['action'] == 'bulk_acknowledge') {

    $ids = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'No record selected.'
        ]);
        exit;
    }

    $ack_remark = $remark;
    $ack_by = $session_id;
    $ack_date = $pst_datenow;

    $s2w_status = $s_completed_id; // acknowledge -> completed

    mysqli_begin_transaction($db_con);

    try {

        // 1) Get IDs from rp_id
        $stmt_get = $db_con->prepare("
            SELECT rp_id, rp_s2w_ir_id, rp_s2w_sr_id, rp_s2w_id
            FROM inspection_s2w_report
            WHERE rp_id = ?
        ");

        // 2) Update inspection_records
        $stmt_ir = $db_con->prepare("
            UPDATE inspection_records SET 
                ir_status = ?,
                ir_sorting_status = ?,
                ir_s2w_status = ?, 
                ir_s2w_rp_status = ?, 
                ir_s2w_ack_status = ?
            WHERE ir_id = ?
        ");

        // 3) Update inspection_sorting
        $stmt_sr = $db_con->prepare("
            UPDATE inspection_sorting SET 
                sr_status = ?,
                sr_s2w_status = ?,
                sr_s2w_rp_status = ?,
                sr_s2w_ack_status = ?
            WHERE sr_id = ?
        ");

        // 4) Update inspection_s2w
        $stmt_s2w = $db_con->prepare("
            UPDATE inspection_s2w SET 
                s2w_status = ?,
                s2w_rp_status = ?,
                s2w_ack_status = ?
            WHERE s2w_id = ?
        ");

        // 5) Update inspection_s2w_report
        $stmt_rp = $db_con->prepare("
            UPDATE inspection_s2w_report SET 
                rp_s2w_status = ?, 
                rp_s2w_ack_status = ?,
                acknowledge_remark = ?, 
                acknowledge_by = ?, 
                acknowledge_date = ?
            WHERE rp_id = ?
        ");

        // 6) Fetch inspection details (for activity log)
        $stmt_det = $db_con->prepare("
            SELECT s.rp_s2w_docno, r.ir_shift, r.shift_date
            FROM inspection_s2w_report s
            LEFT JOIN inspection_records r ON s.rp_s2w_ir_id = r.ir_id
            WHERE s.rp_id = ?
        ");

        // 7) Get max priority
        $stmt_max = $db_con->prepare("
            SELECT MAX(comment_priority) AS max_priority
            FROM activity_comment
            WHERE staff_id = ? AND section = ? AND task = ?
        ");

        // 8) Insert activity_comment
        $stmt_insert = $db_con->prepare("
            INSERT INTO activity_comment
                (section, task, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date)
            VALUES
                (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        $done = 0;

        foreach ($ids as $rp_id) {

            $rp_id = intval($rp_id);
            if ($rp_id <= 0) continue;

            // get ir_id, sr_id, s2w_id from rp_id
            $stmt_get->bind_param("i", $rp_id);
            $stmt_get->execute();
            $rpRow = $stmt_get->get_result()->fetch_assoc();

            if (!$rpRow) continue;

            $ir_id  = intval($rpRow['rp_s2w_ir_id']);
            $sr_id  = intval($rpRow['rp_s2w_sr_id']);
            $s2w_id = intval($rpRow['rp_s2w_id']);

            // update inspection_records
            $stmt_ir->bind_param("iiiiii",
                $s2w_status, $s2w_status, $s2w_status, $s2w_status, $s2w_status, $ir_id
            );
            $stmt_ir->execute();

            // update inspection_sorting
            $stmt_sr->bind_param("iiiii",
                $s2w_status, $s2w_status, $s2w_status, $s2w_status, $sr_id
            );
            $stmt_sr->execute();

            // update inspection_s2w
            $stmt_s2w->bind_param("iiii",
                $s2w_status, $s2w_status, $s2w_status, $s2w_id
            );
            $stmt_s2w->execute();

            // update inspection_s2w_report
            $stmt_rp->bind_param("iisssi",
                $s2w_status, $s2w_status, $ack_remark, $ack_by, $ack_date, $rp_id
            );
            $stmt_rp->execute();

            // activity log
            $stmt_det->bind_param("i", $rp_id);
            $stmt_det->execute();
            $inspectiondet = $stmt_det->get_result()->fetch_assoc();

            if ($inspectiondet) {

                $s2w_docno = $inspectiondet['rp_s2w_docno'];
                $sr_current_shift = $inspectiondet['ir_shift'];
                $sr_production_date = $inspectiondet['shift_date'];

                $appsection = 'PDI';
                $apptask = 'S2W REPORT';
                $comment_status = "acknowledge the Something When Wrong (S2W) Report";

                $stmt_max->bind_param("sss", $session_id, $appsection, $apptask);
                $stmt_max->execute();
                $row_max = $stmt_max->get_result()->fetch_assoc();

                $next_priority = (int)($row_max['max_priority'] ?? 0) + 1;

                $stmt_insert->bind_param("sssssssssss",
                    $appsection,
                    $apptask,
                    $s2w_status,
                    $s2w_docno,
                    $sr_current_shift,
                    $sr_production_date,
                    $comment_status,
                    $next_priority,
                    $session_id,
                    $session_id,
                    $pst_datenow
                );
                $stmt_insert->execute();
            }

            $done++;
        }

        mysqli_commit($db_con);

        echo json_encode([
            'status' => 'success',
            'message' => "S2W report acknowledged successfully ($done record(s))."
        ]);
        exit;

    } catch (Exception $e) {

        mysqli_rollback($db_con);

        echo json_encode([
            'status' => 'error',
            'message' => 'Bulk acknowledge failed: ' . $e->getMessage()
        ]);
        exit;
    }
}


exit;

?>