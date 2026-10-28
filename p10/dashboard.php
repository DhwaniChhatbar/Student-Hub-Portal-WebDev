
<?php

session_start();
require_once "db.php";

if (!isset($_SESSION["user_id"])) {
    require_once "remember_me.php";
}

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$timeout = 900;

if (time() - ($_SESSION["last_activity"] ?? 0) > $timeout) {
    header("Location: timeout.php");
    exit;
}

$_SESSION["last_activity"] = time();

$role = strtolower($_SESSION["role"] ?? "");

if ($role === "admin") {
    header("Location: admin_dashboard.php");
    exit;
}

if ($role === "student") {
    header("Location: student_dashboard.php");
    exit;
}

if ($role === "faculty") {
    header("Location: faculty_dashboard.php");
    exit;
}

header("Location: logout.php");
exit;

?>
