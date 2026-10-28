
<?php
session_start();
include 'db.php';

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);

    $result = mysqli_query($conn, "SELECT id, username, password
                                   FROM admin_users
                                   WHERE username = '$username'");

    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($_POST['password'], $admin['password'])) {
        session_regenerate_id(true);

        $_SESSION['admin_id'] = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
</head>
<body>

<h2>Admin Login</h2>

<?php if (isset($_GET['error'])): ?>
    <p>Please log in to access this page.</p>
<?php endif; ?>

<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit" name="login">Login</button>
</form>

</body>
</html>
