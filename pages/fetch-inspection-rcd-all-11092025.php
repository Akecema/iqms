<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

if($_POST['action'] == 'fetch_records_group')
{
    $columns = array('ir_material', 'ir_model', 'inspect_date', '	ir_shift', 'ir_status');

    $today = date('Y-m-d');
    $query = "SELECT I.inspect_date, I.inspect_group, I.ir_shift, T.modcode, P.typemodel, P.typeside, M.matno, M.matdesc,
                H.shiftdesc, H.shiftbadge,
                (   SELECT COUNT(*) 
                    FROM inspection_records AS I2 
                    WHERE I2.inspect_group = I.inspect_group
                )   AS pallet_count  
                FROM inspection_records AS I
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE I.ir_id != '' ";
   
    if (!empty($_POST['fd_model'])) {
        $fd_model = intval($_POST['fd_model']); // sanitize
        $query .= " AND I.ir_model = '$fd_model' ";
    }

    if (!empty($_POST['fd_type'])) {
        $fd_type = intval($_POST['fd_type']);
        $query .= " AND I.ir_type = '$fd_type' ";
    }

    if (!empty($_POST['fd_material'])) {
        $fd_material = intval($_POST['fd_material']);
        $query .= " AND I.ir_material = '$fd_material' ";
    }
    
    if (!empty($_POST['fd_shift'])) {
        $fd_shift = $_POST['fd_shift'];
        $query .= " AND I.ir_shift = '$fd_shift' ";
    }

    if (!empty($_POST['daterange'])) {
        $daterange = $_POST['daterange'];
        $dates = explode(' - ', $daterange);
        if (count($dates) == 2) {
            $start_date = DateTime::createFromFormat('d/m/Y', trim($dates[0]))->format('Y-m-d');
            $end_date = DateTime::createFromFormat('d/m/Y', trim($dates[1]))->format('Y-m-d');
            $query .= " AND DATE(I.inspect_date) BETWEEN '$start_date' AND '$end_date' ";
        }
    }

    if(isset($_POST["search"]["value"]))
    {
        $search = $_POST["search"]["value"];
        $query .= " AND (
            T.modcode LIKE '%$search%' OR 
            P.typemodel LIKE '%$search%' OR 
            P.typeside LIKE '%$search%' OR 
            M.matno LIKE '%$search%' OR 
            M.matdesc LIKE '%$search%'
        ) ";		
    }
   
    $query .= 'GROUP BY I.ir_model, I.ir_type, I.ir_material, I.ir_shift, I.inspect_date';

    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order']['0']['column'];
        $colDir = $_POST['order']['0']['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= 'ORDER BY I.inspect_date DESC';
    }


    $query1 = '';

    if($_POST["length"] != -1)
    {
        $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($db_con, $query));
    $result = mysqli_query($db_con, $query . $query1);

    $data = array();

    while($row = mysqli_fetch_array($result))
    {
        //Shift
        $badgeShift = $row["shiftbadge"];

        $isnpectiondate = date('d-m-Y', strtotime($row["inspect_date"]));
   
        $sub_array = array();
        $sub_array[] = '<div class="clearfix ms-2" data-inspect-group="'.$row["inspect_group"].'">
                            <h6 class="mb-0 fw-semibold">'.$row["matno"].'</h6>
                            <span class="fs-14">'.$row["matdesc"].'</span>
                        </div>'; 
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row["modcode"].'</h6>
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["typeside"].')'.'</span>
                        </div>'; 
        $sub_array[] = '<div class="hstack gap-2 fs-11"><a href="javascript:void(0)">'.$isnpectiondate.'</a></div>';
        $sub_array[] = '<div class="hstack gap-2 fs-11"><a href="javascript:void(0)" class="badge badge-rounded badge-sm '.$badgeShift.'">'.$row["shiftdesc"].'</a></div>';
        $sub_array[] = '<div class="d-flex justify-content-center mb-2"><a href="javascript:void(0)" class="badge badge-rounded badge-dark">'.$row["pallet_count"].'</a></div>';
        $sub_array[] = '<a href="javascript:void(0);"
                            class="btn btn-rounded btn-primary btn-xxs viewPallet" data-inspect-group="'.$row["inspect_group"].'" data-bs-toggle="tooltip" 
                                data-bs-placement="top" title="View all pallets sequence">
                            <i class="fa fa-cog"></i>
                        </a>';
        $sub_array[] = $row['inspect_group'];
        $data[] = $sub_array;
        
    }

    function get_all_data($db_con)
    {
        $query = "SELECT * FROM inspection_records WHERE created_by = '$session_id'";
        $result = mysqli_query($db_con, $query);
        return mysqli_num_rows($result);
    }

    $output = array(
    "draw"    => intval($_POST["draw"]),
    "recordsTotal"  =>  $number_filter_row,
    "recordsFiltered" => $number_filter_row,
    "data"    => $data
    );

    echo json_encode($output);
}

// All record by group
if($_POST['action'] == 'fetch_records_list')
{
    $igroup = $_POST['igroup'] ?? '';

    $columns = array('I.ir_docno', 'M.matno', 'T.modcode', 'I.ir_pallet_no', 'I.ir_result', 'I.ir_status');

    $query = "SELECT I.ir_id, I.ir_docno, I.ir_pallet_no, I.ir_result, I.ir_status,
                     I.inspect_date, I.inspect_group, I.ir_shift, I.created_date,
                     T.modcode, P.typemodel, P.typeside, 
                     M.matno, M.matdesc, 
                     H.shiftdesc
              FROM inspection_records AS I
              LEFT JOIN model_details AS T ON I.ir_model = T.modid
              LEFT JOIN model_type AS P ON I.ir_type = P.typeid
              LEFT JOIN material_header AS M ON I.ir_material = M.matid 
              LEFT JOIN shift_detail AS H ON I.ir_shift = H.shiftshort
              WHERE 1=1 ";

    // Filter by group
    if (!empty($igroup)) {
        $igroup = mysqli_real_escape_string($db_con, $igroup);
        $query .= " AND I.inspect_group = '$igroup' ";
    }

    // Filter: status
    if (!empty($_POST['fd_status'])) {
        $status = intval($_POST['fd_status']);
        $query .= " AND I.ir_status = '$status' ";
    }

    // Filter: result
    if (!empty($_POST['fd_result'])) {
        $result = mysqli_real_escape_string($db_con, $_POST['fd_result']);
        $query .= " AND I.ir_result = '$result' ";
    }

    // Keyword search
    if (!empty($_POST['fd_search'])) {
        $search = mysqli_real_escape_string($db_con, $_POST['fd_search']);

        if (strpos($search, '#') === 0) {
            // Remove the '#' and search pallet number only
            $palletSearch = substr($search, 1);
            $query .= " AND I.ir_pallet_no LIKE '%$palletSearch%' ";
        } else {
            // Search document number
            $query .= " AND I.ir_docno LIKE '%$search%' ";
        }
    }

    // Ordering
    if(isset($_POST["order"]))
    {
        $colIndex = $_POST['order'][0]['column'];
        $colDir   = $_POST['order'][0]['dir'];
        $query .= " ORDER BY " . $columns[$colIndex] . " $colDir ";
    }
    else
    {
        $query .= " ORDER BY I.ir_pallet_no ASC"; // default sort by pallet sequence
    }

    // Pagination
    $query1 = '';
    if($_POST["length"] != -1) {
        $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
    }

    $number_filter_row = mysqli_num_rows(mysqli_query($db_con, $query));
    $result = mysqli_query($db_con, $query . $query1);

    $data = array();

    while($row = mysqli_fetch_assoc($result))
    {
        // Badge for status
        $statusBadge = '';
        if ($row['ir_status'] != 1)
        {
            if ($row['ir_status'] == 4) $statusBadge = '<span class="badge badge-rounded badge-outline-warning badge-sm">Approved</span>';
            elseif ($row['ir_status'] == 5) $statusBadge = '<span class="badge badge-rounded badge-outline-pink badge-sm">Completed</span>';
            elseif ($row['ir_status'] == 8) $statusBadge = '<span class="badge badge-rounded badge-outline-oren badge-sm">Cancelled</span>';
            elseif ($row['ir_status'] == 9) $statusBadge = '<span class="badge badge-rounded badge-outline-purple badge-sm">Pending Review</span>';
            elseif ($row['ir_status'] == 12) $statusBadge = '<span class="badge badge-rounded badge-outline-success badge-sm">Returned</span>';
        }

        // Result dropdown
        $resultCell = '<select class="form-control result-select">
                            <option value="">Choose</option>
                            <option value="OK" '.($row['ir_result']=='OK'?'selected':'').'>OK</option>
                            <option value="NG" '.($row['ir_result']=='NG'?'selected':'').'>NG</option>
                       </select>';

        $sub_array = array();
        $sub_array[] = '<div class="clearfix ms-2">
                            <a href="javascript:void(0);" class="fw-semibold text-primary viewDocDetails" 
                                data-docno="'.$row["ir_docno"].'" title="Click to view details"><span class="fs-14">'.$row["ir_docno"].' </span>
                            </a>
                        </div>';
        $sub_array[] = '<div class="d-flex justify-content-center mb-2"><a href="javascript:void(0)" class="badge badge-rounded badge-outline-dark">'.$row["ir_pallet_no"]. '</div>';
        $sub_array[] = $resultCell;
        $sub_array[] = $statusBadge;
        $sub_array[] = '<a href="javascript:void(0);" class="btn btn-sm btn-primary editRecord" data-id="'.$row['ir_id'].'">Edit</a>';

        $data[] = $sub_array;
    }

    $output = array(
        "draw"            => intval($_POST["draw"]),
        "recordsTotal"    => $number_filter_row,
        "recordsFiltered" => $number_filter_row,
        "data"            => $data
    );

    echo json_encode($output);
}

//View details in Modal
if($_POST['action'] == 'inspection_details')
{

    function dateBlock($label, $datetime) {
        return '
            <div class="third-post style-2 mt-2">
                <div class="post-1">
                    <div class="post-data">
                        <span class="mb-1 d-block">Date ' . $label . '</span>
                        <div class="">
                            <span>
                                <h6 class="mb-1 text-primary">
                                    <small><i class="fa-solid fa-calendar-days me-2"></i></small>
                                    <span>' . date("j M Y", strtotime($datetime)) . ' | ' . date("h:i A", strtotime($datetime)) . '</span>
                                </h6>
                            </span>
                        </div>
                    </div>
                </div>
            </div>';
    }

    $docno = $_POST['docno'];

    $sql = "SELECT I.ir_id, I.ir_docno, I.ir_pallet_no, I.ir_result, I.ir_status, I.ir_shift,
            I.created_date, I.submitted_date, I.approved_date, I.cancelled_date, I.returned_date,  
            T.modcode, P.typemodel, P.typeside, 
            M.matno, M.matdesc, H.shiftdesc, H.shiftbadge, S.statusname
            FROM inspection_records as I    
            LEFT JOIN model_details as T ON I.ir_model = T.modid
            LEFT JOIN model_type as P ON I.ir_type = P.typeid
            LEFT JOIN material_header as M ON I.ir_material = M.matid     
            LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort     
            LEFT JOIN system_status as S ON I.ir_status = S.statusid 
            WHERE I.ir_docno = ?";
    $stmt = $db_con->prepare($sql);
    $stmt->bind_param("s", $docno);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $docno = $row['ir_docno'];
    $ir_id = $row['ir_id'];
    $ng_html = ''; 

    if ($row['ir_result'] === 'NG') {

        // 1. Get defect results (with type name)
        $sqlDefect = "SELECT D.defect_id, D.defect_type, D.defect_area, T.defectname
                    FROM inspection_defect D
                    LEFT JOIN defect_type T ON D.defect_type = T.defectid
                    WHERE D.rcd_ir_id = ?";
        $stmtDefect = $db_con->prepare($sqlDefect);
        $stmtDefect->bind_param("i", $ir_id);
        $stmtDefect->execute();
        $resDefect = $stmtDefect->get_result();

        if ($resDefect->num_rows > 0) {

            $ng_html .= '          
                <hr>
                <div class="px-4 pb-4">
                    <!--<h5 class="text-primary mt-3">Defects</h5>-->
                    <div class="table-responsive">
                        <table class="table table-border date-table" id="inspectionTable_defect">
                            <thead class="table-light">
                                <tr>
                                    <th>Defect Type</th>
                                    <th>Defect Area</th>
                                    <th>Defect Photo</th>
                                    <th>Comparison Photo</th>
                                </tr>
                            </thead>
                            <tbody>';
            
            while ($defect = $resDefect->fetch_assoc()) {
                
                $defectId = $defect['defect_id'];

                //Fetch defect photos
                $photoHtml = '';
                $sqlPhoto = "SELECT defect_photo FROM inspection_defect_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                $stmtPhoto = $db_con->prepare($sqlPhoto);
                $stmtPhoto->bind_param("ii", $ir_id, $defectId);
                $stmtPhoto->execute();
                $resPhoto = $stmtPhoto->get_result();

                $photoHtml .= '<div class="avatar-list avatar-list-stacked">';
                while ($photo = $resPhoto->fetch_assoc()) {

                    $photoUrl = 'gallery/defect/' . $photo['defect_photo'];
                    $photoHtml .= '<img src="'.$photoUrl.'" data-src="'.$photoUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $photoHtml .= '</div>';

                if ($photoHtml === '') $photoHtml = '<span class="text-muted">-</span>';

                //Fetch comparison photos
                $compareHtml = '';
                $sqlCompare = "SELECT compare_photo FROM inspection_compare_photo WHERE rcd_ir_id = ? AND rcd_defect_id = ?";
                $stmtCompare = $db_con->prepare($sqlCompare);
                $stmtCompare->bind_param("ii", $ir_id, $defectId);
                $stmtCompare->execute();
                $resCompare = $stmtCompare->get_result();

                $compareHtml .= '<div class="avatar-list avatar-list-stacked">';
                while ($compare = $resCompare->fetch_assoc()) {
                    $compareUrl = 'gallery/defect_compare/' . $compare['compare_photo'];
                    $compareHtml .= '<img src="'.$compareUrl.'" data-src="'.$compareUrl.'" class="zoomable-img avatar avatar-lg rounded-circle" alt="" style="width:40px;height:40px;">';
                }
                $compareHtml .= '</div>';

                if ($compareHtml === '') $compareHtml = '<span class="text-muted">-</span>';

                // Defect row
                $ng_html .= '
                    <tr>
                        <td>'.$defect['defectname'].'</td>
                        <td>'.$defect['defect_area'].'</td>
                        <td>'.$photoHtml.'</td>
                        <td>'.$compareHtml.'</td>
                    </tr>';
            }

            $ng_html .= '
                            </tbody>
                        </table>
                    </div>
                </div>';
                
        } else {
            $ng_html .= '<p class="text-muted px-4">No defect data found.</p>';
        }
    }

    //Result
    $badgeClass = "";

    if ($row["ir_result"] == 'OK') $badgeClass = 'badge-hijo';
    elseif ($row["ir_result"] == 'NG') $badgeClass = 'badge-meron';

    //Shift
    $badgeShift = $row["shiftbadge"];

    echo '<div class="card p-3 mb-3 rounded shadow-sm border">
    <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="d-flex align-items-center">
            <div class="rounded-circle bg-light text-dark fw-bold d-flex justify-content-center align-items-center" style="width: 40px; height: 40px;">
                1
            </div>
            <span class="ms-2 text-muted">Pallet Sequence</span>
        </div>
        <span class="badge bg-light text-dark">Status: <strong class="text-success">Completed</strong></span>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p class="mb-1 text-muted">Material</p>
            <p class="mb-1 fw-semibold text-success">53701-BZ830</p>
            <p class="text-success">FG–APRON SUB–ASSY FR FENDER RH</p>

            <p class="mb-1 text-muted mt-2">Model</p>
            <p class="fw-semibold text-success">APRON (RH)</p>
        </div>

        <div class="col-md-6">
            <p class="mb-1 text-muted">Doc no</p>
            <p class="fw-semibold text-success">3100010909250013</p>

            <div class="d-flex align-items-center gap-3 mt-2">
                <div>
                    <p class="mb-1 text-muted">Result</p>
                    <span class="badge bg-success rounded-pill px-3 py-1">OK</span>
                </div>
                <div>
                    <p class="mb-1 text-muted">Shift</p>
                    <span class="badge border border-purple text-purple rounded-pill px-3 py-1">Night</span>
                </div>
            </div>
        </div>
    </div>
</div>
';
    echo '<div class="row">
            <div class="col-lg-12">
                <div class="card mt-3">
                    <div class="card-header">                              
                        <div class="clearfix mb-1 d-flex">
                            <div class="me-3 avatar avatar-md style-1 border border-opacity-10 rounded d-flex align-items-center justify-content-center bg-white"
                                data-bs-toggle="tooltip" title="Pallet Sequence">
                                '.$row['ir_pallet_no'].'
                            </div>
                            <div class="media-body me-2">
                                <p class="mb-0">Pallet Sequence</p>
                            </div>
                        </div>
                    
                        <span class="float-end text-black">Status : <b>'.$row["statusname"].'</b></span> 
                    </div>
                    <div class="card-body">
                        <div class="row mb-5">
                            <div class="mt-4 col-xl-5 col-lg-3 col-md-6 col-sm-12">
                                <div class="clearfix mb-3 d-flex">
                                    <div class="media-body me-2">
                                        <p class="mb-0">Material</p>
                                        <h5 class="text-primary mb-0 mt-1 custom-text-mat">'.$row["matno"].'</h5>
                                        <h6 class="text-primary mb-0 custom-text-mat">'.$row["matdesc"].'</h6>

                                        <p class="mb-0 mt-3">Model</p>
                                        <h5 class="text-primary mb-0 mt-1 custom-text-mat">'.$row["typemodel"].' ('.$row["typeside"].')'.'</h5>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 col-xl-5 col-lg-3 col-md-6 col-sm-12">
                                <div class="clearfix mb-3 d-flex">
                                    <div class="media-body me-2">
                                        <p class="mb-0">Doc no</p>
                                        <h5 class="text-primary mb-0 mt-1 custom-text-mat">'.$row['ir_docno'].'</h5>                                                    

                                        <p class="mb-0 mt-3">Result</p>
                                        <h5 class="text-primary mb-0 mt-1 custom-text-mat"><span class="badge badge-rounded '.$badgeClass.'">'.$row["ir_result"].'</span></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 col-xl-2 col-lg-3 col-md-6 col-sm-12 d-flex justify-content-lg-end">
                                <div class="clearfix mb-3 d-flex">
                                    <div class="media-body me-2">
                                        <p class="mb-0">Shift</p>
                                        <h5 class="mb-0 mt-1 custom-text-mat"><span class="badge badge-rounded '.$badgeShift.'">'.$row["shiftdesc"].'</span></h5>
                                    </div>
                                </div>
                            </div>
                        </div>'
                        
                        . $ng_html .
                    
                    '</div>
                </div>
            </div>
        </div> ';
        
        $status = $row['ir_status']; // current status

        echo '
            <div class="accordion accordion-header-bg accordion-bordered mt-4">
                <div class="accordion-item">
                    <h2 class="accordion-header accordion-header-primary" id="headingTwo6">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo6">
                            <span class="accordion-header-icon"></span>
                            <span class="accordion-header-text"><i class="fa-solid fa-calendar-days me-2"></i>Activity Dates</span>
                        </button>
                    </h2>
                    <div id="collapseTwo6" class="accordion-collapse collapse" aria-labelledby="headingTwo6" data-bs-parent="#accordion-six">
                        <div class="accordion-body">
                            <div class="recent-post">';

                        // Always show Created Date
                        echo dateBlock("Created", $row['created_date']);

                        // Conditionally show other dates
                        if ($status == 9 && !empty($row['submitted_date'])) {
                            echo dateBlock("Submitted", $row['submitted_date']);
                        }
                        if (($status == 4 || $status == 5) && !empty($row['approved_date'])) {
                            echo dateBlock("Approved", $row['approved_date']);
                        }
                        if ($status == 8 && !empty($row['cancelled_date'])) {
                            echo dateBlock("Cancelled", $row['cancelled_date']);
                        }
                        if ($status == 12 && !empty($row['returned_date'])) {
                            echo dateBlock("Returned", $row['returned_date']);
                        }

                        echo '
                            </div>
                        </div>
                    </div>
                </div>
            </div>';

}

?>