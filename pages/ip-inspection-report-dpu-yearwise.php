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
    
    <!-- Clockpicker -->
    <link href="vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    
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

        .status-bullet {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            box-shadow: inset -2px -2px 4px rgba(0,0,0,0.2), 0 2px 4px rgba(0,0,0,0.1);
        }
        .status-bullet.bg-hijau {
            background: radial-gradient(circle at 30% 30%, #5fba62ff, #4caf50);
        }
        .status-bullet.bg-merah {
            background: radial-gradient(circle at 30% 30%, #f75145ff, #f44336);
        }
    </style>

    
</head>
<body>

    <div id="preloader">
		<div>
		</div>
    </div>

    <div id="main-wrapper">
        <div class="nav-header">
            <?php include 'nav-hdr-logo.php'; ?>
        </div>
		
		<div class="chatbox">
			<div class="chatbox-close"></div>
            <?php include 'nav-hdr-chat-box.php'; ?>
		</div>
		
		<div class="header">
            <div class="header-content">
            <?php include 'nav-hdr-top.php'; ?>
			</div>
		</div>

		<div class="deznav">
            <div class="deznav-scroll">
                <?php include 'nav-left-sidebar.php'; ?>
			</div>
        </div>

        <style>
        .tbl-yearly-dpu tbody tr td:last-child {
            text-align: center !important; 
        }

        .tbl-yearly-dpu thead tr th:last-child{
            text-align: center !important;
        }

        .table-responsive {
            max-height: 500px; /* Adjust this value to your liking */
            overflow-y: auto;  /* Enables vertical scroll */
            overflow-x: auto;  /* Enables horizontal scroll for wide tables */
        }

        </style>

        <div class="content-body">
			<div class="container-fluid">
                    <div class="report-shell">
                        <div class="report-hero">
                            <h2>Yearly DPU Performance Summary</h2>
                            <p>This section breaks down Yearly Model Volume, Total Failures and DPU.</p>
                        </div>    
                    </div> 

                    <div class="card-header flex-wrap">
                        <div>
                            <!-- <h4 class="card-title">Yearly DPU Performance Summary</h4> -->
                            <!-- <p class="m-0 subtitle">Default datatables. Add <code>datatables</code> class in root</p> -->
                        </div>
                        <ul class="nav nav-tabs dzm-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="monthly-tab" type="button" role="tab"  aria-selected="true"  onclick="window.location.href='ip-inspection-report-dpu.php'">Monthly</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="yearly-tab" type="button" role="tab" aria-selected="false">Yearly</button>
                            </li>
                        </ul>
                    </div>

                    <div class="row mt-4">
                        <!-- Column starts -->
                        <div class="col-xl-12">
                            <div class="card dz-card" id="accordion-one">
                                <div class="card-header flex-wrap">
                                    <div>
                                        <h4 class="card-title">Yearly Defect & DPU Trend</h4>
                                        <!-- <p class="m-0 subtitle">Default datatables. Add <code>datatables</code> class in root</p> -->
                                    </div>
                                </div>

                                <!--tab-content-->
                                <div class="tab-content" id="yearly-tab">
                                    <div class="tab-pane fade show active" id="Preview" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="card-body pt-0">
                                                <?php
                                                // Get financial years
                                                $sql_fys = "
                                                    SELECT financial_year, financial_desc 
                                                    FROM financial_year 
                                                    WHERE financial_year >= (
                                                        SELECT financial_year - 1 
                                                        FROM financial_year 
                                                        WHERE financial_accstatus = 'AC' 
                                                        LIMIT 1
                                                    )
                                                    AND financial_year <= (
                                                        SELECT financial_year 
                                                        FROM financial_year 
                                                        WHERE financial_accstatus = 'AC' 
                                                        LIMIT 1
                                                    )
                                                    ORDER BY financial_year ASC
                                                ";
                                                $res_fys = $db_con->query($sql_fys);
                                                $fys = [];
                                                if ($res_fys) {
                                                    while ($row = $res_fys->fetch_assoc()) {
                                                        $fys[] = $row;
                                                    }
                                                }

                                                // Get models
                                                $sql_models = "SELECT modid, modcode FROM model_details WHERE compcd = '$session_comp' AND plant = '$session_plant' AND modstatus = 'Y' ORDER BY modid ASC";
                                                $res_models = $db_con->query($sql_models);
                                                $models = [];
                                                if ($res_models) {
                                                    while ($row = $res_models->fetch_assoc()) {
                                                        $models[] = $row;
                                                    }
                                                }

                                                // Build data map for volume and defects
                                                $data_map = [];
                                                if (!empty($fys)) {
                                                    $min_fy = $fys[0]['financial_year'];
                                                    $max_fy = $fys[count($fys)-1]['financial_year'];

                                                    // Fetch defects
                                                    $sql_def = "
                                                        SELECT 
                                                            r.ir_model, 
                                                            r.financial_yr, 
                                                            COUNT(d.defect_id) as def
                                                        FROM inspection_records r
                                                        JOIN inspection_defect d ON r.ir_id = d.rcd_ir_id
                                                        WHERE r.financial_yr >= '$min_fy' AND r.financial_yr <= '$max_fy'
                                                        GROUP BY r.ir_model, r.financial_yr
                                                    ";
                                                    $res_def = $db_con->query($sql_def);
                                                    if ($res_def) {
                                                        while ($row = $res_def->fetch_assoc()) {
                                                            $data_map[$row['ir_model']][$row['financial_yr']]['def'] = $row['def'];
                                                        }
                                                    }

                                                    // Fetch volumes from dpu_volume
                                                    $sql_vol = "
                                                        SELECT 
                                                            model_id, 
                                                            financial_year, 
                                                            (IFNULL(jan,0) + IFNULL(feb,0) + IFNULL(mac,0) + IFNULL(apr,0) + IFNULL(may,0) + IFNULL(june,0) + IFNULL(july,0) + IFNULL(aug,0) + IFNULL(sept,0) + IFNULL(oct,0) + IFNULL(nov,0) + IFNULL(december,0)) as total_vol
                                                        FROM dpu_volume
                                                        WHERE financial_year >= '$min_fy' AND financial_year <= '$max_fy'
                                                    ";
                                                    $res_vol = $db_con->query($sql_vol);
                                                    if ($res_vol) {
                                                        while ($row = $res_vol->fetch_assoc()) {
                                                            $data_map[$row['model_id']][$row['financial_year']]['vol'] = $row['total_vol'];
                                                        }
                                                    }
                                                }
                                                ?>

                                            <div class="table-responsive">
                                                <table class="display table mb-1 table-striped table-bordered tbl-yearly-dpu">
                                                        <thead class="thead-black">
                                                            <tr>
                                                                <th rowspan="2" class="align-middle text-center">Model</th>
                                                                <?php foreach($fys as $fy): ?>
                                                                    <th colspan="3" class="text-center">FY <?= htmlspecialchars($fy['financial_desc']) ?></th>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                            <tr>
                                                                <?php foreach($fys as $fy): ?>
                                                                    <th class="text-center">Volume</th>
                                                                    <th class="text-center">Defects</th>
                                                                    <th class="text-center" style="background-color: #c62513ff; color: #fff;">DPU</th>
                                                                <?php endforeach; ?>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach($models as $m): ?>
                                                                <tr>
                                                                    <td class="fw-bold text-center"><?= htmlspecialchars($m['modcode']) ?></td>
                                                                    <?php 
                                                                    foreach($fys as $fy): 
                                                                        $yr = $fy['financial_year'];
                                                                        $vol = isset($data_map[$m['modid']][$yr]['vol']) ? (int)$data_map[$m['modid']][$yr]['vol'] : 0;
                                                                        $def = isset($data_map[$m['modid']][$yr]['def']) ? (int)$data_map[$m['modid']][$yr]['def'] : 0;
                                                                        $dpu = $vol > 0 ? number_format($def / $vol, 4) : '0.0000';
                                                                    ?>
                                                                        <td class="text-center"><?= $vol ?></td>
                                                                        <td class="text-center text-danger"><?= $def > 0 ? $def : '-' ?></td>
                                                                        <td class="text-center fw-semibold text-primary"><?= $vol > 0 ? $dpu : '-' ?></td>
                                                                    <?php endforeach; ?>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        </tbody>
                                                         <tfoot>
                                                             <tr style="background-color: #f8f9fa; font-weight: bold; border-top: 2px solid #dee2e6;">
                                                                 <td class="text-center">TOTAL</td>
                                                                 <?php 
                                                                 foreach($fys as $fy): 
                                                                    $yr = $fy['financial_year'];
                                                                    $total_vol = 0;
                                                                    $total_def = 0;
                                                                    foreach($models as $m) {
                                                                        $total_vol += isset($data_map[$m['modid']][$yr]['vol']) ? (int)$data_map[$m['modid']][$yr]['vol'] : 0;
                                                                        $total_def += isset($data_map[$m['modid']][$yr]['def']) ? (int)$data_map[$m['modid']][$yr]['def'] : 0;
                                                                    }
                                                                    $total_dpu = $total_vol > 0 ? number_format($total_def / $total_vol, 4) : '0.0000';
                                                                ?>
                                                                    <td class="text-center"><?= number_format($total_vol) ?></td>
                                                                    <td class="text-center text-danger"><?= $total_def > 0 ? number_format($total_def) : '-' ?></td>
                                                                    <td class="text-center text-primary"><?= $total_vol > 0 ? $total_dpu : '-' ?></td>
                                                                 <?php endforeach; ?>
                                                             </tr>
                                                         </tfoot>
                                                </table>
                                            </div>

                                                <?php

                                                // Prepare chart data
                                                $chart_categories = [];
                                                $chart_series = [];
                                                
                                                foreach($fys as $fy) {
                                                    $chart_categories[] = 'FY ' . $fy['financial_desc'];
                                                }

                                                foreach($models as $m) {
                                                    $model_data = [];
                                                    foreach($fys as $fy) {
                                                        $yr = $fy['financial_year'];
                                                        $def = isset($data_map[$m['modid']][$yr]['def']) ? (int)$data_map[$m['modid']][$yr]['def'] : 0;
                                                        $model_data[] = $def;
                                                    }
                                                    $chart_series[] = [
                                                        'name' => htmlspecialchars($m['modcode']),
                                                        'type' => 'column',
                                                        'data' => $model_data
                                                    ];
                                                }

                                                $dpu_data = [];
                                                foreach($fys as $fy) {
                                                    $yr = $fy['financial_year'];
                                                    $total_vol = 0;
                                                    $total_def = 0;
                                                    foreach($models as $m) {
                                                        $vol = isset($data_map[$m['modid']][$yr]['vol']) ? (int)$data_map[$m['modid']][$yr]['vol'] : 0;
                                                        $def = isset($data_map[$m['modid']][$yr]['def']) ? (int)$data_map[$m['modid']][$yr]['def'] : 0;
                                                        $total_vol += $vol;
                                                        $total_def += $def;
                                                    }
                                                    $dpu = $total_vol > 0 ? (float)number_format($total_def / $total_vol, 4) : 0;
                                                    $dpu_data[] = $dpu;
                                                }
                                                
                                                $chart_series[] = [
                                                    'name' => 'Overall DPU',
                                                    'type' => 'line',
                                                    'data' => $dpu_data
                                                ];
                                                ?>

                                                <hr>   
                                                <div class="mb-4 mt-4">
                                                    <div id="yearlyTrendChart"></div>
                                                </div>
                                             </div>

                                                <?php
                                                // Calculate Insights
                                                $latest_fy_idx = count($fys) - 1;
                                                $latest_fy = $latest_fy_idx >= 0 ? $fys[$latest_fy_idx]['financial_year'] : null;
                                                $latest_fy_desc = $latest_fy_idx >= 0 ? $fys[$latest_fy_idx]['financial_desc'] : '';
                                                $max_dpu_val = -1;
                                                $top_model_name = "";

                                                if ($latest_fy) {
                                                    foreach ($models as $m) {
                                                        $vol = isset($data_map[$m['modid']][$latest_fy]['vol']) ? (int)$data_map[$m['modid']][$latest_fy]['vol'] : 0;
                                                        $def = isset($data_map[$m['modid']][$latest_fy]['def']) ? (int)$data_map[$m['modid']][$latest_fy]['def'] : 0;
                                                        $dpu = $vol > 0 ? $def / $vol : 0;
                                                        if ($dpu > $max_dpu_val && $dpu > 0) {
                                                            $max_dpu_val = $dpu;
                                                            $top_model_name = $m['modcode'];
                                                        }
                                                    }
                                                }
                                                ?>

                                            <!-- /Default accordion -->	
                                        </div>
                                        
                                        
                                    </div>
                                    <!--/tab-content-->

                        
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card border-0 shadow-sm" style="box-shadow: 0 0.125rem 0.25rem #9c9898ff !important;">
                                <div class="card-header border-0 border-bottom">
                                    <h4 class="heading mb-0"><i class="fa fa-lightbulb me-2" aria-hidden="true"></i> Yearly Insight</h4>
                                </div>
                                <div class="card-body py-3 px-4">                                            
                                    <div id="yearlyInsight">
                                        <h6 class="mb-1" style="font-size: 13px; font-weight: 600;">Top Contributing Model (FY <?= $latest_fy_desc ?>)</h6>
                                        <?php if ($top_model_name): ?>
                                            <p class="text-muted mb-0" style="font-size: 12px;">
                                                <strong><span style="color: #565856ff;font-weight:700;"><?= htmlspecialchars($top_model_name) ?></span></strong> had the highest DPU 
                                                <span style="color: #c22b1aff;font-weight:700;">(<?= number_format($max_dpu_val, 4) ?>)</span> in FY <?= htmlspecialchars($latest_fy_desc) ?>.
                                            </p>
                                            <p class="text-muted mt-2 mb-0" style="font-size: 12px;">
                                                Consider conducting a root cause analysis (RCA) on the <strong><?= htmlspecialchars($top_model_name) ?></strong> production line to reduce defect frequency for the next cycle.
                                            </p>
                                        <?php else: ?>
                                            <p class="text-muted mb-0" style="font-size: 12px;">No significant DPU data found for the current period.</p>
                                        <?php endif; ?>
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

    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/select2/js/select2.full.min.js"></script>
    <script src="js/plugins-init/select2-init.js"></script>
   	<script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>	

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/js/dataTables.buttons.min.js"></script>
    <script src="vendor/datatables/js/buttons.html5.min.js"></script>
    <script src="vendor/datatables/js/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
	<script src="vendor/datatables/responsive/responsive.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/deznav-init.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="js/plugins-init/sweetalert.init.js"></script>

    <script src="vendor/moment/moment.min.js"></script>
    <!-- clockpicker -->
    <script src="vendor/clockpicker/js/bootstrap-clockpicker.min.js"></script>
    <!-- Clockpicker init -->
    <script src="js/plugins-init/clock-picker-init.js"></script>

    <script src="vendor/apexchart/apexchart.js"></script>

    <script>
    $('.filter-select').select2({
        minimumResultsForSearch: Infinity,
        width: '100%'
    });
    </script>

    <script>
    $(document).ready(function () {
        $('.tbl-yearly-dpu').DataTable({
            // Enable pagination and setup layout (Length menu, Filter, Table, Info, Pagination)
            dom: '<"d-flex justify-content-between align-items-center mb-3"lf>rt<"d-flex justify-content-between align-items-center mt-3"ip>',
            paging: true,
            lengthChange: true,
            pageLength: 10,
            lengthMenu: [10, 20, 50, 100],
            ordering: false, // Disabled due to complex rowspan/colspan header
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            },
            initComplete: function(settings, json) {
                this.api().columns.adjust();
            }
        });

        // Initialize Yearly Trend Chart
        var chartCategories = <?= json_encode($chart_categories) ?>;
        var chartSeries = <?= json_encode($chart_series) ?>;

        if (chartSeries.length > 1) {
            var yaxisConfig = [];
            // Defect Qty Axis
            yaxisConfig.push({
                seriesName: chartSeries[0].name,
                title: { text: 'Quantity of Defect', style: { fontWeight: 600 } },
                labels: { formatter: function(val) { return Math.round(val); } }
            });
            // Hide other column axes
            for(var i=1; i < chartSeries.length - 1; i++) {
                yaxisConfig.push({
                    seriesName: chartSeries[i].name,
                    show: false
                });
            }
            // DPU Axis
            yaxisConfig.push({
                seriesName: chartSeries[chartSeries.length - 1].name,
                opposite: true,
                title: { text: 'DPU', style: { fontWeight: 600 } },
                labels: { formatter: function(val) { return val.toFixed(4); } }
            });

            var strokeWidths = chartSeries.map(function(s) {
                return s.type === 'line' ? 3 : 0;
            });

            var chartColors = ['#11470F', '#739C38', '#b6b00aff', '#51462fff', '#B08038', '#e1a91dff', '#879e83'];
            var seriesColors = chartSeries.map(function(s, index) {
                if (index === chartSeries.length - 1) return '#c62513ff'; // Distinct red for Overall DPU line
                return chartColors[index % chartColors.length];
            });

            var options = {
                series: chartSeries,
                colors: seriesColors,
                chart: {
                    height: 450,
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
                    width: strokeWidths,
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '40%'
                    }
                },
                xaxis: {
                    categories: chartCategories,
                    title: { text: 'Financial Year', style: { fontWeight: 600 } }
                },
                yaxis: yaxisConfig,
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (val, opts) {
                            if(val === undefined || val === null) return val;
                            var seriesType = chartSeries[opts.seriesIndex].type;
                            if(seriesType === 'line') return val.toFixed(4);
                            return val;
                        }
                    }
                },
                legend: {
                    position: 'right',
                    offsetY: 40
                }
            };

            var yearlyTrendChart = new ApexCharts(document.querySelector("#yearlyTrendChart"), options);
            yearlyTrendChart.render();
        }
    });
    </script>


</body>
</html>
