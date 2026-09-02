<?php

//get maximum no
// function getCurrentTransNo($db_con, $transmodule, $transprocess) {

//     $stmt = $db_con->prepare("
//         SELECT maximum_no 
//         FROM transaction_type 
//         WHERE transmodule_cd = ? AND transprocess = ?
//         LIMIT 1
//     ");
//     $stmt->bind_param("ss", $transmodule, $transprocess);
//     $stmt->execute();
//     $stmt->bind_result($max_no);
//     $stmt->fetch();
//     $stmt->close();

//     return str_pad($max_no, 4, '0', STR_PAD_LEFT);
// }

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

    
    if ($shift_date !== $last_date) {
        // New date → reset
        $reset = true;
    } 
    elseif ($current_shift !== $last_shift) {
        // Same date, different shift → reset
        $reset = true;
    }

    // 3. Determine next number
    if ($reset) {
        $next_no = 1;
    } else {
        $next_no = intval($max_no) + 1;
    }

     // 4. Persist update (IMPORTANT)
    $stmt = $db_con->prepare("
        UPDATE transaction_type
        SET maximum_no = ?, last_shift = ?, last_date = ?
        WHERE transmodule_cd = ? AND transprocess = ?
    ");
    $stmt->bind_param(
        'issss',
        $next_no,
        $current_shift,
        $shift_date,
        $transmodule,
        $transprocess
    );
    $stmt->execute();
    $stmt->close();

    // 5. Return padded value
    return str_pad($next_no, 4, '0', STR_PAD_LEFT);
}

?>