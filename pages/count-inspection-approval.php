<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'system-status.php';
include '../shift.php';

$shift     = $_POST['shift'] ?? '';
$shift_date = $_POST['shift_date'] ?? '';

$queryToday = "SELECT COUNT(*) AS total_pending 
                FROM inspection_records 
                WHERE ir_status = '$s_pendReview_id' 
                AND ir_shift = '$shift' 
                AND shift_date = '$shift_date'";
$rowReview = mysqli_fetch_assoc(mysqli_query($db_con, $queryToday));

$queryApproved = "SELECT COUNT(*) AS total_approved 
                FROM inspection_records 
                WHERE ir_status = '$s_reviewed_id' 
                AND ir_shift = '$shift' 
                AND shift_date = '$shift_date'";
$rowApproved = mysqli_fetch_assoc(mysqli_query($db_con, $queryApproved));

$queryCompleted = "SELECT COUNT(*) AS total_completed 
                FROM inspection_records 
                WHERE ir_status = '$s_completed_id' 
                AND ir_shift = '$shift' 
                AND shift_date = '$shift_date'";
$rowCompleted = mysqli_fetch_assoc(mysqli_query($db_con, $queryCompleted));

echo json_encode([
    'pending'   => $rowReview['total_pending'] ?? 0,
    'approved'  => $rowApproved['total_approved'] ?? 0,
    'completed' => $rowCompleted['total_completed'] ?? 0
]);

?>