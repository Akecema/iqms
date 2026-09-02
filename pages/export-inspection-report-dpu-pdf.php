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

$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('DPU Report FY ' . $targetFY_desc);

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
</style>

<div class="report-container">
    <div class="title-box">
        <table style="border:none; width:100%; border-collapse: collapse;">
            <tr>
                <td style="border:none; text-align:left; padding:0;">
                    <span class="main-title">DPU REPORT</span><br>
                    <span class="sub-title">Quality Assurance Department</span>
                </td>
                <td style="border:none; text-align:right; color: #666; vertical-align:bottom; padding:0;">
                    <strong>FY ' . $targetFY_desc . '</strong>
                </td>
            </tr>
        </table>
    </div>

    <table cellpadding="6">';

$sql_models = "SELECT b.modid, b.modcode FROM model_details b WHERE b.compcd = '$session_comp' and b.plant = '$session_plant' and b.modstatus = 'Y' ORDER BY b.modid ASC";
$sql_vol = "SELECT * FROM dpu_volume WHERE financial_year = '$fy'";
$res_vol = $db_con->query($sql_vol);
$vols = [];
if ($res_vol) {
    while($v = $res_vol->fetch_assoc()) {
        $vols[$v['model_id']] = $v;
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
    'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
    'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
    'december' => 12, 'jan' => 1
];

$res_models = $db_con->query($sql_models);

$html .= '<thead><tr>';
$html .= '<th width="4%">No</th>';
$html .= '<th width="12%" class="first-col">Model</th>';
$month_width = 84 / 12; // 7% per month
$m_headers = ['Feb', 'Mac', 'April', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec', 'Jan'];
foreach($m_headers as $h) {
    $html .= '<th width="'.$month_width.'%">'.$h.'</th>';
}
$html .= '</tr></thead><tbody>';

$no = 1;
if ($res_models) {
    while ($row = $res_models->fetch_assoc()) {
        $mid = $row['modid'];
        
        $html .= '<tr>';
        $html .= '<td width="4%">'.$no++.'</td>';
        $html .= '<td width="12%" class="first-col">'.$row['modcode'].'</td>';
        
        foreach ($m_map as $col_name => $mth_num) {
            $vol = isset($vols[$mid][$col_name]) ? floatval($vols[$mid][$col_name]) : 0;
            $def = isset($defs[$mid][$mth_num]) ? floatval($defs[$mid][$mth_num]) : 0;

            if ($vol > 0) {
                $dpu = number_format(($def / $vol), 4);
                $html .= '<td width="'.$month_width.'%">'.$dpu.'</td>';
            } else {
                $html .= '<td width="'.$month_width.'%">-</td>';
            }
        }
        $html .= '</tr>';
    }
}

$html .= '</tbody></table></div>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('DPU_Report_FY' . $targetFY_desc . '.pdf', 'I');
exit;
?>
