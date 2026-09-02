<?php
$file = 'c:\xampp_7\htdocs\iQims\pages\fetch-material-master.php';
$code = <<<'EOD'

// ===============================
// UPLOAD GALLERY
// ===============================
if ($_POST['action'] == 'upload_gallery') {

    $matid = intval($_POST['matid']);
    
    if($matid <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Material ID.']);
        exit;
    }

    // Get details for folder & db
    // Need modcode, compcd, plant
    // Note: We need JOINs to get modcode
    $q_mat = $db_con->prepare("SELECT m.matid, m.compcd, m.plant, d.modcode 
                               FROM material_header m 
                               LEFT JOIN model_details d ON m.modelid = d.modid 
                               WHERE m.matid = ?");
    $q_mat->bind_param("i", $matid);
    $q_mat->execute();
    $res = $q_mat->get_result();
    $matData = $res->fetch_assoc();
    
    if(!$matData) {
        echo json_encode(['status' => 'error', 'message' => 'Material not found.']);
        exit;
    }
    
    $modcode = $matData['modcode'] ?? 'Unknown';
    $compcd  = $matData['compcd'] ?? '3100';
    $plant   = $matData['plant'] ?? '3100';
    
    // Prepare Folder
    $target_dir = __DIR__ . "/gallery/model/" . $modcode . "/" . $matid . "/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $count = 0;
    
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['name'] as $i => $name) {
            
            $tmp_name = $_FILES['files']['tmp_name'][$i];
            
            if (empty($tmp_name)) continue;
            
            $imagename = uniqid() . "_" . basename($name);
            $target_file = $target_dir . $imagename;
            
            if (move_uploaded_file($tmp_name, $target_file)) {
                
                $imagestatus = 'Y';
                $stmt = $db_con->prepare("INSERT INTO material_gallery (image_matid, compcd, plant, imagename, imagestatus, createdate, createby, updatedate, updateby) VALUES (?, ?, ?, ?, ?, NOW(), ?, NOW(), ?)");
                $stmt->bind_param("issssss", $matid, $compcd, $plant, $imagename, $imagestatus, $session_id, $session_id);
                $stmt->execute();
                
                $count++;
            }
        }
    }
    
    echo json_encode(['status' => 'success', 'message' => "$count files uploaded."]);
    exit;
}
?>
EOD;

$content = file_get_contents($file);
// Remove last ?>
$content = preg_replace('/\?>\s*$/', '', $content);
file_put_contents($file, $content . $code);
echo "Appended successfully.";
?>
