<?php
require 'db.php';

$error = '';

$name = '';
$email = '';
$course = '';
$phone = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $course = trim($_POST['course'] ?? '');
    $phone = trim($_POST['phone'] ?? '');

    if ($name === '' || $email === '' || $course === '') {
        $error = 'Name, email and course are required.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $stmt = $conn->prepare(
                "INSERT INTO students (name, email, course, phone)
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param("ssss", $name, $email, $course, $phone);
            $stmt->execute();
            $stmt->close();

            header("Location: index.php?message=" .
                urlencode("Student added successfully."));
            exit;

        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $error = 'This email address is already registered.';
            } else {
                $error = 'Failed to add student.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">

    <h2>Add Student</h2>

    <?php if ($error !== ''): ?>
        <div class="error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <form method="POST">

        <label>Name</label>
        <input
            type="text"
            name="name"
            value="<?= htmlspecialchars($name) ?>"
            required
        >

        <label>Email</label>
        <input
            type="email"
            name="email"
            value="<?= htmlspecialchars($email) ?>"
            required
        >

        <label>Course</label>
        <input
            type="text"
            name="course"
            value="<?= htmlspecialchars($course) ?>"
            required
        >

        <label>Phone</label>
        <input
            type="text"
            name="phone"
            value="<?= htmlspecialchars($phone) ?>"
        >

        <button type="submit">Add Student</button>

    </form>

    <a href="index.php" class="back">Back to Student List</a>

</div>

</body>
</html>