<!-- File Upload and Forwarding -->
<?php
// Establish database connection
$servername = "localhost";
$username = "root";
$password = "root123";
$dbname = "test";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// File upload handling
if(isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
    $file_tmp_name = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    
    // Open the file in binary mode
    $file_handle = fopen($file_tmp_name, 'rb');
    
    // Read the file content
    $file_content = fread($file_handle, filesize($file_tmp_name));
    
    // Close the file handle
    fclose($file_handle);
    
    // Prepare SQL statement to insert the file into the database
    $stmt = $conn->prepare("INSERT INTO files (file_name, file_content) VALUES (?, ?)");
    $stmt->bind_param("sb", $file_name, $file_content);
    
    // Execute the statement
    if($stmt->execute()) {
        // Redirect to another interface (forward.php in this example)
        header("Location: forward.php");
        exit();
    } else {
        echo "Error uploading file: " . $conn->error;
    }
    
    // Close statement
    $stmt->close();
} else {
    echo "Error uploading file.";
}

// Close connection
$conn->close();
?>
