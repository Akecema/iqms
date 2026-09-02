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

    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
    <link href="css/image.css" rel="stylesheet">

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
		
        <?php

        $startDate = date('01/01/Y'); ; //2023-01-01
        $endDate = date('m/t/Y'); //2023-01-31

        $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' AND task = 'IR' AND process = 'approval'";
        $resDelay = mysqli_query($db_con, $delay_sql);
        $rowDelay = mysqli_fetch_assoc($resDelay);
        $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

        $today = new DateTime();
        $minDate = (clone $today)->modify("-{$delay_day} days"); // earliest allowed
        $prodDate = new DateTime($shift_date);  // from your row

        // Button enabled only if shift_date is within last X days (inclusive)
        $isAllowed = ($prodDate >= $minDate && $prodDate <= $today);
        $btnDisabled = $isAllowed ? "" : "disabled";

        ?>

        <style>

        .border-error {
            border: 2px solid #eb2020ff !important;   
            background-color: #faf7f9ff !important;
            color : #2D2E2D;   
        }

        .border-error:hover {
            color: #181818 !important;  
        }
        .pallet-row td {
            padding: 0 !important;
            border-top: none;
            background: #fcfcfc;
        }

        .slide-wrap {
            border-top: 1px solid #dee2e6;
        }

        .dataTables_filter input {
            width: 180px !important; /* or any size you want */
            height: 35px !important;             /* optional */
            font-size: 11px !important;          /* optional */
        }

		#inspectionPendingListPrevious tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionPendingListPrevious thead tr th:last-child{
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


        #modalDefect tbody tr td:last-child {
            text-align: left !important; 
        }

        #modalDefect thead tr th:last-child{
            text-align: left !important;
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

        .avatar-list {
            display: flex;
            align-items: center;
        }
        .avatar-list-inline .avatar {
            margin-left: -10px;
            border: 2px solid #fff;
            cursor: zoom-in;
        }
        .avatar.avatar-md {
            width: 40px;
            height: 40px;
            overflow: hidden;
        }
        .avatar-list-inline .avatar:last-child {
            margin-right: 0;     /* no margin on last item */
        }

        .zoomable-img {
            cursor: zoom-in;       /* Show hand on hover */
            position: relative;    /* Make sure it's clickable */
            z-index: 10;           /* Bring it above wrappers */
            pointer-events: auto;  /* Ensure clicks pass through */
        }

        .zoomable-img:hover {
            transform: scale(1.32);
            box-shadow: 0 3px 6px rgba(0,0,0,0.15);
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

        .pallet-col {
            width: 65px;
            min-width: 65px;
            max-width: 65px;
            white-space: normal !important;
            word-wrap: break-word;
        }
 
        .small-text {
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

        </style>

        
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<div class="header-left mb-4">
                    <div class="dashboard_bar">
                        <?=$side_menu6;?>
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                        <ul class="nav nav-pills success-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-series="social" onclick="location.href='inspection-rcd-pendingreview.php'">
                                    <i class="bi bi-calendar-check fs-4 text-muted"></i>
                                    <span>Today</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active text-dark" data-series="project" onclick="location.href='#'">
                                    <i class="bi bi-arrow-clockwise fs-3 text-primary"></i>
                                    <span>Previous</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="d-flex align-items-center ms-auto">
                        <select class="default-select status-select normal-select" id="filterLink">
                            <option value="inspection-rcd-pendingreview.php">Today</option>
                            <option value="inspection-rcd-pendingreview-pre.php" selected>Previous</option>
                        </select>
                        <button class="btn btn-sm btn-primary ms-2" onclick="location.href='all.php'">View All</button>
                    </div>	 -->
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card h-auto">
                            <div class="card-body ai-tabs-1 py-2">
                                <ul class="nav nav-tabs align-items-end" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" href="#">
                                            Pending Review 
                                            <span id="countPending" class="badge badge-circle badge-light badge-primary light ms-2">0</span>
                                        </a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="inspection-rcd-reviewed-pre.php">
                                            Reviewed
                                            <span id="countApproved" class="badge badge-circle badge-light badge-primary light ms-2">0</span>
                                        </a>
                                    </li>	                                    	
                                    <li class="nav-item">
                                        <a class="nav-link" href="inspection-rcd-completed-pre.php">
                                            Completed
                                            <span id="countCompleted" class="badge badge-circle badge-light badge-primary light ms-2">0</span>
                                        </a>
                                    </li>				  
                                </ul>
                            </div>
                        </div>					
                    </div>
                </div>

                <div class="tab-content" id="myTabContent">
                            
                    <!-- Pending reviewed -->
                    <div class="tab-pane fade show active" id="pendingTab" role="tabpanel" aria-labelledby="pending-tab" tabindex="0">
                        <div class="row">
                            <div class="col-xxl-9 col-xl-8">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row g-3">
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label">Model</label>
                                                        <select class="form-control select2-filter cs_model" name="fd_model" id="single-select" onChange="getType(this.value)">
                                                            <option value="">Select Model</option>
                                                            <?php
                                                            $sql_model = "SELECT modid, modcode FROM model_details WHERE compcd = '$session_comp' and plant = '$session_plant' and modstatus = 'Y'
                                                                            ORDER BY modcode ASC";
                                                            $rst_model = mysqli_query($db_con, $sql_model);

                                                            while ($row_model = mysqli_fetch_array($rst_model)) {
                                                            ?>
                                                                <option value="<?php echo $row_model['modid']; ?>" 
                                                                    <?= (isset($_GET['fd_model']) && $_GET['fd_model'] == $row_model['modid']) ? "selected" : "" ?>>
                                                                    <?php echo $row_model['modcode']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4 mb-2">
                                                        <label class="form-label">Type</label>
                                                        <div id="div_type">
                                                            <select class="form-control filter-select cs_type" name="fd_type" id="fd_type">
                                                                <option value="">Select Type</option>                                                    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4 mb-2">                                            
                                                        <label class="form-label">Part No</label>
                                                        <div id="div_material">
                                                            <select class="form-control filter-select cs_material" name="fd_material" id="fd_material">
                                                                <option value="">Select Part no</option>                                                    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5 mb-2">                                           
                                                        <label class="form-label">Inspection Date Range</label>
                                                        <input class="form-control input-daterange-datepicker" type="text" name="daterange" id="daterange_insp" value="">
                                                    </div>
                                                    <!-- Buttons -->
                                                    <div class="text-end mt-3">
                                                        <!-- Hidden row id -->
                                                        <input type="hidden" id="hidden_shift" value="<?=$current_shift;?>"/>
                                                        <input type="hidden" id="hidden_shift_date" value="<?= $shift_date; ?>">
                                                        <button class="btn btn-rounded btn-black text-white btn-sm me-2" id="btnFilterSearch">Search</button>
                                                        <button class="btn btn-rounded btn-dark btn-sm" id="btnResetFilter"><i class="fa fa-refresh"></i> Reset</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-header py-3 d-block d-sm-flex">
                                                <h4 class="heading mb-0"></h4>
                                                <span class="text-success dang d-block">
                                                <span id="totalOkPending" class="me-3 d-inline-flex align-items-center" data-bs-toggle="tooltip" title="OK">
                                                    <svg class="me-1" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 4.5L6.75 12.75L3 9" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    <span>0</span>
                                                </span>

                                                <span id="totalNgPending" class="d-inline-flex align-items-center" data-bs-toggle="tooltip" title="NG">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ca1d14ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                    <span>0</span>
                                                </span>
                                            </div>
                                            <div class="card-body">                                                                                                      
                                                <small class="table-tip d-inline-flex align-items-center">
                                                    <i class="fa fa-info-circle me-1" data-bs-toggle="tooltip" title="Use # to search specific pallet sequence. Example: #3"></i>
                                                    Tip: Use <code>#</code> to search by pallet sequence (e.g. <code>#3</code>)
                                                </small>
                                                <div class="table-responsive">
                                                    <table id="inspectionPendingListPrevious" class="display table mb-1 table-striped-thead table-wide table-md">                                                              
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th class="nosort"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                                                <th>Doc No</th>
                                                                <th>Part No</th>
                                                                <th class="pallet-col">Pallet Sequence</th>
                                                                <th>Inspection Date</th>
                                                                <th>Shift</th>
                                                                <th>Result</th>
                                                                <th class="nosort">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>                                             
                                                
                                                <button id="btnBulkApprove" class="btn btn-black me-2" <?= $btnDisabled ?>>
                                                    <i class="fa fa-check-double"></i> Review Selected
                                                </button>

                                                <button id="btnBulkReturn" class="btn btn-black" <?= $btnDisabled ?>>
                                                    <i class="fa fa-undo"></i> Return Selected
                                                </button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal View-->
                            <div class="modal fade custom-modal-md" id="detailModal">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">                                                    
                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div>                              
                                        <div class="modal-body" id="detailModalBody">
                                            
                                        </div>
                                        <!-- <div class="modal-footer">
                                            <button type="button" class="btn btn-dark light" data-bs-dismiss="modal">Close</button>
                                        </div> -->
                                    </div>
                                </div>
                            </div>

                            <!-- Zoom Image Modal -->
                            <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="background: transparent; border: none;">
                                        <img src="" id="zoomedImage" class="img-fluid rounded shadow" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                                    </div>
                                </div>
                            </div>   
                            
                            <!-- Approval Modal -->
                            <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form id="approveForm">
                                    <div class="modal-content">
                                        <div class="modal-header">                                                    
                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div> 
                                        <div class="modal-body">
                                            <input type="hidden" name="ir_id" id="approve_ir_id">
                                            <div class="mb-3">
                                                <label for="approval_remark" class="form-label">Comment/ Reason <!-- <span class="text-danger">*</span>--></label> 
                                                <textarea class="form-control" name="remark" id="approval_remark" rows="4" style="color: #333;"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-black" id="btnConfirmApprove"><i class="fa fa-check"></i> Approve</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <!--Bulk Approval Modal -->
                            <div class="modal fade" id="bulkapproveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form id="bulkapproveForm">
                                    <div class="modal-content">
                                        <div class="modal-header">                                                    
                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div> 
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="bulk_approval_remark" class="form-label">Comment/ Reason <!--<span class="text-danger">*</span>--></label> 
                                                <textarea class="form-control" name="remark" id="bulk_approval_remark" rows="4" style="color: #333;"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-black" id="btnConfirmApproveBulk"><i class="fa fa-check"></i> Review</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Return Modal -->
                            <div class="modal fade" id="returnModal" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form id="returnForm">
                                    <div class="modal-content">
                                        <div class="modal-header">                                                    
                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div> 
                                        <div class="modal-body">
                                            <input type="hidden" name="ir_id" id="return_ir_id">
                                            <div class="mb-3">
                                                <label for="return_remark" class="form-label">Comment/ Reason <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="remark" id="return_remark" rows="4" style="color: #333;"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-black" id="btnConfirmReturn"><i class="fa fa-undo"></i> Return</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Bulk Return Modal -->
                            <div class="modal fade" id="bulkreturnModal" tabindex="-1" aria-labelledby="bulkreturnModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <form id="bulkreturnForm">
                                    <div class="modal-content">
                                        <div class="modal-header">                                                    
                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </div> 
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="bulk_return_remark" class="form-label">Comment/ Reason <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="remark" id="bulk_return_remark" rows="4" style="color: #333;"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-black" id="btnConfirmReturnBulk"><i class="fa fa-undo"></i> Return</button>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Activity comment-->
                            <div class="col-xxl-3 col-xl-4">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card" style="overflow-y:scroll;height:auto;max-height:1375px;">
                                            <div class="card-body profile-accordion pb-0">
                                                <div class="accordion" id="accordionExample2">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header" id="headingOne2">
                                                        <button class="accordion-button border-0 mb-4" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne2" aria-expanded="true" aria-controls="collapseOne2">
                                                            Activity
                                                        </button>
                                                        </h2>
                                                        <div id="collapseOne2" class="accordion-collapse collapse show" aria-labelledby="headingOne2" data-bs-parent="#accordionExample2">
                                                            <div class="accordion-body">
                                                                <div class="widget-timeline-icons pb-1 ms-n3">
                                                                    <div id="activityCommentContainer">
                                                                        <!-- Fetched activity comments will load here -->
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
                            <!-- end activity comment-->
                        </div> 
                    </div>                    
                    <!-- End tab pending -->
                </div>
                <!-- End tab -->

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

    <!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="vendor/moment/moment.min.js"></script>
    <script src="vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- clockpicker -->
    <script src="vendor/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <!-- asColorPicker -->
	<script src="vendor/jquery-ascolor/jquery-ascolor.min.js"></script>
    <script src="vendor/jquery-asgradient/jquery-asgradient.min.js"></script>
    <script src="vendor/jquery-ascolorpicker/js/jquery-ascolorpicker.min.js"></script>
    <!-- Material color picker -->
    <script src="vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- pickdate -->
    <script src="vendor/pickadate/picker.js"></script>
    <script src="vendor/pickadate/picker.time.js"></script>
    <script src="vendor/pickadate/picker.date.js"></script>

    <!-- Daterangepicker -->
    <script src="js/plugins-init/bs-daterange-picker-init.js"></script>
    <!-- Clockpicker init -->
    <script src="js/plugins-init/clock-picker-init.js"></script>
    <!-- asColorPicker init -->
	<script src="js/plugins-init/jquery-ascolorpicker.init.js"></script>
    <!-- Material color picker init -->
    <script src="js/plugins-init/material-date-picker-init.js"></script>
    <!-- Pickdate -->
    <script src="js/plugins-init/pickadate-init.js"></script>

    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>

    <script>
    document.getElementById('filterLink').addEventListener('change', function() {
        window.location.href = this.value;
    });
    </script>

    <script>

    $('.filter-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });
    
    </script>
    <script>

    function getType(modelId){
        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    $('#div_type').html(response); 
                } 
            }
        };
        xhr.open("GET", "find-type.php?model_id=" + modelId, true);
        xhr.send();
    }

    function getMaterial(modelId,typeId){
        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    $('#div_material').html(response); 
                } 
            }
        };
        xhr.open("GET", "find-material.php?model_id=" + modelId + "&type_id=" + typeId, true);
        xhr.send();
    }

    </script>

    <script>

    $('#daterange_insp').daterangepicker({
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

    $('#daterange_insp, #daterange_prod').val('');

    </script>

    <script>

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#inspectionPendingListPrevious').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

    <script>

    let table; // Global table

    $(document).ready(function () {
        
        // Define globally accessible function
        window.fetchTotalCounts = function(model = '', type = '', material = '', fd_daterange = '', action = 'fetch_pending') {
            $.post('count-ok-ng-approval-previous.php', {
                action: action,
                model: model,
                type: type,
                material: material,
                fd_daterange : fd_daterange,
                shift: $('#hidden_shift').val(),
                shift_date: $('#hidden_shift_date').val()
            }, function (res) {
                const data = JSON.parse(res);
                $('#totalOkPending span').text(data.ok);
                $('#totalNgPending span').text(data.ng);
            });
        };

        
        function getTableHeight() {
            // Adjust offset depending on your header/footer/filter size
            return ($(window).height() - 250) + 'px';
        }
        
        // Init DataTable
        table = $('#inspectionPendingListPrevious').DataTable({
            processing: true,
            serverSide: true,
            order: [[3, 'desc']],
            lengthChange: false,
            scrollX: true,            // horizontal scroll for wide columns
            scrollY: getTableHeight(), // dynamic vertical scroll (auto fits screen)
            scrollCollapse: true,     // collapses empty space if fewer rows
            autoWidth: false,
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            },
            ajax: {
                url: 'fetch-inspection-rcd-pending-previous-action.php',
                method: 'POST',
                data: function (d) {
                    d.action = 'fetch_records';
                    d.model = $('.cs_model').val();
                    d.type = $('.cs_type').val();
                    d.material = $('.cs_material').val();
                    d.fd_daterange = $('#daterange_insp').val();
                }
            },
            columnDefs: [{ targets: 'nosort', orderable: false }]
        });

        // Populate dropdowns
        window.getType = function(modelId) {
            $.get("find-type.php", { model_id: modelId }, function(response) {
                $('#div_type').html(response);
                $('#div_material').html('<select class="form-control cs_material"><option value="">Select Part No</option></select>');
            });
        }

        window.getMaterial = function(modelId, typeId) {
            $.get("find-material.php", { model_id: modelId, type_id: typeId }, function(response) {
                $('#div_material').html(response);
            });
        }

        // Load initial counts
        fetchTotalCounts('', '', '', 'fetch_pending');

        // Load counts on page load
        reloadCounts();

        // Load activity comment
        reloadActivityComments();

        // Filter search
        $('#btnFilterSearch').on('click', function (e) {
            e.preventDefault();
            table.ajax.reload();
            fetchTotalCounts($('.cs_model').val(), $('.cs_type').val(), $('.cs_material').val(), $('#daterange_insp').val(), 'fetch_pending');
        });

        // Reset filter
        $('#btnResetFilter').on('click', function () {
            $('.cs_model, .cs_type, .cs_material').val('').trigger('change');
            $('#daterange_insp').val('');
            table.ajax.reload();
            fetchTotalCounts('', '', '', 'fetch_pending'); // With empty params
        });

    });

    </script>

    <script>
    const DELAY_DAY = <?= (int)$delay_day ?>;
    </script>

    <script>

    function reloadCounts() {
        $.post('count-inspection-approval-previous.php', {
            shift: $('#hidden_shift').val(),
            shift_date: $('#hidden_shift_date').val()
        }, function(res) {
            const data = JSON.parse(res);
            // Update badges
            $('#countPending').text(data.pending);
            $('#countApproved').text(data.approved);
            $('#countCompleted').text(data.completed);
        });
    }

    </script>
    
    <script>

    function reloadActivityComments() {

        $.post('fetch-activity-comment-previous.php', {
            shift: $('#hidden_shift').val(),
            shift_date: $('#hidden_shift_date').val(),
            section : 'PDI',
            task : 'IR'
        }, function(res) {
            $('#activityCommentContainer').html(res);
        }).fail(function() {
            $('#activityCommentContainer').html('<p class="text-danger">Failed to load activity comments.</p>');
        });

    }

    </script>

    <script>

    $(document).on('click', '.viewDocDetails', function() {

        let docno = $(this).data('docno');

        $.ajax({

            url: 'fetch-inspection-details.php',
            type: 'POST',
            dataType: 'html',
            data: { action : 'inspection_details', docno: docno },
            success: function(res) {
                $('#detailModalBody').html(res);
                let m = new bootstrap.Modal(document.getElementById('detailModal'));
                m.show();
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                alert("Failed to load modal content.");
            }
        });
    }); 

    </script>

    <script>

    //Zoom defec /compare photo in modal 
    $(document).on('click', '.zoomable-img', function() {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        console.log("Clicked:", imgSrc);
        $('#zoomedImage').attr('src', imgSrc);
        const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        modal.show();
    });

    </script>

    <script>

    //single Approval   
    $(document).on('click', '.btnApprove', function () {
        const ir_id = $(this).data('irid');        
        const ir_result = $(this).data('result');
        
        $('#approve_ir_id').val(ir_id);
        $('#approveForm').data('result', ir_result); 
        $('#approval_remark').val('');
        $('#approval_remark').removeClass('border-error');

        new bootstrap.Modal(document.getElementById('approveModal')).show();
    });

    $('#approval_remark').on('change', function() {
        $(this).removeClass('border-error');
    }); 

    $('#approveForm').on('submit', function (e) {
        e.preventDefault();

        const ir_id = $('#approve_ir_id').val();
        const remark = $('#approval_remark').val().trim();
        const result_id = $('#approveForm').data('result');  

        // if (!remark) {
        //     Swal.fire({
        //         icon: 'warning',
        //         iconColor: "#286912",
        //         title: 'Missing comment',
        //         confirmButtonColor: '#28a745',
        //         text: 'Please state the comment or reason.',
        //     });
        //     $('#approval_remark').addClass('border-error');
        //     return;
        // }
        // $('#approval_remark').removeClass('border-error');

        Swal.fire({
            title: 'Are you sure?',
            text: "Approve this inspection?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it'
        }).then((result) => {
            if (result.isConfirmed) {
                const $btn = $('#btnConfirmApprove');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Approving...');

                $.ajax({
                    url: 'fetch-inspection-rcd-pending-previous-action.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'approve_inspection',
                        ir_id: ir_id,
                        approval_remark: remark,
                        result_id : result_id
                    },
                    success: function (res) {
                        $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Approve');
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Approved',
                                text: 'Inspection approved successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            $('#approveModal').modal('hide');

                            // Reload table
                            table.ajax.reload(null, false);

                            // Refresh total counts
                            reloadCounts();
                            fetchTotalCounts($('.cs_model').val(), $('.cs_type').val(), $('.cs_material').val());

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

    //Single Return
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
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing comment',
                confirmButtonColor: '#28a745',
                text: 'Please state the comment or reason.',
            });
            $('#return_remark').addClass('border-error');
            return;
        }
        $('#return_remark').removeClass('border-error');

        //Confirmation prompt before approving
        Swal.fire({
            title: 'Are you sure?',
            text: "Return this inspection?",
            icon: 'question',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, return it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with approval
                const $btn = $('#btnConfirmReturn');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Return...');

                $.ajax({
                    url: 'fetch-inspection-rcd-pending-previous-action.php',
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
                                iconColor: "#286912",
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

    const DELAY_DAY = <?= (int)$delay_day ?>;

    function isAllowedByDelay(shiftDateStr) {

        if (!shiftDateStr) return false;

        let prodDate = new Date(shiftDateStr + "T00:00:00");
        let today = new Date();
        today.setHours(0,0,0,0);

        let minDate = new Date();
        minDate.setHours(0,0,0,0);
        minDate.setDate(minDate.getDate() - DELAY_DAY);

        return (prodDate >= minDate && prodDate <= today);
    }


    let selectedIds = new Set();
    let selectAllPages = false; // 

    // Row checkbox
    $(document).on('change', '.row-check', function () {

        // check if all enabled checkboxes are selected
        let totalEnabled = $('.row-check:not(:disabled)').length;
        let totalChecked = $('.row-check:not(:disabled):checked').length;

        $('#checkAll').prop('checked', totalEnabled > 0 && totalEnabled === totalChecked);
    });

    // Tick All checkbox (select all across pages)
    $(document).on('change', '#checkAll', function () {

        if (this.checked) {

            $('.row-check').each(function () {

                if ($(this).prop('disabled')) return; // skip not allowed

                $(this).prop('checked', true).trigger('change');
            });

        } else {

            $('.row-check').prop('checked', false).trigger('change');
        }
    });

    // Restore checked state on redraw (pagination / search / reload)
    $('#sortingPendingList').on('draw.dt', function () {

        $('.row-check').each(function () {

            let shiftDate = $(this).data('shiftdate');

            if (!isAllowedByDelay(shiftDate)) {
                $(this).prop('checked', false);
                $(this).prop('disabled', true);   // 🔥 cannot select
            } else {
                $(this).prop('disabled', false);
            }
        });

        // also reset checkAll
        $('#checkAll').prop('checked', false);
    });


    //Bulk approval
    $('#btnBulkApprove').on('click', function () {

        if (selectedIds.size === 0) {
            Swal.fire({
                title: 'Warning',
                text: "Please select at least one record.",
                icon: 'warning',
                iconColor: "#286912",
                confirmButtonColor: '#28a745'
            });
            return;
        }

        $('#bulk_approval_remark').val('');
        $('#approveCount').text(selectedIds.size);

        $('#bulkapproveModal').modal('show');
    });

    $('#bulkapproveForm').on('submit', function (e) {
        e.preventDefault();

        let remark = $(this).find('textarea[name="remark"]').val().trim();
        $('#btnConfirmApproveBulk').prop('disabled', true);

        $.ajax({
            url: 'fetch-inspection-bulk-action.php',
            type: 'POST',
            dataType: 'json', 
            data: {
                ids: Array.from(selectedIds),
                remark: remark,
                action : 'bulk_approve'
            },
            success: function (r) {

                $('#btnConfirmApproveBulk').prop('disabled', false);

                if (r.status === 'success') {
                    $('#bulkapproveModal').modal('hide');

                    Swal.fire({
                        title: 'Success',
                        text: r.message,
                        icon: 'success',
                        iconColor: "#286912",
                        confirmButtonColor: '#28a745'
                    });

                    selectedIds.clear();
                    $('#checkAll').prop('checked', false);
                    table.ajax.reload(null, false);
                    fetchTotalCounts();
                    reloadCounts();
                    reloadActivityComments();

                } else {
                    Swal.fire({
                        title: 'Error',
                        text: r.message || 'Unknown error',
                        icon: 'error'
                    });
                }
            },
            error: function (xhr) {
                $('#btnConfirmApproveBulk').prop('disabled', false);
                console.error(xhr.responseText);

                Swal.fire({
                    title: 'Error',
                    text: 'Server error occurred',
                    icon: 'error'
                });
            }
        });
    }); 

    //Bulk return
    $('#btnBulkReturn').on('click', function () {

        if (selectedIds.size === 0) {
            Swal.fire({
                title: 'Warning',
                text: "Please select at least one record.",
                icon: 'warning',
                iconColor: "#286912",
                confirmButtonColor: '#28a745'
            });
            return;
        }

        $('#bulk_return_remark').val('');
        $('#returnCount').text(selectedIds.size);

        $('#bulkreturnModal').modal('show');
    });

    $('#bulkreturnForm').on('submit', function (e) {
        e.preventDefault();

        let remark = $(this).find('textarea[name="remark"]').val().trim();
        $('#btnConfirmReturnBulk').prop('disabled', true);

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing comment',
                confirmButtonColor: '#28a745',
                text: 'Please state the comment or reason.',
            });
            $('#bulk_return_remark').addClass('border-error');
            return;
        }
        $('#bulk_return_remark').removeClass('border-error');

        $.ajax({
            url: 'fetch-inspection-bulk-action.php',
            type: 'POST',
            dataType: 'json', 
            data: {
                ids: Array.from(selectedIds),
                remark: remark,
                action : 'bulk_return'
            },
            success: function (r) {

                $('#btnConfirmReturnBulk').prop('disabled', false);

                if (r.status === 'success') {
                    $('#bulkreturnModal').modal('hide');

                    Swal.fire({
                        title: 'Success',
                        text: r.message,
                        icon: 'success',
                        iconColor: "#286912",
                        confirmButtonColor: '#28a745'
                    });

                    selectedIds.clear();
                    $('#checkAll').prop('checked', false);
                    table.ajax.reload(null, false);
                    fetchTotalCounts();
                    reloadCounts();
                    reloadActivityComments();

                } else {
                    Swal.fire({
                        title: 'Error',
                        text: r.message || 'Unknown error',
                        icon: 'error'
                    });
                }
            },
            error: function (xhr) {
                $('#btnConfirmReturnBulk').prop('disabled', false);
                console.error(xhr.responseText);

                Swal.fire({
                    title: 'Error',
                    text: 'Server error occurred',
                    icon: 'error'
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