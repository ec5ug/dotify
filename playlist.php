<!-- https://www.w3schools.com/howto/howto_js_popup_form.asp -->
<?php
require "import.php";
require "logged-in.php";

if(isset($_POST["create_playlist"])){
    $username = $_SESSION["username"];
    $playlist_name = $_POST["playlist_name"];
    createPlaylist($username, $playlist_name);
    header("Location: playlist.php");
    exit();
} else if (isset($_POST["delete_playlist"])) {
    $playlist_id = $_POST['playlist_id'];
    deletePlaylist($playlist_id);
    header("Location: playlist.php");
    exit();
}

$username = $_SESSION["username"];
$user_playlists = getPlaylist($username);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 

    <link rel="stylesheet" href="styles/main.css">
    <style>
.dropdown {
            position: relative;
            display: inline-block;
        }

        /* Styling for the button */
        .dropdown button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            font-size: 16px;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        /* Styling for the dropdown content (the form) */
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
            padding: 10px;
            border-radius: 5px;
        }

        /* Styling for the dropdown content links */
        .dropdown-content input[type="text"], .dropdown-content input[type="submit"] {
            width: 100%;
            padding: 8px 16px;
            margin: 4px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
    </style>
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    
    <div class="dropdown">
        <button onclick=openForm()>Create Playlist</button>
        <div class="dropdown-content" id="dropdown-content">
            <form method="post" id="create_playlist_form">
                <label for="playlist_name">Playlist Name:</label>
                <input type="text" id="playlist_name" name="playlist_name" required><br><br>
                <input type="submit" name="create_playlist" value="Submit">
                <button onclick=closeForm()>Close</button>
            </form>
        </div>
    </div>

    <?php
    if (!empty($user_playlists)) {
        echo "<table>";
        foreach ($user_playlists as $playlist) {
            echo "<tr>";
            echo "<td>" . $playlist['playlist_name'] . "</td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='playlist_id' value='" . $playlist['playlist_id'] . "'>";
            echo "<button type='submit' name='delete_playlist'>Delete Playlist</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No playlists found.</p>";
    }
    // var_dump($user_playlists);
    // $user_access = get_access($username);
    // echo "\n";
    // var_dump($user_access);
    ?>

    <script>
        function openForm() {
            document.getElementById("dropdown-content").style.display = "block";
        }
        function closeForm() {
            document.getElementById("dropdown-content").style.display = "none";
        }
    </script>
</body>
</html>