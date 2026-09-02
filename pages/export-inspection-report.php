<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';

require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// --- 1. Database Fetching (Keep your existing logic) ---
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

// --- 2. Initialize Spreadsheet ---
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Inspection Report');

// Define Styles
$headerStyle = [
    'font' => [
        'bold' => true, 
        'color' => ['rgb' => 'FFFFFF'], // White text
        'size' => 14
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => '337A36'] // Your Theme Green
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ]
];

// Define the Secondary Section Header
$subHeaderStyle = [
    'font' => [
        'bold' => true,
        'color' => ['rgb' => '2C3E50'] // Dark Slate
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F2F4F2'] // Pale Green-Grey
    ],
    'borders' => [
        'bottom' => ['borderStyle' => Border::BORDER_MEDIUM, 'color' => ['rgb' => '337A36']]
    ]
];

// $headerStyle = [
//     'font' => ['bold' => true, 'size' => 14],
//     'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F2F2']],
//     'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
//     'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
// ];

// $subHeaderStyle = [
//     'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
//     'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '337A36']],
//     'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]]
// ];

// --- 3. Build Header Section ---
$sheet->mergeCells('A1:F1');
$sheet->setCellValue('A1', 'Inspection Report : ' . $data['ir_docno']);
$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

// Section A: General Info
$sheet->mergeCells('A2:F2');
$sheet->setCellValue('A2', 'A. General Information');
$sheet->getStyle('A2:F2')->applyFromArray($subHeaderStyle);

$sheet->setCellValue('A3', 'Document No')->setCellValue('B3', $data['ir_docno']);
$sheet->setCellValue('C3', 'Result')->setCellValue('D3', $data['ir_result']);
$sheet->setCellValue('E3', 'Inspection Date')->setCellValue('F3', date('d-m-Y', strtotime($data['inspect_date'])));

// Align B3 to left
$sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

$sheet->setCellValue('A4', 'Shift')->setCellValue('B4', $data['shiftdesc']);
$sheet->setCellValue('C4', 'Pallet Sequence')->setCellValue('D4', $data['ir_pallet_no']);
$sheet->setCellValue('E4', 'Production Date')->setCellValue('F4', date('d-m-Y', strtotime($data['prod_date'])));

// Align B4 and D4 to left
$sheet->getStyle('B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// Applying color to Result
$resultColor = ($data['ir_result'] == 'OK') ? '008000' : 'FF0000';
$sheet->getStyle('D3')->getFont()->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color($resultColor))->setBold(true);

// --- 4. Section B: Goods Details ---
$sheet->mergeCells('A7:F7');
$sheet->setCellValue('A7', 'B. Finished Goods Details');
$sheet->getStyle('A7:F7')->applyFromArray($subHeaderStyle);

$sheet->setCellValue('A8', 'Part No')->mergeCells('B8:C8')->setCellValue('B8', $data['matno']);
$sheet->setCellValue('D8', 'Model')->mergeCells('E8:F8')->setCellValue('E8', $data['modcode'] . " (" . $data['partside'] . ")");

$sheet->setCellValue('A9', 'Part Name')->mergeCells('B9:C9')->setCellValue('B9', $data['matdesc']);
$sheet->setCellValue('D9', 'Type')->mergeCells('E9:F9')->setCellValue('E9', $data['typemodel']);

// --- 5. Section C: Defects & Images ---
if ($data['ir_result'] !== 'OK') {
    $sheet->mergeCells('A11:F11');
    $sheet->setCellValue('A11', 'C. Defect Details');
    $sheet->getStyle('A11:F11')->applyFromArray($subHeaderStyle);

    $sheet->setCellValue('A12', 'No')
          ->setCellValue('B12', 'Type')
          ->setCellValue('C12', 'Area')
          ->setCellValue('D12', 'Defect Photo')
          ->mergeCells('D12:E12')
          ->setCellValue('F12', 'Comparison Photo');

    // Apply background color to labels
    $sheet->getStyle('A12:F12')->applyFromArray([
        'fill' => [
            'fillType' => Fill::FILL_SOLID,
            'startColor' => ['rgb' => 'F7F7EB']
        ],
        'font' => ['bold' => true]
    ]);


    // Set column widths
    $sheet->getColumnDimension('A')->setWidth(5);
    $sheet->getColumnDimension('B')->setWidth(25);
    $sheet->getColumnDimension('C')->setWidth(20);
    $sheet->getColumnDimension('D')->setWidth(15);
    $sheet->getColumnDimension('E')->setWidth(15);
    $sheet->getColumnDimension('F')->setWidth(40);

    $currentRow = 13;
    $def_sql = "SELECT d.defect_id, t.defectname, d.defect_area FROM inspection_defect d 
                LEFT JOIN defect_type t ON d.defect_type = t.defectid WHERE d.rcd_ir_id = '$ir_id'";
    $def_res = mysqli_query($db_con, $def_sql);

    $index = 1;
    while ($def_row = mysqli_fetch_assoc($def_res)) {
        $sheet->setCellValue('A' . $currentRow, $index++);
        $sheet->setCellValue('B' . $currentRow, $def_row['defectname']);
        $sheet->setCellValue('C' . $currentRow, $def_row['defect_area']);
        
        // Set row height to accommodate images
        $sheet->getRowDimension($currentRow)->setRowHeight(110);
        $sheet->mergeCells('D' . $currentRow . ':E' . $currentRow);
        
        // Apply borders to the row
        $sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray([
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
            'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
        ]);

        // Handle Defect Photos (Multiple)
        $p_sql = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = '{$def_row['defect_id']}'";
        $p_res = mysqli_query($db_con, $p_sql);
        $def_offsetX = 5;
        
        while ($p_row = mysqli_fetch_assoc($p_res)) {
            $imgPath = 'gallery/inspection/defect/' . $ir_id . '/' . $p_row['defect_photo'];
            if (file_exists($imgPath)) {
                $drawing = new Drawing();
                $drawing->setPath($imgPath);
                $drawing->setHeight(100);
                $drawing->setCoordinates('D' . $currentRow);
                $drawing->setOffsetX($def_offsetX);
                $drawing->setOffsetY(5);
                $drawing->setWorksheet($sheet);
                $def_offsetX += 120; // Adjust offset for next photo
            }
        }

        // Handle Comparison Photos (Multiple)
        $c_sql = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = '{$def_row['defect_id']}'";
        $c_res = mysqli_query($db_con, $c_sql);
        $comp_offsetX = 5;
        while ($c_row = mysqli_fetch_assoc($c_res)) {
            $imgPath = 'gallery/inspection/defect_compare/' . $ir_id . '/' . $c_row['compare_photo'];
            if (file_exists($imgPath)) {
                $drawing = new Drawing();
                $drawing->setPath($imgPath);
                $drawing->setHeight(100);
                $drawing->setCoordinates('F' . $currentRow);
                $drawing->setOffsetX($comp_offsetX);
                $drawing->setOffsetY(5);
                $drawing->setWorksheet($sheet);
                $comp_offsetX += 120; // Adjust offset for next photo
            }
        }

        $currentRow++;
    }
    $currentRow++; // Gap between Section C and Section D
} else {
    $currentRow = 10;
}

// --- 6. Section D: Approval ---
$sheet->mergeCells('A' . $currentRow . ':F' . $currentRow);
$sheet->setCellValue('A' . $currentRow, 'D. Action Details');
$sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->applyFromArray($subHeaderStyle);
$startActionRow = $currentRow; // Track for bordering
$currentRow++;

// Sub Header
$sheet->setCellValue('A' . $currentRow, 'Action')->mergeCells('A' . $currentRow . ':B' . $currentRow);
$sheet->setCellValue('C' . $currentRow, 'Name');
$sheet->setCellValue('D' . $currentRow, 'Date')->mergeCells('D' . $currentRow . ':E' . $currentRow);
$sheet->setCellValue('F' . $currentRow, 'Remarks');
$sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getFont()->setBold(true);
$sheet->getStyle('A' . $currentRow . ':F' . $currentRow)->getFill()
    ->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('F7F7EB'); // Same pale green
$currentRow++;

// Created Info
$sheet->setCellValue('A' . $currentRow, 'Created')->mergeCells('A' . $currentRow . ':B' . $currentRow);
$sheet->setCellValue('C' . $currentRow, $data['created_by_name']);
$sheet->setCellValue('D' . $currentRow, $data['created_date'] != '0000-00-00 00:00:00' ? date('d-m-Y H:i A', strtotime($data['created_date'])) : '-')->mergeCells('D' . $currentRow . ':E' . $currentRow);
$sheet->setCellValue('F' . $currentRow, '');
$currentRow++;

// Submitted Info
$sheet->setCellValue('A' . $currentRow, 'Submitted')->mergeCells('A' . $currentRow . ':B' . $currentRow);
$sheet->setCellValue('C' . $currentRow, $data['submitted_by_name']);
$sheet->setCellValue('D' . $currentRow, $data['submitted_date'] != '0000-00-00 00:00:00' ? date('d-m-Y H:i A', strtotime($data['submitted_date'])) : '-')->mergeCells('D' . $currentRow . ':E' . $currentRow);
$sheet->setCellValue('F' . $currentRow, '');
$currentRow++;

// Reviewed Info
$sheet->setCellValue('A' . $currentRow, 'Reviewed')->mergeCells('A' . $currentRow . ':B' . $currentRow);
$sheet->setCellValue('C' . $currentRow, $data['reviewed_by_name']);
$sheet->setCellValue('D' . $currentRow, $data['reviewed_date'] != '0000-00-00 00:00:00' ? date('d-m-Y H:i A', strtotime($data['reviewed_date'])) : '-')->mergeCells('D' . $currentRow . ':E' . $currentRow);
$sheet->setCellValue('F' . $currentRow, $data['reviewed_remark']);
$sheet->getStyle('F' . $currentRow)->getAlignment()->setWrapText(true);
$currentRow++;

// Apply consistent styling to Activity Section
$sheet->getStyle('A' . $startActionRow . ':F' . ($currentRow - 1))->applyFromArray([
    'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
    'alignment' => ['vertical' => Alignment::VERTICAL_CENTER]
]);

// --- 6. Export ---
$filename = "Inspection_Report_" . $data['ir_docno'] . ".xlsx";

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;