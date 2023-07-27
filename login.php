<?php
// Check if the form is submitted <-- FROM SGSLogin.php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include "db_conn.php";
    // Retrieve the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

    
    // Check the connection
    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    // Prepare the SQL statement using prepared statements
    $stmt = $connection->prepare("SELECT id, username, email, password, company FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    $adminstmt = $connection->prepare("SELECT name, contactNumber, contactEmail, password FROM admins WHERE name = ? AND password = ?");
    $adminstmt->bind_param("ss", $username, $password);
    $adminstmt->execute();
    $admin_result = $adminstmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Start a session
            session_start();

            
            // Store the username in a session variable
            $_SESSION['username'] = $username;

            // Redirect to home_page.php
            header("Location: home_page.php");
            exit();
        }
    } elseif ($admin_result->num_rows > 0){
        while ($row = $admin_result->fetch_assoc()) {
            // Start a session
            session_start();

            // Store the username in a session variable
            $_SESSION['username'] = $username;

            // Redirect to home_page.php
            header("Location: home_page.php");
            exit();
        }
    }else {
        header("Location: SGSLogin.php?error=incorrect");
        ?>
        <form action="SGSLogin.php" method="post">
             <input type="submit" value="Return to Login">
        </form>
        <?php
    }

    // Close the database connection
    $connection->close();
}
?>
