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

        .remove-old-ok {
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
        .remove-old-ok:hover {
            background: #B31236;
            color: #fff;
            border-color: #FAF7F9;
        }

        .remove-new-ok {
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
        .remove-new-ok:hover {
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
                    <div class="col-xl-4">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
                                    <div class="card-header">
                                        <h5 class="heading mb-0 text-primary">S2W Details </h5>
                                    </div>
									<div class="card-body">	
                                        <div class="widget-timeline-icons pb-1 mt-4">                                            

                                            <?php

                                            $sqls2w = "SELECT S.s2w_id, S.s2w_additional_desc, T.rd_dept_name
                                                        FROM inspection_s2w S
                                                        LEFT JOIN related_departments T ON S.s2w_send_to = T.rd_dept_id
                                                        WHERE S.s2w_id = ?";
                                            $stmts2w = $db_con->prepare($sqls2w);
                                            $stmts2w->bind_param("i", $es2w_id);
                                            $stmts2w->execute();
                                            $ress2w = $stmts2w->get_result();
                                            $rows2w = $ress2w->fetch_assoc();

                                            ?>
                                                                                                
                                            <div class="timeline-panel">
                                                <div class="clearfix">
                                                    <div class="post-1">
                                                        <div class="post-data">
                                                            <h6>Additional Information (If Any)</h6>
                                                            <span>
                                                                <textarea class="form-control smart-area" placeholder="No Additional Information found..." disabled><?= $rows2w['s2w_additional_desc'] ?></textarea>
                                                            </span>                                                            
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row g-3 mt-1">
                                                    <!-- Defect Photo Card -->
                                                    <div class="col-lg-12">
                                                        <div class="p-3 border rounded-3 h-100 mb-0">                                                                                                                                    
                                                            <h6 class="mb-2">Photos NG (Defect)</h6>
                                                            <div class="avatar-list avatar-list-stacked">
                                                                <?php
                                                                //Fetch defect photos
                                                                $photoHtml = '';
                                                                $sqlPhoto = "SELECT defect_photoid, defect_photo
                                                                                FROM inspection_s2w_defect_photo
                                                                                WHERE s2w_id = ?
                                                                                ORDER BY defect_photoid ASC";
                                                                $stmtPhoto = $db_con->prepare($sqlPhoto);
                                                                $stmtPhoto->bind_param("i", $es2w_id);
                                                                $stmtPhoto->execute();
                                                                $resPhoto = $stmtPhoto->get_result();
                                                                
                                                                while ($photo = $resPhoto->fetch_assoc()) {
                                                                    $photoUrl = 'gallery/s2w/photo_defect/'. $es2w_id .'/'. $photo['defect_photo'];
                                                                ?>
                                                                    <img src="<?= $photoUrl ?>" alt="" class="viewAvatar avatar avatar-sm rounded-circle" data-full="<?= $photoUrl ?>">
                                                                <?php } ?>
                                                            </div>                                                                     
                                                        </div>
                                                        
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="p-3 border rounded-3 h-100 mb-0">                                                                                                                                    
                                                            <h6 class="mb-2">Photo OK</h6>
                                                            <div class="avatar-list avatar-list-stacked">
                                                                <?php
                                                                //Fetch OK photos
                                                                $OKHtml = '';
                                                                $sqlOK = "SELECT ok_photoid,ok_photo
                                                                                FROM inspection_s2w_ok_photo
                                                                                WHERE s2w_id = ?
                                                                                ORDER BY ok_photoid ASC";
                                                                $stmtOK = $db_con->prepare($sqlOK);
                                                                $stmtOK->bind_param("i", $es2w_id);
                                                                $stmtOK->execute();
                                                                $resOK = $stmtOK->get_result();

                                                                while ($OKphoto = $resOK->fetch_assoc()) {
                                                                    $OKUrl = 'gallery/s2w/photo_ok/'. $es2w_id .'/'. $OKphoto['ok_photo'];
                                                                ?>
                                                                <img src="<?= $OKUrl ?>" alt="" class="viewAvatar avatar avatar-sm rounded-circle" data-full="<?= $OKUrl ?>">

                                                                <?php } ?>
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
                    <div class="col-xl-8">
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
                                                    <div class="mb-4 mt-3">                                             
                                                        <div id="correction_photo_existing" class="d-flex flex-wrap mb-2"></div>
                                                        <div id="defect_photo_new" class="d-flex flex-wrap mb-2"></div>

                                                        <input type="file" class="form-control d-none" id="correction_photo_s2w" name="correction_photo_s2w[]" multiple hidden>
                                                        <label for="correction_photo_s2w" class="btn btn-primary light btn-sm btnImg"><i class="fa fa-upload me-1"></i> Add Image</label>
                                                                                                    
                                                        <small class="text-muted d-block btnText">Use Ctrl to select multiple images</small>
                                                    </div>
                                                </div>   
                                                
                                                <!-- preventive-->                                                
                                                <div class="mb-4 mt-2">
                                                    <label class="form-label">Preventive <span class="text-danger">*</span></label>
                                                    <textarea class="form-control" id="fd_preventive" rows="3" placeholder="Permanent Counter Measure"></textarea>
                                                </div>

                                                <!-- Photos -->
                                                <div class="col-md-5 mb-4">
                                                    <h6>Preventive Photos <span class="text-danger">*</span></h6>
                                                    <div class="mb-4 mt-3">                                             
                                                        <div id="preventive_photo_existing" class="d-flex flex-wrap mb-2"></div>
                                                        <div id="ok_photo_new" class="d-flex flex-wrap mb-2"></div>

                                                        <input type="file" class="form-control d-none" id="preventive_photo_s2w" name="preventive_photo_s2w[]" multiple hidden>
                                                        <label for="preventive_photo_s2w" class="btn btn-primary light btn-sm btnImg"><i class="fa fa-upload me-1"></i> Add Image</label>
                                                                                                    
                                                        <small class="text-muted d-block btnText">Use Ctrl to select multiple images</small>
                                                    </div>
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
                    border:1px solid #ddd;cursor:pointer"
                    data-id="${img.id}" data-s2w="${img.s2w_report_id}">

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
                        data-url="${e.target.result}"
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
                    border:1px solid #ddd;cursor:pointer"
                    data-id="${img.id}" data-s2w="${img.s2w_report_id}">

                    <span class="remove-old-ok no-zoom"
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
                        data-url="${e.target.result}"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url('${e.target.result}');
                        background-size:cover;background-position:center;
                        border:1px solid #ddd;cursor:pointer">

                        <span class="remove-new-ok no-zoom" data-idx="${idx}"
                            style="position:absolute;top:-10px;right:-10px;
                            cursor:pointer;font-size:20px;z-index:10;">&times;</span>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    }

    // Add New Photo
    $("#correction_photo_s2w").on("change", function () {

        for (let file of this.files) {
            if (file && file.size > 0) {     // <-- FILTER EMPTY FILES
                new_correction_files.push(file);
            }
        }
        renderCorrectionPhotos();
        this.value = "";
    });

    $("#preventive_photo_s2w").on("change", function () {

        for (let file of this.files) {
            if (file && file.size > 0) {
                new_preventive_files.push(file);
            }
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

    $(document).on("click", ".remove-new-ok", function (e) {
        e.stopPropagation();
        e.preventDefault();
        new_preventive_files.splice($(this).data("idx"), 1);
        renderPreventivePhotos();
    });

    //Remove Existing Photo (stored in DB)
    $(document).on("click", ".remove-old", function (e) {

        e.stopPropagation();   // HARD stop
        e.preventDefault(); 

        const id = $(this).parent().data("id");
        const s2w_report_id = $(this).parent().data("s2w");

        Swal.fire({
            title: "Delete this photo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#d33"
        }).then(r => {
            if (!r.isConfirmed) return;

            $.post("fetch-ip-s2w-section.php",
                { action: "delete_correction_photo", id, s2w_report_id },
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

    $(document).on("click", ".remove-old-ok", function (e) {

        e.stopPropagation();
        e.preventDefault();

        const id = $(this).parent().data("id");
        const s2w_report_id = $(this).parent().data("s2w");

        Swal.fire({
            title: "Delete this photo?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Delete",
            confirmButtonColor: "#d33"
        }).then(r => {
            if (!r.isConfirmed) return;

            $.post("fetch-ip-s2w-section.php",
                { action: "delete_preventive_photo", id, s2w_report_id },
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
        formData.append("correction_photo_s2w[]", f)
    );

    //For update
    new_correction_files.forEach(f =>
        formData.append("correction_photo_s2w[]", f)
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

    $(document).on("click", ".zoom-item-ok", function (e) {

        if ($(e.target).hasClass("no-zoom") ||
            $(e.target).hasClass("remove-old-ok") ||
            $(e.target).hasClass("remove-new-ok")) return;

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

    // SAVE
    $(document).on('click', '#btnSave', function() {

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

        // Add new photos only
        new_correction_files.forEach(f => fd.append("correction_photo[]", f));
        new_preventive_files.forEach(f => fd.append("preventive_photo[]", f));

        Swal.fire({
            title: "Confirm save this S2W report?",
            icon: "question",
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
                    if (data.status === "success") {

                        // Reset new images
                        // Clear NEW upload arrays
                        new_correction_files = [];
                        new_preventive_files = [];

                        // Clear existing — force refresh later
                        // existing_correction_photos = [];
                        // existing_preventive_photos = [];

                        // Clear file inputs
                        $("#correction_photo_s2w").val("");
                        $("#preventive_photo_s2w").val("");

                        const s2w_report_id = data.insert_id;
                        const ir_id = data.ir_id;
                        const sr_id = data.sr_id;
                        const s2w_id = data.s2w_id;
                        const s2w_report_status = data.s2w_report_status;

                        // Attach the correct S2W ID to both update buttons
                        $("#btnUpdate").attr({
                            "data-s2wreportid": s2w_id,
                            "data-s2wid": s2w_id,
                            "data-irid": ir_id,
                            "data-srid": sr_id
                        });

                        $("#btnSubmit").attr({
                            "data-s2wreportid": s2w_id,
                            "data-s2wid": s2w_id,
                            "data-irid": ir_id,
                            "data-srid": sr_id,
                            "data-s2wstatus": s2w_report_status
                        });

                        // Store hidden S2W REPORT ID
                        if (!$("#hidden_s2w_report_id").length) {
                            $("<input>", {
                                type: "hidden",
                                id: "hidden_s2w_report_id",
                                value: s2w_report_id
                            }).appendTo(".card-body");
                        } else {
                            $("#hidden_s2w_report_id").val(s2w_report_id);
                        }

                        // Switch buttons
                        $("#btnSave").addClass("d-none");
                        $("#btnUpdate").removeClass("d-none");
                        $("#btnSubmit").removeClass("d-none");

                        Swal.fire({
                            title: "Saved!",
                            text: "S2W report saved successfully.",
                            icon: "success",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"   // <-- GREEN button
                        });

                        // Reload updated images from DB
                        $.ajax({
                            url: "fetch-ip-s2w-section.php",
                            type: "POST",
                            data: { action: "get_s2w_details", s2w_id: data.s2w_id },
                            dataType: "json",
                            success: function(res) {

                                const d = res.data;

                                if (d.photo_correction) {
                                    d.photo_correction.forEach(p => {
                                        existing_correction_photos.push({
                                            id: p.correction_photoid,
                                            s2w_report_id: d.rp_s2w_report_id,
                                            url: `gallery/s2w_report/photo_correction/${d.rp_s2w_report_id}/${p.file}`
                                        });
                                    });
                                }

                                if (d.photo_preventive) {
                                    d.photo_preventive.forEach(p => {
                                        existing_preventive_photos.push({
                                            id: p.preventive_photoid,
                                            s2w_report_id: d.rp_s2w_report_id,
                                            url: `gallery/s2w_report/photo_preventive/${d.rp_s2w_report_id}/${p.file}`
                                        });
                                    });
                                }

                                renderCorrectionPhotos();
                                renderPreventivePhotos();
                            }
                        });

                    }
                }
            });
        });
    });

    // Load Existing Record 
    $(document).ready(function () {

        const s2w_id = $("#hidden_s2w_id").val();
        if (!s2w_id) return;

        $.ajax({
            url: "fetch-ip-s2w-section.php",
            type: "POST",
            data: { action: "get_s2w_details", s2w_id },
            dataType: "json",

            success: function (res) {

                if (res.status !== "success") return;

                const d = res.data;

                // Store S2W ID & STATUS into hidden inputs (always)
                $("#hidden_s2w_report_id").val(d.rp_s2w_report_id);
                $("#hidden_s2w_report_status").val(d.rp_s2w_report_status);

                // Also store in localStorage
                localStorage.setItem("s2w_report_id", d.rp_s2w_report_id);
                localStorage.setItem("s2w_report_status", d.rp_s2w_report_status);

                console.log("AFTER AJAX -> S2W REPORT ID:", d.rp_s2w_report_id, "Status:", d.rp_s2w_report_status, "IR ID:", d.rp_s2w_ir_id, "SR ID:", d.rp_s2w_sr_id, "S2W ID:", d.rp_s2w_id);

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
                existing_correction_photos = [];
                existing_preventive_photos = [];

                if (d.photo_correction && d.photo_correction.length > 0) {
                    d.photo_correction.forEach(p => {
                        existing_correction_photos.push({
                            id: p.correction_photoid,
                            s2w_report_id: d.rp_s2w_report_id,
                            url: `gallery/s2w_report/photo_correction/${d.rp_s2w_report_id}/${p.file}`
                        });
                    });
                }

                if (d.photo_preventive && d.photo_preventive.length > 0) {
                    d.photo_preventive.forEach(p => {
                        existing_preventive_photos.push({
                            id: p.preventive_photoid,
                            s2w_report_id: d.rp_s2w_report_id,
                            url: `gallery/s2w_report/photo_preventive/${d.rp_s2w_report_id}/${p.file}`
                        });
                    });
                }

                renderCorrectionPhotos();
                renderPreventivePhotos();

                /* -----------------------------------------
                4. Set hidden s2w_id properly
                --------------------------------------------*/
                if ($("#hidden_s2w_report_id").length === 0) {
                    $("<input>", {
                        type: "hidden",
                        id: "hidden_s2w_report_id",
                        value: d.rp_s2w_report_id || ""
                    }).appendTo(".card-body");
                } else {
                    $("#hidden_s2w_report_id").val(d.rp_s2w_report_id || "");
                }

                if (!$("#hidden_s2w_report_status").length) {
                    $("<input>", {
                        type: "hidden",
                        id: "hidden_s2w_report_status",
                        value: d.s2w_report_status
                    }).appendTo(".card-body");
                } else {
                    $("#hidden_s2w_report_status").val(d.s2w_report_status);
                }

                /* -----------------------------------------
                5. Button visibility logic (clean version)
                --------------------------------------------*/

                // STATUS LOGIC
                const s2w_report_status = parseInt(d.rp_s2w_report_status);

                // NEW ENTRY (no s2w_id yet)
                if (!s2w_report_status || s2w_report_status === "0") {
                    $("#btnSave").removeClass("d-none");
                }

                // DRAFT (13) allow UPDATE + SUBMIT
                else if (s2w_report_status === 13) {

                    $("#btnUpdate").removeClass("d-none");
                    $("#btnSubmit").removeClass("d-none");
                    $("#btnSave").addClass("d-none");
                    $("#btnCancel").removeClass("d-none");
                }

                // PENDING REVIEW → show CANCEL BUTTON ONLY
                else if (s2w_report_status === 4 || s2w_report_status === 10) {
                    
                    $("#btnSave").addClass("d-none");
                    $("#btnUpdate").removeClass("d-none");
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
                    $("#correction_photo_s2w").prop("disabled", true);
                    $("label[for='correction_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old, .remove-new").remove();

                    // ALLOW ZOOM ONLY
                    $("#correction_photo_existing .zoom-item").css("pointer-events", "auto");

                    // DISABLE IMAGE UPLOAD
                    $("#preventive_photo_s2w").prop("disabled", true);
                    $("label[for='preventive_photo_s2w']").addClass("disabled").css({
                        opacity: 0.4,
                        pointerEvents: "none"
                    });

                    // DISABLE DELETE ICONS
                    $(".remove-old, .remove-new").remove();

                    // ALLOW ZOOM ONLY
                    $("#preventive_photo_existing .zoom-item").css("pointer-events", "auto");
                }

                // APPROVED / CANCELLED / PENDING APPROVAL → VIEW ONLY
                else if (s2w_report_status === 4 || s2w_report_status === 8 || s2w_report_status === 10) {

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

                    $(".remove-old-ok, .remove-new-ok").remove();

                    $("#preventive_photo_existing .zoom-item-ok").css("pointer-events", "auto");

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
       
        // if (!validateField("#fd_cronology", "Cronology")) return;
        // if (!validateField("#fd_rootcause", "Root Cause")) return;
        // if (!validateField("#fd_rootcause_area", "Root Cause Area")) return;
        // if (!validateField("#fd_rootcause_place", "Root Cause Place")) return;
        // if (!validateField("#fd_correction", "Correction / Corrective")) return;
        // if (!validatePhotos(new_correction_files, existing_correction_photos, "Correction", "#correction_photo_box")) return;
        // if (!validateField("#fd_preventive", "Preventive")) return;
        // if (!validatePhotos(new_preventive_files, existing_preventive_photos, "Preventive", "#preventive_photo_box")) return;
        // if (!validateField("#fd_conclusion", "Conclusion")) return;

        let fd = new FormData();
        fd.append("action", "update_s2w");
        fd.append("ir_id", $("#hidden_ir_id").val());
        fd.append("sr_id", $("#hidden_sr_id").val());
        fd.append("s2w_id", $("#hidden_s2w_id").val());
        fd.append("s2w_report_id", $("#hidden_s2w_report_id").val());

        // fields
        fd.append("fd_cronology", $("#fd_cronology").val());
        fd.append("fd_rootcause", $("#fd_rootcause").val());
        fd.append("fd_rootcause_area", $("#fd_rootcause_area").val());
        fd.append("fd_rootcause_place", $("#fd_rootcause_place").val());
        fd.append("fd_correction", $("#fd_correction").val());
        fd.append("fd_preventive", $("#fd_preventive").val());
        fd.append("fd_conclusion", $("#fd_conclusion").val());

        // Only send NEW images
        new_correction_files.forEach(f => fd.append("correction_photo[]", f));
        new_preventive_files.forEach(f => fd.append("preventive_photo[]", f));

        Swal.fire({
            title: "Confirm Update?",
            text: "Are you sure you want to save this S2W Report?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754",
            cancelButtonColor: "#6c757d",
        }).then(r => {
            if (!r.isConfirmed) return;

            $.ajax({
                url: "fetch-ip-s2w-section.php",
                type: "POST",
                data: fd,
                processData: false,
                contentType: false,
                dataType: "json",

                success: function(res) {
                    if (res.status === "success") {

                        new_correction_files = [];
                        new_preventive_files = [];

                        // existing_correction_photos = []; 
                        // existing_preventive_photos = []; 
                        
                        $("#correction_photo_s2w").val("");
                        $("#preventive_photo_s2w").val("");

                        Swal.fire({
                            title: "Updated!",
                            text: "S2W report update successfully.",
                            icon: "success",
                            confirmButtonText: "OK",
                            confirmButtonColor: "#28a745"   // <-- GREEN button
                        }).then(() => location.reload());

                        // new_correction_files = [];
                        // new_preventive_files = [];

                    }
                }
            });
        });
    });

    // Submit
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
        fd.append("action", "submit_for_review");
        fd.append("ir_id", $("#hidden_ir_id").val());
        fd.append("sr_id", $("#hidden_sr_id").val());
        fd.append("s2w_id", $("#hidden_s2w_id").val());
        fd.append("s2w_report_id", $("#hidden_s2w_report_iid").val());

        // fields
        fd.append("fd_cronology", $("#fd_cronology").val());
        fd.append("fd_rootcause", $("#fd_rootcause").val());
        fd.append("fd_rootcause_area", $("#fd_rootcause_area").val());
        fd.append("fd_rootcause_place", $("#fd_rootcause_place").val());
        fd.append("fd_correction", $("#fd_correction").val());
        fd.append("fd_preventive", $("#fd_preventive").val());
        fd.append("fd_conclusion", $("#fd_conclusion").val());

        // Also store in localStorage
        localStorage.setItem("s2w_report_id", s2w_report_id);
        localStorage.setItem("s2w_report_status", s2w_report_status);

        console.log("Submit clicked for:", ir_id, sr_id, s2w_report_id, s2w_report_status);

        Swal.fire({
            title: "Submit this S2W report for approval?",
            // text: "Submit this S2W for review?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Submit",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
        }).then((result) => {

            if (!result.isConfirmed) return;

            new_correction_files.forEach(f => fd.append("correction_photo_s2w[]", f));
            new_preventive_files.forEach(f => fd.append("preventive_photo_s2w[]", f));
            
            $.ajax({
            url: 'fetch-ip-s2w-section.php',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            defectSend: function() {
                Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your S2W report submitting .',
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
                    text: res.msg || 'Your S2W report was submitted for approval.',
                    timer: 3000,
                    showConfirmButton: false
                }).then(() => {
                    // redirect to view page or reload list
                    window.location.href = 'ip-s2w-sect.php';
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
                    url: 'fetch-ip-s2w-section.php',
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