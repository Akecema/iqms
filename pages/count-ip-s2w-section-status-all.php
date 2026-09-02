<?php
header('Content-Type: application/json');
session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

if ($_POST['action'] == 'today') {

    $query = "SELECT S.rp_s2w_status 
            FROM inspection_s2w_report S
            LEFT JOIN inspection_records I ON S.rp_s2w_ir_id = I.ir_id
            WHERE I.ir_shift = ? AND I.shift_date = ?";

    if ($session_role == 4) {
        // Restrict to only their own records
        $query .= " AND S.created_by = '$session_id' ";
    }
    else if ($session_role == 3) {
        // Restrict to only their own records
        $query .= " AND S.rp_approver = '$session_id' ";
    }

    $stmt = $db_con->prepare($query);
    $stmt->bind_param("ss", $current_shift, $shift_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_draft =$total_completed = $total_pending = $total_approved = $total_completed = $total_cancelled = $total_returned = 0;

    while ($row = $result->fetch_assoc()) {

        switch ($row['rp_s2w_status']) {
            case 4:  $total_approved++;  break;
            case 5:  $total_completed++;  break;
            case 8:  $total_cancelled++; break;
            case 10: $total_pending++;   break;
            case 12: $total_returned++;  break;
            case 13: $total_draft++; break;
        }
    }

    echo json_encode([   
        'draft'     => $total_draft,
        'completed' => $total_completed,
        'pending'   => $total_pending,
        'approved'  => $total_approved,
        'completed' => $total_completed,
        'cancelled' => $total_cancelled,
        'returned'  => $total_returned,
    ]);

}

if ($_POST['action'] == 'previous') {

     $query = "SELECT S.rp_s2w_status 
            FROM inspection_s2w_report S
            LEFT JOIN inspection_records I ON S.rp_s2w_ir_id = I.ir_id
            WHERE I.shift_date < ?";

    if ($session_role == 4) {
        // Restrict to only their own records
        $query .= " AND S.created_by = '$session_id' ";
    }
    else if ($session_role == 3) {
        // Restrict to only their own records
        $query .= " AND S.rp_approver = '$session_id' ";
    }

    $stmt = $db_con->prepare($query);
    $stmt->bind_param("s", $shift_date);
    $stmt->execute();
    $result = $stmt->get_result();

    $total_draft =$total_completed = $total_pending = $total_approved = $total_completed = $total_cancelled = $total_returned = 0;

    while ($row = $result->fetch_assoc()) {

        switch ($row['rp_s2w_status']) {
            case 4:  $total_approved++;  break;
            case 5:  $total_completed++;  break;
            case 8:  $total_cancelled++; break;
            case 10: $total_pending++;   break;
            case 12: $total_returned++;  break;
            case 13: $total_draft++; break;
        }
    }

    echo json_encode([   
        'draft'     => $total_draft,
        'completed' => $total_completed,
        'pending'   => $total_pending,
        'approved'  => $total_approved,
        'completed' => $total_completed,
        'cancelled' => $total_cancelled,
        'returned'  => $total_returned,
    ]);

}

exit;