<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        nav ul {
            list-style-type: none;
            padding: 0;
            text-align: center;
        }

        nav ul li {
            display: inline;
            margin-right: 10px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            padding: 5px 10px;
            border-radius: 5px;
        }

        nav ul li a:hover {
            background-color: #6cb;
            color: black;
        }
    </style>
</head>
<body>

<nav class="top-nav">
    <ul>
        <li><a href="./welcome.php">Home</a></li>
        <li><a href="./search.php">Find a Song</a></li>
        <li><a href="./favorites.php">Favorites</a></li>
        <li><a href="./playlist.php">Playlists</a></li>
        <li><a href='./reccomendations.php'>Recommendations</a></li>
        <li><a href='./friend_group.php'>Your Groups</a></li>
        <li><a href="./logout.php">Logout</a></li>
    </ul>
</nav>

</body>
</html>
