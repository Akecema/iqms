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

$ir_status = $s_completed_id;

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
if($_POST['action'] == 'bulk_submit') {

    $ids = $_POST['ids'] ?? [];

    if (empty($ids)) {
        echo json_encode(['status' => 'error', 'message' => 'No records selected']);
        exit;
    }

    $ids = array_map('intval', $ids);

    // ----------------------------
    // 1) Get reviewer emails ONCE
    // ----------------------------
    $recipients = [];
    $sql = "SELECT E.staff_name, E.staff_email
            FROM user_authorization A
            LEFT JOIN employee_details E ON E.staff_id = A.staff_id
            WHERE A.PDI_reviewer = 'Y' AND E.staff_email <> ''";
    $result = $db_con->query($sql);

    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row;
    }

    // ----------------------------
    // 2) Prepare update statement
    // ----------------------------
    $updateStmt = $db_con->prepare("
        UPDATE inspection_records
        SET ir_docno = ?,
            ir_status = ?,
            prod_date = ?,
            submitted_by = ?,
            submitted_date = NOW()
        WHERE ir_id = ?
    ");

    // ----------------------------
    // 3) Prepare activity insert
    // ----------------------------
    $activityStmt = $db_con->prepare("
        INSERT INTO activity_comment(
            section, task, form_status, docno,
            prod_shift, shift_date, status_comment,
            comment_priority, staff_id, commentator, comment_date
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    // ----------------------------
    // 4) Loop submit each record
    // ----------------------------
    $success = 0;
    $fail = 0;
    $submittedDocs = [];

    foreach ($ids as $ir_id) {

        // Fetch prod_date (or use today)
        $stmtProd = $db_con->prepare("SELECT prod_date FROM inspection_records WHERE ir_id = ?");
        $stmtProd->bind_param("i", $ir_id);
        $stmtProd->execute();
        $rowProd = $stmtProd->get_result()->fetch_assoc();

        $ir_prod_date = ($rowProd['prod_date'] != '0000-00-00')
            ? date('Y-m-d', strtotime($rowProd['prod_date']))
            : $shift_date;

        // Generate running no for EACH ROW
        $transmodule   = "IR";
        $transprocess  = "New";

        $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

        // Generate docno for EACH ROW
        // Make sure $ir_code and $doc_date exist in your system
        $ir_docno = $session_comp . $ir_code . $doc_date . $running_no;

        // Update record
        $updateStmt->bind_param("sissi", $ir_docno, $s_pendReview_id, $ir_prod_date, $session_id, $ir_id);

        if ($updateStmt->execute()) {

            // Fetch inspection details
            $stmt3 = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.inspect_date, R.ir_shift, M.matno
                                            FROM inspection_records R 
                                                LEFT JOIN material_header M ON R.ir_material = M.matid
                                                    WHERE ir_id = ?");
            $stmt3->bind_param('i', $ir_id);
            $stmt3->execute();
            $inspectiondet = $stmt3->get_result()->fetch_assoc();
            
            $inspectdate = date('d-m-Y', strtotime($inspectiondet['inspect_date']));                  
            $shiftdet = $inspectiondet['ir_shift'] == 'D' ? 'Day' : 'Night';

            // Insert activity comment (priority per record)
            $appsection = 'PDI';
            $apptask = 'IR';
            $comment_status = "submit the inspection";

            // Get next priority
            $q = $db_con->prepare("SELECT COALESCE(MAX(comment_priority),0) AS maxp FROM activity_comment WHERE staff_id = ? AND section = ?");
            $q->bind_param("ss", $session_id, $appsection);
            $q->execute();
            $maxp = $q->get_result()->fetch_assoc();
            $next_priority = intval($maxp['maxp']) + 1;

            $activityStmt->bind_param(
                "sssssssssss",
                $appsection,
                $apptask,
                $s_pendReview_id,
                $ir_docno,
                $current_shift,
                $shift_date,
                $comment_status,
                $next_priority,
                $session_id,
                $session_id,
                $pst_datenow
            );
            $activityStmt->execute();

            $success++;
            $submittedDocs[] = $ir_docno;

        } else {
            $fail++;
        }
    }

    // ----------------------------
    // 5) Send email ONCE (recommended)
    // ----------------------------
    // if (!empty($recipients) && $success > 0) {

    //     $mail = new PHPMailer();
    //     $mail->isSMTP();
    //     $mail->Host = $host;
    //     $mail->SMTPAuth = true;
    //     $mail->Username = $email_username;
    //     $mail->Password = $email_password;
    //     $mail->Port = $port;

    //     $mail->setFrom($email_username, $system_name);
    //     $mail->isHTML(true);
    //     $mail->Subject = $esubject_4;

    //     $submitter_name = $stf_name;

    //     $listHtml = "<ul>";
    //     foreach ($submittedDocs as $docno) {
    //         $listHtml .= "<li><b>$docno</b></li>";
    //     }
    //     $listHtml .= "</ul>";

    //     foreach ($recipients as $authouser) {
    //         $mail->clearAddresses();
    //         $mail->addAddress($authouser['staff_email'], $authouser['staff_name']);

    //         $mail->Body = "<h4>Dear {$authouser['staff_name']},</h4>";
    //         $mail->Body .= "<p>The following inspection record(s) have been submitted by <b>$submitter_name</b> and require your review:</p>";
    //         $mail->Body .= $listHtml;

            
    //         $mail->Body .= "
    //                     <h4 style='color:#cc0000;'>Inspection Record Details</h4>
    //                     <table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;font-size:14px;'>
    //                         <tr>
    //                             <th align='left'>Part No</th>
    //                             <td>{$inspectiondet['matno']}</td>
    //                         </tr>
    //                         <tr>
    //                             <th align='left'>Inspection Date</th>
    //                             <td>{$inspectdate}</td>
    //                         </tr>
    //                         <tr>
    //                             <th align='left'>Shift</th>
    //                             <td>{$shiftdet}</td>
    //                         </tr>
    //                         <tr>
    //                             <th align='left'>Document No</th>
    //                             <td>{$listHtml}</td>
    //                         </tr>
    //                     </table>
    //                 ";

    //         $mail->Body .= "<p>Please log in to the system:<br><a href='{$system_url}'>{$system_url}</a></p>";
    //         $mail->Body .= "<p>** This is a system generated email. Please DO NOT REPLY. **</p>";

    //         $mail->send(); // ignore failure here if you want
    //     }
    // }

    // ----------------------------
    // 6) Response
    // ----------------------------
    echo json_encode([
        'status' => 'success',
        'message' => "$success record(s) submitted successfully. Failed: $fail"
    ]);
    exit;


}

//Reviwed
if($_POST['action'] == 'bulk_approve') {
    
    // ===============================
    // 1) Fetch all document numbers
    // ===============================
    $docnos = [];
    $docnoQuery = $db_con->prepare("SELECT ir_docno FROM inspection_records WHERE ir_id IN ($idList) ORDER BY ir_docno");
    $docnoQuery->execute();
    $docnoResult = $docnoQuery->get_result();
    
    while($docRow = $docnoResult->fetch_assoc()) {
        if(!empty($docRow['ir_docno'])) {
            $docnos[] = $docRow['ir_docno'];
        }
    }
    
    // Combine document numbers with commas
    $combined_docnos = implode(', ', $docnos);
    
    // ===============================
    // 2) Update inspection records
    // ===============================
    $stmt = $db_con->prepare("
                UPDATE inspection_records
                SET 
                    ir_status = CASE
                        WHEN ir_result = 'OK' THEN $s_completed_id
                        WHEN ir_result = 'NG' THEN $s_reviewed_id
                        ELSE ir_status
                    END,
                    ir_sorting_status = ?,
                    reviewed_remark = ?,
                    reviewed_by = ?,
                    reviewed_date = NOW()
                WHERE ir_id IN ($idList)
            ");

    $stmt->bind_param("iss", $s_new_id, $remark, $session_id);

    // ===============================
    // 3) Activity comment (single row with multiple docnos)
    // ===============================
    $appsection = 'PDI';
    $apptask = 'IR';
    $comment_status = "reviewed the inspection submission";

    $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? AND section = ?";
    $stmtr_quamax = $db_con->prepare($query_quamax);
    $stmtr_quamax->bind_param("ss", $session_id, $appsection);
    $stmtr_quamax->execute();
    $rst_quamax = $stmtr_quamax->get_result();
    $row_quamax = $rst_quamax->fetch_array();

    $next_priority = ($row_quamax[0] + 1);

    // Insert single row with comma-separated document numbers
    $rinsert5 = $db_con->prepare("
        INSERT INTO activity_comment
            (section, task, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $rinsert5->bind_param(
        "sssssssssss",
        $appsection,
        $apptask,
        $s_reviewed_id,
        $combined_docnos,  // Multiple document numbers separated by commas
        $current_shift,
        $shift_date,
        $comment_status,
        $next_priority,
        $session_id,
        $session_id,
        $pst_datenow
    );
    $rinsert5->execute();

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => count($ids) . ' record(s) reviewed successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $stmt->error
        ]);
    }

}

//Return
if($_POST['action'] == 'bulk_return') {
    
    // ===============================
    // 1) Fetch all document numbers
    // ===============================
    $docnos = [];
    $docnoQuery = $db_con->prepare("SELECT ir_docno FROM inspection_records WHERE ir_id IN ($idList) ORDER BY ir_docno");
    $docnoQuery->execute();
    $docnoResult = $docnoQuery->get_result();
    
    while($docRow = $docnoResult->fetch_assoc()) {
        if(!empty($docRow['ir_docno'])) {
            $docnos[] = $docRow['ir_docno'];
        }
    }
    
    // Combine document numbers with commas
    $combined_docnos = implode(', ', $docnos);
    
    // ===============================
    // 2) Update inspection records
    // ===============================
    $stmt = $db_con->prepare("
                UPDATE inspection_records
                SET 
                    ir_status = ?,
                    returned_remark = ?,
                    returned_by = ?,
                    returned_date = NOW()
                WHERE ir_id IN ($idList)
            ");

    $stmt->bind_param("iss", $s_return_id, $remark, $session_id);

    // ===============================
    // 3) Activity comment (single row with multiple docnos)
    // ===============================
    $appsection = 'PDI';
    $apptask = 'IR';
    $comment_status = "returned the inspection submission";

    $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? AND section = ?";
    $stmtr_quamax = $db_con->prepare($query_quamax);
    $stmtr_quamax->bind_param("ss", $session_id, $appsection);
    $stmtr_quamax->execute();
    $rst_quamax = $stmtr_quamax->get_result();
    $row_quamax = $rst_quamax->fetch_array();

    $next_priority = ($row_quamax[0] + 1);

    // Insert single row with comma-separated document numbers
    $rinsert5 = $db_con->prepare("
        INSERT INTO activity_comment
            (section, task, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $rinsert5->bind_param(
        "sssssssssss",
        $appsection,
        $apptask,
        $s_return_id,
        $combined_docnos,  // Multiple document numbers separated by commas
        $current_shift,
        $shift_date,
        $comment_status,
        $next_priority,
        $session_id,
        $session_id,
        $pst_datenow
    );
    $rinsert5->execute();

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => count($ids) . ' record(s) returned successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $stmt->error
        ]);
    }

}

//Cancel
if ($_POST['action'] == 'bulk_cancel') {

    $ids    = $_POST['ids'] ?? [];
    $remark = trim($_POST['remark'] ?? '');
    $transid = 2;

    if (!is_array($ids) || count($ids) == 0) {
        echo json_encode(['status' => 'error', 'message' => 'No records selected.']);
        exit;
    }

    if ($remark == '') {
        echo json_encode(['status' => 'error', 'message' => 'Remark is required.']);
        exit;
    }

    // OPTIONAL: begin transaction (recommended)
    $db_con->begin_transaction();

    try {

        $successCount = 0;
        $failCount = 0;

        foreach ($ids as $id) {

            $ir_id = intval($id);
            if ($ir_id <= 0) continue;

            // ===============================
            // 1) Generate cancel doc no (each row must be unique)
            // ===============================
            // Example:
            // $ir_docnocanc = $session_comp . $ir_cancelcode . $doc_date . $ir_cancelcode_max;
            // IMPORTANT: you must UPDATE running number inside loop!
            // Below is a simple example using time + id (safe unique)
            $ir_docnocanc = $session_comp . $ir_cancelcode . date("Ymd") . str_pad($ir_id, 5, "0", STR_PAD_LEFT);

            // ===============================
            // 2) Update current record -> Cancelled (status = 8)
            // ===============================
            $stmt = $db_con->prepare("
                UPDATE inspection_records 
                SET ir_docnocancel = ?, 
                    ir_status = ?, 
                    cancel_remark = ?, 
                    cancelled_by = ?, 
                    cancelled_date = NOW() 
                WHERE ir_id = ?
            ");
            $stmt->bind_param('sissi', $ir_docnocanc, $s_cancelled_id, $remark, $session_id, $ir_id);
            $stmt->execute();

            if ($stmt->affected_rows <= 0) {
                $failCount++;
                continue;
            }

            // ===============================
            // 3) Copy record -> Insert new record status = 1
            // ===============================
            $query = "
                SELECT ir_model, ir_type, ir_material, ir_shift, shift_date, ir_pallet_no, inspect_group, inspect_date
                FROM inspection_records 
                WHERE ir_id = ?
            ";
            $stmt2 = $db_con->prepare($query);
            $stmt2->bind_param('i', $ir_id);
            $stmt2->execute();
            $result = $stmt2->get_result();

            if ($row = $result->fetch_assoc()) {

                $insert = $db_con->prepare("
                    INSERT INTO inspection_records 
                        (ir_model, ir_type, ir_material, ir_pallet_no, ir_result, ir_status, ir_shift, shift_date, inspect_group, inspect_date)
                    VALUES (?, ?, ?, ?, '', 1, ?, ?, ?, ?)
                ");

                $insert->bind_param(
                    "ssssssss",
                    $row['ir_model'],
                    $row['ir_type'],
                    $row['ir_material'],
                    $row['ir_pallet_no'],
                    $row['ir_shift'],
                    $row['shift_date'],
                    $row['inspect_group'],
                    $row['inspect_date']
                );
                $insert->execute();
                
                // Get the new inserted record ID
                $new_ir_id = $insert->insert_id;
                
                // ===============================
                // Auto create folder for photo
                // ===============================
                // defect
                $folder_new_d = __DIR__ . "/gallery/inspection/defect/" . $new_ir_id;
                if (!is_dir($folder_new_d)) mkdir($folder_new_d, 0777, true);
                
                // comparison
                $folder_new_c = __DIR__ . "/gallery/inspection/defect_compare/" . $new_ir_id;
                if (!is_dir($folder_new_c)) mkdir($folder_new_c, 0777, true);
            }

            // ===============================
            // 4) Activity comment (bulk)
            // ===============================
            $appsection = 'PDI';
            $comment_status = "cancel the inspection submission";

            $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? AND section = ?";
            $stmtr_quamax = $db_con->prepare($query_quamax);
            $stmtr_quamax->bind_param("ss", $session_id, $appsection);
            $stmtr_quamax->execute();
            $rst_quamax = $stmtr_quamax->get_result();
            $row_quamax = $rst_quamax->fetch_array();

            $next_priority = ($row_quamax[0] + 1);

            $rinsert5 = $db_con->prepare("
                INSERT INTO activity_comment
                    (section, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $rinsert5->bind_param(
                "ssssssssss",
                $appsection,
                $s_cancelled_id,
                $ir_docnocanc,
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
            'message' => "Cancel completed. Success: $successCount, Failed: $failCount"
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

exit;

?>