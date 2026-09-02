<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'system-status.php';
include '../shift.php';

$shift     = $_POST['shift'] ?? '';
$shift_date = $_POST['shift_date'] ?? '';

// user role - if admin (1) list all, otherwise check authorization
if ($session_role == 1) {
    $role_reviewer = "Y";
    $role_approval = "Y";
} else {
    $sql = "SELECT S2W_reviewer, S2W_approver
            FROM user_authorization 
            WHERE staff_id = '$session_id'";
    $result = $db_con->query($sql);
    $row = $result->fetch_assoc();

    $role_reviewer = $row['S2W_reviewer'];  // Y or N
    $role_approval = $row['S2W_approver'];  // Y or N
}

// $sql = "
//         SELECT task
//         FROM user_authorization
//         WHERE staff_id = ?
//         AND section = 'PDI'
//         AND auto_status = 'AC'
//     ";

// $stmt = $db_con->prepare($sql);
// $stmt->bind_param("s", $session_id);
// $stmt->execute();
// $result = $stmt->get_result();

// $role_reviewer = 'N';
// $role_approval = 'N';

// while ($row = $result->fetch_assoc()) {
//     if ($row['task'] === 'S2W_reviewer') {
//         $role_reviewer = 'Y';
//     }
//     if ($row['task'] === 'S2W_approver') {
//         $role_approval = 'Y';
//     }
// }

// ---- INITIALIZE ----
$total_pending = 0;
$total_reviewed = 0;
$total_approved = 0;

// ---- ROLE-BASED LOGIC ----

// BOTH Reviewer + Approver → pending = 9 & 10
if ($role_reviewer === "Y" && $role_approval === "Y") {

    // Pending = 9 & 10
    $queryPending = "
        SELECT COUNT(*) AS total 
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status IN (9,10)
        AND p.ir_shift = '$shift'
        AND p.shift_date = '$shift_date'
    ";
    $total_pending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending))['total'];

    // Reviewed = ONLY 10
    $queryReview = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 10
        AND p.ir_shift = '$shift'
        AND p.shift_date = '$shift_date'
    ";
    $total_reviewed = mysqli_fetch_assoc(mysqli_query($db_con, $queryReview))['total'];

    // Approved = 4
    $queryApprove = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 4
        AND p.ir_shift = '$shift'
        AND p.shift_date = '$shift_date'
    ";
    $total_approved = mysqli_fetch_assoc(mysqli_query($db_con, $queryApprove))['total'];
}
else if ($role_reviewer === "Y") {
    // Reviewer only → pending = 9
    $queryPending = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 9
        AND p.ir_shift = '$shift'
        AND p.shift_date = '$shift_date'
    ";
    $total_pending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending))['total'];

    // Reviewer can see reviewed (status 10)
    $queryReview = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 10
        AND p.ir_shift = '$shift'
        AND p.shift_date = '$shift_date'
    ";
    $total_reviewed = mysqli_fetch_assoc(mysqli_query($db_con, $queryReview))['total'];

    $total_approved = 0; // reviewer cannot approve
}
else if ($role_approval === "Y") {
    // Approver only → pending = 10
    $queryPending = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 10
        AND p.ir_shift = '$shift'
        AND p.shift_date = '$shift_date'
    ";
    $total_pending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending))['total'];

    // $total_reviewed = 0; // approver not reviewer

    $queryReview = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 10
        AND p.ir_shift = '$shift'
        AND p.shift_date = '$shift_date'
    ";
    $total_reviewed = mysqli_fetch_assoc(mysqli_query($db_con, $queryReview))['total'];

    // Approved = 4
    $queryApprove = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 4
        AND p.ir_shift = '$shift'
        AND p.shift_date = '$shift_date'
    ";
    $total_approved = mysqli_fetch_assoc(mysqli_query($db_con, $queryApprove))['total'];
}
else {
    // no access → every total = 0
    $total_pending = 0;
    $total_reviewed = 0;
    $total_approved = 0;
}

echo json_encode([
    "pending" => $total_pending,
    "reviewed" => $total_reviewed,
    "approved" => $total_approved
]);

?>