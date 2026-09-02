<?php

include 'db/db_connect.php';

set_time_limit(0);


$upd = "SELECT staff_id FROM employee_details";
$stm_upd = $db_con->prepare($upd);

// Check if the prepare statement was successful
if ($stm_upd === false) {
    die('Error in preparing SQL statement: ' . $db_con->error);
}

$stm_upd->execute();
$rst_upd = $stm_upd->get_result();

$staff_ids = [];
while ($row_upd = mysqli_fetch_array($rst_upd)) {
    $staff_ids[] = $db_con->real_escape_string($row_upd['staff_id']); // Escape the staff_id as a string
}

// Check if there are any staff IDs to process
if (!empty($staff_ids)) {
    // Create a string of comma-separated staff IDs for the IN clause
    $staff_ids_str = "'" . implode("','", $staff_ids) . "'"; // Ensure proper string formatting for SQL

    // Perform the deletion in one query
    $del = "DELETE FROM user_role WHERE staff_id NOT IN ($staff_ids_str)";
    
    $upd_del = $db_con->prepare($del);
    
    // Check if the prepare statement for DELETE query was successful
    if ($upd_del === false) {
        die('Error in preparing DELETE SQL statement: ' . $db_con->error);
    }
    
    $upd_del->execute();
} else {
    echo "No valid staff IDs found to process.";
}



?>