<?php

$accCode = 'AC';
$accPeriod = 'Open';
$accPeriod_co = 'Close';

//financail year yg active an open
$query_financialyr = "SELECT * FROM financial_year WHERE financial_accstatus = ? and financial_status = ?";
$stmtr_financialyr = $db_con->prepare($query_financialyr); 
$stmtr_financialyr->bind_param("ss", $accCode, $accPeriod);
$stmtr_financialyr->execute();

$rst_financialyr = $stmtr_financialyr->get_result();                                                                 
$row_financialyr = $rst_financialyr->fetch_array();

$financialyr = $row_financialyr['financial_year'];

//financial year still active but close
$query_financialyr_co = "SELECT * FROM financial_year WHERE financial_accstatus = ? and financial_status = ?";
$stmtr_financialyr_co = $db_con->prepare($query_financialyr_co); 
$stmtr_financialyr_co->bind_param("ss", $accCode, $accPeriod_co);
$stmtr_financialyr_co->execute();

$rst_financialyr_co = $stmtr_financialyr_co->get_result();                                                                 
$row_financialyr_co = $rst_financialyr_co->fetch_array();

$financialyr_co = $row_financialyr_co['financial_year'];

//check if current fyear still open
$query_crtopen = "SELECT * FROM financial_year WHERE financial_accstatus = ? and financial_status = ?";
$stmtr_crtopen  = $db_con->prepare($query_crtopen); 
$stmtr_crtopen ->bind_param("ss",  $accCode, $accPeriod);
$stmtr_crtopen ->execute();

$rst_crtopen = $stmtr_crtopen ->get_result();  
$row_crtopen = $rst_crtopen ->num_rows; 

?>