
<?php
require_once "db.php";
require_once "auth.php";
require_once "audit.php";

requireAdmin();

// Record dashboard visit
logAction($pdo, "VIEW_DASHBOARD", "Admin viewed dashboard");

// Dashboard statistics
$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$studentCount = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$eventCount = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
$registrationCount = $pdo->query("SELECT COUNT(*) FROM registrations")->fetchColumn();

// Latest registrations
$registrations = $pdo->query(
    "SELECT r.id, s.name, s.email, e.title, r.registration_date
     FROM registrations r
     LEFT JOIN students s ON r.student_id = s.id
     LEFT JOIN events e ON r.event_id = e.id
     ORDER BY r.id DESC
     LIMIT 5"
)->fetchAll(PDO::FETCH_ASSOC);

// Latest audit logs
$logs = $pdo->query(
    "SELECT a.action, a.details, a.ip_address, a.created_at, u.username
     FROM audit_logs a
     LEFT JOIN users u ON a.user_id = u.id
     ORDER BY a.created_at DESC
     LIMIT 10"
)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard</title>
</head>
<body>

    <h1>Admin Dashboard</h1>

    <p>
        Welcome,
        <?= htmlspecialchars($_SESSION["name"] ?? "Admin", ENT_QUOTES, "UTF-8") ?>
    </p>

    <h2>Statistics</h2>
    <p>Total Users: <?= $userCount ?></p>
    <p>Total Students: <?= $studentCount ?></p>
    <p>Total Events: <?= $eventCount ?></p>
    <p>Total Registrations: <?= $registrationCount ?></p>

    <h2>Latest Registrations</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Event</th>
            <th>Registration Date</th>
        </tr>

        <?php foreach ($registrations as $registration): ?>
            <tr>
                <td><?= htmlspecialchars((string) $registration["id"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($registration["name"] ?? "N/A", ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($registration["email"] ?? "N/A", ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($registration["title"] ?? "N/A", ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($registration["registration_date"] ?? "N/A", ENT_QUOTES, "UTF-8") ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <h2>Audit Logs</h2>

    <table border="1" cellpadding="8">
        <tr>
            <th>Username</th>
            <th>Action</th>
            <th>Details</th>
            <th>IP Address</th>
            <th>Date</th>
        </tr>

        <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= htmlspecialchars($log["username"] ?? "N/A", ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($log["action"], ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($log["details"] ?? "", ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($log["ip_address"] ?? "", ENT_QUOTES, "UTF-8") ?></td>
                <td><?= htmlspecialchars($log["created_at"], ENT_QUOTES, "UTF-8") ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <p><a href="logout.php">Logout</a></p>

</body>
</html>
