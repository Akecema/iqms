<?php

function getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date) {

    // 1. Get current max_no, shift, and date
    $stmt = $db_con->prepare("SELECT maximum_no, last_shift, last_date FROM transaction_type WHERE transmodule_cd = ? AND transprocess = ?");
    $stmt->bind_param('ss', $transmodule, $transprocess);
    $stmt->execute();
    $stmt->bind_result($max_no, $last_shift, $last_date);
    $found = $stmt->fetch();
    $stmt->close();

    if (!$found) return false;

    // 2. Determine if need to reset
    $reset = false;

    if ($shift_date > $last_date) {
        // New date = always reset
        $reset = true;
    } elseif ($shift_date == $last_date && $current_shift !== $last_shift) {
        // Same day but different shift = reset
        $reset = true;
    }

    if ($reset) {
        $max_no = 1;
    } else {
        $max_no = intval($max_no) + 1;
    }

    // 3. Update the new values
    $stmt = $db_con->prepare("UPDATE transaction_type SET maximum_no = ?, last_shift = ?, last_date = ? WHERE transmodule_cd = ? AND transprocess = ?");
    $stmt->bind_param('issss', $max_no, $current_shift, $shift_date, $transmodule, $transprocess);
    $stmt->execute();
    $stmt->close();

    // 4. Return running number
    return str_pad($max_no, 4, '0', STR_PAD_LEFT);
}

// function getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date) {

//     // 1. Get the current row
//     $stmt = $db_con->prepare("SELECT maximum_no, last_shift, last_date FROM transaction_type WHERE transmodule_cd = ? AND transprocess = ?");
//     $stmt->bind_param('ss', $transmodule, $transprocess);
//     $stmt->execute();
//     $stmt->bind_result($max_no, $last_shift, $last_date);
//     $found = $stmt->fetch();
//     $stmt->close();

//     if (!$found) {
//         // Optional: throw error or create a new row (or just fail)
//         return false; // or handle as needed
//     }

//     // 2. Determine if need to reset
//     if ($last_shift !== $current_shift || $last_date != $shift_date) {
//         $max_no = 1;
//     } else {
//         $max_no = intval($max_no) + 1;
//     }

//     // 3. Update the row
//     $stmt = $db_con->prepare("UPDATE transaction_type SET maximum_no = ?, last_shift = ?, last_date = ? WHERE transmodule_cd = ? AND transprocess = ?");
//     $stmt->bind_param('issss', $max_no, $current_shift, $shift_date, $transmodule, $transprocess);
//     $stmt->execute();
//     $stmt->close();

//     // 4. Return formatted running number
//     return str_pad($max_no, 4, '0', STR_PAD_LEFT);
// }

?>