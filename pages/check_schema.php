<?php
include '../db/db_connect.php';
$res = mysqli_query($db_con, "DESCRIBE material_header");
while($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}
?>
