<?php

require '../db/db_connect.php';
include 'system-status.php';

if (isset($_POST['ir_id'])) {
    $ir_id = intval($_POST['ir_id']);

    // Check if related part exists in any of the three tables
    $exists = false;

    // Already create Sorting
    $sql1 = "SELECT sr_id FROM inspection_sorting WHERE sr_ir_id = ? and sr_status != ? LIMIT 1";
    $stmt1 = $db_con->prepare($sql1);
    $stmt1->bind_param("ii", $ir_id, $s_cancelled_id);
    $stmt1->execute();
    $stmt1->store_result();
    if ($stmt1->num_rows > 0) $exists = true;

    echo json_encode(["exists" => $exists]);
}
?>
