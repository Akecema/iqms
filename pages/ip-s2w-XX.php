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
            border: 2px solid #e74c3c !important;  /* Red border */
            background-color: #fff6f6;
        }

        .avatar-hover-border {
            border: 4px solid #1c1c1dff;
            box-shadow: 0 0 8px #28a74533;
        }

        .avatar-hover-border:hover {
            border: 5px solid #1b1c1bff;
            box-shadow: 0 0 8px #28a74533;
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
            z-index: 10;           /* Bring it above wrappers */
            pointer-events: auto;  /* Ensure clicks pass through */
        }

         .zoomable-img:hover {
            transform: scale(1.35); /* optional: subtle zoom effect on hover */
        }

        #listdoSomethingwrong tbody tr td:last-child {
            text-align: left !important; 
        }

        #listdoSomethingwrong thead tr th:last-child{
            text-align: left !important;
        }

        
        #listdoSomethingwrong tbody tr td:first-child {
            text-align: left !important; 
        }

        #listdoSomethingwrong thead tr th:first-child{
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
        
       .avatar-list-inline .avatar {
            position: relative;
            z-index: 1;
            transition: transform 0.2s ease;
            margin-left: -10px;
            border: 2px solid #fff;
            cursor: zoom-in;
        }

        .avatar-list-inline .avatar:hover {
            z-index: 10;
            transform: scale(1.6); /* optional hover zoom */
        }

        .avatar:hover {
            transform: scale(1.6); /* optional: subtle zoom effect on hover */
        }

        .modal-header {
            border-bottom: none !important;
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
                </div>

                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                        <div class="row">                    
                            <div class="col-12">
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
                                                <div class="col-xl-4 col-sm-3 mb-2 ms-auto">                                            
                                                        <!-- Search Box -->
                                                    <div class="input-group flex-grow-1 mb-2">
                                                        <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                                        <input type="text" id="searchInput" class="form-control" placeholder="Search">
                                                    </div>
                                                </div>
                                                <div class="table-responsive" style="overflow-x:auto;">
                                                    <table id="listdoSomethingwrong" class="display table mb-1 table-striped-thead table-wide table-md w-100">                                                              
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th>Inspection Doc No</th>
                                                                <th>S2W Doc No</th>
																<th>Part No</th>
																<th>Model</th>
																<th>Inspection Date</th>
																<th>Shift</th>
                                                                <th class="nosort">Status</th>
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
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content" style="background: transparent; border: none;">
                                                        <img src="" id="zoomedImage" class="img-fluid rounded shadow" style="max-width: 90vw; max-height: 90vh;">
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

    $('.filter-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
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

    $(document).on('click', '.viewDocDetails', function() {

        let docno = $(this).data('docno');

        $.ajax({

            url: 'fetch-ip-s2w.php',
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

    $(document).on('click', '.zoomable-img', function () {
        const src = $(this).data('src');        
        console.log('Image clicked:', src);
        $('#zoomedImage').attr('src', src);
        const zoomModal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        zoomModal.show();
    });

    </script>

    <script>

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

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

    let table;
    $(document).ready(function() {

        table = $('#listdoSomethingwrong').DataTable({
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
                url: 'fetch-ip-s2w.php',
                method:"POST",
                data: function (d) {
                        d.action   = 'fetch_records_create';
                        d.fd_model = $('.cs_model').val();
                        d.fd_type = $('.cs_type').val();
                        d.fd_material = $('.cs_material').val();
                        d.fd_shift = $('.cs_shift').val();
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
            }
        }); 
		 
    });

    </script>

    <script>

    $(document).on('click', '.btnCreate, .btnEdit, .btnView', function() {
        let irid = $(this).data('irid');
        window.location.href = 'ip-sorting-create.php?erid=' + irid;
    });

    </script>

    <script>

    $(document).ready(function () {
        // Read erid from URL
        const urlParams = new URLSearchParams(window.location.search);
        const irid = urlParams.get('erid');

        if (irid) {
            $.ajax({
                url: 'inspection-rcd-imgview.php',
                type: 'POST',
                dataType: 'json',
                data: { ir_id: irid },   // pass irid
                success: function (res) {
                    // Inject images
                    $('#lightgallery').html(res.gallery_html);

                    // Inject details
                    $('#material_product_detail').html(res.detail_html);

                    // Init lightGallery if needed
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
    });

    </script>

    <script>

    $('#btnFilterSearch').on('click', function() {
        table.ajax.reload();
    });

    $('#btnResetFilter').on('click', function() {
        $('.cs_model, .cs_type, .cs_material, .cs_shift').val('').trigger('change');
        $('#searchInput').val('');
        table.ajax.reload();
    });

    $('#searchInput').on('keyup', function() {
        table.ajax.reload();
    });

    </script>

</body>
</html>