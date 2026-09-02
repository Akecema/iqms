<?php

// $salt_password = "!Lg123p@$$";
// $u_password = hash('sha256', $salt_password);	

// echo $u_password;

$hashed = password_hash('123', PASSWORD_DEFAULT);
echo $hashed;
?>