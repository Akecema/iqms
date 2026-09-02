<!-- System title -->
<?php include "../system-header.php";?>

<!-- Session start -->
<?php include "session-start.php"; ?> 

<!-- Shift management -->
<?php include "../shift.php"; ?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <!--Title-->
	<title><?php echo $syst_title; ?> - Dashboard</title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">
	<meta name="robots" content="index, follow">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="../icon/favicon.ico">
    
    <!-- CSS -->
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link href="vendor/swiper/css/swiper-bundle.min.css" rel="stylesheet">
	<link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	<link href="vendor/datatables/css/buttons.dataTables.min.css" rel="stylesheet">
	<link href="vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
	
	<!-- Style css -->
    <link class="main-css" href="css/style.css" rel="stylesheet"> 
    <link href="vendor/chartist/css/chartist.min.css" rel="stylesheet">  
    
    <!-- layout for tab IR, SR,S2W -->
    <link href="css/layout-style.css" rel="stylesheet">
    <link href="css/badge.css" rel="stylesheet">
    <link href="css/button.css" rel="stylesheet">
    <link href="css/modal.css" rel="stylesheet">
    <link href="css/form.css" rel="stylesheet">
    <link href="css/image.css" rel="stylesheet">
    
    <style>
        .widget-stat .media {
            align-items: center;
        }
        .widget-stat .media i {
            font-size: 30px;
            color: #fff;
        }
        .card-header {
            border-bottom: 0;
            padding-bottom: 0;
        }
        .welcome-card {
            background: linear-gradient(to right, #18301dff, #0d7b2dff);
            color: white;
            border: none;
            overflow: hidden;
            position: relative;
        }
        .welcome-card .card-body {
            position: relative;
            z-index: 1;
        }
        .welcome-card::after {
            content: "";
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }

        h5.tx-status
        {
            font-size : 12px;
            font-weight : 500
        }

        /* FG Filter Dropdown Styles */
        .fg-filter-menu {
            min-width: 450px !important;
            padding: 10px !important;
        }
        .fg-filter-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2px 10px;
        }
        .fg-filter-item-all {
            grid-column: span 2;
            border-bottom: 1px solid #eee;
            margin-bottom: 5px;
            padding-bottom: 5px;
        }
        .FG-filter-item {
            padding: 5px 12px !important;
            border-radius: 4px;
        }
        .FG-filter-item:hover {
            background: #f8f9fa;
        }
        .FG-filter-item .form-check {
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .FG-filter-item .form-check-input {
            margin-top: 0;
            cursor: pointer;
        }
        .FG-filter-item .form-check-label {
            margin-left: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 12px;
            color: #333;
            font-weight: 500;
        }
        .fg-filter-scroll {
            max-height: 350px;
            overflow-y: auto;
            padding-right: 5px;
        }
        /* Scrollbar styling */
        .fg-filter-scroll::-webkit-scrollbar {
            width: 5px;
        }
        .fg-filter-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .fg-filter-scroll::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        .fg-filter-scroll::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Type Filter Dropdown Styles */
        .type-filter-menu {
            min-width: 200px !important;
            padding: 10px !important;
        }
        .type-filter-grid {
            display: grid;
            grid-template-columns: repeat(1, 1fr);
            gap: 2px 10px;
        }
        .type-filter-item-all {
            /* grid-column: span 2; */
            border-bottom: 1px solid #eee;
            margin-bottom: 5px;
            padding-bottom: 5px;
        }
        .type-filter-dropdown-item {
            padding: 5px 12px !important;
            border-radius: 4px;
        }
        .type-filter-dropdown-item:hover {
            background: #f8f9fa;
        }
        .type-filter-dropdown-item .form-check {
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .type-filter-dropdown-item .form-check-input {
            margin-top: 0;
            cursor: pointer;
        }
        .type-filter-dropdown-item .form-check-label {
            margin-left: 10px;
            cursor: pointer;
            width: 100%;
            font-size: 12px;
            color: #333;
            font-weight: 500;
        }
        .nav-link.active {
            background-color: #000 !important;
            color: #fff !important;
        }
    
        /* custom tab toolbars */
        .custom-toolbar{
            background:#f1f1f1;
            padding:6px;
            border-radius:12px;
            display:inline-flex;
            gap:5px;
        }

        .custom-toolbar .nav-link{
            border:none;
            border-radius:10px;
            padding:10px 18px;
            text-align:center;
            color:#444;
            background:transparent;

            display:flex;
            flex-direction:column;
            align-items:center;
            justify-content:center;

            font-size:13px;
        }

        .custom-toolbar .nav-link i{
            font-size:18px;
            margin-bottom:3px;
        }

        .custom-toolbar .nav-link:hover{
            background:#e6e6e6;
        }

        .custom-toolbar .nav-link.active{
            background:white;
            box-shadow:0 2px 4px rgba(0,0,0,0.15);
            color:#000;
        }

        .custom-toolbar .nav-link.active:hover{
            background:#000;
            box-shadow:0 2px 4px rgba(0,0,0,0.15);
            color:#fff;
        }

        /* Redesigned Shift Tabs */
        #shiftTabs.nav-tabs {
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 45px !important;
        }
        #shiftTabs .nav-item {
            margin-bottom: -1px;
        }
        #shiftTabs .nav-link {
            border: 1px solid #e0e0e0;
            border-bottom: none;
            background: #f9faf9;
            color: #006241;
            font-weight: 500;
            font-size: 12px;
            padding: 15px 40px;
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            margin-right: 4px;
            transition: all 0.2s ease;
            min-width: 140px;
            text-align: center;
        }
        #shiftTabs .nav-link.active {
            background: #0b2110;
            color: #ffffff;
            border-color: #e0e0e0;
        }
        #shiftTabs .nav-link:hover:not(.active) {
            background: #f1f3f1;
        }

    </style>

</head>
<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper">

        <!-- Nav header -->
        <div class="nav-header">
            <?php include 'nav-hdr-logo.php'; ?>
        </div>
		
		<!-- Chat box -->
		<div class="chatbox">
			<div class="chatbox-close"></div>
            <?php include 'nav-hdr-chat-box.php'; ?>
		</div>
		
		<!-- Header -->
		<div class="header">
            <div class="header-content">
                <?php include 'nav-hdr-top.php'; ?>
			</div>
		</div>

        <!-- Sidebar -->
        <div class="deznav">
            <div class="deznav-scroll">
                <?php include 'nav-left-sidebar.php'; ?>
			</div>
        </div>

        <!-- Content body -->
        <div class="content-body">
			<div class="container-fluid">

                <?php include "get-financial-year.php"; ?>
                <?php
                // Fetch Inspection Result Overview Trend (Monthly OK vs NG)
                // Using the financial year
                $currentYearTrend = $financialyr;

                // Define shift for filtering
                $shift = $shiftshort ?? 'D'; 
                $shiftCondition = "";
                if ($shift == 'D') {
                    $shiftCondition = "AND ir_shift = 'D'";
                } elseif ($shift == 'N') {
                    $shiftCondition = "AND ir_shift = 'N'";
                }

                $queryOverviewTrend = "SELECT 
                                            MONTH(inspect_date) as m_num,
                                            DATE_FORMAT(inspect_date, '%b') as m_name,
                                            SUM(CASE WHEN ir_result = 'OK' THEN 1 ELSE 0 END) as ok_count,
                                            SUM(CASE WHEN ir_result = 'NG' THEN 1 ELSE 0 END) as ng_count
                                        FROM inspection_records 
                                        WHERE financial_yr = '$currentYearTrend' AND ir_result IS NOT NULL $shiftCondition
                                        GROUP BY m_num
                                        ORDER BY m_num";
                $resOverviewTrend = mysqli_query($db_con, $queryOverviewTrend);

                $trendMonths = ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan'];
                $trendOK = array_fill(0, 12, 0);
                $trendNG = array_fill(0, 12, 0);

                if ($resOverviewTrend) {
                    while($row = mysqli_fetch_assoc($resOverviewTrend)) {
                        $mNum = (int)$row['m_num'];
                        // Map month number to index: Feb (2) -> 0, Mar (3) -> 1, ..., Jan (1) -> 11
                        $mIndex = ($mNum == 1) ? 11 : $mNum - 2;
                        if ($mIndex >= 0 && $mIndex < 12) {
                            $trendOK[$mIndex] = (int)$row['ok_count'];
                            $trendNG[$mIndex] = (int)$row['ng_count'];
                        }
                    }
                }

                $totalInspectedYear = array_sum($trendOK) + array_sum($trendNG);
                $totalOKYear = array_sum($trendOK);
                $totalNGYear = array_sum($trendNG);
                $yieldYear = ($totalInspectedYear > 0) ? round(($totalOKYear / $totalInspectedYear) * 100, 1) : 0;

                // Fetch initial Defect (Type) Overview data for overiewChartType
                // Initially showing "Day" result as default
                $queryTypeDefects = "SELECT 
                                        T.defectname, 
                                        COUNT(D.defect_id) as total
                                      FROM inspection_records S 
                                      INNER JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id 
                                      INNER JOIN defect_type T ON T.defectid = D.defect_type 
                                      WHERE DATE(S.inspect_date) = CURDATE() AND S.ir_result = 'NG' 
                                      " . str_replace("ir_shift", "S.ir_shift", $shiftCondition) . "
                                      GROUP BY T.defectid, T.defectname
                                      ORDER BY total ASC";
                $resTypeDefects = mysqli_query($db_con, $queryTypeDefects);
                $typeDefectLabels = [];
                $typeDefectCounts = [];
                if ($resTypeDefects) {
                    while($row = mysqli_fetch_assoc($resTypeDefects)) {
                        $typeDefectLabels[] = $row['defectname'];
                        $typeDefectCounts[] = (int)$row['total'];
                    }
                }

                // 1. KPI Counts
                $kpiShiftCondition = str_replace("ir_shift", "I.ir_shift", $shiftCondition);
                $queryOK = "SELECT COUNT(*) as count FROM inspection_records I
                                WHERE I.ir_result = 'OK' AND DATE(I.inspect_date) = CURDATE() $kpiShiftCondition";
                $resultOK = mysqli_query($db_con, $queryOK);
                $rowOK = mysqli_fetch_assoc($resultOK);
                $countOK = $rowOK['count'];

                $queryNG = "SELECT COUNT(*) as count FROM inspection_records I
                                WHERE I.ir_result = 'NG' AND DATE(I.inspect_date) = CURDATE() $kpiShiftCondition";
                $resultNG = mysqli_query($db_con, $queryNG);
                $rowNG = mysqli_fetch_assoc($resultNG);
                $countNG = $rowNG['count'];
                
                //the percentage of items that passed inspection ("OK") out of the total number of items inspected
                $countInspections = $countOK + $countNG;
                $yield = ($countInspections > 0) ? round(($countOK / $countInspections) * 100, 1) : 0;

                // --- Dynamic Stacked Defect Chart Data ---
                $resModels = mysqli_query($db_con, "SELECT model_id, model FROM model_hdr WHERE model_status = 'AC' ORDER BY model ASC");
                $stackedCategories = [];
                $modelIndexMap = [];
                $modelCount = 0;
                while ($row = mysqli_fetch_assoc($resModels)) {
                    $stackedCategories[] = $row['model'];
                    $modelIndexMap[$row['model_id']] = $modelCount++;
                }

                $resTypes = mysqli_query($db_con, "SELECT typeid, typemodel FROM model_type WHERE typestatus = 'Y' ORDER BY typemodel ASC");
                $stackedSeries = [];
                $typeMatrix = [];
                while ($row = mysqli_fetch_assoc($resTypes)) {
                    $typeMatrix[$row['typeid']] = count($stackedSeries);
                    $stackedSeries[] = [
                        'name' => $row['typemodel'],
                        'data' => array_fill(0, max(0, $modelCount), 0)
                    ];
                }

                $queryDefectByModel = "SELECT 
                                            m_hdr.modelid,
                                            m_hdr.typeid,
                                            COUNT(I.ir_id) as defect_count
                                        FROM inspection_records I
                                        JOIN material_header m_hdr ON I.ir_material = m_hdr.matid
                                        WHERE I.ir_result = 'OK' AND DATE(I.inspect_date) = CURDATE() $kpiShiftCondition
                                        GROUP BY m_hdr.modelid, m_hdr.typeid";
                $resDefects = mysqli_query($db_con, $queryDefectByModel);
                while ($row = mysqli_fetch_assoc($resDefects)) {
                    $mid = $row['modelid'];
                    $tid = $row['typeid'];
                    if (isset($modelIndexMap[$mid]) && isset($typeMatrix[$tid])) {
                        $stackedSeries[$typeMatrix[$tid]]['data'][$modelIndexMap[$mid]] = (int)$row['defect_count'];
                    }
                }

                ?>
                
                <!-- Welcome Banner -->
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card welcome-card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h2 class="text-white">Inspection Dashboard</h2>
                                        <p class="mb-0">Overview of inspection performance, yield rates, and defect tracking.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="nav nav-tabs style-2 mb-4 mt-4" id="shiftTabs" role="tablist">
                    <li class="nav-item"><button class="nav-link <?= ($shiftshort=='D') ? 'active' : '' ?>" data-shift="D" type="button">Day</button></li>
                    <li class="nav-item"><button class="nav-link <?= ($shiftshort=='N') ? 'active' : '' ?>" data-shift="N" type="button">Night</button></li>
                    <li class="nav-item"><button class="nav-link" data-shift="ALL" type="button">All</button></li>
                </ul>

                <!-- Result by month -->
                <div class="col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-header border-0 pb-0 flex-wrap">
                            <h4 class="heading mb-0">Inspection Result Overview</h4> 
                            <div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/>
                                            <circle fill="#1b1a1aff" cx="5" cy="12" r="2"/>
                                            <circle fill="#1b1a1aff" cx="12" cy="12" r="2"/>
                                            <circle fill="#1b1a1aff" cx="19" cy="12" r="2"/></g>
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end fg-filter-menu">
                                        <div class="fg-filter-scroll">
                                            <div class="fg-filter-grid">
                                                <li class="dropdown-item FG-filter-item fg-filter-item-all" data-matid="all">
                                                    <div class="form-check custom-checkbox">
                                                        <input type="checkbox" class="form-check-input" id="check_all_fg">
                                                        <label class="form-check-label" for="check_all_fg">Show All</label>
                                                    </div>
                                                </li>
                                                <?php
                                                    $queryFGoods = "SELECT matid, matno FROM material_header WHERE matstatus = 'Y' ORDER BY matno ASC";
                                                    $resFGoodsDropdown = mysqli_query($db_con, $queryFGoods);
                                                    if($resFGoodsDropdown) {
                                                        while($m = mysqli_fetch_assoc($resFGoodsDropdown)) {
                                                            $matid = htmlspecialchars($m['matid']);
                                                            $matno = htmlspecialchars($m['matno']);
                                                            echo '<li class="dropdown-item FG-filter-item" data-matid="'.$matid.'">
                                                                    <div class="form-check custom-checkbox">
                                                                        <input type="checkbox" class="form-check-input fg-checkbox" id="check_'.$matid.'" value="'.$matid.'">
                                                                        <label class="form-check-label" for="check_'.$matid.'">'.$matno.'</label>
                                                                    </div>
                                                                </li>';
                                                        }
                                                    }
                                                ?>
                                            </div>
                                        </div>
                                    </ul> 
                                </div>
                            </div>                       
                        </div>                        
                        <div class="card-body custome-tooltip p-0">
                            
                            <div id="overiewChartMonth" class="mt-4"></div>

                            <div class="ttl-project mt-4">
                                <div class="pr-data px-4">
                                    <h5 id="ov-total-year"><?= number_format($totalInspectedYear) ?></h5>
                                    <span>Total Inspected</span>
                                </div>
                                <div class="pr-data px-4">
                                    <h5 id="ov-ok-year" class="text-primary"><?= number_format($totalOKYear) ?></h5>
                                    <span>Total OK</span>
                                </div>
                                <div class="pr-data px-4">
                                    <h5 id="ov-ng-year" class="text-meron"><?= number_format($totalNGYear) ?></h5>
                                    <span>Total NG</span>
                                </div>
                                <div class="pr-data px-4">
                                    <h5 id="ov-yield-year" class="text-jingga"><?= $yieldYear ?>%</h5>
                                    <span>Yield Rate</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end Result by month -->

                <!-- By Model -->
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                
                                <div>
                                    <h4 class="heading mb-3">Model Overview</h4>
                                    <p class="mb-0 subtitle">
                                        <ul class="nav nav-pills stacked-mix-tab" id="stacked-pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-series="day" id="stacked-pills-day-tab" data-bs-toggle="pill" data-bs-target="#stacked-pills-day" type="button" role="tab"  aria-selected="true">Day</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="week" id="stacked-pills-week-tab" data-bs-toggle="pill" data-bs-target="#stacked-pills-week" type="button" role="tab"  aria-selected="true">Week</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="month" id="stacked-pills-month-tab" data-bs-toggle="pill" data-bs-target="#stacked-pills-month" type="button" role="tab"  aria-selected="false">Month</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="year" id="stacked-pills-year-tab" data-bs-toggle="pill" data-bs-target="#stacked-pills-year" type="button" role="tab"  aria-selected="false">Year</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="all" id="stacked-pills-all-tab" data-bs-toggle="pill" data-bs-target="#stacked-pills-all" type="button" role="tab" aria-selected="false">All</button>
                                            </li>
                                        </ul>
                                    </p>
                                </div>
                                
                                <ul class="nav nav-tabs dzm-tabs" id="myTab-OKNG" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" data-result="OK" id="tab-OK" data-bs-toggle="tab" data-bs-target="#CheckboxOK" type="button" role="tab"  aria-selected="true">OK</button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" data-result="NG" id="tab-NG" data-bs-toggle="tab" data-bs-target="#CheckboxNG" type="button" role="tab"  aria-selected="false">NG</button>
                                    </li>
                                </ul>
                                
                            </div>
                            <div class="card-body custome-tooltip p-0">
                                
                                <div id="stacked_model_defect_chart"></div>

                                <div class="ttl-project mt-4">
                                    <div class="pr-data">
                                        <h5 id="ov-total"><?= number_format($countInspections) ?></h5>
                                        <span>Total Inspected</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 id="ov-ok" class="text-primary fw-semibold"><?= number_format($countOK) ?></h5>
                                        <span>OK</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 id="ov-ng" class="text-meron fw-semibold "><?= number_format($countNG) ?></h5>
                                        <span>NG</span>
                                    </div>
                                    <div class="pr-data">
                                        <h5 id="ov-yield" class="text-jingga fw-semibold"><?= $yield ?>%</h5>
                                        <span>Yield Rate</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end By Model -->

                <!-- Result by type -->
                <div class="row">
                    <div class="col-xl-12 col-xxl-12">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                <div>
                                    <h4 class="heading mb-3">Type of Defect Overview</h4>
                                    <p class="mb-0 subtitle">
                                        <ul class="nav nav-pills type-mix-tab" id="type-pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-series="day" id="type-pills-day-tab" data-bs-toggle="pill" data-bs-target="#type-pills-day" type="button" role="tab"  aria-selected="true">Day</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="week" id="type-pills-week-tab" data-bs-toggle="pill" data-bs-target="#type-pills-week" type="button" role="tab"  aria-selected="true">Week</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="month" id="type-pills-month-tab" data-bs-toggle="pill" data-bs-target="#type-pills-month" type="button" role="tab"  aria-selected="false">Month</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="year" id="type-pills-year-tab" data-bs-toggle="pill" data-bs-target="#type-pills-year" type="button" role="tab"  aria-selected="false">Year</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="all" id="type-pills-all-tab" data-bs-toggle="pill" data-bs-target="#type-pills-all" type="button" role="tab" aria-selected="false">All</button>
                                            </li>
                                        </ul>
                                    </p>
                                </div>
                                <div class="dropdown">
                                    <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <circle fill="#1b1a1aff" cx="5" cy="12" r="2"/>
                                                <circle fill="#1b1a1aff" cx="12" cy="12" r="2"/>
                                                <circle fill="#1b1a1aff" cx="19" cy="12" r="2"/>
                                            </g>
                                        </svg>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end type-filter-menu">
                                        <div class="type-filter-grid">
                                            <li class="dropdown-item type-filter-dropdown-item type-filter-item-all" data-typeid="all">
                                                <div class="form-check custom-checkbox">
                                                    <input type="checkbox" class="form-check-input" id="check_all_type">
                                                    <label class="form-check-label" for="check_all_type">Show All</label>
                                                </div>
                                            </li>
                                            <?php
                                                $queryModelTypes = "SELECT typeid, typemodel FROM model_type ORDER BY typemodel ASC";
                                                $resModelTypes = mysqli_query($db_con, $queryModelTypes);
                                                if($resModelTypes) {
                                                    while($mt = mysqli_fetch_assoc($resModelTypes)) {
                                                        $typeid = $mt['typeid'];
                                                        $typename = htmlspecialchars($mt['typemodel']);
                                                        echo '<li class="dropdown-item type-filter-dropdown-item" data-typeid="'.$typeid.'">
                                                                <div class="form-check custom-checkbox">
                                                                    <input type="checkbox" class="form-check-input type-checkbox" id="type_check_'.$typeid.'" value="'.$typeid.'">
                                                                    <label class="form-check-label" for="type_check_'.$typeid.'">'.$typename.'</label>
                                                                </div>
                                                              </li>';
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </ul>
                                </div>
                            </div>
                            <div class="card-body custome-tooltip p-0">                                
                                <div id="overiewChartType"></div>
                            </div>
                        </div>
                    </div>                    
                </div>                
                <!-- end Result by type -->

            </div>
        </div>

        <div class="footer">
            <?php include 'nav-footer.php' ;?>
        </div>

    </div>

    <!-- Scripts -->
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/chart-js/chart.bundle.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="vendor/apexchart/apexchart.js"></script>
	
	<!-- Dashboard 1 -->
	<script src="js/dashboard/dashboard-1.js"></script>
	<script src="vendor/draggable/draggable.js"></script>
	<script src="vendor/swiper/js/swiper-bundle.min.js"></script>
	
	<script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
	<script src="vendor/datatables/js/dataTables.buttons.min.js"></script>
	<script src="vendor/datatables/js/buttons.html5.min.js"></script>
	<script src="vendor/datatables/js/jszip.min.js"></script>
	<script src="js/plugins-init/datatables.init.js"></script>
   
	<!-- Apex Chart -->	
	<script src="vendor/bootstrap-datetimepicker/js/moment.js"></script>
	<script src="vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
	

    <script src="vendor/raphael/raphael.min.js"></script>
    <script src="vendor/morris/morris.min.js"></script>
    <script src="js/plugins-init/morris-init.js"></script>
	<!-- Vectormap -->
    <script src="vendor/jqvmap/js/jquery.vmap.min.js"></script>
    <script src="vendor/jqvmap/js/jquery.vmap.world.js"></script>
    <script src="vendor/jqvmap/js/jquery.vmap.usa.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>
	
    <script>
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(el => new bootstrap.Tooltip(el));

        // FG & Type Filter multi-select logic (prevent closing)
        $(document).on('click', '.fg-filter-menu, .type-filter-menu', function(e) {
            e.stopPropagation();
        });

        $(document).on('click', '.FG-filter-item', function(e) {
            var $checkbox = $(this).find('input[type="checkbox"]');
            if (!$(e.target).is('input[type="checkbox"]')) {
                $checkbox.prop('checked', !$checkbox.prop('checked'));
            }
            
            if ($(this).hasClass('fg-filter-item-all')) {
                $('.fg-checkbox').prop('checked', $checkbox.prop('checked'));
            } else {
                var allChecked = $('.fg-checkbox:checked').length === $('.fg-checkbox').length;
                $('#check_all_fg').prop('checked', allChecked);
            }
            fetchTrendData();
        });

        $(document).on('click', '.type-filter-dropdown-item', function(e) {
            var $checkbox = $(this).find('input[type="checkbox"]');
            if (!$(e.target).is('input[type="checkbox"]')) {
                $checkbox.prop('checked', !$checkbox.prop('checked'));
            }
            
            if ($(this).hasClass('type-filter-item-all')) {
                $('.type-checkbox').prop('checked', $checkbox.prop('checked'));
            } else {
                var allChecked = $('.type-checkbox:checked').length === $('.type-checkbox').length;
                $('#check_all_type').prop('checked', allChecked);
            }
            fetchTypeDefectData();
        });
    </script>
    
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
    var trendChart, typeChart, chartStacked;
    var globalShiftDate = '<?php echo $shift_date; ?>';
    var globalShift = '<?php echo $shift; ?>';
    jQuery(window).on('load', function() {
        // Custom Monthly Inspection Result Chart
        var options = {
            series: [{
                name: 'OK',
                data: <?php echo json_encode($trendOK); ?>
            }, {
                name: 'NG',
                data: <?php echo json_encode($trendNG); ?>
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 8
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($trendMonths); ?>,
                labels: {
                    style: {
                        colors: '#787878',
                        fontSize: '13px',
                        fontWeight: 400
                    },
                },
                axisBorder: {
                    show: false,
                },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#787878',
                        fontSize: '13px',
                        fontWeight: 400
                    },
                },
            },
            fill: {
                opacity: 1,
                colors: ['#11470F', '#842f1aff']
            },
            colors: ['#11470F', '#842f1aff'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " records"
                    }
                }
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'right',
                offsetY: 10 
            }
        };

        const chartElement = document.querySelector("#overiewChartMonth");
        if (chartElement) {
            chartElement.innerHTML = "";
            trendChart = new ApexCharts(chartElement, options);
            trendChart.render();
        }

        // Defect (Type) Overview Bar Chart
        var typeOptions = {
            series: [{
                name: 'Defects',
                data: <?php echo json_encode($typeDefectCounts); ?>
            }],
            chart: {
                type: 'bar',
                height: 350,
                toolbar: {
                    show: false,
                },
            },
            plotOptions: {
                bar: {
                    horizontal: true,
                    barHeight: '90%',
                    distributed: false,
                    borderRadius: 4
                },
            },
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '12px',
                    colors: ['#fff']
                },
                formatter: function (val) {
                    return val;
                },
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: <?php echo json_encode($typeDefectLabels); ?>,
                labels: {
                    style: {
                        colors: '#787878',
                        fontSize: '12px',
                        fontWeight: 400
                    },
                },
            },
            yaxis: {
                labels: {
                    style: {
                        colors: '#787878',
                        fontSize: '13px',
                        fontWeight: 400
                    },
                },
            },
            fill: {
                opacity: 1,
                colors: ['#155C12']
            },
            colors: ['#537B2F'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " defects"
                    }
                }
            },
            grid: {
                padding: {
                    bottom: 1
                }
            }
        };

        const typeChartElement = document.querySelector("#overiewChartType");
        if (typeChartElement) {
            typeChartElement.innerHTML = "";
            typeChart = new ApexCharts(typeChartElement, typeOptions);
            typeChart.render();
        }

        // Render Stacked Chart
        stackedModelDefectChart();
    });

    function stackedModelDefectChart() {
        var options = {
            series: <?php echo json_encode($stackedSeries); ?>,
            chart: {
                type: 'bar',
                height: 450,
                stacked: true,
                toolbar: { show: false }
            },
            plotOptions: {
                bar: {
                    horizontal: true, /* Y-axis displays Models */
                    borderRadius: 6,
                    barHeight: '60%'
                },
            },
            /* Use a professional green-themed palette based on #085209 */
            // colors: ['#085209', '#2E7D32', '#66BB6A', '#A5D6A7'],
            colors: ['#11470F', '#739C38', '#b6b00aff', '#51462fff', '#826E44', '#e1a91dff', '#879e83'], 
            xaxis: {
                categories: <?php echo json_encode($stackedCategories); ?>,
                // title: { text: 'Total' }
            },
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                top: 30
            },
            fill: { opacity: 1 },
            tooltip: { theme: 'light' }
        };

        chartStacked = new ApexCharts(document.querySelector("#stacked_model_defect_chart"), options);
        chartStacked.render();

        // AJAX for filtering (Timeframe + Result)
        function fetchStackedData(type, result) {
            $.ajax({
                url: 'fetch-stacked-defect.php',
                type: 'POST',
                data: { 
                    type: type,
                    result: result,
                    shift: globalShift,
                    shift_date: globalShiftDate
                },
                success: function(res) {
                    chartStacked.updateOptions({
                        xaxis: {
                            categories: res.categories
                        }
                    });
                    chartStacked.updateSeries(res.series);

                    // Update counters
                    $('#ov-total').text(res.stats.total);
                    $('#ov-ok').text(res.stats.ok);
                    $('#ov-ng').text(res.stats.ng);
                    $('#ov-yield').text(res.stats.yield);
                }
            });
        }

        // Hook to stacked-mix-tab click (Timeframe)
        $(".stacked-mix-tab .nav-link").on('click', function() {
            var type = $(this).attr('data-series');
            var result = $("#myTab-OKNG .nav-link.active").attr('data-result');
            fetchStackedData(type, result);
        });

        // Hook to OK/NG tabs click (Result)
        $("#myTab-OKNG .nav-link").on('click', function() {
            var type = $(".stacked-mix-tab .nav-link.active").attr('data-series');
            var result = $(this).attr('data-result');
            fetchStackedData(type, result);
        });
    }

    // Handle shift tab clicks
    $(document).on('click', '#shiftTabs .nav-link', function() {
        var shift = $(this).data('shift');
        globalShift = shift;

        $("#shiftTabs .nav-link").removeClass('active');
        $(this).addClass('active');

        // Reload all data
        fetchTrendData();
        fetchTypeDefectData();
        // For stacked chart, we use the active timeframe and result tabs
        var stackedType = $(".stacked-mix-tab .nav-link.active").attr('data-series') || 'day';
        var stackedResult = $("#myTab-OKNG .nav-link.active").attr('data-result') || 'OK';
        
        // We need to call fetchStackedData which is inside stackedModelDefectChart or make it global
        // In current code it is local. I'll move it or just call the event triggers
        $(".stacked-mix-tab .nav-link.active").trigger('click');
    });

    function fetchTrendData() {
        var selectedMats = [];
        if ($('#check_all_fg').is(':checked')) {
            selectedMats = ['all'];
        } else {
            $('.fg-checkbox:checked').each(function() {
                selectedMats.push($(this).val());
            });
        }

        $.ajax({
            url: 'fetch-dashboard-ip2-trend.php',
            type: 'POST',
            data: { 
                matids: selectedMats,
                shift: globalShift
            },
            dataType: 'json',
            success: function(data) {
                if (trendChart) {
                    trendChart.updateSeries([
                        { name: 'OK', data: data.trendOK },
                        { name: 'NG', data: data.trendNG }
                    ]);
                }
                $('#ov-total-year').text(data.metrics.total);
                $('#ov-ok-year').text(data.metrics.ok);
                $('#ov-ng-year').text(data.metrics.ng);
                $('#ov-yield-year').text(data.metrics.yield);
            }
        });
    }

    function fetchTypeDefectData() {
        var selectedTypes = [];
        if ($('#check_all_type').is(':checked')) {
            selectedTypes = ['all'];
        } else {
            $('.type-checkbox:checked').each(function() {
                selectedTypes.push($(this).val());
            });
        }

        // Get active timeframe from type-mix-tab
        var timeframe = $('.type-mix-tab .nav-link.active').data('series') || 'day';

        $.ajax({
            url: 'fetch-dashboard-ip2-type-defects.php',
            type: 'POST',
            data: { 
                typeids: selectedTypes,
                timeframe: timeframe,
                shift: globalShift
            },
            dataType: 'json',
            success: function(data) {
                if (typeChart) {
                    typeChart.updateOptions({
                        xaxis: {
                            categories: data.labels
                        }
                    });
                    typeChart.updateSeries([{
                        name: 'Defects',
                        data: data.counts
                    }]);
                }
            }
        });
    }

    // Handle timeframe tab clicks
    $(document).on('click', '.type-mix-tab .nav-link', function() {
        fetchTypeDefectData();
    });

    $(document).on('change', '.fg-filter-menu input[type="checkbox"], .type-filter-menu input[type="checkbox"]', function() {
        if ($(this).closest('.fg-filter-menu').length) fetchTrendData();
        if ($(this).closest('.type-filter-menu').length) fetchTypeDefectData();
    });
    </script>

</body>
</html>
