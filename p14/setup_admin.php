
<?php
require_once "db.php";

$username = "admin";
$email = "admin@example.com";
$password = password_hash("Admin@123", PASSWORD_DEFAULT);
$role = "admin";

$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->fetch()) {
    echo "An account with this email already exists. No changes made.";
} else {
    $stmt = $pdo->prepare(
        "INSERT INTO users (username, email, password, role)
         VALUES (?, ?, ?, ?)"
    );

    $stmt->execute([$username, $email, $password, $role]);

    echo "Admin account created successfully.";
    echo "<br>Email: admin@example.com";
    echo "<br>Password: Admin@123";
    echo "<br>Delete setup_admin.php now.";
}
?>
