<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';

header('Content-Type: application/json');

$type = $_POST['type'] ?? 'day';
$data = [
    'categories' => [],
    'total' => [],
    'ok' => [],
    'ng' => [],
    'stats' => [
        'total' => 0,
        'ok' => 0,
        'ng' => 0,
        'yield' => 0
    ]
];

switch ($type) {
    case 'day':
        // Last 24 hours or specifically today? Usually 24 hours or 8 hours for a shift.
        // Let's show by hour for the current date.
        $sql = "SELECT HOUR(created_date) as label, 
                       COUNT(*) as total, 
                       SUM(CASE WHEN ir_result = 'OK' THEN 1 ELSE 0 END) as ok, 
                       SUM(CASE WHEN ir_result = 'NG' THEN 1 ELSE 0 END) as ng 
                FROM inspection_records 
                WHERE shift_date = CURDATE() OR created_date >= DATE_SUB(NOW(), INTERVAL 1 DAY)
                GROUP BY label
                ORDER BY label ASC";
        break;
    case 'week':
        $sql = "SELECT DATE_FORMAT(shift_date, '%d %b') as label, 
                       COUNT(*) as total, 
                       SUM(CASE WHEN ir_result = 'OK' THEN 1 ELSE 0 END) as ok, 
                       SUM(CASE WHEN ir_result = 'NG' THEN 1 ELSE 0 END) as ng 
                FROM inspection_records 
                WHERE shift_date >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
                GROUP BY shift_date
                ORDER BY shift_date ASC";
        break;
    case 'month':
        $sql = "SELECT DATE_FORMAT(shift_date, '%d %b') as label, 
                       COUNT(*) as total, 
                       SUM(CASE WHEN ir_result = 'OK' THEN 1 ELSE 0 END) as ok, 
                       SUM(CASE WHEN ir_result = 'NG' THEN 1 ELSE 0 END) as ng 
                FROM inspection_records 
                WHERE shift_date >= DATE_SUB(CURDATE(), INTERVAL 29 DAY)
                GROUP BY shift_date
                ORDER BY shift_date ASC";
        break;
    case 'year':
        $sql = "SELECT DATE_FORMAT(shift_date, '%b %Y') as label, 
                       COUNT(*) as total, 
                       SUM(CASE WHEN ir_result = 'OK' THEN 1 ELSE 0 END) as ok, 
                       SUM(CASE WHEN ir_result = 'NG' THEN 1 ELSE 0 END) as ng 
                FROM inspection_records 
                WHERE shift_date >= DATE_SUB(CURDATE(), INTERVAL 11 MONTH)
                GROUP BY MONTH(shift_date), YEAR(shift_date)
                ORDER BY shift_date ASC";
        break;
    case 'all':
        $sql = "SELECT DATE_FORMAT(shift_date, '%b %Y') as label, 
                       COUNT(*) as total, 
                       SUM(CASE WHEN ir_result = 'OK' THEN 1 ELSE 0 END) as ok, 
                       SUM(CASE WHEN ir_result = 'NG' THEN 1 ELSE 0 END) as ng 
                FROM inspection_records 
                GROUP BY MONTH(shift_date), YEAR(shift_date)
                ORDER BY shift_date ASC";
        break;
    default:
        $sql = "";
}

if ($sql) {
    $result = mysqli_query($db_con, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if ($type === 'day') {
            $data['categories'][] = str_pad($row['label'], 2, '0', STR_PAD_LEFT) . ':00';
        } else {
            $data['categories'][] = $row['label'];
        }
        $data['total'][] = (int)$row['total'];
        $data['ok'][] = (int)$row['ok'];
        $data['ng'][] = (int)$row['ng'];
        
        $data['stats']['total'] += $row['total'];
        $data['stats']['ok'] += $row['ok'];
        $data['stats']['ng'] += $row['ng'];
    }
    
    if ($data['stats']['total'] > 0) {
        $data['stats']['yield'] = round(($data['stats']['ok'] / $data['stats']['total']) * 100, 1);
    }
}

// Format stats for display
$data['stats']['total_fmt'] = number_format($data['stats']['total']);
$data['stats']['ok_fmt'] = number_format($data['stats']['ok']);
$data['stats']['ng_fmt'] = number_format($data['stats']['ng']);
$data['stats']['yield_fmt'] = $data['stats']['yield'] . '%';

echo json_encode($data);
