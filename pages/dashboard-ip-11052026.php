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

        /* Styling to match your green theme dashboard */
        .defect-scroll-container::-webkit-scrollbar { width: 6px; }
        .defect-scroll-container::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        .defect-scroll-container::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3); border-radius: 10px; }
    
        /* Custom Scrollbar for a clean Dashboard look */
        .defect-scroll-container::-webkit-scrollbar { width: 6px; }
        .defect-scroll-container::-webkit-scrollbar-track { background: rgba(255, 255, 255, 0.1); border-radius: 10px; }
        .defect-scroll-container::-webkit-scrollbar-thumb { background: rgba(255, 255, 255, 0.3); border-radius: 10px; }

        /* Custom Scrollbar for better UI */
        .defect-scroll-container::-webkit-scrollbar {
            width: 6px;
        }
        .defect-scroll-container::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        .defect-scroll-container::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        /* Model Filter Dropdown Styles */
        .model-filter-menu {
            min-width: 220px !important;
            padding: 10px !important;
        }
        .model-filter-item-all {
            border-bottom: 1px solid #eee;
            margin-bottom: 5px;
            padding-bottom: 5px;
        }
        .model-filter-dropdown-item {
            padding: 5px 12px !important;
            border-radius: 4px;
            cursor: pointer;
        }
        .model-filter-dropdown-item:hover {
            background: #f8f9fa;
        }
        .model-filter-dropdown-item .form-check {
            margin-bottom: 0;
            display: flex;
            align-items: center;
        }
        .model-filter-dropdown-item .form-check-input {
            margin-top: 0;
            cursor: pointer;
        }
        .model-filter-dropdown-item .form-check-label {
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

                <style>

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

                <div class="card-header py-3 d-block d-sm-flex">
                    <ul class="nav nav-pills mt-3 mt-sm-0 custom-toolbar mb-2 ms-auto" id="myTab" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="today-tab"
                                data-bs-toggle="tab" data-bs-target="#tabToday"
                                type="button" role="tab">

                                <i class="bi bi-calendar-day"></i>
                                <span>Today</span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" type="button"
                                onclick="window.location.href='dashboard-ip-past.php'">

                                <i class="bi bi-clock-history"></i>
                                <span>Past</span>
                            </button>
                        </li>

                    </ul>
                </div>

                <!-- Shift Tabs -->
                <!-- <ul class="nav nav-tabs style-2 mb-4" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a href="" class="nav-link <?= ($shiftshort=='D') ? 'active' : '' ?>" data-bs-toggle="tab" data-bs-target="#tabDay">Day</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link border-s-1 <?= ($shiftshort=='N') ? 'active' : '' ?>"  data-bs-toggle="tab" data-bs-target="#tabNight">Night</a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link border-s-1"  data-bs-toggle="tab" data-bs-target="#tabAll">All</a>
                    </li>
                </ul> -->
                
                <ul class="nav nav-tabs style-2 mb-4" id="shiftTabs" role="tablist">
                    <li class="nav-item"><button class="nav-link <?= ($shiftshort=='D') ? 'active' : '' ?>" data-shift="D" type="button">Day</button></li>
                    <li class="nav-item"><button class="nav-link <?= ($shiftshort=='N') ? 'active' : '' ?>" data-shift="N" type="button">Night</button></li>
                    <li class="nav-item"><button class="nav-link" data-shift="ALL" type="button">All</button></li>
                </ul>
               
                <?php

                    $shift = $shiftshort;
                    $shiftCondition = "";

                    if ($shift == 'D') {
                        $shiftCondition = "AND I.ir_shift = 'D'";
                    }
                    elseif ($shift == 'N') {
                        $shiftCondition = "AND I.ir_shift = 'N'";
                    }

                    // 1. KPI Counts
                    $queryOK = "SELECT COUNT(*) as count FROM inspection_records I
                                    WHERE I.ir_result = 'OK' AND I.shift_date = '$shift_date' $shiftCondition";
                    $resultOK = mysqli_query($db_con, $queryOK);
                    $rowOK = mysqli_fetch_assoc($resultOK);
                    $countOK = (int)($rowOK['count'] ?? 0);

                    $queryNG = "SELECT COUNT(*) as count FROM inspection_records I
                                    WHERE I.ir_result = 'NG' AND I.shift_date = '$shift_date' $shiftCondition";
                    $resultNG = mysqli_query($db_con, $queryNG);
                    $rowNG = mysqli_fetch_assoc($resultNG);
                    $countNG = (int)($rowNG['count'] ?? 0);
                    
                    //the percentage of items that passed inspection ("OK") out of the total number of items inspected
                    $countInspections = $countOK + $countNG;
                    $yield = ($countInspections > 0) ? round(($countOK / $countInspections) * 100, 1) : 0;

                    // 2. Recent Records (Last 5)
                    $queryRecent = "SELECT I.ir_docno, I.ir_result, I.created_date, T.modcode, M.matno
                                    FROM inspection_records I
                                    LEFT JOIN model_details T ON I.ir_model = T.modid
                                    LEFT JOIN material_header M ON I.ir_material = M.matid
                                    WHERE I.shift_date = '$shift_date' 
                                    $shiftCondition
                                    ORDER BY I.ir_id DESC LIMIT 5";
                    $resultRecent = mysqli_query($db_con, $queryRecent);

                    // 3. Top 5 Models
                    $queryModel = "SELECT T.modcode, COUNT(*) as count
                                FROM inspection_records I
                                LEFT JOIN model_details T ON I.ir_model = T.modid
                                WHERE I.shift_date = '$shift_date'
                                $shiftCondition
                                GROUP BY T.modcode
                                ORDER BY count DESC LIMIT 5";
                    $resultModel = mysqli_query($db_con, $queryModel);
                    $modLabels = [];
                    $modCounts = [];
                    while($m = mysqli_fetch_assoc($resultModel)){
                        $modLabels[] = $m['modcode'] ? $m['modcode'] : 'Unknown';
                        $modCounts[] = $m['count'];
                    }
                    ?>

                    <?php
                    
                    // In Progress: 1 or 13
                    $resIP = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records I
                                            WHERE I.ir_result != '' AND I.shift_date = '$shift_date' $shiftCondition AND (I.ir_status = 1 OR I.ir_status = 13)");
                    $countInProgress = (int)(mysqli_fetch_assoc($resIP)['count'] ?? 0);

                    // Pending: 14
                    $resP = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records I
                                            WHERE I.ir_result != '' AND I.shift_date = '$shift_date' $shiftCondition
                                            AND (I.ir_status IN(9) OR I.ir_sorting_status = 9 OR I.ir_s2w_status IN (9,10) 
                                            OR I.ir_s2w_rp_status = 10 OR I.ir_s2w_ack_status  = 14)");
                    $countPending = (int)(mysqli_fetch_assoc($resP)['count'] ?? 0);

                    // Completed: 5
                    $resC = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records I
                                            WHERE I.ir_result != '' AND I.shift_date = '$shift_date' $shiftCondition AND I.ir_status = 5");
                    $countCompleted = (int)(mysqli_fetch_assoc($resC)['count'] ?? 0);

                    // Reject: 16
                    $resR = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records I
                                            WHERE I.ir_result != '' AND I.shift_date = '$shift_date' $shiftCondition AND (I.ir_status = 12 OR I.ir_s2w_ack_status = 16)");
                    $countReject = (int)(mysqli_fetch_assoc($resR)['count'] ?? 0);

                    $shift_dateTotal = $countInProgress + $countPending + $countCompleted + $countReject;

                    //total Inspections
                    $resIP_total = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records I
                                                    WHERE I.ir_result != '' AND I.shift_date = '$shift_date' $shiftCondition");
                    $countInspections = (int)(mysqli_fetch_assoc($resIP_total)['count'] ?? 0);
                    
                    $rateInProgress = ($shift_dateTotal > 0) ? round(($countInProgress / $shift_dateTotal) * 100) : 0;
                    $ratePending    = ($shift_dateTotal > 0) ? round(($countPending / $shift_dateTotal) * 100) : 0;
                    $rateCompleted  = ($shift_dateTotal > 0) ? round(($countCompleted / $shift_dateTotal) * 100) : 0;
                    $rateReject     = ($shift_dateTotal > 0) ? round(($countReject / $shift_dateTotal) * 100) : 0;

                    // 4. Total Defect by Model Type Side               
                    $queryDefectBySide = "SELECT 
                                            mts.typecode, mts.typemodel, mts.typeside,
                                            COUNT(I.ir_id) as total_inspected,
                                            SUM(CASE WHEN I.ir_result = 'NG' THEN 1 ELSE 0 END) as defect_count,
                                            IFNULL(ROUND((SUM(CASE WHEN I.ir_result = 'NG' THEN 1 ELSE 0 END) / NULLIF(COUNT(I.ir_id), 0)) * 100, 1), 0) as defect_rate
                                        FROM model_type_side mts
                                        LEFT JOIN material_header mh ON mts.typeside_id = mh.typeside_id
                                        LEFT JOIN inspection_records I ON mh.matid = I.ir_material AND I.shift_date = '$shift_date' $shiftCondition
                                        GROUP BY mts.typeside_id, mts.typecode";
                    $modelResults = mysqli_query($db_con, $queryDefectBySide);

                    //calculate percentage
                    //defect_count/total_defect *100 (by modeltype)

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
                                            WHERE I.ir_result = 'OK' AND I.shift_date = '$shift_date' $shiftCondition
                                            GROUP BY m_hdr.modelid, m_hdr.typeid";
                    $resDefects = mysqli_query($db_con, $queryDefectByModel);
                    while ($row = mysqli_fetch_assoc($resDefects)) {
                        $mid = $row['modelid'];
                        $tid = $row['typeid'];
                        if (isset($modelIndexMap[$mid]) && isset($typeMatrix[$tid])) {
                            $stackedSeries[$typeMatrix[$tid]]['data'][$modelIndexMap[$mid]] = (int)$row['defect_count'];
                        }
                    }

                    $queryAllDefects = "SELECT 
                                            T.defectname,
                                            COUNT(D.defect_id) as defect_total
                                        FROM inspection_records I 
                                        INNER JOIN inspection_defect D ON D.rcd_ir_id = I.ir_id 
                                        INNER JOIN defect_type T ON T.defectid = D.defect_type 
                                        WHERE I.ir_result = 'NG' 
                                        AND I.shift_date = '$shift_date' $shiftCondition
                                        GROUP BY T.defectid, T.defectname
                                        ORDER BY defect_total DESC";

                    $resAllDefects = mysqli_query($db_con, $queryAllDefects);

                    ?>
                        

                    
                        
                        <div class="row">
                            <div class="col-xxl-12 col-xxl-12">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <div class="row">  
                                            <div class="col-xl-6">
                                                <div class="row">                                            
                                                    <div class="col-xl-6 col-sm-6">
                                                        <div class="card">
                                                            <div class="card-body depostit-card">
                                                                <div class="depostit-card-media d-flex justify-content-between style-1">
                                                                    <div>
                                                                        <h6>Total Inspections</h6>
                                                                        <h3><span id="card-total"><?= $countInspections ?></span></h3>
                                                                    </div>
                                                                    <div class="icon-box bg-secondary">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <g clip-path="url(#clip0_3_566)">
                                                                            <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z" fill="#222B40"/>
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z" fill="#222B40"/>
                                                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z" fill="#222B40"/>
                                                                            </g>
                                                                            <defs>
                                                                                <clipPath id="clip0_3_566">
                                                                                <rect width="24" height="24" fill="white"/>
                                                                                </clipPath>
                                                                            </defs>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <div class="progress-box mt-0">
                                                                    <div class="d-flex justify-content-between">
                                                                        <p class="mb-0">Complete Task</p>
                                                                        <p class="mb-0"> <span id="card-compl-ratio"><?= $countCompleted ?>/<?= $countInspections ?></span></p>
                                                                    </div>
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-primary" style="width:50%; height:5px; border-radius:4px;" role="progressbar"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>	
                                                    </div>
                                                    <div class="col-xl-6 col-sm-6">
                                                        <div class="card same-card">
                                                            <div class="card-body depostit-card">
                                                                <div class="depostit-card-media d-flex justify-content-between style-1">
                                                                    <div>
                                                                        <h6>Defect Found</h6>
                                                                        <h3><span id="card-ng"><?= $countNG ?></span></h3>
                                                                    </div>
                                                                    <div class="icon-box bg-primary">
                                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                            <g clip-path="url(#clip0_3_defect)">
                                                                                <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z" fill="#fff"/>
                                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14.2929 10.2929C14.6834 9.90237 15.3166 9.90237 15.7071 10.2929C16.0976 10.6834 16.0976 11.3166 15.7071 11.7071L13.4142 14L15.7071 16.2929C16.0976 16.6834 16.0976 17.3166 15.7071 17.7071C15.3166 18.0976 14.6834 18.0976 14.2929 17.7071L12 15.4142L9.70711 17.7071C9.31658 18.0976 8.68342 18.0976 8.29289 17.7071C7.90237 17.3166 7.90237 16.6834 8.29289 16.2929L10.5858 14L8.29289 11.7071C7.90237 11.3166 7.90237 10.6834 8.29289 10.2929C8.68342 9.90237 9.31658 9.90237 9.70711 10.2929L12 12.5858L14.2929 10.2929Z" fill="#fff"/>
                                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z" fill="#fff"/>
                                                                            </g>
                                                                            <defs>
                                                                                <clipPath id="clip0_3_defect">
                                                                                    <rect width="24" height="24" fill="white"/>
                                                                                </clipPath>
                                                                            </defs>
                                                                        </svg>
                                                                    </div>
                                                                </div>
                                                                <div class="progress-box mt-0">
                                                                    <div class="d-flex justify-content-between">
                                                                        <p class="mb-0">NG</p>
                                                                        <p class="mb-0"> <span id="card-ng-ratio"><?= $countNG ?>/<?= $countInspections ?></span></p>
                                                                    </div>
                                                                    <div class="progress">
                                                                        <div class="progress-bar bg-primary" style="width:50%; height:5px; border-radius:4px;" role="progressbar"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Status -->
                                                    <div class="col-xl-12 col-lg-12">
                                                        <div class="card">
                                                            <div class="card-header bg-transparent border-0 pt-4" style="height: 100px;">
                                                                <h4 class="card-title" style="font-weight: 700; color: #1a1a1a;">Overall Status Progress</h4>
                                                            </div>
                                                            <div class="card-body">
                                                                <div class="row align-items-center">
                                                                    <div class="col-sm-6 text-center">
                                                                        <div id="inspection_pie_chart"></div>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <ul class="list-unstyled mb-0 ms-lg-3">
                                                                            <li class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <span><i class="fas fa-circle me-2" style="color: #205128;"></i> In Progress</span>
                                                                                <span class="fw-bold text-dark"><span id="rate-ip"><?= $rateInProgress ?></span>%</span>
                                                                            </li>
                                                                            <li class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <span><i class="fas fa-circle me-2" style="color: #86e21cff;"></i> Pending</span>
                                                                                <span class="fw-bold text-dark"><span id="rate-pending"><?= $ratePending ?></span>%</span>
                                                                            </li>
                                                                            <li class="mb-3 d-flex align-items-center justify-content-between">
                                                                                <span><i class="fas fa-circle me-2" style="color: #142C14;"></i> Complete</span>
                                                                                <span class="fw-bold text-dark"><span id="rate-completed"><?= $rateCompleted ?></span>%</span>
                                                                            </li>
                                                                            <li class="mb-0 d-flex align-items-center justify-content-between">
                                                                                <span><i class="fas fa-circle me-2" style="color: #8DA750;"></i> Return</span>
                                                                                <span class="fw-bold text-dark"><span id="rate-return"><?= $rateReject ?></span>%</span>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Status -->
                                                    
                                                </div>	
                                            </div>

                                            <!-- Result -->
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title" style="font-weight: 700; color: #1a1a1a;">Overall Result</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="morris_donughtResult" class="morris_chart_height"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end Result -->

                                            <!-- By Defect -->
                                            <div class="col-xl-3 col-lg-6">
                                                <div class="card" style="background: #085209; border-radius: 15px; color: white; height: 500px;">
                                                    <div class="card-header border-0 pb-0">
                                                        <h4 class="card-title" id="defect-card-title" style="color: white; font-weight: 600;">Defect Type (All)</h4>
                                                        <p class="mb-0">
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/>
                                                                        <circle fill="#f8f4f4ff" cx="5" cy="12" r="2"/>
                                                                        <circle fill="#f8f4f4ff" cx="12" cy="12" r="2"/>
                                                                        <circle fill="#f8f4f4ff" cx="19" cy="12" r="2"/></g>
                                                                    </svg>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end model-filter-menu">
                                                                    <li class="dropdown-item model-filter-dropdown-item model-filter-item-all" data-modelid="all">
                                                                        <div class="form-check custom-checkbox">
                                                                            <input type="checkbox" class="form-check-input" id="check_all_model">
                                                                            <label class="form-check-label" for="check_all_model">Show All</label>
                                                                        </div>
                                                                    </li>
                                                                    <?php
                                                                        $queryModels = "SELECT model_id, model FROM model_hdr WHERE model_status = 'AC' ORDER BY model_id ASC";
                                                                        $resModelsDropdown = mysqli_query($db_con, $queryModels);
                                                                        if($resModelsDropdown) {
                                                                            while($m = mysqli_fetch_assoc($resModelsDropdown)) {
                                                                                $mid = htmlspecialchars($m['model_id']);
                                                                                $mname = htmlspecialchars($m['model']);
                                                                                echo '<li class="dropdown-item model-filter-dropdown-item" data-modelid="'.$mid.'">
                                                                                        <div class="form-check custom-checkbox">
                                                                                            <input type="checkbox" class="form-check-input model-checkbox" id="model_check_'.$mid.'" value="'.$mid.'">
                                                                                            <label class="form-check-label" for="model_check_'.$mid.'">'.$mname.'</label>
                                                                                        </div>
                                                                                    </li>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </ul> 
                                                            </div>
                                                        </p>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="defect-scroll-container" id="defect-model-list" style="height: 350px; overflow-y: auto; padding-right: 10px;">
                                                            
                                                            <?php 
                                                            $maxPcs = 0;
                                                            $data = [];
                                                            while($row = mysqli_fetch_assoc($resAllDefects)) {
                                                                $data[] = $row;
                                                                if($row['defect_total'] > $maxPcs) $maxPcs = $row['defect_total'];
                                                            }

                                                            foreach ($data as $item): 
                                                                $currentPcs = (int)$item['defect_total'];
                                                                // Calculate progress width relative to the highest defect count
                                                                $barWidth = ($maxPcs > 0) ? ($currentPcs / $maxPcs) * 100 : 0;
                                                            ?>
                                                            <div class="mb-4">
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <span style="font-size: 12px; font-weight: 600; text-transform: uppercase;">
                                                                        <?= htmlspecialchars($item['defectname']) ?>
                                                                    </span>
                                                                    <span style="font-weight: 600; color: #abc66cff;"><?= number_format($currentPcs) ?> <!--PCS--></span>
                                                                </div>
                                                                <div class="progress" style="height: 10px; background: rgba(255,255,255,0.2); border-radius: 50px;">
                                                                    <div class="progress-bar" role="progressbar" 
                                                                        style="width: <?= $barWidth ?>%; background: #8da750; border-radius: 50px;">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php endforeach; ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end By Defect -->
                                            
                                            <!-- By Model -->
                                            <div class="col-xl-9 col-lg-9">
                                                <div class="card overflow-hidden">
                                                    <div class="card-header border-0 pb-0 flex-wrap">
                                                        
                                                        <div>
                                                            <h4 class="heading mb-3">Model Overview</h4>
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
                                            <!-- end By Model -->
                                            
                                            <!-- By Model type -->
                                            <div class="col-xl-3 col-lg-3">
                                                <div class="card same-card" style="background: #205128; border-radius: 15px; color: white;">
                                                    <div class="card-header border-0 pb-0">
                                                        <h4 class="card-title" id="part-type-card-title" style="color: white; font-weight: 600;">Part Type (All)</h4>
                                                        <p class="mb-0">
                                                            <div class="dropdown">
                                                                <a href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/>
                                                                        <circle fill="#f8f4f4ff" cx="5" cy="12" r="2"/>
                                                                        <circle fill="#f8f4f4ff" cx="12" cy="12" r="2"/>
                                                                        <circle fill="#f8f4f4ff" cx="19" cy="12" r="2"/></g>
                                                                    </svg>
                                                                </a>
                                                                <ul class="dropdown-menu dropdown-menu-end model-filter-menu">
                                                                    <li class="dropdown-item model-filter-dropdown-item-part model-filter-item-all" data-modelid="all">
                                                                        <div class="form-check custom-checkbox">
                                                                            <input type="checkbox" class="form-check-input" id="check_all_model_part">
                                                                            <label class="form-check-label" for="check_all_model_part">Show All</label>
                                                                        </div>
                                                                    </li>
                                                                    <?php
                                                                        $queryModels = "SELECT model_id, model FROM model_hdr WHERE model_status = 'AC' ORDER BY model_id ASC";
                                                                        $resModelsDropdown = mysqli_query($db_con, $queryModels);
                                                                        if($resModelsDropdown) {
                                                                            while($m = mysqli_fetch_assoc($resModelsDropdown)) {
                                                                                $mid = htmlspecialchars($m['model_id']);
                                                                                $mname = htmlspecialchars($m['model']);
                                                                                echo '<li class="dropdown-item model-filter-dropdown-item-part" data-modelid="'.$mid.'">
                                                                                        <div class="form-check custom-checkbox">
                                                                                            <input type="checkbox" class="form-check-input model-checkbox-part" id="model_part_check_'.$mid.'" value="'.$mid.'">
                                                                                            <label class="form-check-label" for="model_part_check_'.$mid.'">'.$mname.'</label>
                                                                                        </div>
                                                                                    </li>';
                                                                            }
                                                                        }
                                                                    ?>
                                                                </ul> 
                                                            </div>
                                                        </p>
                                                    </div>
                                                    <div class="card-body pt-3" id="part-type-list">
                                                        <?php 
                                                        if ($modelResults && mysqli_num_rows($modelResults) > 0) {
                                                            while ($row = mysqli_fetch_assoc($modelResults)) {
                                                                $rate = $row['defect_rate'] ?? 0;
                                                        ?>
                                                            <div class="mb-4">
                                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                                    <span style="font-weight: 500; font-size: 0.9rem; color : #e4e7e4ff;"><?= htmlspecialchars($row['typemodel']) ?> <?= htmlspecialchars($row['typeside']) ?></span>
                                                                    <span style="font-weight: 700; font-size: 0.9rem; color : #e4e7e4ff;"><?= $rate ?>%</span>
                                                                </div>
                                                                <div class="progress" style="height: 12px; background: #d5d6d5ff; border-radius: 10px;" 
                                                                    data-bs-toggle="tooltip" data-bs-placement="top" 
                                                                    title="NG : <?= $row['defect_count'] ?> / Total : <?= $row['total_inspected'] ?> ">
                                                                    <div class="progress-bar" role="progressbar" 
                                                                        style="width: <?= $rate ?>%; background: #8DA750; border-radius: 10px; transition: width 0.5s;" 
                                                                        aria-valuenow="<?= $rate ?>" aria-valuemin="0" aria-valuemax="100">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php 
                                                            }
                                                        } else {
                                                            echo '<p class="text-white opacity-50">No data available for today</p>';
                                                        }
                                                        ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- end By Model type -->
                                            
                                        </div>
                                    </div>			
                                </div>
                            </div>
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
    (function($) {
        "use strict" 
        
        var globalShiftDate = '<?php echo $shift_date; ?>';
        var globalShift = '<?php echo $shift; ?>';

        var chartStatus = null;
        var chartResult = null;
        var chartStacked = null;

        var dzChartlist = function(){
            
            var inspectionPieChart = function(){
                var options = {
                    series: [<?php echo $countInProgress; ?>, <?php echo $countPending; ?>, <?php echo $countCompleted; ?>, <?php echo $countReject; ?>],
                    chart: {
                        type: 'donut',
                        height: 250
                    },
                    labels: ['In Progress', 'Pending', 'Complete', 'Return'],
                    colors: ['#205128', '#86e21cff', '#142C14', '#8DA750'],
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        show: false
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '75%',
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontSize: '22px',
                                    },
                                    value: {
                                        show: true,
                                        fontSize: '16px',
                                        formatter: function (val) {
                                            return val
                                        }
                                    },
                                    total: {
                                        show: true,
                                        label: 'Total',
                                        color: '#373d3f',
                                        formatter: function (w) {
                                            return w.globals.seriesTotals.reduce((a, b) => {
                                                return a + b
                                            }, 0)
                                        }
                                    }
                                }
                            }
                        }
                    }
                };
                chartStatus = new ApexCharts(document.querySelector("#inspection_pie_chart"), options);
                chartStatus.render();
            }

            //by result
            var donutChartResult = function(){
                chartResult = Morris.Donut({
                    element: 'morris_donughtResult',
                    data: [{
                        label: "OK",
                        value: <?php echo $countOK; ?>
                    }, {
                        label: "NG",
                        value: <?php echo $countNG; ?>
                    }],
                    resize: true,
                    redraw: true,
                    colors: ['#142C14', '#8AA94F']
                });
            }

            var stackedModelDefectChart = function(){
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
                    colors: ['#085209', '#2E7D32', '#66BB6A', '#A5D6A7'], 
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

                // Hook to mix-chart-tab click (Timeframe)
                $(".mix-chart-tab .nav-link").on('click', function() {
                    var type = $(this).attr('data-series');
                    var result = $("#myTab-OKNG .nav-link.active").attr('data-result');
                    fetchStackedData(type, result);
                });

                // Hook to OK/NG tabs click (Result)
                $("#myTab-OKNG .nav-link").on('click', function() {
                    var type = $(".mix-chart-tab .nav-link.active").attr('data-series');
                    var result = $(this).attr('data-result');
                    fetchStackedData(type, result);
                });
            }

            var fetchDefectsByModel = function(modelIds) {
                $.ajax({
                    url: 'fetch-defects-by-model.php',
                    type: 'POST',
                    data: { 
                        model_ids: modelIds,
                        shift: globalShift,
                        shift_date: globalShiftDate
                    },
                    beforeSend: function() {
                        $('#defect-model-list').html('<div class="text-center py-5"><div class="spinner-border text-light" role="status"></div></div>');
                    },
                    success: function(res) {
                        $('#defect-model-list').html(res);
                    }
                });
            }

            // Model Filter multi-select logic (prevent closing)
            $(document).on('click', '.model-filter-menu', function(e) {
                e.stopPropagation();
            });

            $(document).on('click', '.model-filter-dropdown-item', function(e) {
                var $checkbox = $(this).find('input[type="checkbox"]');
                if (!$(e.target).is('input[type="checkbox"]')) {
                    $checkbox.prop('checked', !$checkbox.prop('checked'));
                }
                
                if ($(this).hasClass('model-filter-item-all')) {
                    $('.model-checkbox').prop('checked', $checkbox.prop('checked'));
                } else {
                    var allChecked = $('.model-checkbox:checked').length === $('.model-checkbox').length;
                    $('#check_all_model').prop('checked', allChecked);
                }
                
                var selectedModels = [];
                if ($('#check_all_model').is(':checked')) {
                    selectedModels = ['all'];
                    $('#defect-card-title').text('Defect Type (All)');
                } else {
                    $('.model-checkbox:checked').each(function() {
                        selectedModels.push($(this).val());
                    });
                    
                    if (selectedModels.length === 0) {
                        $('#defect-card-title').text('Defect Type (All)');
                    } else if (selectedModels.length === 1) {
                        var mname = $('.model-checkbox:checked').closest('.model-filter-dropdown-item').find('.form-check-label').text();
                        $('#defect-card-title').text('Defect Type (' + mname + ')');
                    } else {
                        $('#defect-card-title').text('Defect Type (' + selectedModels.length + ' selected)');
                    }
                }
                
                fetchDefectsByModel(selectedModels);
            });

            var fetchPartTypeDetails = function(modelIds) {
                $.ajax({
                    url: 'fetch-part-type-details.php',
                    type: 'POST',
                    data: { 
                        model_ids: modelIds,                        
                        shift: globalShift,
                        shift_date: globalShiftDate
                    },
                    beforeSend: function() {
                        $('#part-type-list').html('<div class="text-center py-5"><div class="spinner-border text-light" role="status"></div></div>');
                    },
                    success: function(res) {
                        $('#part-type-list').html(res);
                        $('[data-bs-toggle="tooltip"]').tooltip();
                    }
                });
            }

            $(document).on('click', '.model-filter-dropdown-item-part', function(e) {
                var $checkbox = $(this).find('input[type="checkbox"]');
                if (!$(e.target).is('input[type="checkbox"]')) {
                    $checkbox.prop('checked', !$checkbox.prop('checked'));
                }
                
                if ($(this).hasClass('model-filter-item-all')) {
                    $('.model-checkbox-part').prop('checked', $checkbox.prop('checked'));
                } else {
                    var allChecked = $('.model-checkbox-part:checked').length === $('.model-checkbox-part').length;
                    $('#check_all_model_part').prop('checked', allChecked);
                }
                
                var selectedModels = [];
                if ($('#check_all_model_part').is(':checked')) {
                    selectedModels = ['all'];
                    $('#part-type-card-title').text('Part Type (All)');
                } else {
                    $('.model-checkbox-part:checked').each(function() {
                        selectedModels.push($(this).val());
                    });
                    
                    if (selectedModels.length === 0) {
                        $('#part-type-card-title').text('Part Type (All)');
                    } else if (selectedModels.length === 1) {
                        var mname = $('.model-checkbox-part:checked').closest('.model-filter-dropdown-item-part').find('.form-check-label').text();
                        $('#part-type-card-title').text('Part Type (' + mname + ')');
                    } else {
                        $('#part-type-card-title').text('Part Type (' + selectedModels.length + ' selected)');
                    }
                }
                
                fetchPartTypeDetails(selectedModels);
            });

            var modelBarChart = function(){
                var options = {
                    series: [{
                        name: 'Inspections',
                        data: <?php echo json_encode($modCounts); ?>
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            borderRadius: 4,
                            horizontal: false,
                            columnWidth: '45%'
                        }
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
                        categories: <?php echo json_encode($modLabels); ?>,
                    },
                    fill: {
                        opacity: 1,
                        colors: ['#6418C3']
                    },
                    colors: ['#6418C3']
                };

                var chart = new ApexCharts(document.querySelector("#model_bar_chart"), options);
                chart.render();
            }

           
            return {
                init:function(){
                    $('[data-bs-toggle="tooltip"]').tooltip();
                },
                load:function(){
                    inspectionPieChart();
                    donutChartResult();
                    modelBarChart();
                    stackedModelDefectChart();
                },
                resize:function(){
                }
            }
        }();

        jQuery(document).ready(function(){
            dzChartlist.init();
            dzChartlist.load();

            // Shift Tab Click logic
            $("#shiftTabs .nav-link").on('click', function() {
                var shift = $(this).data('shift');
                globalShift = shift;

                $("#shiftTabs .nav-link").removeClass('active');
                $(this).addClass('active');

                // Reload all data
                reloadDashboardData();
            });
        });

        function reloadDashboardData() {
            var type = 'day';
            var result = $("#myTab-OKNG .nav-link.active").attr('data-result') || 'OK';

            // 1. Reload Stacked Chart & Stats
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
                    if(chartStacked) {
                        chartStacked.updateOptions({ xaxis: { categories: res.categories } });
                        chartStacked.updateSeries(res.series);
                    }
                    
                    // Update main statistics
                    $('#ov-total').text(res.stats.total);
                    $('#ov-ok').text(res.stats.ok);
                    $('#ov-ng').text(res.stats.ng);
                    $('#ov-yield').text(res.stats.yield);

                    // Update Top Cards
                    $('#card-total').text(res.stats.total);
                    $('#card-ng').text(res.stats.ng);
                    $('#card-compl-ratio').text(res.stats.completed + '/' + res.stats.total);
                    $('#card-ng-ratio').text(res.stats.ng + '/' + res.stats.total);

                    // Update Status Percentages
                    var totalS = parseInt(res.stats.in_progress) + parseInt(res.stats.pending) + parseInt(res.stats.completed) + parseInt(res.stats.return);
                    if(totalS > 0) {
                        $('#rate-ip').text(Math.round((parseInt(res.stats.in_progress) / totalS) * 100));
                        $('#rate-pending').text(Math.round((parseInt(res.stats.pending) / totalS) * 100));
                        $('#rate-completed').text(Math.round((parseInt(res.stats.completed) / totalS) * 100));
                        $('#rate-return').text(Math.round((parseInt(res.stats.return) / totalS) * 100));
                    } else {
                        $('#rate-ip').text(0);
                        $('#rate-pending').text(0);
                        $('#rate-completed').text(0);
                        $('#rate-return').text(0);
                    }

                    // 2. Update Status Donut
                    if(chartStatus) {
                        chartStatus.updateSeries([
                            parseInt(res.stats.in_progress || 0), 
                            parseInt(res.stats.pending || 0), 
                            parseInt(res.stats.completed || 0), 
                            parseInt(res.stats.return || 0)
                        ]);
                    }

                    // 3. Update Result Donut
                    if(chartResult) {
                        chartResult.setData([
                            { label: "OK", value: parseInt(res.stats.ok.replace(/,/g, '')) },
                            { label: "NG", value: parseInt(res.stats.ng.replace(/,/g, '')) }
                        ]);
                    }
                }
            });

            // 4. Reload Defect List (current selected models)
            var selectedModels = [];
            if ($('#check_all_model').is(':checked')) {
                selectedModels = ['all'];
            } else {
                $('.model-checkbox:checked').each(function() {
                    selectedModels.push($(this).val());
                });
            }
            
            $.ajax({
                url: 'fetch-defects-by-model.php',
                type: 'POST',
                data: { 
                    model_ids: selectedModels,
                    shift: globalShift,
                    shift_date: globalShiftDate
                },
                success: function(res) {
                    $('#defect-model-list').html(res);
                }
            });

            // 5. Reload Part Type List (current selected models)
            var selectedModelsPart = [];
            if ($('#check_all_model_part').is(':checked')) {
                selectedModelsPart = ['all'];
            } else {
                $('.model-checkbox-part:checked').each(function() {
                    selectedModelsPart.push($(this).val());
                });
            }

            $.ajax({
                url: 'fetch-part-type-details.php',
                type: 'POST',
                data: { 
                    model_ids: selectedModelsPart,                        
                    shift: globalShift,
                    shift_date: globalShiftDate
                },
                success: function(res) {
                    $('#part-type-list').html(res);
                }
            });
        }

        jQuery(window).on('resize',function(){
            dzChartlist.resize();
        });

    })(jQuery);
    </script>

</body>
</html>
