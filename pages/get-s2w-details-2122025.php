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
    
    <div class="mb-4 mt-4">
        <span>Document No : <span class="text-meron fs-semibold"><?= $rowS2W['s2w_docno'] ?></span></span>
    </div>
    
   
    <!-- METHOD -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card card-comment">
                <div class="card-body pb-0">                    
                    <div class="d-flex py-2 mt-3 mb-4 position-relative">
                        <div class="d-inline-block position-relative">
                            <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-chat-square-text" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1h-2.5a2 2 0 0 0-1.6.8L8 14.333 6.1 11.8a2 2 0 0 0-1.6-.8H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM2 0a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h2.5a1 1 0 0 1 .8.4l1.9 2.533a1 1 0 0 0 1.6 0l1.9-2.533a1 1 0 0 1 .8-.4H14a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                    <path d="M3 3.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5M3 6a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9A.5.5 0 0 1 3 6m0 2.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5"/>
                                </svg>
                            </div>
                        </div>
                        <div class="clearfix ms-4">
                            <h6 class="mb-1 fw-semibold">Additional Information (If Any)</h6>
                            <p class="fs-14 mb-0 text-black"><?=$rowS2W['s2w_additional_desc'] ?></p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-xl-4">

            <!-- Defect PHOTOS -->
            <div class="d-team mt-2">
                <span class="d-block text-black">Photos NG (Defect)</span>
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

                while ($p = $resDefect->fetch_assoc()) {
                    $DefectUrl = 'gallery/s2w/photo_defect/'. $s2w_id .'/'. $p['defect_photo'];
                ?>
                    <img src="<?= $DefectUrl ?>" 
                        class="viewAvatar avatar avatar-lg rounded-circle" 
                        data-full="<?= $DefectUrl ?>">
                <?php } ?>
                </div>
            </div>

            <!-- OK PHOTOS -->
            <div class="d-team mt-4">
                <span class="d-block text-black">Photo OK</span>
                <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                <?php
                $sqlOK = "SELECT ok_photoid,ok_photo
                                FROM inspection_s2w_ok_photo
                                WHERE s2w_id = ?
                                ORDER BY ok_photoid ASC ";
                $stmtOK = $db_con->prepare($sqlOK);
                $stmtOK->bind_param("i", $s2w_id);
                $stmtOK->execute();
                $resOK = $stmtOK->get_result();

                while ($c = $resOK->fetch_assoc()) {
                    $OKUrl = 'gallery/s2w/photo_ok/'. $s2w_id .'/'. $c['ok_photo'];
                ?>
                    <img src="<?= $OKUrl ?>" 
                        class="viewAvatar avatar avatar-lg rounded-circle" 
                        data-full="<?= $OKUrl ?>">
                <?php } ?>
                </div>
            </div>
        </div>
    </div> 

