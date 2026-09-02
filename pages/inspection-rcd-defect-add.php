<?php

ob_start();
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

//in production
// error_reporting(E_ALL & ~E_NOTICE);

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$ir_id      = $_POST['ir_id'] ?? '';
$pallet_no  = $_POST['pallet'];
$result     = $_POST['result'];
$model_id   = $_POST['model'];
$type_id    = $_POST['type'];
$material_id= $_POST['material'];
$shift      = $_POST['shift'];

$defect_type    = $_POST['fd_defectType'] ?? '';
$defect_areas   = $_POST['fd_area'] ?? [];

$area_str = is_array($defect_areas) ? implode(',', $defect_areas) : $defect_areas;

$success = false;
$new_id = $ir_id;
$prev_result = '';

//create inspection group (group by material, model, type, shift, production date)
$sql_group = "SELECT inspect_group 
              FROM inspection_records 
              WHERE ir_model = ? AND ir_type = ? AND ir_material = ? 
                AND ir_shift = ? AND shift_date = ?
              ORDER BY inspect_group DESC LIMIT 1";
$stmt = $db_con->prepare($sql_group);
$stmt->bind_param('iiiis', $model_id, $type_id, $material_id, $shift, $shift_date);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

    $stmt->bind_result($existing_group);
    $stmt->fetch();
    $inspect_group = $existing_group;  // Use existing group

} else {

    // No group exists — get max group and increment
    $sql_max = "SELECT MAX(inspect_group) FROM inspection_records";
    $result_max = $db_con->query($sql_max);
    $max_group = $result_max->fetch_row()[0] ?? 0;
    $inspect_group = $max_group + 1;
}
$stmt->close();

// 1. If updating existing, get previous result
if ($ir_id) {
    $stmt = $db_con->prepare("SELECT ir_result FROM inspection_records WHERE ir_id = ?");
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $stmt->bind_result($prev_result);
    $stmt->fetch();
    $stmt->close();
}

// 2. Handle NG→OK (delete defect & photo data and files)
if ($ir_id && $prev_result === 'NG' && $result === 'OK') {
    
    // Delete defect photos
    $photos = [];
    $stmt = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = ?");
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $stmt->bind_result($photo_path);
    while ($stmt->fetch()) $photos[] = $photo_path;
    $stmt->close();

    foreach ($photos as $path) {
        $full_path = __DIR__ . "/gallery/inspection/defect/".$ir_id. "/" . basename($path);
        if (file_exists($full_path)) unlink($full_path);
    }

    // Delete comparison photos
    $compare_photos = [];
    $stmt = $db_con->prepare("SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ?");
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $stmt->bind_result($compare_path);
    while ($stmt->fetch()) $compare_photos[] = $compare_path;
    $stmt->close();

    foreach ($compare_photos as $path) {
        $full_path = __DIR__ . "/gallery/inspection/defect_compare/" .$ir_id . "/" . basename($path);
        if (file_exists($full_path)) unlink($full_path);
    }

    // Delete defect records
    $db_con->query("DELETE FROM inspection_defect WHERE rcd_ir_id = " . intval($ir_id));
    $db_con->query("DELETE FROM inspection_defect_photo WHERE rcd_ir_id = " . intval($ir_id));
    $db_con->query("DELETE FROM inspection_compare_photo WHERE rcd_ir_id = " . intval($ir_id));

}

// 3. Insert/Update Main inspection record
if ($ir_id) {

    // update
    $sql = "UPDATE inspection_records SET ir_model = ?, ir_type = ?, ir_material = ?, ir_pallet_no = ?, ir_result = ?, ir_status = ?, ir_shift = ?, shift_date = ?, updated_by = ?, updated_date = NOW() WHERE ir_id = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param('iiissssssi', $model_id, $type_id, $material_id, $pallet_no, $result, $s_new_id, $shift, $shift_date, $session_id, $ir_id);
    $stmt->execute();
    $success = $stmt->affected_rows > 0;

} else {

    // insert
    $sql = "INSERT INTO inspection_records (ir_model, ir_type, ir_material, ir_pallet_no, ir_result, ir_status, ir_shift, shift_date, inspect_group, inspect_date, created_by, created_date) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), ?, NOW())";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param('iiississis', $model_id, $type_id, $material_id, $pallet_no, $result, $s_new_id, $shift, $shift_date, $inspect_group, $session_id);
    $stmt->execute();
    $new_id = $stmt->insert_id;
    $success = $stmt->affected_rows > 0;

    // Auto create folder for photo
    // defect
    $folder_new_d = __DIR__ . "/gallery/inspection/defect/" . $new_id;
    if (!is_dir($folder_new_d)) mkdir($folder_new_d, 0777, true);

    // comparison
    $folder_new_c = __DIR__ . "/gallery/inspection/defect_compare/" . $new_id;
    if (!is_dir($folder_new_c)) mkdir($folder_new_c, 0777, true);

}

// 4. Handle NG or OK->NG (add/update defect + photo)
if ($result === 'NG') {

    // Always delete previous details to avoid duplicates
    $db_con->query("DELETE FROM inspection_defect WHERE rcd_ir_id = " . intval($new_id));
    $db_con->query("DELETE FROM inspection_defect_photo WHERE rcd_ir_id = " . intval($new_id));
    $db_con->query("DELETE FROM inspection_compare_photo WHERE rcd_ir_id = " . intval($new_id));

    // Insert defect
    $stmt = $db_con->prepare("INSERT INTO inspection_defect (rcd_ir_id, defect_type, defect_area, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param('iiss', $new_id, $defect_type, $area_str, $session_id);
    $stmt->execute();
    $defect_id = $stmt->insert_id;

    // Defect Photos
    if (!empty($_FILES['defect_photo']['name'][0])) {
        foreach ($_FILES['defect_photo']['tmp_name'] as $i => $tmp_name) {
            if ($_FILES['defect_photo']['error'][$i] === 0) {
                $fileName = uniqid() . '_' . str_replace(' ', '_', basename($_FILES['defect_photo']['name'][$i]));
                $targetFile = __DIR__ . "/gallery/inspection/defect/" .$new_id. "/" . $fileName;
                if (move_uploaded_file($tmp_name, $targetFile)) {
                    $stmtPhoto = $db_con->prepare("INSERT INTO inspection_defect_photo (rcd_ir_id, rcd_defect_id, defect_photo, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
                    $stmtPhoto->bind_param("iiss", $new_id, $defect_id, $fileName, $session_id);
                    $stmtPhoto->execute();
                }
            }
        }
    }

    // Comparison Photos
    if (!empty($_FILES['compare_photo']['name'][0])) {
        foreach ($_FILES['compare_photo']['tmp_name'] as $i => $tmp_name) {
            if ($_FILES['compare_photo']['error'][$i] === 0) {
                $fileName = uniqid() . '_' . str_replace(' ', '_', basename($_FILES['compare_photo']['name'][$i]));
                $targetFile = __DIR__ . "/gallery/inspection/defect_compare/" .$new_id. "/" . $fileName;
                if (move_uploaded_file($tmp_name, $targetFile)) {
                    $stmtCompPhoto = $db_con->prepare("INSERT INTO inspection_compare_photo (rcd_ir_id, rcd_defect_id, compare_photo, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
                    $stmtCompPhoto->bind_param("iiss", $new_id, $defect_id, $fileName, $session_id);
                    $stmtCompPhoto->execute();
                }
            }
        }
    }
}

echo json_encode(['success' => $success, 'ir_id' => $new_id ?? $ir_id, 'status' => $s_new_id]);

?>