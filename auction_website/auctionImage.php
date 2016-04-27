<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/18/15
 * Time: 1:22 PM
 */
require_once('openDatabase.php');
$thisAuctionQuery = $database->prepare(<<<'SQL'
    SELECT
        AUCTION.ITEM_PHOTO
        FROM AUCTION
        WHERE AUCTION.AUCTION_ID =:id;
SQL
);
$id = $_GET['photo'];
$thisAuctionQuery->bindValue(':id', $id);
$thisAuctionQuery->execute();
$photoContents = $thisAuctionQuery->fetch()['ITEM_PHOTO'];
if (strlen($photoContents) == 0) {
    $photoContents = file_get_contents('No_image.jpg');
}
header('Content-Type: image/jpeg');
header('Content-Length: '.strlen($photoContents));

echo $photoContents;

