<?php
header("Cache-Control: no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
require '../db/db_connect.php';
include 'session-login.php';

$ir_id = $_POST['ir_id'] ?? '';
$sr_id = $_POST['sr_id'] ?? '';

if (!$ir_id || !$sr_id) {
    echo "<div class='alert alert-danger'>Invalid request.</div>";
    exit;
}

$stmt = $db_con->prepare("
    SELECT
        s.created_date,
        s.submitted_date,
        s.reviewed_date,
        s.approved_date,
        s.cancelled_date,
        s.returned_date,        
        s.approved_remark,
        s.cancel_remark,
        s.sr_docnocancel,
        s.returned_remark,
        s.reviewed_remark,
        s.sr_status,
        E.short_name  AS created_by,
        ES.short_name AS submitted_by,
        EA.short_name AS approved_by,
        EW.short_name AS reviewed_by,
        EC.short_name AS cancelled_by,
        ER.short_name AS returned_by
    FROM inspection_sorting s
    LEFT JOIN employee_details AS E  ON s.created_by   = E.staff_id
    LEFT JOIN employee_details AS ES ON s.submitted_by = ES.staff_id
    LEFT JOIN employee_details AS EA ON s.approved_by  = EA.staff_id
    LEFT JOIN employee_details AS EW ON s.reviewed_by  = EW.staff_id
    LEFT JOIN employee_details AS EC ON s.cancelled_by = EC.staff_id
    LEFT JOIN employee_details AS ER ON s.returned_by  = ER.staff_id
    WHERE s.sr_id = ?
    LIMIT 1
");
$stmt->bind_param("i", $sr_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    echo "<div class='text-muted text-center py-3'>No timeline found.</div>";
    exit;
}

function formatTime($dt) {
    return ($dt && $dt != '0000-00-00 00:00:00') ? date("j M Y | h:i A", strtotime($dt)) : '-';
}

$created_by = ($row['created_date'] != '0000-00-00 00:00:00') ? 'by '.$row['created_by'] : '';
$submitted_by = ($row['submitted_date'] != '0000-00-00 00:00:00') ? 'by '.$row['submitted_by'] : '';
$approved_by = ($row['approved_date'] != '0000-00-00 00:00:00') ? 'by '.$row['approved_by'] : '';
$returned_by = ($row['returned_date'] != '0000-00-00 00:00:00') ? 'by '.$row['returned_by'] : '';
$cancelled_by = ($row['cancelled_date'] != '0000-00-00 00:00:00') ? 'by '.$row['cancelled_by'] : '';

?>

 <div class="timeline-entry mb-4">
    <div class="timeline-icon bg-body-secondary text-dark">
        <i class="fa fa-calendar-plus"></i>
    </div>
    <div class="timeline-content">
        <p class="mb-0 fw-semibold text-dark">Created Date</p>
        <span class="ms-0 fs-13"><?=formatTime($row['created_date']) ?></span>
        <span class="ms-0 fs-13"><?=$created_by ?></span>
    </div>
</div>
<div class="timeline-entry mb-4">
    <div class="timeline-icon bg-body-secondary text-dark">
        <i class="fa fa-calendar-alt"></i>
    </div>
    <div class="timeline-content">
        <p class="mb-0 fw-semibold text-dark">Submitted Date</p>
        <span class="ms-0 fs-13"><?= formatTime($row['submitted_date']) ?></span>
        <span class="ms-0 fs-13"><?= $submitted_by ?></span>
    </div>
</div>
<div class="timeline-entry mb-4">
    <div class="timeline-icon bg-body-secondary text-dark">
        <i class="fa fa-calendar-check"></i>
    </div>
    <div class="timeline-content">
        <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="<?=$row['approved_remark'] ?> ">Approved Date</p>
        <span class="ms-0 fs-13"><?= formatTime($row['approved_date']) ?></span>
        <span class="ms-0 fs-13"><?= $approved_by ?></span>
        <?php if (!empty($row['approved_remark'])): ?>
        <small class="table-tip d-inline-flex align-items-center text-primary">
            <i class="fa fa-info-circle p-1"
            data-bs-toggle="modal"
            data-bs-target="#remarkModal"
            data-remark="<?= htmlspecialchars($row['approved_remark'], ENT_QUOTES) ?>"
            role="button">
            </i>
        </small>
        <?php endif; ?>
    </div>
</div>
<div class="timeline-entry mb-4">
    <div class="timeline-icon bg-body-secondary text-dark">
        <i class="fa fa-calendar-minus"></i>
    </div>
    <div class="timeline-content">
        <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="<?=$row['returned_remark'] ?>">Returned Date</p>
        <span class="ms-0 fs-13"><?= formatTime($row['returned_date']) ?></span>
        <span class="ms-0 fs-13"><?= $returned_by ?></span> 
        <?php if ($row['returned_remark']): ?>
        <small class="table-tip d-inline-flex align-items-center text-primary">
            <i class="fa fa-info-circle p-1" 
            data-bs-toggle="modal"
            data-bs-target="#remarkModal"
            data-remark="<?= htmlspecialchars($row['returned_remark'], ENT_QUOTES) ?>"
            role="button">
            </i>
        </small>
        <?php endif; ?>
    </div>
</div>  

<?php if ($row['sr_status'] == 8) { ?>

<div class="timeline-entry mb-0">
    <div class="timeline-icon bg-body-secondary text-dark">
        <i class="fa fa-calendar-times"></i>
    </div>
    <div class="timeline-content">
        <p class="mb-0 fw-semibold text-dark timeline-title-remark" data-remark="<?=$row['returned_remark'] ?>">Cancelled Date</p>
        <span class="ms-0 fs-13"><?= formatTime($row['cancelled_date']) ?></span>
        <span class="ms-0 fs-13"><?= $cancelled_by ?></span> 
        <?php if ($row['cancel_remark']): ?>
        <small class="table-tip d-inline-flex align-items-center text-primary">
            <i class="fa fa-info-circle p-1" 
            data-bs-toggle="modal"
            data-bs-target="#remarkModal"
            data-remark="<?= htmlspecialchars($row['cancel_remark'], ENT_QUOTES) ?>"
            role="button">
            </i>
        </small>
        <?php endif; ?>
    </div>
</div>

<?php } ?>
