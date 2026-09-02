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
<div class="col-xl-6 col-sm-6">
    <div class="card">
        <div class="card-body depostit-card">
            <div class="depostit-card-media d-flex justify-content-between style-1">
                <div>
                    <h6>Pallet Sequence</h6>
                    <h3><?= $row['ir_pallet_no'] ?></h3>
                </div>
                <div class="icon-box bg-secondary">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_3_566)">
                        <path opacity="0.3" fill-rule="evenodd" clip-rule="evenodd" d="M8 3V3.5C8 4.32843 8.67157 5 9.5 5H14.5C15.3284 5 16 4.32843 16 3.5V3H18C19.1046 3 20 3.89543 20 5V21C20 22.1046 19.1046 23 18 23H6C4.89543 23 4 22.1046 4 21V5C4 3.89543 4.89543 3 6 3H8Z" fill="#222B40"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M10.875 15.75C10.6354 15.75 10.3958 15.6542 10.2042 15.4625L8.2875 13.5458C7.90417 13.1625 7.90417 12.5875 8.2875 12.2042C8.67083 11.8208 9.29375 11.8208 9.62917 12.2042L10.875 13.45L14.0375 10.2875C14.4208 9.90417 14.9958 9.90417 15.3792 10.2875C15.7625 10.6708 15.7625 11.2458 15.3792 11.6292L11.5458 15.4625C11.3542 15.6542 11.1146 15.75 10.875 15.75Z" fill="#222B40"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11 2C11 1.44772 11.4477 1 12 1C12.5523 1 13 1.44772 13 2H14.5C14.7761 2 15 2.22386 15 2.5V3.5C15 3.77614 14.7761 4 14.5 4H9.5C9.22386 4 9 3.77614 9 3.5V2.5C9 2.22386 9.22386 2 9.5 2H11Z" fill="#222B40"/>
                        </g>
                        <defs>
                        <clipPath id="clip0_3_566">
                        <rect width="24" height="24" fill="white"/>
                        </clipPath>
                        </defs>
                    </svg>
                </div>
            </div>
            <div class="progress mb-2 mt-3">
                <div class="progress-bar progress-animated bg-primary" style="width: 80%"></div>
            </div>
            <small>Document No</small>
            <p class="fw-semibold text-black"><?= $row['ir_docno'] ?></p>
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