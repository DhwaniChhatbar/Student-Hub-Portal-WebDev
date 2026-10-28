<?php
/**
 * db_connect.php
 * Establishes a MySQL connection for the StudentHub application
 * using the mysqli extension.
 */

// ---- Configuration (edit to match your environment) ----
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'studenthub');

// ---- Create connection ----
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// ---- Check connection ----
if (!$conn) {
    // In production, log this instead of exposing details to the user
    die('Database connection failed: ' . mysqli_connect_error());
}

// Ensure UTF-8 for correct character handling
mysqli_set_charset($conn, 'utf8mb4');