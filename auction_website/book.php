<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 9/23/15
 * Time: 6:55 PM
 */
// Connect to database here
require_once('openDatabase.php');
session_start();
if (!$_SESSION['login'])
    header("location: login.php");
$thisAuctionQuery = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.STATUS,
        AUCTION.OPEN_TIME,
        AUCTION.CLOSE_TIME,
        AUCTION.ITEM_CAPTION,
        AUCTION.ITEM_DESCRIPTION,
        AUCTION.AUCTION_ID,
        AUCTION.SELLER,
        AUCTION.CURRENT_PRICE
        FROM AUCTION
        WHERE SELLER <> :seller
SQL
);

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Find in our website</title>
    <link rel="stylesheet" href="stylesheet/style.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Tangerine">
    <link rel="stylesheet" type="text/css" href="stylesheet/bootstrap.min.css"/>
</head>
<body>
<header>
    <div class="head_only">
        <div>
            <h2 class="TangerineFont">Bid here</h2>
        </div>
    </div>
</header>
<nav>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="manage.php">Manage your list</a></li>
        <li><a href="settings.php">Buy it</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="seller.php">Sell Here</a></li>
    </ul>
</nav>
<hr>
<ul class="breadcrumb">
    <li><a href="index.php">Shopping Main Page</a></li>
    <li><a href="settings.php">Find the best one</a></li>
    <li><a href="#">Details</a></li>
</ul>
                <section>
                <div class="col-md-6">
                <h2>items details</h2>
                <table class="table-bordered">
                <thead>
                  <tr>
                     <th>Auction_ID</th>
                     <th>item</th>
                     <th>description</th>
                     <th>Seller</th>
                     <th>Current Price</th>
                     <th>Close time</th>
                  </tr>
               </thead>
<?PHP
$seller = $_SESSION['id'];
$thisAuctionQuery->bindValue(':seller', $seller, PDO::PARAM_INT);
$thisAuctionQuery->execute();
$aids = array();
foreach ($thisAuctionQuery->fetchAll() as $auction):
        $auction_id = $auction['AUCTION_ID'];
        $item = $auction['ITEM_CAPTION'];
        $description = $auction['ITEM_DESCRIPTION'];
        $seller = $auction['SELLER'];
        $status = $auction['CURRENT_PRICE'];
        $close_time = $auction['CLOSE_TIME'];
        $aids[] = $auction['AUCTION_ID'];
        echo "
               <tbody>
                  <tr>
                     <td class=\"center\"> {$auction_id} </td>
                     <td class=\"center\"> {$item} </td>
                     <td class=\"center\"> {$description} </td>
                     <td class=\"center\"> {$seller} </td>
                     <td class=\"center\"> {$status} </td>
                     <td class=\"center\"> {$close_time} </td>
                  </tr>
               </tbody>";
endforeach;

?>
</table>
</div>
</section>
<section>
    <div class="col-md-6">
        <h2>Bid Now</h2>
        <?PHP
        echo"
        <form action=\"complete.php\" method=\"get\">
            <label>Select the item id you want</label>
            <select name=\"totalItem\" required=\"required\" style=\"width: 100\">
                <option value=\"\">[select]</option>";

            //foreach($aids as $i -> $id){
            for($i = 0; $i < count($aids); $i++) {
                echo "<option value=\"{$aids[$i]}\">{$aids[$i]} </option>";

            }
        ?>
            </select>
            <br><br>
            <br><br>
        <?PHP
        if($_SESSION['display'])
        {
            echo "the number is not enough for a new bid";
            $_SESSION['display'] = false;
        }
        ?>
            <p><strong>input your price here</strong>
            <input type='number' name='price' placeholder='price (> current price)'></p>
            <br><br>
            <input type="submit" name="submit" value="submit">
        </form>
    </div>
</section>
<br><br><br><br><br>
<hr>
<footer class="col-xs-4 col-xs-offset-4">
    <br><br><br><br>
    <div class="foot">Not ready? You are always welcome to contact us</div>
    <br>

    <div class="foot">Copyright someone</div>
</footer>
</body>
</html>
<?PHP
$thisAuctionQuery->closeCursor();
?>
