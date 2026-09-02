<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'system-status.php';
include '../shift.php';

$shift     = $_POST['shift'] ?? '';
$shift_date = $_POST['shift_date'] ?? '';

//user role - as reviewer or approver
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

// $roles = getUserRoles($db_con, $session_id, 'PDI');

// $role_reviewer = in_array('S2W_reviewer', $roles) ? 'Y' : 'N';
// $role_approval = in_array('S2W_approver', $roles) ? 'Y' : 'N';


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

// ---- INITIALIZE ----
$total_pending = 0;
$total_reviewed = 0;
$total_approved = 0;

// ---- ROLE-BASED LOGIC ----

// BOTH Reviewer + Approver → pending = 9 & 10
if ($role_reviewer && $role_approval) {

    $processCondition = "(process IN ('review', 'approval'))";

    $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' AND task = 'S2W' AND $processCondition";
    $resDelay = mysqli_query($db_con, $delay_sql);
    $rowDelay = mysqli_fetch_assoc($resDelay);
    $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

    // Compute allowed date 
    //use allowed date combine with production date and delay days
    //for delay date combine with both shift (D/N)
    $todayDate = date('Y-m-d');
    $allowedDate = date('Y-m-d', strtotime("-$delay_day days"));

    // Pending = 9 & 10
    $queryPending = "
        SELECT COUNT(*) AS total 
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status IN (9,10)
        AND p.shift_date < '$todayDate'";
    $total_pending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending))['total'];

    // Reviewed = ONLY 10
    $queryReview = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 10
        AND p.shift_date < '$todayDate'";
    $total_reviewed = mysqli_fetch_assoc(mysqli_query($db_con, $queryReview))['total'];

    // Approved = 4
    $queryApprove = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 4
        AND p.shift_date < '$todayDate'";
    $total_approved = mysqli_fetch_assoc(mysqli_query($db_con, $queryApprove))['total'];

}
else if ($role_reviewer === "Y") {

    $processCondition = "(process  = 'review' ";

    $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' AND task = 'S2W' AND $processCondition";
    $resDelay = mysqli_query($db_con, $delay_sql);
    $rowDelay = mysqli_fetch_assoc($resDelay);
    $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

    // Compute allowed date 
    //use allowed date combine with production date and delay days
    //for delay date combine with both shift (D/N)
    $todayDate = date('Y-m-d');
    $allowedDate = date('Y-m-d', strtotime("-$delay_day days"));

    // Reviewer only → pending = 9
    $queryPending = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 9
        AND p.shift_date < '$todayDate'";
    $total_pending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending))['total'];

    // Reviewer can see reviewed (status 10)
    $queryReview = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 10
        AND p.shift_date < '$todayDate'";
    $total_reviewed = mysqli_fetch_assoc(mysqli_query($db_con, $queryReview))['total'];

    $total_approved = 0; // reviewer cannot approve

}
else if ($role_approval === "Y") {

    $processCondition = "(process = 'approval'";

    $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' AND task = 'S2W' AND $processCondition";
    $resDelay = mysqli_query($db_con, $delay_sql);
    $rowDelay = mysqli_fetch_assoc($resDelay);
    $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

    // Compute allowed date 
    //use allowed date combine with production date and delay days
    //for delay date combine with both shift (D/N)
    $todayDate = date('Y-m-d');
    $allowedDate = date('Y-m-d', strtotime("-$delay_day days"));

    // Approver only → pending = 10
    $queryPending = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 10
        AND p.shift_date < '$todayDate'";
    $total_pending = mysqli_fetch_assoc(mysqli_query($db_con, $queryPending))['total'];

    $total_reviewed = 0; // approver not reviewer

    // Approved = 4
    $queryApprove = "
        SELECT COUNT(*) AS total
        FROM inspection_s2w s
        LEFT JOIN inspection_records p ON s.s2w_ir_id = p.ir_id
        WHERE s.s2w_status = 4
        AND p.shift_date < '$todayDate'";
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