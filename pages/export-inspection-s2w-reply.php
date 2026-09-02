<?php
ob_start();
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

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('S2W Reply Report');

// Styles
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 14],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '337A36']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
];
$subHeaderStyle = [
    'font' => ['bold' => true],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F4F2']],
    'borders' => ['bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '337A36']]]
];

// Header
$sheet->mergeCells('A1:D1');
$sheet->setCellValue('A1', 'S2W Reply Report : ' . $ir_data['ir_docno']);
$sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

// Details
$sheet->mergeCells('A2:D2');
$sheet->setCellValue('A2', 'A. S2W Reply Details');
$sheet->getStyle('A2:D2')->applyFromArray($subHeaderStyle);

$sheet->setCellValue('A3', 'Chronology')->mergeCells('B3:D3')->setCellValue('B3', $reply['rp_s2w_cronology']);
$sheet->setCellValue('A4', 'Root Cause')->mergeCells('B4:D4')->setCellValue('B4', $reply['rp_s2w_rootcause']);
$sheet->setCellValue('A5', 'Root Cause Area')->setCellValue('B5', $reply['rp_s2w_rootcause_area']);
$sheet->setCellValue('A6', 'Root Cause Place')->setCellValue('B6', $reply['rp_s2w_rootcause_place']);
$sheet->setCellValue('A7', 'Correction')->setCellValue('B7', $reply['rp_s2w_correction']);
$sheet->setCellValue('A8', 'Preventive')->setCellValue('B8', $reply['rp_s2w_preventive']);
$sheet->setCellValue('A9', 'Conclusion')->setCellValue('B9', $reply['rp_s2w_conclusion']);

// Formatting Labels
$sheet->getStyle('A3:A9')->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F7F7EB']],
    'font' => ['bold' => true]
]);

// Allow multi-line text
$sheet->getStyle('B3:B9')->getAlignment()->setWrapText(true);

$row = 9;

// --- B & C: Photos Section ---
$photo_sections = [
    ['title' => 'B. Correction Photos', 'sql' => "SELECT correction_photo as img FROM inspection_s2w_correction_photo WHERE s2w_rp_id = '$rp_id'", 'path' => 'gallery/inspection_s2w_report/photo_correction/'],
    ['title' => 'C. Preventive Photos', 'sql' => "SELECT preventive_photo as img FROM inspection_s2w_preventive_photo WHERE s2w_rp_id = '$rp_id'", 'path' => 'gallery/inspection_s2w_report/photo_preventive/']
];

foreach ($photo_sections as $sec) {
    $res_photo = mysqli_query($db_con, $sec['sql']);
    if (mysqli_num_rows($res_photo) > 0) {
        $valid_images = [];
        while ($r = mysqli_fetch_assoc($res_photo)) {
            $fullPath = $sec['path'] . $rp_id . '/' . $r['img'];
            if (file_exists($fullPath)) {
                $valid_images[] = $fullPath;
            }
        }

        if (count($valid_images) > 0) {
            $row += 2; // Add single line space before section header
            $sheet->mergeCells("A{$row}:D{$row}");
            $sheet->setCellValue("A{$row}", $sec['title']);
            $sheet->getStyle("A{$row}:D{$row}")->applyFromArray($subHeaderStyle);
            $row++;
            
            $colIdx = 1; // A=1, B=2, C=3, D=4
            $sheet->getRowDimension($row)->setRowHeight(90);
            
            foreach ($valid_images as $imgPath) {
                if ($colIdx > 4) {
                    $colIdx = 1;
                    $row++;
                    $sheet->getRowDimension($row)->setRowHeight(90);
                }
                
                $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIdx);
                
                $drawing = new Drawing();
                $drawing->setName('Photo');
                $drawing->setDescription('Photo');
                $drawing->setPath($imgPath);
                $drawing->setCoordinates($colLetter . $row);
                $drawing->setHeight(100);
                $drawing->setOffsetX(10);
                $drawing->setOffsetY(10);
                $drawing->setWorksheet($sheet);
                
                $colIdx++;
            }
        }
    }
}

// Approval Details
$row += 2; // Add single line space
$sheet->mergeCells("A{$row}:D{$row}");
$sheet->setCellValue("A{$row}", 'D. Action Details');
$sheet->getStyle("A{$row}:D{$row}")->applyFromArray($subHeaderStyle);
$row++;

$sheet->setCellValue("A{$row}", 'Action')->setCellValue("B{$row}", 'Name')->setCellValue("C{$row}", 'Date')->setCellValue("D{$row}", 'Remark');
$sheet->getStyle("A{$row}:D{$row}")->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F7F7EB']],
    'font' => ['bold' => true]
]);
$row++;

// Helper for dates
if (!function_exists('fmtDT')) {
    function fmtDT($date) {
        return (!empty($date) && strpos($date, '0000') === false) ? date('d M Y | h:i A', strtotime($date)) : '-';
    }
}

$startApprRow = $row;
$sheet->setCellValue("A{$row}", 'Created')->setCellValue("B{$row}", $reply['created_name'])->setCellValue("C{$row}", fmtDT($reply['created_date']))->setCellValue("D{$row}", '-'); $row++;
$sheet->setCellValue("A{$row}", 'Submitted')->setCellValue("B{$row}", $reply['submitted_name'])->setCellValue("C{$row}", fmtDT($reply['submitted_date']))->setCellValue("D{$row}", '-'); $row++;
$sheet->setCellValue("A{$row}", 'Approved')->setCellValue("B{$row}", $reply['approved_name'])->setCellValue("C{$row}", fmtDT($reply['approved_date']))->setCellValue("D{$row}", $reply['approved_remark']);

$sheet->getStyle("A{$startApprRow}:A{$row}")->getFont()->setBold(true);

// Set Auto Size
foreach (range('A','D') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Align to top
$sheet->getStyle("A1:D{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

if (ob_get_length()) {
    ob_end_clean();
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="S2W_Reply_Report_'.$ir_data['ir_docno'].'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
