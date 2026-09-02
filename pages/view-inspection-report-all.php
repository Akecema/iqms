<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';

// Get filters from GET instead of POST for easy linking
$fd_model = $_GET['fd_model'] ?? '';
$fd_type = $_GET['fd_type'] ?? '';
$fd_material = $_GET['fd_material'] ?? '';
$fd_daterange = $_GET['fd_daterange'] ?? '';
$fd_shift = $_GET['fd_shift'] ?? '';
$fd_result = $_GET['fd_result'] ?? '';

// Base query construction (replicated from fetch-inspection-report-list.php)
$sql_base = " FROM inspection_records AS I
                LEFT JOIN model_details AS T ON I.ir_model = T.modid
                LEFT JOIN model_type AS P ON I.ir_type = P.typeid
                LEFT JOIN material_header AS M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
                WHERE I.ir_status = 5 ";

if ($session_role == 4) {
    $sql_base .= " AND I.created_by = '$session_id' ";
}

if (!empty($fd_model)) {
    $model = intval($fd_model);
    $sql_base .= " AND I.ir_model = '$model' ";
}

if (!empty($fd_type)) {
    $type = intval($fd_type);
    $sql_base .= " AND I.ir_type = '$type' ";
}

if (!empty($fd_material)) {
    $material = intval($fd_material);
    $sql_base .= " AND I.ir_material = '$material' ";
}

if (!empty($fd_daterange)) {
    $dates = explode(' - ', $fd_daterange);
    if (count($dates) == 2) {
        $start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
        $end_date = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
        $sql_base .= " AND DATE(I.inspect_date) BETWEEN '$start_date' AND '$end_date' ";
    }
} 
// else {
//     $sql_base .= " AND DATE(I.inspect_date) = CURDATE() ";
// }

if (!empty($fd_shift)) {
    $shift = mysqli_real_escape_string($db_con, $fd_shift);
    $sql_base .= " AND I.ir_shift = '$shift' ";
}

if (!empty($fd_result)) {
    $result = mysqli_real_escape_string($db_con, $fd_result);
    $sql_base .= " AND I.ir_result = '$result' ";
}

$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$count_query = "SELECT COUNT(I.ir_id) as total " . $sql_base;
$count_result = mysqli_query($db_con, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

$offset = ($page - 1) * $limit;

$query = "SELECT I.ir_docno, M.matno, M.matdesc, T.modcode, P.typemodel, M.partside, 
                 I.inspect_date, H.shiftdesc, I.ir_pallet_no, I.ir_result, I.prod_date, I.ir_id " . $sql_base . " ORDER BY I.inspect_date DESC, I.ir_docno DESC LIMIT $limit OFFSET $offset";

$result = mysqli_query($db_con, $query);

// Build query string for existing parameters
$get_params = $_GET;
unset($get_params['page']);
$qs = http_build_query($get_params);
$qs = $qs ? '&' . $qs : '';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inspection Report List</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-green: #085209;
            --theme-green: #337A36;
            --dark-slate: #2C3E50;
            --pale-grey: #F2F4F2;
            --border-color: #E2E8F0;
        }

        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark-slate);
            line-height: 1.5;
            margin: 0;
            padding: 40px;
            background-color: #f8f9fa;
        }

        .report-content {
            background-color: white;
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        
        .report-header {
            text-align: center;
            background-color: var(--theme-green);
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .report-header h1 {
            margin: 0;
            font-size: 22px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .section {
            margin-bottom: 30px;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .section-title {
            background-color: var(--pale-grey);
            color: var(--dark-slate);
            padding: 12px 20px;
            font-weight: 700;
            border-bottom: 3px solid var(--theme-green);
            font-size: 16px;
        }

        .filter-info {
            padding: 15px 20px;
            background: #fff;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .filter-item {
            font-size: 13px;
        }

        .filter-label {
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            font-size: 11px;
            margin-right: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: var(--pale-grey);
            color: var(--dark-slate);
            text-align: left;
            padding: 12px 15px;
            font-size: 12px;
            border-bottom: 2px solid var(--theme-green);
        }

        th.title {
            background-color: var(--theme-green);
            color: #fff;
            text-transform: uppercase;
            padding: 12px 15px;
            font-size: 14px;
            text-align: left;
            border: 1px solid var(--theme-green);
            letter-spacing: 0.5px;
        }

        th.col-header {
            background-color: #F8F9FA;
            color: #0b5122;
            text-align: left;
            padding: 12px 15px;
            font-size: 13px;
            border-top: 2px solid var(--theme-green);
            border-bottom: 2px solid var(--theme-green);
        }

        th.col-header-center {
            background-color: #F8F9FA;
            color: #0b5122;
            text-align: center;
            padding: 12px 15px;
            font-size: 13px;
            border-top: 2px solid var(--theme-green);
            border-bottom: 2px solid var(--theme-green);
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 13px;
        }

        tr:hover {
            background-color: #fcfdfc;
        }

        .badge-ok {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .badge-ng {
            background-color: #ffebee;
            color: #c62828;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .pallet-badge {
            background-color: #f1f5f9;
            color: #475569;
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 11px;
        }

        @media print {
            body { padding: 0; margin: 0; background: none; }
            .no-print { display: none; }
            .report-content { box-shadow: none; padding: 0; max-width: 100%; }
            .section { page-break-inside: auto; }
            tr { page-break-inside: avoid; }
        }

        .btn-print {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1c1b1bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: 600;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
        }

        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 5px;
            margin-top: 25px;
            padding: 15px 0;
            border-top: 1px solid var(--border-color);
        }

        .pagination a, .pagination span {
            padding: 6px 14px;
            border: 1px solid var(--border-color);
            background-color: white;
            color: var(--dark-slate);
            text-decoration: none;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .pagination a:hover {
            background-color: var(--pale-grey);
            border-color: var(--theme-green);
            color: var(--theme-green);
        }

        .pagination .active {
            background-color: var(--theme-green);
            color: white;
            border-color: var(--theme-green);
        }

        .pagination .disabled {
            color: #a0aec0;
            cursor: not-allowed;
            background-color: #f7fafc;
        }

        .pagination-container {
            text-align: center;
            margin-top: 20px;
        }
        
        .pagination-info {
            margin-top: 10px;
            font-size: 13px;
            color: #64748b;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">Print Report</button>

    <div class="report-content">
        <div class="report-header">
            <h1>Inspection Report</h1>
        </div>

        <div class="section">
            <div class="section-title">Summary Information</div>
            <div class="filter-info">
                <div class="filter-item">
                    <span class="filter-label">Date Range:</span>
                    <span><?= $fd_daterange ?: 'Today (' . date('d/m/Y') . ')' ?></span>
                </div>
                <?php if($fd_model): ?>
                <div class="filter-item">
                    <span class="filter-label">Model:</span>
                    <span><?= htmlspecialchars($fd_model) ?></span>
                </div>
                <?php endif; ?>
                <?php if($fd_shift): ?>
                <div class="filter-item">
                    <span class="filter-label">Shift:</span>
                    <span><?= $fd_shift == 'D' ? 'Day' : ($fd_shift == 'N' ? 'Night' : $fd_shift) ?></span>
                </div>
                <?php endif; ?>
                <?php if($fd_result): ?>
                <div class="filter-item">
                    <span class="filter-label">Result:</span>
                    <span class="<?= $fd_result == 'OK' ? 'badge-ok' : 'badge-ng' ?>"><?= $fd_result ?></span>
                </div>
                <?php endif; ?>
                <div class="filter-item" style="margin-left: auto;">
                    <span class="filter-label">Generated:</span>
                    <span><?= date('d M Y, h:i A') ?></span>
                </div>
            </div>

            <table>
                <thead>
                    <tr>
                        <th colspan="9" class="title">INSPECTION REPORT LIST</th>
                    </tr>
                    <tr>
                        <th class="col-header-center" width="3%">No</th>
                        <th class="col-header" width="17%">Doc No</th>
                        <th class="col-header" width="22%">Part Details</th>
                        <th class="col-header" width="14%">Model</th>
                        <th class="col-header-center" width="10%">Inspect Date</th>
                        <th class="col-header-center" width="7%">Shift</th>
                        <th class="col-header-center" width="7%">Pallet</th>
                        <th class="col-header-center" width="8%">Result</th>
                        <th class="col-header-center" width="12%">Prod Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php 
                        $counter = $offset + 1;
                        while($row = mysqli_fetch_assoc($result)): 
                        ?>
                        <tr>
                            <td style="text-align: center;"><?= $counter++ ?>.</td>
                            <td><strong><?= $row['ir_docno'] ?></strong></td>
                            <td>
                                <strong><?= $row['matno'] ?></strong><br>
                                <span style="font-size: 11px; color: #64748B;"><?= htmlspecialchars($row['matdesc']) ?></span>
                            </td>
                            <td>
                                <strong><?= $row['modcode'] ?></strong><br>
                                <span style="font-size: 11px; color: #64748B;"><?= $row['typemodel'] ?> (<?= $row['partside'] ?>)</span>
                            </td>
                            <td style="text-align: center;"><?= date('d-m-Y', strtotime($row['inspect_date'])) ?></td>
                            <td style="text-align: center;"><?= $row['shiftdesc'] ?></td>
                            <td style="text-align: center;"><span class="pallet-badge"><?= $row['ir_pallet_no'] ?></span></td>
                            <td style="text-align: center;">
                                <?php if($row['ir_result'] == 'OK'): ?>
                                    <span class="badge-ok">OK</span>
                                <?php else: ?>
                                    <span class="badge-ng">NG</span>
                                <?php endif; ?>
                            </td>
                            <td style="text-align: center;"><?= ($row['prod_date'] && $row['prod_date'] != '0000-00-00') ? date('d-m-Y', strtotime($row['prod_date'])) : '-' ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 30px; color: #64748B;">No records found matching the criteria.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>

            <div class="pagination-container no-print">
                <?php if ($total_pages > 1): ?>
                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=1<?= $qs ?>">&laquo; First</a>
                            <a href="?page=<?= ($page - 1) ?><?= $qs ?>">&lsaquo; Prev</a>
                        <?php else: ?>
                            <span class="disabled">&laquo; First</span>
                            <span class="disabled">&lsaquo; Prev</span>
                        <?php endif; ?>

                        <?php
                        $start = max(1, $page - 2);
                        $end = min($total_pages, $page + 2);
                        for ($i = $start; $i <= $end; $i++):
                        ?>
                            <?php if ($i == $page): ?>
                                <span class="active"><?= $i ?></span>
                            <?php else: ?>
                                <a href="?page=<?= $i ?><?= $qs ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page < $total_pages): ?>
                            <a href="?page=<?= ($page + 1) ?><?= $qs ?>">Next &rsaquo;</a>
                            <a href="?page=<?= $total_pages ?><?= $qs ?>">Last &raquo;</a>
                        <?php else: ?>
                            <span class="disabled">Next &rsaquo;</span>
                            <span class="disabled">Last &raquo;</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <div class="pagination-info">
                    Showing <?php echo $total_records > 0 ? $offset + 1 : 0; ?> - <?php echo min($offset + $limit, $total_records); ?> of <?= $total_records ?> records
                </div>
            </div>
            
        </div>
    </div>
</body>
</html>
