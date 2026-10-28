
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "db.php";

if (isset($_SESSION["user_id"])) {
    return;
}

$token = $_COOKIE["remember_token"] ?? "";

if ($token === "" || !preg_match('/^[a-f0-9]{64}$/', $token)) {
    return;
}

$tokenHash = hash("sha256", $token);

$stmt = $conn->prepare(
    "SELECT id, email, role FROM users
     WHERE remember_token_hash = ?
     AND remember_expiry > NOW()"
);
$stmt->bind_param("s", $tokenHash);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    setcookie("remember_token", "", [
        "expires" => time() - 3600,
        "path" => "/Practical10",
        "httponly" => true,
        "secure" => !empty($_SERVER["HTTPS"])
            && $_SERVER["HTTPS"] !== "off",
        "samesite" => "Lax"
    ]);
    return;
}

session_regenerate_id(true);

$_SESSION["user_id"] = $user["id"];
$_SESSION["email"] = $user["email"];
$_SESSION["role"] = $user["role"];
$_SESSION["last_activity"] = time();
$_SESSION["login_session_id"] = session_id();

$newToken = bin2hex(random_bytes(32));
$newHash = hash("sha256", $newToken);

$update = $conn->prepare(
    "UPDATE users SET remember_token_hash = ?
     WHERE id = ? AND remember_token_hash = ?"
);
$update->bind_param("sis", $newHash, $user["id"], $tokenHash);
$update->execute();

if ($update->affected_rows === 1) {
    setcookie("remember_token", $newToken, [
        "expires" => time() + 30 * 24 * 60 * 60,
        "path" => "/Practical10",
        "httponly" => true,
        "secure" => !empty($_SERVER["HTTPS"])
            && $_SERVER["HTTPS"] !== "off",
        "samesite" => "Lax"
    ]);
} else {
    unset($_SESSION["user_id"], $_SESSION["email"], $_SESSION["role"]);
}
?>
