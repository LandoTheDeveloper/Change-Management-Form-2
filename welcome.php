<!DOCTYPE html>
<html class="container">
<head>
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Status Styles */
        .status-column {
        width: 150px;
        }

        .not-started {
        color: white;
        background-color: rgb(170, 1, 1);
        }

        .in-progress {
        color: white;
        background-color: rgb(165, 165, 0);
        }

        .completed {
        color: white;
        background-color: green;
        }

    </style>
</head>
<body>
<?php
// Establish a connection to the server
$servername = "localhost";
$db_username = "root";
$db_password = "";
$database = "user_information";

$conn = new mysqli($servername, $db_username, $db_password, $database);

// Start a session
session_start();

// Retrieve the username from the session variable
$username = $_SESSION['username'] ?? '';

// If the user is admin
if ($username == 'admin') {
    echo '<h1>Admin Panel</h1>';
    ?>
    <!-- Search Form -->
    <form method="post" action="">
        <label for="search">Search User:</label>
        <input type="text" id="search" name="search" placeholder="Enter username"
               value="<?php echo isset($search) ? $search : ''; ?>">
        <button type="submit" class="button">Search</button>
    </form>
    <?php
    // Check if a search query is submitted
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['search'])) {
        $search = $_POST['search'];

        // Perform the user search query
        $sql = "SELECT id, username, email, gender, phone, name, company FROM users WHERE username LIKE '%$search%'";
        $result = $conn->query($sql);

        // Print all user data
        if ($result->num_rows > 0) {
            echo "<h2>User Information</h2>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Username</th><th>Company</th><th>Name</th><th>Email</th><th>Phone</th><th>Gender</th></tr>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['username'] . "</td>";
                echo "<td>" . $row['company'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['phone'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";

                echo "</tr>";
            }
        }

        echo "</table>";

        // Retrieve the user's projects
        $userProjects = "SELECT name, description, status, SGSContact FROM projects WHERE user = '$search'";
        $projectsResult = $conn->query($userProjects);

        if ($projectsResult->num_rows > 0) {
            echo "<h2>User Projects</h2>";
            echo "<table>";
            echo "<tr><th>Name</th><th>Description</th><th>Status</th><th>SGS Contact</th></tr>";

            while ($project = $projectsResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $project['name'] . "</td>";
                echo "<td>" . $project['description'] . "</td>";

                // Display status of project
                $status = $project['status'];
                echo "<td class='status-column $status'>
                        <form method='post' action=''>
                            <select name='status' onchange='this.form.submit()'>
                                <option value='not-started'" . ($status == 'not-started' ? ' selected' : '') . ">Not Started</option>
                                <option value='in-progress'" . ($status == 'in-progress' ? ' selected' : '') . ">In Progress</option>
                                <option value='completed'" . ($status == 'completed' ? ' selected' : '') . ">Completed</option>
                            </select>
                            <input type='hidden' name='search' value='$search'>
                            <input type='hidden' name='project' value='" . $project['name'] . "'>
                        </form>
                      </td>";

                // Display which SGS employee is on the project.
                $sgsc = $project['SGSContact'];
                if ($sgsc == NULL) {
                    echo "<td class='status-column not-started'></td>";
                } else {
                    echo "<td class='status-column completed'>$sgsc</td>";
                }
                echo "</tr>";
            }

            echo "</table>";
        } else {
            echo "<p>No projects found.</p>";
        }

        // Check if a status update is submitted
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['status']) && isset($_POST['project'])) {
            $status = $_POST['status'];
            $projectName = $_POST['project'];

            // Update the status in the database
            $updateStatusQuery = "UPDATE projects SET status = '$status' WHERE user = '$search' AND name = '$projectName'";
            $conn->query($updateStatusQuery);

        }
    } else {
        echo "No users found.";
    }
    ?>

    <!-- Log out button -->
    <form action="SGSLogin.php" id="logOut">
        <label for="logout">
            <input type="submit" value="Log Out" class="button">
        </label>
    </form>

    <?php

// Non-Admin User
} else {
    echo "<h1>Welcome</h1>";
    echo "Welcome " . $username . "<br> <br>";

    // Retrieve the user's projects
    $userProjects = "SELECT name, description, status, SGSContact, contactNumber, contactEmail FROM projects WHERE user = '$username'";
    $projectsResult = $conn->query($userProjects);

    if ($projectsResult->num_rows > 0) {
        echo "<h2>Your Projects</h2>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Description</th><th>Status</th><th>SGS Contact</th><th>Phone</th><th>Email</th></tr>";

        while ($project = $projectsResult->fetch_assoc()) {
            echo "<tr>";
            // Display project name and description
            echo "<td>" . $project['name'] . "</td>";
            echo "<td>" . $project['description'] . "</td>";

            // Display status of project
            $status = $project['status'];
            echo "<td class='status-column $status'>$status</td>";

            // Display which SGS employee is on the project.
            echo "<td>" . $project['SGSContact'] . "</td>";
            // Display employee contact information
            echo "<td>" . $project['contactNumber'] . "</td>";
            echo "<td>" . $project['contactEmail'] . "</td>";

            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No projects found.</p>";
    }

    echo "</table>";

    // Log out button
    echo '<form action="project_creation_page.html">
            <input type="submit" value="Create A Project" class="button">
        </form>
        <form action="SGSLogin.php" id="logOut">
            <label for="logout">
                <input type="submit" value="Log Out" class="button">
            </label>
        </form>';
}
?>

</body>
</html>
