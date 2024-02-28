<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "User_Login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "DELETE") {
    // Retrieve data from the request payload
    parse_str(file_get_contents("php://input"), $_DELETE);

    $username = mysqli_real_escape_string($conn, $_DELETE['username']);
    $taskId = mysqli_real_escape_string($conn, $_DELETE['taskId']);

    // Use prepared statements to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM $username WHERE id = ?");
    $stmt->bind_param("i", $taskId);

    if ($stmt->execute()) {
        http_response_code(200); // Success status code
        echo json_encode(array("message" => "Task deleted successfully"));
    } else {
        http_response_code(500); // Internal Server Error status code
        echo json_encode(array("error" => "Error deleting task: " . $stmt->error));
    }

    $stmt->close();
} else {
    http_response_code(400); // Bad Request status code
    echo json_encode(array("error" => "Invalid request method"));
}

$conn->close();
?>
