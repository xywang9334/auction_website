<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/28/15
 * Time: 12:11 AM
 */
session_start();
if ($_SESSION['login'] == false)
    header('location: login.php');
require_once('openDatabase.php');
$thisAuctionQuery = $database->prepare(<<<'SQL'
    SELECT
        ITEM_CATEGORY.ITEM_CATEGORY_ID,
        ITEM_CATEGORY.NAME
        FROM ITEM_CATEGORY
SQL
);
$todaySpecial = $database->prepare(<<<'SQL'
  SELECT
    AUCTION.ITEM_DESCRIPTION,
    AUCTION.ITEM_CAPTION,
    AUCTION.CURRENT_PRICE,
    AUCTION.START_PRICE,
    AUCTION.SELLER,
    AUCTION.CLOSE_TIME,
    AUCTION.ITEM_PHOTO,
    AUCTION.AUCTION_ID,
    AUCTION.HIGHEST_BIDDER
    FROM AUCTION
    ORDER BY AUCTION.NUM_BID DESC
    LIMIT 20
SQL
);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Find in our website</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h1 class="TangerineFont">In Our Database...</h1>
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
<section class="col-md-6">
    <h2>Filter out here</h2>
    <form method="get">
        <div class="panel panel-primary">
            <div class="panel-body">
                <div>
                    <div>We offer categories</div>
                    <?PHP
                    $thisAuctionQuery->execute();
                    foreach ($thisAuctionQuery->fetchAll() as $auction):
                        $name = $auction['NAME'];

                        echo "
                        <label><input type=\"checkbox\" checked=\"checked\"/>{$name}</label>";
                    endforeach;
                    ?>
                </div>
                <br>
                <div>
                    <div>Item ID</div>
                    <?PHP
                    $thisAuctionQuery->execute();
                    foreach ($thisAuctionQuery->fetchAll() as $auction):
                        $category_id = $auction['ITEM_CATEGORY_ID'];
                        echo "
                        <label><input type=\"checkbox\" checked=\"checked\"/>{$category_id}</label>";
                    endforeach;
                    ?>
                </div>
                <br>
                <div>
                    <div>Bid ends in</div>
                    <label><input type="checkbox" checked="checked"/>This month</label>
                    <label><input type="checkbox" checked="checked"/>Next month</label>
                    <label><input type="checkbox" checked="checked"/>This year</label>
                    <label><input type="checkbox" checked="checked"/>Next year</label>
                </div>
                <br>
                <input type="submit" name="submit" onclick="book.php">
            </div>
        </div>
    </form>
</section>
<section class="col-md-6">
    <h2>Today's special</h2>
    <?PHP
    $todaySpecial->execute();
    foreach($todaySpecial->fetchAll() as $special):
        $description = $special['ITEM_DESCRIPTION'];
        $caption = $special['ITEM_CAPTION'];
        $price = $special['START_PRICE'];
        $current_price = $special['CURRENT_PRICE'];
        $close = $special['CLOSE_TIME'];
        $image = $special['ITEM_PHOTO'];
        $id = $special['AUCTION_ID'];
        $seller = $special['SELLER'];
        if(time() > strtotime($close))
            continue;
        if($image != null)
        {
            echo "<img src=\"auctionImage.php?photo={$id}\" height=\"100\" width=\"100\"/>";
        }
        echo"
            <h3>{$caption}</h3>
            <div>item description: {$description}</div>
            <div>Pricing from: {$price}</div>
            <div>Current Price: {$current_price}</div>
            <div>Deadline: {$close}</div>
            <div>Sell by {$seller}</div>";
    endforeach;
    ?>
    <br>
    <form method="post" action="book.php">
        <button>View All Items</button>
    </form>
</section>
<br>
<hr>
<footer>
    <div class="foot">Not ready? You are always welcome to contact us</div>
    <br>
    <div class="foot">Copyright someone</div>
</footer>
</body>
</html>
<?PHP
$thisAuctionQuery->closeCursor();
?>
