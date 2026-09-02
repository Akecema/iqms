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
    
    <link href="css/timeline.css" rel="stylesheet">    

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

        .partno-select + .select2-container {
            width: 260px !important;  /* adjust only customer select */
        }

        .part_name {
            width: 250px !important;  /* adjust only customer select */
        }

        .customer-select + .select2-container {
            width: 150px !important;  /* adjust only customer select */
        }

        .vendor-select + .select2-container {
            width: 140px !important;  /* adjust only customer select */
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
            width: 60px !important;
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

        #remarkModal .modal-dialog {
            margin-top: -140px;   /* adjust distance from top */
            margin-right: 50px;
        }

        #remarkModal .modal-content {
            border-radius: 10px;
        }
        #remarkModal .modal-header {
            border-bottom: none;
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

        </style>

		<?php


        $sridEnc = $_GET['srid'] ?? '';
        $eir_id = $_GET['irid'] ?? '';
        $epg = 'c';

        //decrypt
        $esr_id = decryptData($sridEnc);

        //get status       
        $stmt = $db_con->prepare("SELECT S.sr_status
                                    FROM inspection_sorting S 
                                        WHERE S.sr_id = ?");
        $stmt->bind_param('s', $esr_id);
        $stmt->execute();
        $sortingdet = $stmt->get_result()->fetch_assoc();        
    
        $estatus = $sortingdet['sr_status'] ?? "";
        
        $sidemenu = ($epg == 'c') ? $side_menu8 : $side_menu9;
        
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
                        <?=$sidemenu;?>
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
                                                <?=$gallery_html;?>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                        
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="row">
                    <div class="col-xxl-3 col-xl-4">                          
                        <!-- Timeline -->
                        <div class="recent-post"> </div>
                    </div>

                    <div class="col-xxl-9 col-xl-8">                
                        <div class="card mb-4">
                            <div class="card-header border-0 ai-tabs-1">
                                <h4 class="card-title"></h4>
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item"><a href="#" onclick="window.location.href='ip-sorting-edit.php?srid=<?=$sridEnc?>&&irid=<?=$eir_id?>&&pg=<?=$epg?>'"  class="nav-link"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="p-1"> Sorting</span></a></li>
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
                                                            <th>Part Number</th>
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
                                            <div class="table-responsive mb-2">
                                                <table class="isplay table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartVendor">
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
                                                            <th>Related Vendor</th>
                                                            <th>Type of Part </th>
                                                            <th>Part Number</th>
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
                                                        <col style="width: 40%;">
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
                
                <!-- Remark Modal -->
                <div class="modal fade" id="remarkModal" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <div class="modal-content border-0 shadow-sm">
                            <div class="modal-body p-3 d-flex align-items-start bg-light-green">
                                <!-- Icon -->
                                <div class="me-3">
                                    <i class="fa fa-envelope fs-2 text-primary"></i>
                                </div>

                                <!-- Text -->
                                <div>
                                    <h6 class="fw-bold mb-1">Comment/Reason</h6>
                                    <p id="remarkContent" class="mb-0 small text-primary">
                                        <!-- Display remark here -->
                                    </p>
                                </div>

                                <!-- Close button -->
                                <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
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
    </script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {

    const epage = "<?= $epg ?>"; 
        
        // Compare and redirect
        if ( epage === 'c') {
            window.location.href = "ip-sorting-list-all.php";
        } else {
            window.location.href = "ip-sorting-list-all-pre.php";
        }
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
        const irid = urlParams.get('irid');
        if (irid) {
            loadMaterialDetails(irid);
        }
    });

    </script>

    <script>

    $(document).ready(function() {
        const ir_id = $("#hidden_ir_id").val();  // or however you store it
        const sr_id = $("#hidden_sr_id").val();

        loadTimeline(ir_id, sr_id);
    });

    function loadTimeline(ir_id, sr_id) {
        $.ajax({
            url: "fetch-timeline.php",
            type: "POST",
            data: { 
                ir_id: ir_id, 
                sr_id: sr_id,
                t: new Date().getTime() 
            },
            cache: false,
            success: function (html) {
                $(".recent-post").html(html);

                $(document).off("click", "[data-bs-target='#remarkModal']").on("click", "[data-bs-target='#remarkModal']", function () {
                    const remark = $(this).data("remark") || "No remark provided.";
                    const reviewedBy = $(this).data("by") || "-";
                    const reviewedDate = $(this).data("date") || "-";

                    $("#remarkContent").text(remark);
                });
                
                // run tooltip
                $('[data-bs-toggle="tooltip"]').tooltip();
            },
            error: function () {
                $(".recent-post").html("<div class='alert alert-danger'>Failed to load timeline.</div>");
            }
        });
    }

    // Handle remark icon click
    $(document).on('click', '[data-bs-target="#remarkModal"]', function () {
        const remark = $(this).data('remark') || 'No remark provided.';
        $('#remarkContent').text(remark);
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
            let lastRow = tbody.find("tr:last");  

            // Prevent multiple empty rows
            if (lastRow.length > 0) {               

                let related_dept = lastRow.find(".related_dept").val();
                let type_part    = lastRow.find(".type_part").val();
                let part_no      = lastRow.find(".part_no").val();
                let qty_ok       = lastRow.find(".qty_ok").val();
                let qty_ng       = lastRow.find(".qty_ng").val();

                // if all important fields are empty, block adding new row
                if (!related_dept && !type_part && !part_no && !qty_ok && !qty_ng) {
                    Swal.fire("Warning", "Please fill or save the current row before adding a new one.", "warning");
                    return;
                }
            }

            // Add new row
            let newRow = `
                <tr>
                    <td>
                        <select class="form-control related_dept select2">
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
                        <select class="form-control part_no select2">
                            <option value="">Part Number</option>
                        </select>                        
                    </td>
                    <td>
                        <input type="text" class="form-control part_name" value="" readonly data-bs-toggle="tooltip" title="">
                    </td>
                    <td><input type="number" class="form-control qty_ok" value="" style="width:70px;"></td>
                    <td><input type="number" class="form-control qty_ng" value="" style="width:70px;"></td>
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

            // Fetch part numbers dynamically
            let ir_id = $("#hidden_ir_id").val();
            $.post("get-partno.php", { ir_id: ir_id }, function(data){
                addedRow.find(".part_no").html(data).trigger("change");
            });

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

            if(!related_dept) {
                alert("Related Dept is required.");
                row.find(".related_dept").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".related_dept").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                row.find(".type_part").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".type_part").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                row.find(".part_no").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".part_no").next('.select2').find('.select2-selection').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                row.find(".part_name").addClass('border-error');
                return;
            }
            else {
                row.find(".part_name").removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }
            
            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Save this related part?",
            icon: "question",
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
                        data: {  ir_id: $("#hidden_ir_id").val(), sr_id: $("#hidden_sr_id").val(), related_dept : related_dept, type_part : type_part, part_no : part_no, 
                                part_name : part_name, qty_ok : qty_ok, qty_ng : qty_ng, action: 'add_related_part' },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
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
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {
                                 Swal.fire({
                                        icon: "Error",
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

             if(!related_dept) {
                alert("Related Dept is required.");
                row.find(".related_dept").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".related_dept").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                row.find(".type_part").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".type_part").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                row.find(".part_no").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".part_no").next('.select2').find('.select2-selection').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                row.find(".part_name").addClass('border-error');
                return;
            }
            else {
                row.find(".part_name").removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
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
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else if(res.status === "duplicate"){

                                Swal.fire({
                                        icon: "warning",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
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
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();

                            } else {
                                 Swal.fire({
                                        icon: "Error",
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
                data: { action: "get_related_part_edit", ir_id, sr_id },
                success: function (res) {
                    console.log("AJAX Response:", res);

                    if (res.status !== "success") return;

                    const d = res.data;

                    console.log("Sorting Status:", d.sorting_status);
                    console.log("sr_id:", d.sr_id);
                    console.log("ir_id:", d.ir_id);

                    $("#relatedPartDept tbody").html(d.html);
                    $(".select2").select2({ width: "100%" });
                    $("#relatedPartDept [data-bs-toggle='tooltip']").tooltip();

                    // Disable all fields if locked statuses (e.g. Approved=4, Cancelled=8, Pending Review=10)
                    if ([4, 8, 10].includes(+d.sorting_status)) {
                        $("#relatedPartDept")
                            .find("input, select")
                            .prop("disabled", true)
                            .css({ cursor: "not-allowed", opacity: 0.8 });

                        $("#relatedPartDept .btnSaveRowDept, #relatedPartDept .btnUpdateRowDept, #relatedPartDept .btnDeleteRowDept, #btnAddRowDept")
                            .prop("disabled", true)
                            .css({
                                opacity: 0.6,
                                cursor: "not-allowed",
                                pointerEvents: "none"
                            });

                        $("#btnAddRowDept").addClass("d-none");
                    } else {
                        // Editable mode
                        $("#relatedPartDept")
                            .find("input, select, button")
                            .prop("disabled", false)
                            .css({ cursor: "auto", opacity: 1 });
                        $("#btnAddRowDept").removeClass("d-none");
                    }
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

    </script>

    <!--///////////////////////////////////////////////////////////////////////////-->
    <!-- Related Part Vendor -->
    <script>

    // Save related loose part involve
    $(document).ready(function () {

        // Add new row
        $(document).on("click", "#btnAddRowVdr", function () {
            let tbody = $("#relatedPartVendor tbody");
            let lastRow = tbody.find("tr:last");  

            // Prevent multiple empty rows
            if (lastRow.length > 0) {               

                let related_vdr = lastRow.find(".related_vdr").val();
                let type_part    = lastRow.find(".type_part").val();
                let part_no      = lastRow.find(".part_no").val();
                let qty_ok       = lastRow.find(".qty_ok").val();
                let qty_ng       = lastRow.find(".qty_ng").val();

                // if all important fields are empty, block adding new row
                if (!related_vdr && !type_part && !part_no && !qty_ok && !qty_ng) {
                    Swal.fire("Warning", "Please fill or save the current row before adding a new one.", "warning");
                    return;
                }
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
                        <select class="form-control part_no select2">
                            <option value="">Part Number</option>
                        </select>                        
                    </td>
                    <td>
                        <input type="text" class="form-control part_name" value="" readonly data-bs-toggle="tooltip" title="">
                    </td>
                    <td><input type="number" class="form-control qty_ok" value="" style="width:70px;"></td>
                    <td><input type="number" class="form-control qty_ng" value="" style="width:70px;"></td>
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

            // Fetch part numbers dynamically
            let ir_id = $("#hidden_ir_id").val();
            $.post("get-partno.php", { ir_id: ir_id }, function(data){
                addedRow.find(".part_no").html(data).trigger("change");
            });

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

            if(!related_vdr) {
                alert("Related Vendor is required.");
                row.find(".related_vdr").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".related_vdr").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                row.find(".type_part").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".type_part").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                row.find(".part_no").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".part_no").next('.select2').find('.select2-selection').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                row.find(".part_name").addClass('border-error');
                return;
            }
            else {
                row.find(".part_name").removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }
            
            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Save this related part?",
            icon: "question",
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
                        data: {  ir_id: $("#hidden_ir_id").val(), sr_id: $("#hidden_sr_id").val(), related_vdr : related_vdr, type_part : type_part, part_no : part_no, 
                                part_name : part_name, qty_ok : qty_ok, qty_ng : qty_ng, action: 'add_related_part' },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
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
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {
                                 Swal.fire({
                                        icon: "Error",
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

             if(!related_vdr) {
                alert("Related Vendor is required.");
                row.find(".related_vdr").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".related_vdr").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                row.find(".type_part").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".type_part").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                row.find(".part_no").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".part_no").next('.select2').find('.select2-selection').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                row.find(".part_name").addClass('border-error');
                return;
            }
            else {
                row.find(".part_name").removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
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
                        data: { action: 'update_related_part', row_id: row_id, ir_id: $("#hidden_ir_id").val(), related_vdr : related_vdr, type_part : type_part, part_no : part_no, 
                                part_name : part_name, qty_ok : qty_ok, qty_ng : qty_ng },
                        success: function(res) {
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else if(res.status === "duplicate"){

                                Swal.fire({
                                        icon: "warning",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
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
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();

                            } else {
                                 Swal.fire({
                                        icon: "Error",
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
                data: { action: "get_related_part_edit", ir_id, sr_id },
                success: function (res) {
                    if (res.status !== "success") return;
                    const d = res.data;

                    $("#relatedPartVendor tbody").html(d.html);
                    $(".select2").select2({ width: "100%" });
                    $("#relatedPartVendor [data-bs-toggle='tooltip']").tooltip();

                    // Lock fields if status = Approved(4), Cancelled(8), or Pending Review(10)
                    if ([4, 8, 10].includes(+d.sorting_status)) {
                        $("#relatedPartVendor")
                            .find("input, select")
                            .prop("disabled", true)
                            .css({ cursor: "not-allowed", opacity: 0.8 });

                        $("#relatedPartVendor .btnSaveRowVdr, #relatedPartVendor .btnUpdateRowVdr, #relatedPartVendor .btnDeleteRowVdr, #btnAddRowVdr")
                            .prop("disabled", true)
                            .css({
                                opacity: 0.6,
                                cursor: "not-allowed",
                                pointerEvents: "none"
                            });

                        $("#btnAddRowVdr").addClass("d-none");
                    } else {
                        $("#relatedPartVendor")
                            .find("input, select, button")
                            .prop("disabled", false)
                            .css({ cursor: "auto", opacity: 1 });
                        $("#btnAddRowVdr").removeClass("d-none");
                    }
                },
                error: function (xhr) {
                    console.error("Reload failed:", xhr.status, xhr.responseText);
                }
            });
        }

        $(function () {
            const ir_id = $("#hidden_ir_id").val();
            if (ir_id) loadRelatedVdr(ir_id);
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

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }
            
            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Save this finished goods part?",
            icon: "question",
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

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
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
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
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
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();
                                
                            } else {
                                 Swal.fire({
                                        icon: "Error",
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
    function loadFinishGoodsPart(ir_id) {
        const sr_id = $("#hidden_sr_id").val();

        $.ajax({
            url: "fetch-ip-related-part-cust.php",
            method: "POST",
            dataType: "json",
            data: { action: "get_finishgoods_part_edit", ir_id, sr_id },
            success: function (res) {
                if (res.status !== "success") return;

                const d = res.data;

                $("#relatedPartCustomer tbody").html(d.html);
                $(".select2").select2({ width: "100%" });
                $("#relatedPartCustomer [data-bs-toggle='tooltip']").tooltip();

                // Disable all fields if locked statuses (Approved=4, Cancelled=8, Pending Review=10)
                if ([4, 8, 10].includes(+d.sorting_status)) {
                    $("#relatedPartCustomer")
                        .find("input, select")
                        .prop("disabled", true)
                        .css({ cursor: "not-allowed", opacity: 0.8 });

                    $("#relatedPartCustomer .btnSaveRowCust, #relatedPartCustomer .btnUpdateRowCust, #relatedPartCustomer .btnDeleteRowCust, #btnAddRowCust")
                        .prop("disabled", true)
                        .css({
                            opacity: 0.6,
                            cursor: "not-allowed",
                            pointerEvents: "none"
                        });

                    $("#btnAddRowCust").addClass("d-none");
                } else {
                    $("#relatedPartCustomer")
                        .find("input, select, button")
                        .prop("disabled", false)
                        .css({ cursor: "auto", opacity: 1 });
                    $("#btnAddRowCust").removeClass("d-none");
                }
            },
            error: function (xhr) {
                console.error("Reload failed:", xhr.status, xhr.responseText);
            }
        });
    }

    $(function () {
        const ir_id = $("#hidden_ir_id").val();
        if (ir_id) loadFinishGoodsPart(ir_id);
    }); 

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
                            title: 'Saved!',
                            text: 'Defect added successfully.',
                            timer: 3000,
                            showConfirmButton: false
                        });

                        reloadTable();

                    } else {
                        Swal.fire({
                            icon: 'error',
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