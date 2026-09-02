<?php
include '../db/db_connect.php';
include 'system-status.php';

$section = 'PDI';
$current_shift = $_POST['shift'];
$today = $_POST['shift_date'];

$query_act = "SELECT 
                C.tbl_id, 
                C.docno, 
                C.status_comment, 
                C.commentator, 
                C.comment_date,
                E.staff_name, 
                S.text_color, 
                S.icon_class,
                COALESCE(I.shift_date, I2.shift_date) AS shift_date
            FROM activity_comment C 
            LEFT JOIN employee_details E ON E.staff_id = C.commentator 
            LEFT JOIN system_status S ON S.statusid = C.form_status
            LEFT JOIN inspection_records I ON I.ir_docno = C.docno
            LEFT JOIN inspection_records I2 ON I2.ir_docnocancel = C.docno
            WHERE C.section = ? 
            ORDER BY C.tbl_id DESC";

$stmt_act = $db_con->prepare($query_act);
$stmt_act->bind_param("s", $section);
$stmt_act->execute();
$result_act = $stmt_act->get_result();

?>

<ul class="timeline">
<?php while ($row_act = $result_act->fetch_assoc()) {

    $commentator = $row_act['commentator'];
    $comment_status = $row_act['status_comment'];
    $comment_date = date("j M Y, g:i a",strtotime($row_act['comment_date'])); 
    $docno = $row_act['docno'];
    $textColor = $row_act['text_color'] ?? 'text-dark';
    $iconClass = $row_act['icon_class'];
?>
    <li>
        <div class="timeline-media">
            <i class="las <?= $iconClass; ?>"></i>
        </div>
        <div class="timeline-panel">
            <div class="clearfix">
                <span class="fs-13 fw-semibold text-dark"><?= $row_act['staff_name']; ?></span> 
                <span class="ms-0 fs-13"><?= $comment_status; ?><br>
                    <span class="<?=$textColor ?> ms-1">#<?= $docno; ?></span>
                </span>
                <span class="fs-12 d-block mt-1 ms-1"><?= $comment_date; ?></span>
            </div>
        </div>
    </li>
<?php } ?>
</ul>
