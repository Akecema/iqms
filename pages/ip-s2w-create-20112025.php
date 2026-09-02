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
            align-items: center;
        }

        .avatar-list-stacked .avatar {
            margin-left: 0;
            border: 2px solid #fff;
            cursor: pointer;
            transition: transform 0.2s ease;
        }

        .avatar-list-stacked .avatar:first-child {
            margin-left: 0;
        }

        .avatar-sm {
            width: 50px;
            height: 50px;
            font-size: 0.75rem;
            text-align: center;
            line-height: 32px;
        }
        .avatar-sm:hover {
            transform: scale(1.52); /* optional: subtle zoom effect on hover */
        }
        
        .viewAvatar:hover {
            transform: scale(1.52); /* optional: subtle zoom effect on hover */
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

        </style>

		<?php

        $sridEnc = $_GET['srid'] ?? '';
        $eir_id = $_GET['irid'] ?? '';

        //decrypt
        $esr_id = decryptData($sridEnc);

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
                            <span class="accordion-header-text">Material Details</span>
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
                    <div class="col-xl-7">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="profile-blog">									
											
                                            <input type="hidden" id="hidden_ir_id" name="hidden_ir_id" class="form-control" value="<?= $eir_id ?>">
                                            <input type="hidden" id="hidden_sr_id" name="hidden_sr_id" class="form-control" value="<?= $esr_id ?>">

                                            <div class="mb-3 mt-4">
                                                <label class="form-label">Additional Information (If Any) </label>
                                                <textarea class="form-control" id="fd_addinfo" rows="3"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Sending To <span class="text-danger">*</span></label>                                            
                                                <select class="form-control select2-filter fd_dept" name="fd_dept" id="single-select">
                                                    <option value="">Select Department</option>
                                                    <?php
                                                    $sql_dept = "SELECT rd_dept_id, rd_dept_name FROM related_departments WHERE rd_dept_status = 'AC'
                                                                    ORDER BY rd_dept_id ASC";
                                                    $rst_dept = mysqli_query($db_con, $sql_dept);

                                                    while ($row_dept = mysqli_fetch_array($rst_dept)) {
                                                    ?>
                                                        <option value="<?php echo $row_dept['rd_dept_id']; ?>">
                                                            <?php echo $row_dept['rd_dept_name']; ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>                                            
                                            </div>

                                            <h6>Defect Photos (NG)</h6>
                                            <div class="mb-4">                                             
                                                <div id="defect_photo_existing" class="d-flex flex-wrap mb-2"></div>
                                                <div id="defect_photo_new" class="d-flex flex-wrap mb-2"></div>

                                                <input type="file" class="form-control d-none" id="defect_photo_s2w" name="defect_photo_s2w[]" multiple hidden>
                                                <label for="defect_photo_s2w" class="btn btn-primary light btn-sm btnImg"><i class="fa fa-upload me-1"></i> Add Image</label>
                                                                                            
                                                <small class="text-muted d-block btnText">Use Ctrl to select multiple images</small>
                                            </div>                         

                                            <div class="text-end mt-4 mb-4">
                                                <button type="button" id="btnSave" class="btn btn-black"> Save</button>
                                                <button type="button" id="btnUpdate" class="btn btn-black d-none"><i class="fa fa-check me-2"></i> Save Changes</button>
                                                <button type="button" id="btnSubmit" class="btn btn-black d-none"><i class="fa-solid fa-paper-plane me-2"></i> Submit</button>
                                            </div>
										</div>
									</div>
								</div>
							</div>
						</div>
                    </div>
                    <div class="col-xl-5">
                        <div class="card h-auto">
                            <div class="card-body">
                                <div class="profile-tab">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                             <li class="nav-item">
                                                <a href="#my-posts" data-bs-toggle="tab" class="nav-link active show viewRightDetail" data-irid="<?= $eir_id ?>">
                                                Inspection
                                                </a>
                                            </li>

                                            <li class="nav-item">
                                                <a href="#about-me" data-bs-toggle="tab" class="nav-link viewRightDetailSr" data-irid="<?= $eir_id ?>">
                                                Sorting
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
                            
                                <div class="mb-3">
                                    <label for="cancel_remark" class="form-label">Cancellation Remark <span class="text-danger">*</span></label>
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
        window.location.href = "ip-s2w.php";
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

        //--## S2W
        let existing_defect_photos = [];   // Photos already stored in DB
        let new_defect_files = [];         // Newly selected files not saved yet
        
        // Preview Renderer
        function renderDefectPhotos() {
            const box = $("#defect_photo_existing");
            box.empty();

            // --- EXISTING PHOTOS (from DB) ---
            existing_defect_photos.forEach(img => {
                box.append(`
                    <div class="position-relative me-2 mb-2 zoom-item"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${img.url}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;cursor:pointer"
                        data-id="${img.id}" data-s2w="${img.s2w_id}">

                        <span class="remove-old no-zoom"
                            style="position:absolute;top:-10px;right:-10px;
                            cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                    </div>
                `);
            });

            // --- NEW PHOTOS (selected from PC) ---
            new_defect_files.forEach((file, idx) => {
                const reader = new FileReader();
                reader.onload = e => {
                    box.append(`
                        <div class="position-relative me-2 mb-2 zoom-item"
                            style="width:80px;height:80px;border-radius:8px;
                            background-image:url('${e.target.result}');
                            background-size:cover;background-position:center;
                            border:1px solid #ddd;cursor:pointer">

                            <span class="remove-new no-zoom" data-idx="${idx}"
                                style="position:absolute;top:-10px;right:-10px;
                                cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                        </div>
                    `);
                };
                reader.readAsDataURL(file);
            });
        }

        // Load Photos from get_s2w_details
        function loadS2W(sr_id) {
            $.post("fetch-ip-s2w.php", { action: "get_s2w_details", sr_id }, res => {
                
                if (res.status !== "success") return;

                const d = res.data;

                existing_defect_photos = [];
                new_defect_files = [];

                if (d.photo_defect) {
                    d.photo_defect.forEach(p => {
                        existing_defect_photos.push({
                            id: p.defect_photoid,
                            s2w_id: d.s2w_id,
                            url: `gallery/s2w/defect/${d.s2w_id}/${p.file}`
                        });
                    });
                }

                renderDefectPhotos();
            }, "json");
        }

        // Add New Photo
        $("#defect_photo_s2w").on("change", function () {

            for (let f of this.files) {
                new_defect_files.push(f);
            }

            renderDefectPhotos();
            this.value = ""; // Reset file selector
        });

        //Remove New Photo (not uploaded yet)
        $(document).on("click", ".remove-new", function (e) {

            e.stopPropagation();   // HARD stop
            e.preventDefault();   

            new_defect_files.splice($(this).data("idx"), 1);
            renderDefectPhotos();
        });

        //Remove Existing Photo (stored in DB)
        $(document).on("click", ".remove-old", function (e) {

            e.stopPropagation();   // HARD stop
            e.preventDefault(); 

            const id = $(this).parent().data("id");
            const s2w_id = $(this).parent().data("s2w");

            Swal.fire({
                title: "Delete this photo?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete",
                confirmButtonColor: "#d33"
            }).then(r => {
                if (!r.isConfirmed) return;

                $.post("fetch-ip-s2w.php",
                    { action: "delete_defect_photo", id, s2w_id },
                    resp => {
                        if (resp.status === "success") {
                            existing_defect_photos =
                            existing_defect_photos.filter(x => x.id !== id);
                            renderDefectPhotos();
                        }
                    },
                    "json"
                );
            });
        });

        // Save / Update — Send New Files Only

        //For add
        new_defect_files.forEach(f =>
            formData.append("defect_photo_s2w[]", f)
        );

        //For update
        new_defect_files.forEach(f =>
            formData.append("defect_photo_s2w[]", f)
        );

        // CLICK ZOOM — Works for new + existing photos
        $(document).on("click", ".zoom-item", function (e) {

            // Ignore clicks on delete buttons
            if ($(e.target).hasClass("no-zoom") || $(e.target).hasClass("remove-old") || $(e.target).hasClass("remove-new"))
                return;

            const clickedUrl = $(this).data("url");

            // Build full list of all images
            zoomImages = [];

            // Existing images
            existing_defect_photos.forEach(p => zoomImages.push(p.url));

            // New (preview) images
            new_defect_files.forEach((f, i) => {
                zoomImages.push(
                    $("#defect_photo_existing .zoom-item").eq(i + existing_defect_photos.length).data("url")
                );
            });

            // Find index of clicked image
            zoomIndex = zoomImages.indexOf(clickedUrl);

            // Set modal image
            $("#zoomedImg").attr("src", clickedUrl);

            // Show modal
            $("#imgZoomModal").modal("show");
        });


        // Add/create S2W
        $(document).on('click', '#btnSave', function() {

            let add_info  = $("#fd_addinfo").val().trim();
            let send_dept = $(".fd_dept").val();

            if (!send_dept) {
                Swal.fire("Validation", "Sending To is required.", "warning");
                $('.fd_dept').next('.select2-container').find('.select2-selection').addClass('border-error');
                return false;
            } else {
                $(".fd_dept").removeClass("border-error");
            }

            let formData = new FormData();
            formData.append("action", "add_s2w");
            formData.append("ir_id", $("#hidden_ir_id").val());
            formData.append("sr_id", $("#hidden_sr_id").val());
            formData.append("add_info", add_info);
            formData.append("send_dept", send_dept);

            // Add new photos only
            new_defect_files.forEach(f => formData.append("defect_photo_s2w[]", f));

            Swal.fire({
                title: "Confirm Save?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Save",
                confirmButtonColor: "#198754"
            }).then(res => {
                if (!res.isConfirmed) return;

                $.ajax({
                    url: "fetch-ip-s2w.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",

                    success: function(data) {
                        if (data.status === "success") {

                            // Reset new images
                            defectFiles = [];
                            $("#defect_photo_s2w").val("");

                            const s2w_id = data.insert_id;
                            const ir_id = data.ir_id;
                            const sr_id = data.sr_id;
                            const s2w_status = data.s2w_status;

                            // Attach the correct S2W ID to both update buttons
                            $("#btnUpdate").attr({
                                "data-s2wid": s2w_id,
                                "data-irid": ir_id,
                                "data-srid": sr_id
                            });

                            $("#btnSubmit").attr({
                                "data-s2wid": s2w_id,
                                "data-irid": ir_id,
                                "data-srid": sr_id,
                                "data-s2wstatus": s2w_status
                            });

                            // Store hidden S2W ID
                            if (!$("#hidden_s2w_id").length) {
                                $("<input>", {
                                    type: "hidden",
                                    id: "hidden_s2w_id",
                                    value: s2w_id
                                }).appendTo(".card-body");
                            } else {
                                $("#hidden_s2w_id").val(s2w_id);
                            }

                            // Switch buttons
                            $("#btnSave").addClass("d-none");
                            $("#btnUpdate").removeClass("d-none");
                            $("#btnSubmit").removeClass("d-none");

                            Swal.fire({
                                title: "Saved!",
                                text: "S2W record saved successfully.",
                                icon: "success",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#28a745"   // <-- GREEN button
                            });
                        }
                    }
                });
            });
        });

        // Remove border error on slect 2
        $('.fd_dept').on('change', function() {
            if ($(this).val()) {
                $(this).next('.select2-container').find('.select2-selection').removeClass('border-error');
            }
        });

        // Load Existing Record 
        $(document).ready(function () {

            const sr_id = $("#hidden_sr_id").val();
            if (!sr_id) return;

            $.ajax({
                url: "fetch-ip-s2w.php",
                type: "POST",
                data: { action: "get_s2w_details", sr_id },
                dataType: "json",

                success: function (res) {

                    if (res.status !== "success") return;

                    const d = res.data;

                    // Store S2W ID & STATUS into hidden inputs (always)
                    $("#hidden_s2w_id").val(d.s2w_id);
                    $("#hidden_s2w_status").val(d.s2w_status);

                    // Also store in localStorage
                    localStorage.setItem("s2w_id", d.s2w_id);
                    localStorage.setItem("s2w_status", d.s2w_status);

                    console.log("AFTER AJAX -> S2W ID:", d.s2w_id, "Status:", d.s2w_status, "IR ID:", d.ir_id, "SR ID:", d.sr_id);

                    /* -----------------------------------------
                    1. Fill basic fields
                    --------------------------------------------*/
                    $("#fd_addinfo").val(d.s2w_additional_desc || "");
                    $(".fd_dept").val(d.s2w_send_to || "").trigger("change");

                    /* -----------------------------------------
                    2. Reset new image selection
                    --------------------------------------------*/
                    defectFiles = [];
                    $("#defect_photo_s2w").val("");

                    existing_defect_photos = [];

                    if (d.photo_defect && d.photo_defect.length > 0) {
                        d.photo_defect.forEach(p => {
                            existing_defect_photos.push({
                                id: p.defect_photoid,
                                s2w_id: d.s2w_id,
                                url: `gallery/s2w/defect/${d.s2w_id}/${p.file}`
                            });
                        });
                    }

                    renderDefectPhotos();

                    /* -----------------------------------------
                    4. Set hidden s2w_id properly
                    --------------------------------------------*/
                    if ($("#hidden_s2w_id").length === 0) {
                        $("<input>", {
                            type: "hidden",
                            id: "hidden_s2w_id",
                            value: d.s2w_id || ""
                        }).appendTo(".card-body");
                    } else {
                        $("#hidden_s2w_id").val(d.s2w_id || "");
                    }

                    if (!$("#hidden_s2w_status").length) {
                        $("<input>", {
                            type: "hidden",
                            id: "hidden_s2w_status",
                            value: d.s2w_status
                        }).appendTo(".card-body");
                    } else {
                        $("#hidden_s2w_status").val(d.s2w_status);
                    }

                    /* -----------------------------------------
                    5. Button visibility logic (clean version)
                    --------------------------------------------*/

                    // STATUS LOGIC
                    const s2w_status = parseInt(d.s2w_status);

                    // NEW ENTRY (no s2w_id yet)
                    if (!s2w_status || s2w_status === "0") {
                        $("#btnSave").removeClass("d-none");
                    }

                    // DRAFT (13) or RETURNED (12) → allow UPDATE + SUBMIT
                    else if (s2w_status === 12 || s2w_status === 13) {
                        $("#btnUpdate").removeClass("d-none");
                        $("#btnSubmit").removeClass("d-none");
                        $("#btnSave").addClass("d-none");
                    }

                    // PENDING REVIEW → show CANCEL BUTTON ONLY
                    else if (s2w_status === 9) {
                        $("#btnSave").addClass("d-none");
                        $("#btnCancel").removeClass("d-none");

                        // Show Cancel button if it exists, otherwise create it
                        if ($("#btnCancel").length === 0) {
                            $("<button>", {
                                id: "btnCancel",
                                type: "button",
                                class: "btn btn-black",
                                'data-irid': d.ir_id,
                                'data-srid': d.sr_id,
                                'data-s2wid': d.s2w_id
                            })
                            .html('<i class="fa fa-times me-1"></i> Cancel S2W')
                            .appendTo(".text-end");
                        } else {
                            $("#btnCancel").removeClass("d-none");
                        }

                        // Disable all form fields
                        $("#add-sorting-tab textarea, #add-sorting-tab select")
                        .prop("disabled", true);

                        // DISABLE IMAGE UPLOAD
                        $("#defect_photo_s2w").prop("disabled", true);
                        $("label[for='defect_photo_s2w']").addClass("disabled").css({
                            opacity: 0.4,
                            pointerEvents: "none"
                        });

                        // DISABLE DELETE ICONS
                        $(".remove-old, .remove-new").remove();

                        // ALLOW ZOOM ONLY
                        $("#defect_photo_existing .zoom-item").css("pointer-events", "auto");

                    }

                    // APPROVED / CANCELLED / PENDING APPROVAL → VIEW ONLY
                    else if (s2w_status === 4 || s2w_status === 8 || s2w_status === 10) {
                        $("#btnUpdate").addClass("d-none");
                        $("#btnSubmit").addClass("d-none");
                        $("#btnCancel").addClass("d-none");

                        // Disable all form fields
                        $("#add-sorting-tab input, #add-sorting-tab textarea, #add-sorting-tab select")
                        .prop("disabled", true);

                        // DISABLE IMAGE UPLOAD
                        $("#defect_photo_s2w").prop("disabled", true);
                        $("label[for='defect_photo_s2w']").addClass("disabled").css({
                            opacity: 0.4,
                            pointerEvents: "none"
                        });

                        // DISABLE DELETE ICONS
                        $(".remove-old, .remove-new").remove();

                        // ALLOW ZOOM ONLY
                        $("#defect_photo_existing .zoom-item").css("pointer-events", "auto");
                    }

                    /* -----------------------------------------
                    7. Re-init tooltips
                    --------------------------------------------*/
                    initTooltips();
                }
            });
        });

        // Update
        $(document).on('click', '#btnUpdate', function() {

            let add_info  = $("#fd_addinfo").val().trim();
            let send_dept = $(".fd_dept").val();

            if (!send_dept) {
                Swal.fire("Validation", "Sending To is required.", "warning");
                $('.fd_dept').next('.select2-container').find('.select2-selection').addClass('border-error');
                return false;
            } else {
                $(".fd_dept").removeClass("border-error");
            }

            let formData = new FormData();

            formData.append("action", "update_s2w");
            formData.append("ir_id", $("#hidden_ir_id").val());
            formData.append("sr_id", $("#hidden_sr_id").val());
            formData.append("s2w_id", $("#hidden_s2w_id").val());
            formData.append("add_info", $("#fd_addinfo").val());
            formData.append("send_dept", $(".fd_dept").val());

            // Only send NEW images
            new_defect_files.forEach(f => formData.append("defect_photo_s2w[]", f));

            Swal.fire({
                title: "Confirm Update?",
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#198754"
            }).then(r => {
                if (!r.isConfirmed) return;

                $.ajax({
                    url: "fetch-ip-s2w.php",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",

                    success: function(res) {
                        if (res.status === "success") {

                            new_defect_files = [];
                            existing_defect_photos = []; 
                            $("#defect_photo_s2w").val("");

                            Swal.fire({
                                title: "Updated!",
                                text: "S2W record update successfully.",
                                icon: "success",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#28a745"   // <-- GREEN button
                            }).then(() => location.reload());

                            // Swal.fire("Updated!", res.message, "success")
                            //     .then(() => location.reload());
                        }
                    }
                });
            });
        });

        // Submit
        $(document).on('click', '#btnSubmit', function() {

            let add_info  = $("#fd_addinfo").val().trim();
            let send_dept = $(".fd_dept").val();

            if (!send_dept) {
                Swal.fire("Validation", "Sending To is required.", "warning");
                $('.fd_dept').next('.select2-container').find('.select2-selection').addClass('border-error');
                return false;
            } else {
                $(".fd_dept").removeClass("border-error");
            }

            const ir_id = $("#hidden_ir_id").val();
            const sr_id = $("#hidden_sr_id").val();
            const s2w_id = $("#hidden_s2w_id").val();
            const s2w_status = $("#hidden_s2w_status").val();

            // Also store in localStorage
            localStorage.setItem("s2w_id", s2w_id);
            localStorage.setItem("s2w_status", s2w_status);

            console.log("Submit clicked for:", ir_id, sr_id, s2w_id, s2w_status);

            Swal.fire({
                title: "Submit this S2W for review?",
                // text: "Submit this S2W for review?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, Submit",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#198754"
            }).then((result) => {
                if (!result.isConfirmed) return;

                let formData = new FormData();
                formData.append('action', 'submit_for_review');
                formData.append('sr_id', sr_id);
                formData.append('ir_id', ir_id);
                formData.append('s2w_id', s2w_id);
                formData.append('s2w_status', s2w_status);
                formData.append("add_info", $("#fd_addinfo").val());
                formData.append("send_dept", $(".fd_dept").val());

                new_defect_files.forEach(f => formData.append("defect_photo_s2w[]", f));
                
                $.ajax({
                url: 'fetch-ip-s2w.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                defectSend: function() {
                    Swal.fire({
                    title: 'Submitting...',
                    text: 'Please wait while we process your sorting report.',
                    allowOutsideClick: false,
                    didOpen: () => Swal.showLoading()
                    });
                },
                success: function(res) {
                    Swal.close();

                    if (res.success) {

                    let emailMessage = '';
                    if (res.emails_sent > 0 || res.emails_failed > 0) {
                        emailMessage = `\n\nEmail summary:\n Sent: ${res.emails_sent}\n Failed: ${res.emails_failed}`;
                        if (res.emails_failed > 0 && res.failed_list.length > 0) {
                            emailMessage += `\n\nFailed recipients:\n${res.failed_list.join('\n')}`;
                        }
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Submitted!',
                        text: res.msg || 'Your S2W was submitted for approval.',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {
                        // redirect to view page or reload list
                        window.location.href = 'ip-s2w.php';
                    });
                    } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: res.msg || 'Failed to submit.',
                    });
                    }
                },
                error: function(xhr, status, error) {
                    Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred: ' + (xhr.responseText || error),
                    });
                }
                });
            });
        });

        // Cancel
        $(document).on('click', '#btnCancel', function (e) {

            e.preventDefault();
            const ir_id = $(this).attr('data-irid');
            const sr_id = $(this).attr('data-srid');
            const s2w_id = $(this).attr('data-s2wid');

            $('#cancel_ir_id').val(ir_id);
            $('#cancel_sr_id').val(sr_id);
            $('#cancel_s2w_id').val(s2w_id);
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
            const remark = $('#cancel_remark').val().trim();

            if (!remark) {
                alert('Please state the reason for cancellation.');
                $('#cancel_remark').addClass('border-error');
                return;
            } else {
                $('#cancel_remark').removeClass('border-error');
            }

            // Show confirmation first
            Swal.fire({
                title: 'Confirm Cancellation?',
                text: 'Are you sure you want to cancel this S2W?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, Cancel it',
                cancelButtonText: 'No, Keep it',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#198754'
            }).then((result) => {
                if (result.isConfirmed) {
                    const $btn = $('#btnConfirmCancel');
                    $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Canceling...');

                    $.ajax({
                        url: 'fetch-ip-s2w.php',
                        type: 'POST',
                        dataType: 'json',
                        data: { action: 'cancel_record', ir_id, sr_id, s2w_id, remark },
                        success: function(res){
                            $btn.prop('disabled', false).html('<i class="fa fa-times me-1"></i> Confirm Cancel');

                            if (res.success) {

                                // Close modal
                                bootstrap.Modal.getInstance(document.getElementById('cancelRemarkModal')).hide();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Cancelled',
                                    text: 'The record has been cancelled successfully.',
                                    timer: 3000,
                                    showConfirmButton: false
                                });

                                // Redirect
                                setTimeout(() => {
                                    window.location.href = 'ip-s2w.php';
                                }, 2000);

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
        function loadRightDetailSr(ir_id) {
            $.ajax({
                url: "get-sorting-details.php",
                method: "POST",
                dataType: 'html',
                data: { ir_id: ir_id },
                beforeSend: function() {
                    $("#sortingRightDetail").html("<div class='text-center p-3'>Loading...</div>");
                },
                success: function(html) {
                    $("#sortingRightDetail").html(html);
                }
            });
        }

        $(document).on("click", ".viewRightDetailSr", function () {
            let ir_id = $(this).data("irid");
            loadRightDetailSr(ir_id);
        });

    </script>
    
</body>
</html>