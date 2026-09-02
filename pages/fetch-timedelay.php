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
if ($_POST['action'] === 'list_timedelay') {

    $columns = [
        'c.task',
        'c.process',
        'c.delay_day'

    ];

    $sql = "
        SELECT
            c.delayid,
            c.task,
            c.task_name,
            c.process,
            c.delay_day
        FROM time_delay c
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            c.task LIKE '%$search%' OR
            c.process LIKE '%$search%' OR
            c.delay_day LIKE '%$search%'
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $col = $_POST['order'][0]['column'];
        $dir = $_POST['order'][0]['dir'];
        $sql .= " ORDER BY {$columns[$col]} $dir ";
    } else {
        $sql .= " ORDER BY c.delayid ASC ";
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
                            data-bs-placement="top" title="">
                            '.$row['task_name']. '
                        </span> ';
        $sub_array[] = '<span class="clearfix" title="">
                            <span class="fs-14">'.ucwords($row['process']). '</span> 
                            <h6 class="mb-0 fw-semibold me-3"></h6>
                        </span>';
       $sub_array[] = '<input type="number" 
                            class="form-control delay-days"
                            min="0" step="1"
                            data-id="'.$row['delayid'].'" 
                            value="'.$row['delay_day'].'">';
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
if ($_POST['action'] == 'update_day') {

    $task_id = intval($_POST['task_id']);
    $delay_day = intval($_POST['delay_day']);

    $stmt = $db_con->prepare("
        UPDATE time_delay
        SET delay_day = ?, updated_by = ?, updated_date = NOW()
        WHERE delayid = ?
    ");

    $stmt->bind_param("isi", $delay_day, $session_id, $task_id);

    if($stmt->execute()){
        echo json_encode(['status'=>'success']);
    } else {
        echo json_encode(['status'=>'error','message'=>'Update failed']);
    }

    exit;
}

?>