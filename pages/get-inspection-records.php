<?php

include '../db/db_connect.php';
include '../shift.php';
include 'system-status.php';

$model = $_POST['model'];
$type = $_POST['type'];
$material = $_POST['material'];
$shift = $_POST['shift'];
$shift_date = $_POST['shift_date'] ?? $shift_date; // Prefer AJAX, else use shift.php

$sql = "SELECT r.ir_id, r.ir_pallet_no AS pallet_no, r.ir_result AS result , r.ir_status AS status,
            (SELECT COUNT(*) FROM inspection_defect d WHERE d.rcd_ir_id = r.ir_id) AS defect_count
        FROM inspection_records r
        WHERE r.ir_model = ? AND r.ir_type = ? AND r.ir_material = ? AND r.ir_shift = ? and r.shift_date = ? and r.ir_status != $s_cancelled_id
        ORDER BY r.ir_pallet_no ASC";

$stmt = $db_con->prepare($sql);
$stmt->bind_param("sssss", $model, $type, $material, $shift, $shift_date);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {

    $row['has_defect'] = ($row['defect_count'] > 0); // true/false
    $data[] = $row;
}
file_put_contents('debugxxX.log', print_r($data, true), FILE_APPEND);
echo json_encode($data);

?>