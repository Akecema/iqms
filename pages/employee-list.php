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

    <link href="css/badge.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    
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

		#tableEmployee tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableEmployee thead tr th:last-child{
            text-align: left !important;
        }

        .avatar-sm
        {
            width : 48px !important;
            height : 48px !important;
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
                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                        <div class="row">                    
                            <div class="col-xl-12">
                                <div class="card overflow-hidden h-auto">	
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="table-responsive">
                                                <table id="tableEmployee" class="display table mb-1 table-striped-thead table-wide table-md">
                                                    <thead class="thead-black">
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Company</th>
                                                            <th>Department</th>
                                                            <th>Action</th>
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
    //to apply select style to non select2
    $('.result-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });
    </script>

    <script>

	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#tableEmployee').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>

    <script>
        
    let table;
    $(document).ready(function() {

        table = $('#tableEmployee').DataTable({
            processing: true,
            serverSide: true,
            order: [[0, 'asc']],
			lengthChange: false,
            language: {
                paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
            },
            "ajax": {
                url: 'fetch-employee.php',
                method:"POST",
                data: function (d) {
                        d.action   = 'fetch_employee';
                    }
            },
            columnDefs: [                
                { targets: 'nosort', orderable: false }
            ],
        }); 
		 
    });

    function resetPassword(staffId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You want to reset this user's password to default (Qims@user!)?",
            icon: 'warning',
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Yes, reset it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'fetch-employee.php',
                    method: 'POST',
                    data: {
                        action: 'reset_password',
                        staff_id: staffId
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Reset!',
                                text: response.message,
                                icon: 'success',
                                iconColor: "#198754",
                                showCancelButton: true,
                                confirmButtonColor: '#198754'
                            });
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.message,
                                icon: 'error',
                                iconColor: "#198754",
                                showCancelButton: true,
                                confirmButtonColor: '#198754'
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again.',
                            icon: 'error',
                            iconColor: "#198754",
                            showCancelButton: true,
                            confirmButtonColor: '#198754'
                        });
                    }
                });
            }
        });
    }

    function toggleAccountLock(staffId, currentStatus) {
        let actionMsg = (currentStatus === 'Y') ? 'unlock' : 'lock';
        let confirmText = (currentStatus === 'Y') ? "You want to unlock this account?" : "You want to lock this account? The user will not be able to login.";
        
        Swal.fire({
            title: 'Are you sure?',
            text: confirmText,
            icon: 'warning',
            iconColor: "#198754",
            showCancelButton: true,
            confirmButtonColor: '#198754',
            confirmButtonText: 'Yes, ' + actionMsg + ' it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'fetch-employee.php',
                    method: 'POST',
                    data: {
                        action: 'toggle_lock',
                        staff_id: staffId,
                        current_status: currentStatus
                    },
                    success: function(response) {
                        try {
                            let res = typeof response === 'string' ? JSON.parse(response) : response;
                            if (res.status === 'success') {
                                Swal.fire({
                                    title: (currentStatus === 'Y' ? 'Unlocked!' : 'Locked!'),
                                    text: res.message,
                                    icon: 'success',
                                    iconColor: "#198754",
                                    confirmButtonColor: '#198754'
                                }).then(() => {
                                    table.ajax.reload(null, false); // reload table without resetting paging
                                });
                            } else {
                                Swal.fire('Error', res.message, 'error');
                            }
                        } catch (e) {
                            console.error("Response parsing error:", response);
                            Swal.fire('Error', 'Invalid server response.', 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong. Please try again.', 'error');
                    }
                });
            }
        });
    }

    // Reload after save / delete
    // loadEmployeeTable();
    </script>

    

</body>
</html>