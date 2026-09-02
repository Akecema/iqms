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
        
        </style>

		<?php

        $eir_id = $_GET['erid'] ?? null;
        
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

                <div class="card mb-4">
                    <div class="card-header border-0 ai-tabs-1 mb-4">
                        
                        <h4 class="card-title"></h4>
                        <ul class="nav nav-tabs mb-3">
                            <li class="nav-item"><a href="#add-sorting-tab" class="nav-link active show"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="p-1"> Sorting</span></a></li>
                            <li class="nav-item"><a href="#part-involve-tab" onclick="window.location.href='ip-sorting-part-involve.php?erid=<?=$eir_id?>'" class="nav-link"><i class="fa fa-list" aria-hidden="true"></i> <span class="p-1">Part Involve</span></a></li>
                        </ul>
                    </div>

                    
                    <div class="card-body py-0 mb-4 divDocno d-flex">
                        <div class="col-md-4 mb-3">
                            <div class="alert alert-meron border-meron outline-dashed py-3 px-4 d-flex align-items-center justify-content-between text-dark">

                                <!-- LEFT SIDE: Icon + Doc Info -->
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

                                <!-- RIGHT SIDE: Total Earnings -->
                                <!-- <div class="d-flex align-items-center border outline-dashed rounded px-3 py-2 divDocnoCancel">
                                    <div class="avatar avatar-md style-1 bg-primary-light text-primary rounded d-flex align-items-center justify-content-center">
                                        <i class="bi bi-x"></i>
                                    </div>
                                    <div class="ms-2 text-end">
                                        <h4 class="mb-0 fw-semibold lh-1 viewCancelDocno"></h4>
                                        <span class="fs-14">Cancellation Doc No</span>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <!-- Sorting Qty & method -->
                        <div class="tab-pane fade show active" id="add-sorting-tab" role="tabpanel" aria-labelledby="create-tab" tabindex="0">    
                            <div class="card-body ai-tabs-1 py-2"> 

                                <input type="hidden" id="hidden_ir_id" name="hidden_ir_id" class="form-control" value="<?=$eir_id;?>">

                                <div class="row g-4 mt-2">

                                    <!-- LEFT -->
                                    <div class="col-md-6">
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
                                                        <input type="number" id="sr_qty_ok" name="sr_qty_ok" class="form-control">
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label class="form-label">Qty NG <span class="text-danger p-1">*</span></label>
                                                        <input type="number" id="sr_qty_ng" name="sr_qty_ng" class="form-control">
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

                                    <!-- RIGHT -->
                                    <div class="col-md-6">
                                        <!-- ALL RIGHT CONTENT HERE -->
                                        <div class="field-section">
                                            <h6 class="section-title">
                                                <i class="fa fa-image"></i> Photos Before (NG) <span class="text-danger p-1">*</span>
                                            </h6>

                                            <div id="before_photo_existing" class="photo-box d-flex flex-wrap mb-2"></div>
                                            <div id="before_photo_new" class="photo-box d-flex flex-wrap mb-2"></div>

                                            <input type="file" class="form-control d-none" id="before_photo" name="before_photo[]" multiple hidden>
                                            <label for="before_photo" class="btn btn-primary light btn-sm btnImg"><i class="fa fa-upload me-1"></i> Add Image</label>
                                            <div class="s2w-small-text">Use Ctrl to select multiple images</div>
                                        </div>

                                        <div class="field-section">
                                            <h6 class="section-title">
                                                <i class="fa fa-image"></i> Photos After Sorting (OK) <span class="text-danger p-1">*</span>
                                            </h6>

                                            <div id="after_photo_existing" class="photo-box d-flex flex-wrap mb-2"></div>
                                            <div id="after_photo_new" class="photo-box d-flex flex-wrap mb-2"></div>

                                            <input type="file" class="form-control d-none" id="after_photo" name="after_photo[]" multiple hidden>
                                            <label for="after_photo" class="btn btn-primary light btn-sm btnImg"><i class="fa fa-upload me-1"></i> Add Image</label>
                                            <div class="s2w-small-text">Use Ctrl to select multiple images</div>
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
        window.location.href = "ip-sorting.php";
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
        const irid = urlParams.get('erid');
        if (irid) {
            loadMaterialDetails(irid);
        }
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
                    border-radius:8px;border:1px solid #ddd;cursor:zoom-in;
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

        const ir_id = $("#hidden_ir_id").val();
        if (!ir_id) return;

        $.ajax({
            url: "fetch-ip-sorting.php",
            type: "POST",
            data: { action: "get_sorting_details", ir_id },
            dataType: "json",
            success: function(res) {

                console.log("AJAX Response:", res);
                if (res.status !== "success") return;

                const d = res.data;

                console.log("Sorting Status:", d.sorting_status);
                console.log("sr_id:", d.sr_id);
                
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

                if (d.sr_id !== null && d.sr_id !== undefined && d.sr_id !== "") {
                    $("#btnSave").addClass("d-none");
                    $("#btnUpdate").removeClass("d-none");  // show only if record exists

                    if (parseInt(d.sorting_status) === 12 || (parseInt(d.sorting_status) === 13)) {
                        $("#btnSubmit").removeClass("d-none");
                    } else {
                        $("#btnSubmit").addClass("d-none");
                    }

                    $("<input>", {
                        type: "hidden",
                        id: "hidden_sr_id",
                        value: d.sr_id
                    }).appendTo("body");

                    $("<input>", {
                        type: "hidden",
                        id: "hidden_sr_status",
                        value: d.sorting_status
                    }).appendTo("body");
                }
                else {
                    $("#btnUpdate").hide();  // Add this
                    $("#btnSubmit").addClass("d-none");
                }

              
                // Render Before photos
                let beforeHtml = "";
                d.photos_before.forEach(p => {
                    beforeHtml += `
                        <div class="position-relative me-2 mb-2" 
                            style="width:80px;height:80px;background-image:url('gallery/inspection_sorting/before/${d.sr_id}/${p.file}');background-size:cover;background-position:center;border-radius:8px;border:1px solid #ddd;cursor:zoom-in;" 
                            data-id="${p.id}" data-filename="${p.file}" data-folder="before">
                            <span class="remove-image-btn" data-bs-toggle="tooltip" title="Remove">&times;</span>
                        </div>`;
                });
                $("#before_photo_existing").html(beforeHtml || "<em> </em>");

                // Render After photos
                let afterHtml = "";
                d.photos_after.forEach(p => {
                    afterHtml += `
                        <div class="position-relative me-2 mb-2" 
                            style="width:80px;height:80px;background-image:url('gallery/inspection_sorting/after/${d.sr_id}/${p.file}');background-size:cover;background-position:center;border-radius:8px;border:1px solid #ddd;cursor:zoom-in;" 
                            data-id="${p.id}" data-filename="${p.file}" data-folder="after">
                            <span class="remove-image-btn" data-bs-toggle="tooltip" title="Remove">&times;</span>
                        </div>`;
                });
                $("#after_photo_existing").html(afterHtml || "<em> </em>");

                // ===== Control UI based on Sorting Status =====
                if (parseInt(d.sorting_status) === 4 || parseInt(d.sorting_status) === 8) {
                    console.log("Status = 11 → approved/locked, hide Update & Cancel buttons");

                    // Hide both buttons
                    $("#btnUpdate").addClass("d-none");
                    $("#btnCancel").addClass("d-none");

                    // Also disable the form for read-only view
                    $("#add-sorting-tab input, #add-sorting-tab textarea, #add-sorting-tab select").prop("disabled", true);

                    // Hide upload buttons and labels
                    $("#before_photo, #after_photo").addClass("d-none");
                    $("label[for='before_photo'], label[for='after_photo']").addClass("d-none");
                    $(".btnText, .btnImg").addClass("d-none");

                    // Remove delete icons if any
                    $(".remove-image-btn").remove();

                    // Apply a subtle visual lock
                    $("#add-sorting-tab .card-body")
                        .addClass("readonly-mode")
                        .css({ opacity: 0.85, pointerEvents: "none" });

                    // But keep existing photos clickable for zoom
                    $("#before_photo_existing, #after_photo_existing")
                        .css("pointer-events", "auto");

                } else if (parseInt(d.sorting_status) === 10) {
                    console.log("Status = 9 → lock form for view only, show Cancel button");

                    $("#btnUpdate").addClass("d-none");

                    // Show Cancel button if it exists, otherwise create it
                    if ($("#btnCancel").length === 0) {
                        $("<button>", {
                            id: "btnCancel",
                            type: "button",
                            class: "btn btn-black",
                            'data-irid': ir_id,
                            'data-srid': d.sr_id
                        })
                        .html('<i class="fa fa-times me-1"></i> Cancel Sorting')
                        .appendTo(".text-end");
                    } else {
                        $("#btnCancel").removeClass("d-none");
                    }

                    $("#before_photo, #after_photo").addClass("d-none");
                    $("label[for='before_photo'], label[for='after_photo']").addClass("d-none");
                    $(".btnText, .btnImg").addClass("d-none");

                    $("#add-sorting-tab input, #add-sorting-tab textarea, #add-sorting-tab select").prop("disabled", true);
                    $(".remove-image-btn").remove();

                    $("#add-sorting-tab .card-body")
                        .addClass("readonly-mode")
                        .find("input, textarea, select, button:not(#btnCancel)")
                        .prop("disabled", true);

                    $("#before_photo_existing, #after_photo_existing").css("pointer-events", "auto");

                } else {
                    console.log("Status ≠ 9 or 11 → normal editable mode");

                    $("#btnUpdate").removeClass("d-none");
                    $("#btnCancel").addClass("d-none");

                    $("#add-sorting-tab input, #add-sorting-tab textarea, #add-sorting-tab select").prop("disabled", false);

                    $("#before_photo, #after_photo").removeClass("d-none");
                    $("label[for='before_photo'], label[for='after_photo']").removeClass("d-none");
                    $(".btnText, .btnImg").removeClass("d-none");

                    $("#add-sorting-tab .card-body").css({ opacity: 1, pointerEvents: "auto" });
                }


                

                // Reinitialize tooltips for dynamically added elements
                initTooltips();

            }
        });
    });

    // ----- Add new record -------
    $(document).on("click", "#btnSave", function() {

        // collect values
        let qty_ok  = $("#sr_qty_ok").val().trim();
        let qty_ng  = $("#sr_qty_ng").val().trim();
        let sorting_method = $("#sr_sorting").val().trim();
        let rework_method  = $("#sr_rework").val().trim();
        let remarks        = $("#sr_remarks").val().trim();

        let before_photos  = $("#before_photo")[0].files;
        let after_photos = $("#after_photo")[0].files;

        // validation
        if(!qty_ok) {
            alert("QTY OK is required.");
            $('#sr_qty_ok').addClass('border-error');
            return;
        }
        else {
            $('#sr_qty_ok').removeClass('border-error');
        }

        if (qty_ok < 0) {
            alert("QTY OK cannot be less than 0.");
            $('#sr_qty_ok').addClass('select-error');
            return;
        }
        else {
            $('#sr_qty_ok').removeClass('border-error');
        }

        if(!qty_ng) {
            alert("QTY NG is required.");
            $('#sr_qty_ng').addClass('border-error');
            return;
        }
        else {
            $('#sr_qty_ng').removeClass('border-error');
        }

        if (qty_ng <= 0) {
            alert("QTY NG cannot be less than or equal 0.");
            $('#sr_qty_ng').addClass('select-error');
            return;
        }
        else {
            $('#sr_qty_ng').removeClass('border-error');
        }

        if (beforeFiles.length === 0) {
            alert('Please add at least one photo before sorting!');
            $('label[for="before_photo"]').addClass('border-error');
            return;
        }
        else {
            $('label[for="before_photo"]').removeClass('border-error');
        }

        if (afterFiles.length === 0) {
            alert('Please add at least one photo after sorting!');
            $('label[for="after_photo"]').addClass('border-error');
            return;
        }
        else {
            $('label[for="after_photo"]').removeClass('border-error');
        }

        if (!sorting_method) {
            alert('Sorting method is required');
            $('#sr_sorting').addClass('border-error');
            return;
        }
        else {
            $('#sr_sorting').removeClass('border-error');
        }

        if (!rework_method) {
            alert('Rework method is required');
            $('#sr_rework').addClass('border-error');
            return;
        }
        else {
            $('#sr_rework').removeClass('border-error');
        }

        if (!remarks) {
            alert('Remarks is required');
            $('#sr_remarks').addClass('border-error');
            return;
        }
        else {
            $('#sr_remarks').removeClass('border-error');
        }

        // build FormData (important for file uploads)
        let formData = new FormData();
        formData.append("action", "add_sorting");
        formData.append("ir_id", $("#hidden_ir_id").val());
        formData.append("qty_ok", qty_ok);
        formData.append("qty_ng", qty_ng);
        formData.append("sorting_method", sorting_method);
        formData.append("rework_method", rework_method);
        formData.append("remarks", remarks);

        // Append images
        beforeFiles.forEach(file => formData.append('before_photo[]', file));
        afterFiles.forEach(file => formData.append('after_photo[]', file));

        Swal.fire({
            title: "Confirm Save?",
            text: "Save this sorting record?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "fetch-ip-sorting.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(res) {
                        if (res.status === "success") {

                            Swal.fire({
                                title: "Success",
                                text: res.message,
                                icon: "success",
                                iconColor: "#286912",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754"
                                }).then(() => { 

                                    $("#btnSave").addClass("d-none");
                                    $("#btnUpdate").removeClass("d-none");
                                    $("#btnSubmit").removeClass("d-none");

                                    // store IDs
                                    const ir_id = res.ir_id;    
                                    const sr_id = res.insert_id;
                                    const sr_status = res.sr_status;

                                    console.log("Saved IDs:", ir_id, sr_id, sr_status);

                                    // dynamically add data attributes to the submit button
                                    $("#btnSubmit").attr({"data-irid": ir_id,"data-srid": sr_id,"data-srstatus": sr_status});

                                    // Save the sorting ID for future updates
                                    if ($("#hidden_sr_id").length === 0) {
                                    $("<input>").attr({
                                        type: "hidden",
                                        id: "hidden_sr_id",
                                        value: sr_id
                                    }).appendTo("body");
                                    } else {
                                    $("#hidden_sr_id").val(sr_id);
                                    }

                                    // store in localStorage
                                    localStorage.setItem("ir_id", ir_id);
                                    localStorage.setItem("sr_id", sr_id);

                                    window.location.href = `ip-sorting-part-involve.php?erid=${res.ir_id}&sid=${res.insert_id}`;  
                            });
                        } else {
                            Swal.fire("Error", res.message, "error");
                        }
                    },
                    error: function(xhr, status, err) {
                        Swal.fire("Error", "Something went wrong: " + err, "error");
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        
        const ir_id = localStorage.getItem("ir_id") || $("#hidden_ir_id").val();
        const sr_id = localStorage.getItem("sr_id") || $("#hidden_sr_id").val();
        const sr_status = localStorage.getItem("sr_id") || $("#hidden_sr_status").val();
        console.log("Load IDs:", ir_id, sr_id, sr_status);

        if (ir_id && sr_id) {
            $("#btnSubmit").attr({
            "data-irid": ir_id,
            "data-srid": sr_id,
            "data-srstatus": sr_status
            }).removeClass("d-none");
        }
    });

    // ------ Cancel record ------
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
            showCancelButton: true,
            confirmButtonText: 'Yes, Cancel it',
            cancelButtonText: 'No, Keep it',
            cancelButtonColor: '#198754'
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
                            });

                            // Redirect
                            setTimeout(() => {
                                window.location.href = 'ip-sorting.php';
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

    let existing_before_photos = [];   // from DB
    let existing_after_photos = [];    // from DB
    let new_before_files = [];         // selected but not uploaded yet
    let new_after_files = [];
    let deleted_before_ids = [];       // IDs to delete from DB
    let deleted_after_ids = [];

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
                    background-size:cover;background-position:center;border:1px solid #ccc;">
                    <span class="remove-old" data-type="${type}" data-id="${img.id}" 
                        style="position:absolute;top:-10px;right:-10px;
                        font-size:18px;cursor:zoom-in;z-index:2;">&times;</span>
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
                        background-size:cover;background-position:center;border:1px solid #ccc;">
                        <span class="remove-new" data-type="${type}" data-idx="${idx}"
                            style="position:absolute;top:-10px;right:-10px;
                            font-size:18px;cursor:zoom-in;z-index:2;">&times;</span>
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
            url: "fetch-ip-sorting.php",
            type: "POST",
            dataType: "json",
            data: { action: "get_sorting_photos", ir_id },
            success: function(res) {
                if (res.status === "success") {
                    existing_before_photos = res.before || [];
                    existing_after_photos  = res.after || [];
                    renderPhotoPreview("#before_photo_existing", existing_before_photos, [], "before");
                    renderPhotoPreview("#after_photo_existing", existing_after_photos, [], "after");
                }
            }
        });
    }

    // ===========================================================
    // HANDLE FILE INPUTS
    // ===========================================================
    $("#before_photo").on("change", function() {
        for (let f of this.files) new_before_files.push(f);
        renderPhotoPreview("#before_photo_new", [], new_before_files, "before");
        $(this).val('');
    });

    $("#after_photo").on("change", function() {
        for (let f of this.files) new_after_files.push(f);
        renderPhotoPreview("#after_photo_new", [], new_after_files, "after");
        $(this).val('');
    });

    // ===========================================================
    // REMOVE NEW (not yet uploaded)
    // ===========================================================
    $(document).on("click", ".remove-new", function() {
        const type = $(this).data("type");
        const idx = $(this).data("idx");

        if (type === "before") new_before_files.splice(idx, 1);
        else new_after_files.splice(idx, 1);

        renderPhotoPreview(
            type === "before" ? "#before_photo_new" : "#after_photo_new",
            [],
            type === "before" ? new_before_files : new_after_files,
            type
        );
    });

    // ===========================================================
    // ON SAVE/UPDATE → append new photos into formData
    // ===========================================================
    function appendPhotosToForm(formData) {
        new_before_files.forEach(f => formData.append("before_photo[]", f));
        new_after_files.forEach(f => formData.append("after_photo[]", f));
    }

    </script>

    <script>

    // --- Delete photo (DB + file) ---
    $(document).on('click', '.remove-image-btn', function(e) {
        e.stopPropagation();
        const container = $(this).closest('.position-relative');
        const id = container.data('id');
        const folder = container.data('folder');

        Swal.fire({
            title: "Confirm Delete?",
            text: "This photo will be permanently deleted.",
            icon: "warning",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it",
            confirmButtonColor: "#dc3545"
        }).then((r) => {
            if (r.isConfirmed) {
                $.post("delete-sorting-photo.php", { action: folder === "before" ? "delete_before" : "delete_after", id }, function(res) {
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
        const qty_ok  = $("#sr_qty_ok").val().trim();
        const qty_ng  = $("#sr_qty_ng").val().trim();
        const sorting_method = $("#sr_sorting").val().trim();
        const rework_method  = $("#sr_rework").val().trim();
        const remarks        = $("#sr_remarks").val().trim();

        // Count total photos (existing + new)
        const totalBefore = $("#before_photo_existing .position-relative").length + beforeFiles.length;
        const totalAfter  = $("#after_photo_existing .position-relative").length + afterFiles.length;

        // Sequential validation
        if (!qty_ok || qty_ok < 0) {
            Swal.fire("Validation", "Qty OK is required and cannot be negative.", "warning");
            $("#sr_qty_ok").addClass("border-error").focus();
            return false;
        } else {
            $("#sr_qty_ok").removeClass("border-error");
        }

        if (!qty_ng || qty_ng <= 0) {
            Swal.fire("Validation", "Qty NG is required and must be greater than 0.", "warning");
            $("#sr_qty_ng").addClass("border-error").focus();
            return false;
        } else {
            $("#sr_qty_ng").removeClass("border-error");
        }

        if (totalBefore === 0) {
            Swal.fire("Validation", "Please include at least one BEFORE (NG) photo.", "warning");
            $("label[for='before_photo']").addClass("border-error");
            return false;
        } else {
            $("label[for='before_photo']").removeClass("border-error");
        }

        if (totalAfter === 0) {
            Swal.fire("Validation", "Please include at least one AFTER (OK) photo.", "warning");
            $("label[for='after_photo']").addClass("border-error");
            return false;
        } else {
            $("label[for='after_photo']").removeClass("border-error");
        }

        if (!sorting_method) {
            Swal.fire("Validation", "Sorting Method is required.", "warning");
            $("#sr_sorting").addClass("border-error").focus();
            return false;
        } else {
            $("#sr_sorting").removeClass("border-error");
        }

        if (!rework_method) {
            Swal.fire("Validation", "Rework Method is required.", "warning");
            $("#sr_rework").addClass("border-error").focus();
            return false;
        } else {
            $("#sr_rework").removeClass("border-error");
        }

        if (!remarks) {
            Swal.fire("Validation", "Remarks is required.", "warning");
            $("#sr_remarks").addClass("border-error").focus();
            return false;
        } else {
            $("#sr_remarks").removeClass("border-error");
        }

        return true; // all good
    }

    // --- Update ---
    $(document).on('click', '#btnUpdate', function() {

        if (!validateSortingForm()) return;

        let formData = new FormData();
        formData.append("action", "update_sorting");
        formData.append("ir_id", $("#hidden_ir_id").val());
        formData.append("sr_id", $("#hidden_sr_id").val());
        formData.append("qty_ok", $("#sr_qty_ok").val());
        formData.append("qty_ng", $("#sr_qty_ng").val());
        formData.append("sorting_method", $("#sr_sorting").val());
        formData.append("rework_method", $("#sr_rework").val());
        formData.append("remarks", $("#sr_remarks").val());

        beforeFiles.forEach(f => formData.append("before_photo[]", f));
        afterFiles.forEach(f => formData.append("after_photo[]", f));

        Swal.fire({
            title: "Confirm Update?",
            icon: "question",
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: "Yes, update",
            confirmButtonColor: "#198754"
        }).then((r) => {
            if (r.isConfirmed) {
                $.ajax({
                    url: "fetch-ip-sorting.php",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    success: function(res) {
                        if (res.status === "success") {

                            // Reset image arrays to prevent re-uploading
                            beforeFiles = [];
                            afterFiles = [];

                            Swal.fire({
                                title: "Updated!",
                                text: res.message,
                                icon: "success",
                                iconColor: "#286912",
                                confirmButtonText: "OK",
                                confirmButtonColor: "#198754" // change here
                            }).then(() => location.reload());

                            
                        } else {
                            Swal.fire("Error", res.message, "error");
                        }
                    }
                });
            }
        });
    });

    // -------Submit---
    $(document).on('click', '#btnSubmit', function() {

        if (!validateSortingForm()) return; 

        const ir_id = $("#hidden_ir_id").val();
        const sr_id = $("#hidden_sr_id").val();
        const sr_status = $("#hidden_sr_status").val();
        console.log("Submit clicked for:", ir_id, sr_id,sr_status);

        Swal.fire({
            title: "Submit for approval?",
            text: "Submit this sorting report for approval?",
            icon: "question",
            iconColor: "#286912",
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
            formData.append('sr_status', sr_status);
            formData.append("qty_ok", $("#sr_qty_ok").val());
            formData.append("qty_ng", $("#sr_qty_ng").val());
            formData.append("sorting_method", $("#sr_sorting").val());
            formData.append("rework_method", $("#sr_rework").val());
            formData.append("remarks", $("#sr_remarks").val());

            beforeFiles.forEach(f => formData.append("before_photo[]", f));
            afterFiles.forEach(f => formData.append("after_photo[]", f));
            
            $.ajax({
            url: 'fetch-ip-sorting.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function() {
                Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your submission.',
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
                    iconColor: "#286912",
                    title: 'Submitted!',
                    text: res.msg || 'Your sorting report was submitted for approval.',
                    timer: 3000,
                    confirmButtonColor: "#198754",
                    showConfirmButton: false
                }).then(() => {
                    // redirect to view page or reload list
                    window.location.href = 'ip-sorting.php';
                });
                } else {
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

    </script>

    </script>

    <!-- Check if part involved exist to enabled/disbaled tab part involve -->
    <script>

    $(document).ready(function() {
        const ir_id = <?= $eir_id ?>; // from your PHP variable

        $.post("check-part-involve.php", { ir_id: ir_id }, function(res) {
            const data = JSON.parse(res);

            const $tab = $('a[href="#part-involve-tab"]');

            if (data.exists) {
                // Enable and make clickable
                $tab.removeClass('disabled text-muted');
                $tab.css('pointer-events', 'auto');
            } else {
                // Disable and make look inactive
                $tab.addClass('disabled text-muted');
                $tab.css('pointer-events', 'none');
            }
        });
    });

    </script>
    
</body>
</html>