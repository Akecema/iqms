<!-- System title -->
<?php include "../system-header.php";?>

<!-- Session start -->
<?php include "session-start.php"; ?> 
<?php include "get-authorization-pdi.php"; ?>

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
    <link href="css/badge.css" rel="stylesheet">
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

        $startDate = date('m/01/Y') ; //2023-01-01
        $endDate = date('m/t/Y'); //2023-01-31

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

		#s2wReviewedList tbody tr td:last-child {
            text-align: left !important; 
        }

        #s2wReviewedList thead tr th:last-child{
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

        #remarkModal .modal-dialog {
            margin-top: -140px;   /* adjust distance from top */
            margin-right: 50px;
        }

        #remarkContent {
            white-space: pre-wrap; /* support long text and line breaks */
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
                        <?=$side_menu11;?>
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                        <ul class="nav nav-pills success-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active text-dark" data-series="social" onclick="location.href='#'">
                                    <i class="bi bi-calendar-check fs-4 text-primary"></i>
                                    <span>Today</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-series="project" onclick="location.href='ip-s2w-pending-pre.php'">
                                    <i class="bi bi-arrow-clockwise fs-3 text-muted"></i>
                                    <span>Previous</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                    <!-- <div class="d-flex align-items-center ms-auto">
                        <select class="default-select status-select normal-select" id="filterLink">
                            <option value="inspection-rcd-pendingreview.php">Today</option>
                            <option value="inspection-rcd-pendingreview-pre.php">Previous</option>
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
                                        <a class="nav-link" href="ip-s2w-pending.php">
                                            Pending Approval
                                            <span id="countPending" class="badge badge-circle badge-light badge-primary light ms-2">0</span>
                                        </a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#">
                                            Reviewed
                                            <span id="countReviewed" class="badge badge-circle badge-light badge-primary light ms-2">0</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="ip-s2w-approved.php">
                                            Approved
                                            <span id="countApproved" class="badge badge-circle badge-light badge-primary light ms-2">0</span>
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
                                                <div class="row">
                                                    <div class="col-xl-3 col-sm-6 mb-2">
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
                                                    <div class="col-xl-3 col-sm-6 mb-2">
                                                        <label class="form-label">Type</label>
                                                        <div id="div_type">
                                                            <select class="form-control filter-select cs_type" name="fd_type" id="fd_type">
                                                                <option value="">Select Type</option>                                                    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-sm-6 mb-2">                                            
                                                        <label class="form-label">Part No</label>
                                                        <div id="div_material">
                                                            <select class="form-control filter-select cs_material" name="fd_material" id="fd_material">
                                                                <option value="">Select Part no</option>                                                    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-3 col-sm-6 align-self-end mb-2">
                                                        <!-- Hidden row id -->
                                                        <input type="hidden" id="hidden_shift" value="<?=$current_shift;?>"/>
                                                        <input type="hidden" id="hidden_shift_date" value="<?= $shift_date; ?>">
                                                        <div>
                                                            <button class="btn btn-rounded btn-black text-white btn-sm me-2" type="button" id="btnFilterSearch" data-bs-toggle="tooltip" title="">Search</button>                                                                
                                                            <button type="button" id="btnResetFilter" class="btn btn-rounded btn-dark btn-sm" data-bs-toggle="tooltip" title="">
                                                                <i class="fa fa-undo me-1"></i> Reset
                                                            </button>                                                    
                                                        </div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">                                                                                                      
                                                <!-- <small class="table-tip d-inline-flex align-items-center">
                                                    <i class="fa fa-info-circle me-1" data-bs-toggle="tooltip" title="Use # to search specific pallet sequence. Example: #3"></i>
                                                    Tip: Use <code>#</code> to search by pallet sequence (e.g. <code>#3</code>)
                                                </small> -->
                                                <?php $canApprove = ($S2W_approver ?? 'N') === 'Y'; ?>
                                                <div class="table-responsive"><?= "Autho:".$S2W_approver ?>
                                                    <table id="s2wReviewedList" class="display table mb-1 table-striped-thead table-wide table-md">                                                              
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th class="nosort">
    <input type="checkbox"
           id="checkAll"
           class="form-check-input"
           <?= $canApprove ? '' : 'disabled' ?>>
</th>
                                                                <th>Doc No</th>
                                                                <th>Part No</th>                                                                
                                                                <th>Inspection Date</th>
                                                                <th>Shift</th>
                                                                <th>Status</th>
                                                                <th class="nosort">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                
                                                <button id="btnBulkApprove" class="btn btn-black me-2" disabled>
                                                    <i class="fa fa-check-double"></i> Approve Selected
                                                </button>

                                                <button id="btnBulkReturn" class="btn btn-black" disabled>
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
                                            
                                            <!-- Hiidden ir_id, sr_id -->
                                            <input type="hidden" name="sr_id" id="approve_sr_id">
                                            <input type="hidden" name="ir_id" id="approve_ir_id">
                                            <input type="hidden" name="s2w_id" id="approve_s2w_id">
                                            <input type="hidden" id="approve_mode" value="">

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
   
                                            <!-- Hiidden ir_id, sr_id -->
                                            <input type="hidden" name="sr_id" id="return_sr_id">
                                            <input type="hidden" name="ir_id" id="return_ir_id">
                                            <input type="hidden" name="s2w_id" id="return_s2w_id">
                                            <input type="hidden" id="return_mode">

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
                                            <button type="submit" class="btn btn-black" id="btnConfirmApproveBulk"><i class="fa fa-check"></i> Approve</button>
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

                            <!-- Zoom Image Modal -->
                            <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content" style="background: transparent; border: none;">
                                        <img src="" id="zoomedImage" class="img-fluid rounded shadow" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                                    </div>
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
        xhr.send();about:blank#blocked
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

    </script>

    <script>

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#s2wReviewedList').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

    <script>

    //Disbaled button selected
    // function toggleBulkButtons() {

    //     let info = table.page.info();
    //     let hasData = info.recordsDisplay > 0;

    //     // Disable checkAll if no data
    //     $('#checkAll').prop('disabled', !hasData);

    //     // If no data → force clear everything
    //     if (!hasData) {
    //         selectedIds.clear();
    //         selectAllPages = false;
    //         $('#checkAll').prop('checked', false);
    //     }

    //     // Also disable checkAll if no data
    //     $('#checkAll').prop('disabled', !hasData).prop('checked', false);

    //     // Button depends on selection
    //     updateBulkButtonsBySelection();
    // }

    //Disbaled button selected
    const authoS2W = "<?= trim($S2W_approver) ?>"; // Y / N

    function toggleBulkButtons() {

        let info = table.page.info();
        let hasData = info.recordsDisplay > 0;

        // AUTHORIZATION FIRST — STOP EVERYTHING
        if (authoS2W === 'N') {
            $('#checkAll')
                .prop('checked', false)
                .prop('disabled', true);

            selectedIds.clear();
            selectAllPages = false;

            updateBulkButtonsBySelection();
            return; 
        }

        // DATA-BASED LOGIC (ONLY FOR AUTHORIZED USERS)
        if (!hasData) {
            $('#checkAll')
                .prop('checked', false)
                .prop('disabled', true);

            selectedIds.clear();
            selectAllPages = false;
        } else {
            $('#checkAll').prop('disabled', false);
        }

        updateBulkButtonsBySelection();
    }

    let table; // Global table

    $(document).ready(function () {
        
        // Init DataTable
        table = $('#s2wReviewedList').DataTable({
            processing: true,
            serverSide: true,
            order: [[2, 'desc']],
            lengthChange: false,
            scrollX: true,            // horizontal scroll for wide columns
            scrollY: 'calc(100vh - 170px)', // dynamic vertical scroll (auto fits screen)
            scrollCollapse: true,     // collapses empty space if fewer rows
            autoWidth: false,
            drawCallback: function () {
                toggleBulkButtons();
            },
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            },
            ajax: {
                url: 'fetch-ip-s2w-pending.php',
                method: 'POST',
                data: function (d) {
                    d.action = 'fetch_records_reviewed';
                    d.model = $('.cs_model').val();
                    d.type = $('.cs_type').val();
                    d.material = $('.cs_material').val();
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

        // Load counts on page load
        reloadCounts();

        // Load activity comment
        reloadActivityComments();

        // Filter search
        $('#btnFilterSearch').on('click', function (e) {
            e.preventDefault();
            table.ajax.reload();
        });

        // Reset filter
        $('#btnResetFilter').on('click', function () {
            $('.cs_model').val('').trigger('change');
            $('#div_type').html('<select class="form-control cs_type"><option value="">Select Type</option></select>');
            $('#div_material').html('<select class="form-control cs_material"><option value="">Select Part No</option></select>');
            table.ajax.reload();
        });

    });

    </script>

    <script>

    function reloadCounts() {
        $.post('count-s2w-approval.php', {
            shift: $('#hidden_shift').val(),
            shift_date: $('#hidden_shift_date').val()
        }, function(res) {

            const data = JSON.parse(res);
            // Update badges
            $('#countPending').text(data.pending);
            $('#countReviewed').text(data.reviewed);
            $('#countApproved').text(data.approved);
        });
    }

    </script>
    
    <script>

    function reloadActivityComments() {

        const shift = $('#hidden_shift').val();
        const shift_date = $('#hidden_shift_date').val();
        console.log("Reloading comments with:", { shift, shift_date });
        
        $.post('fetch-activity-comment.php', {
            shift: $('#hidden_shift').val(),
            shift_date: $('#hidden_shift_date').val(),
            section: 'PDI',
            task: 'S2W'
        })
        .done(function(res) {
            console.log('Comment response:', res);
            $('#activityCommentContainer').html(res);
        })
        .fail(function(xhr) {
            console.error('Comment load failed:', xhr.status, xhr.responseText);
            $('#activityCommentContainer').html('<p class="text-danger">Failed to load activity comments.</p>');
        });
    }

    </script>
  
    <script>

    $(document).on('click', '.viewDocDetails', function() {

        const irid = $(this).data('irid'); 
        const docno = $(this).data('docno');
        const pg = 'r';

        // Build URL safely with encodeURIComponent
        const targetUrl = 'ip-s2w-pending-det.php?docno=' 
                        + encodeURIComponent(docno)                         
                        + '&irid=' + encodeURIComponent(irid) 
                        + '&pg=' + encodeURIComponent(pg);

        window.location.href = targetUrl;
    });
    
    </script>

    <script>

    $(document).on('click', '.zoomable-img', function () {
        const src = $(this).data('src');
        $('#zoomedImage').attr('src', src);
        const zoomModal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        zoomModal.show();
    });

    </script>

    <script>

    $(document).on('click', '.btnApprove', function () {

        const ir_id = $(this).data('irid'); 
        const sr_id = $(this).data('srid');
        const s2w_id = $(this).data('s2wid');  
        
        $('#approve_sr_id').val(sr_id); 
        $('#approve_ir_id').val(ir_id);
        $('#approve_s2w_id').val(s2w_id);  
        $('#approval_remark').val('');
        $('#approval_remark').removeClass('border-error');

        new bootstrap.Modal(document.getElementById('approveModal')).show();
    });

    $('#approval_remark').on('change', function() {
        $(this).removeClass('border-error');
    }); 

    $('#approveForm').on('submit', function (e) {
        e.preventDefault();

        const sr_id = $('#approve_sr_id').val();       
        const ir_id = $('#approve_ir_id').val();        
        const s2w_id = $('#approve_s2w_id').val();   
        const remark = $('#approval_remark').val().trim();

        // if (!remark) {
        //     Swal.fire({
        //         icon: 'warning',
        //         title: 'Missing Reason',
        //         text: 'Please state the comment or reason.',
        //     });
        //     $('#approval_remark').addClass('border-error');
        //     return;
        // }
        // $('#approval_remark').removeClass('border-error');

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to approve this S2W?",
            icon: 'question',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, approve it'
        }).then((result) => {
            if (result.isConfirmed) {
                const $btn = $('#btnConfirmApprove');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Approving...');

                $.ajax({
                    url: 'fetch-ip-s2w-pending.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'approve_s2w',
                        ir_id: ir_id,
                        sr_id: sr_id,
                        s2w_id: s2w_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Approve');
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Approved',
                                text: 'S2W approved successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            $('#approveModal').modal('hide');

                            // Reload table
                            table.ajax.reload(null, false);

                            // Refresh total counts
                            reloadCounts();
                            // Reload activity
                            reloadActivityComments();
                            
                        } else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: "#286912",
                                title: 'Error',
                                text: res.message || 'Approval failed.',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function () {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
                            title: 'Error',
                            text: res.message || 'Approval failed.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    });

    //Return
    $(document).on('click', '.btnReturn', function () {

        const ir_id = $(this).data('irid'); 
        const sr_id = $(this).data('srid'); 
        const s2w_id = $(this).data('s2wid');  
        
        $('#return_sr_id').val(sr_id); 
        $('#return_ir_id').val(ir_id); 
        $('#return_s2w_id').val(s2w_id); 
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

        const sr_id = $('#return_sr_id').val();       
        const ir_id = $('#return_ir_id').val();       
        const s2w_id = $('#return_s2w_id').val();     
        const remark = $('#return_remark').val().trim();

        if (!remark) {
            if (!remark) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Missing Reason',
                    text: 'Please state the comment or reason.',
                });
            }
            $('#return_remark').addClass('border-error');
            return;

        } else {
            $('#return_remark').removeClass('border-error');
        }

        //Confirmation prompt before approving
        Swal.fire({
            title: 'Are you sure?',
            text: "Return this S2W?",
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
                    url: 'fetch-ip-s2w-pending.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'approve-return',
                        ir_id: ir_id,
                        sr_id: sr_id,
                        s2w_id: s2w_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Return');
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Return',
                                text: 'The S2W has been returned successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            $('#returnModal').modal('hide');

                            // Refresh DataTable
                            table.ajax.reload(null, false);

                            // Load counts on page load
                            reloadCounts();
                            
                            // Reload activity
                            reloadActivityComments();

                        } else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: "#286912",
                                title: 'Error',
                                text: res.message || 'Approval failed.',
                                timer: 3000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function () {
                        Swal.close();
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
                            title: 'Error',
                            text: 'Server error while approving.',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    }
                });
            }
        });
    });

    </script> 

    <script>

    function updateBulkButtonsBySelection() {

        let hasSelected = selectedIds.size > 0;

        $('#btnBulkApprove').prop('disabled', !hasSelected);
        $('#btnBulkReturn').prop('disabled', !hasSelected);
    }

    </script>
    
    <script>

    let selectedIds = new Set();
    let selectAllPages = false; // 

    // Row checkbox
    $(document).on('change', '.row-check', function () {
        let id = $(this).val();

        if (this.checked) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
            selectAllPages = false;
            $('#checkAll').prop('checked', false);
        }

        updateBulkButtonsBySelection(); // ✅ add this
    });

    // Tick All checkbox (select all across pages)
    $(document).on('change', '#checkAll', function () {
        selectAllPages = this.checked;

        if (selectAllPages) {
            $('.row-check').prop('checked', true);

            $('.row-check').each(function () {
                selectedIds.add(this.value);
            });
        } else {
            $('.row-check').prop('checked', false);
            selectedIds.clear();
        }

        updateBulkButtonsBySelection(); // ✅ add this
    });

    // Restore checked state on redraw (pagination / search / reload)
    $('#s2wReviewedList').on('draw.dt', function () {

        $('.row-check').each(function () {
            let id = $(this).val();

            if (selectAllPages || selectedIds.has(id)) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });

        $('#checkAll').prop('checked', selectAllPages);

        updateBulkButtonsBySelection(); // ✅ add this
    });

    </script>

    <script>

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

        let remark = $('#bulk_approval_remark').val().trim();

        $.ajax({
            url: 'fetch-s2w-bulk-action.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'bulk_approve',
                remark: remark,
                ids: Array.from(selectedIds)   // send sr_id list only
            },
            success: function (r) {

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
                    reloadCounts();
                    reloadActivityComments();

                } else {
                    Swal.fire({
                        title: 'Error',
                        text: r.message || 'Approval failed.',
                        icon: 'error'
                    });
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                Swal.fire("Error", "Server error occurred", "error");
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
        // $('#btnConfirmReturnBulk').prop('disabled', true);

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
            url: 'fetch-s2w-bulk-action.php',
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