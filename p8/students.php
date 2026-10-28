
<?php
require_once "db.php";

$sql = "SELECT * FROM students";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$students = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student List</title>
</head>
<body>
    <h2>Student List</h2>

    <?php foreach ($students as $student): ?>
        <?= htmlspecialchars($student["id"] ?? $student["student_id"] ?? "") ?> -
        <?= htmlspecialchars($student["name"]) ?> -
        <?= htmlspecialchars($student["email"]) ?> -
        <?= htmlspecialchars($student["course"]) ?>
        <br>
    <?php endforeach; ?>
</body>
</html>
