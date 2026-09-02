<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';

// Get filters from GET
$fd_model = $_GET['fd_model'] ?? '';
$fd_type = $_GET['fd_type'] ?? '';
$fd_material = $_GET['fd_material'] ?? '';
$fd_daterange = $_GET['fd_daterange'] ?? '';
$fd_shift = $_GET['fd_shift'] ?? '';

// Base query construction
$sql_base = " FROM inspection_s2w_report AS SR
                LEFT JOIN inspection_s2w AS S ON SR.rp_s2w_id = S.s2w_id
                LEFT JOIN inspection_records AS I ON SR.rp_s2w_ir_id = I.ir_id
                LEFT JOIN model_details AS T ON I.ir_model = T.modid
                LEFT JOIN model_type AS P ON I.ir_type = P.typeid
                LEFT JOIN material_header AS M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
                WHERE SR.rp_s2w_status = 5 ";

if ($session_role == 4) {
    $sql_base .= " AND SR.created_by = '$session_id' ";
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

if (!empty($fd_shift)) {
    $shift = mysqli_real_escape_string($db_con, $fd_shift);
    $sql_base .= " AND I.ir_shift = '$shift' ";
}

// Pagination Logic
$limit = 20;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Count total records
$count_query = "SELECT COUNT(*) as total " . $sql_base;
$count_res = mysqli_query($db_con, $count_query);
$count_row = mysqli_fetch_assoc($count_res);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);
if ($page > $total_pages && $total_pages > 0) $page = $total_pages;
$offset = ($page - 1) * $limit;

// Main Query
$query = "SELECT SR.rp_id, SR.rp_s2w_docno, M.matno, M.matdesc, T.modcode, P.typemodel, M.partside, 
                 I.inspect_date " . $sql_base . " ORDER BY SR.rp_s2w_docno DESC LIMIT $offset, $limit";

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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>S2W Reply Report List</title>
    <style>
        :root {
            --theme-green: #337A36;
            --dark-slate: #2D3748;
            --pale-grey: #F8F9FA;
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

        /* .report-header {
            border-bottom: 3px solid var(--theme-green);
            padding-bottom: 15px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .report-header h1 {
            color: var(--theme-green);
            margin: 0;
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 1px;
        } */

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

        .btn-print:hover {
            background-color: #2a632c;
            transform: translateY(-1px);
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
            color: var(--theme-green);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 12px;
            padding: 12px 10px;
            border-bottom: 2px solid var(--theme-green);
            text-align: left;
        }

        th.col-header-center {
            text-align: center;
        }

        th.title {
            background-color: var(--theme-green);
            color: #fff;
            text-align: center;
            font-size: 16px;
            padding: 15px;
            border: none;
        }

        td {
            padding: 12px 10px;
            border-bottom: 1px solid var(--border-color);
            font-size: 13px;
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #f8fafc;
        }

        .avatar-list-stacked {
            display: flex;
            justify-content: center;
        }

        .avatar-list-stacked .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #fff;
            margin-left: -12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: all 0.2s;
            object-fit: cover;
        }

        .avatar-list-stacked .avatar:first-child {
            margin-left: 0;
        }

        .avatar-list-stacked .avatar:hover {
            transform: translateY(-3px) scale(1.1);
            z-index: 10;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.85);
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(5px);
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            border-radius: 8px;
            box-shadow: 0 0 30px rgba(0,0,0,0.5);
            animation: zoom 0.3s ease-out;
        }

        @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
        }

        .pagination-container {
            text-align: center;
            margin-top: 20px;
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

        .pagination-info {
            margin-top: 10px;
            font-size: 13px;
            color: #64748b;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                background-color: #fff;
                padding: 0;
            }
            .report-content {
                box-shadow: none;
                max-width: 100%;
                padding: 0;
            }
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">Print Report</button>

    <div class="report-content">
        <div class="report-header">
            <h1>Reply Something When Wrong (S2W)</h1>
        </div>

        <div class="section">
            <div class="section-title">Summary Information</div>
            <div class="filter-info">
                <div class="filter-item">
                    <span class="filter-label">Date Range:</span>
                    <span><?= $fd_daterange ?: 'All time' ?></span>
                </div>
                <?php if($fd_model): ?>
                <?php
                    $m_query = "SELECT modcode FROM model_details WHERE modid = " . intval($fd_model);
                    $m_res = mysqli_query($db_con, $m_query);
                    $m_row = mysqli_fetch_assoc($m_res);
                ?>
                <div class="filter-item">
                    <span class="filter-label">Model:</span>
                    <span><?= htmlspecialchars($m_row['modcode']) ?></span>
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
                        <th colspan="6" class="title">S2W REPLY REPORT LIST</th>
                    </tr>
                    <tr>
                        <th class="col-header-center" width="3%">No</th>
                        <th class="col-header" width="15%">Doc No</th>
                        <th class="col-header" width="27%">Part Details</th>
                        <th class="col-header" width="15%">Model</th>
                        <th class="col-header-center" width="20%">Correction Photos</th>
                        <th class="col-header-center" width="20%">Preventive Photos</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php 
                        $counter = $offset + 1;
                        while($row = mysqli_fetch_assoc($result)): 
                            $rp_id = $row['rp_id'];

                            // Correction Photos
                            $correctionHtml = '';
                            $sqlCr = "SELECT correction_photo FROM inspection_s2w_correction_photo WHERE s2w_rp_id = '$rp_id'";
                            $resCr = mysqli_query($db_con, $sqlCr);
                            if ($resCr && mysqli_num_rows($resCr) > 0) {
                                $crContent = '';
                                while ($photo = mysqli_fetch_assoc($resCr)) {
                                    $photoUrl = 'gallery/inspection_s2w_report/photo_correction/' . $rp_id . '/' . $photo['correction_photo'];
                                    if (file_exists($photoUrl)) {
                                        $crContent .= '<img src="'.$photoUrl.'" class="avatar" onclick="zoomImage(this.src)" style="cursor:pointer;">';
                                    }
                                }
                                if ($crContent !== '') {
                                    $correctionHtml = '<div class="avatar-list avatar-list-stacked">' . $crContent . '</div>';
                                }
                            }
                            if (empty($correctionHtml)) $correctionHtml = '<span style="color:#64748B;">-</span>';

                            // Preventive Photos
                            $preventiveHtml = '';
                            $sqlPr = "SELECT preventive_photo FROM inspection_s2w_preventive_photo WHERE s2w_rp_id = '$rp_id'";
                            $resPr = mysqli_query($db_con, $sqlPr);
                            if ($resPr && mysqli_num_rows($resPr) > 0) {
                                $prContent = '';
                                while ($photo = mysqli_fetch_assoc($resPr)) {
                                    $photoUrl = 'gallery/inspection_s2w_report/photo_preventive/' . $rp_id . '/' . $photo['preventive_photo'];
                                    if (file_exists($photoUrl)) {
                                        $prContent .= '<img src="'.$photoUrl.'" class="avatar" onclick="zoomImage(this.src)" style="cursor:pointer;">';
                                    }
                                }
                                if ($prContent !== '') {
                                    $preventiveHtml = '<div class="avatar-list avatar-list-stacked">' . $prContent . '</div>';
                                }
                            }
                            if (empty($preventiveHtml)) $preventiveHtml = '<span style="color:#64748B;">-</span>';
                        ?>
                        <tr>
                            <td style="text-align: center;"><?= $counter++ ?>.</td>
                            <td><strong><?= $row['rp_s2w_docno'] ?></strong></td>
                            <td>
                                <strong><?= $row['matno'] ?></strong><br>
                                <span style="font-size: 11px; color: #64748B;"><?= htmlspecialchars($row['matdesc']) ?></span>
                            </td>
                            <td>
                                <strong><?= $row['modcode'] ?></strong><br>
                                <span style="font-size: 11px; color: #64748B;"><?= $row['typemodel'] ?> (<?= $row['partside'] ?>)</span>
                            </td>
                            <td align="center"><?= $correctionHtml ?></td>
                            <td align="center"><?= $preventiveHtml ?></td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: #64748B;">No records found matching the criteria.</td>
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
        <img class="modal-content" id="zoomedImg">
    </div>

    <script>
        function zoomImage(src) {
            var modal = document.getElementById("imageModal");
            var modalImg = document.getElementById("zoomedImg");
            modal.style.display = "flex";
            modalImg.src = src;
        }

        document.getElementById("imageModal").onclick = function() {
            this.style.display = "none";
        }
    </script>
</body>
</html>
