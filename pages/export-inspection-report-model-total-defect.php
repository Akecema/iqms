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

// Centralized Filter Logic for Exports
$f_fy       = isset($_GET['f_fy'])       && !empty($_GET['f_fy'])       ? mysqli_real_escape_string($db_con, $_GET['f_fy'])       : $financialyr;
$f_month    = isset($_GET['f_month'])    && !empty($_GET['f_month'])    ? intval($_GET['f_month'])    : '';
$f_quarter  = isset($_GET['f_quarter'])  && !empty($_GET['f_quarter'])  ? intval($_GET['f_quarter'])  : '';
$f_type     = isset($_GET['f_type'])     && !empty($_GET['f_type'])     ? intval($_GET['f_type'])     : '';
$f_model    = isset($_GET['f_model'])    && !empty($_GET['f_model'])    ? intval($_GET['f_model'])    : '';
$f_daterange= isset($_GET['f_daterange'])&& !empty($_GET['f_daterange'])? mysqli_real_escape_string($db_con, $_GET['f_daterange']): '';
$f_shift    = isset($_GET['f_shift'])    && !empty($_GET['f_shift'])    ? mysqli_real_escape_string($db_con, $_GET['f_shift'])    : '';

$filter_sql = "";
if (!empty($f_month))     $filter_sql .= " AND MONTH(S.inspect_date) = '$f_month'";
if (!empty($f_shift))     $filter_sql .= " AND S.ir_shift = '$f_shift'";
if (!empty($f_type))      $filter_sql .= " AND S.ir_type = '$f_type'";
if (!empty($f_model))     $filter_sql .= " AND S.ir_model = '$f_model'";

if (!empty($f_daterange)) {
    $dates = explode(' - ', $f_daterange);
    if (count($dates) == 2) {
        $f_start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
        $f_end_date   = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
        $filter_sql  .= " AND DATE(S.inspect_date) BETWEEN '$f_start_date' AND '$f_end_date'";
    }
}

if (!empty($f_quarter)) {
    $qtr_row_sql = "SELECT month_start, month_end FROM financial_quarter WHERE quarter_id = '$f_quarter' LIMIT 1";
    $qtr_row_res = mysqli_query($db_con, $qtr_row_sql);
    if ($qtr_row_res && $qtr_row = mysqli_fetch_assoc($qtr_row_res)) {
        $qm_start = (int)$qtr_row['month_start'];
        $qm_end   = (int)$qtr_row['month_end'];
        if ($qm_start && $qm_end) {
            $filter_sql .= " AND MONTH(S.inspect_date) BETWEEN '$qm_start' AND '$qm_end'";
        }
    }
}

$targetFY = $f_fy;
$targetFY_desc = $financialdesc;
$fy_desc_query = mysqli_query($db_con, "SELECT financial_desc FROM financial_year WHERE financial_year = '$targetFY'");
if ($fy_desc_query && mysqli_num_rows($fy_desc_query) > 0) {
    $row_fy = mysqli_fetch_assoc($fy_desc_query);
    $targetFY_desc = $row_fy['financial_desc'];
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Defect Summary');

// --- Style Definitions ---

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

$rowStyleEven = [
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFFFF']],
];

$rowStyleOdd = [
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F2F4F2']], // Very light green tint
];

$totalStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '337A36']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
];

// --- Layout Construction ---

// Title & Subtitle
$sheet->setCellValue('A1', 'DEFECTS BY MODEL');
$sheet->getStyle('A1')->applyFromArray($titleStyle);
$sheet->setCellValue('A2', 'FY ' . $targetFY_desc);
$sheet->getStyle('A2')->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));

// Header Row
$headers = ['Type', 'Model', 'Total Inspection', 'Defects Quantity'];
$columns = ['A', 'B', 'C', 'D'];
foreach ($columns as $index => $col) {
    $sheet->setCellValue($col . '4', $headers[$index]);
    $sheet->getStyle($col . '4')->applyFromArray($headerStyle);
    $sheet->getRowDimension('4')->setRowHeight(25);
}

$rowNum = 5;

$sql_defect_model = "SELECT 
                        MT.typemodel AS type_name,
                        MD.modcode AS model_name,
                        COUNT(D.defect_id) AS total_qty,
                        (SELECT COUNT(ir_id) FROM inspection_records S WHERE ir_type = MT.typeid AND ir_model = MD.modid AND financial_yr = '$targetFY' AND ir_status = '5' $filter_sql) AS total_inspection
                     FROM model_type MT
                     JOIN model_details MD ON 1=1
                     LEFT JOIN inspection_records S ON S.ir_type = MT.typeid 
                                        AND S.ir_model = MD.modid 
                                        AND S.financial_yr = '$targetFY' 
                                        AND S.ir_status = '5' $filter_sql
                     LEFT JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id AND S.ir_result = 'NG'
                     WHERE MT.typestatus = 'Y' AND MT.compcd = '$session_comp' AND MT.plant = '$session_plant'
                       AND MD.modstatus = 'Y' AND MD.compcd = '$session_comp' AND MD.plant = '$session_plant'
                     GROUP BY MT.typeid, MD.modid
                     HAVING total_inspection > 0
                     ORDER BY MT.typemodel ASC, total_qty DESC";
$res_defect_model = mysqli_query($db_con, $sql_defect_model);

$data_rows = [];
$group_counts = [];
$grand_total_qty = 0;
$grand_total_inspection = 0;
while ($row = mysqli_fetch_assoc($res_defect_model)) {
    $data_rows[] = $row;
    $group_counts[$row['type_name']] = ($group_counts[$row['type_name']] ?? 0) + 1;
    $grand_total_qty += (int)$row['total_qty'];
    $grand_total_inspection += (int)$row['total_inspection'];
}

if (!empty($data_rows)) {
    $current_type = '';
    
    // Style for the Type grouping column
    $typeColumnStyle = [
        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F9FA']],
        'font' => ['bold' => true, 'color' => ['rgb' => '337A36']],
        'alignment' => [
            'vertical' => Alignment::VERTICAL_CENTER,
            'horizontal' => Alignment::HORIZONTAL_LEFT
        ],
        'borders' => [
            'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'DDDDDD']],
        ]
    ];

    foreach ($data_rows as $index => $row) {
        $isEven = ($index % 2 == 0);
        $currentStyle = $isEven ? $rowStyleEven : $rowStyleOdd;
        
        // Apply Zebra Striping to Model, Inspection and Qty columns
        $sheet->getStyle('B' . $rowNum . ':D' . $rowNum)->applyFromArray($currentStyle);
        $sheet->getStyle('B' . $rowNum . ':D' . $rowNum)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->getColor()->setRGB('DDDDDD');
        $sheet->getRowDimension($rowNum)->setRowHeight(22);

        // Grouping Type (Merge cells and apply specific Type style)
        if ($current_type !== $row['type_name']) {
            $rowspan = $group_counts[$row['type_name']];
            $rangeA = 'A' . $rowNum . ':A' . ($rowNum + $rowspan - 1);
            if ($rowspan > 1) {
                $sheet->mergeCells($rangeA);
            }
            $sheet->setCellValue('A' . $rowNum, $row['type_name']);
            $sheet->getStyle($rangeA)->applyFromArray($typeColumnStyle);
            $current_type = $row['type_name'];
        }

        $sheet->setCellValue('B' . $rowNum, $row['model_name']);
        $sheet->setCellValue('C' . $rowNum, $row['total_inspection']);
        $sheet->setCellValue('D' . $rowNum, $row['total_qty']);
        
        // Number Formatting
        $sheet->getStyle('C' . $rowNum . ':D' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
        $sheet->getStyle('C' . $rowNum . ':D' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_RIGHT);
        
        $rowNum++;
    }
    
    // Grand Total Row
    $sheet->mergeCells('A' . $rowNum . ':B' . $rowNum);
    $sheet->setCellValue('A' . $rowNum, 'GRAND TOTAL    ');
    $sheet->setCellValue('C' . $rowNum, $grand_total_inspection);
    $sheet->setCellValue('D' . $rowNum, $grand_total_qty);
    $sheet->getStyle('A' . $rowNum . ':D' . $rowNum)->applyFromArray($totalStyle);
    $sheet->getStyle('C' . $rowNum . ':D' . $rowNum)->getNumberFormat()->setFormatCode('#,##0');
    $sheet->getRowDimension($rowNum)->setRowHeight(28);
}

// Auto-size and Fine-tuning
foreach (range('A', 'D') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

// Add a little extra width manually for breathing room
$sheet->getColumnDimension('C')->setWidth(20);
$sheet->getColumnDimension('D')->setWidth(20);

// --- Add Stacked Bar Chart ---
if (!empty($data_rows)) {
    // Generate Matrix Data for Chart
    $types = [];
    $models = [];
    $matrix = [];
    foreach ($data_rows as $row) {
        if (!in_array($row['type_name'], $types)) $types[] = $row['type_name'];
        if (!in_array($row['model_name'], $models)) $models[] = $row['model_name'];
        $matrix[$row['type_name']][$row['model_name']] = (int)$row['total_qty'];
    }
    
    // Create a hidden sheet for the matrix data
    $dataSheet = $spreadsheet->createSheet();
    $dataSheet->setTitle('ChartSource');
    $dataSheet->setSheetState(\PhpOffice\PhpSpreadsheet\Worksheet\Worksheet::SHEETSTATE_HIDDEN);
    
    // Write Matrix to ChartSource
    $dataSheet->setCellValue('A1', 'Model Type');
    $col = 'B';
    foreach ($models as $m) {
        $dataSheet->setCellValue($col . '1', $m);
        $col++;
    }
    
    // Fill Rows
    $r = 2;
    foreach ($types as $t) {
        $dataSheet->setCellValue('A' . $r, $t);
        $c = 'B';
        foreach ($models as $m) {
            $val = $matrix[$t][$m] ?? 0;
            $dataSheet->setCellValue($c . $r, $val);
            $c++;
        }
        $r++;
    }
    
    $lastRow = count($types) + 1;
    
    $xAxisTickValues = [
        new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
            \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING, 
            "'ChartSource'!\$A\$2:\$A\$" . $lastRow, null, count($types)
        ),
    ];
    
    $dataSeriesLabels = [];
    $dataSeriesValues = [];
    $greenPalette = ['11470F', '739C38', 'D4F357'];

    foreach ($models as $idx => $m) {
        $colAlpha = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($idx + 2);
        
        $dataSeriesLabels[] = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
            \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_STRING, 
            "'ChartSource'!\$" . $colAlpha . "\$1", null, 1
        );

        $valSource = new \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues(
            \PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues::DATASERIES_TYPE_NUMBER, 
            "'ChartSource'!\$" . $colAlpha . "\$2:\$" . $colAlpha . "\$" . $lastRow, null, count($types)
        );

        // Apply Green Palette
        $seriesColor = $greenPalette[$idx % count($greenPalette)];
        $valSource->setFillColor(array_fill(0, count($types), $seriesColor));
        
        $dataSeriesValues[] = $valSource;
    }
    
    // Create the Data Series as CLUSTERED (Grouped)
    $series = new \PhpOffice\PhpSpreadsheet\Chart\DataSeries(
        \PhpOffice\PhpSpreadsheet\Chart\DataSeries::TYPE_BARCHART,
        \PhpOffice\PhpSpreadsheet\Chart\DataSeries::GROUPING_CLUSTERED, // Grouped side-by-side
        range(0, count($dataSeriesValues) - 1),
        $dataSeriesLabels,
        $xAxisTickValues,
        $dataSeriesValues,
        null,
        null,
        \PhpOffice\PhpSpreadsheet\Chart\DataSeries::DIRECTION_COL // Vertical as per requested design
    );

    $layout = new \PhpOffice\PhpSpreadsheet\Chart\Layout();
    $plotArea = new \PhpOffice\PhpSpreadsheet\Chart\PlotArea($layout, [$series]);
    $legend = new \PhpOffice\PhpSpreadsheet\Chart\Legend(\PhpOffice\PhpSpreadsheet\Chart\Legend::POSITION_BOTTOM, null, false);
    $title = new \PhpOffice\PhpSpreadsheet\Chart\Title('Defect Distribution by Model');

    $chart = new \PhpOffice\PhpSpreadsheet\Chart\Chart(
        'defectChart',
        $title,
        $legend,
        $plotArea,
        true,
        'gap',
        null,
        null
    );
    
    $chart->setTopLeftPosition('G3');
    $chart->setBottomRightPosition('O25');
    
    $sheet->addChart($chart);
}

// Clear any existing output buffers
if (ob_get_length()) ob_end_clean();

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Defect_Summary_Model_FY' . $targetFY . '_' . date('Ymd_His') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->setIncludeCharts(true);
$writer->save('php://output');
exit;
