<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
require_once('TCPDF/tcpdf.php');

// Get filters from GET
$fd_model = $_GET['fd_model'] ?? '';
$fd_type = $_GET['fd_type'] ?? '';
$fd_material = $_GET['fd_material'] ?? '';
$fd_daterange = $_GET['fd_daterange'] ?? '';
$fd_shift = $_GET['fd_shift'] ?? '';
$fd_result = $_GET['fd_result'] ?? '';

// Base query construction
$sql_base = " FROM inspection_records AS I
                LEFT JOIN model_details AS T ON I.ir_model = T.modid
                LEFT JOIN model_type AS P ON I.ir_type = P.typeid
                LEFT JOIN material_header AS M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
                WHERE I.ir_status = 5 ";

if ($session_role == 4) {
    $sql_base .= " AND I.created_by = '$session_id' ";
}

if (!empty($fd_model)) {
    $model = intval($fd_model);
    $sql_base .= " AND I.ir_model = '$model' ";
}

if (!empty($fd_type)) {
    $type = intval($fd_type);
    $sql_base .= " AND I.ir_type = '$type' ";
}

if (!empty($fd_material)) {
    $material = intval($fd_material);
    $sql_base .= " AND I.ir_material = '$material' ";
}

if (!empty($fd_daterange)) {
    $dates = explode(' - ', $fd_daterange);
    if (count($dates) == 2) {
        $start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
        $end_date = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
        $sql_base .= " AND DATE(I.inspect_date) BETWEEN '$start_date' AND '$end_date' ";
    }
} 
// else {
//     $sql_base .= " AND DATE(I.inspect_date) = CURDATE() ";
// }

if (!empty($fd_shift)) {
    $shift = mysqli_real_escape_string($db_con, $fd_shift);
    $sql_base .= " AND I.ir_shift = '$shift' ";
}

if (!empty($fd_result)) {
    $result = mysqli_real_escape_string($db_con, $fd_result);
    $sql_base .= " AND I.ir_result = '$result' ";
}

$query = "SELECT I.ir_docno, M.matno, M.matdesc, T.modcode, P.typemodel, M.partside, 
                 I.inspect_date, H.shiftdesc, I.ir_pallet_no, I.ir_result, I.prod_date " . $sql_base . " ORDER BY I.inspect_date DESC, I.ir_docno DESC";

$result_set = mysqli_query($db_con, $query);

// Create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('Inspection Report List');
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(10, 15, 10);
$pdf->SetHeaderMargin(0);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->SetFont('helvetica', '', 8);
$pdf->AddPage();

$html = '
<style>
    .title { font-size: 18pt; font-weight: bold; color: #285A2A; }
    .doc-info { text-align: right; color: #555555; font-size: 9pt; line-height: 2.0; }
    table { border-collapse: collapse; width: 100%; }
    th.title { background-color: #337A36; color: #FFFFFF; font-weight: bold; text-align: left; padding: 6px; font-size: 10pt; border: 1px solid #337A36; text-transform: uppercase; letter-spacing: 0.5px; }
    th.col-header { background-color: #F8F9FA; color: #0b5122; font-weight: bold; text-align: left; padding: 6px; border-top: 1.5px solid #337A36; border-bottom: 1.5px solid #337A36; font-size: 10pt; }
    th.col-header-center { background-color: #F8F9FA; color: #0b5122; font-weight: bold; text-align: center; padding: 6px; border-top: 1.5px solid #337A36; border-bottom: 1.5px solid #337A36; font-size: 10pt; }
    td { border-bottom: 0.1px solid #E2E8F0; padding: 6px; font-size: 9pt; line-height: 2.0;}
    .text-center { text-align: center; }
    .badge-ok { color: #1B801B; font-weight: bold; }
    .badge-ng { color: #cc0000; font-weight: bold; }
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="60%">
            <span class="title">INSPECTION REPORT LIST</span><br>
            <span style="font-size: 10pt; color: #64748B; margin-top: 1.3px; margin-bottom: 1.5px;">Quality Assurance Department</span>
        </td>
        <td width="40%" class="doc-info">
            <strong style="color: #444444;">DATE:</strong> '.date('d F Y').'<br>
        </td>
    </tr>
</table>
<br><br>

<table>
    <thead>
        <tr>
            <th colspan="9" class="title"></th>
        </tr>
        <tr>
            <th class="col-header-center" width="4%">No</th>
            <th class="col-header" width="12%">Doc No</th>
            <th class="col-header" width="20%">Part No & Desc</th>
            <th class="col-header" width="16%">Model & Type</th>
            <th class="col-header-center" width="10%">Inspection Date</th>
            <th class="col-header-center" width="9%">Shift</th>
            <th class="col-header-center" width="7%">Pallet</th>
            <th class="col-header-center" width="8%">Result</th>
            <th class="col-header-center" width="14%">Prod Date</th>
        </tr>
    </thead>
    <tbody>';

if (mysqli_num_rows($result_set) > 0) {
    $counter = 1;
    while($row = mysqli_fetch_assoc($result_set)) {
        $resClass = ($row['ir_result'] == 'OK') ? 'badge-ok' : 'badge-ng';
        $pDate = ($row['prod_date'] && $row['prod_date'] != '0000-00-00') ? date('d-m-Y', strtotime($row['prod_date'])) : '-';
        
        $html .= '<tr>
            <td width="4%" class="text-center">' . $counter++ . '.' .'</td>
            <td width="12%">' . $row['ir_docno'] . '</td>
            <td width="20%">' . $row['matno'] . '<br><span style="font-size:7pt; color:#666;">' . htmlspecialchars($row['matdesc']) . '</span></td>
            <td width="16%">' . $row['modcode'] . '<br><span style="font-size:7pt; color:#666;">' . $row['typemodel'] . ' (' . $row['partside'] . ')</span></td>
            <td width="10%" class="text-center">' . date('d-m-Y', strtotime($row['inspect_date'])) . '</td>
            <td width="9%" class="text-center">' . $row['shiftdesc'] . '</td>
            <td width="7%" class="text-center">' . $row['ir_pallet_no'] . '</td>
            <td width="8%" class="text-center"><span class="' . $resClass . '">' . $row['ir_result'] . '</span></td>
            <td width="14%" class="text-center">' . $pDate . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="9" class="text-center">No records found.</td></tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('Inspection_Report_List_' . date('Ymd') . '.pdf', 'I');
exit;
