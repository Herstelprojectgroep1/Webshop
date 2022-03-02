<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/styles/setDiscount.css">
</head>
<body>
<main>
    <div class="set-discount">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>">
            <h2>Category</h2>
            <div>
                <label>
                    <input type="radio" id="L" name="ptype" value="L" onclick="showElement()">
                    Large
                </label>
            </div>
            <div>
                <label>
                    <input type="radio" id="M" name="ptype" value="M" onclick="showElement()">
                    Medium
                </label>
            </div>
            <div>
                <label>
                    <input type="radio" id="S" name="ptype" value="S" onclick="showElement()">
                    Small
                </label>
            </div>
            <div>
                <label>
                    <input type="radio" id="T" name="ptype" value="T" onclick="showElement()">
                    Tiny
                </label>
            </div>


            <?php
            include_once "../controllers/db/dbconnect.php";
            error_reporting(E_ALL);
            ini_set("display_errors", 1);
            ini_set("display_startup_errors", 1);
            $conn = GetConnection();

            $showProduct = false;

            if (isset($_POST['ptype'])) {
                $ptype = filter_input(INPUT_POST, 'ptype');
                $query = "SELECT `name` FROM `product` WHERE `category` = ?";
                if ($stm = mysqli_prepare($conn, $query)) {
                    mysqli_stmt_bind_param($stm, 's', $ptype);
                    if (mysqli_stmt_execute($stm)) {
                        mysqli_stmt_bind_result($stm, $pname);
                        echo "<h2>Product</h2>";
                        while (mysqli_stmt_fetch($stm)) {
                            echo "<div>
                                <label for='" . $pname . "'>
                                    <input type='checkbox' id='" . $pname . "' name='" . $pname . "' value='" . $pname . "'>
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
                        Discount:
                        <input type="text" id="discount" name="discount">
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
                <input type="submit" id="submit" value="submit">
            </div>
        </form>
    </div>
</main>
</body>
</html>