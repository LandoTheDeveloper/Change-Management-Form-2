<!DOCTYPE html>
<?php
// Start a session
session_start();
?>
<html class="container">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="UTF-8">

<title>Home Page</title>
<link rel="stylesheet" href="appStyle.css">
</head>
<body>


<!-- Settings Sidebar -->
<div id="main">
    <!-- Open Sidebar -->
  <button class="openbtn" onclick="openNav()">⚙ Settings</button>  
  <script src="openSettings.js"></script>
</div>

<!-- Fixes bug that opens settings panel when site loads -->
<body onload="closeNav()"></body>

<script src="updatePassword.js"></script>
<div id="mySidebar" class="sidebar">
    <!-- Close Sidebar -->
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
  <!-- Account Settings -->
  <a href="javascript:void(0)" onclick="toggleSubmenu()">Account</a>
  <ul id="accountSubmenu">
    <li><a href="#" onclick="openPasswordPopup()">Change Password</a></li>
  </ul>

  <!-- Appearance Settings -->
  <script src="appearanceSettings.js"></script>
  <a href="javascript:void(0)" onclick="toggleAppearanceMenu()">Appearance</a>
  <ul id="appearanceSubmenu" style="display:none;">
    <li>   
        <!-- Light and Dark mode toggle -->
        <a> Light/Dark Mode: </a>
            <label class="switch"> 
                <input type="checkbox" id="theme-toggle" style="display:none;">
                <span class="slider"></span>
            </label>
        <script src="toggle-theme.js"></script></li>
  </ul>
  

  <!-- Notification Settings -->
  <a href="#">Notifications</a>
  <a href="https://www.sgstechnologies.net/contact">Contact Us</a>

  <!-- Log Out Button -->
  <form action="SGSLogin.php" id="logOut">
            <label for="logout">
                <input type="submit" value="Log Out" class="button">
            </label>
        </form>
</div>

<!-- Password change popup -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="updatePassword.js"></script>
<div id="passwordPopup" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closePasswordPopup()">×</span>
        <h2>Change Password</h2>
        <form action="" id="changePasswordForm">
            <label for="currentPassword">Current Password:</label>
            <input type="password" id="currentPassword" required placeholder="Current Password">
            <label for="newPassword">New Password:</label>
            <input type="password" id="newPassword" required placeholder="New Password">
            <label for="confirmPassword">Confirm New Password:</label>
            <input type="password" id="confirmPassword" required placeholder="Confirm Password">
            <button type="submit" class="button">Change Password</button>
        </form>
    </div>
</div>

<script>
    
    $(document).ready(function() {

        // Confirm that the passwords are the same
        function checkPasswordMatch() {
            var pass = $("#newPassword").val();
            var confirm_pass = $("#confirmPassword").val();

            if (pass === confirm_pass){
                return true;
            } else {
                alert("Passwords do not match.");
                return false;
            }
        }
            // When the changePasswordForm is submitted
            $("#changePasswordForm").submit(function() {
                if (checkPasswordMatch()){
                
                var newPassword = $("#newPassword").val();
                var currentPassword = $("#currentPassword").val();
                
                if (newPassword.length < 8) {
                    console.log("Too short");
                    return false;
                } else {
                    return true;
                }

                // Send the data to the server using AJAX
                $.ajax({
                    type: "POST",
                    url: "updatePassword.php",
                    data: { newPassword: newPassword, currentPassword: currentPassword },
                    success: function(response) {
                        // Handle the response if needed
                        console.log(response);
                    },
                    error: function(xhr, status, error) {
                        // Handle errors if any
                        console.error(error);
                    }
                });
            }
        });
    });
   
    
</script>



<?php
include "db_conn.php";



// Retrieve the username from the session variable
$username = $_SESSION['username'] ?? '';

// Check if the user is an admin
$isAdmin = $connection->prepare("SELECT name FROM admins WHERE name = ?;");
$isAdmin->bind_param("s", $username);
$isAdmin->execute();
$isAdmin->bind_result($_isAdmin);
$isAdmin->fetch();
$isAdmin->close();
if ($_isAdmin) {
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
        $result = $connection->query($sql);

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
        $projectsResult = $connection->query($userProjects);

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

                <!-- Include jQuery library -->
                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
                                    location.reload();
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

// Non-Admin User
} else {
    echo "<h1>Welcome $username</h1>";

    // Retrieve the user's projects
    $userProjects = "SELECT name, description, status, SGSContact, contactNumber, contactEmail FROM projects WHERE user = '$username'";
    $projectsResult = $connection->query($userProjects);

    if ($projectsResult->num_rows > 0) {
        echo "<h2>Your Projects</h2>";
        echo "<table>";
        echo "<tr><th>Name</th><th>Description</th><th>Status</th><th>SGS Contact</th><th>Phone</th><th>Email</th></tr>";
        while ($project = $projectsResult->fetch_assoc()) {
            echo "<tr>";
            // Display project name and description
            echo "<td>" . $project['name'];
            echo "<td>" . $project['description'] . "</td>";

            // Display status of project
            $status = $project['status'];
            if ($status == NULL || $status == 'awaiting'){
                $status = 'awaiting';
                $showStatus = "Awaiting Confirmation";
            } elseif ($status == 'not-started'){
                $showStatus = "Not Started";
            } elseif ($status == 'in-progress'){
                $showStatus = "In Progress";
            } elseif ($status = "completed") {
                $showStatus = "Completed";
            } else {
                $showStatus = "Awaiting Confirmation";
            }
            echo "<td class='status-column $status' align:'center'>$showStatus</td>";

            // Get admin contact information and fill it into the table
            $adminContact = $project['SGSContact'];
            $admins = "SELECT name, contactNumber, contactEmail FROM admins WHERE name = '$adminContact'";
            $adminResult = $connection->query($admins);
            while ($admin = $adminResult->fetch_assoc()){
                // Display which SGS employee is on the project.
                echo "<td>" . $project['SGSContact'] . "</td>";
                // Display employee contact information
                echo "<td>" . $admin['contactNumber'] . "</td>";
                echo "<td>" . $admin['contactEmail'] . "</td>";

                echo "</tr>";
            }
            
        }

        echo "</table>";
    // If no projects are found
    } else {
        echo "<p>No projects found.</p>";
    }

    echo "</table>";

    // Project creation page
    echo '<form action="project_creation_page.html">
            <input type="submit" value="Create A Project" class="button">
        </form>';

}
?>

</body>
</html>
