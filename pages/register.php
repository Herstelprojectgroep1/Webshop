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
      include_once '../utils/filter.php';
      include_once '../controllers/db/dbconnect.php';
   ?>

   <main>
     <div class="login-box">

       <?php

       if(isset($_POST['submit'])){

         $input['username'] = filterInputPost($_POST['username'], 'username');
         $input['email'] = $_POST['email'];
         $input['dob'] = date('Y-m-d', strtotime($_POST['birth']));
         $input['password'] = filterInputPost($_POST['password'], 'password');
         $input['password_confirm'] =filterInputPost($_POST['password_confirm'], 'password_confirm');
        
        
         if(checkPassword($input['password']) && $input['password'] === $input['password_confirm'] ){
             if (strtolower(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))){ //validates the email
                 if ($input['dob']){
                     if (!in_array(false, $input)) {
                         if (executeQuery(
                             "INSERT INTO user (`rol_ID`, `username`, `email`, `password`, `date_of_birth`, `logged_in`)
                                           VALUES (?, ?, ?, ?, ?, ?)",
                                                   "isssii",
                                           array(1, $input['username'], $input['email'], generateHash($input['password']), $input['dob'], 0)
    
                             ));
                       }else{
                           echo "ERROR: please check if all fields were filled in";
                       }
                   }else{
                       echo "No valid date";
                   }
               }else{
                   echo "Email is not valid";
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
        <label for=birth>Date of birth (year-month-date)</label><br>
        <input type="text" name="birth" id="birth">
        <label for=password>Password</label><br>
        <input type="text" name="password" id="password"><br>
        <label for=password>Confirm password</label><br>
        <input type="text" name="password_confirm" id="password_confirm"><br>

        <input type="submit" name="submit" value="Register">
        <a href="login.php">Log in</a>
       </form>
     </div>
   </main>

 </body>
</html>