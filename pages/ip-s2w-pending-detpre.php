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

    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
    <link href="css/timeline.css" rel="stylesheet">
    <link href="css/badge.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
    
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

        .input-error, .border-error,
        .select2-container--default .select2-selection.border-error,
        .select2-container--default .select2-selection--single.border-error {
            border: 1px solid #e74c3c !important;
            background-color: #fff6f6 !important;
        }

        .select2-container {
            z-index: 0 !important;
        }

        .text-end button {
            z-index: 10 !important;
            position: relative;
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
    
        .remove-old {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 22px;
            height: 22px;
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
        .remove-old:hover {
            background: #B31236;
            color: #fff;
            border-color: #FAF7F9;
        }

        .remove-new {
            position: absolute;
            top: -10px;
            right: -10px;
            width: 22px;
            height: 22px;
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
        .remove-new:hover {
            background: #B31236;
            color: #fff;
            border-color: #FAF7F9;
        }

        .position-relative:hover {
            transform: scale(1.05);
            transition: 0.2s ease-in-out;
            z-index: 2;
        }

        .readonly-mode {
            opacity: 1.0;
            color: #60676E; /* subtle gray font color */
        }

        .readonly-mode input,
        .readonly-mode textarea,
        .readonly-mode select {
            color: #60676E !important;
            background-color: #F0F2F0 !important;
            border-color: #ddd !important;
        }

        /* make textarea text appear lighter */
        .readonly-mode textarea:disabled {
            -webkit-text-fill-color: #60676E !important; /* Safari fix */
        }

        .modal-header {
            border-bottom: none !important;
        }

        input[type="file"].d-none {
            display: none !important;
        }

        .avatar-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px; /* small spacing between photos */
        }

        .avatar-list img {
            display: inline-block;
            margin-right: -8px; /* create overlapping circle effect */
            border: 2px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .avatar-lg-custom {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        .zoomable-photo {
            cursor: zoom-in; /* shows hand cursor */
            transition: transform 0.15s ease-in-out;
        }

        .zoomable-photo:hover {
            transform: scale(1.32); /* optional: subtle zoom effect on hover */
        }

        
        #btnUpdate, #btnSubmit {
            position: relative;
            z-index: 1000 !important;
        }

        .card-body {
            padding-bottom: 0.5rem !important;   /* adjust or set to 0 */
        }
        
        .d-team {
            margin-bottom: 0 !important;
            padding-bottom: 0 !important;
        }
        .d-team + .d-team {
            margin-top: 0.25rem !important; /* optional small spacing */
        }

        .d-team span,
        .ds-head span,
        .ds-head h6 {
            margin-bottom: 0 !important;
        }

        .d-team {
            margin-top: 1.25rem !important;
            margin-bottom: 1.25rem !important;
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

        #inspectionTable thead {
            background-color : #EDEBE8;
        }

        /* Align Comparison Photo header */
        #inspectionTable thead th:nth-child(3) {
            text-align: left !important;
        }

        /* Align Comparison Photo cells */
        #inspectionTable tbody td:nth-child(3) {
            text-align: left !important;
        }
        
        .card-header.chart-card {
            display: flex;
            justify-content: flex-start;   /* Align everything to the left */
            gap: 200px;                      /* Space between OK and NG blocks */
        }

        /* Custom header background */
        .accordion-header-bg-custom .accordion-button {
            background-color: #EDEBE8;        /* light grey background */
            /* color: #222;                      text color */
            /* font-weight: 500;                 make it stand out */
        }

        /* When expanded */
        .accordion-header-bg-custom .accordion-button:not(.collapsed) {
            background-color: #CCC7BC;        /* soft blue when open */
            color: #222;
            border-color : #CCC7BC;
        }

        </style>

		<?php

        $edocno = $_GET['docno'] ?? "";
        $epg = $_GET['pg'] ?? "";

        //get ir_id
        $stmt = $db_con->prepare("SELECT R.ir_id, S.s2w_id, S.s2w_ir_id, S.s2w_sr_id, S.s2w_status
                                    FROM inspection_s2w S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.s2w_ir_id
                                            WHERE S.s2w_docno = ?");
        $stmt->bind_param('s', $edocno);
        $stmt->execute();
        $s2wdet = $stmt->get_result()->fetch_assoc();
        
        $eir_id = $s2wdet['s2w_ir_id'];
        $esr_id = $s2wdet['s2w_sr_id'];
        $es2w_id = $s2wdet['s2w_id'];
        $es2w_status = $s2wdet['s2w_status'];

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
                        <?=$side_menu10;?>
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

                <input type="hidden" id="hidden_ir_id" value="<?= $eir_id ?? '' ?>">
                <input type="hidden" id="hidden_sr_id" value="<?= $esr_id ?? '' ?>">
                <input type="hidden" id="hidden_s2w_id" value="<?= $es2w_id ?? '' ?>">
                <input type="hidden" id="hidden_docno" value="<?= htmlspecialchars($_GET['docno'] ?? '') ?>">
                <input type="hidden" id="hidden_status" value="">

                <div class="row">
					<div class="col-xl-9 col-xxl-12">
						<div class="row">
							<div class="col-xl-12">
								<div class="row"> 
									<div class="col-xl-9">
										<div class="card overflow-hidden">
											<div class="card-header pb-3 flex-wrap">
												<h4 class="heading mb-0">S2W Details</h4><ul class="nav nav-pills mt-3 mt-sm-0" id="myTab2" role="tablist">
                                                    <div class="s2w-actionbar">
                                                    <a href="javascript:void(0)"
                                                    class="s2w-action viewRightDetail"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasRight"
                                                    data-bs-title="View inspection record" data-bs-placement="top" data-bs-custom-class="tooltip-dark"
                                                    data-irid="<?= $eir_id ?>">
                                                        <i class="fa fa-clipboard-check"></i>
                                                        Inspection
                                                    </a>

                                                    <span class="s2w-separator"></span>

                                                    <a href="javascript:void(0)"
                                                    class="s2w-action viewRightDetailSr"
                                                    data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasRight-SR"
                                                    data-bs-title="View sorting report" data-bs-placement="top" data-bs-custom-class="tooltip-dark"
                                                    data-srid="<?= $esr_id ?>">
                                                        <i class="fa fa-random"></i>
                                                        Sorting
                                                    </a>
                                                </div>
                                                <!-- <ul>
                                                    <li class="nav-item ms-1" role="presentation">
                                                        <button class="btn btn-sm btn-lime me-2 viewRightDetail" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" 
                                                        data-bs-title="View inspection details" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-irid="<?= $eir_id ?>">
                                                        Inspection <i class="fa fa-angle-double-right fa-xs" aria-hidden="true"></i>
                                                    </button>
                                                    </li>
                                                    <li class="nav-item ms-1" role="presentation">
                                                        <button class="btn btn-sm btn-darklime me-2 viewRightDetailSr" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight-SR" aria-controls="offcanvasRight" 
                                                        data-bs-title="View sorting details" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-srid="<?= $esr_id ?>">
                                                        Sorting <i class="fa fa-angle-double-right fa-xs" aria-hidden="true"></i></button>
                                                    </li>
                                                </ul>														 -->
											</div>
											<div class="card-body custome-tooltip p-3">
												<div id="s2wDetailContainer">
                                                    <div class="text-center py-5 text-muted">
                                                        <i class="fa fa-spinner fa-spin me-2"></i> Loading s2w details...
                                                    </div>
                                                </div>
											</div>
										</div>
									</div>                                   
									<div class="col-xl-3">                        
                                        <!-- Timeline -->
                                        <div class="recent-post"> </div>
									</div>
								</div>
							</div>			
						</div>
					</div>
					
                    <!-- Offcanvas Inspection -->
                    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header offcanvas-header-dark">
                            <h5 class="offcanvas-title mb-0 text-white" id="offcanvasRightLabel">Inspection</h5>
                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="offcanvas-body">
                            <!-- Inspection details -->
                            <div id="inspectionRightDetail"></div>
                        </div>
                    </div>

                    <!-- Offcanvas Sorting -->
                    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight-SR" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header offcanvas-header-dark">
                            <h5 class="offcanvas-title mb-0 text-white" id="offcanvasRightLabel">Sorting</h5>
                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="offcanvas-body">
                            <!-- Sorting details -->
                            <div id="sortingRightDetail"></div>
                        </div>
                    </div>

                    <!-- Modal for image zoom from isnpection-->
                    <div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content bg-transparent border-0 shadow-none">
                                <img id="previewImage" src="" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                            </div>
                        </div>
                    </div>   

                    <!-- Modal for image zoom from S2W-->
                    <div class="modal fade" id="imgZoomModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content" style="background: transparent; border: none;">
                                <img src="" id="zoomedImg" class="img-fluid rounded shadow" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                            </div>
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
    </script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {

    history.back();

    // const epage = "<?= $epg ?>"; 
        
    //     // Compare and redirect
    //     if (epage === 'c') {
    //         window.location.href = "ip-s2w-pending.php";
    //     } else if (epage === 'p') {
    //         window.location.href = "ip-s2w-pending-pre.php";
    //     } else if (epage === 'r') {
    //         window.location.href = "ip-s2w-reviewed.php";
    //     }else {
    //         window.location.href = "ip-s2w-approved.php";
    //     }
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

    let zoomImages = [];   // list of URLs for zooming
    let zoomIndex = 0;     // currently viewed index

    // Zoom images
    // When avatar is clicked
    $(document).on('click', '.viewAvatar', function () {
        const fullImg = $(this).data('full');
        console.log('Image clicked:', fullImg); 
        $('#previewImage').attr('src', fullImg);

        const modal = new bootstrap.Modal(document.getElementById('imagePreviewModal'));
        modal.show();
    });

    function initTooltips() {
        const list = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        list.map(el => new bootstrap.Tooltip(el));
    }

    // When any image (old or new) is clicked
    $(document).on('click', '.position-relative', function (e) {

        // Gather all visible images
        imageList = $('.position-relative').map(function () {
            let bg = $(this).css('background-image');
            return bg ? bg.replace(/^url\(["']?/, '').replace(/["']?\)$/, '') : null;
        }).get();

        // Current index
        currentIndex = $(this).index('.position-relative');

        // Show clicked image in modal
        $("#zoomedImg").attr("src", imageList[currentIndex]);
        $("#imgZoomModal").modal("show");
    });

    </script>

    <script>

    const eir_id = "<?= $eir_id ?>";
    const esr_id = "<?= $esr_id ?>";    
    const es2w_id = "<?= $es2w_id ?>";
    const es2w_status = "<?= $es2w_status ?>";

    // Load mateiral details
    $(document).ready(function () {
        if (eir_id) {
            loadMaterialDetails(eir_id);
        }
    });

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
        const s2w_id = $("#hidden_s2w_id").val();

        loadTimeline(ir_id, sr_id, s2w_id);
    });

    function loadTimeline(ir_id, sr_id, s2w_id) {
        $.ajax({
            url: "fetch-timeline-s2w.php",
            type: "POST",
            data: { 
                ir_id: ir_id, 
                sr_id: sr_id,
                s2w_id : s2w_id,
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
    <script>

    $(document).ready(function() {
        const docno = $("#hidden_docno").val();

        if (!docno) {
            $("#s2wDetailContainer").html("<div class='alert alert-danger'>Missing document number.</div>");
            return;
        }

        // Fetch all details when page first loads
        fetchs2wDetails(docno);
    });

    function fetchs2wDetails(docno) {
        $.ajax({
            url: "fetch-ip-s2w-pending.php",
            type: "POST",
            dataType: "json",
            data: { action: "fetch_details", docno: docno  },
            success: function(res) {
                if (res.success && res.data) {
                    renderS2WDetails(res.data);

                    const d = res.data;
                    console.log("AFTER AJAX : s2w id", d.s2w_id, "Status:", d.s2w_status);

                    // store status
                    $("#hidden_status").val(d.s2w_status);

                    // disable textarea if approved or reviewed
                    if (d.s2w_status == 4) {
                        $(".btnApprove, .btnReturnDetail").hide();
                    } 

                } else {
                    $("#s2wDetailContainer").html("<div class='alert alert-warning'>No record found for this document.</div>");
                }
            },
            error: function() {
                $("#s2wDetailContainer").html("<div class='alert alert-danger'>Failed to load details.</div>");
            }
        });
    }
   
    function renderS2WDetails(d) {

        let okHTML = '';
        let defectHTML = '';

        if (d.ok_photos) {
            d.ok_photos.split(',').forEach(photo => {
                okHTML += `
                    <img src="gallery/inspection_s2w/photo_ok/${d.s2w_id}/${photo.trim()}"
                        class="avatar avatar-lg-custom rounded-circle zoomable-photo"
                        data-src="gallery/inspection_s2w/photo_ok/${d.s2w_id}/${photo.trim()}"
                        alt="OK Photo">
                `;
            });
        } else {
            okHTML = `<span class="text-muted fs-13">No photo available</span>`;
        }

        if (d.defect_photos) {
            d.defect_photos.split(',').forEach(photo => {
                defectHTML += `
                    <img src="gallery/inspection_s2w/photo_defect/${d.s2w_id}/${photo.trim()}"
                        class="avatar avatar-lg-custom rounded-circle zoomable-photo"
                        data-src="gallery/inspection_s2w/photo_defect/${d.s2w_id}/${photo.trim()}"
                        alt="Defect Photo">
                `;
            });
        } else {
            defectHTML = `<span class="text-muted fs-13">No photo available</span>`;
        }


        let approveBtnHTML = "";
        let returnButtonHTML = "";
        let commentBlockHTML = "";

        let returnMode = "";
        let returnText = "";

        let reviewerCommentHTML = "";
        let approverCommentHTML = "";

        // REMOVE reviewer buttons if user is NOT reviewer
        if (d.s2w_status == 9 && d.S2W_reviewer !== "Y") {
            approveBtnHTML = "";  // hide Review button
            returnMode = ""; 
        }

        // REMOVE approver buttons if user is NOT approver
        if (d.s2w_status == 10 && d.S2W_approver !== "Y") {
            approveBtnHTML = "";  // hide Approve button
            returnMode = ""; 
        }

        // Reviewer return allowed:
        if (d.s2w_status == 9 && d.S2W_reviewer === "Y") {
            returnButtonHTML = `
                <button type="button" 
                        class="btn btn-black btnReturnDetail"
                        data-irid="${d.s2w_ir_id}" 
                        data-srid="${d.s2w_sr_id}" 
                        data-s2wid="${d.s2w_id}"
                        data-mode="review-return">
                    <i class="fa fa-undo me-2"></i> Return
                </button>
            `;
        }

        // Approver return allowed:
        if (d.s2w_status == 10 && d.S2W_approver === "Y") {
            returnButtonHTML = `
                <button type="button" 
                        class="btn btn-black btnReturnDetail"
                        data-irid="${d.s2w_ir_id}" 
                        data-srid="${d.s2w_sr_id}" 
                        data-s2wid="${d.s2w_id}"
                        data-mode="approve-return">
                    <i class="fa fa-undo me-2"></i> Return
                </button>
            `;
        }

        // Mode: Reviewer → Status 9
        if (d.s2w_status == 9 && d.S2W_reviewer === "Y") {

            approveBtnHTML = `
                <button type="button" 
                        class="btn btn-black btnReviewDetail"
                        data-irid="${d.s2w_ir_id}" 
                        data-srid="${d.s2w_sr_id}" 
                        data-s2wid="${d.s2w_id}">
                    <i class="fa fa-check me-2"></i> Review & Send for Approval
                </button>
            `;
            
            commentBlockHTML = `
                <div class="col-md-12 mt-2">
                    <div class="s2w-section">
                        <h6 class="section-title">
                            <i class="fa fa-commenting"></i> Reviewer Comment / Reason
                        </h6>
                        <textarea class="form-control" id="detail_remark" rows="3"></textarea>
                    </div>
                </div>
            `;

            returnMode = "review-return";
            returnText = "Return to Creator";
            
        } 

        // Mode: Approver → Status 10
        if (d.s2w_status == 10 && d.S2W_approver === "Y") {

            approveBtnHTML = `
                <button type="button" 
                        class="btn btn-black btnApproveDetail"
                        data-irid="${d.s2w_ir_id}" 
                        data-srid="${d.s2w_sr_id}" 
                        data-s2wid="${d.s2w_id}">
                    <i class="fa fa-check me-2"></i> Approve
                </button>
            `;

            commentBlockHTML = `
                <div class="col-md-12 mt-2">
                    <div class="s2w-section">
                        <h6 class="section-title">
                            <i class="fa fa-commenting"></i> Approver Comment / Reason
                        </h6>
                        <textarea class="form-control" id="detail_remark" rows="3"></textarea>
                    </div>
                </div>
            `;

            

            returnMode = "approve-return";
            returnText = "Return";

        }

        if (d.s2w_status == 10) {
        // If Reviewer comment exists
            if (d.reviewed_remark && d.reviewed_remark.trim() !== "") {
                reviewerCommentHTML = `
                    <div class="col-md-12">
                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-commenting"></i> Reviewer Comment / Reason
                            </h6>
                            <p class="content-info">${d.reviewed_remark.replace(/\n/g, '<br>')}</p>
                        </div>
                    </div>
                `;
            }
        }

        if (d.s2w_status == 4) {
            // If Reviewer comment exists
            if (d.reviewed_remark && d.reviewed_remark.trim() !== "") {
                reviewerCommentHTML = `
                    <div class="col-md-12">
                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-commenting"></i> Reviewer Comment / Reason
                            </h6>
                            <p class="content-info">${d.reviewed_remark.replace(/\n/g, '<br>')}</p>
                        </div>
                    </div>
                `;
            }

            // If Approver comment exists
            if (d.approved_remark && d.approved_remark.trim() !== "") {
                approverCommentHTML = `
                    <div class="col-md-12">
                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-commenting"></i> Approver Comment / Reason
                            </h6>
                            <p class="content-info">${d.approved_remark.replace(/\n/g, '<br>')}</p>
                        </div>
                    </div>
                `;
            }
        }

        // else
        // {
        //     // If Reviewer comment exists
        //     if (d.reviewed_remark && d.reviewed_remark.trim() !== "") {
        //         reviewerCommentHTML = `
        //             <div class="col-md-12">
        //                 <div class="s2w-section">
        //                     <h6 class="section-title">
        //                         <i class="fa fa-commenting"></i> Reviewer Comment / Reason
        //                     </h6>
        //                     <p class="content-info">${d.reviewed_remark.replace(/\n/g, '<br>')}</p>
        //                 </div>
        //             </div>
        //         `;
        //     }

        //     // If Approver comment exists
        //     if (d.approved_remark && d.approved_remark.trim() !== "") {
        //         approverCommentHTML = `
        //             <div class="col-md-12">
        //                 <div class="s2w-section">
        //                     <h6 class="section-title">
        //                         <i class="fa fa-commenting"></i> Approver Comment / Reason
        //                     </h6>
        //                     <p class="content-info">${d.approved_remark.replace(/\n/g, '<br>')}</p>
        //                 </div>
        //             </div>
        //         `;
        //     }
        // }

        let html = `
                <div class="card-body">                

                    <div class="row g-2 mt-2">

                        <!-- ========================= -->
                        <!-- ROW 1: FULL WIDTH -->
                        <!-- ========================= -->
                        <div class="col-md-12">
                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-sync-alt"></i> Additional Information (If Any)
                                </h6>
                                <p class="content-info">
                                    ${d.s2w_additional_desc ? d.s2w_additional_desc.replace(/\n/g,'<br>') : '-'}
                                </p>
                            </div>
                        </div>

                        <!-- ========================= -->
                        <!-- ROW 2: LEFT + RIGHT -->
                        <!-- ========================= -->
                        <div class="col-md-12">
                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-tools"></i> Sending To
                                </h6>
                                <p class="content-info">${d.rd_dept_name}</p>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-image"></i> Photo NG (Defect)
                                </h6>
                                <div class="photo-box avatar-list avatar-list-stacked ms-3 mt-4">
                                    ${okHTML}
                                </div>
                            </div>
                        </div>

                        <!-- ========================= -->
                        <!-- ROW 3: RIGHT COLUMN ONLY -->
                        <!-- ========================= -->
                        <div class="col-md-6 offset-md-12">
                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-image"></i> Photo After OK
                                </h6>
                                <div class="photo-box avatar-list avatar-list-stacked ms-3 mt-4">
                                    ${defectHTML}
                                </div>
                            </div>
                        </div>

                        <hr class="mt-3 mb-1">

                        <!-- ========================= -->
                        <!-- ROW 4: COMMENTS -->
                        <!-- ========================= -->
                        ${reviewerCommentHTML}
                        ${approverCommentHTML}
                        

                    </div>

                </div>`;


        $("#s2wDetailContainer").html(html);

        // reinitialize tooltips and zoom
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    </script>

    <script>

    $(document).on('click', '.zoomable-photo', function () {
        const imgSrc = $(this).data('src');
        $('#zoomedImg').attr('src', imgSrc);
        $('#imgZoomModal').modal('show');
    });

    </script>

    <script>

    // Approve
    // ===============================
    // REVIEWER → REVIEW & SEND FOR APPROVAL
    // ===============================
    $(document).on('click', '.btnReviewDetail', function () {

        const ir_id = $(this).data('irid');
        const sr_id = $(this).data('srid');
        const s2w_id = $(this).data('s2wid');
        const remark = $("#detail_remark").val().trim();

        // if (!remark) {
        //     Swal.fire("Missing Comment", "Please enter reviewer comment.", "warning");
        //     $("#detail_remark").addClass("border-error");
        //     return;
        // }
        // else {
        //     $("#detail_remark").removeClass("border-error");
        // }

        Swal.fire({
            title: "Send for Approval?",
            text: "Reviewer confirms to send this S2W for approval.",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Send",
            confirmButtonColor: "#198754",
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "fetch-ip-s2w-pending.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "review_s2w",
                        ir_id,
                        sr_id,
                        s2w_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                title: 'Reviewed',
                                text: 'S2W has been sent for approval.',
                                icon: 'success',
                                iconColor: "#286912",
                                confirmButtonColor: '#198754'
                            }).then((result) => {
                                window.location.href = "ip-s2w-pending.php";

                            });

                            // Reload page section
                            fetchs2wDetails($("#hidden_docno").val());
                        }
                    }
                });
            }
        });
    });

        // ===============================
    // APPROVER → APPROVE S2W
    // ===============================
    $(document).on('click', '.btnApproveDetail', function () {

        const ir_id = $(this).data('irid');
        const sr_id = $(this).data('srid');
        const s2w_id = $(this).data('s2wid');
        const remark = $("#detail_remark").val().trim();

        // if (!remark) {
        //     Swal.fire("Missing Comment", "Please enter approver comment.", "warning");
        //     return;
        // }

        Swal.fire({
            title: "Approve S2W?",
            text: "Approver confirms approval.",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Approve",
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "fetch-ip-s2w-pending.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "approve_s2w",
                        ir_id,
                        sr_id,
                        s2w_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Approved',
                                text: 'The S2W has been approved successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                // redirect to view page or reload list
                                window.location.href = 'ip-s2w-pending.php';
                            });

                            // Reload page section
                            fetchs2wDetails($("#hidden_docno").val());
                        }
                    }
                });
            }
        });
    });

    //Return
    // =======================================
    // RETURN HANDLER (Reviewer or Approver)
    // =======================================
    $(document).on('click', '.btnReturnDetail', function () {

        const ir_id = $(this).data('irid');
        const sr_id = $(this).data('srid');
        const s2w_id = $(this).data('s2wid');
        const mode = $(this).data('mode');  // "review-return" or "approve-return"
        const remark = $("#detail_remark").val().trim();

        // if (!remark) {
        //     Swal.fire("Missing Comment", "Please enter return reason.", "warning");
        //     return;
        // }

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing comment',
                confirmButtonColor: '#28a745',
                text: 'Please state the comment or reason.',
            });
            $('#detail_remark').addClass('border-error');
            return;
        }
        $('#detail_remark').removeClass('border-error');

        // Dialog text changes based on mode:
        let confirmText = 
            mode === "review-return"
            ? "Return this S2W?"
            : "Return this S2W?";

        Swal.fire({
            title: "Confirm Return?",
            text: confirmText,
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Return",            
            confirmButtonColor: "#198754"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "fetch-ip-s2w-pending.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: mode,   // backend will receive: "review-return" or "approve-return"
                        ir_id,
                        sr_id,
                        s2w_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        if (res.success) {
                             Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Returned',
                                text: 'The S2W has been returned successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                // redirect to view page or reload list
                                window.location.href = 'ip-s2w-pending.php';
                            });

                            // Reload the updated detail view
                            fetchs2wDetails($("#hidden_docno").val());
                        }
                    }
                });
            }
        });
    });

    </script>

    <script>

    // Right box Inspection details
    function loadRightDetail(ir_id) {
        $.ajax({
            url: "get-inspection-details.php",
            method: "POST",
            dataType: 'html',
            data: { ir_id: ir_id },
            beforeSend: function() {
                $("#inspectionRightDetail").html("<div class='text-center p-3'>Loading...</div>");
            },
            success: function(html) {
                $("#inspectionRightDetail").html(html);
            }
        });
    }

    $(document).on("click", ".viewRightDetail", function () {
        let ir_id = $(this).data("irid");
        loadRightDetail(ir_id);
    });

    $(document).ready(function () {
        let ir_id = $(".viewRightDetail.active, .viewRightDetail.show").data("irid");

        if (ir_id) {
            loadRightDetail(ir_id);
        }
    });

    // Right box Sorting details
    function loadRightDetailSr(sr_id) {
        $.ajax({
            url: "get-sorting-details.php",
            method: "POST",
            dataType: 'html',
            data: { sr_id: sr_id },
            beforeSend: function() {
                $("#sortingRightDetail").html("<div class='text-center p-3'>Loading...</div>");
            },
            success: function(html) {
                $("#sortingRightDetail").html(html);
            }
        });
    }

    $(document).on("click", ".viewRightDetailSr", function () {
        let sr_id = $(this).data("srid");
        loadRightDetailSr(sr_id);
    });

    </script>
    
</body>
</html>