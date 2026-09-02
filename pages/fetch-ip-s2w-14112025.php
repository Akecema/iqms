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

    if (!empty($_POST['fd_shift'])) {
        $shift = mysqli_real_escape_string($db_con, $_POST['fd_shift']);
        $query .= " AND I.ir_shift = '$shift' ";
    }

    if (!empty($_POST['fd_status'])) {
        $status = intval($_POST['fd_status']);
        $query .= " AND I.ir_status = '$status' ";
    }

    // Filter: result
    if (!empty($_POST['fd_result'])) {
        $result = mysqli_real_escape_string($db_con, $_POST['fd_result']);
        $query .= " AND I.ir_result = '$result' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);
       
        // Combine: subquery filter + multi-column search
        // $query .= " AND (
        //             -- 1. Match sr_docno in sorting (exclude status 1 & 13)
        //             I.ir_id IN (
        //                 SELECT sr_ir_id 
        //                 FROM inspection_records 
        //                 WHERE ir_docno LIKE '%$search%' 
        //                 AND sr_status != 1 
        //                 AND sr_status != 13
        //             )

        //             -- 2. OR match other columns (joined fields)
        //             OR U.statusname LIKE '%$search%'
        //             OR T.modcode LIKE '%$search%'
        //             OR P.typemodel LIKE '%$search%'
        //             OR P.typeside LIKE '%$search%'
        //             OR M.matno LIKE '%$search%'
        //             OR M.matdesc LIKE '%$search%'
        //             OR H.shiftdesc LIKE '%$search%'
        //         ) ";      
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
        $q_sr->bind_result($sr_docno, $sr_status);
        if ($q_sr->fetch()) {
            if ($sr_status != 1 && $sr_status != 8 && $sr_status != 13) {
                $display_docno = $sr_docno;
            } else {
                $display_docno = ''; // hide docno if status 1 or 13
            }
        }
        $q_sr->close();

        $sub_array = [];
     
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" 
                                data-docno="'.$row["ir_docno"].'" title="Click to view details"><span class="fs-14">'.$row["ir_docno"].'<br>'.$row["ir_id"].'</span>
                            </a>
                        </div>';
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
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["typeside"].')'.'</span>
                        </div>'; 
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$isnpectiondate.'</span></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].$row["sr_id"].'</span></div>';
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
// VIEW DETAILS MODAL
// ==========================================================
if($_POST['action'] == 'inspection_details')
{
    $docno = $_POST['docno'];

    $sql = "SELECT I.ir_id, I.ir_docno, I.ir_docnocancel, I.ir_pallet_no, I.ir_result, I.ir_status, I.ir_shift,
            I.created_date, I.submitted_date, I.approved_date, I.reviewed_date, I.cancelled_date, I.returned_date,
            I.approved_by, I.reviewed_by, I.returned_by, I.approved_remark, I.cancel_remark, I.returned_remark, 
            T.modcode, P.typemodel, P.typeside, M.matno, M.matdesc, H.shiftdesc, H.shiftbadge, S.statusname,
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

                $photoHtml .= '<div class="avatar-list avatar-list-inline">';
                while ($photo = $resPhoto->fetch_assoc()) {

                    $photoUrl = 'gallery/inspection/defect/'. $photo['defect_photo'];
                    $photoHtml .= '<a href="javascript:void(0);" class="viewAvatar" data-full="'.$photoUrl.'">
                                        <img src="'.$photoUrl.'" class="avatar avatar-md rounded-circle" alt="" />
                                    </a>';
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

                $compareHtml .= '<div class="avatar-list avatar-list-inline">';
                while ($compare = $resCompare->fetch_assoc()) {
                    $compareUrl = 'gallery/inspection/defect_compare/'. $compare['compare_photo'];
                    $compareHtml .= '<a href="javascript:void(0);" class="viewAvatar" data-full="'.$compareUrl.'">
                                        <img src="'.$compareUrl.'" class="avatar avatar-md rounded-circle" alt="" />
                                    </a>';
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
    if ($row['reviewed_date'] != '0000-00-00 00:00:00' || $row['approved_date'] != '0000-00-00 00:00:00') {
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
                            <p class="fw-semibold text-primary">'.$row["modcode"].' ('.$row["typeside"].')'.'</p>
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
if ($_POST['action'] == 'add_s2w') {

    if (!empty($_POST['send_dept'])) {
        
        $ir_id      = intval($_POST['ir_id']);
        $sr_id      = intval($_POST['sr_id']);
        $add_info   = trim($_POST['add_info']);
        $send_dept  = intval($_POST['send_dept']);
     
        // update S2W status n table inspection records & sorting
        // $stmt = $db_con->prepare("UPDATE inspection_records SET ir_s2w_status = ? WHERE ir_id = ?");
        // $stmt->bind_param('ii', $s_draft_id, $ir_id);
        // $stmt->execute();

        // $stmtSR = $db_con->prepare("UPDATE inspection_sorting SET sr_s2w_status = ? WHERE sr_id = ?");
        // $stmtSR->bind_param('ii', $s_draft_id, $sr_id);
        // $stmtSR->execute();
        
        // Insert main record
        $stmt = $db_con->prepare("INSERT INTO inspection_s2w
                    (s2w_ir_id, s2w_sr_id, s2w_additional_desc, s2w_send_to, s2w_status, created_by, created_date) 
                    VALUES (?, ?, ?, ?, ?, ?, NOW())");
        $stmt->bind_param("iisiis", $ir_id, $sr_id, $add_info, $send_dept, $s_draft_id, $session_id);

        if ($stmt->execute()) {

            $insert_id = $stmt->insert_id;

            // Define the folder path
            $folderPath = __DIR__ . "/gallery/s2w/defect/" . $insert_id;

            // Create folder if it doesn’t exist
            if (!is_dir($folderPath)) {
                mkdir($folderPath, 0755, true); // recursive creation
            }

            // BEFORE PHOTOS
            if (!empty($_FILES['defect_photo_s2w']['name'][0])) {
                foreach ($_FILES['defect_photo_s2w']['tmp_name'] as $i => $tmp_name) {
                    if ($_FILES['defect_photo_s2w']['error'][$i] === 0) {
                        $filename = uniqid() . '_' . str_replace(' ', '_', basename($_FILES['defect_photo_s2w']['name'][$i]));
                        $targetFile = $folderPath . "/" . $filename;

                        if (move_uploaded_file($tmp_name, $targetFile)) {
                            $stmtPhoto = $db_con->prepare("INSERT INTO inspection_s2w_defect_photo 
                                (s2w_ir_id, s2w_sr_id, s2w_id, defect_photo, created_by, created_date) 
                                VALUES (?, ?, ?, ?, ?, NOW())");
                            $stmtPhoto->bind_param("iiiss", $ir_id, $sr_id, $insert_id, $filename, $session_id);
                            $stmtPhoto->execute();
                        }
                        else {
                            error_log("Upload failed: " . $tmp_name . " to " . $targetFile);
                        }
                    }
                }
            }

            echo json_encode([
                "status" => "success",
                "message" => "S2W record saved successfully.",
                "insert_id" => $insert_id,
                "ir_id" => $ir_id,                
                "sr_id" => $sr_id,
                "s2w_status" => $s_draft_id
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
if ($_POST['action'] == 'get_s2w_details') {

    $sr_id = intval($_POST['sr_id']);

    // 1. Get the latest sorting record (if exists)
    $stmt = $db_con->prepare("SELECT 
                                s.s2w_ir_id,
                                s.s2w_id,
                                s.s2w_docno,
                                s.s2w_additional_desc,
                                s.s2w_send_to,
                                s.s2w_status,
                                t.statusname
                                FROM inspection_s2w s   
                                LEFT JOIN system_status t ON s.s2w_status = t.statusid 
                                WHERE s.s2w_sr_id = ? and s.s2w_status != ? LIMIT 1");
    $stmt->bind_param("ii", $sr_id, $s_cancelled_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $s2w_rcd = $result->fetch_assoc(); 

    // 3. Prepare default response
    $response = [
        "status" => "success",
        "data" => [
            "ir_id" => $s2w_rcd['s2w_ir_id'] ?? null,
            "sr_id" => $sr_id ?? null,
            "s2w_id" => $s2w_rcd['s2w_id'] ?? null,
            "s2w_docno" => $s2w_rcd['s2w_docno'] ?? null,
            "s2w_additional_desc" => $s2w_rcd['s2w_additional_desc'] ?? null,
            "s2w_send_to" => $s2w_rcd['s2w_send_to'] ?? null,
            "s2w_status" => $s2w_rcd['s2w_status'] ?? null, 
            "sr_statusname" => $s2w_rcd['statusname'] ?? null,
            "photo_defect" => []
        ]
    ];

    // 4. If sorting record exists, load photos
    if (!empty($s2w_rcd)) {
        $photo_defect = [];
        $q1 = $db_con->prepare("SELECT defect_photoid, defect_photo 
                                FROM inspection_s2w_defect_photo
                                WHERE s2w_id = ?");
        $q1->bind_param("i", $s2w_rcd['s2w_id']);
        $q1->execute();
        $r1 = $q1->get_result();
        while ($p = $r1->fetch_assoc()) {
            $photo_defect[] = [
                "id" => $p['defect_photoid'],
                "file" => $p['defect_photo']
            ];
        }

        $response['data']['photo_defect'] = $photo_defect;
    }

    echo json_encode($response);
}

// ==========================================================
// UPDATE SORTING RECORD
// ==========================================================
if ($_POST['action'] == 'update_s2w') {

    $ir_id      = intval($_POST['ir_id']);
    $sr_id      = intval($_POST['sr_id']);
    $s2w_id     = intval($_POST['s2w_id']);
    $add_info   = trim($_POST['add_info']);
    $send_dept  = intval($_POST['send_dept']);

    // --- Update main sorting info ---
    $stmt = $db_con->prepare("UPDATE inspection_s2w 
                              SET s2w_additional_desc = ?, s2w_send_to = ?, updated_by = ?, updated_date = NOW() 
                              WHERE s2w_sr_id = ? AND s2w_id = ?");
    $stmt->bind_param("sisii", $add_info, $send_dept, $session_id, $sr_id, $s2w_id);

    // Execute main update
    if (!$stmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Update failed: " . $stmt->error]);
        exit;
    }

    // --- DEFECT photos (NG) ---
    if (!empty($_FILES['defect_photo_s2w']['name'][0])) {
        foreach ($_FILES['defect_photo_s2w']['tmp_name'] as $idx => $tmp) {
            $original_name = basename($_FILES['defect_photo_s2w']['name'][$idx]);
            $filename = uniqid() . '_' . $original_name;
            $targetPath = __DIR__ ."/gallery/s2w/defect/" . $s2w_id . "/" . $filename;

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
                $stmt2 = $db_con->prepare("INSERT INTO inspection_s2w_defect_photo (s2w_ir_id, s2w_sr_id, s2w_id, defect_photo, created_by, created_date) VALUES (?, ?, ?, ?, ?, NOW())");
                $stmt2->bind_param("iiiss", $ir_id, $sr_id, $s2w_id, $filename, $session_id);
                $stmt2->execute();
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
            $original_name = basename($_FILES['defect_photo_s2w']['name'][$idx]);
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