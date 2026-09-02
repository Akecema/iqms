<?php

// DB connection settings come entirely from environment variables (Azure
// App Service Application Settings), so the app can be pointed at any
// MySQL server without editing code. No fallback on any of these,
// including host/port/user/db names: falling back to a hardcoded value
// here is exactly how a real secret ends up committed to git history in
// the first place. All must be set as App Service Application Settings —
// see .env.example for the variable names.
define("DB_HOST", getenv('DB_HOST'));
define("DB_PORT", getenv('DB_PORT'));
define("DB_USER", getenv('DB_USER'));
define("DB_NAME1", getenv('DB_NAME1'));
define("DB_NAME2", getenv('DB_NAME2'));

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
