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

        .form-control { background-color : #fff; }

        input[readonly] {
            background-color: #ffffff;   /* light gray */
            color: #495057;              /* dark text */
            /* cursor: not-allowed; */        /* show blocked cursor */
        }

        .select2-container--default .select2-selection--single {
            background-color: #fff !important;
            width: 100% !important;   /* match parent width */
        }

        .select2-container {
            width: 100% !important;
            max-width: 100%;
        }

        .select2-selection__rendered {
            white-space: nowrap !important;
            text-overflow: ellipsis !important;
            overflow: hidden !important;
        }

            @media (max-width: 768px) {
            .select2-container {
                font-size: 12px;
            }
            .select2-selection__rendered {
                max-width: 120px;
            }
        }

        /* related part */
        .dept-select + .select2-container {
            width: 140px !important;  /* adjust only customer select */
        }

        .part-select + .select2-container {
            width: 180px !important;  /* adjust only customer select */
        }

        .part_no + .select2-container {
            width: 260px !important;  /* adjust only customer select */
        }

        .part_name {
            width: 250px !important;  /* adjust only customer select */
        }

        .customer-select + .select2-container {
            width: 150px !important;  /* adjust only customer select */
        }

        .vendor-select + .select2-container {
            width: 160px !important;  /* adjust only customer select */
        }

        .input-error, .border-error {
            border: 1px solid #e74c3c !important;  /* Red border */
            background-color: #fff6f6;
        }

        #relatedPartDept tbody tr td:last-child {
            text-align: left !important; 
        }

        #relatedPartDept thead tr th:last-child{
            text-align: left !important;
        }

        #relatedPartVendor tbody tr td:last-child {
            text-align: left !important; 
        }

        #relatedPartVendor thead tr th:last-child{
            text-align: left !important;
        }

        #relatedPartCustomer tbody tr td:last-child {
            text-align: left !important; 
        }

        #relatedPartCustomer thead tr th:last-child{
            text-align: left !important;
        }
        
        /* Floating button back  */
        .back-button {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 9999;
            width: 36px;
            height: 36px;
            padding: 0;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 3px 8px rgba(0,0,0,0.15);
            background-color: #1d1e1eff;
            color: white;
        }
        .back-button:hover {
            background-color: #5b5e5dff;
            border-color: #5b5e5dff;
            color: white;
        }

        #lightgallery img {
            width: 100%;              /* fills its column */
            height: 200px;            /* fixed height thumbnail */
            object-fit: cover;        /* fill box, crop if needed */
            border-radius: 6px;       /* optional rounded corners */
            background: #fff;
            border: 1px solid #eee;
        }

        #lightgallery a {
            padding: 5px;         /* internal spacing around image */
        }

        textarea::placeholder {
            font-size: 11px; 
            color: #EDEBEB;      
        }

        /* Sub-section title style */
        .section-title-sub {
            background: #f8f9fa;      /* light background */
            border-left: 4px solid #b30000; /* blue left border */
            padding: 8px 12px;
            border-radius: 4px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 1rem;
            display: flex;
            align-items: center;
        }

        /* Outline buttons for uploads */
        .btn-outline-success, .btn-outline-primary {
            border-width: 1px;
            font-weight: 500;
            transition: 0.2s ease-in-out;
        }

        .btn-outline-success:hover {
            background-color: #28a745;
            color: #fff;
        }

        .btn-outline-primary:hover {
            background-color: #b30000;
            color: #fff;
        }

        .avatar-preview {
            position: relative;
            display: inline-block;
        }
    
        .remove-image-btn {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #181818;
            color: #fff;
            font-size: 15px;
            line-height: 20px;
            text-align: center;
            cursor: pointer;
            z-index: 10;
            border: 2px solid #fff; /* optional: white border for visibility */
            transition: background 0.2s, color 0.2s;
        }
        .remove-image-btn:hover {
            background: #B31236;
            color: #fff;
            border-color: #FAF7F9;
        }
        
        .qty_ok,
        .qty_ng {
            width: 80px !important;
            text-align: center;
        }

        #relatedPartDept input:disabled,
        #relatedPartDept select:disabled {
            background-color: #F0F2F0 !important;
            color: #60676E !important;
            border-color: #ddd !important;
        }

        #relatedPartVendor input:disabled,
        #relatedPartVendor select:disabled {
            background-color: #F0F2F0 !important;
            color: #60676E !important;
            border-color: #ddd !important;
        }

        #relatedPartCustomer input:disabled,
        #relatedPartCustomer select:disabled {
            background-color: #F0F2F0 !important;
            color: #60676E !important;
            border-color: #ddd !important;
        }

        button:disabled,
        .btn:disabled {
            opacity: 0.6 !important;
            cursor: not-allowed !important;
            filter: grayscale(0.3);
        }

        /* Custom header background */
        .accordion-header-bg-custom .accordion-button {
            background-color: #eeeeeeff;        /* light grey background */
            /* color: #222;                      text color */
            /* font-weight: 500;                 make it stand out */
        }

        /* When expanded */
        .accordion-header-bg-custom .accordion-button:not(.collapsed) {
            background-color: #D7DED7;        /* soft blue when open */
            color: #222;
            border-color : #D7DED7;
        }

        /* Remove Bootstrap shadow focus ring for cleaner look */
        .accordion-header-bg-custom .accordion-button:focus {
            box-shadow: none;
        }

        .bg-primary-light
        {
            background-color: #DEE0DE !important; 
        }

        .btnSaveRowDept,
        .btnSaveRowVdr {
            cursor: pointer !important;
        }

         .table-responsive {
            max-height: 320px;   /* adjust height as needed */
            overflow-y: auto;
        }

        .table-responsive {
            max-height: 300px;
            overflow-y: auto;
        }

        .table-responsive thead th {
            position: sticky;
            top: 0;
            background: #111;   /* match .thead-black */
            color: #fff;
            z-index: 2;
        }

        #searchRelatedPartDept, #searchRelatedPartVendor {
            font-size: 12px;   /* try 12px, 13px, 14px */
        }

        #relatedPartDept th:nth-child(1),
        #relatedPartDept td:nth-child(1) {
            position: sticky;
            left: 0;
        }

        /* Freeze first column */
        #relatedPartDept th:first-child,
        #relatedPartDept td:first-child {
            z-index: 2;
            /* background: #fff; */
        }

        #relatedPartDept thead th:first-child {
            z-index: 5;
        }
 
        #relatedPartVendor th:nth-child(1),
        #relatedPartVendor td:nth-child(1) {
            position: sticky;
            left: 0;
        }

        #relatedPartDept th:nth-child(1),
        #relatedPartDept td:nth-child(1) {
            position: sticky;
            left: 0;
        }

        /* Freeze first column */
        #relatedPartVendor th:first-child,
        #relatedPartVendor td:first-child {
            z-index: 2;
            /* background: #fff; */
        }

        #relatedPartVendor thead th:first-child {
            z-index: 5;
        }

        .select2-container--open {
            z-index: 9999 !important;
        }

        </style>

		<?php

        $eir_id = $_GET['erid'] ?? '';

        //get sr_id
        $stmt = $db_con->prepare("
            SELECT sr_id
            FROM inspection_sorting
            WHERE sr_ir_id = ? and sr_status != ?
        ");
        $stmt->bind_param("ii", $eir_id, $s_cancelled_id);
        $stmt->execute();
        $res = $stmt->get_result();
        $row = $res->fetch_assoc();

        $esr_id = $row['sr_id'];
        
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
                        <?=$side_menu7;?>
                    </div>
                </div>

                <div id="detailsPreview" >
                    <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                        <div class="accordion-item">
                        <h2 class="accordion-header accordion-header-primary" id="headingOne6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6">
                        <span class="accordion-header-icon"></span>
                            <span class="accordion-header-text"><?= $side_menu_material ?></span>
                        </button>
                        </h2>
                    </div>

                    <div id="collapseOne6" class="accordion__body collapse" aria-labelledby="accord-6One" data-bs-parent="#accordion-six">
                        <div class="accordion-body-text p-0">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <div class="row">                                        
                                        <div class="col-xl-4">                                             
                                           <div class="product-detail-content" id="material_product_detail">
                                            <!-- Material Details will be display here via AJAX -->    
                                            </div>
                                        </div>                                        
                                        <div class="col-xl-6">
                                            <h5 class="text-primary d-inline">Gallery</h5>
                                            <div class="row mt-4 sp4" id="lightgallery">
                                                <!-- Gallery loaded via AJAX -->
                                            </div>
                                        </div>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="card mb-4">
                    <div class="card-header border-0 ai-tabs-1">
                        <h4 class="card-title"></h4>
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item"><a href="#add-sorting-tab" onclick="window.location.href='ip-sorting-create.php?erid=<?=$eir_id?>'"  class="nav-link"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="p-1"> Sorting</span></a></li>
                            <li class="nav-item"><a href="#part-involve-tab"  class="nav-link active show"><i class="fa fa-list" aria-hidden="true"></i> <span class="p-1">Part Involve</span></a></li>
                        </ul>
                    </div>

                    <div class="tab-content" id="myTabContent">                      

                        <input type="hidden" id="hidden_ir_id" value="<?= $eir_id ?>">
                        <input type="hidden" id="hidden_sr_id" value="<?= $esr_id ?>">

                        <!-- Part Involve -->
                        <!-- 1. Department -->
                        <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-0 p-3">
                            <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                <i class="fa fa-building me-2 text-black"></i> RELATED LOOSE PART INVOLVE - In House Part (If any)
                            </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                <div class="accordion-body">

                                    <div class="d-flex justify-content-end mb-2">
                                        <input type="text"
                                            id="searchRelatedPartDept"
                                            class="form-control form-control-sm w-25"
                                            placeholder="Search">
                                    </div>

                                    <div class="table-responsive mb-2">
                                        <table class="display table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartDept">
                                            <colgroup>
                                                <col style="width: 15%;">
                                                <col style="width: 20%;">
                                                <col style="width: 18%;">
                                                <col style="width: 35%;">
                                                <col style="width: 8%;">
                                                <col style="width: 8%;">
                                                <col style="width: 8%;">
                                            </colgroup>
                                            <thead class="thead-black">
                                                <tr>
                                                    <th>Related Dept</th>
                                                    <th>Type of Part </th>
                                                    <th>Part No</th>
                                                    <th>Part Name</th>
                                                    <th>QTY OK</th>
                                                    <th>QTY NG</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    <button type="button" id="btnAddRowDept" class="btn btn-primary btn-sm mt-2">+ Add New</button>
                                    
                                </div>
                            </div>
                        </div>

                        <!-- 2. Vendor -->
                        <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-0 p-3">
                            <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                <i class="fa fa-truck me-2 text-black"></i> RELATED LOOSE PART INVOLVE - Tier 2 (If any)
                            </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                <div class="accordion-body">   
                                    
                                    <div class="d-flex justify-content-end mb-2">
                                        <input type="text"
                                            id="searchRelatedPartVendor"
                                            class="form-control form-control-sm w-25"
                                            placeholder="Search">
                                    </div>

                                    <div class="table-responsive mb-2">
                                        <table class="isplay table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartVendor">
                                            <colgroup>
                                                <col style="width: 15%;">
                                                <col style="width: 20%;">
                                                <col style="width: 18%;">
                                                <col style="width: 35%;">
                                                <col style="width: 10%;">
                                                <col style="width: 10%;">
                                                <col style="width: 8%;">
                                            </colgroup>
                                            <thead class="thead-black">
                                                <tr>
                                                    <th>Related Vendor</th>
                                                    <th>Type of Part </th>
                                                    <th>Part No</th>
                                                    <th>Part Name</th>
                                                    <th>QTY OK</th>
                                                    <th>QTY NG</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                    <button type="button" id="btnAddRowVdr" class="btn btn-primary btn-sm mt-2">+ Add New</button>

                                </div>
                            </div>
                        </div>

                        <!-- 3. Customer -->
                        <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-0 p-3">
                            <h2 class="accordion-header" id="headingFour">
                            <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                <i class="fa fa-users me-2 text-black"></i> FINISHED GOODS PART INVOLVE - Customer (If any)
                            </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <div class="table-responsive mb-2">
                                        <table class="isplay table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartCustomer" style="width:600px">
                                            <colgroup>
                                                <col style="width: 35%;">
                                                <col style="width: 10%;">
                                                <col style="width: 10%;">
                                                <col style="width: 8%;">
                                            </colgroup>
                                            <thead class="thead-black">
                                                <tr>
                                                    <th>Related Customer</th>
                                                    <th>QTY OK</th>
                                                    <th>QTY NG</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div> 
                    </div> 
                </div> 

                <!-- Modal for image zoom -->
                <div class="modal fade" id="imgZoomModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background: transparent; border: none;">
                            <img src="" id="zoomedImg" class="img-fluid rounded shadow" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                        </div>
                    </div>
                </div>                                  
                            
                <a href="javascript:void(0);" class="btn btn-primary btn-lg rounded-circle back-button" id="btnBack" title="Go Back">
                    <i class="fa fa-arrow-left"></i>
                </a>
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

    <script src="vendor/wnumb/wNumb.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="js/highlight.min.js"></script>    
    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>

    <script>
    function initSelect2(row) {
        row.find("select").select2({
            width: '100%'   // makes Select2 stretch to <td> width
        });
    }

    // Initialize for first row on page load
    $(document).ready(function () {
        initSelect2($("#relatedPartDept tbody tr"));
    });

    $(document).ready(function () {
        initSelect2($("#relatedPartVendortbody tr"));
    });

    </script>

    <script>
    document.getElementById('btnBack').addEventListener('click', function () {
        window.location.href = "ip-sorting.php";
    });
    </script>

    <script>
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // run on page load
    document.addEventListener("DOMContentLoaded", function(){
        initTooltips();
    });
    </script>

    <script>

    // Zoom images
    $(document).on('click', '.zoomable-img', function() {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        console.log("Clicked:", imgSrc);
        $('#zoomedImage').attr('src', imgSrc);
        const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        modal.show();
    });

    </script>

    <script>
      
    // Load mateiral details
    function loadMaterialDetails(irid) {
        $.ajax({
            url: 'fetch-material-details.php',
            type: 'POST',
            dataType: 'json',
            data: { ir_id: irid },
            success: function (res) {
                // Inject images
                $('#lightgallery').html(res.gallery_html);

                // Inject details
                $('#material_product_detail').html(res.detail_html);

                // Re-init lightGallery
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

    // Link
    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const irid = urlParams.get('erid');
        if (irid) {
            loadMaterialDetails(irid);
        }
    });

    </script>

    <script>

    // VALIDATION
    function showValidationError(row, message, fieldSelector, isSelect2 = false) {

        Swal.fire({
            icon: 'warning',
            title: 'Error',
            text: message,
            iconColor: "#286912",
            confirmButtonText: 'OK',
            confirmButtonColor: '#198754'
        });

        // Clear previous errors
        row.find('.border-error').removeClass('border-error');

        if (isSelect2) {
            row.find(fieldSelector)
            .next('.select2')
            .find('.select2-selection')
            .addClass('border-error');
        } else {
            row.find(fieldSelector).addClass('border-error');
        }
    }

    </script>

    <script>

    // Searching
    function applyRelatedDeptSearch() {

        let keyword = $("#searchRelatedPartDept").val().toLowerCase().trim();

        $("#relatedPartDept tbody tr").each(function () {

            let row = $(this);

            let dept     = row.find(".related_dept option:selected").text().toLowerCase();
            let type     = row.find(".type_part option:selected").text().toLowerCase();
            let partNo   = row.find(".part_no option:selected").text().toLowerCase();
            let partName = row.find(".part_name").val()?.toLowerCase() || "";

            let combined = `${dept} ${type} ${partNo} ${partName}`;

            row.toggle(combined.includes(keyword));
        });
    }

    $(document).on("keyup", "#searchRelatedPartDept", function () {
        applyRelatedDeptSearch();
    });

    function applyRelatedVendorSearch() {

        let keyword = $("#searchRelatedPartVendor").val().toLowerCase().trim();

        $("#relatedPartVendor tbody tr").each(function () {

            let row = $(this);

            let dept     = row.find(".related_vdr option:selected").text().toLowerCase();
            let type     = row.find(".type_part option:selected").text().toLowerCase();
            let partNo   = row.find(".part_no option:selected").text().toLowerCase();
            let partName = row.find(".part_name").val()?.toLowerCase() || "";

            let combined = `${dept} ${type} ${partNo} ${partName}`;

            row.toggle(combined.includes(keyword));
        });
    }

    $(document).on("keyup", "#searchRelatedPartVendor", function () {
        applyRelatedVendorSearch();
    });

    </script>

    <!--///////////////////////////////////////////////////////////////////////////-->
    <!-- #Related Part Department -->
    <script>

    // Save related loose part involve
    $(document).ready(function () {

        // Add new row
        $(document).on("click", "#btnAddRowDept", function () {

            let tbody = $("#relatedPartDept tbody");

            if ($(".btnSaveRowDept").length > 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Unsaved Record",
                    text: "Please save the existing row before adding a new one.",
                    iconColor: "#286912",
                    confirmButtonColor: "#198754"
                });
                return;
            }

            // Add new row
            let newRow = `
                <tr>
                    <td>
                        <select class="form-control related_dept select2 dept-select">
                            <option value="">Select Dept</option>
                            <?php
                            $q = $db_con->query("SELECT rd_dept_id, rd_dept_name FROM related_departments WHERE rd_dept_status='AC'");
                            while($r = $q->fetch_assoc()){
                                echo "<option value='{$r['rd_dept_id']}'>{$r['rd_dept_name']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control type_part select2">
                            <option value="">Select Type</option>
                            <?php
                            $q = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status='AC'");
                            while($r = $q->fetch_assoc()){
                                echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control part_no select2 partno-select">
                            <option value="">Part No</option>
                        </select>                        
                    </td>
                    <td>
                        <input type="text" class="form-control part_name" value="" readonly data-bs-toggle="tooltip" title="">
                    </td>
                    <td><input type="number" class="form-control qty_ok" min="0" value="" style="width:70px;"></td>
                    <td><input type="number" class="form-control qty_ng" min="0" value="" style="width:70px;"></td>
                    <td>
                        <button type="button" class="btn btn-black btn-sm btnSaveRowDept" data-bs-toggle="tooltip" title="Add record"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </td>
                </tr>
            `;

            tbody.append(newRow);

            // Re-init select2 + tooltip
            let addedRow = tbody.find("tr:last");
            addedRow.find(".select2").select2({ width: "100%" });
            addedRow.find("[data-bs-toggle='tooltip']").tooltip();

            // Fetch Part No dynamically
            // let ir_id = $("#hidden_ir_id").val();
            // $.post("get-partno.php", { ir_id: ir_id }, function(data){
            //     addedRow.find(".part_no").html(data).trigger("change");
            // });

        });

        // Load Part Name when Part No changes
        $(document).on("change", ".part_no", function () {
            const partNoId = $(this).val();
            const partNameInput = $(this).closest("tr").find(".part_name");

            if (partNoId) {
                $.post("get-partname.php", { part_no_id: partNoId }, function (data) {
                    // update value and tooltip
                    partNameInput.val(data);
                    partNameInput.tooltip('dispose'); // remove any old tooltip
                    partNameInput.attr("title", data); // update title attribute
                    const tooltip = new bootstrap.Tooltip(partNameInput[0], { placement: 'top', trigger: 'manual' }); 
                    tooltip.setContent({ '.tooltip-inner': data }); // refresh tooltip content
                    tooltip.show(); // show the correct new text
                });
            } else {
                partNameInput
                    .val("")
                    .attr("title", "")
                    .tooltip('dispose'); // remove tooltip if cleared
            }
        });

        // Save row
        $(document).on("click", ".btnSaveRowDept", function(){

            let row = $(this).closest("tr");

            let related_dept = row.find(".related_dept").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

            // Clear old errors
            row.find('.border-error').removeClass('border-error');

            if(!related_dept) {
                showValidationError(row, "Related Department is required.", ".related_dept", true);
                return;
            }

            if(!type_part) {
                showValidationError(row, "Type of Part is required.", ".type_part", true);
                return;
            }

            if(!part_no) {
                showValidationError(row, "Part No is required.", ".part_no", true);
                return;
            }
            
            if(!part_name) {
                showValidationError(row, "Part Name is required.", ".part_name");
                return;
            }

            if (qty_ok === "" || qty_ok < 0) {
                showValidationError(row, "QTY OK must be 0 or greater.", ".qty_ok");
                return;
            }

            if (qty_ng === "" || qty_ng < 0) {
                showValidationError(row, "QTY NG must be 0 or greater.", ".qty_ng");
                return;
            }

            Swal.fire({
                title: "Save record?",
                text: "Save this related part?",
                icon: "question",
                iconColor: "#286912",
                showCancelButton: true,
                confirmButtonText: "Yes, Save",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#198754"
            }).then((result) => {

                if (result.isConfirmed) {

                    $.ajax({
                        url: "fetch-ip-related-part-dept.php",
                        method: "POST",
                        dataType: "json",
                        data: {  ir_id: $("#hidden_ir_id").val(), 
                            sr_id: $("#hidden_sr_id").val(), 
                            related_dept : related_dept, 
                            type_part : type_part, 
                            part_no : part_no, 
                            part_name : part_name, 
                            qty_ok : qty_ok, 
                            qty_ng : qty_ng, 
                            action: 'add_related_part' },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
                                        iconColor: "#286912",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                                
                                // reload full table from server instead of modifying row manually
                                loadRelatedDept($("#hidden_ir_id").val());

                            }
                            else if(res.status === "duplicate"){
                                Swal.fire({
                                        icon: "warning",
                                        iconColor: "#286912",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {
                                 Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });

        });

        // Update row
        $(document).on("click", ".btnUpdateRowDept", function(){

            let row = $(this).closest("tr");            
            let row_id = row.data("srp_id");

            let related_dept = row.find(".related_dept").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

            // Clear old errors
            row.find('.border-error').removeClass('border-error');

            if(!related_dept) {
                showValidationError(row, "Related Department is required.", ".related_dept", true);
                return;
            }

            if(!type_part) {
                showValidationError(row, "Type of Part is required.", ".type_part", true);
                return;
            }

            if(!part_no) {
                showValidationError(row, "Part No is required.", ".part_no", true);
                return;
            }
            
            if(!part_name) {
                showValidationError(row, "Part Name is required.", ".part_name");
                return;
            }

            if (qty_ok === "" || qty_ok < 0) {
                showValidationError(row, "QTY OK must be 0 or greater.", ".qty_ok");
                return;
            }

            if (qty_ng === "" || qty_ng < 0) {
                showValidationError(row, "QTY NG must be 0 or greater.", ".qty_ng");
                return;
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-ip-related-part-dept.php",
                        method: "POST",
                        dataType: "json",
                        data: { action: 'update_related_part', row_id: row_id, ir_id: $("#hidden_ir_id").val(), sr_id: $("#hidden_sr_id").val(), related_dept : related_dept, type_part : type_part, part_no : part_no, 
                                part_name : part_name, qty_ok : qty_ok, qty_ng : qty_ng },
                        success: function(res) {
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "success",
                                        iconColor: "#286912",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else if(res.status === "duplicate"){

                                Swal.fire({
                                        icon: "warning",
                                        iconColor: "#286912",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });
        });

        // Delete row
        $(document).on("click", ".btnDeleteRowDept", function(){
            let row = $(this).closest("tr");
            let row_id = row.data("srp_id"); // get srp_id if exists

            Swal.fire({
                title: "Are you sure?",
                text: row_id ? "This will delete the record permanently." : "This row will be removed.",
                icon: "warning",
                iconColor: "#286912",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (row_id) {
                        // Call PHP to delete saved record
                        $.post("fetch-ip-related-part-dept.php", {
                            action: "delete_related_part",
                            row_id: row_id
                        }, function(res){
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "succes",
                                        iconColor: "#286912",
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();

                            } else {
                                 Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        }, "json");
                    } else {
                        // Just remove unsaved row
                        row.remove();
                    }
                }
            });
        });

        function loadRelatedDept(ir_id) {
            const sr_id = $("#hidden_sr_id").val();

            $.ajax({
                url: "fetch-ip-related-part-dept.php",
                type: "POST",
                dataType: "json",
                data: { action: "get_related_part", ir_id, sr_id },
                success: function (res) {
                    $("#relatedPartDept tbody").html(res.html);
                    $(".select2").select2({ width: "100%" });
                    $("#relatedPartDept [data-bs-toggle='tooltip']").tooltip();

                    // Disable all fields if sorting_status == 9 or 11
                    if (+res.sorting_status === 9 || +res.sorting_status === 11) {
                        // Disable all form inputs & selects
                        $("#relatedPartDept")
                            .find("input, select")
                            .prop("disabled", true)
                            .css({ cursor: "not-allowed", opacity: 0.8 });

                        // Disable buttons (not hide them)
                        $("#relatedPartDept .btnSaveRowDept, #relatedPartDept .btnUpdateRowDept, #relatedPartDept .btnDeleteRowDept, #btnAddRowDept")
                            .prop("disabled", true)
                            .css({
                                opacity: 0.6,
                                cursor: "not-allowed",
                                pointerEvents: "none"
                        });

                        // Hide "+ Add New" button only
                        $("#btnAddRowDept").addClass("d-none");

                    } else {
                        // Enable everything back for editable mode
                        $("#relatedPartDept")
                            .find("input, select, button")
                            .prop("disabled", false)
                            .css({ cursor: "auto", opacity: 1 });
                    }
                    
                    // Re-apply search after table reload
                    applyRelatedDeptSearch();

                },
                error: function (xhr) {
                    console.error("Reload failed:", xhr.status, xhr.responseText);
                },
            });

            
        }

        $(function () {
            const ir_id = $("#hidden_ir_id").val();
            if (ir_id) loadRelatedDept(ir_id);
        });

    });

    // on change dept to display part no
    $(document).on('change', '.dept-select', function () {

        let deptId = $(this).val();
        let row    = $(this).closest('tr');
        let partSelect = row.find('.partno-select');

        let ir_id = $('#hidden_ir_id').val();

        // Reset Part No
        partSelect.html('<option value="">Part No</option>').trigger('change');

        if (!deptId || !ir_id) return;

        $.ajax({
            url: 'find-part-dept.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_part_by_dept',
                dept_id: deptId,
                ir_id: ir_id
            },
            success: function (res) {

                if (res.status === 'success') {
                    partSelect.html(res.options).trigger('change');
                } else {
                    partSelect.html('<option value="">No Part Found</option>');
                }
            },
            error: function () {
                partSelect.html('<option value="">Error loading</option>');
            }
        });
    });

    </script>

    <!--///////////////////////////////////////////////////////////////////////////-->
    <!-- Related Part Vendor -->
    <script>

    // Save related loose part involve
    $(document).ready(function () {

        // Add new row
        $(document).on("click", "#btnAddRowVdr", function () {

            let tbody = $("#relatedPartVendor tbody");

            if ($(".btnSaveRowVdr").length > 0) {
                Swal.fire({
                    icon: "warning",
                    title: "Unsaved Record",
                    text: "Please save the existing row before adding a new one.",
                    iconColor: "#286912",
                    confirmButtonColor: "#198754"
                });
                return;
            }

            // Add new row
            let newRow = `
                <tr>
                    <td>
                        <select class="form-control related_vdr select2 vendor-select">
                            <option value="">Select Vendor</option>
                            <?php
                            $q = $db_con->query("SELECT rv_vendor_id, rv_vendor_name FROM related_vendors WHERE rv_vendor_status='AC'");
                            while($r = $q->fetch_assoc()){
                                echo "<option value='{$r['rv_vendor_id']}'>{$r['rv_vendor_name']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control type_part select2">
                            <option value="">Select Type</option>
                            <?php
                            $q = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status='AC'");
                            while($r = $q->fetch_assoc()){
                                echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control part_no select2 partno-select">
                            <option value="">Part No</option>
                        </select>                        
                    </td>
                    <td>
                        <input type="text" class="form-control part_name" value="" readonly data-bs-toggle="tooltip" title="">
                    </td>
                    <td><input type="number" class="form-control qty_ok" min="0" value="" style="width:70px;"></td>
                    <td><input type="number" class="form-control qty_ng" min="0" value="" style="width:70px;"></td>
                    <td>
                        <button type="button" class="btn btn-black btn-sm btnSaveRowVdr" data-bs-toggle="tooltip" title="Add record"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </td>
                </tr>
            `;

            tbody.append(newRow);

            // Re-init select2 + tooltip
            let addedRow = tbody.find("tr:last");
            addedRow.find(".select2").select2({ width: "100%" });
            addedRow.find("[data-bs-toggle='tooltip']").tooltip();

            // Fetch Part No dynamically
            // let ir_id = $("#hidden_ir_id").val();
            // $.post("get-partno.php", { ir_id: ir_id }, function(data){
            //     addedRow.find(".part_no").html(data).trigger("change");
            // });

        });

        // Load Part Name when Part No changes
        $(document).on("change", ".part_no", function(){
            let partNoId = $(this).val();
            let partNameInput = $(this).closest("tr").find(".part_name");

            if(partNoId){
                $.post("get-partname.php", { part_no_id: partNoId }, function(data){
                    // data now contains the part description text, not <input>
                    partNameInput.val(data);

                    partNameInput.attr("title", data)
                                .tooltip('dispose')   // destroy old tooltip
                                .tooltip();           // re-init new tooltip

                });
            } else {
                partNameInput.val("");

                partNameInput.val("").attr("title", "")
                     .tooltip('dispose'); // remove tooltip if empty
            }
        });

        // Save row
        $(document).on("click", ".btnSaveRowVdr", function(){

            let row = $(this).closest("tr");

            let related_vdr = row.find(".related_vdr").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

            // Clear old errors
            row.find('.border-error').removeClass('border-error');

            if(!related_vdr) {
                showValidationError(row, "Related Vendor is required.", ".related_vdr", true);
                return;
            }

            if(!type_part) {
                showValidationError(row, "Type of Part is required.", ".type_part", true);
                return;
            }

            if(!part_no) {
                showValidationError(row, "Part No is required.", ".part_no", true);
                return;
            }
            
            if(!part_name) {
                showValidationError(row, "Part Name is required.", ".part_name", true);
                return;
            }

            if (qty_ok === "" || qty_ok < 0) {
                showValidationError(row, "QTY OK must be 0 or greater.", ".qty_ok");
                return;
            }

            if (qty_ng === "" || qty_ng < 0) {
                showValidationError(row, "QTY NG must be 0 or greater.", ".qty_ng");
                return;
            }

            Swal.fire({
            //title: "Are you sure?",
            text: "Save this related part?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-ip-related-part-vendor.php",
                        method: "POST",
                        dataType: "json",
                        data: {  ir_id: $("#hidden_ir_id").val(), 
                            sr_id: $("#hidden_sr_id").val(), 
                            related_vdr : related_vdr, 
                            type_part : type_part, 
                            part_no : part_no, 
                            part_name : part_name, 
                            qty_ok : qty_ok, 
                            qty_ng : qty_ng, 
                            action: 'add_related_part' 
                        },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
                                        iconColor: "#286912",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                // reload full table from server instead of modifying row manually
                                loadRelatedVdr($("#hidden_ir_id").val());
                            }
                            else if(res.status === "duplicate"){
                                Swal.fire({
                                        icon: "warning",
                                        iconColor: "#286912",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {
                                 Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });

        });

        // Update row
        $(document).on("click", ".btnUpdateRowVdr", function(){

            let row = $(this).closest("tr");
            let row_id = row.data("srp_id");

            let related_vdr = row.find(".related_vdr").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

            // Clear old errors
            row.find('.border-error').removeClass('border-error');

            if(!related_vdr) {
                showValidationError(row, "Related Vendor is required.", ".related_vdr", true);
                return;
            }

            if(!type_part) {
                showValidationError(row, "Type of Part is required.", ".type_part", true);
                return;
            }

            if(!part_no) {
                showValidationError(row, "Part No is required.", ".part_no", true);
                return;
            }
            
            if(!part_name) {
                showValidationError(row, "Part Name is required.", ".part_name", true);
                return;
            }

            if (qty_ok === "" || qty_ok < 0) {
                showValidationError(row, "QTY OK must be 0 or greater.", ".qty_ok");
                return;
            }

            if (qty_ng === "" || qty_ng < 0) {
                showValidationError(row, "QTY NG must be 0 or greater.", ".qty_ng");
                return;
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-ip-related-part-vendor.php",
                        method: "POST",
                        dataType: "json",
                        data: { action: 'update_related_part', 
                            row_id: row_id, 
                            ir_id: $("#hidden_ir_id").val(), 
                            related_vdr : related_vdr, 
                            type_part : type_part, 
                            part_no : part_no, 
                            part_name : part_name, 
                            qty_ok : qty_ok, 
                            qty_ng : qty_ng 
                        },
                        success: function(res) {
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "success",
                                        iconColor: "#286912",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else if(res.status === "duplicate"){

                                Swal.fire({
                                        icon: "warning",
                                        iconColor: "#286912",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });
        });

        // Delete row
        $(document).on("click", ".btnDeleteRowVdr", function(){
            let row = $(this).closest("tr");
            let row_id = row.data("srp_id"); // get srp_id if exists

            Swal.fire({
                title: "Are you sure?",
                text: row_id ? "This will delete the record permanently." : "This row will be removed.",
                icon: "warning",
                iconColor: "#286912",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (row_id) {
                        // Call PHP to delete saved record
                        $.post("fetch-ip-related-part-vendor.php", {
                            action: "delete_related_part",
                            row_id: row_id
                        }, function(res){
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "succes",
                                        iconColor: "#286912",
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();

                            } else {
                                 Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        }, "json");
                    } else {
                        // Just remove unsaved row
                        row.remove();
                    }
                }
            });
        });

        function loadRelatedVdr(ir_id) {
            const sr_id = $("#hidden_sr_id").val();

            $.ajax({
                url: "fetch-ip-related-part-vendor.php",
                type: "POST",
                dataType: "json",
                data: { action: "get_related_part", ir_id, sr_id },
                success: function (res) {
                    $("#relatedPartVendor tbody").html(res.html);
                    $(".select2").select2({ width: "100%" });
                    $("#relatedPartVendor [data-bs-toggle='tooltip']").tooltip();

                    // Disable all fields if sorting_status == 9 or 11
                    if (+res.sorting_status === 9 || +res.sorting_status === 11) {
                        // Disable all form inputs & selects
                        $("#relatedPartVendor")
                            .find("input, select")
                            .prop("disabled", true)
                            .css({ cursor: "not-allowed", opacity: 0.8 });

                        // Disable buttons (not hide them)
                        $("#relatedPartVendor .btnSaveRowVdr, #relatedPartVendor .btnUpdateRowVdr, #relatedPartVendor .btnDeleteRowVdr, #btnAddRowVdr")
                            .prop("disabled", true)
                            .css({
                                opacity: 0.6,
                                cursor: "not-allowed",
                                pointerEvents: "none"
                        });

                        // Hide "+ Add New" button only
                        $("#btnAddRowVdr").addClass("d-none");

                    } else {
                        // Enable everything back for editable mode
                        $("#relatedPartVendor")
                            .find("input, select, button")
                            .prop("disabled", false)
                            .css({ cursor: "auto", opacity: 1 });
                    }

                    // Re-apply search after table reload
                    applyRelatedDeptVendor();

                },
                error: function (xhr) {
                    console.error("Reload failed:", xhr.status, xhr.responseText);
                },
            });
   
        }

        $(function () {
            const ir_id = $("#hidden_ir_id").val();
            if (ir_id) loadRelatedVdr(ir_id);
        });  
       
    });

    // on change dept to display part no
    $(document).on('change', '.vendor-select', function () {

        let vdrId = $(this).val();
        let row    = $(this).closest('tr');
        let partSelect = row.find('.partno-select');

        let ir_id = $('#hidden_ir_id').val();

        // Reset Part No
        partSelect.html('<option value="">Part No</option>').trigger('change');

        if (!vdrId || !ir_id) return;

        $.ajax({
            url: 'find-part-vendor.php',
            type: 'POST',
            dataType: 'json',
            data: {
                action: 'get_part_by_vendor',
                vendor_id: vdrId,
                ir_id: ir_id
            },
            success: function (res) {

                if (res.status === 'success') {
                    partSelect.html(res.options).trigger('change');
                } else {
                    partSelect.html('<option value="">No Part Found</option>');
                }
            },
            error: function () {
                partSelect.html('<option value="">Error loading</option>');
            }
        });
    });

    </script>

    <!--///////////////////////////////////////////////////////////////////////////-->
    <!-- Related Part Customer -->
    <script>

    // Save related loose part involve
    $(document).ready(function () {

        // Save row
        $(document).on("click", ".btnSaveRowCust", function(){

            let row = $(this).closest("tr");

            let related_cust = row.find(".related_cust").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

            // Clear old errors
            row.find('.border-error').removeClass('border-error');

            if (qty_ok === "" || qty_ok < 0) {
                showValidationError(row, "QTY OK must be 0 or greater.", ".qty_ok");
                return;
            }

            if (qty_ng === "" || qty_ng < 0) {
                showValidationError(row, "QTY NG must be 0 or greater.", ".qty_ng");
                return;
            }

            Swal.fire({
            //title: "Are you sure?",
            text: "Save this finished goods part?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-ip-related-part-cust.php",
                        method: "POST",
                        dataType: "json",
                        data: {  ir_id: $("#hidden_ir_id").val(), sr_id: $("#hidden_sr_id").val(), related_cust : related_cust, qty_ok : qty_ok, qty_ng : qty_ng, action: 'add_finishgoods_part' },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
                                        iconColor: "#286912",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                // reload full table from server instead of modifying row manually
                                loadFinishGoodsPart($("#hidden_ir_id").val());
                            }
                            else {
                                 Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });

        });

        // Update row
        $(document).on("click", ".btnUpdateRowCust", function(){

            let row = $(this).closest("tr");
            let row_id = row.data("srp_id");

            let qty_ok  = row.find(".qty_ok").val();
            let qty_ng  = row.find(".qty_ng").val();

           // Clear old errors
            row.find('.border-error').removeClass('border-error');

            if (qty_ok === "" || qty_ok < 0) {
                showValidationError(row, "QTY OK must be 0 or greater.", ".qty_ok");
                return;
            }

            if (qty_ng === "" || qty_ng < 0) {
                showValidationError(row, "QTY NG must be 0 or greater.", ".qty_ng");
                return;
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-ip-related-part-cust.php",
                        method: "POST",
                        dataType: "json",
                        data: { action: 'update_finishgoods_part', row_id: row_id, ir_id: $("#hidden_ir_id").val(), qty_ok : qty_ok, qty_ng : qty_ng },
                        success: function(res) {
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "success",
                                        iconColor: "#286912",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });
        });

        // Delete row
        $(document).on("click", ".btnDeleteRowCust", function(){
            let row = $(this).closest("tr");
            let row_id = row.data("srp_id"); // get srp_id if exists

            Swal.fire({
                title: "Are you sure?",
                text: row_id ? "This will delete the record permanently." : "This row will be removed.",
                icon: "warning",
                iconColor: "#286912",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (row_id) {
                        // Call PHP to delete saved record
                        $.post("fetch-ip-related-part-cust.php", {
                            action: "delete_related_part",
                            row_id: row_id
                        }, function(res){
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "succes",
                                        iconColor: "#286912",
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();
                                
                            } else {
                                 Swal.fire({
                                        icon: "Error",
                                        iconColor: "#286912",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        }, "json");

                        // reload full table from server instead of modifying row manually
                        loadFinishGoodsPartAftrDelete($("#hidden_ir_id").val());
                        
                    } else {
                        // Just remove unsaved row
                        row.remove();
                    }
                }
            });
        });

    });

    //Fetch record
    $(document).ready(function () {
        const ir_id = $("#hidden_ir_id").val();
        const sr_id = $("#hidden_sr_id").val();

        $.ajax({
            url: "fetch-ip-related-part-cust.php",
            type: "POST",
            dataType: "json", // Expect proper JSON
            data: {
                action: "get_finishgoods_part",
                ir_id: ir_id,
                sr_id: sr_id
            },
            success: function (res) {
                $("#relatedPartCustomer tbody").html(res.html);
                $("#relatedPartCustomer .select2").select2({ width: "100%" });
                $("#relatedPartCustomer [data-bs-toggle='tooltip']").tooltip();

                //  Disable all fields and hide Add button if approved
                if (+res.sorting_status === 4 || +res.sorting_status === 10 ) {
                    // Disable all form inputs & selects
                    $("#relatedPartCustomer")
                        .find("input, select")
                        .prop("disabled", true)
                        .css({ cursor: "not-allowed", opacity: 0.8 });

                    // Disable buttons (not hide them)
                    $("#relatedPartCustomer .btnSaveRowCust, #relatedPartCustomer .btnUpdateRowCust, #relatedPartCustomer .btnDeleteRowCust, #btnAddRowCust")
                        .prop("disabled", true)
                        .css({
                            opacity: 0.6,
                            cursor: "not-allowed",
                            pointerEvents: "none"
                    });

                } else {
                    // Enable everything back for editable mode
                    $("#relatedPartCustomer")
                        .find("input, select, button")
                        .prop("disabled", false)
                        .css({ cursor: "pointer", opacity: 1 });
                }

            },
            error: function (xhr) {
                console.error("Customer load failed:", xhr.status, xhr.responseText);
            }
        });
    });

    function loadFinishGoodsPart(ir_id) {
        const sr_id = $("#hidden_sr_id").val();

        $.ajax({
            url: "fetch-ip-related-part-cust.php",
            method: "POST",
            dataType: "json", //  Expect JSON, not HTML
            data: { action: "get_finishgoods_part", ir_id: ir_id, sr_id: sr_id },
            success: function (res) {
                $("#relatedPartCustomer tbody").html(res.html);

                if (+res.sorting_status === 9 || +res.sorting_status === 11) {
                    // Disable all form inputs & selects
                    $("#relatedPartCustomer")
                        .find("input, select")
                        .prop("disabled", true)
                        .css({ cursor: "not-allowed", opacity: 0.8 });

                    // Disable buttons (not hide them)
                    $("#relatedPartCustomer .btnSaveRowCust, #relatedPartCustomer .btnUpdateRowCust, #relatedPartCustomer .btnDeleteRowCust, #btnAddRowCust")
                        .prop("disabled", true)
                        .css({
                            opacity: 0.6,
                            cursor: "not-allowed",
                            pointerEvents: "none"
                    });

                    // Hide "+ Add New" button only
                    $("#btnAddRowCust").addClass("d-none");

                } else {
                    // Enable everything back for editable mode
                    $("#relatedPartCustomer")
                        .find("input, select, button")
                        .prop("disabled", false)
                        .css({ cursor: "auto", opacity: 1 });
                }
            },
            error: function (xhr) {
                console.error("Reload failed:", xhr.status, xhr.responseText);
            }
        });
    }

    function loadFinishGoodsPartAftrDelete(ir_id) {
        $.ajax({
            url: "fetch-ip-related-part-cust.php",
            method: "POST",
            data: { action: "get_finishgoods_part_aftr_delete", ir_id: ir_id },
            dataType: "html", // expect raw HTML rows
            success: function(html) {
                console.log("Reloaded HTML:", html);
                $("#relatedPartCustomer tbody").html(html);
            },
            error: function(xhr) {
                console.error("Reload failed:", xhr.status, xhr.responseText);
            }
        });
    }

    </script>

    <script>

    // Add new defect
    $('#btnDraft').on('click', function() {

        // 1. Defect type required
        const defectType = $('#fd_defectType').val();

        // 1. At least one defect photo required
        if (defectFiles.length === 0) {
            alert('Please add at least one Defect Photo!');
            $('label[for="defect_photo"]').addClass('border-error');
            return;
        }
        // 2.  At least one comparison photos required
        if (compareFiles.length === 0) {
            alert('Please add at least one Comparison Photo!');
            $('label[for="compare_photo"]').addClass('border-error');
            return;
        }

        // Get from hidden inputs or fields on your page
        let pallet     = $('.ipallet').val();
        let result     = $('.resultSelect').val();
        let model      = $('.cs_model').val();
        let type       = $('.cs_type').val();
        let material   = $('.cs_material').val();
        let shift      = $('#hidden_shift').val();

        // ----------- Gather FormData ----------- //
        let formData = new FormData();

        // Defect info
        formData.append('fd_defectType', defectType);
        $('input[name="fd_area[]"]:checked').each(function() {
            formData.append('fd_area[]', $(this).val());
        });

        // Append images
        defectFiles.forEach(file => formData.append('defect_photo[]', file));
        compareFiles.forEach(file => formData.append('compare_photo[]', file));

        // Main info for inspection record
        formData.append('pallet', pallet);
        formData.append('result', result);
        formData.append('model', model);
        formData.append('type', type);
        formData.append('material', material);
        formData.append('shift', shift);

        // AJAX example:
        $.ajax({
            url: 'inspection-rcd-defect-add.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {

                if (!response.success) {
                    alert('Failed to save!');
                    return;
                }

                //AFTER SAVING NG -> fetch latest pallet from DB
                $.ajax({
                    url: 'get-latest-pallet.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { model, type, material, shift }, // include shift_date if your PHP uses it
                    success: function (res) {

                    const nextPallet = res.latest_pallet ? (parseInt(res.latest_pallet, 10) + 1) : 1;
                    $('.ipallet').val(nextPallet);     // show next pallet
                    $('.resultSelect').val('');        // reset result to "Choose"
                    $('#Add_NG').slideUp();            // hide NG panel

                    // clear previews/arrays so the next NG starts clean
                    defectFiles = [];
                    compareFiles = [];

                    //Reset fields                 
                    $('#fd_defectType').val('').trigger('change'); 
                    $('.areaCheck').removeAttr('checked').prop('checked', false);
                    $('#defect_photo_preview').empty();
                    $('#compare_photo_preview').empty();                    
                    $('.resultSelect').val('').trigger('change');                    

                    // alert('Defect added successfully.');

                    if (response.success) {
                        // SweetAlert2 for success message only
                        Swal.fire({
                            icon: 'success',
                            iconColor: "#286912",
                            title: 'Saved!',
                            text: 'Defect added successfully.',
                            timer: 3000,
                            showConfirmButton: false
                        });

                        reloadTable();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
                            title: 'Oops...',
                            text: res.msg || 'Failed to add defect.',
                        });
                    }  

                },
                error: function () { alert('Saved, but failed to reload latest pallet.'); }
            });
        },
        error: function () { alert('Error saving NG details.'); }

        });
    });

    </script>

    <script>

    $(function () {
        $('[data-bs-toggle="tooltip"]').tooltip({
            trigger: 'manual',
            placement: 'top'
        });
    });

    </script>
    
</body>
</html>