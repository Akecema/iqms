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

		#inspectionPendingList tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionPendingList thead tr th:last-child{
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
                        <?=$side_menu5;?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

						<?php

						$today = date('Y-m-d');

						// Get total inspections for today
						$queryToday = "SELECT COUNT(*) AS total_today 
											FROM inspection_records 
												WHERE ir_status = '9' AND shift_date = '$today'";
						$resultToday = mysqli_query($db_con, $queryToday);
						$rowReview = mysqli_fetch_assoc($resultToday);

						// Get total inspections for history (not today)
						$queryHistory = "SELECT COUNT(*) AS total_history 
											FROM inspection_records 
												WHERE created_by = '$session_id' AND shift_date != '$today'";
						$resultHistory = mysqli_query($db_con, $queryHistory);
						$rowHistory = mysqli_fetch_assoc($resultHistory);

						?>

                        <div class="card h-auto">
							<div class="card-body ai-tabs-1 py-2">
								<ul class="nav nav-tabs align-items-end" id="myTab" role="tablist">
								  <li class="nav-item" role="presentation">
									<button class="nav-link active" id="create-tab" data-bs-toggle="tab" data-bs-target="#create-tab-pane" type="button" role="tab" aria-controls="create-tab-pane" aria-selected="true">Today Inspections <span class="badge badge-circle badge-light badge-primary light ms-2"><?= $rowReview['total_today']; ?></span></button>
								  </li>
								  <li class="nav-item" role="presentation">
									<button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs-tab-pane" type="button" role="tab" aria-controls="jobs-tab-pane" aria-selected="false">All Inspections<span class="badge badge-circle badge-light badge-primary light ms-2"><?= $rowHistory['total_history']; ?></span></button>
								  </li>								  
								</ul>
							</div>
						</div>
						<div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">


                                <div class="row">                                
                                    <div class="col-xxl-9 col-xl-8">
                                        <div class="card">
                                            <div class="card-header py-3 d-block d-sm-flex">
                                                <h4 class="heading mb-0">Jan 23, 2024</h4>
                                                <ul class="nav nav-pills mt-3 mt-sm-0 mix-profile-tab" id="myTab" role="tablist">
                                                    <li class="nav-item ms-1" role="presentation">
                                                        <button class="nav-link active" id="week-tab3" data-bs-toggle="tab" data-bs-target="#tabWeek3" type="button" role="tab" aria-selected="true">To be Review</button>
                                                    </li>
                                                    <li class="nav-item ms-1" role="presentation">
                                                        <button class="nav-link" id="month-tab3" data-bs-toggle="tab" data-bs-target="#tabMonth3" type="button" role="tab" aria-selected="false" tabindex="-1">Reviewes</button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="tabWeek3" role="tabpanel" aria-labelledby="week-tab3" tabindex="0">
                                                        <div class="widget-timeline-icons pb-3">
                                                            <ul class="timeline">
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">StumbleUpon is acquired by eBay.</span>
                                                                            <span class="fs-14 d-block">3:30 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                                                    <h6 class="fs-15 mb-0">Meeting with customer</h6>
                                                                                </div>
                                                                                <div class="col-xl-1 ms-auto col-sm-3 col-6">
                                                                                    <span class="badge badge-sm badge-light border-0">UI Design</span>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-sm-3 col-6">
                                                                                    <div class="avatar-list avatar-list-stacked ms-3">
                                                                                        <img src="images/avatar/3.jpg" alt="" class="avatar avatar-sm rounded-circle">
                                                                                        <img src="images/avatar/4.jpg" alt="" class="avatar avatar-sm rounded-circle">
                                                                                        <div class="avatar avatar-sm bg-blue text-white rounded-circle d-inline-flex align-items-center justify-content-center">S</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-1 col-sm-3 col-6 mt-2 mt-sm-0">
                                                                                    <span class="badge badge-sm badge-info light border-0">In Progress</span>
                                                                                </div>
                                                                                <div class="col-xxl-1 col-xl-2 col-sm-3 col-6 text-end mt-2 mt-sm-0">
                                                                                    <a href="javascript:void(0);" class="btn btn-xxs btn-light text-black">View</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                                                    <h6 class="fs-15 mb-0">User Module Testing</h6>
                                                                                </div>
                                                                                <div class="col-xl-1 ms-auto col-sm-3 col-6">
                                                                                    <span class="badge badge-sm badge-light border-0">Phase 2.6 QA</span>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-sm-3 col-6">
                                                                                    <div class="avatar-list avatar-list-stacked ms-3">
                                                                                        <div class="avatar avatar-sm bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center">A</div>
                                                                                        <div class="avatar avatar-sm bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center">R</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-1 col-sm-3 col-6 mt-2 mt-sm-0">
                                                                                    <span class="badge badge-sm badge-success light border-0">Completed</span>
                                                                                </div>
                                                                                <div class="col-xxl-1 col-xl-2 col-sm-3 col-6 text-end mt-2 mt-sm-0">
                                                                                    <a href="javascript:void(0);" class="btn btn-xxs btn-light text-black">View</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-user"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">Mashable, a news website and blog, goes live</span>
                                                                            <span class="fs-14 d-block">04:12 PM by <span class="text-primary">Jackson</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-link"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">05 New Project Files Uploaded</span>
                                                                            <span class="fs-14 d-block">12:25 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row g-3">
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/pdf.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">Airplus Guideline</h6>
                                                                                            <span class="fs-13">1.5MB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/csv.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">FureStibe requirements</h6>
                                                                                            <span class="fs-13">9KB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/css.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">FureStibe styles</h6>
                                                                                            <span class="fs-13">52KB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-file-alt"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-image"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">3 Dashboard concepts uploaded</span>
                                                                            <span class="fs-14 d-block">1:56 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row g-3">
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen1.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen2.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen3.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Fold Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-credit-card"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">You have received your monthly Affiliate Fee</span>
                                                                            <span class="fs-14 d-block">2:08 PM by <span class="text-primary">DexignZone Team</span></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-8">
                                                                                <div class="alert alert-primary border-primary outline-dashed py-3 px-4 d-flex align-items-center mb-0 mt-3">
                                                                                    <i class="fa-solid fa-building-columns text-primary fs-30 align-self-start"></i>
                                                                                    <div class="mx-3">
                                                                                        <h6 class="fw-semibold mb-1">Withdraw Your Funds to Bank</h6>
                                                                                        <p class="fs-14 mb-0 text-black">Securely withdraw money to your bank account, with a $25 fee.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tabMonth3" role="tabpanel" aria-labelledby="month-tab3" tabindex="0">
                                                        <div class="widget-timeline-icons pb-3">
                                                            <ul class="timeline">
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">StumbleUpon is acquired by eBay.</span>
                                                                            <span class="fs-14 d-block">3:30 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                                                    <h6 class="fs-15 mb-0">Meeting with customer</h6>
                                                                                </div>
                                                                                <div class="col-xl-1 ms-auto col-sm-3 col-6">
                                                                                    <span class="badge badge-sm badge-light border-0">UI Design</span>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-sm-3 col-6">
                                                                                    <div class="avatar-list avatar-list-stacked ms-3">
                                                                                        <img src="images/avatar/3.jpg" alt="" class="avatar avatar-sm rounded-circle">
                                                                                        <img src="images/avatar/4.jpg" alt="" class="avatar avatar-sm rounded-circle">
                                                                                        <div class="avatar avatar-sm bg-blue text-white rounded-circle d-inline-flex align-items-center justify-content-center">S</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-1 col-sm-3 col-6 mt-2 mt-sm-0">
                                                                                    <span class="badge badge-sm badge-info light border-0">In Progress</span>
                                                                                </div>
                                                                                <div class="col-xxl-1 col-xl-2 col-sm-3 col-6 text-end mt-2 mt-sm-0">
                                                                                    <a href="javascript:void(0);" class="btn btn-xxs btn-light text-black">View</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                                                    <h6 class="fs-15 mb-0">User Module Testing</h6>
                                                                                </div>
                                                                                <div class="col-xl-1 ms-auto col-sm-3 col-6">
                                                                                    <span class="badge badge-sm badge-light border-0">Phase 2.6 QA</span>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-sm-3 col-6">
                                                                                    <div class="avatar-list avatar-list-stacked ms-3">
                                                                                        <div class="avatar avatar-sm bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center">A</div>
                                                                                        <div class="avatar avatar-sm bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center">R</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-1 col-sm-3 col-6 mt-2 mt-sm-0">
                                                                                    <span class="badge badge-sm badge-success light border-0">Completed</span>
                                                                                </div>
                                                                                <div class="col-xxl-1 col-xl-2 col-sm-3 col-6 text-end mt-2 mt-sm-0">
                                                                                    <a href="javascript:void(0);" class="btn btn-xxs btn-light text-black">View</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-user"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">Mashable, a news website and blog, goes live</span>
                                                                            <span class="fs-14 d-block">04:12 PM by <span class="text-primary">Jackson</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-file-alt"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Fold Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-credit-card"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">You have received your monthly Affiliate Fee</span>
                                                                            <span class="fs-14 d-block">2:08 PM by <span class="text-primary">DexignZone Team</span></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-8">
                                                                                <div class="alert alert-primary border-primary outline-dashed py-3 px-4 d-flex align-items-center mb-0 mt-3">
                                                                                    <i class="fa-solid fa-building-columns text-primary fs-30 align-self-start"></i>
                                                                                    <div class="mx-3">
                                                                                        <h6 class="fw-semibold mb-1">Withdraw Your Funds to Bank</h6>
                                                                                        <p class="fs-14 mb-0 text-black">Securely withdraw money to your bank account, with a $25 fee.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tabYear3" role="tabpanel" aria-labelledby="year-tab3" tabindex="0">
                                                        <div class="widget-timeline-icons pb-3">
                                                            <ul class="timeline">
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">StumbleUpon is acquired by eBay.</span>
                                                                            <span class="fs-14 d-block">3:30 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                                                    <h6 class="fs-15 mb-0">Meeting with customer</h6>
                                                                                </div>
                                                                                <div class="col-xl-1 ms-auto col-sm-3 col-6">
                                                                                    <span class="badge badge-sm badge-light border-0">UI Design</span>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-sm-3 col-6">
                                                                                    <div class="avatar-list avatar-list-stacked ms-3">
                                                                                        <img src="images/avatar/3.jpg" alt="" class="avatar avatar-sm rounded-circle">
                                                                                        <img src="images/avatar/4.jpg" alt="" class="avatar avatar-sm rounded-circle">
                                                                                        <div class="avatar avatar-sm bg-blue text-white rounded-circle d-inline-flex align-items-center justify-content-center">S</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-1 col-sm-3 col-6 mt-2 mt-sm-0">
                                                                                    <span class="badge badge-sm badge-info light border-0">In Progress</span>
                                                                                </div>
                                                                                <div class="col-xxl-1 col-xl-2 col-sm-3 col-6 text-end mt-2 mt-sm-0">
                                                                                    <a href="javascript:void(0);" class="btn btn-xxs btn-light text-black">View</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                                                    <h6 class="fs-15 mb-0">User Module Testing</h6>
                                                                                </div>
                                                                                <div class="col-xl-1 ms-auto col-sm-3 col-6">
                                                                                    <span class="badge badge-sm badge-light border-0">Phase 2.6 QA</span>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-sm-3 col-6">
                                                                                    <div class="avatar-list avatar-list-stacked ms-3">
                                                                                        <div class="avatar avatar-sm bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center">A</div>
                                                                                        <div class="avatar avatar-sm bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center">R</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-1 col-sm-3 col-6 mt-2 mt-sm-0">
                                                                                    <span class="badge badge-sm badge-success light border-0">Completed</span>
                                                                                </div>
                                                                                <div class="col-xxl-1 col-xl-2 col-sm-3 col-6 text-end mt-2 mt-sm-0">
                                                                                    <a href="javascript:void(0);" class="btn btn-xxs btn-light text-black">View</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-user"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">Mashable, a news website and blog, goes live</span>
                                                                            <span class="fs-14 d-block">04:12 PM by <span class="text-primary">Jackson</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-link"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">05 New Project Files Uploaded</span>
                                                                            <span class="fs-14 d-block">12:25 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row g-3">
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/pdf.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">Airplus Guideline</h6>
                                                                                            <span class="fs-13">1.5MB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/csv.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">FureStibe requirements</h6>
                                                                                            <span class="fs-13">9KB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/css.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">FureStibe styles</h6>
                                                                                            <span class="fs-13">52KB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-file-alt"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-image"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">3 Dashboard concepts uploaded</span>
                                                                            <span class="fs-14 d-block">1:56 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row g-3">
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen1.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen2.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen3.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Fold Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-credit-card"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">You have received your monthly Affiliate Fee</span>
                                                                            <span class="fs-14 d-block">2:08 PM by <span class="text-primary">DexignZone Team</span></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-8">
                                                                                <div class="alert alert-primary border-primary outline-dashed py-3 px-4 d-flex align-items-center mb-0 mt-3">
                                                                                    <i class="fa-solid fa-building-columns text-primary fs-30 align-self-start"></i>
                                                                                    <div class="mx-3">
                                                                                        <h6 class="fw-semibold mb-1">Withdraw Your Funds to Bank</h6>
                                                                                        <p class="fs-14 mb-0 text-black">Securely withdraw money to your bank account, with a $25 fee.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-image"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">3 Dashboard concepts uploaded</span>
                                                                            <span class="fs-14 d-block">1:56 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row g-3">
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen1.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen2.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen3.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Fold Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-credit-card"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">You have received your monthly Affiliate Fee</span>
                                                                            <span class="fs-14 d-block">2:08 PM by <span class="text-primary">DexignZone Team</span></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-8">
                                                                                <div class="alert alert-primary border-primary outline-dashed py-3 px-4 d-flex align-items-center mb-0 mt-3">
                                                                                    <i class="fa-solid fa-building-columns text-primary fs-30 align-self-start"></i>
                                                                                    <div class="mx-3">
                                                                                        <h6 class="fw-semibold mb-1">Withdraw Your Funds to Bank</h6>
                                                                                        <p class="fs-14 mb-0 text-black">Securely withdraw money to your bank account, with a $25 fee.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane fade" id="tabAll3" role="tabpanel" aria-labelledby="all-tab3" tabindex="0">
                                                        <div class="widget-timeline-icons pb-3">
                                                            <ul class="timeline">
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">StumbleUpon is acquired by eBay.</span>
                                                                            <span class="fs-14 d-block">3:30 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                                                    <h6 class="fs-15 mb-0">Meeting with customer</h6>
                                                                                </div>
                                                                                <div class="col-xl-1 ms-auto col-sm-3 col-6">
                                                                                    <span class="badge badge-sm badge-light border-0">UI Design</span>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-sm-3 col-6">
                                                                                    <div class="avatar-list avatar-list-stacked ms-3">
                                                                                        <img src="images/avatar/3.jpg" alt="" class="avatar avatar-sm rounded-circle">
                                                                                        <img src="images/avatar/4.jpg" alt="" class="avatar avatar-sm rounded-circle">
                                                                                        <div class="avatar avatar-sm bg-blue text-white rounded-circle d-inline-flex align-items-center justify-content-center">S</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-1 col-sm-3 col-6 mt-2 mt-sm-0">
                                                                                    <span class="badge badge-sm badge-info light border-0">In Progress</span>
                                                                                </div>
                                                                                <div class="col-xxl-1 col-xl-2 col-sm-3 col-6 text-end mt-2 mt-sm-0">
                                                                                    <a href="javascript:void(0);" class="btn btn-xxs btn-light text-black">View</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row align-items-center">
                                                                                <div class="col-xxl-6 col-xl-5 col-lg-12 mb-3 mb-xl-0">
                                                                                    <h6 class="fs-15 mb-0">User Module Testing</h6>
                                                                                </div>
                                                                                <div class="col-xl-1 ms-auto col-sm-3 col-6">
                                                                                    <span class="badge badge-sm badge-light border-0">Phase 2.6 QA</span>
                                                                                </div>
                                                                                <div class="col-xxl-2 col-sm-3 col-6">
                                                                                    <div class="avatar-list avatar-list-stacked ms-3">
                                                                                        <div class="avatar avatar-sm bg-warning text-white rounded-circle d-inline-flex align-items-center justify-content-center">A</div>
                                                                                        <div class="avatar avatar-sm bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center">R</div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-xl-1 col-sm-3 col-6 mt-2 mt-sm-0">
                                                                                    <span class="badge badge-sm badge-success light border-0">Completed</span>
                                                                                </div>
                                                                                <div class="col-xxl-1 col-xl-2 col-sm-3 col-6 text-end mt-2 mt-sm-0">
                                                                                    <a href="javascript:void(0);" class="btn btn-xxs btn-light text-black">View</a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-user"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">Mashable, a news website and blog, goes live</span>
                                                                            <span class="fs-14 d-block">04:12 PM by <span class="text-primary">Jackson</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-link"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">05 New Project Files Uploaded</span>
                                                                            <span class="fs-14 d-block">12:25 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row g-3">
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/pdf.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">Airplus Guideline</h6>
                                                                                            <span class="fs-13">1.5MB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/csv.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">FureStibe requirements</h6>
                                                                                            <span class="fs-13">9KB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-lg-3 col-sm-6">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div class="me-3">
                                                                                            <img src="images/files/css.png" width="35" alt="">
                                                                                        </div>
                                                                                        <div class="clearfix">
                                                                                            <h6 class="mb-0">FureStibe styles</h6>
                                                                                            <span class="fs-13">52KB</span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-file-alt"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-image"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">3 Dashboard concepts uploaded</span>
                                                                            <span class="fs-14 d-block">1:56 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row g-3">
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen1.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen2.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen3.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Fold Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-credit-card"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">You have received your monthly Affiliate Fee</span>
                                                                            <span class="fs-14 d-block">2:08 PM by <span class="text-primary">DexignZone Team</span></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-8">
                                                                                <div class="alert alert-primary border-primary outline-dashed py-3 px-4 d-flex align-items-center mb-0 mt-3">
                                                                                    <i class="fa-solid fa-building-columns text-primary fs-30 align-self-start"></i>
                                                                                    <div class="mx-3">
                                                                                        <h6 class="fw-semibold mb-1">Withdraw Your Funds to Bank</h6>
                                                                                        <p class="fs-14 mb-0 text-black">Securely withdraw money to your bank account, with a $25 fee.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-image"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">3 Dashboard concepts uploaded</span>
                                                                            <span class="fs-14 d-block">1:56 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="row g-3">
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen1.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen2.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                                <div class="col-md-2 col-4">
                                                                                    <img src="images/blog/screen3.jpg" alt="" class="w-100 rounded">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><strong>Hughes</strong> Fold Created & assigned a new task <a href="javascript:void(0);" class="text-primary">Design Multistep Registraion Form</a> to you </span>
                                                                            <span class="fs-14 d-block">11:02 PM by <span class="text-primary">Hughes</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-credit-card"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">You have received your monthly Affiliate Fee</span>
                                                                            <span class="fs-14 d-block">2:08 PM by <span class="text-primary">DexignZone Team</span></span>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-lg-8">
                                                                                <div class="alert alert-primary border-primary outline-dashed py-3 px-4 d-flex align-items-center mb-0 mt-3">
                                                                                    <i class="fa-solid fa-building-columns text-primary fs-30 align-self-start"></i>
                                                                                    <div class="mx-3">
                                                                                        <h6 class="fw-semibold mb-1">Withdraw Your Funds to Bank</h6>
                                                                                        <p class="fs-14 mb-0 text-black">Securely withdraw money to your bank account, with a $25 fee.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-3 col-xl-4">
                                        <div class="row sticky-top sticky-top-80 z-0">
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title mb-0">Activity</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        
                                                    <div class="widget-timeline-icons pb-3">
                                                            <ul class="timeline">
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold">StumbleUpon is acquired by eBay.</span>
                                                                            <span class="fs-14 d-block">3:30 PM by <span class="text-primary">You</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-book-open"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="fs-14 fw-semibold"><a href="javascript:void(0);" class="text-primary fw-medium">jQuery.js</a> was merged into <strong>Google</strong> Task task</span>
                                                                            <span class="fs-14 d-block">12:38 PM by <span class="text-primary">Jogn Walles</span></span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>








                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card overflow-hidden h-auto">	
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="table-responsive">
                                                        <table id="inspectionPendingList" class="display table mb-1 table-striped-thead table-wide table-md">
                                                            <thead class="thead-black">
                                                                <tr>
                                                                    <th>Doc No</th>
                                                                    <th>Part No</th>
                                                                    <th>Pallet Sequence</th>
                                                                    <th>Result</th>
                                                                    <th>Shift</th>
                                                                    <th class="nosort">Action</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="jobs-tab-pane" role="tabpanel" aria-labelledby="jobs-tab" tabindex="0">
                                <div class="card h-auto overflow-hidden">
                                    <div class="card-body p-0">
                                        <div class="table-responsive active-projects style-1">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                            
						</div>                         
                    </div>

                    <!-- Modal View-->
                    <div class="modal fade custom-modal-md" id="detailModal">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">                               
                                <div class="modal-body" id="detailModalBody">
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-dark light" data-bs-dismiss="modal">Close</button>
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
                    
                    <!-- Approval Modal -->
                    <div class="modal fade" id="approveModal" tabindex="-1" aria-labelledby="approveModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <form id="approveForm">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="approveModalLabel"></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="ir_id" id="approve_ir_id">
                                    <div class="mb-3">
                                        <label for="approval_remark" class="form-label">Comment/ Reason <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="remark" id="approval_remark" rows="4"></textarea>
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
                                <div class="modal-header bg-primary text-white">
                                    <h5 class="modal-title" id="returnModalLabel"></h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <div class="modal-body">
                                    <input type="hidden" name="ir_id" id="return_ir_id">
                                    <div class="mb-3">
                                        <label for="return_remark" class="form-label">Comment/ Reason <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="remark" id="return_remark" rows="4"></textarea>
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
		$('#inspectionPendingList').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

	<script>

    let table;
    $(document).ready(function() {

        table = $('#inspectionPendingList').DataTable({
            processing: true,
            serverSide: true,
            order: [[2, 'desc']],
			lengthChange: false,
            language: {
                paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
            },
            "ajax": {
                url: 'fetch-inspection-rcd-action.php',
                method:"POST",
                data: {
                    action : 'fetch_records'}
            },
            columnDefs: [// hide the inspect_group column
                { targets: 'nosort', orderable: false }
            ],
        }); 
		 
    });

    </script>

    <script>

    $(document).on('click', '.viewDocDetails', function() {

        let docno = $(this).data('docno');

        $.ajax({

            url: 'fetch-inspection-rcd-action.php',
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
        $('#zoomedImage').attr('src', src);
        const zoomModal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        zoomModal.show();
    });

    </script>

    <script>

    // Approve
    $(document).on('click', '.btnApprove', function () {

        const ir_id = $(this).data('irid');

        $('#approve_ir_id').val(ir_id);
        $('#approval_remark').val('');

        //Clear previous error border
        $('#approval_remark').removeClass('border-error');

        const modal = new bootstrap.Modal(document.getElementById('approveModal'));
        modal.show();
    });

    // Remove border when user fixes the input
    $('#approval_remark').on('change', function() {
        // $(this).removeClass('border-error');
       $('#approval_remark').removeClass('border-error');
    }); 

    // 2. Handle form submit
    $('#approveForm').on('submit', function (e) {
        e.preventDefault();

        const ir_id = $('#approve_ir_id').val();
        const remark = $('#approval_remark').val().trim();

        if (!remark) {
            alert('Please state the comment or reason.');
            $('#approval_remark').addClass('border-error');
            return;
        } else {
            $('#approval_remark').removeClass('border-error');
        }

        //Confirmation prompt before approving
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to approve this inspection?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, approve it'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with approval
                const $btn = $('#btnConfirmApprove');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Approving...');

                $.ajax({
                    url: 'fetch-inspection-rcd-action.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'approve_inspection',
                        ir_id: ir_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        $btn.prop('disabled', false).html('<i class="fa fa-check"></i> Approve');
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Approved',
                                text: 'Inspection approved successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            });

                            $('#approveModal').modal('hide');

                            //Reload table
                            $('#inspectionPendingList').DataTable().ajax.reload(null, false); 

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
                    url: 'fetch-inspection-rcd-action.php',
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

                            //Reload table
                            $('#inspectionPendingList').DataTable().ajax.reload(null, false); 

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