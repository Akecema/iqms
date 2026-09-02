<?php

$prd_app_status = "SELECT * FROM system_status";
$stmtr_app_status = $db_con->prepare($prd_app_status); 
$stmtr_app_status->execute();
$rst_app_status = $stmtr_app_status->get_result();                                                                 

while($row_app_status = $rst_app_status->fetch_array())
{
    if($row_app_status['statusid'] == 1) //New
    {
        $s_new_id = $row_app_status['statusid'];
        $s_new = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 2) //In Progress
    {
        $s_inprogress_id = $row_app_status['statusid'];
        $s_inprogress = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 3) //Pending
    {
        $s_pending_id = $row_app_status['statusid'];
        $s_pending = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 4) //Approved
    {
        $s_approved_id = $row_app_status['statusid'];
        $s_approved = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 5) //Completed
    {
        $s_completed_id = $row_app_status['statusid'];
        $s_completed = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 6) //Closed
    {
        $s_closed_id = $row_app_status['statusid'];
        $s_closed = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 7) //Rejected
    {
        $s_rejected_id = $row_app_status['statusid'];
        $s_rejected = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 8) //Cancelled
    {
        $s_cancelled_id = $row_app_status['statusid'];
        $s_cancelled = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 9) //Pending Review
    {
        $s_pendReview_id = $row_app_status['statusid'];
        $s_pendReview = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 10) //Pending Approval
    {
        $s_pendApproval_id = $row_app_status['statusid'];
        $s_pendApproval = $row_app_status['statusname'];
    }
     else if($row_app_status['statusid'] == 11) //Reviewed
    {
        $s_reviewed_id = $row_app_status['statusid'];
        $s_reviewed = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 12) //Return
    {
        $s_return_id = $row_app_status['statusid'];
        $s_return = $row_app_status['statusname'];
    }
    else if($row_app_status['statusid'] == 13) //Draft
    {
        $s_draft_id = $row_app_status['statusid'];
        $s_draft = $row_app_status['statusname'];
    }    
    else if($row_app_status['statusid'] == 14) //pending acknowledge
    {
        $s_pendAck_id = $row_app_status['statusid'];
        $s_pendAck = $row_app_status['statusname'];
    }    
    else if($row_app_status['statusid'] == 15) //acknowledge
    {
        $s_acknowledge_id = $row_app_status['statusid'];
        $s_acknowledge = $row_app_status['statusname'];
        
    }else if($row_app_status['statusid'] == 16) //Returned acknowledge
    {
        $s_returnAck_id = $row_app_status['statusid'];
        $s_returnAck = $row_app_status['statusname'];
    }

}

?>