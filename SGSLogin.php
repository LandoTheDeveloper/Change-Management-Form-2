<!DOCTYPE html>
<html class="container">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SGS Login</title>
    <link rel="stylesheet" href="style.css">
    <script src="passwordSecurity.js"></script>
</head>
<body>
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
