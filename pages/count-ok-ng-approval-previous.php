<?php
include '../db/db_connect.php';
include 'system-status.php';

$action = $_POST['action'] ?? '';
$shift = $_POST['shift'] ?? '';
$shift_date = $_POST['shift_date'] ?? '';
$model_id = $_POST['model'] ?? '';
$type_id = $_POST['type'] ?? '';
$material_id = $_POST['material'] ?? '';
$fd_daterange = $_POST['fd_daterange'] ?? '';

// Set default to prevent undefined $query
$query = '';
$params = [];
$types = '';

if($action == 'fetch_pending')
{    
    $query = "SELECT ir_result FROM inspection_records WHERE ir_status = ? AND DATE(shift_date) < ?";
    $params = [$s_pendReview_id, $shift_date];
    $types = "is";
}
elseif ($action == 'fetch_approved')
{    
    $query = "SELECT ir_result FROM inspection_records WHERE ir_status = ?  AND DATE(shift_date) < ?";
    $params = [$s_approved_id, $shift_date];
    $types = "is";
}
elseif ($action == 'fetch_completed')
{    
    $query = "SELECT ir_result FROM inspection_records WHERE ir_status = ? AND DATE(shift_date) < ?";
    $params = [$s_completed_id, $shift_date];
    $types = "is";
}

// Optional filters
if (!empty($model_id)) {
    $query .= " AND ir_model = ?";
    $types .= "i";
    $params[] = $model_id;
}
if (!empty($type_id)) {
    $query .= " AND ir_type = ?";
    $types .= "i";
    $params[] = $type_id;
}
if (!empty($material_id)) {
    $query .= " AND ir_material = ?";
    $types .= "i";
    $params[] = $material_id;
}

if (!empty($fd_daterange)) {
    // split by hyphen or en-dash with optional spaces
    $parts = preg_split('/\s*[-–]\s*/', trim($fd_daterange));
    if (count($parts) === 2) {
        $d1 = trim($parts[0]);
        $d2 = trim($parts[1]);

        // try d/m/Y first, then d-m-Y
        $s1 = DateTime::createFromFormat('d/m/Y', $d1) ?: DateTime::createFromFormat('d-m-Y', $d1);
        $s2 = DateTime::createFromFormat('d/m/Y', $d2) ?: DateTime::createFromFormat('d-m-Y', $d2);

        if ($s1 && $s2) {
            $start_date = $s1->format('Y-m-d');
            $end_date   = $s2->format('Y-m-d');

            // BETWEEN is inclusive on both ends; if shift_date has time, prefer >= and < next day.
            $query  .= " AND (DATE(shift_date) BETWEEN ? AND ? )";
            $types  .= "ss";
            $params[] = $start_date;
            $params[] = $end_date;          // push second value separately
            // or: array_push($params, $start_date, $end_date);
        }
    }
}

$stmt = $db_con->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$result = $stmt->get_result();

$total_ok = 0;
$total_ng = 0;

while ($row = $result->fetch_assoc()) {

    $result_val = strtoupper(trim($row['ir_result']));

    if ($result_val === 'OK') $total_ok++;
    elseif ($result_val === 'NG') $total_ng++;
}

echo json_encode([
    'ok' => $total_ok,
    'ng' => $total_ng
]);

