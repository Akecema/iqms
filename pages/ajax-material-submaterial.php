<?php
session_start();
include '../db/db_connect.php';

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

if ($action == "fetch_material_list") {

    $keyword = trim($_POST['keyword'] ?? '');

    $sql = "
        SELECT 
            m.matid,
            m.matno,
            m.matdesc,
            md.modcode AS modelcode,
            (
                SELECT COUNT(*)
                FROM material_details s
                WHERE s.mathdr = m.matid AND s.bomstatus = 'Y'
            ) AS sub_count
        FROM material_header m
        LEFT JOIN model_details md ON md.modid = m.modelid
        WHERE m.matstatus = 'Y'
    ";

    if ($keyword != '') {
        $sql .= " AND (m.matno LIKE ? OR m.matdesc LIKE ?)";
    }

    $sql .= " ORDER BY m.matno ASC LIMIT 200";

    $stmt = $db_con->prepare($sql);

    if ($keyword != '') {
        $like = "%".$keyword."%";
        $stmt->bind_param("ss", $like, $like);
    }

    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode([
        "success" => true,
        "data" => $data
    ]);
    exit;
}


// ============================
// DATATABLE SUB MATERIAL
// ============================
if ($action == "fetch_sub_material_table") {

    $matid = intval($_POST['matid'] ?? 0);

    $draw   = intval($_POST['draw'] ?? 1);
    $start  = intval($_POST['start'] ?? 0);
    $length = intval($_POST['length'] ?? 10);

    if ($matid <= 0) {
        echo json_encode([
            "draw" => $draw,
            "recordsTotal" => 0,
            "recordsFiltered" => 0,
            "data" => []
        ]);
        exit;
    }

    // Total
    $stmtTotal = $db_con->prepare("
        SELECT COUNT(*) AS total
        FROM material_details
        WHERE mathdr = ? AND bomstatus = 'Y'
    ");
    $stmtTotal->bind_param("i", $matid);
    $stmtTotal->execute();
    $totalRes = $stmtTotal->get_result()->fetch_assoc();
    $recordsTotal = intval($totalRes['total']);

    // Fetch data
    $stmt = $db_con->prepare("
        SELECT matdet_id, bom, bomdesc, mattype, bomstatus
        FROM material_details
        WHERE mathdr = ? AND bomstatus = 'Y'
        ORDER BY bom ASC
        LIMIT ?, ?
    ");
    $stmt->bind_param("iii", $matid, $start, $length);
    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    while ($r = $res->fetch_assoc()) {

        $badge = ($r['bomstatus'] == 'Y')
            ? '<span class="badge bg-success">Active</span>'
            : '<span class="badge bg-secondary">Inactive</span>';

        $data[] = [
            "subcode" => $r['bom'],
            "subname" => $r['bomdesc'],
            "spec" => $r['mattype'],
            "status_badge" => $badge,
            "action" => '
                <div class="dropdown">
                    <button class="btn btn-sm btn-light dropdown-toggle" data-bs-toggle="dropdown">
                        Action
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item btnEditSub" href="javascript:void(0)" data-id="'.$r['matdet_id'].'">Edit</a></li>
                        <li><a class="dropdown-item text-danger btnDeleteSub" href="javascript:void(0)" data-id="'.$r['matdet_id'].'">Delete</a></li>
                    </ul>
                </div>
            '
        ];
    }

    echo json_encode([
        "draw" => $draw,
        "recordsTotal" => $recordsTotal,
        "recordsFiltered" => $recordsTotal,
        "data" => $data
    ]);
    exit;
}

echo json_encode([
    "success" => false,
    "message" => "Invalid action"
]);
exit;
