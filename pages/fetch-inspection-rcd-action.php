<?php

session_start();
include '../db/db_connect.php';
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

$pst_datenow = date('Y-m-d H:i:s');	

//Edit result 
if ($_POST['action'] === 'update_result') {

    $ir_id  = intval($_POST['ir_id'] ?? 0);
    $result = $_POST['result'] ?? ''; // '', 'OK', 'NG'

    if ($ir_id <= 0 || !in_array($result, ['', 'OK', 'NG'], true)) {
        echo json_encode(['success' => false, 'message' => 'Invalid parameters.']);
        exit;
    }

    // From NG->OK
    $new_id = $ir_id;
    $prev_result = '';

    // 1. If updating existing, get previous result
    if ($ir_id) {
        $stmt = $db_con->prepare("SELECT ir_result FROM inspection_records WHERE ir_id = ?");
        $stmt->bind_param('i', $ir_id);
        $stmt->execute();
        $stmt->bind_result($prev_result);
        $stmt->fetch();
        $stmt->close();
    }

    if ($prev_result === 'NG' && $result === 'OK') {
    
        // Delete defect photos
        $photos = [];
        $stmt = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = ?");
        $stmt->bind_param('i', $ir_id);
        $stmt->execute();
        $stmt->bind_result($photo_path);
        while ($stmt->fetch()) $photos[] = $photo_path;
        $stmt->close();

        foreach ($photos as $path) {
            $full_path = __DIR__ . "/gallery/inspection/defect/" . basename($path);
            if (file_exists($full_path)) unlink($full_path);
        }

        // Delete comparison photos
        $compare_photos = [];
        $stmt = $db_con->prepare("SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ?");
        $stmt->bind_param('i', $ir_id);
        $stmt->execute();
        $stmt->bind_result($compare_path);
        while ($stmt->fetch()) $compare_photos[] = $compare_path;
        $stmt->close();

        foreach ($compare_photos as $path) {
            $full_path = __DIR__ . "/gallery/inspection/defect_compare/" . basename($path);
            if (file_exists($full_path)) unlink($full_path);
        }

        // Delete defect records
        $db_con->query("DELETE FROM inspection_defect WHERE rcd_ir_id = " . intval($ir_id));
        $db_con->query("DELETE FROM inspection_defect_photo WHERE rcd_ir_id = " . intval($ir_id));
        $db_con->query("DELETE FROM inspection_compare_photo WHERE rcd_ir_id = " . intval($ir_id));

    }

    // Update result
    $stmt2 = $db_con->prepare("UPDATE inspection_records SET ir_result = ? WHERE ir_id = ?");
    $stmt2->bind_param('si', $result, $ir_id);
    $ok = $stmt2->execute();
    $stmt2->close();

    if ($ok) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'DB update failed.']);
    }
    exit;
}

// Case for status return — reset status to 1 (New)
if ($_POST['action'] == 'update_result_reset_status') {

    $ir_id = $_POST['ir_id'];
    $result = $_POST['result'];

    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_result = ?, ir_status = 1, updated_by = ?, updated_date = NOW() WHERE ir_id = ?");
    $stmt->bind_param("ssi", $result, $session_id, $ir_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update.']);
    }
    exit;
}

//Submit inspection for review
if($_POST['action'] == 'submit_for_review')
{
    $ir_id = $_POST['ir_id']; 

    if(!empty($_POST['prod_date'] || $_POST['prod_date'] != '0000-00-00')){
        $ir_prod_date = date('Y-m-d', strtotime($_POST['prod_date']));
    } else {
        $ir_prod_date = $shift_date;   // shift_date
    }

    $transid = 1; 

    $transmodule = "IR";   // Or from your code
    $transprocess = "New";                // Or "Cancel", etc.
    $current_shift = $current_shift;      // E.g. 'D', 'N' from your shift logic
    $shift_date = $shift_date;  // E.g. '2024-08-06'

    $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

    //generate doc no
    //comp,code,date,running no
    $ir_docno = $session_comp . $ir_code . $doc_date . $running_no;

    // 1. Update inspection_records
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_docno = ?, ir_status = ?, prod_date = ?, submitted_by = ?, submitted_date = NOW() WHERE ir_id = ?");
    $stmt->bind_param('sissi', $ir_docno, $s_pendReview_id, $ir_prod_date, $session_id, $ir_id);
    $stmt->execute();

    // --- Send Email Notification ---
    $recipients = [];

    $sql = "SELECT E.staff_name, E.staff_email
                FROM user_authorization A 
                    LEFT JOIN employee_details E ON E.staff_id = A.staff_id
                        WHERE A.PDI_reviewer = 'Y' ";
    $result = $db_con->query($sql);
    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row;
    }

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_records R 
                                        LEFT JOIN material_header M ON R.ir_material = M.matid
                                            WHERE ir_id = ?");
    $stmt3->bind_param('i', $ir_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    //5. activity comment
    $appsection = 'PDI';
    $apptask = 'IR';
    $comment_status = "submit the inspection";

    // activities
    $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? and section = ? ";
    $stmtr_quamax = $db_con->prepare($query_quamax); 
    $stmtr_quamax->bind_param("ss", $session_id, $appsection);
    $stmtr_quamax->execute();

    $rst_quamax = $stmtr_quamax->get_result();                                                                
    $row_quamax = $rst_quamax->fetch_array();

    $next_priority = ($row_quamax[0] + 1);

    $rinsert5 = "INSERT INTO activity_comment(section, task, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date) 
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $rinsert5 = $db_con->prepare($rinsert5);
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_pendReview_id, $ir_docno, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    //submitter = user login
    // $submitter_name  = $stf_name;
    // $doc_no = $inspectiondet['ir_docno'];
    // $inspectdate = date('d-m-Y', strtotime($inspectiondet['inspect_date']));
    // $shiftdet = $inspectiondet['ir_shift'] == 'D' ? 'Day' : 'Night';

    // $mail = new PHPMailer(); 

    // // SMTP Configuration
    // $mail->isSMTP();
    // $mail->Host = $host; // Your SMTP server
    // $mail->SMTPAuth = true;
    // $mail->Username = $email_username; // Your Mailtrap username
    // $mail->Password = $email_password; // Your Mailtrap password
    // //$mail->SMTPSecure = 'tls';
    // $mail->Port = $port;

    // // Sender and recipient settings
    // $mail->setFrom($email_username, $system_name);

    // $success_count = 0;
    // $fail_count = 0;
    // $fail_emails = [];

    // // All authorize users for review inspection record
    // foreach ($recipients as $authouser) {

    //     // Clear all recipients and attachments for each loop
    //     $mail->clearAddresses();
    //     $mail->clearAttachments();

    //     $mail->addAddress($authouser['staff_email'], $authouser['staff_name']);        
    //     $mail->isHTML(true);
    //     $mail->Subject =  $esubject_4;

    //     $mail->Body = "<h4>Dear {$authouser['staff_name']},</h4>";
    //     $mail->Body .= "<p>A new inspection record (<strong>Doc No: $doc_no </strong>) has been submitted by $submitter_name and requires your review. </p>";
    //     $mail->Body .= "<p>Please log in to the system and review the submission at your earliest convenience.<br>";
    //     $mail->Body .= "<a href={$system_url}> {$system_url}</a></p>";

    //     $mail->Body .= "
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
    //                     </table>
    //                 ";

    //     $mail->Body .= "<p>** This is a system generated email. Please DO NOT REPLY. **</p>";
        
    //     if ($mail->send()) {
    //         $success_count++;  
    //     } else {
    //         $fail_count++;
    //         $fail_emails[] = $authouser['staff_email'] . " (" . $mail->ErrorInfo . ")";
    //     }

    // }

    $response = [
        'success' => true,
        'msg' => 'Inspection record submitted for review.',
        'ir_id' => $ir_id
    ];

    echo json_encode($response);
    exit; // <--- always exit after sending AJAX response
}

//Cancel inspection record
if ($_POST['action'] == 'cancel_record') {

    $ir_id  = intval($_POST['ir_id'] ?? 0);
    $remark = trim($_POST['remark'] ?? '');
    $transid = 2; 

    //generate doc no
    //comp,code,date,running no
    $ir_docnocanc = $session_comp . $ir_cancelcode . $doc_date . $ir_cancelcode_max;

    // 1. Set current record to Cancelled (status = 8)
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_docnocancel = ?, ir_status = ? ,cancel_remark = ?, cancelled_by = ?, cancelled_date = NOW() WHERE ir_id = ?");
    $stmt->bind_param('sissi', $ir_docnocanc, $s_cancelled_id, $remark, $session_id, $ir_id);
    $stmt->execute();

    // 2. Copy the row, set status = 1 (New)
    // Get the current record (excluding primary key)
    $query = "SELECT ir_model, ir_type, ir_material, ir_shift, shift_date, ir_pallet_no, ir_result, shift_date, inspect_group, inspect_date, shift_date
                    FROM inspection_records WHERE ir_id = ?";
    $stmt2 = $db_con->prepare($query);
    $stmt2->bind_param('i', $ir_id);
    $stmt2->execute();
    $result = $stmt2->get_result();

    if ($row = $result->fetch_assoc()) {

        // Insert new record with status = 1
        $insert = $db_con->prepare("INSERT INTO inspection_records 
                                    (ir_model, ir_type, ir_material, ir_pallet_no, ir_result, ir_status, ir_shift, shift_date, inspect_group, inspect_date)
                                    VALUES (?, ?, ?, ?, '', 1, ?, ?, ?, ?)");
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

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_records R 
                                        LEFT JOIN material_header M ON R.ir_material = M.matid
                                            WHERE ir_id = ?");
    $stmt3->bind_param('i', $ir_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    //5. activity comment
    $appsection = 'PDI';
    $comment_status = "cancel the inspection submission";

    // activities
    $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? and section = ? ";
    $stmtr_quamax = $db_con->prepare($query_quamax); 
    $stmtr_quamax->bind_param("ss", $session_id, $appsection);
    $stmtr_quamax->execute();

    $rst_quamax = $stmtr_quamax->get_result();                                                                
    $row_quamax = $rst_quamax->fetch_array();

    $next_priority = ($row_quamax[0] + 1);

    $rinsert5 = "INSERT INTO activity_comment(section, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date) 
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $rinsert5 = $db_con->prepare($rinsert5);
    $rinsert5->bind_param("ssssssssss", $appsection, $s_cancelled_id, $ir_docnocanc, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    echo json_encode(['success' => true]);
    exit;
}

?>