<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

$sr_id = $_POST['sr_id'];

$sqlsorting = "SELECT 
                s.sr_id,
                s.sr_docno,
                s.sr_qty_ok,
                s.sr_qty_ng,
                s.sr_sorting_method,
                s.sr_rework_method,
                s.sr_remarks
                FROM inspection_sorting s   
                WHERE s.sr_id = ?";
$stmtsorting = $db_con->prepare($sqlsorting);
$stmtsorting->bind_param("i", $sr_id);
$stmtsorting->execute();
$ressorting = $stmtsorting->get_result();
$sorting = $ressorting->fetch_assoc() ;

$sortingId = $sorting['sr_id'];

?>

<div class="col-xl-6 col-sm-6">
    <div class="card">
        <div class="card-body depostit-card">
            <div class="depostit-card-media d-flex justify-content-between style-1">
                <div>
                    <h6>Qty OK</h6>
                    <h3><?= $sorting['sr_qty_ok'] ?></h3>
                </div>
                <div>
                    <h6>Qty NG</h6>
                    <h3><?= $sorting['sr_qty_ng'] ?></h3>
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
            <p class="fw-semibold text-black"><?= $sorting['sr_docno'] ?></p>
        </div>
    </div>	
</div>

<hr>

<!-- METHOD -->
<div class="row">
    <div class="col-xl-6">
        <div class="card card-comment">
            <div class="card-body pb-0">
                <div class="d-flex py-2 mt-3 position-relative">
                    <div class="d-inline-block position-relative">
                        <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
                            <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-repeat" viewBox="0 0 16 16">
                                <path d="M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z"/>
                            </svg>
                        </div>
                        </div>
                    </div>
                    <div class="clearfix ms-4">
                        <h6 class="mb-1 fw-semibold">Sorting Method</h6>
                        <p class="fs-14 mb-0 text-black"><?=$sorting['sr_sorting_method'] ?></p>
                    </div>
                </div>
                <div class="d-flex py-2 mt-3 position-relative">
                    <div class="d-inline-block position-relative">
                        <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                                <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
                            </svg>
                        </div>
                    </div>
                    <div class="clearfix ms-4">
                        <h6 class="mb-1 fw-semibold">Rework Method</h6>
                        <p class="fs-14 mb-0 text-black"><?=$sorting['sr_rework_method'] ?></p>
                    </div>
                </div>
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
                        <h6 class="mb-1 fw-semibold">Remarks</h6>
                        <p class="fs-14 mb-0 text-black"><?=$sorting['sr_remarks'] ?></p>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="col-xl-4">
        <div class="modern-card mb-4">
            <div class="section-title"><i class="bi bi-exclamation-circle"></i> Photo Before (NG)</div>
                <div class="photo-box mb-2 d-flex flex-wrap">
                    <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                        <?php
                        $sqlBefore = "SELECT before_photoid, before_photo 
                                FROM inspection_sorting_before_photo 
                                WHERE sr_sorting_id = ?";
                        $stmtBefore = $db_con->prepare($sqlBefore);
                        $stmtBefore->bind_param("i", $sortingId);
                        $stmtBefore->execute();
                        $resBefore = $stmtBefore->get_result();

                        if ($resBefore->num_rows > 0) {
                            while ($p = $resBefore->fetch_assoc()) {
                                $BeforeUrl = 'gallery/inspection_sorting/before/' .$sortingId. '/' .$p['before_photo'];
                                echo '<img src="'.$BeforeUrl.'" class="photo-item viewAvatar avatar avatar-lg rounded-circle" data-full="'.$BeforeUrl.'">';
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
                <div class="section-title"><i class="bi bi-check2-circle"></i>  Photo After Sorting (OK)</div>

                <div class="photo-box mb-2 d-flex flex-wrap">
                    <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                        <?php
                        $sqlAfter = "SELECT after_photoid, after_photo 
                                        FROM inspection_sorting_after_photo 
                                        WHERE sr_sorting_id = ? ";
                        $stmtAfter = $db_con->prepare($sqlAfter);
                        $stmtAfter->bind_param("i", $sortingId);
                        $stmtAfter->execute();
                        $resAfter = $stmtAfter->get_result();

                        if ($resAfter->num_rows > 0) {
                            while ($c = $resAfter->fetch_assoc()) {
                                $AfterUrl = 'gallery/inspection_sorting/after/' .$sortingId. '/' .$c['after_photo'];
                                echo '<img src="'.$AfterUrl.'" class="photo-item viewAvatar avatar avatar-lg rounded-circle" data-full="'.$AfterUrl.'">';
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

<hr>

<div class="accordion-item accordion-header-bg-custom-2 accordion-bordered mb-3">
    <h2 class="accordion-header" id="headingTwo">
    <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        <i class="fa fa-building me-2 text-black"></i> RELATED LOOSE PART INVOLVE - In House Part (If any)
    </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
        <div class="accordion-body">

            <div class="sp-body">
                <div class="part-card-grid">

                    <?php 
                    
                    $stmt = $db_con->prepare("
                            SELECT p.srp_id_dept, p.srp_related_dept, p.srp_type_part_dept,
                                p.srp_mathdr_id_dept, p.srp_qty_ok_dept, p.srp_qty_ng_dept,
                                m.bom, m.bomdesc,
                                d.rd_dept_id, d.rd_dept_name,
                                t.tp_partid, t.tp_partname
                            FROM inspection_sorting_related_part_dept p
                            LEFT JOIN material_details m ON p.srp_mathdr_id_dept = m.matdet_id
                            LEFT JOIN related_departments d ON d.rd_dept_id = p.srp_related_dept
                            LEFT JOIN type_part t ON t.tp_partid = p.srp_type_part_dept
                            WHERE p.srp_ir_id_sorting = ?
                    ");
                    $stmt->bind_param("i", $sortingId);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    
                    if ($res->num_rows > 0) {                
                    while ($row = $res->fetch_assoc()) { ?>
                    
                    <div class="part-card">
                        <div class="pc-header">
                            <span class="pc-title badge badge-outline-sephire"><?= $row['rd_dept_name'] ?></span>
                            <span class="pc-type fs-10 fw-semibold"><?= $row['tp_partname'] ?></span>
                        </div>

                        <div class="pc-body">
                            <div> <span class="fs-13 fw-semibold">Part Number :  </span> <?= $row['bom'] ?></div>
                            <div> <span class="fs-13 fw-semibold">Part Name : </span> <?= htmlspecialchars($row['bomdesc']) ?></div>
                        </div>

                        <div class="pc-footer">
                            <div class="ok">OK : <?= $row['srp_qty_ok_dept'] ?></div>
                            <div class="ng">NG : <?= $row['srp_qty_ng_dept'] ?></div>
                        </div>
                    </div>

                    <?php } 
                    
                    } else {            
                        echo "<tr><td colspan='4' class='text-center text-danger'>No record</td></tr>";
                    }
                    ?>

                </div>
            </div>          
            
        </div>
    </div>
</div>

<div class="accordion-item accordion-header-bg-custom-2 accordion-bordered mb-3">
    <h2 class="accordion-header" id="headingThree">
    <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
        <i class="fa fa-truck me-2 text-black"></i> RELATED LOOSE PART INVOLVE - Tier 2 (If any)
    </button>
    </h2>
    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
        <div class="accordion-body">

            <div class="sp-body">
                <div class="part-card-grid">

                    <?php 
                    
                    $stmt = $db_con->prepare("
                                SELECT p.srp_id_vdr, p.srp_related_vdr, p.srp_type_part_vdr, p.srp_mathdr_id_vdr, 
                                    p.srp_qty_ok_vdr, p.srp_qty_ng_vdr,
                                    m.bom, m.bomdesc,
                                    v.rv_vendor_id, v.rv_vendor_name,
                                    t.tp_partid, t.tp_partname
                                FROM inspection_sorting_related_part_vendor p
                                LEFT JOIN material_details m ON p.srp_mathdr_id_vdr = m.matdet_id 
                                LEFT JOIN related_vendors v ON v.rv_vendor_id = p.srp_related_vdr
                                LEFT JOIN type_part t ON t.tp_partid = p.srp_type_part_vdr
                                WHERE p.srp_ir_id_sorting = ?
                            ");
                    $stmt->bind_param("i", $sortingId);
                    $stmt->execute();
                    $res = $stmt->get_result();
                    
                    if ($res->num_rows > 0) {                
                    while ($row = $res->fetch_assoc()) { ?>
                    
                    <div class="part-card">
                        <div class="pc-header">
                            <span class="pc-title badge badge-outline-sephire"><?= $row['rv_vendor_name'] ?></span>
                            <span class="pc-type fs-10 fw-semibold"><?= $row['tp_partname'] ?></span>
                        </div>

                        <div class="pc-body">
                            <div><span class="fs-13 fw-semibold">Part Number : </span> <?= $row['bom'] ?></div>
                            <div><span class="fs-13 fw-semibold">Part Name : </span> <?= htmlspecialchars($row['bomdesc']) ?></div>
                        </div>

                        <div class="pc-footer">
                            <div class="ok">OK : <?= $row['srp_qty_ok_vdr'] ?></div>
                            <div class="ng">NG : <?= $row['srp_qty_ng_vdr'] ?></div>
                        </div>
                    </div>

                    <?php } 
                    
                    } else {            
                        echo "<tr><td colspan='4' class='text-center text-danger'>No record</td></tr>";
                    }
                    ?>

                </div>
            </div>            
            
        </div>
    </div>
</div>

<div class="accordion-item accordion-header-bg-custom-2 accordion-bordered mb-3">
    <h2 class="accordion-header" id="headingFour">
    <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
        <i class="fa fa-users me-2 text-black"></i> FINISHED GOODS PART INVOLVE - Customer (If any)
    </button>
    </h2>
    <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
        <div class="accordion-body">

            <div class="sp-body">
                <div class="part-card-grid">

                    <?php 
                    $stmt = $db_con->prepare("
                        SELECT p.srp_id_cust, p.srp_related_cust,
                            p.srp_qty_ok_cust, p.srp_qty_ng_cust,
                            c.rc_cust_name, c.rc_cust_id
                        FROM inspection_sorting_related_part_cust p
                        LEFT JOIN related_customers c ON p.srp_related_cust = c.rc_cust_id
                        WHERE p.srp_ir_id_sorting = ?
                    ");
                    $stmt->bind_param("i", $sortingId);
                    $stmt->execute();
                    $res = $stmt->get_result();
                
                    
                    if ($res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) { ?>
                    
                    <div class="part-card">
                        <div class="pc-header">
                            <span class="pc-title"><?= $row['rc_cust_name'] ?></span>
                        </div>

                        <div class="pc-footer">
                            <div class="ok">OK : <?= $row['srp_qty_ok_cust'] ?></div>
                            <div class="ng">NG : <?= $row['srp_qty_ng_cust'] ?></div>
                        </div>
                    </div>

                    <?php } 
                    } else {            
                        echo "<tr><td colspan='4' class='text-center text-danger'>No record</td></tr>";
                    }?>

                </div>
            </div>         
            
        </div>
    </div>
</div>
