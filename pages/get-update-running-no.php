<?php

// update maximum no + 1 after insert
function updateNextTransNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date) {

    // If last_date is 0000-00-00, treat as reset
    $stmt = $db_con->prepare("
                SELECT maximum_no, last_shift, last_date
                FROM transaction_type
                WHERE transmodule_cd = ? AND transprocess = ?
                LIMIT 1
            ");
    $stmt->bind_param("ss", $transmodule, $transprocess);
    $stmt->execute();
    $stmt->bind_result($max_no, $last_shift, $last_date);
    $stmt->fetch();
    $stmt->close();

    $reset = false;

    // If date is new → reset
    if ($last_date == "0000-00-00" || $shift_date > $last_date) {
        $reset = true;
    }
    else if ($last_shift === "N" && $current_shift === "D") {
        // Night → Day shift rollover resets number
        $reset = true;
    }

    if ($reset) {
        $new_no = 1;
    } else {
        $new_no = intval($max_no) + 1;
    }

    // Update the table
    $stmt = $db_con->prepare("
                UPDATE transaction_type
                SET maximum_no = ?, last_shift = ?, last_date = ?
                WHERE transmodule_cd = ? AND transprocess = ?
            ");
    $stmt->bind_param("issss", $new_no, $current_shift, $shift_date, $transmodule, $transprocess);
    $stmt->execute();
    $stmt->close();

    return $new_no;
}

?>