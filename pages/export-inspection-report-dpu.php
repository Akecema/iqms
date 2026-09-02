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

$fy = isset($_GET['fy']) && !empty($_GET['fy']) ? mysqli_real_escape_string($db_con, $_GET['fy']) : date('Y');

$fy_desc_query = mysqli_query($db_con, "SELECT financial_desc FROM financial_year WHERE financial_year = '$fy'");
$targetFY_desc = $fy;
if ($fy_desc_query && mysqli_num_rows($fy_desc_query) > 0) {
    $row_fy = mysqli_fetch_assoc($fy_desc_query);
    $targetFY_desc = $row_fy['financial_desc'];
}

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('DPU Report');

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

// Title & Subtitle
$sheet->setCellValue('A1', 'DPU REPORT');
$sheet->getStyle('A1')->applyFromArray($titleStyle);
$sheet->setCellValue('A2', 'FY ' . $targetFY_desc);
$sheet->getStyle('A2')->getFont()->setItalic(true)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('666666'));

$headers = ['No', 'Model', 'Feb', 'Mac', 'April', 'May', 'June', 'July', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec', 'Jan'];
$col = 'A';
foreach ($headers as $h) {
    $sheet->setCellValue($col . '4', $h);
    $col++;
}
$sheet->getStyle('A4:N4')->applyFromArray($headerStyle);

// Get Data
$sql_models = "SELECT b.modid, b.modcode FROM model_details b WHERE b.compcd = '$session_comp' and b.plant = '$session_plant' and b.modstatus = 'Y' ORDER BY b.modid ASC";
$sql_vol = "SELECT * FROM dpu_volume WHERE financial_year = '$fy'";
$res_vol = $db_con->query($sql_vol);
$vols = [];
if ($res_vol) {
    while($v = $res_vol->fetch_assoc()) {
        $vols[$v['model_id']] = $v;
    }
}

$sql_def = "SELECT inspection_records.ir_model, MONTH(inspection_records.shift_date) as mth, SUM(inspection_sorting.sr_qty_ng) as tot
            FROM inspection_sorting 
            JOIN inspection_records ON inspection_records.ir_id = inspection_sorting.sr_ir_id 
            WHERE inspection_records.financial_yr = '$fy'
            GROUP BY inspection_records.ir_model, MONTH(inspection_records.shift_date)";
$res_def = $db_con->query($sql_def);
$defs = [];
if ($res_def) {
    while($d = $res_def->fetch_assoc()) {
        $defs[$d['ir_model']][$d['mth']] = floatval($d['tot']);
    }
}

$m_map = [
    'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
    'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
    'december' => 12, 'jan' => 1
];

$res_models = $db_con->query($sql_models);
$rowNum = 5;
$no = 1;
if ($res_models) {
    while ($row = $res_models->fetch_assoc()) {
        $mid = $row['modid'];
        
        $sheet->setCellValue('A' . $rowNum, $no++);
        $sheet->setCellValue('B' . $rowNum, $row['modcode']);
        $sheet->getStyle('A' . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $col = 'C';
        foreach ($m_map as $col_name => $mth_num) {
            $vol = isset($vols[$mid][$col_name]) ? floatval($vols[$mid][$col_name]) : 0;
            $def = isset($defs[$mid][$mth_num]) ? floatval($defs[$mid][$mth_num]) : 0;

            if ($vol > 0) {
                $dpu = number_format(($def / $vol), 4);
                $sheet->setCellValue($col . $rowNum, $dpu);
            } else {
                $sheet->setCellValue($col . $rowNum, '-');
            }
            $sheet->getStyle($col . $rowNum)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $col++;
        }
        $rowNum++;
    }
}

foreach (range('A', 'N') as $columnID) {
    $sheet->getColumnDimension($columnID)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="DPU_Report_FY' . $targetFY_desc . '_' . date('Ymd_His') . '.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
?>
