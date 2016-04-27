<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/17/15
 * Time: 11:25 PM
 */
error_reporting(-1);
ini_set("display_errors", 1);
require_once('openDatabase.php');
$email = $_POST['email'];
$password = $_POST['password'];
$thisAuctionQuery = $database->prepare(<<<'SQL'
    SELECT
    PERSON.PASSWORD,
    PERSON.FORENAME,
    PERSON.PERSON_ID
    FROM
    PERSON
    WHERE PERSON.EMAIL_ADDRESS = :email
SQL
);
session_start();

$_SESSION['login'] = false;
$thisAuctionQuery->bindValue(':email', $email);
$pwd = $thisAuctionQuery->execute();
$redirect = false;
foreach ($thisAuctionQuery->fetchAll() as $result):
    $pwd = $result['PASSWORD'];
    $firstName = $result['FORENAME'];
    $id = $result['PERSON_ID'];
    if (password_verify($password, $pwd))
    {
        $_SESSION['firstName'] = $firstName;
        $_SESSION['login'] = true;
        $_SESSION['id'] = $id;
        $redirect = true;
        header('location: manage.php');
    }
    else
    {
        $redirect = true;
        $_SESSION['display'] = true;
        header('location: login.php');
    }
    break;
endforeach;
if(! $redirect)
    header('location: login.php');

$thisAuctionQuery->closeCursor();
?>