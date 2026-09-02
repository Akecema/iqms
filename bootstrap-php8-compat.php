<?php
/**
 * PHP 8 compatibility shim.
 *
 * Auto-prepended to every request via .user.ini (auto_prepend_file).
 * This restores PHP 7-era runtime behavior that this codebase was written
 * against, so we don't have to touch hundreds of individual call sites.
 *
 * Currently handles:
 *  - mysqli error mode: as of PHP 8.1, mysqli reports SQL errors by
 *    throwing mysqli_sql_exception instead of returning false. This app
 *    relies throughout on the classic
 *        mysqli_query(...) or die('some message')
 *        mysqli_connect(...) or die('Database Connection Error')
 *    pattern, which expects a falsy return value on failure, not an
 *    exception (918 mysqli_query() call sites app-wide). Turning
 *    reporting off restores that PHP 7 behavior.
 */

if (function_exists('mysqli_report')) {
    mysqli_report(MYSQLI_REPORT_OFF);
}
