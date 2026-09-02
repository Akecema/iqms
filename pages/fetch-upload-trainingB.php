<?php
include '../db/db_connect.php';
include '../timezone.php';
include 'financial-year.php';
include 'training-manhours.php';

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

$pst_datenow  = date('Y-m-d H:i:s');
$pst_date = date('d-m-Y');
$created_by  = $_SESSION['staff_id'] ?? 'SYSTEM';
$section     = 3;

// ================= VALIDATE FILE =================
if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
    die('NO_FILE');
}

$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
if ($ext !== 'csv') {
    die('INVALID_FILE');
}

// ================= OPEN CSV =================
$file = fopen($_FILES['file']['tmp_name'], 'r');
if (!$file) {
    die('FILE_OPEN_FAILED');
}

$file_name = $_FILES['file']['name'];
$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
$file_type = $_FILES['file']['type'];
$file_size = $_FILES['file']['size'];
$file_tmpname = $_FILES["file"]["tmp_name"];   

// skip header
fgetcsv($file);

//Add upload file
$rinsert = "INSERT INTO training_upload(filename, new_filename, filetype, filesize, user_upload, date_upload) 
                VALUES ( ?, ?, ?, ?, ?, ?)";
$rinsert = $db_con->prepare($rinsert);
$rinsert->bind_param("ssssss", $file_name, $file_name, $file_type, $file_size, $_SESSION["username"], $pst_datenow);  
$rinsert->execute();     

$istId = $db_con->insert_id;

$create_file_name = 'Training Score_'.$pst_date.'_'.$_SESSION["username"].'_'.$istId;
$new_file_name = $create_file_name.'.'.$file_ext;

$UpdRcd = "UPDATE training_upload SET new_filename = ? WHERE upload_fileid = ?";
$updateTbl = $db_con->prepare($UpdRcd);
$updateTbl->bind_param("ss", $new_file_name, $istId);
$updateTbl->execute();

$targetPath = '../uploads/Training/'.$new_file_name;
move_uploaded_file($file_tmpname, $targetPath);

$errors = [];
$failed_rows = []; // Store failed rows with reasons
$period_cache = []; // Cache period data per company
$row_number = 1; // Track row number (starting from 1 for first data row after header)

while (($row = fgetcsv($file)) !== false) {

    $row_number++; // Increment for each row
    $staff_id        = trim($row[0]);
    $company         = trim($row[1]);
    $actual_manhours = (int) $row[2];

    if (!$staff_id || !$company) {
        $error_msg = "Invalid row: Missing staff_id or company";
        $errors[] = "Row $row_number: $error_msg";
        $failed_rows[] = [
            'row_number' => $row_number,
            'data' => $row,
            'reason' => $error_msg
        ];
        continue;
    }

    // Check if we already fetched period data for this company
    if (!isset($period_cache[$company])) {
        
        // SET TRAINING PERIOD
        $sect_training = '3';
        $periodacc = 'AC';
        $periodsta = 'Open';

        $query_gt_rcd = "SELECT division_id FROM company WHERE company_code = ? ";
        $get_gt_rcd = $db_mast_con->prepare($query_gt_rcd); 
        $get_gt_rcd->bind_param("s", $company);
        $get_gt_rcd->execute();
        $rst_rcd_period = $get_gt_rcd->get_result(); 
        $row_rcd_period = $rst_rcd_period->fetch_array();

        $divs = $row_rcd_period['division_id'] ?? null;

        if (empty($divs)) {
            $error_msg = "Company $company not found or has no division";
            $errors[] = "Row $row_number ($staff_id): $error_msg";
            $failed_rows[] = [
                'row_number' => $row_number,
                'data' => $row,
                'reason' => $error_msg
            ];
            $period_cache[$company] = null; // Cache the failure
            continue;
        }

        $query_prd = "SELECT * FROM period_training  as T
                                LEFT JOIN period_header AS P ON P.period_id = T.period_id
                                    WHERE P.appraisal_section_id = ? and P.period_accstatus = ? and P.period_status = ?
                                        and T.division_id = ? and T.training_accstatus = ? and T.training_periodstatus = ? ";
        $get_prd = $db_con->prepare($query_prd); 
        $get_prd->bind_param("ississ", $sect_training, $periodacc, $periodsta, $divs, $periodacc, $periodsta);
        $get_prd->execute();

        $rst_prd = $get_prd->get_result(); 
        $row_prd = $rst_prd->fetch_array(); 

        $period_id  = $row_prd['period_id'] ?? null;
        $prd_training_id = $row_prd['prd_training_id'] ?? null;
        $fyr = $row_prd['financial_year'] ?? null;

        // If period data not found for this company, skip records for this company
        if (empty($period_id) || empty($prd_training_id) || empty($fyr)) {
            $error_msg = "Training period not found for company $company";
            $errors[] = "Row $row_number ($staff_id): $error_msg";
            $failed_rows[] = [
                'row_number' => $row_number,
                'data' => $row,
                'reason' => $error_msg
            ];
            $period_cache[$company] = null; // Cache the failure
            continue;
        }

        // Cache the period data for this company
        $period_cache[$company] = [
            'period_id' => $period_id,
            'prd_training_id' => $prd_training_id,
            'fyr' => $fyr
        ];
    } else {
        // Use cached period data
        if ($period_cache[$company] === null) {
            // This company has no period data, skip
            $error_msg = "Training period not found for company $company";
            $errors[] = "Row $row_number ($staff_id): $error_msg";
            $failed_rows[] = [
                'row_number' => $row_number,
                'data' => $row,
                'reason' => $error_msg
            ];
            continue;
        }
        
        $period_id = $period_cache[$company]['period_id'];
        $prd_training_id = $period_cache[$company]['prd_training_id'];
        $fyr = $period_cache[$company]['fyr'];
    }

    // ================= APA TRACKING CHECK =================
    $query_finftrack = "SELECT status_apa FROM apa_tracking WHERE staff_id = ?";
    $get_finftrack = $db_con->prepare($query_finftrack);
    $get_finftrack->bind_param("s", $staff_id);
    $get_finftrack->execute();

    $rst_finftrack = $get_finftrack->get_result();
    $row_finftrack = $rst_finftrack->fetch_assoc();

    // If no APA record → default to 1 (NEW) and proceed
    $status_apa = $row_finftrack['status_apa'] ?? 1;

    // Only allow update for New (1) or Draft (2)
    if (!in_array($status_apa, [1, 2])) {
        $error_msg = "APA already submitted/appraised (status: $status_apa)";
        $errors[] = "Row $row_number ($staff_id): $error_msg";
        $failed_rows[] = [
            'row_number' => $row_number,
            'data' => $row,
            'reason' => $error_msg
        ];
        continue;
    }

    //find section id for training
    $query_apaform = "SELECT appraisal_form FROM employee_details WHERE staff_id = ? ";
    $get_apaform = $db_con->prepare($query_apaform); 
    $get_apaform->bind_param("s", $staff_id);
    $get_apaform->execute();

    $rst_apaform = $get_apaform->get_result(); 
    $row_apaform = $rst_apaform->fetch_array(); 

    $rcd_sform_id = $row_apaform['appraisal_form'] ?? null;

    // If appraisal form not found, skip this record only
    if (empty($rcd_sform_id)) {
        $error_msg = "Appraisal form not found in employee details";
        $errors[] = "Row $row_number ($staff_id): $error_msg";
        $failed_rows[] = [
            'row_number' => $row_number,
            'data' => $row,
            'reason' => $error_msg
        ];
        continue;
    }

    $tbl_name = '';
        
    switch ($rcd_sform_id) {
        case '7':
            $tbl_name = "apa_form7_section";
            break;
        case '8':
            $tbl_name = "apa_form8_section";
            break;
        case '9':
            $tbl_name = "apa_form9_section";
            break;
        case '10':
            $tbl_name = "apa_form10_section";
            break;
        case '11':
            $tbl_name = "apa_form11_section";
            break;
        case '12':
            $tbl_name = "apa_form12_section";
            break;
            
    };

    // Validate that table name was set
    if (empty($tbl_name)) {
        $error_msg = "Invalid appraisal form type ($rcd_sform_id)";
        $errors[] = "Row $row_number ($staff_id): $error_msg";
        $failed_rows[] = [
            'row_number' => $row_number,
            'data' => $row,
            'reason' => $error_msg
        ];
        continue; // Skip this record
    }

    $sectdesc = 'TRAINING';

    $query_trainsection = "SELECT * FROM $tbl_name WHERE form_section_desc = ? ";
    $get_trainsection = $db_con->prepare($query_trainsection); 
    
    if (!$get_trainsection) {
        $error_msg = "Database error: " . $db_con->error;
        $errors[] = "Row $row_number ($staff_id): $error_msg";
        $failed_rows[] = [
            'row_number' => $row_number,
            'data' => $row,
            'reason' => $error_msg
        ];
        continue; // Skip this record
    }
    
    $get_trainsection->bind_param("s", $sectdesc);
    $get_trainsection->execute();

    $rst_trainsection = $get_trainsection->get_result(); 
    $row_trainsection = $rst_trainsection->fetch_array(); 

    $form_section_id = $row_trainsection['form_section_id'];

    // ===== target manhours from training-manhours.php =====
    if (empty($target_manhour) || $target_manhour <= 0) {
        $errors[] = "Target manhour not defined for staff $staff_id";
        continue;
    }

    //Maximum training hour is 5
    $training_score = max(0, min(5, round(($actual_manhours / $target_manhour) * 5)));
    $training_score_perc = ($training_score / 5) * 5;

    // ===== INSERT =====
    $sql = "
    INSERT INTO training_score (
        staff_id,
        period_id,
        prd_training_id,
        financial_year,
        section,
        target_manhours,
        actual_manhours,
        training_score,
        upload_fileid,
        company,
        created_by,
        created_date,
        updated_by,
        updated_date
    ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)
    ON DUPLICATE KEY UPDATE
        period_id        = VALUES(period_id),
        prd_training_id  = VALUES(prd_training_id),
        financial_year   = VALUES(financial_year),
        section          = VALUES(section),
        target_manhours  = VALUES(target_manhours),
        actual_manhours  = VALUES(actual_manhours),
        training_score   = VALUES(training_score),
        upload_fileid    = VALUES(upload_fileid),
        company          = VALUES(company),
        updated_by       = VALUES(updated_by),
        updated_date     = VALUES(updated_date)
    ";


    $stmt = $db_con->prepare($sql);

    if (!$stmt) {
        $errors[] = "Prepare failed for $staff_id";
        continue;
    }

    $upload_fileid = $istId;

    if (
        !$staff_id ||
        !$company ||
        !$period_id ||
        !$prd_training_id ||
        !$fyr
    ) {
        $errors[] = "Missing data for $staff_id";
        continue;
    }

    $stmt->bind_param(
        "siiiiiiiisssss",
        $staff_id,
        $period_id,
        $prd_training_id,
        $fyr,
        $section,
        $target_manhour,
        $actual_manhours,
        $training_score,
        $upload_fileid,
        $company,
        $created_by,
        $pst_datenow,
        $created_by,
        $pst_datenow
    );

    // if (!$stmt->execute()) {
    //     $errors[] = "Insert failed for $staff_id";
    // }

    // APA Score - Check if record exists
    $check_apa = "SELECT staff_id FROM apa_score WHERE staff_id = ? AND apa_section = ?";
    $stmt_check = $db_con->prepare($check_apa);
    $stmt_check->bind_param("si", $staff_id, $section);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    
    if ($result_check->num_rows > 0) {
        // Record exists - UPDATE
        $update_apa = "UPDATE apa_score 
                       SET section_score = ?, 
                           score_percentage = ?, 
                           section_score_appsr = ?, 
                           score_percentage_appsr = ?
                       WHERE staff_id = ? AND apa_section = ?";
        $stmt_update = $db_con->prepare($update_apa);
        $stmt_update->bind_param("sssssi",$training_score, $training_score_perc, $training_score, $training_score_perc, $staff_id, $section);
        if (!$stmt_update->execute()) {
            $errors[] = "Update apa_score failed for $staff_id : " . $stmt_update->error;
        }

        $stmt_update->close();

    } else {
        // Record doesn't exist - INSERT
        $insert_apa = "INSERT INTO apa_score(staff_id, financial_year, apa_section, form_section_id, 
                                             section_score, score_percentage, section_score_appsr, score_percentage_appsr) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $db_con->prepare($insert_apa);
        $stmt_insert->bind_param("ssisssss", $staff_id, $fyr, $section, $form_section_id, 
                                  $training_score, $training_score_perc, $training_score, $training_score_perc);
        if (!$stmt_insert->execute()) {
            $errors[] = "Insert apa_score failed for $staff_id : " . $stmt_insert->error;
        }

        $stmt_insert->close();
        
    }
    $stmt_check->close();

    if (!$stmt->execute()) {
        $errors[] = "Insert failed for $staff_id : " . $stmt->error;
    }

    $stmt->close();
}

fclose($file);

// ================= RESPONSE =================
if (!empty($errors)) {
    $response = [
        'status' => 'error',
        'message' => 'Some records failed to upload'
    ];
    // $response = [
    //     'status' => 'error',
    //     'message' => 'Some records failed to upload',
    //     'error_count' => count($errors),
    //     'errors' => $errors,
    //     'failed_rows' => $failed_rows
    // ];
    echo json_encode($response);
} else {
    echo json_encode([
        'status' => 'success',
        'message' => 'All records uploaded successfully'
    ]);
}
