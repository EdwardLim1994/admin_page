<?php
session_start();

require_once('dbConfig.php');
$stmt = $mysqli->prepare("UPDATE users SET current_session_id = '' WHERE username = ?");
$stmt->bind_param("s", $_SESSION["username"]);

$stmt->execute();
$stmt->close();

mysqli_close($mysqli);

session_destroy();
header("Location: ../../index.php");    
