<?php
// Check if the form is submitted <-- FROM SGSLogin.php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the username and password from the form
    $username = $_POST["username"];
    $password = $_POST["password"];

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

    // Prepare the SQL statement using prepared statements
    $stmt = $conn->prepare("SELECT id, username, email, password, company FROM users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Start a session
            session_start();

            
            // Store the username in a session variable
            $_SESSION['username'] = $username;

            // Redirect to welcome.php
            header("Location: welcome.php");
            exit();
        }
    } else {
        header("Location: SGSLogin.php?error=incorrect");
        ?>
        <form action="SGSLogin.php" method="post">
             <input type="submit" value="Return to Login">
        </form>
        <?php
    }

    // Close the database connection
    $conn->close();
}
?>
