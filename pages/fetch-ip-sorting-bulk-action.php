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
include 'system-status.php';include 'system-transaction-code.php';
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

    $ids = $_POST['ids'] ?? [];
    $transid = 3;

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No record selected.']);
        exit;
    }

    // get reviewer recipients once (NOT inside loop)
    $recipients = [];
    $sql = "SELECT E.staff_name, E.staff_email
            FROM user_authorization A 
            LEFT JOIN employee_details E ON E.staff_id = A.staff_id
            WHERE A.SR_reviewer = 'Y'";
    $result = $db_con->query($sql);
    while ($row = $result->fetch_assoc()) {
        if (!empty($row['staff_email'])) {
            $recipients[] = $row;
        }
    }

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;
        $submittedDocs = []; // for email summary

        foreach ($ids as $id) {

            $ir_id = intval($id);
            if ($ir_id <= 0) continue;

            // 1) Check current sorting status MUST be 13
            $chk = $db_con->prepare("
                SELECT ir_sorting_status
                FROM inspection_records
                WHERE ir_id = ?
            ");
            $chk->bind_param("i", $ir_id);
            $chk->execute();
            $chkRow = $chk->get_result()->fetch_assoc();

            // Allow both Draft (12) and Returned (13)
            if (!$chkRow || !in_array(intval($chkRow['ir_sorting_status']), [12, 13])) {
                $failCount++;
                continue;
            }

            // 2) Get sorting record (sr_id, sr_status, sr_docno)
            $getSR = $db_con->prepare("
                SELECT sr_id, sr_status, sr_docno
                FROM inspection_sorting
                WHERE sr_ir_id = ?  and sr_status != 8
                ORDER BY sr_id DESC
                LIMIT 1
            ");
            $getSR->bind_param("i", $ir_id);
            $getSR->execute();
            $sr = $getSR->get_result()->fetch_assoc();

            if (!$sr) {
                $failCount++;
                continue;
            }

            $sr_id = intval($sr['sr_id']);
            $sr_status = intval($sr['sr_status']);
            $ir_docno = $sr['sr_docno']; // existing docno

            // 3) If sr_status = Draft -> generate NEW docno
            if ($sr_status == $s_draft_id) {

                $transmodule = "SR";
                $transprocess = "New";

                $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

                $ir_docno = $session_comp . $sr_code . $doc_date . $running_no;

                $stmtUpdate = $db_con->prepare("
                    UPDATE inspection_sorting
                    SET sr_docno = ?,
                        sr_status = ?,
                        submitted_by = ?,
                        submitted_date = NOW()
                    WHERE sr_id = ?
                ");
                $stmtUpdate->bind_param("sisi", $ir_docno, $s_pendReview_id, $session_id, $sr_id);
                $stmtUpdate->execute();

            } else {

                // returned SR and resubmit (keep docno)
                $stmtUpdate = $db_con->prepare("
                    UPDATE inspection_sorting
                    SET sr_status = ?,
                        submitted_by = ?,
                        submitted_date = NOW()
                    WHERE sr_id = ?
                ");
                $stmtUpdate->bind_param("isi", $s_pendReview_id, $session_id, $sr_id);
                $stmtUpdate->execute();
            }

            // 4) Update inspection_records sorting status
            $stmtRec = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? WHERE ir_id = ?");
            $stmtRec->bind_param("ii", $s_pendReview_id, $ir_id);
            $stmtRec->execute();

            // 5) Insert activity comment
            $appsection = 'PDI';
            $apptask = 'SR';
            $comment_status = "submit the sorting report";

            $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? AND section = ? AND task = ?";
            $stmtr_quamax = $db_con->prepare($query_quamax);
            $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
            $stmtr_quamax->execute();
            $rst_quamax = $stmtr_quamax->get_result();
            $row_quamax = $rst_quamax->fetch_array();
            $next_priority = ($row_quamax[0] + 1);

            // fetch inspection details for logging
            $stmtDet = $db_con->prepare("
                SELECT R.inspect_date, R.ir_shift
                FROM inspection_records R
                WHERE R.ir_id = ?
            ");
            $stmtDet->bind_param("i", $ir_id);
            $stmtDet->execute();
            $inspectiondet = $stmtDet->get_result()->fetch_assoc();

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
                $ir_docno,
                $inspectiondet['ir_shift'],
                $inspectiondet['inspect_date'],
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $rinsert5->execute();

            $submittedDocs[] = $ir_docno;
            $successCount++;
        }

        $db_con->commit();

        // 6) Send email ONCE (bulk summary)
        $emails_sent = 0;
        $emails_failed = 0;

        if (count($recipients) > 0 && count($submittedDocs) > 0) {

            $mail = new PHPMailer();

            $mail->isSMTP();
            $mail->Host = $host;
            $mail->SMTPAuth = true;
            $mail->Username = $email_username;
            $mail->Password = $email_password;
            $mail->Port = $port;

            $mail->setFrom($email_username, $system_name);
            $mail->isHTML(true);
            $mail->Subject = $esubject_5;

            $docListHtml = "<ul>";
            foreach ($submittedDocs as $dno) {
                $docListHtml .= "<li><strong>$dno</strong></li>";
            }
            $docListHtml .= "</ul>";

            foreach ($recipients as $authouser) {

                $mail->clearAddresses();
                $mail->addAddress($authouser['staff_email'], $authouser['staff_name']);

                $mail->Body = "<h4>Dear {$authouser['staff_name']},</h4>";
                $mail->Body .= "<p>Bulk sorting report submission has been made by <strong>$stf_name</strong>.</p>";
                $mail->Body .= "<p>Submitted Doc No:</p>";
                $mail->Body .= $docListHtml;
                $mail->Body .= "<p>Please log in and review:</p>";
                $mail->Body .= "<a href='{$system_url}'>{$system_url}</a>";
                $mail->Body .= "<p>** This is a system generated email. Please DO NOT REPLY. **</p>";

                if ($mail->send()) $emails_sent++;
                else $emails_failed++;
            }
        }

        echo json_encode([
            'status' => 'success',
            'message' => "Bulk submit completed. Success: $successCount, Failed: $failCount",
            'emails_sent' => $emails_sent,
            'emails_failed' => $emails_failed
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
    $transid = 4;

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No record selected.']);
        exit;
    }

    if ($remark == '') {
        echo json_encode(['status' => 'error', 'message' => 'Remark is required.']);
        exit;
    }

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;
        $failedList = [];

        foreach ($ids as $id) {

            $ir_id = intval($id);
            if ($ir_id <= 0) continue;

            // 1) Find latest SR record for this IR
            $getSR = $db_con->prepare("
                SELECT sr_id, sr_status
                FROM inspection_sorting
                WHERE sr_ir_id = ? and sr_status != 8
                ORDER BY sr_id DESC
                LIMIT 1
            ");
            $getSR->bind_param("i", $ir_id);
            $getSR->execute();
            $sr = $getSR->get_result()->fetch_assoc();

            if (!$sr) {
                $failCount++;
                $failedList[] = "IR:$ir_id (No sorting record found)";
                continue;
            }

            $sr_id = intval($sr['sr_id']);
            $sr_status = intval($sr['sr_status']);

            // 2) Only allow cancel if SR status = 9 (Submitted / Pending Review)
            if ($sr_status != 9) {
                $failCount++;
                $failedList[] = "IR:$ir_id (Invalid status: $sr_status)";
                continue;
            }

            $docno_new = "";

            // 3) Generate cancel docno (must be unique)
            // If you have running number logic, use getNextTransactionNo() here
            $sr_docnocanc = $session_comp . $sr_cancelcode . $doc_date . str_pad($sr_id, 5, "0", STR_PAD_LEFT);

            // 4) Update SR -> Cancelled (status=8)
            $stmt = $db_con->prepare("
                UPDATE inspection_sorting
                SET 
                    sr_docno = ?,
                    sr_docnocancel = ?,
                    sr_status = ?,
                    cancel_remark = ?,
                    cancelled_by = ?,
                    cancelled_date = NOW()
                WHERE sr_id = ?
            ");
            $stmt->bind_param("ssissi", $docno_new, $sr_docnocanc, $s_cancelled_id, $remark, $session_id, $sr_id);
            $stmt->execute();

            if ($stmt->affected_rows <= 0) {
                $failCount++;
                $failedList[] = "IR:$ir_id (Update failed)";
                continue;
            }

            // 5) Update inspection_records sorting status -> New (1)
            $stmt2 = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? WHERE ir_id = ?");
            $stmt2->bind_param("ii", $s_new_id, $ir_id);
            $stmt2->execute();

            // 6) Insert activity comment
            $appsection = 'PDI';
            $apptask = 'SR';
            $comment_status = "cancel sorting report submission";

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
                $sr_docnocanc,
                $current_shift,
                $shift_date,
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

    $sorting_status  = $s_reviewed_id; // or $s_approved_id

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;
        $failedList = [];
        $docnos = []; // Collect all document numbers
        $sr_current_shift = $current_shift;
        $sr_production_date = $shift_date;

        foreach ($ids as $id) {

            $sr_id = intval($id);
            if ($sr_id <= 0) continue;

            // Get sr_status + sr_docno + sr_ir_id
            $stmtGet = $db_con->prepare("
                SELECT sr_ir_id, sr_status, sr_docno
                FROM inspection_sorting
                WHERE sr_id = ?
                LIMIT 1
            ");
            $stmtGet->bind_param("i", $sr_id);
            $stmtGet->execute();
            $sr = $stmtGet->get_result()->fetch_assoc();

            if (!$sr) {
                $failCount++;
                $failedList[] = "SR:$sr_id not found";
                continue;
            }

            $ir_id     = intval($sr['sr_ir_id']);   // ✅ this is ir_id
            $sr_status = intval($sr['sr_status']);
            $sr_docno  = $sr['sr_docno'];

            if ($ir_id <= 0) {
                $failCount++;
                $failedList[] = "SR:$sr_id missing sr_ir_id";
                continue;
            }

            // Validate must be Pending Review (9)
            if ($sr_status != 9) {
                $failCount++;
                $failedList[] = "SR:$sr_id invalid status ($sr_status)";
                continue;
            }

            // Update inspection_records
            $stmt = $db_con->prepare("
                UPDATE inspection_records 
                SET ir_sorting_status = ?, 
                    ir_s2w_status = ? 
                WHERE ir_id = ?
            ");
            $stmt->bind_param("iii", $sorting_status, $s_new_id, $ir_id);
            $stmt->execute();

            // Update inspection_sorting
            $stmt2 = $db_con->prepare("
                UPDATE inspection_sorting
                SET sr_status = ?,
                    sr_s2w_status = ?,
                    approved_remark = ?,
                    approved_by = ?,
                    approved_date = ?
                WHERE sr_id = ?
            ");
            $stmt2->bind_param("iisssi", $sorting_status, $s_new_id, $approved_remark, $approved_by, $approved_date, $sr_id);
            $stmt2->execute();

            // Collect document number
            if (!empty($sr_docno)) {
                $docnos[] = $sr_docno;
            }

            // Get shift + date from first successful record
            if ($successCount == 0) {
                $stmt3 = $db_con->prepare("SELECT ir_shift, shift_date FROM inspection_records WHERE ir_id = ? LIMIT 1");
                $stmt3->bind_param("i", $ir_id);
                $stmt3->execute();
                $inspectiondet = $stmt3->get_result()->fetch_assoc();
                
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
            $apptask = 'SR';
            $comment_status = "reviewed the sorting report";

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
                $sorting_status,
                $combined_docnos,  // Multiple document numbers separated by commas
                $sr_current_shift,
                $sr_production_date,
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $rinsert5->execute();
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

    // remark required (optional - you can remove this)
    if ($remark == '') {
        echo json_encode(['status' => 'error', 'message' => 'Please enter comment / reason']);
        exit;
    }

    $returned_remark = $remark;
    $returned_by     = $session_id;
    $returned_date   = $pst_datenow;
    $sorting_status  = $s_return_id;

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;
        $failedList = [];
        $docnos = []; // Collect all document numbers
        $sr_current_shift = $current_shift;
        $sr_production_date = $shift_date;

        foreach ($ids as $id) {

            $sr_id = intval($id);
            if ($sr_id <= 0) continue;

            // 1) Get SR details + ir_id
            $stmtGet = $db_con->prepare("
                SELECT sr_ir_id, sr_status, sr_docno
                FROM inspection_sorting
                WHERE sr_id = ?
                LIMIT 1
            ");
            $stmtGet->bind_param("i", $sr_id);
            $stmtGet->execute();
            $sr = $stmtGet->get_result()->fetch_assoc();

            if (!$sr) {
                $failCount++;
                $failedList[] = "SR:$sr_id not found";
                continue;
            }

            $ir_id     = intval($sr['sr_ir_id']);
            $sr_status = intval($sr['sr_status']);
            $sr_docno  = $sr['sr_docno'];

            if ($ir_id <= 0) {
                $failCount++;
                $failedList[] = "SR:$sr_id missing sr_ir_id";
                continue;
            }

            // 2) Validate SR status (usually only allow return when Pending Review = 9)
            if ($sr_status != 9) {
                $failCount++;
                $failedList[] = "SR:$sr_id invalid status ($sr_status)";
                continue;
            }

            // 3) Update inspection_records sorting status -> RETURN
            $stmt = $db_con->prepare("
                UPDATE inspection_records 
                SET ir_sorting_status = ?
                WHERE ir_id = ?
            ");
            $stmt->bind_param("ii", $sorting_status, $ir_id);
            $stmt->execute();

            // 4) Update inspection_sorting -> RETURN + remark/by/date
            $stmt2 = $db_con->prepare("
                UPDATE inspection_sorting
                SET sr_status = ?,
                    returned_remark = ?,
                    returned_by = ?,
                    returned_date = ?
                WHERE sr_id = ?
            ");
            $stmt2->bind_param("isssi", $sorting_status, $returned_remark, $returned_by, $returned_date, $sr_id);
            $stmt2->execute();

            // Collect document number
            if (!empty($sr_docno)) {
                $docnos[] = $sr_docno;
            }

            // Get shift + date from first successful record
            if ($successCount == 0) {
                $stmt3 = $db_con->prepare("
                    SELECT ir_shift, shift_date
                    FROM inspection_records
                    WHERE ir_id = ?
                    LIMIT 1
                ");
                $stmt3->bind_param("i", $ir_id);
                $stmt3->execute();
                $inspectiondet = $stmt3->get_result()->fetch_assoc();

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
            $apptask = 'SR';
            $comment_status = "returned the sorting report";

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
                $sorting_status,
                $combined_docnos,  // Multiple document numbers separated by commas
                $sr_current_shift,
                $sr_production_date,
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $rinsert5->execute();
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

//Bulk Close
if ($_POST['action'] == 'bulk_close') {

    $ids    = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No records selected']);
        exit;
    }

    if ($remark == '') {
        echo json_encode(['status' => 'error', 'message' => 'Please enter comment / reason']);
        exit;
    }

    $closed_by   = $session_id;
    $closed_date = $pst_datenow;
    $closed_status = 5; // Closed

    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;
        $failedList = [];
        $docnos = []; 
        $sr_current_shift = $current_shift;
        $sr_production_date = $shift_date;

        foreach ($ids as $id) {

            $sr_id = intval($id);
            if ($sr_id <= 0) continue;

            $stmtGet = $db_con->prepare("
                SELECT sr_ir_id, sr_status, sr_docno
                FROM inspection_sorting
                WHERE sr_id = ?
                LIMIT 1
            ");
            $stmtGet->bind_param("i", $sr_id);
            $stmtGet->execute();
            $sr = $stmtGet->get_result()->fetch_assoc();

            if (!$sr) {
                $failCount++;
                $failedList[] = "SR:$sr_id not found";
                continue;
            }

            $ir_id     = intval($sr['sr_ir_id']);
            $sr_docno  = $sr['sr_docno'];

            // 1. Update sorting report
            $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET 
                                        sr_status = ?, 
                                        sr_s2w_status = ?, 
                                        sr_s2w_rp_status = ?, 
                                        sr_s2w_ack_status = ?, 
                                        closed_by = ?, 
                                        closed_date = ?, 
                                        closed_remark = ? 
                                        WHERE sr_id = ?");
            $stmt2->bind_param("iiiisssi", $closed_status, $closed_status, $closed_status, $closed_status, $closed_by, $closed_date, $remark, $sr_id);
            $stmt2->execute();

            // 2. Sync inspection records
            $stmt = $db_con->prepare("UPDATE inspection_records SET 
                                        ir_status = ?, 
                                        ir_sorting_status = ?, 
                                        ir_s2w_status = ?, 
                                        ir_s2w_rp_status = ?, 
                                        ir_s2w_ack_status = ?
                                        WHERE ir_id = ?");
            $stmt->bind_param("iiiiii", $closed_status, $closed_status, $closed_status, $closed_status, $closed_status, $ir_id);
            $stmt->execute();

            // Collect document number
            if (!empty($sr_docno)) {
                $docnos[] = $sr_docno;
            }

            // Get shift + date from first successful record
            if ($successCount == 0) {
                $stmt3 = $db_con->prepare("SELECT ir_shift, shift_date FROM inspection_records WHERE ir_id = ? LIMIT 1");
                $stmt3->bind_param("i", $ir_id);
                $stmt3->execute();
                $inspectiondet = $stmt3->get_result()->fetch_assoc();

                $sr_current_shift   = $inspectiondet['ir_shift'] ?? $current_shift;
                $sr_production_date = $inspectiondet['shift_date'] ?? $shift_date;
            }

            $successCount++;
        }

        // Insert SINGLE activity comment with ALL document numbers
        if ($successCount > 0 && count($docnos) > 0) {
            
            $combined_docnos = implode(', ', $docnos);
            
            $appsection = 'PDI';
            $apptask = 'SR';
            $comment_status = "closed the inspection (bulk)";

            $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? AND section = ? AND task = ?";
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
                $closed_status,
                $combined_docnos,  
                $sr_current_shift,
                $sr_production_date,
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $rinsert5->execute();
        }

        $db_con->commit();

        echo json_encode([
            'status' => 'success',
            'message' => "Bulk close completed. Success: $successCount, Failed: $failCount",
            'failed_list' => $failedList
        ]);
        exit;

    } catch (Exception $e) {
        $db_con->rollback();
        echo json_encode([
            'status' => 'error',
            'message' => 'Bulk close failed: ' . $e->getMessage()
        ]);
        exit;
    }
}

exit;

?>