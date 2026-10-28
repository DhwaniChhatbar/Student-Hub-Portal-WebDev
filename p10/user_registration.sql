CREATE DATABASE IF NOT EXISTS practical10_db;
USE practical10_db;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('Admin', 'Student') NOT NULL,
    remember_token_hash CHAR(64) DEFAULT NULL,
    remember_expiry DATETIME DEFAULT NULL
);

-- Seeded accounts for practical testing.
-- Passwords are generated using PHP password_hash().

INSERT INTO users (email, password, role)
VALUES
(
    'admin@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.',
    'Admin'
),
(
    'student@example.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.',
    'Student'
);