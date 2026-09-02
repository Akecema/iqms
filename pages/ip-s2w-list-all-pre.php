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
        /* .avatar-list {
            display: flex;
            align-items: center;
        }

        .avatar-list-stacked .avatar {
            margin-left: 0;
            border: 2px solid #fff;
            cursor: zoom-in;
            transition: transform 0.2s ease;
        }

        .avatar-list-stacked .avatar:first-child {
            margin-left: 0;
        } */

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

        .zoomable-img {
            cursor: pointer;       /* Show hand on hover */
            position: relative;    /* Make sure it's clickable */
            z-index: 99999 !important;           /* Bring it above wrappers */
            pointer-events: auto;  /* Ensure clicks pass through */
        }

        #s2wListall tbody tr td:last-child {
            text-align: left !important; 
        }

        #s2wListall thead tr th:last-child{
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

        #inspectionGroupsTable tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionGroupsTable thead tr th:last-child{
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

        #docnoModal .modal-dialog {
            margin-top: -140px;   /* adjust distance from top */
            margin-right: 50px;
        }

        .bg-light-green {
            background-color: #E5EDE4; /* soft green background */
            border-radius: 6px;
        }
        /* 
        #docnoContent {
            white-space: pre-wrap; /* support long text and line breaks 
        } */

        .tooltip .tooltip-inner {
            /* background-color: #333 !important;
            color: #fff; */
            max-width: 220px;
            white-space: pre-wrap;
        }
        
        .avatar-list {
            display: flex;
            align-items: center;
        }
        .avatar-list-inline .avatar {
            margin-left: -10px;
            border: 2px solid #fff;
            cursor: pointer;
        }
        .avatar.avatar-md {
            width: 40px;
            height: 40px;
            overflow: hidden;
        }
        .avatar-list-inline .avatar:last-child {
            margin-right: 0;     /* no margin on last item */
        }

        .modal-header {
            border-bottom: none !important;
        }

        .modal-title {
            color: #000;
        }

        .viewAvatar:hover {
            transform: scale(1.4); /* optional: subtle zoom effect on hover */
        }

       .viewDocno{
            cursor : pointer;
       }

        .child-row-wrapper {
            background: #f8f9fa;
            border-left: 3px solid #198754;
            width: 100%;
        }

        table.dataTable tr.shown td {
            background-color: #eef7ee !important;
        }

       .doc-tree {
            padding-left: 30px;
            border-left: 2px solid #ccc;
        }

        .tree {
            margin-left: 20px;
            padding-left: 20px;
            border-left: 2px solid #ccc;
            max-width: 350px;      /* <<< THIS FIXES YOUR WIDE GAP */
        }

        .tree-item {
            position: relative;
            padding: 8px 0 8px 10px;
            text-align : left;
        }

        .tree-item::before {
            content: "";
            position: absolute;
            top: 18px;
            left: -20px;
            width: 20px;
            height: 2px;
            background: #ccc;
        }
        
        .tree-bullet {
            position: absolute;
            left: -8px;
            top: 15px;
            width: 8px;
            height: 8px;
            background: #e6e6e6;
            border: 2px solid #999;
            border-radius: 50%;
        }

        /* Green */
        .bullet-green {
            background: #4CAF50;  /* green */
            border-color: #3b8d3f;
        }

        /* Orange */
        .bullet-orange {
            background: #FFA500;  /* orange */
            border-color: #cc8400;
        }

        /* Red */
        .bullet-red {
            background: #E53935;  /* red */
            border-color: #b32c29;
        }

        .bullet-purple {
            background: #BC57C2;  /* red */
            border-color: #742F78;
        }

        .doc-arrow {
            font-size: 8px;
            color: #666;
            margin-left: 6px;
            transition: transform 0.2s ease;
        }

        tr.shown .doc-arrow {
            color: #000;
        }

        .ip-section{
            color : #194A10;
        }

        small{
            font-size : 12px;
        }

        .red-link {
            color: #B81A2E !important;
        }

        #remarkModal .modal-dialog {
            margin-top: -140px;   /* adjust distance from top */
            margin-right: 50px;
        }

        #remarkModal .modal-content {
            border-radius: 10px;
        }
        #remarkModal .modal-header {
            border-bottom: none;
        }

        #remarkModalSr .modal-dialog {
            margin-top: -140px;   /* adjust distance from top */
            margin-right: 50px;
        }

        #remarkModalSr .modal-content {
            border-radius: 10px;
        }
        #remarkModalSr .modal-header {
            border-bottom: none;
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
                        <?=$side_menu10;?>
                    </div>
                    <div class="d-flex align-items-center ms-auto">
                        <ul class="nav nav-pills success-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-series="social" onclick="location.href='ip-s2w-list-all.php'">
                                    <i class="bi bi-calendar-check fs-4 text-primary"></i>
                                    <span>Today</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active text-dark" data-series="project" onclick="location.href='#'">
                                    <i class="bi bi-arrow-clockwise fs-3 text-muted"></i>
                                    <span>Previous</span>
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <?php

                $today = date('Y-m-d');

                // Get total inspections for history (not today)
                $queryAll = "SELECT COUNT(s2w_id) AS total_s2w 
                             FROM inspection_s2w S
                             LEFT JOIN inspection_records I ON S.s2w_ir_id = I.ir_id
                             WHERE I.shift_date!= '$shift_date'";
                        
                if ($session_role == 4) {
                    // Restrict to only their own records
                    $queryAll .= " AND S.created_by = '$session_id' ";
                }

                $resultAll = mysqli_query($db_con, $queryAll);
                $rowAll = mysqli_fetch_assoc($resultAll);

                ?>

                <div class="card h-auto">
                    <div class="card-body ai-tabs-1 py-2">
                        <ul class="nav nav-tabs align-items-end" id="myTab" role="tablist">                            
                            <li class="nav-item" role="presentation">
                            <a class="nav-link active" href="#">
                                All Records
                                <span class="badge badge-circle badge-light badge-primary light ms-2"><?= $rowAll['total_s2w']; ?></span>
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
                                                            <h2 class="text-koko count count-draft"><?= $total_new ?></h2> 
                                                            <span>New Created</span>
                                                        </div>
                                                        <!-- <p>S2W</p> -->
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-sven">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-info count count-pendingRev"><?= $total_pendingRev ?></h2>
                                                            <span>Pending Review</span>
                                                        </div>	
                                                        <!-- <p>S2W</p> -->
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-sven">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-purple count count-pending"><?= $total_pending ?></h2>
                                                            <span>Pending Approval</span>
                                                        </div>	
                                                        <!-- <p>S2W</p> -->
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-eleven">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-danger count count-cancelled"><?= $total_cancelled ?></h2>
                                                            <span>Cancelled</span>
                                                        </div>	
                                                        <!-- <p>S2W</p> -->
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-eleven">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-teal count count-returned"><?= $total_returned ?></h2>
                                                            <span>Returned</span>
                                                        </div>	
                                                        <!-- <p>S2W</p> -->
                                                    </div>
                                                </div>
                                                <div class="col-xl-2 col-sm-3 col-6">
                                                    <div class="task-summary task-odd">
                                                        <div class="d-flex align-items-baseline">
                                                            <h2 class="text-warning count count-approved"><?= $total_approved ?></h2>
                                                            <span>Approved</span>
                                                        </div>	
                                                        <!-- <p>S2W</p> -->
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
                                                        
                                                        <div class="col-md-5 mb-2">                                            
                                                            <label class="form-label">Inspection Date Range</label>
                                                            <input class="form-control input-daterange-datepicker" type="text" name="daterange" id="daterange_insp" value="">
                                                        </div>

                                                        <!-- Row 2 -->
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
                                                            $sqlStatusFilter = "SELECT statusid, statusname FROM system_status WHERE status = 'AC' AND s2w = 'Y' ORDER BY statusmaps";
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
                                            <div class="card-body">
                                                <div class="col-xl-4 col-sm-3 mb-2 ms-auto mb-4">                                            
                                                    <!-- Search Box -->
                                                    <div class="input-group flex-grow-1 mb-2">
                                                        <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                                        <input type="text" id="searchInput" class="form-control" placeholder="Search">
                                                    </div>                                                    
                                                </div>
                                                <div class="table-responsive">
                                                    <table id="s2wListall" class="display table mb-1 table-striped-thead table-wide table-md w-100">                                                              
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th>Doc No</th>
																<th>Part No</th>
																<th>Model</th>
																<th>Inspection Date</th>
																<th>Shift</th>
                                                                <th>Status</th>
                                                                <th class="nosort">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
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

                                            <!-- View inspection detail-->
                                            <divView all doc class="modal fade" id="detailModal">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">                                                     
                                                            <h5 class="modal-title p-3">Inspection Record Detail</h5>                                                 
                                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>                      
                                                        <div class="modal-body" id="detailModalBody">
                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- View sorting detail-->
                                            <divView all doc class="modal fade" id="sortingModal">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">                                                     
                                                            <h5 class="modal-title p-3">Sorting Report Detail</h5>                                                 
                                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div>                      
                                                        <div class="modal-body" id="sortingModalBody">
                                                        
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
                                                            <label for="cancel_remark" class="form-label">Cancellation Remark <span class="text-danger">*</span></label>
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
                                                                <h6 class="fw-bold mb-1">Comment/Reason</h6>
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

                                            <div class="modal fade" id="remarkModalSr" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-md">
                                                    <div class="modal-content border-0 shadow-sm">
                                                        <div class="modal-body p-3 d-flex align-items-start bg-light-green">
                                                            <!-- Icon -->
                                                            <div class="me-3">
                                                                <i class="fa fa-envelope fs-2 text-primary"></i>
                                                            </div>

                                                            <!-- Text -->
                                                            <div>
                                                                <h6 class="fw-bold mb-1">Comment/Reason</h6>
                                                                <p id="remarkContentSr" class="mb-0 small text-primary">
                                                                    <!-- Display remark here -->
                                                                </p>
                                                            </div>

                                                            <!-- Close button -->
                                                            <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
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
    //to apply select style to non select2
    $('.result-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });
    </script>

    <script>

    $('#daterange_insp').daterangepicker({
        startDate: moment().startOf('month'),
        endDate: moment().endOf('month'),
        locale: {
            format: 'DD/MM/YYYY'
        }
    });

    $('#daterange_insp').val('');
    
    </script>

    <script>

    function reloadTotals() {
        $.ajax({
            url: 'count-ip-s2w-status-pre.php',
            method: 'POST',
            dataType: 'json',  // important
            success: function (data) {
                $('.count-draft').text(data.draft);
                $('.count-pendingRev').text(data.pendingRev);
                $('.count-pending').text(data.pending);
                $('.count-approved').text(data.approved);
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
        const table = $('#s2wListall').DataTable();
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

        const imgSrc = $(this).data('full');
        console.log("Clicked:", imgSrc);

        $('#zoomedImage').attr('src', imgSrc);
        const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        modal.show();
    });

    
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

     document.addEventListener('DOMContentLoaded', function () {
        const remarkModal = new bootstrap.Modal(document.getElementById('remarkModalSr'));
        const remarkContent = document.getElementById('remarkContentSr');

        // Event delegation: catch clicks inside detailModal
        document.getElementById('sortingModalBody').addEventListener('click', function (e) {
            if (e.target.classList.contains('timeline-title-remark-sr')) {
                const remark = e.target.getAttribute('data-remark') || 'No remark available.';
                remarkContent.textContent = remark;
                remarkModal.show();
            }
        });
    });

    </script>

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

    let table;
    $(document).ready(function() {

        table = $('#s2wListall').DataTable({
            processing: true,
            serverSide: true,
            order: [[1, 'asc']],
			lengthChange: false,
            scrollX: true,
            scrollY: '70vh',
            language: {
                paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
            },
            "ajax": {
                url: 'fetch-ip-s2w-rcd-all-pre.php',
                method:"POST",
                data: function (d) {
                        d.action   = 'fetch_records_list_all';
                        d.fd_model = $('.cs_model').val();
                        d.fd_type = $('.cs_type').val();
                        d.fd_material = $('.cs_material').val();
                        d.fd_shift = $('.cs_shift').val();
                        d.fd_status = $('#filterStatus').val();
                        d.fd_daterange = $('#daterange_insp').val();
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

                //Refresh total counts based on filters
                reloadTotals();
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

    $(document).on('click', '.pageAction', function() {

        const encs2wid = $(this).data('encs2wid');
        const srid = $(this).data('srid');
        const irid = $(this).data('irid');
        const status = $(this).data('status');
        const encstatus = $(this).data('encstatus');
        const pg = 'p';

        targetUrl = 'ip-s2w-edit.php?encs2wid=' 
                        + encodeURIComponent(encs2wid) 
                        + '&irid=' + encodeURIComponent(irid) 
                        + '&status=' + encodeURIComponent(encstatus)
                        + '&pg=' + encodeURIComponent(pg);

        window.location.href = targetUrl;
    }); 

    //view only
    $(document).on('click', '.pageActionView', function() {

        const encs2wid = $(this).data('encs2wid');
        const srid = $(this).data('srid');
        const irid = $(this).data('irid');
        const status = $(this).data('status');
        const encstatus = $(this).data('encstatus');
        const pg = 'p';

        targetUrl = 'ip-s2w-view.php?encs2wid=' 
                        + encodeURIComponent(encs2wid) 
                        + '&irid=' + encodeURIComponent(irid) 
                        + '&status=' + encodeURIComponent(encstatus)
                        + '&pg=' + encodeURIComponent(pg);

        window.location.href = targetUrl;
    }); 

    </script>


    <script>

    document.getElementById('btnBack').addEventListener('click', function () {
        history.back();
    });

    </script>

    <script>

    $(document).on('click', '.viewDocument', function () {
        
        const tr = $(this).closest('tr');
        const table = $('#s2wListall').DataTable();
        const row = table.row(tr);

        const irid = $(this).data('irid');
        const arrow = $(this).find('.doc-arrow'); // FA icon

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            arrow.removeClass('fa-minus').addClass('fa-plus');

        } else {
            $.post('fetch-ip-s2w-docno.php', { irid: irid }, function (res) {
                row.child(`<div class="p-2">${res}</div>`).show();
                tr.addClass('shown');
                arrow.removeClass('fa-plus').addClass('fa-minus');
            });
        }
    });
     
    // View inspection
    $(document).on('click', '.viewDocInspection', function() {

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

    // View Sorting
    $(document).on('click', '.viewDocSorting', function() {

        let docno = $(this).data('docno');

        $.ajax({

            url: 'fetch-sorting-details.php',
            type: 'POST',
            dataType: 'html',
            data: { action : 'sorting_details', docno: docno },
            success: function(res) {
                $('#sortingModalBody').html(res);
                let m = new bootstrap.Modal(document.getElementById('sortingModal'));
                m.show();                
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                alert("Failed to load modal content.");
            }
        });
    }); 

    $(document).on('click', '.viewMaterial', function () {
        const tr = $(this).closest('tr');
        const table = $('#inspectionGroupsList').DataTable();
        const row = table.row(tr);

        const material = $(this).data('material');
        const model    = $(this).data('model');
        const arrow = $(this).find('.doc-arrow'); // FA icon

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            arrow.removeClass('fa-minus').addClass('fa-plus');

        } else {
            $.post('fetch-material-gallery.php', { material, model }, function (res) {
                row.child(`<div class="p-2">${res}</div>`).show();
                tr.addClass('shown');
                arrow.removeClass('fa-plus').addClass('fa-minus');
            });
        }
    });

    </script>
  
</body>
</html>