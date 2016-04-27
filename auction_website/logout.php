<?php
/**
 * Created by PhpStorm.
 * User: xywang
 * Date: 10/18/15
 * Time: 8:29 PM
 */

session_start();
$_SESSION = array();
session_regenerate_id(true);
session_unset();

header("location: index.php");
?>