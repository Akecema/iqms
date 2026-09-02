<!-- FAVICONS ICON -->
<link rel="shortcut icon" type="image/png" href="../icon/favicon.ico">
    
<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';

$ir_id = isset($_GET['ir_id']) ? mysqli_real_escape_string($db_con, $_GET['ir_id']) : '';
if (empty($ir_id)) die("Missing Record ID");

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

$resultColor = ($data['ir_result'] == 'OK') ? '#085209' : '#FF0000';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Inspection Report - <?php echo $data['ir_docno']; ?></title>
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

        /* 3-column default */
        .info-grid .info-item:nth-child(3n) { border-right: none; }
        
        /* 2-column override */
        .info-grid.grid-2 .info-item:nth-child(2n) { border-right: none; }
        .info-grid.grid-2 .info-item:nth-child(even) { border-right: none; }
        .info-grid.grid-2 .info-item:nth-child(odd) { border-right: 1px solid var(--border-color); }

        .label {
            font-size: 11px;
            color: #64748B;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
        }

        .value {
            font-size: 14px;
            font-weight: 500;
        }

        .result-badge {
            color: <?php echo $resultColor; ?>;
            font-weight: 700;
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
            padding: 15px;
            border-bottom: 1px solid var(--border-color);
            font-size: 13px;
            vertical-align: middle;
        }

        .photo-container {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .photo-box {
            width: 100px;
            height: 100px;
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

        @page {
            margin: 0; /* Margin 0 hides browser-generated headers/footers */
        }

        @media print {
            body { 
                padding: 0; 
                margin: 0;
            }
            .no-print { display: none; }
            .section { 
                page-break-inside: avoid; 
                margin-bottom: 20px;
            }
            .report-content { 
                padding: 0 40px; 
                box-shadow: none; 
                border-radius: 0; 
            }
        }

        .report-content {
            background-color: white;
            padding: 40px;
            max-width: 900px;
            margin: 0 auto;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
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

        .btn-print:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
    <button class="btn-print no-print" onclick="window.print()">Print</button>

    <div class="report-content">
        <div class="report-header">
            <h1>Inspection Report : <?php echo $data['ir_docno']; ?></h1>
        </div>

                    <div class="section">
                        <div class="section-title">A. General Information</div>
                        <div class="info-grid">
                            <div class="info-item">
                                <div class="label">Document No</div>
                                <div class="value"><?php echo $data['ir_docno']; ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Result</div>
                                <div class="value result-badge"><?php echo $data['ir_result']; ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Pallet Sequence</div>
                                <div class="value"><?php echo $data['ir_pallet_no']; ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Inspection Date</div>
                                <div class="value"><?php echo date('d-m-Y', strtotime($data['inspect_date'])); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Production Date</div>
                                <div class="value"><?php echo date('d-m-Y', strtotime($data['prod_date'])); ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Shift</div>
                                <div class="value"><?php echo $data['shiftdesc']; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="section">
                        <div class="section-title">B. Finished Goods Details</div>
                        <div class="info-grid">
                            <div class="info-item" style="grid-column: span 1;">
                                <div class="label">Part No</div>
                                <div class="value"><?php echo $data['matno']; ?></div>
                            </div>
                            <div class="info-item" style="grid-column: span 2; border-right: none;">
                                <div class="label">Model</div>
                                <div class="value"><?php echo $data['modcode'] . " (" . $data['partside'] . ")"; ?></div>
                            </div>
                            <div class="info-item" style="grid-column: span 1; border-right: 1px solid var(--border-color);">
                                <div class="label">Part Name</div>
                                <div class="value"><?php echo $data['matdesc']; ?></div>
                            </div>
                            <div class="info-item" style="grid-column: span 2; border-right: none;">
                                <div class="label">Type</div>
                                <div class="value"><?php echo $data['typemodel']; ?></div>
                            </div>
                        </div>
                    </div>

                    <?php if ($data['ir_result'] != 'OK') { ?>
                    <div class="section">
                        <div class="section-title">C. Defect Details</div>
                        <table>
                            <thead>
                                <tr>
                                    <th width="50">No</th>
                                    <th>Type</th>
                                    <th>Area</th>
                                    <th>Defect Photo</th>
                                    <th>Comparison Photo</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $def_sql = "SELECT d.defect_id, t.defectname, d.defect_area FROM inspection_defect d 
                                            LEFT JOIN defect_type t ON d.defect_type = t.defectid WHERE d.rcd_ir_id = '$ir_id'";
                                $def_res = mysqli_query($db_con, $def_sql);
                                $index = 1;
                                while ($def_row = mysqli_fetch_assoc($def_res)) {
                                    ?>
                                    <tr>
                                        <td align="center"><?php echo $index++; ?></td>
                                        <td><?php echo $def_row['defectname']; ?></td>
                                        <td><?php echo $def_row['defect_area']; ?></td>
                                        <td>
                                            <div class="photo-container lightgallery">
                                                <?php
                                                $p_sql = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = '{$def_row['defect_id']}'";
                                                $p_res = mysqli_query($db_con, $p_sql);
                                                while ($p_row = mysqli_fetch_assoc($p_res)) {
                                                    $imgPath = 'gallery/inspection/defect/' . $ir_id . '/' . $p_row['defect_photo'];
                                                    if (file_exists($imgPath)) {
                                                        echo '<a href="'.$imgPath.'" class="lg-item"><img src="'.$imgPath.'" class="photo-box"></a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="photo-container lightgallery">
                                                <?php
                                                $c_sql = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = '{$def_row['defect_id']}'";
                                                $c_res = mysqli_query($db_con, $c_sql);
                                                while ($c_row = mysqli_fetch_assoc($c_res)) {
                                                    $imgPath = 'gallery/inspection/defect_compare/' . $ir_id . '/' . $c_row['compare_photo'];
                                                    if (file_exists($imgPath)) {
                                                        echo '<a href="'.$imgPath.'" class="lg-item"><img src="'.$imgPath.'" class="photo-box"></a>';
                                                    }
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>

                    <div class="section">
                        <div class="section-title">D. Action Details</div>
                        <div class="info-grid grid-2" style="grid-template-columns: repeat(2, 1fr);">
                            <div class="info-item">
                                <div class="label">Created By</div>
                                <div class="value"><?php echo !empty($data['created_by_name']) ? $data['created_by_name'] : '-'; ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Created Date</div>
                                <div class="value"><?php echo ($data['created_date'] != '0000-00-00 00:00:00') ? date('d-m-Y H:i A', strtotime($data['created_date'])) : '-'; ?></div>
                            </div>
                            
                            <div class="info-item">
                                <div class="label">Submitted By</div>
                                <div class="value"><?php echo !empty($data['submitted_by_name']) ? $data['submitted_by_name'] : '-'; ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Submitted Date</div>
                                <div class="value"><?php echo ($data['submitted_date'] != '0000-00-00 00:00:00') ? date('d-m-Y H:i A', strtotime($data['submitted_date'])) : '-'; ?></div>
                            </div>

                            <div class="info-item">
                                <div class="label">Reviewed By</div>
                                <div class="value"><?php echo !empty($data['reviewed_by_name']) ? $data['reviewed_by_name'] : '-'; ?></div>
                            </div>
                            <div class="info-item">
                                <div class="label">Reviewed Date</div>
                                <div class="value"><?php echo ($data['reviewed_date'] != '0000-00-00 00:00:00') ? date('d-m-Y H:i A', strtotime($data['reviewed_date'])) : '-'; ?></div>
                            </div>

                            <?php if (!empty($data['reviewed_remark'])) { ?>
                            <div class="info-item" style="grid-column: span 2;">
                                <div class="label">Remarks</div>
                                <div class="value"><?php echo $data['reviewed_remark']; ?></div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
    </div>

    <script>
        // Auto trigger print after a small delay
        window.onload = function() {
            setTimeout(function() {
                // window.print();
            }, 1000);
        }
    </script>
    

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
