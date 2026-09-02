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

// Fetch S2W Reply Record
$sql_reply = "SELECT rp.*,
            E1.staff_name AS created_name, E2.staff_name AS submitted_name, 
            E3.staff_name AS approved_name
            FROM inspection_s2w_report rp
            LEFT JOIN employee_details AS E1 ON rp.created_by = E1.staff_id
            LEFT JOIN employee_details AS E2 ON rp.submitted_by = E2.staff_id
            LEFT JOIN employee_details AS E3 ON rp.approved_by = E3.staff_id
            WHERE rp.rp_s2w_ir_id = '$ir_id'";

$res_reply = mysqli_query($db_con, $sql_reply);
$reply = mysqli_fetch_assoc($res_reply);
if (!$reply) die("S2W Reply record not found for this inspection.");

$rp_id = $reply['rp_id'];

// Fetch Photos
$correction_photos = [];
$res_corr = mysqli_query($db_con, "SELECT correction_photo FROM inspection_s2w_correction_photo WHERE s2w_rp_id = '$rp_id'");
while ($row = mysqli_fetch_assoc($res_corr)) $correction_photos[] = $row['correction_photo'];

$preventive_photos = [];
$res_prev = mysqli_query($db_con, "SELECT preventive_photo FROM inspection_s2w_preventive_photo WHERE s2w_rp_id = '$rp_id'");
while ($row = mysqli_fetch_assoc($res_prev)) $preventive_photos[] = $row['preventive_photo'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>S2W Reply Report - <?php echo $ir_data['ir_docno']; ?></title>
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
        }

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
            <h1>S2W Reply Report : <?php echo htmlspecialchars($ir_data['ir_docno']); ?></h1>
        </div>

        <!-- A. S2W Reply Details -->
        <div class="section">
            <div class="section-title">A. S2W Reply Details</div>
            <div class="info-grid">
                <div class="info-item" style="grid-column: span 3;">
                    <div class="label">Chronology</div>
                    <div class="value"><?php echo nl2br(htmlspecialchars($reply['rp_s2w_cronology'] ?: '-')); ?></div>
                </div>
                <div class="info-item" style="grid-column: span 3;">
                    <div class="label">Root Cause</div>
                    <div class="value"><?php echo nl2br(htmlspecialchars($reply['rp_s2w_rootcause'] ?: '-')); ?></div>
                </div>
                <div class="info-item" style="grid-column: span 3;">
                    <div class="label">Root Cause Area</div>
                    <div class="value"><?php echo htmlspecialchars($reply['rp_s2w_rootcause_area'] ?: '-'); ?></div>
                </div>
                <div class="info-item" style="grid-column: span 3;">
                    <div class="label">Root Cause Place</div>
                    <div class="value"><?php echo htmlspecialchars($reply['rp_s2w_rootcause_place'] ?: '-'); ?></div>
                </div>
              
                
                <div class="info-item" style="grid-column: span 3;">
                    <div class="label">Correction</div>
                    <div class="value"><?php echo nl2br(htmlspecialchars($reply['rp_s2w_correction'] ?: '-')); ?></div>
                </div>
                <div class="info-item" style="grid-column: span 3;">
                    <div class="label">Preventive</div>
                    <div class="value"><?php echo nl2br(htmlspecialchars($reply['rp_s2w_preventive'] ?: '-')); ?></div>
                </div>
                <div class="info-item" style="grid-column: span 3; border-bottom: none;">
                    <div class="label">Conclusion</div>
                    <div class="value"><?php echo nl2br(htmlspecialchars($reply['rp_s2w_conclusion'] ?: '-')); ?></div>
                </div>
            </div>
        </div>

        <!-- B. Correction Photos -->
        <div class="section">
            <div class="section-title">B. Correction Photos</div>
            <div class="photo-container">
                <?php if (empty($correction_photos)) echo '<div class="value">No photos uploaded</div>'; ?>
                <?php foreach ($correction_photos as $file): ?>
                    <img src="gallery/inspection_s2w_report/photo_correction/<?php echo $rp_id; ?>/<?php echo $file; ?>" class="photo-box">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- C. Preventive Photos -->
        <div class="section">
            <div class="section-title">C. Preventive Photos</div>
            <div class="photo-container">
                <?php if (empty($preventive_photos)) echo '<div class="value">No photos uploaded</div>'; ?>
                <?php foreach ($preventive_photos as $file): ?>
                    <img src="gallery/inspection_s2w_report/photo_preventive/<?php echo $rp_id; ?>/<?php echo $file; ?>" class="photo-box">
                <?php endforeach; ?>
            </div>
        </div>

        <!-- D. Approval Details -->
        <div class="section">
            <div class="section-title">D. Action Details</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Created By</div>
                    <div class="value"><?php echo htmlspecialchars($reply['created_name'] ?: '-'); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Created Date</div>
                    <div class="value"><?php echo (!empty($reply['created_date']) && strpos($reply['created_date'], '0000') === false) ? date('d-m-Y H:i A', strtotime($reply['created_date'])) : '-'; ?></div>
                </div>
                <div class="info-item"></div> <!-- Empty for grid -->
                
                <div class="info-item">
                    <div class="label">Submitted By</div>
                    <div class="value"><?php echo htmlspecialchars($reply['submitted_name'] ?: '-'); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Submitted Date</div>
                    <div class="value"><?php echo (!empty($reply['submitted_date']) && strpos($reply['submitted_date'], '0000') === false) ? date('d-m-Y H:i A', strtotime($reply['submitted_date'])) : '-'; ?></div>
                </div>
                <div class="info-item"></div> <!-- Empty for grid -->

                <div class="info-item">
                    <div class="label">Approved By</div>
                    <div class="value"><?php echo htmlspecialchars($reply['approved_name'] ?: '-'); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Approved Date</div>
                    <div class="value"><?php echo (!empty($reply['approved_date']) && strpos($reply['approved_date'], '0000') === false) ? date('d-m-Y H:i A', strtotime($reply['approved_date'])) : '-'; ?></div>
                </div>
                <div class="info-item" style="grid-column: span 1; border-bottom: none;">
                    <div class="label">Approved Remark</div>
                    <div class="value"><?php echo htmlspecialchars($reply['approved_remark']) ?: '-'; ?></div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
