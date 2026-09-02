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

$ir_id = isset($_GET['ir_id']) ? mysqli_real_escape_string($db_con, $_GET['ir_id']) : '';
if (empty($ir_id)) die("Missing Record ID");

// Fetch Sorting Data
$sql = "SELECT S.*, ST.statusname, 
        E1.staff_name as created_name, 
        E2.staff_name as submitted_name, 
        E3.staff_name as approved_name
        FROM inspection_sorting S
        LEFT JOIN system_status ST ON S.sr_status = ST.statusid
        LEFT JOIN employee_details E1 ON S.created_by = E1.staff_id
        LEFT JOIN employee_details E2 ON S.submitted_by = E2.staff_id
        LEFT JOIN employee_details E3 ON S.approved_by = E3.staff_id
        WHERE S.sr_ir_id = '$ir_id' AND S.sr_status != 13";
$res = mysqli_query($db_con, $sql);
$sorting = mysqli_fetch_assoc($res);
if (!$sorting) die("Sorting record not found");

$sr_id = $sorting['sr_id'];

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setTitle('Sorting Report');

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
$sheet->mergeCells('A1:F1');
$sheet->setCellValue('A1', 'Sorting Report : ' . $sorting['sr_docno']);
$sheet->getStyle('A1:F1')->applyFromArray($headerStyle);

// Summary
$sheet->mergeCells('A2:F2');
$sheet->setCellValue('A2', 'A. Summary');
$sheet->getStyle('A2:F2')->applyFromArray($subHeaderStyle);

$sheet->setCellValue('A3', 'Doc No')->setCellValue('B3', $sorting['sr_docno']);
$sheet->setCellValue('C3', 'Status')->setCellValue('D3', $sorting['statusname']);
$sheet->setCellValue('E3', 'Created By')->setCellValue('F3', $sorting['created_name']);

$sheet->setCellValue('A4', 'Qty OK')->setCellValue('B4', $sorting['sr_qty_ok']);
$sheet->setCellValue('C4', 'Qty NG')->setCellValue('D4', $sorting['sr_qty_ng']);
$sheet->setCellValue('E4', 'Total')->setCellValue('F4', $sorting['sr_qty_ok'] + $sorting['sr_qty_ng']);

// Formatting Labels (Bold)
$sheet->getStyle('A3:A4')->getFont()->setBold(true);
$sheet->getStyle('C3:C4')->getFont()->setBold(true);
$sheet->getStyle('E3:E4')->getFont()->setBold(true);

// Aligning values to left
$sheet->getStyle('B3:B4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('D4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('F4')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
// Also include D3 and F3 for consistency if they are values, or stick strictly to user request.
// User didn't ask for D3, F3. I'll stick to request.
$sheet->getStyle('D3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
$sheet->getStyle('F3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

// Sorting Details
$sheet->mergeCells('A6:F6');
$sheet->setCellValue('A6', 'B. Sorting Details');
$sheet->getStyle('A6:F6')->applyFromArray($subHeaderStyle);

$sheet->setCellValue('A7', 'Sorting Method')->mergeCells('B7:F7')->setCellValue('B7', $sorting['sr_sorting_method']);
$sheet->setCellValue('A8', 'Rework Method')->mergeCells('B8:F8')->setCellValue('B8', $sorting['sr_rework_method']);
$sheet->setCellValue('A9', 'Remarks')->mergeCells('B9:F9')->setCellValue('B9', $sorting['sr_remarks']);

// Apply background color to labels
$sheet->getStyle('A7:A9')->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F7F7EB']
    ],
    'font' => ['bold' => true]
]);

// Related Parts - In House
$sheet->mergeCells('A11:F11');
$sheet->setCellValue('A11', 'C. Related Loose Parts - In House');
$sheet->getStyle('A11:F11')->applyFromArray($subHeaderStyle);

$sheet->setCellValue('A12', 'Dept')->setCellValue('B12', 'Type')->setCellValue('C12', 'Part No')->setCellValue('D12', 'Part Name')->setCellValue('E12', 'Qty OK')->setCellValue('F12', 'Qty NG');
$sheet->getStyle('A12:F12')->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F7F7EB']],
    'font' => ['bold' => true]
]);
$row = 13;
$res_inhouse = mysqli_query($db_con, "SELECT p.*, d.rd_dept_name, t.tp_partname, m.bom, m.bomdesc 
                                       FROM inspection_sorting_related_part_dept p
                                       LEFT JOIN related_departments d ON p.srp_related_dept = d.rd_dept_id
                                       LEFT JOIN type_part t ON p.srp_type_part_dept = t.tp_partid
                                       LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
                                       WHERE p.srp_ir_id_sorting = '$sr_id'");
while ($part = mysqli_fetch_assoc($res_inhouse)) {
    $sheet->setCellValue('A'.$row, $part['rd_dept_name']);
    $sheet->setCellValue('B'.$row, $part['tp_partname']);
    $sheet->setCellValue('C'.$row, $part['bom']);
    $sheet->setCellValue('D'.$row, $part['bomdesc']);
    $sheet->setCellValue('E'.$row, $part['srp_qty_ok_dept']);
    $sheet->setCellValue('F'.$row, $part['srp_qty_ng_dept']);
    $row++;
}

// Related Parts - Vendor
$row += 2;
$sheet->mergeCells('A'.$row.':F'.$row);
$sheet->setCellValue('A'.$row, 'D. Related Loose Parts - Vendor');
$sheet->getStyle('A'.$row.':F'.$row)->applyFromArray($subHeaderStyle);
$row++;
$sheet->setCellValue('A'.$row, 'Vendor')->setCellValue('B'.$row, 'Type')->setCellValue('C'.$row, 'Part No')->setCellValue('D'.$row, 'Part Name')->setCellValue('E'.$row, 'Qty OK')->setCellValue('F'.$row, 'Qty NG');
$sheet->getStyle('A'.$row.':F'.$row)->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F7F7EB']],
    'font' => ['bold' => true]
]);
$row++;
$res_vendor = mysqli_query($db_con, "SELECT p.*, v.rv_vendor_name, t.tp_partname, m.bom, m.bomdesc 
                                      FROM inspection_sorting_related_part_vendor p
                                      LEFT JOIN related_vendors v ON p.srp_related_vdr = v.rv_vendor_id
                                      LEFT JOIN type_part t ON p.srp_type_part_vdr = t.tp_partid
                                      LEFT JOIN material_details m ON p.srp_mathdr_id_vdr = m.matdet_id
                                      WHERE p.srp_ir_id_sorting = '$sr_id'");
while ($part = mysqli_fetch_assoc($res_vendor)) {
    $sheet->setCellValue('A'.$row, $part['rv_vendor_name']);
    $sheet->setCellValue('B'.$row, $part['tp_partname']);
    $sheet->setCellValue('C'.$row, $part['bom']);
    $sheet->setCellValue('D'.$row, $part['bomdesc']);
    $sheet->setCellValue('E'.$row, $part['srp_qty_ok_vdr']);
    $sheet->setCellValue('F'.$row, $part['srp_qty_ng_vdr']);
    $row++;
}

// Related Parts - Customer
$row += 2;
$sheet->mergeCells('A'.$row.':F'.$row);
$sheet->setCellValue('A'.$row, 'E. Finished Goods Part - Customer');
$sheet->getStyle('A'.$row.':F'.$row)->applyFromArray($subHeaderStyle);
$row++;
$sheet->setCellValue('A'.$row, 'Customer')->setCellValue('B'.$row, '')->setCellValue('C'.$row, '')->setCellValue('D'.$row, '')->setCellValue('E'.$row, 'Qty OK')->setCellValue('F'.$row, 'Qty NG');
$sheet->getStyle('A'.$row.':F'.$row)->applyFromArray([
    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F7F7EB']],
    'font' => ['bold' => true]
]);
$row++;
$res_customer = mysqli_query($db_con, "SELECT p.*, c.rc_cust_name 
                                        FROM inspection_sorting_related_part_cust p
                                        LEFT JOIN related_customers c ON p.srp_related_cust = c.rc_cust_id
                                        WHERE p.srp_ir_id_sorting = '$sr_id'");
while ($part = mysqli_fetch_assoc($res_customer)) {
    $sheet->setCellValue('A'.$row, $part['rc_cust_name']);
    $sheet->setCellValue('E'.$row, $part['srp_qty_ok_cust']);
    $sheet->setCellValue('F'.$row, $part['srp_qty_ng_cust']);
    $row++;
}

// Approval Details
$row += 2;
$sheet->mergeCells('A'.$row.':F'.$row);
$sheet->setCellValue('A'.$row, 'F. Action Details');
$sheet->getStyle('A'.$row.':F'.$row)->applyFromArray($subHeaderStyle);
$row++;

$headingRow = $row;
$sheet->setCellValue('A'.$row, 'Action')->setCellValue('B'.$row, 'Name')->mergeCells('C'.$row.':D'.$row)->setCellValue('C'.$row, 'Date')->mergeCells('E'.$row.':F'.$row)->setCellValue('E'.$row, 'Remark');
$sheet->getStyle("A{$row}:F{$row}")->applyFromArray([
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => ['rgb' => 'F7F7EB']
    ],
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER]
]);
$row++;

// Created
$sheet->setCellValue('A'.$row, 'Created');
$sheet->setCellValue('B'.$row, $sorting['created_name'] ?: '-');
$sheet->mergeCells('C'.$row.':D'.$row);
$sheet->setCellValue('C'.$row, (!empty($sorting['created_date']) && strpos($sorting['created_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($sorting['created_date'])) : '-');
$sheet->mergeCells('E'.$row.':F'.$row);
$sheet->setCellValue('E'.$row, '-');
$row++;

// Submitted
$sheet->setCellValue('A'.$row, 'Submitted');
$sheet->setCellValue('B'.$row, $sorting['submitted_name'] ?: '-');
$sheet->mergeCells('C'.$row.':D'.$row);
$sheet->setCellValue('C'.$row, (!empty($sorting['submitted_date']) && strpos($sorting['submitted_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($sorting['submitted_date'])) : '-');
$sheet->mergeCells('E'.$row.':F'.$row);
$sheet->setCellValue('E'.$row, '-');
$row++;

// Reviewed (using Approved data)
$sheet->setCellValue('A'.$row, 'Reviewed');
$sheet->setCellValue('B'.$row, $sorting['approved_name'] ?: '-');
$sheet->mergeCells('C'.$row.':D'.$row);
$sheet->setCellValue('C'.$row, (!empty($sorting['approved_date']) && strpos($sorting['approved_date'], '0000') === false) ? date('d M Y | h:i A', strtotime($sorting['approved_date'])) : '-');
$sheet->mergeCells('E'.$row.':F'.$row);
$sheet->setCellValue('E'.$row, $sorting['approved_remark'] ?: '-');
$row++;

// Borders for the table
$sheet->getStyle("A{$headingRow}:F".($row-1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);
$sheet->getStyle("B{$headingRow}:F".($row-1))->getAlignment()->setWrapText(true);
$sheet->getStyle("A{$headingRow}:A".($row-1))->getFont()->setBold(true);

// Set Auto Size
foreach (range('A','F') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Sorting_Report_'.$sorting['sr_docno'].'.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
exit;
