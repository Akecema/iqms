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
    
    <div class="mb-4 mt-4">
        <span>Document No : <span class="text-meron fs-semibold"><?= $sorting['sr_docno'] ?></span></span>
    </div>
    
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-header border-0 chart-card">
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary-light rounded-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check" viewBox="0 0 16 16">
                                <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0z"/>
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <h4 class="mb-0"><?=$sorting['sr_qty_ok'] ?></h4>
                            <span>Qty OK</span>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="icon-box bg-primary-light rounded-circle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-x" viewBox="0 0 16 16">
                                <path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793z"/>
                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                            </svg>
                        </div>
                        <div class="ms-2">
                            <h4 class="mb-0"><?=$sorting['sr_qty_ng'] ?></h4>
                            <span>Qty NG </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- METHOD -->
    <div class="row">
        <div class="col-xl-6">
            <div class="card card-comment">
                <div class="card-body pb-0">
                    <div class="d-flex py-2 mt-3 position-relative">
                        <div class="d-inline-block position-relative">
                            <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sort-up" viewBox="0 0 16 16">
                                    <path d="M3.5 12.5a.5.5 0 0 1-1 0V3.707L1.354 4.854a.5.5 0 1 1-.708-.708l2-1.999.007-.007a.5.5 0 0 1 .7.006l2 2a.5.5 0 1 1-.707.708L3.5 3.707zm3.5-9a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5M7.5 6a.5.5 0 0 0 0 1h5a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zm0 3a.5.5 0 0 0 0 1h1a.5.5 0 0 0 0-1z"/>
                                </svg>
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
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-repeat" viewBox="0 0 16 16">
                                    <path d="M11 5.466V4H5a4 4 0 0 0-3.584 5.777.5.5 0 1 1-.896.446A5 5 0 0 1 5 3h6V1.534a.25.25 0 0 1 .41-.192l2.36 1.966c.12.1.12.284 0 .384l-2.36 1.966a.25.25 0 0 1-.41-.192m3.81.086a.5.5 0 0 1 .67.225A5 5 0 0 1 11 13H5v1.466a.25.25 0 0 1-.41.192l-2.36-1.966a.25.25 0 0 1 0-.384l2.36-1.966a.25.25 0 0 1 .41.192V12h6a4 4 0 0 0 3.585-5.777.5.5 0 0 1 .225-.67Z"/>
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

        <!-- BEFORE PHOTOS -->
            <div class="d-team mt-2">
                <span class="d-block text-black">Photo Before (NG)</span>
                <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                <?php
                $sqlBefore = "SELECT before_photoid, before_photo 
                                FROM inspection_sorting_before_photo 
                                WHERE sr_sorting_id = ?";
                $stmtBefore = $db_con->prepare($sqlBefore);
                $stmtBefore->bind_param("i", $sortingId);
                $stmtBefore->execute();
                $resBefore = $stmtBefore->get_result();

                while ($p = $resBefore->fetch_assoc()) {
                    $BeforeUrl = 'gallery/sorting/before/' . $p['before_photo'];
                ?>
                    <img src="<?= $BeforeUrl ?>" 
                        class="viewAvatar avatar avatar-lg rounded-circle" 
                        data-full="<?= $BeforeUrl ?>">
                <?php } ?>
                </div>
            </div>

            <!-- AFTER PHOTOS -->
            <div class="d-team mt-4">
                <span class="d-block text-black">Photo After Sorting (OK)</span>
                <div class="d-flex align-items-center avatar-list avatar-list-stacked mt-3">
                <?php
                $sqlAfter = "SELECT after_photoid, after_photo 
                                FROM inspection_sorting_after_photo 
                                WHERE sr_sorting_id = ? ";
                $stmtAfter = $db_con->prepare($sqlAfter);
                $stmtAfter->bind_param("i", $sortingId);
                $stmtAfter->execute();
                $resAfter = $stmtAfter->get_result();

                while ($c = $resAfter->fetch_assoc()) {
                    $AfterUrl = 'gallery/sorting/after/' . $c['after_photo'];
                ?>
                    <img src="<?= $AfterUrl ?>" 
                        class="viewAvatar avatar avatar-lg rounded-circle" 
                        data-full="<?= $AfterUrl ?>">
                <?php } ?>
                </div>
            </div>
        </div>
    </div> 

    <hr>

    <div class="p-3"><h5 class="mb-0 fw-semibold lh-1">Part Involve</h5></div>

    <!-- Part Involve -->
    <!-- 1. Department -->
    <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-0 p-3">
        <h2 class="accordion-header" id="headingTwo">
        <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
            <i class="fa fa-building me-2 text-black"></i> RELATED LOOSE PART INVOLVE - In House Part (If any)
        </button>
        </h2>
        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="table-responsive mb-2">
                    <table class="display table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartDept">
                        <colgroup>
                            <col style="width: 15%;">
                            <col style="width: 20%;">
                            <col style="width: 18%;">
                            <col style="width: 35%;">
                            <col style="width: 8%;">
                            <col style="width: 8%;">
                            <col style="width: 8%;">
                        </colgroup>
                        <thead class="thead-black">
                            <tr>
                                <th>Related Dept</th>
                                <th>Type of Part </th>
                                <th>Part Number</th>
                                <th>Part Name</th>
                                <th>QTY OK</th>
                                <th>QTY NG</th>
                            </tr>
                        </thead>
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

                        ob_start();

                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {

                        ?>
                        <tbody>
                            <tr>
                                <td><?= $row['rd_dept_name'] ?></td>
                                <td><?= $row['tp_partname'] ?></td>
                                <td><?= $row['bom'] ?></td>
                                <td><?= htmlspecialchars($row['bomdesc']) ?></td>
                                <td><?= $row['srp_qty_ok_dept'] ?></td>
                                <td><?= $row['srp_qty_ng_dept'] ?></td>
                            </tr>
                            <?php
                                }
                                } else {
                                    echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
                                } 
                            ?>

                        </tbody>
                    </table>
                </div>                
            </div>
        </div>
    </div>

    <!-- 2. Vendor -->
    <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-0 p-3">
        <h2 class="accordion-header" id="headingThree">
        <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
            <i class="fa fa-truck me-2 text-black"></i> RELATED LOOSE PART INVOLVE - Tier 2 (If any)
        </button>
        </h2>
        <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
            <div class="accordion-body">                                        
                <div class="table-responsive mb-2">
                    <table class="isplay table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartVendor">
                        <colgroup>
                            <col style="width: 15%;">
                            <col style="width: 20%;">
                            <col style="width: 18%;">
                            <col style="width: 35%;">
                            <col style="width: 8%;">
                            <col style="width: 8%;">
                            <col style="width: 8%;">
                        </colgroup>
                        <thead class="thead-black">
                            <tr>
                                <th>Related Vendor</th>
                                <th>Type of Part </th>
                                <th>Part Number</th>
                                <th>Part Name</th>
                                <th>QTY OK</th>
                                <th>QTY NG</th>
                            </tr>
                        </thead>

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

                        ob_start();

                        if ($res->num_rows > 0) {
                            while ($row = $res->fetch_assoc()) {
                                ?>
                        <tbody>
                        <tr>
                            <td><?= $row['rv_vendor_name'] ?></td>
                            <td><?= $row['tp_partname'] ?></td>
                            <td><?= $row['bom'] ?></td>
                            <td><?= htmlspecialchars($row['bomdesc']) ?></td>
                            <td><?= $row['srp_qty_ok_vdr'] ?></td>
                            <td><?= $row['srp_qty_ng_vdr'] ?></td>
                        </tr>
                        <?php
                                }
                            } else {
                                    echo "<tr><td colspan='7' class='text-center text-danger'>No record</td></tr>";
                                }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- 3. Customer -->
    <div class="accordion-item accordion-header-bg-custom accordion-bordered mb-0 p-3">
        <h2 class="accordion-header" id="headingFour">
        <button class="accordion-button collapsed d-flex align-items-center" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
            <i class="fa fa-users me-2 text-black"></i> FINISHED GOODS PART INVOLVE - Customer (If any)
        </button>
        </h2>
        <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#accordionExample">
            <div class="accordion-body">
                <div class="table-responsive mb-2">
                    <table class="display table mb-1 table-striped-thead table-wide table-md mt-4" id="relatedPartCustomer" style="width:600px">
                        <colgroup>
                            <col style="width: 40%;">
                            <col style="width: 10%;">
                            <col style="width: 10%;">
                            <col style="width: 8%;">
                        </colgroup>
                        <thead class="thead-black">
                            <tr>
                                <th>Related Customer</th>
                                <th>QTY OK</th>
                                <th>QTY NG</th>
                            </tr>
                        </thead>
                        <tbody>
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

                            ob_start();

                            if ($res->num_rows > 0) {
                                while ($row = $res->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($row['rc_cust_name']) ?></td>
                                <td><?= $row['srp_qty_ok_cust'] ?></td>
                                <td><?= $row['srp_qty_ng_cust'] ?></td>
                            </tr>
                            <?php
                                    }
                                } else {            
                                    echo "<tr><td colspan='4' class='text-center text-danger'>No record</td></tr>";
                                }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> 
