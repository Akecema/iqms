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
        
        .badge-sm {
            font-size: 0.75rem;
            padding: 0.42em 0.65em;
        }

        #searchInput::placeholder {
            font-size: 10px; 
            color: #D6D3D2;       /* optional: change placeholder color */
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
        $query_i = "SELECT I.ir_id, I.ir_material, I.ir_result, I.ir_status, I.ir_pallet_no, I.ir_shift, I.inspect_date, I.shift_date, I.inspect_group, 
                         T.modcode, M.matno, M.matdesc, P.typeside, H.shiftdesc
                    FROM inspection_records I
                    LEFT JOIN model_details as T ON I.ir_model = T.modid
                    LEFT JOIN material_header as M ON I.ir_material = M.matid
                    LEFT JOIN model_type as P ON M.typeid = P.typeid 
                    LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort     
                    WHERE I.inspect_group = ? ORDER BY I.ir_pallet_no ASC";
        $stmt_i = $db_con->prepare($query_i);
        $stmt_i->bind_param("i", $group);
        $stmt_i->execute();
        $result_i = $stmt_i->get_result();
        $row_i = $result_i->fetch_array();

        $gall_model = $row_i['modcode'];

        if ($row_i["ir_shift"] == 'D') $badgeClass = 'badge-outline-ungu';
        elseif ($row_i["ir_shift"] == 'N') $badgeClass = 'badge-outline-pink';

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
        $total_returned = 0;

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
                case 12:
                    $total_returned++;
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

                <?php

                $today = date('Y-m-d');

                // Get total inspections for today
                $queryToday = "SELECT COUNT(DISTINCT inspect_group) AS total_groups FROM inspection_records";
                $resultToday = mysqli_query($db_con, $queryToday);
                $rowToday = mysqli_fetch_assoc($resultToday);

                // Get total inspections for history (not today)
                $queryHistory = "SELECT COUNT(ir_id) AS total_inspections FROM inspection_records";
                $resultHistory = mysqli_query($db_con, $queryHistory);
                $rowHistory = mysqli_fetch_assoc($resultHistory);

                ?>

                <div class="card h-auto">
                    <div class="card-body ai-tabs-1 py-2">
                        <ul class="nav nav-tabs align-items-end" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="create-tab" data-bs-toggle="tab" data-bs-target="#create-tab-pane" type="button" role="tab" aria-controls="create-tab-pane" 
                                aria-selected="true">
                                Grouped by Date & Shift
                                <span class="badge badge-circle badge-light badge-primary light ms-2">
                                    <?= $rowToday['total_groups']; ?>
                                </span>
                            </button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs-tab-pane" type="button" role="tab" aria-controls="jobs-tab-pane" 
                                aria-selected="false">
                                All Records
                                <span class="badge badge-circle badge-light badge-primary light ms-2"><?= $rowHistory['total_inspections']; ?></span></button>
                            </li>								  
                        </ul>
                    </div>
                </div>
                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
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
                                                                        <p><strong class="text-primary"><?=$row_i['modcode'];?> (<?=$row_i['typeside'];?>)</strong></p>
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
                                                                            <p> <span class="fs-13 badge badge-rounded <?=$badgeClass ?>"><?=$row_i['shiftdesc'];?></span></p>
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

                                <?php                       

                                // Get total inspections for today
                                $queryOK = "SELECT COUNT(*) AS totalOK 
                                                    FROM inspection_records 
                                                        WHERE ir_result = 'OK' AND inspect_group = '$group'";
                                $resultOK = mysqli_query($db_con, $queryOK);
                                $rowOK = mysqli_fetch_assoc($resultOK);

                                // Get total inspections approved
                                $queryNG = "SELECT COUNT(*) AS totalNG 
                                                    FROM inspection_records 
                                                        WHERE ir_result = 'NG' AND inspect_group = '$group'";
                                $resultNG = mysqli_query($db_con, $queryNG);
                                $rowNG = mysqli_fetch_assoc($resultNG);

                                ?>

                                <div class="row">
                                    <!-- Activity comment-->
                                    <div class="col-xxl-3 col-xl-4">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card">
										<div class="card-header">
											<div class="clearfix">
												<h4 class="card-title mb-0">Connected Accounts</h4>
											</div>
										</div>
										<div class="card-body">
                                            <?php
                                            $sql_status = "SELECT statusid, statusname FROM system_status WHERE status = 'AC' and inspection = 'Y' ORDER BY statusid ASC";
                                            $rst_status = mysqli_query($db_con, $sql_status);

                                            while ($row_status = mysqli_fetch_array($rst_status)) {

                                                if ($row_status['statusid'] == 4) $statusBadge = 'badge-warning ';
                                                elseif ($row_status['statusid'] == 5) $statusBadge = 'badge-pink';
                                                elseif ($row_status['statusid'] == 8) $statusBadge = 'badge-oren';
                                                elseif ($row_status['statusid'] == 9) $statusBadge = 'badge-purple';
                                                elseif ($row_status['statusid'] == 12) $statusBadge = 'badge-success';
                                            
                                            ?>

											<div class="d-flex align-items-center border-bottom py-3">
												<div class="clearfix ms-2">
													<h6 class="mb-0 fw-semibold"><?=$row_status['statusname'] ?></h6>
													
												</div>
												<div class="clearfix ms-auto">
													<div class="form-check form-switch">
														<a href="javascript:void(0)" class="badge badge-rounded <?=$statusBadge ?> badge-md">1</a>
													</div>
												</div>
											</div>

                                            <?php } ?>
										</div>
									</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-9 col-xl-8">
                                        <div class="card">
                                             <div class="card-header py-3 d-block d-sm-flex">
                                                <h4 class="heading mb-0"></h4>
                                                <span class="text-success dang d-block">
                                                <span id="totalOkPending" class="me-3 d-inline-flex align-items-center" data-bs-toggle="tooltip" title="OK">
                                                    <svg class="me-1" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 4.5L6.75 12.75L3 9" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    <span><?=$rowOK['totalOK'];?></span>
                                                </span>

                                                <span id="totalNgPending" class="d-inline-flex align-items-center" data-bs-toggle="tooltip" title="NG">
                                                    <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ca1d14ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                        <line x1="18" y1="6" x2="6" y2="18"></line>
                                                        <line x1="6" y1="6" x2="18" y2="18"></line>
                                                    </svg>
                                                    <span><?=$rowNG['totalNG'];?></span>
                                                </span>
                                            </div>
                                            <div class="card-body">
                                                <div class="row" class="row mb-3">
                                                    <div class="col-xl-3 col-sm-6 mb-2">
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
                                                    <div class="col-xl-3 col-sm-6 mb-2">
                                                        <!-- Result Filter -->
                                                        <select id="filterResult" class="filter-select ">
                                                            <option value="">Any Result</option>
                                                            <option value="OK">OK</option>
                                                            <option value="NG">NG</option>
                                                        </select>
                                                    </div>

                                                    
                                                    <div class="col-xl-4 col-sm-3 mb-2">                                            
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
                                                    <div class="col-xl-2 col-sm-5 mb-2 d-flex" style="margin-top: 4px;">
                                                        <div>
                                                            <button type="button" id="btnResetFilter" class="btn btn-rounded btn-dark btn-sm" data-bs-toggle="tooltip" title="">
                                                                <i class="fa fa-undo me-1"></i> Reset
                                                            </button>                                                
                                                        </div> 
                                                    </div>
                                                </div>
                                                
                                                <div class="nextline"></div>

                                                <div class="table-responsive">
                                                    <table id="inspectionGroupsList" class="display table mb-1 table-striped-thead table-wide table-md">                                                              
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th>Doc No</th>
                                                                <th class="pallet-col">Pallet Sequence</th>
                                                                <th>Result</th>
                                                                <th>Status</th>
                                                                <th class="nosort">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>  
                                            </div>

                                            <!-- Modal View-->
                                            <div class="modal fade custom-modal-md" id="detailModal">
                                                <div class="modal-dialog modal-lg" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary text-white">
                                                            <h5 class="modal-title" id="approveModalLabel"></h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                                        <img src="" id="zoomedImage" class="img-fluid rounded shadow" style="max-width: 90vw; max-height: 90vh;">
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

    let table;
    $(document).ready(function() {

        table = $('#inspectionGroupsList').DataTable({
            processing: true,
            serverSide: true,
            order: [[2, 'desc']],
			lengthChange: false,
            language: {
                paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
            },
            "ajax": {
                url: 'fetch-inspection-rcd-all.php',
                method:"POST",
                data: function (d) {
                        d.action   = 'fetch_records_list';
                        d.igroup = <?=$group ?>;
                        d.fd_status = $('#filterStatus').val();
                        d.fd_result = $('#filterResult').val();
                        d.fd_search = $('#searchInput').val();

                        console.log("Filters sent to server:", d);
                    }
            },
            columnDefs: [
                    { targets: 'nosort', orderable: false }
            ],
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

    $('#filterStatus, #filterResult').on('change', function() {
        table.ajax.reload();
    });

    $('#searchInput').on('keyup', function() {
        table.ajax.reload();
    });

    $('#btnResetFilter').on('click', function() {
        $('#filterStatus, #filterResult').val(null).trigger('change');
        $('#searchInput').val('');
        table.ajax.reload();
    });

    </script>
    
    <script>

    $(document).on('click', '.viewDocDetails', function() {

        let docno = $(this).data('docno');

        $.ajax({

            url: 'fetch-inspection-rcd-pending-action.php',
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

</body>
</html>