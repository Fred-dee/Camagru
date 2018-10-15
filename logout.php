<?php
if (!isset($_SESSION))
	session_start();
require_once('./includes/functions.php');
unset($_SESSION);
session_destroy();
session_start();
$_SESSION["login"] = "guest";
//login_error(0, 'This needs to work');
header('location: ./index');
?>