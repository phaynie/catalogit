<?php //login.php

// extract the db name from the original request URL
$requestString = $_SERVER['REQUEST_URI'];  // example = /catalogit/dbname/intropage.php
$startPosition = strpos($requestString, "/", 1) + 1;  // character after second slash
$length = strpos($requestString, "/", $startPosition) - $startPosition; // use position of third slash
$dbname = substr($requestString, $startPosition, $length);

$hn = 'localhost';
$db = $dbname;
$un = 'root';
$pw = 'mysql';
?>
