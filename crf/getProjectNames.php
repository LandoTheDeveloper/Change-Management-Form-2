<?php
include "db_connection.php"; // Make sure you include the database connection

// Fetch project names from the database
$query = "SELECT project_name FROM project_information";
$result = $connection->query($query);

$projectNames = [];
while ($row = $result->fetch_assoc()) {
    $projectNames[] = $row['project_name'];
}

// Send project names as JSON response
header('Content-Type: application/json');
echo json_encode($projectNames);

$connection->close();
?>
