<?php

// Check is post method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "db_connection.php";

    // Retrieve data from project creation page
    $project_name = $_POST['project_name'];
    $cr_num = $_POST['cr_number'];
    $client_email = $_POST['client_email'];

    // Insert into db
    $stmt = $connection->prepare("INSERT INTO project_information (project_name, cr_num, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $project_name, $cr_num, $client_email);
    if ($stmt->execute()) {
        header("Location: CRF.html");
        exit;
    }

    // Close connection
    $stmt->close();
    $connection->close();
}
?>