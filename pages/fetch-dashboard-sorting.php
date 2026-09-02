<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';

header('Content-Type: application/json');

$shift = $_POST['shift'] ?? 'ALL';
$shiftCondition = "";
if ($shift == 'D') {
    $shiftCondition = " AND I.ir_shift = 'D'";
} elseif ($shift == 'N') {
    $shiftCondition = " AND I.ir_shift = 'N'";
}

// User requested inspect_date = today
$query = "SELECT 
            I.ir_id,
            SORT.sr_status,
            SORT.sr_docno AS doc_no,
            M.matno,
            M.matdesc,
            H.model,
            MT.typemodel,
            PT.side_name,
            I.ir_docno as ir_docno,
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
          FROM inspection_sorting SORT
          JOIN inspection_records I ON I.ir_id = SORT.sr_ir_id
          JOIN material_header M ON I.ir_material = M.matid
          JOIN model_hdr H ON M.modelid = H.model_id
          LEFT JOIN model_type MT ON I.ir_type = MT.typeid
          LEFT JOIN system_status S ON SORT.sr_status = S.statusid
          LEFT JOIN shift_detail AS SH ON I.ir_shift = SH.shiftshort
          LEFT JOIN part_side PT ON M.typeside_id = PT.side_id
          WHERE DATE(I.inspect_date) = CURDATE() $shiftCondition
          ORDER BY I.inspect_date DESC";

$result = mysqli_query($db_con, $query);
$data = [];

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {

        // Status Badge
        $badgeClass = trim($row['badge'] . '-' . $row['badge_color']);
        $textColor = $row['text_color'];
        $iconClass  = $row['icon_class'];

        $statusBadge = '
                <span class="badge badge-rounded ' . $badgeClass . ' badge-sm ' . 'style="color: ' . $textColor . '">                  
                    ' . htmlspecialchars($row['statusname'] ?? 'Pending') . '
                </span>
            ';
        
        $badgeShift = $row["shiftbadge"] ?? 'badge-secondary';
        $shiftdesc = $row["shiftdesc"] ?? 'ALL';
        $shiftDescMarkup = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$shiftdesc.'</span></div>';

        // Progress Bar Calculation for Sorting
        $percent = 0;
        $progressColor = 'bg-beige';
        
        $sortStatus = $row['sr_status'];

        if ($sortStatus == 5) { // Completed
            $percent = 100;
            $progressColor = 'bg-oyen';
        } elseif ($sortStatus == 11) { // Review
            $percent = 75;
            $progressColor = 'bg-primary';
        } elseif ($sortStatus == 9) { // Pending Review
            $percent = 50;
            $progressColor = 'bg-emerald';
        } elseif ($sortStatus == 13) { // Draft
            $percent = 25;
            $progressColor = 'bg-beige';
        } else {
            // For Status 1 (Return) or others
            $percent = 0;
            $progressColor = 'bg-bangtan';
        }

        $progressMarkup = '
            <div class="progress" style="height:6px; width:100px;">
                <div class="progress-bar '.$progressColor.'" style="width: '.$percent.'%;" role="progressbar"></div>
            </div>
            <span class="fs-12">'.$percent.'%</span>
        ';

        $docNo = $row['doc_no'] ? $row['doc_no'] : '';
        $sideName = $row["side_name"] ? ' ('.$row["side_name"].')' : '';

        $data[] = [
            'doc_no' => '<h6 class="mb-0 fw-semibold">#Sorting</h6><span class="fs-11">'.$docNo.'</span><br><h6 class="mb-0 fw-semibold mt-2">#Inspection</h6><span class="fs-11">'.$row['ir_docno'].'</span>',
            'part_no' => '<h6 class="mb-0 fw-semibold">'.$row["matno"].'</h6><span class="fs-11">'.$row["matdesc"].'</span>',
            'model' => '<h6 class="mb-0 fw-semibold">'.$row["model"].'</h6><span class="fs-11">'.$row["typemodel"].$sideName.'</span>',
            'shift' => $shiftDescMarkup,
            'progress' => $progressMarkup,
            'status' => $statusBadge
        ];
    }
}

echo json_encode(['data' => $data]);
?>
