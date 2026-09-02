<?php

session_start();
include '../db/db_connect.php';
include 'session-login.php';
include '../timezone.php';
include '../shift.php';

$material_id = $_POST['material'] ?? '';
$model    = $_POST['model'] ?? '';

$sql_rcdmaterial = "SELECT M.modcode 
                    FROM material_header H
                    LEFT JOIN model_details M ON M.modid = H.modelid
                    WHERE H.matid = '$material_id' AND M.modid = '$model'";
$res = mysqli_query($db_con, $sql_rcdmaterial);
$row = mysqli_fetch_assoc($res);
$gall_model = $row['modcode'] ?? '';

$sql_img = "SELECT imagename FROM material_gallery WHERE image_matid = '$material_id'";
$result_img = mysqli_query($db_con, $sql_img);

$gallery_html = '<div class="avatar-list avatar-list-inline" style="display: inline-block; margin-right: 0; padding-right: 0; font-size: 0;" >';

while ($row_img = mysqli_fetch_assoc($result_img)) {
    $img = "gallery/model/$gall_model/$material_id/".$row_img['imagename'];    
    $gallery_html .= '<a href="javascript:void(0);" class="viewAvatar" data-full="'.$img.'">
                        <img src="'.$img.'" class="avatar avatar-md rounded-circle" alt="">
                    </a>';
}

$gallery_html .= '</div>';

if (mysqli_num_rows($result_img) == 0) {
    $gallery_html = '<p class="text-muted">No images found.</p>';
}

echo $gallery_html;
