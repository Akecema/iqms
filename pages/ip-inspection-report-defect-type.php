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
                        <h2>Model Type Performance Report</h2>
                        <p>This section breaks down type of defects and where defects are occurring most frequently within the structural categories.</p>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                            <div class="row">                    
                                <div class="col-12">
                                    <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                                    
                                        <style>

                                            #inspectionDefectSummary thead tr th:last-child{
                                                text-align: center !important; 
                                            }

                                            #defect-type-table thead tr th:last-child{
                                                text-align: center !important;  
                                            }

                                            #defect-type-table th{
                                                border-top: 2px solid #337A36 !important;
                                                border: 2px solid #6c8f6cff !important;
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
                                            .dataTables_scrollHeadInner table {
                                                border-top: 1px solid #eeeeee !important;
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

                                            .form-select-sm{
                                                min-width:160px; 
                                                min-height:30px;
                                                font-weight:500;
                                            }

                                        </style>

                                        <div class="row">

                                            <?php
                                            // ============================================================
                                            // Centralized Filter Variables
                                            // ============================================================
                                            $f_fy       = isset($_GET['f_fy'])       && !empty($_GET['f_fy'])       ? mysqli_real_escape_string($db_con, $_GET['f_fy'])       : $financialyr;
                                            $f_month    = isset($_GET['f_month'])    && !empty($_GET['f_month'])    ? intval($_GET['f_month'])    : '';
                                            $f_quarter  = isset($_GET['f_quarter'])  && !empty($_GET['f_quarter'])  ? intval($_GET['f_quarter'])  : '';
                                            $f_type     = isset($_GET['f_type'])     && !empty($_GET['f_type'])     ? intval($_GET['f_type'])     : '';
                                            $f_daterange= isset($_GET['f_daterange'])&& !empty($_GET['f_daterange'])? mysqli_real_escape_string($db_con, $_GET['f_daterange']): '';
                                            $f_shift    = isset($_GET['f_shift'])    && !empty($_GET['f_shift'])    ? mysqli_real_escape_string($db_con, $_GET['f_shift'])    : '';

                                            // Fetch FY date bounds for the selected financial year
                                            $fy_bounds_sql = "SELECT date_start, date_end FROM financial_year WHERE financial_year = '$f_fy' LIMIT 1";
                                            $fy_bounds_res = mysqli_query($db_con, $fy_bounds_sql);
                                            $fy_date_start = '';
                                            $fy_date_end   = '';
                                            if ($fy_bounds_res && $fy_bounds_row = mysqli_fetch_assoc($fy_bounds_res)) {
                                                $fy_date_start = $fy_bounds_row['date_start'] ?? ''; // Y-m-d format
                                                $fy_date_end   = $fy_bounds_row['date_end']   ?? '';
                                            }



                                            // Build shared WHERE extra conditions
                                            $filter_sql = "";
                                            if (!empty($f_month))     $filter_sql .= " AND MONTH(S.inspect_date) = '$f_month'";
                                            if (!empty($f_shift))     $filter_sql .= " AND S.ir_shift = '$f_shift'";
                                            if (!empty($f_type))      $filter_sql .= " AND S.ir_type = '$f_type'";

                                            // Date range filter
                                            $f_start_date = '';
                                            $f_end_date   = '';
                                            if (!empty($f_daterange)) {
                                                $dates = explode(' - ', $f_daterange);
                                                if (count($dates) == 2) {
                                                    $f_start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
                                                    $f_end_date   = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
                                                    $filter_sql  .= " AND DATE(S.inspect_date) BETWEEN '$f_start_date' AND '$f_end_date'";
                                                }
                                            }

                                            // Quarter filter: resolve to month range from financial_quarter table
                                            $quarter_month_filter = '';
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



                                            // Fetch dropdown data for filter form
                                            $fy_sql_f  = "SELECT financial_year, financial_desc FROM financial_year ORDER BY financial_year DESC";
                                            $fy_res_f  = mysqli_query($db_con, $fy_sql_f);

                                            $qtr_sql   = "SELECT quarter_id, quarter_name FROM financial_quarter ORDER BY quarter_id ASC";
                                            $qtr_res   = mysqli_query($db_con, $qtr_sql);

                                            $type_sql  = "SELECT typeid, typemodel FROM model_type WHERE typestatus='Y' AND compcd='$session_comp' AND plant='$session_plant' ORDER BY typemodel ASC";
                                            $type_res  = mysqli_query($db_con, $type_sql);

                                            $shift_sql = "SELECT shiftshort, shiftdesc FROM shift_detail ORDER BY shiftshort ASC";
                                            $shift_res = mysqli_query($db_con, $shift_sql);

                                            $months_list = [
                                                1=>'January', 2=>'February', 3=>'March', 4=>'April',
                                                5=>'May', 6=>'June', 7=>'July', 8=>'August',
                                                9=>'September', 10=>'October', 11=>'November', 12=>'December'
                                            ];
                                            ?>

                                            <div class="col-xl-12 analysis-type-filter">
                                                <div class="card border-0 shadow-sm">
                                                    <div class="card-body py-3 px-4">
                                                        <form method="GET" id="filterFormMain">

                                                            <!-- Row 1: FY, Month, Quarter, Type -->
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
                                                                        <?php if($qtr_res && mysqli_num_rows($qtr_res) > 0):
                                                                            while($qtr_row = mysqli_fetch_assoc($qtr_res)): ?>
                                                                                <option value="<?= $qtr_row['quarter_id'] ?>" <?= ($f_quarter == $qtr_row['quarter_id']) ? 'selected' : '' ?>><?= htmlspecialchars($qtr_row['quarter_name']) ?></option>
                                                                            <?php endwhile;
                                                                        else: ?>
                                                                            <option disabled>No quarters defined</option>
                                                                        <?php endif; ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-auto g-4">
                                                                    <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Type</label>
                                                                    <select name="f_type" id="f_type" class="form-select form-select-sm cs-border-primary">
                                                                        <option value="">- All Types -</option>
                                                                        <?php if($type_res): while($t_row = mysqli_fetch_assoc($type_res)): ?>
                                                                            <option value="<?= $t_row['typeid'] ?>" <?= ($f_type == $t_row['typeid']) ? 'selected' : '' ?>><?= htmlspecialchars($t_row['typemodel']) ?></option>
                                                                        <?php endwhile; endif; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <!-- Row 2: Date Range, Shift + Apply / Reset -->
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
                                                                    <button type="submit" class="btn btn-sm btn-black" style="min-width:80px;">
                                                                        <!-- <i class="fa fa-filter me-1"></i> --> Apply
                                                                    </button>
                                                                    <a href="ip-inspection-report-defect-analysis.php" class="btn btn-sm btn-dark" style="min-width:80px;">
                                                                        <i class="fa fa-redo me-1"></i> Reset
                                                                    </a>
                                                                </div>
                                                            </div>

                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- by type -->
                                            <div class="col-xl-5 analysis-type-table">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom">
                                                        <div>
                                                            <h4 class="heading mb-0">Total Defects</h4>
                                                        </div>
                                                        <div class="dropdown custom-dropdown justify-content-end d-flex mb-3">
                                                            <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; background: transparent; border: none;">
                                                                <i class="fa fa-bars" style="font-size: 18px; color: #5a5c69;"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="export-inspection-report-type-total-defect.php" id="btnExportExcel"><i class="fa fa-file-excel text-green me-2"></i> Download Excel</a></li>
                                                                <li><a class="dropdown-item" href="export-inspection-report-type-total-defect-pdf.php" id="btnExportPdf" target="_blank"><i class="fa fa-file-pdf text-red me-2"></i> Download PDF</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                                
                                                    <div class="card-body">
                                                        
                                                        <?php
                                                        $targetFY = $f_fy;
                                                        ?>

                                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                                            <div class="d-flex align-items-center gap-3">                                                              
                                                            </div>  
                                                        </div>

                                                        <div class="table-responsive">
                                                            <table class="table table-bordered table-striped custom-table-summary" id="inspectionDefectSummary">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Type</th>
                                                                        <th class="text-center">Total Defects</th>
                                                                        <th class="text-center">Percentage (%)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php
                                                                    
                                                                    // Get defects grouped by model type
                                                                    $filter_sql_summary = str_replace('S.', 'S.', $filter_sql); // alias same as S
                                                                    $sql_summary = "SELECT 
                                                                                        MT.typemodel, 
                                                                                        COUNT(D.defect_id) as type_total
                                                                                    FROM model_type MT
                                                                                    LEFT JOIN inspection_records S ON S.ir_type = MT.typeid AND S.financial_yr = '$targetFY' AND S.ir_status = '5' $filter_sql_summary
                                                                                    LEFT JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id
                                                                                    WHERE MT.typestatus = 'Y' AND MT.compcd = '$session_comp' AND MT.plant = '$session_plant'
                                                                                    GROUP BY MT.typeid, MT.typemodel
                                                                                    ORDER BY type_total DESC";
                                                                    $res_summary = mysqli_query($db_con, $sql_summary);
                                                                    
                                                                    $summary_data = [];
                                                                    $grandTotal = 0;
                                                                    if (mysqli_num_rows($res_summary) > 0) {
                                                                        while ($row = mysqli_fetch_assoc($res_summary)) {
                                                                            $summary_data[] = $row;
                                                                            $grandTotal += (int)$row['type_total'];
                                                                        }
                                                                    }
                                                                    
                                                                    if (!empty($summary_data)) {
                                                                        foreach ($summary_data as $row) {
                                                                            $typeName = $row['typemodel'];
                                                                            $count = (int)$row['type_total'];
                                                                            $percentage = ($grandTotal > 0) ? round(($count / $grandTotal) * 100) : 0;
                                                                            
                                                                            echo "<tr>";
                                                                            echo "<td><strong>$typeName</strong></td>";
                                                                            echo "<td class='text-center'>" . number_format($count) . "</td>";
                                                                            echo "<td class='text-center'>$percentage%</td>";
                                                                            echo "</tr>";
                                                                        }
                                                                        
                                                                        // Total Row
                                                                        echo "<tr class='table-total'>";
                                                                        echo "<td>Total</td>";
                                                                        echo "<td class='text-center'>" . number_format($grandTotal) . "</td>";
                                                                        echo "<td class='text-center'>100%</td>";
                                                                        echo "</tr>";
                                                                    } else {
                                                                        echo "<tr><td colspan='3' class='text-center'>No data available for FY $targetFY</td></tr>";
                                                                    }
                                                                    ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>

                                            <!-- Graph -->
                                            <div class="col-xl-7 analysis-type-graph">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom">
                                                        <div>
                                                            <h4 class="heading mb-0">Total Defects Overview</h4>
                                                        </div>
                                                        <div class="dropdown custom-dropdown justify-content-end d-flex mb-3">
                                                            <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; background: transparent; border: none;">
                                                                <i class="fa fa-bars" style="font-size: 18px; color: #5a5c69;"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" href="#" id="btnExportDonutPng"> Download PNG</a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                                
                                                    <div class="card-body">
                                                        <?php
                                                        $overview_labels = [];
                                                        $overview_series = [];
                                                        $donut_labels = [];
                                                        $donut_series = [];
                                                        if (!empty($summary_data)) {
                                                            // Sort ascending for horizontal bar (largest at top)
                                                            $sorted_summary = array_reverse($summary_data);
                                                            foreach ($sorted_summary as $row) {
                                                                $overview_labels[] = $row['typemodel'];
                                                                $overview_series[] = (int)$row['type_total'];
                                                            }
                                                            foreach ($summary_data as $row) {
                                                                if ((int)$row['type_total'] > 0) {
                                                                    $donut_labels[] = $row['typemodel'];
                                                                    $donut_series[] = (int)$row['type_total'];
                                                                }
                                                            }
                                                        }
                                                        ?>
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div id="defectTypeOverviewBarChart" style="width: 100%;"></div>
                                                            </div>
                                                            <div class="col-md-5 d-flex justify-content-center align-items-center">
                                                                <div id="defectTypeDonutChart" style="width: 100%; min-height: 300px;"></div>
                                                            </div>
                                                        </div>
                                                        <script>
                                                            var overviewLabels = <?= json_encode($overview_labels) ?>;
                                                            var overviewSeries = <?= json_encode($overview_series) ?>;
                                                            var donutLabels = <?= json_encode($donut_labels) ?>;
                                                            var donutSeries = <?= json_encode($donut_series) ?>;
                                                        </script>
                                                    </div> 
                                                </div>
                                            </div>

                                            <?php
                                            $targetFY_m = $f_fy;
                                            
                                            // Breakdown by Type and Model
                                            $sql_defect_model = "SELECT 
                                                                    MT.typemodel AS type_name,
                                                                    MD.modcode AS model_name,
                                                                    COUNT(D.defect_id) AS total_qty
                                                                FROM model_type MT
                                                                JOIN model_details MD ON 1=1
                                                                LEFT JOIN inspection_records S ON S.ir_type = MT.typeid 
                                                                        AND S.ir_model = MD.modid 
                                                                        AND S.financial_yr = '$targetFY_m' 
                                                                        AND S.ir_result = 'NG' 
                                                                        AND S.ir_status = '5' $filter_sql
                                                                LEFT JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id
                                                                WHERE MT.typestatus = 'Y' AND MT.compcd = '$session_comp' AND MT.plant = '$session_plant'
                                                                AND MD.modstatus = 'Y' AND MD.compcd = '$session_comp' AND MD.plant = '$session_plant'
                                                                GROUP BY MT.typeid, MD.modid
                                                                HAVING total_qty > 0
                                                                ORDER BY MT.typemodel ASC, total_qty DESC";
                                            $res_defect_model = mysqli_query($db_con, $sql_defect_model);
                                            
                                            $data_rows = [];
                                            
                                            while ($row = mysqli_fetch_assoc($res_defect_model)) {
                                                $data_rows[] = $row;
                                            }
                                            ?>

                                        </div>  

                                        <?php
                                        // 1. Get Column Headers (Model Types)
                                        $sql_mt = "SELECT typeid, typemodel FROM model_type 
                                                WHERE typestatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant' 
                                                ORDER BY typemodel ASC";
                                        $res_mt = mysqli_query($db_con, $sql_mt);
                                        $model_types = [];
                                        while($row = mysqli_fetch_assoc($res_mt)) $model_types[] = $row;

                                        // 2. Get Row Headers (Defect Types/Categories)
                                        $sql_dt = "SELECT defectid, defectname FROM defect_type WHERE defectstatus = 'Y' ORDER BY defectname ASC";
                                        $res_dt = mysqli_query($db_con, $sql_dt);
                                        $defect_categories = [];
                                        while($row = mysqli_fetch_assoc($res_dt)) $defect_categories[] = $row;

                                        // 3. Get Defect Data
                                        $filter_sql_ir = str_replace('S.', 'IR.', $filter_sql);
                                        $sql_data = "SELECT 
                                                        ID.defect_type, 
                                                        IR.ir_type as model_type_id, 
                                                        COUNT(ID.defect_id) as qty
                                                    FROM inspection_records IR
                                                    JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
                                                    WHERE IR.financial_yr = '$targetFY' 
                                                    AND IR.ir_result = 'NG' AND IR.ir_status = '5' $filter_sql_ir
                                                    GROUP BY ID.defect_type, IR.ir_type";
                                        $res_data = mysqli_query($db_con, $sql_data);
                                        $matrix = [];
                                        while($row = mysqli_fetch_assoc($res_data)){
                                            $matrix[$row['defect_type']][$row['model_type_id']] = $row['qty'];
                                        }

                                        // Calculate Grand Total for percentage
                                        $grand_total = 0;
                                        foreach($matrix as $def_id => $m_data) {
                                            foreach($m_data as $qty) $grand_total += (int)$qty;
                                        }

                                        // 4. Calculate Insights for Defect Type Page
                                        $sql_insp_all = "SELECT COUNT(ir_id) as total_insp FROM inspection_records S WHERE ir_status = '5' AND financial_yr = '$f_fy' $filter_sql";
                                        $res_insp_all = mysqli_query($db_con, $sql_insp_all);
                                        $total_insp_all = mysqli_fetch_assoc($res_insp_all)['total_insp'] ?? 0;

                                        // Peak Model Type (from summary_data calculated previously in code)
                                        $peak_defect_type = "N/A";
                                        $peak_defect_qty = 0;
                                        if (!empty($summary_data)) {
                                            $peak_defect_type = $summary_data[0]['typemodel'];
                                            $peak_defect_qty = $summary_data[0]['type_total'];
                                        }

                                        // Find Top Defect Category (e.g. Crack, Dent)
                                        $peak_cat_name = "N/A";
                                        $peak_cat_qty = 0;
                                        foreach($defect_categories as $dt) {
                                            $row_sum = 0;
                                            foreach($model_types as $mt) {
                                                $row_sum += (int)($matrix[$dt['defectid']][$mt['typeid']] ?? 0);
                                            }
                                            if($row_sum > $peak_cat_qty) {
                                                $peak_cat_qty = $row_sum;
                                                $peak_cat_name = $dt['defectname'];
                                            }
                                        }

                                        $overall_rate = ($total_insp_all > 0) ? ($grand_total / $total_insp_all) * 100 : 0;
                                        ?>

                                        
                                        <div class="row">
                                            <!-- by defect -->
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
                                                                    <li><a class="dropdown-item" id="exportExcelBtnDefectType" href="export-inspection-report-defect-type.php?fy=<?= $targetFY ?>"><i class="fa fa-file-excel text-green me-2"></i> Download Excel</a></li>
                                                                    <li><a class="dropdown-item" id="exportPdfBtnDefectType" href="export-inspection-report-defect-type-pdf.php?fy=<?= $targetFY ?>" target="_blank"><i class="fa fa-file-pdf text-red me-2"></i> Download PDF</a></li>
                                                                </ul>
                                                            </div>                                                            
                                                        </div>
                                                    </div>
                                                            
                                                    <div class="card-body defect-type">

                                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                                            <div class="d-flex align-items-center gap-3">  
                                                                <div class="input-group search-area d-none d-md-inline-flex" style="width: 250px; margin-left: 2px;">
                                                                    <input type="text" class="form-control" id="defectSearchInput" placeholder="Search defect name...">
                                                                    <span class="input-group-text">
                                                                        <a href="javascript:void(0)">
                                                                            <i class="flaticon-381-search-2"></i>
                                                                        </a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                            


                                                        </div>
                                                        

                                                        <div class="table-responsive">
                                                            <?php
                                                            // --- Prepare Chart Data for Defect Type Analysis ---
                                                            $chart_dt_categories = [];
                                                            $chart_dt_series = [];
                                                            $temp_dt_ids = [];

                                                            // Identify defect types with data
                                                            foreach($defect_categories as $dt) {
                                                                $row_sum = 0;
                                                                foreach($model_types as $mt) {
                                                                    $row_sum += (int)($matrix[$dt['defectid']][$mt['typeid']] ?? 0);
                                                                }
                                                                if ($row_sum > 0) {
                                                                    $chart_dt_categories[] = $dt['defectname'];
                                                                    $temp_dt_ids[] = $dt['defectid'];
                                                                }
                                                            }

                                                            // Build series per model type
                                                            foreach($model_types as $mt) {
                                                                $mt_data = [];
                                                                foreach($temp_dt_ids as $def_id) {
                                                                    $mt_data[] = (int)($matrix[$def_id][$mt['typeid']] ?? 0);
                                                                }
                                                                $chart_dt_series[] = [
                                                                    'name' => $mt['typemodel'],
                                                                    'data' => $mt_data
                                                                ];
                                                            }
                                                            ?>

                                                            <table class="table table-bordered table-striped" id="defect-type-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Defect Type</th>
                                                                        <?php foreach($model_types as $mt): ?>
                                                                            <th class="text-center"><?= $mt['typemodel']; ?></th>
                                                                        <?php endforeach; ?>
                                                                        <th class="text-center">Total</th>
                                                                        <th class="text-center">Percentage (%)</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php 
                                                                    $col_totals = array_fill_keys(array_column($model_types, 'typeid'), 0);
                                                                    
                                                                    foreach($defect_categories as $dt): 
                                                                        $row_id = $dt['defectid'];
                                                                        $row_sum = 0;
                                                                    ?>
                                                                        <tr>
                                                                            <td><strong><?= $dt['defectname']; ?></strong></td>
                                                                            <?php foreach($model_types as $mt): 
                                                                                $m_id = $mt['typeid'];
                                                                                $qty = $matrix[$row_id][$m_id] ?? 0;
                                                                                $row_sum += $qty;
                                                                                $col_totals[$m_id] += $qty;
                                                                            ?>
                                                                            <td class="text-center"><?= $qty > 0 ? number_format($qty) : '-'; ?></td>
                                                                            <?php endforeach; ?>
                                                                            <td class="text-center"><strong><?= number_format($row_sum); ?></strong></td>
                                                                            <td class="text-center"><?= $grand_total > 0 ? round(($row_sum / $grand_total) * 100) : 0; ?>%</td>
                                                                        </tr>
                                                                    <?php endforeach; ?>
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr class="table-total">
                                                                        <td>Total</td>
                                                                        <?php foreach($model_types as $mt): ?>
                                                                            <td class="text-center"><?= number_format($col_totals[$mt['typeid']]); ?></td>
                                                                        <?php endforeach; ?>
                                                                        <td class="text-center"><?= number_format($grand_total); ?></td>
                                                                        <td class="text-center">100%</td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                        </div>
                                                    </div> 
                                                </div>
                                                </div>
                                            </div> 

                                            <div class="col-xl-12">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom d-flex justify-content-between align-items-center flex-wrap">
                                                        <div>
                                                            <h4 class="heading mb-0">Defect Type Analysis Graph</h4>
                                                            <span class="d-block mt-1" style="font-size: 11px; font-weight:400; color: #888;">This chart visualizes the distribution of defect types across structural categories (Model Types).</span>
                                                        </div>
                                                    </div>
                                                            
                                                    <div class="card-body defect-type">

                                                        <!-- Defect Type Analysis Graph -->
                                                        <div id="defectTypeAnalysisChart"></div>

                                                    </div> 
                                                </div>
                                            </div> 
                                        </div>

                                        <div class="row mb-4">
                                            <div class="col-xl-12">
                                                <div class="card border-0 shadow-sm" style="box-shadow: 0 0.125rem 0.25rem #9c9898ff !important;">
                                                    <div class="card-header border-0 border-bottom">
                                                        <h4 class="heading mb-0"><i class="fa fa-lightbulb me-2" aria-hidden="true"></i>Insights</h4>
                                                    </div>
                                                    <div class="card-body py-3 px-4">
                                                        <ul style="list-style-type: none; padding: 0; margin-top: 10px;">
                                                            <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                                <div style="min-width: 6px; height: 6px; background: #11470F; border-radius: 50%; margin-top: 6px;"></div>
                                                                <div>Total inspection volume reached <strong><?= number_format($total_insp_all) ?></strong> units with <strong><?= number_format($grandTotal) ?></strong> total defects detected.</div>
                                                            </li>
                                                            <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                                <div style="min-width: 6px; height: 6px; background: #11470F; border-radius: 50%; margin-top: 6px;"></div>
                                                                <div>The overall defect rate for this period is <strong><?= number_format($overall_rate, 2) ?>%</strong>.</div>
                                                            </li>
                                                            <?php if($peak_defect_qty > 0): ?>
                                                                <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                                    <div style="min-width: 6px; height: 6px; background: #af0808; border-radius: 50%; margin-top: 6px;"></div>
                                                                    <div>Structural Analysis: <strong><?= $peak_defect_type ?></strong> is the model type with the highest frequency (<?= number_format($peak_defect_qty) ?> occurrences).</div>
                                                                </li>
                                                            <?php endif; ?>
                                                            <?php if($peak_cat_qty > 0): ?>
                                                                <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                                    <div style="min-width: 6px; height: 6px; background: #af0808; border-radius: 50%; margin-top: 6px;"></div>
                                                                    <div>Significant Alert: <strong><?= $peak_cat_name ?></strong> is the most common defect category found (<?= number_format($peak_cat_qty) ?> cases).</div>
                                                                </li>
                                                            <?php endif; ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            if(typeof ApexCharts !== 'undefined' && document.querySelector("#defectTypeAnalysisChart")){
                                                var optionsDT = {
                                                    series: <?= json_encode($chart_dt_series) ?>,
                                                    colors: ['#11470F', '#739C38', '#D4F357', '#EAF739', '#FFFDD0', '#364536', '#879e83', '#5a695b'],
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
                                                        categories: <?= json_encode($chart_dt_categories) ?>,
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

                                                var chartDT = new ApexCharts(document.querySelector("#defectTypeAnalysisChart"), optionsDT);
                                                chartDT.render();
                                            }
                                        });
                                        </script>

                                        <!-- <div class="row">
                                            <div class="col-xl-12">
                                                <div class="card">
                                                    <div class="card-header border-0 border-bottom">
                                                        <h4 class="heading mb-0">Defect Distribution: Model & Type Breakdown</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="defectStackedBarChart"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>               
			</div>
        </div>



        <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Vertical Bar Chart: Total Defects by Type (X=type, Y=qty)
            if (document.querySelector("#defectTypeOverviewBarChart")) {
                var optionsOverviewBar = {
                    series: [{
                        name: 'Total Defects',
                        data: overviewSeries
                    }],
                    chart: {
                        type: 'bar',
                        height: 320,
                        toolbar: { show: false }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            borderRadius: 4,
                            columnWidth: '45%',
                            dataLabels: { position: 'top' }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        offsetY: -20,
                        style: {
                            fontSize: '12px',
                            colors: ['#304758']
                        },
                        formatter: function(val) { return val > 0 ? val : ''; }
                    },
                    xaxis: {
                        categories: overviewLabels,
                        title: { text: 'Type', style: { fontWeight: 500 } }
                    },
                    yaxis: {
                        title: { text: 'Defect Quantity', style: { fontWeight: 500 } }
                    },
                    grid: {
                        xaxis: { lines: { show: false } },
                        yaxis: { lines: { show: true } }
                    },
                    tooltip: {
                        y: { formatter: function(val) { return val + ' defects'; } }
                    },
                    colors: ['#11470F'],
                    legend: { show: false }
                };
                var overviewBarChart = new ApexCharts(document.querySelector("#defectTypeOverviewBarChart"), optionsOverviewBar);
                overviewBarChart.render();
            }

            // Donut Chart: Total Defects by Type
            if (document.querySelector("#defectTypeDonutChart")) {
                var optionsDonut = {
                    series: donutSeries,
                    labels: donutLabels,
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    plotOptions: {
                        pie: { donut: { size: '65%' } }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val) { return Math.round(val) + "%"; }
                    },
                    legend: { position: 'bottom' },
                    colors: ['#11470F', '#739C38', '#D4F357', '#EAF739', '#FFFDD0', '#364536', '#879e83', '#5a695b'],
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: { width: 200 },
                            legend: { position: 'bottom' }
                        }
                    }]
                };
                var chartDonut = new ApexCharts(document.querySelector("#defectTypeDonutChart"), optionsDonut);
                chartDonut.render();

                document.getElementById('btnExportDonutPng').addEventListener('click', function(e) {
                    e.preventDefault();
                    // Export both charts as a combined PNG
                    Promise.all([
                        overviewBarChart.dataURI(),
                        chartDonut.dataURI()
                    ]).then(function(results) {
                        var imgBar = new Image();
                        var imgDonut = new Image();
                        var barURI = results[0].imgURI;
                        var donutURI = results[1].imgURI;

                        imgBar.onload = function() {
                            imgDonut.onload = function() {
                                var padding = 20;
                                var totalWidth = imgBar.width + imgDonut.width + padding * 3;
                                var totalHeight = Math.max(imgBar.height, imgDonut.height) + padding * 2;

                                var canvas = document.createElement('canvas');
                                canvas.width = totalWidth;
                                canvas.height = totalHeight;
                                var ctx = canvas.getContext('2d');

                                // White background
                                ctx.fillStyle = '#ffffff';
                                ctx.fillRect(0, 0, totalWidth, totalHeight);

                                // Draw bar chart on left
                                ctx.drawImage(imgBar, padding, padding);
                                // Draw donut chart on right
                                ctx.drawImage(imgDonut, imgBar.width + padding * 2, padding);

                                var link = document.createElement('a');
                                link.href = canvas.toDataURL('image/png');
                                link.download = 'Total_Defects_Overview.png';
                                document.body.appendChild(link);
                                link.click();
                                document.body.removeChild(link);
                            };
                            imgDonut.src = donutURI;
                        };
                        imgBar.src = barURI;
                    });
                });
            }

        });
        </script>
		
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
    <script src="js/highlight.min.js"></script>
    
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>

    <script>

    $(function() {
        //Initialize Select2 Elements
        $('.result-select').select2()
    });

    </script>

    <script>
    $('.filter-select').select2({
        minimumResultsForSearch: Infinity, // Hide search box if not needed
        width: '100%'
    });
    </script>

    <script>
    $('#daterange_inspect')
        .daterangepicker({
            autoUpdateInput: false,
            maxDate: moment(),
            startDate: moment().subtract(29, 'days'),
            endDate: moment(),
            locale:{
                format:'DD/MM/YYYY',
                cancelLabel:'Clear'
            }
        })
        .on('apply.daterangepicker', function(ev, picker){
            $(this).val(
                picker.startDate.format('DD/MM/YYYY') +
                ' - ' +
                picker.endDate.format('DD/MM/YYYY')
            );
        })
        .on('cancel.daterangepicker', function(ev, picker){
            $(this).val('');
    });

    $('#daterange_inspect').val('');

    // FY date bounds from PHP
    var fyDateStart = "<?= $fy_date_start ? date('d/m/Y', strtotime($fy_date_start)) : '' ?>";
    var fyDateEnd   = "<?= $fy_date_end   ? date('d/m/Y', strtotime($fy_date_end))   : '' ?>";

    // Build daterangepicker options based on FY bounds
    var drpOptions = {
        autoUpdateInput: false,
        locale: {
            format: 'DD/MM/YYYY',
            cancelLabel: 'Clear'
        }
    };
    if (fyDateStart) drpOptions.minDate = moment(fyDateStart, 'DD/MM/YYYY');
    if (fyDateEnd)   drpOptions.maxDate = moment(fyDateEnd,   'DD/MM/YYYY');

    // Initialize daterangepicker for the analysis filter form
    $('#f_daterange')
        .daterangepicker(drpOptions)
        .on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            $('#filterFormMain').submit();
        })
        .on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#filterFormMain').submit();
        });

    // Restore existing value if filter was previously applied
    var existingDateRange = "<?= addslashes($f_daterange) ?>";
    if (existingDateRange) {
        var parts = existingDateRange.split(' - ');
        if (parts.length === 2) {
            var rStart = moment(parts[0], 'DD/MM/YYYY');
            var rEnd   = moment(parts[1], 'DD/MM/YYYY');
            // Clamp to FY bounds if available
            if (fyDateStart && rStart.isBefore(moment(fyDateStart, 'DD/MM/YYYY'))) rStart = moment(fyDateStart, 'DD/MM/YYYY');
            if (fyDateEnd   && rEnd.isAfter(moment(fyDateEnd,   'DD/MM/YYYY')))   rEnd   = moment(fyDateEnd,   'DD/MM/YYYY');
            $('#f_daterange').data('daterangepicker').setStartDate(rStart);
            $('#f_daterange').data('daterangepicker').setEndDate(rEnd);
        }
    }

    </script>

    <script>

    function updateExportLinks() {
        var params = $.param({
            f_fy: $('#f_fy').val(),
            f_month: $('#f_month').val(),
            f_quarter: $('#f_quarter').val(),
            f_type: $('#f_type').val(),
            f_daterange: $('#f_daterange').val(),
            f_shift: $('#f_shift').val()
        });

        // Summary Excel & PDF
        $('#btnExportExcel').attr('href', 'export-inspection-report-type-total-defect.php?' + params);
        $('#btnExportPdf').attr('href', 'export-inspection-report-type-total-defect-pdf.php?' + params);
        
        // Defect Type Matrix Excel & PDF
        var defectSearch = $('#defectSearchInput').val() || '';
        var defectParams = params + '&search=' + encodeURIComponent(defectSearch);
        $('#exportExcelBtnDefectType').attr('href', 'export-inspection-report-defect-type.php?' + defectParams);
        $('#exportPdfBtnDefectType').attr('href', 'export-inspection-report-defect-type-pdf.php?' + defectParams);
    }

    $('#btnFilterSearch').on('click', function() {
        table.ajax.reload();
        updateExportLinks();
    });

    $('#btnResetFilter').on('click', function() {
        $('.cs_model, .cs_type, .cs_material, .cs_shift, #filterResult').val('').trigger('change');
        $('#daterange_inspect').val('');
        $('#searchInput').val('');
        table.ajax.reload();
        updateExportLinks();
    });

    $(document).ready(function() {
        updateExportLinks();
    });

    $('#searchInput').on('keyup', function() {
        table.ajax.reload();
    });

    // Initialize DataTable for Defect Type Table
    var defectTypeDataTable = $('#defect-type-table').DataTable({
        "paging": false,
        "scrollY": "400px",
        "scrollCollapse": true,
        "lengthChange": false,
        "searching": true,
        "info": true,
        "ordering": false,
        "dom": "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "language": {
            "emptyTable": "No data available"
        }
    });

    // Function to recalculate table totals based on visible rows
    function recalculateTotalsDefectType() {
        let colTotals = [];
        let grandTotal = 0;
        let sumPercent = 0;
        let numCols = $("#defect-type-table thead tr th").length;
        
        for (let i = 1; i < numCols - 2; i++) {
            colTotals[i] = 0;
        }

        $(defectTypeDataTable.rows({ search: 'applied' }).nodes()).each(function() {
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

        let footerRow = $("#defect-type-table tfoot tr");
        for (let i = 1; i < numCols - 2; i++) {
            footerRow.find('td').eq(i).text(colTotals[i] > 0 ? colTotals[i].toLocaleString() : '-');
        }
        
        footerRow.find('td').eq(numCols - 2).text(grandTotal.toLocaleString());
        footerRow.find('td').eq(numCols - 1).text(sumPercent + '%');
    }

    // Real-time table search/filter
    $("#defectSearchInput").on("keyup", function() {
        var value = $(this).val();
        defectTypeDataTable.search(value).draw();
        
        recalculateTotalsDefectType();

        var fy = "<?= $targetFY ?>";
        var searchParam = encodeURIComponent(value);
        $("#exportExcelBtnDefectType").attr("href", "export-inspection-report-defect-type.php?fy=" + fy + "&search=" + searchParam);
        $("#exportPdfBtnDefectType").attr("href", "export-inspection-report-defect-type-pdf.php?fy=" + fy + "&search=" + searchParam);
    });

    </script>

    <script>

    // Initialize DataTable for inspection records
    var table = $('#inspectionGroupsList').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: "fetch-inspection-report-list.php",
            type: "POST",
            data: function(d) {
                d.action = 'fetch_records_list_all';
                d.fd_model = $('.cs_model').val();
                d.fd_type = $('.cs_type').val();
                d.fd_material = $('.cs_material').val();                
                d.fd_daterange = $('#daterange_inspect').val();
                d.fd_shift = $('.cs_shift').val();
                d.fd_result = $('#filterResult').val();
            }
        },
        "dom": "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
               "<'row'<'col-sm-12'tr>>" +
               "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        "columns": [
            { "data": 0 }, // Doc No
            { "data": 1 }, // Material
            { "data": 2 }, // Model
            { "data": 3 }, // Inspection Date
            { "data": 4 }, // Shift
            { "data": 5 }, // Pallet Sequence
            { "data": 6 }, // Result
            { "data": 7 } // View
        ],
        "order": [[3, 'desc']], // Default sort by inspection date descending, adjusted index from 4 to 3
        "pageLength": 10,
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "language": {
            "emptyTable": "No inspection records found",
            "processing": "Loading data...",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "infoEmpty": "Showing 0 to 0 of 0 entries",
            "infoFiltered": "(filtered from _MAX_ total entries)",
            "paginate": {
                    "previous": '<i class="fa fa-angle-left"></i>',
                    "next": '<i class="fa fa-angle-right"></i>'
            },
        },
        "columnDefs": [
            {
                "targets": 'nosort',
                "orderable": false
            }
        ],
        "drawCallback": function(settings) {
            // Update OK/NG counts from server response
            var json = settings.json;
            if (json) {
                // Ensure we default to 0 if undefined
                var okCount = json.total_ok !== undefined ? json.total_ok : 0;
                var ngCount = json.total_ng !== undefined ? json.total_ng : 0;

                $('#totalOkPending span').text(okCount);
                $('#totalNgPending span').text(ngCount);
            }
            
            // Reinitialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        }
    });

    $(document).on('click', '.viewDetails', function() {
        let irid = $(this).data('irid');
        window.location.href = 'ip-inspection-report-view.php?erid=' + irid;
    });

    </script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));
    });
    </script>

    <script>

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));

    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    </script>

    <script>

    document.getElementById('btnBack').addEventListener('click', function () {
        history.back();
    });

    </script>

</body>
</html>