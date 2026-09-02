<?php

function getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date) {

    // 1. Get current max_no, shift, and date
    $stmt = $db_con->prepare("SELECT maximum_no, last_shift, last_date 
                              FROM transaction_type 
                              WHERE transmodule_cd = ? AND transprocess = ?");
    $stmt->bind_param('ss', $transmodule, $transprocess);
    $stmt->execute();
    $stmt->bind_result($max_no, $last_shift, $last_date);
    $found = $stmt->fetch();
    $stmt->close();

    if (!$found) return false;

    // 2. Determine if need to reset
    $reset = false;

    if ($shift_date > $last_date) {
        // New production date always reset (start of new Day shift)
        $reset = true;
    } else {
        // Same production date
        // If last shift = Night and current shift = Day → reset (full cycle ended)
        if ($last_shift === 'Night' && $current_shift === 'Day') {
            $reset = true;
        }
    }

    // 3. Set next running number
    if ($reset) {
        $max_no = 1;
    } else {
        $max_no = intval($max_no) + 1;
    }

    // 4. Update new values
    $stmt = $db_con->prepare("UPDATE transaction_type 
                              SET maximum_no = ?, last_shift = ?, last_date = ? 
                              WHERE transmodule_cd = ? AND transprocess = ?");
    $stmt->bind_param('issss', $max_no, $current_shift, $shift_date, $transmodule, $transprocess);
    $stmt->execute();
    $stmt->close();

    // 5. Return padded running number
    return str_pad($max_no, 4, '0', STR_PAD_LEFT);
}

?>