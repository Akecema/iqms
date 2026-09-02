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

// Base query construction
$sql_base = " FROM inspection_s2w AS S
                LEFT JOIN inspection_records AS I ON S.s2w_ir_id = I.ir_id
                LEFT JOIN model_details AS T ON I.ir_model = T.modid
                LEFT JOIN model_type AS P ON I.ir_type = P.typeid
                LEFT JOIN material_header AS M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
                LEFT JOIN related_departments AS R ON S.s2w_send_to = R.rd_dept_id
                WHERE S.s2w_status = 5 ";

if ($session_role == 4) {
    $sql_base .= " AND S.created_by = '$session_id' ";
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

if (!empty($fd_shift)) {
    $shift = mysqli_real_escape_string($db_con, $fd_shift);
    $sql_base .= " AND I.ir_shift = '$shift' ";
}

$query = "SELECT S.s2w_id, S.s2w_docno, M.matno, M.matdesc, T.modcode, P.typemodel, M.partside, 
                 I.inspect_date, H.shiftdesc, R.rd_dept_name " . $sql_base . " ORDER BY S.s2w_docno DESC";

$result_set = mysqli_query($db_con, $query);

// Create new PDF document
$pdf = new TCPDF('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('iQims');
$pdf->SetTitle('S2W Report List');
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
</style>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
    <tr>
        <td width="60%">
            <span class="title">S2W REPORT LIST</span><br>
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
            <th colspan="7" class="title"></th>
        </tr>
        <tr>
            <th class="col-header-center" width="3%">No</th>
            <th class="col-header" width="12%">Doc No</th>
            <th class="col-header" width="22%">Part Details</th>
            <th class="col-header" width="10%">Model</th>
            <th class="col-header" width="15%">Sending To</th>
            <th class="col-header-center" width="19%">Photos NG (Defect)</th>
            <th class="col-header-center" width="19%">Photos OK</th>
        </tr>
    </thead>
    <tbody>';

if (mysqli_num_rows($result_set) > 0) {
    $counter = 1;
    while($row = mysqli_fetch_assoc($result_set)) {
        $s2w_id = $row['s2w_id'];
        
        // Before Photo
        $ngHtml = '';
        $sqlNg = "SELECT defect_photo FROM inspection_s2w_defect_photo WHERE s2w_id = '$s2w_id'";
        $resNg = mysqli_query($db_con, $sqlNg);
        while ($photo = mysqli_fetch_assoc($resNg)) {
            $pathNg = 'gallery/inspection_s2w/photo_defect/' . $s2w_id . '/' . $photo['defect_photo'];
            if (file_exists($pathNg)) {
                $ngHtml .= '<img src="' . $pathNg . '" width="30" height="30"> ';
            }
        }
        $ngImg = (!empty($ngHtml)) ? $ngHtml : '-';

        // After Photo
        $okHtml = '';
        $sqlOk = "SELECT ok_photo FROM inspection_s2w_ok_photo WHERE s2w_id = '$s2w_id'";
        $resOk = mysqli_query($db_con, $sqlOk);
        while ($photo = mysqli_fetch_assoc($resOk)) {
            $pathOk = 'gallery/inspection_s2w/photo_ok/' . $s2w_id . '/' . $photo['ok_photo'];
            if (file_exists($pathOk)) {
                $okHtml .= '<img src="' . $pathOk . '" width="30" height="30"> ';
            }
        }
        $okImg = (!empty($okHtml)) ? $okHtml : '-';

        $html .= '<tr>
            <td width="3%" class="text-center">' . $counter++ . '.</td>
            <td width="12%">' . $row['s2w_docno'] . '</td>
            <td width="22%">' . $row['matno'] . '<br><span style="font-size:7pt; color:#666;">' . htmlspecialchars($row['matdesc']) . '</span></td>
            <td width="10%">' . $row['modcode'] . '<br><span style="font-size:7pt; color:#666;">' . $row['typemodel'] . ' (' . $row['partside'] . ')</span></td>
            <td width="15%">' . $row['rd_dept_name'] . '</td>
            <td width="19%" class="text-center">' . $ngImg . '</td>
            <td width="19%" class="text-center">' . $okImg . '</td>
        </tr>';
    }
} else {
    $html .= '<tr><td colspan="7" class="text-center">No records found.</td></tr>';
}

$html .= '</tbody></table>';

$pdf->writeHTML($html, true, false, true, false, '');
$pdf->Output('S2W_Report_List_' . date('Ymd') . '.pdf', 'I');
exit;
