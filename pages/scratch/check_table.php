<?php
include '../db/db_connect.php';
$res = $db_con->query("DESCRIBE model_type_side");
while($row = $res->fetch_assoc()){
    print_r($row);
}
?>
