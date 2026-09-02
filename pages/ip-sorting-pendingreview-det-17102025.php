<!-- System title -->
<?php include "../system-header.php";?>

<!-- Session start -->
<?php include "session-start.php"; ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <!--Title-->
	<title><?php echo $syst_title; ?> </title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">

	<!-- MOBILE SPECIFIC -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="../icon/favicon.ico">
    
	<link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="vendor/select2/css/select2.min.css">
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link class="main-css" href="css/style.css" rel="stylesheet">
    <link class="main-css" href="css/add-style.css" rel="stylesheet">
	
    <!-- Tagify Css -->
	<link href="vendor/tagify/dist/tagify.css" rel="stylesheet">	
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
    
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    
	<!-- Daterange picker -->
    <link href="vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Clockpicker -->
    <link href="vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <!-- asColorpicker -->
    <link href="vendor/jquery-ascolorpicker/css/ascolorpicker.min.css" rel="stylesheet">
    <!-- Material color picker -->
    <link href="vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
	
    <!-- Pick date -->
    <link rel="stylesheet" href="vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="vendor/pickadate/themes/default.date.css">
    
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">

</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
		<div>
			
            <?php //
            // include 'loading-images.php'; ?>

		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            
            <?php include 'nav-hdr-logo.php'; ?>

        </div>
        <!--**********************************
            Nav header end
        ***********************************-->
		
		<!--**********************************
            Chat box start
        ***********************************-->
		<div class="chatbox">
			<div class="chatbox-close"></div>
			
            <?php include 'nav-hdr-chat-box.php'; ?>

		</div>
		<!--**********************************
            Chat box End
        ***********************************-->
		
		<!--**********************************
            Header start
        ***********************************-->
		<div class="header">
            <div class="header-content">
                
            <?php include 'nav-hdr-top.php'; ?>

			</div>
		</div>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
		<div class="deznav">
            <div class="deznav-scroll">
				
                <?php include 'nav-left-sidebar.php'; ?>
                
			</div>
        </div>

        <style>

        .border-error {
            border: 2px solid #eb2020ff !important;   
            background-color: #faf7f9ff !important;
            color : #2D2E2D;   
        }

        .border-error:hover {
            color: #181818 !important;  
        }
        
        .dataTables_filter input {
            width: 180px !important; /* or any size you want */
            height: 35px !important;             /* optional */
            font-size: 11px !important;          /* optional */
        }

		#sortingPendingList tbody tr td:last-child {
            text-align: left !important; 
        }

        #sortingPendingList thead tr th:last-child{
            text-align: left !important;
        }

        #inspectionApprovedList tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionApprovedList thead tr th:last-child{
            text-align: left !important;
        }

        #inspectionCompletedList tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionCompletedList thead tr th:last-child{
            text-align: left !important;
        }

        /* table header, body align */
        #inspectionTable_defect tbody tr td:last-child {
            text-align: left; 
        }

        #inspectionTable_defect thead tr th:last-child {
            text-align: left !important; 
        }

        .date-table thead tr th{
            font-size: 12px; /* or 14px, 13px, etc. */
            background-color :#E9ECEF !important; 
        }

        .date-table td {
            font-size: 12px; /* or 14px, 13px, etc. */
        }

        .date-table td h6 {
            font-size: 12px;
        }

        .date-table td span {
            font-size: 12px;
        }

        #detailModal h5 {
            font-size: 13px;
        }

        #detailModal .table th {
            font-size: 13px;
        }

        #detailModal .table td {
            font-size: 13px;
        }

        #detailModal .s-date span {
            font-size: 10px;
        }

        .zoomable-img {
            cursor: pointer;       /* Show hand on hover */
            position: relative;    /* Make sure it's clickable */
            z-index: 10;           /* Bring it above wrappers */
            pointer-events: auto;  /* Ensure clicks pass through */
        }

        .bg-custom-header {
            background-color: #F2F5F0; 
            border-radius: 8px;
            padding: 10px;
            color: #333;
        }

        .bg-custom-foot {
            background-color: #F2F5F0; 
            color: #333;
        }
 
        .small-text {
            font-size: 11px; /* or 12px, etc. */
        }

        .doc-text {
            font-size: 12px; /* or 12px, etc. */
        }

       .widget-timeline-icons ul.timeline {
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        /* timeline  date activity */
        .timeline-entry {
            display: flex;
            align-items: start;
            position: relative;
            padding-left: 0.063rem;
        }

        .timeline-entry::before {
            content: "";
            position: absolute;
            top: 1.438rem;
            left: 0.938rem;
            height: 100%;
            width: 2px;
            background-color: #dee2e6;
            z-index: 0;
        }

        .timeline-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-size: 14px;
            z-index: 1;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .timeline-title-remark {
            cursor: pointer;       /* Show hand on hover */
        }

        #remarkModal .modal-dialog {
            margin-top: -140px;   /* adjust distance from top */
            margin-right: 50px;
        }

        .bg-light-green {
            background-color: #E5EDE4; /* soft green background */
            border-radius: 6px;
        }

        #remarkContent {
            white-space: pre-wrap; /* support long text and line breaks */
        }

        .tooltip .tooltip-inner {
            /* background-color: #333 !important;
            color: #fff; */
            max-width: 220px;
            white-space: pre-wrap;
        }

        .table-tip {
            font-size: 11px;
            margin-bottom: 6px;
            color: #6c757d;
        }

        .modal-header {
            border-bottom: none !important;
        }
         /* Sub-section title style */
        .section-title-sub {
            background: #f8f9fa;      /* light background */
            border-left: 4px solid #b30000; /* blue left border */
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        /* Floating button back  */
        .back-button {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
            width: 36px;
            height: 36px;
            padding: 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            background-color: #1d1e1eff;
            color: white;
        }
        .back-button:hover {
            background-color: #5b5e5dff;
            border-color: #5b5e5dff;
            color: white;
        }

        .avatar-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px; /* small spacing between photos */
        }

        .avatar-list img {
            display: inline-block;
            margin-right: -8px; /* create overlapping circle effect */
            border: 2px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .avatar-lg-custom {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        .zoomable-photo {
            cursor: pointer; /* shows hand cursor */
            transition: transform 0.15s ease-in-out;
        }

        .zoomable-photo:hover {
            transform: scale(2.05); /* optional: subtle zoom effect on hover */
        }

        #relatedPartDept thead th {
            font-size: 13px;
        }

        #relatedPartVendor thead th {
            font-size: 13px;
        }

        #relatedPartCustomer thead th {
            font-size: 13px;
        }

        #relatedPartDept tbody tr td:last-child {
            text-align: left !important; 
        }

        #relatedPartDept thead tr th:last-child{
            text-align: left !important;
        }

        #relatedPartVendor tbody tr td:last-child {
            text-align: left !important; 
        }

        #relatedPartVendor thead tr th:last-child{
            text-align: left !important;
        }

        textarea:disabled,
        textarea[readonly] {
            background-color: #FBFCFA !important;
            border-color: #d6d3d3ff !important;
            color: #999 !important;
            cursor: not-allowed;
        }

        </style>

        <?php

        $edocno = $_GET['docno'] ?? "";

        //get ir_id
        $stmt = $db_con->prepare("SELECT R.ir_id, S.sr_id, S.sr_status
                                    FROM inspection_sorting S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.sr_ir_id
                                            WHERE S.sr_docno = ?");
        $stmt->bind_param('s', $edocno);
        $stmt->execute();
        $sortingdet = $stmt->get_result()->fetch_assoc();
        
        $eir_id = $sortingdet['ir_id'];
        $esr_id = $sortingdet['sr_id'];
        $esr_status = $sortingdet['sr_status'];

        $stmt = $db_con->prepare("
                SELECT 
                    s.sr_id,
                    s.sr_docno,
                    s.sr_qty_ok,
                    s.sr_qty_ng,
                    s.sr_sorting_method,
                    s.sr_rework_method,
                    s.sr_remarks,
                    s.sr_ir_id,
                    s.created_date,
                    s.submitted_date,
                    s.approved_date,
                    s.reviewed_date,
                    s.cancelled_date,
                    s.returned_date,
                    s.approved_remark,
                    s.cancel_remark,
                    s.sr_docnocancel,
                    s.returned_remark,
                    s.reviewed_remark,

                    E.short_name  AS createby,
                    ES.short_name AS submitby,
                    EA.short_name AS approvalby,
                    EW.short_name AS reviewby,
                    EC.short_name AS cancelby,
                    ER.short_name AS returnby,

                    (SELECT GROUP_CONCAT(before_photo) 
                        FROM inspection_sorting_before_photo 
                        WHERE sr_sorting_id = s.sr_id) AS before_photos,

                    (SELECT GROUP_CONCAT(after_photo) 
                        FROM inspection_sorting_after_photo 
                        WHERE sr_sorting_id = s.sr_id) AS after_photos

                FROM inspection_sorting s
                LEFT JOIN employee_details AS E  ON s.created_by   = E.staff_id
                LEFT JOIN employee_details AS ES ON s.submitted_by = ES.staff_id
                LEFT JOIN employee_details AS EA ON s.approved_by  = EA.staff_id
                LEFT JOIN employee_details AS EW ON s.reviewed_by  = EW.staff_id
                LEFT JOIN employee_details AS EC ON s.cancelled_by = EC.staff_id
                LEFT JOIN employee_details AS ER ON s.returned_by  = ER.staff_id
                WHERE s.sr_docno = ?
                LIMIT 1
            ");

        $stmt->bind_param('s', $edocno);
        $stmt->execute();
        $sorting = $stmt->get_result()->fetch_assoc();

        if (!$sorting) {
            echo "<div class='alert alert-danger'>No sorting record found for this document.</div>";
            exit;
        }

        // Always show Created Date
        $created_Dt = date("j M Y", strtotime($sorting['created_date'])) . ' | ' . date("h:i A", strtotime($sorting['created_date']));
        $created_by = 'by '.$sorting['createby'];

        // Submit date
        if ($sorting['submitted_date'] != '0000-00-00 00:00:00') {
            $submitted_Dt = date("j M Y", strtotime($sorting['submitted_date'])) . ' | ' . date("h:i A", strtotime($sorting['submitted_date']));        
            $submitted_by = 'by '.$sorting['submitby'];
        }
        else
        {
            $submitted_Dt = '-';
            $submitted_by = '';
        }

        //Approved & Reviewed date
        if ($sorting['reviewed_date'] != '0000-00-00 00:00:00') {            
            $reviewed_Dt = date("j M Y", strtotime($sorting['reviewed_date'])) . ' | ' . date("h:i A", strtotime($sorting['reviewed_date']));
            $reviewed_by = 'by '.$sorting['reviewby'];            
            $reviewed_remark = $sorting['reviewed_remark'];
           
        }
        else
        {
            $reviewed_Dt = '-';
            $reviewed_by = '';
            $reviewed_remark = '';
        }

        //Cancelled date
        if ($sorting['cancelled_date'] != '0000-00-00 00:00:00') {
            $cancelled_Dt = date("j M Y", strtotime($sorting['cancelled_date'])) . ' | ' . date("h:i A", strtotime($sorting['cancelled_date']));
            $cancelled_by = 'by '.$sorting['cancelby'];
            $cancelled_remark = $sorting['cancel_remark'];
            $cancelled_docno = $sorting['ir_docnocancel'];
        }
        else
        {
            $cancelled_Dt = '-';
            $cancelled_by = '';
            $cancelled_remark = '';
            $cancelled_docno = '';
        }

        //Returned date
        if ($sorting['returned_date'] != '0000-00-00 00:00:00') {
            $returned_Dt = date("j M Y", strtotime($sorting['returned_date'])) . ' | ' . date("h:i A", strtotime($sorting['returned_date']));
            $returned_by = 'by '.$sorting['returnby'];
            $returned_remark = $sorting['returned_remark'];
        }
        else
        {
            $returned_Dt = '-';
            $returned_by = '';
            $returned_remark = '';
        }
        ?>
        
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
       <div class="content-body default-height">
			<div class="container-fluid">
                <div class="header-left mb-4">
                    <div class="dashboard_bar">
                        <?=$side_menu9;?>
                    </div>
                </div>

                <div id="detailsPreview" >
                    <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                        <div class="accordion-item">
                        <h2 class="accordion-header accordion-header-primary" id="headingOne6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6">
                        <span class="accordion-header-icon"></span>
                            <span class="accordion-header-text">Material Details</span>
                        </button>
                        </h2>
                    </div>

                    <div id="collapseOne6" class="accordion__body collapse" aria-labelledby="accord-6One" data-bs-parent="#accordion-six">
                        <div class="accordion-body-text p-0">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <div class="row">                                        
                                        <div class="col-xl-4">                                             
                                           <div class="product-detail-content" id="material_product_detail">
                                            <!-- Material Details will be display here via AJAX -->    
                                            </div>
                                        </div>                                        
                                        <div class="col-xl-6">
                                            <h5 class="text-primary d-inline">Gallery</h5>
                                            <div class="row mt-4 sp4" id="lightgallery">
                                                <?=$gallery_html;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                </div>
				
				<div class="tab-content" id="tabContentMyProfileBottom">
					<div class="row">
						<div class="col-xxl-3 col-xl-4">
							<div class="row sticky-top sticky-top-80 z-0">
								<div class="col-lg-12">
									<div class="card">
										<div class="card-header">
											<h4 class="card-title mb-0">Timeline</h4>
										</div>
										<div class="card-body" style="overflow-y:scroll;height:320px;max-height:400px;">
											<div class="recent-post">
                                                <div class="timeline-entry mb-4">
                                                    <div class="timeline-icon bg-body-secondary text-dark">
                                                        <i class="fa fa-calendar-plus"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <p class="mb-0 fw-semibold text-dark">Created Date</p>
                                                        <span class="ms-0 fs-13"><?=$created_Dt ?></span>
                                                        <span class="ms-0 fs-13"><?=$created_by ?></span>
                                                    </div>
                                                </div>
                                                <div class="timeline-entry mb-4">
                                                    <div class="timeline-icon bg-body-secondary text-dark">
                                                        <i class="fa fa-calendar-alt"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <p class="mb-0 fw-semibold text-dark">Submitted Date</p>
                                                        <span class="ms-0 fs-13"><?=$submitted_Dt ?></span>
                                                        <span class="ms-0 fs-13"><?=$submitted_by ?></span>
                                                    </div>
                                                </div>
                                                <div class="timeline-entry mb-4">
                                                    <div class="timeline-icon bg-body-secondary text-dark">
                                                        <i class="fa fa-calendar-check"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="<?=$reviewed_remark ?> ">Reviewed Date xx</p>
                                                        <span class="ms-0 fs-13"><?=$reviewed_Dt ?></span>
                                                        <span class="ms-0 fs-13"><?=$reviewed_by ?></span> 
                                                        <?php if ($reviewed_remark): ?>
                                                        <small class="table-tip d-inline-flex align-items-center text-primary">
                                                            <i class="fa fa-info-circle p-1" data-bs-toggle="tooltip" title="<?= htmlspecialchars($reviewed_remark) ?>"></i>
                                                        </small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <div class="timeline-entry mb-0">
                                                    <div class="timeline-icon bg-body-secondary text-dark">
                                                        <i class="fa fa-calendar-minus"></i>
                                                    </div>
                                                    <div class="timeline-content">
                                                        <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="<?=$returned_remark ?>">Returned Date</p>
                                                        <span class="ms-0 fs-13"><?=$returned_Dt ?></span>
                                                        <span class="ms-0 fs-13"><?=$returned_by ?></span> 
                                                        <?php if ($returned_remark): ?>
                                                        <small class="table-tip d-inline-flex align-items-center text-primary">
                                                            <i class="fa fa-info-circle p-1" data-bs-toggle="tooltip" title="<?= htmlspecialchars($returned_remark) ?>"></i>
                                                        </small>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>                                    
                                            </div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xxl-9 col-xl-8">
							<div class="card">
								<div class="card-header py-3 d-block d-sm-flex">
									<h4 class="heading mb-0"><p class="text-muted mb-0 small-text">Doc no</p><span class="doc-text"><?=$edocno;?></span></h4>
									<ul class="nav nav-pills mt-3 mt-sm-0 mix-profile-tab" id="myTab" role="tablist">
										<li class="nav-item ms-1" role="presentation">
											<button class="nav-link active" id="week-tab3" data-bs-toggle="tab" data-bs-target="#tabSorting" type="button" role="tab" aria-selected="true"> <i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Sorting</button>
										</li>
										<li class="nav-item ms-1" role="presentation">
											<button class="nav-link" id="month-tab3" data-bs-toggle="tab" data-bs-target="#tabPartInvolve" type="button" role="tab" aria-selected="false" tabindex="-1"><i class="fa fa-list me-1" aria-hidden="true"></i> Part Involve</button>
										</li>
									</ul>
								</div>
								<div class="card-body">
									<div class="tab-content" id="myTabContent">

                                        <!-- Sorting Qty & Method-->
										<div class="tab-pane fade show active" id="tabSorting" role="tabpanel" aria-labelledby="week-tab3" tabindex="0">
											<div class="d-md-flex d-none flex-wrap mb-3">
                                                <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
                                                    <div class="avatar avatar-md style-1 bg-primary-light text-primary rounded d-flex align-items-center justify-content-center">                                                       
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-up" viewBox="0 0 16 16">
                                                            <path d="M8.864.046C7.908-.193 7.02.53 6.956 1.466c-.072 1.051-.23 2.016-.428 2.59-.125.36-.479 1.013-1.04 1.639-.557.623-1.282 1.178-2.131 1.41C2.685 7.288 2 7.87 2 8.72v4.001c0 .845.682 1.464 1.448 1.545 1.07.114 1.564.415 2.068.723l.048.03c.272.165.578.348.97.484.397.136.861.217 1.466.217h3.5c.937 0 1.599-.477 1.934-1.064a1.86 1.86 0 0 0 .254-.912c0-.152-.023-.312-.077-.464.201-.263.38-.578.488-.901.11-.33.172-.762.004-1.149.069-.13.12-.269.159-.403.077-.27.113-.568.113-.857 0-.288-.036-.585-.113-.856a2 2 0 0 0-.138-.362 1.9 1.9 0 0 0 .234-1.734c-.206-.592-.682-1.1-1.2-1.272-.847-.282-1.803-.276-2.516-.211a10 10 0 0 0-.443.05 9.4 9.4 0 0 0-.062-4.509A1.38 1.38 0 0 0 9.125.111zM11.5 14.721H8c-.51 0-.863-.069-1.14-.164-.281-.097-.506-.228-.776-.393l-.04-.024c-.555-.339-1.198-.731-2.49-.868-.333-.036-.554-.29-.554-.55V8.72c0-.254.226-.543.62-.65 1.095-.3 1.977-.996 2.614-1.708.635-.71 1.064-1.475 1.238-1.978.243-.7.407-1.768.482-2.85.025-.362.36-.594.667-.518l.262.066c.16.04.258.143.288.255a8.34 8.34 0 0 1-.145 4.725.5.5 0 0 0 .595.644l.003-.001.014-.003.058-.014a9 9 0 0 1 1.036-.157c.663-.06 1.457-.054 2.11.164.175.058.45.3.57.65.107.308.087.67-.266 1.022l-.353.353.353.354c.043.043.105.141.154.315.048.167.075.37.075.581 0 .212-.027.414-.075.582-.05.174-.111.272-.154.315l-.353.353.353.354c.047.047.109.177.005.488a2.2 2.2 0 0 1-.505.805l-.353.353.353.354c.006.005.041.05.041.17a.9.9 0 0 1-.121.416c-.165.288-.503.56-1.066.56z"/>
                                                        </svg>
                                                    </div>
                                                    <div class="clearfix ms-2">
                                                        <h3 class="mb-0 fw-semibold lh-1 fs-16"><?= htmlspecialchars($sorting['sr_qty_ok']) ?: '-' ?></h3>
                                                        <span class="fs-13">Qty OK</span>
                                                    </div>
                                                </div>
                                                <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
                                                    <div class="avatar avatar-md style-1 bg-primary-light text-primary rounded d-flex align-items-center justify-content-center">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-thumbs-down" viewBox="0 0 16 16">
                                                            <path d="M8.864 15.674c-.956.24-1.843-.484-1.908-1.42-.072-1.05-.23-2.015-.428-2.59-.125-.36-.479-1.012-1.04-1.638-.557-.624-1.282-1.179-2.131-1.41C2.685 8.432 2 7.85 2 7V3c0-.845.682-1.464 1.448-1.546 1.07-.113 1.564-.415 2.068-.723l.048-.029c.272-.166.578-.349.97-.484C6.931.08 7.395 0 8 0h3.5c.937 0 1.599.478 1.934 1.064.164.287.254.607.254.913 0 .152-.023.312-.077.464.201.262.38.577.488.9.11.33.172.762.004 1.15.069.13.12.268.159.403.077.27.113.567.113.856s-.036.586-.113.856c-.035.12-.08.244-.138.363.394.571.418 1.2.234 1.733-.206.592-.682 1.1-1.2 1.272-.847.283-1.803.276-2.516.211a10 10 0 0 1-.443-.05 9.36 9.36 0 0 1-.062 4.51c-.138.508-.55.848-1.012.964zM11.5 1H8c-.51 0-.863.068-1.14.163-.281.097-.506.229-.776.393l-.04.025c-.555.338-1.198.73-2.49.868-.333.035-.554.29-.554.55V7c0 .255.226.543.62.65 1.095.3 1.977.997 2.614 1.709.635.71 1.064 1.475 1.238 1.977.243.7.407 1.768.482 2.85.025.362.36.595.667.518l.262-.065c.16-.04.258-.144.288-.255a8.34 8.34 0 0 0-.145-4.726.5.5 0 0 1 .595-.643h.003l.014.004.058.013a9 9 0 0 0 1.036.157c.663.06 1.457.054 2.11-.163.175-.059.45-.301.57-.651.107-.308.087-.67-.266-1.021L12.793 7l.353-.354c.043-.042.105-.14.154-.315.048-.167.075-.37.075-.581s-.027-.414-.075-.581c-.05-.174-.111-.273-.154-.315l-.353-.354.353-.354c.047-.047.109-.176.005-.488a2.2 2.2 0 0 0-.505-.804l-.353-.354.353-.354c.006-.005.041-.05.041-.17a.9.9 0 0 0-.121-.415C12.4 1.272 12.063 1 11.5 1"/>
                                                        </svg>
                                                    </div>
                                                    <div class="clearfix ms-2">
                                                        <h3 class="mb-0 fw-semibold lh-1 fs-16"><?= htmlspecialchars($sorting['sr_qty_ng']) ?: '-' ?></h3>
                                                        <span class="fs-13">Qty NG</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Sorting Method -->
                                            <div class="row g-3 mb-3">
                                                <div class="col-sm-12">
                                                    <div class="border border-opacity-10 rounded p-3">
                                                        <h6 class="fs-14">Sorting Method </h6>
                                                        <p class="fs-13"><?= nl2br(htmlspecialchars($sorting['sr_sorting_method'])) ?: '-' ?> </p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="border border-opacity-10 rounded p-3">
                                                        <h6 class="fs-14">Rework Method</h6>
                                                        <p class="fs-13"><?= nl2br(htmlspecialchars($sorting['sr_rework_method'])) ?: '-' ?></p>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="border border-opacity-10 rounded p-3">
                                                        <h6 class="fs-14">Remarks</h6>
                                                        <p class="fs-13"><?= nl2br(htmlspecialchars($sorting['sr_remarks'])) ?: '-' ?></p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Photo -->
                                            <?php
                                                $before_photos = explode(',', $sorting['before_photos'] ?? '');
                                                $after_photos  = explode(',', $sorting['after_photos'] ?? '');
                                            ?>

                                            <!-- Photos Before -->
                                            <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                <div class="row align-items-center">
                                                    <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                    <h6 class="fs-15 mb-0">Photos Before (NG)</h6>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="avatar-list avatar-list-stacked ms-3 mt-4">
                                                            <?php if (!empty($before_photos[0])): ?>
                                                                <?php foreach ($before_photos as $photo): ?>
                                                                    <img src="gallery/sorting/before/<?= htmlspecialchars($photo) ?>" 
                                                                        class="avatar avatar-lg-custom rounded-circle zoomable-photo" 
                                                                        data-src="gallery/sorting/before/<?= htmlspecialchars($photo) ?>" 
                                                                        alt="Before Photo">
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <span class="text-muted fs-13">No photo available</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Photos After -->
                                             <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                <div class="row align-items-center">
                                                    <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                    <h6 class="fs-15 mb-0">Photos After Sorting (OK)</h6>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="avatar-list avatar-list-stacked ms-3 mt-4">
                                                            <?php if (!empty($after_photos[0])): ?>
                                                                <?php foreach ($after_photos as $photo): ?>
                                                                    <img src="gallery/sorting/after/<?= htmlspecialchars($photo) ?>" 
                                                                        class="avatar avatar-lg-custom rounded-circle zoomable-photo" 
                                                                        data-src="gallery/sorting/after/<?= htmlspecialchars($photo) ?>" 
                                                                        alt="Before Photo">
                                                                <?php endforeach; ?>
                                                            <?php else: ?>
                                                                <span class="text-muted fs-13">No photo available</span>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 mt-4">
                                                <div class="mb-3">
                                                    <label class="form-label">Comment/ Reason </span></label>
                                                    <?php if ($reviewed_remark): ?>
                                                        <textarea class="form-control" name="remark" id="approval_remark" rows="4" style="color: #333; background-color : #FBFCFA;" disabled><?= $reviewed_remark ?></textarea>
                                                    <?php else: ?>
                                                        <textarea class="form-control" name="remark" id="approval_remark" rows="4" style="color: #333; background-color : #FBFCFA;"></textarea>
                                                    <?php endif; ?>
                                                </div>
                                            </div>

                                            <div class="text-end mt-4 mb-4">
                                                <button type="button" class="btn btn-black btnApprove"> <i class="fa fa-check me-2"></i> Approve</button>
                                                <button type="button" class="btn btn-black btnReturn"><i class="fa fa-undo me-2"></i> Return</button>
                                            </div>  

                                            <!-- Modal for image zoom -->
                                            <div class="modal fade" id="imgZoomModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content" style="background: transparent; border: none;">
                                                        <img src="" id="zoomedImg" class="img-fluid rounded shadow" style="max-width: 90vw; max-height: 90vh;">
                                                    </div>
                                                </div>
                                            </div>    
										</div>

                                        <!-- Part Involve -->
										<div class="tab-pane fade" id="tabPartInvolve" role="tabpanel" aria-labelledby="month-tab3" tabindex="0">
											
                                            <!-- 1. Department -->
                                            <div class="accordion-item accordion-header-bg accordion-bordered mb-4 p-0">
                                                <h2 class="accordion-header" id="headingTwo">
                                                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                                    <i class="fa fa-building me-2 text-black"></i> RELATED LOOSE PART INVOLVE - In House Part (If any)
                                                </button>
                                                </h2>
                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive mb-2">
                                                            <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="relatedPartDept">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Related Dept</th>
                                                                        <th>Type of Part</th>
                                                                        <th>Part Number</th>
                                                                        <th>Part Name</th>
                                                                        <th>QTY OK</th>
                                                                        <th>QTY NG</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $stmt = $db_con->prepare("
                                                                                SELECT p.srp_qty_ok_dept, p.srp_qty_ng_dept,
                                                                                m.bom, m.bomdesc,
                                                                                d.rd_dept_name,
                                                                                e.tp_partname
                                                                                FROM inspection_sorting_related_part_dept p
                                                                                LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
                                                                                LEFT JOIN related_departments d ON p.srp_related_dept = d.rd_dept_id
                                                                                LEFT JOIN type_part e ON p.srp_type_part_dept = e.tp_partid
                                                                                WHERE p.srp_ir_id_dept = ? and p.srp_ir_id_sorting = ?
                                                                            ");
                                                                    $stmt->bind_param("ii", $eir_id, $esr_id);
                                                                    $stmt->execute();
                                                                    $res = $stmt->get_result();

                                                                    if ($res->num_rows > 0) {
                                                                        while ($row = $res->fetch_assoc()) {
                                                                    ?>

                                                                    <tr>
                                                                        <td><?=$row['rd_dept_name'] ?></td>
                                                                        <td><?=$row['tp_partname'] ?></td>
                                                                        <td><?=$row['bom'] ?></td>
                                                                        <td><?=$row['bomdesc'] ?></td>
                                                                        <td><?=$row['srp_qty_ok_dept'] ?></td>
                                                                        <td><?=$row['srp_qty_ng_dept'] ?></td>
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    } else {
                                                                        echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 2. Vendor -->
                                            <div class="accordion-item accordion-header-bg accordion-bordered mb-4 p-0">
                                                <h2 class="accordion-header" id="headingThree">
                                                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                                    <i class="fa fa-truck me-2 text-black"></i> RELATED LOOSE PART INVOLVE - Tier 2 (If any)
                                                </button>
                                                </h2>
                                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">                                        
                                                        <div class="table-responsive mb-2">
                                                            <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="relatedPartVendor">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Related Vendor</th>
                                                                        <th>Type of Part</th>
                                                                        <th>Part Number</th>
                                                                        <th>Part Name</th>
                                                                        <th>QTY OK</th>
                                                                        <th>QTY NG</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $stmt = $db_con->prepare("
                                                                                SELECT p.srp_qty_ok_vdr, p.srp_qty_ng_vdr,
                                                                                m.bom, m.bomdesc,
                                                                                d.rv_vendor_name,
                                                                                e.tp_partname
                                                                                FROM inspection_sorting_related_part_vendor p
                                                                                LEFT JOIN material_details m ON p.srp_mathdr_id_vdr = m.matdet_id
                                                                                LEFT JOIN related_vendors d ON p.srp_related_vdr = d.rv_vendor_id
                                                                                LEFT JOIN type_part e ON p.srp_type_part_vdr = e.tp_partid
                                                                                WHERE p.srp_ir_id_vdr = ? and p.srp_ir_id_sorting = ?
                                                                            ");
                                                                    $stmt->bind_param("ii", $eir_id, $esr_id);
                                                                    $stmt->execute();
                                                                    $res = $stmt->get_result();

                                                                    if ($res->num_rows > 0) {
                                                                        while ($row = $res->fetch_assoc()) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?=$row['rv_vendor_name'] ?></td>
                                                                        <td><?=$row['tp_partname'] ?></td>
                                                                        <td><?=$row['bom'] ?></td>
                                                                        <td><?=$row['bomdesc'] ?></td>
                                                                        <td><?=$row['srp_qty_ok_vdr'] ?></td>
                                                                        <td><?=$row['srp_qty_ng_vdr'] ?></td>
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    } else {
                                                                        echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 3. Customer -->
                                            <div class="accordion-item accordion-header-bg accordion-bordered mb-4 p-0">
                                                <h2 class="accordion-header" id="headingFour">
                                                <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                                    <i class="fa fa-users me-2 text-black"></i> FINISHED GOODS PART INVOLVE - Customer (If any)
                                                </button>
                                                </h2>
                                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                            <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="relatedPartCustomer" style="width:600px">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Related Customer</th>
                                                                        <th>QTY OK</th>
                                                                        <th>QTY NG</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $stmt = $db_con->prepare("
                                                                                SELECT p.srp_qty_ok_cust, p.srp_qty_ng_cust,
                                                                                d.rc_cust_name
                                                                                FROM inspection_sorting_related_part_cust p
                                                                                LEFT JOIN related_customers d ON p.srp_related_cust = d.rc_cust_id
                                                                                WHERE p.srp_ir_id_cust = ? and p.srp_ir_id_sorting = ?
                                                                            ");
                                                                    $stmt->bind_param("ii", $eir_id, $esr_id);
                                                                    $stmt->execute();
                                                                    $res = $stmt->get_result();

                                                                    if ($res->num_rows > 0) {
                                                                        while ($row = $res->fetch_assoc()) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?=$row['rc_cust_name'] ?></td>
                                                                        <td><?=$row['srp_qty_ok_cust'] ?></td>
                                                                        <td><?=$row['srp_qty_ng_cust'] ?></td>
                                                                    </tr>
                                                                     <?php
                                                                        }
                                                                    } else {
                                                                        echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div> 
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

                <a href="javascript:void(0);" class="btn btn-primary btn-lg rounded-circle back-button" id="btnBack" title="Go Back">
                    <i class="fa fa-arrow-left"></i>
                </a>
				
			</div>			
		</div>


        <!--**********************************
            Content body end
        ***********************************-->
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <?php include 'nav-footer.php' ;?>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->
		
        <!--**********************************
           Support ticket button end
        ***********************************-->


	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
       
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/select2/js/select2.full.min.js"></script>
    <script src="js/plugins-init/select2-init.js"></script>
	<script src="vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js"></script>
    <script src="vendor/chart-js/chart.bundle.min.js"></script>
	<!-- Apex Chart -->
	<script src="vendor/apexchart/apexchart.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/responsive/responsive.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>    
    <script src="js/highlight.min.js"></script>    
    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>

    <script>
    document.getElementById('btnBack').addEventListener('click', function () {
        window.location.href = "ip-sorting-pendingreview.php";
    });
    </script>

    <script>
    
    const eir_id = "<?= $eir_id ?>";
    const esr_id = "<?= $esr_id ?>";

    // Load mateiral details
    $(document).ready(function () {
        if (eir_id) {
            loadMaterialDetails(eir_id);
        }
    });

    function loadMaterialDetails(irid) {
        $.ajax({
            url: 'fetch-material-details.php',
            type: 'POST',
            dataType: 'json',
            data: { ir_id: irid },
            success: function (res) {
                // Inject images
                $('#lightgallery').html(res.gallery_html);

                // Inject details
                $('#material_product_detail').html(res.detail_html);

                // Re-init lightGallery
                if ($('#lightgallery').data('lightGallery')) {
                    $('#lightgallery').data('lightGallery').destroy(true);
                }
                $('#lightgallery').lightGallery({
                    selector: 'a',
                    thumbnail: true
                });
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
            }
        });
    }

    </script>

    <script>
    $(document).ready(function() {
        const esr_status = "<?= $esr_status ?>";

        if (esr_status == 11 || esr_status == 12) {
            $('.btnApprove, .btnReturn').hide(); // hide both buttons
        }
    });
    </script>

    <script>

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#sortingPendingList').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

    <script>

    $(document).on('click', '.zoomable-photo', function () {
        const imgSrc = $(this).data('src');
        $('#zoomedImg').attr('src', imgSrc);
        $('#imgZoomModal').modal('show');
    });

    </script>

    <script>

    // Approve
    $(document).on('click', '.btnApprove', function () {

        const ir_id = eir_id;
        const sr_id = esr_id;
        const remark = $('#approval_remark').val().trim();

        if (!remark) {
            Swal.fire('Missing Input', 'Please enter your comment or reason before approving.', 'warning');
            $('#approval_remark').addClass('border-error');
            return;
        } else {
            $('#approval_remark').removeClass('border-error');
        }

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to approve this sorting report?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it'
        }).then((result) => {
            if (result.isConfirmed) {

                const $btn = $('.btnApprove');
                $btn.prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-2"></span>Approving...');

                $.ajax({
                    url: 'fetch-ip-sorting-pending-action.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'approve_sorting',
                        ir_id: ir_id,
                        sr_id: sr_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        $btn.prop('disabled', false)
                            .html('<i class="fa fa-check me-2"></i> Approve');

                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved',
                                text: 'Sorting report approved successfully.',
                                timer: 2000,
                                showConfirmButton: false,
                                willClose: () => {
                                    // Fade out Approve button
                                    $('.btnApprove').fadeOut(300);

                                    // Reload timeline only
                                    $.ajax({
                                        url: 'fetch-timeline.php',
                                        type: 'POST',
                                        data: { ir_id: ir_id, sr_id: sr_id },
                                        success: function (html) {

                                            $('.recent-post').html(html);

                                            // Reinitialize Bootstrap tooltips
                                            $('[data-bs-toggle="tooltip"]').tooltip();
                                        },
                                        error: function () {
                                            console.error('Failed to reload timeline.');
                                        }
                                    });

                                    // Reload textarea (fetch latest reviewed remark)
                                    $.ajax({
                                        url: 'fetch-remark.php',  // a simple PHP file returning remark text
                                        type: 'POST',
                                        data: { ir_id: ir_id, sr_id: sr_id },
                                        dataType: 'json',
                                        success: function (data) {
                                            if (data && data.reviewed_remark !== undefined) {
                                                $('#approval_remark')
                                                    .val(data.reviewed_remark)
                                                    .prop('disabled', true)
                                                    .css({
                                                        'background-color': '#FBFCFA',
                                                        'color': '#555'
                                                    });
                                            }
                                        },
                                        error: function () {
                                            console.error('Failed to reload remark field.');
                                        }
                                    });

                                    
                                }
                            });
                        } else {
                            Swal.fire('Error', res.message || 'Approval failed.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server error while approving.', 'error');
                    }
                });
            }
        });
    });


    //Return
    $(document).on('click', '.btnReturn', function () {

        const ir_id = $(this).data('irid');

        $('#return_ir_id').val(ir_id);
        $('#return_remark').val('');

        //Clear previous error border
        $('#return_remark').removeClass('border-error');

        const modal = new bootstrap.Modal(document.getElementById('returnModal'));
        modal.show();
    });

    // Remove border when user fixes the input
    $('#return_remark').on('change', function() {
        // $(this).removeClass('border-error');
       $('#return_remark').removeClass('border-error');
    }); 

    // 2. Handle form submit
    $('#returnForm').on('submit', function (e) {
        e.preventDefault();

        const ir_id = $('#return_ir_id').val();
        const remark = $('#return_remark').val().trim();

        if (!remark) {
            alert('Please state the comment or reason.');
            $('#return_remark').addClass('border-error');
            return;
        } else {
            $('#return_remark').removeClass('border-error');
        }

        //Confirmation prompt before approving
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to return this inspection?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, return it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with approval
                const $btn = $('#btnConfirmReturn');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Return...');

                $.ajax({
                    url: 'fetch-ip-sorting-pending-action.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'return_inspection',
                        ir_id: ir_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Return');
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Return',
                                text: 'The inspection has been returned successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            $('#returnModal').modal('hide');

                            // Refresh DataTable
                            table.ajax.reload(null, false);

                            // Refresh totals
                            fetchTotalCounts($('.cs_model').val(), $('.cs_type').val(), $('.cs_material').val(),'fetch_pending');
                            // Load counts on page load
                            reloadCounts();
                            
                            // Reload activity
                            reloadActivityComments();

                        } else {
                            Swal.fire('Error', res.message || 'Approval failed.', 'error');
                        }
                    },
                    error: function () {
                        Swal.close();
                        Swal.fire('Error', 'Server error while approving.', 'error');
                    }
                });
            }
        });
    });

    </script>

    <script>

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

    </script>

</body>
</html>