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

// All records
if($_POST['action'] == 'fetch_records_list_all')
{
    $igroup = $_POST['igroup'] ?? '';

    $columns = array('SR.rp_s2w_docno', 'M.matno', 'P.modcode', 'SR.rp_s2w_status');

    // Base FROM and WHERE
    $sql_base = " FROM inspection_s2w_report AS SR
                    LEFT JOIN inspection_s2w AS S ON SR.rp_s2w_id = S.s2w_id
                    LEFT JOIN inspection_records AS I ON SR.rp_s2w_ir_id = I.ir_id
                    LEFT JOIN model_details AS T ON I.ir_model = T.modid
                    LEFT JOIN model_type AS P ON I.ir_type = P.typeid
                    LEFT JOIN material_header AS M ON I.ir_material = M.matid 
                    LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
                    WHERE SR.rp_s2w_status = 5 ";
    
    if ($session_role == 4) {
        // Restrict to only their own records
        $sql_base .= " AND SR.created_by = '$session_id' ";
    }

    if (!empty($_POST['fd_model'])) {
        $model = intval($_POST['fd_model']);
        $sql_base .= " AND I.ir_model = '$model' ";
    }

    if (!empty($_POST['fd_type'])) {
        $type = intval($_POST['fd_type']);
        $sql_base .= " AND I.ir_type = '$type' ";
    }

    if (!empty($_POST['fd_material'])) {
        $material = intval($_POST['fd_material']);
        $sql_base .= " AND I.ir_material = '$material' ";
    }

    if (!empty($_POST['fd_daterange'])) {
        $daterange = $_POST['fd_daterange'];
        $dates = explode(' - ', $daterange);
        if (count($dates) == 2) {
            $start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
            $end_date = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
            $sql_base .= " AND DATE(I.inspect_date) BETWEEN '$start_date' AND '$end_date' ";
        }
    }
    // else {
    //     // Default to today's inspection date if no daterange is selected
    //     $sql_base .= " AND DATE(I.inspect_date) = CURDATE() ";
    // }

    // Shift Logic: Filter overrides default (no default shift restriction as per user request to combine D&N)
    if (!empty($_POST['fd_shift'])) {
        $shift = mysqli_real_escape_string($db_con, $_POST['fd_shift']);
        $sql_base .= " AND I.ir_shift = '$shift' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);
        $sql_base .= " AND SR.rp_s2w_docno LIKE '%$search%' ";
    }

    // Calculate Totals (OK/NG) based on the filtered result set
    $queryCount = "SELECT 
                    SUM(CASE WHEN I.ir_result = 'OK' THEN 1 ELSE 0 END) as total_ok,
                    SUM(CASE WHEN I.ir_result = 'NG' THEN 1 ELSE 0 END) as total_ng
                   " . $sql_base;
    $resCount = mysqli_query($db_con, $queryCount);
    $rowCount = mysqli_fetch_assoc($resCount);
    $total_ok = $rowCount['total_ok'] ?? 0;
    $total_ng = $rowCount['total_ng'] ?? 0;


    // Main Query
    $query = "SELECT SR.rp_id, SR.rp_s2w_id, SR.rp_s2w_ir_id, SR.rp_s2w_docno, SR.rp_s2w_status, SR.created_date,
                     SR.rp_s2w_send_to, 
                     I.ir_id, I.ir_docno, I.ir_model, I.ir_material, I.ir_pallet_no, I.ir_result, I.ir_status AS ir_record_status,
                     I.inspect_date, I.shift_date, DATE_FORMAT(I.prod_date,'%d-%m-%Y') AS prod_date, 
                     I.inspect_group, I.ir_shift, 
                     T.modcode, P.typemodel, M.partside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc, H.shiftbadge " . $sql_base;

    // Ordering
    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order'][0]['column'];
        $colDir   = $_POST['order'][0]['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= " ORDER BY SR.rp_s2w_docno desc"; // default sort by sorting docno
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
        $ids[] = $row['ir_id'];
    }

    // Default empty map
    $defectMap = [];
    if (!empty($ids)) {
        $idList = implode(",", array_map('intval', $ids));
        $sqlDef = "SELECT rcd_ir_id, COUNT(*) AS defect_count 
                FROM inspection_defect 
                WHERE rcd_ir_id IN ($idList)
                GROUP BY rcd_ir_id";
        $resDef = mysqli_query($db_con, $sqlDef);
        while($d = mysqli_fetch_assoc($resDef)) {
            $defectMap[$d['rcd_ir_id']] = (int)$d['defect_count'];
        }
    }

    $data = [];

    foreach ($records as $row) {

        $irid = $row['ir_id'];
        $rp_id = $row['rp_id'];
        $s2wid = $row['rp_s2w_id'];
        $srStatus = $row['rp_s2w_status'];
        $has_defect = !empty($defectMap[$irid]) && $defectMap[$irid] > 0;

        // Correction Photos
        $correctionHtml = '';
        $sqlCr = "SELECT correction_photo FROM inspection_s2w_correction_photo WHERE s2w_rp_id = $rp_id";
        $resCr = mysqli_query($db_con, $sqlCr);
        if ($resCr && mysqli_num_rows($resCr) > 0) {
            $correctionHtml .= '<div class="avatar-list avatar-list-stacked">';
            while ($p = mysqli_fetch_assoc($resCr)) {
                $photoUrl = 'gallery/inspection_s2w_report/photo_correction/' . $rp_id . '/' . $p['correction_photo'];
                $correctionHtml .= '<img src="'.$photoUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:30px;height:30px; cursor:pointer;">';
            }
            $correctionHtml .= '</div>';
        } else {
            $correctionHtml = '<span class="text-muted fs-12">-</span>';
        }

        // Preventive Photos
        $preventiveHtml = '';
        $sqlPr = "SELECT preventive_photo FROM inspection_s2w_preventive_photo WHERE s2w_rp_id = $rp_id";
        $resPr = mysqli_query($db_con, $sqlPr);
        if ($resPr && mysqli_num_rows($resPr) > 0) {
            $preventiveHtml .= '<div class="avatar-list avatar-list-stacked">';
            while ($p = mysqli_fetch_assoc($resPr)) {
                $photoUrl = 'gallery/inspection_s2w_report/photo_preventive/' . $rp_id . '/' . $p['preventive_photo'];
                $preventiveHtml .= '<img src="'.$photoUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:30px;height:30px; cursor:pointer;">';
            }
            $preventiveHtml .= '</div>';
        } else {
            $preventiveHtml = '<span class="text-muted fs-12">-</span>';
        }

        $sub_array = [];
        
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="fs-14 fw-semibold">'.$row["rp_s2w_docno"].'</h6></div>';
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
        $sub_array[] = '<div class="clearfix ms-2">'.$correctionHtml.'</div>';
        $sub_array[] = '<div class="clearfix ms-2">'.$preventiveHtml.'</div>';
        $sub_array[] = '<div class="d-flex align-items-center gap-2"><button type="button" class="btn btn-primary btn-sm viewDetails" data-irid="'.$irid.'">View</button></div>';

        $data[] = $sub_array;
    }

    $output = array(
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $number_filter_row,
        "recordsFiltered" => $number_filter_row,
        "total_ok"        => $total_ok,
        "total_ng"        => $total_ng,
        "data"            => $data
    );

    echo json_encode($output);
}

// View details in Modal
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

                    $photoUrl = 'gallery/inspection/defect/' .$ir_id. '/' . $photo['defect_photo'];
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
                    $compareUrl = 'gallery/inspection/defect_compare/' .$ir_id. '/' . $compare['compare_photo'];
                    $compareHtml .= '<img src="'.$compareUrl.'" data-src="'.$compareUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $compareHtml .= '</div>';

                if ($resCompare->num_rows === 0) $compareHtml = '<span class="text-muted">-</span>';

                // Defect row
                $ng_html .= '
                    <tr>
                        <td>xx</td>
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
    $approved_icon = "";
    if($row['ir_result'] === 'OK')
    {
        $approved_Dt = date("j M Y", strtotime($row['approved_date'])) . ' | ' . date("h:i A", strtotime($row['approved_date']));
        $approved_by = 'by '.$row['approvalby'];
        $approved_remark = $row['approved_remark'];
        
        if (!empty($row['approved_remark'])):
            $approved_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark"
                data-remark="'.$approved_remark.'"
                role="button">
                </i>
            </small>';
        endif;       
    }
    else
    {
        $approved_Dt = date("j M Y", strtotime($row['reviewed_date'])) . ' | ' . date("h:i A", strtotime($row['reviewed_date']));
        $approved_by = 'by '.$row['reviewby'];            
        $approved_remark = $row['reviewed_remark'];

        if (!empty($row['reviewed_remark'])):
            $approved_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark"
                data-remark="'.$approved_remark.'"
                role="button">
                </i>
            </small>';
        endif;
    }
    

    //Cancelled date
    $cancelled_icon = "";
    if ($row['cancelled_date'] != '0000-00-00 00:00:00') {
        $cancelled_Dt = date("j M Y", strtotime($row['cancelled_date'])) . ' | ' . date("h:i A", strtotime($row['cancelled_date']));
        $cancelled_by = 'by '.$row['cancelby'];
        $cancelled_remark = $row['cancel_remark'];
        $cancelled_docno = '#'.$row['ir_docnocancel'];

        if (!empty($row['cancel_remark'])):
            $cancelled_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark"
                data-remark="'.$cancelled_remark.'"
                role="button">
                </i>
            </small>';
        endif;
    }
    else
    {
        $cancelled_Dt = '-';
        $cancelled_by = '';
        $cancelled_remark = '';
        $cancelled_docno = '';
        $cancelled_icon = '';
    }

    //Returned date
    $returned_icon = '';
    if ($row['returned_date'] != '0000-00-00 00:00:00') {
        $returned_Dt = date("j M Y", strtotime($row['returned_date'])) . ' | ' . date("h:i A", strtotime($row['returned_date']));
        $returned_by = 'by '.$row['returnby'];
        $returned_remark = $row['returned_remark'];

        if (!empty($row['returned_remark'])):
            $returned_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark"
                data-remark="'.$returned_remark.'"
                role="button">
                </i>
            </small>';
        endif;
    }
    else
    {
        $returned_Dt = '-';
        $returned_by = '';
        $returned_remark = '';
        $returned_icon = '';
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
                                <div class="timeline-content">ccccccc
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$approved_remark.' ">Approved Date</p>
                                    <span class="ms-0 fs-13">'.$approved_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$approved_by. '</span>' .$approved_icon .'

                                    
                                </div>
                            </div>
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-times"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$cancelled_remark.'">Cancelled Date</p>
                                    <span class="ms-0 fs-13">'.$cancelled_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$cancelled_by.'</span>' .$cancelled_icon .'</br>
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
                                    <span class="ms-0 fs-13">'.$returned_by.'</span> '.$returned_icon.'
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

?>