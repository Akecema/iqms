<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include '../shift.php';

$ir_id = $_POST['ir_id'] ?? 0;
$count = 0;

if ($ir_id) {

    $stmt = $db_con->prepare("SELECT COUNT(*) as cnt FROM inspection_defect WHERE rcd_ir_id = ?");
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();
}
echo json_encode(['has_defect' => $count > 0]);

?>