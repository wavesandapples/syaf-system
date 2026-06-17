<?php
include 'config.php'; // make sure this connects to syafdb

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $fname    = $_POST['fname'];
    $lname    = $_POST['lname'];
    $gender   = $_POST['gender'];
    $address  = $_POST['address'];
    $state    = $_POST['state'];
    $phonenum = $_POST['phonenum'];
    $email    = $_POST['email'];
    $eduArr   = isset($_POST['edu']) ? $_POST['edu'] : [];
    $username = $_POST['username'];
    $pass     = $_POST['pass'];
    $repass   = $_POST['repass'];

    // ✅ Check password match
    if ($pass !== $repass) {
        die("Error: Passwords do not match. <a href='signup.html'>Try again</a>");
    }

    // ✅ Convert education array to string
    $edu = implode(", ", $eduArr);

    // ✅ Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users 
        (fname, lname, gender, address, state, phonenum, email, edu, username, password) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", 
        $fname, $lname, $gender, $address, $state, $phonenum, $email, $edu, $username, $pass);

    if ($stmt->execute()) {
       header("Location: ../frontend/login.html");
       exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>