<?php
include "../system-header.php";
include "session-start.php";
include "../shift.php"; // to get $shift_date context if needed, though we primarily use current year
include "get-financial-year.php";

$matids = isset($_POST['matids']) ? $_POST['matids'] : [];
$currentYearTrend = $financialyr;

$shift = $_POST['shift'] ?? 'ALL';
$shiftCondition = "";
if ($shift == 'D') {
    $shiftCondition = " AND ir_shift = 'D'";
} elseif ($shift == 'N') {
    $shiftCondition = " AND ir_shift = 'N'";
}

$where_clause = "WHERE financial_yr = '$currentYearTrend' AND ir_result IS NOT NULL $shiftCondition";
if (!empty($matids) && !in_array('all', $matids)) {
    $matid_list = implode(',', array_map('intval', $matids));
    $where_clause .= " AND ir_material IN ($matid_list)";
}

$queryOverviewTrend = "SELECT 
                    MONTH(inspect_date) as m_num,
                    SUM(CASE WHEN ir_result = 'OK' THEN 1 ELSE 0 END) as ok_count,
                    SUM(CASE WHEN ir_result = 'NG' THEN 1 ELSE 0 END) as ng_count
                  FROM inspection_records 
                  $where_clause
                  GROUP BY m_num
                  ORDER BY m_num";
$resOverviewTrend = mysqli_query($db_con, $queryOverviewTrend);

$trendOK = array_fill(0, 12, 0);
$trendNG = array_fill(0, 12, 0);

if ($resOverviewTrend) {
    while($row = mysqli_fetch_assoc($resOverviewTrend)) {
        $mNum = (int)$row['m_num'];
        // Map month number to index: Feb (2) -> 0, Mar (3) -> 1, ..., Jan (1) -> 11
        $mIndex = ($mNum == 1) ? 11 : $mNum - 2;
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

echo json_encode([
    'trendOK' => $trendOK,
    'trendNG' => $trendNG,
    'metrics' => [
        'total' => number_format($totalInspectedYear),
        'ok' => number_format($totalOKYear),
        'ng' => number_format($totalNGYear),
        'yield' => $yieldYear . '%'
    ]
]);
?>
