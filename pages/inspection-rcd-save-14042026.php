<?php

ob_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

//in production
// error_reporting(E_ALL & ~E_NOTICE);

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$ir_id      = $_POST['ir_id'] ?? '';
$pallet_no  = $_POST['pallet'];
$result     = $_POST['result'];
$model_id   = $_POST['model'];
$type_id    = $_POST['type'];
$material_id= $_POST['material'];
$shift      = $_POST['shift'];

//create inspection group (group by material, model, type, shift, production date)
$sql_group = "SELECT inspect_group 
              FROM inspection_records 
              WHERE ir_model = ? AND ir_type = ? AND ir_material = ? AND ir_shift = ? AND shift_date = ?
              ORDER BY inspect_group DESC LIMIT 1";
$stmt = $db_con->prepare($sql_group);
$stmt->bind_param('iiiss', $model_id, $type_id, $material_id, $shift, $shift_date);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

    $stmt->bind_result($existing_group);
    $stmt->fetch();
    $inspect_group = $existing_group;  // Use existing group

} else {

    // No group exists — get max group and increment
    $sql_max = "SELECT MAX(inspect_group) FROM inspection_records";
    $result_max = $db_con->query($sql_max);
    $max_group = $result_max->fetch_row()[0] ?? 0;
    
    $inspect_group = $max_group + 1;
}
$stmt->close();

//Insert/Update Main inspection record
$sql = "INSERT INTO inspection_records (ir_model, ir_type, ir_material, ir_pallet_no, ir_result, ir_status, ir_shift, shift_date, inspect_group, inspect_date, created_by, created_date) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
$stmt = $db_con->prepare($sql);
$stmt->bind_param('iiiissssiss', $model_id, $type_id, $material_id, $pallet_no, $result, $s_new_id, $shift, $shift_date, $inspect_group, $shift_date,  $session_id);
$stmt->execute();
$new_id = $stmt->insert_id;
$success = $stmt->affected_rows > 0;

// Auto create folder for photo
// defect
$folder_new_d = __DIR__ . "/gallery/inspection/defect/" . $new_id;
if (!is_dir($folder_new_d)) mkdir($folder_new_d, 0777, true);

// comparison
$folder_new_c = __DIR__ . "/gallery/inspection/defect_compare/" . $new_id;
if (!is_dir($folder_new_c)) mkdir($folder_new_c, 0777, true);

echo json_encode(['success' => $success, 'ir_id' => $new_id ?? $ir_id, 'status' => $s_new_id]);

?>