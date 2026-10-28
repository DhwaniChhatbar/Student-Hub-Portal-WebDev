
CREATE DATABASE IF NOT EXISTS practical14;
USE practical14;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'faculty', 'student') NOT NULL DEFAULT 'student',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    course VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    event_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NULL,
    registered_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(100) NOT NULL,
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL
);

INSERT IGNORE INTO users (name, email, password, role) VALUES
('Faculty User', 'faculty@example.com', 'not-used-for-demo', 'faculty'),
('Student User', 'student@example.com', 'not-used-for-demo', 'student');

INSERT IGNORE INTO students (name, email, course) VALUES
('Aarav Patel', 'aarav@example.com', 'CSE'),
('Diya Shah', 'diya@example.com', 'IT'),
('Kabir Mehta', 'kabir@example.com', 'CSE');

INSERT INTO events (title, event_date)
SELECT 'Web Development Workshop', '2026-11-10'
WHERE NOT EXISTS (
    SELECT 1 FROM events WHERE title = 'Web Development Workshop'
);

INSERT INTO events (title, event_date)
SELECT 'Cybersecurity Seminar', '2026-11-15'
WHERE NOT EXISTS (
    SELECT 1 FROM events WHERE title = 'Cybersecurity Seminar'
);

INSERT INTO registrations (user_id, event_id)
SELECT u.id, e.id
FROM users u
CROSS JOIN events e
WHERE u.role = 'student'
AND e.title = 'Web Development Workshop'
AND NOT EXISTS (
    SELECT 1 FROM registrations r
    WHERE r.user_id = u.id AND r.event_id = e.id
);
