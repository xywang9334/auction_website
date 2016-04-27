<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/28/15
 * Time: 12:17 AM
 */

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
        AUCTION.NUM_BID,
        AUCTION.ITEM_PHOTO
        FROM AUCTION
        WHERE AUCTION.AUCTION_ID = :id;
SQL
);
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Update your item</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h1 class="TangerineFont">Update your item</h1>
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
    <h2>Update your item</h2>
    <?PHP $id = $_POST['auction_id'];?>
    <?PHP
    $thisAuctionQuery->bindValue(':id', $id, PDO::PARAM_INT);
    $thisAuctionQuery->execute();
    foreach ($thisAuctionQuery->fetchAll() as $result):
        $caption = $result['ITEM_CAPTION'];
        $description = $result['ITEM_DESCRIPTION'];
        $price = $result['CURRENT_PRICE'];
        $image = $result['ITEM_PHOTO'];
    endforeach;
    ?>
    <div id="middle">
        <form action="updateForm.php" method="post" enctype="multipart/form-data">
            <?PHP echo"<input type=\"hidden\" value='{$id}' name=\"auction_id\">"; ?>
            <label>Caption: </label><br>
            <?PHP echo"<input class=\"big-input\" name=\"name\" value = \"{$caption}\" placeholder=\"caption\">";?>
            <br>
            <br>
            <label>Description: </label><br>
            <?PHP echo"<input class=\"big-input\" name=\"description\" value=\"{$description}\" placeholder='description'>";?>
            <br>
            <br>
            <label>Price: </label><br>
            <?PHP echo"<input class=\"big-input\" type='number' name=\"price\" value=\"{$price}\" placeholder='price'>";?>
            <br>
            <br>
            <div>Upload an image of your item(optional)</div>
            <input type="file" name="pic" accept="image/*">
            <br><br>
            <input type="submit" value="submit your item">
        </form>
    </div>
</section>
<br><br><br><br><br><br><br>
</body>
</html>
<?PHP
$thisAuctionQuery->closeCursor();
?>

