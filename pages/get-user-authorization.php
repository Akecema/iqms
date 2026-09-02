<?php

function getUserRoles($db, $staff_id, $section) {
    $sql = "
        SELECT task
        FROM user_authorization
        WHERE staff_id = ?
          AND section = ?
          AND auto_status = 'AC'
    ";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("ss", $staff_id, $section);
    $stmt->execute();
    $result = $stmt->get_result();

    $roles = [];
    while ($row = $result->fetch_assoc()) {
        $roles[] = $row['task'];
    }
    return $roles;
}

?>