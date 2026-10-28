<?php
require 'db.php';

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id < 1) {
    header("Location: index.php?error=" . urlencode("Invalid student ID."));
    exit;
}

$stmt = $conn->prepare(
    "SELECT id, name, email
     FROM students
     WHERE id = ? AND status = 'Active'"
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $conn->prepare(
        "UPDATE students SET status = 'Inactive'
         WHERE id = ? AND status = 'Active'"
    );

    $stmt->bind_param("i", $id);
    $stmt->execute();

    $changed = $stmt->affected_rows;
    $stmt->close();

    if ($changed === 1) {
        header("Location: index.php?message=" .
            urlencode("Student marked as inactive successfully."));
    } else {
        header("Location: index.php?error=" .
            urlencode("Failed to deactivate student."));
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Delete</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="form-container">

    <h2>Confirm Delete</h2>

    <p>Are you sure you want to deactivate this student?</p>

    <p>
        <strong>Name:</strong>
        <?= htmlspecialchars($student['name']) ?>
    </p>

    <p>
        <strong>Email:</strong>
        <?= htmlspecialchars($student['email']) ?>
    </p>

    <p class="warning">
        The record will be marked Inactive, not permanently deleted.
    </p>

    <form method="POST">
        <button type="submit" class="danger">
            Yes, Deactivate Student
        </button>
    </form>

    <a href="index.php" class="back">Cancel</a>

</div>

</body>
</html>