<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$ir_id = $_POST['ir_id'] ?? '';
$ir_status = $_POST['status'] ?? '' ;
$html = '';

if ($ir_id) {
    $sql = "SELECT d.defect_id, t.defectname, d.defect_type, d.defect_area, i.shift_date
            FROM inspection_defect d
            LEFT JOIN defect_type t ON d.defect_type = t.defectid
            LEFT JOIN inspection_records i ON d.rcd_ir_id = i.ir_id
            WHERE d.rcd_ir_id = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $res = $stmt->get_result();

    $html .= '<div id="defectTableContainer" class="defect-list">';

    $i = 1;
    while ($row = $res->fetch_assoc()) {

        // Fetch defect photos
        $photos = [];
        $qry = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = ?");
        $qry->bind_param('i', $row['defect_id']);
        $qry->execute();
        $result = $qry->get_result();

        while($ph = $result->fetch_assoc()) {
            $photos[] = '<img src="gallery/inspection/defect/' .$ir_id. '/' .$ph['defect_photo'].'" class="avatar avatar-sm rounded-circle zoomable-photo-defect" 
                            data-src="gallery/inspection/defect/' .$ir_id. '/' .$ph['defect_photo'].'">';

        }

        // wrap defect images in the stacked avatar container:
        if (!empty($photos)) {
            $photosHtml = '<div class="avatar-list avatar-list-stacked gallery-defect" id="gallery-defect-'.$row['defect_id'].'">'.implode('', $photos).'</div>';
        } else {
            $photosHtml = '-';
        }

        // Fetch comparison photos (repeat as above)
        $comparePhotos = [];
        $qry2 = $db_con->prepare("SELECT compare_photo FROM inspection_compare_photo WHERE rcd_defect_id = ?");
        $qry2->bind_param('i', $row['defect_id']);
        $qry2->execute();
        $result2 = $qry2->get_result();

        while($ph2 = $result2->fetch_assoc()) {
            $comparePhotos[] = '<img src="gallery/inspection/defect_compare/' .$ir_id. '/' .$ph2['compare_photo'].'" class="avatar avatar-sm rounded-circle zoomable-photo-compare" 
                                    data-src="gallery/inspection/defect_compare/' .$ir_id. '/' .$ph2['compare_photo'].'">';
        }

        // wrap comparison images in the stacked avatar container:
        if (!empty($comparePhotos)) {
            $photosHtml_compare = '<div class="avatar-list avatar-list-stacked gallery-defect" id="gallery-compare-'.$row['defect_id'].'">'.implode('', $comparePhotos).'</div>';
        } else {
            $photosHtml_compare = '-';
        }

        //Get delay days (for section = PDI, you can adjust if section dynamic)
        // $delay_sql = "SELECT delay_day FROM time_delay WHERE section = 'PDI' LIMIT 1";
        // $resDelay = mysqli_query($db_con, $delay_sql);
        // $rowDelay = mysqli_fetch_assoc($resDelay);
        // $delay_day = $rowDelay ? (int)$rowDelay['delay_day'] : 0;

        // $today = new DateTime();
        // $allowedDate = (clone $today)->modify("-{$delay_day} days");
        // $prodDate = new DateTime($row['shift_date']);  // assuming shift_date exists in $row

        // $isAllowed = $prodDate >= $allowedDate;        
        // $btnDisabled = $isAllowed ? "" : "disabled style='opacity:0.4;pointer-events:none;'";

        // Only allow edit/delete if status is 1
       $actionBtns = '';

        if ($ir_status == 1 || $ir_status == 12 ) {

            $actionBtns = '<button class="btn btn-outline-primary btn-xxs edit-defect" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit defect details"
                                data-defectid="'.$row['defect_id'].'"
                                data-irid="'.$ir_id.'">
                                <i class="fa fa-edit"></i>
                            </button> ';

            $actionBtns .= '<button class="btn btn-outline-primary btn-xxs delete-defect" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete defect"
                                data-defectid="'.$row['defect_id'].'"
                                data-irid="'.$ir_id.'">
                                <i class="fa fa-times"></i>
                            </button>';
        }
        else {
            
            $actionBtns .= ' <button class="btn badge-outline-light btn-xxs edit-defect" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit defect details" disabled
                                data-defectid="'.$row['defect_id'].'"
                                data-irid="'.$ir_id.'">
                                <i class="fa fa-edit"></i>
                            </button> '; 

             $actionBtns .= ' <button class="btn btn-outline-light btn-xxs delete-defect" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete defect" disabled
                                data-defectid="'.$row['defect_id'].'"
                                data-irid="'.$ir_id.'">
                                <i class="fa fa-times"></i>
                            </button>';
        }

            $html .= '
            <div class="defect-row mb-3">
                <div class="defect-card">

                    <div class="defect-header">
                        <div class="defect-title">
                            <span class="defect-index">#'.$i++.'</span>
                            <span class="defect-name">'.$row['defectname'].'</span>
                        </div>

                        <div class="defect-area">
                            <span class="badge badge-outline-secondary">
                                Area: '.$row['defect_area'].'
                            </span>
                        </div>
                    </div>

                    <div class="defect-body">
                        <div class="defect-photo-block">
                            <label>Defect Photos</label>
                            '.$photosHtml.'
                        </div>

                        <div class="defect-photo-block">
                            <label>Comparison Photos</label>
                            '.$photosHtml_compare.'
                        </div>
                    </div>

                    <div class="defect-actions">
                        '.($actionBtns ?: '<span class="text-muted">No action</span>').'
                    </div>

                </div>
            </div>';

    }

    $html .= '</div>';

} else {
    $html .= '<div class="text-center text-muted">No defect details found.</div>';
}

echo $html;
exit;

?>