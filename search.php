<?php
require "import.php";
require "logged-in.php";

if(isset($_POST["submit"])){
    $str = $_POST["search"];
    $songs_found = searchSongs($str);
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
    <a href="welcome.php">Home</a>
    <p></p>
    <form method="post">
        <label>Search</label>
        <input type="text" name="search" style="width: 300px;" placeholder="Search by title, artist, or release year" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search for a song by title, artist, or release year'">
        <input type="submit" name="submit">
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
    echo "</tr>";
    echo "</thead>";
    
    // Initialize an array to keep track of displayed track names
    $displayed_track_names = [];
    
    foreach ($songs_found as $song_found) {
        // Check if the track name has been displayed already
        if (!in_array($song_found['track_name'], $displayed_track_names)) {
            echo "<tr>";
            echo "<td>" . $song_found['track_name'] . "</td>";
            echo "<td>" . $song_found['released_year'] . "</td>";
            echo "<td>";
            
            // Concatenate artist names for tracks with the same name
            $artist_names = [];
            foreach ($songs_found as $song) {
                if ($song['track_name'] == $song_found['track_name']) {
                    $artist_names[] = $song['artist_name'];
                }
            }
            echo implode(", ", array_unique($artist_names)); // Display unique artist names
            
            echo "</td>";
            echo "</tr>";
            
            // Add the displayed track name to the array
            $displayed_track_names[] = $song_found['track_name'];
        }
    }
    echo "</table>";
    echo "</div>";
} else if (isset($_POST["submit"])) {
    echo "<p>No songs found.</p>";
}
?>

</body>
</html>
