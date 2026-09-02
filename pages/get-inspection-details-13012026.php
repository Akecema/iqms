<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$ir_id = $_POST['ir_id'];

// Sequence palete
$sql = "SELECT I.ir_pallet_no, I.ir_docno
        FROM inspection_records as I  
        WHERE I.ir_id = ?";
$stmt = $db_con->prepare($sql);
$stmt->bind_param("s", $ir_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

?>

<div class="row">
    <div class="col-xl-3  col-lg-6 col-sm-6">
        <div class="widget-stat card bg-grn">
            <div class="card-body  p-4">
                <div class="media">
                    <span class="me-3">
                        <i class="la la-cog"></i>
                    </span>
                    <div class="media-body text-white mb-4">
                        <p class="mb-1">Pallet Sequence</p>
                        <h3 class="text-white"><?= $row['ir_pallet_no'] ?></h3>
                        <hr>
                        <small-12>Doc No  <?= $row['ir_docno'] ?></small-12>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <?php 

    $sqlDefect = "SELECT D.defect_id, D.defect_type, D.defect_area, T.defectname
                    FROM inspection_defect D
                    LEFT JOIN defect_type T ON D.defect_type = T.defectid
                    WHERE D.rcd_ir_id = ?";
    $stmtDefect = $db_con->prepare($sqlDefect);
    $stmtDefect->bind_param("i", $ir_id);
    $stmtDefect->execute();
    $resDefect = $stmtDefect->get_result();

    while ($defect = $resDefect->fetch_assoc()) {

        $defectId = $defect['defect_id'];

    ?>

    <div class="col-xl-4 col-sm-8">
        <div class="card box-hover">
            <div class="card-body">
                <div class="products style-1">
                    <div>
                        <h6><?= $defect['defectname'] ?></h6>
                        <span class="fs-14 d-block">Defect Area : 
                                <span class="text-primary"><?= $defect['defect_area'] ?></span>
                            </span>
                    </div>	
                </div>
                <div class="mt-4">
                    <p class=" mb-1 font-w500">Defect Photo</p>
                    <div class="photo-box mb-2 d-flex flex-wrap">
                        <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                            <?php
                            $sqlPhoto = "SELECT defect_photo FROM inspection_defect_photo 
                                        WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                            $stmtPhoto = $db_con->prepare($sqlPhoto);
                            $stmtPhoto->bind_param("ii", $ir_id, $defectId);
                            $stmtPhoto->execute();
                            $resPhoto = $stmtPhoto->get_result();

                            if ($resPhoto->num_rows > 0) {
                                while ($p = $resPhoto->fetch_assoc()) {
                                    $photoUrl = 'gallery/inspection/defect/' .$ir_id. '/' .$p['defect_photo'];
                                    echo '<img src="'.$photoUrl.'" class="photo-item viewAvatar avatar avatar-lg rounded-circle" data-full="'.$photoUrl.'">';
                                }
                            } else {
                                echo '<span class="text-muted">No photos available.</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p class=" mb-1 font-w500">Comparison Photo</p>
                    <div class="photo-box mb-2 d-flex flex-wrap">
                        <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                            <?php
                            $sqlCompare = "SELECT compare_photo FROM inspection_compare_photo 
                                        WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                            $stmtCompare = $db_con->prepare($sqlCompare);
                            $stmtCompare->bind_param("ii", $ir_id, $defectId);
                            $stmtCompare->execute();
                            $resCompare = $stmtCompare->get_result();

                            if ($resCompare->num_rows > 0) {
                                while ($p = $resCompare->fetch_assoc()) {
                                    $compareUrl = 'gallery/inspection/defect_compare/' .$ir_id. '/' .$p['compare_photo'];
                                    echo '<img src="'.$compareUrl.'" class="photo-item viewAvatar avatar avatar-lg rounded-circle" data-full="'.$compareUrl.'">';
                                }
                            } else {
                                echo '<span class="text-muted">No photos available.</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php } ?>

</div>