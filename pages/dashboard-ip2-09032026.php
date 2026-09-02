<!-- System title -->
<?php include "../system-header.php";?>

<!-- Session start -->
<?php include "session-start.php"; ?> 

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

                <?php
                // Fetch Inspection Result Overview Trend (Monthly OK vs NG)
                // Using the year from the current $shift_date context
                $currentYearTrend = date('Y', strtotime($shift_date));
                $queryOverviewTrend = "SELECT 
                                            MONTH(shift_date) as m_num,
                                            DATE_FORMAT(shift_date, '%b') as m_name,
                                            SUM(CASE WHEN ir_result = 'OK' THEN 1 ELSE 0 END) as ok_count,
                                            SUM(CASE WHEN ir_result = 'NG' THEN 1 ELSE 0 END) as ng_count
                                        FROM inspection_records 
                                        WHERE YEAR(shift_date) = '$currentYearTrend' AND ir_result IS NOT NULL
                                        GROUP BY m_num
                                        ORDER BY m_num";
                $resOverviewTrend = mysqli_query($db_con, $queryOverviewTrend);

                $trendMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $trendOK = array_fill(0, 12, 0);
                $trendNG = array_fill(0, 12, 0);

                if ($resOverviewTrend) {
                    while($row = mysqli_fetch_assoc($resOverviewTrend)) {
                        $mIndex = (int)$row['m_num'] - 1;
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
                // Initially showing "All" for the current year
                $queryTypeDefects = "SELECT 
                                        T.defectname, 
                                        COUNT(D.defect_id) as total
                                      FROM inspection_records S 
                                      INNER JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id 
                                      INNER JOIN defect_type T ON T.defectid = D.defect_type 
                                      WHERE YEAR(S.shift_date) = '$currentYearTrend' AND S.ir_result = 'NG'
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

                <div class="row">

                    <!-- Result by type -->
                    <div class="col-xl-8">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0 pb-0 flex-wrap">
                                <div>
                                    <h4 class="heading mb-3">Type Overview</h4>
                                    <p class="mb-0 subtitle">
                                        <ul class="nav nav-pills mix-chart-tab" id="pills-tab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" data-series="day" id="pills-day-tab" data-bs-toggle="pill" data-bs-target="#pills-day" type="button" role="tab"  aria-selected="true">Day</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="week" id="pills-week-tab" data-bs-toggle="pill" data-bs-target="#pills-week" type="button" role="tab"  aria-selected="true">Week</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="month" id="pills-month-tab" data-bs-toggle="pill" data-bs-target="#pills-month" type="button" role="tab"  aria-selected="false">Month</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="year" id="pills-year-tab" data-bs-toggle="pill" data-bs-target="#pills-year" type="button" role="tab"  aria-selected="false">Year</button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" data-series="all" id="pills-all-tab" data-bs-toggle="pill" data-bs-target="#pills-all" type="button" role="tab" aria-selected="false">All</button>
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
                    <!-- end Result by type -->

                    <!-- <div class="col-xl-4">
                        <div class="card overflow-hidden">
                            <div class="card-header border-0 flex-wrap">
                                <h4 class="heading mb-0">My To Do Items</h4>
                                <div>
                                    <a href="javascript:void(0);" class="text-primary me-2">View All</a>
                                    <a href="javascript:void(0);" class="text-black"> + Add To Do</a>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="dt-do-bx">
                                    <div class="draggable-zone dropzoneContainer to-dodroup dz-scroll">
                                        <div class="sub-card draggable-handle draggable">
                                            <div class="d-items">
                                                <span class="text-warning dang d-block mb-2">
                                                    <svg class="me-1" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M3.61051 15.3276H14.3978C15.5843 15.3276 16.329 14.0451 15.7395 13.0146L10.35 3.59085C9.75676 2.5536 8.26126 2.55285 7.66726 3.5901L2.26876 13.0139C1.67926 14.0444 2.42326 15.3276 3.61051 15.3276Z" stroke="#FF9F00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M9.00189 10.0611V7.7361" stroke="#FF9F00" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8.99625 12.375H9.00375" stroke="#FF9F00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    Latest to do's
                                                </span>
                                                <div class="d-flex justify-content-between flex-wrap">
                                                    <div class="d-items-2">
                                                        <div class="svg-icon">
                                                            <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="1" height="1" fill="#888888"/>
                                                                <rect y="3" width="1" height="1" fill="#888888"/>
                                                                <rect y="6" width="1" height="1" fill="#888888"/>
                                                                <rect y="9" width="1" height="1" fill="#888888"/>
                                                                <rect y="12" width="1" height="1" fill="#888888"/>
                                                                <rect y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="15" width="1" height="1" fill="#888888"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="form-check custom-checkbox">
                                                                <input type="checkbox" class="form-check-input" id="customCheckBox1" required>
                                                                <label class="form-check-label" for="customCheckBox1">Compete this projects</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="icon-box icon-box-sm bg-danger-light me-1">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M13.8055 4.1598H2.50012" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </div>
                                                        <div class="icon-box icon-box-sm bg-primary-light">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.16492 13.6286H14" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M7.34723 4.00059L10.9821 6.79201" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>

                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                        <div class="sub-card draggable-handle draggable">
                                            <div class="d-items">
                                                <span class="text-success dang d-block mb-2">
                                                    <svg class="me-1" width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M15 4.5L6.75 12.75L3 9" stroke="#3AC977" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                    Latest finished to do's
                                                </span>
                                                <div class="d-flex justify-content-between flex-wrap">
                                                    <div class="d-items-2">
                                                        <div class="svg-icon">
                                                            <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="1" height="1" fill="#888888"/>
                                                                <rect y="3" width="1" height="1" fill="#888888"/>
                                                                <rect y="6" width="1" height="1" fill="#888888"/>
                                                                <rect y="9" width="1" height="1" fill="#888888"/>
                                                                <rect y="12" width="1" height="1" fill="#888888"/>
                                                                <rect y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="15" width="1" height="1" fill="#888888"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="form-check custom-checkbox">
                                                                <input type="checkbox" class="form-check-input" id="customCheckBox2" required>
                                                                <label class="form-check-label" for="customCheckBox2">Compete this projects</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="icon-box icon-box-sm bg-danger-light me-1">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M13.8055 4.1598H2.50012" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </div>
                                                        <div class="icon-box icon-box-sm bg-primary-light">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.16492 13.6286H14" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M7.34723 4.00059L10.9821 6.79201" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>

                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                        <div class="sub-card draggable-handle draggable">
                                            <div class="d-items">
                                                <div class="d-flex justify-content-between flex-wrap">
                                                    <div class="d-items-2">
                                                        <div class="svg-icon">
                                                            <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="1" height="1" fill="#888888"/>
                                                                <rect y="3" width="1" height="1" fill="#888888"/>
                                                                <rect y="6" width="1" height="1" fill="#888888"/>
                                                                <rect y="9" width="1" height="1" fill="#888888"/>
                                                                <rect y="12" width="1" height="1" fill="#888888"/>
                                                                <rect y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="15" width="1" height="1" fill="#888888"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="form-check custom-checkbox">
                                                                <input type="checkbox" class="form-check-input" id="customCheckBox3" required>
                                                                <label class="form-check-label" for="customCheckBox3">Compete this projects</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="icon-box icon-box-sm bg-danger-light me-1">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M13.8055 4.1598H2.50012" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </div>
                                                        <div class="icon-box icon-box-sm bg-primary-light">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.16492 13.6286H14" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M7.34723 4.00059L10.9821 6.79201" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>

                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                        <div class="sub-card draggable-handle draggable">
                                            <div class="d-items">
                                                <div class="d-flex justify-content-between flex-wrap">
                                                    <div class="d-items-2">
                                                        <div class="svg-icon">
                                                            <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="1" height="1" fill="#888888"/>
                                                                <rect y="3" width="1" height="1" fill="#888888"/>
                                                                <rect y="6" width="1" height="1" fill="#888888"/>
                                                                <rect y="9" width="1" height="1" fill="#888888"/>
                                                                <rect y="12" width="1" height="1" fill="#888888"/>
                                                                <rect y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="15" width="1" height="1" fill="#888888"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="form-check custom-checkbox">
                                                                <input type="checkbox" class="form-check-input" id="customCheckBox4" required>
                                                                <label class="form-check-label" for="customCheckBox4">Compete this projects Monday</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="icon-box icon-box-sm bg-danger-light me-1">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M13.8055 4.1598H2.50012" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </div>
                                                        <div class="icon-box icon-box-sm bg-primary-light">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.16492 13.6286H14" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M7.34723 4.00059L10.9821 6.79201" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>

                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                        <div class="sub-card draggable-handle draggable">
                                            <div class="d-items">
                                                <div class="d-flex justify-content-between flex-wrap">
                                                    <div class="d-items-2">
                                                        <div class="svg-icon">
                                                            <svg width="9" height="16" viewBox="0 0 9 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <rect width="1" height="1" fill="#888888"/>
                                                                <rect y="3" width="1" height="1" fill="#888888"/>
                                                                <rect y="6" width="1" height="1" fill="#888888"/>
                                                                <rect y="9" width="1" height="1" fill="#888888"/>
                                                                <rect y="12" width="1" height="1" fill="#888888"/>
                                                                <rect y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="4" y="15" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="3" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="6" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="9" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="12" width="1" height="1" fill="#888888"/>
                                                                <rect x="8" y="15" width="1" height="1" fill="#888888"/>
                                                            </svg>
                                                        </div>
                                                        <div>
                                                            <div class="form-check custom-checkbox">
                                                                <input type="checkbox" class="form-check-input" id="customCheckBox5" required>
                                                                <label class="form-check-label" for="customCheckBox5">Compete this projects Monday</label>
                                                            </div>
                                                            <span>2023-12-26 07:15:00</span>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="icon-box icon-box-sm bg-danger-light me-1">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M12.8833 6.31213C12.8833 6.31213 12.5213 10.8021 12.3113 12.6935C12.2113 13.5968 11.6533 14.1261 10.7393 14.1428C8.99994 14.1741 7.25861 14.1761 5.51994 14.1395C4.64061 14.1215 4.09194 13.5855 3.99394 12.6981C3.78261 10.7901 3.42261 6.31213 3.42261 6.31213" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M13.8055 4.1598H2.50012" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M11.6271 4.1598C11.1037 4.1598 10.6531 3.7898 10.5504 3.27713L10.3884 2.46647C10.2884 2.09247 9.94974 1.8338 9.56374 1.8338H6.74174C6.35574 1.8338 6.01707 2.09247 5.91707 2.46647L5.75507 3.27713C5.65241 3.7898 5.20174 4.1598 4.67841 4.1598" stroke="#FF5E5E" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </div>
                                                        <div class="icon-box icon-box-sm bg-primary-light">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M9.16492 13.6286H14" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.52001 2.52986C9.0371 1.91186 9.96666 1.82124 10.5975 2.32782C10.6324 2.35531 11.753 3.22586 11.753 3.22586C12.446 3.64479 12.6613 4.5354 12.2329 5.21506C12.2102 5.25146 5.87463 13.1763 5.87463 13.1763C5.66385 13.4393 5.34389 13.5945 5.00194 13.5982L2.57569 13.6287L2.02902 11.3149C1.95244 10.9895 2.02902 10.6478 2.2398 10.3849L8.52001 2.52986Z" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                                <path d="M7.34723 4.00059L10.9821 6.79201" stroke="#0D99FF" stroke-linecap="round" stroke-linejoin="round"/>
                                                            </svg>
                                                        </div>
                                                    </div>
                                                </div>	
                                            </div>
                                        </div>
                                    </div>
                                </div>	
                            </div>
                        </div>
                    </div> -->
                </div>

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
    var trendChart, typeChart;
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
                colors: ['#142C14', '#537B2F']
            },
            colors: ['#142C14', '#537B2F'],
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
                colors: ['#537B2F']
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
            data: { matids: selectedMats },
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

        // Get active timeframe from mix-chart-tab
        var timeframe = $('.mix-chart-tab .nav-link.active').data('series') || 'day';

        $.ajax({
            url: 'fetch-dashboard-ip2-type-defects.php',
            type: 'POST',
            data: { 
                typeids: selectedTypes,
                timeframe: timeframe
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
    $(document).on('click', '.mix-chart-tab .nav-link', function() {
        fetchTypeDefectData();
    });

    $(document).on('change', '.fg-filter-menu input[type="checkbox"], .type-filter-menu input[type="checkbox"]', function() {
        if ($(this).closest('.fg-filter-menu').length) fetchTrendData();
        if ($(this).closest('.type-filter-menu').length) fetchTypeDefectData();
    });
    </script>

</body>
</html>
