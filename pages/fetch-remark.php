<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';

$ir_id = $_POST['ir_id'] ?? 0;
$sr_id = $_POST['sr_id'] ?? 0;

$stmt = $db_con->prepare("SELECT reviewed_remark FROM inspection_sorting WHERE sr_id = ?");
$stmt->bind_param("i", $sr_id);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();

echo json_encode([
    'reviewed_remark' => $result['reviewed_remark'] ?? ''
]);
