<?php
session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include '../shift.php';
include 'system-status.php';

$model_id   = $_POST['model']   ?? '';
$type_id    = $_POST['type']    ?? '';
$material_id= $_POST['material']?? '';
$shift      = $_POST['shift']   ?? '';

// Basic guard
if (!$model_id || !$type_id || !$material_id || !$shift) {
  echo json_encode(['rows'=>[], 'error'=>'missing_params']);
  exit;
}

$sql = "
  SELECT
    ir.ir_id,
    ir.ir_pallet_no,
    ir.ir_result,
    ir.ir_status,
    ir.ir_docno,
    DATE_FORMAT(ir.prod_date,'%d-%m-%Y') AS prod_date,
    COALESCE(d.cnt,0) AS defect_count
  FROM inspection_records ir
  LEFT JOIN (
    SELECT rcd_ir_id, COUNT(*) AS cnt
    FROM inspection_defect
    GROUP BY rcd_ir_id
  ) d ON d.rcd_ir_id = ir.ir_id
  WHERE ir.ir_model = ?
    AND ir.ir_type = ?
    AND ir.ir_material = ?
    AND ir.ir_shift = ?
    AND ir.shift_date = ? 
    AND ir.ir_status != $s_cancelled_id
  ORDER BY ir.ir_pallet_no ASC
";

$stmt = $db_con->prepare($sql);
$stmt->bind_param("iiiss", $model_id, $type_id, $material_id, $shift, $shift_date);
$stmt->execute();
$result = $stmt->get_result();

$rows = [];
while ($row = $result->fetch_assoc()) {
  $row['has_defect'] = ((int)$row['defect_count'] > 0);
  $rows[] = $row;
}

echo json_encode(['rows'=>$rows]);

?>