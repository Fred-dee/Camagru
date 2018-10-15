<?php
	if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
	header('Content-type: text/html');
	if (!isset($_SESSION["login"]))
	{
		$_SESSION["login"] = "guest";
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Index</title>
		<?php require_once('./includes/main-includes.php'); ?>
	</head>
	<body onload="onReady()">
		<?php require_once('./includes/navbar.php'); ?>
		<?php require_once('./includes/footer.php'); ?>
	</body>
</html>