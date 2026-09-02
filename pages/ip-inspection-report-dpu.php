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
        #tableDPUReport tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableDPUReport thead tr th:last-child{
            text-align: left !important;
        }

        #tableMonthlyDPU tbody tr td:last-child {
            text-align: left !important; 
        }

        #tableMonthlyDPU thead tr th:last-child{
            text-align: left !important;
        }
        </style>

        <div class="content-body">
			<div class="container-fluid">
                 <div class="report-shell">
                    <div class="report-hero">
                        <h2>Monthly DPU Report</h2>
                        <p>This section breaks down monthly Volume, Defects and DPU by Models.</p>
                    </div>

                    <div class="tab-content" id="tabshift">
                        <div class="tab-pane fade show active" id="create-tab-pane" role="tabpanel" aria-labelledby="create-tab" tabindex="0">                        
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="card">                                    
                                        <?php
                                        $cYr = date('Y');

                                        // Fetch dropdown data for filter form
                                        $fy_sql_f  = "SELECT financial_year, financial_desc FROM financial_year WHERE financial_year <= '$cYr'  ORDER BY financial_year DESC";
                                        $fy_res_f  = mysqli_query($db_con, $fy_sql_f);
                                        ?>

                                        <div class="card-header border-0 border-bottom d-flex justify-content-between align-items-center flex-wrap">
                                            <div>
                                                <h4 class="heading mb-0">DPU by Model</h4>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="dropdown custom-dropdown">
                                                    <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; background: transparent; border: none;">
                                                        <i class="fa fa-bars" style="font-size: 18px; color: #5a5c69;"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="export-inspection-report-dpu.php?fy=<?= $cYr ?>" id="exportExcelBtnDPU"><i class="fa fa-file-excel text-green me-2"></i> Download Excel</a></li>
                                                        <li><a class="dropdown-item" href="export-inspection-report-dpu-pdf.php?fy=<?= $cYr ?>" id="exportPdfBtnDPU" target="_blank"><i class="fa fa-file-pdf text-red me-2"></i> Download PDF</a></li>
                                                    </ul>
                                                </div>                                                            
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-2 align-items-end mb-2">
                                                <div class="col-auto g-4">
                                                    <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Financial Year</label>
                                                    <select name="filter_fy" id="filter_fy" class="form-select form-select-sm cs-border-primary text-primary filter-select" onchange="reloadDPUData()">
                                                        <?php while($fy_row = mysqli_fetch_assoc($fy_res_f)): ?>
                                                            <option value="<?= $fy_row['financial_year'] ?>" <?= ($fy_row['financial_year'] == 2026 || $fy_row['financial_year'] == date('Y')) ? 'selected' : '' ?>>
                                                                FY <?= $fy_row['financial_desc'] ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="table-responsive">
                                                <table id="tableDPUReport" class="display table mb-1 table-striped-thead table-wide table-md" style="width: 100%; min-width: 1000px;">
                                                    <thead class="thead-black">
                                                        <tr>
                                                            <th>No</th>
                                                            <th style="min-width: 90px;">Model</th>
                                                            <th>Feb</th>
                                                            <th>Mac</th>
                                                            <th>April</th>
                                                            <th>May</th>
                                                            <th>June</th>
                                                            <th>July</th>
                                                            <th>Aug</th>
                                                            <th>Sept</th>
                                                            <th>Oct</th>
                                                            <th>Nov</th>
                                                            <th>Dec</th>
                                                            <th style="text-align: left !important;">Jan</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>

                                            <hr>
                                            <div class="mb-4 mt-3">
                                                <div id="overallDpuChart" style="min-height: 300px;"></div>
                                            </div>

                                        
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-12 dpu_table">
                                    <div class="card">                                    
                                        <?php
                                        $cYr = date('Y');

                                        // Fetch dropdown data for filter form
                                        $fy_sql_f  = "SELECT financial_year, financial_desc FROM financial_year WHERE financial_year <= '$cYr'  ORDER BY financial_year DESC";
                                        $fy_res_f  = mysqli_query($db_con, $fy_sql_f);
                                        ?>

                                        <div class="card-header border-0 border-bottom d-flex justify-content-between align-items-center flex-wrap">
                                            <div>
                                                <h4 class="heading mb-0">Monthly Volume & DPU Performance by Model</h4>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <div class="dropdown custom-dropdown">
                                                    <button type="button" class="btn btn-sm" data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0; background: transparent; border: none;">
                                                        <i class="fa fa-bars" style="font-size: 18px; color: #5a5c69;"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="export-inspection-report-dpu-montlhy.php?fy=<?= $cYr ?>" id="exportExcelBtnMonthly"><i class="fa fa-file-excel text-green me-2"></i> Download Excel</a></li>
                                                        <li><a class="dropdown-item" href="export-inspection-report-dpu-montlhy-pdf.php?fy=<?= $cYr ?>" id="exportPdfBtnMonthly" target="_blank"><i class="fa fa-file-pdf text-red me-2"></i> Download PDF</a></li>
                                                    </ul>
                                                </div>                                                            
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="row g-2 align-items-end mb-4">
                                                <div class="col-auto g-4">
                                                    <label class="form-label mb-1" style="font-size:11px;font-weight:600;color:#555;">Financial Year</label>
                                                    <select name="filter_fy_monthly" id="filter_fy_monthly" class="form-select form-select-sm cs-border-primary text-primary filter-select" onchange="reloadDPUMonthlyData()">
                                                        <?php while($fy_row = mysqli_fetch_assoc($fy_res_f)): ?>
                                                            <option value="<?= $fy_row['financial_year'] ?>" <?= ($fy_row['financial_year'] == 2026 || $fy_row['financial_year'] == date('Y')) ? 'selected' : '' ?>>
                                                                FY <?= $fy_row['financial_desc'] ?>
                                                            </option>
                                                        <?php endwhile; ?>
                                                    </select>
                                                </div>
                                            </div>
    
                                            <div class="mb-4 mt-4">
                                                <div id="monthlyTrendChart"></div>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="tableMonthlyDPU" class="display table mb-1 table-striped table-bordered" style="min-width: 800px;">
                                                    <thead class="thead-black">
                                                        <tr>
                                                            <th>Month</th>
                                                            <th>Model</th>
                                                            <th>Total Defects</th>
                                                            <th style="background-color: #ce6b0fff;">Volume</th>
                                                            <th style="background-color: #c62513ff;">DPU</th>
                                                            <th style="background-color: #64c226ff;">Target</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
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
                                            <div id="monthlyInsight">
                                                <h6 class="mb-1" style="font-size: 13px; font-weight: 600;">Top Contributing Model</h6>
                                                <p id="topModelText" class="text-muted mb-0" style="font-size: 12px;">No data available for the current selection.</p>
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

    var table;
    var tableMonthly;
    var dpuChart;
    var trendChart;


    function reloadDPUData() {
        if(table) table.ajax.reload();
        fetchChartData();
        
        var fy = $('#filter_fy').val();
        $('#exportExcelBtnDPU').attr('href', 'export-inspection-report-dpu.php?fy=' + fy);
        $('#exportPdfBtnDPU').attr('href', 'export-inspection-report-dpu-pdf.php?fy=' + fy);
    }

    function reloadDPUMonthlyData() {
        if(tableMonthly) tableMonthly.ajax.reload();
        fetchMonthlyTrendData();
        
        var fy = $('#filter_fy_monthly').val();
        $('#exportExcelBtnMonthly').attr('href', 'export-inspection-report-dpu-montlhy.php?fy=' + fy);
        $('#exportPdfBtnMonthly').attr('href', 'export-inspection-report-dpu-montlhy-pdf.php?fy=' + fy);
    }

    function fetchMonthlyTrendData() {
        var fy = $('#filter_fy_monthly').val();
        $.ajax({
            url: 'fetch-dpu.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'get_monthly_dpu_chart', filter_fy: fy },
            success: function(response) {
                if(response.status === 'success') {
                    renderMonthlyTrendChart(response.categories, response.series);
                }
            }
        });
    }

    function renderMonthlyTrendChart(categories, series) {
        if(trendChart) {
            trendChart.destroy();
        }

        if(!series || series.length === 0) return;

        // Separate series by type for Y-axis mapping
        var firstVolSeries = series.find(s => s.type === 'column');
        var firstDpuSeries = series.find(s => s.type === 'line');

        var yaxis = series.map(s => {
            if (s.type === 'column') {
                return {
                    seriesName: firstVolSeries ? firstVolSeries.name : s.name,
                    show: s.name === (firstVolSeries ? firstVolSeries.name : ''),
                    title: { text: 'Volume', style: { color: '#3f3f3fff', fontWeight: 600 } },
                    labels: { 
                        style: { colors: '#3f3f3fff' },
                        formatter: function(val) { return val ? Number(val).toLocaleString() : '0'; }
                    }
                };
            } else {
                return {
                    seriesName: firstDpuSeries ? firstDpuSeries.name : s.name,
                    show: s.name === (firstDpuSeries ? firstDpuSeries.name : ''),
                    opposite: true,
                    title: { text: 'DPU', style: { color: '#3f3f3fff', fontWeight: 600 } },
                    labels: { 
                        style: { colors: '#3f3f3fff' },
                        formatter: function(val) { return (val !== null && val !== undefined) ? Number(val).toFixed(4) : ''; }
                    }
                };
            }
        });

        // Set matched colors for Vol and DPU of the same model
        var palette = ['#34a71dff', '#c56a0eff', '#51462fff', '#e1a91dff', '#842f1aff', '#dac61bff', '#546E7A', '#13d8aa', '#A5978B'];
        var finalColors = [];
        var modelColorMap = {};
        var colorIdx = 0;

        series.forEach(s => {
            var modelName = s.name.replace(' Vol', '').replace(' DPU', '');
            if (!modelColorMap[modelName]) {
                modelColorMap[modelName] = palette[colorIdx % palette.length];
                colorIdx++;
            }
            finalColors.push(modelColorMap[modelName]);
        });

        var options = {
            series: series,
            chart: {
                height: 450,
                type: 'line',
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
                foreColor: '#333',
                fontFamily: 'inherit'
            },
            stroke: {
                width: series.map(s => s.type === 'line' ? 3 : 0),
                curve: 'smooth'
            },
            markers: {
                size: series.map(s => s.type === 'line' ? 4 : 0),
                strokeWidth: 2,
                hover: { size: 6 }
            },
            plotOptions: {
                bar: { 
                    columnWidth: '70%',
                    borderRadius: 2,
                    dataLabels: { position: 'top' }
                }
            },
            colors: finalColors,
            dataLabels: { 
                enabled: true,
                enabledOnSeries: series.map((s, idx) => s.type === 'column' ? idx : -1).filter(i => i !== -1),
                formatter: function(val) { return val ? Number(val).toLocaleString() : ''; },
                offsetY: -20,
                style: { fontSize: '10px', colors: ["#333"] }
            },
            xaxis: {
                categories: categories,
                axisBorder: { show: true },
                axisTicks: { show: true },
                labels: { 
                    show: true,
                    style: { fontWeight: 600, fontSize: '12px' } 
                }
            },
            yaxis: yaxis,
            tooltip: {
                shared: true,
                intersect: false,
                theme: 'light',
                y: {
                    formatter: function(val, { seriesIndex }) {
                        var s = series[seriesIndex];
                        if (s.type === 'column') return val ? Number(val).toLocaleString() : '0';
                        return (val !== null && val !== undefined) ? Number(val).toFixed(4) : '-';
                    }
                }
            },
            legend: {
                position: 'right',
                verticalAlign: 'middle',
                offsetY: 0,
                markers: { radius: 2 }
            },
            grid: {
                borderColor: '#e0e0e0',
                strokeDashArray: 0
            },
            title: {
                text: '',
                align: 'left',
                style: { fontSize: '16px', fontWeight: 'bold', color: '#173320' }
            }
        };

        trendChart = new ApexCharts(document.querySelector("#monthlyTrendChart"), options);
        trendChart.render();

        // Calculate Monthly Insights
        updateMonthlyInsights(categories, series);
    }

    function updateMonthlyInsights(categories, series) {
        var latestMonthIdx = -1;
        var maxDpu = -1;
        var topModel = "";

        // Find the latest month that has at least one DPU value
        for (var m = categories.length - 1; m >= 0; m--) {
            var monthHasData = false;
            series.forEach(s => {
                if (s.type === 'line') {
                    var val = s.data[m];
                    if (val !== null && val !== undefined && val > 0) {
                        monthHasData = true;
                        if (val > maxDpu) {
                            maxDpu = val;
                            topModel = s.name.replace(' DPU', '');
                        }
                    }
                }
            });
            if (monthHasData) {
                latestMonthIdx = m;
                break;
            }
        }

        if (topModel && latestMonthIdx !== -1) {
            $('#topModelText').html('<strong><span style="color: #565856ff;font-weight:700;">' + topModel + '</strong></span>' + ' had the highest DPU <span style="color: #c22b1aff;font-weight:700;">(' + maxDpu.toFixed(4) + ')</span> in ' + categories[latestMonthIdx] + '.');
            $('#suggestionText').html('Consider conducting a root cause analysis (RCA) on the <strong>' + topModel + '</strong> production line to reduce defect frequency.');
        } else {
            $('#topModelText').text('No significant DPU data found for the current period.');
            $('#suggestionText').text('Maintain current quality control measures and monitor upcoming production cycles.');
        }
    }


    function fetchChartData() {
        var fy = $('#filter_fy').val();
        $.ajax({
            url: 'fetch-dpu.php',
            type: 'POST',
            dataType: 'json',
            data: { action: 'get_dpu_chart', filter_fy: fy },
            success: function(res) {
                if(res.status === 'success') {
                    if (dpuChart) {
                        dpuChart.updateSeries(res.series);
                        dpuChart.updateOptions({
                            tooltip: {
                                y: {
                                    formatter: function (val, opts) {
                                        var sIndex = opts.seriesIndex;
                                        var idx = opts.dataPointIndex;
                                        var def = res.series[sIndex].defects[idx];
                                        var vol = res.series[sIndex].volumes[idx];
                                        return val + " (Defects: " + def + ", Vol: " + vol + ")";
                                    }
                                }
                            }
                        });
                    } else {
                        var options = {
                            series: res.series,
                            chart: {
                                height: 350,
                                type: 'line', 
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
                            colors: ['#11470F', '#739C38', '#c56a0eff', '#842f1aff', '#51462fff', '#e1a91dff', '#879e83'],
                            dataLabels: {
                                enabled: false
                            },
                            stroke: { curve: 'smooth', width: 2 },
                            xaxis: {
                                categories: ['Feb', 'Mac', 'April', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec', 'Jan'],
                                labels: { style: { fontWeight: 600 } }
                            },
                            yaxis: {
                                title: { text: 'Defects Per Unit (DPU)', style: { fontWeight: 600 } }
                            },
                            tooltip: {
                                theme: 'light',
                                y: {
                                    formatter: function (val, opts) {
                                        var sIndex = opts.seriesIndex;
                                        var idx = opts.dataPointIndex;
                                        var def = res.series[sIndex].defects[idx];
                                        var vol = res.series[sIndex].volumes[idx];
                                        return val + " (Defects: " + def + ", Vol: " + vol + ")";
                                    }
                                }
                            }
                        };
                        dpuChart = new ApexCharts(document.querySelector("#overallDpuChart"), options);
                        dpuChart.render();
                    }
                }
            }
        });
    }
    
    $(document).ready(function () {
        
        fetchChartData();

        table = $('#tableDPUReport').DataTable({
            dom: '<"d-none"B><"d-flex justify-content-end mb-3"f>rt<"d-flex justify-content-between mt-3"ip>',
            buttons: [
                { extend: 'excel', className: 'buttons-excel' },
                { extend: 'pdf', className: 'buttons-pdf', orientation: 'landscape', pageSize: 'A4' }
            ],
            processing: true,
            serverSide: true,
            lengthChange: false,
            pageLength: 10,
            scrollY: "500px",
            scrollX: true,
            scrollCollapse: true,
            order: [[1, 'asc']], // Order by model code by default
            ajax: {
                url: 'fetch-dpu.php',
                type: 'POST',
                data: function(d) {
                    d.action = 'list_dpu_report';
                    d.filter_fy = $('#filter_fy').val();
                }
            },
            columnDefs: [
                { targets: [0], orderable: false, searchable: false },
                { targets: [2,3,4,5,6,7,8,9,10,11,12,13], orderable: false, searchable: false }
            ],
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

        tableMonthly = $('#tableMonthlyDPU').DataTable({
            processing: true,
            serverSide: false,
            lengthChange: false,
            pageLength: 20,
            ordering: false,
            ajax: {
                url: 'fetch-dpu.php',
                type: 'POST',
                data: function(d) {
                    d.action = 'list_monthly_dpu_table';
                    d.filter_fy = $('#filter_fy_monthly').val();
                }
            },
            language: {
                paginate: {
                    previous: '<i class="fa fa-angle-left"></i>',
                    next: '<i class="fa fa-angle-right"></i>'
                }
            },
            drawCallback: function(settings) {
                $('[data-bs-toggle="tooltip"]').tooltip();
            }
        });
        fetchMonthlyTrendData();

    });
    </script>

</body>
</html>
