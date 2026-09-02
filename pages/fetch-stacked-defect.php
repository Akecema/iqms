<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
include 'get-financial-year.php';

header('Content-Type: application/json');

$type = $_POST['type'] ?? 'day';
$shift = $_POST['shift'] ?? 'ALL';
$shift_date = $_POST['shift_date'] ?? date('Y-m-d');

$where_clause = "";
$where_shift = "";

if ($shift === 'D') {
    $where_shift = "AND ir.ir_shift = 'D'";

} elseif ($shift === 'N') {
    $where_shift = "AND ir.ir_shift = 'N'";

} else { // ALL
    $where_shift = "AND ir.ir_shift IN ('D','N')";
}

switch ($type) {
    case 'day':
        $where_clause = "DATE(ir.inspect_date) = CURDATE()";
        break;
    case 'week':
        $where_clause = "YEARWEEK(ir.inspect_date, 1) = YEARWEEK(CURDATE(), 1)";
        break;
    case 'month':
        $where_clause = "YEAR(ir.inspect_date) = YEAR(CURDATE()) AND MONTH(ir.inspect_date) = MONTH(CURDATE())";
        break;
    case 'year':
        $where_clause = "ir.financial_yr = '$financialyr'";
        break;
    case 'all':
        $where_clause = "1=1";
        break;
}

$result_filter = $_POST['result'] ?? 'OK';

// 1. Get all active models
$resModels = mysqli_query($db_con, "SELECT model_id, model FROM model_hdr WHERE model_status = 'AC' ORDER BY model ASC");
$stackedCategories = [];
$modelIndexMap = [];
$modelCount = 0;
while ($row = mysqli_fetch_assoc($resModels)) {
    $stackedCategories[] = $row['model'];
    $modelIndexMap[$row['model_id']] = $modelCount++;
}

// 2. Get all active model types
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

// 3. Fetch defect/ok counts based on filter
$queryDefects = "SELECT 
                    m_hdr.modelid,
                    m_hdr.typeid,
                    COUNT(ir.ir_id) as count
                FROM inspection_records ir
                JOIN material_header m_hdr ON ir.ir_material = m_hdr.matid
                WHERE ir.ir_result = '$result_filter' 
                AND $where_clause
                $where_shift
                GROUP BY m_hdr.modelid, m_hdr.typeid";

$resDefects = mysqli_query($db_con, $queryDefects);
while ($row = mysqli_fetch_assoc($resDefects)) {
    $mid = $row['modelid'];
    $tid = $row['typeid'];
    if (isset($modelIndexMap[$mid]) && isset($typeMatrix[$tid])) {
        $stackedSeries[$typeMatrix[$tid]]['data'][$modelIndexMap[$mid]] = (int)$row['count'];
    }
}

// 4. Fetch summary statistics based on filter
$queryStats = "SELECT 
                    COUNT(ir.ir_id) as total,
                    SUM(CASE WHEN ir.ir_result = 'OK' THEN 1 ELSE 0 END) as ok_count,
                    SUM(CASE WHEN ir.ir_result = 'NG' THEN 1 ELSE 0 END) as ng_count,
                    SUM(CASE WHEN (ir.ir_status = 1 OR ir.ir_status = 13) THEN 1 ELSE 0 END) as in_progress,
                    SUM(CASE WHEN (ir.ir_status IN(9) OR ir.ir_sorting_status = 9 OR ir.ir_s2w_status IN (9,10) OR ir.ir_s2w_rp_status = 10 OR ir.ir_s2w_ack_status = 14) THEN 1 ELSE 0 END) as pending,
                    SUM(CASE WHEN ir.ir_status = 5 THEN 1 ELSE 0 END) as completed,
                    SUM(CASE WHEN ir.ir_s2w_ack_status IN (12,16) THEN 1 ELSE 0 END) as return_val
                FROM inspection_records ir
                WHERE $where_clause
                $where_shift";

$resStats = mysqli_query($db_con, $queryStats);
$rowStats = mysqli_fetch_assoc($resStats);

$totalCount = (int)($rowStats['ok_count'] + $rowStats['ng_count']); // Use only results found
$okCount = (int)$rowStats['ok_count'];
$ngCount = (int)$rowStats['ng_count'];
$yieldRate = ($totalCount > 0) ? round(($okCount / $totalCount) * 100, 1) : 0;

echo json_encode([
    'categories' => $stackedCategories,
    'series' => $stackedSeries,
    'stats' => [
        'total' => number_format($totalCount),
        'ok' => number_format($okCount),
        'ng' => number_format($ngCount),
        'yield' => $yieldRate . '%',
        'in_progress' => (int)($rowStats['in_progress'] ?? 0),
        'pending' => (int)($rowStats['pending'] ?? 0),
        'completed' => (int)($rowStats['completed'] ?? 0),
        'return' => (int)($rowStats['return_val'] ?? 0)
    ]
]);
