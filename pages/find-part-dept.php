<?php 

session_start();
include '../db/db_connect.php';
include 'session-login.php';

if ($_POST['action'] === 'get_part_by_dept') {

    $dept_id = intval($_POST['dept_id'] ?? 0);
    $ir_id   = intval($_POST['ir_id'] ?? 0);

    if ($dept_id <= 0 || $ir_id <= 0) {
        echo json_encode(['status' => 'error']);
        exit;
    }

    /*Get material header from inspection_records*/
    $stmt = $db_con->prepare("
        SELECT ir_material 
        FROM inspection_records 
        WHERE ir_id = ?
    ");
    $stmt->bind_param("i", $ir_id);
    $stmt->execute();
    $stmt->bind_result($mathdr);
    $stmt->fetch();
    $stmt->close();

    if (!$mathdr) {
        echo json_encode(['status' => 'error']);
        exit;
    }

    /*2. Get parts filtered by department*/
    $stmt = $db_con->prepare("
        SELECT 
        m.bom, m.bomdesc, m.matdet_id
        FROM material_details m        
        JOIN material_department md ON md.matdet_id = m.matdet_id
        WHERE m.mathdr = ?
          AND md.rd_dept_id = ?
          AND md.md_status = 'AC'
        ORDER BY m.bom ASC
    ");
    $stmt->bind_param("ii", $mathdr, $dept_id);
    $stmt->execute();
    $res = $stmt->get_result();

    $options = '<option value="">Part No</option>';

    while ($row = $res->fetch_assoc()) {
        $options .= sprintf(
            '<option value="%d" data-desc="%s">%s</option>',
            $row['matdet_id'],
            htmlspecialchars($row['bomdesc']),
            htmlspecialchars($row['bom'])
        );
    }

    echo json_encode([
        'status'  => 'success',
        'options' => $options
    ]);
    exit;
}

?>

<script>

$(function() {
    //Initialize Select2 Elements
    $('.default-select').select2()
});

</script>