<?php
// Establish connection to the database
$server = 'localhost';
$db_username = 'root';
$db_password = '';
$database = 'user_information';
$connection = new mysqli($server, $db_username, $db_password, $database, 3306) or die("not connected");
?>