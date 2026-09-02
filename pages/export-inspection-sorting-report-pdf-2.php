<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
require_once('TCPDF/tcpdf.php');

$ir_id = isset($_GET['ir_id']) ? mysqli_real_escape_string($db_con, $_GET['ir_id']) : '';
if (empty($ir_id)) die("Missing Record ID");

// Fetch Sorting Data
$sql = "SELECT S.*, ST.statusname, E1.staff_name as created_name
        FROM inspection_sorting S
        LEFT JOIN system_status ST ON S.sr_status = ST.statusid
        LEFT JOIN employee_details E1 ON S.created_by = E1.staff_id
        WHERE S.sr_ir_id = '$ir_id' AND S.sr_status != 13";
$res = mysqli_query($db_con, $sql);
$sorting = mysqli_fetch_assoc($res);
if (!$sorting) die("Sorting record not found");

$sr_id = $sorting['sr_id'];

// Initialize TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle('Sorting Report - ' . $sorting['sr_docno']);
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->SetMargins(15, 15, 15);
$pdf->SetAutoPageBreak(TRUE, 15);
$pdf->SetFont('helvetica', '', 10);
$pdf->AddPage();

$html = '
<style>
    .header { 
        background-color: #337A36; 
        color: white; 
        text-align: center; 
        padding: 10px; 
    }
    .section-title { 
        background-color: #F2F4F2; 
        color: #2C3E50;
        padding: 5px; 
        font-weight: bold; 
        border-bottom: 2px solid #337A36;
    }
    table { 
        width: 100%; 
        border-collapse: collapse; 
    }
    th, td { 
        border: 1px solid #E2E8F0; 
        padding: 8px;
        line-height : 1.5 
    }
    .label { 
        font-weight: bold; 
        color: #64748B; 
        font-size: 9pt; 
    }
</style>
<div class="header"><h1>Sorting Report : '.$sorting['sr_docno'].'</h1></div>
<br><br>
<div class="section-title">A. Summary</div>
<table>
    <tr nobr="true">
        <td class="label">Doc No</td><td>'.$sorting['sr_docno'].'</td>
        <td class="label">Status</td><td>'.$sorting['statusname'].'</td>
    </tr>
    <tr nobr="true">
        <td class="label">Qty OK</td><td>'.number_format($sorting['sr_qty_ok']).'</td>
        <td class="label">Qty NG</td><td>'.number_format($sorting['sr_qty_ng']).'</td>
    </tr>
</table>
<br><br>
<div class="section-title">B. Sorting Details</div>
<table>
    <tr nobr="true"><td class="label">Sorting Method</td><td>'.nl2br($sorting['sr_sorting_method']).'</td></tr>
    <tr nobr="true"><td class="label">Rework Method</td><td>'.nl2br($sorting['sr_rework_method']).'</td></tr>
    <tr nobr="true"><td class="label">Remarks</td><td>'.nl2br($sorting['sr_remarks']).'</td></tr>
</table>
';

// Photos Before Sorting (NG)
$res_before = mysqli_query($db_con, "SELECT before_photo FROM inspection_sorting_before_photo WHERE sr_sorting_id = '$sr_id'");
if (mysqli_num_rows($res_before) > 0) {
    $html .= '<br><br><div class="section-title">C. Photos Before Sorting (NG)</div><table style="padding: 10px;"><tr nobr="true">';
    $count = 0;
    while ($row = mysqli_fetch_assoc($res_before)) {
        if ($count > 0 && $count % 4 == 0) $html .= '</tr><tr>';
        $imgPath = 'gallery/inspection_sorting/before/' . $sr_id . '/' . $row['before_photo'];
        if (file_exists($imgPath)) {
            $html .= '<td style="border: none; text-align: center;"><img src="'.$imgPath.'" width="120" height="120" style="border: 1px solid #E2E8F0;"></td>';
            $count++;
        }
    }
    // Fill empty cells
    while ($count % 4 != 0) {
        $html .= '<td style="border: none;"></td>';
        $count++;
    }
    $html .= '</tr></table>';
}

// Photos After Sorting (OK)
$res_after = mysqli_query($db_con, "SELECT after_photo FROM inspection_sorting_after_photo WHERE sr_sorting_id = '$sr_id'");
if (mysqli_num_rows($res_after) > 0) {
    $html .= '<br><br><div class="section-title">D. Photos After Sorting (OK)</div><table style="padding: 10px;"><tr nobr="true">';
    $count = 0;
    while ($row = mysqli_fetch_assoc($res_after)) {
        if ($count > 0 && $count % 4 == 0) $html .= '</tr><tr>';
        $imgPath = 'gallery/inspection_sorting/after/' . $sr_id . '/' . $row['after_photo'];
        if (file_exists($imgPath)) {
            $html .= '<td style="border: none; text-align: center;"><img src="'.$imgPath.'" width="120" height="120" style="border: 1px solid #E2E8F0;"></td>';
            $count++;
        }
    }
    // Fill empty cells
    while ($count % 4 != 0) {
        $html .= '<td style="border: none;"></td>';
        $count++;
    }
    $html .= '</tr></table>';
}

// Add In-House Parts
$res_inhouse = mysqli_query($db_con, "SELECT p.*, d.rd_dept_name, t.tp_partname, m.bom, m.bomdesc 
                                       FROM inspection_sorting_related_part_dept p
                                       LEFT JOIN related_departments d ON p.srp_related_dept = d.rd_dept_id
                                       LEFT JOIN type_part t ON p.srp_type_part_dept = t.tp_partid
                                       LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
                                       WHERE p.srp_ir_id_sorting = '$sr_id'");
if (mysqli_num_rows($res_inhouse) > 0) {
    $html .= '<br><br><div class="section-title">E. Related Loose Part - In House</div>
    <table>
        <tr style="background-color: #F2F4F2;"><th width="25%">Dept</th><th width="45%">Part No</th><th width="15%">Qty OK</th><th width="15%">Qty NG</th></tr>';
    while ($p = mysqli_fetch_assoc($res_inhouse)) {
        $html .= '<tr nobr="true"><td>'.$p['rd_dept_name'].'</td><td>'.$p['bom'].'<br><span style="font-size: 8pt; color: #64748B;">'.$p['bomdesc'].'</span></td><td>'.$p['srp_qty_ok_dept'].'</td><td>'.$p['srp_qty_ng_dept'].'</td></tr>';
    }
    $html .= '</table>';
}

// Add Vendor Parts
$res_vendor = mysqli_query($db_con, "SELECT p.*, v.rv_vendor_name, m.bom, m.bomdesc 
                                      FROM inspection_sorting_related_part_vendor p
                                      LEFT JOIN related_vendors v ON p.srp_related_vdr = v.rv_vendor_id
                                      LEFT JOIN material_details m ON p.srp_mathdr_id_vdr = m.matdet_id
                                      WHERE p.srp_ir_id_sorting = '$sr_id'");
if (mysqli_num_rows($res_vendor) > 0) {
    $html .= '<br><br><div class="section-title">F. Related Loose Part - Vendor</div>
    <table>
        <tr style="background-color: #F2F4F2;"><th width="25%">Vendor</th><th width="45%">Part No</th><th width="15%">Qty OK</th><th width="15%">Qty NG</th></tr>';
    while ($p = mysqli_fetch_assoc($res_vendor)) {
        $html .= '<tr nobr="true"><td>'.$p['rv_vendor_name'].'</td><td>'.$p['bom'].'<br><span style="font-size: 8pt; color: #64748B;">'.$p['bomdesc'].'</span></td><td>'.$p['srp_qty_ok_vdr'].'</td><td>'.$p['srp_qty_ng_vdr'].'</td></tr>';
    }
    $html .= '</table>';
}

// Add Customer Parts
$res_customer = mysqli_query($db_con, "SELECT p.*, c.rc_cust_name 
                                        FROM inspection_sorting_related_part_cust p
                                        LEFT JOIN related_customers c ON p.srp_related_cust = c.rc_cust_id
                                        WHERE p.srp_ir_id_sorting = '$sr_id'");
if (mysqli_num_rows($res_customer) > 0) {
    $html .= '<br><br><div class="section-title">G. Finished Goods Part - Customer</div>
    <table>
        <tr style="background-color: #F2F4F2;"><th width="60%">Customer</th><th width="20%">Qty OK</th><th width="20%">Qty NG</th></tr>';
    while ($p = mysqli_fetch_assoc($res_customer)) {
        $html .= '<tr nobr="true"><td>'.$p['rc_cust_name'].'</td><td>'.$p['srp_qty_ok_cust'].'</td><td>'.$p['srp_qty_ng_cust'].'</td></tr>';
    }
    $html .= '</table>';
}
$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Sorting_Report_'.$sorting['sr_docno'].'.pdf', 'I');
exit;
