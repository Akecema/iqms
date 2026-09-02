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
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

$targetFY = isset($_GET['fy']) && !empty($_GET['fy']) ? mysqli_real_escape_string($db_con, $_GET['fy']) : $financialyr;
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
$sheet->setTitle('Monthly Type Analysis');

// Styles
$titleStyle = [
    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1A1A1A']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
];

$headerStyle = [
    'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '337A36']],
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
$sheet->setCellValue('A1', 'MONTHLY TYPE ANALYSIS REPORT');
$sheet->getStyle('A1')->applyFromArray($titleStyle);
$sheet->setCellValue('A2', 'FY ' . $targetFY_desc);
$sheet->getStyle('A2')->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));

// Columns: Months
$months = [
    2 => 'Feb',
    3 => 'Mac',
    4 => 'April',
    5 => 'May',
    6 => 'June',
    7 => 'July',
    8 => 'Aug',
    9 => 'Sept',
    10 => 'Oct',
    11 => 'Nov',
    12 => 'Dec',
    1 => 'Jan'
];

// Row Headers: Model Types
$sql_mt = "SELECT typeid, typemodel FROM model_type 
          WHERE typestatus = 'Y' AND compcd = '$session_comp' AND plant = '$session_plant'";
if (!empty($searchQuery)) {
    $sql_mt .= " AND typemodel LIKE '%$searchQuery%'";
}
$sql_mt .= " ORDER BY typemodel ASC";
$res_mt = mysqli_query($db_con, $sql_mt);
$model_types = [];
while($row = mysqli_fetch_assoc($res_mt)) $model_types[] = $row;

// Get Data
$sql_data = "SELECT 
                IR.ir_type as model_type_id, 
                MONTH(IR.shift_date) as month_num,
                COUNT(ID.defect_id) as qty
             FROM inspection_records IR
             JOIN inspection_defect ID ON ID.rcd_ir_id = IR.ir_id
             WHERE IR.financial_yr = '$targetFY' 
               AND IR.ir_result = 'NG' AND IR.ir_status = '5'
             GROUP BY IR.ir_type, MONTH(IR.shift_date)";
$res_data = mysqli_query($db_con, $sql_data);
$matrix = [];
while($row = mysqli_fetch_assoc($res_data)){
    $matrix[$row['model_type_id']][$row['month_num']] = $row['qty'];
}

$footer_grand_total = 0;

// Write Table Headers
$sheet->setCellValue('A4', 'Type');
$colIndex = 2; // B
foreach ($months as $num => $name) {
    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
    $sheet->setCellValue($colLetter . '4', $name);
    $colIndex++;
}
$colLetterTotal = Coordinate::stringFromColumnIndex($colIndex);
$sheet->setCellValue($colLetterTotal . '4', 'Total');

$endColLetter = $colLetterTotal;
$sheet->getStyle('A4:' . $endColLetter . '4')->applyFromArray($headerStyle);
$sheet->getStyle('A4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// Write Data
$rowNum = 5;
$col_totals = array_fill_keys(array_keys($months), 0);

foreach ($model_types as $mt) {
    $type_id = $mt['typeid'];
    $row_sum = 0;
    
    $sheet->setCellValue('A' . $rowNum, $mt['typemodel']);
    $sheet->getStyle('A' . $rowNum)->getFont()->setBold(true);
    
    $colIndex = 2;
    foreach ($months as $num => $name) {
        $qty = $matrix[$type_id][$num] ?? 0;
        $row_sum += $qty;
        $col_totals[$num] += $qty;
        
        $colLetter = Coordinate::stringFromColumnIndex($colIndex);
        $sheet->setCellValue($colLetter . $rowNum, $qty > 0 ? $qty : '-');
        $sheet->getStyle($colLetter . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $colIndex++;
    }
    
    $sheet->setCellValue($colLetterTotal . $rowNum, $row_sum);
    $sheet->getStyle($colLetterTotal . $rowNum)->getFont()->setBold(true);
    $sheet->getStyle($colLetterTotal . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    
    $footer_grand_total += $row_sum;
    $rowNum++;
}

// Write Totals row
$sheet->setCellValue('A' . $rowNum, 'Total');
$colIndex = 2;
foreach ($months as $num => $name) {
    $colLetter = Coordinate::stringFromColumnIndex($colIndex);
    $sheet->setCellValue($colLetter . $rowNum, $col_totals[$num]);
    $colIndex++;
}
$sheet->setCellValue($colLetterTotal . $rowNum, $footer_grand_total);

$sheet->getStyle('A' . $rowNum . ':' . $endColLetter . $rowNum)->applyFromArray($totalStyle);
$sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// Apply borders
$sheet->getStyle('A4:' . $endColLetter . $rowNum)->applyFromArray($dataStyle);

// Auto sizing columns
for ($i = 1; $i <= Coordinate::columnIndexFromString($endColLetter); $i++) {
    $col = Coordinate::stringFromColumnIndex($i);
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Chart generation
if ($rowNum > 5) {
    $wsName = "'" . str_replace("'", "''", $sheet->getTitle()) . "'!";
    
    $endColChart = Coordinate::stringFromColumnIndex(count($months) + 1); // 12 months -> M
    $xAxisTickValues = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, $wsName . '$B$4:$' . $endColChart . '$4', null, count($months)),
    ];
    
    $dataSeriesLabels = [];
    $dataSeriesValues = [];
    
    for ($r = 5; $r < $rowNum; $r++) {
        $dataSeriesLabels[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, $wsName . '$A$' . $r, null, 1);
        $dataSeriesValues[] = new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, $wsName . '$B$' . $r . ':$' . $endColChart . '$' . $r, null, count($months));
    }
    
    $series = new DataSeries(
        DataSeries::TYPE_BARCHART,       // plotType
        DataSeries::GROUPING_CLUSTERED,  // plotGrouping
        range(0, count($dataSeriesValues) - 1), // plotOrder
        $dataSeriesLabels,               // plotLabel
        $xAxisTickValues,                // plotCategory
        $dataSeriesValues                // plotValues
    );
    
    $series->setPlotDirection(DataSeries::DIRECTION_COL);
    
    $plotArea = new PlotArea(null, [$series]);
    $legend = new Legend(Legend::POSITION_RIGHT, null, false);
    $title = new Title('Monthly Defect Trend');
    
    $chart = new Chart(
        'chart_trend', // name
        $title,        // title
        $legend,       // legend
        $plotArea,     // plotArea
        true,          // plotVisibleOnly
        0,             // displayBlanksAs
        null,          // xAxisLabel
        null           // yAxisLabel
    );
    
    $chart->setTopLeftPosition('A' . ($rowNum + 2));
    $chart->setBottomRightPosition($endColLetter . ($rowNum + 20));
    
    $sheet->addChart($chart);
}

// Download
$filename = "Monthly_Type_Analysis_FY" . $targetFY . "_" . date('Ymd_His') . ".xlsx";
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'. $filename .'"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->setIncludeCharts(true);
$writer->save('php://output');
exit;
