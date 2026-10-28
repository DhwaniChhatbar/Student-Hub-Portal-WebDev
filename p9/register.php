
<?php
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request.");
}

$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';

if ($username === '' || $email === '' || $password === '' || $confirm_password === '') {
    die("Please fill in all required fields.");
}

if (!preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username)) {
    die("Invalid username. Use 3-50 letters, numbers, or underscores.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die("Invalid email format.");
}

if (strlen($password) < 6) {
    die("Password must contain at least 6 characters.");
}

if ($password !== $confirm_password) {
    die("Passwords do not match.");
}

$checkStmt = $conn->prepare(
    "SELECT id FROM users WHERE username = ? OR email = ?"
);

$checkStmt->bind_param("ss", $username, $email);
$checkStmt->execute();
$checkStmt->store_result();

if ($checkStmt->num_rows > 0) {
    $checkStmt->close();
    $conn->close();
    die("Username or email already exists.");
}

$checkStmt->close();

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$insertStmt = $conn->prepare(
    "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
);

$insertStmt->bind_param("sss", $username, $email, $hashedPassword);

if ($insertStmt->execute()) {
    echo "Registration successful!";
} else {
    echo "Registration failed. Please try again.";
}

$insertStmt->close();
$conn->close();
?>