
<?php
require_once "db.php";
require_once "auth.php";

if (isset($_SESSION["user_id"])) {
    if (strtolower($_SESSION["role"] ?? "") === "admin") {
        header("Location: dashboard.php");
    } else {
        header("Location: forbidden.php");
    }
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {
        $error = "Enter both email and password.";
    } else {
        $stmt = $pdo->prepare(
            "SELECT id, username, email, password, role
             FROM users
             WHERE email = ?"
        );

        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {
            session_regenerate_id(true);

            $_SESSION["user_id"] = (int) $user["id"];
            $_SESSION["name"] = $user["username"];
            $_SESSION["role"] = strtolower($user["role"]);

            if (strtolower($user["role"]) === "admin") {
                require_once "audit.php";
                logAction($pdo, "ADMIN_LOGIN", "Admin logged in");

                header("Location: dashboard.php");
            } else {
                header("Location: forbidden.php");
            }

            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>
</head>
<body>
    <h2>Admin Login</h2>

    <?php if ($error !== ""): ?>
        <p><?= htmlspecialchars($error, ENT_QUOTES, "UTF-8") ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>

        <br><br>

        <label for="password">Password</label>
        <input type="password" id="password" name="password" required>

        <br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>
