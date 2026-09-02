<?php

session_start();
header('Content-Type: application/json');
require '../db/db_connect.php';
include 'session-login.php';
include '../shift.php';
include 'system-status.php';

if($_POST['action'] == 'fetch_records')
{
     $columns = array('ir_material', 'ir_model', 'inspect_date', '	ir_shift', 'ir_status');

    /* https://stackoverflow.com/questions/22296500/mysqli-join-tables-from-2-different-databases */

    $today = date('Y-m-d');
    $query = "SELECT I.inspect_date, I.inspect_group, I.ir_shift, T.modcode, P.typemodel, P.typeside, M.matno, M.matdesc, H.shiftdesc,
                (   SELECT COUNT(*) 
                    FROM inspection_records AS I2 
                    WHERE I2.inspect_group = I.inspect_group
                )   AS pallet_count  
                FROM inspection_records AS I
                LEFT JOIN model_details as T ON I.ir_model = T.modid
                LEFT JOIN model_type as P ON I.ir_type = P.typeid
                LEFT JOIN material_header as M ON I.ir_material = M.matid 
                LEFT JOIN shift_detail as H ON I.ir_shift = H.shiftshort                         
                WHERE I.created_by = '$session_id' and I.shift_date = '$today'
                GROUP BY I.ir_model, I.ir_type, I.ir_material, I.ir_shift, I.inspect_date ";
   
    if(isset($_POST["search"]["value"]))
    {
        // $query .= ' AND (TB1.staff_name LIKE "%'.$_POST["search"]["value"].'%" ';
        // $query .= ' OR TB1.staff_id LIKE "%'.$_POST["search"]["value"].'%"'; 
        // $query .= ' OR TB1.identification_no LIKE "%'.$_POST["search"]["value"].'%"'; 
        // $query .= ' OR TB2.design_name LIKE "%'.$_POST["search"]["value"].'%"'; 
        // $query .= ' OR TB3.company_code LIKE "%'.$_POST["search"]["value"].'%"'; 
        // $query .= ' OR TB3.company LIKE "%'.$_POST["search"]["value"].'%"'; 
        // $query .= ' OR TB4.grade_name LIKE "%'.$_POST["search"]["value"].'%"'; 
        // $query .= ' OR TB5.branch_name LIKE "%'.$_POST["search"]["value"].'%"';         
        // $query .= ' OR TB6.dept_code LIKE "%'.$_POST["search"]["value"].'%"';                 
        // $query .= ' OR TB6.dept_name LIKE "%'.$_POST["search"]["value"].'%")'; 			
    }
   

    if(isset($_POST["order"]))
    {
        $query .= 'ORDER BY '.$columns[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].'  ';
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
        $badgeClass = '';

        if ($row["ir_shift"] == 'D') $badgeClass = 'badge-secondary';
        elseif ($row["ir_shift"] == 'N') $badgeClass = 'badge-danger';
   
        $sub_array = array();
        $sub_array[] = '<div class="clearfix ms-2" data-inspect-group="'.$row["inspect_group"].'">
                            <h6 class="mb-0 fw-semibold">'.$row["matno"].'</h6>
                            <span class="fs-14">'.$row["matdesc"].'</span>
                        </div>'; 
        $sub_array[] = '<div class="clearfix ms-2">
                            <h6 class="mb-0 fw-semibold">'.$row["modcode"].'</h6>
                            <span class="fs-14">'.$row["typemodel"].' ('.$row["typeside"].')'.'</span>
                        </div>';                   
        $sub_array[] = '<div class="hstack gap-2 fs-14"><a href="javascript:void(0)" class="badge light badge-rounded '.$badgeClass.'">'.$row["shiftdesc"].'</a></div>';
        $sub_array[] = '<div class="d-flex justify-content-center mb-2"><a href="javascript:void(0)" class="badge badge-rounded badge-light light">'.$row["pallet_count"].'</a></div>';
        $sub_array[] = '<a href="javascript:void(0);"
                            class="btn btn-rounded btn-primary btn-xxs viewPallet" data-inspect-group="'.$row["inspect_group"].'" data-bs-toggle="tooltip" 
                                data-bs-placement="top" title="View All Pallets">
                            <i class="fa fa-bars"></i>
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

?>