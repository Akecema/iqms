<?php
header("Cache-Control: no-cache, must-revalidate, max-age=0");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
require '../db/db_connect.php';
include 'session-login.php';


$ir_id = $_POST['ir_id'] ?? '';
$sr_id = $_POST['sr_id'] ?? '';
$s2w_id = $_POST['s2w_id'] ?? '';
$rp_id = $_POST['rp_id'] ?? '';

if (!$rp_id) {
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
        s.acknowledge_date,
        s.acknowledge_return_date,       
        s.approved_remark,
        s.cancel_remark,
        s.rp_s2w_docnocancel,
        s.returned_remark,
        s.reviewed_remark,
        s.acknowledge_remark,
        s.acknowledge_return_remark,
        s.rp_s2w_status,
        ST.statusmaps,
        E.short_name  AS created_by,
        ES.short_name AS submitted_by,
        EA.short_name AS approved_by,
        EW.short_name AS reviewed_by,
        EC.short_name AS cancelled_by,
        ER.short_name AS returned_by,
        EAC.short_name AS acknowledge_by,        
        EAR.short_name AS acknowledge_return_by
    FROM inspection_s2w_report s
    LEFT JOIN system_status AS ST  ON s.rp_s2w_status   = ST.statusid
    LEFT JOIN employee_details AS E  ON s.created_by   = E.staff_id
    LEFT JOIN employee_details AS ES ON s.submitted_by = ES.staff_id
    LEFT JOIN employee_details AS EA ON s.approved_by  = EA.staff_id
    LEFT JOIN employee_details AS EW ON s.reviewed_by  = EW.staff_id
    LEFT JOIN employee_details AS EC ON s.cancelled_by = EC.staff_id
    LEFT JOIN employee_details AS ER ON s.returned_by  = ER.staff_id
    LEFT JOIN employee_details AS EAC ON s.acknowledge_by = EAC.staff_id
    LEFT JOIN employee_details AS EAR ON s.acknowledge_return_by  = EAR.staff_id
    WHERE s.rp_id = ? ");
$stmt->bind_param("i", $rp_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    echo "<div class='text-muted text-center py-3'>No timeline found.</div>";
    exit;
}

$sr_status = (int)$row['rp_s2w_status'];
$sr_status_mp = (int)$row['statusmaps'];

function tl($current, $step) {

    $map = [
        'new'   => 1,
        'created' => 2,
        'pendingRw' => 3,
        'pendingAp' => 4,
        'reviewed' => 5,
        'approved'  => 6,
        'cancelled' => 7,
        'returned'  => 8,        
        'acknowledge'  => 9,        
        'returnedAck'  => 10,
        'completed' => 11
    ];

    if (!isset($map[$step])) return '';

    if ($current === $map[$step]) return 'active';
    if ($current > $map[$step])   return 'done';
    if ($current === 12 && $step === 'returned') return 'error';
    if ($current === 8  && $step === 'cancelled') return 'error';

    return '';
}


function formatTime($dt) {
    return ($dt && $dt != '0000-00-00 00:00:00') ? date("j M Y | h:i A", strtotime($dt)) : '-';
}

$created_by = ($row['created_date'] != '0000-00-00 00:00:00') ? 'by '.$row['created_by'] : '';
$submitted_by = ($row['submitted_date'] != '0000-00-00 00:00:00') ? 'by '.$row['submitted_by'] : '';
$approved_by = ($row['approved_date'] != '0000-00-00 00:00:00') ? 'by '.$row['approved_by'] : '';
$returned_by = ($row['returned_date'] != '0000-00-00 00:00:00') ? 'by '.$row['returned_by'] : '';
$cancelled_by = ($row['cancelled_date'] != '0000-00-00 00:00:00') ? 'by '.$row['cancelled_by'] : '';
$acknowledge_by = ($row['acknowledge_date'] != '0000-00-00 00:00:00') ? 'by '.$row['acknowledge_by'] : '';
$returnedAck_by = ($row['acknowledge_return_date'] != '0000-00-00 00:00:00') ? 'by '.$row['acknowledge_return_by'] : '';

?>

<div class="timeline-card">

    <div class="timeline-item <?= tl($sr_status_mp,'created') ?>">
        <span class="timeline-icon"><i class="la la-calendar"></i></span>
        <div>
            <div class="timeline-title">Created</div>
            <div class="timeline-date">
                <?= formatTime($row['created_date']) ?><br><?= $created_by ?>
            </div>
        </div>
    </div>

    <div class="timeline-item <?= tl($sr_status_mp,'pendingRw') ?>">
        <span class="timeline-icon"><i class="la la-upload"></i></span>
        <div>
            <div class="timeline-title">Submitted</div>
            <div class="timeline-date">
                <?= formatTime($row['submitted_date']) ?><br><?= $submitted_by ?>
            </div>
        </div>
    </div>

    <div class="timeline-item <?= tl($sr_status_mp,'reviewed') ?>">
        <span class="timeline-icon"><i class="la la-check-circle"></i></span>
        <div>
            <div class="timeline-title">Approved 
                <?php if (!empty($row['approved_remark'])): ?>
                <small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 remark-btn"
                role="button"
                data-bs-toggle="modal"
                data-bs-target="#remarkModal"
                data-title="Approved Remark"
                data-remark="<?= htmlspecialchars($row['approved_remark'], ENT_QUOTES) ?>">
                </i>
            </small>
            <?php endif; ?>
            </div>
            <div class="timeline-date">
                <?= formatTime($row['approved_date']) ?><br><?= $approved_by ?>
            </div>            
        </div>
    </div>

    <?php if ($sr_status == 8): ?>
    <div class="timeline-item <?= tl($sr_status_mp,'cancelled') ?>">
        <span class="timeline-icon"><i class="la la-times-circle"></i></span>
        <div>
            <div class="timeline-title">Cancelled
                <?php if (!empty($row['cancel_remark'])): ?>
                <small class="table-tip d-inline-flex align-items-center text-primary">
                    <i class="fa fa-info-circle p-1 remark-btn"
                    role="button"
                    data-bs-toggle="modal"
                    data-bs-target="#remarkModal"
                    data-title="Cancellation Remark"
                    data-remark="<?= htmlspecialchars($row['cancel_remark'], ENT_QUOTES) ?>">
                    </i>
                </small>
                <?php endif; ?>
            </div>
            <div class="timeline-date">
                <?= formatTime($row['cancelled_date']) ?><br><?= $cancelled_by ?>
            </div>
            
        </div>
    </div>
    <?php endif; ?>

    <?php if ($sr_status == 12): ?>
    <div class="timeline-item <?= tl($sr_status_mp,'returned') ?>">
        <span class="timeline-icon"><i class="la la-undo"></i></span>
        <div>
            <div class="timeline-title">Returned
                <?php if (!empty($row['returned_remark'])): ?>
                <small class="table-tip d-inline-flex align-items-center text-primary">
                    <i class="fa fa-info-circle p-1 remark-btn"
                    role="button"
                    data-bs-toggle="modal"
                    data-bs-target="#remarkModal"
                    data-title="Returned Remark"
                    data-remark="<?= htmlspecialchars($row['returned_remark'], ENT_QUOTES) ?>">
                    </i>
                </small>
                <?php endif; ?>
            </div>
            <div class="timeline-date">
                <?= formatTime($row['returned_date']) ?><br><?= $returned_by ?>
            </div>            
        </div>
    </div>
    <?php endif; ?>

    <?php if ($sr_status == 16): ?>
    <div class="timeline-item <?= tl($sr_status_mp,'returnedAck') ?>">
        <span class="timeline-icon"><i class="la la-undo"></i></span>
        <div>
            <div class="timeline-title">Returned
                <?php if (!empty($row['acknowledge_return_remark'])): ?>
                <small class="table-tip d-inline-flex align-items-center text-primary">
                    <i class="fa fa-info-circle p-1 remark-btn"
                    role="button"
                    data-bs-toggle="modal"
                    data-bs-target="#remarkModal"
                    data-title="Returned Remark"
                    data-remark="<?= htmlspecialchars($row['acknowledge_return_remark'], ENT_QUOTES) ?>">
                    </i>
                </small>
                <?php endif; ?>
            </div>
            <div class="timeline-date">
                <?= formatTime($row['acknowledge_return_date']) ?><br><?= $returnedAck_by ?>
            </div>            
        </div>
    </div>
    <?php endif; ?>

    <?php if ($sr_status == 5): ?>
    <div class="timeline-item <?= tl($sr_status_mp,'acknowledge') ?>">
        <span class="timeline-icon"><i class="la la-calendar-check-o"></i></span>
        <div>
            <div class="timeline-title">Completed
                <?php if (!empty($row['acknowledge_remark'])): ?>
                <small class="table-tip d-inline-flex align-items-center text-primary">
                    <i class="fa fa-info-circle p-1 remark-btn"
                    role="button"
                    data-bs-toggle="modal"
                    data-bs-target="#remarkModal"
                    data-title="Acknowledge Remark"
                    data-remark="<?= htmlspecialchars($row['acknowledge_remark'], ENT_QUOTES) ?>">
                    </i>
                </small>
                <?php endif; ?>
            </div>
            <div class="timeline-date">
                <?= formatTime($row['acknowledge_date']) ?><br><?= $acknowledge_by ?>
            </div>            
        </div>
    </div>
    <?php endif; ?>



</div>



