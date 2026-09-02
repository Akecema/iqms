<?php

include '../timezone.php';
$session_id =  $_SESSION["username"];
$session_role =  $_SESSION["user_role"];
$session_comp =  $_SESSION["user_comp"];
$session_plant =  $_SESSION["user_plant"];
$session_force_password = $_SESSION['force_password_change'];

//appraisal system id
$systemid = '2';

$sql_staff = "SELECT L.*, E.*, D.*, M.*
              FROM user_login AS L
              LEFT JOIN employee_details as E ON E.staff_id = L.staff_id
              LEFT JOIN ingress_group.designation as D ON E.designation = D.design_id
              LEFT JOIN ingress_group.department as M ON E.department = M.dept_id
              WHERE L.username = ? ";
$stmtr_staff = $db_con->prepare($sql_staff); 
$stmtr_staff ->bind_param("s", $session_id);
$stmtr_staff ->execute();

$rst_staff  = $stmtr_staff ->get_result();                                                                 
$detail_staff = $rst_staff ->fetch_array();

$stf_staffid = $detail_staff['staff_id'];
$stf_name = $detail_staff['staff_name'];
$stf_shortname = $detail_staff['short_name'];
$stf_coid = $detail_staff['company'];
$stf_division = $detail_staff['division'];
$stf_identno = $detail_staff['identification_no'];
$stf_design = $detail_staff['design_name'];
$stf_departmentID = $detail_staff['department'];
$stf_department = $detail_staff['dept_name'];
$stf_department_code = $detail_staff['dept_code'];
$stf_email = $detail_staff['staff_email'];

$stf_username = $detail_staff['username'];
$stf_currpassword = $detail_staff['password'];
$change_pswrd_sta = $detail_staff['change_password'];

//gender
// $stf_gender = ($detail_staff['gender'] == 'M')?'Male':'Female';

//designation
$gsel_cdesg = "SELECT * FROM designation where design_id = ? ";
$gstmtr_cdesg = $db_mast_con->prepare($gsel_cdesg); 
$gstmtr_cdesg->bind_param("s", $stf_design);
$gstmtr_cdesg->execute();

$grst_cdesg = $gstmtr_cdesg->get_result();                                                                 
$grow_cdesg = $grst_cdesg->fetch_array();

$stf_desgname = $grow_cdesg['design_name'];

//hod
// $gsel_lhod = "SELECT TB1.*, TB2.*, TB3.*    
//                 FROM approval AS TB1
//                 LEFT JOIN appraisal.employee_details as TB2 ON TB1.appraisor = TB2.staff_id
//                 LEFT JOIN ingress_group.employees as TB3 ON TB1.appraisor = TB3.staff_id
//                 WHERE TB1.staff_id = ? ";
// $gstmtr_lhod = $db_mast_con->prepare($gsel_lhod); 
// $gstmtr_lhod->bind_param("s", $stf_staffid);
// $gstmtr_lhod->execute();

// $grst_lhod = $gstmtr_lhod->get_result();                                                                 
// $grow_lhod = $grst_lhod->fetch_array();

// $stf_hod = $grow_lhod['appraisor'];
// $stf_hodname = $grow_lhod['staff_name'];
// $stf_hodemail = $grow_lhod['email'];
// $stf_hod_accstatus = $grow_lhod['account_status'];

//user role
$query_emp_role = "SELECT * FROM user_roles WHERE staff_id = ? and system_id = ? ";
$stmtr_emp_role = $db_con->prepare($query_emp_role); 
$stmtr_emp_role->bind_param("ss", $stf_staffid, $systemid);
$stmtr_emp_role->execute();

$rst_emp_role = $stmtr_emp_role->get_result();                                                                 
$row_emp_role = $rst_emp_role->fetch_array();

$session_role = $row_emp_role['role'];

//authorization
// $query_emp_det_apps = "SELECT * FROM employee_details WHERE staff_id = ? ";
// $stmtr_emp_det_apps = $db_con->prepare($query_emp_det_apps); 
// $stmtr_emp_det_apps->bind_param("s", $stf_staffid);
// $stmtr_emp_det_apps->execute();

// $rst_emp_det_apps = $stmtr_emp_det_apps->get_result();                                                                 
// $row_emp_det_apps = $rst_emp_det_apps->fetch_array();

// $stf_appform = $row_emp_det_apps['appraisal_form'];
// $stf_do_kpi = $row_emp_det_apps['do_KPI'];
// $stf_do_apa = $row_emp_det_apps['do_APA'];
// $stf_upld_training = $row_emp_det_apps['upload_training'];
// $stf_nonex_appsor = $row_emp_det_apps['non_exec_appraisor'];
// $stf_manage_expat = $row_emp_det_apps['manage_expatriate'];
// $stf_relocation = $row_emp_det_apps['relocation'];

//if user is appraisor
// $query_auth_appsor = "SELECT appraisor FROM approval WHERE appraisor = ?";
// $stmtr_auth_appsor = $db_mast_con->prepare($query_auth_appsor); 
// $stmtr_auth_appsor->bind_param("s", $stf_staffid);
// $stmtr_auth_appsor->execute();

// $rst_auth_appsor = $stmtr_auth_appsor->get_result();                                                                 
// $row_auth_appsor = $rst_auth_appsor->num_rows;

//photo
$gsel_cphoto = "SELECT * FROM employee_photo WHERE identification_no = ? ";
$gstmtr_cphoto = $db_con->prepare($gsel_cphoto); 
$gstmtr_cphoto->bind_param("s", $stf_identno);
$gstmtr_cphoto->execute();

$grst_cphoto = $gstmtr_cphoto->get_result();                                                                 
$grow_cphoto = $grst_cphoto->fetch_array();

$gst_photo = $grow_cphoto['photo_name'];

if($grow_cphoto > 0 )
{    
    $stf_photo = '<img src="../photo/'.$gst_photo.'" class="avatar avatar-md">';
    $top_photo = '<img src="../photo/'.$gst_photo.'" class="avatar avatar-md" alt="">';
    $gst_photo = $grow_cphoto['photo_name'];
}
else
{
    $stf_photo = '<img src="images/avatar/pic7.jpg" class="avatar avatar-md" alt="">';
    $top_photo = '<img src="images/avatar/pic7.jpg" class="avatar avatar-md" alt="">';
    $gst_photo = 'pic7.jpg';
}

//PRODUCTION
// $imgServer = "http://172.18.1.14";

// if($grow_cphoto > 0 )
// {    
//     $stf_photo = '<img src="'.$imgServer.'/'.'Appraisal/photo/'.$gst_photo.'" class="avatar avatar-md">';
//     $top_photo = '<img src="'.$imgServer.'/'.'Appraisal/photo/'.$gst_photo.'" class="avatar avatar-md" alt="">';
// }
// else
// {
//     $stf_photo = '<img src="'.$imgServer.'/'.'Appraisal/assets/images/faces/9.jpg" class="avatar avatar-md" alt="">';
//     $top_photo = '<img src=".'.$imgServer.'/'.'Appraisal/assets/images/faces/9.jpg" class="avatar avatar-md" alt="">';
// }


?>