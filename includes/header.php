<?php
session_start();
if(!$_SESSION['userId']) {
	header('location: ./index.html');
}

require_once 'db_connect.php';
?>
