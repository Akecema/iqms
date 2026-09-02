<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';

$defect_id = $_POST['defect_id'] ?? 0;
$ir_id = $_POST['ir_id'] ?? 0;

// Prepare and fetch defect
$stmt = $db_con->prepare("
            SELECT defect_type, defect_area, rcd_ir_id
            FROM inspection_defect
            WHERE defect_id = ? AND rcd_ir_id = ?
        ");

$stmt->bind_param('ii', $defect_id, $ir_id);
$stmt->execute();
$stmt->bind_result($defect_type, $area, $ir_id_db);  // Don't overwrite $ir_id from POST!
$found = $stmt->fetch();  // <- ASSIGN fetch result!
$stmt->close();

if (!$found) {
    echo json_encode(['success' => false, 'msg' => 'Defect not found']);
    exit;
}

$base_path_def = 'gallery/inspection/defect/' .$ir_id. '/';
$base_path_comp = 'gallery/inspection/defect_compare/' .$ir_id. '/';

// Example: Fetch defect photo URLs
$defect_photos = [];
$photo_result = $db_con->query("SELECT def_photoid, defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = $defect_id AND rcd_ir_id = $ir_id");

while ($row = $photo_result->fetch_assoc()) {
    $defect_photos[] = [
        'def_photoid' => $row['def_photoid'],
        'url' => $base_path_def . $row['defect_photo']
    ];
}

// Example: Fetch compare photo URLs
$compare_photos = [];
$compare_result = $db_con->query("SELECT compare_photoid, compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = $defect_id AND rcd_ir_id = $ir_id");

while ($row = $compare_result->fetch_assoc()) {
    $compare_photos[] = [
        'compare_photoid' => $row['compare_photoid'],
        'url' => $base_path_comp . $row['compare_photo']
    ];
}

// Area
$area_arr = $area ? explode(',', $area) : [];

echo json_encode([
    'success' => true,
    'data' => [
        'defect_type'     => $defect_type,
        'area'            => $area_arr,
        'defect_photos'   => $defect_photos,
        'compare_photos'  => $compare_photos,
        'ir_id'           => $ir_id_db
    ]
]);

?>