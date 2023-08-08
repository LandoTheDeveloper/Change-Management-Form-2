<?php
include "db_connection.php";

if (isset($_GET['projectName'])) {
    $projectName = $_GET['projectName'];

    // Fetch project details based on the selected project name
    $query = "SELECT cr_num, email FROM project_information WHERE project_name = ?";
    $stmt = $connection->prepare($query);
    $stmt->bind_param("s", $projectName);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $projectDetails = $result->fetch_assoc();
        header('Content-Type: application/json');
        echo json_encode($projectDetails);
    } else {
        echo json_encode(array()); // Return empty JSON if no project details found
    }

    $stmt->close();
}

$connection->close();
?>
