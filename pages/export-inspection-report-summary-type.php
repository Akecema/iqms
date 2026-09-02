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
use PhpOffice\PhpSpreadsheet\Chart\Chart;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;
use PhpOffice\PhpSpreadsheet\Chart\DataSeriesValues;
use PhpOffice\PhpSpreadsheet\Chart\Legend as ChartLegend;
use PhpOffice\PhpSpreadsheet\Chart\PlotArea;
use PhpOffice\PhpSpreadsheet\Chart\Title;

$targetFY = isset($_GET['fy']) && !empty($_GET['fy']) ? mysqli_real_escape_string($db_con, $_GET['fy']) : $financialyr;
$targetFY_desc = $financialdesc;
if (isset($_GET['fy']) && !empty($_GET['fy'])) {
    $fy_desc_query = mysqli_query($db_con, "SELECT financial_desc FROM financial_year WHERE financial_year = '$targetFY'");
    if ($fy_desc_query && mysqli_num_rows($fy_desc_query) > 0) {
        $row_fy = mysqli_fetch_assoc($fy_desc_query);
        $targetFY_desc = $row_fy['financial_desc'];
    }
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Defect Summary');

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
        'allBorders' => ['borderStyle' => Border::BORDER_THIN],
    ]
];

$totalStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '337A36']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
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


// Title & Subtitle
$sheet->setCellValue('A1', 'DEFECT SUMMARY REPORT');
$sheet->getStyle('A1')->applyFromArray($titleStyle);
$sheet->setCellValue('A2', 'FY ' . $targetFY_desc);
$sheet->getStyle('A2')->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));

// --- Table 1: Total Defects by Type ---
// $sheet->setCellValue('A3', 'Total Defect By Type');
// $sheet->getStyle('A3:C3')->applyFromArray($subHeaderStyle);

$sheet->setCellValue('A4', 'Model Type');
$sheet->setCellValue('B4', 'Total Defects');
$sheet->setCellValue('C4', 'Percentage (%)');
$sheet->getStyle('A4:C4')->applyFromArray($headerStyle);

// Summary by Type
$sql_summary = "SELECT 
                    MT.typemodel, 
                    COUNT(D.defect_id) as type_total
                FROM model_type MT
                LEFT JOIN inspection_records S ON S.ir_type = MT.typeid AND S.financial_yr = '$targetFY' AND S.ir_status = '5'
                LEFT JOIN inspection_defect D ON D.rcd_ir_id = S.ir_id
                WHERE MT.typestatus = 'Y' AND MT.compcd = '$session_comp' AND MT.plant = '$session_plant'
                GROUP BY MT.typeid, MT.typemodel
                ORDER BY type_total DESC";
$res_summary = mysqli_query($db_con, $sql_summary);

$summary_data = [];
$grandTotal = 0;
if (mysqli_num_rows($res_summary) > 0) {
    while ($row = mysqli_fetch_assoc($res_summary)) {
        $summary_data[] = $row;
        $grandTotal += (int)$row['type_total'];
    }
}

$rowNum = 5;
foreach ($summary_data as $row) {
    $count = (int)$row['type_total'];
    $percentage = ($grandTotal > 0) ? round(($count / $grandTotal) * 100) : 0;
    
    $sheet->setCellValue('A' . $rowNum, $row['typemodel']);
    $sheet->setCellValue('B' . $rowNum, $count);
    $sheet->setCellValue('C' . $rowNum, $percentage . '%');
    // $sheet->getStyle('A' . $rowNum . ':C' . $rowNum)->applyFromArray($dataStyle);
    $sheet->getStyle('B' . $rowNum . ':C' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $rowNum++;
}

// Total Row Table 1
$sheet->setCellValue('A' . $rowNum, 'Total');
$sheet->setCellValue('B' . $rowNum, $grandTotal);
$sheet->setCellValue('C' . $rowNum, '100%');
$sheet->getStyle('A' . $rowNum . ':C' . $rowNum)->applyFromArray($totalStyle);
$sheet->getStyle('B' . $rowNum . ':C' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// --- Add Donut Chart ---
// The chart will use data from the summary table above
$dataEndRow = $rowNum - 1;
if ($dataEndRow >= 5) {
    // Define a custom color palette (standard professional colors)
    $colors = ['11470F', '739C38', 'D4F357', 'EAF739', 'FFFDD0', '858796', '5a5c69'];
    
    $sheetTitle = $sheet->getTitle();
    $dataSeriesLabels = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'$sheetTitle'!\$B\$4", null, 1),
    ];
    $xAxisTickValues = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'$sheetTitle'!\$A\$5:\$A\$" . $dataEndRow, null, $dataEndRow - 4),
    ];
    $dataSeriesValues = [
        new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "'$sheetTitle'!\$B\$5:\$B\$" . $dataEndRow, null, $dataEndRow - 4, [], null, $colors),
    ];

    // Build the dataseries
    $series = new DataSeries(
        DataSeries::TYPE_DONUTCHART, // plotType
        null, // plotGrouping (Donut doesn't use this the same way)
        range(0, count($dataSeriesValues) - 1), // plotOrder
        $dataSeriesLabels, // plotLabel
        $xAxisTickValues, // plotCategory
        $dataSeriesValues // plotValues
    );

    // Set chart to display percentages as data labels
    $layout = new \PhpOffice\PhpSpreadsheet\Chart\Layout();
    $layout->setShowPercent(true);
    $layout->setShowVal(false);

    // Set the series in the plot area (v1.x uses constructor for layout)
    $plotArea = new PlotArea($layout, [$series]);
    
    // Set the chart legend
    $legend = new ChartLegend(ChartLegend::POSITION_RIGHT, null, false);
    $title = new Title('Defect Distribution : Type Breakdown');

    // Create the chart with data labels showing percent
    $chart = new Chart(
        'defectChart', // name
        $title, // title
        $legend, // legend
        $plotArea, // plotArea
        true, // plotVisibleOnly
        'gap', // displayBlanksAs
        null, // xAxisLabel
        null  // yAxisLabel
    );

    // Set the position where the chart will appear
    $chart->setTopLeftPosition('E3');
    $chart->setBottomRightPosition('L20');

    // Add the chart to the worksheet
    $sheet->addChart($chart);
}



// Auto size columns
foreach (range('A', 'C') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Defect_Summary_FY' . $targetFY . '_' . date('Ymd_His') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->setIncludeCharts(true);
$writer->save('php://output');
exit;
