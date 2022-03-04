<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Discount</title>
    <link rel="stylesheet" href="../assets/styles/setDiscount.css">
</head>
<body>
<?php
include_once "../components/headerLogin.php";
include_once "../controllers/db/dbconnect.php";
include "../utils/filter.php";
$conn = GetConnection();


if (isset($_GET["error"])) {
    $error = $_GET["error"];
    if ($error == "invalidDiscount") {
        echo "Please use an integer for the discount. Please try again. <br>";
    }
    if ($error == "invalidPeriod") {
        echo "Invalid discount period. Please try again. <br>";
    }
}
if (isset($_POST["submit"]) && isset($_POST['product-id']) && isset($_POST['discount']) && isset($_POST['beginDate']) && isset($_POST['endDate'])) {
    $pID = $_POST["product-id"];
    $korting = $_POST["discount"];
    $beginDate = $_POST["beginDate"];
    $endDate = $_POST["endDate"];
    $discount = filter_var($korting, FILTER_VALIDATE_INT);
    if (!$discount) {
        header("Location: setDiscount.php?error=invalidDiscount");
        return;
    }
    if ($beginDate > $endDate) {
        header("Location: setDiscount.php?error=invalidPeriod");
        return;
    }

    $sqli = "INSERT INTO `discount` (`productID`, `discount`, `newPrice`, `beginDate`, `endDate`) 
VALUES (?, 
        ?, 
        (SELECT price/100*(100-?) FROM product WHERE productID=?), 
        ?, 
        ?)";
    if ($statement = mysqli_prepare($conn, $sqli)) {
        for ($i = 0; $i < count($pID); $i++) {
            mysqli_stmt_bind_param($statement, 'iiiiss', $pID[$i], $discount, $discount, $pID[$i], $beginDate, $endDate);
            mysqli_stmt_execute($statement) or die("EXECUTE ERROR");
            if (count($pID) == $i) {
                mysqli_stmt_close($statement);
                mysqli_close($conn);
            }
        }
    } else {
        die(mysqli_error($conn));
    }
}
?>
<main>
    <div class="set-discount">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <h2>Category</h2>
            <div>
                <label>
                    <input type="radio" id="L" name="ptype"
                           value="L" <?php echo isset($_POST['ptype']) && $_POST['ptype'] == "L" ? "checked" : '' ?>>
                    Large
                </label>
            </div>
            <div>
                <label>
                    <input type="radio" id="M" name="ptype"
                           value="M" <?php echo isset($_POST['ptype']) && $_POST['ptype'] == "M" ? "checked" : '' ?>>
                    Medium
                </label>
            </div>
            <div>
                <label>
                    <input type="radio" id="S" name="ptype"
                           value="S" <?php echo isset($_POST['ptype']) && $_POST['ptype'] == "S" ? "checked" : '' ?>>
                    Small
                </label>
            </div>
            <div>
                <label>
                    <input type="radio" id="T" name="ptype"
                           value="T" <?php echo isset($_POST['ptype']) && $_POST['ptype'] == "T" ? "checked" : '' ?>>
                    Tiny
                </label>
            </div>


            <?php
            $showProduct = false;
            if (isset($_POST['ptype'])) {
                $ptype = filter_input(INPUT_POST, 'ptype');
                $query = "SELECT `name`, `productID`, `price` FROM `product` WHERE `category` = ?";
                if ($stm = mysqli_prepare($conn, $query)) {
                    mysqli_stmt_bind_param($stm, 's', $ptype);
                    if (mysqli_stmt_execute($stm)) {
                        mysqli_stmt_bind_result($stm, $pname, $pID, $price);
                        echo "<h2>Product</h2>";
                        while (mysqli_stmt_fetch($stm)) {
                            echo "<div>
                                <label>
                                    <input type='checkbox' id='" . $pname . "' name='product-id[]' value='" . $pID . "'>
                                    " . $pname . "
                                </label>
                                </div>";
                        }
                        $showProduct = true;
                        mysqli_stmt_close($stm);
                        mysqli_close($conn);
                    } else {
                        echo "kon niet uitvoeren";
                    }
                } else {
                    echo "prepare fail";
                }
            } else {
                echo "Please choose a category.";
            }
            if ($showProduct) {
                ?>
                <div>
                    <label>
                        Discount (percentage):
                        <input type="number" step="1" min="0" max="100" id="discount" name="discount">
                    </label>
                </div>
                <div>
                    <label>
                        Starting date:
                        <input type="date" id="beginDate" name="beginDate">
                    </label>
                </div>
                <div>
                    <label>
                        Ending date:
                        <input type="date" id="endDate" name="endDate">
                    </label>
                </div>
            <?php } ?>
            <div>
                <input type="submit" id="submit" value="submit" name="submit">
            </div>
        </form>
    </div>
</main>
</body>
</html>