<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include '../shift.php';

$model = $_POST['model'];
$type = $_POST['type'];
$material_id = $_POST['material'];

//model
$sql_rcdmaterial = "SELECT H.matid, H.matdesc, H.matno, M.modcode, H.partside
                    FROM material_header H 
                    LEFT JOIN model_details M ON M.modid = H.modelid
                    LEFT JOIN model_type as P ON H.typeid = P.typeid
                    WHERE H.matid = '$material_id' and M.modid = '$model' ";
$result_rcdmaterial = mysqli_query($db_con, $sql_rcdmaterial);
$row_rcdmaterial = mysqli_fetch_assoc($result_rcdmaterial);

//material id
$gall_model = $row_rcdmaterial['modcode'];

$sql_img = "SELECT imagename FROM material_gallery WHERE image_matid = '$material_id' ORDER BY imagepriority ASC";
$result_img = mysqli_query($db_con, $sql_img);

$gallery_html = '';

$images = [];
while ($row_img = mysqli_fetch_assoc($result_img)) {
    $images[] = $row_img['imagename'];
}
$total = count($images);

$gallery_html = '<div class="gallery-container w-100">';

if ($total > 0) {
    // 1. Main image (First image)
    $img0 = $images[0];
    $path0 = "gallery/model/$gall_model/$material_id/$img0";
    $gallery_html .= "
        <div class=\"main-gallery-item\">
            <a href=\"$path0\" data-src=\"$path0\" data-exthumbimage=\"$path0\">
                <img src=\"$path0\" alt=\"Main Image\">
            </a>
        </div>
    ";

    // 2. Thumbnails (Next 3 images)
    if ($total > 1) {
        $gallery_html .= '<div class="gallery-thumbs mt-2">';
        // Loop for up to 3 thumbnails (indices 1, 2, 3)
        for ($i = 1; $i < min($total, 4); $i++) {
            $img = $images[$i];
            $path = "gallery/model/$gall_model/$material_id/$img";
            
            $overlay = '';
            // If this is the 3rd thumbnail (index 3) and there are more than 4 images total
            if ($i == 3 && $total > 4) {
                $remaining = $total - 4;
                if ($remaining > 0) {
                    $overlay = "<div class=\"more-overlay\">+" . sprintf("%02d", $remaining) . "</div>";
                }
            }

            $gallery_html .= "
                <div class=\"thumb-item\">
                    <a href=\"$path\" data-src=\"$path\" data-exthumbimage=\"$path\">
                        <img src=\"$path\" alt=\"Thumbnail $i\">
                        $overlay
                    </a>
                </div>
            ";
        }
        $gallery_html .= '</div>';
    }

    // 3. Hidden items for LightGallery (Remaining images)
    for ($i = 4; $i < $total; $i++) {
        $img = $images[$i];
        $path = "gallery/model/$gall_model/$material_id/$img";
        $gallery_html .= "<a href=\"$path\" data-src=\"$path\" data-exthumbimage=\"$path\" style=\"display:none;\"></a>";
    }
} else {
    $gallery_html .= '<p class="text-muted p-3">No images found.</p>';
}

$gallery_html .= '</div>';

$detail_html = '
                
    <div class="d-flex align-items-center border-bottom py-3">
        <div class="clearfix ms-2">
            <h6 class="mb-0 fw-semibold">Part Name</h6>
            <span class="fs-13">'. $row_rcdmaterial['matdesc'] .'</span>
        </div>
    </div>
    <div class="d-flex align-items-center border-bottom py-3">
        <div class="clearfix ms-2">
            <h6 class="mb-0 fw-semibold">Part No</h6>
            <span class="fs-13">'. $row_rcdmaterial['matno'] .'</span>
        </div>
    </div>
    <div class="d-flex align-items-center border-bottom py-3">
        <div class="clearfix ms-2">
            <h6 class="mb-0 fw-semibold">Model</h6>
            <span class="fs-13">' . $row_rcdmaterial['modcode'].' ('.$row_rcdmaterial["partside"].')' . '</span>
        </div>
    </div>
    <div class="d-flex align-items-center border-bottom py-3">
        <div class="clearfix ms-2">
            <h6 class="mb-0 fw-semibold">Inspection Date</h6>
            <span class="fs-13">'. date('d-m-Y', strtotime($target_date)) .'</span>
        </div>
    </div>
    <!--<div class="d-flex align-items-center border-bottom py-3">
        <div class="clearfix ms-2">
            <h6 class="mb-0 fw-semibold">Shift Date</h6>
            <span class="fs-13">'. date('d-m-Y', strtotime($target_date)) .'</span>
        </div>
    </div>-->
    <div class="d-flex align-items-center py-3">
        <div class="clearfix ms-2">
            <h6 class="mb-0 fw-semibold">Shift</h6>
            <span class="fs-13">' . $current_shiftdesc . '</span>
        </div>
    </div>';


echo json_encode([
    'gallery_html' => $gallery_html,
    'detail_html' => $detail_html
]);

?>

