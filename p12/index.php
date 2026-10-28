
<?php
require_once 'auth.php';
require_admin();

include 'db.php';
include 'upload.php';

$error = "";

if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $date = mysqli_real_escape_string($conn, $_POST['event_date']);

    list($poster, $error) = upload_poster($_FILES['poster'] ?? null);

    if (!$error) {
        $poster_sql = $poster
            ? "'" . mysqli_real_escape_string($conn, $poster) . "'"
            : "NULL";

        mysqli_query($conn, "INSERT INTO events (title, event_date, poster)
                             VALUES ('$title', '$date', $poster_sql)");

        header("Location: index.php?msg=Event added successfully");
        exit();
    }
}

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    $result = mysqli_query($conn, "SELECT poster FROM events WHERE id = $id");
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        mysqli_query($conn, "DELETE FROM events WHERE id = $id");

        if (!empty($row['poster'])) {
            $file = 'uploads/' . basename($row['poster']);

            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    header("Location: index.php?msg=Event deleted successfully");
    exit();
}

$search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');

$result = mysqli_query($conn, "SELECT * FROM events
                               WHERE title LIKE '%$search%'
                               ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Event Management</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 100%; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        img { width: 70px; height: 90px; object-fit: cover; }
        .ok { color: green; }
        .err { color: red; }
    </style>
</head>
<body>

<h2>Admin Event Management</h2>

<p>
    Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?> |
    <a href="dashboard.php">Dashboard</a> |
    <a href="logout.php">Logout</a>
</p>

<h2>Add Event</h2>

<?php if (isset($_GET['msg'])): ?>
    <p class="ok"><?php echo htmlspecialchars($_GET['msg']); ?></p>
<?php endif; ?>

<?php if ($error): ?>
    <p class="err"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Event title" required>
    <input type="date" name="event_date" required>
    <input type="file" name="poster" accept=".jpg,.jpeg,.png,.webp">
    <button type="submit" name="add">Add Event</button>
</form>

<h2>Events</h2>

<form method="GET">
    <input type="text" name="search" placeholder="Search event title"
           value="<?php echo htmlspecialchars($_GET['search'] ?? ''); ?>">
    <button type="submit">Search</button>
    <a href="index.php">Reset</a>
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Poster</th>
        <th>Title</th>
        <th>Date</th>
        <th>Action</th>
    </tr>

    <?php while ($row = mysqli_fetch_assoc($result)): ?>
    <tr>
        <td><?php echo (int) $row['id']; ?></td>
        <td>
            <?php if (!empty($row['poster'])): ?>
                <img src="uploads/<?php echo htmlspecialchars(basename($row['poster'])); ?>"
                     alt="Event poster">
            <?php else: ?>
                No poster
            <?php endif; ?>
        </td>
        <td><?php echo htmlspecialchars($row['title']); ?></td>
        <td><?php echo htmlspecialchars($row['event_date']); ?></td>
        <td>
            <a href="edit.php?id=<?php echo (int) $row['id']; ?>">Edit</a> |
            <a href="index.php?delete=<?php echo (int) $row['id']; ?>"
               onclick="return confirm('Delete this event?');">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>
