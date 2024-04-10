<?php
session_start();

$conn = mysqli_connect("localhost", "workflow", "uok123", "uok");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['role'] = $row['role'];
        if ($username === 'lec') {
            
            header("Location: index.php");
        } else {
            
            header("Location: workflow.php");
        }
        exit(); 
    } else {
        $error = "Invalid username or password";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<body>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    Username: <input type="text" name="username"><br>
    Password: <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
<?php
if (isset($error)) {
    echo $error;
}
?>
</body>
</html>
