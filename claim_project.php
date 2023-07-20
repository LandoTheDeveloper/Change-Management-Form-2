<?php
// Establish connection to the database
$server = 'localhost';
$db_username = 'root';
$db_password = '';
$database = 'user_information';
$connection = new mysqli($server, $db_username, $db_password, $database, 3306) or die("not connected");

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["projectId"])) {
    session_start();
    $projectId = $_POST["projectId"];
    $currentUsername = $_SESSION['username'] ?? '';

    // Check if the project is already claimed
    $checkClaimedQuery = "SELECT SGSContact FROM projects WHERE name = '$projectId'";
    $result = $connection->query($checkClaimedQuery);

    if ($result && $row = $result->fetch_assoc()) {
        $sgsContact = $row['SGSContact'];
        if ($sgsContact === NULL) {
            // Update the "SGSContact" column with the current user's username for the selected project
            $updateClaimQuery = "UPDATE projects SET SGSContact = '$currentUsername' WHERE name = '$projectId' AND SGSContact IS NULL";
            $updateResult = $connection->query($updateClaimQuery);

            if ($updateResult) {
                // Return the current username to update the display without reloading the page
                echo $currentUsername;
            } else {
                echo "Error claiming the project.";
            }
        } else {
            // The project is already claimed, return a message to indicate that.
            echo "Project already claimed by " . $sgsContact;
        }
    } else {
        echo "Error checking project status.";
    }
}

$connection->close(); // Close the database connection after the update.
?>
