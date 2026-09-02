<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
file_put_contents("debug_org.txt", print_r($_POST, true));
header('Content-Type: application/json');

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

?>