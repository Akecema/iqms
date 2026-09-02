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

    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
    <link href="css/badge.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
    <link href="css/image.css" rel="stylesheet">
    <link href="css/timeline.css" rel="stylesheet">
	
    <!-- Tagify Css -->
	<link href="vendor/tagify/dist/tagify.css" rel="stylesheet">	
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
    
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    
	<link href="vendor/nestable2/css/jquery.nestable.min.css" rel="stylesheet">
    <link href="vendor/sweetalert2/sweetalert2.min.css?v=1" rel="stylesheet">
    
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

        .text-white-body,
        .text-white-body * {
            color: #fff !important;
        }

        </style>

		<?php

        $s2widEnc = $_GET['encs2wid'] ?? '';
        $eir_id = $_GET['irid'] ?? '';
        $esridEnc = $_GET['srid'];
        $epg = $_GET['pg'] ?? "";

        //decrypt
        $es2w_id = decryptData($s2widEnc);
        $esr_id = decryptData($esridEnc);

        //s2w docno
        $sql = "SELECT s2w_docno FROM inspection_s2w WHERE s2w_id = ?";
        $stmt = $db_con->prepare($sql);
        $stmt->bind_param("i", $es2w_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $es2w_docno = $row['s2w_docno'];

        ?>

        <style>

        .remove-icon {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #181818;
            color: #fff;
            width: 20px;
            height: 20px;
            font-size: 16px;
            line-height: 20px;
            text-align: center;
            border-radius: 50%;
            cursor: pointer;
            z-index: 20;
        }

        .zoom-item,
        .new-photo {
            cursor: zoom-in;
        }

        .zoom-item .remove-icon,
        .new-photo .remove-icon {
            cursor: pointer !important;
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

                <div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="heading mb-0"> 
                                    <small>Document No</small>
                                    <p class="fw-semibold text-black"><?= $es2w_docno ?></p>
                                </h4> 
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

                                    <span class="s2w-separator"></span>

                                    <a href="javascript:void(0)"
                                    class="s2w-action viewRightDetailS2W"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#offcanvasRight-S2W"
                                    data-bs-title="View S2W details" data-bs-placement="top" data-bs-custom-class="tooltip-dark"
                                    data-s2wid="<?= $es2w_id ?>">
                                        <i class="fa fa-file"></i>
                                        S2W
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade show active" id="add-sorting-tab">

                                        <!-- Hidden Fields -->
                                        <input type="hidden" id="hidden_ir_id" value="<?= $eir_id ?>">
                                        <input type="hidden" id="hidden_sr_id" value="<?= $esr_id ?>">
                                        <input type="hidden" id="hidden_s2w_id" value="<?= $es2w_id ?>">
                                        <input type="hidden" id="hidden_docno" value="<?= $es2w_docno ?>">
                                        <!-- <input type="hidden" id="hidden_rp_id" value="<?= $rp_id ?? 0 ?>"> -->

                                        <div class="row g-4 mt-2">

                                            <!-- ========================================== -->
                                            <!-- LEFT COLUMN -->
                                            <!-- ========================================== -->
                                            <div class="col-md-6">

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-history"></i> Cronology <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="fd_cronology"></textarea>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-lightbulb"></i> Root Cause <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="fd_rootcause"></textarea>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-map"></i> Root Cause Area <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="fd_rootcause_area"></textarea>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-location-dot"></i> Root Cause Place <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="fd_rootcause_place"></textarea>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-file-alt"></i> Conclusion <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="fd_conclusion"></textarea>
                                                </div>

                                            </div>

                                            <!-- ========================================== -->
                                            <!-- RIGHT COLUMN -->
                                            <!-- ========================================== -->
                                            <div class="col-md-6">

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-tools"></i> Correction / Corrective <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="fd_correction"></textarea>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title"> 
                                                        <i class="fa fa-image"></i> Correction Photos <span class="text-danger p-1">*</span>
                                                    </h6>

                                                    <div class="photo-box mb-2 d-flex flex-wrap" id="correction_photo_existing"></div>

                                                    <input type="file" id="correction_photo_s2w" name="correction_photo[]" multiple hidden>
                                                    <label for="correction_photo_s2w" class="btn btn-primary light btn-sm btnImg">
                                                        <i class="fa fa-upload me-1"></i> Add Image
                                                    </label>
                                                    <div class="s2w-small-text">Use Ctrl to select multiple images</div>
                                                </div>                                                

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-check-circle"></i> Preventive <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="fd_preventive"></textarea>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-image"></i> Preventive Photos <span class="text-danger p-1">*</span>
                                                    </h6> 

                                                    <div class="photo-box mb-2 d-flex flex-wrap" id="preventive_photo_existing"></div>

                                                    <input type="file" id="preventive_photo_s2w" name="preventive_photo[]" multiple hidden>
                                                    <label for="preventive_photo_s2w" class="btn btn-primary light btn-sm btnImg">
                                                        <i class="fa fa-upload me-1"></i> Add Image
                                                    </label>
                                                    <div class="s2w-small-text">Use Ctrl to select multiple images</div>
                                                </div>

                                            </div>
                                        </div>

                                        <!-- Buttons -->
                                        <div class="text-end mt-4 mb-4">
                                            <button type="button" id="btnSave" class="btn btn-black">Save</button>
                                            <button type="button" id="btnUpdate" class="btn btn-black d-none"><i class="fa fa-check me-2"></i>Save Changes</button>
                                            <button type="button" id="btnSubmit" class="btn btn-black d-none"><i class="fa-solid fa-paper-plane me-2"></i>Submit</button>
                                        </div>

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

                    <!-- Offcanvas S2W -->
                    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="offcanvasRight-S2W" aria-labelledby="offcanvasRightLabel">
                        <div class="offcanvas-header offcanvas-header-dark">
                            <h5 class="offcanvas-title mb-0 text-white" id="offcanvasRightLabel">Something When Wrong (S2W)</h5>
                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="offcanvas" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <div class="offcanvas-body">
                            <!-- S2W details -->
                            <div id="S2WRightDetail"></div>
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

                <!-- <div class="modal fade" id="imgZoomModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content" style="ackground: transparent; border: none;">
                            <div class="modal-body p-0 text-center">
                                <img id="zoomedImg" src="" class="img-fluid" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- Modal for image zoom from S2W-->
                <div class="modal fade" id="imgZoomModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background: transparent; border: none;">
                            <img src="" id="zoomedImg" class="img-fluid rounded shadow" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
                        </div>
                    </div>
                </div>   

                <!-- Cancel Remark Modal -->
                <div class="modal fade" id="cancelRemarkModal" tabindex="-1" aria-labelledby="cancelRemarkLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">                                                    
                            <h5 class="modal-title" id="ngModalLabel"></h5>                                                  
                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <form id="cancelRemarkForm">
                            <div class="modal-body">

                            <input type="hidden" id="cancel_ir_id" name="ir_id">
                            <input type="hidden" id="cancel_sr_id" name="sr_id">
                            <input type="hidden" id="cancel_s2w_id" name="s2w_id">
                            <input type="hidden" id="cancel_rp_id" name="rp_id">
                        
                            <div class="mb-3">
                                <label for="cancel_remark" class="form-label">Cancellation Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="cancel_remark" name="remark" rows="4" maxlength="500"></textarea>
                                <div class="form-text"><span id="cancel_count">0</span>/500</div>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-black" id="btnConfirmCancel"><i class="fa fa-times me-1"></i>Confirm Cancel</button>
                            </div>
                        </form>
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
        const valid_role = "<?php echo $session_role; ?>";
        const valid_userid = "<?php echo $session_id; ?>";
    </script>

    <script>
    function initSelect2(row) {
        row.find("select").select2({
            width: '100%'   // makes Select2 stretch to <td> width
        });
    }
    </script>

    <script>
    document.getElementById('btnBack').addEventListener('click', function () {
        window.location.href = "ip-s2w-sect.php";
    });
    </script>

    <script>
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]')); Dashboard
        
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

    <!--///////////////////////////////////////////////////////////////////////////-->
    <script>

    // --- GLOBAL ARRAYS ---
    let existing_correction_photos = [];   // {id, rp_id, url}
    let new_correction_files = [];         // File objects to upload

    let existing_preventive_photos = [];
    let new_preventive_files = [];

    //Render EXISTING photos (DB)
    function renderCorrectionPhotos() {
        const box = $("#correction_photo_existing");
        box.empty();

        existing_correction_photos.forEach((img, index) => {
            box.append(`
                <div class="position-relative me-2 mb-2 zoom-item"
                    style="width:80px;height:80px;border-radius:8px;
                    background-image:url('${img.url}');
                    background-size:cover;background-position:center;
                    border:1px solid #ddd;cursor:zoom-in"
                    data-id="${img.id}" 
                    data-rpid="${img.rp_id}"
                    data-index="${index}"
                >
                    <span class="remove-icon remove-old-correction">&times;</span>
                </div>
            `);
        });
    }

    function renderPreventivePhotos() {
        const box = $("#preventive_photo_existing");
        box.empty();

        existing_preventive_photos.forEach((img, index) => {
            box.append(`
                <div class="position-relative me-2 mb-2 zoom-item"
                    style="width:80px;height:80px;border-radius:8px;
                    background-image:url('${img.url}');
                    background-size:cover;background-position:center;
                    border:1px solid #ddd;cursor:zoom-in"
                    data-id="${img.id}" 
                    data-rpid="${img.rp_id}"
                    data-index="${index}"
                >
                    <span class="remove-icon remove-old-preventive">&times;</span>
                </div>
            `);
        });
    }

    // CORRECTION – add new photos (for Save, Update, Submit)
    //Render NEW photo previews
    $("#correction_photo_s2w").on("change", function(e) {
        const files = Array.from(e.target.files);

        files.forEach((file, index) => {
            const previewIndex = new_correction_files.length;

            new_correction_files.push(file);

            const reader = new FileReader();
            reader.onload = function(ev) {
                $("#correction_photo_existing").append(`
                    <div class="position-relative me-2 mb-2 new-photo"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${ev.target.result}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;"
                        data-newindex="${previewIndex}"
                    >
                        <span class="remove-icon remove-new-correction">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    });

    // PREVENTIVE – add new photos
    $("#preventive_photo_s2w").on("change", function(e) {
        const files = Array.from(e.target.files);

        files.forEach((file, index) => {
            const previewIndex = new_preventive_files.length;

            new_preventive_files.push(file);

            const reader = new FileReader();
            reader.onload = function(ev) {
                $("#preventive_photo_existing").append(`
                    <div class="position-relative me-2 mb-2 new-photo"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${ev.target.result}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;"
                        data-newindex="${previewIndex}"
                    >
                        <span class="remove-icon remove-new-preventive">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    });

    // ZOOM IMAGE (existing + new)
    $(document).on("click", ".zoom-item, .new-photo", function(e) {

        // Do not zoom when clicking remove button
        if ($(e.target).hasClass("remove-icon")) return;

        let bg = $(this).css("background-image");

        // Extract URL from CSS background-image
        bg = bg.replace(/^url\(["']?/, '').replace(/["']?\)$/, '');

        // Set modal image
        $("#zoomedImg").attr("src", bg);

        // Show the modal
        $("#imgZoomModal").modal("show");
    });

    //Delete EXISTING photos (AJAX)
    $(document).on("click", ".remove-old-correction", function(e) {
        e.stopPropagation();

        let box = $(this).closest("div");
        let photoId = box.data("id");
        let rp_id   = box.data("rpid");

        Swal.fire({
            title: "Remove photo",
            text: "Remove this photo?",
            icon: "warning",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Remove",
            confirmButtonColor: "#198754"
        }).then(res => {
            if (!res.isConfirmed) return;

            $.post("fetch-ip-s2w-section.php", {
                action: "delete_correction_photo",
                id: photoId,
                rp_id: rp_id
            }, function(resp) {
                box.remove();
                existing_correction_photos = existing_correction_photos.filter(p => p.id != photoId);
            }, "json");
        });
    });

    $(document).on("click", ".remove-old-preventive", function(e) {
        e.stopPropagation();

        let box = $(this).closest("div");
        let photoId = box.data("id");
        let rp_id   = box.data("rpid");

        Swal.fire({
            title: "Remove photo",
            text: "Remove this photo?",
            icon: "warning",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Remove",
            confirmButtonColor: "#198754"
        }).then(res => {
            if (!res.isConfirmed) return;

            $.post("fetch-ip-s2w-section.php", {
                action: "delete_preventive_photo",
                id: photoId,
                rp_id: rp_id
            }, function(resp) {
                box.remove();
                existing_preventive_photos = existing_preventive_photos.filter(p => p.id != photoId);
            }, "json");
        });
    });

    //Delete NEW photos (not uploaded yet)
    $(document).on("click", ".remove-new-correction", function(e) {
        e.stopPropagation();

        let box = $(this).closest("div");
        let index = box.data("newindex");

        // remove from local array
        new_correction_files.splice(index, 1);

        // remove from UI
        box.remove();
    });

    $(document).on("click", ".remove-new-preventive", function(e) {
        e.stopPropagation();

        let box = $(this).closest("div");
        let index = box.data("newindex");

        new_preventive_files.splice(index, 1);
        box.remove();
    });

    // Load record
    function loadS2WDetailsById(s2w_id) {
        $.ajax({
            url: "fetch-ip-s2w-section.php",
            type: "POST",
            data: { action: "get_s2w_details", s2w_id: s2w_id },
            dataType: "json",
            success: function(res) {

                console.log("RAW RESPONSE:", res);
                console.log("Correction photos returned:", res.data.correction_photo);
                console.log("Preventive photos returned:", res.data.preventive_photo);
                console.log("RP ID:", res.data.rp_id);

                if (res.status !== "success" || !res.data) return;

                const d = res.data;
                const status = d.rp_s2w_status;

                // rp_id from DB 
                const rp_id = d.rp_id;

                // set hidden rp_id
                if ($("#hidden_rp_id").length === 0) {
                    $("<input>", { type: "hidden", id: "hidden_rp_id", value: rp_id })
                        .appendTo("body");
                } else {
                    $("#hidden_rp_id").val(rp_id);
                }

                //set hidden report status
                if ($("#hidden_rp_status").length === 0) {
                    $("<input>", { type: "hidden", id: "hidden_rp_status", value: status })
                        .appendTo("body");
                } else {
                    $("#hidden_rp_status").val(status);
                }

                // text fields
                $("#fd_cronology").val(d.rp_s2w_cronology || "");
                $("#fd_rootcause").val(d.rp_s2w_rootcause || "");
                $("#fd_rootcause_area").val(d.rp_s2w_rootcause_area || "");
                $("#fd_rootcause_place").val(d.rp_s2w_rootcause_place || "");
                $("#fd_correction").val(d.rp_s2w_correction || "");
                $("#fd_preventive").val(d.rp_s2w_preventive || "");
                $("#fd_conclusion").val(d.rp_s2w_conclusion || "");

                // reset arrays
                existing_correction_photos = [];
                existing_preventive_photos = [];
                new_correction_files = [];
                new_preventive_files = [];

                if (d.correction_photo) {
                    d.correction_photo.forEach(p => {
                        existing_correction_photos.push({
                            id: p.correction_photoid,
                            rp_id: rp_id,
                            url: `gallery/inspection_s2w_report/photo_correction/${rp_id}/${p.file}`
                        });
                    });
                }

                if (d.preventive_photo) {
                    d.preventive_photo.forEach(p => {
                        existing_preventive_photos.push({
                            id: p.preventive_photoid,
                            rp_id: rp_id,
                            url: `gallery/inspection_s2w_report/photo_preventive/${rp_id}/${p.file}`
                        });
                    });
                }

                renderCorrectionPhotos();
                renderPreventivePhotos();

                /* -----------------------------------------
                5. Button visibility logic (clean version)
                --------------------------------------------*/
                
                // Permission check
                const is_owner = (d.created_by == valid_userid);
                const is_restricted = (valid_role == 2 && !is_owner && status != 1);

                // NEW ENTRY (no s2w_id yet)
                if (!status || status === 0) {
                    $("#btnSave").removeClass("d-none");
                }
                
                // RESTRICTED VIEW (Role 2 viewing others' records) - FORCE READ ONLY
                else if (is_restricted) {
                    $("#btnUpdate").addClass("d-none");
                    $("#btnSubmit").addClass("d-none");
                    $("#btnCancel").addClass("d-none");
                    $("#btnSave").addClass("d-none");

                    // Disable all form fields
                    $("#add-sorting-tab input, #add-sorting-tab textarea, #add-sorting-tab select")
                    .prop("disabled", true);

                    // DISABLE IMAGE UPLOAD
                    $("#correction_photo_s2w").prop("disabled", true);
                    $("label[for='correction_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old, .remove-new").remove();

                    // ALLOW ZOOM ONLY
                    $("#correction_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#preventive_photo_s2w").prop("disabled", true);
                    $("label[for='preventive_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old-correction, .remove-new-correction").remove();
                    $(".remove-old-preventive, .remove-new-preventive").remove();

                    // ALLOW ZOOM ONLY
                    $("#preventive_photo_existing .zoom-item").css("pointer-events", "auto");
                }

                // switch buttons: existing report → show Update + Submit
                else if (status == 1) {
                    // New report → show only Save
                    $("#btnSave").removeClass("d-none");
                    $("#btnUpdate").addClass("d-none");
                    $("#btnSubmit").addClass("d-none");
                }
                else if (status == 12 || status == 13 || status == 16) {
                    // Draft or Returned → allow editing + submit
                    $("#btnSave").addClass("d-none");
                    $("#btnUpdate").removeClass("d-none");
                    $("#btnSubmit").removeClass("d-none");
                }                
                else if (status == 10) {
                    // Pending approval → allow cancel                    
                    $("#btnCancel").removeClass("d-none");
                    $("#btnSave").addClass("d-none");
                    $("#btnUpdate").addClass("d-none");
                    $("#btnSubmit").addClass("d-none");

                    // Show Cancel button if it exists, otherwise create it
                    if ($("#btnCancel").length === 0) {
                        $("<button>", {
                            id: "btnCancel",
                            type: "button",
                            class: "btn btn-black",
                            'data-irid': d.rp_s2w_ir_id,
                            'data-srid': d.rp_s2w_sr_id,
                            'data-s2wid': d.rp_s2w_id,
                            'data-rpid': d.rp_id
                        })
                        .html('<i class="fa fa-times me-1"></i> Cancel S2W Report')
                        .appendTo(".text-end");
                    } else {
                        $("#btnCancel").removeClass("d-none");
                    }

                    // Disable all form fields
                    $(".s2w-section textarea").prop("disabled", true);

                    // DISABLE DELETE ICONS
                    $(".remove-old-correction, .remove-new-correction").remove();

                    // ALLOW ZOOM ONLY
                    $("#correction_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#correction_photo_s2w").prop("disabled", true);
                    $("label[for='correction_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old-preventive, .remove-new-preventive").remove();

                    // ALLOW ZOOM ONLY
                    $("#preventive_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#preventive_photo_s2w").prop("disabled", true);
                    $("label[for='preventive_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                } 
                else if (status == 5) {
                    // Pending approval → allow cancel                    
                    $("#btnCancel").removeClass("d-none");
                    $("#btnSave").addClass("d-none");
                    $("#btnUpdate").addClass("d-none");
                    $("#btnSubmit").addClass("d-none");

                    // Disable all form fields
                    $(".s2w-section textarea").prop("disabled", true);

                    // DISABLE DELETE ICONS
                    $(".remove-old-correction, .remove-new-correction").remove();

                    // ALLOW ZOOM ONLY
                    $("#correction_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#correction_photo_s2w").prop("disabled", true);
                    $("label[for='correction_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old-preventive, .remove-new-preventive").remove();

                    // ALLOW ZOOM ONLY
                    $("#preventive_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#preventive_photo_s2w").prop("disabled", true);
                    $("label[for='preventive_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                }    
                else {
                    // Approved, Cancelled, Review, anything non-editable
                    $("#btnSave").addClass("d-none");
                    $("#btnUpdate").addClass("d-none");
                    $("#btnSubmit").addClass("d-none");
                }

            }
        });
    }

    function buildS2WFormData(action) {
        let fd = new FormData();
        fd.append("action", action);

        fd.append("ir_id", $("#hidden_ir_id").val());
        fd.append("sr_id", $("#hidden_sr_id").val());
        fd.append("s2w_id", $("#hidden_s2w_id").val());  
        fd.append("s2w_docno", $("#hidden_docno").val());        
        fd.append("s2w_rp_status", $("#hidden_rp_status").val());

        const rp_id = $("#hidden_rp_id").val();
        if (rp_id) {
            fd.append("rp_id", rp_id);   // for update / submit
        }

        // text fields
        fd.append("fd_cronology", $("#fd_cronology").val());
        fd.append("fd_rootcause", $("#fd_rootcause").val());
        fd.append("fd_rootcause_area", $("#fd_rootcause_area").val());
        fd.append("fd_rootcause_place", $("#fd_rootcause_place").val());
        fd.append("fd_correction", $("#fd_correction").val());
        fd.append("fd_preventive", $("#fd_preventive").val());
        fd.append("fd_conclusion", $("#fd_conclusion").val());

        // NEW photos only – existing remain in DB
        new_correction_files.forEach(f => fd.append("correction_photo[]", f));
        new_preventive_files.forEach(f => fd.append("preventive_photo[]", f));

        return fd;
    }

    //FORM VALIDATION
    function validateField(id, label) {
        let val = $(id).val().trim();

        if (!val) {
            $(id).addClass("border-error");

            Swal.fire({
                title: "Missing Field",
                text: label + " is required.",
                icon: "warning",
                iconColor: "#286912",
                showCancelButton: true,
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                scrollToField(id);   // scroll AFTER alert closes
                $(id).focus();       // auto-focus field
            });

            return false;
        }

        $(id).removeClass("border-error");
        return true;
    }

    function validatePhotos(arrNew, arrExisting, label, scrollTarget) {

        console.log("New:", arrNew.length, "Existing:", arrExisting.length);

        if (arrNew.length === 0 && arrExisting.length === 0) {

            Swal.fire({
                title: label + " Photo Required",
                text: `Please add at least one ${label} photo.`,
                icon: "question",
                iconColor: "#286912",
                showCancelButton: true,
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                scrollToField(scrollTarget);  // scroll AFTER alert closes
            });

            return false;
        }
        return true;
    }
    
    //Validation Function
    function scrollToField(selector) {
        $('html, body').animate({
            scrollTop: $(selector).offset().top - 120   // adjust if header exists
        }, 400);
    }

    $("textarea, input").on("input", function() {
        $(this).removeClass("border-error");
    });

    //Save
    $(document).on('click', '#btnSave', function() {

        if (!validateField("#fd_cronology", "Cronology")) return;
        if (!validateField("#fd_rootcause", "Root Cause")) return;
        if (!validateField("#fd_rootcause_area", "Root Cause Area")) return;
        if (!validateField("#fd_rootcause_place", "Root Cause Place")) return;
        if (!validateField("#fd_correction", "Correction / Corrective")) return;
        if (!validatePhotos(new_correction_files, existing_correction_photos, "Correction", "#correction_photo_existing")) return;
        if (!validateField("#fd_preventive", "Preventive")) return;
        if (!validatePhotos(new_preventive_files, existing_preventive_photos, "Preventive", "#preventive_photo_existing")) return;
        if (!validateField("#fd_conclusion", "Conclusion")) return;

        let fd = buildS2WFormData("add_s2w_report");  // backend will INSERT and ignore rp_id

        Swal.fire({
            title: "Save record?",
            text : "Confirm save this S2W report?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            confirmButtonColor: "#198754"
        }).then(res => {
            if (!res.isConfirmed) return;

            $.ajax({
                url: "fetch-ip-s2w-section.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {

                    console.log("AJAX RESPONSE:", data);
                    
                    if (data.status === "success") {

                        const rp_id = data.insert_id;
                        const ir_id = data.ir_id;
                        const sr_id = data.sr_id;
                        const s2w_id = data.s2w_id;
                        const s2w_rp_status = data.s2w_rp_status;

                        // store rp_id in hidden field
                        if ($("#hidden_rp_id").length === 0) {
                            $("<input>", {
                                type: "hidden",
                                id: "hidden_rp_id",
                                value: rp_id
                            }).appendTo("body");
                        } else {
                            $("#hidden_rp_id").val(rp_id);
                        }

                        // attach data attributes if you still use them
                        $("#btnUpdate").attr({
                            "data-rpid": rp_id,
                            "data-s2wid": s2w_id,
                            "data-irid": ir_id,
                            "data-srid": sr_id
                        });

                        $("#btnSubmit").attr({
                            "data-rpid": rp_id,
                            "data-s2wid": s2w_id,
                            "data-irid": ir_id,
                            "data-srid": sr_id,
                            "data-s2wstatus": s2w_rp_status
                        });

                        // switch buttons
                        $("#btnSave").addClass("d-none");
                        $("#btnUpdate").removeClass("d-none");
                        $("#btnSubmit").removeClass("d-none");

                        Swal.fire({
                            title: "Saved!",
                            text: "S2W report saved successfully.",
                            icon: "success",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        });

                        // clear new files + inputs
                        new_correction_files = [];
                        new_preventive_files = [];
                        $("#correction_photo_s2w").val("");
                        $("#preventive_photo_s2w").val("");

                        $(".temp-photo").remove(); // remove previews

                        // reload all data & photos from DB (now using rp_id)
                        loadS2WDetailsById(s2w_id);
                    }
                }
            });
        });
    });

    //Update
    $(document).on('click', '#btnUpdate', function() {

        if (!validateField("#fd_cronology", "Cronology")) return;
        if (!validateField("#fd_rootcause", "Root Cause")) return;
        if (!validateField("#fd_rootcause_area", "Root Cause Area")) return;
        if (!validateField("#fd_rootcause_place", "Root Cause Place")) return;
        if (!validateField("#fd_correction", "Correction / Corrective")) return;
        if (!validatePhotos(new_correction_files, existing_correction_photos, "Correction", "#correction_photo_box")) return;
        if (!validateField("#fd_preventive", "Preventive")) return;
        if (!validatePhotos(new_preventive_files, existing_preventive_photos, "Preventive", "#preventive_photo_box")) return;
        if (!validateField("#fd_conclusion", "Conclusion")) return;

        let fd = buildS2WFormData("update_s2w_report");  // backend will UPDATE based on rp_id

        Swal.fire({
            //title: "Save changes to this S2W report?",
            text: "Save changes to this S2W report?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Save Changes",
            confirmButtonColor: "#198754"
        }).then(res => {
            if (!res.isConfirmed) return;

            $.ajax({
                url: "fetch-ip-s2w-section.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {
                    if (data.status === "success") {

                        Swal.fire({
                            title: "Updated!",
                            text: "S2W report updated successfully.",
                            icon: "success",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        });

                        // clear new files + inputs (uploaded already)
                        new_correction_files = [];
                        new_preventive_files = [];
                        $("#correction_photo_s2w").val("");
                        $("#preventive_photo_s2w").val("");

                        // reload from DB (include new photos)
                        loadS2WDetailsById($("#hidden_s2w_id").val());
                    }
                }
            });
        });
    });

    //Submit
    $(document).on('click', '#btnSubmit', function() {

        if (!validateField("#fd_cronology", "Cronology")) return;
        if (!validateField("#fd_rootcause", "Root Cause")) return;
        if (!validateField("#fd_rootcause_area", "Root Cause Area")) return;
        if (!validateField("#fd_rootcause_place", "Root Cause Place")) return;
        if (!validateField("#fd_correction", "Correction / Corrective")) return;
        if (!validatePhotos(new_correction_files, existing_correction_photos, "Correction", "#correction_photo_box")) return;
        if (!validateField("#fd_preventive", "Preventive")) return;
        if (!validatePhotos(new_preventive_files, existing_preventive_photos, "Preventive", "#preventive_photo_box")) return;
        if (!validateField("#fd_conclusion", "Conclusion")) return;

        let fd = buildS2WFormData("submit_s2w_report");  // backend: UPDATE + change status

        Swal.fire({
            title: "Submit",
            text: "Submit this S2W report for approval?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Submit",
            confirmButtonColor: "#198754"
        }).then(res => {
            if (!res.isConfirmed) return;

            $.ajax({
                url: "fetch-ip-s2w-section.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",
                beforeSend: function() {
                    Swal.fire({
                    title: 'Submitting...',
                    text: 'Please wait while we process your submission.',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                    });
                },
                success: function(data) {
                    if (data.status === "success") {

                        Swal.fire({
                            title: "Submitted!",
                            text: "S2W report submitted successfully.",
                            icon: "success",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        }).then(() => {
                            // redirect to view page or reload list
                            window.location.href = 'ip-s2w-sect.php';
                        });

                        // clear new files + inputs
                        new_correction_files = [];
                        new_preventive_files = [];
                        $("#correction_photo_s2w").val("");
                        $("#preventive_photo_s2w").val("");

                        // reload to reflect submitted status
                        loadS2WDetailsById($("#hidden_s2w_id").val());

                        // optionally disable editing here if status is submitted
                        // $("#btnUpdate, #btnSubmit").prop("disabled", true);
                    }
                }
            });
        });
    });

    // Load records
    $(document).ready(function () {

        const s2w_id = $("#hidden_s2w_id").val();

        if (s2w_id && s2w_id !== "0") {
            loadS2WDetailsById(s2w_id);

        } else {
            console.log("No S2W ID → Nothing to load.");

            $("#btnSave").removeClass("d-none");
            $("#btnUpdate, #btnSubmit").addClass("d-none");
        }
    });

    // Cancel
    $(document).on('click', '#btnCancel', function (e) {

        e.preventDefault();
        const ir_id = $(this).attr('data-irid');
        const sr_id = $(this).attr('data-srid');
        const s2w_id = $(this).attr('data-s2wid');
        const rp_id = $(this).attr('data-rpid');

        $('#cancel_ir_id').val(ir_id);
        $('#cancel_sr_id').val(sr_id);
        $('#cancel_s2w_id').val(s2w_id);
        $('#cancel_rp_id').val(rp_id);
        $('#cancel_remark').val('');
        $('#cancel_count').text('0');
        new bootstrap.Modal(document.getElementById('cancelRemarkModal')).show();
    });

    // Live count
    $('#cancel_remark').on('input', function(){
        $('#cancel_count').text(this.value.length);
    });

    // Submit cancellation (AJAX)
    // Remove border when user fixes the input
    $('#cancel_remark').on('change', function() {
        // $(this).removeClass('border-error');
        $('#cancel_remark').removeClass('border-error');
    }); 

    $('#cancelRemarkForm').on('submit', function(e){
        
        e.preventDefault();

        const ir_id = $('#cancel_ir_id').val();
        const sr_id = $('#cancel_sr_id').val();
        const s2w_id = $('#cancel_s2w_id').val();
        const rp_id = $('#cancel_rp_id').val();
        const remark = $('#cancel_remark').val().trim();

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing Reason',
                text: 'Please state the reason for cancellation.',
                confirmButtonColor: '#198754'
            });
            $('#cancel_remark').addClass('border-error');
            return;
        }
        $('#cancel_remark').removeClass('border-error');

        // Show confirmation first
        Swal.fire({
            title: 'Confirm Cancellation?',
            text: 'Are you sure you want to cancel this S2W report?',
            icon: 'warning',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: 'Yes, Cancel it',
            cancelButtonText: 'No, Keep it',
            confirmButtonColor: '#198754'
        }).then((result) => {
            if (result.isConfirmed) {
                const $btn = $('#btnConfirmCancel');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Canceling...');

                $.ajax({
                    url: 'fetch-ip-s2w-section.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { action: 'cancel_record', ir_id, sr_id, s2w_id, rp_id, remark },
                    success: function(res){
                        $btn.prop('disabled', false).html('<i class="fa fa-times me-1"></i> Confirm Cancel');

                        if (res.success) {

                            // Close modal
                            bootstrap.Modal.getInstance(document.getElementById('cancelRemarkModal')).hide();

                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Cancelled',
                                text: 'The record has been cancelled successfully.',
                                timer: 3000,
                                showConfirmButton: false
                            }).then(() => {
                                // redirect to view page or reload list
                                window.location.href = 'ip-s2w-sect.php';
                            });

                            // Redirect
                            // setTimeout(() => {
                            //     window.location.href = 'ip-s2w-sect.php';
                            // }, 2000);

                        } else {
                            alert(res.message || 'Cancel failed.');
                        }
                    },
                    error: function(xhr){
                        $btn.prop('disabled', false).html('<i class="fa fa-times me-1"></i>Confirm Cancel');
                        console.error(xhr.responseText);
                        alert('Server error while cancelling.');
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