<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/styles/login.css">
</head>

<body>

    <?php
      require_once '../components/headerLogin.php';
      require_once '../controllers/db/dbconnect.php';
      require_once '../utils/filter.php';
    ?>

    <main>
        <div class="login-box">

            <?php

            session_start();
            if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
                header("location:#");
                exit();
            }

            if (isset($_POST['submit'])) {
                if (!empty($_POST['username']) && $_POST['password']) {
                    $input['username'] = filterInput($_POST['username'], 'username');
                    $input['password'] = filterInput($_POST['password'], 'password');
                    if (checkPassword($input['password'])) {
                        if (!in_array(false, $input)) {
                            $data = getData(
                                "SELECT * FROM user WHERE username = ?",
                                "s",
                                array($input["username"])
                            );
                            if (array_key_exists("username", $data) && array_key_exists("password", $data)) {
                                if (password_verify($input['password'], $data['password']) && $input['username'] === $data['username']) {

                                        executeQuery("UPDATE user SET logged_in = 1 WHERE username = ?", 
                                        "s",
                                        array($input["username"])
                                        );

                                        $_SESSION['ID'] = $data ['ID'];
                                        $_SESSION['username'] = $data['username'];
                                        $_SESSION['email'] = $data['email'];
                                        $_SESSION['password'] = $data['password'];
                                        $_SESSION['date_of_birth'] = $data['date_of_birth'];
                                        $_SESSION['logged_in'] = $data['logged_in'];

                                        header("location:../pages/productOverzicht.php");  
                                } else {
                                    echo "ERROR: Incorrect password";
                                }
                            } else {
                                echo "ERROR: username and password does not exist";
                            }
                        } else {
                            echo "ERROR: ERROR: fill both fields in again";
                        }
                    } else {
                        echo "ERROR: password needs to be 8 characters long and has atleast 1 uppercase character, 1 special character and 1 number";
                    }
                } else {
                    echo "ERROR: please fill in both fields";
                }
            } 

?>

            <h2>Login</h2>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for=username>Username</label>
                <input type="text" name="username" id="username">
                <label for=password>Password</label>
                <input type="password" name="password" id="password">

                <input type="submit" name="submit" value="Login">
                <a href="register.php">Register</a>
            </form>
        </div>
    </main>
</body>

</html>