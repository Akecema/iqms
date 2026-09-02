<?php
session_start();
include '../db/db_connect.php';
include 'system-status.php';
include 'session-login.php';
include '../shift.php';

$fd_model = $_POST['fd_model'] ?? '';
$fd_type = $_POST['fd_type'] ?? '';
$fd_material = $_POST['fd_material'] ?? '';
$fd_shift = $_POST['fd_shift'] ?? '';
$fd_status = $_POST['fd_status'] ?? '';
$fd_result = $_POST['fd_result'] ?? '';

// Set default to prevent undefined $query
$query = '';
$params = [];
$types = '';
  
$query = "SELECT ir_result FROM inspection_records WHERE ir_shift = '$current_shift' AND shift_date = '$shift_date' ";
$params = [];
$types = "";

if ($session_role == 4) {
    // Restrict to only their own records
   $query .= " AND created_by = '$session_id' ";
}

// Optional filters
if (!empty($fd_model)) {
    $query .= " AND ir_model = ?";
    $types .= "i";
    $params[] = $fd_model;
}

if (!empty($fd_type)) {
    $query .= " AND ir_type = ?";
    $types .= "i";
    $params[] = $fd_type;
}

if (!empty($fd_material)) {
    $query .= " AND ir_material = ?";
    $types .= "i";
    $params[] = $fd_material;
}

if (!empty($fd_shift)) {
    $query .= " AND ir_shift = ?";
    $types .= "s";
    $params[] = $fd_shift;
}

if (!empty($fd_status)) {
    $query .= " AND ir_status = ?";
    $types .= "i";
    $params[] = $fd_status;
}

if (!empty($fd_result)) {
    $query .= " AND ir_result = ?";
    $types .= "s";
    $params[] = $fd_result;
}

$stmt = $db_con->prepare($query);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
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

