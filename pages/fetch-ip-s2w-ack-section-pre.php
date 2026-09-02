<?php

ob_start();
error_reporting(0);

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$today = date('Y-m-d');
$pst_datenow = date('Y-m-d H:i:s');	

// All records
if($_POST['action'] == 'fetch_records')
{
    // Filters
    $model_id = $_POST['model'] ?? '';
    $type_id = $_POST['type'] ?? '';
    $material_id = $_POST['material'] ?? '';

    $columns = array('I.rp_s2w_docno', 'M.matno', 'I.shift_date', 'I.ir_shifts');

    $query = "SELECT S.rp_id, S.rp_s2w_ir_id, S.rp_s2w_sr_id, S.rp_s2w_id, S.rp_s2w_docno, S.rp_s2w_status,
                I.ir_id, I.ir_pallet_no, I.inspect_date, I.ir_shift, I.shift_date,
                T.modcode, P.typemodel, M.partside, 
                M.matno, M.matdesc, H.shiftdesc, H.shiftbadge            
                FROM inspection_s2w_report AS S                
                LEFT JOIN inspection_records I ON S.rp_s2w_ir_id = I.ir_id
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE S.rp_s2w_status = 14 
                AND I.shift_date < '$shift_date'";
   
    // Apply filters
    if (!empty($_POST['model'])) {
        $query .= " AND I.ir_model = '$model_id'";
    }
    if (!empty($_POST['type'])) {
        $query .= " AND I.ir_type = '$type_id'";
    }
    if (!empty($_POST['material'])) {
        $query .= " AND I.ir_material = '$material_id'";
    }

    if(isset($_POST["search"]["value"]))
    {
        $search = $_POST["search"]["value"];
       
        // Original search logic
        $query .= " AND (
            S.rp_s2w_docno LIKE '%$search%' OR
            T.modcode LIKE '%$search%' OR 
            P.typemodel LIKE '%$search%' OR 
            M.partside LIKE '%$search%' OR 
            M.matno LIKE '%$search%' OR 
            M.matdesc LIKE '%$search%' 
        ) ";
       
    }
    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order']['0']['column'];
        $colDir = $_POST['order']['0']['dir'];

        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= 'ORDER BY S.approved_date DESC';
    }

    $query1 = '';

    if($_POST["length"] != -1)
    {
        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($db_con, $query));
    $result = mysqli_query($db_con, $query . $query1);

    $data = array();

    while($row = mysqli_fetch_array($result))
    {
        $rpid = $row['rp_id'];

        $badgeClass = '';
        $badgeShift = $row["shiftbadge"];

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
                    ' . ($iconClass ? '<i class="la ' . $iconClass . ' me-0"></i>' : '') . '
                    ' . htmlspecialchars($rowABadge['statusname']) . '
                </span>
            ';
        }

         // Get delay days (for section = PDI, you can adjust if section dynamic)
        $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' AND task = 'S2W_SC' AND process = 'acknowledge'";
        $resDelay = mysqli_query($db_con, $delay_sql);
        $rowDelay = mysqli_fetch_assoc($resDelay);
        $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

        $today = new DateTime();
        $minDate = (clone $today)->modify("-{$delay_day} days"); // earliest allowed
        $prodDate = new DateTime($row['shift_date']);  // from your row

        // Button enabled only if shift_date is within last X days (inclusive)
        $isAllowed = ($prodDate >= $minDate && $prodDate <= $today);
        $btnDisabled = $isAllowed ? "" : "disabled";
        $linkUrl = $isAllowed ? "viewDocDetails" : "viewDocDetails_pre";

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
   
        $sub_array = array();
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary '.$linkUrl.'" data-irid="'.$row['ir_id'].'" 
                                data-docno="'.htmlspecialchars($row['rp_s2w_docno']).'" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view details"><span class="fs-14">'.$row["rp_s2w_docno"].' </span>
                            </a>
                        </div>';
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold small-text">'.$row["matno"].'</h6>
                            <span class="fs-14">'.$row["matdesc"].'</span>
                        </div>
                        
                        <div class="clearfix ms-2 mt-1">
                            <h6 class="mb-0 fw-semibold small-text">'.$row["modcode"].'</h6>
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["partside"].')'.'</span>
                        </div>'; 
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$isnpectiondate.'</span></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span></div>';
        // $sub_array[] = '<div class="d-flex align-items-center gap-2">' .$statusBadge. '</div>';
        $sub_array[] = '<button class="btn btn-rounded btn-primary btn-xxs btnAcknowledge me-1" data-irid="'.$row['rp_s2w_ir_id'].'" data-srid="'.$row['rp_s2w_sr_id'].'" 
                            data-s2wid="'.$row['rp_s2w_id'].'" data-rpid="'.$row['rp_id'].'"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Acknowledge S2W Report" '.$btnDisabled.'>
                            <i class="fa fa-check"></i>
                        </a>
                        
                        <button class="btn btn-rounded btn-secondary btn-xxs btnReturn" data-irid="'.$row["rp_s2w_ir_id"].'" data-srid="'.$row['rp_s2w_sr_id'].'" 
                            data-s2wid="'.$row['rp_s2w_id'].'" data-rpid="'.$row['rp_id'].'"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Return S2W Report" '.$btnDisabled.'>
                            <i class="fa fa-undo"></i>
                        </button>';
        $data[] = $sub_array;
        
    }

    $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"  =>  $number_filter_row,
            "recordsFiltered" => $number_filter_row,
            "data"    => $data
    );

    echo json_encode($output);
}

// Sorting details
if ($_POST['action'] === 'fetch_details') {

    $docno = $_POST['docno'] ?? '';

    $stmt = $db_con->prepare("
                    SELECT 
                        s.rp_id, s.rp_s2w_id, s.rp_s2w_ir_id, s.rp_s2w_sr_id, s.rp_s2w_docno, 
                        s.rp_s2w_cronology, s.rp_s2w_rootcause, s.rp_s2w_rootcause_area, s.rp_s2w_rootcause_place,
                        s.rp_s2w_correction, s.rp_s2w_preventive, s.rp_s2w_conclusion, s.rp_s2w_status,
                        s.approved_remark, s.returned_remark, s.acknowledge_remark,
                        t.statusname,
                        (SELECT GROUP_CONCAT(correction_photo) FROM inspection_s2w_correction_photo WHERE s2w_rp_id = s.rp_id) AS correction_photos,
                        (SELECT GROUP_CONCAT(preventive_photo) FROM inspection_s2w_preventive_photo WHERE s2w_rp_id = s.rp_id) AS preventive_photos
                    FROM inspection_s2w_report s
                    LEFT JOIN system_status t ON s.rp_s2w_status = t.statusid
                    WHERE s.rp_s2w_docno = ?
                    LIMIT 1
                ");
    $stmt->bind_param('s', $docno);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    if ($data) {
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

//Approve s2w
if ($_POST['action'] == 'acknowledge_s2w') {

    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $s2w_id = $_POST['s2w_id'];
    $rp_id = $_POST['rp_id'];
    $remark = trim($_POST['approval_remark']);

    // 2. Decide status based on result
    $approved_remark = $remark;
    $approved_by = $session_id;
    $approved_date = $pst_datenow;
    $s2w_status =  $s_completed_id;

    // 3. Update sorting status in inspection record 
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_s2w_rp_status = ? WHERE ir_id = ?");
    $stmt->bind_param("ii", $s2w_status, $$ir_id);
    $success = $stmt->execute();

    // 3.1 Update sorting report
    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_rp_status = ?  WHERE sr_id = ?");
    $stmt2->bind_param("ii", $s2w_status, $sr_id);
    $success2 = $stmt2->execute();

    // 3.1 Update S2W
    $stmt3 = $db_con->prepare("UPDATE inspection_s2w SET s2w_rp_status = ? WHERE s2w_id = ?");
    $stmt3->bind_param("ii", $s2w_status,  $s2w_id);
    $success3 = $stmt3->execute();

    // 3.1 Update S2W report
    $stmt4 = $db_con->prepare("UPDATE inspection_s2w_report SET rp_s2w_status = ?, acknowledge_remark = ?, acknowledge_by = ?, acknowledge_date = ? WHERE rp_id = ?");
    $stmt4->bind_param("isssi", $s2w_status, $approved_remark, $approved_by, $approved_date, $rp_id);
    $success4 = $stmt4->execute();

    $db_con->commit();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT s.rp_s2w_docno, r.ir_shift, r.shift_date
                                FROM inspection_s2w_report s
                                    LEFT JOIN inspection_records r ON s.rp_s2w_ir_id = r.ir_id
                                        WHERE s.rp_id = ?");
    $stmt3->bind_param('i', $rp_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $s2w_docno = $inspectiondet['rp_s2w_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'S2W REPORT';
    $comment_status = "acknowledge the Something When Wrong (S2W) Report";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s2w_status, $s2w_docno, $sr_current_shift, $sr_production_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    // Force commit to ensure DB updates are visible immediately
    $db_con->commit();

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Something When Wrong (S2W) report has been acknowledge.' : 'Failed to acknowledge Something When Wrong (S2W) report.'
    ]);

    exit;
}

//Return s2w
if ($_POST['action'] == 'approve-return') {

    // approver returns → update status to 9
    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $s2w_id = $_POST['s2w_id'];
    $rp_id = $_POST['rp_id'];
    $remark = trim($_POST['approval_remark']);

    // 2. Decide status based on result
    $returned_remark = $remark;
    $returned_by = $session_id;
    $returned_date = $pst_datenow;
    $s2w_status = $s_returnAck_id;

    // 3. Update sorting status in inspection record 
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_s2w_rp_status = ? WHERE ir_id = ?");
    $stmt->bind_param("ii", $s2w_status, $ir_id);
    $success = $stmt->execute();

    // 3.1 Update sorting report
    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_rp_status = ? WHERE sr_id = ?");
    $stmt2->bind_param("ii", $s2w_status, $sr_id);
    $success2 = $stmt2->execute();

    // 3.1 Update sorting report
    $stmt3 = $db_con->prepare("UPDATE inspection_s2w SET s2w_rp_status = ? WHERE s2w_id = ?");
    $stmt3->bind_param("ii", $s2w_status, $s2w_id);
    $success3 = $stmt3->execute();
    $db_con->commit();
    
    // 3.1 Update S2W report
    $stmt4 = $db_con->prepare("UPDATE inspection_s2w_report SET rp_s2w_status = ?, acknowledge_return_remark = ?, acknowledge_return_by = ?, acknowledge_return_date = ? WHERE rp_id = ?");
    $stmt4->bind_param("isssi", $s2w_status, $returned_remark, $returned_by, $returned_date, $rp_id);
    $success4 = $stmt4->execute();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT s.rp_s2w_docno, r.ir_shift, r.shift_date
                                FROM inspection_s2w_report s
                                    LEFT JOIN inspection_records r ON s.rp_s2w_ir_id = r.ir_id
                                        WHERE s.rp_id = ?");
    $stmt3->bind_param('i', $rp_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $s2w_docno = $inspectiondet['rp_s2w_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'S2W REPORT';
    $comment_status = "returned the Something When Wrong (S2W) Report";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s2w_status, $s2w_docno, $sr_current_shift, $sr_production_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    // Force commit to ensure DB updates are visible immediately
    $db_con->commit();

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Something When Wrong (S2W) report has been returned.' : 'Failed to return Something When Wrong (S2W) report.'
    ]);

    exit;
}

// ---------- COMPLETED-------------//
//Approved
if ($_POST['action'] == 'fetch_records_completed') 
{
    // Filters
    $model_id = $_POST['model'] ?? '';
    $type_id = $_POST['type'] ?? '';
    $material_id = $_POST['material'] ?? '';

    $columns = array('I.rp_s2w_docno', 'M.matno', 'I.shift_date', 'I.ir_shift');

    $query = "SELECT S.rp_id, S.rp_s2w_ir_id, S.rp_s2w_sr_id, S.rp_s2w_id, S.rp_s2w_docno, S.rp_s2w_status,
                I.ir_id, I.ir_pallet_no, I.inspect_date, I.ir_shift, 
                T.modcode, P.typemodel, M.partside, 
                M.matno, M.matdesc, H.shiftdesc, H.shiftbadge            
                FROM inspection_s2w_report AS S                
                LEFT JOIN inspection_records I ON S.rp_s2w_ir_id = I.ir_id
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE S.rp_s2w_status = 5 
                AND I.shift_date < '$shift_date'";
   
    // Apply filters
    if (!empty($_POST['model'])) {
        $query .= " AND I.ir_model = '$model_id'";
    }
    if (!empty($_POST['type'])) {
        $query .= " AND I.ir_type = '$type_id'";
    }
    if (!empty($_POST['material'])) {
        $query .= " AND I.ir_material = '$material_id'";
    }

    if(isset($_POST["search"]["value"]))
    {
        $search = $_POST["search"]["value"];
       
        // Original search logic
        $query .= " AND (
            S.rp_s2w_docno LIKE '%$search%' OR
            T.modcode LIKE '%$search%' OR 
            P.typemodel LIKE '%$search%' OR 
            M.partside LIKE '%$search%' OR 
            M.matno LIKE '%$search%' OR 
            M.matdesc LIKE '%$search%' 
        ) ";
       
    }
    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order']['0']['column'];
        $colDir = $_POST['order']['0']['dir'];

        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= 'ORDER BY S.submitted_date DESC';
    }

    $query1 = '';

    if($_POST["length"] != -1)
    {
        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($db_con, $query));
    $result = mysqli_query($db_con, $query . $query1);

    $data = array();

    while($row = mysqli_fetch_array($result))
    {
        $rpid = $row["rp_id"];

        $badgeClass = '';
        $badgeShift = $row["shiftbadge"];

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
                    ' . ($iconClass ? '<i class="la ' . $iconClass . ' me-0"></i>' : '') . '
                    ' . htmlspecialchars($rowABadge['statusname']) . '
                </span>
            ';
        }

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
   
        $sub_array = array();
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" data-irid="'.$row['ir_id'].'" 
                                data-docno="'.htmlspecialchars($row['rp_s2w_docno']).'" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view details"><span class="fs-14">'.$row["rp_s2w_docno"].' </span>
                            </a>
                        </div>';
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold small-text">'.$row["matno"].'</h6>
                            <span class="fs-14">'.$row["matdesc"].'</span>
                        </div>
                        
                        <div class="clearfix ms-2 mt-1">
                            <h6 class="mb-0 fw-semibold small-text">'.$row["modcode"].'</h6>
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["partside"].')'.'</span>
                        </div>'; 
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$isnpectiondate.'</span></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span></div>';
        $sub_array[] = '<div class="d-flex align-items-center gap-2">' .$statusBadge. '</div>';
        $data[] = $sub_array;
        
    }

    $output = array(
            "draw"    => intval($_POST["draw"]),
            "recordsTotal"  =>  $number_filter_row,
            "recordsFiltered" => $number_filter_row,
            "data"    => $data
    );

    echo json_encode($output);
}

ob_end_flush();

?>
