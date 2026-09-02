<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';

header('Content-Type: application/json');

$type = $_POST['type'] ?? 'day';
$shift_date = $_POST['shift_date'] ?? date('Y-m-d');

$where_clause = "";
switch ($type) {
    case 'day':
        $where_clause = "ir.shift_date = '$shift_date'";
        break;
    case 'week':
        $where_clause = "ir.shift_date >= DATE_SUB('$shift_date', INTERVAL 6 DAY) AND ir.shift_date <= CURDATE()";
        break;
    case 'month':
        $where_clause = "YEAR(ir.shift_date) = YEAR('$shift_date') AND MONTH(ir.shift_date) = MONTH('$shift_date')";
        break;
    case 'year':
        $where_clause = "YEAR(ir.shift_date) = YEAR(CURDATE())";
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
                WHERE ir.ir_result = '$result_filter' AND $where_clause
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
                    SUM(CASE WHEN ir.ir_result = 'NG' THEN 1 ELSE 0 END) as ng_count
                FROM inspection_records ir
                WHERE $where_clause";

$resStats = mysqli_query($db_con, $queryStats);
$rowStats = mysqli_fetch_assoc($resStats);

$totalCount = (int)$rowStats['total'];
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
        'yield' => $yieldRate . '%'
    ]
]);
