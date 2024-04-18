<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    // Redirect user to login page if not logged in
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if user has permission to perform this action
    $allowed_roles = ['hod', 'dean', 'vice_chancellor'];
    $current_role = $_SESSION['role'];
    if (!in_array($current_role, $allowed_roles)) {
        echo "You do not have permission to perform this action.";
        exit();
    }

    // Process form submission
    $conn = mysqli_connect("localhost", "workflow", "uok123", "uok");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $letter_id = mysqli_real_escape_string($conn, $_POST['letter_id']);
    $action = mysqli_real_escape_string($conn, $_POST['action']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);

    // Fetch letter information
    $sql_fetch_letter = "SELECT * FROM letters WHERE id = '$letter_id'";
    $result_fetch_letter = mysqli_query($conn, $sql_fetch_letter);
    $row_fetch_letter = mysqli_fetch_assoc($result_fetch_letter);

    // Update letter status and feedback
    if ($action == 'approve') {
        $status = 'approved';
        $next_handler = getNextHandler($current_role);
        $feedback_msg = "Approved by $current_role";
        if ($next_handler !== false) {
            $feedback_msg .= ". Forwarded to $next_handler.";
            $currentHandler = next_handler;
            // Send email to next handler
            sendEmail($next_handler,  $row_fetch_letter['content']);
        }
    } elseif ($action == 'reject') {
        $status = 'rejected';
        $feedback_msg = "Rejected by $current_role";
        // Send feedback to previous handler
        $feedback_msg .= ". Feedback: $feedback";
        // Send email to previous handler
        sendEmail($row_fetch_letter['current_handler'],  $feedback);
    }

    $sql_update_letter = "UPDATE letters SET status='$status', feedback='$feedback_msg' current_handler='$currentHandler' WHERE id='$letter_id'";
    $result_update_letter = mysqli_query($conn, $sql_update_letter);

    if ($result_update_letter) {
        echo "Action performed successfully.";
    } else {
        echo "Error performing action: " . mysqli_error($conn);
    }

    mysqli_close($conn);
} else {
    echo "Invalid request.";
}

function getNextHandler($current_role) {
    // Define the next handler based on current role
    switch ($current_role) {
        case 'hod':
            return 'dean';
        case 'dean':
            return 'vice_chancellor';
        default:
            return false;
    }
}

function sendEmail($recipient,  $content) {
    // Implement email sending logic here
}
?>
