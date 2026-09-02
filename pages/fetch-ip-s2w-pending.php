<?php

ob_start();
error_reporting(0);

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';
include 'get-authorization-pdi.php';

$today = date('Y-m-d');
$pst_datenow = date('Y-m-d H:i:s');	

// All records
if($_POST['action'] == 'fetch_records')
{
    // Filters
    $model_id = $_POST['model'] ?? '';
    $type_id = $_POST['type'] ?? '';
    $material_id = $_POST['material'] ?? '';

    // $sql = "
    //     SELECT task
    //     FROM user_authorization
    //     WHERE staff_id = ?
    //     AND section = 'PDI'
    //     AND auto_status = 'AC'
    // ";

    // $stmt = $db_con->prepare($sql);
    // $stmt->bind_param("s", $session_id);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // $role_reviewer = 'N';
    // $role_approval = 'N';

    // while ($row = $result->fetch_assoc()) {
    //     if ($row['task'] === 'S2W_reviewer') {
    //         $role_reviewer = 'Y';
    //     }
    //     if ($row['task'] === 'S2W_approver') {
    //         $role_approval = 'Y';
    //     }
    // }

    // user role - if admin (1) list all, otherwise check authorization
    if ($session_role == 1) {
        $role_reviewer = "Y";
        $role_approval = "Y";
    } else {
        $sql = "SELECT S2W_reviewer, S2W_approver
                FROM user_authorization 
                WHERE staff_id = '$session_id'";
        $result = $db_con->query($sql);
        $row = $result->fetch_assoc();

        $role_reviewer = $row['S2W_reviewer'] ?? 'N';
        $role_approval = $row['S2W_approver'] ?? 'N';
    }

    $statusCondition = "";

    if($session_role != 1)
    {
        // Reviewer → status 9
        if ($role_reviewer === "Y" && $role_approval === "Y") {
            // BOTH Y → show both 9 & 10
            $statusCondition = " (S.s2w_status IN (9, 10)) ";
        }
        else if ($role_reviewer === "Y") {
            // Reviewer only
            $statusCondition = " (S.s2w_status = 9) ";
        }
        else if ($role_approval === "Y") {
            // Approval only
            $statusCondition = " (S.s2w_status = 10) ";
        }
        else {
            // No role → show nothing
            $statusCondition = " 1 = 0 ";
        }
    }
    else
    {
        // Admin → show both 9 & 10 (not all statuses)
        $statusCondition = " (S.s2w_status IN (9, 10)) ";
    }

    $columns = array('I.s2w_docno', 'M.matno', 'I.shift_date', 'I.ir_shifts');

    $query = "SELECT S.s2w_id, S.s2w_ir_id, S.s2w_sr_id, S.s2w_docno, S.s2w_status,
                I.ir_id, I.ir_pallet_no, I.inspect_date, I.ir_shift, 
                T.modcode, P.typemodel, M.partside, 
                M.matno, M.matdesc, H.shiftdesc, H.shiftbadge            
                FROM inspection_s2w AS S                
                LEFT JOIN inspection_records I ON S.s2w_ir_id = I.ir_id
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE $statusCondition
                AND I.ir_shift = '$current_shift' 
                AND I.shift_date = '$shift_date'";
   
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
                S.s2w_docno LIKE '%$search%' OR
                T.modcode LIKE '%$search%' OR 
                P.typemodel LIKE '%$search%' OR 
                M.partside LIKE '%$search%' OR 
                M.matno LIKE '%$search%' OR 
                M.matdesc LIKE '%$search%' OR
                I.ir_pallet_no LIKE '%$search%'
            ) ";
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

        $s2wid = $row['s2w_id'];

        $badgeClass = '';
        $badgeShift = $row["shiftbadge"];

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

        //button approve
        if ($row['s2w_status'] == 9) {
            $approvedBtn = 'btnReview';
            $returnBtn = 'btnRevReturn';
            $title = "Review S2W";
        }
        elseif($row['s2w_status'] == 10) {
            $approvedBtn = 'btnApprove';
            $returnBtn = 'btnAppReturn';
            $title = "Approve S2W";
        }

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
   
        $sub_array = array();

        $sub_array[] = '<input type="checkbox" class="row-check form-check-input" value="'.$row["s2w_id"].'" data-status="'.$row["s2w_status"].'">';
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" data-irid="'.$row['s2w_ir_id'].'" 
                                data-docno="'.htmlspecialchars($row['s2w_docno']).'" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Click to view details"><span class="fs-14">'.$row["s2w_docno"].' </span>
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
        $sub_array[] = '<button class="btn btn-rounded btn-primary btn-xxs '.$approvedBtn.' me-1" data-irid="'.$row['s2w_ir_id'].'" data-srid="'.$row['s2w_sr_id'].'" 
                            data-s2wid="'.$row['s2w_id'].'"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="'.$title.'">
                            <i class="fa fa-check"></i>
                        </a>
                        
                        <button class="btn btn-rounded btn-secondary btn-xxs '.$returnBtn.' btnReturn" data-irid="'.$row["s2w_ir_id"].'" data-srid="'.$row['s2w_sr_id'].'" 
                            data-s2wid="'.$row['s2w_id'].'"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
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
                        s.s2w_id, s.s2w_ir_id, s.s2w_sr_id, s.s2w_docno, s.s2w_additional_desc, s.s2w_send_to,
                        s.s2w_status, s.reviewed_remark, s.approved_remark, s.rvw_returned_remark, s.app_returned_remark, 
                        t.statusname, d.rd_dept_name,
                        (SELECT GROUP_CONCAT(ok_photo) FROM inspection_s2w_ok_photo WHERE s2w_id = s.s2w_id) AS ok_photos,
                        (SELECT GROUP_CONCAT(defect_photo) FROM inspection_s2w_defect_photo WHERE s2w_id = s.s2w_id) AS defect_photos
                    FROM inspection_s2w s
                    LEFT JOIN related_departments d ON s.s2w_send_to = d.rd_dept_id 
                    LEFT JOIN system_status t ON s.s2w_status = t.statusid
                    WHERE s.s2w_docno = ?
                    LIMIT 1
                ");
    $stmt->bind_param('s', $docno);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();

    //user role - as reviewer or approver
    $sql = "SELECT S2W_reviewer, S2W_approver
                FROM user_authorization 
                    WHERE staff_id = '$session_id'";
    $result = $db_con->query($sql);
    $row = $result->fetch_assoc();

    $role_reviewer = $row['S2W_reviewer'];  // Y or N
    $role_approval = $row['S2W_approver'];  // Y or N

    if ($data) {

        // Attach authorization info into the same array
        $data['S2W_reviewer'] = $role_reviewer;  // Y or N
        $data['S2W_approver'] = $role_approval;  // Y or N

        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false]);
    }

    // $sql = "
    //     SELECT task
    //     FROM user_authorization
    //     WHERE staff_id = ?
    //     AND section = 'PDI'
    //     AND auto_status = 'AC'
    // ";

    // $stmt = $db_con->prepare($sql);
    // $stmt->bind_param("s", $session_id);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // $role_reviewer = 'N';
    // $role_approval = 'N';

    // while ($row = $result->fetch_assoc()) {
    //     if ($row['task'] === 'S2W_reviewer') {
    //         $role_reviewer = 'Y';
    //     }
    //     if ($row['task'] === 'S2W_approver') {
    //         $role_approval = 'Y';
    //     }
    // }

    // if ($data) {

    //     $data['S2W_reviewer'] = $role_reviewer;  // Y / N
    //     $data['S2W_approver'] = $role_approval;  // Y / N

    //     echo json_encode([
    //         'success' => true,
    //         'data' => $data
    //     ]);
    // } else {
    //     echo json_encode(['success' => false]);
    // }


    exit;
}

//Review s2w
if ($_POST['action'] == 'review_s2w') {

    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $s2w_id = $_POST['s2w_id'];
    $remark = trim($_POST['approval_remark']);

    // 2. Decide status based on result
    $approved_remark = $remark;
    $approved_by = $session_id;
    $approved_date = $pst_datenow;
    $s2w_status =  $s_pendApproval_id;

    // 3. Update sorting status in inspection record 
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
    $stmt->bind_param("ii", $s2w_status, $ir_id);
    $success = $stmt->execute();

    // 3.1 Update sorting report
    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
    $stmt2->bind_param("ii", $s2w_status, $sr_id);
    $success2 = $stmt2->execute();

    // 3.1 Update S2W
    $stmt3 = $db_con->prepare("UPDATE inspection_s2w SET s2w_status = ?, reviewed_remark = ?, reviewed_by = ?, reviewed_date = ? WHERE s2w_id = ?");
    $stmt3->bind_param("isssi", $s2w_status, $approved_remark, $approved_by, $approved_date, $s2w_id);
    $success3 = $stmt3->execute();

    $db_con->commit();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT s.s2w_docno, r.ir_shift, r.shift_date
                                FROM inspection_s2w s
                                    LEFT JOIN inspection_records r ON s.s2w_ir_id = r.ir_id
                                        WHERE s.s2w_id = ?");
    $stmt3->bind_param('i', $s2w_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $s2w_docno = $inspectiondet['s2w_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'S2W';
    $comment_status = "reviewed the Something When Wrong (S2W)";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s2w_status, $s2w_docno, $sr_current_shift, $sr_production_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    // Force commit to ensure DB updates are visible immediately
    $db_con->commit();

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Something When Wrong (S2W) has been approved.' : 'Failed to approve Something When Wrong (S2W).'
    ]);

    exit;
}

//Approve s2w
if ($_POST['action'] == 'approve_s2w') {

    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $s2w_id = $_POST['s2w_id'];
    $remark = trim($_POST['approval_remark']);

    // 2. Decide status based on result
    $approved_remark = $remark;
    $approved_by = $session_id;
    $approved_date = $pst_datenow;
    $s2w_status =  $s_approved_id;

    // 3. Update sorting status in inspection record 
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ?, ir_s2w_rp_status  = ? WHERE ir_id = ?");
    $stmt->bind_param("iii", $s2w_status, $s_new_id, $ir_id);
    $success = $stmt->execute();

    // 3.1 Update sorting report
    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
    $stmt2->bind_param("ii", $s2w_status, $sr_id);
    $success2 = $stmt2->execute();

    // 3.1 Update S2W
    $stmt3 = $db_con->prepare("UPDATE inspection_s2w SET s2w_status = ?, s2w_rp_status = ?, approved_remark = ?, approved_by = ?, approved_date = ? WHERE s2w_id = ?");
    $stmt3->bind_param("iisssi", $s2w_status, $s_new_id, $approved_remark, $approved_by, $approved_date, $s2w_id);
    $success3 = $stmt3->execute();

    $db_con->commit();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT s.s2w_docno, r.ir_shift, r.shift_date
                                FROM inspection_s2w s
                                    LEFT JOIN inspection_records r ON s.s2w_ir_id = r.ir_id
                                        WHERE s.s2w_id = ?");
    $stmt3->bind_param('i', $s2w_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $s2w_docno = $inspectiondet['s2w_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'S2W';
    $comment_status = "approved the Something When Wrong (S2W)";

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
        'message' => $success ? 'Something When Wrong (S2W) has been approved.' : 'Failed to approve Something When Wrong (S2W).'
    ]);

    exit;
}

//Return s2w
if ($_POST['action'] == 'review-return') {
    // reviewer returns → update status to 8 or appropriate
    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $s2w_id = $_POST['s2w_id'];
    $remark = trim($_POST['approval_remark']);

    // 2. Decide status based on result
    $returned_remark = $remark;
    $returned_by = $session_id;
    $returned_date = $pst_datenow;
    $s2w_status = $s_return_id;

    // 3. Update sorting status in inspection record 
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
    $stmt->bind_param("ii", $s_return_id, $ir_id);
    $success = $stmt->execute();

    // 3.1 Update sorting report
    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
    $stmt2->bind_param("ii", $s2w_status, $sr_id);
    $success2 = $stmt2->execute();

    // 3.1 Update sorting report
    $stmt3 = $db_con->prepare("UPDATE inspection_s2w SET s2w_status = ?, rvw_returned_remark = ?, rvw_returned_by = ?, rvw_returned_date = ? WHERE s2w_id = ?");
    $stmt3->bind_param("isssi", $s2w_status, $returned_remark, $returned_by, $returned_date, $s2w_id);
    $success3 = $stmt3->execute();
    $db_con->commit();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT s.s2w_docno, r.ir_shift, r.shift_date
                                FROM inspection_s2w s
                                    LEFT JOIN inspection_records r ON s.s2w_ir_id = r.ir_id
                                        WHERE s.s2w_id = ?");
    $stmt3->bind_param('i', $s2w_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $s2w_docno = $inspectiondet['s2w_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'S2W';
    $comment_status = "returned the Something When Wrong (S2W)";

    // activities
    $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? and section = ? and task = ? ";
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
        'message' => $success ? 'Something When Wrong (S2W) has been returned.' : 'Failed to return Something When Wrong (S2W).'
    ]);

    exit;
}

if ($_POST['action'] == 'approve-return') {
    
    // approver returns → update status to 9
    $ir_id = $_POST['ir_id'];
    $sr_id = $_POST['sr_id'];
    $s2w_id = $_POST['s2w_id'];
    $remark = trim($_POST['approval_remark']);

    // 2. Decide status based on result
    $returned_remark = $remark;
    $returned_by = $session_id;
    $returned_date = $pst_datenow;
    $s2w_status = $s_return_id;

    // 3. Update sorting status in inspection record 
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
    $stmt->bind_param("ii", $s_return_id, $ir_id);
    $success = $stmt->execute();

    // 3.1 Update sorting report
    $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
    $stmt2->bind_param("ii", $s2w_status, $sr_id);
    $success2 = $stmt2->execute();

    // 3.1 Update sorting report
    $stmt3 = $db_con->prepare("UPDATE inspection_s2w SET s2w_status = ?, app_returned_remark = ?, app_returned_by = ?, app_returned_date = ? WHERE s2w_id = ?");
    $stmt3->bind_param("isssi", $s2w_status, $returned_remark, $returned_by, $returned_date, $s2w_id);
    $success3 = $stmt3->execute();
    $db_con->commit();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT s.s2w_docno, r.ir_shift, r.shift_date
                                FROM inspection_s2w s
                                    LEFT JOIN inspection_records r ON s.s2w_ir_id = r.ir_id
                                        WHERE s.s2w_id = ?");
    $stmt3->bind_param('i', $s2w_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $s2w_docno = $inspectiondet['s2w_docno'];
    $sr_current_shift = $inspectiondet['ir_shift'];
    $sr_production_date = $inspectiondet['shift_date'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'S2W';
    $comment_status = "returned the Something When Wrong (S2W)";

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
        'message' => $success ? 'Something When Wrong (S2W) has been returned.' : 'Failed to return Something When Wrong (S2W).'
    ]);

    exit;
}

// ---------- REVIEWED & APPROVED -------------//
// Reviewed
if ($_POST['action'] == 'fetch_records_reviewed') {

    /* ---------------------------------------------------
        1. USER AUTHORIZATION
    --------------------------------------------------- */
    // $S2W_reviewer and $S2W_approver are already loaded from get-authorization-pdi.php

    // If user is NOT reviewer → return empty dataset
    if ($S2W_approver !== "Y") {
        echo json_encode([
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => []
        ]);
        exit;
    }

    /* ---------------------------------------------------
        2. FILTER INPUTS
    --------------------------------------------------- */
    $model_id    = $_POST['model']    ?? '';
    $type_id     = $_POST['type']     ?? '';
    $material_id = $_POST['material'] ?? '';

    /* ---------------------------------------------------
        3. BASE QUERY (Reviewer always sees status=10)
    --------------------------------------------------- */
    $columns = ['S.s2w_docno', 'M.matno', 'I.shift_date', 'I.ir_shift'];

    $query = "
        SELECT 
            S.s2w_id, S.s2w_ir_id, S.s2w_sr_id, S.s2w_docno, S.s2w_status,
            I.ir_id, I.ir_pallet_no, I.inspect_date, I.ir_shift,
            T.modcode, P.typemodel, M.partside,
            M.matno, M.matdesc,
            H.shiftdesc, H.shiftbadge
        FROM inspection_s2w S
        LEFT JOIN inspection_records I ON S.s2w_ir_id = I.ir_id
        LEFT JOIN model_details T      ON I.ir_model = T.modid
        LEFT JOIN model_type P         ON I.ir_type  = P.typeid
        LEFT JOIN material_header M       ON I.ir_material = M.matid
        LEFT JOIN shift_detail H       ON I.ir_shift   = H.shiftshort
        WHERE S.s2w_status = 10
        AND I.ir_shift = '$current_shift'
        AND I.shift_date = '$shift_date'
    ";

    /* ---------------------------------------------------
        4. APPLY FILTERS
    --------------------------------------------------- */
    if (!empty($model_id)) {
        $query .= " AND I.ir_model = '$model_id'";
    }
    if (!empty($type_id)) {
        $query .= " AND I.ir_type = '$type_id'";
    }
    if (!empty($material_id)) {
        $query .= " AND I.ir_material = '$material_id'";
    }

    /* ---------------------------------------------------
        5. SEARCH FILTER (keyword)
    --------------------------------------------------- */
    if (!empty($_POST["search"]["value"])) {

        $search = $_POST["search"]["value"];

        // search by pallet: #123
        if (strpos($search, '#') === 0) {
            $palletNo = intval(ltrim($search, '#'));
            $query .= " AND I.ir_pallet_no = $palletNo ";
        } else {
            $search = $db_con->real_escape_string($search);

            $query .= "
                AND (
                    S.s2w_docno   LIKE '%$search%' OR
                    T.modcode     LIKE '%$search%' OR
                    P.typemodel   LIKE '%$search%' OR 
                    M.partside    LIKE '%$search%' OR 
                    M.matno       LIKE '%$search%' OR 
                    M.matdesc     LIKE '%$search%' OR
                    I.ir_pallet_no LIKE '%$search%'
                )
            ";
        }
    }

    /* ---------------------------------------------------
        6. ORDERING
    --------------------------------------------------- */
    if (isset($_POST["order"])) {
        $colIndex = $_POST['order'][0]['column'];
        $colDir   = $_POST['order'][0]['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    } else {
        $query .= " ORDER BY S.reviewed_date DESC ";
    }

    /* ---------------------------------------------------
        7. PAGINATION
    --------------------------------------------------- */
    $query_limit = "";

    if ($_POST["length"] != -1) {
        $start  = intval($_POST['start']);
        $length = intval($_POST['length']);
        $query_limit = " LIMIT $start, $length";
    }

    /* ---------------------------------------------------
        8. GET TOTAL COUNT + RECORDS
    --------------------------------------------------- */
    $count_result = mysqli_query($db_con, $query);
    $recordsTotal = mysqli_num_rows($count_result);

    $result = mysqli_query($db_con, $query . $query_limit);

    /* ---------------------------------------------------
        9. FORMAT DATA FOR DATATABLES
    --------------------------------------------------- */
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {

        $s2wid = $row['s2w_id'];
        
        $badgeShift = $row["shiftbadge"];

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

        if (!empty($rowABadge['statusname'])) {

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

        $inspectDate = date('d-m-Y', strtotime($row["inspect_date"]));

        $approvedBtn = 'btnApprove';
        $returnBtn = 'btnAppReturn';
        $title = "Approve S2W";

        // Logic authorization check
        $btnDisabled = ($S2W_approver == 'Y') ? '' : 'disabled style="cursor: no-drop; opacity: 0.6;"';
        $chkDisabled = ($S2W_approver == 'Y') ? '' : 'disabled';

        $data[] = [
            
            '<input type="checkbox" class="row-check form-check-input" value="'.$row["s2w_id"].'" data-status="'.$row["s2w_status"].'" '.$chkDisabled.'>',

            '<div class="clearfix ms-2">
                <a href="javascript:void(0);" 
                   class="fw-semibold text-primary viewDocDetails"
                   data-irid="'.$row['s2w_ir_id'].'"
                   data-docno="'.htmlspecialchars($row['s2w_docno']).'"
                   data-bs-toggle="tooltip" 
                   data-bs-placement="top" 
                   title="Click to view details">
                        <span class="fs-14">'.$row["s2w_docno"].'</span>
                </a>
            </div>',

            '<div class="clearfix ms-2">
                <h6 class="mb-0 fw-semibold small-text">'.$row["matno"].'</h6>
                <span class="fs-14">'.$row["matdesc"].'</span>
            </div>
            <div class="clearfix ms-2 mt-1">
                <h6 class="mb-0 fw-semibold small-text">'.$row["modcode"].'</h6>
                <span class="fs-14">'.$row["typemodel"].' ('.$row["partside"].')</span>
            </div>',

            '<span>'.$inspectDate.'</span>',
            '<span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span>',
            '<div class="d-flex align-items-center gap-2">' .$statusBadge. '</div>',

            '<button class="btn btn-rounded btn-primary btn-xxs '.$approvedBtn.' me-1" data-irid="'.$row['s2w_ir_id'].'" data-srid="'.$row['s2w_sr_id'].'" 
                data-s2wid="'.$row['s2w_id'].'"
                '.$btnDisabled.'
                data-bs-toggle="tooltip" data-bs-placement="top" title="'.$title.'">
                <i class="fa fa-check"></i>
            </button>
            
            <button class="btn btn-rounded btn-secondary btn-xxs '.$returnBtn.' btnReturn" data-irid="'.$row["s2w_ir_id"].'" data-srid="'.$row['s2w_sr_id'].'" 
                data-s2wid="'.$row['s2w_id'].'"
                '.$btnDisabled.'
                data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                <i class="fa fa-undo"></i>
            </button>'

        ];
    }

    /* ---------------------------------------------------
        10. RETURN JSON
    --------------------------------------------------- */
    echo json_encode([
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $recordsTotal,
        "recordsFiltered" => $recordsTotal,
        "data"            => $data
    ]);

    exit;
}

//Approved
if ($_POST['action'] == 'fetch_records_approved') {

    /* ---------------------------------------------------
        1. USER AUTHORIZATION
    --------------------------------------------------- */
    $sql = "SELECT S2W_approver FROM user_authorization WHERE staff_id = '$session_id'";
    $row = $db_con->query($sql)->fetch_assoc();
    $role_approval = $row['S2W_approver']; // Y or N

    // If NOT approver → return empty
    if ($role_approval !== "Y") {
        echo json_encode([
            "draw" => intval($_POST["draw"]),
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => []
        ]);
        exit;
    }

    /* ---------------------------------------------------
        2. FILTER INPUTS
    --------------------------------------------------- */
    $model_id    = $_POST['model']    ?? '';
    $type_id     = $_POST['type']     ?? '';
    $material_id = $_POST['material'] ?? '';

    /* ---------------------------------------------------
        3. BASE QUERY: Approved Only (status = 4)
    --------------------------------------------------- */
    $columns = ['S.s2w_docno', 'M.matno', 'I.shift_date', 'I.ir_shift'];

    $query = "
        SELECT 
            S.s2w_id, S.s2w_ir_id, S.s2w_sr_id, S.s2w_docno, S.s2w_status,
            I.ir_id, I.ir_pallet_no, I.inspect_date, I.ir_shift,
            T.modcode, P.typemodel, M.partside,
            M.matno, M.matdesc,
            H.shiftdesc, H.shiftbadge
        FROM inspection_s2w S
        LEFT JOIN inspection_records I ON S.s2w_ir_id = I.ir_id
        LEFT JOIN model_details T      ON I.ir_model = T.modid
        LEFT JOIN model_type P         ON I.ir_type  = P.typeid
        LEFT JOIN material_header M       ON I.ir_material = M.matid
        LEFT JOIN shift_detail H       ON I.ir_shift   = H.shiftshort
        WHERE S.s2w_status = 4
        AND I.ir_shift = '$current_shift'
        AND I.shift_date = '$shift_date'
    ";

    /* ---------------------------------------------------
        4. APPLY FILTERS
    --------------------------------------------------- */
    if (!empty($model_id)) {
        $query .= " AND I.ir_model = '$model_id'";
    }
    if (!empty($type_id)) {
        $query .= " AND I.ir_type = '$type_id'";
    }
    if (!empty($material_id)) {
        $query .= " AND I.ir_material = '$material_id'";
    }

    /* ---------------------------------------------------
        5. SEARCH FILTER
    --------------------------------------------------- */
    if (!empty($_POST["search"]["value"])) {

        $search = $_POST["search"]["value"];

        if (strpos($search, '#') === 0) {
            $palletNo = intval(ltrim($search, '#'));
            $query .= " AND I.ir_pallet_no = $palletNo ";
        } else {
            $search = $db_con->real_escape_string($search);

            $query .= "
                AND (
                    S.s2w_docno LIKE '%$search%' OR
                    T.modcode   LIKE '%$search%' OR
                    P.typemodel LIKE '%$search%' OR
                    M.partside  LIKE '%$search%' OR
                    M.matno     LIKE '%$search%' OR
                    M.matdesc   LIKE '%$search%' OR
                    I.ir_pallet_no LIKE '%$search%'
                )
            ";
        }
    }

    /* ---------------------------------------------------
        6. ORDERING
    --------------------------------------------------- */
    if (isset($_POST["order"])) {

        $colIndex = $_POST['order'][0]['column'];
        $colDir   = $_POST['order'][0]['dir'];

        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";

    } else {
        $query .= " ORDER BY S.approved_date DESC ";
    }

    /* ---------------------------------------------------
        7. PAGINATION
    --------------------------------------------------- */
    $query_limit = "";

    if ($_POST["length"] != -1) {
        $start  = intval($_POST['start']);
        $length = intval($_POST['length']);
        $query_limit = " LIMIT $start, $length";
    }

    /* ---------------------------------------------------
        8. GET TOTAL COUNT + FILTERED RESULTS
    --------------------------------------------------- */
    $result_count = mysqli_query($db_con, $query);
    $recordsTotal = mysqli_num_rows($result_count);

    $result = mysqli_query($db_con, $query . $query_limit);

    /* ---------------------------------------------------
        9. FORMAT DATA FOR DATATABLE
    --------------------------------------------------- */
    $data = [];

    while ($row = mysqli_fetch_assoc($result)) {

        $s2wid = $row['s2w_id'];

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

        if (!empty($rowABadge['statusname'])) {

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

        $inspectDate = date('d-m-Y', strtotime($row["inspect_date"]));
        $badgeShift  = $row["shiftbadge"];

        $data[] = [

            // Doc No
            '<div class="clearfix ms-2">
                <a href="javascript:void(0);" 
                   class="fw-semibold text-primary viewDocDetails"
                   data-irid="'.$row['s2w_ir_id'].'"
                   data-docno="'.htmlspecialchars($row['s2w_docno']).'"
                   data-bs-toggle="tooltip" 
                   data-bs-placement="top" 
                   title="Click to view details">
                    <span class="fs-14">'.$row["s2w_docno"].'</span>
                </a>
            </div>',

            // Material + Model
            '<div class="clearfix ms-2">
                <h6 class="mb-0 fw-semibold small-text">'.$row["matno"].'</h6>
                <span class="fs-14">'.$row["matdesc"].'</span>
            </div>
            <div class="clearfix ms-2 mt-1">
                <h6 class="mb-0 fw-semibold small-text">'.$row["modcode"].'</h6>
                <span class="fs-14">'.$row["typemodel"].' ('.$row["partside"].')</span>
            </div>',

            // Inspection Date
            '<span>'.$inspectDate.'</span>',

            // Shift
            '<span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span>',

            // Status
            '<div class="d-flex align-items-center gap-2">' .$statusBadge. '</div>'
        ];
    }

    /* ---------------------------------------------------
        10. RETURN JSON
    --------------------------------------------------- */
    echo json_encode([
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $recordsTotal,
        "recordsFiltered" => $recordsTotal,
        "data"            => $data
    ]);
    exit;
}

ob_end_flush();

?>
