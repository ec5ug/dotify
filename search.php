<?php
require "import.php";
require "logged-in.php";

$username = $_SESSION["username"];
if(isset($_POST["search-submit"])){
    $str = $_POST["search"];
    $songs_found = searchSongs($str);
} else if (isset($_POST['favorite-create'])) {
    $song_id = $_POST["song_id"];
    addToFavorites($username, $song_id);
    header('Location: ' . $_SERVER['REQUEST_URI']);
    exit();
} else if (isset($_POST['favorite-remove'])) {
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
    <h1>Search for a Song</h1>
    <p></p>
    <form method="post">
        <label>Search</label>
        <input type="text" name="search" style="width: 300px;" placeholder="Search by title, artist, or release year" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search for a song by title, artist, or release year'">
        <input type="submit" name="search-submit">
    </form>
</header>

<?php
if (!empty($songs_found)) {
    echo "<div class='container'>";
    echo "<h3>Songs Found</h3>";
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
    
    foreach ($songs_found as $song_found) {
        if (!in_array($song_found['track_name'], $displayed_track_names)) {
            echo "<tr>";
            echo "<td>" . $song_found['track_name'] . "</td>";
            echo "<td>" . $song_found['released_year'] . "</td>";
            echo "<td>";
            
            $artist_names = [];
            foreach ($songs_found as $song) {
                if ($song['track_name'] == $song_found['track_name']) {
                    $artist_names[] = $song['artist_name'];
                }
            }
            echo implode(", ", array_unique($artist_names));
            
            echo "</td>";
            echo "<td>";
            echo "<form method='post'>";
            if (inFavorites($username, $song_found['song_id'])) {
                echo "<input type='hidden' name='song_id' value='" . $song_found['song_id'] . "'>";
                echo "<button type='submit' name='favorite-remove'>Remove from Favorites</button>";
            } else {
                echo "<input type='hidden' name='song_id' value='" . $song_found['song_id'] . "'>";
                echo "<button type='submit' name='favorite-create'>Add to Favorites</button>";
            }
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            
            $displayed_track_names[] = $song_found['track_name'];
        }
    }
    echo "</table>";
    echo "</div>";
} else if (isset($_POST["search-submit"]) && !empty($_POST["search"])) {
    echo "<p>No songs found.</p>";
}
?>

</body>
</html>