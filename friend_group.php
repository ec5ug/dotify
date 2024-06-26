<?php
require "import.php";
require "logged-in.php";

$username = $_SESSION["username"];
$user_friend_groups = retrieveUserFriendGroups($username);
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
} else if (isset($_POST["remove_from_group"])) {
    $friend_group_id = $_POST['friend_group_id'];
    removeUserFromFriendGroup($username, $friend_group_id);
    header("Location: friend_group.php");
    exit();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="mint">
<?php include 'nav_bar.php'; ?>

<!-- Add the form for creating a friend group -->
<div class="center">
<h2>Create a Friend Group</h2>
<form method="post" class="formBox">
    <label for="friend_group_name">Enter Friend Group Name:</label><br>
    <input type="text" id="friend_group_name" name="friend_group_name" required><br><br>
    <button type="submit" name="create_friend_group" class="btn btn-light">Create Friend Group</button>
</form>
<br>
<h2>Add Yourself To Friend Group</h2>
<form method="post" class="formBox">
    <label>Enter Friend Group Name:</label></br>
    <input type="text" id="friend_group_name" name="friend_group_name" required><br><br>
    <button type="submit" name="add_to_friend_group" class="btn btn-success">Add Yourself to Friend Group</button>
</form>
<?php
    if (isset($_GET["message"])){
        if($_GET["message"] === "friend_group_dne"){
            echo "<p style=\"color: red\">Error: Such a friend group name does not exist.</p>";
        }
    }
?>
<br>
<h2>Groups You Are In</h2>
<?php
    if (!empty($user_friend_groups)) {
        echo "<div class='container'>";
        echo "<table class='friendGroup'>";
        foreach ($user_friend_groups as $user_friend_group) {
            echo "<tr>";
            $friend_group_id = $user_friend_group['friend_group_id'];
            $friend_group_name = getGroupName($friend_group_id);
            echo "<td>" . $friend_group_name . "</td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='friend_group_id' value='" . $friend_group_id . "'>";
            echo "<button type='submit' name='remove_from_group' class='btn btn-danger'>Remove From Friend Group</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";
    } else {
        echo "<p>You aren't in any friend groups.</p>";
    }
?>
</div>
</body>
</html>