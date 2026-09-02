<?php
session_start();
require './db/db_connect.php';

if (!isset($_POST['btnlogin'])) {
    header("Location: index.php");
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];
$captcha  = $_POST['captcha'] ?? '';

// ------------------------------------------------
// 1. GET USER & DETAILS
// ------------------------------------------------
// We do NOT filter by account_locked='N' here, so we can detect if it IS locked.
$stmt = $db_con->prepare("
    SELECT 
        L.staff_id, 
        L.username, 
        L.password, 
        L.account_locked, 
        L.force_change_password,
        E.account_status,
        E.compcode, 
        E.compplant
    FROM user_login L
    LEFT JOIN employee_details E ON L.staff_id = E.staff_id
    WHERE L.username = ?
    LIMIT 1
");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    // SECURITY: Don't reveal if user exists, but here we don't have choice if we want to track failures by username?
    // Actually, if username doesn't exist, we can't lock it. 
    // We just show generic error.
    $_SESSION['login_error'] = 'Invalid username or password.';
    header("Location: index.php");
    exit;
}

// ------------------------------------------------
// 2. CHECK STATUS
// ------------------------------------------------

// A) Check if Inactive
// Assuming 'AC' is Active based on fetch-employee.php
if ($user['account_status'] !== 'AC') {
    $_SESSION['login_error'] = 'Your account is inactive. Please contact administrator.';
    header("Location: index.php");
    exit;
}

// B) Check if Locked
if ($user['account_locked'] === 'Y') {
    $_SESSION['login_error'] = 'Your account has been locked due to multiple failed attempts.';
    header("Location: index.php");
    exit;
}

// ------------------------------------------------
// 3. CHECK PREVIOUS FAILURES (For CAPTCHA / Logic)
// ------------------------------------------------
// Count failed attempts in the last 30 minutes (or total recent)
// The requirement says "failed to attempt more than 3 times".
// We'll check the total count of failures since last success (implied, or just raw count if we delete on success).
// Since we delete on success (step 5), counting all rows is fine.

$stmtFail = $db_con->prepare("SELECT COUNT(*) AS fail_count FROM user_failedlogin WHERE username = ?");
$stmtFail->bind_param("s", $username);
$stmtFail->execute();
$failCount = (int)$stmtFail->get_result()->fetch_assoc()['fail_count'];

// Optional: CAPTCHA check if attempts >= 3 (from previous logic)
// if ($failCount >= 3) {
//     if (empty($captcha) || $captcha !== ($_SESSION['captcha'] ?? '')) {
//         $_SESSION['login_error'] = 'Invalid CAPTCHA.';
//         $_SESSION['show_captcha'] = true;
//         header("Location: index.php");
//         exit;
//     }
// }

// ------------------------------------------------
// 4. VERIFY PASSWORD
// ------------------------------------------------
if (password_verify($password, $user['password'])) {
    
    // SUCCESS
    
    // 1. Reset failures
    $db_con->query("DELETE FROM user_failedlogin WHERE username = '" . $db_con->real_escape_string($username) . "'");
    
    // 2. Update Last Login (optional but good practice)
    $db_con->query("UPDATE user_login SET last_login = NOW() WHERE username = '" . $db_con->real_escape_string($username) . "'");
    
    // 3. Clear Session junk
    unset($_SESSION['show_captcha'], $_SESSION['captcha'], $_SESSION['login_error']);

    // 4. Set User Session
    $_SESSION['staff_id']            = $user['staff_id'];
    $_SESSION['username']            = $username;
    $_SESSION['user_comp']           = $user['compcode'];
    $_SESSION['user_plant']          = $user['compplant'];
    $_SESSION['force_password_change'] = $user['force_change_password'];
    
    $stmtRole = $db_con->prepare("SELECT role FROM user_roles WHERE staff_id = ? LIMIT 1");
    $stmtRole->bind_param("s", $user['staff_id']);
    $stmtRole->execute();
    $roleData = $stmtRole->get_result()->fetch_assoc();
    $_SESSION['user_role'] = $roleData['role'] ?? '';

    header("Location: pages/dashboard-ip.php");
    //header("Location: pages/home.php");
    exit;

} else {
    
    // FAILED
    
    // 1. Log failure
    $stmtInsert = $db_con->prepare("INSERT INTO user_failedlogin (username, login_date) VALUES (?, NOW())");
    $stmtInsert->bind_param("s", $username);
    $stmtInsert->execute();
    
    // 2. Refresh Count
    $failCount++;
    
    // 3. Check Lock Condition
    // "failed to attempt more than 3 times" => If count > 3 (i.e. 4 or more)
    if ($failCount > 3) {
        // Lock Account
        $stmtLock = $db_con->prepare("UPDATE user_login SET account_locked = 'Y', locked_date = NOW() WHERE username = ?");
        $stmtLock->bind_param("s", $username);
        $stmtLock->execute();
        
        $_SESSION['login_error'] = 'Your account has been locked due to multiple failed attempts.';
    } else {
        // 4. Show error + CAPTCHA trigger if needed
        $_SESSION['login_error'] = 'Invalid username or password.'; // Generic message usually safer, but context implies we distinguish locked.
        
        // If 3 attempts reached, show captcha next time
        if ($failCount >= 3) {
            $_SESSION['show_captcha'] = true;
        }
    }
    
    header("Location: index.php");
    exit;
}
?>
