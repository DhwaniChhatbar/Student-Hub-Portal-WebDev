
<?php

session_start();
require_once "db.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: login.php");
    exit;
}

$email = trim($_POST["email"] ?? "");
$password = $_POST["password"] ?? "";

$stmt = $conn->prepare(
    "SELECT id, username, email, password, role FROM users WHERE email = ?"
);

$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || !password_verify($password, $user["password"])) {
    header("Location: login.php?error=1");
    exit;
}

session_regenerate_id(true);

$_SESSION["user_id"] = $user["id"];
$_SESSION["username"] = $user["username"];
$_SESSION["name"] = $user["username"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = strtolower($user["role"]);
$_SESSION["last_activity"] = time();
$_SESSION["login_session_id"] = session_id();

if (isset($_POST["remember"])) {
    $token = bin2hex(random_bytes(32));
    $tokenHash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 30 * 24 * 60 * 60);

    $update = $conn->prepare(
        "UPDATE users SET remember_token_hash = ?,
         remember_expiry = ? WHERE id = ?"
    );

    $update->bind_param(
        "ssi",
        $tokenHash,
        $expiry,
        $user["id"]
    );

    $update->execute();

    setcookie("remember_token", $token, [
        "expires" => time() + 30 * 24 * 60 * 60,
        "path" => "/",
        "httponly" => true,
        "secure" => !empty($_SERVER["HTTPS"])
            && $_SERVER["HTTPS"] !== "off",
        "samesite" => "Lax"
    ]);
}

header("Location: dashboard.php");
exit;

?>
