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
    $columns = array('I.ir_docno', 'M.matno', 'P.modcode', 'I.inspect_date', 'H.shiftdesc', 'I.ir_pallet_no', 'I.ir_status');

    $query = "SELECT I.ir_id, I.ir_docno, I.ir_model, I.ir_type, I.ir_material, I.ir_pallet_no, I.ir_result, I.ir_status, I.ir_sorting_status,
                     I.inspect_date, I.shift_date, I.prod_date, I.inspect_group, I.ir_shift, I.created_by, I.created_date, 
                     T.modcode, P.typemodel, M.partside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc, H.shiftbadge
              FROM inspection_records AS I 
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              LEFT JOIN system_status AS U ON I.ir_sorting_status = U.statusid
              WHERE I.ir_result = 'NG' and I.ir_status = '$s_reviewed_id' 
              AND I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date' ";

    if ($session_role == 4) {
        // Restrict to only their own records
        $query .= " AND I.created_by = '$session_id' ";
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

    // Filter: Inspection Date Range
    if (!empty($_POST['fd_daterange_insp'])) {
        $daterange = $_POST['fd_daterange_insp'];
        $dates = explode(' - ', $daterange);
        if (count($dates) == 2) {
            $start_date = date('Y-m-d', strtotime(str_replace('/', '-', trim($dates[0]))));
            $end_date = date('Y-m-d', strtotime(str_replace('/', '-', trim($dates[1]))));
            $query .= " AND I.inspect_date BETWEEN '$start_date' AND '$end_date' ";
        }
    }

    // Filter: Production Date Range
    if (!empty($_POST['fd_daterange_prod'])) {
        $daterange = $_POST['fd_daterange_prod'];
        $dates = explode(' - ', $daterange);
        if (count($dates) == 2) {
            $start_date = date('Y-m-d', strtotime(str_replace('/', '-', trim($dates[0]))));
            $end_date = date('Y-m-d', strtotime(str_replace('/', '-', trim($dates[1]))));
            $query .= " AND I.prod_date BETWEEN '$start_date' AND '$end_date' ";
        }
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);
       
        // Convert search to Y-m-d format if it looks like a date (DD-MM-YYYY)
        $dateSearch = '';
        if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $search)) {
            // Convert DD-MM-YYYY to YYYY-MM-DD
            $dateParts = explode('-', $search);
            $dateSearch = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
        }
        
        // Combine: subquery filter + multi-column search
        $query .= " AND (
                    -- 1. Match sr_docno in sorting (exclude status 1 & 13)
                    I.ir_id IN (
                        SELECT sr_ir_id 
                        FROM inspection_sorting 
                        WHERE sr_docno LIKE '%$search%' 
                        AND sr_status != 1 
                        AND sr_status != 13
                    )

                    -- 2. OR match other columns (joined fields)
                    OR U.statusname LIKE '%$search%'
                    OR T.modcode LIKE '%$search%'
                    OR P.typemodel LIKE '%$search%'
                    OR M.partside LIKE '%$search%'
                    OR M.matno LIKE '%$search%'
                    OR M.matdesc LIKE '%$search%'
                    OR H.shiftdesc LIKE '%$search%'";
        
        // Add date search if format matches DD-MM-YYYY
        if ($dateSearch) {
            $query .= " OR I.inspect_date = '$dateSearch'
                        OR I.prod_date = '$dateSearch'";
        }
        
        $query .= " ) ";   
        
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
        $query .= " ORDER BY I.ir_pallet_no ASC"; // default sort by pallet sequence
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
        $irid = $row['ir_id'];

        // Status badge
        $statusBadge = '';

        $queryBadge = "SELECT 
                            r.*,
                            s.statusname,
                            s.badge,
                            s.badge_color,
                            s.text_color,
                            s.icon_class
                        FROM inspection_records r
                        LEFT JOIN system_status s 
                        ON s.statusid = r.ir_sorting_status
                        WHERE r.ir_id = '$irid' ";        

        $resultBadge = mysqli_query($db_con, $queryBadge);
        $rowABadge = mysqli_fetch_assoc($resultBadge);

        // if (!empty($rowABadge['statusname']) && ($row['ir_sorting_status'] != 1)) {
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

        // Action buttons
        $btnAction = ''; // default empty

        if ($row['ir_sorting_status'] == 1) {
            // ADD button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnCreate ms-1"
                            data-bs-toggle="tooltip" title="Create Sorting"
                            data-irid="'.$irid.'" data-model="'.$row['ir_model'].'"
                            data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-plus"></i>
                        </button>';
        }
        elseif (in_array($row['ir_sorting_status'], [12, 13])) {
            // EDIT button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnEdit ms-1"
                            data-bs-toggle="tooltip" title="Edit Sorting"
                            data-irid="'.$irid.'" data-model="'.$row['ir_model'].'"
                            data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-edit"></i>
                        </button>';
        }
        elseif (in_array($row['ir_sorting_status'], [8,9,11])) {
            // VIEW button
            $btnAction = '<button class="btn btn-rounded btn-black btn-xxs btnView ms-1"
                            data-bs-toggle="tooltip" title="View Sorting"
                            data-irid="'.$irid.'" data-model="'.$row['ir_model'].'"
                            data-type="'.$row['ir_type'].'" data-material="'.$row['ir_material'].'">
                            <i class="fa fa-list"></i>
                        </button>';
        }
        
        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
        $productiondate = date('d-m-Y', strtotime($row["prod_date"]));

        $display_docno = '';

        // If status in 4,7,10,12,13 → get sr_docno from inspection_sorting
        $q_sr = $db_con->prepare("SELECT sr_docno, sr_status FROM inspection_sorting WHERE sr_ir_id = ?");
        $q_sr->bind_param("i", $irid);
        $q_sr->execute();
        $q_sr->bind_result($sr_docno, $sr_status);
        if ($q_sr->fetch()) {
            if ($sr_status != 1 && $sr_status != 8 && $sr_status != 13) {
                $display_docno = $sr_docno;
            } else {
                $display_docno = ''; // hide docno if status 1 or 13
            }
        }
        $q_sr->close();

        $sorting_status = intval($row['ir_sorting_status']);
        $disableCheck = (in_array($sorting_status, [1,5,8,11])) ? 'disabled' : '';

        $sub_array = [];
     
        if ($sorting_status == 1) {
            $sub_array[] = '';
        } else {
            $sub_array[] = '<input type="checkbox"
                                class="row-check form-check-input"
                                value="'.$row["ir_id"].'"
                                data-status="'.$sorting_status.'"
                                '.$disableCheck.'>';
        }
        $sub_array[] = '<div class="clearfix ms-2">
                            <span class="fs-14" 
                                data-docno="'.$display_docno.'" data-bs-toggle="tooltip" title="">
                                <span class="fs-14">'.$display_docno.'</span>
                            </span>
                        </div>';
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2 viewMaterial" data-inspect-group="'.$row["inspect_group"].'"
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
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$productiondate.'</span></div>';
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
// VIEW DETAILS MODAL
// ==========================================================
if($_POST['action'] == 'inspection_details')
{

    $docno = $_POST['docno'];

    $sql = "SELECT I.ir_id, I.ir_docno, I.ir_docnocancel, I.ir_pallet_no, I.ir_result, I.ir_status, I.ir_shift,
            I.created_date, I.submitted_date, I.approved_date, I.reviewed_date, I.cancelled_date, I.returned_date,
            I.approved_by, I.reviewed_by, I.returned_by, I.reviewed_remark, I.approved_remark, I.cancel_remark, I.returned_remark,
            T.modcode, P.typemodel, M.partside, 
            M.matno, M.matdesc, H.shiftdesc, H.shiftbadge, S.statusname, 
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

                    $photoUrl = 'gallery/inspection/defect/' . $photo['defect_photo'];
                    $photoHtml .= '<img src="'.$photoUrl.'" data-src="'.$photoUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $photoHtml .= '</div>';

                if ($resPhoto->num_rows === 0) $photoHtml = '<span class="text-muted">-</span>';

                //Fetch comparison photos
                $compareHtml = '';
                $sqlCompare = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                $stmtCompare = $db_con->prepare($sqlCompare);
                $stmtCompare->bind_param("ii", $ir_id, $defectId);
                $stmtCompare->execute();
                $resCompare = $stmtCompare->get_result();

                $compareHtml .= '<div class="avatar-list avatar-list-stacked">';
                while ($compare = $resCompare->fetch_assoc()) {
                    $compareUrl = 'gallery/inspection/defect_compare/' . $compare['compare_photo'];
                    $compareHtml .= '<img src="'.$compareUrl.'" data-src="'.$compareUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $compareHtml .= '</div>';

                if ($resCompare->num_rows === 0) $compareHtml = '<span class="text-muted">-</span>';

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
        $approved_remark = $row['reviewed_remark'];
    }

    //Cancelled date
    if ($row['cancelled_date'] != '0000-00-00 00:00:00') {
        $cancelled_Dt = date("j M Y", strtotime($row['cancelled_date'])) . ' | ' . date("h:i A", strtotime($row['cancelled_date']));
        $cancelled_by = 'by '.$row['cancelby'];
        $cancelled_remark = $row['cancel_remark'];
        $cancelled_docno = '#'.$row['ir_docnocancel'];
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
                            <p class="fw-semibold text-primary">'.$row["typemodel"].' ('.$row["partside"].')'.'</p>
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
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$approved_remark.' ">Approved Date</p>
                                    <span class="ms-0 fs-13">'.$approved_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$approved_by.'</span> 
                                </div>
                            </div>
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-times"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$cancelled_remark.'">Cancelled Date</p>
                                    <span class="ms-0 fs-13">'.$cancelled_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$cancelled_by.'</span></br>
                                    <span class="ms-0 fs-13 bold text-black">'.$cancelled_docno.'</span>
                                </div>
                            </div>
                            <div class="timeline-entry mb-0">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-minus"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$returned_remark.'">Returned Date</p>
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

// ==========================================================
// ADD SORTING DETAILS
// ==========================================================
if ($_POST['action'] == 'add_sorting') {

    if (!empty($_POST['ir_id']) && isset($_POST['qty_ok'], $_POST['qty_ng'], $_POST['sorting_method'], $_POST['rework_method'])) {
        
        $ir_id          = intval($_POST['ir_id']);
        $qty_ok         = intval($_POST['qty_ok']);
        $qty_ng         = intval($_POST['qty_ng']);
        $sorting_method = trim($_POST['sorting_method']);
        $rework_method  = trim($_POST['rework_method']);
        $remarks        = trim($_POST['remarks']);
     
        //update sorting status n table inspection records
        $stmt = $db_con->prepare("UPDATE inspection_records SET ir_sorting_status = ? WHERE ir_id = ?");
        $stmt->bind_param('ii', $s_draft_id, $ir_id);
        $stmt->execute();
        
        // Insert main record
        $stmt = $db_con->prepare("INSERT INTO inspection_sorting 
                    (sr_ir_id, sr_qty_ok, sr_qty_ng, sr_sorting_method, sr_rework_method, sr_remarks, sr_status, created_by, created_date) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iiisssis", $ir_id, $qty_ok, $qty_ng, $sorting_method, $rework_method, $remarks, $s_draft_id, $session_id);

        if ($stmt->execute()) {

            $insert_id = $stmt->insert_id;

            // Auto create folder for photo
            // before
            $folder_new_b = __DIR__ . "/gallery/inspection_sorting/before/" . $insert_id;
            if (!is_dir($folder_new_b)) mkdir($folder_new_b, 0777, true);

            // after
            $folder_new_a = __DIR__ . "/gallery/inspection_sorting/after/" . $insert_id;
            if (!is_dir($folder_new_a)) mkdir($folder_new_a, 0777, true);


            // BEFORE PHOTOS
            if (!empty($_FILES['before_photo']['name'][0])) {
                foreach ($_FILES['before_photo']['tmp_name'] as $i => $tmp_name) {
                    if ($_FILES['before_photo']['error'][$i] === 0) {
                        $filename = uniqid() . '_' . str_replace(' ', '_', basename($_FILES['before_photo']['name'][$i]));
                        $targetFile = __DIR__ . "/gallery/inspection_sorting/before/" .$insert_id. "/" . $filename;
                        if (move_uploaded_file($tmp_name, $targetFile)) {
                            $stmtPhoto = $db_con->prepare("INSERT INTO inspection_sorting_before_photo 
                                (sr_ir_id, sr_sorting_id, before_photo, created_by, created_date) 
                                VALUES (?, ?, ?, ?, NOW())");
                            $stmtPhoto->bind_param("iiss", $ir_id, $insert_id, $filename, $session_id);
                            $stmtPhoto->execute();
                        }
                        else {
                            error_log("Upload failed: " . $tmp_name . " to " . $targetFile);
                        }
                    }
                }
            }

            // AFTER PHOTOS
            if (!empty($_FILES['after_photo']['name'][0])) {
                foreach ($_FILES['after_photo']['tmp_name'] as $i => $tmp_name) {
                    if ($_FILES['after_photo']['error'][$i] === 0) {
                        $filename = uniqid() . '_' . str_replace(' ', '_', basename($_FILES['after_photo']['name'][$i]));
                        $targetFile = __DIR__ . "/gallery/inspection_sorting/after/" .$insert_id. "/" . $filename;
                        if (move_uploaded_file($tmp_name, $targetFile)) {
                            $stmtAftPhoto = $db_con->prepare("INSERT INTO inspection_sorting_after_photo 
                                (sr_ir_id, sr_sorting_id, after_photo, created_by, created_date) 
                                VALUES (?, ?, ?, ?, NOW())");
                            $stmtAftPhoto->bind_param("iiss", $ir_id, $insert_id, $filename, $session_id);
                            $stmtAftPhoto->execute();
                        }
                    }
                }
            }

            echo json_encode([
                "status" => "success",
                "message" => "Sorting record saved successfully.",
                "insert_id" => $insert_id,
                "ir_id" => $ir_id,
                "sr_status" => $s_draft_id
            ]);

        } else {
            echo json_encode(["status" => "error", "message" => "Insert failed: " . $stmt->error]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Missing required fields"]);
    }
}

// ==========================================================
// GET SORTING DETAILS
// ==========================================================
if ($_POST['action'] == 'get_sorting_details') {

    $ir_id = intval($_POST['ir_id']);

    // 1. Get the latest sorting record (if exists)
     // 1. Get the latest sorting record (if exists)
    // $stmt = $db_con->prepare("SELECT 
    //                             s.sr_id,
    //                             s.sr_docno,
    //                             s.sr_qty_ok,
    //                             s.sr_qty_ng,
    //                             s.sr_sorting_method,
    //                             s.sr_rework_method,
    //                             s.sr_remarks,
    //                             t.statusname
    //                             FROM inspection_sorting s   
    //                             LEFT JOIN system_status t ON s.sr_status = t.statusid 
    //                             WHERE s.sr_ir_id = ? and s.sr_status != ?
    //                             ORDER BY s.sr_id DESC LIMIT 1");
    // $stmt->bind_param("ii", $ir_id, $s_cancelled_id);
    // $stmt->execute();
    // $result = $stmt->get_result();

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
                                WHERE s.sr_ir_id = ?
                                ORDER BY s.sr_id DESC LIMIT 1");
    $stmt->bind_param("i", $ir_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $sorting = $result->fetch_assoc(); // may be null
    $sorting_id = $sorting['sr_id'] ?? null;

    // 2. Always get sorting status from inspection_record
    $stmt2 = $db_con->prepare("SELECT ir_sorting_status FROM inspection_records WHERE ir_id = ? ");
    $stmt2->bind_param("i", $ir_id);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    $status_row = $res2->fetch_assoc();

    $sorting_status = $status_row ? $status_row['ir_sorting_status'] : null;

    // 3. Prepare default response
    $response = [
        "status" => "success",
        "data" => [
            "sr_id" => $sorting_id,
            "ir_id" => $ir_id,
            "sr_qty_ok" => $sorting['sr_qty_ok'] ?? null,
            "sr_qty_ng" => $sorting['sr_qty_ng'] ?? null,
            "sr_sorting_method" => $sorting['sr_sorting_method'] ?? null,
            "sr_rework_method" => $sorting['sr_rework_method'] ?? null,
            "sr_remarks" => $sorting['sr_remarks'] ?? null,
            "sr_status" => $sorting['sr_status'] ?? $sorting_status,
            "sr_docno" => $sorting['sr_docno'] ?? null, 
            "sr_statusname" => $sorting['statusname'] ?? null,
            "before_photo" => [],
            "after_photo" => []
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
                "before_photoid" => $p['before_photoid'],
                "file" => $p['before_photo'],
                "srid" => $sorting_id
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
                "after_photoid" => $p['after_photoid'],
                "file" => $p['after_photo'],
                "srid" => $sorting_id
            ];
        }

        $response['data']['before_photo'] = $photos_before;
        $response['data']['after_photo'] = $photos_after;
    }

    echo json_encode($response);
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
            $targetPath = "gallery/inspection_sorting/after/" .$sr_id. "/" . $filename;

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
if($_POST['action'] == 'submit_sorting')
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
        $ir_docno = $session_comp . $sr_code . $doc_date . $running_no;

        // 2. Update inspection_sorting
        $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_docno = ?, sr_qty_ok = ?, sr_qty_ng = ?, sr_sorting_method = ?, sr_rework_method = ?, 
                                    sr_remarks = ?, sr_status = ?, submitted_by = ?, submitted_date = NOW() WHERE sr_id = ?");
        $stmt2->bind_param('siisssisi', $ir_docno, $qty_ok, $qty_ng, $sorting_method, $rework_method, $remarks, $s_pendReview_id, $session_id, $sr_id);
        $stmt2->execute();
        
    }
    else { //for return SR and resubmit
        
        // 2. Update inspection_sorting
        $stmt2 = $db_con->prepare("UPDATE inspection_sorting SET sr_qty_ok = ?, sr_qty_ng = ?, sr_sorting_method = ?, sr_rework_method = ?, 
                                    sr_remarks = ?, sr_status = ?, submitted_by = ?, submitted_date = NOW() WHERE sr_id = ?");
        $stmt2->bind_param('iisssisi', $qty_ok, $qty_ng, $sorting_method, $rework_method, $remarks, $s_pendReview_id, $session_id, $sr_id);
        $stmt2->execute();
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
            $targetPath = "gallery/inspection_sorting/after/" .$sr_id. "/" . $filename;

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
    $stmt5->bind_param('ii', $s_pendReview_id, $ir_id);
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

    // $sql = "
    //         SELECT DISTINCT 
    //             E.staff_name,
    //             E.staff_email
    //         FROM user_authorization A
    //         INNER JOIN employee_details E 
    //             ON E.staff_id = A.staff_id
    //         WHERE A.section = ?
    //         AND A.task = ?
    //         AND A.auto_status = 'AC'
    //     ";

    // $stmt = $db_con->prepare($sql);
    // $stmt->bind_param("ss", $uSection, $nextTask);
    // $stmt->execute();
    // $result = $stmt->get_result();

    // $recipients = [];
    // while ($row = $result->fetch_assoc()) {
    //     if (!empty($row['staff_email'])) {
    //         $recipients[] = $row;
    //     }
    // }

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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_pendReview_id, $ir_docno, $inspectiondet['ir_shift'], $inspectiondet['inspect_date'], $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    //submitter = user login
    $submitter_name  = $stf_name;
    $doc_no = $inspectiondet['sr_docno'];
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
        $mail->Subject =  $esubject_5;

        $mail->Body = "<h4>Dear {$authouser['staff_name']},</h4>";
        $mail->Body .= "<p>A new sorting report (<strong>Doc No: $doc_no </strong>) has been submitted by $submitter_name and requires your review. </p>";
        $mail->Body .= "<p>Please log in to the system and review the submission at your earliest convenience.<br>";
        $mail->Body .= "<a href={$system_url}> {$system_url}</a></p>";

        $mail->Body .= "
                        <h4 style='color:#cc0000;'>Sorting Report Details</h4>
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
        "status" => "success",
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
    $rinsert5->bind_param("sssssssssss", $appsection, $apptask, $s_cancelled_id, $sr_docnocanc, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    echo json_encode(['success' => true]);
    exit;
}

// ==========================================================
// DELETE PHOTO
// ==========================================================
if ($_POST['action'] == 'delete_before_photo') {

    $photo_id = intval($_POST['id']);
    $sr_id    = intval($_POST['sr_id']);

    // Step 1: Get filename
    $stmt = $db_con->prepare("
                SELECT before_photo 
                FROM inspection_sorting_before_photo 
                WHERE before_photoid = ?
            ");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $filename = $result['before_photo'];
        $filePath = __DIR__ . "/gallery/inspection_sorting/before/$sr_id/$filename";

        // Step 2: Delete file if exists
        if (file_exists($filePath)) unlink($filePath);

        // Step 3: Delete DB record
        $del = $db_con->prepare("
                    DELETE FROM inspection_sorting_before_photo 
                    WHERE before_photoid = ?
                ");
        $del->bind_param("i", $photo_id);
        $del->execute();
    }

    echo json_encode(["status" => "success"]);
    exit;
}

if ($_POST['action'] == 'delete_after_photo') {

    $photo_id = intval($_POST['id']);
    $sr_id    = intval($_POST['sr_id']);

    // Step 1: Get filename
    $stmt = $db_con->prepare("
                SELECT after_photo 
                FROM inspection_sorting_after_photo 
                WHERE after_photoid = ?
            ");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $filename = $result['after_photo'];
        $filePath = __DIR__ . "/gallery/inspection_sorting/after/$sr_id/$filename";

        // Step 2: Delete file if exists
        if (file_exists($filePath)) unlink($filePath);

        // Step 3: Delete DB record
        $del = $db_con->prepare("
                    DELETE FROM inspection_sorting_after_photo
                    WHERE after_photoid = ?
                ");
        $del->bind_param("i", $photo_id);
        $del->execute();
    }

    echo json_encode(["status" => "success"]);
    exit;
}

?>