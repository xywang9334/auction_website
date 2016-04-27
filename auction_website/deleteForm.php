<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/12/15
 * Time: 7:42 PM
 */
error_reporting(-1);
ini_set("display_errors", 1);
require_once('openDatabase.php');
$deleteAuctionQuery = $database->prepare(<<<'SQL'
    DELETE
      FROM AUCTION
      WHERE AUCTION.AUCTION_ID = :id;
SQL
);
$auction_id = $_POST['auction_id'];
$deleteAuctionQuery->bindValue(':id', $auction_id, PDO::PARAM_INT);
$deleteAuctionQuery->execute();
header("Location: submitted.php");
$thisAuctionQuery->closeCursor();
?>