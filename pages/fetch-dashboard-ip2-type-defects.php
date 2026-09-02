<?php
include "../system-header.php";
include "session-start.php";
include "../shift.php";
include "get-financial-year.php";

$typeids = isset($_POST['typeids']) ? $_POST['typeids'] : [];
$timeframe = $_POST['timeframe'] ?? 'day';
$currentYearTrend = date('Y', strtotime($shift_date));

$shift = $_POST['shift'] ?? 'ALL';
$shiftCondition = "";
if ($shift == 'D') {
    $shiftCondition = " AND S.ir_shift = 'D'";
} elseif ($shift == 'N') {
    $shiftCondition = " AND S.ir_shift = 'N'";
}

$date_condition = "1=1";
if ($timeframe == 'day') {
    $date_condition = "DATE(S.inspect_date) = CURDATE()";
} else if ($timeframe == 'week') {
    $date_condition = "YEARWEEK(S.inspect_date, 1) = YEARWEEK(CURDATE(), 1)";
} else if ($timeframe == 'month') {
    $date_condition = "MONTH(S.inspect_date) = MONTH(CURDATE()) AND YEAR(S.inspect_date) = YEAR(CURDATE())";
} else if ($timeframe == 'year') {
    $date_condition = "S.financial_yr = '$financialyr'";
}

$where_clause = "$date_condition AND S.ir_result = 'NG' $shiftCondition";
if (!empty($typeids) && !in_array('all', $typeids)) {
    $typeid_list = implode(',', array_map(function($id) use ($db_con) {
        return "'" . mysqli_real_escape_string($db_con, $id) . "'";
    }, $typeids));
    $where_clause .= " AND S.ir_type IN ($typeid_list)";
}

$query = "SELECT 
            T.defectname, 
            COUNT(D.defect_id) as total
          FROM inspection_records S 
          INNER JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id 
          INNER JOIN defect_type T ON T.defectid = D.defect_type 
          WHERE $where_clause
          GROUP BY T.defectid, T.defectname
          ORDER BY total ASC"; // ASC so the highest is at top in horizontal ApexChart if using bar with categories reversed, or we just sort desc and Apex does its thing. Apex usually displays from top to bottom.

$result = mysqli_query($db_con, $query);
$labels = [];
$counts = [];

if ($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['defectname'];
        $counts[] = (int)$row['total'];
    }
}

// If empty, return some placeholder if needed, or just empty arrays
echo json_encode([
    'labels' => $labels,
    'counts' => $counts
]);
?>
