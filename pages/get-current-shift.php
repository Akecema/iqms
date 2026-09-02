<?php

include '../db/db_connect.php';
session_start();

$current_time = date("H:i:s");
$current_date = date("Y-m-d");

// Example: assuming `shift_detail` holds shift start/end time
$sql = "SELECT shiftdesc FROM shift_detail 
        WHERE 
            (timestart < timeend AND '$current_time' BETWEEN timestart AND timeend) 
         OR (timestart > timeend AND ('$current_time' >= timestart OR '$current_time' <= timeend))
        LIMIT 1";

$result = mysqli_query($db_con, $sql);
$row = mysqli_fetch_assoc($result);

echo json_encode(['shift' => $row ? $row['shiftdesc'] : "UNKNOWN"]);

?>
