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
     include_once '../components/headerLogin.php'
   ?>

   <main>
     <div class="login-box">
       <h2>Login</h2>
       <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for=username>Username</label><br>
        <input type="text" name="username" id="username"><br>
        <label for=password>Password</label><br>
        <input type="text" name="password" id="password"><br>

        <input type="submit" name="submit" value="Login">
        <a href="register.php">Register</a>
       </form>
     </div>
   </main>