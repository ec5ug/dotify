<!-- https://www.sitepoint.com/create-a-php-login-system/ -->
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
            <h2>Create Account</h2>
            <nav>
                <a href="index.php">Home</a>
            </nav>
            <?php
                if (isset($_GET["message"]) && $_GET["message"] === "passwordmismatch"){
                    echo "<p style=\"color: red\">Error: Verified password mismatch.</p>";
                }
            ?>
            <form action="index.php" method="post">
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
            <a href="signup.php">Create Account</a>
        </header>
     </body>
 </html>