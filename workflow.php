<!DOCTYPE html>
<html>
<head>
    <title>Workflow Interface</title>
</head>
<body>
    <h2>Letters Pending Approval</h2>
    <?php
    session_start();

    if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
        // Redirect user to login page if not logged in
        header("Location: login.php");
        exit();
    }

    $current_role = $_SESSION['role'];
    $conn = mysqli_connect("localhost", "workflow", "uok123", "uok");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch letters based on current user's role
    $sql = "SELECT * FROM letters WHERE status='pending' AND current_handler='$current_role'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        echo "Error fetching data: " . mysqli_error($conn);
    } else {
        if (mysqli_num_rows($result) > 0) {
            echo "<table border='1'>";
            echo "<tr><th>ID</th><th>Content</th><th>Action</th></tr>";
            // <th>Subject</th>

            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                // echo "<td>" . $row['subject'] . "</td>";
                echo "<td>" . $row['content'] . "</td>";
                echo "<td>";
                echo "<form action='action.php' method='post'>";
                echo "<input type='hidden' name='letter_id' value='" . $row['id'] . "'>";
                echo "<input type='radio' name='action' value='approve'>Approve";
                echo "<input type='radio' name='action' value='reject'>Reject";
                echo "<br>";
                echo "Feedback: <textarea name='feedback'></textarea>";
                echo "<br>";
                echo "<input type='submit' value='Submit'>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No letters pending approval.</p>";
        }
    }

    mysqli_close($conn);
    ?>
</body>
</html>
