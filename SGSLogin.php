<!DOCTYPE html>
<html class="container">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGS Login</title>
    <link rel="stylesheet" href="appStyle.css">
    <script src="passwordSecurity.js"></script>
</head>
<body>

    <!-- Settings Sidebar -->
    <div id="main">
    <button class="openbtn" onclick="openNav()">⚙ Settings</button>  
    <script src="openSettings.js"></script>
    </div>

    <!-- Fixes bug that opens settings panel when site loads -->
    <body onload="closeNav()"></body>

    <div id="mySidebar" class="sidebar">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
    <a href="#">Account</a>
    <a>Light/Dark mode:</a>
        <label class="switch"> 
            <input type="checkbox" id="theme-toggle">
            <span class="slider"></span>
        </label>
    <script src="toggle-theme.js"></script>
    <a href="#">Notifications</a>
    <a href="https://www.sgstechnologies.net/contact">Contact Us</a>
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
            <label for="forgotPassword">
                <p class="forgotPass">Forgot Password?</p>
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
</body>
</html>
