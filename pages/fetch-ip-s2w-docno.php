<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include '../shift.php';

$irid = $_POST['irid'] ?? '';

$sql = "SELECT I.ir_docno, T.sr_docno, P.s2w_docno, P.s2w_docnocancel, P.s2w_status
        FROM inspection_records AS I
        LEFT JOIN inspection_sorting AS T ON I.ir_id = T.sr_ir_id
        LEFT JOIN inspection_s2w AS P ON I.ir_id = P.s2w_ir_id
        WHERE I.ir_id = ?";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("s", $irid);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


$docno_html = '
    <div class="tree">

        <div class="tree-item">
            <span class="tree-bullet bullet-green"></span>
            <span class="fw-semibold ip-section">Inspection</span><br>
            <small><a href="javascript:void(0);" data-docno="'.$row['ir_docno'].'" class="viewDocInspection red-link">'.$row['ir_docno'].'</a></small>
        </div>

        <div class="tree-item">
            <span class="tree-bullet bullet-orange"></span>
            <span class="fw-semibold ip-section">Sorting</span><br>
            <small><a href="javascript:void(0);" data-docno="'.$row['sr_docno'].'" class="viewDocSorting red-link">'.$row['sr_docno'].'</a></small>
        </div>

        <div class="tree-item">
            <span class="tree-bullet bullet-red"></span>
            <span class="fw-semibold ip-section">Something Went Wrong (S2W)</span><br>
            <small>'.$row['s2w_docno'].'</small>
        </div>';

if ((int)$row['s2w_status'] == 8) {

$docno_html .= '
    <div class="tree-item">
        <span class="tree-bullet bullet-purple"></span>
        <span class="fw-semibold ip-section">S2W Cancellation</span><br>
        <small>'.$row['s2w_docnocancel'].'</small>
    </div>';
}

$docno_html .= '
</div>';

echo $docno_html;