<?php
session_start();
include '../db/db_connect.php';
include '../shift.php';

$model_ids = isset($_POST['model_ids']) ? $_POST['model_ids'] : [];
$shift_date = $_POST['shift_date'] ?? $shift_date;

$shift = $_POST['shift'] ?? 'ALL'; // D / N / ALL
$shiftCondition = "";
if ($shift === 'D') $shiftCondition = "AND S.ir_shift = 'D'";
elseif ($shift === 'N') $shiftCondition = "AND S.ir_shift = 'N'";
else $shiftCondition = "AND S.ir_shift IN ('D','N')";

$where_clause = "S.ir_result = 'NG' AND S.shift_date = '$shift_date' $shiftCondition";

if (!empty($model_ids) && !in_array('all', $model_ids)) {
    $model_id_list = implode(',', array_map(function($id) use ($db_con) {
        return "'" . mysqli_real_escape_string($db_con, $id) . "'";
    }, $model_ids));
    
    $query = "SELECT 
                T.defectname,
                COUNT(D.defect_id) as defect_total
              FROM inspection_records S 
              INNER JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id 
              INNER JOIN defect_type T ON T.defectid = D.defect_type 
              INNER JOIN material_header MH ON S.ir_material = MH.matid
              WHERE $where_clause AND MH.modelid IN ($model_id_list)
              GROUP BY T.defectid, T.defectname
              ORDER BY defect_total DESC";
} else {
    $query = "SELECT 
                T.defectname,
                COUNT(D.defect_id) as defect_total
              FROM inspection_records S 
              INNER JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id 
              INNER JOIN defect_type T ON T.defectid = D.defect_type 
              WHERE $where_clause 
              GROUP BY T.defectid, T.defectname
              ORDER BY defect_total DESC";
}

$result = mysqli_query($db_con, $query);
$maxPcs = 0;
$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
    if ($row['defect_total'] > $maxPcs) $maxPcs = $row['defect_total'];
}

$html = '';


if (!empty($data)) {
    foreach ($data as $item) {
        $currentPcs = (int)$item['defect_total'];
        $barWidth = ($maxPcs > 0) ? ($currentPcs / $maxPcs) * 100 : 0;
        $html .= '
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-1">
                    <span style="font-size: 12px; font-weight: 600; text-transform: uppercase;">
                        ' . htmlspecialchars($item['defectname']) . '
                    </span>
                    <span style="font-weight: 600; color: #abc66cff;">' . number_format($currentPcs) . '</span>
                </div>
                <div class="progress" style="height: 10px; background: rgba(255,255,255,0.2); border-radius: 50px;">
                    <div class="progress-bar" role="progressbar" 
                         style="width: ' . $barWidth . '%; background: #8da750; border-radius: 50px;">
                    </div>
                </div>
            </div>';
    }
} else {
    $html = '<p class="text-white opacity-50">No data available.</p>';
}

echo $html;
?>
