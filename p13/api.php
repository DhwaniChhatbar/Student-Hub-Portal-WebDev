
<?php
header("Content-Type: application/json; charset=UTF-8");

require_once "db.php";

function respond($status, $data) {
    http_response_code($status);
    echo json_encode($data);
    exit;
}

function getInput() {
    $data = json_decode(file_get_contents("php://input"), true);

    if (!is_array($data)) {
        respond(400, [
            "success" => false,
            "message" => "Invalid JSON request."
        ]);
    }

    return $data;
}

function validateStudent($data) {
    $name = trim($data["name"] ?? "");
    $email = trim($data["email"] ?? "");
    $course = trim($data["course"] ?? "");

    if ($name === "" || $email === "" || $course === "") {
        respond(422, [
            "success" => false,
            "message" => "All fields are required."
        ]);
    }

    if (strlen($name) > 100 || strlen($course) > 100 ||
        strlen($email) > 150) {
        respond(422, [
            "success" => false,
            "message" => "One or more fields exceed the allowed length."
        ]);
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        respond(422, [
            "success" => false,
            "message" => "Enter a valid email address."
        ]);
    }

    return [$name, $email, $course];
}

$method = $_SERVER["REQUEST_METHOD"];

try {
    if ($method === "GET") {
        $stmt = $pdo->query(
            "SELECT id, name, email, course FROM students ORDER BY id DESC"
        );

        respond(200, [
            "success" => true,
            "data" => $stmt->fetchAll()
        ]);
    }

    if ($method === "POST") {
        $data = getInput();
        [$name, $email, $course] = validateStudent($data);

        $stmt = $pdo->prepare(
            "INSERT INTO students (name, email, course)
             VALUES (?, ?, ?)"
        );
        $stmt->execute([$name, $email, $course]);

        respond(201, [
            "success" => true,
            "message" => "Student added successfully.",
            "id" => (int) $pdo->lastInsertId()
        ]);
    }

    if ($method === "PUT") {
        $data = getInput();
        $id = filter_var(
            $data["id"] ?? null,
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => 1]]
        );

        if ($id === false || $id === null) {
            respond(400, [
                "success" => false,
                "message" => "A valid student ID is required."
            ]);
        }

        [$name, $email, $course] = validateStudent($data);

        $stmt = $pdo->prepare(
            "UPDATE students
             SET name = ?, email = ?, course = ?
             WHERE id = ?"
        );
        $stmt->execute([$name, $email, $course, $id]);

        if ($stmt->rowCount() === 0) {
            $check = $pdo->prepare(
                "SELECT id FROM students WHERE id = ?"
            );
            $check->execute([$id]);

            if (!$check->fetch()) {
                respond(404, [
                    "success" => false,
                    "message" => "Student not found."
                ]);
            }
        }

        respond(200, [
            "success" => true,
            "message" => "Student updated successfully."
        ]);
    }

    if ($method === "DELETE") {
        $data = getInput();
        $id = filter_var(
            $data["id"] ?? null,
            FILTER_VALIDATE_INT,
            ["options" => ["min_range" => 1]]
        );

        if ($id === false || $id === null) {
            respond(400, [
                "success" => false,
                "message" => "A valid student ID is required."
            ]);
        }

        $stmt = $pdo->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$id]);

        if ($stmt->rowCount() === 0) {
            respond(404, [
                "success" => false,
                "message" => "Student not found."
            ]);
        }

        respond(200, [
            "success" => true,
            "message" => "Student deleted successfully."
        ]);
    }

    header("Allow: GET, POST, PUT, DELETE");
    respond(405, [
        "success" => false,
        "message" => "Method not allowed."
    ]);

} catch (PDOException $e) {
    if ($e->getCode() === "23000") {
        respond(409, [
            "success" => false,
            "message" => "This email address already exists."
        ]);
    }

    error_log($e->getMessage());

    respond(500, [
        "success" => false,
        "message" => "A database error occurred."
    ]);
}
?>
