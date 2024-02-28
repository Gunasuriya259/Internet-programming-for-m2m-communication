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

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $username = mysqli_real_escape_string($conn, $_GET['username']);
    $password = mysqli_real_escape_string($conn, $_GET['password']);
    $email = mysqli_real_escape_string($conn, $_GET['email']);

    if ($username === "" || $password === "" || $email === "") {
        echo "Please Enter All Fields.";
    } else {
        // Insert user details into the 'registration' table
        $sql = "INSERT INTO registration (username, password, email) VALUES ('$username', '$password', '$email')";

        if ($conn->query($sql) === TRUE) {
            $user_id = $conn->insert_id; // Get the user_id of the newly inserted user
            echo "User Details Registered Successfully!";

            // Set a session variable to store the user_id for future use
            session_start();
            $_SESSION['user_id'] = $user_id;
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();
?>
