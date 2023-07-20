<!DOCTYPE html>
<html class="container">
<head>
    <title>SGS Login</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var showPasswordCheckbox = document.getElementById("showPasswordCheckbox");

            if (showPasswordCheckbox.checked) {
                passwordInput.type = "text";
            } else {
                passwordInput.type = "password";
            }
        }
    </script>
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
