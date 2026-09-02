<?php

include '../db/db_connect.php';
include '../shift.php';

$ir_id = $_POST['ir_id'] ?? '';

$data = [];

if ($ir_id) {
    // Get defect records for this inspection
    $sql = "
        SELECT d.defect_id, d.rcd_ir_id, d.defect_type, d.defect_area, t.defectname, r.ir_pallet_no, r.ir_result
        FROM inspection_defect d
        LEFT JOIN defect_type t ON d.defect_type = t.defectid
        LEFT JOIN inspection_records r ON d.rcd_ir_id = r.ir_id
        WHERE d.rcd_ir_id = ?
    ";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($defect = $res->fetch_assoc()) {

        $defect_id = $defect['defect_id'];

        $base_path_def = 'gallery/defect/';
        $base_path_comp = 'gallery/defect_compare/';

        // Get defect photos for this defect
        $photos = [];
        $stmt2 = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?");
        $stmt2->bind_param('ii', $ir_id, $defect_id);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        while ($row = $res2->fetch_assoc()) {
            $photos[] = $base_path_def . $row['defect_photo'];
        }
        $stmt2->close();

        // Get compare photos for this defect
        $compare_photos = [];
        $stmt3 = $db_con->prepare("SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?");
        $stmt3->bind_param('ii', $ir_id, $defect_id);
        $stmt3->execute();
        $res3 = $stmt3->get_result();
        while ($row = $res3->fetch_assoc()) {
            $compare_photos[] =  $base_path_comp . $row['compare_photo'];
        }
        $stmt3->close();

        // Add everything to one array
        $data[] = [
            'defect_id'      => $defect['defect_id'],     // add this line!
            'ir_id'          => $defect['rcd_ir_id'],     // add this line!
            'pallet_no'      => $defect['ir_pallet_no'],
            'defect_type'    => $defect['defectname'],
            'defect_area'    => $defect['defect_area'],
            'defect_photos'  => $photos,
            'compare_photos' => $compare_photos
        ];
    }
}

echo json_encode([
    'success' => true,
    'data' => $data
]);

?>