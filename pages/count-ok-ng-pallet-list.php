<?php
include '../db/db_connect.php';
include 'system-status.php';

$group = $_POST['igroup'] ?? '';
$fd_status = $_POST['fd_status'] ?? '';
$fd_result = $_POST['fd_result'] ?? '';

// Set default to prevent undefined $query
$query = '';
$params = [];
$types = '';
  
$query = "SELECT ir_result FROM inspection_records WHERE inspect_group = ?";
$params = [$group];
$types = "i";


// Optional filters
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

