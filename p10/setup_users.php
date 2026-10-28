<?php
require_once "db.php";

$users = [
    ["admin@example.com", "Admin@123", "Admin"],
    ["student@example.com", "Student@123", "Student"]
];

$stmt = $conn->prepare(
    "INSERT INTO users (email, password, role)
     VALUES (?, ?, ?)
     ON DUPLICATE KEY UPDATE password = VALUES(password),
                             role = VALUES(role)"
);

foreach ($users as $user) {
    $email = $user[0];
    $password = password_hash($user[1], PASSWORD_DEFAULT);
    $role = $user[2];

    $stmt->bind_param("sss", $email, $password, $role);
    $stmt->execute();
}

echo "Test accounts created successfully.<br>";
echo "Admin: admin@example.com / Admin@123<br>";
echo "Student: student@example.com / Student@123<br>";
echo "Delete setup_users.php after running it.";
?>