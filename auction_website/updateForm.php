<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/12/15
 * Time: 11:38 PM
 */
error_reporting(-1);
ini_set("display_errors", 1);
require_once('openDatabase.php');
$updateAuctionQuery = $database->prepare(<<<'SQL'
    UPDATE
      AUCTION
      SET ITEM_CAPTION = :caption,
      START_PRICE = :price,
      ITEM_DESCRIPTION =:description,
      ITEM_PHOTO = :photo
      WHERE AUCTION_ID =:id
SQL
);

$updateWithoutImageAuctionQuery = $database->prepare(<<<'SQL'
    UPDATE
      AUCTION
      SET ITEM_CAPTION = :caption,
      START_PRICE = :price,
      ITEM_DESCRIPTION =:description
      WHERE AUCTION_ID =:id
SQL
);
$auction_id = $_POST['auction_id'];
$caption = $_POST['name'];
$description = $_POST['description'];
$price = $_POST['price'];
$image = fopen($_FILES['pic']['tmp_name'], 'rb');
if (strlen($image) == 0) {
  $updateWithoutImageAuctionQuery->bindValue(':id', $auction_id, PDO::PARAM_INT);
  $updateWithoutImageAuctionQuery->bindValue(':description', $description, PDO::PARAM_STR);
  $updateWithoutImageAuctionQuery->bindValue(':price', $price, PDO::PARAM_INT);
  $updateWithoutImageAuctionQuery->bindValue(':caption', $caption, PDO::PARAM_STR);
  $updateWithoutImageAuctionQuery->execute();
}
else {
  $updateAuctionQuery->bindValue(':id', $auction_id, PDO::PARAM_INT);
  $updateAuctionQuery->bindValue(':description', $description, PDO::PARAM_STR);
  $updateAuctionQuery->bindValue(':price', $price, PDO::PARAM_INT);
  $updateAuctionQuery->bindValue(':caption', $caption, PDO::PARAM_STR);
  $updateAuctionQuery->bindValue(':photo', $image, PDO::PARAM_LOB);
  $updateAuctionQuery->execute();
}

header("Location: submitted.php");
$thisAuctionQuery->closeCursor();
?>