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

         $input['username'] = filterInput($_POST['username'], 'username');
         $input['email'] = $_POST['email'];
         $input['dob'] = date('Y-m-d', strtotime($_POST['birth']));
         $input['password'] = filterInput($_POST['password'], 'password');
         $input['password_confirm'] = filterInput($_POST['password_confirm'], 'password_confirm');
        
         if(checkPassword($input['password']) && $input['password'] === $input['password_confirm'] ){
             if (strtolower(filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL))){ //validates the email
                 if ($input['dob']){
                     if (!in_array(false, $input)) {
                         if (executeQuery(
                             "INSERT INTO user (role_ID, username, email, password, date_of_birth, logged_in)
                                           VALUES (?, ?, ?, ?, ?, ?)",
                             "issssi",
                              array(1, $input['username'], $input['email'], createHash($input['password']), $input['dob'], 0)
                             )) {
                               echo "registration succes";
                             }
                       }else{
                           echo "ERROR: please check if all fields were filled in";
                       }
                   }else{
                       echo "ERROR: no valid date";
                   }
               }else{
                   echo "ERROR: mail is not valid";
               }
          }else{
               echo "ERROR: password needs to be 8 characters long and has atleast 1 uppercase character, 1 special character and 1 number";
          }
       }
       ?>

       <h2>Register</h2>
       <form method="POST" action="<?php echo $_SERVER['PHP_SELF'];?>">
        <label for=username>Username</label>
        <input type="text" name="username" id="username">
        <label for=email>Email</label>
        <input type="text" name="email" id="email">
        <label for=birth>Date of birth</label>
        <input type="text" name="birth" id="birth">
        <label for=password>Password</label>
        <input type="password" name="password" id="password">
        <label for=password_confirm>Confirm password</label>
        <input type="password" name="password_confirm" id="password_confirm">

        <input type="submit" name="submit" value="Register">
        <a href="login.php">Log in</a>
       </form>
     </div>
   </main>

 </body>
</html>