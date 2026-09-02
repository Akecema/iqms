<?php
session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';

if ($_POST['action'] == 'get_pdi_inspection') {
    $ir_id = isset($_POST['ir_id']) ? mysqli_real_escape_string($db_con, $_POST['ir_id']) : '';

    if (empty($ir_id)) {
        echo json_encode(['status' => 'error', 'message' => 'Missing ID']);
        exit;
    }

    $sql = "SELECT I.ir_docno, I.inspect_date, I.prod_date, I.ir_pallet_no, H.shiftdesc, I.ir_result, I.ir_docno,
                   I.created_date, I.submitted_date, I.reviewed_date, I.reviewed_remark,
                   E1.staff_name AS created_by_name, 
                   E2.staff_name AS submitted_by_name, 
                   E3.staff_name AS reviewed_by_name
            FROM inspection_records AS I
            LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
            LEFT JOIN employee_details AS E1 ON I.created_by = E1.staff_id
            LEFT JOIN employee_details AS E2 ON I.submitted_by = E2.staff_id
            LEFT JOIN employee_details AS E3 ON I.reviewed_by = E3.staff_id
            WHERE I.ir_id = '$ir_id'";

    $result = mysqli_query($db_con, $sql);
    
    if ($result && mysqli_num_rows($result) > 0) {
        $data = mysqli_fetch_assoc($result);
        
        // Format dates
        $data['inspect_date'] = date('d-m-Y', strtotime($data['inspect_date']));
        $data['prod_date'] = date('d-m-Y', strtotime($data['prod_date']));

        $defects = [];
        if ($data['ir_result'] == 'NG') {
            $def_sql = "SELECT d.defect_id, t.defectname, d.defect_area
                        FROM inspection_defect d
                        LEFT JOIN defect_type t ON d.defect_type = t.defectid
                        WHERE d.rcd_ir_id = '$ir_id'";
            $def_res = mysqli_query($db_con, $def_sql);
            
            while ($def_row = mysqli_fetch_assoc($def_res)) {
                $defect_id = $def_row['defect_id'];
                
                // Get defect photos
                $photos = [];
                $photo_sql = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = '$defect_id'";
                $photo_res = mysqli_query($db_con, $photo_sql);
                while ($p_row = mysqli_fetch_assoc($photo_res)) {
                    $photos[] = 'gallery/inspection/defect/' . $ir_id . '/' . $p_row['defect_photo'];
                }
                $def_row['defect_photos'] = $photos;

                // Get comparison photos
                $compare_photos = [];
                $comp_sql = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = '$defect_id'";
                $comp_res = mysqli_query($db_con, $comp_sql);
                while ($c_row = mysqli_fetch_assoc($comp_res)) {
                    $compare_photos[] = 'gallery/inspection/defect_compare/' . $ir_id . '/' . $c_row['compare_photo'];
                }
                $def_row['compare_photos'] = $compare_photos;

                $defects[] = $def_row;
            }
        }
        $data['defects'] = $defects;
        
        echo json_encode(['status' => 'success', 'data' => $data]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found']);
    }
}
exit;
