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

    .checkbox-error {
        outline: 2px solid #e74c3c;  /* For checkbox group */
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
                        <?=$side_menu;?>
                    </div>
                </div>
                <div class="row">
					<div class="col-xl-12">
						<div class="filter cm-content-box box-primary">
							<div class="content-title SlideToolHeader">
								<div class="cpa">
									<?=$side_menu2;?>
								</div>
								<div class="tools">
									<a href="javascript:void(0);" class="expand handle"><i class="fal fa-angle-down"></i></a>
								</div>
							</div>
							<div class="cm-content-body form excerpt">
								<div class="card-body">
									<div class="row">
										<div class="col-xl-3 col-sm-6">
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
										<div class="col-xl-3 col-sm-6">
											<label class="form-label">Type</label>
                                            <div id="div_type">
                                                <select class="form-control select2-filter cs_type" name="fd_type" id="fd_type">
                                                    <option value="">Select Type</option>                                                    
                                                </select>
                                            </div>
										</div>
										<div class="col-xl-3 col-sm-6">                                            
                                            <label class="form-label">Material</label>
                                            <div id="div_material">
                                               <select class="form-control select2-filter cs_material" name="fd_material" id="fd_material">
                                                    <option value="">Select Material</option>                                                    
                                                </select>
                                            </div>
										</div>
										<div class="col-xl-3 col-sm-6 align-self-end">
											<div>
												<button class="btn btn-rounded btn-secondary text-black  me-2" title="Click here to Search" type="button" id="btnFilter">Search</button>
											</div>
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
                        <div class="col-lg-12">
                            <div class="card card-comment">
                                <div class="card-body pb-0">
                                    <div class="d-flex justify-content-between mb-2">
                                        <!-- <div class="d-flex align-items-center py-2">
                                            <div class="d-inline-block position-relative">
                                                <img src="images/avatar/avatar2.jpg" alt="" class="rounded avatar avatar-md style-1">
                                            </div>
                                            <div class="clearfix ms-2">
                                                <h6 class="mb-0 fw-semibold">Kennedy</h6>
                                                <span class="fs-13">Yestarday at 5:30 PM</span>
                                            </div>
                                        </div>
                                        <div class="clearfix ms-auto">
                                            <button type="button" class="btn btn-light btn-icon-xxs tp-btn fs-18 align-self-start"><i class="bi bi-grid"></i></button>
                                        </div> -->
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-7 col-lg-6 col-md-6">
                                            <div class="gallery-grid rows-3" id="lightgallery">
                                                <!-- Images will be injected here via AJAX -->
                                            </div>
                                        </div>

                                        <div class="col-xl-5 col-lg-6 col-md-6 col-sm-12">
                                            <div class="product-detail-content" id="material_product_detail">
                                                
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <div>
                <div>

                <!-- Add result -->
                <div class="col-xl-12">
                    <div class="card dz-card" id="accordion-three">
                        <div class="card-header">                           
                            <h4 class="card-title">Add</h4>
                            <button class="btn btn-primary mb-3" id="addRowBtn">+ Add Pallete</button>                   
                        </div>
                        
                        <!-- /tab-content -->	
                        <div class="tab-content" id="myTabContent-2">
                            <div class="tab-pane fade show active" id="withoutSpace" role="tabpanel" aria-labelledby="home-tab-2">
                                <div class="card-body pt-0">
                                    <div class="table-responsive">
                                        <table id="example3" class="display table mb-1 table-striped-thead table-wide table-md table-border-last-0 inspectionTable">
                                            <thead>
                                                <tr>
                                                    <th>Pallete No</th>
                                                    <th class="no-sort">Result</th>
                                                    <th class="no-sort">Status</th>
                                                    <th class="no-sort">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" id= "hidden_shift" value="<?=$current_shift;?>"/>
                            
                        </div>
                        <!-- /tab-content -->	                        
                    </div>
                </div>

                <!-- NG Detail Modal -->
                <div class="modal fade bd-example-modal-lg" id="ngModal" tabindex="-1" aria-labelledby="ngModalLabel" >
                    <div class="modal-dialog  modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-dark text-white">
                                <h5 class="modal-title" id="ngModalLabel">NG Details</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">                                        
                                <div class="row">
                                    
                                    <!-- Hidden row id -->
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
                                                    
                                                    $cstatus = 'AC';

                                                    $query_typeDefc = "SELECT defectid, defectdesc FROM defect_type WHERE defectstatus = ? ORDER BY defectdesc ASC";
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
                                                                <?php echo $row_alltype_defc['defectdesc']; ?>
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

													<!--button-->
													<div class="shopping-cart  mb-1 me-3">
                                                        <button type="button" class="btn btn-secondary btn-cancel" data-bs-dismiss="modal"><i class="fa fa-shopping-basket me-2"></i> Cancel</button>
                                                        <button type="button" class="btn btn-secondary btn-cancel" id="btnSubmitNG"><i class="fa fa-shopping-basket me-2"></i> Submit</button>
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
                                appendRow(item.ir_id, item.pallet_no, item.result, true); // already saved
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

    // Append Row Function
    function appendRow(ir_id, palletNo, result, isSaved) {

        const disabledAttr = ''; // Keep as your logic
        const successClass = isSaved ? 'table-success' : '';

        const showListIcon = result === 'NG'
            ? `<a href="javascript:void(0);" class="btn btn-dark btn-sm content-icon add_defect" data-irid="${ir_id}" data-toggle="tooltip" data-placement="top" title="Add Defect"><i class="fa fa-plus"></i></a>
            <a href="javascript:void(0);" class="btn btn-dark btn-sm content-icon view_defect" data-toggle="tooltip" data-placement="top" title="View Defect"><i class="fa fa-th-list"></i></a>`
            : '';

        // Always generate delete button, but will show only for last row
        const deleteBtn = `<a href="javascript:void(0);" class="btn btn-danger btn-sm deleteRow" data-irid="${ir_id}" data-toggle="tooltip" data-placement="top" title="Delete"><i class="fa fa-times"></i></a>`;

        const row = `
            <tr class="${successClass}" data-irid="${ir_id}">
                <td class="pallet_no">${palletNo}</td>
                <td>
                    <select class="form-control result-select" ${disabledAttr}>
                        <option value="">Choose</option>
                        <option value="OK" ${result === 'OK' ? 'selected' : ''}>OK</option>
                        <option value="NG" ${result === 'NG' ? 'selected' : ''}>NG</option>
                    </select>
                </td>
                <td>
                    ${showListIcon}
                    ${deleteBtn}
                </td>
            </tr>`;
        $('.inspectionTable tbody').append(row);

        showDeleteOnlyOnLatestSavedRow(); // <-- Call after appending
    }

    function showDeleteOnlyOnLatestSavedRow() {
        $('.inspectionTable tbody .deleteRow').hide();

        const $savedRows = $('.inspectionTable tbody tr').filter(function() {
            const irid = $(this).attr('data-irid');
            return irid && irid !== "" && irid !== "0" && irid !== undefined;
        });

        if ($savedRows.length > 0) {
            let $latestRow = $savedRows.first();
            let maxPallet = parseInt($latestRow.find('.pallet_no').text(), 10);

            $savedRows.each(function() {
                const pn = parseInt($(this).find('.pallet_no').text(), 10);
                if (pn > maxPallet) {
                    maxPallet = pn;
                    $latestRow = $(this);
                }
            });

            $latestRow.find('.deleteRow').show();
        }
    }

    // Add More Row Button
    $('#addRowBtn').on('click', function () {
        // appendRow(currentPallet++, '', false);
        appendRow('', currentPallet, '', false);
        currentPallet++; // increment AFTER appending

    });

    // Delete row
    $(document).on('click', '.deleteRow', function () {
        const row = $(this).closest('tr');
        const irId = row.attr('data-irid'); // Use .attr, not .data

        if (!irId || irId === "0") {
            alert('No valid record to delete!');
            return;
        }

        if (confirm('Are you sure you want to delete this record?')) {
            $.ajax({
                url: 'inspection-rcd-delete.php',
                type: 'POST',
                data: { ir_id: irId },
                success: function (res) {
                    row.remove();
                    updatePalletNumbers();
                    showDeleteOnlyOnLatestSavedRow();
                },
                error: function () {
                    alert('Failed to delete the record from the database.');
                }
            });
        }
    });

    function updatePalletNumbers() {
        currentPallet = 1;
        $('.inspectionTable tbody tr').each(function () {
            $(this).find('.pallet_no').text(currentPallet++);
        });
        showDeleteOnlyOnLatestSavedRow();
    }

    // Auto-Save on Result Change
    $(document).on('change', '.result-select:not([disabled])', function () {

        const row = $(this).closest('tr');
        const palletNo = row.find('.pallet_no').text().trim();
        const result = $(this).val();
        const model = $('.cs_model').val();
        const type = $('.cs_type').val();
        const material = $('.cs_material').val();
        const shift = $('#hidden_shift').val();
        const irId = row.data('irid'); // get ir_id from row

        if (!result) return;

        $.ajax({
            url: 'inspection-rcd-save.php',
            method: 'POST',
            data: {
                pallet_no: palletNo,
                result: result,
                model: model,
                type: type,
                material: material,
                shift : shift
            },
            dataType: 'json',
            success: function (res) {
                alert('Record saved.');

                if (res.ir_id) {
                    row.attr('data-irid', res.ir_id);
                }
                console.log('Saved row, irid set:', row.find('.pallet_no').text(), row.attr('data-irid'));

                row.addClass('table-success');
                row.find('.result-select').prop('disabled', true);

                // Now check what pallet numbers have irid
                $('.inspectionTable tbody tr').each(function() {
                    console.log('Row:', $(this).find('.pallet_no').text(), 'irid:', $(this).attr('data-irid'));
                });

                showDeleteOnlyOnLatestSavedRow();

                // Show the NG modal and pass ir_id to hidden input
                if (result === 'NG' && res.ir_id) {
                    $('#ng_ir_id').val(res.ir_id); // <-- SET THE ROW ID HERE

                    // Show the NG modal
                    const ngModal = new bootstrap.Modal(document.getElementById('ngModal'));
                    ngModal.show();
                }

                // Auto redirect to page add defect if result NG
                // if (result === 'NG' && res.ir_id) {
                //     const url = `inspection-rcd-defect-add.php?row_id=${res.ir_id}`;
                //     window.open(url, '_blank');
                // }
            },
            error: function () {
                alert('Failed to save.');
                row.addClass('table-danger');
            }
        });
    });

    $('#ngModal').on('shown.bs.modal', function () {
        $('#fd_defectType').select2({
            dropdownParent: $('#ngModal')
        });
    });

    // When opening modal, set the ir_id!
    function openNgModal(ir_id) {
        $('#ng_ir_id').val(ir_id);
        $('#ngModal').modal('show');
    }

    //update icon if result change
    $(document).on('change', '.result-select', function () {

        const selectedResult = $(this).val();
        const $row = $(this).closest('tr');
        const $iconCell = $row.find('td').eq(2); // Icon column

        // Remove existing .fa-th-list icon if any
        $iconCell.find('.fa-th-list').closest('a').remove();

        // If result is NG, add the icon
        if (selectedResult === 'NG') {
            const listIcon = `
                <a href="javascript:void(0);" class="btn btn-dark btn-sm content-icon" disabled>
                    <i class="fa fa-plus"></i>
                </a>
                <a href="javascript:void(0);" class="btn btn-dark btn-sm content-icon" disabled>
                    <i class="fa fa-th-list"></i>
                </a>
                `;

            // Insert after .fa-plus icon
            const $plusBtn = $iconCell.find('.fa-plus').closest('a');
            if ($plusBtn.length) {
                $plusBtn.after(listIcon);
            } else {
                // fallback: just append if .fa-plus not found
                $iconCell.append(listIcon);
            }

            // Show the NG modal
            // const ngModal = new bootstrap.Modal(document.getElementById('ngModal'));
            // ngModal.show();

            // Redirect to another page
            // const irId = $row.data('irid');
            // if (irId) {
            //     // window.location.href = 'inspection-rcd-defect-add.php?row_id=' + irId;
            //     window.open('inspection-rcd-defect-add.php?row_id=' + irId, '_blank');

            // } else {
            //     // Optionally, alert the user to save the row first
            //     alert('Please save this record first before adding defect details.');
            // }

        }
    });

    // Add defect
    $(document).on('click', '.add_defect', function() {
        const irId = $(this).data('irid'); // Read the id from data attribute

        // Set the id in the modal hidden input (as in previous steps)
        $('#ng_ir_id').val(irId);

        // Show the modal (Bootstrap 5 way)
        const ngModal = new bootstrap.Modal(document.getElementById('ngModal'));
        ngModal.show();
    });

    </script>

    <script>

    function fetchLatestPallet() {

        const model = $('.cs_model').val();
        const type = $('.cs_type').val();
        const material = $('.cs_material').val();
        const shift = $('#hidden_shift').val();

        if (model && type && material) {
            $.ajax({
                url: 'get-latest-pallet.php',
                method: 'POST',
                dataType: 'json',
                data: { model, type, material, shift },
                success: function (res) {
                    if (res && typeof res.latest !== 'undefined') {
                        const nextPallet = res.res.latest + 1;
                        window.currentPallet = nextPallet;
                        window.currentShift = res.current_shift;
                        $('#pallet_info').html('Starting Pallet No: <strong>' + nextPallet + '</strong><br>Current Shift: ' + res.current_shift);
                    }
                }
            });
        }
    }

    </script>

    <script>

    // Select 2 dropdown in modal
    // $('#ngModal').on('shown.bs.modal', function () {
    //     $('.select2-filter').select2({
    //         dropdownParent: $('#ngModal'),
    //         width: '250px'
    //     });
    // });

    </script>

    <!-- Photo -->
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
    // Submit form
    $('#btnSubmitNG').on('click', function() {
        
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
            alert('Please add at least one compare photo.');
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
            formData.append('compare_photo[]', selectedFiles_defect[i]);
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
                    alert('NG details submitted.');
                    // Reload your main inspection table if needed
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

    $('#ngModal').on('shown.bs.modal', function () {
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
    
</body>
</html>