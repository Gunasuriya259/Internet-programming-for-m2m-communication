<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "User_Login";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $usernameToDelete = mysqli_real_escape_string($conn, $_GET['username']);

    if ($usernameToDelete === "") {
        echo "Please Enter Username.";
    } else {
        // Use prepared statements to prevent SQL injection
        $stmt = $conn->prepare("DROP TABLE IF EXISTS ?");
        $stmt->bind_param("s", $usernameToDelete);

        if ($stmt->execute()) {
            echo "User Table Dropped Successfully!";
        } else {
            echo "Error Dropping User Table: " . $conn->error;
        }

        $stmt->close();

        // Now, delete the user from the 'registration' table
        $deleteUserSql = "DELETE FROM registration WHERE Username = ?";

        $stmt = $conn->prepare($deleteUserSql);
        $stmt->bind_param("s", $usernameToDelete);

        if ($stmt->execute()) {
            echo "User Account Deleted Successfully!";
        } else {
            echo "Error Deleting User Account: " . $conn->error;
        }

        $stmt->close();
    }
}

$conn->close();
?>
