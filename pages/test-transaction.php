<?php
require '../db/db_connect.php';

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

echo "<h2>Testing getNextTransactionNo()</h2>";

$test1 = getNextTransactionNo($db_con, "S2W_rp", "New", "", "0000-00-00");
echo "Test 1 (Same date, same shift → +1): $test1<br>";

// $test2 = getNextTransactionNo($db_con, "S2W", "CREATE", "Night", "2025-01-10");
// echo "Test 2 (Same date, shift changes → +1): $test2<br>";

// $test3 = getNextTransactionNo($db_con, "S2W", "CREATE", "Day", "2025-01-11");
// echo "Test 3 (New date → RESET): $test3<br>";

// $test4 = getNextTransactionNo($db_con, "S2W", "CREATE", "Day", "2025-01-12");
// echo "Test 4 (New date again → RESET): $test4<br>";
