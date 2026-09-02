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

        .badge-sm {
            font-size: 0.75rem;
            padding: 0.42em 0.65em;
        }

        .badge-md {
            font-size: 0.85rem;
            padding: 0.4em 0.7em;
        }

        .badge-lg {
            font-size: 1.05rem;
            padding: 0.6em 1em;
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

        .viewAvatar:hover {
            transform: scale(1.8); /* optional: subtle zoom effect on hover */
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
                <div class="row">
                    <div class="col-12">

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
									<button class="nav-link active" id="create-tab" data-bs-toggle="tab" data-bs-target="#create-tab-pane" type="button" role="tab" aria-controls="create-tab-pane" 
                                        aria-selected="true">
                                        Grouped by Material
                                        <span class="badge badge-circle badge-light badge-primary light ms-2">
                                            <?= $rowToday['total_groups']; ?>
                                        </span>
                                    </button>
								  </li>
								  <li class="nav-item" role="presentation">
									<a class="nav-link" type="button" href="inspection-rcd-pallet-list-all.php">
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
                                <div class="col-xl-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row g-3">
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
																<th>Inspection Date</th>
																<th>Shift</th>
																<th class="nosort">Total Pallet Sequence</th>
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

                                <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content bg-transparent border-0 shadow-none">
                                            <img id="previewImage" src="" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px; box-shadow:0 2px 24px #0006;">
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
                data: function (d) {
                        d.action   = 'fetch_records_group';
                        d.fd_model = $('.cs_model').val();
                        d.fd_type  = $('.cs_type').val();
                        d.fd_material = $('.cs_material').val();

                        console.log("Filters sent to server:", d);
                    }
            },
            columnDefs: [
                { targets: [6], visible: false }, // hide the inspect_group column
                { targets: 'nosort', orderable: false }
            ],
        }); 
		 
    });

    // Search button
    $('#btnFilterSearch').on('click', function() {
        table.ajax.reload();
    });

    // Reset button
    $('#btnResetFilter').on('click', function () {
        $('.cs_model, .cs_type, .cs_material, .cs_shift').val(null).trigger('change');

        // Clear date range properly
        $('#daterange_insp').data('daterangepicker').setStartDate(moment());
        $('#daterange_insp').data('daterangepicker').setEndDate(moment());
        $('#daterange_insp').val('');

        // Reset dynamic selects
        $('#fd_type').html('<option value="">Select Type</option>');
        $('#fd_material').html('<option value="">Select Part no</option>');

        table.ajax.reload();
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

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));

    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    </script>

    <script>

    $(document).on('click', '.viewMaterial', function () {
        const tr = $(this).closest('tr');
        const table = $('#inspectionGroupsTable').DataTable();
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

    </script>

</body>
</html>