<!-- https://www.sitepoint.com/create-a-php-login-system/ -->
<?php
require("connect-db.php");
require("request-db.php");
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
         <title>Dotify</title>
     </head>  
     <body>
        <header class="container">
            <h1>Dotify</h1>
            <nav>
                <a href="index.php">Home</a>
            </nav>
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
            <form action="login.php" method="post">
                <label for="username">Username:</label>
                <input id="username" name="username" required="" type="text" /><br>
                <label for="password">Password:</label>
                <input id="password" name="password" required="" type="password" /><br>
                <input name="login" type="submit" value="Login" />
            </form>
            <br>
            <a href="signup.php">Create Account</a>
        </header>
     </body>
 </html>