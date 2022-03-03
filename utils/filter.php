<?php

// password has to be 8 characters long, needs atleast 1 uppercase letter, 1 number and atleast 1 special character
function checkPassword($password){
    if (strlen($password) >= 8) { 
      if (preg_match('/[A-Z]/', $password)) { 
        if (preg_match('/[0-9]/', $password)) { 
          if (preg_match('/[^a-zA-Z\d]/', $password)) { 
            return $password;
          }
        }
      }
    }
    return "not valid password";
  }

//PASSWORD_BCRYPT is used to create new password hashes
function createHash($password) {
  $passwordHash =  password_hash($password, PASSWORD_BCRYPT);
  //  var_dump($passwordHash);
  return $passwordHash;
}  

function filterInput($postVariable, $parameterName){
  $filteredValue = !empty($postVariable) ? FILTER_INPUT(INPUT_POST, $parameterName, FILTER_SANITIZE_SPECIAL_CHARS) : false;
  return $filteredValue;
}

function verifyPassword($password, $passwordHash){
   if (password_verify($password, $passwordHash)){
     return true;
   }
   return false;
}



?>
