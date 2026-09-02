<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include '../shift.php';

if($_POST['action'] == 'sorting_details')
{
    $docno = $_POST['docno'];

    $sql = "SELECT 
                S.sr_id, S.sr_docno, S.sr_docnocancel, S.sr_qty_ok, S.sr_qty_ng,
                S.sr_sorting_method, S.sr_rework_method, S.sr_remarks,
                S.sr_status, S.created_date, S.submitted_date, S.approved_date, S.reviewed_date, S.cancelled_date, S.returned_date,
                S.approved_by, S.reviewed_by, S.returned_by, S.cancelled_by, 
                S.approved_remark, S.cancel_remark, S.returned_remark, 
                E.short_name as createby, ES.short_name as submitby, EA.short_name as approvalby, EW.short_name as reviewby, 
                EC.short_name as cancelby, ER.short_name as returnby,
                t.statusname
            FROM inspection_sorting S
            LEFT JOIN system_status t ON S.sr_status = t.statusid            
            LEFT JOIN employee_details AS E ON S.created_by = E.staff_id
            LEFT JOIN employee_details AS ES ON S.submitted_by = ES.staff_id
            LEFT JOIN employee_details AS EA ON S.approved_by = EA.staff_id
            LEFT JOIN employee_details AS EW ON S.reviewed_by = EW.staff_id
            LEFT JOIN employee_details AS EC ON S.cancelled_by = EC.staff_id
            LEFT JOIN employee_details AS ER ON S.returned_by = ER.staff_id 
            WHERE S.sr_docno = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("s", $docno);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $sr_id = $row['sr_id'];

    //photo
    $beforeHtml = '';
    $sqlbefore = "SELECT before_photo FROM inspection_sorting_before_photo WHERE sr_sorting_id = ? ";
    $stmtbefore = $db_con->prepare($sqlbefore);
    $stmtbefore->bind_param("i", $sr_id);
    $stmtbefore->execute();
    $resbefore = $stmtbefore->get_result();

    $beforeHtml .= '<div class="avatar-list avatar-list-stacked">';
    while ($before = $resbefore->fetch_assoc()) {

        $beforeUrl = 'gallery/inspection_sorting/before/' .$sr_id. '/' .$before['before_photo'];
        $beforeHtml .= '<a href="javascript:void(0);" data-src="'.$beforeUrl.'" data-full="'.$beforeUrl.'">
                            <img src="'.$beforeUrl.'" class="avatar avatar-md rounded-circle zoomable-img" alt="" />
                        </a>';
    }
    $beforeHtml .= '</div>';

    if ($resbefore->num_rows === 0) $beforeHtml = '<span class="text-muted">-</span>';

    //Fetch comparison photos
    $afterHtml = '';
    $sqlafter = "SELECT after_photo FROM inspection_sorting_after_photo WHERE sr_sorting_id = ? ";
    $stmtafter = $db_con->prepare($sqlafter);
    $stmtafter->bind_param("i", $sr_id);
    $stmtafter->execute();
    $resafter = $stmtafter->get_result();

    $afterHtml .= '<div class="avatar-list avatar-list-stacked">';
    while ($after = $resafter->fetch_assoc()) {
        $afterUrl = 'gallery/inspection_sorting/after/' .$sr_id. '/' .$after['after_photo'];
        $afterHtml .= '<a href="javascript:void(0);" data-src="'.$afterUrl.'" data-full="'.$afterUrl.'">
                            <img src="'.$afterUrl.'" class="avatar avatar-md rounded-circle zoomable-img" alt="" />
                        </a>';
    }
    $afterHtml .= '</div>';

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
    if ($row['approved_date'] != '0000-00-00 00:00:00') {        
        $approved_Dt = date("j M Y", strtotime($row['approved_date'])) . ' | ' . date("h:i A", strtotime($row['approved_date']));
        $approved_by = 'by '.$row['approvalby'];
        $approved_remark = $row['approved_remark'];
        
        if (!empty($row['approved_remark'])):
            $approved_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark-sr"
                data-remark="'.$approved_remark.'"
                role="button">
                </i>
            </small>';
        endif; 
        
    }
    else
    {
        $approved_Dt = '-';
        $approved_by = '';
        $approved_remark = '';
        $approved_icon = "";
    }
 

    //Cancelled date
    $cancelled_icon = "";
    if ($row['cancelled_date'] != '0000-00-00 00:00:00') {
        $cancelled_Dt = date("j M Y", strtotime($row['cancelled_date'])) . ' | ' . date("h:i A", strtotime($row['cancelled_date']));
        $cancelled_by = 'by '.$row['cancelby'];
        $cancelled_remark = $row['cancel_remark'];
        $cancelled_docno = $row['sr_docnocancel'];

        if (!empty($row['cancel_remark'])):
            $cancelled_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark-sr"
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
        $cancelled_icon = "";
    }

    //Returned date
    $returned_icon = '';
    if ($row['returned_date'] != '0000-00-00 00:00:00') {
        $returned_Dt = date("j M Y", strtotime($row['returned_date'])) . ' | ' . date("h:i A", strtotime($row['returned_date']));
        $returned_by = 'by '.$row['returnby'];
        $returned_remark = $row['returned_remark'];

        if (!empty($row['returned_remark'])):
            $returned_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark-sr"
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

    echo '
        <div class="row">
          
            <div class="d-md-flex d-none flex-wrap mb-3">
                <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
                    <div class="avatar avatar-md style-1 bg-oren-light text-black rounded d-flex align-items-center justify-content-center">                                                       
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                        <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
                        </svg>
                    </div>
                    <div class="clearfix ms-2">
                        <h3 class="mb-0 fw-semibold lh-1 fs-16">'.$row['sr_qty_ok'].'</h3>
                        <span class="fs-13">Qty OK</span>
                    </div>
                </div>
                <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
                    <div class="avatar avatar-md style-1 bg-oren-light text-black rounded d-flex align-items-center justify-content-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                        <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                    </div>
                    <div class="clearfix ms-2">
                        <h3 class="mb-0 fw-semibold lh-1 fs-16">'.$row['sr_qty_ng'].'</h3>
                        <span class="fs-13">Qty NG</span>
                    </div>
                </div>
                <div class="clearfix mt-0 mt-xl-0 ms-auto d-flex flex-column col-xl-3">
                    <div class="clearfix mb-3 text-xl-end">
                        <span class="badge badge-pill badge-dark-2">'.$row['statusname'].'</span>
                    </div>
                </div>
            </div>

             <div class="row g-4 mt-2">

                <!-- ========================================== -->
                <!-- LEFT COLUMN -->
                <!-- ========================================== -->
                <div class="col-md-6">

                    <div class="s2w-section">
                        <h6 class="section-title">
                            <i class="fa fa-sync-alt"></i> Sorting Method 
                        </h6>
                        <p class="content-info">'.$row['sr_sorting_method'].'</p>
                    </div>

                    <div class="s2w-section">
                        <h6 class="section-title">
                            <i class="fa fa-tools"></i> Rework Method
                        </h6>
                        <p class="content-info">'.$row['sr_rework_method'].'</p>
                    </div>

                    <div class="s2w-section">
                        <h6 class="section-title">
                            <i class="fa fa-comment-alt"></i> Remarks
                        </h6>
                        <p class="content-info">'.$row['sr_remarks'].'</p>
                    </div>

                </div>

                <!-- ========================================== -->
                <!-- RIGHT COLUMN -->
                <!-- ========================================== -->
                <div class="col-md-6">

                    <div class="s2w-section">
                        <h6 class="section-title">
                            <i class="fa fa-image"></i> Photos Before (NG)
                        </h6>

                        <div class="photo-box"> '.$beforeHtml.' </div>
                    </div>

                    <div class="s2w-section">
                        <h6 class="section-title">
                            <i class="fa fa-image"></i> Photos After Sorting (OK)
                        </h6>

                        <div class="photo-box"> '.$afterHtml.' </div>
                    </div>

                </div>

            </div>
        </div>';    

}

?>