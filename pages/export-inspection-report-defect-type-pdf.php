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
$f_daterange= isset($_GET['f_daterange'])&& !empty($_GET['f_daterange'])? mysqli_real_escape_string($db_con, $_GET['f_daterange']): '';
$f_shift    = isset($_GET['f_shift'])    && !empty($_GET['f_shift'])    ? mysqli_real_escape_string($db_con, $_GET['f_shift'])    : '';

$filter_sql = "";
if (!empty($f_month))     $filter_sql .= " AND MONTH(IR.inspect_date) = '$f_month'";
if (!empty($f_shift))     $filter_sql .= " AND IR.ir_shift = '$f_shift'";
if (!empty($f_type))      $filter_sql .= " AND IR.ir_type = '$f_type'";

if (!empty($f_daterange)) {
    $dates = explode(' - ', $f_daterange);
    if (count($dates) == 2) {
        $f_start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
        $f_end_date   = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
        $filter_sql  .= " AND DATE(IR.inspect_date) BETWEEN '$f_start_date' AND '$f_end_date'";
    }
}

if (!empty($f_quarter)) {
    $qtr_row_sql = "SELECT month_start, month_end FROM financial_quarter WHERE quarter_id = '$f_quarter' LIMIT 1";
    $qtr_row_res = mysqli_query($db_con, $qtr_row_sql);
    if ($qtr_row_res && $qtr_row = mysqli_fetch_assoc($qtr_row_res)) {
        $qm_start = (int)$qtr_row['month_start'];
        $qm_end   = (int)$qtr_row['month_end'];
        if ($qm_start && $qm_end) {
            $filter_sql .= " AND MONTH(IR.inspect_date) BETWEEN '$qm_start' AND '$qm_end'";
        }
    }
}

$targetFY = $f_fy;
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($db_con, $_GET['search']) : '';

$query_fy_desc = "SELECT financial_desc FROM financial_year WHERE financial_year = '$targetFY'";
$res_fy_desc = mysqli_query($db_con, $query_fy_desc);
if ($row_fy_desc = mysqli_fetch_assoc($res_fy_desc)) {
    $targetFY_desc = $row_fy_desc['financial_desc'];
} else {
    $targetFY_desc = $financialdesc;
}

// Create new PDF document, use Landscape orientation ('L') for matrix table fit
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('Type Of Defect Analysis Report FY' . $targetFY_desc);

// PDF Setup
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
                    <span class="main-title">TYPE OF DEFECT ANALYSIS REPORT</span><br>
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
$sql_mt = "SELECT typeid, typemodel FROM model_type 
          WHERE typestatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant' 
          ORDER BY typemodel ASC";
$res_mt = mysqli_query($db_con, $sql_mt);
$model_types = [];
while($row = mysqli_fetch_assoc($res_mt)) $model_types[] = $row;

$sql_dt = "SELECT defectid, defectname FROM defect_type WHERE defectstatus = 'Y'";
if (!empty($searchQuery)) {
    $sql_dt .= " AND defectname LIKE '%$searchQuery%'";
}
$sql_dt .= " ORDER BY defectname ASC";
$res_dt = mysqli_query($db_con, $sql_dt);
$defect_categories = [];
while($row = mysqli_fetch_assoc($res_dt)) $defect_categories[] = $row;

$sql_data = "SELECT 
                ID.defect_type, 
                IR.ir_type as model_type_id, 
                COUNT(ID.defect_id) as qty
             FROM inspection_records IR
             JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
             WHERE IR.financial_yr = '$targetFY' 
               AND IR.ir_result = 'NG' AND IR.ir_status = '5' $filter_sql
             GROUP BY ID.defect_type, IR.ir_type";
$res_data = mysqli_query($db_con, $sql_data);
$matrix = [];
while($row = mysqli_fetch_assoc($res_data)){
    $matrix[$row['defect_type']][$row['model_type_id']] = $row['qty'];
}

$unfiltered_grand_total = 0;
foreach($matrix as $def_id => $m_data) {
    foreach($m_data as $qty) $unfiltered_grand_total += $qty;
}

$footer_grand_total = 0;
$footer_percent = 0;

// Table Header construction
$num_cols = count($model_types);
$width_first = 15; // 15% width
$width_last_two = 12; // 6% + 6%
$width_model = ($num_cols > 0) ? (100 - $width_first - $width_last_two) / $num_cols : 20;
$width_model_rounded = round($width_model, 2);

$html .= '<thead><tr>';
$html .= '<th width="'.$width_first.'%" class="first-col">Defect Type</th>';
foreach($model_types as $mt) {
    $html .= '<th width="'.$width_model_rounded.'%" style="font-size: 7pt;">'.$mt['typemodel'].'</th>';
}
$html .= '<th width="6%">Total</th>';
$html .= '<th width="6%">Percent</th>';
$html .= '</tr></thead><tbody>';

// Table Body construction
$col_totals = array_fill_keys(array_column($model_types, 'typeid'), 0);

foreach($defect_categories as $dt) {
    $row_id = $dt['defectid'];
    $row_sum = 0;
    
    $html .= '<tr>';
    $html .= '<td width="'.$width_first.'%" class="first-col">'.$dt['defectname'].'</td>';
    
    foreach($model_types as $mt) {
        $m_id = $mt['typeid'];
        $qty = $matrix[$row_id][$m_id] ?? 0;
        $row_sum += $qty;
        $col_totals[$m_id] += $qty;
        $html .= '<td width="'.$width_model_rounded.'%">'.($qty > 0 ? number_format($qty) : '-').'</td>';
    }
    
    $footer_grand_total += $row_sum;
    $percentage = $unfiltered_grand_total > 0 ? round(($row_sum / $unfiltered_grand_total) * 100) : 0;
    $footer_percent += $percentage;
    $html .= '<td width="6%"><strong>'.number_format($row_sum).'</strong></td>';
    $html .= '<td width="6%">'.$percentage.'%</td>';
    $html .= '</tr>';
}

// Table Footer construction
$html .= '<tr class="table-total">';
$html .= '<td width="'.$width_first.'%" class="first-col">Total</td>';
foreach($model_types as $mt) {
    $html .= '<td width="'.$width_model_rounded.'%">'.number_format($col_totals[$mt['typeid']]).'</td>';
}
$html .= '<td width="6%">'.number_format($footer_grand_total).'</td>';
$html .= '<td width="6%">'.$footer_percent.'%</td>';
$html .= '</tr>';

$html .= '</tbody></table></div>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Type_Of_Defect_Analysis_FY' . $targetFY . '.pdf', 'I');
exit;
