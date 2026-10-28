<?php
require 'db.php';

$message = $_GET['message'] ?? '';
$error = $_GET['error'] ?? '';

$search = trim($_GET['search'] ?? '');
$course = trim($_GET['course'] ?? '');

$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 5;
$offset = ($page - 1) * $limit;

$where = ["status = 'Active'"];
$params = [];
$types = '';

if ($search !== '') {
    $where[] = "(name LIKE ? OR email LIKE ? OR course LIKE ?)";
    $term = "%$search%";

    $params[] = $term;
    $params[] = $term;
    $params[] = $term;

    $types .= 'sss';
}

if ($course !== '') {
    $where[] = "course = ?";
    $params[] = $course;
    $types .= 's';
}

$whereSQL = implode(' AND ', $where);

$countSQL = "SELECT COUNT(*) AS total FROM students WHERE $whereSQL";
$stmt = $conn->prepare($countSQL);

if ($types !== '') {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$total = $stmt->get_result()->fetch_assoc()['total'];
$stmt->close();

$totalPages = max(1, (int)ceil($total / $limit));

$sql = "SELECT * FROM students
        WHERE $whereSQL
        ORDER BY id DESC
        LIMIT ? OFFSET ?";

$stmt = $conn->prepare($sql);

$queryParams = $params;
$queryTypes = $types . 'ii';

$queryParams[] = $limit;
$queryParams[] = $offset;

$stmt->bind_param($queryTypes, ...$queryParams);
$stmt->execute();

$result = $stmt->get_result();

$courses = $conn->query(
    "SELECT DISTINCT course FROM students ORDER BY course"
);

function h($value) {
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1>Student Management System</h1>

    <?php if ($message !== ''): ?>
        <div class="success"><?= h($message) ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
        <div class="error"><?= h($error) ?></div>
    <?php endif; ?>

    <div class="actions">
        <a href="add.php" class="button">Add Student</a>
        <a href="export.php" class="button export">Export CSV</a>
    </div>

    <form method="GET" class="filter-form">

        <input
            type="text"
            name="search"
            placeholder="Search name, email or course"
            value="<?= h($search) ?>"
        >

        <select name="course">
            <option value="">All Courses</option>

            <?php while ($c = $courses->fetch_assoc()): ?>
                <option
                    value="<?= h($c['course']) ?>"
                    <?= $course === $c['course'] ? 'selected' : '' ?>
                >
                    <?= h($c['course']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <button type="submit">Search / Filter</button>
        <a href="index.php" class="button reset">Reset</a>

    </form>

    <p>Total active students: <?= (int)$total ?></p>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Course</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
            <?php if ($result->num_rows > 0): ?>

                <?php while ($student = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= (int)$student['id'] ?></td>
                        <td><?= h($student['name']) ?></td>
                        <td><?= h($student['email']) ?></td>
                        <td><?= h($student['course']) ?></td>
                        <td><?= h($student['phone']) ?></td>
                        <td><?= h($student['status']) ?></td>

                        <td class="actions-cell">
                            <a
                                href="edit.php?id=<?= (int)$student['id'] ?>"
                                class="edit"
                            >Edit</a>

                            <a
                                href="delete.php?id=<?= (int)$student['id'] ?>"
                                class="delete"
                            >Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>

            <?php else: ?>
                <tr>
                    <td colspan="7">No active student records found.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a
                class="<?= $page === $i ? 'current' : '' ?>"
                href="?<?= h(http_build_query([
                    'search' => $search,
                    'course' => $course,
                    'page' => $i
                ])) ?>"
            ><?= $i ?></a>
        <?php endfor; ?>
    </div>

</div>

</body>
</html>