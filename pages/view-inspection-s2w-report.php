<!-- FAVICONS ICON -->
<link rel="shortcut icon" type="image/png" href="../icon/favicon.ico">

<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';

$ir_id = isset($_GET['ir_id']) ? mysqli_real_escape_string($db_con, $_GET['ir_id']) : '';
if (empty($ir_id)) die("Missing Record ID");

// Fetch Inspection Record for Doc No
$sql_ir = "SELECT ir_docno FROM inspection_records WHERE ir_id = '$ir_id'";
$res_ir = mysqli_query($db_con, $sql_ir);
$ir_data = mysqli_fetch_assoc($res_ir);

// Fetch S2W Record
$sql_s2w = "SELECT S.*, ST.statusname, D.rd_dept_name,
            E1.staff_name AS created_name, E2.staff_name AS submitted_name, 
            E3.staff_name AS reviewed_name, E4.staff_name AS approved_name
            FROM inspection_s2w S
            LEFT JOIN related_departments D ON S.s2w_send_to = D.rd_dept_id
            LEFT JOIN system_status ST ON S.s2w_status = ST.statusid
            LEFT JOIN employee_details AS E1 ON S.created_by = E1.staff_id
            LEFT JOIN employee_details AS E2 ON S.submitted_by = E2.staff_id
            LEFT JOIN employee_details AS E3 ON S.reviewed_by = E3.staff_id
            LEFT JOIN employee_details AS E4 ON S.approved_by = E4.staff_id
            WHERE S.s2w_ir_id = '$ir_id' AND S.s2w_status = 5";

$res_s2w = mysqli_query($db_con, $sql_s2w);
$s2w = mysqli_fetch_assoc($res_s2w);
if (!$s2w) die("S2W record not found for this inspection.");

$s2w_id = $s2w['s2w_id'];

// Fetch Photos
$defect_photos = [];
$res_defect = mysqli_query($db_con, "SELECT defect_photo FROM inspection_s2w_defect_photo WHERE s2w_id = '$s2w_id'");
while ($row = mysqli_fetch_assoc($res_defect)) $defect_photos[] = $row['defect_photo'];

$ok_photos = [];
$res_ok = mysqli_query($db_con, "SELECT ok_photo FROM inspection_s2w_ok_photo WHERE s2w_id = '$s2w_id'");
while ($row = mysqli_fetch_assoc($res_ok)) $ok_photos[] = $row['ok_photo'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>S2W Report - <?php echo $s2w['s2w_docno']; ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="vendor/lightgallery/css/lightgallery.min.css" rel="stylesheet">
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
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .report-content {
            background-color: white;
            padding: 40px;
            max-width: 900px;
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
            color: white;
            margin: 0;
            font-size: 24px;
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

        .info-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0;
        }

        .info-item {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            border-right: 1px solid var(--border-color);
        }

        .info-item:nth-child(3n) { border-right: none; }

        .label {
            font-size: 11px;
            color: #64748B;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .value {
            font-size: 13px;
            font-weight: 500;
        }

        .photo-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            padding: 15px 20px;
        }

        .photo-box {
            width: 150px;
            height: 150px;
            border: 1px solid var(--border-color);
            border-radius: 4px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .photo-box:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-color: var(--theme-green);
        }

        /* Approval Table overrides removed */

        @media print {
            body { padding: 0; margin: 0; }
            .no-print { display: none; }
            .section { page-break-inside: avoid; margin-bottom: 20px; }
            .report-content { padding: 0 40px; box-shadow: none; border-radius: 0; }
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
            z-index: 100;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">Print</button>

    <div class="report-content">
        <div class="report-header">
            <h1>S2W Report : <?php echo $s2w['s2w_docno']; ?></h1>
        </div>

        <!-- A. S2W Details -->
        <div class="section">
            <div class="section-title">A. S2W Details</div>
            <div class="info-grid">
                <div class="info-item" style="grid-column: span 3;">
                    <div class="label">Additional Information</div>
                    <div class="value"><?php echo nl2br(htmlspecialchars($s2w['s2w_additional_desc'])); ?></div>
                </div>
                <div class="info-item" style="grid-column: span 3; border-bottom: none;">
                    <div class="label">Sending To</div>
                    <div class="value"><?php echo htmlspecialchars($s2w['rd_dept_name'] ?: '-'); ?></div>   
                </div>
            </div>
        </div>

        <!-- B. Photos NG (Defect) -->
        <div class="section">
            <div class="section-title">B. Photos NG (Defect)</div>
            <div class="photo-container lightgallery">
                <?php if (empty($defect_photos)) echo '<div class="value">No photos uploaded</div>'; ?>
                <?php foreach ($defect_photos as $file): 
                    $photo_path = "gallery/inspection_s2w/photo_defect/" . $s2w_id . "/" . $file;
                ?>
                    <a href="<?php echo $photo_path; ?>" class="lg-item">
                        <img src="<?php echo $photo_path; ?>" class="photo-box">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- C. Photo OK -->
        <div class="section">
            <div class="section-title">C. Photo OK</div>
            <div class="photo-container lightgallery">
                <?php if (empty($ok_photos)) echo '<div class="value">No photos uploaded</div>'; ?>
                <?php foreach ($ok_photos as $file): 
                    $photo_path = "gallery/inspection_s2w/photo_ok/" . $s2w_id . "/" . $file;
                ?>
                    <a href="<?php echo $photo_path; ?>" class="lg-item">
                        <img src="<?php echo $photo_path; ?>" class="photo-box">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- D. Approval Details -->
        <div class="section">
            <div class="section-title">D. Action Details</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Created By</div>
                    <div class="value"><?php echo htmlspecialchars($s2w['created_name'] ?: '-'); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Created Date</div>
                    <div class="value"><?php echo (!empty($s2w['created_date']) && strpos($s2w['created_date'], '0000') === false) ? date('d-m-Y H:i A', strtotime($s2w['created_date'])) : '-'; ?></div>
                </div>
                <div class="info-item"></div> <!-- Empty for grid -->
                
                <div class="info-item">
                    <div class="label">Submitted By</div>
                    <div class="value"><?php echo htmlspecialchars($s2w['submitted_name'] ?: '-'); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Submitted Date</div>
                    <div class="value"><?php echo (!empty($s2w['submitted_date']) && strpos($s2w['submitted_date'], '0000') === false) ? date('d-m-Y H:i A', strtotime($s2w['submitted_date'])) : '-'; ?></div>
                </div>
                <div class="info-item"></div> <!-- Empty for grid -->

                <div class="info-item">
                    <div class="label">Reviewed By</div>
                    <div class="value"><?php echo htmlspecialchars($s2w['reviewed_name'] ?: '-'); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Reviewed Date</div>
                    <div class="value"><?php echo (!empty($s2w['reviewed_date']) && strpos($s2w['reviewed_date'], '0000') === false) ? date('d-m-Y H:i A', strtotime($s2w['reviewed_date'])) : '-'; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Reviewed Remark</div>
                    <div class="value"><?php echo htmlspecialchars($s2w['reviewed_remark']) ?: '-'; ?></div>
                </div>

                <div class="info-item">
                    <div class="label">Approved By</div>
                    <div class="value"><?php echo htmlspecialchars($s2w['approved_name'] ?: '-'); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Approved Date</div>
                    <div class="value"><?php echo (!empty($s2w['approved_date']) && strpos($s2w['approved_date'], '0000') === false) ? date('d-m-Y H:i A', strtotime($s2w['approved_date'])) : '-'; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Approved Remark</div>
                    <div class="value"><?php echo htmlspecialchars($s2w['approved_remark']) ?: '-'; ?></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Scripts -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/lightgallery/js/lightgallery-all.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.lightgallery').lightGallery({
                selector: '.lg-item',
                thumbnail: true,
                download: true,
                share: false
            });
        });
    </script>
</body>
</html>
