<?php
if (!isset($_SESSION))
	session_start();
require_once('./includes/functions.php');
unset($_SESSION);
session_destroy();
session_start();
$_SESSION["login"] = "guest";
header('location: ./index');
?>