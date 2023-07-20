<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the username and password from the form
    $proj_name = $_POST["proj_name"];
    $proj_desc = $_POST['proj_desc'];

    // Connect to the database
    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $database = "user_information";

    $conn = new mysqli($servername, $db_username, $db_password, $database);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Start a session
    session_start();
    // Retrieve username
    $user = $_SESSION['username'];

    // Get date of creation
    $date = date("m/d/Y");

    $cmpnystmt = $conn->prepare("SELECT company FROM users WHERE username = ?;");
    $cmpnystmt->bind_param("s", $user);
    $cmpnystmt->execute();
    $cmpnystmt->bind_result($company);
    $cmpnystmt->fetch();
    $cmpnystmt->close();

    // Prepare the SQL statement using prepared statements
    $stmt = $conn->prepare("INSERT INTO projects (name, description, user, company, dateCreated) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $proj_name, $proj_desc, $user, $company, $date);
    if ($stmt->execute()) {
        header("Location: welcome.php");
        exit;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();
}
?>
