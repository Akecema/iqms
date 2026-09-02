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
    
	<link href="vendor/nestable2/css/jquery.nestable.min.css" rel="stylesheet">
    <link href="vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    
    <!-- Clockpicker -->
    <link href="vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    
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

		#tableDPU tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableDPU thead tr th:last-child{
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
                        <?=$side_menu_mast8;?> (<?=$side_menu_mast7;?>)
                    </div>
                </div>

                <div class="tab-content" id="tabshift">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">                        
                        <div class="row">
                            <div class="col-xl-9">
                                <div class="card">                                    
                                    <div class="card-body">

                                        <?php

                                        $cYr = date('Y');

                                        // Fetch dropdown data for filter form
                                        $fy_sql_f  = "SELECT financial_year, financial_desc FROM financial_year WHERE financial_year <= '$cYr'  ORDER BY financial_year DESC";
                                        $fy_res_f  = mysqli_query($db_con, $fy_sql_f);

                                        ?>

                                        <div class="row g-2 align-items-end mb-2">
                                            <div class="col-auto g-4">
                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Financial Year</label>
                                                <select name="filter_fy" id="filter_fy" class="form-select form-select-sm cs-border-primary text-primary filter-select" onchange="document.getElementById('f_daterange').value=''; this.form.submit()">
                                                    <option value="">All</option>
                                                    <?php while($fy_row = mysqli_fetch_assoc($fy_res_f)): ?>
                                                        <option value="<?= $fy_row['financial_year'] ?>">
                                                            FY <?= $fy_row['financial_desc'] ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="tableDPU" class="display table mb-1 table-striped-thead table-wide table-md">
                                                <thead class="thead-black">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Financial Year</th>
                                                        <th>Model</th>
                                                        <th>Feb</th>
                                                        <th>Mac</th>
                                                        <th>April</th>
                                                        <th>May</th>
                                                        <th>June</th>
                                                        <th>July</th>
                                                        <th>Aug</th>
                                                        <th>Sept</th>
                                                        <th>Oct</th>
                                                        <th>Nov</th>
                                                        <th>Dec</th>
                                                        <th>Jan</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3">
                                <div class="row">                                    
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-block w-100">
                                                    <h4 class="heading mb-1">
                                                        <i class="fa fa-cloud-upload me-2 text-black"></i>
                                                        Upload Target DPU
                                                    </h4>
                                                    <small class="text-muted d-block">
                                                        
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                                <div class="mb-4 dwld-template text-end">
                                                    <a href="uploads/template_target_DPU.xlsx" download class="btn btn-outline-primary btn-sm">
                                                        <i class="fa fa-download me-1"></i> Template
                                                    </a>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Financial Year</label>
                                                    <select class="form-control filter-select fd_yr" name="fd_yr" id="single-select-fy">
                                                        <option value="">Select Financial Year</option>
                                                        <?php
                                                        $sql_fy = "SELECT financial_year, financial_desc FROM financial_year WHERE financial_accstatus = 'AC' and financial_status = 'Open'
                                                                        ORDER BY financial_year ASC";
                                                        $rst_fy = mysqli_query($db_con, $sql_fy);

                                                        while ($row_fy = mysqli_fetch_array($rst_fy)) {
                                                        ?>
                                                            <option value="<?php echo $row_fy['financial_year']; ?>" 
                                                                <?= (isset($_GET['fd_yr']) && $_GET['fd_yr'] == $row_fy['financial_year']) ? "selected" : "" ?>>
                                                                <?php echo $row_fy['financial_desc']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Model</label>
                                                    <select class="form-control select2-filter cs_model" name="fd_model" id="single-select">
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
                                                <div class="mb-3">
                                                    <label for="formFile" class="form-label">File</label>
                                                    <input class="form-control" type="file" id="formFile">
                                                </div>
                                                
                                                <div class="card-footer d-flex justify-content-between align-items-center">                                                   
                                                    <button type="button" class="btn btn-black" id="btnSaveDPU">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            <!-- Modal update DPU -->
                            <div class="modal fade" id="dpuEditModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content border-0 shadow-sm">
                                        <div class="modal-header border-bottom-0">
                                            <h5 class="modal-title fw-semibold text-dark">Edit Target DPU</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body px-4 py-3">
                                            <input type="hidden" id="edit_dpu_id">
                                            <div class="row g-3">
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Feb</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_feb">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Mac</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_mac">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Apr</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_apr">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">May</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_may">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">June</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_june">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">July</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_july">
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Aug</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_aug">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Sept</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_sept">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Oct</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_oct">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Nov</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_nov">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Dec</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_december">
                                                </div>
                                                <div class="col-md-2 mb-3">
                                                    <label class="form-label">Jan</label>
                                                    <input type="number" step="0.001" min="0.001" class="form-control" id="edit_jan">
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Model</label>
                                                    <select class="form-select" id="edit_model_id">
                                                        <option value="">Select Model</option>
                                                        <?php
                                                        $rst_model2 = mysqli_query($db_con, $sql_model);
                                                        while ($row_model = mysqli_fetch_array($rst_model2)) {
                                                        ?>
                                                            <option value="<?php echo $row_model['modid']; ?>"><?php echo $row_model['modcode']; ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select" id="edit_dpu_status">
                                                        <option value="AC">Active</option>
                                                        <option value="IN">Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnUpdateDPU">
                                                <i class="fa fa-save me-1"></i> Save Changes
                                            </button>
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
    <style>
        /* Change font color for disabled Select2 rows */
        .select2-container--default .select2-results__option[aria-disabled=true] {
            color: #CFD4CF !important;
        }
    </style>
       
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/select2/js/select2.full.min.js"></script>
    <script src="js/plugins-init/select2-init.js"></script>
   	<script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>	

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/responsive/responsive.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>

    <script src="vendor/moment/moment.min.js"></script>
    <!-- clockpicker -->
    <script src="vendor/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <!-- Clockpicker init -->
    <script src="js/plugins-init/clock-picker-init.js"></script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {
        history.back();
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
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#tableDPU').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>


    <script>

    let table; // global
    
    $(document).ready(function () {

        table = $('#tableDPU').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 6,
            scrollY: "500px",
            scrollX: true,
            scrollCollapse: true,
            order: [[2, 'desc']],
            ajax: {
                url: 'fetch-settings.php',
                type: 'POST',
                data: function(d) {
                    d.action = 'list_target_dpu';
                    d.filter_fy = $('#filter_fy').val();
                }
            },
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            }
        });

    });

    function validateField(id, label) {
        let val = $(id).val();

        // for Select2, value may be null
        if (!val || val.toString().trim() === "") {
            $(id).addClass("border-error");

            Swal.fire({
                text: label + " is required.",
                icon: "warning",
                iconColor: "#198754",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                scrollToField(id);
                $(id).focus();
            });

            return false;
        }

        $(id).removeClass("border-error");
        return true;
    }

    // ADD FINANCIAL YEAR
    $(document).on('click', '#btnSaveFY', function () {

        if (!validateField('#add_financial_year', 'Financial Year')) return;
        if (!validateField('#add_financial_desc', 'Description')) return;
        if (!validateField('#add_date_start', 'Date Start')) return;
        if (!validateField('#add_date_end', 'Date End')) return;

        Swal.fire({
            title: 'Add Financial Year',
            text: 'Are you sure?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754'
        }).then(res => {

            if (!res.isConfirmed) return;

            $.ajax({
                url: 'fetch-settings.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'add_financial_yr',
                    add_financial_year: $('#add_financial_year').val(),
                    add_financial_desc: $('#add_financial_desc').val(),
                    add_date_start: $('#add_date_start').val(),
                    add_date_end: $('#add_date_end').val()
                },
                beforeSend: function () {
                    Swal.fire({
                        title: 'Saving...',
                        allowOutsideClick: false,
                        didOpen: () => Swal.showLoading()
                    });
                },
                success: function (res) {

                    if (res.status === 'success') {

                        Swal.fire({
                            title: "Saved",
                            text: "New financial year added successfully.",
                            icon: "success",
                            confirmButtonColor: "#198754"
                        }).then(() => {

                            table.ajax.reload(null, false);

                            $('#add_financial_year').val('');
                            $('#add_financial_desc').val('');
                            $('#add_date_start').val('');
                            $('#add_date_end').val('');

                            $('.border-error').removeClass('border-error');
                        });

                    } else {

                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                            confirmButtonColor: '#198754'
                        });
                    }
                },
                error: function () {
                    Swal.fire('Error', 'System error occurred.', 'error');
                }
            });

        });
    });


    // EDIT MODAL LOAD
    $(document).on('click', '.btnEditFY', function () {

        const financial_id = $(this).data('id');

        $.ajax({
            url: 'fetch-settings.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_financial_yr',
                financial_id: financial_id
            },
            success: function (res) {

                if (res.status !== 'success') {
                    Swal.fire('Error', res.message, 'error');
                    return;
                }

                const d = res.data;

                // Fill inputs
                $('#edit_financial_id').val(d.financial_id);
                $('#edit_financial_year').val(d.financial_year);                
                $('#edit_financial_desc').val(d.financial_desc);                
                $('#edit_date_start').val(d.date_start);
                $('#edit_date_end').val(d.date_end);
                $('#edit_financial_accstatus').val(d.financial_accstatus);

                $('#yearEditModal').modal('show');

            },
            error: function (xhr, status, error) {
                Swal.fire('Error', 'Failed to load record. (Error: ' + error + ')', 'error');
            }
        });
    });

    // UPDATE
    function toggleDpuInputs(status) {
        let isInactive = (status === 'IN');
        $('#dpuEditModal input[type="number"]').prop('disabled', isInactive);
        $('#edit_model_id').prop('disabled', isInactive);
    }

    $('#filter_fy').on('change', function() {
        table.ajax.reload();
    });

    $('#edit_dpu_status').on('change', function() {
        toggleDpuInputs($(this).val());
    });

    // EDIT DPU MODAL LOAD
    $(document).on('click', '.btnEditDPU', function () {
        const dpu_id = $(this).data('id');
        $.ajax({
            url: 'fetch-settings.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'get_target_dpu', dpu_id: dpu_id },
            success: function (res) {
                if (res.status !== 'success') {
                    Swal.fire('Error', res.message, 'error');
                    return;
                }
                const d = res.data;
                $('#edit_dpu_id').val(d.dpu_id);
                $('#edit_feb').val(d.feb);
                $('#edit_mac').val(d.mac);
                $('#edit_apr').val(d.apr);
                $('#edit_may').val(d.may);
                $('#edit_june').val(d.june);
                $('#edit_july').val(d.july);
                $('#edit_aug').val(d.aug);
                $('#edit_sept').val(d.sept);
                $('#edit_oct').val(d.oct);
                $('#edit_nov').val(d.nov);
                $('#edit_december').val(d.december);
                $('#edit_jan').val(d.jan);
                $('#edit_dpu_status').val(d.dpu_status);
                $('#edit_model_id').val(d.model_id);
                toggleDpuInputs(d.dpu_status);
                $('#dpuEditModal').modal('show');
            },
            error: function (xhr, status, error) {
                Swal.fire('Error', 'Failed to load record. (Error: ' + error + ')', 'error');
            }
        });
    });

    // UPDATE DPU
    $('#btnUpdateDPU').on('click', function () {
        $.ajax({
            url: 'fetch-settings.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_target_dpu',
                edit_dpu_id: $('#edit_dpu_id').val(),
                edit_feb: $('#edit_feb').val(),
                edit_mac: $('#edit_mac').val(),
                edit_apr: $('#edit_apr').val(),
                edit_may: $('#edit_may').val(),
                edit_june: $('#edit_june').val(),
                edit_july: $('#edit_july').val(),
                edit_aug: $('#edit_aug').val(),
                edit_sept: $('#edit_sept').val(),
                edit_oct: $('#edit_oct').val(),
                edit_nov: $('#edit_nov').val(),
                edit_december: $('#edit_december').val(),
                edit_jan: $('#edit_jan').val(),
                edit_dpu_status: $('#edit_dpu_status').val(),
                edit_model_id: $('#edit_model_id').val()
            },
            success: function(res){
                if(res.status === 'success'){
                    Swal.fire({
                        title: "Saved",
                        text: "Record updated successfully.",
                        icon: "success",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#198754"
                    }).then(()=>{
                        $('#dpuEditModal').modal('hide');
                        table.ajax.reload(null,false);
                    });
                } else {
                    Swal.fire({
                        title:'Error',
                        text:res.message,
                        icon:'error',
                        confirmButtonColor: "#198754"
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire('Error', 'System error occurred: ' + error, 'error');
            }
        });
    });

    // INLINE UPDATE
    $(document).on('change', '.dpu-inline-edit', function() {
        const $input = $(this);
        const dpu_id = $input.data('id');
        const field = $input.data('field');
        const val = $input.val();

        $.ajax({
            url: 'fetch-settings.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'inline_update_target_dpu',
                dpu_id: dpu_id,
                field: field,
                value: val
            },
            success: function(res) {
                if(res.status !== 'success') {
                    Swal.fire({
                        toast: true,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 4000,
                        icon: 'error',
                        title: 'Failed to update ' + field
                        // title: 'Failed to update ' + field
                    });
                } else {
                    Swal.fire({
                        toast: true,
                        position: 'center',
                        showConfirmButton: false,
                        timer: 2000,
                        icon: 'success',
                        title: 'Saved'
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire('Error', 'System error occurred: ' + error, 'error');
            }
        });
    });

    $('#single-select-fy').on('change', function() {
        var fy = $(this).val();
        if (fy) {
            $.ajax({
                url: 'fetch-settings.php',
                type: 'POST',
                dataType: 'json',
                data: { action: 'get_existing_models', financial_year: fy },
                success: function(res) {
                    if (res.status === 'success') {
                        $('#single-select option').each(function() {
                            var val = $(this).val();
                            if (val && res.data.includes(parseInt(val))) {
                                $(this).prop('disabled', true);
                            } else {
                                $(this).prop('disabled', false);
                            }
                        });
                        $('#single-select').select2({ width: '100%' });
                        if ($('#single-select option:selected').prop('disabled')) {
                            $('#single-select').val(null).trigger('change');
                        }
                    }
                }
            });
        } else {
            $('#single-select option').prop('disabled', false);
            $('#single-select').select2({ width: '100%' });
        }
    });

    // UPLOAD TARGET DPU
    $('#btnSaveDPU').on('click', function() {

        var model = $('#single-select').val();
        var fy = $('#single-select-fy').val();
        var fileInput = $('#formFile')[0];

        if (!model) { 
            Swal.fire({
                text: "Please select Model.",
                icon: "warning",
                iconColor: "#198754",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            });

            return; 
        }

        if (!fy) { 
            Swal.fire({
                text: "Please select Financial Year.",
                icon: "warning",
                iconColor: "#198754",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            });
            return; 
        }

        if (fileInput.files.length === 0) { 
            Swal.fire({
                text: "Please select a file.",
                icon: "warning",
                iconColor: "#198754",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            });
            return; 
        }

        var formData = new FormData();
        formData.append('action', 'upload_target_dpu');
        formData.append('model_id', model);
        formData.append('financial_year', fy);
        formData.append('file', fileInput.files[0]);

        $.ajax({
            url: 'fetch-settings.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.status === 'success') {
                    Swal.fire({
                        title: 'Success',
                        text: 'Data successfully uploaded to Target DPU',
                        icon: 'success',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754'
                    }).then(() => {
                        table.ajax.reload(null, false);
                        $('#formFile').val('');
                        $('#single-select').val(null).trigger('change');
                        $('#single-select-fy').val(null).trigger('change');
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: res.message || 'Failed to upload.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#198754'
                    });
                }
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'An error occurred during upload',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#198754'
                });
            }
        });
    });

    </script>

</body>
</html>