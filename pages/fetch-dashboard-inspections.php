<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';

header('Content-Type: application/json');

$shift = $_POST['shift'] ?? 'ALL';
$shiftCondition = "";
if ($shift == 'D') {
    $shiftCondition = " AND ir_shift = 'D'";
} elseif ($shift == 'N') {
    $shiftCondition = " AND ir_shift = 'N'";
}

// User requested inspect_date = today
$query = "SELECT 
            I.ir_id,
            I.ir_docno,
            M.matno,
            M.matdesc,
            H.model,
            MT.typemodel,
            PT.side_name,
            I.inspect_date,
            I.ir_shift,
            I.ir_pallet_no,
            I.ir_result,
            I.prod_date,
            I.ir_status,
            I.ir_sorting_status,
            I.ir_s2w_status,
            I.ir_s2w_rp_status,
            I.ir_s2w_ack_status,
            S.statusname,
            S.badge,              
            S.badge_color,
            S.text_color,
            S.icon_class,
            SH.shiftdesc, 
            SH.shiftbadge
          FROM inspection_records I
          JOIN material_header M ON I.ir_material = M.matid
          JOIN model_hdr H ON M.modelid = H.model_id
          LEFT JOIN model_type MT ON I.ir_type = MT.typeid
          LEFT JOIN system_status S ON I.ir_status = S.statusid
          LEFT JOIN shift_detail AS SH ON I.ir_shift = SH.shiftshort
          LEFT JOIN part_side PT ON M.typeside_id = PT.side_id
          WHERE DATE(I.inspect_date) = CURDATE() $shiftCondition
          ORDER BY I.inspect_date DESC";

$result = mysqli_query($db_con, $query);
$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {

        // Result Badge
        $resultBadge = '';
        if ($row['ir_result'] == 'OK') {
            $resultBadge = '<span class="badge badge-rounded badge-black" style="font-size: 11px !important;">OK</span>';
        } elseif ($row['ir_result'] == 'NG') {
            $resultBadge = '<span class="badge badge-rounded badge-oyen" style="font-size: 11px !important;">NG</span>';
        }

        // Status Badge
        $badgeClass = trim($row['badge'] . '-' . $row['badge_color']);
        $textColor = $row['text_color'];
        $iconClass  = $row['icon_class'];

        $statusBadge = '
                <span class="badge badge-rounded ' . $badgeClass . ' badge-sm ' . 'style="color: ' . $textColor . '">                  
                    ' . htmlspecialchars($row['statusname']) . '
                </span>
            ';
        
        $badgeShift = $row["shiftbadge"];
        $shiftDesc = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span></div>';

        // Progress Bar Calculation
        $percent = 0;
        $progressColor = 'bg-black';
        
        if ($row['ir_result'] == 'OK') {
            // OK Path (3 Steps)
            if ($row['ir_status'] == 5) {
                $percent = 100;
                $progressColor = 'bg-oyen';
            } elseif ($row['ir_status'] == 9) {
                $percent = 66;
                $progressColor = 'bg-emerald';
            } else {
                $percent = 33;
                $progressColor = 'bg-beige';
            }
        } else {
            // NG Path (19 Steps)
            // Checking backwards from the end of the workflow
            if ($row['ir_status'] == 5) { 
                $percent = 100; 
                $progressColor = 'bg-oyen';
            } elseif ($row['ir_s2w_ack_status'] == 15) { 
                $percent = round((18/19)*100); 
                $progressColor = 'bg-emerald';
            } elseif ($row['ir_s2w_ack_status'] == 1) { 
                $percent = round((17/19)*100); 
            } elseif ($row['ir_s2w_rp_status'] == 11) { 
                $percent = round((16/19)*100);
                $progressColor = 'bg-primary'; 
            } elseif ($row['ir_s2w_rp_status'] == 10) { 
                $percent = round((15/19)*100); 
            } elseif ($row['ir_s2w_rp_status'] == 13) { 
                $percent = round((14/19)*100); 
            } elseif ($row['ir_s2w_rp_status'] == 1) { 
                $percent = round((13/19)*100); 
            } elseif ($row['ir_s2w_status'] == 4) { 
                $percent = round((12/19)*100); 
            } elseif ($row['ir_s2w_status'] == 10) { 
                $percent = round((11/19)*100); 
            } elseif ($row['ir_s2w_status'] == 9) { 
                $percent = round((10/19)*100); 
            } elseif ($row['ir_s2w_status'] == 13) { 
                $percent = round((9/19)*100); 
            } elseif ($row['ir_s2w_status'] == 1) { 
                $percent = round((8/19)*100); 
            } elseif ($row['ir_sorting_status'] == 11) { 
                $percent = round((7/19)*100); 
            } elseif ($row['ir_sorting_status'] == 9) { 
                $percent = round((6/19)*100); 
            } elseif ($row['ir_sorting_status'] == 13) { 
                $percent = round((5/19)*100); 
            } elseif ($row['ir_sorting_status'] == 1) { 
                $percent = round((4/19)*100); 
                $progressColor = 'bg-primary';
            } elseif ($row['ir_status'] == 11) { 
                $percent = round((3/19)*100); 
                $progressColor = 'bg-primary'; 
            } elseif ($row['ir_status'] == 9) { 
                $percent = round((2/19)*100); 
            } else { 
                $percent = round((1/19)*100); 
                $progressColor = 'bg-beige';
            }
        }

        $progressMarkup = '
            <div class="progress" style="height:6px; width:100px;">
                <div class="progress-bar '.$progressColor.'" style="width: '.$percent.'%;" role="progressbar"></div>
            </div>
            <span class="fs-12">'.$percent.'%</span>
        ';

        $data[] = [
            'doc_no' => '<span class="mb-0" style="font-size: 11px; color: #6c6868ff; font-weight : 500;">'.$row['ir_docno'].'</span>',
            'part_no' => '<h6 class="mb-0 fw-semibold">'.$row["matno"].'</h6><span class="fs-11">'.$row["matdesc"].'</span>',
            'model' => '<h6 class="mb-0 fw-semibold">'.$row["model"].'</h6><span class="fs-11">'.$row["typemodel"].' ('.$row["side_name"].')'.'</span>',
            'shift' => $shiftDesc,
            'pallet_seq' => $row['ir_pallet_no'],
            'result' => $resultBadge,
            'progress' => $progressMarkup,
            'status' => $statusBadge
        ];
    }
}

echo json_encode(['data' => $data]);
?>
