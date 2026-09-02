<?php
require '../db/db_connect.php';

if (isset($_POST['action']) && isset($_POST['id'])) {
    
    $id = intval($_POST['id']);
    $action = $_POST['action'];

    if ($action === 'delete_before') {
        $table = "inspection_sorting_before_photo";
        $column = "before_photo";
        $idcol = "before_photoid";
        $folder = "gallery/sorting/before/";
    } elseif ($action === 'delete_after') {
        $table = "inspection_sorting_after_photo";
        $column = "after_photo";
        $idcol = "after_photoid";
        $folder = "gallery/sorting/after/";
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid action."]);
        exit;
    }

    $stmt = $db_con->prepare("SELECT $column FROM $table WHERE $idcol = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $filename = $row[$column];
        $filePath = $folder . $filename;

        $del = $db_con->prepare("DELETE FROM $table WHERE $idcol = ?");
        $del->bind_param("i", $id);
        if ($del->execute()) {
            if (file_exists($filePath)) unlink($filePath);
            echo json_encode(["status" => "success", "message" => "Photo deleted successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Database delete failed."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Photo not found."]);
    }

} else {
    echo json_encode(["status" => "error", "message" => "Invalid request."]);
}
?>