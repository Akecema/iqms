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

    // 1. Get current settings
    $stmt = $db_con->prepare("
        SELECT maximum_no, last_shift, last_date 
        FROM transaction_type 
        WHERE transmodule_cd = ? 
          AND transprocess = ?
    ");
    $stmt->bind_param('ss', $transmodule, $transprocess);
    $stmt->execute();
    $stmt->bind_result($max_no, $last_shift, $last_date);
    $found = $stmt->fetch();
    $stmt->close();

    if (!$found) return false;


    // ----------------------------------------------------
    // 2. RESET ONLY IF NEW PRODUCTION DATE
    // ----------------------------------------------------
    if ($shift_date !== $last_date) {
        $next_no = 1;   // reset
    } else {
        $next_no = intval($max_no) + 1;  // continue
    }


    // ----------------------------------------------------
    // 3. UPDATE TABLE
    // ----------------------------------------------------
    $stmt = $db_con->prepare("
        UPDATE transaction_type
        SET maximum_no = ?, 
            last_shift = ?, 
            last_date = ?
        WHERE transmodule_cd = ? 
          AND transprocess = ?
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


    // ----------------------------------------------------
    // 4. RETURN PADDED VALUE
    // ----------------------------------------------------
    return str_pad($next_no, 4, '0', STR_PAD_LEFT);
}


?>