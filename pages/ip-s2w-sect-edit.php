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
    <link href="css/badge.css" rel="stylesheet">
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

         .remove-old-preventive {
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
        .remove-old-preventive:hover {
            background: #B31236;
            color: #fff;
            border-color: #FAF7F9;
        }
        .remove-new-preventive {
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
        .remove-new-preventive:hover {
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
            cursor: zoom-in;
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

        .avatar-lg
        {
            width: 40px !important;
            height: 40px !important;
        }
        
        .viewAvatar:hover {
            transform: scale(1.52); /* optional: subtle zoom effect on hover */
            cursor : zoom-in;
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

        </style>

		<?php

        $encrpidEnc = $_GET['encrpid'] ?? '';
        $eir_id = $_GET['irid'] ?? '';
        $epg = $_GET['pg'] ?? "";

        //decrypt
        $erp_id = decryptData($encrpidEnc);

        $sql = "SELECT rp_s2w_sr_id, rp_s2w_id FROM inspection_s2w_report WHERE rp_id = ?";
        $stmt = $db_con->prepare($sql);
        $stmt->bind_param("i", $erp_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $esr_id = $row['rp_s2w_sr_id'];
        $es2w_id = $row['rp_s2w_id'];

        // $sidemenu = ($epg == 'c') ? $side_menu14 : $side_menu15;

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
									<div class="col-xl-9">
										<div class="card overflow-hidden">
											<div class="card-header">
                                                <h4 class="heading mb-0">Create S2W</h4>
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
                                                <!-- <ul class="nav nav-pills mt-3 mt-sm-0" id="myTab2" role="tablist">
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
                                                    <li class="nav-item ms-1" role="presentation">
                                                        <button class="btn btn-sm btn-darklime-2 me-2 viewRightDetailS2W" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight-S2W" aria-controls="offcanvasRight" 
                                                        data-bs-title="View S2W details" data-bs-placement="top" data-bs-custom-class="tooltip-dark" data-s2wid="<?= $es2w_id ?>">
                                                        S2W <i class="fa fa-angle-double-right fa-xs" aria-hidden="true"></i></button>
                                                    </li>
                                                </ul> -->
                                            </div>
											<div class="card-body custome-tooltip p-3">
												<div class="profile-blog">									
											
                                                    <input type="hidden" id="hidden_ir_id" value="<?= $eir_id ?>">
                                                    <input type="hidden" id="hidden_sr_id" value="<?= $esr_id ?>">
                                                    <input type="hidden" id="hidden_s2w_id" value="<?= $es2w_id ?>">
                                                    <input type="hidden" id="hidden_rp_id" value="<?= $erp_id ?? 0 ?>">
                                                    <input type="hidden" id="hidden_rp_status" value="1">

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

                                                    <div class="text-end mt-4 mb-4">
                                                        <button type="button" id="btnSave" class="btn btn-black">Save</button>
                                                        <button type="button" id="btnUpdate" class="btn btn-black d-none"><i class="fa fa-check me-2"></i>Save Changes</button>
                                                        <button type="button" id="btnSubmit" class="btn btn-black d-none"><i class="fa-solid fa-paper-plane me-2"></i>Submit</button>
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

    const epage = "<?= $epg ?>"; 
        
        // Compare and redirect
        if ( epage === 'c') {
            window.location.href = "ip-s2w-sect-list-all.php";
        } else {
            window.location.href = "ip-s2w-sect-list-all-pre.php";
        }
    });
    
    </script>

    <script>
    function initTooltips() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="offcanvas"]')); 
        
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
        const list = [].slice.call(document.querySelectorAll('[data-bs-toggle="offcanvas"]'));
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
        const ir_id = $("#hidden_ir_id").val();  
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
                $('[data-bs-toggle="offcanvas"]').tooltip();
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

    //--## S2W
    let existing_correction_photos = [];   // Photos already stored in DB
    let new_correction_files = [];         // Newly selected files not saved yet

    let existing_preventive_photos = [];
    let new_preventive_files = [];
    
    // Preview Renderer
    function renderCorrectionPhotos() {
        const box = $("#correction_photo_existing");
        box.empty();

        // --- EXISTING PHOTOS (from DB) ---
        existing_correction_photos.forEach(img => {
            box.append(`
                <div class="position-relative me-2 mb-2 zoom-item"
                    style="width:80px;height:80px;border-radius:8px;
                    background-image:url('${img.url}');
                    background-size:cover;background-position:center;
                    border:1px solid #ddd;cursor:zoom-in"
                    data-id="${img.id}" data-rpid="${img.rp_id}">

                    <span class="remove-old no-zoom"
                        style="position:absolute;top:-10px;right:-10px;
                        cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                </div>
            `);
        });

        // --- NEW PHOTOS (selected from PC) ---
        new_correction_files.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = e => {
                box.append(`
                    <div class="position-relative me-2 mb-2 zoom-item"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${e.target.result}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;cursor:zoom-in">

                        <span class="remove-new no-zoom" data-idx="${idx}"
                            style="position:absolute;top:-10px;right:-10px;
                            cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    }

    function renderPreventivePhotos() {
        const box = $("#preventive_photo_existing");
        box.empty();

        // Existing OK photos
        existing_preventive_photos.forEach(img => {
            box.append(`
                <div class="position-relative me-2 mb-2 zoom-item-ok"
                    style="width:80px;height:80px;border-radius:8px;
                    background-image:url('${img.url}');
                    background-size:cover;background-position:center;
                    border:1px solid #ddd;cursor:zoom-in"
                    data-id="${img.id}" data-rpid="${img.rp_id}">

                    <span class="remove-old-preventive no-zoom"
                        style="position:absolute;top:-10px;right:-10px;
                        cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                </div>
            `);
        });

        // New OK photos (from PC)
        new_preventive_files.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = e => {
                box.append(`
                    <div class="position-relative me-2 mb-2 zoom-item-ok"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${e.target.result}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;cursor:zoom-in">

                        <span class="remove-new-preventive no-zoom" data-idx="${idx}"
                            style="position:absolute;top:-10px;right:-10px;
                            cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    }

    // Load Photos from get_s2w_details
    function loadS2W(rp_id) {

        $.post("fetch-ip-s2w-section-rcd-all.php", { action: "get_s2w_details", rp_id }, res => {
            
            if (res.status !== "success") return;

            const d = res.data;

            existing_correction_photos = [];
            new_correction_files = [];

            if (d.photo_correction) {
                d.photo_correction.forEach(p => {
                    existing_correction_photos.push({
                        id: p.correction_photoid,
                        rp_id: d.rp_id,
                        url: `gallery/inspection_s2w_report/photo_correction/${d.rp_id}/${p.file}`
                    });
                });
            }

            renderCorrectionPhotos();

            existing_preventive_photos = [];
            new_preventive_files = [];

            if (d.photo_preventive) {
                d.photo_preventive.forEach(p => {
                    existing_preventive_photos.push({
                        id: p.preventive_photoid,
                        rp_id: d.rp_id,
                        url: `gallery/inspection_s2w_report/photo_preventive/${d.rp_id}/${p.file}`
                    });
                });
            }

            renderPreventivePhotos();


        }, "json");
    }

    // Add New Photo
    $("#correction_photo_s2w").on("change", function () {

        for (let f of this.files) {
            new_correction_files.push(f);
        }

        renderCorrectionPhotos();
        this.value = ""; // Reset file selector
    });

    $("#preventive_photo_s2w").on("change", function () {
        for (let f of this.files) {
            new_preventive_files.push(f);
        }
        renderPreventivePhotos();
        this.value = "";
    });

    //Remove New Photo (not uploaded yet)
    $(document).on("click", ".remove-new", function (e) {

        e.stopPropagation();   // HARD stop
        e.preventDefault();   

        new_correction_files.splice($(this).data("idx"), 1);
        renderCorrectionPhotos();
    });

    //Remove Existing Photo (stored in DB)
    $(document).on("click", ".remove-old", function (e) {

        e.stopPropagation();   // HARD stop
        e.preventDefault(); 

        const id = $(this).parent().data("id");
        const rp_id = $(this).parent().data("rpid");

        Swal.fire({
            text: "Delete this photo?",
            icon: "warning",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#198754"
        }).then(r => {
            if (!r.isConfirmed) return;

            $.post("fetch-ip-s2w-section-rcd-all.php",
                { action: "delete_correction_photo", id, rp_id },
                resp => {
                    if (resp.status === "success") {
                        existing_correction_photos =
                        existing_correction_photos.filter(x => x.id !== id);
                        renderCorrectionPhotos();
                    }
                },
                "json"
            );
        });
    });

    $(document).on("click", ".remove-new-preventive", function (e) {
        e.stopPropagation();
        e.preventDefault();
        new_preventive_files.splice($(this).data("idx"), 1);
        renderPreventivePhotos();
    });

    $(document).on("click", ".remove-old-preventive", function (e) {

        e.stopPropagation();
        e.preventDefault();

        const id = $(this).parent().data("id");
        const rp_id = $(this).parent().data("rpid");

        Swal.fire({
            text: "Delete this photo?",
            icon: "warning",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#198754"
        }).then(r => {
            if (!r.isConfirmed) return;

            $.post("fetch-ip-s2w-section-rcd-all.php",
                { action: "delete_preventive_photo", id, rp_id },
                resp => {
                    if (resp.status === "success") {
                        existing_preventive_photos =
                        existing_preventive_photos.filter(x => x.id !== id);
                        renderPreventivePhotos();
                    }
                },
                "json"
            );
        });
    });

    // Save / Update — Send New Files Only

    //For add
    new_correction_files.forEach(f =>
        fd.append("correction_photo_s2w[]", f)
    );

    //For update
    new_correction_files.forEach(f =>
        fd.append("correction_photo_s2w[]", f)
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
        existing_correction_photos.forEach(p => zoomImages.push(p.url));

        // New (preview) images
        new_correction_files.forEach((f, i) => {
            zoomImages.push(
                $("#correction_photo_existing .zoom-item").eq(i + existing_correction_photos.length).data("url")
            );
        });

        // Find index of clicked image
        zoomIndex = zoomImages.indexOf(clickedUrl);

        // Set modal image
        $("#zoomedImg").attr("src", clickedUrl);

        // Show modal
        $("#imgZoomModal").modal("show");
    });

    //For add
    new_preventive_files.forEach(f =>
        fd.append("preventive_photo_s2w[]", f)
    );

    //For update
    new_preventive_files.forEach(f =>
        fd.append("preventive_photo_s2w[]", f)
    );

    $(document).on("click", ".zoom-item-ok", function (e) {

        if ($(e.target).hasClass("no-zoom") ||
            $(e.target).hasClass("remove-old-preventive") ||
            $(e.target).hasClass("remove-new-preventive")) return;

        const clickedUrl = $(this).css("background-image")
            .replace(/^url\(["']?/, '').replace(/["']?\)$/, '');

        zoomImages = [];

        // Existing
        existing_preventive_photos.forEach(p => zoomImages.push(p.url));

        // New
        $("#preventive_photo_existing .zoom-item-ok").each(function () {
            const bg = $(this).css("background-image")
                .replace(/^url\(["']?/, '').replace(/["']?\)$/, '');
            zoomImages.push(bg);
        });

        zoomIndex = zoomImages.indexOf(clickedUrl);
        $("#zoomedImg").attr("src", clickedUrl);
        $("#imgZoomModal").modal("show");
    });

    // LOAD EXISTING RECORD
    $(document).ready(function () {
        const sessionId = "<?= $session_id ?>";
        const rp_id = $("#hidden_rp_id").val();
        if (!rp_id) return;

        $.ajax({
            url: "fetch-ip-s2w-section-rcd-all.php",
            type: "POST",
            data: { action: "get_s2w_details", rp_id },
            dataType: "json",

            success: function (res) {

                if (res.status !== "success") return;

                const d = res.data;

                // Store S2W ID & STATUS into hidden inputs (always)
                $("#hidden_rp_id").val(d.rp_id);
                $("#hidden_rp_status").val(d.rp_s2w_status);

                // Also store in localStorage
                localStorage.setItem("rp_id", d.rp_id);
                localStorage.setItem("s2w_rp_status", d.rp_s2w_status);

                console.log("AFTER AJAX -> IP ID:", d.rp_id, "Status:", d.rp_s2w_status, "IR ID:", d.rp_ir_id, "SR ID:", d.rp_sr_id,  "S2W ID", d.rp_s2w_id);

                /* -----------------------------------------
                1. Fill basic fields
                --------------------------------------------*/
                $("#fd_cronology").val(d.rp_s2w_cronology || "");
                $("#fd_rootcause").val(d.rp_s2w_rootcause || "");
                $("#fd_rootcause_area").val(d.rp_s2w_rootcause_area || "");
                $("#fd_rootcause_place").val(d.rp_s2w_rootcause_place || "");
                $("#fd_correction").val(d.rp_s2w_correction || "");
                $("#fd_preventive").val(d.rp_s2w_preventive || "");
                $("#fd_conclusion").val(d.rp_s2w_conclusion || "");

                /* -----------------------------------------
                2. Reset new image selection
                --------------------------------------------*/
                // correctionFiles = [];
                new_correction_files
                $("#correction_photo_s2w").val("");

                existing_correction_photos = [];

                if (d.photo_correction && d.photo_correction.length > 0) {
                    d.photo_correction.forEach(p => {
                        existing_correction_photos.push({
                            id: p.correction_photoid,
                            rp_id: d.rp_id,
                            url: `gallery/inspection_s2w_report/photo_correction/${d.rp_id}/${p.file}`
                        });
                    });
                }

                renderCorrectionPhotos();

                // preventiveFiles = [];
                new_preventive_files = [];
                $("#preventive_photo_s2w").val("");

                existing_preventive_photos = [];

                if (d.photo_preventive && d.photo_preventive.length > 0) {
                    d.photo_preventive.forEach(p => {
                        existing_preventive_photos.push({
                            id: p.preventive_photoid,
                            rp_id: d.rp_id,
                            url: `gallery/inspection_s2w_report/photo_preventive/${d.rp_id}/${p.file}`
                        });
                    });
                }

                renderPreventivePhotos();

                /* -----------------------------------------
                4. Set hidden s2w_id properly
                --------------------------------------------*/
                if ($("#hidden_rp_id").length === 0) {
                    $("<input>", {
                        type: "hidden",
                        id: "hidden_rp_id",
                        value: d.rp_id || ""
                    }).appendTo(".card-body");
                } else {
                    $("#hidden_rp_id").val(d.rp_id || "");
                }

                if (!$("#hidden_rp_status").length) {
                    $("<input>", {
                        type: "hidden",
                        id: "hidden_rp_status",
                        value: d.rp_status
                    }).appendTo(".card-body");
                } else {
                    $("#hidden_rp_status").val(d.rp_status);
                }

                /* -----------------------------------------
                5. Button visibility and Access Control Logic
                --------------------------------------------*/
                const rp_s2w_status = parseInt(d.rp_s2w_status);
                const isCreator = (sessionId === d.created_by);

                // GLOBAL VIEW-ONLY MODE (If not creator)
                if (!isCreator) {
                    $("#btnSave, #btnUpdate, #btnSubmit, #btnCancel").addClass("d-none");
                    
                    // Disable all form fields and add visual indicator
                    $(".profile-blog input, .profile-blog textarea, .profile-blog select").prop("disabled", true);
                    $(".card-body").addClass("readonly-mode");

                    // DISABLE IMAGE UPLOAD & DELETE (FOR ALL)
                    $("#correction_photo_s2w, #preventive_photo_s2w").prop("disabled", true);
                    $("label[for='correction_photo_s2w'], label[for='preventive_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });
                    $(".remove-old, .remove-new, .remove-old-preventive, .remove-new-preventive").remove();
                    
                    // Show "View Only" message if desired, or just hide buttons
                    if (!$("#viewOnlyBadge").length) {
                        $('<span id="viewOnlyBadge" class="badge badge-light border ms-2"><i class="fa fa-eye me-1"></i> Read Only Mode</span>')
                        .insertAfter(".dashboard_bar");
                    }

                } else {
                    // CREATOR LOGIC (Standard Workflow)
                    
                    // NEW ENTRY (no s2w_id yet)
                    if (!rp_s2w_status || rp_s2w_status === 0) {
                        $("#btnSave").removeClass("d-none");
                    }
                    // DRAFT or RETURNED → allow UPDATE + SUBMIT
                    else if (rp_s2w_status === 12 || rp_s2w_status === 13) {
                        $("#btnUpdate").removeClass("d-none");
                        $("#btnSubmit").removeClass("d-none");
                        $("#btnSave").addClass("d-none");
                    }
                    // PENDING REVIEW → show CANCEL BUTTON ONLY
                    else if (rp_s2w_status === 10) {
                        $("#btnSave").addClass("d-none");
                        $("#btnCancel").removeClass("d-none");

                        if ($("#btnCancel").length === 0) {
                            $("<button>", {
                                id: "btnCancel",
                                type: "button",
                                class: "btn btn-black",
                                'data-irid': d.ir_id,
                                'data-srid': d.sr_id,
                                'data-s2wid': d.s2w_id,
                                'data-rpid': d.rp_id
                            })
                            .html('<i class="fa fa-times me-1"></i> Cancel S2W Report')
                            .appendTo(".text-end");
                        } else {
                            $("#btnCancel").removeClass("d-none");
                        }

                        // Disable form fields
                        $(".profile-blog input, .profile-blog textarea, .profile-blog select").prop("disabled", true);
                        $("#correction_photo_s2w, #preventive_photo_s2w").prop("disabled", true);
                        $("label[for='correction_photo_s2w'], label[for='preventive_photo_s2w']").addClass("disabled").css({
                            opacity: 0.4,
                            pointerEvents: "none"
                        });
                        $(".remove-old, .remove-new, .remove-old-preventive, .remove-new-preventive").remove();
                    }
                    // APPROVED / CANCELLED / COMPLETED → VIEW ONLY
                    else if (rp_s2w_status === 4 || rp_s2w_status === 5 || rp_s2w_status === 8) {
                        $("#btnSave, #btnUpdate, #btnSubmit, #btnCancel").addClass("d-none");
                        $("input, textarea, select").prop("disabled", true);
                        $("#correction_photo_s2w, #preventive_photo_s2w").prop("disabled", true);
                        $("label[for='correction_photo_s2w'], label[for='preventive_photo_s2w']").addClass("disabled").css({
                            opacity: 0.4,
                            pointerEvents: "none"
                        });
                        $(".remove-old, .remove-new, .remove-old-preventive, .remove-new-preventive").remove();
                    }
                }
                
                // Keep ZOOM functionality active regardless of owner/status
                $("#correction_photo_existing .zoom-item, #preventive_photo_existing .zoom-item").css("pointer-events", "auto");

                /* -----------------------------------------
                7. Re-init tooltips
                --------------------------------------------*/
                initTooltips();
            }
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

        console.log("New:", arrNew.length, "Existing:", arrExisting.length);

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
    
    //Validation Function
    function scrollToField(selector) {
        $('html, body').animate({
            scrollTop: $(selector).offset().top - 120   // adjust if header exists
        }, 400);
    }

    // UPDATE RECORD
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

        let fd = new FormData();

        fd.append("action", "update_s2w");
        fd.append("ir_id", $("#hidden_ir_id").val());
        fd.append("sr_id", $("#hidden_sr_id").val());
        fd.append("s2w_id", $("#hidden_s2w_id").val());
        fd.append("rp_id", $("#hidden_rp_id").val());
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

        Swal.fire({
            text: "Save changes to this S2W report?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: "#198754"
        }).then(r => {
            if (!r.isConfirmed) return;

            $.ajax({
                url: "fetch-ip-s2w-section-rcd-all.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",

                success: function(res) {
                    if (res.status === "success") {

                        new_correction_files = [];
                        existing_correction_photos = []; 
                        $("#correction_photo_s2w").val("");

                        new_preventive_files = [];
                        existing_preventive_photos = []; 
                        $("#preventive_photo_s2w").val("");

                        Swal.fire({
                            title: "Updated!",
                            text: "S2W record update successfully.",
                            icon: "success",
                            iconColor: "#286912",
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

    //SUBMIT RECORD
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

        let fd = new FormData();
        fd.append("action", 'submit_s2w_report');
        fd.append("ir_id", $("#hidden_ir_id").val());
        fd.append("sr_id", $("#hidden_sr_id").val());
        fd.append("s2w_id", $("#hidden_s2w_id").val());
        fd.append("rp_id", $("#hidden_rp_id").val());        
        fd.append("s2w_rp_status", $("#hidden_rp_status").val());
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

        Swal.fire({
            // title: "Submit this S2W for review?",
            text: "Submit this S2W Report for approval?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Submit",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
        }).then((result) => {
            if (!result.isConfirmed) return;
            
            $.ajax({
            url: 'fetch-ip-s2w-section-rcd-all.php',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            defectSend: function() {
                Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your s2w.',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
                });
            },
            success: function(res) {
                Swal.close();

                if (res.status === "success"){

                let emailMessage = '';
                if (res.emails_sent > 0 || res.emails_failed > 0) {
                    emailMessage = `\n\nEmail summary:\n Sent: ${res.emails_sent}\n Failed: ${res.emails_failed}`;
                    if (res.emails_failed > 0 && res.failed_list.length > 0) {
                        emailMessage += `\n\nFailed recipients:\n${res.failed_list.join('\n')}`;
                    }
                }

                    Swal.fire({
                        icon: 'success',
                        iconColor: "#286912",
                        title: 'Submitted!',
                        text: res.msg || 'Your S2W Report was submitted for approval.',
                        timer: 3000,
                        showConfirmButton: false
                    }).then(() => {

                        // redirect to view page or reload list
                        // window.location.href = 'ip-s2w-list-all.php';
                        history.back();

                    });
                } 
                else {
                    Swal.fire({
                        icon: 'error',
                        iconColor: "#286912",
                        title: 'Oops...',
                        text: res.msg || 'Failed to submit.',
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                icon: 'error',
                iconColor: "#286912",
                title: 'Error',
                text: 'An error occurred: ' + (xhr.responseText || error),
                });
            }
            });
        });
    });

    // CANCEL SUBMISSION
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
            });
            $('#cancel_remark').addClass('border-error');
            return;
        }
        $('#cancel_remark').removeClass('border-error');

        // Show confirmation first
        Swal.fire({
            title: 'Confirm cancellation?',
            text: 'Are you sure you want to cancel this S2W Report?',
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
                    url: 'fetch-ip-s2w-section-rcd-all.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { action: 'cancel_record', rp_id, ir_id, sr_id, s2w_id, remark },
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
                                window.location.href = 'ip-s2w-sect-list-all.php';

                            });

                            // Redirect
                            // setTimeout(() => {
                            //     window.location.href = 'ip-s2w-list-all.php';
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