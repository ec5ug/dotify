<?php
require "import.php";
require "logged-in.php";
?>
<!-- Source: https://www.youtube.com/watch?v=6xdHq2YE0g8 -->
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
    <form method = "post">
    <label>Search</label>
    <input type="text" name="search" style="width: 300px;" placeholder="Search by title, artist, or release year" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Search for a song by title, artist, or release year'">
        <input type="submit" name="submit">
    </form>


</header>
</body>
</html>

<?php
if(isset($_POST["submit"])){
    $str = $_POST["search"];
    $result = searchSongs($str);
    if(sizeof($result) === 0){
        echo "<p style=\"color: red\">No results found.</p>";
        exit();
    }
    var_dump($result);
    header("Location: search.php");
    exit();
}
?>

<div class="container">
    <h3>Songs</h3>
    <div class="row justify-content-center">
        <?php if(isset($result)): ?>
        <table class="w3-table w3-bordered w3-card-4 center" style="width:100%">
            <thead>
            <tr style="background-color:#B0B0B0">
                <th><b>Title</b></th>
                <th><b>Artist</b></th>
                <th><b>Release Year</b></th>
            </tr>
            </thead>
            <!-- iterate array of results, display the existing requests -->
            <?php foreach ($result as $song_info): ?>
                <tr>
                    <td><?php echo $song_info['track_name']; ?></td>
                    <td><?php echo $song_info['artist_name']; ?></td>
                    <td><?php echo $song_info['released_year']; ?></td>
                <!-- Insert button code here -->
                </tr>
            <?php endforeach; ?>

        </table>
        <?php endif; ?>
    </div>
