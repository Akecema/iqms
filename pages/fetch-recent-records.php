<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';

$shift_date = $_POST['shift_date'] ?? date('Y-m-d');
$shift = $_POST['shift'] ?? 'ALL';

$shiftCondition = "";
if ($shift === 'D') $shiftCondition = "AND I.ir_shift = 'D'";
elseif ($shift === 'N') $shiftCondition = "AND I.ir_shift = 'N'";
else $shiftCondition = "AND I.ir_shift IN ('D','N')";

$queryRecent = "SELECT I.ir_docno, I.ir_result, I.created_date, T.modcode, M.matno
                FROM inspection_records I
                LEFT JOIN model_details T ON I.ir_model = T.modid
                LEFT JOIN material_header M ON I.ir_material = M.matid
                WHERE I.shift_date = '$shift_date' 
                $shiftCondition
                ORDER BY I.ir_id DESC LIMIT 5";

$resultRecent = mysqli_query($db_con, $queryRecent);

if (mysqli_num_rows($resultRecent) > 0) {
    while ($r = mysqli_fetch_assoc($resultRecent)) {
        $badgeClass = ($r['ir_result'] == 'OK') ? 'success' : 'danger';
        $time = date('H:i A', strtotime($r['created_date']));
        echo '
        <div class="d-flex align-items-center mb-3">
            <div class="flex-shrink-0 me-3">
                <span class="badge badge-'.$badgeClass.'">'.$r['ir_result'].'</span>
            </div>
            <div class="flex-grow-1">
                <h6 class="mb-0 text-white" style="font-size: 13px;">'.htmlspecialchars($r['ir_docno']).'</h6>
                <small class="text-white opacity-50">'.htmlspecialchars($r['modcode']).' - '.htmlspecialchars($r['matno']).'</small>
            </div>
            <div class="text-end">
                <small class="text-white opacity-50">'.$time.'</small>
            </div>
        </div>';
    }
} else {
    echo '<p class="text-white opacity-50">No recent records for this shift</p>';
}
?>
