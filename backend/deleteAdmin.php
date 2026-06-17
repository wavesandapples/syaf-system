<?php
session_start();
include 'config.php';

if (!isset($_SESSION['username'])) {
    header("Location: frontend/login.html");
    exit();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60)) {
    session_unset();
    session_destroy();
    header("Location: frontend/login.html?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time();

$id = $_GET['id'];
$sql = "DELETE FROM users WHERE id=$id";

if ($conn->query($sql) === TRUE) {
    header("Location: adminDashboard.php");
    exit();
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>
