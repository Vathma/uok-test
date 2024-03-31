<?php
session_start();

$conn = mysqli_connect("localhost", "workflow", "uok123", "uok");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$letter_id = $_POST['letter_id'];
$action = $_POST['action'];
$feedback = $_POST['feedback'];
$current_user_id = $_SESSION['user_id'];
$current_role = $_SESSION['role'];

if ($current_role == 'hod') {
    if ($action == 'reject') {
        $sql = "UPDATE letters SET status='rejected', feedback='$feedback' WHERE id='$letter_id'";
    } else {
        $sql = "UPDATE letters SET status='approved', current_handler='dean' WHERE id='$letter_id'";
    }
} elseif ($current_role == 'dean') {
    if ($action == 'reject') {
        $sql = "UPDATE letters SET status='rejected', feedback='$feedback' WHERE id='$letter_id'";
    } else {
        $sql = "UPDATE letters SET status='approved', current_handler='vice_chancellor' WHERE id='$letter_id'";
    }
} elseif ($current_role == 'vice_chancellor') {
    if ($action == 'reject') {
        $sql = "UPDATE letters SET status='rejected', feedback='$feedback' WHERE id='$letter_id'";
    } else {
        $sql = "UPDATE letters SET status='approved' WHERE id='$letter_id'";
    }
}

if (mysqli_query($conn, $sql)) {
    echo "Action completed successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}

mysqli_close($conn);
?>