<?php

include "db/db_connect.php";

//System Title
$qry_syst_title = "SELECT * FROM system_list WHERE system_id = '2' ";
$get_syst_title = $db_mast_con->prepare($qry_syst_title);
//$get_syst_title -> bind_param('s', );
$get_syst_title -> execute();

$rst_syst_title = $get_syst_title -> get_result();
$row_syst_title = $rst_syst_title -> fetch_array();

$syst_title = $row_syst_title['system_title'];

?>