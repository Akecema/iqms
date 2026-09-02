<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$s2w_id = $_POST['s2w_id'];

$sqlS2W = "SELECT S.s2w_id, S.s2w_docno, S.s2w_additional_desc, T.rd_dept_name
                FROM inspection_s2w S
                LEFT JOIN related_departments T ON S.s2w_send_to = T.rd_dept_id
                WHERE S.s2w_id = ?";
$stmtS2W = $db_con->prepare($sqlS2W);
$stmtS2W->bind_param("i", $s2w_id);
$stmtS2W->execute();
$resS2W = $stmtS2W->get_result();
$rowS2W = $resS2W->fetch_assoc() ;

?>

<div class="col-xl-6 col-sm-6">
    <div class="card">
        <div class="card-body depostit-card">            
            <div class="progress mb-2 mt-3">
                <div class="progress-bar progress-animated bg-primary" style="width: 80%"></div>
            </div>
            <small>Document No</small>
            <p class="fw-semibold text-black"><?= $rowS2W['s2w_docno'] ?></p>
        </div>
    </div>	
</div>

<div class="row g-4">

    <!-- LEFT SECTION: Additional Info -->
    <div class="col-xl-6">
        <div class="modern-card">
            <div class="d-flex align-items-start">
                <div>
                    <div class="section-title">
                        <i class="bi bi-info-circle"></i> Additional Information
                    </div>

                    <p class="text-dark fs-14 mb-0">
                        <?= $rowS2W['s2w_additional_desc'] ?: '<span class="text-muted">No additional info provided.</span>' ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="modern-card">
            <div class="d-flex align-items-start">
                <div>
                    <div class="section-title">
                        <i class="bi bi-person-check"></i> Send To
                    </div>

                    <p class="text-dark fs-14 mb-0">
                        <?= $rowS2W['rd_dept_name'] ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT SIDE: PHOTOS -->
    <div class="col-xl-6">

        <!-- DEFECT PHOTOS -->
        <div class="modern-card mb-4">
            <div class="section-title"><i class="bi bi-exclamation-circle"></i> Photos NG (Defect)</div>
                <div class="photo-box mb-2 d-flex flex-wrap">
                    <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                        <?php
                        $sqlDefect = "SELECT defect_photoid, defect_photo
                                        FROM inspection_s2w_defect_photo
                                        WHERE s2w_id = ?
                                        ORDER BY defect_photoid ASC";
                        $stmtDefect = $db_con->prepare($sqlDefect);
                        $stmtDefect->bind_param("i", $s2w_id);
                        $stmtDefect->execute();
                        $resDefect = $stmtDefect->get_result();

                        if ($resDefect->num_rows > 0) {
                            while ($p = $resDefect->fetch_assoc()) {
                                $DefectUrl = "gallery/inspection_s2w/photo_defect/$s2w_id/".$p['defect_photo'];
                                echo '<img src="'.$DefectUrl.'" class="photo-item viewAvatar avatar avatar-lg rounded-circle" data-full="'.$DefectUrl.'">';
                            }
                        } else {
                            echo '<span class="text-muted">No photos available.</span>';
                        }
                        ?>
                    </div>
                </div>
            </div>

            <!-- OK PHOTOS -->
            <div class="modern-card">
                <div class="section-title"><i class="bi bi-check2-circle"></i> Photos OK</div>

                <div class="photo-box mb-2 d-flex flex-wrap">
                    <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                        <?php
                        $sqlOK = "SELECT ok_photoid, ok_photo
                                    FROM inspection_s2w_ok_photo
                                    WHERE s2w_id = ?
                                    ORDER BY ok_photoid ASC";
                        $stmtOK = $db_con->prepare($sqlOK);
                        $stmtOK->bind_param("i", $s2w_id);
                        $stmtOK->execute();
                        $resOK = $stmtOK->get_result();

                        if ($resOK->num_rows > 0) {
                            while ($c = $resOK->fetch_assoc()) {
                                $OKUrl = "gallery/inspection_s2w/photo_ok/$s2w_id/".$c['ok_photo'];
                                echo '<img src="'.$OKUrl.'" class="photo-item viewAvatar avatar avatar-lg rounded-circle" data-full="'.$OKUrl.'">';
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
