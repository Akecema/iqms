<?php

//session_start();
$sid = session_id();

if (!isset($_SESSION["username"])) {

	session_unset();
	session_destroy();
	
	header("location: ../index.php");
	exit;
}
else if (isset($_REQUEST['logout']) && $_REQUEST['logout'] == "true") {

	session_unset();
	session_destroy();

	header("location: ../index.php");
	exit;
}


?>