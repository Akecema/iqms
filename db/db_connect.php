<?php

// DB connection settings come from environment variables (Azure App
// Service Application Settings locally / .env when run outside App
// Service), so the app can be pointed at any MySQL server without
// editing code. Defaults match the previous hardcoded values for
// host/port/user/db names, matching the i-CHARM/mrin_online pattern.
//
// No fallback for the password: falling back to a hardcoded value here
// is exactly how a real secret ends up committed to git history in the
// first place. Fail loudly instead of silently connecting with a
// stale/leaked credential.
define("DB_HOST", getenv('DB_HOST') ?: '172.18.4.11');
define("DB_PORT", getenv('DB_PORT') ?: '3306');
define("DB_USER", getenv('DB_USER') ?: 'root');
define("DB_NAME1", getenv('DB_NAME1') ?: 'ingress_group');
define("DB_NAME2", getenv('DB_NAME2') ?: 'iqms');

$db_password = getenv('DB_PASSWORD');
if ($db_password === false || $db_password === '') {
	die('DB_PASSWORD environment variable is not set. Check Azure App Service Application Settings / your .env file.');
}
define("DB_PASSWORD", $db_password);

// Make the connection
$db_mast_con = mysqli_connect(DB_HOST . ':' . DB_PORT, DB_USER, DB_PASSWORD, DB_NAME1);
$db_con = mysqli_connect(DB_HOST . ':' . DB_PORT, DB_USER, DB_PASSWORD, DB_NAME2);

//
if(!$db_mast_con){
	die("Database Ingress Connection Error: ".mysqli_connect_error());
}

if(!$db_con){
	die("Database iQms Connection Error: ".mysqli_connect_error());
}

?>
