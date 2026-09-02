<!-- System title -->
<?php include "../system-header.php";?>

<!-- Session start -->
<?php include "session-start.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo $syst_title; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="author" content="DexignZone">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/png" href="../icon/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="vendor/select2/css/select2.min.css">
    <link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link class="main-css" href="css/style.css" rel="stylesheet">
    <link class="main-css" href="css/add-style.css" rel="stylesheet">
    <link href="vendor/sweetalert2/sweetalert2.min.css" rel="stylesheet">
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
        .filter-card { padding: 22px; }
        .metric-card { padding: 22px; height: 100%; }
        .metric-label {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #70806c;
            font-weight: 700;
            margin-bottom: 10px;
        }
        .metric-value {
            font-size: 32px;
            line-height: 1;
            font-weight: 700;
            color: #183323;
            margin-bottom: 8px;
        }
        .metric-note { font-size: 13px; color: #7e877d; margin-bottom: 0; }
        .filter-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 16px;
            align-items: end;
        }
        .filter-grid label {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: #637064;
            margin-bottom: 8px;
        }
        .chart-card, .table-card { padding: 24px; }
        .section-title {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 18px;
        }
        .section-title h4 { margin-bottom: 4px; }
        .section-title p { margin-bottom: 0; color: #788478; font-size: 13px; }
        .insight-note {
            background: #f4f8f3;
            border: 1px solid #d7e4d2;
            border-radius: 14px;
            padding: 14px 16px;
            color: #35513d;
            font-size: 13px;
        }
        .inspector-table { width: 100%; border-collapse: separate; border-spacing: 0; }
        .inspector-table thead th {
            background: #f7faf6;
            color: #50604f;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            font-weight: 700;
            padding: 14px 12px;
            border-bottom: 1px solid #e8eee7;
        }
        .inspector-table tbody td {
            padding: 14px 12px;
            border-bottom: 1px solid #eef2ee;
            vertical-align: middle;
            color: #2f3b31;
            font-size: 13px;
        }
        .inspector-table tbody tr:hover { background: #fbfdfb; }
        .rank-badge {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: #183323;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }
        .accuracy-pill {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 700;
            color: #1b4025;
            background: #e5f4e8;
        }
        .empty-state {
            padding: 36px 20px;
            text-align: center;
            color: #768176;
            font-size: 14px;
            border: 1px dashed #d8e1d6;
            border-radius: 16px;
            background: #fbfdfb;
        }
        @media (max-width: 767px) {
            .report-hero, .filter-card, .chart-card, .table-card, .metric-card { border-radius: 16px; }
            .table-responsive { overflow-x: auto; }
            .metric-value { font-size: 28px; }
        }
    </style>
</head>
<body>
    <div id="preloader"><div></div></div>
    <div id="main-wrapper">
        <div class="nav-header"><?php include 'nav-hdr-logo.php'; ?></div>
        <div class="chatbox">
            <div class="chatbox-close"></div>
            <?php include 'nav-hdr-chat-box.php'; ?>
        </div>
        <div class="header">
            <div class="header-content"><?php include 'nav-hdr-top.php'; ?></div>
        </div>
        <div class="deznav">
            <div class="deznav-scroll"><?php include 'nav-left-sidebar.php'; ?></div>
        </div>
        <?php
        $f_fy = isset($_GET['f_fy']) && $_GET['f_fy'] !== '' ? mysqli_real_escape_string($db_con, $_GET['f_fy']) : $financialyr;
        $f_shift = isset($_GET['f_shift']) && $_GET['f_shift'] !== '' ? mysqli_real_escape_string($db_con, $_GET['f_shift']) : '';
        $f_from = isset($_GET['f_from']) && $_GET['f_from'] !== '' ? mysqli_real_escape_string($db_con, $_GET['f_from']) : '';
        $f_to = isset($_GET['f_to']) && $_GET['f_to'] !== '' ? mysqli_real_escape_string($db_con, $_GET['f_to']) : '';

        $shift_options = [];
        $shift_res = mysqli_query($db_con, "SELECT shiftshort, shiftdesc FROM shift_detail ORDER BY shiftshort ASC");
        if ($shift_res) {
            while ($shift_row = mysqli_fetch_assoc($shift_res)) {
                $shift_options[] = $shift_row;
            }
        }

        $where = [];
        $where[] = "I.financial_yr = '$f_fy'";
        $where[] = "(I.cancelled_date IS NULL OR I.cancelled_date = '0000-00-00 00:00:00')";
        if ($f_shift !== '') { $where[] = "I.ir_shift = '$f_shift'"; }
        if ($f_from !== '') { $where[] = "I.inspect_date >= '$f_from'"; }
        if ($f_to !== '') { $where[] = "I.inspect_date <= '$f_to'"; }
        $where_sql = implode(' AND ', $where);

        $sql = "SELECT
                    I.created_by AS inspector_id,
                    COALESCE(NULLIF(TRIM(E.short_name), ''), NULLIF(TRIM(E.staff_name), ''), I.created_by) AS inspector_name,
                    COUNT(DISTINCT I.ir_id) AS inspections_done,
                    COALESCE(SUM(COALESCE(D.defect_count, 0)), 0) AS defects_found,
                    SUM(
                        CASE
                            WHEN (
                                (I.reviewed_date IS NOT NULL AND I.reviewed_date <> '0000-00-00 00:00:00')
                                OR (I.approved_date IS NOT NULL AND I.approved_date <> '0000-00-00 00:00:00')
                                OR (I.returned_date IS NOT NULL AND I.returned_date <> '0000-00-00 00:00:00')
                            ) THEN 1 ELSE 0
                        END
                    ) AS rechecked_total,
                    SUM(
                        CASE
                            WHEN (
                                (I.reviewed_date IS NOT NULL AND I.reviewed_date <> '0000-00-00 00:00:00')
                                OR (I.approved_date IS NOT NULL AND I.approved_date <> '0000-00-00 00:00:00')
                            ) THEN 1 ELSE 0
                        END
                    ) AS accepted_rechecks,
                    SUM(
                        CASE
                            WHEN (I.returned_date IS NOT NULL AND I.returned_date <> '0000-00-00 00:00:00')
                            THEN 1 ELSE 0
                        END
                    ) AS returned_rechecks
                FROM inspection_records I
                LEFT JOIN employee_details E ON E.staff_id = I.created_by
                LEFT JOIN (
                    SELECT rcd_ir_id, COUNT(*) AS defect_count
                    FROM inspection_defect
                    GROUP BY rcd_ir_id
                ) D ON D.rcd_ir_id = I.ir_id
                WHERE $where_sql
                GROUP BY I.created_by, inspector_name
                ORDER BY inspections_done DESC, defects_found DESC, inspector_name ASC";

        $report_rows = [];
        $total_inspections = 0;
        $total_defects = 0;
        $total_rechecks = 0;
        $total_accepted = 0;

        $res = mysqli_query($db_con, $sql);
        if ($res) {
            while ($row = mysqli_fetch_assoc($res)) {
                $row['inspections_done'] = (int) $row['inspections_done'];
                $row['defects_found'] = (int) $row['defects_found'];
                $row['rechecked_total'] = (int) $row['rechecked_total'];
                $row['accepted_rechecks'] = (int) $row['accepted_rechecks'];
                $row['returned_rechecks'] = (int) $row['returned_rechecks'];
                $row['accuracy'] = $row['rechecked_total'] > 0 ? round(($row['accepted_rechecks'] / $row['rechecked_total']) * 100, 2) : null;
                $report_rows[] = $row;
                $total_inspections += $row['inspections_done'];
                $total_defects += $row['defects_found'];
                $total_rechecks += $row['rechecked_total'];
                $total_accepted += $row['accepted_rechecks'];
            }
        }

        $total_inspectors = count($report_rows);
        $average_accuracy = $total_rechecks > 0 ? round(($total_accepted / $total_rechecks) * 100, 2) : null;
        $top_inspector = $total_inspectors > 0 ? $report_rows[0]['inspector_name'] : '-';
        $chart_labels = [];
        $chart_data = [];
        foreach ($report_rows as $row) {
            $chart_labels[] = $row['inspector_name'];
            $chart_data[] = $row['inspections_done'];
        }
        ?>
        <div class="content-body">
            <div class="container-fluid">
                <div class="report-shell">
                    <div class="report-hero">
                        <h2>Inspector Performance Report</h2>
                        <p>Monitor inspections completed by each inspector, total defects captured, and recheck accuracy when reviewer feedback is available.</p>
                    </div>
                    <div class="filter-card">
                        <form method="GET">
                            <div class="filter-grid">
                                <div>
                                    <label for="f_fy">Financial Year</label>
                                    <input type="text" class="form-control" id="f_fy" name="f_fy" value="<?= htmlspecialchars($f_fy) ?>">
                                </div>
                                <div>
                                    <label for="f_shift">Shift</label>
                                    <select class="form-control" id="f_shift" name="f_shift">
                                        <option value="">All Shifts</option>
                                        <?php foreach ($shift_options as $shift_option): ?>
                                            <option value="<?= htmlspecialchars($shift_option['shiftshort']) ?>" <?= $f_shift === $shift_option['shiftshort'] ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($shift_option['shiftshort'] . ' - ' . $shift_option['shiftdesc']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div>
                                    <label for="f_from">From Date</label>
                                    <input type="date" class="form-control" id="f_from" name="f_from" value="<?= htmlspecialchars($f_from) ?>">
                                </div>
                                <div>
                                    <label for="f_to">To Date</label>
                                    <input type="date" class="form-control" id="f_to" name="f_to" value="<?= htmlspecialchars($f_to) ?>">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary w-100">Apply Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="metric-card">
                                <div class="metric-label">Inspectors</div>
                                <div class="metric-value"><?= number_format($total_inspectors) ?></div>
                                <p class="metric-note">Inspectors with at least one inspection in the selected range.</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="metric-card">
                                <div class="metric-label">Inspections Done</div>
                                <div class="metric-value"><?= number_format($total_inspections) ?></div>
                                <p class="metric-note">Total inspections attributed to the inspector who created the record.</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="metric-card">
                                <div class="metric-label">Defects Found</div>
                                <div class="metric-value"><?= number_format($total_defects) ?></div>
                                <p class="metric-note">Combined defect entries linked to the selected inspection records.</p>
                            </div>
                        </div>
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="metric-card">
                                <div class="metric-label">Average Accuracy</div>
                                <div class="metric-value"><?= $average_accuracy !== null ? number_format($average_accuracy, 2) . '%' : '-' ?></div>
                                <p class="metric-note">Calculated from rechecked inspections only.</p>
                            </div>
                        </div>
                    </div>
                    <div class="insight-note">
                        Accuracy is calculated as accepted rechecks divided by total rechecks. A recheck is counted when the inspection has been reviewed, approved, or returned.
                        <?php if ($top_inspector !== '-'): ?>
                            Top volume inspector for this selection: <strong><?= htmlspecialchars($top_inspector) ?></strong>.
                        <?php endif; ?>
                    </div>
                    <div class="chart-card">
                        <div class="section-title">
                            <div>
                                <h4 class="mb-0">Inspections Per Inspector</h4>
                                <p>Bar chart ranked from highest to lowest inspection volume.</p>
                            </div>
                        </div>
                        <?php if (!empty($report_rows)): ?>
                            <div id="inspectorPerformanceChart" style="min-height: 420px;"></div>
                        <?php else: ?>
                            <div class="empty-state">No inspection data found for the current filter selection.</div>
                        <?php endif; ?>
                    </div>
                    <div class="table-card">
                        <div class="section-title">
                            <div>
                                <h4 class="mb-0">Inspector Ranking</h4>
                                <p>Ranking table based on inspection volume, with defect totals and recheck accuracy.</p>
                            </div>
                        </div>
                        <?php if (!empty($report_rows)): ?>
                            <div class="table-responsive">
                                <table class="inspector-table">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Inspector</th>
                                            <th>Inspections Done</th>
                                            <th>Defects Found</th>
                                            <th>Rechecked</th>
                                            <th>Accepted</th>
                                            <th>Returned</th>
                                            <th>Accuracy</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($report_rows as $index => $row): ?>
                                            <tr>
                                                <td><span class="rank-badge"><?= $index + 1 ?></span></td>
                                                <td><?= htmlspecialchars($row['inspector_name']) ?></td>
                                                <td><?= number_format($row['inspections_done']) ?></td>
                                                <td><?= number_format($row['defects_found']) ?></td>
                                                <td><?= number_format($row['rechecked_total']) ?></td>
                                                <td><?= number_format($row['accepted_rechecks']) ?></td>
                                                <td><?= number_format($row['returned_rechecks']) ?></td>
                                                <td><?php if ($row['accuracy'] !== null): ?><span class="accuracy-pill"><?= number_format($row['accuracy'], 2) ?>%</span><?php else: ?>-<?php endif; ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php else: ?>
                            <div class="empty-state">No ranked inspectors to display yet.</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer"><?php include 'nav-footer.php'; ?></div>
    </div>
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="vendor/select2/js/select2.full.min.js"></script>
    <script src="js/plugins-init/select2-init.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/deznav-init.js"></script>
    <script src="vendor/sweetalert2/sweetalert2.min.js"></script>
    <script src="vendor/apexchart/apexchart.js"></script>
    <?php if (!empty($report_rows)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var chartOptions = {
                series: [{ name: 'Inspections', data: <?= json_encode($chart_data) ?> }],
                chart: { type: 'bar', height: 420, toolbar: { show: false } },
                colors: ['#d3bb1bff'],
                plotOptions: { bar: { borderRadius: 6, distributed: true, columnWidth: '48%' } },
                dataLabels: { enabled: true, offsetY: -18, style: { colors: ['#334137'] } },
                legend: { show: false },
                xaxis: {
                    categories: <?= json_encode($chart_labels) ?>,
                    labels: { rotate: -35, style: { fontSize: '12px', fontWeight: 500 } }
                },
                yaxis: { title: { text: 'Inspections' } },
                grid: { borderColor: '#e8eee7', strokeDashArray: 4 },
                tooltip: {
                    y: {
                        formatter: function (val) { return val + ' inspections'; }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector('#inspectorPerformanceChart'), chartOptions);
            chart.render();
        });
    </script>
    <?php endif; ?>
</body>
</html>
