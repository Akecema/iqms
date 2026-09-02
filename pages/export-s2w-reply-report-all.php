<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

// Get filters from GET
$fd_model = $_GET['fd_model'] ?? '';
$fd_type = $_GET['fd_type'] ?? '';
$fd_material = $_GET['fd_material'] ?? '';
$fd_daterange = $_GET['fd_daterange'] ?? '';
$fd_shift = $_GET['fd_shift'] ?? '';

// Base query construction
$sql_base = " FROM inspection_s2w_report AS SR
                LEFT JOIN inspection_s2w AS S ON SR.rp_s2w_id = S.s2w_id
                LEFT JOIN inspection_records AS I ON SR.rp_s2w_ir_id = I.ir_id
                LEFT JOIN model_details AS T ON I.ir_model = T.modid
                LEFT JOIN model_type AS P ON I.ir_type = P.typeid
                LEFT JOIN material_header AS M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
                WHERE SR.rp_s2w_status = 5 ";

if ($session_role == 4) {
    $sql_base .= " AND SR.created_by = '$session_id' ";
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

$query = "SELECT SR.rp_id, SR.rp_s2w_docno, M.matno, M.matdesc, T.modcode, P.typemodel, M.partside, 
                 I.inspect_date, H.shiftdesc " . $sql_base . " ORDER BY SR.rp_s2w_docno DESC";

$result_data = mysqli_query($db_con, $query);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('S2W Reply Reports');

// Styles
$titleStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '337A36']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
];

$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => '0B5122']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F9FA']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT, 'vertical' => Alignment::VERTICAL_CENTER],
    'borders' => [
        'top' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '337A36']],
        'bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '337A36']],
    ]
];

// Title Row
$sheet->mergeCells('A1:K1');
$sheet->setCellValue('A1', ' S2W REPLY REPORT LIST');
$sheet->getStyle('A1:K1')->applyFromArray($titleStyle);
$sheet->getRowDimension(1)->setRowHeight(25);

// Header Row
$headers = ['No', 'Doc No', 'Part No', 'Part Name', 'Model', 'Type', 'Side', 'Inspect Date', 'Shift', 'Correction Photos', 'Preventive Photos'];
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '2', $header);
    $sheet->getStyle($col . '2')->applyFromArray($headerStyle);
    $col++;
}

// Data Rows
$rowNum = 3;
$counter = 1;
while ($row = mysqli_fetch_assoc($result_data)) {
    $sheet->setCellValue('A' . $rowNum, $counter++);
    $sheet->setCellValue('B' . $rowNum, $row['rp_s2w_docno']);
    $sheet->setCellValue('C' . $rowNum, $row['matno']);
    $sheet->setCellValue('D' . $rowNum, $row['matdesc']);
    $sheet->setCellValue('E' . $rowNum, $row['modcode']);
    $sheet->setCellValue('F' . $rowNum, $row['typemodel']);
    $sheet->setCellValue('G' . $rowNum, $row['partside']);
    $sheet->setCellValue('H' . $rowNum, $row['inspect_date'] ? date('d-m-Y', strtotime($row['inspect_date'])) : '-');
    $sheet->setCellValue('I' . $rowNum, $row['shiftdesc']);
    
    // Centers
    $sheet->getStyle('H' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle('I' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $rp_id = $row['rp_id'];

    // Correction Photos
    $sqlCr = "SELECT correction_photo FROM inspection_s2w_correction_photo WHERE s2w_rp_id = '$rp_id'";
    $resCr = mysqli_query($db_con, $sqlCr);
    $xOffsetCr = 5;
    while ($photo = mysqli_fetch_assoc($resCr)) {
        $photoPath = 'gallery/inspection_s2w_report/photo_correction/' . $rp_id . '/' . $photo['correction_photo'];
        if (file_exists($photoPath)) {
            $drawing = new Drawing();
            $drawing->setPath($photoPath);
            $drawing->setHeight(50);
            $drawing->setCoordinates('J' . $rowNum);
            $drawing->setOffsetX($xOffsetCr);
            $drawing->setWorksheet($sheet);
            $xOffsetCr += 60;
            $sheet->getRowDimension($rowNum)->setRowHeight(45);
        }
    }

    // Preventive Photos
    $sqlPr = "SELECT preventive_photo FROM inspection_s2w_preventive_photo WHERE s2w_rp_id = '$rp_id'";
    $resPr = mysqli_query($db_con, $sqlPr);
    $xOffsetPr = 5;
    while ($photo = mysqli_fetch_assoc($resPr)) {
        $photoPath = 'gallery/inspection_s2w_report/photo_preventive/' . $rp_id . '/' . $photo['preventive_photo'];
        if (file_exists($photoPath)) {
            $drawing = new Drawing();
            $drawing->setPath($photoPath);
            $drawing->setHeight(50);
            $drawing->setCoordinates('K' . $rowNum);
            $drawing->setOffsetX($xOffsetPr);
            $drawing->setWorksheet($sheet);
            $xOffsetPr += 60;
            $sheet->getRowDimension($rowNum)->setRowHeight(45);
        }
    }

    $rowNum++;
}

// Auto size columns (A to I)
foreach (range('A', 'I') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// Set manual width for photo columns
$sheet->getColumnDimension('J')->setWidth(40);
$sheet->getColumnDimension('K')->setWidth(40);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="S2W_Reply_Report_List_' . date('Ymd_His') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
