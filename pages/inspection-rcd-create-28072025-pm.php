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

</head>
<body>

    <style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 10px;
    }
    .gallery-grid .grid-item img {
        width: 100%;
        border-radius: 5px;
    }

    /* checkbox  */
    .area-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);  /* 4 columns per row */
        gap: 0.5rem 2.0rem;  /* row-gap, col-gap: adjust as needed */
        max-width: 100%;
    }
    .area-grid .form-check {
        margin-bottom: 0;
    }

    .area-grid .form-check-label {
        display: flex;
        align-items: center;
        gap: 1.0em; /* Increase or decrease this value for more/less space */
    }

        #fd_defectType + .select2-container {
        width: 300px !important;
    }

    .remove-image {
        background: #fff;
        border-radius: 50%;
        padding: 0 3px;
        border: 1px solid #000;
        line-height: 1;
    }
    
    .input-error, .select-error {
        border: 2px solid #e74c3c !important;  /* Red border */
        background-color: #fff6f6;
    }

    .avatar-list {
        display: flex;
        align-items: center;
        justify-content: flex-start;  /* Forces left alignment */
    }

    .avatar-hover-border {
        border: 4px solid #1c1c1dff;
        box-shadow: 0 0 8px #28a74533;
    }

    .avatar-hover-border:hover {
        border: 5px solid #1b1c1bff;
        box-shadow: 0 0 8px #28a74533;
    }

    .checkbox-error {
        outline: 2px solid #e74c3c;  /* For checkbox group */
    }

    /* table header, body align */
    .inspectionTable_defect tbody tr td:last-child {
        text-align: left; 
    }

    .inspectionTable_defect thead tr th:last-child {
        text-align: left !important; 
    }

    #photoZoomModal .modal-dialog {
        display: flex;
        align-items: center;
        width: auto;
        min-height: 100vh;
        
        margin: 1.75rem auto;
    }

    #photoZoomModal .modal-content {
        background: transparent;
        max-width: 95vw;
        box-shadow: none;
        border: 0;
    }

    #photoZoomModal .modal-body {
        padding: 0;
        text-align: center;
    }

    .dataTables_filter, .dataTables_length {
        display: none !important;
    }

    .inspectionTable tbody tr td:last-child {
        text-align: left !important; 
    }

    .inspectionTable thead tr th:last-child{
         text-align: left !important;
    }


  </style>

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
                        <?=$side_menu2;?>
                    </div>
                </div>
                <div class="row">
					<div class="col-xl-12">
                        <div class="card">
							<div class="card-header border-0 pb-0 flex-wrap">
								<!-- <h4 class="heading mb-0">Literary success</h4> -->
							</div>
							<div class="card-body">
                                
								<div class="row">
                                    <div class="col-xl-3 col-sm-6 mb-2">
                                        <label class="form-label">Model</label>
                                        <select class="form-control select2-filter cs_model" name="fd_model" id="single-select" onChange="getType(this.value)">
                                            <option value="">Select Model</option>
                                            <?php
                                            $sql_model = "SELECT modid, modcode FROM model_details WHERE compcd = '$session_comp' and plant = '$session_plant' and modstatus = 'Y'
                                                            ORDER BY modcode ASC";
                                            $rst_model = mysqli_query($db_con, $sql_model);

                                            while ($row_model = mysqli_fetch_array($rst_model)) {
                                            ?>
                                                <option value="<?php echo $row_model['modid']; ?>" 
                                                    <?= (isset($_GET['fd_model']) && $_GET['fd_model'] == $row_model['modid']) ? "selected" : "" ?>>
                                                    <?php echo $row_model['modcode']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-2">
                                        <label class="form-label">Type</label>
                                        <div id="div_type">
                                            <select class="form-control select2-filter cs_type" name="fd_type" id="fd_type">
                                                <option value="">Select Type</option>                                                    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-2">                                            
                                        <label class="form-label">Material</label>
                                        <div id="div_material">
                                            <select class="form-control select2-filter cs_material" name="fd_material" id="fd_material">
                                                <option value="">Select Material</option>                                                    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 align-self-end mb-2">
                                        <!-- Hidden row id -->
                                        <input type="hidden" id= "hidden_shift" value="<?=$current_shift;?>"/>
                                        <div>
                                            <button class="btn btn-rounded btn-black text-white  me-2" title="Click here to Search" type="button" id="btnFilter">Search</button>
                                        </div>
                                    </div>
                                </div>								
							</div>
						</div>						
					</div>
				</div>

                <!-- Display pictures of material -->
                <div id="imagePreview" style="display: none; margin-top: 20px;">
                    <div class="row">
						<div class="col-xl-12">
							<div class="row">
								<div class="col-8">
									<div class="card">
										<div class="card-header">
											<div class="clearfix">
												<h4 class="card-title mb-0">Image Preview</h4>
											</div>
										</div>
										<div class="card-body">
											<div class="gallery-grid rows-3" id="lightgallery">
                                                <!-- Images will be injected here via AJAX -->
                                            </div>
										</div>
									</div>
								</div>
								<div class="col-4">
									<div class="card">
										<div class="card-header">
											<h4 class="heading mb-0">Material Details</h4>
										</div>
										<div class="card-body">
											<div class="product-detail-content" id="material_product_detail">
                                                <!-- Images Details will be injected here via AJAX -->       
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
									<h6 class="card-title">Add Inspection</h6>
								</div>
								<div class="card-body">
									
                                    <div class="card-header">                           
                                        <h4 class="card-title"></h4>
                                        <button class="btn btn-rounded btn-black mb-3" id="addRowBtn">+ Add Pallete</button>                   
                                    </div>
                                    
                                    <div class="card-body pt-0">
                                        <div class="table-responsive">
                                            <table id="example3" class="display table mb-1 table-striped-thead table-wide table-md table-border-last-0 inspectionTable">
                                                <thead>
                                                    <tr>
                                                        <th>Pallete No</th>
                                                        <th>Result</th>
                                                        <th>Defect</th>
                                                        <th>Send</th>
                                                        <th>Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Rows are rendered via appendRow() -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div> 
                    
                     <!-- NG Detail Modal -->
                    <div class="modal fade bd-example-modal-lg" id="ngModal" tabindex="-1" aria-labelledby="ngModalLabel" >
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" id="ngModalLabel">Defect Details</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">                                        
                                    <div class="row">  

                                        <!-- Hidden inspection row id -->
                                        <input type="hidden" id="ng_ir_id" name="ng_ir_id" value="">

                                        <div class="col-xl-6 col-lg-9 col-md-9">
                                            <!-- <h4 class="d-flex justify-content-between align-items-center mb-3">
                                                <span class="text-dark">Your cart</span>
                                                <span class="badge badge-primary badge-pill">3</span>
                                            </h4> -->
                                            <form id="form1">
                                            <ul class="list-group mb-3">
                                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                    <div>
                                                        <h6 class="my-0 mb-3">Type of Defect</h6>
                                                        <?php
                                                        
                                                        $cstatus = 'Y';

                                                        $query_typeDefc = "SELECT defectid, defectname FROM defect_type WHERE defectstatus = ? ORDER BY defectname ASC";
                                                        $get_typeDefc = $db_con->prepare($query_typeDefc); 
                                                        $get_typeDefc->bind_param("s", $cstatus);
                                                        $get_typeDefc->execute();
                                                        $result_typeDefc = $get_typeDefc->get_result(); 

                                                        ?>
                                                        
                                                        <select class="form-control " name="fd_defectType" id="fd_defectType">
                                                            <option value="">Select Defect</option>
                                                            <?php
                                                            while ($row_alltype_defc = mysqli_fetch_array($result_typeDefc)) {
                                                            ?>
                                                                <option value="<?php echo $row_alltype_defc['defectid']; ?>" 
                                                                    <?= (isset($_GET['fd_defectType']) && $_GET['fd_defectType'] == $row_alltype_defc['defectid']) ? "selected" : "" ?>>
                                                                    <?php echo $row_alltype_defc['defectname']; ?>
                                                                </option>
                                                            <?php } ?>
                                                        </select>                                                  

                                                    </div>                                                
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                                    <div>
                                                        <h6 class="my-0 mb-3">Area of Defect</h6>
                                                        <div class="mb-3 area-grid">
                                                            <?php
                                                            $query = "SELECT areamax FROM defect_area WHERE areaid = 1"; 
                                                            $result = $db_con->query($query);
                                                            $row = $result->fetch_assoc();
                                                            $max = (int)$row['areamax'];
                                                            ?>

                                                            <?php
                                                            for ($i = 1; $i <= $max; $i++) {
                                                                echo '
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input" name="fd_area[]" value="'.$i.'" id="area_'.$i.'">
                                                                    <label class="form-check-label" for="area_'.$i.'">'.$i.'</label>
                                                                </div>
                                                                ';
                                                            }
                                                            ?>                                                           
                                                            
                                                        </div>
                                                    </div>                                       
                                                </li>
                                            </ul> 
                                            </form>                                      
                                        </div>

                                        <!--Tab slider End-->
                                        <div class="col-xl-6 col-lg-3 col-md-3 col-sm-9">
                                            <div class="product-detail-content">
                                                
                                                <!--Defect details-->
                                                <div class="new-arrival-content pr">
                                                    <h4>Defect of Photo</h4>
                                                    
                                                    <div class="cm-content-body publish-content form excerpt">
                                                        <div class="card-body">
                                                            <div class="row">                                                        
                                                                <div class="col-xl-12 col-sm-12">
                                                                    <div class="avatar-upload d-flex flex-column">
                                                                        <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer"></div>
                                                                        <div class="change-btn mt-2">
                                                                            <input type="file" class="form-control d-none" name="defect_photo[]" id="imageUpload" accept=".png, .jpg, .jpeg" multiple>
                                                                            <label for="imageUpload" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                            <small class="text-muted d-block mt-1">You can add more images later. Selected images will appear below.</small>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="d-flex align-items-end flex-wrap mt-4">
                                                        <h4>Comparing Photo (Part NG & OK)</h4>
                                                        
                                                        <div class="cm-content-body publish-content form excerpt">
                                                            <div class="card-body">
                                                                <div class="row">                                                        
                                                                    <div class="col-xl-12 col-sm-12">
                                                                        <div class="avatar-upload d-flex flex-column">
                                                                            <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare"></div>
                                                                            <div class="change-btn mt-2">
                                                                                <input type="file" class="form-control d-none" name="compare_photo[]" id="imageUpload_compare" accept=".png, .jpg, .jpeg" multiple>
                                                                                <label for="imageUpload_compare" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                                <small class="text-muted d-block mt-1">You can add more images later. Selected images will appear below.</small>
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
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light btn-cancel" data-bs-dismiss="modal"><i class="fa fa-times me-2"></i> Cancel</button>
                                    <button type="button" class="btn btn-black" id="btnAddDefect"><i class="fa fa-check me-2"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Image -->
                    <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-labelledby="imageZoomModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                            <div class="modal-body text-center p-0">
                                <img id="zoomedImage" src="" style="max-width:100%;max-height:80vh;object-fit:contain;">
                            </div>
                            </div>
                        </div>
                    </div>	

                    <!-- View Defect Modal -->
                    <div class="modal fade bd-example-modal-lg" id="view_ngModal" tabindex="-1" aria-labelledby="ngModalLabel" >
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" id="ngModalLabel">View Defect</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">                                        
                                    <div class="row"> 
                                        <table class="table header-border table-hover verticle-middle inspectionTable_defect">
                                            <thead class="thead-black">
                                                <tr>
                                                    <th>Pallete No</th>
                                                    <th>Type of Defect</th>
                                                    <th>Area of Defect</th>
                                                    <th>Defect Photo</th>
                                                    <th>Comparing Photo</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Rows are rendered via appendRow() -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Preview Defect Photo form list -->
                    <div class="modal fade" id="photoZoomModal" tabindex="-1" aria-labelledby="photoZoomModalLabel" aria-hidden="true">
                        <div class="modal-dialog" id="photoZoomDialog">
                            <div class="modal-content">
                            <!-- <button type="button" class="btn-close position-absolute top-0 end-0 m-3" data-bs-dismiss="modal" aria-label="Close"></button> -->
                            <div class="modal-body p-0 text-center">
                                <img id="zoomedPhoto" src="" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px; box-shadow:0 2px 24px #0006;">
                            </div>
                            </div>
                        </div>
                    </div> 
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
	
	<!-- Dashboard 1 -->
	<script src="js/dashboard/dashboard-1.js"></script>
	<script src="vendor/draggable/draggable.js"></script>
	<script src="vendor/swiper/js/swiper-bundle.min.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/responsive/responsive.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>

	<script>

    jQuery(document).ready(function(){
        setTimeout(function(){
            dzSettingsOptions.version = 'light';
            new dzSettings(dzSettingsOptions);

            setCookie('version','light');
        },1500)
    });

	</script>

    <script>

    function getType(modelId){
        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    $('#div_type').html(response); 
                } 
            }
        };
        xhr.open("GET", "find-type.php?model_id=" + modelId, true);
        xhr.send();
    }

    function getMaterial(modelId,typeId){
        
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    var response = xhr.responseText;
                    $('#div_material').html(response); 
                } 
            }
        };
        xhr.open("GET", "find-material.php?model_id=" + modelId + "&type_id=" + typeId, true);
        xhr.send();
    }

    </script>
	
    <script>

    let currentPallet = 1;
    let currentShift = '';

    // Fetch shift and saved data on submit
    $('#btnFilter').on('click', function () {

        const model = $('.cs_model').val();
        const type = $('.cs_type').val();
        const material = $('.cs_material').val();
        const currentShift = $('#hidden_shift').val(); //get from hidden input

        if (model && type && material) {
            // fetch image + detail
            $.ajax({
                url: 'inspection-rcd-imgview.php',
                type: 'POST',
                dataType: 'json',
                data: { model, type, material },
                success: function (response) {
                    $('#lightgallery').html(response.gallery_html);
                    $('#material_product_detail').html(response.detail_html);
                    $('#imagePreview').slideDown();

                    if ($('#lightgallery').data('lightGallery')) {
                        $('#lightgallery').data('lightGallery').destroy(true);
                    }
                    $('#lightgallery').lightGallery({ selector: 'a.grid-item', thumbnail: true });

                    // fetch existing inspection data
                    $.ajax({
                        url: 'get-inspection-records.php',
                        method: 'POST',
                        dataType: 'json',
                        data: { model, type, material, shift: currentShift },
                        success: function (res) {
                            $('.inspectionTable tbody').empty();
                            currentPallet = 1;

                            res.forEach(item => {
                                appendRow(item.ir_id, 
                                        item.pallet_no, 
                                        item.result, 
                                        item.status, 
                                        true,
                                        item.has_defect 
                                    ); // already saved
                                currentPallet = Math.max(currentPallet, parseInt(item.pallet_no) + 1);
                            });

                            // add a blank row for new entry
                            appendRow('', currentPallet, '', false);
                        }
                    });
                }
            });
        } else {
            alert('Please select Model, Type, and Material.');
        }
    });

    </script>

    <script>
    
    //Append row
    function appendRow(ir_id, palletNo, result, status, isSaved, hasDefect) {

        // Result select dropdown
        let select = `<select class="default-select form-control resultSelect">
            <option value="">Select</option>
            <option value="OK" ${result === 'OK' ? 'selected' : ''}>OK</option>
            <option value="NG" ${result === 'NG' ? 'selected' : ''}>NG</option>
        </select>`;

        // Defect column
        let defectCol = '';
        if (isSaved && result === 'NG' && status === 'New') {

            defectCol = `<button class="btn btn-rounded btn-primary btn-xxs add_defect" data-irid="${ir_id}"><i class="fa fa-plus"></i></button>`;

            if (hasDefect) {
                defectCol += ` <button class="btn btn-rounded btn-warning btn-xxs view_defect" data-irid="${ir_id}"><i class="fa fa-bars"></i></button>`;
            }

        } else if (isSaved && result === 'NG' && hasDefect) {
            defectCol = `<button class="btn btn-rounded btn-warning btn-xxs view_defect" data-irid="${ir_id}"><i class="fa fa-bars"></i></button>`;
        }

        // Status column
        let statusCol = '';
        
        if (isSaved) {
            let badgeClass = '';
            if (status === 'New') badgeClass = 'badge-outline-primary';
            else if (status === 'Submitted') badgeClass = 'bg-success';
            else if (status === 'Cancelled') badgeClass = 'bg-danger';
            else badgeClass = 'bg-light text-dark';

            statusCol = `<span class="badge badge-rounded ${badgeClass}" style="font-size:0.75rem;">${status || ''}</span>`;
        }

        // Send column
        let sendCol = '';
        
        if (isSaved && result === 'OK' && status === 'New') {
            sendCol = `<button class="btn btn-rounded btn-red btn-xxs submitBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Send for review"><i class="fa-solid fa-paper-plane"></i></button>`;
        }

        if (hasDefect) {
            sendCol = `<button class="btn btn-rounded btn-red btn-xxs submitBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Send for review"><i class="fa-solid fa-paper-plane"></i></button>`;
        }

        if (isSaved && status === 'Submitted') {
            sendCol = `<button class="btn btn-rounded btn-outline-primary btn-xxs cancel_review" data-bs-placement="top" title="Cancel review"><i class="fa fa-times"></i></button>`;
        }

        // Build table row (make sure the order matches the header)
        let tr = `
            <tr data-irid="${ir_id}">
                <td>${palletNo}</td>
                <td>${select}</td>
                <td>${defectCol}</td>
                <td>${sendCol}</td>
                <td>${statusCol}</td>
            </tr>
        `;

        // DataTables API way:
        let table = $('.inspectionTable').DataTable();
        table.row.add([
            palletNo,
            select,
            defectCol,
            sendCol,
            statusCol
        ]).draw(false);

        // run tooltip
        $('[data-bs-toggle="tooltip"]').tooltip();

    }

    </script>
    

    <script>

    // Show modal to add defect
    $(document).on('click', '.add_defect', function() {

        // Reset the form fields
        $('#form1')[0].reset();

        // Also reset custom UI, file arrays, error highlights, and previews
        $('#fd_defectType').removeClass('select-error');
        $('input[name="fd_area[]"]').removeClass('checkbox-error');
        $('#imageUpload').removeClass('input-error').val('');
        $('#imageUpload_compare').removeClass('input-error').val('');
        $('#imagePreviewContainer').empty();
        $('#imagePreviewContainer_compare').empty();
        selectedFiles_defect = [];
        selectedFiles_compare = [];
            
        const row = $(this).closest('tr');
        const irId = $(this).data('irid'); // Read the id from data attribute

        // Set the id in the modal hidden input (as in previous steps)
        $('#ng_ir_id').val(irId);        
        $('#ngModal').data('row', row);

        // Show the modal (Bootstrap 5 way)
        const ngModal = new bootstrap.Modal(document.getElementById('ngModal'));
        ngModal.show();
    });

    </script>

    <script>

    // Add More Row Button - latest pallete from database
    $('#addRowBtn').on('click', function () {

        let table = $('.inspectionTable').DataTable();
        let rows = table.rows().nodes();
        let lastRow = $(rows[rows.length - 1]);
        
        // If no rows exist, allow adding
        if (lastRow.length) {
            // Get the <select> result and data-irid
            let resultSelect = lastRow.find('.resultSelect').val();
            let dataIrid = lastRow.attr('data-irid');
            let statusText = lastRow.find('td').eq(2).text().trim();

            // Validation: if not saved (no irid OR result not selected)
            if ((!dataIrid || dataIrid == '') || !resultSelect) {
                alert('Please complete and save the latest pallet before adding a new one.');
                return false; // prevent adding
            }
        }

        let model = $('.cs_model').val();
        let type = $('.cs_type').val();
        let material = $('.cs_material').val();
        let shift = $('#hidden_shift').val();

        $.ajax({
            url: 'get-latest-pallet.php',
            method: 'POST',
            data: {model, type, material, shift},
            dataType: 'json',
            success: function(response) {
                let latestPalletNo = response.latest || 0;
                let newPalletNo = latestPalletNo + 1;
                appendRow('', newPalletNo, '', '', false);
            }
        });
    });

    // Remove new (unsaved) row on delete icon click
    $(document).on('click', '.deleteRow', function() {
        $(this).closest('tr').remove();
    });

    </script>

    <script>
    
    //Auto save result
    $(document).on('change', '.resultSelect', function() {

        let row = $(this).closest('tr');
        let result = $(this).val();
        let ir_id = row.data('irid'); // If ir_id exists, it's an update; else it's a new insert
        let palletNo = row.find('td').eq(0).text().trim();
        let statusTd = row.find('td').eq(2);

        // Collect other info as needed (model, type, material, shift, etc.)
        let model = $('.cs_model').val();
        let type = $('.cs_type').val();
        let material = $('.cs_material').val();
        let shift = $('#hidden_shift').val();
        let irId = row.data('irid'); // get ir_id from row

        // Optional: show loading indicator or disable row while saving

        $.ajax({
            url: 'inspection-rcd-save.php',
            type: 'POST',
            dataType: 'json',
            data: {
                ir_id: ir_id, // could be blank for new
                pallet_no: palletNo,
                result: result,
                model: model,
                type: type,
                material: material,
                shift: shift
            },
            success: function(response) {
                if (response.success) {

                    alert('Record saved.');

                    // Update ir_id and status if returned from backend
                    if (response.ir_id) {
                        row.attr('data-irid', response.ir_id);
                    }
                    if (response.status) {
                        statusTd.text(response.status);
                    }
                   
                    // Rerender the action cell!
                    let isSaved = !!response.ir_id;
                    let actionTd = row.find('td').eq(3);

                    let actionBtn = '';

                    if (isSaved) {                        
                        
                        if (result === 'OK' && response.status === 'New') {
                            actionBtn = ' <button class="btn btn-rounded btn-red btn-xxs submitBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Send for review"><i class="fa-solid fa-paper-plane"></i></button>';
                        }

                        if (result === 'NG' && response.status === 'New') {
                            actionBtn = ` <button class="btn btn-rounded btn-primary btn-xxs add_defect" data-irid="${ir_id}" data-bs-placement="top" title="Add defect" ><i class="fa fa-plus" aria-hidden="true"></i></button>`;
                            actionBtn = ' <button class="btn btn-rounded btn-red btn-xxs submitBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Send for review"><i class="fa-solid fa-paper-plane"></i></button>';
                        }
            
                    } else {

                        actionBtn = `${(result === 'OK') ? '<button class="btn btn-rounded btn-red btn-xxs submitBtn" data-bs-toggle="tooltip" data-bs-placement="top" title="Send for review"><i class="fa-solid fa-paper-plane"></i></button>' : ''}`;
                    }

                    actionTd.html(actionBtn);

                    // Show the NG modal and pass ir_id to hidden input
                    if (result === 'NG' && response.ir_id) {

                        $('#ng_ir_id').val(response.ir_id);

                        // Show the NG modal
                        const ngModal = new bootstrap.Modal(document.getElementById('ngModal'));
                        ngModal.show();
                    }
                    
                } else {
                    alert('Save failed: ' + response.message);
                }
            },
            error: function() {
                alert('Network or server error.');
            }
        });
    });

    </script>

    <!-- DEFECT PHOTO -->
    <script>

    // --- For Defect Photo ---
    let selectedFiles_defect = [];

    $('#imagePreviewContainer').on('click', '.remove-image', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const idx = $(this).data('idx');
        selectedFiles_defect.splice(idx, 1);
        updatePreview_defect();
    });

    function updatePreview_defect() {
        const previewContainer = $('#imagePreviewContainer');
        previewContainer.html(""); // Clear previews

        selectedFiles_defect.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`
                    <div class="avatar-preview me-2 mb-2 position-relative" style="cursor:pointer;" data-imgsrc="${e.target.result}">
                        <span class="remove-image" data-idx="${idx}" style="position:absolute;top:2px;right:2px;cursor:pointer;font-size:18px;color:#c00;z-index:2;">&times;</span>
                    </div>
                `).css({
                    'background-image': 'url(' + e.target.result + ')',
                    'width': '80px',
                    'height': '80px',
                    'background-size': 'cover',
                    'background-position': 'center',
                    'border-radius': '12px',
                    'border': '1px solid #ddd'
                });
                previewContainer.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    $('#imageUpload').change(function() {
        const newFiles = Array.from(this.files);
        selectedFiles_defect = selectedFiles_defect.concat(newFiles);
        updatePreview_defect();
        $(this).val('');
    });

    $('#imagePreviewContainer').on('click', '.avatar-preview', function(e){
        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');
        // open modal manually
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    // --- For Comparing Photo ---
    let selectedFiles_compare = [];

    $('#imagePreviewContainer_compare').on('click', '.remove-image', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const idx = $(this).data('idx');
        selectedFiles_compare.splice(idx, 1);
        updatePreview_compare();
    });

    function updatePreview_compare() {
        const previewContainer = $('#imagePreviewContainer_compare');
        previewContainer.html(""); // Clear previews

        selectedFiles_compare.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`
                    <div class="avatar-preview me-2 mb-2 position-relative" style="cursor:pointer;" data-imgsrc="${e.target.result}">
                        <span class="remove-image" data-idx="${idx}" style="position:absolute;top:2px;right:2px;cursor:pointer;font-size:18px;color:#c00;z-index:2;">&times;</span>
                    </div>
                `).css({
                    'background-image': 'url(' + e.target.result + ')',
                    'width': '80px',
                    'height': '80px',
                    'background-size': 'cover',
                    'background-position': 'center',
                    'border-radius': '12px',
                    'border': '1px solid #ddd'
                });
                previewContainer.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    $('#imageUpload_compare').change(function() {
        const newFiles = Array.from(this.files);
        selectedFiles_compare = selectedFiles_compare.concat(newFiles);
        updatePreview_compare();
        $(this).val('');
    });

    $('#imagePreviewContainer_compare').on('click', '.avatar-preview', function(e){
        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');
        // open modal manually
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    </script>

    <script>

    // save defect
    $('#btnAddDefect').on('click', function() {
        
        console.log('ng_ir_id:', $('#ng_ir_id').val());
        console.log('fd_defectType:', $('#fd_defectType').val());

        // Gather values
        var defectType = $('#fd_defectType').val();
        var checkedAreas = $('input[name="fd_area[]"]:checked').length;
        var defectPhotos = selectedFiles_defect.length;
        var comparePhotos = selectedFiles_compare.length;
        var irId = $('#ng_ir_id').val();

        var hasError = false;

        // Remove previous error states
        $('#fd_defectType').removeClass('select-error');
        $('input[name="fd_area[]"]').removeClass('checkbox-error');
        $('#imageUpload').removeClass('input-error');
        $('#imageUpload_compare').removeClass('input-error');
        
        // Validation
        if (!defectType) {
            alert('Please select a defect type.');
            $('#fd_defectType').addClass('select-error');
            hasError = true;
            return;
        }
        if (checkedAreas === 0) {
            alert('Please select at least one defect area.');
             $('input[name="fd_area[]"]').first().addClass('checkbox-error');
            hasError = true;
            return;
        }
        if (defectPhotos === 0) {
            alert('Please add at least one defect photo.');
            $('#imageUpload').addClass('input-error');
            hasError = true;
            return;
        }
        if (comparePhotos === 0) {
            alert('Please add at least one comparing photo.');
            $('#imageUpload_compare').addClass('input-error');
            hasError = true;
            return;
        }
        if (!irId) {
            alert('System error: Missing record ID. Please try again.');
            return;
        }

        var formData = new FormData();

        // Collect simple fields
        formData.append('ng_ir_id', $('#ng_ir_id').val());
        formData.append('fd_defectType', $('#fd_defectType').val());

        // Collect checked defect areas (as array)
        $('input[name="fd_area[]"]:checked').each(function(i, obj) {
            formData.append('fd_area[]', $(obj).val());
        });

        // Defect photo files
        for (var i = 0; i < selectedFiles_defect.length; i++) {
            formData.append('defect_photo[]', selectedFiles_defect[i]);
        }

        // Compare photo files
        for (var i = 0; i < selectedFiles_compare.length; i++) {
            formData.append('compare_photo[]', selectedFiles_compare[i]);
        }

        $.ajax({
            url: 'inspection-rcd-defect-save.php',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function() {
                // Show loading if needed
            },
            success: function(res) {

                if (res.success) {
                    // Success: close modal, reload table, show alert, etc.
                    $('#ngModal').modal('hide');
                    alert('Defect details succesfully saved.');

                    let row = $('#ngModal').data('row');
                    if (row) {

                        let ir_id = $('#ng_ir_id').val();
                        let defectTd = row.find('td').eq(2); // Defect column
                        let sendTd = row.find('td').eq(3);   // Send column

                        // Defect column: both buttons
                        let defectBtns = 
                            `<button class="btn btn-rounded btn-primary btn-xxs add_defect" data-irid="${ir_id}" data-bs-placement="top" title="Add defect">
                                <i class="fa fa-plus"></i> 
                            </button>
                            <button class="btn btn-rounded btn-warning btn-xxs view_defect" data-irid="${ir_id}" data-bs-placement="top" title="View defect">
                                <i class="fa fa-bars"></i>
                            </button>`;

                        // Send column: only submit button
                        let sendBtn = 
                            `<button class="btn btn-rounded btn-red btn-xxs submitBtn" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Send for review">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>`;

                        defectTd.html(defectBtns);
                        sendTd.html(sendBtn);

                        $('#ngModal').removeData('row');
                    }

                } else {
                    alert('Error: ' + res.error);
                }
            },
            error: function() {
                alert('AJAX error');
            }
        });
    });

    </script>

    <script>

    // Clear cache data / form fields if cancel
    $('.btn-cancel').on('click', function() {
        // 1. Clear image arrays
        selectedFiles_defect = [];
        selectedFiles_compare = [];
        updatePreview_defect();
        updatePreview_compare();

        // 2. Reset form fields
        // Reset select2
        $('#fd_defectType').val('').trigger('change'); // if using Select2

        // Reset checkboxes
        $('input[type="checkbox"]').prop('checked', false);

        // Reset other inputs as needed
        // e.g., $('input[type="text"]').val('');

        // Optionally, reset <input type="file"> if you want:
        $('#imageUpload').val('');
        $('#imageUpload_compare').val('');
    });

    </script>

    <script>

    // Show modal to view defect
    $(document).on('click', '.view_defect', function() {

        const irId = $(this).data('irid');

        // Set hidden input for reference (optional)
        $('#ng_ir_id').val(irId);

        // Clear previous defect rows
        $('#view_ngModal .inspectionTable_defect tbody').empty();

        // AJAX: fetch defect details by ir_id
        $.ajax({
            url: 'fetch-defect-details.php',
            method: 'POST',
            dataType: 'json',
            data: { ir_id: irId },
            success: function(response) {
            if (response.success && response.data) {
                response.data.forEach(function(defect) {

                    let defectPhotos = defect.defect_photos.length
                       ? `<div class="avatar-list avatar-list-stacked justify-content-start">` +
                            defect.defect_photos.map(function(photo){
                                return `<img src="${photo}" class="avatar avatar-sm rounded-circle avatar-hover-border zoomable-photo" alt="" data-src="${photo}">`;
                            }).join('') +
                        `</div>`
                        : '-';

                    let comparePhotos = defect.compare_photos.length
                        
                        ? `<div class="avatar-list avatar-list-stacked justify-content-start">` +
                            defect.compare_photos.map(function(photo){
                                return `<img src="${photo}" class="avatar avatar-sm rounded-circle avatar-hover-border zoomable-photo" alt="" data-src="${photo}">`;
                            }).join('') +
                        `</div>`
                        : '-';

                    $('#view_ngModal .inspectionTable_defect tbody').append(`
                        <tr>
                            <td>${defect.pallet_no}</td>
                            <td>${defect.defect_type}</td>
                            <td>${defect.defect_area}</td>
                            <td>${defectPhotos}</td>
                            <td>${comparePhotos}</td>
                        </tr>
                    `);
                });

            } else {
                $('#view_ngModal .inspectionTable_defect tbody').html(
                `<tr><td colspan="6" class="text-center">No defect details found.</td></tr>`
                );
            }

            // Show the modal after loading content
            const view_ngModal = new bootstrap.Modal(document.getElementById('view_ngModal'));
            view_ngModal.show();

            // Delegate: when any zoomable-photo is clicked, show it in modal
            $(document).on('click', '.zoomable-photo', function() {
                var src = $(this).data('src');
                $('#zoomedPhoto').attr('src', src);
                var zoomModal = new bootstrap.Modal(document.getElementById('photoZoomModal'));
                zoomModal.show();
            });

        },
            error: function() {
                alert('Failed to fetch defect details.');
            }
        });

    });

    </script>

</body>
</html>