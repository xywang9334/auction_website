<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/28/15
 * Time: 12:10 AM
 */
session_start();
if ($_SESSION['login'] == false)
    header('location: login.php');
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Upload your item</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h1 class="TangerineFont">Sell your item</h1>
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
    <h2>Upload your item</h2>
    <form action="insertForm.php" method="post" enctype="multipart/form-data">
    <div id="middle">
        <?PHP $caption = $_SESSION['caption']; $description = $_SESSION['description']; ?>
        <label>Caption: </label><br>
        <?PHP echo"<input class=\"big-input\" name=\"name\" placeholder=\"item name\" value='{$caption}'required>"; ?>
        <br>
        <br>
        <label>Description: </label><br>
        <?PHP echo"<input class=\"big-input\" name=\"description\" placeholder=\"item description\" value='{$description}'required>"; ?>
        <br>
        <br>
        <label>Prices: </label><br>
        <input type="number" class="big-input" name="price" placeholder="item price" required>
        <?PHP
        if($_SESSION['display'])
        {
            echo "please input a valid number";
            $_SESSION['display'] = false;
            unset($_SESSION['caption']);
            unset($_SESSION['description']);
        }
        ?>
        <br>
        <br>
        <div>Upload an image of your item(optional)</div>
        <input type="file" name="pic" accept="image/*">
        <br><br>
        <input type="submit" value="submit your item" name="submit">

        </form>
    </div>
</section>
<br><br><br><br><br><br><br>
</body>
</html>
<?PHP
$thisAuctionQuery->closeCursor();
?>
