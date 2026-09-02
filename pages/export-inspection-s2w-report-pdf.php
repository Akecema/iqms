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
        $this->SetFont('dejavusans', 'I', 8);
        $this->SetTextColor(126, 130, 126);
        // Doc No
        $this->Cell(0, 5, 'Doc No: ' .$this->doc_no, 0, 1, 'R');
        // Date - below doc no
        $this->Cell(0, 5, 'Date: ' . $this->report_date, 0, 1, 'R');
    }

    // Page footer
    public function Footer() {
        $this->SetY(-15);
        $this->SetFont('dejavusans', 'I', 8);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}


$ir_id = isset($_GET['ir_id']) ? mysqli_real_escape_string($db_con, $_GET['ir_id']) : '';
if (empty($ir_id)) die("Missing Record ID");

// Fetch ir_docno
$res_ir = mysqli_query($db_con, "SELECT ir_docno FROM inspection_records WHERE ir_id = '$ir_id'");
$ir_data = mysqli_fetch_assoc($res_ir);

// Fetch S2W Data
$sql = "SELECT S.*, ST.statusname, D.rd_dept_name,
        E1.staff_name as created_name, E2.staff_name as submitted_name, 
        E3.staff_name as reviewed_name, E4.staff_name as approved_name 
        FROM inspection_s2w S
        LEFT JOIN related_departments D ON S.s2w_send_to = D.rd_dept_id
        LEFT JOIN system_status ST ON S.s2w_status = ST.statusid
        LEFT JOIN employee_details E1 ON S.created_by = E1.staff_id
        LEFT JOIN employee_details E2 ON S.submitted_by = E2.staff_id
        LEFT JOIN employee_details E3 ON S.reviewed_by = E3.staff_id
        LEFT JOIN employee_details E4 ON S.approved_by = E4.staff_id
        WHERE S.s2w_ir_id = '$ir_id' AND S.s2w_status != 13";
$res = mysqli_query($db_con, $sql);
$s2w = mysqli_fetch_assoc($res);
if (!$s2w) die("S2W record not found");

$s2w_id = $s2w['s2w_id'];

// Initialize TCPDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->doc_no = $s2w['s2w_docno'];
$pdf->report_date = date('d F Y');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('S2W Report - ' . $s2w['s2w_docno']);
$pdf->setPrintHeader(true);
$pdf->setPrintFooter(true); 
$pdf->SetMargins(15, 20, 15);
$pdf->SetAutoPageBreak(TRUE, 20);

$pdf->SetFont('dejavusans', '', 10);
$pdf->AddPage();

// --- CSS Styles ---
$html = '
<style>
    .title { font-size: 18pt; font-weight: bold; color: #555755; }
    .doc-info { text-align: right; color: #555755; font-size: 8pt; }
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
    .summary-table td { padding: 5px; vertical-align: middle; }
    .label { font-weight: bold; color: #34495E; font-size: 9pt; width: 15%; }
    .value { color: #2C3E50; width: 35%; border-bottom: 1px solid #E2E8F0; }
    .photo-box { border: 1px solid #E2E8F0; }
    .approval-table { width: 100%; border-collapse: collapse; }
    .approval-table th { background-color: #F8FAFC; color: #2B522B; font-weight: bold; border-bottom: 2px solid #2B522B; padding: 8px; text-align: center; }
    .approval-table td { border-bottom: 1px solid #EDF2F7; padding: 8px; font-size: 9pt; text-align: center; }
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="60%"><span class="title">S2W REPORT</span><br><span style="color:#64748B; font-size:10pt;">Quality Assurance Department</span></td>
        <td width="40%" class="doc-info"></td>
    </tr>
</table>
<br><hr style="color:#E2E8F0;"><br>

<div class="section-header">&nbsp; A. S2W Details</div>
<table class="summary-table" width="100%" cellpadding="8">
    <tr>
        <td class="label" style="width:20%">Sending To</td>
        <td class="value" style="width:80%" colspan="3">'.htmlspecialchars($s2w['rd_dept_name'] ?: '-').'</td>
    </tr>
    <tr>
        <td class="label" style="width:20%">Additional Info</td>
        <td class="value" style="width:80%; border:none; background-color:#F8FAFC;" colspan="3">'.nl2br(htmlspecialchars($s2w['s2w_additional_desc'])).'</td>
    </tr>
</table>';

// --- B & C: Photos Section ---
$photo_sections = [
    ['title' => 'B. Photos NG (Defect)', 'sql' => "SELECT defect_photo as img FROM inspection_s2w_defect_photo WHERE s2w_id = '$s2w_id'", 'path' => 'gallery/inspection_s2w/photo_defect/'],
    ['title' => 'C. Photo OK', 'sql' => "SELECT ok_photo as img FROM inspection_s2w_ok_photo WHERE s2w_id = '$s2w_id'", 'path' => 'gallery/inspection_s2w/photo_ok/']
];

foreach ($photo_sections as $sec) {
    $res_photo = mysqli_query($db_con, $sec['sql']);
    if (mysqli_num_rows($res_photo) > 0) {
        $valid_images = [];
        while ($row = mysqli_fetch_assoc($res_photo)) {
            $fullPath = $sec['path'] . $s2w_id . '/' . $row['img'];
            if (file_exists($fullPath)) {
                $valid_images[] = $fullPath;
            }
        }

        if (count($valid_images) > 0) {
            $html .= '<br><br>';
            $count = 0;
            $is_first_row = true;
            
            foreach ($valid_images as $imgPath) {
                if ($count % 3 == 0) {
                    if ($count > 0) {
                        $html .= '</tr></table>';
                        if ($is_first_row) {
                            $html .= '</td></tr></table>';
                            $is_first_row = false;
                        }
                    }
                    if ($is_first_row) {
                        // The wrapper table ensures the header and the first row of images stay on the same page
                        $html .= '<table nobr="true" width="100%" cellpadding="0"><tr><td>';
                        $html .= '<div class="section-header">&nbsp; '.$sec['title'].'</div>';
                        $html .= '<table width="100%" cellpadding="10"><tr>';
                    } else {
                        // Subsequent rows also kept together
                        $html .= '<table width="100%" cellpadding="10"><tr nobr="true">';
                    }
                }
                $html .= '<td width="33.33%" style="text-align: left;"><img src="'.$imgPath.'" width="130" height="100" class="photo-box"></td>';
                $count++;
            }
            
            // Fill empty cells to maintain grid width
            while ($count % 3 != 0) {
                $html .= '<td width="33.33%"></td>';
                $count++;
            }
            $html .= '</tr></table>';
            if ($is_first_row) {
                $html .= '</td></tr></table>';
            }
        }
    }
}

// --- D: Approval Details ---
$html .= '<br><br><div class="section-header">&nbsp; D. Action Details</div>
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
            <td width="35%">'.htmlspecialchars($s2w['created_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($s2w['created_date']) && strpos($s2w['created_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w['created_date'])) : '-').'</td>
            <td width="25%">-</td>
        </tr>
        <tr>
            <td width="20%"><strong>Submitted</strong></td>
            <td width="35%">'.htmlspecialchars($s2w['submitted_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($s2w['submitted_date']) && strpos($s2w['submitted_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w['submitted_date'])) : '-').'</td>
            <td width="25%">-</td>
        </tr>
        <tr>
            <td width="20%"><strong>Reviewed</strong></td>
            <td width="35%">'.htmlspecialchars($s2w['reviewed_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($s2w['reviewed_date']) && strpos($s2w['reviewed_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w['reviewed_date'])) : '-').'</td>
            <td width="25%" style="text-align:left;">'.htmlspecialchars($s2w['reviewed_remark']).'</td>
        </tr>
        <tr>
            <td width="20%"><strong>Approved</strong></td>
            <td width="35%">'.htmlspecialchars($s2w['approved_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($s2w['approved_date']) && strpos($s2w['approved_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($s2w['approved_date'])) : '-').'</td>
            <td width="25%" style="text-align:left;">'.htmlspecialchars($s2w['approved_remark']).'</td>
        </tr>
    </tbody>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('S2W_Report_'.$s2w['s2w_docno'].'.pdf', 'I');
exit;
