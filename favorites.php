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
    <?php include 'nav_bar.php'; ?>
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