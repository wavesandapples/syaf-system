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
$sql = "SELECT * FROM users WHERE id=$id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    $update = "UPDATE users SET fname='$fname', lname='$lname', email='$email', username='$username', password='$password' WHERE id=$id";

    if ($conn->query($update) === TRUE) {
        header("Location: adminDashboard.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit User</title>
  <style>
    body {
      font-family: Tahoma, sans-serif;
      background: linear-gradient(to right, pink, lightblue);
      color: #fff;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }
    .form-box {
      background: hotpink;
      padding: 30px;
      border-radius: 12px;
      width: 400px;
    }
    input[type="text"], input[type="email"], input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0;
      border: none;
      border-radius: 5px;
      background: pink;
      color: #fff;
      font-weight: bold;
    }
    input[type="submit"], a {
      background: purple;
      color: #fff;
      padding: 10px 20px;
      border-radius: 8px;
      text-decoration: none;
      display: inline-block;
      margin-top: 10px;
    }
    input[type="submit"]:hover, a:hover { background: pink; }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Edit User</h2>
    <form method="POST">
      <input type="text" name="fname" value="<?php echo $row['fname']; ?>" required>
      <input type="text" name="lname" value="<?php echo $row['lname']; ?>" required>
      <input type="email" name="email" value="<?php echo $row['email']; ?>" required>
      <input type="text" name="username" value="<?php echo $row['username']; ?>" required>
      <input type="text" name="password" value="<?php echo $row['password']; ?>" required>
      <input type="submit" value="Update">
      <a href="adminDashboard.php">Cancel</a>
    </form>
  </div>
</body>
</html>
<?php $conn->close(); ?>
