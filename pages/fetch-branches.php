<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';

$company_id = intval($_POST['company_id']);

$sql = "
    SELECT branch_name, branch_code
    FROM branch
    WHERE branch_co_id = ?
    ORDER BY branch_name ASC
";

$stmt = $db_con->prepare($sql);
$stmt->bind_param("i", $company_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];
while($row = $result->fetch_assoc()){
    $data[] = $row;
}

echo json_encode($data);
exit;

?>
