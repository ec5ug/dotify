<!-- https://www.sitepoint.com/create-a-php-login-system/ -->
<?php
require("import.php");
?>
<?php
    
    if (isset($_POST["signup"])){
        if($_POST["password"] !== $_POST["verify_password"]){
            header("Location: signup.php?message=passwordmismatch");
            exit();
        }
        $username = $_POST["username"];
        $hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $dob = $_POST["dob"];
        createAccount($username, $hash, $dob);
        // $user_list = var_dump(getUsers());
        // echo "<pre>$user_list</pre>";
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
         <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
         <title>Dotify</title>
     </head>  
     <body class="mint">
        <div class="center">
            <h1 class="top">Dotify</h1>
            <h3>Sign In</h3>
            <?php
                if (isset($_GET["message"])){
                    if($_GET["message"] === "incorrectpassword"){
                        echo "<p style=\"color: red\">Error: Password is incorrect.</p>";
                    }
                    if($_GET["message"] === "userdne"){
                        echo "<p style=\"color: red\">Error: User does not exist.</p>";
                    }
                }
            ?>
            <form action="login.php" method="post" class="formBox">
                <label for="username">Username:</label>
                <input id="username" name="username" required="" type="text"/><br>
                <label for="password">Password:</label>
                <input id="password" name="password" required="" type="password" /><br>
                <input name="login" type="submit" value="Login" />
            </form>
            <br>
            <a href="signup.php">Create Account</a>
        </div>
     </body>
 </html>