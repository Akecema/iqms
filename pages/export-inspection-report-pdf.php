<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
require_once('TCPDF/tcpdf.php');

// Custom PDF class to handle Header and Footer
class MYPDF extends TCPDF {
    public $doc_no;
    public $report_date;
    
    // Page header
    public function Header() {
        $this->SetY(10);
        // Set font
        $this->SetFont('dejavusans', 'I', 8);
        // Set color #7E827E
        $this->SetTextColor(126, 130, 126);
        // Doc No - Right aligned
        $this->Cell(0, 5, 'Doc No: ' .$this->doc_no, 0, 1, 'R');
        // Date - below doc no
        $this->Cell(0, 5, 'Date: ' . $this->report_date, 0, 1, 'R');
    }

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('dejavusans', 'I', 8);
        // Page number (Page X/Y)
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


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

$resultColor = ($data['ir_result'] == 'OK') ? '#D4B12A' : '#E74C3C'; // Use theme green or industrial red

// Initialize TCPDF with custom class
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->doc_no = $data['ir_docno']; // Pass Doc No to header
$pdf->report_date = date('d F Y');
$pdf->SetCreator('iQims');
$pdf->SetTitle('Inspection Report - ' . $data['ir_docno']);
$pdf->setPrintHeader(true); // Enabled for Doc No
$pdf->setPrintFooter(true); // Enabled for page numbers
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 20);
$pdf->SetFont('dejavusans', '', 10); 
$pdf->AddPage();

$html = '
<style>
    .title { font-size: 18pt; font-weight: bold; color: #555755; }
    .doc-info { text-align: right; color: #555755; font-size: 8pt; }
    .status-badge { 
        text-align: center; 
        font-size: 12pt; 
        font-weight: bold; 
        color: white;
    }
    .section-header { 
        background-color: #2B522B; 
        color: #FFFFFF; 
        text-transform: uppercase; 
        letter-spacing: 1px;
        font-size: 9pt;
        font-weight: bold;
        padding: 6px;
        line-height : 25px;
    }
    .info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
    .label { font-weight: bold; color: #64748B; font-size: 8pt; text-transform: uppercase; }
    .value { color: #2C3E50; font-size: 9pt; border-bottom: 1px solid #F1F5F9; padding-bottom: 5px; }
    .value-signature { color: #2C3E50; font-size: 8pt; }
    .defect-table { width: 100%; border-collapse: collapse; }
    .defect-table th { 
        background-color: #F8FAFC; 
        color: #2B522B; 
        font-weight: bold; 
        border-bottom: 2px solid #2B522B;
        padding: 8px;
        font-size: 9pt;
    }
    .defect-table td { border-bottom: 1px solid #EDF2F7; padding: 8px; vertical-align: top; font-size: 9pt; }
    .photo-container { border: 1px solid #F1FAF0; border-radius: 4px; padding: 2px; }
    .approval-table { width: 100%; border-collapse: collapse; }
    .approval-table th { background-color: #F8FAFC; color: #2B522B; font-weight: bold; border-bottom: 2px solid #2B522B; padding: 8px; text-align: center; }
    .approval-table td { border-bottom: 1px solid #EDF2F7; padding: 8px; font-size: 9pt; text-align: center; }
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="60%"><span class="title">INSPECTION REPORT</span><br><span style="color:#64748B; font-size:10pt;">Quality Assurance Department</span></td>
        <td width="40%" class="doc-info"></td>
    </tr>
</table>
<br><hr style="color:#E2E8F0;"><br>

<div class="section-header">&nbsp; A. General Information</div>
<table class="info-table" cellpadding="6">
    <tr>
        <td width="33%"><span class="label">Result</span><br><span style="color:'.$resultColor.'; font-weight:bold; font-size : 14px;">'.strtoupper($data['ir_result']).'</span></td>
        <td width="33%"><span class="label">Shift</span><br><span class="value">'.$data['shiftdesc'].'</span></td>
        <td width="33%"><span class="label">Pallet Sequence</span><br><span class="value">#'.$data['ir_pallet_no'].'</span></td>
    </tr>
    <tr>
        <td><span class="label">Inspection Date</span><br><span class="value">'.date('d M Y', strtotime($data['inspect_date'])).'</span></td>
        <td><span class="label">Production Date</span><br><span class="value">'.date('d M Y', strtotime($data['prod_date'])).'</span></td>
        <td><span class="label">Created At</span><br><span class="value">'.date('H:i A', strtotime($data['created_date'])).'</span></td>
    </tr>
</table>

<br>
<div class="section-header">&nbsp; B. Finished Goods Specification</div>
<table class="info-table" cellpadding="6">
    <tr>
        <td width="33%"><span class="label">Part Number</span><br><span class="value">'.$data['matno'].'</span></td>
        <td width="33%"><span class="label">Model Code</span><br><span class="value">'.$data['modcode'].'</span></td>
        <td width="34%"><span class="label">Part Side</span><br><span class="value">'.$data['partside'].'</span></td>
    </tr>
    <tr>
        <td><span class="label">Part Description</span><br><span class="value">'.$data['matdesc'].'</span></td>
        <td><span class="label">Type Model</span><br><span class="value">'.$data['typemodel'].'</span></td>
    </tr>
</table>

<br>';

if ($data['ir_result'] != 'OK') {
    $html .= '
    <div class="section-header">&nbsp; C. Defect Analysis</div>
    <table class="defect-table" cellpadding="6">
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="20%">Defect Type</th>
                <th width="15%">Area</th>
                <th width="30%">Defect Evidence</th>
                <th width="30%">Comparison (Limit)</th>
            </tr>
        </thead>
        <tbody>';
    
    $def_sql = "SELECT d.defect_id, t.defectname, d.defect_area FROM inspection_defect d 
                LEFT JOIN defect_type t ON d.defect_type = t.defectid WHERE d.rcd_ir_id = '$ir_id'";
    $def_res = mysqli_query($db_con, $def_sql);
    $index = 1;
    while ($def_row = mysqli_fetch_assoc($def_res)) {
        $html .= '<tr>
            <td align="center" width="5%">'.$index++.'</td>
            <td width="20%"><strong>'.$def_row['defectname'].'</strong></td>
            <td width="15%">'.$def_row['defect_area'].'</td>
            <td width="30%">';
                $p_res = mysqli_query($db_con, "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = '{$def_row['defect_id']}'");
                while ($p_row = mysqli_fetch_assoc($p_res)) {
                    $imgPath = 'gallery/inspection/defect/' . $ir_id . '/' . $p_row['defect_photo'];
                    if (file_exists($imgPath)) {
                        $html .= '<img src="' . $imgPath . '" width="65" height="65" class="photo-container"> ';
                    }
                }
        $html .= '</td><td  width="30%">';
                $c_res = mysqli_query($db_con, "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = '{$def_row['defect_id']}'");
                while ($c_row = mysqli_fetch_assoc($c_res)) {
                    $imgPath = 'gallery/inspection/defect_compare/' . $ir_id . '/' . $c_row['compare_photo'];
                    if (file_exists($imgPath)) {
                        $html .= '<img src="' . $imgPath . '" width="65" height="65" class="photo-container"> ';
                    }
                }
        $html .= '</td></tr>';
    }
    $html .= '</tbody></table><br>';
}

$html .= '
<br>
<div class="section-header">&nbsp; D. Action Details</div>
<table class="approval-table" cellpadding="8">
    <thead>
        <tr>
            <th width="20%">Action</th>
            <th width="35%">Name</th>
            <th width="20%">Date</th>
            <th width="25%">Remark</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td width="20%"><strong>Created</strong></td>
            <td width="35%">'.htmlspecialchars($data['created_by_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($data['created_date']) && strpos($data['created_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($data['created_date'])) : '-').'</td>
            <td width="25%">-</td>
        </tr>
        <tr>
            <td width="20%"><strong>Submitted</strong></td>
            <td width="35%">'.htmlspecialchars($data['submitted_by_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($data['submitted_date']) && strpos($data['submitted_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($data['submitted_date'])) : '-').'</td>
            <td width="25%">-</td>
        </tr>
        <tr>
            <td width="20%"><strong>Reviewed</strong></td>
            <td width="35%">'.htmlspecialchars($data['reviewed_by_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($data['reviewed_date']) && strpos($data['reviewed_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($data['reviewed_date'])) : '-').'</td>
            <td width="25%" style="text-align:left;">'.htmlspecialchars($data['reviewed_remark']).'</td>
        </tr>
    </tbody>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Inspection_Report_' . $data['ir_docno'] . '.pdf', 'I');
exit;
