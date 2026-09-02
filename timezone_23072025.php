<?php 

date_default_timezone_set("Asia/Kuala_Lumpur"); 

//current date, time
$currenttime = date("H:i:s");
$target_date = date("Y-m-d");
$target_datetime = date('Y-m-d H:i:s');

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

    // Build full datetime
    $start_dt = "$target_date $start_time";

    // If overnight shift
    if ($start_time > $end_time) {
        // Shift ends next day
        $end_dt = date('Y-m-d H:i:s', strtotime("$target_date +1 day $end_time"));
    } else {
        // Same-day shift
        $end_dt = "$target_date $end_time";
    }

    // Check if current datetime is within shift range
    if ($target_datetime >= $start_dt && $target_datetime <= $end_dt) {
        $current_shift = $shiftshort;
        $current_shiftdesc = $shiftdesc;

        // Set production date as the shift START date (not necessarily today!)
        $shift_date = date('Y-m-d', strtotime($start_dt));
        $shift_date = date('Y-m-d', strtotime($start_dt));

        break;
    }

}


function get_current_shift_date() {
    // ...all your existing code...
    return $shift_date; // at the end of your logic
}
//echo "Current shift for $target_datetime: $current_shift";

?>