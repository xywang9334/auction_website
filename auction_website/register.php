<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/28/15
 * Time: 12:09 AM
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
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Register</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h1 class="TangerineFont">Register Page</h1>
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
<br><hr>
<section id="middle">
    <header>
        <h2>Register Here</h2>
    </header>
    <a href="login.php">Already registered? Login here</a>
    <form method="post" action="loginForm.php" enctype="multipart/form-data">
        <div class="big-box">
            <fieldset>
                <?PHP $surname = $_SESSION['surname'];
                $forename = $_SESSION['forename'];
                $email = $_SESSION['email'];?>
                <br><br>
                <label>Surname</label>
                <?PHP echo"<input class=\"big-input\" name=\"surname\" placeholder=\"surname\" value='{$surname}'required>";?>
                <br>
                <br>
                <label>Forename</label>
                <?PHP echo"<input class=\"big-input\" name=\"forename\" placeholder=\"forename\" value=\"{$forename}\"required>";?>
                <br>
                <br>
                <label>Password</label>
                <input class="big-input" type="password" name="password" placeholder="password" required>
                <br>
                <br>
                <label>Confirmed Your Password</label>
                <input class="big-input" type="password" name="verified" placeholder="password" required>
                <?PHP if($_SESSION['display']) {
                    echo "inconsistent password";
                }
                ?>
                <br>
                <br>
                <label>Email</label>
                <?PHP echo"<input class=\"big-input\" type=\"email\" name=\"email\" placeholder=\"email\" value=\"{$email}\"required>";?>
                <br><br>
                <?PHP
                if($_SESSION['display']) {
                    unset($_SESSION['display']);
                    unset($_SESSION['surname']);
                    unset($_SESSION['forename']);
                    unset($_SESSION['email']);
                }
                ?>
                <input type="checkbox" name="check"required>
                <label>Agree with our terms of service</label>
                <br><br>
                <input type="submit" name="register" value="register">
            </fieldset>
        </div>
        <br>
    </form>
    <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
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

