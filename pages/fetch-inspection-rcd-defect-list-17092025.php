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
    $sql = "SELECT d.defect_id, t.defectname, d.defect_type, d.defect_area
            FROM inspection_defect d
            LEFT JOIN defect_type t ON d.defect_type = t.defectid
            WHERE d.rcd_ir_id = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param('i', $ir_id);
    $stmt->execute();
    $res = $stmt->get_result();

    $html .= '<div id="defectTableContainer">';
    $html .= '<div class="defect-list">';
    $html .= '<table class="table table-sm mb-0"><thead>
        <tr>
            <th>#</th>
            <th>Defect Type</th>
            <th>Area</th>
            <th>Defect Photos</th>
            <th>Comparison Photos</th>
            <th> </th>
        </tr></thead><tbody>';

    $i = 1;
    while ($row = $res->fetch_assoc()) {

        // Fetch defect photos
        $photos = [];
        $qry = $db_con->prepare("SELECT defect_photo FROM inspection_defect_photo WHERE rcd_defect_id = ?");
        $qry->bind_param('i', $row['defect_id']);
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
        $qry2->bind_param('i', $row['defect_id']);
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
        elseif ($ir_status == 9) {
            
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

        $html .= '<tr>
                    <td>'.$i++.'</td>
                    <td>'.$row['defectname'].'</td>
                    <td>'.$row['defect_area'].'</td>
                    <td>'.$photosHtml.'</td>
                    <td>'.$photosHtml_compare.'</td>
                    <td>'.($actionBtns ?: '-').'</td>
                </tr>';
    }

    $html .= '</tbody></table></div></div>';

} else {
    $html .= '<div class="text-center text-muted">No defect details found.</div>';
}

echo $html;
exit;

?>