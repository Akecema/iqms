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
if($_POST['action'] == 'fetch_records_list_all')
{
    $columns = array('I.sr_docno', 'M.matno', 'P.modcode', 'I.inspect_date', 'H.shiftdesc',  'I.ir_status');

    $query = "SELECT S.rp_id, S.rp_s2w_id, S.rp_s2w_ir_id, S.rp_s2w_sr_id, S.rp_s2w_docno, S.rp_s2w_status, S.created_by,
                     I.ir_id, I.ir_docno, I.ir_model, I.ir_type, I.ir_material, I.ir_pallet_no, I.ir_result, I.ir_status, 
                     I.inspect_date, I.shift_date, I.inspect_group, I.ir_shift, I.created_date, I.shift_date,
                     T.modcode, P.typemodel, M.partside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc, H.shiftbadge
              FROM inspection_s2w_report S  
              LEFT JOIN inspection_records AS I ON S.rp_s2w_ir_id = I.ir_id
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              LEFT JOIN system_status AS U ON S.rp_s2w_status = U.statusid
              WHERE I.shift_date < '$shift_date' ";

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
        $query .= " AND I.rp_s2w_status = '$status' ";
    }

    if (!empty($_POST['fd_daterange'])) {
        $daterange = $_POST['fd_daterange'];
        $dates = explode(' - ', $daterange);
        if (count($dates) == 2) {
            $start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
            $end_date = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
            $query .= " AND DATE(I.inspect_date) BETWEEN '$start_date' AND '$end_date' ";
        }
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);
       
         $query .= " AND (
                        S.rp_s2w_docno LIKE '%$search%' 
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
        $rpid = $row['rp_id'];

        // Status badge
        $statusBadge = '';

        $queryBadge = "SELECT 
                            r.*,
                            s.statusname,
                            s.badge,
                            s.badge_color,
                            s.text_color,
                            s.icon_class
                        FROM inspection_s2w_report r
                        LEFT JOIN system_status s 
                        ON s.statusid = r.rp_s2w_status
                        WHERE r.rp_id = '$rpid' ";        

        $resultBadge = mysqli_query($db_con, $queryBadge);
        $rowABadge = mysqli_fetch_assoc($resultBadge);

        if (!empty($rowABadge['statusname']) && ($row['rp_s2w_status'] != 1)) {

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

        // Get delay days (for section = PDI, you can adjust if section dynamic)
        $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' AND task = 'S2W_SC' AND process = 'create'";
        $resDelay = mysqli_query($db_con, $delay_sql);
        $rowDelay = mysqli_fetch_assoc($resDelay);
        $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

        $today = new DateTime();
        $allowedDate = (clone $today)->modify("-{$delay_day} days");
        $prodDate = new DateTime($row['shift_date']);  // assuming shift_date exists in $row

        $isAllowed = $prodDate >= $allowedDate;

        //encrypt url
        $enc_rpid = urlencode(encryptData($rpid));
        $enc_status = urlencode(encryptData($row['rp_s2w_status']));
        
        // Action buttons
        $btnAction = ''; // default empty

        if($isAllowed)
        {
            if (in_array($row['rp_s2w_status'], [12, 13, 16])) {
                // EDIT button
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="Edit S2W Report" 
                                data-encrpid="'.$enc_rpid.'" 
                                data-irid="'.$row['ir_id'].'" 
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'"
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-edit"></i>
                            </button>';
            }
            elseif (in_array($row['rp_s2w_status'], [4, 5, 8])) {
                // VIEW button
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="View S2W Report" 
                                data-encrpid="'.$enc_rpid.'" 
                                data-irid="'.$row['ir_id'].'"
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'"
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-list"></i>
                            </button>';
            }
            elseif (in_array($row['rp_s2w_status'], [10])) { //pending review,pending approval
                // CANCEL button           
                $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageAction ms-1"
                                data-bs-toggle="tooltip" title="Cancel S2W" 
                                data-encrpid="'.$enc_rpid.'" 
                                data-irid="'.$row['ir_id'].'" 
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'" 
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-times"></i>
                            </button>';
            }

        }
        else
        {
             $btnAction = '<button class="btn btn-rounded btn-black btn-xxs pageActionView ms-1" 
                                data-bs-toggle="tooltip" title="View S2W"
                                data-encrpid="'.$enc_rpid.'" 
                                data-irid="'.$row["ir_id"].'"
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'" 
                                data-status="'.$row["rp_s2w_status"].'" data-encstatus="'.$enc_status.'" 
                                data-model="'.$row['ir_model'].'" data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                                <i class="fa fa-bars"></i></i>
                            </button>';
        }

        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));

        $display_docno = '';

        // If status in 4,7,10,12,13 → get sr_docno from inspection_sorting
        $q_sr = $db_con->prepare("SELECT rp_s2w_docno, rp_s2w_status FROM inspection_s2w_report WHERE rp_s2w_id = ?");
        $q_sr->bind_param("i", $s2wid);
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
        
        $sub_array = [];
     
        $sub_array[] = '<span class="fs-14">'.$row["rp_s2w_docno"].'</span></a>';
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

// ==========================================================
// GET DETAILS
// ==========================================================
if ($_POST['action'] == 'get_s2w_details') {

    $rp_id = intval($_POST['rp_id']);

    // ---------------------------------------------
    // 1. FETCH MAIN S2W HEADER
    // ---------------------------------------------
    $q = $db_con->prepare("
        SELECT 
            s2w.rp_id,
            s2w.rp_s2w_id,
            s2w.rp_s2w_ir_id,
            s2w.rp_s2w_sr_id,
            s2w.rp_s2w_docno,
            s2w.rp_s2w_cronology,
            s2w.rp_s2w_rootcause,
            s2w.rp_s2w_rootcause_area,
            s2w.rp_s2w_rootcause_place,
            s2w.rp_s2w_correction,
            s2w.rp_s2w_preventive,
            s2w.rp_s2w_conclusion,
            s2w.rp_s2w_status,
            s2w.created_by,
            s2w.created_date,
            s2w.updated_by,
            s2w.updated_date,
            t.statusname
        FROM inspection_s2w_report s2w
        LEFT JOIN system_status t ON s2w.rp_s2w_status = t.statusid 
        WHERE s2w.rp_id = ?
    ");
    $q->bind_param("i", $rp_id);
    $q->execute();
    $header = $q->get_result()->fetch_assoc();

    if (!$header) {
        echo json_encode([
            "status" => "success",
            "data" => [
                "rp_id" => $rp_id,
                "s2w_id" => $header['rp_s2w_id'],
                "s2w_ir_id" => $header['rp_s2w_ir_id'],
                "s2w_sr_id" => $header['rp_s2w_sr_id'],
                "rp_s2w_cronology"   => $header['rp_s2w_cronology'],
                "rp_s2w_rootcause"   => $header['rp_s2w_rootcause'],
                "rp_s2w_rootcause_area" => $header['rp_s2w_rootcause_area'],
                "rp_s2w_rootcause_place" => $header['rp_s2w_rootcause_place'],
                "rp_s2w_correction"  => $header['rp_s2w_correction'],
                "rp_s2w_preventive"  => $header['rp_s2w_preventive'],
                "rp_s2w_conclusion"  => $header['rp_s2w_conclusion'],
                "s2w_status" => $header['rp_s2w_status'],
                "photo_correction" => [],
                "photo_preventive" => []
            ]
        ]);
        exit;
    }

    // ---------------------------------------------
    // 2. FETCH PHOTOS
    // ---------------------------------------------
    $photos = [];

    $p = $db_con->prepare("
        SELECT 
            correction_photoid, 
            correction_photo
        FROM inspection_s2w_correction_photo
        WHERE s2w_rp_id = ?
        ORDER BY correction_photoid ASC
    ");
    $p->bind_param("i", $rp_id);
    $p->execute();
    $r = $p->get_result();

    while ($row = $r->fetch_assoc()) {
        $photos_correction[] = [
            "correction_photoid" => $row['correction_photoid'],
            "rp_id" => $rp_id,
            "file" => $row['correction_photo']
        ];
    }

    $k = $db_con->prepare("
        SELECT 
            preventive_photoid, 
            preventive_photo
        FROM inspection_s2w_preventive_photo
        WHERE s2w_rp_id = ?
        ORDER BY preventive_photoid ASC
    ");
    $k->bind_param("i", $rp_id);
    $k->execute();
    $m = $k->get_result();

    while ($row = $m->fetch_assoc()) {
        $photos_preventive[] = [
            "preventive_photoid" => $row['preventive_photoid'],
            "rp_id" => $rp_id,
            "file" => $row['preventive_photo']
        ];
    }

    // ---------------------------------------------
    // 3. BUILD FINAL CLEAN STRUCTURE
    // ---------------------------------------------
    echo json_encode([
        "status" => "success",
        "data" => [
            "rp_ir_id" => $header['rp_s2w_ir_id'],
            "rp_sr_id" => $header['rp_s2w_sr_id'],
            "rp_s2w_id" => $header['rp_s2w_id'],
            "rp_id" => $rp_id,            
            "rp_s2w_docno" => $header['rp_s2w_docno'],            
            "rp_s2w_cronology"   => $header['rp_s2w_cronology'],
            "rp_s2w_rootcause"   => $header['rp_s2w_rootcause'],
            "rp_s2w_rootcause_area" => $header['rp_s2w_rootcause_area'],
            "rp_s2w_rootcause_place" => $header['rp_s2w_rootcause_place'],
            "rp_s2w_correction"  => $header['rp_s2w_correction'],
            "rp_s2w_preventive"  => $header['rp_s2w_preventive'],
            "rp_s2w_conclusion"  => $header['rp_s2w_conclusion'],
            "rp_s2w_status" => $header['rp_s2w_status'], 
            "sr_statusname" => $header['statusname'],
            "photo_correction" => $photos_correction,
            "photo_preventive" => $photos_preventive
        ]
    ]);
    exit;
}

// ==========================================================
// UPDATE
// ==========================================================
if ($_POST['action'] == 'update_s2w') {

    $ir_id = intval($_POST['ir_id']);
    $sr_id = intval($_POST['sr_id']);
    $s2w_id = intval($_POST['s2w_id']);
    $rp_id = intval($_POST['rp_id']);
    
    $fd_cronology       = trim($_POST['fd_cronology']);
    $fd_rootcause       = trim($_POST['fd_rootcause']);
    $fd_rootcause_area  = trim($_POST['fd_rootcause_area']);
    $fd_rootcause_place = trim($_POST['fd_rootcause_place']);
    $fd_correction      = trim($_POST['fd_correction']);
    $fd_preventive      = trim($_POST['fd_preventive']);
    $fd_conclusion      = trim($_POST['fd_conclusion']);

    // Update main
    $stmt = $db_con->prepare("
        UPDATE inspection_s2w_report
        SET 
        rp_s2w_cronology = ?, 
        rp_s2w_rootcause = ?, 
        rp_s2w_rootcause_area = ?, 
        rp_s2w_rootcause_place = ?, 
        rp_s2w_correction = ?, 
        rp_s2w_preventive = ?, 
        rp_s2w_conclusion = ?, 
        updated_by = ?, 
        updated_date = NOW() 
        WHERE rp_id = ?
    ");
    $stmt->bind_param("ssssssssi", $fd_cronology, $fd_rootcause, $fd_rootcause_area,
                        $fd_rootcause_place, $fd_correction, $fd_preventive,
                        $fd_conclusion, $session_id, $rp_id );
    $stmt->execute();

    // Folder
    $folder_correction = __DIR__ . "/gallery/inspection_s2w_report/photo_correction/" . $rp_id;
    if (!is_dir($folder_correction)) mkdir($folder_correction, 0777, true);

    // Upload NEW photos only
    if (!empty($_FILES['correction_photo']['name'][0])) {
        foreach ($_FILES['correction_photo']['tmp_name'] as $i => $tmp) {

            $original = basename($_FILES['correction_photo']['name'][$i]);
            $filename = uniqid() . "_" . $original;

            move_uploaded_file($tmp, "$folder_correction/$filename");

            $p = $db_con->prepare("
                        INSERT INTO inspection_s2w_correction_photo 
                        (s2w_ir_id, s2w_sr_id, s2w_id, s2w_rp_id, correction_photo, created_by, created_date)
                        VALUES (?, ?, ?, ?, ?, ?, NOW())
            ");
            $p->bind_param("iiiiss", $ir_id, $sr_id, $s2w_id, $rp_id, $filename, $session_id);
            $p->execute();
        }
    }

    // Folder
    $folder_preventive = __DIR__ . "/gallery/inspection_s2w_report/photo_preventive/" . $rp_id;
    if (!is_dir($folder_preventive)) mkdir($folder_preventive, 0777, true);

    // Upload NEW photos only
    if (!empty($_FILES['preventive_photo']['name'][0])) {
        foreach ($_FILES['preventive_photo']['tmp_name'] as $i => $tmp) {

            $original = basename($_FILES['preventive_photo']['name'][$i]);
            $filename = uniqid() . "_" . $original;

            move_uploaded_file($tmp, "$folder_preventive/$filename");

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
        "message" => "Updated"
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
        $transid = 7; 
        $transmodule = "S2W_rp";   // Or from your code
        $transprocess = "New";                // Or "Cancel", etc.
        $current_shift = $current_shift;      // E.g. 'D', 'N' from your shift logic
        $shift_date = $shift_date;  // E.g. '2024-08-06'

        $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

        //generate doc no
        //comp,code,date,running no
        $s2w_rp_docno = $session_comp . $s2w_rp_code . $doc_date . $running_no;

        // -------------------------
        // 1.1 UPDATE INCREMENT BY 1
        // -------------------------
        // $stmt = $db_con->prepare("UPDATE transaction_type 
        //                             SET maximum_no = maximum_no + 1, last_shift = '$current_shift' , last_date = '$shift_date' 
        //                             WHERE transid = ?");
        // $stmt->bind_param('i', $transid);
        // $stmt->execute();

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
                    $s2w_rp_docno, $fd_cronology, $fd_rootcause, $fd_rootcause_area, $fd_rootcause_place,
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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_pendReview_id, $s2w_rp_docno, $inspectiondet['ir_shift'], $inspectiondet['inspect_date'], $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
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
        "message" => "S2W report submitted successfully.",
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

    $id = intval($_POST['id']);
    $rp_id = intval($_POST['rp_id']);

    $q = $db_con->prepare("SELECT correction_photo FROM inspection_s2w_correction_photo WHERE correction_photoid = ?");
    $q->bind_param("i", $id);
    $q->execute();
    $res = $q->get_result()->fetch_assoc();

    if ($res) {
        $file = __DIR__ . "/gallery/inspection_s2w_report/photo_correction/$rp_id/" . $res['correction_photo'];
        if (file_exists($file)) unlink($file);
    }

    $db_con->query("DELETE FROM inspection_s2w_correction_photo WHERE correction_photoid = $id");

    echo json_encode(["status" => "success"]);
    exit;
}

if ($_POST['action'] == 'delete_preventive_photo') {

    $id = intval($_POST['id']);
    $rp_id = intval($_POST['rp_id']);

    $q = $db_con->prepare("SELECT preventive_photo FROM inspection_s2w_preventive_photo WHERE preventive_photoid = ?");
    $q->bind_param("i", $id);
    $q->execute();
    $res = $q->get_result()->fetch_assoc();

    if ($res) {
        $file = __DIR__ . "/gallery/inspection_s2w_report/photo_preventive/$rp_id/" . $res['preventive_photo'];
        if (file_exists($file)) unlink($file);
    }

    $db_con->query("DELETE FROM inspection_s2w_preventive_photo WHERE preventive_photoid = $id");

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