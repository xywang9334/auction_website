<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/16/15
 * Time: 6:09 PM
 */

error_reporting(-1);
ini_set("display_errors", 1);
require_once('openDatabase.php');
session_start();
$newIdQuery = $database->prepare('SELECT NEXT_SEQ_VALUE(:seqGenName);');
$newIdQuery->bindValue(':seqGenName', 'PERSON', PDO::PARAM_STR);
$newIdQuery->execute();
$newPersonId = $newIdQuery->fetchColumn(0);
$newIdQuery->closeCursor();

$insertQuery = $database->prepare(<<<'SQL'
    INSERT INTO
    PERSON(PERSON_ID, SURNAME, FORENAME, EMAIL_ADDRESS, PASSWORD)
    VALUES (:id, :surname, :forename, :email, :password);
SQL
);
$surname = $_POST['surname'];
$forename = $_POST['forename'];
$password = $_POST['password'];
$verified = $_POST['verified'];

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$email = $_POST['email'];
if(strcmp($password, $verified) !== 0){
    $_SESSION['surname'] = $surname;
    $_SESSION['forename'] = $forename;
    $_SESSION['display'] = true;
    $_SESSION['email'] = $email;
    header("Location: register.php");
    return;
}

$insertQuery->bindValue(':id', $newPersonId);
$insertQuery->bindValue(':surname', $surname);
$insertQuery->bindValue(':forename', $forename);
$insertQuery->bindParam(':email', $email);
$insertQuery->bindValue(':password', $hashed_password);

$insertQuery->execute();
$_SESSION['login'] = true;
$_SESSION['id'] = $newPersonId;
$_SESSION['firstName'] = $forename;
header('Location: manage.php');
$insertQuery->closeCursor();

?>

