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
    
	<!-- Daterange picker -->
    <link href="vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- Clockpicker -->
    <link href="vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <!-- asColorpicker -->
    <link href="vendor/jquery-ascolorpicker/css/ascolorpicker.min.css" rel="stylesheet">
    <!-- Material color picker -->
    <link href="vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
	
    <!-- Pick date -->
    <link rel="stylesheet" href="vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="vendor/pickadate/themes/default.date.css">
    
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet">
    <link href="vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">

    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
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

        .border-error {
            border: 1px solid #eb2020ff !important;   
            background-color: #faf7f9ff !important;
            color : #2D2E2D;   
        }

        .border-error:hover {
            color: #181818 !important;  
        }
        
        .dataTables_filter input {
            width: 180px !important; /* or any size you want */
            height: 35px !important;             /* optional */
            font-size: 11px !important;          /* optional */
        }

		#sortingPendingList tbody tr td:last-child {
            text-align: left !important; 
        }

        #sortingPendingList thead tr th:last-child{
            text-align: left !important;
        }

        #inspectionApprovedList tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionApprovedList thead tr th:last-child{
            text-align: left !important;
        }

        #inspectionCompletedList tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionCompletedList thead tr th:last-child{
            text-align: left !important;
        }

        /* table header, body align */
        #inspectionTable_defect tbody tr td:last-child {
            text-align: left; 
        }

        #inspectionTable_defect thead tr th:last-child {
            text-align: left !important; 
        }

        .date-table thead tr th{
            font-size: 12px; /* or 14px, 13px, etc. */
            background-color :#E9ECEF !important; 
        }

        .date-table td {
            font-size: 12px; /* or 14px, 13px, etc. */
        }

        .date-table td h6 {
            font-size: 12px;
        }

        .date-table td span {
            font-size: 12px;
        }

        #detailModal h5 {
            font-size: 13px;
        }

        #detailModal .table th {
            font-size: 13px;
        }

        #detailModal .table td {
            font-size: 13px;
        }

        #detailModal .s-date span {
            font-size: 10px;
        }

        .zoomable-img {
            cursor: pointer;       /* Show hand on hover */
            position: relative;    /* Make sure it's clickable */
            z-index: 10;           /* Bring it above wrappers */
            pointer-events: auto;  /* Ensure clicks pass through */
        }

        .bg-custom-header {
            background-color: #F2F5F0; 
            border-radius: 8px;
            padding: 10px;
            color: #333;
        }

        .bg-custom-foot {
            background-color: #F2F5F0; 
            color: #333;
        }
 
        .small-text {
            font-size: 11px; /* or 12px, etc. */
        }

        .doc-text {
            font-size: 12px; /* or 12px, etc. */
        }

       .widget-timeline-icons ul.timeline {
            padding-left: 0 !important;
            margin-left: 0 !important;
        }

        #remarkModal .modal-dialog {
            margin-top: -140px;   /* adjust distance from top */
            margin-right: 50px;
        }

        .bg-light-green {
            background-color: #E5EDE4; /* soft green background */
            border-radius: 6px;
        }

        #remarkContent {
            white-space: pre-wrap; /* support long text and line breaks */
        }

        .content-info
        {
            border-radius: 8px;
            background: #f8f9fa; 
            padding: 8px 12px;
            border: 1px solid #eee7e7ff;
        }

        .tooltip .tooltip-inner {
            /* background-color: #333 !important;
            color: #fff; */
            max-width: 220px;
            white-space: pre-wrap;
        }

        .table-tip {
            font-size: 11px;
            margin-bottom: 6px;
            color: #6c757d;
        }

        .modal-header {
            border-bottom: none !important;
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

        .avatar-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px; /* small spacing between photos */
        }

        .avatar-list img {
            display: inline-block;
            margin-right: -8px; /* create overlapping circle effect */
            border: 2px solid #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .avatar-lg-custom {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #fff;
        }

        .zoomable-photo {
            cursor: zoom-in; /* shows hand cursor */
            transition: transform 0.15s ease-in-out;
        }

        .zoomable-photo:hover {
            transform: scale(1.32); /* optional: subtle zoom effect on hover */
        }

        #relatedPartDept thead th {
            font-size: 12px;
        }

        #relatedPartVendor thead th {
            font-size: 12px;
        }

        #relatedPartCustomer thead th {
            font-size: 12px;
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

        textarea:disabled,
        textarea[readonly] {
            background-color: #FBFCFA !important;
            border-color: #d6d3d3ff !important;
            color: #999 !important;
            cursor: not-allowed;
        }

        #remarkModal .modal-content {
            border-radius: 10px;
        }
        #remarkModal .modal-header {
            border-bottom: none;
        }

        /* Custom header background */
        .accordion-header-bg-custom .accordion-button {
            background-color: #EDEBE8;        /* light grey background */
            color: #222;                      /* text color */
            font-weight: 500;                 /* make it stand out */
        }

        /* When expanded */
        .accordion-header-bg-custom .accordion-button:not(.collapsed) {
            background-color: #CCC7BC;        /* soft blue when open */
            color: #222;
            border-color : #CCC7BC;
        }

        /* Remove Bootstrap shadow focus ring for cleaner look */
        .accordion-header-bg-custom .accordion-button:focus {
            box-shadow: none;
        }

        .bg-primary-light
        {
            background-color: #DEE0DE !important; 
        }

        #tabPartInvolve,
        #tabPartInvolve .accordion,
        #tabPartInvolve .accordion-item{
            width: 100%;
            float: none !important;
            clear: both !important;
            display: block !important;
        }

        .text-end
        {
            margin-bottom: 0;
        }

        </style>

        <?php

        $edocno = $_GET['docno'] ?? "";
        $epg = $_GET['pg'] ?? "";

        //get ir_id
        $stmt = $db_con->prepare("SELECT R.ir_id, S.sr_id, S.sr_status
                                    FROM inspection_sorting S 
                                        LEFT JOIN inspection_records R ON R.ir_id = S.sr_ir_id
                                            WHERE S.sr_docno = ?");
        $stmt->bind_param('s', $edocno);
        $stmt->execute();
        $sortingdet = $stmt->get_result()->fetch_assoc();
        
        $eir_id = $sortingdet['ir_id'];
        $esr_id = $sortingdet['sr_id'];
        $esr_status = $sortingdet['sr_status'];

        $sidemenu = ($epg == 'c') ? $side_menu8 : $side_menu9;

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

                <input type="hidden" id="hidden_ir_id" value="<?= $eir_id ?? '' ?>">
                <input type="hidden" id="hidden_sr_id" value="<?= $esr_id ?? '' ?>">
                <input type="hidden" id="hidden_docno" value="<?= htmlspecialchars($_GET['docno'] ?? '') ?>">
                <input type="hidden" id="hidden_status" value="">

                <div class="row">

                    <!-- LEFT -->
                    <div class="col-xl-9 col-xxl-9">

                        <div class="card">
                            <div class="card-header py-3 d-block d-sm-flex">
                                <h4 class="heading mb-0"><p class="text-muted mb-0 small-text">Document no</p><span class="doc-text"><?=$edocno;?></span></h4>
                                <ul class="nav nav-pills mt-3 mt-sm-0 mix-profile-tab" id="myTab" role="tablist">
                                    <li class="nav-item ms-1" role="presentation">
                                        <button class="nav-link active" id="week-tab3" data-bs-toggle="tab" data-bs-target="#tabSorting" type="button" role="tab" aria-selected="true"> <i class="fa fa-plus-circle me-1" aria-hidden="true"></i> Sorting</button>
                                    </li>
                                    <li class="nav-item ms-1" role="presentation">
                                        <button class="nav-link" id="month-tab3" data-bs-toggle="tab" data-bs-target="#tabPartInvolve" type="button" role="tab" aria-selected="false" tabindex="-1"><i class="fa fa-list me-1" aria-hidden="true"></i> Part Involve</button>
                                    </li>
                                </ul>
                            </div>
                            <div class="card-body">

                                <div class="tab-content" id="myTabContent">

                                    <div class="tab-pane fade show active" id="tabSorting" role="tabpanel">
                                        <div id="sortingDetailContainer">
                                            <div class="text-center py-2 text-muted">
                                                <i class="fa fa-spinner fa-spin me-2"></i> Loading sorting details...
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane fade" id="tabPartInvolve" role="tabpanel" aria-labelledby="month-tab3" tabindex="0">

                                        <div class="accordion" id="accordionExample">

                                            <!-- 1. Department -->
                                            <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-4 p-0">
                                                <h2 class="accordion-header" id="headingTwo">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                                        RELATED LOOSE PART INVOLVE - In House Part
                                                    </button>
                                                </h2>

                                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive mb-2">
                                                            <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="relatedPartDept">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Related Dept</th>
                                                                        <th>Type of Part</th>
                                                                        <th>Part Number</th>
                                                                        <th>Part Name</th>
                                                                        <th>Qty OK</th>
                                                                        <th>Qty NG</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $stmt = $db_con->prepare("
                                                                                SELECT p.srp_qty_ok_dept, p.srp_qty_ng_dept,
                                                                                m.bom, m.bomdesc,
                                                                                d.rd_dept_name,
                                                                                e.tp_partname
                                                                                FROM inspection_sorting_related_part_dept p
                                                                                LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
                                                                                LEFT JOIN related_departments d ON p.srp_related_dept = d.rd_dept_id
                                                                                LEFT JOIN type_part e ON p.srp_type_part_dept = e.tp_partid
                                                                                WHERE p.srp_ir_id_dept = ? and p.srp_ir_id_sorting = ?
                                                                            ");
                                                                    $stmt->bind_param("ii", $eir_id, $esr_id);
                                                                    $stmt->execute();
                                                                    $res = $stmt->get_result();

                                                                    if ($res->num_rows > 0) {
                                                                        while ($row = $res->fetch_assoc()) {
                                                                    ?>

                                                                    <tr>
                                                                        <td><?=$row['rd_dept_name'] ?></td>
                                                                        <td><?=$row['tp_partname'] ?></td>
                                                                        <td><?=$row['bom'] ?></td>
                                                                        <td><?=$row['bomdesc'] ?></td>
                                                                        <td><?=$row['srp_qty_ok_dept'] ?></td>
                                                                        <td><?=$row['srp_qty_ng_dept'] ?></td>
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    } else {
                                                                        echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 2. Vendor -->
                                            <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-4 p-0">
                                                <h2 class="accordion-header" id="headingThree">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseThree">
                                                        RELATED LOOSE PART INVOLVE - Vendor
                                                    </button>
                                                </h2>

                                                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <div class="table-responsive mb-2">
                                                            <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="relatedPartVendor">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Related Vendor</th>
                                                                        <th>Type of Part</th>
                                                                        <th>Part Number</th>
                                                                        <th>Part Name</th>
                                                                        <th>Qty OK</th>
                                                                        <th>Qty NG</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    $stmt = $db_con->prepare("
                                                                                SELECT p.srp_qty_ok_vdr, p.srp_qty_ng_vdr,
                                                                                m.bom, m.bomdesc,
                                                                                d.rv_vendor_name,
                                                                                e.tp_partname
                                                                                FROM inspection_sorting_related_part_vendor p
                                                                                LEFT JOIN material_details m ON p.srp_mathdr_id_vdr = m.matdet_id
                                                                                LEFT JOIN related_vendors d ON p.srp_related_vdr = d.rv_vendor_id
                                                                                LEFT JOIN type_part e ON p.srp_type_part_vdr = e.tp_partid
                                                                                WHERE p.srp_ir_id_vdr = ? and p.srp_ir_id_sorting = ?
                                                                            ");
                                                                    $stmt->bind_param("ii", $eir_id, $esr_id);
                                                                    $stmt->execute();
                                                                    $res = $stmt->get_result();

                                                                    if ($res->num_rows > 0) {
                                                                        while ($row = $res->fetch_assoc()) {
                                                                    ?>
                                                                    <tr>
                                                                        <td><?=$row['rv_vendor_name'] ?></td>
                                                                        <td><?=$row['tp_partname'] ?></td>
                                                                        <td><?=$row['bom'] ?></td>
                                                                        <td><?=$row['bomdesc'] ?></td>
                                                                        <td><?=$row['srp_qty_ok_vdr'] ?></td>
                                                                        <td><?=$row['srp_qty_ng_vdr'] ?></td>
                                                                    </tr>
                                                                    <?php
                                                                        }
                                                                    } else {
                                                                        echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 3. Customer -->
                                            <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-4 p-0">
                                                <h2 class="accordion-header" id="headingFour">
                                                    <button class="accordion-button collapsed" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseFour">
                                                        FINISHED GOODS PART INVOLVE - Customer
                                                    </button>
                                                </h2>

                                                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                                    data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="relatedPartCustomer" style="width:600px">
                                                            <thead>
                                                                <tr>
                                                                    <th>Related Customer</th>
                                                                    <th>Qty OK</th>
                                                                    <th>Qty NG</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php
                                                                $stmt = $db_con->prepare("
                                                                            SELECT p.srp_qty_ok_cust, p.srp_qty_ng_cust,
                                                                            d.rc_cust_name
                                                                            FROM inspection_sorting_related_part_cust p
                                                                            LEFT JOIN related_customers d ON p.srp_related_cust = d.rc_cust_id
                                                                            WHERE p.srp_ir_id_cust = ? and p.srp_ir_id_sorting = ?
                                                                        ");
                                                                $stmt->bind_param("ii", $eir_id, $esr_id);
                                                                $stmt->execute();
                                                                $res = $stmt->get_result();

                                                                if ($res->num_rows > 0) {
                                                                    while ($row = $res->fetch_assoc()) {
                                                                ?>
                                                                <tr>
                                                                    <td><?=$row['rc_cust_name'] ?></td>
                                                                    <td><?=$row['srp_qty_ok_cust'] ?></td>
                                                                    <td><?=$row['srp_qty_ng_cust'] ?></td>
                                                                </tr>
                                                                <?php
                                                                    }
                                                                } else {
                                                                    echo "<tr><td colspan='4' class='text-center text-danger'>No record</td></tr>";
                                                                }
                                                                ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div><!-- end accordion -->

                                    </div><!-- end tabPartInvolve -->


                                </div> <!-- end tab-content -->

                            </div>
                        </div>

                    </div> <!-- end LEFT col -->

                    <!-- RIGHT -->
                    <div class="col-xl-3 col-xxl-3">
                        <!-- Timeline -->
                        <div class="recent-post"></div>
                    </div>

                </div> 
                <!-- end row -->

                <!-- Modal for image zoom -->
                <div class="modal fade" id="imgZoomModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content" style="background: transparent; border: none;">
                            <img src="" id="zoomedImg" class="img-fluid rounded shadow" style="display:block;max-width: 60vw; max-height: 80vh; margin:auto; border-radius: 12px;">
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

    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>    
    <script src="js/highlight.min.js"></script>    
    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>

    <script>
    // document.getElementById('btnBack').addEventListener('click', function () {
    //     window.location.href = "ip-sorting-pendingreview.php";
    // });
    </script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {

        const epage = "<?= $epg ?>"; 
        
        // Compare and redirect
        if ( epage === 'c') {
            window.location.href = "ip-sorting-approved.php";
        } else {
            window.location.href = "ip-sorting-pendingreview-pre.php";
        }
    });

    </script>
    
    <script>
	$(function () {
		$('[data-bs-toggle="tooltip"]').tooltip(); // run on page load

		// run again after table draw
		$('#sortingPendingList').on('draw.dt', function () {
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});
	</script>

    <script>
    
    const eir_id = "<?= $eir_id ?>";
    const esr_id = "<?= $esr_id ?>";
    const esr_status = "<?= $esr_status ?>";

    // Load mateiral details
    $(document).ready(function () {
        if (eir_id) {
            loadMaterialDetails(eir_id);
        }
    });

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

    </script>

    <script>

    $(document).ready(function() {
        const docno = $("#hidden_docno").val();

        if (!docno) {
            $("#sortingDetailContainer").html("<div class='alert alert-danger'>Missing document number.</div>");
            return;
        }

        // Fetch all details when page first loads
        fetchSortingDetails(docno);
    });

    function fetchSortingDetails(docno) {
        $.ajax({
            url: "fetch-ip-sorting-pending.php",
            type: "POST",
            dataType: "json",
            data: { action: "fetch_details", docno: docno  },
            success: function(res) {
                if (res.success && res.data) {
                    renderSortingDetails(res.data);

                    const d = res.data;

                    // store status
                    $("#hidden_status").val(d.sr_status);

                    // disable textarea if approved or reviewed
                    if (d.sr_status == 4 || d.sr_status == 12) {
                        $("#approval_remark")
                            .prop("disabled", true)
                            .css({ "background-color": "#FBFCFA", "color": "#555" });
                        $(".btnApprove, .btnReturn").hide();
                    } else {
                        $("#approval_remark")
                            .prop("disabled", false)
                            .css({ "background-color": "#fff", "color": "#333" });
                        $(".btnApprove, .btnReturn").show();
                    }

                } else {
                    $("#sortingDetailContainer").html("<div class='alert alert-warning'>No record found for this document.</div>");
                }
            },
            error: function() {
                $("#sortingDetailContainer").html("<div class='alert alert-danger'>Failed to load details.</div>");
            }
        });
    }
   
    function renderSortingDetails(d) {
        let beforeHTML = '';
        let afterHTML = '';

        if (d.before_photos) {
            d.before_photos.split(',').forEach(photo => {
                beforeHTML += `
                    <img src="gallery/inspection_sorting/before/${d.sr_id}/${photo.trim()}"
                        class="avatar avatar-lg-custom rounded-circle zoomable-photo"
                        data-src="gallery/inspection_sorting/before/${d.sr_id}/${photo.trim()}"
                        alt="Before Photo">
                `;
            });
        } else {
            beforeHTML = `<span class="text-muted fs-13">No photo available</span>`;
        }

        if (d.after_photos) {
            d.after_photos.split(',').forEach(photo => {
                afterHTML += `
                    <img src="gallery/inspection_sorting/after/${d.sr_id}/${photo.trim()}"
                        class="avatar avatar-lg-custom rounded-circle zoomable-photo"
                        data-src="gallery/inspection_sorting/after/${d.sr_id}/${photo.trim()}"
                        alt="After Photo">
                `;
            });
        } else {
            afterHTML = `<span class="text-muted fs-13">No photo available</span>`;
        }

        // Decide which remark to show based on status
        let remarkText = '';
        if (d.sr_status == 11) {
            remarkText = d.approved_remark || ''; // reviewed remark
        } else if (d.sr_status == 12) {
            remarkText = d.returned_remark || ''; // returned remark
        } else {
            remarkText = d.approved_remark || ''; // default (e.g. before approved)
        }

        let html = `
           

                <div class="d-md-flex d-none flex-wrap mb-3">
                    <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
                        <div class="avatar avatar-md style-1 bg-redd text-black rounded d-flex align-items-center justify-content-center">                                                       
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                            <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0"/>
                            </svg>
                        </div>
                        <div class="clearfix ms-2">
                            <h3 class="mb-0 fw-semibold lh-1 fs-16">${d.sr_qty_ok || '-'}</h3>
                            <span class="fs-13">Qty OK</span>
                        </div>
                    </div>
                    <div class="border outline-dashed rounded p-2 d-flex align-items-center me-3 mt-3">
                        <div class="avatar avatar-md style-1 bg-redd text-black rounded d-flex align-items-center justify-content-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                            </svg>
                        </div>
                        <div class="clearfix ms-2">
                            <h3 class="mb-0 fw-semibold lh-1 fs-16">${d.sr_qty_ng || '-'}</h3>
                            <span class="fs-13">Qty NG</span>
                        </div>
                    </div>
                    <div class="clearfix mt-0 mt-xl-0 ms-auto d-flex flex-column col-xl-3">
                        <div class="clearfix mb-3 text-xl-end">
                            <span class="badge badge-pill badge-redd text-black">${d.statusname}</span>
                        </div>
                    </div>
                </div>
                
                <div class="row g-4 mt-2">

                    <!-- ========================================== -->
                    <!-- LEFT COLUMN -->
                    <!-- ========================================== -->
                    <div class="col-md-6">

                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-sync-alt"></i> Sorting Method 
                            </h6>
                           <p class="content-info">${d.sr_sorting_method ? d.sr_sorting_method.replace(/\n/g, '<br>') : '-'} </p>
                        </div>

                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-tools"></i> Rework Method
                            </h6>
                            <p class="content-info">${d.sr_rework_method ? d.sr_rework_method.replace(/\n/g, '<br>') : '-'} </p>
                        </div>

                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-comment-alt"></i> Remarks
                            </h6>
                            <p class="content-info">${d.sr_remarks ? d.sr_remarks.replace(/\n/g, '<br>') : '-'} </p>
                        </div>

                    </div>

                    <!-- ========================================== -->
                    <!-- RIGHT COLUMN -->
                    <!-- ========================================== -->
                    <div class="col-md-6">

                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-image"></i> Photos Before (NG)
                            </h6>

                            <div class="photo-box avatar-list avatar-list-stacked ms-3 mt-4">${beforeHTML}</div>
                        </div>

                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-image"></i> Photos After Sorting (OK)
                            </h6>

                            <div class="photo-box avatar-list avatar-list-stacked ms-3 mt-4">${afterHTML}</div>
                        </div>

                        <div class="s2w-section">
                            <h6 class="section-title">
                                <i class="fa fa-commenting"></i> Comment/Reason
                            </h6>
                            <textarea class="form-control" id="approval_remark" readonly>${remarkText || ''}</textarea>
                        </div>

                    </div>

                </div>
            
        `;

        $("#sortingDetailContainer").html(html);

        // --- Hide Approve & Return if status = 11 or 12 ---
        if (d.esr_status == 11 || d.esr_status == 12) {
            $(".btnApprove, .btnReturn").hide();
            $("#approval_remark").prop("disabled", true);
        }

        // reinitialize tooltips and zoom
        $('[data-bs-toggle="tooltip"]').tooltip();
    }

    </script>

    <script>

    $(document).on('click', '.zoomable-photo', function () {
        const imgSrc = $(this).data('src');
        $('#zoomedImg').attr('src', imgSrc);
        $('#imgZoomModal').modal('show');
    });

    </script>

    <script>

    // Approve
    $(document).on('click', '.btnApprove', function () {

        const docno = $("#hidden_docno").val();
        const ir_id = eir_id;
        const sr_id = esr_id;
        const remark = $('#approval_remark').val().trim();

        // if (!remark) {
        //     Swal.fire('Missing Input', 'Please enter your comment or reason before approving.', 'warning');
        //     $('#approval_remark').addClass('border-error');
        //     return;
        // } else {
        //     $('#approval_remark').removeClass('border-error');
        // }

        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to approve this sorting report?",
            icon: 'question',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, approve it'
        }).then((result) => {
            if (result.isConfirmed) {

                const $btn = $('.btnApprove');
                $btn.prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-2"></span>Approving...');

                $.ajax({
                    url: 'fetch-ip-sorting-pending.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'approve_sorting',
                        ir_id: ir_id,
                        sr_id: sr_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        $btn.prop('disabled', false)
                            .html('<i class="fa fa-check me-2"></i> Approve');

                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Approved',
                                text: 'Sorting report approved successfully.',
                                timer: 2000,
                                showConfirmButton: false,
                                willClose: () => {
                                    // Fade out Approve button
                                    $('.btnApprove').fadeOut(300);
                                    $('.btnReturn').fadeOut(300);

                                    // reload after 0.5s to ensure DB committed
                                    setTimeout(() => {
                                        fetchSortingDetails(docno);  // reload updated status and remarks
                                        loadTimeline(ir_id, sr_id);  // refresh timeline
                                    }, 700);    
                                }
                                
                            }).then(() => {
                                // redirect to view page or reload list
                                window.location.href = 'ip-sorting-pendingreview.php';
                            });
                            
                        } else {
                            Swal.fire('Error', res.message || 'Approval failed.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server error while approving.', 'error');
                    }
                });
            }
        });
    });

    //Return
    $(document).on('click', '.btnReturn', function () {

        const docno = $("#hidden_docno").val();
        const ir_id = eir_id;
        const sr_id = esr_id;
        const remark = $('#approval_remark').val().trim();

        if (!remark) {
            Swal.fire({
                icon: 'warning',
                iconColor: "#286912",
                title: 'Missing Reason',
                text: 'Please state comment/ reason.',
            });
            $('#approval_remark').addClass('border-error');
            return;
        }

        $('#approval_remark').removeClass('border-error');

        Swal.fire({
            title: 'Confirm Return?',
            text: "Do you want to return this sorting report?",
            icon: 'question',
            iconColor: "#286912",
            showCancelButton: true,
            confirmButtonColor: '#28a745',
            confirmButtonText: 'Yes, return it'
        }).then((result) => {
            if (result.isConfirmed) {

                const $btn = $('.btnReturn');
                $btn.prop('disabled', true)
                    .html('<span class="spinner-border spinner-border-sm me-2"></span>Approving...');

                $.ajax({
                    url: 'fetch-ip-sorting-pending.php',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        action: 'return_sorting',
                        ir_id: ir_id,
                        sr_id: sr_id,
                        approval_remark: remark
                    },
                    success: function (res) {
                        $btn.prop('disabled', false)
                            .html('<i class="fa fa-check me-2"></i> Return');

                        if (res.success) {
                            Swal.fire({
                                icon: 'success',
                                iconColor: "#286912",
                                title: 'Return',
                                text: 'Sorting report returned successfully.',
                                timer: 2000,
                                showConfirmButton: false,
                                willClose: () => {
                                    // Fade out Approve button
                                    $('.btnApprove').fadeOut(300);
                                    $('.btnReturn').fadeOut(300);

                                    // reload after 0.5s to ensure DB committed
                                    setTimeout(() => {
                                        fetchSortingDetails(docno);  // reload updated status and remarks
                                        loadTimeline(ir_id, sr_id);  // refresh timeline
                                    }, 700);
                                    
                                }
                            });
                            
                        } else {
                            Swal.fire('Error', res.message || 'Approval failed.', 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('Error', 'Server error while approving.', 'error');
                    }
                });
            }
        });
    });

    </script>

    <script>

    $(document).ready(function() {
        const ir_id = $("#hidden_ir_id").val();  // or however you store it
        const sr_id = $("#hidden_sr_id").val();

        loadTimeline(ir_id, sr_id);
    });

    function loadTimeline(ir_id, sr_id) {
        $.ajax({
            url: "fetch-timeline.php",
            type: "POST",
            data: { 
                ir_id: ir_id, 
                sr_id: sr_id,
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
                $('[data-bs-toggle="tooltip"]').tooltip();
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

    <script>

    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

    </script>

</body>
</html>