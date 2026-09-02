<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
file_put_contents("debug_org.txt", print_r($_POST, true));
header('Content-Type: application/json');

// =========================================
// LIST
// =========================================
if ($_POST['action'] === 'list_defect') {

    $columns = [
        'defectname'
    ];

    $sql = "
        SELECT
            defectid,
            defectname,
            defectstatus
        FROM defect_type
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            defectname LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY defectname ASC ";
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

        $status = ($row['defectstatus']) == 'Y' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $sub_array = array();
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['defectname']. '</h6>                       
                        </a>'; 
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditDefect" 
                            data-id="'.$row['defectid'].'"
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

// =========================
// ADD DEFECT
// =========================
if ($_POST['action'] === 'add_defect') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'defect_name' => 'Defect Name'
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
    $defect_name = strtoupper(trim($_POST['defect_name']));
    $defect_status = 'Y';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT defectid FROM defect_type WHERE defectid = ?"
    );
    $chk->bind_param("s", $defect_name);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Defect already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO defect_type (
            defectname,
            defectstatus,
            created_by,
            created_date
        ) VALUES (
            ?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "sss",
        $defect_name,
        $defect_status,
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

// =========================
// GET RECORD
// =========================
if ($_POST['action'] == 'get_defect') {

    $defect_id = intval($_POST['defect_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            defectid, 
            defectname,
            defectstatus
        FROM defect_type
        WHERE defectid = ?
    ");

    $stmt->bind_param("i", $defect_id);
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
            'message' => 'Defect not found.'
        ]);
    }

    exit;
}

// =========================
// UPDATE
// =========================
if ($_POST['action'] == 'update_defect') {

    // Sanitize and retrieve values
    $defect_id      = intval($_POST['defect_id']);
    $defect_name    = strtoupper(trim($_POST['defect_name']));
    $defect_status  = trim($_POST['defectStatus']);

    // Validate required fields (optional but recommended)
    if (empty($defect_id) || empty($defect_name)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT defectid 
                FROM defect_type
                WHERE 
                    defectname = ? 
                    AND defectid != ?
            ");

    $stmt->bind_param("si", $defect_name, $defect_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate defect name found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE defect_type
                SET 
                    defectname = ?, 
                    defectstatus = ?
                WHERE defectid = ?
            ");

    $stmt->bind_param("ssi", $defect_name, $defect_status, $defect_id);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Defect updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update defect. Please try again.'
        ]);
    }

    exit;
}

// =========================
// MAXIMUM AREA
// =========================
if ($_POST['action'] == 'edit_area_defect') {

    // Sanitize and retrieve values
    $max_area = intval($_POST['defect_area']);

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE defect_area
                SET areamax = ? 
            ");

    $stmt->bind_param("i", $max_area);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Maximum area of defect updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update. Please try again.'
        ]);
    }

    exit;
}

?>
