<?php
require 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: index.php?error=" . urlencode("Invalid student ID."));
    exit;
}

$stmt = $conn->prepare(
    "SELECT * FROM students WHERE id = ? AND status = 'Active'"
);
$stmt->bind_param("i", $id);
$stmt->execute();

$student = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$student) {
    header("Location: index.php?error=" .
        urlencode("Active student not found."));
    exit;
}

$error = '';

$name = $student['name'];
$email = $student['email'];
$course = $student['course'];
$phone = $student['phone'];

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
                "UPDATE students
                 SET name = ?, email = ?, course = ?, phone = ?
                 WHERE id = ? AND status = 'Active'"
            );

            $stmt->bind_param(
                "ssssi",
                $name,
                $email,
                $course,
                $phone,
                $id
            );

            $stmt->execute();
            $stmt->close();

            header("Location: index.php?message=" .
                urlencode("Student details updated successfully."));
            exit;

        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $error = 'This email address is already registered.';
            } else {
                $error = 'Failed to update student details.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Student</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">

    <h2>Edit Student</h2>

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

        <button type="submit">Update Student</button>

    </form>

    <a href="index.php" class="back">Back to Student List</a>

</div>

</body>
</html>