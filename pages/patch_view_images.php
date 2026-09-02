<?php
$file = 'c:\xampp_7\htdocs\iQims\pages\fetch-material-master.php';

$code = <<<'EOD'

// ===============================
// GET IMAGES
// ===============================
if ($_POST['action'] == 'get_material_images') {
    $matid = intval($_POST['matid']);
    
    // Get Modcode for path
    $q_mat = $db_con->prepare("SELECT m.matid, d.modcode 
                               FROM material_header m 
                               LEFT JOIN model_details d ON m.modelid = d.modid 
                               WHERE m.matid = ?");
    $q_mat->bind_param("i", $matid);
    $q_mat->execute();
    $matData = $q_mat->get_result()->fetch_assoc();
    
    $modcode = $matData['modcode'] ?? 'Unknown';
    $folder_path = "gallery/model/" . $modcode . "/" . $matid . "/";
    
    // Fetch from DB
    $stmt = $db_con->prepare("SELECT imageid, imagename, createdate FROM material_gallery WHERE image_matid = ? AND imagestatus = 'Y' ORDER BY imageid DESC");
    $stmt->bind_param("i", $matid);
    $stmt->execute();
    $res = $stmt->get_result();
    
    $images = [];
    while($row = $res->fetch_assoc()){
        $images[] = [
            'id' => $row['imageid'],
            'path' => $folder_path . $row['imagename'],
            'name' => $row['imagename'],
            'created' => $row['createdate']
        ];
    }
    
    echo json_encode(['status' => 'success', 'data' => $images]);
    exit;
}

// ===============================
// DELETE IMAGE
// ===============================
if ($_POST['action'] == 'delete_material_image') {
    $imageid = intval($_POST['imageid']);
    
    // Soft Delete
    $stmt = $db_con->prepare("UPDATE material_gallery SET imagestatus = 'N', updatedate = NOW() WHERE imageid = ?");
    $stmt->bind_param("i", $imageid);
    
    if($stmt->execute()){
         echo json_encode(['status' => 'success']);
    } else {
         echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
    }
    exit;
}
EOD;

$content = file_get_contents($file);
$content = preg_replace('/\?>\s*$/', '', $content);
file_put_contents($file, $content . $code . "\n" . "?" . ">");
echo "Actions appended.";
?>
