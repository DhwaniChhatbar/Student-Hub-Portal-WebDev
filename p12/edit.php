
<?php
require_once 'auth.php';
require_admin();

include 'db.php';
include 'upload.php';

$id = (int) ($_GET['id'] ?? 0);
$error = "";

$result = mysqli_query($conn, "SELECT * FROM events WHERE id = $id");
$event = mysqli_fetch_assoc($result);

if (!$event) {
    die("Event not found.");
}

if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $date = mysqli_real_escape_string($conn, $_POST['event_date']);

    list($poster, $error) = upload_poster($_FILES['poster'] ?? null);

    if (!$error) {
        if ($poster) {
            $new_poster = mysqli_real_escape_string($conn, $poster);
            $old_poster = $event['poster'];

            mysqli_query($conn, "UPDATE events
                                 SET title = '$title',
                                     event_date = '$date',
                                     poster = '$new_poster'
                                 WHERE id = $id");

            if (!empty($old_poster)) {
                $file = 'uploads/' . basename($old_poster);

                if (is_file($file)) {
                    unlink($file);
                }
            }
        } else {
            mysqli_query($conn, "UPDATE events
                                 SET title = '$title',
                                     event_date = '$date'
                                 WHERE id = $id");
        }

        header("Location: index.php?msg=Event updated successfully");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Edit Event</title>
</head>
<body>

<h2>Edit Event</h2>

<?php if ($error): ?>
    <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
<?php endif; ?>

<form method="POST" enctype="multipart/form-data">
    <input type="text" name="title"
           value="<?php echo htmlspecialchars($event['title']); ?>" required>

    <input type="date" name="event_date"
           value="<?php echo htmlspecialchars($event['event_date']); ?>" required>

    <?php if (!empty($event['poster'])): ?>
        <p>Current poster:</p>
        <img src="uploads/<?php echo htmlspecialchars(basename($event['poster'])); ?>"
             alt="Current poster" width="100">
    <?php endif; ?>

    <p>Choose a new poster only if you want to replace the current one.</p>
    <input type="file" name="poster" accept=".jpg,.jpeg,.png,.webp">

    <button type="submit" name="update">Update Event</button>
</form>

<p><a href="index.php">Back to Events</a></p>

</body>
</html>
