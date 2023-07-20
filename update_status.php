<?php
// Establish connection to the database
$server = 'localhost';
$db_username = 'root';
$db_password = '';
$database = 'user_information';
$connection = new mysqli($server, $db_username, $db_password, $database, 3306) or die("not connected");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["selectedOption"]) && isset($_POST["projectId"])) {
        $selectedOption = $_POST["selectedOption"];
        $projectId = $_POST["projectId"];

        // Sanitize and validate the input if needed.

        // Perform the database update with the specified projectId, for example:
        $sql = "UPDATE projects SET status = '$selectedOption' WHERE projectid = '$projectId'";
        $result = $connection->query($sql);

        // Echo a response back to the frontend to indicate the update was successful.
        echo "Option updated successfully.";
    } else {
        // Echo an error response back to the frontend if the required data is not provided.
        echo "Invalid data.";
    }
}

?>
