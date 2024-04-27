<?php
require "import.php";
require "logged-in.php";
$username = $_SESSION["username"];
$found_favorites = getFavorites($username);
if (isset($_POST['favorite-remove'])) {
    $song_id = $_POST["song_id"];
    removeFromFavorites($username, $song_id);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
}
else if (isset($_POST['add-playlist'])){
    $song_id = $_POST["song_id"];
    header("Location: addsong.php?song=$song_id");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Dotify</title>

</head>
<body class="mint">
    <style>
        /* Styling generated from ChatGPT */
        /* Tooltip container */
        .tooltip {
            position: relative;
            display: inline-block;
        }

        /* Tooltip text */
        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #555;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 125%;
            left: 50%;
            margin-left: -60px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        /* Tooltip arrow */
        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #555 transparent transparent transparent;
        }

        /* Show the tooltip text when hovering over the tooltip container */
        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }
    </style>
    <?php include 'nav_bar.php'; ?>
<header class="container">
    <h1>Favorites</h1>



<?php
if (!empty($found_favorites)) {
    echo "<div class='container'>";
    #echo "<h3>Songs Found</h3>";
    echo "<table>";
    echo "<thead>";
    echo "<tr style=\"background-color:#B0B0B0\">";
    echo "<th><b>Title</b></th>";
    echo "<th><b>Release Year</b></th>";
    echo "<th><b>Artist</b></th>";
    echo "<th></th>";
    echo "<th></th>";
    echo "</tr>";
    echo "</thead>";

    $displayed_track_names = [];
    ###
    foreach ($found_favorites as $found_favorite) {
        if (!in_array($found_favorite['track_name'], $displayed_track_names)) {
            echo "<tr>";
            echo "<td>" . $found_favorite['track_name'] . "</td>";
            echo "<td>" . $found_favorite['released_year'] . "</td>";
            echo "<td>";

            $artist_names = [];
            foreach ($found_favorites as $song) {
                if ($song['track_name'] == $found_favorite['track_name']) {
                    $artist_names[] = $song['artist_name'];
                }
            }
            echo implode(", ", array_unique($artist_names));

            echo "</td>";
            echo "<td>";
            echo "<form method='post'>";
            if (inFavorites($username, $found_favorite['song_id'])) {
                echo "<input type='hidden' name='song_id' value='" . $found_favorite['song_id'] . "'>";
                echo "<button type='submit' name='favorite-remove'>Remove from Favorites</button>";
            } else {
                echo "<input type='hidden' name='song_id' value='" . $found_favorite['song_id'] . "'>";
                echo "<button type='submit' name='favorite-create'>Add to Favorites</button>";
            }
            echo "</td>";
            echo "<td>";
            if (getPlaylist($username)){
                echo "<button type='submit' name='add-playlist'>Add to Playlist</button>";
            }
            else{
                echo "<div class='tooltip'>";
                echo "<button type='button' disabled style='color: gray; cursor: not-allowed;'>Add to Playlist</button> ";
                echo "<span class='tooltiptext'>You must create at least one playlist first!</span>";
                echo "</div>";
            }
            echo "</form>";
            echo "</td>";
            echo "</tr>";

            $displayed_track_names[] = $found_favorite['track_name'];
        }

    }
    echo "</table>";
    echo "</div>";
} else {
    echo "<p>You currently have no favorites.</p>";
}
?>