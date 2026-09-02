<?php
session_start();
require '../db/db_connect.php';
include 'session-login.php';
include 'get-financial-year.php';
require '../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// Centralized Filter Logic for Exports
$f_fy       = isset($_GET['f_fy'])       && !empty($_GET['f_fy'])       ? mysqli_real_escape_string($db_con, $_GET['f_fy'])       : $financialyr;
$f_month    = isset($_GET['f_month'])    && !empty($_GET['f_month'])    ? intval($_GET['f_month'])    : '';
$f_quarter  = isset($_GET['f_quarter'])  && !empty($_GET['f_quarter'])  ? intval($_GET['f_quarter'])  : '';
$f_type     = isset($_GET['f_type'])     && !empty($_GET['f_type'])     ? intval($_GET['f_type'])     : '';
$f_model    = isset($_GET['f_model'])    && !empty($_GET['f_model'])    ? intval($_GET['f_model'])    : '';
$f_daterange= isset($_GET['f_daterange'])&& !empty($_GET['f_daterange'])? mysqli_real_escape_string($db_con, $_GET['f_daterange']): '';
$f_shift    = isset($_GET['f_shift'])    && !empty($_GET['f_shift'])    ? mysqli_real_escape_string($db_con, $_GET['f_shift'])    : '';

$filter_sql = "";
if (!empty($f_month))     $filter_sql .= " AND MONTH(IR.inspect_date) = '$f_month'";
if (!empty($f_shift))     $filter_sql .= " AND IR.ir_shift = '$f_shift'";
if (!empty($f_type))      $filter_sql .= " AND IR.ir_type = '$f_type'";
if (!empty($f_model))     $filter_sql .= " AND IR.ir_model = '$f_model'";

if (!empty($f_daterange)) {
    $dates = explode(' - ', $f_daterange);
    if (count($dates) == 2) {
        $f_start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
        $f_end_date   = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
        $filter_sql  .= " AND DATE(IR.inspect_date) BETWEEN '$f_start_date' AND '$f_end_date'";
    }
}

if (!empty($f_quarter)) {
    $qtr_row_sql = "SELECT month_start, month_end FROM financial_quarter WHERE quarter_id = '$f_quarter' LIMIT 1";
    $qtr_row_res = mysqli_query($db_con, $qtr_row_sql);
    if ($qtr_row_res && $qtr_row = mysqli_fetch_assoc($qtr_row_res)) {
        $qm_start = (int)$qtr_row['month_start'];
        $qm_end   = (int)$qtr_row['month_end'];
        if ($qm_start && $qm_end) {
            $filter_sql .= " AND MONTH(IR.inspect_date) BETWEEN '$qm_start' AND '$qm_end'";
        }
    }
}

$targetFY = $f_fy;
$searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($db_con, $_GET['search']) : '';

$query_fy_desc = "SELECT financial_desc FROM financial_year WHERE financial_year = '$targetFY'";
$res_fy_desc = mysqli_query($db_con, $query_fy_desc);
if ($row_fy_desc = mysqli_fetch_assoc($res_fy_desc)) {
    $targetFY_desc = $row_fy_desc['financial_desc'];
} else {
    $targetFY_desc = $financialdesc;
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Defect By Model Analysis');

// Styles
$titleStyle = [
    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1A1A1A']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
];

$headerStyle = [
    'font' => ['bold' => true, 'size' => 10, 'color' => ['rgb' => '337A36']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F9FA']],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER
    ],
    'borders' => [
        'bottom' => ['borderStyle' => Border::BORDER_THICK, 'color' => ['rgb' => '337A36']],
    ]
];

$dataStyle = [
    'borders' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'E0E0E0']],
    ]
];

$totalStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '337A36']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
];

// Title
$sheet->setCellValue('A1', 'DEFECT BY MODEL ANALYSIS REPORT');
$sheet->getStyle('A1')->applyFromArray($titleStyle);
$sheet->setCellValue('A2', 'FY ' . $targetFY_desc);
$sheet->getStyle('A2')->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));

// 1. Get Column Headers (Model Details)
$sql_md = "SELECT modid, modcode FROM model_details 
          WHERE modstatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant' 
          ORDER BY modcode ASC";
$res_md = mysqli_query($db_con, $sql_md);
$models = [];
while($row = mysqli_fetch_assoc($res_md)) $models[] = $row;

// 2. Get Row Headers (Defect Types)
$sql_dt = "SELECT defectid, defectname FROM defect_type WHERE defectstatus = 'Y'";
if (!empty($searchQuery)) {
    $sql_dt .= " AND defectname LIKE '%$searchQuery%'";
}
$sql_dt .= " ORDER BY defectname ASC";
$res_dt = mysqli_query($db_con, $sql_dt);
$defect_categories = [];
while($row = mysqli_fetch_assoc($res_dt)) $defect_categories[] = $row;

// 3. Get Data
$sql_data = "SELECT 
                ID.defect_type, 
                IR.ir_model as model_id, 
                COUNT(ID.defect_id) as qty
             FROM inspection_records IR
             JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
             WHERE IR.financial_yr = '$targetFY' 
               AND IR.ir_result = 'NG' AND IR.ir_status = '5' $filter_sql
             GROUP BY ID.defect_type, IR.ir_model";
$res_data = mysqli_query($db_con, $sql_data);
$matrix = [];
while($row = mysqli_fetch_assoc($res_data)){
    $matrix[$row['defect_type']][$row['model_id']] = $row['qty'];
}

$unfiltered_grand_total = 0;
foreach($matrix as $def_id => $m_data) {
    foreach($m_data as $qty) $unfiltered_grand_total += $qty;
}

$footer_grand_total = 0;
$footer_percent = 0;

// Write Table Headers
$sheet->setCellValue('A4', 'Defect Type');
$colIndex = 2; // B
foreach ($models as $m) {
    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
    $sheet->setCellValue($colLetter . '4', $m['modcode']);
    $colIndex++;
}
$colLetterTotal = Coordinate::stringFromColumnIndex($colIndex);
$sheet->setCellValue($colLetterTotal . '4', 'Total');

$colLetterPercent = Coordinate::stringFromColumnIndex($colIndex + 1);
$sheet->setCellValue($colLetterPercent . '4', 'Percentage (%)');

$endColLetter = $colLetterPercent;
$sheet->getStyle('A4:' . $endColLetter . '4')->applyFromArray($headerStyle);
$sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// Write Data
$rowNum = 5;
$col_totals = array_fill_keys(array_column($models, 'modid'), 0);

foreach ($defect_categories as $dt) {
    $row_id = $dt['defectid'];
    $row_sum = 0;
    
    $sheet->setCellValue('A' . $rowNum, $dt['defectname']);
    $sheet->getStyle('A' . $rowNum)->getFont()->setBold(true);
    
    $colIndex = 2;
    foreach ($models as $m) {
        $m_id = $m['modid'];
        $qty = $matrix[$row_id][$m_id] ?? 0;
        $row_sum += $qty;
        $col_totals[$m_id] += $qty;
        
        $colLetter = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue($colLetter . $rowNum, $qty > 0 ? $qty : '-');
        $sheet->getStyle($colLetter . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $colIndex++;
    }
    
    $sheet->setCellValue($colLetterTotal . $rowNum, $row_sum);
    $sheet->getStyle($colLetterTotal . $rowNum)->getFont()->setBold(true);
    $sheet->getStyle($colLetterTotal . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    $footer_grand_total += $row_sum;
    $percentage = $unfiltered_grand_total > 0 ? round(($row_sum / $unfiltered_grand_total) * 100) : 0;
    $footer_percent += $percentage;
    $sheet->setCellValue($colLetterPercent . $rowNum, $percentage . '%');
    $sheet->getStyle($colLetterPercent . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    $rowNum++;
}

// Write Totals row
$sheet->setCellValue('A' . $rowNum, 'Total');
$colIndex = 2;
foreach ($models as $m) {
    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
    $sheet->setCellValue($colLetter . $rowNum, $col_totals[$m['modid']]);
    $colIndex++;
}
$sheet->setCellValue($colLetterTotal . $rowNum, $footer_grand_total);
$sheet->setCellValue($colLetterPercent . $rowNum, $footer_percent . '%');

$sheet->getStyle('A' . $rowNum . ':' . $endColLetter . $rowNum)->applyFromArray($totalStyle);
$sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// Apply borders
$sheet->getStyle('A4:' . $endColLetter . $rowNum)->applyFromArray($dataStyle);

// Auto sizing columns
for ($i = 1; $i <= Coordinate::columnIndexFromString($endColLetter); $i++) {
    $col = Coordinate::stringFromColumnIndex($i);
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Download
$filename = "Defect_By_Model_Analysis_FY" . $targetFY . "_" . date('Ymd_His') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
