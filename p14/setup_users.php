
<?php
require_once "db.php";

$users = [
    ["Faculty User", "faculty@example.com", "Faculty@123", "faculty"],
    ["Student User", "student@example.com", "Student@123", "student"]
];

$stmt = $pdo->prepare(
    "INSERT INTO users (username, email, password, role)
     VALUES (?, ?, ?, ?)
     ON DUPLICATE KEY UPDATE
     username = VALUES(username),
     password = VALUES(password),
     role = VALUES(role)"
);

foreach ($users as $user) {
    $stmt->execute([
        $user[0],
        $user[1],
        password_hash($user[2], PASSWORD_DEFAULT),
        $user[3]
    ]);
}

echo "Test accounts ready.<br>";
echo "Faculty: faculty@example.com / Faculty@123<br>";
echo "Student: student@example.com / Student@123<br>";
echo "Delete setup_users.php now.";
?>
