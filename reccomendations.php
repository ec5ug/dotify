<?php
require "import.php";
require "logged-in.php";

$username = $_SESSION["username"];
$songs_sung_by_listened_to_artists = reccomendSongsByArtists($username);
?>
<!DOCTYPE html>
 <html lang="en">
     <head>
         <meta charset="utf-8">
         <meta http-equiv="X-UA-Compatible" content="IE=edge">
         <meta name="viewport" content="width=device-width, initial-scale=1"> 
         <meta name="description" content="">
         <meta name="keywords" content="">

         <link rel="stylesheet" href="styles/main.css">
     </head>  
     <body>
        <?php include 'nav_bar.php'; ?>
        <h1>Reccomended Songs</h1>
        <h2>Songs sung by artists that you have listened to</h2>
        <?php
        var_dump($songs_sung_by_listened_to_artists);
        ?>
        <h2>Songs sung with similar energy levels</h2> 
     </body>
 </html>