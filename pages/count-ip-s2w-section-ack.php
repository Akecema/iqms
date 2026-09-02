<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'system-status.php';
include '../shift.php';

if ($_POST['action'] == 'today') {

    $queryPending = "SELECT COUNT(*) AS total_pending 
                    FROM inspection_s2w_report s
                    LEFT JOIN inspection_records p ON s.rp_s2w_ir_id = p.ir_id
                    WHERE s.rp_s2w_status = '$s_pendAck_id' 
                    AND p.ir_shift = '$current_shift' 
                    AND p.shift_date = '$shift_date'";
    $rowPending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending));

    $queryCompl = "SELECT COUNT(*) AS total_completed 
                        FROM inspection_s2w_report s
                        LEFT JOIN inspection_records p ON s.rp_s2w_ir_id = p.ir_id
                        WHERE s.rp_s2w_status = '$s_completed_id' 
                        AND p.ir_shift = '$current_shift' 
                        AND p.shift_date = '$shift_date'";
    $rowCompl = mysqli_fetch_assoc(mysqli_query($db_con, $queryCompl));
    

    echo json_encode([
        'pending'   => $rowPending['total_pending'] ?? 0,
        'completed'  => $rowCompl['total_completed'] ?? 0
    ]);

}

if ($_POST['action'] == 'previous') {

    $queryPending = "SELECT COUNT(*) AS total_pending 
                    FROM inspection_s2w_report s
                    LEFT JOIN inspection_records p ON s.rp_s2w_ir_id = p.ir_id
                    WHERE s.rp_s2w_status = '$s_pendAck_id' 
                    AND p.shift_date < '$shift_date'";
    $rowPending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending));

    $queryCompl = "SELECT COUNT(*) AS total_completed 
                        FROM inspection_s2w_report s
                        LEFT JOIN inspection_records p ON s.rp_s2w_ir_id = p.ir_id
                        WHERE s.rp_s2w_status = '$s_completed_id' 
                        AND p.shift_date < '$shift_date'";
    $rowCompl = mysqli_fetch_assoc(mysqli_query($db_con, $queryCompl));
    

    echo json_encode([
        'pending'   => $rowPending['total_pending'] ?? 0,
        'completed'  => $rowCompl['total_completed'] ?? 0
    ]);

}

?>