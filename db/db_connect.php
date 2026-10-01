<?php

// Refuse direct HTTP access. This file is meant to be include()'d by
// another script (SCRIPT_FILENAME will be that script, not this one) -
// requesting it directly by URL would run these mysqli_connect() calls
// with no auth check and no caller. This is a PHP-level guard rather than
// a web-server rule because Azure App Service's PHP 8.3 Linux stack fronts
// with Nginx, not Apache - .htaccess (an Apache-only mechanism) is a no-op
// here, confirmed live: db/db_connect.php returned a blank 200 before this
// fix. A PHP-level check works regardless of which web server is in front.
if (realpath($_SERVER['SCRIPT_FILENAME']) === __FILE__) {
    http_response_code(403);
    exit('Direct access forbidden.');
}

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
