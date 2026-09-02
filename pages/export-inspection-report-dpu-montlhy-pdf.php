<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'get-financial-year.php';
require_once('TCPDF/tcpdf.php');

$fy = isset($_GET['fy']) && !empty($_GET['fy']) ? mysqli_real_escape_string($db_con, $_GET['fy']) : date('Y');

$fy_desc_query = mysqli_query($db_con, "SELECT financial_desc FROM financial_year WHERE financial_year = '$fy'");
$targetFY_desc = $fy;
if ($fy_desc_query && mysqli_num_rows($fy_desc_query) > 0) {
    $row_fy = mysqli_fetch_assoc($fy_desc_query);
    $targetFY_desc = $row_fy['financial_desc'];
}

$pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false); // Portrait is fine for 6 cols
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('Monthly DPU Report FY ' . $targetFY_desc);

$pdf->SetMargins(15, 15, 15);
$pdf->SetFont('helvetica', '', 9);
$pdf->AddPage();

$html = '
<style>
    .report-container { font-family: helvetica; color: #333; }
    .title-box { text-align: left; border-bottom: 2px solid #337A36; padding-bottom: 10px; margin-bottom: 20px; }
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
        font-size: 9pt;
        text-transform: uppercase;
        border: 1px solid #edf2f7;
    }
    th.first-col { text-align: left; padding-left: 8px; }
    td { 
        padding: 8px 4px; 
        border: 1px solid #edf2f7; 
        font-size: 9pt;
        vertical-align: middle;
        text-align: center;
    }
    td.first-col { text-align: left; padding-left: 8px; font-weight: bold; color: #4a5568; }
    .text-red { color: #C8361C; font-weight: bold; }
    .text-green { color: #199E2D; font-weight: bold; }
</style>

<div class="report-container">
    <div class="title-box">
        <table style="border:none; width:100%; border-collapse: collapse;">
            <tr>
                <td style="border:none; text-align:left; padding:0;">
                    <span class="main-title">MONTHLY DPU REPORT</span><br>
                    <span class="sub-title">Quality Assurance Department</span>
                </td>
                <td style="border:none; text-align:right; color: #666; vertical-align:bottom; padding:0;">
                    <strong>FY ' . $targetFY_desc . '</strong>
                </td>
            </tr>
        </table>
    </div>

    <table cellpadding="6">';

$sql_models = "SELECT b.modid, b.modcode FROM model_details b WHERE b.compcd = '$session_comp' and b.plant = '$session_plant' and b.modstatus = 'Y' ORDER BY b.modcode ASC";
$sql_vol = "SELECT * FROM dpu_volume WHERE financial_year = '$fy'";
$res_vol = $db_con->query($sql_vol);
$vols = [];
if ($res_vol) {
    while($v = $res_vol->fetch_assoc()) {
        $vols[$v['model_id']] = $v;
    }
}

$sql_target = "SELECT * FROM dpu_target WHERE financial_year = '$fy'";
$res_target = $db_con->query($sql_target);
$targets = [];
if ($res_target) {
    while($t = $res_target->fetch_assoc()) {
        $targets[$t['model_id']] = $t;
    }
}

$sql_def = "SELECT inspection_records.ir_model, MONTH(inspection_records.shift_date) as mth, SUM(inspection_sorting.sr_qty_ng) as tot
            FROM inspection_sorting 
            JOIN inspection_records ON inspection_records.ir_id = inspection_sorting.sr_ir_id 
            WHERE inspection_records.financial_yr = '$fy'
            GROUP BY inspection_records.ir_model, MONTH(inspection_records.shift_date)";
$res_def = $db_con->query($sql_def);
$defs = [];
if ($res_def) {
    while($d = $res_def->fetch_assoc()) {
        $defs[$d['ir_model']][$d['mth']] = floatval($d['tot']);
    }
}

$m_map = [
    'jan' => 1, 'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
    'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
    'december' => 12
];

$res_models = $db_con->query($sql_models);
$models = [];
if ($res_models) {
    while($m = $res_models->fetch_assoc()){
        $models[] = $m;
    }
}

$html .= '<thead><tr>';
$html .= '<th width="15%" class="first-col">Month</th>';
$html .= '<th width="25%">Model</th>';
$html .= '<th width="15%">Total Defects</th>';
$html .= '<th width="15%">Volume</th>';
$html .= '<th width="15%">DPU</th>';
$html .= '<th width="15%">Target</th>';
$html .= '</tr></thead><tbody>';

foreach ($m_map as $col_name => $mth_num) {
    $first_in_month = true;
    $m_lbl = ucfirst($col_name == 'mac' ? 'Mar' : ($col_name == 'december' ? 'Dec' : substr($col_name, 0, 3)));
    
    foreach ($models as $row) {
        $mid = $row['modid'];
        $vol = isset($vols[$mid][$col_name]) ? floatval($vols[$mid][$col_name]) : 0;
        $def = isset($defs[$mid][$mth_num]) ? floatval($defs[$mid][$mth_num]) : 0;
        $target = isset($targets[$mid][$col_name]) ? floatval($targets[$mid][$col_name]) : 0;

        if ($vol > 0 || $def > 0) {
            $dpu_val = ($vol > 0) ? ($def / $vol) : 0;
            $dpu = number_format($dpu_val, 4);
            
            $def_str = ($def != 0) ? '<span class="text-red">'.$def.'</span>' : $def;
            $dpu_str = ($dpu_val > $target) ? '<span class="text-red">'.$dpu.'</span>' : '<span class="text-green">'.$dpu.'</span>';
            
            $html .= '<tr>';
            $html .= '<td width="15%" class="first-col">'.($first_in_month ? '<strong>'.$m_lbl.'</strong>' : '').'</td>';
            $html .= '<td width="25%">'.$row['modcode'].'</td>';
            $html .= '<td width="15%">'.$def_str.'</td>';
            $html .= '<td width="15%">'.$vol.'</td>';
            $html .= '<td width="15%">'.$dpu_str.'</td>';
            $html .= '<td width="15%">'.$target.'</td>';
            $html .= '</tr>';
            
            $first_in_month = false;
        }
    }
}

$html .= '</tbody></table></div>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Monthly_DPU_Report_FY' . $targetFY_desc . '.pdf', 'I');
exit;
?>
