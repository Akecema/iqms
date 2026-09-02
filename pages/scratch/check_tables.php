<?php
include '../../db/db_connect.php';
echo "--- model_type_side ---\n";
$res = $db_con->query("DESCRIBE model_type_side");
while($row = $res->fetch_assoc()){
    print_r($row);
}
echo "\n--- part_side ---\n";
$res2 = $db_con->query("DESCRIBE part_side");
while($row = $res2->fetch_assoc()){
    print_r($row);
}
?>
