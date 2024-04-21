<?php
require "import.php";
require "logged-in.php";
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
<?php include 'nav_bar.php'; ?>
<header class="container">
    <h1>Add a Song to the Dotify Database</h1>
    <p>Welcome to add to song database page, <?= $_SESSION["username"] ?>!</p>
</header>
</body>
</html>