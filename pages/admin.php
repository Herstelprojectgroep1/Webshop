<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/admin.css">
    <title>Admin panel</title>
</head>

<body>

<?php
include_once '../components/headerLogin.php';
include '../utils/filter.php';
include_once '../controllers/db/dbconnect.php';
$connect = GetConnection();

if (isset($_POST["submit"])) {
    $pnaam = $_POST["pnaam"];
    $ptekst = $_POST["ptekst"];
    $ptype = $_POST["ptype"];
    $price = $_POST["price"];
    $prijs = filter_var($price, FILTER_SANITIZE_NUMBER_INT);

    $imgArray = $_FILES["img"];
    $numberOfImg = count($imgArray["name"]);

    for ($key = 0; $key < $numberOfImg; $key++) {
        $name = $imgArray["name"][$key];
        $type = $imgArray["type"][$key];
        $tmp_name = $imgArray["tmp_name"][$key];
        $error = $imgArray["error"][$key];
        $size = $imgArray["size"][$key];
        if ($size == 0) {
            echo "Please select at least one image of the product.";
            return;
        }
        $goodFileType = ["image/png", "image/jpg", "image/jpeg"];
        $imageTypes = finfo_file(finfo_open(FILEINFO_MIME_TYPE), $tmp_name);
        if (in_array($imageTypes, $goodFileType)) {
            if ($error > 0) {
                echo "An error has occurred during upload.";
            } else {
                $dir = "../images/" . $pnaam;
                if (is_dir($dir) === false) {
                    mkdir($dir);
                }
                $imageName = pathinfo($dir . "/" . basename($name), PATHINFO_FILENAME);
                if (file_exists($dir . "/" . $name)) {
                    echo "An image named " . $name . " already exists here";
                    die();
                } else {
                    if (!move_uploaded_file($tmp_name, $dir . "/" . $name)) {
                        echo "An error has occurred during upload.";
                    }
                }
            }
        } else {
            echo "Invalid file type. The image must be png, jpg, or jpeg.";
        }
    }

    if (empty($pnaam) || empty($ptekst) || empty($ptype) || empty($price)) {
        echo "Please fill in all fields.";
    } else {
        $query = "INSERT INTO product (name, description, price, catagory) VALUES
            (
                ?,
                ?,
                ?,
                ?                                             
            )";
        if ($stm = mysqli_prepare($connect, $query)) {
            mysqli_stmt_bind_param($stm, 'ssis', $pnaam, $ptekst, $prijs, $ptype);
            if (mysqli_stmt_execute($stm)) {
                mysqli_stmt_close($stm);
                mysqli_close($connect);
            } else {
                die("EXECUTE ERROR");
            }
        } else {
            die(mysqli_error($connect));
        }
    }
}

?>

<main>
    <div class="add-product">
        <h2>Add product</h2>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) ?>" enctype="multipart/form-data">
            <label for="pnaam">Productnaam:</label><br>
            <input type="text" name="pnaam" id="pnaam"><br>
            <label for="ptekst">Productomschrijving:</label><br>
            <input type="text" name="ptekst" id="ptekst"><br>
            <label for="ptype">Categorie</label><br>
            <select name="ptype" id="ptype">
                <option value=""></option>
                <option value="L">Large</option>
                <option value="M">Medium</option>
                <option value="S">Small</option>
            </select><br>
            <label for="price">Prijs in centen</label><br>
            <input type="text" name="price" id="price"><br>
            <label for="img">Afbeelding(en)</label><br>
            <input type="file" name="img[]" id="img" multiple><br>
            <input type="submit" name="submit" id="submit" value="submit">
        </form>
    </div>
</main>
</body>
</html>