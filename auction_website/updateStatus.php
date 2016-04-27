<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/13/15
 * Time: 9:06 AM
 */
error_reporting(-1);
ini_set("display_errors", 1);
require_once('openDatabase.php');
$updateAuctionQuery = $database->prepare(<<<'SQL'
    UPDATE
        AUCTION
        SET NUM_BID = :bid,
        CURRENT_PRICE = :price,
        HIGHEST_BIDDER = :highest
        WHERE AUCTION_ID = :id
SQL
);

$auctionStatus = $database->prepare(<<<'SQL'
    INSERT INTO
    AUCTION_STATUS(AUCTION_STATUS_ID, NAME)
    VALUES(:status, :username)
SQL
);
$auction_id = $_POST['auction_id'];
$bid = $_POST['bid'] + 1;
$price = $_POST['price'];
$highest = $_POST['highest'];
$status = 5;
$updateAuctionQuery->bindValue(':id', $auction_id, PDO::PARAM_INT);
$updateAuctionQuery->bindValue(':bid', $bid, PDO::PARAM_INT);
$updateAuctionQuery->bindValue(':price', $price, PDO::PARAM_INT);
$updateAuctionQuery->bindValue(':highest', $highest, PDO::PARAM_INT);
$updateAuctionQuery->execute();
$auctionStatus->bindValue(':status', $status);
header("Location: submitted.php");
$updateAuctionQuery->closeCursor();
?>