<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include '../shift.php';

$model = $_POST['model'];
$type = $_POST['type'];
$material = $_POST['material'];

//model
$sql_rcdmaterial = "SELECT H.matdesc, H.matno, M.modcode FROM material_header H 
                        LEFT JOIN model_details M ON M.modid = H.modelid
                            WHERE H.matid = '$material' and M.modid = '$model' ";
$result_rcdmaterial = mysqli_query($db_con, $sql_rcdmaterial);
$row_rcdmaterial = mysqli_fetch_assoc($result_rcdmaterial);

//material id
$gall_model = $row_rcdmaterial['modcode'];


$sql_img = "SELECT imagename FROM material_gallery WHERE image_matid = '$material'";
$result_img = mysqli_query($db_con, $sql_img);

$gallery_html = '';
$count = 0;

while ($row_img = mysqli_fetch_assoc($result_img)) {
    
    $view_img = $row_img['imagename'];
    $thumb = "gallery/model/$gall_model/$view_img"; // adjust path if needed
    $full = "gallery/model/$gall_model/$view_img";

    $extra = ($count == 3) ? ' gallery-more" data-more="+03' : '';
    $col = ($count == 0) ? 'colspan-3 rowspan-2' : '';

    $gallery_html .= "
        <a href=\"$full\" data-exthumbimage=\"$thumb\" data-src=\"$full\" class=\"grid-item $col$extra\">
            <img src=\"$thumb\" alt=\"\">
        </a>
    ";
    $count++;
    
}

if ($count == 0) {
    $gallery_html = '<p class="text-muted">No images found.</p>';
}

// Detail card HTML
$detail_html = '
                <div class="new-arrival-content alert alert-outline-light bg-light bg-opacity-25 outline-dashed pr">
                    <h4>'. $row_rcdmaterial['matdesc'] .'</h4>
                    <div class="d-table mb-2">
                        <p class="price float-start d-block fs-5">'.$row_rcdmaterial['matno'].'</p>
                    </div>
                    <p>Model : '.$row_rcdmaterial['modcode'].'</p>
                    <p>Inspection Date : ' . date('d-m-Y', strtotime($target_date)) . '</p>
                    <p>Production Date : ' . date('d-m-Y', strtotime($target_date)) . '</p>
                    <p>Shift : <span class="badge badge-secondary">' . $current_shiftdesc . '</span></p>
                </div>
            ';

echo json_encode([
    'gallery_html' => $gallery_html,
    'detail_html' => $detail_html
]);

?>

