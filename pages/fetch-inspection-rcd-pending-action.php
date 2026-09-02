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

if($_POST['action'] == 'fetch_records')
{
    // Filters
    $model_id = $_POST['model'] ?? '';
    $type_id = $_POST['type'] ?? '';
    $material_id = $_POST['material'] ?? '';

    $columns = array('I.ir_docno', 'M.matno', 'I.ir_pallet_no', 'I.ir_result', 'I.ir_status');

    $query = "SELECT I.ir_id, I.ir_docno, I.ir_pallet_no, I.ir_result, I.inspect_date, I.ir_shift, 
                T.modcode, P.typemodel, M.partside, M.matno, M.matdesc, H.shiftdesc             
                FROM inspection_records AS I
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE I.ir_status = '$s_pendReview_id' AND I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date'";
   
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
                I.ir_docno LIKE '%$search%' OR
                T.modcode LIKE '%$search%' OR 
                P.typemodel LIKE '%$search%' OR 
                M.partside LIKE '%$search%' OR 
                M.matno LIKE '%$search%' OR 
                M.matdesc LIKE '%$search%' OR
                I.ir_pallet_no LIKE '%$search%' OR
                I.ir_result LIKE '%$search%'
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
        $query .= 'ORDER BY I.submitted_date DESC';
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

        //Shift
        if ($row["ir_shift"] == 'D') 
        {
            $badgeClassSf = 'badge-secondary';
            $badgeIcon = '<span class="ms-1 fa fa-moon"></span>';
        }
        elseif ($row["ir_shift"] == 'N') 
        {
            $badgeClassSf = 'badge-danger';            
            $badgeIcon = ' <span class="ms-1 fa fa-sun"></span>';
        }

        //Result
        if ($row["ir_result"] == 'OK') $badgeClass = 'badge badge-rounded badge-outline-hijo';
        elseif ($row["ir_result"] == 'NG') $badgeClass = 'badge badge-rounded badge-outline-meron';
   
        $sub_array = array();
        
        $sub_array[] = '<input type="checkbox" class="row-check form-check-input" value="'.$row["ir_id"].'" data-result="'.$row['ir_result'].'">';
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" 
                                data-docno="'.$row["ir_docno"].'" title="Click to view details"><span class="fs-14">'.$row["ir_docno"].' </span>
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
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row["ir_pallet_no"].'</h6>
                        </div>'; 
        $sub_array[] = '<span class="badge badge-rounded '.$badgeClass.'">'.$row["ir_result"].'</a></span>';
        $sub_array[] = '<button class="btn btn-rounded btn-primary btn-xxs btnApprove me-1" data-irid="'.$row["ir_id"].'" data-result="'.$row['ir_result'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="Review">
                            <i class="fa fa-check"></i>
                        </a>
                        
                        <button class="btn btn-rounded btn-secondary btn-xxs btnReturn" data-irid="'.$row["ir_id"].'" data-bs-toggle="tooltip" data-bs-placement="top" title="Return">
                            <i class="fa fa-undo"></i>
                        </button>';
        $data[] = $sub_array;
        
    }

    function get_all_data($db_con)
    {
        $query = "SELECT * FROM inspection_records WHERE created_by = '$session_id'";
        $result = mysqli_query($db_con, $query);
        return mysqli_num_rows($result);
    }

    $output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  $number_filter_row,
    "recordsFiltered" => $number_filter_row,
    "data"    => $data
    );

    echo json_encode($output);
}

// Fetch all IDs for bulk selection across pagination
if($_POST['action'] == 'fetch_all_ids')
{
    $model_id = $_POST['model'] ?? '';
    $type_id = $_POST['type'] ?? '';
    $material_id = $_POST['material'] ?? '';

    $query = "SELECT I.ir_id            
                FROM inspection_records AS I
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE I.ir_status = '$s_pendReview_id' AND I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date'";
   
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

    if(isset($_POST["search"]["value"]) && $_POST["search"]["value"] != "")
    {
        $search = $_POST["search"]["value"];
       
        if (strpos($search, '#') === 0) {
            $palletNo = ltrim($search, '#');
            if (is_numeric($palletNo)) {
                $query .= " AND I.ir_pallet_no = " . intval($palletNo) . " ";
            }
        } else {
            $query .= " AND (
                I.ir_docno LIKE '%$search%' OR
                T.modcode LIKE '%$search%' OR 
                P.typemodel LIKE '%$search%' OR 
                M.partside LIKE '%$search%' OR 
                M.matno LIKE '%$search%' OR 
                M.matdesc LIKE '%$search%' OR
                I.ir_pallet_no LIKE '%$search%' OR
                I.ir_result LIKE '%$search%'
            ) ";
        }
    }

    $result = mysqli_query($db_con, $query);
    $ids = array();
    while($row = mysqli_fetch_array($result))
    {
        $ids[] = $row['ir_id'];
    }

    echo json_encode($ids);
}

//View details in Modal
if($_POST['action'] == 'inspection_details')
{
    $docno = $_POST['docno'];

    $sql = "SELECT I.ir_id, I.ir_docno, I.ir_docnocancel, I.ir_pallet_no, I.ir_result, I.ir_status, I.ir_shift,
            I.created_date, I.submitted_date, I.approved_date, I.reviewed_date, I.cancelled_date, I.returned_date,
            I.approved_by, I.reviewed_by, I.returned_by, I.approved_remark, I.cancel_remark, I.returned_remark, 
            T.modcode, P.typemodel, M.partside, M.matno, M.matdesc, H.shiftdesc, H.shiftbadge, S.statusname,
            E.short_name as createby, ES.short_name as submitby, EA.short_name as approvalby, EW.short_name as reviewby, 
            EC.short_name as cancelby, ER.short_name as returnby 
            FROM inspection_records as I    
            LEFT JOIN model_details as T ON I.ir_model = T.modid
            LEFT JOIN model_type as P ON I.ir_type = P.typeid
            LEFT JOIN material_header as M ON I.ir_material = M.matid     
            LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort    
            LEFT JOIN system_status as S ON I.ir_status = S.statusid 
            LEFT JOIN employee_details AS E ON I.created_by = E.staff_id
            LEFT JOIN employee_details AS ES ON I.submitted_by = ES.staff_id
            LEFT JOIN employee_details AS EA ON I.approved_by = EA.staff_id
            LEFT JOIN employee_details AS EW ON I.reviewed_by = EW.staff_id
            LEFT JOIN employee_details AS EC ON I.cancelled_by = EC.staff_id
            LEFT JOIN employee_details AS ER ON I.returned_by = ER.staff_id 
            WHERE I.ir_docno = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("s", $docno);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $docno = $row['ir_docno'];
    $ir_id = $row['ir_id'];
    $ng_html = ''; 

    if ($row['ir_result'] === 'NG') {

        // 1. Get defect results (with type name)
        $sqlDefect = "SELECT D.defect_id, D.defect_type, D.defect_area, T.defectname
                    FROM inspection_defect D
                    LEFT JOIN defect_type T ON D.defect_type = T.defectid
                    WHERE D.rcd_ir_id = ?";
        $stmtDefect = $db_con->prepare($sqlDefect);
        $stmtDefect->bind_param("i", $ir_id);
        $stmtDefect->execute();
        $resDefect = $stmtDefect->get_result();

        if ($resDefect->num_rows > 0) {

            $ng_html .= '          
                <div class="card">
                    <div class="card-body">
                        <!--<h5 class="text-primary mt-3">Defects</h5>-->
                        <div class="table-responsive">
                            <table class="table custom-rounded-table date-table w-100" id="inspectionTable_defect">
                                <thead class="">
                                    <tr>
                                        <th>Defect Type</th>
                                        <th>Defect Area</th>
                                        <th>Defect Photo</th>
                                        <th>Comparison Photo</th>
                                    </tr>
                                </thead>
                                <tbody>';
            
            while ($defect = $resDefect->fetch_assoc()) {
                
                $defectId = $defect['defect_id'];

                //Fetch defect photos
                $photoHtml = '';
                $sqlPhoto = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                $stmtPhoto = $db_con->prepare($sqlPhoto);
                $stmtPhoto->bind_param("ii", $ir_id, $defectId);
                $stmtPhoto->execute();
                $resPhoto = $stmtPhoto->get_result();

                $photoHtml .= '<div class="avatar-list avatar-list-stacked">';
                while ($photo = $resPhoto->fetch_assoc()) {

                    $photoUrl = 'gallery/inspection/defect/' .$ir_id. '/' . $photo['defect_photo'];
                    $photoHtml .= '<img src="'.$photoUrl.'" data-src="'.$photoUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $photoHtml .= '</div>';

                if ($photoHtml === '') $photoHtml = '<span class="text-muted">-</span>';

                //Fetch comparison photos
                $compareHtml = '';
                $sqlCompare = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                $stmtCompare = $db_con->prepare($sqlCompare);
                $stmtCompare->bind_param("ii", $ir_id, $defectId);
                $stmtCompare->execute();
                $resCompare = $stmtCompare->get_result();

                $compareHtml .= '<div class="avatar-list avatar-list-stacked">';
                while ($compare = $resCompare->fetch_assoc()) {
                    $compareUrl = 'gallery/inspection/defect_compare/' .$ir_id. '/' . $compare['compare_photo'];
                    $compareHtml .= '<img src="'.$compareUrl.'" data-src="'.$compareUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $compareHtml .= '</div>';

                if ($compareHtml === '') $compareHtml = '<span class="text-muted">-</span>';

                // Defect row
                $ng_html .= '
                    <tr>
                        <td>'.$defect['defectname'].'</td>
                        <td>'.$defect['defect_area'].'</td>
                        <td>'.$photoHtml.'</td>
                        <td>'.$compareHtml.'</td>
                    </tr>';
            }

            $ng_html .= '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
                
        } else {
            $ng_html .= '<p class="text-muted px-4">No defect data found.</p>';
        }
    }

    //Result
    $badgeClass = "";

    if ($row["ir_result"] == 'OK') $badgeClass = 'badge-hijo';
    elseif ($row["ir_result"] == 'NG') $badgeClass = 'badge-meron';

    //Shift
    $badgeShift = $row["shiftbadge"];

    $status = $row['ir_status']; // current status

    // Always show Created Date
    $created_Dt = date("j M Y", strtotime($row['created_date'])) . ' | ' . date("h:i A", strtotime($row['created_date']));
    $created_by = 'by '.$row['createby'];

    // Submit date
    if ($row['submitted_date'] != '0000-00-00 00:00:00') {
        $submitted_Dt = date("j M Y", strtotime($row['submitted_date'])) . ' | ' . date("h:i A", strtotime($row['submitted_date']));        
        $submitted_by = 'by '.$row['submitby'];
    }
    else
    {
        $submitted_Dt = '-';
        $submitted_by = '';
    }

    //Approved & Reviewed date
    if ($row['approved_date'] != '0000-00-00 00:00:00') {
        if($row['ir_result'] === 'OK')
        {
            $approved_Dt = date("j M Y", strtotime($row['approved_date'])) . ' | ' . date("h:i A", strtotime($row['approved_date']));
            $approved_by = 'by '.$row['approvalby'];
            $approved_remark = $row['approved_remark'];
        }
        else
        {
            $approved_Dt = date("j M Y", strtotime($row['reviewed_date'])) . ' | ' . date("h:i A", strtotime($row['reviewed_date']));
            $approved_by = 'by '.$row['reviewby'];            
            $approved_remark = $row['approved_remark'];
        }
    }
    else
    {
        $approved_Dt = '-';
        $approved_by = '';
        $approved_remark = '';
    }

    //Cancelled date
    if ($row['cancelled_date'] != '0000-00-00 00:00:00') {
        $cancelled_Dt = date("j M Y", strtotime($row['cancelled_date'])) . ' | ' . date("h:i A", strtotime($row['cancelled_date']));
        $cancelled_by = 'by '.$row['cancelby'];
        $cancelled_remark = $row['cancel_remark'];
        $cancelled_docno = $row['ir_docnocancel'];
    }
    else
    {
        $cancelled_Dt = '-';
        $cancelled_by = '';
        $cancelled_remark = '';
        $cancelled_docno = '';
    }

    //Returned date
    if ($row['returned_date'] != '0000-00-00 00:00:00') {
        $returned_Dt = date("j M Y", strtotime($row['returned_date'])) . ' | ' . date("h:i A", strtotime($row['returned_date']));
        $returned_by = 'by '.$row['returnby'];
        $returned_remark = $row['returned_remark'];
    }
    else
    {
        $returned_Dt = '-';
        $returned_by = '';
        $returned_remark = '';
    }

    echo '<div class="row">
          
            <!-- LEFT: Pallet Card -->
            <div class="col-lg-8 mb-3">
                <div class="card p-3 mb-3 rounded shadow-sm border">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; font-size: 18px;">
                                '.$row['ir_pallet_no'].'
                            </div>
                            <span class="ms-2 text-muted">Pallet Sequence</span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-black px-3 py-2">'.$row["statusname"].'</span></br>
                            <!--<small class="text-muted">Inspected by : <strong class="text-dark">'.$row["createby"].'</strong></small>-->
                        </div>                    
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <p class="text-muted mb-0">Material</p>
                            <p class="fw-semibold text-primary mb-0">'.$row["matno"].'</p>
                            <p class="fw-semibold text-primary">'.$row["matdesc"].'</p>
                            <p class="text-muted mb-0 mt-2">Model</p>
                            <p class="fw-semibold text-primary">'.$row["modcode"].' ('.$row["partside"].')'.'</p>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted mb-0">Doc no</p>
                            <p class="fw-semibold text-primary">'.$row['ir_docno'].'</p>

                            <div class="d-flex gap-3 mt-3">
                                <div>
                                    <p class="text-muted mb-1">Result</p>
                                    <span class="badge badge-rounded '.$badgeClass.'">'.$row["ir_result"].'</span>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Shift</p>
                                    <h5 class="mb-0 mt-1 custom-text-mat"><span class="badge badge-rounded '.$badgeShift.'">'.$row["shiftdesc"].'</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Activity Timeline -->
            <div class="col-lg-4 mb-3">
                <div class="card">
                    <div class="card-header py-3 d-block d-sm-flex bg-body-secondary">
                        <h4 class="heading mb-0">Timeline</h4>
                    </div>
                    <div class="card-body"  style="overflow-y:scroll;height:auto;max-height:260px;">
                        <div class="recent-post">
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark">Created Date</p>
                                    <span class="ms-0 fs-13">'.$created_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$created_by.'</span>
                                </div>
                            </div>
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-alt"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark">Submitted Date</p>
                                    <span class="ms-0 fs-13">'.$submitted_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$submitted_by.'</span>
                                </div>
                            </div>
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$approved_remark.'">Approved Date</p>
                                    <span class="ms-0 fs-13">'.$approved_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$approved_by.'</span> 
                                </div>
                            </div>
                            <div class="timeline-entry mb-0">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-minus"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$returned_remark.'">Returned Dates</p>
                                    <span class="ms-0 fs-13">'.$returned_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$returned_by.'</span> 
                                </div>
                            </div>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        // Display defect
        echo $ng_html;
}

//Single Approve inspection record
if ($_POST['action'] == 'approve_inspection') {

    $ir_id = $_POST['ir_id'];
    $remark = trim($_POST['approval_remark']);
    $ir_result = $_POST['result_id'];

    // 2. Decide status based on result
    if ($ir_result === 'OK') {

        $ir_status = $s_completed_id; // Completed
        $approved_remark = $remark;
        $approved_by = $session_id;
        $approved_date = $pst_datenow;

        $reviewed_remark = '';
        $reviewed_by = '';
        $reviewed_date = '';
        $sorting_status = "";

    } elseif ($ir_result === 'NG') {

        $ir_status = $s_reviewed_id; // Approved
        $approved_remark = '';
        $approved_by = '';
        $approved_date = '';

        $reviewed_remark = $remark;
        $reviewed_by = $session_id;
        $reviewed_date = $pst_datenow;
        $sorting_status = $s_new_id;
        
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid result value: ' . $ir_result
        ]);
        exit;
    }

    // 3. Update inspection record with new status
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_status = ?, ir_sorting_status = ?, reviewed_remark = ?, reviewed_by = ?, reviewed_date = ?, 
                                approved_remark = ?, approved_by = ?, approved_date = ? WHERE ir_id = ?");
    $stmt->bind_param("iissssssi", $ir_status, $sorting_status, $reviewed_remark, $reviewed_by, $reviewed_date, $approved_remark, $approved_by, $approved_date, $ir_id);
    $success = $stmt->execute();

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.ir_status, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_records R 
                                        LEFT JOIN material_header M ON R.ir_material = M.matid
                                            WHERE ir_id = ?");
    $stmt3->bind_param('i', $ir_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $ir_docno = $inspectiondet['ir_docno'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'IR';
    $comment_status = "reviewed the inspection submission";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_reviewed_id, $ir_docno, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();
    

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Inspection has been approved.' : 'Failed to approve inspection.'
    ]);

    exit;
}

//Single Return inspection record
if ($_POST['action'] == 'return_inspection') {

    $ir_id = $_POST['ir_id'];
    $remark = trim($_POST['approval_remark']);

    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_status = ?, returned_remark = ?, returned_by = ?, returned_date = NOW() WHERE ir_id = ?");
    $stmt->bind_param("issi", $s_return_id, $remark, $session_id, $ir_id);
    $success = $stmt->execute();

       // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_records R 
                                        LEFT JOIN material_header M ON R.ir_material = M.matid
                                            WHERE ir_id = ?");
    $stmt3->bind_param('i', $ir_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    $ir_docno = $inspectiondet['ir_docno'];

    //activity comment
    $appsection = 'PDI';
    $apptask = 'IR';
    $comment_status = "return the inspection";

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_return_id, $ir_docno, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    echo json_encode([
        'success' => $success,
        'message' => $success ? 'Inspection has been returned.' : 'Failed to return inspection.'
    ]);
    exit;
}

ob_end_flush();

?>
