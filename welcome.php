<?php
require "import.php";
require "logged-in.php";
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
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
         <title>Dotify</title>
     </head>  
     <body class="mint">
        <?php include 'nav_bar.php'; ?>
        <header class="container">
            <p style="font-size: 55px; text-align: center;"><b>Welcome to Dotify, <?= $_SESSION["username"] ?>!</b></p>
            <p style="font-size: 55px; text-align: center;"><i>Dotify is your one stop shop for finding songs, creating playlists, and sharing them with friends!</i></p>
            <p style="font-size: 55px; text-align:">Click on one of the tabs above to get started!</p>
        </header>
     </body>
 </html>