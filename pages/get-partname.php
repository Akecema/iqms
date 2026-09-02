<?php

include '../db/db_connect.php';

$part_no_id = $_POST['part_no_id'];

$sql = "SELECT matdet_id, bomdesc FROM material_details WHERE matdet_id = ?";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("i", $part_no_id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if ($row) {
    echo $row['bomdesc'];  // return plain text
    $tool = $row['bomdesc'];
} else {
    echo "";
}

?>
