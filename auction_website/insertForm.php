<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/12/15
 * Time: 5:18 PM
 */

session_start();
require_once('openDatabase.php');
$id = $_SESSION['id'];
$newIdQuery = $database->prepare('SELECT NEXT_SEQ_VALUE(:seqGenName);');
$newIdQuery->bindValue(':seqGenName', 'AUCTION', PDO::PARAM_STR);
$newIdQuery->execute();
$newAuctionId = $newIdQuery->fetchColumn(0);
$newIdQuery->closeCursor();
$thisAuctionQuery = $database->prepare(<<<'SQL'
    INSERT INTO
    AUCTION(AUCTION_ID, NUM_BID, status, seller, start_price, current_price, open_time, close_time, item_category, item_caption, item_description, item_photo)
    VALUES(:id, :num_bid, :status, :seller, :start, :current_price, CURRENT_TIMESTAMP, NOW()+INTERVAL 3 DAY, :category, :caption, :description, :photo);
SQL
);
$caption = $_POST['name'];
$description = $_POST['description'];
$num_bid = 0;
$status = 1;
$start = $_POST['price'];
$current_price = $start;
$category = 1;
$image = fopen($_FILES['pic']['tmp_name'], 'rb');
if (!is_numeric($start))
{
    $_SESSION['description'] = true;
    $_SESSION['caption'] = $caption;
    $_SESSION['description'] = $description;
    header("Location: seller.php");
}
else
{
    $thisAuctionQuery->bindValue(':id', $newAuctionId);
    $thisAuctionQuery->bindParam(':num_bid', $num_bid);
    $thisAuctionQuery->bindParam(':photo', $image, PDO::PARAM_LOB);
    $thisAuctionQuery->bindParam(':caption', $caption);
    $thisAuctionQuery->bindParam(':description', $description);
    $thisAuctionQuery->bindParam(':seller', $id);
    $thisAuctionQuery->bindParam(':status', $status);
    $thisAuctionQuery->bindParam(':start', $start);
    $thisAuctionQuery->bindParam(':current_price', $current_price);
    $thisAuctionQuery->bindParam(':category', $category);
    $thisAuctionQuery->execute();
    header("Location: submitted.php");
    $thisAuctionQuery->closeCursor();
}

?>

