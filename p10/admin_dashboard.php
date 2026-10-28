
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

if (time() - ($_SESSION["last_activity"] ?? 0) > 900) {
    header("Location: timeout.php");
    exit;
}

if (strtolower($_SESSION["role"] ?? "") !== "admin") {
    http_response_code(403);
    exit("Unauthorized Access: Admin only.");
}

$_SESSION["last_activity"] = time();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome, <?= htmlspecialchars($_SESSION["email"]) ?></p>
    <p>You are logged in as Admin.</p>
    <a href="dashboard.php">Main Dashboard</a>
    <a href="logout.php">Logout</a>
</div>

</body>
</html>
