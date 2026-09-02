<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
file_put_contents("debug_org.txt", print_r($_POST, true));
header('Content-Type: application/json');
ob_start();

if ($_POST['action'] === 'list_financial_yr') {

    $columns = [
        'financial_year',
        'financial_desc',
        'financial_status',
        'date_start',
        'date_end'
    ];

    $sql = "
        SELECT
            financial_id,
            financial_year,
            financial_desc,
            financial_status,
            financial_accstatus,
            date_start,
            date_end
        FROM financial_year
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            financial_year LIKE '%$search%' OR
            financial_desc LIKE '%$search%'
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY financial_year DESC ";
    }

    // PAGINATION
    $limit = "";
    if ($_POST['length'] != -1) {
        $limit = " LIMIT {$_POST['start']}, {$_POST['length']} ";
    }

    $queryTotal = $db_con->query($sql);
    $queryData  = $db_con->query($sql . $limit);

    $data = array();
    while ($row = $queryData->fetch_assoc()) {

        $sub_array = array();
        $sub_array[] = '<span class="fw-bold text-dark">'.$row['financial_year'].'</span>';
        $sub_array[] = $row['financial_desc'];
        
        $status_sys = ($row['financial_status'] == 'Open') ? 'black' : 'meron';
        $status_acc = ($row['financial_accstatus'] == 'AC') ? 'black' : 'meron';
        
        $sub_array[] = '<span class="badge badge-rounded badge-'.$status_acc.'">'.$row['financial_accstatus'].'</span>';
        
        $sub_array[] = date('d-m-Y', strtotime($row['date_start']));
        $sub_array[] = date('d-m-Y', strtotime($row['date_end']));
        
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditFY" 
                            data-id="'.$row['financial_id'].'"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>';
        $data[] = $sub_array;
        
    }

    echo json_encode([
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $queryTotal->num_rows,
        "recordsFiltered" => $queryTotal->num_rows,
        "data"            => $data
    ]);
    exit;
}

if ($_POST['action'] === 'list_shift') {

    $columns = [
        'c.shiftcd',
        'c.shiftdesc',
        'c.shiftshort',
        'c.timestart',
        'c.timeend'

    ];

    $sql = "
        SELECT
            c.shiftid,
            c.shiftcd,
            c.shiftdesc,
            c.shiftshort,
            c.timestart,
            c.timeend
        FROM shift_detail c
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            c.shiftcd LIKE '%$search%' OR
            c.shiftdesc LIKE '%$search%' OR
            c.shiftshort LIKE '%$search%'
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY c.shiftid ASC ";
    }

    // PAGINATION
    $limit = "";
    if ($_POST['length'] != -1) {
        $limit = " LIMIT {$_POST['start']}, {$_POST['length']} ";
    }

    $queryTotal = $db_con->query($sql);
    $queryData  = $db_con->query($sql . $limit);

    $data = array();
    while ($row = $queryData->fetch_assoc()) {

        $sub_array = array();
        $sub_array[] = '<span class="mb-0 me-3" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Shift Name">
                            '.$row['shiftdesc']. '
                        </span> ';
        $sub_array[] = '<span class="mb-0 me-3 d-flex flex-wrap align-items-center justify-content-between w-100" 
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Shift Code">
                            '.$row['shiftcd']. '
                        </span> 

                        <small> 
                            <span class="text-dark"> Short Code : </span>
                            <span 
                                data-bs-toggle="tooltip" 
                                data-bs-placement="top" title="Short Code">
                                '.$row['shiftshort'].'
                            </span>
                        </small>';
        $sub_array[] = '<span class="clearfix" title="">
                            <span class="fs-14">'.$row['timestart']. '</span> 
                            <h6 class="mb-0 fw-semibold me-3"></h6>
                        </span>';
         $sub_array[] = '<span class="clearfix" title="">
                            <span class="fs-14">'.$row['timeend']. '</span> 
                            <h6 class="mb-0 fw-semibold me-3"></h6>
                        </span>'; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditShift" 
                            data-id="'.$row['shiftid'].'"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>';
        $data[] = $sub_array;
        
    }

    echo json_encode([
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $queryTotal->num_rows,
        "recordsFiltered" => $queryTotal->num_rows,
        "data"            => $data
    ]);
    exit;
}

//ADD
if ($_POST['action'] == 'add_shift') {

    // Sanitize and retrieve values
    $shiftcd    = strtoupper(trim($_POST['add_shiftcd']));
    $shiftdesc  = ucwords(trim($_POST['add_shiftdesc']));
    $shiftshort = trim($_POST['add_shiftshort']);
    $timestart  = trim($_POST['add_timestart']);
    $timeend    = trim($_POST['add_timeend']);
    $created_by  = $session_id;

    // Validate required fields (optional but recommended)
    if (empty($shiftcd) || empty($shiftdesc) || empty($shiftshort)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT shiftid 
                FROM shift_detail 
                WHERE shiftcd = ? OR shiftdesc = ? OR shiftshort = ? OR timestart = ? OR timeend = ?  
            ");

    $stmt->bind_param("sssss", $shiftcd, $shiftdesc, $shiftshort, $timestart, $timeend);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate shift found.'
        ]);
        exit;
    }

    function toMinutes($time) {
        list($h,$m) = explode(':', $time);
        return ($h * 60) + $m;
    }

    $newStart = toMinutes($timestart);
    $newEnd   = toMinutes($timeend);

    // Handle wrap past midnight
    if ($newEnd <= $newStart) {
        $newEnd += 1440; // +24 hours
    }

    // Get all existing shifts
    $sql = "SELECT timestart, timeend FROM shift_detail";
    $res = $db_con->query($sql);

    while($row = $res->fetch_assoc()){

        $exStart = toMinutes($row['timestart']);
        $exEnd   = toMinutes($row['timeend']);

        if ($exEnd <= $exStart) {
            $exEnd += 1440;
        }

        // ----- OVERLAP CHECK -----
        if ($newStart < $exEnd && $newEnd > $exStart) {

            echo json_encode([
                'status' => 'error',
                'message' => 'Shift time overlaps with an existing shift.'
            ]);
            exit;
        }
    }

    // Prepare INSERT query
    $sql = "
        INSERT INTO shift_detail (
            shiftcd,
            shiftdesc,
            shiftshort,
            timestart,
            timeend,
            created_by,
            created_date
        ) VALUES (
            ?,?,?,?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "ssssss",
        $shiftcd,
        $shiftdesc,
        $shiftshort,
        $timestart,
        $timeend,
        $created_by
    );

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'New Shift successfully created.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to create new shift. Please try again.'
        ]);
    }

    exit;
}

// GET RECORD
if ($_POST['action'] == 'get_shift') {

    $shift_id = intval($_POST['shift_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            shiftid, 
            shiftcd, 
            shiftdesc, 
            shiftshort,
            timestart,
            timeend
        FROM shift_detail 
        WHERE shiftid = ?
    ");

    $stmt->bind_param("i", $shift_id);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // return success + data
        echo json_encode([
            'status' => 'success',
            'data' => $row
        ]);
    } else {
        // no record found
        echo json_encode([
            'status' => 'error',
            'message' => 'Shift not found.'
        ]);
    }

    exit;
}

//UPDATE 
if ($_POST['action'] == 'update_shift') {

    // Sanitize and retrieve values
    $shift_id   = intval($_POST['edit_shift_id']);
    $shiftcd    = strtoupper(trim($_POST['edit_shiftcd']));
    $shiftdesc  = ucwords(trim($_POST['edit_shiftdesc']));
    $shiftshort = trim($_POST['edit_shiftshort']);
    $timestart  = trim($_POST['edit_timestart']);
    $timeend    = trim($_POST['edit_timeend']);
    $updated_by  = $session_id;

    // Validate required fields (optional but recommended)
    if (empty($shiftcd) || empty($shiftdesc) || empty($shiftshort)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT shiftid 
                FROM shift_detail 
                WHERE 
                    (shiftcd = ? OR shiftdesc = ? OR shiftshort = ? OR timestart = ? OR timeend = ?) 
                    AND shiftid != ?
            ");

    $stmt->bind_param("sssssi", $shiftcd, $shiftdesc, $shiftshort, $timestart, $timeend, $shift_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate shift found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE shift_detail 
                SET 
                    shiftcd = ?, 
                    shiftdesc = ?, 
                    shiftshort = ?, 
                    timestart = ?, 
                    timeend = ?,
                    updated_by = ?,
                    updated_date = NOW()
                WHERE shiftid = ?
            ");

    $stmt->bind_param("ssssssi", $shiftcd, $shiftdesc, $shiftshort, $timestart, $timeend, $updated_by, $shift_id);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Shift details updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update shift details. Please try again.'
        ]);
    }

    exit;
}

// GET FINANCIAL YEAR
if ($_POST['action'] === 'get_financial_yr') {
    $id = intval($_POST['financial_id']);
    $res = $db_con->query("SELECT * FROM financial_year WHERE financial_id = $id");
    
    if (ob_get_length()) ob_clean();
    if ($res && $res->num_rows > 0) {
        echo json_encode(['status' => 'success', 'data' => $res->fetch_assoc()]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
    }
    exit;
}

// ADD FINANCIAL YEAR
if ($_POST['action'] === 'add_financial_yr') {

    $fyear = trim($_POST['add_financial_year']);
    $desc  = trim($_POST['add_financial_desc']);
    $start = $_POST['add_date_start'];
    $end   = $_POST['add_date_end'];

    // Check for duplicates
    $check = $db_con->prepare("SELECT financial_id FROM financial_year WHERE financial_year = ? OR financial_desc = ? OR (date_start = ? AND date_end = ?)");
    $check->bind_param("ssss", $fyear, $desc, $start, $end);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Duplicate record found (Year, Description or Date Range).']);
        exit;
    }

    $stmt = $db_con->prepare("INSERT INTO financial_year (financial_year, financial_desc, date_start, date_end, financial_accstatus, financial_status, created_date, created_by) VALUES (?, ?, ?, ?, 'IN', 'Close', NOW(), ?)");
    $stmt->bind_param("sssss", $fyear, $desc, $start, $end, $session_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to save record.']);
    }
    exit;
}

// UPDATE FINANCIAL YEAR
if ($_POST['action'] === 'update_financial_yr') {

    $id    = intval($_POST['edit_financial_id']);
    $fyear = trim($_POST['edit_financial_year']);
    $desc  = trim($_POST['edit_financial_desc']);
    $start = $_POST['edit_date_start'];
    $end   = $_POST['edit_date_end'];
    $acc   = $_POST['edit_financial_accstatus'];
    
    // Auto status logic: AC -> Open, IN -> Close
    $sys   = ($acc === 'IN') ? 'Close' : 'Open'; 

    // Enforce single AC status if current is being set to AC
    if ($acc === 'AC') {
        $db_con->query("UPDATE financial_year SET financial_accstatus = 'IN', financial_status = 'Close' WHERE financial_id != $id");
    }

    // Check for duplicates
    $check = $db_con->prepare("SELECT financial_id FROM financial_year WHERE (financial_year = ? OR financial_desc = ? OR (date_start = ? AND date_end = ?)) AND financial_id != ?");
    $check->bind_param("ssssi", $fyear, $desc, $start, $end, $id);
    $check->execute();
    if ($check->get_result()->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Duplicate record found (Year, Description or Date Range).']);
        exit;
    }

    $stmt = $db_con->prepare("UPDATE financial_year SET financial_year = ?, financial_desc = ?, date_start = ?, date_end = ?, financial_accstatus = ?, financial_status = ?, updated_date = NOW(), updated_by = ? WHERE financial_id = ?");
    $stmt->bind_param("sssssssi", $fyear, $desc, $start, $end, $acc, $sys, $session_id, $id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update record.']);
    }
    exit;
}

// target_dpu handling
if ($_POST['action'] === 'list_target_dpu') {

    $columns = ['a.dpu_id', 'b.modcode', 'a.financial_year', 'a.feb', 'a.mac', 'a.apr', 'a.may', 'a.june', 'a.july', 'a.aug', 'a.sept', 'a.oct', 'a.nov', 'a.december', 'a.jan', 'a.dpu_status'];
    $sql = "SELECT a.*, b.modcode, y.financial_desc FROM dpu_target a 
                LEFT JOIN model_details b ON a.model_id = b.modid 
                LEFT JOIN financial_year y ON a.financial_year = y.financial_year WHERE 1=1";
    
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (a.financial_year LIKE '%$search%' OR b.modcode LIKE '%$search%') ";
    }
    if (!empty($_POST['filter_fy'])) {
        $filter_fy = $db_con->real_escape_string($_POST['filter_fy']);
        $sql .= " AND a.financial_year = '$filter_fy' ";
    }
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        if ($col < count($columns)) {
            $sql .= " ORDER BY {$columns[$col]} $dir ";
        }
    } else {
        $sql .= " ORDER BY a.dpu_id DESC ";
    }
    $limit = "";
    if ($_POST['length'] != -1) {
        $limit = " LIMIT {$_POST['start']}, {$_POST['length']} ";
    }

    $queryTotal = $db_con->query($sql);
    $queryData  = $db_con->query($sql . $limit);

    $models = [];
    $res_m = $db_con->query("SELECT modid, modcode FROM model_details WHERE compcd = '$session_comp' and plant = '$session_plant' and modstatus = 'Y' ORDER BY modcode ASC");
    if ($res_m) {
        while($m_row = $res_m->fetch_assoc()) {
            $models[$m_row['modid']] = $m_row['modcode'];
        }
    }

    $data = array();
    $no = $_POST['start'] + 1;

    while ($row = $queryData->fetch_assoc()) {

        $d = $row['dpu_status'] == 'IN' ? 'disabled' : '';
        $id = $row['dpu_id'];

        $sub_array = array();
        $sub_array[] = $no++;

        $model_select = '<select class="form-select form-select-sm dpu-inline-edit" style="min-width:120px;" data-id="'.$id.'" data-field="model_id" '.$d.'>';
        $model_select .= '<option value="">-</option>';
        foreach($models as $m_id => $m_code) {
            $sel = ($row['model_id'] == $m_id) ? 'selected' : '';
            $model_select .= '<option value="'.$m_id.'" '.$sel.'>'.$m_code.'</option>';
        }
        $model_select .= '</select>';

        $sub_array[] = '<span class="fw-bold text-dark">'.$row['financial_desc'].'</span>';
        $sub_array[] = $model_select;
        
        $cm = (int)date('n');
        $cy = (int)date('Y');
        
        $m_map = [
            'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
            'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
            'december' => 12, 'jan' => 1
        ];

        $b = function($field, $val) use ($id, $row, $cm, $cy, $m_map) {
            $lock = '';
            if ($row['dpu_status'] == 'IN') {
                $lock = 'disabled';
            } else {
                $fy = (int)$row['financial_year'];
                $f_month = $m_map[$field];
                $f_year = ($f_month == 1) ? $fy + 1 : $fy;
                
                $abs_current = $cy * 12 + $cm;
                $abs_field = $f_year * 12 + $f_month;
                
                if ($abs_field <= $abs_current - 2) {
                    $lock = 'disabled';
                }
            }
            return '<input type="number" step="0.001" min="0.001" class="form-control form-control-sm dpu-inline-edit" style="min-width:70px;" data-id="'.$id.'" data-field="'.$field.'" value="'.floatval($val).'" '.$lock.'>';
        };

        $sub_array[] = $b('feb', $row['feb']);
        $sub_array[] = $b('mac', $row['mac']);
        $sub_array[] = $b('apr', $row['apr']);
        $sub_array[] = $b('may', $row['may']);
        $sub_array[] = $b('june', $row['june']);
        $sub_array[] = $b('july', $row['july']);
        $sub_array[] = $b('aug', $row['aug']);
        $sub_array[] = $b('sept', $row['sept']);
        $sub_array[] = $b('oct', $row['oct']);
        $sub_array[] = $b('nov', $row['nov']);
        $sub_array[] = $b('december', $row['december']);
        $sub_array[] = $b('jan', $row['jan']);

        $status_acc = ($row['dpu_status'] == 'AC') ? 'black' : 'meron';
        $sub_array[] = '<span class="badge badge-rounded badge-'.$status_acc.'" style="font-size:11px;">'.$row['dpu_status'].'</span>';
        
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditDPU" 
                            data-id="'.$row['dpu_id'].'"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>';
        $data[] = $sub_array;
    }

    if (ob_get_length()) ob_clean();
    echo json_encode([
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $queryTotal->num_rows,
        "recordsFiltered" => $queryTotal->num_rows,
        "data"            => $data
    ]);
    exit;
}

if ($_POST['action'] === 'get_target_dpu') {

    $id = intval($_POST['dpu_id']);
    $res = $db_con->query("SELECT * FROM dpu_target WHERE dpu_id = $id");
    if (ob_get_length()) ob_clean();
    if ($res && $res->num_rows > 0) {
        echo json_encode(['status' => 'success', 'data' => $res->fetch_assoc()]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
    }
    exit;
}

if ($_POST['action'] === 'update_target_dpu') {

    $id = intval($_POST['edit_dpu_id']);
    $model_id = intval($_POST['edit_model_id']);

    $fy_query = $db_con->query("SELECT financial_year FROM dpu_target WHERE dpu_id = $id");
    if ($fy_query && $fy_query->num_rows > 0) {
        $curr_fy = $fy_query->fetch_assoc()['financial_year'];
        $check = $db_con->query("SELECT dpu_id FROM dpu_target WHERE model_id = '$model_id' AND financial_year = '$curr_fy' AND dpu_id != '$id'");
        if ($check->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Duplicate target DPU record exists for this Model and Financial Year.']);
            exit;
        }
    }
    $feb = floatval($_POST['edit_feb']);
    $mac = floatval($_POST['edit_mac']);
    $apr = floatval($_POST['edit_apr']);
    $may = floatval($_POST['edit_may']);
    $june = floatval($_POST['edit_june']);
    $july = floatval($_POST['edit_july']);
    $aug = floatval($_POST['edit_aug']);
    $sept = floatval($_POST['edit_sept']);
    $oct = floatval($_POST['edit_oct']);
    $nov = floatval($_POST['edit_nov']);
    $dec = floatval($_POST['edit_december']);
    $jan = floatval($_POST['edit_jan']);
    $status = $_POST['edit_dpu_status'];

    if ($model_id > 0) {
        $stmt = $db_con->prepare("UPDATE dpu_target SET model_id=?, feb=?, mac=?, apr=?, may=?, june=?, july=?, aug=?, sept=?, oct=?, nov=?, december=?, jan=?, dpu_status=?, updated_by=?, updated_date=NOW() WHERE dpu_id=?");
        $stmt->bind_param("iddddddddddddssi", $model_id, $feb, $mac, $apr, $may, $june, $july, $aug, $sept, $oct, $nov, $dec, $jan, $status, $session_id, $id);
    } else {
        $stmt = $db_con->prepare("UPDATE dpu_target SET feb=?, mac=?, apr=?, may=?, june=?, july=?, aug=?, sept=?, oct=?, nov=?, december=?, jan=?, dpu_status=?, updated_by=?, updated_date=NOW() WHERE dpu_id=?");
        $stmt->bind_param("ddddddddddddssi", $feb, $mac, $apr, $may, $june, $july, $aug, $sept, $oct, $nov, $dec, $jan, $status, $session_id, $id);
    }
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update.']);
    }
    exit;
}

if ($_POST['action'] === 'inline_update_target_dpu') {

    $id = intval($_POST['dpu_id']);
    $field = trim($_POST['field']);
    $val = floatval($_POST['value']);

    $allowed = ['model_id','feb','mac','apr','may','june','july','aug','sept','oct','nov','december','jan'];
    if (in_array($field, $allowed)) {
        if ($field === 'model_id') {
            $val = intval($_POST['value']);
            $fy_query = $db_con->query("SELECT financial_year FROM dpu_target WHERE dpu_id = $id");
            if ($fy_query && $fy_query->num_rows > 0) {
                $curr_fy = $fy_query->fetch_assoc()['financial_year'];
                $check = $db_con->query("SELECT dpu_id FROM dpu_target WHERE model_id = '$val' AND financial_year = '$curr_fy' AND dpu_id != '$id'");
                if ($check->num_rows > 0) {
                    echo json_encode(['status' => 'error', 'message' => 'Duplicate record exists for this Model and Financial Year.']);
                    exit;
                }
            }
        }
        $stmt = $db_con->prepare("UPDATE dpu_target SET {$field} = ?, updated_by = ?, updated_date = NOW() WHERE dpu_id = ?");
        $stmt->bind_param("dsi", $val, $session_id, $id);
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
            exit;
        }
    }
    echo json_encode(['status' => 'error', 'message' => 'Failed to inline update.']);
    exit;
}

if ($_POST['action'] === 'upload_target_dpu') {
    require '../vendor/autoload.php';

    $model_id = intval($_POST['model_id']);
    $fy = $db_con->real_escape_string($_POST['financial_year']);

    if (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) {
        echo json_encode(['status' => 'error', 'message' => 'Upload failed.']);
        exit;
    }

    $uploadDir = 'uploads/DPU/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . '_' . basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($filePath);
            $worksheet = $spreadsheet->getActiveSheet();
            $data = $worksheet->toArray();
            
            if (isset($data[1])) {
                $row = $data[1];
                $feb = floatval($row[0]);
                $mac = floatval($row[1]);
                $apr = floatval($row[2]);
                $may = floatval($row[3]);
                $june = floatval($row[4]);
                $july = floatval($row[5]);
                $aug = floatval($row[6]);
                $sept = floatval($row[7]);
                $oct = floatval($row[8]);
                $nov = floatval($row[9]);
                $dec = floatval($row[10]);
                $jan = floatval($row[11]);
                $status = 'AC';

                $check = $db_con->query("SELECT dpu_id FROM dpu_target WHERE model_id = '$model_id' AND financial_year = '$fy'");
                if ($check->num_rows > 0) {
                    echo json_encode(['status' => 'error', 'message' => 'Duplicate target DPU record already exists for this Model and Financial Year.']);
                    exit;
                } else {
                    $stmt = $db_con->prepare("INSERT INTO dpu_target (model_id, financial_year, feb, mac, apr, may, june, july, aug, sept, oct, nov, december, jan, dpu_status, created_by, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
                    $stmt->bind_param("isddddddddddddss", $model_id, $fy, $feb, $mac, $apr, $may, $june, $july, $aug, $sept, $oct, $nov, $dec, $jan, $status, $session_id);
                    $stmt->execute();
                }

                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'No data found in the template.']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => 'Error parsing Excel: ' . $e->getMessage()]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded file.']);
    }
    exit;
}

if ($_POST['action'] === 'get_existing_models') {
    $fy = $db_con->real_escape_string($_POST['financial_year']);
    $res = $db_con->query("SELECT model_id FROM dpu_target WHERE financial_year = '$fy'");
    $existing = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $existing[] = intval($row['model_id']);
        }
    }
    echo json_encode(['status' => 'success', 'data' => $existing]);
    exit;
}

if ($_POST['action'] === 'get_existing_volume_models') {
    $fy = $db_con->real_escape_string($_POST['financial_year']);
    $res = $db_con->query("SELECT DISTINCT model_id FROM dpu_volume WHERE financial_year = '$fy'");
    $existing = [];
    if ($res) {
        while ($row = $res->fetch_assoc()) {
            $existing[] = intval($row['model_id']);
        }
    }
    echo json_encode(['status' => 'success', 'data' => $existing]);
    exit;
}

if ($_POST['action'] === 'list_dpu_volume') {

    $columns = ['a.dpu_volume_id', 'b.modcode', 'a.financial_year', 'a.feb', 'a.mac', 'a.apr', 'a.may', 'a.june', 'a.july', 'a.aug', 'a.sept', 'a.oct', 'a.nov', 'a.december', 'a.jan', 'a.dpu_volume_status'];
    $sql = "SELECT a.*, b.modcode, y.financial_desc FROM dpu_volume a 
                LEFT JOIN model_details b ON a.model_id = b.modid 
                LEFT JOIN financial_year y ON a.financial_year = y.financial_year WHERE 1=1";
    
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (a.financial_year LIKE '%$search%' OR b.modcode LIKE '%$search%') ";
    }
    if (!empty($_POST['filter_fy'])) {
        $filter_fy = $db_con->real_escape_string($_POST['filter_fy']);
        $sql .= " AND a.financial_year = '$filter_fy' ";
    }
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        if ($col < count($columns)) {
            $sql .= " ORDER BY {$columns[$col]} $dir ";
        }
    } else {
        $sql .= " ORDER BY a.dpu_volume_id DESC ";
    }
    $limit = "";
    if ($_POST['length'] != -1) {
        $limit = " LIMIT {$_POST['start']}, {$_POST['length']} ";
    }

    $queryTotal = $db_con->query($sql);
    $queryData  = $db_con->query($sql . $limit);

    $models = [];
    $res_m = $db_con->query("SELECT modid, modcode FROM model_details WHERE compcd = '$session_comp' and plant = '$session_plant' and modstatus = 'Y' ORDER BY modcode ASC");
    if ($res_m) {
        while($m_row = $res_m->fetch_assoc()) {
            $models[$m_row['modid']] = $m_row['modcode'];
        }
    }

    $data = array();
    $no = $_POST['start'] + 1;

    $existing_fy_models = [];
    $res_ex = $db_con->query("SELECT financial_year, model_id FROM dpu_volume");
    if ($res_ex) {
        while($r = $res_ex->fetch_assoc()) {
            $existing_fy_models[$r['financial_year']][] = $r['model_id'];
        }
    }

    while ($row = $queryData->fetch_assoc()) {

        $d = $row['dpu_volume_status'] == 'IN' ? 'disabled' : '';
        $id = $row['dpu_volume_id'];

        $sub_array = array();
        $sub_array[] = $no++;

        $current_fy = $row['financial_year'];
        $model_select = '<select class="form-select form-select-sm volume-inline-edit" style="min-width:120px;" data-id="'.$id.'" data-field="model_id" '.$d.'>';
        $model_select .= '<option value="">-</option>';
        foreach($models as $m_id => $m_code) {
            if ($row['model_id'] == $m_id || empty($existing_fy_models[$current_fy]) || !in_array($m_id, $existing_fy_models[$current_fy])) {
                $sel = ($row['model_id'] == $m_id) ? 'selected' : '';
                $model_select .= '<option value="'.$m_id.'" '.$sel.'>'.$m_code.'</option>';
            }
        }
        $model_select .= '</select>';

        $sub_array[] = '<span class="fw-bold text-dark">'.$row['financial_desc'].'</span>';
        $sub_array[] = $model_select;
        
        $cm = (int)date('n');
        $cy = (int)date('Y');
        
        $m_map = [
            'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
            'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
            'december' => 12, 'jan' => 1
        ];

        $m_names = [
            'feb' => 'February', 'mac' => 'March', 'apr' => 'April', 'may' => 'May', 'june' => 'June',
            'july' => 'July', 'aug' => 'August', 'sept' => 'September', 'oct' => 'October', 'nov' => 'November',
            'december' => 'December', 'jan' => 'January'
        ];

        $model_code_val = $row['modcode'];

        $b = function($field, $val, $remark) use ($id, $row, $cm, $cy, $m_map, $m_names, $model_code_val) {
            $lock = '';
            $is_future = false;
            
            $fy = (int)$row['financial_year'];
            $f_month = $m_map[$field];
            $f_year = ($f_month == 1) ? $fy + 1 : $fy;
            
            $abs_current = $cy * 12 + $cm;
            $abs_field = $f_year * 12 + $f_month;
            
            if ($row['dpu_volume_status'] == 'IN') {
                $lock = 'disabled';
            } else {
                if ($abs_field <= $abs_current - 2) {
                    $lock = 'disabled';
                }
            }
            if ($abs_field > $abs_current) {
                $is_future = true;
            }

            $icon_color = !empty($remark) ? 'text-yellow-m' : 'text-muted';
            $icon_style = empty($remark) ? 'opacity:0.4;' : '';
            
            $icon_class = 'btn-view-remark';
            $icon_cursor = 'cursor: pointer;';
            $icon_title = 'View/Edit Remark';
            
            if ($is_future || $row['dpu_volume_status'] == 'IN') {
                $icon_class = '';
                $icon_cursor = 'cursor: not-allowed; opacity: 0.2;';
                $icon_title = 'Remarks disabled';
            }

            $icon = '<i class="fa fa-comment '.$icon_color.' position-absolute '.$icon_class.'" style="top: 50%; right: 8px; transform: translateY(-50%); font-size: 13px; '.$icon_cursor.' '.$icon_style.'" title="'.$icon_title.'" data-id="'.$id.'" data-field="'.$field.'" data-month="'.$m_names[$field].'" data-model="'.$model_code_val.'" data-actual="'.intval($val).'" data-remark="'.htmlspecialchars(strval($remark)).'"></i>';

            return '<div class="position-relative" style="width: 100%; min-width: 85px;">
                        <input type="number" step="1" min="1" class="form-control form-control-sm volume-inline-edit pe-4" data-id="'.$id.'" data-field="'.$field.'" value="'.intval($val).'" '.$lock.'>
                        '.$icon.'
                    </div>';
        };

        $sub_array[] = $b('feb', $row['feb'], $row['feb_remark']);
        $sub_array[] = $b('mac', $row['mac'], $row['mac_remark']);
        $sub_array[] = $b('apr', $row['apr'], $row['apr_remark']);
        $sub_array[] = $b('may', $row['may'], $row['may_remark']);
        $sub_array[] = $b('june', $row['june'], $row['june_remark']);
        $sub_array[] = $b('july', $row['july'], $row['july_remark']);
        $sub_array[] = $b('aug', $row['aug'], $row['aug_remark']);
        $sub_array[] = $b('sept', $row['sept'], $row['sept_remark']);
        $sub_array[] = $b('oct', $row['oct'], $row['oct_remark']);
        $sub_array[] = $b('nov', $row['nov'], $row['nov_remark']);
        $sub_array[] = $b('december', $row['december'], $row['dec_remark']);
        $sub_array[] = $b('jan', $row['jan'], $row['jan_remark']);

        $status_acc = ($row['dpu_volume_status'] == 'AC') ? 'black' : 'meron';
        $sub_array[] = '<span class="badge badge-rounded badge-'.$status_acc.'" style="font-size:11px;">'.$row['dpu_volume_status'].'</span>';
        
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditDPUVolume" 
                            data-id="'.$row['dpu_volume_id'].'"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>';
        $data[] = $sub_array;
    }

    $output = array(
        "draw"            => isset($_POST['draw']) ? intval($_POST['draw']) : 0,
        "recordsTotal"    => $queryTotal->num_rows,
        "recordsFiltered" => $queryTotal->num_rows,
        "data"            => $data
    );

    echo json_encode($output);
    exit;
}

if ($_POST['action'] === 'get_dpu_volume') {
    $id = intval($_POST['dpu_id']);
    $res = $db_con->query("SELECT * FROM dpu_volume WHERE dpu_volume_id = $id");
    if (ob_get_length()) ob_clean();
    if ($res && $res->num_rows > 0) {
        echo json_encode(['status' => 'success', 'data' => $res->fetch_assoc()]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Record not found.']);
    }
    exit;
}

if ($_POST['action'] === 'update_dpu_volume') {
    
    $id = intval($_POST['edit_dpu_id']);
    $model_id = intval($_POST['edit_model_id']);
    $feb = floatval($_POST['edit_feb']);
    $mac = floatval($_POST['edit_mac']);
    $apr = floatval($_POST['edit_apr']);
    $may = floatval($_POST['edit_may']);
    $june = floatval($_POST['edit_june']);
    $july = floatval($_POST['edit_july']);
    $aug = floatval($_POST['edit_aug']);
    $sept = floatval($_POST['edit_sept']);
    $oct = floatval($_POST['edit_oct']);
    $nov = floatval($_POST['edit_nov']);
    $dec = floatval($_POST['edit_december']);
    $jan = floatval($_POST['edit_jan']);
    $status = $_POST['edit_dpu_status'];

    // Validation
    $vols = [$feb, $mac, $apr, $may, $june, $july, $aug, $sept, $oct, $nov, $dec, $jan];
    foreach($vols as $v) {
        if ($v < 1) {
            echo json_encode(['status' => 'error', 'message' => 'All monthly volumes must be 1 or greater.']);
            exit;
        }
    }

    $stmt = $db_con->prepare("UPDATE dpu_volume SET model_id=?, feb=?, mac=?, apr=?, may=?, june=?, july=?, aug=?, sept=?, oct=?, nov=?, december=?, jan=?, dpu_volume_status=?, updated_by=?, updated_date=NOW() WHERE dpu_volume_id=?");
    $stmt->bind_param("iddddddddddddssi", $model_id, $feb, $mac, $apr, $may, $june, $july, $aug, $sept, $oct, $nov, $dec, $jan, $status, $session_id, $id);

    if (ob_get_length()) ob_clean();
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update.']);
    }
    exit;
}

if ($_POST['action'] === 'inline_update_dpu_volume') {
    $id = intval($_POST['dpu_id']);
    $field = $_POST['field'];

    $allowed_num = ['model_id', 'feb', 'mac', 'apr', 'may', 'june', 'july', 'aug', 'sept', 'oct', 'nov', 'december', 'jan'];
    $allowed_text = ['feb_remark', 'mac_remark', 'apr_remark', 'may_remark', 'june_remark', 'july_remark', 'aug_remark', 'sept_remark', 'oct_remark', 'nov_remark', 'dec_remark', 'jan_remark'];
    
    if ($field === 'december_remark') $field = 'dec_remark';

    if (in_array($field, $allowed_num) || in_array($field, $allowed_text)) {
        $val = $_POST['value'];
        $type = 's'; // Default to string binding for text fields

        if (in_array($field, $allowed_num)) {
            if ($field === 'model_id') {
                $val = intval($_POST['value']);
                $type = 'd';
                $fy_query = $db_con->query("SELECT financial_year FROM dpu_volume WHERE dpu_volume_id = $id");
                if ($fy_query && $fy_query->num_rows > 0) {
                    $curr_fy = $fy_query->fetch_assoc()['financial_year'];
                    $check = $db_con->query("SELECT dpu_volume_id FROM dpu_volume WHERE model_id = '$val' AND financial_year = '$curr_fy' AND dpu_volume_id != '$id'");
                    if ($check->num_rows > 0) {
                        echo json_encode(['status' => 'error', 'message' => 'Duplicate record exists for this Model and Financial Year.']);
                        exit;
                    }
                }
            } else {
                $val = floatval($_POST['value']);
                $type = 'd';
                if ($val < 1) {
                    echo json_encode(['status' => 'error', 'message' => 'Volume must be 1 or greater.']);
                    exit;
                }
            }
        }
        
        $stmt = $db_con->prepare("UPDATE dpu_volume SET {$field} = ?, updated_by = ?, updated_date = NOW() WHERE dpu_volume_id = ?");
        $stmt->bind_param("{$type}si", $val, $session_id, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid field']);
    }
    exit;
}

if ($_POST['action'] === 'get_dpu_volume_months') {

    $fy = $db_con->real_escape_string($_POST['financial_year']);
    $model = intval($_POST['model_id']);

    $res = $db_con->query("SELECT feb, mac, apr, may, june, july, aug, sept, oct, nov, december, jan FROM dpu_volume WHERE financial_year = '$fy' AND model_id = '$model'");
    $existing = [];

    if ($res && $row = $res->fetch_assoc()) {
        $m_map = [
            'feb' => 2, 'mac' => 3, 'apr' => 4, 'may' => 5, 'june' => 6,
            'july' => 7, 'aug' => 8, 'sept' => 9, 'oct' => 10, 'nov' => 11,
            'december' => 12, 'jan' => 1
        ];
        foreach ($m_map as $col => $num) {
            if (isset($row[$col]) && floatval($row[$col]) != 0) {
                $existing[] = $num;
            }
        }
    }
    echo json_encode(['status' => 'success', 'data' => $existing]);
    exit;
}

if ($_POST['action'] === 'add_single_dpu_volume') {
    $fy = $db_con->real_escape_string($_POST['financial_year']);
    $model = intval($_POST['model_id']);
    $month_num = intval($_POST['month']);
    $vol = floatval($_POST['volume']);
    $remark = $_POST['remark'];

    if ($vol < 1) {
        echo json_encode(['status' => 'error', 'message' => 'Volume must be 1 or greater.']);
        exit;
    }

    $m_map = [
        2 => 'feb', 3 => 'mac', 4 => 'apr', 5 => 'may', 6 => 'june',
        7 => 'july', 8 => 'aug', 9 => 'sept', 10 => 'oct', 11 => 'nov',
        12 => 'december', 1 => 'jan'
    ];

    if (!isset($m_map[$month_num])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid month']);
        exit;
    }

    $col = $m_map[$month_num];
    $remark_col = ($col === 'december') ? 'dec_remark' : $col . '_remark';

    $check = $db_con->query("SELECT dpu_volume_id FROM dpu_volume WHERE financial_year = '$fy' AND model_id = '$model'");
    if ($check && $check->num_rows > 0) {
        $row = $check->fetch_assoc();
        $id = $row['dpu_volume_id'];
        
        $stmt = $db_con->prepare("UPDATE dpu_volume SET {$col} = ?, {$remark_col} = ?, updated_by = ?, updated_date = NOW() WHERE dpu_volume_id = ?");
        $stmt->bind_param("dssi", $vol, $remark, $session_id, $id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    } else {
        $stmt = $db_con->prepare("INSERT INTO dpu_volume (financial_year, model_id, {$col}, {$remark_col}, dpu_volume_status, created_by, created_date) VALUES (?, ?, ?, ?, 'AC', ?, NOW())");
        $stmt->bind_param("sidss", $fy, $model, $vol, $remark, $session_id);
        
        if ($stmt->execute()) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }
    exit;
}

if ($_POST['action'] === 'list_dpu_report') {
    $fy = $db_con->real_escape_string($_POST['filter_fy']);
    if (empty($fy)) {
        $fy = date('Y');
    }

    $columns = ['b.modid', 'b.modcode'];
    $sql_models = "SELECT b.modid, b.modcode FROM model_details b WHERE b.compcd = '$session_comp' and b.plant = '$session_plant' and b.modstatus = 'Y' ";
    
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql_models .= " AND (b.modcode LIKE '%$search%') ";
    }
    
    $sql_models .= " ORDER BY b.modcode ASC ";

    $sql_vol = "SELECT * FROM dpu_volume WHERE financial_year = '$fy'";
    $res_vol = $db_con->query($sql_vol);
    $vols = [];
    if ($res_vol) {
        while($v = $res_vol->fetch_assoc()) {
            $vols[$v['model_id']] = $v;
        }
    }

    // MONTH() matches calendar month.
    $sql_def = "SELECT inspection_records.ir_model, MONTH(inspection_records.shift_date) as mth, SUM(inspection_sorting.sr_qty_ng) as tot
                FROM inspection_sorting 
                JOIN inspection_records ON inspection_records.ir_id = inspection_sorting.sr_ir_id 
                WHERE inspection_records.financial_yr = '$fy'
                GROUP BY inspection_records.ir_model, MONTH(inspection_records.shift_date)";
    // Since shift_date handles proper production date, it's safer than inspect_date.
    
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

    $limit = "";
    if ($_POST['length'] != -1) {
        $limit = " LIMIT {$_POST['start']}, {$_POST['length']} ";
    }
    
    $queryTotal = $db_con->query($sql_models);
    $queryData = $db_con->query($sql_models . $limit);

    $data = array();
    $no = $_POST['start'] + 1;

    while ($row = $queryData->fetch_assoc()) {
        $mid = $row['modid'];
        $sub_array = array();
        $sub_array[] = $no++;
        $sub_array[] = '<span class="fw-bold">'.$row['modcode'].'</span>';

        foreach ($m_map as $col => $mth_num) {
            $vol = isset($vols[$mid][$col]) ? floatval($vols[$mid][$col]) : 0;
            $def = isset($defs[$mid][$mth_num]) ? $defs[$mid][$mth_num] : 0;

            if ($vol > 0) {
                $dpu = number_format(($def / $vol), 4);
                $sub_array[] = '<span class="text-success fw-bold">'.$dpu.'</span>';
            } else {
                $sub_array[] = ($def > 0) ? '<span class="text-danger" title="'.$def.' defects without volume">Vol 0</span>' : '-';
            }
        }

        $data[] = $sub_array;
    }

    echo json_encode([
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $queryTotal ? $queryTotal->num_rows : 0,
        "recordsFiltered" => $queryTotal ? $queryTotal->num_rows : 0,
        "data"            => $data
    ]);
    exit;
}

if ($_POST['action'] === 'get_dpu_chart') {
    $fy = $db_con->real_escape_string($_POST['filter_fy']);
    if (empty($fy)) {
        $fy = date('Y');
    }

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

    $sql_models = "SELECT modid, modcode FROM model_details WHERE compcd = '$session_comp' and plant = '$session_plant' and modstatus = 'Y'";
    $res_models = $db_con->query($sql_models);
    $models_map = [];
    if ($res_models) {
        while($m = $res_models->fetch_assoc()) {
            $models_map[$m['modid']] = $m['modcode'];
        }
    }

    $models_with_data = [];
    foreach($vols as $mid => $v) {
        $models_with_data[$mid] = true;
    }
    foreach($defs as $mid => $dm) {
        $models_with_data[$mid] = true;
    }

    $series = [];
    foreach($models_with_data as $mid => $val) {
        $modcode = isset($models_map[$mid]) ? $models_map[$mid] : "Unknown Model ($mid)";
        $model_dpu = [];
        $model_def = [];
        $model_vol = [];
        
        foreach ($m_map as $col => $mth_num) {
            $vol = isset($vols[$mid][$col]) ? floatval($vols[$mid][$col]) : 0;
            $def = isset($defs[$mid][$mth_num]) ? floatval($defs[$mid][$mth_num]) : 0;
            
            $dpu_val = ($vol > 0) ? ($def / $vol) : 0;
            $model_dpu[] = round($dpu_val, 4);
            $model_def[] = $def;
            $model_vol[] = $vol;
        }
        
        $series[] = [
            'name' => $modcode,
            'data' => $model_dpu,
            'defects' => $model_def,
            'volumes' => $model_vol
        ];
    }

    usort($series, function($a, $b) {
        return strcmp($a['name'], $b['name']);
    });

    echo json_encode([
        'status' => 'success',
        'series' => $series
    ]);
    exit;
}

?>