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

if (!$s2w_id) {
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
        s.rvw_returned_date, 
        s.app_returned_date,        
        s.approved_remark,
        s.cancel_remark,
        s.s2w_docnocancel,
        s.rvw_returned_remark,
        s.app_returned_remark,
        s.reviewed_remark,
        s.s2w_status,
        ST.statusmaps,
        E.short_name  AS created_by,
        ES.short_name AS submitted_by,
        EA.short_name AS approved_by,
        EW.short_name AS reviewed_by,
        EC.short_name AS cancelled_by,
        ER.short_name AS rvw_returned_by,
        EP.short_name AS app_returned_by
    FROM inspection_s2w s
    LEFT JOIN system_status AS ST  ON s.s2w_status   = ST.statusid
    LEFT JOIN employee_details AS E  ON s.created_by   = E.staff_id
    LEFT JOIN employee_details AS ES ON s.submitted_by = ES.staff_id
    LEFT JOIN employee_details AS EA ON s.approved_by  = EA.staff_id
    LEFT JOIN employee_details AS EW ON s.reviewed_by  = EW.staff_id
    LEFT JOIN employee_details AS EC ON s.cancelled_by = EC.staff_id
    LEFT JOIN employee_details AS ER ON s.rvw_returned_by  = ER.staff_id
    LEFT JOIN employee_details AS EP ON s.app_returned_by  = EP.staff_id
    WHERE s.s2w_id = ? ");
$stmt->bind_param("i", $s2w_id);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    echo "<div class='text-muted text-center py-3'>No timeline found.</div>";
    exit;
}

$sr_status = (int)$row['s2w_status'];
$sr_status_mp = (int)$row['statusmaps'];

function hasDate($dt) {
    return !empty($dt) && $dt !== '0000-00-00 00:00:00';
}

function tl($current, $step, $row) {

    $map = [
        'new'   => 1,
        'created' => 2,
        'pendingRw' => 3,
        'pendingAp' => 4,
        'reviewed' => ['id'=>5, 'date'=>'reviewed_date'],
        'approved'  => ['id'=>6, 'date'=>'approved_date'],
        'cancelled' => 7,
        'returned'  => ['id'=>8, 'date'=>'approved_date'],
        'completed' => 9
    ];

    if (!isset($map[$step])) return '';

    if ($current === $map[$step]) return 'active';
    if ($current > $map[$step])   return 'done';
    if ($current === 12 && $step === 'returned') return 'error';
    if ($current === 8  && $step === 'cancelled') return 'error';

    if ($step === 'reviewed' && hasDate($row['reviewed_date'])) return 'done';
    if ($step === 'approved' && hasDate($row['approved_date'])) return 'done';
    if ($step === 'returned'  && hasDate($row['rvw_returned_date'])) return 'error';

    return '';
}


function formatTime($dt) {
    return ($dt && $dt != '0000-00-00 00:00:00') ? date("j M Y | h:i A", strtotime($dt)) : '-';
}

$created_by = ($row['created_date'] != '0000-00-00 00:00:00') ? 'by '.$row['created_by'] : 'ZZ';
$submitted_by = ($row['submitted_date'] != '0000-00-00 00:00:00') ? 'by '.$row['submitted_by'] : '';
$reviewed_by = ($row['reviewed_date'] != '0000-00-00 00:00:00') ? 'by '.$row['reviewed_by'] : '';
$approved_by = ($row['approved_date'] != '0000-00-00 00:00:00') ? 'by '.$row['approved_by'] : '';
$returned_by_rw = ($row['rvw_returned_date'] != '0000-00-00 00:00:00') ? 'by '.$row['rvw_returned_by'] : '';
$returned_by_ap = ($row['app_returned_date'] != '0000-00-00 00:00:00') ? 'by '.$row['app_returned_by'] : '';
$cancelled_by = ($row['cancelled_date'] != '0000-00-00 00:00:00') ? 'by '.$row['cancelled_by'] : '';


?>

<div class="timeline-card">

    <div class="timeline-item <?= tl($sr_status_mp,'created',$row) ?>">
        <span class="timeline-icon"><i class="la la-calendar"></i></span>
        <div>
            <div class="timeline-title">Created</div>
            <div class="timeline-date">
                <?= formatTime($row['created_date']) ?><br><?= $created_by ?>
            </div>
        </div>
    </div>

    <div class="timeline-item <?= tl($sr_status_mp,'pendingRw',$row) ?>">
        <span class="timeline-icon"><i class="la la-upload"></i></span>
        <div>
            <div class="timeline-title">Submitted</div>
            <div class="timeline-date">
                <?= formatTime($row['submitted_date']) ?><br><?= $submitted_by ?>
            </div>
        </div>
    </div>

    <div class="timeline-item <?= tl($sr_status_mp,'reviewed',$row) ?>">
        <span class="timeline-icon"><i class="la la-upload"></i></span>
        <div>
            <div class="timeline-title">Reviewed
                <?php if (!empty($row['reviewed_remark'])): ?>
                <small class="table-tip d-inline-flex align-items-center text-primary">
                <i class="fa fa-info-circle p-1 remark-btn"
                role="button"
                data-bs-toggle="modal"
                data-bs-target="#remarkModal"
                data-title="Reviewed Remark"
                data-remark="<?= htmlspecialchars($row['reviewed_remark'], ENT_QUOTES) ?>">
                </i>
            </small>
            <?php endif; ?>
            </div>
            <div class="timeline-date">
                <?= formatTime($row['reviewed_date']) ?><br><?= $reviewed_by ?>
            </div>
        </div>
    </div>

    <div class="timeline-item <?= tl($sr_status_mp,'approved',$row) ?>">
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
    <div class="timeline-item <?= tl($sr_status_mp,'cancelled',$row) ?>">
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
    <div class="timeline-item <?= tl($sr_status_mp,'returned',$row) ?>">
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
                    data-remark="<?= htmlspecialchars($row['rvw_returned_remark'], ENT_QUOTES) ?>">
                    </i>
                </small>
                <?php endif; ?>
            </div>
            <div class="timeline-date">
                <?= formatTime($row['rvw_returned_date']) ?><br><?= $returned_by_rw ?>
            </div>            
        </div>
    </div>
    <?php endif; ?>



</div>



