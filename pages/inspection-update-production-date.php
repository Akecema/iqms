<?php
session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include '../shift.php';
include 'system-status.php';

$ir_id     = intval($_POST['ir_id']);
$prod_date = date('Y-m-d',strtotime($_POST['prod_date']));

if(!$ir_id || !$prod_date){
    echo json_encode(['status'=>'error']);
    exit;
}

$stmt = $db_con->prepare("
    UPDATE inspection_records 
       SET prod_date = ? 
     WHERE ir_id = ?
");

$stmt->bind_param("si", $prod_date, $ir_id);
$stmt->execute();

if($stmt->affected_rows >= 0){
    echo json_encode(['status'=>'success']);
} else {
    echo json_encode(['status'=>'error']);
}
