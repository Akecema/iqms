<?php
session_start();
include '../db/db_connect.php';
include '../shift.php';

$model_ids = isset($_POST['model_ids']) ? $_POST['model_ids'] : [];
$shift_date = $_POST['shift_date'] ?? $shift_date;

$shift = $_POST['shift'] ?? 'ALL'; // D / N / ALL
$shiftCondition = "";
if ($shift === 'D') $shiftCondition = "AND ir.ir_shift = 'D'";
elseif ($shift === 'N') $shiftCondition = "AND ir.ir_shift = 'N'";
else $shiftCondition = "AND ir.ir_shift IN ('D','N')";

$where_clause = "1=1";
if (!empty($model_ids) && !in_array('all', $model_ids)) {
    $model_id_list = implode(',', array_map(function($id) use ($db_con) {
        return "'" . mysqli_real_escape_string($db_con, $id) . "'";
    }, $model_ids));
    $where_clause .= " AND mh.modelid IN ($model_id_list)";
}

$queryDefectBySide = "SELECT 
                        mts.typecode, mts.typemodel, mts.typeside,
                        COUNT(ir.ir_id) as total_inspected,
                        SUM(CASE WHEN ir.ir_result = 'NG' THEN 1 ELSE 0 END) as defect_count,
                        IFNULL(ROUND((SUM(CASE WHEN ir.ir_result = 'NG' THEN 1 ELSE 0 END) / NULLIF(COUNT(ir.ir_id), 0)) * 100, 1), 0) as defect_rate
                    FROM model_type_side mts
                    LEFT JOIN material_header mh ON mts.typeside_id = mh.typeside_id
                    LEFT JOIN inspection_records ir ON mh.matid = ir.ir_material AND ir.shift_date = '$shift_date'
                    WHERE $where_clause $shiftCondition
                    GROUP BY mts.typeside_id, mts.typecode";

$result = mysqli_query($db_con, $queryDefectBySide);
$html = '';

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $rate = $row['defect_rate'] ?? 0;
        $html .= '
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span style="font-weight: 500; font-size: 0.9rem; color : #e4e7e4ff;">' . htmlspecialchars($row['typemodel']) . ' ' . htmlspecialchars($row['typeside']) . '</span>
                    <span style="font-weight: 700; font-size: 0.9rem; color : #e4e7e4ff;">' . $rate . '%</span>
                </div>
                <div class="progress" style="height: 12px; background: #d5d6d5ff; border-radius: 10px;" 
                     data-bs-toggle="tooltip" data-bs-placement="top" 
                     title="NG : ' . $row['defect_count'] . ' / Total : ' . $row['total_inspected'] . '">
                    <div class="progress-bar" role="progressbar" 
                         style="width: ' . $rate . '%; background: #8DA750; border-radius: 10px; transition: width 0.5s;" 
                         aria-valuenow="' . $rate . '" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
            </div>';
    }
} else {
    $html = '<p class="text-white opacity-50">No data available.</p>';
}

echo $html;
?>
