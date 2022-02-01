<?php
//Require ENV
require_once('env.php');

// Connect to server
$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

// Test the connection
if (!$conn) {
    
}