<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';
include 'system-transaction-code.php';
include 'get-running-no.php';
include '../web-mail/email-settings.php';

//Add defect
if ($_POST['action'] == 'add_defect_modal') {

    $ir_rcdid = $_POST['ng_ir_id'] ?? '';
    $defect_type = $_POST['fd_defectType_add'] ?? '';
    $defect_area = $_POST['fd_area_add'] ?? [];

    if (!$ir_rcdid || !$defect_type) {
        echo json_encode(['success' => false, 'error' => 'Missing ir_rcdid or defect_type']);
        exit;
    }

    // Convert array to comma-separated string
    $defect_area_str = '';
    if (!empty($defect_area)) {
        $defect_area_str = implode(',', $defect_area);
    }

    // 1. INSERT ONE ROW
    $stmt = $db_con->prepare("INSERT INTO inspection_defect (rcd_ir_id, defect_type, defect_area, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiss", $ir_rcdid, $defect_type, $defect_area_str, $session_id);
    $stmt->execute();
    $defect_id = $db_con->insert_id;

    // 2. Save defect_photo(s)
    if (!empty($_FILES['imageUpload_defect_photo']['name'][0])) {

        $targetDir = "gallery/inspection/defect/" .$ir_rcdid. "/";

        foreach ($_FILES['imageUpload_defect_photo']['tmp_name'] as $key => $tmp_name) {

            $originalName = basename($_FILES['imageUpload_defect_photo']['name'][$key]);

            // Replace ALL whitespace (spaces, tabs, etc) with underscores:
            $safeName = preg_replace('/\s+/', '_', $originalName);
            $fileName = uniqid() . '_' . $safeName;

            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($tmp_name, $targetFile)) {
                $stmtPhoto = $db_con->prepare("INSERT INTO inspection_defect_photo (rcd_ir_id, rcd_defect_id, defect_photo, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
                $stmtPhoto->bind_param("iiss", $ir_rcdid, $defect_id, $fileName, $session_id);
                $stmtPhoto->execute();
            }
        }
    }

    // 3. Save compare_photo(s)
    if (!empty($_FILES['imageUpload_compare_photo']['name'][0])) {

        $targetDir = "gallery/inspection/defect_compare/" . $ir_rcdid . "/";

        foreach ($_FILES['imageUpload_compare_photo']['tmp_name'] as $key => $tmp_name) {

            $originalName = basename($_FILES['imageUpload_compare_photo']['name'][$key]);
            
            // Replace ALL whitespace (spaces, tabs, etc) with underscores:
            $safeName = preg_replace('/\s+/', '_', $originalName);
            $fileName = uniqid() . '_' . $safeName;

            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($tmp_name, $targetFile)) {
                $stmtCompare = $db_con->prepare("INSERT INTO inspection_compare_photo (rcd_ir_id, rcd_defect_id, compare_photo, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
                $stmtCompare->bind_param("iiss", $ir_rcdid, $defect_id, $fileName, $session_id);
                $stmtCompare->execute();
            }
        }
    }

    echo json_encode(['success' => true]);

}

//Delete result 
if ($_POST['action'] === 'delete_defect') {

    $ir_id = $_POST['ir_id'];
    $defect_id = $_POST['defect_id'] ?? 0;

    // Delete defect photos
    $photos = [];
    $stmt = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = ?");
    $stmt->bind_param('i', $defect_id);
    $stmt->execute();
    $stmt->bind_result($photo_path);
    while ($stmt->fetch()) $photos[] = $photo_path;
    $stmt->close();

    foreach ($photos as $path) {
        $full_path = __DIR__ . "/gallery/inspection/defect/" .$ir_id. "/". basename($path);
        if (file_exists($full_path)) unlink($full_path);
    }

    // Delete comparison photos
    $compare_photos = [];
    $stmt = $db_con->prepare("SELECT compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = ?");
    $stmt->bind_param('i', $defect_id);
    $stmt->execute();
    $stmt->bind_result($compare_path);
    while ($stmt->fetch()) $compare_photos[] = $compare_path;
    $stmt->close();

    foreach ($compare_photos as $path) {
        $full_path = __DIR__ . "/gallery/inspection/defect_compare/" .$ir_id. "/". basename($path);
        if (file_exists($full_path)) unlink($full_path);
    }

    // Delete defect records
    $db_con->query("DELETE FROM inspection_defect WHERE defect_id = " . intval($defect_id));
    $db_con->query("DELETE FROM inspection_defect_photo WHERE rcd_defect_id = " . intval($defect_id));
    $db_con->query("DELETE FROM inspection_compare_photo WHERE rcd_defect_id = " . intval($defect_id));

    echo json_encode(['success' => true]);

}

//Update defect
if ($_POST['action'] == 'update_defect_modal') {

    $ir_id = $_POST['ir_id'];
    $defect_id = $_POST['defect_id'];
    $defect_type = $_POST['defect_type'];
    $defect_area = $_POST['area'] ?? [];    

    // 1. Update inspection_records (type of defect)
    $stmt = $db_con->prepare("UPDATE inspection_defect SET defect_type = ?, defect_area = ? WHERE defect_id = ? and rcd_ir_id = ?");
    $stmt->bind_param('ssii', $defect_type, $defect_area, $defect_id, $ir_id);
    $stmt->execute();

    $deleted_defect_photo_ids = isset($_POST['deleted_defect_photo_ids']) ? json_decode($_POST['deleted_defect_photo_ids'], true) : [];
    $deleted_compare_photo_ids = isset($_POST['deleted_compare_photo_ids']) ? json_decode($_POST['deleted_compare_photo_ids'], true) : [];

    if (!empty($deleted_defect_photo_ids)) {
        foreach ($deleted_defect_photo_ids as $photoId) {
            $stmt = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE def_photoid = ?");
            $stmt->bind_param("i", $photoId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $filePath = "gallery/inspection/defect/" .$ir_id. "/". $row['defect_photo'];
                if (file_exists($filePath)) unlink($filePath);
            }
            $stmt_del = $db_con->prepare("DELETE FROM inspection_defect_photo WHERE def_photoid = ?");
            $stmt_del->bind_param("i", $photoId);
            $stmt_del->execute();
        }
    }

    // Save new uploads (if any)
    if (!empty($_FILES['defect_photo_ed']['name'][0])) {
        $targetDir = "gallery/inspection/defect/" .$ir_id. "/";
        foreach ($_FILES['defect_photo_ed']['tmp_name'] as $key => $tmp_name) {
            if (empty($tmp_name)) continue;
            $fileName = uniqid() . '_' . preg_replace('/\s+/', '_', $_FILES['defect_photo_ed']['name'][$key]);
            if (move_uploaded_file($tmp_name, $targetDir.$fileName)) {
                $stmt_add = $db_con->prepare("INSERT INTO inspection_defect_photo (rcd_ir_id, rcd_defect_id, defect_photo, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
                $stmt_add->bind_param("iiss", $ir_id, $defect_id, $fileName, $session_id);
                $stmt_add->execute();
            }
        }
    }

    // comparison photo
    if (!empty($deleted_compare_photo_ids)) {
        foreach ($deleted_compare_photo_ids as $photoId) {
            $stmt = $db_con->prepare("SELECT compare_photo FROM inspection_compare_photo WHERE compare_photoid = ?");
            $stmt->bind_param("i", $photoId);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($row = $result->fetch_assoc()) {
                $filePath = "gallery/inspection/defect_compare/" .$ir_id. "/" . $row['compare_photo'];
                if (file_exists($filePath)) unlink($filePath);
            }
            $stmt_del = $db_con->prepare("DELETE FROM inspection_compare_photo WHERE compare_photoid = ?");
            $stmt_del->bind_param("i", $photoId);
            $stmt_del->execute();
        }
    }

    // Save new uploads (if any)
    if (!empty($_FILES['compare_photo_ed']['name'][0])) {
        $targetDir = "gallery/inspection/defect_compare/" .$ir_id. "/";
        foreach ($_FILES['compare_photo_ed']['tmp_name'] as $key => $tmp_name) {
            if (empty($tmp_name)) continue;
            $fileName = uniqid() . '_' . preg_replace('/\s+/', '_', $_FILES['compare_photo_ed']['name'][$key]);
            if (move_uploaded_file($tmp_name, $targetDir.$fileName)) {
                $stmt_add = $db_con->prepare("INSERT INTO inspection_compare_photo (rcd_ir_id, rcd_defect_id, compare_photo, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
                $stmt_add->bind_param("iiss", $ir_id, $defect_id, $fileName, $session_id);
                $stmt_add->execute();
            }
        }
    }

    $response['success'] = true;
    $response['msg'] = 'Your changes have been saved.';
    
    echo json_encode($response);
}

//Delete current defect photo
if($_POST['action'] == 'delete_photo')
{
    $photo_id = $_POST['id'] ?? '';
    $photo_type = $_POST['phototype'] ?? '';

    if (!$photo_id || !$photo_type) {
        echo json_encode(['success' => false, 'error' => 'Missing parameters']);
        exit;
    }

    if ($photo_type == 'defect') {
   
        //get ir_id
        $stmt = $db_con->prepare("SELECT rcd_ir_id FROM inspection_defect_photo WHERE def_photoid  = ?");
        $stmt->bind_param("i", $photo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $table = 'inspection_defect_photo';
        $field = 'defect_photo';
        $tblid = 'def_photoid';
        $folder = 'gallery/inspection/defect/' .$row['rcd_ir_id']. '/';
        $filename = 'defect_photo';

    } else if ($photo_type == 'compare') {

        //get ir_id
        $stmt = $db_con->prepare("SELECT rcd_ir_id FROM inspection_compare_photo WHERE compare_photoid  = ?");
        $stmt->bind_param("i", $photo_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        $table = 'inspection_compare_photo';
        $field = 'compare_photo';
        $tblid = 'compare_photoid';
        $folder = 'gallery/inspection/defect_compare/' .$row['rcd_ir_id']. '/';
        $filename = 'compare_photo';

    } else {

        echo json_encode(['success' => false, 'error' => 'Invalid type']);
        exit;
    }

    // Get filename from DB
    $stmt = $db_con->prepare("SELECT $field FROM $table WHERE $tblid = ?");
    $stmt->bind_param("i", $photo_id);
    $stmt->execute();
    $stmt->bind_result($filename);
    $stmt->fetch();
    $stmt->close();

    if ($filename) {

        $filepath = $folder . $filename;

        // Delete from DB
        $del = $db_con->prepare("DELETE FROM $table WHERE $tblid = ?");
        $del->bind_param("i", $photo_id);

        if ($del->execute()) {

            if (file_exists($filepath)) unlink($filepath);
            echo json_encode(['success' => true]);
            exit;
        }
        $del->close();
    }

    echo json_encode(['success' => false, 'error' => 'Image not found or DB error']);
}

?>