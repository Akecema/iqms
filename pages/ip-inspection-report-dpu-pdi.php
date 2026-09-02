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
        .legend-icon { display: inline-block; width: 24px; height: 24px; vertical-align: middle; }
        .double-green { border: 3px double #28a745; border-radius: 50%; }
        .single-green { border: 2px solid #28a745; border-radius: 50%; }
        .triangle-black { width: 0; height: 0; border-left: 10px solid transparent; border-right: 10px solid transparent; border-bottom: 18px solid #000; background: none; }
        .red-x { color: #dc3545; font-weight: bold; font-size: 20px; display: flex; align-items: center; justify-content: center; }
        .red-x::after { content: 'X'; }
        
        #tblPDIPerformance thead th { background-color: #000000 !important; color: white !important; font-weight: 600; border-color: #333; vertical-align: middle; }
        #tblPDIPerformance tbody td { border-color: #dee2e6; vertical-align: middle; }
        .bg-light-blue { background-color: #e9f2fb; font-weight: 600; }

        /* Add */
        .table .thead-black th {
            background-color: #000000 !important;
            color: #fff !important;
            font-size: 12px;
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
                            <h2>PDI Performance</h2>
                            <p>This section tracks the PDI (Pre-Delivery Inspection) Performance for the Internal Quality category across all models.</p>
                        </div>    
                    </div> 

                    <div class="row mt-4">
                        <div class="col-xl-12">
                            <div class="card table-card">
                                <div class="card-header border-0 pb-0">
                                    <h4 class="card-title fw-bold">PDI Performance Summary</h4>
                                    <div class="ms-auto d-flex align-items-center">
                                        <label class="me-2 mb-0 fw-bold">Financial Year:</label>
                                        <select id="filter_fy" class="form-select form-select-sm" style="width: 120px;">
                                            <?php
                                            $curr_yr = date('Y');
                                            $sql_fy = "SELECT financial_year, financial_desc FROM financial_year WHERE financial_year <= '$curr_yr' ORDER BY financial_year DESC";
                                            $res_fy = $db_con->query($sql_fy);
                                            while($fy_row = $res_fy->fetch_assoc()) {
                                                $selected = ($fy_row['financial_year'] == $curr_yr) ? 'selected' : '';
                                                echo "<option value='{$fy_row['financial_year']}' $selected>{$fy_row['financial_desc']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="tblPDIPerformance" class="table table-bordered table-striped text-center align-middle">
                                            <thead style="background-color: #000 !important;">
                                                <tr id="pdiHeader">
                                                    <th>Internal Quality</th>
                                                    <th>Items</th>
                                                    <th>Model</th>
                                                    <th>Unit</th>
                                                    <th>Target</th>
                                                    <!-- Months will be injected here -->
                                                    <th>Status</th>
                                                    <th>YTD (FY<span id="ytdFY"></span>)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="pdiBody">
                                                <!-- Data will be injected here -->
                                            </tbody>
                                        </table>
                                        
                                        <div class="border-top pt-3 mt-3 text-end">
                                            <p class="mb-0 fs-14">
                                                <span class="fw-bold text-dark me-2">Models:</span> 
                                                <?php
                                                $sql_m = "SELECT modcode FROM model_details WHERE compcd = '$session_comp' AND plant = '$session_plant' AND modstatus = 'Y' ORDER BY modcode ASC";
                                                $res_m = $db_con->query($sql_m);
                                                $m_list = [];
                                                if ($res_m) {
                                                    while($m_row = $res_m->fetch_assoc()) {
                                                        $m_list[] = $m_row['modcode'];
                                                    }
                                                }
                                                echo implode(' / ', $m_list);
                                                ?>
                                            </p>
                                        </div>

                                    </div>

                                    <div class="mt-4 border-top pt-3">
                                        <div class="d-flex align-items-center flex-wrap gap-4 mb-3">
                                            <span class="fw-bold me-2 text-dark">Legends:</span>
                                            <div class="d-flex align-items-center"><span class="legend-icon double-green me-2"></span> <span class="fs-13">≥ target</span></div>
                                            <div class="d-flex align-items-center"><span class="legend-icon single-green me-2"></span> <span class="fs-13">&lt; 3% target</span></div>
                                            <div class="d-flex align-items-center"><span class="legend-icon triangle-black me-2"></span> <span class="fs-13">3% ~ 10% below target</span></div>
                                            <div class="d-flex align-items-center"><span class="legend-icon red-x me-2"></span> <span class="fs-13">&gt; 10% below target</span></div>
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
    $(document).ready(function () {
        const target_val = 0.005;
        const m_map = {
            'feb': 'Feb', 'mac': 'Mar', 'apr': 'Apr', 'may': 'May', 'june': 'Jun',
            'july' : 'Jul', 'aug': 'Aug', 'sept': 'Sep', 'oct': 'Oct', 'nov': 'Nov',
            'december': 'Dec', 'jan': 'Jan'
        };

        function fetchPDIPerformance() {
            const fy = $('#filter_fy').val();
            $.ajax({
                url: 'fetch-dpu.php',
                type: 'POST',
                dataType: 'json',
                data: { action: 'get_pdi_performance', filter_fy: fy },
                success: function(res) {
                    if (res.status === 'success') {
                        renderPDITable(res);
                    }
                }
            });
        }

        function renderPDITable(res) {

            const data = res.data;
            const currentMonth = new Date().getMonth() + 1; // 1-12
            const currentYear = new Date().getFullYear();
            const filterYear = parseInt(res.fy);
            
            // Rebuild Header
            let headerHtml = `
                <th style="background-color: #000 !important; color: #fff !important;">Internal Quality</th>
                <th style="background-color: #000 !important; color: #fff !important;">Items</th>
                <th style="background-color: #000 !important; color: #fff !important;">Model</th>
                <th style="background-color: #000 !important; color: #fff !important;">Unit</th>
                <th style="background-color: #000 !important; color: #fff !important;">Target</th>
            `;
            
            let monthCols = [];
            // Order: Feb to Jan
            const months = ['feb', 'mac', 'apr', 'may', 'june', 'july', 'aug', 'sept', 'oct', 'nov', 'december', 'jan'];
            
            months.forEach(m => {
                // Simplified logic: for current FY, stop at current month. For past FY, show all.
                // Assuming FY starts in Feb.
                const m_num = (m === 'jan') ? 1 : (m === 'feb' ? 2 : (m === 'mac' ? 3 : (m === 'apr' ? 4 : (m === 'may' ? 5 : (m === 'june' ? 6 : (m === 'july' ? 7 : (m === 'aug' ? 8 : (m === 'sept' ? 9 : (m === 'oct' ? 10 : (m === 'nov' ? 11 : 12))))))))));
                
                let shouldShow = true;
                if (filterYear >= currentYear) {
                    // Logic for current/future FY
                    // If month is Jan, it's next calendar year.
                    if (m === 'jan') {
                        if (currentMonth !== 1) shouldShow = false;
                    } else {
                        if (m_num > currentMonth) shouldShow = false;
                    }
                }
                
                if (shouldShow) {
                    headerHtml += `<th style="background-color: #000 !important; color: #fff !important;">${m_map[m]}-${res.fy.substring(2)}</th>`;
                    monthCols.push(m);
                }
            });
            
            headerHtml += `
                <th style="background-color: #000 !important; color: #fff !important;">Status</th>
                <th style="background-color: #000 !important; color: #fff !important;">YTD (FY${res.fy.substring(2)}/${(parseInt(res.fy.substring(2))+1)})</th>
            `;
            $('#pdiHeader').html(headerHtml);

            // Render Body
            let bodyHtml = `
                <tr>
                    <td rowspan="1" class="bg-light-blue">Internal Quality</td>
                    <td>PDI Performance</td>
                    <td>All</td>
                    <td>DPU</td>
                    <td>< ${target_val}</td>
            `;

            let lastMonthDPU = 0;
            let hasLatestData = false;

            monthCols.forEach(m => {
                const val = data[m] ? data[m].dpu : 0;
                bodyHtml += `<td>${val.toFixed(4)}</td>`;
            });

            // Find latest month with volume > 0 for status
            for (let i = monthCols.length - 1; i >= 0; i--) {
                const m = monthCols[i];
                if (data[m] && data[m].vol > 0) {
                    lastMonthDPU = data[m].dpu;
                    hasLatestData = true;
                    break;
                }
            }

            // Status Logic (Performance vs Target)
            // legend: >= target (Double Green), < 3% target (Single Green), 3~10% below (Triangle), > 10% below (Red X)
            
            let statusIcon = '-';
            if (hasLatestData) {
                if (lastMonthDPU <= target_val) {
                    statusIcon = '<span class="legend-icon double-green" title="Performance >= Target"></span>';
                } else if (lastMonthDPU < target_val * 1.03) {
                    statusIcon = '<span class="legend-icon single-green" title="Performance < 3% below Target"></span>';
                } else if (lastMonthDPU < target_val * 1.10) {
                    statusIcon = '<span class="legend-icon triangle-black" title="Performance 3% ~ 10% below Target"></span>';
                } else {
                    statusIcon = '<span class="legend-icon red-x" title="Performance > 10% below Target"></span>';
                }
            }

            bodyHtml += `
                    <td>${statusIcon}</td>
                    <td>${res.ytd.toFixed(4)}</td>
                </tr>
            `;
            $('#pdiBody').html(bodyHtml);
        }

        $('#filter_fy').on('change', function() {
            fetchPDIPerformance();
        });

        fetchPDIPerformance();

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


    });
    </script>


</body>
</html>
