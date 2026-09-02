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
                        <h2>Defect Analysis Report</h2>
                        <p>This section breaks down total inspections and defects within the structural categories.</p>
                    </div>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                            <div class="row">  
                                
                                
                                <div class="col-12 mb-4 mt-4">
                                    <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                                    
                                        <style>

                                            #montlhy-type-table thead tr th:last-child{
                                                text-align: center !important; 
                                            }

                                            #montlhy-model-table thead tr th:last-child{
                                                text-align: center !important; 
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
                                            .form-select-sm{
                                                min-width:160px; 
                                                min-height:30px;
                                                font-weight:500;
                                            }

                                            /* Toggle Filter Styles */
                                            .toggle-group-container {
                                                display: inline-flex;
                                                background: #F2F5F2;
                                                padding: 4px;
                                                border-radius: 100px;
                                                position: relative;
                                                box-shadow: 0 4px 15px rgba(147, 149, 146, 0.2);
                                            }

                                            .toggle-group-container a {
                                                padding: 6px 26px;
                                                border-radius: 100px;
                                                color:#444;
                                                text-decoration: none !important;
                                                font-weight: 500;
                                                font-size: 14px;
                                                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                                                z-index: 1;
                                                min-width: 90px;
                                                text-align: center;
                                            }

                                            .toggle-group-container a.active {
                                                background: white;
                                                font-weight: 700;
                                                box-shadow: 0 2px 4px rgba(0,0,0,0.15);
                                                color:#000;
                                            }

                                            .toggle-group-container a:not(.active):hover {
                                                color: #000;
                                                background: #e6e6e6;
                                            }
                                            
                                            
                                        </style>

                                        <div class="row">
                                            
                                        <?php
                                        // ============================================================
                                        // Centralized Filter Logic
                                        // ============================================================
                                        $f_fy       = isset($_GET['f_fy'])       && !empty($_GET['f_fy'])       ? mysqli_real_escape_string($db_con, $_GET['f_fy'])       : $financialyr;
                                        $f_quarter  = isset($_GET['f_quarter'])  && !empty($_GET['f_quarter'])  ? intval($_GET['f_quarter'])  : '';
                                        $f_type     = isset($_GET['f_type'])     && !empty($_GET['f_type'])     ? intval($_GET['f_type'])     : '';
                                        $f_model    = isset($_GET['f_model'])    && !empty($_GET['f_model'])    ? intval($_GET['f_model'])    : '';
                                        $f_shift    = isset($_GET['f_shift'])    && !empty($_GET['f_shift'])    ? mysqli_real_escape_string($db_con, $_GET['f_shift'])    : '';
                                        $f_range    = isset($_GET['f_range'])    && !empty($_GET['f_range'])    ? mysqli_real_escape_string($db_con, $_GET['f_range'])    : 'all';

                                        // Build shared WHERE $filter_sql
                                        $filter_sql = "";
                                        
                                        // Time Range filter
                                        if ($f_range === 'day') {
                                            $filter_sql .= " AND DATE(IR.inspect_date) = CURDATE()";
                                        } elseif ($f_range === 'week') {
                                            $filter_sql .= " AND YEARWEEK(IR.inspect_date, 1) = YEARWEEK(CURDATE(), 1)";
                                        } elseif ($f_range === 'month') {
                                            $filter_sql .= " AND MONTH(IR.inspect_date) = MONTH(CURDATE()) AND YEAR(IR.inspect_date) = YEAR(CURDATE())";
                                        } elseif ($f_range === 'year') {
                                            $filter_sql .= " AND YEAR(IR.inspect_date) = YEAR(CURDATE())";
                                        }

                                        // Handle Quarter Filter (Month Range)
                                        $q_months_filter = [];
                                        if (!empty($f_quarter)) {
                                            $q_res = mysqli_query($db_con, "SELECT month_start, month_end FROM financial_quarter WHERE quarter_id = '$f_quarter'");
                                            if ($q_row = mysqli_fetch_assoc($q_res)) {
                                                $m_start = intval($q_row['month_start']);
                                                $m_end   = intval($q_row['month_end']);
                                                
                                                if ($m_start <= $m_end) {
                                                    $filter_sql .= " AND MONTH(IR.inspect_date) BETWEEN '$m_start' AND '$m_end'";
                                                    for ($m = $m_start; $m <= $m_end; $m++) $q_months_filter[] = $m;
                                                } else {
                                                    $filter_sql .= " AND (MONTH(IR.inspect_date) >= '$m_start' OR MONTH(IR.inspect_date) <= '$m_end')";
                                                    for ($m = $m_start; $m <= 12; $m++) $q_months_filter[] = $m;
                                                    for ($m = 1; $m <= $m_end; $m++)    $q_months_filter[] = $m;
                                                }
                                            }
                                        }

                                        if (!empty($f_shift))     $filter_sql .= " AND IR.ir_shift = '$f_shift'";
                                        if (!empty($f_type))      $filter_sql .= " AND IR.ir_type = '$f_type'";
                                        if (!empty($f_model))     $filter_sql .= " AND IR.ir_model = '$f_model'";

                                        $targetFY = $f_fy;

                                        // Fetch dropdown data
                                        $fy_res_f  = mysqli_query($db_con, "SELECT financial_year, financial_desc FROM financial_year ORDER BY financial_year DESC");
                                        $qtr_res   = mysqli_query($db_con, "SELECT quarter_id, quarter_name FROM financial_quarter ORDER BY quarter_id ASC");
                                        $type_res  = mysqli_query($db_con, "SELECT typeid, typemodel FROM model_type WHERE typestatus='Y' AND compcd='$session_comp' AND plant='$session_plant' ORDER BY typemodel ASC");
                                        $mod_res   = mysqli_query($db_con, "SELECT modid, modcode FROM model_details WHERE modstatus='Y' AND compcd='$session_comp' AND plant='$session_plant' ORDER BY modcode ASC");
                                        $shift_res = mysqli_query($db_con, "SELECT shiftshort, shiftdesc FROM shift_detail ORDER BY shiftshort ASC");
                                        ?>

                                        <div class="col-xl-12 button-group-view mb-4 mt-2">
                                            <div class="d-flex justify-content-center">
                                                <div class="toggle-group-container">
                                                    <a href="?f_range=day" class="<?= $f_range == 'day' ? 'active' : '' ?>">Day</a>
                                                    <a href="?f_range=week" class="<?= $f_range == 'week' ? 'active' : '' ?>">Week</a>
                                                    <a href="?f_range=month" class="<?= $f_range == 'month' ? 'active' : '' ?>">Month</a>
                                                    <a href="?f_range=year" class="<?= $f_range == 'year' ? 'active' : '' ?>">Year</a>
                                                    <a href="?f_range=all" class="<?= $f_range == 'all' ? 'active' : '' ?>">All</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <!-- Data Preparation for Chart/Matrix -->
                            <?php
                            // 1. Get Model Types (Categories)
                            $sql_mt = "SELECT typeid, typemodel FROM model_type 
                                    WHERE typestatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant' 
                                    ORDER BY typemodel ASC";
                            $res_mt = mysqli_query($db_con, $sql_mt);
                            $cat_types = [];
                            while($row = mysqli_fetch_assoc($res_mt)) $cat_types[] = $row;
                            $cat_names = array_column($cat_types, 'typemodel');

                            // 2. Get Model Details (Series)
                            $sql_md = "SELECT modid, modcode FROM model_details 
                                    WHERE modstatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant' 
                                    ORDER BY modcode ASC";
                            $res_md = mysqli_query($db_con, $sql_md);
                            $series_models = [];
                            while($row = mysqli_fetch_assoc($res_md)) $series_models[] = $row;

                            // 3. Fetch Matrix Data
                            $sql_defect_matrix = "SELECT 
                                                    IR.ir_type, 
                                                    IR.ir_model, 
                                                    COUNT(D.defect_id) as qty
                                                FROM inspection_records IR
                                                JOIN inspection_defect D ON D.rcd_ir_id = IR.ir_id
                                                WHERE IR.financial_yr = '$f_fy' AND IR.ir_status = '5' $filter_sql
                                                GROUP BY IR.ir_type, IR.ir_model";
                            $res_matrix = mysqli_query($db_con, $sql_defect_matrix);
                            $matrix = [];
                            $peak_model_id = 0;
                            $peak_model_qty = 0;
                            $model_defect_totals = [];

                            while($row = mysqli_fetch_assoc($res_matrix)){
                                $matrix[$row['ir_type']][$row['ir_model']] = intval($row['qty']);
                                
                                $model_defect_totals[$row['ir_model']] = ($model_defect_totals[$row['ir_model']] ?? 0) + intval($row['qty']);
                                if ($model_defect_totals[$row['ir_model']] > $peak_model_qty) {
                                    $peak_model_qty = $model_defect_totals[$row['ir_model']];
                                    $peak_model_id = $row['ir_model'];
                                }
                            }

                            // Get Peak Model Name
                            $peak_model_name = "N/A";
                            if ($peak_model_id > 0) {
                                $pm_res = mysqli_query($db_con, "SELECT modcode FROM model_details WHERE modid = '$peak_model_id'");
                                if($pm_row = mysqli_fetch_assoc($pm_res)) $peak_model_name = $pm_row['modcode'];
                            }

                            // 4. Get Peak Defect Category (e.g. Crack, Dent)
                            $sql_peak_cat = "SELECT DT.defectname, COUNT(D.defect_id) as qty
                                            FROM inspection_records IR
                                            JOIN inspection_defect D ON D.rcd_ir_id = IR.ir_id
                                            JOIN defect_type DT ON DT.defectid = D.defect_type
                                            WHERE IR.financial_yr = '$f_fy' AND IR.ir_status = '5' $filter_sql
                                            GROUP BY D.defect_type
                                            ORDER BY qty DESC LIMIT 1";
                            $res_peak_cat = mysqli_query($db_con, $sql_peak_cat);
                            $peak_cat_name = "N/A";
                            $peak_cat_qty = 0;
                            if ($pc_row = mysqli_fetch_assoc($res_peak_cat)) {
                                $peak_cat_name = $pc_row['defectname'];
                                $peak_cat_qty = $pc_row['qty'];
                            }

                            // 5. Total Metrics
                            $sql_total_inspect = "SELECT COUNT(IR.ir_id) as total FROM inspection_records IR WHERE financial_yr = '$f_fy' AND ir_status = '5' $filter_sql";
                            $res_total_inspect = mysqli_query($db_con, $sql_total_inspect);
                            $total_inspection_vol = 0;
                            if ($res_total_inspect) {
                                $row_insp = mysqli_fetch_assoc($res_total_inspect);
                                $total_inspection_vol = $row_insp['total'] ?? 0;
                            }

                            $sql_total_defects = "SELECT COUNT(D.defect_id) as total FROM inspection_records IR JOIN inspection_defect D ON D.rcd_ir_id = IR.ir_id WHERE IR.financial_yr = '$f_fy' AND IR.ir_status = '5' $filter_sql";
                            $res_total_defects = mysqli_query($db_con, $sql_total_defects);
                            $total_defects_count = 0;
                            if ($res_total_defects) {
                                $row_defect = mysqli_fetch_assoc($res_total_defects);
                                $total_defects_count = $row_defect['total'] ?? 0;
                            }

                            $overall_defect_rate = ($total_inspection_vol > 0) ? ($total_defects_count / $total_inspection_vol) * 100 : 0;

                            // 6. Build ApexCharts Series
                            $chart_series = [];
                            foreach($series_models as $sm) {
                                $s_data = [];
                                $has_any_data = false;
                                foreach($cat_types as $ct) {
                                    $v = $matrix[$ct['typeid']][$sm['modid']] ?? 0;
                                    $s_data[] = $v;
                                    if ($v > 0) $has_any_data = true;
                                }
                                
                                if ($has_any_data) {
                                    $chart_series[] = [
                                        'name' => $sm['modcode'],
                                        'data' => $s_data
                                    ];
                                }
                            }
                            ?>

                            <div class="col-xl-8">
                                <div class="card overflow-hidden">
                                    <div class="card-header border-0 border-bottom">
                                            <h4 class="heading mb-0"><i class="fa fa-lightbulb me-2" aria-hidden="true"></i> Insights</h4>
                                    </div>
                                    <div class="card-body py-3 px-4">
                                        <ul style="list-style-type: none; padding: 0; margin-top: 10px;">
                                            <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                <div style="min-width: 6px; height: 6px; background: #11470F; border-radius: 50%; margin-top: 6px;"></div>
                                                <div>Total inspection volume reached <strong><?= number_format($total_inspection_vol) ?></strong> units with <strong><?= number_format($total_defects_count) ?></strong> total defects detected.</div>
                                            </li>
                                            <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                <div style="min-width: 6px; height: 6px; background: #11470F; border-radius: 50%; margin-top: 6px;"></div>
                                                <div>The overall defect rate for this period is <strong><?= number_format($overall_defect_rate, 2) ?>%</strong>.</div>
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
                            <div class="col-xl-4">
                                <div class="card bg-primary">
                                    <div class="card-header border-0">
                                        <h4 class="heading mb-0 text-white">Overview Of Inspection</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div class="sales-bx">
                                                <img src="images/analytics/ip.png" alt="" >
                                                <h4><?= number_format($total_inspection_vol) ?></h4>
                                                <span>Total Inspections</span>
                                            </div>
                                            <div class="sales-bx">
                                                <img src="images/analytics/service-research.png" alt="" >
                                                <h4><?= number_format($total_defects_count) ?></h4>
                                                <span>Total Defects</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-header border-0 pb-0">
                                        <h4 class="heading mb-0">Total Defects by Type & Model</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="stackedDefectChart" style="min-height: 400px;"></div>
                                    </div>
                                </div>
                            </div>
                        
                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var options = {
                                    series: <?= json_encode($chart_series) ?>,
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
                                            borderRadius: 10,
                                            columnWidth: '45%',
                                        },
                                    },
                                    xaxis: {
                                        categories: <?= json_encode($cat_names) ?>,
                                        labels: {
                                            style: {
                                                fontSize: '12px',
                                                fontWeight: 500
                                            }
                                        }
                                    },
                                    colors: ['#11470F', '#739C38', '#D4F357', '#EAF739', '#e5ec83ff', '#364536', '#879e83', '#5a695b'],
                                    legend: {
                                        position: 'right',
                                        offsetY: 40
                                    },
                                    fill: {
                                        opacity: 1
                                    }
                                };

                                var chart = new ApexCharts(document.querySelector("#stackedDefectChart"), options);
                                chart.render();
                            });
                            </script>

                            
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
    <script src="js/deznav-init.js"></script>
    
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="vendor/apexchart/apexchart.js"></script>

    <script>
    $(document).ready(function(){
        function updateExportLinks() {
            var f_range  = '<?= $f_range ?>';
            var f_fy     = $('#f_fy').val();
            var f_quarter = $('#f_quarter').val();
            var f_type   = $('#f_type').val();
            var f_model  = $('#f_model').val();
            var f_shift  = $('#f_shift').val();
            
            var baseParams = `f_range=${f_range}&f_fy=${f_fy}&f_quarter=${f_quarter}&f_type=${f_type}&f_model=${f_model}&f_shift=${f_shift}`;
            
            // Re-bind or remove if needed, but keeping the function structure
        }

        // Initialize links on load
        updateExportLinks();


    });
    </script>

</body>
</html>