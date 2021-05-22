<?php

$mysqli = new mysqli("localhost","root","","user_maintanance");

// Check connection
if ($mysqli -> connect_errno) {
  exit('Error connecting to database'); //Should be a message a typical user could understand in production
}
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli->set_charset("utf8mb4");



?>