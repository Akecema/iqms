<?php
include '../db/db_connect.php';

$shift_date = $_POST['shift_date'] ?? date('Y-m-d');
$shift      = $_POST['shift'] ?? 'ALL';

// IMPORTANT: match your column name (you use I.ir_shift)
$shiftCondition = "";
if ($shift === 'D') $shiftCondition = "AND I.ir_shift = 'D'";
if ($shift === 'N') $shiftCondition = "AND I.ir_shift = 'N'";

// ===== COUNTS =====
$countOK = (int)mysqli_fetch_assoc(mysqli_query($db_con, "
  SELECT COUNT(*) c FROM inspection_records I
  WHERE I.ir_result='OK' AND I.shift_date='$shift_date' $shiftCondition
"))['c'];

$countNG = (int)mysqli_fetch_assoc(mysqli_query($db_con, "
  SELECT COUNT(*) c FROM inspection_records I
  WHERE I.ir_result='NG' AND I.shift_date='$shift_date' $shiftCondition
"))['c'];

$totalInspected = $countOK + $countNG;
$yield = $totalInspected ? round(($countOK/$totalInspected)*100, 1) : 0;

// ===== STATUS SERIES =====
$countInProgress = (int)mysqli_fetch_assoc(mysqli_query($db_con, "
  SELECT COUNT(*) c FROM inspection_records I
  WHERE I.ir_result!='' AND I.shift_date='$shift_date' $shiftCondition
    AND (I.ir_status=1 OR I.ir_status=13)
"))['c'];

$countPending = (int)mysqli_fetch_assoc(mysqli_query($db_con, "
  SELECT COUNT(*) c FROM inspection_records I
  WHERE I.ir_result!='' AND I.shift_date='$shift_date' $shiftCondition
    AND (I.ir_status IN(9)
      OR I.ir_sorting_status=9
      OR I.ir_s2w_status IN(9,10)
      OR I.ir_s2w_rp_status=10
      OR I.ir_s2w_ack_status=14)
"))['c'];

$countCompleted = (int)mysqli_fetch_assoc(mysqli_query($db_con, "
  SELECT COUNT(*) c FROM inspection_records I
  WHERE I.ir_result!='' AND I.shift_date='$shift_date' $shiftCondition
    AND I.ir_status=5
"))['c'];

$countReject = (int)mysqli_fetch_assoc(mysqli_query($db_con, "
  SELECT COUNT(*) c FROM inspection_records I
  WHERE I.ir_result!='' AND I.shift_date='$shift_date' $shiftCondition
    AND I.ir_s2w_ack_status IN(12,16)
"))['c'];

$statusSeries = [$countInProgress, $countPending, $countCompleted, $countReject];

// ===== STACKED CHART (categories + series) =====
// Build categories (models)
$resModels = mysqli_query($db_con, "SELECT model_id, model FROM model_hdr WHERE model_status='AC' ORDER BY model ASC");
$stackedCategories = [];
$modelIndexMap = [];
$i = 0;
while($r = mysqli_fetch_assoc($resModels)){
  $stackedCategories[] = $r['model'];
  $modelIndexMap[$r['model_id']] = $i++;
}
$modelCount = count($stackedCategories);

// Build series (types)
$resTypes = mysqli_query($db_con, "SELECT typeid, typemodel FROM model_type WHERE typestatus='Y' ORDER BY typemodel ASC");
$stackedSeries = [];
$typeMatrix = [];
while($r = mysqli_fetch_assoc($resTypes)){
  $typeMatrix[$r['typeid']] = count($stackedSeries);
  $stackedSeries[] = [
    "name" => $r['typemodel'],
    "data" => array_fill(0, $modelCount, 0)
  ];
}

// Fill series data
$resDef = mysqli_query($db_con, "
  SELECT mh.modelid, mh.typeid, COUNT(I.ir_id) defect_count
  FROM inspection_records I
  JOIN material_header mh ON I.ir_material = mh.matid
  WHERE I.ir_result='OK' AND I.shift_date='$shift_date' $shiftCondition
  GROUP BY mh.modelid, mh.typeid
");
while($r = mysqli_fetch_assoc($resDef)){
  $mid = $r['modelid']; $tid = $r['typeid'];
  if(isset($modelIndexMap[$mid]) && isset($typeMatrix[$tid])){
    $stackedSeries[$typeMatrix[$tid]]['data'][$modelIndexMap[$mid]] = (int)$r['defect_count'];
  }
}

// ===== DEFECT LIST HTML =====
ob_start();
// (render your defect list here based on query using $shiftCondition)
echo "<div class='text-white'>...</div>";
$defectHtml = ob_get_clean();

// ===== PART TYPE HTML =====
ob_start();
// (render your part type list here based on query using $shiftCondition)
echo "<div class='text-white'>...</div>";
$partTypeHtml = ob_get_clean();

header('Content-Type: application/json');
echo json_encode([
  "stats" => [
    "total" => number_format($totalInspected),
    "ok"    => number_format($countOK),
    "ng"    => number_format($countNG),
    "yield" => $yield . "%"
  ],
  "statusSeries" => $statusSeries,
  "stackedCategories" => $stackedCategories,
  "stackedSeries" => $stackedSeries,
  "defectHtml" => $defectHtml,
  "partTypeHtml" => $partTypeHtml
]);