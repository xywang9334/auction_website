<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/27/15
 * Time: 11:53 PM
 */
error_reporting(-1);
ini_set("display_errors", 1);
session_start();
if (!$_SESSION['login'])
    header('location: login.php');
$highest = $_SESSION['id'];
require_once('openDatabase.php');
$thisAuctionQuery = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.STATUS,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        AUCTION.AUCTION_ID,
        AUCTION.SELLER,
        AUCTION.START_PRICE,
        AUCTION.CURRENT_PRICE,
        AUCTION.NUM_BID
        FROM AUCTION
        WHERE AUCTION.SELLER = :seller and AUCTION.STATUS = :status;
SQL
);

$thatAuctionQuery = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.STATUS,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        AUCTION.AUCTION_ID,
        AUCTION.SELLER,
        AUCTION.START_PRICE,
        AUCTION.CURRENT_PRICE,
        AUCTION.NUM_BID,
        AUCTION.HIGHEST_BIDDER
        FROM AUCTION
        WHERE AUCTION.STATUS = :status;
SQL
);

$pendingAuctionQuery = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.STATUS,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        AUCTION.AUCTION_ID,
        AUCTION.SELLER,
        AUCTION.START_PRICE,
        AUCTION.CURRENT_PRICE,
        AUCTION.NUM_BID,
        AUCTION.HIGHEST_BIDDER
        FROM AUCTION
        WHERE AUCTION.HIGHEST_BIDDER = :highest;
SQL
);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Manage your list</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <?PHP echo"<h2 class=\"TangerineFont\">Manage your session, {$_SESSION['firstName']}</h2>"; ?>
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
<section>
    <div class="col-md-6 border-right">
        <h2> List of All Items on sale</h2>
        <?PHP
        $STATUS = 1;
        $thisAuctionQuery->bindValue(':seller', $highest, PDO::PARAM_INT);
        $thisAuctionQuery->bindValue(':status', $STATUS, PDO::PARAM_INT);
        $thisAuctionQuery->execute();
        foreach ($thisAuctionQuery->fetchAll() as $auction):
                $auction_id = $auction['ITEM_CAPTION'];
                $description = $auction['ITEM_DESCRIPTION'];
                $status = $auction['STATUS'];
                $close_time = $auction['CLOSE_TIME'];
                $start_price = $auction['START_PRICE'];
                $current_price = $auction['CURRENT_PRICE'];
                $bid = $auction['NUM_BID'];
                $id = $auction['AUCTION_ID'];
                echo "<br>";
                echo "<img src=\"auctionImage.php?photo={$id}\" height=\"100\" width=\"100\"/>";
                echo"
                <div>
                    <h3>item name: {$auction_id}</h3>
                    <form method=\"post\" action = 'deleteForm.php' enctype=\"multipart/form-data\">
                        <input type=\"hidden\" value='{$id}' name=\"auction_id\">
                        <input type=\"submit\" name=\"button\"  value=\"cancel sale\">
                    </form>
                    <div>item description: {$description}</div>
                    <div>Auction ends at: {$close_time}</div>
                    <div>Start Price: {$start_price}</div>
                    <div>Current Price: {$current_price}</div>
                    <div>Number of People bid: {$bid}</div>
                    <form action=\"update.php\" method=\"post\" enctype=\"multipart/form-data\">
                        <input type=\"hidden\" value='{$id}' name=\"auction_id\">
                        <button>Update desciption</button>
                    </form>
                </div>";
        endforeach;
        ?>
        <br>
    </div>
</section>
<section>
    <div class="col-md-6">
        <h2> List of All Confirmed Items</h2>
        <?PHP
        $STATUS = 6;
        $thatAuctionQuery->bindValue(':status', $STATUS, PDO::PARAM_INT);
        $thatAuctionQuery->execute();
        foreach ($thatAuctionQuery->fetchAll() as $auction):
            $auction_id = $auction['ITEM_CAPTION'];
            $description = $auction['ITEM_DESCRIPTION'];
            $status = $auction['STATUS'];
            $close_time = $auction['CLOSE_TIME'];
            $start_price = $auction['START_PRICE'];
            $current_price = $auction['CURRENT_PRICE'];
            $bid = $auction['NUM_BID'];
            $id = $auction['AUCTION_ID'];
            $seller = $auction['SELLER'];

            echo "<br>";
            echo "<img src=\"auctionImage.php?photo={$id}\" height=\"100\" width=\"100\"/>";
            echo"
                <div>
                    <form action=\"payment.php\" method=\"post\" enctype='multipart/form-data'>
                    <h3>item name: {$auction_id}</h3>
                    <div>item description: {$description}</div>
                    <div>Auction ends at: {$close_time}</div>
                    <div>Start Price: {$start_price}</div>
                    <div>Current Price: {$current_price}</div>
                    <div>Sell by {$seller}</div>
                    <input type=\"hidden\" value='{$current_price}' name=\"price\">
                    <button>pay for it</button>
                   </form>
                </div>";
        endforeach;
        ?>
        <br>
        <hr>
        <h2> List of All Pending Items</h2>
        <div>
            <?PHP
            $pendingAuctionQuery->bindValue(':highest', $highest, PDO::PARAM_INT);
            $pendingAuctionQuery->execute();
            foreach ($pendingAuctionQuery->fetchAll() as $auction):
                $auction_id = $auction['ITEM_CAPTION'];
                $description = $auction['ITEM_DESCRIPTION'];
                $status = $auction['STATUS'];
                $close_time = $auction['CLOSE_TIME'];
                $start_price = $auction['START_PRICE'];
                $current_price = $auction['CURRENT_PRICE'];
                $bid = $auction['NUM_BID'];
                $id = $auction['AUCTION_ID'];
                $seller = $auction['SELLER'];

                echo "<br>";
                echo "<img src=\"auctionImage.php?photo={$id}\" height=\"100\" width=\"100\"/>";
                echo"
                <div>
                    <h3>item name: {$auction_id}</h3>
                    <div>item description: {$description}</div>
                    <div>Auction ends at: {$close_time}</div>
                    <div>Start Price: {$start_price}</div>
                    <div>Current Price: {$current_price}</div>
                    <div>Number of People bid: {$bid}</div>
                    <div>Sell by: {$seller}</div>
                </div>";
            endforeach;
            ?>
        </div>
    </div>
</section>
<br><br><br><br><br><br><hr>
<footer class="col-xs-4 col-xs-offset-4">
    <div class="foot">Not ready? You are always welcome to contact us</div>
    <br>
    <div class="foot">Copyright someone</div>
</footer>
</body>
</html>

<?PHP
$thisAuctionQuery->closeCursor();
$thatAuctionQuery->closeCursor();
$pendingAuctionQuery->closeCursor();
?>


