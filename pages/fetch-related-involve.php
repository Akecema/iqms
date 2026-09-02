<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
file_put_contents("debug_org.txt", print_r($_POST, true));
header('Content-Type: application/json');

// =========================================
// RELATED EPARTMENT
// =========================================
// LIST ALL RELATED DEPARTMNET
if ($_POST['action'] === 'list_RelatedDept') {

    $columns = [
        'c.rd_dept_name',
        'c.rd_dept_status'
    ];

    $sql = "
        SELECT
            c.rd_dept_id,
            c.rd_dept_name,
            c.rd_dept_status,
            d.dept_id,
            d.dept_code,
            d.dept_name,
            d.dept_status
        FROM related_departments c
        LEFT JOIN department d ON c.mast_dept_id = d.dept_id
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            c.rd_dept_name LIKE '%$search%' OR
            d.dept_name LIKE '%$search%' OR
            d.dept_code LIKE '%$search%'
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY c.rd_dept_name ASC ";
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

        $status = ($row['rd_dept_status']) == 'AC' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $checked = ($row["rd_dept_status"] == 'AC') ? 'checked' : '';

        $sub_array = array();
        $sub_array[] = '<span class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['dept_name']. '</h6> 
                            <span class="fs-14" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Deparment">'.$row['rd_dept_name'].'
                            </span>                                                       
                        </span>';
        $sub_array[] = $status; 
        $sub_array[] = '<div class="form-check form-switch">
                            <input class="form-check-input related-toggle" type="checkbox" data-id="'.$row["rd_dept_id"].'" role="switch" id="comp_status" '.$checked.'>
                        </div>';
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

// UPDATE STATUS
if($_POST['action'] == 'update_related_dept') {

    $rel_id = intval($_POST['rel_id']);
    $status = $_POST['status'];   // AC / IN
    $update_by  = $session_id;

    $sql = "
        UPDATE related_departments
        SET rd_dept_status = ?, 
        updated_by = NOW(), 
        updated_date = ?
        WHERE rd_dept_id = ?
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("ssi", $status, $update_by, $rel_id);

    if($stmt->execute()){
        echo json_encode([
            "status"=>"success"
        ]);
    } else {
        echo json_encode([
            "status"=>"error",
            "message"=>"Failed to update"
        ]);
    }

    exit;
}

// ADD RELATED DEPARTMENT
if ($_POST['action'] === 'add_related_dept') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'dept_id' => 'Department',
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
    $dept_id = strtoupper(trim($_POST['dept_id']));
    $dept_status = 'AC';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT mast_dept_id FROM related_departments WHERE mast_dept_id = ?"
    );
    $chk->bind_param("s", $dept_id);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Related department already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================

    //Find dept code
    $sql = "
        SELECT dept_code
        FROM department
        WHERE dept_id = ?
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("s", $dept_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();

    $sql = "
        INSERT INTO related_departments (
            mast_dept_id,
            rd_dept_name,
            rd_dept_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "isss",
        $dept_id,
        $row['dept_code'],
        $dept_status,
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

// =========================================
// VENDOR
// =========================================
// LIST ALL RELATED VENDOR
if ($_POST['action'] === 'list_RelatedVendor') {

    $columns = [
        'c.rv_vendor',
        'c.rv_vendor_name',
        'c.rv_vendor_status'
    ];

    $sql = "
        SELECT
            c.rv_vendor_id,
            c.rv_vendor,
            c.rv_vendor_name,
            c.rv_vendor_status
        FROM related_vendors c
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            c.rv_vendor LIKE '%$search%' OR
            c.rv_vendor_name LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY c.rv_vendor ASC ";
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

        $status = ($row['rv_vendor_status']) == 'AC' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $checked = ($row["rv_vendor_status"] == 'AC') ? 'checked' : '';

        $sub_array = array();
        $sub_array[] = '<span class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['rv_vendor']. '</h6> 
                            <span class="fs-14" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Vendor">'.$row['rv_vendor_name'].'
                            </span>                                                       
                        </span>';
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditVendor" 
                            data-id="'.$row['rv_vendor_id'].'"
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

// GET RECORD
if ($_POST['action'] == 'get_vendor') {

    $vendor_id = intval($_POST['vendor_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            rv_vendor_id, 
            rv_vendor, 
            rv_vendor_name, 
            rv_vendor_status 
        FROM related_vendors 
        WHERE rv_vendor_id = ?
    ");

    $stmt->bind_param("i", $vendor_id);
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
            'message' => 'Vendor not found.'
        ]);
    }

    exit;
}

//UPDATE 
if ($_POST['action'] == 'update_vendor') {

    // Sanitize and retrieve values
    $vendor_id      = intval($_POST['vendor_id']);
    $vendor         = strtoupper(trim($_POST['vendor']));
    $vendor_name    = strtoupper(trim($_POST['vendor_name']));
    $vendor_status  = trim($_POST['vendorStatus']);
    $update_by  = $session_id;

    // Validate required fields (optional but recommended)
    if (empty($vendor_id) || empty($vendor) || empty($vendor_name )) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT rv_vendor_name
                FROM related_vendors 
                WHERE 
                    rv_vendor_name = ? 
                    AND rv_vendor_id != ?
            ");

    $stmt->bind_param("si", $vendor_name, $vendor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate realated vendor found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE related_vendors
                SET 
                    rv_vendor = ?, 
                    rv_vendor_name = ?, 
                    rv_vendor_status = ?,
                    updated_by = ?,
                    updated_date = NOW()
                WHERE rv_vendor_id  = ?
            ");

    $stmt->bind_param("ssssi", $vendor, $vendor_name, $vendor_status, $update_by, $vendor_id);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Related Vendor updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update related vendor. Please try again.'
        ]);
    }

    exit;
}

//ADD
if ($_POST['action'] === 'add_related_vendor') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'vendor' => 'Vendor',
        'vendor_name' => 'Vendor Name'
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
    $vendor = strtoupper(trim($_POST['vendor']));
    $vendor_name = strtoupper(trim($_POST['vendor_name']));
    $vendor_status = 'AC';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT rv_vendor_id FROM related_vendors WHERE rv_vendor_name = ?"
    );
    $chk->bind_param("s", $vendor_name);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Related vendor code already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO related_vendors (
            rv_vendor,
            rv_vendor_name,
            rv_vendor_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "ssss",
        $vendor,
        $vendor_name,
        $vendor_status,
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

// =========================================
// CUSTOMER
// =========================================
// LIST ALL RELATED VENDOR
if ($_POST['action'] === 'list_RelatedCustomer') {

    $columns = [
        'c.rc_cust_name',
        'c.rc_cust_status'
    ];

    $sql = "
        SELECT
            c.rc_cust_id,
            c.rc_cust_name,
            c.rc_cust_status
        FROM related_customers c
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            c.rc_cust_name LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY c.rc_cust_name ASC ";
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

        $status = ($row['rc_cust_status']) == 'AC' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $checked = ($row["rc_cust_status"] == 'AC') ? 'checked' : '';

        $sub_array = array();
        $sub_array[] = '<span class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['rc_cust_name']. '</h6>                                               
                        </span>';
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditCustomer" 
                            data-id="'.$row['rc_cust_id'].'"
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

//UPDATE 
if ($_POST['action'] == 'update_customer') {

    // Sanitize and retrieve values
    $customer_id    = intval($_POST['customer_id']);
    $customer       = strtoupper(trim($_POST['customer']));
    $customer_status  = trim($_POST['customerStatus']);
    $update_by  = $session_id;

    // Validate required fields (optional but recommended)
    if (empty($customer_id) || empty($customer)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT rc_cust_name
                FROM related_customers 
                WHERE 
                    rc_cust_name = ? 
                    AND rc_cust_id != ?
            ");

    $stmt->bind_param("si", $customer, $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate realated customer found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE related_customers
                SET 
                    rc_cust_name = ?, 
                    rc_cust_status = ?,
                    updated_by = ?,
                    updated_date = NOW()
                WHERE rc_cust_id = ?
            ");

    $stmt->bind_param("sssi", $customer, $customer_status, $update_by, $customer_id);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Related Customer updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update related customer. Please try again.'
        ]);
    }

    exit;
}

//ADD
if ($_POST['action'] === 'add_related_customer') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'customer' => 'Customer'
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
    $customer = strtoupper(trim($_POST['customer']));
    $customer_status = 'AC';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT rc_cust_id FROM related_customers WHERE rc_cust_name = ?"
    );
    $chk->bind_param("s", $vendor_name);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Related customer already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO related_customers (
            rc_cust_name,
            rc_cust_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "sss",
        $customer,
        $customer_status,
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
if ($_POST['action'] == 'get_customer') {

    $cust_id = intval($_POST['customer_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            rc_cust_id, 
            rc_cust_name, 
            rc_cust_status 
        FROM related_customers 
        WHERE rc_cust_id = ?
    ");

    $stmt->bind_param("i", $cust_id);
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
            'message' => 'Vendor not found.'
        ]);
    }

    exit;
}

?>
