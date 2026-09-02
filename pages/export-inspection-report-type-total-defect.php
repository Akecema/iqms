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

// Centralized Filter Logic for Exports
$f_fy       = isset($_GET['f_fy'])       && !empty($_GET['f_fy'])       ? mysqli_real_escape_string($db_con, $_GET['f_fy'])       : $financialyr;
$f_month    = isset($_GET['f_month'])    && !empty($_GET['f_month'])    ? intval($_GET['f_month'])    : '';
$f_quarter  = isset($_GET['f_quarter'])  && !empty($_GET['f_quarter'])  ? intval($_GET['f_quarter'])  : '';
$f_type     = isset($_GET['f_type'])     && !empty($_GET['f_type'])     ? intval($_GET['f_type'])     : '';
$f_daterange= isset($_GET['f_daterange'])&& !empty($_GET['f_daterange'])? mysqli_real_escape_string($db_con, $_GET['f_daterange']): '';
$f_shift    = isset($_GET['f_shift'])    && !empty($_GET['f_shift'])    ? mysqli_real_escape_string($db_con, $_GET['f_shift'])    : '';

$filter_sql = "";
if (!empty($f_month))     $filter_sql .= " AND MONTH(S.inspect_date) = '$f_month'";
if (!empty($f_shift))     $filter_sql .= " AND S.ir_shift = '$f_shift'";
if (!empty($f_type))      $filter_sql .= " AND S.ir_type = '$f_type'";

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

$totalStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '337A36']],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_RIGHT],
];

// Title & Subtitle
$sheet->setCellValue('A1', 'DEFECT SUMMARY REPORT');
$sheet->getStyle('A1')->applyFromArray($titleStyle);
$sheet->setCellValue('A2', 'FY ' . $targetFY_desc);
$sheet->getStyle('A2')->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));

$sheet->setCellValue('A4', 'Model Type');
$sheet->setCellValue('B4', 'Total Defects');
$sheet->setCellValue('C4', 'Percentage (%)');
$sheet->getStyle('A4:C4')->applyFromArray($headerStyle);

// Summary by Type
$sql_summary = "SELECT 
                    MT.typemodel, 
                    COUNT(D.defect_id) as type_total
                FROM model_type MT
                LEFT JOIN inspection_records S ON S.ir_type = MT.typeid AND S.financial_yr = '$targetFY' AND S.ir_status = '5' $filter_sql
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
    $sheet->getStyle('B' . $rowNum . ':C' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $rowNum++;
}

// Total Row
$sheet->setCellValue('A' . $rowNum, 'Total');
$sheet->setCellValue('B' . $rowNum, $grandTotal);
$sheet->setCellValue('C' . $rowNum, '100%');
$sheet->getStyle('A' . $rowNum . ':C' . $rowNum)->applyFromArray($totalStyle);
$sheet->getStyle('B' . $rowNum . ':C' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Donut Chart
$dataEndRow = $rowNum - 1;
if ($dataEndRow >= 5) {
    $colors = ['11470F', '739C38', 'D4F357', 'EAF739', 'FFFDD0', '858796', '5a5c69'];
    $sheetTitle = $sheet->getTitle();
    $dataSeriesLabels = [new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'$sheetTitle'!\$B\$4", null, 1)];
    $xAxisTickValues = [new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_STRING, "'$sheetTitle'!\$A\$5:\$A\$" . $dataEndRow, null, $dataEndRow - 4)];
    $dataSeriesValues = [new DataSeriesValues(DataSeriesValues::DATASERIES_TYPE_NUMBER, "'$sheetTitle'!\$B\$5:\$B\$" . $dataEndRow, null, $dataEndRow - 4, [], null, $colors)];

    $series = new DataSeries(DataSeries::TYPE_DONUTCHART, null, range(0, count($dataSeriesValues) - 1), $dataSeriesLabels, $xAxisTickValues, $dataSeriesValues);
    $layout = new \PhpOffice\PhpSpreadsheet\Chart\Layout();
    $layout->setShowPercent(true);
    $layout->setShowVal(false);
    $plotArea = new PlotArea($layout, [$series]);
    $legend = new ChartLegend(ChartLegend::POSITION_RIGHT, null, false);
    $title = new Title('Defect Distribution : Type Breakdown');
    $chart = new Chart('defectChart', $title, $legend, $plotArea, true, 'gap', null, null);
    $chart->setTopLeftPosition('E3');
    $chart->setBottomRightPosition('L20');
    $sheet->addChart($chart);
}

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
