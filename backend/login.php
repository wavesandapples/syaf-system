<?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();

        // Plain text password check (since you requested no hashing)
        if ($pass === $row['password']) {
            $_SESSION['username'] = $row['username'];
            $_SESSION['last_activity'] = time(); // track activity
            header("Location: adminDashboard.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No admin found!";
    }
}
$conn->close();
?>
