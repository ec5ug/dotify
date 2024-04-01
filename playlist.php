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

        /* Show the dropdown content (the form) when the button is clicked */
        .dropdown:hover .dropdown-content {
            display: block;
        }
    </style>
</head>

<body>
    <?php include 'nav_bar.php'; ?>
    
    <div class="dropdown">
        <button>Create Playlist</button>
        <div class="dropdown-content">
            <form method="post" id="create_playlist_form">
                <label for="playlist_name">Playlist Name:</label>
                <input type="text" id="playlist_name" name="playlist_name" required><br><br>
                <input type="submit" name="submit" value="Submit">
            </form>
        </div>
    </div>

    <script>
        function toggleForm() {
            var form = document.getElementById('create_playlist_form');
            form.classList.toggle('hidden');
        }
    </script>
</body>
</html>