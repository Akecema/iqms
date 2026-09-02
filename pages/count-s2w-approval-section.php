<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'system-status.php';
include '../shift.php';

$shift     = $_POST['shift'] ?? '';
$shift_date = $_POST['shift_date'] ?? '';

$statusCondition = "";

if ($session_role != 1) {
    $statusCondition = " AND S.rp_approver = '$session_id' ";
}

$queryPending = "SELECT COUNT(*) AS total_pending 
                FROM inspection_s2w_report s
                LEFT JOIN inspection_records p ON s.rp_s2w_ir_id = p.ir_id
                WHERE s.rp_s2w_status = '$s_pendApproval_id' 
                AND p.ir_shift = '$shift' 
                AND p.shift_date = '$shift_date'
                $statusCondition";
$rowPending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending));

$queryReview = "SELECT COUNT(*) AS total_approved 
                    FROM inspection_s2w_report s
                    LEFT JOIN inspection_records p ON s.rp_s2w_ir_id = p.ir_id
                    WHERE s.rp_s2w_status = '$s_pendAck_id' 
                    AND p.ir_shift = '$shift' 
                    AND p.shift_date = '$shift_date'
                    $statusCondition";
$rowReview = mysqli_fetch_assoc(mysqli_query($db_con, $queryReview));

$queryCompl = "SELECT COUNT(*) AS total_completed 
                    FROM inspection_s2w_report s
                    LEFT JOIN inspection_records p ON s.rp_s2w_ir_id = p.ir_id
                    WHERE s.rp_s2w_status = '$s_completed_id' 
                    AND p.ir_shift = '$shift' 
                    AND p.shift_date = '$shift_date'
                    $statusCondition";
$rowCompl = mysqli_fetch_assoc(mysqli_query($db_con, $queryCompl));

echo json_encode([
    'pending'   => $rowPending['total_pending'] ?? 0,
    'approved'  => $rowReview['total_approved'] ?? 0,
    'completed'  => $rowCompl['total_completed'] ?? 0
]);

?>