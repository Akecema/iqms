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

      

		<?php

        $startDate = date('m/01/Y') ; //2023-01-01
        $endDate = date('m/t/Y'); //2023-01-31
        
        ?>

        <!--**********************************
            Sidebar end
        ***********************************-->

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

		#listdoSomethingwrongSect tbody tr td:last-child {
            text-align: left !important; 
        }

        #listdoSomethingwrongSect thead tr th:last-child{
            text-align: left !important;
        }

        #listdoSomethingwrongSect tbody tr td:last-child {
            text-align: left !important; 
        }

        #listdoSomethingwrongSect thead tr th:last-child{
            text-align: left !important;
        }

        #inspectionCompletedList tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionCompletedList thead tr th:last-child{
            text-align: left !important;
        }

        /* table header, body align */
        #inspectionTable_defect tbody tr td:last-child {
            text-align: left; 
        }

        #inspectionTable_defect thead tr th:last-child {
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

        .zoomable-img {
            cursor: pointer;       /* Show hand on hover */
            position: relative;    /* Make sure it's clickable */
            z-index: 10;           /* Bring it above wrappers */
            pointer-events: auto;  /* Ensure clicks pass through */
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

        .pallet-col {
            width: 65px;
            min-width: 65px;
            max-width: 65px;
            white-space: normal !important;
            word-wrap: break-word;
        }
 
        .small-text {
            font-size: 12px; /* or 12px, etc. */
        }

       .widget-timeline-icons ul.timeline {
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        /* timeline  date activity */
        .timeline-entry {
            display: flex;
            align-items: start;
            position: relative;
            padding-left: 0.063rem;
        }

        .timeline-entry::before {
            content: "";
            position: absolute;
            top: 1.438rem;
            left: 0.938rem;
            height: 100%;
            width: 2px;
            background-color: #dee2e6;
            z-index: 0;
        }

        .timeline-icon {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            font-size: 14px;
            z-index: 1;
            margin-right: 1rem;
            flex-shrink: 0;
        }

        .timeline-title-remark {
            cursor: pointer;       /* Show hand on hover */
        }

        #remarkModal .modal-dialog {
            margin-top: -140px;   /* adjust distance from top */
            margin-right: 50px;
        }

        .bg-light-green {
            background-color: #E5EDE4; /* soft green background */
            border-radius: 6px;
        }

        #remarkContent {
            white-space: pre-wrap; /* support long text and line breaks */
        }

        .tooltip .tooltip-inner {
            /* background-color: #333 !important;
            color: #fff; */
            max-width: 220px;
            white-space: pre-wrap;
        }

        .table-tip {
            font-size: 11px;
            margin-bottom: 6px;
            color: #6c757d;
        }

        .modal-header {
            border-bottom: none !important;
        }
        
        .modal-title {
            color: #000;
        }
        .zoomable-img:hover {
            transform: scale(1.55); /* optional: subtle zoom effect on hover */
        }

        /* material display row images */
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
            transform: scale(1.4); /* optional: subtle zoom effect on hover */
        }

        .child-row-wrapper {
            background: #f8f9fa;
            border-left: 3px solid #198754;
            width: 100%;
        }

        table.dataTable tr.shown td {
            background-color: #eef7ee !important;
        }
        
        .doc-tree {
            padding-left: 30px;
            border-left: 2px solid #ccc;
        }

        .tree {
            margin-left: 20px;
            padding-left: 20px;
            border-left: 2px solid #ccc;
            max-width: 350px;      /* <<< THIS FIXES YOUR WIDE GAP */
        }

        .tree-item {
            position: relative;
            padding: 8px 0 8px 10px;
            text-align : left;
        }

        .tree-item::before {
            content: "";
            position: absolute;
            top: 18px;
            left: -20px;
            width: 20px;
            height: 2px;
            background: #ccc;
        }

        .tree-bullet {
            position: absolute;
            left: -8px;
            top: 15px;
            width: 8px;
            height: 8px;
            background: #e6e6e6;
            border: 2px solid #999;
            border-radius: 50%;
        }

        /* Green */
        .bullet-green {
            background: #4CAF50;  /* green */
            border-color: #3b8d3f;
        }

        /* Orange */
        .bullet-orange {
            background: #FFA500;  /* orange */
            border-color: #cc8400;
        }

        /* Red */
        .bullet-red {
            background: #E53935;  /* red */
            border-color: #b32c29;
        }

        .ip-section{
            color : #194A10;
        }

        small{
            font-size : 12px;
        }

        .red-link {
            color: #B81A2E !important;
        }

        </style>
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
				<div class="header-left mb-4">
                    <div class="dashboard_bar">
                        <?=$side_menu13;?>
                    </div>
                </div>

                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                        <div class="row">                    
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row g-3">
                                                        <!-- Row 1 -->
                                                        <div class="col-md-2 mb-2">
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
                                                        <div class="col-md-2 mb-2">
                                                            <label class="form-label">Type</label>
                                                            <div id="div_type">
                                                                <select class="form-control filter-select cs_type" name="fd_type" id="fd_type">
                                                                    <option value="">Select Type</option>                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-2">                                            
                                                            <label class="form-label">Part No</label>
                                                            <div id="div_material">
                                                                <select class="form-control filter-select cs_material" name="fd_material" id="fd_material">
                                                                    <option value="">Select Part No</option>                                                    
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 mb-2">                                            
                                                            <label class="form-label">Shift</label>
                                                            <select class="form-control filter-select cs_shift" name="fd_shift" id="fd_shift" >
                                                                <option value="">Select Shift</option>
                                                                <option value="D">Day</option>
                                                                <option value="N">Night</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4 mb-2">                                            
                                                            <label class="form-label">Inspection Date Range</label>
                                                            <input class="form-control input-daterange-datepicker" type="text" name="daterange" id="daterange_insp" value="">
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
                                    <div class="col-xl-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="col-xl-4 col-sm-3 mb-2 ms-auto">                                            
                                                    <!-- Search Box -->
                                                    <div class="input-group flex-grow-1 mb-2">
                                                        <span class="input-group-text bg-white"><i class="fa fa-search text-muted"></i></span>
                                                        <input type="text" id="searchInput" class="form-control" placeholder="Search">
                                                    </div>
                                                </div>
                                                <div class="table-responsive" style="overflow-x:auto;">
                                                    <table id="listdoSomethingwrongSect" class="display table mb-1 table-striped-thead table-wide table-md w-100">                                                              
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th class="nosort"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                                                <th>Doc No</th>
																<th>Part No</th>
																<th>Model</th>
																<th>Inspection Date</th>
																<th>Shift</th>
                                                                <th class="nosort">Status</th>
                                                                <th class="nosort">Action</th>
                                                            </tr>
                                                        </thead>
                                                    </table>
                                                </div>
                                                
                                                <button id="btnSubmitSelected" class="btn btn-black me-1" disabled>Submit Selected</button>
                                                <button id="btnCancelSelected" class="btn btn-black" disabled>Cancel Selected</button>  

                                            </div>                                            

                                            <!-- View material images -->
                                            <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content bg-transparent border-0 shadow-none">
                                                        <img id="previewImage" src="" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Zoom Image Modal -->
                                            <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                                    <div class="modal-content bg-transparent border-0 shadow-none">
                                                        <div class="modal-body p-0 text-center">
                                                            <img src="" id="zoomedImage" class="img-fluid rounded shadow"
                                                                style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Bulk Cancel Modal -->
                                            <div class="modal fade" id="bulkcancelModal" tabindex="-1" aria-labelledby="bulkcancelModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form id="bulkcancelForm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">                                                    
                                                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                                                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </div> 
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="bulk_cancel_remark" class="form-label">Comment/ Reason <span class="text-danger">*</span></label>
                                                                <textarea class="form-control" name="remark" id="bulk_cancel_remark" rows="4" style="color: #333;"></textarea>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-black" id="btnConfirmCancelBulk"><i class="fa fa-undo"></i> Cancel Submission</button>
                                                        </div>
                                                    </div>
                                                    </form>
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
    //to apply select style to non select2
    $('.result-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });

    $('.filter-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });
    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
    </script>

    <script>
    var modal = document.getElementById('detailModal');
    modal.addEventListener('shown.bs.modal', function () {
        var tooltipTriggerList = [].slice.call(modal.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
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

    $('#daterange_insp')
        .daterangepicker({
            autoUpdateInput: false,
            maxDate: moment(),
            locale:{
                format:'DD/MM/YYYY',
                cancelLabel:'Clear'
            }
        })

        // when user selects a range
        .on('apply.daterangepicker', function(ev, picker){
            $(this).val(
                picker.startDate.format('DD/MM/YYYY') +
                ' - ' +
                picker.endDate.format('DD/MM/YYYY')
            );
        })

        // when user clicks Clear button
        .on('cancel.daterangepicker', function(ev, picker){
            $(this).val('');
    });

    $('#daterange_insp').val('');
    
    </script>

    <script>

    $(document).on('click', '.viewDocDetails', function() {

        let docno = $(this).data('docno');

        $.ajax({

            url: 'fetch-inspection-details.php',
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

    // Zoom defec /compare photo in modal 
    $(document).on('click', '.zoomable-img', function() {

        const imgSrc = $(this).data('full');
        console.log("Clicked:", imgSrc);

        $('#zoomedImage').attr('src', imgSrc);
        const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        modal.show();
    });

    </script>

    <script>

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

    </script>

    <script>

    document.addEventListener('DOMContentLoaded', function () {
        const remarkModal = new bootstrap.Modal(document.getElementById('remarkModal'));
        const remarkContent = document.getElementById('remarkContent');

        // Event delegation: catch clicks inside detailModal
        document.getElementById('detailModalBody').addEventListener('click', function (e) {
            if (e.target.classList.contains('timeline-title-remark')) {
                const remark = e.target.getAttribute('data-remark') || 'No remark available.';
                remarkContent.textContent = remark;
                remarkModal.show();
            }
        });
    });

    </script>

    <script>

    let table;

    $(document).ready(function() {

        table = $('#listdoSomethingwrongSect').DataTable({
            processing: true,
            serverSide: true,
            order: [[3, 'desc']],
			lengthChange: false,
            scrollX: true,
            // scrollY: '70vh',
            dom: 'lrtip', //hide search box
            language: {
                paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
            },            
            ajax: {
                url: 'fetch-ip-s2w-section.php',
                method:"POST",
                data: function (d) {
                        d.action   = 'fetch_records_create';
                        d.fd_model = $('.cs_model').val();
                        d.fd_type = $('.cs_type').val();
                        d.fd_material = $('.cs_material').val();
                        d.fd_shift = $('.cs_shift').val();
                        d.fd_daterange = $('#daterange_insp').val();
                        d.fd_search = $('#searchInput').val();

                        console.log("Filters sent to server:", d);                        
                    }
            },
            columnDefs: [
                    { targets: 'nosort', orderable: false }
            ],
            drawCallback: function () {

                // disable checkAll if no record
                let api = this.api();
                let rowCount = api.rows({ page: 'current' }).count();

                if (rowCount === 0) {
                    $('#checkAll').prop('checked', false).prop('disabled', true);
                } else {
                    $('#checkAll').prop('disabled', false);
                }

                // Re-init tooltips after each redraw
                document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                    if (!el.getAttribute('data-bs-original-title')) {
                        new bootstrap.Tooltip(el);
                    }
                });
            },
        }); 
		 
    });

    </script>

    <script>

    $(document).on('click', '.btnCreate, .btnEdit, .btnView', function() {

        const s2wid = $(this).data('s2wid');        
        const srid = $(this).data('srid');
        const irid = $(this).data('irid');

        targetUrl = 'ip-s2w-sect-create.php?encs2wid=' 
                    + encodeURIComponent(s2wid) 
                    + '&srid=' + encodeURIComponent(srid)
                    + '&irid=' + encodeURIComponent(irid);

        window.location.href = targetUrl;
    });

    </script>

    <script>

    $(document).on('click', '.viewDocument', function () {
        
        const tr = $(this).closest('tr');
        const table = $('#s2wListall').DataTable();
        const row = table.row(tr);

        const irid = $(this).data('irid');
        const arrow = $(this).find('.doc-arrow'); // FA icon

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
            arrow.removeClass('fa-minus').addClass('fa-plus');

        } else {
            $.post('fetch-ip-s2w-section-docno.php', { irid: irid }, function (res) {
                row.child(`<div class="p-2">${res}</div>`).show();
                tr.addClass('shown');
                arrow.removeClass('fa-plus').addClass('fa-minus');
            });
        }
    });
     
    // View inspection
    $(document).on('click', '.viewDocInspection', function() {

        let docno = $(this).data('docno');

        $.ajax({

            url: 'fetch-inspection-details.php',
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

    // View Sorting
    $(document).on('click', '.viewDocSorting', function() {

        let docno = $(this).data('docno');

        $.ajax({

            url: 'fetch-sorting-details.php',
            type: 'POST',
            dataType: 'html',
            data: { action : 'sorting_details', docno: docno },
            success: function(res) {
                $('#sortingModalBody').html(res);
                let m = new bootstrap.Modal(document.getElementById('sortingModal'));
                m.show();                
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
                alert("Failed to load modal content.");
            }
        });
    }); 

    $(document).on('click', '.viewMaterial', function () {
        
        const tr = $(this).closest('tr');
        const table = $('#listdoSomethingwrongSect').DataTable();
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

    $(document).on('click', '.viewDocument', function () {
        
        const tr = $(this).closest('tr');
        const table = $('#listdoSomethingwrongSect').DataTable();
        const row = table.row(tr);

        const irid = $(this).data('irid');

        if (row.child.isShown()) {
            row.child.hide();
            tr.removeClass('shown');
        } else {
            $.post('fetch-ip-s2w-section-docno.php', { irid: irid }, function (res) {
            row.child(`<div class="p-2">${res}</div>`).show();
            tr.addClass('shown');
            });
        }
    });

    // When avatar is clicked
    $(document).on('click', '.viewAvatar', function () {
        const fullImg = $(this).data('full');
        console.log('Image clicked:', fullImg); 
        $('#previewImage').attr('src', fullImg);
        
        // OPTIONAL: Hide detail modal for cleaner background
        const detailModal = bootstrap.Modal.getInstance(document.getElementById('detailModal'));
        if (detailModal) detailModal.hide();

        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        modal.show();
    });


    $('#imagePreviewModal').on('hidden.bs.modal', function () {
        const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
        detailModal.show();
    });

    </script>

    <script>

    $(document).ready(function () {
        // Read erid from URL
        const urlParams = new URLSearchParams(window.location.search);
        const irid = urlParams.get('irid');

        if (irid) {
            $.ajax({
                url: 'inspection-rcd-imgview.php',
                type: 'POST',
                dataType: 'json',
                data: { ir_id: irid },   // pass irid
                success: function (res) {
                    // Inject images
                    $('#lightgallery').html(res.gallery_html);

                    // Inject details
                    $('#material_product_detail').html(res.detail_html);

                    // Init lightGallery if needed
                    if ($('#lightgallery').data('lightGallery')) {
                        $('#lightgallery').data('lightGallery').destroy(true);
                    }
                    $('#lightgallery').lightGallery({
                        selector: 'a',
                        thumbnail: true
                    });
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", error, xhr.responseText);
                }
            });
        }
    });

    </script>

    <script>

    $('#btnFilterSearch').on('click', function() {
        table.ajax.reload();
    });

    $('#btnResetFilter').on('click', function() {
        $('.cs_model, .cs_type, .cs_material, .cs_shift').val('').trigger('change');
        $('#daterange_insp').val('');
        $('#searchInput').val('');
        table.ajax.reload();
    });

    $('#searchInput').on('keyup', function() {
        table.ajax.reload();
    });

    </script>

    <script>

    let selectedIds = new Set();
    let selectAllPages = false;

    // update enable/disable buttons based on selected checkbox statuses
    function updateBulkButtons() {

        let statusSet = new Set();

        // collect statuses of checked rows (current page)
        $('.row-check:checked').each(function () {
            let st = parseInt($(this).data('status'), 10);
            statusSet.add(st);
        });

        // default disabled
        $('#btnSubmitSelected').prop('disabled', true);
        $('#btnCancelSelected').prop('disabled', true);

        // rule: ONLY status=13 selected -> enable submit
        if (statusSet.size === 1 && (statusSet.has(12) || statusSet.has(13))) {
            $('#btnSubmitSelected').prop('disabled', false);
        }

        // rule: ONLY status=9 selected -> enable cancel
        if (statusSet.size === 1 && (statusSet.has(9) || statusSet.has(10))) {
            $('#btnCancelSelected').prop('disabled', false);
        }
    }

    $(document).on('change', '.row-check', function () {

        // if disabled checkbox, do nothing
        if ($(this).prop('disabled')) {
            return;
        }

        let id = $(this).val();

        if (this.checked) {
            selectedIds.add(id);
        } else {
            selectedIds.delete(id);

            // if user uncheck one row, cancel select all
            selectAllPages = false;
            $('#checkAll').prop('checked', false);
        }

        updateBulkButtons();
    });

    $(document).on('change', '#checkAll', function () {

        selectAllPages = this.checked;

        if (selectAllPages) {

            // tick all checkboxes except disabled (status=11)
            $('.row-check:not(:disabled)').prop('checked', true);

            // add current page IDs into Set
            $('.row-check:not(:disabled)').each(function () {
                selectedIds.add(this.value);
            });

        } else {

            // uncheck all (even disabled no effect)
            $('.row-check').prop('checked', false);

            // clear selection
            selectedIds.clear();
        }

        updateBulkButtons();
    });

    $('#listdoSomethingwrongSect').on('draw.dt', function () {

        $('.row-check').each(function () {

            let id = $(this).val();

            // never tick disabled
            if ($(this).prop('disabled')) {
                $(this).prop('checked', false);
                selectedIds.delete(id);
                return;
            }

            // restore tick
            if (selectAllPages || selectedIds.has(id)) {
                $(this).prop('checked', true);
            } else {
                $(this).prop('checked', false);
            }
        });

        // keep header checkbox checked only if selectAllPages = true
        $('#checkAll').prop('checked', selectAllPages);

        updateBulkButtons();
    });

    function resetSelection() {
        selectedIds.clear();
        selectAllPages = false;
        $('#checkAll').prop('checked', false);
        updateBulkButtons();
    }

    </script>

    <script>
    
    //Submit for review - slected row
    $('#btnSubmitSelected').on('click', function () {

        if (selectedIds.size === 0) {
            Swal.fire({
                title: 'Warning',
                text: "Please select at least one record.",
                icon: 'warning',
                iconColor: "#286912",
                confirmButtonColor: '#28a745'
            });
            return;
        }

        Swal.fire({
            title: 'Submit Selected?',
            text: `Submit ${selectedIds.size} record(s)?`,
            icon: 'question',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Submit'
        }).then((result) => {

            if (!result.isConfirmed) return;

            $('#btnSubmitSelected').prop('disabled', true);

            $.ajax({
                url: 'fetch-s2w-section-bulk-action.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    ids: Array.from(selectedIds),
                    action: 'bulk_submit'
                },
                success: function (r) {

                    $('#btnSubmitSelected').prop('disabled', false);

                    if (r.status === 'success') {

                        Swal.fire({
                            title: 'Success',
                            text: r.message,
                            icon: 'success',
                            iconColor: "#286912",
                            confirmButtonColor: '#28a745'
                        });
                    
                        // Refresh table or reload
                        table.ajax.reload();

                        selectedIds.clear();
                        $('#checkAll').prop('checked', false);

                        table.ajax.reload(null, false);
                        fetchTotalCounts();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
                            title: 'Error',
                            text: r.message || 'Unknown error',
                            confirmButtonColor: '#28a745',
                        });
                    }
                },
                error: function (xhr) {
                    $('#btnSubmitSelected').prop('disabled', false);
                    console.error(xhr.responseText);

                    console.log("STATUS:", xhr.status);
                    console.log("RESPONSE:", xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        iconColor: "#286912",
                        title: 'Error',
                        text: 'Server error occurred',
                        confirmButtonColor: '#28a745',
                    });
                   
                }
            });

        });
    });
    
    // Cancel submmission - selected
    $('#btnCancelSelected').on('click', function () {

        if (selectedIds.size === 0) {
            Swal.fire({
                title: 'Warning',
                text: "Please select at least one record.",
                icon: 'warning',
                iconColor: "#286912",
                confirmButtonColor: '#28a745'
            });
            return;
        }

        $('#bulk_cancel_remark').val('');
        $('#returnCount').text(selectedIds.size);

        $('#bulkcancelModal').modal('show');
    });

    $('#bulkcancelForm').on('submit', function (e) {
        e.preventDefault();

        let remark = $(this).find('textarea[name="remark"]').val().trim();
        // $('#btnConfirmCancelBulk').prop('disabled', true);

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing comment',
                confirmButtonColor: '#28a745',
                text: 'Please state the comment or reason.',
            });
            $('#bulk_cancel_remark').addClass('border-error');
            return;
        }
        $('#bulk_cancel_remark').removeClass('border-error');

        $.ajax({
            url: 'fetch-s2w-section-bulk-action.php',
            type: 'POST',
            dataType: 'json', 
            data: {
                ids: Array.from(selectedIds),
                remark: remark,
                action : 'bulk_cancel'
            },
            success: function (r) {

                $('#btnConfirmCancelBulk').prop('disabled', false);

                if (r.status === 'success') {
                    $('#bulkcancelModal').modal('hide');

                    Swal.fire({
                        title: 'Success',
                        text: r.message,
                        icon: 'success',
                        iconColor: "#286912",
                        confirmButtonColor: '#28a745'
                    });
                    
                    // Refresh table or reload
                    table.ajax.reload();

                    selectedIds.clear();
                    $('#checkAll').prop('checked', false);
                    table.ajax.reload(null, false);
                    fetchTotalCounts();


                } else {
                    Swal.fire({
                        title: 'Error',
                        text: r.message || 'Unknown error',
                        icon: 'error'
                    });
                }
            },
            error: function (xhr) {
                $('#btnConfirmCancelBulk').prop('disabled', false);
                console.error(xhr.responseText);

                Swal.fire({
                    title: 'Error',
                    text: 'Server error occurred',
                    icon: 'error'
                });
            }
        });
    });

    </script>

</body>
</html>