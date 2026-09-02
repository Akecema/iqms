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
    $columns = array('S.s2w_docno', 'M.matno', 'P.modcode', 'I.inspect_date', 'H.shiftdesc', 'I.ir_s2w_status');

    $query = "SELECT I.ir_id, I.ir_docno, I.ir_type, I.ir_model, I.ir_material, I.ir_s2w_status,
                     I.inspect_date, I.shift_date, I.ir_shift, 
                     S.s2w_id, S.s2w_ir_id, S.s2w_sr_id, S.s2w_docno, S.s2w_status, S.created_date, S.created_by,
                     T.modcode, P.typemodel, M.partside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc, H.shiftbadge,
                     U.statusname
              FROM inspection_s2w S
              LEFT JOIN inspection_records I ON S.s2w_ir_id = I.ir_id
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              LEFT JOIN system_status AS U ON S.s2w_status = U.statusid
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
        $query .= " AND S.s2w_status = '$status' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);

         $query .= " AND (
                        S.s2w_docno LIKE '%$search%' 
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
        $query .= " ORDER BY S.s2w_id ASC"; // default sort by pallet sequence
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
        $ids[] = $row['s2w_id'];
    }

    $data = [];

    foreach ($records as $row) {

        $s2wid = $row['s2w_id'];
        $srStatus = $row['s2w_status'];

        // Status badge
        $statusBadge = '';

        $queryBadge = "SELECT 
                            r.*,
                            s.statusname,
                            s.badge,
                            s.badge_color,
                            s.text_color,
                            s.icon_class
                        FROM inspection_s2w r
                        LEFT JOIN system_status s 
                        ON s.statusid = r.s2w_status
                        WHERE r.s2w_id = '$s2wid' ";        

        $resultBadge = mysqli_query($db_con, $queryBadge);
        $rowABadge = mysqli_fetch_assoc($resultBadge);

        if (!empty($rowABadge['statusname']) && ($row['s2w_status'] != 1)) {

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
        $enc_s2wid = urlencode(encryptData($row['s2w_id']));
        $enc_srid = urlencode(encryptData($row['s2w_sr_id']));
        $enc_irid = urlencode(encryptData($row['s2w_ir_id']));
        $enc_status = urlencode(encryptData($row['s2w_status']));
        
        // Action buttons
        $btnAction = '';

        // Check if user can edit/cancel (role 2 can only edit their own records)
        $canEdit = true;
        if ($session_role == 2) {
            $canEdit = ($row['created_by'] == $session_id);
        }

        if (in_array($row['s2w_status'], [12, 13])) { //return, draft
            if ($canEdit) {
                // EDIT button
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="Edit S2W" data-s2wid="'.$row['s2w_id'].'" data-encs2wid="'.$enc_s2wid.'"
                                data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-status="'.$row["s2w_status"].'" data-encstatus="'.$enc_status.'" 
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-edit"></i>
                            </button>';
            } else {
                 // VIEW button
                 $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1" 
                                data-bs-toggle="tooltip" title="View S2W" data-s2wid="'.$row["s2w_id"].'" data-encs2wid="'.$enc_s2wid.'"
                                data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-status="'.$row["s2w_status"].'" data-encstatus="'.$enc_status.'">
                                <i class="fa fa-bars"></i>
                            </button>';
            }
        }
        elseif (in_array($row['s2w_status'], [9])) { //pending review,pending approval
            if ($canEdit) {
                // CANCEL button           
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="Cancel S2W" data-s2wid="'.$row['s2w_id'].'" data-encs2wid="'.$enc_s2wid.'"
                                data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-status="'.$row["s2w_status"].'" data-encstatus="'.$enc_status.'" 
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-times"></i>
                            </button>';
            } else {
                // VIEW button
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1" 
                                data-bs-toggle="tooltip" title="View S2W" data-s2wid="'.$row["s2w_id"].'" data-encs2wid="'.$enc_s2wid.'"
                                data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-status="'.$row["s2w_status"].'" data-encstatus="'.$enc_status.'">
                                <i class="fa fa-bars"></i>
                            </button>';
            }
        }
        elseif (in_array($row['s2w_status'], [4, 5, 8, 10])) { //approved, cancel
            // VIEW button           
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1" 
                            data-bs-toggle="tooltip" title="View S2W" data-s2wid="'.$row["s2w_id"].'" data-encs2wid="'.$enc_s2wid.'"
                            data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-status="'.$row["s2w_status"].'" data-encstatus="'.$enc_status.'">
                            <i class="fa fa-bars"></i>
                        </button>';
        }

        //icon view all doc no
        $icon_arrow = '';

        if($row["s2w_docno"] != "") {
            $icon_arrow = '<i class="fa fa-plus doc-arrow ms-2" aria-hidden="true"></i>';
        }

        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
        
        // $sub_array[] = '<a href="javascript:void(0);"
        //                     class="viewDocument d-flex align-items-center"
        //                     data-irid="'.$row['ir_id'].'"
        //                     data-bs-toggle="tooltip"
        //                     title="Click to view document no">
        //                     <span class="mb-0 fw-semibold text-dark">'.$row["s2w_docno"].'</span>
        //                     '.$icon_arrow.'
        //                 </a>';
        // $sub_array[] = '<a href="javascript:void(0);"
        //                     class="viewDocument d-flex align-items-center"
        //                     data-irid="'.$row['ir_id'].'"
        //                     data-bs-toggle="tooltip"
        //                     title="Click to view document no">
        //                     <span class="mb-0 fw-semibold text-dark">'.$row["s2w_docno"].'</span>
        //                 </a>';
    
        $s2w_status = intval($row['s2w_status']);
        
        // Disable checkbox for: completed statuses OR role 2 users who don't own the record
        $disableCheck = (in_array($s2w_status, [1,4,5,8,11])) ? 'disabled' : '';
        if ($session_role == 2 && !$canEdit) {
            $disableCheck = 'disabled';
        }
        
        $sub_array = [];
         
        $sub_array[] = '<input type="checkbox"
                            class="row-check form-check-input"
                            value="'.$row["s2w_sr_id"].'"
                            data-status="'.$s2w_status.'"
                            '.$disableCheck.'>';
        $sub_array[] = '<span class="fs-14">'.$row["s2w_docno"].'</span></a>';
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2 viewMaterial" data-docno="'.$row["ir_docno"].'"
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
if ($_POST['action'] == 'get_s2w_details') {

    $s2w_id = intval($_POST['s2w_id']);

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
            t.statusname,
            d.rd_dept_name as send_dept
        FROM inspection_s2w s2w
        LEFT JOIN system_status t ON s2w.s2w_status = t.statusid 
        LEFT JOIN related_departments d ON s2w.s2w_send_to = d.rd_dept_id 
        WHERE s2w.s2w_id = ?
    ");
    $q->bind_param("i", $s2w_id);
    $q->execute();
    $header = $q->get_result()->fetch_assoc();

    if (!$header) {
        echo json_encode([
            "status" => "success",
            "data" => [
                "s2w_id" => $s2w_id,
                "s2w_ir_id" => $header['s2w_ir_id'],
                "s2w_sr_id" => $header['s2w_sr_id'],
                "s2w_additional_desc" => "",
                "s2w_send_to" => "",
                "s2w_status" => "",
                "photo_defect" => [],
                "photo_ok" => []
            ]
        ]);
        exit;
    }

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

    $k = $db_con->prepare("
        SELECT 
            ok_photoid,
            ok_photo
        FROM inspection_s2w_ok_photo
        WHERE s2w_id = ?
        ORDER BY ok_photoid ASC
    ");
    $k->bind_param("i", $s2w_id);
    $k->execute();
    $m = $k->get_result();

    while ($row = $m->fetch_assoc()) {
        $photos_ok[] = [
            "ok_photoid" => $row['ok_photoid'],
            "s2w_id" => $s2w_id,
            "file" => $row['ok_photo']
        ];
    }

    // ---------------------------------------------
    // 3. BUILD FINAL CLEAN STRUCTURE
    // ---------------------------------------------
    echo json_encode([
        "status" => "success",
        "data" => [
            "ir_id" => $header['s2w_ir_id'],
            "sr_id" => $header['s2w_sr_id'],
            "s2w_id" => $s2w_id,            
            "s2w_docno" => $header['s2w_docno'],
            "s2w_additional_desc" => $header['s2w_additional_desc'],
            "s2w_send_to" => $header['s2w_send_to'],
            "send_dept" => $header['send_dept'],
            "s2w_status" => $header['s2w_status'], 
            "created_by" => $header['created_by'],
            "sr_statusname" => $header['statusname'],
            "photo_defect" => $photos,
            "photo_ok" => $photos_ok
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
    $folder = __DIR__ . "/gallery/inspection_s2w/photo_defect/" . $s2w_id;
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

    // Folder
    $folder_ok = __DIR__ . "/gallery/inspection_s2w/photo_ok/" . $s2w_id;
    if (!is_dir($folder_ok)) mkdir($folder_ok, 0777, true);

    // Upload NEW photos only
    if (!empty($_FILES['ok_photo_s2w']['name'][0])) {
        foreach ($_FILES['ok_photo_s2w']['tmp_name'] as $i => $tmp) {

            $original = basename($_FILES['ok_photo_s2w']['name'][$i]);
            $filename = uniqid() . "_" . $original;

            move_uploaded_file($tmp, "$folder_ok/$filename");

            $p = $db_con->prepare("
                INSERT INTO inspection_s2w_ok_photo
                (s2w_ir_id, s2w_sr_id, s2w_id, ok_photo, created_by, created_date)
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
        $file = __DIR__ . "/gallery/inspection_s2w/photo_defect/$s2w_id/" . $res['defect_photo'];
        if (file_exists($file)) unlink($file);
    }

    $db_con->query("DELETE FROM inspection_s2w_defect_photo WHERE defect_photoid = $id");

    echo json_encode(["status" => "success"]);
    exit;
}

if ($_POST['action'] == 'delete_ok_photo') {

    $id = intval($_POST['id']);
    $s2w_id = intval($_POST['s2w_id']);

    $q = $db_con->prepare("SELECT ok_photo FROM inspection_s2w_ok_photo WHERE ok_photoid = ?");
    $q->bind_param("i", $id);
    $q->execute();
    $res = $q->get_result()->fetch_assoc();

    if ($res) {
        $file = __DIR__ . "/gallery/inspection_s2w/photo_ok/$s2w_id/" . $res['ok_photo'];
        if (file_exists($file)) unlink($file);
    }

    $db_con->query("DELETE FROM inspection_s2w_ok_photo WHERE ok_photoid = $id");

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
        // $stmt = $db_con->prepare("UPDATE transaction_type SET maximum_no = maximum_no + 1 WHERE transid = ?");
        // $stmt->bind_param('i', $transid);
        // $stmt->execute();

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
            $original_name = basename($_FILES['defect_photo_s2w']['name'][$idx]);
            $filename = uniqid() . '_' . $original_name;
            $targetPath = __DIR__ . "/gallery/inspection_s2w/photo_defect/" .$s2w_id. "/" . $filename;

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

    // --- OK photos ---
    if (!empty($_FILES['ok_photo_s2w']['name'][0])) {
        foreach ($_FILES['ok_photo_s2w']['tmp_name'] as $idx => $tmp) {
            $original_name = basename($_FILES['ok_photo_s2w']['name'][$idx]);
            $filename = uniqid() . '_' . $original_name;
            $targetPath = __DIR__ . "/gallery/inspection_s2w/photo_ok/" .$s2w_id. "/" . $filename;

            // Check if same filename already exists for this ir_id
            $check = $db_con->prepare("SELECT COUNT(*) FROM inspection_s2w_ok_photo WHERE s2w_id = ? AND ok_photo = ?");
            $check->bind_param("is", $s2w_id, $filename);
            $check->execute();
            $check->bind_result($count);
            $check->fetch();
            $check->close();

            if ($count == 0) {
                // Move and insert only if not duplicate
                move_uploaded_file($tmp, $targetPath);
                $stmt3 = $db_con->prepare("INSERT INTO inspection_s2w_ok_photo (s2w_ir_id, s2w_sr_id, s2w_id, ok_photo, updated_by, updated_date) VALUES (?, ?, ?, ?, ?, NOW())");
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
    // $stmt3 = $db_con->prepare("UPDATE transaction_type SET maximum_no = maximum_no + 1 WHERE transid = ?");
    // $stmt3->bind_param('i', $transid);
    // $stmt3->execute();

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