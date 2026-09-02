<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'get-financial-year.php';
require_once('TCPDF/tcpdf.php');

// Centralized Filter Logic for Exports
$f_fy       = isset($_GET['f_fy'])       && !empty($_GET['f_fy'])       ? mysqli_real_escape_string($db_con, $_GET['f_fy'])       : $financialyr;
$f_month    = isset($_GET['f_month'])    && !empty($_GET['f_month'])    ? intval($_GET['f_month'])    : '';
$f_quarter  = isset($_GET['f_quarter'])  && !empty($_GET['f_quarter'])  ? intval($_GET['f_quarter'])  : '';
$f_type     = isset($_GET['f_type'])     && !empty($_GET['f_type'])     ? intval($_GET['f_type'])     : '';
$f_model    = isset($_GET['f_model'])    && !empty($_GET['f_model'])    ? intval($_GET['f_model'])    : '';
$f_daterange= isset($_GET['f_daterange'])&& !empty($_GET['f_daterange'])? mysqli_real_escape_string($db_con, $_GET['f_daterange']): '';
$f_shift    = isset($_GET['f_shift'])    && !empty($_GET['f_shift'])    ? mysqli_real_escape_string($db_con, $_GET['f_shift'])    : '';

$filter_sql = "";
if (!empty($f_month))     $filter_sql .= " AND MONTH(S.inspect_date) = '$f_month'";
if (!empty($f_shift))     $filter_sql .= " AND S.ir_shift = '$f_shift'";
if (!empty($f_type))      $filter_sql .= " AND S.ir_type = '$f_type'";
if (!empty($f_model))     $filter_sql .= " AND S.ir_model = '$f_model'";

if (!empty($f_daterange)) {
    $dates = explode(' - ', $f_daterange);
    if (count($dates) == 2) {
        $f_start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
        $f_end_date   = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
        $filter_sql  .= " AND DATE(S.inspect_date) BETWEEN '$f_start_date' AND '$f_end_date'";
    }
}

if (!empty($f_quarter)) {
    $qtr_row_sql = "SELECT month_start, month_end FROM financial_quarter WHERE quarter_id = '$f_quarter' LIMIT 1";
    $qtr_row_res = mysqli_query($db_con, $qtr_row_sql);
    if ($qtr_row_res && $qtr_row = mysqli_fetch_assoc($qtr_row_res)) {
        $qm_start = (int)$qtr_row['month_start'];
        $qm_end   = (int)$qtr_row['month_end'];
        if ($qm_start && $qm_end) {
            $filter_sql .= " AND MONTH(S.inspect_date) BETWEEN '$qm_start' AND '$qm_end'";
        }
    }
}

$targetFY = $f_fy;
$targetFY_desc = $financialdesc;
$fy_desc_query = mysqli_query($db_con, "SELECT financial_desc FROM financial_year WHERE financial_year = '$targetFY'");
if ($fy_desc_query && mysqli_num_rows($fy_desc_query) > 0) {
    $row_fy = mysqli_fetch_assoc($fy_desc_query);
    $targetFY_desc = $row_fy['financial_desc'];
}

// Create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('Defect Summary Model Report FY' . $targetFY_desc);
// PDF Setup
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();

$html = '
<style>
    .report-container { font-family: helvetica; color: #333; }
    .header-table { margin-bottom: 25px; border-bottom: 2px solid #337A36; }
    .title-box { text-align: left; border-bottom: 2px solid #337A36; padding-bottom: 10px; margin-bottom: 20px; }
    .main-title { font-size: 16pt; font-weight: bold; color: #285A2A; }
    .sub-title { font-size: 10pt; color: #64748B; letter-spacing: 1px; }

    table { border-collapse: collapse; width: 100%; }
    th { 
        background-color: #f1f3f5; 
        color: #337A36; 
        font-weight: bold; 
        text-align: left; 
        padding: 12px 8px; 
        border-bottom: 2px solid #337A36;
        font-size: 9pt;
        text-transform: uppercase;
    }
    td { 
        padding: 10px 8px; 
        border-bottom: 1px solid #edf2f7; 
        font-size: 10pt;
        vertical-align: middle;
    }
    
    /* Grouped Sidebar Style */
    .type-cell { 
        background-color: #fcfdfc; 
        color: #2D5A27; 
        font-weight: bold; 
        border-right: 1px solid #edf2f7;
    }
    
    .model-cell { color: #4a5568; }
    .qty-cell { text-align: center; font-weight: bold; color: #1a1a1a; }
    
    .table-total { background-color: #ffffff; }
    .total-label { font-weight: bold; color: #1a1a1a; border-top: 2px solid #337A36; padding: 12px; font-size: 11pt; }
    .total-val { font-weight: bold; color: #337A36; border-top: 2px solid #337A36; padding: 12px; font-size: 11pt;text-align: center; }
</style>

<div class="report-container">

    <div class="title-box">
        <span class="main-title">DEFECTS BY MODEL</span><br>
        <span class="sub-title">Quality Assurance Department</span>
        <div style="text-align: right; color: #666;">FY ' . $targetFY . '</div>
    </div>

    <table cellpadding="8">
        <thead>
            <tr>
                <th width="25%">Type</th>
                <th width="35%">Model</th>
                <th width="20%" style="text-align:center;">Total Inspection</th>
                <th width="20%" style="text-align:center;">Defects Qty</th>
            </tr>
        </thead>
        <tbody>';

// Query: Breakdown by Type & Model
$sql_defect_model = "SELECT 
                        MT.typemodel AS type_name,
                        MD.modcode AS model_name,
                        COUNT(D.defect_id) AS total_qty,
                        (SELECT COUNT(ir_id) FROM inspection_records S WHERE ir_type = MT.typeid AND ir_model = MD.modid AND financial_yr = '$targetFY' AND ir_status = '5' $filter_sql) AS total_inspection
                     FROM model_type MT
                     JOIN model_details MD ON 1=1
                     LEFT JOIN inspection_records S ON S.ir_type = MT.typeid 
                                        AND S.ir_model = MD.modid 
                                        AND S.financial_yr = '$targetFY' 
                                        AND S.ir_status = '5' $filter_sql
                     LEFT JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id AND S.ir_result = 'NG'
                     WHERE MT.typestatus = 'Y' AND MT.compcd = '$session_comp' AND MT.plant = '$session_plant'
                       AND MD.modstatus = 'Y' AND MD.compcd = '$session_comp' AND MD.plant = '$session_plant'
                     GROUP BY MT.typeid, MD.modid
                     HAVING total_inspection > 0
                     ORDER BY MT.typemodel ASC, total_qty DESC";
$res_defect_model = mysqli_query($db_con, $sql_defect_model);

$data_rows = [];
$group_counts = [];
$grand_total_qty = 0;
$grand_total_inspection = 0;
while ($row = mysqli_fetch_assoc($res_defect_model)) {
    $data_rows[] = $row;
    $group_counts[$row['type_name']] = ($group_counts[$row['type_name']] ?? 0) + 1;
    $grand_total_qty += (int)$row['total_qty'];
    $grand_total_inspection += (int)$row['total_inspection'];
}

if (!empty($data_rows)) {
    $current_type = '';
    foreach ($data_rows as $row) {
        $html .= '<tr>';
        if ($current_type !== $row['type_name']) {
            $rowspan = $group_counts[$row['type_name']];
            $html .= '<td width="25%" rowspan="' . $rowspan . '" class="type-cell">' . $row['type_name'] . '</td>';
            $current_type = $row['type_name'];
        }
        $html .= '
            <td width="35%" class="model-cell">' . $row['model_name'] . '</td>
            <td width="20%" class="qty-cell">' . number_format($row['total_inspection']) . '</td>
            <td width="20%" class="qty-cell">' . number_format($row['total_qty']) . '</td>
        </tr>';
    }
    $html .= '
    <tr class="table-total">
        <td colspan="2" class="total-label" style="text-align:right;">GRAND TOTAL</td>
        <td class="total-val text-center">' . number_format($grand_total_inspection) . '</td>
        <td class="total-val text-center">' . number_format($grand_total_qty) . '</td>
    </tr>';
} else {
    $html .= '<tr><td colspan="4" style="text-align:center; padding:20px; color:#999;">No inspections recorded for this period.</td></tr>';
}

$html .= '</tbody></table></div>';

$pdf->writeHTML($html, true, false, true, false, '');

// --- Add Stacked Bar Chart ---
if (!empty($data_rows)) {
    // Check if we need a new page for the chart
    if ($pdf->GetY() > 180) {
        $pdf->AddPage();
    } else {
        $pdf->Ln(15);
    }

    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Defect Distribution: Model Breakdown', 0, 1, 'L');
    $pdf->Ln(5);

    // Prepare data for chart
    $chart_data = [];
    $all_models = [];
    $max_total = 0;
    
    foreach ($data_rows as $row) {
        $t = $row['type_name'];
        $m = $row['model_name'];
        $q = (int)$row['total_qty'];
        
        if (!isset($chart_data[$t])) {
            $chart_data[$t] = ['total' => 0, 'models' => []];
        }
        $chart_data[$t]['models'][$m] = $q;
        $chart_data[$t]['total'] += $q;
        
        if ($chart_data[$t]['total'] > $max_total) {
            $max_total = $chart_data[$t]['total'];
        }
        
        if (!in_array($m, $all_models)) {
            $all_models[] = $m;
        }
    }

    // Chart Configuration
    $startX = 50; 
    $startY = $pdf->GetY();
    $chartWidth = 130;
    $barHeight = 10;
    $barSpacing = 5;
    
    // Scale factor
    $scale = ($max_total > 0) ? ($chartWidth / $max_total) : 0;
    
    // Standardized Color Palette
    $flat_colors = ['11470F', '739C38', 'D4F357', 'EAF739', 'FFFDD0'];
    
    // Map models to colors
    $model_colors = [];
    foreach ($all_models as $index => $m) {
        $model_colors[$m] = $flat_colors[$index % count($flat_colors)];
    }

    // Draw Bars
    $currentY = $startY;
    foreach ($chart_data as $type => $data) {
        // Label
        $pdf->SetXY(15, $currentY);
        $pdf->SetFont('helvetica', '', 9);
        $pdf->Cell($startX - 18, $barHeight, $type, 0, 0, 'R', false, '', 1);
        
        $currentX = $startX;
        foreach ($data['models'] as $model => $qty) {
            if ($qty <= 0) continue;
            
            $w = $qty * $scale;
            $hex = $model_colors[$model];
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
            
            $pdf->SetFillColor($r, $g, $b);
            $pdf->Rect($currentX, $currentY, $w, $barHeight, 'F');
            
            // Value inside bar if it fits
            if ($w > 10) {
                $pdf->SetTextColor(0, 0, 0);
                if ($r + $g + $b < 380) $pdf->SetTextColor(255, 255, 255); // Dark background -> white text
                $pdf->SetXY($currentX, $currentY);
                $pdf->Cell($w, $barHeight, $qty, 0, 0, 'C');
            }
            
            $currentX += $w;
        }
        
        // Total label at the end
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetXY($currentX + 2, $currentY);
        $pdf->Cell(20, $barHeight, number_format($data['total']), 0, 0, 'L');
        
        $currentY += ($barHeight + $barSpacing);
    }
    
    // Draw Axis
    $pdf->Line($startX, $startY, $startX, $currentY - $barSpacing);
    
    // Draw Legend
    $pdf->SetY($currentY + 10);
    if ($pdf->GetY() > 250) $pdf->AddPage();
    
    $pdf->SetFont('helvetica', 'B', 10);
    $pdf->Cell(0, 10, 'Legend (Models)', 0, 1, 'L');
    
    $pdf->SetFont('helvetica', '', 9);
    $lx = 15;
    $ly = $pdf->GetY();
    $itemsPerRow = 4;
    $colWidth = 45;
    
    foreach ($all_models as $index => $m) {
        if ($index > 0 && $index % $itemsPerRow == 0) {
            $ly += 7;
            $lx = 15;
        }
        
        $hex = $model_colors[$m];
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
        
        $pdf->SetFillColor($r, $g, $b);
        $pdf->Rect($lx, $ly + 1, 4, 4, 'F');
        $pdf->SetXY($lx + 5, $ly);
        $pdf->Cell($colWidth - 5, 6, $m, 0, 0, 'L', false, '', 1);
        
        $lx += $colWidth;
    }
}

// Output PDF
$pdf->Output('Defect_Summary_Model_FY' . $targetFY . '.pdf', 'I');
exit;
