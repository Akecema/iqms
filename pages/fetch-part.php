<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
file_put_contents("debug_org.txt", print_r($_POST, true));
header('Content-Type: application/json');

// =========================================
// part
// =========================================
if ($_POST['action'] === 'list_part') {

    $columns = [
        'tp_partname'
    ];

    $sql = "
        SELECT
            tp_partid,
            tp_partname,
            tp_status
        FROM type_part
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            tp_partname LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY tp_partname ASC ";
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

        $status = ($row['tp_status']) == 'AC' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $sub_array = array();
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['tp_partname']. '</h6>                       
                        </a>'; 
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditPart" 
                            data-id="'.$row['tp_partid'].'"
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

if ($_POST['action'] === 'add_part') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'part_name' => 'Part Name'
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
    $part_name = strtoupper(trim($_POST['part_name']));
    $part_status = 'AC';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT tp_partid FROM type_part WHERE tp_partname = ?"
    );
    $chk->bind_param("s", $part_name);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Part already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO type_part (
            tp_partname,
            tp_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "sss",
        $part_name,
        $part_status,
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
if ($_POST['action'] == 'get_part') {

    $part_id = intval($_POST['part_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            tp_partid, 
            tp_partname,
            tp_status
        FROM type_part
        WHERE tp_partid = ?
    ");

    $stmt->bind_param("i", $part_id);
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
            'message' => 'Part not found.'
        ]);
    }

    exit;
}

//UPDATE 
if ($_POST['action'] == 'update_part') {

    // Sanitize and retrieve values
    $part_id      = intval($_POST['part_id']);
    $part_name    = strtoupper(trim($_POST['part_name']));
    $part_status  = trim($_POST['partStatus']);

    // Validate required fields (optional but recommended)
    if (empty($part_id) || empty($part_name)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT tp_partid 
                FROM type_part
                WHERE 
                    tp_partname = ? 
                    AND tp_partid != ?
            ");

    $stmt->bind_param("si", $part_name, $part_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate part name found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE type_part
                SET 
                    tp_partname = ?, 
                    tp_status = ?
                WHERE tp_partid = ?
            ");

    $stmt->bind_param("ssi", $part_name, $part_status, $part_id);


    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Part updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update part. Please try again.'
        ]);
    }

    exit;
}

?>