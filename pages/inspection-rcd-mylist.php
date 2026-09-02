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
                        <?=$side_menu4;?>
                    </div>
                </div>
                <div class="row">
					<div class="col-xl-12">
                        <div class="card">
							<div class="card-header border-0 pb-0 flex-wrap">
								<!-- <h4 class="heading mb-0">Literary success</h4> -->
							</div>
							<div class="card-body">
								<div class="row">
                                    <div class="col-xl-3 col-sm-6 mb-2">
                                         <label class="form-label">Inspection Date Range</label>
                                            <input class="form-control input-daterange-datepicker" type="text" name="daterange_src" id="daterange_insp" value="<?=$startDate;?> - <?=$endDate;?>">
                                    </div>                                   
                                    <div class="col-xl-3 col-sm-6 align-self-end mb-2">
                                        <!-- Hidden row id -->
                                        <input type="hidden" id="hidden_shift" value="<?=$current_shift;?>"/>
                                        <input type="hidden" id="hidden_shift_date" value="<?= $shift_date ?>">

                                        <div>
                                            <button class="btn btn-rounded btn-black text-white  me-2" title="Click here to Search" type="button" id="btnFilter">Search</button>
                                        </div>
                                    </div>
                                </div>								
							</div>
						</div>						
					</div>

                    <?php

                    $today = date('Y-m-d');
                    $sql = "SELECT ir_id, part_no, created_at, status, inspector_name
                            FROM inspection_record
                            WHERE DATE(created_at) = CURDATE()
                            ORDER BY created_at DESC";

                    $result = $db_con->query($sql);

                    ?>

                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">My Inspections</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">

                                    <?php while($row = $result->fetch_assoc()): ?>
                                    <div class="col-xl-3 col-sm-6">
                                        <a href="profile/projects-details.html" class="card">
                                            <div class="card-body">
                                                <div class="clearfix d-flex">
                                                    <div class="avatar avatar-md style-1 rounded bg-light d-flex align-items-center justify-content-center me-3">
                                                        <img src="images/logo/figma.png" class="m-0" alt="">
                                                    </div>
                                                    <div class="clearfix">
                                                        <h6 class="mb-0 fw-semibold">Figma Design</h6>
                                                        <span class="text-muted fs-13">There are many variations</span>	
                                                    </div>	
                                                </div>
                                                <p class="my-3">Lorem Ipsum is simply dummy text of the printing and typesetting industry.</p>
                                                <div class="clearfix">
                                                    <p class="text-black mb-1 font-w500">Team</p>
                                                    <div class="avatar-list avatar-list-stacked">
                                                        <img src="images/avatar/avatar8.jpg" class="avatar rounded-circle" alt="">
                                                        <img src="images/avatar/avatar6.jpg" class="avatar rounded-circle" alt="">
                                                        <img src="images/avatar/avatar4.jpg" class="avatar rounded-circle" alt="">
                                                        <img src="images/avatar/avatar2.jpg" class="avatar rounded-circle" alt="">
                                                    </div>
                                                </div>
                                                <div class="mt-3">
                                                    <div class="d-flex justify-content-between">
                                                        <span class="fw-medium text-black">Project Complete</span>
                                                        <span class="">60%</span>
                                                    </div>
                                                    <div class="progress mt-2">
                                                        <div class="progress-bar bg-purple" style="width:60%; height:5px; border-radius:4px;" role="progressbar"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer d-flex justify-content-between flex-wrap">
                                                <div class="due-progress mb-0">
                                                    <p class="mb-0 text-black">Due <span class="text-purple">: 2024-06-02</span></p>
                                                </div>
                                                <span class="badge badge-sm badge-primary light border-0">In Progress</span>
                                            </div>
                                        </a>
                                    </div> 
                                    <?php } ?>                                   
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

    let table;
    $(document).ready(function() {

        table = $('#inspectionGroupsTable').DataTable({
            processing: true,
            serverSide: true,
            order: [[2, 'desc']],
            language: {
                paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
            },
            "ajax": {
                url: 'fetch-inspection-rcd-all.php',
                method:"POST",
                data: {
                    action : 'fetch_records'}
            },
            columnDefs: [
                { targets: [6], visible: false }, // hide the inspect_group column
                { targets: 'nosort', orderable: false }
            ],
        });  

    });

    </script>

    <script>

    $(document).on('click', '.viewPallet', function () {
        const inspectGroup = $(this).data('inspect-group');
        if (inspectGroup) {
            window.location.href = 'inspection-rcd-pallet-list.php?egp=' + inspectGroup;
        }
    });

    </script>


</body>
</html>