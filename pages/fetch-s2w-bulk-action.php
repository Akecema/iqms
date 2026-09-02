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

//Bulk Approve
$ids = $_POST['ids'] ?? [];
$remark = trim($_POST['remark'] ?? '');

if (empty($ids)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'No records selected'
    ]);
    exit;
}

$ids = array_map('intval', $ids);
$idList = implode(',', $ids);

//Submit
if ($_POST['action'] == 'bulk_submit') {

    $ids      = $_POST['ids'] ?? [];

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No record selected']);
        exit;
    }

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;
        $failedList = [];

        foreach ($ids as $srid) {

            $sr_id = intval($srid);
            if ($sr_id <= 0) continue;

            // 1) Find IR + S2W by sr_id
            $stmtFind = $db_con->prepare("
                SELECT 
                    S.sr_id,
                    S.sr_ir_id,
                    W.s2w_id,
                    W.s2w_status,
                    W.s2w_docno
                FROM inspection_sorting S
                LEFT JOIN inspection_s2w W ON W.s2w_sr_id = S.sr_id
                WHERE S.sr_id = ? and W.s2w_status != 8
                LIMIT 1
            ");
            $stmtFind->bind_param("i", $sr_id);
            $stmtFind->execute();
            $row = $stmtFind->get_result()->fetch_assoc();

            if (!$row) {
                $failCount++;
                $failedList[] = "SR:$sr_id not found";
                continue;
            }

            $ir_id      = intval($row['sr_ir_id']);
            $s2w_id     = intval($row['s2w_id']);
            $s2w_status = intval($row['s2w_status']);
            $s2w_docno  = $row['s2w_docno'];

            if ($ir_id <= 0 || $s2w_id <= 0) {
                $failCount++;
                $failedList[] = "SR:$sr_id missing IR/S2W";
                continue;
            }

            // 2) If Draft → generate docno
            if ($s2w_status == $s_draft_id) {

                $transmodule = "S2W";
                $transprocess = "New";

                $running_no = getNextTransactionNo(
                    $db_con,
                    $transmodule,
                    $transprocess,
                    $current_shift,
                    $shift_date
                );

                $s2w_docno = $session_comp . $s2w_code . $doc_date . $running_no;

                $stmtUpdate = $db_con->prepare("
                    UPDATE inspection_s2w
                    SET s2w_docno = ?,
                        s2w_status = ?,
                        submitted_by = ?,
                        submitted_date = NOW()
                    WHERE s2w_id = ?
                ");
                $stmtUpdate->bind_param(
                    "sisi",
                    $s2w_docno,
                    $s_pendReview_id,
                    $session_id,
                    $s2w_id
                );
                $stmtUpdate->execute();

            } else {

                // Returned / Edit → resubmit (docno already exist)
                $stmtUpdate = $db_con->prepare("
                    UPDATE inspection_s2w
                    SET 
                        s2w_status = ?,
                        submitted_by = ?,
                        submitted_date = NOW()
                    WHERE s2w_id = ?
                ");
                $stmtUpdate->bind_param(
                    "isi",
                    $s_pendReview_id,
                    $session_id,
                    $s2w_id
                );
                $stmtUpdate->execute();
            }

            // 3) Update inspection_records status
            $stmtRec = $db_con->prepare("
                UPDATE inspection_records
                SET ir_s2w_status = ?
                WHERE ir_id = ?
            ");
            $stmtRec->bind_param("ii", $s_pendReview_id, $ir_id);
            $stmtRec->execute();

            // 4) Update inspection_sorting status
            $stmtSort = $db_con->prepare("
                UPDATE inspection_sorting
                SET sr_s2w_status = ?
                WHERE sr_id = ?
            ");
            $stmtSort->bind_param("ii", $s_pendReview_id, $sr_id);
            $stmtSort->execute();

            // 5) Activity Comment
            $appsection = 'PDI';
            $apptask = 'S2W';
            $comment_status = "submit the Something When Wrong (S2W)";

            $query_quamax = "SELECT MAX(comment_priority)
                             FROM activity_comment
                             WHERE staff_id = ? AND section = ? AND task = ?";
            $stmtr_quamax = $db_con->prepare($query_quamax);
            $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
            $stmtr_quamax->execute();
            $rst_quamax = $stmtr_quamax->get_result();
            $row_quamax = $rst_quamax->fetch_array();
            $next_priority = ($row_quamax[0] + 1);

            // get shift + date
            $stmtDet = $db_con->prepare("
                SELECT ir_shift, inspect_date
                FROM inspection_records
                WHERE ir_id = ?
                LIMIT 1
            ");
            $stmtDet->bind_param("i", $ir_id);
            $stmtDet->execute();
            $inspectiondet = $stmtDet->get_result()->fetch_assoc();

            $rinsert5 = $db_con->prepare("
                INSERT INTO activity_comment
                    (section, task, form_status, docno, prod_shift, shift_date, status_comment,
                     comment_priority, staff_id, commentator, comment_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $rinsert5->bind_param(
                "sssssssssss",
                $appsection,
                $apptask,
                $s_pendReview_id,
                $s2w_docno,
                $inspectiondet['ir_shift'],
                $inspectiondet['inspect_date'],
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $rinsert5->execute();

            $successCount++;
        }

        $db_con->commit();

        echo json_encode([
            'status' => 'success',
            'message' => "Bulk submit completed. Success: $successCount, Failed: $failCount",
            'failed_list' => $failedList
        ]);
        exit;

    } catch (Exception $e) {

        $db_con->rollback();

        echo json_encode([
            'status' => 'error',
            'message' => 'Bulk submit failed: ' . $e->getMessage()
        ]);
        exit;
    }
}

//Cancel
if ($_POST['action'] == 'bulk_cancel') {

    $ids    = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No record selected']);
        exit;
    }

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;
        $failedList = [];

        foreach ($ids as $srid) {

            $sr_id = intval($srid);
            if ($sr_id <= 0) continue;

            // 1) Find IR + S2W by sr_id
            $stmtFind = $db_con->prepare("
                SELECT 
                    S.sr_id,
                    S.sr_ir_id,
                    W.s2w_id,
                    W.s2w_status,
                    W.s2w_docno
                FROM inspection_sorting S
                LEFT JOIN inspection_s2w W ON W.s2w_sr_id = S.sr_id
                WHERE S.sr_id = ? and W.s2w_status != 8
                LIMIT 1
            ");
            $stmtFind->bind_param("i", $sr_id);
            $stmtFind->execute();
            $row = $stmtFind->get_result()->fetch_assoc();

            if (!$row) {
                $failCount++;
                $failedList[] = "SR:$sr_id not found";
                continue;
            }

            $ir_id      = intval($row['sr_ir_id']);
            $s2w_id     = intval($row['s2w_id']);
            $s2w_status = intval($row['s2w_status']);
            $s2w_docno  = $row['s2w_docno'];

            if ($ir_id <= 0 || $s2w_id <= 0) {
                $failCount++;
                $failedList[] = "SR:$sr_id missing IR/S2W";
                continue;
            }

            // 2) Validate status (only allow cancel if Submitted / Pending Review etc.)
            // adjust this list to your flow
            if (!in_array($s2w_status, [$s_pendReview_id, $s_draft_id, 12, 13])) {
                $failCount++;
                $failedList[] = "SR:$sr_id cannot cancel (status:$s2w_status)";
                continue;
            }

            // 3) Generate cancel docno
            // You can use your own running number logic here if you already have function
            // Example: getNextTransactionNo for Cancel
            $transmodule = "S2W";
            $transprocess = "Cancel";

            $running_no_cancel = getNextTransactionNo(
                $db_con,
                $transmodule,
                $transprocess,
                $current_shift,
                $shift_date
            );

            $docno_cancel = $session_comp . $s2w_cancelcode . $doc_date . $running_no_cancel;

            // 4) Update inspection_s2w -> Cancelled
            $stmt = $db_con->prepare("
                UPDATE inspection_s2w
                SET s2w_docnocancel = ?,
                    s2w_status = ?,
                    cancel_remark = ?,
                    cancelled_by = ?,
                    cancelled_date = NOW()
                WHERE s2w_id = ?
            ");
            $stmt->bind_param("sissi", $docno_cancel, $s_cancelled_id, $remark, $session_id, $s2w_id);
            $stmt->execute();

            // 5) Reset SR + IR s2w status to New
            $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
            $stmt2->bind_param("ii", $s_new_id, $sr_id);
            $stmt2->execute();

            $stmt2_1 = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
            $stmt2_1->bind_param("ii", $s_new_id, $ir_id);
            $stmt2_1->execute();

            // 6) Fetch inspection details for activity comment
            $stmt4 = $db_con->prepare("
                SELECT R.inspect_date, R.ir_shift
                FROM inspection_records R
                WHERE R.ir_id = ?
                LIMIT 1
            ");
            $stmt4->bind_param("i", $ir_id);
            $stmt4->execute();
            $inspectiondet = $stmt4->get_result()->fetch_assoc();

            // 7) Insert activity comment
            $appsection = 'PDI';
            $apptask = 'S2W';
            $comment_status = "cancel Something When Wrong (S2W) submission";

            $query_quamax = "SELECT MAX(comment_priority)
                             FROM activity_comment
                             WHERE staff_id = ? AND section = ? AND task = ?";
            $stmtr_quamax = $db_con->prepare($query_quamax);
            $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
            $stmtr_quamax->execute();
            $rst_quamax = $stmtr_quamax->get_result();
            $row_quamax = $rst_quamax->fetch_array();

            $next_priority = ($row_quamax[0] + 1);

            $rinsert5 = $db_con->prepare("
                INSERT INTO activity_comment
                    (section, task, form_status, docno, prod_shift, shift_date, status_comment,
                     comment_priority, staff_id, commentator, comment_date)
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

            $successCount++;
        }

        $db_con->commit();

        echo json_encode([
            'status' => 'success',
            'message' => "Bulk cancel completed. Success: $successCount, Failed: $failCount",
            'failed_list' => $failedList
        ]);
        exit;

    } catch (Exception $e) {

        $db_con->rollback();

        echo json_encode([
            'status' => 'error',
            'message' => 'Bulk cancel failed: ' . $e->getMessage()
        ]);
        exit;
    }
}

//Reviwed
if ($_POST['action'] == 'bulk_review') {

    $ids    = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No records selected']);
        exit;
    }

    $approved_remark = $remark;
    $approved_by     = $session_id;
    $approved_date   = $pst_datenow;

    $s2w_status      = $s_pendApproval_id;

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;
        $failedList = [];

        foreach ($ids as $id) {

            $s2w_id = intval($id);
            if ($s2w_id <= 0) continue;

            // 1) Find sr_id + ir_id from s2w
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

            // 2) Only allow approve if Pending Review (example = 9)
            if ($curStatus != $s_pendReview_id) {
                $failCount++;
                $failedList[] = "S2W:$s2w_id invalid status ($curStatus)";
                continue;
            }

            // 3) Update inspection_records
            $stmt = $db_con->prepare("
                UPDATE inspection_records
                SET ir_s2w_status = ?,
                    ir_s2w_rp_status = ?
                WHERE ir_id = ?
            ");
            $stmt->bind_param("iii", $s2w_status, $s_new_id, $ir_id);
            $stmt->execute();

            // 4) Update inspection_sorting
            $stmt2 = $db_con->prepare("
                UPDATE inspection_sorting
                SET sr_s2w_status = ?
                WHERE sr_id = ?
            ");
            $stmt2->bind_param("ii", $s2w_status, $sr_id);
            $stmt2->execute();

            // 5) Update inspection_s2w
            $stmt3 = $db_con->prepare("
                UPDATE inspection_s2w
                SET s2w_status = ?,
                    s2w_rp_status = ?,
                    reviewed_remark = ?,
                    reviewed_by = ?,
                    reviewed_date = ?
                WHERE s2w_id = ?
            ");
            $stmt3->bind_param("iisssi", $s2w_status, $s_new_id, $approved_remark, $approved_by, $approved_date, $s2w_id);
            $stmt3->execute();

            // 6) Fetch shift + production date for activity log
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

            // 7) Insert activity comment
            $appsection = 'PDI';
            $apptask = 'S2W';
            $comment_status = "review the Something When Wrong (S2W)";

            $query_quamax = "
                SELECT MAX(comment_priority)
                FROM activity_comment
                WHERE staff_id = ? AND section = ? AND task = ?
            ";
            $stmtr_quamax = $db_con->prepare($query_quamax);
            $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
            $stmtr_quamax->execute();
            $rst_quamax = $stmtr_quamax->get_result();
            $row_quamax = $rst_quamax->fetch_array();

            $next_priority = ($row_quamax[0] + 1);

            $rinsert5 = $db_con->prepare("
                INSERT INTO activity_comment
                    (section, task, form_status, docno, prod_shift, shift_date, status_comment,
                     comment_priority, staff_id, commentator, comment_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $rinsert5->bind_param(
                "sssssssssss",
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
            $rinsert5->execute();

            $successCount++;
        }

        $db_con->commit();

        echo json_encode([
            'status' => 'success',
            'message' => "Bulk approve completed. Success: $successCount, Failed: $failCount",
            'failed_list' => $failedList
        ]);
        exit;

    } catch (Exception $e) {

        $db_con->rollback();

        echo json_encode([
            'status' => 'error',
            'message' => 'Bulk approve failed: ' . $e->getMessage()
        ]);
        exit;
    }
}

//Approve
if ($_POST['action'] == 'bulk_approve') {

    $ids    = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No records selected']);
        exit;
    }

    $approved_remark = $remark;
    $approved_by     = $session_id;
    $approved_date   = $pst_datenow;

    $newStatus = $s_approved_id; // final approved

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount    = 0;
        $failedList   = [];

        foreach ($ids as $id) {

            $s2w_id = intval($id);
            if ($s2w_id <= 0) {
                $failCount++;
                $failedList[] = "Invalid S2W ID ($id)";
                continue;
            }

            // 1) Get S2W record
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

            // 2) Only allow approve if status = 10 (Pending Approve)
            if ($curStatus != $s_pendApproval_id) {   // <-- make sure $s_pendApprove_id = 10
                $failCount++;
                $failedList[] = "S2W:$s2w_id invalid status ($curStatus)";
                continue;
            }

            // 3) Update inspection_records
            $stmt1 = $db_con->prepare("
                UPDATE inspection_records
                SET ir_s2w_status = ?, ir_s2w_rp_status = ?
                WHERE ir_id = ?
            ");
            $stmt1->bind_param("iii", $newStatus, $s_new_id, $ir_id);
            $stmt1->execute();

            // 4) Update inspection_sorting
            $stmt2 = $db_con->prepare("
                UPDATE inspection_sorting
                SET sr_s2w_status = ?
                WHERE sr_id = ?
            ");
            $stmt2->bind_param("ii", $newStatus, $sr_id);
            $stmt2->execute();

            // 5) Update inspection_s2w
            $stmt3 = $db_con->prepare("
                UPDATE inspection_s2w
                SET s2w_status = ?,
                    s2w_rp_status = ?,
                    approved_remark = ?,
                    approved_by = ?,
                    approved_date = ?
                WHERE s2w_id = ?
            ");
            $stmt3->bind_param("iisssi", $newStatus, $s_new_id, $approved_remark, $approved_by, $approved_date, $s2w_id);
            $stmt3->execute();

            // 6) Fetch shift + production date for activity log
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

            // 7) Insert activity comment
            $appsection = 'PDI';
            $apptask = 'S2W';
            $comment_status = "approved the Something When Wrong (S2W)";

            $query_quamax = "
                SELECT MAX(comment_priority)
                FROM activity_comment
                WHERE staff_id = ? AND section = ? AND task = ?
            ";
            $stmtr_quamax = $db_con->prepare($query_quamax);
            $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
            $stmtr_quamax->execute();
            $rst_quamax = $stmtr_quamax->get_result();
            $row_quamax = $rst_quamax->fetch_array();

            $next_priority = ($row_quamax[0] + 1);

            $rinsert5 = $db_con->prepare("
                INSERT INTO activity_comment
                    (section, task, form_status, docno, prod_shift, shift_date, status_comment,
                     comment_priority, staff_id, commentator, comment_date)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $rinsert5->bind_param(
                "sssssssssss",
                $appsection,
                $apptask,
                $newStatus,
                $s2w_docno,
                $sr_current_shift,
                $sr_production_date,
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $rinsert5->execute();

            $successCount++;
        }

        $db_con->commit();

        echo json_encode([
            'status' => 'success',
            'message' => "Bulk approve completed. Success: $successCount, Failed: $failCount",
            'failed_list' => $failedList
        ]);
        exit;

    } catch (Exception $e) {

        $db_con->rollback();

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

            // 5) Get shift + production date
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

            // 6) Activity comment
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
                $s2w_docno,
                $sr_current_shift,
                $sr_production_date,
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $stmtAct->execute();

            $successCount++;
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

exit;

?>