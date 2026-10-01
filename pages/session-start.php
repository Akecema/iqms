
<?php

session_start();

// Auth guard: every page under pages/ includes this file before rendering
// anything or running session-login.php's DB queries. Without this check,
// any page here (e.g. dashboard-ip.php) was directly reachable by URL with
// no login at all - session-login.php used $_SESSION['username'] without
// ever verifying it was actually set. Centralized here (like the mysqli
// compat shim) so all 177 pages that include this file are covered by one
// fix instead of editing each individually.
if (!isset($_SESSION['username']) || $_SESSION['username'] === '') {
    header('Location: ../index.php');
    exit;
}

include 'session-login.php';
include 'session-unset.php';

?>