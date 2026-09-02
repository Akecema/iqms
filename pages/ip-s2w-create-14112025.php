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
            width: 40px;
            height: 40px;
            font-size: 0.75rem;
            text-align: center;
            line-height: 32px;
        }
        .avatar-sm:hover {
            transform: scale(1.2); /* optional: subtle zoom effect on hover */
        }
        
        #btnUpdate, #btnSubmit {
            position: relative;
            z-index: 1000 !important;
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

                <div class="card mb-4">
                    
                    <!-- <div class="card-body py-0 mb-4 divDocno d-flex">
                        <div class="col-md-4 mb-3">
                            <div class="alert alert-meron border-meron outline-dashed py-3 px-4 d-flex align-items-center justify-content-between text-dark">                               
                                <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M15 30C18.9782 30 22.7936 28.4196 25.6066 25.6066C28.4196 22.7936 30 18.9782 30 15C30 11.0218 28.4196 7.20644 25.6066 4.3934C22.7936 1.58035 18.9782 0 15 0C11.0218 0 7.20644 1.58035 4.3934 4.3934C1.58035 7.20644 0 11.0218 0 15C0 18.9782 1.58035 22.7936 4.3934 25.6066C7.20644 28.4196 11.0218 30 15 30ZM12.6562 19.6875H14.0625V15.9375H12.6562C11.877 15.9375 11.25 15.3105 11.25 14.5312C11.25 13.752 11.877 13.125 12.6562 13.125H15.4688C16.248 13.125 16.875 13.752 16.875 14.5312V19.6875H17.3438C18.123 19.6875 18.75 20.3145 18.75 21.0938C18.75 21.873 18.123 22.5 17.3438 22.5H12.6562C11.877 22.5 11.25 21.873 11.25 21.0938C11.25 20.3145 11.877 19.6875 12.6562 19.6875ZM15 7.5C15.4973 7.5 15.9742 7.69754 16.3258 8.04918C16.6775 8.40081 16.875 8.87772 16.875 9.375C16.875 9.87228 16.6775 10.3492 16.3258 10.7008C15.9742 11.0525 15.4973 11.25 15 11.25C14.5027 11.25 14.0258 11.0525 13.6742 10.7008C13.3225 10.3492 13.125 9.87228 13.125 9.375C13.125 8.87772 13.3225 8.40081 13.6742 8.04918C14.0258 7.69754 14.5027 7.5 15 7.5Z" fill="#de413cff"/>
                                    </svg>
                                </div>
                                <div>
                                    <h6 class="mb-0 fw-semibold viewDocno"></h6>
                                    <p class="mb-0 viewStatus"></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <?php

                    $sql = "SELECT I.ir_pallet_no
                            FROM inspection_records as I  
                            WHERE I.ir_id = ?";
                    $stmt = $db_con->prepare($sql);
                    $stmt->bind_param("s", $eir_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $row = $result->fetch_assoc();

                    ?>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="add-sorting-tab" role="tabpanel" aria-labelledby="create-tab" tabindex="0">   

                            <div class="col-xl-3 col-3 or-series p-4 ms-auto">
                                <div class="card text-center border-primary outline-dashed">
                                    <div class="card-body p-2">
                                        <h3><?= $row['ir_pallet_no'] ?></h3>
                                        <span>Pallet Sequence</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="widget-timeline-icons pb-3 mt-1">
                                <ul class="timeline">

                                <?php

                                $sqlDefect = "SELECT D.defect_id, D.defect_type, D.defect_area, T.defectname
                                                FROM inspection_defect D
                                                LEFT JOIN defect_type T ON D.defect_type = T.defectid
                                                WHERE D.rcd_ir_id = ?";
                                $stmtDefect = $db_con->prepare($sqlDefect);
                                $stmtDefect->bind_param("i", $eir_id);
                                $stmtDefect->execute();
                                $resDefect = $stmtDefect->get_result();

                                while ($defect = $resDefect->fetch_assoc()) {

                                ?>
                                    <li class="me-4">
                                        <div class="timeline-media">
                                            <i class="las la-cog"></i>
                                        </div>
                                        <div class="timeline-panel">
                                            <div class="clearfix">
                                                <span class="text-black fs-14 fw-semibold"><?= $defect['defectname'] ?></span>
                                                <span class="fs-14 d-block">Defect Area : <span class="text-primary"><?= $defect['defect_area'] ?></span></span>
                                            </div>

                                            <div class="row g-3 mt-1">
                                                <!-- Defect Photo Card -->
                                                <div class="col-lg-6">
                                                    <div class="p-3 border rounded-3 h-100">
                                                        <h6 class="mb-3">Defect Photo</h6>
                                                        <div class="avatar-list avatar-list-stacked">
                                                        <?php

                                                        $defectId = $defect['defect_id'];

                                                        //Fetch defect photos
                                                        $photoHtml = '';
                                                        $sqlPhoto = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                                                        $stmtPhoto = $db_con->prepare($sqlPhoto);
                                                        $stmtPhoto->bind_param("ii", $eir_id, $defectId);
                                                        $stmtPhoto->execute();
                                                        $resPhoto = $stmtPhoto->get_result();
                                                        
                                                        while ($photo = $resPhoto->fetch_assoc()) {
                                                            $photoUrl = 'gallery/inspection/defect/'. $photo['defect_photo'];
                                                        ?>
                                                            <img src="<?= $photoUrl ?>" alt="" class="viewAvatar avatar avatar-sm rounded-circle" data-full="<?= $photoUrl ?>">
                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Comparison Photo Card -->
                                                <div class="col-lg-6">
                                                    <div class="p-3 border rounded-3 h-100">
                                                        <h6 class="mb-3">Comparison Photo</h6>
                                                        <div class="avatar-list avatar-list-stacked">
                                                        <?php
                                                        //Fetch comparison photos
                                                        $compareHtml = '';
                                                        $sqlCompare = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                                                        $stmtCompare = $db_con->prepare($sqlCompare);
                                                        $stmtCompare->bind_param("ii", $eir_id, $defectId);
                                                        $stmtCompare->execute();
                                                        $resCompare = $stmtCompare->get_result();

                                                        while ($compare = $resCompare->fetch_assoc()) {
                                                            $compareUrl = 'gallery/inspection/defect_compare/'. $compare['compare_photo'];
                                                        ?>
                                                        <img src="<?= $compareUrl ?>" alt="" class="viewAvatar avatar avatar-sm rounded-circle" data-full="<?= $compareUrl ?>">

                                                        <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                    
                                    <?php } ?>
                                </ul>
                            </div>

                            <hr>

                            <div class="card-body ai-tabs-1 py-2 mt-4"> 

                                <input type="hidden" id="hidden_ir_id" name="hidden_ir_id" class="form-control" value="<?= $eir_id ?>">
                                <input type="hidden" id="hidden_sr_id" name="hidden_sr_id" class="form-control" value="<?= $esr_id ?>">

                                <!-- Sub-section Title -->
                                <!-- <div class="section-title-sub mb-4">
                                    <i class="fa fa-image me-2"></i> Images & Method
                                </div> -->

                                <div class="row p-4">                                   

                                    <!-- Additional Information -->
                                    <div class="col-md-6" style="margin-right: 1.5rem;">
                                        <div class="mb-3">
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
                                    </div>

                                    <!-- Photos -->
                                    <div class="col-md-5">
                                        <h6>Defect Photos (NG)</h6>
                                        <div class="mb-4">                                             
                                            <div id="defect_photo_existing" class="d-flex flex-wrap mb-2"></div>
                                            <div id="defect_photo_new" class="d-flex flex-wrap mb-2"></div>

                                            <input type="file" class="form-control d-none" id="defect_photo_s2w" name="defect_photo_s2w[]" multiple hidden>
                                            <label for="defect_photo_s2w" class="btn btn-primary light btn-sm btnImg"><i class="fa fa-upload me-1"></i> Add Image</label>
                                                                                        
                                            <small class="text-muted d-block btnText">Use Ctrl to select multiple images</small>
                                        </div>
                                    </div>
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

    //--## S2W

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
                console.log("Loaded S2W:", d);

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
                            id: p.id,
                            url: `gallery/s2w/defect/${d.s2w_id}/${p.file}`
                        });
                    });
                }

                renderPhotoPreview("#defect_photo_existing", existing_defect_photos, new_defect_files, "defect");

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

                /* -----------------------------------------
                5. Button visibility logic (clean version)
                --------------------------------------------*/

                // NEW ENTRY → no S2W ID
                if (!d.s2w_id || d.s2w_id === "" || d.s2w_id === "0") {

                    $("#btnSave").removeClass("d-none");
                    $("#btnUpdate").addClass("d-none");
                    $("#btnSubmit").addClass("d-none");

                } else {

                    // EXISTING ENTRY
                    $("#btnSave").addClass("d-none");
                    $("#btnUpdate").removeClass("d-none");

                    // Status 12 → DRAFT → allow submit
                    if (parseInt(d.s2w_status) === 12 || parseInt(d.s2w_status) === 13 ) {
                        $("#btnSubmit").removeClass("d-none");
                    } else {
                        $("#btnSubmit").addClass("d-none");
                    }

                    // Assign IDs to Update + Submit buttons
                    $("#btnUpdate").attr({
                        "data-s2wid": d.s2w_id,
                        "data-irid": d.ir_id,
                        "data-srid": d.sr_id
                    });

                    $("#btnSubmit").attr({
                        "data-s2wid": d.s2w_id,
                        "data-irid": d.ir_id,
                        "data-srid": d.sr_id,
                        "data-s2wstatus": d.s2w_status
                    });
                }

                /* -----------------------------------------
                6. Read-only mode (Approved / Cancelled)
                --------------------------------------------*/
                if (parseInt(d.s2w_status) === 4 || parseInt(d.s2w_status) === 8 || parseInt(d.s2w_status) === 9) {

                    $("#btnUpdate").addClass("d-none");
                    $("#btnSubmit").addClass("d-none");
                    $("#btnCancel").addClass("d-none");

                    // Disable all form fields
                    $("#add-sorting-tab input, #add-sorting-tab textarea, #add-sorting-tab select")
                        .prop("disabled", true);

                    // Hide image upload elements
                    $("#defect_photo_s2w").addClass("d-none");
                    $("label[for='defect_photo_s2w']").addClass("d-none");
                    $(".remove-old").remove();

                    // Read-only style
                    $("#add-sorting-tab .card-body").css({
                        opacity: 0.85,
                        pointerEvents: "none"
                    });

                    // Allow zoom for existing photos
                    $("#defect_photo_existing").css("pointer-events", "auto");
                }

                /* -----------------------------------------
                7. Re-init tooltips
                --------------------------------------------*/
                initTooltips();
            }
        });
    });


    // ----- Add new record -------
    $(document).on('click', '#btnSave', function() {

        let add_info  = $("#fd_addinfo").val().trim();
        let send_dept = $(".fd_dept").val();

        if (!send_dept) {
            alert("Sending To is required.");
            return;
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


    $('.fd_dept').on('change', function() {
        if ($(this).val()) {
            $(this).next('.select2-container').find('.select2-selection').removeClass('border-error');
        }
    });

    $(document).ready(function() {
        
        const ir_id = localStorage.getItem("ir_id") || $("#hidden_ir_id").val();
        const sr_id = localStorage.getItem("sr_id") || $("#hidden_sr_id").val();        
        const s2w_id = localStorage.getItem("s2w_id") || $("#hidden_s2w_id").val();
        const s2w_status = localStorage.getItem("s2w_status") || $("#hidden_s2w_status").val();
        console.log("Load IDs:", ir_id, sr_id, s2w_id, s2w_status);

        if (ir_id && sr_id && s2w_id) {
            $("#btnSubmit").attr({
            "data-irid": ir_id,
            "data-srid": sr_id,
            "data-s2wid": s2w_id,
            "data-s2wstatus": s2w_status
            }).removeClass("d-none");
        }
    });

    // ------ Cancel record ------
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

    </script>

    <script>

    let existing_defect_photos = [];   // from DB
    let new_defect_files = [];         // selected but not uploaded yet
    let deleted_defect_ids = [];       // IDs to delete from DB

    // ===========================================================
    // Render PREVIEWS
    // ===========================================================
    function renderPhotoPreview(container, existing, selected, type) {
        const c = $(container);
        c.empty();

        // Existing (from DB)
        existing.forEach((img) => {
            const imgDiv = $(`
                <div class="position-relative me-2 mb-2 avatar-preview" 
                    style="width:80px;height:80px;border-radius:8px;
                    background-image:url(${encodeURI(img.url)});
                    background-size:cover;background-position:center;border:1px solid #ccc;cursor:pointer">
                    <span class="remove-old" data-type="${type}" data-id="${img.id}" data-s2wid="${s2w_id}"
                        style="position:absolute;top:-10px;right:-10px;
                        font-size:18px;cursor:pointer;z-index:2;">DD</span>
                </div>
            `);
            c.append(imgDiv);
        });

        // New (not yet uploaded)
        selected.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`
                    <div class="position-relative me-2 mb-2 avatar-preview"
                        style="width:80px;height:80px;border-radius:8px;
                        background-image:url(${e.target.result});
                        background-size:cover;background-position:center;border:1px solid #ccc;cursor:pointer">
                        <span class="remove-new" data-type="${type}" data-idx="${idx}"
                            style="position:absolute;top:-10px;right:-10px;
                            font-size:18px;cursor:pointer;z-index:2;">&times;</span>
                    </div>
                `);
                c.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    // ===========================================================
    // LOAD EXISTING PHOTOS (from DB)
    // ===========================================================
    function loadExistingPhotos(ir_id) {
        $.ajax({
            url: "fetch-ip-s2w.php",
            type: "POST",
            dataType: "json",
            data: { action: "get_sorting_photos", ir_id },
            success: function(res) {
                if (res.status === "success") {
                    existing_defect_photos = res.defect || [];
                    renderPhotoPreview("#defect_photo_existing", existing_defect_photos, new_defect_files, "defect");
                }
            }
        });
    }

    // ===========================================================
    // HANDLE FILE INPUTS
    // ===========================================================
    $("#defect_photo_s2w").on("change", function () {

        // Add new selected files
        for (let f of this.files) new_defect_files.push(f);

        // Re-render everything
        renderPhotoPreview(
            "#defect_photo_existing",
            existing_defect_photos,
            new_defect_files,
            "defect"
        );

        this.value = "";
    });

    // ===========================================================
    // REMOVE NEW (not yet uploaded)
    // ===========================================================
    $(document).on("click", ".remove-new", function() {
        const type = $(this).data("type");
        const idx = $(this).data("idx");

        if (type === "defect") new_defect_files.splice(idx, 1);

        renderPhotoPreview(
            type === "defect" ? "#defect_photo_new" : "",
            [],
            type === "defect" ? new_defect_files : '',
            type
        );
    });

    // ===========================================================
    // ON SAVE/UPDATE → append new photos into formData
    // ===========================================================
    function appendPhotosToForm(formData) {
        new_defect_files.forEach(f => formData.append("defect_photo_s2w[]", f));
    }

    </script>

    <script>

    // --- Delete photo (DB + file) ---
    $(document).on('click', '.remove-old', function(e) {
        e.stopPropagation();
        const container = $(this).closest('.position-relative');
        const id = container.data('id');
        const s2wid = container.data('s2wid');
        const folder = container.data('folder');

        Swal.fire({
            title: "Confirm Delete?",
            text: "This photo will be permanently deleted.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it",
            confirmButtonColor: "#dc3545"
        }).then((r) => {
            if (r.isConfirmed) {
                $.post("delete-s2w-photo.php", { action: folder === "defect" ? "delete_defect" : "", id, s2wid }, function(res) {
                    if (res.status === "success") {
                        container.fadeOut(300, () => container.remove());
                    } else {
                        Swal.fire("Error", res.message, "error");
                    }
                }, "json");
            }
        });
    });

    // Validation
    function validateSortingForm() {

        const add_info  = $("#fd_addinfo").val().trim();
        const send_dept  = $(".fd_dept").val().trim();

        // Sequential validation
        if (!send_dept) {
            Swal.fire("Validation", "Sending To is required.", "warning");
            $('.fd_dept').next('.select2-container').find('.select2-selection').addClass('border-error');
            return false;
        } else {
            $(".fd_dept").removeClass("border-error");
        }

        return true; // all good
    }

    // --- Update ---
    $(document).on('click', '#btnUpdate', function() {

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

    // -------Submit---
    $(document).on('click', '#btnSubmit', function() {

        if (!validateSortingForm()) return; 

        const ir_id = $("#hidden_ir_id").val();
        const sr_id = $("#hidden_sr_id").val();
        const s2w_id = $("#hidden_s2w_id").val();
        const s2w_status = $("#hidden_s2w_status").val();
        console.log("Submit clicked for:", ir_id, sr_id, s2w_id, s2w_status);

        Swal.fire({
            title: "Submit for review?",
            text: "Are you sure you want to submit this S2W for review?",
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

    </script>
    
</body>
</html>