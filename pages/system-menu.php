<?php 

$qry_menu = "SELECT * FROM system_menu WHERE menu_id = '1' ";
$get_menu = $db_con->prepare($qry_menu);
$get_menu -> execute();

$rst_menu = $get_menu->get_result();
$row_menu = $rst_menu->fetch_array();

$side_menu = $row_menu['title'];
$side_menu2 = $row_menu['title_2'];
$side_menu3 = $row_menu['title_3'];
$side_menu4 = $row_menu['title_4'];
$side_menu5 = $row_menu['title_5'];
$side_menu6 = $row_menu['title_6'];
$side_menu7 = $row_menu['title_7'];
$side_menu8 = $row_menu['title_8'];
$side_menu9 = $row_menu['title_9'];
$side_menu10 = $row_menu['title_10'];
$side_menu11 = $row_menu['title_11'];
$side_menu12 = $row_menu['title_12'];
$side_menu13 = $row_menu['title_13'];
$side_menu14 = $row_menu['title_14'];
$side_menu15 = $row_menu['title_15'];
$side_menu16 = $row_menu['title_16'];

/* Master data */
$qry_menu_mast = "SELECT * FROM system_menu WHERE menu_id = '2' ";
$get_menu_mast = $db_con->prepare($qry_menu_mast);
$get_menu_mast -> execute();

$rst_menu_mast = $get_menu_mast->get_result();
$row_menu_mast = $rst_menu_mast->fetch_array();

$side_menu_mast = $row_menu_mast['title'];
$side_menu_mast2 = $row_menu_mast['title_2'];
$side_menu_mast3 = $row_menu_mast['title_3'];
$side_menu_mast4 = $row_menu_mast['title_4'];
$side_menu_mast5 = $row_menu_mast['title_5'];
$side_menu_mast6 = $row_menu_mast['title_6'];
$side_menu_mast7 = $row_menu_mast['title_7'];
$side_menu_mast8 = $row_menu_mast['title_8'];

$qry_menu_oth = "SELECT * FROM system_menu WHERE menu_id = '3' ";
$get_menu_oth = $db_con->prepare($qry_menu_oth);
$get_menu_oth -> execute();

$rst_menu_oth = $get_menu_oth->get_result();
$row_menu_oth = $rst_menu_oth->fetch_array();

$side_menu_timeline = $row_menu_oth['title'];
$side_menu_material = $row_menu_oth['title_2'];

$qry_menu_report = "SELECT * FROM system_menu WHERE menu_id = '4' ";
$get_menu_report = $db_con->prepare($qry_menu_report);
$get_menu_report -> execute();

$rst_menu_report = $get_menu_report->get_result();
$row_menu_report = $rst_menu_report->fetch_array();

$side_menu_report = $row_menu_report['title'];
$side_menu_report2 = $row_menu_report['title_2'];
$side_menu_report3 = $row_menu_report['title_3'];
$side_menu_report4 = $row_menu_report['title_4'];
$side_menu_report5 = $row_menu_report['title_5'];

?>