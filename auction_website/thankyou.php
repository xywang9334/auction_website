<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/28/15
 * Time: 12:14 AM
 */

$cardNumber = $_POST['cardNumber'];
session_start();
if (!is_numeric($cardNumber)) {
    $_SESSION['error_message'] = "incorrect payment method";
    header("Location: payment.php");
}
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
<section id="welcome">
    <h2>Your order has completed</h2>
    <div id="middle">
        <div>Want more items?</div>
        <br>
        <form action="book.php">
            <input type="submit" value="bid here">
        </form>
    </div>
</section>
<br><br><br><br>
<hr>
<footer>
    <div class="foot">Not ready? You are always welcome to contact us</div>
    <br>
    <div class="foot">Copyright someone</div>
</footer>
</body>
</html>

