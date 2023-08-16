<?php
// Include your database connection file
require_once "db_connection.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get form data
    $project_name = $_POST["selected_project_name"];
    $cr_number = $_POST["selected_cr_number"];
    $cr_type = $_POST["cr_type"];
    $submitter_name = $_POST["submitter_name"];
    $date_submitted = $_POST["date_submitted"];
    $client_email = $_POST["selected_client_email"];
    $acceptance = $_POST["acceptance"];
    
    // Serialize arrays to JSON before insertion
    $serializedItems = json_encode($_POST["items"]);
    $serializedHours = json_encode($_POST["hours"]);

    // Prepare and execute the SQL query to insert data into the change_requests table
    $stmt = $connection->prepare("INSERT INTO change_requests (project_name, cr_number, cr_type, submitter_name, date_submitted, client_email, item, hours, acceptance) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $project_name, $cr_number, $cr_type, $submitter_name, $date_submitted, $client_email, $serializedItems, $serializedHours, $acceptance);
    $stmt->execute();

    // Close prepared statement
    $stmt->close();

    // Redirect the user to a success page or display a success message
    header("Location: success.html");
    exit();
}
?>
