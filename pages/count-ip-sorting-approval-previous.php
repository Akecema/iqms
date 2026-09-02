<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'system-status.php';
include '../shift.php';

$shift     = $_POST['shift'] ?? '';
$shift_date = $_POST['shift_date'] ?? '';

$queryPending = "SELECT COUNT(*) AS total_pending 
                 FROM inspection_sorting s
                 LEFT JOIN inspection_records p ON s.sr_ir_id = p.ir_id
                 WHERE s.sr_status = '$s_pendReview_id' 
                 AND p.shift_date != '$shift_date'";
$rowPending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending));

$queryReview = "SELECT COUNT(*) AS total_approved 
                FROM inspection_sorting s
                LEFT JOIN inspection_records p ON s.sr_ir_id = p.ir_id
                WHERE s.sr_status = '$s_reviewed_id' 
                AND p.shift_date != '$shift_date'";
$rowReview = mysqli_fetch_assoc(mysqli_query($db_con, $queryReview));

echo json_encode([
    'pending'   => $rowPending['total_pending'] ?? 0,
    'approved'  => $rowReview['total_approved'] ?? 0
]);

?>