<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';
include 'encrypt.php';

$pst_datenow = date('Y-m-d H:i:s');	



    $irid = $_POST['irid'] ?? '';

    $html = '
        <div class="row">
            <div class="col-md-12">
                <h6>Document No Details</h6>
                <p>IR ID: '.$irid.'</p>
            </div>
        </div>
    ';

    echo $html;

// View details in Modal
// if($_POST['action'] == 'docno_details')
// {
//     $irid = $_POST['irid'];

//     $sql = "SELECT I.ir_docno, T.sr_docno, P.s2w_docno, P.s2w_docnocancel, P.s2w_status
//             FROM inspection_records as I    
//             LEFT JOIN inspection_sorting as T ON I.ir_id = T.sr_ir_id
//             LEFT JOIN inspection_s2w as P ON I.ir_id = P.s2w_ir_id
//             WHERE I.ir_id = ?";
//     $stmt = $db_con->prepare($sql);
//     $stmt->bind_param("s", $irid);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     $row = $result->fetch_assoc();

//     echo '<div class="card">
//             <div class="card-header pb-0 border-0">
//                 <div class="clearfix">
//                     <h4 class="card-title mb-0">Document No</h4>
//                     <!--<small class="d-block">84 New Tasks & 29 Guides</small>-->
//                 </div>
//             </div>
//             <div class="card-body">
//                 <div class="d-flex align-items-center py-2 hover-bg-light rounded my-1">
//                     <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
//                         <img src="icons/check-icon-inspection.jpg" alt="" width="28" height="28">
//                     </div>
//                     <div class="clearfix ms-3">
//                         <h6 class="mb-0 fw-semibold">Inspection</h6>
//                         <span class="fs-13">'.$row['ir_docno'].'</span>
//                     </div>
//                     <div class="clearfix ms-auto">
//                         <span class="badge badge-sm badge-light">0</span>
//                     </div>
//                 </div>
//                 <div class="d-flex align-items-center py-2 hover-bg-light rounded my-1">
//                     <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
//                         <img src="icons/icon-sorting.jpg" alt="" width="24" height="24">
//                     </div>
//                     <div class="clearfix ms-3">
//                         <h6 class="mb-0 fw-semibold">Sorting</h6>
//                         <span class="fs-13">'.$row['sr_docno'].'</span>
//                     </div>
//                     <div class="clearfix ms-auto">
//                         <span class="badge badge-sm badge-light">3</span>
//                     </div>
//                 </div>
//                 <div class="d-flex align-items-center py-2 hover-bg-light rounded my-1">
//                     <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
//                         <img src="icons/icon-s2w.jpg" alt="" width="26" height="21">
//                     </div>
//                     <div class="clearfix ms-3">
//                         <h6 class="mb-0 fw-semibold">Something When Wrong (S2W)</h6>
//                         <span class="fs-13">'.$row['s2w_docno'].'</span>
//                     </div>
//                     <div class="clearfix ms-auto">
//                         <span class="badge badge-sm badge-light">0</span>
//                     </div>
//                 </div>';

//                 if($row['s2w_status'] === 8) {
//                 echo '<div class="d-flex align-items-center py-2 hover-bg-light rounded my-1">
//                     <div class="avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white">
//                         <img src="icons/icon-cancel.png" alt="" width="20" height="20">
//                     </div>
//                     <div class="clearfix ms-3">
//                         <h6 class="mb-0 fw-semibold">Something When Wrong (S2W) Cancellation</h6>
//                         <span class="fs-13">'.$row['s2w_docnocancel'].'</span>
//                     </div>
//                     <div class="clearfix ms-auto">
//                         <span class="badge badge-sm badge-light">0</span>
//                     </div>
//                 </div>';
//                 }
//            echo '</div>
//         </div>';
// }

?>