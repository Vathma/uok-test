<!-- Forwarding Interface -->
<!DOCTYPE html>
<html>
<head>
    <title>Forwarding Interface</title>
</head>
<body>
    <h2>Forwarded File</h2>
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

    // Retrieve the file from the database
    $sql = "SELECT file_name, file_content FROM files ORDER BY id DESC LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $file_name = $row['file_name'];
        $file_content = $row['file_content'];

        // Output the file
        header("Content-type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$file_name\"");
        echo $file_content;
    } else {
        echo "No files found.";
    }

    // Close connection
    $conn->close();
    ?>
</body>
</html>
