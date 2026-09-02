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
        margin: 16px 0;
        padding: 16px; 
        border-radius: 12px;
    }
    .area-grid .form-check {
        margin-bottom: 0;
    }

    .area-grid .form-check-label {
        display: flex;
        align-items: center;
        gap: 1.0em; /* Increase or decrease this value for more/less space */
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

    
    #fd_defectType + .select2-container {
        width: 250px !important;
    }

    .avatar-preview {
        position: relative;
        display: inline-block;
    }
    
    .remove-image-btn {
        position: absolute;
        top: -15px;
        right: -15px;
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: #181818;
        color: #fff;
        font-size: 18px;
        line-height: 24px;
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

    .border-error {
        border: 2px solid #BD062F !important;   
        background-color: #FAF7F9 !important;
        color : #2D2E2D;   
    }

    .border-error:hover {
        color: #181818 !important;  
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

                <!-- Preview material, iszpection details -->
                <div id="detailsPreview" style="display: none; margin-top: 20px;">
                    <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                        <div class="accordion-item">
                        <h2 class="accordion-header accordion-header-primary" id="headingOne6">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6">
                        <span class="accordion-header-icon"></span>
                            <span class="accordion-header-text">Inspection Details</span>
                        </button>
                        </h2>
                    </div>

                    <div id="collapseOne6" class="accordion__body collapse show" aria-labelledby="accord-6One" data-bs-parent="#accordion-six">
                        <div class="accordion-body-text p-0">
                            <div class="card h-auto">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="product-detail-content" id="material_product_detail">
                                            <!-- Images Details will be injected here via AJAX -->       
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Preview images -->
                <div id="imagePreview" style="display: none; margin-top: 20px;">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-xl-4">
                                    <div class="gallery-grid rows-3" id="lightgallery">
                                        <!-- Images will be injected here via AJAX -->
                                    </div>
                                </div>

                                <!-- Pallete inspection -->
                                <div class="col-xl-8 col-lg-12">                                
                                    <!-- <div class="mb-2">
                                        <h5><a href="javascript:void(0)" class="text-black">Inspection</a></h5>                                   
                                    </div>	                                -->
                                    <div class="card">                                            
                                        <div class="card-body"> 
                                            <div class="profile-tab">
                                                <div class="custom-tab-1">
                                                    <!-- <h4 class="card-title">Inspection</h4> -->
                                                    <ul class="nav nav-tabs">
                                                        <li class="nav-item"><a href="#add-pallet" data-bs-toggle="tab" class="nav-link active show">Add</a>
                                                        </li>
                                                        <li class="nav-item"><a href="#view-pallet" data-bs-toggle="tab" class="nav-link">View</a>
                                                        </li>
                                                    </ul>
                                                    <div class="tab-content">

                                                        <!-- Add inspection -->
                                                        <div id="add-pallet" class="tab-pane fade active show">
   
                                                            <div class="my-post-content pt-3 mb-4">                                                                   
                                                            
                                                                <!-- <div class="card-header border-0 flex-wrap">
                                                                    <h4 class="heading mb-0"></h4>
                                                                    <div>
                                                                        <button class="btn btn-primary btn-sm mb-3" id="addRowBtn">+ Add Pallete</button> 
                                                                    </div>
                                                                </div> -->

                                                                <form>
                                                                    <div class="row mt-4">
                                                                        <div class="mb-3 col-md-2">
                                                                            <label class="form-label">Pallet</label>
                                                                            <input type="text" class="form-control ipallet" disabled>
                                                                        </div>
                                                                        <div class="mb-3 col-md-4">
                                                                            <label class="form-label">Result</label>
                                                                            <select class="form-control result-select resultSelect">
                                                                                <option value="" selected="">Choose</option>
                                                                                <option value="OK">OK</option>
                                                                                <option value="NG">NG</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </form> 

                                                                <!-- Add NG details -->
                                                                <div id="Add_NG" style="display:none; margin-top :20px;">
                                 
                                                                    <h5 class="my-0 mb-3">Defect Details</h5>
                                                                    
                                                                    <form id="ngDetailsForm" enctype="multipart/form-data">
                                                                        <div class="row">  
                                                                            <div class="col-xl-6 col-lg-9 col-md-9">
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
                                                                                            
                                                                                            <select class="form-control select-type" name="fd_defectType" id="fd_defectType">
                                                                                                <option value="">Select Defect</option>
                                                                                                <?php
                                                                                                while ($row_alltype_defc = mysqli_fetch_array($result_typeDefc)) {
                                                                                                
                                                                                                    echo '<option value="'.$row_alltype_defc['defectid'].'">'.$row_alltype_defc['defectname'].'</option>';
                                                                                                } ?>
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
                                                                                                                 
                                                                            </div>

                                                                            <!--Tab slider End-->
                                                                            
                                                                                <div class="col-xl-6 col-lg-9 col-md-3">
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

                                                                                                            <!-- Display images  -->                                                                                                         
                                                                                                            <div id="defect_photo_preview" class="d-flex flex-wrap mt-2"></div> 
                                                                                                            <div class="change-btn mt-2">
                                                                                                                <input type="file" class="form-control d-none addDefect" name="defect_photo[]" id="defect_photo" accept="image/*" multiple>
                                                                                                                <label for="defect_photo" class="btn btn-sm btn-primary light">Add Image(s)</label>
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
                                                                                                                
                                                                                                                <!-- Display images  -->
                                                                                                                <div id="compare_photo_preview" class="d-flex flex-wrap mt-2"></div>
                                                                                                                <div class="change-btn mt-2">
                                                                                                                    <input type="file" class="form-control d-none addCompare" name="compare_photo[]" id="compare_photo" accept="image/*" multiple>
                                                                                                                    <label for="compare_photo" class="btn btn-sm btn-primary light">Add Image(s)</label>
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

                                                                        <div class=" border-top text-end py-3">
                                                                            <button type="button" id="btnAddDefect" class="btn btn-black mt-2">Save</button>
                                                                        </div>

                                                                    </form> 

                                                                    <!-- Modal for image zoom -->
                                                                    <div class="modal fade" id="imgZoomModal" tabindex="-1" aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered">
                                                                            <div class="modal-content" style="background: transparent; border: none;">
                                                                                <img src="" id="zoomedImg" class="img-fluid rounded shadow" style="max-width: 90vw; max-height: 90vh;">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>                                                                                                                        
                                                        </div>

                                                        <!-- View inspection -->
                                                        <div id="view-pallet" class="tab-pane fade">
                                                            <div class="pt-3">
                                                                <div class="settings-form mb-4">
                                                                    <!-- <h4 class="text-primary">Account Setting</h4> -->
                                                                    <div class="table-responsive">
                                                                        <table id="palletTable" class="display table mb-1 table-striped-thead table-wide table-md inspectionTable">
                                                                            <thead class="thead-black">
                                                                                <tr>
                                                                                    <th>Pallet No</th>
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
                                                                                                            <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_modal"></div>
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
                                                                                                                <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare_modal"></div>
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
                                                                        <button type="button" class="btn btn-black" id="btnAddDefectModal"><i class="fa fa-check me-2"></i> Save</button>
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

    //to apply select style to non select2
    $('.result-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });

    $('.select-type').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });


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
                    $('#detailsPreview').slideDown();
                    $('#imagePreview').slideDown();

                    if ($('#lightgallery').data('lightGallery')) {
                        $('#lightgallery').data('lightGallery').destroy(true);
                    }

                    $('#lightgallery').lightGallery({ selector: 'a.grid-item', thumbnail: true });

                    // fetch latest pallete
                    $.ajax({
                        url: 'get-latest-pallet.php',
                        type: 'POST',
                        dataType: 'json',
                        data: {
                            model: model,
                            type: type,
                            material: material,
                            shift: currentShift
                        },
                        success: function(response) {
                            // If no previous record, start from 1
                            let nextPallet = response.latest_pallet ? (parseInt(response.latest_pallet) + 1) : 1;
                            $('.ipallet').val(nextPallet);
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

    // Auto save result
    $(document).on('change', '.resultSelect', function() {

        let $select = $(this);
        let result   = $(this).val();
        let model    = $('.cs_model').val();
        let type     = $('.cs_type').val();
        let material = $('.cs_material').val();
        let shift    = $('#hidden_shift').val();
        let pallet   = $('.ipallet').val(); 

        // Show NG details if "NG" is selected, hide otherwise
        if (result === 'NG') {
            $('#Add_NG').slideDown();
            return;
        } else {
            $('#Add_NG').slideUp();
        }

        // If OK, auto-save and increment pallet
        if (result === 'OK') {

            $select.prop('disabled', true);

            $.ajax({
                url: 'inspection-rcd-save.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    model: model,
                    type: type,
                    material: material,
                    shift: shift,
                    pallet: pallet,
                    result: result
                },
                success: function(response) {

                    alert('Record saved.');

                    if (response.success) {
                        $.ajax({
                            url: 'get-latest-pallet.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {model: model, type: type, material: material, shift: shift},
                            success: function(res) {
                                let latestPallet = res.latest_pallet ? (parseInt(res.latest_pallet) + 1) : 1;
                                $('.ipallet').val(latestPallet);
                                $select.val('');
                            }
                        });
                    } else {
                        alert('Failed to save record!');
                    }
                },
                complete: function() {
                    $select.prop('disabled', false);
                }
            });
        }

    });

    </script>

    <script>

    // Arrays to hold files
    let defectFiles = [];
    let compareFiles = [];

    function updatePreview(filesArray, previewId) {
        const preview = document.getElementById(previewId);
        preview.innerHTML = '';
        filesArray.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = "position-relative me-2 mb-2";
                div.style.width = "80px";
                div.style.height = "80px";
                div.style.backgroundImage = `url('${e.target.result}')`;
                div.style.backgroundSize = "cover";
                div.style.backgroundPosition = "center";
                div.style.borderRadius = "8px";
                div.style.border = "1px solid #ddd";
                div.style.cursor = "pointer";
                div.setAttribute('data-idx', idx);

                // Zoom
                div.onclick = function() {
                    document.getElementById('zoomedImg').src = e.target.result;
                    $('#imgZoomModal').modal('show');
                }

                // Remove
                const removeBtn = document.createElement('span');
                removeBtn.className = 'remove-image-btn';
                removeBtn.innerHTML = '&times;';
                removeBtn.title = "Remove";
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

    // Defect Photos
    document.getElementById('defect_photo').addEventListener('change', function() {
        for(let file of this.files) {
            defectFiles.push(file);
        }
        updatePreview(defectFiles, 'defect_photo_preview');
        this.value = '';
    });

    // Comparison Photos
    document.getElementById('compare_photo').addEventListener('change', function() {
        for(let file of this.files) {
            compareFiles.push(file);
        }
        updatePreview(compareFiles, 'compare_photo_preview');
        this.value = '';
    });

    </script>

    <script>

    // Remove old error border first (optional)
    $('#fd_defectType').removeClass('border-error');
    $('input[name="fd_area[]"]').closest('.area-grid').removeClass('border-error');
    $('#defect_photo').removeClass('border-error');
    $('#compare_photo').removeClass('border-error');

    // Remove border when user fixes the input
    $('#fd_defectType').on('change', function() {
        // $(this).removeClass('border-error');
        $(this).next('.select2').find('.select2-selection').removeClass('border-error');
    }); 
    
    // Remove border when user fixes the input
    $('input[name="fd_area[]"]').on('change', function() {
        if ($('input[name="fd_area[]"]:checked').length > 0) {
            $('.area-grid').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#defect_photo').on('change', function() {
        if (defectFiles.length > 0) {
            $('label[for="defect_photo"]').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#compare_photo').on('change', function() {
        if (compareFiles.length > 0) {
            $('label[for="compare_photo"]').removeClass('border-error');
        }
    });

    // Submit with all files
    $('#btnAddDefect').on('click', function() {

        // 1. Defect type required
        const defectType = $('#fd_defectType').val();
        if (!defectType) {
            alert('Please select Type of Defect!');
            // $('#fd_defectType').addClass('border-error').focus();
            $('.select-type').next('.select2').find('.select2-selection').addClass('border-error');
            return false;
        }

        // 2. At least one area required
        if ($('input[name="fd_area[]"]:checked').length === 0) {
            alert('Please select at least one Area of Defect!');
            $('.area-grid').addClass('border-error');
            return;
        }

        // 3. At least one defect photo required
        if (defectFiles.length === 0) {
            alert('Please add at least one Defect Photo!');
            $('label[for="defect_photo"]').addClass('border-error');
            return;
        }
        // 4.  At least one comparison photos required
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
            url: 'inspection-rcd-save.php',
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
                    $('#defect_photo_preview').empty();
                    $('#compare_photo_preview').empty();

                    alert('Defect saved!');

                },
                error: function () { alert('Saved, but failed to reload latest pallet.'); }
            });
        },
        error: function () { alert('Error saving NG details.'); }

        });
    });

    </script>

    <script>

    function loadPalletTable() {

        const model    = $('.cs_model').val();
        const type     = $('.cs_type').val();
        const material = $('.cs_material').val();
        const shift    = $('#hidden_shift').val();

        if (!model || !type || !material || !shift) {
            $('#palletTable tbody').html('<tr><td colspan="5" class="text-muted">Select model/type/material first.</td></tr>');
            return;
        }

        $.ajax({
            
            url: 'inspection-rcd-list.php',
            type: 'POST',
            dataType: 'json',
            data: { model, type, material, shift },
            success: function(res){
                const rows = res.rows || [];
                if (!rows.length) {
                    $('#palletTable tbody').html('<tr><td colspan="5" class="text-muted">No records yet.</td></tr>');
                    return;
                }
                let html = '';
                rows.forEach(r => {

                    const hasDefect = r.defect_count > 0;
                    const resultTxt = r.ir_result ? r.ir_result : '';
                    const defectCell = (r.ir_result === 'NG')
                    ? `<button class="btn btn-rounded btn-primary btn-xxs AddDefectModal" data-irid="${r.ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Add defect"><i class="fa fa-plus"></i></button>
                        <button class="btn btn-rounded btn-warning btn-xxs ViewDefect" data-irid="${r.ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="View defect"><i class="fa fa-bars"></i></button>`
                    : '';

                    const actionCell = (!r.ir_result || r.ir_result === 'OK')
                    ? `<button class="btn btn-rounded btn-red btn-xxs btnSubmit" data-bs-toggle="tooltip" data-bs-placement="top" title="Submit this inspection record for review" data-irid="${r.ir_id}"><i class="fa-solid fa-paper-plane"></i></button>`
                    : '';

                    html += `
                    <tr data-ir="${r.ir_id || ''}">
                        <td>${r.ir_pallet_no}</td>
                        <td>${resultTxt || '<span class="text-muted">-</span>'}</td>
                        <td>${defectCell || (hasDefect ? hasDefect : '<span class="text-muted">-</span>')}</td>
                        <td>${r.ir_status_text || ''}</td>
                        <td>${actionCell || '<span class="text-muted">-</span>'}</td>
                    </tr>`;
                });

                $('#palletTable tbody').html(html);
      
                // run tooltip
                $('[data-bs-toggle="tooltip"]').tooltip();

            },

            error: function(xhr){
            console.error(xhr.responseText);
            $('#palletTable tbody').html('<tr><td colspan="5" class="text-danger">Failed to load table.</td></tr>');

            }
        });
  
    }

    // Hook into your existing flows:
    $('#btnFilter').on('click', function(){
    // ...your existing image/details ajax...
    loadPalletTable();
    });

    </script>

    <script>

    // SINGLE source of truth arrays
    const defectFiles = [];
    const compareFiles = [];

    // delegate so it works even if HTML is added later
    $(document).on('change', '#imageUpload', function () {

        addFilesAndRender(this.files, defectFiles, '#imagePreviewContainer_modal');
        this.value = '';
    });

    $(document).on('change', '#imageUpload_compare', function () {
        addFilesAndRender(this.files, compareFiles, '#imagePreviewContainer_compare_modal');
        this.value = '';
    });

    function addFilesAndRender(fileList, targetArray, previewSel){
        const picked = Array.from(fileList);
        console.log('picked files:', picked.length, picked.map(f => f.name));
        targetArray.push(...picked);
        renderPreview(targetArray, previewSel);
    }

    function renderPreview(filesArray, previewSel){
        
        const $preview = $(previewSel).empty();
        console.log('rendering preview to', previewSel, 'count=', filesArray.length);

        filesArray.forEach((file, idx) => {
            const url = URL.createObjectURL(file); // simpler than FileReader

            const $wrap = $(`
            <div class="position-relative me-2 mb-2"
                style="width:84px;height:84px;border:1px solid #ddd;border-radius:8px;overflow:hidden;cursor:pointer;">
                <img src="${url}" style="width:100%;height:100%;object-fit:cover;">
                <span class="remove-image-btn" title="Remove">&times;</span>
            </div>
            `);

            // FIXED: proper negative values
            $wrap.find('.remove-image-btn').css({
            position:'absolute', top:'-10px', right:'-10px', width:'28px', height:'28px',
            borderRadius:'50%', background:'#000', color:'#fff', lineHeight:'28px',
            textAlign:'center', fontWeight:'bold', border:'2px solid #fff', zIndex:10
            }).on('click', (ev) => {
            ev.stopPropagation();
            filesArray.splice(idx, 1);
            renderPreview(filesArray, previewSel);
            // release URL for removed thumb
            URL.revokeObjectURL(url);
            });

            $wrap.on('click', () => {
            $('#zoomedImg').attr('src', url);
            $('#imgZoomModal').modal('show');
            });

            // release URL when image finishes loading (optional)
            $wrap.find('img').on('load', () => URL.revokeObjectURL(url));

            $preview.append($wrap);
        });
    }

    function resetNgModal(){

        $('#ng_ir_id').val('');
        $('#fd_defectType').val('').trigger('change');
        $('input[name="fd_area[]"]').prop('checked', false);

        // clear without changing references
        defectFiles.length = 0;
        compareFiles.length = 0;

        $('#imagePreviewContainer_modal, #imagePreviewContainer_compare_modal').empty();
        $('label[for="imageUpload"], label[for="imageUpload_compare"]').removeClass('border-error');

    }

    </script>

    <script>

    // open NG modal from the table button
    $(document).on('click', '.AddDefectModal', function (e) {

        e.preventDefault();

        const irId = $(this).data('irid') || '';
        const $tr = $(this).closest('tr');
        const palletNo = $tr.find('td').eq(0).text().trim();

        // optional: clear the modal fields if you have a reset function
        if (typeof resetNgModal === 'function') resetNgModal();

        $('#ng_ir_id').val(irId);
        $('#ngModalLabel').text(`Add Defect — Pallet ${palletNo || ''}`);

        // Bootstrap 5 programmatic open
        const ngModal = new bootstrap.Modal(document.getElementById('ngModal'));
        ngModal.show();

    });

   $(document).on('click', '#btnAddDefectModal', function(e){

    e.preventDefault();

    // --- Validate modal fields ---
    const defectType = $('#fd_defectType').val();
    if(!defectType){
        alert('Please select Type of Defect!');
        $('#fd_defectType').focus();
        return;
    }
    const areasChecked = $('input[name="fd_area[]"]:checked');
    if(areasChecked.length === 0){
        alert('Please select at least one Area of Defect!');
        return;
    }
    if(defectFiles.length === 0){
        alert('Please add at least one Defect Photo!');
        return;
    }
    if(compareFiles.length === 0){
        alert('Please add at least one Comparison Photo!');
        return;
    }

    // --- Gather context (same as your filter area) ---
    const pallet   = $('.ipallet').val();
    const model    = $('.cs_model').val();
    const type     = $('.cs_type').val();
    const material = $('.cs_material').val();
    const shift    = $('#hidden_shift').val();
    const irId     = $('#ng_ir_id').val(); // can be empty (new IR)

    // --- Build FormData ---
    const fd = new FormData();       // so PHP can branch
    fd.append('result', 'NG');
    fd.append('pallet', pallet);
    fd.append('model', model);
    fd.append('type', type);
    fd.append('material', material);
    fd.append('shift', shift);
    if (irId) fd.append('ir_id', irId);

    fd.append('fd_defectType', defectType);
    areasChecked.each(function(){ fd.append('fd_area[]', $(this).val()); });
    defectFiles.forEach(f => fd.append('defect_photo[]', f));
    compareFiles.forEach(f => fd.append('compare_photo[]', f));

    // --- AJAX save ---
    $.ajax({
        url: 'inspection-rcd-save.php',
        type: 'POST',
        data: fd,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res){
        if(!res || !res.success){
            alert(res?.message || 'Save failed.');
            return;
        }

        // Close modal
        const inst = bootstrap.Modal.getInstance(document.getElementById('ngModal'));
        if (inst) inst.hide();

        // Get next pallet, clear UI, reload table
        $.ajax({
            url: 'get-latest-pallet.php',
            type: 'POST',
            dataType: 'json',
            data: { model, type, material, shift },
            success: function(r2){
            const nextPallet = r2.latest_pallet ? (parseInt(r2.latest_pallet, 10) + 1) : 1;
            $('.ipallet').val(nextPallet);
            $('.resultSelect').val('');
            resetNgModal();
            loadPalletTable(); // your existing function
            alert('Defect saved modal!');
            },
            error: function(){ alert('Saved, but failed to fetch latest pallet.'); }
        });
        },
        error: function(xhr){
        console.error(xhr.responseText);
        alert('Server error while saving.');
        }
    });
    });

    // Optional: clear modal on hide
    $('#ngModal').on('hidden.bs.modal', resetNgModal);

    </script>


</body>
</html>