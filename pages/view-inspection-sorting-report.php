<!-- FAVICONS ICON -->
<link rel="shortcut icon" type="image/png" href="../icon/favicon.ico">

<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';

$ir_id = isset($_GET['ir_id']) ? mysqli_real_escape_string($db_con, $_GET['ir_id']) : '';
if (empty($ir_id)) die("Missing Record ID");

// 1. Fetch Inspection Record (Head Part)
$sql = "SELECT I.*, H.shiftdesc, E1.staff_name AS created_by_name, E2.staff_name AS submitted_by_name, 
               E3.staff_name AS reviewed_by_name, MAT.matno, MAT.matdesc, MD.modcode, MAT.partside, MT.typemodel
        FROM inspection_records AS I
        LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
        LEFT JOIN employee_details AS E1 ON I.created_by = E1.staff_id
        LEFT JOIN employee_details AS E2 ON I.submitted_by = E2.staff_id
        LEFT JOIN employee_details AS E3 ON I.reviewed_by = E3.staff_id
        LEFT JOIN material_header AS MAT ON I.ir_material = MAT.matid
        LEFT JOIN model_details AS MD ON I.ir_model = MD.modid
        LEFT JOIN model_type AS MT ON I.ir_type = MT.typeid
        WHERE I.ir_id = '$ir_id'";

$result = mysqli_query($db_con, $sql);
$data = mysqli_fetch_assoc($result);
if (!$data) die("Record not found");

// 2. Fetch Sorting Record
$sql_sorting = "SELECT S.*, E1.staff_name AS s_created_by_name, E2.staff_name AS s_submitted_by_name, 
                       E3.staff_name AS s_approved_by_name, E4.staff_name AS s_reviewed_by_name,
                       ST.statusname
                FROM inspection_sorting S
                LEFT JOIN system_status ST ON S.sr_status = ST.statusid
                LEFT JOIN employee_details AS E1 ON S.created_by = E1.staff_id
                LEFT JOIN employee_details AS E2 ON S.submitted_by = E2.staff_id
                LEFT JOIN employee_details AS E3 ON S.approved_by = E3.staff_id
                LEFT JOIN employee_details AS E4 ON S.reviewed_by = E4.staff_id
                WHERE S.sr_ir_id = '$ir_id' AND S.sr_status != 13"; // Not cancelled

$res_sorting = mysqli_query($db_con, $sql_sorting);
$sorting = mysqli_fetch_assoc($res_sorting);
if (!$sorting) die("Sorting record not found for this inspection.");

$sr_id = $sorting['sr_id'];

// 3. Fetch Photos
$before_photos = [];
$res_before = mysqli_query($db_con, "SELECT before_photo FROM inspection_sorting_before_photo WHERE sr_sorting_id = '$sr_id'");
while ($row = mysqli_fetch_assoc($res_before)) $before_photos[] = $row['before_photo'];

$after_photos = [];
$res_after = mysqli_query($db_con, "SELECT after_photo FROM inspection_sorting_after_photo WHERE sr_sorting_id = '$sr_id'");
while ($row = mysqli_fetch_assoc($res_after)) $after_photos[] = $row['after_photo'];

// 4. Fetch Related Parts
$inhouse_parts = [];
$res_inhouse = mysqli_query($db_con, "SELECT p.*, d.rd_dept_name, t.tp_partname, m.bom, m.bomdesc 
                                       FROM inspection_sorting_related_part_dept p
                                       LEFT JOIN related_departments d ON p.srp_related_dept = d.rd_dept_id
                                       LEFT JOIN type_part t ON p.srp_type_part_dept = t.tp_partid
                                       LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
                                       WHERE p.srp_ir_id_sorting = '$sr_id'");
while ($row = mysqli_fetch_assoc($res_inhouse)) $inhouse_parts[] = $row;

$vendor_parts = [];
$res_vendor = mysqli_query($db_con, "SELECT p.*, v.rv_vendor_name, t.tp_partname, m.bom, m.bomdesc 
                                      FROM inspection_sorting_related_part_vendor p
                                      LEFT JOIN related_vendors v ON p.srp_related_vdr = v.rv_vendor_id
                                      LEFT JOIN type_part t ON p.srp_type_part_vdr = t.tp_partid
                                      LEFT JOIN material_details m ON p.srp_mathdr_id_vdr = m.matdet_id
                                      WHERE p.srp_ir_id_sorting = '$sr_id'");
while ($row = mysqli_fetch_assoc($res_vendor)) $vendor_parts[] = $row;

$customer_parts = [];
$res_customer = mysqli_query($db_con, "SELECT p.*, c.rc_cust_name 
                                        FROM inspection_sorting_related_part_cust p
                                        LEFT JOIN related_customers c ON p.srp_related_cust = c.rc_cust_id
                                        WHERE p.srp_ir_id_sorting = '$sr_id'");
while ($row = mysqli_fetch_assoc($res_customer)) $customer_parts[] = $row;

$resultColor = ($data['ir_result'] == 'OK') ? '#085209' : '#FF0000';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sorting Report - <?php echo $sorting['sr_docno']; ?></title>
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
            color: var(--dark-slate);
            line-height: 1.5;
            margin: 0;
            padding: 40px;
            background-color: #fff;
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

        .section table {
            width: 100%;
            border-collapse: collapse;
        }

        .section th {
            background-color: var(--pale-grey);
            color: var(--dark-slate);
            text-align: left;
            padding: 12px 15px;
            font-size: 12px;
            border-bottom: 2px solid var(--theme-green);
        }

        .section td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 13px;
        }

        .photo-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            padding: 15px 20px;
        }

        .photo-box {
            width: 120px;
            height: 120px;
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

        @media print {
            body { padding: 0; margin: 0; }
            .no-print { display: none; }
            .section { page-break-inside: avoid; margin-bottom: 20px; }
            .report-content { padding: 0 40px; }
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
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">Print</button>

    <div class="report-content">
        <div class="report-header">
            <h1>Sorting Report : <?php echo $sorting['sr_docno']; ?></h1>
        </div>

        <!-- A. Inspection Summary -->
        <div class="section">
            <div class="section-title">A. Inspection Summary</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Document No</div>
                    <div class="value"><?php echo $sorting['sr_docno']; ?></div>
                </div>
                <div class="info-item">
                    
                </div>
                <div class="info-item">
                    
                </div>
                <div class="info-item">
                    <div class="label">Quantity OK</div>
                    <div class="value" style="color: green;"><?php echo number_format($sorting['sr_qty_ok']); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Quantity NG</div>
                    <div class="value" style="color: red;"><?php echo number_format($sorting['sr_qty_ng']); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Total Quantity</div>
                    <div class="value"><?php echo number_format($sorting['sr_qty_ok'] + $sorting['sr_qty_ng']); ?></div>
                </div>
            </div>
        </div>

        <!-- B. Sorting Details -->
        <div class="section">
            <div class="section-title">B. Sorting Details</div>
            <div style="padding: 15px 20px;">
                <div class="label">Sorting Method</div>
                <div class="value" style="margin-bottom: 15px;"><?php echo nl2br($sorting['sr_sorting_method']); ?></div>
                
                <div class="label">Rework Method</div>
                <div class="value" style="margin-bottom: 15px;"><?php echo nl2br($sorting['sr_rework_method']); ?></div>
                
                <div class="label">Remarks</div>
                <div class="value"><?php echo nl2br($sorting['sr_remarks']); ?></div>
            </div>
        </div>

        <!-- C. Photos Before Sorting (NG) -->
        <div class="section">
            <div class="section-title">C. Photos Before Sorting (NG)</div>
            <div class="photo-container lightgallery">
                <?php if (empty($before_photos)) echo '<div class="value">No photos uploaded</div>'; ?>
                <?php foreach ($before_photos as $file): 
                    $photo_path = "gallery/inspection_sorting/before/" . $sr_id . "/" . $file;
                ?>
                    <a href="<?php echo $photo_path; ?>" data-exthumbimage="<?php echo $photo_path; ?>" data-src="<?php echo $photo_path; ?>" class="lg-item">
                        <img src="<?php echo $photo_path; ?>" class="photo-box">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- D. Photos After Sorting (OK) -->
        <div class="section">
            <div class="section-title">D. Photos After Sorting (OK)</div>
            <div class="photo-container lightgallery">
                <?php if (empty($after_photos)) echo '<div class="value">No photos uploaded</div>'; ?>
                <?php foreach ($after_photos as $file): 
                    $photo_path = "gallery/inspection_sorting/after/" . $sr_id . "/" . $file;
                ?>
                    <a href="<?php echo $photo_path; ?>" data-exthumbimage="<?php echo $photo_path; ?>" data-src="<?php echo $photo_path; ?>" class="lg-item">
                        <img src="<?php echo $photo_path; ?>" class="photo-box">
                    </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- E. Parts Involve -->
        <?php if (!empty($inhouse_parts)): ?>
        <div class="section">
            <div class="section-title">E. Related Loose Parts - In House</div>
            <table>
                <thead>
                    <tr>
                        <th>Department</th>
                        <th>Type</th>
                        <th>Part No</th>
                        <th>Part Name</th>
                        <th>Qty OK</th>
                        <th>Qty NG</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inhouse_parts as $p): ?>
                    <tr>
                        <td><?php echo $p['rd_dept_name']; ?></td>
                        <td><?php echo $p['tp_partname']; ?></td>
                        <td><?php echo $p['bom']; ?></td>
                        <td><?php echo $p['bomdesc']; ?></td>
                        <td><?php echo number_format($p['srp_qty_ok_dept']); ?></td>
                        <td><?php echo number_format($p['srp_qty_ng_dept']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <?php if (!empty($vendor_parts)): ?>
        <div class="section">
            <div class="section-title">F. Related Loose Parts - Vendor</div>
            <table>
                <thead>
                    <tr>
                        <th>Vendor</th>
                        <th>Type</th>
                        <th>Part No</th>
                        <th>Part Name</th>
                        <th>Qty OK</th>
                        <th>Qty NG</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vendor_parts as $p): ?>
                    <tr>
                        <td><?php echo $p['rv_vendor_name']; ?></td>
                        <td><?php echo $p['tp_partname']; ?></td>
                        <td><?php echo $p['bom']; ?></td>
                        <td><?php echo $p['bomdesc']; ?></td>
                        <td><?php echo number_format($p['srp_qty_ok_vdr']); ?></td>
                        <td><?php echo number_format($p['srp_qty_ng_vdr']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <?php if (!empty($customer_parts)): ?>
        <div class="section">
            <div class="section-title">G. FINISHED GOODS PART - Customer</div>
            <table>
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Qty OK</th>
                        <th>Qty NG</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($customer_parts as $p): ?>
                    <tr>
                        <td><?php echo $p['rc_cust_name']; ?></td>
                        <td><?php echo number_format($p['srp_qty_ok_cust']); ?></td>
                        <td><?php echo number_format($p['srp_qty_ng_cust']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <!-- H. Approval Details -->
        <div class="section">
            <div class="section-title">H. Action Details</div>
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Created By</div>
                    <div class="value"><?php echo $sorting['s_created_by_name']; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Created Date</div>
                    <div class="value"><?php echo date('d-m-Y H:i A', strtotime($sorting['created_date'])); ?></div>
                </div>
                <div class="info-item"></div> <!-- Empty for grid -->
                
                <div class="info-item">
                    <div class="label">Submitted By</div>
                    <div class="value"><?php echo $sorting['s_submitted_by_name'] ?: '-'; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Submitted Date</div>
                    <div class="value"><?php echo ($sorting['submitted_date'] != '0000-00-00 00:00:00') ? date('d-m-Y H:i A', strtotime($sorting['submitted_date'])) : '-'; ?></div>
                </div>
                <div class="info-item"></div>

                <div class="info-item">
                    <div class="label">Approved By</div>
                    <div class="value"><?php echo $sorting['s_approved_by_name'] ?: '-'; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Approved Date</div>
                    <div class="value"><?php echo ($sorting['approved_date'] != '0000-00-00 00:00:00') ? date('d-m-Y H:i A', strtotime($sorting['approved_date'])) : '-'; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Approved Remark</div>
                    <div class="value"><?php echo htmlspecialchars($sorting['approved_remark'] ?? '') ?: '-'; ?></div>
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
