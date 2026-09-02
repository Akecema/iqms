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

$query = "SELECT I.ir_id, I.ir_docno, M.matno, M.matdesc, T.modcode, P.typemodel, M.partside, 
                 I.inspect_date, H.shiftdesc, I.ir_pallet_no, I.ir_result, I.prod_date " . $sql_base . " ORDER BY I.inspect_date DESC, I.ir_docno DESC";

$result_data = mysqli_query($db_con, $query);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Inspection Reports');

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

$centerStyle = ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]];

// Title Row
$sheet->mergeCells('A1:P1');
$sheet->setCellValue('A1', ' INSPECTION REPORT LIST');
$sheet->getStyle('A1:P1')->applyFromArray($titleStyle);
$sheet->getRowDimension(1)->setRowHeight(25);

// Header Row
$headers = ['No', 'Doc No', 'Part No', 'Part Name', 'Model', 'Type', 'Side', 'Inspect Date', 'Shift', 'Pallet Seq', 'Result', 'Prod Date', 'Defect', 'Defect Area', 'Defect Photos', 'Comparison Photos'];
$col = 'A';
foreach ($headers as $header) {
    $sheet->setCellValue($col . '2', $header);
    $sheet->getStyle($col . '2')->applyFromArray($headerStyle);
    if (in_array($header, ['Inspect Date', 'Shift', 'Pallet Seq', 'Result', 'Prod Date'])) {
        $sheet->getStyle($col . '2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    }
    $col++;
}

// Data Rows
$rowNum = 3;
$counter = 1;
while ($row = mysqli_fetch_assoc($result_data)) {
    $ir_id = $row['ir_id'];
    
    // Check if result is NG to fetch defects
    if ($row['ir_result'] == 'NG') {
        $sqlDefect = "SELECT D.defect_id, D.defect_area, T.defectname
                    FROM inspection_defect D
                    LEFT JOIN defect_type T ON D.defect_type = T.defectid
                    WHERE D.rcd_ir_id = '$ir_id'";
        $resDefect = mysqli_query($db_con, $sqlDefect);
        
        if (mysqli_num_rows($resDefect) > 0) {
            $startRow = $rowNum;
            while ($defect = mysqli_fetch_assoc($resDefect)) {
                $sheet->setCellValue('A' . $rowNum, $counter);
                $sheet->setCellValue('B' . $rowNum, $row['ir_docno']);
                $sheet->setCellValue('C' . $rowNum, $row['matno']);
                $sheet->setCellValue('D' . $rowNum, $row['matdesc']);
                $sheet->setCellValue('E' . $rowNum, $row['modcode']);
                $sheet->setCellValue('F' . $rowNum, $row['typemodel']);
                $sheet->setCellValue('G' . $rowNum, $row['partside']);
                $sheet->setCellValue('H' . $rowNum, date('d-m-Y', strtotime($row['inspect_date'])));
                $sheet->setCellValue('I' . $rowNum, $row['shiftdesc']);
                $sheet->setCellValue('J' . $rowNum, $row['ir_pallet_no']);
                $sheet->setCellValue('K' . $rowNum, $row['ir_result']);
                $sheet->setCellValue('L' . $rowNum, ($row['prod_date'] && $row['prod_date'] != '0000-00-00') ? date('d-m-Y', strtotime($row['prod_date'])) : '-');
                
                // Styling for NG result
                $sheet->getStyle('K' . $rowNum)->getFont()->getColor()->setRGB('FF0000');
                $sheet->getStyle('K' . $rowNum)->getFont()->setBold(true);

                // Defect Details
                $sheet->setCellValue('M' . $rowNum, $defect['defectname']);
                $sheet->setCellValue('N' . $rowNum, $defect['defect_area']);

                $defectId = $defect['defect_id'];
                
                // Defect Photos
                $sqlPhoto = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = '$ir_id' AND rcd_defect_id = '$defectId'";
                $resPhoto = mysqli_query($db_con, $sqlPhoto);
                $xOffset = 5;
                while ($photo = mysqli_fetch_assoc($resPhoto)) {
                    $photoPath = 'gallery/inspection/defect/' . $ir_id . '/' . $photo['defect_photo'];
                    if (file_exists($photoPath)) {
                        $drawing = new Drawing();
                        $drawing->setPath($photoPath);
                        $drawing->setHeight(50);
                        $drawing->setCoordinates('O' . $rowNum);
                        $drawing->setOffsetX($xOffset);
                        $drawing->setWorksheet($sheet);
                        $xOffset += 60;
                        $sheet->getRowDimension($rowNum)->setRowHeight(45);
                    }
                }

                // Comparison Photos
                $sqlCompare = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = '$ir_id' AND rcd_defect_id = '$defectId'";
                $resCompare = mysqli_query($db_con, $sqlCompare);
                $xOffsetComp = 5;
                while ($compare = mysqli_fetch_assoc($resCompare)) {
                    $comparePath = 'gallery/inspection/defect_compare/' . $ir_id . '/' . $compare['compare_photo'];
                    if (file_exists($comparePath)) {
                        $drawingComp = new Drawing();
                        $drawingComp->setPath($comparePath);
                        $drawingComp->setHeight(50);
                        $drawingComp->setCoordinates('P' . $rowNum);
                        $drawingComp->setOffsetX($xOffsetComp);
                        $drawingComp->setWorksheet($sheet);
                        $xOffsetComp += 60;
                        $sheet->getRowDimension($rowNum)->setRowHeight(45);
                    }
                }

                $rowNum++;
            }
            $counter++;
        } else {
            // Result is NG but no defects in table? (Shouldn't happen)
            $sheet->setCellValue('A' . $rowNum, $counter);
            $sheet->setCellValue('B' . $rowNum, $row['ir_docno']);
            $sheet->setCellValue('C' . $rowNum, $row['matno']);
            $sheet->setCellValue('D' . $rowNum, $row['matdesc']);
            $sheet->setCellValue('E' . $rowNum, $row['modcode']);
            $sheet->setCellValue('F' . $rowNum, $row['typemodel']);
            $sheet->setCellValue('G' . $rowNum, $row['partside']);
            $sheet->setCellValue('H' . $rowNum, date('d-m-Y', strtotime($row['inspect_date'])));
            $sheet->setCellValue('I' . $rowNum, $row['shiftdesc']);
            $sheet->setCellValue('J' . $rowNum, $row['ir_pallet_no']);
            $sheet->setCellValue('K' . $rowNum, $row['ir_result']);
            $sheet->setCellValue('L' . $rowNum, ($row['prod_date'] && $row['prod_date'] != '0000-00-00') ? date('d-m-Y', strtotime($row['prod_date'])) : '-');
            $sheet->getStyle('K' . $rowNum)->getFont()->getColor()->setRGB('FF0000');
            $rowNum++;
            $counter++;
        }
    } else {
        // OK Result
        $sheet->setCellValue('A' . $rowNum, $counter);
        $sheet->setCellValue('B' . $rowNum, $row['ir_docno']);
        $sheet->setCellValue('C' . $rowNum, $row['matno']);
        $sheet->setCellValue('D' . $rowNum, $row['matdesc']);
        $sheet->setCellValue('E' . $rowNum, $row['modcode']);
        $sheet->setCellValue('F' . $rowNum, $row['typemodel']);
        $sheet->setCellValue('G' . $rowNum, $row['partside']);
        $sheet->setCellValue('H' . $rowNum, date('d-m-Y', strtotime($row['inspect_date'])));
        $sheet->setCellValue('I' . $rowNum, $row['shiftdesc']);
        $sheet->setCellValue('J' . $rowNum, $row['ir_pallet_no']);
        $sheet->setCellValue('K' . $rowNum, $row['ir_result']);
        $sheet->setCellValue('L' . $rowNum, ($row['prod_date'] && $row['prod_date'] != '0000-00-00') ? date('d-m-Y', strtotime($row['prod_date'])) : '-');
        
        $rowNum++;
        $counter++;
    }
}

// Auto size columns (A to N)
foreach (range('A', 'N') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}
// Set manual width for photo columns
$sheet->getColumnDimension('O')->setWidth(40);
$sheet->getColumnDimension('P')->setWidth(40);

// Redirect output to a client’s web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Inspection_Report_List_' . date('Ymd_His') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;

