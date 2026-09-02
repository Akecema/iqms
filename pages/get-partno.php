<?php

include '../db/db_connect.php';

if (!empty($_POST['ir_id'])) {
    $ir_id = intval($_POST['ir_id']);

    $sql = "SELECT m.matdet_id, m.bom, m.bomdesc
            FROM material_details m
            INNER JOIN inspection_records i ON m.mathdr = i.ir_material
            WHERE i.ir_id = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("i", $ir_id);
    $stmt->execute();
    $res = $stmt->get_result();

    $options = "<option value=''>Part No</option>";
    while($r = $res->fetch_assoc()){
        $options .= "<option value='{$r['matdet_id']}'>{$r['bom']}</option>";
    }
    echo $options;
}
?>
