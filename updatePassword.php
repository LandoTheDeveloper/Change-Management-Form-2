<?php
include "db_conn.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["newPassword"]) && isset($_POST["currentPassword"])) {
        session_start();
        $newPassword = $_POST["newPassword"];
        $currentPassword = $_POST["currentPassword"];
        $username = $_SESSION["username"];

        // Get current password from DB
        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($result);
        $stmt->fetch();
        $stmt->close();

        // Check if current password is correct
        if ($result == $currentPassword) {
            // Perform the database update with the specified projectId, for example:
            $sql = "UPDATE users SET password = '$newPassword' WHERE username = '$username'";
            $result = $connection->query($sql);
        } else {
            echo "Current password is incorrect.";
        }
        
        // Echo a response back to the frontend to indicate the update was successful.
        echo "Password Updated Successfully.";
        
    } else {
        // Echo an error response back to the frontend if the required data is not provided.
        echo "Invalid data.";
    }
}

?>
