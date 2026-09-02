<?php
error_reporting(E_ALL);
ini_set('display_errors', 1); // Turn this off once fixed
ini_set('log_errors', 1);
ini_set('error_log','php_error.log');
session_start();
include '../db/db_connect.php';
include 'session-login.php';

// Suppress errors for debug file writing to prevent breaking JSON response
//@file_put_contents("debug_org.txt", print_r($_POST, true));

header('Content-Type: application/json');

// =========================================
// MODEL
// =========================================
if ($_POST['action'] === 'list_material') {

    // Define columns to match the table headers in material-list.php
    // Index matches the column index sent by DataTables
    $columns = [
        0 => 'h.matno',      // Part No
        1 => 'm.modcode',    // Model
        2 => 't.typemodel',  // Type
        3 => 'h.matstatus',  // Status
        4 => 'h.matid'       // Action (using ID as placeholder for sorting if clicked)
    ];

    $sql = "
        SELECT
            h.matid,
            h.matno,
            h.matdesc,
            h.modelid,
            h.matstatus,
            h.partside,
            m.modcode,
            t.typemodel,
            (
                SELECT COUNT(*)
                FROM material_details s
                WHERE s.mathdr = h.matid
            ) AS sub_count
        FROM material_header h
        LEFT JOIN model_details m ON h.modelid = m.modid
        LEFT JOIN model_type t ON h.typeid = t.typeid
        WHERE 1=1
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            h.matno LIKE '%$search%' OR
            h.matdesc LIKE '%$search%' OR
            m.modcode LIKE '%$search%'  
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $colIndex = intval($_POST['order'][0]['column']);
        $dir = ($_POST['order'][0]['dir'] === 'asc') ? 'ASC' : 'DESC';
        
        if (isset($columns[$colIndex])) {
            $sql .= " ORDER BY {$columns[$colIndex]} $dir ";
        } else {
            $sql .= " ORDER BY h.matno ASC ";
        }
    } else {
        $sql .= " ORDER BY h.matno ASC ";
    }

    // PAGINATION
    $limit = "";
    if (isset($_POST['length']) && $_POST['length'] != -1) {
        $start = intval($_POST['start']);
        $length = intval($_POST['length']);
        $limit = " LIMIT $start, $length ";
    }

    $queryTotal = $db_con->query($sql);
    if (!$queryTotal) {
        echo json_encode(["error" => "Total query failed: " . $db_con->error]);
        exit;
    }
    
    $recordsFiltered = $queryTotal->num_rows;

    // For recordsTotal, we need count without filters
    $sqlTotalAll = "SELECT COUNT(*) as total FROM material_header";
    $resTotalAll = $db_con->query($sqlTotalAll);
    $rowTotalAll = $resTotalAll ? $resTotalAll->fetch_assoc() : ['total' => $recordsFiltered];
    $recordsTotal = intval($rowTotalAll['total'] ?? $recordsFiltered);

    $queryData  = $db_con->query($sql . $limit);
    if (!$queryData) {
        echo json_encode(["error" => "Data query failed: " . $db_con->error]);
        exit;
    }

    $data = array();
    while ($row = $queryData->fetch_assoc()) {

        $status = ($row['matstatus']) == 'Y' ? 
                    '<span class="badge badge-rounded badge-dark fs-14 me-2" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Active">AC </span>' : 
                    '<span class="badge badge-rounded badge-meron fs-14 me-2"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Inactive">IN</span>';

        $sub_array = array();
        
        $sub_array[] = '<span class="clearfix ms-2 mb-4" title="">
                            <h6 class="mb-0 fw-semibold" data-matid="'.$row['matid'].'" data-bs-toggle="tooltip" data-bs-placement="top" title="">
                            '.$row['matno']. '
                            </h6>

                            <span class="fs-14" data-matid="'.$row['matid'].'" 
                                data-bs-toggle="tooltip" data-bs-placement="top" title="Part Name">'.$row['matdesc'].'
                            </span>                                                       
                        </span> <br>
                        <span class="mt-4"><i class="fa fa-sliders"></i> Loose Parts : '.$row['sub_count'].'</span>'; 
        $sub_array[] = '<span class="fs-14" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Part Name">'.$row['modcode'].'
                            </span>'; 
        $sub_array[] = '<span class="clearfix ms-2" title="">
                            <h6 class="mb-0 fw-semibold me-3">'.$row['typemodel']. '</h6> 
                            <span class="fs-14" data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Part Name">'.$row['partside'].'
                            </span>                                                       
                        </span>';
        $sub_array[] = $status; 
        $sub_array[] = '<button type="button"
                            class="btn btn-rounded btn-primary btn-xxs btnEditMaterial" 
                            data-id="'.$row['matid'].'"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Edit">
                            <i class="fa fa-edit"></i>
                        </button>
                        <button type="button" class="btn btn-rounded btn-info btn-xxs btnUploadGallery ms-1"
                            data-id="'.$row['matid'].'"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="Upload Gallery">
                            <i class="fa fa-upload"></i>
                        </button>
                        <button type="button" class="btn btn-rounded btn-warning btn-xxs btnViewImages ms-1"
                            data-id="'.$row['matid'].'"
                            data-bs-toggle="tooltip" 
                            data-bs-placement="top" title="View Images">
                            <i class="fa fa-image"></i>
                        </button>';
        $data[] = $sub_array;
        
    }

    echo json_encode([
        "draw"            => isset($_POST["draw"]) ? intval($_POST["draw"]) : 0,
        "recordsTotal"    => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data"            => $data
    ]);
    exit;
}

// ADD NEW MATERIAL
if ($_POST['action'] == 'add_material') {
    
    $matno   = strtoupper(trim($_POST['matno'] ?? ''));
    $matdesc = strtoupper(trim($_POST['matdesc'] ?? ''));
    $modelid = intval($_POST['modelid'] ?? 0);
    $typeid  = intval($_POST['typeid'] ?? 0);
    $partside = strtoupper(trim($_POST['partside'] ?? ''));
    $matcustomer = intval($_POST['matcustomer'] ?? 0);
    
    // Default values
    $compcd = '3100';
    $plant  = '3100';
    $bun    = 'PCS';
    $matstatus = 'Y';
    $created_by = $session_id;

    if (empty($matno) || empty($matdesc) || empty($modelid) || empty($typeid) || empty($matcustomer)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Check duplicate Part No
    $chk = $db_con->prepare("SELECT matid FROM material_header WHERE matno = ?");
    $chk->bind_param("s", $matno);
    $chk->execute();
    if($chk->get_result()->num_rows > 0){
        echo json_encode(['status' => 'error', 'message' => 'Part No already exists.']);
        exit;
    }

    // Get Model details (code, compcd, plant)
    $q_mod = $db_con->query("SELECT modcode, compcd, plant FROM model_details WHERE modid = '$modelid'");
    $r_mod = $q_mod->fetch_assoc();
    $modcode = $r_mod['modcode'] ?? '';
    // Use model's compcd/plant if available, else default
    if(!empty($r_mod['compcd'])) $compcd = $r_mod['compcd'];
    if(!empty($r_mod['plant']))  $plant  = $r_mod['plant'];

    // Get Type details
    $q_type = $db_con->query("SELECT typemodel FROM model_type WHERE typeid = '$typeid'");
    $r_type = $q_type->fetch_assoc();
    $typemodel = $r_type['typemodel'] ?? '';

    $stmt = $db_con->prepare("INSERT INTO material_header (matno, matdesc, modelid, modelcode, typeid, type, compcd, plant, BUn, matstatus, partside, matcustomer, created_by, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssisissssssss", $matno, $matdesc, $modelid, $modcode, $typeid, $typemodel, $compcd, $plant, $bun, $matstatus, $partside, $matcustomer, $created_by);

    if ($stmt->execute()) {
        $matid = $db_con->insert_id;

        // Auto create folder
        $folder_path = __DIR__ . "/gallery/model/" . $modcode . "/" . $matid;
        if (!is_dir($folder_path)) {
            mkdir($folder_path, 0777, true);
        }

        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    exit;
}

// GET RECORD
if (isset($_POST['action']) && $_POST['action'] == 'get_material') {

    $material_id = intval($_POST['material_id'] ?? 0);

    // Prepare your SELECT query
    $stmt = $db_con->prepare("
        SELECT 
            matid, 
            matno,
            matdesc,
            modelid,
            typeid,
            matstatus,
            partside
        FROM material_header
        WHERE matid = ?
    ");

    $stmt->bind_param("i", $material_id);
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
            'message' => 'Material not found.'
        ]);
    }

    exit;
}

// UPDATE
if ($_POST['action'] == 'update_material') {
    
    $matid   = intval($_POST['matid'] ?? 0);
    $matno   = strtoupper(trim($_POST['matno'] ?? ''));
    $matdesc = strtoupper(trim($_POST['matdesc'] ?? ''));
    $modelid = intval($_POST['modelid'] ?? 0);
    $typeid  = intval($_POST['typeid'] ?? 0);
    $partside = strtoupper(trim($_POST['partside'] ?? ''));
    $matstatus = trim($_POST['matstatus'] ?? '');

    if (empty($matid) || empty($matno)) {
        echo json_encode(['status' => 'error', 'message' => 'Material ID and Part No are required.']);
        exit;
    }

    // Check duplicate Part No
    $chk = $db_con->prepare("SELECT matid FROM material_header WHERE matno = ? AND matid != ?");
    $chk->bind_param("si", $matno, $matid);
    $chk->execute();
    if($chk->get_result()->num_rows > 0){
        echo json_encode(['status' => 'error', 'message' => 'Part No already exists.']);
        exit;
    }

    // Get Modcode
    $q_mod = $db_con->query("SELECT modcode FROM model_details WHERE modid = '$modelid'");
    $r_mod = $q_mod->fetch_assoc();
    $modcode = $r_mod['modcode'] ?? '';

    // Get Type
    $q_type = $db_con->query("SELECT typemodel FROM model_type WHERE typeid = '$typeid'");
    $r_type = $q_type->fetch_assoc();
    $typemodel = $r_type['typemodel'] ?? '';

    // $stmt = $db_con->prepare("UPDATE material_header SET matno=?, matdesc=?, modelid=?, typeid=?, matstatus=?, partside=?,modelcode=?, type=?, updated_by=?, updated_date = NOW()
    //                             WHERE matid=?");
    // $stmt->bind_param("ssiisssssi", $matno, $matdesc, $modelid, $typeid, $matstatus, $partside, $modcode, $typemodel, $session_id, $matid);

    $stmt = $db_con->prepare("UPDATE material_header SET matno=?, matdesc=?, modelid=?, modelcode=?, typeid=?, type=?, matstatus=?, partside=?, updated_by=?, updated_date = NOW()
                                WHERE matid=?");
    $stmt->bind_param("ssisissssi", $matno, $matdesc, $modelid, $modcode, $typeid, $typemodel, $matstatus, $partside, $session_id, $matid);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    exit;
}

// ===============================
// SUB MATERIAL / BOM LIST
// ===============================

// ADD NEW BOM
if ($_POST['action'] == 'add_bom') {
    
    $matid   = intval($_POST['matid'] ?? 0);
    $bom     = strtoupper(trim($_POST['bom'] ?? ''));
    $bomdesc = strtoupper(trim($_POST['bomdesc'] ?? ''));
    
    // Default values
    $bomstatus = 'Y';
    $created_by = $session_id;

    if ($matid <= 0 || empty($bom) || empty($bomdesc)) {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
        exit;
    }

    // Get Parent Details (compcd, plant)
    // We assuming default 3100 if missing or fetch from material_header
    $compcd = '3100';
    $plant  = '3100';
    
    $q_hdr = $db_con->query("SELECT compcd, plant FROM material_header WHERE matid = '$matid'");
    if($r_hdr = $q_hdr->fetch_assoc()){
        if(!empty($r_hdr['compcd'])) $compcd = $r_hdr['compcd'];
        if(!empty($r_hdr['plant']))  $plant  = $r_hdr['plant'];
    }

    // Insert
    $stmt = $db_con->prepare("INSERT INTO material_details (mathdr, bom, bomdesc, compcd, plant, bomstatus, created_by, created_date) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("isssssi", $matid, $bom, $bomdesc, $compcd, $plant, $bomstatus, $created_by);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    exit;
}

// GET BOM RECORD
if ($_POST['action'] == 'get_bom') {

    $matdet_id = intval($_POST['matdet_id'] ?? 0);

    $stmt = $db_con->prepare("
        SELECT 
            matdet_id, 
            bom,
            bomdesc,
            bomstatus
        FROM material_details
        WHERE matdet_id = ?
    ");
    $stmt->bind_param("i", $matdet_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode([
            'status' => 'success',
            'data' => $row
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'BOM not found.'
        ]);
    }
    exit;
}

// UPDATE BOM
if ($_POST['action'] == 'update_bom') {
    
    $matdet_id = intval($_POST['matdet_id'] ?? 0);
    $bom       = strtoupper(trim($_POST['bom'] ?? ''));
    $bomdesc   = strtoupper(trim($_POST['bomdesc'] ?? ''));
    $bomstatus = trim($_POST['bomstatus'] ?? '');
    
    $updated_by = $session_id;

    if (empty($matdet_id) || empty($bom) || empty($bomdesc)) {
        echo json_encode(['status' => 'error', 'message' => 'Required fields missing.']);
        exit;
    }

    $stmt = $db_con->prepare("UPDATE material_details SET bom=?, bomdesc=?, bomstatus=?, updated_by=?, updated_date=NOW() WHERE matdet_id=?");
    $stmt->bind_param("sssii", $bom, $bomdesc, $bomstatus, $updated_by, $matdet_id);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $stmt->error]);
    }
    exit;
}

// ===============================
if ($_POST['action'] === 'list_bom') {

    $columns = [
        0 => 'bom',
        1 => 'bomstatus',
        2 => 'matdet_id'
    ];

    $matid = intval($_POST['matid'] ?? 0);

    $draw   = intval($_POST["draw"] ?? 0);
    $start  = intval($_POST["start"] ?? 0);
    $length = intval($_POST["length"] ?? 10);

    if ($matid <= 0) {
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => []
        ]);
        exit;
    }

    $sql = "
        SELECT 
            matdet_id,
            bom,
            bomdesc,
            bomstatus
        FROM material_details
        WHERE mathdr = '$matid'
    ";

    // SEARCH
    if (!empty($_POST['search']['value'])) {
        $search = $db_con->real_escape_string($_POST['search']['value']);
        $sql .= " AND (
            bom LIKE '%$search%' OR
            bomdesc LIKE '%$search%' 
        ) ";
    }

    // ORDER
    if (isset($_POST['order'])) {
        $colIndex = intval($_POST['order'][0]['column']);
        $dir = ($_POST['order'][0]['dir'] === 'asc') ? 'ASC' : 'DESC';
        
        if (isset($columns[$colIndex])) {
            $sql .= " ORDER BY {$columns[$colIndex]} $dir ";
        } else {
            $sql .= " ORDER BY bom ASC ";
        }
    } else {
        $sql .= " ORDER BY bom ASC ";
    }

    // PAGINATION
    $limit = "";
    if ($length != -1) {
        $limit = " LIMIT $start, $length ";
    }

    $queryTotal = $db_con->query($sql);
    if (!$queryTotal) {
        echo json_encode(["error" => "Total query failed: " . $db_con->error]);
        exit;
    }
    $recordsFiltered = $queryTotal->num_rows;

    $sqlTotalAll = "SELECT COUNT(*) as total FROM material_details WHERE mathdr = '$matid'";
    $resTotalAll = $db_con->query($sqlTotalAll);
    $rowTotalAll = $resTotalAll ? $resTotalAll->fetch_assoc() : ['total' => $recordsFiltered];
    $recordsTotal = intval($rowTotalAll['total'] ?? $recordsFiltered);

    $queryData  = $db_con->query($sql . $limit);
    if (!$queryData) {
        echo json_encode(["error" => "Data query failed: " . $db_con->error]);
        exit;
    }

    $data = array();
    while ($row = $queryData->fetch_assoc()) {

        $status = ($row['bomstatus'] === 'Y')
            ? '<span class="badge badge-rounded badge-dark">AC</span>'
            : '<span class="badge badge-rounded badge-meron">IN</span>';


        $sub_array = array();
        
        $sub_array[] = '<span class="clearfix ms-2 mb-4" title="">
                            <h6 class="mb-0 fw-semibold" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$row['bomdesc'].'">
                            '.$row['bom']. '
                            </h6>                                                    
                        </span>';                        
        $sub_array[] = $status; 
        $sub_array[] = '<button class="btn btn-rounded btn-primary btn-xxs btnEditBOM"
                            data-id="'.$row['matdet_id'].'">
                            <i class="fa fa-edit"></i>
                        </button>';
        $data[] = $sub_array;
        
    }

    echo json_encode([
        "draw"            => $draw,
        "recordsTotal"    => $recordsTotal,
        "recordsFiltered" => $recordsFiltered,
        "data"            => $data
    ]);
    exit;
}

// ===============================
// UPLOAD GALLERY
// ===============================
if (isset($_POST['action']) && $_POST['action'] == 'upload_gallery') {

    $matid = intval($_POST['matid'] ?? 0);
    
    if($matid <= 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Material ID.']);
        exit;
    }

    $q_mat = $db_con->prepare("SELECT m.matid, m.compcd, m.plant, d.modcode 
                               FROM material_header m 
                               LEFT JOIN model_details d ON m.modelid = d.modid 
                               WHERE m.matid = ?");
    $q_mat->bind_param("i", $matid);
    $q_mat->execute();
    $res = $q_mat->get_result();
    $matData = $res->fetch_assoc();
    
    if(!$matData) {
        echo json_encode(['status' => 'error', 'message' => 'Material not found.']);
        exit;
    }
    
    $modcode = $matData['modcode'] ?? 'Unknown';
    $compcd  = $matData['compcd'] ?? '3100';
    $plant   = $matData['plant'] ?? '3100';
    
    $target_dir = __DIR__ . "/gallery/model/" . $modcode . "/" . $matid . "/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $count = 0;
    
    if (!empty($_FILES['files']['name'][0])) {
        foreach ($_FILES['files']['name'] as $i => $name) {
            
            $tmp_name = $_FILES['files']['tmp_name'][$i];
            
            if (empty($tmp_name)) continue;
            
            $imagename = uniqid() . "_" . basename($name);
            $target_file = $target_dir . $imagename;
            
            if (move_uploaded_file($tmp_name, $target_file)) {
                
                $imagestatus = 'Y';
                $stmt = $db_con->prepare("INSERT INTO material_gallery (image_matid, compcd, plant, imagename, imagestatus, created_by, created_date) 
                VALUES (?, ?, ?, ?, ?, ?, NOW())");
                $stmt->bind_param("isssss", $matid, $compcd, $plant, $imagename, $imagestatus, $session_id);
                $stmt->execute();
                
                $count++;
            }
        }
    }
    
    echo json_encode(['status' => 'success', 'message' => "$count files uploaded."]);
    exit;
}

// ===============================
// GET IMAGES
// ===============================
if (isset($_POST['action']) && $_POST['action'] == 'get_material_images') {
    $matid = intval($_POST['matid'] ?? 0);
    
    // Get Modcode for path
    $q_mat = $db_con->prepare("SELECT m.matid, d.modcode 
                               FROM material_header m 
                               LEFT JOIN model_details d ON m.modelid = d.modid 
                               WHERE m.matid = ?");
    $q_mat->bind_param("i", $matid);
    $q_mat->execute();
    $matData = $q_mat->get_result()->fetch_assoc();
    
    $modcode = $matData['modcode'] ?? 'Unknown';
    $folder_path = "gallery/model/" . $modcode . "/" . $matid . "/";
    
    // Fetch from DB (Show All)
    $stmt = $db_con->prepare("SELECT imageid, imagename, imagestatus, created_date, imagepriority 
                                FROM material_gallery WHERE image_matid = ? 
                                    ORDER BY imagepriority ASC");
    $stmt->bind_param("i", $matid);
    $stmt->execute();
    $res = $stmt->get_result();
    
    $images = [];
    while($row = $res->fetch_assoc()){
        $images[] = [
            'id' => $row['imageid'],
            'path' => $folder_path . $row['imagename'],
            'name' => $row['imagename'],
            'status' => $row['imagestatus'],
            'created' => $row['created_date'],
            'priority' => $row['imagepriority']
        ];
    }
    
    echo json_encode(['status' => 'success', 'data' => $images]);
    exit;
}

// ===============================
// DELETE IMAGE
// ===============================
if (isset($_POST['action']) && $_POST['action'] == 'delete_material_image') {
    $imageid = intval($_POST['imageid'] ?? 0);
    
    // 1. Get info to find the file
    $q = $db_con->prepare("
        SELECT g.imagename, g.image_matid, d.modcode 
        FROM material_gallery g
        JOIN material_header m ON g.image_matid = m.matid
        LEFT JOIN model_details d ON m.modelid = d.modid
        WHERE g.imageid = ?
    ");
    $q->bind_param("i", $imageid);
    $q->execute();
    $res = $q->get_result();
    
    if ($row = $res->fetch_assoc()) {
        $imagename = $row['imagename'];
        $matid     = $row['image_matid'];
        $modcode   = $row['modcode'] ?? 'Unknown';

        // Construct path
        $file_path = __DIR__ . "/gallery/model/" . $modcode . "/" . $matid . "/" . $imagename;
        
        // 2. Delete file if exists
        if (file_exists($file_path)) {
            unlink($file_path);
        }

        // 3. Hard Delete from DB
        $stmt = $db_con->prepare("DELETE FROM material_gallery WHERE imageid = ?");
        $stmt->bind_param("i", $imageid);
        
        if($stmt->execute()){
             echo json_encode(['status' => 'success']);
        } else {
             echo json_encode(['status' => 'error', 'message' => 'DB Delete failed']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Image not found']);
    }

    exit;
}

// ===============================
// TOGGLE IMAGE STATUS
// ===============================
if (isset($_POST['action']) && $_POST['action'] == 'toggle_image_status') {
    $imageid = intval($_POST['imageid'] ?? 0);
    
    $stmt = $db_con->prepare("UPDATE material_gallery SET imagestatus = IF(imagestatus='Y', 'N', 'Y'), updated_date = NOW() WHERE imageid = ?");
    $stmt->bind_param("i", $imageid);
    
    if($stmt->execute()){
         echo json_encode(['status' => 'success']);
    } else {
         echo json_encode(['status' => 'error', 'message' => 'Update failed']);
    }
    exit;
}

// ===============================
// UPDATE IMAGE PRIORITY
// ===============================
if (isset($_POST['action']) && $_POST['action'] == 'update_image_priority') {
    $imageid = intval($_POST['imageid'] ?? 0);
    $priority = intval($_POST['priority'] ?? 0);
    
    $stmt = $db_con->prepare("UPDATE material_gallery SET imagepriority = ?, updated_date = NOW() WHERE imageid = ?");
    $stmt->bind_param("ii", $priority, $imageid);
    
    if($stmt->execute()){
         echo json_encode(['status' => 'success']);
    } else {
         echo json_encode(['status' => 'error', 'message' => 'Update priority failed']);
    }
    exit;
}
?>