<?php
$errors = [];
$storage_mode = 'csv'; // Options: 'csv' or 'json'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitize & Validate Inputs
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $pincode = trim($_POST['pincode'] ?? '');

    if (empty($name)) {
        $errors[] = "Name is required.";
    } else {
        $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
    }

    if (empty($email)) {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email address format.";
    }

    if (empty($mobile)) {
        $errors[] = "Mobile number is required.";
    } elseif (!preg_match('/^[0-9]{10}$/', $mobile)) {
        $errors[] = "Mobile number must be exactly 10 digits.";
    }

    if (empty($pincode)) {
        $errors[] = "Pincode is required.";
    } elseif (!preg_match('/^[0-9]{6}$/', $pincode)) {
        $errors[] = "Pincode must be exactly 6 digits.";
    }

    if (empty($message)) {
        $errors[] = "Message is required.";
    } else {
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    }

    // 2. Save Data if Validation Passes
    if (empty($errors)) {
        $entry = [
            'timestamp' => date('Y-m-d H:i:s'),
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'pincode' => $pincode,
            'message' => $message
        ];

        if ($storage_mode === 'csv') {
            saveToCSV('data.csv', $entry);
        } else {
            saveToJSON('data.json', $entry);
        }

        echo "Form submitted successfully!";
    } else {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}

// Function to append data to CSV
function saveToCSV($filename, $data) {
    $file_exists = file_exists($filename);
    $handle = fopen($filename, 'a');

    if (!$file_exists) {
        fputcsv($handle, array_keys($data));
    }

    fputcsv($handle, $data);
    fclose($handle);
}

// Function to append data to JSON
function saveToJSON($filename, $data) {
    $existing = file_exists($filename) ? json_decode(file_get_contents($filename), true) : [];

    if (!is_array($existing)) {
        $existing = [];
    }

    $existing[] = $data;

    file_put_contents(
        $filename,
        json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
    );
}
?>