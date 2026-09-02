<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';
include 'system-transaction-code.php';
include 'get-running-no.php';
include '../web-mail/email-settings.php';

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$pst_datenow = date('Y-m-d H:i:s');	

if($_POST['action'] == 'fetch_records_group')
{
    $columns = array('ir_material', 'ir_model', 'inspect_date', 'ir_shift', 'ir_status');

    $today = date('Y-m-d');
    $query = "SELECT I.ir_material, I.ir_model, I.inspect_date, I.inspect_group, I.ir_shift, 
                T.modcode, P.typemodel, P.typeside, M.matno, M.matdesc,
                H.shiftdesc, H.shiftbadge,
                (   SELECT COUNT(*) 
                    FROM inspection_records AS I2 
                    WHERE I2.inspect_group = I.inspect_group
                )   AS pallet_count  
                FROM inspection_records AS I
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date' ";

    if ($session_role == 4) {
        // Restrict to only their own records
        $query .= " AND I.created_by = '$session_id' ";
    }
   
    if (!empty($_POST['fd_model'])) {
        $fd_model = intval($_POST['fd_model']); // sanitize
        $query .= " AND I.ir_model = '$fd_model' ";
    }

    if (!empty($_POST['fd_type'])) {
        $fd_type = intval($_POST['fd_type']);
        $query .= " AND I.ir_type = '$fd_type' ";
    }

    if (!empty($_POST['fd_material'])) {
        $fd_material = intval($_POST['fd_material']);
        $query .= " AND I.ir_material = '$fd_material' ";
    }

    if (!empty($_POST['daterange'])) {
        $daterange = $_POST['daterange'];
        $dates = explode(' - ', $daterange);
        if (count($dates) == 2) {
            $start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
            $end_date = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
            $query .= " AND DATE(I.inspect_date) BETWEEN '$start_date' AND '$end_date' ";
        }
    }

    if(isset($_POST["search"]["value"]))
    {
        $search = $_POST["search"]["value"];
        $query .= " AND (
            T.modcode LIKE '%$search%' OR 
            P.typemodel LIKE '%$search%' OR 
            P.typeside LIKE '%$search%' OR 
            M.matno LIKE '%$search%' OR 
            M.matdesc LIKE '%$search%'
        ) ";		
    }
   
    $query .= 'GROUP BY I.inspect_group';

    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order']['0']['column'];
        $colDir = $_POST['order']['0']['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= 'ORDER BY I.inspect_date DESC';
    }


    $query1 = '';

    if($_POST["length"] != -1)
    {
        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($db_con, $query));
    $result = mysqli_query($db_con, $query . $query1);

    $data = array();

    while($row = mysqli_fetch_array($result))
    {
        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
        
        $sub_array = array();
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2 viewMaterial" data-inspect-group="'.$row["inspect_group"].'"
                            data-material="'.$row['ir_material'].'" data-model="'.$row['ir_model'].'"  
                            data-bs-toggle="tooltip" title="Click to view material images"">
                            <h6 class="mb-0 fw-semibold">'.$row["matno"].'</h6>
                            <span class="fs-14">'.$row["matdesc"].'</span>
                        </a>'; 
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row["modcode"].'</h6>
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["typeside"].')'.'</span>
                        </div>'; 
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$isnpectiondate.'</span></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span></div>';
        $sub_array[] = '<div class="d-flex justify-content-center mb-2"><span class="badge badge-rounded badge-dark">'.$row["pallet_count"].'</span></div>';
        $sub_array[] = '<a href="javascript:void(0);"
                            class="btn btn-rounded btn-primary btn-xxs viewPallet" data-inspect-group="'.$row["inspect_group"].'" data-bs-toggle="tooltip" 
                                data-bs-placement="top" title="View all pallets sequence">
                            <i class="fa fa-cog"></i>
                        </a>';
        $sub_array[] = $row['inspect_group'];
        $data[] = $sub_array;
        
    }

    function get_all_data($db_con)
    {
        $query = "SELECT * FROM inspection_records WHERE created_by = '$session_id'";
        $result = mysqli_query($db_con, $query);
        return mysqli_num_rows($result);
    }

    $output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  $number_filter_row,
    "recordsFiltered" => $number_filter_row,
    "data"    => $data
    );

    echo json_encode($output);
}

// All record by group
if($_POST['action'] == 'fetch_records_list')
{
    $igroup = $_POST['igroup'] ?? '';

    $columns = array('I.ir_docno', 'I.ir_pallet_no', 'I.ir_result', 'I.ir_status');

    $query = "SELECT I.ir_id, I.ir_docno, I.ir_pallet_no, I.ir_result, I.ir_status,
                     I.inspect_date, I.shift_date, I.inspect_group, I.ir_shift, I.created_date,
                     T.modcode, P.typemodel, P.typeside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc
              FROM inspection_records AS I
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              WHERE 1=1 ";
              
    if ($session_role == 4) {
        // Restrict to only their own records
        $query .= " AND I.created_by = '$session_id' ";
    }

    // Filter by group
    if (!empty($igroup)) {
        $igroup = mysqli_real_escape_string($db_con, $igroup);
        $query .= " AND I.inspect_group = '$igroup' ";
    }

    // Filter: status
    if (!empty($_POST['fd_status'])) {
        $status = intval($_POST['fd_status']);
        $query .= " AND I.ir_status = '$status' ";
    }

    // Filter: result
    if (!empty($_POST['fd_result'])) {
        $result = mysqli_real_escape_string($db_con, $_POST['fd_result']);
        $query .= " AND I.ir_result = '$result' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);

        if (strpos($search, '#') === 0) {
            // Remove the '#' and search pallet number only
            $palletSearch = substr($search, 1);
            $query .= " AND I.ir_pallet_no LIKE '%$palletSearch%' ";
        } else {
            // Search document number
            $query .= " AND I.ir_docno LIKE '%$search%' ";
        }
    }

    // Ordering
    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order'][0]['column'];
        $colDir   = $_POST['order'][0]['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= " ORDER BY I.ir_pallet_no ASC"; // default sort by pallet sequence
    }

    // Pagination
    $query1 = '';
    if($_POST["length"] != -1) {
        $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($db_con, $query));
    $result = mysqli_query($db_con, $query . $query1);

    $records = [];
    $ids = [];
    while($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
        $ids[] = $row['ir_id'];
    }

    // Default empty map
    $defectMap = [];
    if (!empty($ids)) {
        $idList = implode(",", array_map('intval', $ids));
        $sqlDef = "SELECT rcd_ir_id, COUNT(*) AS defect_count 
                FROM inspection_defect 
                WHERE rcd_ir_id IN ($idList)
                GROUP BY rcd_ir_id";
        $resDef = mysqli_query($db_con, $sqlDef);
        while($d = mysqli_fetch_assoc($resDef)) {
            $defectMap[$d['rcd_ir_id']] = (int)$d['defect_count'];
        }
    }

    $data = [];

    foreach ($records as $row) {

        $irid = $row['ir_id'];
        $irStatus = $row['ir_status'];
        $has_defect = !empty($defectMap[$irid]) && $defectMap[$irid] > 0;

        // Status badge
        $statusBadge = '';
        if ($row['ir_status'] != 1) {
            if ($row['ir_status'] == 4) $statusBadge = '<span class="badge badge-rounded badge-outline-hijo badge-sm">'.$s_approved.'</span>';
            elseif ($row['ir_status'] == 5) $statusBadge = '<span class="badge badge-rounded badge-outline-pink badge-sm">'.$s_completed.'</span>';
            elseif ($row['ir_status'] == 8) $statusBadge = '<span class="badge badge-rounded badge-outline-oren badge-sm">'.$s_cancelled.'</span>';
            elseif ($row['ir_status'] == 9) $statusBadge = '<span class="badge badge-rounded badge-outline-purple badge-sm">'.$s_pendReview.'</span>';
            elseif ($row['ir_status'] == 12) $statusBadge = '<span class="badge badge-rounded badge-outline-primary badge-sm">'.$s_return.'</span>';
        }

        // Get delay days (for section = PDI, you can adjust if section dynamic)
        $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' AND task = 'IR' AND process = 'create'";
        $resDelay = mysqli_query($db_con, $delay_sql);
        $rowDelay = mysqli_fetch_assoc($resDelay);
        $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

        $today = new DateTime();
        $allowedDate = (clone $today)->modify("-{$delay_day} days");
        $prodDate = new DateTime($row['shift_date']);  // assuming shift_date exists in $row

        $isAllowed = $prodDate >= $allowedDate;
        $btnDisabled = $isAllowed ? "" : "disabled";

        // Action buttons
        $btnSubmit = "";
        $btnAddDefect = "";
        $btnViewDefect = "";
        $btnCancel = "";

        if($row['ir_result'] != "")
        {
            if ($row['ir_status'] == 1 || $row['ir_status'] == 12) {

                // If NG + no defect in status 1 → don't show submit/edit
                if (!($row['ir_status'] == 1 && $row['ir_result'] == 'NG' && !$has_defect)) {

                    $btnSubmit = '<button class="btn btn-rounded btn-red btn-xxs btnSubmit ms-1" 
                            data-bs-toggle="tooltip" title="Submit inspection"
                            data-irid="'.$irid.'" '.$btnDisabled.'><i class="fa-solid fa-paper-plane"></i></button>';
                }

                if ($row['ir_result'] == 'NG') {

                    $btnAddDefect = '<button class="btn btn-rounded btn-black btn-xxs btnAddDefect ms-1" 
                            data-bs-toggle="tooltip" title="Add defect"
                            data-irid="'.$irid.'" '.$btnDisabled.'><i class="fa-solid fa-plus"></i></button>';

                    if ($has_defect) {
                    
                        $btnViewDefect = ' <button class="btn btn-rounded btn-black btn-xxs btnViewDefect ms-1" 
                            data-bs-toggle="tooltip" title="View defect"
                            data-irid="'.$irid.'" data-status="'.$irStatus.'"><i class="fa fa-bars"></i></i></button>';
                        
                    }
                }
            }

            if ($row['ir_status'] == 9) {

                $btnCancel = '<button class="btn btn-rounded btn-black btn-xxs btnCancel ms-1" 
                        data-bs-toggle="tooltip" title="Cancel inspection"
                        data-irid="'.$irid.'" '.$btnDisabled.'><i class="fa fa-times"></i></button>';
            }

            $actionCell = $btnAddDefect . $btnViewDefect . $btnCancel . $btnSubmit. $shift_date;

        }
        

        // Disable result select for status 4, 5, 8
        $disableResult = (in_array($row['ir_status'], [4,5,8]) || !$isAllowed) ? 'disabled' : '';

        if ($row['ir_status'] == 4 || $row['ir_status'] == 5 || $row['ir_status'] == 8 || $row['ir_status'] == 9) {

            $resultCell = '<input type="text" value="'.$row['ir_result'].'" style="background-color:#EBF0EB;">';
        }
        else
        {
            // Result dropdown
            $resultCell = '<select class="form-control result-select" data-irid="'.$row['ir_id'].'" data-old="'.$row['ir_result'].'" '.$disableResult.'>
                                <option value="">Choose</option>
                                <option value="OK" '.($row['ir_result']=='OK'?'selected':'').'>OK</option>
                                <option value="NG" '.($row['ir_result']=='NG'?'selected':'').'>NG</option>
                            </select>';
        }

        $sub_array = [];
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" 
                                data-docno="'.$row["ir_docno"].'" data-bs-toggle="tooltip" title="Click to view details">
                                <span class="fs-14">'.$row["ir_docno"].'</span></a></div>';
        $sub_array[] = '<div class="d-flex justify-content-center mb-2">
                            <span class="badge badge-rounded badge-outline-dark">'.$row["ir_pallet_no"].'</span></div>';
        $sub_array[] = $resultCell;
        $sub_array[] = $statusBadge;
        $sub_array[] = $actionCell;

        $data[] = $sub_array;
    }

    $output = array(
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $number_filter_row,
        "recordsFiltered" => $number_filter_row,
        "data"            => $data
    );

    echo json_encode($output);
}

// All records
if($_POST['action'] == 'fetch_records_list_all')
{
    $igroup = $_POST['igroup'] ?? '';

    $columns = array('I.ir_docno', 'M.matno', 'P.modcode', 'I.inspect_date', 'H.shiftdesc', 'I.ir_pallet_no', 'I.ir_result', 'I.ir_status');

    $query = "SELECT I.ir_id, I.ir_docno, I.ir_model, I.ir_material, I.ir_pallet_no, I.ir_result, I.ir_status,
                     I.inspect_date, I.shift_date, I.inspect_group, I.ir_shift, I.created_date,
                     T.modcode, P.typemodel, P.typeside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc, H.shiftbadge
              FROM inspection_records AS I
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              WHERE I.ir_shift = '$current_shift' AND I.shift_date = '$shift_date' ";
    
    if ($session_role == 4) {
        // Restrict to only their own records
        $query .= " AND I.created_by = '$session_id' ";
    }

    if (!empty($_POST['fd_model'])) {
        $model = intval($_POST['fd_model']);
        $query .= " AND I.ir_model = '$model' ";
    }

    if (!empty($_POST['fd_type'])) {
        $type = intval($_POST['fd_type']);
        $query .= " AND I.ir_type = '$type' ";
    }

    if (!empty($_POST['fd_material'])) {
        $material = intval($_POST['fd_material']);
        $query .= " AND I.ir_material = '$material' ";
    }

    if (!empty($_POST['fd_shift'])) {
        $shift = mysqli_real_escape_string($db_con, $_POST['fd_shift']);
        $query .= " AND I.ir_shift = '$shift' ";
    }

    if (!empty($_POST['fd_status'])) {
        $status = intval($_POST['fd_status']);
        $query .= " AND I.ir_status = '$status' ";
    }

    // Filter: result
    if (!empty($_POST['fd_result'])) {
        $result = mysqli_real_escape_string($db_con, $_POST['fd_result']);
        $query .= " AND I.ir_result = '$result' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);

        if (strpos($search, '#') === 0) {
            // Remove the '#' and search pallet number only
            $palletSearch = substr($search, 1);
            $query .= " AND I.ir_pallet_no LIKE '%$palletSearch%' ";
        } else {
            // Search document number
            $query .= " AND I.ir_docno LIKE '%$search%' ";
        }
    }

    // Ordering
    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order'][0]['column'];
        $colDir   = $_POST['order'][0]['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= " ORDER BY I.ir_pallet_no ASC"; // default sort by pallet sequence
    }

    // Pagination
    $query1 = '';
    if($_POST["length"] != -1) {
        $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($db_con, $query));
    $result = mysqli_query($db_con, $query . $query1);

    $records = [];
    $ids = [];
    while($row = mysqli_fetch_assoc($result)) {
        $records[] = $row;
        $ids[] = $row['ir_id'];
    }

    // Default empty map
    $defectMap = [];
    if (!empty($ids)) {
        $idList = implode(",", array_map('intval', $ids));
        $sqlDef = "SELECT rcd_ir_id, COUNT(*) AS defect_count 
                FROM inspection_defect 
                WHERE rcd_ir_id IN ($idList)
                GROUP BY rcd_ir_id";
        $resDef = mysqli_query($db_con, $sqlDef);
        while($d = mysqli_fetch_assoc($resDef)) {
            $defectMap[$d['rcd_ir_id']] = (int)$d['defect_count'];
        }
    }

    $data = [];

    foreach ($records as $row) {

        $irid = $row['ir_id'];
        $irStatus = $row['ir_status'];
        $has_defect = !empty($defectMap[$irid]) && $defectMap[$irid] > 0;

        // Status badge
        $statusBadge = '';
        if ($row['ir_status'] != 1) {
            if ($row['ir_status'] == 4) $statusBadge = '<span class="badge badge-rounded badge-outline-hijo badge-sm">'.$s_approved.'</span>';
            elseif ($row['ir_status'] == 5) $statusBadge = '<span class="badge badge-rounded badge-outline-pink badge-sm">'.$s_completed.'</span>';
            elseif ($row['ir_status'] == 8) $statusBadge = '<span class="badge badge-rounded badge-outline-oren badge-sm">'.$s_cancelled.'</span>';
            elseif ($row['ir_status'] == 9) $statusBadge = '<span class="badge badge-rounded badge-outline-purple badge-sm">'.$s_pendReview.'</span>';
            elseif ($row['ir_status'] == 12) $statusBadge = '<span class="badge badge-rounded badge-outline-primary badge-sm">'.$s_return.'</span>';
        }

        // Get delay days (for section = PDI, you can adjust if section dynamic)
        $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' AND task = 'IR' AND process = 'create'";
        $resDelay = mysqli_query($db_con, $delay_sql);
        $rowDelay = mysqli_fetch_assoc($resDelay);
        $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

        $today = new DateTime();
        $allowedDate = (clone $today)->modify("-{$delay_day} days");
        $prodDate = new DateTime($row['shift_date']);  // assuming shift_date exists in $row

        $isAllowed = $prodDate >= $allowedDate;
        $btnDisabled = $isAllowed ? "" : "disabled";

        // Action buttons
        $btnSubmit = "";
        $btnAddDefect = "";
        $btnViewDefect = "";
        $btnCancel = "";

        if($row['ir_result'] != "")
        {
            if ($row['ir_status'] == 1 || $row['ir_status'] == 12) {

                // If NG + no defect in status 1 → don't show submit/edit
                if (!($row['ir_status'] == 1 && $row['ir_result'] == 'NG' && !$has_defect)) {

                    $btnSubmit = '<button class="btn btn-rounded btn-red btn-xxs btnSubmit ms-1" 
                            data-bs-toggle="tooltip" title="Submit inspection"
                            data-irid="'.$irid.'" '.$btnDisabled.'><i class="fa-solid fa-paper-plane"></i></button>';
                }

                if ($row['ir_result'] == 'NG') {

                    $btnAddDefect = '<button class="btn btn-rounded btn-black btn-xxs btnAddDefect ms-1" 
                            data-bs-toggle="tooltip" title="Add defect"
                            data-irid="'.$irid.'" '.$btnDisabled.'><i class="fa-solid fa-plus"></i></button>';

                    if ($has_defect) {
                    
                        $btnViewDefect = ' <button class="btn btn-rounded btn-black btn-xxs btnViewDefect ms-1" 
                            data-bs-toggle="tooltip" title="View defect"
                            data-irid="'.$irid.'" data-status="'.$irStatus.'"><i class="fa fa-bars"></i></i></button>';
                        
                    }
                }
            }

            if ($row['ir_status'] == 9) {

                $btnCancel = '<button class="btn btn-rounded btn-black btn-xxs btnCancel ms-1" 
                        data-bs-toggle="tooltip" title="Cancel inspection"
                        data-irid="'.$irid.'" '.$btnDisabled.'><i class="fa fa-times"></i></button>';
            }

            $actionCell = $btnAddDefect . $btnViewDefect . $btnCancel . $btnSubmit;

        }
        

        // Disable result select for status 4, 5, 8
        $disableResult = (in_array($row['ir_status'], [4,5,8]) || !$isAllowed) ? 'disabled' : '';

        if ($row['ir_status'] == 4 || $row['ir_status'] == 5 || $row['ir_status'] == 8 || $row['ir_status'] == 9) {

            $resultCell = '<input type="text" value="'.$row['ir_result'].'" style="background-color:#EBF0EB;">';
        }
        else
        {
            // Result dropdown
            $resultCell = '<select class="form-control result-select" data-irid="'.$row['ir_id'].'" data-old="'.$row['ir_result'].'" '.$disableResult.'>
                                <option value="">Choose</option>
                                <option value="OK" '.($row['ir_result']=='OK'?'selected':'').'>OK</option>
                                <option value="NG" '.($row['ir_result']=='NG'?'selected':'').'>NG</option>
                            </select>';
        }

        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
        
        $sub_array = [];
        
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" 
                                data-docno="'.$row["ir_docno"].'" data-bs-toggle="tooltip" title="Click to view details">
                                <span class="fs-14">'.$row["ir_docno"].'</span></a></div>';
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2 viewMaterial" data-inspect-group="'.$row["inspect_group"].'"
                            data-material="'.$row['ir_material'].'" data-model="'.$row['ir_model'].'"  
                            data-bs-toggle="tooltip" title="Click to view material images"">
                            <h6 class="mb-0 fw-semibold">'.$row["matno"].'</h6>
                            <span class="fs-14">'.$row["matdesc"].'</span>
                        </a>';
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row["modcode"].'</h6>
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["typeside"].')'.'</span>
                        </div>'; 
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span>'.$isnpectiondate.'</span></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><span class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</span></div>';
        $sub_array[] = '<div class="d-flex justify-content-center mb-2">
                            <span class="badge badge-rounded badge-outline-dark">'.$row["ir_pallet_no"].'</span></div>';
        $sub_array[] = $resultCell;
        $sub_array[] = $statusBadge;
        $sub_array[] = $actionCell;

        $data[] = $sub_array;
    }

    $output = array(
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $number_filter_row,
        "recordsFiltered" => $number_filter_row,
        "data"            => $data
    );

    echo json_encode($output);
}

// View details in Modal
if($_POST['action'] == 'inspection_details')
{

    $docno = $_POST['docno'];

    $sql = "SELECT I.ir_id, I.ir_docno, I.ir_docnocancel, I.ir_pallet_no, I.ir_result, I.ir_status, I.ir_shift,
            I.created_date, I.submitted_date, I.approved_date, I.reviewed_date, I.cancelled_date, I.returned_date,
            I.approved_by, I.reviewed_by, I.returned_by, I.reviewed_remark, I.approved_remark, I.cancel_remark, I.returned_remark,
            T.modcode, P.typemodel, P.typeside, 
            M.matno, M.matdesc, H.shiftdesc, H.shiftbadge, S.statusname, 
            E.short_name as createby, ES.short_name as submitby, EA.short_name as approvalby, EW.short_name as reviewby, 
            EC.short_name as cancelby, ER.short_name as returnby
            FROM inspection_records as I    
            LEFT JOIN model_details as T ON I.ir_model = T.modid
            LEFT JOIN model_type as P ON I.ir_type = P.typeid
            LEFT JOIN material_header as M ON I.ir_material = M.matid     
            LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort     
            LEFT JOIN system_status as S ON I.ir_status = S.statusid 
            LEFT JOIN employee_details AS E ON I.created_by = E.staff_id
            LEFT JOIN employee_details AS ES ON I.submitted_by = ES.staff_id
            LEFT JOIN employee_details AS EA ON I.approved_by = EA.staff_id
            LEFT JOIN employee_details AS EW ON I.reviewed_by = EW.staff_id
            LEFT JOIN employee_details AS EC ON I.cancelled_by = EC.staff_id
            LEFT JOIN employee_details AS ER ON I.returned_by = ER.staff_id
            WHERE I.ir_docno = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("s", $docno);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $docno = $row['ir_docno'];
    $ir_id = $row['ir_id'];
        
    $ng_html = ''; 

    if ($row['ir_result'] === 'NG') {

        // 1. Get defect results (with type name)
        $sqlDefect = "SELECT D.defect_id, D.defect_type, D.defect_area, T.defectname
                    FROM inspection_defect D
                    LEFT JOIN defect_type T ON D.defect_type = T.defectid
                    WHERE D.rcd_ir_id = ?";
        $stmtDefect = $db_con->prepare($sqlDefect);
        $stmtDefect->bind_param("i", $ir_id);
        $stmtDefect->execute();
        $resDefect = $stmtDefect->get_result();

        if ($resDefect->num_rows > 0) {

            $ng_html .= '          
            <div class="card">
                <div class="card-body">
                    <!--<h5 class="text-primary mt-3">Defects</h5>-->
                    <div class="table-responsive">
                        <table class="table custom-rounded-table date-table w-100" id="inspectionTable_defect">
                            <thead class="">
                                <tr>
                                    <th>Defect Type</th>
                                    <th>Defect Area</th>
                                    <th>Defect Photo</th>
                                    <th>Comparison Photo</th>
                                </tr>
                            </thead>
                            <tbody>';
            
            while ($defect = $resDefect->fetch_assoc()) {
                
                $defectId = $defect['defect_id'];

                //Fetch defect photos
                $photoHtml = '';
                $sqlPhoto = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                $stmtPhoto = $db_con->prepare($sqlPhoto);
                $stmtPhoto->bind_param("ii", $ir_id, $defectId);
                $stmtPhoto->execute();
                $resPhoto = $stmtPhoto->get_result();

                $photoHtml .= '<div class="avatar-list avatar-list-stacked">';
                while ($photo = $resPhoto->fetch_assoc()) {

                    $photoUrl = 'gallery/inspection/defect/' .$ir_id. '/' . $photo['defect_photo'];
                    $photoHtml .= '<img src="'.$photoUrl.'" data-src="'.$photoUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $photoHtml .= '</div>';

                if ($resPhoto->num_rows === 0) $photoHtml = '<span class="text-muted">-</span>';

                //Fetch comparison photos
                $compareHtml = '';
                $sqlCompare = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                $stmtCompare = $db_con->prepare($sqlCompare);
                $stmtCompare->bind_param("ii", $ir_id, $defectId);
                $stmtCompare->execute();
                $resCompare = $stmtCompare->get_result();

                $compareHtml .= '<div class="avatar-list avatar-list-stacked">';
                while ($compare = $resCompare->fetch_assoc()) {
                    $compareUrl = 'gallery/inspection/defect_compare/' .$ir_id. '/' . $compare['compare_photo'];
                    $compareHtml .= '<img src="'.$compareUrl.'" data-src="'.$compareUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $compareHtml .= '</div>';

                if ($resCompare->num_rows === 0) $compareHtml = '<span class="text-muted">-</span>';

                // Defect row
                $ng_html .= '
                    <tr>
                        <td>xx</td>
                        <td>'.$defect['defect_area'].'</td>
                        <td>'.$photoHtml.'</td>
                        <td>'.$compareHtml.'</td>
                    </tr>';
            }

            $ng_html .= '
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>';
                
        } else {
            $ng_html .= '<p class="text-muted px-4">No defect data found.</p>';
        }
    }

    //Result
    $badgeClass = "";

    if ($row["ir_result"] == 'OK') $badgeClass = 'badge-hijo';
    elseif ($row["ir_result"] == 'NG') $badgeClass = 'badge-meron';

    //Shift
    $badgeShift = $row["shiftbadge"];

    $status = $row['ir_status']; // current status

    // Always show Created Date
    $created_Dt = date("j M Y", strtotime($row['created_date'])) . ' | ' . date("h:i A", strtotime($row['created_date']));
    $created_by = 'by '.$row['createby'];

    // Submit date
    if ($row['submitted_date'] != '0000-00-00 00:00:00') {
        $submitted_Dt = date("j M Y", strtotime($row['submitted_date'])) . ' | ' . date("h:i A", strtotime($row['submitted_date']));        
        $submitted_by = 'by '.$row['submitby'];
    }
    else
    {
        $submitted_Dt = '-';
        $submitted_by = '';
    }

    //Approved & Reviewed date
    $approved_icon = "";
    if($row['ir_result'] === 'OK')
    {
        $approved_Dt = date("j M Y", strtotime($row['approved_date'])) . ' | ' . date("h:i A", strtotime($row['approved_date']));
        $approved_by = 'by '.$row['approvalby'];
        $approved_remark = $row['approved_remark'];
        
        if (!empty($row['approved_remark'])):
            $approved_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark"
                data-remark="'.$approved_remark.'"
                role="button">
                </i>
            </small>';
        endif;       
    }
    else
    {
        $approved_Dt = date("j M Y", strtotime($row['reviewed_date'])) . ' | ' . date("h:i A", strtotime($row['reviewed_date']));
        $approved_by = 'by '.$row['reviewby'];            
        $approved_remark = $row['reviewed_remark'];

        if (!empty($row['reviewed_remark'])):
            $approved_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark"
                data-remark="'.$approved_remark.'"
                role="button">
                </i>
            </small>';
        endif;
    }
    

    //Cancelled date
    $cancelled_icon = "";
    if ($row['cancelled_date'] != '0000-00-00 00:00:00') {
        $cancelled_Dt = date("j M Y", strtotime($row['cancelled_date'])) . ' | ' . date("h:i A", strtotime($row['cancelled_date']));
        $cancelled_by = 'by '.$row['cancelby'];
        $cancelled_remark = $row['cancel_remark'];
        $cancelled_docno = '#'.$row['ir_docnocancel'];

        if (!empty($row['cancel_remark'])):
            $cancelled_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark"
                data-remark="'.$cancelled_remark.'"
                role="button">
                </i>
            </small>';
        endif;
    }
    else
    {
        $cancelled_Dt = '-';
        $cancelled_by = '';
        $cancelled_remark = '';
        $cancelled_docno = '';
        $cancelled_icon = '';
    }

    //Returned date
    $returned_icon = '';
    if ($row['returned_date'] != '0000-00-00 00:00:00') {
        $returned_Dt = date("j M Y", strtotime($row['returned_date'])) . ' | ' . date("h:i A", strtotime($row['returned_date']));
        $returned_by = 'by '.$row['returnby'];
        $returned_remark = $row['returned_remark'];

        if (!empty($row['returned_remark'])):
            $returned_icon = '<small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 timeline-title-remark"
                data-remark="'.$returned_remark.'"
                role="button">
                </i>
            </small>';
        endif;
    }
    else
    {
        $returned_Dt = '-';
        $returned_by = '';
        $returned_remark = '';
        $returned_icon = '';
    }

    echo '<div class="row">
          
            <!-- LEFT: Pallet Card -->
            <div class="col-lg-8 mb-3">
                <div class="card p-3 mb-3 rounded shadow-sm border">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center" style="width: 40px; height: 40px; font-size: 18px;">
                                '.$row['ir_pallet_no'].'
                            </div>
                            <span class="ms-2 text-muted">Pallet Sequence</span>
                        </div>
                        <div class="text-end">
                            <span class="badge bg-black px-3 py-2">'.$row["statusname"].'</span></br>
                            <!--<small class="text-muted">Inspected by : <strong class="text-dark">'.$row["createby"].'</strong></small>-->
                        </div>                    
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6 border-end">
                            <p class="text-muted mb-0">Material</p>
                            <p class="fw-semibold text-primary mb-0">'.$row["matno"].'</p>
                            <p class="fw-semibold text-primary">'.$row["matdesc"].'</p>
                            <p class="text-muted mb-0 mt-2">Model</p>
                            <p class="fw-semibold text-primary">'.$row["typemodel"].' ('.$row["typeside"].')'.'</p>
                        </div>

                        <div class="col-md-6">
                            <p class="text-muted mb-0">Doc no</p>
                            <p class="fw-semibold text-primary">'.$row['ir_docno'].'</p>

                            <div class="d-flex gap-3 mt-3">
                                <div>
                                    <p class="text-muted mb-1">Result</p>
                                    <span class="badge badge-rounded '.$badgeClass.'">'.$row["ir_result"].'</span>
                                </div>
                                <div>
                                    <p class="text-muted mb-1">Shift</p>
                                    <h5 class="mb-0 mt-1 custom-text-mat"><span class="badge badge-rounded '.$badgeShift.'">'.$row["shiftdesc"].'</span></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: Activity Timeline -->
            <div class="col-lg-4 mb-3">
                <div class="card">
                    <div class="card-header py-3 d-block d-sm-flex bg-body-secondary">
                        <h4 class="heading mb-0">Timeline</h4>
                    </div>
                    <div class="card-body"  style="overflow-y:scroll;height:auto;max-height:260px;">
                        <div class="recent-post">
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-plus"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark">Created Date</p>
                                    <span class="ms-0 fs-13">'.$created_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$created_by.'</span>
                                </div>
                            </div>
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-alt"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark">Submitted Date</p>
                                    <span class="ms-0 fs-13">'.$submitted_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$submitted_by.'</span>
                                </div>
                            </div>
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-check"></i>
                                </div>
                                <div class="timeline-content">ccccccc
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$approved_remark.' ">Approved Date</p>
                                    <span class="ms-0 fs-13">'.$approved_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$approved_by. '</span>' .$approved_icon .'

                                    
                                </div>
                            </div>
                            <div class="timeline-entry mb-4">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-times"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$cancelled_remark.'">Cancelled Date</p>
                                    <span class="ms-0 fs-13">'.$cancelled_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$cancelled_by.'</span>' .$cancelled_icon .'</br>
                                    <span class="ms-0 fs-13 bold text-black">'.$cancelled_docno.'</span>
                                </div>
                            </div>
                            <div class="timeline-entry mb-0">
                                <div class="timeline-icon bg-body-secondary text-dark">
                                    <i class="fa fa-calendar-minus"></i>
                                </div>
                                <div class="timeline-content">
                                    <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="'.$returned_remark.'">Returned Date</p>
                                    <span class="ms-0 fs-13">'.$returned_Dt.'</span>
                                    <span class="ms-0 fs-13">'.$returned_by.'</span> '.$returned_icon.'
                                </div>
                            </div>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>';

        // Display defect
        echo $ng_html;

}

// Update result (Dropdown)
if ($_POST['action'] == 'update_result') {
    $irid = intval($_POST['irid']);
    $newResult = $_POST['result'] ?? '';

    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_result = ? WHERE ir_id = ?");
    $stmt->bind_param("si", $newResult, $irid);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'Result updated']);
    exit;
}

// Add defect
if ($_POST['action'] == 'add_defect') {

    error_log("ng_ir_id received: " . print_r($_POST, true));

    $ir_rcdid = $_POST['ng_ir_id'] ?? '';
    $defect_type = $_POST['fd_defectType_add'] ?? '';
    $defect_area = $_POST['fd_area_add'] ?? [];

    if (!$ir_rcdid || !$defect_type) {
        echo json_encode(['success' => false, 'error' => 'Missing ir_rcdid or defect_type']);
        exit;
    }

    // Convert array to comma-separated string
    $defect_area_str = '';
    if (!empty($defect_area)) {
        $defect_area_str = implode(',', $defect_area);
    }

    // 1. INSERT ONE ROW
    $stmt = $db_con->prepare("INSERT INTO inspection_defect (rcd_ir_id, defect_type, defect_area, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiss", $ir_rcdid, $defect_type, $defect_area_str, $session_id);
    $stmt->execute();
    $defect_id = $db_con->insert_id;

    // 2. Save defect_photo(s)
    if (!empty($_FILES['imageUpload_defect_photo']['name'][0])) {

        $targetDir = "gallery/inspection/defect/" .$ir_rcdid. "/";

        foreach ($_FILES['imageUpload_defect_photo']['tmp_name'] as $key => $tmp_name) {

            $originalName = basename($_FILES['imageUpload_defect_photo']['name'][$key]);

            // Replace ALL whitespace (spaces, tabs, etc) with underscores:
            $safeName = preg_replace('/\s+/', '_', $originalName);
            $fileName = uniqid() . '_' . $safeName;

            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($tmp_name, $targetFile)) {
                $stmtPhoto = $db_con->prepare("INSERT INTO inspection_defect_photo (rcd_ir_id, rcd_defect_id, defect_photo, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
                $stmtPhoto->bind_param("iiss", $ir_rcdid, $defect_id, $fileName, $session_id);
                $stmtPhoto->execute();
            }
        }
    }

    // 3. Save compare_photo(s)
    if (!empty($_FILES['imageUpload_compare_photo']['name'][0])) {

        $targetDir = "gallery/inspection/defect_compare/" .$ir_rcdid. "/";

        foreach ($_FILES['imageUpload_compare_photo']['tmp_name'] as $key => $tmp_name) {

            $originalName = basename($_FILES['imageUpload_compare_photo']['name'][$key]);
            
            // Replace ALL whitespace (spaces, tabs, etc) with underscores:
            $safeName = preg_replace('/\s+/', '_', $originalName);
            $fileName = uniqid() . '_' . $safeName;

            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($tmp_name, $targetFile)) {
                $stmtCompare = $db_con->prepare("INSERT INTO inspection_compare_photo (rcd_ir_id, rcd_defect_id, compare_photo, created_by, created_date) VALUES (?, ?, ?, ?, NOW())");
                $stmtCompare->bind_param("iiss", $ir_rcdid, $defect_id, $fileName, $session_id);
                $stmtCompare->execute();
            }
        }
    }

    echo json_encode(['success' => true]);

}

// From NG to OK
if ($_POST['action'] == 'delete_defect') {

    $irid = intval($_POST['irid']);
    
    // Delete defect photos
    $photos = [];
    $stmt = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = ?");
    $stmt->bind_param('i', $irid);
    $stmt->execute();
    $stmt->bind_result($photo_path);
    while ($stmt->fetch()) $photos[] = $photo_path;
    $stmt->close();

    foreach ($photos as $path) {
        $full_path = __DIR__ . "/gallery/inspection/defect/" .$ir_id. '/' . basename($path);
        if (file_exists($full_path)) unlink($full_path);
    }

    // Delete comparison photos
    $compare_photos = [];
    $stmt = $db_con->prepare("SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ?");
    $stmt->bind_param('i', $irid);
    $stmt->execute();
    $stmt->bind_result($compare_path);
    while ($stmt->fetch()) $compare_photos[] = $compare_path;
    $stmt->close();

    foreach ($compare_photos as $path) {
        $full_path = __DIR__ . "/gallery/inspection/defect_compare/" .$ir_id. '/' . basename($path);
        if (file_exists($full_path)) unlink($full_path);
    }

    // Delete defect records
    $db_con->query("DELETE FROM inspection_defect WHERE rcd_ir_id = " . intval($irid));
    $db_con->query("DELETE FROM inspection_defect_photo WHERE rcd_ir_id = " . intval($irid));
    $db_con->query("DELETE FROM inspection_compare_photo WHERE rcd_ir_id = " . intval($irid));

    echo json_encode(['success' => true, 'message' => 'Defects deleted']);
    exit;
}

// Submit inspection for review
if($_POST['action'] == 'submit_for_review')
{
    $ir_id = $_POST['ir_id']; 
    $transid = 1; 

    //running no
    $stmt = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.inspect_date, R.ir_shift, R.shift_date
                                FROM inspection_records R 
                                    WHERE ir_id = ?");
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $inspectiondet = $stmt->get_result()->fetch_assoc();

    $shiftDate = $inspectiondet['shift_date'];

    if($shiftDate == $shift_date) //today inspection
    {
        $transmodule = "IR";   
        $transprocess = "New";                
        $current_shift = $current_shift;      
        $shift_date = $shift_date; 

        $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

        //generate doc no
        //comp,code,date,running no
        $ir_docno = $session_comp . $ir_code . $doc_date . $running_no;
    
        // 2. Increment maximum_no by 1
        $stmt2 = $db_con->prepare("UPDATE transaction_type SET maximum_no = maximum_no + 1 WHERE transid = ?");
        $stmt2->bind_param('i', $transid);
        $stmt2->execute();

    }
    else //previous inspection
    {
        $cdoc_date = date('dmy', strtotime($inspectiondet['inspect_date']));

        //select maximum
        $sql = "SELECT MAX(CAST(RIGHT(ir_docno, 4) AS UNSIGNED)) AS max_running_no
                FROM inspection_records
                WHERE shift_date = '$shiftDate'";

        $res = mysqli_query($db_con, $sql);
        $row = mysqli_fetch_assoc($res);
        $row_max_no = $row['max_running_no'] + 1 ?? 0; // default 0 if none

        $max_no = str_pad($row_max_no, 4, '0', STR_PAD_LEFT);

        //generate doc no
        //comp,code,date,running no
        $ir_docno = $session_comp . $ir_code . $cdoc_date . $max_no;

    }

    // 1. Update inspection_records
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_docno = ?, ir_status = ?, submitted_by = ?, submitted_date = NOW() WHERE ir_id = ?");
    $stmt->bind_param('sisi', $ir_docno, $s_pendReview_id, $session_id, $ir_id);
    $stmt->execute();

    // --- Send Email Notification ---
    $recipients = [];

    //3. Select users with a specific role
    $sql = "SELECT E.staff_name, E.staff_email
                FROM user_authorization A 
                    LEFT JOIN employee_details E ON E.staff_id = A.staff_id
                        WHERE A.PDI_reviewer = 'Y' AND A.PDI_active = 1";
    $result = $db_con->query($sql);
    while ($row = $result->fetch_assoc()) {
        $recipients[] = $row;
    }

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_records R 
                                        LEFT JOIN material_header M ON R.ir_material = M.matid
                                            WHERE ir_id = ?");
    $stmt3->bind_param('i', $ir_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    //5. activity comment
    $appsection = 'PDI';
    $comment_status = "submit the inspection";

    // activities
    $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? and section = ? ";
    $stmtr_quamax = $db_con->prepare($query_quamax); 
    $stmtr_quamax->bind_param("ss", $session_id, $appsection);
    $stmtr_quamax->execute();

    $rst_quamax = $stmtr_quamax->get_result();                                                                
    $row_quamax = $rst_quamax->fetch_array();

    $next_priority = ($row_quamax[0] + 1);

    $rinsert5 = "INSERT INTO activity_comment(section, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date) 
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $rinsert5 = $db_con->prepare($rinsert5);
    $rinsert5->bind_param("ssssssssss", $appsection, $s_pendReview_id, $ir_docno, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    //submitter = user login
    $submitter_name  = $stf_name;
    $doc_no = $inspectiondet['ir_docno'];
    $inspectdate = date('d-m-Y', strtotime($inspectiondet['inspect_date']));
    $shiftdet = $inspectiondet['ir_shift'] == 'D' ? 'Day' : 'Night';

    $mail = new PHPMailer(); 

    // SMTP Configuration
    $mail->isSMTP();
    $mail->Host = $host; // Your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = $email_username; // Your Mailtrap username
    $mail->Password = $email_password; // Your Mailtrap password
    //$mail->SMTPSecure = 'tls';
    $mail->Port = $port;

    // Sender and recipient settings
    $mail->setFrom($email_username, $system_name);

    $success_count = 0;
    $fail_count = 0;
    $fail_emails = [];

    // All authorize users for review inspection record
    foreach ($recipients as $authouser) {

        // Clear all recipients and attachments for each loop
        $mail->clearAddresses();
        $mail->clearAttachments();

        $mail->addAddress($authouser['staff_email'], $authouser['staff_name']);        
        $mail->isHTML(true);
        $mail->Subject =  $esubject_4;

        $mail->Body = "<h4>Dear {$authouser['staff_name']},</h4>";
        $mail->Body .= "<p>A new inspection record (<strong>Doc No: $doc_no </strong>) has been submitted by $submitter_name and requires your review. </p>";
        $mail->Body .= "<p>Please log in to the system and review the submission at your earliest convenience.<br>";
        $mail->Body .= "<a href={$system_url}> {$system_url}</a></p>";

        $mail->Body .= "
                        <h4 style='color:#cc0000;'>Inspection Record Details</h4>
                        <table border='1' cellpadding='6' cellspacing='0' style='border-collapse:collapse;font-size:14px;'>
                            <tr>
                                <th align='left'>Part No</th>
                                <td>{$inspectiondet['matno']}</td>
                            </tr>
                            <tr>
                                <th align='left'>Inspection Date</th>
                                <td>{$inspectdate}</td>
                            </tr>
                            <tr>
                                <th align='left'>Shift</th>
                                <td>{$shiftdet}</td>
                            </tr>
                        </table>
                    ";

        $mail->Body .= "<p>** This is a system generated email. Please DO NOT REPLY. **</p>";
        
        if ($mail->send()) {
            $success_count++;  
        } else {
            $fail_count++;
            $fail_emails[] = $authouser['staff_email'] . " (" . $mail->ErrorInfo . ")";
        }

    }

    $response = [
        'success' => true,
        'msg' => 'Inspection record submitted for review.',
        'ir_id' => $ir_id
    ];

    echo json_encode($response);
    exit; // <--- always exit after sending AJAX response
}

// Cancel inspection record
if ($_POST['action'] == 'cancel_record') {

    $ir_id  = intval($_POST['ir_id'] ?? 0);
    $remark = trim($_POST['remark'] ?? '');
    $transid = 2; 

    //running no
    $stmt = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.inspect_date, R.ir_shift, R.shift_date
                                FROM inspection_records R 
                                    WHERE ir_id = ?");
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $inspectiondet = $stmt->get_result()->fetch_assoc();

    $shiftDate = $inspectiondet['shift_date'];

    if($shiftDate == $shift_date) //today inspection
    {
        $transmodule = "IR";   
        $transprocess = "New";                
        $current_shift = $current_shift;      
        $shift_date = $shift_date; 

        $running_no = getNextTransactionNo($db_con, $transmodule, $transprocess, $current_shift, $shift_date);

        //generate doc no
        //comp,code,date,running no
        $ir_docno = $session_comp . $ir_cancelcode . $doc_date . $ir_cancelcode_max;
    
        // 2. Increment maximum_no by 1
        $stmt2 = $db_con->prepare("UPDATE transaction_type SET maximum_no = maximum_no + 1 WHERE transid = ?");
        $stmt2->bind_param('i', $transid);
        $stmt2->execute();

    }
    else //previous inspection
    {
        $cdoc_date = date('dmy', strtotime($inspectiondet['inspect_date']));

        //select maximum
        $sql = "SELECT MAX(CAST(RIGHT(ir_docnocancel, 4) AS UNSIGNED)) AS max_running_no
                FROM inspection_records
                WHERE shift_date = '$shiftDate'";

        $res = mysqli_query($db_con, $sql);
        $row = mysqli_fetch_assoc($res);
        $row_max_no = $row['max_running_no'] + 1 ?? 0; // default 0 if none

        $ir_cancelcode_max = str_pad($row_max_no, 4, '0', STR_PAD_LEFT);

        //generate doc no
        //comp,code,date,running no
        $ir_docno = $session_comp . $ir_cancelcode . $cdoc_date . $ir_cancelcode_max;

    }

    // 1. Set current record to Cancelled (status = 8)
    $stmt = $db_con->prepare("UPDATE inspection_records SET ir_docnocancel = ?, ir_status = ? ,cancel_remark = ?, cancelled_by = ?, cancelled_date = NOW() WHERE ir_id = ?");
    $stmt->bind_param('sissi', $ir_docnocanc, $s_cancelled_id, $remark, $session_id, $ir_id);
    $stmt->execute();

    // 2. Copy the row, set status = 1 (New)
    // Get the current record (excluding primary key)
    $query = "SELECT ir_model, ir_type, ir_material, ir_shift, shift_date, ir_pallet_no, ir_result, shift_date, inspect_group, inspect_date, shift_date
                    FROM inspection_records WHERE ir_id = ?";
    $stmt2 = $db_con->prepare($query);
    $stmt2->bind_param('i', $ir_id);
    $stmt2->execute();
    $result = $stmt2->get_result();

    if ($row = $result->fetch_assoc()) {

        // Insert new record with status = 1
        $insert = $db_con->prepare("INSERT INTO inspection_records 
                                    (ir_model, ir_type, ir_material, ir_pallet_no, ir_result, ir_status, ir_shift, shift_date, inspect_group, inspect_date, shift_date)
                                    VALUES (?, ?, ?, ?, '', 1, ?, ?, ?, ?, ?)");
        $insert->bind_param(
                "sssssssss",
                $row['ir_model'],
                $row['ir_type'],
                $row['ir_material'],
                $row['ir_pallet_no'],
                $row['ir_shift'],
                $row['shift_date'],
                $row['inspect_group'],
                $row['inspect_date'],
                $row['shift_date']
        );
        $insert->execute();
    }

    // 4. Fetch inspection details
    $stmt3 = $db_con->prepare("SELECT R.ir_id, R.ir_docno, R.inspect_date, R.ir_shift, M.matno
                                    FROM inspection_records R 
                                        LEFT JOIN material_header M ON R.ir_material = M.matid
                                            WHERE ir_id = ?");
    $stmt3->bind_param('i', $ir_id);
    $stmt3->execute();
    $inspectiondet = $stmt3->get_result()->fetch_assoc();

    //5. activity comment
    $appsection = 'PDI';
    $comment_status = "cancel the inspection submission";

    // activities
    $query_quamax = "SELECT MAX(comment_priority) FROM activity_comment WHERE staff_id = ? and section = ? ";
    $stmtr_quamax = $db_con->prepare($query_quamax); 
    $stmtr_quamax->bind_param("ss", $session_id, $appsection);
    $stmtr_quamax->execute();

    $rst_quamax = $stmtr_quamax->get_result();                                                                
    $row_quamax = $rst_quamax->fetch_array();

    $next_priority = ($row_quamax[0] + 1);

    $rinsert5 = "INSERT INTO activity_comment(section, form_status, docno, prod_shift, shift_date, status_comment, comment_priority, staff_id, commentator, comment_date) 
                    VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $rinsert5 = $db_con->prepare($rinsert5);
    $rinsert5->bind_param("ssssssssss", $appsection, $s_cancelled_id, $ir_docnocanc, $current_shift, $shift_date, $comment_status, $next_priority, $session_id, $session_id, $pst_datenow);
    $rinsert5->execute();

    echo json_encode(['success' => true]);
    exit;
}

?>