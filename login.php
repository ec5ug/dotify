<?php
require("import.php");
?>
<?php
    if (!isset($_POST["login"])){
        header("Location: index.php");
        exit();
    }
    $username = $_POST["username"];
    $password = $_POST["password"];
    $result = getUserHash($username);
    if(sizeof($result) === 0){
        header("Location: index.php?message=userdne");
        exit();
    }
    $hash = $result[0]["hash_password"];
    $isValid = password_verify($password, $hash);
    if(!$isValid){
        header("Location: index.php?message=incorrectpassword");
        exit();
    }
    $_SESSION["username"] = $username;
    header("Location: welcome.php");
    exit();
    