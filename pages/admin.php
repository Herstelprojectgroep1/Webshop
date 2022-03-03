<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/admin.css">
    <title>Add product</title>
</head>

<body>

<?php
include_once '../components/headerLogin.php';
include '../utils/filter.php';
include_once '../controllers/db/dbconnect.php';
$connect = GetConnection();

if (isset($_POST["submit"])) {
    $pname = $_POST["pname"];
    $ptext = $_POST["ptext"];
    $ptype = $_POST["ptype"];
    $price = $_POST["price"];
    $prijs = filter_var($price, FILTER_VALIDATE_INT);

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
                $dir = "../images/" . $pname;
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

    if (empty($pname) || empty($ptext) || empty($ptype) || empty($price)) {
        echo "Please fill in all fields.";
    } else {
        $query = "INSERT INTO product (name, description, price, category) VALUES
            (
                ?,
                ?,
                ?,
                ?                                             
            )";
        if ($stm = mysqli_prepare($connect, $query)) {
            mysqli_stmt_bind_param($stm, 'ssis', $pname, $ptext, $price, $ptype);
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

            <div>
                <label>
                    Name:
                    <input type="text" name="pname" id="pname">
                </label>
            </div>
            <div>
                <label>
                    Description:
                    <input type="text" name="ptext" id="ptext">
                </label>
            </div>
            <div>
                <label>
                    Catergory:
                    <select name="ptype" id="ptype">
                        <option value=""></option>
                        <option value="L">Large</option>
                        <option value="M">Medium</option>
                        <option value="S">Small</option>
                        <option value="T">Tiny</option>
                    </select>
                </label>
            </div>
            <div>
                <label>
                    Price (cents):
                    <input type="number" min="0" step="1" name="price" id="price">
                </label>
            </div>
            <div>
                <label>
                    Images (Minimal one image)
                    <input type="file" name="img[]" id="img" multiple>
                </label>
            </div>
            <div>
                <input type="submit" name="submit" id="submit" value="submit">
            </div>
        </form>
    </div>
</main>
</body>
</html>