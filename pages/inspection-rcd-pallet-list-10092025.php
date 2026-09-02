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

    <!-- Tagify Css -->
	<link href="vendor/tagify/dist/tagify.css" rel="stylesheet">	
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">

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

        .sequencePallet {
            cursor: pointer;
            transition: background 0.2s;
        }
        .sequencePallet:hover {
            background-color: #f8f9fa;
        }
        .sequencePallet.active-pallet {
            background-color: #EBEDEB; 
            border-left: 3px solid #0d6efd;
        }
        .sequencePallet { 
            cursor: pointer; transition: background .15s; 
        }
        .sequencePallet:hover { 
            background: #f8f9fa; 
        }
        .sequencePallet.active-pallet { 
            background: #e7f1ff; border-left: 3px solid #0d6efd; 
        }

        .filter-select { min-width: 180px; }
        .input-group .form-control { min-width: 160px; }

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

        .avatar-list {
            display: flex;
            align-items: center;
            justify-content: flex-start;  /* Forces left alignment */
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
        .inspectionTable_defect tbody tr td:last-child {
            text-align: left; 
        }

        .inspectionTable_defect thead tr th:last-child {
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
        </style>

		<?php

        $group = $_GET['egp'] ?? null;

        if (!$group || !is_numeric($group)) {
            echo "<p>Invalid group</p>";
            exit;
        }

        $query = "SELECT * FROM inspection_records I  
                    WHERE I.inspect_group = ? ORDER BY I.ir_pallet_no ASC";
        $stmt = $db_con->prepare($query);
        $stmt->bind_param("i", $group);
        $stmt->execute();
        $result_isp = $stmt->get_result();

        //Inspection details
        $query_i = "SELECT I.ir_id, I.ir_material, I.ir_result, I.ir_status, I.ir_pallet_no, I.inspect_date, I.shift_date, I.inspect_group, 
                         T.modcode, M.matno, M.matdesc, H.shiftdesc
                    FROM inspection_records I
                    LEFT JOIN model_details as T ON I.ir_model = T.modid
                    LEFT JOIN material_header as M ON I.ir_material = M.matid 
                    LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort     
                    WHERE I.inspect_group = ? ORDER BY I.ir_pallet_no ASC";
        $stmt_i = $db_con->prepare($query_i);
        $stmt_i->bind_param("i", $group);
        $stmt_i->execute();
        $result_i = $stmt_i->get_result();
        $row_i = $result_i->fetch_array();

        $gall_model = $row_i['modcode'];

        //Photo
        $sql_img = "SELECT imagename FROM material_gallery WHERE image_matid = '$row_i[ir_material]'";
        $result_img = mysqli_query($db_con, $sql_img);

        $gallery_html = '';
        $count = 0;

        while ($row_img = mysqli_fetch_assoc($result_img)) {
            
            $view_img = $row_img['imagename'];
            $thumb = "gallery/model/$gall_model/$view_img"; // adjust path if needed
            $full = "gallery/model/$gall_model/$view_img";

            $extra = ($count == 3) ? ' gallery-more" data-more="+03' : '';
            $col = ($count == 0) ? 'colspan-3 rowspan-2' : '';

            $gallery_html .= "
                <a href=\"$full\" data-exthumbimage=\"$thumb\" data-src=\"$full\" class=\"grid-item $col$extra\">
                    <img src=\"$thumb\" alt=\"\">
                </a>
            ";
            $count++;
            
        }

        if ($count == 0) {
            $gallery_html = '<p class="text-muted">No images found.</p>';
        }

        //Count total OK and NG 
        $records = [];
        $total_ok = 0;
        $total_ng = 0;
        
        //Count total status
        $total_new = 0;
        $total_pending = 0;
        $total_approved = 0;
        $total_completed = 0;
        $total_cancelled = 0;

        while ($row = $result_isp->fetch_assoc()) {
            $records[] = $row;

            if ($row['ir_result'] === 'OK') {
                $total_ok++;
            } elseif ($row['ir_result'] === 'NG') {
                $total_ng++;
            }

            // Count by status
            switch ($row['ir_status']) {
                case 1:
                    $total_new++;
                    break;
                case 9:
                    $total_pending++;
                    break;
                case 4:
                    $total_approved++;
                    break;
                case 5:
                    $total_completed++;
                    break;                    
                case 8:
                    $total_cancelled++;
                    break;
            }
        }

        // In the main PHP page before the HTML
        //Get ir_id for pallet sequence 1
        $sqlFirst = "SELECT ir_id FROM inspection_records WHERE inspect_group = $group and ir_pallet_no = 1 ORDER BY ir_id ASC LIMIT 1";
        $resFirst = $db_con->query($sqlFirst);
        $rowFirst = $resFirst->fetch_assoc();
        $first_ir_id = $rowFirst ? $rowFirst['ir_id'] : 0; 

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
                        Inspection Result
                    </div>
                </div>
                <div class="row">                    
                    <div class="col-12">
                        <!-- Preview material, inspection details -->
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
                                                <div class="col-xl-6 col-lg-8">
                                                    <div class="gallery-grid rows-3" id="lightgallery">
                                                        <!-- Images will be injected here via AJAX -->
                                                        <?=$gallery_html;?>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">      
                                                    <div class="product-detail-content" id="material_product_detail">
                                                        <div class="alert alert-primary border-primary outline-dashed py-3 px-3 mt-1 mb-3 mb-0 text-black d-flex">												
                                                            <div class="mx-3">
                                                                <span fs-9>Part Name</span>
                                                                <p><strong class="text-primary"><?=$row_i['matdesc'];?></strong></p>	

                                                                <span fs-9>Part No</span>
                                                                <p><strong class="text-primary"><?=$row_i['matno'];?></strong></p>

                                                                <span fs-9>Model</span>
                                                                <p><strong class="text-primary"><?=$row_i['modcode'];?></strong></p>
                                                            </div>
                                                        </div>
                                                        <div class="row task">                                                        
                                                            <div class="col-xl-4 col-sm-6 col-8">
                                                                <div class="task-summary task-sven">
                                                                    <div class="d-flex align-items-baseline">
                                                                        <span class="mb-2">Inspection Date</span>
                                                                    </div>	
                                                                    <p><?=date('d-m-Y', strtotime($row_i['inspect_date']));?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-sm-6 col-8">
                                                                <div class="task-summary task-odd">
                                                                    <div class="d-flex align-items-baseline">
                                                                        <span class="mb-2">Production Date</span>
                                                                    </div>	
                                                                    <p><?=date('d-m-Y', strtotime($row_i['shift_date']));?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-sm-6 col-8">
                                                                <div class="task-summary task-eleven">
                                                                    <div class="d-flex align-items-baseline">
                                                                        <span class="mb-2">Shift</span>
                                                                    </div>	
                                                                    <p> <span class="fs-13 badge badge-rounded badge-outline-secondary"><?=$current_shiftdesc;?></span></p>
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

                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row task">
                                        <div class="col-xl-2 col-sm-3 col-6">
                                            <div class="task-summary">
                                                <div class="d-flex align-items-baseline">
                                                    <h2 class="text-primary count"><?= $total_new ?></h2> 
                                                    <span>New Created</span>
                                                </div>
                                                <p>Inspections</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-3 col-6">
                                            <div class="task-summary task-sven">
                                                <div class="d-flex align-items-baseline">
                                                    <h2 class="text-purple count"><?= $total_pending ?></h2>
                                                    <span>Pending Review</span>
                                                </div>	
                                                <p>Inspections</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-3 col-6">
                                            <div class="task-summary task-odd">
                                                <div class="d-flex align-items-baseline">
                                                    <h2 class="text-warning count"><?= $total_approved ?></h2>
                                                    <span>Approved</span>
                                                </div>	
                                                <p>Inspections</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-3 col-6">
                                            <div class="task-summary task-odd">
                                                <div class="d-flex align-items-baseline">
                                                    <h2 class="text-success count"><?= $total_completed ?></h2>
                                                    <span>Completed</span>
                                                </div>	
                                                <p>Inspections</p>
                                            </div>
                                        </div>
                                        <div class="col-xl-2 col-sm-3 col-6">
                                            <div class="task-summary task-eleven">
                                                <div class="d-flex align-items-baseline">
                                                    <h2 class="text-danger count"><?= $total_cancelled ?></h2>
                                                    <span>Cancelled</span>
                                                </div>	
                                                <p>Inspections</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row gx-0">
                            <div class="col-xl-12">
                                <div class="card h-auto">
                                    <div class="card-body p-0">
                                        <div class="card-header">
                                            <h4 class="heading mb-0"> Total Inspections Result</h4>  
                                            <span class="text-success dang d-block">
                                                <span class="me-3 d-inline-flex align-items-center" data-bs-toggle="tooltip" title="OK">
                                                    <svg class="me-1" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 4.5L6.75 12.75L3 9" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    <?= $total_ok ?>
                                                </span>

                                                <span class="d-inline-flex align-items-center" data-bs-toggle="tooltip" title="NG">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ca1d14ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                    <?= $total_ng ?>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="row gx-0">
                                            <!-- column -->
                                            <div class="col-xl-3 col-xxl-4 col-lg-4 email-left-body">
                                                <div class="email-left-body">                                                     
                                                    <div class="email-left-box dz-scroll" id="email-left">
                                                        <div class="d-flex align-items-center justify-content-between flex-wrap mb-3 gap-2">
                                                            <div class="d-flex flex-grow-1 gap-2">                                                                
                                                                <div class="mb-3">
                                                                    <div class="mb-2">
                                                                    
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

                                                                    <div class="mb-2">
                                                                        <!-- Result Filter -->
                                                                        <select id="filterResult" class="filter-select ">
                                                                            <option value="">Any Result</option>
                                                                            <option value="OK">OK</option>
                                                                            <option value="NG">NG</option>
                                                                        </select>
                                                                    </div>

                                                                    <div class="mb-2">
                                                                        <!-- Search Box -->
                                                                        <div class="input-group flex-grow-1">
                                                                            <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                                                            <input type="text" id="searchInput" class="form-control" placeholder="Search...">
                                                                        </div>
                                                                    </div>

                                                                    <button type="button" id="resetFilters" class="btn btn-outline-secondary btn-sm">Reset</button>
                                                                </div>                                                                   
                                                            </div>                                                
                                                        </div>
                                                        
                                                        <div class="card">
                                                            <div class="card-header pb-0 border-0">
                                                                <div class="clearfix">
                                                                    <h5 class="card-title mb-0">Pallet Sequence</h5>
                                                                </div>
                                                                <div class="clearfix ms-auto">
                                                                    <h5 class="">Status</h5>
                                                                </div>
                                                            </div>
                                                            <div class="card-body">

                                                                <?php 

                                                                $i = 1;
                                                                foreach ($records as $row) { 

                                                                    $badgeClass = '';

                                                                    if ($row["ir_result"] == 'OK') $badgeClass = 'badge-dark-2';
                                                                    elseif ($row["ir_result"] == 'NG') $badgeClass = 'badge-dark-orange';

                                                                    // All transaction status
                                                                    $sqlStatus = "SELECT statusid, statusname FROM system_status WHERE statusid = '$row[ir_status]' ";
                                                                    $resStatus = $db_con->query($sqlStatus);
                                                                    $rowStatus = $resStatus->fetch_assoc();

                                                                    //Status
                                                                    $textClass = '';

                                                                    if ($row['ir_status'] == 8) $textClass = 'text-danger';
                                                                    else if ($row['ir_status'] == 9) $textClass = 'text-success';
                                                                    else if ($row['ir_status'] == 11) $textClass = 'text-primary';
                                                                    else $textClass = 'text-dark';

                                                                    if ($row['ir_status'] == 1) $statusText = '';
                                                                    else $statusText = $rowStatus["statusname"];
                                                                    
                                               
                                                                    $statusCell = '<span class='.$textClass.' style="font-size:0.75rem; font-weight: 500;">'.$statusText.'</span>';

                                                                ?>

                                                                <div class="d-flex align-items-center py-2 hover-bg-light rounded my-1 sequencePallet"
                                                                    data-irid="<?= $row['ir_id'];?>"
                                                                    data-pallet="<?= $row['ir_pallet_no'];?>"
                                                                    data-result="<?= $row['ir_result'];?>"
                                                                    data-status="<?= $row['ir_status'];?>">
                                                                    <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
                                                                        <?= $row['ir_pallet_no'];?>
                                                                    </div>
                                                                    <div class="clearfix ms-3">
                                                                        <span class="fs-13">Result</span>
                                                                        <h6 class="mb-0 fw-semibold"><?= $row['ir_result'];?></h6>
                                                                    </div>
                                                                    <div class="clearfix ms-auto">
                                                                        <span class="badge badge-sm badge-light"><?= $statusCell;?></span>
                                                                    </div>
                                                                </div>

                                                                <?php } ?>  

                                                            </div>
                                                        </div>                                                        
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Edit Column -->
                                            <div class="col-lg-8 col-xl-9 col-xxl-8">
                                                <div class="email-right-box">
                                                    <!-- Visible when small screen -->
                                                    <div class="d-flex align-items-center px-3">
                                                        <h4 class="card-title d-sm-none d-block"><!-- Email --></h4>
                                                        <div class="email-tools-box float-end mb-2 mt-2">	
                                                            <i class="fa-solid fa-list-ul"></i>
                                                        </div>
                                                    </div>
                                                    <div role="toolbar" class="toolbar ms-1 ms-sm-0">                                                       
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="right-box-padding p-0" id="palletecontent">
                                                                    <!-- Load details inspection -->

                                                                </div>

                                                                <!-- Zoom photo in modal add -->
                                                                <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
                                                                    <div class="modal-dialog modal-dialog-centered">
                                                                        <div class="modal-content" style="background: transparent; border: none;">
                                                                            <img src="" id="zoomedImage" class="img-fluid rounded shadow" style="max-width: 90vw; max-height: 90vh;">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>                                                             
                                                    </div>
                                                </div>

                                                 <!-- Edit Defect modal -->
                                                <div class="modal fade" id="editDefectModal" tabindex="-1" aria-labelledby="DefectModalLabel">
                                                    <div class="modal-dialog  modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header bg-primary">
                                                                <h5 class="modal-title" id="ngModalLabel">Edit Defect</h5>
                                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
    </script>

    <script>    
    $(".email-tools-box").on('click', function(){
        $(' .email-left-body ,.email-tools-box').toggleClass("active");
    });
    </script>

    <script>
    $('.filter-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });
    </script>



    <script>

    $(function () {

        // init select2 first
        $('.filter-select').select2({
            minimumResultsForSearch: Infinity,
            width: 'style',
            dropdownParent: $('.card').first()
        });

        // debounce
        function debounce(fn, ms){ let t; return function(){ clearTimeout(t); t=setTimeout(()=>fn.apply(this, arguments), ms); }; }

        function loadPallet(ir_id, $el) {

            $('.sequencePallet').removeClass('active-pallet');
            if ($el) $el.addClass('active-pallet');

            $('#palletecontent').html('<div class="p-3 text-center"><span class="spinner-border text-primary"></span> Loading...</div>');
            $.post('get-pallet-details.php', { ir_id }, function (res) {
            $('#palletecontent').html(res);
            }).fail(function(){
            $('#palletecontent').html('<div class="p-3 text-danger">Error loading pallet details</div>');
            });
        }

        function applyFilters() {

            $('.sequencePallet').each(function () {
                console.log($(this).data('status'), $(this).data('result'), $(this).data('pallet'));
            });

          
            const fStatus = $('#filterStatus').val();   // statusid or ""
            const fResult = $('#filterResult').val();   // "OK" | "NG" | ""
            const q = ($('#searchInput').val() || '').trim().toLowerCase();

            // Console
            console.log('Filtering:', fStatus, fResult, q);

            $('.sequencePallet').each(function () {

                const $row = $(this);
                const rowStatus = String($row.data('status') ?? '');
                const rowResult = String($row.data('result') ?? '');
                const rowPallet = String($row.data('pallet') ?? '');
                const text = $row.text().toLowerCase();

                let show = true;
                if (fStatus && rowStatus !== fStatus) show = false;
                if (fResult && rowResult !== fResult) show = false;
                if (q && !(text.includes(q) || rowPallet.includes(q))) show = false;

                $row.toggle(show);
            });

            // if current active is hidden, pick first visible
            const $active = $('.sequencePallet.active-pallet:visible');

            if ($active.length === 0) {

                const $firstVisible = $('.sequencePallet:visible').first();
                
                if ($firstVisible.length) {
                    loadPallet($firstVisible.data('irid'), $firstVisible);
                } else {
                    $('#palletecontent').html('<div class="p-3 text-muted">No pallets match your filters.</div>');
                }
            }
        }

        // filters
        $('#filterStatus, #filterResult').on('change', applyFilters);
        $('#searchInput').on('input', debounce(applyFilters, 200));

        // click to load
        $(document).on('click', '.sequencePallet', function () {
            loadPallet($(this).data('irid'), $(this));
        });

        // default: load pallet 1 (or first)
        const $p1 = $('.sequencePallet[data-pallet="1"]').first();

        if ($p1.length) {
            loadPallet($p1.data('irid'), $p1);
        } else {
            const $first = $('.sequencePallet').first();
            if ($first.length) loadPallet($first.data('irid'), $first);
        }
    
    });

    </script>

    <script>
    $('#resetFilters').on('click', function(){

        $('#filterStatus').val('').trigger('change');
        $('#filterResult').val('').trigger('change');
        $('#searchInput').val('');
        // show all and reselect active/first
        $('.sequencePallet').show();

    });
    </script>

    <script>

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

    //Submit for review
    $(document).on('click', '.btnSubmit', function(e) {
        
        e.preventDefault();

        let $btn = $(this);
        let ir_id = $btn.data('irid');

        if (!confirm('Are you sure you want to submit this inspection for review?')) {
            return;
        }

        $.ajax({
            url: 'inspection-rcd-action.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {

                if (res.success) {
                    // SweetAlert2 for success message only
                    Swal.fire({
                        icon: 'success',
                        title: 'Submitted!',
                        text: 'Your inspection record was submitted for review.',
                        timer: 3000,
                        showConfirmButton: false
                    });

                    setTimeout(function() {
                        $('#btnFilter').trigger('click');
                    }, 300); // 300ms delay

                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.msg || 'Failed to submit.',
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred: ' + (xhr.responseText || error),
                });
            }
        });
    });

    </script>

</body>
</html>