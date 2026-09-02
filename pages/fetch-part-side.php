<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include '../db/db_connect.php';
include 'session-login.php';

header('Content-Type: application/json');

if (!isset($_POST['action'])) {
    echo json_encode(['status' => 'error', 'message' => 'No action specified.']);
    exit;
}

$action = $_POST['action'];

if ($action === 'list_part_side') {
    $columns = [
        0 => 'side_id',
        1 => 'side_name'
    ];

    $sql = "SELECT side_id, side_name, side_status FROM part_side WHERE 1=1";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (side_id LIKE '%$search%' OR side_name LIKE '%$search%')";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $colIndex = intval($_POST['order'][0]['column']);
        $dir = ($_POST['order'][0]['dir'] === 'asc') ? 'ASC' : 'DESC';
        if (isset($columns[$colIndex])) {
            $sql .= " ORDER BY {$columns[$colIndex]} $dir ";
        }
    } else {
        $sql .= " ORDER BY side_name ASC ";
    }

    // PAGINATION
    $limit = "";
    if (isset($_POST['length']) && $_POST['length'] != -1) {
        $start = intval($_POST['start']);
        $length = intval($_POST['length']);
        $limit = " LIMIT $start, $length ";
    }

    $resTotal = $db_con->query("SELECT COUNT(*) as total FROM part_side");
    $recordsTotal = $resTotal->fetch_assoc()['total'];

    // For Filtered
    $resFiltered = $db_con->query($sql);
    $recordsFiltered = $resFiltered->num_rows;

    $queryData = $db_con->query($sql . $limit);
    $data = [];
    $no = intval($_POST['start']) + 1;
    while ($row = $queryData->fetch_assoc()) {
        $status = ($row['side_status'] == 'AC') 
            ? '<span class="badge badge-rounded badge-dark fs-12 me-2">AC</span>' 
            : '<span class="badge badge-rounded badge-meron fs-12 me-2">IN</span>';

        $sub = [];
        $sub[] = $no++ .'.';
        $sub[] = $row['side_name'];
        $sub[] = $status;
        $sub[] = '<button type="button" class="btn btn-rounded btn-primary btn-xxs btnEditSide" data-id="'.$row['side_id'].'"><i class="fa fa-edit"></i></button>';
        $data[] = $sub;
    }

    echo json_encode([
        "draw" => intval($_POST['draw']),
        "recordsTotal" => intval($recordsTotal),
        "recordsFiltered" => intval($recordsFiltered),
        "data" => $data
    ]);
    exit;
}

if ($action === 'add_part_side') {
    $side_name = strtoupper(trim($_POST['side_name']));
    if (empty($side_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Side Name is required.']);
        exit;
    }

    // Check Duplicate
    $chk = $db_con->prepare("SELECT side_id FROM part_side WHERE side_name = ?");
    $chk->bind_param("s", $side_name);
    $chk->execute();
    if ($chk->get_result()->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Side Name already exists.']);
        exit;
    }

    $stmt = $db_con->prepare("INSERT INTO part_side (side_name, side_status, created_by, created_date) VALUES (?, 'AC', ?, NOW())");
    $stmt->bind_param("ss", $side_name, $session_id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Save failed.']);
    }
    exit;
}

if ($action === 'get_part_side') {
    $id = intval($_POST['id']);
    $q = $db_con->prepare("SELECT side_id, side_name, side_status FROM part_side WHERE side_id = ?");
    $q->bind_param("i", $id);
    $q->execute();
    $res = $q->get_result();
    if ($row = $res->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'data' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Not found.']);
    }
    exit;
}

if ($action === 'update_part_side') {
    $id = intval($_POST['id']);
    $side_name = strtoupper(trim($_POST['side_name']));
    $side_status = $_POST['side_status'];
    
    if (empty($side_name)) {
        echo json_encode(['status' => 'error', 'message' => 'Side Name is required.']);
        exit;
    }

    $stmt = $db_con->prepare("UPDATE part_side SET side_name = ?, side_status = ?, updated_by = ?, updated_date = NOW() WHERE side_id = ?");
    $stmt->bind_param("sssi", $side_name, $side_status, $session_id, $id);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Update failed.']);
    }
    exit;
}
