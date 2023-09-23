<?php

use AST\Cookie;

/**Require All Setup Files */
require_once realpath(__DIR__) . '/load.php';

/**Remove set cookie */
Cookie::instance()->delete("userlogin");

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

//now redirect
header("Location:" . get_redirect_path_from_url());