<!DOCTYPE html>
<html class="container">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGS Login</title>
    <link rel="stylesheet" href="appStyle.css">
    
</head>
<body>


<!-- Settings Sidebar -->
<div id="main">
    <!-- Open Sidebar -->
  <button class="openbtn" onclick="toggleSidebar()" id="openbtn">⚙ Settings</button>  
</div>

<div id="modal-content"></div>
<div id="mySidebar" class="sidebar">
    <!-- Close Sidebar -->
  <a href="javascript:void(0)" class="closebtn" onclick="toggleSidebar()" id="sidebarTxt">×</a>
  <!-- Appearance Settings -->
  <a href="javascript:void(0)" onclick="toggleAppearanceMenu()" id="sidebarTxt">Appearance</a>
  <ul id="appearanceSubmenu" style="display:none;">
    <li>   
        <!-- Light and Dark mode toggle -->
        <a id="submenuText"> Light/Dark Mode: </a>
            <label class="switch"> 
                <input type="checkbox" id="theme-toggle" style="display:none;">
                <span class="slider"></span>
            </label>
        </li>
  </ul>
  

  <!-- Notification Settings -->
  <a href="#" id="sidebarTxt">Notifications</a>
  <a href="https://www.sgstechnologies.net/contact" id="sidebarTxt">Contact Us</a>
</div>
    <h1>Login</h1>
    <hr>
    <?php
        // Display the error message if it exists
        if (isset($_GET['error']) && $_GET['error'] === 'incorrect') {
            echo "<p style='color: red;'>Username or Password is incorrect.</p>";
        }
    ?>
    <form id="login" action="login.php" method="post">
        <div>
            <label for="username">
                Username: <input type="text" id="username" name="username"><br>
            </label>
        </div>
        <div>
            <label for="password">
                Password: <input type="password" id="password" name="password"><br>
            </label>
        </div>
        <div>
            <label>
                Show Password: <input type="checkbox" id="showPasswordCheckbox" onchange="togglePasswordVisibility()">
            </label>
        </div>

        <input type="submit" value="Submit" class="button">
    </form>

    <form action="new account.html" method="get">
        <input type="submit" value="Create new account" class="button">
    </form>
    <script src="passwordSecurity.js"></script>
    <script src="appearanceSettings.js"></script>
    <script src="openSettings.js"></script>
    <script src="toggle-theme.js"></script>
</body>
</html>
