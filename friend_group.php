<?php
require "import.php";
require "logged-in.php";

$username = $_SESSION["username"];
if(isset($_POST["create_friend_group"])){
    $friend_group_name = $_POST["friend_group_name"];
    createGroup($username, $friend_group_name);
    header("Location: friend_group.php");
    exit();
} else if (isset($_POST["add_to_friend_group"])) {
    $friend_group_name = $_POST["friend_group_name"];
    if (groupNameExists($friend_group_name)) {
        addToGroup($username, $friend_group_name);
        header("Location: friend_group.php");
        exit();
    } else {
        header("Location: friend_group.php?message=friend_group_dne");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">
    <meta name="keywords" content="">

    <link rel="stylesheet" href="styles/main.css">
</head>
<body>
<?php include 'nav_bar.php'; ?>

<!-- Add the form for creating a friend group -->
<div class="container">
    <h1>Create a Friend Group</h1>
    <form method="post">
        <label for="friend_group_name">Enter Friend Group Name:</label><br>
        <input type="text" id="friend_group_name" name="friend_group_name" required><br><br>
        <button type="submit" name="create_friend_group">Create Friend Group</button>
    </form>
    <h1>Add Yourself To Friend Group</h1>
    <form method="post">
        <label>Enter Friend Group Name:</label></br>
        <input type="text" id="friend_group_name" name="friend_group_name" required><br><br>
        <button type="submit" name="add_to_friend_group">Add Yourself to Friend Group</button>
    </form>
    <?php
        if (isset($_GET["message"])){
            if($_GET["message"] === "friend_group_dne"){
                echo "<p style=\"color: red\">Error: Such a friend group name does not exist.</p>";
            }
        }
    ?>     
</div>

</body>
</html>