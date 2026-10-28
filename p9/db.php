
<?php
$host = "localhost";
$dbname = "studenthub1";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Database Connected Successfully";
} catch (PDOException $e) {
    echo "Connection Failed";
}
?>
