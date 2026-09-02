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

        /* related part */
        .dept-select + .select2-container {
            width: 140px !important;  /* adjust only customer select */
        }

        .part-select + .select2-container {
            width: 180px !important;  /* adjust only customer select */
        }

        .partno-select + .select2-container {
            width: 160px !important;  /* adjust only customer select */
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

        .position-relative:hover {
            transform: scale(1.05);
            transition: 0.2s ease-in-out;
            z-index: 2;            
            cursor: zoom-in;
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
        
        </style>

		<?php

        $sridEnc = $_GET['srid'] ?? '';
        $statusEnc = $_GET['status'] ?? '';
        $eir_id = $_GET['irid'] ?? '';
        $epg = $_GET['pg'] ?? "";

        //decrypt
        $esr_id = decryptData($sridEnc);
        $estatus = decryptData($statusEnc);

        //get docno        
        $stmt = $db_con->prepare("SELECT S.sr_docno
                                    FROM inspection_sorting S 
                                        WHERE S.sr_id = ?");
        $stmt->bind_param('s', $esr_id);
        $stmt->execute();
        $sortingdet = $stmt->get_result()->fetch_assoc();        
    
        $edocno = $sortingdet['sr_docno'] ?? "";

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
                    <div class="col-xxl-9 col-xl-8">
                        <div class="card mb-4">
                            <div class="card-header border-0 ai-tabs-1 mb-4">
                                
                                <h4 class="card-title"></h4>
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item"><a href="#add-sorting-tab" class="nav-link active show"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="p-1"> Sorting</span></a></li>
                                    <li class="nav-item"><a href="#part-involve-tab" onclick="window.location.href='ip-sorting-part-involve-edit.php?srid=<?=$sridEnc?>&&irid=<?=$eir_id?>&&pg=<?=$epg?>'" class="nav-link"><i class="fa fa-list" aria-hidden="true"></i> <span class="p-1">Part Involve</span></a></li>
                                </ul>
                            </div>

                            <div class="tab-content" id="myTabContent">                            
                                        
                                <input type="hidden" id="hidden_sr_id" name="hidden_sr_id" class="form-control" value="<?=$esr_id;?>">
                                <input type="hidden" id="hidden_ir_id" name="hidden_ir_id" class="form-control" value="<?=$eir_id;?>">

                                <!-- Sorting Qty & method -->
                                <div class="tab-pane fade show active" id="add-sorting-tab" role="tabpanel" aria-labelledby="create-tab" tabindex="0">    
                                    <div class="card-body ai-tabs-1 py-2"> 

                                        <!-- Hidden Fields -->
                                        <input type="hidden" id="hidden_ir_id" value="<?= $eir_id ?>">
                                        <div class="row g-4">
                                            <div class="col-md-6 mb-1 divDocno">
                                                <!-- DOC NO -->
                                                <div class="field-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-file-text"></i> Doc No
                                                    </h6>
                                                    <div>
                                                        <h6 class="mb-0 fw-semibold viewDocno"></h6>
                                                    </div>  
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row g-4">

                                            <!-- ========================================== -->
                                            <!-- LEFT COLUMN -->
                                            <!-- ========================================== -->
                                            <div class="col-md-12">
                                                <!-- ALL LEFT CONTENT HERE -->
                                                <div class="field-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-hashtag"></i> Quantity
                                                    </h6>
                                                    <!-- Qty Inputs -->                                             
                                                    <div class="photo-box d-flex flex-wrap mb-2">
                                                        <div class="row mb-4 mt-2">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Qty OK <span class="text-danger p-1">*</span></label>
                                                                <input type="number" id="sr_qty_ok" min="0" name="sr_qty_ok" class="form-control">
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Qty NG <span class="text-danger p-1">*</span></label>
                                                                <input type="number" id="sr_qty_ng" min="0" name="sr_qty_ng" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="field-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-sync-alt"></i> Sorting Method  <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="sr_sorting" rows="3"></textarea>
                                                </div>

                                                <div class="field-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-tools"></i> Rework Method <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="sr_rework" rows="3"></textarea>
                                                </div>

                                                <div class="field-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-comment-alt"></i> Remarks <span class="text-danger p-1">*</span>
                                                    </h6>
                                                    <textarea class="form-control" id="sr_remarks" rows="3"></textarea>
                                                </div>

                                            </div>

                                            <!-- ========================================== -->
                                            <!-- RIGHT COLUMN -->
                                            <!-- ========================================== -->
                                            <div class="col-md-12">

                                                <div class="field-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-image"></i> Photos Before (NG) <span class="text-danger p-1">*</span>
                                                    </h6>

                                                    <div class="photo-box mb-2 d-flex flex-wrap" id="before_photo_existing"></div>

                                                    <input type="file" id="before_photo" name="before_photo[]" multiple hidden>
                                                    <label for="before_photo" class="btn btn-primary light btn-sm btnImg">
                                                        <i class="fa fa-upload me-1"></i> Add Image
                                                    </label>
                                                    <div class="s2w-small-text">Use Ctrl to select multiple images</div>
                                                </div>

                                                <div class="field-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-image"></i> Photos After Sorting (OK) <span class="text-danger p-1">*</span>
                                                    </h6>

                                                    <div class="photo-box mb-2 d-flex flex-wrap" id="after_photo_existing"></div>

                                                    <input type="file" id="after_photo" name="after_photo[]" multiple hidden>
                                                    <label for="after_photo" class="btn btn-primary light btn-sm btnImg">
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

                    <div class="col-xxl-3 col-xl-4 mb-4">                        
                        <!-- Timeline -->
                        <div class="recent-post"> </div>
                    </div>

                    <!-- Modal for image zoom -->
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

    <script>

    // --- GLOBAL ARRAYS ---
    let existing_before_photos = [];   // {id, sr_id, url}
    let new_before_files = [];         // File objects to upload

    let existing_after_photos = [];
    let new_after_files = [];

    //Render EXISTING photos (DB)
    function renderBeforePhotos() {
        const box = $("#before_photo_existing");
        box.empty();

        existing_before_photos.forEach((img, index) => {
            box.append(`
                <div class="position-relative me-2 mb-2 zoom-item"
                    style="width:80px;height:80px;border-radius:8px;
                    background-image:url('${img.url}');
                    background-size:cover;background-position:center;
                    border:1px solid #ddd;cursor:zoom-in"
                    data-id="${img.id}" 
                    data-srid="${img.sr_id}"
                    data-index="${index}"
                >
                    <span class="remove-icon remove-old-before">&times;</span>
                </div>
            `);
        });
    }

    function renderAfterPhotos() {
        const box = $("#after_photo_existing");
        box.empty();

        existing_after_photos.forEach((img, index) => {
            box.append(`
                <div class="position-relative me-2 mb-2 zoom-item"
                    style="width:80px;height:80px;border-radius:8px;
                    background-image:url('${img.url}');
                    background-size:cover;background-position:center;
                    border:1px solid #ddd;cursor:zoom-in"
                    data-id="${img.id}" 
                    data-srid="${img.sr_id}"
                    data-index="${index}"
                >
                    <span class="remove-icon remove-old-after">&times;</span>
                </div>
            `);
        });
    }

    // before – add new photos (for Save, Update, Submit)
    //Render NEW photo previews
    $("#before_photo").on("change", function(e) {
        const files = Array.from(e.target.files);

        files.forEach((file, index) => {
            const previewIndex = new_before_files.length;

            new_before_files.push(file);

            const reader = new FileReader();
            reader.onload = function(ev) {
                $("#before_photo_existing").append(`
                    <div class="position-relative me-2 mb-2 new-photo"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${ev.target.result}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;"
                        data-newindex="${previewIndex}"
                    >
                        <span class="remove-icon remove-new-before">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    });

    // after – add new photos
    $("#after_photo").on("change", function(e) {
        const files = Array.from(e.target.files);

        files.forEach((file, index) => {
            const previewIndex = new_after_files.length;

            new_after_files.push(file);

            const reader = new FileReader();
            reader.onload = function(ev) {
                $("#after_photo_existing").append(`
                    <div class="position-relative me-2 mb-2 new-photo"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${ev.target.result}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;"
                        data-newindex="${previewIndex}"
                    >
                        <span class="remove-icon remove-new-after">&times;</span>
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
    $(document).on("click", ".remove-old-before", function(e) {
        e.stopPropagation();

        let box = $(this).closest("div");
        let photoId = box.data("id");
        let sr_id   = box.data("srid");

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

            $.post("fetch-ip-sorting.php", {
                action: "delete_before_photo",
                id: photoId,
                sr_id: sr_id
            }, function(resp) {
                box.remove();
                existing_before_photos = existing_before_photos.filter(p => p.id != photoId);
            }, "json");
        });
    });

    $(document).on("click", ".remove-old-after", function(e) {
        e.stopPropagation();

        let box = $(this).closest("div");
        let photoId = box.data("id");
        let sr_id   = box.data("srid");

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

            $.post("fetch-ip-sorting.php", {
                action: "delete_after_photo",
                id: photoId,
                sr_id: sr_id
            }, function(resp) {
                box.remove();
                existing_after_photos = existing_after_photos.filter(p => p.id != photoId);
            }, "json");
        });
    });

    //Delete NEW photos (not uploaded yet)
    $(document).on("click", ".remove-new-before", function(e) {
        e.stopPropagation();

        let box = $(this).closest("div");
        let index = box.data("newindex");

        // remove from local array
        new_before_files.splice(index, 1);

        // remove from UI
        box.remove();
    });

    $(document).on("click", ".remove-new-after", function(e) {
        e.stopPropagation();

        let box = $(this).closest("div");
        let index = box.data("newindex");

        new_after_files.splice(index, 1);
        box.remove();
    });

    // Load record
    function loadSortingDetailsById(ir_id) {
        $.ajax({
            url: "fetch-ip-sorting.php",
            type: "POST",
            data: { action: "get_sorting_details", ir_id: ir_id },
            dataType: "json",
            success: function(res) {

                console.log("RAW RESPONSE:", res);
                console.log("Before photos returned:", res.data.before_photo);
                console.log("After photos returned:", res.data.after_photo);
                console.log("SR ID:", res.data.sr_id);
                console.log("SR STATUS:", res.data.sr_status);

                if (res.status !== "success" || !res.data) return;

                const d = res.data;
                const status = d.sr_status;

                // sr_id from DB 
                const sr_id = d.sr_id;
                const ir_id = d.ir_id;

                // set hidden sr_id
                if ($("#hidden_sr_id").length === 0) {
                    $("<input>", { type: "hidden", id: "hidden_sr_id", value: sr_id })
                        .appendTo("body");
                } else {
                    $("#hidden_sr_id").val(sr_id);
                }

                //set hidden report status
                if ($("#hidden_sr_status").length === 0) {
                    $("<input>", { type: "hidden", id: "hidden_sr_status", value: status })
                        .appendTo("body");
                } else {
                    $("#hidden_sr_status").val(status);
                }

                // text fields
                $("#sr_qty_ok").val(d.sr_qty_ok || "");
                $("#sr_qty_ng").val(d.sr_qty_ng || "");
                $("#sr_sorting").val(d.sr_sorting_method || "");
                $("#sr_rework").val(d.sr_rework_method || "");
                $("#sr_remarks").val(d.sr_remarks || "");

                // show/hide Doc No label
                if (d.sr_status !== 1 && d.sr_status !== 13) {
                    $(".divDocno .viewDocno").html(d.sr_docno);
                    $(".divDocno .viewStatus").html(d.sr_statusname);
                    $(".divDocno").removeClass("d-none");
                } else {
                    $(".divDocno").addClass("d-none");
                }

                // reset arrays
                existing_before_photos = [];
                existing_after_photos = [];
                new_before_files = [];
                new_after_files = [];

                if (d.before_photo) {
                    d.before_photo.forEach(p => {
                        existing_before_photos.push({
                            id: p.before_photoid,
                            sr_id: sr_id,
                            url: `gallery/inspection_sorting/before/${sr_id}/${p.file}`
                        });
                    });
                }

                if (d.after_photo) {
                    d.after_photo.forEach(p => {
                        existing_after_photos.push({
                            id: p.after_photoid,
                            sr_id: sr_id,
                            url: `gallery/inspection_sorting/after/${sr_id}/${p.file}`
                        });
                    });
                }

                renderBeforePhotos();
                renderAfterPhotos();

                // switch buttons: existing report → show Update + Submit
                if (status == 1) {
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
                else if (status == 9) {
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
                            'data-irid': d.ir_id,
                            'data-srid': d.sr_id
                        })
                        .html('<i class="fa fa-times me-1"></i> Cancel Sorting')
                        .appendTo(".text-end");
                    } else {
                        $("#btnCancel").removeClass("d-none");
                    }

                    // Disable all form fields
                    $(".field-section textarea").prop("disabled", true);
                    $("#sr_qty_ok, #sr_qty_ng").prop("disabled", true); 

                    // DISABLE DELETE ICONS
                    $(".remove-old-before, .remove-new-before").remove();

                    // ALLOW ZOOM ONLY
                    $("#before_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#before_photo").prop("disabled", true);
                    $("label[for='before_photo']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old-after, .remove-new-after").remove();

                    // ALLOW ZOOM ONLY
                    $("#after_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#after_photo").prop("disabled", true);
                    $("label[for='after_photo']").addClass("disabled").css({
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
                    $(".field-section textarea").prop("disabled", true);
                    $("#sr_qty_ok, #sr_qty_ng").prop("disabled", true); 

                    // DISABLE DELETE ICONS
                    $(".remove-old, .remove-new").remove();

                    // ALLOW ZOOM ONLY
                    $("#before_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#before_photo").prop("disabled", true);
                    $("label[for='before_photo']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old-after, .remove-new-after").remove();

                    // ALLOW ZOOM ONLY
                    $("#after_photo_existing .zoom-item").css("pointer-events", "auto");

                    $("#after_photo").prop("disabled", true);
                    $("label[for='after_photo']").addClass("disabled").css({
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

    function buildSortingFormData(action) {
        let fd = new FormData();
        fd.append("action", action);

        fd.append("ir_id", $("#hidden_ir_id").val());  

        const sr_id = $("#hidden_sr_id").val();

        if (sr_id) {
            fd.append("sr_id", sr_id);   // for update / submit
        }

        const srStatus = $("#hidden_sr_status").length 
            ? $("#hidden_sr_status").val() 
            : 1; // NEW 

        fd.append("sr_status", srStatus);

        // text fields
        fd.append("qty_ok", $("#sr_qty_ok").val());
        fd.append("qty_ng", $("#sr_qty_ng").val());
        fd.append("sorting_method", $("#sr_sorting").val());
        fd.append("rework_method", $("#sr_rework").val());
        fd.append("remarks", $("#sr_remarks").val());

        // NEW photos only – existing remain in DB
        new_before_files.forEach(f => fd.append("before_photo[]", f));
        new_after_files.forEach(f => fd.append("after_photo[]", f));

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

    //Save
    $(document).on('click', '#btnSave', function() {

        if (!validateField("#sr_qty_ok", "Qty Ok")) return;
        if (!validateField("#sr_qty_ng", "Qty NG")) return;
        if (!validateField("#sr_sorting", "Sorting Method")) return;
        if (!validateField("#sr_rework", "Rework Method")) return;
        if (!validateField("#sr_remarks", "Remarks")) return;
        if (!validatePhotos(new_before_files, existing_before_photos, "Before", "#before_photo_existing")) return;
        if (!validatePhotos(new_after_files, existing_after_photos, "After", "#after_photo_existing")) return;

        let fd = buildSortingFormData("add_sorting");  // backend will INSERT and ignore sr_id

        const eir_id = <?= $eir_id ?>;

        Swal.fire({
            title: "Save sorting record",
            text : "Confirm save this sorting record?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            confirmButtonColor: "#198754"
        }).then(res => {
            if (!res.isConfirmed) return;

            $.ajax({
                url: "fetch-ip-sorting.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {

                    console.log("AJAX RESPONSE:", data);
                    
                    if (data.status === "success") {

                        const sr_id = data.insert_id;
                        const ir_id = data.ir_id;
                        const sr_status = data.sr_status;

                        // store sr_id in hidden field
                        if ($("#hidden_sr_id").length === 0) {
                            $("<input>", {
                                type: "hidden",
                                id: "hidden_sr_id",
                                value: sr_id
                            }).appendTo("body");
                        } else {
                            $("#hidden_sr_id").val(sr_id);
                        }

                        // attach data attributes if you still use them
                        $("#btnUpdate").attr({
                            "data-srid": sr_id,
                            "data-irid": ir_id
                        });

                        $("#btnSubmit").attr({
                            "data-srid": sr_id,
                            "data-irid": ir_id,
                            "data-srstatus": sr_status
                        });

                        // switch buttons
                        $("#btnSave").addClass("d-none");
                        $("#btnUpdate").removeClass("d-none");
                        $("#btnSubmit").removeClass("d-none");

                        Swal.fire({
                            title: "Saved!",
                            text: "Sorting record saved successfully.",
                            icon: "success",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        });

                        // clear new files + inputs
                        new_before_files = [];
                        new_after_files = [];
                        $("#before_photo").val("");
                        $("#after_photo").val("");

                        $(".temp-photo").remove(); // remove previews

                        // store in localStorage
                        localStorage.setItem("ir_id", ir_id);
                        localStorage.setItem("sr_id", sr_id);
                        
                        window.location.href = `ip-sorting-part-involve.php?erid=${eir_id}&sid=${data.insert_id}`;  
                    }
                }
            });
        });
    });

    //Update
    $(document).on('click', '#btnUpdate', function() {

        if (!validateField("#sr_qty_ok", "Qty Ok")) return;
        if (!validateField("#sr_qty_ng", "Qty NG")) return;
        if (!validateField("#sr_sorting", "Sorting Method")) return;
        if (!validateField("#sr_rework", "Rework Method")) return;
        if (!validateField("#sr_remarks", "Remarks")) return;
        if (!validatePhotos(new_before_files, existing_before_photos, "Before", "#before_photo_existing")) return;
        if (!validatePhotos(new_after_files, existing_after_photos, "After", "#after_photo_existing")) return;

        let fd = buildSortingFormData("update_sorting");  // backend will UPDATE based on sr_id

        Swal.fire({
            title: "Save changes?",
            text: "Save changes to this sorting record?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Save Changes",
            confirmButtonColor: "#198754"
        }).then(res => {
            if (!res.isConfirmed) return;

            $.ajax({
                url: "fetch-ip-sorting.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function(data) {
                    if (data.status === "success") {

                        Swal.fire({
                            title: "Updated!",
                            text: "Sorting record updated successfully.",
                            icon: "success",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        });

                        // clear new files + inputs (uploaded already)
                        new_before_files = [];
                        new_after_files = [];
                        $("#before_photo").val("");
                        $("#after_photo").val("");

                        // reload from DB (include new photos)
                        loadSortingDetailsById($("#hidden_ir_id").val());
                    }
                }
            });
        });
    });

    // Load records
    $(document).ready(function () {

        const ir_id = $("#hidden_ir_id").val();

        if (ir_id && ir_id !== "0") {
            loadSortingDetailsById(ir_id);

        } else {
            console.log("No IRID → Nothing to load.");

            $("#btnSave").removeClass("d-none");
            $("#btnUpdate, #btnSubmit").addClass("d-none");
        }
    });

    //Submit
    $(document).on('click', '#btnSubmit', function() {

        if (!validateField("#sr_qty_ok", "Qty Ok")) return;
        if (!validateField("#sr_qty_ng", "Qty NG")) return;
        if (!validateField("#sr_sorting", "Sorting Method")) return;
        if (!validateField("#sr_rework", "Rework Method")) return;
        if (!validateField("#sr_remarks", "Remarks")) return;
        if (!validatePhotos(new_before_files, existing_before_photos, "Before", "#before_photo_existing")) return;
        if (!validatePhotos(new_after_files, existing_after_photos, "After", "#after_photo_existing")) return;

        let fd = buildSortingFormData("submit_sorting");  // backend will UPDATE based on sr_id

        Swal.fire({
            title: "Submit",
            text: "Submit this sorting record for approval?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Submit",
            confirmButtonColor: "#198754"
        }).then(res => {
            if (!res.isConfirmed) return;

            $.ajax({
                url: "fetch-ip-sorting.php",
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

                    // ALWAYS close loading first
                    Swal.close();

                    if (data.status === "success") {

                        Swal.fire({
                            title: "Submitted!",
                            text: "Sorting record submitted successfully.",
                            icon: "success",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        }).then(() => {
                            // redirect to view page or reload list
                            window.location.href = 'ip-sorting.php';
                        });

                        // clear new files + inputs
                        new_before_files = [];
                        new_after_files = [];
                        $("#before_photo").val("");
                        $("#after_photo").val("");

                        // reload to reflect submitted status
                        loadSortingDetailsById($("#hidden_ir_id").val());

                        // optionally disable editing here if status is submitted
                        // $("#btnUpdate, #btnSubmit").prop("disabled", true);
                    }
                    else {
                        Swal.fire({
                            title: "Error",
                            text: data.message || "Submission failed.",
                            icon: "error",
                            iconColor: "#286912",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"
                        });
                    }
                }
            });
        });
    });

    // Cancel
    $(document).on('click', '#btnCancel', function (e) {

        e.preventDefault();
        const ir_id = $(this).attr('data-irid');
        const sr_id = $(this).attr('data-srid');

        $('#cancel_ir_id').val(ir_id);
        $('#cancel_sr_id').val(sr_id);
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
            text: 'Cancel this sorting record?',
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
                    url: 'fetch-ip-sorting.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { action: 'cancel_record', ir_id, sr_id, remark },
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
                                window.location.href = 'ip-sorting.php';
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
    
    
</body>
</html>