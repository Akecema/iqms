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

// Base query construction (replicated from fetch-sorting-report-list.php)
$sql_base = " FROM inspection_sorting AS S
                LEFT JOIN inspection_records AS I ON S.sr_ir_id = I.ir_id
                LEFT JOIN model_details AS T ON I.ir_model = T.modid
                LEFT JOIN model_type AS P ON I.ir_type = P.typeid
                LEFT JOIN material_header AS M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
                LEFT JOIN system_status AS ST ON S.sr_status = ST.statusid
                LEFT JOIN employee_details AS E ON S.created_by = E.staff_id
                WHERE S.sr_status = 5 ";

if ($session_role == 4) {
    $sql_base .= " AND S.created_by = '$session_id' ";
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
} else {
    // optional default, uncomment if needed
    // $sql_base .= " AND DATE(I.inspect_date) = CURDATE() ";
}

if (!empty($fd_shift)) {
    $shift = mysqli_real_escape_string($db_con, $fd_shift);
    $sql_base .= " AND I.ir_shift = '$shift' ";
}

$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

$count_query = "SELECT COUNT(S.sr_id) as total " . $sql_base;
$count_result = mysqli_query($db_con, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

$offset = ($page - 1) * $limit;

$query = "SELECT S.sr_id, S.sr_docno, S.sr_qty_ok, S.sr_qty_ng, M.matno, M.matdesc, T.modcode, P.typemodel, M.partside, 
                 I.inspect_date, H.shiftdesc, ST.statusname, E.short_name AS createby, S.created_date " . $sql_base . " ORDER BY S.sr_docno DESC LIMIT $limit OFFSET $offset";

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
    <title>Sorting Report List</title>
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

        .badge-status {
            background-color: #e8f5e9;
            color: #2e7d32;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 700;
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

        .avatar-list-stacked .avatar {
            margin-right: -10px;
            border: 2px solid white;
            transition: transform 0.2s, z-index 0.2s;
            position: relative;
        }

        .avatar-list-stacked .avatar:hover {
            transform: scale(1.1) translateY(-2px);
            z-index: 10;
        }

        .avatar {
            width: 35px;
            height: 35px;
            object-fit: cover;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .avatar-list {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.8);
            justify-content: center;
            align-items: center;
        }

        /* Modal Content (Image) */
        .modal-content {
            display: block;
            max-width: 90%;
            max-height: 90vh;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        /* The Close Button */
        .close {
            position: absolute;
            top: 25px;
            right: 45px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
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
            <h1>Sorting Report</h1>
        </div>

        <div class="section">
            <div class="section-title">Summary Information</div>
            <div class="filter-info">
                <div class="filter-item">
                    <span class="filter-label">Date Range:</span>
                    <span><?= $fd_daterange ?: 'All time' ?></span>
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
                    <span><?= $fd_shift == 'D' ? 'Day' : ($fd_shift == 'N' ? 'Night' : htmlspecialchars($fd_shift)) ?></span>
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
                        <th colspan="8" class="title">SORTING REPORT LIST</th>
                    </tr>
                    <tr>
                        <th class="col-header-center" width="3%">No</th>
                        <th class="col-header" width="13%">Doc No</th>
                        <th class="col-header" width="24%">Part Details</th>
                        <th class="col-header" width="10%">Model</th>
                        <th class="col-header-center" width="8%">Qty OK</th>
                        <th class="col-header-center" width="8%">Qty NG</th>
                        <th class="col-header-center" width="18%">Photos Before (NG)</th>
                        <th class="col-header-center" width="18%">Photos After Sorting (OK)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php 
                        $counter = $offset + 1;
                        while($row = mysqli_fetch_assoc($result)): 
                            $sr_id = $row['sr_id'];

                            // Photos Before (NG)
                            $beforeHtml = '';
                            $sqlBefore = "SELECT before_photo FROM inspection_sorting_before_photo WHERE sr_sorting_id = '$sr_id'";
                            $resBefore = mysqli_query($db_con, $sqlBefore);
                            if ($resBefore && mysqli_num_rows($resBefore) > 0) {
                                $beforeContent = '';
                                while ($photo = mysqli_fetch_assoc($resBefore)) {
                                    $photoUrl = 'gallery/inspection_sorting/before/' . $sr_id . '/' . $photo['before_photo'];
                                    if (file_exists($photoUrl)) {
                                        $beforeContent .= '<img src="'.$photoUrl.'" class="avatar" onclick="zoomImage(this.src)" style="width:30px;height:30px; cursor:pointer;">';
                                    }
                                }
                                if ($beforeContent !== '') {
                                    $beforeHtml = '<div class="avatar-list avatar-list-stacked">' . $beforeContent . '</div>';
                                }
                            }
                            if (empty($beforeHtml)) $beforeHtml = '<span style="color:#64748B;">-</span>';

                            // Photos After Sorting (OK)
                            $afterHtml = '';
                            $sqlAfter = "SELECT after_photo FROM inspection_sorting_after_photo WHERE sr_sorting_id = '$sr_id'";
                            $resAfter = mysqli_query($db_con, $sqlAfter);
                            if ($resAfter && mysqli_num_rows($resAfter) > 0) {
                                $afterContent = '';
                                while ($photo = mysqli_fetch_assoc($resAfter)) {
                                    $photoUrl = 'gallery/inspection_sorting/after/' . $sr_id . '/' . $photo['after_photo'];
                                    if (file_exists($photoUrl)) {
                                        $afterContent .= '<img src="'.$photoUrl.'" class="avatar" onclick="zoomImage(this.src)" style="width:30px;height:30px; cursor:pointer;">';
                                    }
                                }
                                if ($afterContent !== '') {
                                    $afterHtml = '<div class="avatar-list avatar-list-stacked">' . $afterContent . '</div>';
                                }
                            }
                            if (empty($afterHtml)) $afterHtml = '<span style="color:#64748B;">-</span>';
                        ?>
                        <tr>
                            <td style="text-align: center;"><?= $counter++ ?>.</td>
                            <td><strong><?= $row['sr_docno'] ?></strong></td>
                            <td>
                                <strong><?= $row['matno'] ?></strong><br>
                                <span style="font-size: 11px; color: #64748B;"><?= htmlspecialchars($row['matdesc']) ?></span>
                            </td>
                            <td>
                                <strong><?= $row['modcode'] ?></strong><br>
                                <span style="font-size: 11px; color: #64748B;"><?= $row['typemodel'] ?> (<?= $row['partside'] ?>)</span>
                            </td>
                            <td align="center"><strong><?= $row['sr_qty_ok'] ?></strong></td>
                            <td align="center"><strong><?= $row['sr_qty_ng'] ?></strong></td>
                            <td align="center"><?= $beforeHtml ?></td>
                            <td align="center"><?= $afterHtml ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" style="text-align: center; padding: 30px; color: #64748B;">No records found matching the criteria.</td>
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

    <!-- The Modal -->
    <div id="imageModal" class="modal">
        <!-- <span class="close" onclick="closeModal()">&times;</span> -->
        <img class="modal-content" id="zoomedImg">
    </div>

    <script>
        function zoomImage(src) {
            var modal = document.getElementById("imageModal");
            var modalImg = document.getElementById("zoomedImg");
            modal.style.display = "flex";
            modalImg.src = src;
        }

        function closeModal() {
            document.getElementById("imageModal").style.display = "none";
        }

        window.onclick = function(event) {
            var modal = document.getElementById("imageModal");
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
