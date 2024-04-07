<?php
require "import.php";
require "logged-in.php";

$username = $_SESSION["username"];
$recommended_songs_by_artists = reccomendSongsByArtists($username);
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
        if (!(empty($recommended_songs_by_artists))) {

        } else {
            echo "<p>No songs were found. This could be due to a couple of reasons:</p>";
            echo "<li>You haven't favorited any songs.</li>";
            echo "<li>You have extensively listed to the songs in our playlist and we don't have any new song we can reccomend to you that you haven't listened to.</li>";
        }
        ?>
        <h2>Songs sung with similar energy levels</h2> 
     </body>
 </html>