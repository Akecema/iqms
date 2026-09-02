<!-- System title -->
<?php include "../system-header.php";?>

<!-- Session start -->
<?php include "session-start.php"; ?> 
<?php include "get-financial-year.php"; ?>

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

    <!-- Pick date -->
    <link rel="stylesheet" href="vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="vendor/pickadate/themes/default.date.css">
    
    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
    <link href="css/badge.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
    <link href="css/image.css" rel="stylesheet">
    <link href="css/material-gallery.css" rel="stylesheet">

</head>
<body>

    <style>
    .gallery-container {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }
    .main-gallery-item {
        width: 100%;
        height: 300px;
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid #eee;
    }
    .main-gallery-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }
    .main-gallery-item:hover img {
        transform: scale(1.05);
    }
    .gallery-thumbs {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
    }
    .thumb-item {
        height: 100px;
        overflow: hidden;
        border-radius: 10px;
        position: relative;
        border: 1px solid #eee;
    }
    .thumb-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .more-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 600;
        pointer-events: none; /* Let clicks pass to the <a> tag */
    }

    /* checkbox  */
    /* Modern Grid Layout */
    .area-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 8px 12px;
        margin-top: 10px;
    }

    /* Each number box */
    .area-box {
        display: flex;
        align-items: center;
        padding: 6px 10px;
        background: #f8f9fa;
        border: 1px solid #e6e6e6;
        border-radius: 6px;
        cursor: pointer;
        user-select: none;
        transition: all 0.2s ease-in-out;
        font-size: 14px;
        justify-content: center;
    }

    /* Hide default checkbox */
    .area-box input[type="checkbox"] {
        display: none;
    }

    /* Hover effect */
    .area-box:hover {
        background: #6c6d6dff;
        border-color: #4a4b4bff;
        color : #fff;
    }

    /* Selected state */
    .area-box input:checked + span {
        background: #515453ff;
        color: white;
        padding: 4px 10px;
        border-radius: 4px;
    }

    @media (min-width: 768px) {
        .col-md-6 {
            max-width: 50% !important;
        }
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
        border: 1px solid #e74c3c !important;  /* Red border */
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
        border: 1px solid #F2F5F0;        
        /* background: rgba(81, 81, 81, 0.1);             */
        border-radius: 2px;
        margin: 16px 0;
        padding: 20px 10px;
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
        background: transparent;
        border-bottom: 2px solid #e5dbc6;
        padding: 16px 24px;
    }
    .defect-list table {
        background: transparent;
    }

    /* Reduce padding for table cells */
    .defect-list table td
    {
        padding-left: 8px;
        padding-right: 8px;
        font-size : 12px;
    }
    .defect-list table th {
        padding-left: 8px;
        padding-right: 8px;
        font-size : 12px;
        font-weight :600;
    }

    /* First column (#) even smaller */
    .defect-list table td:first-child,
    .defect-list table th:first-child {
        padding-left: 4px;
        width: 40px; /* optional fixed width for # column */
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
        border: 1px solid #eb2020ff !important;   
        background-color: #FAF7F9 !important;
        color : #2D2E2D;   
    }

    .border-error:hover {
        color: #181818 !important;  
    }

    .swal-wide {
        width: 600px !important;
    }

    .swal-title-sm {
        font-size: 14px !important;   /* Or use 16px / 20px based on your needs */
    }

    .swal-font-sm {
        font-size: 12px !important;
    }

    .modal-header {
        border-bottom: none !important;
    }

    /* Details Preview Modern Styles */
    .details-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        /* background: #fff; */
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        overflow: hidden;
        margin-bottom: 20px;
    }
    
    .details-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .details-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        padding: 15px 20px;
        border-bottom: 1px solid rgba(0,0,0,0.04);
        display: flex;
        align-items: center;
    }

    .details-title {
        font-size: 12px;
        font-weight: 600;
        color: #2c3e50;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .details-title i {
        color: #910a0dff; /* Primary accent color */
        font-size: 16px;
        background: rgba(107, 97, 97, 0.1);
        padding: 8px;
        border-radius: 8px;
    }

    .details-body {
        padding: 20px;
    }

    /* Styling for injected content */
    #material_product_detail {
        font-size: 12px;
    }
    
    #material_product_detail p, 
    #material_product_detail div.detail-row {
        margin-bottom: 12px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #eee;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #666;
    }

    #material_product_detail strong, 
    #material_product_detail b,
    #material_product_detail span.val {
        color: #222;
        font-weight: 600;
        /* text-align: right; */
    }
    
    #material_product_detail p:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    /* Gallery tweaks */
    #lightgallery a {
        display: block;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        transition: all 0.3s;
        margin-bottom: 10px;
    }
    
    #lightgallery a:hover {
        transform: scale(1.03);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    #lightgallery img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 8px;
    }

    /* Row container */
    .defect-row td {
        padding: 0;
        border: none;
    }

    /* Card look */
    .defect-card {
        background: #ffffff;
        border-radius: 14px;
        padding: 14px 18px;
        margin-bottom: 12px;
        box-shadow: 0 8px 22px rgba(0,0,0,.06);
    }

    /* Header */
    .defect-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }

    .defect-title {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .defect-index {
        font-weight: 600;
        color: #6b7280;
    }

    .defect-name {
        font-size: 15px;
        font-weight: 600;
        color: #111827;
    }

    /* Body */
    .defect-body {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 12px;
    }

    .defect-photo-block label {
        font-size: 12px;
        color: #6b7280;
        margin-bottom: 6px;
        display: block;
    }

    /* Actions */
    .defect-actions {
        display: flex;
        justify-content: flex-end;
        gap: 8px;
    }

    .camera-btn {
        display: inline-block;
        padding: 5px 12px;
        background: #d9e6d8;
        color: #434242;
        border-radius: 0.25rem;
        border: 1px solid #cedfcc;
        cursor: pointer;
        line-height: 18px;
    }
    .camera-btn:hover {
        background: #085209;
        color : white;
    }

    /* Hide for Desktop and iPad (768px and up) */
    @media (min-width: 768px) {
        .camera-btn {
            display: none !important;
        }
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

                <!-- Searching -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card"> 
                            <div class="card-body">
                                <div class="row mb-4">
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
                                        <label class="form-label">Part No</label>
                                        <div id="div_material">
                                            <select class="form-control select2-filter cs_material" name="fd_material" id="fd_material">
                                                <option value="">Select Part no</option>                                                    
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 align-self-end mb-2">
                                        <!-- Hidden row id -->
                                        <input type="hidden" id="hidden_shift" value="<?=$current_shift;?>"/>
                                        <input type="hidden" id="hidden_shift_date" value="<?= $shift_date ?>">
                                        <input type="hidden" id="hidden_financialyr" value="<?= $financialyr ?>">

                                        <div>
                                            <button class="btn btn-rounded btn-black text-white me-2" title="Click here to Search" type="button" id="btnFilter">Search</button>
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- end Searching -->

                <!-- Display image -->
                <div class="row" id="detailsPreview" style="display: none;">
                    <div class="col-xxl-12">
                        <div class="card">                            
                            <div class="card-body">  
                                <div class="row">  
                                    <div class="col-xl-9 col-lg-9 col-md-12">
                                        <div class="alert alert-outline-light outline-dashed p-3 mb-0">
                                            <!-- <h5 class="card-title details-title mb-3"><i class="fa fa-images"></i>Images</h5> -->
                                            <div id="lightgallery"></div>
                                        </div>                                            
                                    </div>
                                    <div class="col-xl-3 col-lg-3 col-md-9">
                                        <div class="alert alert-outline-light outline-dashed p-3 mb-0">
                                            <!-- <h5 class="card-title details-title mb-3"><i class="fa fa-tasks"></i>Finished Goods Details</h5> -->
                                            <div id="material_product_detail"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Display image -->
                
                <!-- Add & View records -->
                <div class="row" id="inspectionView" style="display: none;">
                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-header border-0 pb-0 flex-wrap mb-4  ai-tabs-1 py-2">
                                <ul class="nav nav-tabs mb-3">
                                    <li class="nav-item"><a href="#add-pallet" data-bs-toggle="tab" class="nav-link active show"><i class="fa fa-plus-circle" aria-hidden="true"></i><span class="p-1"> Add </span></a></li>
                                    <li class="nav-item"><a href="#view-pallet" data-bs-toggle="tab" class="nav-link"><i class="fa fa-list" aria-hidden="true"></i> <span class="p-1"> Records</span></a></li>
                                </ul>
                            </div>
                            <div class="card-body">    
                                <div class="tab-content">
                                    <!-- Add inspection -->
                                    <div id="add-pallet" class="tab-pane fade active show">
                                        <form id="add_inspection_form">
                                            <div class="row mt-2">
                                                <div class="mb-3 col-md-3">
                                                    <label class="form-label">Pallet Sequence</label>
                                                    <input type="text" class="form-control ipallet" disabled>
                                                </div>
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Result</label>
                                                    <select class="form-control result-select resultSelect">
                                                        <option value="">Choose</option>
                                                        <option value="OK">OK</option>
                                                        <option value="NG">NG</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form> 

                                        <div id="Add_NG" style="display:none; margin-top:20px;">
        
                                            <div class="card">                                            
                                                <div class="card-body ai-tabs-1 py-2"> 
                                                    <h5 class="my-0 mb-3 mt-3">Defect Details</h5>
                                                                
                                                    <form id="ngDetailsForm" enctype="multipart/form-data">

                                                        <div class="row g-4 mt-2">

                                                        <!-- LEFT -->
                                                        <div class="col-md-6">
                                                            <!-- ALL LEFT CONTENT HERE -->
                                                                <div class="s2w-section">
                                                                <h6 class="section-title">
                                                                    <i class="fa fa-tools"></i> Type of Defect
                                                                </h6>
                                                                
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

                                                            <div class="s2w-section">
                                                            <h6 class="section-title">
                                                                <i class="fa fa-wrench"></i> Area of Defect
                                                            </h6>

                                                            <div class="area-grid">
                                                                <?php
                                                                $query = "SELECT areamax FROM defect_area WHERE areaid = 1"; 
                                                                $result = $db_con->query($query);
                                                                $row = $result->fetch_assoc();
                                                                $max = (int)$row['areamax'];
                                                            
                                                                for ($i = 1; $i <= $max; $i++) {
                                                                    echo '
                                                                    <label class="area-box">
                                                                        <input type="checkbox" class="areaCheck" name="fd_area[]" value="'.$i.'" id="area_'.$i.'">
                                                                        <span>'.$i.'</span>
                                                                    </label>
                                                                    ';
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                            
                                                        </div>

                                                        <!-- RIGHT -->
                                                        <div class="col-md-6">
                                                            <!-- ALL RIGHT CONTENT HERE -->
                                                            <div class="s2w-section">
                                                                <h6 class="section-title">
                                                                    <i class="fa fa-image"></i> Defect Photos
                                                                </h6>

                                                                <div class="cm-content-body publish-content form excerpt">
                                                                    <div class="card-body">
                                                                        <div class="row">                                                        
                                                                            <div class="col-xl-12 col-sm-12">
                                                                                <div class="avatar-upload d-flex flex-column">
                                                                                    <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer"></div>

                                                                                        <!-- Display images  -->                                                                                                         
                                                                                        <div id="defect_photo_preview" class="photo-box d-flex flex-wrap mt-2"></div> 
                                                                                        <div class="change-btn mt-2">
                                                                                            <input type="file" class="form-control d-none addDefect" name="defect_photo[]" id="defect_photo" accept="image/*" multiple>
                                                                                            <label for="defect_photo" class="btn btn-sm btn-primary light">
                                                                                                <i class="fa fa-upload me-1"></i> Add Image 
                                                                                            </label>
                                                                                            <!-- <small class="text-muted d-block mt-1">Use ctrl key to select multiple images.</small> -->
                                                                                            <label class="btn btn-sm camera-btn">
                                                                                                <i class="fa fa-camera" aria-hidden="true"></i> Take Photo
                                                                                                <input type="file" id="defect_camera" name="defect_camera[]" accept="image/*" capture="environment" multiple hidden>
                                                                                            </label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>                                                        
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="s2w-section">
                                                                    <h6 class="section-title">
                                                                        <i class="fa fa-image"></i> Comparison Photos
                                                                    </h6>
                                                                    <div class="cm-content-body publish-content form excerpt">
                                                                        <div class="card-body">
                                                                            <div class="row">                                                        
                                                                                <div class="col-xl-12 col-sm-12">
                                                                                    <div class="avatar-upload d-flex flex-column">
                                                                                        <div class="avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare"></div>  
                                                                                        
                                                                                        <!-- Display images  -->
                                                                                        <div id="compare_photo_preview" class="photo-box d-flex flex-wrap mt-2"></div>
                                                                                        <div class="change-btn mt-2">
                                                                                            <input type="file" class="form-control d-none addCompare" name="compare_photo[]" id="compare_photo" accept="image/*" multiple>
                                                                                            <label for="compare_photo" class="btn btn-sm btn-primary light">
                                                                                                <i class="fa fa-upload me-1"></i> Add Image </label>
                                                                                            <label class="btn btn-sm camera-btn">
                                                                                                <i class="fa fa-camera" aria-hidden="true"></i> Take Photo
                                                                                                <input type="file" id="compare_camera" name="compare_camera[]" accept="image/*" capture="environment" multiple hidden>
                                                                                            </label>
                                                                                            <!-- <small class="text-muted d-block mt-1">Use ctrl key to select multiple images.</small> -->
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

                                                    </div>

                                                    </form> 
                                                </div>                                    
                                        </div>
                                    </div>
                                
                                    <!-- View record -->
                                    <div id="view-pallet" class="tab-pane fade">      
                                
                                        <div class="row mb-3 align-items-end">
                                            <div class="col-md-4">
                                                <select class="form-control status-filter" name="statusFilter" id="statusFilter">
                                                    <option value="">Filter by Status</option>
                                                    <?php
                                                    $query_status = "SELECT statusid, statusname FROM system_status WHERE inspection = 'Y' ORDER BY statusmaps ASC";
                                                    $res_status = mysqli_query($db_con, $query_status);
                                                    while($row_status = mysqli_fetch_assoc($res_status)) {
                                                        echo '<option value="'.$row_status['statusid'].'">'.$row_status['statusname'].'</option>';
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>      

                                        <div class="table-responsive">
                                            <table id="example3" class="display table table-sm mb-1 table-striped-thead inspectionTable" style="width:100%">
                                                <thead class="thead-black">
                                                    <tr class="align-middle">
                                                        <th class="nosort text-center"><input type="checkbox" id="checkAll" class="form-check-input"></th>
                                                        <th>Pallet<br>Sequence</th>
                                                        <th>Document<br>No</th>
                                                        <th class='nosort'>Result</th>
                                                        <th>Production<br>Date</th>
                                                        <th>Status</th>
                                                        <th class='nosort'>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Rows are rendered via appendRow() -->
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="mt-4">
                                            <button id="btnSubmitSelected" class="btn btn-black me-1" disabled>Submit Selected</button>
                                            <button id="btnCancelSelected" class="btn btn-black" disabled>Cancel Selected</button> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end View records -->

                <!-- Modal for image zoom -->
                <div class="modal fade" id="imgZoomModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background: transparent; border: none;">
                            <img src="" id="zoomedImg" class="img-fluid rounded shadow" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
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
                
                <!-- Offcanvas for Defect List -->
                <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDefect" aria-labelledby="offcanvasDefectLabel" style="width: 500px;">
                    <div class="offcanvas-header bg-primary text-white">
                        <h5 class="offcanvas-title ng-title" id="offcanvasDefectLabel">Defect List</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body" id="offcanvasDefectBody">
                        <div id="offcanvasDefectContent">
                            <!-- Content loaded via AJAX -->
                        </div>
                    </div>
                </div>

                <!-- NG Detail Modal ADD  -->
                <div class="modal fade bd-example-modal-lg" id="ngModal" tabindex="-1" aria-labelledby="ngModalLabel" >
                    <div class="modal-dialog  modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title ng-title" id="ngModalLabel">Add Defect</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">                                        
                                <div class="row">  

                                    <!-- Hidden inspection row id -->
                                    <input type="hidden" id="ng_ir_id" name="ng_ir_id" value="">

                                    <div class="row g-4 mt-2">

                                        <!-- LEFT -->
                                        <div class="col-md-6">
                                            <!-- ALL LEFT CONTENT HERE -->
                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-tools"></i> Type of Defect
                                                </h6>
                                                <?php
                                                    
                                                $cstatus = 'Y';

                                                $query_typeDefc = "SELECT defectid, defectname FROM defect_type WHERE defectstatus = ? ORDER BY defectname ASC";
                                                $get_typeDefc = $db_con->prepare($query_typeDefc); 
                                                $get_typeDefc->bind_param("s", $cstatus);
                                                $get_typeDefc->execute();
                                                $result_typeDefc = $get_typeDefc->get_result(); 

                                                ?>
                                                
                                                <select class="form-control " name="fd_defectType_add" id="fd_defectType_add">
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

                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-wrench"></i> Area of Defect
                                                </h6>

                                                <div class="area-grid">
                                                    <?php
                                                    $query = "SELECT areamax FROM defect_area WHERE areaid = 1"; 
                                                    $result = $db_con->query($query);
                                                    $row = $result->fetch_assoc();
                                                    $max = (int)$row['areamax'];
                                                    ?>

                                                    <?php
                                                    for ($i = 1; $i <= $max; $i++) {
                                                        echo '
                                                        <label class="area-box">
                                                            <input type="checkbox" class="areaCheck" name="fd_area_add[]" value="'.$i.'" id="area_add_'.$i.'">
                                                            <span>'.$i.'</span>
                                                        </label>
                                                        ';
                                                    }
                                                    ?>                                                           
                                                    
                                                </div>
                                            </div>
                                        </div>

                                        <!-- RIGHT -->
                                        <div class="col-md-6">
                                            <!-- ALL RIGHT CONTENT HERE -->
                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-image"></i> Defect Photos
                                                </h6>

                                                <div class="cm-content-body publish-content form excerpt">
                                                    <div class="card-body">
                                                        <div class="row">                                                        
                                                            <div class="col-xl-12 col-sm-12">
                                                                <div class="avatar-upload d-flex flex-column">
                                                                    <div class="photo-box avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_defect_add"></div>
                                                                    <div class="change-btn mt-2">
                                                                        <input type="file" class="form-control d-none" name="imageUpload_defect_photo[]" id="imageUpload_defect" accept=".png, .jpg, .jpeg" multiple>
                                                                        <label for="imageUpload_defect" class="btn btn-sm btn-primary light">
                                                                            <i class="fa fa-upload me-1"></i> Add Image </label>
                                                                        <small class="text-muted d-block mt-1">Use ctrl key to select multiple images.</small>
                                                                    </div>
                                                                </div>
                                                            </div>                                                        
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-image"></i> Comparison Photos
                                                </h6>

                                                <div class="cm-content-body publish-content form excerpt">
                                                    <div class="card-body">
                                                        <div class="row">                                                        
                                                            <div class="col-xl-12 col-sm-12">
                                                                <div class="avatar-upload d-flex flex-column">
                                                                    <div class="photo-box avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare_add"></div>
                                                                    <div class="change-btn mt-2">
                                                                        <input type="file" class="form-control d-none" name="imageUpload_compare_photo[]" id="imageUpload_compare" accept=".png, .jpg, .jpeg" multiple>
                                                                        <label for="imageUpload_compare" class="btn btn-sm btn-primary light">
                                                                            <i class="fa fa-upload me-1"></i> Add Image</label>
                                                                        <small class="text-muted d-block mt-1">Use ctrl key to select multiple images.</small>
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
                                <button type="button" class="btn btn-light btnCloseModal_add" data-bs-dismiss="modal">Cancel</button>
                                <button type="button" class="btn btn-black" id="btnAddDefect_modal"><i class="fa fa-check me-2"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Defect modal -->
                <div class="modal fade" id="editDefectModal" tabindex="-1" aria-labelledby="DefectModalLabel">
                    <div class="modal-dialog  modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <h5 class="modal-title ng-title" id="ngModalLabel">Edit Defect</h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">                                        
                                <div class="row">  

                                    <!-- Hidden inspection row id -->
                                    <input type="hidden" id="ng_ir_id" name="ng_ir_id">
                                    <input type="hidden" id="ng_defect_id" name="ng_defect_id">


                                    <div class="row g-4 mt-2">

                                        <!-- LEFT -->
                                        <div class="col-md-6">
                                            <!-- ALL LEFT CONTENT HERE -->
                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-tools"></i> Type of Defect
                                                </h6>
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

                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-wrench"></i> Area of Defect
                                                </h6>
                                                <div class="area-grid">
                                                    <?php
                                                    $query = "SELECT areamax FROM defect_area WHERE areaid = 1"; 
                                                    $result = $db_con->query($query);
                                                    $row = $result->fetch_assoc();
                                                    $max = (int)$row['areamax'];

                                                    for ($i = 1; $i <= $max; $i++) {
                                                        echo '
                                                        <label class="area-box">
                                                            <input type="checkbox" class="" name="fd_area_ed[]" value="'.$i.'" id="area_ed_'.$i.'">
                                                            <span>'.$i.'</span>
                                                        </label>
                                                        ';
                                                    }
                                                    ?>                                                           
                                                    
                                                </div>
                                            </div>

                                        </div>

                                        <!-- RIGHT -->
                                        <div class="col-md-6">
                                            <!-- ALL RIGHT CONTENT HERE -->
                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-image"></i> Defect Photos
                                                </h6>
                                                <div class="cm-content-body publish-content form excerpt">
                                                    <div class="card-body">
                                                        <div class="row">                                                        
                                                            <div class="col-xl-12 col-sm-12">
                                                                <div class="avatar-upload d-flex flex-column">
                                                                    <div class="photo-box avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_ed"></div>
                                                                    <div class="change-btn mt-2">
                                                                        <input type="file" class="form-control d-none" name="defect_photo_ed[]" id="imageUpload_defect_ed" accept=".png, .jpg, .jpeg" multiple>
                                                                        <label for="imageUpload_defect_ed" class="btn btn-sm btn-primary light">
                                                                            <i class="fa fa-upload me-1"></i> Add Image</label>
                                                                        <small class="text-muted d-block mt-1">Use ctrl key to select multiple images.</small>
                                                                    </div>
                                                                </div>
                                                            </div>                                                        
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="s2w-section">
                                                <h6 class="section-title">
                                                    <i class="fa fa-image"></i> Comparison Photos
                                                </h6>
                                                <div class="cm-content-body publish-content form excerpt">
                                                    <div class="card-body">
                                                        <div class="row">                                                        
                                                            <div class="col-xl-12 col-sm-12">
                                                                <div class="avatar-upload d-flex flex-column">
                                                                    <div class="photo-box avatar-preview-multiple d-flex flex-wrap" id="imagePreviewContainer_compare_ed"></div>
                                                                    <div class="change-btn mt-2">
                                                                        <input type="file" class="form-control d-none" name="compare_photo_ed[]" id="imageUpload_compare_ed" accept=".png, .jpg, .jpeg" multiple>
                                                                        <label for="imageUpload_compare_ed" class="btn btn-sm btn-primary light">
                                                                            <i class="fa fa-upload me-1"></i> Add Image </label>
                                                                        <small class="text-muted d-block mt-1">Use ctrl key to select multiple images. </small>
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
                                <button type="button" class="btn btn-light btnCloseModal_ed" data-bs-dismiss="modal"> Cancel</button>
                                <button type="button" class="btn btn-black" id="btnEditDefect_modal"><i class="fa fa-check me-2"></i> Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zoom photo in modal add -->
                <div class="modal fade" id="imageZoomModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background: transparent; border: none;">
                            <img src="" id="zoomedImage" class="img-fluid rounded shadow" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
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

                <!-- Cancel Remark Modal -->
                <div class="modal fade" id="cancelRemarkModal" tabindex="-1" aria-labelledby="cancelRemarkLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                        <div class="modal-header">                                                    
                            <h5 class="modal-title" id="SubmitModalLabel"></h5>                                                  
                            <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                        <form id="cancelRemarkForm">
                            <div class="modal-body">
                            <input type="hidden" id="cancel_ir_id" name="ir_id">
                        
                            <div class="mb-3">
                                <label for="cancel_remark" class="form-label">Cancellation Reason <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="cancel_remark" name="remark" rows="4" maxlength="500"></textarea>
                                <div class="form-text"><span id="cancel_count">0</span>/500</div>
                            </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-black" id="btnConfirmCancel"><i class="fa fa-times me-1"></i>Cancel Submission</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>

                <!-- Bulk Cancel Modal -->
                <div class="modal fade" id="bulkcancelModal" tabindex="-1" aria-labelledby="bulkcancelModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <form id="bulkcancelForm">
                        <div class="modal-content">
                            <div class="modal-header">                                                    
                                <h5 class="modal-title ng-title" id="bulkcancelModalLabel" style="color : #000000;"></h5>                                                  
                                <button type="button" class="btn btn-sm btn-light rounded-circle" data-bs-dismiss="modal" aria-label="Close">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div> 
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="bulk_cancel_remark" class="form-label">Cancellation Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control" name="remark" id="bulk_cancel_remark" rows="4" style="color: #333;"></textarea>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-black" id="btnConfirmCancelBulk"><i class="fa fa-undo"></i> Cancel Submission</button>
                            </div>
                        </div>
                        </form>
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
	<script src="vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js"></script>
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

    <!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="vendor/moment/moment.min.js"></script>
 
    <!-- Pickdate -->
    <script src="js/plugins-init/pickadate-init.js"></script>    
    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    
    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>
  

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

    //today date
    function getTodayDDMMYYYY() {
        const d = new Date();
        const dd = String(d.getDate()).padStart(2,'0');
        const mm = String(d.getMonth()+1).padStart(2,'0');
        const yyyy = d.getFullYear();
        return `${dd}-${mm}-${yyyy}`;
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
                    $('#detailsPreview').slideDown();
                    $('#inspectionView').slideDown();
                    $('#imagePreview').slideDown();

                    // Re-init lightGallery
                    if ($('#lightgallery').data('lightGallery')) {
                        $('#lightgallery').data('lightGallery').destroy(true);
                    }
                    $('#lightgallery').lightGallery({
                        selector: 'a',
                        thumbnail: true
                    });

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
            alert('Please select Model, Type, and Part no.');
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
        let fyear    = $('#hidden_financialyr').val();
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
                    fyear : fyear,
                    result: result
                },
                success: function(response) {

                    // alert('Record saved.');
                    if (response.success) {
                        $.ajax({
                            url: 'get-latest-pallet.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {model: model, type: type, material: material, shift: shift},
                            success: function(res) {

                                // SweetAlert2 for success message only
                                Swal.fire({
                                    icon: 'success',
                                    iconColor: "#286912",
                                    title: 'Saved!',
                                    text: 'Record saved.',
                                    timer: 3000,
                                    showConfirmButton: false
                                });

                                let latestPallet = res.latest_pallet ? (parseInt(res.latest_pallet) + 1) : 1;
                                $('.ipallet').val(latestPallet);
                                $select.val('').trigger('change');
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
                            title: 'Oops...',
                            text: res.msg || 'Failed to add defect.',
                        });
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

    // Camera Support
    document.getElementById('defect_camera').addEventListener('change', function() {
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

    // Comparison Camera Support
    document.getElementById('compare_camera').addEventListener('change', function() {
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

    // Add new defect
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
                            iconColor: "#286912",
                            title: 'Saved!',
                            text: 'Defect added successfully.',
                            timer: 3000,
                            showConfirmButton: false
                        });

                        loadPalletTable();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
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

    <?php

    // All transaction status
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
    
    let selectedIds = new Set();
    let selectAllPages = false;
    let selectedStatuses = new Map(); // Store ID -> Status mapping

    function toggleBulkButtons() {
        if (selectedIds.size === 0) {
            $('#btnSubmitSelected').prop('disabled', true);
            $('#btnCancelSelected').prop('disabled', true);
            return;
        }

        // collect selected statuses from our Map
        let statuses = [];
        selectedIds.forEach(id => {
            if (selectedStatuses.has(String(id))) {
                statuses.push(selectedStatuses.get(String(id)));
            }
        });

        // if statuses length is zero but selectedIds is not, something is wrong or loading
        if (statuses.length === 0) {
             $('#btnSubmitSelected').prop('disabled', true);
             $('#btnCancelSelected').prop('disabled', true);
             return;
        }

        // RULE 1: Submit only if ALL are 1, 12 or 13
        let canSubmit = statuses.length > 0 && statuses.every(s => (s === 1 || s === 12 || s === 13));

        // RULE 2: Cancel only if ALL are 9
        let canCancel = statuses.length > 0 && statuses.every(s => (s === 9));

        $('#btnSubmitSelected').prop('disabled', !canSubmit);
        $('#btnCancelSelected').prop('disabled', !canCancel);
    }

    $(document).on('change', '.row-check', function () {
        const id = String(this.value);

        if (this.checked) {
            selectedIds.add(id);
            selectedStatuses.set(id, parseInt($(this).data('status')));
        } else {
            selectedIds.delete(id);
            selectedStatuses.delete(id);
            selectAllPages = false;
            $('#checkAll').prop('checked', false);
        }

        toggleBulkButtons();
    });

    $(document).on('change', '#checkAll', function () {
        selectAllPages = this.checked;
        
        // Use DataTables API to find ALL row-check checkboxes across all pages
        const table = $('.inspectionTable').DataTable();
        const allCheckboxes = table.$('.row-check:not(:disabled)');

        if (selectAllPages) {
            allCheckboxes.prop('checked', true).each(function () {
                selectedIds.add(String(this.value));
                selectedStatuses.set(String(this.value), parseInt($(this).data('status')));
            });
        } else {
            allCheckboxes.prop('checked', false);
            selectedIds.clear();
            selectedStatuses.clear();
        }

        toggleBulkButtons();
    });

    // Handle draw event to restore checked states
    $(document).on('draw.dt', '.inspectionTable', function () {
        const table = $(this).DataTable();
        
        table.$('.row-check').each(function () {
            const id = String(this.value);
            if (selectAllPages || selectedIds.has(id)) {
                $(this).prop('checked', true);
                // Ensure status is in map if checkbox is checked
                if (!selectedStatuses.has(id)) {
                    selectedStatuses.set(id, parseInt($(this).data('status')));
                }
            } else {
                $(this).prop('checked', false);
                // Ensure status is removed from map if checkbox is unchecked
                if (selectedStatuses.has(id)) {
                    selectedStatuses.delete(id);
                }
            }
        });

        $('#checkAll').prop('checked', selectAllPages);
        toggleBulkButtons();
    });

    </script>

    <script>

    const shiftDate = $('#hidden_shift_date').val(); 

    function loadPalletTable() {

        const model    = $('.cs_model').val();
        const type     = $('.cs_type').val();
        const material = $('.cs_material').val();
        const shift    = $('#hidden_shift').val();
        const statusFilter = $('#statusFilter').val() || '';

        if (!model || !type || !material || !shift) {
            $('.inspectionTable tbody').html('<tr><td colspan="5" class="text-muted">Select model/type/material first.</td></tr>');
            return;
        }

        $.ajax({
            
            url: 'fetch-inspection-rcd-list.php',
            type: 'POST',
            dataType: 'json',
            data: { model, type, material, shift, status: statusFilter },

            success: function(res){

                // If DataTable already initialized, destroy before replacing DOM
                if ($.fn.dataTable && $.fn.dataTable.isDataTable('.inspectionTable')) {
                    $('.inspectionTable').DataTable().destroy();
                }

                const rows = res.rows || [];
                
                // Clear and populate status map for all records in the list
                selectedStatuses.clear();

                if (!rows.length) {
                    $('.inspectionTable tbody').html('<tr><td colspan="8" class="text-muted">No records yet.</td></tr>');
                    return;
                }

                let html = '';
                rows.forEach(r => {
                    selectedStatuses.set(String(r.ir_id), parseInt(r.ir_status));


                const hasDefect  = (r.defect_count || 0) > 0;
                const resultVal  = r.ir_result ? r.ir_result : '';
                const statusNum  = parseInt(r.ir_status, 10); // API must return this

                let statusText = statusMap[statusNum] || ''; // status is integer
                let statusCol = '';

                if (statusNum !== 1) { // Hide badge if status is "New"
                
                    let badgeClass = '';

                    if (parseInt(statusNum) === 4) badgeClass = 'badge-outline-sephora';
                    else if (parseInt(statusNum) === 5) badgeClass = 'badge-outline-oyen';
                    else if (parseInt(statusNum) === 8) badgeClass = 'badge-outline-pink';
                    else if (parseInt(statusNum) === 9) badgeClass = 'badge-outline-emerald';
                    else if (parseInt(statusNum) === 10) badgeClass = 'badge-outline-meron';
                    else if (parseInt(statusNum) === 11) badgeClass = 'badge-outline-hijau';
                    else if (parseInt(statusNum) === 12) badgeClass = 'badge-outline-bangtan';
                    else badgeClass = 'badge-outline-light text-dark';

                    if (statusNum === 12) {
                        statusCol = `<span class="badge badge-rounded ${badgeClass} showReturnComment" 
                                        data-irid="${r.ir_id}" 
                                        style="cursor: pointer; font-size: 0.75rem;">
                                        ${statusText}
                                    </span>`;
                    } else {
                        statusCol = `<span class="badge badge-rounded ${badgeClass}" style="font-size:0.75rem;">
                                        ${statusText || ''}
                                    </span>`;
                    }

                } else {
                    statusCol = '';
                }

                // 1) RESULT CELL (editable only if status == 1)
                let resultCell = '';
                if (statusNum === 1 || statusNum === 12) {
                    resultCell = `
                        <select class="form-control result-select resultSelect_ed" data-irid="${r.ir_id}" data-status="${statusNum}">
                            <option value="" ${resultVal === '' ? 'selected' : ''}>Select</option>
                            <option value="OK" ${resultVal === 'OK' ? 'selected' : ''}>OK</option>
                            <option value="NG" ${resultVal === 'NG' ? 'selected' : ''}>NG</option>
                        </select>
                    `;
                } else {                  
                    resultCell = `
                        <select class="form-control result-select resultSelect_ed" data-irid="${r.ir_id}" data-status="${statusNum}" disabled>
                            <option value="" ${resultVal === '' ? 'selected' : ''}>Select</option>
                            <option value="OK" ${resultVal === 'OK' ? 'selected' : ''}>OK</option>
                            <option value="NG" ${resultVal === 'NG' ? 'selected' : ''}>NG</option>
                        </select>
                    `;
                }

                // 2) DEFECT CELL
                let defectCell = '<span class="text-muted"> </span>';

                if (resultVal === 'NG') {

                    // Disable AddDefectModal if status is 8 or 9
                    const isAddDefectDisabled = (statusNum === 4 || statusNum === 5 || statusNum === 8 || statusNum === 9 || statusNum === 11);

                    if (!isAddDefectDisabled) {
                        defectCell = `
                            <button class="btn btn-rounded btn-black btn-xxs AddDefectModal" 
                                    data-irid="${r.ir_id}" 
                                    data-bs-toggle="tooltip" 
                                    data-bs-placement="top" 
                                    title="Add defect">
                                <i class="fa fa-plus"></i>
                            </button>`;
                    } else {
                        defectCell = ` <button class="btn btn-rounded btn-black btn-xxs AddDefectModal" disabled>
                                        <i class="fa fa-plus"></i>
                                     </button>`;
                    }

                    // Show View only if defect_count > 0
                    if (hasDefect) {
                        defectCell += `
                        <button class="btn btn-rounded btn-black btn-xxs ViewDefect" 
                                data-irid="${r.ir_id}" 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" 
                                title="View defect">
                            <i class="fa fa-bars"></i>
                        </button>`;
                    }

                } else if (hasDefect) {
                    // if record is OK but still has defect_count > 0 (edge case)
                    defectCell = hasDefect;
                }

                // 3) ACTION CELL (submit/cancel rules)
                const canSubmit = (resultVal === 'OK') || (resultVal === 'NG' && hasDefect);
                let actionCell = '<span class="text-muted"> </span>';

                if (statusNum === 9) {
                    actionCell = `
                        <button class="btn btn-rounded btn-warning btn-xxs btnCancel"
                                data-bs-toggle="tooltip" data-bs-placement="top"
                                title="Cancel submission"
                                data-irid="${r.ir_id}">
                            <i class="fa fa-times"></i>
                        </button>`;
                } 
                else if (canSubmit) {
                    if (statusNum === 4 || statusNum === 5 || statusNum === 11) {
                        
                        actionCell = `
                            <button class="btn btn-rounded btn-red btn-xxs btnSubmit" disabled
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Already reviewed / returned"
                                    data-irid="${r.ir_id}">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>`;
                    } else {
                        actionCell = `
                            <button class="btn btn-rounded btn-red btn-xxs btnSubmit"
                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                    title="Submit inspection"
                                    data-irid="${r.ir_id}">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>`;
                    }
                }

                //4) PRODUCTION DATE
                let prodDate = r.prod_date && r.prod_date !== "00-00-0000" 
                ? r.prod_date 
                : shiftDate;

                let prodDateCell = '';

                if (statusNum === 1 || statusNum === 12 || statusNum === 13) {

                    // editable
                    prodDateCell = `
                    <div class="date-wrapper">
                        <input name="datepicker"
                            class="form-control bt-datepicker"
                            value="${prodDate}"
                            data-irid="${r.ir_id}">
                        <i class="far fa-calendar calendar-icon"></i>
                    </div>
                    `;

                } else {

                    // disabled (readonly + styled)
                    prodDateCell = `
                    <div class="date-wrapper disabled">
                        <input name="datepicker"
                            class="form-control bt-datepicker"
                            value="${prodDate}"
                            data-irid="${r.ir_id}"
                            disabled>
                        <i class="far fa-calendar calendar-icon"></i>
                    </div>
                    `;
                }

                const disableStatuses = [5,8,11];
                // Disable checkbox if status is 5, 8, 11 OR if ir_result is empty
                const isCheckboxDisabled = disableStatuses.includes(statusNum) || !resultVal;

                html += `
                <tr data-ir="${r.ir_id || ''}" data-status="${r.ir_status}">
                        <td class="text-center">
                            <input type="checkbox"
                            class="row-check form-check-input"
                            value="${r.ir_id}"
                            data-status="${statusNum}"
                            ${isCheckboxDisabled ? 'disabled' : ''}>
                        </td>
                        <td>${r.ir_pallet_no}</td>
                        <td>${r.ir_docno || '-'}</td>
                        <td>${resultCell}</td>
                        <td>${prodDateCell}</td>
                        <td>${statusCol}</td>
                        <td>${defectCell}${actionCell}</td>
                    </tr>`;

                });

                $('.inspectionTable tbody').html(html);

                // initialise datepickers
                $('.bt-datepicker').datepicker({
                    format: 'dd-mm-yyyy',
                    autoclose: true,
                    todayHighlight: true,
                    endDate: new Date()   // disable future dates
                });

                // init DataTables pagination (Bootstrap 5)
                $('.inspectionTable').DataTable({
                    paging: true,
                    searching: false,
                    info: true,
                    lengthChange: false,        // hide "Show X entries"
                    pageLength: 10,             // items per page
                    ordering: true,                    
                    order: [[1, 'asc']],
                    columnDefs:[
                        {
                            "targets": 'nosort',
                            "orderable":false,
                        },
                    ],
                    stateSave: false,           // set true if you want it to remember page
                    language: {
                        paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
                    },
                    drawCallback: function () {
                        // re-init tooltips each time the page changes
                        document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
                        if (!el.getAttribute('data-bs-original-title')) new bootstrap.Tooltip(el);
                        });
                    }
                });
      
                // run tooltip
                $('[data-bs-toggle="tooltip"]').tooltip();

            },

            error: function(xhr){
            console.error(xhr.responseText);
            $('.inspectionTable tbody').html('<tr><td colspan="5" class="text-danger">Failed to load table.</td></tr>');

            }
        });
  
    }

    // Auto save production date
    $(document).off('change', '.bt-datepicker').on('change', '.bt-datepicker', function () {

        let ir_id = $(this).data('irid');
        let prod_date = $(this).val();

        if(!ir_id || !prod_date) return;

        $.ajax({
            url: 'inspection-update-production-date.php',
            type: 'POST',
            dataType: 'json',
            data: {
                ir_id: ir_id,
                prod_date: prod_date
            },

            success:function(res){

                if(res.status === 'success'){
                    console.log("Production date saved");
                } 
                else{
                    alert("Failed to save date");
                }
            },

            error:function(xhr){
                console.log(xhr.responseText);
                alert("Server error saving date");
            }
        });

    });

    // Hook into your existing flows:
    $('#btnFilter').on('click', function(){
        selectedIds.clear();
        selectedStatuses.clear();
        selectAllPages = false;
        $('#checkAll').prop('checked', false);
        loadPalletTable();
    });

    // Run when the View tab is shown
    $('a[href="#view-pallet"]').on('shown.bs.tab', function () {
        loadPalletTable();
    });

    $(document).on('change', '#statusFilter', function(){
        loadPalletTable();
    });

    </script>

    <script>

    // View return comment
    $(document).off('click', '.showReturnComment').on('click', '.showReturnComment', function () {
        const ir_id = $(this).data('irid');

        $.post('get-inspection-comment.php', { ir_id }, function (res) {
            const commentText = res || 'No comment available.';

            Swal.fire({
                title: 'Comment',
                html: `<div class="text-start text-center">${commentText}</div>`,
                confirmButtonText: 'Close',
                customClass: {
                    title: 'swal-title-sm', 
                    confirmButton: 'btn btn-sm btn-primary',
                    popup: 'swal-font-sm'
                }
            });
        }).fail(function () {
            Swal.fire({
                icon: 'error',
                iconColor: "#286912",
                title: 'Failed to load comment',
                text: 'Please try again later.'
            });
        });
    });

    </script>

    <script>
        
    function resetNgModal(){

        $('#ng_ir_id').val('');
        $('#fd_defectType').val('').trigger('change');
        $('input[name="fd_area[]"]').prop('checked', false);

        // clear without changing references
        defectFiles.length = 0;
        compareFiles.length = 0;

        $('#imagePreviewContainer_modal, #imagePreviewContainer_compare_modal').empty();
        $('label[for="imageUpload_defect"], label[for="imageUpload_compare"]').removeClass('border-error');

    }

    // open NG modal from the table button
    $(document).on('click', '.AddDefectModal', function (e) {

        e.preventDefault();

        const irId = $(this).data('irid') || '';
        const $tr = $(this).closest('tr');
        const palletNo = $tr.find('td').eq(1).text().trim(); // Column 1 is Pallet Sequence

        // optional: clear the modal fields if you have a reset function
        if (typeof resetNgModal === 'function') resetNgModal();

        $('#ng_ir_id').val(irId);
        $('#ngModalLabel').addClass('ng-title').text(`Add Defect — Pallet Sequence ${palletNo || ''}`);

        // Bootstrap 5 programmatic open
        const ngModal = new bootstrap.Modal(document.getElementById('ngModal'));
        ngModal.show();

    });

    </script>
    
    <!-- ###### ADD DEFECT -->
    <script>

    //  Add Defect
    // --- For Defect Photo ---
    let selectedFiles_defect = [];

    $('#imagePreviewContainer_defect_add').on('click', '.remove-image', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const idx = $(this).data('idx');
        selectedFiles_defect.splice(idx, 1);
        updatePreview_defect();
    });

    function updatePreview_defect() {
        const previewContainer = $('#imagePreviewContainer_defect_add');
        previewContainer.html(""); // Clear previews

        selectedFiles_defect.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`
                    <div class="avatar-preview me-2 mb-2 position-relative" style="cursor:pointer;" data-imgsrc="${e.target.result}">
                        <span class="remove-image" data-idx="${idx}" style="position:absolute;top:-11px;right:-11px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
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

    $('#imageUpload_defect').change(function() {
        const newFiles = Array.from(this.files);
        selectedFiles_defect = selectedFiles_defect.concat(newFiles);
        updatePreview_defect();
        $(this).val('');
    });

    $('#imagePreviewContainer_defect_add').on('click', '.avatar-preview', function(e){
        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');
        // open modal manually
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    // --- For Comparing Photo ---
    let selectedFiles_compare = [];

    $('#imagePreviewContainer_compare_add').on('click', '.remove-image', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const idx = $(this).data('idx');
        selectedFiles_compare.splice(idx, 1);
        updatePreview_compare();
    });

    function updatePreview_compare() {
        const previewContainer = $('#imagePreviewContainer_compare_add');
        previewContainer.html(""); // Clear previews

        selectedFiles_compare.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`
                    <div class="avatar-preview me-2 mb-2 position-relative" style="cursor:pointer;" data-imgsrc="${e.target.result}">
                        <span class="remove-image" data-idx="${idx}" style="position:absolute;top:-11px;right:-11px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
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

    $('#imagePreviewContainer_compare_add').on('click', '.avatar-preview', function(e){
        if ($(e.target).hasClass('remove-image')) return;
        let imgSrc = $(this).attr('data-imgsrc');
        // open modal manually
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    </script>

    <script>

    // Add Defect form Modal
    // Remove old error border first (optional)
    $('#fd_defectType_add').removeClass('border-error');
    $('input[name="fd_area_add[]"]').closest('.area-grid').removeClass('border-error');
    $('#imageUpload_defect').removeClass('border-error');
    $('#imageUpload_compare').removeClass('border-error');

    // Remove border when user fixes the input
    $('#fd_defectType_add').on('change', function() {
        // $(this).removeClass('border-error');
        $(this).next('.select2').find('.select2-selection').removeClass('border-error');
    }); 
    
    // Remove border when user fixes the input
    $('input[name="fd_area_add[]"]').on('change', function() {
        if ($('input[name="fd_area_add[]"]:checked').length > 0) {
            $('.area-grid').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#imageUpload_defect').on('change', function() {
        if (selectedFiles_defect.length > 0) {
            $('label[for="imageUpload_defect"]').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#imageUpload_compare').on('change', function() {
        if (selectedFiles_compare.length > 0) {
            $('label[for="imageUpload_compare"]').removeClass('border-error');
        }
    });

    // Save
    $('#btnAddDefect_modal').on('click', function() {
        
        console.log('ng_ir_id:', $('#ng_ir_id').val());
        console.log('fd_defectType:', $('#fd_defectType_add').val());

        // Gather values
        var defectType = $('#fd_defectType_add').val();
        var checkedAreas = $('input[name="fd_area_add[]"]:checked').length;
        var defectPhotos = selectedFiles_defect.length;
        var comparePhotos = selectedFiles_compare.length;
        var irId = $('#ng_ir_id').val();

        // Remove previous error states
        $('#fd_defectType_add').removeClass('border-error');
        $('.area-grid').removeClass('border-error');
        $('label[for="imageUpload_defect"]').removeClass('border-error');
        $('label[for="imageUpload_compare"]').removeClass('border-error');

        // Validation: Defect Type
        if (!defectType) {
            $('#fd_defectType_add').addClass('border-error');
            Swal.fire({
                title: "Missing Field",
                text: "Please select a defect type.",
                icon: "warning",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                $('#fd_defectType_add').focus();
            });
            return;
        }

        // Validation: Defect Area
        if (checkedAreas === 0) {
            $('.area-grid').addClass('border-error');
            Swal.fire({
                title: "Missing Field",
                text: "Please select at least one defect area.",
                icon: "warning",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            });
            return;
        }

        // Validation: Defect Photos
        if (defectPhotos === 0) {
            $('label[for="imageUpload_defect"]').addClass('border-error');
            Swal.fire({
                title: "Missing Field",
                text: "Please add at least one defect photo.",
                icon: "warning",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                $('label[for="imageUpload_defect"]').focus();
            });
            return;
        }

        // Validation: Comparison Photos
        if (comparePhotos === 0) {
            $('label[for="imageUpload_compare"]').addClass('border-error');
            Swal.fire({
                title: "Missing Field",
                text: "Please add at least one comparison photo.",
                icon: "warning",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                $('label[for="imageUpload_compare"]').focus();
            });
            return;
        }

        // Validation: IR ID
        if (!irId) {
            Swal.fire({
                title: "System Error",
                text: "Missing record ID. Please try again.",
                icon: "error",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            });
            return;
        }


        var formData = new FormData();

        // Collect simple fields
        formData.append('action', 'add_defect_modal');
        formData.append('ng_ir_id', $('#ng_ir_id').val());
        formData.append('fd_defectType_add', $('#fd_defectType_add').val());

        // Collect checked defect areas (as array)
        $('input[name="fd_area_add[]"]:checked').each(function(i, obj) {
            formData.append('fd_area_add[]', $(obj).val());
        });

        // Defect photo files
        for (var i = 0; i < selectedFiles_defect.length; i++) {
            formData.append('imageUpload_defect_photo[]', selectedFiles_defect[i]);
        }

        // Compare photo files
        for (var i = 0; i < selectedFiles_compare.length; i++) {
            formData.append('imageUpload_compare_photo[]', selectedFiles_compare[i]);
        }

        $.ajax({
            url: 'inspection-rcd-defect-action.php',
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
                    resetAddDefectModal(); 
                    loadPalletTable();

                    // alert('Defect added successfully.');
                    
                    // SweetAlert2 for success message only
                    Swal.fire({
                        icon: 'success',
                        iconColor: "#286912",
                        title: 'Saved!',
                        text: 'Defect added successfully.',
                        timer: 3000,
                        showConfirmButton: false,
                        confirmButtonColor: "#198754"
                    });                   

                    let row = $('#ngModal').data('row');
                    if (row) {

                        let ir_id = $('#ng_ir_id').val();
                        let defectTd = row.find('td').eq(2); // Defect column
                        let sendTd = row.find('td').eq(4);   // Send column

                        // Defect column: both buttons
                        let defectBtns = 
                            `<button class="btn btn-rounded btn-primary btn-xxs AddDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="Add defect">
                                <i class="fa fa-plus"></i> 
                            </button>
                            <button class="btn btn-rounded btn-warning btn-xxs ViewDefect" data-irid="${ir_id}" data-bs-toggle="tooltip" data-bs-placement="top" title="View defect">
                                <i class="fa fa-bars"></i>
                            </button>`;

                        // Send column: only submit button
                        let sendBtn = 
                            `<button class="btn btn-rounded btn-red btn-xxs btnSubmit" 
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Submit inspection" data-irid="${ir_id}">
                                <i class="fa-solid fa-paper-plane"></i>
                            </button>`;

                        defectTd.html(defectBtns);
                        sendTd.html(sendBtn);

                        // Refresh the defect list (offcanvas)
                        let status = row.data('status');
                        reloadDefectTable(ir_id, status);

                        $('#ngModal').removeData('row');
                    }

                } else {
                    Swal.fire({
                        icon: 'error',
                        iconColor: "#286912",
                        title: 'Oops...',
                        text: res.msg || 'Failed to add defect.',
                    });
                }
            },
            error: function() {
                alert('AJAX error');
            }
        });
    });
    
    </script>

    <!-- ###### VIEW DEFECT -->
    <script>

    // View defect
    $(document).on('click', '.ViewDefect', function() {

        let btn = $(this);
        let row = btn.closest('tr');
        let irId = btn.data('irid');
        let status = row.attr('data-status');
        
        // Initialize/Get offcanvas
        var bsOffcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasDefect'));
        bsOffcanvas.show();

        // Show loading state
        $('#offcanvasDefectContent').html('<div class="d-flex justify-content-center py-5"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div></div>');
        
        // AJAX to get defect list
        $.ajax({
            url: 'fetch-inspection-rcd-defect-list.php',
            type: 'POST',
            data: { ir_id: irId, status: status }, 
            success: function(html) {
                $('#offcanvasDefectContent').html(html);

                // Re-initialize tooltips
                var tooltipTriggerList = [].slice.call(document.querySelectorAll('#offcanvasDefectContent [data-bs-toggle="tooltip"]'))
                var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                  return new bootstrap.Tooltip(tooltipTriggerEl)
                })
            },
            error: function() {
                $('#offcanvasDefectContent').html('<div class="text-danger text-center p-3">Failed to load defect details.</div>');
            }
        });

    });

    // When clicking on any zoomable image
    $(document).on('click', '.zoomable-photo-defect', function () {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    // When clicking on any zoomable image
    $(document).on('click', '.zoomable-photo-compare', function () {
        const imgSrc = $(this).data('src') || $(this).attr('src');
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');
    });

    </script>

    <!-- ###### DELETE DEFECT -->
    <script>

    $(document).on('click', '.delete-defect', function () {

        let defectId = $(this).data('defectid');
        let irId     = $(this).data('irid');

        // Store hidden values
        $('#ng_ir_id').val(irId);
        $('#ng_defect_id').val(defectId);

        Swal.fire({
            title: 'Remove this defect?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            iconColor: '#286912',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            // cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel',
            reverseButtons: true
        }).then((result) => {

            if (!result.isConfirmed) return;

            $.ajax({
                url: 'inspection-rcd-defect-action.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    action: 'delete_defect',
                    defect_id: defectId,
                    ir_id: irId
                },
                success: function (res) {

                    if (res.success) {

                        Swal.fire({
                            icon: 'success',
                            iconColor: '#286912',
                            title: 'Deleted!',
                            text: 'Defect deleted successfully.',
                            timer: 2500,
                            showConfirmButton: false
                        });

                        reloadDefectTable(irId, 1);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            iconColor: '#dc3545',
                            title: 'Failed',
                            text: res.msg || 'Failed to delete defect.'
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        icon: 'error',
                        iconColor: '#dc3545',
                        title: 'Server Error',
                        text: 'Unable to process your request.'
                    });
                }
            });

        });
    });

    </script>

    <!-- ###### EDIT DEFECT -->
    <script>

    // Photo
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
            url: 'fetch-inspection-rcd-single-defect.php',
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

                    console.log('Existing defect photos:', existing_defect_photos);
                    console.log('Existing compare photos:', existing_compare_photos);

                    updatePreview_defect_ed();
                    updatePreview_compare_ed();

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

        console.log('updatePreview_defect_ed called, existing photos count:', existing_defect_photos.length);

        // Existing (from DB)
        existing_defect_photos.forEach((img, idx) => {

            const imgId = img.def_photoid;
            const imgUrl = img.url; // Don't encode yet, test raw URL first

            console.log(`Defect photo ${idx}:`, { imgId, imgUrl, raw: img });

            const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative" data-exist="1" data-idx="${idx}" data-imgsrc="${imgUrl}" data-imgid="${imgId}">
                                <span class="remove-image-defect-old" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                            </div>`).css({
                                'background-image': 'url("' + imgUrl + '")',
                                'width': '80px',
                                'height': '80px',
                                'background-size': 'cover',
                                'background-position': 'center',
                                'border-radius': '12px',
                                'border':'1px solid #ddd',
                                'cursor': 'pointer'
                            });
            
            console.log('Created div for defect photo:', imgDiv[0]);
            console.log('Background image style:', imgDiv.css('background-image'));
            
            c.append(imgDiv);
        });

        // New files (not yet uploaded)
        selectedFiles_defect_ed.forEach((file, idx) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative"
                    data-exist="0" data-idx="${idx}" data-imgsrc="${e.target.result}">
                    <span class="remove-image" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
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
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');

    });
    
    // Add new image(s)
    $('#imageUpload_defect_ed').on('change', function() {
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
            let photoId = $img.data('imgid');
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

    //Comparison photo
    function updatePreview_compare_ed(isEdit = false) {

        const c = $('#imagePreviewContainer_compare_ed');
        c.empty();

        console.log('updatePreview_compare_ed called, existing photos count:', existing_compare_photos.length);

        // Existing (from DB)
        existing_compare_photos.forEach((img, idx) => {

            const imgId = img.compare_photoid;
            const imgUrl = img.url; // Don't encode, use raw URL

            console.log(`Compare photo ${idx}:`, { imgId, imgUrl, raw: img });

            const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative" data-exist="1" data-idx="${idx}" data-imgsrc="${imgUrl}" data-imgid="${imgId}">
                                <span class="remove-image-compare-old" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
                            </div>`).css({
                                'background-image': 'url("' + imgUrl + '")',
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
                    <span class="remove-image" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
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
        $('#zoomedImage').attr('src', imgSrc);
        $('#imageZoomModal').modal('show');

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
            let photoId = $img.data('imgid');
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

    // Edit defect details
    // Remove old error border first (optional)
    $('#fd_defectType_ed').removeClass('border-error');
    $('input[name="fd_area_ed[]"]').closest('.area-grid').removeClass('border-error');

    // Remove border when user fixes the input
    $('#fd_defectType_ed').on('change', function() {
        // $(this).removeClass('border-error');
        $(this).next('.select2').find('.select2-selection').removeClass('border-error');
    }); 
    
    // Remove border when user fixes the input
    $('input[name="fd_area_ed[]"]').on('change', function() {
        if ($('input[name="fd_area_ed[]"]:checked').length > 0) {
            $('.area-grid').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#imageUpload_defect_ed').on('change', function() {
        if (selectedFiles_defect_ed.length > 0) {
            $('label[for="imageUpload_defect_ed"]').removeClass('border-error');
        }
    });

    // Remove border when user fixes the input
    $('#imageUpload_compare_ed').on('change', function() {
        if (selectedFiles_compare_ed.length > 0) {
            $('label[for="imageUpload_compare_ed"]').removeClass('border-error');
        }
    });

    //Update
    $('#btnEditDefect_modal').on('click', function(e) {

        e.preventDefault();

        // Gather values
        var defectType = $('#fd_defectType_ed').val();
        var checkedAreas = $('input[name="fd_area_ed[]"]:checked').length;
        var defectPhotos = selectedFiles_defect_ed.length;
        var comparePhotos = selectedFiles_compare_ed.length;
        var irId = $('#ng_ir_id').val();

        var totalDefectPhotos = (existing_defect_photos?.length || 0) + (selectedFiles_defect_ed?.length || 0);
        var totalComparePhotos = (existing_compare_photos?.length || 0) + (selectedFiles_compare_ed?.length || 0);

        // Remove previous error states
        $('#fd_defectType_ed').removeClass('border-error');
        $('.area-grid').removeClass('border-error');
        $('label[for="imageUpload_defect_ed"]').removeClass('border-error');
        $('label[for="imageUpload_compare_ed"]').removeClass('border-error');

        // Validation: Defect Type
        if (!defectType) {
            $('#fd_defectType_ed').addClass('border-error');
            Swal.fire({
                title: "Missing Field",
                text: "Please select a defect type.",
                icon: "warning",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                $('#fd_defectType_ed').focus();
            });
            return;
        }

        // Validation: Defect Area
        if (checkedAreas === 0) {
            $('.area-grid').addClass('border-error');
            Swal.fire({
                title: "Missing Field",
                text: "Please select at least one defect area.",
                icon: "warning",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            });
            return;
        }

        // Validation: Defect Photos (including existing)
        if (totalDefectPhotos === 0) {
            $('label[for="imageUpload_defect_ed"]').addClass('border-error');
            Swal.fire({
                title: "Missing Field",
                text: "Please add at least one defect photo.",
                icon: "warning",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                $('label[for="imageUpload_defect_ed"]').focus();
            });
            return;
        }

        // Validation: Comparison Photos (including existing)
        if (totalComparePhotos === 0) {
            $('label[for="imageUpload_compare_ed"]').addClass('border-error');
            Swal.fire({
                title: "Missing Field",
                text: "Please add at least one comparison photo.",
                icon: "warning",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            }).then(() => {
                $('label[for="imageUpload_compare_ed"]').focus();
            });
            return;
        }

        // Validation: IR ID
        if (!irId) {
            Swal.fire({
                title: "System Error",
                text: "Missing record ID. Please try again.",
                icon: "error",
                iconColor: "#286912",
                confirmButtonText: "OK",
                confirmButtonColor: "#198754"
            });
            return;
        }
        
        let formData = new FormData();

        formData.append('action', 'update_defect_modal');
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

                    //alert('Your changes have been saved.');

                    // Success feedback
                    Swal.fire({
                        icon: 'success',
                        iconColor: "#286912",
                        title: 'Updated!',
                        text: 'Your changes have been saved.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                    $('#editDefectModal').modal('hide');

                    //reload table
                    reloadDefectTable($('#ng_ir_id').val(), 1);

                    // Reset arrays for next time
                    selectedFiles_defect_ed = [];
                    deleted_defect_photo_ids = [];
                    selectedFiles_compare_ed = [];
                    deleted_compare_photo_ids = [];

                } else {
                    Swal.fire({
                        icon: 'error',
                        iconColor: "#286912",
                        title: 'Oops...',
                        text: res.msg || 'Update failed.',
                    });
                }
            }
        });
    });

    // reload the table
    function reloadDefectTable(ir_id, status) {

        $.ajax({
            url: 'fetch-inspection-rcd-defect-list.php',
            type: 'POST',
            data: { ir_id: ir_id, status: status },
            success: function(html) {
                // If offcanvas is present, update it
                if ($('#offcanvasDefectContent').length > 0) {
                     $('#offcanvasDefectContent').html(html);
                }
                
                // Fallback for container if somehow still used
                if ($('#defectTableContainer').length > 0 && $('#offcanvasDefectContent').length === 0) {
                     $('#defectTableContainer').replaceWith(html);
                }
            }
        });
    }

    </script>

    <script>

    // Close button (modal)  
    // Clear cache data / form fields if cancel
    $('.btnCloseModal_add').on('click', function() {

        // 1. Clear image arrays
        selectedFiles_defect = [];
        selectedFiles_compare = [];
        updatePreview_defect();
        updatePreview_compare();

        // 2. Reset form fields
        // Reset select2
        $('#fd_defectType_add').val('').trigger('change'); // if using Select2

        // Reset checkboxes
        $('input[type="checkbox"]').prop('checked', false);

        // Reset other inputs as needed
        // e.g., $('input[type="text"]').val('');

        // Optionally, reset <input type="file"> if you want:
        $('#imageUpload_defect').val('');
        $('#imageUpload_compare').val('');

    });

    // Clear cache data / form fields if cancel
    $('.btnCloseModal_edit').on('click', function() {

        // 1. Clear image arrays
        selectedFiles_defect_ed = [];
        selectedFiles_compare_ed = [];
        updatePreview_defect_ed();
        updatePreview_compare_ed();

        // 2. Reset form fields
        // Reset select2
        $('#fd_defectTyp_ed').val('').trigger('change'); // if using Select2

        // Reset checkboxes
        $('input[type="checkbox"]').prop('checked', false);

        // Reset other inputs as needed
        // e.g., $('input[type="text"]').val('');

        // Optionally, reset <input type="file"> if you want:
        $('#imageUpload_defect_ed').val('');
        $('#imageUpload_compare_ed').val('');
    });

    </script>
    
    <!-- ###### EDIT RESULT -->
    <script>

    //Update result in list (OK->NG , NG->OK)
    $(document).on('change', '.resultSelect_ed', function() {

        let $select = $(this);
        let row = $(this).closest('tr');
        let result = $(this).val();
        let ir_id = $(this).data('irid');
        let status = parseInt($select.data('status'), 10);

        // Disable while saving (UX)
        $select.prop('disabled', true);

        let ajaxAction = (status === 12) ? 'update_result_reset_status' : 'update_result';

        $.ajax({
            url: 'fetch-inspection-rcd-action.php',
            type: 'POST',
            dataType: 'json',
            data: {
                ir_id: ir_id, 
                result: result,
                action : ajaxAction
            },
            success: function(response) {
                if (response.success) {

                    alert('The changes have been saved.');
                
                    // run tooltip
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Show the NG modal and pass ir_id to hidden input
                    if (result === 'NG') {

                        $('#ng_ir_id').val(ir_id);
                        $('#ngModal').data('row', row);

                        const ngModal = new bootstrap.Modal(document.getElementById('ngModal'));
                        ngModal.show();
                    }

                    // reload the table (manual)
                    loadPalletTable();


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

    //Submit for review
    $(document).on('click', '.btnSubmit', function (e) {
        e.preventDefault();

        let $btn = $(this);
        let ir_id = $btn.data('irid');
        let row = $btn.closest('tr');
        let prodDate = row.find('.bt-datepicker').val();

        // --- Step 1: Confirm using Swal ---
        Swal.fire({
            title: 'Submit Inspection?',
            // html: `Submit this inspection record for review?<br>${prodDate ? '<small class="text-muted">Production Date: ' + prodDate + '</small>' : ''}`,
            text: 'Submit this inspection record for review?',
            icon: 'question',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: 'Yes, Submit',
            cancelButtonText: 'Cancel',
            confirmButtonColor: "#198754",
            reverseButtons: true
        }).then((result) => {

            if (!result.isConfirmed) return;

            // --- Step 2: Show loading BEFORE AJAX starts ---
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your submission.',
                icon: 'info',
                iconColor: "#198754",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });

            // --- Step 3: Build form data ---
            let formData = new FormData();
            formData.append('action', 'submit_for_review');
            formData.append('ir_id', ir_id);
            if (prodDate) {
                formData.append('prod_date', prodDate);
            }

            // --- Step 4: AJAX request ---
            $.ajax({
                url: 'fetch-inspection-rcd-action.php',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',

                success: function (res) {

                    if (res.success) {

                        // Show success
                        Swal.fire({
                            icon: 'success',
                            iconColor: "#286912",
                            title: 'Submitted!',
                            text: 'Your inspection record was successfully submitted.',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        // Reload table after delay
                        setTimeout(() => {
                            $('#btnFilter').trigger('click');
                        }, 600);

                    } else {
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
                            title: 'Submission Failed',
                            text: res.msg || 'The server could not process your request.'
                        });
                    }
                },

                error: function (xhr, status, error) {
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

    <script>

    //Cancel submission
    $(document).on('click', '.btnCancel', function (e) {

        e.preventDefault();
        const ir_id = $(this).data('irid') || $(this).attr('data-irid');
        $('#cancel_ir_id').val(ir_id);
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
        const remark = $('#cancel_remark').val().trim();

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing Reason',
                confirmButtonColor: '#28a745',
                text: 'Please state the reason for cancellation.',
        });
        
        $('#cancel_remark').addClass('border-error');
        return;
    }

    $('#cancel_remark').removeClass('border-error');

        Swal.fire({
            title: 'Confirm Cancellation?',
            text: 'Cancel this inspection record from submission?',
            icon: 'warning',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonText: 'Yes, Cancel it',            
            confirmButtonColor: '#28a745',
            cancelButtonText: 'No, Keep it',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {

                const $btn = $('#btnConfirmCancel');
                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Canceling...');

                $.ajax({
                    url: 'fetch-inspection-rcd-action.php',
                    type: 'POST',
                    dataType: 'json',
                    data: { action: 'cancel_record', ir_id, remark },
                    success: function(res){
                        $btn.prop('disabled', false).html('<i class="fa fa-times me-1"></i>Confirm Cancel');

                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Cancelled',
                                text: 'The record has been cancelled successfully.',
                                timer: 2500,
                                showConfirmButton: false
                            });

                            // Close modal
                            const modalEl = document.getElementById('cancelRemarkModal');
                            bootstrap.Modal.getInstance(modalEl).hide();

                            // Refresh table or reload
                            loadPalletTable();

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

    // Bulk Submit for review - selected row
    $('#btnSubmitSelected').on('click', function () {

        if (selectedIds.size === 0) {
            Swal.fire({
                title: 'Warning',
                text: "Please select at least one record.",
                icon: 'warning',
                iconColor: "#286912",
                confirmButtonColor: '#28a745'
            });
            return;
        }

        Swal.fire({
            title: 'Submit Selected?',
            text: `Submit ${selectedIds.size} record(s)?`,
            icon: 'question',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Submit'
        }).then((result) => {

            if (!result.isConfirmed) return;

            // Show loading BEFORE sending AJAX
            Swal.fire({
                title: 'Submitting...',
                text: 'Please wait while we process your submission.',
                icon: 'info',
                iconColor: "#198754",
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });

            $('#btnSubmitSelected').prop('disabled', true);

            $.ajax({
                url: 'fetch-inspection-bulk-action.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    ids: Array.from(selectedIds),
                    action: 'bulk_submit'
                },
                success: function (r) {

                    $('#btnSubmitSelected').prop('disabled', false);

                    if (r.status === 'success') {

                        Swal.fire({
                            title: 'Success',
                            text: r.message,
                            icon: 'success',
                            iconColor: "#286912",
                            confirmButtonColor: '#28a745'
                        });
                    
                        // Reload table after delay
                        setTimeout(() => {
                            $('#btnFilter').trigger('click');
                        }, 600);

                        fetchTotalCounts();

                    } else {
                        Swal.fire({
                            icon: 'error',
                            iconColor: "#286912",
                            title: 'Error',
                            text: r.message || 'Unknown error',
                            confirmButtonColor: '#28a745',
                        });
                    }
                },
                error: function (xhr) {
                    $('#btnSubmitSelected').prop('disabled', false);
                    console.error(xhr.responseText);

                    console.log("STATUS:", xhr.status);
                    console.log("RESPONSE:", xhr.responseText);

                    Swal.fire({
                        icon: 'error',
                        iconColor: "#286912",
                        title: 'Error',
                        text: 'Server error occurred',
                        confirmButtonColor: '#28a745',
                    });
                   
                }
            });

        });
    });

    // Bulk Cancel submmission - selected
    $('#btnCancelSelected').on('click', function () {

        if (selectedIds.size === 0) {
            Swal.fire({
                title: 'Warning',
                text: "Please select at least one record.",
                icon: 'warning',
                iconColor: "#286912",
                confirmButtonColor: '#28a745'
            });
            return;
        }

        $('#bulk_cancel_remark').val('');
        $('#returnCount').text(selectedIds.size);

        // $('#bulkcancelModal').modal('show');
        new bootstrap.Modal(document.getElementById('bulkcancelModal')).show();
    });

    $('#bulkcancelForm').on('submit', function (e) {
        e.preventDefault();

        let remark = $(this).find('textarea[name="remark"]').val().trim();
        // $('#btnConfirmCancelBulk').prop('disabled', true);

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing comment',
                confirmButtonColor: '#28a745',
                text: 'Please state the comment or reason.',
            });
            $('#bulk_cancel_remark').addClass('border-error');
            return;
        }
        $('#bulk_cancel_remark').removeClass('border-error');

        $.ajax({
            url: 'fetch-inspection-bulk-action.php',
            type: 'POST',
            dataType: 'json', 
            data: {
                ids: Array.from(selectedIds),
                remark: remark,
                action : 'bulk_cancel'
            },
            success: function (r) {

                $('#btnConfirmCancelBulk').prop('disabled', false);

                if (r.status === 'success') {
                    $('#bulkcancelModal').modal('hide');

                    Swal.fire({
                        title: 'Success',
                        text: r.message,
                        icon: 'success',
                        iconColor: "#286912",
                        confirmButtonColor: '#28a745'
                    });
                    
                    // Refresh table or reload
                    loadPalletTable();

                    selectedIds.clear();
                    selectedStatuses.clear();
                    $('#checkAll').prop('checked', false);
                    fetchTotalCounts();


                } else {
                    Swal.fire({
                        title: 'Error',
                        text: r.message || 'Unknown error',
                        icon: 'error'
                    });
                }
            },
            error: function (xhr) {
                $('#btnConfirmCancelBulk').prop('disabled', false);
                console.error(xhr.responseText);

                Swal.fire({
                    title: 'Error',
                    text: 'Server error occurred',
                    icon: 'error'
                });
            }
        });
    });

    </script>

    <script>

    //Reset input modal
    function resetAddDefectModal() {

        $('#fd_defectType_add').val('');
        $('input[name="fd_area_add[]"]').prop('checked', false);
        $('#imageUpload_defect').val('');
        $('#imageUpload_compare').val('');
        $('#imagePreviewContainer_defect_add').empty();
        $('#imagePreviewContainer_compare_add').empty();
        selectedFiles_defect = [];
        selectedFiles_compare = [];

    }

    </script>

</body>
</html>