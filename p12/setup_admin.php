
<?php
require_once 'db.php';

$username = 'admin';
$password = password_hash('admin123', PASSWORD_DEFAULT);

$stmt = $conn->prepare(
    "SELECT id FROM admin_users WHERE username = ?"
);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $stmt->close();

    $stmt = $conn->prepare(
        "UPDATE admin_users SET password = ? WHERE username = ?"
    );
    $stmt->bind_param("ss", $password, $username);
    $stmt->execute();

    echo "Admin account updated successfully.";
} else {
    $stmt->close();

    $stmt = $conn->prepare(
        "INSERT INTO admin_users (username, password) VALUES (?, ?)"
    );
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();

    echo "Admin account created successfully.";
}

$stmt->close();
$conn->close();

echo "<p>Username: admin</p>";
echo "<p>Password: admin123</p>";
?>
