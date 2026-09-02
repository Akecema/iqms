<?php
header('Content-Type: application/json');
session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$query = "SELECT S.sr_status 
          FROM inspection_sorting S
          LEFT JOIN inspection_records I ON S.sr_ir_id = I.ir_id
          WHERE I.ir_shift = ? AND I.shift_date = ?";

if ($session_role == 4) {
    // Restrict to only their own records
   $query .= " AND S.created_by = '$session_id' ";
}

$stmt = $db_con->prepare($query);
$stmt->bind_param("ss", $current_shift, $shift_date);
$stmt->execute();
$result = $stmt->get_result();

$total_draft = $total_pending = $total_approved = $total_completed = $total_cancelled = $total_returned = 0;

while ($row = $result->fetch_assoc()) {

    switch ($row['sr_status']) {
        case 4:  $total_approved++;  break;
        case 8:  $total_cancelled++; break;
        case 10: $total_pending++;   break;
        case 12: $total_returned++;  break;
        case 13: $total_draft++; break;
    }
}

echo json_encode([   
    'draft'     => $total_draft,
    'pending'   => $total_pending,
    'approved'  => $total_approved,
    'completed' => $total_completed,
    'cancelled' => $total_cancelled,
    'returned'  => $total_returned,
]);

exit;