<?php

$prd_transact = "SELECT * FROM transaction_type";
$stmtr_transact = $db_con->prepare($prd_transact); 
$stmtr_transact->execute();
$rst_transact = $stmtr_transact->get_result();                                                                 

while($row_transact = $rst_transact->fetch_array())
{
    if($row_transact['transid'] == 1) //inspection record
    {
        $ir_code = $row_transact['transcode'];
        $ir_max = sprintf('%04d',$row_transact['maximum_no']);
    }
    else if($row_transact['transid'] == 2) //inspection cancel
    {
        $ir_cancelcode = $row_transact['transcode'];
        $ir_cancelcode_max = sprintf('%04d',$row_transact['maximum_no']);
    }
    else if($row_transact['transid'] == 3) //sorting report
    {
        $sr_code = $row_transact['transcode'];
        $sr_code_max = sprintf('%04d',$row_transact['maximum_no']);
    }
    else if($row_transact['transid'] == 4) //sorting report cancel
    {
        $sr_cancelcode = $row_transact['transcode'];
        $sr_cancelcode_max = sprintf('%04d',$row_transact['maximum_no']);
    }
    else if($row_transact['transid'] == 5) //s2w
    {
        $s2w_code = $row_transact['transcode'];
        $s2w_code_max = sprintf('%04d',$row_transact['maximum_no']);
    }
    else if($row_transact['transid'] == 6) //s2w cancel
    {
        $s2w_cancelcode = $row_transact['transcode'];
        $s2w_cancelcode_max = sprintf('%04d',$row_transact['maximum_no']);
    }
    else if($row_transact['transid'] == 7) //s2w
    {
        $s2w_rp_code = $row_transact['transcode'];
        $s2w_rp_code_max = sprintf('%04d',$row_transact['maximum_no']);
    }
    else if($row_transact['transid'] == 8) //s2w cancel
    {
        $s2w_rp_cancelcode = $row_transact['transcode'];
        $s2w_rp_cancelcode_max = sprintf('%04d',$row_transact['maximum_no']);
    }


}

?>