<?php
header('Content-Type: application/json');
session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$query = "SELECT ir_result, ir_status FROM inspection_records WHERE ir_shift = ? AND shift_date = ?";

if ($session_role == 4) {
    // Restrict to only their own records
   $query .= " AND created_by = '$session_id' ";
}

$stmt = $db_con->prepare($query);
$stmt->bind_param("ss", $current_shift, $shift_date);
$stmt->execute();
$result = $stmt->get_result();

$total_ok = $total_ng = 0;
$total_new = $total_pending = $total_approved = $total_completed = $total_cancelled = $total_returned = 0;

while ($row = $result->fetch_assoc()) {
    if ($row['ir_result'] === 'OK') $total_ok++;
    elseif ($row['ir_result'] === 'NG') $total_ng++;

    switch ($row['ir_status']) {
        case 1:  $total_new++;       break;
        case 9:  $total_pending++;   break;
        case 4:  $total_approved++;  break;
        case 5:  $total_completed++; break;
        case 8:  $total_cancelled++; break;
        case 12: $total_returned++;  break;
    }
}

echo json_encode([
    'ok'        => $total_ok,
    'ng'        => $total_ng,
    'new'       => $total_new,
    'pending'   => $total_pending,
    'approved'  => $total_approved,
    'completed' => $total_completed,
    'cancelled' => $total_cancelled,
    'returned'  => $total_returned,
]);

exit;