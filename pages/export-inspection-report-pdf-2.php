<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
require_once('TCPDF/tcpdf.php');

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

$resultColor = ($data['ir_result'] == 'OK') ? '#085209' : '#FF0000';

// Initialize TCPDF
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('Inspection Report - ' . $data['ir_docno']);

// Remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// Set margins
$pdf->SetMargins(15, 15, 15);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 15);

// Set font
$pdf->SetFont('helvetica', '', 10);

// Add a page
$pdf->AddPage();

// Construct HTML content
$html = '
<style>
    .report-header {
        background-color: #337A36;
        color: white;
        text-align: center;
        padding: 10px;
    }
    .section-title {
        background-color: #F2F4F2;
        color: #2C3E50;
        font-weight: bold;
        padding: 5px;
        border-bottom: 2px solid #337A36;
    }
    .info-table {
        width: 100%;
        border-collapse: collapse;
    }
    .info-table td {
        padding: 8px;
        border: 1px solid #E2E8F0;
    }
    .label {
        font-size: 9pt;
        color: #64748B;
        font-weight: bold;
    }
    .value {
        font-size: 9pt;
        font-weight: normal;
        color: #3D403D;
    }
    .defect-table {
        width: 100%;
        border-collapse: collapse;
    }
    .defect-table th {
        background-color: #F2F4F2;
        font-weight: bold;
        border-bottom: 2px solid #337A36;
        padding: 5px;
    }
    .defect-table td {
        border-bottom: 1px solid #E2E8F0;
        padding: 5px;
    }
    .photo-box {
        width: 80px;
        height: 80px;
        margin-right: 5px;
    }
</style>

<div class="report-header">
    <h1 style="font-size: 18pt;">INSPECTION REPORT : ' . $data['ir_docno'] . '</h1>
</div>

<br><br>

<div class="section-title">A. General Information</div>
<table class="info-table">
    <tr>
        <td width="33%">
            <span class="label">Document No</span><br>
            <span class="value">' . $data['ir_docno'] . '</span>
        </td>
        <td width="33%">
            <span class="label">Result</span><br>
            <span class="value" style="color:' . $resultColor . '; font-weight:bold;">' . $data['ir_result'] . '</span>
        </td>
        <td width="34%">
            <span class="label">Inspection Date</span><br>
            <span class="value">' . date('d-m-Y', strtotime($data['inspect_date'])) . '</span>
        </td>
    </tr>
    <tr>
        <td>
            <span class="label">Shift</span><br>
            <span class="value">' . $data['shiftdesc'] . '</span>
        </td>
        <td>
            <span class="label">Pallet Sequence</span><br>
            <span class="value">' . $data['ir_pallet_no'] . '</span>
        </td>
        <td>
            <span class="label">Production Date</span><br>
            <span class="value">' . date('d-m-Y', strtotime($data['prod_date'])) . '</span>
        </td>
    </tr>
</table>

<br><br>

<div class="section-title">B. Finished Goods Details</div>
<table class="info-table">
    <tr>
        <td width="33%">
            <span class="label">Part No</span><br>
            <span class="value">' . $data['matno'] . '</span>
        </td>
        <td width="67%">
            <span class="label">Model</span><br>
            <span class="value">' . $data['modcode'] . " (" . $data['partside'] . ")" . '</span>
        </td>
    </tr>
    <tr>
        <td width="33%">
            <span class="label">Part Name</span><br>
            <span class="value">' . $data['matdesc'] . '</span>
        </td>
        <td width="67%">
            <span class="label">Type</span><br>
            <span class="value">' . $data['typemodel'] . '</span>
        </td>
    </tr>
</table>

<br><br>';

if ($data['ir_result'] != 'OK') {
    $html .= '
    <div class="section-title">C. Defect Details</div>
    <table class="defect-table" cellpadding="5">
        <thead>
            <tr style="background-color: #F2F4F2;">
                <th width="5%">No</th>
                <th width="20%">Type</th>
                <th width="15%">Area</th>
                <th width="30%">Defect Photo</th>
                <th width="30%">Comparison Photo</th>
            </tr>
        </thead>
        <tbody>';
    
    $def_sql = "SELECT d.defect_id, t.defectname, d.defect_area FROM inspection_defect d 
                LEFT JOIN defect_type t ON d.defect_type = t.defectid WHERE d.rcd_ir_id = '$ir_id'";
    $def_res = mysqli_query($db_con, $def_sql);
    $index = 1;
    while ($def_row = mysqli_fetch_assoc($def_res)) {
        $html .= '<tr>
            <td align="center">' . $index++ . '</td>
            <td>' . $def_row['defectname'] . '</td>
            <td>' . $def_row['defect_area'] . '</td>
            <td>';
            
        $p_sql = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = '{$def_row['defect_id']}'";
        $p_res = mysqli_query($db_con, $p_sql);
        while ($p_row = mysqli_fetch_assoc($p_res)) {
            $imgPath = 'gallery/inspection/defect/' . $ir_id . '/' . $p_row['defect_photo'];
            if (file_exists($imgPath)) {
                $html .= '<img src="' . $imgPath . '" width="70" height="70" style="margin-right:2px;"> ';
            }
        }
        
        $html .= '</td>
            <td>';
            
        $c_sql = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = '{$def_row['defect_id']}'";
        $c_res = mysqli_query($db_con, $c_sql);
        while ($c_row = mysqli_fetch_assoc($c_res)) {
            $imgPath = 'gallery/inspection/defect_compare/' . $ir_id . '/' . $c_row['compare_photo'];
            if (file_exists($imgPath)) {
                $html .= '<img src="' . $imgPath . '" width="70" height="70" style="margin-right:2px;"> ';
            }
        }
        
        $html .= '</td>
        </tr>';
    }
    $html .= '</tbody></table><br><br>';
}

$html .= '
<div class="section-title">D. Approval</div>
<table class="info-table">
    <tr>
        <td width="67%">
            <span class="label">Created By</span><br>
            <span class="value">' . (!empty($data['created_by_name']) ? $data['created_by_name'] : '-') . '</span>
        </td>
        <td width="33%">
            <span class="label">Created Date</span><br>
            <span class="value">' . ($data['created_date'] != '0000-00-00 00:00:00' ? date('d-m-Y H:i A', strtotime($data['created_date'])) : '-') . '</span>
        </td>
    </tr>
    <tr>
        <td>
            <span class="label">Submitted By</span><br>
            <span class="value">' . (!empty($data['submitted_by_name']) ? $data['submitted_by_name'] : '-') . '</span>
        </td>
        <td>
            <span class="label">Submitted Date</span><br>
            <span class="value">' . ($data['submitted_date'] != '0000-00-00 00:00:00' ? date('d-m-Y H:i A', strtotime($data['submitted_date'])) : '-') . '</span>
        </td>
    </tr>
    <tr>
        <td>
            <span class="label">Reviewed By</span><br>
            <span class="value">' . (!empty($data['reviewed_by_name']) ? $data['reviewed_by_name'] : '-') . '</span>
        </td>
        <td>
            <span class="label">Reviewed Date</span><br>
            <span class="value">' . ($data['reviewed_date'] != '0000-00-00 00:00:00' ? date('d-m-Y H:i A', strtotime($data['reviewed_date'])) : '-') . '</span>
        </td>
    </tr>';

if (!empty($data['reviewed_remark'])) {
    $html .= '
    <tr>
        <td colspan="2">
            <span class="label">Remarks</span><br>
            <span class="value">' . $data['reviewed_remark'] . '</span>
        </td>
    </tr>';
}

$html .= '</table>';

// Print text using writeHTMLCell()
$pdf->writeHTML($html, true, false, true, false, '');

// Close and output PDF document
$pdf->Output('Inspection_Report_' . $data['ir_docno'] . '.pdf', 'I');
