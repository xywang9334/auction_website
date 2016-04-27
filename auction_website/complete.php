<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/27/15
 * Time: 4:26 PM
 */

require_once('openDatabase.php');
session_start();
$highest = $_SESSION['id'];
if (!$_SESSION['login'])
    header("Location: login.php");
$thisAuctionQuery = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.STATUS,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        AUCTION.AUCTION_ID,
        AUCTION.SELLER,
        AUCTION.NUM_BID,
        AUCTION.CURRENT_PRICE
        FROM AUCTION
        WHERE AUCTION.AUCTION_ID = :auctionId;
SQL
);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Complete your order</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h1 class="TangerineFont">Complete your order</h1>
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
<hr>
<br>
<ul class="breadcrumb">
    <li><a href="index.php">Shopping Main Page</a></li>
    <li><a href="settings.php">Find the best one</a></li>
    <li><a href="book.php">Details</a></li>
    <li><a href="#">Complete your order</a></li>
</ul>
<section class="col-xs-4 col-xs-offset-4">
    <h2>Confirm your selection</h2>
    <?PHP
    $total_item = $_GET['totalItem'];
    $price = $_GET['price'];
    $thisAuctionQuery->bindValue(':auctionId', $total_item, PDO::PARAM_INT);
    $thisAuctionQuery->execute();
    foreach ($thisAuctionQuery->fetchAll() as $auction):
        $description = $auction['ITEM_DESCRIPTION'];
        $current_price = $auction['CURRENT_PRICE'];
        if ($price <= $current_price)
        {
            $_SESSION['display'] = true;
            header("Location: book.php");
            return;
        }
        $seller = $auction['SELLER'];
        $caption = $auction['ITEM_CAPTION'];
        $id = $auction['AUCTION_ID'];
        $bid = $auction['NUM_BID'];
        echo "
        <div><h3>{$caption}</h3></div>
        <br>
        <div>item description: {$description}</div>
        <br>
        <div>seller: {$seller}</div>
        <br>
        <div>your price: {$price}</div>
        <br>";
    endforeach;

    
    ?>

    <form action="updateStatus.php" method="post" enctype="multipart/form-data">
        <?PHP echo"<input type=\"hidden\" value='{$id}' name=\"auction_id\">"; ?>
        <?PHP echo"<input type=\"hidden\" value='{$bid}' name=\"bid\">"; ?>
        <?PHP echo"<input type=\"hidden\" value='{$price}' name=\"price\">"; ?>
        <?PHP echo"<input type=\"hidden\" value='{$highest}' name=\"highest\">"; ?>
        <input type="submit" value="Bid this item">
    </form>
    <br><br><br>
    <form action="book.php">
        <div>Last chance to cancel your order</div>
        <input type="submit" value="cancel">
    </form>
    <br>
    <hr>
    <footer>
        <div class="foot">Not ready? You are always welcome to contact us</div>
        <br>
        <div class="foot">Copyright someone</div>
    </footer>
</section>
</body>
</html>
<?PHP
$thisAuctionQuery->closeCursor();
?>
