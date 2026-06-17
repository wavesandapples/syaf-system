<?php
session_start();
include 'config.php';

// ✅ Require admin login
if (!isset($_SESSION['username'])) {
    header("Location: frontend/login.html");
    exit();
}

// ✅ Session timeout (1 minute)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 60)) {
    session_unset();
    session_destroy();
    header("Location: frontend/login.html?timeout=1");
    exit();
}
$_SESSION['last_activity'] = time();

$sql = "SELECT * FROM users";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <style>
    body {
      font-family: Tahoma, sans-serif;
      background: linear-gradient(to right, #ff9a9e, #fad0c4, #a1c4fd); /* soft pink-blue gradient */
      color: #333;
      margin: 0;
      padding: 20px;
    }
    h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #4a148c;
    }
    .dashboard {
      background: rgba(255,255,255,0.9);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      width: 95%;
      margin: auto;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid #ddd;
    }
    th {
      background: #f48fb1; /* soft pink header */
      color: #fff;
    }
    tr:nth-child(even) { background: #fce4ec; }
    tr:hover { background: #f8bbd0; }
    a {
      color: #1976d2;
      text-decoration: none;
      font-weight: bold;
      padding: 6px 10px;
      border-radius: 6px;
      background: #bbdefb;
      transition: background 0.3s;
    }
    a:hover {
      background: #64b5f6;
      color: #fff;
    }
    .logout {
      text-align: center;
      margin-top: 20px;
    }
    .logout a {
      background: #8e24aa;
      padding: 10px 20px;
      border-radius: 8px;
      color: #fff;
      text-decoration: none;
      margin: 0 10px;
      transition: background 0.3s;
    }
    .logout a:hover { background: #d81b60; }
  </style>
</head>
<body>
  <h2>Admin Dashboard</h2>
  <div class="dashboard">
    <p style="text-align:center;">Welcome, <?php echo $_SESSION['username']; ?> (Admin)</p>

    <table>
      <tr>
        <th>ID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Username</th>
        <th>Action</th>
      </tr>
      <?php while($row = $result->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['fname']; ?></td>
        <td><?php echo $row['lname']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['username']; ?></td>
        <td>
          <a href="editAdmins.php?id=<?php echo $row['id']; ?>">Edit</a>
          <a href="deleteAdmin.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?');">Delete</a>
        </td>
      </tr>
      <?php } ?>
    </table>

    <div class="logout">
      <a href="logout.php">Logout</a>
      <a href="../frontend/home.html">Home Page</a>
    </div>
  </div>
</body>
</html>
<?php $conn->close(); ?>
