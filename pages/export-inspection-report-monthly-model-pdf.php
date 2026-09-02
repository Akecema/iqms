<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'get-financial-year.php';
require_once('TCPDF/tcpdf.php');

$targetFY = isset($_GET['fy']) && !empty($_GET['fy']) ? mysqli_real_escape_string($db_con, $_GET['fy']) : $financialyr;
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($db_con, $_GET['search']) : '';

$query_fy_desc = "SELECT financial_desc FROM financial_year WHERE financial_year = '$targetFY'";
$res_fy_desc = mysqli_query($db_con, $query_fy_desc);
if ($row_fy_desc = mysqli_fetch_assoc($res_fy_desc)) {
    $targetFY_desc = $row_fy_desc['financial_desc'];
} else {
    $targetFY_desc = $financialdesc;
}

// Create new PDF document, use Landscape orientation ('L')
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('Monthly Model Analysis Report FY' . $targetFY_desc);

// PDF Setup
$pdf->SetMargins(15, 15, 15);
$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();

$html = '
<style>
    .report-container { font-family: helvetica; color: #333; }
    .title-box { text-align: rig; border-bottom: 2px solid #337A36; padding-bottom: 10px; margin-bottom: 20px;}
    .main-title { font-size: 14pt; font-weight: bold; color: #285A2A; }
    .sub-title { font-size: 10pt; color: #64748B; letter-spacing: 1px; }

    table { border-collapse: collapse; width: 100%; }
    th { 
        background-color: #f1f3f5; 
        color: #337A36; 
        font-weight: bold; 
        text-align: center; 
        padding: 10px 4px; 
        border-bottom: 2px solid #337A36;
        font-size: 8pt;
        text-transform: uppercase;
        border: 1px solid #edf2f7;
    }
    th.first-col { text-align: left; padding-left: 8px; }
    td { 
        padding: 8px 4px; 
        border: 1px solid #edf2f7; 
        font-size: 8pt;
        vertical-align: middle;
        text-align: center;
    }
    td.first-col { text-align: left; padding-left: 8px; font-weight: bold; color: #4a5568; }
    
    .table-total td { 
        background-color: #337A36; 
        color: #ffffff; 
        font-weight: bold; 
        border-top: 2px solid #2D5A27; 
    }
    .table-total td.first-col { color: #ffffff; }
</style>

<div class="report-container">
    <div class="title-box">
        <table style="border:none; width:100%; border-collapse: collapse;">
            <tr>
                <td style="border:none; text-align:left; padding:0;">
                    <span class="main-title">MONTHLY MODEL ANALYSIS REPORT</span><br>
                    <span class="sub-title">Quality Assurance Department</span>
                </td>
                <td style="border:none; text-align:right; color: #666; vertical-align:bottom; padding:0;">
                    <strong>FY ' . $targetFY . '</strong>
                </td>
            </tr>
        </table>
    </div>

    <table cellpadding="6">';

// Data Processing
$months = [
    2 => 'Feb',
    3 => 'Mac',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'Aug',
    9 => 'Sept',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dec',
    1 => 'Jan'
];

$sql_md = "SELECT modid, modcode FROM model_details 
          WHERE modstatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant'";
if (!empty($searchQuery)) {
    $sql_md .= " AND modcode LIKE '%$searchQuery%'";
}
$sql_md .= " ORDER BY modcode ASC";
$res_md = mysqli_query($db_con, $sql_md);
$model_details = [];
while($row = mysqli_fetch_assoc($res_md)) $model_details[] = $row;


$sql_data = "SELECT 
                IR.ir_model as model_id, 
                MONTH(IR.shift_date) as month_num,
                COUNT(ID.defect_id) as qty
             FROM inspection_records IR
             JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
             WHERE IR.financial_yr = '$targetFY' 
               AND IR.ir_result = 'NG' AND IR.ir_status = '5'
             GROUP BY IR.ir_model, MONTH(IR.shift_date)";
$res_data = mysqli_query($db_con, $sql_data);
$matrix = [];
while($row = mysqli_fetch_assoc($res_data)){
    $matrix[$row['model_id']][$row['month_num']] = $row['qty'];
}

$footer_grand_total = 0;

// Table Header construction
$num_cols = count($months);
$width_first = 18; // 18% width for type
$width_last = 10; // 10% for Total
$width_model = ($num_cols > 0) ? (100 - $width_first - $width_last) / $num_cols : 12;
$width_model_rounded = round($width_model, 2);

$html .= '<thead><tr>';
$html .= '<th width="'.$width_first.'%" class="first-col">Type</th>';
foreach($months as $num => $name) {
    $html .= '<th width="'.$width_model_rounded.'%" style="font-size: 7pt;">'.$name.'</th>';
}
$html .= '<th width="'.$width_last.'%">Total</th>';
$html .= '</tr></thead><tbody>';

// Table Body construction
$col_totals = array_fill_keys(array_keys($months), 0);

foreach($model_details as $md) {
    $mod_id = $md['modid'];
    $row_sum = 0;
    
    $html .= '<tr>';
    $html .= '<td width="'.$width_first.'%" class="first-col">'.$md['modcode'].'</td>';
    
    foreach($months as $num => $name) {
        $qty = $matrix[$mod_id][$num] ?? 0;
        $row_sum += $qty;
        $col_totals[$num] += $qty;
        $html .= '<td width="'.$width_model_rounded.'%">'.($qty > 0 ? number_format($qty) : '-').'</td>';
    }
    
    $footer_grand_total += $row_sum;
    $html .= '<td width="'.$width_last.'%"><strong>'.number_format($row_sum).'</strong></td>';
    $html .= '</tr>';
}

// Table Footer construction
$html .= '<tr class="table-total">';
$html .= '<td width="'.$width_first.'%" class="first-col">Total</td>';
foreach($months as $num => $name) {
    $html .= '<td width="'.$width_model_rounded.'%">'.number_format($col_totals[$num]).'</td>';
}
$html .= '<td width="'.$width_last.'%">'.number_format($footer_grand_total).'</td>';
$html .= '</tr>';

$html .= '</tbody></table></div>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Monthly_Model_Analysis_FY' . $targetFY . '.pdf', 'I');
exit;
