<?php
require "import.php";
?>
<!DOCTYPE html>
 <html lang="en">
     <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1"> 

         <meta name="author" content="Siddharth Premjith, Emily Chang, Hayley Davis">
         <meta name="description" content="">
         <meta name="keywords" content="">

         <link rel="stylesheet" href="styles/main.css">
         <title>Dotify</title>
     </head>  
     <body>
        <header class="container">
            <h1>Dotify</h1>
            <nav>
                <a href="index.php">Home</a>
            </nav>
            <p>Welcome to Dotify, <?= $_SESSION["username"] ?>!</p>
        </header>
        <a href="logout.php">Logout</a>
     </body>
 </html>