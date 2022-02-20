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
      include_once '../components/headerLogin.php';
      include '../utils/filter.php';
   ?>

   <main>
     <div class="login-box">

       <?php
       if(isset($_POST['submit'])){
         $username = $_POST['username'];
         $email = $_POST['email'];
         $password = $_POST['password'];
         $confirm = $_POST['confirm'];
        
         if(filterPassword($password)){
           if ($confirm === $password){
            
           }else{
             echo "Password and Confirm password does not match";
           } 
         }else{
           echo "Password needs to be 8 characters long and has atleast 1 uppercase character, 1 special character and 1 number";
         }
       }

       ?>

       <h2>Register</h2>
       <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for=username>Username</label><br>
        <input type="text" name="username" id="username"><br>
        <label for=email>Email</label><br>
        <input type="text" name="email" id="email"><br>
        <label for=password>Password</label><br>
        <input type="text" name="password" id="password"><br>
        <label for=password>Confirm password</label><br>
        <input type="text" name="confirm" id="confirm"><br>

        <input type="submit" name="submit" value="Register">
        <a href="login.php">Log in</a>
       </form>
     </div>
   </main>

 </body>
</html>