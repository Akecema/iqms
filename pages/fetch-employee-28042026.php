<?php
session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include 'get-financial-year.php';

header('Content-Type: application/json');

// =========================================
// UPDATE
// =========================================
if($_POST['action'] == 'fetch_employee')
{
    $columns = array('e.staff_name', 'c.company', 'ed.dept_name','');

    $query = "SELECT 
                e.staff_id, e.staff_name, e.short_name, e.identification_no, e.staff_email, 
                c.company_code, c.company, c.code_comp, 
                d.dept_code, d.dept_name, 
                b.branch_name,
                p.photo_name,
                u.account_locked
                FROM employee_details e
                LEFT JOIN employee_photo p ON e.identification_no = p.identification_no
                LEFT JOIN company c ON e.company = c.company_id
                LEFT JOIN branch b ON e.branch = b.branch_id
                LEFT JOIN department d ON e.department = d.dept_id 
                LEFT JOIN user_login u ON e.staff_id = u.staff_id
                WHERE e.account_status = 'AC' ";
    

    if(isset($_POST["search"]["value"]))
    {
        $search = $_POST["search"]["value"];
        $query .= " AND (        
            e.staff_name LIKE '%$search%' OR 
            e.staff_id LIKE '%$search%' OR 
            e.short_name LIKE '%$search%' OR 
            e.staff_email LIKE '%$search%' OR 
            e.identification_no LIKE '%$search%' OR 
            c.company_code LIKE '%$search%' OR 
            c.company LIKE '%$search%' OR  
            c.code_comp LIKE '%$search%' OR 
            b.branch_name LIKE '%$search%' OR 
            d.dept_code LIKE '%$search%' OR 
            d.dept_name LIKE '%$search%'
        ) ";		
    }

    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order']['0']['column'];
        $colDir = $_POST['order']['0']['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= 'ORDER BY e.staff_name ASC';
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

        //photo
        $gst_photo   = $row['photo_name'];

        $photoPath = (!empty($gst_photo) && file_exists("../photo/".$gst_photo))
                        ? "../photo/".$gst_photo
                        : "images/avatar/pic7.jpg";

        $enc_id = base64_encode($row["staff_id"]);

        $sub_array = array();
        $sub_array[] = '<div class="d-flex align-items-center py-2">
                            <div class="d-inline-block position-relative">
                                <img src="'.$photoPath.'" alt="" class="rounded-circle avatar avatar-sm">
                            </div>
                            <a href="javascript:void(0);" class="clearfix ms-2" title="">
                                <h6 class="mb-0 fw-semibold">'.$row["staff_name"].'</h6>
                                <span class="fs-14">'.$row["staff_id"].'</span>
                            </a>
                        </div>'; 
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row["company"].'</h6>
                            <span class="fs-14">'.$row["branch_name"].'</span>
                        </div>'; 
        $sub_array[] = '<div class="d-flex mb-2"><span class="badge badge-rounded badge-dark">'.$row["dept_name"].'</span></div>';
        $locked = $row['account_locked'];
        $lockIcon = ($locked == 'Y') ? 'fa-lock' : 'fa-unlock';
        $lockTitle = ($locked == 'Y') ? 'Unlock Account' : 'Lock Account';
        $lockBtnClass = ($locked == 'Y') ? 'btn-meron' : 'btn-info';

        $sub_array[] = '<a href="employee-edit.php?sid='.$enc_id.'"
                            class="btn btn-rounded btn-primary btn-xxs" data-bs-toggle="tooltip" 
                                data-bs-placement="top" title="View & Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <button type="button" class="btn btn-rounded btn-warning btn-xxs ms-1" 
                                onclick="resetPassword(\''.$row["staff_id"].'\')" data-bs-toggle="tooltip" 
                                data-bs-placement="top" title="Reset Password">
                            <i class="fa fa-key"></i>
                        </button>
                        <button type="button" class="btn btn-rounded '.$lockBtnClass.' btn-xxs ms-1" 
                                onclick="toggleAccountLock(\''.$row["staff_id"].'\', \''.$locked.'\')" data-bs-toggle="tooltip" 
                                data-bs-placement="top" title="'.$lockTitle.'">
                            <i class="fa '.$lockIcon.'"></i>
                        </button>';
        $data[] = $sub_array;
        
    }

    function get_all_data($db_con)
    {
        $query = "SELECT * FROM employee_details WHERE account_status = 'AC'";
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

// =========================================
// SAVE
// =========================================

if ($_POST['action'] == 'add_employee') {

    $chk = $db_con->prepare(
        "SELECT staff_id FROM employee_details WHERE staff_id = ?"
    );
    $chk->bind_param("s", $_POST['staff_id']);
    $chk->execute();

    if ($chk->get_result()->num_rows > 0) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Staff ID already exists.'
        ]);
        exit;
    }

    $sql = "
        INSERT INTO employee_details (
            staff_id,
            staff_name,
            short_name,
            identification_no,
            staff_email,
            company,
            branch,
            compcode,
            compplant,
            division,
            department,
            designation,
            contact_no,
            account_status,
            created_by,
            created_date
        ) VALUES (
            ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, NOW()
        )
    ";

    $stmt = $db_con->prepare($sql);

    $staff_id = strtoupper(trim($_POST['staff_id']));
    $staff_name = strtoupper(trim($_POST['staff_name']));
    $short_name = strtoupper(trim($_POST['short_name']));
    $icno       = trim($_POST['icno']);
    $email      = trim($_POST['staff_email']);

    $company     = (int) $_POST['company'];
    $branch      = (int) $_POST['branch'];
    $department  = (int) $_POST['department'];
    $designation = (int) $_POST['designation'];
    $contactno   = trim($_POST['contact']);
    $account_status = $_POST['account_status'];
    $role = $_POST['role'];
    $created_by  = $session_id;

    //encode staff_id
    $encodestaff_id = base64_encode($staff_id);

    //find compcode & compplant
    $sqlCp = " SELECT code_comp, division_id FROM company
                WHERE company_id = ?";
    $stmtCp = $db_con->prepare($sqlCp);
    $stmtCp->bind_param("i", $company);
    $stmtCp->execute();
    $ccode = $stmtCp->get_result()->fetch_assoc();

    $compcode = $ccode['code_comp'];
    $division = $ccode['division_id'];

    //find branch
    $sqlBc = " SELECT branch_code FROM branch
                WHERE branch_id = ?";
    $stmtBc = $db_con->prepare($sqlBc);
    $stmtBc->bind_param("i", $branch);
    $stmtBc->execute();
    $bplant = $stmtBc->get_result()->fetch_assoc();

    $compplant = ($branch ? $bplant['branch_code'] : '');

    $stmt->bind_param(
        "sssssiissiiisss",
        $staff_id,        // s
        $staff_name,      // s
        $short_name,      // s
        $icno,            // s
        $email,           // s
        $company,         // i
        $branch,          // i
        $compcode,        // s
        $compplant,       // s
        $division,        // i
        $department,      // i
        $designation,     // i
        $contactno,       // s
        $account_status,  // s
        $created_by       // s
    );

    $rowinsert = $stmt->execute();
    $row_id = $db_con->insert_id;

    //Login
    //default password
    $plainPassword = "Qims@user!";   // initial password
    $passwordHash  = password_hash($plainPassword, PASSWORD_DEFAULT);

    $force_change_password = 1;

    $sqlLog = "
            INSERT INTO user_login (
                staff_id,
                username,
                password,
                force_change_password,
                created_by,
                created_date
            ) VALUES (?,?,?,?,?,NOW())
        ";

    $stmtLog = $db_con->prepare($sqlLog);
    $stmtLog->bind_param(
        "sssss",
        $staff_id,
        $staff_id,
        $passwordHash,
        $force_change_password,
        $created_by
    );

    $stmtLog->execute();

    // Approval
    $sqlApp = "
        INSERT INTO employee_approval (
            staff_id,
            appraisor,
            created_by,
            created_date
        ) VALUES (?,?,?, NOW())
    ";

    $stmtApp = $db_con->prepare($sqlApp);

    $approval   = trim($_POST['approval']);

    $stmtApp->bind_param(
        "sss",
        $staff_id,
        $approval,
        $created_by
    );

    $stmtApp->execute();

    //Roles
    $systemid = '2';
    $sqlrole = "
            INSERT INTO user_roles(
                staff_id,
                system_id,
                role,
                created_by,
                created_date
            ) VALUES (?,?,?,?,NOW())
        ";

    $stmtrole = $db_con->prepare($sqlrole);
    $stmtrole->bind_param(
        "ssss",
        $staff_id,
        $systemid,
        $role,
        $created_by
    );

    $stmtrole->execute();

    //Profile picture
    if (!empty($_FILES['photo']['name'])) {

        $uploadDir = "../photo/";
        // $uploadDir = __DIR__ . "/../photo/";

        // ensure folder exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir,0777,true);
        }

        $tmp = $_FILES['photo']['tmp_name'];

        // get extension safely
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));

        // allowed types
        $allowed = ['jpg','jpeg','png','gif'];

        if (in_array($ext,$allowed)) {

            // filename = IC number
            $fileName = $icno . "." . $ext;

            $dest = $uploadDir . $fileName;

            // move physical file
            if (move_uploaded_file($tmp,$dest)) {

                // store in DB table
                $sqlP = "
                    INSERT INTO employee_photo
                    (identification_no, photo_name, created_by, created_date)
                    VALUES (?,?,?,NOW())
                ";

                $stmtP = $db_con->prepare($sqlP);
                $stmtP->bind_param("sss",$icno,$fileName,$created_by);
                $stmtP->execute();
            }
        }
    }

    if ($rowinsert) {
        echo json_encode([
            'status'  => 'success',
            'message' => 'Employee created successfully.',
            'staff_id' => $encodestaff_id
        ]);
    } else {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Insert failed: ' . $stmt->error
        ]);
    }

    exit;

}

// =========================================
// UPDATE
// =========================================

if ($_POST['action'] == 'update_employee') {

    // =========================
    // 1. BASIC SERVER VALIDATION
    // =========================
    $required = [
        'staff_id'     => 'Staff ID',
        'staff_name'   => 'Full Name',
        'short_name'   => 'Short Name',        
        'icno'         => 'Identification No',
        'staff_email'  => 'Email',
        'company'      => 'Company',
        'department'   => 'Department',
        'designation'  => 'Designation',
        'approval'  => 'Approval',
        'role'  => 'Role'
    ];

    foreach ($required as $field => $label) {
        if (empty($_POST[$field])) {
            echo json_encode([
                'status'  => 'error',
                'message' => "$label is required."
            ]);
            exit;
        }
    }

    // Email format validation
    if (!filter_var($_POST['staff_email'], FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Invalid email format.'
        ]);
        exit;
    }


    // =========================
    // 2. UPDATE QUERY
    // =========================

    $staff_name = strtoupper(trim($_POST['staff_name']));
    $short_name = strtoupper(trim($_POST['short_name']));
    $new_ic     = trim($_POST['icno']);
    $email      = trim($_POST['staff_email']);

    $company     = (int) $_POST['company'];
    $branch      = (int) $_POST['branch'];
    $department  = (int) $_POST['department'];
    $designation = (int) $_POST['designation'];
    $contactno   = trim($_POST['contact']);
    $updated_by  = $session_id;
    $staff_id    = $_POST['staff_id'];
    $email       = $_POST['staff_email'];
    $role       = $_POST['role'];
    $account_status  = $_POST['account_status'];
    
    //find compcode & compplant
    $sqlCp = " SELECT code_comp, division_id FROM company
                WHERE company_id = ?";
    $stmtCp = $db_con->prepare($sqlCp);
    $stmtCp->bind_param("i", $company);
    $stmtCp->execute();
    $ccode = $stmtCp->get_result()->fetch_assoc();

    $compcode = $ccode['code_comp'];
    $division = $ccode['division_id'];

    //find branch
    $sqlBc = " SELECT branch_code FROM branch
                WHERE branch_id = ?";
    $stmtBc = $db_con->prepare($sqlBc);
    $stmtBc->bind_param("i", $branch);
    $stmtBc->execute();
    $bplant = $stmtBc->get_result()->fetch_assoc();

    $compplant = ($branch ? $bplant['branch_code'] : '');

    $sql = "
        UPDATE employee_details SET
            staff_name   = ?,
            short_name   = ?,
            staff_email  = ?,
            company      = ?,
            branch       = ?,
            compcode     = ?,
            compplant    = ?,
            division     = ?,
            department   = ?,
            designation  = ?,
            contact_no   = ?,
            account_status    = ?, 
            updated_by   = ?,
            updated_date = NOW()
        WHERE staff_id = ?
    ";

    $stmt = $db_con->prepare($sql);
    
    $stmt->bind_param(
        "sssiiiiiiissss",
            $staff_name,     // s
            $short_name,     // s
            $email,          // s
            $company,        // i
            $branch,         // i
            $compcode,       // i
            $compplant,      // i
            $division,       // i
            $department,     // i
            $designation,    // i
            $contactno,      // s
            $account_status, // s
            $updated_by,     // s
            $staff_id        // s
    );    

    $rowedit = $stmt->execute();

    if (!$stmt) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Prepare failed: ' . $db_con->error
        ]);
        exit;
    }

    // Approval
    $sqlApp = "
        UPDATE employee_approval SET
            appraisor    = ?,
            updated_by   = ?,
            updated_date = NOW()
        WHERE staff_id = ?
    ";

    $stmtApp = $db_con->prepare($sqlApp);

    if (!$stmtApp) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Prepare failed: ' . $db_con->error
        ]);
        exit;
    }

    $approval   = trim($_POST['approval']);
    $updated_by  = $session_id;
    $staff_id    = $_POST['staff_id'];

    $stmtApp->bind_param(
        "sss",
            $approval,     // s
            $updated_by,     // s
            $staff_id        // s
    );
    $stmtApp->execute();

    //Role
    $sqlRole = "
                UPDATE user_roles SET
                    role    = ?,
                    updated_by   = ?,
                    updated_date = NOW()
                WHERE staff_id = ?
            ";

    $stmtRole = $db_con->prepare($sqlRole);

    if (!$stmtRole) {
        echo json_encode([
            'status'  => 'error',
            'message' => 'Prepare failed: ' . $db_con->error
        ]);
        exit;
    }

    $stmtRole->bind_param(
        "sss",
            $role ,     // s
            $updated_by,     // s
            $staff_id        // s
    );
    $stmtRole->execute();

    // =========================
    // 3. IF CHANGE IC NO, RENAME PHOTO AS WELL
    // =========================
    
    // 0. Get existing IC + photo filename
    $sqlOld = "
        SELECT ed.identification_no, ep.photo_name
        FROM employee_details ed
        LEFT JOIN employee_photo ep 
            ON ed.identification_no = ep.identification_no
        WHERE ed.staff_id = ?
    ";

    $stmtOld = $db_con->prepare($sqlOld);
    $stmtOld->bind_param("s", $_POST['staff_id']);
    $stmtOld->execute();
    $old = $stmtOld->get_result()->fetch_assoc();

    $old_ic   = trim($old['identification_no']);
    $old_file = trim($old['photo_name']);

    if ($old_ic !== $new_ic && !empty($old_file)) {

        $photoDir = "../photo/";

        $oldPath = $photoDir . $old_file;

        // keep file extension (jpg/png etc)
        $ext = pathinfo($old_file, PATHINFO_EXTENSION);

        $new_file = $new_ic . "." . $ext;
        $newPath = $photoDir . $new_file;

        // Only rename if file really exists
        if (file_exists($oldPath)) {

            if (rename($oldPath, $newPath)) {

                // update DB photo_name
                $sqlU = "
                    UPDATE employee_photo 
                    SET identification_no = ?, photo_name = ?
                    WHERE identification_no = ?
                ";

                $stmtU = $db_con->prepare($sqlU);
                $stmtU->bind_param("sss", $new_ic, $new_file, $old_ic);
                $stmtU->execute();
            }
        }

        $sqlic = "
            UPDATE employee_details SET
                identification_no   = ?
                    WHERE staff_id = ?
        ";

        $stmtic = $db_con->prepare($sqlic);        
        $stmtic->bind_param("ss", $new_ic, $staff_id );  
        $stmtic->execute();
    }

    // =========================
    // 4. UPLOAD PHOTO
    // =========================    
    
    $uploadDir = "../photo/";

    if(isset($_FILES['photo']) && $_FILES['photo']['error'] == 0){

        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);

        $newFile = $new_ic . "." . strtolower($ext);
        $target = $uploadDir . $newFile;

        // delete old photo if exists
        $sqlPic = "SELECT photo_name FROM employee_photo WHERE identification_no = ?";
        $stmtPic = $db_con->prepare($sqlPic);
        $stmtPic->bind_param("s",$new_ic);
        $stmtPic->execute();
        $old = $stmtPic->get_result()->fetch_assoc();

        if(!empty($old['photo_name'])){
            $oldPath = $uploadDir.$old['photo_name'];
            if(file_exists($oldPath)) unlink($oldPath);
        }

        // move uploaded
        move_uploaded_file($_FILES['photo']['tmp_name'], $target);

        // insert / update table
        $sqlUp = "
            INSERT INTO employee_photo (identification_no, photo_name)
            VALUES (?,?)
            ON DUPLICATE KEY UPDATE 
                photo_name = VALUES(photo_name)
        ";

        $stmtUp = $db_con->prepare($sqlUp);
        $stmtUp->bind_param("ss",$new_ic,$newFile);
        $stmtUp->execute();
    }

    // =========================
    // 5. EXECUTE & RESPOND
    // =========================
    if ($rowedit) {

        echo json_encode([
            'status'  => 'success',
            'message' => 'Employee updated successfully.'
        ]);

    } else {

        echo json_encode([
            'status'  => 'error',
            'message' => 'Update failed. Please try again.'
        ]);
    }

    if (!in_array($_POST['account_status'], ['AC','IN'])) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid account status.'
        ]);
        exit;
    }   
    exit;
}

// =========================
// 2. GET AUTHORIZATION
// =========================
if ($_POST['action'] === 'get_authorization') {

    header('Content-Type: application/json');

    $staff_id = $_POST['staff_id'] ?? '';

    if (!$staff_id) {
        echo json_encode(['status'=>'error','message'=>'Staff ID missing']);
        exit;
    }

    $sql = "
        SELECT
            PDI_reviewer,
            SR_reviewer,
            S2W_reviewer,
            S2W_approver,
            S2W_acknowledger
        FROM user_authorization
        WHERE staff_id = ?
        LIMIT 1
    ";

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("s", $staff_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        echo json_encode([
            'status' => 'success',
            'data'   => $res->fetch_assoc()
        ]);
    } else {
        echo json_encode([
            'status' => 'empty',   // no authorization yet
            'data'   => []
        ]);
    }
    exit;
}

// =========================================
// AUTHORIZATION
// =========================================

//Add
if ($_POST['action'] === 'add_authorization') {

    $sql = "
        INSERT INTO user_authorization (
            staff_id,
            PDI_reviewer,
            SR_reviewer,
            S2W_reviewer,
            S2W_approver,
            S2W_acknowledger,
            created_by,
            created_date
        ) VALUES (?,?,?,?,?,?,?,NOW())
    ";

    $stmt = $db_con->prepare($sql);

    $stmt->bind_param(
        "sssssss",
        $_POST['staff_id'],
        $_POST['PDI_reviewer'],
        $_POST['SR_reviewer'],
        $_POST['S2W_reviewer'],
        $_POST['S2W_approver'],
        $_POST['S2W_acknowledger'],
        $session_id
    );

    if ($stmt->execute()) {
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error','message'=>$stmt->error]);
    }
    exit;
}

// Update
if ($_POST['action'] === 'update_authorization') {

    $sql = "
        UPDATE user_authorization
        SET
            PDI_reviewer = ?,
            SR_reviewer = ?,
            S2W_reviewer = ?,
            S2W_approver = ?,
            S2W_acknowledger = ?,
            updated_by = ?,
            updated_date = NOW()
        WHERE staff_id = ?
    ";

    $stmt = $db_con->prepare($sql);

    $stmt->bind_param(
        "sssssss",
        $_POST['PDI_reviewer'],
        $_POST['SR_reviewer'],
        $_POST['S2W_reviewer'],
        $_POST['S2W_approver'],
        $_POST['S2W_acknowledger'],
        $session_id,
        $_POST['staff_id']
    );

    if ($stmt->execute()) {
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error','message'=>$stmt->error]);
    }
    exit;
}


if ($_POST['action'] === 'reset_password') {
    $staff_id = $_POST['staff_id'];
    $newPassword = "Qims@user!";
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = "UPDATE user_login SET 
                password = ?, 
                force_change_password = 1,
                change_password = 'Y',
                change_password_date = NOW(),
                updated_date = NOW()
            WHERE staff_id = ?";
    
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("ss", $hashedPassword, $staff_id);

    //clear form tbl failed login
    $sqlU = "DELETE FROM user_failedlogin WHERE username = ?";
    $stmtU = $db_con->prepare($sqlU);
    $stmtU->bind_param("s", $staff_id);
    $stmtU->execute();
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Password reset to default (Qims@user!) successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to reset password: ' . $stmt->error]);
    }
    exit;
}

if ($_POST['action'] === 'toggle_lock') {
    $staff_id = $_POST['staff_id'];
    $current_status = $_POST['current_status'];
    $new_status = ($current_status === 'Y') ? 'N' : 'Y';
    // $session_id is already defined in session-login.php

    if ($new_status === 'Y') {
        $sql = "UPDATE user_login SET 
                    account_locked = 'Y',
                    locked_date = NOW(),
                    locked_by = ?
                WHERE staff_id = ?";
    } else {
        $sql = "UPDATE user_login SET 
                    account_locked = 'N',
                    unlocked_date = NOW(),
                    unlocked_by = ?
                WHERE staff_id = ?";
    }

    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("ss", $session_id, $staff_id);

    //clear failed login
    $del = $db_con->prepare("
                    DELETE FROM user_failedlogin
                    WHERE username = ?
            ");
    $del->bind_param("s", $staff_id);
    $del->execute();

    if ($stmt->execute()) {
        $msg = ($new_status === 'Y') ? 'Account locked successfully.' : 'Account unlocked successfully.';
        echo json_encode(['status' => 'success', 'message' => $msg]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update account status: ' . $stmt->error]);
    }
    exit;
}


