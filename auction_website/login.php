<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/27/15
 * Time: 11:50 PM
 */
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") {
    header('Location: https://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    exit(1);
}
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== "on") {
    header('HTTP/1.1 403 Forbidden: TLS Required');
    // Optionally output an error page here
    exit(1);
}
session_start();
if ($_SESSION['login'] == true)
    header('location: manage.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>login</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h1 class="TangerineFont">Login Page</h1>
        </div>
    </div>
</header>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="login.php">Login</a></li>
        <li><a href="settings.php">Buy it</a></li>
        <li><a href="register.php">Register Here</a></li>
        <li><a href="seller.php">Sell Here</a></li>
    </ul>
</nav>
<hr>
<section id="middle">
    <header>
        <h2>Login here</h2>
    </header>
    <form method="post" action="checkForm.php" enctype="multipart/form-data">
        <div class="big-box">
            <fieldset>
                <a href="register.php">Not registered? Register Here</a>
                <br><br>
                <?PHP $value = $_SESSION['email']; ?>
                <label>Email: </label>
                <?PHP echo"<input class=\"big-input\" type=\"email\" name=\"email\" placeholder=\"email\" value='{$value}' required>";?>
                <?PHP
                if($_SESSION['display'])
                {
                    $_SESSION['display'] = false;
                    echo "error, wrong email or password combination";
                }
                ?>
                <br><br>
                <label>Password: </label>
                <input class="big-input" type="password" name="password" placeholder="password" required>
                <br>
                <br>
            </fieldset>
            <input type="submit" name="login" value="login">
        </div>
        <br>
    </form>
    <br><br><br><br><br><br><br><br><br>
    <hr>
    <footer>
        <div class="foot">Not ready? You are always welcome to contact us
            <br>
            Copyright someone
        </div>
    </footer>
</section>
</body>
</html>

