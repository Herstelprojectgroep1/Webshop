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
require_once "credentials.php";

//database connection
function dbConnect($server, $username, $password, $database){
    // check if the connection exists
    $conn = mysqli_connect(HOSTNAME, USERNAME, PASSWORD , DATABASE);
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
    $db = dbConnect(HOSTNAME, USERNAME, PASSWORD , DATABASE);
    $stmt = mysqli_prepare($db, $sql) or die (mysqli_stmt_error($stmt));
    mysqli_stmt_bind_param($stmt, $dataTypes, ...$values) or die(mysqli_stmt_error($stmt));
    $results = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    mysqli_close($db);
    return $results;
}

function getData($sql , $dataTypes, $values){
    $db = dbConnect(HOSTNAME, USERNAME, PASSWORD , DATABASE);
    $stmt = mysqli_prepare($db, $sql) or die (mysqli_stmt_error($stmt));
    mysqli_stmt_bind_param($stmt, $dataTypes, ...$values) or die (mysqli_stmt_error($stmt));
    mysqli_stmt_execute($stmt);
    //get the data
    $result = mysqli_stmt_get_result($stmt) or die (mysql_stmt_error($stmt));
    $row = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    mysqli_close($db);

    if (empty($row)){
        return "Unable to get data!"; 
    }
}

?>