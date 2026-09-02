<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include '../shift.php';

if($_POST['action'] == 'inspection_details')
{
    $docno = $_POST['docno'];

    $sql = "SELECT I.ir_id, I.ir_docno, I.ir_docnocancel, I.ir_pallet_no, I.ir_result, I.ir_status, I.ir_shift, I.prod_date,
            I.created_date, I.submitted_date, I.approved_date, I.reviewed_date, I.cancelled_date, I.returned_date,
            I.approved_by, I.reviewed_by, I.returned_by, I.approved_remark, I.reviewed_remark, I.cancel_remark, I.returned_remark, 
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
                                <thead>
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

                    $photoUrl = 'gallery/inspection/defect/' .$ir_id. '/' .$photo['defect_photo'];
                    $photoHtml .= '<a href="javascript:void(0);" data-src="'.$photoUrl.'" data-full="'.$photoUrl.'">
                                        <img src="'.$photoUrl.'" class="avatar avatar-md rounded-circle zoomable-img" alt="" />
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
                    $compareUrl = 'gallery/inspection/defect_compare/' .$ir_id. '/' .$compare['compare_photo'];
                    $compareHtml .= '<a href="javascript:void(0);" data-full="'.$compareUrl.'">
                                        <img src="'.$compareUrl.'" class="avatar avatar-md rounded-circle zoomable-img" alt="" />
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
    $approved_icon = "";
    if ($row['reviewed_date'] != '0000-00-00 00:00:00' || $row['approved_date'] != '0000-00-00 00:00:00') {
        if($row['ir_result'] === 'OK')
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

    }
    else
    {
        $approved_Dt = '-';
        $approved_by = '';
        $approved_remark = '';
        $approved_icon = '';
    }

    //Cancelled date
    $cancelled_icon = "";
    if ($row['cancelled_date'] != '0000-00-00 00:00:00') {
        $cancelled_Dt = date("j M Y", strtotime($row['cancelled_date'])) . ' | ' . date("h:i A", strtotime($row['cancelled_date']));
        $cancelled_by = 'by '.$row['cancelby'];
        $cancelled_remark = $row['cancel_remark'];
        $cancelled_docno = $row['ir_docnocancel'];

        if (!empty($row['cancel_remark'])):
            $cancelled_icon = '<small class="table-tip d-inline-flex align-items-center text-primary timeline-title-remark">
                <i class="fa fa-info-circle p-1"
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
                            <span class="badge bg-redd text-black fs-semibold px-3 py-2">'.$row["statusname"].'</span></br>
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
                            <p class="text-muted mb-0 mt-2">Production Date</p>
                            <p class="fw-semibold text-primary">'.date("d-m-Y", strtotime($row['prod_date'])).'</p>
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
                    <div class="card-header card-header-timeline py-3 d-block d-sm-flex">
                        <h4 class="heading-timeline mb-0">Timeline</h4>
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
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$approved_remark.' ">Reviewed Date</p>
                                    <span class="ms-0 fs-13">'.$approved_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$approved_by.'</span>' .$approved_icon.' 
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
                                    <span class="ms-0 fs-13 bold text-danger">'.$cancelled_docno.'</span>
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