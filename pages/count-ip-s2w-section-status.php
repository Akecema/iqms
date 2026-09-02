<?php
header('Content-Type: application/json');
session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$query = " SELECT S.s2w_report_status
            FROM inspection_s2w AS S
            LEFT JOIN inspection_records I ON S.s2w_ir_id = I.ir_id
            LEFT JOIN related_departments R ON S.s2w_send_to = R.rd_dept_id
            WHERE R.mast_dept_id = ?                   
            AND I.ir_shift = ?
            AND I.shift_date = ? ";

$stmt = $db_con->prepare($query);
$stmt->bind_param("iss", $stf_departmentID, $current_shift, $shift_date);
$stmt->execute();
$result = $stmt->get_result();

$total_new = $total_pending = $total_approved = 0;

while ($row = $result->fetch_assoc()) {

    switch ($row['s2w_report_status']) {
        case 4:  $total_approved++;  break;
        case 10: $total_pending++;   break;
        case 1: $total_new++; break;
    }
}

echo json_encode([   
    'new'     => $total_new,
    'pending'   => $total_pending,
    'approved'  => $total_approved,
]);

exit;