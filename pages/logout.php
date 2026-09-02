<?php

session_start();	
unset($_SESSION["username"]);
unset($_SESSION["user_role"]);
unset($_SESSION["user_comp"]);
unset($_SESSION["user_plant"]);	
unset($_SESSION['force_password_change']);

header('Refresh: 1; URL = ../index.php');

?>