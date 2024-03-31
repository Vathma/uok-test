<?php
session_start();

$conn = mysqli_connect("localhost", "workflow", "uok123", "uok");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $row['id'];
    $_SESSION['role'] = $row['role'];
    header("Location: index.php");
} else {
    echo "Invalid username or password";
}

mysqli_close($conn);
?>