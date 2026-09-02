<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
require_once('TCPDF/tcpdf.php');

$ir_id = isset($_GET['ir_id']) ? mysqli_real_escape_string($db_con, $_GET['ir_id']) : '';
if (empty($ir_id)) die("Missing Record ID");

// Fetch ir_docno
$res_ir = mysqli_query($db_con, "SELECT ir_docno FROM inspection_records WHERE ir_id = '$ir_id'");
$ir_data = mysqli_fetch_assoc($res_ir);

// Fetch S2W Reply Data
$sql = "SELECT rp.*,
        E1.staff_name as created_name, E2.staff_name as submitted_name, 
        E3.staff_name as approved_name 
        FROM inspection_s2w_report rp
        LEFT JOIN employee_details E1 ON rp.created_by = E1.staff_id
        LEFT JOIN employee_details E2 ON rp.submitted_by = E2.staff_id
        LEFT JOIN employee_details E3 ON rp.approved_by = E3.staff_id
        WHERE rp.rp_s2w_ir_id = '$ir_id'";
$res = mysqli_query($db_con, $sql);
$reply = mysqli_fetch_assoc($res);
if (!$reply) die("S2W Reply record not found");

$rp_id = $reply['rp_id'];

// Initialize TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('S2W Reply Report - ' . $ir_data['ir_docno']);
$pdf->setPrintHeader(false);
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
    .label { font-weight: bold; color: #34495E; font-size: 9pt; width: 25%; }
    .value { color: #2C3E50; width: 75%; border-bottom: 1px solid #E2E8F0; }
    .photo-box { border: 1px solid #E2E8F0; }
    .approval-table { width: 100%; border-collapse: collapse; }
    .approval-table th { background-color: #F8FAFC; color: #2B522B; font-weight: bold; border-bottom: 2px solid #2B522B; padding: 8px; text-align: center; }
    .approval-table td { border-bottom: 1px solid #EDF2F7; padding: 8px; font-size: 9pt; text-align: center; }
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="60%"><span class="title">S2W REPLY REPORT</span><br><span style="color:#64748B; font-size:10pt;">Quality Assurance Department</span></td>
        <td width="40%" class="doc-info">
            <strong>INSPECT DOC NO:</strong> '.$ir_data['ir_docno'].'<br>
            <strong>DATE:</strong> '.date('d F Y').'<br>
        </td>
    </tr>
</table>
<br><hr style="color:#E2E8F0;"><br>

<div class="section-header">&nbsp; A. S2W Reply Details</div>
<table class="summary-table" width="100%" cellpadding="8">
    <tr>
        <td class="label">Chronology</td>
        <td class="value" style="background-color:#F8FAFC;">'.nl2br(htmlspecialchars($reply['rp_s2w_cronology'])).'</td>
    </tr>
    <tr>
        <td class="label">Root Cause</td>
        <td class="value" style="background-color:#F8FAFC;">'.nl2br(htmlspecialchars($reply['rp_s2w_rootcause'])).'</td>
    </tr>
    <tr>
        <td class="label">Root Cause Area</td>
        <td class="value" style="background-color:#F8FAFC;">'.htmlspecialchars($reply['rp_s2w_rootcause_area']).'</td>
    </tr>
    <tr>
        <td class="label">Root Cause Place</td>
        <td class="value" style="background-color:#F8FAFC;">'.htmlspecialchars($reply['rp_s2w_rootcause_place']).'</td>
    </tr>
    <tr>
        <td class="label">Correction</td>
        <td class="value" style="background-color:#F8FAFC;">'.nl2br(htmlspecialchars($reply['rp_s2w_correction'])).'</td>
    </tr>
    <tr>
        <td class="label">Preventive</td>
        <td class="value" style="background-color:#F8FAFC;">'.nl2br(htmlspecialchars($reply['rp_s2w_preventive'])).'</td>
    </tr>
    <tr>
        <td class="label">Conclusion</td>
        <td class="value" style="background-color:#F8FAFC;">'.nl2br(htmlspecialchars($reply['rp_s2w_conclusion'])).'</td>
    </tr>
</table>';

// --- B & C: Photos Section ---
$photo_sections = [
    ['title' => 'B. Correction Photos', 'sql' => "SELECT correction_photo as img FROM inspection_s2w_correction_photo WHERE s2w_rp_id = '$rp_id'", 'path' => 'gallery/inspection_s2w_report/photo_correction/'],
    ['title' => 'C. Preventive Photos', 'sql' => "SELECT preventive_photo as img FROM inspection_s2w_preventive_photo WHERE s2w_rp_id = '$rp_id'", 'path' => 'gallery/inspection_s2w_report/photo_preventive/']
];

foreach ($photo_sections as $sec) {
    $res_photo = mysqli_query($db_con, $sec['sql']);
    if (mysqli_num_rows($res_photo) > 0) {
        $valid_images = [];
        while ($row = mysqli_fetch_assoc($res_photo)) {
            $fullPath = $sec['path'] . $rp_id . '/' . $row['img'];
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
                        $html .= '<table nobr="true" width="100%" cellpadding="0"><tr><td>';
                        $html .= '<div class="section-header">&nbsp; '.$sec['title'].'</div>';
                        $html .= '<table width="100%" cellpadding="10"><tr>';
                    } else {
                        $html .= '<table width="100%" cellpadding="10"><tr nobr="true">';
                    }
                }
                $html .= '<td width="33.33%" style="text-align: left;"><img src="'.$imgPath.'" width="160" height="130" class="photo-box"></td>';
                $count++;
            }
            
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
            <td width="35%">'.htmlspecialchars($reply['created_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($reply['created_date']) && strpos($reply['created_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($reply['created_date'])) : '-').'</td>
            <td width="25%">-</td>
        </tr>
        <tr>
            <td width="20%"><strong>Submitted</strong></td>
            <td width="35%">'.htmlspecialchars($reply['submitted_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($reply['submitted_date']) && strpos($reply['submitted_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($reply['submitted_date'])) : '-').'</td>
            <td width="25%">-</td>
        </tr>
        <tr>
            <td width="20%"><strong>Approved</strong></td>
            <td width="35%">'.htmlspecialchars($reply['approved_name'] ?: '-').'</td>
            <td width="20%">'.((!empty($reply['approved_date']) && strpos($reply['approved_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($reply['approved_date'])) : '-').'</td>
            <td width="25%" style="text-align:left;">'.htmlspecialchars($reply['approved_remark']).'</td>
        </tr>
    </tbody>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('S2W_Reply_Report_'.$ir_data['ir_docno'].'.pdf', 'I');
exit;
