<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';

$photo_id = $_POST['id'] ?? '';
$photo_type = $_POST['phototype'] ?? '';

if (!$photo_id || !$photo_type) {
    echo json_encode(['success' => false, 'error' => 'Missing parameters']);
    exit;
}

if ($photo_type == 'defect') {

    $table = 'inspection_defect_photo';
    $field = 'defect_photo';
    $tblid = 'def_photoid';
    $folder = 'gallery/defect/';
    $filename = 'defect_photo';

} else if ($photo_type == 'compare') {

    $table = 'inspection_compare_photo';
    $field = 'compare_photo';
    $tblid = 'compare_photoid';
    $folder = 'gallery/defect_compare/';
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

?>