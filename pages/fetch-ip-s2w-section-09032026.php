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
    $columns = array('I.sr_docno', 'M.matno', 'P.modcode', 'I.inspect_date', 'H.shiftdesc',  'I.ir_status');
    
    // $query = "SELECT S.s2w_id, S.s2w_ir_id, S.s2w_sr_id, S.s2w_docno, S.s2w_status, S.s2w_rp_status, S.created_by,
    //                  I.ir_id, I.ir_docno, I.ir_model, I.ir_type, I.ir_material, I.ir_pallet_no, I.ir_result, I.ir_status, 
    //                  I.inspect_date, I.shift_date, I.inspect_group, I.ir_shift, I.created_date,
    //                  (SELECT created_by FROM inspection_s2w_report WHERE rp_s2w_id = S.s2w_id ORDER BY rp_id DESC LIMIT 1) as rp_s2w_created_by,
    //                  T.modcode, P.typemodel, M.partside, 
    //                  M.matno, M.matdesc, 
    //                  H.shiftdesc, H.shiftbadge
    //           FROM inspection_s2w S  
    //           LEFT JOIN inspection_records AS I ON S.s2w_ir_id = I.ir_id
    //           LEFT JOIN related_departments R ON S.s2w_send_to = R.rd_dept_id
    //           LEFT JOIN model_details AS T ON I.ir_model = T.modid
    //           LEFT JOIN model_type AS P ON I.ir_type = P.typeid
    //           LEFT JOIN material_header AS M ON I.ir_material = M.matid 
    //           LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
    //           LEFT JOIN system_status AS U ON S.s2w_status = U.statusid
    //           WHERE S.s2w_status = '$s_approved_id' 
    //           AND R.mast_dept_id = '$stf_departmentID'
    //           AND I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date' ";

    // allow to S2W REPLY anytime, cannot lock by shift date due to delay approve s2w report - 11022026
    $query = "SELECT S.s2w_id, S.s2w_ir_id, S.s2w_sr_id, S.s2w_docno, S.s2w_status, S.s2w_rp_status, S.created_by,
                     I.ir_id, I.ir_docno, I.ir_model, I.ir_type, I.ir_material, I.ir_pallet_no, I.ir_result, I.ir_status, 
                     I.inspect_date, I.shift_date, I.inspect_group, I.ir_shift, I.created_date,
                     (SELECT created_by FROM inspection_s2w_report WHERE rp_s2w_id = S.s2w_id ORDER BY rp_id DESC LIMIT 1) as rp_s2w_created_by,
                     T.modcode, P.typemodel, M.partside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc, H.shiftbadge
              FROM inspection_s2w S  
              LEFT JOIN inspection_records AS I ON S.s2w_ir_id = I.ir_id
              LEFT JOIN related_departments R ON S.s2w_send_to = R.rd_dept_id
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              LEFT JOIN system_status AS U ON S.s2w_status = U.statusid
              WHERE S.s2w_status = '$s_approved_id'  ";
    
    if ($session_role != 1) {
        // superadmin can view all
        $query .= "AND R.mast_dept_id = '$stf_departmentID' ";
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

    if (!empty($_POST['fd_status'])) {
        $status = intval($_POST['fd_status']);
        $query .= " AND S.s2w_rp_status = '$status' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);
       
        // Combine: subquery filter + multi-column search
        $query .= " AND (
                    -- 1. Match sr_docno in sorting (exclude status 1 & 13)
                    S.sr_id IN (
                        SELECT rp_s2w_id, rp_s2w_docno
                        FROM inspection_s2w_report
                        WHERE rp_s2w_docno LIKE '%$search%' 
                        AND rp_s2w_status != 1 
                        AND rp_s2w_status != 13
                    )

                    -- 2. OR match other columns (joined fields)
                    OR U.statusname LIKE '%$search%'
                    OR T.modcode LIKE '%$search%'
                    OR P.typemodel LIKE '%$search%'
                    OR M.partside LIKE '%$search%'
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
        $query .= " ORDER BY S.rp_s2w_id ASC"; // default sort by pallet sequence
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
        $s2wid = $row['s2w_id'];

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
                        ON s.statusid = r.s2w_rp_status
                        WHERE r.s2w_id = '$s2wid' ";        

        $resultBadge = mysqli_query($db_con, $queryBadge);
        $rowABadge = mysqli_fetch_assoc($resultBadge);

        if (!empty($rowABadge['statusname'])) {

            $badgeClass = trim($rowABadge['badge'] . '-' . $rowABadge['badge_color']);
            $textColor = $rowABadge['text_color'];
            $iconClass  = $rowABadge['icon_class'];

            $statusBadge = '
                <span class="badge badge-rounded ' . $badgeClass . ' badge-sm ' . 'style="color: ' . $textColor . '">
                    ' . ($iconClass ? '<i class="la ' . $iconClass . ' me-0"></i>' : '') . '
                    ' . htmlspecialchars($rowABadge['statusname']) . '
                </span>
            ';
        }

        //encrypt url
        $enc_s2wid = urlencode(encryptData($row['s2w_id']));
        $enc_srid = urlencode(encryptData($row['s2w_sr_id']));
        $enc_irid = urlencode(encryptData($row['s2w_ir_id']));
        $enc_status = urlencode(encryptData($row['s2w_rp_status']));
        
        // Action buttons moved down

        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));

        $display_docno = '';

        // If status in 4,7,10,12,13 → get sr_docno from inspection_sorting
        $q_sr = $db_con->prepare("SELECT rp_s2w_docno, rp_s2w_status, created_by FROM inspection_s2w_report WHERE rp_s2w_id = ?");
        $q_sr->bind_param("i", $s2wid);
        $q_sr->execute();
        $q_sr->bind_result($s2w_docno, $s2w_status, $rep_created_by);
        if ($q_sr->fetch()) {
            if ($s2w_status != 1 && $s2w_status != 8 && $s2w_status != 13) {
                $display_docno = $s2w_docno;
            } else {
                $display_docno = ''; // hide docno if status 1 or 13
            }
        }
        $q_sr->close();

        $canEdit = true;
        // Role 2 restriction: can only edit own records
        if ($session_role == 2) {
            $canEdit = ($row['rp_s2w_created_by'] == $session_id);
        }

        // Action buttons
        $btnAction = ''; 

        if ($row['s2w_rp_status'] == 1) {
            // ADD button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnCreate ms-1"
                            data-bs-toggle="tooltip" title="Reply" data-s2wid="'.$enc_s2wid.'"
                            data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-model="'.$row['ir_model'].'"
                            data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-plus"></i>
                        </button>';
        }
        elseif (in_array($row['s2w_rp_status'], [12, 13, 16]) && $canEdit) {
            // EDIT button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnEdit ms-1"
                            data-bs-toggle="tooltip" title="Edit" data-s2wid="'.$enc_s2wid.'"
                            data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-model="'.$row['ir_model'].'"
                            data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-edit"></i>
                        </button>';
        }
        else { 
             // VIEW button
             if ($row['s2w_rp_status'] != 1) {
                 $title = ($canEdit) ? "View" : "View";
                 $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnView ms-1"
                                 data-bs-toggle="tooltip" title="'.$title.'" data-s2wid="'.$enc_s2wid.'"
                                 data-irid="'.$row['ir_id'].'" data-srid="'.$enc_srid.'" data-model="'.$row['ir_model'].'"
                                 data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                 <i class="fa fa-list"></i>
                             </button>';
             }
        }

        $s2w_rp_status = intval($row['s2w_rp_status']);
        $disabled = ($s2w_rp_status == 1 || $s2w_rp_status == 11) ? 'disabled' : '';
        if (!$canEdit) { $disabled = 'disabled'; }
        
        $sub_array = [];
     
        $sub_array[] = '<input type="checkbox"
                            class="row-check form-check-input"
                            value="'.$row["s2w_id"].'"
                            data-status="'.$s2w_rp_status.'"
                            '.$disabled.'>';
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2 viewDocument" 
                            data-irid="'.$row['ir_id'].'"
                            data-bs-toggle="tooltip" title="">
                            <span class="fs-14">'.$row["s2w_docno"].'</span>
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
// ADD RECORD
// ==========================================================
if ($_POST['action'] == 'add_s2w_report') {

    $ir_id  = intval($_POST['ir_id']);
    $sr_id  = intval($_POST['sr_id']);
    $s2w_id = intval($_POST['s2w_id']);

    // Fetch s2w_send_to
    $q_send = $db_con->prepare("SELECT s2w_send_to FROM inspection_s2w WHERE s2w_id = ?");
    $q_send->bind_param("i", $s2w_id);
    $q_send->execute();
    $q_send->bind_result($s2w_send_to);
    $q_send->fetch();
    $q_send->close();

    $fd_cronology       = trim($_POST['fd_cronology']);
    $fd_rootcause       = trim($_POST['fd_rootcause']);
    $fd_rootcause_area  = trim($_POST['fd_rootcause_area']);
    $fd_rootcause_place = trim($_POST['fd_rootcause_place']);
    $fd_correction      = trim($_POST['fd_correction']);
    $fd_preventive      = trim($_POST['fd_preventive']);
    $fd_conclusion      = trim($_POST['fd_conclusion']);

    // Set S2W status → Draft
    $stmt = $db_con->prepare("
                UPDATE inspection_s2w 
                SET s2w_rp_status = ? 
                WHERE s2w_id = ?");
    $stmt->bind_param("ii", $s_draft_id, $s2w_id);
    $stmt->execute();

    // INSERT REPORT
    $stmt = $db_con->prepare("
        INSERT INTO inspection_s2w_report
        (
            rp_s2w_ir_id, rp_s2w_sr_id, rp_s2w_id, rp_s2w_send_to,
            rp_s2w_cronology, rp_s2w_rootcause, rp_s2w_rootcause_area,
            rp_s2w_rootcause_place, rp_s2w_correction, rp_s2w_preventive,
            rp_s2w_conclusion, rp_s2w_status,
            created_by, created_date
        )
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

    $stmt->bind_param(
        "iiiisssssssis",
        $ir_id, $sr_id, $s2w_id, $s2w_send_to,
        $fd_cronology, $fd_rootcause, $fd_rootcause_area,
        $fd_rootcause_place, $fd_correction, $fd_preventive,
        $fd_conclusion, $s_draft_id,
        $session_id
    );

    $stmt->execute();
    $rp_id = $stmt->insert_id;

    // CREATE FOLDERS
    $folder_corr = __DIR__ . "/gallery/inspection_s2w_report/photo_correction/$rp_id";
    $folder_prev = __DIR__ . "/gallery/inspection_s2w_report/photo_preventive/$rp_id";

    if (!is_dir($folder_corr)) mkdir($folder_corr, 0777, true);
    if (!is_dir($folder_prev)) mkdir($folder_prev, 0777, true);

    // UPLOAD CORRECTION PHOTOS
    if (!empty($_FILES["correction_photo"]["name"][0])) {
        foreach ($_FILES["correction_photo"]["name"] as $i => $name) {

            $filename = uniqid() . "_" . basename($name);
            move_uploaded_file($_FILES["correction_photo"]["tmp_name"][$i], "$folder_corr/$filename");

            $p = $db_con->prepare("
                        INSERT INTO inspection_s2w_correction_photo 
                        (s2w_ir_id, s2w_sr_id, s2w_id, s2w_rp_id, correction_photo, created_by, created_date)
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
                    ");
            $p->bind_param("iiiiss", $ir_id, $sr_id, $s2w_id, $rp_id, $filename, $session_id);
            $p->execute();
        }
    }

    // UPLOAD PREVENTIVE PHOTOS
    if (!empty($_FILES["preventive_photo"]["name"][0])) {
        foreach ($_FILES["preventive_photo"]["name"] as $i => $name) {

            $filename = uniqid() . "_" . basename($name);
            move_uploaded_file($_FILES["preventive_photo"]["tmp_name"][$i], "$folder_prev/$filename");

            $p = $db_con->prepare("
                        INSERT INTO inspection_s2w_preventive_photo 
                        (s2w_ir_id, s2w_sr_id, s2w_id, s2w_rp_id, preventive_photo, created_by, created_date)
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
                    ");
            $p->bind_param("iiiiss", $ir_id, $sr_id, $s2w_id, $rp_id, $filename, $session_id);
            $p->execute();
        }
    }

    echo json_encode([
        "status" => "success",
        "insert_id" => $rp_id,
        "ir_id" => $ir_id,
        "sr_id" => $sr_id,
        "s2w_id" => $s2w_id,
        "s2w_rp_status" => $s_draft_id
    ]);
    exit;
}

// ==========================================================
// GET DETAILS
// ==========================================================
if ($_POST['action'] == 'get_s2w_details') {

    $s2w_id = intval($_POST['s2w_id']);

    // 1. Fetch Header
    $q = $db_con->prepare("
        SELECT 
            rp_id,
            rp_s2w_id,
            rp_s2w_ir_id,
            rp_s2w_sr_id,
            rp_s2w_docno,
            rp_s2w_cronology,
            rp_s2w_rootcause,
            rp_s2w_rootcause_area,
            rp_s2w_rootcause_place,
            rp_s2w_correction,
            rp_s2w_preventive,
            rp_s2w_conclusion,
            rp_s2w_status,
            created_by,
            created_date,
            updated_by,
            updated_date
        FROM inspection_s2w_report
        WHERE rp_s2w_id = ? AND rp_s2w_status != ?
        LIMIT 1
    ");
    $q->bind_param("ii", $s2w_id, $s_cancelled_id);
    $q->execute();
    $header = $q->get_result()->fetch_assoc();

    if (!$header) {
        echo json_encode([
            "status" => "success",
            "data" => [
                "rp_id" => 0,
                "rp_s2w_status" => 1,
                "correction_photo" => [],
                "preventive_photo" => []
            ]
        ]);
        exit;
    }

    // 2. Fetch Correction Photos
    $photos = [];
    $p = $db_con->prepare("
        SELECT correction_photoid, correction_photo
        FROM inspection_s2w_correction_photo
        WHERE s2w_rp_id = ?
        ORDER BY correction_photoid ASC
    ");
    $p->bind_param("i", $header['rp_id']);
    $p->execute();
    $r = $p->get_result();
    while ($row = $r->fetch_assoc()) {
        $photos[] = [
            "correction_photoid" => $row['correction_photoid'],
            "file" => $row['correction_photo']
        ];
    }

    // 3. Fetch Preventive Photos
    $photos_ok = [];
    $k = $db_con->prepare("
        SELECT preventive_photoid, preventive_photo
        FROM inspection_s2w_preventive_photo
        WHERE s2w_rp_id = ?
        ORDER BY preventive_photoid ASC
    ");
    $k->bind_param("i", $header['rp_id']);
    $k->execute();
    $m = $k->get_result();
    while ($row = $m->fetch_assoc()) {
        $photos_ok[] = [
            "preventive_photoid" => $row['preventive_photoid'],
            "file" => $row['preventive_photo']
        ];
    }

    // 4. Return JSON
    echo json_encode([
        "status" => "success",
        "data" => [
            "rp_id"   => $header['rp_id'],
            "rp_s2w_id"          => $header['rp_s2w_id'],
            "rp_s2w_ir_id"       => $header['rp_s2w_ir_id'],
            "rp_s2w_sr_id"       => $header['rp_s2w_sr_id'],
            "rp_s2w_docno"       => $header['rp_s2w_docno'],
            "rp_s2w_cronology"   => $header['rp_s2w_cronology'],
            "rp_s2w_rootcause"   => $header['rp_s2w_rootcause'],
            "rp_s2w_rootcause_area" => $header['rp_s2w_rootcause_area'],
            "rp_s2w_rootcause_place" => $header['rp_s2w_rootcause_place'],
            "rp_s2w_correction"  => $header['rp_s2w_correction'],
            "rp_s2w_preventive"  => $header['rp_s2w_preventive'],
            "rp_s2w_conclusion"  => $header['rp_s2w_conclusion'],
            "rp_s2w_status" => $header['rp_s2w_status'],
            "created_by" => $header['created_by'],
            "correction_photo"   => $photos,
            "preventive_photo"   => $photos_ok
        ]
    ]);
    exit;
}

// ==========================================================
// UPDATE
// ==========================================================
if ($_POST['action'] == 'update_s2w_report') {

    $rp_id  = intval($_POST['rp_id']);
    $ir_id  = intval($_POST['ir_id']);
    $sr_id  = intval($_POST['sr_id']);
    $s2w_id = intval($_POST['s2w_id']);

    $fd_cronology       = trim($_POST['fd_cronology']);
    $fd_rootcause       = trim($_POST['fd_rootcause']);
    $fd_rootcause_area  = trim($_POST['fd_rootcause_area']);
    $fd_rootcause_place = trim($_POST['fd_rootcause_place']);
    $fd_correction      = trim($_POST['fd_correction']);
    $fd_preventive      = trim($_POST['fd_preventive']);
    $fd_conclusion      = trim($_POST['fd_conclusion']);

    // UPDATE HEADER
    $stmt = $db_con->prepare("
                UPDATE inspection_s2w_report
                SET rp_s2w_cronology = ?, rp_s2w_rootcause = ?, rp_s2w_rootcause_area = ?, 
                    rp_s2w_rootcause_place = ?, rp_s2w_correction = ?, rp_s2w_preventive = ?, 
                    rp_s2w_conclusion = ?, updated_by = ?, updated_date = NOW()
                WHERE rp_id = ?
            ");
    $stmt->bind_param(
        "ssssssssi",
        $fd_cronology, $fd_rootcause, $fd_rootcause_area,
        $fd_rootcause_place, $fd_correction, $fd_preventive,
        $fd_conclusion, $session_id, $rp_id
    );
    $stmt->execute();

    // FOLDERS
    $folder_corr = __DIR__ . "/gallery/inspection_s2w_report/photo_correction/$rp_id";
    $folder_prev = __DIR__ . "/gallery/inspection_s2w_report/photo_preventive/$rp_id";

    if (!is_dir($folder_corr)) mkdir($folder_corr, 0777, true);
    if (!is_dir($folder_prev)) mkdir($folder_prev, 0777, true);

    // ADD NEW CORRECTION PHOTOS
    if (!empty($_FILES['correction_photo']['name'][0])) {
        foreach ($_FILES['correction_photo']['name'] as $i => $nm) {

            $filename = uniqid() . "_" . basename($nm);
            move_uploaded_file($_FILES['correction_photo']['tmp_name'][$i], "$folder_corr/$filename");

            $p = $db_con->prepare("
                        INSERT INTO inspection_s2w_correction_photo 
                        (s2w_ir_id, s2w_sr_id, s2w_id, s2w_rp_id, correction_photo, created_by, created_date)
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
                    ");
            $p->bind_param("iiiiss", $ir_id, $sr_id, $s2w_id, $rp_id, $filename, $session_id);
            $p->execute();
        }
    }

    // ADD NEW PREVENTIVE PHOTOS
    if (!empty($_FILES['preventive_photo']['name'][0])) {
        foreach ($_FILES['preventive_photo']['name'] as $i => $nm) {

            $filename = uniqid() . "_" . basename($nm);
            move_uploaded_file($_FILES['preventive_photo']['tmp_name'][$i], "$folder_prev/$filename");

            $p = $db_con->prepare("
                        INSERT INTO inspection_s2w_preventive_photo 
                        (s2w_ir_id, s2w_sr_id, s2w_id, s2w_rp_id, preventive_photo, created_by, created_date)
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
                    ");
            $p->bind_param("iiiiss", $ir_id, $sr_id, $s2w_id, $rp_id, $filename, $session_id);
            $p->execute();
        }
    }

    echo json_encode([
        "status" => "success",
        "rp_id"  => $rp_id
    ]);
    exit;
}

// ==========================================================
// SUBMIT
// ==========================================================
if ($_POST['action'] == 'submit_s2w_report') {

    $rp_id  = intval($_POST['rp_id']);
    $ir_id  = intval($_POST['ir_id']);
    $sr_id  = intval($_POST['sr_id']);
    $s2w_id = intval($_POST['s2w_id']);
    $s2w_docno = intval($_POST['s2w_docno']);
    $rp_status = intval($_POST['s2w_rp_status']);

    $fd_cronology       = trim($_POST['fd_cronology']);
    $fd_rootcause       = trim($_POST['fd_rootcause']);
    $fd_rootcause_area  = trim($_POST['fd_rootcause_area']);
    $fd_rootcause_place = trim($_POST['fd_rootcause_place']);
    $fd_correction      = trim($_POST['fd_correction']);
    $fd_preventive      = trim($_POST['fd_preventive']);
    $fd_conclusion      = trim($_POST['fd_conclusion']);

    //if draft create new docno, no need for returned
    if($rp_status  ==  $s_draft_id)
    {
        // -------------------------
        // 1. CREATE DOCUMENT NO
        // -------------------------
        // $transid = 7; 
        // $transmodule = "S2W_rp";   // Or from your code
        // $transprocess = "New";                // Or "Cancel", etc.
        // $current_shift = $current_shift;      // E.g. 'D', 'N' from your shift logic
        // $shift_date = $shift_date;  // E.g. '2024-08-06'

        // $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

        // //generate doc no
        // //comp,code,date,running no
        // $s2w_rp_docno = $session_comp . $s2w_rp_code . $doc_date . $running_no;

        // Update Appraisor
        $sql = "
                SELECT P.appraisor, E.staff_name, E.staff_email
                FROM employee_approval P
                LEFT JOIN employee_details E ON E.staff_id = P.appraisor
                WHERE P.staff_id = ?
                LIMIT 1
            ";

        $stmt = $db_con->prepare($sql);
        $stmt->bind_param("s", $session_id);
        $stmt->execute();

        $appraisor = $stmt->get_result()->fetch_assoc();

        $appraisor_id    = $appraisor['appraisor'];

        // -------------------------
        // 2. UPDATE TEXT FIELDS
        // -------------------------
        $stmt = $db_con->prepare("
                    UPDATE inspection_s2w_report
                    SET 
                        rp_s2w_docno           = ?,
                        rp_s2w_cronology       = ?,
                        rp_s2w_rootcause       = ?,
                        rp_s2w_rootcause_area  = ?,
                        rp_s2w_rootcause_place = ?,
                        rp_s2w_correction      = ?,
                        rp_s2w_preventive      = ?,
                        rp_s2w_conclusion      = ?,
                        rp_s2w_status          = ?,
                        rp_approver            = ?,     
                        submitted_by           = ?,
                        submitted_date         = NOW()
                    WHERE rp_id = ?
                ");

        $stmt->bind_param(
                    "ssssssssissi",
                    $s2w_docno, $fd_cronology, $fd_rootcause, $fd_rootcause_area, $fd_rootcause_place,
                    $fd_correction, $fd_preventive, $fd_conclusion,
                    $s_pendApproval_id, $appraisor_id,       
                    $session_id,                
                    $rp_id
                );
        $stmt->execute();
    
    }else { //for return S2W and resubmit - no need new document no
        
         $stmt = $db_con->prepare("
                    UPDATE inspection_s2w_report
                    SET 
                        rp_s2w_cronology       = ?,
                        rp_s2w_rootcause       = ?,
                        rp_s2w_rootcause_area  = ?,
                        rp_s2w_rootcause_place = ?,
                        rp_s2w_correction      = ?,
                        rp_s2w_preventive      = ?,
                        rp_s2w_conclusion      = ?,
                        rp_s2w_status          = ?,     
                        submitted_by           = ?,
                        submitted_date         = NOW()
                    WHERE rp_id = ?
                ");

        $stmt->bind_param(
                    "sssssssiii",
                    $fd_cronology, $fd_rootcause, $fd_rootcause_area, $fd_rootcause_place,
                    $fd_correction, $fd_preventive, $fd_conclusion,
                    $s_pendApproval_id,         
                    $session_id,                
                    $rp_id
                );
        $stmt->execute();

    }

    // -------------------------
    // 3 PREPARE FOLDERS
    // -------------------------
    $folder_corr = __DIR__ . "/gallery/inspection_s2w_report/photo_correction/$rp_id";
    $folder_prev = __DIR__ . "/gallery/inspection_s2w_report/photo_preventive/$rp_id";

    if (!is_dir($folder_corr)) mkdir($folder_corr, 0777, true);
    if (!is_dir($folder_prev)) mkdir($folder_prev, 0777, true);

    // ---------------------------------------------------------
    // 4. UPLOAD NEW CORRECTION PHOTOS  (existing photos keep)
    // ---------------------------------------------------------
    if (!empty($_FILES["correction_photo"]["name"][0])) {
        foreach ($_FILES["correction_photo"]["name"] as $i => $name) {

            $filename = uniqid() . "_" . basename($name);
            move_uploaded_file($_FILES["correction_photo"]["tmp_name"][$i], "$folder_corr/$filename");

            $p = $db_con->prepare("
                        INSERT INTO inspection_s2w_correction_photo 
                        (s2w_ir_id, s2w_sr_id, s2w_id, s2w_rp_id, correction_photo, created_by, created_date)
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
                    ");
            $p->bind_param("iiiiss", $ir_id, $sr_id, $s2w_id, $rp_id, $filename, $session_id);
            $p->execute();
        }
    }

    // ---------------------------------------------------------
    // 5. UPLOAD NEW PREVENTIVE PHOTOS (existing keep)
    // ---------------------------------------------------------
    if (!empty($_FILES["preventive_photo"]["name"][0])) {
        foreach ($_FILES["preventive_photo"]["name"] as $i => $name) {

            $filename = uniqid() . "_" . basename($name);
            move_uploaded_file($_FILES["preventive_photo"]["tmp_name"][$i], "$folder_prev/$filename");

            $p = $db_con->prepare("
                        INSERT INTO inspection_s2w_preventive_photo 
                        (s2w_ir_id, s2w_sr_id, s2w_id, s2w_rp_id, preventive_photo, created_by, created_date)
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
                    ");
            $p->bind_param("iiiiss", $ir_id, $sr_id, $s2w_id, $rp_id, $filename, $session_id);
            $p->execute();
        }
    }

    // -------------------------
    // 6. UPDATE PARENT STATUSES
    // -------------------------
    $db_con->query("UPDATE inspection_records SET ir_s2w_rp_status = $s_pendApproval_id WHERE ir_id = $ir_id");
    $db_con->query("UPDATE inspection_sorting SET sr_s2w_rp_status = $s_pendApproval_id WHERE sr_id = $sr_id");
    $db_con->query("UPDATE inspection_s2w SET s2w_rp_status = $s_pendApproval_id WHERE s2w_id = $s2w_id");

    // -------------------------
    // 7. HOD TO SEND EMAIL
    // -------------------------
    $recipients = [];

    //3. Select users with a specific role
    $sql = "SELECT E.staff_name, E.staff_email
                FROM employee_approval P
                    LEFT JOIN employee_details E ON E.staff_id = P.appraisor
                        WHERE P.staff_id = '$session_id' ";
    $result = $db_con->query($sql);
    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row;
    }

    // -------------------------
    // 8. FETCH DETAILS
    // -------------------------
    $stmt4 = $db_con->prepare("SELECT S.rp_id, S.rp_s2w_docno, R.ir_id, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_s2w_report S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.rp_s2w_ir_id
                                            LEFT JOIN material_header M ON R.ir_material = M.matid
                                                WHERE S.rp_id = ?");
    $stmt4->bind_param('i', $rp_id);
    $stmt4->execute();
    $inspectiondet = $stmt4->get_result()->fetch_assoc();

    // -------------------------
    // 8. ACTIVITY COMMENT
    // -------------------------
    $appsection = 'PDI';
    $apptask = 'S2W_report';
    $comment_status = "submit the Something When Wrong (S2W) Report";

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

    // -------------------------
    // 9. SUBMITTER DETAIL
    // -------------------------
    $submitter_name  = $stf_name;
    $doc_no = $inspectiondet['rp_s2w_docno'];
    $inspectdate = date('d-m-Y', strtotime($inspectiondet['inspect_date']));
    $shiftdet = $inspectiondet['ir_shift'] == 'D' ? 'Day' : 'Night';

    // -------------------------
    // 10. SEND EMAIL
    // -------------------------
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
        $mail->Body .= "<p>A new Something When Wrong (S2W) Report (<strong>Doc No: $doc_no </strong>) has been submitted by $submitter_name and requires your approval. </p>";
        $mail->Body .= "<p>Please log in to the system and approve the submission at your earliest convenience.<br>";
        $mail->Body .= "<a href={$system_url}> {$system_url}</a></p>";

        $mail->Body .= "
                        <h4 style='color:#cc0000;'>Something When Wrong (S2W) Details</h4>
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

    // -------------------------
    // 7. SEND RESPONSE
    // -------------------------
    echo json_encode([
        "status" => "success",
        "message" => "S2W Reply submitted successfully.",
        "rp_id" => $rp_id,
        'emails_sent' => $success_count,
        'emails_failed' => $fail_count,
        'failed_list' => $fail_emails
    ]);
    exit;
}

// ==========================================================
// DELETE PHOTO
// ==========================================================
if ($_POST['action'] == 'delete_correction_photo') {

    $photo_id = intval($_POST['id']);
    $rp_id    = intval($_POST['rp_id']);

    // Step 1: Get filename
    $stmt = $db_con->prepare("
                SELECT correction_photo 
                FROM inspection_s2w_correction_photo 
                WHERE correction_photoid = ?
            ");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $filename = $result['correction_photo'];
        $filePath = __DIR__ . "/gallery/inspection_s2w_report/photo_correction/$rp_id/$filename";

        // Step 2: Delete file if exists
        if (file_exists($filePath)) unlink($filePath);

        // Step 3: Delete DB record
        $del = $db_con->prepare("
                    DELETE FROM inspection_s2w_correction_photo 
                    WHERE correction_photoid = ?
                ");
        $del->bind_param("i", $photo_id);
        $del->execute();
    }

    echo json_encode(["status" => "success"]);
    exit;
}

if ($_POST['action'] == 'delete_preventive_photo') {

    $photo_id = intval($_POST['id']);
    $rp_id    = intval($_POST['rp_id']);

    // Step 1: Get filename
    $stmt = $db_con->prepare("
                SELECT preventive_photo 
                FROM inspection_s2w_preventive_photo 
                WHERE preventive_photoid = ?
            ");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $filename = $result['preventive_photo'];
        $filePath = __DIR__ . "/gallery/inspection_s2w_report/photo_preventive/$rp_id/$filename";

        // Step 2: Delete file if exists
        if (file_exists($filePath)) unlink($filePath);

        // Step 3: Delete DB record
        $del = $db_con->prepare("
                    DELETE FROM inspection_s2w_preventive_photo
                    WHERE preventive_photoid = ?
                ");
        $del->bind_param("i", $photo_id);
        $del->execute();
    }

    echo json_encode(["status" => "success"]);
    exit;
}

// ==========================================================
// CANCEL SORTING RECORD
// ========================== ================================
if ($_POST['action'] == 'cancel_record') {

    $ir_id  = intval($_POST['ir_id'] ?? 0);
    $sr_id  = intval($_POST['sr_id'] ?? 0);
    $s2w_id  = intval($_POST['s2w_id'] ?? 0);
    $rp_id  = intval($_POST['rp_id'] ?? 0);
    $remark = trim($_POST['remark'] ?? '');
    $transid = 8; 

    //generate doc no
    //comp,code,date,running no
    $docno_cancel = $session_comp . $s2w_rp_cancelcode . $doc_date . $s2w_rp_cancelcode_max;

    // 1. Set current record to Cancelled (status = 8)
    $stmt = $db_con->prepare("UPDATE inspection_s2w_report SET rp_s2w_docnocancel = ?, rp_s2w_status = ? ,
                                cancel_remark = ?, cancelled_by = ?, cancelled_date = NOW() WHERE rp_id = ?");
    $stmt->bind_param('sissi', $docno_cancel, $s_cancelled_id, $remark, $session_id, $rp_id);
    $stmt->execute();

    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_rp_status = ? WHERE sr_id = ?");
    $stmt2->bind_param('ii', $s_new_id, $sr_id);
    $stmt2->execute();

    // 21. Update s2w status to New (status = 1) in table inspection
    $stmt2_1 = $db_con->prepare("UPDATE inspection_records SET ir_s2w_rp_status = ? WHERE ir_id = ?");
    $stmt2_1->bind_param('ii', $s_new_id, $ir_id);
    $stmt2_1->execute();

    // 22. Update s2w status to New (status = 1) in table inspection
    $stmt2_2 = $db_con->prepare("UPDATE inspection_s2w SET s2w_rp_status = ? WHERE s2w_id = ?");
    $stmt2_2->bind_param('ii', $s_new_id, $s2w_id);
    $stmt2_2->execute();

    // -------------------------
    // 1.1 UPDATE INCREMENT BY 1
    // -------------------------
    // $stmt3 = $db_con->prepare("UPDATE transaction_type 
    //                             SET maximum_no = maximum_no + 1, last_shift = '$current_shift' , last_date = '$shift_date' 
    //                             WHERE transid = ?");
    // $stmt3->bind_param('i', $transid);
    // $stmt3->execute();

    // 4. Fetch s2w details
    $stmt4 = $db_con->prepare("SELECT S.rp_id, S.rp_s2w_docno, R.ir_id, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_s2w_report S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.rp_s2w_ir_id
                                            LEFT JOIN material_header M ON R.ir_material = M.matid
                                                WHERE S.rp_id = ?");
    $stmt4->bind_param('i', $rp_id);
    $stmt4->execute();
    $inspectiondet = $stmt4->get_result()->fetch_assoc();

    // 5. activity comment
    $appsection = 'PDI';
    $apptask = 'S2W_report';
    $comment_status = "cancel Something When Wrong (S2W) report submission";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_cancelled_id, $docno_cancel, $inspectiondet['ir_shift'], $inspectiondet['inspect_date'], $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    echo json_encode(['success' => true]);
    exit;
}

?>