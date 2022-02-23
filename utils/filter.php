<?php

// password has to be 8 characters long, needs atleast 1 uppercase letter, 1 number and atleast 1 special character
function checkPassword($password){
    if (strlen($password) >= 8) { 
      if (preg_match('/[A-Z]/', $password)) { 
        if (preg_match('/[0-9]/', $password)) { 
          if (preg_match('/[^a-zA-Z\d]/', $password)) { 
            return true;
          }
        }
      }
    }
    return false;
  }


  //PASSWORD_BCRYPT is used to create new password hashes
   function generateHash($password1) {
   $passwordHash =  password_hash($password1, PASSWORD_BCRYPT);
  //  var_dump($passwordHash);
   return $passwordHash;
}  




?>
