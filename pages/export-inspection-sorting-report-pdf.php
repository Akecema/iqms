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
        $this->Cell(0, 5, 'Doc No: ' . $this->doc_no, 0, 1, 'R');
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

// Fetch Sorting Data
$sql = "SELECT S.*, ST.statusname, 
        E1.staff_name as created_name, 
        E2.staff_name as submitted_name, 
        E3.staff_name as reviewed_name, 
        E4.staff_name as approved_name
        FROM inspection_sorting S
        LEFT JOIN system_status ST ON S.sr_status = ST.statusid
        LEFT JOIN employee_details E1 ON S.created_by = E1.staff_id
        LEFT JOIN employee_details E2 ON S.submitted_by = E2.staff_id
        LEFT JOIN employee_details E3 ON S.reviewed_by = E3.staff_id
        LEFT JOIN employee_details E4 ON S.approved_by = E4.staff_id
        WHERE S.sr_ir_id = '$ir_id' AND S.sr_status != 13";
$res = mysqli_query($db_con, $sql);
$sorting = mysqli_fetch_assoc($res);
if (!$sorting) die("Sorting record not found");

$sr_id = $sorting['sr_id'];

// Initialize TCPDF
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->doc_no = $sorting['sr_docno'];
$pdf->report_date = date('d F Y');
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Sorting Report - ' . $sorting['sr_docno']);
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
    .data-table { width: 100%; border-collapse: collapse; }
    .data-table th { 
        background-color: #F8FAFC; 
        color: #2B522B; 
        font-weight: bold; 
        border-bottom: 2px solid #2B522B;
        padding: 8px;
    }
    .data-table td { border-bottom: 1px solid #EDF2F7; padding: 8px; font-size: 9pt; }
    .photo-box { border: 1px solid #E2E8F0; }
    .qty-ok { color: #2B522B; font-weight: bold; }
    .qty-ng { color: #E74C3C; font-weight: bold; }
    .approval-table { width: 100%; border-collapse: collapse; }
    .approval-table th { background-color: #F8FAFC; color: #2B522B; font-weight: bold; border-bottom: 2px solid #2B522B; padding: 8px; text-align: center; }
    .approval-table td { border-bottom: 1px solid #EDF2F7; padding: 8px; font-size: 9pt; text-align: center; }
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="60%"><span class="title">SORTING REPORT</span><br><span style="color:#64748B; font-size:10pt;">Quality Assurance Department</span></td>
        <td width="40%" class="doc-info"></td>
    </tr>
</table>
<br><hr style="color:#E2E8F0;"><br>

<div class="section-header">&nbsp; A. Sorting Result</div>
<table class="summary-table" width="100%" cellpadding="8">
    <tr>
        <td class="label">Qty OK</td><td class="value"><span class="qty-ok">'.number_format($sorting['sr_qty_ok']).' </span></td>
        <td class="label">Qty NG</td><td class="value"><span class="qty-ng">'.number_format($sorting['sr_qty_ng']).' </span></td>
    </tr>
</table>

<br><br>
<div class="section-header">&nbsp; B. Methodology & Remarks</div>
<table class="summary-table" width="100%" cellpadding="8">
    <tr>
        <td class="label" style="width:20%">Sorting Method</td>
        <td class="value" style="width:80%">'.($sorting['sr_sorting_method'] ?: '-').'</td>
    </tr>
    <tr>
        <td class="label" style="width:20%">Rework Method</td>
        <td class="value" style="width:80%">'.($sorting['sr_rework_method'] ?: '-').'</td>
    </tr>
    <tr>
        <td class="label" style="width:20%">Remarks</td>
        <td class="value" style="width:80%; border:none; background-color:#F8FAFC;">'.nl2br($sorting['sr_remarks']).'</td>
    </tr>
</table>';

// --- C & D: Photos Section ---
$photo_sections = [
    ['title' => 'C. Photos Before Sorting (NG)', 'sql' => "SELECT before_photo as img FROM inspection_sorting_before_photo WHERE sr_sorting_id = '$sr_id'", 'path' => 'gallery/inspection_sorting/before/'],
    ['title' => 'D. Photos After Sorting (OK)', 'sql' => "SELECT after_photo as img FROM inspection_sorting_after_photo WHERE sr_sorting_id = '$sr_id'", 'path' => 'gallery/inspection_sorting/after/']
];

foreach ($photo_sections as $sec) {
    $res_photo = mysqli_query($db_con, $sec['sql']);
    if (mysqli_num_rows($res_photo) > 0) {
        $valid_images = [];
        while ($row = mysqli_fetch_assoc($res_photo)) {
            $fullPath = $sec['path'] . $sr_id . '/' . $row['img'];
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
                $html .= '<td width="33.33%" style="text-align: left;"><img src="'.$imgPath.'" width="160" height="130" class="photo-box"></td>';
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

// --- E, F, G: Related Parts Data Fetching ---
$res_inhouse = mysqli_query($db_con, "SELECT p.*, d.rd_dept_name, m.bom, m.bomdesc FROM inspection_sorting_related_part_dept p LEFT JOIN related_departments d ON p.srp_related_dept = d.rd_dept_id LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id WHERE p.srp_ir_id_sorting = '$sr_id'");
$res_vendor = mysqli_query($db_con, "SELECT p.*, v.rv_vendor_name, m.bom, m.bomdesc FROM inspection_sorting_related_part_vendor p LEFT JOIN related_vendors v ON p.srp_related_vdr = v.rv_vendor_id LEFT JOIN material_details m ON p.srp_mathdr_id_vdr = m.matdet_id WHERE p.srp_ir_id_sorting = '$sr_id'");
$res_customer = mysqli_query($db_con, "SELECT p.*, c.rc_cust_name FROM inspection_sorting_related_part_cust p LEFT JOIN related_customers c ON p.srp_related_cust = c.rc_cust_id WHERE p.srp_ir_id_sorting = '$sr_id'");

$tables = [
    ['title' => 'E. Related Loose Part - In House', 'res' => $res_inhouse, 'h1' => 'Department', 'col' => 'rd_dept_name', 'suffix' => 'dept', 'has_bom' => true],
    ['title' => 'F. Related Loose Part - Vendor', 'res' => $res_vendor, 'h1' => 'Vendor', 'col' => 'rv_vendor_name', 'suffix' => 'vdr', 'has_bom' => true],
    ['title' => 'G. Finished Goods Part - Customer', 'res' => $res_customer, 'h1' => 'Customer', 'col' => 'rc_cust_name', 'suffix' => 'cust', 'has_bom' => false]
];

foreach ($tables as $t) {
    if (mysqli_num_rows($t['res']) > 0) {
        $html .= '<br><br>
        <table nobr="true" width="100%" cellpadding="0" border="0">
            <tr>
                <td>
                    <div class="section-header">&nbsp; '.$t['title'].'</div>
                    <table class="data-table" cellpadding="8">
                        <thead>
                            <tr>
                                <th width="30%">'.$t['h1'].'</th>
                                <th width="40%">Part Specification</th>
                                <th width="15%" style="text-align:center;">Qty OK</th>
                                <th width="15%" style="text-align:center;">Qty NG</th>
                            </tr>
                        </thead>';
        
        mysqli_data_seek($t['res'], 0);
        while ($p = mysqli_fetch_assoc($t['res'])) {
            $ok_val = $p['srp_qty_ok_' . $t['suffix']];
            $ng_val = $p['srp_qty_ng_' . $t['suffix']];
            $part_info = $t['has_bom'] ? '<strong>'.$p['bom'].'</strong><br><small>'.$p['bomdesc'].'</small>' : '-';

            $html .= '<tr>
                <td width="30%">'.$p[$t['col']].'</td>
                <td width="40%">'.$part_info.'</td>
                <td width="15%" align="center" class="qty-ok">'.number_format($ok_val).'</td>
                <td width="15%" align="center" class="qty-ng">'.number_format($ng_val).'</td>
            </tr>';
        }
        $html .= '</table>
                </td>
            </tr>
        </table>';
    }
}

// --- H: Authorization ---
$html .= '<br><br>
<table nobr="true" width="100%" cellpadding="0" border="0">
    <tr>
        <td>
            <div class="section-header">&nbsp; H. Action Details</div>
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
                        <td width="35%">'.htmlspecialchars($sorting['created_name'] ?: '-').'</td>
                        <td width="20%">'.((!empty($sorting['created_date']) && strpos($sorting['created_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($sorting['created_date'])) : '-').'</td>
                        <td width="25%">-</td>
                    </tr>
                    <tr>
                        <td width="20%"><strong>Submitted</strong></td>
                        <td width="35%">'.htmlspecialchars($sorting['submitted_name'] ?: '-').'</td>
                        <td width="20%">'.((!empty($sorting['submitted_date']) && strpos($sorting['submitted_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($sorting['submitted_date'])) : '-').'</td>
                        <td width="25%">-</td>
                    </tr>
                    <tr>
                        <td width="20%"><strong>Reviewed</strong></td>
                        <td width="35%">'.htmlspecialchars($sorting['approved_name'] ?: '-').'</td>
                        <td width="20%">'.((!empty($sorting['approved_date']) && strpos($sorting['approved_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($sorting['approved_date'])) : '-').'</td>
                        <td width="25%" style="text-align:left;">'.htmlspecialchars($sorting['approved_remark']).'</td>
                    </tr>
                </tbody>
            </table>
        </td>
    </tr>
</table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Sorting_Report_'.$sorting['sr_docno'].'.pdf', 'I');
exit;