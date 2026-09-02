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

		#tableShift tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableShift thead tr th:last-child{
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
                <div class="tab-content" id="tabshift">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">                        
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">Financial Year</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tableShift" class="display table mb-1 table-striped-thead table-wide table-md">
                                                <thead class="thead-black">
                                                    <tr>
                                                        <th>Financial Year</th>
                                                        <th>Description</th>
                                                        <th>Status</th>
                                                        <th>Date Start</th>
                                                        <th>Date End</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="row">                                    
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-block w-100">
                                                    <h4 class="heading mb-1">
                                                        <i class="fa fa-calendar me-2 text-black"></i>
                                                        Add Financial Year
                                                    </h4>
                                                    <small class="text-muted d-block">
                                                       <!-- This Related Shifts will display in sorting section. -->
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Financial Year</label>
                                                    <input type="text" class="form-control" id="add_financial_year" placeholder="e.g. 2024">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="add_financial_desc" placeholder="e.g. 2024/25">
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Date Start</label>
                                                        <input type="date" class="form-control" id="add_date_start">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Date End</label>
                                                        <input type="date" class="form-control" id="add_date_end">
                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="button" class="btn btn-black" id="btnSaveFY">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            <!-- Modal update fy -->
                            <div class="modal fade" id="yearEditModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <!-- <h5 class="modal-title fw-semibold text-dark">
                                                <i class="fa fa-building me-2 text-primary"></i>Edit Company
                                            </h5> -->
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">

                                            <input type="hidden" id="edit_financial_id">

                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Financial Year</label>
                                                    <input type="text" class="form-control" id="edit_financial_year" placeholder="e.g. 2024">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Description</label>
                                                    <input type="text" class="form-control" id="edit_financial_desc" placeholder="e.g. 2024/25">
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Date Start</label>
                                                    <input type="date" class="form-control" id="edit_date_start">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Date End</label>
                                                    <input type="date" class="form-control" id="edit_date_end">
                                                </div>
                                            </div>

                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Account Status</label>
                                                    <select class="form-select" id="edit_financial_accstatus">
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
                                            <button type="button" class="btn btn-black" id="btnUpdateFY">
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

    //to apply select style to non select2
    //select with no filter
    // $('.default-select').select2({
    //     minimumResultsForSearch: Infinity, // Hide search box if not needed
    //     width: '100%'
    // });

    </script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {
        history.back();
    });

    </script>

    <script>

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#tableShift').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>


    <script>

    let table; // global
    
    $(document).ready(function () {

        table = $('#tableShift').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: 'fetch-settings.php',
                type: 'POST',
                data: {
                    action: 'list_financial_yr'
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
                    Swal.fire({
                        icon: 'error',
                        iconColor: "#286912",
                        title: 'Error',
                        text: res.message,
                        timer: 3000,
                        showConfirmButton: false
                    });

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
            error: function () {
                Swal.fire({
                    icon: 'error',
                    iconColor: "#286912",
                    title: 'Error',
                    text: 'Failed to load record.',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    });

    // UPDATE
    $('#btnUpdateFY').on('click', function () {

        if (!validateField('#edit_financial_year', 'Financial Year')) return;
        if (!validateField('#edit_financial_desc', 'Description')) return;
        if (!validateField('#edit_date_start', 'Date Start')) return;
        if (!validateField('#edit_date_end', 'Date End')) return;

        $.ajax({
            url: 'fetch-settings.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_financial_yr',
                edit_financial_id: $('#edit_financial_id').val(),
                edit_financial_year: $('#edit_financial_year').val(),
                edit_financial_desc: $('#edit_financial_desc').val(),
                edit_date_start: $('#edit_date_start').val(),
                edit_date_end: $('#edit_date_end').val(),
                edit_financial_accstatus: $('#edit_financial_accstatus').val()
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
                        $('#yearEditModal').modal('hide');
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
            }
        });

    });


    </script>

</body>
</html>