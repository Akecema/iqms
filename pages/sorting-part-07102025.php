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

                <div class="card h-auto">
                    <div class="card-body ai-tabs-1 py-2">
                        <ul class="nav nav-tabs align-items-end" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="create-tab" data-bs-toggle="tab" data-bs-target="#create-tab-pane" type="button" role="tab" aria-controls="create-tab-pane" 
                                aria-selected="true">
                                Sorting
                            </button>
                            </li>
                            <li class="nav-item" role="presentation">
                            <a class="nav-link" type="button" href="sorting-part.php">
                                Part Involve
                            </a>
                            </li>								  
                        </ul>
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

                <div class="tab-content" id="myTabContent">
					<div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">

                        <div class="card"> 
                            <div class="cm-content-body form excerpt rounded-0">
                                <div class="card-body">
                                    <!-- <h6 class="mb-1">Menu Structure</h6>
                                    <p class="fs-13 mb-4">Add menu items from the column on the left.</p> -->

                                    <div class="row">
                                        <div class="col-xl-6 col-lg-9 col-md-3">
                                            <div class="product-detail-content">
                                                
                                                <!--Defect details-->
                                                <div class="new-arrival-content pr">
                                                    <h4>Photos Before (NG)</h4>
                                                    
                                                    <div class="cm-content-body publish-content form excerpt">
                                                        <div class="card-body">
                                                            <div class="row">                                                        
                                                                <div class="col-xl-12 col-sm-12">
                                                                    <div class="avatar-upload d-flex flex-column">
                                                                        <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer"></div>

                                                                        <!-- Display images  -->                                                                                                         
                                                                        <div id="defect_photo_preview" class="d-flex flex-wrap mt-2"></div> 
                                                                        <div class="change-btn mt-2">
                                                                            <input type="file" class="form-control d-none addBefore" name="defect_photo[]" id="defect_photo" accept="image/*" multiple>
                                                                            <label for="defect_photo" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                            <small class="text-muted d-block mt-1">Use ctrl key to select multiple images. Selected images will appear above.</small>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="d-flex align-items-end flex-wrap mt-4">
                                                        <h4>Photos After Sorting (OK)</h4>
                                                        
                                                        <div class="cm-content-body publish-content form excerpt">
                                                            <div class="card-body">
                                                                <div class="row">                                                        
                                                                    <div class="col-xl-12 col-sm-12">
                                                                        <div class="avatar-upload d-flex flex-column">
                                                                            <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare"></div>  
                                                                            
                                                                            <!-- Display images  -->
                                                                            <div id="compare_photo_preview" class="d-flex flex-wrap mt-2"></div>
                                                                            <div class="change-btn mt-2">
                                                                                <input type="file" class="form-control d-none addAfter" name="compare_photo[]" id="compare_photo" accept="image/*" multiple>
                                                                                <label for="compare_photo" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                                <small class="text-muted d-block mt-1">Use ctrl key to select multiple images. Selected images will appear above.</small>
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

                                        <div class="col-xl-6 col-lg-9 col-md-3">
                                            <div class="col-xl-6 col-sm-6 mb-3">
                                                <label class="form-label">Sorting Method</label>
                                                <textarea class="form-control" placeholder="Enter sorting method" cols="60" rows="3"></textarea>
                                            </div>
                                            <div class="col-xl-6 col-sm-6 mb-3">
                                                <label class="form-label">Rework Method</label>
                                                <textarea class="form-control" placeholder="Enter reworks method" rows="3"></textarea>
                                            </div>
                                            <div class="col-xl-6 col-sm-6 mb-3">
                                                <label class="form-label">Remarks</label>
                                                <textarea class="form-control" placeholder="Enter remarks" rows="3"></textarea>
                                            </div>
                                            </div>
                                        </div>

                                        <div class=" border-top text-end py-3">
                                            <button type="button" id="btnDraft" class="btn btn-primary mt-2" data-bs-toggle="tooltip" title="Save as draft">Save</button>
                                            <button type="button" id="btnSubmit" class="btn btn-black mt-2" data-bs-toggle="tooltip" title="Submit for approval">Submit</button>
                                        </div>

                                    </div>

                                    <hr>

                                    
                                    <!-- Hidden -->
                                    <input type="hidden" id="hidden_ir_id" name="hidden_ir_id" class="form-control" value="<?=$eir_id;?>">
                                    <div class="accordion accordion-with-icon accordion-bordered" id="accordionExample">

                                    
                                    <!-- 1. Department -->
                                    <div class="accordion-item border-0 mb-0 p-3">
                                        <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <i class="fa fa-building me-2 text-black"></i> RELATED LOOSE PART INVOLVE - In House Part (If any)
                                        </button>
                                        </h2>
                                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="table-responsive mb-2">
                                                    <table class="isplay table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartDept">
                                                        <colgroup>
                                                            <col style="width: 15%;">
                                                            <col style="width: 20%;">
                                                            <col style="width: 18%;">
                                                            <col style="width: 35%;">
                                                            <col style="width: 8%;">
                                                            <col style="width: 8%;">
                                                            <col style="width: 8%;">
                                                        </colgroup>
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th>Related Dept</th>
                                                                <th>Type of Part </th>
                                                                <th>Part Number</th>
                                                                <th>Part Name</th>
                                                                <th>QTY OK</th>
                                                                <th>QTY NG</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                                
                                                <button type="button" id="btnAddRow" class="btn btn-primary btn-sm mt-2">+ Add New</button>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <!-- 2. Vendor -->
                                    <div class="accordion-item border-0 mb-0 p-3">
                                        <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            <i class="fa fa-truck me-2 text-black"></i> RELATED LOOSE PART INVOLVE - Tier 2 (If any)
                                        </button>
                                        </h2>
                                        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">                                        
                                                <div class="table-responsive mb-2">
                                                    <table class="isplay table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartVendor">
                                                        <colgroup>
                                                            <col style="width: 15%;">
                                                            <col style="width: 20%;">
                                                            <col style="width: 18%;">
                                                            <col style="width: 35%;">
                                                            <col style="width: 8%;">
                                                            <col style="width: 8%;">
                                                            <col style="width: 8%;">
                                                        </colgroup>
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th>Related Vendor</th>
                                                                <th>Type of Part </th>
                                                                <th>Part Number</th>
                                                                <th>Part Name</th>
                                                                <th>QTY OK</th>
                                                                <th>QTY NG</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>

                                                <button type="button" id="btnAddRowVdr" class="btn btn-primary btn-sm mt-2">+ Add New</button>

                                            </div>
                                        </div>
                                    </div>

                                    <!-- 3. Customer -->
                                    <div class="accordion-item border-0 mb-0 p-3">
                                        <h2 class="accordion-header" id="headingFour">
                                        <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <i class="fa fa-users me-2 text-black"></i> FINISHED GOODS PART INVOLVE - Customer (If any)
                                        </button>
                                        </h2>
                                        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div class="table-responsive mb-2">
                                                    <table class="isplay table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartCustomer" style="width:600px">
                                                        <colgroup>
                                                            <col style="width: 40%;">
                                                            <col style="width: 10%;">
                                                            <col style="width: 10%;">
                                                            <col style="width: 8%;">
                                                        </colgroup>
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th>Related Customer</th>
                                                                <th>QTY OK</th>
                                                                <th>QTY NG</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>	
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
        history.back();
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

    $(document).on('click', '.zoomable-img', function() {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        console.log("Clicked:", imgSrc);
        $('#zoomedImage').attr('src', imgSrc);
        const modal = new bootstrap.Modal(document.getElementById('imageZoomModal'));
        modal.show();
    });

    </script>

    <script>
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

    $(document).ready(function () {
        const urlParams = new URLSearchParams(window.location.search);
        const irid = urlParams.get('erid');
        if (irid) {
            loadMaterialDetails(irid);
        }
    });

    </script>

    <!-- ##Sorting Qty -->
    <script>

    $(document).ready(function () {

        // Save row
        $(document).on("click", ".btnSaveRowSr", function(){

            let row = $(this).closest("tr");

            let qty_ok  = row.find(".sr_qty_ok").val();
            let qty_ng  = row.find(".sr_qty_ng").val();

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".sr_qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".sr_qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".sr_qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".sr_qty_ng").removeClass('border-error');
            }
            
            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".sr_qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".sr_qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".sr_qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".sr_qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Save this sorting?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-sorting-qty.php",
                        method: "POST",
                        dataType: "json",
                        data: {  ir_id: $("#hidden_ir_id").val(), qty_ok : qty_ok, qty_ng : qty_ng, action: 'add_sorting_qty' },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                // reload full table from server instead of modifying row manually
                                loadSortingRcd($("#hidden_ir_id").val());

                            }
                            else {
                                 Swal.fire({
                                        icon: "error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });

        });

        // Update row
        $(document).on("click", ".btnUpdateRowSr", function(){

            let row = $(this).closest("tr");
            let row_id = row.data("sr_id");

            let qty_ok = row.find(".sr_qty_ok").val();
            let qty_ng = row.find(".sr_qty_ng").val();

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".sr_qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".sr_qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".sr_qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".sr_qty_ng").removeClass('border-error');
            }

            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".sr_qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".sr_qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".sr_qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".sr_qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-sorting-qty.php",
                        method: "POST",
                        dataType: "json",
                        data: { action: 'update_sorting_qty', row_id: row_id, ir_id: $("#hidden_ir_id").val(), qty_ok : qty_ok, qty_ng : qty_ng },
                        success: function(res) {
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else if(res.status === "duplicate"){

                                Swal.fire({
                                        icon: "warning",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });
        });

        function loadSortingRcd(ir_id) {
            $.ajax({
                url: "fetch-sorting-qty.php",
                method: "POST",
                data: { action: "get_sorting_qty", ir_id: ir_id },
                dataType: "html", // expect raw HTML rows
                success: function(html) {
                    console.log("Reloaded HTML:", html);
                    $("#tableSortingQty tbody").html(html);
                },
                error: function(xhr) {
                    console.error("Reload failed:", xhr.status, xhr.responseText);
                }
            });
        }

    });

    //Fetch record
    $(document).ready(function(){

        let ir_id = $("#hidden_ir_id").val();

        $.post("fetch-sorting-qty.php", {

            action: "get_sorting_qty",
            ir_id: ir_id

        }, function(res){
            $("#tableSortingQty tbody").html(res);

            // re-init select2 + tooltip
            $("#tableSortingQty .select2").select2({ width: "100%" });
            $("#tableSortingQty [data-bs-toggle='tooltip']").tooltip();

        }, "html");
    });

    </script>

    <!-- #Related Part Department -->
    <script>

    // Save related loose part involve
    $(document).ready(function () {

        // Add new row
        $(document).on("click", "#btnAddRow", function () {
            let tbody = $("#relatedPartDept tbody");
            let lastRow = tbody.find("tr:last");  

            // Prevent multiple empty rows
            if (lastRow.length > 0) {               

                let related_dept = lastRow.find(".related_dept").val();
                let type_part    = lastRow.find(".type_part").val();
                let part_no      = lastRow.find(".part_no").val();
                let qty_ok       = lastRow.find(".qty_ok").val();
                let qty_ng       = lastRow.find(".qty_ng").val();

                // if all important fields are empty, block adding new row
                if (!related_dept && !type_part && !part_no && !qty_ok && !qty_ng) {
                    Swal.fire("Warning", "Please fill or save the current row before adding a new one.", "warning");
                    return;
                }
            }

            // Add new row
            let newRow = `
                <tr>
                    <td>
                        <select class="form-control related_dept select2">
                            <option value="">Select Dept</option>
                            <?php
                            $q = $db_con->query("SELECT rd_dept_id, rd_dept_name FROM related_departments WHERE rd_dept_status='AC'");
                            while($r = $q->fetch_assoc()){
                                echo "<option value='{$r['rd_dept_id']}'>{$r['rd_dept_name']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control type_part select2">
                            <option value="">Select Type</option>
                            <?php
                            $q = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status='AC'");
                            while($r = $q->fetch_assoc()){
                                echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control part_no select2">
                            <option value="">Part Number</option>
                        </select>                        
                    </td>
                    <td>
                        <input type="text" class="form-control part_name" value="" readonly data-bs-toggle="tooltip" title="">
                    </td>
                    <td><input type="number" class="form-control qty_ok" value="" style="width:70px;"></td>
                    <td><input type="number" class="form-control qty_ng" value="" style="width:70px;"></td>
                    <td>
                        <button type="button" class="btn btn-black btn-sm btnSaveRow" data-bs-toggle="tooltip" title="Add record"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </td>
                </tr>
            `;

            tbody.append(newRow);

            // Re-init select2 + tooltip
            let addedRow = tbody.find("tr:last");
            addedRow.find(".select2").select2({ width: "100%" });
            addedRow.find("[data-bs-toggle='tooltip']").tooltip();

            // Fetch part numbers dynamically
            let ir_id = $("#hidden_ir_id").val();
            $.post("get-partno.php", { ir_id: ir_id }, function(data){
                addedRow.find(".part_no").html(data).trigger("change");
            });

        });

        // Load Part Name when Part No changes
        $(document).on("change", ".part_no", function(){
            let partNoId = $(this).val();
            let partNameInput = $(this).closest("tr").find(".part_name");

            if(partNoId){
                $.post("get-partname.php", { part_no_id: partNoId }, function(data){
                    // data now contains the part description text, not <input>
                    partNameInput.val(data);

                    partNameInput.attr("title", data)
                                .tooltip('dispose')   // destroy old tooltip
                                .tooltip();           // re-init new tooltip

                });
            } else {
                partNameInput.val("");

                partNameInput.val("").attr("title", "")
                     .tooltip('dispose'); // remove tooltip if empty
            }
        });

        // Save row
        $(document).on("click", ".btnSaveRow", function(){

            let row = $(this).closest("tr");

            let related_dept = row.find(".related_dept").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

            if(!related_dept) {
                alert("Related Dept is required.");
                row.find(".related_dept").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".related_dept").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                row.find(".type_part").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".type_part").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                row.find(".part_no").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".part_no").next('.select2').find('.select2-selection').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                row.find(".part_name").addClass('border-error');
                return;
            }
            else {
                row.find(".part_name").removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }
            
            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Save this related part?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-related-part-dept.php",
                        method: "POST",
                        dataType: "json",
                        data: {  ir_id: $("#hidden_ir_id").val(), related_dept : related_dept, type_part : type_part, part_no : part_no, 
                                part_name : part_name, qty_ok : qty_ok, qty_ng : qty_ng, action: 'add_related_part' },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                                
                                // reload full table from server instead of modifying row manually
                                loadRelatedDept($("#hidden_ir_id").val());

                            }
                            else if(res.status === "duplicate"){
                                Swal.fire({
                                        icon: "warning",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {
                                 Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });

        });

        // Update row
        $(document).on("click", ".btnUpdateRow", function(){

            let row = $(this).closest("tr");
            let row_id = row.data("srp_id");

            let related_dept = row.find(".related_dept").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

             if(!related_dept) {
                alert("Related Dept is required.");
                row.find(".related_dept").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".related_dept").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                row.find(".type_part").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".type_part").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                row.find(".part_no").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".part_no").next('.select2').find('.select2-selection').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                row.find(".part_name").addClass('border-error');
                return;
            }
            else {
                row.find(".part_name").removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-related-part-dept.php",
                        method: "POST",
                        dataType: "json",
                        data: { action: 'update_related_part', row_id: row_id, ir_id: $("#hidden_ir_id").val(), related_dept : related_dept, type_part : type_part, part_no : part_no, 
                                part_name : part_name, qty_ok : qty_ok, qty_ng : qty_ng },
                        success: function(res) {
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else if(res.status === "duplicate"){

                                Swal.fire({
                                        icon: "warning",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });
        });

        // Delete row
        $(document).on("click", ".btnDeleteRow", function(){
            let row = $(this).closest("tr");
            let row_id = row.data("srp_id"); // get srp_id if exists

            Swal.fire({
                title: "Are you sure?",
                text: row_id ? "This will delete the record permanently." : "This row will be removed.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (row_id) {
                        // Call PHP to delete saved record
                        $.post("fetch-related-part-dept.php", {
                            action: "delete_related_part",
                            row_id: row_id
                        }, function(res){
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "succes",
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();

                            } else {
                                 Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        }, "json");
                    } else {
                        // Just remove unsaved row
                        row.remove();
                    }
                }
            });
        });

        function loadRelatedDept(ir_id) {
            $.ajax({
                url: "fetch-related-part-dept.php",
                method: "POST",
                data: { action: "get_related_part", ir_id: ir_id },
                dataType: "html", // expect raw HTML rows
                success: function(html) {
                    console.log("Reloaded HTML:", html);
                    $("#relatedPartDept tbody").html(html);
                },
                error: function(xhr) {
                    console.error("Reload failed:", xhr.status, xhr.responseText);
                }
            });
        }

    });

    //Fetch record
    $(document).ready(function(){

        let ir_id = $("#hidden_ir_id").val();

        $.post("fetch-related-part-dept.php", {
            action: "get_related_part",
            ir_id: ir_id
        }, function(res){
                
            // res is already the HTML string
            $("#relatedPartDept tbody").html(res);

            // re-init tooltips after new rows are added
            initTooltips();

            // Re-init select2 after appending
            $("#relatedPartDept .select2").select2({
                width: "100%"
            });
            
        }, "html");
     
        // Init select2 for static dropdowns (in case no ajax runs)
        $("#relatedPartDept .select2").select2({ width: "100%" });

    });

    </script>

    <!-- Related Part Vendor -->
    <script>

    // Save related loose part involve
    $(document).ready(function () {

        // Add new row
        $(document).on("click", "#btnAddRowVdr", function () {
            let tbody = $("#relatedPartVendor tbody");
            let lastRow = tbody.find("tr:last");  

            // Prevent multiple empty rows
            if (lastRow.length > 0) {               

                let related_vdr = lastRow.find(".related_vdr").val();
                let type_part    = lastRow.find(".type_part").val();
                let part_no      = lastRow.find(".part_no").val();
                let qty_ok       = lastRow.find(".qty_ok").val();
                let qty_ng       = lastRow.find(".qty_ng").val();

                // if all important fields are empty, block adding new row
                if (!related_vdr && !type_part && !part_no && !qty_ok && !qty_ng) {
                    Swal.fire("Warning", "Please fill or save the current row before adding a new one.", "warning");
                    return;
                }
            }

            // Add new row
            let newRow = `
                <tr>
                    <td>
                        <select class="form-control related_vdr select2 vendor-select">
                            <option value="">Select Vendor</option>
                            <?php
                            $q = $db_con->query("SELECT rv_vendor_id, rv_vendor_name FROM related_vendors WHERE rv_vendor_status='AC'");
                            while($r = $q->fetch_assoc()){
                                echo "<option value='{$r['rv_vendor_id']}'>{$r['rv_vendor_name']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control type_part select2">
                            <option value="">Select Type</option>
                            <?php
                            $q = $db_con->query("SELECT tp_partid, tp_partname FROM type_part WHERE tp_status='AC'");
                            while($r = $q->fetch_assoc()){
                                echo "<option value='{$r['tp_partid']}'>{$r['tp_partname']}</option>";
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select class="form-control part_no select2">
                            <option value="">Part Number</option>
                        </select>                        
                    </td>
                    <td>
                        <input type="text" class="form-control part_name" value="" readonly data-bs-toggle="tooltip" title="">
                    </td>
                    <td><input type="number" class="form-control qty_ok" value="" style="width:70px;"></td>
                    <td><input type="number" class="form-control qty_ng" value="" style="width:70px;"></td>
                    <td>
                        <button type="button" class="btn btn-black btn-sm btnSaveRowVdr" data-bs-toggle="tooltip" title="Add record"><i class="fa fa-plus" aria-hidden="true"></i></button>
                    </td>
                </tr>
            `;

            tbody.append(newRow);

            // Re-init select2 + tooltip
            let addedRow = tbody.find("tr:last");
            addedRow.find(".select2").select2({ width: "100%" });
            addedRow.find("[data-bs-toggle='tooltip']").tooltip();

            // Fetch part numbers dynamically
            let ir_id = $("#hidden_ir_id").val();
            $.post("get-partno.php", { ir_id: ir_id }, function(data){
                addedRow.find(".part_no").html(data).trigger("change");
            });

        });

        // Load Part Name when Part No changes
        $(document).on("change", ".part_no", function(){
            let partNoId = $(this).val();
            let partNameInput = $(this).closest("tr").find(".part_name");

            if(partNoId){
                $.post("get-partname.php", { part_no_id: partNoId }, function(data){
                    // data now contains the part description text, not <input>
                    partNameInput.val(data);

                    partNameInput.attr("title", data)
                                .tooltip('dispose')   // destroy old tooltip
                                .tooltip();           // re-init new tooltip

                });
            } else {
                partNameInput.val("");

                partNameInput.val("").attr("title", "")
                     .tooltip('dispose'); // remove tooltip if empty
            }
        });

        // Save row
        $(document).on("click", ".btnSaveRowVdr", function(){

            let row = $(this).closest("tr");

            let related_vdr = row.find(".related_vdr").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

            if(!related_vdr) {
                alert("Related Vendor is required.");
                row.find(".related_vdr").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".related_vdr").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                row.find(".type_part").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".type_part").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                row.find(".part_no").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".part_no").next('.select2').find('.select2-selection').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                row.find(".part_name").addClass('border-error');
                return;
            }
            else {
                row.find(".part_name").removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }
            
            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Save this related part?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-related-part-vendor.php",
                        method: "POST",
                        dataType: "json",
                        data: {  ir_id: $("#hidden_ir_id").val(), related_vdr : related_vdr, type_part : type_part, part_no : part_no, 
                                part_name : part_name, qty_ok : qty_ok, qty_ng : qty_ng, action: 'add_related_part' },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                // reload full table from server instead of modifying row manually
                                loadRelatedVdr($("#hidden_ir_id").val());
                            }
                            else if(res.status === "duplicate"){
                                Swal.fire({
                                        icon: "warning",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {
                                 Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });

        });

        // Update row
        $(document).on("click", ".btnUpdateRowVdr", function(){

            let row = $(this).closest("tr");
            let row_id = row.data("srp_id");

            let related_vdr = row.find(".related_vdr").val();
            let type_part    = row.find(".type_part").val();
            let part_no      = row.find(".part_no").val();
            let part_name    = row.find(".part_name").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

             if(!related_vdr) {
                alert("Related Vendor is required.");
                row.find(".related_vdr").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".related_vdr").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!type_part) {
                alert("Type of Part is required.");
                row.find(".type_part").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".type_part").next('.select2').find('.select2-selection').removeClass('border-error');
            }

            if(!part_no) {
                alert("Part Number is required.");
                row.find(".part_no").next('.select2').find('.select2-selection').addClass('border-error');
                return;
            }
            else {
                row.find(".part_no").next('.select2').find('.select2-selection').removeClass('border-error');
            }
            
            if(!part_name) {
                alert("Part Name is required.");
                row.find(".part_name").addClass('border-error');
                return;
            }
            else {
                row.find(".part_name").removeClass('border-error');
            }

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-related-part-vendor.php",
                        method: "POST",
                        dataType: "json",
                        data: { action: 'update_related_part', row_id: row_id, ir_id: $("#hidden_ir_id").val(), related_vdr : related_vdr, type_part : type_part, part_no : part_no, 
                                part_name : part_name, qty_ok : qty_ok, qty_ng : qty_ng },
                        success: function(res) {
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else if(res.status === "duplicate"){

                                Swal.fire({
                                        icon: "warning",
                                        title: "Duplicate",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754" 
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });
        });

        // Delete row
        $(document).on("click", ".btnDeleteRowVdr", function(){
            let row = $(this).closest("tr");
            let row_id = row.data("srp_id"); // get srp_id if exists

            Swal.fire({
                title: "Are you sure?",
                text: row_id ? "This will delete the record permanently." : "This row will be removed.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (row_id) {
                        // Call PHP to delete saved record
                        $.post("fetch-related-part-vendor.php", {
                            action: "delete_related_part",
                            row_id: row_id
                        }, function(res){
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "succes",
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();

                            } else {
                                 Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        }, "json");
                    } else {
                        // Just remove unsaved row
                        row.remove();
                    }
                }
            });
        });

        function loadRelatedVdr(ir_id) {
            $.ajax({
                url: "fetch-related-part-vendor.php",
                method: "POST",
                data: { action: "get_related_part", ir_id: ir_id },
                dataType: "html", // expect raw HTML rows
                success: function(html) {
                    console.log("Reloaded HTML:", html);
                    $("#relatedPartVendor tbody").html(html);
                },
                error: function(xhr) {
                    console.error("Reload failed:", xhr.status, xhr.responseText);
                }
            });
        }

    });

    //Fetch record
    $(document).ready(function(){

        let ir_id = $("#hidden_ir_id").val();

        $.post("fetch-related-part-vendor.php", {

            action: "get_related_part",
            ir_id: ir_id

        }, function(res){
            $("#relatedPartVendor tbody").html(res);

            // re-init select2 + tooltip
            $("#relatedPartVendor .select2").select2({ width: "100%" });
            $("#relatedPartVendor [data-bs-toggle='tooltip']").tooltip();

        }, "html");
    });

    </script>

    <!-- Related Part Customer -->
    <script>

    // Save related loose part involve
    $(document).ready(function () {

        // Save row
        $(document).on("click", ".btnSaveRowCust", function(){

            let row = $(this).closest("tr");

            let related_cust = row.find(".related_cust").val();
            let qty_ok       = row.find(".qty_ok").val();
            let qty_ng       = row.find(".qty_ng").val();

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }
            
            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Save this finished goods part?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Save",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-related-part-cust.php",
                        method: "POST",
                        dataType: "json",
                        data: {  ir_id: $("#hidden_ir_id").val(), related_cust : related_cust, qty_ok : qty_ok, qty_ng : qty_ng, action: 'add_finishgoods_part' },
                        success: function(res) {
                            if(res.status === "success"){
                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                // reload full table from server instead of modifying row manually
                                loadFinishGoodsPart($("#hidden_ir_id").val());

                            }
                            else {
                                 Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });

        });

        // Update row
        $(document).on("click", ".btnUpdateRowCust", function(){

            let row = $(this).closest("tr");
            let row_id = row.data("srp_id");

            let qty_ok  = row.find(".qty_ok").val();
            let qty_ng  = row.find(".qty_ng").val();

            if(!qty_ok) {
                alert("QTY OK is required.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if(!qty_ng) {
                alert("QTY NG is required.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            if (qty_ok < 0) {
                alert("QTY OK cannot be less than 0.");
                row.find(".qty_ok").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ok").removeClass('border-error');
            }

            if (qty_ng <= 0) {
                alert("QTY NG cannot be less than or equal 0.");
                row.find(".qty_ng").addClass('border-error');
                return;
            }
            else {
                row.find(".qty_ng").removeClass('border-error');
            }

            Swal.fire({
            title: "Are you sure?",
            text: "Update this related part?",
            icon: "question",
            showCancelButton: true,
            confirmButtonText: "Yes, Update",
            cancelButtonText: "Cancel",
            confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "fetch-related-part-cust.php",
                        method: "POST",
                        dataType: "json",
                        data: { action: 'update_finishgoods_part', row_id: row_id, ir_id: $("#hidden_ir_id").val(), qty_ok : qty_ok, qty_ng : qty_ng },
                        success: function(res) {
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "success",
                                        title: "Success",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                            else {

                                Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        },
                        error: function(xhr, status, err) {
                            Swal.fire("Error", "Something went wrong: " + err, "error");
                        }
                    });
                }
            });
        });

        // Delete row
        $(document).on("click", ".btnDeleteRowCust", function(){
            let row = $(this).closest("tr");
            let row_id = row.data("srp_id"); // get srp_id if exists

            Swal.fire({
                title: "Are you sure?",
                text: row_id ? "This will delete the record permanently." : "This row will be removed.",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it",
                cancelButtonText: "Cancel",
                confirmButtonColor: "#198754"
            }).then((result) => {
                if (result.isConfirmed) {
                    if (row_id) {
                        // Call PHP to delete saved record
                        $.post("fetch-related-part-cust.php", {
                            action: "delete_related_part",
                            row_id: row_id
                        }, function(res){
                            if(res.status === "success"){

                                Swal.fire({
                                        icon: "succes",
                                        title: "Deleted!",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });

                                row.remove();
                                
                            } else {
                                 Swal.fire({
                                        icon: "Error",
                                        title: "Error",
                                        text: res.message,
                                        confirmButtonText: "OK",
                                        confirmButtonColor: "#198754"
                                    });
                            }
                        }, "json");

                        // reload full table from server instead of modifying row manually
                        loadFinishGoodsPartAftrDelete($("#hidden_ir_id").val());
                        
                    } else {
                        // Just remove unsaved row
                        row.remove();
                    }
                }
            });
        });

    });

    //Fetch record
    $(document).ready(function(){

        let ir_id = $("#hidden_ir_id").val();

        $.post("fetch-related-part-cust.php", {

            action: "get_finishgoods_part",
            ir_id: ir_id

        }, function(res){
            $("#relatedPartCustomer tbody").html(res);

            // re-init select2 + tooltip
            $("#relatedPartCustomer .select2").select2({ width: "100%" });
            $("#relatedPartCustomer [data-bs-toggle='tooltip']").tooltip();

        }, "html");
    });

    function loadFinishGoodsPart(ir_id) {
        $.ajax({
            url: "fetch-related-part-cust.php",
            method: "POST",
            data: { action: "get_finishgoods_part", ir_id: ir_id },
            dataType: "html", // expect raw HTML rows
            success: function(html) {
                console.log("Reloaded HTML:", html);
                $("#relatedPartCustomer tbody").html(html);
            },
            error: function(xhr) {
                console.error("Reload failed:", xhr.status, xhr.responseText);
            }
        });
    }

    function loadFinishGoodsPartAftrDelete(ir_id) {
        $.ajax({
            url: "fetch-related-part-cust.php",
            method: "POST",
            data: { action: "get_finishgoods_part_aftr_delete", ir_id: ir_id },
            dataType: "html", // expect raw HTML rows
            success: function(html) {
                console.log("Reloaded HTML:", html);
                $("#relatedPartCustomer tbody").html(html);
            },
            error: function(xhr) {
                console.error("Reload failed:", xhr.status, xhr.responseText);
            }
        });
    }

    </script>

    <script>

    // Add new defect
    $('#btnDraft').on('click', function() {

        // 1. Defect type required
        const defectType = $('#fd_defectType').val();

        // 1. At least one defect photo required
        if (defectFiles.length === 0) {
            alert('Please add at least one Defect Photo!');
            $('label[for="defect_photo"]').addClass('border-error');
            return;
        }
        // 2.  At least one comparison photos required
        if (compareFiles.length === 0) {
            alert('Please add at least one Comparison Photo!');
            $('label[for="compare_photo"]').addClass('border-error');
            return;
        }

        // Get from hidden inputs or fields on your page
        let pallet     = $('.ipallet').val();
        let result     = $('.resultSelect').val();
        let model      = $('.cs_model').val();
        let type       = $('.cs_type').val();
        let material   = $('.cs_material').val();
        let shift      = $('#hidden_shift').val();

        // ----------- Gather FormData ----------- //
        let formData = new FormData();

        // Defect info
        formData.append('fd_defectType', defectType);
        $('input[name="fd_area[]"]:checked').each(function() {
            formData.append('fd_area[]', $(this).val());
        });

        // Append images
        defectFiles.forEach(file => formData.append('defect_photo[]', file));
        compareFiles.forEach(file => formData.append('compare_photo[]', file));

        // Main info for inspection record
        formData.append('pallet', pallet);
        formData.append('result', result);
        formData.append('model', model);
        formData.append('type', type);
        formData.append('material', material);
        formData.append('shift', shift);

        // AJAX example:
        $.ajax({
            url: 'inspection-rcd-defect-add.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function(response) {

                if (!response.success) {
                    alert('Failed to save!');
                    return;
                }

                //AFTER SAVING NG -> fetch latest pallet from DB
                $.ajax({
                    url: 'get-latest-pallet.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { model, type, material, shift }, // include shift_date if your PHP uses it
                    success: function (res) {

                    const nextPallet = res.latest_pallet ? (parseInt(res.latest_pallet, 10) + 1) : 1;
                    $('.ipallet').val(nextPallet);     // show next pallet
                    $('.resultSelect').val('');        // reset result to "Choose"
                    $('#Add_NG').slideUp();            // hide NG panel

                    // clear previews/arrays so the next NG starts clean
                    defectFiles = [];
                    compareFiles = [];

                    //Reset fields                 
                    $('#fd_defectType').val('').trigger('change'); 
                    $('.areaCheck').removeAttr('checked').prop('checked', false);
                    $('#defect_photo_preview').empty();
                    $('#compare_photo_preview').empty();                    
                    $('.resultSelect').val('').trigger('change');                    

                    // alert('Defect added successfully.');

                    if (response.success) {
                        // SweetAlert2 for success message only
                        Swal.fire({
                            icon: 'success',
                            title: 'Saved!',
                            text: 'Defect added successfully.',
                            timer: 3000,
                            showConfirmButton: false
                        });

                        reloadTable();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: res.msg || 'Failed to add defect.',
                        });
                    }  

                },
                error: function () { alert('Saved, but failed to reload latest pallet.'); }
            });
        },
        error: function () { alert('Error saving NG details.'); }

        });
    });

    </script>
    

</body>
</html>