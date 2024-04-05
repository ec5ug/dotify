<?php
require "import.php";
require "logged-in.php";
?>
<?php
    if(isset($_POST["update-playlist"])){
        $song_id = $_POST["song_id"];
        foreach ($_POST as $playlist_id => $checked){
            if ($playlist_id === $song_id)
                continue;
            $empty = listedItemInPlaylisting($song_id, intval($playlist_id));
            if($empty)
                addSongToPlaylist($song_id, intval($playlist_id));
        }
    }
    if(!isset($_GET["song"])){
        header("Location: search.php");
    }
    $username = $_SESSION["username"];
    $song_id = $_GET["song"];
    $user_playlists = getPlaylist($username);
    $track_name = getSongName($song_id);
    $playlistsWithSong = getPlaylistsWithSong($username, $song_id);
    //find if the playlist has the song
    $has_song = [];
    foreach ($user_playlists as $user_playlist){
        $playlist_id = $user_playlist["playlist_id"];
        $has_song[$playlist_id]["playlist_name"] = $user_playlist["playlist_name"];
        $has_song[$playlist_id]["in_playlist"] = false;
        foreach ($playlistsWithSong as $playlistWithSong){
            if($user_playlist["playlist_id"] === $playlistWithSong["playlist_id"]){
                $has_song[$playlist_id]["in_playlist"] = true;
            }
        }
    }
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
        <?php include 'nav_bar.php'; ?>
        <header class="container">
            <h1>Add <?=$track_name?> to Your Playlists</h1>
            <?php
                echo "<form method='post' action=''>";
                echo "<input type='hidden' name='song_id' value='$song_id'>\n";
                foreach ($has_song as $playlist_id => $playlist_arr){
                    $playlist_name = $playlist_arr["playlist_name"];
                    if(!$playlist_arr["in_playlist"]){
                        echo "<input type='checkbox' name='$playlist_id' >\n";
                        echo "<label for='$playlist_id'>$playlist_name</label><br>\n";
                    }
                }
                echo "<br>";
                echo "<button type='submit' name='update-playlist'>Update Playlists</button>";
            ?>
        </header>
     </body>
 </html>