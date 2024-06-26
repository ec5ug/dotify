<?php
require "import.php";
require "logged-in.php";

$username = $_SESSION["username"];
$recommended_songs_by_artists = reccomendSongsByArtists($username);
$reccomended_songs_by_energy = reccomendSongsByEnergy($username)
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
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     </head>  
     <body class="mint">
        <?php include 'nav_bar.php'; ?>
        <div class="container">
        <h1>Recommended Songs</h1>
        <?php
        $user_favorites = getFavorites($username);
        $user_songs = getSongsInUserPlaylist($username);
        if (empty($user_favorites) && empty($user_songs)) {
            echo "<p>No reccomendations could be found. This could be due to a few reasons</p>";
            echo "<li>You have extensively listed to the songs in our playlist and we don't have any new song we can reccomend to you that you haven't listened to.</li>";
            echo "<li>You have not listened to enough songs for us to make reccomendations.</li>";
        } else {
            echo "<h3>Songs sung by artists that you have listened to</h3>";
            echo "<table>";
            foreach ($recommended_songs_by_artists as $recommended_song_by_artists) {
                echo "<tr>";
                $song_id = $recommended_song_by_artists['song_id'];
                $song_name = getSongName($song_id);
                echo "<td>" . $song_name . "</td>";
                $artist_name = getArtistNames($song_id);
                echo "<td>" . $artist_name . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br>";
            echo "<h3>Songs sung with similar energy levels</h3>";
            echo "<table>";
            foreach ($reccomended_songs_by_energy as $reccomended_song_by_energy) {
                echo "<tr>";
                $song_id = $reccomended_song_by_energy['song_id'];
                $song_name = getSongName($song_id);
                echo "<td>" . $song_name . "</td>";
                $artist_name = getArtistNames($song_id);
                echo "<td>" . $artist_name . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        }
        ?>
        </div>
     </body>
 </html>