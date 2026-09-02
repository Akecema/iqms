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

		#inspectionGroupsTable tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionGroupsTable thead tr th:last-child{
            text-align: left !important;
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
                    <div class="col-12">

						<?php

						$today = date('Y-m-d');

						// Get total inspections for today
						$queryToday = "SELECT COUNT(*) AS total_today 
											FROM inspection_records 
												WHERE created_by = '$session_id' AND shift_date = '$today'";
						$resultToday = mysqli_query($db_con, $queryToday);
						$rowToday = mysqli_fetch_assoc($resultToday);

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
									<button class="nav-link active" id="create-tab" data-bs-toggle="tab" data-bs-target="#create-tab-pane" type="button" role="tab" aria-controls="create-tab-pane" aria-selected="true">Today Inspections <span class="badge badge-circle badge-light badge-primary light ms-2"><?= $rowToday['total_today']; ?></span></button>
								  </li>
								  <li class="nav-item" role="presentation">
									<button class="nav-link" id="jobs-tab" data-bs-toggle="tab" data-bs-target="#jobs-tab-pane" type="button" role="tab" aria-controls="jobs-tab-pane" aria-selected="false">Inspections History <span class="badge badge-circle badge-light badge-primary light ms-2"><?= $rowHistory['total_history']; ?></span></button>
								  </li>
								  
								</ul>
							</div>
						</div>
						<div class="tab-content" id="myTabContent">
						  <div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
							<div class="row">
								<div class="col-xl-12">
									<div class="card overflow-hidden h-auto">	
										<div class="card-body">
											<div class="row">
												<div class="table-responsive">
													<table id="inspectionGroupsTable" class="display table mb-1 table-striped-thead table-wide table-md">
														<thead class="thead-black">
															<tr>
																<th>Part No</th>
																<th>Model</th>
																<th>Shift</th>
																<th class="nosort">Total Pallete Sequence</th>
																<th class="nosort"></th>
																<th class="nosort"></th>
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

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#inspectionGroupsTable').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

	<script>

    let table;
    $(document).ready(function() {

        table = $('#inspectionGroupsTable').DataTable({
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
                data: {
                    action : 'fetch_records'}
            },
            columnDefs: [
                { targets: [5], visible: false }, // hide the inspect_group column
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

<script>
  const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
  tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
</script>

</body>
</html>