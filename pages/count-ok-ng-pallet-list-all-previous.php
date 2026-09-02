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
$fd_daterange= $_POST['fd_daterange'] ?? '';
$fd_status = $_POST['fd_status'] ?? '';
$fd_result = $_POST['fd_result'] ?? '';

// Set default to prevent undefined $query
$query = '';
$params = [];
$types = '';

if ($current_shift == 'D') {        
    // previous = all before today
    $sql_prev = "WHERE shift_date < '$shift_date'";

} else {
    // current = today Night
    // previous = all before today Night (including today's Day)
    $sql_prev = "WHERE (shift_date < '$shift_date') OR (shift_date = '$shift_date' AND ir_shift = 'D')";
}

$query = "SELECT ir_result FROM inspection_records ".$sql_prev;
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
if (!empty($fd_daterange)) {
    // split by hyphen or en-dash with optional spaces
    $parts = preg_split('/\s*[-–]\s*/', trim($fd_daterange));
    if (count($parts) === 2) {
        $d1 = trim($parts[0]);
        $d2 = trim($parts[1]);

        // try d/m/Y first, then d-m-Y
        $s1 = DateTime::createFromFormat('d/m/Y', $d1) ?: DateTime::createFromFormat('d-m-Y', $d1);
        $s2 = DateTime::createFromFormat('d/m/Y', $d2) ?: DateTime::createFromFormat('d-m-Y', $d2);

        if ($s1 && $s2) {
            $start_date = $s1->format('Y-m-d');
            $end_date   = $s2->format('Y-m-d');

            // BETWEEN is inclusive on both ends; if shift_date has time, prefer >= and < next day.
            $query  .= " AND DATE(shift_date) BETWEEN ? AND ? ";
            $types  .= "ss";
            $params[] = $start_date;
            $params[] = $end_date;          // ✅ push second value separately
            // or: array_push($params, $start_date, $end_date);
        }
    }
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

