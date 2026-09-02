<?php

//include '../db/db_connect.php';

include 'phpmailer.php'; 

//url
$qry_url = "SELECT url_desc FROM system_url ";
$stmtr_url = $db_con->prepare($qry_url);
$stmtr_url->execute();

$rst_url = $stmtr_url->get_result(); 
$row_url = $rst_url->fetch_array(); 

$system_url = $row_url['url_desc'];

//email settings
$qry_emsettings = "SELECT * FROM email_settings";
$stmtr_emsettings = $db_con->prepare($qry_emsettings);
$stmtr_emsettings->execute();

$rst_emsettings = $stmtr_emsettings->get_result(); 
$row_emsettings = $rst_emsettings->fetch_array(); 

$system_name = $row_emsettings['system_name'];
$host_name = $row_emsettings['host_name'];
$host = $row_emsettings['host'];
$email_username = $row_emsettings['email_username'];
$email_password = $row_emsettings['email_password'];
$port = $row_emsettings['port'];

//notification
$qry_notification = "SELECT * FROM email_notification";
$stmtr_notification = $db_con->prepare($qry_notification);
$stmtr_notification->execute();

$rst_notification = $stmtr_notification->get_result(); 


while($row_notification = $rst_notification->fetch_array())
{
    if($row_notification['notification_id'] == '1')
    {
        $esubject_1 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '2')
    {
        $esubject_2 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '3')
    {
        $esubject_3 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '4')
    {
        $esubject_4 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '5')
    {
        $esubject_5 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '6')
    {
        $esubject_6 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '7')
    {
        $esubject_7 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '8')
    {
        $esubject_8 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '9')
    {
        $esubject_9 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '9')
    {
        $esubject_9 = $row_notification['email_subject'];
    }
    else if($row_notification['notification_id'] == '10')
    {
        $esubject_10 = $row_notification['email_subject'];
    }

}

?>