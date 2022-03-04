<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <link rel="stylesheet" href="../assets/styles/productOverzicht.css">
</head>
<body>
<?php
include_once "../components/headerLogin.php";
//include "../utils/filter.php";
include_once "../controllers/db/dbconnect.php";
$conn = GetConnection();
$query = "SELECT `name`, `price`,`category`, `newPrice` FROM `product`
LEFT JOIN `discount`
ON product.productID = discount.productID AND CURRENT_DATE >= discount.beginDate AND CURRENT_DATE <= discount.endDate";
if ($stmt = mysqli_prepare($conn, $query)) {
    if (mysqli_stmt_execute($stmt)) {
        mysqli_stmt_bind_result($stmt, $pname, $price, $ptype, $newPrice);
        mysqli_stmt_store_result($stmt);
    } else {
        echo "Could not execute statement";
    }
} else {
    echo "prepare fail";
}
//$price = (int) $price;
//$price = number_format($price, 2, ",", "");
//echo $price;
if (mysqli_stmt_num_rows($stmt) > 0) {
    while (mysqli_stmt_fetch($stmt)) {
        $dir = "../images/" . $pname;
        $name = scandir($dir);
        $price = (float) $price;
        $price = round($price, 2);
        echo "<div class='product'>
        <img src='$dir/$name[2]' alt='$dir/$name[2]'><br>
        <h3>$pname</h3> &euro;";
        if($newPrice){echo number_format($newPrice, 2, ",", "") . " from <s> &euro;" . $price . "</s>";} else {echo $price;}
        echo "</div>";
    }
}
mysqli_stmt_close($stmt);
mysqli_close($conn);
?>

</body>
</html>