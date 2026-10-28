
<?php
function upload_poster($file) {
    if (!$file || $file['error'] == UPLOAD_ERR_NO_FILE) {
        return [null, null];
    }

    if ($file['error'] == UPLOAD_ERR_INI_SIZE ||
        $file['error'] == UPLOAD_ERR_FORM_SIZE ||
        $file['size'] > 2 * 1024 * 1024) {
        return [null, "Poster must be 2 MB or less."];
    }

    if ($file['error'] != UPLOAD_ERR_OK) {
        return [null, "Upload failed."];
    }

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
        return [null, "Only JPG, JPEG, PNG and WEBP files are allowed."];
    }

    if (!getimagesize($file['tmp_name'])) {
        return [null, "Please upload a valid image."];
    }

    if (!is_dir('uploads')) {
        return [null, "The uploads folder does not exist."];
    }

    $new_name = uniqid() . '.' . $ext;

    if (!move_uploaded_file($file['tmp_name'], 'uploads/' . $new_name)) {
        return [null, "Could not save the poster."];
    }

    return [$new_name, null];
}
?>
