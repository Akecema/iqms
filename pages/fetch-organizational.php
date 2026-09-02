<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
file_put_contents("debug_org.txt", print_r($_POST, true));
header('Content-Type: application/json');

// =========================================
// COMPANY
// =========================================
// LIST ALL COMPANY
if ($_POST['action'] === 'list_company') {

    $columns = [
        'c.company',
        'c.code_comp',
        'd.division'
    ];

    $sql = "
        SELECT
            c.company_id,
            c.company_code,
            c.company,
            c.code_comp,
            c.company_status,
            d.division,
            t.country,
            (  SELECT COUNT(*) 
                FROM branch AS b2 
                WHERE b2.branch_co_id = c.company_id
            )   AS branch_count
        FROM company c
        LEFT JOIN division d ON c.division_id = d.division_id
        LEFT JOIN country t ON c.country_id = t.country_id
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            c.company LIKE '%$search%' OR
            c.code_comp LIKE '%$search%' OR
            d.division LIKE '%$search%'
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY c.company ASC ";
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

        $status = ($row['company_status']) == 'AC' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $badgecolor = $row["branch_count"] != 0 ? "badge-secondary" : "badge-dark";

        $disablebranch = !empty($row['branch_id']) ? "" : "disabled";

        $sub_array = array();
        $sub_array[] = '<span class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['company']. '</h6> 
                            <span class="fs-14" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Company Code">'.$row['code_comp'].'
                            </span>                                                       
                        </span>'; 
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row['division'].'</h6>
                            <span class="fs-14" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Country">'.$row['country'].'</span>
                        </div>'; 
        $sub_array[] = '
                    <div class="d-flex justify-content-center mb-2">
                        <span class="badge badge-rounded '.$badgecolor.' branch-badge" 
                            data-company="'.$row["company_id"].' >
                            <span class="fs-14"  data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="View Branch">
                            '.$row["branch_count"].'
                            </span>  
                        </span>
                    </div>';
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditCompany" 
                            data-id="'.$row['company_id'].'"
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

// ADD COMPANY
if ($_POST['action'] === 'add_company') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'company_code' => 'Company Code',
        'company_name' => 'Company Name',
        'code_comp'    => 'Code Company',
        'division_id'  => 'Division',
        'country_id'   => 'Country'
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
    $company_code = strtoupper(trim($_POST['company_code']));
    $company_name = strtoupper(trim($_POST['company_name']));
    $code_comp    = (int) $_POST['code_comp'];
    $division_id  = (int) $_POST['division_id'];
    $country_id   = $_POST['country_id'];
    $company_status = 'AC';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT company_id FROM company WHERE company_code = ?"
    );
    $chk->bind_param("s", $company_code);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Company code already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO company (
            company_code,
            company,
            code_comp,
            division_id,
            country_id,
            company_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?,?,?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "ssiiiss",
        $company_code,
        $company_name,
        $code_comp,
        $division_id,
        $country_id,
        $company_status,
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
if ($_POST['action'] == 'get_company') {

    $company_id = intval($_POST['company_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            company_id, 
            company_code, 
            company, 
            code_comp, 
            division_id, 
            country_id 
        FROM company 
        WHERE company_id = ?
    ");

    $stmt->bind_param("i", $company_id);
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
            'message' => 'Company not found.'
        ]);
    }

    exit;
}

//UPDATE 
if ($_POST['action'] == 'update_company') {

    // Sanitize and retrieve values
    $company_id      = intval($_POST['company_id']);
    $company_code    = strtoupper(trim($_POST['company_code']));
    $company_name    = strtoupper(trim($_POST['company_name']));
    $code_comp       = trim($_POST['code_comp']);
    $division_id     = intval($_POST['division_id']);
    $country_id      = intval($_POST['country_id']);
    $company_status  = trim($_POST['compStatus']);

    // Validate required fields (optional but recommended)
    if (empty($company_id) || empty($company_code) || empty($company_name || empty($code_comp) )) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT company_id 
                FROM company 
                WHERE 
                    (company_code = ? OR company = ? OR code_comp = ?) 
                    AND company_id != ?
            ");

    $stmt->bind_param("sssi", $company_code, $company_name, $code_comp, $company_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate company code, name, or code_comp found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE company 
                SET 
                    company_code = ?, 
                    company = ?, 
                    code_comp = ?, 
                    division_id = ?, 
                    country_id = ?,
                    company_status = ?
                WHERE company_id = ?
            ");

    $stmt->bind_param("sssiisi", $company_code, $company_name, $code_comp, $division_id, $country_id, $company_status, $company_id);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Company updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update company. Please try again.'
        ]);
    }

    exit;
}

// =========================================
// DEPARTMENT
// =========================================
if ($_POST['action'] === 'list_department') {

    $columns = [
        'd.dept_code',
        'd.dept_name'
    ];

    $sql = "
        SELECT
            d.dept_id,
            d.dept_code,
            d.dept_name,
            d.dept_status
        FROM department d
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            d.dept_code LIKE '%$search%' OR
            d.dept_name LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY d.dept_name ASC ";
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

        $status = ($row['dept_status']) == 'AC' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $sub_array = array();
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['dept_name']. '</h6>                       
                        </a>'; 
        $sub_array[] = $row['dept_code']; 
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditDepartment" 
                            data-id="'.$row['dept_id'].'"
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

// ADD DEPARTMENT
if ($_POST['action'] === 'add_department') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'dept_code' => 'Department Code',
        'dept_name' => 'Department Name'
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
    $department_code = strtoupper(trim($_POST['dept_code']));
    $department_name = strtoupper(trim($_POST['dept_name']));
    $department_status = 'AC';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT dept_id FROM department WHERE dept_code = ?"
    );
    $chk->bind_param("s", $department_code);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Department code already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO department (
            dept_code,
            dept_name,
            dept_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "ssss",
        $department_code,
        $department_name,
        $department_status,
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
if ($_POST['action'] == 'get_department') {

    $department_id = intval($_POST['department_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            dept_id, 
            dept_code,
            dept_name,
            dept_status
        FROM department
        WHERE dept_id = ?
    ");

    $stmt->bind_param("i", $department_id);
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
            'message' => 'Department not found.'
        ]);
    }

    exit;
}

//UPDATE 
if ($_POST['action'] == 'update_department') {

    // Sanitize and retrieve values
    $department_id      = intval($_POST['department_id']);
    $department_code    = strtoupper(trim($_POST['department_code']));
    $department_name    = strtoupper(trim($_POST['department_name']));
    $department_status  = trim($_POST['deptStatus']);

    // Validate required fields (optional but recommended)
    if (empty($department_id) || empty($department_code) || empty($department_name )) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT dept_id 
                FROM department 
                WHERE 
                    (dept_code = ? OR dept_name = ? ) 
                    AND dept_id != ?
            ");

    $stmt->bind_param("ssi", $department_code, $department_name, $department_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate department code, department name found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE department 
                SET 
                    dept_code = ?, 
                    dept_name = ?, 
                    dept_status = ?
                WHERE dept_id = ?
            ");

    $stmt->bind_param("sssi", $department_code, $department_name, $department_status, $department_id);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Department updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update department. Please try again.'
        ]);
    }

    exit;
}

// =========================================
// DESIGNATION
// =========================================
if ($_POST['action'] === 'list_designation') {

    $columns = [
        'd.design_name'
    ];

    $sql = "
        SELECT
            d.design_id,
            d.design_name,
            d.design_status
        FROM designation d
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            d.design_name LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY d.design_name ASC ";
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

        $status = ($row['design_status']) == 'AC' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $sub_array = array();
        $sub_array[] = '<a href="javascript:void(0);" class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['design_name']. '</h6>                       
                        </a>'; 
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditDesignation" 
                            data-id="'.$row['design_id'].'"
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

if ($_POST['action'] === 'add_designation') {

    header('Content-Type: application/json');

    // =========================
    // VALIDATION
    // =========================
    $required = [
        'design_name' => 'Designation Name'
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
    $designation_name = strtoupper(trim($_POST['design_name']));
    $designation_status = 'AC';
    $created_by  = $session_id;

    // =========================
    // DUPLICATE CHECK
    // =========================
    $chk = $db_con->prepare(
        "SELECT design_id FROM designation WHERE design_name = ?"
    );
    $chk->bind_param("s", $designation_code);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Designation code already exists.'
        ]);
        exit;
    }

    // =========================
    // INSERT
    // =========================
    $sql = "
        INSERT INTO designation (
            design_name,
            design_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param(
        "sss",
        $designation_name,
        $designation_status,
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
if ($_POST['action'] == 'get_designation') {

    $designation_id = intval($_POST['designation_id']);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            design_id, 
            design_name,
            design_status
        FROM designation
        WHERE design_id = ?
    ");

    $stmt->bind_param("i", $designation_id);
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
            'message' => 'Designation not found.'
        ]);
    }

    exit;
}

//UPDATE 
if ($_POST['action'] == 'update_designation') {

    // Sanitize and retrieve values
    $designation_id      = intval($_POST['designation_id']);
    $designation_name    = strtoupper(trim($_POST['designation_name']));
    $designation_status  = strtoupper(trim($_POST['designStatus']));

    // Validate required fields (optional but recommended)
    if (empty($designation_id) || empty($designation_name )) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Missing required fields.'
        ]);
        exit;
    }

    // Check for duplicates
    $stmt = $db_con->prepare("
                SELECT design_id 
                FROM designation
                WHERE 
                    (design_name = ?) 
                    AND design_id != ?
            ");

    $stmt->bind_param("si", $designation_name, $designation_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Duplicate designation name found.'
        ]);
        exit;
    }

    // Prepare UPDATE query
    $stmt = $db_con->prepare("
                UPDATE designation 
                SET 
                    design_name = ?, 
                    design_status = ?
                WHERE design_id = ?
            ");

    $stmt->bind_param("ssi", $designation_name, $designation_status, $designation_id);

    // Execute query
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Designation updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update designation. Please try again.'
        ]);
    }

    exit;
}


?>
