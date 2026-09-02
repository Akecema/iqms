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
    <link href="vendor/chartist/css/chartist.min.css" rel="stylesheet">
    <link class="main-css" href="css/style.css" rel="stylesheet">
    
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

                <?php
                // 1. KPI Counts
                $queryOK = "SELECT COUNT(*) as count FROM inspection_records WHERE ir_result = 'OK'";
                $resultOK = mysqli_query($db_con, $queryOK);
                $rowOK = mysqli_fetch_assoc($resultOK);
                $countOK = $rowOK['count'];

                $queryNG = "SELECT COUNT(*) as count FROM inspection_records WHERE ir_result = 'NG'";
                $resultNG = mysqli_query($db_con, $queryNG);
                $rowNG = mysqli_fetch_assoc($resultNG);
                $countNG = $rowNG['count'];
                
                $total = $countOK + $countNG;
                $yield = ($total > 0) ? round(($countOK / $total) * 100, 1) : 0;

                // 2. Recent Records (Last 5)
                $queryRecent = "SELECT I.ir_docno, I.ir_result, I.created_date, T.modcode, M.matno
                                FROM inspection_records I
                                LEFT JOIN model_details T ON I.ir_model = T.modid
                                LEFT JOIN material_header M ON I.ir_material = M.matid
                                ORDER BY I.ir_id DESC LIMIT 5";
                $resultRecent = mysqli_query($db_con, $queryRecent);

                // 3. Top 5 Models
                $queryModel = "SELECT T.modcode, COUNT(*) as count
                               FROM inspection_records I
                               LEFT JOIN model_details T ON I.ir_model = T.modid
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
                // Today's Status Counts
                $today = date('Y-m-d');
                
                // In Progress: 1 or 13
                $resIP = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records WHERE shift_date = '$today' AND (ir_status = 1 OR ir_status = 13)");
                $countInProgress = mysqli_fetch_assoc($resIP)['count'];

                // Pending: 14
                $resP = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records WHERE shift_date = '$today' AND ir_s2w_ack_status = 14");
                $countPending = mysqli_fetch_assoc($resP)['count'];

                // Completed: 5
                $resC = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records WHERE shift_date = '$today' AND ir_status = 5");
                $countCompleted = mysqli_fetch_assoc($resC)['count'];

                // Reject: 16
                $resR = mysqli_query($db_con, "SELECT COUNT(*) as count FROM inspection_records WHERE shift_date = '$today' AND ir_s2w_ack_status = 16");
                $countReject = mysqli_fetch_assoc($resR)['count'];

                $todayTotal = $countInProgress + $countPending + $countCompleted + $countReject;
                
                $rateInProgress = ($todayTotal > 0) ? round(($countInProgress / $todayTotal) * 100) : 0;
                $ratePending    = ($todayTotal > 0) ? round(($countPending / $todayTotal) * 100) : 0;
                $rateCompleted  = ($todayTotal > 0) ? round(($countCompleted / $todayTotal) * 100) : 0;
                $rateReject     = ($todayTotal > 0) ? round(($countReject / $todayTotal) * 100) : 0;
                ?>

                <!-- Charts Progress -->
                <div class="row" id="ip_progress">

                    <!-- Donut Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Overall Results</h4>
                            </div>
                            <div class="card-body">
                                <div id="inspection_pie_chart"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-8 col-lg-7">
                        <div class="card">
                            <div class="card-header pb-0">
                                <h4 class="card-title">Current Status Progress</h4>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-sm-3">
                                        <h5 class="mb-0 tx-status">In Progress</h5>
                                        <div id="gauge_inprogress"></div>
                                        <h3 class="mt-1"><?php echo $countInProgress; ?></h3>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5 class="mb-0 tx-status">Pending</h5>
                                        <div id="gauge_pending"></div>
                                        <h3 class="mt-1"><?php echo $countPending; ?></h3>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5 class="mb-0 tx-status">Completed</h5>
                                        <div id="gauge_completed"></div>
                                        <h3 class="mt-1"><?php echo $countCompleted; ?></h3>
                                    </div>
                                    <div class="col-sm-3">
                                        <h5 class="mb-0 tx-status">Rejected</h5>
                                        <div id="gauge_reject"></div>
                                        <h3 class="mt-1"><?php echo $countReject; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KPI Cards -->
                <div class="row">
                     <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-layer-1"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1">Total Inspections</p>
                                        <h3 class="text-white"><?php echo number_format($total); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-success">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-success"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1">OK Records</p>
                                        <h3 class="text-white"><?php echo number_format($countOK); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-danger">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-error"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1">NG Records</p>
                                        <h3 class="text-white"><?php echo number_format($countNG); ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-warning">
                            <div class="card-body p-4">
                                <div class="media">
                                    <span class="me-3">
                                        <i class="flaticon-381-diamond"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1">Yield Rate</p>
                                        <h3 class="text-white"><?php echo $yield; ?>%</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts Section -->
                <div class="row">
                    <!-- Bar Chart -->
                    <div class="col-xl-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Top 5 Inspected Models</h4>
                            </div>
                            <div class="card-body">
                                <div id="model_bar_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity Table -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Recent Inspections</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th><strong>DOC NO.</strong></th>
                                                <th><strong>MODEL</strong></th>
                                                <th><strong>PART NO.</strong></th>
                                                <th><strong>DATE</strong></th>
                                                <th><strong>RESULT</strong></th>
                                                <th><strong>STATUS</strong></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            while($rowRecent = mysqli_fetch_assoc($resultRecent)) { 
                                                $badgeClass = ($rowRecent['ir_result'] == 'OK') ? 'badge-success' : 'badge-danger';
                                            ?>
                                            <tr>
                                                <td><strong><?php echo $rowRecent['ir_docno']; ?></strong></td>
                                                <td><?php echo $rowRecent['modcode']; ?></td>
                                                <td><?php echo $rowRecent['matno']; ?></td>
                                                <td><?php echo date('d M Y', strtotime($rowRecent['created_date'])); ?></td>
                                                <td><span class="badge light <?php echo $badgeClass; ?>"><?php echo $rowRecent['ir_result']; ?></span></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-pencil"></i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                    </div>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/chart-js/chart.bundle.min.js"></script>
    <script src="vendor/apexchart/apexchart.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>

    <script>
    (function($) {
        "use strict" 
        
        var dzChartlist = function(){
            
            var inspectionPieChart = function(){
                var options = {
                    series: [<?php echo $countOK; ?>, <?php echo $countNG; ?>],
                    chart: {
                        type: 'donut',
                        height: 300
                    },
                    labels: ['OK', 'NG'],
                    colors: ['#2BC155', '#FF2E2E'],
                    dataLabels: {
                        enabled: false
                    },
                    legend: {
                        position: 'bottom'
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
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
                var chart = new ApexCharts(document.querySelector("#inspection_pie_chart"), options);
                chart.render();
            }

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

            var renderGauge = function(selector, value, color) {
                var options = {
                    series: [value],
                    chart: {
                        height: 120,
                        type: 'radialBar',
                        sparkline: {
                            enabled: true
                        }
                    },
                    plotOptions: {
                        radialBar: {
                            startAngle: -90,
                            endAngle: 90,
                            track: {
                                background: "#e7e7e7",
                                strokeWidth: '97%',
                                margin: 5,
                                dropShadow: {
                                    enabled: false
                                }
                            },
                            dataLabels: {
                                name: {
                                    show: false
                                },
                                value: {
                                    offsetY: -2,
                                    fontSize: '18px',
                                    show: false
                                }
                            }
                        }
                    },
                    fill: {
                        colors: [color]
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    labels: ['Progress'],
                };

                var chart = new ApexCharts(document.querySelector(selector), options);
                chart.render();
            }

            return {
                init:function(){
                },
                load:function(){
                    renderGauge("#gauge_inprogress", <?php echo $rateInProgress; ?>, "#e6b72cff");
                    renderGauge("#gauge_pending", <?php echo $ratePending; ?>, "#b6de16ff");
                    renderGauge("#gauge_completed", <?php echo $rateCompleted; ?>, "#0d893aff");
                    renderGauge("#gauge_reject", <?php echo $rateReject; ?>, "#9f2828ff");
                    
                    inspectionPieChart();
                    modelBarChart();
                },
                resize:function(){
                }
            }
        }();

        jQuery(document).ready(function(){
            dzChartlist.init();
            dzChartlist.load();
        });

        jQuery(window).on('resize',function(){
            dzChartlist.resize();
        });

    })(jQuery);
    </script>

</body>
</html>
