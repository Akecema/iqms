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
        background: #000;
        color : #E4EBE1;
        border-radius: 50%;
        padding: 0 3px;
        border: 1px solid #000;
        line-height: 1;
    }

    .remove-image-defect-old
    {
        background: #000;
        color : #E4EBE1;
        border-radius: 50%;
        padding: 0 3px;
        border: 1px solid #000;
        line-height: 1;
    }

    .remove-image-compare-old
    {
        background: #000;
        color : #E4EBE1;
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

    /* defect photo from list */
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

    /* defect photo in modal add defect */
    #imageZoomModal.modal-dialog {
        display: flex;
        align-items: center;
        width: auto;
        min-height: 100vh;        
        margin: 1.75rem auto;
    }

    #imageZoomModal.modal-content {
        background: transparent;
        max-width: 95vw;
        box-shadow: none;
        border: 0;
    }

    #imageZoomModal.modal-body {
        padding: 0;
        text-align: center;
    }

    .zoomed-img {
        display: block;
        max-width: 60vw;
        max-height: 80vh;
        margin: auto;
        border-radius: 12px;
        box-shadow: 0 2px 24px #0006;
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

    .defect-list {
        border: 1px solid #acafacff;        
        background: rgba(81, 81, 81, 0.1);;              
        border-radius: 12px;
        margin: 16px 24px;
        padding: 20px 18px;
        box-shadow: 0 4px 16px 0 rgba(226,174,110,0.09); 
    }

    /* Make defect-list table transparent inside card */
    .defect-list table {
        background: transparent;
        margin-bottom: 0;
    }

    /* Optional: for mobile/smaller screens */
    @media (max-width: 600px) {
    .defect-list {
        margin: 8px 2px;
        padding: 12px 4px;
    }
    }

    .defect-details-row td {
        background: #faf3e7;
        border-bottom: 2px solid #e5dbc6;
        padding: 16px 24px;
    }
    .defect-list table {
        background: transparent;
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
                                        <input type="hidden" id="hidden_shift" value="<?=$current_shift;?>"/>
                                        <input type="hidden" id="hidden_shift_date" value="<?= $shift_date ?>">

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
                                        <button class="btn btn-rounded btn-black mb-3" id="btnAddRow">+ Add Pallete</button>                   
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display table mb-1 table-striped-thead table-wide table-md inspectionTable">
                                                <thead class="thead-black">
                                                    <tr>
                                                        <th>Pallete No</th>
                                                        <th>Result</th>
                                                        <th>Defect</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
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
                    
                    <!-- NG Detail Modal ADD  -->
                    <div class="modal fade bd-example-modal-lg" id="ngModal" tabindex="-1" aria-labelledby="ngModalLabel" >
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" id="ngModalLabel">Add Defect</h5>
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
                                                    <h4>Defect Photos</h4>
                                                    
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
                                                        <h4>Comparison Photos</h4>
                                                        
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
                                    <button type="button" class="btn btn-light btnCloseModal" data-bs-dismiss="modal"><i class="fa fa-times me-2"></i> Cancel</button>
                                    <button type="button" class="btn btn-black" id="btnAddDefect"><i class="fa fa-check me-2"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Zoom defect photo in modal add -->
                    <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-labelledby="imageZoomModalLabel" aria-hidden="true">
                        <div class="modal-dialog" id="imageZoomModal">
                            <div class="modal-content">
                            <div class="modal-body p-0 text-center">
                                <img id="zoomedImage" src="" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px; box-shadow:0 2px 24px #0006;">
                            </div>
                            </div>
                        </div>
                    </div>	

                    <!-- Edit Defect modal -->
                    <div class="modal fade" id="editDefectModal" tabindex="-1" aria-labelledby="DefectModalLabel">
                        <div class="modal-dialog  modal-lg">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h5 class="modal-title" id="ngModalLabel">Edit Defect</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">                                        
                                    <div class="row">  

                                        <!-- Hidden inspection row id -->
                                        <input type="hidden" id="ng_ir_id" name="ng_ir_id">
                                        <input type="hidden" id="ng_defect_id" name="ng_defect_id">

                                        <div class="col-xl-6 col-lg-9 col-md-9">                                            
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
                                                            
                                                            <select class="form-control " name="fd_defectType_ed" id="fd_defectType_ed">
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
                                                                        <input type="checkbox" class="form-check-input" name="fd_area_ed[]" value="'.$i.'" id="area_ed_'.$i.'">
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
                                                    <h4>Defect Photos</h4>
                                                    
                                                    <div class="cm-content-body publish-content form excerpt">
                                                        <div class="card-body">
                                                            <div class="row">                                                        
                                                                <div class="col-xl-12 col-sm-12">
                                                                    <div class="avatar-upload d-flex flex-column">
                                                                        <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_ed"></div>
                                                                        <div class="change-btn mt-2">
                                                                            <input type="file" class="form-control d-none" name="defect_photo_ed[]" id="imageUpload_ed" accept=".png, .jpg, .jpeg" multiple>
                                                                            <label for="imageUpload_ed" class="btn btn-sm btn-primary light">Add Image(s)</label>
                                                                            <small class="text-muted d-block mt-1">You can add more images later. Selected images will appear below.</small>
                                                                        </div>
                                                                    </div>
                                                                </div>                                                        
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <div class="d-flex align-items-end flex-wrap mt-4">
                                                        <h4>Comparison Photos</h4>
                                                        
                                                        <div class="cm-content-body publish-content form excerpt">
                                                            <div class="card-body">
                                                                <div class="row">                                                        
                                                                    <div class="col-xl-12 col-sm-12">
                                                                        <div class="avatar-upload d-flex flex-column">
                                                                            <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare_ed"></div>
                                                                            <div class="change-btn mt-2">
                                                                                <input type="file" class="form-control d-none" name="compare_photo_ed[]" id="imageUpload_compare_ed" accept=".png, .jpg, .jpeg" multiple>
                                                                                <label for="imageUpload_compare_ed" class="btn btn-sm btn-primary light">Add Image(s)</label>
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
                                    <button type="button" class="btn btn-light btnCloseModal" data-bs-dismiss="modal"><i class="fa fa-times me-2"></i> Cancel</button>
                                    <button type="button" class="btn btn-black" id="btnEditDefect"><i class="fa fa-check me-2"></i> Save Changes</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Zoom Photo from defect list -->
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

                    <!-- Zoom defect photo in modal update -->
                    <div class="modal fade" id="imageZoomModal_ed" tabindex="-1" aria-labelledby="imageZoomModal_edLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                            <div class="modal-body text-center p-0">
                                <img id="zoomedImage_ed" src="" style="max-width:100%;max-height:80vh;object-fit:contain;">
                            </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="imageZoomModal_ed" tabindex="-1" aria-labelledby="imageZoomModal_edLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                            <div class="modal-body text-center p-0">
                                <img id="zoomedImage_ed" src="" style="max-width:100%;max-height:80vh;object-fit:contain;">
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
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>

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
        const shiftDate = $('#hidden_shift_date').val();

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
                        data: { model, type, material, shift: currentShift, shift_date: shiftDate },
                        success: function (res) {

                            console.log(res);
                            // $('.inspectionTable tbody').empty();
                            let table = $('.inspectionTable').DataTable();
                            table.clear().draw(); // Properly clears all rows!      

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
                            appendRow('', currentPallet, '', '', false, false);
                        }
                    });
                }
            });
        } else {
            alert('Please select Model, Type, and Material.');
        }
    });

    </script>

    <?php

    // system status
    $statusMap = [];
    $sql = "SELECT statusid, statusname FROM system_status";
    $res = $db_con->query($sql);

    while($row = $res->fetch_assoc()) {
        $statusMap[$row['statusid']] = $row['statusname'];
    }

    ?>

    <script>
    const statusMap = <?php echo json_encode($statusMap); ?>;
    </script>

    <script>
    
    //Append row
    function appendRow(ir_id, palletNo, result, status, isSaved, hasDefect) {

        // Result select dropdown
        let select = `<select class="default-select form-control resultSelect" ${parseInt(status) === 9 ? 'disabled' : ''}>
                        <option value="">Select</option>
                        <option value="OK" ${result === 'OK' ? 'selected' : ''}>OK</option>
                        <option value="NG" ${result === 'NG' ? 'selected' : ''}>NG</option>
                    </select>`;

        // Defect column
        let defectCol = '';
        if (isSaved && result === 'NG' && parseInt(status) === 1) {

            defectCol = `<button class="btn btn-rounded btn-primary btn-xxs btnAddDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Add defect"><i class="fa fa-plus"></i></button>`;

            if (hasDefect) {
                defectCol += ` <button class="btn btn-rounded btn-warning btn-xxs btnViewDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="View defect"><i class="fa fa-bars"></i></button>`;
            }

        } else if (isSaved && result === 'NG' && hasDefect) {
            defectCol = `<button class="btn btn-rounded btn-warning btn-xxs btnViewDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="View defect"><i class="fa fa-bars"></i></button>`;
        }

        // Hide add defect if status = 9
        if (isSaved && result === 'NG' && hasDefect && parseInt(status) === 9) {
                defectCol = `
                    <button class="btn btn-rounded btn-primary btn-xxs btnAddDefect" 
                            data-irid="${ir_id}" 
                            data-bs-toggle="tooltip" data-bs-placement="top" 
                            title="Add defect" disabled>
                        <i class="fa fa-plus"></i>
                    </button>
                    <button class="btn btn-rounded btn-warning btn-xxs btnViewDefect" 
                            data-irid="${ir_id}" 
                            data-bs-toggle="tooltip" data-bs-placement="top" 
                            title="View defect">
                        <i class="fa fa-bars"></i>
                    </button>
                `;
        }

        // Map of statusid to status text
        // const statusMap = {
        //     1: 'New',
        //     2: 'Draft',
        //     3: 'Submitted',
        //     4: 'Approved',
        //     5: 'Appraised',
        //     6: 'Closed',
        //     7: 'Rejected',
        //     8: 'Cancelled',
        //     9: 'Pending Review',
        //     10: 'Pending Approval'
        // };

        let statusText = statusMap[parseInt(status)]; // status is integer
        
        // Status column
        let statusCol = '';

        if (isSaved) {

            if (parseInt(status) !== 1) { // Hide badge if status is "New"
                
                let badgeClass = '';

                if (parseInt(status) === 8) badgeClass = 'badge-outline-danger';
                else if (parseInt(status) === 9) badgeClass = 'badge-outline-secondary';
                else if (parseInt(status) === 10) badgeClass = 'badge-outline-primary';
                else badgeClass = 'badge-outline-light text-dark';

                statusCol = `<span class="badge badge-rounded ${badgeClass}" style="font-size:0.75rem;">${statusText || ''}</span>`;
            } else {
                statusCol = ''; // Hide for "New"
            }
            
        }
        
        // Send column
        let sendCol = '';

        if (isSaved && parseInt(status) === 9) {
                sendCol = `<button class="btn btn-rounded btn-info btn-xxs btnCancelReview" data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel this inspection record" data-irid="${ir_id}"><i class="fa fa-times"></i></button>`;
        }
        else if (isSaved && result === 'OK' && parseInt(status) === 1) {

            sendCol = `<button class="btn btn-rounded btn-red btn-xxs btnSubmit" data-bs-toggle="tooltip" data-bs-placement="top" title="Submit this inspection record for review" data-irid="${ir_id}"><i class="fa-solid fa-paper-plane"></i></button>`;

        } else if (isSaved && result === 'NG' && hasDefect && parseInt(status) === 1) {

            // If NG and defect has been added, allow submit
            sendCol = `<button class="btn btn-rounded btn-red btn-xxs btnSubmit" data-bs-toggle="tooltip" data-bs-placement="top" title="Submit this inspection record for review" data-irid="${ir_id}"><i class="fa-solid fa-paper-plane"></i></button>`;

        } 

        // Build table row (make sure the order matches the header)
        let tr = `
            <tr data-irid="${ir_id}" data-status="${status}">
                <td>${palletNo}</td>
                <td>${select}</td>
                <td>${defectCol}</td>
                <td>${statusCol}</td>
                <td>${sendCol}</td>
            </tr>
        `;

        // DataTables API way:
        let table = $('.inspectionTable').DataTable();
        let rowNode = table.row.add([
            palletNo,
            select,
            defectCol,
            statusCol,
            sendCol
        ]).draw(false).node();;

        $(rowNode).attr('data-irid', ir_id || '').attr('data-status', status || '');

        // run tooltip
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    </script>
    
    <script>
    
    //Select result OK/NG
    $(document).on('change', '.resultSelect', function() {

        let row = $(this).closest('tr');
        let result = $(this).val();
        let ir_id = row.data('irid'); // If ir_id exists, it's an update; else it's a new insert
        let palletNo = row.find('td').eq(0).text().trim();

        // Collect other info as needed (model, type, material, shift, etc.)
        let model = $('.cs_model').val();
        let type = $('.cs_type').val();
        let material = $('.cs_material').val();
        let shift = $('#hidden_shift').val();

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
                        
                        // Extra: get the DataTables node for this row and update it too
                        let table = $('.inspectionTable').DataTable();
                        let dtRow = table.row(row).node();
                        if (dtRow) $(dtRow).attr('data-irid', response.ir_id);
                    }

                    // Rerender the action cell!
                    let defectTd = row.find('td').eq(2); // Defect column
                    let statusTd = row.find('td').eq(3); // Status column (if you want to use badge)
                    let sendTd = row.find('td').eq(4);   // Send column

                    let defectBtns = '';
                    let sendBtn = '';

                    // If saved and status is New
                    if (response.ir_id && parseInt(response.status) === 1) {
                        
                        if (result === 'OK') {

                            defectBtns = '';
                            sendBtn = `<button class="btn btn-rounded btn-red btn-xxs btnSubmit"
                                                data-bs-toggle="tooltip" data-bs-placement="top" title="Submit this inspection record for review" data-irid="${response.ir_id}">
                                            <i class="fa-solid fa-paper-plane"></i>
                                        </button>`;

                        }  else if (result === 'NG' && response.hasDefect) {
                            
                            // Always show Add Defect button, and after defect save, update to include View Defect if needed
                            updateDefectButtons(response.ir_id, defectTd);
                            sendBtn = '';
                        }
                        else {
                            updateDefectButtons(response.ir_id, defectTd);
                            sendBtn = '';
                        }

                    } else if (parseInt(response.status) === 3) {

                         sendBtn = `<button class="btn btn-rounded btn-red btn-xxs btnSubmit"
                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Submit this inspection record for review" data-irid="${response.ir_id}">
                                        <i class="fa-solid fa-paper-plane"></i>
                                    </button>`;
                    }

                    // If not NG, update defect column normally
                    if (result !== 'NG') {
                        defectTd.html(defectBtns);
                    }
                    sendTd.html(sendBtn);

                    // // Map of statusid to status text
                    // const statusMap = {
                    //     1: 'New',
                    //     2: 'Draft',
                    //     3: 'Submitted',
                    //     4: 'Approved',
                    //     5: 'Appraised',
                    //     6: 'Closed',
                    //     7: 'Rejected',
                    //     8: 'Cancelled',
                    //     9: 'Pending Review',
                    //     10: 'Pending Approval'
                    // };

                    let statusText = statusMap[response.status]; // status is integer

                    // Optional: show status as badge
                    if (parseInt(response.status) !== 1) { // Hide badge if status is "New"
                
                        let badgeClass = '';

                        if (parseInt(status) === 8) badgeClass = 'badge-outline-danger';
                        else if (parseInt(status) === 9) badgeClass = 'badge-outline-secondary';
                        else if (parseInt(status) === 10) badgeClass = 'badge-outline-primary';
                        else badgeClass = 'badge-outline-light text-dark';

                        statusTd.html(`<span class="badge badge-rounded ${badgeClass}" style="font-size:0.75rem;">${statusText || ''}</span>`);

                    } else {
                        statusTd.html(''); // No badge for "New"
                    }

                    // run tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Show the NG modal and pass ir_id to hidden input
                    if (result === 'NG' && response.ir_id) {

                        $('#ng_ir_id').val(response.ir_id);
                        $('#ngModal').data('row', row);
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

    <script>

    // Show modal to add defect
    $(document).on('click', '.btnAddDefect', function() {

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
    $('#btnAddRow').on('click', function () {

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
    //  ADD DEFECT PHOTO 
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
                        <span class="remove-image" data-idx="${idx}" style="position:absolute;top:2px;right:2px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                    </div>
                `).css({
                    'background-image': 'url(' + e.target.result + ')',
                    'width': '80px',
                    'height': '80px',
                    'background-size': 'cover',
                    'background-position': 'center',
                    'border-radius': '12px',
                    'border': '1px solid #ddd',
                    'cursor': 'pointer'
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
                        <span class="remove-image" data-idx="${idx}" style="position:absolute;top:2px;right:2px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                    </div>
                `).css({
                    'background-image': 'url(' + e.target.result + ')',
                    'width': '80px',
                    'height': '80px',
                    'background-size': 'cover',
                    'background-position': 'center',
                    'border-radius': '12px',
                    'border': '1px solid #ddd',
                    'cursor': 'pointer'
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

    // Add new defect
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
                    alert('Defect added successfully.');

                    let row = $('#ngModal').data('row');
                    if (row) {

                        let ir_id = $('#ng_ir_id').val();
                        let defectTd = row.find('td').eq(2); // Defect column
                        let sendTd = row.find('td').eq(4);   // Send column

                        // Defect column: both buttons
                        let defectBtns = 
                            `<button class="btn btn-rounded btn-primary btn-xxs btnAddDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Add defect">
                                <i class="fa fa-plus"></i> 
                            </button>
                            <button class="btn btn-rounded btn-warning btn-xxs btnViewDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="View defect">
                                <i class="fa fa-bars"></i>
                            </button>`;

                        // Send column: only submit button
                        let sendBtn = 
                            `<button class="btn btn-rounded btn-red btn-xxs btnSubmit" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Submit this inspection record for review" data-irid="${ir_id}">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>`;

                        defectTd.html(defectBtns);
                        sendTd.html(sendBtn);

                        // --- Auto-refresh defect details list if row is expanded ---
                        if (row && row.next().hasClass('defect-details-row')) {

                            let colspan = row.children('td').length;
                            row.next().find('td').html('<div class="text-center">Refreshing defect list...</div>');
                            
                            let status = row.data('status');

                            $.ajax({
                                url: 'fetch-defect-list.php',
                                type: 'POST',
                                data: { ir_id: irId, status: status }, // send status if needed
                                success: function(html) {

                                    row.next().find('td').html(html);

                                    // zoom photo in defect list
                                    $(document).on('click', '.zoomable-photo', function() {
                                        var src = $(this).data('src');
                                        $('#zoomedPhoto').attr('src', src);
                                        var zoomModal = new bootstrap.Modal(document.getElementById('photoZoomModal'));
                                        zoomModal.show();
                                    });
                                },
                                error: function() {
                                    row.next().find('td').html('<div class="text-danger">Failed to load defect details.</div>');
                                }
                            });
                        }

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

    // Table list of defect
    $(document).on('click', '.btnViewDefect', function() {

        let btn = $(this);
        let row = btn.closest('tr');
        let irId = btn.data('irid');
        let status = row.attr('data-status');
        if (!status) status = 1; // fallback to 1 if undefined/null/empty

        // Collapse if already expanded
        if (row.next().hasClass('defect-details-row')) {
            row.next().remove();
            btn.removeClass('expanded');
            return;
        }

        // Remove any existing open rows first (optional)
        $('.defect-details-row').remove();
        $('.btnViewDefect').removeClass('expanded');

        // Show loading state
        btn.addClass('expanded');
        let colspan = row.children('td').length;
        let loadingRow = $(`<tr class="defect-details-row"><td colspan="${colspan}" class="text-center">Loading defect details...</td></tr>`);
        row.after(loadingRow);
        
    
        // AJAX to get defect list
        $.ajax({
            url: 'fetch-defect-list.php',
            type: 'POST',
            data: { ir_id: irId, status: status }, // send status if needed
            success: function(html) {
                row.next().find('td').html(html);

                // zoom photo in defect list
                $(document).on('click', '.zoomable-photo', function() {
                    var src = $(this).data('src');
                    $('#zoomedPhoto').attr('src', src);
                    var zoomModal = new bootstrap.Modal(document.getElementById('photoZoomModal'));
                    zoomModal.show();
                });
            },
            error: function() {
                row.next().find('td').html('<div class="text-danger">Failed to load defect details.</div>');
            }
        });
    });

    </script>
 
    <script>
    
    // Update defect buttons based on whether there are any defects once result are select
    function updateDefectButtons(ir_id, defectTd) {

        $.ajax({
            url: 'get-defect-status.php',
            type: 'POST',
            dataType: 'json',
            data: { ir_id: ir_id },
            success: function(resp) {
                let btnHtml = `<button class="btn btn-rounded btn-primary btn-xxs btnAddDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Add defect">
                                <i class="fa fa-plus"></i>
                            </button>`;
                if (resp.has_defect) {
                    btnHtml += ` <button class="btn btn-rounded btn-warning btn-xxs btnViewDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="View defect">
                                    <i class="fa fa-bars"></i>
                                </button>`;
                }
                defectTd.html(btnHtml);
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
    }

    </script>

    <script>

    // PHOTO
    let existing_defect_photos = []; // [{id, url}]
    let selectedFiles_defect_ed = [];

    let existing_compare_photos = []; // [{id, url}]
    let selectedFiles_compare_ed = [];

    // For delete tracking
    let deleted_defect_photo_ids = [];
    let deleted_compare_photo_ids = [];

    $(document).on('click', '.edit-defect', function() {

        let defectId = $(this).data('defectid');
        let irId = $(this).data('irid');

        // Set the hidden field values!
        $('#ng_ir_id').val(irId);
        $('#ng_defect_id').val(defectId);

        $.ajax({
            url: 'fetch-single-defect.php',
            type: 'POST',
            dataType: 'json',
            data: { defect_id: defectId, ir_id: irId },
            success: function(res) {

                console.log('Defect type from backend:', res.data.defect_type);
                console.log('Compare images from backend:', res.data.compare_photos);
                if(res.success){

                    $('#fd_defectType_ed').val(res.data.defect_type).trigger('change');;
                    $('input[name="fd_area_ed[]"]').prop('checked', false);

                    (res.data.area || []).forEach(function(area){
                        $('input[name="fd_area_ed[]"][value="'+area+'"]').prop('checked',true);
                    });

                    //defect & comparison photos
                    existing_defect_photos = res.data.defect_photos || [];
                    existing_compare_photos = res.data.compare_photos || [];

                    updatePreview_defect_ed(true);
                    updatePreview_compare_ed(true);

                    var m = new bootstrap.Modal(document.getElementById('editDefectModal'));
                    m.show();

                } else {
                    alert(res.msg || 'Not found');
                }
            }
        });
    }); 

    // Show all current (existing) and new images
    function updatePreview_defect_ed() {

        const c = $('#imagePreviewContainer_ed');
        c.empty();

        // Existing (from DB)
        existing_defect_photos.forEach((img, idx) => {

            const imgId = img.def_photoid;
            const imgUrl = encodeURI(img.url);

            const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative" data-exist="1" data-idx="${idx}" data-imgsrc="${imgUrl}" data-imgid="${imgId}">
                                <span class="remove-image-defect-old" style="position:absolute;top:2px;right:2px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                            </div>`).css({
                                'background-image': 'url(' + imgUrl + ')',
                                'width': '80px',
                                'height': '80px',
                                'background-size': 'cover',
                                'background-position': 'center',
                                'border-radius': '12px',
                                'border':'1px solid #ddd',
                                'cursor': 'pointer'
                            });
            c.append(imgDiv);
        });

        // New files (not yet uploaded)
        selectedFiles_defect_ed.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative"
                    data-exist="0" data-idx="${idx}" data-imgsrc="${e.target.result}">
                    <span class="remove-image" style="position:absolute;top:2px;right:2px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                </div>`).css({
                    'background-image': `url(${e.target.result})`,
                    'width': '80px', 
                    'height': '80px', 
                    'background-size': 'cover',
                    'background-position': 'center', 
                    'border-radius': '12px', 
                    'border':'1px solid #ddd',
                    'cursor': 'pointer'
                });
                c.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    //zoom images
    $('#imagePreviewContainer_ed').on('click', '.avatar-preview', function(e){

        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');

        // open modal manually
        $('#zoomedImage_ed').attr('src', imgSrc);
        $('#imageZoomModal_ed').modal('show');

    });

    // Add new image(s)
    $('#imageUpload_ed').on('change', function() {
        for (let i = 0; i < this.files.length; i++) {
            selectedFiles_defect_ed.push(this.files[i]);
        }
        updatePreview_defect_ed();
        $(this).val(""); // Reset file input
    });

    // Remove image (either from DB or not-yet-uploaded)
    $('#imagePreviewContainer_ed').on('click', '.remove-image', function(e) {

        e.preventDefault(); e.stopPropagation();
        const $img = $(this).parent();
        const idx = $img.data('idx');

        if ($img.data('exist') == 1) {
            // Existing: mark for deletion (do not remove from DB yet)
            let photoId = $img.data('photoid');
            deleted_defect_photo_ids.push(photoId);
            existing_defect_photos.splice(idx, 1);
        } else {
            // New: remove from array
            selectedFiles_defect_ed.splice(idx, 1);
        }
        
        updatePreview_defect_ed();
    });

    //remove old image gallery & database
    $('#imagePreviewContainer_ed').on('click', '.remove-image-defect-old', function(e) {
        
        e.stopPropagation();
        const imgDiv = $(this).closest('.avatar-preview');
        const imgId = imgDiv.data('imgid'); // the unique DB ID

        if (!imgId) {
            alert('No image ID found!');
            return;
        }

        if (!confirm('Remove this image?')) return;

        console.log("Deleting image with ID:", imgId);

        // AJAX to PHP to remove from DB and folder
        $.ajax({
            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            data: { id: imgId, phototype: 'defect', action : 'delete_photo'},
            dataType: 'json',
            success: function(res) {

                // 1. Remove from existing_defect_photos array
                const idxToRemove = existing_defect_photos.findIndex(img => img.def_photoid == imgId);
                if (idxToRemove > -1) {
                    existing_defect_photos.splice(idxToRemove, 1);
                }

                //2. old image
                if (res.success) {
                    imgDiv.remove(); // remove from UI
                } else {
                    alert('Failed to delete image: ' + res.error);
                }

                //3. reload table
                reloadDefectTable($('#ng_ir_id').val(), 1);
                
            },
            error: function() {
                alert('Server error. Try again.');
            }
        });

    });

    //COMPARISON PHOTOS
    function updatePreview_compare_ed(isEdit = false) {

        const c = $('#imagePreviewContainer_compare_ed');
        c.empty();

        // Existing (from DB)
        existing_compare_photos.forEach((img, idx) => {

            const imgId = img.compare_photoid;
            const imgUrl = encodeURI(img.url);

            const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative" data-exist="1" data-idx="${idx}" data-imgsrc="${imgUrl}" data-imgid="${imgId}">
                                <span class="remove-image-compare-old" style="position:absolute;top:2px;right:2px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                            </div>`).css({
                                'background-image': 'url(' + imgUrl + ')',
                                'width': '80px',
                                'height': '80px',
                                'background-size': 'cover',
                                'background-position': 'center',
                                'border-radius': '12px',
                                'border':'1px solid #ddd',
                                'cursor': 'pointer'
            });
            c.append(imgDiv);
        });

        // New files (not yet uploaded)
        selectedFiles_compare_ed.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative"
                    data-exist="0" data-idx="${idx}" data-imgsrc="${e.target.result}">
                    <span class="remove-image" style="position:absolute;top:2px;right:2px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                </div>`).css({
                    'background-image': `url(${e.target.result})`,
                    'width': '80px', 
                    'height': '80px', 
                    'background-size': 'cover',
                    'background-position': 'center', 
                    'border-radius': '12px', 
                    'border':'1px solid #ddd',
                    'cursor': 'pointer'
                });
                c.append(imgDiv);
            };
            reader.readAsDataURL(file);
        });
    }

    //zoom images
    $('#imagePreviewContainer_compare_ed').on('click', '.avatar-preview', function(e){

        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');
        // open modal manually
        $('#zoomedImage_ed').attr('src', imgSrc);
        $('#imageZoomModal_ed').modal('show');

    });

    $('#imageUpload_compare_ed').on('change', function() {

        // this.files is a FileList
        for (let i = 0; i < this.files.length; i++) {
            selectedFiles_compare_ed.push(this.files[i]);
        }
        updatePreview_compare_ed();
        $(this).val(""); 
        
    });
    
    //remove defect image before upload
    $('#imagePreviewContainer_compare_ed').on('click', '.remove-image', function(e) {
        
        e.preventDefault(); e.stopPropagation();
        const $img = $(this).parent();
        const idx = $img.data('idx');
        if ($img.data('exist') == 1) {
            let photoId = $img.data('photoid');
            deleted_compare_photo_ids.push(photoId); 
            existing_compare_photos.splice(idx, 1);
        } else {
            selectedFiles_compare_ed.splice(idx, 1);
        }

        updatePreview_compare_ed(true);
    });

    //remove old image gallery & database
    $('#imagePreviewContainer_compare_ed').on('click', '.remove-image-compare-old', function(e) {
        
        e.stopPropagation();
        const imgDiv = $(this).closest('.avatar-preview');
        const imgId = imgDiv.data('imgid'); // the unique DB ID

        if (!imgId) {
            alert('No image ID found!');
            return;
        }

        if (!confirm('Remove this image?')) return;

        console.log("Deleting image with ID:", imgId);

        // AJAX to PHP to remove from DB and folder
        $.ajax({
            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            data: { id: imgId, phototype: 'compare', action : 'delete_photo'},
            dataType: 'json',
            success: function(res) {

                // 1. Remove from existing_defect_photos array
                const idxToRemove = existing_compare_photos.findIndex(img => img.compare_photoid == imgId);
                if (idxToRemove > -1) {
                    existing_compare_photos.splice(idxToRemove, 1);
                }

                //2. old image
                if (res.success) {
                    imgDiv.remove(); // remove from UI
                } else {
                    alert('Failed to delete image: ' + res.error);
                }
 
                //reload table
                reloadDefectTable($('#ng_ir_id').val(), 1);

            },
            error: function() {
                alert('Server error. Try again.');
            }
        });

    });

    </script>

    <script>

    $('#btnEditDefect').on('click', function(e) {

        e.preventDefault();

        // Gather values
        var defectType = $('#fd_defectType_ed').val();
        var checkedAreas = $('input[name="fd_area_ed[]"]:checked').length;
        var defectPhotos = selectedFiles_defect_ed.length;
        var comparePhotos = selectedFiles_compare_ed.length;
        var irId = $('#ng_ir_id').val();

        var totalDefectPhotos = (existing_defect_photos?.length || 0) + (selectedFiles_defect_ed?.length || 0);
        var totalComparePhotos = (existing_compare_photos?.length || 0) + (selectedFiles_compare_ed?.length || 0);

        var hasError = false;

        // Remove previous error states
        $('#fd_defectType_ed').removeClass('select-error');
        $('input[name="fd_area_ed[]"]').removeClass('checkbox-error');
        $('#imageUpload_ed').removeClass('input-error');
        $('#imageUpload_compare_ed').removeClass('input-error');
        
        // Validation
        if (!defectType) {
            alert('Please select a defect type.');
            $('#fd_defectType_ed').addClass('select-error');
            hasError = true;
            return;
        }
        if (checkedAreas === 0) {
            alert('Please select at least one defect area.');
            $('input[name="fd_area_ed[]"]').first().addClass('checkbox-error');
            hasError = true;
            return;
        }
        if (totalDefectPhotos === 0) {
            alert('Please add at least one defect photo.');
            $('#imageUpload_ed').addClass('input-error');
            hasError = true;
            return;
        }
        if (comparePhotos === 0) {
            alert('Please add at least one comparing photo.');
            $('#imageUpload_compare_ed').addClass('input-error');
            hasError = true;
            return;
        }
        if (!irId) {
            alert('System error: Missing record ID. Please try again.');
            return;
        }
        
        let formData = new FormData();

        formData.append('action', 'update_defect');
        formData.append('ir_id', $('#ng_ir_id').val());
        formData.append('defect_id', $('#ng_defect_id').val());
        formData.append('defect_type', $('#fd_defectType_ed').val());        
        
        let areas = [];
        $('input[name="fd_area_ed[]"]:checked').each(function() {
            areas.push($(this).val());
        });

        formData.append('area', areas.join(','));
        formData.append('deleted_defect_photo_ids', JSON.stringify(deleted_defect_photo_ids));
        formData.append('deleted_compare_photo_ids', JSON.stringify(deleted_compare_photo_ids));

        // Add new images - defect
        for (let i = 0; i < selectedFiles_defect_ed.length; i++) {
            formData.append('defect_photo_ed[]', selectedFiles_defect_ed[i]);
        }

        // Add new images - compare
        for (let i = 0; i < selectedFiles_compare_ed.length; i++) {
            formData.append('compare_photo_ed[]', selectedFiles_compare_ed[i]);
        }

        $.ajax({

            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {
                if (res.success) {

                    alert('Your changes have been saved.');
                    $('#editDefectModal').modal('hide');

                    //reload table
                    reloadDefectTable($('#ng_ir_id').val(), 1);

                    // Reset arrays for next time
                    selectedFiles_defect_ed = [];
                    deleted_defect_photo_ids = [];
                    selectedFiles_compare_ed = [];
                    deleted_compare_photo_ids = [];

                } else {
                    alert(res.msg || 'Update failed!');
                }
            }
        });
    });

    // reload the table
    function reloadDefectTable(ir_id, status) {

        $.ajax({
            url: 'fetch-defect-list.php',
            type: 'POST',
            data: { ir_id: ir_id, status: status },
            success: function(html) {
                $('#defectTableContainer').html(html);
            }
        });
    }

    </script>

    <script>

    // Clear cache data / form fields if cancel
    $('.btnCloseModal').on('click', function() {

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

    //submit for review
    $(document).on('click', '.btnSubmit', function(e) {
        
        e.preventDefault();

        let $btn = $(this);
        let ir_id = $btn.data('irid');

        // Use browser confirm for confirmation
        if (!confirm('Are you sure you want to submit this inspection record for review?')) {
            return; // Stop if user cancels
        }

        let formData = new FormData();
        formData.append('action', 'submit_for_review');
        formData.append('ir_id', ir_id);

        $.ajax({
            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(res) {

                if (res.success) {
                    // SweetAlert2 for success message only
                    Swal.fire({
                        icon: 'success',
                        title: 'Submitted!',
                        text: 'Your inspection record was submitted for review.',
                        timer: 3000,
                        showConfirmButton: false
                    });

                    setTimeout(function() {
                        $('#btnFilter').trigger('click');
                    }, 300); // 300ms delay

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

    </script>

    <script>

    //Cancelled inspection
    $(document).on('click', '.btnCancelReview', function() {
        let ir_id = $(this).data('irid');
        if (!confirm('Cancel this inspection record?')) return;

        $.ajax({
            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            data: { action: 'cancel_review', ir_id: ir_id },
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Cancelled',
                        text: 'Record has been cancelled.',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    $('#btnFilter').trigger('click'); // Reload table
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to cancel.' });
                }
            }
        });
    });

    </script>

</body>
</html>