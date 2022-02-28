<?php
// //Require ENV
// require_once('env.php');

// // Connect to server
// $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD, DATABASE);

// // Test the connection
// if (!$conn) {
//     exit ("Could not connect to the database");
// } ?>

<?php
require_once ("credentials.php");

//database connection
function dbConnect($server, $username, $password, $database){
    // check if the connection exists
    $conn = mysqli_connect("localhost", "root", "" , "webshop");
    if (!$conn) {
    exit("Could not connect to the database!");
    }
    return $conn;
}

/* 
executeQuery():
execute a insert, delete or update query.
*/

function executeQuery($sql, $dataTypes, $values){
    $db = dbConnect("localhost", "root", "" , "webshop");
    $stmt = mysqli_prepare($db, $sql) or die (mysqli_stmt_error($stmt));
    $stmt = bindQuery($stmt, $dataTypes, $values);
    $results = executePreparedQuery($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($db);
    return $result;
}





?>