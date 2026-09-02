<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';

if (isset($_POST['ir_id'])) {

    $ir_id = intval($_POST['ir_id']);

    $sql = "SELECT returned_remark FROM inspection_records WHERE ir_id = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $stmt->bind_result($comment);
    $stmt->fetch();
    $stmt->close();

    echo $comment ?: 'No comment available.';
}
?>
