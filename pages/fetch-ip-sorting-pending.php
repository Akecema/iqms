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

    $columns = array('I.sr_docno', 'M.matno', 'I.shift_date', 'I.ir_shift');

    $query = "SELECT S.sr_id, S.sr_ir_id, S.sr_docno, S.sr_status,
                I.ir_pallet_no, I.inspect_date, I.prod_date, I.ir_shift, 
                T.modcode, P.typemodel, M.partside, 
                M.matno, M.matdesc, H.shiftdesc, H.shiftbadge            
                FROM inspection_sorting AS S                
                LEFT JOIN inspection_records I ON S.sr_ir_id = I.ir_id
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE S.sr_status = '$s_pendReview_id' AND I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date'";
   
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
       
        // Check if search starts with #
        if (strpos($search, '#') === 0) {
            $palletNo = ltrim($search, '#');
            if (is_numeric($palletNo)) {
                $query .= " AND I.ir_pallet_no = " . intval($palletNo) . " ";
            }
        } else {
            // Original search logic
            $query .= " AND (
                S.sr_docno LIKE '%$search%' OR
                T.modcode LIKE '%$search%' OR 
                P.typemodel LIKE '%$search%' OR 
                M.partside LIKE '%$search%' OR 
                M.matno LIKE '%$search%' OR 
                M.matdesc LIKE '%$search%' OR
                H.shiftdesc LIKE '%$search%' OR
                I.ir_pallet_no LIKE '%$search%' OR
                I.ir_result LIKE '%$search%'
            ) ";
        }
    }


    if(isset($_POST["search"]["value"]))
    {
        $search = $_POST["search"]["value"];
       
        // Check if search starts with #
        if (strpos($search, '#') === 0) {
            $palletNo = ltrim($search, '#');
            if (is_numeric($palletNo)) {
                $query .= " AND I.ir_pallet_no = " . intval($palletNo) . " ";
            }
        } else {
            // Original search logic + date search
            // Convert search to Y-m-d format if it looks like a date (DD-MM-YYYY)
            $dateSearch = '';
            if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $search)) {
                // Convert DD-MM-YYYY to YYYY-MM-DD
                $dateParts = explode('-', $search);
                $dateSearch = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
            }
            
            $query .= " AND (
                S.sr_docno LIKE '%$search%' OR
                T.modcode LIKE '%$search%' OR 
                P.typemodel LIKE '%$search%' OR 
                M.partside LIKE '%$search%' OR 
                M.matno LIKE '%$search%' OR 
                M.matdesc LIKE '%$search%' OR
                I.ir_pallet_no LIKE '%$search%'";
            
            // Add date search if format matches
            if ($dateSearch) {
                $query .= " OR I.prod_date = '$dateSearch' OR I.inspect_date = '$dateSearch'";
            }
            
            $query .= " ) ";
        }
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
        $badgeClass = '';
        $badgeShift = $row["shiftbadge"];

        //Result
        if ($row["ir_result"] == 'OK') $badgeClass = 'badge badge-rounded badge-outline-hijo';
        elseif ($row["ir_result"] == 'NG') $badgeClass = 'badge badge-rounded badge-outline-meron';

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
        $productiondate = $row['prod_date'] && $row['prod_date'] != '0000-00-00' ? date('d-m-Y', strtotime($row['prod_date'])) : '-';
   
        $sub_array = array();
        
        $sub_array[] = '<input type="checkbox" class="row-check form-check-input" value="'.$row["sr_id"].'" data-result="'.$row['sr_result'].'">';
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" data-docno="'.htmlspecialchars($row['sr_docno']).'" 
                               data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view details"><span class="fs-14">'.$row["sr_docno"].' </span>
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
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$productiondate.'</span></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span></div>';
        $sub_array[] = '<button class="btn btn-rounded btn-primary btn-xxs btnApprove me-1" data-irid="'.$row['sr_ir_id'].'" data-srid="'.$row['sr_id'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="Approve">
                            <i class="fa fa-check"></i>
                        </button>
                        
                        <button class="btn btn-rounded btn-secondary btn-xxs btnReturn me-1" data-irid="'.$row["sr_ir_id"].'" data-srid="'.$row['sr_id'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                            <i class="fa fa-undo"></i>
                        </button>
                        
                        <button class="btn btn-rounded btn-meron btn-xxs btnClose" data-irid="'.$row["sr_ir_id"].'" data-srid="'.$row['sr_id'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="Close">
                            <i class="fa fa-times"></i>
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
                        s.sr_id, s.sr_docno, s.sr_qty_ok, s.sr_qty_ng,
                        s.sr_sorting_method, s.sr_rework_method, s.sr_remarks,
                        s.sr_status, s.approved_remark, s.returned_remark, t.statusname,
                        (SELECT GROUP_CONCAT(before_photo) FROM inspection_sorting_before_photo WHERE sr_sorting_id = s.sr_id) AS before_photos,
                        (SELECT GROUP_CONCAT(after_photo) FROM inspection_sorting_after_photo WHERE sr_sorting_id = s.sr_id) AS after_photos
                    FROM inspection_sorting s
                    LEFT JOIN system_status t ON s.sr_status = t.statusid
                    WHERE s.sr_docno = ?
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

//Approve inspection record
if ($_POST['action'] == 'approve_sorting') {

    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $remark = trim($_POST['approval_remark']);

    // 2. Decide status based on result
    $approved_remark = $remark;
    $approved_by = $session_id;
    $approved_date = $pst_datenow;
    $sorting_status =  $s_reviewed_id;

    // 3. Update sorting status in inspection record 
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ?, ir_s2w_status = ? WHERE ir_id = ?");
    $stmt->bind_param("iii", $sorting_status, $s_new_id, $ir_id);
    $success = $stmt->execute();

    // 3.1 Update sorting report
    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_status = ?, sr_s2w_status = ?, approved_remark = ?, approved_by = ?, approved_date = ? WHERE sr_id = ?");
    $stmt2->bind_param("iisssi", $sorting_status, $s_new_id, $approved_remark, $approved_by, $approved_date, $sr_id);
    $success2 = $stmt2->execute();

    $stmt2_1 = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
    $stmt2_1->bind_param("i", $ir_id);
    $success2_1 = $stmt2_1->execute();

    $db_con->commit();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT s.sr_docno, r.ir_shift, r.shift_date
                                FROM inspection_sorting s
                                    LEFT JOIN inspection_records r ON s.sr_ir_id = r.ir_id
                                        WHERE s.sr_id = ?");
    $stmt3->bind_param('i', $sr_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $sr_docno = $inspectiondet['sr_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'SR';
    $comment_status = "reviewed the sorting report";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_reviewed_id, $sr_docno, $sr_current_shift, $sr_production_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    // Force commit to ensure DB updates are visible immediately
    $db_con->commit();

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Sorting report has been approved.' : 'Failed to approve Sorting report.'
    ]);

    exit;
}

//Return inspection record
if ($_POST['action'] == 'return_sorting') {

    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $remark = trim($_POST['approval_remark']);

    // 2. Decide status based on result
    $returned_remark = $remark;
    $returned_by = $session_id;
    $returned_date = $pst_datenow;
    $sorting_status = $s_return_id;

    // 3. Update sorting status in inspection record 
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? WHERE ir_id = ?");
    $stmt->bind_param("ii", $s_return_id, $ir_id);
    $success = $stmt->execute();

    // 3.1 Update sorting report
    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_status = ?, returned_remark = ?, returned_by = ?, returned_date = ? WHERE sr_id = ?");
    $stmt2->bind_param("isssi", $sorting_status, $returned_remark, $returned_by, $returned_date, $sr_id);
    $success2 = $stmt2->execute();
    $db_con->commit();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT s.sr_docno, r.ir_shift, r.shift_date
                                FROM inspection_sorting s
                                    LEFT JOIN inspection_records r ON s.sr_ir_id = r.ir_id
                                        WHERE s.sr_id = ?");
    $stmt3->bind_param('i', $sr_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $sr_docno = $inspectiondet['sr_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'SR';
    $comment_status = "returned the sorting report";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_return_id, $sr_docno, $sr_current_shift, $sr_production_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    // Force commit to ensure DB updates are visible immediately
    $db_con->commit();

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Sorting report has been returned.' : 'Failed to return Sorting report.'
    ]);

    exit;
}

//Close inspection record
if ($_POST['action'] == 'close_sorting') {

    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $remark = trim($_POST['close_remark']);

    $closed_by = $session_id;
    $closed_date = $pst_datenow;
    $closed_status = 5; // Closed

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
    $success2 = $stmt2->execute();

    // 2. Sync inspection records
    $stmt = $db_con->prepare("UPDATE inspection_records SET 
                                ir_status = ?, 
                                ir_sorting_status = ?, 
                                ir_s2w_status = ?, 
                                ir_s2w_rp_status = ?, 
                                ir_s2w_ack_status = ?
                                WHERE ir_id = ?");
    $stmt->bind_param("iiiiii", $closed_status, $closed_status, $closed_status, $closed_status, $closed_status, $ir_id);
    $success = $stmt->execute();

    $db_con->commit();

    // 3. Fetch inspection details for activity log
    $stmt3 = $db_con->prepare("SELECT s.sr_docno, r.ir_shift, r.shift_date
                                FROM inspection_sorting s
                                    LEFT JOIN inspection_records r ON s.sr_ir_id = r.ir_id
                                        WHERE s.sr_id = ?");
    $stmt3->bind_param('i', $sr_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $sr_docno = $inspectiondet['sr_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    // Activity comment
    $appsection = 'PDI';
    $apptask = 'SR';
    $comment_status = "closed the inspection";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $closed_status, $sr_docno, $sr_current_shift, $sr_production_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    $db_con->commit();

    echo json_encode([
        'success' => $success2 && $success,
        'message' => ($success2 && $success) ? 'The inspection has been closed.' : 'Failed to close the inspection.'
    ]);

    exit;
}

ob_end_flush();

?>
