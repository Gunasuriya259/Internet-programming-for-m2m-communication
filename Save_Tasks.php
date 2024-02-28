<?php
// No need to start the session if you don't require user authentication

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "User_Login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $task = mysqli_real_escape_string($conn, $_POST['task']);

    if ($task !== "") {
        // Insert task into the 'tasks' table without user authentication
        $sql = "INSERT INTO tasks (task) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $task);

        if ($stmt->execute()) {
            echo "Task Saved Successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
