<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "User_Login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT task FROM tasks";
$result = $conn->query($sql);

if ($result !== false) {  // Check if the query was successful
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo $row['task'] . "<br>";
        }
    } else {
        echo "No tasks found.";
    }
} else {
    echo "Error retrieving tasks: " . $conn->error;
}

$conn->close();
?>
