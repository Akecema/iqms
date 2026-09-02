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
        /* Status Tracking Styles */
        #status-tracking {
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            margin-bottom: 25px;
        }

        .status-bar-container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: relative;
            margin: 40px 0 20px;
            padding: 0 50px;
        }

        .status-bar-line {
            position: absolute;
            top: 25px;
            left: 100px;
            right: 100px;
            height: 4px;
            background: #e0e6ed;
            z-index: 1;
        }

        .status-step {
            position: relative;
            z-index: 3;
            text-align: center;
            flex: 1;
        }

        .status-icon-wrapper {
            width: 50px;
            height: 50px;
            background: #fff;
            border: 3px solid #e0e6ed;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            transition: all 0.3s ease;
            font-size: 20px;
            color: #888;
        }

        .status-step.active .status-icon-wrapper {
            border-color: #205128;
            color: #205128;
            background: #e8f5e9;
            box-shadow: 0 0 10px rgba(32, 81, 40, 0.2);
        }

        .status-step .status-count {
            display: block;
            font-size: 1.25rem;
            font-weight: 700;
            color: #205128;
            margin-top: 5px;
        }

        .status-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* Fix DataTable pagination layout */
        .dataTables_wrapper .dataTables_paginate {
            float: right;
            text-align: right;
            padding-top: 0.25em;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            display: inline-block;
            padding: 0.5em 1em;
            margin-left: 2px;
            text-align: center;
            text-decoration: none !important;
            cursor: pointer;
            color: #333 !important;
            border: 1px solid transparent;
            border-radius: 2px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            color: #fff !important;
            background: #000;
            border: 1px solid #000;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            color: #fff !important;
            background: #585858;
            border: 1px solid #585858;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:active {
            cursor: default;
            color: #666 !important;
            background: transparent;
            border: 1px solid transparent;
        }
        
        .dataTables_wrapper .dataTables_info {
            clear: both;
            float: left;
            padding-top: 0.755em;
        }
        
        .dataTables_wrapper .dataTables_length {
            float: left;
        }
        
        .dataTables_wrapper .dataTables_filter {
            float: right;
            text-align: right;
        }

                                
        /* Soft color badges for icons */
        .bg-primary-soft { background-color: rgba(13, 110, 253, 0.1); }
        .bg-warning-soft { background-color: rgba(255, 193, 7, 0.1); }
        .bg-success-soft { background-color: rgba(25, 135, 84, 0.1); }
        .bg-danger-soft { background-color: rgba(220, 53, 69, 0.1); }
        .bg-secondary-soft { background-color: rgba(108, 117, 125, 0.1); }
        .status-item { 
            font-size: 13px; 
            color : #202020ff;
        }

        .text-muted
        {
            color : #353434ff !important
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
                        <?=$side_menu_report;?> <?=$side_menu_report4; ?>
                    </div>                    
                </div>

                <?php
                $today = date('Y-m-d');

                // Single query to get all status counts for the current shift date
                // We'll calculate both the overall status tracking and the specific result counts (OK/NG) for completed items
                $queryCounts = "SELECT 
                                    COUNT(*) as total,
                                    SUM(CASE WHEN s2w_status IN (1,13) THEN 1 ELSE 0 END) as pending_draft,
                                    SUM(CASE WHEN s2w_status = 9 THEN 1 ELSE 0 END) as pending_review,
                                    SUM(CASE WHEN s2w_status = 11 THEN 1 ELSE 0 END) as reviewed,
                                    SUM(CASE WHEN s2w_status = 5 THEN 1 ELSE 0 END) as completed,
                                    SUM(CASE WHEN s2w_status IN (12, 16) THEN 1 ELSE 0 END) as returned,
                                    SUM(CASE WHEN s2w_status = 8 THEN 1 ELSE 0 END) as cancelled,
                                    SUM(CASE WHEN s2w_status = 5 THEN 1 ELSE 0 END) as completed_today
                                FROM inspection_s2w ";
                if ($session_role == 4) {
                    $queryCounts .= " AND created_by = '$session_id'";
                }

                $resCounts = mysqli_query($db_con, $queryCounts);
                $data = mysqli_fetch_assoc($resCounts);

                // For Status Tracking Bar (All shifts today)
                $totalCount           = $data['total'] ?? 0;
                $pendingDraftCount   = $data['pending_draft'] ?? 0;
                $pendingReviewCount   = $data['pending_review'] ?? 0;
                $pendingReviewedCount = $data['reviewed'] ?? 0;
                $completedCount       = $data['completed'] ?? 0;
                $returnedCount        = $data['returned'] ?? 0; 
                $cancelledCount       = $data['cancelled'] ?? 0;

                // For KPI Cards (Current shift specifically)
                $total_completed = $data['completed_today'] ?? 0;
                $total_ok        = $data['ok_today'] ?? 0;
                $total_ng        = $data['ng_today'] ?? 0;

                ?>
                
                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                        <div class="row">                    
                            <div class="col-12">
                                
                                <!-- Status Tracking -->
                                <div class="col-xl-12" id="status-tracking">
                                    <div class="card mb-4" style="border-radius: 10px; border: 1px solid #eef0f2; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                                        <div class="card-body py-3">
                                            <div class="d-flex align-items-center flex-wrap justify-content-between">
                                                <div class="status-group d-flex align-items-center">
                                                    <div class="status-item me-4">
                                                        <!-- <span class="badge bg-primary-soft me-2"><i class="fas fa-check-square text-primary"></i></span> -->
                                                        <span class="text-muted small">Total :</span> 
                                                        <span class="ms-1 fw-bold text-white badge badge-circle badge-oyen"><?= number_format($totalCount) ?></span>
                                                    </div>

                                                    <div class="vr me-4 opacity-25" style="height: 20px;"></div>

                                                    <div class="status-item me-4">
                                                        <!-- <span class="badge bg-warning-soft me-2"><i class="fas fa-square text-warning"></i></span> -->
                                                        <span class="text-muted small">New :</span> 
                                                        <span class="ms-1 fw-bold text-dark badge badge-circle badge-dark"><?= number_format($pendingDraftCount) ?></span>
                                                    </div> 
                                                    
                                                    <div class="vr me-4 opacity-25" style="height: 20px;"></div>

                                                    <div class="status-item me-4">
                                                        <!-- <span class="badge bg-warning-soft me-2"><i class="fas fa-square text-warning"></i></span> -->
                                                        <span class="text-muted small">Pending Review :</span> 
                                                        <span class="ms-1 fw-bold text-dark badge badge-circle badge-dark"><?= number_format($pendingReviewCount) ?></span>
                                                    </div>

                                                    <div class="vr me-4 opacity-25" style="height: 20px;"></div>

                                                    <div class="status-item me-4">
                                                        <!-- <span class="badge bg-warning-soft me-2"><i class="fas fa-square text-warning"></i></span> -->
                                                        <span class="text-muted small">Reviewed :</span> 
                                                        <span class="ms-1 fw-bold text-dark badge badge-circle badge-dark"><?= number_format($pendingReviewedCount) ?></span>
                                                    </div>

                                                    <div class="vr me-4 opacity-25" style="height: 20px;"></div>

                                                    <div class="status-item me-4">
                                                        <!-- <span class="badge bg-success-soft me-2"><i class="fas fa-check-square text-success"></i></span> -->
                                                        <span class="text-muted small">Completed :</span> 
                                                        <span class="ms-1 fw-bold text-dark badge badge-circle badge-dark"><?= number_format($completedCount) ?></span>
                                                    </div>

                                                    <div class="vr me-4 opacity-25" style="height: 20px;"></div>

                                                    <div class="status-item me-4">
                                                        <!-- <span class="badge bg-danger-soft me-2"><i class="fas fa-dot-circle text-danger"></i></span> -->
                                                        <span class="text-muted small">Returned :</span> 
                                                        <span class="ms-1 fw-bold text-dark badge badge-circle badge-dark"><?= number_format($returnedCount) ?></span>
                                                    </div>

                                                    <div class="vr me-4 opacity-25" style="height: 20px;"></div>

                                                    <div class="status-item me-4">
                                                        <!-- <span class="badge bg-secondary-soft me-2"><i class="fas fa-minus-square text-secondary"></i></span> -->
                                                        <span class="text-muted small">Cancelled :</span> 
                                                        <span class="ms-1 fw-bold text-dark badge badge-circle badge-dark"><?= number_format($cancelledCount) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- end Status Tracking -->

                                <!-- Filter -->
                                <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header accordion-header-primary" id="headingOne6">                                        
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6">
                                                <span><i class="fa fa-filter me-2"></i> Filter</span>
                                            </button>
                                        </h2>
                                    </div>

                                    <div id="collapseOne6" class="accordion__body collapse" aria-labelledby="accord-6One" data-bs-parent="#accordion-six">
                                        <div class="accordion-body-text p-0">
                                            <div class="card h-auto">
                                                <div class="card-body">
                                                    <div class="row g-3">
                                                            <!-- Row 1 -->                                                             
                                                            <div class="col-md-4 mb-2">                                            
                                                                <label class="form-label">Part No</label>
                                                                <div id="div_material">
                                                                    <select class="form-control filter-select cs_material" name="fd_material" id="fd_material">
                                                                        <option value="">Select Part No</option>                                                    
                                                                    </select>
                                                                </div>
                                                            </div>
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
                                                            
                                                            <div class="col-md-3 mb-2">                                           
                                                                <label class="form-label">Shift</label>
                                                                <select class="form-control filter-select cs_shift" name="fd_shift" id="fd_shift" >
                                                                    <option value="">Select Shift</option>
                                                                    <option value="D">Day</option>
                                                                    <option value="N">Night</option>
                                                                </select>
                                                            </div>

                                                            <div class="col-md-3 mb-2">                                            
                                                                <label class="form-label">Inspection Date Range</label>
                                                                <input class="form-control" type="text" name="daterange" id="daterange_inspect" value="" placeholder="DD/MM/YYYY - DD/MM/YYYY">
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
                                    </div>

                                    <style>
                                        .btn-outline-custom {
                                            background: #fff;
                                            border: 1px solid #d1d3e2;
                                            color: #3f4340ff;
                                            padding: 5px 12px;
                                            font-size: 12px;
                                            font-weight: 500;
                                            border-radius: 4px;
                                            display: inline-flex;
                                            align-items: center;
                                            gap: 6px;
                                            text-decoration: none;
                                            transition: all 0.2s;
                                        }
                                        .btn-outline-custom:hover {
                                            background: #f8f9fc;
                                            border-color: #b7b9cc;
                                            color: #1c1d1cff;
                                        }
                                        .btn-outline-custom i {
                                            font-size: 12px;
                                            color: #858796;
                                        }
                                    </style>

                                    <div class="post-input d-flex gap-2 justify-content-end">                                                            
                                        <a href="view-s2w-report-all.php" id="btnViewAll" target="_blank" class="btn-outline-custom">
                                            <i class="fa fa-file-text text-black"></i> View
                                        </a>
                                        <a href="export-s2w-report-all.php" id="btnExportExcel" class="btn-outline-custom">
                                            <i class="fa fa-file-excel text-green"></i> Download Excel
                                        </a>
                                        <a href="export-s2w-report-all-pdf.php" id="btnExportPdf" target="_blank" class="btn-outline-custom">
                                            <i class="fa fa-file-pdf text-danger"></i> Download PDF
                                        </a>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table id="s2wGroupsList" class="display table mb-1 table-striped-thead table-wide table-md">                                                              
                                                            <thead class="thead-black">
                                                                <tr>
                                                                    <th>Doc No</th>
                                                                    <th>Part No</th>
                                                                    <th>Model</th>
                                                                    <th>Sending To</th>
                                                                    <th>Photos NG (Defect)</th>
                                                                    <th>Photo OK</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                        </table>
                                                    </div>
                                                    
                                                    
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
            dataType: 'json',
            success: function (data) {
                // Update KPI Cards
                $('.count-completed').text(data.completed);
                $('.count-ok').text(data.ok);
                $('.count-ng').text(data.ng);

                // Update Status Tracking Bar
                var totalAll = parseInt(data.new) + parseInt(data.pending) + parseInt(data.approved) + 
                               parseInt(data.completed) + parseInt(data.cancelled) + parseInt(data.returned);
                
                $('#status-tracking .status-total .status-count').text(totalAll);
                $('#status-tracking .status-pending .status-count').text(data.pending);
                $('#status-tracking .status-completed .status-count').text(data.completed);
                $('#status-tracking .status-rejected .status-count').text(parseInt(data.cancelled) + parseInt(data.returned));
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
    $('.filter-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });
    </script>

    <script>
    $('#daterange_inspect')
        .daterangepicker({
            autoUpdateInput: false,
            maxDate: moment(),
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            locale:{
                format:'DD/MM/YYYY',
                cancelLabel:'Clear'
            }
        })
        .on('apply.daterangepicker', function(ev, picker){
            $(this).val(
                picker.startDate.format('DD/MM/YYYY') +
                ' - ' +
                picker.endDate.format('DD/MM/YYYY')
            );
        })
        .on('cancel.daterangepicker', function(ev, picker){
            $(this).val('');
    });

    $('#daterange_inspect').val('');

    </script>

    <script>

    function updateExportLinks() {
        var params = $.param({
            fd_model: $('.cs_model').val(),
            fd_type: $('.cs_type').val(),
            fd_material: $('.cs_material').val(),
            fd_daterange: $('#daterange_inspect').val(),
            fd_shift: $('.cs_shift').val(),
            fd_result: $('#filterResult').val()
        });

        $('#btnViewAll').attr('href', 'view-s2w-report-all.php?' + params);
        $('#btnExportExcel').attr('href', 'export-s2w-report-all.php?' + params);
        $('#btnExportPdf').attr('href', 'export-s2w-report-all-pdf.php?' + params);
    }

    $('#btnFilterSearch').on('click', function() {
        table.ajax.reload();
        updateExportLinks();
    });

    $('#btnResetFilter').on('click', function() {
        $('.cs_model, .cs_type, .cs_material, .cs_shift, #filterResult').val('').trigger('change');
        $('#daterange_inspect').val('');
        $('#searchInput').val('');
        table.ajax.reload();
        updateExportLinks();
    });

    $(document).ready(function() {
        updateExportLinks();
    });

    $('#searchInput').on('keyup', function() {
        table.ajax.reload();
    });

    </script>

    <script>

    // Initialize DataTable for s2w records
    var table = $('#s2wGroupsList').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "fetch-s2w-report-list.php",
            type: "POST",
            data: function(d) {
                d.action = 'fetch_records_list_all';
                d.fd_model = $('.cs_model').val();
                d.fd_type = $('.cs_type').val();
                d.fd_material = $('.cs_material').val();                
                d.fd_daterange = $('#daterange_inspect').val();
                d.fd_shift = $('.cs_shift').val();
                d.fd_result = $('#filterResult').val();
            }
        },
        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "columns": [
            { "data": 0 }, // Doc No
            { "data": 1 }, // Material
            { "data": 2 }, // Model
            { "data": 3 }, // Sending To
            { "data": 4 }, // Photos NG (Defect)
            { "data": 5 }, // Photo OK
            { "data": 6 } // Action
        ],
        "order": [[0, 'desc']], // Default sort by doc no desc
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "language": {
            "emptyTable": "No inspection records found",
            "processing": "Loading data...",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
            },
        },
        "columnDefs": [
            {
                "targets": 'nosort',
                "orderable": false
            }
        ],
        "drawCallback": function(settings) {
            // Update OK/NG counts from server response
            var json = settings.json;
            if (json) {
                // Ensure we default to 0 if undefined
                var okCount = json.total_ok !== undefined ? json.total_ok : 0;
                var ngCount = json.total_ng !== undefined ? json.total_ng : 0;

                $('#totalOkPending span').text(okCount);
                $('#totalNgPending span').text(ngCount);
            }
            
            // Reinitialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    $(document).on('click', '.viewDetails', function() {
        let irid = $(this).data('irid');
        window.location.href = 'ip-s2w-report-view.php?erid=' + irid;
    });

    $(document).on('click', '.zoomable-img', function() {
        var src = $(this).attr('src');
        $('#previewImage').attr('src', src);
        $('#imagePreviewModal').modal('show');
    });

    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
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

</body>
</html>