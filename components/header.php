<!DOCTYPE html>
<html lang="en">
  <head>
     <meta charset="UTF-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="../assets/styles/headerLogin.css">
  </head>

  <body>
   
  <?php
    require_once '../utils/filter.php';
  ?>
   <header>


     <div class="container">

       <div class="logo">  
          NHL WEBSHOP
       </div>  
      
       <div class="search-bar">
          <input type="search" name="zoekbalk" placeholder="Zoeken">
        </div>
       
        <ul class="nav-list">
            <?php

            if (isset($_GET["logout"]) && $_GET["logout"] == "true") {
                logOut();
            }


            if($_SESSION['logged_in']){
            ?>
           <li><a href="../pages/productOverzicht.php">Home</a></li>
           <li><a href="#">Cart</a></li>
           <li><a href="?logout=true">Logout</a></li>
           <?php
           }else {
           ?> 
           <li><a href="../pages/productOverzicht.php">Home</a></li>
           <li><a href="#">Cart</a></li>
           <li><a href="../pages/index.php">Log in</a></li>
           <?php
           }
           ?>
        </ul>

     </div>   
   </header>


  </body>
</html>