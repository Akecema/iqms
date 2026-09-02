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
    
	<!-- <link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet"> -->

    <!-- Tagify Css -->
	<link href="vendor/tagify/dist/tagify.css" rel="stylesheet">	
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
    
	<link href="vendor/nestable2/css/jquery.nestable.min.css" rel="stylesheet">
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

        <style>

        .filter-select { min-width: 180px; }
        .input-group .form-control { min-width: 160px; }

        /* checkbox  */
        .area-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);  /* 4 columns per row */
            gap: 0.5rem 2.0rem;  /* row-gap, col-gap: adjust as needed */
            max-width: 100%;
            margin: 16px 0;
            padding: 16px; 
            border-radius: 12px;
        }
        .area-grid .form-check {
            margin-bottom: 0;
        }

        .area-grid .form-check-label {
            display: flex;
            align-items: center;
            gap: 1.0em; /* Increase or decrease this value for more/less space */
        }

        .date-label {
            font-size: 11px;
            font-weight: 400;
            color: #DEDCDC;
        }

        .remove-image {
            background: #000;
            color : #E4EBE1;
            border-radius: 50%;
            padding: 0 3px;
            border: 1px solid #000;
            line-height: 1;
        }

        .remove-image-defect-old
        {
            background: #000;
            color : #E4EBE1;
            border-radius: 50%;
            padding: 0 3px;
            border: 1px solid #000;
            line-height: 1;
        }

        .remove-image-compare-old
        {
            background: #000;
            color : #E4EBE1;
            border-radius: 50%;
            padding: 0 3px;
            border: 1px solid #000;
            line-height: 1;
        }
        
        .input-error, .select-error {
            border: 1px solid #e74c3c !important;  /* Red border */
            background-color: #fff6f6;
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

        .avatar-list.avatar-list-inline a {
            margin-right: -10px;   /* pull images closer together */
        }

        .avatar-list.avatar-list-inline img {
            margin: 0;            /* remove image margin */
            padding: 0;
        }
        
        .zoomable-img {
            width: 65px;
            height: 65px;
            border-radius: 50% !important; 
            object-fit: cover;
            cursor: zoom-in;
            border: 1px solid #ddd;
            transition: .2s ease-in-out;
        }

        .zoomable-img:hover {
            transform: scale(1.32);
            box-shadow: 0 3px 6px rgba(0,0,0,0.15);
        }

        .checkbox-error {
            outline: 2px solid #e74c3c;  /* For checkbox group */
        }

        /* table header, body align */
        #inspectionTable_defect tbody tr td:last-child {
            text-align: left; 
        }

        #inspectionTable_defect thead tr th:last-child {
            text-align: left !important; 
        }

        .dataTables_filter, .dataTables_length {
            display: none !important;
        }

        .defect-list {
            border: 1px solid #cacfcaff;        
            background: rgba(81, 81, 81, 0.1);            
            border-radius: 5px;
            margin: 16px 0;
            padding: 20px 10px;
            box-shadow: 0 4px 16px 0 rgba(226,174,110,0.09); 
        }

        /* Make defect-list table transparent inside card */
        .defect-list table {
            background: transparent;
            margin-bottom: 0;
        }

        /* Optional: for mobile/smaller screens */
        @media (max-width: 600px) {
        .defect-list {
            margin: 8px 2px;
            padding: 12px 4px;
        }
        }

        .defect-details-row td {
            background: transparent;
            border-bottom: 2px solid #e5dbc6;
            padding: 16px 24px;
        }
        .defect-list table {
            background: transparent;
        }

        /* Reduce padding for table cells */
        .defect-list table td
        {
            padding-left: 8px;
            padding-right: 8px;
            font-size : 12px;
        }
        .defect-list table th {
            padding-left: 8px;
            padding-right: 8px;
            font-size : 12px;
            font-weight :600;
        }

        /* First column (#) even smaller */
        .defect-list table td:first-child,
        .defect-list table th:first-child {
            padding-left: 4px;
            width: 40px; /* optional fixed width for # column */
        }

        #inspectionGroupsList tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionGroupsList thead tr th:last-child{
            text-align: left !important;
        }
        
        #fd_defectType + .select2-container {
            width: 250px !important;
        }

        .avatar-preview {
            position: relative;
            display: inline-block;
        }
        .remove-image-btn {
            position: absolute;
            top: -15px;
            right: -15px;
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #181818;
            color: #fff;
            font-size: 18px;
            line-height: 24px;
            text-align: center;
            cursor: pointer;
            z-index: 10;
            border: 2px solid #fff; /* optional: white border for visibility */
            transition: background 0.2s, color 0.2s;
        }
        .remove-image-btn:hover {
            background: #B31236;
            color: #fff;
            border-color: #FAF7F9;
        }

        .border-error {
            border: 2px solid #eb2020ff !important;   
            background-color: #FAF7F9 !important;
            color : #2D2E2D;   
        }

        .border-error:hover {
            color: #181818 !important;  
        }

        #inspectionGroupsList tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionGroupsList thead tr th:last-child{
            text-align: left !important;
        }

        .dataTables_filter input {
            width: 180px !important; /* or any size you want */
            height: 35px !important;             /* optional */
            font-size: 11px !important;          /* optional */
        }
        
        .badge-sm {
            font-size: 0.75rem;
            padding: 0.42em 0.65em;
        }

        #searchInput::placeholder {
            font-size: 11px; 
            color: #c3c1c0ff;       /* optional: change placeholder color */
        }

        .custom-text-mat
        {
            font-size: 12px;
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

        .modal-header {
            border-bottom: none !important;
        }

        div.dataTables_wrapper {
            width: 100%;
        }

        .dataTables_scrollBody {
            overflow-x: auto !important;
            overflow-y: auto !important;
        }

        </style>

		<?php

        $startDate = date('m/01/Y') ; //2023-01-01
        $endDate = date('m/t/Y'); //2023-01-31
        
        ?>

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
                        <?=$side_menu5;?>
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
                                <button class="nav-link" data-series="project" onclick="location.href='inspection-rcd-list-pre.php'">
                                    <i class="bi bi-arrow-clockwise fs-3 text-muted"></i>
                                    <span>Previous</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <?php

                $today = date('Y-m-d');

                // Get total inspections for today
                $queryToday = "SELECT COUNT(DISTINCT inspect_group) AS total_groups FROM inspection_records 
                                    WHERE ir_shift = '$current_shift' AND shift_date = '$shift_date'";

                if ($session_role == 4) {
                    // Restrict to only their own records
                    $queryToday .= " AND created_by = '$session_id' ";
                }

                $resultToday = mysqli_query($db_con, $queryToday);
                $rowToday = mysqli_fetch_assoc($resultToday);

                // Get total inspections for history (not today)
                $queryAll = "SELECT COUNT(ir_id) AS total_inspections FROM inspection_records
                                WHERE ir_shift = '$current_shift' AND shift_date = '$shift_date'";
                        
                if ($session_role == 4) {
                    // Restrict to only their own records
                    $queryAll .= " AND created_by = '$session_id' ";
                }

                $resultAll = mysqli_query($db_con, $queryAll);
                $rowAll = mysqli_fetch_assoc($resultAll);

                ?>

                <div class="card h-auto">
                    <div class="card-body ai-tabs-1 py-2">
                        <ul class="nav nav-tabs align-items-end" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" href="inspection-rcd-list.php">
                                Grouped by Material
                                <span class="badge badge-circle badge-light badge-primary light ms-2">
                                    <?= $rowToday['total_groups']; ?>
                                </span>
                            </a>
                            </li>
                            <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="#">
                                All Records
                                <span class="badge badge-circle badge-light badge-primary light ms-2"><?= $rowAll['total_inspections']; ?></span>
                            </a>
                            </li>								  
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                        <div class="row">                    
                            <div class="col-12">
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row task">
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-koko count count-new"><?= $total_new ?></h2> 
                                                            <span>New Created</span>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-sven">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-purple count count-pending"><?= $total_pending ?></h2>
                                                            <span>Pending Review</span>
                                                        </div>	
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-eleven">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-danger count count-cancelled"><?= $total_cancelled ?></h2>
                                                            <span>Cancelled</span>
                                                        </div>	
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-eleven">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-teal count count-returned"><?= $total_returned ?></h2>
                                                            <span>Returned</span>
                                                        </div>	
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-odd">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-warning count count-approved"><?= $total_approved ?></h2>
                                                            <span>Approved</span>
                                                        </div>	
                                                        
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-odd">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-pink count count-completed"><?= $total_completed ?></h2>
                                                            <span>Completed</span>
                                                        </div>	
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row g-3">
                                                        <!-- Row 1 -->
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
                                                                    <option value="">Select Part No</option>                                                    
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Row 2 -->
                                                        <div class="col-md-3 mb-2">                                            
                                                            <label class="form-label">Production Date Range</label>
                                                            <input class="form-control input-daterange-datepicker" type="text" name="daterange" id="daterange_prod" value="">
                                                        </div>
                                                        <div class="col-md-3 mb-2">                                           
                                                            <label class="form-label">Shift</label>
                                                            <select class="form-control filter-select cs_shift" name="fd_shift" id="fd_shift" >
                                                                <option value="">Select Shift</option>
                                                                <option value="D">Day</option>
                                                                <option value="N">Night</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-2">                                                                                                
                                                            <label class="form-label">Status</label>
                                                            <?php
                                                            // Get status options
                                                            $statusOptions = [];
                                                            $sqlStatusFilter = "SELECT statusid, statusname FROM system_status WHERE status = 'AC' AND inspection = 'Y' ORDER BY statusid";
                                                            $resultStatusFilter = $db_con->query($sqlStatusFilter);

                                                            while ($statusRow = $resultStatusFilter->fetch_assoc()) {
                                                                $statusOptions[] = $statusRow;
                                                            }
                                                            ?>

                                                            <!-- Status Filter -->
                                                            <select id="filterStatus" class="filter-select">
                                                                <option value="">Any Status</option>
                                                                <?php foreach ($statusOptions as $status): ?>
                                                                    <option value="<?= $status['statusid'] ?>"><?= $status['statusname'] ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3 mb-2">                                           
                                                            <label class="form-label">Result</label>
                                                            <select id="filterResult" class="filter-select ">
                                                                <option value="">Any Result</option>
                                                                <option value="OK">OK</option>
                                                                <option value="NG">NG</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <!-- Buttons -->
                                                    <div class="text-end mt-3">
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
                                                <div class="col-xl-4 col-sm-3 mb-2 ms-auto">                                            
                                                        <!-- Search Box -->
                                                    <div class="input-group flex-grow-1 mb-2">
                                                        <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                                        <input type="text" id="searchInput" class="form-control" placeholder="Search document no or #pallet sequence">
                                                    </div>
                                                    <div class="form-text small text-muted">
                                                        <i class="fa fa-info-circle me-1" data-bs-toggle="tooltip" data-bs-custom-class="tooltip-sm" title="Use # to search specific pallet sequence. Example: #3"></i>
                                                        <!-- Use <code>#</code> to search by pallet sequence (e.g. <code>#3</code>) -->
                                                    </div>
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="inspectionGroupsList" class="display table mb-1 table-striped-thead table-wide table-md">                                                              
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th class="nosort  align-middle"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                                                <th>Doc No</th>
																<th>Part No</th>
																<th>Model</th>
																<th>Inspection Date</th>
																<th>Shift</th>
                                                                <th class="pallet-col">Pallet Sequence</th>
                                                                <th>Result</th>
                                                                <th>Production Date</th>
                                                                <th>Status</th>
                                                                <th class="nosort">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                
                                                <div class="mt-4">
                                                    <button id="btnSubmitSelected" class="btn btn-black me-1" disabled>Submit Selected</button>
                                                    <button id="btnCancelSelected" class="btn btn-black" disabled>Cancel Selected</button> 
                                                </div> 
                                                
                                            </div>                                            

                                            <!-- View material images -->
                                            <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content bg-transparent border-0 shadow-none">
                                                        <img id="previewImage" src="" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px; box-shadow:0 2px 24px #0006;">
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

                                            <!-- Add NG details -->
                                            <div class="modal fade bd-example-modal-lg" id="ngModal" tabindex="-1" aria-labelledby="ngModalLabel" >
                                                <div class="modal-dialog  modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">                                                    
                                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>    
                                                        <div class="modal-body">                                        
                                                            <div class="row"> 

                                                                <!-- Hidden inspection row id -->
                                                                <input type="hidden" id="ng_ir_id" name="ng_ir_id">

                                                                <div class="col-xl-6 col-lg-9 col-md-9">
                                                                    <!-- <h4 class="d-flex justify-content-between align-items-center mb-3">
                                                                        <span class="text-dark">Your cart</span>
                                                                        <span class="badge badge-primary badge-pill">3</span>
                                                                    </h4> -->
                                                                    <form id="form1">
                                                                    <ul class="list-group mb-3">
                                                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                                            <div>
                                                                                <h6 class="my-0 mb-3">Type of Defect</h6>
                                                                                <?php
                                                                                
                                                                                $cstatus = 'Y';

                                                                                $query_typeDefc = "SELECT defectid, defectname FROM defect_type WHERE defectstatus = ? ORDER BY defectname ASC";
                                                                                $get_typeDefc = $db_con->prepare($query_typeDefc); 
                                                                                $get_typeDefc->bind_param("s", $cstatus);
                                                                                $get_typeDefc->execute();
                                                                                $result_typeDefc = $get_typeDefc->get_result(); 

                                                                                ?>
                                                                                
                                                                                <select class="form-control " name="fd_defectType_add" id="fd_defectType_add">
                                                                                    <option value="">Select Defect</option>
                                                                                    <?php
                                                                                    while ($row_alltype_defc = mysqli_fetch_array($result_typeDefc)) {
                                                                                    ?>
                                                                                        <option value="<?php echo $row_alltype_defc['defectid']; ?>" 
                                                                                            <?= (isset($_GET['fd_defectType']) && $_GET['fd_defectType'] == $row_alltype_defc['defectid']) ? "selected" : "" ?>>
                                                                                            <?php echo $row_alltype_defc['defectname']; ?>
                                                                                        </option>
                                                                                    <?php } ?>
                                                                                </select>                                                  

                                                                            </div>                                                
                                                                        </li>
                                                                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                                            <div>
                                                                                <h6 class="my-0 mb-3">Area of Defect</h6>
                                                                                <div class="mb-3 area-grid">
                                                                                    <?php
                                                                                    $query = "SELECT areamax FROM defect_area WHERE areaid = 1"; 
                                                                                    $result = $db_con->query($query);
                                                                                    $row = $result->fetch_assoc();
                                                                                    $max = (int)$row['areamax'];
                                                                                    ?>

                                                                                    <?php
                                                                                    for ($i = 1; $i <= $max; $i++) {
                                                                                        echo '
                                                                                        <div class="form-check">
                                                                                            <input type="checkbox" class="form-check-input" name="fd_area_add[]" value="'.$i.'" id="area_add_'.$i.'">
                                                                                            <label class="form-check-label" for="area_add_'.$i.'">'.$i.'</label>
                                                                                        </div>
                                                                                        ';
                                                                                    }
                                                                                    ?>                                                           
                                                                                    
                                                                                </div>
                                                                            </div>                                       
                                                                        </li>
                                                                    </ul> 
                                                                    </form>                                      
                                                                </div>

                                                                <!--Tab slider End-->
                                                                <div class="col-xl-6 col-lg-3 col-md-3 col-sm-9">
                                                                    <div class="product-detail-content">
                                                                        
                                                                        <!--Defect details-->
                                                                        <div class="new-arrival-content pr">
                                                                            <h4>Defect Photos</h4>
                                                                            
                                                                            <div class="cm-content-body publish-content form excerpt">
                                                                                <div class="card-body">
                                                                                    <div class="row">                                                        
                                                                                        <div class="col-xl-12 col-sm-12">
                                                                                            <div class="avatar-upload d-flex flex-column">
                                                                                                <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_defect_add"></div>
                                                                                                <div class="change-btn mt-2">
                                                                                                    <input type="file" class="form-control d-none" name="imageUpload_defect_photo[]" id="imageUpload_defect" accept=".png, .jpg, .jpeg" multiple>
                                                                                                    <label for="imageUpload_defect" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                                                    <small class="text-muted d-block mt-1">Use ctrl key to select multiple images. Selected images will appear above.</small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>                                                        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        
                                                                            <div class="d-flex align-items-end flex-wrap mt-4">
                                                                                <h4>Comparison Photos</h4>
                                                                                
                                                                                <div class="cm-content-body publish-content form excerpt">
                                                                                    <div class="card-body">
                                                                                        <div class="row">                                                        
                                                                                            <div class="col-xl-12 col-sm-12">
                                                                                                <div class="avatar-upload d-flex flex-column">
                                                                                                    <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare_add"></div>
                                                                                                    <div class="change-btn mt-2">
                                                                                                        <input type="file" class="form-control d-none" name="imageUpload_compare_photo[]" id="imageUpload_compare" accept=".png, .jpg, .jpeg" multiple>
                                                                                                        <label for="imageUpload_compare" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                                                        <small class="text-muted d-block mt-1">Use ctrl key to select multiple images. Selected images will appear above.</small>
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
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light btnCloseModal_add" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-black" id="AddDefect"><i class="fa fa-check me-2"></i> Save</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Defect modal -->
                                            <div class="modal fade" id="editDefectModal" tabindex="-1" aria-labelledby="DefectModalLabel">
                                                <div class="modal-dialog  modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">                                                    
                                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>    
                                                        <div class="modal-body">                                        
                                                            <div class="row">  

                                                                <!-- Hidden inspection row id -->
                                                                <input type="hidden" id="ng_ir_id" name="ng_ir_id">
                                                                <input type="hidden" id="ng_defect_id" name="ng_defect_id">

                                                                <div class="col-xl-6 col-lg-9 col-md-9">                                            
                                                                    <form id="form1">
                                                                        <ul class="list-group mb-3">
                                                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                                                <div>
                                                                                    <h6 class="my-0 mb-3">Type of Defect</h6>
                                                                                    <?php
                                                                                    
                                                                                    $cstatus = 'Y';

                                                                                    $query_typeDefc = "SELECT defectid, defectname FROM defect_type WHERE defectstatus = ? ORDER BY defectname ASC";
                                                                                    $get_typeDefc = $db_con->prepare($query_typeDefc); 
                                                                                    $get_typeDefc->bind_param("s", $cstatus);
                                                                                    $get_typeDefc->execute();
                                                                                    $result_typeDefc = $get_typeDefc->get_result(); 

                                                                                    ?>
                                                                                    
                                                                                    <select class="form-control " name="fd_defectType_ed" id="fd_defectType_ed">
                                                                                        <option value="">Select Defect</option>
                                                                                        <?php
                                                                                        while ($row_alltype_defc = mysqli_fetch_array($result_typeDefc)) {
                                                                                        ?>
                                                                                            <option value="<?php echo $row_alltype_defc['defectid']; ?>" 
                                                                                                <?= (isset($_GET['fd_defectType']) && $_GET['fd_defectType'] == $row_alltype_defc['defectid']) ? "selected" : "" ?>>
                                                                                                <?php echo $row_alltype_defc['defectname']; ?>
                                                                                            </option>
                                                                                        <?php } ?>
                                                                                    </select>                                                  

                                                                                </div>                                                
                                                                            </li>
                                                                            <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                                                <div>
                                                                                    <h6 class="my-0 mb-3">Area of Defect</h6>
                                                                                    <div class="mb-3 area-grid">
                                                                                        <?php
                                                                                        $query = "SELECT areamax FROM defect_area WHERE areaid = 1"; 
                                                                                        $result = $db_con->query($query);
                                                                                        $row = $result->fetch_assoc();
                                                                                        $max = (int)$row['areamax'];
                                                                                        ?>

                                                                                        <?php
                                                                                        for ($i = 1; $i <= $max; $i++) {
                                                                                            echo '
                                                                                            <div class="form-check">
                                                                                                <input type="checkbox" class="form-check-input" name="fd_area_ed[]" value="'.$i.'" id="area_ed_'.$i.'">
                                                                                                <label class="form-check-label" for="area_'.$i.'">'.$i.'</label>
                                                                                            </div>
                                                                                            ';
                                                                                        }
                                                                                        ?>                                                           
                                                                                        
                                                                                    </div>
                                                                                </div>                                       
                                                                            </li>
                                                                        </ul> 
                                                                    </form>                                      
                                                                </div>

                                                                <!--Tab slider End-->
                                                                <div class="col-xl-6 col-lg-3 col-md-3 col-sm-9">
                                                                    <div class="product-detail-content">
                                                                        
                                                                        <!--Defect details-->
                                                                        <div class="new-arrival-content pr">
                                                                            <h4>Defect Photos</h4>
                                                                            
                                                                            <div class="cm-content-body publish-content form excerpt">
                                                                                <div class="card-body">
                                                                                    <div class="row">                                                        
                                                                                        <div class="col-xl-12 col-sm-12">
                                                                                            <div class="avatar-upload d-flex flex-column">
                                                                                                <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_ed"></div>
                                                                                                <div class="change-btn mt-2">
                                                                                                    <input type="file" class="form-control d-none" name="defect_photo_ed[]" id="imageUpload_defect_ed" accept=".png, .jpg, .jpeg" multiple>
                                                                                                    <label for="imageUpload_defect_ed" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                                                    <small class="text-muted d-block mt-1">Use ctrl key to select multiple images. Selected images will appear above.</small>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>                                                        
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        
                                                                            <div class="d-flex align-items-end flex-wrap mt-4">
                                                                                <h4>Comparison Photos</h4>
                                                                                
                                                                                <div class="cm-content-body publish-content form excerpt">
                                                                                    <div class="card-body">
                                                                                        <div class="row">                                                        
                                                                                            <div class="col-xl-12 col-sm-12">
                                                                                                <div class="avatar-upload d-flex flex-column">
                                                                                                    <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare_ed"></div>
                                                                                                    <div class="change-btn mt-2">
                                                                                                        <input type="file" class="form-control d-none" name="compare_photo_ed[]" id="imageUpload_compare_ed" accept=".png, .jpg, .jpeg" multiple>
                                                                                                        <label for="imageUpload_compare_ed" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                                                        <small class="text-muted d-block mt-1">Use ctrl key to select multiple images. Selected images will appear above.</small>
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
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light btnCloseModal_ed" data-bs-dismiss="modal"> Cancel</button>
                                                            <button type="button" class="btn btn-black" id="btnEditDefect_modal"><i class="fa fa-check me-2"></i> Save Changes</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Zoom Image Modal -->
                                            <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content bg-transparent border-0 shadow-none">
                                                    <div class="modal-body p-0 text-center">
                                                        <img src="" id="zoomedImage" class="img-fluid rounded shadow"
                                                            style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>

                                             <!-- Zoom Photo from defect list -->
                                            <div class="modal fade" id="photoZoomModal" tabindex="-1" aria-labelledby="photoZoomModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" id="photoZoomDialog">
                                                    <div class="modal-content">
                                                    <!-- <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button> -->
                                                    <div class="modal-body p-0 text-center">
                                                        <img id="zoomedPhoto" src="" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px; box-shadow:0 2px 24px #0006;">
                                                    </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <!-- Remark Modal -->
                                            <div class="modal fade" id="remarkModal" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-md">
                                                    <div class="modal-content border-0 shadow-sm">
                                                        <div class="modal-body p-3 d-flex align-items-start bg-light-green">
                                                            <!-- Icon -->
                                                            <div class="me-3">
                                                                <i class="fa fa-envelope fs-2 text-primary"></i>
                                                            </div>

                                                            <!-- Text -->
                                                            <div>
                                                                <h6 class="fw-bold mb-1">Remark</h6>
                                                                <p id="remarkContent" class="mb-0 small text-primary">
                                                                    <!-- Display remark here -->
                                                                </p>
                                                            </div>

                                                            <!-- Close button -->
                                                            <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Cancel Remark Modal -->
                                            <div class="modal fade" id="cancelRemarkModal" tabindex="-1" aria-labelledby="cancelRemarkLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                    <div class="modal-header">                                                    
                                                        <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                                        <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </div>    
                                                    <form id="cancelRemarkForm">
                                                        <div class="modal-body">
                                                        <input type="hidden" id="cancel_ir_id" name="ir_id">
                                                    
                                                        <div class="mb-3">
                                                            <label for="cancel_remark" class="form-label">Cancellation Rason <span class="text-danger">*</span></label>
                                                            <textarea class="form-control" id="cancel_remark" name="remark" rows="4" maxlength="500"></textarea>
                                                            <div class="form-text"><span id="cancel_count">0</span>/500</div>
                                                        </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-black" id="btnConfirmCancel"><i class="fa fa-times me-1"></i>Confirm Cancel</button>
                                                        </div>
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Bulk Cancel Modal -->
                                            <div class="modal fade" id="bulkcancelModal" tabindex="-1" aria-labelledby="bulkcancelModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form id="bulkcancelForm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">                                                    
                                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div> 
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="bulk_cancel_remark" class="form-label">Comment/ Reason <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" name="remark" id="bulk_cancel_remark" rows="4" style="color: #333;"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-black" id="btnConfirmCancelBulk"><i class="fa fa-undo"></i> Cancel Submission</button>
                                                        </div>
                                                    </div>
                                                    </form>
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
    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>

    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="js/highlight.min.js"></script>
    
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>

    <script>

    $(function() {
        //Initialize Select2 Elements
        $('.result-select').select2()
    });

    </script>

    <script>

    function reloadTotals() {
        $.ajax({
            url: 'count-inspection-status.php',
            method: 'POST',
            dataType: 'json',  // important
            success: function (data) {
                $('.count-new').text(data.new);
                $('.count-pending').text(data.pending);
                $('.count-approved').text(data.approved);
                $('.count-completed').text(data.completed);
                $('.count-cancelled').text(data.cancelled);
                $('.count-returned').text(data.returned);
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error, xhr.responseText);
            }
        });
    }

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

    $(document).on('click', '.viewMaterial', function () {
        const tr = $(this).closest('tr');
        const table = $('#inspectionGroupsList').DataTable();
        const row = table.row(tr);

        const material = $(this).data('material');
        const model    = $(this).data('model');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            $.post('fetch-material-gallery.php', { material, model }, function (res) {
            row.child(`<div class="p-2">${res}</div>`).show();
            tr.addClass('shown');
            });
        }
    });

    // When avatar is clicked
    $(document).on('click', '.viewAvatar', function () {
        const fullImg = $(this).data('full');
        $('#previewImage').attr('src', fullImg);

        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        modal.show();
    });

    // Zoom defec /compare photo in modal 
    $(document).on('click', '.zoomable-img', function() {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        console.log("Clicked:", imgSrc);
        $('#zoomedImage').attr('src', imgSrc);
        const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        modal.show();
    });

    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
    </script>

    <script>
    var modal = document.getElementById('detailModal');
    modal.addEventListener('shown.bs.modal', function () {
        var tooltipTriggerList = [].slice.call(modal.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>

    <script>
    $('.filter-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });
    </script>

    <script>

    $('#daterange_prod').daterangepicker({
        startDate: moment().startOf('month'),
        endDate: moment(),           // today selected by default
        maxDate: moment(),           // block future dates
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

    $('#daterange_prod').val('');

    // $('#daterange_prod').daterangepicker({
    //     startDate: moment().startOf('month'),
    //     endDate: moment(),           // today selected by default
    //     maxDate: moment(),           // block future dates
    //     locale: {
    //         format: 'DD/MM/YYYY'
    //     }
    // });

    </script>

    <script>

    let table;
    $(document).ready(function() {

        // Define globally accessible function
        window.fetchTotalCounts = function(fd_model = '', fd_type = '', fd_material = '', fd_shift = '', fd_status = '', fd_result = '') {
            $.post('count-ok-ng-pallet-list-all.php', {
                fd_model: fd_model,
                fd_type: fd_type,
                fd_material: fd_material,
                fd_shift: fd_shift,
                fd_status: fd_status,
                fd_result: fd_result
            }, function (res) {
                const data = JSON.parse(res);
                $('#totalOkPending span').text(data.ok);
                $('#totalNgPending span').text(data.ng);
            });
        };

        table = $('#inspectionGroupsList').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
			lengthChange: false,
            scrollX: true,
            scrollY: "300px",        
            scrollCollapse: true,
            language: {
                paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
            },
            "ajax": {
                url: 'fetch-inspection-rcd-all.php',
                method:"POST",
                data: function (d) {
                        d.action   = 'fetch_records_list_all';
                        d.fd_model = $('.cs_model').val();
                        d.fd_type = $('.cs_type').val();
                        d.fd_material = $('.cs_material').val();
                        d.fd_daterange = $('#daterange_prod').val();
                        d.fd_shift = $('.cs_shift').val();
                        d.fd_status = $('#filterStatus').val();
                        d.fd_result = $('#filterResult').val();
                        d.fd_search = $('#searchInput').val();

                        console.log("Filters sent to server:", d);                        
                    }
            },
            columnDefs: [
                    { targets: 'nosort', orderable: false }
            ],

            // Tooltip
            drawCallback: function(settings) {
                // Re-init tooltips after each redraw
                const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
                
                // Re-init datepickers
                $('.bt-datepicker').datepicker('destroy').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date()   // disable future dates
                });

                //Refresh total counts based on filters
                reloadTotals();
                fetchTotalCounts($('.cs_model').val(), $('.cs_type').val(), $('.cs_material').val(), $('.cs_shift').val(), $('#filterStatus').val(), $('#filterResult').val());
            }
        }); 
		 
    });

    // Auto save production date
    $(document).off('change', '.bt-datepicker').on('change', '.bt-datepicker', function () {

        let ir_id = $(this).data('irid');
        let prod_date = $(this).val();

        if(!ir_id || !prod_date) return;

        $.ajax({
            url: 'inspection-update-production-date.php',
            type: 'POST',
            dataType: 'json',
            data: {
                ir_id: ir_id,
                prod_date: prod_date
            },

            success:function(res){

                if(res.status === 'success'){
                    console.log("Production date saved");
                } 
                else{
                    alert("Failed to save date");
                }
            },

            error:function(xhr){
                console.log(xhr.responseText);
                alert("Server error saving date");
            }
        });

    });

    </script>

    <script>

    function reloadActivityComments() {

        $.post('fetch-activity-comment.php', {
            shift: $('#hidden_shift').val(),
            shift_date: $('#hidden_shift_date').val()
        }, function(res) {
            $('#activityCommentContainer').html(res);
        }).fail(function() {
            $('#activityCommentContainer').html('<p class="text-danger">Failed to load activity comments.</p>');
        });

    }

    </script>

    <script>

    $('#btnFilterSearch').on('click', function() {
        table.ajax.reload();
    });

    $('#btnResetFilter').on('click', function() {
        $('.cs_model, .cs_type, .cs_material, .cs_shift, #filterStatus, #filterResult').val('').trigger('change');
        $('#searchInput').val('');
        table.ajax.reload();
    });

    $('#searchInput').on('keyup', function() {
        table.ajax.reload();
    });

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

    </script>
    
    <script>

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));

    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    </script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {
        history.back();
    });

    </script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const remarkModal = new bootstrap.Modal(document.getElementById('remarkModal'));
        const remarkContent = document.getElementById('remarkContent');

        // Event delegation: catch clicks inside detailModal
        document.getElementById('detailModalBody').addEventListener('click', function (e) {
            if (e.target.classList.contains('timeline-title-remark')) {
                const remark = e.target.getAttribute('data-remark') || 'No remark available.';
                remarkContent.textContent = remark;
                remarkModal.show();
            }
        });
    });
    </script>

    <script>
    function reloadTable() {
        if (table) {
            table.ajax.reload(null, false);
        }
    }
    </script>

    <script>
        
    function resetNgModal(){

        $('#ng_ir_id').val('');
        $('#fd_defectType').val('').trigger('change');
        $('input[name="fd_area[]"]').prop('checked', false);

        // clear without changing references
        defectFiles.length = 0;
        compareFiles.length = 0;

        $('#imagePreviewContainer_modal, #imagePreviewContainer_compare_modal').empty();
        $('label[for="imageUpload_defect"], label[for="imageUpload_compare"]').removeClass('border-error');

    }

    // open NG modal from the table button
    $(document).on("click", ".btnAddDefect", function () {
        const irid = $(this).data("irid");

        // Set hidden input
        $("#ng_ir_id").val(irid);
        console.log("Manual Add Defect - Set ng_ir_id:", irid);

        // Optional: clear previous modal fields (recommended)
        resetAddDefectModal(); // You already have this function after save

        // Show modal
        $("#ngModal").modal("show");
    });

    </script>

    <script>

    $(document).on("change", ".result-select", function () {

        const newResult = $(this).val();
        const irid = $(this).data("irid");
        const oldResult = $(this).data("old") || "";

        // Ask confirmation
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to update this inspection result?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#085209',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, update it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                
                // ✅ Proceed with update
                $.post("fetch-inspection-rcd-all.php",
                    { action: "update_result", irid, result: newResult },
                    function () {

                        // logic for NG modal / defect delete
                        if ((oldResult === "" && newResult === "NG") || (oldResult === "OK" && newResult === "NG")) {
                            $("#ng_ir_id").val(irid);
                            $("#ngModal").data('irid', irid).modal("show");
                        } else if (oldResult === "NG" && newResult === "OK") {
                            $.post("fetch-inspection-rcd-all.php", { action: "delete_defect", irid });

                            // Success feedback
                            Swal.fire({
                                icon: 'success',
                                title: 'Updated!',
                                text: 'Inspection result updated successfully.',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }

                        // update old value
                        $(`.result-select[data-irid='${irid}']`).data("old", newResult);
                        table.ajax.reload(null, false);
                        
                        // Reload count status
                        reloadTotals();
                        
                    },
                    "json"
                );

            } else {
                // If canceled, revert the select value back
                $(`.result-select[data-irid='${irid}']`).val(oldResult);
            }
        });

    });

    </script>
    

    <script>

    //  Add Defect
    // --- For Defect Photo ---
    let selectedFiles_defect = [];

    $('#imagePreviewContainer_defect_add').on('click', '.remove-image', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const idx = $(this).data('idx');
        selectedFiles_defect.splice(idx, 1);
        updatePreview_defect();
    });

    function updatePreview_defect() {
        const previewContainer = $('#imagePreviewContainer_defect_add');
        previewContainer.html(""); // Clear previews

        selectedFiles_defect.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`
                    <div class="avatar-preview me-2 mb-2 position-relative" style="cursor:pointer;" data-imgsrc="${e.target.result}">
                        <span class="remove-image" data-idx="${idx}" style="position:absolute;top:-11px;right:-11px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                    </div>
                `).css({
                    'background-image': 'url(' + e.target.result + ')',
                    'width': '80px',
                    'height': '80px',
                    'background-size': 'cover',
                    'background-position': 'center',
                    'border-radius': '12px',
                    'border': '1px solid #ddd',
                    'cursor': 'pointer'
                });
                previewContainer.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    $('#imageUpload_defect').change(function() {
        const newFiles = Array.from(this.files);
        selectedFiles_defect = selectedFiles_defect.concat(newFiles);
        updatePreview_defect();
        $(this).val('');
    });

    $('#imagePreviewContainer_defect_add').on('click', '.avatar-preview', function(e){
        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');
        // open modal manually
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    // --- For Comparing Photo ---
    let selectedFiles_compare = [];

    $('#imagePreviewContainer_compare_add').on('click', '.remove-image', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const idx = $(this).data('idx');
        selectedFiles_compare.splice(idx, 1);
        updatePreview_compare();
    });

    function updatePreview_compare() {
        const previewContainer = $('#imagePreviewContainer_compare_add');
        previewContainer.html(""); // Clear previews

        selectedFiles_compare.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`
                    <div class="avatar-preview me-2 mb-2 position-relative" style="cursor:pointer;" data-imgsrc="${e.target.result}">
                        <span class="remove-image" data-idx="${idx}" style="position:absolute;top:-11px;right:-11px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                    </div>
                `).css({
                    'background-image': 'url(' + e.target.result + ')',
                    'width': '80px',
                    'height': '80px',
                    'background-size': 'cover',
                    'background-position': 'center',
                    'border-radius': '12px',
                    'border': '1px solid #ddd',
                    'cursor': 'pointer'
                });
                previewContainer.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    $('#imageUpload_compare').change(function() {
        const newFiles = Array.from(this.files);
        selectedFiles_compare = selectedFiles_compare.concat(newFiles);
        updatePreview_compare();
        $(this).val('');
    });

    $('#imagePreviewContainer_compare_add').on('click', '.avatar-preview', function(e){
        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');
        // open modal manually
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    </script>

    <script>

    // Add Defect form Modal
    // Remove old error border first (optional)
    $('#fd_defectType_add').removeClass('border-error');
    $('input[name="fd_area_add[]"]').closest('.area-grid').removeClass('border-error');
    $('#imageUpload_defect').removeClass('border-error');
    $('#imageUpload_compare').removeClass('border-error');

    // Remove border when user fixes the input
    $('#fd_defectType_add').on('change', function() {
        // $(this).removeClass('border-error');
        $(this).next('.select2').find('.select2-selection').removeClass('border-error');
    }); 
    
    // Remove border when user fixes the input
    $('input[name="fd_area_add[]"]').on('change', function() {
        if ($('input[name="fd_area_add[]"]:checked').length > 0) {
            $('.area-grid').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#imageUpload_defect').on('change', function() {
        if (selectedFiles_defect.length > 0) {
            $('label[for="imageUpload_defect"]').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#imageUpload_compare').on('change', function() {
        if (selectedFiles_compare.length > 0) {
            $('label[for="imageUpload_compare"]').removeClass('border-error');
        }
    });

    // Save
    $('#AddDefect').on('click', function() {
        
        console.log("ng_ir_id (before submit):", $('#ng_ir_id').val());
        console.log('ng_ir_id:', $('#ng_ir_id').val());
        console.log('fd_defectType:', $('#fd_defectType_add').val());

        // Gather values
        var defectType = $('#fd_defectType_add').val();
        var checkedAreas = $('input[name="fd_area_add[]"]:checked').length;
        var defectPhotos = selectedFiles_defect.length;
        var comparePhotos = selectedFiles_compare.length;
        var irId = $('#ng_ir_id').val();        

        var hasError = false;

        // Remove previous error states
        $('#fd_defectType_add').removeClass('select-error');
        $('input[name="fd_area_add[]"]').removeClass('checkbox-error');
        $('#imageUpload_defect').removeClass('input-error');
        $('#imageUpload_compare').removeClass('input-error');
        
        // Validation
        if (!defectType) {
            alert('Please select a defect type.');
            $('#fd_defectType_add').addClass('select-error');
            hasError = true;
            return;
        }
        if (checkedAreas === 0) {
            alert('Please select at least one defect area.');
            $('.area-grid').addClass('border-error');
            hasError = true;
            return;
        }
        if (defectPhotos === 0) {
            alert('Please add at least one defect photo.');
            $('label[for="imageUpload_defect"]').addClass('border-error');
            hasError = true;
            return;
        }
        if (comparePhotos === 0) {
            alert('Please add at least one comparing photo.');
            $('label[for="imageUpload_compare"]').addClass('border-error');
            hasError = true;
            return;
        }
        if (!irId) {
            alert('System error: Missing inspection record ID. Please try again.');
            return;
        }

        var formData = new FormData();

        // Collect simple fields
        formData.append('action', 'add_defect');
        formData.append('ng_ir_id', $('#ng_ir_id').val());
        formData.append('fd_defectType_add', $('#fd_defectType_add').val());

        // Collect checked defect areas (as array)
        $('input[name="fd_area_add[]"]:checked').each(function(i, obj) {
            formData.append('fd_area_add[]', $(obj).val());
        });

        // Defect photo files
        for (var i = 0; i < selectedFiles_defect.length; i++) {
            formData.append('imageUpload_defect_photo[]', selectedFiles_defect[i]);
        }

        // Compare photo files
        for (var i = 0; i < selectedFiles_compare.length; i++) {
            formData.append('imageUpload_compare_photo[]', selectedFiles_compare[i]);
        }

        $.ajax({
            url: 'fetch-inspection-rcd-all.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function() {
                // Show loading if needed
            },
            success: function(res) {

                if (res.success) {
                    
                    // Success: close modal, reload table, show alert, etc.
                    $('#ngModal').modal('hide');
                    resetAddDefectModal(); 
                    reloadTable();

                    // On submit click
                    Swal.fire({
                        title: 'Submitting...',
                        text: 'Please wait while we process your inspection.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    if (res.success) {
                        // SweetAlert2 for success message only
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: 'Defect added successfully.',
                            timer: 3000,
                            showConfirmButton: false
                        });

                        reloadTable();
                        
                        // Reload count status
                        reloadTotals();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.msg || 'Failed to add defect.',
                        });
                    }                   
                    

                } else {
                    alert('Error: ' + res.error);
                }
            },
            error: function() {
                alert('AJAX error');
            }
        });
    });
    
    </script>

    <script>

    //Reset input modal
    function resetAddDefectModal() {

        $('#fd_defectType_add').val('');
        $('input[name="fd_area_add[]"]').prop('checked', false);
        $('#imageUpload_defect').val('');
        $('#imageUpload_compare').val('');
        $('#imagePreviewContainer_defect_add').empty();
        $('#imagePreviewContainer_compare_add').empty();
        selectedFiles_defect = [];
        selectedFiles_compare = [];
        selectedFiles_defect = [];
        selectedFiles_compare = [];
        updatePreview_defect();
        updatePreview_compare();

    }

    </script>

    <!-- ###### VIEW DEFECT -->
    <script>

    // View defect
    $(document).on('click', '.btnViewDefect', function() {

        let btn = $(this);
        let row = btn.closest('tr');
        let irId = btn.data('irid');
        let status = btn.data('status');
        // if (!status) status = 1; // fallback to 1 if undefined/null/empty

        // Collapse if already expanded
        if (row.next().hasClass('defect-details-row')) {
            row.next().remove();
            btn.removeClass('expanded');
            return;
        }

        // Remove any existing open rows first (optional)
        $('.defect-details-row').remove();
        $('.ViewDefect').removeClass('expanded');

        // Show loading state
        btn.addClass('expanded');
        let colspan = row.children('td').length;
        let loadingRow = $(`<tr class="defect-details-row"><td colspan="${colspan}" class="text-center">Loading defect details...</td></tr>`);
        row.after(loadingRow);
        
        // AJAX to get defect list
        $.ajax({
            url: 'fetch-inspection-rcd-defect-list.php',
            type: 'POST',
            data: { ir_id: irId, status: status }, // send status if needed
            success: function(html) {
                row.next().find('td').html(html);

                // zoom photo in defect list
                $(document).on('click', '.zoomable-photo', function() {
                    var src = $(this).data('src');
                    $('#zoomedPhoto').attr('src', src);
                    var zoomModal = new bootstrap.Modal(document.getElementById('photoZoomModal'));
                    zoomModal.show();
                });

                // run tooltip
                $('[data-bs-toggle="tooltip"]').tooltip();

            },
            error: function() {
                row.next().find('td').html('<div class="text-danger">Failed to load defect details.</div>');
            }
        });

    });

    //View only for defect list
    $(document).on('click', '.btnViewOnly', function() {

        let btn = $(this);
        let row = btn.closest('tr');
        let irId = btn.data('irid');
        let status = btn.data('status');
        // if (!status) status = 1; // fallback to 1 if undefined/null/empty

        // Collapse if already expanded
        if (row.next().hasClass('defect-details-row')) {
            row.next().remove();
            btn.removeClass('expanded');
            return;
        }

        // Remove any existing open rows first (optional)
        $('.defect-details-row').remove();
        $('.ViewDefect').removeClass('expanded');

        // Show loading state
        btn.addClass('expanded');
        let colspan = row.children('td').length;
        let loadingRow = $(`<tr class="defect-details-row"><td colspan="${colspan}" class="text-center">Loading defect details...</td></tr>`);
        row.after(loadingRow);
        
        // AJAX to get defect list
        $.ajax({
            url: 'fetch-inspection-rcd-defect-list.php',
            type: 'POST',
            data: { ir_id: irId, status: status }, // send status if needed
            success: function(html) {
                row.next().find('td').html(html);

                // zoom photo in defect list
                $(document).on('click', '.zoomable-photo', function() {
                    var src = $(this).data('src');
                    $('#zoomedPhoto').attr('src', src);
                    var zoomModal = new bootstrap.Modal(document.getElementById('photoZoomModal'));
                    zoomModal.show();
                });

                // run tooltip
                $('[data-bs-toggle="tooltip"]').tooltip();

            },
            error: function() {
                row.next().find('td').html('<div class="text-danger">Failed to load defect details.</div>');
            }
        });

    });

    // When clicking on any zoomable image
    $(document).on('click', '.zoomable-photo-defect', function () {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    // When clicking on any zoomable image
    $(document).on('click', '.zoomable-photo-compare', function () {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    </script>

    <!-- ###### EDIT DEFECT -->
    <script>

    // Photo
    let existing_defect_photos = []; // [{id, url}]
    let selectedFiles_defect_ed = [];

    let existing_compare_photos = []; // [{id, url}]
    let selectedFiles_compare_ed = [];

    // For delete tracking
    let deleted_defect_photo_ids = [];
    let deleted_compare_photo_ids = [];

    $(document).on('click', '.edit-defect', function() {

        let defectId = $(this).data('defectid');
        let irId = $(this).data('irid');

        // Set the hidden field values!
        $('#ng_ir_id').val(irId);
        $('#ng_defect_id').val(defectId);

        $.ajax({
            url: 'fetch-inspection-rcd-single-defect.php',
            type: 'POST',
            dataType: 'json',
            data: { defect_id: defectId, ir_id: irId },
            success: function(res) {

                console.log('Defect type from backend:', res.data.defect_type);
                console.log('Compare images from backend:', res.data.compare_photos);
                if(res.success){

                    $('#fd_defectType_ed').val(res.data.defect_type).trigger('change');;
                    $('input[name="fd_area_ed[]"]').prop('checked', false);

                    (res.data.area || []).forEach(function(area){
                        $('input[name="fd_area_ed[]"][value="'+area+'"]').prop('checked',true);
                    });

                    //defect & comparison photos
                    existing_defect_photos = res.data.defect_photos || [];
                    existing_compare_photos = res.data.compare_photos || [];

                    updatePreview_defect_ed(true);
                    updatePreview_compare_ed(true);

                    var m = new bootstrap.Modal(document.getElementById('editDefectModal'));
                    m.show();

                } else {
                    alert(res.msg || 'Not found');
                }
            }
        });
    }); 

    // Show all current (existing) and new images
    function updatePreview_defect_ed() {

        const c = $('#imagePreviewContainer_ed');
        c.empty();

        // Existing (from DB)
        existing_defect_photos.forEach((img, idx) => {

            const imgId = img.def_photoid;
            const imgUrl = encodeURI(img.url);

            const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative" data-exist="1" data-idx="${idx}" data-imgsrc="${imgUrl}" data-imgid="${imgId}">
                                <span class="remove-image-defect-old" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                            </div>`).css({
                                'background-image': 'url(' + imgUrl + ')',
                                'width': '80px',
                                'height': '80px',
                                'background-size': 'cover',
                                'background-position': 'center',
                                'border-radius': '12px',
                                'border':'1px solid #ddd',
                                'cursor': 'pointer'
                            });
            c.append(imgDiv);
        });

        // New files (not yet uploaded)
        selectedFiles_defect_ed.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative"
                    data-exist="0" data-idx="${idx}" data-imgsrc="${e.target.result}">
                    <span class="remove-image" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                </div>`).css({
                    'background-image': `url(${e.target.result})`,
                    'width': '80px', 
                    'height': '80px', 
                    'background-size': 'cover',
                    'background-position': 'center', 
                    'border-radius': '12px', 
                    'border':'1px solid #ddd',
                    'cursor': 'pointer'
                });
                c.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    //zoom images
    $('#imagePreviewContainer_ed').on('click', '.avatar-preview', function(e){

        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');

        // open modal manually
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');

    });
    
    // Add new image(s)
    $('#imageUpload_defect_ed').on('change', function() {
        for (let i = 0; i < this.files.length; i++) {
            selectedFiles_defect_ed.push(this.files[i]);
        }
        updatePreview_defect_ed();
        $(this).val(""); // Reset file input
    });

    // Remove image (either from DB or not-yet-uploaded)
    $('#imagePreviewContainer_ed').on('click', '.remove-image', function(e) {

        e.preventDefault(); e.stopPropagation();
        const $img = $(this).parent();
        const idx = $img.data('idx');

        if ($img.data('exist') == 1) {
            // Existing: mark for deletion (do not remove from DB yet)
            let photoId = $img.data('photoid');
            deleted_defect_photo_ids.push(photoId);
            existing_defect_photos.splice(idx, 1);
        } else {
            // New: remove from array
            selectedFiles_defect_ed.splice(idx, 1);
        }
        
        updatePreview_defect_ed();
    });

    //remove old image gallery & database
    $('#imagePreviewContainer_ed').on('click', '.remove-image-defect-old', function(e) {
        
        e.stopPropagation();
        const imgDiv = $(this).closest('.avatar-preview');
        const imgId = imgDiv.data('imgid'); // the unique DB ID

        if (!imgId) {
            alert('No image ID found!');
            return;
        }

        if (!confirm('Remove this image?')) return;

        console.log("Deleting image with ID:", imgId);

        // AJAX to PHP to remove from DB and folder
        $.ajax({
            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            data: { id: imgId, phototype: 'defect', action : 'delete_photo'},
            dataType: 'json',
            success: function(res) {

                // 1. Remove from existing_defect_photos array
                const idxToRemove = existing_defect_photos.findIndex(img => img.def_photoid == imgId);
                if (idxToRemove > -1) {
                    existing_defect_photos.splice(idxToRemove, 1);
                }

                //2. old image
                if (res.success) {
                    imgDiv.remove(); // remove from UI
                } else {
                    alert('Failed to delete image: ' + res.error);
                }

                //3. reload table
                reloadDefectTable($('#ng_ir_id').val(), 1);
                
            },
            error: function() {
                alert('Server error. Try again.');
            }
        });

    });

    //Comparison photo
    function updatePreview_compare_ed(isEdit = false) {

        const c = $('#imagePreviewContainer_compare_ed');
        c.empty();

        // Existing (from DB)
        existing_compare_photos.forEach((img, idx) => {

            const imgId = img.compare_photoid;
            const imgUrl = encodeURI(img.url);

            const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative" data-exist="1" data-idx="${idx}" data-imgsrc="${imgUrl}" data-imgid="${imgId}">
                                <span class="remove-image-compare-old" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                            </div>`).css({
                                'background-image': 'url(' + imgUrl + ')',
                                'width': '80px',
                                'height': '80px',
                                'background-size': 'cover',
                                'background-position': 'center',
                                'border-radius': '12px',
                                'border':'1px solid #ddd',
                                'cursor': 'pointer'
            });
            c.append(imgDiv);
        });

        // New files (not yet uploaded)
        selectedFiles_compare_ed.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative"
                    data-exist="0" data-idx="${idx}" data-imgsrc="${e.target.result}">
                    <span class="remove-image" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                </div>`).css({
                    'background-image': `url(${e.target.result})`,
                    'width': '80px', 
                    'height': '80px', 
                    'background-size': 'cover',
                    'background-position': 'center', 
                    'border-radius': '12px', 
                    'border':'1px solid #ddd',
                    'cursor': 'pointer'
                });
                c.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    //zoom images
    $('#imagePreviewContainer_compare_ed').on('click', '.avatar-preview', function(e){

        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');
        // open modal manually
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');

    });

    $('#imageUpload_compare_ed').on('change', function() {

        // this.files is a FileList
        for (let i = 0; i < this.files.length; i++) {
            selectedFiles_compare_ed.push(this.files[i]);
        }
        updatePreview_compare_ed();
        $(this).val(""); 
        
    });
    
    //remove defect image before upload
    $('#imagePreviewContainer_compare_ed').on('click', '.remove-image', function(e) {
        
        e.preventDefault(); e.stopPropagation();
        const $img = $(this).parent();
        const idx = $img.data('idx');
        if ($img.data('exist') == 1) {
            let photoId = $img.data('photoid');
            deleted_compare_photo_ids.push(photoId); 
            existing_compare_photos.splice(idx, 1);
        } else {
            selectedFiles_compare_ed.splice(idx, 1);
        }

        updatePreview_compare_ed(true);
    });

    //remove old image gallery & database
    $('#imagePreviewContainer_compare_ed').on('click', '.remove-image-compare-old', function(e) {
        
        e.stopPropagation();
        const imgDiv = $(this).closest('.avatar-preview');
        const imgId = imgDiv.data('imgid'); // the unique DB ID

        if (!imgId) {
            alert('No image ID found!');
            return;
        }

        if (!confirm('Remove this image?')) return;

        console.log("Deleting image with ID:", imgId);

        // AJAX to PHP to remove from DB and folder
        $.ajax({
            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            data: { id: imgId, phototype: 'compare', action : 'delete_photo'},
            dataType: 'json',
            success: function(res) {

                // 1. Remove from existing_defect_photos array
                const idxToRemove = existing_compare_photos.findIndex(img => img.compare_photoid == imgId);
                if (idxToRemove > -1) {
                    existing_compare_photos.splice(idxToRemove, 1);
                }

                //2. old image
                if (res.success) {
                    imgDiv.remove(); // remove from UI
                } else {
                    alert('Failed to delete image: ' + res.error);
                }
 
                //reload table
                reloadDefectTable($('#ng_ir_id').val(), 1);

            },
            error: function() {
                alert('Server error. Try again.');
            }
        });

    });

    </script>

    <script>

    // Edit defect details
    // Remove old error border first (optional)
    $('#fd_defectType_ed').removeClass('border-error');
    $('input[name="fd_area_ed[]"]').closest('.area-grid').removeClass('border-error');

    // Remove border when user fixes the input
    $('#fd_defectType_ed').on('change', function() {
        // $(this).removeClass('border-error');
        $(this).next('.select2').find('.select2-selection').removeClass('border-error');
    }); 
    
    // Remove border when user fixes the input
    $('input[name="fd_area_ed[]"]').on('change', function() {
        if ($('input[name="fd_area_ed[]"]:checked').length > 0) {
            $('.area-grid').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#imageUpload_defect_ed').on('change', function() {
        if (selectedFiles_defect_ed.length > 0) {
            $('label[for="imageUpload_defect_ed"]').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#imageUpload_compare_ed').on('change', function() {
        if (selectedFiles_compare_ed.length > 0) {
            $('label[for="imageUpload_compare_ed"]').removeClass('border-error');
        }
    });

    //Update
    $('#btnEditDefect_modal').on('click', function(e) {

        e.preventDefault();

        // Gather values
        var defectType = $('#fd_defectType_ed').val();
        var checkedAreas = $('input[name="fd_area_ed[]"]:checked').length;
        var defectPhotos = selectedFiles_defect_ed.length;
        var comparePhotos = selectedFiles_compare_ed.length;
        var irId = $('#ng_ir_id').val();

        var totalDefectPhotos = (existing_defect_photos?.length || 0) + (selectedFiles_defect_ed?.length || 0);
        var totalComparePhotos = (existing_compare_photos?.length || 0) + (selectedFiles_compare_ed?.length || 0);

        var hasError = false;

        // Remove previous error states
        $('#fd_defectType_ed').removeClass('select-error');
        $('input[name="fd_area_ed[]"]').removeClass('checkbox-error');
        $('#imageUpload_defect_ed').removeClass('input-error');
        $('#imageUpload_compare_ed').removeClass('input-error');
        
        // Validation
        if (!defectType) {
            alert('Please select a defect type.');
            $('#fd_defectType_ed').addClass('select-error');
            hasError = true;
            return;
        }
        if (checkedAreas === 0) {
            alert('Please select at least one defect area.');
            $('.area-grid').addClass('border-error');
            hasError = true;
            return;
        }
        if (totalDefectPhotos === 0) {
            alert('Please add at least one defect photo.');
            $('label[for="imageUpload_defect_ed"]').addClass('border-error');
            hasError = true;
            return;
        }
        if (totalComparePhotos === 0) {
            alert('Please add at least one comparing photo.');
            $('label[for="imageUpload_compare_ed"]').addClass('border-error');
            hasError = true;
            return;
        }
        if (!irId) {
            alert('System error: Missing record ID. Please try again.');
            return;
        }
        
        let formData = new FormData();

        formData.append('action', 'update_defect_modal');
        formData.append('ir_id', $('#ng_ir_id').val());
        formData.append('defect_id', $('#ng_defect_id').val());
        formData.append('defect_type', $('#fd_defectType_ed').val());        
        
        let areas = [];
        $('input[name="fd_area_ed[]"]:checked').each(function() {
            areas.push($(this).val());
        });

        formData.append('area', areas.join(','));
        formData.append('deleted_defect_photo_ids', JSON.stringify(deleted_defect_photo_ids));
        formData.append('deleted_compare_photo_ids', JSON.stringify(deleted_compare_photo_ids));

        // Add new images - defect
        for (let i = 0; i < selectedFiles_defect_ed.length; i++) {
            formData.append('defect_photo_ed[]', selectedFiles_defect_ed[i]);
        }

        // Add new images - compare
        for (let i = 0; i < selectedFiles_compare_ed.length; i++) {
            formData.append('compare_photo_ed[]', selectedFiles_compare_ed[i]);
        }

        $.ajax({

            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.success) {

                    //alert('Your changes have been saved.');
                    // On submit click
                    Swal.fire({
                        title: 'Updating...',
                        text: 'Please wait while we process your request.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    if (res.success) {
                        // SweetAlert2 for success message only
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: 'Your changes have been saved.',
                            timer: 3000,
                            showConfirmButton: false
                        });

                        $('#editDefectModal').modal('hide');

                        //reload table
                        reloadDefectTable($('#ng_ir_id').val(), 1);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.msg || 'Failed to edit defect.',
                        });
                    }      

                    // Reset arrays for next time
                    selectedFiles_defect_ed = [];
                    deleted_defect_photo_ids = [];
                    selectedFiles_compare_ed = [];
                    deleted_compare_photo_ids = [];

                } else {
                    alert(res.msg || 'Update failed!');
                }
            }
        });
    });

    // reload the table
    function reloadDefectTable(ir_id, status) {

        $.ajax({
            url: 'fetch-inspection-rcd-defect-list.php',
            type: 'POST',
            data: { ir_id: ir_id, status: status },
            success: function(html) {
                $('#defectTableContainer').html(html);
            }
        });
    }

    </script>

    <script>

    // Close button (modal)  
    // Clear cache data / form fields if cancel
    $('.btnCloseModal_add').on('click', function() {

        // 1. Clear image arrays
        selectedFiles_defect = [];
        selectedFiles_compare = [];
        updatePreview_defect();
        updatePreview_compare();

        // 2. Reset form fields
        // Reset select2
        $('#fd_defectType_add').val('').trigger('change'); // if using Select2

        // Reset checkboxes
        $('input[type="checkbox"]').prop('checked', false);

        // Reset other inputs as needed
        // e.g., $('input[type="text"]').val('');

        // Optionally, reset <input type="file"> if you want:
        $('#imageUpload_defect').val('');
        $('#imageUpload_compare').val('');

    });

    // Clear cache data / form fields if cancel
    $('.btnCloseModal_edit').on('click', function() {

        // 1. Clear image arrays
        selectedFiles_defect_ed = [];
        selectedFiles_compare_ed = [];
        updatePreview_defect_ed();
        updatePreview_compare_ed();

        // 2. Reset form fields
        // Reset select2
        $('#fd_defectTyp_ed').val('').trigger('change'); // if using Select2

        // Reset checkboxes
        $('input[type="checkbox"]').prop('checked', false);

        // Reset other inputs as needed
        // e.g., $('input[type="text"]').val('');

        // Optionally, reset <input type="file"> if you want:
        $('#imageUpload_defect_ed').val('');
        $('#imageUpload_compare_ed').val('');
    });

    </script>

    <!-- ###### DELETE DEFECT -->
    <script>

    $(document).on('click', '.delete-defect', function() {  
        
        let defectId = $(this).data('defectid');
        let irId = $(this).data('irid');

        // Set the hidden field values!
        $('#ng_ir_id').val(irId);
        $('#ng_defect_id').val(defectId);

        // Set the hidden field values!
        $('#ng_ir_id').val(irId);

        if (!confirm('Remove this defect?')) return;

        $.ajax({
            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            dataType: 'json',
            data: { action : 'delete_defect',  defect_id: defectId, ir_id: irId },
            success: function(res) {
                if(res.success){
                    
                    reloadDefectTable($('#ng_ir_id').val(), 1);

                    // On submit click
                    Swal.fire({
                        title: 'Deleting...',
                        text: 'Please wait while we process your request.',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    if (res.success) {
                        // SweetAlert2 for success message only
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'Defect deleted successfully.',
                            timer: 3000,
                            showConfirmButton: false
                        });

                        reloadDefectTable($('#ng_ir_id').val(), 1);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.msg || 'Failed to delete defect.',
                        });
                    }      

                } else {
                    alert('Failed to delete record.');
                }
            }
        });
    });

    </script>

    <script>

    //Submit for review
    $(document).on('click', '.btnSubmit', function(e) {
        e.preventDefault();

        let ir_id = $(this).data('irid');
        
        // find the row
        let row = $(this).closest('tr');

        // get production date from input
        let prod_date = row.find('.bt-datepicker').val();

        // Step 1: Ask user for confirmation (replaces confirm())
        Swal.fire({
            title: 'Submit Inspection?',
            text: 'Submit this inspection record for review?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit',
            cancelButtonText: 'Cancel',
            confirmButtonColor: "#198754",
            reverseButtons: true
        }).then((result) => {

            if (!result.isConfirmed) return;

            // Step 2: Show loading BEFORE AJAX
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your inspection.',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Step 3: Build formData
            let formData = new FormData();
            formData.append('action', 'submit_for_review');
            formData.append('prod_date', prod_date);
            formData.append('ir_id', ir_id);

            // Step 4: AJAX request
            $.ajax({
                url: 'fetch-inspection-rcd-all.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function(res) {

                    if (res.success) {
                        // Success alert
                        Swal.fire({
                            icon: 'success',
                            iconColor: "#198754",
                            title: 'Submitted!',
                            text: 'Your inspection record was submitted for review.',
                            timer: 2500,
                            showConfirmButton: false
                        });
                        
                        // Refresh table
                        reloadTable();
                        reloadTotals();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Submission Failed',
                            text: res.msg || 'Failed to submit the inspection.',
                        });
                    }
                },

                error: function(xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Server Error',
                        text: xhr.responseText || error,
                    });
                }
            });

        }); // end Swal confirm
    });

    </script>

    <script>

    $(document).on('click', '.btnCancel', function (e) {

        e.preventDefault();
        const ir_id = $(this).data('irid') || $(this).attr('data-irid');
        $('#cancel_ir_id').val(ir_id);
        $('#cancel_remark').val('');
        $('#cancel_count').text('0');
        new bootstrap.Modal(document.getElementById('cancelRemarkModal')).show();
    });

    // Live count
    $('#cancel_remark').on('input', function(){
        $('#cancel_count').text(this.value.length);
    });

    // Submit cancellation (AJAX)
    // Remove border when user fixes the input
    $('#cancel_remark').on('change', function() {
        // $(this).removeClass('border-error');
       $('#cancel_remark').removeClass('border-error');
    }); 

    $('#cancelRemarkForm').on('submit', function(e){
        e.preventDefault();

        const ir_id = $('#cancel_ir_id').val();
        const remark = $('#cancel_remark').val().trim();

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                title: 'Missing Reason',
                confirmButtonColor: '#28a745',
                text: 'Please state the reason for cancellation.',
            });
            $('#cancel_remark').addClass('border-error');
            return;
        }
        $('#cancel_remark').removeClass('border-error');


        const $btn = $('#btnConfirmCancel');
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Canceling...');

        $.ajax({
            url: 'fetch-inspection-rcd-all.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'cancel_record', ir_id, remark },
            success: function(res){
                $btn.prop('disabled', false).html('<i class="fa fa-times me-1"></i>Confirm Cancel');
                if (res.success) {

                    Swal.fire({
                        icon: 'success',
                        title: 'Cancelled',
                        text: 'The record has been cancelled successfully.',
                        timer: 3000,
                        showConfirmButton: false
                    });

                    // close modal
                    const modalEl = document.getElementById('cancelRemarkModal');
                    bootstrap.Modal.getInstance(modalEl).hide();

                    // refresh the table
                    reloadTable();
                        
                    // Reload count status
                    reloadTotals();
                    
                } else {
                    alert(res.message || 'Cancel failed.');
                }
            },
            error: function(xhr){
                $btn.prop('disabled', false).html('<i class="fa fa-times me-1"></i>Confirm Cancel');
                console.error(xhr.responseText);
                alert('Server error while cancelling.');
            }
        });
    });

    </script>

    <script>

    let selectedIds = new Set();
    let selectAllPages = false;

    function toggleBulkButtons() {

        let canSubmit = false;
        let canCancel = false;

        if (selectedIds.size === 0) {
            $('#btnSubmitSelected').prop('disabled', true);
            $('#btnCancelSelected').prop('disabled', true);
            return;
        }

        // collect selected statuses (ONLY from checked rows)
        let statuses = [];

        $('.row-check:checked').each(function () {
            statuses.push(parseInt($(this).data('status')));
        });

        // if "selectAllPages" is ON, still only current page can be read
        // so safest: enable buttons only based on current checked rows

        // RULE 1: Submit only if ALL are 12 or 13
        canSubmit = statuses.length > 0 && statuses.every(s => (s === 1 || s === 12 || s === 13));

        // RULE 2: Cancel only if ALL are 9
        canCancel = statuses.length > 0 && statuses.every(s => (s === 9));

        $('#btnSubmitSelected').prop('disabled', !canSubmit);
        $('#btnCancelSelected').prop('disabled', !canCancel);
    }

    $(document).on('change', '.row-check', function () {
        const id = this.value;

        if (this.checked) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);
            selectAllPages = false;
            $('#checkAll').prop('checked', false);
        }

        toggleBulkButtons();
    });

    $(document).on('change', '#checkAll', function () {
        selectAllPages = this.checked;

        if (selectAllPages) {
            $('.row-check').prop('checked', true).each(function () {
                selectedIds.add(this.value);
            });
        } else {
            $('.row-check').prop('checked', false);
            selectedIds.clear();
        }

        toggleBulkButtons();
    });

    $('#inspectionGroupsList').on('draw.dt', function () {

        $('.row-check').each(function () {
            const id = this.value;

            if (selectAllPages || selectedIds.has(id)) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });

        $('#checkAll').prop('checked', selectAllPages);
        toggleBulkButtons();
    });

    </script>

    <script>

    // Bulk Submit for review - selected row
    $('#btnSubmitSelected').on('click', function () {

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

        Swal.fire({
            title: 'Submit Selected?',
            text: `Submit ${selectedIds.size} record(s)?`,
            icon: 'question',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Submit'
        }).then((result) => {

            if (!result.isConfirmed) return;

            $('#btnSubmitSelected').prop('disabled', true);

            $.ajax({
                url: 'fetch-inspection-bulk-action.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    ids: Array.from(selectedIds),
                    action: 'bulk_submit'
                },
                success: function (r) {

                    $('#btnSubmitSelected').prop('disabled', false);

                    if (r.status === 'success') {

                        Swal.fire({
                            title: 'Success',
                            text: r.message,
                            icon: 'success',
                            iconColor: "#286912",
                            confirmButtonColor: '#28a745'
                        });
                    
                        // Refresh table or reload
                        loadPalletTable();

                        selectedIds.clear();
                        $('#checkAll').prop('checked', false);

                        table.ajax.reload(null, false);
                        fetchTotalCounts();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
                            title: 'Error',
                            text: r.message || 'Unknown error',
                            confirmButtonColor: '#28a745',
                        });
                    }
                },
                error: function (xhr) {
                    $('#btnSubmitSelected').prop('disabled', false);
                    console.error(xhr.responseText);

                    console.log("STATUS:", xhr.status);
                    console.log("RESPONSE:", xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        iconColor: "#286912",
                        title: 'Error',
                        text: 'Server error occurred',
                        confirmButtonColor: '#28a745',
                    });
                   
                }
            });

        });
    });

    // Bulk Cancel submmission - selected
    $('#btnCancelSelected').on('click', function () {

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

        $('#bulk_cancel_remark').val('');
        $('#returnCount').text(selectedIds.size);

        $('#bulkcancelModal').modal('show');
    });

    $('#bulkcancelForm').on('submit', function (e) {
        e.preventDefault();

        let remark = $(this).find('textarea[name="remark"]').val().trim();
        // $('#btnConfirmCancelBulk').prop('disabled', true);

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing comment',
                confirmButtonColor: '#28a745',
                text: 'Please state the comment or reason.',
            });
            $('#bulk_cancel_remark').addClass('border-error');
            return;
        }
        $('#bulk_cancel_remark').removeClass('border-error');

        $.ajax({
            url: 'fetch-inspection-bulk-action.php',
            type: 'POST',
            dataType: 'json', 
            data: {
                ids: Array.from(selectedIds),
                remark: remark,
                action : 'bulk_cancel'
            },
            success: function (r) {

                $('#btnConfirmCancelBulk').prop('disabled', false);

                if (r.status === 'success') {
                    $('#bulkcancelModal').modal('hide');

                    Swal.fire({
                        title: 'Success',
                        text: r.message,
                        icon: 'success',
                        iconColor: "#286912",
                        confirmButtonColor: '#28a745'
                    });
                    
                    // Refresh table or reload
                    loadPalletTable();

                    selectedIds.clear();
                    $('#checkAll').prop('checked', false);
                    table.ajax.reload(null, false);
                    fetchTotalCounts();


                } else {
                    Swal.fire({
                        title: 'Error',
                        text: r.message || 'Unknown error',
                        icon: 'error'
                    });
                }
            },
            error: function (xhr) {
                $('#btnConfirmCancelBulk').prop('disabled', false);
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
    // Show remark in modal
    $(document).on('click', '[data-remark]', function() {
        let remark = $(this).data('remark');
        if (remark) {
            $('#remarkContent').text(remark);
            let remarkModal = new bootstrap.Modal(document.getElementById('remarkModal'));
            remarkModal.show();
        }
    });
    </script>

</body>
</html>