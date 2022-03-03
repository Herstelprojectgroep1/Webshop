<!DOCTYPE html>
<hmtl lang="en">
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
   ?>

   <main>
     <div class="login-box">

     <?php
       session_start();

       if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true){
         header("location:#");
         exit();
       }

       if(isset($_POST['submit'])){
         if(!empty($_POST['username']) && $_POST['password']){
             $input['username'] = filterInput($_POST['username'], 'username');
             $input['password'] = filterInput($_POST['password'], 'password');

            if (checkPassword($input['password'])){
               $data = getData(
                 "SELECT id, username, password ",
                 "ss",
                 array($input["username"], createHash($input['password']))
               );
               if (array_key_exists("username", $data) && array_key_exists("wachtwoord" , $data)){


               }
             }else{
               echo "ERROR: password needs to be 8 characters long and has atleast 1 uppercase character, 1 special character and 1 number";
             }
          }else{
             echo "ERROR: Please enter your username and password to login.";
          }
       }
       
     ?>

       <h2>Login</h2>
       <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for=username>Username</label>
        <input type="text" name="username" id="username">
        <label for=password>Password</label>
        <input type="text" name="password" id="password">

        <input type="submit" name="submit" value="Login">
        <a href="register.php">Register</a>
       </form>
     </div>
   </main>