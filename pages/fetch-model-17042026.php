<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
file_put_contents("debug_org.txt", print_r($_POST, true));
header('Content-Type: application/json');

// =========================================
// MODEL
// =========================================
if ($_POST['action'] === 'list_model') {

    $columns = [
        'model'
    ];

    $sql = "
        SELECT
            model_id,
            model,
            model_status
        FROM model_hdr
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            model LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY model ASC ";
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

        $status = ($row['model_status']) == 'AC' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $sub_array = array();
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['model']. '</h6>                       
                        </a>'; 
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditModel" 
                            data-id="'.$row['model_id'].'"
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

if ($_POST['action'] === 'add_model') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'model_name' => 'Model Name'
    ];

    foreach ($required as $field => $label) {
        if (empty($_POST[$field])) {
            echo json_encode([
                'status' => 'error',
                'message' => "$label is required."
            ]);
            exit;
        }
    }

    // =========================
    // SANITIZE
    // =========================
    $model_name = strtoupper(trim($_POST['model_name']));
    $model_status = 'AC';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT model_id FROM model_hdr WHERE model = ?"
    );
    $chk->bind_param("s", $model_name);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Model already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO model_hdr (
            model,
            model_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "sss",
        $model_name,
        $model_status,
        $created_by
    );

    if ($stmt->execute()) {

        $model_id = $db_con->insert_id;

        // Auto create folder
        $folder_path = __DIR__ . "/gallery/model/" . $model_name;
        if (!is_dir($folder_path)) {
            mkdir($folder_path, 0777, true);
        }

        // Default values
        $compcd = '3100';
        $plant  = '3100';
        $modstatus = 'Y';

        $sql2 = "
            INSERT INTO model_details (
                modcode,
                model_id,
                compcd,
                plant,
                modstatus,
                created_by,
                created_date
            ) VALUES (
                ?,?,?,?,?,?, NOW()
            )
        ";

        $stmt2 = $db_con->prepare($sql2);
        $stmt2->bind_param(
            "ssssss",
            $model_name,
            $model_id,
            $compcd,
            $plant,
            $modstatus,
            $created_by
        );
        $stmt2->execute();
        
        echo json_encode([
            'status' => 'success'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $stmt->error
        ]);
    }
    exit;
}

// GET RECORD
if ($_POST['action'] == 'get_model') {

    $model_id = intval($_POST['model_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            model_id, 
            model,
            model_status
        FROM model_hdr
        WHERE model_id = ?
    ");

    $stmt->bind_param("i", $model_id);
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
            'message' => 'Model not found.'
        ]);
    }

    exit;
}

//UPDATE 
if ($_POST['action'] == 'update_model') {

    // Sanitize and retrieve values
    $model_id      = intval($_POST['model_id']);
    $model_name    = strtoupper(trim($_POST['model_name']));
    $model_status  = trim($_POST['modelStatus']);

    // Validate required fields (optional but recommended)
    if (empty($model_id) || empty($model_name )) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT model_id 
                FROM model_hdr
                WHERE 
                    model = ? 
                    AND model_id != ?
            ");

    $stmt->bind_param("si", $model_name, $model_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate model name found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE model_hdr 
                SET 
                    model = ?, 
                    model_status = ?
                WHERE model_id = ?
            ");

    $stmt->bind_param("ssi", $model_name, $model_status, $model_id);

    //Update model details
    $detail_status = ($model_status == 'AC') ? 'Y' : 'N';

    $stmtDet = $db_con->prepare("
                    UPDATE model_details
                    SET 
                        modcode = ?, 
                        modstatus = ?
                    WHERE model_id = ?
                ");

    $stmtDet->bind_param("ssi", $model_name, $detail_status, $model_id);
    $stmtDet->execute();

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Model updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update model. Please try again.'
        ]);
    }

    exit;
}

// =========================================
// MODEL TYPE
// =========================================
if ($_POST['action'] === 'list_model_type') {

    $columns = [
        'typemodel', 'typestatus'
    ];

    $sql = "
        SELECT
            typeid,
            typecode,
            typemodel,
            typestatus
        FROM model_type
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            typemodel LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY typemodel ASC ";
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

        $status = ($row['typestatus']) == 'Y' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $sub_array = array();
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['typemodel']. '</h6>                       
                        </a>';
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditModel" 
                            data-id="'.$row['typeid'].'"
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

if ($_POST['action'] === 'add_type') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'type_name' => 'Type Name'
    ];

    foreach ($required as $field => $label) {
        if (empty($_POST[$field])) {
            echo json_encode([
                'status' => 'error',
                'message' => "$label is required."
            ]);
            exit;
        }
    }

    // =========================
    // SANITIZE
    // =========================
    $type_name = strtoupper(trim($_POST['type_name']));
    $type_status = 'Y';
    $compcode = '3100';
    $plantcode = '3100';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
                "SELECT typeid FROM model_type WHERE typemodel = ? and compcd = ? and plant = ?"
            );
    $chk->bind_param("sss", $type_name, $compcode, $plantcode);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Type already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO model_type (
            typecode,
            typemodel,
            compcd,
            plant,
            typestatus,
            created_by,
            created_date
        ) VALUES (
            ?,?,?,?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "ssssss",
        $type_name,
        $type_name,
        $compcode,
        $plantcode,
        $type_status,
        $created_by
    );

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => $stmt->error
        ]);
    }
    exit;
}

// GET RECORD
if ($_POST['action'] == 'get_type') {

    $type_id = intval($_POST['type_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            typeid, 
            typemodel,
            typestatus
        FROM model_type
        WHERE typeid  = ?
    ");

    $stmt->bind_param("i", $type_id);
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
            'message' => 'Type not found.'
        ]);
    }

    exit;
}

//UPDATE 
if ($_POST['action'] == 'update_type') {

    // Sanitize and retrieve values
    $type_id      = intval($_POST['type_id']);
    $type_name    = strtoupper(trim($_POST['type_name']));
    $type_status  = trim($_POST['typeStatus']);

    // Validate required fields (optional but recommended)
    if (empty($type_id) || empty($type_name)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT typeid  
                FROM model_type
                WHERE 
                    typemodel = ? 
                    AND typeid != ?
            ");

    $stmt->bind_param("si", $type_name, $type_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate type found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE model_type
                SET 
                    typemodel = ?, 
                    typestatus = ?
                WHERE typeid = ?
            ");

    $stmt->bind_param("ssi", $type_name, $type_status, $type_id);

    //Update model details
    $detail_status = ($type_status == 'AC') ? 'Y' : 'N';

    $stmtDet = $db_con->prepare("
                    UPDATE model_type
                    SET 
                        typemodel = ?, 
                        typestatus = ?
                    WHERE typeid = ?
                ");

    $stmtDet->bind_param("ssi", $type_name, $detail_status, $type_id);
    $stmtDet->execute();

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Type updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update model. Please try again.'
        ]);
    }

    exit;
}


?>