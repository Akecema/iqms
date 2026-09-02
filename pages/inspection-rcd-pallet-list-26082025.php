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

    <!-- Tagify Css -->
	<link href="vendor/tagify/dist/tagify.css" rel="stylesheet">	
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">

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

        #inspectionGroupsTable tbody tr td:last-child {
            text-align: left !important; 
        }

        #inspectionGroupsTable thead tr th:last-child{
            text-align: left !important;
        }

        .dataTables_filter input {
            width: 180px !important; /* or any size you want */
            height: 35px !important;             /* optional */
            font-size: 11px !important;          /* optional */
        }

        </style>

		<?php

        $group = $_GET['egp'] ?? null;

        if (!$group || !is_numeric($group)) {
            echo "<p>Invalid group</p>";
            exit;
        }

        $query = "SELECT * FROM inspection_records I  
                    WHERE I.inspect_group = ? ORDER BY I.ir_pallet_no ASC";
        $stmt = $db_con->prepare($query);
        $stmt->bind_param("i", $group);
        $stmt->execute();
        $result_isp = $stmt->get_result();

        //Inspection details
        $query_i = "SELECT I.ir_id, I.ir_material, I.ir_result, I.ir_status, I.ir_pallet_no, I.inspect_date, I.shift_date, I.inspect_group, 
                         T.modcode, M.matno, M.matdesc, H.shiftdesc
                    FROM inspection_records I
                    LEFT JOIN model_details as T ON I.ir_model = T.modid
                    LEFT JOIN material_header as M ON I.ir_material = M.matid 
                    LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort     
                    WHERE I.inspect_group = ? ORDER BY I.ir_pallet_no ASC";
        $stmt_i = $db_con->prepare($query_i);
        $stmt_i->bind_param("i", $group);
        $stmt_i->execute();
        $result_i = $stmt_i->get_result();
        $row_i = $result_i->fetch_array();

        $gall_model = $row_i['modcode'];

        //Photo
        $sql_img = "SELECT imagename FROM material_gallery WHERE image_matid = '$row_i[ir_material]'";
        $result_img = mysqli_query($db_con, $sql_img);

        $gallery_html = '';
        $count = 0;

        while ($row_img = mysqli_fetch_assoc($result_img)) {
            
            $view_img = $row_img['imagename'];
            $thumb = "gallery/model/$gall_model/$view_img"; // adjust path if needed
            $full = "gallery/model/$gall_model/$view_img";

            $extra = ($count == 3) ? ' gallery-more" data-more="+03' : '';
            $col = ($count == 0) ? 'colspan-3 rowspan-2' : '';

            $gallery_html .= "
                <a href=\"$full\" data-exthumbimage=\"$thumb\" data-src=\"$full\" class=\"grid-item $col$extra\">
                    <img src=\"$thumb\" alt=\"\">
                </a>
            ";
            $count++;
            
        }

        if ($count == 0) {
            $gallery_html = '<p class="text-muted">No images found.</p>';
        }

        //Count total OK and NG 
        $records = [];
        $total_ok = 0;
        $total_ng = 0;

        while ($row = $result_isp->fetch_assoc()) {
            $records[] = $row;

            if ($row['ir_result'] === 'OK') {
                $total_ok++;
            } elseif ($row['ir_result'] === 'NG') {
                $total_ng++;
            }
        }

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
                        <!-- <?=$side_menu4;?> -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">

                        <!-- Preview material, inspection details -->
                        <div id="detailsPreview" >
                            <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                                <div class="accordion-item">
                                <h2 class="accordion-header accordion-header-primary" id="headingOne6">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne6">
                                <span class="accordion-header-icon"></span>
                                    <span class="accordion-header-text">Inspection Details</span>
                                </button>
                                </h2>
                            </div>

                            <div id="collapseOne6" class="accordion__body collapse" aria-labelledby="accord-6One" data-bs-parent="#accordion-six">
                                <div class="accordion-body-text p-0">
                                    <div class="card h-auto">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-8">
                                                    <div class="gallery-grid rows-3" id="lightgallery">
                                                        <!-- Images will be injected here via AJAX -->
                                                        <?=$gallery_html;?>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6">      
                                                    <div class="product-detail-content" id="material_product_detail">
                                                        <div class="alert alert-primary border-primary outline-dashed py-3 px-3 mt-1 mb-3 mb-0 text-black d-flex">												
                                                            <div class="mx-3">
                                                                <span fs-9>Part Name</span>
                                                                <p><strong class="text-primary"><?=$row_i['matdesc'];?></strong></p>	

                                                                <span fs-9>Part No</span>
                                                                <p><strong class="text-primary"><?=$row_i['matno'];?></strong></p>

                                                                <span fs-9>Model</span>
                                                                <p><strong class="text-primary"><?=$row_i['modcode'];?></strong></p>
                                                            </div>
                                                        </div>
                                                        <div class="row task">
                                                        
                                                            <div class="col-xl-4 col-sm-6 col-8">
                                                                <div class="task-summary task-sven">
                                                                    <div class="d-flex align-items-baseline">
                                                                        <span class="mb-2">Inspection Date</span>
                                                                    </div>	
                                                                    <p><?=date('d-m-Y', strtotime($row_i['inspect_date']));?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-sm-6 col-8">
                                                                <div class="task-summary task-odd">
                                                                    <div class="d-flex align-items-baseline">
                                                                        <span class="mb-2">Production Date</span>
                                                                    </div>	
                                                                    <p><?=date('d-m-Y', strtotime($row_i['shift_date']));?></p>
                                                                </div>
                                                            </div>
                                                            <div class="col-xl-4 col-sm-6 col-8">
                                                                <div class="task-summary task-eleven">
                                                                    <div class="d-flex align-items-baseline">
                                                                        <span class="mb-2">Shift</span>
                                                                    </div>	
                                                                    <p> <span class="fs-13 badge badge-rounded badge-outline-danger"><?=$current_shiftdesc;?></span></p>
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
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Inspection Result</h4>
                                <div>
                                    <span class="text-success dang d-block">
                                        <span class="me-3 d-inline-flex align-items-center" data-bs-toggle="tooltip" title="OK">
                                            <svg class="me-1" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15 4.5L6.75 12.75L3 9" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                            <?= $total_ok ?>
                                        </span>

                                        <span class="d-inline-flex align-items-center" data-bs-toggle="tooltip" title="NG">
                                            <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#ca1d14ff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                                <line x1="6" y1="6" x2="18" y2="18"></line>
                                            </svg>
                                            <?= $total_ng ?>
                                        </span>
                                    </span>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    
                                    <div class="table-responsive">
                                        <table id="inspectionGroupsTable" class="display table mb-1 table-striped-thead table-wide table-md">
                                            <thead class="thead-black">
                                                <tr>
                                                    <th style="width: 15%;">Sequence Pallet No</th>
                                                    <th style="width: 20%;">Result</th>
                                                    <th style="width: 15%;">Defect</th>
                                                    <th style="width: 15%;">Total Defect</th>
                                                    <th style="width: 20%;">Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>                                            
                                            <tbody>

                                            <?php 

                                            $i = 1;
                                            foreach ($records as $row) {
                                                
                                                // All transaction status
                                                $sqlStatus = "SELECT statusid, statusname FROM system_status WHERE statusid = '$row[ir_status]' ";
                                                $resStatus = $db_con->query($sqlStatus);
                                                $rowStatus = $resStatus->fetch_assoc();

                                                $resultCell = ' <select class="form-control result-select resultSelect">
                                                                    <option value="">Choose</option>
                                                                    <option value="OK" '.($row['ir_result'] == 'OK' ? 'selected' : '').'>OK</option>
                                                                    <option value="NG" '.($row['ir_result'] == 'NG' ? 'selected' : '').'>NG</option>
                                                                </select>';

                                                //Status
                                                $badgeClass = '';

                                                if ($row['ir_status'] == 1) $badgeClass = 'badge-outline-info';
                                                elseif ($row['ir_status'] == 8) $badgeClass = 'badge-outline-danger';
                                                else if ($row['ir_status'] == 9) $badgeClass = 'badge-outline-secondary';
                                                else if ($row['ir_status'] == 10) $badgeClass = 'badge-outline-primary';
                                                else $badgeClass = 'badge-outline-light text-dark';

                                                $statusText = $rowStatus["statusname"];

                                                $statusCell = '<span class="badge badge-rounded '.$badgeClass.'" style="font-size:0.75rem;">'.$statusText.'</span>';

                                                //Defect
                                                $sql_def = "SELECT defect_type, defect_area, rcd_ir_id,
                                                            (   
                                                                SELECT COUNT(*) 
                                                                FROM inspection_defect 
                                                                WHERE rcd_ir_id = '$row[ir_id]'
                                                            )   AS defect_count 

                                                            FROM inspection_defect WHERE rcd_ir_id = ? ";
                                                $stmt_def = $db_con->prepare($sql_def);
                                                $stmt_def->bind_param('i', $row['ir_id']);
                                                $stmt_def->execute();
                                                $res_def = $stmt_def->get_result(); 
                                                $row_def = $res_def->fetch_assoc();                                                                                           

                                                $defectCell = '';

                                                if ($row['ir_result'] === 'NG') {

                                                    $defectCell = ' <button class="btn btn-rounded btn-primary btn-xxs AddDefectModal" 
                                                                        data-bs-toggle="tooltip"  data-bs-placement="top" title="Add defect"> <i class="fa fa-plus"></i>
                                                                   </button> ';
                                                }

                                                if ($row['ir_result'] === 'NG'  && $res_def->num_rows != 0) {

                                                    $defectCell .= ' <button class="btn btn-rounded btn-warning btn-xxs ViewDefect" data-irid="'.$row['ir_id'].'"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="View defect"><i class="fa fa-bars"></i>
                                                                    </button>';
                                                }

                                                $totalDef = '<a href="javascript:void(0)" class="badge badge-rounded badge-outline-dark">'.$row_def["defect_count"].'</a>';

                                                //Submit, cancel
                                                $actionCell =  '';

                                                if ($row['ir_status'] == 1) {

                                                    $actionCell = ' <button class="btn btn-rounded btn-red btn-xxs btnSubmit"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Submit inspection for review"><i class="fa-solid fa-paper-plane"></i>
                                                                    </button>';
                                                }
                                                elseif ($row['ir_status'] == 9) {

                                                    $actionCell .= ' <button class="btn btn-rounded btn-secondary btn-xxs btnCancel"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Cancel this submission from review"><i class="fa fa-times"></i>
                                                                    </button>';
                                                }

                                                echo "<tr>
                                                        <td>{$row['ir_pallet_no']}</td>
                                                        <td>{$resultCell}</td>
                                                        <td>{$defectCell}</td>
                                                        <td>{$totalDef}</td>
                                                        <td>{$statusCell}</td>
                                                        <td>{$actionCell}</td>
                                                    </tr>";
                                                $i++;
                                            }

                                            ?>

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
     <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js"></script>
    <script src="vendor/chart-js/chart.bundle.min.js"></script>
	<!-- Apex Chart -->
	<script src="vendor/apexchart/apexchart.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/responsive/responsive.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <!-- Daterangepicker -->
    <!-- momment js is must -->
    <script src="vendor/moment/moment.min.js"></script>
    <script src="vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- clockpicker -->
    <script src="vendor/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <!-- asColorPicker -->
	<script src="vendor/jquery-ascolor/jquery-ascolor.min.js"></script>
    <script src="vendor/jquery-asgradient/jquery-asgradient.min.js"></script>
    <script src="vendor/jquery-ascolorpicker/js/jquery-ascolorpicker.min.js"></script>
    <!-- Material color picker -->
    <script src="vendor/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>
    <!-- pickdate -->
    <script src="vendor/pickadate/picker.js"></script>
    <script src="vendor/pickadate/picker.time.js"></script>
    <script src="vendor/pickadate/picker.date.js"></script>

    <!-- Daterangepicker -->
    <script src="js/plugins-init/bs-daterange-picker-init.js"></script>
    <!-- Clockpicker init -->
    <script src="js/plugins-init/clock-picker-init.js"></script>
    <!-- asColorPicker init -->
	<script src="js/plugins-init/jquery-ascolorpicker.init.js"></script>
    <!-- Material color picker init -->
    <script src="js/plugins-init/material-date-picker-init.js"></script>
    <!-- Pickdate -->
    <script src="js/plugins-init/pickadate-init.js"></script>

    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>

    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
    </script>

    <script>
    
    // Pagination
    $('#inspectionGroupsTable').DataTable({

        paging: true,
        searching: true,
        info: true,
        lengthChange: false,        // hide "Show X entries"
        pageLength: 10,             // items per page
        ordering: false,            // keep your current row order
        stateSave: false,           // set true if you want it to remember page
        language: {
            paginate: { previous: '<i class="fa fa-angle-left"></i>', next: '<i class="fa fa-angle-right"></i>' }
        }
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
        // if (!status) status = 1; // fallback to 1 if undefined/null/empty

        // Collapse if already expanded
        if (row.next().hasClass('defect-details-row')) {
            row.next().remove();
            btn.removeClass('expanded');
            return;
        }

        // Remove any existing open rows first (optional)
        $('.defect-details-row').remove();
        $('.ViewDefect').removeClass('expanded');

        // Show loading state
        btn.addClass('expanded');
        let colspan = row.children('td').length;
        let loadingRow = $(`<tr class="defect-details-row"><td colspan="${colspan}" class="text-center">Loading defect details...</td></tr>`);
        row.after(loadingRow);
        
        // AJAX to get defect list
        $.ajax({
            url: 'fetch-inspection-rcd-defect-list.php',
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

                // run tooltip
                $('[data-bs-toggle="tooltip"]').tooltip();

            },
            error: function() {
                row.next().find('td').html('<div class="text-danger">Failed to load defect details.</div>');
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

    $(document).on('click', '.delete-defect', function() {  
        
        let defectId = $(this).data('defectid');
        let irId = $(this).data('irid');

        // Set the hidden field values!
        $('#ng_ir_id').val(irId);
        $('#ng_defect_id').val(defectId);

        // Set the hidden field values!
        $('#ng_ir_id').val(irId);

        if (!confirm('Remove this defect?')) return;

        $.ajax({
            url: 'inspection-rcd-defect-action.php',
            type: 'POST',
            dataType: 'json',
            data: { action : 'delete_defect',  defect_id: defectId, ir_id: irId },
            success: function(res) {
                if(res.success){
                    
                    alert('Record deleted successfully.');
                    reloadDefectTable($('#ng_ir_id').val(), 1);

                } else {
                    alert('Failed to delete record.');
                }
            }
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
                                <span class="remove-image-defect-old" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
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

    //Comparison photo
    function updatePreview_compare_ed(isEdit = false) {

        const c = $('#imagePreviewContainer_compare_ed');
        c.empty();

        // Existing (from DB)
        existing_compare_photos.forEach((img, idx) => {

            const imgId = img.compare_photoid;
            const imgUrl = encodeURI(img.url);

            const imgDiv = $(`<div class="avatar-preview me-2 mb-2 position-relative" data-exist="1" data-idx="${idx}" data-imgsrc="${imgUrl}" data-imgid="${imgId}">
                                <span class="remove-image-compare-old" style="position:absolute;top:-12px;right:-12px;cursor:pointer;font-size:18px;z-index:2;">&times;</span>
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

        var hasError = false;

        // Remove previous error states
        $('#fd_defectType_ed').removeClass('select-error');
        $('input[name="fd_area_ed[]"]').removeClass('checkbox-error');
        $('#imageUpload_defect_ed').removeClass('input-error');
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
            $('.area-grid').addClass('border-error');
            hasError = true;
            return;
        }
        if (totalDefectPhotos === 0) {
            alert('Please add at least one defect photo.');
            $('label[for="imageUpload_defect_ed"]').addClass('border-error');
            hasError = true;
            return;
        }
        if (totalComparePhotos === 0) {
            alert('Please add at least one comparing photo.');
            $('label[for="imageUpload_compare_ed"]').addClass('border-error');
            hasError = true;
            return;
        }
        if (!irId) {
            alert('System error: Missing record ID. Please try again.');
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
            url: 'fetch-inspection-rcd-defect-list.php',
            type: 'POST',
            data: { ir_id: ir_id, status: status },
            success: function(html) {
                $('#defectTableContainer').html(html);
            }
        });
    }

    </script>

    <script>

    //Submit for review
    $(document).on('click', '.btnSubmit', function(e) {
        
        e.preventDefault();

        let $btn = $(this);
        let ir_id = $btn.data('irid');

        if (!confirm('Are you sure you want to submit this inspection for review?')) {
            return;
        }

        $.ajax({
            url: 'inspection-rcd-action.php',
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

</body>
</html>