<?php

date_default_timezone_set("Asia/Kuala_Lumpur"); 

//current date, time
$currenttime = date("H:i:s");
$target_date = date("Y-m-d");
$target_datetime = date('Y-m-d H:i:s');
$doc_date = date('ymd', strtotime($target_date));

//current shift
$qry_shift = "SELECT shiftdesc, shiftshort, timestart, timeend FROM shift_detail";
$stmt_shift = $db_con->prepare($qry_shift);
$stmt_shift->execute();
$rst_shift = $stmt_shift->get_result();

$current_shift = "No matching shift";

while($row_shift = $rst_shift->fetch_array())
{
    $shiftdesc = $row_shift['shiftdesc'];
    $shiftshort = $row_shift['shiftshort'];
    $start_time = $row_shift['timestart'];
    $end_time = $row_shift['timeend'];

    // Overnight shift
    if ($start_time > $end_time) {
        // Night shift: spans two days
        $start_dt = "$target_date $start_time";
        $end_dt = date('Y-m-d H:i:s', strtotime("$target_date +1 day $end_time"));

        // If now is after midnight but before end_time, adjust start_dt to yesterday
        if ($currenttime < $end_time) {
            $start_dt = date('Y-m-d', strtotime("$target_date -1 day")) . " $start_time";
            $end_dt = "$target_date $end_time";
        }
    } else {
        // Day shift: same day
        $start_dt = "$target_date $start_time";
        $end_dt = "$target_date $end_time";
    }

    if ($target_datetime >= $start_dt && $target_datetime <= $end_dt) {
        
        $current_shift = $shiftshort;
        $current_shiftdesc = $shiftdesc;

        // Use shift start date as production date
        $shift_date = date('Y-m-d', strtotime($start_dt));
        break;
    }
}

?>