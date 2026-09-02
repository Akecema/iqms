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

		#tableTimedelay tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableTimedelay thead tr th:last-child{
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

                <ul class="nav nav-underline nav-underline-primary nav-underline-text-dark nav-underline-gap-x-0 mb-4" id="tabMyProfileBottom" role="tablist">
                        <li class="nav-item ms-1" role="presentation">
                            <a href="setting-shift.php" class="nav-link py-3 border-3 text-black active">Pre Delivery Inspection (PDI)</a>
                        </li>
                        <!-- <li class="nav-item ms-1" role="presentation">
                            <a href="setting-timedelay.php" class="nav-link py-3 border-3 text-black">Incoming</a>
                        </li> -->
                    </ul>

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
                                            <table id="tableTimedelay" class="display table mb-1 table-striped-thead table-wide table-md">
                                                <thead class="thead-black">
                                                    <tr>
                                                        <th>Section Task</th>
                                                        <th>Process</th>
                                                        <th>Delay Duration (day)</th>
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
		$('#tableTimedelay').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});

	</script>


    <script>

    let table; // global
    
    $(document).ready(function () {

        table = $('#tableTimedelay').DataTable({
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 10,
            order: [[0, 'asc']],
            ajax: {
                url: 'fetch-timedelay.php',
                type: 'POST',
                data: {
                    action: 'list_timedelay'
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

    //Update days
    $(document).on('input', '.delay-days', function () {

        let input = $(this);
        let task_id = input.data('id');
        let delay_day = input.val();

        let row = input.closest('tr');

        $.ajax({
            url: 'fetch-timedelay.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'update_day',
                task_id: task_id,
                delay_day: delay_day
            },
            success: function(res){

                if(res.status === 'success'){

                    row.addClass('row-updated');

                    setTimeout(()=>{
                        row.removeClass('row-updated');
                    },2000);

                } else {
                    row.css('background','#f8d7da');
                }
            }
        });

    });

    </script>

</body>
</html>