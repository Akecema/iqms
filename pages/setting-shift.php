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
                            <div class="col-xl-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">Shift Detail</h6>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="tableShift" class="display table mb-1 table-striped-thead table-wide table-md">
                                                <thead class="thead-black">
                                                    <tr>
                                                        <th>Shift Name</th>
                                                        <th>Shift Code</th>
                                                        <th>Time Start</th>
                                                        <th>Time End</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="row">                                    
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-block w-100">
                                                    <h4 class="heading mb-1">
                                                        <i class="fa fa-clock me-2 text-black"></i>
                                                        Add Shift
                                                    </h4>
                                                    <small class="text-muted d-block">
                                                       <!-- This Related Shifts will display in sorting section. -->
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Shift Name</label>
                                                    <input type="text" class="form-control" id="add_shiftdesc" placeholder="Enter Shift">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Shift Code</label>
                                                    <input type="text" class="form-control" id="add_shiftcd" placeholder="Enter Shift">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Short Code</label>
                                                    <input type="text" class="form-control" id="add_shiftshort" placeholder="Enter Shift">
                                                </div>
                                                <div class="row g-3">
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Time Start</label>
                                                        <div class="input-group clockpicker" data-placement="top" data-align="left" data-autoclose="true">
                                                            <input type="text" class="form-control" id="add_timestart" value=""> 
                                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Time End</label>
                                                        <div class="input-group clockpicker" data-placement="top" data-align="left" data-autoclose="true">
                                                            <input type="text" class="form-control" id="add_timeend" value=""> 
                                                            <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer text-end">
                                                    <button type="button" class="btn btn-black" id="btnSaveShift">Save</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                            <!-- Modal update shift -->
                            <div class="modal fade" id="shiftEditModal" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content border-0 shadow-sm">

                                        <div class="modal-header border-bottom-0">
                                            <!-- <h5 class="modal-title fw-semibold text-dark">
                                                <i class="fa fa-building me-2 text-primary"></i>Edit Company
                                            </h5> -->
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body px-4 py-3">

                                            <input type="hidden" id="edit_shift_id">

                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Shift Name</label>
                                                    <input type="text" class="form-control" id="edit_shiftdesc" placeholder="Enter Shift Name">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Shift Code</label>
                                                    <input type="text" class="form-control" id="edit_shiftcd" placeholder="Enter Sshift Code">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Short Code</label>
                                                    <input type="text" class="form-control" id="edit_shiftshort" placeholder="Enter Shift Short Code">
                                                </div>
                                            </div>
                                            
                                            <div class="row g-3">
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Time Start</label>
                                                    <div class="input-group clockpicker" data-placement="top" data-align="left" data-autoclose="true">
                                                        <input type="text" class="form-control" id="edit_timestart" value="13:14"> 
                                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label class="form-label">Time End</label>
                                                    <div class="input-group clockpicker" data-placement="top" data-align="left" data-autoclose="true">
                                                        <input type="text" class="form-control" id="edit_timeend" value="13:14"> 
                                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer bg-light border-top-0 px-4 py-3">
                                            <button type="button" class="btn light btn-dark" data-bs-dismiss="modal">
                                                <i class="fa fa-times me-1"></i> Cancel
                                            </button>
                                            <button type="button" class="btn btn-black" id="btnUpdateShift">
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
                    action: 'list_shift'
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

    // ADD RELATED SHIFT
    $(document).on('click', '#btnSaveShift', function () {

        if (!validateField('#add_shiftdesc', 'Shift Name')) return;
        if (!validateField('#add_shiftcd', 'Shift Code')) return;
        if (!validateField('#add_shiftshort', 'Short Code')) return;
        if (!validateField('#add_timestart', 'Time Start')) return;
        if (!validateField('#add_timeend', 'Time End')) return;

        Swal.fire({
            title: 'Add new shift',
            text: 'Add this new shift?',
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
                    action: 'add_shift',
                    add_shiftcd: $('#add_shiftcd').val(),
                    add_shiftdesc: $('#add_shiftdesc').val(),
                    add_shiftshort: $('#add_shiftshort').val(),
                    add_timestart: $('#add_timestart').val(),
                    add_timeend: $('#add_timeend').val()
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
                            text: "New shift added successfully.",
                            icon: "success",
                            confirmButtonColor: "#198754"
                        }).then(() => {

                            table.ajax.reload(null, false);

                            $('#add_shiftcd').val('');
                            $('#add_shiftdesc').val('');
                            $('#add_shiftshort').val('');
                            $('#add_timestart').val('');
                            $('#add_timeend').val('');

                            $('.border-error').removeClass('border-error');
                        });

                    } else {

                        Swal.fire({
                            title: 'Error',
                            text: res.message,
                            icon: 'error',
                            iconColor: "#b02424ff",
                            confirmButtonColor: '#198754',
                            confirmButtonColor: "#198754"
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: 'Error',
                        text: 'System error occurred.',
                        icon: 'error',
                        iconColor: "#b02424ff",
                        confirmButtonColor: '#198754',
                        confirmButtonColor: "#198754"
                    });
                }
            });

        });
    });


    //EDIT SHIFT
    $(document).on('click', '.btnEditShift', function () {

        const shift_id = $(this).data('id');

        $.ajax({
            url: 'fetch-settings.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_shift',
                shift_id: shift_id
            },
            success: function (res) {

                if (res.status !== 'success') {
                    Swal.fire({
                        title: 'Error',
                        text: res.message,
                        icon: 'error',
                        iconColor: "#198754",
                        showCancelButton: true,
                        confirmButtonColor: '#198754'
                    });
                    return;
                }

                const d = res.data;

                // Fill inputs
                $('#edit_shift_id').val(d.shiftid);
                $('#edit_shiftcd').val(d.shiftcd);                
                $('#edit_shiftdesc').val(d.shiftdesc);                
                $('#edit_shiftshort').val(d.shiftshort);
                $('#edit_timestart').val(d.timestart);
                $('#edit_timeend').val(d.timeend);

                // Show modal first
                $('#shiftEditModal').modal('show');

            },
            error: function () {
                Swal.fire('Error', 'Failed to load shift data', 'error');
            }
        });
    });

    //UPDATE
    $('#btnUpdateShift').on('click', function () {

        if (!validateField('#edit_shiftdesc', 'Shift Name')) return;
        if (!validateField('#edit_shiftcd', 'Shift Code')) return;
        if (!validateField('#edit_shiftshort', 'Short Code')) return;
        if (!validateField('#edit_timestart', 'Time Start')) return;
        if (!validateField('#edit_timeend', 'Time End')) return;

        $.ajax({
            url: 'fetch-settings.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_shift',
                edit_shift_id: $('#edit_shift_id').val(),
                edit_shiftcd: $('#edit_shiftcd').val(),
                edit_shiftdesc: $('#edit_shiftdesc').val(),
                edit_shiftshort: $('#edit_shiftshort').val(),
                edit_timestart: $('#edit_timestart').val(),
                edit_timeend: $('#edit_timeend').val()
            },
            success: function(res){
                if(res.status === 'success'){
                    Swal.fire({
                        title: "Saved",
                        text: "Shift detail updated successfully.",
                        icon: "success",
                        iconColor: "#198754",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#198754"
                    }).then(()=>{
                        $('#shiftEditModal').modal('hide');
                        table.ajax.reload(null,false);
                    });
                } else {
                    Swal.fire({
                        title:'Error',
                        text:res.message,
                        icon:'error',
                        iconColor: "#b02424ff",
                        confirmButtonText: "OK",
                        confirmButtonColor: "#198754"
                    });
                }
            }
        });

    });


    </script>

</body>
</html>