<?php
session_start();

$conn = mysqli_connect("localhost", "workflow", "uok123", "uok");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$content = $_POST['content'];
$lecturer_id = $_SESSION['user_id'];


$sql = "INSERT INTO letters (lecturer_id, content, status, current_handler)
        VALUES ('$lecturer_id', '$content', 'pending', 'hod')";

if (mysqli_query($conn, $sql)) {
    echo "Letter submitted successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>