<?php
require 'db.php';

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="students.csv"');

$output = fopen('php://output', 'w');

fwrite($output, "\xEF\xBB\xBF");

fputcsv($output, [
    'ID',
    'Name',
    'Email',
    'Course',
    'Phone',
    'Status'
]);

$result = $conn->query(
    "SELECT id, name, email, course, phone, status
     FROM students
     WHERE status = 'Active'
     ORDER BY id"
);

while ($student = $result->fetch_assoc()) {
    fputcsv($output, [
        $student['id'],
        $student['name'],
        $student['email'],
        $student['course'],
        $student['phone'],
        $student['status']
    ]);
}

fclose($output);
exit;
?>