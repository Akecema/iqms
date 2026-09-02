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
    
	<!-- <link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/buttons/1.6.4/css/buttons.dataTables.min.css" rel="stylesheet"> -->

    <!-- Tagify Css -->
	<link href="vendor/tagify/dist/tagify.css" rel="stylesheet">	
	<link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
    
	<link href="vendor/nestable2/css/jquery.nestable.min.css" rel="stylesheet">
    <link href="vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">
    
    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
    <link href="css/badge.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
    <link href="css/image.css" rel="stylesheet">
    <style>
            .report-shell { display: grid; gap: 24px; }
            .report-hero {
                background: linear-gradient(135deg, #173320 0%, #2f5d3b 50%, #6d8f49 100%);
                border-radius: 20px;
                padding: 28px;
                color: #fff;
                box-shadow: 0 18px 40px rgba(23, 51, 32, 0.18);
            }
            .report-hero h2 { color: #fff; margin-bottom: 8px; }
            .report-hero p { margin-bottom: 0; max-width: 760px; color: rgba(255, 255, 255, 0.82); }
            .filter-card, .metric-card, .chart-card, .table-card {
                background: #fff;
                border-radius: 18px;
                box-shadow: 0 14px 32px rgba(17, 30, 24, 0.08);
                border: 1px solid #eef1ec;
            }
            
            @media (max-width: 767px) {
                .report-hero, .filter-card, .chart-card, .table-card, .metric-card { border-radius: 16px; }
            .table-responsive { overflow-x: auto; }
            .metric-value { font-size: 28px; }
        }
    </style>

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

        $startDate = date('m/01/Y') ; //2023-01-01
        $endDate = date('m/t/Y'); //2023-01-31
        
        ?>

        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
			<div class="container-fluid">
                <div class="report-shell">
                    <div class="report-hero">
                        <h2>Model Performance Report</h2>
                        <p>This section breaks down what types of defects are occurring most frequently within the structural categories.</p>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                            <div class="row">                    
                                <div class="col-12">
                                    <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                                    
                                        <style>

                                            #inspectionDefectModelSummary thead tr th:last-child{
                                                text-align: center !important; 
                                            }

                                            #defect-model-table thead tr th:last-child{
                                                text-align: center !important; 
                                            }

                                            #defect-model-table th{
                                                border-bottom: 3px solid #6c8f6cff !important;
                                            }

                                            th{
                                                border-bottom: 2px solid #1f7c17ff;
                                            }

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

                                            .custom-table-summary thead th {
                                                background-color: #f8f9fa;
                                                font-weight: 700;
                                                text-transform: uppercase;
                                                font-size: 12px;
                                            }
                                            .custom-table-summary tbody td {
                                                font-size: 13px;
                                            }
                                            .table-total td, .table-total th {
                                                background-color: #364536ff !important;
                                                color: white !important;
                                                font-weight : 500 !important;
                                            }
                                            .cs-border-primary
                                            {
                                                border-color : #c6c7c5ff;
                                            }

                                            #defect-model-table thead th {
                                                position: sticky;
                                                top: 0;
                                                z-index: 2;
                                                background-color: #f8f9fa; /* Ensuring background covers the scroll space */
                                            }

                                            #defect-model-table tfoot td, #defect-model-table tfoot th {
                                                position: sticky;
                                                bottom: 0;
                                                z-index: 2;
                                                background-color: #364536ff !important;
                                            }
                                            .form-select-sm{
                                                min-width:160px; 
                                                min-height:30px;
                                                font-weight:500;
                                            }
                                            .analysis-type-filter .card { border-radius: 8px; border: 1px solid #eee; }
                                        </style>

                                        <?php
                                        // ============================================================
                                        // Centralized Filter Variables
                                        // ============================================================
                                        $f_fy       = isset($_GET['f_fy'])       && !empty($_GET['f_fy'])       ? mysqli_real_escape_string($db_con, $_GET['f_fy'])       : $financialyr;
                                        $f_month    = isset($_GET['f_month'])    && !empty($_GET['f_month'])    ? intval($_GET['f_month'])    : '';
                                        $f_quarter  = isset($_GET['f_quarter'])  && !empty($_GET['f_quarter'])  ? intval($_GET['f_quarter'])  : '';
                                        $f_type     = isset($_GET['f_type'])     && !empty($_GET['f_type'])     ? intval($_GET['f_type'])     : '';
                                        $f_model    = isset($_GET['f_model'])    && !empty($_GET['f_model'])    ? intval($_GET['f_model'])    : '';
                                        $f_daterange= isset($_GET['f_daterange'])&& !empty($_GET['f_daterange'])? mysqli_real_escape_string($db_con, $_GET['f_daterange']): '';
                                        $f_shift    = isset($_GET['f_shift'])    && !empty($_GET['f_shift'])    ? mysqli_real_escape_string($db_con, $_GET['f_shift'])    : '';

                                        // Fetch FY date bounds for the selected financial year
                                        $fy_bounds_sql = "SELECT date_start, date_end FROM financial_year WHERE financial_year = '$f_fy' LIMIT 1";
                                        $fy_bounds_res = mysqli_query($db_con, $fy_bounds_sql);
                                        $fy_date_start = '';
                                        $fy_date_end   = '';
                                        if ($fy_bounds_res && $fy_bounds_row = mysqli_fetch_assoc($fy_bounds_res)) {
                                            $fy_date_start = $fy_bounds_row['date_start'] ?? ''; 
                                            $fy_date_end   = $fy_bounds_row['date_end']   ?? '';
                                        }

                                        // Build shared WHERE extra conditions (using S. prefix to match queries)
                                        $filter_sql = "";
                                        if (!empty($f_month))     $filter_sql .= " AND MONTH(S.inspect_date) = '$f_month'";
                                        if (!empty($f_shift))     $filter_sql .= " AND S.ir_shift = '$f_shift'";
                                        if (!empty($f_type))      $filter_sql .= " AND S.ir_type = '$f_type'";
                                        if (!empty($f_model))     $filter_sql .= " AND S.ir_model = '$f_model'";

                                        if (!empty($f_daterange)) {
                                            $dates = explode(' - ', $f_daterange);
                                            if (count($dates) == 2) {
                                                $f_start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
                                                $f_end_date   = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
                                                $filter_sql  .= " AND DATE(S.inspect_date) BETWEEN '$f_start_date' AND '$f_end_date'";
                                            }
                                        }

                                        if (!empty($f_quarter)) {
                                            $qtr_row_sql = "SELECT month_start, month_end FROM financial_quarter WHERE quarter_id = '$f_quarter' LIMIT 1";
                                            $qtr_row_res = mysqli_query($db_con, $qtr_row_sql);
                                            if ($qtr_row_res && $qtr_row = mysqli_fetch_assoc($qtr_row_res)) {
                                                $qm_start = (int)$qtr_row['month_start'];
                                                $qm_end   = (int)$qtr_row['month_end'];
                                                if ($qm_start && $qm_end) {
                                                    $filter_sql .= " AND MONTH(S.inspect_date) BETWEEN '$qm_start' AND '$qm_end'";
                                                }
                                            }
                                        }

                                        $targetFY = $f_fy;
                                        $targetFY_m = $f_fy; // Backward compatibility for some old variables

                                        // Fetch dropdown data
                                        $fy_res_f  = mysqli_query($db_con, "SELECT financial_year, financial_desc FROM financial_year ORDER BY financial_year DESC");
                                        $qtr_res   = mysqli_query($db_con, "SELECT quarter_id, quarter_name FROM financial_quarter ORDER BY quarter_id ASC");
                                        $type_res  = mysqli_query($db_con, "SELECT typeid, typemodel FROM model_type WHERE typestatus='Y' AND compcd='$session_comp' AND plant='$session_plant' ORDER BY typemodel ASC");
                                        $mod_res   = mysqli_query($db_con, "SELECT modid, modcode FROM model_details WHERE modstatus='Y' AND compcd='$session_comp' AND plant='$session_plant' ORDER BY modcode ASC");
                                        $shift_res = mysqli_query($db_con, "SELECT shiftshort, shiftdesc FROM shift_detail ORDER BY shiftshort ASC");
                                        $months_list = [1=>'January', 2=>'February', 3=>'March', 4=>'April', 5=>'May', 6=>'June', 7=>'July', 8=>'August', 9=>'September', 10=>'October', 11=>'November', 12=>'December'];
                                        ?>

                                        <div class="col-xl-12 analysis-type-filter mb-4">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body py-3 px-4">
                                                    <form method="GET" id="filterFormMain">
                                                        <div class="row g-2 align-items-end mb-2">
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Financial Year</label>
                                                                <select name="f_fy" id="f_fy" class="form-select form-select-sm cs-border-primary text-primary" onchange="document.getElementById('f_daterange').value=''; this.form.submit()">
                                                                    <?php while($fy_row = mysqli_fetch_assoc($fy_res_f)): ?>
                                                                        <option value="<?= $fy_row['financial_year'] ?>" <?= ($f_fy == $fy_row['financial_year']) ? 'selected' : '' ?>>
                                                                            FY <?= $fy_row['financial_desc'] ?>
                                                                        </option>
                                                                    <?php endwhile; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Month</label>
                                                                <select name="f_month" id="f_month" class="form-select form-select-sm cs-border-primary">
                                                                    <option value="">- All Months -</option>
                                                                    <?php foreach($months_list as $mnum => $mname): ?>
                                                                        <option value="<?= $mnum ?>" <?= ($f_month == $mnum) ? 'selected' : '' ?>><?= $mname ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Quarter</label>
                                                                <select name="f_quarter" id="f_quarter" class="form-select form-select-sm cs-border-primary">
                                                                    <option value="">- All Quarters -</option>
                                                                    <?php if($qtr_res): while($qtr_row = mysqli_fetch_assoc($qtr_res)): ?>
                                                                        <option value="<?= $qtr_row['quarter_id'] ?>" <?= ($f_quarter == $qtr_row['quarter_id']) ? 'selected' : '' ?>><?= htmlspecialchars($qtr_row['quarter_name']) ?></option>
                                                                    <?php endwhile; endif; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Type</label>
                                                                <select name="f_type" id="f_type" class="form-select form-select-sm cs-border-primary">
                                                                    <option value="">- All Types -</option>
                                                                    <?php if($type_res): mysqli_data_seek($type_res, 0); while($t_row = mysqli_fetch_assoc($type_res)): ?>
                                                                        <option value="<?= $t_row['typeid'] ?>" <?= ($f_type == $t_row['typeid']) ? 'selected' : '' ?>><?= htmlspecialchars($t_row['typemodel']) ?></option>
                                                                    <?php endwhile; endif; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Model</label>
                                                                <select name="f_model" id="f_model" class="form-select form-select-sm cs-border-primary">
                                                                    <option value="">- All Models -</option>
                                                                    <?php if($mod_res): while($m_row = mysqli_fetch_assoc($mod_res)): ?>
                                                                        <option value="<?= $m_row['modid'] ?>" <?= ($f_model == $m_row['modid']) ? 'selected' : '' ?>><?= htmlspecialchars($m_row['modcode']) ?></option>
                                                                    <?php endwhile; endif; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="row g-2 align-items-end">
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Inspection Date Range</label>
                                                                <div class="input-group input-group-sm">
                                                                    <span class="input-group-text" style="min-height:35px;"><i class="fa fa-calendar" style="font-size:10px;"></i></span>
                                                                    <input type="text" name="f_daterange" id="f_daterange" class="form-control" placeholder="dd/mm/yyyy - dd/mm/yyyy" value="<?= htmlspecialchars($f_daterange) ?>" style="min-width:200px;min-height:35px;font-size:11px;" autocomplete="off">
                                                                </div>
                                                            </div>
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Shift</label>
                                                                <select name="f_shift" id="f_shift" class="form-select form-select-sm cs-border-primary">
                                                                    <option value="">- All Shifts -</option>
                                                                    <?php if($shift_res): while($sh_row = mysqli_fetch_assoc($shift_res)): ?>
                                                                        <option value="<?= $sh_row['shiftshort'] ?>" <?= ($f_shift == $sh_row['shiftshort']) ? 'selected' : '' ?>><?= htmlspecialchars($sh_row['shiftdesc']) ?></option>
                                                                    <?php endwhile; endif; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-auto d-flex gap-2">
                                                                <button type="submit" class="btn btn-sm btn-black" style="min-width:80px;">Apply</button>
                                                                <a href="ip-inspection-report-defect-model.php" class="btn btn-sm btn-dark" style="min-width:80px;"><i class="fa fa-redo me-1"></i> Reset</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <!-- by type & model -->
                                            <div class="col-xl-12 mb-4 defect-model">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom">
                                                        <div>
                                                            <h4 class="heading mb-0">Total Defects by Model</h4>                                                        
                                                        </div>
                                                        
                                                        <div class="dropdown custom-dropdown justify-content-end d-flex mb-3">
                                                            <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; background: transparent; border: none;">
                                                                <i class="fa fa-bars" style="font-size: 18px; color: #5a5c69;"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="export-inspection-report-model-total-defect.php" id="btnExportExcelModelSummary"><i class="fa fa-file-excel text-green me-2"></i> Download Excel</a></li>
                                                                <li><a class="dropdown-item" href="export-inspection-report-model-total-defect-pdf.php" id="btnExportPdfModelSummary" target="_blank"><i class="fa fa-file-pdf text-red me-2"></i> Download PDF</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                                
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                                            <div class="d-flex align-items-center gap-3">                                                              
                                                            </div>
                                                            
                                                            <div class="d-flex align-items-center m-0">
                                                                <!-- Filter form removed (moved to top) -->
                                                            </div>
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped custom-table-summary" id="inspectionDefectModelSummary">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Type</th>
                                                                        <th>Model</th>
                                                                        <th class="text-center">Total Inspection</th>
                                                                        <th class="text-center">Defects Qty</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    // Breakdown by Type and Model
                                                                    $sql_defect_model_sum = "SELECT 
                                                                                            MT.typemodel AS type_name,
                                                                                            MD.modcode AS model_name,MD.modid,
                                                                                            COUNT(D.defect_id) AS total_qty,
                                                                                            (SELECT COUNT(ir_id) FROM inspection_records S WHERE ir_type = MT.typeid AND ir_model = MD.modid AND financial_yr = '$targetFY_m' AND ir_status = '5' $filter_sql) AS total_inspection
                                                                                        FROM model_type MT
                                                                                        JOIN model_details MD ON 1=1
                                                                                        LEFT JOIN inspection_records S ON S.ir_type = MT.typeid 
                                                                                                AND S.ir_model = MD.modid 
                                                                                                AND S.financial_yr = '$targetFY_m' 
                                                                                                AND S.ir_status = '5' $filter_sql
                                                                                        LEFT JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id
                                                                                        WHERE MT.typestatus = 'Y' AND MT.compcd = '$session_comp' AND MT.plant = '$session_plant'
                                                                                            AND MD.modstatus = 'Y' AND MD.compcd = '$session_comp' AND MD.plant = '$session_plant'
                                                                                        GROUP BY MT.typeid, MD.modid
                                                                                        HAVING total_inspection > 0
                                                                                        ORDER BY MT.typemodel ASC, total_qty DESC";
                                                                    $res_defect_model_sum = mysqli_query($db_con, $sql_defect_model_sum);
                                                                    
                                                                    $data_rows_sum = [];
                                                                    $group_counts_sum = [];
                                                                    $grand_total_qty_sum = 0;
                                                                    $grand_total_inspection_sum = 0;
                                                                    
                                                                    while ($row = mysqli_fetch_assoc($res_defect_model_sum)) {
                                                                        $data_rows_sum[] = $row;
                                                                        $group_counts_sum[$row['type_name']] = ($group_counts_sum[$row['type_name']] ?? 0) + 1;
                                                                        $grand_total_qty_sum += (int)$row['total_qty'];
                                                                        $grand_total_inspection_sum += (int)$row['total_inspection'];
                                                                    }
                                                                    
                                                                    if (!empty($data_rows_sum)) {
                                                                        $current_type = '';
                                                                        foreach ($data_rows_sum as $row) {
                                                                            echo "<tr>";
                                                                            if ($current_type !== $row['type_name']) {
                                                                                $rowspan = $group_counts_sum[$row['type_name']];
                                                                                echo "<td rowspan='$rowspan' class='align-middle'><strong>{$row['type_name']}</strong></td>";
                                                                                $current_type = $row['type_name'];
                                                                            }
                                                                            echo "<td>{$row['model_name']}</td>";
                                                                            echo "<td class='text-center'>{$row['total_inspection']}</td>";
                                                                            echo "<td class='text-center'>{$row['total_qty']}</td>";
                                                                            echo "</tr>";
                                                                        }
                                                                        
                                                                        // Grand Total Row
                                                                        echo "<tr class='table-total'>";
                                                                        echo "<td colspan='2'>GRAND TOTAL</td>";
                                                                        echo "<td class='text-center'>" . number_format($grand_total_inspection_sum) . "</td>";
                                                                        echo "<td class='text-center'>" . number_format($grand_total_qty_sum) . "</td>";
                                                                        echo "</tr>";
                                                                    } else {
                                                                        echo "<tr><td colspan='4' class='text-center'>No data available</td></tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>

                                            <!-- Inspection vs defect -->
                                            <div class="col-xl-6 col-lg-6 mb-4 defect-model">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom">
                                                        <div>
                                                            <h4 class="heading mb-0">Total Inspections & Defects</h4>                                                        
                                                        </div>
                                                    </div>
                                                                
                                                    <div class="card-body">
                                                        <?php
                                                        $inspect_models_data = [];
                                                        foreach ($data_rows_sum as $row) {
                                                            $model_name = $row['model_name'];
                                                            // Prevent double counting total inspection since the query duplicates lines across Types
                                                            // Wait, but total_inspection in subquery is ALREADY per model type.
                                                            // Actually, the subquery we wrote was: 
                                                            // (SELECT COUNT(ir_id) FROM inspection_records WHERE ir_type = MT.typeid AND ... AND ir_status = '5')
                                                            // So summing it across different types is CORRECT!
                                                            if (!isset($inspect_models_data[$model_name])) {
                                                                $inspect_models_data[$model_name] = [
                                                                    'inspection' => 0,
                                                                    'defect' => 0
                                                                ];
                                                            }
                                                            $inspect_models_data[$model_name]['inspection'] += (int)$row['total_inspection'];
                                                            $inspect_models_data[$model_name]['defect'] += (int)$row['total_qty'];
                                                        }
                                                        
                                                        $inspect_categories = array_keys($inspect_models_data);
                                                        $inspect_series_total = [];
                                                        $inspect_series_defect = [];
                                                        foreach ($inspect_categories as $m) {
                                                            $inspect_series_total[] = $inspect_models_data[$m]['inspection'];
                                                            $inspect_series_defect[] = $inspect_models_data[$m]['defect'];
                                                        }
                                                        ?>
                                                        <div id="chartInspectionVsDefect"></div>
                                                        <script>
                                                            var categoriesInspect = <?= json_encode($inspect_categories) ?>;
                                                            var seriesInspectData = [
                                                                {
                                                                    name: 'Total Inspection',
                                                                    data: <?= json_encode($inspect_series_total) ?>
                                                                },
                                                                {
                                                                    name: 'Defects Qty',
                                                                    data: <?= json_encode($inspect_series_defect) ?>
                                                                }
                                                            ];
                                                        </script>
                                                    </div> 
                                                </div>
                                            </div>

                                            <!-- Model vs defect -->
                                            <div class="col-xl-6 col-lg-6 mb-4 defect-model-overview">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom">
                                                        <div>
                                                            <h4 class="heading mb-0">Total Defects Overview</h4>                                                        
                                                        </div>                                                    
                                                    
                                                    </div>
                                                                
                                                    <div class="card-body">

                                                        <?php
                                                        $chart_types = array_keys($group_counts_sum);
                                                        $chart_models = [];
                                                        foreach ($data_rows_sum as $row) {
                                                            if (!in_array($row['model_name'], $chart_models)) {
                                                                $chart_models[] = $row['model_name'];
                                                            }
                                                        }
                                                        
                                                        $chart_series = [];
                                                        foreach ($chart_models as $model) {
                                                            $data_for_model = [];
                                                            foreach ($chart_types as $type) {
                                                                $qty = 0;
                                                                foreach ($data_rows_sum as $row) {
                                                                    if ($row['model_name'] === $model && $row['type_name'] === $type) {
                                                                        $qty = (int)$row['total_qty'];
                                                                        break;
                                                                    }
                                                                }
                                                                $data_for_model[] = $qty;
                                                            }
                                                            $chart_series[] = [
                                                                'name' => $model,
                                                                'data' => $data_for_model
                                                            ];
                                                        }
                                                        ?>
                                                        <div id="chartModelOverview"></div>
                                                        
                                                        <script>
                                                            var chartTypes = <?= json_encode(array_values($chart_types)) ?>;
                                                            var chartSeries = <?= json_encode($chart_series) ?>;
                                                        </script>                                                    
                                                        
                                                    </div> 
                                                </div>
                                            </div>

                                            <?php
                                            // 1. Get Column Headers (Model Details)
                                            $sql_md = "SELECT modid, modcode FROM model_details 
                                                    WHERE modstatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant' 
                                                    ORDER BY modcode ASC";
                                            $res_md = mysqli_query($db_con, $sql_md);
                                            $models = [];
                                            while($row = mysqli_fetch_assoc($res_md)) $models[] = $row;

                                            // 2. Get Row Headers (Defect Categories)
                                            $sql_dt = "SELECT defectid, defectname FROM defect_type WHERE defectstatus = 'Y' ORDER BY defectname ASC";
                                            $res_dt = mysqli_query($db_con, $sql_dt);
                                            $defect_categories = [];
                                            while($row = mysqli_fetch_assoc($res_dt)) $defect_categories[] = $row;

                                            // 3. Get Defect Data Matrix
                                            $sql_data_m = "SELECT 
                                                            ID.defect_type, 
                                                            S.ir_model as model_id, 
                                                            COUNT(ID.defect_id) as qty
                                                        FROM inspection_records S
                                                        JOIN inspection_defect ID ON ID.rcd_ir_id = S.ir_id
                                                        WHERE S.financial_yr = '$targetFY' 
                                                        AND S.ir_result = 'NG' AND S.ir_status = '5' $filter_sql
                                                        GROUP BY ID.defect_type, S.ir_model";
                                            $res_data_m = mysqli_query($db_con, $sql_data_m);
                                            $matrix_m = [];
                                            while($row = mysqli_fetch_assoc($res_data_m)){
                                                $matrix_m[$row['defect_type']][$row['model_id']] = $row['qty'];
                                            }

                                            // Calculate Grand Total for detailed percentage
                                            $grand_total_m = 0;
                                            foreach($matrix_m as $def_id => $m_data) {
                                                foreach($m_data as $qty) $grand_total_m += $qty;
                                            }

                                            // Find Top Defect Category (e.g. Crack, Dent)
                                            $peak_cat_name = "N/A";
                                            $peak_cat_qty = 0;
                                            foreach($defect_categories as $dt) {
                                                $row_sum = 0;
                                                foreach($models as $m) {
                                                    $row_sum += (int)($matrix_m[$dt['defectid']][$m['modid']] ?? 0);
                                                }
                                                if($row_sum > $peak_cat_qty) {
                                                    $peak_cat_qty = $row_sum;
                                                    $peak_cat_name = $dt['defectname'];
                                                }
                                            }

                                            // --- Prepare Chart Data for Defect Type Analysis ---
                                            $chart_defect_categories = [];
                                            $chart_defect_series_data = [];
                                            $temp_defect_types = [];

                                            // Identify defect types that have data
                                            foreach($defect_categories as $dt) {
                                                $row_sum = 0;
                                                foreach($models as $m) {
                                                    $row_sum += (int)($matrix_m[$dt['defectid']][$m['modid']] ?? 0);
                                                }
                                                if ($row_sum > 0) {
                                                    $chart_defect_categories[] = $dt['defectname'];
                                                    $temp_defect_types[] = $dt['defectid'];
                                                }
                                            }

                                            // Build the series for each model
                                            foreach($models as $m) {
                                                $model_data = [];
                                                foreach($temp_defect_types as $dt_id) {
                                                    $model_data[] = (int)($matrix_m[$dt_id][$m['modid']] ?? 0);
                                                }
                                                $chart_defect_series_data[] = [
                                                    'name' => $m['modcode'],
                                                    'data' => $model_data
                                                ];
                                            }

                                            // Calculate Insights for Model Page
                                            $peak_model_name = "N/A";
                                            $peak_model_qty = 0;
                                            if(!empty($inspect_models_data)) {
                                                foreach($inspect_models_data as $m_name => $vals) {
                                                    if($vals['defect'] > $peak_model_qty) {
                                                        $peak_model_qty = $vals['defect'];
                                                        $peak_model_name = $m_name;
                                                    }
                                                }
                                            }
                                            $ov_model_rate = ($grand_total_inspection_sum > 0) ? ($grand_total_qty_sum / $grand_total_inspection_sum) * 100 : 0;
                                            ?>

                                            <!-- by model details -->
                                            <div class="col-xl-12">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom d-flex justify-content-between align-items-center flex-wrap">
                                                        <div>
                                                            <h4 class="heading mb-0">Defect Type Details</h4>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <div class="dropdown custom-dropdown">
                                                                <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; background: transparent; border: none;">
                                                                    <i class="fa fa-bars" style="font-size: 18px; color: #5a5c69;"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li><a class="dropdown-item" id="exportExcelBtnModel" href="export-inspection-report-defect-model-details.php?fy=<?= $targetFY_m ?>"><i class="fa fa-file-excel text-green me-2"></i> Download Excel</a></li>
                                                                    <li><a class="dropdown-item" id="exportPdfBtnModel" href="export-inspection-report-defect-model-details-pdf.php?fy=<?= $targetFY_m ?>" target="_blank"><i class="fa fa-file-pdf text-red me-2"></i> Download PDF</a></li>
                                                                </ul>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                            
                                                    <div class="card-body defect-model">

                                                        <?php
                                                        $targetFY = isset($_GET['fy_type']) && !empty($_GET['fy_type']) ? mysqli_real_escape_string($db_con, $_GET['fy_type']) : $financialyr;

                                                        $fy_sql = "SELECT financial_year, financial_desc FROM financial_year ORDER BY financial_year DESC";
                                                        $fy_res = mysqli_query($db_con, $fy_sql);
                                                        ?>

                                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                                            <div class="d-flex align-items-center gap-3">                                                         
                                                                <div class="input-group search-area d-none d-md-inline-flex" style="width: 250px; margin-left: 3px;">
                                                                    <input type="text" class="form-control" id="defectModelSearchInput" placeholder="Search defect name...">
                                                                    <span class="input-group-text">
                                                                        <a href="javascript:void(0)">
                                                                            <i class="flaticon-381-search-2"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            <div class="d-flex align-items-center m-0">
                                                                <!-- Filter form removed (moved to top) -->
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="table-responsive" style="max-height: 500px; overflow-y: auto; overflow-x: auto;">
                                                            <?php
                                                            // Data prepared at top of section
                                                            ?>

                                                            <table class="table table-bordered table-striped custom-table-summary" id="defect-model-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Defect Type</th>
                                                                        <?php foreach($models as $m): ?>
                                                                            <th class="text-center"><?= $m['modcode']; ?></th>
                                                                        <?php endforeach; ?>
                                                                        <th class="text-center">Total</th>
                                                                        <th class="text-center">Percentage (%)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    $col_totals_m = array_fill_keys(array_column($models, 'modid'), 0);
                                                                    
                                                                    foreach($defect_categories as $dt): 
                                                                        $row_id = $dt['defectid'];
                                                                        $row_sum = 0;
                                                                    ?>
                                                                        <tr>
                                                                            <td><strong><?= $dt['defectname']; ?></strong></td>
                                                                            <?php foreach($models as $m): 
                                                                                $m_id = $m['modid'];
                                                                                $qty = $matrix_m[$row_id][$m_id] ?? 0;
                                                                                $row_sum += $qty;
                                                                                $col_totals_m[$m_id] += $qty;
                                                                            ?>
                                                                            <td class="text-center" style="<?= $qty > 0 ? 'color: #af0808ff; font-weight: 600;' : '' ?>"><?= $qty > 0 ? number_format($qty) : '-'; ?></td>
                                                                            <?php endforeach; ?>
                                                                            <td class="text-center"><strong><?= number_format($row_sum); ?></strong></td>
                                                                            <td class="text-center"><?= $grand_total_m > 0 ? round(($row_sum / $grand_total_m) * 100) : 0; ?>%</td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr class="table-total">
                                                                        <td>Total</td>
                                                                        <?php foreach($models as $m): ?>
                                                                            <td class="text-center"><?= number_format($col_totals_m[$m['modid']]); ?></td>
                                                                        <?php endforeach; ?>
                                                                        <td class="text-center"><?= number_format($grand_total_m); ?></td>
                                                                        <td class="text-center">100%</td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>

                                            <div class="col-xl-12">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom d-flex justify-content-between align-items-center flex-wrap">
                                                        <div>
                                                            <h4 class="heading mb-0">Defect Type Analysis Graph</h4>
                                                            <span class="d-block mt-1" style="font-size: 11px; font-weight:400; color: #888;">This chart visualizes the distribution of different defect types across all models.</span>
                                                        </div>
                                                    </div>
                                                            
                                                    <div class="card-body defect-model">                                                   
                                                        <!-- Defect Type Analysis Graph -->
                                                        <div id="chartDefectTypeDetails"></div>
                                                    </div> 
                                                </div>
                                            </div>

                                            
                                            <div class="col-xl-12 mb-4">
                                                <div class="card border-0 shadow-sm" style="box-shadow: 0 0.125rem 0.25rem #9c9898ff !important;">
                                                    <div class="card-header border-0 border-bottom">
                                                        <h4 class="heading mb-0"><i class="fa fa-lightbulb me-2" aria-hidden="true"></i> Insights</h4>
                                                    </div>
                                                    <div class="card-body py-3 px-4">
                                                        <ul style="list-style-type: none; padding: 0; margin-top: 10px;">
                                                            <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                                <div style="min-width: 6px; height: 6px; background: #11470F; border-radius: 50%; margin-top: 6px;"></div>
                                                                <div>Total inspection volume reached <strong><?= number_format($grand_total_inspection_sum) ?></strong> units with <strong><?= number_format($grand_total_qty_sum) ?></strong> total defects detected.</div>
                                                            </li>
                                                            <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                                <div style="min-width: 6px; height: 6px; background: #11470F; border-radius: 50%; margin-top: 6px;"></div>
                                                                <div>The overall defect rate for this period is <strong><?= number_format($ov_model_rate, 2) ?>%</strong>.</div>
                                                            </li>
                                                            <?php if($peak_model_qty > 0): ?>
                                                                <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                                    <div style="min-width: 6px; height: 6px; background: #af0808; border-radius: 50%; margin-top: 6px;"></div>
                                                                    <div>Performance Alert: <strong><?= $peak_model_name ?></strong> is the model with the highest defect count (<?= number_format($peak_model_qty) ?> instances).</div>
                                                                </li>
                                                            <?php endif; ?>
                                                            <?php if($peak_cat_qty > 0): ?>
                                                                <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                                    <div style="min-width: 6px; height: 6px; background: #af0808; border-radius: 50%; margin-top: 6px;"></div>
                                                                    <div>Significant Alert: <strong><?= $peak_cat_name ?></strong> is the most common defect type found in this period (<?= number_format($peak_cat_qty) ?> cases).</div>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
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

    <script src="js/custom.min.js"></script>
    <script src="vendor/moment/moment.min.js"></script>
    <script src="vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
    <script src="js/deznav-init.js"></script>
    
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="vendor/apexchart/apexchart.js"></script>

    <script>
    $(document).ready(function(){
        // Back buttons
        $('#btnBack').on('click', function() {
            history.back();
        });

        // Date Range Picker Initialization
        $('#f_daterange').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            minDate: '<?= !empty($fy_date_start) ? DateTime::createFromFormat("Y-m-d", $fy_date_start)->format("d/m/Y") : "" ?>',
            maxDate: '<?= !empty($fy_date_end) ? DateTime::createFromFormat("Y-m-d", $fy_date_end)->format("d/m/Y") : "" ?>',
            locale: {
                format: 'DD/MM/YYYY',
                cancelLabel: 'Clear'
            }
        });

        $('#f_daterange').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
        });

        $('#f_daterange').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        function updateExportLinks() {
            var f_fy        = $('#f_fy').val();
            var f_month     = $('#f_month').val();
            var f_quarter   = $('#f_quarter').val();
            var f_type      = $('#f_type').val();
            var f_model     = $('#f_model').val();
            var f_daterange = $('#f_daterange').val();
            var f_shift     = $('#f_shift').val();
            var search      = $('#defectModelSearchInput').val() || '';
            
            var params = `f_fy=${f_fy}&f_month=${f_month}&f_quarter=${f_quarter}&f_type=${f_type}&f_model=${f_model}&f_daterange=${encodeURIComponent(f_daterange)}&f_shift=${f_shift}&search=${encodeURIComponent(search)}`;
            
            $("#btnExportExcelModelSummary").attr("href", `export-inspection-report-model-total-defect.php?${params}`);
            $("#btnExportPdfModelSummary").attr("href", `export-inspection-report-model-total-defect-pdf.php?${params}`);
            $("#exportExcelBtnModel").attr("href", `export-inspection-report-defect-model-details.php?${params}`);
            $("#exportPdfBtnModel").attr("href", `export-inspection-report-defect-model-details-pdf.php?${params}`);
        }

        // Initial call
        updateExportLinks();

        if(typeof ApexCharts !== 'undefined' && document.querySelector("#chartInspectionVsDefect")){
            var optionsInspect = {
                series: seriesInspectData,
                chart: {
                    type: 'bar',
                    height: 450,
                    toolbar: {
                        show: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 2,
                        dataLabels: {
                            position: 'top',
                            offsetY: -20
                        },
                    },
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -20,
                    style: {
                        fontSize: '12px',
                        colors: ["#304758"]
                    }
                },
                stroke: {
                    show: true,
                    width: 2,
                    colors: ['transparent']
                },
                xaxis: {
                    categories: categoriesInspect,
                },
                yaxis: {
                    title: {
                        text: 'Quantity'
                    }
                },
                fill: {
                    opacity: 1
                },
                colors: [ '#232A1C','#388031'], // Blue for Inspection, Red for Defect
                tooltip: {
                    y: {
                        formatter: function (val) {
                            return val
                        }
                    }
                }
            };
            var chartInspect = new ApexCharts(document.querySelector("#chartInspectionVsDefect"), optionsInspect);
            chartInspect.render();
        }

        if(typeof ApexCharts !== 'undefined' && document.querySelector("#chartModelOverview")){
            var options = {
                series: chartSeries,
                colors: ['#163313', '#214d1d', '#2d6627', '#388031', '#438A3B', '#4FB445', '#65C05D', '#7ECA76', '#96D490'], // Define your custom colors here
                chart: {
                    type: 'bar',
                    height: 450,
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                responsive: [{
                    breakpoint: 480,
                    options: {
                        legend: {
                            position: 'bottom',
                            offsetX: -10,
                            offsetY: 0
                        }
                    }
                }],
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 2,
                        columnWidth: '40%',
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 900
                                }
                            }
                        }
                    },
                },
                xaxis: {
                    categories: chartTypes,
                },
                yaxis: {
                    title: {
                        text: 'Total Qty',
                        style: {
                            fontWeight: 500,
                        }
                    }
                },
                legend: {
                    position: 'bottom',
                    offsetY: 5
                },
                fill: {
                    opacity: 1
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartModelOverview"), options);
            chart.render();
        }

        if(typeof ApexCharts !== 'undefined' && document.querySelector("#chartDefectTypeDetails")){
            var optionsDefectType = {
                series: <?= json_encode($chart_defect_series_data) ?>,
                colors: ['#163313', '#214d1d', '#2d6627', '#388031', '#438A3B', '#4FB445', '#65C05D', '#7ECA76', '#96D490'],
                chart: {
                    type: 'bar',
                    height: 500,
                    stacked: true,
                    toolbar: {
                        show: true
                    },
                    zoom: {
                        enabled: true
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: true,
                        borderRadius: 2,
                        barHeight: '60%',
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '11px',
                                    fontWeight: 900
                                }
                            }
                        }
                    },
                },
                xaxis: {
                    categories: <?= json_encode($chart_defect_categories) ?>,
                },
                yaxis: {
                    title: {
                        text: 'Defect Types',
                        style: {
                            fontWeight: 500,
                        }
                    }
                },
                legend: {
                    position: 'top',
                    offsetY: 0
                },
                fill: {
                    opacity: 1
                }
            };

            var chartDefectType = new ApexCharts(document.querySelector("#chartDefectTypeDetails"), optionsDefectType);
            chartDefectType.render();
        }


        function recalculateTotalsModel() {
            let colTotals = [];
            let grandTotal = 0;
            let sumPercent = 0;
            let numCols = $("#defect-model-table thead tr th").length;
            
            for (let i = 1; i < numCols - 2; i++) {
                colTotals[i] = 0;
            }

            $("#defect-model-table tbody tr:visible").each(function() {
                let row = $(this);
                for (let i = 1; i < numCols - 2; i++) {
                    let cellVal = row.find('td').eq(i).text().replace(/,/g, '').trim();
                    let val = cellVal === '-' ? 0 : parseInt(cellVal);
                    if (!isNaN(val)) {
                        colTotals[i] += val;
                        grandTotal += val;
                    }
                }
                
                let rowPercentText = row.find('td').eq(numCols - 1).text().replace('%', '').trim();
                let rowPercent = parseInt(rowPercentText);
                if (!isNaN(rowPercent)) {
                    sumPercent += rowPercent;
                }
            });

            let footerRow = $("#defect-model-table tfoot tr");
            for (let i = 1; i < numCols - 2; i++) {
                footerRow.find('td').eq(i).text(colTotals[i] > 0 ? colTotals[i].toLocaleString() : '-');
            }
            
            footerRow.find('td').eq(numCols - 2).text(grandTotal.toLocaleString());
            footerRow.find('td').eq(numCols - 1).text(sumPercent + '%');
        }

        $("#defectModelSearchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#defect-model-table tbody tr").filter(function() {
                var defectName = $(this).find("td:first").text().toLowerCase();
                $(this).toggle(defectName.indexOf(value) > -1)
            });
            recalculateTotalsModel();
            updateExportLinks();
        });
    });
    </script>

</body>
</html>