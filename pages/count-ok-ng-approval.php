<?php
include '../db/db_connect.php';
include 'system-status.php';

$action = $_POST['action'] ?? '';
$shift = $_POST['shift'] ?? '';
$shift_date = $_POST['shift_date'] ?? '';
$model_id = $_POST['model'] ?? '';
$type_id = $_POST['type'] ?? '';
$material_id = $_POST['material'] ?? '';

// Set default to prevent undefined $query
$query = '';
$params = [];
$types = '';

if($action == 'fetch_pending')
{    
    $query = "SELECT ir_result FROM inspection_records WHERE ir_status = ? AND ir_shift = ? AND shift_date = ?";
    $params = [$s_pendReview_id, $shift, $shift_date];
    $types = "iss";
}
elseif ($action == 'fetch_approved')
{    
    $query = "SELECT ir_result FROM inspection_records WHERE ir_status = ?  AND ir_shift = ? AND shift_date = ?";
    $params = [$s_reviewed_id, $shift, $shift_date];
    $types = "iss";
}
elseif ($action == 'fetch_completed')
{    
    $query = "SELECT ir_result FROM inspection_records WHERE ir_status = ? AND ir_shift = ? AND shift_date = ?";
    $params = [$s_completed_id, $shift, $shift_date];
    $types = "iss";
}

// Optional filters
if (!empty($model_id)) {
    $query .= " AND ir_model = ?";
    $types .= "i";
    $params[] = $model_id;
}
if (!empty($type_id)) {
    $query .= " AND ir_type = ?";
    $types .= "i";
    $params[] = $type_id;
}
if (!empty($material_id)) {
    $query .= " AND ir_material = ?";
    $types .= "i";
    $params[] = $material_id;
}

$stmt = $db_con->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$total_ok = 0;
$total_ng = 0;

while ($row = $result->fetch_assoc()) {

    $result_val = strtoupper(trim($row['ir_result']));

    if ($result_val === 'OK') $total_ok++;
    elseif ($result_val === 'NG') $total_ng++;
}

echo json_encode([
    'ok' => $total_ok,
    'ng' => $total_ng
]);

