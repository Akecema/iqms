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
    <link href="css/badge.css" rel="stylesheet">    

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

		<?php

        $eir_id = $_GET['erid'] ?? null;
        $ir_result = '';
        $sorting_data = null;
        $s2w_data = null;
        $before_photos = [];
        $after_photos = [];
        $s2w_defect_photos = [];
        $s2w_ok_photos = [];
        $s2w_reply_data = null;
        $s2w_correction_photos = [];
        $s2w_preventive_photos = [];
        $inhouse_parts = [];
        $vendor_parts = [];
        $customer_parts = [];

        if ($eir_id) {

            $eir_id_clean = mysqli_real_escape_string($db_con, $eir_id);
            
            // Fetch Result
            $sql_res = "SELECT ir_result FROM inspection_records WHERE ir_id = '$eir_id_clean'";
            $res_query = mysqli_query($db_con, $sql_res);
            $row_res = mysqli_fetch_assoc($res_query);
            $ir_result = $row_res['ir_result'] ?? '';

            // Fetch Sorting Data (sr_status = 5)
            $sql_sorting = "SELECT s.*, 
                            c.staff_name AS created_by_name, 
                            sub.staff_name AS submitted_by_name, 
                            r.staff_name AS approved_by_name 
                            FROM inspection_sorting s
                            LEFT JOIN employee_details c ON s.created_by = c.staff_id
                            LEFT JOIN employee_details sub ON s.submitted_by = sub.staff_id
                            LEFT JOIN employee_details r ON s.approved_by = r.staff_id
                            WHERE s.sr_ir_id = '$eir_id_clean' AND s.sr_status = 5";
            $res_sorting = mysqli_query($db_con, $sql_sorting);

            if ($res_sorting && mysqli_num_rows($res_sorting) > 0) {

                $sorting_data = mysqli_fetch_assoc($res_sorting);
                $sr_id = $sorting_data['sr_id'];

                // Fetch Photos Before (NG)
                $sql_before = "SELECT * FROM inspection_sorting_before_photo WHERE sr_ir_id = '$eir_id_clean' AND sr_sorting_id = '$sr_id'";
                $res_before = mysqli_query($db_con, $sql_before);
                while ($row = mysqli_fetch_assoc($res_before)) {
                    $before_photos[] = $row['before_photo'];
                }

                // Fetch Photos After Sorting (OK)
                $sql_after = "SELECT * FROM inspection_sorting_after_photo WHERE sr_ir_id = '$eir_id_clean' AND sr_sorting_id = '$sr_id'";
                $res_after = mysqli_query($db_con, $sql_after);
                while ($row = mysqli_fetch_assoc($res_after)) {
                    $after_photos[] = $row['after_photo'];
                }

                // Fetch Related Inhouse Part
                $sql_inhouse = "SELECT p.*, d.rd_dept_name, t.tp_partname, m.bom, m.bomdesc 
                                FROM inspection_sorting_related_part_dept p
                                LEFT JOIN related_departments d ON p.srp_related_dept = d.rd_dept_id
                                LEFT JOIN type_part t ON p.srp_type_part_dept = t.tp_partid
                                LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
                                WHERE p.srp_ir_id_sorting = '$sr_id'";
                $res_inhouse = mysqli_query($db_con, $sql_inhouse);
                while ($row = mysqli_fetch_assoc($res_inhouse)) {
                    $inhouse_parts[] = $row;
                }

                // Fetch Related Vendor Part
                $sql_vendor = "SELECT p.*, v.rv_vendor_name, t.tp_partname, m.bom, m.bomdesc 
                               FROM inspection_sorting_related_part_vendor p
                               LEFT JOIN related_vendors v ON p.srp_related_vdr = v.rv_vendor_id
                               LEFT JOIN type_part t ON p.srp_type_part_vdr = t.tp_partid
                               LEFT JOIN material_details m ON p.srp_mathdr_id_vdr = m.matdet_id
                               WHERE p.srp_ir_id_sorting = '$sr_id'";
                $res_vendor = mysqli_query($db_con, $sql_vendor);
                while ($row = mysqli_fetch_assoc($res_vendor)) {
                    $vendor_parts[] = $row;
                }

                 // Fetch Related Customer Part
                 $sql_customer = "SELECT p.*, c.rc_cust_name 
                                  FROM inspection_sorting_related_part_cust p
                                  LEFT JOIN related_customers c ON p.srp_related_cust = c.rc_cust_id
                                  WHERE p.srp_ir_id_sorting = '$sr_id'";
                 $res_customer = mysqli_query($db_con, $sql_customer);
                 while ($row = mysqli_fetch_assoc($res_customer)) {
                     $customer_parts[] = $row;
                 }
             }
             
             // Fetch S2W Data
             $sql_s2w = "SELECT s.*, d.rd_dept_name, 
                         c.staff_name AS created_by_name, 
                         sub.staff_name AS submitted_by_name, 
                         rv.staff_name AS reviewed_by_name, 
                         ap.staff_name AS approved_by_name
                         FROM inspection_s2w s
                         LEFT JOIN related_departments d ON s.s2w_send_to = d.rd_dept_id
                         LEFT JOIN employee_details c ON s.created_by = c.staff_id
                         LEFT JOIN employee_details sub ON s.submitted_by = sub.staff_id
                         LEFT JOIN employee_details rv ON s.reviewed_by = rv.staff_id
                         LEFT JOIN employee_details ap ON s.approved_by = ap.staff_id
                         WHERE s.s2w_ir_id = '$eir_id_clean'";
             $res_s2w = mysqli_query($db_con, $sql_s2w);
             
             if ($res_s2w && mysqli_num_rows($res_s2w) > 0) {
                 $s2w_data = mysqli_fetch_assoc($res_s2w);
                 $s2w_id = $s2w_data['s2w_id'];
                 $s2w_sr_id = $s2w_data['s2w_sr_id'];

                 // Fetch S2W Defect Photos
                 $sql_s2w_defect = "SELECT * FROM inspection_s2w_defect_photo WHERE s2w_ir_id = '$eir_id_clean' AND s2w_id = '$s2w_id'";
                 $res_s2w_defect = mysqli_query($db_con, $sql_s2w_defect);
                 while ($row = mysqli_fetch_assoc($res_s2w_defect)) {
                     $s2w_defect_photos[] = $row['defect_photo'];
                 }

                 // Fetch S2W OK Photos
                 $sql_s2w_ok = "SELECT * FROM inspection_s2w_ok_photo WHERE s2w_ir_id = '$eir_id_clean' AND s2w_id = '$s2w_id'";
                 $res_s2w_ok = mysqli_query($db_con, $sql_s2w_ok);
                 while ($row = mysqli_fetch_assoc($res_s2w_ok)) {
                     $s2w_ok_photos[] = $row['ok_photo'];
                 }
             }

             // Fetch S2W Reply Data
             $sql_s2w_reply = "SELECT rp.*,
                         c.staff_name AS created_by_name, 
                         sub.staff_name AS submitted_by_name, 
                         ap.staff_name AS approved_by_name
                         FROM inspection_s2w_report rp
                         LEFT JOIN employee_details c ON rp.created_by = c.staff_id
                         LEFT JOIN employee_details sub ON rp.submitted_by = sub.staff_id
                         LEFT JOIN employee_details ap ON rp.approved_by = ap.staff_id
                         WHERE rp.rp_s2w_ir_id = '$eir_id_clean'";
             $res_s2w_reply = mysqli_query($db_con, $sql_s2w_reply);
             
             if ($res_s2w_reply && mysqli_num_rows($res_s2w_reply) > 0) {
                 $s2w_reply_data = mysqli_fetch_assoc($res_s2w_reply);
                 $s2w_rp_id = $s2w_reply_data['rp_id'];
                 
                 // Fetch S2W Correction Photos
                 $sql_s2w_correction = "SELECT * FROM inspection_s2w_correction_photo WHERE s2w_rp_id = '$s2w_rp_id'";
                 $res_s2w_correction = mysqli_query($db_con, $sql_s2w_correction);
                 while ($row = mysqli_fetch_assoc($res_s2w_correction)) {
                     $s2w_correction_photos[] = $row['correction_photo'];
                 }

                 // Fetch S2W Preventive Photos
                 $sql_s2w_preventive = "SELECT * FROM inspection_s2w_preventive_photo WHERE s2w_rp_id = '$s2w_rp_id'";
                 $res_s2w_preventive = mysqli_query($db_con, $sql_s2w_preventive);
                 while ($row = mysqli_fetch_assoc($res_s2w_preventive)) {
                     $s2w_preventive_photos[] = $row['preventive_photo'];
                 }
             }
         }

         $tabDisabled = ($ir_result == 'OK') ? 'disabled' : '';

         ?>

        <style>

        h5 { 
            font-size: 13px; 
            font-weight : 500;
        }

        .card-title
        {
            font-size : 13px;
            font-weight : 500;
            color : #1B801B;
        }

        #tbl-pdi-inspection thead tr th{
            text-align: left !important; 
            font-size : 12px;
        }

        #tbl-pdi-inspection tbody tr td:last-child{
            text-align: left !important; 
        }

        #tbl-related-inhouse thead tr th{
            text-align: left !important; 
            font-size : 12px;
        }

        #tbl-related-vendor thead tr th{
            text-align: left !important; 
            font-size : 12px;
        }

        #tbl-related-customer thead tr th{
            text-align: left !important; 
            font-size : 12px;
        }

        #tbl-related-customer tbody tr td:last-child{
            text-align: left !important; 
        }

        .inspection, .inspection-defect {
            background: #fafcfbff;
            padding: 2.5rem;
            border-radius: 1rem;
            border: 1px solid #e1e9f4;
            margin-top: 1rem;
        }

        .avatar-list {
            display: flex;
            flex-wrap: wrap;
            gap: 5px; /* small spacing between photos */
        }

        .avatar-list img {
            display: inline-block;
            margin-right: -8px; /* create overlapping circle effect */
            border: 2px solid #f3f1f1ff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            object-fit: cover;
        }

        .fs-activity
        {
            font-size : 12px;
        }

        .nav-link.disabled {
            pointer-events: none;
            cursor: default;
            color: #999 !important;
        }

        .custom-tab-1 .nav-tabs .nav-link {
            font-size : 12px;
            color : #4f4c4cff;
        }

        .custom-tab-1 .nav-tabs .nav-link.active {
            background-color: transparent !important;
            font-weight : 600;
            font-size : 14px;
            color : #000;
        }

        .post-title h5 {
            font-weight : 600;
            font-size : 13px;
        }

        .bg-light-green {
            background-color: #E5EDE4;
            border-radius: 6px;
        }

        .text-created
        {
            font-weight : 500;
            font-size : 14px;
            color : #950a0aff;
        }

        .text-submitted
        {
            font-weight : 500;
            font-size : 14px;
            color : #2e6308ff;
        }

        .text-reviewed
        {
            font-weight : 500;
            font-size : 14px;
            color : #774f08ff;
        }

        .text-muted-appv
        {
            color : #929491ff;
        }

        .widget-timeline-icons ul.timeline {
             padding-left: 0 !important;
             margin-left: 0 !important;
         }

        </style>

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
                        <?=$side_menu_report;?> <?=$side_menu_report2; ?>
                    </div>
                </div>

                <!-- row -->                
                <div class="row">
                    <div class="col-xl-4">
						<div class="row">                             
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
                                        <h5 class="text-primary d-inline mb-4">Finished Goods Details</h5>

                                        <!-- Material Details -->
										<div id="material_product_detail"></div>
									</div>
								</div>
							</div>                           
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">										
                                        <h5 class="text-primary d-inline">Finished Goods Gallery</h5>

                                        <!-- Images Material  -->
                                        <div class="row mt-4 sp4" id="lightgallery"></div>										
									</div>
								</div>
							</div>
							<!-- <div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										
									</div>
								</div>
							</div> -->
						</div>
                    </div>
                    <div class="col-xl-8">
                        <div class="card h-auto">
                            <div class="card-body">
                                <div class="view-S2W-Reply">
                                    <div class="custom-tab-1">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a href="#view-PDI?erid=<?=$eir_id;?>" data-bs-toggle="tab" class="nav-link">PDI</a>  </li>
                                            <li class="nav-item"><a href="#view-Sorting?erid=<?=$eir_id;?>" data-bs-toggle="tab" class="nav-link">Sorting</a></li>
                                            <li class="nav-item"><a href="#view-S2W?erid=<?=$eir_id;?>" data-bs-toggle="tab" class="nav-link">S2W</a></li>
                                            <li class="nav-item"><a href="#view-S2W-Reply?erid=<?=$eir_id;?>" data-bs-toggle="tab" class="nav-link active show">S2W Reply</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            
                                            <!-- PDI -->
                                            <div id="view-PDI?erid=<?=$eir_id;?>" class="tab-pane fade">
                                                <div class="my-post-content pt-3 mb-4">
                                                    
                                                        <style>
                                                            .btn-outline-custom {
                                                                background: #fff;
                                                                border: 1px solid #d1d3e2;
                                                                color: #3f4340ff;
                                                                padding: 5px 12px;
                                                                font-size: 12px;
                                                                font-weight: 500;
                                                                border-radius: 4px;
                                                                display: inline-flex;
                                                                align-items: center;
                                                                gap: 6px;
                                                                text-decoration: none;
                                                                transition: all 0.2s;
                                                            }
                                                            .btn-outline-custom:hover {
                                                                background: #f8f9fc;
                                                                border-color: #b7b9cc;
                                                                color: #1c1d1cff;
                                                            }
                                                            .btn-outline-custom i {
                                                                font-size: 12px;
                                                                color: #858796;
                                                            }
                                                        </style>

                                                        <div class="post-input d-flex gap-2 justify-content-end">                                                            
                                                            <a href="view-inspection-report.php?ir_id=<?=$eir_id?>" target="_blank" class="btn-outline-custom">
                                                                <i class="fa fa-file-text text-black"></i> View
                                                            </a>
                                                            <a href="export-inspection-report.php?ir_id=<?=$eir_id?>" class="btn-outline-custom">
                                                                <i class="fa fa-file-excel text-green"></i> Download Excel
                                                            </a>
                                                            <a href="export-inspection-report-pdf.php?ir_id=<?=$eir_id?>" target="_blank" class="btn-outline-custom">
                                                                <i class="fa fa-file-pdf text-danger"></i> Download PDF
                                                            </a>
                                                        </div>

                                                        <div class="mt-4 mb-4">
                                                            <h4 class="card-title">Inspection Details</h4> <hr>
                                                        </div>                                                   

                                                        <div class="inspection">
                                                            <div class="table-responsive">
                                                                <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="tbl-pdi-inspection">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Document No</th>
                                                                            <th>Inspection Date</th>
                                                                            <th>Production Date</th>
                                                                            <th class="text-center">Pallet Sequence</th>
                                                                            <th>Shift</th>
                                                                            <th class="text-end">Result</th>
                                                                        </tr>
                                                                    </thead>                                                            
                                                                </table>
                                                            </div> 
                                                        </div>
                                                        
                                                        <div class="mt-4 mb-4">
                                                            <h4 class="card-title">Defect Details</h4> <hr>
                                                        </div>

                                                        <!-- NG details -->
                                                        <div class="inspection-defect">
                                                            
                                                        </div>

                                                        <div class="mt-4 mb-4">
                                                            <h4 class="card-title">Approval Details</h4> <hr>
                                                        </div> 

                                                        <div class="inspection-activity py-4 px-3 bg-light-grey rounded text-center">
                                                            <div class="row align-items-center">
                                                                <!-- Created -->
                                                                <div class="col-md-4 mb-3 mb-md-0 border-end border-opacity-10">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Created Date</h6>
                                                                    <div id="act-created-date" class="fw-bold text-created fs-14"></div>
                                                                    <div id="act-created-by" class="fs-12 text-muted-appv"></div>
                                                                </div>
                                                                
                                                                <!-- Submitted -->
                                                                <div class="col-md-4 mb-3 mb-md-0 border-end border-opacity-10">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Submitted Date</h6>
                                                                    <div id="act-submitted-date" class="fw-bold text-submitted fs-14"></div>
                                                                    <div id="act-submitted-by" class="fs-12 text-muted-appv"></div>
                                                                </div>
                                                                
                                                                <!-- Reviewed -->
                                                                <div class="col-md-4 position-relative">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Reviewed Date</h6>
                                                                    <div id="act-reviewed-date" class="fw-bold text-reviewed fs-14"></div>
                                                                    <div id="act-reviewed-by" class="fs-12 text-muted-appv"></div>
                                                                    
                                                                    <div class="clearfix position-absolute top-0 end-0 mt-n1 me-2">
                                                                        <small class="table-tip d-inline-flex align-items-center text-primary" id="remark-info" style="display:none;">
                                                                            <i class="fa fa-info-circle p-1 timeline-title-remark fs-5" data-remark="" role="button"></i>
                                                                        </small>
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
                                                                                <div class="text-start w-100">
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
                                                            </div>
                                                        </div>
                                                       
                                                </div>
                                            </div>

                                            <!-- Sorting -->
                                            <div id="view-Sorting?erid=<?=$eir_id;?>" class="tab-pane fade mb-4">

                                                <div class="post-input d-flex gap-2 justify-content-end mt-4 mb-4">                                                            
                                                    <a href="view-inspection-sorting-report.php?ir_id=<?=$eir_id?>" target="_blank" class="btn-outline-custom">
                                                        <i class="fa fa-file-text text-black"></i> View
                                                    </a>
                                                    <a href="export-inspection-sorting-report.php?ir_id=<?=$eir_id?>" class="btn-outline-custom">
                                                        <i class="fa fa-file-excel text-green"></i> Download Excel
                                                    </a>
                                                    <a href="export-inspection-sorting-report-pdf.php?ir_id=<?=$eir_id?>" target="_blank" class="btn-outline-custom">
                                                        <i class="fa fa-file-pdf text-danger"></i> Download PDF
                                                    </a>
                                                </div>

                                                <div class="mt-4 mb-4">
                                                    <h4 class="card-title">Sorting Details</h4> <hr>
                                                    <b>Document No : </b> <?=$sorting_data['sr_docno'];?>
                                                </div>  

                                                

                                                <div class="col-xl-6">
                                                    <div class="card mt-4">
                                                        <div class="card-header border-0 chart-card">                                                        
                                                            <div class="d-flex align-items-center">
                                                                <div class="icon-box bg-primary-light rounded-circle">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-check" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
                                                                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                                                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                                                                    </svg>
                                                                </div>
                                                                <div class="ms-2">
                                                                    <h4 class="mb-0 text-green fw-bold"><?=$sorting_data['sr_qty_ok'] ?? '0';?> <small class="fs-12 text-success"></small></h4>
                                                                    <span class="text-black">Qty OK</span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <div class="icon-box bg-primary-light rounded-circle">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard-x" viewBox="0 0 16 16">
                                                                        <path fill-rule="evenodd" d="M6.146 7.146a.5.5 0 0 1 .708 0L8 8.293l1.146-1.147a.5.5 0 1 1 .708.708L8.707 9l1.147 1.146a.5.5 0 0 1-.708.708L8 9.707l-1.146 1.147a.5.5 0 0 1-.708-.708L7.293 9 6.146 7.854a.5.5 0 0 1 0-.708"/>
                                                                        <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                                                                        <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                                                                    </svg>
                                                                </div>
                                                                <div class="ms-2">
                                                                    <h4 class="mb-0 text-meron fw-bold"><?=$sorting_data['sr_qty_ng'] ?? '0';?> <small class="fs-12 text-success"></small></h4>
                                                                    <span class="text-black">Qty NG</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="inspection-sorting">
                                                    <div class="s2w-section">
                                                        <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                            <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Sorting Method</h5></a>
                                                            <p><?=$sorting_data['sr_sorting_method'] ?? '-';?></p>                                                    
                                                        </div>

                                                        <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                            <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Rework Method</h5></a>
                                                            <p><?=$sorting_data['sr_rework_method'] ?? '-';?></p>                                                    
                                                        </div>

                                                        <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                            <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Remarks</h5></a>
                                                            <p><?=$sorting_data['sr_remarks'] ?? '-';?></p>                                                    
                                                        </div>
                                                    </div>
                                                    <div class="s2w-section">
                                                        <div class="row">                                                 
                                                            <!-- Photo Section Before (NG) -->
                                                            <div class="col-md-6">
                                                                <div class="profile-uoloaded-post border-bottom-1 pb-2 mt-4">
                                                                    <h5 class="text-black mb-1">Photos Before (NG)</h5>
                                                                    <div class="avatar-list avatar-list-stacked gallery-sorting-zoom">
                                                                        <?php 
                                                                        if (!empty($before_photos)) {
                                                                            foreach ($before_photos as $file) {
                                                                                $img_path = "gallery/inspection_sorting/before/" . $sr_id . "/" . $file;
                                                                                echo '<a href="'.$img_path.'" data-src="'.$img_path.'"><img src="'.$img_path.'" class="avatar rounded-circle" alt=""></a>';
                                                                            }
                                                                        } else {
                                                                            echo '<span class="text-muted fs-12">No photos</span>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Photo Section After (OK) -->
                                                            <div class="col-md-6">
                                                                <div class="profile-uoloaded-post border-bottom-1 pb-2 mt-4">
                                                                    <h5 class="text-black mb-1">Photos After Sorting (OK)</h5>
                                                                    <div class="avatar-list avatar-list-stacked gallery-sorting-zoom">
                                                                        <?php 
                                                                        if (!empty($after_photos)) {
                                                                            foreach ($after_photos as $file) {
                                                                                $img_path = "gallery/inspection_sorting/after/" . $sr_id . "/" . $file;
                                                                                echo '<a href="'.$img_path.'" data-src="'.$img_path.'"><img src="'.$img_path.'" class="avatar rounded-circle" alt=""></a>';
                                                                            }
                                                                        } else {
                                                                            echo '<span class="text-muted fs-12">No photos</span>';
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="mt-4 mb-4">
                                                    <h4 class="card-title">Part Involve</h4> <hr>
                                                </div> 

                                                <div class="inspection-sorting-part-involve">
                                                    <div class="card-body">
                                                        
                                                        <div class="widget-timeline-icons pb-3 ms-n3">
                                                            <ul class="timeline">
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-city"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="text-black fs-14 fw-semibold">RELATED LOOSE PART - In House</span>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="table-responsive">
                                                                                <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="tbl-related-inhouse">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Related Dept</th>
                                                                                            <th>Type of Part</th>
                                                                                            <th>Part No</th>
                                                                                            <th>Part Name</th>
                                                                                            <th>Qty OK</th>
                                                                                            <th class="text-end">Qty NG</th>
                                                                                        </tr>
                                                                                    </thead>                                                            
                                                                                    <tbody>
                                                                                        <?php if (empty($inhouse_parts)): ?>
                                                                                            <tr><td colspan="6" class="text-center">No records found</td></tr>
                                                                                        <?php else: ?>
                                                                                            <?php foreach ($inhouse_parts as $part): ?>
                                                                                                <tr>
                                                                                                    <td><?= htmlspecialchars($part['rd_dept_name'] ?? '-') ?></td>
                                                                                                    <td><?= htmlspecialchars($part['tp_partname'] ?? '-') ?></td>
                                                                                                    <td><?= htmlspecialchars($part['bom'] ?? '-') ?></td>
                                                                                                    <td><?= htmlspecialchars($part['bomdesc'] ?? '-') ?></td>
                                                                                                    <td class="text-center"><?= number_format($part['srp_qty_ok_dept']) ?></td>
                                                                                                    <td class="text-center"><?= number_format($part['srp_qty_ng_dept']) ?></td>
                                                                                                </tr>
                                                                                            <?php endforeach; ?>
                                                                                        <?php endif; ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-user"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="text-black fs-14 fw-semibold">RELATED LOOSE PART - Vendor</span>
                                                                        </div>
                                                                        <div class="px-3 py-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="table-responsive">
                                                                                <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="tbl-related-vendor">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Related Vendor</th>
                                                                                            <th>Type of Part</th>
                                                                                            <th>Part No</th>
                                                                                            <th>Part Name</th>
                                                                                            <th>Qty OK</th>
                                                                                            <th class="text-end">Qty NG</th>
                                                                                        </tr>
                                                                                    </thead>                                                            
                                                                                    <tbody>
                                                                                        <?php if (empty($vendor_parts)): ?>
                                                                                            <tr><td colspan="6" class="text-center">No records found</td></tr>
                                                                                        <?php else: ?>
                                                                                            <?php foreach ($vendor_parts as $part): ?>
                                                                                                <tr>
                                                                                                    <td><?= htmlspecialchars($part['rv_vendor_name'] ?? '-') ?></td>
                                                                                                    <td><?= htmlspecialchars($part['tp_partname'] ?? '-') ?></td>
                                                                                                    <td><?= htmlspecialchars($part['bom'] ?? '-') ?></td>
                                                                                                    <td><?= htmlspecialchars($part['bomdesc'] ?? '-') ?></td>
                                                                                                    <td class="text-center"><?= number_format($part['srp_qty_ok_vdr']) ?></td>
                                                                                                    <td class="text-center"><?= number_format($part['srp_qty_ng_vdr']) ?></td>
                                                                                                </tr>
                                                                                            <?php endforeach; ?>
                                                                                        <?php endif; ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="timeline-media">
                                                                        <i class="las la-user-friends"></i>
                                                                    </div>
                                                                    <div class="timeline-panel">
                                                                        <div class="clearfix">
                                                                            <span class="text-black fs-14 fw-semibold">FINISHED GOODS PART - Customer</span>
                                                                        </div>
                                                                        <div class="p-md-4 p-3 mt-3 border border-opacity-10 rounded">
                                                                            <div class="table-responsive">
                                                                                <table class="table mb-1 table-striped-thead table-wide table-sm table-border-last-0" id="tbl-related-customer">
                                                                                    <thead>
                                                                                        <tr>
                                                                                            <th>Related Customer</th>
                                                                                            <th>Qty OK</th>
                                                                                            <th>Qty NG</th>
                                                                                        </tr>
                                                                                    </thead>                                                            
                                                                                    <tbody>
                                                                                        <?php if (empty($customer_parts)): ?>
                                                                                            <tr><td colspan="3" class="text-center">No records found</td></tr>
                                                                                        <?php else: ?>
                                                                                            <?php foreach ($customer_parts as $part): ?>
                                                                                                <tr>
                                                                                                    <td><?= htmlspecialchars($part['rc_cust_name'] ?? '-') ?></td>
                                                                                                    <td><?= number_format($part['srp_qty_ok_cust']) ?></td>
                                                                                                    <td class="text-left"><?= number_format($part['srp_qty_ng_cust']) ?></td>
                                                                                                </tr>
                                                                                            <?php endforeach; ?>
                                                                                        <?php endif; ?>
                                                                                    </tbody>
                                                                                </table>
                                                                            </div> 
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                                
                                                <!-- Approval Details for Sorting -->
                                                <div class="mt-4 mb-4">
                                                    <h4 class="card-title">Approval Details</h4> <hr>
                                                </div> 

                                                <div class="inspection-activity py-4 px-3 bg-light-grey rounded text-center">
                                                    <div class="row align-items-center">
                                                        <!-- Created -->
                                                        <div class="col-md-4 mb-3 mb-md-0 border-end border-opacity-10">
                                                            <h6 class="text-muted-appv fs-12 mb-1">Created Date</h6>
                                                            <div class="fw-bold text-created fs-14">
                                                                <?= (!empty($sorting_data['created_date']) && $sorting_data['created_date'] != '0000-00-00 00:00:00') ? date('d M Y | h:i A', strtotime($sorting_data['created_date'])) : '-' ?>
                                                            </div>
                                                            <div class="fs-12 text-muted-appv">
                                                                <?= !empty($sorting_data['created_by_name']) ? 'by ' . htmlspecialchars($sorting_data['created_by_name']) : '' ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Submitted -->
                                                        <div class="col-md-4 mb-3 mb-md-0 border-end border-opacity-10">
                                                            <h6 class="text-muted-appv fs-12 mb-1">Submitted Date</h6>
                                                            <div class="fw-bold text-submitted fs-14">
                                                                <?= (!empty($sorting_data['submitted_date']) && $sorting_data['submitted_date'] != '0000-00-00 00:00:00') ? date('d M Y | h:i A', strtotime($sorting_data['submitted_date'])) : '-' ?>
                                                            </div>
                                                            <div class="fs-12 text-muted-appv">
                                                                <?= !empty($sorting_data['submitted_by_name']) ? 'by ' . htmlspecialchars($sorting_data['submitted_by_name']) : '' ?>
                                                            </div>
                                                        </div>
                                                        
                                                        <!-- Reviewed -->
                                                        <div class="col-md-4 position-relative">
                                                            <h6 class="text-muted-appv fs-12 mb-1">Reviewed Date</h6>
                                                            <div class="fw-bold text-reviewed fs-14">
                                                                <?= (!empty($sorting_data['approved_date']) && $sorting_data['approved_date'] != '0000-00-00 00:00:00') ? date('d M Y | h:i A', strtotime($sorting_data['approved_date'])) : '-' ?>
                                                            </div>
                                                            <div class="fs-12 text-muted-appv">
                                                                <?= !empty($sorting_data['approved_by_name']) ? 'by ' . htmlspecialchars($sorting_data['approved_by_name']) : '' ?>
                                                            </div>
                                                            
                                                            <?php if (!empty($sorting_data['approved_remark'])): ?>
                                                            <div class="clearfix position-absolute top-0 end-0 mt-n1 me-2">
                                                                <small class="table-tip d-inline-flex align-items-center text-primary">
                                                                    <i class="fa fa-info-circle p-1 timeline-title-remark-sorting fs-5" data-remark="<?= htmlspecialchars($sorting_data['approved_remark']) ?>" role="button"></i>
                                                                </small>
                                                            </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Remark Modal -->
                                                <div class="modal fade" id="remarkModalSorting" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content border-0 shadow-sm">
                                                            <div class="modal-body p-3 d-flex align-items-start bg-light-green">
                                                                <!-- Icon -->
                                                                <div class="me-3">
                                                                    <i class="fa fa-envelope fs-2 text-primary"></i>
                                                                </div>

                                                                <!-- Text -->
                                                                <div class="text-start w-100">
                                                                    <h6 class="fw-bold mb-1">Comment/Reason</h6>
                                                                    <p id="remarkContentSorting" class="mb-0 small text-primary">
                                                                        <!-- Display remark here -->
                                                                    </p>
                                                                </div>

                                                                <!-- Close button -->
                                                                <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- S2W -->
                                            <div id="view-S2W?erid=<?=$eir_id;?>" class="tab-pane fade">

                                                <div class="post-input d-flex gap-2 justify-content-end mt-4 mb-4">                                                            
                                                    <a href="view-inspection-s2w-report.php?ir_id=<?=$eir_id?>" target="_blank" class="btn-outline-custom">
                                                        <i class="fa fa-file-text text-black"></i> View
                                                    </a>
                                                    <a href="export-inspection-s2w-report.php?ir_id=<?=$eir_id?>" class="btn-outline-custom">
                                                        <i class="fa fa-file-excel text-green"></i> Download Excel
                                                    </a>
                                                    <a href="export-inspection-s2w-report-pdf.php?ir_id=<?=$eir_id?>" target="_blank" class="btn-outline-custom">
                                                        <i class="fa fa-file-pdf text-danger"></i> Download PDF
                                                    </a>
                                                </div>

                                                <div class="pt-3">
                                                    <div class="mt-4 mb-4">
                                                        <h4 class="card-title">Something When Wrong (S2W) Details</h4> <hr>
                                                        <b>Document No : </b> <?=$s2w_data['s2w_docno'];?>
                                                    </div>  
                                                    
                                                    <div class="inspection-s2w">
                                                        <div class="s2w-section">
                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Additional Information</h5></a>
                                                                <p><?= !empty($s2w_data['s2w_additional_desc']) ? nl2br(htmlspecialchars($s2w_data['s2w_additional_desc'])) : '-'; ?></p>                                                    
                                                            </div>

                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Sending To</h5></a>
                                                                <p><?= !empty($s2w_data['rd_dept_name']) ? htmlspecialchars($s2w_data['rd_dept_name']) : '-'; ?></p>                                                    
                                                            </div>
                                                        </div>
                                                        <div class="s2w-section">
                                                            <div class="row">                                                 
                                                                <!-- Photo Section Before (NG) -->
                                                                <div class="col-md-6">
                                                                    <div class="profile-uoloaded-post border-bottom-1 pb-2 mt-4">
                                                                        <h5 class="text-black mb-1">Photos NG (Defect)</h5>
                                                                        <div class="avatar-list avatar-list-stacked gallery-sorting-zoom">
                                                                            <?php 
                                                                            if (!empty($s2w_defect_photos) && !empty($s2w_id)) {
                                                                                foreach ($s2w_defect_photos as $file) {
                                                                                    // Based on typical save path structure fetching pattern observed across the codebase
                                                                                    $img_path = "gallery/inspection_s2w/photo_defect/" . $s2w_id . "/".  $file;
                                                                                    echo '<a href="'.$img_path.'" data-src="'.$img_path.'"><img src="'.$img_path.'" class="avatar rounded-circle" alt=""></a>';
                                                                                }
                                                                            } else {
                                                                                echo '<span class="text-muted fs-12">No photos</span>';
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Photo Section After (OK) -->
                                                                <div class="col-md-6">
                                                                    <div class="profile-uoloaded-post border-bottom-1 pb-2 mt-4">
                                                                        <h5 class="text-black mb-1">Photo OK</h5>
                                                                        <div class="avatar-list avatar-list-stacked gallery-sorting-zoom">
                                                                            <?php 
                                                                            if (!empty($s2w_ok_photos) && !empty($s2w_id)) {
                                                                                foreach ($s2w_ok_photos as $file) {
                                                                                    $img_path = "gallery/inspection_s2w/photo_ok/" . $s2w_id . "/" . $file;
                                                                                    echo '<a href="'.$img_path.'" data-src="'.$img_path.'"><img src="'.$img_path.'" class="avatar rounded-circle" alt=""></a>';
                                                                                }
                                                                            } else {
                                                                                echo '<span class="text-muted fs-12">No photos</span>';
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- S2W Approval Details -->
                                                        <div class="mt-4 mb-3">
                                                            <h4 class="card-title">Approval Details</h4> <hr>
                                                        </div>

                                                        <div class="inspection-activity py-4 px-3 bg-light-grey rounded text-center">
                                                            <div class="row align-items-center">
                                                                <!-- Created -->
                                                                <div class="col-md-3 mb-3 mb-md-0 border-end border-opacity-10">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Created Date</h6>
                                                                    <div class="fw-bold text-created fs-14">
                                                                        <?= (!empty($s2w_data['created_date']) && strpos($s2w_data['created_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w_data['created_date'])) : '-' ?>
                                                                    </div>
                                                                    <div class="fs-12 text-muted-appv">
                                                                        <?= !empty($s2w_data['created_by_name']) ? 'by ' . htmlspecialchars($s2w_data['created_by_name']) : '' ?>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Submitted -->
                                                                <div class="col-md-3 mb-3 mb-md-0 border-end border-opacity-10">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Submitted Date</h6>
                                                                    <div class="fw-bold text-submitted fs-14">
                                                                        <?= (!empty($s2w_data['submitted_date']) && strpos($s2w_data['submitted_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w_data['submitted_date'])) : '-' ?>
                                                                    </div>
                                                                    <div class="fs-12 text-muted-appv">
                                                                        <?= !empty($s2w_data['submitted_by_name']) ? 'by ' . htmlspecialchars($s2w_data['submitted_by_name']) : '' ?>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Reviewed -->
                                                                <div class="col-md-3 mb-3 mb-md-0 position-relative border-end border-opacity-10">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Reviewed Date</h6>
                                                                    <div class="fw-bold text-reviewed fs-14">
                                                                        <?= (!empty($s2w_data['reviewed_date']) && strpos($s2w_data['reviewed_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w_data['reviewed_date'])) : '-' ?>
                                                                    </div>
                                                                    <div class="fs-12 text-muted-appv">
                                                                        <?= !empty($s2w_data['reviewed_by_name']) ? 'by ' . htmlspecialchars($s2w_data['reviewed_by_name']) : '' ?>
                                                                    </div>
                                                                    
                                                                    <?php if (!empty($s2w_data['reviewed_remark'])): ?>
                                                                    <div class="clearfix position-absolute top-0 end-0 mt-n1 me-2">
                                                                        <small class="table-tip d-inline-flex align-items-center text-primary">
                                                                            <i class="fa fa-info-circle p-1 timeline-title-remark-s2w-rev fs-5 pointer" data-remark="<?= htmlspecialchars($s2w_data['reviewed_remark']); ?>" role="button" title="View Remark"></i>
                                                                        </small>
                                                                    </div>
                                                                    <?php endif; ?>
                                                                </div>

                                                                <!-- Approved -->
                                                                <div class="col-md-3 position-relative">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Approved Date</h6>
                                                                    <div class="fw-bold text-primary fs-14">
                                                                        <?= (!empty($s2w_data['approved_date']) && strpos($s2w_data['approved_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w_data['approved_date'])) : '-' ?>
                                                                    </div>
                                                                    <div class="fs-12 text-muted-appv">
                                                                        <?= !empty($s2w_data['approved_by_name']) ? 'by ' . htmlspecialchars($s2w_data['approved_by_name']) : '' ?>
                                                                    </div>
                                                                    
                                                                    <?php if (!empty($s2w_data['approved_remark'])): ?>
                                                                    <div class="clearfix position-absolute top-0 end-0 mt-n1 me-2">
                                                                        <small class="table-tip d-inline-flex align-items-center text-primary">
                                                                            <i class="fa fa-info-circle p-1 timeline-title-remark-s2w-app fs-5 pointer" data-remark="<?= htmlspecialchars($s2w_data['approved_remark']); ?>" role="button" title="View Remark"></i>
                                                                        </small>
                                                                    </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>

                                                <!-- Remark Modal Reviewed-->
                                                <div class="modal fade" id="remarkModalS2WRev" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content border-0 shadow-sm">
                                                            <div class="modal-body p-3 d-flex align-items-start bg-light-green">
                                                                <!-- Icon -->
                                                                <div class="me-3">
                                                                    <i class="fa fa-envelope fs-2 text-primary"></i>
                                                                </div>

                                                                <!-- Text -->
                                                                <div class="text-start w-100">
                                                                    <h6 class="fw-bold mb-1">Comment/Reason</h6>
                                                                    <p id="remarkContentS2WRev" class="mb-0 small text-primary">
                                                                        <!-- Display remark here -->
                                                                    </p>
                                                                </div>

                                                                <!-- Close button -->
                                                                <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Remark Modal Approved-->
                                                <div class="modal fade" id="remarkModalS2WApp" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content border-0 shadow-sm">
                                                            <div class="modal-body p-3 d-flex align-items-start bg-light-green">
                                                                <!-- Icon -->
                                                                <div class="me-3">
                                                                    <i class="fa fa-envelope fs-2 text-primary"></i>
                                                                </div>

                                                                <!-- Text -->
                                                                <div class="text-start w-100">
                                                                    <h6 class="fw-bold mb-1">Comment/Reason</h6>
                                                                    <p id="remarkContentS2WApp" class="mb-0 small text-primary">
                                                                        <!-- Display remark here -->
                                                                    </p>
                                                                </div>

                                                                <!-- Close button -->
                                                                <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- S2W Reply -->
                                            <div id="view-S2W-Reply?erid=<?=$eir_id;?>" class="tab-pane fade active show">

                                                <div class="post-input d-flex gap-2 justify-content-end mt-4 mb-4">                                                            
                                                    <a href="view-inspection-s2w-reply.php?ir_id=<?=$eir_id?>" target="_blank" class="btn-outline-custom">
                                                        <i class="fa fa-file-text text-black"></i> View
                                                    </a>
                                                    <a href="export-inspection-s2w-reply.php?ir_id=<?=$eir_id?>" class="btn-outline-custom">
                                                        <i class="fa fa-file-excel text-green"></i> Download Excel
                                                    </a>
                                                    <a href="export-inspection-s2w-reply-pdf.php?ir_id=<?=$eir_id?>" target="_blank" class="btn-outline-custom">
                                                        <i class="fa fa-file-pdf text-danger"></i> Download PDF
                                                    </a>
                                                </div>

                                                <div class="pt-3">
                                                    <div class="mt-4 mb-4">
                                                        <h4 class="card-title">S2W Reply Details</h4> <hr>
                                                        <b>Document No : </b> <?=$s2w_reply_data['rp_s2w_docno'];?>
                                                    </div>  
                                                    
                                                    <div class="inspection-s2w">
                                                        <div class="s2w-section">
                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Chronology</h5></a>
                                                                <p><?= !empty($s2w_reply_data['rp_s2w_cronology']) ? nl2br(htmlspecialchars($s2w_reply_data['rp_s2w_cronology'])) : '-'; ?></p>                                                    
                                                            </div>

                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Root Cause</h5></a>
                                                                <p><?= !empty($s2w_reply_data['rp_s2w_rootcause']) ? nl2br(htmlspecialchars($s2w_reply_data['rp_s2w_rootcause'])) : '-'; ?></p>                                                    
                                                            </div>
                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Root Cause Area</h5></a>
                                                                <p><?= !empty($s2w_reply_data['rp_s2w_rootcause_area']) ? nl2br(htmlspecialchars($s2w_reply_data['rp_s2w_rootcause_area'])) : '-'; ?></p>                                                    
                                                            </div>
                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Root Cause Place</h5></a>
                                                                <p><?= !empty($s2w_reply_data['rp_s2w_rootcause_place']) ? nl2br(htmlspecialchars($s2w_reply_data['rp_s2w_rootcause_place'])) : '-'; ?></p>                                                    
                                                            </div>
                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Correction</h5></a>
                                                                <p><?= !empty($s2w_reply_data['rp_s2w_correction']) ? nl2br(htmlspecialchars($s2w_reply_data['rp_s2w_correction'])) : '-'; ?></p>                                                    
                                                            </div>
                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Preventive</h5></a>
                                                                <p><?= !empty($s2w_reply_data['rp_s2w_preventive']) ? nl2br(htmlspecialchars($s2w_reply_data['rp_s2w_preventive'])) : '-'; ?></p>                                                    
                                                            </div>
                                                            <div class="profile-uoloaded-post border-bottom-1 pb-2">
                                                                <a class="post-title" href="javascript:void(0);"><h5 class="text-black">Conclusion</h5></a>
                                                                <p><?= !empty($s2w_reply_data['rp_s2w_conclusion']) ? nl2br(htmlspecialchars($s2w_reply_data['rp_s2w_conclusion'])) : '-'; ?></p>                                                    
                                                            </div>
                                                        </div>
                                                        <div class="s2w-section">
                                                            <div class="row">                                                 
                                                                <!-- Photo Section Correction -->
                                                                <div class="col-md-6">
                                                                    <div class="profile-uoloaded-post border-bottom-1 pb-2 mt-4">
                                                                        <h5 class="text-black mb-1">Correction Photos</h5>
                                                                        <div class="avatar-list avatar-list-stacked gallery-sorting-zoom">
                                                                            <?php 
                                                                            if (!empty($s2w_correction_photos) && !empty($s2w_rp_id)) {
                                                                                foreach ($s2w_correction_photos as $file) {
                                                                                    $img_path = "gallery/inspection_s2w_report/photo_correction/" . $s2w_rp_id . "/".  $file;
                                                                                    echo '<a href="'.$img_path.'" data-src="'.$img_path.'"><img src="'.$img_path.'" class="avatar rounded-circle" alt=""></a>';
                                                                                }
                                                                            } else {
                                                                                echo '<span class="text-muted fs-12">No photos</span>';
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <!-- Photo Section Preventive -->
                                                                <div class="col-md-6">
                                                                    <div class="profile-uoloaded-post border-bottom-1 pb-2 mt-4">
                                                                        <h5 class="text-black mb-1">Preventive Photos</h5>
                                                                        <div class="avatar-list avatar-list-stacked gallery-sorting-zoom">
                                                                            <?php 
                                                                            if (!empty($s2w_preventive_photos) && !empty($s2w_rp_id)) {
                                                                                foreach ($s2w_preventive_photos as $file) {
                                                                                    $img_path = "gallery/inspection_s2w_report/photo_preventive/" . $s2w_rp_id . "/" . $file;
                                                                                    echo '<a href="'.$img_path.'" data-src="'.$img_path.'"><img src="'.$img_path.'" class="avatar rounded-circle" alt=""></a>';
                                                                                }
                                                                            } else {
                                                                                echo '<span class="text-muted fs-12">No photos</span>';
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- S2W Reply Approval Details -->
                                                        <div class="mt-4 mb-3">
                                                            <h4 class="card-title">Approval Details</h4> <hr>
                                                        </div>

                                                        <div class="inspection-activity py-4 px-3 bg-light-grey rounded text-center">
                                                            <div class="row align-items-center">
                                                                <!-- Created -->
                                                                <div class="col-md-4 mb-3 mb-md-0 border-end border-opacity-10">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Created Date</h6>
                                                                    <div class="fw-bold text-created fs-14">
                                                                        <?= (!empty($s2w_reply_data['created_date']) && strpos($s2w_reply_data['created_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w_reply_data['created_date'])) : '-' ?>
                                                                    </div>
                                                                    <div class="fs-12 text-muted-appv">
                                                                        <?= !empty($s2w_reply_data['created_by_name']) ? 'by ' . htmlspecialchars($s2w_reply_data['created_by_name']) : '' ?>
                                                                    </div>
                                                                </div>
                                                                
                                                                <!-- Submitted -->
                                                                <div class="col-md-4 mb-3 mb-md-0 border-end border-opacity-10">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Submitted Date</h6>
                                                                    <div class="fw-bold text-submitted fs-14">
                                                                        <?= (!empty($s2w_reply_data['submitted_date']) && strpos($s2w_reply_data['submitted_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w_reply_data['submitted_date'])) : '-' ?>
                                                                    </div>
                                                                    <div class="fs-12 text-muted-appv">
                                                                        <?= !empty($s2w_reply_data['submitted_by_name']) ? 'by ' . htmlspecialchars($s2w_reply_data['submitted_by_name']) : '' ?>
                                                                    </div>
                                                                </div>

                                                                <!-- Approved -->
                                                                <div class="col-md-4 position-relative">
                                                                    <h6 class="text-muted-appv fs-12 mb-1">Approved Date</h6>
                                                                    <div class="fw-bold text-primary fs-14">
                                                                        <?= (!empty($s2w_reply_data['approved_date']) && strpos($s2w_reply_data['approved_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w_reply_data['approved_date'])) : '-' ?>
                                                                    </div>
                                                                    <div class="fs-12 text-muted-appv">
                                                                        <?= !empty($s2w_reply_data['approved_by_name']) ? 'by ' . htmlspecialchars($s2w_reply_data['approved_by_name']) : '' ?>
                                                                    </div>
                                                                    
                                                                    <?php if (!empty($s2w_reply_data['approved_remark'])): ?>
                                                                    <div class="clearfix position-absolute top-0 end-0 mt-n1 me-2">
                                                                        <small class="table-tip d-inline-flex align-items-center text-primary">
                                                                            <i class="fa fa-info-circle p-1 timeline-title-remark-s2w-reply-app fs-5 pointer" data-remark="<?= htmlspecialchars($s2w_reply_data['approved_remark']); ?>" role="button" title="View Remark"></i>
                                                                        </small>
                                                                    </div>
                                                                    <?php endif; ?>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <!-- Remark Modal Approved-->
                                                <div class="modal fade" id="remarkModalS2WReplyApp" tabindex="-1" aria-labelledby="remarkModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered modal-md">
                                                        <div class="modal-content border-0 shadow-sm">
                                                            <div class="modal-body p-3 d-flex align-items-start bg-light-green">
                                                                <!-- Icon -->
                                                                <div class="me-3">
                                                                    <i class="fa fa-envelope fs-2 text-primary"></i>
                                                                </div>

                                                                <!-- Text -->
                                                                <div class="text-start w-100">
                                                                    <h6 class="fw-bold mb-1">Comment/Reason</h6>
                                                                    <p id="remarkContentS2WReplyApp" class="mb-0 small text-primary">
                                                                        <!-- Display remark here -->
                                                                    </p>
                                                                </div>

                                                                <!-- Close button -->
                                                                <button type="button" class="btn-close ms-2" data-bs-dismiss="modal" aria-label="Close"></button>
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
        window.location.href = "ip-s2w-reply-report.php";
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

    $(document).on('click', '.timeline-title-remark', function () {
        const remark = $(this).attr('data-remark') || $(this).data('remark');
        if (remark) {
            $('#remarkContent').text(remark);
            $('#remarkModal').modal('show');
        }
    });

    $(document).on('click', '.timeline-title-remark-sorting', function () {
        const remark = $(this).attr('data-remark') || $(this).data('remark');
        if (remark) {
            $('#remarkContentSorting').text(remark);
            $('#remarkModalSorting').modal('show');
        }
    });

    $(document).on('click', '.timeline-title-remark-s2w-rev', function () {
        const remark = $(this).attr('data-remark') || $(this).data('remark');
        if (remark) {
            $('#remarkContentS2WRev').text(remark);
            $('#remarkModalS2WRev').modal('show');
        }
    });

    $(document).on('click', '.timeline-title-remark-s2w-app', function () {
        const remark = $(this).attr('data-remark') || $(this).data('remark');
        if (remark) {
            $('#remarkContentS2WApp').text(remark);
            $('#remarkModalS2WApp').modal('show');
        }
    });

    $(document).on('click', '.timeline-title-remark-s2w-reply-app', function () {
        const remark = $(this).attr('data-remark') || $(this).data('remark');
        if (remark) {
            $('#remarkContentS2WReplyApp').text(remark);
            $('#remarkModalS2WReplyApp').modal('show');
        }
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
            url: 'fetch-material-details-report.php',
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

    // Load PDI Inspection Details
    function loadPDIRecord(irid) {
        $.ajax({
            url: 'fetch-inspection-report-view.php',
            type: 'POST',
            dataType: 'json',
            data: { 
                action: 'get_pdi_inspection',
                ir_id: irid 
            },
            success: function (res) {
                if (res.status === 'success') {
                    const d = res.data;
                    
                    // Update Document No
                    $('#view-PDI span.fs-13').first().text(d.ir_docno);

                    // Update Table
                    let resultColor = (d.ir_result === 'OK') ? 'text-primary' : 'text-danger';
                    let palletSequence =  '<span class="badge badge-rounded badge-outline-emerald text-center">' + d.ir_pallet_no + '</span>';
                    let tableRow = `
                        <tr>
                            <td>${d.ir_docno}</td>
                            <td>${d.inspect_date}</td>
                            <td>${d.prod_date}</td>
                            <td class="text-center">${palletSequence}</td>
                            <td>${d.shiftdesc}</td>
                            <td class="text-end fw-bold ${resultColor}">${d.ir_result}</td>
                        </tr>
                    `;
                    $('#tbl-pdi-inspection').append('<tbody>' + tableRow + '</tbody>');

                    // --- Update Activity Timeline ---
                    // Helper to format date consistent with system
                    const formatDate = (dateStr) => {
                        if (!dateStr || dateStr === '0000-00-00 00:00:00' || dateStr === '0000-00-00') return '-';
                        const date = new Date(dateStr);
                        const day = date.getDate();
                        const months = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
                        const month = months[date.getMonth()];
                        const year = date.getFullYear();
                        
                        let hours = date.getHours();
                        const minutes = date.getMinutes().toString().padStart(2, '0');
                        const ampm = hours >= 12 ? 'PM' : 'AM';
                        hours = hours % 12;
                        hours = hours ? hours : 12; // 0 should be 12
                        
                        return `${day} ${month} ${year} | ${hours}:${minutes} ${ampm}`;
                    };

                    // Set Dates and User Names
                    $('#act-created-date').text(formatDate(d.created_date));
                    $('#act-created-by').text(d.created_by_name ? `by ${d.created_by_name}` : '');

                    $('#act-submitted-date').text(formatDate(d.submitted_date));
                    $('#act-submitted-by').text(d.submitted_by_name ? `by ${d.submitted_by_name}` : '');

                    $('#act-reviewed-date').text(formatDate(d.reviewed_date));
                    $('#act-reviewed-by').text(d.reviewed_by_name ? `by ${d.reviewed_by_name}` : '');

                    // Handle Remark Icon
                    if (d.reviewed_remark) {
                        $('#remark-info').show();
                        $('#remark-info i.timeline-title-remark').attr('data-remark', d.reviewed_remark);
                    } else {
                        $('#remark-info').hide();
                    }

                    // Update Defect Details if NG
                    const defectContainer = $('.inspection-defect');
                    defectContainer.empty();
                    const defectHeader = $('.mt-4.mb-4:has(h4:contains("Defect Details"))');

                    if (d.ir_result === 'NG' && d.defects && d.defects.length > 0) {
                        defectHeader.show();
                        defectContainer.show();
                        
                        d.defects.forEach((defect, index) => {
                            let defectPhotosHtml = '';
                            defect.defect_photos.forEach(photo => {
                                defectPhotosHtml += `
                                    <a href="${photo}" data-src="${photo}">
                                        <img src="${photo}" class="avatar rounded-circle" alt="">
                                    </a>`;
                            });

                            let comparePhotosHtml = '';
                            defect.compare_photos.forEach(photo => {
                                comparePhotosHtml += `
                                    <a href="${photo}" data-src="${photo}">
                                        <img src="${photo}" class="avatar rounded-circle" alt="">
                                    </a>`;
                            });

                            let defectHtml = `
                                <div class="defect-item ${index > 0 ? 'mt-5 pt-4 border-top' : ''}">
                                    <div class="clearfix d-flex">
                                        <div class="clearfix">
                                            <h6 class="mb-0 fw-semibold">#${index + 1} ${defect.defectname}</h6>
                                            <span class="fs-14 d-block">Defect Area : <span class="text-primary">${defect.defect_area}</span></span>
                                        </div>	
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="clearfix mt-4">
                                                <p class="text-black mb-1 font-w500">Defect Photos</p>
                                                <div class="avatar-list avatar-list-stacked gallery-defect-zoom">
                                                    ${defectPhotosHtml || '<span class="text-muted fs-12">No photos</span>'}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="clearfix mt-4">
                                                <p class="text-black mb-1 font-w500">Comparison Photos</p>
                                                <div class="avatar-list avatar-list-stacked gallery-defect-zoom">
                                                    ${comparePhotosHtml || '<span class="text-muted fs-12">No photos</span>'}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `;
                            defectContainer.append(defectHtml);
                        });

                        // Initialize local LightGallery for defects
                        $('.gallery-defect-zoom').each(function() {
                            $(this).lightGallery({
                                selector: 'a',
                                thumbnail: true
                            });
                        });

                    } else if (d.ir_result === 'NG') {
                        defectHeader.show();
                        defectContainer.show();
                        defectContainer.html('<div class="text-muted">No defect details found.</div>');
                    } else {
                        // For OK result, hide the defect section
                        defectHeader.hide();
                        defectContainer.hide();
                    }
                }
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
            loadPDIRecord(irid);
        }

        // Initialize LightGallery for Sorting tab photos
        $('.gallery-sorting-zoom').lightGallery({
            selector: 'a',
            thumbnail: true
        });
    });

    </script>

     
</body>
</html>