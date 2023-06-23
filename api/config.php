<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kodego_db";

// Make a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if($conn->connect_error) {
    die("Connection error: " . $conn->connect_error);
}


echo "Connected successfully!";

?>