<?php
include '../db/db_connect.php';
include '../shift.php'; 

$model_id = $_POST['model'];
$type_id = $_POST['type'];
$material_id = $_POST['material'];
$shift = $_POST['shift'];

// Get current shift
$current_time = date("H:i:s");
$current_date = date("Y-m-d");

$sql = "SELECT MAX(ir_pallet_no) AS latest_pallet FROM inspection_records 
                WHERE ir_model = ? AND ir_type = ? AND ir_material = ? AND ir_shift = ? and shift_date = ? ";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("sssss", $model_id, $type_id, $material_id, $shift, $shift_date);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

echo json_encode([
    'latest_pallet' => $row['latest_pallet']
]);

?>