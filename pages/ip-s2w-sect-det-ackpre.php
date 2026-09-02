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
        $stmt = $db_con->prepare("SELECT R.ir_id, S.rp_id, S.rp_s2w_id, S.rp_s2w_ir_id, S.rp_s2w_sr_id, S.rp_s2w_status
                                    FROM inspection_s2w_report S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.rp_s2w_ir_id
                                            WHERE S.rp_s2w_docno = ?");
        $stmt->bind_param('s', $edocno);
        $stmt->execute();
        $s2wdet = $stmt->get_result()->fetch_assoc();
        
        $eir_id = $s2wdet['rp_s2w_ir_id'];
        $esr_id = $s2wdet['rp_s2w_sr_id'];
        $es2w_id = $s2wdet['rp_s2w_id'];
        $erp_id = $s2wdet['rp_id'];
        $erp_status = $s2wdet['rp_s2w_status'];

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
                        <?=$side_menu13;?>
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
                <input type="hidden" id="hidden_rp_id" value="<?= $erp_id ?? '' ?>">
                <input type="hidden" id="hidden_docno" value="<?= htmlspecialchars($_GET['docno'] ?? '') ?>">
                <input type="hidden" id="hidden_status" value="">

                <div class="row">
					<div class="col-xl-9 col-xxl-12">
						<div class="row">
							<div class="col-xl-12">
								<div class="row">                                    
									<div class="col-xl-3">										
                                        
                                        <!-- Timeline -->
                                        <div class="recent-post"> </div>
                                        
									</div>
									<div class="col-xl-9">
										<div class="card overflow-hidden">
											<div class="card-header pb-3 flex-wrap">
												<h4 class="heading mb-0">S2W Report Acknowledge</h4>												
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
								</div>
							</div>			
						</div>
					</div>
					<div class="col-xl-6 col-xxl-12">
						<div class="card">
							<div class="card-body p-3">
								<div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs mt-4">
                                            <li class="nav-item">
                                                <a href="#my-posts" data-bs-toggle="tab" class="nav-link active show viewRightDetail" data-irid="<?= $eir_id ?>">
                                                Inspection
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="#about-me" data-bs-toggle="tab" class="nav-link viewRightDetailSr" data-srid="<?= $esr_id ?>">
                                                Sorting
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#my-S2W" data-bs-toggle="tab" class="nav-link viewRightDetailS2W" data-s2wid="<?= $es2w_id ?>">
                                                Something When Wrong (S2W)
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div id="my-posts" class="tab-pane fade active show">
                                                <div class="my-post-content pt-3">
                                                    <!-- Inspection details -->
                                                    <div id="inspectionRightDetail"></div>
                                                </div>
                                            </div>
                                            <div id="about-me" class="tab-pane fade">
                                                <div class="profile-about-me pt-3">
                                                    <!-- Sorting details -->
                                                    <div id="sortingRightDetail"></div>
                                                </div>
                                            </div>
                                            <div id="my-S2W" class="tab-pane fade">
                                                <div class="profile-my-S2W pt-3">
                                                    <!-- Sorting details -->
                                                    <div id="S2WRightDetail"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
							</div>
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
    const erp_id = "<?= $erp_id ?>";
    const erp_status = "<?= $erp_status ?>";

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
        const rp_id = $("#hidden_rp_id").val();

        loadTimeline(ir_id, sr_id, s2w_id, rp_id);
    });

    function loadTimeline(ir_id, sr_id, s2w_id, rp_id) {
        $.ajax({
            url: "fetch-timeline-s2w-section.php",
            type: "POST",
            data: { 
                ir_id: ir_id, 
                sr_id: sr_id,
                s2w_id : s2w_id,
                rp_id : rp_id,
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
            url: "fetch-ip-s2w-ack-section.php",
            type: "POST",
            dataType: "json",
            data: { action: "fetch_details", docno: docno  },
            success: function(res) {
                if (res.success && res.data) {
                    renderS2WDetails(res.data);

                    const d = res.data;
                    console.log("AFTER AJAX : rp id", d.rp_id, "Status:", d.rp_s2w_status);

                    // store status
                    $("#hidden_status").val(d.rp_s2w_status);

                    // disable textarea if approved or reviewed or completed
                    if (d.rp_s2w_status == 4 || d.rp_s2w_status == 5) {
                        $(".btnAcknowledge, .btnReturn").hide();
                        $("textarea").prop("disabled", true);
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

        let correctionHTML = '';
        let preventiveHTML = '';

        if (d.correction_photos) {
            d.correction_photos.split(',').forEach(photo => {
                correctionHTML += `
                    <img src="gallery/inspection_s2w_report/photo_correction/${d.rp_id}/${photo.trim()}"
                        class="avatar avatar-lg-custom rounded-circle zoomable-photo"
                        data-src="gallery/inspection_s2w_report/photo_correction/${d.rp_id}/${photo.trim()}"
                        alt="OK Photo">
                `;
            });
        } else {
            correctionHTML = `<span class="text-muted fs-13">No photo available</span>`;
        }

        if (d.preventive_photos) {
            d.preventive_photos.split(',').forEach(photo => {
                preventiveHTML += `
                    <img src="gallery/inspection_s2w_report/photo_preventive/${d.rp_id}/${photo.trim()}"
                        class="avatar avatar-lg-custom rounded-circle zoomable-photo"
                        data-src="gallery/inspection_s2w_report/photo_preventive/${d.rp_id}/${photo.trim()}"
                        alt="Defect Photo">
                `;
            });
        } else {
            preventiveHTML = `<span class="text-muted fs-13">No photo available</span>`;
        }

        // Decide which remark to show based on status
        let remarkText = '';
        if (d.rp_status == 15) {
            remarkText = d.acknowledge_remark || ''; // reviewed remark
        } else if (d.rp_status == 16) {
            remarkText = d.acknowledge_return_remark || ''; // returned remark
        } else {
            remarkText = d.acknowledge_remark || ''; // default (e.g. before approved)
        }

        let html = `
            <div class="card-body">                

                <div class="row g-2 mt-2">

                    <div class="row g-4 mt-2">

                        <!-- ========================================== -->
                        <!-- LEFT COLUMN -->
                        <!-- ========================================== -->
                        <div class="col-md-6">

                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-history"></i> Cronology 
                                </h6>
                                <p class="content-info">
                                    ${d.rp_s2w_cronology ? d.rp_s2w_cronology.replace(/\n/g,'<br>') : '-'}
                                </p>
                            </div>

                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-lightbulb"></i> Root Cause 
                                </h6>
                                <p class="content-info">
                                    ${d.rp_s2w_rootcause ? d.rp_s2w_rootcause.replace(/\n/g,'<br>') : '-'}
                                </p>
                            </div>

                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-map"></i> Root Cause Area 
                                </h6>
                                <p class="content-info">
                                    ${d.rp_s2w_rootcause_area ? d.rp_s2w_rootcause_area.replace(/\n/g,'<br>') : '-'}
                                </p>
                            </div>

                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-location-dot"></i> Root Cause Place 
                                </h6>
                                <p class="content-info">
                                    ${d.rp_s2w_rootcause_place ? d.rp_s2w_rootcause_place.replace(/\n/g,'<br>') : '-'}
                                </p>
                            </div>

                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-file-alt"></i> Conclusion 
                                </h6>
                                <p class="content-info">
                                    ${d.rp_s2w_conclusion ? d.rp_s2w_conclusion.replace(/\n/g,'<br>') : '-'}
                                </p>
                            </div>

                        </div>

                        <!-- ========================================== -->
                        <!-- RIGHT COLUMN -->
                        <!-- ========================================== -->
                        <div class="col-md-6">

                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-tools"></i> Correction / Corrective 
                                </h6>
                                <p class="content-info">
                                    ${d.rp_s2w_correction ? d.rp_s2w_correction.replace(/\n/g,'<br>') : '-'}
                                </p>
                            </div>

                            <div class="s2w-section">
                                <h6 class="section-title"> 
                                    <i class="fa fa-image"></i> Correction Photos 
                                </h6>
                                <div class="photo-box avatar-list avatar-list-stacked ms-3 mt-4">
                                    ${correctionHTML}
                                </div>
                            </div>                                                

                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-check-circle"></i> Preventive 
                                </h6>
                                <p class="content-info">
                                    ${d.rp_s2w_preventive ? d.rp_s2w_preventive.replace(/\n/g,'<br>') : '-'}
                                </p>
                            </div>

                            <div class="s2w-section">
                                <h6 class="section-title">
                                    <i class="fa fa-image"></i> Preventive Photos 
                                </h6> 
                                <div class="photo-box avatar-list avatar-list-stacked ms-3 mt-4">
                                    ${preventiveHTML}
                                </div>
                            </div>

                        </div>
                    </div>

                    <hr class="mt-3 mb-1">

                    <!-- ========================= -->
                    <!-- ROW 4: COMMENTS -->
                    <!-- ========================= -->
                    <div class="col-md-12">
                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-commenting"></i> Comment/Reason
                            </h6>
                            <p class="content-info">${d.approved_remark || ''} </p>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-commenting"></i> Comment/Reason 
                            </h6>
                            <textarea class="form-control" id="acknowledge_remark">${remarkText || ''}</textarea>
                        </div>
                    </div>

                </div>

            </div>`;


        $("#s2wDetailContainer").html(html);

        // --- Disabled all field/button ---        
        $(".btnAcknowledge, .btnReturn").hide();
        $("#acknowledge_remark").prop("disabled", true);
        

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

    const epage = "<?= $epg ?>"; 

    // ===============================
    // APPROVER → APPROVE S2W
    // ===============================
    $(document).on('click', '.btnAcknowledge', function () {

        const docno = $("#hidden_docno").val();
        const ir_id = eir_id;
        const sr_id = esr_id;
        const s2w_id = es2w_id;
        const rp_id = erp_id;
        const remark = $('#acknowledge_remark').val().trim();

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing Remarks',
                text: 'Please state the remark for acknowledgement.',
            });
            $('#acknowledge_remark').addClass('border-error');
            return;
        }
        $('#acknowledge_remark').removeClass('border-error');

        Swal.fire({
            title: "Are you sure?",
            text: "Acknowledge this S2W Report?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Acknowledge",
            confirmButtonColor: '#28a745'
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "fetch-ip-s2w-ack-section.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: "acknowledge_s2w",
                        ir_id,
                        sr_id,
                        s2w_id,
                        rp_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Acknowledge',
                                text: 'The S2W has been acknowledge successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                // redirect to view page or reload list
                                if(epage === 'c') {
                                    window.location.href = 'ip-s2w-sect-acknowledge.php';
                                }
                                else if(epage === 'p') 
                                {
                                    window.location.href = 'ip-s2w-sect-acknowledge-pre.php';
                                }
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
    // RETURN HANDLER (creator)
    // =======================================
    $(document).on('click', '.btnReturn', function () {

        const docno = $("#hidden_docno").val();
        const ir_id = eir_id;
        const sr_id = esr_id;
        const s2w_id = es2w_id;
        const rp_id = erp_id;
        const remark = $('#acknowledge_remark').val().trim();

       if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing Remarks',
                text: 'Please state the remark for return.',
            });
            $('#acknowledge_remark').addClass('border-error');
            return;
        }
        $('#acknowledge_remark').removeClass('border-error');

        Swal.fire({
            title: "Confirm Return?",
            text: 'Do you want to return this S2W report',
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Return",            
            confirmButtonColor: "#198754"
        }).then((result) => {
            if (result.isConfirmed) {

                $.ajax({
                    url: "fetch-ip-s2w-ack-section.php",
                    type: "POST",
                    dataType: "json",
                    data: {
                        action: 'approve-return',
                        ir_id,
                        sr_id,
                        s2w_id,
                        rp_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        if (res.success) {
                             Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Returned',
                                text: 'The S2W report has been returned successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                // redirect to view page or reload list
                                if(epage === 'c') {
                                    window.location.href = 'ip-s2w-sect-acknowledge.php';
                                }
                                else if(epage === 'p') 
                                {
                                    window.location.href = 'ip-s2w-sect-acknowledge-pre.php';
                                }
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
    
    // Right box S2W
    function loadRightDetailS2W(s2w_id) {
        $.ajax({
            url: "get-s2w-details.php",
            method: "POST",
            dataType: 'html',
            data: { s2w_id: s2w_id },
            beforeSend: function() {
                $("#S2WRightDetail").html("<div class='text-center p-3'>Loading...</div>");
            },
            success: function(html) {
                $("#S2WRightDetail").html(html);

                // Wait until hidden fields are created
                setTimeout(function(){
                    let report_id = $("#hidden_s2w_report_id").val();

                    console.log("After S2W HTML loaded, report ID =", report_id);

                    if (report_id && report_id !== "0") {
                        loadS2W(report_id);
                    }
                }, 50);

                // --- Disabled all field/button ---        
                $(".btnApprove, .btnReturn").prop("disabled", true);
                $("#approval_remark").prop("disabled", true);
            }
        });
    }

    $(document).on("click", ".viewRightDetailS2W", function () {
        let s2w_id = $(this).data("s2wid");
        loadRightDetailS2W(s2w_id);
    });

    </script>
    
</body>
</html>