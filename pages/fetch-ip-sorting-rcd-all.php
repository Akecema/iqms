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
include 'encrypt.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$pst_datenow = date('Y-m-d H:i:s');	

// All records
if($_POST['action'] == 'fetch_records_list_all')
{
    $columns = array('S.sr_docno', 'M.matno', 'P.modcode', 'I.inspect_date', 'H.shiftdesc', 'I.sr_status');

    $query = "SELECT I.ir_id, I.ir_type, I.ir_model, I.ir_material,
                     I.inspect_date, I.shift_date, I.ir_shift, 
                     S.sr_id, S.sr_ir_id,S.sr_docno, S.sr_status, S.created_date,
                     T.modcode, P.typemodel, M.partside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc, H.shiftbadge,
                     U.statusname
              FROM inspection_sorting S
              LEFT JOIN inspection_records I ON S.sr_ir_id = I.ir_id
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              LEFT JOIN system_status AS U ON S.sr_status = U.statusid
              WHERE I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date' ";
    
    if ($session_role == 4) {
        // Restrict to only their own records
        $query .= " AND S.created_by = '$session_id' ";
    }

    if (!empty($_POST['fd_model'])) {
        $model = intval($_POST['fd_model']);
        $query .= " AND I.ir_model = '$model' ";
    }

    if (!empty($_POST['fd_type'])) {
        $type = intval($_POST['fd_type']);
        $query .= " AND I.ir_type = '$type' ";
    }

    if (!empty($_POST['fd_material'])) {
        $material = intval($_POST['fd_material']);
        $query .= " AND I.ir_material = '$material' ";
    }

    if (!empty($_POST['fd_shift'])) {
        $shift = mysqli_real_escape_string($db_con, $_POST['fd_shift']);
        $query .= " AND I.ir_shift = '$shift' ";
    }

    if (!empty($_POST['fd_status'])) {
        $status = intval($_POST['fd_status']);
        $query .= " AND S.sr_status = '$status' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);

         $query .= " AND (
                        S.sr_docno LIKE '%$search%' 
                        OR U.statusname LIKE '%$search%'
                        OR T.modcode LIKE '%$search%'
                        OR P.typemodel LIKE '%$search%'
                        OR M.partside LIKE '%$search%'
                        OR M.matno LIKE '%$search%'
                        OR M.matdesc LIKE '%$search%'
                    ) ";
        
    }

    // Ordering
    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order'][0]['column'];
        $colDir   = $_POST['order'][0]['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= " ORDER BY S.sr_id ASC"; // default sort by pallet sequence
    }

    // Pagination
    $query1 = '';
    if($_POST["length"] != -1) {
        $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($db_con, $query));
    $result = mysqli_query($db_con, $query . $query1);

    $records = [];
    $ids = [];
    while($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
        $ids[] = $row['sr_id'];
    }

    $data = [];

    foreach ($records as $row) {

        $srid = $row['sr_id'];
        $srStatus = $row['sr_status'];

        // Status badge
        $statusBadge = '';

        $queryBadge = "SELECT 
                            r.*,
                            s.statusname,
                            s.badge,
                            s.badge_color,
                            s.text_color,
                            s.icon_class
                        FROM inspection_sorting r
                        LEFT JOIN system_status s 
                        ON s.statusid = r.sr_status
                        WHERE r.sr_id = '$srid' ";        

        $resultBadge = mysqli_query($db_con, $queryBadge);
        $rowABadge = mysqli_fetch_assoc($resultBadge);

        if (!empty($rowABadge['statusname']) && ($row['sr_status'] != 1)) {

            $badgeClass = trim($rowABadge['badge'] . '-' . $rowABadge['badge_color']);
            $textColor = $rowABadge['text_color'];
            $iconClass  = $rowABadge['icon_class'];

            $statusBadge = '
                <span class="badge badge-rounded ' . $badgeClass . ' badge-sm ' . 'style="color: ' . $textColor . '">
                    ' . ($iconClass ? '<i class="la ' . $iconClass . ' me-1"></i>' : '') . '
                    ' . htmlspecialchars($rowABadge['statusname']) . '
                </span>
            ';
        }

        //encrypt url
        $enc_srid = urlencode(encryptData($row['sr_id']));
        $enc_irid = urlencode(encryptData($row['ir_id']));
        $enc_status = urlencode(encryptData($row['sr_status']));
        
        // Action buttons
        $btnAction = '';

        if (in_array($row['sr_status'], [12, 13])) {
            // EDIT button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                            data-bs-toggle="tooltip" title="Edit Sorting" data-irid="'.$row['ir_id'].'" 
                            data-srid="'.$enc_srid.'" data-status="'.$row["sr_status"].'" data-encstatus="'.$enc_status.'" 
                            data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-edit"></i>
                        </button>';

        }
        elseif (in_array($row['sr_status'], [8,9,11])) {
            // VIEW button           
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1" 
                            data-bs-toggle="tooltip" title="View Sorting" data-irid="'.$row["ir_id"].'"
                            data-srid="'.$enc_srid.'" data-status="'.$row["sr_status"].'" data-encstatus="'.$enc_status.'"><i class="fa fa-bars"></i></i>
                        </button>';
        }
        elseif (in_array($row['sr_status'], [10])) {
            // CANCEL button           
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                            data-bs-toggle="tooltip" title="Cancel Sorting" data-irid="'.$row['ir_id'].'" 
                            data-srid="'.$enc_srid.'" data-status="'.$row["sr_status"].'" data-encstatus="'.$enc_status.'" 
                            data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-times"></i>
                        </button>';
        }

        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));

        $sorting_status = intval($row['sr_status']);       
        $disableCheck = (in_array($sorting_status, [1,5,8,11])) ? 'disabled' : '';

        $sub_array = [];
     
        $sub_array[] = '<input type="checkbox"
                            class="row-check form-check-input"
                            value="'.$row["sr_ir_id"].'"
                            data-status="'.$sorting_status.'"
                            '.$disableCheck.'>';        
        $sub_array[] = '<div class="clearfix ms-2">
                            <span class="fs-14" data-docno="'.$row["sr_docno"].'" data-bs-toggle="tooltip" title="">
                                '.$row["sr_docno"].'
                            </span>
                        </div>';
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2 viewMaterial" 
                            data-material="'.$row['ir_material'].'" data-model="'.$row['ir_model'].'"  
                            data-bs-toggle="tooltip" title="Click to view material images"">
                            <h6 class="mb-0 fw-semibold">'.$row["matno"].'</h6>
                            <span class="fs-14">'.$row["matdesc"].'</span>
                        </a>';
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row["modcode"].'</h6>
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["partside"].')'.'</span>
                        </div>'; 
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$isnpectiondate.'</span></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span></div>';
        $sub_array[] = '<div class="d-flex align-items-center gap-2">' .$statusBadge. '</div>';
        $sub_array[] = $btnAction;

        $data[] = $sub_array;
    }

    $output = array(
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $number_filter_row,
        "recordsFiltered" => $number_filter_row,
        "data"            => $data
    );

    echo json_encode($output);
}

// ==========================================================
// GET SORTING DETAILS
// ==========================================================
if ($_POST['action'] == 'get_sorting_details') {

    $sr_id = intval($_POST['sr_id']);
    $ir_id = intval($_POST['ir_id']);

    // 1. Get the latest sorting record (if exists)
    $stmt = $db_con->prepare("SELECT 
                                s.sr_id,
                                s.sr_docno,
                                s.sr_qty_ok,
                                s.sr_qty_ng,
                                s.sr_sorting_method,
                                s.sr_rework_method,
                                s.sr_remarks,
                                s.sr_status,
                                t.statusname
                                FROM inspection_sorting s   
                                LEFT JOIN system_status t ON s.sr_status = t.statusid 
                                WHERE s.sr_id = ? 
                                ORDER BY s.sr_id DESC LIMIT 1");
    $stmt->bind_param("i", $sr_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $sorting = $result->fetch_assoc(); // may be null
    $sorting_id = $sorting['sr_id'];

    // 3. Prepare default response
    $response = [
        "status" => "success",
        "data" => [
            "sr_id" => $sr_id ?? null,
            "ir_id" => $ir_id ?? null,
            "qty_ok" => $sorting['sr_qty_ok'] ?? null,
            "qty_ng" => $sorting['sr_qty_ng'] ?? null,
            "sorting_method" => $sorting['sr_sorting_method'] ?? null,
            "rework_method" => $sorting['sr_rework_method'] ?? null,
            "remarks" => $sorting['sr_remarks'] ?? null,
            "sorting_status" => $sorting['sr_status'] ?? null,
            "sr_docno" => $sorting['sr_docno'] ?? null, 
            "sr_statusname" => $sorting['statusname'] ?? null,
            "photos_before" => [],
            "photos_after" => []
        ]
    ];

    // 4. If sorting record exists, load photos
    if (!empty($sorting)) {
        $photos_before = [];
        $q1 = $db_con->prepare("SELECT before_photoid, before_photo 
                                FROM inspection_sorting_before_photo 
                                WHERE sr_ir_id = ? and sr_sorting_id = ?");
        $q1->bind_param("ii", $ir_id, $sorting_id);
        $q1->execute();
        $r1 = $q1->get_result();
        while ($p = $r1->fetch_assoc()) {
            $photos_before[] = [
                "id" => $p['before_photoid'],
                "file" => $p['before_photo']
            ];
        }

        $photos_after = [];
        $q2 = $db_con->prepare("SELECT after_photoid, after_photo 
                                FROM inspection_sorting_after_photo 
                                WHERE sr_ir_id = ? and sr_sorting_id = ?");
        $q2->bind_param("ii", $ir_id, $sorting_id);
        $q2->execute();
        $r2 = $q2->get_result();
        while ($p = $r2->fetch_assoc()) {
            $photos_after[] = [
                "id" => $p['after_photoid'],
                "file" => $p['after_photo']
            ];
        }

        $response['data']['photos_before'] = $photos_before;
        $response['data']['photos_after'] = $photos_after;
    }

    echo json_encode($response);
}

// ==========================================================
// CANCEL SORTING RECORD
// ========================== ================================
if ($_POST['action'] == 'cancel_record') {

    $ir_id  = intval($_POST['ir_id'] ?? 0);
    $sr_id  = intval($_POST['sr_id'] ?? 0);
    $remark = trim($_POST['remark'] ?? '');
    $transid = 4; 

    //generate doc no
    //comp,code,date,running no
    $sr_docnocanc = $session_comp . $sr_cancelcode . $doc_date . $sr_cancelcode_max;

    // 1. Set current record to Cancelled (status = 8)
    $stmt = $db_con->prepare("UPDATE inspection_sorting SET sr_docnocancel = ?, sr_status = ? ,cancel_remark = ?, cancelled_by = ?, cancelled_date = NOW() WHERE sr_id = ?");
    $stmt->bind_param('sissi', $sr_docnocanc, $s_cancelled_id, $remark, $session_id, $sr_id);
    $stmt->execute();

    // 21. Update sorting status to New (status = 1) in table inspection
    $stmt2 = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? WHERE ir_id = ?");
    $stmt2->bind_param('ii', $s_new_id, $ir_id);
    $stmt2->execute();

    // 3. Increment maximum_no by 1 f
    // $stmt3 = $db_con->prepare("UPDATE transaction_type SET maximum_no = maximum_no + 1 WHERE transid = ?");
    // $stmt3->bind_param('i', $transid);
    // $stmt3->execute();

    // 4. activity comment
    $appsection = 'PDI';
    $apptask = 'SR';
    $comment_status = "cancel sorting report submission";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_cancelled_id, $sr_docnocanc, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    echo json_encode(['success' => true]);
    exit;
}

// ==========================================================
// UPDATE SORTING RECORD
// ==========================================================
if ($_POST['action'] == 'update_sorting') {

    $sr_id          = intval($_POST['sr_id']);
    $ir_id          = intval($_POST['ir_id']);
    $qty_ok         = intval($_POST['qty_ok']);
    $qty_ng         = intval($_POST['qty_ng']);
    $sorting_method = trim($_POST['sorting_method']);
    $rework_method  = trim($_POST['rework_method']);
    $remarks        = trim($_POST['remarks']);

    // --- Update main sorting info ---
    $stmt = $db_con->prepare("UPDATE inspection_sorting 
                              SET sr_qty_ok = ?, sr_qty_ng = ?, sr_sorting_method = ?, sr_rework_method = ?, sr_remarks = ?, updated_by = ?, updated_date = NOW() 
                              WHERE sr_id = ? AND sr_ir_id = ?");
    $stmt->bind_param("iissssii", $qty_ok, $qty_ng, $sorting_method, $rework_method, $remarks, $session_id, $sr_id, $ir_id);

    // Execute main update
    if (!$stmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Update failed: " . $stmt->error]);
        exit;
    }

    // --- BEFORE photos (NG) ---
    if (!empty($_FILES['before_photo']['name'][0])) {
        foreach ($_FILES['before_photo']['tmp_name'] as $idx => $tmp) {
            $original_name = basename($_FILES['before_photo']['name'][$idx]);
            $filename = uniqid() . '_' . $original_name;
            $targetPath = "gallery/inspection_sorting/before/" .$sr_id. "/" . $filename;

            // Check if same filename already exists for this ir_id
            $check = $db_con->prepare("SELECT COUNT(*) FROM inspection_sorting_before_photo WHERE sr_ir_id = ? AND before_photo = ?");
            $check->bind_param("is", $ir_id, $filename);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();

            if ($count == 0) {
                // Move and insert only if not duplicate
                move_uploaded_file($tmp, $targetPath);
                $stmt2 = $db_con->prepare("INSERT INTO inspection_sorting_before_photo (sr_ir_id, sr_sorting_id, before_photo, updated_by, updated_date) VALUES (?, ?, ?, ?, NOW())");
                $stmt2->bind_param("iiss", $ir_id, $sr_id, $filename, $session_id);
                $stmt2->execute();
            }
        }
    }

    // --- AFTER photos (OK) ---
    if (!empty($_FILES['after_photo']['name'][0])) {
        foreach ($_FILES['after_photo']['tmp_name'] as $idx => $tmp) {
            $original_name = basename($_FILES['after_photo']['name'][$idx]);
            $filename = uniqid() . '_' . $original_name;
            $targetPath = "gallery/inspection_sorting/before/" .$sr_id. "/" . $filename;

            // Check if same filename already exists for this ir_id
            $check = $db_con->prepare("SELECT COUNT(*) FROM inspection_sorting_after_photo WHERE sr_ir_id = ? AND after_photo = ?");
            $check->bind_param("is", $ir_id, $filename);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();

            if ($count == 0) {
                move_uploaded_file($tmp, $targetPath);
                $stmt3 = $db_con->prepare("INSERT INTO inspection_sorting_after_photo (sr_ir_id, sr_sorting_id, after_photo, updated_by, updated_date) VALUES (?, ?, ?, ?, NOW())");
                $stmt3->bind_param("iiss", $ir_id, $sr_id, $filename, $session_id);
                $stmt3->execute();
            }
        }
    }

    echo json_encode(["status" => "success", "message" => "Sorting record updated successfully."]);
    exit;
}

// ==========================================================
// SUBMIT SORTING RECORD FOR RVIEW
// ========================== ================================
if($_POST['action'] == 'submit_for_review')
{
    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $sr_status = $_POST['sr_status'];  
    $qty_ok         = intval($_POST['qty_ok']);
    $qty_ng         = intval($_POST['qty_ng']);
    $sorting_method = trim($_POST['sorting_method']);
    $rework_method  = trim($_POST['rework_method']);
    $remarks        = trim($_POST['remarks']);
    $transid = 3; 

    //if draft create new docno, no need for returned
    if($sr_status  ==  $s_draft_id)
    {
        $transmodule = "SR";   // Or from your code
        $transprocess = "New";                // Or "Cancel", etc.
        $current_shift = $current_shift;      // E.g. 'D', 'N' from your shift logic
        $shift_date = $shift_date;  // E.g. '2024-08-06'

        $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

        //generate doc no
        //comp,code,date,running no
        $ir_docno = $session_comp . $ir_code . $doc_date . $running_no;

        // 1. Increment maximum_no by 1
        // $stmt = $db_con->prepare("UPDATE transaction_type SET maximum_no = maximum_no + 1 WHERE transid = ?");
        // $stmt->bind_param('i', $transid);
        // $stmt->execute();

        // 2. Update inspection_sorting
        $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_docno = ?, sr_qty_ok = ?, sr_qty_ng = ?, sr_sorting_method = ?, sr_rework_method = ?, 
                                    sr_remarks = ?, sr_status = ?, submitted_by = ?, submitted_date = NOW() WHERE sr_id = ?");
        $stmt2->bind_param('siisssisi', $ir_docno, $qty_ok, $qty_ng, $sorting_method, $rework_method, $remarks, $s_pendApproval_id, $session_id, $sr_id);
        $stmt2->execute();
        
    }
    else { //for return SR and resubmit
        
        // 2. Update inspection_sorting
        $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_qty_ok = ?, sr_qty_ng = ?, sr_sorting_method = ?, sr_rework_method = ?, 
                                    sr_remarks = ?, sr_status = ?, submitted_by = ?, submitted_date = NOW() WHERE sr_id = ?");
        $stmt2->bind_param('iisssisi', $qty_ok, $qty_ng, $sorting_method, $rework_method, $remarks, $s_pendApproval_id, $session_id, $sr_id);
        $stmt2->execute();
    }

    // --- BEFORE photos (NG) ---
    if (!empty($_FILES['before_photo']['name'][0])) {
        foreach ($_FILES['before_photo']['tmp_name'] as $idx => $tmp) {
            $original_name = basename($_FILES['before_photo']['name'][$idx]);
            $filename = uniqid() . '_' . $original_name;
            $targetPath = "gallery/sorting/before/" . $filename;

            // Check if same filename already exists for this ir_id
            $check = $db_con->prepare("SELECT COUNT(*) FROM inspection_sorting_before_photo WHERE sr_ir_id = ? AND before_photo = ?");
            $check->bind_param("is", $ir_id, $filename);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();

            if ($count == 0) {
                // Move and insert only if not duplicate
                move_uploaded_file($tmp, $targetPath);
                $stmt3 = $db_con->prepare("INSERT INTO inspection_sorting_before_photo (sr_ir_id, sr_sorting_id, before_photo, updated_by, updated_date) VALUES (?, ?, ?, ?, NOW())");
                $stmt3->bind_param("iiss", $ir_id, $sr_id, $filename, $session_id);
                $stmt3->execute();
            }
        }
    }

    // --- AFTER photos (OK) ---
    if (!empty($_FILES['after_photo']['name'][0])) {
        foreach ($_FILES['after_photo']['tmp_name'] as $idx => $tmp) {
            $original_name = basename($_FILES['after_photo']['name'][$idx]);
            $filename = uniqid() . '_' . $original_name;
            $targetPath = "gallery/sorting/after/" . $filename;

            // Check if same filename already exists for this ir_id
            $check = $db_con->prepare("SELECT COUNT(*) FROM inspection_sorting_after_photo WHERE sr_ir_id = ? AND after_photo = ?");
            $check->bind_param("is", $ir_id, $filename);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();

            if ($count == 0) {
                move_uploaded_file($tmp, $targetPath);
                $stmt4 = $db_con->prepare("INSERT INTO inspection_sorting_after_photo (sr_ir_id, sr_sorting_id, after_photo, updated_by, updated_date) VALUES (?, ?, ?, ?, NOW())");
                $stmt4->bind_param("iiss", $ir_id, $sr_id, $filename, $session_id);
                $stmt4->execute();
            }
        }
    }

    // 1.4 update sorting status n table inspection records
    $stmt5 = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? WHERE ir_id = ?");
    $stmt5->bind_param('ii', $s_pendApproval_id, $ir_id);
    $stmt5->execute();

    // --- Send Email Notification ---
    $recipients = [];

     //3. Select users with a specific role
    $sql = "SELECT E.staff_name, E.staff_email
                FROM user_authorization A 
                    LEFT JOIN employee_details E ON E.staff_id = A.staff_id
                        WHERE A.SR_reviewer = 'Y'";
    $result = $db_con->query($sql);
    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row;
    }

    //3. Select users with a specific role
    // $uSection = 'PDI';
    // $uTask =  = 'SR_reviewer';
    // $auto_status = 'AC';

    // // $sql = "
    // //         SELECT DISTINCT 
    // //             E.staff_name,
    // //             E.staff_email
    // //         FROM user_authorization A
    // //         INNER JOIN employee_details E 
    // //             ON E.staff_id = A.staff_id
    // //         WHERE A.section = ?
    // //         AND A.task = ?
    // //         AND A.auto_status = 'AC'
    // //     ";

    // // $stmt = $db_con->prepare($sql);
    // // $stmt->bind_param("ss", $uSection, $nextTask);
    // // $stmt->execute();
    // // $result = $stmt->get_result();

    // // $recipients = [];
    // // while ($row = $result->fetch_assoc()) {
    // //     if (!empty($row['staff_email'])) {
    // //         $recipients[] = $row;
    // //     }
    // // }

    // 4. Fetch inspection details
    $stmt4 = $db_con->prepare("SELECT S.sr_id, S.sr_docno, R.ir_id, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_sorting S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.sr_ir_id
                                            LEFT JOIN material_header M ON R.ir_material = M.matid
                                                WHERE S.sr_id = ?");
    $stmt4->bind_param('i', $sr_id);
    $stmt4->execute();
    $inspectiondet = $stmt4->get_result()->fetch_assoc();

    //5. activity comment
    $appsection = 'PDI';
    $apptask = 'SR';
    $comment_status = "submit the sorting report";
    
    //submitter = user login
    $submitter_name  = $stf_name;
    $doc_no = $inspectiondet['sr_docno'];
    $inspectdate = date('d-m-Y', strtotime($inspectiondet['inspect_date']));
    $shiftdet = $inspectiondet['ir_shift'] == 'D' ? 'Day' : 'Night';

    // activities
    $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? and section = ? and task = ?";
    $stmtr_quamax = $db_con->prepare($query_quamax); 
    $stmtr_quamax->bind_param("sss", $session_id, $appsection, $apptask);
    $stmtr_quamax->execute();

    $rst_quamax = $stmtr_quamax->get_result();                                                                
    $row_quamax = $rst_quamax->fetch_array();

    $next_priority = ($row_quamax[0] + 1);

    $rinsert5 = "INSERT INTO activity_comment(section, task, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date) 
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $rinsert5 = $db_con->prepare($rinsert5);
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_pendApproval_id, $doc_no, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

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
        $mail->Subject =  $esubject_5;

        $mail->Body = "<h4>Dear {$authouser['staff_name']},</h4>";
        $mail->Body .= "<p>A new sorting report (<strong>Doc No: $doc_no </strong>) has been submitted by $submitter_name and requires your review. </p>";
        $mail->Body .= "<p>Please log in to the system and review the submission at your earliest convenience.<br>";
        $mail->Body .= "<a href={$system_url}> {$system_url}</a></p>";

        $mail->Body .= "
                        <h4 style='color:#cc0000;'>Inspection Record Details</h4>
                        <table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;font-size:14px;'>
                            <tr>
                                <th align='left'>Part No</th>
                                <td>{$inspectiondet['matno']}</td>
                            </tr>
                            <tr>
                                <th align='left'>Inspection Date</th>
                                <td>{$inspectdate}</td>
                            </tr>
                            <tr>
                                <th align='left'>Shift</th>
                                <td>{$shiftdet}</td>
                            </tr>
                            <tr>
                                <th align='left'>Requestor</th>
                                <td>{$submitter_name}</td>
                            </tr>
                        </table>
                    ";

        $mail->Body .= "<p>** This is a system generated email. Please DO NOT REPLY. **</p>";
        
        if ($mail->send()) {
            $success_count++;  
        } else {
            $fail_count++;
            $fail_emails[] = $authouser['staff_email'] . " (" . $mail->ErrorInfo . ")";
        }

    }

    $response = [
        'success' => true,
        'msg' => 'Sorting report submitted for review.',
        'ir_id' => $ir_id,
        'emails_sent' => $success_count,
        'emails_failed' => $fail_count,
        'failed_list' => $fail_emails
    ];

    echo json_encode($response);
    exit; // <--- always exit after sending AJAX response
}

?>