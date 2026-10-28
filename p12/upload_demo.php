
<?php
require_once 'upload.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    list($fileName, $error) = upload_poster($_FILES['poster'] ?? null);

    if ($error) {
        $message = $error;
    } elseif ($fileName) {
        $message = "Upload successful: " . $fileName;
    } else {
        $message = "Please select an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Poster Upload Demo</title>
</head>
<body>
    <h2>Test Event Poster Upload</h2>

    <?php if ($message !== ''): ?>
        <p><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <label>Select poster (JPG, PNG or WEBP; maximum 2 MB):</label>
        <input type="file" name="poster" accept=".jpg,.jpeg,.png,.webp" required>
        <button type="submit">Upload Poster</button>
    </form>
</body>
</html>
