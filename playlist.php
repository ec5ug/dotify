<?php
require "import.php";
require "logged-in.php";

if(isset($_POST["submit"])){
    $username = $_SESSION["username"];
    $playlist_name = $_POST["playlist_name"];
    $user_id = getUserId($username); // Get user_id
    createPlaylist($user_id, $playlist_name);
    header("Location: playlist.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 

    <link rel="stylesheet" href="styles/main.css">
    <style>
        .hidden {
            display: none;
        }
    </style>
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    <h1>Create a Playlist</h1>
    
    <form method="post" id="create_playlist_form">
        <label for="playlist_name">Playlist Name:</label>
        <input type="text" id="playlist_name" name="playlist_name" required><br><br>
        <input type="submit" name="submit" value="Create Playlist">
    </form>
</body>
</html>