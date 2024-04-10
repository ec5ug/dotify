<!-- https://www.w3schools.com/howto/howto_js_popup_form.asp -->
<?php
require "import.php";
require "logged-in.php";

$username = $_SESSION["username"];

if(isset($_POST["create_playlist"])){
    $playlist_name = $_POST["playlist_name"];
    createPlaylist($username, $playlist_name);
    header("Location: playlist.php");
    exit();
} else if (isset($_POST["delete_playlist"])) {
    $playlist_id = $_POST['playlist_id'];
    deletePlaylist($playlist_id);
    header("Location: playlist.php");
    exit();
} else if (isset($_POST["delete_song_from_playlist"])) {
    $playlist_id = $_POST['playlist_id'];
    $song_id = $_POST['song_id'];
    deleteSongFromPlaylist($playlist_id, $song_id);
    header("Location: playlist.php");
    exit();
} else if (isset($_POST["grant_individual_access"])) {
    $new_username = $_POST['username_access'];
    $playlist_id = $_POST['playlist_id'];
    if (userExists($new_username)) {
        grantIndividualAccess($new_username, $playlist_id);
        header("Location: playlist.php");
        exit();
    } else {
        $_SESSION['error_message'][$playlist_id] = "The username does not exist.";
        $_SESSION['error_field'][$playlist_id] = "individual_access";
    }
} else if (isset($_POST['grant_group_access'])) {
    $new_group = $_POST['group_access'];
    $playlist_id = $_POST['playlist_id'];
    if (groupNameExists($new_group)) {
        grantGroupAccess($new_group, $playlist_id);
    } else {
        $_SESSION['error_message'][$playlist_id] = "The group name does not exist.";
        $_SESSION['error_field'][$playlist_id] = "group_access";
    }
}

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
        foreach ($user_playlists as $playlist) {
            echo "<table>"; // Open table for each playlist
                echo "<tr>
                    <td>" . $playlist['playlist_name'] . "</td>
                <td> 
                    <form method='post'>
                        <input type='hidden' name='playlist_id' value='" . $playlist['playlist_id'] . "'>
                        <button type='submit' name='delete_playlist'>Delete Playlist</button>
                    </form>
                </td>
            </tr>
            <tr>
            <td colspan='2'>
                <form method='post'>
                    <input type='hidden' name='playlist_id' value='" . $playlist['playlist_id'] . "'>
                    <input type='text' name='username_access' placeholder='Enter username'>
                    <button type='submit' name='grant_individual_access'>Grant Individual Access</button>";
                    $playlist_id = $playlist['playlist_id'];
                    if (isset($_SESSION['error_message'][$playlist_id]) && $_SESSION['error_field'][$playlist_id] === 'individual_access') {
                        echo '<p>Error: ' . htmlspecialchars($_SESSION['error_message'][$playlist_id]) . '</p>';
                        unset($_SESSION['error_message'][$playlist_id]);
                        unset($_SESSION['error_field'][$playlist_id]);
                    }
                echo "</form>
            </td>
            </tr>";
            echo "<tr>
            <td colspan='2'>
                <form method='post'>
                    <input type='hidden' name='playlist_id' value='" . $playlist['playlist_id'] . "'>
                    <input type='text' name='group_access' placeholder='Enter friend group name'>
                    <button type='submit' name='grant_group_access'>Grant Group Access</button>";
                    $playlist_id = $playlist['playlist_id'];
                    if (isset($_SESSION['error_message'][$playlist_id]) && $_SESSION['error_field'][$playlist_id] === 'group_access') {
                        echo '<p>Error: ' . htmlspecialchars($_SESSION['error_message'][$playlist_id]) . '</p>';
                        unset($_SESSION['error_message'][$playlist_id]);
                        unset($_SESSION['error_field'][$playlist_id]);
                    }
                echo "</form>
            </td>
        </tr>";

            // List songs under each playlist
            $songs_in_playlist = getSongsInPlaylist($playlist['playlist_id']);
            foreach ($songs_in_playlist as $song_in_playlist) {
                echo "<tr>";
                $song_id = $song_in_playlist['song_id'];
                echo "<td>&nbsp;&nbsp;&nbsp;&nbsp;" . getSongName($song_id) . "</td>"; // Indentation
                echo "<td>";
                echo "<form method='post'>";
                echo "<input type='hidden' name='playlist_id' value='" . $playlist['playlist_id'] . "'>";
                echo "<input type='hidden' name='song_id' value='" . $song_in_playlist['song_id'] . "'>";
                echo "<button type='submit' name='delete_song_from_playlist'>Delete from Playlist</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            // Insert an empty row for space between playlists
            echo "<tr><td colspan='2'>&nbsp;</td></tr>";
            echo "</table>"; // Close table for each playlist
    }
    } else {
        echo "<p>No playlists found.</p>";
    }
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