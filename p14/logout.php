
<?php
require_once "db.php";
require_once "auth.php";
require_once "audit.php";

if (isset($_SESSION["user_id"]) &&
    ($_SESSION["role"] ?? "") === "admin") {
    logAction($pdo, "ADMIN_LOGOUT", "Admin logged out");
}

$_SESSION = [];
session_destroy();

header("Location: login.php");
exit;
?>
