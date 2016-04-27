<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/12/15
 * Time: 7:22 PM
 */
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title> A small auction website </title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h1 class="TangerineFont">We have received your order</h1>
        </div>
    </div>
</header>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage Your List</a></li>
        <li><a href="settings.php">Buy it</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="seller.php">Sell Here</a></li>
    </ul>
</nav>
<br>
<hr>
<section class="col-xs-6 col-xs-offset-3">
    <h2>Your action is successfully performed</h2>
    <br><br><br>
    <form action="manage.php">
        <input type="submit" value="go and manage your session">
    </form>
    <br><br><br><br><br>
    <footer>
        <div class="foot">Not ready? You are always welcome to contact us</div>
        <br>
        <div class="foot">Copyright someone</div>
    </footer>
</section>
<br><br><br><br>
<hr>

</body>
</html>
