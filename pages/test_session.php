<?php
session_start();
$_SESSION["check"] = "WORKING";
echo $_SESSION["check"];
?>