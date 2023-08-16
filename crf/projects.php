<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Projects and Change Requests</title>
    <link rel='stylesheet' href='style.css'>
</head>
<body class='container'>
    <h1>View Projects and Change Requests</h1>

    <?php
    // Include your database connection file
    require_once "db_connection.php";

    // Fetch projects and change requests data from the database
    $query = "SELECT * FROM change_requests";
    $result = $connection->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            // Display project information
            echo "<h2>Project: " . $row["project_name"] . "</h2>";

            // Fetch and display change requests for the project
            $requestId = $row["request_id"];
            $changeRequestQuery = "SELECT * FROM change_requests WHERE request_id = $requestId";
            $changeRequestResult = $connection->query($changeRequestQuery);

            if ($changeRequestResult->num_rows > 0) {
                echo "<ul>";
                while ($changeRequestRow = $changeRequestResult->fetch_assoc()) {
                    // Display change request information
                    echo "<li>";
                    echo "CR#: " . $changeRequestRow["cr_number"] . "<br>";
                    echo "Type of CR: " . $changeRequestRow["cr_type"] . "<br>";
                    echo "Submitter Name: " . $changeRequestRow["submitter_name"] . "<br>";
                    echo "Date Submitted: " . $changeRequestRow["date_submitted"] . "<br>";
                    echo "Accepted: " . $changeRequestRow["acceptance"] . "<br>";
                    echo "Items: " . trim($changeRequestRow["item"], '["<p>  <\/p>"]') . "<br>";
                    echo "Hours: " . trim($changeRequestRow["hours"], '["]') . "<br>";
                    echo "</li>";
                }
                echo "</ul>";
                echo "<br>";
            } else {
                echo "<p>No change requests for this project.</p>";
            }
        }
    } else {
        echo "<p>No projects available.</p>";
    }

    // Close the database connection
    $connection->close();
    ?>
</body>
</html>
