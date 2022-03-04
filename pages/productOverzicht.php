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
    ?>
    <ul>
        <li><a href="productOverzicht.php">All products</a> </li>
        <li><a href="productOverzicht.php?category=Large">Large</a></li>
        <li><a href="productOverzicht.php?category=Medium">Medium</a></li>
        <li><a href="productOverzicht.php?category=Small">Small</a></li>
        <li><a href="productOverzicht.php?category=Tiny">Tiny</a></li>
    </ul>
    <main>
    <?php

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

    if (mysqli_stmt_num_rows($stmt) > 0) {
        while (mysqli_stmt_fetch($stmt)) {
            $dir = "../images/" . $pname;
            $name = scandir($dir);
            $price = number_format((float)$price/100, 2, ",", "");
            $newPrice = (float)$newPrice / 100;
            echo "<a class='product' href=''>
                <img src='$dir/$name[2]' alt='$dir/$name[2]'><br>
                <h4>$pname</h4> &euro;";
            if ($newPrice) {
                echo number_format($newPrice, 2, ",", "") . " from <s> &euro;" . $price . "</s>";
            } else {
                echo $price;
            }
            echo "</a>";
        }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    ?>
</main>

</body>
</html>