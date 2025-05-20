<?php
$host = "localhost";
$username = "root"; // Default username for XAMPP/MAMP
$password = "";     // Default password for XAMPP/MAMP
$dbname = "techastra";

// Create connection
$con = mysqli_connect($host, $username, $password, $dbname);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}
?>