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
        .awaiting {
            color: #f8f8f8;
            background-color: rgb(90, 90, 90);
        }

        .not-started {
        color: #f8f8f8;
        background-color: rgb(170, 1, 1);
        }

        .in-progress {
        color: #f8f8f8;
        background-color: rgb(165, 165, 0);
        }

        .completed {
        color: #f8f8f8;
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
        $userProjects = "SELECT name, description, status, SGSContact, projectid FROM projects WHERE user = '$search'";
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
                if ($status == NULL){
                    $status = 'awaiting';
                }

                ?>
                <!-- Status Changing -->
                <td id='statusColumn_<?php echo $project['projectid']; ?>' class='status-column <?php echo $status; ?>'>
                    <select class='statusSelect' name='statusSelect' data-projectid='<?php echo $project['projectid']; ?>'>
                        <option value='awaiting' <?php echo ($status == 'awaiting') ? ' selected' : ''?>>Awaiting</option>
                        <option value='not-started'<?php echo ($status == 'not-started') ? ' selected' : ''; ?>>Not Started</option>
                        <option value='in-progress'<?php echo ($status == 'in-progress') ? ' selected' : ''; ?>>In Progress</option>
                        <option value='completed'<?php echo ($status == 'completed') ? ' selected' : ''; ?>>Completed</option>
                    </select>
                    <input type='hidden' name='search' value='<?php echo $search; ?>'>
                    <input type='hidden' name='project' value='<?php echo $project['projectid']; ?>'>
                </td>
                                        

                <!-- Include jQuery library -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

                <script>
                    $(document).ready(function() {
                        // When any statusSelect dropdown changes
                        $('.statusSelect').change(function() {
                            var selectedOption = $(this).val();
                            var projectId = $(this).data('projectid');
                            console.log('Selected Option:', selectedOption);
                            console.log('Project ID:', projectId);

                            // Send the data to the server using AJAX
                            $.ajax({
                                type: "POST",
                                url: "update_status.php",
                                data: { selectedOption: selectedOption, projectId: projectId },
                                success: function(response) {
                                    // Handle the response if needed
                                    console.log(response);

                                    // Update the background color of the corresponding <td> element
                                    $('#statusColumn_' + projectId).removeClass('awaiting not-started in-progress completed').addClass(selectedOption);
                                },
                                error: function(xhr, status, error) {
                                    // Handle errors if any
                                    console.error(error);
                                }
                            });
                        });
                    });
                </script>
                        
                <!-- Claim Button -->
                <?php
                // Display which SGS employee is on the project.
                $sgsc = $project['SGSContact'];
                                
                if ($sgsc == NULL) {
                    echo "<td class='status-column not-started'>";
                    echo "<button id='claimButton_$project[projectid]' class='claimButton' data-project='$project[name]'>Claim</button>";
                    echo "</td>";
                } else {
                    echo "<td class='status-column completed'>$sgsc</td>";
                }
                
                
                        echo "</tr>";
            }
                            echo "</table>";
                        } else {
                            echo "<p>No projects found.</p>";
                        } ?>

                <script>
                    $(document).ready(function() {
                        // When any claimButton is clicked
                        $('.claimButton').click(function() {
                            var projectId = $(this).data('project');

                            // Send the claim data to the server using AJAX
                            $.ajax({
                                type: "POST",
                                url: "claim_project.php",
                                data: { projectId: projectId },
                                success: function(response) {
                                    // Handle the response if needed
                                    console.log(response);

                                    // Update the "SGSContact" column in the table without reloading the page
                                    var sgsColumn = $('#statusColumn_' + projectId);
                                    sgsColumn.removeClass('not-started').addClass('completed').text(response);

                                    // Hide the claim button
                                    $('#claimButton_' + projectId).hide();
                                },
                                error: function(xhr, status, error) {
                                    // Handle errors if any
                                    console.error(error);
                                }
                            });
                        });
                    });
                </script>
<?php
                
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
        echo "<tr><th style=width:15%>Name</th><th style=width:25%;>Description</th><th style=width:15%>Status</th><th>SGS Contact</th><th style=width:20%>Phone</th><th>Email</th></tr>";
        while ($project = $projectsResult->fetch_assoc()) {
            echo "<tr>";
            // Display project name and description
            echo "<td>" . $project['name']?> <input type="submit" value="Edit" class="button"> <?php "</td>";
            echo "<td>" . $project['description'] . "</td>";

            // Display status of project
            $status = $project['status'];
            if ($status == NULL){
                $status = 'awaiting';
                $showStatus = "Awaiting Confirmation";
            } elseif ($status == 'not-started'){
                $showStatus = "Not Started";
            } elseif ($status == 'in-progress'){
                $showStatus = "In Progress";
            } else {
                $showStatus = "Completed";
            }
            echo "<td class='status-column $status'>$showStatus</td>";

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

    // Log out button and Project Creation Button
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
