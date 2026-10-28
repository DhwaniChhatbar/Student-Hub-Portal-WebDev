
<?php
require_once 'auth.php';
require_admin();

include 'db.php';

$result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM events");
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
</head>
<body>

<h2>Admin Dashboard</h2>

<p>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?></p>
<p>Total Events: <?php echo $row['total']; ?></p>

<a href="index.php">Manage Events</a> |
<a href="logout.php">Logout</a>

</body>
</html>
