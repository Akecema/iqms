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
        WHERE S.s2w_ir_id = '$ir_id' AND S.s2w_status = 5";
$res = mysqli_query($db_con, $sql);
$s2w = mysqli_fetch_assoc($res);
if (!$s2w) die("S2W record not found");

$s2w_id = $s2w['s2w_id'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('S2W Report');

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
$sheet->setCellValue('A1', 'S2W Report : ' . $s2w['s2w_docno']);
$sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

// Details
$sheet->mergeCells('A2:D2');
$sheet->setCellValue('A2', 'A. S2W Details');
$sheet->getStyle('A2:D2')->applyFromArray($subHeaderStyle);

$sheet->setCellValue('A3', 'Inspection Doc No')->setCellValue('B3', $ir_data['ir_docno']);
$sheet->setCellValue('C3', 'Status')->setCellValue('D3', $s2w['statusname']);
$sheet->setCellValue('A4', 'Sending To')->mergeCells('B4:D4')->setCellValue('B4', $s2w['rd_dept_name']);
$sheet->setCellValue('A5', 'Additional Info')->mergeCells('B5:D5')->setCellValue('B5', $s2w['s2w_additional_desc']);

// Formatting Labels
$sheet->getStyle('A3:A5')->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F7F7EB']],
    'font' => ['bold' => true]
]);
$sheet->getStyle('C3')->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F7F7EB']],
    'font' => ['bold' => true]
]);

// Allow multi-line text for remark
$sheet->getStyle('B5')->getAlignment()->setWrapText(true);

$row = 5;

// --- B & C: Photos Section ---
$photo_sections = [
    ['title' => 'B. Photos NG (Defect)', 'sql' => "SELECT defect_photo as img FROM inspection_s2w_defect_photo WHERE s2w_id = '$s2w_id'", 'path' => 'gallery/inspection_s2w/photo_defect/'],
    ['title' => 'C. Photo OK', 'sql' => "SELECT ok_photo as img FROM inspection_s2w_ok_photo WHERE s2w_id = '$s2w_id'", 'path' => 'gallery/inspection_s2w/photo_ok/']
];

foreach ($photo_sections as $sec) {
    $res_photo = mysqli_query($db_con, $sec['sql']);
    if (mysqli_num_rows($res_photo) > 0) {
        $valid_images = [];
        while ($r = mysqli_fetch_assoc($res_photo)) {
            $fullPath = $sec['path'] . $s2w_id . '/' . $r['img'];
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
$sheet->setCellValue("A{$row}", 'Created')->setCellValue("B{$row}", $s2w['created_name'])->setCellValue("C{$row}", fmtDT($s2w['created_date']))->setCellValue("D{$row}", '-'); $row++;
$sheet->setCellValue("A{$row}", 'Submitted')->setCellValue("B{$row}", $s2w['submitted_name'])->setCellValue("C{$row}", fmtDT($s2w['submitted_date']))->setCellValue("D{$row}", '-'); $row++;
$sheet->setCellValue("A{$row}", 'Reviewed')->setCellValue("B{$row}", $s2w['reviewed_name'])->setCellValue("C{$row}", fmtDT($s2w['reviewed_date']))->setCellValue("D{$row}", $s2w['reviewed_remark']); $row++;
$sheet->setCellValue("A{$row}", 'Approved')->setCellValue("B{$row}", $s2w['approved_name'])->setCellValue("C{$row}", fmtDT($s2w['approved_date']))->setCellValue("D{$row}", $s2w['approved_remark']);

$sheet->getStyle("A{$startApprRow}:A{$row}")->getFont()->setBold(true);

// Set Auto Size
foreach (range('A','D') as $col) {
    if ($col == 'B' && strlen($s2w['s2w_additional_desc']) > 60) {
        $sheet->getColumnDimension($col)->setWidth(45);
    } else {
        $sheet->getColumnDimension($col)->setAutoSize(true);
    }
}

// Align to top
$sheet->getStyle("A1:D{$row}")->getAlignment()->setVertical(Alignment::VERTICAL_TOP);

if (ob_get_length()) {
    ob_end_clean();
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="S2W_Report_'.$s2w['s2w_docno'].'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
