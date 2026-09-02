<?php

date_default_timezone_set("Asia/Kuala_Lumpur"); 

function get_current_shift($db_con) {

    // Current date/time
    $currenttime = date("H:i:s");
    $target_date = date("Y-m-d");
    $target_datetime = date('Y-m-d H:i:s');

    // Prepare query
    $qry_shift = "SELECT shiftdesc, shiftshort, timestart, timeend FROM shift_detail";
    $stmt_shift = $db_con->prepare($qry_shift);
    $stmt_shift->execute();
    $rst_shift = $stmt_shift->get_result();

    // Defaults
    $result = [
        'shiftshort' => null,
        'shiftdesc' => null,
        'shift_date' => null,
        'production_date' => null,
        'found' => false
    ];

    while ($row_shift = $rst_shift->fetch_array()) {

        $shiftdesc = $row_shift['shiftdesc'];
        $shiftshort = $row_shift['shiftshort'];
        $start_time = $row_shift['timestart'];
        $end_time = $row_shift['timeend'];

        // Build datetime
        $start_dt = "$target_date $start_time";

        // If overnight shift
        if ($start_time > $end_time) {
            $end_dt = date('Y-m-d H:i:s', strtotime("$target_date +1 day $end_time"));
        } else {
            $end_dt = "$target_date $end_time";
        }

        // Check if current time falls into this shift
        if ($target_datetime >= $start_dt && $target_datetime <= $end_dt) {
            $result = [
                'shiftshort' => $shiftshort,
                'shiftdesc' => $shiftdesc,
                'shift_date' => date('Y-m-d', strtotime($start_dt)), // Shift start date
                'production_date' => date('Y-m-d', strtotime($start_dt)),
                'found' => true
            ];
            break;
        }
    }

    return $result;
}

$shift_info = get_current_shift($db_con);

$currenttime = date("H:i:s");
$target_date = date("Y-m-d");
$target_datetime = date('Y-m-d H:i:s');

if ($shift_info['found']) {

    $current_shift = $shift_info['shiftshort'];
    $current_shiftdesc = $shift_info['shiftdesc'];
    $shift_date = $shift_info['shift_date'];
    $shift_date = $shift_info['production_date'];

} else {
    echo "No matching shift found";
}

?>