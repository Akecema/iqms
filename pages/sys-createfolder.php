<?php


require '../db/db_connect.php';

$stmt = $db_con->prepare("
        SELECT matid
        FROM material_header
        WHERE modelcode = 'D74A'
    ");
//$stmt->bind_param("ii", $ir_id, $sr_id);
$stmt->execute();
$res = $stmt->get_result();

while($row = $res->fetch_assoc()) {

    $matid = $row['matid'];

    $base = "gallery/model/D74A/$matid";

    if(!is_dir($base)){
        mkdir($base, 0775, true);
    }

    // // define subfolders
    // $subfolders = [
    //     "$base/member",
    //     "$base/apron",
    //     "$base/floor"
    // ];

    // // create each one
    // foreach($subfolders as $dir){

    //     if(!is_dir($dir)){
    //         mkdir($dir, 0775, true);
    //     }
    // }

}

?>