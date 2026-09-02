<?php

include 'session-login.php';

$sql = "
    SELECT 
        PDI_reviewer,
        SR_reviewer,
        S2W_reviewer,
        S2W_approver,
        S2W_acknowledger
    FROM user_authorization
    WHERE staff_id = ?
";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("s", $session_id);
$stmt->execute();
$auth = $stmt->get_result()->fetch_assoc();

$pdi_reviewer = $auth['PDI_reviewer'];
$SR_reviewer = $auth['SR_reviewer'];
$S2W_reviewer = $auth['S2W_reviewer'];
$S2W_approver = $auth['S2W_approver'];
$S2W_acknowledger = $auth['S2W_acknowledger'];

?>