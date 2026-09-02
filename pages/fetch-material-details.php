<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include '../shift.php';

header('Content-Type: application/json');

$ir_id = intval($_POST['ir_id'] ?? 0);

$sql = "SELECT R.ir_model, R.ir_type, R.ir_material, R.inspect_date, R.shift_date, R.ir_shift, 
                H.shiftdesc
        FROM inspection_records R
        LEFT JOIN shift_detail H ON R.ir_shift = H.shiftshort
        WHERE R.ir_id = ?";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("i", $ir_id);
$stmt->execute();
$row_ir = $stmt->get_result()->fetch_assoc();

$model = $row_ir['ir_model'];
$type = $row_ir['ir_type'];
$material_id = $row_ir['ir_material'];
$target_date = $row_ir['inspect_date'];
$current_shiftdesc = $row_ir['shiftdesc'];

//model
$sql_rcdmaterial = "SELECT H.matdesc, H.matno, H.partside, M.modcode
                    FROM material_header H 
                    LEFT JOIN model_details M ON M.modid = H.modelid
                    LEFT JOIN model_type as P ON H.typeid = P.typeid
                    WHERE H.matid = '$material_id' and M.modid = '$model' ";
$result_rcdmaterial = mysqli_query($db_con, $sql_rcdmaterial);
$row_rcdmaterial = mysqli_fetch_assoc($result_rcdmaterial);

//material id
$gall_model = $row_rcdmaterial['modcode'];

$sql_img = "SELECT imagename FROM material_gallery WHERE image_matid = '$material_id'";
$result_img = mysqli_query($db_con, $sql_img);

$gallery_html = '';

while ($row_img = mysqli_fetch_assoc($result_img)) {
    $view_img = $row_img['imagename'];
    $thumb = "gallery/model/$gall_model/$material_id/$view_img"; 
    $full  = "gallery/model/$gall_model/$material_id/$view_img";

    $gallery_html .= '
            <div class="col-lg-4 col-md-4 col-sm-6 col-6 mb-3">
                <a 
                    href="'.$full.'" 
                    class="lg-item d-block rounded-3 border overflow-hidden shadow-sm"
                    data-src="'.$full.'"
                    data-exthumbimage="'.$thumb.'"
                    data-lg-size="1600-1200">
                    <img 
                        src="'.$thumb.'" 
                        class="w-100" 
                        style="object-fit: cover; height: 120px;" 
                        alt=""
                        loading="lazy"
                    >
                </a>
            </div>';

}

if (empty($gallery_html)) {
    $gallery_html = '<p class="text-muted">No images found.</p>';
}

// Detail card HTML
$detail_html = '
                <div class="alert alert-primary border-primary outline-dashed py-3 px-3 mt-1 mb-3 mb-0 text-black d-flex">												
                    <div class="mx-3">
						<span fs-9>Part Name</span>
                        <p><strong class="text-primary">'. $row_rcdmaterial['matdesc'] .'</strong></p>	

                        <span fs-9>Part No</span>
                        <p><strong class="text-primary">'.$row_rcdmaterial['matno'].'</strong></p>

                        <span fs-9>Model</span>
                        <p><strong class="text-primary">'.$row_rcdmaterial['modcode'].' ('.$row_rcdmaterial["partside"].')'.'</strong></p>
                    </div>
                </div>
                <div class="d-flex align-items-center border-bottom py-3">
                    <div class="clearfix ms-2">
                        <h6 class="mb-0 fw-semibold">Shift Date</h6>
                        <span class="fs-13">'. date('d-m-Y', strtotime($target_date)) .'</span>
                    </div>
                </div>
                <div class="d-flex align-items-center border-bottom py-3">
                    <div class="clearfix ms-2">
                        <h6 class="mb-0 fw-semibold">Production Date</h6>
                        <span class="fs-13">'. date('d-m-Y', strtotime($target_date)) .'</span>
                    </div>
                </div>
                <div class="d-flex align-items-center py-3">
                    <div class="clearfix ms-2">
                        <h6 class="mb-0 fw-semibold">Shift</h6>
                        <span class="fs-13">' . $current_shiftdesc . '</span>
                    </div>
                </div>';

echo json_encode([
    'detail_html' => $detail_html,
    'gallery_html' => $gallery_html
]);
