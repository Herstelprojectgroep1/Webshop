<?php
//Require ENV
require_once('env.php');

// Connect to server
$conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

// Test the connection
if (!$conn) {
    
}


function GetConnection()
{
    $connect = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE)
    or die(mysqli_connect_error());
    $db = mysqli_select_db($connect, DATABASE);
    if (!$db) {
        die('no database with that name');
    }
    return $connect;
}
