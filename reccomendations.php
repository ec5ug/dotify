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
        <?php
        $user_favorites = getFavorites($username);
        $user_songs = getSongsInUserPlaylist($username);
        if (empty($user_favorites) && empty($user_songs)) {
            echo "<p>No reccomendations could be found. This could be due to a few reasons</p>";
            echo "<li>You have extensively listed to the songs in our playlist and we don't have any new song we can reccomend to you that you haven't listened to.</li>";
            echo "<li>You have not listened to enough songs for us to make reccomendations.</li>";
        } else {
            echo "<h2>Songs sung by artists that you have listened to</h2>";
            echo "<table>";
            foreach ($recommended_songs_by_artists as $recommended_song_by_artists) {
                echo "<tr>";
                $song_id = $recommended_song_by_artists['song_id'];
                $song_name = getSongName($song_id);
                echo "<td>" . $song_name . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<h2>Songs sung with similar energy levels</h2>";
            var_dump(calculate_average_energy($username));
        }
        ?>
     </body>
 </html>