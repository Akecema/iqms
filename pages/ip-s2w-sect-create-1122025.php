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
        
        #btnUpdate, #btnSubmit {
            position: relative;
            z-index: 1000 !important;
        }

        .smart-area {
            min-height: 40px;
        }

        .smart-area:not(:placeholder-shown) {
            min-height: 120px;
        }
        
        .photo-box {
            position: relative;
            width: 95px;
            height: 95px;
            margin-right: 12px;
            margin-bottom: 22px; /* extra bottom space so icon won't overlap next row */
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid #e6e6e6;
            box-shadow: 0 2px 6px rgba(0,0,0,0.10);
            transition: 0.2s ease-in-out;

            /* IMPORTANT: Only hide IMAGE overflow, not delete icon */about:blank#blocked
            overflow: visible;
        }

        .photo-img {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            overflow: hidden;        /* keeps the image rounded */
            background-size: cover;
            background-position: center;
        }

        /* DELETE BUTTON OUTSIDE */
        .photo-box span {
            position: absolute;
            top: -10px;      /* move further outside */
            right: -10px;    /* move further outside */
            width: 22px;
            height: 22px;
            border-radius: 50%;
            background: #000;
            color: #fff;
            font-size: 15px;
            line-height: 20px;
            text-align: center;
            cursor: pointer;
            z-index: 10;      /* sits above everything */
            border: 2px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,0.25);
        }

        .photo-img {
            cursor: pointer !important;
        }

        #zoomModalImg {
            transition: transform 0.25s ease;
            transform: scale(0.9);
        }

        #zoomModal.show #zoomModalImg {
            transform: scale(1);
        }

        .viewAvatar {
            width: 40px !important;     /* change to any size */
            height: 40px !important;    /* same as width for perfect circle */
            object-fit: cover;
            cursor: pointer;
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

                <div class="row">
					<div class="col-xl-9 col-xxl-12">
						<div class="row">
							<div class="col-xl-12">
                                <div class="row">
                                    <div class="col-xl-3">
                                        <div class="card bg-timeline outline-dashed overflow-hidden">
                                            <div class="card-header">
                                                <h4 class="card-title mb-0"><?= $side_menu_timeline ?></h4>
                                            </div>
                                            <div class="card-body p-3 mt-2">
                                                <!-- Timeline -->
                                                <div class="recent-post">
                                                                                        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-9">
                                        <div class="card">
                                            <div class="card-header">
                                                <!-- <h4 class="heading mb-0">Create S2W Cronology</h4> -->
                                            </div>
                                            <div class="card-body">
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="add-sorting-tab" role="tabpanel" aria-labelledby="create-tab" tabindex="0">  
                                                        <div class="row">
                                                            <div class="card-body ai-tabs-1 py-2 mt-4"> 

                                                                <input type="hidden" id="hidden_ir_id" name="hidden_ir_id" class="form-control" value="<?= $eir_id ?>">
                                                                <input type="hidden" id="hidden_sr_id" name="hidden_sr_id" class="form-control" value="<?= $esr_id ?>">                                                                                            
                                                                <input type="hidden" id="hidden_s2w_id" name="hidden_s2w_id" class="form-control" value="<?= $es2w_id ?>">

                                                                <!-- cronology -->                                                
                                                                <div class="mb-4 mt-2">
                                                                    <label class="form-label">Cronology <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="fd_cronology" rows="3" placeholder="Problem History"></textarea>
                                                                </div>

                                                                <!-- root cause-->                                                
                                                                <div class="mb-4 mt-2">
                                                                    <label class="form-label">Root Cause <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="fd_rootcause" rows="3" placeholder="Why-why Analysis"></textarea>
                                                                </div>

                                                                <!-- root cause area -->                                                
                                                                <div class="mb-4 mt-2">
                                                                    <label class="form-label">Root Cause Area <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="fd_rootcause_area" rows="3" placeholder="Problem Area"></textarea>
                                                                </div>

                                                                <!-- root cause place-->                                                
                                                                <div class="mb-4 mt-2">
                                                                    <label class="form-label">Root Cause Place <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="fd_rootcause_place" rows="3" placeholder="Actual Place"></textarea>
                                                                </div>

                                                                <!-- correction/corrective-->                                                
                                                                <div class="mb-4 mt-2">
                                                                    <label class="form-label">Correction / Corrective <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="fd_correction" rows="3" placeholder="Temporary Counter Measure"></textarea>
                                                                </div>

                                                                <!-- Photos -->
                                                                <div class="col-md-5 mb-4">
                                                                    <h6>Correction / Corrective Photos <span class="text-danger">*</span></h6>
                                                                    <div id="correction_photo_box" class="d-flex flex-wrap mb-2 mt-4"></div>

                                                                    <input type="file" id="correction_photo" class="d-none" multiple>
                                                                    <label for="correction_photo" class="btn btn-primary btn-sm"><i class="fa fa-upload me-1"></i> Add Photo</label>
                                                                    <small class="text-muted d-block btnText">Use Ctrl to select multiple images</small>
                                                                </div>   
                                                                
                                                                <!-- preventive-->                                                
                                                                <div class="mb-4 mt-2">
                                                                    <label class="form-label">Preventive <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="fd_preventive" rows="3" placeholder="Permanent Counter Measure"></textarea>
                                                                </div>

                                                                <!-- Photos -->
                                                                <div class="col-md-5 mb-4">
                                                                    <h6>Preventive Photos <span class="text-danger">*</span></h6>
                                                                    <div id="preventive_photo_box" class="d-flex flex-wrap mb-2 mt-4"></div>
                                                                    <input type="file" id="preventive_photo" class="d-none" multiple>
                                                                    <label for="preventive_photo" class="btn btn-primary btn-sm"><i class="fa fa-upload me-1"></i> Add Photo</label>
                                                                </div>   

                                                                <!-- conclusion-->                                                
                                                                <div class="mb-4 mt-2">
                                                                    <label class="form-label">Conclusion <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" id="fd_conclusion" rows="3" placeholder="Result and Monitoring of Plan Activity"></textarea>
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
                </div>

                <!-- IMAGE ZOOM MODAL -->
                <div class="modal fade" id="zoomModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content"  style="background: transparent; border: none;">
                        <div class="modal-body p-0 text-center">
                            <img id="zoomModalImg" src="" class="img-fluid" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
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
        const s2w_id = $("#hidden_s2w_id").val();

        loadTimeline(ir_id, sr_id, s2w_id);
    });

    function loadTimeline(ir_id, sr_id, s2w_id) {
        $.ajax({
            url: "fetch-timeline-s2w-section.php",
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

    // === ZOOM IMAGE HANDLER ===
    $(document).on("click", ".photo-img", function () {

        // Get background image URL
        let imgUrl = $(this).css("background-image")
            .replace(/^url\(["']?/, '')
            .replace(/["']?\)$/, '');

        // Set modal image
        $("#zoomModalImg").attr("src", imgUrl);

        // Show modal
        $("#zoomModal").modal("show");
    });

    // Prevent zoom when clicking delete button
    $(document).on("click", ".photo-box span", function (e) {
        e.stopPropagation();
    });

    </script>

    <script>

    let existing_correction_photos = [];   // From DB
    let new_correction_files = [];         // User new uploads

    let existing_preventive_photos = [];   // From DB
    let new_preventive_files = [];         // User new uploads

    //RENDER FUNCTIONS
    function renderCorrectionPhotos() {
        const box = $("#correction_photo_box");
        box.empty();

        // Existing photos
        existing_correction_photos.forEach(p => {
            box.append(`
                <div class="photo-box" data-id="${p.id}" data-s2w="${p.s2w_id}">
                    <div class="photo-img" style="background-image:url('${p.url}'); cursor:pointer;"></div>
                    <span class="delete-existing-correction">&times;</span>
                </div>
            `);
        });

        // New photos
        new_correction_files.forEach((f, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                box.append(`
                    <div class="photo-box">
                        <div class="photo-img" style="background-image:url('${e.target.result}'); cursor:pointer;"></div>
                        <span class="delete-new-correction" data-idx="${i}">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(f);
        });
    }

    function renderPreventivePhotos() {
        const box = $("#preventive_photo_box");
        box.empty();

        // Existing
        existing_preventive_photos.forEach(p => {
            box.append(`
                <div class="photo-box" data-id="${p.id}" data-s2w="${p.s2w_id}">
                    <div class="photo-img" style="background-image:url('${p.url}')"></div>
                    <span class="delete-existing-preventive">&times;</span>
                </div>
            `);
        });

        // New
        new_preventive_files.forEach((f, i) => {
            const reader = new FileReader();
            reader.onload = e => {
                box.append(`
                    <div class="photo-box">
                        <div class="photo-img" style="background-image:url('${e.target.result}')"></div>
                        <span class="delete-new-preventive" data-idx="${i}">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(f);
        });
    }

    //CLEAN UPLOAD HANDLERS
    $("#correction_photo").on("change", function () {
        for (let file of this.files) new_correction_files.push(file);
        renderCorrectionPhotos();
        this.value = "";
    });

    $("#preventive_photo").on("change", function () {
        for (let file of this.files) new_preventive_files.push(file);
        renderPreventivePhotos();
        this.value = "";
    });

    // Delete NEW (not yet uploaded)
    $(document).on("click", ".delete-new-correction", function () {
        let index = $(this).data("idx");
        new_correction_files.splice(index, 1);
        renderCorrectionPhotos();
    });

    $(document).on("click", ".delete-new-preventive", function () {
        let index = $(this).data("idx");
        new_preventive_files.splice(index, 1);
        renderPreventivePhotos();
    });

    //Delete EXISTING (stored in DB)
    $(document).on("click", ".delete-existing-correction", function () {
        let id = $(this).parent().data("id");

        Swal.fire({
            title: "Delete Photo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete"
        }).then(r => {
            if (!r.isConfirmed) return;

            $.post("fetch-ip-s2w-section.php",
                { action: "delete_correction_photo", id },
                function (res) {

                    if (res.status === "success") {
                        existing_correction_photos =
                            existing_correction_photos.filter(p => p.id !== id);

                        renderCorrectionPhotos();
                    }

                }, "json");
        });
    });

    $(document).on("click", ".delete-existing-preventive", function () {
        let id = $(this).parent().data("id");

        Swal.fire({
            title: "Delete Photo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete"
        }).then(r => {
            if (!r.isConfirmed) return;

            $.post("fetch-ip-s2w-section.php",
                { action: "delete_preventive_photo", id },
                function (res) {

                    if (res.status === "success") {
                        existing_preventive_photos =
                        existing_preventive_photos.filter(p => p.id !== id);

                        renderPreventivePhotos();
                    }

                }, "json");
        });
    });

    //FORM VALIDATION
    function validateField(id, label) {
        let val = $(id).val().trim();

        if (!val) {
            $(id).addClass("border-error");

            Swal.fire("Missing Field", label + " is required.", "warning")
            .then(() => {
                scrollToField(id);   // <-- now scroll AFTER alert closes
                $(id).focus();       // optional: auto-focus field
            });

            return false;
        }

        $(id).removeClass("border-error");
        return true;
    }

    function validatePhotos(arrNew, arrExisting, label, scrollTarget) {
        if (arrNew.length === 0 && arrExisting.length === 0) {

            Swal.fire(label + " Photo Required", 
                    `Please add at least one ${label} photo.`, 
                    "warning")
            .then(() => {
                scrollToField(scrollTarget);  // scroll AFTER alert closes
            });

            return false;
        }
        return true;
    }

    function validatePhotos(arrNew, arrExisting, label) {
        if (arrNew.length === 0 && arrExisting.length === 0) {
            Swal.fire(label + " Photo Required", `Please add at least one ${label} photo.`, "warning");
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

    // SAVE (INSERT) 
    $("#btnSave").on("click", function () {

        if (!validateField("#fd_cronology", "Cronology")) return;
        if (!validateField("#fd_rootcause", "Root Cause")) return;
        if (!validateField("#fd_rootcause_area", "Root Cause Area")) return;
        if (!validateField("#fd_rootcause_place", "Root Cause Place")) return;
        if (!validateField("#fd_correction", "Correction / Corrective")) return;
        if (!validatePhotos(new_correction_files, existing_correction_photos, "Correction", "#correction_photo_box")) return;
        if (!validateField("#fd_preventive", "Preventive")) return;
        if (!validatePhotos(new_preventive_files, existing_preventive_photos, "Preventive", "#preventive_photo_box")) return;
        if (!validateField("#fd_conclusion", "Conclusion")) return;

        // Confirm Before Save
        Swal.fire({
            title: "Save S2W Report?",
            text: "Are you sure you want to save this S2W Report?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754",
            cancelButtonColor: "#6c757d",
        }).then((result) => {
            if (!result.isConfirmed) return;

            let fd = new FormData();
            fd.append("action", "add_s2w_report");
            fd.append("ir_id", $("#hidden_ir_id").val());
            fd.append("sr_id", $("#hidden_sr_id").val());
            fd.append("s2w_id", $("#hidden_s2w_id").val());

            // fields
            fd.append("fd_cronology", $("#fd_cronology").val());
            fd.append("fd_rootcause", $("#fd_rootcause").val());
            fd.append("fd_rootcause_area", $("#fd_rootcause_area").val());
            fd.append("fd_rootcause_place", $("#fd_rootcause_place").val());
            fd.append("fd_correction", $("#fd_correction").val());
            fd.append("fd_preventive", $("#fd_preventive").val());
            fd.append("fd_conclusion", $("#fd_conclusion").val());

            // Photos
            new_correction_files.forEach(f => fd.append("correction_photo[]", f));
            new_preventive_files.forEach(f => fd.append("preventive_photo[]", f));

            $.ajax({
                url: "fetch-ip-s2w-section.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",
                success: function (res) {

                    if (res.status !== "success") {
                        Swal.fire("Error", res.message || "Failed to save.", "error");
                        return;
                    }

                    const s2w_report_id    = res.insert_id;          // from PHP
                    const s2w_report_status = res.s2w_report_status; // draft id
                    const s2w_id           = $("#hidden_s2w_id").val();

                    // create / update hidden inputs
                    if (!$("#hidden_s2w_report_id").length) {
                        $("<input>", {
                            type: "hidden",
                            id: "hidden_s2w_report_id",
                            value: s2w_report_id
                        }).appendTo(".card-body");
                    } else {
                        $("#hidden_s2w_report_id").val(s2w_report_id);
                    }

                    if (!$("#hidden_s2w_report_status").length) {
                        $("<input>", {
                            type: "hidden",
                            id: "hidden_s2w_report_status",
                            value: s2w_report_status
                        }).appendTo(".card-body");
                    } else {
                        $("#hidden_s2w_report_status").val(s2w_report_status);
                    }

                    // store in localStorage for future reload
                    localStorage.setItem("rp_s2w_report_id", s2w_report_id);
                    localStorage.setItem("rp_s2w_report_status", s2w_report_status);

                    // switch buttons
                    $("#btnSave").addClass("d-none");
                    $("#btnUpdate").removeClass("d-none");
                    $("#btnSubmit").removeClass("d-none");

                    // reset "new" arrays because now everything is in DB
                    new_correction_files = [];
                    new_preventive_files = [];

                    Swal.fire({
                        icon: "success",
                        title: "Saved!",
                        text: "S2W report saved successfully."
                    });

                    // Reload from DB so images now come from DB paths
                    loadS2W(s2w_report_id);
                }
            });
        });
    });

    //RELOAD
    // Load Existing Record 
    // $(document).ready(function () {

    //     let report_id = $("#hidden_s2w_report_id").val();

    //     // fallback to localStorage (optional)
    //     if (!report_id || report_id === "0") {
    //         let saved = localStorage.getItem("rp_s2w_report_id");
    //         if (saved && saved !== "0") report_id = saved;
    //     }

    //     if (report_id && report_id !== "0") {
    //         console.log("Auto-load S2W:", report_id);
    //         loadS2W(report_id);
    //     }
    // });

    // Load S2W Report by REPORT ID (rp_id)
    function loadS2W(s2w_report_id) {

        if (!s2w_report_id || s2w_report_id === "0") {
            console.log("loadS2W aborted - invalid id:", s2w_report_id);
            return;
        }
        else
        {
            console.log("loadS2W report id:", s2w_report_id);
        }

        $.ajax({
            url: "fetch-ip-s2w-section.php",
            type: "POST",
            data: { action: "get_s2w_details", s2w_report_id: s2w_report_id },
            dataType: "json",
            success: function (res) {

                if (res.status !== "success") {
                    console.log("get_s2w_details returned status:", res.status);
                    return;
                }

                const d = res.data;

                console.log("Loaded S2W Report id:", d);

                /* ---------------------------
                * 1. Fill text fields
                * ---------------------------*/
                $("#fd_cronology").val(d.rp_s2w_cronology || "");
                $("#fd_rootcause").val(d.rp_s2w_rootcause || "");
                $("#fd_rootcause_area").val(d.rp_s2w_rootcause_area || "");
                $("#fd_rootcause_place").val(d.rp_s2w_rootcause_place || "");
                $("#fd_correction").val(d.rp_s2w_correction || "");
                $("#fd_preventive").val(d.rp_s2w_preventive || "");
                $("#fd_conclusion").val(d.rp_s2w_conclusion || "");

                /* ---------------------------
                * 2. Prepare photo arrays
                * ---------------------------*/
                existing_correction_photos = [];
                existing_preventive_photos = [];

                // Correction photos
                if (d.photo_correction && d.photo_correction.length > 0) {
                    d.photo_correction.forEach(p => {
                        existing_correction_photos.push({
                            id: p.correction_photoid,
                            report_id: d.rp_s2w_report_id,
                            url: `gallery/s2w_report/correction_photo/${d.rp_s2w_report_id}/${p.file}`
                        });
                    });
                }

                // Preventive photos
                if (d.photo_preventive && d.photo_preventive.length > 0) {
                    d.photo_preventive.forEach(p => {
                        existing_preventive_photos.push({
                            id: p.preventive_photoid,
                            report_id: d.rp_s2w_report_id,
                            url: `gallery/s2w_report/preventive_photo/${d.rp_s2w_report_id}/${p.file}`
                        });
                    });
                }

                // Render
                renderCorrectionPhotos();
                renderPreventivePhotos();

                /* ---------------------------
                * 3. Hidden fields + localStorage
                * ---------------------------*/
                $("#hidden_s2w_report_id").val(d.rp_s2w_report_id);
                $("#hidden_s2w_report_status").val(d.rp_s2w_report_status);
                $("#hidden_s2w_id").val(d.rp_s2w_id); 

                localStorage.setItem("rp_s2w_report_id", d.rp_s2w_report_id);
                localStorage.setItem("rp_s2w_report_status", d.rp_s2w_report_status);

                // status logic for buttons, disable fields, etc.
                const status = parseInt(d.rp_s2w_report_status);

                // Reset buttons first
                $("#btnSave, #btnUpdate, #btnSubmit").addClass("d-none");
                $("textarea, input").prop("disabled", false);
                $("#correction_photo, #preventive_photo").prop("disabled", false);
                $(".delete-existing-correction, .delete-existing-preventive").show();

                /* === STATUS 13 → Show Update + Submit === */
                if (status === 13) {

                    $("#btnUpdate").removeClass("d-none");
                    $("#btnSubmit").removeClass("d-none");
                }

                /* === STATUS 4 & 10 → DISABLE ALL === */
                else if (status === 4 || status === 10) {

                    // Hide all buttons
                    $("#btnSave, #btnUpdate, #btnSubmit").addClass("d-none");

                    // Disable textboxes
                    $("textarea, input").prop("disabled", true);

                    // Disable photo uploads
                    $("#correction_photo, #preventive_photo").prop("disabled", true);

                    // Remove delete icons
                    $(".delete-existing-correction, .delete-existing-preventive").remove();

                    // Allow zoom
                    $(".photo-img").css("pointer-events", "auto");
                }

                if (typeof initTooltips === "function") {
                    initTooltips();
                }
            }
        });
    }

    //UPDATE
    $("#btnUpdate").on("click", function () {

        const report_id = $("#hidden_s2w_report_id").val();
        const ir_id = $("#hidden_ir_id").val();
        const sr_id = $("#hidden_sr_id").val();
        const s2w_id = $("#hidden_s2w_id").val();

        if (!report_id) {
            Swal.fire("Error", "No report ID found.", "error");
            return;
        }

        // VALIDATION
        if (!validateField("#fd_cronology", "Cronology")) return;
        if (!validateField("#fd_rootcause", "Root Cause")) return;
        if (!validateField("#fd_rootcause_area", "Root Cause Area")) return;
        if (!validateField("#fd_rootcause_place", "Root Cause Place")) return;
        if (!validateField("#fd_correction", "Correction")) return;
        if (!validatePhotos(new_correction_files, existing_correction_photos, "Correction", "#correction_photo_box")) return;
        if (!validateField("#fd_preventive", "Preventive")) return;
        if (!validatePhotos(new_preventive_files, existing_preventive_photos, "Preventive", "#preventive_photo_box")) return;
        if (!validateField("#fd_conclusion", "Conclusion")) return;

        let fd = new FormData();
        fd.append("action", "update_s2w");
        fd.append("s2w_report_id", report_id);

        // IMPORTANT - SEND IDs to PHP
        fd.append("ir_id", ir_id);
        fd.append("sr_id", sr_id);
        fd.append("s2w_id", s2w_id);

        // Fields
        fd.append("fd_cronology", $("#fd_cronology").val());
        fd.append("fd_rootcause", $("#fd_rootcause").val());
        fd.append("fd_rootcause_area", $("#fd_rootcause_area").val());
        fd.append("fd_rootcause_place", $("#fd_rootcause_place").val());
        fd.append("fd_correction", $("#fd_correction").val());
        fd.append("fd_preventive", $("#fd_preventive").val());
        fd.append("fd_conclusion", $("#fd_conclusion").val());

        // Photos
        new_correction_files.forEach(f => fd.append("correction_photo[]", f));
        new_preventive_files.forEach(f => fd.append("preventive_photo[]", f));

        $.ajax({
            url: "fetch-ip-s2w-section.php",
            type: "POST",
            data: fd,
            contentType: false,
            processData: false,
            dataType: "json",
            success: function (res) {

                Swal.fire({
                    icon: "success",
                    title: "Updated!",
                    text: "S2W report updated successfully."
                });

                new_correction_files = [];
                new_preventive_files = [];

                loadS2W(report_id);
            }
        });
    });

    //SUBMIT
    $("#btnSubmit").on("click", function () {

        const report_id = $("#hidden_s2w_report_id").val();

        if (!report_id) {
            Swal.fire("Error", "No report ID found.", "error");
            return;
        }

        if (!validateField("#fd_cronology", "Cronology")) return;
        if (!validateField("#fd_rootcause", "Root Cause")) return;
        if (!validateField("#fd_rootcause_area", "Root Cause Area")) return;
        if (!validateField("#fd_rootcause_place", "Root Cause Place")) return;
        if (!validateField("#fd_correction", "Correction")) return;
        if (!validatePhotos(new_correction_files, existing_correction_photos, "Correction", "#correction_photo_box")) return;
        if (!validateField("#fd_preventive", "Preventive")) return;
        if (!validatePhotos(new_preventive_files, existing_preventive_photos, "Preventive", "#preventive_photo_box")) return;
        if (!validateField("#fd_conclusion", "Conclusion")) return;

        Swal.fire({
            title: "Submit for Review?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Submit"
        }).then(r => {

            if (!r.isConfirmed) return;

            let fd = new FormData();
            fd.append("action", "submit_for_review");
            fd.append("s2w_report_id", report_id);

            $.ajax({
                url: "fetch-ip-s2w-section.php",
                type: "POST",
                data: fd,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function () {

                    Swal.fire("Submitted!", "", "success");

                    new_correction_files = [];
                    new_preventive_files = [];

                    loadS2W(report_id);
                }
            });
        });
    });

    </script>

    <script>

    // Right box Inspection details
    // function loadRightDetail(ir_id) {
    //     $.ajax({
    //         url: "get-inspection-details.php",
    //         method: "POST",
    //         dataType: 'html',
    //         data: { ir_id: ir_id },
    //         beforeSend: function() {
    //             $("#inspectionRightDetail").html("<div class='text-center p-3'>Loading...</div>");
    //         },
    //         success: function(html) {
    //             $("#inspectionRightDetail").html(html);

    //         }
    //     });
    // }

    // $(document).on("click", ".viewRightDetail", function () {
    //     let ir_id = $(this).data("irid");
    //     loadRightDetail(ir_id);
    // });

    // $(document).ready(function () {
    //     let ir_id = $(".viewRightDetail.active, .viewRightDetail.show").data("irid");

    //     if (ir_id) {
    //         loadRightDetail(ir_id);
    //     }
    // });

    // Right box Sorting details
    // function loadRightDetailSr(sr_id) {
    //     $.ajax({
    //         url: "get-sorting-details.php",
    //         method: "POST",
    //         dataType: 'html',
    //         data: { sr_id: sr_id },
    //         beforeSend: function() {
    //             $("#sortingRightDetail").html("<div class='text-center p-3'>Loading...</div>");
    //         },
    //         success: function(html) {
    //             $("#sortingRightDetail").html(html);
    //         }
    //     });
    // }

    // $(document).on("click", ".viewRightDetailSr", function () {
    //     let sr_id = $(this).data("srid");
    //     loadRightDetailSr(sr_id);
    // });

    // Right box S2W
    // function loadRightDetailS2W(s2w_id) {
    //     $.ajax({
    //         url: "get-s2w-details.php",
    //         method: "POST",
    //         dataType: 'html',
    //         data: { s2w_id: s2w_id },
    //         beforeSend: function() {
    //             $("#S2WRightDetail").html("<div class='text-center p-3'>Loading...</div>");
    //         },
    //         success: function(html) {
    //             $("#S2WRightDetail").html(html);

    //             // Wait until hidden fields are created
    //             setTimeout(function(){
    //                 let report_id = $("#hidden_s2w_report_id").val();

    //                 console.log("After S2W HTML loaded, report ID =", report_id);

    //                 if (report_id && report_id !== "0") {
    //                     loadS2W(report_id);
    //                 }
    //             }, 50);
    //         }
    //     });
    // }

    // $(document).on("click", ".viewRightDetailS2W", function () {
    //     let s2w_id = $(this).data("s2wid");
    //     loadRightDetailS2W(s2w_id);
    // });

    </script>
    
</body>
</html>