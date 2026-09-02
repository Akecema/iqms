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
    
        .remove-image-btn {
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
        .remove-image-btn:hover {
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
        $stmt = $db_con->prepare("SELECT S.sr_docno, S.sr_qty_ok, S.sr_qty_ng
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
                                    <li class="nav-item"><a href="#part-involve-tab" onclick="window.location.href='ip-sorting-part-involve-view.php?srid=<?=$sridEnc?>&&irid=<?=$eir_id?>&&pg=<?=$epg?>'" class="nav-link"><i class="fa fa-list" aria-hidden="true"></i> <span class="p-1">Part Involve</span></a></li>
                                </ul>
                            </div>

                            <div class="tab-content" id="myTabContent">
                                <!-- Sorting Qty & method -->
                                <div class="tab-pane fade show active" id="add-sorting-tab" role="tabpanel" aria-labelledby="create-tab" tabindex="0">    
                                    <div class="card-body">

                                        <input type="hidden" id="hidden_sr_id" name="hidden_sr_id" class="form-control" value="<?=$esr_id;?>">
                                        <input type="hidden" id="hidden_ir_id" name="hidden_ir_id" class="form-control" value="<?=$eir_id;?>">

                                        <div class="d-md-flex d-none flex-wrap mb-3">
                                            <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
                                                <div class="avatar avatar-md style-1 bg-oren-light text-white rounded d-flex align-items-center justify-content-center">                                                       
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                                                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
                                                    </svg>
                                                </div>
                                                <div class="clearfix ms-2">
                                                    <h3 class="mb-0 fw-semibold lh-1 fs-16"></h3>
                                                    <span class="fw-semibold fs-14 mb-4">Qty OK</span> <br/>
                                                    <span id="sr_qty_ok" class="fw-semibold fs-18 text-hijau mt-4"><?= $sortingdet['sr_qty_ok'] ?></span>
                                                </div>
                                            </div>
                                            <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
                                                <div class="avatar avatar-md style-1 bg-oren-light text-white rounded d-flex align-items-center justify-content-center">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                                    </svg>
                                                </div>
                                                <div class="clearfix ms-2">
                                                    <h3 class="mb-0 fw-semibold lh-1 fs-16"></h3>
                                                    <span class="fw-semibold fs-14">Qty NG</span><br/>
                                                    <span id="sr_qty_ng" class="fw-semibold fs-18 text-danger"><?= $sortingdet['sr_qty_ng'] ?></span>
                                                </div>
                                            </div>
                                            <div class="clearfix mt-0 mt-xl-0 ms-auto d-flex flex-column col-xl-3">
                                                <div class="clearfix mb-3 text-xl-end">
                                                    <span class="badge badge-pill badge-dark-2"></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row g-4 mt-2">

                                            <!-- ========================================== -->
                                            <!-- LEFT COLUMN -->
                                            <!-- ========================================== -->
                                            <div class="col-md-12">

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-sync-alt"></i> Sorting Method 
                                                    </h6>
                                                    <textarea class="form-control" id="sr_sorting" rows="3"></textarea>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-tools"></i> Rework Method
                                                    </h6>
                                                    <textarea class="form-control" id="sr_rework" rows="3"></textarea>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-comment-alt"></i> Remarks
                                                    </h6>
                                                    <textarea class="form-control" id="sr_remarks" rows="3"></textarea>
                                                </div>

                                            </div>

                                            <!-- ========================================== -->
                                            <!-- RIGHT COLUMN -->
                                            <!-- ========================================== -->
                                            <div class="col-md-12">

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-image"></i> Photos Before (NG)
                                                    </h6>
                                                    <div id="before_photo_existing" class="d-flex flex-wrap mb-2"></div>
                                                    <div id="before_photo_new" class="d-flex flex-wrap mb-2"></div>
                                                </div>

                                                <div class="s2w-section">
                                                    <h6 class="section-title">
                                                        <i class="fa fa-image"></i> Photos After Sorting (OK)
                                                    </h6>

                                                    <div id="after_photo_existing" class="d-flex flex-wrap mb-2"></div>
                                                    <div id="after_photo_new" class="d-flex flex-wrap mb-2"></div>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="col-md-12">
                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-commenting"></i> Comment/Reason
                                                </h6>
                                                <textarea class="form-control" id="sr_remarks" rows="3"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                    </div> 

                    <div class="col-xxl-3 col-xl-4">
                        <div class="row sticky-top sticky-top-80 z-0">
                            <!-- Timeline -->
                            <div class="recent-post"> </div>
                        </div>
                    </div>
                </div>

                <!-- Modal for image zoom -->
                <div class="modal fade" id="imgZoomModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background: transparent; border: none;">
                            <img src="" id="zoomedImg" class="img-fluid rounded shadow" style="max-width: 90vw; max-height: 90vh;">
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
        if ( epage === 'p') {
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
    <script>

    //--## sorting  
    
    let beforeFiles = [];
    let afterFiles = [];

    // --- PREVIEW HELPER ---
    // --- Preview NEW uploads only ---
    function updatePreview(filesArray, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = ''; // clear only the new upload preview section
        filesArray.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = "position-relative me-2 mb-2";
                div.style.cssText = `
                    width:80px;height:80px;
                    background-image:url('${e.target.result}');
                    background-size:cover;background-position:center;
                    border-radius:8px;border:1px solid #ddd;cursor:pointer;
                `;
                div.setAttribute('data-idx', idx);

                // Remove button (remove only from local array)
                const removeBtn = document.createElement('span');
                removeBtn.className = 'remove-image-btn';
                removeBtn.innerHTML = '&times;';
                removeBtn.onclick = function(ev) {
                    ev.stopPropagation();
                    filesArray.splice(idx, 1);
                    updatePreview(filesArray, previewId);
                };
                div.appendChild(removeBtn);
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }

    // --- When selecting new Before images ---
    $('#before_photo').on('change', function() {
        for (let file of this.files) beforeFiles.push(file);
        updatePreview(beforeFiles, 'before_photo_new');
        this.value = '';
    });

    // --- When selecting new After images ---
    $('#after_photo').on('change', function() {
        for (let file of this.files) afterFiles.push(file);
        updatePreview(afterFiles, 'after_photo_new');
        this.value = '';
    });

    // --- Add new images ---
    $('#before_photo').on('change', function() {
        for (let file of this.files) beforeFiles.push(file);
        updatePreview(beforeFiles, 'before_photo_preview');
        this.value = '';
    });

    $('#after_photo').on('change', function() {
        for (let file of this.files) afterFiles.push(file);
        updatePreview(afterFiles, 'after_photo_preview');
        this.value = '';
    });

    //View Image
    let currentIndex = -1;
    let imageList = [];

    // When any image (old or new) is clicked
    $(document).on('click', '.position-relative', function (e) {
        if ($(e.target).hasClass('remove-image-btn')) return;

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

    // Handle keyboard navigation while modal is open
    $(document).on('keydown', function (e) {
        if (!$('#imgZoomModal').hasClass('show')) return;

        if (e.key === 'ArrowRight') {
            currentIndex = (currentIndex + 1) % imageList.length;
            $("#zoomedImg").attr("src", imageList[currentIndex]);
        } else if (e.key === 'ArrowLeft') {
            currentIndex = (currentIndex - 1 + imageList.length) % imageList.length;
            $("#zoomedImg").attr("src", imageList[currentIndex]);
        } else if (e.key === 'Escape') {
            $("#imgZoomModal").modal("hide");
        }
    });

    // --- Load Existing Record ---
    $(document).ready(function() {

        const sr_id = $("#hidden_sr_id").val();
        const ir_id = $("#hidden_ir_id").val();
        if (!sr_id) return;

        $.ajax({
            url: "fetch-ip-sorting-rcd-all.php",
            type: "POST",
            data: { action: "get_sorting_details", sr_id, ir_id },
            dataType: "json",
            success: function(res) {

                console.log("AJAX Response:", res);
                if (res.status !== "success") return;

                const d = res.data;

                console.log("Sorting Status:", d.sorting_status);
                console.log("sr_id:", d.sr_id);
                console.log("ir_id:", d.ir_id);
                
                $("#sr_qty_ok").val(d.qty_ok);
                $("#sr_qty_ng").val(d.qty_ng);
                $("#sr_sorting").val(d.sorting_method);
                $("#sr_rework").val(d.rework_method);
                $("#sr_remarks").val(d.remarks);

                // show/hide Doc No label
                if (d.sorting_status !== 1 && d.sorting_status !== 13) {
                    $(".divDocno .viewDocno").html(d.sr_docno);
                    $(".divDocno .viewStatus").html(d.sr_statusname);
                    $(".divDocno").removeClass("d-none");
                } else {
                    $(".divDocno").addClass("d-none");
                }
              
                // Render Before photos
                let beforeHtml = "";
                d.photos_before.forEach(p => {
                    beforeHtml += `
                        <div class="position-relative me-2 mb-2" 
                            style="width:80px;height:80px;background-image:url('gallery/inspection_sorting/before/${p.file}');
                            background-size:cover;background-position:center;border-radius:8px;border:1px solid #ddd;cursor:pointer;" 
                            data-id="${p.id}" data-filename="${p.file}" data-folder="before">                           
                        </div>`;
                });
                $("#before_photo_existing").html(beforeHtml || "<em> </em>");

                // Render After photos
                let afterHtml = "";
                d.photos_after.forEach(p => {
                    afterHtml += `
                        <div class="position-relative me-2 mb-2" 
                            style="width:80px;height:80px;background-image:url('gallery/inspection_sorting/after/${p.file}');
                            background-size:cover;background-position:center;border-radius:8px;border:1px solid #ddd;cursor:pointer;" 
                            data-id="${p.id}" data-filename="${p.file}" data-folder="after">
                        </div>`;
                });
                $("#after_photo_existing").html(afterHtml || "<em> </em>");

                
               $("#add-sorting-tab .card-body")
                        .addClass("readonly-mode")
                        .find("input, textarea, select")
                        .prop("disabled", true);

                // Reinitialize tooltips for dynamically added elements
                initTooltips();

            }
        });
    });

    </script>

    
    
</body>
</html>