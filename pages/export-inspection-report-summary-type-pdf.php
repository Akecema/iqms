<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'get-financial-year.php';
require_once('TCPDF/tcpdf.php');

$targetFY = isset($_GET['fy']) && !empty($_GET['fy']) ? mysqli_real_escape_string($db_con, $_GET['fy']) : $financialyr;
$targetFY_desc = $financialdesc;

if (isset($_GET['fy']) && !empty($_GET['fy'])) {
    $fy_desc_query = mysqli_query($db_con, "SELECT financial_desc FROM financial_year WHERE financial_year = '$targetFY'");
    if ($fy_desc_query && mysqli_num_rows($fy_desc_query) > 0) {
        $row_fy = mysqli_fetch_assoc($fy_desc_query);
        $targetFY_desc = $row_fy['financial_desc'];
    }
}

// Create new PDF document
$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('Defect Summary Report FY' . $targetFY_desc);
// --- PDF Setup Enhancements ---
$pdf->SetMargins(20, 20, 20); // Wider margins for more whitespace
$pdf->SetAutoPageBreak(TRUE, 25);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();

$html = '
<style>
    .report-container { font-family: helvetica; color: #444; }
    .title-box { text-align: left; border-bottom: 2px solid #337A36; padding-bottom: 10px; margin-bottom: 20px; }
    .main-title { font-size: 16pt; font-weight: bold; color: #285A2A; }
    .sub-title { font-size: 10pt; color: #64748B; letter-spacing: 1px; }
    
    .section-header { font-size: 11pt; font-weight: bold; color: #585958ff; margin-top: 30px; margin-bottom: 15px; }
    
    table { border-collapse: collapse; width: 100%; border: none; }
    th { 
        background-color: #f8f9fa; 
        color: #337A36; 
        font-weight: bold; 
        text-align: left; 
        padding: 12px 8px; 
        border-bottom: 1px solid #337A36; 
    }
    td { 
        padding: 10px 8px; 
        border-bottom: 1px solid #eeeeee; 
        color: #444;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    
    .table-total { background-color: #ffffff; }
    .total-label { font-weight: bold; color: #1a1a1a; border-top: 2px solid #337A36; }
    .total-val { font-weight: bold; color: #337A36; border-top: 2px solid #337A36; font-size: 11pt; }
</style>

<div class="report-container">
    <div class="title-box">
        <span class="main-title">DEFECT SUMMARY REPORT</span><br>
        <span class="sub-title">Quality Assurance Department</span>
        <div style="text-align: right; color: #666;">FY ' . $targetFY_desc . '</div>
    </div>

    <!--<div class="section-header">Total Defects by Model Type</div>-->
    <table cellpadding="6">
        <thead>
            <tr>
                <th width="50%">Model Type</th>
                <th width="25%" class="text-center">Total Defects</th>
                <th width="25%" class="text-center">Percentage</th>
            </tr>
        </thead>
        <tbody>';

// Summary by Type
$sql_summary = "SELECT 
                    MT.typemodel, 
                    COUNT(D.defect_id) as type_total
                FROM model_type MT
                LEFT JOIN inspection_records S ON S.ir_type = MT.typeid AND S.financial_yr = '$targetFY' AND S.ir_status = '5' 
                LEFT JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id
                WHERE MT.typestatus = 'Y' AND MT.compcd = '$session_comp' AND MT.plant = '$session_plant'
                GROUP BY MT.typeid, MT.typemodel
                ORDER BY type_total DESC";
$res_summary = mysqli_query($db_con, $sql_summary);

$summary_data = [];
$grandTotal = 0;
if (mysqli_num_rows($res_summary) > 0) {
    while ($row = mysqli_fetch_assoc($res_summary)) {
        $summary_data[] = $row;
        $grandTotal += (int)$row['type_total'];
    }
}

if (!empty($summary_data)) {
    $chartData = [];
    foreach ($summary_data as $row) {
        $count = (int)$row['type_total'];
        $percentage = ($grandTotal > 0) ? round(($count / $grandTotal) * 100) : 0;
        
        $chartData[] = [
            'label' => $row['typemodel'],
            'value' => $count,
            'percent' => $percentage
        ];

        $html .= '
        <tr>
            <td width="50%" style="font-weight:bold;">' . $row['typemodel'] . '</td>
            <td width="25%" class="text-center">' . number_format($count) . '</td>
            <td width="25%" class="text-center">' . $percentage . '%</td>
        </tr>';
    }
    
    $html .= '
    <tr class="table-total">
        <td class="total-label">Grand Total</td>
        <td class="total-val text-center">' . number_format($grandTotal) . '</td>
        <td class="total-val text-center">100%</td>
    </tr>';
}

$html .= '</tbody></table></div>';

$pdf->writeHTML($html, true, false, true, false, '');

// --- Add Donut Chart ---
if (!empty($chartData) && $grandTotal > 0) {
    $pdf->Ln(10);
    $pdf->SetXY(15, $pdf->GetY());
    $pdf->SetFont('helvetica', 'B', 12);
    $pdf->Cell(0, 10, 'Defect Distribution : Type Breakdown', 0, 1, 'L');
    
    $xc = 60; 
    $yc = $pdf->GetY() + 40;
    $r = 30;
    
    // Custom palette
    $colors = ['11470F', '739C38', 'D4F357', 'EAF739', 'FFFDD0', '858796', '5a5c69'];
    
    $start_angle = 0;
    foreach ($chartData as $index => $data) {
        if ($data['value'] <= 0) continue;
        
        $angle = ($data['value'] / $grandTotal) * 360;
        $hex = $colors[$index % count($colors)];
        
        // Convert hex to RGB
        $r_val = hexdec(substr($hex, 0, 2));
        $g_val = hexdec(substr($hex, 2, 2));
        $b_val = hexdec(substr($hex, 4, 2));
        
        $pdf->SetFillColor($r_val, $g_val, $b_val);
        $pdf->PieSector($xc, $yc, $r, $start_angle, $start_angle + $angle, 'FD');
        
        $start_angle += $angle;
    }
    
    // Draw white circle in middle to make it a donut
    $pdf->SetFillColor(255, 255, 255);
    $pdf->Circle($xc, $yc, $r * 0.5, 0, 360, 'F', array(), array(255, 255, 255));
    
    // Draw Legend
    $ly = $yc - 30;
    $lx = $xc + 50;
    $pdf->SetFont('helvetica', '', 9);
    foreach ($chartData as $index => $data) {
        $hex = $colors[$index % count($colors)];
        $r_val = hexdec(substr($hex, 0, 2));
        $g_val = hexdec(substr($hex, 2, 2));
        $b_val = hexdec(substr($hex, 4, 2));
        
        $pdf->SetFillColor($r_val, $g_val, $b_val);
        $pdf->Rect($lx, $ly + 2, 4, 4, 'F');
        $pdf->SetXY($lx + 6, $ly);
        $pdf->Cell(0, 8, $data['label'] . ' (' . $data['percent'] . '%)', 0, 1, 'L');
        $ly += 8;
    }
}

// Output PDF
$pdf->Output('Defect_Summary_Report_FY' . $targetFY . '.pdf', 'I');
exit;
