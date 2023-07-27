<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "db_conn.php";
    // Check the connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Start a session
    session_start();
    // Retrieve username
    $user = $_SESSION['username'];
    $proj_name = $_POST['proj_name'];
    $proj_desc = $_POST['proj_desc'];
    // Get date of creation
    $date = date("m/d/Y");

    $cmpnystmt = $connection->prepare("SELECT company FROM users WHERE username = ?;");
    $cmpnystmt->bind_param("s", $user);
    $cmpnystmt->execute();
    $cmpnystmt->bind_result($company);
    $cmpnystmt->fetch();
    $cmpnystmt->close();

    // Prepare the SQL statement using prepared statements
    $stmt = $connection->prepare("INSERT INTO projects (name, description, user, company, dateCreated) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $proj_name, $proj_desc, $user, $company, $date);
    if ($stmt->execute()) {
        header("Location: home_page.php");
        exit;
    }

    // Close the database connection
    $stmt->close();
    $connection->close();
}
?>
