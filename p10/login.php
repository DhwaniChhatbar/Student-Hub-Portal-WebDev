
<?php

session_start();

if (isset($_SESSION["user_id"])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_GET["error"])) {
    $error = "Invalid email or password.";
} elseif (isset($_GET["timeout"])) {
    $error = "Session expired. Please log in again.";
} elseif (isset($_GET["logout"])) {
    $error = "You have logged out successfully.";
} elseif (isset($_GET["unauthorized"])) {
    $error = "Unauthorized access.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - Practical 10</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">
    <h2>Secure Login</h2>

    <?php if ($error !== ""): ?>
        <p class="message"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form action="authenticate.php" method="POST">
        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <label class="remember">
            <input type="checkbox" name="remember" value="1">
            Remember Me
        </label>

        <button type="submit">Login</button>
    </form>
</div>

</body>
</html>
