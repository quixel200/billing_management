<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
// Configuration for database connection
$host = "localhost"; 
$dbname = "billing_management";
$username = "root"; 
$password = ""; 

// MySQLi connection
$connection = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
