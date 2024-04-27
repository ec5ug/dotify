<!-- https://www.sitepoint.com/create-a-php-login-system/ -->
<?php
require("import.php");
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
        <header class="center">
            <h1 class="top">Dotify</h1>
            <h3>Create Account</h3>
            <?php
                if (isset($_GET["message"]) && $_GET["message"] === "passwordmismatch"){
                    echo "<p style=\"color: red\">Error: Verified password mismatch.</p>";
                }
            ?>
            <form action="index.php" method="post" class="formBox">
                <label for="username">Username:</label>
                <input id="username" name="username" required="" type="text" /><br>
                <label for="password">Password:</label>
                <input id="password" name="password" required="" type="password" /><br>
                <label for="password">Verify Password:</label>
                <input id="password" name="verify_password" required="" type="password" /><br>
                <label for="date">Birth Date:</label>
                <input type='text' id='dob' name='dob' placeholder='Format: yyyy-mm-dd' pattern="\d{4}-d{1, 2}-\d{1,2}" /><br>
                <input name="signup" type="submit" value="Signup" />
            </form>
            <br>
            <a href="index.php">Return to Home</a>
        </header>
     </body>
 </html>