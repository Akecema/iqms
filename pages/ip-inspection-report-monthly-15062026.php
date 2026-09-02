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
                        <h2>Monthly Summary</h2>
                        <p>This section provides the overview of total defects found across all types and models cross financial year.</p>
                    </div>

                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">
                            <div class="row">                    
                                <div class="col-12">
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

                                        // Build shared WHERE $filter_sql
                                        $filter_sql = "";
                                        
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

                                        <!-- Centralized Filter Panel -->
                                        <div class="col-xl-12 mb-4">
                                            <div class="card border-0 shadow-sm">
                                                <div class="card-body py-3 px-4">
                                                    <form method="GET" id="filterFormMain">
                                                        <div class="row g-2 align-items-end">
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Financial Year</label>
                                                                <select name="f_fy" id="f_fy" class="form-select form-select-sm cs-border-primary text-primary" onchange="this.form.submit()">
                                                                    <?php while($fy_row = mysqli_fetch_assoc($fy_res_f)): ?>
                                                                        <option value="<?= $fy_row['financial_year'] ?>" <?= ($f_fy == $fy_row['financial_year']) ? 'selected' : '' ?>>
                                                                            FY <?= $fy_row['financial_desc'] ?>
                                                                        </option>
                                                                    <?php endwhile; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Quarter</label>
                                                                <select name="f_quarter" id="f_quarter" class="form-select form-select-sm cs-border-primary">
                                                                    <option value="">- All Quarters -</option>
                                                                    <?php if($qtr_res): while($q_row = mysqli_fetch_assoc($qtr_res)): ?>
                                                                        <option value="<?= $q_row['quarter_id'] ?>" <?= ($f_quarter == $q_row['quarter_id']) ? 'selected' : '' ?>><?= htmlspecialchars($q_row['quarter_name']) ?></option>
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
                                                            <div class="col-auto g-4">
                                                                <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Shift</label>
                                                                <select name="f_shift" id="f_shift" class="form-select form-select-sm cs-border-primary">
                                                                    <option value="">- All Shifts -</option>
                                                                    <?php if($shift_res): while($sh_row = mysqli_fetch_assoc($shift_res)): ?>
                                                                        <option value="<?= $sh_row['shiftshort'] ?>" <?= ($f_shift == $sh_row['shiftshort']) ? 'selected' : '' ?>><?= $sh_row['shiftdesc'] ?></option>
                                                                    <?php endwhile; endif; ?>
                                                                </select>
                                                            </div>
                                                            <div class="col-auto g-4">
                                                                <button type="submit" class="btn btn-sm btn-black" style="min-width:80px;">Apply</button>
                                                                <a href="<?= basename($_SERVER['PHP_SELF']) ?>" class="btn btn-sm btn-dark" style="min-width:80px;"><i class="fa fa-redo me-1"></i> Reset</a>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Data Preparation for Chart and Tables -->
                            <?php
                            $months = [
                                2 => 'Feb',
                                3 => 'Mac',
                                4 => 'April',
                                5 => 'May',
                                6 => 'June',
                                7 => 'July',
                                8 => 'Aug',
                                9 => 'Sept',
                                10 => 'Oct',
                                11 => 'Nov',
                                12 => 'Dec',
                                1 => 'Jan'
                            ];

                            // Filter months if Quarter is selected
                            if (!empty($f_quarter) && !empty($q_months_filter)) {
                                $filtered_months = [];
                                foreach ($months as $num => $name) {
                                    if (in_array($num, $q_months_filter)) {
                                        $filtered_months[$num] = $name;
                                    }
                                }
                                $months = $filtered_months;
                            }

                            // Get Row Headers (Model Types)
                            $sql_mt = "SELECT typeid, typemodel FROM model_type 
                                        WHERE typestatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant' 
                                        ORDER BY typemodel ASC";
                            $res_mt = mysqli_query($db_con, $sql_mt);
                            $model_types = [];
                            while($row = mysqli_fetch_assoc($res_mt)) $model_types[] = $row;

                            // Get Defect Data
                            $sql_data = "SELECT 
                                            IR.ir_type as model_type_id, 
                                            MONTH(IR.shift_date) as month_num,
                                            COUNT(ID.defect_id) as qty
                                        FROM inspection_records IR
                                        JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
                                        WHERE IR.financial_yr = '$targetFY' 
                                        AND IR.ir_result = 'NG' AND IR.ir_status = '5' $filter_sql
                                        GROUP BY IR.ir_type, MONTH(IR.shift_date)";
                            $res_data = mysqli_query($db_con, $sql_data);
                            $matrix = [];
                            while($row = mysqli_fetch_assoc($res_data)){
                                $matrix[$row['model_type_id']][$row['month_num']] = $row['qty'];
                            }

                            // Get Total Inspections for Line Chart
                            $sql_insp = "SELECT 
                                            MONTH(IR.shift_date) as month_num,
                                            COUNT(IR.ir_id) as qty
                                        FROM inspection_records IR
                                        WHERE IR.financial_yr = '$targetFY' 
                                        AND IR.ir_status = '5' $filter_sql
                                        GROUP BY MONTH(IR.shift_date)";
                            $res_insp = mysqli_query($db_con, $sql_insp);
                            $inspect_matrix = [];
                            while($row = mysqli_fetch_assoc($res_insp)) {
                                $inspect_matrix[$row['month_num']] = $row['qty'];
                            }

                            // Chart Data Prep
                            $chart_months = array_values($months);
                            $stackedSeries = [];
                            
                            // 1. Add Stacked Bars (Defect Types)
                            foreach($model_types as $mt) {
                                $type_id = $mt['typeid'];
                                $type_name = $mt['typemodel'];
                                $data_pts = [];
                                foreach($months as $num => $m_name) {
                                    $data_pts[] = isset($matrix[$type_id][$num]) ? (int)$matrix[$type_id][$num] : 0;
                                }
                                $stackedSeries[] = [
                                    'name' => $type_name,
                                    'type' => 'column', // Bar
                                    'data' => $data_pts
                                ];
                            }

                            // 2. Add Line Chart (Total Inspection)
                            $inspect_data_pts = [];
                            foreach($months as $num => $m_name) {
                                $inspect_data_pts[] = isset($inspect_matrix[$num]) ? (int)$inspect_matrix[$num] : 0;
                            }
                            $stackedSeries[] = [
                                'name' => 'Total Inspection',
                                'type' => 'line', // Line
                                'data' => $inspect_data_pts
                            ];

                            // 3. Get Defect Data by Shift (D & N)
                            $sql_shift = "SELECT 
                                            MONTH(IR.shift_date) as month_num,
                                            IR.ir_shift,
                                            COUNT(ID.defect_id) as qty
                                        FROM inspection_records IR
                                        JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
                                        WHERE IR.financial_yr = '$targetFY' 
                                        AND IR.ir_result = 'NG' AND IR.ir_status = '5' $filter_sql
                                        GROUP BY MONTH(IR.shift_date), IR.ir_shift";
                            $res_shift = mysqli_query($db_con, $sql_shift);
                            $shift_matrix = [];
                            while($row = mysqli_fetch_assoc($res_shift)) {
                                $shift_matrix[$row['ir_shift']][$row['month_num']] = $row['qty'];
                            }

                            $shiftD_data = [];
                            $shiftN_data = [];
                            foreach($months as $num => $name) {
                                $shiftD_data[] = isset($shift_matrix['D'][$num]) ? (int)$shift_matrix['D'][$num] : 0;
                                $shiftN_data[] = isset($shift_matrix['N'][$num]) ? (int)$shift_matrix['N'][$num] : 0;
                            }
                            ?>

                            <!-- Monthly Summary Overview -->                        
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-0 border-bottom">
                                        <h4 class="heading mb-0">Monthly Overview</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered custom-table-summary text-center">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th class="text-start" style="width: 200px;">Month</th>
                                                        <?php foreach($months as $num => $name): ?>
                                                            <th class="text-center"><?= $name ?></th>
                                                        <?php endforeach; ?>
                                                        <th class="text-center">Grand Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <th class="text-start bg-light">Total Inspection</th>
                                                        <?php 
                                                        $grand_total_insp = 0;
                                                        foreach($months as $num => $name) {
                                                            $qty_insp = isset($inspect_matrix[$num]) ? (int)$inspect_matrix[$num] : 0;
                                                            $grand_total_insp += $qty_insp;
                                                            echo "<td class='text-center'>".($qty_insp > 0 ? number_format($qty_insp) : "-")."</td>";
                                                        }
                                                        ?>
                                                        <th class="text-center bg-light"><?= number_format($grand_total_insp) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-start bg-light">Defects Found</th>
                                                        <?php 
                                                        $total_all_months = 0;
                                                        // Calculate monthly totals
                                                        $monthly_totals = [];
                                                        foreach($months as $num => $name) {
                                                            $sql_m_total = "SELECT COUNT(ID.defect_id) as qty
                                                                            FROM inspection_records IR
                                                                            JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
                                                                            WHERE IR.financial_yr = '$targetFY' 
                                                                                AND IR.ir_result = 'NG' AND IR.ir_status = '5' 
                                                                                AND MONTH(IR.shift_date) = '$num' $filter_sql";
                                                            $res_m_total = mysqli_query($db_con, $sql_m_total);
                                                            $row_m_total = mysqli_fetch_assoc($res_m_total);
                                                            $qty = (int)($row_m_total['qty'] ?? 0);
                                                            $monthly_totals[$num] = $qty;
                                                            $total_all_months += $qty;
                                                            echo "<td class='text-center' style='".($qty > 0 ? "color: #3c8313ff; font-weight: 600;" : "")."'>".($qty > 0 ? number_format($qty) : "-")."</td>";
                                                        }
                                                        ?>
                                                        <th class="text-center bg-light"><?= number_format($total_all_months) ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-start bg-light">Defect Rate (%)</th>
                                                        <?php 
                                                        foreach($months as $num => $name) {
                                                            $d = $monthly_totals[$num];
                                                            $i = isset($inspect_matrix[$num]) ? (int)$inspect_matrix[$num] : 0;
                                                            $rate = $i > 0 ? ($d / $i) * 100 : 0;
                                                            echo "<td class='text-center' style='".($rate > 0 ? "color: #af0808; font-weight: 600;" : "")."'>".($rate > 0 ? number_format($rate, 2)."%" : "-")."</td>";
                                                        }
                                                        $grand_rate = $grand_total_insp > 0 ? ($total_all_months / $grand_total_insp) * 100 : 0;
                                                        ?>
                                                        <th class="text-center bg-light" style="color: #af0808; font-weight: 600;"><?= number_format($grand_rate, 2) ?>%</th>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <hr class="my-4">
                                        <div id="monthlyOverviewChart"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-0 border-bottom">
                                        <h4 class="heading mb-0">Monthly Defect Trend by Shift</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="shiftTrendChart"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- by type -->
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-header border-0 border-bottom d-flex justify-content-between align-items-center flex-wrap">
                                        <div>
                                            <h4 class="heading mb-0">Defect Type</h4>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <div class="dropdown custom-dropdown">
                                                <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; background: transparent; border: none;">
                                                    <i class="fa fa-bars" style="font-size: 18px; color: #5a5c69;"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" id="exportExcelBtn" href="export-inspection-report-monthly-type.php?fy=<?= $targetFY ?>"><i class="fa fa-file-excel text-greens me-2"></i> Download Excel</a></li>
                                                    <li><a class="dropdown-item" id="exportPdfBtn" href="export-inspection-report-monthly-type-pdf.php?fy=<?= $targetFY ?>" target="_blank"><i class="fa fa-file-pdf text-red me-2"></i> Download PDF</a></li>
                                                </ul>
                                            </div>                                                            
                                        </div>
                                    </div>
                                                
                                    <div class="card-body defect-type">

                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="input-group search-area d-none d-md-inline-flex" style="width: 250px;">
                                                    <input type="text" class="form-control" id="defectSearchInput" placeholder="Search type name...">
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
                                            $col_totals = array_fill_keys(array_keys($months), 0);
                                            $grand_total = 0;
                                            ?>
                                            <table class="table table-bordered table-striped custom-table-summary" id="montlhy-type-table">
                                                <thead>
                                                    <tr>
                                                        <th>Type</th>
                                                        <?php foreach($months as $num => $name): ?>
                                                            <th class="text-center"><?= $name ?></th>
                                                        <?php endforeach; ?>
                                                        <th class="text-center">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    foreach($model_types as $mt): 
                                                        $row_sum = 0;
                                                        $type_id = $mt['typeid'];
                                                    ?>
                                                        <tr>
                                                            <td><strong><?= $mt['typemodel'] ?></strong></td>
                                                            <?php foreach($months as $num => $name): 
                                                                $qty = isset($matrix[$type_id][$num]) ? $matrix[$type_id][$num] : 0;
                                                                $row_sum += $qty;
                                                                $col_totals[$num] += $qty;
                                                            ?>
                                                                <td class="text-center" style="<?= $qty > 0 ? 'color: #3c8313ff; font-weight: 600;' : '' ?>"><?= $qty > 0 ? number_format($qty) : '-' ?></td>
                                                            <?php endforeach; ?>
                                                            <td class="text-center"><strong><?= number_format($row_sum) ?></strong></td>
                                                            <?php $grand_total += $row_sum; ?>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-total">
                                                        <td>Total</td>
                                                        <?php foreach($months as $num => $name): ?>
                                                            <td class="text-center"><?= number_format($col_totals[$num]) ?></td>
                                                        <?php endforeach; ?>
                                                        <td class="text-center"><?= number_format($grand_total) ?></td>
                                                    </tr>
                                                    <tr class="table-total" style="background-color: #f8f9fa !important; color: #333 !important;">
                                                        <td style="background-color: #f8f9fa !important; color: #333 !important;">Defect Rate (%)</td>
                                                        <?php 
                                                        foreach($months as $num => $name): 
                                                            $d = $col_totals[$num];
                                                            $i = isset($inspect_matrix[$num]) ? (int)$inspect_matrix[$num] : 0;
                                                            $rate = $i > 0 ? ($d / $i) * 100 : 0;
                                                        ?>
                                                            <td class="text-center" style="background-color: #f8f9fa !important; color: #af0808ff !important; font-weight: 600 !important;"><?= $rate > 0 ? number_format($rate, 2)."%" : "-" ?></td>
                                                        <?php endforeach; 
                                                        $grand_rate_type = $grand_total_insp > 0 ? ($grand_total / $grand_total_insp) * 100 : 0;
                                                        ?>
                                                        <td class="text-center" style="background-color: #f8f9fa !important; color: #af0808ff !important; font-weight: 600 !important;"><?= number_format($grand_rate_type, 2) ?>%</td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>

                                        <hr>    
                                            
                                        <div id="stackedMonthlyChart"></div>

                                    </div> 
                                </div>
                            </div>

                            <!-- <div class="row">
                                <div class="col-xl-12 mb-4">
                                    <div class="card border-0 shadow-sm">
                                        <div class="card-header border-0 border-bottom">
                                            <h4 class="heading mb-0">Inspection & Defect Type Overview</h4>
                                        </div>
                                        <div class="card-body">
                                            
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                            
                            <div class="col-12">
                                <div class="accordion accordion-with-icon accordion-header-bg accordion-bordered">
                                    <div class="row">
                                        <div class="col-xl-12">
                                            <div class="card">
                                                <div class="card-header border-0 border-bottom d-flex justify-content-between align-items-center flex-wrap">
                                                    <div>
                                                        <h4 class="heading mb-0">Defect by Model</h4>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <div class="dropdown custom-dropdown">
                                                            <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; background: transparent; border: none;">
                                                                <i class="fa fa-bars" style="font-size: 18px; color: #5a5c69;"></i>
                                                            </button>
                                                            <ul class="dropdown-menu dropdown-menu-end">
                                                                <li><a class="dropdown-item" id="exportExcelBtnModel" href="export-inspection-report-monthly-model.php?fy=<?= $targetFY_m ?>"><i class="fa fa-file-excel text-greens me-2"></i> Download Excel</a></li>
                                                                <li><a class="dropdown-item" id="exportPdfBtnModel" href="export-inspection-report-monthly-model-pdf.php?fy=<?= $targetFY_m ?>" target="_blank"><i class="fa fa-file-pdf text-red me-2"></i> Download PDF</a></li>
                                                            </ul>
                                                        </div>                                                            
                                                    </div>
                                                </div>
                                                            
                                                <div class="card-body defect-model">

                                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="input-group search-area d-none d-md-inline-flex" style="width: 250px;">
                                                                <input type="text" class="form-control" id="defectModelSearchInput" placeholder="Search model name...">
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
                                                        // Get Row Headers (Model Details)
                                                        $sql_md = "SELECT modid, modcode FROM model_details 
                                                                    WHERE modstatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant' 
                                                                    ORDER BY modcode ASC";
                                                        $res_md = mysqli_query($db_con, $sql_md);
                                                        $model_details = [];
                                                        while($row = mysqli_fetch_assoc($res_md)) $model_details[] = $row;

                                                        // Get Defect Data for Models
                                                        $sql_data_m = "SELECT 
                                                                        IR.ir_model as model_id, 
                                                                        MONTH(IR.shift_date) as month_num,
                                                                        COUNT(ID.defect_id) as qty
                                                                        FROM inspection_records IR
                                                                        JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
                                                                        WHERE IR.financial_yr = '$f_fy' 
                                                                        AND IR.ir_result = 'NG' AND IR.ir_status = '5' $filter_sql
                                                                        GROUP BY IR.ir_model, MONTH(IR.shift_date)";
                                                        $res_data_m = mysqli_query($db_con, $sql_data_m);
                                                        $matrix_m = [];
                                                        while($row = mysqli_fetch_assoc($res_data_m)){
                                                            $matrix_m[$row['model_id']][$row['month_num']] = $row['qty'];
                                                        }

                                                        // Prepare Model Chart Series
                                                        $stackedSeriesModel = [];
                                                        foreach($model_details as $md) {
                                                            $mod_id = $md['modid'];
                                                            $mod_code = $md['modcode'];
                                                            $data_pts_m = [];
                                                            $has_data = false;
                                                            foreach($months as $num => $m_name) {
                                                                $val = isset($matrix_m[$mod_id][$num]) ? (int)$matrix_m[$mod_id][$num] : 0;
                                                                $data_pts_m[] = $val;
                                                                if($val > 0) $has_data = true;
                                                            }
                                                            
                                                            // Only show models that have at least one defect in this period to keep chart clean
                                                            if($has_data){
                                                                $stackedSeriesModel[] = [
                                                                    'name' => $mod_code,
                                                                    'type' => 'column',
                                                                    'data' => $data_pts_m
                                                                ];
                                                            }
                                                        }

                                                        // Add Total Inspection line to model chart for consistency
                                                        if(isset($inspect_data_pts)){
                                                            $stackedSeriesModel[] = [
                                                                'name' => 'Total Inspection',
                                                                'type' => 'line',
                                                                'data' => $inspect_data_pts
                                                            ];
                                                        }
                                                        ?>
                                                        
                                                        <table class="table table-bordered table-striped custom-table-summary" id="montlhy-model-table">
                                                            <thead>
                                                                <tr>
                                                                    <th>Type</th>
                                                                    <?php foreach($months as $num => $name): ?>
                                                                        <th class="text-center"><?= $name ?></th>
                                                                    <?php endforeach; ?>
                                                                    <th class="text-center">Total</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <?php 
                                                                $col_totals_m = array_fill_keys(array_keys($months), 0);
                                                                $grand_total_m = 0;
                                                                foreach($model_details as $md): 
                                                                    $row_sum_m = 0;
                                                                    $mod_id = $md['modid'];
                                                                ?>
                                                                    <tr>
                                                                        <td><strong><?= $md['modcode'] ?></strong></td>
                                                                        <?php foreach($months as $num => $name): 
                                                                            $qty_m = isset($matrix_m[$mod_id][$num]) ? $matrix_m[$mod_id][$num] : 0;
                                                                            $row_sum_m += $qty_m;
                                                                            $col_totals_m[$num] += $qty_m;
                                                                        ?>
                                                                            <td class="text-center" style="<?= $qty_m > 0 ? 'color: #3c8313ff; font-weight: 600;' : '' ?>"><?= $qty_m > 0 ? number_format($qty_m) : '-' ?></td>
                                                                        <?php endforeach; ?>
                                                                        <td class="text-center"><strong><?= number_format($row_sum_m) ?></strong></td>
                                                                        <?php $grand_total_m += $row_sum_m; ?>
                                                                    </tr>
                                                                <?php endforeach; ?>
                                                            </tbody>
                                                            <tfoot>
                                                                <tr class="table-total">
                                                                    <td>Total</td>
                                                                    <?php foreach($months as $num => $name): ?>
                                                                        <td class="text-center"><?= number_format($col_totals_m[$num]) ?></td>
                                                                    <?php endforeach; ?>
                                                                    <td class="text-center"><?= number_format($grand_total_m) ?></td>
                                                                </tr>
                                                                <tr class="table-total" style="background-color: #f8f9fa !important; color: #333 !important;">
                                                                    <td style="background-color: #f8f9fa !important; color: #333 !important;">Defect Rate (%)</td>
                                                                    <?php 
                                                                    foreach($months as $num => $name): 
                                                                        $d = $col_totals_m[$num];
                                                                        $i = isset($inspect_matrix[$num]) ? (int)$inspect_matrix[$num] : 0;
                                                                        $rate = $i > 0 ? ($d / $i) * 100 : 0;
                                                                    ?>
                                                                        <td class="text-center" style="background-color: #f8f9fa !important; color: #af0808ff !important; font-weight: 700 !important;"><?= $rate > 0 ? number_format($rate, 2)."%" : "-" ?></td>
                                                                    <?php endforeach; 
                                                                    $grand_rate_model = $grand_total_insp > 0 ? ($grand_total_m / $grand_total_insp) * 100 : 0;
                                                                    ?>
                                                                    <td class="text-center" style="background-color: #f8f9fa !important; color: #af0808ff !important; font-weight: 700 !important;"><?= number_format($grand_rate_model, 2) ?>%</td>
                                                                </tr>
                                                            </tfoot>
                                                        </table>
                                                    </div>

                                                    <hr>    
                                            
                                                    <div id="stackedMonthlyChartModel"></div>

                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="card border-0 shadow-sm" style="box-shadow: 0 0.125rem 0.25rem #9c9898ff !important;">
                                    <div class="card-header border-0 border-bottom">
                                        <h4 class="heading mb-0"><i class="fa fa-lightbulb me-2" aria-hidden="true"></i> Insight</h4>
                                    </div>
                                    <div class="card-body py-3 px-4">
                                        <?php
                                        // Calculate Insights
                                        $insights = [];

                                        // 1. Peak Month
                                        $peak_val = -1;
                                        $peak_month = "";
                                        foreach($months as $num => $name) {
                                            if($monthly_totals[$num] > $peak_val) {
                                                $peak_val = $monthly_totals[$num];
                                                $peak_month = $name;
                                            }
                                        }
                                        if($peak_val > 0) $insights[] = "Peak defects detected in <strong>$peak_month</strong> (<strong>$peak_val</strong> defects)";

                                        // 2. Shift Comparison
                                        $totalD = array_sum($shiftD_data);
                                        $totalN = array_sum($shiftN_data);
                                        $totalShift = $totalD + $totalN;
                                        if($totalShift > 0) {
                                            if($totalN > $totalD) {
                                                $diff = (($totalN - $totalD) / ($totalD > 0 ? $totalD : 1)) * 100;
                                                $insights[] = "Night shift has higher defects (<strong>+".number_format($diff, 1)."%</strong> compared to Day)";
                                            } else if($totalD > $totalN) {
                                                $diff = (($totalD - $totalN) / ($totalN > 0 ? $totalN : 1)) * 100;
                                                $insights[] = "Day shift has higher defects (<strong>+".number_format($diff, 1)."%</strong> compared to Night)";
                                            } else {
                                                $insights[] = "Defect distribution is <strong>equal</strong> between Day and Night shifts";
                                            }
                                        }

                                        // 3. Overall Defect Rate & Volume
                                        if($grand_total_insp > 0) {
                                            $insights[] = "Total inspection volume reached <strong>".number_format($grand_total_insp)."</strong> units";
                                            $insights[] = "Overall defect rate for the selected period is <strong>".number_format($grand_rate, 2)."%</strong>";
                                        }

                                        // 4. Trend (Compare last 2 months that have data)
                                        $months_with_data = [];
                                        $month_nums = array_keys($months);
                                        foreach($month_nums as $m_num) {
                                            if(isset($inspect_matrix[$m_num]) && $inspect_matrix[$m_num] > 0) {
                                                $months_with_data[] = $m_num;
                                            }
                                        }

                                        if(count($months_with_data) >= 2) {
                                            $curr_m = end($months_with_data);
                                            $prev_m = prev($months_with_data);
                                            
                                            $curr_d = $monthly_totals[$curr_m];
                                            $curr_i = $inspect_matrix[$curr_m];
                                            $curr_r = ($curr_d / $curr_i) * 100;
                                            
                                            $prev_d = $monthly_totals[$prev_m];
                                            $prev_i = $inspect_matrix[$prev_m];
                                            $prev_r = ($prev_d / $prev_i) * 100;
                                            
                                            $delta = $curr_r - $prev_r;
                                            $delta_fmt = number_format(abs($delta), 1) . "%";
                                            
                                            $curr_name = $months[$curr_m];
                                            $prev_name = $months[$prev_m];

                                            if($delta < 0) {
                                                $status = "<span class='text-success' style='font-weight:600;'>(Improvement)</span>";
                                                $insights[] = "Defect rate decreased by <strong>$delta_fmt</strong> from $prev_name to $curr_name $status";
                                            } else if ($delta > 0) {
                                                $status = "<span class='text-danger' style='font-weight:600;'>(Increase)</span>";
                                                $insights[] = "Defect rate increased by <strong>$delta_fmt</strong> from $prev_name to $curr_name $status";
                                            } else {
                                                $insights[] = "Defect rate remained consistent between $prev_name and $curr_name";
                                            }
                                        }

                                        // defect rate between 2 month

                                        

                                        ?>

                                        <?php if(!empty($insights)): ?>
                                            <ul style="list-style-type: none; padding: 0; margin-top: 10px;">
                                                <?php foreach($insights as $insight): ?>
                                                    <li style="margin-bottom: 12px; font-size: 13px; color: #444; display: flex; align-items: flex-start; gap: 10px;">
                                                        <div style="min-width: 6px; height: 6px; background: #11470F; border-radius: 50%; margin-top: 6px;"></div>
                                                        <div><?= $insight ?></div>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <p class="mb-0 text-muted" style="font-size: 13px;">No specific insights available for the current filter selection.</p>
                                        <?php endif; ?>
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
    <script src="js/deznav-init.js"></script>
    
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="vendor/apexchart/apexchart.js"></script>

    <script>
    $(document).ready(function(){
        // Chart Data
        var chartMonths = <?= json_encode($chart_months) ?>;
        var chartSeries = <?= json_encode($stackedSeries) ?>;
        var monthlyOverviewLabels = <?= json_encode(array_values($months)) ?>;
        var monthlyOverviewData = <?= json_encode(array_values($monthly_totals)) ?>;
        var shiftDData = <?= json_encode($shiftD_data) ?>;
        var shiftNData = <?= json_encode($shiftN_data) ?>;

        // Monthly Overview Chart
        if(document.querySelector("#monthlyOverviewChart")){
            var optionsOverview = {
                series: [{
                    name: 'Defects Found',
                    type: 'area',
                    data: monthlyOverviewData
                }],
                colors: ['#11470F'],
                chart: {
                    height: 300,
                    type: 'line',
                    toolbar: { show: false }
                },
                stroke: {
                    width: [3],
                    curve: 'smooth'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.7,
                        opacityTo: 0.2,
                        stops: [0, 90, 100]
                    }
                },
                xaxis: {
                    categories: monthlyOverviewLabels,
                },
                markers: {
                    size: 5,
                    colors: ["#11470F"],
                    strokeColors: "#fff",
                    strokeWidth: 2,
                },
                dataLabels: {
                    enabled: true,
                    offsetY: -10,
                    style: { fontSize: '12px', colors: ['#11470F'] }
                },
                tooltip: {
                    y: { formatter: function(val) { return val + " defects"; } }
                }
            };
            var chartOverview = new ApexCharts(document.querySelector("#monthlyOverviewChart"), optionsOverview);
            chartOverview.render();
        }

        // Shift Trend Chart
        if(document.querySelector("#shiftTrendChart")){
            var optionsShift = {
                series: [{
                    name: 'Day',
                    data: shiftDData
                }, {
                    name: 'Night',
                    data: shiftNData
                }],
                chart: {
                    height: 350,
                    type: 'area', // Area chart for shift comparison                    
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    },
                },
                colors: ['#11470F', '#d3bb1bff'], // Blue for Day, Red for Night
                dataLabels: { enabled: true },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.45,
                        opacityTo: 0.05,
                        stops: [20, 100, 100, 100]
                    }
                },
                xaxis: {
                    categories: monthlyOverviewLabels,
                },
                tooltip: {
                    x: { format: 'dd/MM/yy HH:mm' },
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left'
                }
            };
            var chartShift = new ApexCharts(document.querySelector("#shiftTrendChart"), optionsShift);
            chartShift.render();
        }

        if(typeof ApexCharts !== 'undefined' && document.querySelector("#stackedMonthlyChart")){
            var options = {
                series: chartSeries,
                chart: {
                    height: 400,
                    type: 'line', 
                    stacked: true,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    },
                    zoom: {
                        enabled: true
                    }
                },
                stroke: {
                    width: chartSeries.map(s => s.type === 'line' ? 3 : 0),
                    curve: 'smooth'
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
                        borderRadius: 4,
                        columnWidth: '45%',
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 700,
                                    color: '#333'
                                }
                            }
                        }
                    },
                },
                xaxis: {
                    categories: chartMonths,
                    axisBorder: { show: false },
                    axisTicks: { show: false }
                },
                yaxis: {
                    title: {
                        text: 'Quantity',
                        style: {
                            color: '#555',
                            fontWeight: 600
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left',
                    offsetY: 0
                },
                fill: {
                    opacity: chartSeries.map(s => s.type === 'line' ? 1 : 1),
                },
                colors: ['#0F1405','#2A380F','#455C19','#608023','#7AA42D','#95C837','#A5D156','#BBDC7F', '#1B3133', '#FF4560'],
                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: chartSeries.map(s => s.type === 'line' ? 4 : 0),
                }
            };

            var chart = new ApexCharts(document.querySelector("#stackedMonthlyChart"), options);
            chart.render();
        }

        var chartSeriesModel = <?= json_encode($stackedSeriesModel) ?>;
        if(typeof ApexCharts !== 'undefined' && document.querySelector("#stackedMonthlyChartModel")){
            var optionsModel = {
                series: chartSeriesModel,
                chart: {
                    height: 400,
                    type: 'line', 
                    stacked: true,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    }
                },
                stroke: {
                    width: chartSeriesModel.map(s => s.type === 'line' ? 3 : 0),
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        borderRadius: 4,
                        columnWidth: '45%',
                        dataLabels: {
                            total: {
                                enabled: true,
                                style: {
                                    fontSize: '13px',
                                    fontWeight: 700,
                                    color: '#333'
                                }
                            }
                        }
                    },
                },
                xaxis: {
                    categories: chartMonths,
                },
                yaxis: {
                    title: {
                        text: 'Quantity',
                        style: {
                            color: '#555',
                            fontWeight: 600
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'left'
                },
                fill: {
                    opacity: 1
                },
                // Use a wider variety of colors for models as there can be many
                colors: ['#0F1405','#2A380F','#455C19','#608023','#7AA42D','#95C837','#A5D156','#BBDC7F', '#1B3133', '#af0808ff', '#5a5c69', '#364536ff', '#FF4560'],
                dataLabels: {
                    enabled: false
                },
                markers: {
                    size: chartSeriesModel.map(s => s.type === 'line' ? 4 : 0),
                }
            };

            var chartModel = new ApexCharts(document.querySelector("#stackedMonthlyChartModel"), optionsModel);
            chartModel.render();
        }

        // Back buttons
        $('#btnBack').on('click', function() {
            history.back();
        });

        // Function to recalculate table totals based on visible rows
        function recalculateTotals() {
            let colTotals = [];
            let grandTotal = 0;
            let numCols = $("#montlhy-type-table thead tr th").length;
            
            for (let i = 1; i < numCols - 1; i++) {
                colTotals[i] = 0;
            }

            $("#montlhy-type-table tbody tr:visible").each(function() {
                let row = $(this);
                for (let i = 1; i < numCols - 1; i++) {
                    let cellVal = row.find('td').eq(i).text().replace(/,/g, '').trim();
                    let val = cellVal === '-' ? 0 : parseInt(cellVal);
                    if (!isNaN(val)) {
                        colTotals[i] += val;
                        grandTotal += val;
                    }
                }
            });

            let footerRow = $("#montlhy-type-table tfoot tr");
            for (let i = 1; i < numCols - 1; i++) {
                footerRow.find('td').eq(i).text(colTotals[i] > 0 ? colTotals[i].toLocaleString() : '-');
            }
            
            footerRow.find('td').eq(numCols - 1).text(grandTotal.toLocaleString());
        }

        // Function to update export links with all filter parameters
        function updateExportLinks() {
            var f_fy     = $('#f_fy').val();
            var f_quarter = $('#f_quarter').val();
            var f_type   = $('#f_type').val();
            var f_model  = $('#f_model').val();
            var f_shift  = $('#f_shift').val();
            var searchType  = $('#defectSearchInput').val() || '';
            var searchModel = $('#defectModelSearchInput').val() || '';
            
            var baseParams = `f_fy=${f_fy}&f_quarter=${f_quarter}&f_type=${f_type}&f_model=${f_model}&f_shift=${f_shift}`;
            
            $("#exportExcelBtn").attr("href", `export-inspection-report-monthly-type.php?${baseParams}&search=${encodeURIComponent(searchType)}`);
            $("#exportPdfBtn").attr("href", `export-inspection-report-monthly-type-pdf.php?${baseParams}&search=${encodeURIComponent(searchType)}`);
            
            $("#exportExcelBtnModel").attr("href", `export-inspection-report-monthly-model.php?${baseParams}&search=${encodeURIComponent(searchModel)}`);
            $("#exportPdfBtnModel").attr("href", `export-inspection-report-monthly-model-pdf.php?${baseParams}&search=${encodeURIComponent(searchModel)}`);
        }

        // Real-time table search/filter
        $("#defectSearchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#montlhy-type-table tbody tr").filter(function() {
                var defectName = $(this).find("td:first").text().toLowerCase();
                $(this).toggle(defectName.indexOf(value) > -1)
            });
            recalculateTotals();
            updateExportLinks();
        });

        function recalculateTotalsModel() {
            let colTotals = [];
            let grandTotal = 0;
            let numCols = $("#montlhy-model-table thead tr th").length;
            
            for (let i = 1; i < numCols - 1; i++) {
                colTotals[i] = 0;
            }

            $("#montlhy-model-table tbody tr:visible").each(function() {
                let row = $(this);
                for (let i = 1; i < numCols - 1; i++) {
                    let cellVal = row.find('td').eq(i).text().replace(/,/g, '').trim();
                    let val = cellVal === '-' ? 0 : parseInt(cellVal);
                    if (!isNaN(val)) {
                        colTotals[i] += val;
                        grandTotal += val;
                    }
                }
            });

            let footerRow = $("#montlhy-model-table tfoot tr");
            for (let i = 1; i < numCols - 1; i++) {
                footerRow.find('td').eq(i).text(colTotals[i] > 0 ? colTotals[i].toLocaleString() : '-');
            }
            
            footerRow.find('td').eq(numCols - 1).text(grandTotal.toLocaleString());
        }

        $("#defectModelSearchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $("#montlhy-model-table tbody tr").filter(function() {
                var defectName = $(this).find("td:first").text().toLowerCase();
                $(this).toggle(defectName.indexOf(value) > -1)
            });
            recalculateTotalsModel();
            updateExportLinks();
        });

        // Initialize links on load
        updateExportLinks();


    });
    </script>

</body>
</html>