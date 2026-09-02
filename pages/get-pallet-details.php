<?php
include '../db/db_connect.php';
include '../shift.php'; 

$ir_id = $_POST['ir_id'] ?? 0;

// 1. Fetch main pallet info
$sql = "SELECT * FROM inspection_records WHERE ir_id = ?";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("i", $ir_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) {
    echo '<div class="p-3 text-danger">No record found.</div>';
    exit;
}

// 2. Fetch defect list for this pallet
$sql_defect = "SELECT D.defect_id, T.defectname, D.defect_type, D.defect_area FROM inspection_defect D
               LEFT JOIN defect_type T ON D.defect_type = T.defectid
               WHERE D.rcd_ir_id = ? ORDER BY D.defect_id ASC";
$stmt2 = $db_con->prepare($sql_defect);
$stmt2->bind_param("i", $ir_id);
$stmt2->execute();
$res_defects = $stmt2->get_result();

// 3. Build defect rows
$defect_rows = '';
$i = 1;
while ($def = $res_defects->fetch_assoc()) {
    
    // Fetch defect photos
    $photos = [];
    $qry = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = ?");
    $qry->bind_param('i', $def['defect_id']);
    $qry->execute();
    $result = $qry->get_result();

    while($ph = $result->fetch_assoc()) {
        $photos[] = '<img src="gallery/defect/'.$ph['defect_photo'].'" class="avatar avatar-sm rounded-circle zoomable-photo-defect" data-src="gallery/defect/'.$ph['defect_photo'].'">';
    }

    // wrap defect images in the stacked avatar container:
    if (!empty($photos)) {
        $photosHtml = '<div class="avatar-list avatar-list-stacked">'.implode('', $photos).'</div>';
    } else {
        $photosHtml = '-';
    }

    // Fetch comparison photos (repeat as above)
    $comparePhotos = [];
    $qry2 = $db_con->prepare("SELECT compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = ?");
    $qry2->bind_param('i', $def['defect_id']);
    $qry2->execute();
    $result2 = $qry2->get_result();

    while($ph2 = $result2->fetch_assoc()) {
        $comparePhotos[] = '<img src="gallery/defect_compare/'.$ph2['compare_photo'].'" class="avatar avatar-sm rounded-circle zoomable-photo-compare" data-src="gallery/defect_compare/'.$ph2['compare_photo'].'">';
    }

     // wrap comparison images in the stacked avatar container:
    if (!empty($comparePhotos)) {
        $photosHtml_compare = '<div class="avatar-list avatar-list-stacked">'.implode('', $comparePhotos).'</div>';
    } else {
        $photosHtml_compare = '-';
    }

    $defect_rows .= '
        <tr>
            <td>' . $i++ . '.</td>
            <td>' . $def['defectname'] . '</td>
            <td>' . htmlspecialchars($def['defect_area']) . '</td>
            <td>'.$photosHtml.'</td>
            <td>'.$photosHtml_compare.'</td>
            <td><button class="btn badge-outline-light btn-xxs btn-sm" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit defect details" data-defid="' . $def['defect_id'] . '" data-irid="' . $ir_id . '"><i class="fa fa-edit"></i></button></td>
        </tr>';
}

if ($defect_rows === '') {
    $defect_rows = '<tr><td colspan="6" class="text-muted text-center">No defects found.</td></tr>';
}

// Disabled select and button for status Pending Reviewed and cancelled
$isDisabled = in_array($row['ir_status'], [8, 9]);

?>

<!-- HTML OUTPUT STARTS -->
<div class="card-header border-0 flex-wrap">
    
    <div class="d-flex justify-content-between d-grid gap-3">

        <!-- Always show Created Date -->
        <div class="s-date">
            <p class="mb-0 date-label">Created Date</p>
            <span>
                <?= date("M j, Y", strtotime($row['created_date'])) ?> | 
                <?= date("h:i A", strtotime($row['created_date'])) ?>
            </span>
        </div>

        <?php if ($row['ir_status'] == 8): ?>
            <!-- Cancelled -->
            <div class="s-date">
                <p class="mb-0">Cancellation Date</p>
                <span>
                    <?= date("M j, Y", strtotime($row['cancelled_date'])) ?> | 
                    <?= date("h:i A", strtotime($row['cancelled_date'])) ?>
                </span>
            </div>
        
        <?php elseif ($row['ir_status'] == 9): ?>
            <!-- Pending Review -->
            <div class="s-date">
                <p class="mb-0 date-label">Submitted Date</p>
                <span>
                    <?= date("M j, Y", strtotime($row['submitted_date'])) ?> | 
                    <?= date("h:i A", strtotime($row['submitted_date'])) ?>
                </span>
            </div>

        <?php elseif ($row['ir_status'] == 11): ?>
            <!-- Reviewed -->
            <div class="s-date date-label">
                <p class="mb-0">Submitted Date</p>
                <span>
                    <?= date("M j, Y", strtotime($row['submitted_date'])) ?> | 
                    <?= date("h:i A", strtotime($row['submitted_date'])) ?>
                </span>
            </div>
            <div class="s-date">
                <p class="mb-0 date-label">Reviewed Date</p>
                <span>
                    <?= date("M j, Y", strtotime($row['reviewed_date'])) ?> | 
                    <?= date("h:i A", strtotime($row['reviewed_date'])) ?>
                </span>
            </div>
        <?php endif; ?>

    </div>

    <!-- <div>       
        <small><i class="fa-solid fa-calendar-days me-2"></i><span><?=date("M j, Y");?> | <?= date("h : i A", strtotime($row['created_date'])) ?></span></small>						
    </div> -->

</div>
<hr>

<div class="read-wapper dz-scroll" id="read-content">
    <div class="read-content">
        <div class="col-sm-4">
            <p class="fs-14 fw-semibold">Result</p>
            <form action="#">
                <div class="d-flex">
                    <div class="clearfix flex-grow-1">
                        <select class="form-control result-select resultSelect" <?= $isDisabled ? 'disabled' : '' ?>>
                            <option value="">Choose</option>
                            <option value="OK" <?= $row['ir_result'] == 'OK' ? 'selected' : '' ?>>OK</option>
                            <option value="NG" <?= $row['ir_result'] == 'NG' ? 'selected' : '' ?>>NG</option>
                        </select>
                    </div>
                    <div class="clearfix ms-3">
                        <button class="btn btn-black" type="button" <?= $isDisabled ? 'disabled' : '' ?>>Update</button>
                    </div>
                </div>
            </form>
        </div>

        <hr>
        
        <?php

        $has_defect = ($res_defects->num_rows > 0);
        $show_defect_table = ($row['ir_result'] == 'NG' && $has_defect);

        ?>

        <?php if ($show_defect_table): ?>
        <div class="media mb-2 mt-3">
            <div class="media-body">
                <h5 class="my-1 text-primary">Defects List</h5>
            </div>
        </div>
        <div class="read-content-body">
            <div class="table-responsive">
                <table id="inspectionTable_defect" class="display table mb-1 table-striped-thead table-wide table-md inspectionTable_defect">
                    <thead class="thead-black">
                        <tr>
                            <th>#</th>
                            <th>Defect Type</th>
                            <th>Area</th>
                            <th>Defect Photos</th>
                            <th>Comparison Photos</th>
                            <th>Edit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?= $defect_rows ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>

<script>
$(function () {
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function (tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });
});
</script>

<script>
//to apply select style to non select2
$('.result-select').select2({
    minimumResultsForSearch: Infinity, // Hide search box if not needed
    width: '100%'
});
</script>