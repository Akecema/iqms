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

// ==========================================================
// ALL APPROVE INSPECTION RECORDS TO LIST IN SORTING
// ==========================================================
if($_POST['action'] == 'fetch_records_create')
{
    $columns = array('I.ir_docno', 'I.ir_docno', 'M.matno', 'P.modcode', 'I.inspect_date', 'H.shiftdesc', 'I.ir_pallet_no', 'I.ir_status');

    $query = "SELECT S.sr_id, S.sr_docno, S.sr_s2w_status,
                     I.ir_id, I.ir_docno, I.ir_model, I.ir_type, I.ir_material, I.ir_pallet_no, I.ir_result, I.ir_status, 
                     I.inspect_date, I.shift_date, I.inspect_group, I.ir_shift, I.created_date,
                     T.modcode, P.typemodel, P.typeside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc, H.shiftbadge
              FROM inspection_sorting S  
              LEFT JOIN inspection_records AS I ON S.sr_ir_id = I.ir_id
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              LEFT JOIN system_status AS U ON S.sr_s2w_status = U.statusid
              WHERE I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date' 
              and S.sr_status = '$s_approved_id' ";
    
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

    if (!empty($_POST['fd_status'])) {
        $status = intval($_POST['fd_status']);
        $query .= " AND S.sr_status = '$status' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);
       
        // Combine: subquery filter + multi-column search
        $query .= " AND (
                    -- 1. Match sr_docno in sorting (exclude status 1 & 13)
                    S.sr_id IN (
                        SELECT s2w_sr_id, s2w_docno
                        FROM inspection_s2w
                        WHERE s2w_docno LIKE '%$search%' 
                        AND s2w_status != 1 
                        AND s2w_status != 13
                    )
                    

                    -- 2. OR match other columns (joined fields)
                    OR I.ir_docno LIKE '%$search%'
                    OR U.statusname LIKE '%$search%'
                    OR T.modcode LIKE '%$search%'
                    OR P.typemodel LIKE '%$search%'
                    OR P.typeside LIKE '%$search%'
                    OR M.matno LIKE '%$search%'
                    OR M.matdesc LIKE '%$search%'
                    OR H.shiftdesc LIKE '%$search%'
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

    $data = array();

    while($row = mysqli_fetch_array($result))
    {
        $srid = $row['sr_id'];

        // Status badge
        $statusBadge = '';
        if ($row['sr_s2w_status'] != 1) {
            if ($row['sr_s2w_status'] == 13) $statusBadge = '<span class="badge badge-rounded badge-outline-hijo badge-sm">'.$s_draft.'</span>';
            elseif ($row['sr_s2w_status'] == 4) $statusBadge = '<span class="badge badge-rounded badge-outline-purple badge-sm">'.$s_approved.'</span>';
            elseif ($row['sr_s2w_status'] == 8) $statusBadge = '<span class="badge badge-rounded badge-outline-oren badge-sm">'.$s_cancelled.'</span>';
            elseif ($row['sr_s2w_status'] == 9) $statusBadge = '<span class="badge badge-rounded badge-outline-pink badge-sm">'. $s_pendReview.'</span>';
            elseif ($row['sr_s2w_status'] == 10) $statusBadge = '<span class="badge badge-rounded badge-outline-merah badge-sm">'.$s_pendApproval.'</span>';
            elseif ($row['sr_s2w_status'] == 12) $statusBadge = '<span class="badge badge-rounded badge-outline-primary badge-sm">'.$s_return.'</span>';
        }

        //encrypt url
        $enc_srid = urlencode(encryptData($row['sr_id']));
        $enc_irid = urlencode(encryptData($row['ir_id']));
        $enc_status = urlencode(encryptData($row['sr_s2w_status']));
        
        // Action buttons
        $btnAction = ''; // default empty

        if ($row['sr_s2w_status'] == 1) {
            // ADD button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnCreate ms-1"
                            data-bs-toggle="tooltip" title="Create S2W"
                            data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-model="'.$row['ir_model'].'"
                            data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-plus"></i>
                        </button>';
        }
        elseif (in_array($row['sr_s2w_status'], [12, 13])) {
            // EDIT button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnEdit ms-1"
                            data-bs-toggle="tooltip" title="Edit S2W"
                             data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-model="'.$row['ir_model'].'"
                            data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-edit"></i>
                        </button>';
        }
        elseif (in_array($row['sr_s2w_status'], [4, 8, 9, 10])) {
            // VIEW button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnView ms-1"
                            data-bs-toggle="tooltip" title="View S2W"
                            data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-model="'.$row['ir_model'].'"
                            data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-list"></i>
                        </button>';
        }

        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));

        $display_docno = '';

        // If status in 4,7,10,12,13 → get sr_docno from inspection_sorting
        $q_sr = $db_con->prepare("SELECT s2w_docno, s2w_status FROM inspection_s2w WHERE s2w_sr_id = ?");
        $q_sr->bind_param("i", $srid);
        $q_sr->execute();
        $q_sr->bind_result($s2w_docno, $s2w_status);
        if ($q_sr->fetch()) {
            if ($s2w_status != 1 && $s2w_status != 8 && $s2w_status != 13) {
                $display_docno = $s2w_docno;
            } else {
                $display_docno = ''; // hide docno if status 1 or 13
            }
        }
        $q_sr->close();

        //icon view all doc no
        $icon_viewdoc = '';

        if($s2w_docno != "" && $s2w_status != 8) {
            $icon_viewdoc = '<small class="table-tip d-inline-flex align-items-center text-primary">
                                <i class="fa fa-file p-1 viewDocno" data-bs-toggle="tooltip" title="View document no"
                                data-irid="'.$row["ir_id"].'">
                                </i>
                            </small>';
        }
        

        $sub_array = [];
     
        // $sub_array[] = '<div class="clearfix ms-2">
        //                     <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" 
        //                         data-docno="'.$row["ir_docno"].'" title="Click to view details"><span class="fs-14">'.$row["ir_docno"].'<br>'.$srid.'</span>
        //                     </a>
        //                 </div>';
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2 viewDocument" 
                            data-irid="'.$row['ir_id'].'"
                            data-bs-toggle="tooltip" title="Click to view document no"">
                            <h6 class="mb-0 fw-semibold">'.$display_docno.'</h6>
                        </a>';
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2 viewMaterial" 
                            data-inspect-group="'.$row["inspect_group"].'"
                            data-material="'.$row['ir_material'].'" data-model="'.$row['ir_model'].'"  
                            data-bs-toggle="tooltip" title="Click to view material images"">
                            <h6 class="mb-0 fw-semibold">'.$row["matno"].'</h6>
                            <span class="fs-14">'.$row["matdesc"].'</span>
                        </a>';
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row["modcode"].'</h6>
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["typeside"].')'.'</span>
                        </div>'; 
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$isnpectiondate.'</span></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span></div>';
        $sub_array[] = $statusBadge;
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
// ADD SORTING DETAILS
// ==========================================================
if ($_POST['action'] == 'add_s2w') {

    $ir_id = intval($_POST['ir_id']);
    $sr_id = intval($_POST['sr_id']);
    $add_info = trim($_POST['add_info']);
    $send_dept = intval($_POST['send_dept']);

    // update S2W status n table inspection records & sorting
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
    $stmt->bind_param('ii', $s_draft_id, $ir_id);
    $stmt->execute();

    $stmtSR = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
    $stmtSR->bind_param('ii', $s_draft_id, $sr_id);
    $stmtSR->execute();

    // Insert main
    $stmt = $db_con->prepare("
        INSERT INTO inspection_s2w 
        (s2w_ir_id, s2w_sr_id, s2w_additional_desc, s2w_send_to, s2w_status, created_by, created_date)
        VALUES (?, ?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param("iisiis", $ir_id, $sr_id, $add_info, $send_dept, $s_draft_id, $session_id);
    $stmt->execute();

    $s2w_id = $stmt->insert_id;

    // Folder
    $folder = __DIR__ . "/gallery/s2w/defect/" . $s2w_id;
    if (!is_dir($folder)) mkdir($folder, 0777, true);

    // Upload defect photos
    if (!empty($_FILES['defect_photo_s2w']['name'][0])) {
        foreach ($_FILES['defect_photo_s2w']['tmp_name'] as $i => $tmp) {

            $original = basename($_FILES['defect_photo_s2w']['name'][$i]);
            $filename = uniqid() . "_" . $original;

            move_uploaded_file($tmp, "$folder/$filename");

            $p = $db_con->prepare("
                INSERT INTO inspection_s2w_defect_photo 
                (s2w_ir_id, s2w_sr_id, s2w_id, defect_photo, created_by, created_date)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $p->bind_param("iiiss", $ir_id, $sr_id, $s2w_id, $filename, $session_id);
            $p->execute();
        }
    }

    echo json_encode([
        "status" => "success",
        "s2w_id" => $s2w_id
    ]);
    exit;
}

// ==========================================================
// GET SORTING DETAILS
// ==========================================================
if ($_POST['action'] == 'get_s2w_details') {

    $sr_id = intval($_POST['sr_id']);

    // ---------------------------------------------
    // 1. FETCH MAIN S2W HEADER
    // ---------------------------------------------
    $q = $db_con->prepare("
        SELECT 
            s2w.s2w_id,
            s2w.s2w_ir_id,
            s2w.s2w_sr_id,
            s2w.s2w_docno,
            s2w.s2w_additional_desc,
            s2w.s2w_send_to,
            s2w.s2w_status,
            s2w.created_by,
            s2w.created_date,
            s2w.updated_by,
            s2w.updated_date,
            t.statusname
        FROM inspection_s2w s2w
        LEFT JOIN system_status t ON s2w.s2w_status = t.statusid 
        WHERE s2w.s2w_sr_id = ? 
        ORDER BY s2w.s2w_id DESC
        LIMIT 1
    ");
    $q->bind_param("i", $sr_id);
    $q->execute();
    $header = $q->get_result()->fetch_assoc();

    if (!$header) {
        echo json_encode([
            "status" => "success",
            "data" => [
                "s2w_id" => 0,
                "s2w_ir_id" => 0,
                "s2w_sr_id" => $sr_id,
                "s2w_additional_desc" => "",
                "s2w_send_to" => "",
                "s2w_status" => "",
                "photo_defect" => []
            ]
        ]);
        exit;
    }

    $s2w_id = $header['s2w_id'];

    // ---------------------------------------------
    // 2. FETCH DEFECT PHOTOS
    // ---------------------------------------------
    $photos = [];

    $p = $db_con->prepare("
        SELECT 
            defect_photoid,
            defect_photo
        FROM inspection_s2w_defect_photo
        WHERE s2w_id = ?
        ORDER BY defect_photoid ASC
    ");
    $p->bind_param("i", $s2w_id);
    $p->execute();
    $r = $p->get_result();

    while ($row = $r->fetch_assoc()) {
        $photos[] = [
            "defect_photoid" => $row['defect_photoid'],
            "s2w_id" => $s2w_id,
            "file" => $row['defect_photo']
        ];
    }

    // ---------------------------------------------
    // 3. BUILD FINAL CLEAN STRUCTURE
    // ---------------------------------------------
    echo json_encode([
        "status" => "success",
        "data" => [
            "ir_id" => $header['s2w_ir_id'],
            "sr_id" => $sr_id,
            "s2w_id" => $header['s2w_id'],            
            "s2w_docno" => $header['s2w_docno'],
            "s2w_additional_desc" => $header['s2w_additional_desc'],
            "s2w_send_to" => $header['s2w_send_to'],
            "s2w_status" => $header['s2w_status'], 
            "sr_statusname" => $header['statusname'],
            "photo_defect" => $photos
        ]
    ]);
    exit;
}

// ==========================================================
// UPDATE SORTING RECORD
// ==========================================================
if ($_POST['action'] == 'update_s2w') {

    $ir_id = intval($_POST['ir_id']);
    $sr_id = intval($_POST['sr_id']);
    $s2w_id = intval($_POST['s2w_id']);
    $add_info = trim($_POST['add_info']);
    $send_dept = intval($_POST['send_dept']);

    // Update main
    $stmt = $db_con->prepare("
        UPDATE inspection_s2w 
        SET s2w_additional_desc=?, s2w_send_to=?, updated_by=?, updated_date=NOW() 
        WHERE s2w_id=?
    ");
    $stmt->bind_param("siii", $add_info, $send_dept, $session_id, $s2w_id);
    $stmt->execute();

    // Folder
    $folder = __DIR__ . "/gallery/s2w/defect/" . $s2w_id;
    if (!is_dir($folder)) mkdir($folder, 0777, true);

    // Upload NEW photos only
    if (!empty($_FILES['defect_photo_s2w']['name'][0])) {
        foreach ($_FILES['defect_photo_s2w']['tmp_name'] as $i => $tmp) {

            $original = basename($_FILES['defect_photo_s2w']['name'][$i]);
            $filename = uniqid() . "_" . $original;

            move_uploaded_file($tmp, "$folder/$filename");

            $p = $db_con->prepare("
                INSERT INTO inspection_s2w_defect_photo
                (s2w_ir_id, s2w_sr_id, s2w_id, defect_photo, created_by, created_date)
                VALUES (?, ?, ?, ?, ?, NOW())
            ");
            $p->bind_param("iiiss", $ir_id, $sr_id, $s2w_id, $filename, $session_id);
            $p->execute();
        }
    }

    echo json_encode([
        "status" => "success",
        "message" => "Updated"
    ]);
    exit;
}

// ==========================================================
// DELETE EXISTING PHOTO
// ========================== ================================
if ($_POST['action'] == 'delete_defect_photo') {

    $id = intval($_POST['id']);
    $s2w_id = intval($_POST['s2w_id']);

    $q = $db_con->prepare("SELECT defect_photo FROM inspection_s2w_defect_photo WHERE defect_photoid = ?");
    $q->bind_param("i", $id);
    $q->execute();
    $res = $q->get_result()->fetch_assoc();

    if ($res) {
        $file = __DIR__ . "/gallery/s2w/defect/$s2w_id/" . $res['defect_photo'];
        if (file_exists($file)) unlink($file);
    }

    $db_con->query("DELETE FROM inspection_s2w_defect_photo WHERE defect_photoid = $id");

    echo json_encode(["status" => "success"]);
    exit;
}

// ==========================================================
// SUBMIT SORTING RECORD FOR REVIEW
// ========================== ================================
if($_POST['action'] == 'submit_for_review')
{
    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $s2w_id = $_POST['s2w_id'];
    $s2w_status = $_POST['s2w_status'];  
    $add_info = trim($_POST['add_info']);
    $send_dept  = trim($_POST['send_dept']);
    $transid = 5; 

    //if draft create new docno, no need for returned
    if($s2w_status  ==  $s_draft_id)
    {
        $transmodule = "S2W";   // Or from your code
        $transprocess = "New";                // Or "Cancel", etc.
        $current_shift = $current_shift;      // E.g. 'D', 'N' from your shift logic
        $shift_date = $shift_date;  // E.g. '2024-08-06'

        $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

        //generate doc no
        //comp,code,date,running no
        $s2w_docno = $session_comp . $s2w_code . $doc_date . $running_no;

        // 1. Increment maximum_no by 1
        $stmt = $db_con->prepare("UPDATE transaction_type SET maximum_no = maximum_no + 1 WHERE transid = ?");
        $stmt->bind_param('i', $transid);
        $stmt->execute();

        // 2. Update inspection_sorting
        $stmt2 = $db_con->prepare("UPDATE inspection_s2w SET s2w_docno = ?, s2w_additional_desc = ?, s2w_send_to = ?, 
                                    s2w_status = ?, submitted_by = ?, submitted_date = NOW() WHERE s2w_id = ?");
        $stmt2->bind_param('ssiisi', $s2w_docno, $add_info, $send_dept, $s_pendReview_id, $session_id, $s2w_id);
        $stmt2->execute();
        
    }
    else { //for return SR and resubmit
        
        // 2. Update inspection_sorting
        $stmt2 = $db_con->prepare("UPDATE inspection_s2w SET s2w_additional_desc = ?, s2w_send_to = ?, 
                                    s2w_status = ?, submitted_by = ?, submitted_date = NOW() WHERE s2w_id = ?");
        $stmt2->bind_param('siisi', $add_info, $send_dept, $s_pendReview_id, $session_id, $s2w_id);
        $stmt2->execute();
    }

    // --- DEFECT photos (NG) ---
    if (!empty($_FILES['defect_photo_s2w']['name'][0])) {
        foreach ($_FILES['defect_photo_s2w']['tmp_name'] as $idx => $tmp) {
            $original_name = basename($_FILES['defect_photo']['name'][$idx]);
            $filename = uniqid() . '_' . $original_name;
            $targetPath = __DIR__ . "/gallery/s2w/defect/" .$s2w_id. "/" . $filename;

            // Check if same filename already exists for this ir_id
            $check = $db_con->prepare("SELECT COUNT(*) FROM inspection_s2w_defect_photo WHERE s2w_id = ? AND defect_photo = ?");
            $check->bind_param("is", $s2w_id, $filename);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();

            if ($count == 0) {
                // Move and insert only if not duplicate
                move_uploaded_file($tmp, $targetPath);
                $stmt3 = $db_con->prepare("INSERT INTO inspection_s2w_defect_photo (s2w_ir_id, s2w_sr_id, s2w_id, defect_photo, updated_by, updated_date) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt3->bind_param("iiiss", $ir_id, $sr_id, $s2w_id, $filename, $session_id);
                $stmt3->execute();
            }
        }
    }

    // 1.4 update sorting status n table inspection records
    $stmt5 = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
    $stmt5->bind_param('ii', $s_pendReview_id, $ir_id);
    $stmt5->execute();

    // 1.4 update sorting status n table inspection sorting
    $stmt5_1 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
    $stmt5_1->bind_param('ii', $s_pendReview_id, $sr_id);
    $stmt5_1->execute();

    // --- Send Email Notification ---
    $recipients = [];

    //3. Select users with a specific role
    $sql = "SELECT E.staff_name, E.staff_email
                FROM user_authorization A 
                    LEFT JOIN employee_details E ON E.staff_id = A.staff_id
                        WHERE A.S2W_reviewer = 'Y'";
    $result = $db_con->query($sql);
    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row;
    }

    // 4. Fetch s2w details
    $stmt4 = $db_con->prepare("SELECT S.s2w_id, S.s2w_docno, R.ir_id, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_s2w S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.s2w_ir_id
                                            LEFT JOIN material_header M ON R.ir_material = M.matid
                                                WHERE S.s2w_id = ?");
    $stmt4->bind_param('i', $s2w_id);
    $stmt4->execute();
    $inspectiondet = $stmt4->get_result()->fetch_assoc();

    //5. activity comment
    $appsection = 'PDI';
    $apptask = 'S2W';
    $comment_status = "submit the Something When Wrong (S2W)";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_pendReview_id, $s2w_docno, $inspectiondet['ir_shift'], $inspectiondet['inspect_date'], $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    //submitter = user login
    $submitter_name  = $stf_name;
    $doc_no = $inspectiondet['s2w_docno'];
    $inspectdate = date('d-m-Y', strtotime($inspectiondet['inspect_date']));
    $shiftdet = $inspectiondet['ir_shift'] == 'D' ? 'Day' : 'Night';

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
        $mail->Subject =  $esubject_6;

        $mail->Body = "<h4>Dear {$authouser['staff_name']},</h4>";
        $mail->Body .= "<p>A new Something When Wrong (S2W) (<strong>Doc No: $doc_no </strong>) has been submitted by $submitter_name and requires your review. </p>";
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
        'msg' => 'Something When Wrong (S2W) submitted for review.',
        'ir_id' => $ir_id,
        'emails_sent' => $success_count,
        'emails_failed' => $fail_count,
        'failed_list' => $fail_emails
    ];

    echo json_encode($response);
    exit; // <--- always exit after sending AJAX response
}

// ==========================================================
// CANCEL SORTING RECORD
// ========================== ================================
if ($_POST['action'] == 'cancel_record') {

    $ir_id  = intval($_POST['ir_id'] ?? 0);
    $sr_id  = intval($_POST['sr_id'] ?? 0);
    $s2w_id  = intval($_POST['s2w_id'] ?? 0);
    $remark = trim($_POST['remark'] ?? '');
    $transid = 6; 

    //generate doc no
    //comp,code,date,running no
    $sr_docnocanc = $session_comp . $s2w_cancelcode . $doc_date . $s2w_ccancelcode_max;

    // 1. Set current record to Cancelled (status = 8)
    $stmt = $db_con->prepare("UPDATE inspection_s2w SET s2w_docnocancel = ?, s2w_status = ? ,cancel_remark = ?, cancelled_by = ?, cancelled_date = NOW() WHERE s2w_id = ?");
    $stmt->bind_param('sissi', $sr_docnocanc, $s_cancelled_id, $remark, $session_id, $s2w_id);
    $stmt->execute();

    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
    $stmt2->bind_param('ii', $s_new_id, $sr_id);
    $stmt2->execute();

    // 21. Update sorting status to New (status = 1) in table inspection
    $stmt2_1 = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
    $stmt2_1->bind_param('ii', $s_new_id, $ir_id);
    $stmt2_1->execute();

    // 3. Increment maximum_no by 1 f
    $stmt3 = $db_con->prepare("UPDATE transaction_type SET maximum_no = maximum_no + 1 WHERE transid = ?");
    $stmt3->bind_param('i', $transid);
    $stmt3->execute();

    // 4. Fetch s2w details
    $stmt4 = $db_con->prepare("SELECT S.s2w_id, S.s2w_docno, R.ir_id, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_s2w S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.s2w_ir_id
                                            LEFT JOIN material_header M ON R.ir_material = M.matid
                                                WHERE S.s2w_id = ?");
    $stmt4->bind_param('i', $s2w_id);
    $stmt4->execute();
    $inspectiondet = $stmt4->get_result()->fetch_assoc();

    // 5. activity comment
    $appsection = 'PDI';
    $apptask = 'S2W';
    $comment_status = "cancel Something When Wrong (S2W) submission";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_cancelled_id, $sr_docnocanc, $inspectiondet['ir_shift'], $inspectiondet['inspect_date'], $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    echo json_encode(['success' => true]);
    exit;
}

?>